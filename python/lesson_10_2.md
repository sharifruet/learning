# Lesson 10.2: Try-Except Blocks

## Learning Objectives

By the end of this lesson, you will be able to:
- Use `try` and `except` blocks to handle exceptions
- Understand the `else` clause in exception handling
- Use the `finally` clause for cleanup
- Handle specific exceptions
- Handle multiple exceptions
- Chain exception handling
- Understand exception handling flow
- Apply exception handling in practical scenarios
- Write robust error-handling code

---

## Introduction to Try-Except Blocks

**Try-except blocks** allow you to catch and handle exceptions, preventing your program from crashing.

### Basic Syntax

```python
try:
    # Code that might raise an exception
    risky_operation()
except ExceptionType:
    # Code to handle the exception
    handle_error()
```

---

## Basic Try-Except

### Simple Try-Except

```python
try:
    result = 10 / 0
except ZeroDivisionError:
    print("Cannot divide by zero")

print("Program continues")
```

### Try-Except with Exception Object

```python
try:
    result = 10 / 0
except ZeroDivisionError as e:
    print(f"Error occurred: {e}")

print("Program continues")
```

### Catching All Exceptions (Not Recommended)

```python
try:
    risky_operation()
except:  # Catches all exceptions (use sparingly)
    print("An error occurred")
```

### Better: Catch Specific Exceptions

```python
try:
    risky_operation()
except ValueError:
    print("Value error occurred")
except TypeError:
    print("Type error occurred")
except Exception as e:  # Catch other exceptions
    print(f"Unexpected error: {e}")
```

---

## Handling Specific Exceptions

### Single Exception

```python
try:
    number = int("abc")
except ValueError:
    print("Invalid number format")
```

### Multiple Specific Exceptions

```python
try:
    result = 10 / 0
except ZeroDivisionError:
    print("Cannot divide by zero")
except TypeError:
    print("Invalid type for division")
```

### Exception with Information

```python
try:
    number = int(input("Enter a number: "))
except ValueError as e:
    print(f"Invalid input: {e}")
```

---

## The `else` Clause

The `else` clause runs if no exception was raised in the `try` block.

### Using `else`

```python
try:
    result = 10 / 2
except ZeroDivisionError:
    print("Cannot divide by zero")
else:
    print(f"Result: {result}")  # Only runs if no exception
```

### Example: File Reading

```python
try:
    with open("file.txt", "r") as file:
        content = file.read()
except FileNotFoundError:
    print("File not found")
else:
    print(f"File read successfully: {len(content)} characters")
```

### When to Use `else`

```python
try:
    value = int(input("Enter a number: "))
except ValueError:
    print("Invalid number")
else:
    # Only executes if conversion succeeded
    print(f"You entered: {value}")
    print(f"Double: {value * 2}")
```

---

## The `finally` Clause

The `finally` clause always executes, whether an exception occurred or not. Use it for cleanup.

### Basic `finally`

```python
try:
    result = 10 / 2
except ZeroDivisionError:
    print("Cannot divide by zero")
finally:
    print("This always runs")
```

### Cleanup Example

```python
file = None
try:
    file = open("data.txt", "r")
    content = file.read()
except FileNotFoundError:
    print("File not found")
finally:
    if file:
        file.close()  # Always close file
    print("Cleanup completed")
```

### `finally` with Context Managers

```python
# Better: Use context manager
try:
    with open("data.txt", "r") as file:
        content = file.read()
except FileNotFoundError:
    print("File not found")
finally:
    print("Cleanup completed")  # Still runs even if exception
```

---

## Complete Try-Except-Else-Finally Structure

### Full Structure

```python
try:
    # Code that might raise exception
    risky_operation()
except SpecificException:
    # Handle specific exception
    handle_specific_error()
except AnotherException:
    # Handle another exception
    handle_another_error()
except Exception as e:
    # Handle any other exception
    handle_general_error(e)
else:
    # Runs if no exception
    handle_success()
finally:
    # Always runs
    cleanup()
```

### Example: Complete Structure

```python
try:
    number = int(input("Enter a number: "))
    result = 100 / number
except ValueError:
    print("Invalid number format")
except ZeroDivisionError:
    print("Cannot divide by zero")
else:
    print(f"Result: {result}")
finally:
    print("Operation completed")
```

---

## Multiple Exception Handling

### Handling Multiple Exceptions Separately

```python
try:
    number = int(input("Enter a number: "))
    result = 100 / number
except ValueError:
    print("Invalid number")
except ZeroDivisionError:
    print("Cannot divide by zero")
except KeyboardInterrupt:
    print("Operation cancelled")
except Exception as e:
    print(f"Unexpected error: {e}")
```

### Handling Multiple Exceptions Together

```python
try:
    risky_operation()
except (ValueError, TypeError) as e:
    print(f"Input error: {e}")
except (ZeroDivisionError, OverflowError) as e:
    print(f"Math error: {e}")
```

### Example: Multiple Exceptions

```python
def process_number(value):
    try:
        number = float(value)
        result = 100 / number
        return result
    except (ValueError, TypeError):
        print("Invalid input type")
    except ZeroDivisionError:
        print("Cannot divide by zero")
    except Exception as e:
        print(f"Unexpected error: {e}")

process_number("abc")      # ValueError
process_number(0)          # ZeroDivisionError
process_number(10)         # Success
```

---

## Exception Handling Flow

### Execution Order

```python
try:
    print("1. Try block starts")
    result = 10 / 2
    print("2. Try block ends")
except ZeroDivisionError:
    print("3. Exception handler")
else:
    print("4. Else clause (no exception)")
finally:
    print("5. Finally clause (always runs)")

# Output:
# 1. Try block starts
# 2. Try block ends
# 4. Else clause (no exception)
# 5. Finally clause (always runs)
```

### Flow with Exception

```python
try:
    print("1. Try block starts")
    result = 10 / 0
    print("2. Try block ends")
except ZeroDivisionError:
    print("3. Exception handler")
else:
    print("4. Else clause (no exception)")
finally:
    print("5. Finally clause (always runs)")

# Output:
# 1. Try block starts
# 3. Exception handler
# 5. Finally clause (always runs)
```

---

## Nested Try-Except Blocks

### Nested Structure

```python
try:
    try:
        number = int(input("Enter number: "))
    except ValueError:
        print("Invalid number format")
        number = 0
    
    result = 100 / number
except ZeroDivisionError:
    print("Cannot divide by zero")
```

### Example: Nested Exception Handling

```python
try:
    try:
        file = open("data.txt", "r")
        content = file.read()
    except FileNotFoundError:
        print("File not found, using default")
        content = "Default content"
    finally:
        if 'file' in locals():
            file.close()
    
    # Process content
    number = int(content)
except ValueError:
    print("Content is not a valid number")
```

---

## Practical Examples

### Example 1: Safe Division

```python
def safe_divide(a, b):
    try:
        result = a / b
        return result
    except ZeroDivisionError:
        print("Warning: Division by zero")
        return None
    except TypeError:
        print("Error: Invalid types for division")
        return None

print(safe_divide(10, 2))   # 5.0
print(safe_divide(10, 0))   # None (with warning)
print(safe_divide(10, "2")) # None (with error)
```

### Example 2: File Operations

```python
def read_file_safely(filename):
    try:
        with open(filename, "r") as file:
            return file.read()
    except FileNotFoundError:
        print(f"File '{filename}' not found")
        return None
    except PermissionError:
        print(f"Permission denied: '{filename}'")
        return None
    except Exception as e:
        print(f"Unexpected error: {e}")
        return None

content = read_file_safely("data.txt")
if content:
    print(f"Read {len(content)} characters")
```

### Example 3: Input Validation

```python
def get_positive_integer():
    while True:
        try:
            value = int(input("Enter a positive integer: "))
            if value <= 0:
                raise ValueError("Number must be positive")
            return value
        except ValueError as e:
            print(f"Invalid input: {e}. Please try again.")
        except KeyboardInterrupt:
            print("\nOperation cancelled")
            return None

number = get_positive_integer()
if number:
    print(f"You entered: {number}")
```

### Example 4: Dictionary Access

```python
def safe_get(dictionary, key, default=None):
    try:
        return dictionary[key]
    except KeyError:
        return default
    except TypeError:
        print("Error: First argument must be a dictionary")
        return default

person = {"name": "Alice", "age": 30}
print(safe_get(person, "name"))      # Alice
print(safe_get(person, "city"))      # None (default)
print(safe_get("not a dict", "key")) # None (with error message)
```

### Example 5: List Operations

```python
def safe_get_item(items, index, default=None):
    try:
        return items[index]
    except IndexError:
        return default
    except TypeError:
        print("Error: First argument must be a list or tuple")
        return default

my_list = [1, 2, 3, 4, 5]
print(safe_get_item(my_list, 2))   # 3
print(safe_get_item(my_list, 10))  # None (default)
```

### Example 6: Resource Cleanup

```python
def process_file(filename):
    file = None
    try:
        file = open(filename, "r")
        data = file.read()
        # Process data
        result = len(data)
        return result
    except FileNotFoundError:
        print(f"File '{filename}' not found")
        return None
    except IOError as e:
        print(f"I/O error: {e}")
        return None
    finally:
        if file:
            file.close()
            print("File closed")

process_file("data.txt")
```

---

## Common Patterns

### Pattern 1: Try-Except-Return

```python
def safe_operation():
    try:
        result = risky_operation()
        return result
    except Exception as e:
        print(f"Error: {e}")
        return None
```

### Pattern 2: Try-Except-Raise

```python
def validate_input(value):
    try:
        number = int(value)
        return number
    except ValueError:
        raise ValueError(f"Cannot convert '{value}' to integer")
```

### Pattern 3: Try-Except-Log

```python
import logging

def process_data(data):
    try:
        result = complex_operation(data)
        return result
    except Exception as e:
        logging.error(f"Error processing data: {e}")
        return None
```

### Pattern 4: Try-Except-Continue (in loops)

```python
numbers = ["10", "20", "abc", "30", "def"]

valid_numbers = []
for num_str in numbers:
    try:
        number = int(num_str)
        valid_numbers.append(number)
    except ValueError:
        continue  # Skip invalid values

print(valid_numbers)  # [10, 20, 30]
```

---

## Common Mistakes and Pitfalls

### 1. Catching Too Broad

```python
# WRONG: Catches everything
try:
    operation()
except:  # Too broad!
    print("Error")

# BETTER: Be specific
try:
    operation()
except SpecificError:
    print("Specific error")
except Exception as e:
    print(f"Other error: {e}")
```

### 2. Silent Failures

```python
# WRONG: Hides errors
try:
    important_operation()
except:
    pass  # Bad!

# BETTER: Log or handle
try:
    important_operation()
except Exception as e:
    print(f"Error: {e}")  # At least log it
```

### 3. Wrong Exception Order

```python
# WRONG: General exception first
try:
    operation()
except Exception:  # Too general, catches everything
    print("Error")
except ValueError:  # Never reached!
    print("Value error")

# CORRECT: Specific first
try:
    operation()
except ValueError:
    print("Value error")
except Exception:
    print("Other error")
```

### 4. Not Using `finally` for Cleanup

```python
# WRONG: Resource might not be cleaned up
file = open("data.txt", "r")
try:
    content = file.read()
except:
    pass
file.close()  # Might not execute if exception

# CORRECT: Use finally
file = open("data.txt", "r")
try:
    content = file.read()
except:
    pass
finally:
    file.close()  # Always executes
```

---

## Best Practices

### 1. Be Specific

```python
# Good: Specific exception
try:
    number = int(value)
except ValueError:
    handle_error()
```

### 2. Don't Suppress Errors

```python
# Good: Log errors
try:
    operation()
except Exception as e:
    logging.error(f"Error: {e}")
```

### 3. Use `finally` for Cleanup

```python
# Good: Always cleanup
try:
    resource = acquire()
    use(resource)
finally:
    release(resource)
```

### 4. Use `else` for Success Cases

```python
# Good: Clear success handling
try:
    result = operation()
except Error:
    handle_error()
else:
    process_result(result)
```

### 5. Order Exceptions Correctly

```python
# Good: Specific to general
try:
    operation()
except SpecificError:
    handle_specific()
except GeneralError:
    handle_general()
```

---

## Practice Exercise

### Exercise: Error Handling

**Objective**: Create a Python program that demonstrates try-except blocks and error handling.

**Instructions**:

1. Create a file called `error_handling_practice.py`

2. Write a program that:
   - Uses try-except blocks
   - Handles specific exceptions
   - Uses else and finally clauses
   - Handles multiple exceptions
   - Demonstrates error handling patterns

3. Your program should include:
   - Basic try-except
   - Multiple exception handling
   - else clause usage
   - finally clause usage
   - Nested try-except
   - Practical error handling scenarios

**Example Solution**:

```python
"""
Error Handling Practice
This program demonstrates try-except blocks and error handling.
"""

print("=" * 60)
print("ERROR HANDLING PRACTICE")
print("=" * 60)
print()

# 1. Basic try-except
print("1. BASIC TRY-EXCEPT")
print("-" * 60)
try:
    result = 10 / 0
except ZeroDivisionError:
    print("Caught ZeroDivisionError: Cannot divide by zero")
print()

# 2. Try-except with exception object
print("2. TRY-EXCEPT WITH EXCEPTION OBJECT")
print("-" * 60)
try:
    number = int("abc")
except ValueError as e:
    print(f"Caught ValueError: {e}")
print()

# 3. Multiple specific exceptions
print("3. MULTIPLE SPECIFIC EXCEPTIONS")
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

# 4. Handling multiple exceptions together
print("4. HANDLING MULTIPLE EXCEPTIONS TOGETHER")
print("-" * 60)
def convert_to_number(value):
    try:
        return float(value)
    except (ValueError, TypeError) as e:
        print(f"Conversion error: {e}")
        return None

print(convert_to_number("123"))   # 123.0
print(convert_to_number("abc"))   # None
print(convert_to_number(None))    # None
print()

# 5. else clause
print("5. ELSE CLAUSE")
print("-" * 60)
try:
    result = 10 / 2
except ZeroDivisionError:
    print("Cannot divide by zero")
else:
    print(f"Division successful: {result}")
print()

# 6. finally clause
print("6. FINALLY CLAUSE")
print("-" * 60)
try:
    result = 10 / 2
except ZeroDivisionError:
    print("Cannot divide by zero")
finally:
    print("Finally block always executes")
print()

# 7. Complete try-except-else-finally
print("7. COMPLETE TRY-EXCEPT-ELSE-FINALLY")
print("-" * 60)
def safe_divide(a, b):
    try:
        result = a / b
    except ZeroDivisionError:
        print("Cannot divide by zero")
        return None
    except TypeError:
        print("Invalid types")
        return None
    else:
        print("Division successful")
        return result
    finally:
        print("Cleanup completed")

print(safe_divide(10, 2))
print()
print(safe_divide(10, 0))
print()

# 8. File operations with error handling
print("8. FILE OPERATIONS WITH ERROR HANDLING")
print("-" * 60)
def read_file_safely(filename):
    try:
        with open(filename, "r") as file:
            content = file.read()
            return content
    except FileNotFoundError:
        print(f"File '{filename}' not found")
        return None
    except PermissionError:
        print(f"Permission denied: '{filename}'")
        return None
    except Exception as e:
        print(f"Unexpected error: {e}")
        return None

# Test with non-existent file
content = read_file_safely("nonexistent.txt")
print()

# 9. Input validation
print("9. INPUT VALIDATION")
print("-" * 60)
def get_integer_input(prompt):
    while True:
        try:
            value = int(input(prompt))
            return value
        except ValueError:
            print("Invalid input. Please enter an integer.")
        except KeyboardInterrupt:
            print("\nOperation cancelled")
            return None

# Uncomment to test:
# number = get_integer_input("Enter an integer: ")
# if number:
#     print(f"You entered: {number}")
print()

# 10. Dictionary access with error handling
print("10. DICTIONARY ACCESS WITH ERROR HANDLING")
print("-" * 60)
def safe_get(dictionary, key, default=None):
    try:
        return dictionary[key]
    except KeyError:
        return default
    except TypeError:
        print("Error: First argument must be a dictionary")
        return default

person = {"name": "Alice", "age": 30}
print(f"Name: {safe_get(person, 'name')}")      # Alice
print(f"City: {safe_get(person, 'city', 'N/A')}")  # N/A
print()

# 11. List operations with error handling
print("11. LIST OPERATIONS WITH ERROR HANDLING")
print("-" * 60)
def safe_get_item(items, index, default=None):
    try:
        return items[index]
    except IndexError:
        return default
    except TypeError:
        print("Error: First argument must be a list or tuple")
        return default

my_list = [1, 2, 3, 4, 5]
print(f"Item at index 2: {safe_get_item(my_list, 2)}")   # 3
print(f"Item at index 10: {safe_get_item(my_list, 10)}")  # None
print()

# 12. Nested try-except
print("12. NESTED TRY-EXCEPT")
print("-" * 60)
try:
    try:
        number = int("123")
        print(f"Converted to int: {number}")
    except ValueError:
        print("Inner: Invalid number")
        number = 0
    
    result = 100 / number
    print(f"Result: {result}")
except ZeroDivisionError:
    print("Outer: Cannot divide by zero")
print()

# 13. Exception chaining
print("13. EXCEPTION CHAINING")
print("-" * 60)
try:
    try:
        result = 10 / 0
    except ZeroDivisionError as e:
        raise ValueError("Invalid operation") from e
except ValueError as e:
    print(f"Caught: {e}")
    print(f"Original: {e.__cause__}")
print()

# 14. Processing list with error handling
print("14. PROCESSING LIST WITH ERROR HANDLING")
print("-" * 60)
numbers = ["10", "20", "abc", "30", "def", "40"]
valid_numbers = []

for num_str in numbers:
    try:
        number = int(num_str)
        valid_numbers.append(number)
    except ValueError:
        print(f"Skipping invalid value: '{num_str}'")
        continue

print(f"Valid numbers: {valid_numbers}")
print()

# 15. Resource cleanup with finally
print("15. RESOURCE CLEANUP WITH FINALLY")
print("-" * 60)
def process_with_cleanup():
    resource = None
    try:
        resource = "Resource acquired"
        print(resource)
        # Simulate operation
        result = 10 / 2
        return result
    except ZeroDivisionError:
        print("Division error")
        return None
    finally:
        if resource:
            print("Cleaning up resource")

result = process_with_cleanup()
print(f"Result: {result}")
print()

# 16. Multiple exception types with different handling
print("16. MULTIPLE EXCEPTION TYPES WITH DIFFERENT HANDLING")
print("-" * 60)
def process_value(value, divisor):
    try:
        number = float(value)
        result = number / divisor
        return result
    except ValueError:
        return "Invalid number format"
    except TypeError:
        return "Invalid type"
    except ZeroDivisionError:
        return "Cannot divide by zero"
    except Exception as e:
        return f"Unexpected error: {e}"

print(process_value("10", 2))      # 5.0
print(process_value("abc", 2))     # Invalid number format
print(process_value(10, 0))        # Cannot divide by zero
print(process_value(10, "2"))      # Invalid type
print()

# 17. Try-except in loop
print("17. TRY-EXCEPT IN LOOP")
print("-" * 60)
data = ["10", "20", "invalid", "30", "0", "40"]
results = []

for item in data:
    try:
        number = int(item)
        if number != 0:
            result = 100 / number
            results.append(result)
        else:
            print(f"Skipping division by zero for '{item}'")
    except ValueError:
        print(f"Skipping invalid value: '{item}'")
    except Exception as e:
        print(f"Error processing '{item}': {e}")

print(f"Results: {results}")
print()

# 18. Exception information extraction
print("18. EXCEPTION INFORMATION EXTRACTION")
print("-" * 60)
try:
    result = 10 / 0
except ZeroDivisionError as e:
    print(f"Exception type: {type(e).__name__}")
    print(f"Exception message: {str(e)}")
    print(f"Exception args: {e.args}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
ERROR HANDLING PRACTICE
============================================================

1. BASIC TRY-EXCEPT
------------------------------------------------------------
Caught ZeroDivisionError: Cannot divide by zero

[... rest of output ...]
```

**Challenge** (Optional):
- Create a robust input validation system
- Build an error logging system
- Create a retry mechanism with exception handling
- Implement graceful error recovery

---

## Key Takeaways

1. **`try` block** contains code that might raise exceptions
2. **`except` block** handles exceptions
3. **`else` clause** runs if no exception occurred
4. **`finally` clause** always runs (for cleanup)
5. **Handle specific exceptions** rather than catching everything
6. **Order matters**: specific exceptions before general ones
7. **Use `except Exception as e`** to capture exception object
8. **Multiple exceptions** can be handled together in one `except`
9. **Nested try-except** blocks allow layered error handling
10. **`finally` is essential** for resource cleanup
11. **`else` is useful** for code that should only run on success
12. **Don't suppress all errors** - log or handle appropriately
13. **Use context managers** (`with`) when possible instead of try-finally
14. **Exception chaining** preserves original exception information
15. **Cleanup code** should go in `finally` blocks

---

## Quiz: Try-Except

Test your understanding with these questions:

1. **What does the `try` block do?**
   - A) Handles exceptions
   - B) Contains code that might raise exceptions
   - C) Always executes
   - D) Cleans up resources

2. **What does the `except` block do?**
   - A) Contains risky code
   - B) Handles exceptions
   - C) Always executes
   - D) Runs on success

3. **When does the `else` clause execute?**
   - A) When exception occurs
   - B) When no exception occurs
   - C) Always
   - D) Never

4. **When does the `finally` clause execute?**
   - A) Only on success
   - B) Only on error
   - C) Always
   - D) Never

5. **What is the correct order of exception handling?**
   - A) General to specific
   - B) Specific to general
   - C) Doesn't matter
   - D) Only one exception

6. **How do you catch multiple exceptions together?**
   - A) `except Exception1, Exception2`
   - B) `except (Exception1, Exception2)`
   - C) `except Exception1 and Exception2`
   - D) `except Exception1 or Exception2`

7. **What should go in the `finally` block?**
   - A) Error handling
   - B) Success code
   - C) Cleanup code
   - D) Main logic

8. **What is wrong with `except:` (bare except)?**
   - A) Nothing
   - B) Catches too broadly
   - C) Doesn't catch anything
   - D) Syntax error

9. **How do you get the exception object?**
   - A) `except Exception`
   - B) `except Exception as e`
   - C) `except Exception e`
   - D) `except e as Exception`

10. **What happens if exception is not caught?**
    - A) Program continues
    - B) Program crashes
    - C) Silent failure
    - D) Returns None

**Answers**:
1. B) Contains code that might raise exceptions (try block purpose)
2. B) Handles exceptions (except block purpose)
3. B) When no exception occurs (else runs on success)
4. C) Always (finally always executes)
5. B) Specific to general (handle specific exceptions first)
6. B) `except (Exception1, Exception2)` (tuple syntax for multiple exceptions)
7. C) Cleanup code (finally is for cleanup)
8. B) Catches too broadly (catches all exceptions, including system exits)
9. B) `except Exception as e` (captures exception object as e)
10. B) Program crashes (uncaught exceptions terminate program)

---

## Next Steps

Excellent work! You've mastered try-except blocks. You now understand:
- How to use try-except blocks
- How to handle specific exceptions
- How to use else and finally clauses
- How to handle multiple exceptions

**What's Next?**
- Lesson 10.3: Raising Exceptions
- Learn how to raise exceptions
- Create custom exceptions
- Understand exception propagation

---

## Additional Resources

- **Errors and Exceptions**: [docs.python.org/3/tutorial/errors.html](https://docs.python.org/3/tutorial/errors.html)
- **Exception Handling**: [docs.python.org/3/reference/compound_stmts.html#try](https://docs.python.org/3/reference/compound_stmts.html#try)
- **Built-in Exceptions**: [docs.python.org/3/library/exceptions.html](https://docs.python.org/3/library/exceptions.html)

---

*Lesson completed! You're ready to move on to the next lesson.*

