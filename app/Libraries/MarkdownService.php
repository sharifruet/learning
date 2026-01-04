<?php

namespace App\Libraries;

use Parsedown;

/**
 * MarkdownService
 * 
 * Service for parsing Markdown content to HTML
 */
class MarkdownService
{
    protected $parsedown;

    public function __construct()
    {
        $this->parsedown = new Parsedown();
        // Enable safe mode to prevent XSS attacks
        $this->parsedown->setSafeMode(true);
        // Enable line breaks
        $this->parsedown->setBreaksEnabled(true);
    }

    /**
     * Parse Markdown content to HTML
     * 
     * @param string $markdown Markdown content
     * @return string HTML content
     */
    public function parse(string $markdown): string
    {
        if (empty($markdown)) {
            return '';
        }

        return $this->parsedown->text($markdown);
    }

    /**
     * Parse inline Markdown (for single lines)
     * 
     * @param string $markdown Markdown content
     * @return string HTML content
     */
    public function parseInline(string $markdown): string
    {
        if (empty($markdown)) {
            return '';
        }

        return $this->parsedown->line($markdown);
    }
}

