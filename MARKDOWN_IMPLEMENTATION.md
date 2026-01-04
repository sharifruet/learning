# Markdown Support Implementation

## Overview

This implementation provides a hybrid approach for lesson content storage:
- **Database Storage**: All lesson content is stored in the database
- **Markdown Support**: Content can be stored as Markdown and automatically converted to HTML
- **Backward Compatible**: Existing HTML content continues to work

## Installation

1. Install the Parsedown library:
   ```bash
   composer require erusev/parsedown
   ```

2. Run composer update:
   ```bash
   composer update
   ```

## Usage

### Setting Content Type

When creating/editing a lesson, set the `content_type` field:
- `'html'` - Content is stored as HTML (default, backward compatible)
- `'markdown'` - Content is stored as Markdown and will be parsed to HTML

### Database Schema

The `lessons` table already has a `content_type` field:
- `content_type` VARCHAR - Can be 'html' or 'markdown'
- `content` TEXT/LONGTEXT - Stores the raw content (HTML or Markdown)

### In Code

#### Using the Service

```php
use Config\Services;

$markdownService = Services::markdown();
$html = $markdownService->parse($markdownContent);
```

#### Using the Helper

```php
helper('markdown');
$html = parse_markdown($markdownContent);
```

### In Views

The lesson view automatically handles Markdown parsing:
- If `content_type` is 'markdown', content is parsed to HTML
- If `content_type` is 'html', content is used as-is
- The parsed/raw content is available as `$lesson['content_html']`

## Features

- **Safe Mode**: XSS protection enabled by default
- **Line Breaks**: Automatic line break conversion
- **Code Blocks**: Syntax highlighting support (requires Prism.js or similar)
- **Backward Compatible**: Existing HTML content works without changes

## Example Markdown Content

```markdown
# Lesson Title

This is a paragraph with **bold** and *italic* text.

## Code Example

Here's a Python code example:

```python
def hello_world():
    print("Hello, World!")
```

## Lists

- Item 1
- Item 2
- Item 3

1. First item
2. Second item
3. Third item
```

## Migration Notes

- Existing lessons with HTML content will continue to work
- To convert existing HTML to Markdown, update the `content_type` field to 'markdown' and convert the content
- New lessons can be created with either HTML or Markdown

