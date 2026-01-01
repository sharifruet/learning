# Lesson 10.1: Exceptions

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what exceptions are and why they occur
- Recognize common Python exceptions
- Understand the exception hierarchy
- Identify when exceptions are raised
- Read and interpret exception messages
- Understand the difference between errors and exceptions
- Know when exceptions are appropriate
- Understand exception types and their uses

---

## Introduction to Exceptions

**Exceptions** are events that occur during program execution that disrupt the normal flow of instructions. When an exception occurs, Python raises an exception object.

### What Are Exceptions?

- **Runtime errors**: Problems that occur while the program is running
- **Signal problems**: Indicate that something went wrong
- **Can be handled**: Exceptions can be caught and handled
- **Provide information**: Exception messages explain what went wrong

### Why Exceptions Matter

- **Error detection**: Identify problems in code
- **Program stability**: Prevent crashes
- **Debugging**: Help locate issues
- **User experience**: Provide meaningful error messages

### Exception vs Error

- **Error**: Usually indicates a serious problem (syntax errors, etc.)
- **Exception**: Can be caught and handled during execution

---

## Common Exceptions

### SyntaxError

Occurs when Python cannot parse your code (syntax error):

```python
# SyntaxError: invalid syntax
if True
    print("Hello")

# Correct
if True:
    print("Hello")
```

### NameError

Occurs when a variable is not defined:

```python
# NameError: name 'x' is not defined
print(x)

# Correct
x = 10
print(x)
```

### TypeError

Occurs when an operation is performed on an inappropriate type:

```python
# TypeError: unsupported operand type(s) for +: 'int' and 'str'
result = 5 + "hello"

# Correct
result = 5 + int("5")
# Or
result = str(5) + "hello"
```

### ValueError

Occurs when a function receives an argument of correct type but inappropriate value:

```python
# ValueError: invalid literal for int() with base 10: 'abc'
number = int("abc")

# Correct
number = int("123")
```

### IndexError

Occurs when trying to access an index that doesn't exist:

```python
# IndexError: list index out of range
my_list = [1, 2, 3]
print(my_list[5])

# Correct
print(my_list[0])  # Valid index
```

### KeyError

Occurs when trying to access a dictionary key that doesn't exist:

```python
# KeyError: 'age'
person = {"name": "Alice"}
print(person["age"])

# Correct
print(person.get("age", "N/A"))  # Use get() with default
# Or
if "age" in person:
    print(person["age"])
```

### AttributeError

Occurs when trying to access an attribute that doesn't exist:

```python
# AttributeError: 'str' object has no attribute 'append'
text = "hello"
text.append("world")

# Correct
my_list = ["hello"]
my_list.append("world")
```

### ZeroDivisionError

Occurs when dividing by zero:

```python
# ZeroDivisionError: division by zero
result = 10 / 0

# Correct
divisor = 0
if divisor != 0:
    result = 10 / divisor
else:
    print("Cannot divide by zero")
```

### FileNotFoundError

Occurs when trying to open a file that doesn't exist:

```python
# FileNotFoundError: [Errno 2] No such file or directory: 'nonexistent.txt'
with open("nonexistent.txt", "r") as file:
    content = file.read()

# Correct
try:
    with open("nonexistent.txt", "r") as file:
        content = file.read()
except FileNotFoundError:
    print("File not found")
```

### ImportError

Occurs when an import statement fails:

```python
# ImportError: cannot import name 'nonexistent' from 'module'
from module import nonexistent

# Correct
from module import existing_function
```

### ModuleNotFoundError

Occurs when a module cannot be found:

```python
# ModuleNotFoundError: No module named 'nonexistent_module'
import nonexistent_module

# Correct
import os  # Existing module
```

---

## Exception Hierarchy

Python exceptions are organized in a hierarchy. All exceptions inherit from `BaseException`.

### Base Exception Classes

```
BaseException
├── SystemExit
├── KeyboardInterrupt
├── GeneratorExit
└── Exception
    ├── StopIteration
    ├── StopAsyncIteration
    ├── ArithmeticError
    │   ├── FloatingPointError
    │   ├── OverflowError
    │   └── ZeroDivisionError
    ├── AssertionError
    ├── AttributeError
    ├── BufferError
    ├── EOFError
    ├── ImportError
    │   └── ModuleNotFoundError
    ├── LookupError
    │   ├── IndexError
    │   └── KeyError
    ├── MemoryError
    ├── NameError
    │   └── UnboundLocalError
    ├── OSError
    │   ├── FileNotFoundError
    │   ├── PermissionError
    │   └── ...
    ├── RuntimeError
    │   └── RecursionError
    ├── SyntaxError
    │   └── IndentationError
    ├── SystemError
    ├── TypeError
    └── ValueError
```

### Understanding the Hierarchy

```python
# All exceptions inherit from Exception
try:
    x = 1 / 0
except Exception as e:
    print(f"Caught exception: {type(e).__name__}")

# More specific exceptions
try:
    x = 1 / 0
except ZeroDivisionError as e:
    print("Caught ZeroDivisionError")
except ArithmeticError as e:
    print("Caught ArithmeticError")
except Exception as e:
    print("Caught general Exception")
```

### Exception Inheritance

```python
# ZeroDivisionError is a subclass of ArithmeticError
print(issubclass(ZeroDivisionError, ArithmeticError))  # True
print(issubclass(ZeroDivisionError, Exception))        # True
print(issubclass(ZeroDivisionError, BaseException))    # True

# IndexError is a subclass of LookupError
print(issubclass(IndexError, LookupError))  # True
print(issubclass(KeyError, LookupError))    # True
```

---

## When Exceptions Are Raised

### Built-in Functions

Many built-in functions raise exceptions:

```python
# int() raises ValueError
try:
    number = int("abc")
except ValueError:
    print("Invalid number")

# list[index] raises IndexError
try:
    item = [1, 2, 3][10]
except IndexError:
    print("Index out of range")

# dict[key] raises KeyError
try:
    value = {"a": 1}["b"]
except KeyError:
    print("Key not found")
```

### Operations

Operations can raise exceptions:

```python
# Division raises ZeroDivisionError
try:
    result = 10 / 0
except ZeroDivisionError:
    print("Cannot divide by zero")

# Type operations raise TypeError
try:
    result = "hello" + 5
except TypeError:
    print("Cannot concatenate str and int")
```

### User-Defined

You can raise exceptions:

```python
# Raise exception
if age < 0:
    raise ValueError("Age cannot be negative")

# Raise with custom message
if not isinstance(name, str):
    raise TypeError(f"Expected str, got {type(name).__name__}")
```

---

## Reading Exception Messages

### Exception Message Format

```python
try:
    x = 1 / 0
except ZeroDivisionError as e:
    print(f"Exception type: {type(e).__name__}")
    print(f"Exception message: {e}")
    print(f"Exception args: {e.args}")
```

### Traceback Information

```python
def divide(a, b):
    return a / b

def calculate():
    return divide(10, 0)

# This will show full traceback
calculate()
# Traceback (most recent call last):
#   File "<stdin>", line 1, in <module>
#   File "<stdin>", line 2, in calculate
#   File "<stdin>", line 2, in divide
# ZeroDivisionError: division by zero
```

### Understanding Tracebacks

```python
def function_a():
    function_b()

def function_b():
    function_c()

def function_c():
    x = 1 / 0

# Traceback shows call chain
function_a()
# Traceback (most recent call last):
#   File "<stdin>", line 1, in <module>
#   File "<stdin>", line 2, in function_a
#   File "<stdin>", line 2, in function_b
#   File "<stdin>", line 2, in function_c
# ZeroDivisionError: division by zero
```

---

## Common Exception Patterns

### Type Checking

```python
def add_numbers(a, b):
    if not isinstance(a, (int, float)):
        raise TypeError(f"Expected number, got {type(a).__name__}")
    if not isinstance(b, (int, float)):
        raise TypeError(f"Expected number, got {type(b).__name__}")
    return a + b

# Usage
try:
    result = add_numbers(5, "10")
except TypeError as e:
    print(f"Error: {e}")
```

### Value Validation

```python
def set_age(age):
    if not isinstance(age, int):
        raise TypeError("Age must be an integer")
    if age < 0:
        raise ValueError("Age cannot be negative")
    if age > 150:
        raise ValueError("Age seems unrealistic")
    return age

# Usage
try:
    set_age(-5)
except ValueError as e:
    print(f"Value error: {e}")
```

### Resource Access

```python
def read_file(filename):
    try:
        with open(filename, "r") as file:
            return file.read()
    except FileNotFoundError:
        raise FileNotFoundError(f"File '{filename}' not found")
    except PermissionError:
        raise PermissionError(f"Permission denied: '{filename}'")
```

---

## Exception Information

### Getting Exception Details

```python
try:
    x = 1 / 0
except ZeroDivisionError as e:
    print(f"Exception type: {type(e)}")
    print(f"Exception name: {type(e).__name__}")
    print(f"Exception message: {str(e)}")
    print(f"Exception args: {e.args}")
```

### Exception Attributes

```python
try:
    with open("nonexistent.txt", "r") as file:
        content = file.read()
except FileNotFoundError as e:
    print(f"Error: {e}")
    print(f"Filename: {e.filename}")
    print(f"Errno: {e.errno}")
```

---

## Practical Examples

### Example 1: Input Validation

```python
def get_positive_number():
    while True:
        try:
            number = float(input("Enter a positive number: "))
            if number <= 0:
                raise ValueError("Number must be positive")
            return number
        except ValueError as e:
            print(f"Invalid input: {e}. Please try again.")

number = get_positive_number()
print(f"You entered: {number}")
```

### Example 2: Safe Division

```python
def safe_divide(a, b):
    if b == 0:
        raise ZeroDivisionError("Cannot divide by zero")
    return a / b

# Usage
try:
    result = safe_divide(10, 0)
except ZeroDivisionError as e:
    print(f"Error: {e}")
```

### Example 3: Dictionary Access

```python
def get_value(dictionary, key, default=None):
    try:
        return dictionary[key]
    except KeyError:
        return default

# Usage
person = {"name": "Alice"}
age = get_value(person, "age", "Unknown")
print(f"Age: {age}")
```

### Example 4: List Operations

```python
def safe_get_item(items, index, default=None):
    try:
        return items[index]
    except IndexError:
        return default

# Usage
my_list = [1, 2, 3]
item = safe_get_item(my_list, 10, "Not found")
print(item)
```

---

## Common Mistakes and Pitfalls

### 1. Catching Too Broad Exceptions

```python
# WRONG: Catches everything
try:
    risky_operation()
except:  # Too broad!
    print("Error occurred")

# BETTER: Catch specific exceptions
try:
    risky_operation()
except ValueError:
    print("Value error")
except TypeError:
    print("Type error")
```

### 2. Ignoring Exceptions

```python
# WRONG: Silent failure
try:
    important_operation()
except:
    pass  # Bad! Hides errors

# BETTER: Log or handle
try:
    important_operation()
except Exception as e:
    print(f"Error: {e}")  # At least log it
```

### 3. Not Understanding Exception Types

```python
# WRONG: Wrong exception type
try:
    x = int("abc")
except TypeError:  # Wrong! Should be ValueError
    print("Error")

# CORRECT
try:
    x = int("abc")
except ValueError:
    print("Invalid number")
```

---

## Best Practices

### 1. Use Specific Exceptions

```python
# Good: Specific exception
try:
    file.read()
except FileNotFoundError:
    print("File not found")
```

### 2. Provide Meaningful Messages

```python
# Good: Clear error message
if age < 0:
    raise ValueError("Age must be a non-negative integer")
```

### 3. Don't Suppress All Exceptions

```python
# Bad: Suppresses everything
try:
    operation()
except:
    pass

# Good: Handle specific exceptions
try:
    operation()
except SpecificError:
    handle_error()
```

### 4. Understand Exception Hierarchy

```python
# Catch more specific first
try:
    operation()
except ZeroDivisionError:
    handle_zero_division()
except ArithmeticError:  # More general
    handle_arithmetic_error()
```

---

## Practice Exercise

### Exercise: Exception Basics

**Objective**: Create a Python program that demonstrates understanding of exceptions.

**Instructions**:

1. Create a file called `exceptions_practice.py`

2. Write a program that:
   - Demonstrates common exceptions
   - Shows exception hierarchy
   - Reads exception information
   - Handles different exception types

3. Your program should include:
   - Examples of common exceptions
   - Exception hierarchy demonstration
   - Exception information extraction
   - Practical exception scenarios

**Example Solution**:

```python
"""
Exceptions Practice
This program demonstrates exceptions in Python.
"""

print("=" * 60)
print("EXCEPTIONS PRACTICE")
print("=" * 60)
print()

# 1. NameError
print("1. NameError")
print("-" * 60)
try:
    print(undefined_variable)
except NameError as e:
    print(f"Caught NameError: {e}")
print()

# 2. TypeError
print("2. TypeError")
print("-" * 60)
try:
    result = 5 + "hello"
except TypeError as e:
    print(f"Caught TypeError: {e}")
print()

# 3. ValueError
print("3. ValueError")
print("-" * 60)
try:
    number = int("abc")
except ValueError as e:
    print(f"Caught ValueError: {e}")
print()

# 4. IndexError
print("4. IndexError")
print("-" * 60)
try:
    my_list = [1, 2, 3]
    print(my_list[10])
except IndexError as e:
    print(f"Caught IndexError: {e}")
print()

# 5. KeyError
print("5. KeyError")
print("-" * 60)
try:
    person = {"name": "Alice"}
    print(person["age"])
except KeyError as e:
    print(f"Caught KeyError: {e}")
print()

# 6. AttributeError
print("6. AttributeError")
print("-" * 60)
try:
    text = "hello"
    text.append("world")
except AttributeError as e:
    print(f"Caught AttributeError: {e}")
print()

# 7. ZeroDivisionError
print("7. ZeroDivisionError")
print("-" * 60)
try:
    result = 10 / 0
except ZeroDivisionError as e:
    print(f"Caught ZeroDivisionError: {e}")
print()

# 8. FileNotFoundError
print("8. FileNotFoundError")
print("-" * 60)
try:
    with open("nonexistent.txt", "r") as file:
        content = file.read()
except FileNotFoundError as e:
    print(f"Caught FileNotFoundError: {e}")
print()

# 9. Exception Information
print("9. EXCEPTION INFORMATION")
print("-" * 60)
try:
    x = 1 / 0
except ZeroDivisionError as e:
    print(f"Exception type: {type(e)}")
    print(f"Exception name: {type(e).__name__}")
    print(f"Exception message: {str(e)}")
    print(f"Exception args: {e.args}")
print()

# 10. Exception Hierarchy
print("10. EXCEPTION HIERARCHY")
print("-" * 60)
print("ZeroDivisionError is subclass of ArithmeticError:")
print(f"  {issubclass(ZeroDivisionError, ArithmeticError)}")

print("IndexError is subclass of LookupError:")
print(f"  {issubclass(IndexError, LookupError)}")

print("All exceptions inherit from Exception:")
print(f"  {issubclass(ZeroDivisionError, Exception)}")
print(f"  {issubclass(ValueError, Exception)}")
print()

# 11. Multiple Exception Types
print("11. MULTIPLE EXCEPTION TYPES")
print("-" * 60)
def divide_numbers(a, b):
    try:
        return a / b
    except ZeroDivisionError:
        return "Cannot divide by zero"
    except TypeError:
        return "Invalid types for division"

print(divide_numbers(10, 2))    # 5.0
print(divide_numbers(10, 0))    # Cannot divide by zero
print(divide_numbers(10, "2"))  # Invalid types for division
print()

# 12. Raising Exceptions
print("12. RAISING EXCEPTIONS")
print("-" * 60)
def validate_age(age):
    if not isinstance(age, int):
        raise TypeError("Age must be an integer")
    if age < 0:
        raise ValueError("Age cannot be negative")
    return age

try:
    validate_age(-5)
except ValueError as e:
    print(f"Validation error: {e}")

try:
    validate_age("25")
except TypeError as e:
    print(f"Type error: {e}")
print()

# 13. Exception in Function Call Chain
print("13. EXCEPTION IN FUNCTION CALL CHAIN")
print("-" * 60)
def function_a():
    return function_b()

def function_b():
    return function_c()

def function_c():
    return 1 / 0

try:
    result = function_a()
except ZeroDivisionError as e:
    print(f"Caught exception from deep call: {e}")
print()

# 14. Safe Operations
print("14. SAFE OPERATIONS")
print("-" * 60)
def safe_get(dictionary, key, default=None):
    try:
        return dictionary[key]
    except KeyError:
        return default

def safe_divide(a, b, default=None):
    try:
        return a / b
    except ZeroDivisionError:
        return default

person = {"name": "Alice"}
print(f"Age: {safe_get(person, 'age', 'Unknown')}")
print(f"Division: {safe_divide(10, 0, 'N/A')}")
print()

# 15. Exception Type Checking
print("15. EXCEPTION TYPE CHECKING")
print("-" * 60)
def handle_exception(e):
    if isinstance(e, ValueError):
        return "Value error occurred"
    elif isinstance(e, TypeError):
        return "Type error occurred"
    elif isinstance(e, ZeroDivisionError):
        return "Division by zero"
    else:
        return f"Unknown error: {type(e).__name__}"

try:
    x = int("abc")
except Exception as e:
    print(handle_exception(e))

try:
    x = 10 / 0
except Exception as e:
    print(handle_exception(e))
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
EXCEPTIONS PRACTICE
============================================================

1. NameError
------------------------------------------------------------
Caught NameError: name 'undefined_variable' is not defined

[... rest of output ...]
```

**Challenge** (Optional):
- Create a robust input validation system
- Build an exception logging system
- Create custom exception classes
- Implement error recovery mechanisms

---

## Key Takeaways

1. **Exceptions** are runtime errors that disrupt program flow
2. **Common exceptions**: NameError, TypeError, ValueError, IndexError, KeyError, etc.
3. **Exception hierarchy**: All exceptions inherit from `BaseException` or `Exception`
4. **ZeroDivisionError** occurs when dividing by zero
5. **FileNotFoundError** occurs when file doesn't exist
6. **TypeError** occurs with wrong type operations
7. **ValueError** occurs with wrong value for correct type
8. **IndexError** occurs with invalid list/tuple index
9. **KeyError** occurs with missing dictionary key
10. **AttributeError** occurs with missing object attribute
11. **Exception messages** provide information about what went wrong
12. **Tracebacks** show the call chain where exception occurred
13. **Exception hierarchy** allows catching related exceptions
14. **Use specific exceptions** rather than catching everything
15. **Understand exception types** to handle them appropriately

---

## Quiz: Exceptions

Test your understanding with these questions:

1. **What is an exception?**
   - A) A syntax error
   - B) A runtime error that can be handled
   - C) A compilation error
   - D) A warning

2. **What exception is raised when dividing by zero?**
   - A) `ValueError`
   - B) `TypeError`
   - C) `ZeroDivisionError`
   - D) `ArithmeticError`

3. **What exception is raised for invalid list index?**
   - A) `KeyError`
   - B) `IndexError`
   - C) `ValueError`
   - D) `TypeError`

4. **What exception is raised for missing dictionary key?**
   - A) `KeyError`
   - B) `IndexError`
   - C) `ValueError`
   - D) `NameError`

5. **What exception is raised when variable is not defined?**
   - A) `NameError`
   - B) `ValueError`
   - C) `TypeError`
   - D) `AttributeError`

6. **What exception is raised for wrong type operation?**
   - A) `ValueError`
   - B) `TypeError`
   - C) `NameError`
   - D) `KeyError`

7. **What exception is raised when file doesn't exist?**
   - A) `IOError`
   - B) `FileNotFoundError`
   - C) `OSError`
   - D) `FileError`

8. **What is the base class for most exceptions?**
   - A) `BaseException`
   - B) `Exception`
   - C) `Error`
   - D) `RuntimeError`

9. **What does a traceback show?**
   - A) Exception type only
   - B) Call chain where exception occurred
   - C) Exception message only
   - D) File name only

10. **What exception is raised for invalid value conversion?**
    - A) `TypeError`
    - B) `ValueError`
    - C) `NameError`
    - D) `KeyError`

**Answers**:
1. B) A runtime error that can be handled (exception definition)
2. C) `ZeroDivisionError` (specific exception for division by zero)
3. B) `IndexError` (exception for invalid list/tuple index)
4. A) `KeyError` (exception for missing dictionary key)
5. A) `NameError` (exception for undefined variable)
6. B) `TypeError` (exception for wrong type operations)
7. B) `FileNotFoundError` (exception when file doesn't exist)
8. B) `Exception` (base class for most user-facing exceptions)
9. B) Call chain where exception occurred (traceback shows full call stack)
10. B) `ValueError` (exception for invalid value, like int("abc"))

---

## Next Steps

Excellent work! You've mastered exceptions. You now understand:
- What exceptions are and when they occur
- Common exception types
- Exception hierarchy
- How to read exception messages

**What's Next?**
- Lesson 10.2: Try-Except Blocks
- Learn how to handle exceptions
- Understand try/except/else/finally
- Explore exception handling patterns

---

## Additional Resources

- **Built-in Exceptions**: [docs.python.org/3/library/exceptions.html](https://docs.python.org/3/library/exceptions.html)
- **Exception Hierarchy**: [docs.python.org/3/library/exceptions.html#exception-hierarchy](https://docs.python.org/3/library/exceptions.html#exception-hierarchy)
- **Errors and Exceptions**: [docs.python.org/3/tutorial/errors.html](https://docs.python.org/3/tutorial/errors.html)

---

*Lesson completed! You're ready to move on to the next lesson.*

