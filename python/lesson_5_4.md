# Lesson 5.4: Loop Techniques

## Learning Objectives

By the end of this lesson, you will be able to:
- Use the enumerate() function effectively
- Understand and use the zip() function
- Combine enumerate() and zip() in loops
- Use advanced list comprehension techniques
- Apply loop techniques in practical scenarios
- Write more Pythonic and efficient loop code
- Understand when to use different loop techniques
- Optimize loop performance

---

## Introduction to Loop Techniques

Python provides several built-in functions and techniques that make loops more powerful, readable, and efficient. These techniques help you write more Pythonic code and handle common looping scenarios elegantly.

### Key Techniques Covered

- **enumerate()** - Get index and value simultaneously
- **zip()** - Iterate over multiple sequences in parallel
- **Advanced comprehensions** - More complex list/dict/set comprehensions
- **Combining techniques** - Using multiple techniques together

---

## The enumerate() Function

The `enumerate()` function adds a counter to an iterable, returning tuples of (index, value).

### Basic Syntax

```python
enumerate(iterable, start=0)
```

### Basic Usage

```python
# Without enumerate (less Pythonic)
fruits = ["apple", "banana", "orange"]
for i in range(len(fruits)):
    print(f"{i}: {fruits[i]}")

# With enumerate (more Pythonic)
fruits = ["apple", "banana", "orange"]
for index, fruit in enumerate(fruits):
    print(f"{index}: {fruit}")
# Output:
# 0: apple
# 1: banana
# 2: orange
```

### Custom Start Value

```python
# Start counting from 1
fruits = ["apple", "banana", "orange"]
for index, fruit in enumerate(fruits, start=1):
    print(f"{index}. {fruit}")
# Output:
# 1. apple
# 2. banana
# 3. orange

# Start from any number
for index, fruit in enumerate(fruits, start=10):
    print(f"{index}: {fruit}")
# Output:
# 10: apple
# 11: banana
# 12: orange
```

### Practical Examples

```python
# Numbered list
tasks = ["Buy groceries", "Finish homework", "Call dentist"]
print("To-do list:")
for i, task in enumerate(tasks, 1):
    print(f"{i}. {task}")

# Finding index of item
names = ["Alice", "Bob", "Charlie", "Diana"]
search = "Charlie"
for index, name in enumerate(names):
    if name == search:
        print(f"Found {search} at index {index}")
        break

# Processing with index
scores = [85, 92, 78, 96, 88]
for i, score in enumerate(scores):
    if score < 80:
        print(f"Student {i} needs improvement (score: {score})")
```

### When to Use enumerate()

✅ **Use enumerate() when**:
- You need both index and value
- You're tracking position in a sequence
- You need to modify elements by index
- You want more readable code than `range(len())`

---

## The zip() Function

The `zip()` function combines multiple iterables element-wise, creating tuples of corresponding elements.

### Basic Syntax

```python
zip(iterable1, iterable2, ...)
```

### Basic Usage

```python
# Combine two lists
names = ["Alice", "Bob", "Charlie"]
ages = [25, 23, 24]

for name, age in zip(names, ages):
    print(f"{name} is {age} years old")
# Output:
# Alice is 25 years old
# Bob is 23 years old
# Charlie is 24 years old

# Without zip (less elegant)
for i in range(len(names)):
    print(f"{names[i]} is {ages[i]} years old")
```

### Multiple Sequences

```python
# Combine three sequences
names = ["Alice", "Bob", "Charlie"]
ages = [25, 23, 24]
cities = ["NYC", "LA", "Chicago"]

for name, age, city in zip(names, ages, cities):
    print(f"{name}, age {age}, lives in {city}")
# Output:
# Alice, age 25, lives in NYC
# Bob, age 23, lives in LA
# Charlie, age 24, lives in Chicago
```

### Different Length Sequences

```python
# zip() stops at shortest sequence
list1 = [1, 2, 3, 4, 5]
list2 = ["a", "b", "c"]

for num, letter in zip(list1, list2):
    print(f"{num}: {letter}")
# Output:
# 1: a
# 2: b
# 3: c
# (Stops at 3, even though list1 has 5 elements)
```

### Converting to List/Dict

```python
# Convert zip to list
names = ["Alice", "Bob", "Charlie"]
ages = [25, 23, 24]
pairs = list(zip(names, ages))
print(pairs)  # Output: [('Alice', 25), ('Bob', 23), ('Charlie', 24)]

# Convert to dictionary
name_age_dict = dict(zip(names, ages))
print(name_age_dict)  # Output: {'Alice': 25, 'Bob': 23, 'Charlie': 24}
```

### Unzipping (Unpacking)

```python
# Zip and then unzip
pairs = [('Alice', 25), ('Bob', 23), ('Charlie', 24)]
names, ages = zip(*pairs)
print(names)  # Output: ('Alice', 'Bob', 'Charlie')
print(ages)   # Output: (25, 23, 24)
```

### Practical Examples

```python
# Combining data from multiple sources
students = ["Alice", "Bob", "Charlie"]
scores_math = [85, 90, 75]
scores_science = [92, 88, 80]

for student, math, science in zip(students, scores_math, scores_science):
    average = (math + science) / 2
    print(f"{student}: Math={math}, Science={science}, Avg={average}")

# Creating dictionaries from two lists
keys = ["name", "age", "city"]
values = ["Alice", 25, "NYC"]
person = dict(zip(keys, values))
print(person)  # Output: {'name': 'Alice', 'age': 25, 'city': 'NYC'}
```

### When to Use zip()

✅ **Use zip() when**:
- You need to iterate over multiple sequences simultaneously
- You're combining related data from different sources
- You want to create dictionaries from two lists
- You're processing parallel data structures

---

## Combining enumerate() and zip()

You can combine `enumerate()` and `zip()` for powerful iterations.

### Basic Combination

```python
# Enumerate and zip together
names = ["Alice", "Bob", "Charlie"]
ages = [25, 23, 24]

for index, (name, age) in enumerate(zip(names, ages)):
    print(f"{index}: {name} is {age} years old")
# Output:
# 0: Alice is 25 years old
# 1: Bob is 23 years old
# 2: Charlie is 24 years old
```

### Practical Example

```python
# Process multiple lists with index
students = ["Alice", "Bob", "Charlie"]
scores_math = [85, 90, 75]
scores_science = [92, 88, 80]

print("Student Report:")
for i, (student, math, science) in enumerate(zip(students, scores_math, scores_science), 1):
    average = (math + science) / 2
    print(f"{i}. {student}: Math={math}, Science={science}, Average={average:.1f}")
```

---

## Advanced List Comprehensions

List comprehensions can be combined with enumerate() and zip() for powerful one-liners.

### enumerate() in Comprehensions

```python
# Create list of (index, value) pairs
fruits = ["apple", "banana", "orange"]
indexed = [(i, fruit) for i, fruit in enumerate(fruits)]
print(indexed)  # Output: [(0, 'apple'), (1, 'banana'), (2, 'orange')]

# Create dictionary with enumerate
fruits = ["apple", "banana", "orange"]
fruit_dict = {i: fruit for i, fruit in enumerate(fruits)}
print(fruit_dict)  # Output: {0: 'apple', 1: 'banana', 2: 'orange'}

# Filter with enumerate
numbers = [10, 20, 30, 40, 50]
# Get indices of even numbers
even_indices = [i for i, num in enumerate(numbers) if num % 20 == 0]
print(even_indices)  # Output: [0, 1, 2, 3, 4] (all are multiples of 20)
```

### zip() in Comprehensions

```python
# Combine lists in comprehension
names = ["Alice", "Bob", "Charlie"]
ages = [25, 23, 24]
people = [(name, age) for name, age in zip(names, ages)]
print(people)  # Output: [('Alice', 25), ('Bob', 23), ('Charlie', 24)]

# Create dictionary from two lists
keys = ["name", "age", "city"]
values = ["Alice", 25, "NYC"]
person = {k: v for k, v in zip(keys, values)}
print(person)  # Output: {'name': 'Alice', 'age': 25, 'city': 'NYC'}

# Process multiple lists
students = ["Alice", "Bob"]
scores_math = [85, 90]
scores_science = [92, 88]
averages = [(s, (m + sc) / 2) for s, m, sc in zip(students, scores_math, scores_science)]
print(averages)  # Output: [('Alice', 88.5), ('Bob', 89.0)]
```

### Nested Comprehensions with Techniques

```python
# Nested list with enumerate
matrix = [[1, 2, 3], [4, 5, 6], [7, 8, 9]]
# Get all elements with their (row, col) indices
elements = [(i, j, matrix[i][j]) for i, row in enumerate(matrix) 
            for j, val in enumerate(row)]
print(elements[:3])  # Output: [(0, 0, 1), (0, 1, 2), (0, 2, 3)]
```

---

## Other Useful Loop Functions

### reversed()

Iterate over a sequence in reverse order.

```python
# Reverse iteration
fruits = ["apple", "banana", "orange"]
for fruit in reversed(fruits):
    print(fruit)
# Output:
# orange
# banana
# apple

# With enumerate
for i, fruit in enumerate(reversed(fruits)):
    print(f"{i}: {fruit}")
# Output:
# 0: orange
# 1: banana
# 2: apple
```

### sorted()

Iterate over a sequence in sorted order (without modifying original).

```python
# Iterate in sorted order
numbers = [3, 1, 4, 1, 5, 9, 2, 6]
for num in sorted(numbers):
    print(num)
# Output: 1, 1, 2, 3, 4, 5, 6, 9

# Sorted with key function
students = [("Alice", 25), ("Bob", 23), ("Charlie", 24)]
for name, age in sorted(students, key=lambda x: x[1]):  # Sort by age
    print(f"{name}: {age}")
```

---

## Practical Examples

### Example 1: Processing Parallel Data

```python
# Student data from different sources
student_ids = [101, 102, 103]
names = ["Alice", "Bob", "Charlie"]
scores = [85, 90, 75]

# Process together
for student_id, name, score in zip(student_ids, names, scores):
    grade = "A" if score >= 90 else "B" if score >= 80 else "C"
    print(f"ID {student_id}: {name} - Score: {score}, Grade: {grade}")
```

### Example 2: Creating Lookup Tables

```python
# Create lookup dictionary
categories = ["fruit", "vegetable", "fruit", "vegetable"]
items = ["apple", "carrot", "banana", "lettuce"]

# Using zip to create dictionary
item_category = dict(zip(items, categories))
print(item_category)  # Output: {'apple': 'fruit', 'carrot': 'vegetable', ...}

# Reverse lookup
category_items = {}
for item, category in zip(items, categories):
    if category not in category_items:
        category_items[category] = []
    category_items[category].append(item)
print(category_items)
```

### Example 3: Data Transformation

```python
# Transform data structure
old_format = [("Alice", 25), ("Bob", 23), ("Charlie", 24)]
# Convert to dictionary with enumerated keys
new_format = {i: {"name": name, "age": age} 
              for i, (name, age) in enumerate(old_format)}
print(new_format)
```

### Example 4: Finding Differences

```python
# Compare two lists
list1 = [1, 2, 3, 4, 5]
list2 = [1, 2, 9, 4, 5]

# Find differences with index
differences = [(i, a, b) for i, (a, b) in enumerate(zip(list1, list2)) 
               if a != b]
print(differences)  # Output: [(2, 3, 9)]
```

---

## Performance Considerations

### enumerate() vs range(len())

```python
# enumerate() is more Pythonic and slightly more efficient
fruits = ["apple", "banana", "orange"]

# Less efficient
for i in range(len(fruits)):
    print(f"{i}: {fruits[i]}")

# More efficient and Pythonic
for i, fruit in enumerate(fruits):
    print(f"{i}: {fruit}")
```

### zip() vs Manual Indexing

```python
# zip() is cleaner and more readable
names = ["Alice", "Bob"]
ages = [25, 23]

# Manual indexing (error-prone)
for i in range(len(names)):
    print(f"{names[i]}: {ages[i]}")

# Using zip() (cleaner)
for name, age in zip(names, ages):
    print(f"{name}: {age}")
```

### Memory Considerations

```python
# zip() returns an iterator (lazy evaluation)
# It doesn't create the full list in memory
names = ["Alice", "Bob", "Charlie"]
ages = [25, 23, 24]

# This is memory efficient
for name, age in zip(names, ages):
    print(f"{name}: {age}")

# If you need the full list
pairs = list(zip(names, ages))  # Creates list in memory
```

---

## Common Patterns

### Pattern 1: Numbered Output

```python
# Add line numbers
lines = ["First line", "Second line", "Third line"]
for i, line in enumerate(lines, 1):
    print(f"{i}. {line}")
```

### Pattern 2: Parallel Processing

```python
# Process multiple related lists
keys = ["name", "age", "city"]
values = ["Alice", 25, "NYC"]
for key, value in zip(keys, values):
    print(f"{key}: {value}")
```

### Pattern 3: Finding Positions

```python
# Find all positions of an item
items = ["apple", "banana", "apple", "orange", "apple"]
target = "apple"
positions = [i for i, item in enumerate(items) if item == target]
print(positions)  # Output: [0, 2, 4]
```

### Pattern 4: Pairwise Processing

```python
# Process adjacent pairs
numbers = [1, 2, 3, 4, 5]
pairs = list(zip(numbers, numbers[1:]))
for a, b in pairs:
    print(f"Pair: ({a}, {b})")
# Output:
# Pair: (1, 2)
# Pair: (2, 3)
# Pair: (3, 4)
# Pair: (4, 5)
```

---

## Common Mistakes and Pitfalls

### 1. Forgetting enumerate() Returns Tuples

```python
# Wrong: trying to unpack incorrectly
# for index, value in enumerate([1, 2, 3]):
#     print(index, value)  # This actually works!

# But be careful with nested structures
data = [(1, 2), (3, 4), (5, 6)]
# for i, x, y in enumerate(data):  # Error! enumerate returns (i, (x, y))
for i, (x, y) in enumerate(data):  # Correct
    print(i, x, y)
```

### 2. zip() with Different Lengths

```python
# zip() stops at shortest sequence - be aware!
list1 = [1, 2, 3, 4, 5]
list2 = ["a", "b"]
for num, letter in zip(list1, list2):
    print(num, letter)  # Only processes first 2 items!
```

### 3. Modifying During Iteration

```python
# Be careful modifying sequences you're iterating over
fruits = ["apple", "banana", "orange"]
# for i, fruit in enumerate(fruits):
#     if fruit == "banana":
#         fruits.remove(fruit)  # Can cause issues!

# Better: create new list
fruits = ["apple", "banana", "orange"]
filtered = [fruit for i, fruit in enumerate(fruits) if fruit != "banana"]
```

---

## Practice Exercise

### Exercise: Loop Techniques Practice

**Objective**: Create a Python program that demonstrates various loop techniques and their combinations.

**Instructions**:

1. Create a file called `loop_techniques_practice.py`

2. Write a program that:
   - Uses enumerate() in various ways
   - Uses zip() to combine sequences
   - Combines enumerate() and zip()
   - Uses advanced comprehensions
   - Implements practical loop-based solutions

3. Your program should include:
   - Numbered lists
   - Parallel data processing
   - Data transformation
   - Lookup table creation
   - Pattern finding

**Example Solution**:

```python
"""
Loop Techniques Practice
This program demonstrates various loop techniques and their combinations.
"""

print("=" * 60)
print("LOOP TECHNIQUES PRACTICE")
print("=" * 60)
print()

# 1. Basic enumerate()
print("1. BASIC enumerate()")
print("-" * 60)
fruits = ["apple", "banana", "orange"]
print("With default start (0):")
for index, fruit in enumerate(fruits):
    print(f"  {index}: {fruit}")

print("\nWith custom start (1):")
for index, fruit in enumerate(fruits, start=1):
    print(f"  {index}. {fruit}")
print()

# 2. enumerate() with Conditions
print("2. enumerate() WITH CONDITIONS")
print("-" * 60)
scores = [85, 92, 78, 96, 88]
print(f"Scores: {scores}")
print("Students needing improvement (score < 80):")
for i, score in enumerate(scores):
    if score < 80:
        print(f"  Student {i}: {score}")
print()

# 3. Basic zip()
print("3. BASIC zip()")
print("-" * 60)
names = ["Alice", "Bob", "Charlie"]
ages = [25, 23, 24]

print("Combining names and ages:")
for name, age in zip(names, ages):
    print(f"  {name} is {age} years old")
print()

# 4. zip() with Multiple Sequences
print("4. zip() WITH MULTIPLE SEQUENCES")
print("-" * 60)
students = ["Alice", "Bob", "Charlie"]
scores_math = [85, 90, 75]
scores_science = [92, 88, 80]

print("Student scores:")
for student, math, science in zip(students, scores_math, scores_science):
    average = (math + science) / 2
    print(f"  {student}: Math={math}, Science={science}, Avg={average:.1f}")
print()

# 5. zip() to Create Dictionary
print("5. zip() TO CREATE DICTIONARY")
print("-" * 60)
keys = ["name", "age", "city"]
values = ["Alice", 25, "NYC"]

person = dict(zip(keys, values))
print(f"Dictionary from zip(): {person}")

# Multiple dictionaries
students = ["Alice", "Bob", "Charlie"]
ages = [25, 23, 24]
people = [dict(zip(["name", "age"], [s, a])) for s, a in zip(students, ages)]
print(f"List of dictionaries: {people}")
print()

# 6. Combining enumerate() and zip()
print("6. COMBINING enumerate() AND zip()")
print("-" * 60)
names = ["Alice", "Bob", "Charlie"]
ages = [25, 23, 24]

print("Numbered list with multiple values:")
for i, (name, age) in enumerate(zip(names, ages), 1):
    print(f"  {i}. {name}, age {age}")
print()

# 7. enumerate() in List Comprehension
print("7. enumerate() IN LIST COMPREHENSION")
print("-" * 60)
fruits = ["apple", "banana", "orange"]

# Create list of (index, fruit) pairs
indexed = [(i, fruit) for i, fruit in enumerate(fruits)]
print(f"Indexed list: {indexed}")

# Create dictionary
fruit_dict = {i: fruit for i, fruit in enumerate(fruits)}
print(f"Dictionary: {fruit_dict}")

# Find positions of specific items
items = ["apple", "banana", "apple", "orange", "apple"]
target = "apple"
positions = [i for i, item in enumerate(items) if item == target]
print(f"Positions of '{target}' in {items}: {positions}")
print()

# 8. zip() in List Comprehension
print("8. zip() IN LIST COMPREHENSION")
print("-" * 60)
names = ["Alice", "Bob", "Charlie"]
ages = [25, 23, 24]

# Create list of tuples
people = [(name, age) for name, age in zip(names, ages)]
print(f"People tuples: {people}")

# Create dictionary
name_age_dict = {name: age for name, age in zip(names, ages)}
print(f"Name-age dictionary: {name_age_dict}")

# Process and transform
students = ["Alice", "Bob"]
scores_math = [85, 90]
scores_science = [92, 88]
averages = [(s, (m + sc) / 2) for s, m, sc in zip(students, scores_math, scores_science)]
print(f"Student averages: {averages}")
print()

# 9. Finding Differences
print("9. FINDING DIFFERENCES")
print("-" * 60)
list1 = [1, 2, 3, 4, 5]
list2 = [1, 2, 9, 4, 5]

print(f"List 1: {list1}")
print(f"List 2: {list2}")

differences = [(i, a, b) for i, (a, b) in enumerate(zip(list1, list2)) if a != b]
print("Differences (index, list1_value, list2_value):")
for i, a, b in differences:
    print(f"  Index {i}: {a} != {b}")
print()

# 10. Parallel Data Processing
print("10. PARALLEL DATA PROCESSING")
print("-" * 60)
student_ids = [101, 102, 103]
names = ["Alice", "Bob", "Charlie"]
scores = [85, 90, 75]

print("Student reports:")
for student_id, name, score in zip(student_ids, names, scores):
    grade = "A" if score >= 90 else "B" if score >= 80 else "C"
    print(f"  ID {student_id}: {name} - Score: {score}, Grade: {grade}")
print()

# 11. Creating Lookup Tables
print("11. CREATING LOOKUP TABLES")
print("-" * 60)
categories = ["fruit", "vegetable", "fruit", "vegetable"]
items = ["apple", "carrot", "banana", "lettuce"]

# Item to category
item_category = dict(zip(items, categories))
print(f"Item to category: {item_category}")

# Category to items (grouping)
category_items = {}
for item, category in zip(items, categories):
    if category not in category_items:
        category_items[category] = []
    category_items[category].append(item)
print(f"Category to items: {category_items}")
print()

# 12. reversed() and sorted()
print("12. reversed() AND sorted()")
print("-" * 60)
fruits = ["apple", "banana", "orange"]

print("Reversed iteration:")
for fruit in reversed(fruits):
    print(f"  {fruit}")

print("\nReversed with enumerate:")
for i, fruit in enumerate(reversed(fruits)):
    print(f"  {i}: {fruit}")

numbers = [3, 1, 4, 1, 5, 9, 2, 6]
print(f"\nSorted iteration of {numbers}:")
for num in sorted(numbers):
    print(f"  {num}")
print()

# 13. Pairwise Processing
print("13. PAIRWISE PROCESSING")
print("-" * 60)
numbers = [1, 2, 3, 4, 5]
print(f"Processing pairs from {numbers}:")
pairs = list(zip(numbers, numbers[1:]))
for a, b in pairs:
    print(f"  Pair: ({a}, {b})")
print()

# 14. Data Transformation
print("14. DATA TRANSFORMATION")
print("-" * 60)
old_format = [("Alice", 25), ("Bob", 23), ("Charlie", 24)]
print(f"Old format: {old_format}")

# Transform to dictionary with enumerated keys
new_format = {i: {"name": name, "age": age} 
              for i, (name, age) in enumerate(old_format)}
print("New format (dictionary):")
for key, value in new_format.items():
    print(f"  {key}: {value}")
print()

# 15. Complex Combination
print("15. COMPLEX COMBINATION")
print("-" * 60)
students = ["Alice", "Bob", "Charlie"]
scores_math = [85, 90, 75]
scores_science = [92, 88, 80]

print("Student report with rankings:")
# Calculate averages and sort
student_data = [(name, (math + science) / 2, math, science) 
                for name, math, science in zip(students, scores_math, scores_science)]
student_data.sort(key=lambda x: x[1], reverse=True)  # Sort by average

for rank, (name, avg, math, science) in enumerate(student_data, 1):
    print(f"  {rank}. {name}: Math={math}, Science={science}, Average={avg:.1f}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
LOOP TECHNIQUES PRACTICE
============================================================

1. BASIC enumerate()
------------------------------------------------------------
With default start (0):
  0: apple
  1: banana
  2: orange

With custom start (1):
  1. apple
  2. banana
  3. orange

[... rest of output ...]
```

**Challenge** (Optional):
- Create a data analysis tool using these techniques
- Build a report generator with numbered sections
- Implement a data comparison utility
- Create a transformation pipeline
- Build a lookup system generator

---

## Key Takeaways

1. **enumerate() adds counters** - Get index and value simultaneously
2. **zip() combines sequences** - Iterate over multiple sequences in parallel
3. **Combine techniques** - enumerate() and zip() work well together
4. **Use in comprehensions** - Both work great in list/dict comprehensions
5. **More Pythonic** - These techniques make code more readable and efficient
6. **Memory efficient** - zip() uses lazy evaluation (iterator)
7. **Watch sequence lengths** - zip() stops at shortest sequence
8. **reversed() and sorted()** - Useful for iteration order control
9. **Practical applications** - Parallel processing, data transformation, lookups
10. **Performance** - Generally more efficient than manual indexing

---

## Quiz: Loop Techniques

Test your understanding with these questions:

1. **What does `enumerate()` return?**
   - A) Just the index
   - B) Just the value
   - C) Tuples of (index, value)
   - D) A list

2. **What is the default start value for `enumerate()`?**
   - A) 1
   - B) 0
   - C) -1
   - D) None

3. **What does `zip()` do?**
   - A) Combines sequences element-wise
   - B) Sorts sequences
   - C) Reverses sequences
   - D) Filters sequences

4. **What happens when zip() receives sequences of different lengths?**
   - A) Error
   - B) Stops at shortest sequence
   - C) Pads with None
   - D) Continues with longest

5. **How do you create a dictionary from two lists using zip()?**
   - A) `dict(zip(list1, list2))`
   - B) `zip(dict(list1, list2))`
   - C) `{zip(list1, list2)}`
   - D) `zip().dict(list1, list2)`

6. **What is the output of: `list(enumerate(['a', 'b'], start=1))`?**
   - A) `[(0, 'a'), (1, 'b')]`
   - B) `[(1, 'a'), (2, 'b')]`
   - C) `[1, 'a', 2, 'b']`
   - D) Error

7. **How do you iterate backwards over a list?**
   - A) `for item in list.reverse():`
   - B) `for item in reversed(list):`
   - C) `for item in list[::-1]:`
   - D) Both B and C

8. **What does `zip(*pairs)` do?**
   - A) Creates pairs
   - B) Unzips (unpacks) pairs
   - C) Sorts pairs
   - D) Filters pairs

9. **When should you use enumerate() instead of range(len())?**
   - A) Always
   - B) When you need both index and value
   - C) Never
   - D) Only with lists

10. **What is the result of: `list(zip([1, 2], ['a', 'b', 'c']))`?**
    - A) `[(1, 'a'), (2, 'b'), (None, 'c')]`
    - B) `[(1, 'a'), (2, 'b')]`
    - C) Error
    - D) `[1, 'a', 2, 'b']`

**Answers**:
1. C) Tuples of (index, value) (enumerate returns iterator of tuples)
2. B) 0 (default start is 0)
3. A) Combines sequences element-wise (creates tuples of corresponding elements)
4. B) Stops at shortest sequence (zip stops when shortest iterable is exhausted)
5. A) `dict(zip(list1, list2))` (zip creates pairs, dict converts to dictionary)
6. B) `[(1, 'a'), (2, 'b')]` (enumerate with start=1)
7. D) Both B and C (reversed() and slicing both work)
8. B) Unzips (unpacks) pairs (* operator unpacks)
9. B) When you need both index and value (more Pythonic than range(len()))
10. B) `[(1, 'a'), (2, 'b')]` (stops at shortest sequence)

---

## Next Steps

Excellent work! You've mastered loop techniques. You now understand:
- How to use enumerate() effectively
- How to use zip() for parallel iteration
- Combining enumerate() and zip()
- Advanced comprehensions with these techniques
- Practical applications and patterns

**What's Next?**
- Module 6: Functions
- Practice combining these techniques in real projects
- Learn about more advanced iteration patterns
- Explore generator expressions and iterators

---

## Additional Resources

- **enumerate()**: [docs.python.org/3/library/functions.html#enumerate](https://docs.python.org/3/library/functions.html#enumerate)
- **zip()**: [docs.python.org/3/library/functions.html#zip](https://docs.python.org/3/library/functions.html#zip)
- **Built-in Functions**: [docs.python.org/3/library/functions.html](https://docs.python.org/3/library/functions.html)

---

*Lesson completed! You're ready to move on to the next lesson.*

