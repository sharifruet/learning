# Lesson 5.2: Loops - For Loops

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what loops are and why they're useful
- Use for loops to iterate over sequences
- Work with the range() function
- Iterate over different data types (lists, strings, dictionaries, etc.)
- Use enumerate() to get both index and value
- Understand nested for loops
- Use loop control statements (break, continue, pass)
- Apply for loops in practical programming scenarios
- Write efficient and readable loop code

---

## Introduction to Loops

**Loops** allow you to execute a block of code repeatedly. They are essential for processing collections of data, performing repetitive tasks, and automating operations.

Python provides two main types of loops:
- **for loops** - iterate over a sequence (this lesson)
- **while loops** - execute while a condition is True (next lesson)

---

## The for Loop

The `for` loop iterates over a sequence (list, tuple, string, dictionary, etc.) and executes code for each item.

### Basic Syntax

```python
for item in sequence:
    # Code to execute for each item
    statement1
    statement2
```

**Important**:
- The loop variable (`item`) takes each value from the sequence
- The code block is indented
- The loop continues until all items are processed

### Simple Examples

```python
# Iterate over a list
fruits = ["apple", "banana", "orange"]
for fruit in fruits:
    print(fruit)
# Output:
# apple
# banana
# orange

# Iterate over a string
word = "Python"
for char in word:
    print(char)
# Output:
# P
# y
# t
# h
# o
# n

# Iterate over a tuple
numbers = (1, 2, 3, 4, 5)
for num in numbers:
    print(num * 2)
# Output:
# 2
# 4
# 6
# 8
# 10
```

---

## The range() Function

The `range()` function generates a sequence of numbers, commonly used with for loops.

### Basic range() Syntax

```python
range(stop)              # 0 to stop-1
range(start, stop)       # start to stop-1
range(start, stop, step) # start to stop-1 with step
```

### Examples

```python
# range(stop) - starts at 0
for i in range(5):
    print(i)
# Output:
# 0
# 1
# 2
# 3
# 4

# range(start, stop)
for i in range(2, 6):
    print(i)
# Output:
# 2
# 3
# 4
# 5

# range(start, stop, step)
for i in range(0, 10, 2):
    print(i)
# Output:
# 0
# 2
# 4
# 6
# 8

# Negative step (count backwards)
for i in range(10, 0, -1):
    print(i)
# Output:
# 10
# 9
# 8
# 7
# 6
# 5
# 4
# 3
# 2
# 1
```

### Common range() Patterns

```python
# Count from 1 to 10
for i in range(1, 11):
    print(i)

# Count even numbers
for i in range(0, 10, 2):
    print(i)

# Count backwards
for i in range(10, 0, -1):
    print(i)

# Generate list of numbers
numbers = list(range(5))
print(numbers)  # Output: [0, 1, 2, 3, 4]
```

---

## Iterating Over Different Data Types

### Lists

```python
# Iterate over list items
fruits = ["apple", "banana", "orange"]
for fruit in fruits:
    print(f"I like {fruit}")

# Iterate with index using range()
fruits = ["apple", "banana", "orange"]
for i in range(len(fruits)):
    print(f"{i}: {fruits[i]}")

# Better: Use enumerate() (covered later)
```

### Strings

```python
# Iterate over characters
word = "Python"
for char in word:
    print(char)

# Iterate over words in a sentence
sentence = "Hello world Python"
for word in sentence.split():
    print(word)
```

### Tuples

```python
# Iterate over tuple items
coordinates = (10, 20), (30, 40), (50, 60)
for x, y in coordinates:
    print(f"Point: ({x}, {y})")
```

### Dictionaries

```python
# Iterate over keys (default)
student = {"name": "Alice", "age": 25, "gpa": 3.8}
for key in student:
    print(key)
# Output:
# name
# age
# gpa

# Iterate over keys explicitly
for key in student.keys():
    print(key)

# Iterate over values
for value in student.values():
    print(value)
# Output:
# Alice
# 25
# 3.8

# Iterate over key-value pairs
for key, value in student.items():
    print(f"{key}: {value}")
# Output:
# name: Alice
# age: 25
# gpa: 3.8
```

### Sets

```python
# Iterate over set elements
fruits = {"apple", "banana", "orange"}
for fruit in fruits:
    print(fruit)
# Note: Order may vary (sets are unordered)
```

---

## Using enumerate()

The `enumerate()` function adds a counter to an iterable, returning both index and value.

### Basic Syntax

```python
for index, value in enumerate(sequence):
    # Use both index and value
    statement
```

### Examples

```python
# Basic enumerate
fruits = ["apple", "banana", "orange"]
for index, fruit in enumerate(fruits):
    print(f"{index}: {fruit}")
# Output:
# 0: apple
# 1: banana
# 2: orange

# Start counting from 1
for index, fruit in enumerate(fruits, start=1):
    print(f"{index}. {fruit}")
# Output:
# 1. apple
# 2. banana
# 3. orange

# Practical use
students = ["Alice", "Bob", "Charlie"]
for i, name in enumerate(students, 1):
    print(f"Student {i}: {name}")
```

### When to Use enumerate()

```python
# Without enumerate (less Pythonic)
fruits = ["apple", "banana", "orange"]
for i in range(len(fruits)):
    print(f"{i}: {fruits[i]}")

# With enumerate (more Pythonic)
for i, fruit in enumerate(fruits):
    print(f"{i}: {fruit}")
```

---

## Nested For Loops

You can nest for loops to iterate over multiple dimensions.

### Basic Syntax

```python
for outer_item in outer_sequence:
    # Outer loop code
    for inner_item in inner_sequence:
        # Inner loop code
        statement
```

### Examples

```python
# Multiplication table
for i in range(1, 4):
    for j in range(1, 4):
        print(f"{i} x {j} = {i * j}")
# Output:
# 1 x 1 = 1
# 1 x 2 = 2
# 1 x 3 = 3
# 2 x 1 = 2
# ...

# Iterate over 2D list
matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
]

for row in matrix:
    for element in row:
        print(element, end=" ")
    print()  # New line after each row
# Output:
# 1 2 3
# 4 5 6
# 7 8 9

# With indices
for i in range(len(matrix)):
    for j in range(len(matrix[i])):
        print(f"matrix[{i}][{j}] = {matrix[i][j]}")
```

### Real-World Example

```python
# Find pairs in a list
numbers = [1, 2, 3, 4]
for i in range(len(numbers)):
    for j in range(i + 1, len(numbers)):
        print(f"Pair: ({numbers[i]}, {numbers[j]})")
# Output:
# Pair: (1, 2)
# Pair: (1, 3)
# Pair: (1, 4)
# Pair: (2, 3)
# Pair: (2, 4)
# Pair: (3, 4)
```

---

## Loop Control Statements

### break Statement

The `break` statement exits the loop immediately.

```python
# Find first even number
numbers = [1, 3, 5, 8, 9, 10]
for num in numbers:
    if num % 2 == 0:
        print(f"First even number: {num}")
        break
# Output: First even number: 8

# Search in list
names = ["Alice", "Bob", "Charlie", "Diana"]
search = "Charlie"
for name in names:
    if name == search:
        print(f"Found {search}!")
        break
else:
    print(f"{search} not found")
```

### continue Statement

The `continue` statement skips the rest of the current iteration and continues with the next.

```python
# Print only even numbers
numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
for num in numbers:
    if num % 2 != 0:  # Skip odd numbers
        continue
    print(num)
# Output:
# 2
# 4
# 6
# 8
# 10

# Skip invalid data
scores = [85, -1, 92, 78, -1, 96]
valid_scores = []
for score in scores:
    if score < 0:  # Skip invalid scores
        continue
    valid_scores.append(score)
print(valid_scores)  # Output: [85, 92, 78, 96]
```

### pass Statement

The `pass` statement does nothing - used as a placeholder.

```python
# Placeholder for future code
for i in range(5):
    if i == 3:
        pass  # Do nothing, but syntax requires something
    else:
        print(i)

# Common use: empty loop body
for item in items:
    pass  # Will implement later
```

### else Clause with for Loops

The `else` clause executes if the loop completes normally (without break).

```python
# Search with else
names = ["Alice", "Bob", "Charlie"]
search = "Diana"

for name in names:
    if name == search:
        print(f"Found {search}!")
        break
else:
    print(f"{search} not found")  # Executes if loop completes without break
# Output: Diana not found
```

---

## Common Patterns

### Pattern 1: Accumulating Values

```python
# Sum numbers
numbers = [1, 2, 3, 4, 5]
total = 0
for num in numbers:
    total += num
print(total)  # Output: 15

# Product
numbers = [1, 2, 3, 4, 5]
product = 1
for num in numbers:
    product *= num
print(product)  # Output: 120
```

### Pattern 2: Finding Maximum/Minimum

```python
# Find maximum
numbers = [3, 1, 4, 1, 5, 9, 2, 6]
maximum = numbers[0]
for num in numbers:
    if num > maximum:
        maximum = num
print(maximum)  # Output: 9

# Or use built-in
maximum = max(numbers)
```

### Pattern 3: Counting Occurrences

```python
# Count occurrences
numbers = [1, 2, 3, 2, 1, 4, 3, 2]
count = {}
for num in numbers:
    count[num] = count.get(num, 0) + 1
print(count)  # Output: {1: 2, 2: 3, 3: 2, 4: 1}
```

### Pattern 4: Filtering

```python
# Filter even numbers
numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
evens = []
for num in numbers:
    if num % 2 == 0:
        evens.append(num)
print(evens)  # Output: [2, 4, 6, 8, 10]
```

### Pattern 5: Building Lists

```python
# Build list of squares
squares = []
for i in range(5):
    squares.append(i ** 2)
print(squares)  # Output: [0, 1, 4, 9, 16]

# Or use list comprehension (covered later)
squares = [i ** 2 for i in range(5)]
```

---

## Practical Examples

### Example 1: Processing Student Grades

```python
# Calculate average grade
grades = [85, 92, 78, 96, 88]
total = 0
count = 0

for grade in grades:
    total += grade
    count += 1

average = total / count
print(f"Average grade: {average}")  # Output: Average grade: 87.8
```

### Example 2: Text Processing

```python
# Count words in text
text = "Python is a great programming language"
words = text.split()
word_count = len(words)
print(f"Number of words: {word_count}")

# Count characters (excluding spaces)
char_count = 0
for char in text:
    if char != " ":
        char_count += 1
print(f"Character count (no spaces): {char_count}")
```

### Example 3: Data Validation

```python
# Validate scores
scores = [85, 92, -5, 78, 105, 96, 88]
valid_scores = []

for score in scores:
    if 0 <= score <= 100:
        valid_scores.append(score)
    else:
        print(f"Invalid score: {score}")

print(f"Valid scores: {valid_scores}")
```

### Example 4: Pattern Generation

```python
# Print pattern
for i in range(5):
    for j in range(i + 1):
        print("*", end="")
    print()
# Output:
# *
# **
# ***
# ****
# *****
```

---

## Common Mistakes and Pitfalls

### 1. Modifying List While Iterating

```python
# Dangerous: Modifying list while iterating
numbers = [1, 2, 3, 4, 5]
# for num in numbers:
#     if num % 2 == 0:
#         numbers.remove(num)  # Can cause issues!

# Better: Create new list or iterate over copy
numbers = [1, 2, 3, 4, 5]
evens = [num for num in numbers if num % 2 == 0]
```

### 2. Forgetting Colon

```python
# Wrong
# for i in range(5)
#     print(i)

# Correct
for i in range(5):
    print(i)
```

### 3. Incorrect Indentation

```python
# Wrong
# for i in range(5):
# print(i)  # IndentationError!

# Correct
for i in range(5):
    print(i)
```

### 4. Using Wrong Variable Name

```python
# Confusing variable names
fruits = ["apple", "banana"]
for fruit in fruits:  # Good
    print(fruit)

for item in fruits:  # Also fine
    print(item)

# for x in fruits:  # Less clear what x represents
```

### 5. Off-by-One Errors with range()

```python
# Remember: range(5) is 0, 1, 2, 3, 4 (not 5!)
for i in range(5):
    print(i)  # Prints 0 to 4

# To include 5:
for i in range(6):  # 0 to 5
    print(i)
```

---

## Practice Exercise

### Exercise: For Loop Practice

**Objective**: Create a Python program that demonstrates various for loop operations and patterns.

**Instructions**:

1. Create a file called `for_loop_practice.py`

2. Write a program that:
   - Uses for loops with different data types
   - Uses range() function
   - Demonstrates enumerate()
   - Shows nested loops
   - Uses loop control statements
   - Implements practical loop-based solutions

3. Your program should include:
   - Number processing
   - Text processing
   - List operations
   - Pattern generation
   - Data analysis

**Example Solution**:

```python
"""
For Loop Practice
This program demonstrates various for loop operations and patterns.
"""

print("=" * 60)
print("FOR LOOP PRACTICE")
print("=" * 60)
print()

# 1. Basic For Loop
print("1. BASIC FOR LOOP")
print("-" * 60)
fruits = ["apple", "banana", "orange"]
for fruit in fruits:
    print(f"  I like {fruit}")
print()

# 2. Using range()
print("2. USING range()")
print("-" * 60)
print("Count 0 to 4:")
for i in range(5):
    print(f"  {i}")

print("\nCount 2 to 5:")
for i in range(2, 6):
    print(f"  {i}")

print("\nEven numbers 0 to 8:")
for i in range(0, 10, 2):
    print(f"  {i}")

print("\nCount backwards 10 to 1:")
for i in range(10, 0, -1):
    print(f"  {i}")
print()

# 3. Iterating Over Strings
print("3. ITERATING OVER STRINGS")
print("-" * 60)
word = "Python"
print(f"Characters in '{word}':")
for char in word:
    print(f"  {char}")

sentence = "Hello world Python"
print(f"\nWords in '{sentence}':")
for word in sentence.split():
    print(f"  {word}")
print()

# 4. Iterating Over Dictionaries
print("4. ITERATING OVER DICTIONARIES")
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

# 5. Using enumerate()
print("5. USING enumerate()")
print("-" * 60)
fruits = ["apple", "banana", "orange"]
print("With default index (starts at 0):")
for index, fruit in enumerate(fruits):
    print(f"  {index}: {fruit}")

print("\nWith custom start (starts at 1):")
for index, fruit in enumerate(fruits, start=1):
    print(f"  {index}. {fruit}")
print()

# 6. Accumulating Values
print("6. ACCUMULATING VALUES")
print("-" * 60)
numbers = [1, 2, 3, 4, 5]

# Sum
total = 0
for num in numbers:
    total += num
print(f"Sum of {numbers}: {total}")

# Product
product = 1
for num in numbers:
    product *= num
print(f"Product of {numbers}: {product}")
print()

# 7. Finding Maximum/Minimum
print("7. FINDING MAXIMUM/MINIMUM")
print("-" * 60)
numbers = [3, 1, 4, 1, 5, 9, 2, 6]

maximum = numbers[0]
minimum = numbers[0]
for num in numbers:
    if num > maximum:
        maximum = num
    if num < minimum:
        minimum = num

print(f"Numbers: {numbers}")
print(f"Maximum: {maximum}")
print(f"Minimum: {minimum}")
print()

# 8. Counting Occurrences
print("8. COUNTING OCCURRENCES")
print("-" * 60)
numbers = [1, 2, 3, 2, 1, 4, 3, 2, 1]
count = {}

for num in numbers:
    count[num] = count.get(num, 0) + 1

print(f"Numbers: {numbers}")
print("Occurrences:")
for num, freq in count.items():
    print(f"  {num}: {freq} times")
print()

# 9. Filtering
print("9. FILTERING")
print("-" * 60)
numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]

# Even numbers
evens = []
for num in numbers:
    if num % 2 == 0:
        evens.append(num)
print(f"Even numbers from {numbers}: {evens}")

# Numbers greater than 5
greater_than_5 = []
for num in numbers:
    if num > 5:
        greater_than_5.append(num)
print(f"Numbers > 5: {greater_than_5}")
print()

# 10. Nested Loops
print("10. NESTED LOOPS")
print("-" * 60)
# Multiplication table
print("Multiplication table (1-3):")
for i in range(1, 4):
    for j in range(1, 4):
        print(f"  {i} x {j} = {i * j}")
print()

# 2D matrix
matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
]
print("Matrix elements:")
for row in matrix:
    for element in row:
        print(f"  {element}", end=" ")
    print()  # New line
print()

# 11. Loop Control: break
print("11. LOOP CONTROL: break")
print("-" * 60)
numbers = [1, 3, 5, 8, 9, 10]
print(f"Finding first even number in {numbers}:")
for num in numbers:
    if num % 2 == 0:
        print(f"  Found: {num}")
        break
print()

# 12. Loop Control: continue
print("12. LOOP CONTROL: continue")
print("-" * 60)
numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
print(f"Even numbers from {numbers}:")
for num in numbers:
    if num % 2 != 0:
        continue
    print(f"  {num}")
print()

# 13. Loop Control: else
print("13. LOOP CONTROL: else")
print("-" * 60)
names = ["Alice", "Bob", "Charlie"]
search = "Diana"

print(f"Searching for '{search}' in {names}:")
for name in names:
    if name == search:
        print(f"  Found {search}!")
        break
else:
    print(f"  {search} not found")
print()

# 14. Pattern Generation
print("14. PATTERN GENERATION")
print("-" * 60)
print("Star pattern:")
for i in range(5):
    for j in range(i + 1):
        print("*", end="")
    print()

print("\nNumber pattern:")
for i in range(1, 6):
    for j in range(1, i + 1):
        print(j, end=" ")
    print()
print()

# 15. Processing Student Data
print("15. PROCESSING STUDENT DATA")
print("-" * 60)
students = [
    {"name": "Alice", "scores": [85, 92, 78]},
    {"name": "Bob", "scores": [90, 88, 95]},
    {"name": "Charlie", "scores": [75, 80, 85]}
]

for student in students:
    name = student["name"]
    scores = student["scores"]
    average = sum(scores) / len(scores)
    print(f"{name}: scores={scores}, average={average:.1f}")
print()

# 16. Text Analysis
print("16. TEXT ANALYSIS")
print("-" * 60)
text = "Python is a great programming language"
print(f"Analyzing: '{text}'")

# Word count
words = text.split()
print(f"  Word count: {len(words)}")

# Character count (excluding spaces)
char_count = 0
for char in text:
    if char != " ":
        char_count += 1
print(f"  Character count (no spaces): {char_count}")

# Vowel count
vowels = "aeiouAEIOU"
vowel_count = 0
for char in text:
    if char in vowels:
        vowel_count += 1
print(f"  Vowel count: {vowel_count}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
FOR LOOP PRACTICE
============================================================

1. BASIC FOR LOOP
------------------------------------------------------------
  I like apple
  I like banana
  I like orange

2. USING range()
------------------------------------------------------------
Count 0 to 4:
  0
  1
  2
  3
  4

[... rest of output ...]
```

**Challenge** (Optional):
- Create more complex nested loop patterns
- Build a data analysis tool using loops
- Implement a search algorithm
- Create a text processing utility
- Build a game with loop-based logic

---

## Key Takeaways

1. **for loops iterate over sequences** - lists, strings, tuples, dictionaries, sets
2. **range() generates number sequences** - commonly used with for loops
3. **enumerate() provides index and value** - more Pythonic than range(len())
4. **Nested loops** allow iteration over multiple dimensions
5. **break exits the loop** - stops execution immediately
6. **continue skips to next iteration** - skips rest of current iteration
7. **pass does nothing** - placeholder for future code
8. **else with for** - executes if loop completes without break
9. **Common patterns**: accumulating, filtering, counting, finding max/min
10. **Avoid modifying lists while iterating** - create new list instead

---

## Quiz: For Loops

Test your understanding with these questions:

1. **What does `for i in range(5):` iterate over?**
   - A) 1, 2, 3, 4, 5
   - B) 0, 1, 2, 3, 4
   - C) 0, 1, 2, 3, 4, 5
   - D) 1, 2, 3, 4

2. **What does `enumerate()` return?**
   - A) Just the index
   - B) Just the value
   - C) Both index and value
   - D) The sequence

3. **What does `break` do in a loop?**
   - A) Skips to next iteration
   - B) Exits the loop
   - C) Does nothing
   - D) Continues the loop

4. **What does `continue` do in a loop?**
   - A) Exits the loop
   - B) Skips to next iteration
   - C) Does nothing
   - D) Stops the program

5. **How do you iterate over dictionary key-value pairs?**
   - A) `for key in dict:`
   - B) `for key, value in dict.items():`
   - C) `for value in dict:`
   - D) `for item in dict:`

6. **What is the output of: `for i in range(2, 5): print(i)`?**
   - A) 2, 3, 4
   - B) 2, 3, 4, 5
   - C) 1, 2, 3, 4
   - D) 0, 1, 2, 3, 4

7. **What happens when you modify a list while iterating over it?**
   - A) Works fine
   - B) Can cause unexpected behavior
   - C) Always causes error
   - D) Slows down the loop

8. **What does the `else` clause do with a for loop?**
   - A) Always executes
   - B) Executes if loop completes without break
   - C) Never executes
   - D) Executes on error

9. **What is the range for `range(0, 10, 2)`?**
   - A) 0, 2, 4, 6, 8
   - B) 0, 2, 4, 6, 8, 10
   - C) 2, 4, 6, 8, 10
   - D) 0, 1, 2, 3, 4, 5, 6, 7, 8, 9

10. **How do you iterate backwards with range()?**
    - A) `range(10, 0)`
    - B) `range(10, 0, -1)`
    - C) `range(0, 10, -1)`
    - D) `range(10, -1)`

**Answers**:
1. B) 0, 1, 2, 3, 4 (range(5) starts at 0, stops before 5)
2. C) Both index and value (returns tuples of (index, value))
3. B) Exits the loop (stops execution immediately)
4. B) Skips to next iteration (skips rest of current iteration)
5. B) `for key, value in dict.items():` (iterates over key-value pairs)
6. A) 2, 3, 4 (range(2, 5) is 2 to 4, exclusive of 5)
7. B) Can cause unexpected behavior (should create new list instead)
8. B) Executes if loop completes without break (else with for loops)
9. A) 0, 2, 4, 6, 8 (step of 2, stops before 10)
10. B) `range(10, 0, -1)` (negative step counts backwards)

---

## Next Steps

Excellent work! You've mastered for loops. You now understand:
- How to use for loops with different data types
- The range() function and its variations
- enumerate() for getting indices
- Nested loops for multi-dimensional iteration
- Loop control statements (break, continue, pass)
- Common patterns and best practices

**What's Next?**
- Lesson 5.3: Loops - While Loops
- Practice combining for loops with conditionals
- Learn about list comprehensions (advanced for loops)
- Explore more complex loop patterns

---

## Additional Resources

- **Python For Loops**: [docs.python.org/3/tutorial/controlflow.html#for-statements](https://docs.python.org/3/tutorial/controlflow.html#for-statements)
- **range() Function**: [docs.python.org/3/library/stdtypes.html#range](https://docs.python.org/3/library/stdtypes.html#range)
- **enumerate() Function**: [docs.python.org/3/library/functions.html#enumerate](https://docs.python.org/3/library/functions.html#enumerate)

---

*Lesson completed! You're ready to move on to the next lesson.*

