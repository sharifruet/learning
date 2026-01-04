# Project 1.1: Building a CLI Application

## Learning Objectives

By the end of this project, you will be able to:
- Understand command-line interface (CLI) concepts
- Use the `argparse` module effectively
- Create user-friendly command-line applications
- Handle command-line arguments and options
- Build file processing tools
- Implement subcommands in CLI applications
- Add help text and descriptions
- Handle errors gracefully
- Create professional CLI tools
- Test CLI applications
- Package CLI applications
- Apply best practices for CLI development

---

## Introduction to CLI Applications

**Command-Line Interface (CLI)** applications are programs that users interact with through text commands in a terminal or command prompt. They are powerful, scriptable, and essential for automation and system administration.

**Why CLI Applications?**
- **Automation**: Can be easily scripted and automated
- **Efficiency**: Faster for experienced users
- **Remote access**: Work over SSH and remote connections
- **Resource efficient**: Lower memory and CPU usage
- **Integration**: Easy to integrate with other tools

**Common CLI Tools**:
- `git` - Version control
- `docker` - Container management
- `pip` - Package management
- `grep` - Text search
- `ls`, `cd`, `mkdir` - File operations

---

## argparse Module

### Basic Usage

```python
import argparse

# Create parser
parser = argparse.ArgumentParser(description='A simple CLI tool')

# Add argument
parser.add_argument('name', help='Your name')

# Parse arguments
args = parser.parse_args()

# Use arguments
print(f'Hello, {args.name}!')
```

**Usage**:
```bash
python script.py Alice
# Output: Hello, Alice!
```

### Positional Arguments

```python
import argparse

parser = argparse.ArgumentParser(description='Process some files')
parser.add_argument('input_file', help='Input file path')
parser.add_argument('output_file', help='Output file path')

args = parser.parse_args()
print(f'Processing {args.input_file} -> {args.output_file}')
```

**Usage**:
```bash
python script.py input.txt output.txt
```

### Optional Arguments

```python
import argparse

parser = argparse.ArgumentParser(description='File processor')
parser.add_argument('--input', '-i', help='Input file', required=True)
parser.add_argument('--output', '-o', help='Output file', default='output.txt')
parser.add_argument('--verbose', '-v', action='store_true', help='Verbose mode')

args = parser.parse_args()

if args.verbose:
    print(f'Processing {args.input} -> {args.output}')
```

**Usage**:
```bash
python script.py --input file.txt --output result.txt --verbose
# or
python script.py -i file.txt -o result.txt -v
```

### Argument Types

```python
import argparse

parser = argparse.ArgumentParser()
parser.add_argument('--count', type=int, help='Number of items', default=1)
parser.add_argument('--price', type=float, help='Price per item')
parser.add_argument('--active', action='store_true', help='Active flag')
parser.add_argument('--mode', choices=['read', 'write', 'append'], help='File mode')

args = parser.parse_args()
print(f'Count: {args.count}, Price: {args.price}, Active: {args.active}, Mode: {args.mode}')
```

### Multiple Values

```python
import argparse

parser = argparse.ArgumentParser()
parser.add_argument('--files', nargs='+', help='List of files')
parser.add_argument('--tags', nargs='*', help='Optional tags')

args = parser.parse_args()
print(f'Files: {args.files}')
print(f'Tags: {args.tags}')
```

**Usage**:
```bash
python script.py --files file1.txt file2.txt file3.txt
python script.py --tags tag1 tag2 tag3
```

---

## Creating Command-Line Interfaces

### Simple CLI Tool

```python
#!/usr/bin/env python3
"""
Simple CLI Calculator
"""

import argparse

def add(a, b):
    return a + b

def subtract(a, b):
    return a - b

def multiply(a, b):
    return a * b

def divide(a, b):
    if b == 0:
        raise ValueError("Cannot divide by zero")
    return a / b

def main():
    parser = argparse.ArgumentParser(
        description='A simple command-line calculator',
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog='''
Examples:
  python calculator.py add 10 5
  python calculator.py subtract 10 5
  python calculator.py multiply 10 5
  python calculator.py divide 10 5
        '''
    )
    
    parser.add_argument('operation', 
                       choices=['add', 'subtract', 'multiply', 'divide'],
                       help='Operation to perform')
    parser.add_argument('a', type=float, help='First number')
    parser.add_argument('b', type=float, help='Second number')
    parser.add_argument('-v', '--verbose', action='store_true',
                       help='Show detailed output')
    
    args = parser.parse_args()
    
    operations = {
        'add': add,
        'subtract': subtract,
        'multiply': multiply,
        'divide': divide
    }
    
    try:
        result = operations[args.operation](args.a, args.b)
        if args.verbose:
            print(f'{args.operation.capitalize()}({args.a}, {args.b}) = {result}')
        else:
            print(result)
    except ValueError as e:
        print(f'Error: {e}', file=sys.stderr)
        sys.exit(1)

if __name__ == '__main__':
    import sys
    main()
```

### Subcommands

```python
#!/usr/bin/env python3
"""
CLI Tool with Subcommands
"""

import argparse
import sys

def create_parser():
    parser = argparse.ArgumentParser(
        description='File management tool',
        prog='filetool'
    )
    
    subparsers = parser.add_subparsers(dest='command', help='Available commands')
    
    # Create subcommand
    create_parser = subparsers.add_parser('create', help='Create a new file')
    create_parser.add_argument('filename', help='Name of the file to create')
    create_parser.add_argument('--content', help='File content', default='')
    
    # Read subcommand
    read_parser = subparsers.add_parser('read', help='Read a file')
    read_parser.add_argument('filename', help='Name of the file to read')
    
    # Delete subcommand
    delete_parser = subparsers.add_parser('delete', help='Delete a file')
    delete_parser.add_argument('filename', help='Name of the file to delete')
    delete_parser.add_argument('--force', action='store_true', help='Force deletion')
    
    return parser

def handle_create(args):
    try:
        with open(args.filename, 'w') as f:
            f.write(args.content)
        print(f'Created file: {args.filename}')
    except Exception as e:
        print(f'Error creating file: {e}', file=sys.stderr)
        sys.exit(1)

def handle_read(args):
    try:
        with open(args.filename, 'r') as f:
            print(f.read())
    except FileNotFoundError:
        print(f'Error: File {args.filename} not found', file=sys.stderr)
        sys.exit(1)
    except Exception as e:
        print(f'Error reading file: {e}', file=sys.stderr)
        sys.exit(1)

def handle_delete(args):
    import os
    try:
        if args.force or input(f'Delete {args.filename}? (y/n): ').lower() == 'y':
            os.remove(args.filename)
            print(f'Deleted file: {args.filename}')
        else:
            print('Deletion cancelled')
    except FileNotFoundError:
        print(f'Error: File {args.filename} not found', file=sys.stderr)
        sys.exit(1)
    except Exception as e:
        print(f'Error deleting file: {e}', file=sys.stderr)
        sys.exit(1)

def main():
    parser = create_parser()
    args = parser.parse_args()
    
    if not args.command:
        parser.print_help()
        sys.exit(1)
    
    handlers = {
        'create': handle_create,
        'read': handle_read,
        'delete': handle_delete
    }
    
    handlers[args.command](args)

if __name__ == '__main__':
    main()
```

---

## File Processing Tool

### Complete File Processing CLI

```python
#!/usr/bin/env python3
"""
Advanced File Processing CLI Tool
Supports multiple operations on text files
"""

import argparse
import sys
import os
from pathlib import Path

def count_lines(filename):
    """Count lines in a file."""
    try:
        with open(filename, 'r', encoding='utf-8') as f:
            return sum(1 for _ in f)
    except Exception as e:
        print(f'Error: {e}', file=sys.stderr)
        sys.exit(1)

def count_words(filename):
    """Count words in a file."""
    try:
        with open(filename, 'r', encoding='utf-8') as f:
            content = f.read()
            return len(content.split())
    except Exception as e:
        print(f'Error: {e}', file=sys.stderr)
        sys.exit(1)

def count_chars(filename):
    """Count characters in a file."""
    try:
        with open(filename, 'r', encoding='utf-8') as f:
            return len(f.read())
    except Exception as e:
        print(f'Error: {e}', file=sys.stderr)
        sys.exit(1)

def search_text(filename, pattern, case_sensitive=True):
    """Search for text pattern in a file."""
    try:
        with open(filename, 'r', encoding='utf-8') as f:
            lines = f.readlines()
            matches = []
            for i, line in enumerate(lines, 1):
                if case_sensitive:
                    if pattern in line:
                        matches.append((i, line.strip()))
                else:
                    if pattern.lower() in line.lower():
                        matches.append((i, line.strip()))
            return matches
    except Exception as e:
        print(f'Error: {e}', file=sys.stderr)
        sys.exit(1)

def replace_text(filename, old_text, new_text, output_file=None):
    """Replace text in a file."""
    try:
        with open(filename, 'r', encoding='utf-8') as f:
            content = f.read()
        
        new_content = content.replace(old_text, new_text)
        
        output = output_file if output_file else filename
        with open(output, 'w', encoding='utf-8') as f:
            f.write(new_content)
        
        return content.count(old_text)
    except Exception as e:
        print(f'Error: {e}', file=sys.stderr)
        sys.exit(1)

def create_parser():
    parser = argparse.ArgumentParser(
        description='Advanced file processing tool',
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog='''
Examples:
  %(prog)s count-lines file.txt
  %(prog)s count-words file.txt
  %(prog)s search file.txt --pattern "hello"
  %(prog)s replace file.txt --old "old" --new "new" --output newfile.txt
        '''
    )
    
    parser.add_argument('-v', '--verbose', action='store_true',
                       help='Enable verbose output')
    
    subparsers = parser.add_subparsers(dest='command', help='Available commands')
    
    # Count lines
    count_lines_parser = subparsers.add_parser('count-lines', help='Count lines in file')
    count_lines_parser.add_argument('file', help='Input file')
    
    # Count words
    count_words_parser = subparsers.add_parser('count-words', help='Count words in file')
    count_words_parser.add_argument('file', help='Input file')
    
    # Count characters
    count_chars_parser = subparsers.add_parser('count-chars', help='Count characters in file')
    count_chars_parser.add_argument('file', help='Input file')
    
    # Search
    search_parser = subparsers.add_parser('search', help='Search for text in file')
    search_parser.add_argument('file', help='Input file')
    search_parser.add_argument('-p', '--pattern', required=True, help='Text pattern to search')
    search_parser.add_argument('-i', '--ignore-case', action='store_true',
                              help='Case-insensitive search')
    
    # Replace
    replace_parser = subparsers.add_parser('replace', help='Replace text in file')
    replace_parser.add_argument('file', help='Input file')
    replace_parser.add_argument('--old', required=True, help='Text to replace')
    replace_parser.add_argument('--new', required=True, help='Replacement text')
    replace_parser.add_argument('-o', '--output', help='Output file (default: overwrite input)')
    
    return parser

def main():
    parser = create_parser()
    args = parser.parse_args()
    
    if not args.command:
        parser.print_help()
        sys.exit(1)
    
    if args.verbose:
        print(f'Executing command: {args.command}')
    
    if args.command == 'count-lines':
        count = count_lines(args.file)
        print(f'Lines: {count}')
    
    elif args.command == 'count-words':
        count = count_words(args.file)
        print(f'Words: {count}')
    
    elif args.command == 'count-chars':
        count = count_chars(args.file)
        print(f'Characters: {count}')
    
    elif args.command == 'search':
        matches = search_text(args.file, args.pattern, 
                             case_sensitive=not args.ignore_case)
        if matches:
            print(f'Found {len(matches)} matches:')
            for line_num, line in matches:
                print(f'  Line {line_num}: {line}')
        else:
            print('No matches found')
    
    elif args.command == 'replace':
        count = replace_text(args.file, args.old, args.new, args.output)
        output = args.output if args.output else args.file
        print(f'Replaced {count} occurrence(s) in {output}')

if __name__ == '__main__':
    main()
```

---

## Advanced Features

### Progress Bars

```python
import argparse
import sys
from tqdm import tqdm

def process_file(filename):
    """Process file with progress bar."""
    try:
        with open(filename, 'r') as f:
            lines = f.readlines()
        
        for line in tqdm(lines, desc='Processing'):
            # Process line
            pass
        
        print('Processing complete!')
    except Exception as e:
        print(f'Error: {e}', file=sys.stderr)
        sys.exit(1)

def main():
    parser = argparse.ArgumentParser(description='File processor with progress')
    parser.add_argument('file', help='Input file')
    args = parser.parse_args()
    process_file(args.file)
```

### Configuration Files

```python
import argparse
import json
import os

def load_config(config_file='config.json'):
    """Load configuration from file."""
    if os.path.exists(config_file):
        with open(config_file, 'r') as f:
            return json.load(f)
    return {}

def main():
    parser = argparse.ArgumentParser(description='Tool with config file')
    parser.add_argument('--config', default='config.json', help='Config file')
    parser.add_argument('--input', help='Input file')
    args = parser.parse_args()
    
    config = load_config(args.config)
    
    # Use config values as defaults
    input_file = args.input or config.get('input', 'default.txt')
    print(f'Processing: {input_file}')
```

### Logging

```python
import argparse
import logging

def setup_logging(verbose=False):
    """Setup logging configuration."""
    level = logging.DEBUG if verbose else logging.INFO
    logging.basicConfig(
        level=level,
        format='%(asctime)s - %(name)s - %(levelname)s - %(message)s'
    )

def main():
    parser = argparse.ArgumentParser(description='Tool with logging')
    parser.add_argument('-v', '--verbose', action='store_true', help='Verbose logging')
    args = parser.parse_args()
    
    setup_logging(args.verbose)
    logger = logging.getLogger(__name__)
    
    logger.info('Starting application')
    logger.debug('Debug information')
    logger.warning('Warning message')
    logger.error('Error message')
```

---

## Best Practices

### 1. Clear Help Text

```python
parser = argparse.ArgumentParser(
    description='Clear description of what the tool does',
    epilog='Examples and additional information'
)
parser.add_argument('input', help='Clear description of input')
```

### 2. Proper Error Handling

```python
import sys

try:
    # Your code
    pass
except FileNotFoundError:
    print('Error: File not found', file=sys.stderr)
    sys.exit(1)
except Exception as e:
    print(f'Error: {e}', file=sys.stderr)
    sys.exit(1)
```

### 3. Exit Codes

```python
import sys

# Success
sys.exit(0)

# Error
sys.exit(1)

# Custom exit codes
sys.exit(2)  # Specific error type
```

### 4. Input Validation

```python
def validate_file(filename):
    """Validate file exists and is readable."""
    if not os.path.exists(filename):
        raise FileNotFoundError(f'File not found: {filename}')
    if not os.access(filename, os.R_OK):
        raise PermissionError(f'Cannot read file: {filename}')
    return True
```

---

## Practice Exercise

### Exercise: CLI Tool

**Objective**: Create a complete CLI application for file management.

**Requirements**:

1. Create a CLI tool with subcommands:
   - `list` - List files in a directory
   - `info` - Show file information
   - `copy` - Copy files
   - `move` - Move files
   - `delete` - Delete files

2. Features:
   - Help text for all commands
   - Verbose mode
   - Error handling
   - Progress indicators (optional)

**Example Solution**:

```python
#!/usr/bin/env python3
"""
File Management CLI Tool
A comprehensive file management command-line interface
"""

import argparse
import sys
import os
import shutil
from pathlib import Path
from datetime import datetime

def format_size(size):
    """Format file size in human-readable format."""
    for unit in ['B', 'KB', 'MB', 'GB']:
        if size < 1024.0:
            return f'{size:.2f} {unit}'
        size /= 1024.0
    return f'{size:.2f} TB'

def list_files(directory, verbose=False):
    """List files in a directory."""
    try:
        path = Path(directory)
        if not path.exists():
            print(f'Error: Directory {directory} does not exist', file=sys.stderr)
            sys.exit(1)
        
        if not path.is_dir():
            print(f'Error: {directory} is not a directory', file=sys.stderr)
            sys.exit(1)
        
        files = sorted(path.iterdir())
        
        if verbose:
            print(f'Contents of {directory}:')
            print('-' * 60)
            print(f'{"Name":<40} {"Size":<15} {"Modified":<20}')
            print('-' * 60)
            
            for file in files:
                size = format_size(file.stat().st_size) if file.is_file() else '<DIR>'
                mtime = datetime.fromtimestamp(file.stat().st_mtime).strftime('%Y-%m-%d %H:%M:%S')
                name = file.name + ('/' if file.is_dir() else '')
                print(f'{name:<40} {size:<15} {mtime:<20}')
        else:
            for file in files:
                print(file.name + ('/' if file.is_dir() else ''))
    
    except Exception as e:
        print(f'Error: {e}', file=sys.stderr)
        sys.exit(1)

def file_info(filename, verbose=False):
    """Show file information."""
    try:
        path = Path(filename)
        if not path.exists():
            print(f'Error: File {filename} does not exist', file=sys.stderr)
            sys.exit(1)
        
        stat = path.stat()
        
        print(f'File: {path.absolute()}')
        print(f'Size: {format_size(stat.st_size)}')
        print(f'Type: {"Directory" if path.is_dir() else "File"}')
        print(f'Modified: {datetime.fromtimestamp(stat.st_mtime)}')
        print(f'Created: {datetime.fromtimestamp(stat.st_ctime)}')
        print(f'Permissions: {oct(stat.st_mode)[-3:]}')
        
        if path.is_file():
            print(f'Extension: {path.suffix or "None"}')
    
    except Exception as e:
        print(f'Error: {e}', file=sys.stderr)
        sys.exit(1)

def copy_file(source, destination, verbose=False):
    """Copy file or directory."""
    try:
        src = Path(source)
        dst = Path(destination)
        
        if not src.exists():
            print(f'Error: Source {source} does not exist', file=sys.stderr)
            sys.exit(1)
        
        if verbose:
            print(f'Copying {source} to {destination}...')
        
        if src.is_file():
            shutil.copy2(src, dst)
        elif src.is_dir():
            shutil.copytree(src, dst, dirs_exist_ok=True)
        
        if verbose:
            print('Copy completed successfully')
    
    except Exception as e:
        print(f'Error: {e}', file=sys.stderr)
        sys.exit(1)

def move_file(source, destination, verbose=False):
    """Move file or directory."""
    try:
        src = Path(source)
        dst = Path(destination)
        
        if not src.exists():
            print(f'Error: Source {source} does not exist', file=sys.stderr)
            sys.exit(1)
        
        if verbose:
            print(f'Moving {source} to {destination}...')
        
        shutil.move(str(src), str(dst))
        
        if verbose:
            print('Move completed successfully')
    
    except Exception as e:
        print(f'Error: {e}', file=sys.stderr)
        sys.exit(1)

def delete_file(filename, force=False, verbose=False):
    """Delete file or directory."""
    try:
        path = Path(filename)
        
        if not path.exists():
            print(f'Error: {filename} does not exist', file=sys.stderr)
            sys.exit(1)
        
        if not force:
            confirm = input(f'Delete {filename}? (y/n): ')
            if confirm.lower() != 'y':
                print('Deletion cancelled')
                return
        
        if verbose:
            print(f'Deleting {filename}...')
        
        if path.is_file():
            path.unlink()
        elif path.is_dir():
            shutil.rmtree(path)
        
        if verbose:
            print('Deletion completed successfully')
    
    except Exception as e:
        print(f'Error: {e}', file=sys.stderr)
        sys.exit(1)

def create_parser():
    parser = argparse.ArgumentParser(
        description='File management CLI tool',
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog='''
Examples:
  %(prog)s list /path/to/directory
  %(prog)s info file.txt
  %(prog)s copy source.txt dest.txt
  %(prog)s move old.txt new.txt
  %(prog)s delete file.txt --force
        '''
    )
    
    parser.add_argument('-v', '--verbose', action='store_true',
                       help='Enable verbose output')
    
    subparsers = parser.add_subparsers(dest='command', help='Available commands')
    
    # List command
    list_parser = subparsers.add_parser('list', help='List files in directory')
    list_parser.add_argument('directory', help='Directory to list')
    
    # Info command
    info_parser = subparsers.add_parser('info', help='Show file information')
    info_parser.add_argument('file', help='File to inspect')
    
    # Copy command
    copy_parser = subparsers.add_parser('copy', help='Copy file or directory')
    copy_parser.add_argument('source', help='Source file or directory')
    copy_parser.add_argument('destination', help='Destination path')
    
    # Move command
    move_parser = subparsers.add_parser('move', help='Move file or directory')
    move_parser.add_argument('source', help='Source file or directory')
    move_parser.add_argument('destination', help='Destination path')
    
    # Delete command
    delete_parser = subparsers.add_parser('delete', help='Delete file or directory')
    delete_parser.add_argument('file', help='File or directory to delete')
    delete_parser.add_argument('--force', action='store_true',
                              help='Force deletion without confirmation')
    
    return parser

def main():
    parser = create_parser()
    args = parser.parse_args()
    
    if not args.command:
        parser.print_help()
        sys.exit(1)
    
    handlers = {
        'list': lambda: list_files(args.directory, args.verbose),
        'info': lambda: file_info(args.file, args.verbose),
        'copy': lambda: copy_file(args.source, args.destination, args.verbose),
        'move': lambda: move_file(args.source, args.destination, args.verbose),
        'delete': lambda: delete_file(args.file, args.force, args.verbose)
    }
    
    handlers[args.command]()

if __name__ == '__main__':
    main()
```

**Usage Examples**:
```bash
# List files
python filetool.py list /path/to/directory
python filetool.py list . -v

# File information
python filetool.py info file.txt

# Copy file
python filetool.py copy source.txt dest.txt -v

# Move file
python filetool.py move old.txt new.txt

# Delete file
python filetool.py delete file.txt
python filetool.py delete file.txt --force
```

**Expected Output**: A complete CLI tool for file management with all required features.

**Challenge** (Optional):
- Add recursive operations
- Add file filtering options
- Add batch operations
- Create a setup.py for installation
- Add unit tests

---

## Key Takeaways

1. **argparse** - Standard library for CLI argument parsing
2. **Positional arguments** - Required arguments
3. **Optional arguments** - Flags and options
4. **Subcommands** - Organize commands into groups
5. **Help text** - Provide clear documentation
6. **Error handling** - Handle errors gracefully
7. **Exit codes** - Use proper exit codes
8. **Input validation** - Validate user input
9. **Progress indicators** - Show progress for long operations
10. **Logging** - Add logging for debugging
11. **Best practices** - Clear help, proper errors, validation
12. **File operations** - Common file processing tasks
13. **User experience** - Make tools user-friendly
14. **Testing** - Test CLI applications
15. **Packaging** - Package for distribution

---

## Quiz: CLI Development

Test your understanding with these questions:

1. **What module is used for CLI argument parsing?**
   - A) sys
   - B) argparse
   - C) click
   - D) getopt

2. **What creates a parser?**
   - A) argparse.Parser()
   - B) argparse.ArgumentParser()
   - C) argparse.create_parser()
   - D) argparse.parser()

3. **What adds a positional argument?**
   - A) parser.add()
   - B) parser.add_argument()
   - C) parser.argument()
   - D) parser.positional()

4. **What makes an argument optional?**
   - A) Starts with --
   - B) Starts with -
   - C) action='store_true'
   - D) All of the above

5. **What creates subcommands?**
   - A) parser.add_subparsers()
   - B) parser.subcommands()
   - C) parser.commands()
   - D) parser.add_commands()

6. **What parses arguments?**
   - A) parser.parse()
   - B) parser.parse_args()
   - C) parser.args()
   - D) parser.get_args()

7. **What sets argument type?**
   - A) type parameter
   - B) dtype parameter
   - C) argtype parameter
   - D) format parameter

8. **What adds help text?**
   - A) help parameter
   - B) description parameter
   - C) doc parameter
   - D) info parameter

9. **What is a store_true action?**
   - A) Stores True if flag is present
   - B) Stores False if flag is present
   - C) Stores the flag value
   - D) Stores the flag name

10. **What exits with error code?**
    - A) sys.exit(1)
    - B) exit(1)
    - C) raise SystemExit(1)
    - D) All of the above

**Answers**:
1. B) argparse (standard library module)
2. B) argparse.ArgumentParser() (create parser)
3. B) parser.add_argument() (add argument)
4. D) All of the above (optional argument methods)
5. A) parser.add_subparsers() (create subcommands)
6. B) parser.parse_args() (parse arguments)
7. A) type parameter (set type)
8. A) help parameter (help text)
9. A) Stores True if flag is present (store_true)
10. D) All of the above (exit methods)

---

## Next Steps

Excellent work! You've mastered CLI application development. You now understand:
- argparse module
- Creating command-line interfaces
- File processing tools
- How to build professional CLI applications

**What's Next?**
- Project 2.1: Web Scraping Basics
- Learn web scraping
- Work with BeautifulSoup
- Understand ethical scraping

---

## Additional Resources

- **argparse Documentation**: [docs.python.org/3/library/argparse.html](https://docs.python.org/3/library/argparse.html)
- **Click Library**: [click.palletsprojects.com/](https://click.palletsprojects.com/) (Alternative to argparse)
- **CLI Best Practices**: [clig.dev/](https://clig.dev/)
- **Python Packaging Guide**: [packaging.python.org/](https://packaging.python.org/)

---

*Project completed! You're ready to move on to the next project.*

