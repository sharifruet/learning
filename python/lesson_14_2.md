# Lesson 14.2: contextlib Module

## Learning Objectives

By the end of this lesson, you will be able to:
- Use the `@contextmanager` decorator
- Understand generator-based context managers
- Use the `closing()` function
- Work with `ExitStack` for multiple contexts
- Create context managers easily
- Handle exceptions with contextlib
- Use contextlib utilities effectively
- Understand when to use contextlib vs manual implementation
- Apply contextlib in real-world scenarios
- Debug contextlib issues

---

## Introduction to contextlib

The `contextlib` module provides utilities for working with context managers. It makes creating and using context managers easier and more Pythonic.

### Why contextlib?

- **Simpler syntax**: Create context managers with generators
- **Less boilerplate**: No need to implement `__enter__` and `__exit__`
- **Utilities**: Helper functions for common patterns
- **Flexibility**: Easy to create context managers
- **Pythonic**: More readable and maintainable code

---

## @contextmanager Decorator

The `@contextmanager` decorator allows you to create context managers using generator functions instead of classes.

### Basic Usage

```python
from contextlib import contextmanager

@contextmanager
def my_context_manager():
    # Setup code (before yield)
    print("Entering context")
    try:
        yield "value"  # Value returned to 'as' variable
    finally:
        # Cleanup code (after yield)
        print("Exiting context")

# Use context manager
with my_context_manager() as value:
    print(f"Inside context with value: {value}")
# Output:
# Entering context
# Inside context with value: value
# Exiting context
```

### Understanding the Pattern

```python
from contextlib import contextmanager

@contextmanager
def timer(name):
    import time
    # Setup
    start = time.time()
    print(f"Starting {name}...")
    try:
        yield  # Nothing returned
    finally:
        # Cleanup
        elapsed = time.time() - start
        print(f"{name} took {elapsed:.4f} seconds")

with timer("Operation"):
    import time
    time.sleep(1)
```

### Returning Values

```python
from contextlib import contextmanager

@contextmanager
def file_manager(filename, mode):
    # Setup
    file = open(filename, mode)
    try:
        yield file  # Return file object
    finally:
        # Cleanup
        file.close()

# Use context manager
with file_manager('test.txt', 'w') as f:
    f.write("Hello, World!")
# File is automatically closed
```

### Exception Handling

```python
from contextlib import contextmanager

@contextmanager
def exception_handler():
    try:
        yield
    except ValueError as e:
        print(f"Handled ValueError: {e}")
        # Exception is still propagated unless you don't re-raise
    except Exception as e:
        print(f"Handled exception: {e}")
        raise  # Re-raise other exceptions

with exception_handler():
    raise ValueError("Test error")
```

### Suppressing Exceptions

```python
from contextlib import contextmanager

@contextmanager
def suppress_exceptions(*exception_types):
    try:
        yield
    except exception_types as e:
        print(f"Suppressing {type(e).__name__}: {e}")
        # Don't re-raise - exception is suppressed

with suppress_exceptions(ValueError, TypeError):
    raise ValueError("This will be suppressed")
print("Continuing after suppressed exception")
```

---

## Practical @contextmanager Examples

### Example 1: File Manager

```python
from contextlib import contextmanager

@contextmanager
def file_manager(filename, mode):
    file = open(filename, mode)
    try:
        yield file
    finally:
        file.close()

# Use context manager
with file_manager('data.txt', 'w') as f:
    f.write("Hello, World!")
```

### Example 2: Timer

```python
from contextlib import contextmanager
import time

@contextmanager
def timer(name="Operation"):
    start = time.time()
    print(f"Starting {name}...")
    try:
        yield
    finally:
        elapsed = time.time() - start
        print(f"{name} took {elapsed:.4f} seconds")

with timer("Data processing"):
    time.sleep(1)
    # Simulate work
```

### Example 3: Change Directory

```python
from contextlib import contextmanager
import os

@contextmanager
def change_directory(path):
    original_path = os.getcwd()
    try:
        os.chdir(path)
        yield
    finally:
        os.chdir(original_path)

with change_directory("/tmp"):
    print(f"Current directory: {os.getcwd()}")
# Directory is automatically restored
```

### Example 4: Temporary State

```python
from contextlib import contextmanager

@contextmanager
def temporary_state(obj, **kwargs):
    """Temporarily set attributes on an object."""
    original_values = {}
    try:
        # Save original values
        for key, value in kwargs.items():
            original_values[key] = getattr(obj, key, None)
            setattr(obj, key, value)
        yield
    finally:
        # Restore original values
        for key, value in original_values.items():
            if value is None:
                delattr(obj, key)
            else:
                setattr(obj, key, value)

class MyClass:
    pass

obj = MyClass()
obj.x = 1
with temporary_state(obj, x=2, y=3):
    print(f"x={obj.x}, y={obj.y}")  # x=2, y=3
print(f"x={obj.x}")  # x=1 (restored)
```

### Example 5: Resource Lock

```python
from contextlib import contextmanager
import threading

@contextmanager
def lock_manager(lock):
    print("Acquiring lock")
    lock.acquire()
    try:
        yield
    finally:
        print("Releasing lock")
        lock.release()

lock = threading.Lock()
with lock_manager(lock):
    print("Critical section")
```

### Example 6: Database Transaction

```python
from contextlib import contextmanager

@contextmanager
def transaction(db):
    """Manage database transaction."""
    try:
        yield db
        db.commit()
        print("Transaction committed")
    except Exception as e:
        db.rollback()
        print(f"Transaction rolled back: {e}")
        raise

# Simulated database
class Database:
    def commit(self):
        pass
    def rollback(self):
        pass

db = Database()
with transaction(db):
    # Database operations
    pass
```

---

## closing() Function

The `closing()` function creates a context manager that closes an object when exiting the context.

### Basic Usage

```python
from contextlib import closing
from urllib.request import urlopen

# closing() ensures the object is closed
with closing(urlopen('https://www.python.org')) as page:
    content = page.read()
    print(len(content))
# Page is automatically closed
```

### When to Use closing()

Use `closing()` when an object has a `close()` method but doesn't implement the context manager protocol:

```python
from contextlib import closing

class MyResource:
    def close(self):
        print("Closing resource")

# MyResource doesn't implement __enter__/__exit__
# Use closing() to make it a context manager
with closing(MyResource()) as resource:
    print("Using resource")
# Resource is automatically closed
```

### Example: File-like Objects

```python
from contextlib import closing

class FileLike:
    def __init__(self, data):
        self.data = data
        self.closed = False
    
    def read(self):
        return self.data
    
    def close(self):
        self.closed = True
        print("File closed")

# Use closing() to ensure close() is called
with closing(FileLike("Hello")) as f:
    print(f.read())
print(f"File closed: {f.closed}")
```

---

## ExitStack

`ExitStack` allows you to manage multiple context managers dynamically.

### Basic Usage

```python
from contextlib import ExitStack

with ExitStack() as stack:
    file1 = stack.enter_context(open('file1.txt', 'w'))
    file2 = stack.enter_context(open('file2.txt', 'w'))
    # Both files are automatically closed when exiting
    file1.write("Hello")
    file2.write("World")
```

### Dynamic Context Management

```python
from contextlib import ExitStack

def process_files(filenames):
    with ExitStack() as stack:
        files = [stack.enter_context(open(fname)) for fname in filenames]
        # Process files
        for file in files:
            print(file.read())
        # All files are automatically closed

process_files(['file1.txt', 'file2.txt'])
```

### Conditional Context Managers

```python
from contextlib import ExitStack

def process_with_optional_file(filename=None):
    with ExitStack() as stack:
        if filename:
            file = stack.enter_context(open(filename, 'w'))
            file.write("Data")
        # File is closed if it was opened
        print("Processing complete")

process_with_optional_file('optional.txt')
process_with_optional_file()  # No file opened
```

### Multiple Context Managers

```python
from contextlib import ExitStack
import threading

def complex_operation():
    with ExitStack() as stack:
        # Enter multiple contexts
        file = stack.enter_context(open('data.txt', 'w'))
        lock = stack.enter_context(threading.Lock())
        timer = stack.enter_context(timer_context("Operation"))
        
        # Use resources
        file.write("Data")
        # All contexts are properly exited
```

### ExitStack with Callbacks

```python
from contextlib import ExitStack

def callback():
    print("Cleanup callback")

with ExitStack() as stack:
    stack.callback(callback)
    # Do work
    print("Working...")
# Callback is called when exiting
```

---

## Other contextlib Utilities

### suppress()

Suppress specific exceptions:

```python
from contextlib import suppress

# Suppress FileNotFoundError
with suppress(FileNotFoundError):
    os.remove('nonexistent.txt')
print("Continuing after suppressed exception")
```

### redirect_stdout() and redirect_stderr()

Redirect stdout/stderr:

```python
from contextlib import redirect_stdout, redirect_stderr
import io

# Redirect stdout to a string
f = io.StringIO()
with redirect_stdout(f):
    print("This goes to the string")
output = f.getvalue()
print(f"Captured: {output}")
```

### nullcontext()

A context manager that does nothing:

```python
from contextlib import nullcontext

# Useful for optional context managers
def process(use_context=False):
    ctx = my_context() if use_context else nullcontext()
    with ctx:
        # Do work
        pass
```

---

## Advanced Patterns

### Pattern 1: Nested Context Managers

```python
from contextlib import contextmanager

@contextmanager
def outer_context():
    print("Outer: entering")
    try:
        yield
    finally:
        print("Outer: exiting")

@contextmanager
def inner_context():
    print("Inner: entering")
    try:
        yield
    finally:
        print("Inner: exiting")

# Nest context managers
with outer_context():
    with inner_context():
        print("Inside both")
```

### Pattern 2: Context Manager Composition

```python
from contextlib import contextmanager, ExitStack

@contextmanager
def timer(name):
    import time
    start = time.time()
    try:
        yield
    finally:
        print(f"{name} took {time.time() - start:.4f} seconds")

@contextmanager
def logger(name):
    print(f"Starting {name}")
    try:
        yield
    finally:
        print(f"Finished {name}")

# Compose multiple context managers
def composed_operation():
    with ExitStack() as stack:
        stack.enter_context(timer("Operation"))
        stack.enter_context(logger("Operation"))
        # Do work
        print("Working...")

composed_operation()
```

### Pattern 3: Reusable Context Manager

```python
from contextlib import contextmanager

@contextmanager
def reusable_context():
    print("Entering")
    try:
        yield
    finally:
        print("Exiting")

# Reuse the same context manager
ctx = reusable_context()
with ctx:
    print("First use")

with ctx:
    print("Second use")
```

### Pattern 4: Context Manager with State

```python
from contextlib import contextmanager

@contextmanager
def stateful_context(initial_state):
    state = initial_state.copy() if isinstance(initial_state, dict) else initial_state
    print(f"Entering with state: {state}")
    try:
        yield state
    finally:
        print(f"Exiting with state: {state}")

with stateful_context({"count": 0}) as state:
    state["count"] = 5
    print(f"State: {state}")
```

---

## Common Mistakes and Pitfalls

### 1. Forgetting try-finally

```python
# WRONG: No exception handling
from contextlib import contextmanager

@contextmanager
def bad_context():
    setup()
    yield
    cleanup()  # Might not execute if exception occurs

# CORRECT: Use try-finally
@contextmanager
def good_context():
    setup()
    try:
        yield
    finally:
        cleanup()  # Always executes
```

### 2. Not Yielding

```python
# WRONG: No yield statement
from contextlib import contextmanager

@contextmanager
def bad_context():
    setup()
    # Missing yield!
    cleanup()

# CORRECT: Must have yield
@contextmanager
def good_context():
    setup()
    try:
        yield
    finally:
        cleanup()
```

### 3. Yielding Multiple Times

```python
# WRONG: Multiple yields
from contextlib import contextmanager

@contextmanager
def bad_context():
    yield "first"
    yield "second"  # Error!

# CORRECT: Single yield
@contextmanager
def good_context():
    yield "value"
```

### 4. Not Using closing() for Objects with close()

```python
# WRONG: Manual close (might not happen on exception)
resource = MyResource()
try:
    use_resource(resource)
finally:
    resource.close()

# CORRECT: Use closing()
from contextlib import closing

with closing(MyResource()) as resource:
    use_resource(resource)
```

---

## Best Practices

### 1. Always Use try-finally

```python
from contextlib import contextmanager

@contextmanager
def my_context():
    setup()
    try:
        yield
    finally:
        cleanup()  # Always executes
```

### 2. Use @contextmanager for Simple Cases

```python
# Good: Use @contextmanager for simple context managers
from contextlib import contextmanager

@contextmanager
def simple_context():
    setup()
    try:
        yield
    finally:
        cleanup()
```

### 3. Use closing() for Objects with close()

```python
from contextlib import closing

with closing(MyResource()) as resource:
    use_resource(resource)
```

### 4. Use ExitStack for Multiple Contexts

```python
from contextlib import ExitStack

with ExitStack() as stack:
    file1 = stack.enter_context(open('file1.txt'))
    file2 = stack.enter_context(open('file2.txt'))
    # Both files are closed
```

### 5. Document Your Context Managers

```python
from contextlib import contextmanager

@contextmanager
def my_context():
    """Context manager that does something.
    
    Yields:
        The resource being managed
    """
    setup()
    try:
        yield resource
    finally:
        cleanup()
```

---

## Practice Exercise

### Exercise: contextlib

**Objective**: Create a Python program that demonstrates the contextlib module.

**Instructions**:

1. Create a file called `contextlib_practice.py`

2. Write a program that:
   - Uses `@contextmanager` decorator
   - Uses `closing()` function
   - Uses `ExitStack` for multiple contexts
   - Demonstrates practical applications
   - Shows advanced patterns

3. Your program should include:
   - Basic @contextmanager usage
   - Generator-based context managers
   - Exception handling with @contextmanager
   - closing() examples
   - ExitStack examples
   - Real-world applications

**Example Solution**:

```python
"""
contextlib Module Practice
This program demonstrates the contextlib module utilities.
"""

from contextlib import contextmanager, closing, ExitStack, suppress, redirect_stdout
import time
import os
import io

print("=" * 60)
print("CONTEXTLIB MODULE PRACTICE")
print("=" * 60)
print()

# 1. Basic @contextmanager
print("1. BASIC @contextmanager")
print("-" * 60)

@contextmanager
def my_context_manager():
    print("Entering context")
    try:
        yield "value"
    finally:
        print("Exiting context")

with my_context_manager() as value:
    print(f"Inside context with value: {value}")
print()

# 2. Timer with @contextmanager
print("2. TIMER WITH @contextmanager")
print("-" * 60)

@contextmanager
def timer(name="Operation"):
    start = time.time()
    print(f"Starting {name}...")
    try:
        yield
    finally:
        elapsed = time.time() - start
        print(f"{name} took {elapsed:.4f} seconds")

with timer("Data processing"):
    time.sleep(0.1)
print()

# 3. File manager with @contextmanager
print("3. FILE MANAGER WITH @contextmanager")
print("-" * 60)

@contextmanager
def file_manager(filename, mode):
    file = open(filename, mode)
    try:
        yield file
    finally:
        file.close()

with file_manager('test.txt', 'w') as f:
    f.write("Hello, World!")

with file_manager('test.txt', 'r') as f:
    content = f.read()
    print(f"Content: {content}")
print()

# 4. Exception handling with @contextmanager
print("4. EXCEPTION HANDLING WITH @contextmanager")
print("-" * 60)

@contextmanager
def exception_handler():
    try:
        yield
    except ValueError as e:
        print(f"Handled ValueError: {e}")

try:
    with exception_handler():
        raise ValueError("Test error")
except ValueError:
    print("Exception was propagated")
print()

# 5. Suppressing exceptions with @contextmanager
print("5. SUPPRESSING EXCEPTIONS WITH @contextmanager")
print("-" * 60)

@contextmanager
def suppress_exceptions(*exception_types):
    try:
        yield
    except exception_types as e:
        print(f"Suppressing {type(e).__name__}: {e}")

with suppress_exceptions(ValueError, TypeError):
    raise ValueError("This will be suppressed")
print("Continuing after suppressed exception")
print()

# 6. Change directory with @contextmanager
print("6. CHANGE DIRECTORY WITH @contextmanager")
print("-" * 60)

@contextmanager
def change_directory(path):
    original_path = os.getcwd()
    try:
        os.chdir(path)
        yield
    finally:
        os.chdir(original_path)

original = os.getcwd()
with change_directory("/tmp"):
    print(f"Current directory: {os.getcwd()}")
print(f"Restored directory: {os.getcwd()}")
print()

# 7. Temporary state with @contextmanager
print("7. TEMPORARY STATE WITH @contextmanager")
print("-" * 60)

@contextmanager
def temporary_state(obj, **kwargs):
    original_values = {}
    try:
        for key, value in kwargs.items():
            original_values[key] = getattr(obj, key, None)
            setattr(obj, key, value)
        yield
    finally:
        for key, value in original_values.items():
            if value is None:
                if hasattr(obj, key):
                    delattr(obj, key)
            else:
                setattr(obj, key, value)

class MyClass:
    pass

obj = MyClass()
obj.x = 1
with temporary_state(obj, x=2, y=3):
    print(f"x={obj.x}, y={obj.y}")
print(f"x={obj.x}")
print()

# 8. closing() function
print("8. closing() FUNCTION")
print("-" * 60)

class MyResource:
    def __init__(self):
        self.closed = False
    
    def close(self):
        self.closed = True
        print("Resource closed")
    
    def use(self):
        print("Using resource")

with closing(MyResource()) as resource:
    resource.use()
print(f"Resource closed: {resource.closed}")
print()

# 9. ExitStack basic usage
print("9. ExitStack BASIC USAGE")
print("-" * 60)

with ExitStack() as stack:
    file1 = stack.enter_context(open('test1.txt', 'w'))
    file2 = stack.enter_context(open('test2.txt', 'w'))
    file1.write("Hello")
    file2.write("World")
    print("Both files opened and will be closed")
print("Both files closed")
print()

# 10. ExitStack with dynamic contexts
print("10. ExitStack WITH DYNAMIC CONTEXTS")
print("-" * 60)

def process_files(filenames):
    with ExitStack() as stack:
        files = [stack.enter_context(open(fname, 'w')) for fname in filenames]
        for i, file in enumerate(files):
            file.write(f"Data {i}")
        print(f"Processed {len(files)} files")

process_files(['test1.txt', 'test2.txt'])
print()

# 11. ExitStack with callbacks
print("11. ExitStack WITH CALLBACKS")
print("-" * 60)

def cleanup_callback():
    print("Cleanup callback executed")

with ExitStack() as stack:
    stack.callback(cleanup_callback)
    print("Working...")
print()

# 12. suppress() function
print("12. suppress() FUNCTION")
print("-" * 60)

with suppress(FileNotFoundError):
    os.remove('nonexistent.txt')
print("Continuing after suppressed exception")
print()

# 13. redirect_stdout()
print("13. redirect_stdout()")
print("-" * 60)

f = io.StringIO()
with redirect_stdout(f):
    print("This goes to the string")
    print("Another line")
output = f.getvalue()
print(f"Captured output: {output!r}")
print()

# 14. Nested context managers
print("14. NESTED CONTEXT MANAGERS")
print("-" * 60)

@contextmanager
def outer_context():
    print("Outer: entering")
    try:
        yield
    finally:
        print("Outer: exiting")

@contextmanager
def inner_context():
    print("Inner: entering")
    try:
        yield
    finally:
        print("Inner: exiting")

with outer_context():
    with inner_context():
        print("Inside both")
print()

# 15. Real-world: Multiple file processing
print("15. REAL-WORLD: MULTIPLE FILE PROCESSING")
print("-" * 60)

def process_multiple_files(filenames):
    with ExitStack() as stack:
        files = [stack.enter_context(open(fname, 'w')) for fname in filenames]
        for i, file in enumerate(files):
            file.write(f"Content {i}\n")
        print(f"Processed {len(files)} files")

process_multiple_files(['output1.txt', 'output2.txt', 'output3.txt'])
print()

# Cleanup
for fname in ['test.txt', 'test1.txt', 'test2.txt', 'output1.txt', 'output2.txt', 'output3.txt']:
    if os.path.exists(fname):
        os.remove(fname)

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
CONTEXTLIB MODULE PRACTICE
============================================================

1. BASIC @contextmanager
------------------------------------------------------------
Entering context
Inside context with value: value
Exiting context

[... rest of output ...]
```

**Challenge** (Optional):
- Create a context manager that temporarily modifies environment variables
- Build a context manager that redirects both stdout and stderr
- Implement a context manager that manages database connections with connection pooling
- Create a context manager that handles temporary file creation and cleanup

---

## Key Takeaways

1. **@contextmanager** - creates context managers from generators
2. **Generator pattern** - setup before yield, cleanup after
3. **try-finally** - always use for cleanup code
4. **closing()** - for objects with close() method
5. **ExitStack** - manage multiple context managers dynamically
6. **suppress()** - suppress specific exceptions
7. **redirect_stdout/stderr** - redirect output streams
8. **nullcontext()** - context manager that does nothing
9. **Less boilerplate** - simpler than implementing __enter__/__exit__
10. **Exception handling** - cleanup always happens
11. **Dynamic contexts** - ExitStack for conditional contexts
12. **Composition** - combine multiple context managers
13. **Best practices** - always use try-finally, document
14. **Pythonic** - more readable and maintainable
15. **Flexibility** - easy to create context managers

---

## Quiz: contextlib

Test your understanding with these questions:

1. **What does @contextmanager do?**
   - A) Creates a context manager from a generator
   - B) Creates a generator from a context manager
   - C) Closes a context manager
   - D) Nothing

2. **What must a @contextmanager function contain?**
   - A) return statement
   - B) yield statement
   - C) raise statement
   - D) pass statement

3. **What does closing() do?**
   - A) Opens a file
   - B) Closes an object when exiting context
   - C) Creates a context manager
   - D) Both B and C

4. **What is ExitStack used for?**
   - A) Managing multiple context managers
   - B) Exiting Python
   - C) Stack operations
   - D) Error handling

5. **When should you use @contextmanager?**
   - A) Always
   - B) For simple context managers
   - C) Never
   - D) Only for files

6. **What happens if you don't use try-finally in @contextmanager?**
   - A) Nothing
   - B) Cleanup might not execute
   - C) Error occurs
   - D) Context manager works normally

7. **What does suppress() do?**
   - A) Suppresses all exceptions
   - B) Suppresses specific exceptions
   - C) Raises exceptions
   - D) Nothing

8. **Can you yield multiple times in @contextmanager?**
   - A) Yes
   - B) No
   - C) Only in Python 3.9+
   - D) Only with special syntax

9. **What is the advantage of @contextmanager over manual implementation?**
   - A) Less boilerplate
   - B) Simpler syntax
   - C) More readable
   - D) All of the above

10. **What does redirect_stdout() do?**
    - A) Redirects stdout to a file
    - B) Redirects stdout to a stream
    - C) Closes stdout
    - D) Both A and B

**Answers**:
1. A) Creates a context manager from a generator (@contextmanager purpose)
2. B) yield statement (required in @contextmanager)
3. D) Both B and C (closing() functionality)
4. A) Managing multiple context managers (ExitStack purpose)
5. B) For simple context managers (@contextmanager use case)
6. B) Cleanup might not execute (consequence of missing try-finally)
7. B) Suppresses specific exceptions (suppress() functionality)
8. B) No (only one yield allowed)
9. D) All of the above (@contextmanager advantages)
10. D) Both A and B (redirect_stdout() functionality)

---

## Next Steps

Excellent work! You've mastered the contextlib module. You now understand:
- How to use @contextmanager decorator
- How to use closing() function
- How to work with ExitStack
- Advanced patterns and utilities

**What's Next?**
- Module 15: Metaclasses and Descriptors
- Learn about descriptors
- Understand the descriptor protocol
- Explore metaclasses

---

## Additional Resources

- **contextlib**: [docs.python.org/3/library/contextlib.html](https://docs.python.org/3/library/contextlib.html)
- **@contextmanager**: [docs.python.org/3/library/contextlib.html#contextlib.contextmanager](https://docs.python.org/3/library/contextlib.html#contextlib.contextmanager)
- **ExitStack**: [docs.python.org/3/library/contextlib.html#contextlib.ExitStack](https://docs.python.org/3/library/contextlib.html#contextlib.ExitStack)

---

*Lesson completed! You're ready to move on to the next module.*

