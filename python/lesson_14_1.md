# Lesson 14.1: Context Manager Protocol

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the context manager protocol
- Implement `__enter__` and `__exit__` methods
- Handle exceptions in context managers
- Create custom context managers
- Understand resource management
- Use context managers effectively
- Handle cleanup operations
- Understand the `with` statement
- Create reusable context managers
- Debug context manager issues

---

## Introduction to Context Managers

**Context managers** are objects that manage resources and ensure proper setup and cleanup. They are used with the `with` statement to guarantee that resources are properly acquired and released.

### Why Context Managers?

- **Automatic cleanup**: Resources are always released
- **Exception safety**: Cleanup happens even if errors occur
- **Clean code**: Reduces boilerplate code
- **Resource management**: Ensures proper resource handling
- **Pythonic**: Idiomatic Python pattern

### The `with` Statement

The `with` statement is used to enter and exit a context manager:

```python
with open('file.txt', 'r') as f:
    content = f.read()
# File is automatically closed here
```

---

## Context Manager Protocol

A context manager must implement two methods:
- `__enter__()`: Called when entering the `with` block
- `__exit__()`: Called when exiting the `with` block

### Basic Context Manager

```python
class MyContextManager:
    def __enter__(self):
        print("Entering context")
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        print("Exiting context")
        return False  # Don't suppress exceptions

# Use context manager
with MyContextManager() as cm:
    print("Inside context")
# Output:
# Entering context
# Inside context
# Exiting context
```

### Understanding `__enter__`

The `__enter__` method:
- Is called when entering the `with` block
- Can return a value (assigned to the variable after `as`)
- Typically returns `self` or a resource

```python
class FileManager:
    def __init__(self, filename, mode):
        self.filename = filename
        self.mode = mode
        self.file = None
    
    def __enter__(self):
        print(f"Opening {self.filename}")
        self.file = open(self.filename, self.mode)
        return self.file  # Return the file object
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        print(f"Closing {self.filename}")
        if self.file:
            self.file.close()
        return False

# Use context manager
with FileManager('test.txt', 'w') as f:
    f.write("Hello, World!")
# File is automatically closed
```

### Understanding `__exit__`

The `__exit__` method receives three arguments:
- `exc_type`: Exception type (None if no exception)
- `exc_val`: Exception value (None if no exception)
- `exc_tb`: Exception traceback (None if no exception)

```python
class MyContextManager:
    def __enter__(self):
        print("Entering")
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        print(f"Exiting - Exception: {exc_type}")
        if exc_type is not None:
            print(f"Exception occurred: {exc_val}")
        return False  # Don't suppress exception

with MyContextManager():
    print("Inside")
    # raise ValueError("Error!")  # Uncomment to see exception handling
```

### Return Value of `__exit__`

The `__exit__` method can return:
- `False` or `None`: Exception is propagated (normal behavior)
- `True`: Exception is suppressed

```python
class SuppressException:
    def __enter__(self):
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if exc_type is ValueError:
            print(f"Suppressing ValueError: {exc_val}")
            return True  # Suppress the exception
        return False  # Don't suppress other exceptions

with SuppressException():
    raise ValueError("This will be suppressed")
print("Continuing after suppressed exception")
```

---

## Practical Context Manager Examples

### Example 1: File Manager

```python
class FileManager:
    def __init__(self, filename, mode):
        self.filename = filename
        self.mode = mode
        self.file = None
    
    def __enter__(self):
        print(f"Opening {self.filename}")
        self.file = open(self.filename, self.mode)
        return self.file
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if self.file:
            print(f"Closing {self.filename}")
            self.file.close()
        return False

# Use context manager
with FileManager('data.txt', 'w') as f:
    f.write("Hello, World!")
# File is automatically closed
```

### Example 2: Timer Context Manager

```python
import time

class Timer:
    def __init__(self, name="Operation"):
        self.name = name
        self.start_time = None
    
    def __enter__(self):
        print(f"Starting {self.name}...")
        self.start_time = time.time()
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        elapsed = time.time() - self.start_time
        print(f"{self.name} took {elapsed:.4f} seconds")
        return False

# Use context manager
with Timer("Data processing"):
    time.sleep(1)
    # Simulate work
# Output: Data processing took 1.0000 seconds
```

### Example 3: Database Connection Manager

```python
class DatabaseConnection:
    def __init__(self, connection_string):
        self.connection_string = connection_string
        self.connection = None
    
    def __enter__(self):
        print(f"Connecting to {self.connection_string}")
        # Simulate connection
        self.connection = {"connected": True, "string": self.connection_string}
        return self.connection
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if self.connection:
            print(f"Closing connection to {self.connection_string}")
            self.connection["connected"] = False
        return False

# Use context manager
with DatabaseConnection("postgresql://localhost/db") as conn:
    print(f"Using connection: {conn}")
    # Use connection
# Connection is automatically closed
```

### Example 4: Lock Manager

```python
import threading

class LockManager:
    def __init__(self, lock):
        self.lock = lock
    
    def __enter__(self):
        print("Acquiring lock")
        self.lock.acquire()
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        print("Releasing lock")
        self.lock.release()
        return False

# Use context manager
lock = threading.Lock()
with LockManager(lock):
    print("Critical section")
    # Lock is automatically released
```

### Example 5: Change Directory Context Manager

```python
import os

class ChangeDirectory:
    def __init__(self, path):
        self.path = path
        self.original_path = None
    
    def __enter__(self):
        self.original_path = os.getcwd()
        print(f"Changing directory to {self.path}")
        os.chdir(self.path)
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        print(f"Restoring directory to {self.original_path}")
        os.chdir(self.original_path)
        return False

# Use context manager
with ChangeDirectory("/tmp"):
    print(f"Current directory: {os.getcwd()}")
    # Work in /tmp
# Directory is automatically restored
```

---

## Exception Handling in Context Managers

### Handling Exceptions

Context managers can handle exceptions in the `__exit__` method:

```python
class ExceptionHandler:
    def __enter__(self):
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if exc_type is not None:
            print(f"Handling exception: {exc_type.__name__}: {exc_val}")
            # Log exception, clean up, etc.
        return False  # Don't suppress exception

with ExceptionHandler():
    raise ValueError("Test exception")
# Exception is handled but still propagated
```

### Suppressing Exceptions

You can suppress exceptions by returning `True` from `__exit__`:

```python
class SuppressErrors:
    def __init__(self, *exception_types):
        self.exception_types = exception_types
    
    def __enter__(self):
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if exc_type in self.exception_types:
            print(f"Suppressing {exc_type.__name__}: {exc_val}")
            return True  # Suppress exception
        return False  # Don't suppress other exceptions

with SuppressErrors(ValueError, TypeError):
    raise ValueError("This will be suppressed")
print("Continuing after suppressed exception")
```

### Cleanup on Exception

Context managers ensure cleanup happens even when exceptions occur:

```python
class ResourceManager:
    def __init__(self, resource_name):
        self.resource_name = resource_name
        self.resource = None
    
    def __enter__(self):
        print(f"Acquiring {self.resource_name}")
        self.resource = {"name": self.resource_name, "acquired": True}
        return self.resource
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if self.resource:
            print(f"Releasing {self.resource_name}")
            self.resource["acquired"] = False
        if exc_type is not None:
            print(f"Exception occurred: {exc_val}")
        return False

# Exception occurs, but resource is still released
with ResourceManager("Database"):
    raise ValueError("Error!")
    # Resource is still released
```

### Exception Chaining

You can re-raise exceptions or raise new ones:

```python
class ErrorLogger:
    def __enter__(self):
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if exc_type is not None:
            print(f"Logging exception: {exc_type.__name__}: {exc_val}")
            # Log to file, database, etc.
            # You can raise a new exception here if needed
        return False  # Propagate original exception

with ErrorLogger():
    raise ValueError("Original error")
```

---

## Advanced Context Manager Patterns

### Pattern 1: Context Manager with State

```python
class StatefulContext:
    def __init__(self, initial_state):
        self.initial_state = initial_state
        self.current_state = None
    
    def __enter__(self):
        self.current_state = self.initial_state.copy() if hasattr(self.initial_state, 'copy') else self.initial_state
        print(f"Entering with state: {self.current_state}")
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        print(f"Exiting with state: {self.current_state}")
        return False
    
    def update_state(self, new_state):
        self.current_state = new_state

with StatefulContext({"count": 0}) as ctx:
    ctx.update_state({"count": 5})
    print(f"State: {ctx.current_state}")
```

### Pattern 2: Nested Context Managers

```python
class Context1:
    def __enter__(self):
        print("Entering Context1")
        return self
    def __exit__(self, *args):
        print("Exiting Context1")
        return False

class Context2:
    def __enter__(self):
        print("Entering Context2")
        return self
    def __exit__(self, *args):
        print("Exiting Context2")
        return False

# Nested context managers
with Context1():
    with Context2():
        print("Inside both contexts")
# Output:
# Entering Context1
# Entering Context2
# Inside both contexts
# Exiting Context2
# Exiting Context1
```

### Pattern 3: Multiple Context Managers

```python
# Multiple context managers in one with statement
with Context1(), Context2():
    print("Inside both contexts")
# Output:
# Entering Context1
# Entering Context2
# Inside both contexts
# Exiting Context2
# Exiting Context1
```

### Pattern 4: Context Manager Factory

```python
def create_timer(name):
    """Factory function for Timer context manager."""
    class Timer:
        def __init__(self, name):
            self.name = name
            self.start_time = None
        
        def __enter__(self):
            import time
            print(f"Starting {self.name}...")
            self.start_time = time.time()
            return self
        
        def __exit__(self, exc_type, exc_val, exc_tb):
            import time
            elapsed = time.time() - self.start_time
            print(f"{self.name} took {elapsed:.4f} seconds")
            return False
    
    return Timer(name)

# Use factory
with create_timer("Operation"):
    import time
    time.sleep(1)
```

### Pattern 5: Reusable Context Manager

```python
class ReusableContext:
    def __init__(self):
        self.count = 0
    
    def __enter__(self):
        self.count += 1
        print(f"Entering (use #{self.count})")
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        print(f"Exiting (use #{self.count})")
        return False

# Reuse the same context manager
ctx = ReusableContext()
with ctx:
    print("First use")

with ctx:
    print("Second use")
```

---

## Common Mistakes and Pitfalls

### 1. Not Returning from `__exit__`

```python
# WRONG: Not returning False
class BadContext:
    def __enter__(self):
        return self
    def __exit__(self, exc_type, exc_val, exc_tb):
        pass  # Implicitly returns None (OK, but explicit is better)

# CORRECT: Explicitly return False
class GoodContext:
    def __enter__(self):
        return self
    def __exit__(self, exc_type, exc_val, exc_tb):
        return False  # Explicit
```

### 2. Not Handling Exceptions Properly

```python
# WRONG: Suppressing all exceptions
class BadContext:
    def __enter__(self):
        return self
    def __exit__(self, exc_type, exc_val, exc_tb):
        return True  # Suppresses ALL exceptions (dangerous!)

# CORRECT: Only suppress specific exceptions
class GoodContext:
    def __enter__(self):
        return self
    def __exit__(self, exc_type, exc_val, exc_tb):
        if exc_type is ValueError:
            return True  # Only suppress ValueError
        return False  # Don't suppress others
```

### 3. Not Cleaning Up on Exception

```python
# WRONG: Cleanup might not happen
class BadContext:
    def __init__(self):
        self.resource = acquire_resource()
    
    def __enter__(self):
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if exc_type is None:  # Only cleanup if no exception
            release_resource(self.resource)

# CORRECT: Always cleanup
class GoodContext:
    def __init__(self):
        self.resource = None
    
    def __enter__(self):
        self.resource = acquire_resource()
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if self.resource:
            release_resource(self.resource)  # Always cleanup
        return False
```

### 4. Forgetting to Return Resource

```python
# WRONG: Not returning the resource
class BadContext:
    def __enter__(self):
        self.file = open('file.txt', 'r')
        # Forgot to return!
    
    def __exit__(self, *args):
        self.file.close()

# CORRECT: Return the resource
class GoodContext:
    def __enter__(self):
        self.file = open('file.txt', 'r')
        return self.file  # Return the resource
    
    def __exit__(self, *args):
        self.file.close()
```

---

## Best Practices

### 1. Always Clean Up Resources

```python
class ResourceManager:
    def __enter__(self):
        self.resource = acquire_resource()
        return self.resource
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if self.resource:
            release_resource(self.resource)  # Always cleanup
        return False
```

### 2. Handle Exceptions Appropriately

```python
class ExceptionHandler:
    def __exit__(self, exc_type, exc_val, exc_tb):
        if exc_type is not None:
            # Handle exception
            log_exception(exc_type, exc_val, exc_tb)
        return False  # Don't suppress unless necessary
```

### 3. Return Appropriate Values

```python
class FileManager:
    def __enter__(self):
        self.file = open('file.txt', 'r')
        return self.file  # Return the resource, not self
    
    def __exit__(self, *args):
        self.file.close()
        return False
```

### 4. Document Your Context Managers

```python
class MyContextManager:
    """Context manager that does something.
    
    Usage:
        with MyContextManager() as cm:
            # Use cm
    """
    def __enter__(self):
        """Enter the context."""
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        """Exit the context."""
        return False
```

### 5. Test Exception Handling

```python
# Test that exceptions are handled correctly
ctx = MyContextManager()
try:
    with ctx:
        raise ValueError("Test")
except ValueError:
    print("Exception was propagated correctly")
```

---

## Practice Exercise

### Exercise: Custom Context Managers

**Objective**: Create a Python program that demonstrates custom context managers.

**Instructions**:

1. Create a file called `context_managers_practice.py`

2. Write a program that:
   - Creates custom context managers
   - Implements `__enter__` and `__exit__`
   - Handles exceptions in context managers
   - Demonstrates practical applications
   - Shows advanced patterns

3. Your program should include:
   - Basic context manager
   - File manager context manager
   - Timer context manager
   - Exception handling
   - Resource cleanup
   - Nested context managers
   - Real-world examples

**Example Solution**:

```python
"""
Context Manager Protocol Practice
This program demonstrates custom context managers.
"""

import time
import os

print("=" * 60)
print("CONTEXT MANAGER PROTOCOL PRACTICE")
print("=" * 60)
print()

# 1. Basic context manager
print("1. BASIC CONTEXT MANAGER")
print("-" * 60)

class MyContextManager:
    def __enter__(self):
        print("Entering context")
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        print("Exiting context")
        return False

with MyContextManager() as cm:
    print("Inside context")
print()

# 2. File manager context manager
print("2. FILE MANAGER CONTEXT MANAGER")
print("-" * 60)

class FileManager:
    def __init__(self, filename, mode):
        self.filename = filename
        self.mode = mode
        self.file = None
    
    def __enter__(self):
        print(f"Opening {self.filename}")
        self.file = open(self.filename, self.mode)
        return self.file
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if self.file:
            print(f"Closing {self.filename}")
            self.file.close()
        return False

# Create a test file
with FileManager('test.txt', 'w') as f:
    f.write("Hello, World!")

with FileManager('test.txt', 'r') as f:
    content = f.read()
    print(f"Content: {content}")
print()

# 3. Timer context manager
print("3. TIMER CONTEXT MANAGER")
print("-" * 60)

class Timer:
    def __init__(self, name="Operation"):
        self.name = name
        self.start_time = None
    
    def __enter__(self):
        print(f"Starting {self.name}...")
        self.start_time = time.time()
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        elapsed = time.time() - self.start_time
        print(f"{self.name} took {elapsed:.4f} seconds")
        return False

with Timer("Data processing"):
    time.sleep(0.1)
    # Simulate work
print()

# 4. Exception handling in context manager
print("4. EXCEPTION HANDLING")
print("-" * 60)

class ExceptionHandler:
    def __enter__(self):
        print("Entering context")
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if exc_type is not None:
            print(f"Handling exception: {exc_type.__name__}: {exc_val}")
        print("Exiting context")
        return False  # Don't suppress exception

try:
    with ExceptionHandler():
        raise ValueError("Test exception")
except ValueError as e:
    print(f"Caught exception: {e}")
print()

# 5. Suppressing exceptions
print("5. SUPPRESSING EXCEPTIONS")
print("-" * 60)

class SuppressErrors:
    def __init__(self, *exception_types):
        self.exception_types = exception_types
    
    def __enter__(self):
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if exc_type in self.exception_types:
            print(f"Suppressing {exc_type.__name__}: {exc_val}")
            return True  # Suppress exception
        return False

with SuppressErrors(ValueError, TypeError):
    raise ValueError("This will be suppressed")
print("Continuing after suppressed exception")
print()

# 6. Resource manager
print("6. RESOURCE MANAGER")
print("-" * 60)

class ResourceManager:
    def __init__(self, resource_name):
        self.resource_name = resource_name
        self.resource = None
    
    def __enter__(self):
        print(f"Acquiring {self.resource_name}")
        self.resource = {"name": self.resource_name, "acquired": True}
        return self.resource
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if self.resource:
            print(f"Releasing {self.resource_name}")
            self.resource["acquired"] = False
        if exc_type is not None:
            print(f"Exception occurred: {exc_val}")
        return False

# Normal usage
with ResourceManager("Database"):
    print("Using resource")

# Exception occurs, but resource is still released
try:
    with ResourceManager("Database"):
        raise ValueError("Error!")
except ValueError:
    print("Exception caught, resource was released")
print()

# 7. Change directory context manager
print("7. CHANGE DIRECTORY CONTEXT MANAGER")
print("-" * 60)

class ChangeDirectory:
    def __init__(self, path):
        self.path = path
        self.original_path = None
    
    def __enter__(self):
        self.original_path = os.getcwd()
        print(f"Changing directory to {self.path}")
        os.chdir(self.path)
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        print(f"Restoring directory to {self.original_path}")
        os.chdir(self.original_path)
        return False

original = os.getcwd()
with ChangeDirectory("/tmp"):
    print(f"Current directory: {os.getcwd()}")
print(f"Restored directory: {os.getcwd()}")
print()

# 8. Stateful context manager
print("8. STATEFUL CONTEXT MANAGER")
print("-" * 60)

class StatefulContext:
    def __init__(self, initial_state):
        self.initial_state = initial_state
        self.current_state = None
    
    def __enter__(self):
        self.current_state = self.initial_state.copy() if isinstance(self.initial_state, dict) else self.initial_state
        print(f"Entering with state: {self.current_state}")
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        print(f"Exiting with state: {self.current_state}")
        return False
    
    def update_state(self, new_state):
        self.current_state = new_state

with StatefulContext({"count": 0}) as ctx:
    ctx.update_state({"count": 5})
    print(f"State: {ctx.current_state}")
print()

# 9. Nested context managers
print("9. NESTED CONTEXT MANAGERS")
print("-" * 60)

class Context1:
    def __enter__(self):
        print("Entering Context1")
        return self
    def __exit__(self, *args):
        print("Exiting Context1")
        return False

class Context2:
    def __enter__(self):
        print("Entering Context2")
        return self
    def __exit__(self, *args):
        print("Exiting Context2")
        return False

with Context1():
    with Context2():
        print("Inside both contexts")
print()

# 10. Multiple context managers
print("10. MULTIPLE CONTEXT MANAGERS")
print("-" * 60)

with Context1(), Context2():
    print("Inside both contexts")
print()

# 11. Reusable context manager
print("11. REUSABLE CONTEXT MANAGER")
print("-" * 60)

class ReusableContext:
    def __init__(self):
        self.count = 0
    
    def __enter__(self):
        self.count += 1
        print(f"Entering (use #{self.count})")
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        print(f"Exiting (use #{self.count})")
        return False

ctx = ReusableContext()
with ctx:
    print("First use")

with ctx:
    print("Second use")
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

# 13. Error logger context manager
print("13. ERROR LOGGER CONTEXT MANAGER")
print("-" * 60)

class ErrorLogger:
    def __enter__(self):
        self.errors = []
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if exc_type is not None:
            self.errors.append((exc_type.__name__, str(exc_val)))
            print(f"Logged error: {exc_type.__name__}: {exc_val}")
        return False

logger = ErrorLogger()
try:
    with logger:
        raise ValueError("Test error")
except ValueError:
    print(f"Errors logged: {logger.errors}")
print()

# 14. Lock manager context manager
print("14. LOCK MANAGER CONTEXT MANAGER")
print("-" * 60)

import threading

class LockManager:
    def __init__(self, lock):
        self.lock = lock
    
    def __enter__(self):
        print("Acquiring lock")
        self.lock.acquire()
        return self
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        print("Releasing lock")
        self.lock.release()
        return False

lock = threading.Lock()
with LockManager(lock):
    print("Critical section")
print()

# 15. Real-world: Database connection
print("15. REAL-WORLD: DATABASE CONNECTION")
print("-" * 60)

class DatabaseConnection:
    def __init__(self, connection_string):
        self.connection_string = connection_string
        self.connection = None
    
    def __enter__(self):
        print(f"Connecting to {self.connection_string}")
        # Simulate connection
        self.connection = {"connected": True, "string": self.connection_string}
        return self.connection
    
    def __exit__(self, exc_type, exc_val, exc_tb):
        if self.connection:
            print(f"Closing connection to {self.connection_string}")
            self.connection["connected"] = False
        return False

with DatabaseConnection("postgresql://localhost/db") as conn:
    print(f"Using connection: {conn}")
    # Use connection
print()

# Cleanup
if os.path.exists('test.txt'):
    os.remove('test.txt')

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
CONTEXT MANAGER PROTOCOL PRACTICE
============================================================

1. BASIC CONTEXT MANAGER
------------------------------------------------------------
Entering context
Inside context
Exiting context

[... rest of output ...]
```

**Challenge** (Optional):
- Create a context manager that temporarily modifies environment variables
- Build a context manager that redirects stdout/stderr
- Implement a context manager that manages temporary files
- Create a context manager that handles database transactions

---

## Key Takeaways

1. **Context managers** - manage resources with `with` statement
2. **`__enter__` method** - called when entering context
3. **`__exit__` method** - called when exiting context
4. **Exception handling** - `__exit__` receives exception info
5. **Return value** - `__exit__` can suppress exceptions by returning True
6. **Resource cleanup** - always happens, even on exceptions
7. **`with` statement** - ensures proper resource management
8. **Nested contexts** - can nest multiple context managers
9. **Multiple contexts** - can use multiple in one `with` statement
10. **Best practices** - always cleanup, handle exceptions, return appropriate values
11. **Automatic cleanup** - resources are always released
12. **Exception safety** - cleanup happens even if errors occur
13. **Clean code** - reduces boilerplate
14. **Pythonic** - idiomatic Python pattern
15. **Reusable** - can reuse context manager instances

---

## Quiz: Context Protocol

Test your understanding with these questions:

1. **What methods must a context manager implement?**
   - A) `__init__` and `__del__`
   - B) `__enter__` and `__exit__`
   - C) `start` and `stop`
   - D) `open` and `close`

2. **What does `__enter__` return?**
   - A) Nothing
   - B) The context manager instance
   - C) A value assigned to the variable after `as`
   - D) Always None

3. **What arguments does `__exit__` receive?**
   - A) None
   - B) Exception type, value, traceback
   - C) Self only
   - D) Exception only

4. **What happens if `__exit__` returns True?**
   - A) Exception is propagated
   - B) Exception is suppressed
   - C) Context manager is reused
   - D) Nothing

5. **When is `__exit__` called?**
   - A) Only on normal exit
   - B) Only on exceptions
   - C) Always, even on exceptions
   - D) Never

6. **What is the purpose of context managers?**
   - A) To manage resources
   - B) To ensure cleanup
   - C) To handle exceptions
   - D) All of the above

7. **Can you nest context managers?**
   - A) No
   - B) Yes, but only two
   - C) Yes, any number
   - D) Only with special syntax

8. **What does the `with` statement do?**
   - A) Opens a file
   - B) Enters and exits a context manager
   - C) Handles exceptions
   - D) All of the above

9. **What should `__exit__` return to suppress an exception?**
   - A) False
   - B) True
   - C) None
   - D) The exception

10. **When should you use context managers?**
    - A) Always
    - B) For resource management
    - C) Never
    - D) Only for files

**Answers**:
1. B) `__enter__` and `__exit__` (context manager protocol)
2. C) A value assigned to the variable after `as` (`__enter__` return value)
3. B) Exception type, value, traceback (`__exit__` arguments)
4. B) Exception is suppressed (returning True from `__exit__`)
5. C) Always, even on exceptions (`__exit__` is always called)
6. D) All of the above (context manager purposes)
7. C) Yes, any number (nesting context managers)
8. B) Enters and exits a context manager (`with` statement purpose)
9. B) True (suppress exception by returning True)
10. B) For resource management (context manager use case)

---

## Next Steps

Excellent work! You've mastered the context manager protocol. You now understand:
- How to implement `__enter__` and `__exit__`
- How to handle exceptions in context managers
- How to create custom context managers

**What's Next?**
- Lesson 14.2: contextlib Module
- Learn the `@contextmanager` decorator
- Understand `closing()` and other utilities
- Explore contextlib helpers

---

## Additional Resources

- **Context Managers**: [docs.python.org/3/reference/datamodel.html#context-managers](https://docs.python.org/3/reference/datamodel.html#context-managers)
- **with Statement**: [docs.python.org/3/reference/compound_stmts.html#with](https://docs.python.org/3/reference/compound_stmts.html#with)
- **PEP 343**: [peps.python.org/pep-0343/](https://peps.python.org/pep-0343/) (The "with" Statement)

---

*Lesson completed! You're ready to move on to the next lesson.*

