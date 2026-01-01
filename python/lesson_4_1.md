# Lesson 4.1: Dictionaries

## Learning Objectives

By the end of this lesson, you will be able to:
- Create dictionaries in Python
- Access and modify dictionary values
- Understand dictionary keys and their requirements
- Use common dictionary methods
- Iterate over dictionaries
- Work with nested dictionaries
- Apply dictionaries in practical programming scenarios
- Understand dictionary comprehensions

---

## Introduction to Dictionaries

A **dictionary** (dict) is an unordered, mutable collection of key-value pairs in Python. Dictionaries are also known as associative arrays, hash maps, or hash tables in other programming languages. They provide an efficient way to store and retrieve data by key rather than by index.

### Key Characteristics of Dictionaries

1. **Unordered**: Items don't have a defined order (Python 3.7+ maintains insertion order)
2. **Mutable**: Can be modified after creation
3. **Key-Value Pairs**: Each item consists of a key and its associated value
4. **Keys Must Be Unique**: No duplicate keys allowed
5. **Keys Must Be Hashable**: Keys must be immutable (strings, numbers, tuples)
6. **Fast Lookup**: O(1) average time complexity for access

---

## Creating Dictionaries

### Basic Dictionary Creation

**Method 1: Using curly braces `{}`**:
```python
# Empty dictionary
empty_dict = {}
print(empty_dict)  # Output: {}

# Dictionary with key-value pairs
student = {
    "name": "Alice",
    "age": 25,
    "gpa": 3.8
}
print(student)  # Output: {'name': 'Alice', 'age': 25, 'gpa': 3.8}
```

**Method 2: Using the `dict()` constructor**:
```python
# From keyword arguments
student = dict(name="Alice", age=25, gpa=3.8)
print(student)  # Output: {'name': 'Alice', 'age': 25, 'gpa': 3.8}

# From list of tuples
pairs = [("name", "Alice"), ("age", 25), ("gpa", 3.8)]
student = dict(pairs)
print(student)  # Output: {'name': 'Alice', 'age': 25, 'gpa': 3.8}

# Empty dictionary
empty = dict()
print(empty)  # Output: {}
```

**Method 3: Dictionary comprehension** (covered later):
```python
# Squares dictionary
squares = {x: x**2 for x in range(5)}
print(squares)  # Output: {0: 0, 1: 1, 2: 4, 3: 9, 4: 16}
```

### Dictionary Examples

```python
# Student information
student = {
    "name": "Alice",
    "age": 25,
    "gpa": 3.8,
    "courses": ["Math", "Science", "English"]
}

# Phone book
phonebook = {
    "Alice": "555-1234",
    "Bob": "555-5678",
    "Charlie": "555-9012"
}

# Configuration
config = {
    "host": "localhost",
    "port": 8080,
    "debug": True
}

# Mixed types
mixed = {
    "string": "hello",
    "number": 42,
    "float": 3.14,
    "boolean": True,
    "list": [1, 2, 3],
    "nested": {"key": "value"}
}
```

---

## Accessing Dictionary Values

### Using Square Brackets `[]`

```python
student = {
    "name": "Alice",
    "age": 25,
    "gpa": 3.8
}

# Access by key
print(student["name"])  # Output: Alice
print(student["age"])   # Output: 25

# KeyError if key doesn't exist
# print(student["email"])  # KeyError: 'email'
```

### Using `.get()` Method (Safe Access)

```python
student = {
    "name": "Alice",
    "age": 25
}

# Returns value if key exists
print(student.get("name"))      # Output: Alice

# Returns None if key doesn't exist (no error)
print(student.get("email"))     # Output: None

# Returns default value if key doesn't exist
print(student.get("email", "N/A"))  # Output: N/A
```

### Checking Key Existence

```python
student = {
    "name": "Alice",
    "age": 25
}

# Using 'in' operator
if "name" in student:
    print("Name exists")

if "email" not in student:
    print("Email does not exist")

# Using .get() with None check
if student.get("email") is None:
    print("Email not found")
```

---

## Modifying Dictionaries

### Adding and Updating Values

```python
student = {
    "name": "Alice",
    "age": 25
}

# Add new key-value pair
student["gpa"] = 3.8
print(student)  # Output: {'name': 'Alice', 'age': 25, 'gpa': 3.8}

# Update existing value
student["age"] = 26
print(student)  # Output: {'name': 'Alice', 'age': 26, 'gpa': 3.8}

# Update multiple values
student.update({"age": 27, "city": "NYC"})
print(student)  # Output: {'name': 'Alice', 'age': 27, 'gpa': 3.8, 'city': 'NYC'}
```

### Removing Items

**1. `del` statement**:
```python
student = {"name": "Alice", "age": 25, "gpa": 3.8}
del student["age"]
print(student)  # Output: {'name': 'Alice', 'gpa': 3.8}

# Error if key doesn't exist
# del student["email"]  # KeyError: 'email'
```

**2. `.pop(key)`** - Removes and returns value:
```python
student = {"name": "Alice", "age": 25, "gpa": 3.8}
age = student.pop("age")
print(age)      # Output: 25
print(student)  # Output: {'name': 'Alice', 'gpa': 3.8}

# With default value (no error if key doesn't exist)
email = student.pop("email", None)
print(email)  # Output: None
```

**3. `.popitem()`** - Removes and returns last item (Python 3.7+):
```python
student = {"name": "Alice", "age": 25, "gpa": 3.8}
item = student.popitem()
print(item)     # Output: ('gpa', 3.8)
print(student)  # Output: {'name': 'Alice', 'age': 25}
```

**4. `.clear()`** - Removes all items:
```python
student = {"name": "Alice", "age": 25}
student.clear()
print(student)  # Output: {}
```

---

## Dictionary Keys

### Key Requirements

1. **Must be hashable** (immutable):
   - Strings, numbers, tuples (with hashable elements) are allowed
   - Lists, dictionaries, sets are NOT allowed

2. **Must be unique**:
   - Duplicate keys overwrite previous values

```python
# Valid keys
valid_dict = {
    "string": "value1",
    42: "value2",
    3.14: "value3",
    (1, 2): "value4",
    True: "value5"
}

# Invalid keys
# invalid_dict = {
#     [1, 2]: "value"  # TypeError: unhashable type: 'list'
#     {"key": "value"}: "value"  # TypeError: unhashable type: 'dict'
# }
```

### Duplicate Keys

```python
# Last value wins
student = {
    "name": "Alice",
    "name": "Bob"  # Overwrites "Alice"
}
print(student)  # Output: {'name': 'Bob'}
```

---

## Dictionary Methods

### Common Methods

**1. `.keys()`** - Returns view of all keys:
```python
student = {"name": "Alice", "age": 25, "gpa": 3.8}
keys = student.keys()
print(keys)        # Output: dict_keys(['name', 'age', 'gpa'])
print(list(keys))  # Output: ['name', 'age', 'gpa']

# Iterate over keys
for key in student.keys():
    print(key)
```

**2. `.values()`** - Returns view of all values:
```python
student = {"name": "Alice", "age": 25, "gpa": 3.8}
values = student.values()
print(values)        # Output: dict_values(['Alice', 25, 3.8])
print(list(values))  # Output: ['Alice', 25, 3.8]

# Iterate over values
for value in student.values():
    print(value)
```

**3. `.items()`** - Returns view of all key-value pairs:
```python
student = {"name": "Alice", "age": 25, "gpa": 3.8}
items = student.items()
print(items)  # Output: dict_items([('name', 'Alice'), ('age', 25), ('gpa', 3.8)])

# Iterate over items
for key, value in student.items():
    print(f"{key}: {value}")
```

**4. `.copy()`** - Creates shallow copy:
```python
original = {"name": "Alice", "age": 25}
copy = original.copy()
copy["age"] = 26
print(original)  # Output: {'name': 'Alice', 'age': 25}
print(copy)      # Output: {'name': 'Alice', 'age': 26}
```

**5. `.update(other_dict)`** - Updates dictionary with another:
```python
student = {"name": "Alice", "age": 25}
student.update({"age": 26, "gpa": 3.8})
print(student)  # Output: {'name': 'Alice', 'age': 26, 'gpa': 3.8}
```

**6. `.setdefault(key, default)`** - Returns value if key exists, else sets default:
```python
student = {"name": "Alice", "age": 25}

# Key exists - returns value
age = student.setdefault("age", 0)
print(age)  # Output: 25

# Key doesn't exist - sets and returns default
gpa = student.setdefault("gpa", 0.0)
print(gpa)  # Output: 0.0
print(student)  # Output: {'name': 'Alice', 'age': 25, 'gpa': 0.0}
```

---

## Iterating Over Dictionaries

### Iterating Over Keys

```python
student = {"name": "Alice", "age": 25, "gpa": 3.8}

# Method 1: Direct iteration (default is keys)
for key in student:
    print(key)
# Output:
# name
# age
# gpa

# Method 2: Explicit .keys()
for key in student.keys():
    print(key)
```

### Iterating Over Values

```python
student = {"name": "Alice", "age": 25, "gpa": 3.8}

for value in student.values():
    print(value)
# Output:
# Alice
# 25
# 3.8
```

### Iterating Over Items (Key-Value Pairs)

```python
student = {"name": "Alice", "age": 25, "gpa": 3.8}

# Method 1: Using .items()
for key, value in student.items():
    print(f"{key}: {value}")
# Output:
# name: Alice
# age: 25
# gpa: 3.8

# Method 2: Using enumerate (if you need index)
for i, (key, value) in enumerate(student.items()):
    print(f"{i}: {key} = {value}")
```

---

## Dictionary Comprehensions

Dictionary comprehensions provide a concise way to create dictionaries.

### Basic Syntax

```python
# Traditional way
squares = {}
for x in range(5):
    squares[x] = x**2
print(squares)  # Output: {0: 0, 1: 1, 2: 4, 3: 9, 4: 16}

# Dictionary comprehension
squares = {x: x**2 for x in range(5)}
print(squares)  # Output: {0: 0, 1: 1, 2: 4, 3: 9, 4: 16}
```

### Examples

```python
# Squares
squares = {x: x**2 for x in range(1, 6)}
print(squares)  # Output: {1: 1, 2: 4, 3: 9, 4: 16, 5: 25}

# Uppercase keys
words = ["hello", "world", "python"]
upper_dict = {word: word.upper() for word in words}
print(upper_dict)  # Output: {'hello': 'HELLO', 'world': 'WORLD', 'python': 'PYTHON'}

# With condition
even_squares = {x: x**2 for x in range(10) if x % 2 == 0}
print(even_squares)  # Output: {0: 0, 2: 4, 4: 16, 6: 36, 8: 64}

# From two lists
keys = ["a", "b", "c"]
values = [1, 2, 3]
combined = {k: v for k, v in zip(keys, values)}
print(combined)  # Output: {'a': 1, 'b': 2, 'c': 3}
```

---

## Nested Dictionaries

Dictionaries can contain other dictionaries, creating nested structures.

### Creating Nested Dictionaries

```python
# Nested dictionary
students = {
    "Alice": {
        "age": 25,
        "gpa": 3.8,
        "courses": ["Math", "Science"]
    },
    "Bob": {
        "age": 23,
        "gpa": 3.5,
        "courses": ["English", "History"]
    }
}
```

### Accessing Nested Values

```python
students = {
    "Alice": {
        "age": 25,
        "gpa": 3.8
    }
}

# Access nested value
print(students["Alice"]["age"])  # Output: 25

# Safe access with .get()
age = students.get("Alice", {}).get("age", 0)
print(age)  # Output: 25
```

### Modifying Nested Dictionaries

```python
students = {
    "Alice": {
        "age": 25,
        "gpa": 3.8
    }
}

# Modify nested value
students["Alice"]["age"] = 26

# Add new nested key
students["Alice"]["city"] = "NYC"

# Add new student
students["Charlie"] = {"age": 24, "gpa": 3.9}
```

---

## Common Dictionary Operations

### Length

```python
student = {"name": "Alice", "age": 25, "gpa": 3.8}
length = len(student)
print(length)  # Output: 3
```

### Membership Testing

```python
student = {"name": "Alice", "age": 25}

# Check if key exists
print("name" in student)      # Output: True
print("email" in student)      # Output: False
print("Alice" in student)      # Output: False (checks keys, not values!)

# Check if value exists
print("Alice" in student.values())  # Output: True
```

### Combining Dictionaries

```python
# Using update()
dict1 = {"a": 1, "b": 2}
dict2 = {"c": 3, "d": 4}
dict1.update(dict2)
print(dict1)  # Output: {'a': 1, 'b': 2, 'c': 3, 'd': 4}

# Using ** unpacking (Python 3.5+)
dict1 = {"a": 1, "b": 2}
dict2 = {"c": 3, "d": 4}
combined = {**dict1, **dict2}
print(combined)  # Output: {'a': 1, 'b': 2, 'c': 3, 'd': 4}
```

---

## Practical Examples

### Example 1: Phone Book

```python
phonebook = {
    "Alice": "555-1234",
    "Bob": "555-5678",
    "Charlie": "555-9012"
}

# Lookup
name = "Alice"
if name in phonebook:
    print(f"{name}'s number: {phonebook[name]}")

# Add contact
phonebook["Diana"] = "555-3456"

# Remove contact
del phonebook["Bob"]
```

### Example 2: Word Counter

```python
text = "hello world hello python world"
words = text.split()

# Count word occurrences
word_count = {}
for word in words:
    word_count[word] = word_count.get(word, 0) + 1

print(word_count)  # Output: {'hello': 2, 'world': 2, 'python': 1}

# Using Counter (from collections module - advanced)
from collections import Counter
word_count = Counter(words)
print(word_count)  # Output: Counter({'hello': 2, 'world': 2, 'python': 1})
```

### Example 3: Student Grades

```python
grades = {
    "Alice": [85, 92, 78],
    "Bob": [90, 88, 95],
    "Charlie": [75, 80, 85]
}

# Calculate averages
averages = {}
for name, scores in grades.items():
    averages[name] = sum(scores) / len(scores)

print(averages)  # Output: {'Alice': 85.0, 'Bob': 91.0, 'Charlie': 80.0}
```

### Example 4: Configuration

```python
config = {
    "database": {
        "host": "localhost",
        "port": 5432,
        "name": "mydb"
    },
    "api": {
        "key": "secret_key",
        "timeout": 30
    }
}

# Access nested config
db_host = config["database"]["host"]
api_timeout = config.get("api", {}).get("timeout", 60)
```

---

## Common Mistakes and Pitfalls

### 1. KeyError When Key Doesn't Exist

```python
student = {"name": "Alice"}
# print(student["age"])  # KeyError!

# Solution: Use .get()
age = student.get("age", 0)  # Returns 0 if key doesn't exist
```

### 2. Confusing Keys and Values

```python
student = {"name": "Alice", "age": 25}
# "Alice" in student  # False! (checks keys, not values)
"Alice" in student.values()  # True
```

### 3. Using Mutable Types as Keys

```python
# Wrong
# invalid = {[1, 2]: "value"}  # TypeError!

# Correct
valid = {(1, 2): "value"}  # Tuples are hashable
```

### 4. Modifying Dictionary While Iterating

```python
# Dangerous: Modifying while iterating
student = {"name": "Alice", "age": 25}
# for key in student:
#     if key == "age":
#         del student[key]  # RuntimeError!

# Solution: Iterate over copy
for key in list(student.keys()):
    if key == "age":
        del student[key]
```

### 5. Shallow Copy Issues with Nested Dictionaries

```python
import copy

original = {"nested": {"value": 1}}
shallow = original.copy()
shallow["nested"]["value"] = 2
print(original)  # Output: {'nested': {'value': 2}} (also changed!)

# Use deep copy
deep = copy.deepcopy(original)
deep["nested"]["value"] = 3
print(original)  # Output: {'nested': {'value': 2}} (unchanged)
```

---

## Practice Exercise

### Exercise: Dictionary Manipulation

**Objective**: Create a Python program that demonstrates various dictionary operations and use cases.

**Instructions**:

1. Create a file called `dictionary_practice.py`

2. Write a program that:
   - Creates dictionaries in different ways
   - Accesses and modifies dictionary values
   - Uses dictionary methods
   - Implements practical dictionary-based solutions
   - Works with nested dictionaries

3. Your program should include:
   - Student management system
   - Word counter
   - Phone book
   - Configuration management
   - Dictionary operations

**Example Solution**:

```python
"""
Dictionary Manipulation Practice
This program demonstrates various dictionary operations and use cases.
"""

print("=" * 60)
print("DICTIONARY MANIPULATION PRACTICE")
print("=" * 60)
print()

# 1. Creating Dictionaries
print("1. CREATING DICTIONARIES")
print("-" * 60)
# Empty dictionary
empty = {}
print(f"Empty: {empty}")

# Dictionary with key-value pairs
student = {
    "name": "Alice",
    "age": 25,
    "gpa": 3.8
}
print(f"Student: {student}")

# Using dict() constructor
student2 = dict(name="Bob", age=23, gpa=3.5)
print(f"Student 2: {student2}")

# From list of tuples
pairs = [("name", "Charlie"), ("age", 24), ("gpa", 3.9)]
student3 = dict(pairs)
print(f"Student 3: {student3}")
print()

# 2. Accessing Values
print("2. ACCESSING VALUES")
print("-" * 60)
student = {"name": "Alice", "age": 25, "gpa": 3.8}

# Square brackets
print(f"Name: {student['name']}")
print(f"Age: {student['age']}")

# .get() method (safe)
print(f"GPA: {student.get('gpa')}")
print(f"Email: {student.get('email', 'N/A')}")

# Check existence
print(f"'name' in student: {'name' in student}")
print(f"'email' in student: {'email' in student}")
print()

# 3. Modifying Dictionaries
print("3. MODIFYING DICTIONARIES")
print("-" * 60)
student = {"name": "Alice", "age": 25}
print(f"Original: {student}")

# Add/update
student["gpa"] = 3.8
print(f"After adding gpa: {student}")

student["age"] = 26
print(f"After updating age: {student}")

# Update multiple
student.update({"city": "NYC", "country": "USA"})
print(f"After update(): {student}")

# Remove
del student["country"]
print(f"After deleting country: {student}")

removed = student.pop("city", None)
print(f"Popped city: {removed}")
print(f"After pop(): {student}")
print()

# 4. Dictionary Methods
print("4. DICTIONARY METHODS")
print("-" * 60)
student = {"name": "Alice", "age": 25, "gpa": 3.8}

print(f"Keys: {list(student.keys())}")
print(f"Values: {list(student.values())}")
print(f"Items: {list(student.items())}")
print(f"Length: {len(student)}")

# Copy
copy = student.copy()
copy["age"] = 26
print(f"Original: {student}")
print(f"Copy: {copy}")

# Setdefault
gpa = student.setdefault("gpa", 0.0)
print(f"setdefault('gpa'): {gpa}")

email = student.setdefault("email", "unknown")
print(f"setdefault('email'): {email}")
print(f"After setdefault: {student}")
print()

# 5. Iterating Over Dictionaries
print("5. ITERATING OVER DICTIONARIES")
print("-" * 60)
student = {"name": "Alice", "age": 25, "gpa": 3.8}

print("Keys:")
for key in student:
    print(f"  {key}")

print("\nValues:")
for value in student.values():
    print(f"  {value}")

print("\nItems:")
for key, value in student.items():
    print(f"  {key}: {value}")
print()

# 6. Dictionary Comprehensions
print("6. DICTIONARY COMPREHENSIONS")
print("-" * 60)
# Squares
squares = {x: x**2 for x in range(1, 6)}
print(f"Squares: {squares}")

# Uppercase
words = ["hello", "world", "python"]
upper_dict = {word: word.upper() for word in words}
print(f"Uppercase: {upper_dict}")

# With condition
even_squares = {x: x**2 for x in range(10) if x % 2 == 0}
print(f"Even squares: {even_squares}")
print()

# 7. Phone Book
print("7. PHONE BOOK")
print("-" * 60)
phonebook = {
    "Alice": "555-1234",
    "Bob": "555-5678",
    "Charlie": "555-9012"
}

print("Phone Book:")
for name, number in phonebook.items():
    print(f"  {name}: {number}")

# Lookup
name = "Alice"
if name in phonebook:
    print(f"\n{name}'s number: {phonebook[name]}")

# Add contact
phonebook["Diana"] = "555-3456"
print(f"\nAfter adding Diana: {phonebook}")
print()

# 8. Word Counter
print("8. WORD COUNTER")
print("-" * 60)
text = "hello world hello python world python"
words = text.split()

# Count words
word_count = {}
for word in words:
    word_count[word] = word_count.get(word, 0) + 1

print("Word counts:")
for word, count in word_count.items():
    print(f"  {word}: {count}")
print()

# 9. Student Grades
print("9. STUDENT GRADES")
print("-" * 60)
grades = {
    "Alice": [85, 92, 78],
    "Bob": [90, 88, 95],
    "Charlie": [75, 80, 85]
}

# Calculate averages
averages = {}
for name, scores in grades.items():
    avg = sum(scores) / len(scores)
    averages[name] = avg
    print(f"{name}: {scores} → Average: {avg:.1f}")

print(f"\nAll averages: {averages}")
print()

# 10. Nested Dictionaries
print("10. NESTED DICTIONARIES")
print("-" * 60)
students = {
    "Alice": {
        "age": 25,
        "gpa": 3.8,
        "courses": ["Math", "Science"]
    },
    "Bob": {
        "age": 23,
        "gpa": 3.5,
        "courses": ["English", "History"]
    }
}

print("Student Details:")
for name, info in students.items():
    print(f"  {name}:")
    print(f"    Age: {info['age']}")
    print(f"    GPA: {info['gpa']}")
    print(f"    Courses: {info['courses']}")

# Modify nested
students["Alice"]["age"] = 26
students["Alice"]["courses"].append("Art")
print(f"\nAfter modifying Alice:")
print(f"  Age: {students['Alice']['age']}")
print(f"  Courses: {students['Alice']['courses']}")
print()

# 11. Configuration Management
print("11. CONFIGURATION MANAGEMENT")
print("-" * 60)
config = {
    "database": {
        "host": "localhost",
        "port": 5432,
        "name": "mydb"
    },
    "api": {
        "key": "secret_key",
        "timeout": 30
    }
}

# Access nested config
db_host = config["database"]["host"]
db_port = config["database"]["port"]
api_timeout = config.get("api", {}).get("timeout", 60)

print(f"Database: {db_host}:{db_port}")
print(f"API timeout: {api_timeout} seconds")
print()

# 12. Dictionary Operations
print("12. DICTIONARY OPERATIONS")
print("-" * 60)
dict1 = {"a": 1, "b": 2}
dict2 = {"c": 3, "d": 4}

# Combine using update
dict1_copy = dict1.copy()
dict1_copy.update(dict2)
print(f"Combined (update): {dict1_copy}")

# Combine using ** unpacking
combined = {**dict1, **dict2}
print(f"Combined (**): {combined}")

# Membership
print(f"'a' in dict1: {'a' in dict1}")
print(f"1 in dict1.values(): {1 in dict1.values()}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
DICTIONARY MANIPULATION PRACTICE
============================================================

1. CREATING DICTIONARIES
------------------------------------------------------------
Empty: {}
Student: {'name': 'Alice', 'age': 25, 'gpa': 3.8}
Student 2: {'name': 'Bob', 'age': 23, 'gpa': 3.5}
Student 3: {'name': 'Charlie', 'age': 24, 'gpa': 3.9}

[... rest of output ...]
```

**Challenge** (Optional):
- Create a more complex student management system
- Build a complete inventory system
- Implement a caching mechanism
- Create a configuration parser
- Build a data transformation tool

---

## Key Takeaways

1. **Dictionaries store key-value pairs** and provide fast O(1) lookup
2. **Keys must be hashable** (immutable: strings, numbers, tuples)
3. **Use `[]` for access** or `.get()` for safe access with defaults
4. **Dictionary methods**: `.keys()`, `.values()`, `.items()`, `.get()`, `.pop()`, `.update()`
5. **Dictionary comprehensions** provide concise dictionary creation
6. **Nested dictionaries** allow complex data structures
7. **Iterate with `.items()`** to get both keys and values
8. **Use `.get()`** to avoid KeyError when key might not exist
9. **Dictionaries are mutable** - can add, modify, and remove items
10. **Dictionaries are unordered** (but Python 3.7+ maintains insertion order)

---

## Quiz: Dictionaries

Test your understanding with these questions:

1. **How do you access a value in a dictionary?**
   - A) `dict.value(key)`
   - B) `dict[key]`
   - C) `dict.get(key)`
   - D) Both B and C

2. **What happens if you try to access a non-existent key with `dict[key]`?**
   - A) Returns `None`
   - B) Returns empty string
   - C) Raises `KeyError`
   - D) Creates the key

3. **Which of these can be a dictionary key?**
   - A) List
   - B) Dictionary
   - C) Tuple
   - D) Set

4. **What does `dict.get(key, default)` do?**
   - A) Gets value or returns default if key doesn't exist
   - B) Gets value or creates key with default
   - C) Always returns default
   - D) Error

5. **How do you iterate over both keys and values?**
   - A) `for key in dict:`
   - B) `for key, value in dict.items():`
   - C) `for value in dict.values():`
   - D) All of the above

6. **What does `dict.pop(key)` do?**
   - A) Returns value and removes key
   - B) Just removes key
   - C) Just returns value
   - D) Error

7. **Can dictionaries have duplicate keys?**
   - A) Yes
   - B) No
   - C) Only if values are different
   - D) Only in Python 2

8. **What is the result of `{"a": 1, "b": 2}.get("c", 0)`?**
   - A) `None`
   - B) `0`
   - C) `KeyError`
   - D) `"c"`

9. **How do you check if a key exists in a dictionary?**
   - A) `key in dict`
   - B) `dict.has_key(key)`
   - C) `dict.contains(key)`
   - D) All of the above

10. **What does `{x: x**2 for x in range(3)}` create?**
    - A) `{0: 0, 1: 1, 2: 4}`
    - B) `[0, 1, 4]`
    - C) `{0, 1, 4}`
    - D) Error

**Answers**:
1. D) Both B and C (`dict[key]` and `dict.get(key)`)
2. C) Raises `KeyError` (use `.get()` to avoid)
3. C) Tuple (must be hashable/immutable)
4. A) Gets value or returns default if key doesn't exist
5. B) `for key, value in dict.items():` (iterates over key-value pairs)
6. A) Returns value and removes key
7. B) No (duplicate keys overwrite previous values)
8. B) `0` (default value when key doesn't exist)
9. A) `key in dict` (membership operator)
10. A) `{0: 0, 1: 1, 2: 4}` (dictionary comprehension)

---

## Next Steps

Excellent work! You've mastered dictionaries. You now understand:
- How to create and manipulate dictionaries
- Accessing and modifying values
- Dictionary methods and operations
- Dictionary comprehensions
- Nested dictionaries
- Practical applications

**What's Next?**
- Lesson 4.2: Sets
- Practice building more dictionary-based programs
- Learn about advanced dictionary operations
- Explore real-world dictionary applications

---

## Additional Resources

- **Python Dictionaries**: [docs.python.org/3/tutorial/datastructures.html#dictionaries](https://docs.python.org/3/tutorial/datastructures.html#dictionaries)
- **Dictionary Methods**: [docs.python.org/3/library/stdtypes.html#dict](https://docs.python.org/3/library/stdtypes.html#dict)
- **Dictionary Comprehensions**: [docs.python.org/3/tutorial/datastructures.html#dictionaries](https://docs.python.org/3/tutorial/datastructures.html#dictionaries)

---

*Lesson completed! You're ready to move on to the next lesson.*

