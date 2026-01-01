# Lesson 11.3: Packages

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what packages are and how they're structured
- Create Python packages
- Use `__init__.py` files
- Import from packages
- Understand package hierarchy
- Organize code into packages
- Use package imports effectively
- Understand namespace packages
- Apply package best practices

---

## Introduction to Packages

**Packages** are a way of organizing related modules into directories. A package is essentially a directory containing Python modules and an `__init__.py` file.

### What Are Packages?

- **Directory structure**: Packages are directories containing modules
- **Organization**: Group related modules together
- **Namespace**: Provide hierarchical namespace
- **Reusability**: Easier to share and distribute code

### Packages vs Modules

- **Module**: A single `.py` file
- **Package**: A directory containing multiple modules (and possibly sub-packages)

---

## Package Structure

### Basic Package Structure

```
mypackage/
    __init__.py
    module1.py
    module2.py
```

### Example Package Structure

```
mypackage/
    __init__.py
    module1.py
    module2.py
    subpackage/
        __init__.py
        submodule1.py
        submodule2.py
```

### Real-World Example

```
mylib/
    __init__.py
    math_utils.py
    string_utils.py
    file_utils.py
    data/
        __init__.py
        validators.py
        processors.py
```

---

## The `__init__.py` File

The `__init__.py` file makes a directory a Python package. It can be empty or contain initialization code.

### Empty `__init__.py`

```python
# mypackage/__init__.py
# Empty file - makes directory a package
```

### `__init__.py` with Code

```python
# mypackage/__init__.py
"""My package documentation."""

# Package-level variables
VERSION = "1.0.0"
AUTHOR = "Your Name"

# Import commonly used items
from .module1 import function1
from .module2 import Class1

# Package initialization code
print("Package initialized")
```

### Example: Package Initialization

```python
# mypackage/__init__.py
"""
My Package

A collection of utility modules.
"""

__version__ = "1.0.0"
__author__ = "Your Name"

# Make key items available at package level
from .math_utils import add, subtract
from .string_utils import reverse_string

# Package-level initialization
def initialize():
    """Initialize package."""
    print("Package initialized")

# This runs when package is imported
print(f"MyPackage {__version__} loaded")
```

---

## Creating Packages

### Step 1: Create Directory Structure

```bash
mkdir mypackage
cd mypackage
touch __init__.py
touch module1.py
touch module2.py
```

### Step 2: Create `__init__.py`

```python
# mypackage/__init__.py
"""My package."""
```

### Step 3: Create Modules

```python
# mypackage/module1.py
def function1():
    return "Function 1"

def function2():
    return "Function 2"
```

```python
# mypackage/module2.py
class MyClass:
    def method(self):
        return "Method called"
```

### Step 4: Use the Package

```python
# main.py
import mypackage.module1
from mypackage import module2

result = mypackage.module1.function1()
obj = module2.MyClass()
```

---

## Package Imports

### Importing Entire Module

```python
import mypackage.module1

mypackage.module1.function1()
```

### Importing from Package

```python
from mypackage import module1

module1.function1()
```

### Importing Specific Items

```python
from mypackage.module1 import function1

function1()
```

### Importing from Sub-packages

```python
from mypackage.subpackage import submodule1

submodule1.function()
```

### Example: Package Import Patterns

```python
# Pattern 1: Full path
import mypackage.math_utils
result = mypackage.math_utils.add(5, 3)

# Pattern 2: Import module
from mypackage import math_utils
result = math_utils.add(5, 3)

# Pattern 3: Import function
from mypackage.math_utils import add
result = add(5, 3)

# Pattern 4: Import multiple
from mypackage.math_utils import add, subtract, multiply
```

---

## Package Hierarchy

### Nested Packages

```
mylib/
    __init__.py
    core/
        __init__.py
        base.py
        utils.py
    data/
        __init__.py
        validators.py
        processors.py
    ui/
        __init__.py
        components.py
        layouts.py
```

### Importing from Nested Packages

```python
# Import from nested package
from mylib.core import base
from mylib.data import validators
from mylib.ui import components

# Or with full path
import mylib.core.base
import mylib.data.validators
```

---

## Practical Examples

### Example 1: Math Utilities Package

```
mathutils/
    __init__.py
    basic.py
    advanced.py
```

```python
# mathutils/__init__.py
"""Math utilities package."""

from .basic import add, subtract, multiply, divide
from .advanced import sqrt, power, factorial

__all__ = ['add', 'subtract', 'multiply', 'divide', 'sqrt', 'power', 'factorial']
```

```python
# mathutils/basic.py
"""Basic math operations."""

def add(a, b):
    return a + b

def subtract(a, b):
    return a - b

def multiply(a, b):
    return a * b

def divide(a, b):
    if b == 0:
        raise ValueError("Cannot divide by zero")
    return a / b
```

```python
# mathutils/advanced.py
"""Advanced math operations."""

import math

def sqrt(x):
    return math.sqrt(x)

def power(x, y):
    return x ** y

def factorial(n):
    return math.factorial(n)
```

```python
# main.py - Using the package
from mathutils import add, subtract, sqrt, factorial

print(add(5, 3))
print(subtract(10, 4))
print(sqrt(25))
print(factorial(5))
```

### Example 2: String Utilities Package

```
strutils/
    __init__.py
    operations.py
    validators.py
```

```python
# strutils/__init__.py
"""String utilities package."""

from .operations import reverse, capitalize, lower, upper
from .validators import is_palindrome, is_email, is_phone

__all__ = ['reverse', 'capitalize', 'lower', 'upper', 
           'is_palindrome', 'is_email', 'is_phone']
```

```python
# strutils/operations.py
"""String operations."""

def reverse(text):
    return text[::-1]

def capitalize(text):
    return text.capitalize()

def lower(text):
    return text.lower()

def upper(text):
    return text.upper()
```

```python
# strutils/validators.py
"""String validators."""

def is_palindrome(text):
    cleaned = text.lower().replace(" ", "")
    return cleaned == cleaned[::-1]

def is_email(email):
    return "@" in email and "." in email.split("@")[1]

def is_phone(phone):
    digits = ''.join(filter(str.isdigit, phone))
    return len(digits) == 10
```

---

## `__all__` in Packages

The `__all__` variable defines what gets imported with `from package import *`.

### Using `__all__`

```python
# mypackage/__init__.py
from .module1 import func1, func2
from .module2 import Class1, Class2

__all__ = ['func1', 'func2', 'Class1', 'Class2']
```

### Example: Controlling Exports

```python
# mypackage/__init__.py
from .module1 import public_function, _private_function

# Only public_function will be exported with import *
__all__ = ['public_function']

# _private_function is still accessible with explicit import
```

---

## Package Best Practices

### 1. Use `__init__.py` Effectively

```python
# mypackage/__init__.py
"""Package documentation."""

# Make commonly used items available
from .module1 import important_function
from .module2 import ImportantClass

__version__ = "1.0.0"
```

### 2. Organize Related Modules

```
# Good organization
utils/
    __init__.py
    math_utils.py
    string_utils.py
    file_utils.py
```

### 3. Use Descriptive Names

```python
# Good: Descriptive package name
import data_processors
import math_utilities

# Avoid: Generic names
import utils
import helpers
```

### 4. Document Packages

```python
# mypackage/__init__.py
"""
My Package

A comprehensive package for [description].

Modules:
    - module1: [description]
    - module2: [description]

Usage:
    from mypackage import module1
    module1.function()
"""
```

### 5. Use `__all__` for Public API

```python
# mypackage/__init__.py
from .module1 import public_func1, public_func2
from .module2 import PublicClass

__all__ = ['public_func1', 'public_func2', 'PublicClass']
```

---

## Common Mistakes and Pitfalls

### 1. Missing `__init__.py`

```python
# WRONG: Directory without __init__.py is not a package
mypackage/
    module1.py  # Cannot import as package

# CORRECT: Add __init__.py
mypackage/
    __init__.py  # Makes it a package
    module1.py
```

### 2. Circular Imports in Packages

```python
# WRONG: Circular import
# package/module1.py
from .module2 import func

# package/module2.py
from .module1 import func  # Circular!

# BETTER: Reorganize to avoid circular dependencies
```

### 3. Import Errors

```python
# WRONG: Incorrect import path
from mypackage import nonexistent_module

# CORRECT: Check module exists
from mypackage import existing_module
```

### 4. Not Using Relative Imports

```python
# In package/module1.py

# WRONG: Absolute import (if package name changes)
from mypackage.module2 import func

# BETTER: Relative import
from .module2 import func
```

---

## Relative Imports

### Relative Import Syntax

- `.module` - Import from same package
- `..module` - Import from parent package
- `...module` - Import from grandparent package

### Example: Relative Imports

```python
# mypackage/module1.py
from .module2 import function  # Same package
from ..parent import something  # Parent package
```

### When to Use Relative Imports

```python
# In package code, use relative imports
# package/subpackage/module.py
from .. import parent_module  # Relative to parent
from . import sibling_module  # Relative to current
```

---

## Practice Exercise

### Exercise: Creating Packages

**Objective**: Create Python packages demonstrating package structure and organization.

**Instructions**:

1. Create package structures that demonstrate:
   - Basic package structure
   - `__init__.py` usage
   - Package imports
   - Nested packages
   - Package organization

2. Create modules within packages

3. Create a main script that uses your packages

**Example Solution**:

```python
"""
Package Creation Practice
This demonstrates creating and using Python packages.

Note: In practice, these would be in separate directories.
Shown here for educational purposes.
"""

print("=" * 60)
print("PACKAGE CREATION PRACTICE")
print("=" * 60)
print()

# ============================================================
# Package Structure Example:
# mathutils/
#     __init__.py
#     basic.py
#     advanced.py
# ============================================================

print("1. PACKAGE STRUCTURE")
print("-" * 60)
print("""
Package structure:
mathutils/
    __init__.py
    basic.py
    advanced.py
""")

# ============================================================
# mathutils/__init__.py
# ============================================================
print("2. __init__.py EXAMPLE")
print("-" * 60)
print("""
# mathutils/__init__.py
\"\"\"Math utilities package.\"\"\"

from .basic import add, subtract, multiply, divide
from .advanced import sqrt, power, factorial

__version__ = "1.0.0"
__all__ = ['add', 'subtract', 'multiply', 'divide', 'sqrt', 'power', 'factorial']
""")

# ============================================================
# mathutils/basic.py
# ============================================================
print("3. MODULE IN PACKAGE")
print("-" * 60)
print("""
# mathutils/basic.py
\"\"\"Basic math operations.\"\"\"

def add(a, b):
    return a + b

def subtract(a, b):
    return a - b

def multiply(a, b):
    return a * b

def divide(a, b):
    if b == 0:
        raise ValueError("Cannot divide by zero")
    return a / b
""")

# ============================================================
# Using the package
# ============================================================
print("4. USING THE PACKAGE")
print("-" * 60)
print("""
# main.py
from mathutils import add, subtract, sqrt, factorial

print(add(5, 3))        # 8
print(subtract(10, 4))  # 6
print(sqrt(25))         # 5.0
print(factorial(5))     # 120
""")

# ============================================================
# Nested Package Structure
# ============================================================
print("5. NESTED PACKAGE STRUCTURE")
print("-" * 60)
print("""
mylib/
    __init__.py
    core/
        __init__.py
        base.py
        utils.py
    data/
        __init__.py
        validators.py
        processors.py
""")

# ============================================================
# Import patterns
# ============================================================
print("6. IMPORT PATTERNS")
print("-" * 60)
print("""
# Pattern 1: Full path
import mylib.core.base
mylib.core.base.function()

# Pattern 2: Import module
from mylib.core import base
base.function()

# Pattern 3: Import function
from mylib.core.base import function
function()

# Pattern 4: Import from __init__.py
from mylib import function  # If exported in __init__.py
function()
""")

# ============================================================
# __all__ usage
# ============================================================
print("7. __all__ USAGE")
print("-" * 60)
print("""
# mypackage/__init__.py
from .module1 import func1, func2, _private_func
from .module2 import Class1

# Control what gets imported with 'from package import *'
__all__ = ['func1', 'func2', 'Class1']
# _private_func is not in __all__, but can still be imported explicitly
""")

# ============================================================
# Relative imports
# ============================================================
print("8. RELATIVE IMPORTS")
print("-" * 60)
print("""
# In package/module1.py

# Relative import (same package)
from .module2 import function

# Relative import (parent package)
from ..parent import something

# Relative import (sibling package)
from ..sibling import something_else
""")

# ============================================================
# Package initialization
# ============================================================
print("9. PACKAGE INITIALIZATION")
print("-" * 60)
print("""
# mypackage/__init__.py
\"\"\"Package documentation.\"\"\"

__version__ = "1.0.0"
__author__ = "Your Name"

# Import commonly used items
from .module1 import important_function

# Package-level initialization
def initialize():
    print("Package initialized")

# Runs when package is imported
print(f"Package {__version__} loaded")
""")

# ============================================================
# Complete package example
# ============================================================
print("10. COMPLETE PACKAGE EXAMPLE")
print("-" * 60)
print("""
# strutils/__init__.py
\"\"\"String utilities package.\"\"\"

from .operations import reverse, capitalize, upper, lower
from .validators import is_palindrome, is_email

__version__ = "1.0.0"
__all__ = ['reverse', 'capitalize', 'upper', 'lower', 
           'is_palindrome', 'is_email']

# strutils/operations.py
def reverse(text):
    return text[::-1]

def capitalize(text):
    return text.capitalize()

def upper(text):
    return text.upper()

def lower(text):
    return text.lower()

# strutils/validators.py
def is_palindrome(text):
    cleaned = text.lower().replace(" ", "")
    return cleaned == cleaned[::-1]

def is_email(email):
    return "@" in email and "." in email.split("@")[1]

# Usage:
from strutils import reverse, is_palindrome
print(reverse("hello"))
print(is_palindrome("racecar"))
""")

# ============================================================
# Package organization best practices
# ============================================================
print("11. PACKAGE ORGANIZATION BEST PRACTICES")
print("-" * 60)
print("""
1. Use __init__.py to make directories packages
2. Organize related modules together
3. Use descriptive package names
4. Document packages with docstrings
5. Use __all__ to define public API
6. Use relative imports within packages
7. Avoid circular imports
8. Keep __init__.py minimal (or use for convenience imports)
""")

# ============================================================
# Common package patterns
# ============================================================
print("12. COMMON PACKAGE PATTERNS")
print("-" * 60)
print("""
# Pattern 1: Flat package
utils/
    __init__.py
    module1.py
    module2.py

# Pattern 2: Hierarchical package
mylib/
    __init__.py
    core/
        __init__.py
        base.py
    data/
        __init__.py
        validators.py

# Pattern 3: Feature-based
app/
    __init__.py
    models/
        __init__.py
        user.py
        product.py
    views/
        __init__.py
        user_view.py
        product_view.py
""")

print()
print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
print()
print("Note: In a real project, create actual directory structures")
print("and separate .py files for each module in the package.")
```

**Expected Output**:
```
============================================================
PACKAGE CREATION PRACTICE
============================================================

1. PACKAGE STRUCTURE
------------------------------------------------------------

Package structure:
mathutils/
    __init__.py
    basic.py
    advanced.py

[... rest of output ...]
```

**Challenge** (Optional):
- Create a complete utility package library
- Build a package with sub-packages
- Create a package following best practices
- Organize an existing project into packages

---

## Key Takeaways

1. **Packages** are directories containing modules and `__init__.py`
2. **`__init__.py`** makes a directory a Python package (can be empty)
3. **Package structure** organizes related modules together
4. **Package imports** use dot notation: `from package import module`
5. **`__all__`** controls what gets imported with `from package import *`
6. **Relative imports** use `.` for same package, `..` for parent
7. **Nested packages** allow hierarchical organization
8. **Package documentation** goes in `__init__.py` docstring
9. **Use descriptive names** for packages
10. **Organize modules** by functionality within packages
11. **`__init__.py` can contain** initialization code and convenience imports
12. **Avoid circular imports** in packages
13. **Package version** can be defined in `__init__.py`
14. **Use `__all__`** to define public API
15. **Keep `__init__.py` focused** on package-level concerns

---

## Quiz: Packages

Test your understanding with these questions:

1. **What makes a directory a Python package?**
   - A) Contains .py files
   - B) Contains `__init__.py`
   - C) Has subdirectories
   - D) Named with "package"

2. **What is `__init__.py` used for?**
   - A) Package initialization
   - B) Module documentation
   - C) Function definitions
   - D) Class definitions

3. **How do you import from a package?**
   - A) `import package.module`
   - B) `from package import module`
   - C) Both A and B
   - D) `import package`

4. **What does `__all__` control?**
   - A) Package version
   - B) What gets imported with `import *`
   - C) Package name
   - D) Module order

5. **What does `.` mean in relative imports?**
   - A) Parent package
   - B) Current package
   - C) Root package
   - D) Sub-package

6. **Can `__init__.py` be empty?**
   - A) No
   - B) Yes
   - C) Only in Python 2
   - D) Only in Python 3

7. **What is a nested package?**
   - A) Package with many files
   - B) Package containing sub-packages
   - C) Package with classes
   - D) Package with functions

8. **How do you import from a sub-package?**
   - A) `from package.subpackage import module`
   - B) `import package.subpackage.module`
   - C) Both A and B
   - D) `import subpackage`

9. **What should package names be?**
   - A) Generic
   - B) Descriptive
   - C) Numbers
   - D) Single letters

10. **What is the purpose of packages?**
    - A) Organize modules
    - B) Group related functionality
    - C) Provide namespace
    - D) All of the above

**Answers**:
1. B) Contains `__init__.py` (required to make directory a package)
2. A) Package initialization (can contain init code and imports)
3. C) Both A and B (both import styles work)
4. B) What gets imported with `import *` (controls exports)
5. B) Current package (`.` refers to current package in relative imports)
6. B) Yes (`__init__.py` can be empty in Python 3)
7. B) Package containing sub-packages (nested package structure)
8. C) Both A and B (both import styles work for sub-packages)
9. B) Descriptive (use clear, descriptive package names)
10. D) All of the above (packages organize, group, and namespace)

---

## Next Steps

Excellent work! You've mastered packages. You now understand:
- How to create packages
- How to use `__init__.py`
- How to import from packages
- Package organization

**What's Next?**
- Lesson 11.4: Standard Library Overview
- Learn about important standard library modules
- Explore datetime, collections, and more
- Understand Python's built-in modules

---

## Additional Resources

- **Packages**: [docs.python.org/3/tutorial/modules.html#packages](https://docs.python.org/3/tutorial/modules.html#packages)
- **Package Structure**: [docs.python.org/3/tutorial/modules.html#intra-package-references](https://docs.python.org/3/tutorial/modules.html#intra-package-references)
- **PEP 420 - Implicit Namespace Packages**: [peps.python.org/pep-0420/](https://peps.python.org/pep-0420/)

---

*Lesson completed! You're ready to move on to the next lesson.*

