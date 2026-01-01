# Lesson 10.4: Debugging Techniques

## Learning Objectives

By the end of this lesson, you will be able to:
- Use print statements for debugging
- Use the Python debugger (pdb) for interactive debugging
- Understand logging basics and the logging module
- Set breakpoints and step through code
- Inspect variables and call stacks
- Use different logging levels
- Configure loggers and handlers
- Apply debugging techniques effectively
- Choose appropriate debugging methods

---

## Introduction to Debugging

**Debugging** is the process of finding and fixing errors (bugs) in your code. Python provides several tools and techniques for debugging.

### Why Debugging Matters

- **Find errors**: Locate bugs in code
- **Understand behavior**: See how code executes
- **Inspect state**: Check variable values
- **Trace execution**: Follow program flow

### Debugging Approaches

1. **Print debugging**: Simple but effective
2. **Debugger (pdb)**: Interactive debugging
3. **Logging**: Structured debugging information
4. **IDE debuggers**: Visual debugging tools

---

## Print Debugging

**Print debugging** is the simplest debugging technique - adding print statements to see what's happening.

### Basic Print Debugging

```python
def calculate_total(items):
    print(f"DEBUG: calculate_total called with {items}")
    total = 0
    for item in items:
        print(f"DEBUG: Processing item {item}")
        total += item
        print(f"DEBUG: Total is now {total}")
    print(f"DEBUG: Final total: {total}")
    return total

calculate_total([10, 20, 30])
```

### Debugging with f-strings

```python
def divide(a, b):
    print(f"DEBUG: divide({a}, {b})")
    result = a / b
    print(f"DEBUG: result = {result}")
    return result
```

### Conditional Debugging

```python
DEBUG = True

def process_data(data):
    if DEBUG:
        print(f"DEBUG: Processing data: {data}")
    result = data * 2
    if DEBUG:
        print(f"DEBUG: Result: {result}")
    return result
```

### Debugging with Separators

```python
def complex_function(x, y):
    print("=" * 40)
    print(f"DEBUG: Entering function with x={x}, y={y}")
    result = x + y
    print(f"DEBUG: Calculation result: {result}")
    print("=" * 40)
    return result
```

---

## Python Debugger (pdb)

The **Python debugger (pdb)** is an interactive debugger for Python programs.

### Starting the Debugger

#### Method 1: `pdb.set_trace()`

```python
import pdb

def calculate(a, b):
    pdb.set_trace()  # Breakpoint here
    result = a + b
    return result

calculate(5, 10)
```

#### Method 2: Command Line

```bash
python -m pdb script.py
```

#### Method 3: Post-Mortem Debugging

```python
import pdb

def buggy_function():
    x = 1
    y = 0
    result = x / y  # Error here

try:
    buggy_function()
except:
    pdb.post_mortem()  # Enter debugger on exception
```

### Basic pdb Commands

| Command | Shortcut | Description |
|---------|----------|-------------|
| `help` | `h` | Show help |
| `next` | `n` | Execute next line |
| `step` | `s` | Step into function |
| `continue` | `c` | Continue execution |
| `list` | `l` | Show current code |
| `print` | `p` | Print variable |
| `pp` | `pp` | Pretty print |
| `where` | `w` | Show stack trace |
| `break` | `b` | Set breakpoint |
| `quit` | `q` | Quit debugger |

### Using pdb Commands

```python
import pdb

def process_numbers(numbers):
    pdb.set_trace()
    total = 0
    for num in numbers:
        total += num
    return total

process_numbers([1, 2, 3, 4, 5])

# In debugger:
# (Pdb) n          # Next line
# (Pdb) p total    # Print total
# (Pdb) p numbers  # Print numbers
# (Pdb) l          # List code
# (Pdb) c          # Continue
```

### Stepping Through Code

```python
import pdb

def add(a, b):
    result = a + b
    return result

def calculate(x, y):
    pdb.set_trace()
    sum_result = add(x, y)
    product = x * y
    return sum_result + product

calculate(5, 3)

# (Pdb) n          # Step over add()
# (Pdb) s          # Step into add()
# (Pdb) n          # Next line in add()
# (Pdb) c          # Continue
```

### Inspecting Variables

```python
import pdb

def process_data(data):
    pdb.set_trace()
    filtered = [x for x in data if x > 0]
    total = sum(filtered)
    average = total / len(filtered)
    return average

process_data([1, -2, 3, -4, 5])

# (Pdb) p data        # Print data
# (Pdb) p filtered    # Print filtered
# (Pdb) pp data       # Pretty print data
# (Pdb) type(data)    # Check type
```

### Setting Breakpoints

```python
import pdb

def function_a():
    x = 1
    y = 2
    return x + y

def function_b():
    result = function_a()
    pdb.set_trace()  # Breakpoint
    return result * 2

function_b()

# (Pdb) b function_a    # Set breakpoint in function_a
# (Pdb) b 5             # Set breakpoint at line 5
# (Pdb) c               # Continue to breakpoint
```

---

## Logging Basics

The **logging** module provides a flexible framework for emitting log messages.

### Basic Logging

```python
import logging

logging.basicConfig(level=logging.DEBUG)
logging.debug("Debug message")
logging.info("Info message")
logging.warning("Warning message")
logging.error("Error message")
logging.critical("Critical message")
```

### Logging Levels

| Level | Numeric Value | Description |
|-------|---------------|-------------|
| DEBUG | 10 | Detailed debugging information |
| INFO | 20 | Informational messages |
| WARNING | 30 | Warning messages |
| ERROR | 40 | Error messages |
| CRITICAL | 50 | Critical error messages |

### Configuring Logging

```python
import logging

# Configure logging
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(name)s - %(levelname)s - %(message)s',
    datefmt='%Y-%m-%d %H:%M:%S'
)

logging.info("Application started")
logging.error("An error occurred")
```

### Logging to File

```python
import logging

logging.basicConfig(
    filename='app.log',
    level=logging.DEBUG,
    format='%(asctime)s - %(levelname)s - %(message)s'
)

logging.debug("Debug message")
logging.info("Info message")
logging.error("Error message")
```

### Using Loggers

```python
import logging

# Create logger
logger = logging.getLogger(__name__)
logger.setLevel(logging.DEBUG)

# Create handler
handler = logging.StreamHandler()
handler.setLevel(logging.INFO)

# Create formatter
formatter = logging.Formatter('%(asctime)s - %(name)s - %(levelname)s - %(message)s')
handler.setFormatter(formatter)

# Add handler to logger
logger.addHandler(handler)

logger.debug("Debug message")
logger.info("Info message")
logger.error("Error message")
```

### Logging in Functions

```python
import logging

logging.basicConfig(level=logging.DEBUG)
logger = logging.getLogger(__name__)

def process_data(data):
    logger.debug(f"Processing data: {data}")
    try:
        result = sum(data)
        logger.info(f"Processed successfully: {result}")
        return result
    except Exception as e:
        logger.error(f"Error processing data: {e}")
        raise

process_data([1, 2, 3, 4, 5])
```

### Logging Best Practices

```python
import logging

# Use module-level logger
logger = logging.getLogger(__name__)

def function_with_logging():
    logger.debug("Entering function")
    try:
        # Code here
        logger.info("Operation successful")
    except Exception as e:
        logger.error(f"Operation failed: {e}", exc_info=True)
        raise
    finally:
        logger.debug("Exiting function")
```

---

## Practical Examples

### Example 1: Debugging with Print

```python
def find_max(numbers):
    print(f"DEBUG: Input: {numbers}")
    if not numbers:
        print("DEBUG: Empty list")
        return None
    
    max_val = numbers[0]
    print(f"DEBUG: Initial max: {max_val}")
    
    for num in numbers[1:]:
        print(f"DEBUG: Checking {num} against {max_val}")
        if num > max_val:
            max_val = num
            print(f"DEBUG: New max: {max_val}")
    
    print(f"DEBUG: Final max: {max_val}")
    return max_val

find_max([3, 1, 4, 1, 5, 9, 2, 6])
```

### Example 2: Debugging with pdb

```python
import pdb

def binary_search(arr, target):
    pdb.set_trace()
    left, right = 0, len(arr) - 1
    
    while left <= right:
        mid = (left + right) // 2
        if arr[mid] == target:
            return mid
        elif arr[mid] < target:
            left = mid + 1
        else:
            right = mid - 1
    
    return -1

result = binary_search([1, 2, 3, 4, 5], 3)
```

### Example 3: Logging in Application

```python
import logging

# Configure logging
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(levelname)s - %(message)s'
)

logger = logging.getLogger(__name__)

def process_user(user_id):
    logger.info(f"Processing user {user_id}")
    try:
        # Process user
        logger.debug(f"User {user_id} processed successfully")
        return True
    except Exception as e:
        logger.error(f"Error processing user {user_id}: {e}")
        return False

process_user(123)
```

### Example 4: Conditional Debugging

```python
import logging
import os

# Set debug level from environment
DEBUG = os.getenv('DEBUG', 'False').lower() == 'true'
LOG_LEVEL = logging.DEBUG if DEBUG else logging.INFO

logging.basicConfig(level=LOG_LEVEL)
logger = logging.getLogger(__name__)

def complex_operation(data):
    logger.debug(f"Starting operation with data: {data}")
    # Complex processing
    result = data * 2
    logger.info(f"Operation completed: {result}")
    return result
```

---

## Common Debugging Patterns

### Pattern 1: Debug Flag

```python
DEBUG = True

def function():
    if DEBUG:
        print("Debug: Function called")
    # Code here
```

### Pattern 2: Logging Decorator

```python
import logging
from functools import wraps

logging.basicConfig(level=logging.DEBUG)
logger = logging.getLogger(__name__)

def log_function(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        logger.debug(f"Calling {func.__name__} with args={args}, kwargs={kwargs}")
        result = func(*args, **kwargs)
        logger.debug(f"{func.__name__} returned {result}")
        return result
    return wrapper

@log_function
def add(a, b):
    return a + b

add(5, 3)
```

### Pattern 3: Assertions for Debugging

```python
def process_data(data):
    assert isinstance(data, list), "Data must be a list"
    assert len(data) > 0, "Data cannot be empty"
    
    # Process data
    return sum(data)
```

---

## Best Practices

### 1. Use Appropriate Debugging Method

- **Print**: Quick debugging, simple issues
- **pdb**: Complex debugging, interactive inspection
- **Logging**: Production code, persistent debugging

### 2. Remove Debug Code

```python
# Good: Use logging instead of print
import logging
logger = logging.getLogger(__name__)
logger.debug("Debug message")

# Avoid: Leaving print statements
print("DEBUG: message")  # Should be removed
```

### 3. Use Logging Levels Appropriately

```python
logger.debug("Detailed debugging info")
logger.info("General information")
logger.warning("Warning messages")
logger.error("Error messages")
logger.critical("Critical errors")
```

### 4. Don't Over-Debug

```python
# Bad: Too many debug statements
def function():
    print("DEBUG: Start")
    print("DEBUG: Step 1")
    print("DEBUG: Step 2")
    print("DEBUG: Step 3")
    print("DEBUG: End")

# Good: Strategic debugging
def function():
    logger.debug("Function started")
    # Key operations
    logger.debug("Function completed")
```

---

## Common Mistakes and Pitfalls

### 1. Leaving Print Statements

```python
# WRONG: Print statements in production code
def function():
    print("DEBUG: Processing")
    # Code
    print("DEBUG: Done")

# BETTER: Use logging
def function():
    logger.debug("Processing")
    # Code
    logger.debug("Done")
```

### 2. Not Using Appropriate Log Levels

```python
# WRONG: Using error for everything
logging.error("User logged in")
logging.error("Data processed")

# BETTER: Use appropriate levels
logging.info("User logged in")
logging.debug("Data processed")
```

### 3. Too Much Debugging

```python
# WRONG: Debugging every line
print(f"x = {x}")
x = x + 1
print(f"x = {x}")
x = x * 2
print(f"x = {x}")

# BETTER: Debug key points
logger.debug(f"Initial value: {x}")
# Process
logger.debug(f"Final value: {x}")
```

---

## Practice Exercise

### Exercise: Debugging Practice

**Objective**: Create a Python program that demonstrates various debugging techniques.

**Instructions**:

1. Create a file called `debugging_practice.py`

2. Write a program that:
   - Uses print debugging
   - Demonstrates pdb usage
   - Uses logging
   - Shows debugging patterns

3. Your program should include:
   - Print debugging examples
   - pdb debugging examples
   - Logging examples
   - Practical debugging scenarios

**Example Solution**:

```python
"""
Debugging Practice
This program demonstrates various debugging techniques.
"""

import pdb
import logging

print("=" * 60)
print("DEBUGGING PRACTICE")
print("=" * 60)
print()

# 1. Basic print debugging
print("1. BASIC PRINT DEBUGGING")
print("-" * 60)
def calculate_sum(numbers):
    print(f"DEBUG: Input numbers: {numbers}")
    total = 0
    for num in numbers:
        print(f"DEBUG: Adding {num} to total (current: {total})")
        total += num
    print(f"DEBUG: Final total: {total}")
    return total

result = calculate_sum([1, 2, 3, 4, 5])
print(f"Result: {result}\n")

# 2. Conditional debugging
print("2. CONDITIONAL DEBUGGING")
print("-" * 60)
DEBUG = True

def process_data(data):
    if DEBUG:
        print(f"DEBUG: Processing data: {data}")
    result = data * 2
    if DEBUG:
        print(f"DEBUG: Result: {result}")
    return result

result = process_data(10)
print(f"Result: {result}\n")

# 3. Debugging with separators
print("3. DEBUGGING WITH SEPARATORS")
print("-" * 60)
def complex_function(x, y):
    print("=" * 40)
    print(f"DEBUG: Entering function with x={x}, y={y}")
    intermediate = x * y
    print(f"DEBUG: Intermediate result: {intermediate}")
    result = intermediate + x + y
    print(f"DEBUG: Final result: {result}")
    print("=" * 40)
    return result

result = complex_function(5, 3)
print(f"Result: {result}\n")

# 4. Basic logging
print("4. BASIC LOGGING")
print("-" * 60)
logging.basicConfig(level=logging.DEBUG)

logging.debug("Debug message")
logging.info("Info message")
logging.warning("Warning message")
logging.error("Error message")
logging.critical("Critical message")
print()

# 5. Logging with configuration
print("5. LOGGING WITH CONFIGURATION")
print("-" * 60)
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(levelname)s - %(message)s',
    datefmt='%H:%M:%S'
)

logging.info("Application started")
logging.warning("This is a warning")
logging.error("An error occurred")
print()

# 6. Logging to file
print("6. LOGGING TO FILE")
print("-" * 60)
logging.basicConfig(
    filename='debug.log',
    level=logging.DEBUG,
    format='%(asctime)s - %(levelname)s - %(message)s'
)

logging.debug("Debug message to file")
logging.info("Info message to file")
logging.error("Error message to file")
print("Logged to debug.log\n")

# 7. Using logger object
print("7. USING LOGGER OBJECT")
print("-" * 60)
logger = logging.getLogger(__name__)
logger.setLevel(logging.DEBUG)

# Create console handler
console_handler = logging.StreamHandler()
console_handler.setLevel(logging.INFO)

# Create formatter
formatter = logging.Formatter('%(name)s - %(levelname)s - %(message)s')
console_handler.setFormatter(formatter)

logger.addHandler(console_handler)

logger.debug("Debug message (won't show)")
logger.info("Info message")
logger.error("Error message")
print()

# 8. Logging in function
print("8. LOGGING IN FUNCTION")
print("-" * 60)
def process_items(items):
    logger.info(f"Processing {len(items)} items")
    try:
        total = sum(items)
        logger.info(f"Successfully processed: total={total}")
        return total
    except Exception as e:
        logger.error(f"Error processing items: {e}")
        raise

try:
    result = process_items([1, 2, 3, 4, 5])
    print(f"Result: {result}\n")
except Exception:
    pass

# 9. Debugging with assertions
print("9. DEBUGGING WITH ASSERTIONS")
print("-" * 60)
def divide(a, b):
    assert b != 0, "Division by zero"
    assert isinstance(a, (int, float)), "First argument must be number"
    assert isinstance(b, (int, float)), "Second argument must be number"
    return a / b

try:
    result = divide(10, 2)
    print(f"10 / 2 = {result}")
    # Uncomment to test assertions:
    # divide(10, 0)  # AssertionError
except AssertionError as e:
    print(f"Assertion failed: {e}")
print()

# 10. Logging exception information
print("10. LOGGING EXCEPTION INFORMATION")
print("-" * 60)
def risky_operation():
    try:
        result = 10 / 0
        return result
    except Exception as e:
        logger.error(f"Error in risky_operation: {e}", exc_info=True)
        raise

try:
    risky_operation()
except Exception:
    pass
print()

# 11. Debugging decorator pattern
print("11. DEBUGGING DECORATOR PATTERN")
print("-" * 60)
from functools import wraps

def debug_function(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        logger.debug(f"Calling {func.__name__}(*{args}, **{kwargs})")
        try:
            result = func(*args, **kwargs)
            logger.debug(f"{func.__name__} returned {result}")
            return result
        except Exception as e:
            logger.error(f"Error in {func.__name__}: {e}")
            raise
    return wrapper

@debug_function
def multiply(a, b):
    return a * b

result = multiply(5, 3)
print(f"5 * 3 = {result}\n")

# 12. Conditional logging
print("12. CONDITIONAL LOGGING")
print("-" * 60)
import os

# Set log level from environment or default
LOG_LEVEL = os.getenv('LOG_LEVEL', 'INFO')
logging.basicConfig(level=getattr(logging, LOG_LEVEL))
logger = logging.getLogger(__name__)

logger.debug("Debug message (may not show)")
logger.info("Info message")
logger.warning("Warning message")
print()

# 13. Multiple handlers
print("13. MULTIPLE HANDLERS")
print("-" * 60)
logger = logging.getLogger("multi_handler")
logger.setLevel(logging.DEBUG)

# Console handler
console_handler = logging.StreamHandler()
console_handler.setLevel(logging.INFO)

# File handler
file_handler = logging.FileHandler("detailed.log")
file_handler.setLevel(logging.DEBUG)

# Formatter
formatter = logging.Formatter('%(asctime)s - %(levelname)s - %(message)s')
console_handler.setFormatter(formatter)
file_handler.setFormatter(formatter)

logger.addHandler(console_handler)
logger.addHandler(file_handler)

logger.debug("Debug message (file only)")
logger.info("Info message (both)")
logger.error("Error message (both)")
print("Check detailed.log for all messages\n")

# 14. Finding bugs with debugging
print("14. FINDING BUGS WITH DEBUGGING")
print("-" * 60)
def buggy_function(numbers):
    # Bug: doesn't handle empty list
    total = 0
    for i in range(len(numbers)):
        total += numbers[i]  # Should use sum()
    average = total / len(numbers)  # Bug: division by zero if empty
    return average

# Debug version
def debugged_function(numbers):
    logger.debug(f"Input: {numbers}")
    if not numbers:
        logger.warning("Empty list provided")
        return None
    
    total = sum(numbers)  # Better approach
    logger.debug(f"Total: {total}, Count: {len(numbers)}")
    average = total / len(numbers)
    logger.info(f"Average: {average}")
    return average

result = debugged_function([1, 2, 3, 4, 5])
print(f"Average: {result}\n")

# 15. pdb example (commented - uncomment to try)
print("15. PDB EXAMPLE")
print("-" * 60)
print("Uncomment the code below to try pdb:")
print()
print("""
def example_with_pdb():
    import pdb; pdb.set_trace()
    x = 10
    y = 20
    result = x + y
    return result

# Uncomment to try:
# result = example_with_pdb()
""")
print()

# Cleanup
import os
if os.path.exists('debug.log'):
    os.remove('debug.log')
if os.path.exists('detailed.log'):
    os.remove('detailed.log')

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
DEBUGGING PRACTICE
============================================================

1. BASIC PRINT DEBUGGING
------------------------------------------------------------
DEBUG: Input numbers: [1, 2, 3, 4, 5]
DEBUG: Adding 1 to total (current: 0)
DEBUG: Adding 2 to total (current: 1)
[... rest of output ...]
```

**Challenge** (Optional):
- Create a debugging utility module
- Build a logging configuration system
- Create a debug decorator library
- Implement a trace logging system

---

## Key Takeaways

1. **Print debugging** is simple but effective for quick debugging
2. **pdb** is Python's interactive debugger
3. **Logging module** provides structured debugging information
4. **Logging levels**: DEBUG, INFO, WARNING, ERROR, CRITICAL
5. **pdb commands**: n (next), s (step), c (continue), p (print), l (list)
6. **Use logging** instead of print for production code
7. **Set appropriate log levels** for different environments
8. **Loggers** can have multiple handlers (console, file, etc.)
9. **Format logging** messages for better readability
10. **Use exc_info=True** to log exception tracebacks
11. **Remove debug code** before production (or use logging)
12. **Use assertions** for debugging assumptions
13. **Conditional debugging** with flags or environment variables
14. **Don't over-debug** - be strategic about what to log
15. **Choose appropriate method** for your debugging needs

---

## Quiz: Debugging

Test your understanding with these questions:

1. **What is the simplest debugging technique?**
   - A) pdb
   - B) Print debugging
   - C) Logging
   - D) IDE debugger

2. **What command starts the Python debugger?**
   - A) `pdb.start()`
   - B) `pdb.set_trace()`
   - C) `pdb.debug()`
   - D) `pdb.break()`

3. **What pdb command executes the next line?**
   - A) `s`
   - B) `n`
   - C) `c`
   - D) `p`

4. **What is the default logging level?**
   - A) DEBUG
   - B) INFO
   - C) WARNING
   - D) ERROR

5. **What logging level shows detailed debugging info?**
   - A) DEBUG
   - B) INFO
   - C) WARNING
   - D) ERROR

6. **What should you use instead of print in production?**
   - A) pdb
   - B) Logging
   - C) assert
   - D) input()

7. **What pdb command steps into a function?**
   - A) `n`
   - B) `s`
   - C) `c`
   - D) `l`

8. **What logging level is for warnings?**
   - A) DEBUG
   - B) INFO
   - C) WARNING
   - D) ERROR

9. **What pdb command shows the current code?**
   - A) `p`
   - B) `l`
   - C) `w`
   - D) `c`

10. **What should you do with debug print statements?**
    - A) Leave them
    - B) Remove or replace with logging
    - C) Comment them out
    - D) Move them to separate file

**Answers**:
1. B) Print debugging (simplest technique)
2. B) `pdb.set_trace()` (starts debugger at that point)
3. B) `n` (next - executes next line)
4. C) WARNING (default logging level)
5. A) DEBUG (shows detailed debugging info)
6. B) Logging (should use logging in production)
7. B) `s` (step - steps into function)
8. C) WARNING (logging level for warnings)
9. B) `l` (list - shows current code)
10. B) Remove or replace with logging (clean up debug code)

---

## Next Steps

Excellent work! You've mastered debugging techniques. You now understand:
- How to use print debugging
- How to use the pdb debugger
- How to use logging
- When to use each technique

**What's Next?**
- Module 11: Modules and Packages
- Learn about importing modules
- Understand package structure
- Explore Python's module system

---

## Additional Resources

- **Logging**: [docs.python.org/3/library/logging.html](https://docs.python.org/3/library/logging.html)
- **pdb**: [docs.python.org/3/library/pdb.html](https://docs.python.org/3/library/pdb.html)
- **Debugging**: [docs.python.org/3/library/pdb.html#debugger-commands](https://docs.python.org/3/library/pdb.html#debugger-commands)

---

*Lesson completed! You're ready to move on to the next module.*

