# Lesson 12.3: Comprehensions Advanced

## Learning Objectives

By the end of this lesson, you will be able to:
- Use advanced list comprehension techniques
- Create dictionary comprehensions
- Create set comprehensions
- Work with nested comprehensions
- Understand when to use comprehensions vs loops
- Apply comprehensions in complex scenarios
- Write readable and efficient comprehensions
- Avoid common comprehension pitfalls
- Combine multiple comprehension types
- Use comprehensions with conditionals

---

## Introduction to Advanced Comprehensions

**Comprehensions** are concise ways to create collections (lists, dictionaries, sets) in Python. This lesson covers advanced techniques and all comprehension types.

### Why Comprehensions?

- **Concise**: Write less code
- **Readable**: Express intent clearly
- **Pythonic**: Idiomatic Python style
- **Efficient**: Often faster than loops
- **Functional**: Declarative style

---

## List Comprehensions (Advanced)

### Basic List Comprehension Review

```python
# Basic syntax
[expression for item in iterable]

# With condition
[expression for item in iterable if condition]

# Example
squares = [x ** 2 for x in range(5)]
print(squares)  # [0, 1, 4, 9, 16]
```

### Multiple Conditions

```python
# Multiple conditions with and
evens_squares = [x ** 2 for x in range(10) if x % 2 == 0 and x > 0]
print(evens_squares)  # [4, 16, 36, 64]

# Multiple conditions with or
special = [x for x in range(20) if x % 2 == 0 or x % 3 == 0]
print(special)  # [0, 2, 3, 4, 6, 8, 9, 10, 12, 14, 15, 16, 18]
```

### Conditional Expression (Ternary)

```python
# If-else in expression
numbers = [1, 2, 3, 4, 5]
result = ['even' if x % 2 == 0 else 'odd' for x in numbers]
print(result)  # ['odd', 'even', 'odd', 'even', 'odd']

# More complex
values = [x if x > 0 else 0 for x in [-2, -1, 0, 1, 2]]
print(values)  # [0, 0, 0, 1, 2]
```

### Multiple Iterables

```python
# Cartesian product
products = [x * y for x in [1, 2, 3] for y in [10, 20]]
print(products)  # [10, 20, 20, 40, 30, 60]

# With condition
pairs = [(x, y) for x in range(3) for y in range(3) if x != y]
print(pairs)  # [(0, 1), (0, 2), (1, 0), (1, 2), (2, 0), (2, 1)]
```

### Nested List Comprehensions

```python
# Flatten nested list
matrix = [[1, 2, 3], [4, 5, 6], [7, 8, 9]]
flattened = [item for row in matrix for item in row]
print(flattened)  # [1, 2, 3, 4, 5, 6, 7, 8, 9]

# Create matrix
matrix = [[i * j for j in range(3)] for i in range(3)]
print(matrix)  # [[0, 0, 0], [0, 1, 2], [0, 2, 4]]
```

### Advanced Examples

```python
# Extract specific attributes
class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age

people = [Person("Alice", 25), Person("Bob", 30), Person("Charlie", 35)]
names = [p.name for p in people if p.age > 25]
print(names)  # ['Bob', 'Charlie']

# String manipulation
words = ["hello", "world", "python"]
lengths = [len(word) for word in words]
print(lengths)  # [5, 5, 6]

# Complex transformation
data = [1, 2, 3, 4, 5]
result = [x ** 2 if x % 2 == 0 else x ** 3 for x in data]
print(result)  # [1, 4, 27, 16, 125]
```

---

## Dictionary Comprehensions

### Basic Dictionary Comprehension

```python
# Basic syntax
{key_expression: value_expression for item in iterable}

# Example
squares = {x: x ** 2 for x in range(5)}
print(squares)  # {0: 0, 1: 1, 2: 4, 3: 9, 4: 16}
```

### Dictionary Comprehension with Condition

```python
# With condition
evens_squares = {x: x ** 2 for x in range(10) if x % 2 == 0}
print(evens_squares)  # {0: 0, 2: 4, 4: 16, 6: 36, 8: 64}

# Filter existing dictionary
original = {'a': 1, 'b': 2, 'c': 3, 'd': 4}
filtered = {k: v for k, v in original.items() if v > 2}
print(filtered)  # {'c': 3, 'd': 4}
```

### Dictionary Comprehension Examples

```python
# From list
words = ["hello", "world", "python"]
word_lengths = {word: len(word) for word in words}
print(word_lengths)  # {'hello': 5, 'world': 5, 'python': 6}

# Transform keys
original = {'a': 1, 'b': 2, 'c': 3}
uppercase = {k.upper(): v * 2 for k, v in original.items()}
print(uppercase)  # {'A': 2, 'B': 4, 'C': 6}

# Transform values
numbers = {'a': 1, 'b': 2, 'c': 3}
squared = {k: v ** 2 for k, v in numbers.items()}
print(squared)  # {'a': 1, 'b': 4, 'c': 9}
```

### Dictionary Comprehension with Multiple Conditions

```python
# Multiple conditions
data = {'a': 1, 'b': 2, 'c': 3, 'd': 4, 'e': 5}
result = {k: v for k, v in data.items() if v > 2 and v < 5}
print(result)  # {'c': 3, 'd': 4}

# Conditional value transformation
numbers = {'a': 1, 'b': 2, 'c': 3, 'd': 4}
result = {k: ('even' if v % 2 == 0 else 'odd') for k, v in numbers.items()}
print(result)  # {'a': 'odd', 'b': 'even', 'c': 'odd', 'd': 'even'}
```

### Dictionary from Two Lists

```python
# Using zip
keys = ['a', 'b', 'c']
values = [1, 2, 3]
dictionary = {k: v for k, v in zip(keys, values)}
print(dictionary)  # {'a': 1, 'b': 2, 'c': 3}

# With condition
keys = ['a', 'b', 'c', 'd']
values = [1, 2, 3, 4]
dictionary = {k: v for k, v in zip(keys, values) if v > 2}
print(dictionary)  # {'c': 3, 'd': 4}
```

### Advanced Dictionary Comprehensions

```python
# Nested dictionary
data = {'a': [1, 2, 3], 'b': [4, 5, 6], 'c': [7, 8, 9]}
sums = {k: sum(v) for k, v in data.items()}
print(sums)  # {'a': 6, 'b': 15, 'c': 24}

# Dictionary of dictionaries
people = {
    'Alice': {'age': 25, 'city': 'NYC'},
    'Bob': {'age': 30, 'city': 'LA'},
    'Charlie': {'age': 35, 'city': 'NYC'}
}
nyc_ages = {name: info['age'] for name, info in people.items() 
            if info['city'] == 'NYC'}
print(nyc_ages)  # {'Alice': 25, 'Charlie': 35}
```

---

## Set Comprehensions

### Basic Set Comprehension

```python
# Basic syntax
{expression for item in iterable}

# Example
squares = {x ** 2 for x in range(5)}
print(squares)  # {0, 1, 4, 9, 16}

# Note: Sets remove duplicates automatically
numbers = {x % 3 for x in range(10)}
print(numbers)  # {0, 1, 2}
```

### Set Comprehension with Condition

```python
# With condition
evens = {x for x in range(10) if x % 2 == 0}
print(evens)  # {0, 2, 4, 6, 8}

# Unique values from list
words = ["hello", "world", "hello", "python"]
unique_lengths = {len(word) for word in words}
print(unique_lengths)  # {5, 6}
```

### Set Comprehension Examples

```python
# From string
text = "hello"
unique_chars = {char for char in text}
print(unique_chars)  # {'h', 'e', 'l', 'o'}

# From list with transformation
numbers = [1, 2, 3, 4, 5, 6]
even_squares = {x ** 2 for x in numbers if x % 2 == 0}
print(even_squares)  # {16, 4, 36}

# Multiple conditions
numbers = {x for x in range(20) if x % 2 == 0 and x % 3 == 0}
print(numbers)  # {0, 6, 12, 18}
```

### Set Operations with Comprehensions

```python
# Set operations
set1 = {1, 2, 3, 4, 5}
set2 = {4, 5, 6, 7, 8}

# Union
union = {x for x in set1} | {x for x in set2}
print(union)  # {1, 2, 3, 4, 5, 6, 7, 8}

# Intersection
intersection = {x for x in set1 if x in set2}
print(intersection)  # {4, 5}

# Difference
difference = {x for x in set1 if x not in set2}
print(difference)  # {1, 2, 3}
```

---

## Nested Comprehensions

### Nested List Comprehensions

```python
# Create 2D matrix
matrix = [[i * j for j in range(3)] for i in range(3)]
print(matrix)  # [[0, 0, 0], [0, 1, 2], [0, 2, 4]]

# Flatten matrix
matrix = [[1, 2, 3], [4, 5, 6], [7, 8, 9]]
flattened = [item for row in matrix for item in row]
print(flattened)  # [1, 2, 3, 4, 5, 6, 7, 8, 9]

# Transpose matrix
matrix = [[1, 2, 3], [4, 5, 6], [7, 8, 9]]
transposed = [[row[i] for row in matrix] for i in range(3)]
print(transposed)  # [[1, 4, 7], [2, 5, 8], [3, 6, 9]]
```

### Nested Dictionary Comprehensions

```python
# Dictionary of lists
data = {i: [j for j in range(i)] for i in range(1, 4)}
print(data)  # {1: [0], 2: [0, 1], 3: [0, 1, 2]}

# Nested dictionaries
nested = {i: {j: i * j for j in range(1, 4)} for i in range(1, 4)}
print(nested)
# {1: {1: 1, 2: 2, 3: 3}, 2: {1: 2, 2: 4, 3: 6}, 3: {1: 3, 2: 6, 3: 9}}
```

### Nested Set Comprehensions

```python
# Set of sets (frozenset)
data = {frozenset({i, j}) for i in range(3) for j in range(3) if i != j}
print(data)  # {frozenset({0, 1}), frozenset({0, 2}), frozenset({1, 2})}
```

### Complex Nested Comprehensions

```python
# List of dictionaries
people = [
    {'name': 'Alice', 'age': 25, 'city': 'NYC'},
    {'name': 'Bob', 'age': 30, 'city': 'LA'},
    {'name': 'Charlie', 'age': 35, 'city': 'NYC'}
]

# Dictionary of lists
by_city = {
    city: [p['name'] for p in people if p['city'] == city]
    for city in {p['city'] for p in people}
}
print(by_city)  # {'NYC': ['Alice', 'Charlie'], 'LA': ['Bob']}
```

---

## Combining Comprehension Types

### List of Dictionaries

```python
# Create list of dictionaries
people = [
    {'name': f'Person_{i}', 'age': 20 + i, 'score': i * 10}
    for i in range(5)
]
print(people)
# [{'name': 'Person_0', 'age': 20, 'score': 0}, ...]
```

### Dictionary of Lists

```python
# Group by category
data = ['apple', 'banana', 'apricot', 'blueberry', 'avocado']
grouped = {
    letter: [word for word in data if word.startswith(letter)]
    for letter in {word[0] for word in data}
}
print(grouped)  # {'a': ['apple', 'apricot', 'avocado'], 'b': ['banana', 'blueberry']}
```

### Set of Tuples

```python
# Unique pairs
pairs = {(i, j) for i in range(3) for j in range(3) if i < j}
print(pairs)  # {(0, 1), (0, 2), (1, 2)}
```

---

## Advanced Techniques

### Using Functions in Comprehensions

```python
# With built-in functions
numbers = [1, 2, 3, 4, 5]
squared = [pow(x, 2) for x in numbers]
print(squared)  # [1, 4, 9, 16, 25]

# With custom functions
def process(x):
    return x ** 2 if x % 2 == 0 else x ** 3

result = [process(x) for x in range(5)]
print(result)  # [0, 1, 4, 27, 16]
```

### Comprehensions with enumerate()

```python
# List with index
words = ['hello', 'world', 'python']
indexed = [(i, word) for i, word in enumerate(words)]
print(indexed)  # [(0, 'hello'), (1, 'world'), (2, 'python')]

# Dictionary with index as key
indexed_dict = {i: word for i, word in enumerate(words)}
print(indexed_dict)  # {0: 'hello', 1: 'world', 2: 'python'}
```

### Comprehensions with zip()

```python
# Combine two lists
keys = ['a', 'b', 'c']
values = [1, 2, 3]
combined = {k: v for k, v in zip(keys, values)}
print(combined)  # {'a': 1, 'b': 2, 'c': 3}

# Multiple lists
list1 = [1, 2, 3]
list2 = [10, 20, 30]
list3 = [100, 200, 300]
combined = [sum(x) for x in zip(list1, list2, list3)]
print(combined)  # [111, 222, 333]
```

### Comprehensions with filter()

```python
# Using filter in comprehension
numbers = range(10)
filtered = [x for x in filter(lambda n: n % 2 == 0, numbers)]
print(filtered)  # [0, 2, 4, 6, 8]

# More readable with condition
filtered = [x for x in numbers if x % 2 == 0]
print(filtered)  # [0, 2, 4, 6, 8]
```

---

## When to Use Comprehensions

### Use Comprehensions When:

1. **Simple transformations**
```python
# Good: Simple transformation
squares = [x ** 2 for x in range(10)]
```

2. **Filtering collections**
```python
# Good: Filtering
evens = [x for x in range(10) if x % 2 == 0]
```

3. **Creating dictionaries/sets from data**
```python
# Good: Dictionary creation
word_count = {word: len(word) for word in words}
```

### Avoid Comprehensions When:

1. **Complex logic**
```python
# Bad: Too complex
result = [x ** 2 if x % 2 == 0 else x ** 3 if x > 5 else x for x in range(10)]

# Good: Use loop
result = []
for x in range(10):
    if x % 2 == 0:
        result.append(x ** 2)
    elif x > 5:
        result.append(x ** 3)
    else:
        result.append(x)
```

2. **Side effects needed**
```python
# Bad: Side effects in comprehension
[print(x) for x in range(5)]  # Works but not recommended

# Good: Use loop
for x in range(5):
    print(x)
```

3. **Readability suffers**
```python
# Bad: Hard to read
result = [[[i * j * k for k in range(3)] for j in range(3)] for i in range(3)]

# Good: Break into steps or use loop
```

---

## Common Mistakes and Pitfalls

### 1. Variable Name Collision

```python
# WRONG: Variable name collision
x = 5
squares = [x ** 2 for x in range(10)]  # x is overwritten
print(x)  # 9 (not 5!)

# CORRECT: Use different variable name
x = 5
squares = [i ** 2 for i in range(10)]
print(x)  # 5
```

### 2. Mutable Default Arguments

```python
# WRONG: Mutable default in comprehension
# (This is more of a function issue, but can appear in comprehensions)
def process(items=[]):  # Bad default
    return [x * 2 for x in items]

# CORRECT: Use None
def process(items=None):
    if items is None:
        items = []
    return [x * 2 for x in items]
```

### 3. Overly Complex Comprehensions

```python
# WRONG: Too complex
result = [x ** 2 if x % 2 == 0 else x ** 3 if x > 5 else x * 2 if x < 3 else x for x in range(10)]

# CORRECT: Use loop or break into steps
result = []
for x in range(10):
    if x % 2 == 0:
        result.append(x ** 2)
    elif x > 5:
        result.append(x ** 3)
    elif x < 3:
        result.append(x * 2)
    else:
        result.append(x)
```

### 4. Forgetting Parentheses in Generator Expressions

```python
# WRONG: Missing parentheses
gen = x ** 2 for x in range(5)  # SyntaxError

# CORRECT: Use parentheses
gen = (x ** 2 for x in range(5))
```

### 5. Confusing List and Set Comprehensions

```python
# List comprehension: []
squares_list = [x ** 2 for x in range(5)]  # [0, 1, 4, 9, 16]

# Set comprehension: {}
squares_set = {x ** 2 for x in range(5)}  # {0, 1, 4, 9, 16}

# Dictionary comprehension: {key: value}
squares_dict = {x: x ** 2 for x in range(5)}  # {0: 0, 1: 1, 2: 4, 3: 9, 4: 16}
```

---

## Best Practices

### 1. Keep Comprehensions Readable

```python
# Good: Clear and readable
evens = [x for x in range(10) if x % 2 == 0]

# Better: Add comments for complex ones
# Get squares of even numbers greater than 2
evens_squares = [x ** 2 for x in range(10) if x % 2 == 0 and x > 2]
```

### 2. Use Descriptive Variable Names

```python
# Good: Descriptive names
word_lengths = {word: len(word) for word in words}

# Bad: Unclear names
wl = {w: len(w) for w in ws}
```

### 3. Break Complex Comprehensions

```python
# Good: Break into steps
numbers = range(20)
evens = [x for x in numbers if x % 2 == 0]
evens_squares = [x ** 2 for x in evens]
```

### 4. Use Generator Expressions for Large Data

```python
# Good: Generator for large data
sum_squares = sum(x ** 2 for x in range(1000000))

# Avoid: List comprehension for large data
sum_squares = sum([x ** 2 for x in range(1000000)])  # Creates list unnecessarily
```

---

## Practice Exercise

### Exercise: Comprehensions

**Objective**: Create a Python program that demonstrates all types of comprehensions.

**Instructions**:

1. Create a file called `comprehensions_practice.py`

2. Write a program that:
   - Uses advanced list comprehensions
   - Creates dictionary comprehensions
   - Creates set comprehensions
   - Uses nested comprehensions
   - Demonstrates practical applications

3. Your program should include:
   - Multiple conditions in comprehensions
   - Conditional expressions (ternary)
   - Multiple iterables
   - Nested comprehensions
   - All three comprehension types (list, dict, set)
   - Real-world examples

**Example Solution**:

```python
"""
Advanced Comprehensions Practice
This program demonstrates advanced comprehensions in Python.
"""

print("=" * 60)
print("ADVANCED COMPREHENSIONS PRACTICE")
print("=" * 60)
print()

# 1. Advanced list comprehensions
print("1. ADVANCED LIST COMPREHENSIONS")
print("-" * 60)

# Multiple conditions
evens_squares = [x ** 2 for x in range(10) if x % 2 == 0 and x > 0]
print(f"Even squares (>0): {evens_squares}")

# Conditional expression (ternary)
numbers = [1, 2, 3, 4, 5]
result = ['even' if x % 2 == 0 else 'odd' for x in numbers]
print(f"Even/Odd: {result}")

# Multiple iterables
products = [x * y for x in [1, 2, 3] for y in [10, 20]]
print(f"Products: {products}")

# Nested list comprehension
matrix = [[i * j for j in range(3)] for i in range(3)]
print(f"Matrix: {matrix}")

# Flatten matrix
flattened = [item for row in matrix for item in row]
print(f"Flattened: {flattened}")
print()

# 2. Dictionary comprehensions
print("2. DICTIONARY COMPREHENSIONS")
print("-" * 60)

# Basic dictionary comprehension
squares = {x: x ** 2 for x in range(5)}
print(f"Squares dict: {squares}")

# With condition
evens_squares = {x: x ** 2 for x in range(10) if x % 2 == 0}
print(f"Even squares dict: {evens_squares}")

# From list
words = ["hello", "world", "python"]
word_lengths = {word: len(word) for word in words}
print(f"Word lengths: {word_lengths}")

# Transform keys and values
original = {'a': 1, 'b': 2, 'c': 3}
transformed = {k.upper(): v * 2 for k, v in original.items()}
print(f"Transformed: {transformed}")

# From two lists
keys = ['a', 'b', 'c']
values = [1, 2, 3]
dictionary = {k: v for k, v in zip(keys, values)}
print(f"From lists: {dictionary}")

# Conditional value transformation
numbers = {'a': 1, 'b': 2, 'c': 3, 'd': 4}
result = {k: ('even' if v % 2 == 0 else 'odd') for k, v in numbers.items()}
print(f"Even/Odd dict: {result}")
print()

# 3. Set comprehensions
print("3. SET COMPREHENSIONS")
print("-" * 60)

# Basic set comprehension
squares = {x ** 2 for x in range(5)}
print(f"Squares set: {squares}")

# With condition
evens = {x for x in range(10) if x % 2 == 0}
print(f"Evens set: {evens}")

# Unique values from list
words = ["hello", "world", "hello", "python"]
unique_lengths = {len(word) for word in words}
print(f"Unique lengths: {unique_lengths}")

# From string
text = "hello"
unique_chars = {char for char in text}
print(f"Unique chars: {unique_chars}")

# Multiple conditions
numbers = {x for x in range(20) if x % 2 == 0 and x % 3 == 0}
print(f"Divisible by 2 and 3: {numbers}")
print()

# 4. Nested comprehensions
print("4. NESTED COMPREHENSIONS")
print("-" * 60)

# Nested list comprehension
matrix = [[i * j for j in range(3)] for i in range(3)]
print(f"Matrix: {matrix}")

# Transpose matrix
matrix = [[1, 2, 3], [4, 5, 6], [7, 8, 9]]
transposed = [[row[i] for row in matrix] for i in range(3)]
print(f"Transposed: {transposed}")

# Dictionary of lists
data = {i: [j for j in range(i)] for i in range(1, 4)}
print(f"Dict of lists: {data}")

# Nested dictionaries
nested = {i: {j: i * j for j in range(1, 4)} for i in range(1, 4)}
print(f"Nested dict: {nested}")
print()

# 5. Complex examples
print("5. COMPLEX EXAMPLES")
print("-" * 60)

# List of dictionaries
people = [
    {'name': f'Person_{i}', 'age': 20 + i, 'score': i * 10}
    for i in range(5)
]
print(f"People: {people[:2]}...")  # Show first 2

# Group by category
data = ['apple', 'banana', 'apricot', 'blueberry', 'avocado']
grouped = {
    letter: [word for word in data if word.startswith(letter)]
    for letter in {word[0] for word in data}
}
print(f"Grouped by letter: {grouped}")

# Unique pairs
pairs = {(i, j) for i in range(3) for j in range(3) if i < j}
print(f"Unique pairs: {pairs}")
print()

# 6. Using functions in comprehensions
print("6. FUNCTIONS IN COMPREHENSIONS")
print("-" * 60)

# With built-in functions
numbers = [1, 2, 3, 4, 5]
squared = [pow(x, 2) for x in numbers]
print(f"Using pow(): {squared}")

# With custom functions
def process(x):
    return x ** 2 if x % 2 == 0 else x ** 3

result = [process(x) for x in range(5)]
print(f"Using custom function: {result}")
print()

# 7. Comprehensions with enumerate
print("7. COMPREHENSIONS WITH enumerate()")
print("-" * 60)

words = ['hello', 'world', 'python']
indexed = [(i, word) for i, word in enumerate(words)]
print(f"Indexed list: {indexed}")

indexed_dict = {i: word for i, word in enumerate(words)}
print(f"Indexed dict: {indexed_dict}")
print()

# 8. Comprehensions with zip
print("8. COMPREHENSIONS WITH zip()")
print("-" * 60)

keys = ['a', 'b', 'c']
values = [1, 2, 3]
combined = {k: v for k, v in zip(keys, values)}
print(f"Combined: {combined}")

list1 = [1, 2, 3]
list2 = [10, 20, 30]
list3 = [100, 200, 300]
combined = [sum(x) for x in zip(list1, list2, list3)]
print(f"Sum of zipped: {combined}")
print()

# 9. Real-world example: Data processing
print("9. REAL-WORLD EXAMPLE: DATA PROCESSING")
print("-" * 60)

# Simulate data
students = [
    {'name': 'Alice', 'age': 20, 'grades': [85, 90, 88]},
    {'name': 'Bob', 'age': 21, 'grades': [92, 87, 91]},
    {'name': 'Charlie', 'age': 19, 'grades': [78, 82, 80]},
]

# Calculate averages
averages = {
    student['name']: sum(student['grades']) / len(student['grades'])
    for student in students
}
print(f"Student averages: {averages}")

# Filter high performers
high_performers = [
    student['name']
    for student in students
    if sum(student['grades']) / len(student['grades']) > 85
]
print(f"High performers: {high_performers}")

# Group by age range
age_groups = {
    'young': [s['name'] for s in students if s['age'] < 20],
    'adult': [s['name'] for s in students if s['age'] >= 20]
}
print(f"Age groups: {age_groups}")
print()

# 10. Performance comparison
print("10. PERFORMANCE CONSIDERATIONS")
print("-" * 60)

# Generator expression for large data
large_gen = (x ** 2 for x in range(1000000))
print(f"Generator created (no list): {type(large_gen)}")

# List comprehension for small data
small_list = [x ** 2 for x in range(10)]
print(f"Small list: {small_list}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
ADVANCED COMPREHENSIONS PRACTICE
============================================================

1. ADVANCED LIST COMPREHENSIONS
------------------------------------------------------------
Even squares (>0): [4, 16, 36, 64]
Even/Odd: ['odd', 'even', 'odd', 'even', 'odd']
Products: [10, 20, 20, 40, 30, 60]
Matrix: [[0, 0, 0], [0, 1, 2], [0, 2, 4]]
Flattened: [0, 0, 0, 0, 1, 2, 0, 2, 4]

[... rest of output ...]
```

**Challenge** (Optional):
- Create a data processing pipeline using comprehensions
- Build a matrix manipulation library using nested comprehensions
- Implement a data analysis tool using dictionary comprehensions
- Create a text processing system using set comprehensions

---

## Key Takeaways

1. **List comprehensions**: `[expression for item in iterable]`
2. **Dictionary comprehensions**: `{key: value for item in iterable}`
3. **Set comprehensions**: `{expression for item in iterable}`
4. **Multiple conditions**: Use `and`/`or` in `if` clause
5. **Conditional expressions**: `value_if_true if condition else value_if_false`
6. **Multiple iterables**: Use nested `for` loops
7. **Nested comprehensions**: Comprehensions inside comprehensions
8. **Use comprehensions** for simple transformations and filtering
9. **Avoid comprehensions** when logic is too complex
10. **Keep comprehensions readable** - break complex ones into steps
11. **Use generator expressions** for large datasets
12. **Dictionary comprehensions** create key-value pairs
13. **Set comprehensions** automatically remove duplicates
14. **Nested comprehensions** can create multi-dimensional structures
15. **Comprehensions are Pythonic** - prefer them over loops when appropriate

---

## Quiz: Comprehensions

Test your understanding with these questions:

1. **What is the syntax for a dictionary comprehension?**
   - A) `[key: value for item in iterable]`
   - B) `{key: value for item in iterable}`
   - C) `(key: value for item in iterable)`
   - D) `{key, value for item in iterable}`

2. **What does a set comprehension automatically do?**
   - A) Sorts values
   - B) Removes duplicates
   - C) Converts to list
   - D) Nothing special

3. **How do you add multiple conditions in a comprehension?**
   - A) Use multiple `if` clauses
   - B) Use `and`/`or` in single `if` clause
   - C) Use nested comprehensions
   - D) Both A and B

4. **What is the syntax for a conditional expression in a comprehension?**
   - A) `if condition else value`
   - B) `value if condition else other_value`
   - C) `condition ? value : other_value`
   - D) `value when condition else other_value`

5. **How do you create a matrix using nested comprehensions?**
   - A) `[[expr for j in range(n)] for i in range(m)]`
   - B) `[expr for i in range(m) for j in range(n)]`
   - C) `{expr for i in range(m) for j in range(n)}`
   - D) Both A and B

6. **What happens if you use the same variable name in a comprehension as outside?**
   - A) Error occurs
   - B) Variable is preserved
   - C) Variable is overwritten
   - D) Nothing happens

7. **When should you avoid using comprehensions?**
   - A) Always use comprehensions
   - B) When logic is too complex
   - C) When you need side effects
   - D) Both B and C

8. **What is the difference between list and set comprehensions?**
   - A) Syntax only
   - B) Sets remove duplicates
   - C) Lists are ordered
   - D) Both B and C

9. **How do you flatten a nested list using a comprehension?**
   - A) `[item for row in matrix for item in row]`
   - B) `[item for item in row for row in matrix]`
   - C) `[row for row in matrix]`
   - D) `{item for row in matrix for item in row}`

10. **What is the benefit of using generator expressions over list comprehensions?**
    - A) Faster execution
    - B) Memory efficiency
    - C) Simpler syntax
    - D) All of the above

**Answers**:
1. B) `{key: value for item in iterable}` (dictionary comprehension syntax)
2. B) Removes duplicates (set property)
3. D) Both A and B (multiple ways to add conditions)
4. B) `value if condition else other_value` (ternary operator syntax)
5. A) `[[expr for j in range(n)] for i in range(m)]` (nested list comprehension)
6. C) Variable is overwritten (comprehension variable shadows outer)
7. D) Both B and C (avoid when complex or side effects needed)
8. D) Both B and C (sets remove duplicates, lists are ordered)
9. A) `[item for row in matrix for item in row]` (correct flattening syntax)
10. B) Memory efficiency (generators don't create full list)

---

## Next Steps

Excellent work! You've mastered advanced comprehensions. You now understand:
- Advanced list comprehension techniques
- Dictionary comprehensions
- Set comprehensions
- Nested comprehensions
- When to use comprehensions

**What's Next?**
- Continue with more advanced Python topics
- Practice using comprehensions in real projects
- Explore more Python features and best practices

---

## Additional Resources

- **List Comprehensions**: [docs.python.org/3/tutorial/datastructures.html#list-comprehensions](https://docs.python.org/3/tutorial/datastructures.html#list-comprehensions)
- **Dictionary Comprehensions**: [docs.python.org/3/tutorial/datastructures.html#dictionaries](https://docs.python.org/3/tutorial/datastructures.html#dictionaries)
- **Set Comprehensions**: [docs.python.org/3/tutorial/datastructures.html#sets](https://docs.python.org/3/tutorial/datastructures.html#sets)

---

*Lesson completed! You're ready to move on to the next lesson.*

