<?php

declare(strict_types=1);

namespace Tests\Unit\Editor;

use App\Admin\Services\SystemSettingsServiceInterface;
use App\Editor\DTOs\QuestionDataDTO;
use App\Editor\DTOs\SkillDataDTO;
use App\Editor\Repositories\QuestionRepositoryInterface;
use App\Editor\Repositories\SkillRepositoryInterface;
use App\Editor\UseCases\ManageQuestionUseCase;
use App\Editor\UseCases\ManageSkillUseCase;
use Mockery;
use Tests\TestCase;

final class ContentApprovalUseCaseTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_suspends_new_skill_when_content_approval_is_required(): void
    {
        $skillRepo = Mockery::mock(SkillRepositoryInterface::class);
        $settings = Mockery::mock(SystemSettingsServiceInterface::class);
        $settings->shouldReceive('isContentApprovalRequired')->once()->andReturn(true);

        $skillRepo->shouldReceive('save')
            ->once()
            ->with(Mockery::on(function (SkillDataDTO $dto) {
                return $dto->skillId === null && $dto->isActive === false;
            }))
            ->andReturn(true);

        $useCase = new ManageSkillUseCase($skillRepo, $settings);

        $dto = new SkillDataDTO(
            skillId: null,
            editorId: 1,
            title: 'Test Skill',
            slug: 'test-skill',
            description: 'Description',
        );

        $useCase->execute($dto);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function it_publishes_new_skill_when_content_approval_is_not_required(): void
    {
        $skillRepo = Mockery::mock(SkillRepositoryInterface::class);
        $settings = Mockery::mock(SystemSettingsServiceInterface::class);
        $settings->shouldReceive('isContentApprovalRequired')->once()->andReturn(false);

        $skillRepo->shouldReceive('save')
            ->once()
            ->with(Mockery::on(function (SkillDataDTO $dto) {
                return $dto->skillId === null && $dto->isActive === true;
            }))
            ->andReturn(true);

        $useCase = new ManageSkillUseCase($skillRepo, $settings);

        $dto = new SkillDataDTO(
            skillId: null,
            editorId: 1,
            title: 'Test Skill',
            slug: 'test-skill',
            description: 'Description',
        );

        $useCase->execute($dto);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function it_preserves_active_state_when_editing_existing_skill(): void
    {
        $skillRepo = Mockery::mock(SkillRepositoryInterface::class);
        $settings = Mockery::mock(SystemSettingsServiceInterface::class);

        $skillRepo->shouldReceive('isLockedByAdmin')->once()->andReturn(false);
        $skillRepo->shouldReceive('verifyOwnership')->once()->andReturn(true);
        $skillRepo->shouldReceive('save')
            ->once()
            ->with(Mockery::on(function (SkillDataDTO $dto) {
                return $dto->skillId === 5 && $dto->isActive === true;
            }))
            ->andReturn(true);

        $useCase = new ManageSkillUseCase($skillRepo, $settings);

        $dto = new SkillDataDTO(
            skillId: 5,
            editorId: 1,
            title: 'Updated Skill',
            slug: 'updated-skill',
            description: 'Description',
            isActive: true,
        );

        $useCase->execute($dto);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function it_publishes_new_question_even_when_content_approval_is_required(): void
    {
        $questionRepo = Mockery::mock(QuestionRepositoryInterface::class);
        $skillRepo = Mockery::mock(SkillRepositoryInterface::class);

        $skillRepo->shouldReceive('verifyOwnership')->once()->andReturn(true);
        $skillRepo->shouldReceive('isSuspended')->once()->andReturn(false);

        $questionRepo->shouldReceive('save')
            ->once()
            ->with(Mockery::on(function (QuestionDataDTO $dto) {
                return $dto->questionId === null && $dto->isActive === true;
            }))
            ->andReturn(true);

        $useCase = new ManageQuestionUseCase($questionRepo, $skillRepo);

        $dto = new QuestionDataDTO(
            questionId: null,
            editorId: 1,
            skillId: 2,
            questionText: 'Test question?',
            difficulty: 'easy',
        );

        $useCase->execute($dto);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function it_already_publishes_new_question_when_content_approval_is_not_required(): void
    {
        $questionRepo = Mockery::mock(QuestionRepositoryInterface::class);
        $skillRepo = Mockery::mock(SkillRepositoryInterface::class);

        $skillRepo->shouldReceive('verifyOwnership')->once()->andReturn(true);
        $skillRepo->shouldReceive('isSuspended')->once()->andReturn(false);

        $questionRepo->shouldReceive('save')
            ->once()
            ->with(Mockery::on(function (QuestionDataDTO $dto) {
                return $dto->questionId === null && $dto->isActive === true;
            }))
            ->andReturn(true);

        $useCase = new ManageQuestionUseCase($questionRepo, $skillRepo);

        $dto = new QuestionDataDTO(
            questionId: null,
            editorId: 1,
            skillId: 2,
            questionText: 'Test question?',
            difficulty: 'easy',
        );

        $useCase->execute($dto);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function it_blocks_new_question_for_a_suspended_skill(): void
    {
        $questionRepo = Mockery::mock(QuestionRepositoryInterface::class);
        $skillRepo = Mockery::mock(SkillRepositoryInterface::class);

        $skillRepo->shouldReceive('verifyOwnership')->once()->andReturn(true);
        $skillRepo->shouldReceive('isSuspended')->once()->andReturn(true);

        $questionRepo->shouldNotReceive('save');

        $useCase = new ManageQuestionUseCase($questionRepo, $skillRepo);

        $dto = new QuestionDataDTO(
            questionId: null,
            editorId: 1,
            skillId: 2,
            questionText: 'Test question?',
            difficulty: 'easy',
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('You cannot add or edit questions for a suspended skill.');

        $useCase->execute($dto);
    }

    /** @test */
    public function it_preserves_active_state_when_editing_existing_question(): void
    {
        $questionRepo = Mockery::mock(QuestionRepositoryInterface::class);
        $skillRepo = Mockery::mock(SkillRepositoryInterface::class);

        $skillRepo->shouldReceive('verifyOwnership')->once()->andReturn(true);
        $skillRepo->shouldReceive('isSuspended')->once()->andReturn(false);
        $questionRepo->shouldReceive('isLockedByAdmin')->once()->andReturn(false);
        $questionRepo->shouldReceive('verifyOwnership')->once()->andReturn(true);

        $questionRepo->shouldReceive('save')
            ->once()
            ->with(Mockery::on(function (QuestionDataDTO $dto) {
                return $dto->questionId === 3 && $dto->isActive === true;
            }))
            ->andReturn(true);

        $useCase = new ManageQuestionUseCase($questionRepo, $skillRepo);

        $dto = new QuestionDataDTO(
            questionId: 3,
            editorId: 1,
            skillId: 2,
            questionText: 'Updated question?',
            difficulty: 'easy',
            isActive: true,
        );

        $useCase->execute($dto);
        $this->addToAssertionCount(1);
    }
}
