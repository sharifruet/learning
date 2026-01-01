# Lesson 3.2: Tuples

## Learning Objectives

By the end of this lesson, you will be able to:
- Create tuples in Python
- Understand the difference between tuples and lists
- Use tuple unpacking effectively
- Understand tuple immutability and its implications
- Access tuple elements using indexing and slicing
- Work with tuple methods and operations
- Apply tuples in practical programming scenarios
- Know when to use tuples vs lists

---

## Introduction to Tuples

A **tuple** is an ordered, immutable collection of items in Python. Like lists, tuples can contain any type of data, but unlike lists, tuples cannot be modified after creation. This immutability makes tuples useful for fixed data, function return values, and dictionary keys.

### Key Characteristics of Tuples

1. **Ordered**: Items maintain their order
2. **Immutable**: Cannot be modified after creation
3. **Indexed**: Access items by position (starting at 0)
4. **Heterogeneous**: Can contain different data types
5. **Hashable**: Can be used as dictionary keys (if all elements are hashable)

---

## Creating Tuples

### Basic Tuple Creation

**Method 1: Using parentheses `()`**:
```python
# Empty tuple
empty_tuple = ()
print(empty_tuple)  # Output: ()

# Tuple with items
numbers = (1, 2, 3, 4, 5)
print(numbers)  # Output: (1, 2, 3, 4, 5)

# Single element tuple (note the comma!)
single = (42,)  # Comma is required!
print(single)   # Output: (42,)
print(type(single))  # <class 'tuple'>

# Without comma, it's not a tuple
not_tuple = (42)
print(type(not_tuple))  # <class 'int'> (not a tuple!)
```

**Method 2: Using the `tuple()` constructor**:
```python
# From a list
numbers = tuple([1, 2, 3, 4, 5])
print(numbers)  # Output: (1, 2, 3, 4, 5)

# From a string (splits into characters)
chars = tuple("hello")
print(chars)  # Output: ('h', 'e', 'l', 'l', 'o')

# From a range
numbers = tuple(range(5))
print(numbers)  # Output: (0, 1, 2, 3, 4)

# Empty tuple
empty = tuple()
print(empty)  # Output: ()
```

**Method 3: Without parentheses (tuple packing)**:
```python
# Python allows creating tuples without parentheses
coordinates = 10, 20, 30
print(coordinates)  # Output: (10, 20, 30)
print(type(coordinates))  # <class 'tuple'>

# This is called "tuple packing"
x, y, z = 1, 2, 3  # Creates tuple (1, 2, 3) and unpacks it
```

### Tuple Examples

```python
# Tuple of strings
fruits = ("apple", "banana", "orange")
print(fruits)

# Tuple of numbers
coordinates = (10, 20)
print(coordinates)

# Mixed types
student = ("Alice", 25, 3.8, True)
print(student)

# Nested tuples
matrix = ((1, 2, 3), (4, 5, 6), (7, 8, 9))
print(matrix)
```

---

## Accessing Tuple Elements

### Indexing

Tuples support the same indexing as lists:

```python
fruits = ("apple", "banana", "orange", "grape", "kiwi")

# Positive indexing (from start)
print(fruits[0])  # Output: apple (first element)
print(fruits[1])  # Output: banana
print(fruits[4])  # Output: kiwi (last element)

# Negative indexing (from end)
print(fruits[-1])  # Output: kiwi (last element)
print(fruits[-2])  # Output: grape (second to last)
print(fruits[-5])  # Output: apple (first element)
```

### Slicing

Tuples support slicing just like lists:

```python
numbers = (0, 1, 2, 3, 4, 5, 6, 7, 8, 9)

# Basic slicing
print(numbers[2:5])    # Output: (2, 3, 4)
print(numbers[:5])     # Output: (0, 1, 2, 3, 4)
print(numbers[5:])     # Output: (5, 6, 7, 8, 9)
print(numbers[:])      # Output: (0, 1, 2, 3, 4, 5, 6, 7, 8, 9)

# Negative indices
print(numbers[-5:])    # Output: (5, 6, 7, 8, 9)

# Step size
print(numbers[::2])    # Output: (0, 2, 4, 6, 8)
print(numbers[::-1])   # Output: (9, 8, 7, 6, 5, 4, 3, 2, 1, 0)
```

---

## Tuple vs List

Understanding when to use tuples vs lists is important:

### Key Differences

| Feature | Tuple | List |
|---------|-------|------|
| **Mutability** | Immutable (cannot change) | Mutable (can change) |
| **Syntax** | `()` parentheses | `[]` square brackets |
| **Performance** | Slightly faster | Slightly slower |
| **Memory** | Less memory | More memory |
| **Hashable** | Yes (if elements are hashable) | No |
| **Use Case** | Fixed data, keys, return values | Dynamic data, modifications |

### When to Use Tuples

1. **Fixed data** that shouldn't change
2. **Dictionary keys** (lists can't be keys)
3. **Function return values** (multiple values)
4. **Coordinates** or fixed pairs/triples
5. **Data integrity** - when you want to prevent accidental modification

### When to Use Lists

1. **Dynamic data** that needs modification
2. **When you need to add/remove items**
3. **When order might change**
4. **When you need list-specific methods**

### Comparison Examples

```python
# Lists - mutable
fruits_list = ["apple", "banana"]
fruits_list.append("orange")  # Can modify
fruits_list[0] = "cherry"      # Can change elements
print(fruits_list)  # Output: ['cherry', 'banana', 'orange']

# Tuples - immutable
fruits_tuple = ("apple", "banana")
# fruits_tuple.append("orange")  # AttributeError!
# fruits_tuple[0] = "cherry"     # TypeError!

# But you can create a new tuple
fruits_tuple = fruits_tuple + ("orange",)
print(fruits_tuple)  # Output: ('apple', 'banana', 'orange')
```

### Performance Comparison

```python
import time

# List creation and access
start = time.time()
my_list = list(range(1000000))
list_time = time.time() - start

# Tuple creation and access
start = time.time()
my_tuple = tuple(range(1000000))
tuple_time = time.time() - start

print(f"List time: {list_time:.6f} seconds")
print(f"Tuple time: {tuple_time:.6f} seconds")
# Tuples are generally slightly faster
```

---

## Tuple Immutability

### What Immutability Means

Once a tuple is created, you cannot:
- Add elements
- Remove elements
- Change elements
- Reorder elements

```python
# Creating a tuple
coordinates = (10, 20)

# These will all cause errors:
# coordinates[0] = 15        # TypeError: 'tuple' object does not support item assignment
# coordinates.append(30)    # AttributeError: 'tuple' object has no attribute 'append'
# coordinates.remove(10)    # AttributeError: 'tuple' object has no attribute 'remove'
```

### Creating New Tuples

To "modify" a tuple, you create a new one:

```python
# Original tuple
numbers = (1, 2, 3)

# Create new tuple with additional element
new_numbers = numbers + (4,)
print(new_numbers)  # Output: (1, 2, 3, 4)
print(numbers)      # Output: (1, 2, 3) (original unchanged)

# Create new tuple by slicing
modified = numbers[:2] + (99,) + numbers[2:]
print(modified)  # Output: (1, 2, 99, 3)
```

### Immutability of Nested Structures

**Important**: Tuple immutability applies to the tuple itself, not necessarily to its contents:

```python
# Tuple containing a mutable list
mixed = (1, 2, [3, 4])
print(mixed)  # Output: (1, 2, [3, 4])

# Cannot change the tuple structure
# mixed[0] = 10  # TypeError!

# But can modify the list inside
mixed[2].append(5)  # This works!
print(mixed)  # Output: (1, 2, [3, 4, 5])

# Cannot reassign the list
# mixed[2] = [6, 7]  # TypeError!
```

---

## Tuple Unpacking

Tuple unpacking is a powerful feature that allows you to assign tuple elements to multiple variables.

### Basic Unpacking

```python
# Packing (creating tuple)
coordinates = (10, 20)

# Unpacking (assigning to variables)
x, y = coordinates
print(x)  # Output: 10
print(y)  # Output: 20

# Multiple values
name, age, city = ("Alice", 25, "NYC")
print(f"{name} is {age} years old and lives in {city}")
# Output: Alice is 25 years old and lives in NYC
```

### Swapping Variables

Tuple unpacking makes swapping elegant:

```python
# Traditional way (needs temp variable)
a = 5
b = 10
temp = a
a = b
b = temp
print(a, b)  # Output: 10 5

# Python way (using tuple unpacking)
a = 5
b = 10
a, b = b, a  # Swap in one line!
print(a, b)  # Output: 10 5
```

### Extended Unpacking

Python 3 allows extended unpacking with `*`:

```python
# Unpacking with *
first, *middle, last = (1, 2, 3, 4, 5)
print(first)   # Output: 1
print(middle)  # Output: [2, 3, 4] (becomes a list)
print(last)    # Output: 5

# Ignoring values with _
x, _, y = (1, 2, 3)
print(x, y)  # Output: 1 3 (ignored the middle value)

# Multiple ignores
first, *_, last = (1, 2, 3, 4, 5, 6, 7)
print(first, last)  # Output: 1 7
```

### Function Return Values

Tuples are commonly used to return multiple values from functions:

```python
def get_name_age():
    return "Alice", 25  # Returns a tuple

# Unpack the return value
name, age = get_name_age()
print(f"{name} is {age} years old")
# Output: Alice is 25 years old

# Or use as tuple
result = get_name_age()
print(result)  # Output: ('Alice', 25)
print(result[0])  # Output: Alice
```

### Practical Unpacking Examples

```python
# Coordinates
point = (3, 4)
x, y = point
distance = (x**2 + y**2)**0.5
print(f"Distance from origin: {distance:.2f}")

# RGB colors
color = (255, 128, 64)
red, green, blue = color
print(f"RGB: R={red}, G={green}, B={blue}")

# Date components
date = (2024, 1, 15)
year, month, day = date
print(f"Date: {year}-{month:02d}-{day:02d}")
```

---

## Tuple Methods and Operations

### Available Methods

Tuples have fewer methods than lists (due to immutability):

**1. `count(item)`** - Returns count of occurrences:
```python
numbers = (1, 2, 3, 2, 4, 2)
count = numbers.count(2)
print(count)  # Output: 3
```

**2. `index(item)`** - Returns index of first occurrence:
```python
fruits = ("apple", "banana", "orange", "banana")
index = fruits.index("banana")
print(index)  # Output: 1

# With start and end
index = fruits.index("banana", 2)  # Search from index 2
print(index)  # Output: 3
```

### Common Operations

**1. Length**:
```python
fruits = ("apple", "banana", "orange")
length = len(fruits)
print(length)  # Output: 3
```

**2. Membership Testing**:
```python
fruits = ("apple", "banana", "orange")
print("apple" in fruits)      # Output: True
print("grape" in fruits)     # Output: False
print("banana" not in fruits)  # Output: False
```

**3. Concatenation**:
```python
tuple1 = (1, 2, 3)
tuple2 = (4, 5, 6)
combined = tuple1 + tuple2
print(combined)  # Output: (1, 2, 3, 4, 5, 6)
```

**4. Repetition**:
```python
repeated = (1, 2) * 3
print(repeated)  # Output: (1, 2, 1, 2, 1, 2)
```

**5. Iteration**:
```python
fruits = ("apple", "banana", "orange")

# Iterate over items
for fruit in fruits:
    print(fruit)
# Output:
# apple
# banana
# orange

# Iterate with index
for index, fruit in enumerate(fruits):
    print(f"{index}: {fruit}")
# Output:
# 0: apple
# 1: banana
# 2: orange
```

**6. Comparison**:
```python
tuple1 = (1, 2, 3)
tuple2 = (1, 2, 4)
tuple3 = (1, 2, 3)

print(tuple1 < tuple2)   # Output: True (lexicographic comparison)
print(tuple1 == tuple3)  # Output: True
print(tuple1 > tuple2)   # Output: False
```

---

## Tuples as Dictionary Keys

Because tuples are immutable (and hashable if all elements are hashable), they can be used as dictionary keys:

```python
# Tuples as keys
coordinates_dict = {
    (0, 0): "origin",
    (1, 1): "diagonal",
    (2, 2): "diagonal"
}

print(coordinates_dict[(0, 0)])  # Output: origin
print(coordinates_dict[(1, 1)])  # Output: diagonal

# Lists cannot be keys (they're mutable)
# invalid_dict = {[1, 2]: "value"}  # TypeError: unhashable type: 'list'

# But tuples containing lists cannot be keys either
# invalid_tuple = ([1, 2], 3)
# invalid_dict = {invalid_tuple: "value"}  # TypeError: unhashable type: 'list'
```

### Practical Example: Coordinate System

```python
# Grid-based game or mapping
grid = {
    (0, 0): "Start",
    (0, 1): "Path",
    (1, 1): "Treasure",
    (2, 2): "End"
}

def get_cell(x, y):
    return grid.get((x, y), "Empty")

print(get_cell(0, 0))  # Output: Start
print(get_cell(5, 5))  # Output: Empty
```

---

## Converting Between Tuples and Lists

You can convert between tuples and lists:

```python
# List to tuple
my_list = [1, 2, 3, 4, 5]
my_tuple = tuple(my_list)
print(my_tuple)  # Output: (1, 2, 3, 4, 5)

# Tuple to list
my_tuple = (1, 2, 3, 4, 5)
my_list = list(my_tuple)
print(my_list)  # Output: [1, 2, 3, 4, 5]

# Why convert?
# To modify a tuple, convert to list, modify, convert back
coordinates = (10, 20)
coords_list = list(coordinates)
coords_list[0] = 15
new_coordinates = tuple(coords_list)
print(new_coordinates)  # Output: (15, 20)
```

---

## Practical Examples

### Example 1: Coordinates

```python
# Point coordinates
point1 = (3, 4)
point2 = (6, 8)

# Calculate distance
def distance(p1, p2):
    x1, y1 = p1
    x2, y2 = p2
    return ((x2 - x1)**2 + (y2 - y1)**2)**0.5

dist = distance(point1, point2)
print(f"Distance: {dist:.2f}")  # Output: Distance: 5.00
```

### Example 2: RGB Colors

```python
# Color definitions
colors = {
    "red": (255, 0, 0),
    "green": (0, 255, 0),
    "blue": (0, 0, 255),
    "white": (255, 255, 255),
    "black": (0, 0, 0)
}

def get_color_components(color_name):
    return colors.get(color_name, (0, 0, 0))

red, green, blue = get_color_components("red")
print(f"Red: RGB({red}, {green}, {blue})")
```

### Example 3: Student Records

```python
# Immutable student records
students = [
    ("Alice", 25, 3.8),
    ("Bob", 23, 3.5),
    ("Charlie", 24, 3.9)
]

# Access student data
for student in students:
    name, age, gpa = student
    print(f"{name}: Age {age}, GPA {gpa}")
```

### Example 4: Function Return Values

```python
def calculate_stats(numbers):
    total = sum(numbers)
    count = len(numbers)
    average = total / count
    maximum = max(numbers)
    minimum = min(numbers)
    return total, count, average, maximum, minimum

scores = [85, 92, 78, 96, 88]
total, count, avg, max_score, min_score = calculate_stats(scores)
print(f"Total: {total}, Count: {count}, Average: {avg:.2f}")
print(f"Max: {max_score}, Min: {min_score}")
```

---

## Common Mistakes and Pitfalls

### 1. Forgetting Comma in Single-Element Tuple

```python
# Wrong - this is not a tuple
not_tuple = (42)
print(type(not_tuple))  # <class 'int'>

# Correct - comma is required
is_tuple = (42,)
print(type(is_tuple))  # <class 'tuple'>
```

### 2. Trying to Modify Tuple

```python
numbers = (1, 2, 3)
# numbers[0] = 10  # TypeError!

# Solution: Create new tuple
numbers = (10, 2, 3)
```

### 3. Confusing Tuple and List Syntax

```python
# Tuple uses parentheses
my_tuple = (1, 2, 3)

# List uses square brackets
my_list = [1, 2, 3]

# Don't mix them up!
```

### 4. Unpacking Mismatch

```python
# Wrong - number of variables doesn't match
# x, y = (1, 2, 3)  # ValueError: too many values to unpack

# Correct
x, y, z = (1, 2, 3)

# Or use extended unpacking
x, *rest = (1, 2, 3)
```

---

## Practice Exercise

### Exercise: Working with Tuples

**Objective**: Create a Python program that demonstrates various tuple operations and use cases.

**Instructions**:

1. Create a file called `tuple_practice.py`

2. Write a program that:
   - Creates tuples in different ways
   - Demonstrates tuple immutability
   - Uses tuple unpacking
   - Compares tuples and lists
   - Uses tuples as dictionary keys
   - Implements practical tuple-based solutions

3. Your program should include:
   - Coordinate system
   - Color definitions
   - Student records
   - Function return values
   - Tuple operations

**Example Solution**:

```python
"""
Tuple Practice
This program demonstrates various tuple operations and use cases.
"""

print("=" * 60)
print("TUPLE PRACTICE")
print("=" * 60)
print()

# 1. Creating Tuples
print("1. CREATING TUPLES")
print("-" * 60)
# Empty tuple
empty = ()
print(f"Empty tuple: {empty}")

# Tuple with items
fruits = ("apple", "banana", "orange")
print(f"Fruits: {fruits}")

# Single element (comma required!)
single = (42,)
print(f"Single element: {single}, type: {type(single)}")

# Without comma (not a tuple!)
not_tuple = (42)
print(f"Without comma: {not_tuple}, type: {type(not_tuple)}")

# Using tuple constructor
numbers = tuple([1, 2, 3, 4, 5])
print(f"From list: {numbers}")

# Tuple packing (without parentheses)
coordinates = 10, 20, 30
print(f"Packed tuple: {coordinates}")
print()

# 2. Accessing Elements
print("2. ACCESSING ELEMENTS")
print("-" * 60)
fruits = ("apple", "banana", "orange", "grape", "kiwi")
print(f"Fruits: {fruits}")
print(f"First: {fruits[0]}")
print(f"Last: {fruits[-1]}")
print(f"Slice [1:4]: {fruits[1:4]}")
print(f"Every other: {fruits[::2]}")
print()

# 3. Tuple Immutability
print("3. TUPLE IMMUTABILITY")
print("-" * 60)
numbers = (1, 2, 3)
print(f"Original: {numbers}")

# Cannot modify
# numbers[0] = 10  # TypeError!

# Create new tuple
new_numbers = numbers + (4,)
print(f"New tuple: {new_numbers}")
print(f"Original unchanged: {numbers}")

# Modify by slicing
modified = numbers[:1] + (99,) + numbers[1:]
print(f"Modified: {modified}")
print()

# 4. Tuple Unpacking
print("4. TUPLE UNPACKING")
print("-" * 60)
# Basic unpacking
point = (3, 4)
x, y = point
print(f"Point {point}: x={x}, y={y}")

# Multiple values
name, age, city = ("Alice", 25, "NYC")
print(f"{name} is {age} years old, lives in {city}")

# Swapping
a, b = 5, 10
print(f"Before swap: a={a}, b={b}")
a, b = b, a
print(f"After swap: a={a}, b={b}")

# Extended unpacking
first, *middle, last = (1, 2, 3, 4, 5)
print(f"First: {first}, Middle: {middle}, Last: {last}")
print()

# 5. Tuple vs List
print("5. TUPLE vs LIST")
print("-" * 60)
# List - mutable
fruits_list = ["apple", "banana"]
fruits_list.append("orange")
print(f"List (mutable): {fruits_list}")

# Tuple - immutable
fruits_tuple = ("apple", "banana")
# fruits_tuple.append("orange")  # Error!
print(f"Tuple (immutable): {fruits_tuple}")

# Performance
import time
n = 1000000

start = time.time()
my_list = list(range(n))
list_time = time.time() - start

start = time.time()
my_tuple = tuple(range(n))
tuple_time = time.time() - start

print(f"List creation time: {list_time:.6f}s")
print(f"Tuple creation time: {tuple_time:.6f}s")
print()

# 6. Tuple Methods
print("6. TUPLE METHODS")
print("-" * 60)
numbers = (1, 2, 3, 2, 4, 2, 5)
print(f"Numbers: {numbers}")
print(f"Count of 2: {numbers.count(2)}")
print(f"Index of first 2: {numbers.index(2)}")
print(f"Index of 2 starting from 3: {numbers.index(2, 3)}")
print()

# 7. Tuples as Dictionary Keys
print("7. TUPLES AS DICTIONARY KEYS")
print("-" * 60)
# Grid system
grid = {
    (0, 0): "Start",
    (0, 1): "Path",
    (1, 1): "Treasure",
    (2, 2): "End"
}

print("Grid positions:")
for pos, value in grid.items():
    x, y = pos
    print(f"  ({x}, {y}): {value}")

# Access cell
def get_cell(x, y):
    return grid.get((x, y), "Empty")

print(f"\nCell (1, 1): {get_cell(1, 1)}")
print(f"Cell (5, 5): {get_cell(5, 5)}")
print()

# 8. Function Return Values
print("8. FUNCTION RETURN VALUES")
print("-" * 60)
def get_name_age():
    return "Alice", 25

# Unpack return value
name, age = get_name_age()
print(f"Name: {name}, Age: {age}")

# Use as tuple
result = get_name_age()
print(f"Result tuple: {result}")

# Multiple return values
def calculate_stats(numbers):
    return sum(numbers), len(numbers), max(numbers), min(numbers)

scores = [85, 92, 78, 96, 88]
total, count, maximum, minimum = calculate_stats(scores)
print(f"\nScores: {scores}")
print(f"Total: {total}, Count: {count}")
print(f"Max: {maximum}, Min: {minimum}")
print()

# 9. RGB Colors
print("9. RGB COLORS")
print("-" * 60)
colors = {
    "red": (255, 0, 0),
    "green": (0, 255, 0),
    "blue": (0, 0, 255),
    "white": (255, 255, 255),
    "black": (0, 0, 0)
}

for color_name, rgb in colors.items():
    r, g, b = rgb
    print(f"{color_name}: RGB({r}, {g}, {b})")
print()

# 10. Coordinate Calculations
print("10. COORDINATE CALCULATIONS")
print("-" * 60)
def distance(p1, p2):
    x1, y1 = p1
    x2, y2 = p2
    return ((x2 - x1)**2 + (y2 - y1)**2)**0.5

point1 = (3, 4)
point2 = (6, 8)
dist = distance(point1, point2)
print(f"Distance between {point1} and {point2}: {dist:.2f}")

# Multiple points
points = [(0, 0), (3, 4), (6, 8), (9, 12)]
print("\nDistances from origin:")
for point in points:
    x, y = point
    dist = distance((0, 0), point)
    print(f"  Point {point}: distance = {dist:.2f}")
print()

# 11. Student Records
print("11. STUDENT RECORDS")
print("-" * 60)
students = [
    ("Alice", 25, 3.8),
    ("Bob", 23, 3.5),
    ("Charlie", 24, 3.9)
]

print("Student Records:")
for student in students:
    name, age, gpa = student
    print(f"  {name}: Age {age}, GPA {gpa}")

# Add new student (create new tuple)
new_student = ("Diana", 22, 3.7)
students = students + [new_student]  # Create new list
print(f"\nAfter adding {new_student[0]}:")
for student in students:
    name, age, gpa = student
    print(f"  {name}: Age {age}, GPA {gpa}")
print()

# 12. Tuple Operations
print("12. TUPLE OPERATIONS")
print("-" * 60)
tuple1 = (1, 2, 3)
tuple2 = (4, 5, 6)

# Concatenation
combined = tuple1 + tuple2
print(f"{tuple1} + {tuple2} = {combined}")

# Repetition
repeated = (1, 2) * 3
print(f"(1, 2) * 3 = {repeated}")

# Membership
print(f"2 in {tuple1}: {2 in tuple1}")
print(f"7 in {tuple1}: {7 in tuple1}")

# Length
print(f"Length of {tuple1}: {len(tuple1)}")

# Comparison
print(f"{tuple1} < {tuple2}: {tuple1 < tuple2}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
TUPLE PRACTICE
============================================================

1. CREATING TUPLES
------------------------------------------------------------
Empty tuple: ()
Fruits: ('apple', 'banana', 'orange')
Single element: (42,), type: <class 'tuple'>
Without comma: 42, type: <class 'int'>
From list: (1, 2, 3, 4, 5)
Packed tuple: (10, 20, 30)

[... rest of output ...]
```

**Challenge** (Optional):
- Create a more complex coordinate system
- Build a color palette manager
- Implement a student database with tuple records
- Create a function that returns multiple statistics
- Build a game board using tuples as keys

---

## Key Takeaways

1. **Tuples are immutable** - cannot be modified after creation
2. **Use parentheses `()`** to create tuples, comma required for single elements
3. **Tuple unpacking** allows elegant variable assignment and swapping
4. **Tuples are faster** and use less memory than lists
5. **Tuples can be dictionary keys** (if all elements are hashable)
6. **Use tuples for fixed data**, lists for dynamic data
7. **Tuple methods**: `count()` and `index()` (fewer than lists)
8. **Slicing and indexing** work the same as lists
9. **Function return values** often use tuples for multiple values
10. **Immutability provides data integrity** and prevents accidental changes

---

## Quiz: Tuples

Test your understanding with these questions:

1. **What is the correct way to create a single-element tuple?**
   - A) `(42)`
   - B) `(42,)`
   - C) `[42]`
   - D) `{42}`

2. **Can you modify a tuple after creation?**
   - A) Yes, using indexing
   - B) Yes, using methods
   - C) No, tuples are immutable
   - D) Only if it contains lists

3. **What does `x, y = (1, 2)` do?**
   - A) Creates a tuple
   - B) Unpacks a tuple
   - C) Swaps variables
   - D) Error

4. **Can tuples be used as dictionary keys?**
   - A) Yes, always
   - B) No, never
   - C) Yes, if all elements are hashable
   - D) Only if tuple has 2 elements

5. **What is the result of `(1, 2) + (3, 4)`?**
   - A) `(4, 6)`
   - B) `(1, 2, 3, 4)`
   - C) `(1, 2, (3, 4))`
   - D) Error

6. **How do you swap two variables `a` and `b` in Python?**
   - A) `a = b; b = a`
   - B) `a, b = b, a`
   - C) `swap(a, b)`
   - D) Cannot swap

7. **What tuple method returns the index of an item?**
   - A) `find()`
   - B) `index()`
   - C) `search()`
   - D) `locate()`

8. **What is the main difference between tuples and lists?**
   - A) Tuples use `()`, lists use `[]`
   - B) Tuples are immutable, lists are mutable
   - C) Tuples are faster
   - D) All of the above

9. **What happens if you try `tuple[0] = 10` on a tuple?**
   - A) Works fine
   - B) `TypeError`
   - C) `ValueError`
   - D) `AttributeError`

10. **What does `*middle` do in `first, *middle, last = (1, 2, 3, 4, 5)`?**
    - A) Error
    - B) `middle = 2`
    - C) `middle = [2, 3, 4]`
    - D) `middle = (2, 3, 4)`

**Answers**:
1. B) `(42,)` (comma is required for single-element tuple)
2. C) No, tuples are immutable (cannot be modified)
3. B) Unpacks a tuple (assigns 1 to x, 2 to y)
4. C) Yes, if all elements are hashable
5. B) `(1, 2, 3, 4)` (tuple concatenation)
6. B) `a, b = b, a` (tuple unpacking for swapping)
7. B) `index()` (returns index of first occurrence)
8. D) All of the above (syntax, mutability, performance)
9. B) `TypeError` (tuples don't support item assignment)
10. C) `middle = [2, 3, 4]` (extended unpacking creates a list)

---

## Next Steps

Excellent work! You've mastered tuples. You now understand:
- How to create and work with tuples
- The difference between tuples and lists
- Tuple immutability and its implications
- Tuple unpacking and its power
- When to use tuples vs lists
- Practical applications of tuples

**What's Next?**
- Lesson 3.3: Nested Data Structures
- Practice combining tuples and lists
- Learn about more advanced tuple operations
- Explore tuple-based design patterns

---

## Additional Resources

- **Python Tuples Documentation**: [docs.python.org/3/tutorial/datastructures.html#tuples-and-sequences](https://docs.python.org/3/tutorial/datastructures.html#tuples-and-sequences)
- **Tuple Methods**: [docs.python.org/3/library/stdtypes.html#tuple](https://docs.python.org/3/library/stdtypes.html#tuple)
- **Sequence Types**: [docs.python.org/3/library/stdtypes.html#sequence-types-list-tuple-range](https://docs.python.org/3/library/stdtypes.html#sequence-types-list-tuple-range)

---

*Lesson completed! You're ready to move on to the next lesson.*

