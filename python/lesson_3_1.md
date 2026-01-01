# Lesson 3.1: Lists

## Learning Objectives

By the end of this lesson, you will be able to:
- Create lists in Python
- Access list elements using indexing and slicing
- Modify lists using various methods
- Understand list mutability
- Use common list methods (append, extend, insert, remove, pop)
- Understand list comprehensions (basics)
- Work with nested lists
- Apply lists in practical programming scenarios

---

## Introduction to Lists

A **list** is an ordered, mutable collection of items in Python. Lists can contain any type of data, including numbers, strings, other lists, and even mixed types. Lists are one of the most versatile and commonly used data structures in Python.

### Key Characteristics of Lists

1. **Ordered**: Items maintain their order
2. **Mutable**: Can be modified after creation
3. **Indexed**: Access items by position (starting at 0)
4. **Heterogeneous**: Can contain different data types
5. **Dynamic**: Can grow or shrink as needed

---

## Creating Lists

### Basic List Creation

**Method 1: Using square brackets `[]`**:
```python
# Empty list
empty_list = []
print(empty_list)  # Output: []

# List with items
numbers = [1, 2, 3, 4, 5]
print(numbers)  # Output: [1, 2, 3, 4, 5]

# List with different types
mixed = [1, "hello", 3.14, True]
print(mixed)  # Output: [1, 'hello', 3.14, True]
```

**Method 2: Using the `list()` constructor**:
```python
# From a string (splits into characters)
chars = list("hello")
print(chars)  # Output: ['h', 'e', 'l', 'l', 'o']

# From a range
numbers = list(range(5))
print(numbers)  # Output: [0, 1, 2, 3, 4]

# Empty list
empty = list()
print(empty)  # Output: []
```

**Method 3: List comprehension** (covered in detail later):
```python
# Squares of numbers
squares = [x**2 for x in range(5)]
print(squares)  # Output: [0, 1, 4, 9, 16]
```

### List Examples

```python
# List of strings
fruits = ["apple", "banana", "orange"]
print(fruits)

# List of numbers
scores = [85, 92, 78, 96, 88]
print(scores)

# Mixed types
student = ["Alice", 25, 3.8, True]
print(student)

# Nested lists (lists within lists)
matrix = [[1, 2, 3], [4, 5, 6], [7, 8, 9]]
print(matrix)
```

---

## Accessing List Elements

### Indexing

Lists are indexed starting from 0. You can access elements by their position:

```python
fruits = ["apple", "banana", "orange", "grape", "kiwi"]

# Positive indexing (from start)
print(fruits[0])  # Output: apple (first element)
print(fruits[1])  # Output: banana
print(fruits[2])  # Output: orange
print(fruits[4])  # Output: kiwi (last element)

# Negative indexing (from end)
print(fruits[-1])  # Output: kiwi (last element)
print(fruits[-2])  # Output: grape (second to last)
print(fruits[-5])  # Output: apple (first element)
```

**Index positions**:
```
Index:    0        1        2        3        4
Item:   apple   banana   orange   grape    kiwi
Index:   -5       -4       -3       -2       -1
```

### Index Out of Range

Accessing an invalid index causes an `IndexError`:

```python
fruits = ["apple", "banana", "orange"]
# print(fruits[5])  # IndexError: list index out of range
# print(fruits[-4])  # IndexError: list index out of range

# Safe access with bounds checking
if len(fruits) > 5:
    print(fruits[5])
else:
    print("Index out of range")
```

### Slicing

Slicing allows you to extract a portion of a list:

**Syntax**: `list[start:end:step]`

```python
numbers = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]

# Basic slicing [start:end]
print(numbers[2:5])    # Output: [2, 3, 4] (indices 2, 3, 4)
print(numbers[0:3])    # Output: [0, 1, 2]
print(numbers[:5])     # Output: [0, 1, 2, 3, 4] (from start)
print(numbers[5:])     # Output: [5, 6, 7, 8, 9] (to end)
print(numbers[:])      # Output: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] (entire list)

# Negative indices
print(numbers[-5:])    # Output: [5, 6, 7, 8, 9] (last 5 elements)
print(numbers[:-3])     # Output: [0, 1, 2, 3, 4, 5, 6] (all except last 3)

# Step size
print(numbers[::2])    # Output: [0, 2, 4, 6, 8] (every 2nd element)
print(numbers[1::2])   # Output: [1, 3, 5, 7, 9] (every 2nd starting from 1)
print(numbers[::-1])   # Output: [9, 8, 7, 6, 5, 4, 3, 2, 1, 0] (reverse)
```

### Slicing Examples

```python
# Get first 3 items
fruits = ["apple", "banana", "orange", "grape", "kiwi"]
first_three = fruits[:3]
print(first_three)  # Output: ['apple', 'banana', 'orange']

# Get last 2 items
last_two = fruits[-2:]
print(last_two)  # Output: ['grape', 'kiwi']

# Get middle items
middle = fruits[1:4]
print(middle)  # Output: ['banana', 'orange', 'grape']

# Reverse a list
reversed_fruits = fruits[::-1]
print(reversed_fruits)  # Output: ['kiwi', 'grape', 'orange', 'banana', 'apple']
```

---

## Modifying Lists

Lists are **mutable**, meaning you can change their contents after creation.

### Changing Elements by Index

```python
fruits = ["apple", "banana", "orange"]
print(fruits)  # Output: ['apple', 'banana', 'orange']

# Change an element
fruits[1] = "grape"
print(fruits)  # Output: ['apple', 'grape', 'orange']

# Change multiple elements
fruits[0:2] = ["cherry", "date"]
print(fruits)  # Output: ['cherry', 'date', 'orange']
```

### Adding Elements

**1. `append(item)`** - Adds item to the end:
```python
fruits = ["apple", "banana"]
fruits.append("orange")
print(fruits)  # Output: ['apple', 'banana', 'orange']

# Can append any type
fruits.append(42)
print(fruits)  # Output: ['apple', 'banana', 'orange', 42]
```

**2. `insert(index, item)`** - Inserts item at specific position:
```python
fruits = ["apple", "banana", "orange"]
fruits.insert(1, "grape")  # Insert at index 1
print(fruits)  # Output: ['apple', 'grape', 'banana', 'orange']

# Insert at the beginning
fruits.insert(0, "kiwi")
print(fruits)  # Output: ['kiwi', 'apple', 'grape', 'banana', 'orange']
```

**3. `extend(iterable)`** - Adds all items from another iterable:
```python
fruits = ["apple", "banana"]
more_fruits = ["orange", "grape"]
fruits.extend(more_fruits)
print(fruits)  # Output: ['apple', 'banana', 'orange', 'grape']

# Can extend with any iterable
fruits.extend(["kiwi", "mango"])
print(fruits)  # Output: ['apple', 'banana', 'orange', 'grape', 'kiwi', 'mango']

# Using += (equivalent to extend)
fruits += ["cherry"]
print(fruits)  # Output: ['apple', 'banana', 'orange', 'grape', 'kiwi', 'mango', 'cherry']
```

**Difference between `append()` and `extend()`**:
```python
# append() adds the entire object
list1 = [1, 2, 3]
list1.append([4, 5])
print(list1)  # Output: [1, 2, 3, [4, 5]]

# extend() adds each element
list2 = [1, 2, 3]
list2.extend([4, 5])
print(list2)  # Output: [1, 2, 3, 4, 5]
```

### Removing Elements

**1. `remove(item)`** - Removes first occurrence of item:
```python
fruits = ["apple", "banana", "orange", "banana"]
fruits.remove("banana")
print(fruits)  # Output: ['apple', 'orange', 'banana'] (only first removed)

# Error if item not found
# fruits.remove("grape")  # ValueError: list.remove(x): x not in list
```

**2. `pop(index)`** - Removes and returns item at index (default: last):
```python
fruits = ["apple", "banana", "orange"]

# Remove and return last item
last = fruits.pop()
print(last)     # Output: orange
print(fruits)   # Output: ['apple', 'banana']

# Remove and return item at specific index
first = fruits.pop(0)
print(first)    # Output: apple
print(fruits)   # Output: ['banana']
```

**3. `del` statement** - Deletes item(s) by index or slice:
```python
fruits = ["apple", "banana", "orange", "grape"]

# Delete by index
del fruits[1]
print(fruits)  # Output: ['apple', 'orange', 'grape']

# Delete by slice
del fruits[1:3]
print(fruits)  # Output: ['apple']

# Delete entire list
del fruits
# print(fruits)  # NameError: name 'fruits' is not defined
```

**4. `clear()`** - Removes all items:
```python
fruits = ["apple", "banana", "orange"]
fruits.clear()
print(fruits)  # Output: []
```

### Other List Methods

**1. `index(item)`** - Returns index of first occurrence:
```python
fruits = ["apple", "banana", "orange", "banana"]
index = fruits.index("banana")
print(index)  # Output: 1

# With start and end
index = fruits.index("banana", 2)  # Search from index 2
print(index)  # Output: 3
```

**2. `count(item)`** - Returns count of occurrences:
```python
fruits = ["apple", "banana", "orange", "banana"]
count = fruits.count("banana")
print(count)  # Output: 2
```

**3. `sort()`** - Sorts list in place:
```python
numbers = [3, 1, 4, 1, 5, 9, 2, 6]
numbers.sort()
print(numbers)  # Output: [1, 1, 2, 3, 4, 5, 6, 9]

# Reverse sort
numbers.sort(reverse=True)
print(numbers)  # Output: [9, 6, 5, 4, 3, 2, 1, 1]

# Sort strings
fruits = ["banana", "apple", "orange"]
fruits.sort()
print(fruits)  # Output: ['apple', 'banana', 'orange']
```

**4. `reverse()`** - Reverses list in place:
```python
fruits = ["apple", "banana", "orange"]
fruits.reverse()
print(fruits)  # Output: ['orange', 'banana', 'apple']
```

**5. `copy()`** - Creates a shallow copy:
```python
original = [1, 2, 3]
copy = original.copy()
copy.append(4)
print(original)  # Output: [1, 2, 3]
print(copy)      # Output: [1, 2, 3, 4]
```

---

## List Comprehensions (Basics)

List comprehensions provide a concise way to create lists. They're covered in more detail later, but here's a basic introduction:

### Basic Syntax

```python
# Traditional way
squares = []
for x in range(5):
    squares.append(x**2)
print(squares)  # Output: [0, 1, 4, 9, 16]

# List comprehension way
squares = [x**2 for x in range(5)]
print(squares)  # Output: [0, 1, 4, 9, 16]
```

### Simple Examples

```python
# Squares of numbers
squares = [x**2 for x in range(1, 6)]
print(squares)  # Output: [1, 4, 9, 16, 25]

# Convert to uppercase
words = ["hello", "world", "python"]
uppercase = [word.upper() for word in words]
print(uppercase)  # Output: ['HELLO', 'WORLD', 'PYTHON']

# Even numbers
evens = [x for x in range(10) if x % 2 == 0]
print(evens)  # Output: [0, 2, 4, 6, 8]
```

---

## Nested Lists

Lists can contain other lists, creating nested structures:

```python
# 2D list (matrix)
matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
]

# Accessing elements
print(matrix[0])      # Output: [1, 2, 3]
print(matrix[0][1])   # Output: 2
print(matrix[1][2])   # Output: 6

# Modifying nested lists
matrix[0][0] = 10
print(matrix)  # Output: [[10, 2, 3], [4, 5, 6], [7, 8, 9]]
```

### Working with Nested Lists

```python
# Creating a 3x3 grid
grid = [[0 for _ in range(3)] for _ in range(3)]
print(grid)  # Output: [[0, 0, 0], [0, 0, 0], [0, 0, 0]]

# Accessing rows and columns
matrix = [[1, 2, 3], [4, 5, 6], [7, 8, 9]]
first_row = matrix[0]
first_column = [row[0] for row in matrix]
print(f"First row: {first_row}")      # Output: First row: [1, 2, 3]
print(f"First column: {first_column}")  # Output: First column: [1, 4, 7]
```

---

## Common List Operations

### Length

```python
fruits = ["apple", "banana", "orange"]
length = len(fruits)
print(length)  # Output: 3
```

### Membership Testing

```python
fruits = ["apple", "banana", "orange"]
print("apple" in fruits)   # Output: True
print("grape" in fruits)   # Output: False
print("banana" not in fruits)  # Output: False
```

### Concatenation and Repetition

```python
# Concatenation
list1 = [1, 2, 3]
list2 = [4, 5, 6]
combined = list1 + list2
print(combined)  # Output: [1, 2, 3, 4, 5, 6]

# Repetition
repeated = [1, 2] * 3
print(repeated)  # Output: [1, 2, 1, 2, 1, 2]
```

### Iteration

```python
fruits = ["apple", "banana", "orange"]

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

---

## Practical Examples

### Example 1: Shopping List

```python
shopping_list = []

# Add items
shopping_list.append("milk")
shopping_list.append("bread")
shopping_list.append("eggs")
print(shopping_list)  # Output: ['milk', 'bread', 'eggs']

# Remove item
shopping_list.remove("bread")
print(shopping_list)  # Output: ['milk', 'eggs']

# Check if item exists
if "milk" in shopping_list:
    print("Milk is on the list")
```

### Example 2: Score Tracking

```python
scores = [85, 92, 78, 96, 88]

# Calculate average
average = sum(scores) / len(scores)
print(f"Average: {average}")  # Output: Average: 87.8

# Find highest and lowest
highest = max(scores)
lowest = min(scores)
print(f"Highest: {highest}, Lowest: {lowest}")  # Output: Highest: 96, Lowest: 78

# Sort scores
sorted_scores = sorted(scores)
print(f"Sorted: {sorted_scores}")  # Output: Sorted: [78, 85, 88, 92, 96]
```

### Example 3: Student Records

```python
students = [
    ["Alice", 25, 3.8],
    ["Bob", 23, 3.5],
    ["Charlie", 24, 3.9]
]

# Add new student
students.append(["Diana", 22, 3.7])

# Access student data
for student in students:
    name, age, gpa = student
    print(f"{name}: Age {age}, GPA {gpa}")
```

---

## Common Mistakes and Pitfalls

### 1. Index Out of Range

```python
fruits = ["apple", "banana"]
# print(fruits[5])  # IndexError

# Solution: Check length or use try-except
if len(fruits) > 5:
    print(fruits[5])
```

### 2. Modifying List While Iterating

```python
# Dangerous: Modifying while iterating
numbers = [1, 2, 3, 4, 5]
# for num in numbers:
#     if num % 2 == 0:
#         numbers.remove(num)  # Can cause issues

# Better: Create new list or iterate over copy
numbers = [1, 2, 3, 4, 5]
numbers = [num for num in numbers if num % 2 != 0]
print(numbers)  # Output: [1, 3, 5]
```

### 3. Shallow Copy vs Deep Copy

```python
# Shallow copy (nested lists share references)
original = [[1, 2], [3, 4]]
copy = original.copy()
copy[0][0] = 99
print(original)  # Output: [[99, 2], [3, 4]] (also changed!)

# For nested structures, use deep copy
import copy
original = [[1, 2], [3, 4]]
deep_copy = copy.deepcopy(original)
deep_copy[0][0] = 99
print(original)  # Output: [[1, 2], [3, 4]] (unchanged)
```

### 4. Confusing append() and extend()

```python
# append() adds the whole object
list1 = [1, 2, 3]
list1.append([4, 5])
print(list1)  # Output: [1, 2, 3, [4, 5]]

# extend() adds each element
list2 = [1, 2, 3]
list2.extend([4, 5])
print(list2)  # Output: [1, 2, 3, 4, 5]
```

---

## Practice Exercise

### Exercise: List Manipulation

**Objective**: Create a Python program that demonstrates various list operations and manipulations.

**Instructions**:

1. Create a file called `list_practice.py`

2. Write a program that:
   - Creates lists in different ways
   - Accesses elements using indexing and slicing
   - Modifies lists using various methods
   - Demonstrates list comprehensions
   - Works with nested lists
   - Implements practical list operations

3. Your program should include:
   - A task management system
   - A grade calculator
   - A simple inventory system
   - List manipulation exercises

**Example Solution**:

```python
"""
List Manipulation Practice
This program demonstrates various list operations and manipulations.
"""

print("=" * 60)
print("LIST MANIPULATION PRACTICE")
print("=" * 60)
print()

# 1. Creating Lists
print("1. CREATING LISTS")
print("-" * 60)
# Empty list
empty = []
print(f"Empty list: {empty}")

# List with items
fruits = ["apple", "banana", "orange"]
print(f"Fruits: {fruits}")

# Using list constructor
numbers = list(range(1, 6))
print(f"Numbers: {numbers}")

# Mixed types
mixed = [1, "hello", 3.14, True]
print(f"Mixed: {mixed}")
print()

# 2. Accessing Elements
print("2. ACCESSING ELEMENTS")
print("-" * 60)
fruits = ["apple", "banana", "orange", "grape", "kiwi"]
print(f"Fruits: {fruits}")
print(f"First fruit: {fruits[0]}")
print(f"Last fruit: {fruits[-1]}")
print(f"Middle fruits: {fruits[1:4]}")
print(f"Every other fruit: {fruits[::2]}")
print()

# 3. Modifying Lists
print("3. MODIFYING LISTS")
print("-" * 60)
shopping = ["milk", "bread"]
print(f"Initial: {shopping}")

# Add items
shopping.append("eggs")
print(f"After append: {shopping}")

shopping.insert(0, "butter")
print(f"After insert: {shopping}")

shopping.extend(["cheese", "yogurt"])
print(f"After extend: {shopping}")

# Remove items
shopping.remove("bread")
print(f"After remove: {shopping}")

last_item = shopping.pop()
print(f"Popped item: {last_item}")
print(f"After pop: {shopping}")
print()

# 4. List Methods
print("4. LIST METHODS")
print("-" * 60)
numbers = [3, 1, 4, 1, 5, 9, 2, 6]
print(f"Numbers: {numbers}")
print(f"Length: {len(numbers)}")
print(f"Count of 1: {numbers.count(1)}")
print(f"Index of 4: {numbers.index(4)}")

# Sorting
sorted_numbers = sorted(numbers)
print(f"Sorted: {sorted_numbers}")

numbers.sort(reverse=True)
print(f"Sorted in place (reverse): {numbers}")
print()

# 5. List Comprehensions
print("5. LIST COMPREHENSIONS")
print("-" * 60)
# Squares
squares = [x**2 for x in range(1, 6)]
print(f"Squares: {squares}")

# Even numbers
evens = [x for x in range(10) if x % 2 == 0]
print(f"Even numbers: {evens}")

# Uppercase
words = ["hello", "world", "python"]
uppercase = [word.upper() for word in words]
print(f"Uppercase: {uppercase}")
print()

# 6. Nested Lists
print("6. NESTED LISTS")
print("-" * 60)
matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
]
print(f"Matrix: {matrix}")
print(f"First row: {matrix[0]}")
print(f"Element at [1][2]: {matrix[1][2]}")

# Access column
first_column = [row[0] for row in matrix]
print(f"First column: {first_column}")
print()

# 7. Task Management System
print("7. TASK MANAGEMENT SYSTEM")
print("-" * 60)
tasks = []

# Add tasks
tasks.append("Buy groceries")
tasks.append("Finish homework")
tasks.append("Call dentist")
print(f"Tasks: {tasks}")

# Mark task as done (remove)
if "Buy groceries" in tasks:
    tasks.remove("Buy groceries")
    print("Task 'Buy groceries' completed!")
print(f"Remaining tasks: {tasks}")

# Add priority task
tasks.insert(0, "Urgent: Submit report")
print(f"After adding urgent task: {tasks}")
print()

# 8. Grade Calculator
print("8. GRADE CALCULATOR")
print("-" * 60)
scores = [85, 92, 78, 96, 88, 91, 87]
print(f"Scores: {scores}")

# Statistics
total = sum(scores)
average = total / len(scores)
highest = max(scores)
lowest = min(scores)

print(f"Total: {total}")
print(f"Average: {average:.2f}")
print(f"Highest: {highest}")
print(f"Lowest: {lowest}")

# Letter grades
def get_grade(score):
    if score >= 90:
        return "A"
    elif score >= 80:
        return "B"
    elif score >= 70:
        return "C"
    else:
        return "F"

grades = [get_grade(score) for score in scores]
print(f"Letter grades: {grades}")
print()

# 9. Inventory System
print("9. INVENTORY SYSTEM")
print("-" * 60)
inventory = [
    ["apple", 50, 0.99],
    ["banana", 30, 0.79],
    ["orange", 40, 1.29]
]

print("Current Inventory:")
for item in inventory:
    name, quantity, price = item
    print(f"  {name}: {quantity} units @ ${price:.2f}")

# Add new item
inventory.append(["grape", 25, 1.49])
print("\nAfter adding grapes:")
for item in inventory:
    name, quantity, price = item
    print(f"  {name}: {quantity} units @ ${price:.2f}")

# Update quantity
for item in inventory:
    if item[0] == "apple":
        item[1] = 60  # Update quantity
        break

print("\nAfter updating apple quantity:")
for item in inventory:
    name, quantity, price = item
    print(f"  {name}: {quantity} units @ ${price:.2f}")
print()

# 10. List Operations
print("10. LIST OPERATIONS")
print("-" * 60)
list1 = [1, 2, 3]
list2 = [4, 5, 6]

# Concatenation
combined = list1 + list2
print(f"Combined: {combined}")

# Repetition
repeated = [1, 2] * 3
print(f"Repeated: {repeated}")

# Membership
print(f"2 in list1: {2 in list1}")
print(f"7 in list1: {7 in list1}")

# Copy
copy = list1.copy()
copy.append(4)
print(f"Original: {list1}")
print(f"Copy: {copy}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
LIST MANIPULATION PRACTICE
============================================================

1. CREATING LISTS
------------------------------------------------------------
Empty list: []
Fruits: ['apple', 'banana', 'orange']
Numbers: [1, 2, 3, 4, 5]
Mixed: [1, 'hello', 3.14, True]

[... rest of output ...]
```

**Challenge** (Optional):
- Create a more advanced task management system with priorities
- Build a student gradebook with multiple subjects
- Implement a shopping cart with quantities
- Create a matrix calculator
- Build a text analysis tool using lists

---

## Key Takeaways

1. **Lists are ordered, mutable collections** that can hold any type of data
2. **Indexing starts at 0** - use positive (0, 1, 2...) or negative (-1, -2...) indices
3. **Slicing** `[start:end:step]` extracts portions of lists
4. **Common methods**: `append()`, `extend()`, `insert()`, `remove()`, `pop()`, `sort()`, `reverse()`
5. **List comprehensions** provide a concise way to create lists
6. **Lists can be nested** to create multi-dimensional structures
7. **Lists are mutable** - changes affect the original list
8. **Use `copy()` for shallow copies**, `deepcopy()` for nested structures
9. **Membership testing** with `in` and `not in` is efficient
10. **Lists are versatile** and used extensively in Python programming

---

## Quiz: Lists

Test your understanding with these questions:

1. **What is the index of the first element in a list?**
   - A) 1
   - B) 0
   - C) -1
   - D) None

2. **What does `[1, 2, 3][1:3]` return?**
   - A) `[1, 2]`
   - B) `[2, 3]`
   - C) `[1, 2, 3]`
   - D) `[2]`

3. **What method adds an item to the end of a list?**
   - A) `add()`
   - B) `append()`
   - C) `insert()`
   - D) `extend()`

4. **What is the difference between `append()` and `extend()`?**
   - A) No difference
   - B) `append()` adds one item, `extend()` adds multiple items
   - C) `append()` adds to beginning, `extend()` adds to end
   - D) `append()` is faster

5. **What does `[1, 2, 3].pop()` return?**
   - A) `1`
   - B) `2`
   - C) `3`
   - D) `None`

6. **How do you reverse a list?**
   - A) `list.reverse()`
   - B) `list[::-1]`
   - C) `reversed(list)`
   - D) All of the above

7. **What does `[x**2 for x in range(3)]` create?**
   - A) `[0, 1, 4]`
   - B) `[1, 4, 9]`
   - C) `[0, 2, 4]`
   - D) Error

8. **What is the result of `[1, 2] + [3, 4]`?**
   - A) `[1, 2, 3, 4]`
   - B) `[4, 6]`
   - C) `[1, 2, [3, 4]]`
   - D) Error

9. **What does `len([1, 2, 3])` return?**
   - A) `3`
   - B) `2`
   - C) `4`
   - D) Error

10. **How do you access the last element of a list?**
    - A) `list[last]`
    - B) `list[-1]`
    - C) `list[len(list)]`
    - D) `list.last()`

**Answers**:
1. B) 0 (Python uses 0-based indexing)
2. B) `[2, 3]` (slicing from index 1 to 3, exclusive of end)
3. B) `append()` (adds item to end)
4. B) `append()` adds one item, `extend()` adds multiple items
5. C) `3` (pop() without argument removes and returns last item)
6. D) All of the above (multiple ways to reverse)
7. A) `[0, 1, 4]` (squares of 0, 1, 2)
8. A) `[1, 2, 3, 4]` (list concatenation)
9. A) `3` (length of list with 3 elements)
10. B) `list[-1]` (negative indexing from end)

---

## Next Steps

Excellent work! You've mastered lists. You now understand:
- How to create and manipulate lists
- Indexing and slicing
- Common list methods
- List comprehensions basics
- Working with nested lists
- Practical applications

**What's Next?**
- Lesson 3.2: Tuples
- Lesson 3.3: Nested Data Structures
- Practice building more complex list-based programs
- Learn about advanced list operations

---

## Additional Resources

- **Python Lists Documentation**: [docs.python.org/3/tutorial/datastructures.html#more-on-lists](https://docs.python.org/3/tutorial/datastructures.html#more-on-lists)
- **List Methods**: [docs.python.org/3/tutorial/datastructures.html#list-methods](https://docs.python.org/3/tutorial/datastructures.html#list-methods)
- **List Comprehensions**: [docs.python.org/3/tutorial/datastructures.html#list-comprehensions](https://docs.python.org/3/tutorial/datastructures.html#list-comprehensions)

---

*Lesson completed! You're ready to move on to the next lesson.*

