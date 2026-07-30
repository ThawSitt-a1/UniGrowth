<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Recommendation;

use App\Core\Assets\Models\Skill;
use App\Core\Recommendation\Services\TagIntersectionSimilarityService;
use Illuminate\Support\Collection;
use Tests\TestCase;

final class TagIntersectionSimilarityServiceTest extends TestCase
{
    private TagIntersectionSimilarityService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new TagIntersectionSimilarityService();
    }

    /** @test */
    public function it_returns_empty_array_when_no_candidates(): void
    {
        $result = $this->service->rank(['php'], new Collection(), 5);

        $this->assertEmpty($result);
    }

    /** @test */
    public function it_returns_cold_start_fallback_when_user_has_no_tags(): void
    {
        $skill1 = new Skill(['id' => 1, 'title' => 'Skill A', 'tags' => ['tag1'], 'description' => 'Desc', 'content' => 'C']);
        $skill2 = new Skill(['id' => 2, 'title' => 'Skill B', 'tags' => ['tag2'], 'description' => 'Desc', 'content' => 'C']);

        $candidates = new Collection([$skill1, $skill2]);

        $result = $this->service->rank([], $candidates, 5);

        $this->assertCount(2, $result);

        foreach ($result as $item) {
            $this->assertEquals(0, $item['score']);
            $this->assertEquals(0, $item['matching_tags_count']);
            $this->assertEmpty($item['matching_tags']);
        }
    }

    /** @test */
    public function it_ranks_skills_by_tag_overlap_using_jaccard_score(): void
    {
        $userTags = ['php', 'laravel', 'backend'];

        $highMatch = new Skill(['id' => 1, 'title' => 'Laravel Advanced', 'tags' => ['php', 'laravel', 'testing', 'eloquent'], 'description' => 'Desc', 'content' => 'C']);
        $mediumMatch = new Skill(['id' => 2, 'title' => 'PHP Basics', 'tags' => ['php', 'syntax'], 'description' => 'Desc', 'content' => 'C']);
        $noMatch = new Skill(['id' => 3, 'title' => 'Vue.js', 'tags' => ['javascript', 'frontend'], 'description' => 'Desc', 'content' => 'C']);

        $candidates = new Collection([$highMatch, $mediumMatch, $noMatch]);

        $result = $this->service->rank($userTags, $candidates, 5);

        $this->assertCount(2, $result); // Only 2 have matches

        // highMatch should be first (higher score)
        $this->assertEquals('Laravel Advanced', $result[0]['skill']->title);
        $this->assertEquals('PHP Basics', $result[1]['skill']->title);

        // Verify scores: highMatch has 2/5 = 0.4, mediumMatch has 1/4 = 0.25
        $this->assertEqualsWithDelta(0.4, $result[0]['score'], 0.001);
        $this->assertEqualsWithDelta(0.25, $result[1]['score'], 0.001);
    }

    /** @test */
    public function it_respects_the_limit_parameter(): void
    {
        $userTags = ['php'];

        $skills = [];
        for ($i = 0; $i < 10; $i++) {
            $skills[] = new Skill(['id' => $i, 'title' => "Skill {$i}", 'tags' => ['php'], 'description' => 'Desc', 'content' => 'C']);
        }

        $candidates = new Collection($skills);

        $result = $this->service->rank($userTags, $candidates, 3);

        $this->assertCount(3, $result);
    }

    /** @test */
    public function it_handles_case_insensitive_tag_matching(): void
    {
        $userTags = ['PHP', 'LARAVEL'];

        $skill = new Skill(['id' => 1, 'title' => 'Laravel', 'tags' => ['php', 'laravel'], 'description' => 'Desc', 'content' => 'C']);

        $candidates = new Collection([$skill]);

        $result = $this->service->rank($userTags, $candidates, 5);

        $this->assertCount(1, $result);
        $this->assertEquals(2, $result[0]['matching_tags_count']);
    }
}
