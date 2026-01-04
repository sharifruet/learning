# Lesson 18.2: Optimization Techniques

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand algorithm optimization
- Use functools.lru_cache for caching
- Understand Cython basics
- Apply optimization techniques
- Choose appropriate optimizations
- Measure optimization impact
- Understand trade-offs
- Apply optimizations in practice
- Avoid premature optimization
- Follow optimization best practices

---

## Introduction to Optimization

**Optimization** is the process of improving code performance. However, it's important to optimize the right things and measure the impact.

### Why Optimize?

- **Performance**: Make code run faster
- **Efficiency**: Use fewer resources
- **Scalability**: Handle larger workloads
- **User experience**: Faster response times
- **Cost**: Reduce computational costs

### Optimization Principles

1. **Measure first**: Profile before optimizing
2. **Optimize bottlenecks**: Focus on what matters
3. **Measure after**: Verify improvements
4. **Consider trade-offs**: Performance vs readability
5. **Avoid premature optimization**: Don't optimize too early

---

## Algorithm Optimization

### Choosing Better Algorithms

The choice of algorithm has the biggest impact on performance:

```python
# O(n²) - Slow
def find_duplicates_slow(items):
    duplicates = []
    for i in range(len(items)):
        for j in range(i + 1, len(items)):
            if items[i] == items[j]:
                duplicates.append(items[i])
    return duplicates

# O(n) - Fast
def find_duplicates_fast(items):
    seen = set()
    duplicates = []
    for item in items:
        if item in seen:
            duplicates.append(item)
        seen.add(item)
    return duplicates
```

### Time Complexity Considerations

```python
# O(n²) - Quadratic
def slow_search(data, target):
    for i in range(len(data)):
        for j in range(len(data)):
            if data[i] + data[j] == target:
                return (i, j)

# O(n) - Linear
def fast_search(data, target):
    seen = {}
    for i, value in enumerate(data):
        complement = target - value
        if complement in seen:
            return (seen[complement], i)
        seen[value] = i
```

### Data Structure Selection

Choose appropriate data structures:

```python
# Slow: List for membership testing
def check_membership_slow(items, target):
    return target in items  # O(n)

# Fast: Set for membership testing
def check_membership_fast(items, target):
    items_set = set(items)
    return target in items_set  # O(1)
```

### Loop Optimization

```python
# Slow: Multiple iterations
def process_slow(data):
    doubled = [x * 2 for x in data]
    filtered = [x for x in doubled if x > 10]
    return sum(filtered)

# Fast: Single iteration
def process_fast(data):
    total = 0
    for x in data:
        doubled = x * 2
        if doubled > 10:
            total += doubled
    return total
```

---

## Caching (functools.lru_cache)

### Basic Caching

`lru_cache` provides memoization (caching function results):

```python
from functools import lru_cache

@lru_cache(maxsize=128)
def fibonacci(n):
    if n < 2:
        return n
    return fibonacci(n - 1) + fibonacci(n - 2)

# First call computes
result1 = fibonacci(30)  # Computes

# Second call uses cache
result2 = fibonacci(30)  # From cache
```

### Understanding lru_cache

```python
from functools import lru_cache

@lru_cache(maxsize=None)  # Unlimited cache
def expensive_function(x, y):
    # Expensive computation
    return x ** y

# Results are cached
result1 = expensive_function(2, 10)  # Computes
result2 = expensive_function(2, 10)  # From cache
```

### Cache Size

```python
from functools import lru_cache

# Limited cache size (LRU = Least Recently Used)
@lru_cache(maxsize=2)
def get_data(key):
    # Expensive operation
    return f"Data for {key}"

get_data("a")  # Computes
get_data("b")  # Computes
get_data("a")  # From cache
get_data("c")  # Computes, evicts "b"
get_data("b")  # Computes again (was evicted)
```

### Cache Statistics

```python
from functools import lru_cache

@lru_cache(maxsize=128)
def cached_function(x):
    return x * 2

cached_function(5)
cached_function(10)
cached_function(5)  # From cache

# Get cache statistics
print(cached_function.cache_info())
# CacheInfo(hits=1, misses=2, maxsize=128, currsize=2)
```

### Clearing Cache

```python
from functools import lru_cache

@lru_cache(maxsize=128)
def cached_function(x):
    return x * 2

cached_function(5)
print(cached_function.cache_info().currsize)  # 1

# Clear cache
cached_function.cache_clear()
print(cached_function.cache_info().currsize)  # 0
```

### Caching Examples

#### Example 1: Fibonacci

```python
from functools import lru_cache

# Without cache: O(2^n)
def fibonacci_slow(n):
    if n < 2:
        return n
    return fibonacci_slow(n - 1) + fibonacci_slow(n - 2)

# With cache: O(n)
@lru_cache(maxsize=None)
def fibonacci_fast(n):
    if n < 2:
        return n
    return fibonacci_fast(n - 1) + fibonacci_fast(n - 2)
```

#### Example 2: Expensive Computation

```python
from functools import lru_cache
import time

@lru_cache(maxsize=128)
def expensive_computation(n):
    # Simulate expensive operation
    time.sleep(0.1)
    return n ** 2

# First call is slow
result1 = expensive_computation(5)  # Takes 0.1s

# Subsequent calls are fast
result2 = expensive_computation(5)  # Instant (from cache)
```

#### Example 3: API Calls

```python
from functools import lru_cache

@lru_cache(maxsize=100)
def fetch_user_data(user_id):
    # Simulate API call
    import requests
    response = requests.get(f'https://api.example.com/users/{user_id}')
    return response.json()

# First call makes API request
user1 = fetch_user_data(1)

# Second call uses cache
user2 = fetch_user_data(1)  # No API call
```

---

## Cython Basics

### What is Cython?

**Cython** is a programming language that is a superset of Python. It compiles Python code to C extensions for better performance.

### When to Use Cython

- **CPU-bound code**: Mathematical computations
- **Performance critical**: Need maximum speed
- **NumPy operations**: Working with arrays
- **Bottlenecks**: Identified slow code

### Basic Cython Example

#### Python Code

```python
# slow.py
def compute_sum(n):
    total = 0
    for i in range(n):
        total += i * i
    return total
```

#### Cython Code

```python
# fast.pyx
def compute_sum(int n):
    cdef int i
    cdef int total = 0
    for i in range(n):
        total += i * i
    return total
```

#### Setup File

```python
# setup.py
from setuptools import setup
from Cython.Build import cythonize

setup(
    ext_modules = cythonize("fast.pyx")
)
```

#### Building

```bash
python setup.py build_ext --inplace
```

### Cython Type Annotations

```python
# fast.pyx
def compute_sum(int n):
    cdef int i
    cdef long total = 0
    for i in range(n):
        total += i * i
    return total
```

### Cython Performance Tips

1. **Type variables**: Use `cdef` for local variables
2. **Type functions**: Type function parameters
3. **Avoid Python objects**: Use C types when possible
4. **Compile**: Always compile Cython code

---

## Other Optimization Techniques

### 1. List Comprehensions vs Loops

```python
# Slower: Loop with append
result = []
for x in range(1000):
    result.append(x * 2)

# Faster: List comprehension
result = [x * 2 for x in range(1000)]
```

### 2. Generator Expressions

```python
# Memory efficient: Generator expression
total = sum(x * 2 for x in range(1000000))

# Less efficient: List comprehension
total = sum([x * 2 for x in range(1000000)])
```

### 3. Built-in Functions

```python
# Slower: Manual implementation
def sum_manual(data):
    total = 0
    for x in data:
        total += x
    return total

# Faster: Built-in
total = sum(data)
```

### 4. String Operations

```python
# Slower: String concatenation in loop
result = ""
for word in words:
    result += word

# Faster: join()
result = "".join(words)
```

### 5. Local Variable Access

```python
# Slower: Global variable access
global_var = 1000
def slow_function():
    total = 0
    for i in range(1000):
        total += global_var * i
    return total

# Faster: Local variable
def fast_function():
    local_var = 1000
    total = 0
    for i in range(1000):
        total += local_var * i
    return total
```

### 6. Avoiding Unnecessary Operations

```python
# Slower: Unnecessary operations
def slow_function(data):
    result = []
    for item in data:
        processed = item * 2
        if processed > 10:
            result.append(processed)
    return result

# Faster: Early filtering
def fast_function(data):
    result = []
    for item in data:
        if item > 5:  # Filter early
            result.append(item * 2)
    return result
```

---

## Optimization Strategies

### Strategy 1: Measure First

```python
import cProfile
import pstats

# Profile before optimization
cProfile.run('original_function()', 'before.prof')

# Make optimizations
# ...

# Profile after optimization
cProfile.run('optimized_function()', 'after.prof')

# Compare
stats_before = pstats.Stats('before.prof')
stats_after = pstats.Stats('after.prof')
```

### Strategy 2: Optimize Hot Paths

```python
# Identify hot paths with profiling
# Then optimize those specific paths

@lru_cache(maxsize=1000)  # Cache hot path
def hot_path_function(x):
    # Expensive operation
    return expensive_computation(x)
```

### Strategy 3: Algorithm First

```python
# Always optimize algorithm before micro-optimizations
# O(n²) → O(n) is better than optimizing O(n²) code
```

### Strategy 4: Use Appropriate Data Structures

```python
# Use sets for membership testing
items_set = set(items)
if target in items_set:  # O(1)
    pass

# Use dicts for lookups
lookup_dict = {key: value for key, value in data}
result = lookup_dict[key]  # O(1)
```

---

## Common Optimization Patterns

### Pattern 1: Memoization

```python
from functools import lru_cache

@lru_cache(maxsize=128)
def compute(n):
    # Expensive computation
    return n ** 3
```

### Pattern 2: Precomputation

```python
# Precompute values
SQUARES = [i * i for i in range(1000)]

def get_square(n):
    return SQUARES[n]  # O(1) lookup
```

### Pattern 3: Lazy Evaluation

```python
# Use generators for large datasets
def process_large_data(data):
    for item in data:  # Generator, not list
        yield process(item)
```

### Pattern 4: Batch Operations

```python
# Process in batches
def process_batch(items, batch_size=100):
    for i in range(0, len(items), batch_size):
        batch = items[i:i + batch_size]
        process_batch_items(batch)
```

---

## Trade-offs and Considerations

### Performance vs Readability

```python
# Readable but slower
def clear_function(data):
    result = []
    for item in data:
        if item > 0:
            result.append(item * 2)
    return result

# Faster but less readable
def fast_function(data):
    return [x*2 for x in data if x>0]
```

### Memory vs Speed

```python
# Memory efficient: Generator
def process_generator(data):
    for item in data:
        yield process(item)

# Faster but uses more memory: List
def process_list(data):
    return [process(item) for item in data]
```

### When NOT to Optimize

- **Premature optimization**: Don't optimize too early
- **Unclear requirements**: Understand needs first
- **Readability cost**: Don't sacrifice readability
- **No bottleneck**: Don't optimize what's not slow

---

## Best Practices

### 1. Profile First

```python
# Always profile before optimizing
import cProfile
cProfile.run('my_function()')
```

### 2. Optimize Bottlenecks

```python
# Focus on code that takes most time
# (identified through profiling)
```

### 3. Measure Impact

```python
# Measure before and after
time_before = time_function()
# Optimize
time_after = time_function()
improvement = (time_before - time_after) / time_before
```

### 4. Use Appropriate Tools

```python
# Use lru_cache for function caching
# Use Cython for CPU-bound code
# Use generators for memory efficiency
```

### 5. Consider Trade-offs

```python
# Balance performance, readability, maintainability
```

### 6. Document Optimizations

```python
# Document why optimization was made
@lru_cache(maxsize=1000)  # Cache to avoid recomputing expensive API calls
def fetch_data(key):
    pass
```

---

## Practice Exercise

### Exercise: Optimization

**Objective**: Create a Python program that demonstrates optimization techniques.

**Instructions**:

1. Create a file called `optimization_practice.py`

2. Write a program that:
   - Demonstrates algorithm optimization
   - Uses functools.lru_cache
   - Shows optimization techniques
   - Compares performance
   - Applies optimizations in practice

3. Your program should include:
   - Algorithm improvements
   - Caching examples
   - Data structure optimization
   - Loop optimization
   - Built-in function usage
   - Performance comparisons
   - Real-world examples

**Example Solution**:

```python
"""
Optimization Techniques Practice
This program demonstrates various optimization techniques.
"""

from functools import lru_cache
import time

print("=" * 60)
print("OPTIMIZATION TECHNIQUES PRACTICE")
print("=" * 60)
print()

# 1. Algorithm optimization: Finding duplicates
print("1. ALGORITHM OPTIMIZATION: FINDING DUPLICATES")
print("-" * 60)

def find_duplicates_slow(items):
    """O(n²) - Slow"""
    duplicates = []
    for i in range(len(items)):
        for j in range(i + 1, len(items)):
            if items[i] == items[j]:
                duplicates.append(items[i])
    return duplicates

def find_duplicates_fast(items):
    """O(n) - Fast"""
    seen = set()
    duplicates = []
    for item in items:
        if item in seen:
            duplicates.append(item)
        seen.add(item)
    return duplicates

items = [1, 2, 3, 2, 4, 3, 5] * 100

start = time.time()
result_slow = find_duplicates_slow(items)
time_slow = time.time() - start

start = time.time()
result_fast = find_duplicates_fast(items)
time_fast = time.time() - start

print(f"Slow: {time_slow:.6f}s, Fast: {time_fast:.6f}s")
print(f"Speedup: {time_slow / time_fast:.2f}x")
print()

# 2. Caching with lru_cache
print("2. CACHING WITH lru_cache")
print("-" * 60)

def fibonacci_slow(n):
    """Without cache"""
    if n < 2:
        return n
    return fibonacci_slow(n - 1) + fibonacci_slow(n - 2)

@lru_cache(maxsize=None)
def fibonacci_fast(n):
    """With cache"""
    if n < 2:
        return n
    return fibonacci_fast(n - 1) + fibonacci_fast(n - 2)

start = time.time()
result_slow = fibonacci_slow(30)
time_slow = time.time() - start

start = time.time()
result_fast = fibonacci_fast(30)
time_fast = time.time() - start

print(f"Slow: {time_slow:.6f}s, Fast: {time_fast:.6f}s")
print(f"Speedup: {time_slow / time_fast:.2f}x")
print()

# 3. Cache statistics
print("3. CACHE STATISTICS")
print("-" * 60)

@lru_cache(maxsize=128)
def expensive_function(x):
    time.sleep(0.01)  # Simulate expensive operation
    return x * 2

expensive_function(5)
expensive_function(10)
expensive_function(5)  # From cache

print(f"Cache info: {expensive_function.cache_info()}")
print()

# 4. List comprehension vs loop
print("4. LIST COMPREHENSION VS LOOP")
print("-" * 60)

def slow_list_creation(n):
    result = []
    for i in range(n):
        result.append(i * 2)
    return result

def fast_list_creation(n):
    return [i * 2 for i in range(n)]

n = 100000
start = time.time()
slow_list_creation(n)
time_slow = time.time() - start

start = time.time()
fast_list_creation(n)
time_fast = time.time() - start

print(f"Loop: {time_slow:.6f}s, Comprehension: {time_fast:.6f}s")
print(f"Speedup: {time_slow / time_fast:.2f}x")
print()

# 5. Generator expression vs list comprehension
print("5. GENERATOR EXPRESSION VS LIST COMPREHENSION")
print("-" * 60)

def sum_with_list(n):
    return sum([i * 2 for i in range(n)])

def sum_with_generator(n):
    return sum(i * 2 for i in range(n))

n = 1000000
start = time.time()
result1 = sum_with_list(n)
time_list = time.time() - start

start = time.time()
result2 = sum_with_generator(n)
time_gen = time.time() - start

print(f"List: {time_list:.6f}s, Generator: {time_gen:.6f}s")
print(f"Memory efficient: Generator doesn't create list")
print()

# 6. String operations
print("6. STRING OPERATIONS")
print("-" * 60)

def slow_string_concat(words):
    result = ""
    for word in words:
        result += word
    return result

def fast_string_concat(words):
    return "".join(words)

words = ["hello"] * 10000
start = time.time()
slow_string_concat(words)
time_slow = time.time() - start

start = time.time()
fast_string_concat(words)
time_fast = time.time() - start

print(f"Concatenation: {time_slow:.6f}s, Join: {time_fast:.6f}s")
print(f"Speedup: {time_slow / time_fast:.2f}x")
print()

# 7. Built-in functions
print("7. BUILT-IN FUNCTIONS")
print("-" * 60)

def manual_sum(data):
    total = 0
    for x in data:
        total += x
    return total

def builtin_sum(data):
    return sum(data)

data = list(range(1000000))
start = time.time()
manual_sum(data)
time_manual = time.time() - start

start = time.time()
builtin_sum(data)
time_builtin = time.time() - start

print(f"Manual: {time_manual:.6f}s, Built-in: {time_builtin:.6f}s")
print(f"Speedup: {time_manual / time_builtin:.2f}x")
print()

# 8. Data structure selection
print("8. DATA STRUCTURE SELECTION")
print("-" * 60)

def check_in_list(items, target):
    return target in items

def check_in_set(items, target):
    items_set = set(items)
    return target in items_set

items = list(range(100000))
target = 99999

start = time.time()
check_in_list(items, target)
time_list = time.time() - start

start = time.time()
check_in_set(items, target)
time_set = time.time() - start

print(f"List: {time_list:.6f}s, Set: {time_set:.6f}s")
print(f"Speedup: {time_list / time_set:.2f}x")
print()

# 9. Local vs global variables
print("9. LOCAL VS GLOBAL VARIABLES")
print("-" * 60)

global_var = 1000

def slow_function(n):
    total = 0
    for i in range(n):
        total += global_var * i
    return total

def fast_function(n):
    local_var = 1000
    total = 0
    for i in range(n):
        total += local_var * i
    return total

n = 1000000
start = time.time()
slow_function(n)
time_global = time.time() - start

start = time.time()
fast_function(n)
time_local = time.time() - start

print(f"Global: {time_global:.6f}s, Local: {time_local:.6f}s")
print(f"Speedup: {time_local / time_global:.2f}x")
print()

# 10. Early filtering
print("10. EARLY FILTERING")
print("-" * 60)

def slow_filter(data):
    result = []
    for item in data:
        processed = item * 2
        if processed > 10:
            result.append(processed)
    return result

def fast_filter(data):
    result = []
    for item in data:
        if item > 5:  # Filter early
            result.append(item * 2)
    return result

data = list(range(100000))
start = time.time()
slow_filter(data)
time_slow = time.time() - start

start = time.time()
fast_filter(data)
time_fast = time.time() - start

print(f"Late filter: {time_slow:.6f}s, Early filter: {time_fast:.6f}s")
print(f"Speedup: {time_slow / time_fast:.2f}x")
print()

# 11. Precomputation
print("11. PRECOMPUTATION")
print("-" * 60)

def get_square_slow(n):
    return n * n

SQUARES = [i * i for i in range(1000)]

def get_square_fast(n):
    return SQUARES[n]

start = time.time()
for i in range(1000):
    get_square_slow(i)
time_slow = time.time() - start

start = time.time()
for i in range(1000):
    get_square_fast(i)
time_fast = time.time() - start

print(f"Compute: {time_slow:.6f}s, Precomputed: {time_fast:.6f}s")
print(f"Speedup: {time_slow / time_fast:.2f}x")
print()

# 12. Cache with parameters
print("12. CACHE WITH PARAMETERS")
print("-" * 60)

@lru_cache(maxsize=128)
def compute_power(base, exponent):
    time.sleep(0.01)  # Simulate expensive operation
    return base ** exponent

start = time.time()
compute_power(2, 10)
compute_power(3, 10)
compute_power(2, 10)  # From cache
time_cached = time.time() - start

print(f"With cache: {time_cached:.6f}s")
print(f"Cache info: {compute_power.cache_info()}")
print()

# 13. Real-world: Expensive computation caching
print("13. REAL-WORLD: EXPENSIVE COMPUTATION CACHING")
print("-" * 60)

@lru_cache(maxsize=1000)
def process_data(data_id):
    """Simulate expensive data processing"""
    time.sleep(0.1)  # Simulate processing
    return f"Processed data {data_id}"

# First call processes
result1 = process_data(1)  # Takes 0.1s

# Subsequent calls use cache
result2 = process_data(1)  # Instant
result3 = process_data(2)  # Takes 0.1s
result4 = process_data(1)  # Instant

print(f"Cache hits: {process_data.cache_info().hits}")
print(f"Cache misses: {process_data.cache_info().misses}")
print()

# 14. Batch processing
print("14. BATCH PROCESSING")
print("-" * 60)

def process_single(items):
    results = []
    for item in items:
        results.append(process_item(item))
    return results

def process_batch(items, batch_size=100):
    results = []
    for i in range(0, len(items), batch_size):
        batch = items[i:i + batch_size]
        batch_results = process_batch_items(batch)
        results.extend(batch_results)
    return results

def process_item(item):
    return item * 2

def process_batch_items(batch):
    return [item * 2 for item in batch]

items = list(range(10000))
# Batch processing is more efficient for large datasets
print("Batch processing is more efficient for large operations")
print()

# 15. Optimization summary
print("15. OPTIMIZATION SUMMARY")
print("-" * 60)
print("Key optimization techniques:")
print("1. Algorithm optimization (biggest impact)")
print("2. Caching with lru_cache")
print("3. Appropriate data structures")
print("4. Built-in functions")
print("5. List comprehensions")
print("6. Generator expressions")
print("7. String join vs concatenation")
print("8. Local variable access")
print("9. Early filtering")
print("10. Precomputation")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
OPTIMIZATION TECHNIQUES PRACTICE
============================================================

1. ALGORITHM OPTIMIZATION: FINDING DUPLICATES
------------------------------------------------------------
Slow: 0.123456s, Fast: 0.001234s
Speedup: 100.00x

[... rest of output ...]
```

**Challenge** (Optional):
- Optimize a real application
- Compare multiple optimization strategies
- Measure and document performance improvements
- Create an optimization guide for a specific codebase

---

## Key Takeaways

1. **Algorithm optimization** - biggest performance impact
2. **lru_cache** - memoization for function results
3. **Caching** - avoid recomputing expensive operations
4. **Data structures** - choose appropriate structures
5. **List comprehensions** - faster than loops
6. **Generator expressions** - memory efficient
7. **Built-in functions** - use optimized built-ins
8. **String operations** - use join() not concatenation
9. **Local variables** - faster than global
10. **Early filtering** - filter before processing
11. **Precomputation** - compute once, use many times
12. **Cython** - compile to C for speed
13. **Measure first** - profile before optimizing
14. **Optimize bottlenecks** - focus on what matters
15. **Trade-offs** - balance performance and readability

---

## Quiz: Optimization

Test your understanding with these questions:

1. **What has the biggest impact on performance?**
   - A) Micro-optimizations
   - B) Algorithm choice
   - C) Variable names
   - D) Comments

2. **What does lru_cache do?**
   - A) Caches function results
   - B) Speeds up loops
   - C) Optimizes algorithms
   - D) Nothing

3. **What is LRU?**
   - A) Least Recently Used
   - B) Long Running Unit
   - C) Large Resource Usage
   - D) Low Resource Usage

4. **When should you use Cython?**
   - A) Always
   - B) For CPU-bound code
   - C) For I/O-bound code
   - D) Never

5. **What is faster: list or set for membership?**
   - A) List
   - B) Set
   - C) Same
   - D) Depends

6. **What is faster: loop or list comprehension?**
   - A) Loop
   - B) List comprehension
   - C) Same
   - D) Depends

7. **What should you do first?**
   - A) Optimize
   - B) Profile
   - C) Deploy
   - D) Test

8. **What should you optimize?**
   - A) Everything
   - B) Bottlenecks
   - C) Nothing
   - D) Random code

9. **What is memoization?**
   - A) Caching function results
   - B) Optimizing loops
   - C) Using generators
   - D) Nothing

10. **When should you NOT optimize?**
    - A) Always optimize
    - B) Premature optimization
    - C) Never optimize
    - D) Only on Fridays

**Answers**:
1. B) Algorithm choice (biggest performance impact)
2. A) Caches function results (lru_cache purpose)
3. A) Least Recently Used (LRU definition)
4. B) For CPU-bound code (Cython use case)
5. B) Set (O(1) vs O(n))
6. B) List comprehension (generally faster)
7. B) Profile (measure first)
8. B) Bottlenecks (what to optimize)
9. A) Caching function results (memoization definition)
10. B) Premature optimization (when not to optimize)

---

## Next Steps

Excellent work! You've mastered optimization techniques. You now understand:
- Algorithm optimization
- Caching with functools.lru_cache
- Cython basics
- Various optimization techniques

**What's Next?**
- Course 4: Python for Web Development
- Learn web development with Python
- Understand web frameworks
- Explore web APIs

---

## Additional Resources

- **functools.lru_cache**: [docs.python.org/3/library/functools.html#functools.lru_cache](https://docs.python.org/3/library/functools.html#functools.lru_cache)
- **Cython**: [cython.org/](https://cython.org/)
- **Performance Tips**: [wiki.python.org/moin/PythonSpeed/PerformanceTips](https://wiki.python.org/moin/PythonSpeed/PerformanceTips)

---

*Lesson completed! You're ready to move on to the next course.*

