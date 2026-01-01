# Lesson 12.2: Generators and Iterators

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the iterator protocol
- Create generator functions using `yield`
- Use generator expressions
- Understand the difference between generators and regular functions
- Use generators for memory-efficient iteration
- Implement custom iterators
- Understand lazy evaluation
- Apply generators in practical scenarios
- Know when to use generators vs lists

---

## Introduction to Iterators and Generators

**Iterators** are objects that can be iterated upon. **Generators** are a simple way to create iterators using functions.

### Why Generators?

- **Memory efficient**: Generate values on-the-fly
- **Lazy evaluation**: Values computed only when needed
- **Infinite sequences**: Can represent infinite sequences
- **Clean code**: Simpler than custom iterator classes

---

## Iterator Protocol

An **iterator** is an object that implements the iterator protocol: `__iter__()` and `__next__()` methods.

### Understanding Iterables and Iterators

```python
# Iterable: Can be iterated (has __iter__ method)
my_list = [1, 2, 3]
iterator = iter(my_list)  # Get iterator

# Iterator: Returns values via __next__
print(next(iterator))  # 1
print(next(iterator))  # 2
print(next(iterator))  # 3
# print(next(iterator))  # StopIteration
```

### Creating Custom Iterator

```python
class Countdown:
    def __init__(self, start):
        self.current = start
    
    def __iter__(self):
        return self
    
    def __next__(self):
        if self.current <= 0:
            raise StopIteration
        self.current -= 1
        return self.current + 1

# Use iterator
for number in Countdown(5):
    print(number)
# Output: 5, 4, 3, 2, 1
```

### Iterator vs Iterable

```python
# List is iterable (can create iterator)
my_list = [1, 2, 3]
iterator = iter(my_list)

# Iterator has __next__ method
print(next(iterator))  # 1
print(next(iterator))  # 2

# Most iterables are also iterators
# But iterators can only be used once
```

---

## Generator Functions

**Generator functions** use `yield` instead of `return`. They return a generator object.

### Basic Generator Function

```python
def countdown(n):
    """Generator function that counts down."""
    while n > 0:
        yield n
        n -= 1

# Create generator
gen = countdown(5)
print(gen)  # <generator object countdown at 0x...>

# Use generator
for number in countdown(5):
    print(number)
# Output: 5, 4, 3, 2, 1
```

### Understanding `yield`

```python
def simple_generator():
    print("Start")
    yield 1
    print("Middle")
    yield 2
    print("End")
    yield 3

gen = simple_generator()
print(next(gen))  # Start, then 1
print(next(gen))  # Middle, then 2
print(next(gen))  # End, then 3
```

### Generator vs Regular Function

```python
# Regular function
def squares_list(n):
    result = []
    for i in range(n):
        result.append(i ** 2)
    return result

# Generator function
def squares_generator(n):
    for i in range(n):
        yield i ** 2

# Regular function creates entire list in memory
squares_list(5)  # [0, 1, 4, 9, 16]

# Generator creates values on demand
for square in squares_generator(5):
    print(square)  # 0, 1, 4, 9, 16 (one at a time)
```

---

## Generator Examples

### Example 1: Number Sequence

```python
def numbers():
    n = 0
    while True:
        yield n
        n += 1

# Infinite sequence
gen = numbers()
print(next(gen))  # 0
print(next(gen))  # 1
print(next(gen))  # 2
# ... continues infinitely
```

### Example 2: Fibonacci Generator

```python
def fibonacci():
    """Generate Fibonacci sequence."""
    a, b = 0, 1
    while True:
        yield a
        a, b = b, a + b

# Generate first 10 Fibonacci numbers
fib = fibonacci()
for _ in range(10):
    print(next(fib))
# Output: 0, 1, 1, 2, 3, 5, 8, 13, 21, 34
```

### Example 3: Range Generator

```python
def my_range(start, stop=None, step=1):
    """Custom range generator."""
    if stop is None:
        stop = start
        start = 0
    
    current = start
    while current < stop:
        yield current
        current += step

# Use custom range
for i in my_range(5):
    print(i)  # 0, 1, 2, 3, 4

for i in my_range(2, 10, 2):
    print(i)  # 2, 4, 6, 8
```

### Example 4: Reading Large Files

```python
def read_large_file(filename):
    """Generator to read file line by line."""
    with open(filename, 'r') as file:
        for line in file:
            yield line.strip()

# Memory efficient - reads one line at a time
for line in read_large_file('large_file.txt'):
    process(line)  # Process one line at a time
```

---

## Generator Expressions

**Generator expressions** are like list comprehensions but create generators instead of lists.

### Basic Generator Expression

```python
# List comprehension
squares_list = [x ** 2 for x in range(5)]
print(squares_list)  # [0, 1, 4, 9, 16]

# Generator expression
squares_gen = (x ** 2 for x in range(5))
print(squares_gen)  # <generator object <genexpr> at 0x...>

# Use generator
for square in squares_gen:
    print(square)  # 0, 1, 4, 9, 16
```

### Generator Expression Syntax

```python
# Generator expression
gen = (expression for item in iterable)

# With condition
gen = (expression for item in iterable if condition)

# Multiple iterables
gen = (x * y for x in range(3) for y in range(3))
```

### Examples

```python
# Squares
squares = (x ** 2 for x in range(10))
print(list(squares))  # [0, 1, 4, 9, 16, 25, 36, 49, 64, 81]

# Even numbers
evens = (x for x in range(20) if x % 2 == 0)
print(list(evens))  # [0, 2, 4, 6, 8, 10, 12, 14, 16, 18]

# Products
products = (x * y for x in [1, 2, 3] for y in [10, 20])
print(list(products))  # [10, 20, 20, 40, 30, 60]
```

### Generator Expression vs List Comprehension

```python
# List comprehension - creates list immediately
squares_list = [x ** 2 for x in range(1000000)]  # Creates list in memory

# Generator expression - creates generator (lazy)
squares_gen = (x ** 2 for x in range(1000000))  # No list created yet

# Generator is memory efficient
# But can only be used once
```

---

## Generator Methods

### `send()` Method

```python
def accumulator():
    total = 0
    while True:
        value = yield total
        if value is None:
            break
        total += value

acc = accumulator()
next(acc)  # Initialize generator
print(acc.send(10))  # 10
print(acc.send(20))  # 30
print(acc.send(30))  # 60
```

### `throw()` Method

```python
def generator():
    try:
        yield 1
        yield 2
    except ValueError:
        yield "Error handled"

gen = generator()
print(next(gen))  # 1
gen.throw(ValueError("Error"))  # "Error handled"
```

### `close()` Method

```python
def generator():
    try:
        yield 1
        yield 2
    finally:
        print("Generator closed")

gen = generator()
print(next(gen))  # 1
gen.close()  # Generator closed
```

---

## Practical Examples

### Example 1: Infinite Sequence

```python
def natural_numbers():
    """Generate natural numbers."""
    n = 1
    while True:
        yield n
        n += 1

# Get first 10 natural numbers
nums = natural_numbers()
first_10 = [next(nums) for _ in range(10)]
print(first_10)  # [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
```

### Example 2: Chunk Processing

```python
def chunks(data, size):
    """Split data into chunks of given size."""
    for i in range(0, len(data), size):
        yield data[i:i + size]

data = list(range(20))
for chunk in chunks(data, 5):
    print(chunk)
# [0, 1, 2, 3, 4]
# [5, 6, 7, 8, 9]
# [10, 11, 12, 13, 14]
# [15, 16, 17, 18, 19]
```

### Example 3: Filtering Generator

```python
def filter_even(numbers):
    """Filter even numbers."""
    for num in numbers:
        if num % 2 == 0:
            yield num

numbers = range(20)
evens = list(filter_even(numbers))
print(evens)  # [0, 2, 4, 6, 8, 10, 12, 14, 16, 18]
```

### Example 4: Pairwise Generator

```python
def pairwise(iterable):
    """Generate pairs of consecutive elements."""
    iterator = iter(iterable)
    prev = next(iterator)
    for item in iterator:
        yield (prev, item)
        prev = item

data = [1, 2, 3, 4, 5]
for pair in pairwise(data):
    print(pair)
# (1, 2)
# (2, 3)
# (3, 4)
# (4, 5)
```

---

## Generator Best Practices

### 1. Use Generators for Large Data

```python
# Good: Generator for large data
def process_large_file(filename):
    with open(filename, 'r') as f:
        for line in f:
            yield process(line)

# Avoid: Loading entire file
def process_large_file_bad(filename):
    with open(filename, 'r') as f:
        lines = f.readlines()  # Loads entire file
        return [process(line) for line in lines]
```

### 2. Generators are Single-Use

```python
# Generator can only be used once
gen = (x ** 2 for x in range(5))
print(list(gen))  # [0, 1, 4, 9, 16]
print(list(gen))  # [] (exhausted)

# Create new generator if needed
gen = (x ** 2 for x in range(5))
print(list(gen))  # [0, 1, 4, 9, 16]
```

### 3. Use Generator Expressions When Appropriate

```python
# Good: Generator expression for large sequences
sum_of_squares = sum(x ** 2 for x in range(1000000))

# Avoid: List comprehension if not needed
sum_of_squares = sum([x ** 2 for x in range(1000000)])  # Creates list unnecessarily
```

---

## Common Mistakes and Pitfalls

### 1. Using Generator Multiple Times

```python
# WRONG: Generator exhausted after first use
gen = (x ** 2 for x in range(5))
squares1 = list(gen)
squares2 = list(gen)  # Empty!

# CORRECT: Create new generator
gen1 = (x ** 2 for x in range(5))
squares1 = list(gen1)
gen2 = (x ** 2 for x in range(5))
squares2 = list(gen2)
```

### 2. Not Understanding Lazy Evaluation

```python
# Generator doesn't compute until consumed
gen = (x ** 2 for x in range(1000000))  # No computation yet
squares = list(gen)  # Now computes
```

### 3. Confusing Generator Functions and Regular Functions

```python
# WRONG: Forgot yield
def squares(n):
    return [x ** 2 for x in range(n)]  # Returns list, not generator

# CORRECT: Use yield
def squares(n):
    for x in range(n):
        yield x ** 2  # Returns generator
```

---

## Practice Exercise

### Exercise: Generators

**Objective**: Create a Python program that demonstrates generators and iterators.

**Instructions**:

1. Create a file called `generators_practice.py`

2. Write a program that:
   - Creates custom iterators
   - Creates generator functions
   - Uses generator expressions
   - Demonstrates generator methods
   - Shows practical applications

3. Your program should include:
   - Iterator protocol implementation
   - Generator functions with yield
   - Generator expressions
   - Generator methods
   - Practical generator examples

**Example Solution**:

```python
"""
Generators and Iterators Practice
This program demonstrates generators and iterators in Python.
"""

print("=" * 60)
print("GENERATORS AND ITERATORS PRACTICE")
print("=" * 60)
print()

# 1. Iterator protocol
print("1. ITERATOR PROTOCOL")
print("-" * 60)
class Countdown:
    def __init__(self, start):
        self.current = start
    
    def __iter__(self):
        return self
    
    def __next__(self):
        if self.current <= 0:
            raise StopIteration
        self.current -= 1
        return self.current + 1

print("Countdown from 5:")
for number in Countdown(5):
    print(number, end=" ")
print()
print()

# 2. Basic generator function
print("2. BASIC GENERATOR FUNCTION")
print("-" * 60)
def countdown_gen(n):
    while n > 0:
        yield n
        n -= 1

print("Generator countdown:")
for number in countdown_gen(5):
    print(number, end=" ")
print()
print()

# 3. Understanding yield
print("3. UNDERSTANDING YIELD")
print("-" * 60)
def simple_gen():
    print("Start")
    yield 1
    print("Middle")
    yield 2
    print("End")
    yield 3

gen = simple_gen()
print("Using next():")
print(next(gen))
print(next(gen))
print(next(gen))
print()

# 4. Generator vs regular function
print("4. GENERATOR VS REGULAR FUNCTION")
print("-" * 60)
def squares_list(n):
    result = []
    for i in range(n):
        result.append(i ** 2)
    return result

def squares_gen(n):
    for i in range(n):
        yield i ** 2

print("Regular function (list):", squares_list(5))
print("Generator function:")
for square in squares_gen(5):
    print(square, end=" ")
print()
print()

# 5. Fibonacci generator
print("5. FIBONACCI GENERATOR")
print("-" * 60)
def fibonacci():
    a, b = 0, 1
    while True:
        yield a
        a, b = b, a + b

fib = fibonacci()
print("First 10 Fibonacci numbers:")
for _ in range(10):
    print(next(fib), end=" ")
print()
print()

# 6. Infinite sequence generator
print("6. INFINITE SEQUENCE GENERATOR")
print("-" * 60)
def natural_numbers():
    n = 1
    while True:
        yield n
        n += 1

nums = natural_numbers()
first_10 = [next(nums) for _ in range(10)]
print(f"First 10 natural numbers: {first_10}")
print()

# 7. Range generator
print("7. RANGE GENERATOR")
print("-" * 60)
def my_range(start, stop=None, step=1):
    if stop is None:
        stop = start
        start = 0
    
    current = start
    while current < stop:
        yield current
        current += step

print("my_range(5):", list(my_range(5)))
print("my_range(2, 10, 2):", list(my_range(2, 10, 2)))
print()

# 8. Generator expression
print("8. GENERATOR EXPRESSION")
print("-" * 60)
# List comprehension
squares_list = [x ** 2 for x in range(5)]
print(f"List comprehension: {squares_list}")

# Generator expression
squares_gen = (x ** 2 for x in range(5))
print(f"Generator expression: {squares_gen}")
print(f"From generator: {list(squares_gen)}")
print()

# 9. Generator expression with condition
print("9. GENERATOR EXPRESSION WITH CONDITION")
print("-" * 60)
evens = (x for x in range(20) if x % 2 == 0)
print(f"Even numbers: {list(evens)}")
print()

# 10. Multiple iterables in generator expression
print("10. MULTIPLE ITERABLES IN GENERATOR EXPRESSION")
print("-" * 60)
products = (x * y for x in [1, 2, 3] for y in [10, 20])
print(f"Products: {list(products)}")
print()

# 11. Generator expression memory efficiency
print("11. GENERATOR EXPRESSION MEMORY EFFICIENCY")
print("-" * 60)
# Generator expression doesn't create list
large_gen = (x ** 2 for x in range(1000000))
print(f"Generator created (no list yet): {type(large_gen)}")

# Only computes when consumed
first_five = [next(large_gen) for _ in range(5)]
print(f"First 5 values: {first_five}")
print()

# 12. Chunk generator
print("12. CHUNK GENERATOR")
print("-" * 60)
def chunks(data, size):
    for i in range(0, len(data), size):
        yield data[i:i + size]

data = list(range(10))
print(f"Data: {data}")
print("Chunks of 3:")
for chunk in chunks(data, 3):
    print(f"  {chunk}")
print()

# 13. Filter generator
print("13. FILTER GENERATOR")
print("-" * 60)
def filter_even(numbers):
    for num in numbers:
        if num % 2 == 0:
            yield num

numbers = range(20)
evens = list(filter_even(numbers))
print(f"Even numbers: {evens}")
print()

# 14. Pairwise generator
print("14. PAIRWISE GENERATOR")
print("-" * 60)
def pairwise(iterable):
    iterator = iter(iterable)
    prev = next(iterator)
    for item in iterator:
        yield (prev, item)
        prev = item

data = [1, 2, 3, 4, 5]
print(f"Data: {data}")
print("Pairs:")
for pair in pairwise(data):
    print(f"  {pair}")
print()

# 15. Generator with send()
print("15. GENERATOR WITH send()")
print("-" * 60)
def accumulator():
    total = 0
    while True:
        value = yield total
        if value is None:
            break
        total += value

acc = accumulator()
next(acc)  # Initialize
print(f"After send(10): {acc.send(10)}")
print(f"After send(20): {acc.send(20)}")
print(f"After send(30): {acc.send(30)}")
print()

# 16. Generator exhaustion
print("16. GENERATOR EXHAUSTION")
print("-" * 60)
gen = (x ** 2 for x in range(5))
squares1 = list(gen)
squares2 = list(gen)
print(f"First use: {squares1}")
print(f"Second use (exhausted): {squares2}")
print()

# 17. Creating new generator
print("17. CREATING NEW GENERATOR")
print("-" * 60)
gen1 = (x ** 2 for x in range(5))
gen2 = (x ** 2 for x in range(5))
print(f"Gen1: {list(gen1)}")
print(f"Gen2: {list(gen2)}")
print()

# 18. Sum with generator expression
print("18. SUM WITH GENERATOR EXPRESSION")
print("-" * 60)
# Memory efficient
sum_squares = sum(x ** 2 for x in range(10))
print(f"Sum of squares (0-9): {sum_squares}")
print()

# 19. Nested generator
print("19. NESTED GENERATOR")
print("-" * 60)
def nested_squares(n):
    for i in range(n):
        yield (j ** 2 for j in range(i + 1))

for gen in nested_squares(5):
    print(f"  {list(gen)}")
print()

# 20. Generator chain
print("20. GENERATOR CHAIN")
print("-" * 60)
def chain_generators(*iterables):
    for iterable in iterables:
        yield from iterable

gen1 = (x for x in range(3))
gen2 = (x for x in range(3, 6))
chained = chain_generators(gen1, gen2)
print(f"Chained: {list(chained)}")
print()

# 21. Prime number generator
print("21. PRIME NUMBER GENERATOR")
print("-" * 60)
def is_prime(n):
    if n < 2:
        return False
    for i in range(2, int(n ** 0.5) + 1):
        if n % i == 0:
            return False
    return True

def primes():
    n = 2
    while True:
        if is_prime(n):
            yield n
        n += 1

prime_gen = primes()
first_primes = [next(prime_gen) for _ in range(10)]
print(f"First 10 primes: {first_primes}")
print()

# 22. Generator for file processing
print("22. GENERATOR FOR FILE PROCESSING")
print("-" * 60)
def read_lines_generator(lines):
    """Simulate reading lines from file."""
    for line in lines:
        yield line.strip().upper()

lines = ["hello", "world", "python"]
print("Processing lines:")
for processed_line in read_lines_generator(lines):
    print(f"  {processed_line}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
GENERATORS AND ITERATORS PRACTICE
============================================================

1. ITERATOR PROTOCOL
------------------------------------------------------------
Countdown from 5:
5 4 3 2 1

[... rest of output ...]
```

**Challenge** (Optional):
- Create a generator for infinite sequences
- Build a pipeline using generators
- Implement a generator-based data processing system
- Create generators for large dataset processing

---

## Key Takeaways

1. **Iterators** implement `__iter__()` and `__next__()` methods
2. **Generator functions** use `yield` instead of `return`
3. **Generator expressions** create generators using syntax like list comprehensions
4. **Generators are lazy** - values computed only when needed
5. **Generators are memory efficient** - don't store all values
6. **Generators can be infinite** - represent infinite sequences
7. **Generators are single-use** - exhausted after iteration
8. **Use `yield`** to create generator functions
9. **Generator expressions** use parentheses: `(x**2 for x in range(5))`
10. **`yield from`** delegates to another generator
11. **`send()` method** sends values into generator
12. **`throw()` method** throws exception into generator
13. **`close()` method** closes generator
14. **Use generators** for large datasets or infinite sequences
15. **Generators** simplify iteration code

---

## Quiz: Generators

Test your understanding with these questions:

1. **What keyword is used in generator functions?**
   - A) `return`
   - B) `yield`
   - C) `generate`
   - D) `iterator`

2. **What methods must an iterator implement?**
   - A) `__iter__()` and `__next__()`
   - B) `iter()` and `next()`
   - C) `__iter__()` only
   - D) `__next__()` only

3. **What does a generator function return?**
   - A) List
   - B) Generator object
   - C) Iterator object
   - D) Tuple

4. **What is the syntax for generator expressions?**
   - A) `[x for x in range(5)]`
   - B) `(x for x in range(5))`
   - C) `{x for x in range(5)}`
   - D) `x for x in range(5)`

5. **Can generators be used multiple times?**
   - A) Yes, always
   - B) No, they're single-use
   - C) Only in Python 2
   - D) Only with special method

6. **What is lazy evaluation?**
   - A) Values computed immediately
   - B) Values computed only when needed
   - C) Slow computation
   - D) No computation

7. **What does `yield from` do?**
   - A) Returns value
   - B) Delegates to another generator
   - C) Stops generator
   - D) Creates new generator

8. **What exception is raised when iterator is exhausted?**
   - A) `ValueError`
   - B) `StopIteration`
   - C) `IndexError`
   - D) `GeneratorError`

9. **When should you use generators?**
   - A) Always
   - B) For large datasets or infinite sequences
   - C) Never
   - D) Only for lists

10. **What is the benefit of generators?**
    - A) Faster execution
    - B) Memory efficiency
    - C) Simpler syntax
    - D) All of the above

**Answers**:
1. B) `yield` (keyword used in generator functions)
2. A) `__iter__()` and `__next__()` (iterator protocol methods)
3. B) Generator object (generator function returns generator)
4. B) `(x for x in range(5))` (generator expression syntax)
5. B) No, they're single-use (generators are exhausted after use)
6. B) Values computed only when needed (lazy evaluation definition)
7. B) Delegates to another generator (`yield from` usage)
8. B) `StopIteration` (exception when iterator exhausted)
9. B) For large datasets or infinite sequences (appropriate use case)
10. D) All of the above (generators provide multiple benefits)

---

## Next Steps

Excellent work! You've mastered generators and iterators. You now understand:
- How iterators work
- How to create generator functions
- How to use generator expressions
- When to use generators

**What's Next?**
- Lesson 12.3: Comprehensions Advanced
- Learn advanced list comprehensions
- Understand dictionary comprehensions
- Explore set comprehensions

---

## Additional Resources

- **Iterator Types**: [docs.python.org/3/library/stdtypes.html#iterator-types](https://docs.python.org/3/library/stdtypes.html#iterator-types)
- **Generator Functions**: [docs.python.org/3/reference/expressions.html#yield-expressions](https://docs.python.org/3/reference/expressions.html#yield-expressions)
- **Generator Expressions**: [docs.python.org/3/reference/expressions.html#generator-expressions](https://docs.python.org/3/reference/expressions.html#generator-expressions)

---

*Lesson completed! You're ready to move on to the next lesson.*

