# Lesson 7.1: String Methods

## Learning Objectives

By the end of this lesson, you will be able to:
- Use common string methods for text manipulation
- Format strings using different methods (format, f-strings)
- Search and replace text in strings
- Transform string case (upper, lower, title, etc.)
- Split and join strings effectively
- Clean and validate strings
- Work with string whitespace
- Apply string methods in practical scenarios
- Understand string immutability and method chaining

---

## Introduction to String Methods

Strings in Python are **immutable objects** with many built-in methods for manipulation. These methods return new strings rather than modifying the original.

### Key Concepts

1. **String Immutability**: Strings cannot be changed in place
2. **Method Returns**: Methods return new strings
3. **Method Chaining**: Can chain multiple methods together
4. **Case Sensitivity**: Many operations are case-sensitive

### Why String Methods Matter

- **Text Processing**: Clean and transform user input
- **Data Validation**: Check string properties
- **Formatting**: Create readable output
- **Parsing**: Extract information from strings
- **Searching**: Find and replace text

---

## Case Conversion Methods

### upper() and lower()

Convert strings to uppercase or lowercase:

```python
text = "Hello World"

print(text.upper())  # Output: HELLO WORLD
print(text.lower())  # Output: hello world
print(text)          # Output: Hello World (original unchanged)
```

### capitalize() and title()

```python
text = "hello world python"

print(text.capitalize())  # Output: Hello world python (first letter only)
print(text.title())       # Output: Hello World Python (each word capitalized)
```

### swapcase()

```python
text = "Hello World"

print(text.swapcase())  # Output: hELLO wORLD
```

### Practical Example

```python
# User input normalization
user_input = "  JOHN DOE  "
normalized = user_input.strip().title()
print(f"'{normalized}'")  # Output: 'John Doe'
```

---

## Whitespace Methods

### strip(), lstrip(), rstrip()

Remove whitespace from strings:

```python
text = "  hello world  "

print(f"'{text.strip()}'")   # Output: 'hello world' (both sides)
print(f"'{text.lstrip()}'")  # Output: 'hello world  ' (left only)
print(f"'{text.rstrip()}'")  # Output: '  hello world' (right only)
```

### Custom Characters

```python
text = "***hello***"

print(text.strip("*"))   # Output: hello
print(text.lstrip("*"))  # Output: hello***
print(text.rstrip("*"))  # Output: ***hello
```

### Practical Example

```python
# Clean user input
user_email = "  user@example.com  "
clean_email = user_email.strip()
print(f"'{clean_email}'")  # Output: 'user@example.com'
```

---

## Splitting and Joining Strings

### split()

Split a string into a list:

```python
text = "apple,banana,cherry"
fruits = text.split(",")
print(fruits)  # Output: ['apple', 'banana', 'cherry']

# Default splits on whitespace
text = "hello world python"
words = text.split()
print(words)  # Output: ['hello', 'world', 'python']

# Limit splits
text = "one,two,three,four"
parts = text.split(",", 2)
print(parts)  # Output: ['one', 'two', 'three,four']
```

### splitlines()

Split by line breaks:

```python
text = "line1\nline2\nline3"
lines = text.splitlines()
print(lines)  # Output: ['line1', 'line2', 'line3']
```

### join()

Join a list into a string:

```python
fruits = ["apple", "banana", "cherry"]
result = ", ".join(fruits)
print(result)  # Output: apple, banana, cherry

# Join with different separator
words = ["hello", "world"]
sentence = " ".join(words)
print(sentence)  # Output: hello world

# Join characters
chars = ["h", "e", "l", "l", "o"]
word = "".join(chars)
print(word)  # Output: hello
```

### Practical Example

```python
# Process CSV-like data
data = "name,age,city"
fields = data.split(",")
print(fields)  # Output: ['name', 'age', 'city']

# Reconstruct with different separator
new_data = " | ".join(fields)
print(new_data)  # Output: name | age | city
```

---

## String Searching Methods

### find() and index()

Find substring position:

```python
text = "hello world"

# find() returns -1 if not found
print(text.find("world"))   # Output: 6
print(text.find("python"))  # Output: -1

# index() raises ValueError if not found
print(text.index("world"))   # Output: 6
# print(text.index("python"))  # ValueError: substring not found

# Start and end positions
text = "hello hello world"
print(text.find("hello", 1))  # Output: 6 (starts searching from index 1)
```

### rfind() and rindex()

Search from the right:

```python
text = "hello world hello"

print(text.find("hello"))   # Output: 0 (first occurrence)
print(text.rfind("hello"))  # Output: 12 (last occurrence)
```

### count()

Count occurrences:

```python
text = "hello world hello"

print(text.count("hello"))  # Output: 2
print(text.count("l"))      # Output: 4
print(text.count("x"))      # Output: 0
```

### startswith() and endswith()

Check if string starts/ends with substring:

```python
text = "hello world"

print(text.startswith("hello"))  # Output: True
print(text.startswith("world"))  # Output: False
print(text.endswith("world"))    # Output: True
print(text.endswith("hello"))    # Output: False

# Check multiple options
print(text.startswith(("hello", "hi")))  # Output: True
```

### Practical Example

```python
# Validate file extensions
filename = "document.pdf"
if filename.endswith((".pdf", ".doc", ".docx")):
    print("Valid document file")

# Check URL protocol
url = "https://example.com"
if url.startswith("https"):
    print("Secure connection")
```

---

## String Replacement Methods

### replace()

Replace occurrences of substring:

```python
text = "hello world"

# Replace all occurrences
new_text = text.replace("world", "python")
print(new_text)  # Output: hello python

# Replace with count limit
text = "hello hello hello"
new_text = text.replace("hello", "hi", 2)
print(new_text)  # Output: hi hi hello
```

### Practical Example

```python
# Clean text
text = "Hello   World    Python"
cleaned = text.replace("  ", " ")  # Replace double spaces
print(cleaned)  # Output: Hello  World  Python

# Better approach
cleaned = " ".join(text.split())  # Split and rejoin
print(cleaned)  # Output: Hello World Python

# Replace multiple things
text = "Hello, World! How are you?"
text = text.replace(",", "").replace("!", "").replace("?", "")
print(text)  # Output: Hello World How are you
```

---

## String Validation Methods

### isalpha(), isdigit(), isalnum()

Check character types:

```python
text1 = "Hello"
text2 = "123"
text3 = "Hello123"
text4 = "Hello 123"

print(text1.isalpha())  # Output: True (all letters)
print(text2.isdigit())  # Output: True (all digits)
print(text3.isalnum())  # Output: True (letters and digits)
print(text4.isalnum())  # Output: False (contains space)
```

### isspace(), isupper(), islower()

```python
text1 = "   "
text2 = "HELLO"
text3 = "hello"
text4 = "Hello"

print(text1.isspace())  # Output: True
print(text2.isupper())  # Output: True
print(text3.islower())  # Output: True
print(text4.isupper())  # Output: False (mixed case)
```

### istitle()

```python
text1 = "Hello World"
text2 = "hello world"
text3 = "HELLO WORLD"

print(text1.istitle())  # Output: True
print(text2.istitle())  # Output: False
print(text3.istitle())  # Output: False
```

### Practical Example

```python
# Validate user input
def validate_username(username):
    if not username:
        return False
    if not username.isalnum():
        return False
    if len(username) < 3 or len(username) > 20:
        return False
    return True

print(validate_username("user123"))  # Output: True
print(validate_username("user 123"))  # Output: False
print(validate_username("ab"))      # Output: False
```

---

## String Formatting

### Old Style: % Formatting

```python
name = "Alice"
age = 30

# Old style (Python 2, still works)
message = "Hello, %s! You are %d years old." % (name, age)
print(message)  # Output: Hello, Alice! You are 30 years old.
```

### str.format() Method

```python
name = "Alice"
age = 30

# Positional arguments
message = "Hello, {}! You are {} years old.".format(name, age)
print(message)  # Output: Hello, Alice! You are 30 years old.

# Named arguments
message = "Hello, {name}! You are {age} years old.".format(name=name, age=age)
print(message)  # Output: Hello, Alice! You are 30 years old.

# Indexed arguments
message = "Hello, {0}! You are {1} years old. Goodbye, {0}!".format(name, age)
print(message)  # Output: Hello, Alice! You are 30 years old. Goodbye, Alice!
```

### Format Specifiers

```python
# Numbers
pi = 3.14159
print("{:.2f}".format(pi))      # Output: 3.14 (2 decimal places)
print("{:10.2f}".format(pi))    # Output: "      3.14" (width 10)

# Integers
number = 42
print("{:05d}".format(number))  # Output: 00042 (zero-padded, width 5)

# Strings
text = "hello"
print("{:>10}".format(text))    # Output: "     hello" (right-aligned)
print("{:<10}".format(text))    # Output: "hello     " (left-aligned)
print("{:^10}".format(text))    # Output: "  hello   " (center-aligned)
```

### f-strings (Formatted String Literals)

**f-strings** are the modern, preferred way to format strings (Python 3.6+):

```python
name = "Alice"
age = 30

# Basic f-string
message = f"Hello, {name}! You are {age} years old."
print(message)  # Output: Hello, Alice! You are 30 years old.

# Expressions in f-strings
x = 5
y = 10
result = f"{x} + {y} = {x + y}"
print(result)  # Output: 5 + 10 = 15

# Function calls
def get_greeting():
    return "Hello"

message = f"{get_greeting()}, {name}!"
print(message)  # Output: Hello, Alice!
```

### f-string Format Specifiers

```python
# Numbers
pi = 3.14159
print(f"{pi:.2f}")        # Output: 3.14
print(f"{pi:10.2f}")      # Output: "      3.14"

# Integers
number = 42
print(f"{number:05d}")    # Output: 00042

# Strings
text = "hello"
print(f"{text:>10}")      # Output: "     hello"
print(f"{text:<10}")      # Output: "hello     "
print(f"{text:^10}")      # Output: "  hello   "

# Multiple variables
name = "Alice"
age = 30
score = 95.5
print(f"Name: {name:>10}, Age: {age:3d}, Score: {score:5.1f}")
# Output: Name:      Alice, Age:  30, Score:  95.5
```

### Practical Formatting Examples

```python
# Currency formatting
price = 19.99
print(f"Price: ${price:.2f}")  # Output: Price: $19.99

# Percentage
ratio = 0.75
print(f"Progress: {ratio:.1%}")  # Output: Progress: 75.0%

# Date-like formatting
year = 2024
month = 3
day = 15
print(f"{year:04d}-{month:02d}-{day:02d}")  # Output: 2024-03-15

# Table formatting
data = [
    ("Alice", 30, 95.5),
    ("Bob", 25, 87.3),
    ("Charlie", 35, 92.1)
]

for name, age, score in data:
    print(f"{name:10} | {age:3} | {score:5.1f}")
# Output:
# Alice      |  30 |  95.5
# Bob        |  25 |  87.3
# Charlie    |  35 |  92.1
```

---

## String Alignment and Padding

### center(), ljust(), rjust()

```python
text = "hello"

print(text.center(10))     # Output: "  hello   "
print(text.center(10, "*"))  # Output: "**hello***"
print(text.ljust(10))      # Output: "hello     "
print(text.rjust(10))      # Output: "     hello"
print(text.rjust(10, "0"))  # Output: "00000hello"
```

### zfill()

Zero-fill (pad with zeros on the left):

```python
number = "42"
print(number.zfill(5))  # Output: 00042

# Useful for formatting IDs
id = "123"
print(f"ID: {id.zfill(6)}")  # Output: ID: 000123
```

---

## String Partitioning

### partition() and rpartition()

Split string into three parts:

```python
text = "hello world python"

# partition() - splits on first occurrence
result = text.partition(" ")
print(result)  # Output: ('hello', ' ', 'world python')

# rpartition() - splits on last occurrence
result = text.rpartition(" ")
print(result)  # Output: ('hello world', ' ', 'python')

# When separator not found
result = text.partition("x")
print(result)  # Output: ('hello world python', '', '')
```

### Practical Example

```python
# Extract domain from email
email = "user@example.com"
local, separator, domain = email.partition("@")
print(f"Local: {local}, Domain: {domain}")
# Output: Local: user, Domain: example.com
```

---

## Method Chaining

Chain multiple string methods together:

```python
text = "  Hello World  "

# Chain methods
result = text.strip().lower().replace("world", "python").title()
print(result)  # Output: Hello Python

# Process user input
user_input = "  JOHN DOE  "
normalized = user_input.strip().title()
print(normalized)  # Output: John Doe

# Clean and format
text = "hello,world,python"
cleaned = text.replace(",", " ").title()
print(cleaned)  # Output: Hello World Python
```

---

## Common String Operations Summary

### Quick Reference

```python
text = "  Hello World  "

# Case conversion
text.upper()        # "  HELLO WORLD  "
text.lower()        # "  hello world  "
text.title()        # "  Hello World  "
text.capitalize()   # "  hello world  "
text.swapcase()     # "  hELLO wORLD  "

# Whitespace
text.strip()        # "Hello World"
text.lstrip()       # "Hello World  "
text.rstrip()       # "  Hello World"

# Splitting/Joining
"a,b,c".split(",")           # ['a', 'b', 'c']
", ".join(['a', 'b', 'c'])   # "a, b, c"

# Searching
text.find("World")      # 9
text.count("l")         # 3
text.startswith("Hello")  # False (has leading spaces)
text.endswith("World")   # False (has trailing spaces)

# Replacement
text.replace("World", "Python")  # "  Hello Python  "

# Validation
"Hello".isalpha()   # True
"123".isdigit()     # True
"Hello123".isalnum()  # True
"  ".isspace()      # True

# Formatting
f"Hello, {name}!"   # f-string
"{0} {1}".format(a, b)  # format method
```

---

## Practical Examples

### Example 1: Text Processing

```python
def process_text(text):
    """Clean and normalize text."""
    # Remove extra whitespace
    text = " ".join(text.split())
    # Convert to title case
    text = text.title()
    return text

text = "  hello   world   python  "
result = process_text(text)
print(result)  # Output: Hello World Python
```

### Example 2: Email Validation

```python
def is_valid_email(email):
    """Basic email validation."""
    email = email.strip().lower()
    
    # Check basic structure
    if "@" not in email:
        return False
    if "." not in email:
        return False
    
    local, domain = email.split("@", 1)
    
    # Check local and domain
    if not local or not domain:
        return False
    if " " in email:
        return False
    
    return True

print(is_valid_email("user@example.com"))  # Output: True
print(is_valid_email("invalid email"))     # Output: False
```

### Example 3: Password Strength Check

```python
def check_password_strength(password):
    """Check password strength."""
    checks = {
        "length": len(password) >= 8,
        "has_upper": any(c.isupper() for c in password),
        "has_lower": any(c.islower() for c in password),
        "has_digit": any(c.isdigit() for c in password),
        "has_special": any(not c.isalnum() for c in password)
    }
    
    score = sum(checks.values())
    return checks, score

password = "MyP@ssw0rd"
checks, score = check_password_strength(password)
print(f"Score: {score}/5")
print(checks)
```

### Example 4: CSV Parsing

```python
def parse_csv_line(line):
    """Parse a CSV line into fields."""
    line = line.strip()
    if not line:
        return []
    return [field.strip() for field in line.split(",")]

csv_line = "name, age, city, country"
fields = parse_csv_line(csv_line)
print(fields)  # Output: ['name', 'age', 'city', 'country']
```

### Example 5: Text Statistics

```python
def text_statistics(text):
    """Calculate text statistics."""
    words = text.split()
    chars = len(text)
    chars_no_spaces = len(text.replace(" ", ""))
    
    return {
        "words": len(words),
        "characters": chars,
        "characters_no_spaces": chars_no_spaces,
        "average_word_length": sum(len(w) for w in words) / len(words) if words else 0
    }

text = "Hello world Python programming"
stats = text_statistics(text)
print(stats)
# Output: {'words': 4, 'characters': 31, 'characters_no_spaces': 27, 'average_word_length': 6.75}
```

---

## Common Mistakes and Pitfalls

### 1. Forgetting String Immutability

```python
# Wrong: trying to modify string
text = "hello"
# text[0] = "H"  # TypeError: 'str' object does not support item assignment

# Correct: create new string
text = "hello"
text = "H" + text[1:]  # "Hello"
# Or use methods
text = text.capitalize()  # "Hello"
```

### 2. Not Assigning Return Value

```python
# Wrong: method doesn't modify original
text = "hello"
text.upper()
print(text)  # Output: hello (unchanged!)

# Correct: assign return value
text = "hello"
text = text.upper()
print(text)  # Output: HELLO
```

### 3. Case-Sensitive Operations

```python
# Wrong: case-sensitive search
text = "Hello World"
if "hello" in text:  # False (case doesn't match)
    print("Found")

# Correct: normalize case
text = "Hello World"
if "hello" in text.lower():
    print("Found")
```

### 4. Split Without Checking

```python
# Wrong: assumes split always works
email = "user@example.com"
local = email.split("@")[0]  # Works

email = "invalid"
local = email.split("@")[0]  # Still works, but might not be what you want

# Better: check first
if "@" in email:
    local = email.split("@")[0]
```

### 5. Whitespace Issues

```python
# Wrong: not handling whitespace
user_input = "  john doe  "
username = user_input  # Contains spaces

# Correct: strip whitespace
user_input = "  john doe  "
username = user_input.strip()
```

---

## Best Practices

### 1. Use f-strings for Formatting

```python
# Preferred (Python 3.6+)
name = "Alice"
age = 30
message = f"Hello, {name}! You are {age} years old."

# Avoid old style
message = "Hello, %s! You are %d years old." % (name, age)
```

### 2. Normalize User Input

```python
# Always clean user input
user_input = input("Enter name: ").strip().title()
```

### 3. Use Method Chaining Wisely

```python
# Good: readable chain
text = "  HELLO WORLD  "
result = text.strip().lower().title()

# Avoid: too long chains
result = text.strip().lower().replace("a", "b").title().replace("c", "d")  # Hard to read
```

### 4. Validate Before Processing

```python
# Check if string is not empty
if text and text.strip():
    # Process text
    pass
```

### 5. Use Appropriate Methods

```python
# Use startswith/endswith instead of slicing when possible
if text.startswith("http"):  # Clear intent
    pass

# Instead of
if text[:4] == "http":  # Less clear
    pass
```

---

## Practice Exercise

### Exercise: String Manipulation Practice

**Objective**: Create a Python program that demonstrates various string methods and formatting techniques.

**Instructions**:

1. Create a file called `string_practice.py`

2. Write a program that:
   - Processes and cleans text input
   - Formats strings in various ways
   - Searches and replaces text
   - Validates string properties
   - Demonstrates f-strings and formatting
   - Implements practical string utilities

3. Your program should include:
   - Text cleaning functions
   - String formatting examples
   - Search and replace operations
   - Validation functions
   - CSV parsing
   - Text statistics

**Example Solution**:

```python
"""
String Manipulation Practice
This program demonstrates various string methods and formatting techniques.
"""

print("=" * 60)
print("STRING MANIPULATION PRACTICE")
print("=" * 60)
print()

# 1. Case Conversion
print("1. CASE CONVERSION")
print("-" * 60)
text = "hello world python"
print(f"Original: {text}")
print(f"Upper: {text.upper()}")
print(f"Lower: {text.lower()}")
print(f"Title: {text.title()}")
print(f"Capitalize: {text.capitalize()}")
print(f"Swapcase: {text.swapcase()}")
print()

# 2. Whitespace Handling
print("2. WHITESPACE HANDLING")
print("-" * 60)
text = "  hello world  "
print(f"Original: '{text}'")
print(f"Strip: '{text.strip()}'")
print(f"Lstrip: '{text.lstrip()}'")
print(f"Rstrip: '{text.rstrip()}'")
print()

# 3. Splitting and Joining
print("3. SPLITTING AND JOINING")
print("-" * 60)
text = "apple,banana,cherry"
fruits = text.split(",")
print(f"Split: {fruits}")
joined = " | ".join(fruits)
print(f"Joined: {joined}")

text = "hello world python"
words = text.split()
print(f"Split (default): {words}")
print()

# 4. String Searching
print("4. STRING SEARCHING")
print("-" * 60)
text = "hello world hello"
print(f"Text: {text}")
print(f"Find 'world': {text.find('world')}")
print(f"Find 'hello': {text.find('hello')}")
print(f"Rfind 'hello': {text.rfind('hello')}")
print(f"Count 'l': {text.count('l')}")
print(f"Count 'hello': {text.count('hello')}")
print(f"Starts with 'hello': {text.startswith('hello')}")
print(f"Ends with 'hello': {text.endswith('hello')}")
print()

# 5. String Replacement
print("5. STRING REPLACEMENT")
print("-" * 60)
text = "hello world hello"
print(f"Original: {text}")
print(f"Replace 'hello' with 'hi': {text.replace('hello', 'hi')}")
print(f"Replace first only: {text.replace('hello', 'hi', 1)}")
print()

# 6. String Validation
print("6. STRING VALIDATION")
print("-" * 60)
test_strings = ["Hello", "123", "Hello123", "Hello 123", "   ", "HELLO", "hello"]
for s in test_strings:
    print(f"'{s}':")
    print(f"  isalpha: {s.isalpha()}")
    print(f"  isdigit: {s.isdigit()}")
    print(f"  isalnum: {s.isalnum()}")
    print(f"  isspace: {s.isspace()}")
    print(f"  isupper: {s.isupper()}")
    print(f"  islower: {s.islower()}")
print()

# 7. String Formatting - f-strings
print("7. F-STRING FORMATTING")
print("-" * 60)
name = "Alice"
age = 30
score = 95.5
print(f"Name: {name}, Age: {age}, Score: {score}")
print(f"Score: {score:.2f}")
print(f"Age: {age:05d}")
print(f"Name: {name:>10}")
print(f"Name: {name:<10}")
print(f"Name: {name:^10}")
print()

# 8. String Formatting - format()
print("8. FORMAT METHOD")
print("-" * 60)
name = "Bob"
age = 25
message = "Hello, {}! You are {} years old.".format(name, age)
print(message)
message = "Hello, {name}! You are {age} years old.".format(name=name, age=age)
print(message)
print()

# 9. Alignment and Padding
print("9. ALIGNMENT AND PADDING")
print("-" * 60)
text = "hello"
print(f"Center: '{text.center(10)}'")
print(f"Center with *: '{text.center(10, '*')}'")
print(f"Left justify: '{text.ljust(10)}'")
print(f"Right justify: '{text.rjust(10)}'")
print(f"Zero fill: '{'42'.zfill(5)}'")
print()

# 10. Partition
print("10. PARTITION")
print("-" * 60)
text = "hello world python"
result = text.partition(" ")
print(f"Partition: {result}")
result = text.rpartition(" ")
print(f"Rpartition: {result}")

email = "user@example.com"
local, sep, domain = email.partition("@")
print(f"Email: {email}")
print(f"Local: {local}, Domain: {domain}")
print()

# 11. Method Chaining
print("11. METHOD CHAINING")
print("-" * 60)
text = "  HELLO WORLD  "
result = text.strip().lower().title()
print(f"Original: '{text}'")
print(f"Chained: '{result}'")

user_input = "  john doe  "
normalized = user_input.strip().title()
print(f"User input: '{user_input}'")
print(f"Normalized: '{normalized}'")
print()

# 12. Practical: Text Cleaning
print("12. TEXT CLEANING FUNCTION")
print("-" * 60)
def clean_text(text):
    """Clean and normalize text."""
    # Remove extra whitespace
    text = " ".join(text.split())
    # Convert to title case
    text = text.title()
    return text

dirty_text = "  hello   world   python  "
cleaned = clean_text(dirty_text)
print(f"Dirty: '{dirty_text}'")
print(f"Cleaned: '{cleaned}'")
print()

# 13. Practical: Email Validation
print("13. EMAIL VALIDATION")
print("-" * 60)
def is_valid_email(email):
    """Basic email validation."""
    email = email.strip().lower()
    if "@" not in email or "." not in email:
        return False
    local, domain = email.split("@", 1)
    return bool(local and domain and " " not in email)

emails = ["user@example.com", "invalid", "test@domain", "  USER@EXAMPLE.COM  "]
for email in emails:
    valid = is_valid_email(email)
    print(f"'{email}': {valid}")
print()

# 14. Practical: CSV Parsing
print("14. CSV PARSING")
print("-" * 60)
def parse_csv_line(line):
    """Parse a CSV line into fields."""
    line = line.strip()
    if not line:
        return []
    return [field.strip() for field in line.split(",")]

csv_lines = [
    "name, age, city",
    "Alice, 30, New York",
    "Bob, 25, London"
]

for line in csv_lines:
    fields = parse_csv_line(line)
    print(f"Line: {line}")
    print(f"Fields: {fields}")
print()

# 15. Practical: Text Statistics
print("15. TEXT STATISTICS")
print("-" * 60)
def text_statistics(text):
    """Calculate text statistics."""
    words = text.split()
    chars = len(text)
    chars_no_spaces = len(text.replace(" ", ""))
    avg_word_length = sum(len(w) for w in words) / len(words) if words else 0
    
    return {
        "words": len(words),
        "characters": chars,
        "characters_no_spaces": chars_no_spaces,
        "average_word_length": round(avg_word_length, 2)
    }

text = "Hello world Python programming"
stats = text_statistics(text)
print(f"Text: '{text}'")
for key, value in stats.items():
    print(f"  {key}: {value}")
print()

# 16. Formatting Examples
print("16. FORMATTING EXAMPLES")
print("-" * 60)
# Currency
price = 19.99
print(f"Price: ${price:.2f}")

# Percentage
ratio = 0.75
print(f"Progress: {ratio:.1%}")

# Date formatting
year, month, day = 2024, 3, 15
print(f"Date: {year:04d}-{month:02d}-{day:02d}")

# Table formatting
data = [
    ("Alice", 30, 95.5),
    ("Bob", 25, 87.3),
    ("Charlie", 35, 92.1)
]

print("\nName       | Age | Score")
print("-" * 25)
for name, age, score in data:
    print(f"{name:10} | {age:3} | {score:5.1f}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
STRING MANIPULATION PRACTICE
============================================================

1. CASE CONVERSION
------------------------------------------------------------
Original: hello world python
Upper: HELLO WORLD PYTHON
Lower: hello world python
Title: Hello World Python
Capitalize: Hello world python
Swapcase: HELLO WORLD PYTHON

[... rest of output ...]
```

**Challenge** (Optional):
- Build a text analyzer that counts words, sentences, paragraphs
- Create a password generator with validation
- Build a simple markdown parser
- Implement a text search and replace tool
- Create a CSV to JSON converter

---

## Key Takeaways

1. **Strings are immutable** - methods return new strings
2. **Case methods**: `upper()`, `lower()`, `title()`, `capitalize()`, `swapcase()`
3. **Whitespace methods**: `strip()`, `lstrip()`, `rstrip()`
4. **Split/Join**: `split()`, `splitlines()`, `join()`
5. **Search methods**: `find()`, `index()`, `count()`, `startswith()`, `endswith()`
6. **Replacement**: `replace()` for finding and replacing text
7. **Validation**: `isalpha()`, `isdigit()`, `isalnum()`, `isspace()`, etc.
8. **Formatting**: f-strings (preferred), `format()`, old `%` style
9. **Alignment**: `center()`, `ljust()`, `rjust()`, `zfill()`
10. **Method chaining** allows multiple operations in sequence
11. **Always normalize user input** with `strip()` and appropriate case conversion
12. **f-strings are the modern way** to format strings (Python 3.6+)

---

## Quiz: String Methods

Test your understanding with these questions:

1. **What does `"hello".upper()` return?**
   - A) `"hello"`
   - B) `"HELLO"`
   - C) `"Hello"`
   - D) Error

2. **What does `"  hello  ".strip()` return?**
   - A) `"  hello  "`
   - B) `"hello"`
   - C) `"hello  "`
   - D) `"  hello"`

3. **What does `"a,b,c".split(",")` return?**
   - A) `"a b c"`
   - B) `["a", "b", "c"]`
   - C) `("a", "b", "c")`
   - D) Error

4. **What does `", ".join(["a", "b", "c"])` return?**
   - A) `"a,b,c"`
   - B) `"a, b, c"`
   - C) `["a", "b", "c"]`
   - D) Error

5. **What does `"hello".find("x")` return?**
   - A) `0`
   - B) `-1`
   - C) `None`
   - D) Error

6. **What is the preferred string formatting method in Python 3.6+?**
   - A) `%` formatting
   - B) `format()` method
   - C) f-strings
   - D) All are equal

7. **What does `"hello".replace("l", "L", 1)` return?**
   - A) `"heLLo"`
   - B) `"heLlo"`
   - C) `"heLLo"`
   - D) `"hello"`

8. **What does `"123".isdigit()` return?**
   - A) `True`
   - B) `False`
   - C) `"123"`
   - D) Error

9. **What does `f"{3.14159:.2f}"` return?**
   - A) `"3.14"`
   - B) `"3.14159"`
   - C) `"3"`
   - D) Error

10. **Are strings mutable in Python?**
    - A) Yes
    - B) No
    - C) Sometimes
    - D) Depends on version

**Answers**:
1. B) `"HELLO"` (upper() converts to uppercase)
2. B) `"hello"` (strip() removes leading and trailing whitespace)
3. B) `["a", "b", "c"]` (split() returns a list)
4. B) `"a, b, c"` (join() combines list elements with separator)
5. B) `-1` (find() returns -1 when substring not found)
6. C) f-strings (preferred in Python 3.6+, most readable)
7. B) `"heLlo"` (replace first occurrence only due to count=1)
8. A) `True` (isdigit() returns True for numeric strings)
9. A) `"3.14"` (f-string format specifier .2f rounds to 2 decimal places)
10. B) No (strings are immutable - cannot be changed in place)

---

## Next Steps

Excellent work! You've mastered string methods. You now understand:
- How to manipulate strings with built-in methods
- String formatting with f-strings and format()
- Searching and replacing text
- Validating string properties
- Best practices for string handling

**What's Next?**
- Lesson 7.2: Regular Expressions
- Practice with more complex string operations
- Learn about text processing libraries
- Explore string encoding and Unicode

---

## Additional Resources

- **String Methods**: [docs.python.org/3/library/stdtypes.html#string-methods](https://docs.python.org/3/library/stdtypes.html#string-methods)
- **Format String Syntax**: [docs.python.org/3/library/string.html#format-string-syntax](https://docs.python.org/3/library/string.html#format-string-syntax)
- **f-string Documentation**: [docs.python.org/3/reference/lexical_analysis.html#f-strings](https://docs.python.org/3/reference/lexical_analysis.html#f-strings)

---

*Lesson completed! You're ready to move on to the next lesson.*

