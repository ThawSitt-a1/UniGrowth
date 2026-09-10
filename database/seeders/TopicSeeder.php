<?php

namespace Database\Seeders;

use App\Assessment\Models\Option;
use App\Assessment\Models\Question;
use App\Core\Assets\Models\Skill;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            [
                'title' => 'HTML',
                'slug' => 'html',
                'tags' => ['html', 'frontend', 'web'],
                'description' => 'Learn HTML5 markup, semantic elements, forms, and accessibility fundamentals.',
                'content' => "## Step 1: HTML Fundamentals\nLearn the basic structure of an HTML document and essential tags.\n- [MDN HTML Guide](https://developer.mozilla.org/en-US/docs/Web/HTML)\n\n## Step 2: Semantic Markup\nUse proper semantic elements for better SEO and accessibility.\n- [HTML5 Semantic Elements](https://developer.mozilla.org/en-US/docs/Glossary/Semantics)\n\n## Step 3: Forms and Validation\nCreate accessible forms with proper input types and validation.",
                'project_suggestion' => 'Build a responsive personal portfolio page using semantic HTML5 elements.',
            ],
            [
                'title' => 'CSS',
                'slug' => 'css',
                'tags' => ['css', 'frontend', 'web', 'styling'],
                'description' => 'Master CSS3 including selectors, flexbox, grid, animations, and responsive design.',
                'content' => "## Step 1: CSS Selectors and Specificity\nUnderstand how CSS selectors work and how specificity affects styling.\n\n## Step 2: Box Model and Layout\nMaster the CSS box model, flexbox, and grid for modern layouts.\n\n## Step 3: Responsive Design\nUse media queries and relative units to build responsive websites.",
                'project_suggestion' => 'Create a responsive landing page that works on mobile, tablet, and desktop.',
            ],
            [
                'title' => 'PHP Laravel',
                'slug' => 'php-laravel',
                'tags' => ['php', 'laravel', 'backend', 'web'],
                'description' => 'Build robust web applications with the Laravel PHP framework using MVC, Eloquent ORM, and Blade templates.',
                'content' => "## Step 1: Laravel MVC Architecture\nLearn the Model-View-Controller pattern and routing in Laravel.\n\n## Step 2: Eloquent ORM\nDatabase operations using Laravel\'s elegant ActiveRecord implementation.\n\n## Step 3: Middleware and Authentication\nSecure your application with middleware and Laravel\'s built-in auth system.",
                'project_suggestion' => 'Build a task management application with user authentication, CRUD operations, and a REST API.',
            ],
            [
                'title' => 'Computer Basic',
                'slug' => 'computer-basic',
                'tags' => ['computer', 'fundamental', 'basics'],
                'description' => 'Fundamental computer concepts: hardware, software, operating systems, and digital literacy.',
                'content' => "## Step 1: Computer Hardware\nUnderstand CPU, memory, storage devices, and input/output peripherals.\n\n## Step 2: Operating Systems\nBasics of Windows, macOS, and Linux: file management and system settings.\n\n## Step 3: Internet and Networking\nHow the internet works, browsers, email, and online safety.",
                'project_suggestion' => 'Set up a personal computer with an operating system and organize files and folders effectively.',
            ],
        ];

        $questions = [
            'HTML' => [
                ['q' => 'Which HTML element defines the most important heading?', 'opts' => ['<h1>', '<header>', '<title>', '<h6>'], 'correct' => 0, 'difficulty' => 'easy'],
                ['q' => 'Which HTML tag is used for the largest heading?', 'opts' => ['<h1>', '<h6>', '<head>', '<header>'], 'correct' => 0, 'difficulty' => 'easy'],
                ['q' => 'What does the HTML <meta charset="UTF-8"> tag specify?', 'opts' => ['Page style', 'Character encoding', 'Scripts to load', 'Viewport settings'], 'correct' => 1, 'difficulty' => 'medium'],
                ['q' => 'Which HTML element is used for navigation links?', 'opts' => ['<nav>', '<navigation>', '<menu>', '<link>'], 'correct' => 0, 'difficulty' => 'medium'],
                ['q' => 'Which HTML5 element defines a footer for a document?', 'opts' => ['<footer>', '<bottom>', '<section>', '<aside>'], 'correct' => 0, 'difficulty' => 'hard'],
            ],
            'CSS' => [
                ['q' => 'Which CSS property controls text size?', 'opts' => ['font-size', 'text-size', 'font-style', 'text-style'], 'correct' => 0, 'difficulty' => 'easy'],
                ['q' => 'Which CSS selector has the highest specificity?', 'opts' => ['#id', '.class', 'element', '*'], 'correct' => 0, 'difficulty' => 'easy'],
                ['q' => 'Which CSS property makes a container flexible?', 'opts' => ['display: flex', 'flex: 1', 'position: flex', 'float'], 'correct' => 0, 'difficulty' => 'medium'],
                ['q' => 'Which CSS unit is relative to the root element font size?', 'opts' => ['em', 'rem', 'px', '%'], 'correct' => 1, 'difficulty' => 'medium'],
                ['q' => 'Which media query targets screens smaller than 768px?', 'opts' => ['@media (max-width: 768px)', '@media (min-width: 768px)', '@media screen and (max: 768px)', '@media (width: 768px)'], 'correct' => 0, 'difficulty' => 'hard'],
            ],
            'PHP Laravel' => [
                ['q' => 'Which artisan command creates a new controller?', 'opts' => ['php artisan make:controller', 'php artisan create:controller', 'php artisan generate:controller', 'php artisan new:controller'], 'correct' => 0, 'difficulty' => 'easy'],
                ['q' => 'In Laravel Eloquent, which method retrieves all records?', 'opts' => ['->get()', '->all()', '->find()', '->first()'], 'correct' => 0, 'difficulty' => 'easy'],
                ['q' => 'Which middleware protects routes from unauthenticated users?', 'opts' => ['guest', 'auth', 'verified', 'signed'], 'correct' => 1, 'difficulty' => 'medium'],
                ['q' => 'In Laravel, where are database migrations stored?', 'opts' => ['routes/', 'database/migrations/', 'app/Models/', 'config/'], 'correct' => 1, 'difficulty' => 'medium'],
                ['q' => 'Which Blade directive escapes output to prevent XSS?', 'opts' => ['{{ }}', '{!! !!}', '@raw', '@html'], 'correct' => 0, 'difficulty' => 'hard'],
            ],
            'Computer Basic' => [
                ['q' => 'What does CPU stand for?', 'opts' => ['Central Processing Unit', 'Computer Personal Unit', 'Core Processing Unit', 'Control Processing Unit'], 'correct' => 0, 'difficulty' => 'easy'],
                ['q' => 'Which of these is an operating system?', 'opts' => ['Windows', 'Chrome', 'Photoshop', 'Zoom'], 'correct' => 0, 'difficulty' => 'easy'],
                ['q' => 'What does HTTP stand for in web addresses?', 'opts' => ['Hyper Text Transfer Protocol', 'High Transfer Text Protocol', 'Hyperlink Transfer Text Protocol', 'Hyperlink Transmission Process'], 'correct' => 0, 'difficulty' => 'medium'],
                ['q' => 'Which storage device uses magnetic storage?', 'opts' => ['SSD', 'HDD', 'USB', 'RAM'], 'correct' => 1, 'difficulty' => 'medium'],
                ['q' => 'What is the primary function of RAM?', 'opts' => ['Long-term storage', 'Temporary working memory', 'Permanent file storage', 'Graphics rendering'], 'correct' => 1, 'difficulty' => 'hard'],
            ],
        ];

        foreach ($skills as $skillData) {
            $skill = Skill::firstOrCreate(
                ['title' => $skillData['title']],
                [
                    'slug' => $skillData['slug'],
                    'tags' => $skillData['tags'],
                    'description' => $skillData['description'],
                    'content' => $skillData['content'],
                    'resource_link' => null,
                    'resource_links' => null,
                    'project_suggestion' => $skillData['project_suggestion'] ?? '',
                    'is_active' => true,
                    'locked_by_admin' => false,
                ]
            );

            $skillQuestions = $questions[$skillData['title']] ?? [];

            foreach ($skillQuestions as $idx => $q) {
                $question = Question::firstOrCreate(
                    [
                        'skill_id' => $skill->id,
                        'question_text' => $q['q'],
                    ],
                    [
                        'difficulty' => $q['difficulty'],
                        'marks' => 10.0,
                        'is_active' => true,
                        'locked_by_admin' => false,
                    ]
                );

                foreach ($q['opts'] as $optIdx => $optText) {
                    Option::firstOrCreate(
                        [
                            'question_id' => $question->id,
                            'option_text' => $optText,
                        ],
                        [
                            'is_correct' => $optIdx === $q['correct'],
                            'locked_by_admin' => false,
                        ]
                    );
                }
            }
        }

        $this->command->info('Seeded 4 topics: HTML, CSS, PHP Laravel, Computer Basic.');
    }
}
