# Lesson 3.3: Nested Data Structures

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand nested data structures (lists of lists, tuples in lists, etc.)
- Access and modify nested elements
- Work with multi-dimensional structures
- Create and manipulate nested lists and tuples
- Understand shallow vs deep copying with nested structures
- Apply nested data structures in practical scenarios
- Handle common pitfalls with nested structures

---

## Introduction to Nested Data Structures

**Nested data structures** are data structures that contain other data structures as elements. This allows you to create complex, multi-dimensional representations of data, such as matrices, tables, hierarchical data, and more.

### Common Nested Structures

- **Lists of lists** (2D lists, matrices)
- **Lists of tuples**
- **Tuples of lists**
- **Tuples of tuples**
- **Dictionaries containing lists/tuples**
- **Lists of dictionaries**
- **And combinations of the above**

---

## Lists of Lists

Lists of lists are one of the most common nested structures, often used to represent matrices, grids, or tables.

### Creating Lists of Lists

```python
# 2D list (matrix)
matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
]

# Grid
grid = [
    [0, 0, 0],
    [0, 0, 0],
    [0, 0, 0]
]

# Table of data
students = [
    ["Alice", 25, 3.8],
    ["Bob", 23, 3.5],
    ["Charlie", 24, 3.9]
]
```

### Accessing Elements

```python
matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
]

# Access entire row
print(matrix[0])      # Output: [1, 2, 3]

# Access specific element
print(matrix[0][0])   # Output: 1 (first row, first column)
print(matrix[1][2])   # Output: 6 (second row, third column)
print(matrix[2][1])   # Output: 8 (third row, second column)

# Negative indexing
print(matrix[-1][-1])  # Output: 9 (last row, last column)
```

**Visual representation**:
```
matrix[0] → [1, 2, 3]
matrix[1] → [4, 5, 6]
matrix[2] → [7, 8, 9]

matrix[row][column]
```

### Modifying Nested Lists

```python
matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
]

# Modify a single element
matrix[0][0] = 10
print(matrix)  # Output: [[10, 2, 3], [4, 5, 6], [7, 8, 9]]

# Modify an entire row
matrix[1] = [40, 50, 60]
print(matrix)  # Output: [[10, 2, 3], [40, 50, 60], [7, 8, 9]]

# Add a new row
matrix.append([10, 11, 12])
print(matrix)  # Output: [[10, 2, 3], [40, 50, 60], [7, 8, 9], [10, 11, 12]]

# Modify element in a row
matrix[0][1] = 20
print(matrix[0])  # Output: [10, 20, 3]
```

### Iterating Over Nested Lists

```python
matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
]

# Iterate over rows
for row in matrix:
    print(row)
# Output:
# [1, 2, 3]
# [4, 5, 6]
# [7, 8, 9]

# Iterate over rows and elements
for row in matrix:
    for element in row:
        print(element, end=" ")
    print()
# Output:
# 1 2 3
# 4 5 6
# 7 8 9

# Iterate with indices
for i, row in enumerate(matrix):
    for j, element in enumerate(row):
        print(f"matrix[{i}][{j}] = {element}")
# Output:
# matrix[0][0] = 1
# matrix[0][1] = 2
# ...
```

### Creating Lists of Lists

```python
# Method 1: List comprehension
matrix = [[0 for _ in range(3)] for _ in range(3)]
print(matrix)  # Output: [[0, 0, 0], [0, 0, 0], [0, 0, 0]]

# Method 2: Nested loops
matrix = []
for i in range(3):
    row = []
    for j in range(3):
        row.append(i * 3 + j + 1)
    matrix.append(row)
print(matrix)  # Output: [[1, 2, 3], [4, 5, 6], [7, 8, 9]]

# Method 3: Direct initialization
matrix = [[1, 2, 3], [4, 5, 6], [7, 8, 9]]
```

### Common Operations on Lists of Lists

**1. Accessing Rows and Columns**:
```python
matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
]

# Get first row
first_row = matrix[0]
print(first_row)  # Output: [1, 2, 3]

# Get first column (using list comprehension)
first_column = [row[0] for row in matrix]
print(first_column)  # Output: [1, 4, 7]

# Get diagonal
diagonal = [matrix[i][i] for i in range(len(matrix))]
print(diagonal)  # Output: [1, 5, 9]
```

**2. Transposing a Matrix**:
```python
matrix = [
    [1, 2, 3],
    [4, 5, 6]
]

# Transpose (swap rows and columns)
transposed = [[row[i] for row in matrix] for i in range(len(matrix[0]))]
print(transposed)  # Output: [[1, 4], [2, 5], [3, 6]]
```

**3. Finding Dimensions**:
```python
matrix = [
    [1, 2, 3],
    [4, 5, 6]
]

rows = len(matrix)
cols = len(matrix[0]) if matrix else 0
print(f"Dimensions: {rows}x{cols}")  # Output: Dimensions: 2x3
```

---

## Lists of Tuples

Lists of tuples are useful when you need ordered collections of fixed data.

### Creating Lists of Tuples

```python
# Coordinates
points = [(0, 0), (1, 2), (3, 4), (5, 6)]

# Student records
students = [
    ("Alice", 25, 3.8),
    ("Bob", 23, 3.5),
    ("Charlie", 24, 3.9)
]

# RGB colors
colors = [
    (255, 0, 0),    # Red
    (0, 255, 0),    # Green
    (0, 0, 255)     # Blue
]
```

### Accessing Elements

```python
students = [
    ("Alice", 25, 3.8),
    ("Bob", 23, 3.5),
    ("Charlie", 24, 3.9)
]

# Access entire tuple
print(students[0])  # Output: ('Alice', 25, 3.8)

# Access element in tuple
print(students[0][0])  # Output: Alice (first student's name)
print(students[1][2])  # Output: 3.5 (second student's GPA)

# Unpack while accessing
name, age, gpa = students[0]
print(f"{name} is {age} years old with GPA {gpa}")
```

### Modifying Lists of Tuples

```python
students = [
    ("Alice", 25, 3.8),
    ("Bob", 23, 3.5)
]

# Cannot modify tuple elements directly
# students[0][0] = "Alicia"  # TypeError!

# But can replace entire tuple
students[0] = ("Alicia", 25, 3.8)
print(students)  # Output: [('Alicia', 25, 3.8), ('Bob', 23, 3.5)]

# Add new tuple
students.append(("Charlie", 24, 3.9))
print(students)
```

### Iterating Over Lists of Tuples

```python
students = [
    ("Alice", 25, 3.8),
    ("Bob", 23, 3.5),
    ("Charlie", 24, 3.9)
]

# Iterate and unpack
for name, age, gpa in students:
    print(f"{name}: Age {age}, GPA {gpa}")
# Output:
# Alice: Age 25, GPA 3.8
# Bob: Age 23, GPA 3.5
# Charlie: Age 24, GPA 3.9

# Access by index
for i, student in enumerate(students):
    name, age, gpa = student
    print(f"Student {i+1}: {name}")
```

---

## Tuples of Lists

Tuples of lists combine immutability of the outer structure with mutability of inner lists.

### Creating Tuples of Lists

```python
# Tuple containing lists
data = ([1, 2, 3], [4, 5, 6], [7, 8, 9])

# Cannot modify tuple structure
# data[0] = [10, 20, 30]  # TypeError!

# But can modify lists inside
data[0].append(4)
print(data)  # Output: ([1, 2, 3, 4], [4, 5, 6], [7, 8, 9])

data[1][0] = 40
print(data)  # Output: ([1, 2, 3, 4], [40, 5, 6], [7, 8, 9])
```

### Practical Example

```python
# Game board (immutable structure, mutable cells)
board = (
    [None, None, None],
    [None, None, None],
    [None, None, None]
)

# Make a move
board[0][0] = "X"
board[1][1] = "O"
print(board)
# Output: (['X', None, None], [None, 'O', None], [None, None, None])
```

---

## Tuples of Tuples

Tuples of tuples create fully immutable nested structures.

### Creating Tuples of Tuples

```python
# Matrix (fully immutable)
matrix = (
    (1, 2, 3),
    (4, 5, 6),
    (7, 8, 9)
)

# Coordinates
triangle = (
    (0, 0),
    (3, 0),
    (1.5, 2.6)
)
```

### Accessing Elements

```python
matrix = (
    (1, 2, 3),
    (4, 5, 6),
    (7, 8, 9)
)

print(matrix[0][0])  # Output: 1
print(matrix[1][2])  # Output: 6

# Cannot modify
# matrix[0][0] = 10  # TypeError!
```

---

## Dictionaries with Nested Structures

Dictionaries can contain lists, tuples, or other dictionaries as values.

### Dictionary of Lists

```python
# Student grades by subject
grades = {
    "Alice": [85, 92, 78],
    "Bob": [90, 88, 95],
    "Charlie": [75, 80, 85]
}

# Access
print(grades["Alice"])      # Output: [85, 92, 78]
print(grades["Alice"][0])   # Output: 85

# Modify
grades["Alice"].append(96)
print(grades["Alice"])      # Output: [85, 92, 78, 96]

# Add new student
grades["Diana"] = [88, 90, 92]
```

### Dictionary of Tuples

```python
# Student info (immutable records)
students = {
    "Alice": ("Alice", 25, 3.8),
    "Bob": ("Bob", 23, 3.5),
    "Charlie": ("Charlie", 24, 3.9)
}

# Access
name, age, gpa = students["Alice"]
print(f"{name}: Age {age}, GPA {gpa}")

# Cannot modify tuple
# students["Alice"][1] = 26  # TypeError!

# But can replace entire tuple
students["Alice"] = ("Alice", 26, 3.8)
```

### Dictionary of Dictionaries

```python
# Nested dictionaries
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

# Access
print(students["Alice"]["age"])           # Output: 25
print(students["Alice"]["courses"][0])    # Output: Math

# Modify
students["Alice"]["age"] = 26
students["Alice"]["courses"].append("Art")
```

---

## Lists of Dictionaries

Lists of dictionaries are useful for representing collections of records.

### Creating Lists of Dictionaries

```python
# Student records
students = [
    {"name": "Alice", "age": 25, "gpa": 3.8},
    {"name": "Bob", "age": 23, "gpa": 3.5},
    {"name": "Charlie", "age": 24, "gpa": 3.9}
]
```

### Accessing and Modifying

```python
students = [
    {"name": "Alice", "age": 25, "gpa": 3.8},
    {"name": "Bob", "age": 23, "gpa": 3.5}
]

# Access
print(students[0]["name"])  # Output: Alice
print(students[1]["gpa"])   # Output: 3.5

# Modify
students[0]["age"] = 26
students[1]["gpa"] = 3.6

# Add new student
students.append({"name": "Diana", "age": 22, "gpa": 3.7})
```

### Iterating Over Lists of Dictionaries

```python
students = [
    {"name": "Alice", "age": 25, "gpa": 3.8},
    {"name": "Bob", "age": 23, "gpa": 3.5},
    {"name": "Charlie", "age": 24, "gpa": 3.9}
]

# Iterate and access
for student in students:
    print(f"{student['name']}: Age {student['age']}, GPA {student['gpa']}")

# Filter
high_gpa = [s for s in students if s["gpa"] >= 3.8]
print(high_gpa)  # Output: [{'name': 'Alice', 'age': 25, 'gpa': 3.8}, ...]
```

---

## Shallow vs Deep Copy with Nested Structures

Understanding copying is crucial when working with nested structures.

### Shallow Copy

A shallow copy creates a new outer structure but references the same inner objects:

```python
import copy

# Original nested list
original = [[1, 2, 3], [4, 5, 6]]

# Shallow copy
shallow = copy.copy(original)
# Or: shallow = original.copy()  # For lists
# Or: shallow = list(original)   # For lists

# Modify inner list
shallow[0][0] = 99

print(original)  # Output: [[99, 2, 3], [4, 5, 6]] (also changed!)
print(shallow)   # Output: [[99, 2, 3], [4, 5, 6]]
```

### Deep Copy

A deep copy creates completely independent copies of all nested structures:

```python
import copy

# Original nested list
original = [[1, 2, 3], [4, 5, 6]]

# Deep copy
deep = copy.deepcopy(original)

# Modify inner list
deep[0][0] = 99

print(original)  # Output: [[1, 2, 3], [4, 5, 6]] (unchanged!)
print(deep)      # Output: [[99, 2, 3], [4, 5, 6]]
```

### When to Use Each

- **Shallow copy**: When inner structures are immutable (tuples) or you want shared references
- **Deep copy**: When you need completely independent nested structures

---

## Practical Examples

### Example 1: Matrix Operations

```python
# Matrix addition
def add_matrices(m1, m2):
    result = []
    for i in range(len(m1)):
        row = []
        for j in range(len(m1[0])):
            row.append(m1[i][j] + m2[i][j])
        result.append(row)
    return result

matrix1 = [[1, 2], [3, 4]]
matrix2 = [[5, 6], [7, 8]]
result = add_matrices(matrix1, matrix2)
print(result)  # Output: [[6, 8], [10, 12]]
```

### Example 2: Game Board

```python
# Tic-tac-toe board
def create_board(size=3):
    return [[" " for _ in range(size)] for _ in range(size)]

def print_board(board):
    for row in board:
        print("|".join(row))
        print("-" * (len(row) * 2 - 1))

board = create_board(3)
board[0][0] = "X"
board[1][1] = "O"
board[2][2] = "X"
print_board(board)
```

### Example 3: Student Database

```python
# Student database
students = [
    {
        "name": "Alice",
        "age": 25,
        "grades": {"Math": 85, "Science": 92, "English": 78}
    },
    {
        "name": "Bob",
        "age": 23,
        "grades": {"Math": 90, "Science": 88, "English": 95}
    }
]

# Calculate average grade for a student
def avg_grade(student):
    grades = student["grades"].values()
    return sum(grades) / len(grades)

for student in students:
    avg = avg_grade(student)
    print(f"{student['name']}: {avg:.2f}")
```

### Example 4: Coordinate System

```python
# 2D coordinate system
points = [(0, 0), (3, 4), (6, 8), (9, 12)]

def distance(p1, p2):
    x1, y1 = p1
    x2, y2 = p2
    return ((x2 - x1)**2 + (y2 - y1)**2)**0.5

# Calculate distances from origin
for point in points:
    dist = distance((0, 0), point)
    print(f"Point {point}: distance = {dist:.2f}")
```

---

## Common Mistakes and Pitfalls

### 1. Shallow Copy Issues

```python
# Wrong: All rows reference the same list
matrix = [[0] * 3] * 3
matrix[0][0] = 1
print(matrix)  # All rows changed! [[1, 0, 0], [1, 0, 0], [1, 0, 0]]

# Correct: Each row is independent
matrix = [[0 for _ in range(3)] for _ in range(3)]
matrix[0][0] = 1
print(matrix)  # Only first row changed: [[1, 0, 0], [0, 0, 0], [0, 0, 0]]
```

### 2. Modifying Immutable Nested Structures

```python
# Tuple of lists - can modify lists
data = ([1, 2], [3, 4])
data[0].append(5)  # OK
# data[0] = [6, 7]  # Error - cannot reassign

# Tuple of tuples - cannot modify anything
data = ((1, 2), (3, 4))
# data[0][0] = 5  # Error - tuples are immutable
```

### 3. Index Out of Range

```python
matrix = [[1, 2, 3], [4, 5, 6]]
# print(matrix[2][0])  # IndexError - only 2 rows (0, 1)
# print(matrix[0][3])  # IndexError - only 3 columns (0, 1, 2)
```

### 4. Assuming Uniform Structure

```python
# Not all rows have same length
ragged = [[1, 2], [3, 4, 5], [6]]
# Be careful when accessing - check lengths first
```

---

## Practice Exercise

### Exercise: Nested Data Structures Practice

**Objective**: Create a Python program that demonstrates working with various nested data structures.

**Instructions**:

1. Create a file called `nested_structures_practice.py`

2. Write a program that:
   - Creates and manipulates lists of lists
   - Works with lists of tuples
   - Uses dictionaries with nested structures
   - Implements practical nested structure operations
   - Demonstrates shallow vs deep copying

3. Your program should include:
   - Matrix operations
   - Game board
   - Student database
   - Coordinate system
   - Copying examples

**Example Solution**:

```python
"""
Nested Data Structures Practice
This program demonstrates working with various nested data structures.
"""

print("=" * 60)
print("NESTED DATA STRUCTURES PRACTICE")
print("=" * 60)
print()

# 1. Lists of Lists (Matrix)
print("1. LISTS OF LISTS (MATRIX)")
print("-" * 60)
# Create matrix
matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
]

print("Matrix:")
for row in matrix:
    print(f"  {row}")

# Access elements
print(f"\nElement at [1][2]: {matrix[1][2]}")
print(f"First row: {matrix[0]}")
print(f"First column: {[row[0] for row in matrix]}")

# Modify
matrix[0][0] = 10
print(f"\nAfter modifying [0][0] to 10:")
for row in matrix:
    print(f"  {row}")
print()

# 2. Lists of Tuples
print("2. LISTS OF TUPLES")
print("-" * 60)
students = [
    ("Alice", 25, 3.8),
    ("Bob", 23, 3.5),
    ("Charlie", 24, 3.9)
]

print("Students:")
for name, age, gpa in students:
    print(f"  {name}: Age {age}, GPA {gpa}")

# Access
print(f"\nFirst student's name: {students[0][0]}")
print(f"Second student's GPA: {students[1][2]}")

# Replace tuple
students[0] = ("Alicia", 25, 3.8)
print(f"\nAfter updating first student:")
for name, age, gpa in students:
    print(f"  {name}: Age {age}, GPA {gpa}")
print()

# 3. Tuples of Lists
print("3. TUPLES OF LISTS")
print("-" * 60)
data = ([1, 2, 3], [4, 5, 6], [7, 8, 9])
print(f"Original: {data}")

# Can modify lists inside
data[0].append(4)
data[1][0] = 40
print(f"After modifications: {data}")

# Cannot reassign
# data[0] = [10, 20]  # TypeError!
print()

# 4. Dictionary of Lists
print("4. DICTIONARY OF LISTS")
print("-" * 60)
grades = {
    "Alice": [85, 92, 78],
    "Bob": [90, 88, 95],
    "Charlie": [75, 80, 85]
}

print("Grades:")
for name, scores in grades.items():
    avg = sum(scores) / len(scores)
    print(f"  {name}: {scores} (Avg: {avg:.1f})")

# Modify
grades["Alice"].append(96)
print(f"\nAfter adding score for Alice: {grades['Alice']}")
print()

# 5. Dictionary of Dictionaries
print("5. DICTIONARY OF DICTIONARIES")
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

# Modify
students["Alice"]["age"] = 26
students["Alice"]["courses"].append("Art")
print(f"\nAfter updating Alice:")
print(f"  Age: {students['Alice']['age']}")
print(f"  Courses: {students['Alice']['courses']}")
print()

# 6. Lists of Dictionaries
print("6. LISTS OF DICTIONARIES")
print("-" * 60)
students = [
    {"name": "Alice", "age": 25, "gpa": 3.8},
    {"name": "Bob", "age": 23, "gpa": 3.5},
    {"name": "Charlie", "age": 24, "gpa": 3.9}
]

print("Students:")
for student in students:
    print(f"  {student['name']}: Age {student['age']}, GPA {student['gpa']}")

# Filter
high_gpa = [s for s in students if s["gpa"] >= 3.8]
print(f"\nHigh GPA students (>= 3.8):")
for student in high_gpa:
    print(f"  {student['name']}: {student['gpa']}")
print()

# 7. Matrix Operations
print("7. MATRIX OPERATIONS")
print("-" * 60)
def print_matrix(matrix, title="Matrix"):
    print(f"{title}:")
    for row in matrix:
        print(f"  {row}")

def add_matrices(m1, m2):
    return [[m1[i][j] + m2[i][j] for j in range(len(m1[0]))] 
            for i in range(len(m1))]

matrix1 = [[1, 2], [3, 4]]
matrix2 = [[5, 6], [7, 8]]

print_matrix(matrix1, "Matrix 1")
print_matrix(matrix2, "Matrix 2")

result = add_matrices(matrix1, matrix2)
print_matrix(result, "Sum")
print()

# 8. Game Board
print("8. GAME BOARD")
print("-" * 60)
def create_board(size=3):
    return [[" " for _ in range(size)] for _ in range(size)]

def print_board(board):
    for i, row in enumerate(board):
        print("  " + " | ".join(row))
        if i < len(board) - 1:
            print("  " + "-" * (len(row) * 4 - 1))

board = create_board(3)
board[0][0] = "X"
board[1][1] = "O"
board[2][2] = "X"

print("Tic-tac-toe board:")
print_board(board)
print()

# 9. Shallow vs Deep Copy
print("9. SHALLOW vs DEEP COPY")
print("-" * 60)
import copy

original = [[1, 2, 3], [4, 5, 6]]

# Shallow copy
shallow = copy.copy(original)
shallow[0][0] = 99

print(f"Original: {original}")  # Changed!
print(f"Shallow: {shallow}")

# Reset
original = [[1, 2, 3], [4, 5, 6]]

# Deep copy
deep = copy.deepcopy(original)
deep[0][0] = 99

print(f"\nOriginal: {original}")  # Unchanged!
print(f"Deep: {deep}")
print()

# 10. Coordinate System
print("10. COORDINATE SYSTEM")
print("-" * 60)
points = [(0, 0), (3, 4), (6, 8), (9, 12)]

def distance(p1, p2):
    x1, y1 = p1
    x2, y2 = p2
    return ((x2 - x1)**2 + (y2 - y1)**2)**0.5

print("Distances from origin:")
for point in points:
    x, y = point
    dist = distance((0, 0), point)
    print(f"  Point {point}: {dist:.2f}")

# Find closest to origin
closest = min(points, key=lambda p: distance((0, 0), p))
print(f"\nClosest to origin: {closest}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
NESTED DATA STRUCTURES PRACTICE
============================================================

1. LISTS OF LISTS (MATRIX)
------------------------------------------------------------
Matrix:
  [1, 2, 3]
  [4, 5, 6]
  [7, 8, 9]

Element at [1][2]: 6
First row: [1, 2, 3]
First column: [1, 4, 7]

[... rest of output ...]
```

**Challenge** (Optional):
- Create a more complex matrix calculator
- Build a complete game with nested board
- Implement a student management system
- Create a graph representation using nested structures
- Build a spreadsheet-like data structure

---

## Key Takeaways

1. **Nested structures** allow complex, multi-dimensional data representation
2. **Lists of lists** are common for matrices, grids, and tables
3. **Lists of tuples** combine order with immutability of records
4. **Dictionaries** can contain lists, tuples, or other dictionaries
5. **Access nested elements** using multiple indices: `structure[i][j]`
6. **Shallow copy** shares inner structures; **deep copy** creates independent copies
7. **Be careful** when creating nested structures - avoid shared references
8. **Immutable outer structures** (tuples) can contain mutable inner structures (lists)
9. **Choose structure** based on mutability needs and use case
10. **Nested structures** are powerful for representing real-world data

---

## Quiz: Nested Data Structures

Test your understanding with these questions:

1. **How do you access the element at row 1, column 2 in a matrix?**
   - A) `matrix[1, 2]`
   - B) `matrix[1][2]`
   - C) `matrix[2][1]`
   - D) `matrix(1, 2)`

2. **What happens with `matrix = [[0] * 3] * 3` and then `matrix[0][0] = 1`?**
   - A) Only first element changes
   - B) All first elements in each row change
   - C) Error
   - D) Nothing happens

3. **Can you modify a list inside a tuple?**
   - A) Yes
   - B) No
   - C) Only if tuple has 2 elements
   - D) Only if list is empty

4. **What is the difference between shallow and deep copy for nested structures?**
   - A) No difference
   - B) Shallow copies inner structures, deep doesn't
   - C) Deep creates independent copies, shallow shares references
   - D) Shallow is faster

5. **How do you get the first column from a matrix?**
   - A) `matrix[0]`
   - B) `matrix[:, 0]`
   - C) `[row[0] for row in matrix]`
   - D) `matrix.column(0)`

6. **What structure is best for immutable student records?**
   - A) List of lists
   - B) List of tuples
   - C) Tuple of lists
   - D) Dictionary of lists

7. **Can you modify a tuple inside a list?**
   - A) Yes, directly
   - B) No, but can replace entire tuple
   - C) Yes, using methods
   - D) Never

8. **What does `students[0]["name"]` access?**
   - A) First student's name in a list of dictionaries
   - B) Error
   - C) Name key in first dictionary
   - D) Both A and C

9. **How do you create a 3x3 matrix of zeros?**
   - A) `[[0] * 3] * 3`
   - B) `[[0 for _ in range(3)] for _ in range(3)]`
   - C) `[[0, 0, 0], [0, 0, 0], [0, 0, 0]]`
   - D) All of the above (but B and C are safer)

10. **What happens when you modify a list in a shallow copy?**
    - A) Only copy changes
    - B) Only original changes
    - C) Both change (shared reference)
    - D) Error

**Answers**:
1. B) `matrix[1][2]` (row 1, column 2)
2. B) All first elements in each row change (shared reference issue)
3. A) Yes (can modify list inside tuple, but not reassign the list)
4. C) Deep creates independent copies, shallow shares references
5. C) `[row[0] for row in matrix]` (list comprehension)
6. B) List of tuples (ordered, immutable records)
7. B) No, but can replace entire tuple
8. D) Both A and C (first student's name in list of dicts)
9. D) All work, but B and C are safer (avoid shared references)
10. C) Both change (shared reference in shallow copy)

---

## Next Steps

Excellent work! You've mastered nested data structures. You now understand:
- How to create and work with nested structures
- Accessing and modifying nested elements
- Different types of nested combinations
- Shallow vs deep copying
- Practical applications

**What's Next?**
- Module 4: Data Structures - Dictionaries and Sets
- Practice building more complex nested structures
- Learn about advanced data structure operations
- Explore real-world applications

---

## Additional Resources

- **Python Data Structures**: [docs.python.org/3/tutorial/datastructures.html](https://docs.python.org/3/tutorial/datastructures.html)
- **Copy Module**: [docs.python.org/3/library/copy.html](https://docs.python.org/3/library/copy.html)
- **List Comprehensions**: [docs.python.org/3/tutorial/datastructures.html#list-comprehensions](https://docs.python.org/3/tutorial/datastructures.html#list-comprehensions)

---

*Lesson completed! You're ready to move on to the next lesson.*

