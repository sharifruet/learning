# Lesson 1.2: Python Syntax and Basics

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand Python's syntax rules and conventions
- Use proper indentation to create code blocks
- Write effective comments and documentation
- Use the print() function with various formatting options
- Identify and fix common syntax errors
- Write clean, readable Python code

---

## Python Syntax Rules

Python syntax is designed to be clean, readable, and intuitive. Understanding these fundamental rules is crucial for writing correct Python code.

### 1. Statements and Lines

**Basic Rule**: Each statement typically occupies one line.

```python
# Each line is a statement
print("Hello")
print("World")
x = 5
y = 10
```

**Multiple Statements on One Line** (not recommended, but possible):
```python
# Use semicolon to separate statements (avoid in practice)
print("Hello"); print("World"); x = 5
```

**Line Continuation**: For long lines, you can break them using parentheses or backslash:

```python
# Using parentheses (preferred)
total = (1 + 2 + 3 + 
         4 + 5 + 6)

# Using backslash (less common)
total = 1 + 2 + 3 + \
        4 + 5 + 6
```

### 2. Case Sensitivity

Python is **case-sensitive**. This means:
- `name`, `Name`, and `NAME` are three different variables
- `print` is a function, but `Print` or `PRINT` are not

```python
# These are all different
name = "Alice"
Name = "Bob"
NAME = "Charlie"

print(name)  # Output: Alice
print(Name)  # Output: Bob
print(NAME)  # Output: Charlie
```

### 3. Identifiers and Naming Rules

Identifiers are names used for variables, functions, classes, etc.

**Rules for identifiers**:
- Must start with a letter (a-z, A-Z) or underscore (_)
- Can contain letters, digits (0-9), and underscores
- Cannot be a Python keyword (reserved word)
- Cannot contain spaces or special characters

**Valid identifiers**:
```python
name = "John"
user_name = "john_doe"
userName = "johnDoe"
_name = "private"
name2 = "second"
```

**Invalid identifiers**:
```python
# 2name = "invalid"      # Cannot start with digit
# user-name = "invalid"  # Cannot contain hyphens
# user name = "invalid"  # Cannot contain spaces
# class = "invalid"      # Cannot use keyword
```

### 4. Python Keywords

Keywords are reserved words that have special meaning in Python. You cannot use them as variable names.

**Common Python keywords**:
```python
# Some important keywords (you'll learn these later)
True, False, None
if, else, elif, for, while, break, continue
def, return, class, import, from
and, or, not, in, is
try, except, finally, raise
```

**Check if a word is a keyword**:
```python
import keyword
print(keyword.kwlist)  # Shows all Python keywords
print(keyword.iskeyword("if"))  # Returns True
```

### 5. Literals

Literals are fixed values directly written in code:

```python
# String literals
"Hello, World!"
'Python'

# Numeric literals
42          # Integer
3.14        # Float
1.5e2       # Scientific notation (150.0)

# Boolean literals
True
False

# None literal
None
```

### 6. Operators and Punctuation

Python uses various operators and punctuation marks:

```python
# Arithmetic operators
+ - * / % ** //

# Comparison operators
== != < > <= >=

# Logical operators
and or not

# Assignment operators
= += -= *= /=

# Punctuation
() [] {} : , . ; @
```

---

## Indentation and Code Blocks

**Indentation is crucial in Python!** Unlike many languages that use braces `{}` to define code blocks, Python uses indentation.

### Why Indentation Matters

Python uses indentation to determine the structure and grouping of code. This makes Python code more readable but requires careful attention to spacing.

### Indentation Rules

1. **Use consistent indentation** (spaces or tabs, but not both)
2. **Standard is 4 spaces** (recommended by PEP 8)
3. **Indentation level determines code blocks**

### Examples of Indentation

**Correct indentation**:
```python
if True:
    print("This is indented")
    print("This is also indented")
    if True:
        print("This is double-indented")
print("This is not indented - back to base level")
```

**Incorrect indentation** (will cause errors):
```python
# This will cause an IndentationError
if True:
print("This is not indented properly")
```

### Code Blocks

Code blocks are groups of statements that execute together. They're created by indentation:

```python
# Example: if statement block
x = 10
if x > 5:
    print("x is greater than 5")
    print("This is part of the if block")
    y = x * 2
    print(f"y is {y}")
print("This is outside the if block")

# Example: function block (you'll learn functions later)
def greet():
    print("Hello")
    print("Welcome")
    print("Goodbye")
```

### Indentation Best Practices

1. **Use 4 spaces** (not tabs, not 2 spaces, not 8 spaces)
2. **Be consistent** throughout your file
3. **Most editors can convert tabs to spaces automatically**
4. **Configure your editor** to show whitespace

**Common Indentation Errors**:

```python
# Error 1: No indentation after colon
if True:
print("Error!")  # IndentationError

# Error 2: Inconsistent indentation
if True:
    print("4 spaces")
  print("2 spaces")  # IndentationError

# Error 3: Unexpected indentation
    print("Unexpected indentation")  # IndentationError (no preceding statement)
```

### Visual Guide to Indentation Levels

```python
# Level 0 (no indentation)
def function_name():
    # Level 1 (4 spaces)
    if condition:
        # Level 2 (8 spaces)
        print("Level 2")
        if nested:
            # Level 3 (12 spaces)
            print("Level 3")
    # Back to Level 1
    print("Back to Level 1")
# Back to Level 0
```

---

## Comments and Documentation

Comments are essential for explaining code, making notes, and temporarily disabling code. Python provides several ways to add comments.

### Single-Line Comments

Use `#` to create a single-line comment. Everything after `#` on that line is ignored by Python.

```python
# This is a comment
print("Hello")  # This is also a comment

# Comments can be on their own line
# Or at the end of a line of code

# You can comment out code to disable it
# print("This won't run")
```

### Multi-Line Comments

Python doesn't have a built-in multi-line comment syntax, but there are conventions:

**Method 1: Multiple single-line comments** (most common):
```python
# This is a multi-line comment
# using multiple single-line comments
# Each line starts with #
```

**Method 2: Triple-quoted strings** (technically a string, but used as comment):
```python
"""
This is a multi-line string
that can be used as a comment.
It's actually a docstring if placed
at the start of a function/class.
"""
```

### When to Use Comments

**Good uses of comments**:
```python
# Calculate the area of a circle
radius = 5
area = 3.14159 * radius ** 2  # Formula: π * r²

# TODO: Add error handling here
# FIXME: This needs optimization
# NOTE: This works but could be improved
```

**Avoid obvious comments**:
```python
# Bad: Comment states the obvious
x = 5  # Set x to 5

# Good: Comment explains why
x = 5  # Default timeout value in seconds
```

### Docstrings

Docstrings are special strings used to document functions, classes, and modules. They use triple quotes and are placed immediately after the definition.

```python
def greet(name):
    """
    Greet a person by name.
    
    Args:
        name (str): The name of the person to greet
    
    Returns:
        str: A greeting message
    """
    return f"Hello, {name}!"
```

**Docstring conventions**:
- Use triple double quotes `"""` or triple single quotes `'''`
- First line should be a brief summary
- Can span multiple lines
- Used by help() function and documentation tools

**Accessing docstrings**:
```python
def example():
    """This is a docstring."""
    pass

print(example.__doc__)  # Prints the docstring
help(example)           # Shows formatted help
```

### Comment Best Practices

1. **Write clear, concise comments**
2. **Explain "why" not "what"** (code should be self-explanatory)
3. **Keep comments up-to-date** (outdated comments are worse than no comments)
4. **Use comments to mark TODOs and FIXMEs**
5. **Document complex algorithms or business logic**

---

## Print Statements

The `print()` function is one of the most commonly used functions in Python. It displays output to the console.

### Basic Print

```python
print("Hello, World!")
print(42)
print(3.14)
```

### Print Multiple Items

You can print multiple items separated by spaces:

```python
print("Hello", "World", "Python")
# Output: Hello World Python

print("Name:", "Alice", "Age:", 25)
# Output: Name: Alice Age: 25
```

### Print with Separator

Control how items are separated using the `sep` parameter:

```python
print("Hello", "World", sep="")
# Output: HelloWorld

print("Hello", "World", sep="-")
# Output: Hello-World

print("2024", "01", "15", sep="/")
# Output: 2024/01/15
```

### Print with End

Control what happens at the end of the print statement using the `end` parameter:

```python
# Default: end with newline
print("Hello")
print("World")
# Output:
# Hello
# World

# Custom end character
print("Hello", end=" ")
print("World")
# Output: Hello World

print("Loading", end="...")
print("Complete")
# Output: Loading...Complete

# No newline
print("Line 1", end="")
print("Line 2", end="")
# Output: Line 1Line 2
```

### Print Multiple Lines

**Method 1: Multiple print statements**:
```python
print("Line 1")
print("Line 2")
print("Line 3")
```

**Method 2: Escape sequences**:
```python
print("Line 1\nLine 2\nLine 3")
# \n creates a newline

print("First line\nSecond line")
```

**Method 3: Triple-quoted strings**:
```python
print("""Line 1
Line 2
Line 3""")
```

### Common Escape Sequences

Escape sequences are special characters that start with a backslash:

```python
print("Hello\nWorld")      # \n = newline
print("Hello\tWorld")      # \t = tab
print("She said \"Hello\"") # \" = literal quote
print('It\'s Python')      # \' = literal apostrophe
print("Path: C:\\Users")   # \\ = literal backslash
```

**Common escape sequences**:
- `\n` - Newline
- `\t` - Tab
- `\"` - Double quote
- `\'` - Single quote
- `\\` - Backslash
- `\r` - Carriage return

### Print Formatting

**Method 1: String concatenation**:
```python
name = "Alice"
age = 25
print("Name: " + name + ", Age: " + str(age))
```

**Method 2: Comma separation** (automatic spacing):
```python
name = "Alice"
age = 25
print("Name:", name, "Age:", age)
```

**Method 3: f-strings** (Python 3.6+, recommended):
```python
name = "Alice"
age = 25
print(f"Name: {name}, Age: {age}")
```

**Method 4: .format() method**:
```python
name = "Alice"
age = 25
print("Name: {}, Age: {}".format(name, age))
```

**Method 5: % formatting** (older style):
```python
name = "Alice"
age = 25
print("Name: %s, Age: %d" % (name, age))
```

### Print Examples

```python
# Simple output
print("Welcome to Python!")

# Multiple values
x = 10
y = 20
print("x =", x, "y =", y)

# Formatted output
name = "Alice"
score = 95.5
print(f"Student: {name}, Score: {score}%")

# Table-like output
print("Name", "Age", "City", sep=" | ")
print("Alice", 25, "NYC", sep=" | ")
print("Bob", 30, "LA", sep=" | ")

# Progress indicator
for i in range(5):
    print(f"Progress: {i+1}/5", end="\r")
```

### Print to File (Advanced)

You can also print to a file instead of the console:

```python
# Print to a file
with open("output.txt", "w") as f:
    print("Hello, File!", file=f)
```

---

## Common Syntax Errors

Understanding common errors helps you debug your code faster.

### 1. SyntaxError: Invalid Syntax

**Missing colon**:
```python
# Wrong
if True
    print("Hello")

# Correct
if True:
    print("Hello")
```

**Missing parentheses**:
```python
# Wrong
print "Hello"

# Correct
print("Hello")
```

### 2. IndentationError

**Inconsistent indentation**:
```python
# Wrong
if True:
    print("Hello")
  print("World")  # Wrong indentation

# Correct
if True:
    print("Hello")
    print("World")
```

**Unexpected indentation**:
```python
# Wrong
    print("Unexpected")

# Correct
print("Expected")
```

### 3. NameError

**Undefined variable**:
```python
# Wrong
print(undefined_variable)

# Correct
defined_variable = "Hello"
print(defined_variable)
```

### 4. TypeError

**Wrong type usage**:
```python
# Wrong
"Hello" + 5

# Correct
"Hello" + str(5)
# Or
"Hello" + "5"
```

---

## Practice Exercise

### Exercise: Practice Syntax and Comments

**Objective**: Write a Python program that demonstrates proper syntax, indentation, comments, and print statements.

**Instructions**:

1. Create a file called `syntax_practice.py`

2. Write a program that:
   - Includes a docstring at the top explaining what the program does
   - Uses proper indentation
   - Contains helpful comments
   - Uses print() with different formatting options
   - Demonstrates escape sequences
   - Uses f-strings for formatted output

3. Your program should display:
   - A header with your name
   - Information about Python syntax rules
   - A formatted table of escape sequences
   - A footer message

**Example Solution**:

```python
"""
Python Syntax Practice Program
This program demonstrates proper Python syntax, indentation,
comments, and print statements.
Author: [Your Name]
"""

# Program header
print("=" * 50)
print("PYTHON SYNTAX PRACTICE")
print("=" * 50)
print()

# Display information about Python
print("Python Syntax Rules:")
print("- Python is case-sensitive")
print("- Indentation defines code blocks")
print("- Comments start with #")
print()

# Escape sequences table
print("Common Escape Sequences:")
print("-" * 30)
print("Sequence | Description")
print("-" * 30)
print("\\n       | Newline")
print("\\t       | Tab")
print("\\\"       | Double quote")
print("\\\\       | Backslash")
print()

# Using f-strings for formatted output
name = "Python Learner"
age = 1
language = "Python"

print(f"Student Information:")
print(f"  Name: {name}")
print(f"  Experience: {age} year(s)")
print(f"  Learning: {language}")
print()

# Footer
print("=" * 50)
print("Keep practicing Python syntax!")
print("=" * 50)
```

**Expected Output**:
```
==================================================
PYTHON SYNTAX PRACTICE
==================================================

Python Syntax Rules:
- Python is case-sensitive
- Indentation defines code blocks
- Comments start with #

Common Escape Sequences:
------------------------------
Sequence | Description
------------------------------
\n       | Newline
\t       | Tab
\"       | Double quote
\\       | Backslash

Student Information:
  Name: Python Learner
  Experience: 1 year(s)
  Learning: Python

==================================================
Keep practicing Python syntax!
==================================================
```

**Challenge** (Optional):
- Add more escape sequences to the table
- Create a function to display the header (you'll learn functions later, but try it!)
- Use different print formatting methods (f-strings, .format(), etc.)
- Add color to your output (if your terminal supports it)

---

## Key Takeaways

1. **Python syntax** is clean and readable, with specific rules for identifiers and keywords
2. **Indentation** is mandatory in Python and defines code blocks (use 4 spaces)
3. **Comments** (`#`) help document code and explain complex logic
4. **Docstrings** (`"""`) document functions, classes, and modules
5. **print()** function displays output with various formatting options
6. **Escape sequences** (`\n`, `\t`, etc.) add special characters to strings
7. **f-strings** are the modern, recommended way to format output
8. **Common errors** include SyntaxError, IndentationError, NameError, and TypeError

---

## Quiz: Syntax Fundamentals

Test your understanding with these questions:

1. **What is the standard indentation in Python?**
   - A) 2 spaces
   - B) 4 spaces
   - C) 8 spaces
   - D) Tabs

2. **Which of these is a valid Python identifier?**
   - A) `2variable`
   - B) `user-name`
   - C) `user_name`
   - D) `user name`

3. **What does `\n` represent in a string?**
   - A) Newline
   - B) Tab
   - C) Backslash
   - D) Quote

4. **How do you create a single-line comment in Python?**
   - A) `// comment`
   - B) `/* comment */`
   - C) `# comment`
   - D) `<!-- comment -->`

5. **What is the output of: `print("Hello", "World", sep="-")`?**
   - A) `Hello World`
   - B) `Hello-World`
   - C) `Hello,World`
   - D) `Hello-World-`

6. **True or False: Python uses braces `{}` to define code blocks.**
   - A) True
   - B) False

7. **What escape sequence creates a tab?**
   - A) `\t`
   - B) `\n`
   - C) `\tab`
   - D) `\space`

8. **Which of these will cause a SyntaxError?**
   - A) `print("Hello")`
   - B) `if True: print("Hello")`
   - C) `if True print("Hello")`
   - D) `print("Hello", "World")`

**Answers**:
1. B) 4 spaces
2. C) `user_name`
3. A) Newline
4. C) `# comment`
5. B) `Hello-World`
6. B) False (Python uses indentation)
7. A) `\t`
8. C) `if True print("Hello")` (missing colon)

---

## Next Steps

Great job! You've learned the fundamentals of Python syntax. You now understand:
- Python syntax rules and conventions
- How indentation works in Python
- How to write comments and docstrings
- How to use the print() function effectively
- Common syntax errors and how to avoid them

**What's Next?**
- Lesson 1.3: Variables and Data Types
- Practice writing more programs with proper syntax
- Experiment with different print() formatting options
- Review your code for proper indentation and comments

---

## Additional Resources

- **PEP 8 - Style Guide**: [pep8.org](https://pep8.org/) - Official Python style guide
- **Python Style Guide**: [python.org/dev/peps/pep-0008](https://www.python.org/dev/peps/pep-0008/)
- **Python Keywords**: [docs.python.org/3/reference/lexical_analysis.html#keywords](https://docs.python.org/3/reference/lexical_analysis.html#keywords)
- **Print Function Documentation**: [docs.python.org/3/library/functions.html#print](https://docs.python.org/3/library/functions.html#print)

---

*Lesson completed! You're ready to move on to the next lesson.*

