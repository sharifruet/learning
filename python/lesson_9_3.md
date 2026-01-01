# Lesson 9.3: Context Managers

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the `with` statement and context managers
- Use built-in context managers (files, locks, etc.)
- Create custom context managers using classes
- Create context managers using `contextlib`
- Understand the context manager protocol (`__enter__` and `__exit__`)
- Handle exceptions in context managers
- Use context managers for resource management
- Apply context managers in practical scenarios
- Understand when and why to use context managers

---

## Introduction to Context Managers

**Context managers** are objects that define what happens when entering and exiting a context (using the `with` statement). They ensure proper resource management and cleanup.

### Why Context Managers?

- **Automatic cleanup**: Resources are released automatically
- **Exception safety**: Cleanup happens even if errors occur
- **Cleaner code**: No need for try/finally blocks
- **Resource management**: Ensures resources are properly managed

### Common Use Cases

- File operations (automatic closing)
- Database connections
- Locks and synchronization
- Temporary changes (environment variables, etc.)
- Resource allocation/deallocation

---

## The `with` Statement

The `with` statement is used to enter a context managed by a context manager.

### Basic Syntax

```python
with context_manager as variable:
    # Code block
    # Resource is available here
# Resource is automatically cleaned up here
```

### File Example (Built-in Context Manager)

```python
# Files are context managers
with open("file.txt", "r") as file:
    content = file.read()
    # File is automatically closed here, even if error occurs
```

### Without Context Manager

```python
# Manual management
file = open("file.txt", "r")
try:
    content = file.read()
finally:
    file.close()  # Must remember to close
```

### With Context Manager

```python
# Automatic management
with open("file.txt", "r") as file:
    content = file.read()
# Automatically closed
```

---

## Built-in Context Managers

### Files

```python
# Reading
with open("file.txt", "r") as file:
    content = file.read()

# Writing
with open("file.txt", "w") as file:
    file.write("Hello, World!")

# Multiple files
with open("input.txt", "r") as infile, open("output.txt", "w") as outfile:
    content = infile.read()
    outfile.write(content.upper())
```

### Locks (threading)

```python
import threading

lock = threading.Lock()

with lock:
    # Critical section
    # Only one thread can execute this at a time
    shared_resource += 1
# Lock automatically released
```

### Decimal Context

```python
from decimal import Decimal, localcontext

with localcontext() as ctx:
    ctx.prec = 50  # Set precision
    result = Decimal(1) / Decimal(3)
    print(result)  # High precision
# Precision restored
```

---

## Creating Custom Context Managers

### Using Classes

Context managers can be created using classes that implement `__enter__` and `__exit__` methods.

### Basic Context Manager Class

```python
class MyContextManager:
    def __enter__(self):
        # Setup code
        print("Entering context")
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        # Cleanup code
        print("Exiting context")
        return False  # Don't suppress exceptions

# Use it
with MyContextManager() as cm:
    print("Inside context")
# Output:
# Entering context
# Inside context
# Exiting context
```

### Understanding `__enter__` and `__exit__`

```python
class MyContextManager:
    def __enter__(self):
        # Called when entering 'with' block
        # Return value is assigned to variable after 'as'
        print("Entering")
        return "context_value"
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        # Called when exiting 'with' block
        # exc_type: exception type (None if no exception)
        # exc_val: exception value
        # exc_tb: traceback
        # Return True to suppress exception, False to propagate
        print("Exiting")
        return False

with MyContextManager() as value:
    print(f"Value: {value}")
```

### Example: Timer Context Manager

```python
import time

class Timer:
    def __init__(self, description="Operation"):
        self.description = description
        self.start_time = None
    
    def __enter__(self):
        self.start_time = time.time()
        print(f"Starting {self.description}...")
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        elapsed = time.time() - self.start_time
        print(f"{self.description} took {elapsed:.2f} seconds")
        return False

# Use it
with Timer("Data processing"):
    time.sleep(1)  # Simulate work
    # Processing code here
```

### Example: File Writer Context Manager

```python
class FileWriter:
    def __init__(self, filename, mode="w"):
        self.filename = filename
        self.mode = mode
        self.file = None
    
    def __enter__(self):
        self.file = open(self.filename, self.mode)
        return self.file
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if self.file:
            self.file.close()
        return False

# Use it
with FileWriter("output.txt") as file:
    file.write("Hello, World!")
# File automatically closed
```

### Example: Change Directory Context Manager

```python
import os

class ChangeDirectory:
    def __init__(self, new_dir):
        self.new_dir = new_dir
        self.old_dir = None
    
    def __enter__(self):
        self.old_dir = os.getcwd()
        os.chdir(self.new_dir)
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        os.chdir(self.old_dir)
        return False

# Use it
with ChangeDirectory("/tmp"):
    print(f"Current directory: {os.getcwd()}")
# Directory restored
```

### Exception Handling in Context Managers

```python
class SuppressExceptions:
    def __enter__(self):
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        # Return True to suppress exception
        if exc_type is ValueError:
            print(f"Suppressed ValueError: {exc_val}")
            return True  # Suppress this exception
        return False  # Let other exceptions propagate

# Use it
with SuppressExceptions():
    raise ValueError("This will be suppressed")

# This will raise
with SuppressExceptions():
    raise TypeError("This will propagate")
```

---

## The `contextlib` Module

The `contextlib` module provides utilities for creating context managers.

### `@contextmanager` Decorator

The easiest way to create a context manager:

```python
from contextlib import contextmanager

@contextmanager
def my_context_manager():
    # Setup code (before yield)
    print("Entering")
    try:
        yield "value"  # Value returned to 'as' variable
    finally:
        # Cleanup code (after yield)
        print("Exiting")

# Use it
with my_context_manager() as value:
    print(f"Value: {value}")
```

### Example: Timer with `@contextmanager`

```python
from contextlib import contextmanager
import time

@contextmanager
def timer(description="Operation"):
    start = time.time()
    print(f"Starting {description}...")
    try:
        yield
    finally:
        elapsed = time.time() - start
        print(f"{description} took {elapsed:.2f} seconds")

# Use it
with timer("Data processing"):
    time.sleep(1)
```

### Example: File Writer with `@contextmanager`

```python
from contextlib import contextmanager

@contextmanager
def file_writer(filename, mode="w"):
    file = open(filename, mode)
    try:
        yield file
    finally:
        file.close()

# Use it
with file_writer("output.txt") as file:
    file.write("Hello, World!")
```

### `contextlib.suppress()`

Suppress specific exceptions:

```python
from contextlib import suppress

# Suppress FileNotFoundError
with suppress(FileNotFoundError):
    os.remove("nonexistent.txt")
    print("File removed")  # Won't print if file doesn't exist

# Suppress multiple exceptions
with suppress(FileNotFoundError, PermissionError):
    os.remove("file.txt")
```

### `contextlib.redirect_stdout()` and `redirect_stderr()`

Redirect output:

```python
from contextlib import redirect_stdout
import io

# Redirect stdout to string
f = io.StringIO()
with redirect_stdout(f):
    print("This goes to string")
    print("Not to console")

output = f.getvalue()
print(f"Captured: {output}")
```

### `contextlib.ExitStack()`

Manage multiple context managers:

```python
from contextlib import ExitStack

files = ["file1.txt", "file2.txt", "file3.txt"]

with ExitStack() as stack:
    file_handles = [stack.enter_context(open(f, "w")) for f in files]
    # All files are open
    for file in file_handles:
        file.write("Content\n")
# All files are automatically closed
```

### `contextlib.closing()`

Make objects with `close()` method work as context managers:

```python
from contextlib import closing
from urllib.request import urlopen

with closing(urlopen("https://example.com")) as page:
    content = page.read()
# page.close() automatically called
```

---

## Practical Examples

### Example 1: Database Connection

```python
class DatabaseConnection:
    def __init__(self, connection_string):
        self.connection_string = connection_string
        self.connection = None
    
    def __enter__(self):
        # Connect to database
        self.connection = connect(self.connection_string)
        return self.connection
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        # Close connection
        if self.connection:
            self.connection.close()
        return False

# Use it
with DatabaseConnection("db://localhost") as db:
    db.execute("SELECT * FROM users")
```

### Example 2: Temporary Environment Variables

```python
import os
from contextlib import contextmanager

@contextmanager
def set_env(**env_vars):
    """Temporarily set environment variables."""
    old_values = {}
    try:
        # Save old values
        for key, value in env_vars.items():
            old_values[key] = os.environ.get(key)
            os.environ[key] = value
        yield
    finally:
        # Restore old values
        for key, value in old_values.items():
            if value is None:
                os.environ.pop(key, None)
            else:
                os.environ[key] = value

# Use it
with set_env(PATH="/custom/path", DEBUG="1"):
    print(os.environ["PATH"])
# Environment variables restored
```

### Example 3: Lock with Timeout

```python
import threading
import time

class TimeoutLock:
    def __init__(self, timeout=5):
        self.lock = threading.Lock()
        self.timeout = timeout
    
    def __enter__(self):
        acquired = self.lock.acquire(timeout=self.timeout)
        if not acquired:
            raise TimeoutError("Could not acquire lock within timeout")
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        self.lock.release()
        return False

# Use it
with TimeoutLock(timeout=2):
    # Critical section
    time.sleep(1)
```

### Example 4: Logging Context

```python
import logging
from contextlib import contextmanager

@contextmanager
def log_context(operation_name):
    logger = logging.getLogger(__name__)
    logger.info(f"Starting {operation_name}")
    try:
        yield
        logger.info(f"Completed {operation_name}")
    except Exception as e:
        logger.error(f"Error in {operation_name}: {e}")
        raise

# Use it
with log_context("data_processing"):
    # Processing code
    process_data()
```

### Example 5: Resource Pool

```python
class ResourcePool:
    def __init__(self, max_resources=5):
        self.max_resources = max_resources
        self.available = list(range(max_resources))
        self.in_use = set()
        self.lock = threading.Lock()
    
    def __enter__(self):
        with self.lock:
            if not self.available:
                raise RuntimeError("No resources available")
            resource = self.available.pop()
            self.in_use.add(resource)
            return resource
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        with self.lock:
            # Return resource to pool
            resource = self.in_use.pop()
            self.available.append(resource)
        return False

# Use it
pool = ResourcePool(max_resources=3)

with pool as resource:
    print(f"Using resource {resource}")
    # Use resource
# Resource returned to pool
```

---

## Nested Context Managers

### Multiple Context Managers

```python
# Multiple context managers
with open("input.txt", "r") as infile, open("output.txt", "w") as outfile:
    content = infile.read()
    outfile.write(content.upper())

# Nested context managers
with open("input.txt", "r") as infile:
    with open("output.txt", "w") as outfile:
        content = infile.read()
        outfile.write(content.upper())
```

### Custom Nested Context

```python
@contextmanager
def timer(description):
    start = time.time()
    print(f"Starting {description}")
    try:
        yield
    finally:
        elapsed = time.time() - start
        print(f"{description} took {elapsed:.2f}s")

@contextmanager
def log_operation(name):
    print(f"Operation: {name}")
    try:
        yield
    finally:
        print(f"Completed: {name}")

# Nested
with timer("Processing"):
    with log_operation("Data load"):
        # Code here
        pass
```

---

## Common Mistakes and Pitfalls

### 1. Not Using `with` Statement

```python
# WRONG: Manual management
file = open("file.txt", "r")
content = file.read()
file.close()  # Might forget or error might occur

# CORRECT: Use context manager
with open("file.txt", "r") as file:
    content = file.read()
```

### 2. Returning Wrong Value from `__enter__`

```python
# WRONG: Not returning useful value
class BadContext:
    def __enter__(self):
        self.resource = acquire_resource()
        # Forgot to return!
    
    def __exit__(self, *args):
        release_resource(self.resource)

# CORRECT: Return useful value
class GoodContext:
    def __enter__(self):
        self.resource = acquire_resource()
        return self.resource  # Return resource
    
    def __exit__(self, *args):
        release_resource(self.resource)
```

### 3. Not Handling Exceptions in `__exit__`

```python
# WRONG: Exception in cleanup
class BadContext:
    def __exit__(self, exc_type, exc_val, exc_tb):
        cleanup()  # Might raise exception, masking original

# CORRECT: Handle exceptions in cleanup
class GoodContext:
    def __exit__(self, exc_type, exc_val, exc_tb):
        try:
            cleanup()
        except Exception:
            pass  # Log but don't raise
        return False  # Don't suppress original exception
```

### 4. Forgetting `finally` in `@contextmanager`

```python
# WRONG: Cleanup might not run if exception occurs
@contextmanager
def bad_context():
    setup()
    yield
    cleanup()  # Won't run if exception in yield block

# CORRECT: Use try/finally
@contextmanager
def good_context():
    setup()
    try:
        yield
    finally:
        cleanup()  # Always runs
```

---

## Best Practices

### 1. Always Use `with` for Resources

```python
# Good: Automatic cleanup
with open("file.txt", "r") as file:
    content = file.read()
```

### 2. Use `@contextmanager` for Simple Cases

```python
# Good: Simple and readable
@contextmanager
def timer(description):
    start = time.time()
    try:
        yield
    finally:
        print(f"{description} took {time.time() - start:.2f}s")
```

### 3. Use Classes for Complex Context Managers

```python
# Good: Complex logic in class
class DatabaseConnection:
    def __init__(self, connection_string):
        self.connection_string = connection_string
    
    def __enter__(self):
        # Complex setup
        return self
    
    def __exit__(self, *args):
        # Complex cleanup
        pass
```

### 4. Handle Exceptions Properly

```python
# Good: Don't suppress exceptions unless intended
def __exit__(self, exc_type, exc_val, exc_tb):
    cleanup()
    return False  # Let exceptions propagate
```

### 5. Document Context Manager Behavior

```python
class MyContextManager:
    """Context manager that does X.
    
    Ensures Y is cleaned up properly.
    """
    def __enter__(self):
        """Setup and return resource."""
        pass
    
    def __exit__(self, *args):
        """Cleanup resources."""
        pass
```

---

## Practice Exercise

### Exercise: Context Managers

**Objective**: Create a Python program that demonstrates context managers.

**Instructions**:

1. Create a file called `context_managers_practice.py`

2. Write a program that:
   - Uses built-in context managers
   - Creates custom context managers with classes
   - Creates context managers with `@contextmanager`
   - Demonstrates exception handling
   - Shows practical applications

3. Your program should include:
   - File context managers
   - Timer context manager
   - Custom resource managers
   - Exception suppression
   - Nested context managers

**Example Solution**:

```python
"""
Context Managers Practice
This program demonstrates context managers in Python.
"""

import time
import os
import threading
from contextlib import contextmanager, suppress, redirect_stdout
import io

print("=" * 60)
print("CONTEXT MANAGERS PRACTICE")
print("=" * 60)
print()

# 1. Built-in file context manager
print("1. BUILT-IN FILE CONTEXT MANAGER")
print("-" * 60)
with open("test_file.txt", "w") as file:
    file.write("Hello, World!\n")
    file.write("This is a test file.\n")
print("Created test_file.txt")

with open("test_file.txt", "r") as file:
    content = file.read()
    print(f"Content:\n{content}")
print()

# 2. Multiple file context managers
print("2. MULTIPLE FILE CONTEXT MANAGERS")
print("-" * 60)
with open("input.txt", "w") as infile:
    infile.write("Original content")

with open("input.txt", "r") as infile, open("output.txt", "w") as outfile:
    content = infile.read()
    outfile.write(content.upper())
print("Copied and converted to uppercase")
print()

# 3. Timer context manager (class-based)
print("3. TIMER CONTEXT MANAGER (CLASS-BASED)")
print("-" * 60)
class Timer:
    def __init__(self, description="Operation"):
        self.description = description
        self.start_time = None
    
    def __enter__(self):
        self.start_time = time.time()
        print(f"Starting {self.description}...")
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        elapsed = time.time() - self.start_time
        print(f"{self.description} took {elapsed:.2f} seconds")
        return False

with Timer("Data processing"):
    time.sleep(0.5)  # Simulate work
print()

# 4. Timer with @contextmanager
print("4. TIMER WITH @contextmanager")
print("-" * 60)
@contextmanager
def timer(description="Operation"):
    start = time.time()
    print(f"Starting {description}...")
    try:
        yield
    finally:
        elapsed = time.time() - start
        print(f"{description} took {elapsed:.2f} seconds")

with timer("Computation"):
    time.sleep(0.3)
print()

# 5. Change directory context manager
print("5. CHANGE DIRECTORY CONTEXT MANAGER")
print("-" * 60)
class ChangeDirectory:
    def __init__(self, new_dir):
        self.new_dir = new_dir
        self.old_dir = None
    
    def __enter__(self):
        self.old_dir = os.getcwd()
        os.chdir(self.new_dir)
        print(f"Changed to: {os.getcwd()}")
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        os.chdir(self.old_dir)
        print(f"Restored to: {os.getcwd()}")
        return False

original_dir = os.getcwd()
with ChangeDirectory("/tmp"):
    print(f"Inside context: {os.getcwd()}")
print(f"After context: {os.getcwd()}")
print()

# 6. Exception suppression
print("6. EXCEPTION SUPPRESSION")
print("-" * 60)
class SuppressExceptions:
    def __init__(self, *exceptions):
        self.exceptions = exceptions
    
    def __enter__(self):
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if exc_type in self.exceptions:
            print(f"Suppressed {exc_type.__name__}: {exc_val}")
            return True  # Suppress exception
        return False  # Let other exceptions propagate

with SuppressExceptions(ValueError):
    raise ValueError("This will be suppressed")

print("After suppressed exception")
print()

# 7. Using contextlib.suppress()
print("7. USING contextlib.suppress()")
print("-" * 60)
with suppress(FileNotFoundError):
    os.remove("nonexistent.txt")
    print("File removed")
print("After suppress (file didn't exist, but no error)")
print()

# 8. Redirect stdout
print("8. REDIRECT STDOUT")
print("-" * 60)
f = io.StringIO()
with redirect_stdout(f):
    print("This goes to string")
    print("Not to console")

output = f.getvalue()
print(f"Captured output: {output}")
print()

# 9. Lock context manager
print("9. LOCK CONTEXT MANAGER")
print("-" * 60)
lock = threading.Lock()
shared_counter = 0

def increment():
    global shared_counter
    with lock:
        current = shared_counter
        time.sleep(0.01)  # Simulate work
        shared_counter = current + 1

# Without lock (race condition)
shared_counter = 0
threads = [threading.Thread(target=increment) for _ in range(10)]
for t in threads:
    t.start()
for t in threads:
    t.join()
print(f"Counter with lock: {shared_counter}")
print()

# 10. Resource manager
print("10. RESOURCE MANAGER")
print("-" * 60)
class ResourceManager:
    def __init__(self, resource_name):
        self.resource_name = resource_name
        self.resource = None
    
    def __enter__(self):
        print(f"Acquiring {self.resource_name}")
        self.resource = f"Resource: {self.resource_name}"
        return self.resource
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        print(f"Releasing {self.resource_name}")
        self.resource = None
        return False

with ResourceManager("Database Connection") as resource:
    print(f"Using {resource}")
print()

# 11. Nested context managers
print("11. NESTED CONTEXT MANAGERS")
print("-" * 60)
@contextmanager
def log_operation(name):
    print(f"Starting operation: {name}")
    try:
        yield
    finally:
        print(f"Completed operation: {name}")

with timer("Main task"):
    with log_operation("Subtask 1"):
        time.sleep(0.1)
    with log_operation("Subtask 2"):
        time.sleep(0.1)
print()

# 12. Context manager with return value
print("12. CONTEXT MANAGER WITH RETURN VALUE")
print("-" * 60)
class ValueContext:
    def __init__(self, value):
        self.value = value
    
    def __enter__(self):
        return self.value * 2  # Return modified value
    
    def __exit__(self, *args):
        return False

with ValueContext(5) as doubled:
    print(f"Doubled value: {doubled}")
print()

# 13. Error handling in context manager
print("13. ERROR HANDLING IN CONTEXT MANAGER")
print("-" * 60)
class SafeContext:
    def __enter__(self):
        print("Entering safe context")
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        print("Exiting safe context")
        if exc_type is not None:
            print(f"Exception occurred: {exc_type.__name__}: {exc_val}")
        return False  # Don't suppress

with SafeContext():
    print("Inside safe context")
    # raise ValueError("Test exception")  # Uncomment to test
print()

# 14. Context manager that suppresses specific errors
print("14. CONTEXT MANAGER THAT SUPPRESSES SPECIFIC ERRORS")
print("-" * 60)
class IgnoreErrors:
    def __init__(self, *error_types):
        self.error_types = error_types
    
    def __enter__(self):
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if exc_type in self.error_types:
            print(f"Ignored {exc_type.__name__}")
            return True  # Suppress
        return False  # Don't suppress others

with IgnoreErrors(ValueError, TypeError):
    raise ValueError("This will be ignored")
    print("This won't print")

print("After ignored error")
print()

# 15. Practical: File processing with error handling
print("15. PRACTICAL: FILE PROCESSING WITH ERROR HANDLING")
print("-" * 60)
@contextmanager
def process_file(filename):
    print(f"Opening {filename}")
    try:
        with open(filename, "r") as file:
            yield file
    except FileNotFoundError:
        print(f"File {filename} not found")
        yield None
    finally:
        print(f"Closing {filename}")

with process_file("test_file.txt") as file:
    if file:
        content = file.read()
        print(f"Read {len(content)} characters")
print()

# Cleanup
print("Cleaning up test files...")
test_files = ["test_file.txt", "input.txt", "output.txt"]
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
CONTEXT MANAGERS PRACTICE
============================================================

1. BUILT-IN FILE CONTEXT MANAGER
------------------------------------------------------------
Created test_file.txt
Content:
Hello, World!
This is a test file.

[... rest of output ...]
```

**Challenge** (Optional):
- Create a database connection pool context manager
- Build a transaction context manager
- Create a temporary file context manager
- Implement a retry context manager

---

## Key Takeaways

1. **Context managers** ensure proper resource management and cleanup
2. **`with` statement** enters a context managed by a context manager
3. **`__enter__` method** is called when entering the context
4. **`__exit__` method** is called when exiting the context (even on exceptions)
5. **`@contextmanager` decorator** makes it easy to create context managers
6. **`contextlib.suppress()`** suppresses specific exceptions
7. **`contextlib.redirect_stdout()`** redirects output
8. **`contextlib.ExitStack()`** manages multiple context managers
9. **Always use `with`** for resources that need cleanup
10. **Exception handling** in `__exit__` should be careful not to mask errors
11. **Return False from `__exit__`** to let exceptions propagate (default)
12. **Return True from `__exit__`** to suppress exceptions
13. **Use `try/finally`** in `@contextmanager` functions to ensure cleanup
14. **Context managers** make code cleaner and safer
15. **Nested context managers** work naturally with `with` statement

---

## Quiz: Context Managers

Test your understanding with these questions:

1. **What is a context manager?**
   - A) A file object
   - B) An object that manages context entry/exit
   - C) A function
   - D) A class

2. **What statement is used with context managers?**
   - A) `if`
   - B) `for`
   - C) `with`
   - D) `try`

3. **What method is called when entering a context?**
   - A) `__init__`
   - B) `__enter__`
   - C) `__start__`
   - D) `__begin__`

4. **What method is called when exiting a context?**
   - A) `__exit__`
   - B) `__end__`
   - C) `__close__`
   - D) `__finish__`

5. **What decorator creates a context manager from a function?**
   - A) `@context`
   - B) `@contextmanager`
   - C) `@manager`
   - D) `@with`

6. **What does returning True from `__exit__` do?**
   - A) Closes the context
   - B) Suppresses the exception
   - C) Opens the context
   - D) Raises an exception

7. **What does `contextlib.suppress()` do?**
   - A) Creates a context
   - B) Suppresses specific exceptions
   - C) Opens a file
   - D) Closes a file

8. **When is `__exit__` called?**
   - A) Only on success
   - B) Only on error
   - C) Always, even on exceptions
   - D) Never

9. **What is the main benefit of context managers?**
   - A) Faster execution
   - B) Automatic resource cleanup
   - C) Smaller code
   - D) No exceptions

10. **What should you use in `@contextmanager` functions?**
    - A) `if/else`
    - B) `try/finally`
    - C) `for/while`
    - D) `def/class`

**Answers**:
1. B) An object that manages context entry/exit (context manager definition)
2. C) `with` (statement used with context managers)
3. B) `__enter__` (called when entering context)
4. A) `__exit__` (called when exiting context)
5. B) `@contextmanager` (decorator for creating context managers)
6. B) Suppresses the exception (True suppresses, False propagates)
7. B) Suppresses specific exceptions (contextlib utility)
8. C) Always, even on exceptions (guaranteed cleanup)
9. B) Automatic resource cleanup (main benefit)
10. B) `try/finally` (ensures cleanup code runs)

---

## Next Steps

Excellent work! You've mastered context managers. You now understand:
- How the `with` statement works
- How to create custom context managers
- How to use `contextlib` utilities
- How to handle exceptions in context managers

**What's Next?**
- Lesson 9.4: Working with Different File Formats
- Learn about CSV and JSON files
- Understand XML and other formats
- Explore data serialization

---

## Additional Resources

- **Context Managers**: [docs.python.org/3/reference/datamodel.html#context-managers](https://docs.python.org/3/reference/datamodel.html#context-managers)
- **contextlib**: [docs.python.org/3/library/contextlib.html](https://docs.python.org/3/library/contextlib.html)
- **with Statement**: [docs.python.org/3/reference/compound_stmts.html#with](https://docs.python.org/3/reference/compound_stmts.html#with)

---

*Lesson completed! You're ready to move on to the next lesson.*

