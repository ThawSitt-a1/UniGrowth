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

        while ($i < $total) {
            $line = $lines[$i];

            // Skip empty lines
            if (trim($line) === '') {
                $i++;
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
                    $calloutText .= ' ' . trim($contMatches[1]);
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
                   !preg_match('/^(##|###|>|```|!\[@)/', $lines[$i])) {
                $paragraphLines[] = $lines[$i];
                $i++;
            }

            if (!empty($paragraphLines)) {
                $blocks[] = [
                    'type' => 'paragraph',
                    'content' => implode("\n", $paragraphLines),
                ];
            }
        }

        return $blocks;
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
