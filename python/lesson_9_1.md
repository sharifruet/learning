# Lesson 9.1: Reading and Writing Files

## Learning Objectives

By the end of this lesson, you will be able to:
- Open files using the `open()` function
- Read files using different methods (`read()`, `readline()`, `readlines()`)
- Write to files using `write()` and `writelines()`
- Understand different file modes
- Use context managers (`with` statement) for file handling
- Handle file errors and exceptions
- Work with text and binary files
- Close files properly
- Process file content effectively

---

## Introduction to File Handling

**File handling** is essential for reading data from and writing data to files. Python provides built-in functions and methods for file operations.

### Why File Handling?

- **Persistent storage**: Save data beyond program execution
- **Data processing**: Read and process large datasets
- **Configuration**: Read configuration files
- **Logging**: Write logs to files
- **Data exchange**: Import/export data in various formats

### File Operations

1. **Opening**: Create a file object
2. **Reading/Writing**: Perform operations
3. **Closing**: Release resources

---

## Opening Files

### The `open()` Function

The `open()` function opens a file and returns a file object:

```python
file = open("filename.txt", "r")  # Open for reading
```

### Basic Syntax

```python
open(file, mode='r', buffering=-1, encoding=None, errors=None, newline=None, closefd=True, opener=None)
```

### Simple Example

```python
# Open a file for reading
file = open("example.txt", "r")
content = file.read()
file.close()
```

---

## File Modes

### Common File Modes

| Mode | Description |
|------|-------------|
| `'r'` | Read (default) - file must exist |
| `'w'` | Write - creates file, overwrites if exists |
| `'a'` | Append - creates file, appends if exists |
| `'x'` | Exclusive creation - fails if file exists |
| `'r+'` | Read and write |
| `'w+'` | Write and read - overwrites file |
| `'a+'` | Append and read |
| `'b'` | Binary mode (e.g., `'rb'`, `'wb'`) |
| `'t'` | Text mode (default) |

### Mode Examples

```python
# Read mode (default)
file = open("data.txt", "r")
file = open("data.txt")  # Same as above

# Write mode
file = open("output.txt", "w")

# Append mode
file = open("log.txt", "a")

# Binary mode
file = open("image.jpg", "rb")

# Read and write
file = open("data.txt", "r+")
```

---

## Reading Files

### `read()` Method

Reads the entire file content:

```python
file = open("example.txt", "r")
content = file.read()
print(content)
file.close()
```

### `read()` with Size

Reads specified number of characters:

```python
file = open("example.txt", "r")
first_100 = file.read(100)  # Read first 100 characters
rest = file.read()  # Read remaining content
file.close()
```

### `readline()` Method

Reads one line at a time:

```python
file = open("example.txt", "r")
line1 = file.readline()  # First line
line2 = file.readline()   # Second line
file.close()
```

### `readlines()` Method

Reads all lines into a list:

```python
file = open("example.txt", "r")
lines = file.readlines()  # Returns list of lines
file.close()

for line in lines:
    print(line.strip())  # strip() removes newline
```

### Iterating Over File

Files are iterable - you can loop directly:

```python
file = open("example.txt", "r")
for line in file:
    print(line.strip())
file.close()
```

### Complete Reading Example

```python
# Method 1: read() - entire file
with open("example.txt", "r") as file:
    content = file.read()
    print("Entire file:")
    print(content)

# Method 2: readline() - one line at a time
with open("example.txt", "r") as file:
    print("\nLine by line:")
    line = file.readline()
    while line:
        print(line.strip())
        line = file.readline()

# Method 3: readlines() - all lines as list
with open("example.txt", "r") as file:
    print("\nAll lines:")
    lines = file.readlines()
    for line in lines:
        print(line.strip())

# Method 4: Iterate directly
with open("example.txt", "r") as file:
    print("\nIterating:")
    for line in file:
        print(line.strip())
```

---

## Writing Files

### `write()` Method

Writes a string to the file:

```python
file = open("output.txt", "w")
file.write("Hello, World!\n")
file.write("This is a new line.\n")
file.close()
```

### `writelines()` Method

Writes a list of strings:

```python
lines = ["Line 1\n", "Line 2\n", "Line 3\n"]
file = open("output.txt", "w")
file.writelines(lines)
file.close()
```

### Writing Example

```python
# Write single string
with open("output.txt", "w") as file:
    file.write("Hello, World!\n")
    file.write("Python is great!\n")

# Write multiple lines
lines = ["First line\n", "Second line\n", "Third line\n"]
with open("output.txt", "w") as file:
    file.writelines(lines)

# Write formatted content
with open("output.txt", "w") as file:
    name = "Alice"
    age = 30
    file.write(f"Name: {name}\n")
    file.write(f"Age: {age}\n")
```

---

## The `with` Statement (Context Manager)

The `with` statement automatically closes files, even if an error occurs.

### Without `with` Statement

```python
file = open("example.txt", "r")
content = file.read()
file.close()  # Must remember to close
```

### With `with` Statement

```python
with open("example.txt", "r") as file:
    content = file.read()
# File automatically closed here
```

### Benefits of `with` Statement

1. **Automatic closing**: File closed even if error occurs
2. **Cleaner code**: No need to remember `close()`
3. **Exception handling**: Handles errors gracefully
4. **Best practice**: Recommended way to work with files

### Examples with `with`

```python
# Reading
with open("example.txt", "r") as file:
    content = file.read()
    print(content)

# Writing
with open("output.txt", "w") as file:
    file.write("Hello, World!\n")

# Multiple operations
with open("data.txt", "r") as input_file:
    content = input_file.read()
    with open("output.txt", "w") as output_file:
        output_file.write(content.upper())
```

---

## File Modes in Detail

### Read Mode (`'r'`)

```python
# File must exist
with open("example.txt", "r") as file:
    content = file.read()

# Error if file doesn't exist
# FileNotFoundError: [Errno 2] No such file or directory: 'nonexistent.txt'
```

### Write Mode (`'w'`)

```python
# Creates file if doesn't exist
# Overwrites if exists
with open("output.txt", "w") as file:
    file.write("New content\n")
```

### Append Mode (`'a'`)

```python
# Creates file if doesn't exist
# Appends to end if exists
with open("log.txt", "a") as file:
    file.write("New log entry\n")
```

### Exclusive Creation (`'x'`)

```python
# Creates file only if doesn't exist
# Fails if file exists
with open("newfile.txt", "x") as file:
    file.write("Content\n")

# FileExistsError if file already exists
```

### Read and Write (`'r+'`)

```python
# File must exist
# Can read and write
with open("data.txt", "r+") as file:
    content = file.read()
    file.write("Additional content\n")
```

### Binary Mode

```python
# Read binary file
with open("image.jpg", "rb") as file:
    data = file.read()

# Write binary file
with open("copy.jpg", "wb") as file:
    file.write(data)
```

---

## Handling File Errors

### FileNotFoundError

```python
try:
    with open("nonexistent.txt", "r") as file:
        content = file.read()
except FileNotFoundError:
    print("File not found!")
```

### PermissionError

```python
try:
    with open("/etc/passwd", "w") as file:
        file.write("test")
except PermissionError:
    print("Permission denied!")
```

### General Exception Handling

```python
try:
    with open("example.txt", "r") as file:
        content = file.read()
except FileNotFoundError:
    print("File not found!")
except PermissionError:
    print("Permission denied!")
except Exception as e:
    print(f"Error: {e}")
```

---

## Practical Examples

### Example 1: Reading Configuration File

```python
config = {}
with open("config.txt", "r") as file:
    for line in file:
        line = line.strip()
        if line and not line.startswith("#"):  # Skip empty lines and comments
            key, value = line.split("=")
            config[key.strip()] = value.strip()

print(config)
```

### Example 2: Writing Log File

```python
from datetime import datetime

def log_message(message):
    with open("app.log", "a") as file:
        timestamp = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
        file.write(f"[{timestamp}] {message}\n")

log_message("Application started")
log_message("Processing data")
log_message("Application finished")
```

### Example 3: Copying File

```python
# Copy text file
with open("source.txt", "r") as source:
    content = source.read()
    with open("destination.txt", "w") as dest:
        dest.write(content)

# Copy binary file
with open("source.jpg", "rb") as source:
    data = source.read()
    with open("destination.jpg", "wb") as dest:
        dest.write(data)
```

### Example 4: Processing CSV-like Data

```python
data = []
with open("data.txt", "r") as file:
    for line in file:
        line = line.strip()
        if line:
            fields = line.split(",")
            data.append(fields)

for row in data:
    print(row)
```

### Example 5: Reading and Modifying

```python
# Read, modify, write back
with open("data.txt", "r") as file:
    lines = file.readlines()

# Modify lines
modified_lines = []
for line in lines:
    modified_lines.append(line.upper())

# Write back
with open("data.txt", "w") as file:
    file.writelines(modified_lines)
```

---

## Text vs Binary Files

### Text Files

```python
# Text mode (default)
with open("text.txt", "r") as file:  # 'rt' is default
    content = file.read()  # Returns string

with open("text.txt", "w") as file:
    file.write("Hello, World!")  # Writes string
```

### Binary Files

```python
# Binary mode
with open("image.jpg", "rb") as file:
    data = file.read()  # Returns bytes

with open("copy.jpg", "wb") as file:
    file.write(data)  # Writes bytes
```

### When to Use Binary Mode

- Images (jpg, png, gif)
- Videos, audio files
- Executable files
- Compressed files (zip, etc.)
- Any non-text data

---

## File Position

### `tell()` Method

Returns current file position:

```python
with open("example.txt", "r") as file:
    print(file.tell())  # 0 (start)
    file.read(10)
    print(file.tell())  # 10 (after reading 10 chars)
```

### `seek()` Method

Changes file position:

```python
with open("example.txt", "r") as file:
    file.seek(10)  # Move to position 10
    content = file.read()
```

### Seek Modes

```python
# seek(offset, whence)
# whence: 0 (start), 1 (current), 2 (end)

file.seek(0)      # Go to start
file.seek(0, 2)   # Go to end
file.seek(10, 1)  # Move 10 bytes from current position
```

---

## Common Mistakes and Pitfalls

### 1. Forgetting to Close File

```python
# WRONG
file = open("example.txt", "r")
content = file.read()
# Forgot to close!

# CORRECT
with open("example.txt", "r") as file:
    content = file.read()
# Automatically closed
```

### 2. Opening Non-Existent File in Read Mode

```python
# WRONG: No error handling
file = open("nonexistent.txt", "r")

# CORRECT: Handle error
try:
    with open("nonexistent.txt", "r") as file:
        content = file.read()
except FileNotFoundError:
    print("File not found!")
```

### 3. Not Handling Encoding

```python
# May fail with special characters
with open("file.txt", "r") as file:
    content = file.read()

# Better: Specify encoding
with open("file.txt", "r", encoding="utf-8") as file:
    content = file.read()
```

### 4. Overwriting File Accidentally

```python
# WRONG: 'w' mode overwrites
with open("important.txt", "w") as file:
    file.write("New content")  # Old content lost!

# BETTER: Use 'a' for append or check first
import os
if os.path.exists("important.txt"):
    # Handle existing file
    pass
```

---

## Best Practices

### 1. Always Use `with` Statement

```python
# Good
with open("file.txt", "r") as file:
    content = file.read()

# Avoid
file = open("file.txt", "r")
content = file.read()
file.close()
```

### 2. Handle Exceptions

```python
try:
    with open("file.txt", "r") as file:
        content = file.read()
except FileNotFoundError:
    print("File not found!")
except Exception as e:
    print(f"Error: {e}")
```

### 3. Specify Encoding

```python
# Good: Explicit encoding
with open("file.txt", "r", encoding="utf-8") as file:
    content = file.read()
```

### 4. Use Appropriate Mode

```python
# Read: 'r'
# Write (overwrite): 'w'
# Append: 'a'
# Binary: 'rb', 'wb'
```

### 5. Process Files Line by Line for Large Files

```python
# Good for large files
with open("large_file.txt", "r") as file:
    for line in file:
        process(line)  # Process one line at a time

# Avoid for large files
with open("large_file.txt", "r") as file:
    content = file.read()  # Loads entire file into memory
```

---

## Practice Exercise

### Exercise: File Operations

**Objective**: Create a Python program that demonstrates various file operations.

**Instructions**:

1. Create a file called `file_operations_practice.py`

2. Write a program that:
   - Reads files using different methods
   - Writes to files
   - Demonstrates different file modes
   - Uses context managers
   - Handles file errors

3. Your program should include:
   - Reading entire file
   - Reading line by line
   - Writing to files
   - Appending to files
   - Error handling
   - File copying

**Example Solution**:

```python
"""
File Operations Practice
This program demonstrates various file operations in Python.
"""

import os

print("=" * 60)
print("FILE OPERATIONS PRACTICE")
print("=" * 60)
print()

# 1. Writing to a file
print("1. WRITING TO A FILE")
print("-" * 60)
with open("example.txt", "w") as file:
    file.write("Line 1\n")
    file.write("Line 2\n")
    file.write("Line 3\n")
print("Created example.txt with 3 lines")
print()

# 2. Reading entire file with read()
print("2. READING ENTIRE FILE WITH read()")
print("-" * 60)
with open("example.txt", "r") as file:
    content = file.read()
    print("Entire content:")
    print(content)
print()

# 3. Reading line by line with readline()
print("3. READING LINE BY LINE WITH readline()")
print("-" * 60)
with open("example.txt", "r") as file:
    print("Line by line:")
    line = file.readline()
    line_num = 1
    while line:
        print(f"  Line {line_num}: {line.strip()}")
        line = file.readline()
        line_num += 1
print()

# 4. Reading all lines with readlines()
print("4. READING ALL LINES WITH readlines()")
print("-" * 60)
with open("example.txt", "r") as file:
    lines = file.readlines()
    print(f"Total lines: {len(lines)}")
    for i, line in enumerate(lines, 1):
        print(f"  Line {i}: {line.strip()}")
print()

# 5. Iterating over file
print("5. ITERATING OVER FILE")
print("-" * 60)
with open("example.txt", "r") as file:
    print("Iterating:")
    for i, line in enumerate(file, 1):
        print(f"  Line {i}: {line.strip()}")
print()

# 6. Appending to file
print("6. APPENDING TO FILE")
print("-" * 60)
with open("example.txt", "a") as file:
    file.write("Line 4 (appended)\n")
    file.write("Line 5 (appended)\n")
print("Appended 2 lines to example.txt")
print()

# 7. Reading after append
print("7. READING AFTER APPEND")
print("-" * 60)
with open("example.txt", "r") as file:
    print("Updated content:")
    for line in file:
        print(f"  {line.strip()}")
print()

# 8. Writing multiple lines with writelines()
print("8. WRITING MULTIPLE LINES WITH writelines()")
print("-" * 60)
lines = ["First line\n", "Second line\n", "Third line\n"]
with open("output.txt", "w") as file:
    file.writelines(lines)
print("Created output.txt with writelines()")
print()

# 9. File modes demonstration
print("9. FILE MODES DEMONSTRATION")
print("-" * 60)
# Write mode (overwrites)
with open("modes_test.txt", "w") as file:
    file.write("Original content\n")

# Append mode
with open("modes_test.txt", "a") as file:
    file.write("Appended content\n")

# Read mode
with open("modes_test.txt", "r") as file:
    content = file.read()
    print("Content after write and append:")
    print(content)
print()

# 10. Error handling
print("10. ERROR HANDLING")
print("-" * 60)
try:
    with open("nonexistent.txt", "r") as file:
        content = file.read()
except FileNotFoundError:
    print("FileNotFoundError: File not found (expected)")
except Exception as e:
    print(f"Error: {e}")
print()

# 11. File position (tell and seek)
print("11. FILE POSITION (tell and seek)")
print("-" * 60)
with open("example.txt", "r") as file:
    print(f"Initial position: {file.tell()}")
    file.read(5)
    print(f"After reading 5 chars: {file.tell()}")
    file.seek(0)
    print(f"After seek(0): {file.tell()}")
    content = file.read(10)
    print(f"Content at start: {content}")
print()

# 12. Copying file
print("12. COPYING FILE")
print("-" * 60)
# Read source
with open("example.txt", "r") as source:
    content = source.read()

# Write to destination
with open("example_copy.txt", "w") as dest:
    dest.write(content)

print("Copied example.txt to example_copy.txt")

# Verify copy
with open("example_copy.txt", "r") as file:
    print("Copy content:")
    print(file.read())
print()

# 13. Processing file content
print("13. PROCESSING FILE CONTENT")
print("-" * 60)
with open("example.txt", "r") as file:
    lines = file.readlines()

# Process: convert to uppercase
processed_lines = [line.upper() for line in lines]

# Write processed content
with open("example_uppercase.txt", "w") as file:
    file.writelines(processed_lines)

print("Created example_uppercase.txt with uppercase content")
print()

# 14. Reading with encoding
print("14. READING WITH ENCODING")
print("-" * 60)
with open("example.txt", "r", encoding="utf-8") as file:
    content = file.read()
    print("Read with UTF-8 encoding")
    print(f"Content length: {len(content)} characters")
print()

# 15. Writing formatted content
print("15. WRITING FORMATTED CONTENT")
print("-" * 60)
data = [
    {"name": "Alice", "age": 30, "city": "New York"},
    {"name": "Bob", "age": 25, "city": "London"},
    {"name": "Charlie", "age": 35, "city": "Tokyo"}
]

with open("formatted.txt", "w") as file:
    for person in data:
        file.write(f"Name: {person['name']}, Age: {person['age']}, City: {person['city']}\n")

print("Created formatted.txt with structured data")
with open("formatted.txt", "r") as file:
    print(file.read())
print()

# Cleanup
print("Cleaning up test files...")
test_files = ["output.txt", "modes_test.txt", "example_copy.txt", 
              "example_uppercase.txt", "formatted.txt"]
for filename in test_files:
    if os.path.exists(filename):
        os.remove(filename)
        print(f"Removed {filename}")

print()
print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
FILE OPERATIONS PRACTICE
============================================================

1. WRITING TO A FILE
------------------------------------------------------------
Created example.txt with 3 lines

[... rest of output ...]
```

**Challenge** (Optional):
- Create a log file rotation system
- Build a configuration file parser
- Implement a file search utility
- Create a text file statistics tool

---

## Key Takeaways

1. **`open()` function** opens files and returns file objects
2. **File modes**: `'r'` (read), `'w'` (write), `'a'` (append), `'b'` (binary)
3. **Reading methods**: `read()`, `readline()`, `readlines()`, or iterate directly
4. **Writing methods**: `write()` for strings, `writelines()` for lists
5. **`with` statement** automatically closes files (best practice)
6. **Always close files** or use `with` statement
7. **Handle exceptions** (FileNotFoundError, PermissionError, etc.)
8. **Specify encoding** (UTF-8) for text files with special characters
9. **Use appropriate mode** for your operation
10. **Process large files** line by line to avoid memory issues
11. **Binary mode** (`'rb'`, `'wb'`) for non-text files
12. **File position** can be controlled with `seek()` and `tell()`

---

## Quiz: File Basics

Test your understanding with these questions:

1. **What function opens a file?**
   - A) `file()`
   - B) `open()`
   - C) `read()`
   - D) `write()`

2. **What is the default file mode?**
   - A) `'w'`
   - B) `'a'`
   - C) `'r'`
   - D) `'x'`

3. **What does `'w'` mode do?**
   - A) Read file
   - B) Write file (overwrites if exists)
   - C) Append to file
   - D) Read and write

4. **What method reads the entire file?**
   - A) `readline()`
   - B) `readlines()`
   - C) `read()`
   - D) `readall()`

5. **What does `readline()` do?**
   - A) Reads entire file
   - B) Reads one line
   - C) Reads all lines
   - D) Reads bytes

6. **What is the best way to ensure files are closed?**
   - A) Manual `close()`
   - B) `with` statement
   - C) `finally` block
   - D) Don't close

7. **What mode is used for binary files?**
   - A) `'t'`
   - B) `'b'`
   - C) `'x'`
   - D) `'r'`

8. **What does `'a'` mode do?**
   - A) Read file
   - B) Write file (overwrites)
   - C) Append to file
   - D) Read and write

9. **What exception is raised if file doesn't exist in read mode?**
   - A) `IOError`
   - B) `FileNotFoundError`
   - C) `FileError`
   - D) `NotFoundError`

10. **What method writes a list of strings?**
    - A) `write()`
    - B) `writelines()`
    - C) `writeall()`
    - D) `writemany()`

**Answers**:
1. B) `open()` (function to open files)
2. C) `'r'` (read mode is default)
3. B) Write file (overwrites if exists) (`'w'` mode behavior)
4. C) `read()` (reads entire file content)
5. B) Reads one line (`readline()` reads single line)
6. B) `with` statement (automatically closes files)
7. B) `'b'` (binary mode for non-text files)
8. C) Append to file (`'a'` mode appends)
9. B) `FileNotFoundError` (raised when file doesn't exist)
10. B) `writelines()` (writes list of strings to file)

---

## Next Steps

Excellent work! You've mastered file reading and writing. You now understand:
- How to open files with different modes
- How to read files using various methods
- How to write to files
- How to use context managers
- How to handle file errors

**What's Next?**
- Lesson 9.2: Working with File Paths
- Learn about path manipulation
- Understand `pathlib` module
- Explore directory operations

---

## Additional Resources

- **File Objects**: [docs.python.org/3/glossary.html#term-file-object](https://docs.python.org/3/glossary.html#term-file-object)
- **open() Function**: [docs.python.org/3/library/functions.html#open](https://docs.python.org/3/library/functions.html#open)
- **File Handling Tutorial**: [docs.python.org/3/tutorial/inputoutput.html#reading-and-writing-files](https://docs.python.org/3/tutorial/inputoutput.html#reading-and-writing-files)

---

*Lesson completed! You're ready to move on to the next lesson.*

