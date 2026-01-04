# Lesson 24.1: PEP 8 Style Guide

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what PEP 8 is and why it's important
- Apply PEP 8 code formatting rules
- Follow Python naming conventions
- Organize code properly
- Use proper indentation and spacing
- Format imports correctly
- Write readable code
- Use code formatters (black, autopep8)
- Apply PEP 8 best practices
- Review code for style compliance
- Debug style-related issues

---

## Introduction to PEP 8

**PEP 8** (Python Enhancement Proposal 8) is the official style guide for Python code. It provides conventions for writing readable, consistent Python code.

**Why PEP 8 Matters**:
- **Readability**: Code is easier to read and understand
- **Consistency**: All Python code follows the same style
- **Maintainability**: Easier to maintain and modify
- **Collaboration**: Team members can work together more effectively
- **Professional**: Shows professionalism and attention to detail

**Key Principles**:
- Readability counts
- Consistency is important
- Don't break backward compatibility
- Be practical

---

## Code Formatting

### Indentation

```python
# CORRECT: Use 4 spaces for indentation
def function():
    if condition:
        do_something()
        if nested_condition:
            do_nested()

# WRONG: Using tabs or wrong number of spaces
def function():
	if condition:  # Tab instead of spaces
		do_something()
```

### Maximum Line Length

```python
# CORRECT: Lines should not exceed 79 characters (or 99 for comments)
# For long lines, use parentheses for implicit line continuation
result = (value1 + value2 + value3 + 
          value4 + value5)

# Or use backslash for explicit continuation
result = value1 + value2 + value3 + \
         value4 + value5

# WRONG: Very long line
result = value1 + value2 + value3 + value4 + value5 + value6 + value7 + value8 + value9
```

### Blank Lines

```python
# CORRECT: Use blank lines to separate top-level functions and classes
import os
import sys

class MyClass:
    def method1(self):
        pass
    
    def method2(self):
        pass


def function1():
    pass


def function2():
    pass

# WRONG: No blank lines between functions
def function1():
    pass
def function2():
    pass
```

### Whitespace

```python
# CORRECT: Spaces around operators
result = a + b
if x == y:
    pass

# CORRECT: No spaces inside parentheses
my_function(arg1, arg2)

# CORRECT: Spaces after commas
my_list = [1, 2, 3, 4]

# WRONG: No spaces around operators
result=a+b
if x==y:
    pass

# WRONG: Spaces inside parentheses
my_function( arg1, arg2 )
```

### Trailing Whitespace

```python
# CORRECT: No trailing whitespace
def function():
    return value

# WRONG: Trailing whitespace at end of line
def function():
    return value    
```

---

## Naming Conventions

### Variables and Functions

```python
# CORRECT: Use lowercase with underscores (snake_case)
user_name = "Alice"
total_count = 100
def calculate_total():
    pass

# WRONG: CamelCase for variables/functions
userName = "Alice"
totalCount = 100
def CalculateTotal():
    pass
```

### Constants

```python
# CORRECT: Uppercase with underscores
MAX_SIZE = 100
DEFAULT_TIMEOUT = 30
API_BASE_URL = "https://api.example.com"

# WRONG: Lowercase constants
max_size = 100
default_timeout = 30
```

### Classes

```python
# CORRECT: Use CapWords (PascalCase)
class UserManager:
    pass

class DatabaseConnection:
    pass

# WRONG: snake_case for classes
class user_manager:
    pass
```

### Private Variables and Methods

```python
# CORRECT: Single leading underscore for "internal use"
class MyClass:
    def __init__(self):
        self._internal_var = 10
    
    def _internal_method(self):
        pass

# CORRECT: Double leading underscore for name mangling
class MyClass:
    def __init__(self):
        self.__private_var = 20
    
    def __private_method(self):
        pass

# CORRECT: Trailing underscore to avoid conflicts
class_ = "MyClass"  # 'class' is a keyword
```

### Module and Package Names

```python
# CORRECT: Short, lowercase, no underscores if possible
# mymodule.py
# mypackage/

# WRONG: CamelCase or mixed case
# MyModule.py
# MyPackage/
```

---

## Code Organization

### Imports

```python
# CORRECT: Import order
# 1. Standard library imports
import os
import sys
from datetime import datetime

# 2. Related third party imports
import requests
import numpy as np

# 3. Local application/library specific imports
from myapp.models import User
from myapp.utils import helper_function

# CORRECT: One import per line
import os
import sys

# WRONG: Multiple imports on one line
import os, sys

# CORRECT: Group imports with blank line between groups
import os
import sys

import requests

from myapp import utils
```

### Module-Level Dunder Names

```python
# CORRECT: Order of module-level dunder names
"""Module docstring."""

__version__ = '1.0.0'
__author__ = 'Your Name'

import os
import sys

# Constants
MAX_SIZE = 100

# Classes
class MyClass:
    pass

# Functions
def my_function():
    pass

# Main execution
if __name__ == '__main__':
    main()
```

### Function and Method Arguments

```python
# CORRECT: Function arguments
def function(arg1, arg2, arg3=None, arg4='default'):
    pass

# CORRECT: Long argument lists
def function(
    arg1,
    arg2,
    arg3=None,
    arg4='default'
):
    pass

# CORRECT: Keyword arguments
result = function(
    arg1=value1,
    arg2=value2,
    arg3=value3
)
```

---

## Specific Style Rules

### Comparisons

```python
# CORRECT: Use 'is' for None, True, False
if value is None:
    pass

if condition is True:
    pass

# CORRECT: Use == for values
if x == 5:
    pass

# WRONG: Using == with None
if value == None:  # Use 'is None' instead
    pass
```

### String Quotes

```python
# CORRECT: Use single quotes for strings (or double quotes, be consistent)
message = 'Hello, World!'
name = "Alice"

# CORRECT: Use triple quotes for docstrings
def function():
    """This is a docstring."""
    pass

# CORRECT: Use the opposite quote inside
message = "It's a beautiful day"
message = 'He said "Hello"'
```

### Function Definitions

```python
# CORRECT: Function definition style
def function_name(arg1, arg2, arg3=None):
    """Function docstring."""
    pass

# CORRECT: Long function signature
def function_name(
    arg1,
    arg2,
    arg3=None,
    arg4='default'
):
    """Function docstring."""
    pass
```

### Class Definitions

```python
# CORRECT: Class definition style
class MyClass:
    """Class docstring."""
    
    def __init__(self, arg1, arg2):
        """Initialize the class."""
        self.arg1 = arg1
        self.arg2 = arg2
    
    def method(self):
        """Method docstring."""
        pass
```

---

## Code Formatters

### Using black

```bash
# Install black
pip install black

# Format a file
black myfile.py

# Format a directory
black myproject/

# Check without formatting
black --check myfile.py
```

### Using autopep8

```bash
# Install autopep8
pip install autopep8

# Format a file
autopep8 --in-place myfile.py

# Format with aggressive mode
autopep8 --in-place --aggressive myfile.py

# Check without formatting
autopep8 --diff myfile.py
```

### Using isort

```bash
# Install isort
pip install isort

# Sort imports
isort myfile.py

# Check without sorting
isort --check-only myfile.py
```

---

## Common PEP 8 Violations

### Violation Examples

```python
# WRONG: Multiple violations
class myClass:  # Should be MyClass
    def __init__(self,x,y):  # Missing spaces
        self.x=x  # Missing spaces
        self.y=y
    
    def calculateTotal(self):  # Should be calculate_total
        return self.x+self.y  # Missing spaces

# CORRECT: PEP 8 compliant
class MyClass:
    def __init__(self, x, y):
        self.x = x
        self.y = y
    
    def calculate_total(self):
        return self.x + self.y
```

### Fixing Common Issues

```python
# WRONG: Inconsistent spacing
if x==5:
    result=a+b

# CORRECT: Proper spacing
if x == 5:
    result = a + b

# WRONG: Wrong naming
def CalculateTotal():
    pass

# CORRECT: snake_case
def calculate_total():
    pass

# WRONG: Long line
very_long_variable_name = some_function_call_with_many_arguments(arg1, arg2, arg3, arg4, arg5)

# CORRECT: Break into multiple lines
very_long_variable_name = some_function_call_with_many_arguments(
    arg1, arg2, arg3, arg4, arg5
)
```

---

## Best Practices

### 1. Be Consistent

```python
# Choose a style and stick with it
# If using single quotes, use them consistently
message1 = 'Hello'
message2 = 'World'

# If using double quotes, use them consistently
message1 = "Hello"
message2 = "World"
```

### 2. Readability Over Strict Rules

```python
# Sometimes breaking a rule improves readability
# PEP 8 allows exceptions when following the rule would make code less readable
```

### 3. Use Tools

```python
# Use linters and formatters
# - black: Code formatter
# - flake8: Linter
# - pylint: Linter
# - isort: Import sorter
```

### 4. Document Exceptions

```python
# If you must break a PEP 8 rule, document why
def function(arg1, arg2, arg3, arg4, arg5, arg6, arg7):
    # This function signature violates line length, but it's required
    # by the external API we're integrating with
    pass
```

---

## Practical Examples

### Example 1: Before and After PEP 8

```python
# BEFORE: Not PEP 8 compliant
class userManager:
    def __init__(self,userName,userEmail):
        self.userName=userName
        self.userEmail=userEmail
    
    def getUserInfo(self):
        return self.userName+" "+self.userEmail

# AFTER: PEP 8 compliant
class UserManager:
    def __init__(self, user_name, user_email):
        self.user_name = user_name
        self.user_email = user_email
    
    def get_user_info(self):
        return f"{self.user_name} {self.user_email}"
```

### Example 2: Proper Code Organization

```python
"""User management module.

This module provides functionality for managing users.
"""

__version__ = '1.0.0'

# Standard library imports
import os
from datetime import datetime

# Third-party imports
import requests

# Local imports
from .models import User
from .utils import validate_email


# Constants
MAX_USERNAME_LENGTH = 50
DEFAULT_TIMEOUT = 30


# Classes
class UserManager:
    """Manages user operations."""
    
    def __init__(self, api_url):
        """Initialize UserManager.
        
        Args:
            api_url: Base URL for the API
        """
        self.api_url = api_url
    
    def create_user(self, username, email):
        """Create a new user.
        
        Args:
            username: User's username
            email: User's email address
        
        Returns:
            User object if successful, None otherwise
        """
        if not validate_email(email):
            return None
        
        # Implementation
        pass


# Functions
def get_user_by_id(user_id):
    """Get user by ID.
    
    Args:
        user_id: User ID
    
    Returns:
        User object
    """
    # Implementation
    pass


# Main execution
if __name__ == '__main__':
    manager = UserManager('https://api.example.com')
    user = manager.create_user('alice', 'alice@example.com')
```

---

## Practice Exercise

### Exercise: Code Style

**Objective**: Refactor code to follow PEP 8 style guide.

**Instructions**:

1. Review the provided code
2. Identify PEP 8 violations
3. Refactor the code to be PEP 8 compliant
4. Use proper naming conventions
5. Format code correctly
6. Organize imports properly

**Example Solution**:

```python
"""
Refactored Code - PEP 8 Compliant
Original code had multiple PEP 8 violations
"""

# Standard library imports
import os
from datetime import datetime

# Third-party imports
import requests

# Constants
MAX_SIZE = 100
DEFAULT_TIMEOUT = 30
API_BASE_URL = "https://api.example.com"


class UserManager:
    """Manages user operations."""
    
    def __init__(self, api_url=None):
        """Initialize UserManager.
        
        Args:
            api_url: Base URL for the API (defaults to API_BASE_URL)
        """
        self.api_url = api_url or API_BASE_URL
        self._session = requests.Session()
    
    def create_user(self, username, email, age=None):
        """Create a new user.
        
        Args:
            username: User's username
            email: User's email address
            age: User's age (optional)
        
        Returns:
            dict: User data if successful, None otherwise
        """
        if not self._validate_email(email):
            return None
        
        user_data = {
            'username': username,
            'email': email
        }
        
        if age is not None:
            user_data['age'] = age
        
        try:
            response = self._session.post(
                f'{self.api_url}/users',
                json=user_data,
                timeout=DEFAULT_TIMEOUT
            )
            response.raise_for_status()
            return response.json()
        except requests.RequestException as e:
            print(f'Error creating user: {e}')
            return None
    
    def get_user(self, user_id):
        """Get user by ID.
        
        Args:
            user_id: User ID
        
        Returns:
            dict: User data if found, None otherwise
        """
        try:
            response = self._session.get(
                f'{self.api_url}/users/{user_id}',
                timeout=DEFAULT_TIMEOUT
            )
            response.raise_for_status()
            return response.json()
        except requests.RequestException as e:
            print(f'Error getting user: {e}')
            return None
    
    def _validate_email(self, email):
        """Validate email address.
        
        Args:
            email: Email address to validate
        
        Returns:
            bool: True if valid, False otherwise
        """
        import re
        pattern = r'^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$'
        return bool(re.match(pattern, email))


def calculate_total(items, discount=0.0):
    """Calculate total price with discount.
    
    Args:
        items: List of items with 'price' key
        discount: Discount percentage (0.0 to 1.0)
    
    Returns:
        float: Total price after discount
    """
    if not items:
        return 0.0
    
    subtotal = sum(item.get('price', 0) for item in items)
    total = subtotal * (1 - discount)
    return round(total, 2)


def process_files(directory, extension='.txt'):
    """Process all files with given extension.
    
    Args:
        directory: Directory path
        extension: File extension to filter
    
    Returns:
        list: List of processed file paths
    """
    directory_path = os.path.join(os.getcwd(), directory)
    processed_files = []
    
    if not os.path.exists(directory_path):
        print(f'Directory not found: {directory_path}')
        return processed_files
    
    for filename in os.listdir(directory_path):
        if filename.endswith(extension):
            file_path = os.path.join(directory_path, filename)
            processed_files.append(file_path)
            print(f'Processed: {filename}')
    
    return processed_files


def main():
    """Main function."""
    # Create user manager
    manager = UserManager()
    
    # Create user
    user = manager.create_user(
        username='alice',
        email='alice@example.com',
        age=25
    )
    
    if user:
        print(f'Created user: {user["username"]}')
    
    # Calculate total
    items = [
        {'name': 'Item 1', 'price': 10.50},
        {'name': 'Item 2', 'price': 20.00},
        {'name': 'Item 3', 'price': 15.75}
    ]
    total = calculate_total(items, discount=0.1)
    print(f'Total: ${total:.2f}')


if __name__ == '__main__':
    main()
```

**Expected Output**: PEP 8 compliant code with proper formatting, naming, and organization.

**Challenge** (Optional):
- Use black to format the code
- Use flake8 to check for violations
- Add type hints
- Add comprehensive docstrings
- Create a style guide for your project

---

## Key Takeaways

1. **PEP 8** - Official Python style guide
2. **Indentation** - Use 4 spaces
3. **Line length** - Maximum 79 characters (99 for comments)
4. **Naming** - snake_case for variables/functions, CapWords for classes
5. **Constants** - UPPER_CASE with underscores
6. **Imports** - Group and order properly
7. **Whitespace** - Use consistently
8. **Blank lines** - Separate top-level definitions
9. **Code formatters** - Use black, autopep8, isort
10. **Consistency** - Be consistent within your codebase
11. **Readability** - Readability counts more than strict rules
12. **Tools** - Use linters and formatters
13. **Documentation** - Document exceptions to rules
14. **Best practices** - Follow PEP 8 for professional code
15. **Code review** - Review code for style compliance

---

## Quiz: PEP 8

Test your understanding with these questions:

1. **What is PEP 8?**
   - A) Python Enhancement Proposal 8
   - B) Python style guide
   - C) Code formatting standard
   - D) All of the above

2. **How many spaces for indentation?**
   - A) 2
   - B) 4
   - C) 8
   - D) Any

3. **What is the maximum line length?**
   - A) 79 characters
   - B) 80 characters
   - C) 100 characters
   - D) 120 characters

4. **What naming convention for variables?**
   - A) camelCase
   - B) snake_case
   - C) PascalCase
   - D) kebab-case

5. **What naming convention for classes?**
   - A) camelCase
   - B) snake_case
   - C) CapWords
   - D) lowercase

6. **What naming convention for constants?**
   - A) UPPER_CASE
   - B) lower_case
   - C) CamelCase
   - D) mixedCase

7. **What compares with None?**
   - A) ==
   - B) is
   - C) =
   - D) !=

8. **What formats Python code?**
   - A) black
   - B) autopep8
   - C) isort
   - D) All of the above

9. **What separates top-level functions?**
   - A) One blank line
   - B) Two blank lines
   - C) Three blank lines
   - D) No blank lines

10. **What is most important in PEP 8?**
    - A) Strict rules
    - B) Readability
    - C) Performance
    - D) Speed

**Answers**:
1. D) All of the above (PEP 8 definition)
2. B) 4 (indentation spaces)
3. A) 79 characters (line length)
4. B) snake_case (variable naming)
5. C) CapWords (class naming)
6. A) UPPER_CASE (constant naming)
7. B) is (None comparison)
8. D) All of the above (code formatters)
9. B) Two blank lines (function separation)
10. B) Readability (PEP 8 principle)

---

## Next Steps

Excellent work! You've mastered PEP 8 style guide. You now understand:
- Code formatting
- Naming conventions
- Code organization
- How to write PEP 8 compliant code

**What's Next?**
- Lesson 24.2: Code Documentation
- Learn docstrings
- Work with type hints
- Understand documentation best practices

---

## Additional Resources

- **PEP 8**: [pep8.org/](https://pep8.org/)
- **PEP 8 Official**: [www.python.org/dev/peps/pep-0008/](https://www.python.org/dev/peps/pep-0008/)
- **black**: [github.com/psf/black](https://github.com/psf/black)
- **autopep8**: [github.com/hhatto/autopep8](https://github.com/hhatto/autopep8)
- **flake8**: [flake8.pycqa.org/](https://flake8.pycqa.org/)

---

*Lesson completed! You're ready to move on to the next lesson.*

