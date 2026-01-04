<?php

/**
 * Markdown Helper
 * 
 * Helper functions for Markdown parsing
 */

if (!function_exists('parse_markdown')) {
    /**
     * Parse Markdown content to HTML
     * 
     * @param string $markdown Markdown content
     * @return string HTML content
     */
    function parse_markdown(string $markdown): string
    {
        $markdownService = service('markdown');
        return $markdownService->parse($markdown);
    }
}

if (!function_exists('is_markdown')) {
    /**
     * Check if content is Markdown format
     * Simple heuristic: checks for common Markdown patterns
     * 
     * @param string $content Content to check
     * @return bool True if content appears to be Markdown
     */
    function is_markdown(string $content): bool
    {
        if (empty($content)) {
            return false;
        }

        // Check for common Markdown patterns
        $markdownPatterns = [
            '/^#{1,6}\s+/m',           // Headers (# Header)
            '/^\*\s+/m',               // Unordered lists (* item)
            '/^\d+\.\s+/m',            // Ordered lists (1. item)
            '/\*\*.*?\*\*/',           // Bold (**text**)
            '/\*.*?\*/',               // Italic (*text*)
            '/\[.*?\]\(.*?\)/',        // Links [text](url)
            '/^```/m',                 // Code blocks (```code```)
            '/^>\s+/m',                // Blockquotes (> quote)
            '/^\|.*\|/m',              // Tables (| col |)
            '/^-{3,}$/m',              // Horizontal rules (---)
        ];

        foreach ($markdownPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return true;
            }
        }

        return false;
    }
}

