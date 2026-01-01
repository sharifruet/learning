# Lesson 9.2: Working with File Paths

## Learning Objectives

By the end of this lesson, you will be able to:
- Use the `os.path` module for path operations
- Use the `pathlib` module (modern approach)
- Manipulate file and directory paths
- Join and split paths correctly
- Check if paths exist
- Get path components (directory, filename, extension)
- Work with absolute and relative paths
- Handle cross-platform path differences
- Navigate directory structures
- Understand when to use `os.path` vs `pathlib`

---

## Introduction to File Paths

**File paths** specify the location of files and directories in a file system. Python provides tools to work with paths in a cross-platform way.

### Why Path Handling Matters

- **Cross-platform compatibility**: Windows uses `\`, Unix uses `/`
- **Path manipulation**: Join, split, normalize paths
- **Path validation**: Check if paths exist
- **Path information**: Get directory, filename, extension

### Path Types

1. **Absolute paths**: Full path from root
2. **Relative paths**: Path relative to current directory

---

## The `os.path` Module

The `os.path` module provides functions for path manipulation (traditional approach).

### Common `os.path` Functions

| Function | Description |
|----------|-------------|
| `join()` | Join path components |
| `split()` | Split path into directory and filename |
| `dirname()` | Get directory name |
| `basename()` | Get filename |
| `splitext()` | Split filename and extension |
| `exists()` | Check if path exists |
| `isfile()` | Check if path is a file |
| `isdir()` | Check if path is a directory |
| `abspath()` | Get absolute path |
| `normpath()` | Normalize path |

### Joining Paths

```python
import os

# Join path components
path = os.path.join("folder", "subfolder", "file.txt")
print(path)  # Output: folder/subfolder/file.txt (or folder\subfolder\file.txt on Windows)

# Multiple components
path = os.path.join("/", "home", "user", "documents", "file.txt")
print(path)
```

### Splitting Paths

```python
import os

path = "/home/user/documents/file.txt"

# Split into directory and filename
directory, filename = os.path.split(path)
print(f"Directory: {directory}")    # Output: /home/user/documents
print(f"Filename: {filename}")    # Output: file.txt

# Get just directory name
dirname = os.path.dirname(path)
print(dirname)  # Output: /home/user/documents

# Get just filename
basename = os.path.basename(path)
print(basename)  # Output: file.txt
```

### Splitting Extension

```python
import os

path = "document.txt"

# Split filename and extension
filename, extension = os.path.splitext(path)
print(f"Filename: {filename}")    # Output: Filename: document
print(f"Extension: {extension}")  # Output: Extension: .txt

# Works with full paths
path = "/home/user/document.txt"
filename, extension = os.path.splitext(path)
print(filename)  # Output: /home/user/document
print(extension)  # Output: .txt
```

### Checking Path Existence

```python
import os

# Check if path exists
if os.path.exists("file.txt"):
    print("File exists")

# Check if it's a file
if os.path.isfile("file.txt"):
    print("It's a file")

# Check if it's a directory
if os.path.isdir("folder"):
    print("It's a directory")
```

### Absolute and Relative Paths

```python
import os

# Get absolute path
relative_path = "file.txt"
absolute_path = os.path.abspath(relative_path)
print(absolute_path)  # Output: /current/directory/file.txt

# Normalize path
path = "/home/user/../user/documents/./file.txt"
normalized = os.path.normpath(path)
print(normalized)  # Output: /home/user/documents/file.txt

# Check if absolute
print(os.path.isabs("/home/user"))  # Output: True
print(os.path.isabs("user"))        # Output: False
```

### Path Information

```python
import os

path = "/home/user/documents/report.txt"

# Get directory
directory = os.path.dirname(path)
print(directory)  # Output: /home/user/documents

# Get filename
filename = os.path.basename(path)
print(filename)  # Output: report.txt

# Get filename without extension
name = os.path.splitext(filename)[0]
print(name)  # Output: report

# Get extension
ext = os.path.splitext(filename)[1]
print(ext)  # Output: .txt
```

---

## The `pathlib` Module (Modern Approach)

The `pathlib` module provides an object-oriented approach to path handling (Python 3.4+).

### Path Objects

```python
from pathlib import Path

# Create Path object
path = Path("file.txt")
print(path)  # Output: file.txt

# Path objects are cross-platform
path = Path("folder") / "subfolder" / "file.txt"
print(path)  # Works on all platforms
```

### Creating Paths

```python
from pathlib import Path

# From string
path = Path("file.txt")

# From multiple components
path = Path("folder", "subfolder", "file.txt")

# Using / operator
path = Path("folder") / "subfolder" / "file.txt"

# Absolute path
path = Path("/home/user/file.txt")

# Current directory
current = Path.cwd()
print(current)

# Home directory
home = Path.home()
print(home)
```

### Path Properties

```python
from pathlib import Path

path = Path("/home/user/documents/report.txt")

# Get parts
print(path.parts)  # Output: ('/', 'home', 'user', 'documents', 'report.txt')

# Get parent directory
print(path.parent)  # Output: /home/user/documents

# Get filename
print(path.name)  # Output: report.txt

# Get stem (filename without extension)
print(path.stem)  # Output: report

# Get suffix (extension)
print(path.suffix)  # Output: .txt

# Get all suffixes
path = Path("archive.tar.gz")
print(path.suffixes)  # Output: ['.tar', '.gz']
```

### Path Methods

```python
from pathlib import Path

path = Path("file.txt")

# Check existence
print(path.exists())  # True or False
print(path.is_file())  # True if file
print(path.is_dir())   # True if directory

# Get absolute path
abs_path = path.absolute()
print(abs_path)

# Resolve (absolute + normalize)
resolved = path.resolve()
print(resolved)

# Check if absolute
print(path.is_absolute())  # True or False
```

### Joining Paths with `pathlib`

```python
from pathlib import Path

# Using / operator
path = Path("folder") / "subfolder" / "file.txt"

# Multiple levels
path = Path("a") / "b" / "c" / "d.txt"

# With absolute paths
path = Path("/home") / "user" / "file.txt"

# Join method
path = Path("folder").joinpath("subfolder", "file.txt")
```

### Reading and Writing with `pathlib`

```python
from pathlib import Path

path = Path("file.txt")

# Read text
content = path.read_text()
print(content)

# Read bytes
data = path.read_bytes()

# Write text
path.write_text("Hello, World!")

# Write bytes
path.write_bytes(b"Binary data")

# Read lines
lines = path.read_text().splitlines()
```

### Directory Operations

```python
from pathlib import Path

# Create directory
path = Path("new_folder")
path.mkdir()  # Create directory
path.mkdir(exist_ok=True)  # Don't error if exists

# Create parent directories
path = Path("a/b/c")
path.mkdir(parents=True, exist_ok=True)

# Remove directory (must be empty)
path.rmdir()

# List directory contents
directory = Path(".")
for item in directory.iterdir():
    print(item)

# List files only
for file in directory.iterdir():
    if file.is_file():
        print(file)

# List directories only
for dir_item in directory.iterdir():
    if dir_item.is_dir():
        print(dir_item)
```

### Path Pattern Matching

```python
from pathlib import Path

directory = Path(".")

# Find files matching pattern
for file in directory.glob("*.txt"):
    print(file)

# Recursive search
for file in directory.rglob("*.txt"):
    print(file)

# Find specific files
for file in directory.glob("**/*.py"):
    print(file)
```

---

## Comparing `os.path` and `pathlib`

### `os.path` (Traditional)

```python
import os

# Join paths
path = os.path.join("folder", "file.txt")

# Split
directory, filename = os.path.split(path)

# Check existence
if os.path.exists(path):
    print("Exists")

# Get extension
_, ext = os.path.splitext(path)
```

### `pathlib` (Modern)

```python
from pathlib import Path

# Create path
path = Path("folder") / "file.txt"

# Get parts
directory = path.parent
filename = path.name

# Check existence
if path.exists():
    print("Exists")

# Get extension
ext = path.suffix
```

### When to Use Each

- **`os.path`**: Legacy code, compatibility with older Python
- **`pathlib`**: New code, Python 3.4+, more intuitive

---

## Practical Examples

### Example 1: File Information

```python
from pathlib import Path

def file_info(filepath):
    path = Path(filepath)
    if path.exists():
        print(f"Path: {path}")
        print(f"Absolute: {path.absolute()}")
        print(f"Directory: {path.parent}")
        print(f"Filename: {path.name}")
        print(f"Stem: {path.stem}")
        print(f"Extension: {path.suffix}")
        print(f"Size: {path.stat().st_size} bytes")
    else:
        print("File does not exist")

file_info("example.txt")
```

### Example 2: Finding Files

```python
from pathlib import Path

def find_files(directory, pattern="*.txt"):
    """Find all files matching pattern in directory."""
    path = Path(directory)
    if path.is_dir():
        return list(path.glob(pattern))
    return []

# Find all .txt files
txt_files = find_files(".", "*.txt")
for file in txt_files:
    print(file)

# Find all .py files recursively
py_files = find_files(".", "**/*.py")
for file in py_files:
    print(file)
```

### Example 3: Organizing Files

```python
from pathlib import Path
import shutil

def organize_files(source_dir, target_dir):
    """Organize files by extension."""
    source = Path(source_dir)
    target = Path(target_dir)
    
    # Create target directory
    target.mkdir(exist_ok=True)
    
    # Process files
    for file in source.iterdir():
        if file.is_file():
            # Create extension directory
            ext_dir = target / file.suffix[1:]  # Remove dot
            ext_dir.mkdir(exist_ok=True)
            
            # Move file
            dest = ext_dir / file.name
            shutil.move(str(file), str(dest))
            print(f"Moved {file.name} to {ext_dir}")

organize_files(".", "organized")
```

### Example 4: Path Validation

```python
from pathlib import Path

def validate_path(filepath):
    """Validate and normalize path."""
    path = Path(filepath)
    
    # Resolve to absolute
    try:
        resolved = path.resolve()
        print(f"Resolved path: {resolved}")
        
        # Check if exists
        if resolved.exists():
            if resolved.is_file():
                print("Valid file path")
            elif resolved.is_dir():
                print("Valid directory path")
        else:
            print("Path does not exist")
            
        return resolved
    except Exception as e:
        print(f"Invalid path: {e}")
        return None

validate_path("example.txt")
```

### Example 5: Building Paths

```python
from pathlib import Path

def build_project_structure(base_path):
    """Create project directory structure."""
    base = Path(base_path)
    
    # Create directories
    directories = [
        base / "src",
        base / "tests",
        base / "docs",
        base / "data" / "raw",
        base / "data" / "processed"
    ]
    
    for directory in directories:
        directory.mkdir(parents=True, exist_ok=True)
        print(f"Created: {directory}")
    
    # Create files
    files = [
        base / "README.md",
        base / "requirements.txt",
        base / ".gitignore"
    ]
    
    for file in files:
        file.touch()
        print(f"Created: {file}")

build_project_structure("my_project")
```

---

## Cross-Platform Path Handling

### Platform Differences

```python
from pathlib import Path
import os

# Windows uses backslashes
# Unix uses forward slashes

# pathlib handles this automatically
path = Path("folder") / "file.txt"  # Works on all platforms

# os.path.join also handles this
path = os.path.join("folder", "file.txt")  # Works on all platforms
```

### Path Separators

```python
import os
from pathlib import Path

# Get platform separator
print(os.sep)  # Output: / (Unix) or \ (Windows)

# pathlib uses appropriate separator
path = Path("a") / "b" / "c"
print(path)  # Uses correct separator for platform
```

---

## Common Operations

### Getting Current Directory

```python
import os
from pathlib import Path

# os.path way
current = os.getcwd()
print(current)

# pathlib way
current = Path.cwd()
print(current)
```

### Changing Directory

```python
import os

# Change directory
os.chdir("/path/to/directory")

# Get current directory
current = os.getcwd()
```

### Listing Directory Contents

```python
from pathlib import Path

directory = Path(".")

# List all items
for item in directory.iterdir():
    print(item)

# List only files
files = [item for item in directory.iterdir() if item.is_file()]

# List only directories
dirs = [item for item in directory.iterdir() if item.is_dir()]
```

### Recursive Directory Traversal

```python
from pathlib import Path

def find_all_files(directory):
    """Find all files recursively."""
    path = Path(directory)
    files = []
    
    for item in path.rglob("*"):
        if item.is_file():
            files.append(item)
    
    return files

all_files = find_all_files(".")
for file in all_files:
    print(file)
```

---

## Common Mistakes and Pitfalls

### 1. String Concatenation for Paths

```python
# WRONG: String concatenation
path = "folder" + "/" + "file.txt"  # Platform-specific

# CORRECT: Use os.path.join or pathlib
import os
path = os.path.join("folder", "file.txt")

# OR
from pathlib import Path
path = Path("folder") / "file.txt"
```

### 2. Hardcoding Path Separators

```python
# WRONG: Hardcoded separator
path = "folder\\file.txt"  # Windows only

# CORRECT: Use path functions
from pathlib import Path
path = Path("folder") / "file.txt"  # Cross-platform
```

### 3. Not Checking Path Existence

```python
# WRONG: Assume path exists
path = Path("file.txt")
content = path.read_text()  # May fail

# CORRECT: Check first
path = Path("file.txt")
if path.exists():
    content = path.read_text()
else:
    print("File not found")
```

### 4. Confusing `pathlib` Path with String

```python
# pathlib Path is not a string
path = Path("file.txt")

# WRONG: Treating as string
# with open(path, "r") as file:  # May work but not ideal

# CORRECT: Use pathlib methods
content = path.read_text()

# OR convert to string
with open(str(path), "r") as file:
    content = file.read()
```

---

## Best Practices

### 1. Use `pathlib` for New Code

```python
# Preferred: pathlib
from pathlib import Path
path = Path("folder") / "file.txt"
```

### 2. Always Check Existence

```python
from pathlib import Path

path = Path("file.txt")
if path.exists():
    # Process file
    pass
```

### 3. Use `resolve()` for Absolute Paths

```python
from pathlib import Path

path = Path("file.txt")
absolute = path.resolve()  # Absolute + normalized
```

### 4. Use `parents` for Navigation

```python
from pathlib import Path

path = Path("/a/b/c/file.txt")
parent = path.parent  # /a/b/c
grandparent = path.parent.parent  # /a/b
```

### 5. Use `glob()` for Pattern Matching

```python
from pathlib import Path

# Find files matching pattern
for file in Path(".").glob("*.txt"):
    print(file)
```

---

## Practice Exercise

### Exercise: Path Manipulation

**Objective**: Create a Python program that demonstrates path operations.

**Instructions**:

1. Create a file called `path_manipulation_practice.py`

2. Write a program that:
   - Uses `os.path` for path operations
   - Uses `pathlib` for path operations
   - Manipulates file paths
   - Checks path existence
   - Gets path components
   - Works with directories

3. Your program should include:
   - Path joining and splitting
   - Path information extraction
   - Directory operations
   - File finding
   - Cross-platform examples

**Example Solution**:

```python
"""
Path Manipulation Practice
This program demonstrates path operations using os.path and pathlib.
"""

import os
from pathlib import Path

print("=" * 60)
print("PATH MANIPULATION PRACTICE")
print("=" * 60)
print()

# 1. os.path.join()
print("1. os.path.join()")
print("-" * 60)
path = os.path.join("folder", "subfolder", "file.txt")
print(f"Joined path: {path}")

path = os.path.join("/", "home", "user", "file.txt")
print(f"Absolute path: {path}")
print()

# 2. os.path.split()
print("2. os.path.split()")
print("-" * 60)
path = "/home/user/documents/file.txt"
directory, filename = os.path.split(path)
print(f"Directory: {directory}")
print(f"Filename: {filename}")
print()

# 3. os.path.dirname() and basename()
print("3. os.path.dirname() and basename()")
print("-" * 60)
path = "/home/user/documents/report.txt"
print(f"Path: {path}")
print(f"Directory: {os.path.dirname(path)}")
print(f"Filename: {os.path.basename(path)}")
print()

# 4. os.path.splitext()
print("4. os.path.splitext()")
print("-" * 60)
path = "document.txt"
filename, extension = os.path.splitext(path)
print(f"Filename: {filename}")
print(f"Extension: {extension}")

path = "/home/user/document.txt"
filename, extension = os.path.splitext(path)
print(f"Full path filename: {filename}")
print(f"Extension: {extension}")
print()

# 5. os.path.exists()
print("5. os.path.exists()")
print("-" * 60)
test_path = "example.txt"
if os.path.exists(test_path):
    print(f"{test_path} exists")
else:
    print(f"{test_path} does not exist")
print()

# 6. os.path.isfile() and isdir()
print("6. os.path.isfile() and isdir()")
print("-" * 60)
current_dir = "."
if os.path.isdir(current_dir):
    print(f"{current_dir} is a directory")

test_file = "example.txt"
if os.path.isfile(test_file):
    print(f"{test_file} is a file")
print()

# 7. os.path.abspath()
print("7. os.path.abspath()")
print("-" * 60)
relative_path = "file.txt"
absolute_path = os.path.abspath(relative_path)
print(f"Relative: {relative_path}")
print(f"Absolute: {absolute_path}")
print()

# 8. os.path.normpath()
print("8. os.path.normpath()")
print("-" * 60)
path = "/home/user/../user/documents/./file.txt"
normalized = os.path.normpath(path)
print(f"Original: {path}")
print(f"Normalized: {normalized}")
print()

# 9. pathlib Path creation
print("9. pathlib Path creation")
print("-" * 60)
path = Path("file.txt")
print(f"Path: {path}")

path = Path("folder") / "subfolder" / "file.txt"
print(f"Joined path: {path}")

path = Path("/home") / "user" / "file.txt"
print(f"Absolute path: {path}")
print()

# 10. pathlib Path properties
print("10. pathlib Path properties")
print("-" * 60)
path = Path("/home/user/documents/report.txt")
print(f"Path: {path}")
print(f"Parent: {path.parent}")
print(f"Name: {path.name}")
print(f"Stem: {path.stem}")
print(f"Suffix: {path.suffix}")
print(f"Parts: {path.parts}")
print()

# 11. pathlib exists() and is_file()
print("11. pathlib exists() and is_file()")
print("-" * 60)
path = Path("example.txt")
print(f"Path: {path}")
print(f"Exists: {path.exists()}")
print(f"Is file: {path.is_file()}")
print(f"Is directory: {path.is_dir()}")
print()

# 12. pathlib absolute() and resolve()
print("12. pathlib absolute() and resolve()")
print("-" * 60)
path = Path("file.txt")
print(f"Path: {path}")
print(f"Absolute: {path.absolute()}")
print(f"Resolved: {path.resolve()}")
print()

# 13. pathlib read_text() and write_text()
print("13. pathlib read_text() and write_text()")
print("-" * 60)
path = Path("test_file.txt")
path.write_text("Hello, World!\nThis is a test file.")
print(f"Written to {path}")

content = path.read_text()
print(f"Content:\n{content}")

# Cleanup
path.unlink()
print(f"Deleted {path}")
print()

# 14. pathlib directory operations
print("14. pathlib directory operations")
print("-" * 60)
# Create test directory
test_dir = Path("test_directory")
test_dir.mkdir(exist_ok=True)
print(f"Created directory: {test_dir}")

# Create file in directory
test_file = test_dir / "test.txt"
test_file.write_text("Test content")
print(f"Created file: {test_file}")

# List directory contents
print(f"Contents of {test_dir}:")
for item in test_dir.iterdir():
    print(f"  {item.name} ({'file' if item.is_file() else 'directory'})")

# Cleanup
test_file.unlink()
test_dir.rmdir()
print(f"Cleaned up {test_dir}")
print()

# 15. pathlib glob()
print("15. pathlib glob()")
print("-" * 60)
current_dir = Path(".")
print("Finding .txt files:")
txt_files = list(current_dir.glob("*.txt"))
if txt_files:
    for file in txt_files:
        print(f"  {file}")
else:
    print("  No .txt files found")

print("\nFinding .py files recursively:")
py_files = list(current_dir.rglob("*.py"))
if py_files:
    for file in py_files[:5]:  # Show first 5
        print(f"  {file}")
    if len(py_files) > 5:
        print(f"  ... and {len(py_files) - 5} more")
else:
    print("  No .py files found")
print()

# 16. Path.cwd() and Path.home()
print("16. Path.cwd() and Path.home()")
print("-" * 60)
current = Path.cwd()
print(f"Current directory: {current}")

home = Path.home()
print(f"Home directory: {home}")
print()

# 17. Building paths
print("17. Building paths")
print("-" * 60)
base = Path("project")
src = base / "src"
tests = base / "tests"
readme = base / "README.md"

print(f"Project structure:")
print(f"  {base}")
print(f"    {src.relative_to(base)}")
print(f"    {tests.relative_to(base)}")
print(f"    {readme.relative_to(base)}")
print()

# 18. Path comparison
print("18. Path comparison")
print("-" * 60)
path1 = Path("folder/file.txt")
path2 = Path("folder") / "file.txt"
print(f"path1: {path1}")
print(f"path2: {path2}")
print(f"Equal: {path1 == path2}")
print()

# 19. Getting file size
print("19. Getting file size")
print("-" * 60)
test_file = Path("example.txt")
if test_file.exists():
    size = test_file.stat().st_size
    print(f"{test_file.name}: {size} bytes")
else:
    print(f"{test_file} does not exist")
print()

# 20. Path with multiple extensions
print("20. Path with multiple extensions")
print("-" * 60)
path = Path("archive.tar.gz")
print(f"Path: {path}")
print(f"Suffix: {path.suffix}")  # Only last extension
print(f"Suffixes: {path.suffixes}")  # All extensions
print(f"Stem: {path.stem}")  # Without last extension
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
PATH MANIPULATION PRACTICE
============================================================

1. os.path.join()
------------------------------------------------------------
Joined path: folder/subfolder/file.txt
Absolute path: /home/user/file.txt

[... rest of output ...]
```

**Challenge** (Optional):
- Create a file organizer by extension
- Build a path validator utility
- Create a directory tree generator
- Implement a file search utility

---

## Key Takeaways

1. **`os.path`** provides traditional path functions
2. **`pathlib`** provides modern object-oriented path handling (Python 3.4+)
3. **Always use path functions** instead of string concatenation
4. **`os.path.join()`** joins path components cross-platform
5. **`Path /` operator** joins paths in pathlib
6. **`path.exists()`** checks if path exists
7. **`path.is_file()`** and `path.is_dir()`** check path type
8. **`path.parent`** gets parent directory
9. **`path.name`** gets filename, `path.stem` gets name without extension
10. **`path.suffix`** gets file extension
11. **`path.glob()`** finds files matching pattern
12. **`path.resolve()`** gets absolute normalized path
13. **Use `pathlib` for new code**, `os.path` for legacy compatibility
14. **Always check path existence** before operations
15. **Path operations are cross-platform** when using proper functions

---

## Quiz: File Paths

Test your understanding with these questions:

1. **What module provides modern path handling?**
   - A) `os.path`
   - B) `pathlib`
   - C) `filepath`
   - D) `path`

2. **What does `os.path.join()` do?**
   - A) Splits paths
   - B) Joins path components
   - C) Checks existence
   - D) Gets extension

3. **What does `Path /` operator do?**
   - A) Divides paths
   - B) Joins paths in pathlib
   - C) Splits paths
   - D) Checks equality

4. **What does `path.parent` return?**
   - A) Filename
   - B) Parent directory
   - C) Extension
   - D) Full path

5. **What does `path.stem` return?**
   - A) Filename with extension
   - B) Filename without extension
   - C) Extension only
   - D) Directory

6. **What does `path.suffix` return?**
   - A) Filename
   - B) Directory
   - C) File extension
   - D) Full path

7. **What does `path.glob()` do?**
   - A) Creates files
   - B) Finds files matching pattern
   - C) Deletes files
   - D) Moves files

8. **What does `os.path.splitext()` return?**
   - A) Single string
   - B) Tuple of (filename, extension)
   - C) List of parts
   - D) Path object

9. **What does `path.resolve()` do?**
   - A) Checks existence
   - B) Gets absolute normalized path
   - C) Gets relative path
   - D) Creates path

10. **When should you use pathlib vs os.path?**
    - A) Always use os.path
    - B) Use pathlib for new code, os.path for legacy
    - C) Always use pathlib
    - D) Never use either

**Answers**:
1. B) `pathlib` (modern path handling module)
2. B) Joins path components (cross-platform path joining)
3. B) Joins paths in pathlib (pathlib path joining operator)
4. B) Parent directory (directory containing the path)
5. B) Filename without extension (stem is name without suffix)
6. C) File extension (suffix is the extension)
7. B) Finds files matching pattern (pattern matching for files)
8. B) Tuple of (filename, extension) (splits filename and extension)
9. B) Gets absolute normalized path (resolves to absolute and normalizes)
10. B) Use pathlib for new code, os.path for legacy (pathlib is preferred for new code)

---

## Next Steps

Excellent work! You've mastered file path operations. You now understand:
- How to use `os.path` for path operations
- How to use `pathlib` for modern path handling
- How to manipulate and navigate paths
- How to work with directories and files

**What's Next?**
- Lesson 9.3: Context Managers
- Learn about the `with` statement
- Create custom context managers
- Understand resource management

---

## Additional Resources

- **pathlib**: [docs.python.org/3/library/pathlib.html](https://docs.python.org/3/library/pathlib.html)
- **os.path**: [docs.python.org/3/library/os.path.html](https://docs.python.org/3/library/os.path.html)
- **Path Objects**: [docs.python.org/3/library/pathlib.html#pathlib.Path](https://docs.python.org/3/library/pathlib.html#pathlib.Path)

---

*Lesson completed! You're ready to move on to the next lesson.*

