# Project 4.1: File Automation

## Learning Objectives

By the end of this project, you will be able to:
- Understand file automation concepts
- Process files in batches
- Perform directory operations
- Organize files automatically
- Rename files programmatically
- Filter and search files
- Copy and move files in bulk
- Process file contents
- Handle file errors gracefully
- Create automation scripts
- Schedule file operations
- Apply best practices
- Debug automation issues

---

## Introduction to File Automation

**File Automation** involves using scripts to perform repetitive file operations automatically. This saves time and reduces errors in manual file management.

**Common Use Cases**:
- Organizing downloaded files
- Batch renaming files
- Processing multiple files
- Cleaning up directories
- Backing up files
- Converting file formats
- Sorting files by type/date
- Removing duplicate files

**Benefits**:
- **Time saving**: Automate repetitive tasks
- **Consistency**: Same operations every time
- **Error reduction**: Less human error
- **Scalability**: Handle thousands of files
- **Scheduling**: Run automatically

---

## Batch File Processing

### Processing Multiple Files

```python
import os
from pathlib import Path

def process_files(directory, extension='.txt'):
    """Process all files with given extension."""
    directory_path = Path(directory)
    
    for file_path in directory_path.glob(f'*{extension}'):
        print(f'Processing: {file_path.name}')
        # Process file
        with open(file_path, 'r') as f:
            content = f.read()
            # Do something with content
            print(f'  Size: {len(content)} bytes')

# Usage
process_files('/path/to/directory', '.txt')
```

### Batch File Operations

```python
from pathlib import Path
import shutil

def batch_rename(directory, prefix='file_', start_num=1):
    """Rename all files in directory with sequential numbers."""
    directory_path = Path(directory)
    files = sorted(directory_path.iterdir())
    
    for idx, file_path in enumerate(files, start=start_num):
        if file_path.is_file():
            new_name = f'{prefix}{idx:03d}{file_path.suffix}'
            new_path = file_path.parent / new_name
            file_path.rename(new_path)
            print(f'Renamed: {file_path.name} -> {new_name}')

def batch_copy(source_dir, dest_dir, extension='.txt'):
    """Copy all files with extension from source to destination."""
    source_path = Path(source_dir)
    dest_path = Path(dest_dir)
    dest_path.mkdir(parents=True, exist_ok=True)
    
    for file_path in source_path.glob(f'*{extension}'):
        dest_file = dest_path / file_path.name
        shutil.copy2(file_path, dest_file)
        print(f'Copied: {file_path.name}')

def batch_delete(directory, pattern='*.tmp'):
    """Delete all files matching pattern."""
    directory_path = Path(directory)
    deleted_count = 0
    
    for file_path in directory_path.glob(pattern):
        if file_path.is_file():
            file_path.unlink()
            deleted_count += 1
            print(f'Deleted: {file_path.name}')
    
    print(f'Deleted {deleted_count} files')
```

### Processing File Contents

```python
from pathlib import Path

def process_text_files(directory, operation='uppercase'):
    """Process text files with various operations."""
    directory_path = Path(directory)
    
    for file_path in directory_path.glob('*.txt'):
        try:
            with open(file_path, 'r', encoding='utf-8') as f:
                content = f.read()
            
            # Apply operation
            if operation == 'uppercase':
                new_content = content.upper()
            elif operation == 'lowercase':
                new_content = content.lower()
            elif operation == 'strip':
                new_content = content.strip()
            else:
                new_content = content
            
            # Write back
            with open(file_path, 'w', encoding='utf-8') as f:
                f.write(new_content)
            
            print(f'Processed: {file_path.name}')
        except Exception as e:
            print(f'Error processing {file_path.name}: {e}')

def find_and_replace(directory, old_text, new_text):
    """Find and replace text in all files."""
    directory_path = Path(directory)
    
    for file_path in directory_path.glob('*.txt'):
        try:
            with open(file_path, 'r', encoding='utf-8') as f:
                content = f.read()
            
            if old_text in content:
                new_content = content.replace(old_text, new_text)
                with open(file_path, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                print(f'Updated: {file_path.name}')
        except Exception as e:
            print(f'Error processing {file_path.name}: {e}')
```

---

## Directory Operations

### Organizing Files

```python
from pathlib import Path
import shutil
from datetime import datetime

def organize_by_extension(directory):
    """Organize files by extension into subdirectories."""
    directory_path = Path(directory)
    
    for file_path in directory_path.iterdir():
        if file_path.is_file():
            # Get extension (without dot)
            extension = file_path.suffix[1:] if file_path.suffix else 'no_extension'
            
            # Create subdirectory
            subdir = directory_path / extension
            subdir.mkdir(exist_ok=True)
            
            # Move file
            dest = subdir / file_path.name
            file_path.rename(dest)
            print(f'Moved: {file_path.name} -> {extension}/')

def organize_by_date(directory):
    """Organize files by creation date."""
    directory_path = Path(directory)
    
    for file_path in directory_path.iterdir():
        if file_path.is_file():
            # Get creation date
            timestamp = file_path.stat().st_mtime
            date = datetime.fromtimestamp(timestamp)
            date_str = date.strftime('%Y-%m-%d')
            
            # Create subdirectory
            subdir = directory_path / date_str
            subdir.mkdir(exist_ok=True)
            
            # Move file
            dest = subdir / file_path.name
            file_path.rename(dest)
            print(f'Moved: {file_path.name} -> {date_str}/')

def organize_by_size(directory):
    """Organize files by size categories."""
    directory_path = Path(directory)
    
    size_categories = {
        'small': (0, 1024 * 1024),  # 0-1MB
        'medium': (1024 * 1024, 10 * 1024 * 1024),  # 1-10MB
        'large': (10 * 1024 * 1024, float('inf'))  # 10MB+
    }
    
    for file_path in directory_path.iterdir():
        if file_path.is_file():
            size = file_path.stat().st_size
            
            # Determine category
            category = 'large'
            for cat, (min_size, max_size) in size_categories.items():
                if min_size <= size < max_size:
                    category = cat
                    break
            
            # Create subdirectory
            subdir = directory_path / category
            subdir.mkdir(exist_ok=True)
            
            # Move file
            dest = subdir / file_path.name
            file_path.rename(dest)
            print(f'Moved: {file_path.name} -> {category}/ ({size} bytes)')
```

### Directory Traversal

```python
from pathlib import Path

def find_files(directory, pattern='*.txt', recursive=True):
    """Find files matching pattern."""
    directory_path = Path(directory)
    
    if recursive:
        files = list(directory_path.rglob(pattern))
    else:
        files = list(directory_path.glob(pattern))
    
    return files

def find_large_files(directory, min_size_mb=10):
    """Find files larger than specified size."""
    directory_path = Path(directory)
    min_size = min_size_mb * 1024 * 1024
    large_files = []
    
    for file_path in directory_path.rglob('*'):
        if file_path.is_file():
            size = file_path.stat().st_size
            if size >= min_size:
                large_files.append((file_path, size))
    
    return sorted(large_files, key=lambda x: x[1], reverse=True)

def find_duplicate_files(directory):
    """Find duplicate files by content hash."""
    import hashlib
    from collections import defaultdict
    
    directory_path = Path(directory)
    file_hashes = defaultdict(list)
    
    for file_path in directory_path.rglob('*'):
        if file_path.is_file():
            try:
                # Calculate MD5 hash
                hash_md5 = hashlib.md5()
                with open(file_path, 'rb') as f:
                    for chunk in iter(lambda: f.read(4096), b''):
                        hash_md5.update(chunk)
                file_hash = hash_md5.hexdigest()
                file_hashes[file_hash].append(file_path)
            except Exception as e:
                print(f'Error hashing {file_path}: {e}')
    
    # Find duplicates
    duplicates = {h: paths for h, paths in file_hashes.items() if len(paths) > 1}
    return duplicates
```

### Directory Cleanup

```python
from pathlib import Path
import os
from datetime import datetime, timedelta

def cleanup_old_files(directory, days_old=30):
    """Delete files older than specified days."""
    directory_path = Path(directory)
    cutoff_date = datetime.now() - timedelta(days=days_old)
    deleted_count = 0
    
    for file_path in directory_path.rglob('*'):
        if file_path.is_file():
            file_time = datetime.fromtimestamp(file_path.stat().st_mtime)
            if file_time < cutoff_date:
                try:
                    file_path.unlink()
                    deleted_count += 1
                    print(f'Deleted: {file_path.name} ({file_time})')
                except Exception as e:
                    print(f'Error deleting {file_path.name}: {e}')
    
    print(f'Deleted {deleted_count} old files')

def cleanup_empty_directories(directory):
    """Remove empty directories."""
    directory_path = Path(directory)
    removed_count = 0
    
    # Walk from bottom up
    for dir_path in sorted(directory_path.rglob('*'), reverse=True):
        if dir_path.is_dir():
            try:
                # Try to remove (only works if empty)
                dir_path.rmdir()
                removed_count += 1
                print(f'Removed empty directory: {dir_path}')
            except OSError:
                # Directory not empty, skip
                pass
    
    print(f'Removed {removed_count} empty directories')

def cleanup_temp_files(directory):
    """Remove temporary files."""
    directory_path = Path(directory)
    temp_extensions = ['.tmp', '.temp', '.bak', '.swp', '~']
    deleted_count = 0
    
    for file_path in directory_path.rglob('*'):
        if file_path.is_file():
            if file_path.suffix.lower() in temp_extensions or file_path.name.endswith('~'):
                try:
                    file_path.unlink()
                    deleted_count += 1
                    print(f'Deleted temp file: {file_path.name}')
                except Exception as e:
                    print(f'Error deleting {file_path.name}: {e}')
    
    print(f'Deleted {deleted_count} temporary files')
```

---

## Complete Automation Script

### File Organizer

```python
#!/usr/bin/env python3
"""
File Organizer - Automatically organize files in a directory
"""

from pathlib import Path
import shutil
from datetime import datetime
from collections import defaultdict
import argparse

class FileOrganizer:
    def __init__(self, directory):
        self.directory = Path(directory)
        if not self.directory.exists():
            raise ValueError(f'Directory {directory} does not exist')
    
    def organize_by_extension(self, dry_run=False):
        """Organize files by extension."""
        organized = defaultdict(list)
        
        for file_path in self.directory.iterdir():
            if file_path.is_file():
                extension = file_path.suffix[1:] if file_path.suffix else 'no_extension'
                organized[extension].append(file_path)
        
        if dry_run:
            print('Dry run - would organize:')
            for ext, files in organized.items():
                print(f'  {ext}: {len(files)} files')
            return
        
        for extension, files in organized.items():
            subdir = self.directory / extension
            subdir.mkdir(exist_ok=True)
            
            for file_path in files:
                dest = subdir / file_path.name
                if not dest.exists():
                    file_path.rename(dest)
                    print(f'Moved: {file_path.name} -> {extension}/')
                else:
                    print(f'Skipped (exists): {file_path.name}')
    
    def organize_by_date(self, dry_run=False):
        """Organize files by creation date."""
        organized = defaultdict(list)
        
        for file_path in self.directory.iterdir():
            if file_path.is_file():
                timestamp = file_path.stat().st_mtime
                date_str = datetime.fromtimestamp(timestamp).strftime('%Y-%m-%d')
                organized[date_str].append(file_path)
        
        if dry_run:
            print('Dry run - would organize:')
            for date, files in organized.items():
                print(f'  {date}: {len(files)} files')
            return
        
        for date_str, files in organized.items():
            subdir = self.directory / date_str
            subdir.mkdir(exist_ok=True)
            
            for file_path in files:
                dest = subdir / file_path.name
                if not dest.exists():
                    file_path.rename(dest)
                    print(f'Moved: {file_path.name} -> {date_str}/')
    
    def organize_by_type(self, dry_run=False):
        """Organize files by type category."""
        type_categories = {
            'images': ['.jpg', '.jpeg', '.png', '.gif', '.bmp', '.svg'],
            'documents': ['.pdf', '.doc', '.docx', '.txt', '.rtf'],
            'videos': ['.mp4', '.avi', '.mov', '.mkv', '.wmv'],
            'audio': ['.mp3', '.wav', '.flac', '.aac', '.ogg'],
            'archives': ['.zip', '.rar', '.7z', '.tar', '.gz'],
            'code': ['.py', '.js', '.html', '.css', '.java', '.cpp']
        }
        
        organized = defaultdict(list)
        uncategorized = []
        
        for file_path in self.directory.iterdir():
            if file_path.is_file():
                extension = file_path.suffix.lower()
                categorized = False
                
                for category, extensions in type_categories.items():
                    if extension in extensions:
                        organized[category].append(file_path)
                        categorized = True
                        break
                
                if not categorized:
                    uncategorized.append(file_path)
        
        if uncategorized:
            organized['other'] = uncategorized
        
        if dry_run:
            print('Dry run - would organize:')
            for category, files in organized.items():
                print(f'  {category}: {len(files)} files')
            return
        
        for category, files in organized.items():
            subdir = self.directory / category
            subdir.mkdir(exist_ok=True)
            
            for file_path in files:
                dest = subdir / file_path.name
                if not dest.exists():
                    file_path.rename(dest)
                    print(f'Moved: {file_path.name} -> {category}/')
    
    def get_statistics(self):
        """Get directory statistics."""
        stats = {
            'total_files': 0,
            'total_size': 0,
            'by_extension': defaultdict(int),
            'by_type': defaultdict(int)
        }
        
        for file_path in self.directory.rglob('*'):
            if file_path.is_file():
                stats['total_files'] += 1
                stats['total_size'] += file_path.stat().st_size
                stats['by_extension'][file_path.suffix] += 1
        
        return stats

def main():
    parser = argparse.ArgumentParser(description='File organizer tool')
    parser.add_argument('directory', help='Directory to organize')
    parser.add_argument('--method', choices=['extension', 'date', 'type'],
                       default='extension', help='Organization method')
    parser.add_argument('--dry-run', action='store_true',
                       help='Show what would be done without making changes')
    
    args = parser.parse_args()
    
    organizer = FileOrganizer(args.directory)
    
    if args.method == 'extension':
        organizer.organize_by_extension(dry_run=args.dry_run)
    elif args.method == 'date':
        organizer.organize_by_date(dry_run=args.dry_run)
    elif args.method == 'type':
        organizer.organize_by_type(dry_run=args.dry_run)
    
    # Show statistics
    stats = organizer.get_statistics()
    print(f'\nStatistics:')
    print(f'  Total files: {stats["total_files"]}')
    print(f'  Total size: {stats["total_size"] / (1024*1024):.2f} MB')

if __name__ == '__main__':
    main()
```

---

## Advanced Features

### File Monitoring

```python
from pathlib import Path
import time
from watchdog.observers import Observer
from watchdog.events import FileSystemEventHandler

class FileHandler(FileSystemEventHandler):
    def on_created(self, event):
        if not event.is_directory:
            print(f'New file created: {event.src_path}')
            # Process new file
    
    def on_modified(self, event):
        if not event.is_directory:
            print(f'File modified: {event.src_path}')
            # Process modified file
    
    def on_deleted(self, event):
        if not event.is_directory:
            print(f'File deleted: {event.src_path}')

def monitor_directory(directory):
    """Monitor directory for file changes."""
    event_handler = FileHandler()
    observer = Observer()
    observer.schedule(event_handler, directory, recursive=True)
    observer.start()
    
    try:
        while True:
            time.sleep(1)
    except KeyboardInterrupt:
        observer.stop()
    observer.join()
```

### File Backup

```python
from pathlib import Path
import shutil
from datetime import datetime

def backup_files(source_dir, backup_dir, extensions=None):
    """Backup files to backup directory."""
    source_path = Path(source_dir)
    backup_path = Path(backup_dir)
    
    # Create backup directory with timestamp
    timestamp = datetime.now().strftime('%Y%m%d_%H%M%S')
    backup_dir = backup_path / f'backup_{timestamp}'
    backup_dir.mkdir(parents=True, exist_ok=True)
    
    # Copy files
    copied_count = 0
    for file_path in source_path.rglob('*'):
        if file_path.is_file():
            if extensions is None or file_path.suffix in extensions:
                # Preserve directory structure
                relative_path = file_path.relative_to(source_path)
                dest_path = backup_dir / relative_path
                dest_path.parent.mkdir(parents=True, exist_ok=True)
                
                shutil.copy2(file_path, dest_path)
                copied_count += 1
    
    print(f'Backed up {copied_count} files to {backup_dir}')
    return backup_dir
```

---

## Best Practices

### 1. Always Use Path Objects

```python
# Good: Use pathlib.Path
from pathlib import Path
file_path = Path('/path/to/file.txt')

# Avoid: String concatenation
file_path = '/path/to/' + 'file.txt'
```

### 2. Handle Errors

```python
# Good: Handle errors gracefully
try:
    file_path.unlink()
except FileNotFoundError:
    print(f'File not found: {file_path}')
except PermissionError:
    print(f'Permission denied: {file_path}')
```

### 3. Use Dry Run Mode

```python
# Always provide dry-run option
if dry_run:
    print('Would delete:', file_path)
else:
    file_path.unlink()
```

### 4. Log Operations

```python
import logging

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

logger.info(f'Processing file: {file_path}')
logger.error(f'Error processing {file_path}: {e}')
```

---

## Practice Exercise

### Exercise: Automation Script

**Objective**: Create a comprehensive file automation script.

**Requirements**:

1. Create a file automation script that:
   - Organizes files by type/extension/date
   - Renames files in batch
   - Finds and processes files
   - Cleans up directories
   - Provides statistics

2. Features:
   - CLI interface
   - Dry-run mode
   - Error handling
   - Logging
   - Multiple organization methods

**Example Solution**:

```python
#!/usr/bin/env python3
"""
Comprehensive File Automation Script
"""

from pathlib import Path
import shutil
import argparse
import logging
from datetime import datetime, timedelta
from collections import defaultdict
import hashlib

logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(levelname)s - %(message)s'
)
logger = logging.getLogger(__name__)

class FileAutomation:
    def __init__(self, directory, dry_run=False):
        self.directory = Path(directory)
        self.dry_run = dry_run
        
        if not self.directory.exists():
            raise ValueError(f'Directory {directory} does not exist')
    
    def organize_by_extension(self):
        """Organize files by extension."""
        logger.info(f'Organizing files by extension in {self.directory}')
        
        organized = defaultdict(list)
        for file_path in self.directory.iterdir():
            if file_path.is_file():
                ext = file_path.suffix[1:] if file_path.suffix else 'no_extension'
                organized[ext].append(file_path)
        
        if self.dry_run:
            logger.info('DRY RUN - Would organize:')
            for ext, files in organized.items():
                logger.info(f'  {ext}: {len(files)} files')
            return
        
        for ext, files in organized.items():
            subdir = self.directory / ext
            subdir.mkdir(exist_ok=True)
            for file_path in files:
                dest = subdir / file_path.name
                if not dest.exists():
                    file_path.rename(dest)
                    logger.info(f'Moved: {file_path.name} -> {ext}/')
    
    def batch_rename(self, pattern='file_{:03d}', start=1):
        """Batch rename files."""
        logger.info(f'Renaming files in {self.directory}')
        
        files = sorted([f for f in self.directory.iterdir() if f.is_file()])
        
        if self.dry_run:
            logger.info('DRY RUN - Would rename:')
            for idx, file_path in enumerate(files, start):
                new_name = pattern.format(idx) + file_path.suffix
                logger.info(f'  {file_path.name} -> {new_name}')
            return
        
        for idx, file_path in enumerate(files, start):
            new_name = pattern.format(idx) + file_path.suffix
            new_path = file_path.parent / new_name
            if not new_path.exists():
                file_path.rename(new_path)
                logger.info(f'Renamed: {file_path.name} -> {new_name}')
    
    def find_duplicates(self):
        """Find duplicate files."""
        logger.info(f'Finding duplicates in {self.directory}')
        
        file_hashes = defaultdict(list)
        
        for file_path in self.directory.rglob('*'):
            if file_path.is_file():
                try:
                    hash_md5 = hashlib.md5()
                    with open(file_path, 'rb') as f:
                        for chunk in iter(lambda: f.read(4096), b''):
                            hash_md5.update(chunk)
                    file_hash = hash_md5.hexdigest()
                    file_hashes[file_hash].append(file_path)
                except Exception as e:
                    logger.error(f'Error hashing {file_path}: {e}')
        
        duplicates = {h: paths for h, paths in file_hashes.items() if len(paths) > 1}
        
        if duplicates:
            logger.info(f'Found {len(duplicates)} sets of duplicates:')
            for file_hash, paths in duplicates.items():
                logger.info(f'  Hash {file_hash[:8]}... ({len(paths)} files)')
                for path in paths:
                    logger.info(f'    {path}')
        else:
            logger.info('No duplicates found')
        
        return duplicates
    
    def cleanup_old_files(self, days=30):
        """Clean up files older than specified days."""
        logger.info(f'Cleaning up files older than {days} days')
        
        cutoff_date = datetime.now() - timedelta(days=days)
        deleted_count = 0
        
        for file_path in self.directory.rglob('*'):
            if file_path.is_file():
                file_time = datetime.fromtimestamp(file_path.stat().st_mtime)
                if file_time < cutoff_date:
                    if self.dry_run:
                        logger.info(f'Would delete: {file_path.name} ({file_time})')
                    else:
                        try:
                            file_path.unlink()
                            deleted_count += 1
                            logger.info(f'Deleted: {file_path.name}')
                        except Exception as e:
                            logger.error(f'Error deleting {file_path.name}: {e}')
        
        if not self.dry_run:
            logger.info(f'Deleted {deleted_count} old files')
    
    def get_statistics(self):
        """Get directory statistics."""
        stats = {
            'total_files': 0,
            'total_dirs': 0,
            'total_size': 0,
            'by_extension': defaultdict(int),
            'oldest_file': None,
            'newest_file': None
        }
        
        oldest_time = float('inf')
        newest_time = 0
        
        for item in self.directory.rglob('*'):
            if item.is_file():
                stats['total_files'] += 1
                size = item.stat().st_size
                stats['total_size'] += size
                stats['by_extension'][item.suffix] += 1
                
                mtime = item.stat().st_mtime
                if mtime < oldest_time:
                    oldest_time = mtime
                    stats['oldest_file'] = item
                if mtime > newest_time:
                    newest_time = mtime
                    stats['newest_file'] = item
            elif item.is_dir():
                stats['total_dirs'] += 1
        
        return stats

def main():
    parser = argparse.ArgumentParser(description='File automation tool')
    parser.add_argument('directory', help='Directory to process')
    parser.add_argument('--dry-run', action='store_true',
                       help='Show what would be done without making changes')
    
    subparsers = parser.add_subparsers(dest='command', help='Available commands')
    
    # Organize command
    organize_parser = subparsers.add_parser('organize', help='Organize files')
    organize_parser.add_argument('--method', choices=['extension', 'date', 'type'],
                                default='extension', help='Organization method')
    
    # Rename command
    rename_parser = subparsers.add_parser('rename', help='Batch rename files')
    rename_parser.add_argument('--pattern', default='file_{:03d}',
                             help='Naming pattern (use {:03d} for numbers)')
    rename_parser.add_argument('--start', type=int, default=1,
                             help='Starting number')
    
    # Find duplicates command
    subparsers.add_parser('duplicates', help='Find duplicate files')
    
    # Cleanup command
    cleanup_parser = subparsers.add_parser('cleanup', help='Clean up old files')
    cleanup_parser.add_argument('--days', type=int, default=30,
                               help='Delete files older than this many days')
    
    # Statistics command
    subparsers.add_parser('stats', help='Show directory statistics')
    
    args = parser.parse_args()
    
    if not args.command:
        parser.print_help()
        return
    
    try:
        automation = FileAutomation(args.directory, dry_run=args.dry_run)
        
        if args.command == 'organize':
            if args.method == 'extension':
                automation.organize_by_extension()
            # Add other methods as needed
        
        elif args.command == 'rename':
            automation.batch_rename(pattern=args.pattern, start=args.start)
        
        elif args.command == 'duplicates':
            automation.find_duplicates()
        
        elif args.command == 'cleanup':
            automation.cleanup_old_files(days=args.days)
        
        elif args.command == 'stats':
            stats = automation.get_statistics()
            print(f'\nDirectory Statistics:')
            print(f'  Total files: {stats["total_files"]}')
            print(f'  Total directories: {stats["total_dirs"]}')
            print(f'  Total size: {stats["total_size"] / (1024*1024):.2f} MB')
            print(f'\n  Files by extension:')
            for ext, count in sorted(stats['by_extension'].items(), 
                                    key=lambda x: x[1], reverse=True)[:10]:
                print(f'    {ext or "no extension"}: {count}')
            if stats['oldest_file']:
                print(f'\n  Oldest file: {stats["oldest_file"].name}')
            if stats['newest_file']:
                print(f'  Newest file: {stats["newest_file"].name}')
    
    except Exception as e:
        logger.error(f'Error: {e}')
        return 1
    
    return 0

if __name__ == '__main__':
    exit(main())
```

**Usage Examples**:
```bash
# Organize files by extension
python automation.py /path/to/directory organize --method extension

# Batch rename files
python automation.py /path/to/directory rename --pattern "photo_{:03d}" --start 1

# Find duplicates
python automation.py /path/to/directory duplicates

# Cleanup old files
python automation.py /path/to/directory cleanup --days 30

# Show statistics
python automation.py /path/to/directory stats

# Dry run (see what would happen)
python automation.py /path/to/directory organize --dry-run
```

**Expected Output**: A complete file automation tool with multiple features.

**Challenge** (Optional):
- Add file conversion capabilities
- Add scheduling functionality
- Add GUI interface
- Add file search functionality
- Add backup/restore features

---

## Key Takeaways

1. **File Automation** - Automate repetitive file operations
2. **Batch Processing** - Process multiple files at once
3. **Directory Operations** - Organize and manage directories
4. **Path Objects** - Use pathlib.Path for file operations
5. **Error Handling** - Handle file errors gracefully
6. **Dry Run Mode** - Test before making changes
7. **Logging** - Log operations for debugging
8. **File Organization** - Organize by extension, date, type
9. **Batch Renaming** - Rename files programmatically
10. **Duplicate Detection** - Find duplicate files
11. **Cleanup Operations** - Remove old/temp files
12. **Statistics** - Get directory statistics
13. **Best Practices** - Use Path objects, handle errors, log operations
14. **CLI Interface** - Create user-friendly command-line tools
15. **Safety** - Always provide dry-run and confirmation options

---

## Quiz: Automation

Test your understanding with these questions:

1. **What is file automation?**
   - A) Manual file operations
   - B) Automatic file operations
   - C) File backup
   - D) File compression

2. **What library is best for file paths?**
   - A) os.path
   - B) pathlib
   - C) shutil
   - D) glob

3. **What processes multiple files?**
   - A) Batch processing
   - B) Single processing
   - C) Manual processing
   - D) Random processing

4. **What organizes files by extension?**
   - A) Group by type
   - B) Sort by name
   - C) Organize by extension
   - D) Filter files

5. **What is dry-run mode?**
   - A) Test mode
   - B) Show what would happen
   - C) Preview changes
   - D) All of the above

6. **What finds duplicate files?**
   - A) File comparison
   - B) Hash comparison
   - C) Size comparison
   - D) All of the above

7. **What removes old files?**
   - A) Cleanup operation
   - B) Delete operation
   - C) Archive operation
   - D) Backup operation

8. **What should you always do?**
   - A) Handle errors
   - B) Use dry-run
   - C) Log operations
   - D) All of the above

9. **What is batch renaming?**
   - A) Rename one file
   - B) Rename multiple files
   - C) Delete files
   - D) Copy files

10. **What provides file statistics?**
    - A) File count
    - B) Total size
    - C) File types
    - D) All of the above

**Answers**:
1. B) Automatic file operations (automation definition)
2. B) pathlib (modern path library)
3. A) Batch processing (process multiple files)
4. C) Organize by extension (file organization)
5. D) All of the above (dry-run mode)
6. D) All of the above (duplicate detection methods)
7. A) Cleanup operation (remove old files)
8. D) All of the above (best practices)
9. B) Rename multiple files (batch renaming)
10. D) All of the above (statistics)

---

## Next Steps

Excellent work! You've mastered file automation. You now understand:
- Batch file processing
- Directory operations
- How to build automation scripts

**What's Next?**
- Project 5.1: Full-Stack API Project
- Learn complete REST API development
- Build full-stack applications
- Integrate frontend and backend

---

## Additional Resources

- **pathlib Documentation**: [docs.python.org/3/library/pathlib.html](https://docs.python.org/3/library/pathlib.html)
- **shutil Documentation**: [docs.python.org/3/library/shutil.html](https://docs.python.org/3/library/shutil.html)
- **watchdog Library**: [python-watchdog.readthedocs.io/](https://python-watchdog.readthedocs.io/) (File monitoring)
- **File Operations Guide**: Best practices for file automation

---

*Project completed! You're ready to move on to the next project.*

