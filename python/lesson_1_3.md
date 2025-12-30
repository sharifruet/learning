# Lesson 1.3: Variables and Data Types

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what variables are and how to use them
- Follow Python naming conventions for variables
- Identify and use different numeric data types (int, float, complex)
- Work with strings and perform string operations
- Use boolean values and understand their purpose
- Convert between different data types
- Understand type checking and type hints

---

## Variables and Naming Conventions

### What is a Variable?

A **variable** is a named location in memory that stores a value. Think of it as a labeled box where you can store data and retrieve it later using the label (variable name).

```python
# Creating a variable
name = "Alice"
age = 25
height = 5.6

# Using variables
print(name)    # Output: Alice
print(age)     # Output: 25
print(height)  # Output: 5.6
```

### Variable Assignment

In Python, you assign values to variables using the `=` operator:

```python
# Basic assignment
x = 10
message = "Hello, World!"
is_active = True

# Multiple assignment
a = b = c = 0  # All three variables get the value 0

# Multiple assignment with different values
x, y, z = 1, 2, 3  # x=1, y=2, z=3

# Swapping variables (Python makes this easy!)
a = 5
b = 10
a, b = b, a  # Now a=10, b=5
```

### Variable Naming Rules

Python has specific rules for variable names:

1. **Must start with a letter or underscore** (`_`)
2. **Can contain letters, digits, and underscores**
3. **Cannot contain spaces or special characters**
4. **Cannot be a Python keyword**
5. **Case-sensitive** (Name, name, and NAME are different)

**Valid variable names**:
```python
name = "Alice"
user_name = "john_doe"
userName = "camelCase"
_name = "private"
name2 = "second"
_2name = "starts_with_underscore_and_number"
```

**Invalid variable names**:
```python
# 2name = "invalid"      # Cannot start with digit
# user-name = "invalid"  # Cannot contain hyphens
# user name = "invalid"  # Cannot contain spaces
# class = "invalid"      # Cannot use keyword
# $price = 100          # Cannot start with special character
```

### Naming Conventions (PEP 8)

Following Python's style guide (PEP 8) makes your code more readable:

**1. Use descriptive names**:
```python
# Bad
x = 25
n = "Alice"

# Good
age = 25
name = "Alice"
```

**2. Use lowercase with underscores** (snake_case):
```python
# Recommended
user_name = "Alice"
total_count = 100
is_valid = True

# Also acceptable (but less common in Python)
userName = "Alice"      # camelCase
UserName = "Alice"      # PascalCase (used for classes)
```

**3. Constants use UPPERCASE**:
```python
# Constants (values that don't change)
MAX_SIZE = 1000
PI = 3.14159
API_KEY = "secret_key"
```

**4. Private variables start with underscore**:
```python
# Convention: single underscore for "internal use"
_internal_value = 42

# Convention: double underscore for name mangling (advanced)
__private_value = 42
```

**5. Avoid single-letter names** (except for loop counters):
```python
# Acceptable for loop counters
for i in range(10):
    print(i)

# Better for other cases
for index in range(10):
    print(index)
```

### Variable Scope (Introduction)

Variables have different scopes (where they can be accessed). We'll cover this in detail later, but here's a quick introduction:

```python
# Global variable (accessible throughout the file)
global_var = "I'm global"

def my_function():
    # Local variable (only accessible inside the function)
    local_var = "I'm local"
    print(global_var)  # Can access global
    print(local_var)   # Can access local

print(global_var)  # Can access global
# print(local_var)  # Error! Can't access local outside function
```

---

## Numeric Types

Python supports three numeric types: integers, floating-point numbers, and complex numbers.

### Integers (int)

Integers are whole numbers (positive, negative, or zero) with no decimal point.

```python
# Positive integers
age = 25
count = 100
score = 1000

# Negative integers
temperature = -10
debt = -500

# Zero
zero = 0

# Large integers (Python handles arbitrarily large integers)
big_number = 123456789012345678901234567890
```

**Integer operations**:
```python
a = 10
b = 3

print(a + b)   # Addition: 13
print(a - b)   # Subtraction: 7
print(a * b)   # Multiplication: 30
print(a / b)   # Division: 3.333... (returns float)
print(a // b)  # Floor division: 3 (returns int)
print(a % b)   # Modulo (remainder): 1
print(a ** b)  # Exponentiation: 1000
```

**Integer literals**:
```python
# Decimal (base 10) - default
decimal = 42

# Binary (base 2) - prefix with 0b
binary = 0b1010  # 10 in decimal

# Octal (base 8) - prefix with 0o
octal = 0o52     # 42 in decimal

# Hexadecimal (base 16) - prefix with 0x
hexadecimal = 0x2A  # 42 in decimal
```

### Floating-Point Numbers (float)

Floats represent real numbers with decimal points.

```python
# Basic floats
pi = 3.14159
price = 19.99
temperature = 98.6

# Scientific notation
large_number = 1.5e3    # 1500.0
small_number = 1.5e-3   # 0.0015

# Floats can also be negative
negative_float = -3.14
```

**Float operations**:
```python
x = 10.5
y = 3.2

print(x + y)   # 13.7
print(x - y)   # 7.3
print(x * y)   # 33.6
print(x / y)   # 3.28125
print(x // y)  # 3.0 (floor division with floats)
print(x % y)   # 0.8999999999999995
print(x ** y)  # Exponentiation
```

**Floating-point precision**:
```python
# Be aware: floating-point arithmetic can have precision issues
result = 0.1 + 0.2
print(result)  # 0.30000000000000004 (not exactly 0.3!)

# For precise decimal arithmetic, use the decimal module (advanced)
from decimal import Decimal
precise = Decimal('0.1') + Decimal('0.2')
print(precise)  # 0.3
```

### Complex Numbers (complex)

Complex numbers have a real and imaginary part.

```python
# Creating complex numbers
z1 = 3 + 4j      # 3 is real part, 4 is imaginary part
z2 = complex(3, 4)  # Same as above

# Accessing parts
print(z1.real)   # 3.0
print(z1.imag)   # 4.0

# Operations
z3 = z1 + z2
z4 = z1 * z2
```

**Note**: Complex numbers are less commonly used in general programming but are important in scientific computing, signal processing, and mathematics.

### Numeric Type Checking

You can check the type of a variable using the `type()` function:

```python
x = 42
y = 3.14
z = 3 + 4j

print(type(x))  # <class 'int'>
print(type(y))  # <class 'float'>
print(type(z))  # <class 'complex'>

# Using isinstance() (recommended for type checking)
print(isinstance(x, int))    # True
print(isinstance(y, float))  # True
print(isinstance(x, float))  # False
```

---

## Strings and String Operations

Strings are sequences of characters used to represent text.

### Creating Strings

```python
# Single quotes
name = 'Alice'

# Double quotes
greeting = "Hello, World!"

# Triple quotes for multi-line strings
multiline = """This is a
multi-line
string"""

# All are equivalent
str1 = 'Hello'
str2 = "Hello"
str3 = """Hello"""
# str1 == str2 == str3 is True
```

### String Indexing

Strings are sequences, so you can access individual characters by index:

```python
text = "Python"

print(text[0])   # 'P' (first character, index 0)
print(text[1])   # 'y'
print(text[5])   # 'n' (last character)
print(text[-1]) # 'n' (negative index: -1 is last, -2 is second-to-last)
```

**Index positions**:
```
P  y  t  h  o  n
0  1  2  3  4  5
-6 -5 -4 -3 -2 -1
```

### String Slicing

Extract substrings using slicing:

```python
text = "Python Programming"

# Basic slicing: [start:end]
print(text[0:6])      # "Python" (characters 0 to 5)
print(text[7:18])     # "Programming"

# Omitting start (starts from beginning)
print(text[:6])       # "Python"

# Omitting end (goes to end)
print(text[7:])       # "Programming"

# Negative indices
print(text[-11:])     # "Programming"

# Step size
print(text[::2])      # "Pto rgamn" (every 2nd character)
print(text[::-1])     # "gnimmargorP nohtyP" (reverse string)
```

### String Concatenation

Combine strings using `+`:

```python
first_name = "Alice"
last_name = "Smith"
full_name = first_name + " " + last_name
print(full_name)  # "Alice Smith"

# String repetition
greeting = "Hello! " * 3
print(greeting)  # "Hello! Hello! Hello! "
```

### String Methods

Strings have many built-in methods:

```python
text = "  Hello, World!  "

# Case conversion
print(text.upper())        # "  HELLO, WORLD!  "
print(text.lower())        # "  hello, world!  "
print(text.title())        # "  Hello, World!  "
print(text.capitalize())   # "  hello, world!  "
print(text.swapcase())     # "  hELLO, wORLD!  "

# Stripping whitespace
print(text.strip())        # "Hello, World!"
print(text.lstrip())      # "Hello, World!  " (left strip)
print(text.rstrip())      # "  Hello, World!" (right strip)

# Finding and replacing
print(text.find("World"))  # 9 (index where "World" starts)
print(text.replace("World", "Python"))  # "  Hello, Python!  "

# Checking content
print(text.startswith("Hello"))  # False (has leading spaces)
print(text.endswith("!"))        # True
print("Hello" in text)           # True

# Splitting and joining
words = "apple,banana,cherry".split(",")
print(words)  # ['apple', 'banana', 'cherry']
print(", ".join(words))  # "apple, banana, cherry"

# Length
print(len(text))  # 17 (including spaces)
```

### String Formatting

Multiple ways to format strings:

**1. f-strings** (Python 3.6+, recommended):
```python
name = "Alice"
age = 25
print(f"My name is {name} and I'm {age} years old.")
# Output: "My name is Alice and I'm 25 years old."

# Expressions in f-strings
print(f"Next year I'll be {age + 1} years old.")
```

**2. .format() method**:
```python
name = "Alice"
age = 25
print("My name is {} and I'm {} years old.".format(name, age))
print("My name is {0} and I'm {1} years old.".format(name, age))
print("My name is {n} and I'm {a} years old.".format(n=name, a=age))
```

**3. % formatting** (older style):
```python
name = "Alice"
age = 25
print("My name is %s and I'm %d years old." % (name, age))
```

**4. String concatenation**:
```python
name = "Alice"
age = 25
print("My name is " + name + " and I'm " + str(age) + " years old.")
```

### Escape Sequences in Strings

Special characters in strings:

```python
# Newline
print("Line 1\nLine 2")

# Tab
print("Column1\tColumn2\tColumn3")

# Quotes
print('She said "Hello"')
print("It's a beautiful day")
print('It\'s a beautiful day')

# Backslash
print("Path: C:\\Users\\Documents")

# Raw strings (treat backslashes literally)
print(r"C:\Users\Documents")  # No need to escape
```

---

## Boolean Type

Boolean values represent truth values: `True` or `False`.

### Boolean Values

```python
# Boolean literals
is_active = True
is_complete = False

# Boolean values are actually integers in Python
print(True == 1)   # True
print(False == 0)  # True
print(True + True) # 2
```

### Boolean Operations

```python
# Logical operators
x = True
y = False

print(x and y)  # False (both must be True)
print(x or y)   # True (at least one must be True)
print(not x)    # False (negation)

# Comparison operators return booleans
print(5 > 3)    # True
print(5 == 3)   # False
print(5 != 3)   # True
print(5 >= 3)   # True
print(5 <= 3)   # False
```

### Truthiness and Falsiness

In Python, values are evaluated as "truthy" or "falsy" in boolean contexts:

**Falsy values** (evaluate to False):
- `False`
- `None`
- `0` (any numeric zero)
- `""` (empty string)
- `[]` (empty list)
- `{}` (empty dict)
- `()` (empty tuple)

**Truthy values** (evaluate to True):
- Everything else!

```python
# Examples
if 0:
    print("This won't print")
if 1:
    print("This will print")

if "":
    print("This won't print")
if "Hello":
    print("This will print")

# Using bool() to check truthiness
print(bool(0))      # False
print(bool(1))      # True
print(bool(""))     # False
print(bool("Hi"))   # True
print(bool([]))     # False
print(bool([1, 2])) # True
```

---

## Type Conversion

Converting between different data types is called **type casting** or **type conversion**.

### Implicit Conversion

Python automatically converts types in some cases:

```python
# Integer to float
result = 5 + 3.14  # 5 is converted to 5.0, result is 8.14

# In comparisons
print(5 == 5.0)    # True (5 is converted to 5.0)
```

### Explicit Conversion

Use built-in functions to explicitly convert types:

**1. Converting to Integer (int())**:
```python
# From float (truncates decimal part)
print(int(3.14))    # 3
print(int(3.99))    # 3 (not 4! truncates, doesn't round)

# From string (must be valid integer)
print(int("42"))    # 42
print(int("3.14"))  # ValueError! Can't convert float string directly
# Solution: int(float("3.14")) → 3

# From boolean
print(int(True))    # 1
print(int(False))   # 0
```

**2. Converting to Float (float())**:
```python
# From integer
print(float(42))    # 42.0

# From string
print(float("3.14"))  # 3.14
print(float("42"))    # 42.0

# From boolean
print(float(True))    # 1.0
print(float(False))   # 0.0
```

**3. Converting to String (str())**:
```python
# From integer
print(str(42))       # "42"

# From float
print(str(3.14))     # "3.14"

# From boolean
print(str(True))     # "True"
print(str(False))    # "False"

# From other types
print(str([1, 2, 3]))  # "[1, 2, 3]"
```

**4. Converting to Boolean (bool())**:
```python
# From integer
print(bool(0))       # False
print(bool(1))      # True
print(bool(42))     # True

# From float
print(bool(0.0))    # False
print(bool(3.14))   # True

# From string
print(bool(""))     # False
print(bool("Hi"))   # True

# From None
print(bool(None))   # False
```

**5. Converting to Complex (complex())**:
```python
print(complex(3, 4))     # (3+4j)
print(complex("3+4j"))  # (3+4j)
```

### Common Conversion Patterns

```python
# Getting numeric input from user (strings)
user_input = "25"
age = int(user_input)  # Convert to integer

# Formatting numbers for display
price = 19.99
price_str = f"${price:.2f}"  # "$19.99"

# Checking if conversion is possible
def safe_int(value):
    try:
        return int(value)
    except ValueError:
        return None

result = safe_int("42")   # 42
result = safe_int("abc")  # None
```

### Type Checking

```python
# Using type()
x = 42
print(type(x))              # <class 'int'>
print(type(x) == int)      # True

# Using isinstance() (recommended)
print(isinstance(x, int))           # True
print(isinstance(x, (int, float)))  # True (can check multiple types)

# Type hints (Python 3.5+, for documentation and static type checkers)
def greet(name: str) -> str:
    return f"Hello, {name}"

age: int = 25
price: float = 19.99
is_active: bool = True
```

---

## Practice Exercise

### Exercise: Variable Manipulation

**Objective**: Create a Python program that demonstrates working with different data types, variables, and type conversions.

**Instructions**:

1. Create a file called `variables_practice.py`

2. Write a program that:
   - Creates variables of different types (int, float, string, bool)
   - Performs operations on numeric variables
   - Manipulates strings (concatenation, slicing, methods)
   - Converts between types
   - Displays formatted output using f-strings

3. Your program should:
   - Calculate and display a person's information
   - Perform mathematical calculations
   - Format and display results nicely
   - Demonstrate type conversions

**Example Solution**:

```python
"""
Variables and Data Types Practice
This program demonstrates working with different data types,
variables, and type conversions.
"""

# Personal Information (strings)
first_name = "Alice"
last_name = "Smith"
full_name = first_name + " " + last_name

# Numeric Information
age = 25                    # Integer
height_inches = 66.5        # Float
weight_pounds = 140.0       # Float

# Boolean
is_student = True
has_driver_license = False

# Calculations
height_feet = height_inches / 12
bmi = (weight_pounds / (height_inches ** 2)) * 703

# Type conversions
age_str = str(age)
height_str = f"{height_inches:.1f}"
weight_int = int(weight_pounds)

# Display Information
print("=" * 50)
print("PERSONAL INFORMATION")
print("=" * 50)
print(f"Name: {full_name}")
print(f"First Name: {first_name}")
print(f"Last Name: {last_name}")
print()

print("=" * 50)
print("NUMERIC INFORMATION")
print("=" * 50)
print(f"Age: {age} years old (type: {type(age).__name__})")
print(f"Height: {height_inches} inches ({height_feet:.2f} feet)")
print(f"Weight: {weight_pounds} pounds ({weight_int} pounds as integer)")
print(f"BMI: {bmi:.2f}")
print()

print("=" * 50)
print("BOOLEAN INFORMATION")
print("=" * 50)
print(f"Is Student: {is_student}")
print(f"Has Driver License: {has_driver_license}")
print()

print("=" * 50)
print("STRING OPERATIONS")
print("=" * 50)
print(f"Full name in uppercase: {full_name.upper()}")
print(f"Full name in lowercase: {full_name.lower()}")
print(f"First name length: {len(first_name)} characters")
print(f"Last name first letter: {last_name[0]}")
print(f"First 3 letters of first name: {first_name[:3]}")
print()

print("=" * 50)
print("TYPE CONVERSIONS")
print("=" * 50)
print(f"Age as string: '{age_str}' (type: {type(age_str).__name__})")
print(f"Height as string: '{height_str}'")
print(f"Weight as integer: {weight_int} (type: {type(weight_int).__name__})")
print(f"Boolean to integer: {int(is_student)}")
print(f"Integer to boolean: {bool(age)}")
print()

print("=" * 50)
print("CALCULATIONS")
print("=" * 50)
years_until_30 = 30 - age
print(f"Years until 30: {years_until_30}")
print(f"Age in months: {age * 12}")
print(f"Age in days (approx): {age * 365}")
print("=" * 50)
```

**Expected Output**:
```
==================================================
PERSONAL INFORMATION
==================================================
Name: Alice Smith
First Name: Alice
Last Name: Smith

==================================================
NUMERIC INFORMATION
==================================================
Age: 25 years old (type: int)
Height: 66.5 inches (5.54 feet)
Weight: 140.0 pounds (140 pounds as integer)
BMI: 22.58

==================================================
BOOLEAN INFORMATION
==================================================
Is Student: True
Has Driver License: False

==================================================
STRING OPERATIONS
==================================================
Full name in uppercase: ALICE SMITH
Full name in lowercase: alice smith
First name length: 5 characters
Last name first letter: S
First 3 letters of first name: Ali

==================================================
TYPE CONVERSIONS
==================================================
Age as string: '25' (type: str)
Height as string: '66.5'
Weight as integer: 140 (type: int)
Boolean to integer: 1
Integer to boolean: True

==================================================
CALCULATIONS
==================================================
Years until 30: 5
Age in months: 300
Age in days (approx): 9125
==================================================
```

**Challenge** (Optional):
- Add more string operations (splitting, joining, replacing)
- Create a temperature converter (Celsius to Fahrenheit)
- Calculate and display more statistics
- Use different number bases (binary, hexadecimal)
- Create a simple calculator that takes string input and converts to numbers

---

## Key Takeaways

1. **Variables** store values and are created using the `=` operator
2. **Naming conventions** (snake_case) make code more readable
3. **Numeric types**: `int` (integers), `float` (decimals), `complex` (complex numbers)
4. **Strings** are sequences of characters with many useful methods
5. **Booleans** (`True`/`False`) represent truth values
6. **Type conversion** uses functions like `int()`, `float()`, `str()`, `bool()`
7. **Type checking** can be done with `type()` or `isinstance()`
8. **Python is dynamically typed** - variables can change types
9. **String formatting** with f-strings is the modern, recommended approach
10. **Understanding data types** is crucial for writing correct Python code

---

## Quiz: Data Types

Test your understanding with these questions:

1. **What is the output of: `print(type(3.14))`?**
   - A) `<class 'int'>`
   - B) `<class 'float'>`
   - C) `<class 'str'>`
   - D) `<class 'complex'>`

2. **Which of these is a valid variable name?**
   - A) `2variable`
   - B) `my-variable`
   - C) `my_variable`
   - D) `class`

3. **What is the result of: `int(3.99)`?**
   - A) 3
   - B) 4
   - C) 3.99
   - D) Error

4. **What does `"Hello"[1:4]` return?**
   - A) "Hell"
   - B) "ello"
   - C) "ell"
   - D) "Hel"

5. **What is the output of: `bool("")`?**
   - A) `True`
   - B) `False`
   - C) Error
   - D) `None`

6. **Which operator is used for string concatenation?**
   - A) `+`
   - B) `&`
   - C) `,`
   - D) `*`

7. **What is the result of: `"Python".upper()`?**
   - A) "python"
   - B) "PYTHON"
   - C) "Python"
   - D) Error

8. **What is the output of: `print(f"{5 + 3}")`?**
   - A) `5 + 3`
   - B) `8`
   - C) `"8"`
   - D) Error

9. **Which of these is a falsy value in Python?**
   - A) `1`
   - B) `"Hello"`
   - C) `0`
   - D) `[1, 2, 3]`

10. **What is the result of: `str(True)`?**
    - A) `"1"`
    - B) `"True"`
    - C) `1`
    - D) `True`

**Answers**:
1. B) `<class 'float'>`
2. C) `my_variable`
3. A) 3 (truncates, doesn't round)
4. C) "ell" (indices 1, 2, 3)
5. B) `False` (empty string is falsy)
6. A) `+`
7. B) "PYTHON"
8. B) `8` (f-string evaluates expression)
9. C) `0` (zero is falsy)
10. B) `"True"` (string representation)

---

## Next Steps

Excellent work! You've learned about variables and data types. You now understand:
- How to create and name variables
- Different numeric types (int, float, complex)
- String operations and formatting
- Boolean values and truthiness
- Type conversion and checking

**What's Next?**
- Module 2: Operators and Expressions
- Practice creating more programs with different data types
- Experiment with string methods and formatting
- Try converting between types in different scenarios

---

## Additional Resources

- **Python Data Types**: [docs.python.org/3/library/stdtypes.html](https://docs.python.org/3/library/stdtypes.html)
- **String Methods**: [docs.python.org/3/library/stdtypes.html#string-methods](https://docs.python.org/3/library/stdtypes.html#string-methods)
- **Numeric Types**: [docs.python.org/3/library/stdtypes.html#numeric-types-int-float-complex](https://docs.python.org/3/library/stdtypes.html#numeric-types-int-float-complex)
- **PEP 8 Naming Conventions**: [pep8.org/#naming-conventions](https://pep8.org/#naming-conventions)
- **Type Hints**: [docs.python.org/3/library/typing.html](https://docs.python.org/3/library/typing.html)

---

*Lesson completed! You're ready to move on to the next lesson.*

