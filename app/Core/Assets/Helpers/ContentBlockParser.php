<?php

declare(strict_types=1);

namespace App\Core\Assets\Helpers;

final class ContentBlockParser
{
    /**
     * Parse raw content string into structured blocks.
     *
     * Supported block types:
     * - ## Heading 2
     * - ### Heading 3
     * - > info: message
     * - > warning: message
     * - ```language\ncode\n```
     * - ![alt](url)
     * - @[video](url)
     * - Regular paragraphs
     */
    public static function parse(string $content): array
    {
        $blocks = [];
        $lines = explode("\n", $content);
        $i = 0;
        $total = count($lines);
        $iterations = 0;
        $maxIterations = max($total * 10, 100000);

        while ($i < $total) {
            $iterations++;
            if ($iterations > $maxIterations) {
                break;
            }

            $line = $lines[$i];

            // Skip empty lines
            if (trim($line) === '') {
                $i++;

                continue;
            }

            // Skip learning-step blocks entirely - they are rendered only in the
            // dedicated "Learning Steps" section, not in the reading text content.
            if (preg_match('/^(?:#+\s*)?Step(?:\s+\d+)?[:\-]/i', trim($line))) {
                $i++;
                while ($i < $total) {
                    $cur = trim($lines[$i]);
                    // Stop at the next step header or a top-level heading (a new content section)
                    if (preg_match('/^(?:#+\s*)?Step(?:\s+\d+)?[:\-]/i', $cur) || preg_match('/^#{1,6}\s+/', $cur)) {
                        break;
                    }
                    $i++;
                }

                continue;
            }

            // Heading 2
            if (preg_match('/^##\s+(.+)$/', $line, $matches)) {
                $blocks[] = [
                    'type' => 'h2',
                    'content' => trim($matches[1]),
                    'id' => self::slugify(trim($matches[1])),
                ];
                $i++;

                continue;
            }

            // Heading 3
            if (preg_match('/^###\s+(.+)$/', $line, $matches)) {
                $blocks[] = [
                    'type' => 'h3',
                    'content' => trim($matches[1]),
                    'id' => self::slugify(trim($matches[1])),
                ];
                $i++;

                continue;
            }

            // Callout (info or warning)
            if (preg_match('/^>\s*(info|warning):\s*(.+)$/', $line, $matches)) {
                $calloutType = $matches[1];
                $calloutText = $matches[2];
                $i++;

                // Collect continuation lines (lines starting with >)
                while ($i < $total && preg_match('/^>\s*(.*)$/', $lines[$i], $contMatches)) {
                    $calloutText .= ' '.trim($contMatches[1]);
                    $i++;
                }

                $blocks[] = [
                    'type' => 'callout',
                    'calloutType' => $calloutType,
                    'content' => trim($calloutText),
                ];

                continue;
            }

            // Code block
            if (preg_match('/^```(\w+)?$/', $line, $matches)) {
                $language = $matches[1] ?? 'plaintext';
                $codeLines = [];
                $i++;

                while ($i < $total && $lines[$i] !== '```') {
                    $codeLines[] = $lines[$i];
                    $i++;
                }

                $blocks[] = [
                    'type' => 'code',
                    'language' => $language,
                    'content' => implode("\n", $codeLines),
                ];
                $i++;

                continue;
            }

            // Image embed
            if (preg_match('/^!\[([^\]]*)\]\(([^)]+)\)$/', $line, $matches)) {
                $blocks[] = [
                    'type' => 'image',
                    'alt' => $matches[1] ?? '',
                    'url' => $matches[2],
                ];
                $i++;

                continue;
            }

            // Video embed
            if (preg_match('/^@\[video\]\(([^)]+)\)$/', $line, $matches)) {
                $blocks[] = [
                    'type' => 'video',
                    'url' => $matches[1],
                ];
                $i++;

                continue;
            }

            // Paragraph (collect consecutive non-special lines)
            $paragraphLines = [];
            while ($i < $total && trim($lines[$i]) !== '' &&
                   ! preg_match('/^(##|###|```)/', $lines[$i])) {
                $paragraphLines[] = $lines[$i];
                $i++;
            }

            if (! empty($paragraphLines)) {
                $blocks[] = [
                    'type' => 'paragraph',
                    'content' => implode("\n", $paragraphLines),
                ];
            }
        }

        return $blocks;
    }

    /**
     * Render parsed content blocks directly to HTML.
     */
    public static function renderToHtml(string $content): string
    {
        $blocks = self::parse($content);
        $html = '';

        foreach ($blocks as $block) {
            switch ($block['type']) {
                case 'h2':
                    $html .= '<h2 id="' . htmlspecialchars($block['id'], ENT_QUOTES) . '">' . htmlspecialchars($block['content'], ENT_QUOTES) . '<a href="#' . htmlspecialchars($block['id'], ENT_QUOTES) . '" class="section-anchor"><i class="bi bi-link"></i></a></h2>';
                    break;
                case 'h3':
                    $html .= '<h3 id="' . htmlspecialchars($block['id'], ENT_QUOTES) . '">' . htmlspecialchars($block['content'], ENT_QUOTES) . '<a href="#' . htmlspecialchars($block['id'], ENT_QUOTES) . '" class="section-anchor"><i class="bi bi-link"></i></a></h3>';
                    break;
                case 'paragraph':
                    $html .= '<p>' . nl2br(htmlspecialchars($block['content'], ENT_QUOTES)) . '</p>';
                    break;
                case 'code':
                    $lang = htmlspecialchars($block['language'] ?? 'plaintext', ENT_QUOTES);
                    $code = htmlspecialchars($block['content'], ENT_QUOTES);
                    $html .= '<pre><code class="language-' . $lang . '">' . $code . '</code></pre>';
                    break;
                case 'callout':
                    $type = htmlspecialchars($block['calloutType'], ENT_QUOTES);
                    $content = htmlspecialchars($block['content'], ENT_QUOTES);
                    $icon = $type === 'info'
                        ? '<i class="bi bi-info-circle-fill"></i> Info'
                        : '<i class="bi bi-exclamation-triangle-fill"></i> Warning';
                    $html .= '<div class="callout ' . $type . '"><div class="callout-title">' . $icon . '</div><p class="mb-0">' . $content . '</p></div>';
                    break;
                case 'image':
                    $html .= '<img src="' . htmlspecialchars($block['url'], ENT_QUOTES) . '" alt="' . htmlspecialchars($block['alt'], ENT_QUOTES) . '" class="img-fluid">';
                    break;
                case 'video':
                    $html .= '<div class="ratio ratio-16by9"><iframe src="' . htmlspecialchars($block['url'], ENT_QUOTES) . '" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe></div>';
                    break;
            }
        }

        return $html;
    }

    /**
     * Render learning steps to HTML.
     */
    public static function renderStepsToHtml(string $content): string
    {
        $steps = self::parseSteps($content);

        if (empty($steps)) {
            return '';
        }

        $html = '<hr class="section-divider"><div id="steps"><div class="d-flex align-items-center gap-2 mb-3"><i class="bi bi-list-steps fs-4" style="color: #6366f1;"></i><h5 class="fw-bold mb-0" style="color: #0f172a;">Learning Steps</h5></div><div class="d-flex flex-column gap-3">';

        foreach ($steps as $index => $step) {
            $html .= '<div class="card border-0 step-card"><div class="card-body"><div class="d-flex align-items-start gap-3"><span class="step-number">' . ($index + 1) . '</span><div class="flex-grow-1">';
            $html .= '<h6 class="card-title mb-2">' . htmlspecialchars($step['title'], ENT_QUOTES) . '</h6>';

            if (!empty($step['description'])) {
                $html .= '<p class="card-text mb-2">' . nl2br(htmlspecialchars($step['description'], ENT_QUOTES)) . '</p>';
            }

            if (!empty($step['resources'])) {
                $html .= '<div class="step-resources mt-2">';
                foreach ($step['resources'] as $res) {
                    $html .= '<div class="mb-1"><a href="' . htmlspecialchars($res['url'], ENT_QUOTES) . '" target="_blank" rel="noopener noreferrer" class="text-decoration-none" style="color: #6366f1; font-family: \'SF Mono\', Monaco, monospace; font-size: 0.85rem; word-break: break-all;"><i class="bi bi-link-45deg me-1"></i>' . htmlspecialchars($res['url'], ENT_QUOTES) . '</a></div>';
                }
                $html .= '</div>';
            }

            $html .= '</div></div></div></div>';
        }

        $html .= '</div></div>';

        return $html;
    }

    /**
     * Extract headings for TOC generation.
     */
    public static function extractHeadings(string $content): array
    {
        $headings = [];
        $blocks = self::parse($content);

        foreach ($blocks as $block) {
            if (in_array($block['type'], ['h2', 'h3'])) {
                $headings[] = [
                    'type' => $block['type'],
                    'content' => $block['content'],
                    'id' => $block['id'],
                ];
            }
        }

        return $headings;
    }

    /**
     * Parse structured learning steps from raw content.
     *
     * Convention (markdown-ish, authored inside the skill `content` field):
     *
     *     ## Step 1: Understand the Basics
     *     A paragraph describing what to do in this step.
     *     - [Official Docs](https://example.com/docs)   <- step resource link
     *     - [Tutorial](https://example.com/tutorial)    <- step resource link
     *
     *     ## Step 2: Build Something
     *     Another paragraph describing the next step.
     *
     * Steps are auto-numbered in order. Each step may optionally include
     * `- [label](url)` resource links that are rendered beneath the step
     * description (StepResourcesList).
     *
     * @return array<int, array{title: string, description: string, resources: array<int, array{label: string, url: string}>}>
     */
    public static function parseSteps(string $content): array
    {
        $steps = [];
        $lines = explode("\n", $content);
        $total = count($lines);
        $i = 0;
        $iterations = 0;
        $maxIterations = max($total * 10, 100000);

        while ($i < $total) {
            $iterations++;
            if ($iterations > $maxIterations) {
                break;
            }

            $line = $lines[$i];

            // Detect a step header: "## Step 1: ...", "Step 3: ...", "Step: ...", "## Step 2 - ..."
            if (preg_match('/^(?:#+\s*)?Step(?:\s+\d+)?[:\-]\s*(.*)$/i', trim($line), $matches)) {
                $title = trim($matches[1]);
                $i++;

                $descriptionLines = [];
                $resources = [];

                // Collect description lines and step resource links until the next step header
                while ($i < $total) {
                    $current = trim($lines[$i]);

                    // Stop at the next step header
                    if (preg_match('/^(?:#+\s*)?Step(?:\s+\d+)?[:\-]/i', $current)) {
                        break;
                    }

                    // Stop at a top-level heading (new section outside steps)
                    if (preg_match('/^#{1,6}\s+/', $current)) {
                        break;
                    }

                    // Step resource link formats:
                    //   [label](url)
                    //   - [label](url)
                    //   https://example.com  (bare URL)
                    if (preg_match('/^[-*]?\s*\[([^\]]*)\]\(([^)]+)\)$/', $current, $linkMatches)) {
                        $resources[] = [
                            'label' => trim($linkMatches[1]) ?: $linkMatches[2],
                            'url' => trim($linkMatches[2]),
                        ];
                        $i++;

                        continue;
                    }

                    if (preg_match('/^https?:\/\/\S+$/i', $current)) {
                        $resources[] = [
                            'label' => $current,
                            'url' => $current,
                        ];
                        $i++;

                        continue;
                    }

                    if ($current !== '') {
                        $descriptionLines[] = $current;
                    }
                    $i++;
                }

                $steps[] = [
                    'title' => $title,
                    'description' => implode("\n", $descriptionLines),
                    'resources' => $resources,
                ];

                continue;
            }

            $i++;
        }

        return $steps;
    }

    /**
     * Convert text to URL-friendly slug.
     */
    private static function slugify(string $text): string
    {
        $text = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $text);
        $text = trim($text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        $text = strtolower($text);

        return $text ?: 'section';
    }
}
