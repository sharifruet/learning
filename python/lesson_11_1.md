# Lesson 11.1: Importing Modules

## Learning Objectives

By the end of this lesson, you will be able to:
- Use the `import` statement to import modules
- Use `from...import` to import specific items
- Use `import as` to create aliases
- Understand module search paths
- Import standard library modules
- Import third-party modules
- Handle import errors
- Understand different import styles
- Apply imports effectively in your code

---

## Introduction to Modules

**Modules** are files containing Python code that can be imported and used in other Python programs. They allow code reuse and organization.

### What Are Modules?

- **Code organization**: Group related functionality
- **Reusability**: Use code in multiple programs
- **Namespace**: Avoid naming conflicts
- **Standard library**: Built-in modules provided by Python
- **Third-party**: Modules from external packages

### Benefits of Modules

- **Code reuse**: Write once, use many times
- **Organization**: Keep code organized and manageable
- **Maintainability**: Easier to maintain and update
- **Collaboration**: Share code between projects

---

## The `import` Statement

The `import` statement loads a module and makes its contents available.

### Basic Import

```python
import math

# Use module functions
result = math.sqrt(16)
print(result)  # Output: 4.0
```

### Importing Multiple Modules

```python
import math
import os
import sys

# Use imported modules
print(math.pi)
print(os.getcwd())
print(sys.version)
```

### Accessing Module Contents

```python
import math

# Access module attributes with dot notation
print(math.pi)           # 3.141592653589793
print(math.e)            # 2.718281828459045
print(math.sqrt(25))     # 5.0
print(math.factorial(5)) # 120
```

### Common Standard Library Modules

```python
import os          # Operating system interface
import sys         # System-specific parameters
import math        # Mathematical functions
import random      # Random number generation
import datetime    # Date and time operations
import json        # JSON encoder/decoder
import csv         # CSV file handling
import re          # Regular expressions
```

---

## The `from...import` Statement

The `from...import` statement imports specific items from a module.

### Importing Specific Functions

```python
from math import sqrt, pi, factorial

# Use directly without module name
print(sqrt(16))     # 4.0
print(pi)           # 3.141592653589793
print(factorial(5)) # 120
```

### Importing All (Not Recommended)

```python
from math import *

# All math functions available directly
print(sqrt(16))
print(pi)
print(factorial(5))

# Warning: This pollutes the namespace!
```

### Importing Multiple Items

```python
from math import sqrt, pi, e, factorial, sin, cos

print(sqrt(25))
print(pi)
print(e)
print(factorial(5))
print(sin(0))
print(cos(0))
```

### Example: Importing from Different Modules

```python
from math import sqrt, pi
from datetime import datetime, timedelta
from random import randint, choice

print(sqrt(25))
print(pi)
print(datetime.now())
print(randint(1, 10))
print(choice(['a', 'b', 'c']))
```

---

## The `import as` Statement

The `import as` statement creates an alias for a module or imported item.

### Module Aliases

```python
import math as m

# Use alias instead of full module name
print(m.sqrt(16))
print(m.pi)
print(m.factorial(5))
```

### Function Aliases

```python
from math import sqrt as square_root
from datetime import datetime as dt

print(square_root(25))
print(dt.now())
```

### Common Aliases

```python
import numpy as np          # Common for NumPy
import pandas as pd         # Common for Pandas
import matplotlib.pyplot as plt  # Common for matplotlib
import datetime as dt       # Shorter datetime
```

### Example: Using Aliases

```python
import math as m
from datetime import datetime as dt

# More concise
print(m.sqrt(16))
current_time = dt.now()
print(current_time)
```

---

## Combining Import Styles

### Mixed Imports

```python
import math
from math import pi, e
from datetime import datetime as dt

# Use imported items
print(math.sqrt(16))  # From import math
print(pi)             # From from...import
print(dt.now())       # From import as
```

### Example: Practical Import Combination

```python
import os
import sys
from math import sqrt, pi
from datetime import datetime as dt
import json as js

# Use all imports
print(os.getcwd())
print(sqrt(25))
print(pi)
print(dt.now())
data = js.dumps({"key": "value"})
```

---

## Standard Library Modules

### Common Standard Library Modules

```python
# System and OS
import os
import sys
import platform

# Math and Random
import math
import random
import statistics

# Date and Time
import datetime
import time
from datetime import datetime, timedelta

# File Operations
import json
import csv
import pathlib

# String Operations
import re
import string

# Collections
import collections
from collections import Counter, defaultdict

# Utilities
import functools
import itertools
import operator
```

### Examples: Using Standard Library

```python
import os
import math
import random
from datetime import datetime

# OS operations
print(f"Current directory: {os.getcwd()}")
print(f"PI: {math.pi}")
print(f"Random number: {random.randint(1, 100)}")
print(f"Current time: {datetime.now()}")
```

---

## Import Errors

### ModuleNotFoundError

```python
# ModuleNotFoundError if module doesn't exist
try:
    import nonexistent_module
except ModuleNotFoundError:
    print("Module not found")
```

### ImportError

```python
# ImportError if specific import fails
try:
    from math import nonexistent_function
except ImportError:
    print("Cannot import from module")
```

### Handling Import Errors

```python
try:
    import numpy
    has_numpy = True
except ImportError:
    has_numpy = False
    print("NumPy not available")

if has_numpy:
    import numpy as np
    # Use NumPy
```

### Optional Imports

```python
try:
    import optional_module
except ImportError:
    optional_module = None

if optional_module:
    optional_module.doSomething()
else:
    print("Optional module not available")
```

---

## Module Search Path

### Understanding Module Search Path

Python searches for modules in specific locations:

1. Current directory
2. Directories in PYTHONPATH
3. Standard library directories
4. Site-packages (third-party)

### Viewing Search Path

```python
import sys

# View module search path
for path in sys.path:
    print(path)
```

### Adding to Search Path

```python
import sys
import os

# Add directory to search path
sys.path.append('/path/to/module')
# Or
sys.path.insert(0, '/path/to/module')

# Now you can import from that directory
import my_module
```

---

## Import Best Practices

### 1. Use Explicit Imports

```python
# Good: Explicit
from math import sqrt
print(sqrt(25))

# Avoid: Import all
from math import *
```

### 2. Organize Imports

```python
# Good: Organized imports
# Standard library
import os
import sys

# Third-party
import numpy as np
import pandas as pd

# Local modules
import my_module
```

### 3. Use Aliases for Long Names

```python
# Good: Use alias for long names
import matplotlib.pyplot as plt
import datetime as dt

# Avoid: Long names
import matplotlib.pyplot
matplotlib.pyplot.plot(...)
```

### 4. Import at Top of File

```python
# Good: Imports at top
import os
import math

def my_function():
    # Code here
    pass
```

### 5. Handle Import Errors

```python
# Good: Handle missing modules
try:
    import optional_module
except ImportError:
    optional_module = None
```

---

## Common Import Patterns

### Pattern 1: Standard Library

```python
import os
import sys
import math
```

### Pattern 2: Specific Functions

```python
from math import sqrt, pi, factorial
```

### Pattern 3: Module Aliases

```python
import numpy as np
import pandas as pd
```

### Pattern 4: Conditional Imports

```python
try:
    import fast_module
except ImportError:
    import slow_module as fast_module
```

---

## Practical Examples

### Example 1: Using Math Module

```python
import math

# Calculate circle area
radius = 5
area = math.pi * math.pow(radius, 2)
print(f"Area: {area}")

# Calculate factorial
n = 5
fact = math.factorial(n)
print(f"{n}! = {fact}")

# Trigonometric functions
angle = math.pi / 4
print(f"sin({angle}) = {math.sin(angle)}")
```

### Example 2: Using Datetime Module

```python
from datetime import datetime, timedelta

# Current time
now = datetime.now()
print(f"Current time: {now}")

# Time delta
future = now + timedelta(days=7)
print(f"In 7 days: {future}")

# Format datetime
formatted = now.strftime("%Y-%m-%d %H:%M:%S")
print(f"Formatted: {formatted}")
```

### Example 3: Using Random Module

```python
import random

# Random integer
number = random.randint(1, 100)
print(f"Random number: {number}")

# Random choice
items = ['apple', 'banana', 'cherry']
choice = random.choice(items)
print(f"Random choice: {choice}")

# Random shuffle
numbers = [1, 2, 3, 4, 5]
random.shuffle(numbers)
print(f"Shuffled: {numbers}")
```

### Example 4: Using JSON Module

```python
import json

# Convert Python to JSON
data = {"name": "Alice", "age": 30}
json_string = json.dumps(data)
print(f"JSON: {json_string}")

# Convert JSON to Python
json_data = '{"name": "Bob", "age": 25}'
python_data = json.loads(json_data)
print(f"Python: {python_data}")
```

### Example 5: Using OS Module

```python
import os

# Current directory
print(f"Current directory: {os.getcwd()}")

# List directory
files = os.listdir('.')
print(f"Files: {files}")

# Check if file exists
if os.path.exists('file.txt'):
    print("File exists")

# Get environment variable
home = os.getenv('HOME')
print(f"Home: {home}")
```

---

## Common Mistakes and Pitfalls

### 1. Importing Non-Existent Module

```python
# WRONG: Module doesn't exist
import nonexistent_module  # ModuleNotFoundError

# CORRECT: Check if exists or handle error
try:
    import optional_module
except ImportError:
    pass
```

### 2. Name Conflicts

```python
# WRONG: Name conflict
from math import sqrt
def sqrt(x):  # Overwrites imported sqrt
    return x * x

# BETTER: Use module name or alias
import math
def sqrt(x):
    return x * x  # Doesn't conflict with math.sqrt
```

### 3. Import All

```python
# WRONG: Pollutes namespace
from math import *
# All math functions now in namespace

# BETTER: Import specific
from math import sqrt, pi
```

### 4. Circular Imports

```python
# WRONG: Circular import
# module_a.py
import module_b

# module_b.py
import module_a  # Circular!

# BETTER: Reorganize code to avoid circular imports
```

---

## Practice Exercise

### Exercise: Using Modules

**Objective**: Create a Python program that demonstrates various import techniques.

**Instructions**:

1. Create a file called `imports_practice.py`

2. Write a program that:
   - Uses `import` statements
   - Uses `from...import` statements
   - Uses `import as` for aliases
   - Demonstrates standard library modules
   - Handles import errors

3. Your program should include:
   - Different import styles
   - Standard library usage
   - Import error handling
   - Practical examples

**Example Solution**:

```python
"""
Importing Modules Practice
This program demonstrates various import techniques.
"""

print("=" * 60)
print("IMPORTING MODULES PRACTICE")
print("=" * 60)
print()

# 1. Basic import
print("1. BASIC IMPORT")
print("-" * 60)
import math

print(f"PI: {math.pi}")
print(f"Square root of 25: {math.sqrt(25)}")
print(f"5! = {math.factorial(5)}")
print()

# 2. Import multiple modules
print("2. IMPORT MULTIPLE MODULES")
print("-" * 60)
import os
import sys

print(f"Current directory: {os.getcwd()}")
print(f"Python version: {sys.version_info.major}.{sys.version_info.minor}")
print()

# 3. from...import
print("3. FROM...IMPORT")
print("-" * 60)
from math import sqrt, pi, factorial

print(f"PI: {pi}")
print(f"Square root of 16: {sqrt(16)}")
print(f"4! = {factorial(4)}")
print()

# 4. Import as (aliases)
print("4. IMPORT AS (ALIASES)")
print("-" * 60)
import math as m
from datetime import datetime as dt

print(f"PI: {m.pi}")
print(f"Current time: {dt.now()}")
print()

# 5. Function alias
print("5. FUNCTION ALIAS")
print("-" * 60)
from math import sqrt as square_root

print(f"Square root of 36: {square_root(36)}")
print()

# 6. Multiple imports from same module
print("6. MULTIPLE IMPORTS FROM SAME MODULE")
print("-" * 60)
from math import sqrt, pi, e, factorial, sin, cos

print(f"PI: {pi}")
print(f"E: {e}")
print(f"Square root of 9: {sqrt(9)}")
print(f"sin(0): {sin(0)}")
print(f"cos(0): {cos(1)}")
print()

# 7. Datetime module
print("7. DATETIME MODULE")
print("-" * 60)
from datetime import datetime, timedelta

now = datetime.now()
print(f"Current time: {now}")
future = now + timedelta(days=7)
print(f"In 7 days: {future}")
formatted = now.strftime("%Y-%m-%d %H:%M:%S")
print(f"Formatted: {formatted}")
print()

# 8. Random module
print("8. RANDOM MODULE")
print("-" * 60)
import random

print(f"Random integer (1-100): {random.randint(1, 100)}")
items = ['apple', 'banana', 'cherry']
print(f"Random choice: {random.choice(items)}")
numbers = [1, 2, 3, 4, 5]
random.shuffle(numbers)
print(f"Shuffled: {numbers}")
print()

# 9. JSON module
print("9. JSON MODULE")
print("-" * 60)
import json

data = {"name": "Alice", "age": 30, "city": "New York"}
json_string = json.dumps(data, indent=2)
print(f"Python to JSON:\n{json_string}")

json_data = '{"name": "Bob", "age": 25}'
python_data = json.loads(json_data)
print(f"\nJSON to Python: {python_data}")
print()

# 10. OS module
print("10. OS MODULE")
print("-" * 60)
import os

print(f"Current directory: {os.getcwd()}")
print(f"Platform: {os.name}")
print(f"Environment PATH: {os.getenv('PATH', 'Not set')[:50]}...")
print()

# 11. Re module (regular expressions)
print("11. RE MODULE (REGULAR EXPRESSIONS)")
print("-" * 60)
import re

text = "The price is $50"
pattern = r'\$(\d+)'
match = re.search(pattern, text)
if match:
    print(f"Found price: ${match.group(1)}")
print()

# 12. Collections module
print("12. COLLECTIONS MODULE")
print("-" * 60)
from collections import Counter, defaultdict

# Counter
words = ['apple', 'banana', 'apple', 'cherry', 'banana', 'apple']
counter = Counter(words)
print(f"Word count: {counter}")
print(f"Most common: {counter.most_common(2)}")

# Defaultdict
dd = defaultdict(int)
dd['a'] += 1
dd['b'] += 2
print(f"Defaultdict: {dict(dd)}")
print()

# 13. Handling import errors
print("13. HANDLING IMPORT ERRORS")
print("-" * 60)
try:
    import nonexistent_module
except ModuleNotFoundError:
    print("Module not found (expected)")

try:
    from math import nonexistent_function
except ImportError:
    print("Function not found in module (expected)")
print()

# 14. Optional imports
print("14. OPTIONAL IMPORTS")
print("-" * 60)
try:
    import numpy
    has_numpy = True
    print("NumPy is available")
except ImportError:
    has_numpy = False
    print("NumPy is not available")

try:
    import pandas
    has_pandas = True
    print("Pandas is available")
except ImportError:
    has_pandas = False
    print("Pandas is not available")
print()

# 15. Combined imports
print("15. COMBINED IMPORTS")
print("-" * 60)
import math
from math import pi, e
from datetime import datetime as dt
import json as js

print(f"math.sqrt(16) = {math.sqrt(16)}")
print(f"pi = {pi}")
print(f"Current time: {dt.now()}")
data = js.dumps({"key": "value"})
print(f"JSON: {data}")
print()

# 16. Module search path
print("16. MODULE SEARCH PATH")
print("-" * 60)
import sys

print("Module search paths:")
for i, path in enumerate(sys.path[:5], 1):  # Show first 5
    print(f"  {i}. {path}")
if len(sys.path) > 5:
    print(f"  ... and {len(sys.path) - 5} more")
print()

# 17. String module
print("17. STRING MODULE")
print("-" * 60)
import string

print(f"ASCII letters: {string.ascii_letters[:26]}...")
print(f"Digits: {string.digits}")
print(f"Punctuation: {string.punctuation[:20]}...")
print()

# 18. Statistics module
print("18. STATISTICS MODULE")
print("-" * 60)
import statistics

numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
print(f"Mean: {statistics.mean(numbers)}")
print(f"Median: {statistics.median(numbers)}")
print(f"Mode: {statistics.mode([1, 2, 2, 3, 3, 3])}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
IMPORTING MODULES PRACTICE
============================================================

1. BASIC IMPORT
------------------------------------------------------------
PI: 3.141592653589793
Square root of 25: 5.0
5! = 120

[... rest of output ...]
```

**Challenge** (Optional):
- Create a module usage guide
- Build a utility module
- Explore more standard library modules
- Create a module dependency checker

---

## Key Takeaways

1. **`import module`** imports entire module
2. **`from module import item`** imports specific items
3. **`import module as alias`** creates module alias
4. **`from module import item as alias`** creates item alias
5. **Standard library** provides many useful modules
6. **Handle import errors** with try/except
7. **Organize imports** (standard, third-party, local)
8. **Use aliases** for long module names
9. **Avoid `import *`** (pollutes namespace)
10. **Import at top** of file (PEP 8 style)
11. **Module search path** determines where Python looks
12. **Circular imports** should be avoided
13. **Name conflicts** can occur with imports
14. **Optional imports** use try/except pattern
15. **Explicit imports** are preferred over `import *`

---

## Quiz: Imports

Test your understanding with these questions:

1. **What does `import math` do?**
   - A) Imports sqrt function
   - B) Imports math module
   - C) Imports all functions
   - D) Creates alias

2. **What does `from math import sqrt` do?**
   - A) Imports math module
   - B) Imports sqrt function directly
   - C) Creates alias
   - D) Imports all functions

3. **What does `import math as m` do?**
   - A) Imports sqrt
   - B) Creates alias 'm' for math
   - C) Imports all functions
   - D) Nothing

4. **What is wrong with `from math import *`?**
   - A) Nothing
   - B) Pollutes namespace
   - C) Doesn't work
   - D) Too slow

5. **What exception is raised for missing module?**
   - A) `ImportError`
   - B) `ModuleNotFoundError`
   - C) `FileNotFoundError`
   - D) `NameError`

6. **Where should imports be placed?**
   - A) At end of file
   - B) At top of file
   - C) Anywhere
   - D) In functions

7. **What is the standard library?**
   - A) Third-party modules
   - B) Built-in Python modules
   - C) Local modules
   - D) External packages

8. **How do you handle optional imports?**
   - A) `if import module`
   - B) `try/except ImportError`
   - C) `require module`
   - D) `import if module`

9. **What does `sys.path` contain?**
   - A) Module names
   - B) Directories Python searches
   - C) Import statements
   - D) File paths

10. **What should you avoid when importing?**
    - A) Aliases
    - B) `import *`
    - C) `from...import`
    - D) Standard library

**Answers**:
1. B) Imports math module (import statement imports module)
2. B) Imports sqrt function directly (from...import imports specific items)
3. B) Creates alias 'm' for math (import as creates alias)
4. B) Pollutes namespace (import * brings all names into namespace)
5. B) `ModuleNotFoundError` (exception for missing modules)
6. B) At top of file (PEP 8 style guide)
7. B) Built-in Python modules (standard library is built-in)
8. B) `try/except ImportError` (pattern for optional imports)
9. B) Directories Python searches (sys.path contains search paths)
10. B) `import *` (should avoid polluting namespace)

---

## Next Steps

Excellent work! You've mastered importing modules. You now understand:
- How to use import statements
- How to use from...import
- How to use import as
- How to handle import errors

**What's Next?**
- Lesson 11.2: Creating Modules
- Learn how to create your own modules
- Understand module structure
- Explore package organization

---

## Additional Resources

- **Import System**: [docs.python.org/3/reference/import.html](https://docs.python.org/3/reference/import.html)
- **Standard Library**: [docs.python.org/3/library/index.html](https://docs.python.org/3/library/index.html)
- **PEP 8 - Imports**: [pep8.org/#imports](https://pep8.org/#imports)

---

*Lesson completed! You're ready to move on to the next lesson.*

