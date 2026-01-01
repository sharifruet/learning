# Lesson 6.5: Recursion

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what recursion is and how it works
- Write recursive functions in Python
- Identify base cases and recursive cases
- Understand the call stack and how recursion works
- Recognize when to use recursion vs iteration
- Avoid infinite recursion and stack overflow
- Apply recursion to solve common problems
- Understand tail recursion and optimization
- Write efficient recursive solutions

---

## Introduction to Recursion

**Recursion** is a programming technique where a function calls itself to solve a problem. Recursive functions break down a problem into smaller, similar subproblems until they reach a base case that can be solved directly.

### Key Concepts

1. **Base Case**: The condition that stops the recursion
2. **Recursive Case**: The part where the function calls itself
3. **Call Stack**: How function calls are managed in memory

### Why Use Recursion?

- **Elegant solutions** for certain problems
- **Natural fit** for problems with recursive structure (trees, graphs, etc.)
- **Divide and conquer** algorithms
- **Mathematical problems** (factorial, Fibonacci, etc.)

### When to Use Recursion

✅ **Good for**:
- Problems that can be broken into similar subproblems
- Tree/graph traversal
- Mathematical sequences
- Divide and conquer algorithms

❌ **Avoid for**:
- Simple iterative solutions
- Performance-critical code (can be slower)
- Very deep recursion (stack overflow risk)

---

## Basic Recursion

### Simple Example: Countdown

```python
def countdown(n):
    # Base case
    if n <= 0:
        print("Blast off!")
        return
    
    # Recursive case
    print(n)
    countdown(n - 1)  # Call itself with smaller value

countdown(5)
# Output:
# 5
# 4
# 3
# 2
# 1
# Blast off!
```

### How Recursion Works

```python
def countdown(n):
    print(f"Entering countdown({n})")
    if n <= 0:
        print("Base case reached!")
        return
    countdown(n - 1)
    print(f"Exiting countdown({n})")

countdown(3)
# Output:
# Entering countdown(3)
# Entering countdown(2)
# Entering countdown(1)
# Entering countdown(0)
# Base case reached!
# Exiting countdown(0)
# Exiting countdown(1)
# Exiting countdown(2)
# Exiting countdown(3)
```

---

## Factorial

The factorial of n (n!) is a classic recursive example.

### Mathematical Definition

```
n! = n × (n-1) × (n-2) × ... × 1
0! = 1
1! = 1
```

### Recursive Definition

```
factorial(n) = n × factorial(n-1)  if n > 1
factorial(n) = 1                    if n <= 1
```

### Implementation

```python
def factorial(n):
    # Base case
    if n <= 1:
        return 1
    
    # Recursive case
    return n * factorial(n - 1)

print(factorial(5))  # Output: 120
print(factorial(0))  # Output: 1
print(factorial(1))  # Output: 1
```

### Step-by-Step Execution

```
factorial(5)
= 5 × factorial(4)
= 5 × (4 × factorial(3))
= 5 × (4 × (3 × factorial(2)))
= 5 × (4 × (3 × (2 × factorial(1))))
= 5 × (4 × (3 × (2 × 1)))
= 5 × (4 × (3 × 2))
= 5 × (4 × 6)
= 5 × 24
= 120
```

---

## Fibonacci Sequence

The Fibonacci sequence is another classic recursive problem.

### Mathematical Definition

```
F(0) = 0
F(1) = 1
F(n) = F(n-1) + F(n-2)  for n > 1
```

### Recursive Implementation

```python
def fibonacci(n):
    # Base cases
    if n == 0:
        return 0
    if n == 1:
        return 1
    
    # Recursive case
    return fibonacci(n - 1) + fibonacci(n - 2)

print(fibonacci(6))  # Output: 8
# Sequence: 0, 1, 1, 2, 3, 5, 8, 13, 21, ...
```

### Visualizing Recursion

```
fibonacci(5)
= fibonacci(4) + fibonacci(3)
= (fibonacci(3) + fibonacci(2)) + (fibonacci(2) + fibonacci(1))
= ...
```

**Note**: This recursive implementation is inefficient (recalculates same values). We'll see optimization later.

---

## Base Case and Recursive Case

Every recursive function needs:

1. **Base Case**: Condition that stops recursion (prevents infinite loop)
2. **Recursive Case**: Calls function with smaller/simpler input

### Example Structure

```python
def recursive_function(parameter):
    # Base case - must come first!
    if base_condition:
        return base_value
    
    # Recursive case
    return recursive_function(simplified_parameter)
```

### Power Function

```python
def power(base, exponent):
    # Base case
    if exponent == 0:
        return 1
    if exponent == 1:
        return base
    
    # Recursive case
    return base * power(base, exponent - 1)

print(power(2, 3))  # Output: 8
print(power(5, 0))  # Output: 1
```

### Sum of Numbers

```python
def sum_numbers(n):
    # Base case
    if n <= 0:
        return 0
    
    # Recursive case
    return n + sum_numbers(n - 1)

print(sum_numbers(5))  # Output: 15 (1+2+3+4+5)
```

---

## Common Recursive Patterns

### Pattern 1: Linear Recursion

Each call makes one recursive call:

```python
def factorial(n):
    if n <= 1:
        return 1
    return n * factorial(n - 1)  # One recursive call
```

### Pattern 2: Binary Recursion

Each call makes two recursive calls:

```python
def fibonacci(n):
    if n <= 1:
        return n
    return fibonacci(n - 1) + fibonacci(n - 2)  # Two recursive calls
```

### Pattern 3: Multiple Recursion

Each call makes multiple recursive calls:

```python
def tower_of_hanoi(n, source, destination, auxiliary):
    if n == 1:
        print(f"Move disk from {source} to {destination}")
        return
    
    # Multiple recursive calls
    tower_of_hanoi(n - 1, source, auxiliary, destination)
    print(f"Move disk from {source} to {destination}")
    tower_of_hanoi(n - 1, auxiliary, destination, source)
```

---

## Recursion vs Iteration

Many recursive problems can also be solved iteratively.

### Factorial: Recursive vs Iterative

```python
# Recursive
def factorial_recursive(n):
    if n <= 1:
        return 1
    return n * factorial_recursive(n - 1)

# Iterative
def factorial_iterative(n):
    result = 1
    for i in range(1, n + 1):
        result *= i
    return result

# Both produce same result
print(factorial_recursive(5))  # Output: 120
print(factorial_iterative(5))  # Output: 120
```

### When to Use Each

**Use Recursion**:
- Problem naturally recursive (trees, graphs)
- Code is clearer/more elegant
- Performance not critical

**Use Iteration**:
- Simple problems
- Performance critical
- Deep recursion risk
- More memory efficient

---

## Common Recursive Problems

### Problem 1: Sum of List

```python
def sum_list(numbers):
    # Base case
    if not numbers:
        return 0
    
    # Recursive case
    return numbers[0] + sum_list(numbers[1:])

numbers = [1, 2, 3, 4, 5]
print(sum_list(numbers))  # Output: 15
```

### Problem 2: Find Maximum

```python
def find_max(numbers):
    # Base case
    if len(numbers) == 1:
        return numbers[0]
    
    # Recursive case
    max_rest = find_max(numbers[1:])
    return numbers[0] if numbers[0] > max_rest else max_rest

numbers = [3, 1, 4, 1, 5, 9, 2, 6]
print(find_max(numbers))  # Output: 9
```

### Problem 3: Reverse String

```python
def reverse_string(text):
    # Base case
    if len(text) <= 1:
        return text
    
    # Recursive case
    return reverse_string(text[1:]) + text[0]

print(reverse_string("hello"))  # Output: olleh
```

### Problem 4: Palindrome Check

```python
def is_palindrome(text):
    # Base case
    if len(text) <= 1:
        return True
    
    # Recursive case
    if text[0] != text[-1]:
        return False
    return is_palindrome(text[1:-1])

print(is_palindrome("racecar"))  # Output: True
print(is_palindrome("hello"))    # Output: False
```

### Problem 5: Binary Search

```python
def binary_search(arr, target, left=0, right=None):
    if right is None:
        right = len(arr) - 1
    
    # Base case
    if left > right:
        return -1  # Not found
    
    # Recursive case
    mid = (left + right) // 2
    if arr[mid] == target:
        return mid
    elif arr[mid] > target:
        return binary_search(arr, target, left, mid - 1)
    else:
        return binary_search(arr, target, mid + 1, right)

numbers = [1, 3, 5, 7, 9, 11, 13, 15]
print(binary_search(numbers, 7))   # Output: 3
print(binary_search(numbers, 10))   # Output: -1
```

---

## Call Stack and Memory

### Understanding the Call Stack

When a function calls itself, each call is added to the **call stack**:

```python
def countdown(n):
    if n <= 0:
        return
    print(n)
    countdown(n - 1)

countdown(3)
```

**Call Stack**:
```
countdown(0)  ← Top of stack (executes first)
countdown(1)
countdown(2)
countdown(3)  ← Bottom of stack (called first)
```

### Stack Overflow

If recursion goes too deep, you get a `RecursionError`:

```python
def infinite_recursion():
    infinite_recursion()  # No base case!

# infinite_recursion()  # RecursionError: maximum recursion depth exceeded
```

### Maximum Recursion Depth

Python has a default recursion limit:

```python
import sys
print(sys.getrecursionlimit())  # Usually 1000

# Can change (but be careful!)
sys.setrecursionlimit(2000)
```

---

## Tail Recursion

**Tail recursion** occurs when the recursive call is the last operation in the function.

### Non-Tail Recursive

```python
def factorial(n):
    if n <= 1:
        return 1
    return n * factorial(n - 1)  # Multiplication after recursive call
```

### Tail Recursive

```python
def factorial_tail(n, accumulator=1):
    if n <= 1:
        return accumulator
    return factorial_tail(n - 1, n * accumulator)  # Recursive call is last

print(factorial_tail(5))  # Output: 120
```

**Note**: Python doesn't optimize tail recursion, but the pattern is still useful.

---

## Memoization (Optimization)

**Memoization** stores results of expensive function calls to avoid recalculating.

### Fibonacci Without Memoization

```python
def fibonacci(n):
    if n <= 1:
        return n
    return fibonacci(n - 1) + fibonacci(n - 2)

# Very slow for large n (recalculates same values)
```

### Fibonacci With Memoization

```python
def fibonacci_memo(n, memo={}):
    # Base cases
    if n <= 1:
        return n
    
    # Check if already calculated
    if n in memo:
        return memo[n]
    
    # Calculate and store
    memo[n] = fibonacci_memo(n - 1, memo) + fibonacci_memo(n - 2, memo)
    return memo[n]

# Much faster!
print(fibonacci_memo(40))  # Fast
```

### Using functools.lru_cache

```python
from functools import lru_cache

@lru_cache(maxsize=None)
def fibonacci(n):
    if n <= 1:
        return n
    return fibonacci(n - 1) + fibonacci(n - 2)

# Automatically memoized!
print(fibonacci(40))  # Fast
```

---

## Common Mistakes and Pitfalls

### 1. Missing Base Case

```python
# Wrong: no base case
def bad_recursion(n):
    return n + bad_recursion(n - 1)  # Infinite recursion!

# Correct: has base case
def good_recursion(n):
    if n <= 0:
        return 0
    return n + good_recursion(n - 1)
```

### 2. Base Case Never Reached

```python
# Wrong: base case never reached
def bad_factorial(n):
    if n == 0:  # Never reached if n starts negative
        return 1
    return n * bad_factorial(n - 1)

# bad_factorial(-1)  # Infinite recursion!

# Correct: handle all cases
def good_factorial(n):
    if n <= 1:
        return 1
    return n * good_factorial(n - 1)
```

### 3. Not Simplifying the Problem

```python
# Wrong: doesn't simplify
def bad_sum(numbers):
    if not numbers:
        return 0
    return numbers[0] + bad_sum(numbers)  # Same problem!

# Correct: simplifies problem
def good_sum(numbers):
    if not numbers:
        return 0
    return numbers[0] + good_sum(numbers[1:])  # Smaller problem
```

### 4. Stack Overflow

```python
# Be careful with deep recursion
def deep_recursion(n):
    if n <= 0:
        return 0
    return 1 + deep_recursion(n - 1)

# deep_recursion(10000)  # May cause RecursionError
```

---

## Best Practices

### 1. Always Define Base Case First

```python
def recursive_function(n):
    # Base case first!
    if base_condition:
        return base_value
    
    # Then recursive case
    return recursive_case
```

### 2. Ensure Problem Gets Simpler

```python
# Good: problem gets smaller
def factorial(n):
    if n <= 1:
        return 1
    return n * factorial(n - 1)  # n-1 is smaller

# Bad: problem doesn't change
def bad_function(n):
    if n <= 0:
        return 0
    return bad_function(n)  # Same problem!
```

### 3. Use Memoization for Repeated Calculations

```python
# For functions that recalculate same values
from functools import lru_cache

@lru_cache(maxsize=None)
def expensive_recursive_function(n):
    # Implementation
    pass
```

### 4. Consider Iterative Alternative

```python
# Sometimes iteration is better
def factorial_iterative(n):
    result = 1
    for i in range(1, n + 1):
        result *= i
    return result
```

---

## Practice Exercise

### Exercise: Recursion Practice

**Objective**: Create a Python program that demonstrates various recursive functions and patterns.

**Instructions**:

1. Create a file called `recursion_practice.py`

2. Write a program that:
   - Implements classic recursive problems
   - Demonstrates base cases and recursive cases
   - Shows recursion vs iteration
   - Uses memoization for optimization
   - Implements practical recursive solutions

3. Your program should include:
   - Factorial
   - Fibonacci
   - Sum of list
   - String reversal
   - Binary search
   - Tree-like problems

**Example Solution**:

```python
"""
Recursion Practice
This program demonstrates various recursive functions and patterns.
"""

from functools import lru_cache

print("=" * 60)
print("RECURSION PRACTICE")
print("=" * 60)
print()

# 1. Factorial
print("1. FACTORIAL")
print("-" * 60)
def factorial(n):
    """Calculate factorial recursively."""
    if n <= 1:
        return 1
    return n * factorial(n - 1)

for i in range(6):
    print(f"  {i}! = {factorial(i)}")
print()

# 2. Fibonacci
print("2. FIBONACCI")
print("-" * 60)
def fibonacci(n):
    """Calculate Fibonacci number recursively."""
    if n <= 1:
        return n
    return fibonacci(n - 1) + fibonacci(n - 2)

print("Fibonacci sequence (first 10):")
for i in range(10):
    print(f"  F({i}) = {fibonacci(i)}")
print()

# 3. Fibonacci with Memoization
print("3. FIBONACCI WITH MEMOIZATION")
print("-" * 60)
@lru_cache(maxsize=None)
def fibonacci_memo(n):
    """Fibonacci with automatic memoization."""
    if n <= 1:
        return n
    return fibonacci_memo(n - 1) + fibonacci_memo(n - 2)

print(f"F(30) with memoization: {fibonacci_memo(30)}")
print()

# 4. Sum of List
print("4. SUM OF LIST")
print("-" * 60)
def sum_list(numbers):
    """Sum list elements recursively."""
    if not numbers:
        return 0
    return numbers[0] + sum_list(numbers[1:])

numbers = [1, 2, 3, 4, 5]
print(f"Sum of {numbers}: {sum_list(numbers)}")
print()

# 5. Find Maximum
print("5. FIND MAXIMUM")
print("-" * 60)
def find_max(numbers):
    """Find maximum value recursively."""
    if len(numbers) == 1:
        return numbers[0]
    max_rest = find_max(numbers[1:])
    return numbers[0] if numbers[0] > max_rest else max_rest

numbers = [3, 1, 4, 1, 5, 9, 2, 6]
print(f"Maximum of {numbers}: {find_max(numbers)}")
print()

# 6. Reverse String
print("6. REVERSE STRING")
print("-" * 60)
def reverse_string(text):
    """Reverse string recursively."""
    if len(text) <= 1:
        return text
    return reverse_string(text[1:]) + text[0]

text = "hello"
print(f"Reverse of '{text}': '{reverse_string(text)}'")
print()

# 7. Palindrome Check
print("7. PALINDROME CHECK")
print("-" * 60)
def is_palindrome(text):
    """Check if string is palindrome recursively."""
    if len(text) <= 1:
        return True
    if text[0] != text[-1]:
        return False
    return is_palindrome(text[1:-1])

test_words = ["racecar", "hello", "level", "python"]
for word in test_words:
    result = is_palindrome(word)
    print(f"  '{word}' is palindrome: {result}")
print()

# 8. Power Function
print("8. POWER FUNCTION")
print("-" * 60)
def power(base, exponent):
    """Calculate base^exponent recursively."""
    if exponent == 0:
        return 1
    if exponent == 1:
        return base
    return base * power(base, exponent - 1)

print(f"2^3 = {power(2, 3)}")
print(f"5^4 = {power(5, 4)}")
print(f"10^0 = {power(10, 0)}")
print()

# 9. Countdown
print("9. COUNTDOWN")
print("-" * 60)
def countdown(n):
    """Countdown recursively."""
    if n <= 0:
        print("  Blast off!")
        return
    print(f"  {n}")
    countdown(n - 1)

countdown(5)
print()

# 10. Sum of Numbers
print("10. SUM OF NUMBERS")
print("-" * 60)
def sum_numbers(n):
    """Sum numbers from 1 to n recursively."""
    if n <= 0:
        return 0
    return n + sum_numbers(n - 1)

print(f"Sum of 1 to 5: {sum_numbers(5)}")
print(f"Sum of 1 to 10: {sum_numbers(10)}")
print()

# 11. Binary Search
print("11. BINARY SEARCH")
print("-" * 60)
def binary_search(arr, target, left=0, right=None):
    """Binary search recursively."""
    if right is None:
        right = len(arr) - 1
    
    if left > right:
        return -1
    
    mid = (left + right) // 2
    if arr[mid] == target:
        return mid
    elif arr[mid] > target:
        return binary_search(arr, target, left, mid - 1)
    else:
        return binary_search(arr, target, mid + 1, right)

numbers = [1, 3, 5, 7, 9, 11, 13, 15]
target = 7
index = binary_search(numbers, target)
print(f"Searching for {target} in {numbers}")
print(f"  Found at index: {index}")
print()

# 12. Recursion vs Iteration
print("12. RECURSION vs ITERATION")
print("-" * 60)
# Recursive
def factorial_recursive(n):
    if n <= 1:
        return 1
    return n * factorial_recursive(n - 1)

# Iterative
def factorial_iterative(n):
    result = 1
    for i in range(1, n + 1):
        result *= i
    return result

n = 5
print(f"Factorial of {n}:")
print(f"  Recursive: {factorial_recursive(n)}")
print(f"  Iterative: {factorial_iterative(n)}")
print()

# 13. Tower of Hanoi
print("13. TOWER OF HANOI")
print("-" * 60)
def tower_of_hanoi(n, source, destination, auxiliary):
    """Solve Tower of Hanoi recursively."""
    if n == 1:
        print(f"    Move disk from {source} to {destination}")
        return
    
    tower_of_hanoi(n - 1, source, auxiliary, destination)
    print(f"    Move disk from {source} to {destination}")
    tower_of_hanoi(n - 1, auxiliary, destination, source)

print("Tower of Hanoi (3 disks):")
tower_of_hanoi(3, "A", "C", "B")
print()

# 14. Greatest Common Divisor (GCD)
print("14. GREATEST COMMON DIVISOR (GCD)")
print("-" * 60)
def gcd(a, b):
    """Calculate GCD using Euclidean algorithm."""
    if b == 0:
        return a
    return gcd(b, a % b)

print(f"GCD(48, 18) = {gcd(48, 18)}")
print(f"GCD(17, 5) = {gcd(17, 5)}")
print()

# 15. List Flattening
print("15. LIST FLATTENING")
print("-" * 60)
def flatten_list(nested_list):
    """Flatten nested list recursively."""
    result = []
    for item in nested_list:
        if isinstance(item, list):
            result.extend(flatten_list(item))
        else:
            result.append(item)
    return result

nested = [1, [2, 3], [4, [5, 6]], 7]
flattened = flatten_list(nested)
print(f"Nested: {nested}")
print(f"Flattened: {flattened}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
RECURSION PRACTICE
============================================================

1. FACTORIAL
------------------------------------------------------------
  0! = 1
  1! = 1
  2! = 2
  3! = 6
  4! = 5
  5! = 120

[... rest of output ...]
```

**Challenge** (Optional):
- Implement more complex recursive algorithms
- Build a recursive tree traversal system
- Create a recursive parser
- Implement merge sort or quick sort
- Build a recursive file system navigator

---

## Key Takeaways

1. **Recursion is a function calling itself** to solve smaller subproblems
2. **Base case is essential** - stops recursion and prevents infinite loops
3. **Recursive case** calls function with simpler/smaller input
4. **Call stack** manages function calls (can overflow if too deep)
5. **Memoization** optimizes recursive functions that recalculate values
6. **Recursion vs iteration** - choose based on problem and performance needs
7. **Tail recursion** - recursive call is last operation (Python doesn't optimize)
8. **Common patterns**: linear, binary, multiple recursion
9. **Always ensure base case is reachable** and problem gets simpler
10. **Use recursion for problems** that naturally have recursive structure

---

## Quiz: Recursion

Test your understanding with these questions:

1. **What is recursion?**
   - A) A loop
   - B) A function calling itself
   - C) A variable
   - D) An error

2. **What is a base case?**
   - A) The recursive call
   - B) The condition that stops recursion
   - C) The function definition
   - D) The return value

3. **What happens without a base case?**
   - A) Function works fine
   - B) Infinite recursion
   - C) Syntax error
   - D) Returns None

4. **What is the result of `factorial(0)`?**
   - A) `0`
   - B) `1`
   - C) Error
   - D) `None`

5. **What is tail recursion?**
   - A) Recursion at the end of a list
   - B) Recursive call is the last operation
   - C) Recursion with two calls
   - D) Infinite recursion

6. **What is memoization?**
   - A) Forgetting values
   - B) Storing results to avoid recalculation
   - C) Removing recursion
   - D) Error handling

7. **What is the maximum recursion depth in Python (default)?**
   - A) 100
   - B) 500
   - C) 1000
   - D) Unlimited

8. **When should you use recursion?**
   - A) Always
   - B) For problems with recursive structure
   - C) Never
   - D) Only for loops

9. **What is the base case for Fibonacci?**
   - A) `F(0) = 0, F(1) = 1`
   - B) `F(0) = 1, F(1) = 1`
   - C) `F(0) = 0, F(1) = 0`
   - D) No base case

10. **What causes a RecursionError?**
    - A) Missing return statement
    - B) Too many recursive calls (stack overflow)
    - C) Wrong parameter
    - D) Syntax error

**Answers**:
1. B) A function calling itself (recursion definition)
2. B) The condition that stops recursion (prevents infinite recursion)
3. B) Infinite recursion (no stopping condition)
4. B) `1` (factorial of 0 is 1 by definition)
5. B) Recursive call is the last operation (tail recursion pattern)
6. B) Storing results to avoid recalculation (optimization technique)
7. C) 1000 (default recursion limit in Python)
8. B) For problems with recursive structure (trees, graphs, divide-and-conquer)
9. A) `F(0) = 0, F(1) = 1` (Fibonacci base cases)
10. B) Too many recursive calls (stack overflow - exceeds recursion limit)

---

## Next Steps

Excellent work! You've mastered recursion. You now understand:
- How recursion works and when to use it
- Base cases and recursive cases
- Common recursive problems and patterns
- Recursion vs iteration
- Memoization and optimization
- Best practices and pitfalls

**What's Next?**
- Module 7: String Manipulation
- Practice solving more recursive problems
- Learn about tree and graph algorithms
- Explore divide and conquer algorithms

---

## Additional Resources

- **Recursion in Python**: [docs.python.org/3/tutorial/introduction.html#recursion](https://docs.python.org/3/tutorial/introduction.html#recursion)
- **functools.lru_cache**: [docs.python.org/3/library/functools.html#functools.lru_cache](https://docs.python.org/3/library/functools.html#functools.lru_cache)
- **Algorithm Design**: Research recursive algorithms and their applications

---

*Lesson completed! You're ready to move on to the next lesson.*

