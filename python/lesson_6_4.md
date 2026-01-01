# Lesson 6.4: Lambda Functions

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what lambda functions are and when to use them
- Write lambda functions with proper syntax
- Use lambda functions with built-in functions (map, filter, reduce)
- Understand the difference between lambda and regular functions
- Apply lambda functions in practical scenarios
- Know when lambda functions are appropriate
- Avoid common lambda function mistakes
- Write clean and readable lambda code

---

## Introduction to Lambda Functions

A **lambda function** (also called an anonymous function) is a small, unnamed function defined using the `lambda` keyword. Lambda functions are useful for short, simple operations that don't need a full function definition.

### Key Characteristics

- **Anonymous**: No function name
- **Single expression**: Can only contain one expression (no statements)
- **Inline**: Defined where they're used
- **Concise**: Shorter syntax than regular functions

### When to Use Lambda Functions

✅ **Use lambda for**:
- Short, simple operations
- Functions used only once
- Callbacks and event handlers
- Functions passed as arguments (map, filter, etc.)

❌ **Avoid lambda for**:
- Complex logic (use regular functions)
- Functions used multiple times
- When you need multiple statements
- When readability would suffer

---

## Lambda Function Syntax

### Basic Syntax

```python
lambda arguments: expression
```

**Components**:
- `lambda` - keyword
- `arguments` - function parameters (can be multiple)
- `:` - colon separator
- `expression` - single expression (what the function returns)

### Simple Examples

```python
# Basic lambda
square = lambda x: x ** 2
print(square(5))  # Output: 25

# Lambda with multiple parameters
add = lambda a, b: a + b
print(add(3, 5))  # Output: 8

# Lambda with no parameters
get_hello = lambda: "Hello, World!"
print(get_hello())  # Output: Hello, World!
```

### Comparison: Lambda vs Regular Function

```python
# Regular function
def square(x):
    return x ** 2

# Lambda function (equivalent)
square = lambda x: x ** 2

# Both work the same
print(square(5))  # Output: 25 (both ways)
```

---

## Lambda Functions with Built-in Functions

Lambda functions are commonly used with `map()`, `filter()`, and `reduce()`.

### map() with Lambda

The `map()` function applies a function to every item in an iterable.

```python
# Using lambda with map
numbers = [1, 2, 3, 4, 5]
squares = list(map(lambda x: x ** 2, numbers))
print(squares)  # Output: [1, 4, 9, 16, 25]

# Equivalent with list comprehension
squares = [x ** 2 for x in numbers]
print(squares)  # Output: [1, 4, 9, 16, 25]

# Multiple iterables
list1 = [1, 2, 3]
list2 = [4, 5, 6]
sums = list(map(lambda x, y: x + y, list1, list2))
print(sums)  # Output: [5, 7, 9]
```

### filter() with Lambda

The `filter()` function filters items based on a condition.

```python
# Using lambda with filter
numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
evens = list(filter(lambda x: x % 2 == 0, numbers))
print(evens)  # Output: [2, 4, 6, 8, 10]

# Equivalent with list comprehension
evens = [x for x in numbers if x % 2 == 0]
print(evens)  # Output: [2, 4, 6, 8, 10]

# Filter strings
words = ["apple", "banana", "cherry", "date"]
long_words = list(filter(lambda w: len(w) > 5, words))
print(long_words)  # Output: ['banana', 'cherry']
```

### reduce() with Lambda

The `reduce()` function (from `functools`) applies a function cumulatively to items.

```python
from functools import reduce

# Using lambda with reduce
numbers = [1, 2, 3, 4, 5]
sum_all = reduce(lambda x, y: x + y, numbers)
print(sum_all)  # Output: 15

# Product
product = reduce(lambda x, y: x * y, numbers)
print(product)  # Output: 120

# Maximum
maximum = reduce(lambda x, y: x if x > y else y, numbers)
print(maximum)  # Output: 5
```

---

## Lambda Functions with sorted()

Lambda functions are commonly used with `sorted()` for custom sorting.

### Basic Sorting

```python
# Sort by length
words = ["apple", "pie", "banana", "kiwi"]
sorted_by_length = sorted(words, key=lambda w: len(w))
print(sorted_by_length)  # Output: ['pie', 'kiwi', 'apple', 'banana']

# Sort by second character
sorted_by_second = sorted(words, key=lambda w: w[1])
print(sorted_by_second)  # Output: ['banana', 'apple', 'pie', 'kiwi']
```

### Sorting Complex Data

```python
# Sort list of tuples
students = [("Alice", 25, 3.8), ("Bob", 23, 3.5), ("Charlie", 24, 3.9)]

# Sort by age
sorted_by_age = sorted(students, key=lambda s: s[1])
print(sorted_by_age)  # Output: [('Bob', 23, 3.5), ('Charlie', 24, 3.9), ('Alice', 25, 3.8)]

# Sort by GPA (descending)
sorted_by_gpa = sorted(students, key=lambda s: s[2], reverse=True)
print(sorted_by_gpa)  # Output: [('Charlie', 24, 3.9), ('Alice', 25, 3.8), ('Bob', 23, 3.5)]

# Sort list of dictionaries
people = [
    {"name": "Alice", "age": 25},
    {"name": "Bob", "age": 23},
    {"name": "Charlie", "age": 24}
]

sorted_people = sorted(people, key=lambda p: p["age"])
print(sorted_people)
```

---

## Lambda Functions with Other Built-ins

### max() and min() with key

```python
# Find longest word
words = ["apple", "banana", "cherry", "date"]
longest = max(words, key=lambda w: len(w))
print(longest)  # Output: banana

# Find student with highest GPA
students = [("Alice", 3.8), ("Bob", 3.5), ("Charlie", 3.9)]
top_student = max(students, key=lambda s: s[1])
print(top_student)  # Output: ('Charlie', 3.9)
```

### any() and all() with Lambda

```python
# Check if any number is even
numbers = [1, 3, 5, 8, 9]
has_even = any(lambda x: x % 2 == 0, numbers)  # Wrong syntax!

# Correct: use generator expression
has_even = any(x % 2 == 0 for x in numbers)
print(has_even)  # Output: True

# Or with filter
has_even = any(filter(lambda x: x % 2 == 0, numbers))
print(has_even)  # Output: True
```

---

## Lambda Functions in List Comprehensions

While list comprehensions are often preferred, you can use lambda in some cases:

```python
# Using lambda in map (less common, list comprehension preferred)
numbers = [1, 2, 3, 4, 5]
squares = list(map(lambda x: x ** 2, numbers))

# List comprehension (more Pythonic)
squares = [x ** 2 for x in numbers]
```

---

## Practical Examples

### Example 1: Data Processing

```python
# Process list of numbers
numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]

# Square even numbers
even_squares = [x ** 2 for x in filter(lambda x: x % 2 == 0, numbers)]
print(even_squares)  # Output: [4, 16, 36, 64, 100]

# Or more Pythonic
even_squares = [x ** 2 for x in numbers if x % 2 == 0]
```

### Example 2: Sorting and Filtering

```python
# Sort students by multiple criteria
students = [
    {"name": "Alice", "age": 25, "gpa": 3.8},
    {"name": "Bob", "age": 23, "gpa": 3.5},
    {"name": "Charlie", "age": 24, "gpa": 3.9}
]

# Sort by GPA (descending)
sorted_students = sorted(students, key=lambda s: s["gpa"], reverse=True)
for student in sorted_students:
    print(f"{student['name']}: {student['gpa']}")
```

### Example 3: Event Handlers (Conceptual)

```python
# Lambda for simple callbacks
def process_data(data, callback):
    result = callback(data)
    return result

# Use lambda as callback
numbers = [1, 2, 3, 4, 5]
doubled = process_data(numbers, lambda x: [n * 2 for n in x])
print(doubled)  # Output: [2, 4, 6, 8, 10]
```

---

## Lambda vs Regular Functions

### When to Use Lambda

✅ **Good uses**:
- Short, one-line operations
- Functions used once
- As arguments to higher-order functions
- Simple transformations

```python
# Good: Simple transformation
squares = list(map(lambda x: x ** 2, numbers))

# Good: Simple filter
evens = list(filter(lambda x: x % 2 == 0, numbers))

# Good: Simple sort key
sorted_words = sorted(words, key=lambda w: len(w))
```

### When to Use Regular Functions

✅ **Better uses**:
- Complex logic
- Multiple statements
- Functions used multiple times
- When you need docstrings
- When readability matters

```python
# Better: Complex logic
def calculate_grade(score, curve=0):
    """Calculate grade with optional curve."""
    adjusted_score = score + curve
    if adjusted_score >= 90:
        return "A"
    elif adjusted_score >= 80:
        return "B"
    # ... more logic
    return "F"

# Better: Reusable function
def is_valid_email(email):
    """Check if email is valid."""
    return "@" in email and "." in email and len(email) > 5
```

### Comparison Example

```python
# Lambda (works but less readable for complex logic)
process = lambda x: x ** 2 if x > 0 else 0 if x == 0 else -x ** 2

# Regular function (more readable)
def process(x):
    if x > 0:
        return x ** 2
    elif x == 0:
        return 0
    else:
        return -x ** 2
```

---

## Common Patterns

### Pattern 1: Simple Transformations

```python
# Transform data
numbers = [1, 2, 3, 4, 5]
doubled = list(map(lambda x: x * 2, numbers))
print(doubled)  # Output: [2, 4, 6, 8, 10]
```

### Pattern 2: Filtering

```python
# Filter data
numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
evens = list(filter(lambda x: x % 2 == 0, numbers))
print(evens)  # Output: [2, 4, 6, 8, 10]
```

### Pattern 3: Custom Sorting

```python
# Sort with custom key
students = [("Alice", 25), ("Bob", 23), ("Charlie", 24)]
sorted_by_age = sorted(students, key=lambda s: s[1])
print(sorted_by_age)
```

### Pattern 4: Conditional Expressions

```python
# Lambda with conditional
absolute = lambda x: x if x >= 0 else -x
print(absolute(-5))  # Output: 5
print(absolute(5))  # Output: 5
```

---

## Common Mistakes and Pitfalls

### 1. Trying to Use Statements

```python
# Wrong: lambda can't contain statements
# square = lambda x: print(x); x ** 2  # SyntaxError!

# Correct: use regular function
def square(x):
    print(x)
    return x ** 2
```

### 2. Overly Complex Lambda

```python
# Wrong: too complex for lambda
# complex = lambda x: x ** 2 if x > 0 else (0 if x == 0 else -x ** 2) if x < 10 else x

# Better: use regular function
def complex_function(x):
    if x > 0:
        return x ** 2
    elif x == 0:
        return 0
    else:
        return -x ** 2 if x < 10 else x
```

### 3. Assigning Lambda to Variable

```python
# Technically works but not recommended
square = lambda x: x ** 2

# Better: use regular function
def square(x):
    return x ** 2
```

**Note**: PEP 8 recommends using regular functions when assigning to a variable.

### 4. Lambda in List Comprehension

```python
# Unnecessary: lambda in comprehension
# squares = [lambda x: x ** 2 for x in range(5)]  # Wrong!

# Correct: direct expression
squares = [x ** 2 for x in range(5)]
```

### 5. Capturing Variables in Loops

```python
# Wrong: all lambdas capture same variable
# functions = [lambda x: x + i for i in range(3)]
# print(functions[0](10))  # Output: 12 (not 10!)

# Correct: use default parameter
functions = [lambda x, i=i: x + i for i in range(3)]
print(functions[0](10))  # Output: 10 (correct!)
```

---

## Best Practices

### 1. Keep Lambdas Simple

```python
# Good: simple and clear
evens = filter(lambda x: x % 2 == 0, numbers)

# Bad: too complex
result = map(lambda x: x ** 2 if x > 0 else (0 if x == 0 else -x ** 2), numbers)
```

### 2. Use Regular Functions for Reusability

```python
# If you need it more than once, use regular function
def square(x):
    return x ** 2

# Use multiple times
squares1 = [square(x) for x in numbers1]
squares2 = [square(x) for x in numbers2]
```

### 3. Prefer List Comprehensions

```python
# Lambda with map
squares = list(map(lambda x: x ** 2, numbers))

# List comprehension (more Pythonic)
squares = [x ** 2 for x in numbers]
```

### 4. Use Descriptive Variable Names

```python
# Good: descriptive name
is_even = lambda x: x % 2 == 0
evens = filter(is_even, numbers)

# Less clear
f = lambda x: x % 2 == 0
```

---

## Practice Exercise

### Exercise: Lambda Functions Practice

**Objective**: Create a Python program that demonstrates lambda function usage in various scenarios.

**Instructions**:

1. Create a file called `lambda_practice.py`

2. Write a program that:
   - Creates lambda functions for simple operations
   - Uses lambda with map(), filter(), and reduce()
   - Uses lambda with sorted() for custom sorting
   - Demonstrates practical lambda applications
   - Shows when to use lambda vs regular functions

3. Your program should include:
   - Basic lambda functions
   - Lambda with map/filter/reduce
   - Lambda with sorted
   - Data processing examples
   - Comparison with regular functions

**Example Solution**:

```python
"""
Lambda Functions Practice
This program demonstrates lambda function usage in various scenarios.
"""

from functools import reduce

print("=" * 60)
print("LAMBDA FUNCTIONS PRACTICE")
print("=" * 60)
print()

# 1. Basic Lambda Functions
print("1. BASIC LAMBDA FUNCTIONS")
print("-" * 60)
# Square function
square = lambda x: x ** 2
print(f"square(5) = {square(5)}")

# Add function
add = lambda a, b: a + b
print(f"add(3, 5) = {add(3, 5)}")

# No parameters
greet = lambda: "Hello, World!"
print(f"greet() = {greet()}")

# Multiple parameters
calculate = lambda x, y, z: x * y + z
print(f"calculate(2, 3, 4) = {calculate(2, 3, 4)}")
print()

# 2. Lambda with map()
print("2. LAMBDA WITH map()")
print("-" * 60)
numbers = [1, 2, 3, 4, 5]

# Square all numbers
squares = list(map(lambda x: x ** 2, numbers))
print(f"Squares of {numbers}: {squares}")

# Double all numbers
doubled = list(map(lambda x: x * 2, numbers))
print(f"Doubled {numbers}: {doubled}")

# Multiple iterables
list1 = [1, 2, 3]
list2 = [4, 5, 6]
sums = list(map(lambda x, y: x + y, list1, list2))
print(f"Sum of {list1} and {list2}: {sums}")
print()

# 3. Lambda with filter()
print("3. LAMBDA WITH filter()")
print("-" * 60)
numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]

# Even numbers
evens = list(filter(lambda x: x % 2 == 0, numbers))
print(f"Even numbers from {numbers}: {evens}")

# Numbers greater than 5
greater_than_5 = list(filter(lambda x: x > 5, numbers))
print(f"Numbers > 5: {greater_than_5}")

# Filter strings
words = ["apple", "banana", "cherry", "date", "elderberry"]
long_words = list(filter(lambda w: len(w) > 5, words))
print(f"Words longer than 5 chars: {long_words}")
print()

# 4. Lambda with reduce()
print("4. LAMBDA WITH reduce()")
print("-" * 60)
numbers = [1, 2, 3, 4, 5]

# Sum
total = reduce(lambda x, y: x + y, numbers)
print(f"Sum of {numbers}: {total}")

# Product
product = reduce(lambda x, y: x * y, numbers)
print(f"Product of {numbers}: {product}")

# Maximum
maximum = reduce(lambda x, y: x if x > y else y, numbers)
print(f"Maximum of {numbers}: {maximum}")
print()

# 5. Lambda with sorted()
print("5. LAMBDA WITH sorted()")
print("-" * 60)
# Sort by length
words = ["apple", "pie", "banana", "kiwi"]
sorted_by_length = sorted(words, key=lambda w: len(w))
print(f"Words sorted by length: {sorted_by_length}")

# Sort by second character
sorted_by_second = sorted(words, key=lambda w: w[1])
print(f"Words sorted by 2nd character: {sorted_by_second}")

# Sort list of tuples
students = [("Alice", 25, 3.8), ("Bob", 23, 3.5), ("Charlie", 24, 3.9)]
sorted_by_age = sorted(students, key=lambda s: s[1])
print(f"Students sorted by age: {sorted_by_age}")

sorted_by_gpa = sorted(students, key=lambda s: s[2], reverse=True)
print(f"Students sorted by GPA (desc): {sorted_by_gpa}")
print()

# 6. Lambda with max() and min()
print("6. LAMBDA WITH max() AND min()")
print("-" * 60)
words = ["apple", "banana", "cherry", "date"]
longest = max(words, key=lambda w: len(w))
shortest = min(words, key=lambda w: len(w))
print(f"Longest word: {longest}")
print(f"Shortest word: {shortest}")

students = [("Alice", 3.8), ("Bob", 3.5), ("Charlie", 3.9)]
top_student = max(students, key=lambda s: s[1])
print(f"Top student: {top_student}")
print()

# 7. Lambda with Conditional Expressions
print("7. LAMBDA WITH CONDITIONAL EXPRESSIONS")
print("-" * 60)
# Absolute value
absolute = lambda x: x if x >= 0 else -x
print(f"absolute(-5) = {absolute(-5)}")
print(f"absolute(5) = {absolute(5)}")

# Sign function
sign = lambda x: 1 if x > 0 else (-1 if x < 0 else 0)
print(f"sign(5) = {sign(5)}")
print(f"sign(-3) = {sign(-3)}")
print(f"sign(0) = {sign(0)}")
print()

# 8. Practical: Data Processing
print("8. PRACTICAL: DATA PROCESSING")
print("-" * 60)
numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]

# Square even numbers
even_squares = [x ** 2 for x in filter(lambda x: x % 2 == 0, numbers)]
print(f"Even squares: {even_squares}")

# Process student data
students = [
    {"name": "Alice", "age": 25, "gpa": 3.8},
    {"name": "Bob", "age": 23, "gpa": 3.5},
    {"name": "Charlie", "age": 24, "gpa": 3.9}
]

# Sort by GPA
sorted_students = sorted(students, key=lambda s: s["gpa"], reverse=True)
print("Students sorted by GPA:")
for student in sorted_students:
    print(f"  {student['name']}: {student['gpa']}")
print()

# 9. Lambda vs Regular Function
print("9. LAMBDA vs REGULAR FUNCTION")
print("-" * 60)
numbers = [1, 2, 3, 4, 5]

# Lambda approach
squares_lambda = list(map(lambda x: x ** 2, numbers))

# Regular function approach
def square(x):
    return x ** 2

squares_function = list(map(square, numbers))

# List comprehension (most Pythonic)
squares_comprehension = [x ** 2 for x in numbers]

print(f"Lambda: {squares_lambda}")
print(f"Function: {squares_function}")
print(f"Comprehension: {squares_comprehension}")
print("All produce same result!")
print()

# 10. Complex Sorting
print("10. COMPLEX SORTING")
print("-" * 60)
# Sort by multiple criteria
students = [
    {"name": "Alice", "age": 25, "gpa": 3.8},
    {"name": "Bob", "age": 23, "gpa": 3.8},
    {"name": "Charlie", "age": 24, "gpa": 3.9}
]

# Sort by GPA (desc), then by age (asc)
sorted_students = sorted(
    students,
    key=lambda s: (-s["gpa"], s["age"])  # Negative for descending
)
print("Students sorted by GPA (desc), then age (asc):")
for student in sorted_students:
    print(f"  {student['name']}: GPA={student['gpa']}, Age={student['age']}")
print()

# 11. Filtering and Mapping Combined
print("11. FILTERING AND MAPPING COMBINED")
print("-" * 60)
numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]

# Square of even numbers
even_squares = list(map(lambda x: x ** 2, filter(lambda x: x % 2 == 0, numbers)))
print(f"Even squares: {even_squares}")

# Or with list comprehension (more Pythonic)
even_squares_comp = [x ** 2 for x in numbers if x % 2 == 0]
print(f"Even squares (comprehension): {even_squares_comp}")
print()

# 12. Lambda in Higher-Order Functions
print("12. LAMBDA IN HIGHER-ORDER FUNCTIONS")
print("-" * 60)
def apply_operation(numbers, operation):
    """Apply operation to each number."""
    return [operation(n) for n in numbers]

numbers = [1, 2, 3, 4, 5]

# Use lambda as operation
doubled = apply_operation(numbers, lambda x: x * 2)
squared = apply_operation(numbers, lambda x: x ** 2)

print(f"Doubled: {doubled}")
print(f"Squared: {squared}")
print()

# 13. Practical: Text Processing
print("13. PRACTICAL: TEXT PROCESSING")
print("-" * 60)
text = "Python is a great programming language"
words = text.split()

# Sort by length
sorted_by_length = sorted(words, key=lambda w: len(w))
print(f"Words sorted by length: {sorted_by_length}")

# Filter long words
long_words = list(filter(lambda w: len(w) > 4, words))
print(f"Words longer than 4 chars: {long_words}")
print()

# 14. Lambda with Dictionary Operations
print("14. LAMBDA WITH DICTIONARY OPERATIONS")
print("-" * 60)
students = [
    {"name": "Alice", "scores": [85, 92, 78]},
    {"name": "Bob", "scores": [90, 88, 95]},
    {"name": "Charlie", "scores": [75, 80, 85]}
]

# Sort by average score
sorted_by_avg = sorted(
    students,
    key=lambda s: sum(s["scores"]) / len(s["scores"]),
    reverse=True
)
print("Students sorted by average score:")
for student in sorted_by_avg:
    avg = sum(student["scores"]) / len(student["scores"])
    print(f"  {student['name']}: {avg:.1f}")
print()

# 15. When NOT to Use Lambda
print("15. WHEN NOT TO USE LAMBDA")
print("-" * 60)
# Complex logic - use regular function instead
def calculate_grade(score, curve=0):
    """Calculate letter grade."""
    adjusted = score + curve
    if adjusted >= 90:
        return "A"
    elif adjusted >= 80:
        return "B"
    elif adjusted >= 70:
        return "C"
    elif adjusted >= 60:
        return "D"
    else:
        return "F"

scores = [85, 92, 78, 96, 88]
grades = [calculate_grade(score) for score in scores]
print(f"Scores: {scores}")
print(f"Grades: {grades}")
print("(Used regular function for complex logic)")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
LAMBDA FUNCTIONS PRACTICE
============================================================

1. BASIC LAMBDA FUNCTIONS
------------------------------------------------------------
square(5) = 25
add(3, 5) = 8
greet() = Hello, World!
calculate(2, 3, 4) = 10

2. LAMBDA WITH map()
------------------------------------------------------------
Squares of [1, 2, 3, 4, 5]: [1, 4, 9, 16, 25]

[... rest of output ...]
```

**Challenge** (Optional):
- Create a functional programming utility library
- Build a data transformation pipeline
- Implement a sorting system with multiple criteria
- Create a filtering framework
- Build a callback system using lambdas

---

## Key Takeaways

1. **Lambda functions are anonymous** - defined with `lambda` keyword
2. **Single expression only** - cannot contain statements
3. **Use with map(), filter(), reduce()** - common use cases
4. **Use with sorted()** - for custom sorting keys
5. **Keep lambdas simple** - use regular functions for complex logic
6. **List comprehensions often preferred** - more Pythonic than map/filter with lambda
7. **Lambda syntax**: `lambda arguments: expression`
8. **Use for short, one-time operations** - not for reusable functions
9. **Avoid assigning to variables** - PEP 8 recommends regular functions
10. **Readability matters** - don't sacrifice clarity for brevity

---

## Quiz: Lambda Functions

Test your understanding with these questions:

1. **What keyword is used to create lambda functions?**
   - A) `function`
   - B) `lambda`
   - C) `def`
   - D) `anon`

2. **What is the syntax for a lambda function?**
   - A) `lambda: expression`
   - B) `lambda arguments: expression`
   - C) `lambda expression`
   - D) `lambda arguments expression`

3. **Can lambda functions contain multiple statements?**
   - A) Yes
   - B) No, only single expression
   - C) Yes, with semicolons
   - D) Only in Python 3

4. **What does `map(lambda x: x ** 2, [1, 2, 3])` return?**
   - A) `[1, 4, 9]`
   - B) `<map object>`
   - C) `(1, 4, 9)`
   - D) Error

5. **What does `filter(lambda x: x % 2 == 0, [1, 2, 3, 4])` return?**
   - A) `[2, 4]`
   - B) `<filter object>`
   - C) `(2, 4)`
   - D) Error

6. **When should you use lambda functions?**
   - A) Always
   - B) For complex logic
   - C) For short, simple operations
   - D) Never

7. **What is more Pythonic: `map(lambda x: x**2, numbers)` or `[x**2 for x in numbers]`?**
   - A) map with lambda
   - B) List comprehension
   - C) Both are equal
   - D) Neither

8. **Can you use lambda with sorted()?**
   - A) No
   - B) Yes, for custom sort keys
   - C) Only with numbers
   - D) Only in Python 2

9. **What is the result of: `(lambda x, y: x + y)(3, 5)`?**
   - A) `8`
   - B) `lambda`
   - C) Error
   - D) `None`

10. **Should you assign lambda to a variable?**
    - A) Yes, always
    - B) No, use regular function instead
    - C) Only for short functions
    - D) Only in Python 2

**Answers**:
1. B) `lambda` (keyword for anonymous functions)
2. B) `lambda arguments: expression` (correct syntax)
3. B) No, only single expression (cannot have statements)
4. B) `<map object>` (map returns iterator, need list() to convert)
5. B) `<filter object>` (filter returns iterator, need list() to convert)
6. C) For short, simple operations (lambda is for simple, one-time use)
7. B) List comprehension (more Pythonic and readable)
8. B) Yes, for custom sort keys (common use case)
9. A) `8` (immediately invoked lambda: (lambda x, y: x + y)(3, 5) = 8)
10. B) No, use regular function instead (PEP 8 recommendation)

---

## Next Steps

Excellent work! You've mastered lambda functions. You now understand:
- How to create and use lambda functions
- Lambda with map(), filter(), and reduce()
- Lambda with sorted() for custom sorting
- When to use lambda vs regular functions
- Best practices and common patterns

**What's Next?**
- Module 7: String Manipulation
- Practice combining lambda with other Python features
- Learn about generator expressions
- Explore functional programming patterns

---

## Additional Resources

- **Lambda Expressions**: [docs.python.org/3/tutorial/controlflow.html#lambda-expressions](https://docs.python.org/3/tutorial/controlflow.html#lambda-expressions)
- **map(), filter(), reduce()**: [docs.python.org/3/library/functions.html](https://docs.python.org/3/library/functions.html)
- **PEP 8 Style Guide**: [pep8.org](https://pep8.org/) (lambda usage guidelines)

---

*Lesson completed! You're ready to move on to the next lesson.*

