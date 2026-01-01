# Lesson 11.2: Creating Modules

## Learning Objectives

By the end of this lesson, you will be able to:
- Create your own Python modules
- Understand module structure and organization
- Use `__name__` and `__main__` for module execution
- Write module documentation
- Organize code into reusable modules
- Understand module naming conventions
- Create modules with functions and classes
- Make modules executable as scripts
- Apply module best practices

---

## Introduction to Creating Modules

Creating your own modules allows you to organize code, reuse functionality, and build maintainable applications.

### What Makes a Module?

- **Python file**: Any `.py` file can be a module
- **Functions and classes**: Define reusable code
- **Variables**: Module-level constants
- **Documentation**: Docstrings and comments

### Benefits of Creating Modules

- **Code organization**: Group related functionality
- **Reusability**: Use in multiple programs
- **Maintainability**: Easier to maintain and update
- **Testing**: Test modules independently

---

## Module Structure

### Basic Module Structure

```python
"""
Module docstring - describes what the module does.
"""

# Imports
import os
import math

# Constants
PI = 3.14159
VERSION = "1.0.0"

# Functions
def greet(name):
    """Greet a person."""
    return f"Hello, {name}!"

# Classes
class Calculator:
    """A simple calculator class."""
    def add(self, a, b):
        return a + b

# Module-level code (runs on import)
print("Module loaded")
```

### Example: Simple Module

```python
# mymodule.py
"""A simple example module."""

def add(a, b):
    """Add two numbers."""
    return a + b

def subtract(a, b):
    """Subtract b from a."""
    return a - b

def multiply(a, b):
    """Multiply two numbers."""
    return a * b

def divide(a, b):
    """Divide a by b."""
    if b == 0:
        raise ValueError("Cannot divide by zero")
    return a / b
```

### Using Your Module

```python
# main.py
import mymodule

result = mymodule.add(5, 3)
print(result)  # Output: 8
```

---

## `__name__` and `__main__`

The `__name__` variable indicates how a module is being used.

### Understanding `__name__`

- **When imported**: `__name__` is the module name
- **When run directly**: `__name__` is `"__main__"`

### Basic `__name__` Usage

```python
# mymodule.py
def function():
    print("Function called")

print(f"Module name: {__name__}")

# When imported: Module name: mymodule
# When run directly: Module name: __main__
```

### Using `if __name__ == "__main__":`

This pattern allows code to run when the module is executed directly, but not when imported.

```python
# mymodule.py
def add(a, b):
    return a + b

def subtract(a, b):
    return a - b

# Code that runs when module is executed directly
if __name__ == "__main__":
    print("Running module directly")
    print(add(5, 3))
    print(subtract(10, 4))
```

### Example: Module with Main Block

```python
# calculator.py
"""Calculator module with basic operations."""

def add(a, b):
    """Add two numbers."""
    return a + b

def subtract(a, b):
    """Subtract two numbers."""
    return a - b

def multiply(a, b):
    """Multiply two numbers."""
    return a * b

def divide(a, b):
    """Divide two numbers."""
    if b == 0:
        raise ValueError("Cannot divide by zero")
    return a / b

# Main block - runs when script is executed directly
if __name__ == "__main__":
    print("Calculator Module")
    print("=" * 30)
    print(f"5 + 3 = {add(5, 3)}")
    print(f"10 - 4 = {subtract(10, 4)}")
    print(f"6 * 7 = {multiply(6, 7)}")
    print(f"15 / 3 = {divide(15, 3)}")
```

### Running Module as Script

```bash
# Run module directly
python calculator.py

# Import module (main block doesn't run)
python -c "import calculator; print(calculator.add(5, 3))"
```

---

## Module Documentation

### Module Docstring

```python
"""
This is a module docstring.

It describes what the module does, its purpose, and how to use it.
It can span multiple lines and is accessible via __doc__.
"""

def function():
    """Function docstring."""
    pass
```

### Complete Module with Documentation

```python
"""
Math Utilities Module

This module provides various mathematical utility functions
including arithmetic operations, number validation, and calculations.

Author: Your Name
Date: 2024-03-15
Version: 1.0.0
"""

def add(a, b):
    """
    Add two numbers.
    
    Args:
        a: First number
        b: Second number
    
    Returns:
        Sum of a and b
    
    Example:
        >>> add(5, 3)
        8
    """
    return a + b

def is_even(number):
    """
    Check if a number is even.
    
    Args:
        number: Number to check
    
    Returns:
        True if number is even, False otherwise
    
    Example:
        >>> is_even(4)
        True
        >>> is_even(5)
        False
    """
    return number % 2 == 0
```

### Accessing Module Documentation

```python
import mymodule

# Access module docstring
print(mymodule.__doc__)

# Access function docstring
print(mymodule.add.__doc__)

# Or use help()
help(mymodule)
help(mymodule.add)
```

---

## Module Organization

### Organizing Functions

```python
# math_utils.py
"""Mathematical utility functions."""

def add(a, b):
    """Add two numbers."""
    return a + b

def subtract(a, b):
    """Subtract two numbers."""
    return a - b

def multiply(a, b):
    """Multiply two numbers."""
    return a * b

def divide(a, b):
    """Divide two numbers."""
    if b == 0:
        raise ValueError("Cannot divide by zero")
    return a / b
```

### Organizing Classes

```python
# shapes.py
"""Shape classes for geometric calculations."""

import math

class Circle:
    """Represents a circle."""
    
    def __init__(self, radius):
        self.radius = radius
    
    def area(self):
        """Calculate circle area."""
        return math.pi * self.radius ** 2
    
    def circumference(self):
        """Calculate circle circumference."""
        return 2 * math.pi * self.radius

class Rectangle:
    """Represents a rectangle."""
    
    def __init__(self, width, height):
        self.width = width
        self.height = height
    
    def area(self):
        """Calculate rectangle area."""
        return self.width * self.height
    
    def perimeter(self):
        """Calculate rectangle perimeter."""
        return 2 * (self.width + self.height)
```

### Module with Constants

```python
# constants.py
"""Application constants."""

# Application info
APP_NAME = "My Application"
VERSION = "1.0.0"
AUTHOR = "Your Name"

# Configuration
MAX_RETRIES = 3
TIMEOUT = 30
DEBUG = False

# Mathematical constants
PI = 3.141592653589793
E = 2.718281828459045
```

---

## Practical Examples

### Example 1: String Utilities Module

```python
# string_utils.py
"""String manipulation utilities."""

def reverse_string(text):
    """Reverse a string."""
    return text[::-1]

def capitalize_words(text):
    """Capitalize first letter of each word."""
    return text.title()

def count_words(text):
    """Count words in a string."""
    return len(text.split())

def remove_whitespace(text):
    """Remove all whitespace from string."""
    return text.replace(" ", "")

if __name__ == "__main__":
    test_string = "hello world python"
    print(f"Original: {test_string}")
    print(f"Reversed: {reverse_string(test_string)}")
    print(f"Capitalized: {capitalize_words(test_string)}")
    print(f"Word count: {count_words(test_string)}")
```

### Example 2: File Utilities Module

```python
# file_utils.py
"""File operation utilities."""

import os
from pathlib import Path

def file_exists(filename):
    """Check if file exists."""
    return os.path.exists(filename)

def get_file_size(filename):
    """Get file size in bytes."""
    if file_exists(filename):
        return os.path.getsize(filename)
    return None

def read_file_lines(filename):
    """Read file and return lines as list."""
    if not file_exists(filename):
        raise FileNotFoundError(f"File '{filename}' not found")
    
    with open(filename, 'r') as file:
        return file.readlines()

def write_file(filename, content):
    """Write content to file."""
    with open(filename, 'w') as file:
        file.write(content)

if __name__ == "__main__":
    # Test the module
    test_file = "test.txt"
    write_file(test_file, "Hello, World!\nPython is great!")
    print(f"File exists: {file_exists(test_file)}")
    print(f"File size: {get_file_size(test_file)} bytes")
    lines = read_file_lines(test_file)
    print(f"Lines: {lines}")
```

### Example 3: Data Validation Module

```python
# validators.py
"""Data validation utilities."""

def validate_email(email):
    """Validate email address format."""
    if not isinstance(email, str):
        return False
    return "@" in email and "." in email.split("@")[1]

def validate_age(age):
    """Validate age (must be positive integer)."""
    if not isinstance(age, int):
        return False
    return 0 <= age <= 150

def validate_phone(phone):
    """Validate phone number format."""
    if not isinstance(phone, str):
        return False
    # Simple validation: 10 digits
    digits = ''.join(filter(str.isdigit, phone))
    return len(digits) == 10

if __name__ == "__main__":
    # Test validators
    print(validate_email("user@example.com"))  # True
    print(validate_email("invalid"))            # False
    print(validate_age(30))                     # True
    print(validate_age(-5))                     # False
    print(validate_phone("123-456-7890"))       # True
```

---

## Module Best Practices

### 1. Use Descriptive Names

```python
# Good: Descriptive name
import math_utils
import file_helpers
import data_validators

# Avoid: Generic names
import utils
import helpers
import stuff
```

### 2. Write Documentation

```python
"""
Module docstring explaining purpose and usage.
"""

def function():
    """Function docstring with parameters and return value."""
    pass
```

### 3. Organize Code Logically

```python
# 1. Module docstring
# 2. Imports
# 3. Constants
# 4. Functions
# 5. Classes
# 6. if __name__ == "__main__":
```

### 4. Use `if __name__ == "__main__":`

```python
def main_functionality():
    pass

if __name__ == "__main__":
    # Code to run when executed directly
    main_functionality()
```

### 5. Avoid Module-Level Code (when imported)

```python
# Avoid: Code that runs on import
print("Module loaded")  # Runs every time module is imported

# Better: Use if __name__ == "__main__":
if __name__ == "__main__":
    print("Module loaded")  # Only runs when executed directly
```

---

## Common Mistakes and Pitfalls

### 1. Module-Level Side Effects

```python
# WRONG: Side effects on import
print("Module imported")  # Runs every time!

# BETTER: Use if __name__ == "__main__":
if __name__ == "__main__":
    print("Module executed directly")
```

### 2. Poor Module Names

```python
# WRONG: Generic or confusing names
import utils
import helper
import stuff

# BETTER: Descriptive names
import math_utils
import file_helpers
import data_processors
```

### 3. Missing Documentation

```python
# WRONG: No documentation
def function(x, y):
    return x + y

# BETTER: Include docstrings
def function(x, y):
    """Add two numbers together."""
    return x + y
```

### 4. Circular Imports

```python
# WRONG: Circular import
# module_a.py
import module_b

# module_b.py
import module_a  # Circular!

# BETTER: Reorganize to avoid circular dependencies
```

---

## Practice Exercise

### Exercise: Creating Modules

**Objective**: Create Python modules demonstrating module structure and best practices.

**Instructions**:

1. Create multiple module files that demonstrate:
   - Module structure
   - Functions and classes
   - Documentation
   - `__name__` and `__main__`
   - Module organization

2. Create a main file that imports and uses your modules

3. Your modules should include:
   - Module docstrings
   - Function docstrings
   - Constants
   - Functions
   - Classes
   - Main blocks

**Example Solution**:

```python
"""
Module Creation Practice
This demonstrates creating and using Python modules.
"""

# This would be in separate files, but shown together for practice

# ============================================================
# File: math_utils.py
# ============================================================
"""
Mathematical Utilities Module

Provides basic mathematical operations and utilities.
"""

def add(a, b):
    """Add two numbers."""
    return a + b

def subtract(a, b):
    """Subtract b from a."""
    return a - b

def multiply(a, b):
    """Multiply two numbers."""
    return a * b

def divide(a, b):
    """Divide a by b."""
    if b == 0:
        raise ValueError("Cannot divide by zero")
    return a / b

def is_even(number):
    """Check if number is even."""
    return number % 2 == 0

def is_prime(number):
    """Check if number is prime."""
    if number < 2:
        return False
    for i in range(2, int(number ** 0.5) + 1):
        if number % i == 0:
            return False
    return True

if __name__ == "__main__":
    print("Math Utils Module")
    print(f"5 + 3 = {add(5, 3)}")
    print(f"10 - 4 = {subtract(10, 4)}")
    print(f"6 * 7 = {multiply(6, 7)}")
    print(f"15 / 3 = {divide(15, 3)}")
    print(f"Is 4 even? {is_even(4)}")
    print(f"Is 7 prime? {is_prime(7)}")

# ============================================================
# File: string_utils.py
# ============================================================
"""
String Utilities Module

Provides string manipulation functions.
"""

def reverse_string(text):
    """Reverse a string."""
    return text[::-1]

def capitalize_words(text):
    """Capitalize first letter of each word."""
    return text.title()

def count_words(text):
    """Count words in a string."""
    return len(text.split())

def remove_whitespace(text):
    """Remove all whitespace from string."""
    return text.replace(" ", "")

def is_palindrome(text):
    """Check if string is a palindrome."""
    cleaned = text.lower().replace(" ", "")
    return cleaned == cleaned[::-1]

if __name__ == "__main__":
    test_string = "hello world"
    print(f"Original: {test_string}")
    print(f"Reversed: {reverse_string(test_string)}")
    print(f"Capitalized: {capitalize_words(test_string)}")
    print(f"Word count: {count_words(test_string)}")
    print(f"Is 'racecar' palindrome? {is_palindrome('racecar')}")

# ============================================================
# File: constants.py
# ============================================================
"""
Constants Module

Application-wide constants.
"""

APP_NAME = "My Application"
VERSION = "1.0.0"
AUTHOR = "Python Learner"

# Mathematical constants
PI = 3.141592653589793
E = 2.718281828459045

# Configuration
MAX_RETRIES = 3
TIMEOUT = 30

# Status codes
STATUS_OK = 200
STATUS_ERROR = 500
STATUS_NOT_FOUND = 404

if __name__ == "__main__":
    print(f"Application: {APP_NAME}")
    print(f"Version: {VERSION}")
    print(f"Author: {AUTHOR}")
    print(f"PI: {PI}")
    print(f"E: {E}")

# ============================================================
# File: shapes.py
# ============================================================
"""
Shapes Module

Geometric shape classes and calculations.
"""

import math

class Circle:
    """Represents a circle."""
    
    def __init__(self, radius):
        self.radius = radius
    
    def area(self):
        """Calculate circle area."""
        return math.pi * self.radius ** 2
    
    def circumference(self):
        """Calculate circle circumference."""
        return 2 * math.pi * self.radius

class Rectangle:
    """Represents a rectangle."""
    
    def __init__(self, width, height):
        self.width = width
        self.height = height
    
    def area(self):
        """Calculate rectangle area."""
        return self.width * self.height
    
    def perimeter(self):
        """Calculate rectangle perimeter."""
        return 2 * (self.width + self.height)

if __name__ == "__main__":
    circle = Circle(5)
    print(f"Circle (r=5): area={circle.area():.2f}, circumference={circle.circumference():.2f}")
    
    rect = Rectangle(4, 6)
    print(f"Rectangle (4x6): area={rect.area()}, perimeter={rect.perimeter()}")

# ============================================================
# File: main.py (using the modules)
# ============================================================
"""
Main script demonstrating module usage.
"""

# In a real scenario, these would be in separate files
# For this example, we'll show how they would be imported and used

print("=" * 60)
print("MODULE CREATION PRACTICE")
print("=" * 60)
print()

# Note: In practice, you would have separate .py files
# Here's how you would use them:

print("1. Using math_utils module")
print("-" * 60)
# import math_utils
# print(math_utils.add(5, 3))
# print(math_utils.is_prime(7))
print("(In practice: import math_utils)")
print()

print("2. Using string_utils module")
print("-" * 60)
# import string_utils
# print(string_utils.reverse_string("hello"))
# print(string_utils.is_palindrome("racecar"))
print("(In practice: import string_utils)")
print()

print("3. Using constants module")
print("-" * 60)
# import constants
# print(constants.APP_NAME)
# print(constants.VERSION)
print("(In practice: import constants)")
print()

print("4. Using shapes module")
print("-" * 60)
# import shapes
# circle = shapes.Circle(5)
# print(circle.area())
print("(In practice: import shapes)")
print()

print("5. Module documentation")
print("-" * 60)
# import math_utils
# print(math_utils.__doc__)
# help(math_utils)
print("(In practice: help(module_name))")
print()

print("6. __name__ variable")
print("-" * 60)
print(f"Current module __name__: {__name__}")
print("When imported, __name__ is module name")
print("When run directly, __name__ is '__main__'")
print()

print("7. Module structure example")
print("-" * 60)
print("""
# Module structure:
# 1. Module docstring
# 2. Imports
# 3. Constants
# 4. Functions
# 5. Classes
# 6. if __name__ == "__main__": block
""")

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
print()
print("Note: In a real project, create separate .py files for each module.")
print("Then import them using: import module_name")
```

**Expected Output**:
```
============================================================
MODULE CREATION PRACTICE
============================================================

1. Using math_utils module
------------------------------------------------------------
(In practice: import math_utils)

[... rest of output ...]
```

**Challenge** (Optional):
- Create a complete utility module library
- Build a module with configuration management
- Create modules for specific domains (math, strings, files, etc.)
- Organize modules into a package structure

---

## Key Takeaways

1. **Any `.py` file** can be a module
2. **Module structure**: docstring, imports, constants, functions, classes
3. **`__name__` variable** indicates how module is used
4. **`if __name__ == "__main__":`** runs code only when executed directly
5. **Module docstrings** describe the module's purpose
6. **Function docstrings** document function behavior
7. **Use descriptive names** for modules
8. **Organize code logically** within modules
9. **Avoid module-level side effects** when imported
10. **Document your modules** with docstrings
11. **Test modules** using `if __name__ == "__main__":`
12. **Module docstrings** are accessible via `__doc__`
13. **Help function** shows module documentation
14. **Separate modules** by functionality
15. **Follow PEP 8** style guidelines for modules

---

## Quiz: Module Creation

Test your understanding with these questions:

1. **What makes a Python file a module?**
   - A) Special declaration
   - B) Any .py file
   - C) Must have classes
   - D) Must be in package

2. **What is `__name__` when a module is imported?**
   - A) `"__main__"`
   - B) Module filename
   - C) `None`
   - D) `"module"`

3. **What is `__name__` when a module is run directly?**
   - A) Module filename
   - B) `"__main__"`
   - C) `None`
   - D) `"module"`

4. **What does `if __name__ == "__main__":` do?**
   - A) Always runs
   - B) Runs only when imported
   - C) Runs only when executed directly
   - D) Never runs

5. **Where should module docstring be placed?**
   - A) At end of file
   - B) At top of file
   - C) After imports
   - D) Doesn't matter

6. **What should you avoid in modules?**
   - A) Functions
   - B) Classes
   - C) Side effects on import
   - D) Documentation

7. **How do you access module documentation?**
   - A) `module.__doc__`
   - B) `module.doc`
   - C) `module.help()`
   - D) `module.info()`

8. **What is the recommended module structure?**
   - A) Random order
   - B) Docstring, imports, code
   - C) Code, imports, docstring
   - D) Doesn't matter

9. **What should module names be?**
   - A) Generic
   - B) Descriptive
   - C) Short
   - D) Numbers

10. **How do you make a module executable as script?**
    - A) `if __main__`
    - B) `if __name__ == "__main__":`
    - C) `if main():`
    - D) `if run():`

**Answers**:
1. B) Any .py file (any Python file can be a module)
2. B) Module filename (__name__ is the module name when imported)
3. B) `"__main__"` (__name__ is "__main__" when run directly)
4. C) Runs only when executed directly (main block pattern)
5. B) At top of file (module docstring should be first)
6. C) Side effects on import (avoid code that runs on import)
7. A) `module.__doc__` (access module docstring)
8. B) Docstring, imports, code (recommended structure)
9. B) Descriptive (use descriptive module names)
10. B) `if __name__ == "__main__":` (standard pattern for executable modules)

---

## Next Steps

Excellent work! You've mastered creating modules. You now understand:
- How to create modules
- Module structure and organization
- Using __name__ and __main__
- Module documentation

**What's Next?**
- Lesson 11.3: Packages
- Learn about package structure
- Understand __init__.py
- Explore package organization

---

## Additional Resources

- **Modules**: [docs.python.org/3/tutorial/modules.html](https://docs.python.org/3/tutorial/modules.html)
- **PEP 257 - Docstring Conventions**: [peps.python.org/pep-0257/](https://peps.python.org/pep-0257/)
- **Module Documentation**: [docs.python.org/3/tutorial/modules.html#more-on-modules](https://docs.python.org/3/tutorial/modules.html#more-on-modules)

---

*Lesson completed! You're ready to move on to the next lesson.*

