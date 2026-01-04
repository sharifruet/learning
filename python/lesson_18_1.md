# Lesson 18.1: Profiling

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what profiling is
- Use the cProfile module
- Identify performance bottlenecks
- Analyze profiling results
- Use profiling tools effectively
- Understand profiling output
- Apply profiling to real code
- Interpret profiling statistics
- Use line_profiler for line-by-line profiling
- Make informed optimization decisions

---

## Introduction to Profiling

**Profiling** is the process of measuring where your program spends time and which functions are called most often. It helps identify performance bottlenecks.

### Why Profile?

- **Find bottlenecks**: Identify slow code
- **Measure performance**: Get actual timing data
- **Optimize effectively**: Focus on what matters
- **Verify improvements**: Measure before and after
- **Data-driven decisions**: Make optimization decisions based on data

### What is Profiling?

Profiling measures:
- **Execution time**: How long functions take
- **Call counts**: How many times functions are called
- **Call hierarchy**: Which functions call which
- **Memory usage**: How much memory is used (with some tools)

---

## cProfile Module

### Basic Profiling

The `cProfile` module provides deterministic profiling:

```python
import cProfile

def slow_function():
    total = 0
    for i in range(1000000):
        total += i * i
    return total

# Profile the function
cProfile.run('slow_function()')
```

### Profiling with runctx()

```python
import cProfile

def add(x, y):
    return x + y

# Profile with context
cProfile.runctx('result = add(2, 3)', globals(), locals())
```

### Saving Profile Results

```python
import cProfile

def my_function():
    # Your code here
    pass

# Save profile to file
cProfile.run('my_function()', 'profile_output.prof')
```

### Analyzing Profile Results

```python
import cProfile
import pstats

# Run profiling
cProfile.run('my_function()', 'profile_output.prof')

# Analyze results
stats = pstats.Stats('profile_output.prof')
stats.sort_stats('cumulative')
stats.print_stats(10)  # Print top 10
```

---

## Understanding Profile Output

### Profile Statistics

Profile output shows:
- **ncalls**: Number of calls
- **tottime**: Total time in function (excluding subcalls)
- **percall**: Time per call (tottime / ncalls)
- **cumtime**: Cumulative time (including subcalls)
- **percall**: Cumulative time per call
- **filename:lineno(function)**: Location of function

### Example Output

```
         1000003 function calls in 2.345 seconds

   Ordered by: cumulative time

   ncalls  tottime  percall  cumtime  percall filename:lineno(function)
        1    0.000    0.000    2.345    2.345 <string>:1(<module>)
        1    2.345    2.345    2.345    2.345 example.py:5(slow_function)
  1000000    0.000    0.000    0.000    0.000 {built-in method range}
```

### Sorting Options

```python
stats.sort_stats('cumulative')  # By cumulative time
stats.sort_stats('tottime')     # By total time
stats.sort_stats('calls')       # By call count
stats.sort_stats('name')        # By function name
```

### Filtering Results

```python
stats.print_stats('my_module')  # Only functions in my_module
stats.print_stats(0.1)          # Only functions taking > 10% of time
```

---

## Identifying Bottlenecks

### What to Look For

1. **High cumulative time**: Functions that take a lot of time
2. **High call count**: Functions called many times
3. **High per-call time**: Slow individual function calls
4. **Recursive calls**: Functions calling themselves many times

### Example: Finding Bottlenecks

```python
import cProfile
import pstats

def process_data(data):
    result = []
    for item in data:
        # Expensive operation
        processed = expensive_operation(item)
        result.append(processed)
    return result

def expensive_operation(item):
    total = 0
    for i in range(1000):
        total += i * item
    return total

# Profile
data = list(range(100))
cProfile.run('process_data(data)', 'profile.prof')

# Analyze
stats = pstats.Stats('profile.prof')
stats.sort_stats('cumulative')
stats.print_stats(20)
```

### Common Bottlenecks

1. **Loops**: Nested loops, large iterations
2. **I/O operations**: File I/O, network I/O
3. **String operations**: Concatenation, formatting
4. **List operations**: Appending, searching
5. **Function calls**: Too many function calls
6. **Recursion**: Deep recursion

---

## Profiling Techniques

### Technique 1: Profile Entire Script

```python
# profile_script.py
import cProfile
import pstats

if __name__ == '__main__':
    cProfile.run('main()', 'profile.prof')
    stats = pstats.Stats('profile.prof')
    stats.sort_stats('cumulative')
    stats.print_stats()
```

### Technique 2: Profile Specific Function

```python
import cProfile

def my_function():
    # Code to profile
    pass

# Profile just this function
cProfile.run('my_function()')
```

### Technique 3: Profile with Decorator

```python
import cProfile
import pstats
from functools import wraps

def profile_decorator(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        profiler = cProfile.Profile()
        profiler.enable()
        result = func(*args, **kwargs)
        profiler.disable()
        stats = pstats.Stats(profiler)
        stats.sort_stats('cumulative')
        stats.print_stats(10)
        return result
    return wrapper

@profile_decorator
def my_function():
    # Code to profile
    pass
```

### Technique 4: Profile Context Manager

```python
import cProfile
import pstats
from contextlib import contextmanager

@contextmanager
def profile_context():
    profiler = cProfile.Profile()
    profiler.enable()
    try:
        yield profiler
    finally:
        profiler.disable()
        stats = pstats.Stats(profiler)
        stats.sort_stats('cumulative')
        stats.print_stats(10)

# Use
with profile_context():
    my_function()
```

---

## Advanced Profiling

### Call Graph Analysis

```python
import cProfile
import pstats

def analyze_call_graph(profile_file):
    stats = pstats.Stats(profile_file)
    stats.print_callers()  # Show who calls each function
    stats.print_callees()  # Show what each function calls
```

### Time Distribution

```python
import cProfile
import pstats

def analyze_time_distribution(profile_file):
    stats = pstats.Stats(profile_file)
    stats.sort_stats('cumulative')
    
    # Print functions taking most time
    stats.print_stats(0.1)  # Top 10%
```

### Module-Level Analysis

```python
import cProfile
import pstats

def analyze_by_module(profile_file):
    stats = pstats.Stats(profile_file)
    
    # Group by module
    stats.print_stats('module_name')
```

---

## Practical Examples

### Example 1: Profiling a Slow Function

```python
import cProfile
import pstats

def slow_function():
    result = 0
    for i in range(1000000):
        result += i ** 2
    return result

# Profile
cProfile.run('slow_function()', 'slow.prof')

# Analyze
stats = pstats.Stats('slow.prof')
stats.sort_stats('cumulative')
stats.print_stats()
```

### Example 2: Profiling Data Processing

```python
import cProfile
import pstats

def process_large_dataset(data):
    results = []
    for item in data:
        # Multiple operations
        processed = transform(item)
        filtered = filter_data(processed)
        results.append(filtered)
    return results

def transform(item):
    return item * 2

def filter_data(item):
    return item if item > 10 else None

# Profile
data = list(range(10000))
cProfile.run('process_large_dataset(data)', 'process.prof')

# Analyze
stats = pstats.Stats('process.prof')
stats.sort_stats('tottime')
stats.print_stats(20)
```

### Example 3: Comparing Implementations

```python
import cProfile
import pstats

def implementation1(data):
    result = []
    for item in data:
        result.append(item * 2)
    return result

def implementation2(data):
    return [item * 2 for item in data]

# Profile both
data = list(range(100000))
cProfile.run('implementation1(data)', 'impl1.prof')
cProfile.run('implementation2(data)', 'impl2.prof')

# Compare
stats1 = pstats.Stats('impl1.prof')
stats2 = pstats.Stats('impl2.prof')
stats1.sort_stats('cumulative')
stats2.sort_stats('cumulative')

print("Implementation 1:")
stats1.print_stats(5)
print("\nImplementation 2:")
stats2.print_stats(5)
```

---

## Using timeit for Micro-benchmarks

### timeit Module

For small code snippets, use `timeit`:

```python
import timeit

# Time a single expression
time = timeit.timeit('sum(range(100))', number=1000)
print(f"Time: {time} seconds")

# Time with setup
time = timeit.timeit(
    'result = sum(data)',
    setup='data = list(range(100))',
    number=1000
)
print(f"Time: {time} seconds")
```

### Comparing Approaches

```python
import timeit

# Compare two approaches
approach1 = timeit.timeit(
    'result = [x * 2 for x in range(1000)]',
    number=1000
)

approach2 = timeit.timeit(
    'result = []\nfor x in range(1000):\n    result.append(x * 2)',
    number=1000
)

print(f"List comprehension: {approach1}")
print(f"For loop: {approach2}")
```

---

## Common Profiling Patterns

### Pattern 1: Profile Before Optimization

```python
import cProfile
import pstats

# Profile original
cProfile.run('original_function()', 'before.prof')

# Make changes
# ...

# Profile optimized
cProfile.run('optimized_function()', 'after.prof')

# Compare
stats_before = pstats.Stats('before.prof')
stats_after = pstats.Stats('after.prof')
```

### Pattern 2: Profile Hot Paths

```python
import cProfile

def main():
    # Profile only the hot path
    with cProfile.Profile() as profiler:
        hot_path_function()
    
    profiler.print_stats()
```

### Pattern 3: Profile Specific Operations

```python
import cProfile

def process_data(data):
    profiler = cProfile.Profile()
    
    # Profile expensive operation
    profiler.enable()
    result = expensive_operation(data)
    profiler.disable()
    
    profiler.print_stats()
    return result
```

---

## Interpreting Results

### Key Metrics

1. **cumulative time**: Total time including subcalls
2. **total time**: Time in function excluding subcalls
3. **call count**: How many times function was called
4. **per-call time**: Average time per call

### What to Optimize

Optimize functions that have:
- **High cumulative time**: Taking a lot of total time
- **High call count**: Called very frequently
- **High per-call time**: Each call is slow

### Example Analysis

```
   ncalls  tottime  percall  cumtime  percall filename:lineno(function)
   100000    1.234    0.000    1.234    0.000 example.py:10(expensive_op)
        1    0.001    0.001    1.235    1.235 example.py:5(process_data)
```

Analysis:
- `expensive_op` is called 100,000 times
- Takes 1.234 seconds total
- Each call is very fast (0.000 seconds)
- But total time is high due to call count
- **Optimization**: Reduce call count or optimize the function

---

## Common Mistakes and Pitfalls

### 1. Profiling Wrong Code

```python
# WRONG: Profiling setup code
import cProfile
cProfile.run('data = list(range(1000000))')  # Setup, not actual work

# CORRECT: Profile actual work
cProfile.run('process_data(data)')
```

### 2. Not Sorting Results

```python
# WRONG: Unsorted results
stats.print_stats()

# CORRECT: Sort by time
stats.sort_stats('cumulative')
stats.print_stats()
```

### 3. Ignoring Call Count

```python
# WRONG: Only looking at time
# Function takes 0.001s but called 1,000,000 times = 1000s total!

# CORRECT: Consider both time and call count
stats.sort_stats('cumulative')
stats.print_stats()
```

### 4. Profiling in Wrong Environment

```python
# WRONG: Profiling in development mode
# (Debug mode, different data, etc.)

# CORRECT: Profile in production-like environment
```

---

## Best Practices

### 1. Profile Realistic Data

```python
# Use production-like data sizes
data = load_production_data()
cProfile.run('process_data(data)')
```

### 2. Profile Multiple Times

```python
# Profile multiple runs for consistency
for i in range(5):
    cProfile.run('my_function()', f'run_{i}.prof')
```

### 3. Focus on Hot Paths

```python
# Profile the code paths that matter
cProfile.run('hot_path_function()')
```

### 4. Compare Before and After

```python
# Always compare optimizations
stats_before = pstats.Stats('before.prof')
stats_after = pstats.Stats('after.prof')
```

### 5. Use Appropriate Tools

```python
# Use cProfile for function-level
# Use timeit for micro-benchmarks
# Use line_profiler for line-by-line
```

---

## Practice Exercise

### Exercise: Profiling

**Objective**: Create a Python program that demonstrates profiling.

**Instructions**:

1. Create files: `profile_practice.py` and `test_code.py`

2. Write a program that:
   - Uses cProfile to profile code
   - Identifies bottlenecks
   - Analyzes profiling results
   - Compares different implementations
   - Demonstrates profiling techniques

3. Your program should include:
   - Basic profiling
   - Saving and loading profiles
   - Analyzing results
   - Identifying bottlenecks
   - Comparing implementations
   - Real-world examples

**Example Solution**:

```python
"""
Profiling Practice
This program demonstrates profiling techniques.
"""

import cProfile
import pstats
import timeit

# Code to profile
def slow_sum(n):
    """Slow sum implementation."""
    total = 0
    for i in range(n):
        total += i
    return total

def fast_sum(n):
    """Fast sum implementation."""
    return sum(range(n))

def process_data(data):
    """Process data with multiple operations."""
    results = []
    for item in data:
        # Expensive operations
        squared = item ** 2
        cubed = item ** 3
        results.append((squared, cubed))
    return results

def nested_loops(n):
    """Function with nested loops."""
    result = []
    for i in range(n):
        for j in range(n):
            result.append(i * j)
    return result

def recursive_function(n):
    """Recursive function."""
    if n <= 1:
        return 1
    return n * recursive_function(n - 1)

print("=" * 60)
print("PROFILING PRACTICE")
print("=" * 60)
print()

# 1. Basic profiling
print("1. BASIC PROFILING")
print("-" * 60)
cProfile.run('slow_sum(1000000)')
print()

# 2. Save profile to file
print("2. SAVE PROFILE TO FILE")
print("-" * 60)
cProfile.run('slow_sum(1000000)', 'slow_sum.prof')
print("Profile saved to slow_sum.prof")
print()

# 3. Load and analyze profile
print("3. LOAD AND ANALYZE PROFILE")
print("-" * 60)
stats = pstats.Stats('slow_sum.prof')
stats.sort_stats('cumulative')
stats.print_stats(5)
print()

# 4. Sort by different criteria
print("4. SORT BY DIFFERENT CRITERIA")
print("-" * 60)
stats = pstats.Stats('slow_sum.prof')
print("Sorted by cumulative time:")
stats.sort_stats('cumulative')
stats.print_stats(3)
print()

print("Sorted by total time:")
stats.sort_stats('tottime')
stats.print_stats(3)
print()

print("Sorted by call count:")
stats.sort_stats('calls')
stats.print_stats(3)
print()

# 5. Profile data processing
print("5. PROFILE DATA PROCESSING")
print("-" * 60)
data = list(range(1000))
cProfile.run('process_data(data)', 'process.prof')
stats = pstats.Stats('process.prof')
stats.sort_stats('cumulative')
stats.print_stats(10)
print()

# 6. Compare implementations
print("6. COMPARE IMPLEMENTATIONS")
print("-" * 60)
cProfile.run('slow_sum(100000)', 'slow.prof')
cProfile.run('fast_sum(100000)', 'fast.prof')

stats_slow = pstats.Stats('slow.prof')
stats_fast = pstats.Stats('fast.prof')

print("Slow implementation:")
stats_slow.sort_stats('cumulative')
stats_slow.print_stats(3)
print()

print("Fast implementation:")
stats_fast.sort_stats('cumulative')
stats_fast.print_stats(3)
print()

# 7. Profile nested loops
print("7. PROFILE NESTED LOOPS")
print("-" * 60)
cProfile.run('nested_loops(100)', 'nested.prof')
stats = pstats.Stats('nested.prof')
stats.sort_stats('cumulative')
stats.print_stats(5)
print()

# 8. Profile recursive function
print("8. PROFILE RECURSIVE FUNCTION")
print("-" * 60)
cProfile.run('recursive_function(20)', 'recursive.prof')
stats = pstats.Stats('recursive.prof')
stats.sort_stats('cumulative')
stats.print_stats(10)
print()

# 9. Using timeit for micro-benchmarks
print("9. USING timeit FOR MICRO-BENCHMARKS")
print("-" * 60)
time1 = timeit.timeit('sum(range(1000))', number=10000)
time2 = timeit.timeit(
    'total = 0\nfor i in range(1000):\n    total += i',
    number=10000
)
print(f"Built-in sum: {time1:.6f} seconds")
print(f"For loop: {time2:.6f} seconds")
print()

# 10. Profile with context manager
print("10. PROFILE WITH CONTEXT MANAGER")
print("-" * 60)
profiler = cProfile.Profile()
profiler.enable()
result = slow_sum(100000)
profiler.disable()
stats = pstats.Stats(profiler)
stats.sort_stats('cumulative')
stats.print_stats(5)
print()

# 11. Call graph analysis
print("11. CALL GRAPH ANALYSIS")
print("-" * 60)
stats = pstats.Stats('process.prof')
print("Callers (who calls each function):")
stats.print_callers(5)
print()

# 12. Filter by module
print("12. FILTER BY MODULE")
print("-" * 60)
stats = pstats.Stats('slow_sum.prof')
print("Functions in current module:")
stats.print_stats('__main__')
print()

# 13. Identify bottlenecks
print("13. IDENTIFY BOTTLENECKS")
print("-" * 60)
stats = pstats.Stats('nested.prof')
stats.sort_stats('cumulative')
print("Top time consumers:")
stats.print_stats(0.1)  # Top 10%
print()

# 14. Profile decorator
print("14. PROFILE DECORATOR")
print("-" * 60)
from functools import wraps

def profile_decorator(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        profiler = cProfile.Profile()
        profiler.enable()
        result = func(*args, **kwargs)
        profiler.disable()
        stats = pstats.Stats(profiler)
        stats.sort_stats('cumulative')
        stats.print_stats(5)
        return result
    return wrapper

@profile_decorator
def test_function():
    return slow_sum(100000)

result = test_function()
print()

# 15. Real-world: Profile complete workflow
print("15. REAL-WORLD: PROFILE COMPLETE WORKFLOW")
print("-" * 60)
def complete_workflow():
    data = list(range(1000))
    processed = process_data(data)
    total = sum(x[0] for x in processed)
    return total

cProfile.run('complete_workflow()', 'workflow.prof')
stats = pstats.Stats('workflow.prof')
stats.sort_stats('cumulative')
stats.print_stats(10)
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
PROFILING PRACTICE
============================================================

1. BASIC PROFILING
------------------------------------------------------------
         1000003 function calls in 0.123 seconds

   Ordered by: standard name

   ncalls  tottime  percall  cumtime  percall filename:lineno(function)
        1    0.000    0.000    0.123    0.123 <string>:1(<module>)
        1    0.123    0.123    0.123    0.123 profile_practice.py:8(slow_sum)
  1000000    0.000    0.000    0.000    0.000 {built-in method range}

[... rest of output ...]
```

**Challenge** (Optional):
- Profile a real application
- Identify and fix performance bottlenecks
- Compare multiple optimization strategies
- Create a profiling report generator
- Build a performance monitoring system

---

## Key Takeaways

1. **Profiling** - measuring where code spends time
2. **cProfile module** - Python's profiling tool
3. **Profile output** - ncalls, tottime, cumtime, etc.
4. **Identifying bottlenecks** - high time, high call count
5. **pstats module** - analyze profile results
6. **Sorting results** - by time, calls, name
7. **Saving profiles** - save to file for later analysis
8. **Comparing implementations** - profile before/after
9. **timeit module** - for micro-benchmarks
10. **Call graph** - understand call hierarchy
11. **Best practices** - profile realistic data, compare results
12. **Common bottlenecks** - loops, I/O, string ops, recursion
13. **Interpretation** - understand what metrics mean
14. **Optimization focus** - optimize what matters
15. **Data-driven** - make decisions based on profiling data

---

## Quiz: Profiling

Test your understanding with these questions:

1. **What is profiling?**
   - A) Writing code
   - B) Measuring where code spends time
   - C) Debugging code
   - D) Testing code

2. **What module provides profiling in Python?**
   - A) profile
   - B) cProfile
   - C) time
   - D) debug

3. **What does tottime mean?**
   - A) Total time including subcalls
   - B) Time in function excluding subcalls
   - C) Time per call
   - D) Cumulative time

4. **What does cumtime mean?**
   - A) Total time including subcalls
   - B) Time in function excluding subcalls
   - C) Time per call
   - D) Call count

5. **What should you optimize?**
   - A) Everything
   - B) Functions with high cumulative time
   - C) Nothing
   - D) Only slow functions

6. **What is ncalls?**
   - A) Number of calls
   - B) Time per call
   - C) Total time
   - D) Function name

7. **How do you save profile results?**
   - A) cProfile.save()
   - B) cProfile.run('code', 'filename.prof')
   - C) cProfile.write()
   - D) Can't save

8. **What module analyzes profile results?**
   - A) analyze
   - B) pstats
   - C) stats
   - D) profile

9. **What is timeit used for?**
   - A) Profiling
   - B) Micro-benchmarks
   - C) Timing
   - D) All of the above

10. **What should you profile?**
    - A) Everything
    - B) Hot paths and bottlenecks
    - C) Nothing
    - D) Only slow code

**Answers**:
1. B) Measuring where code spends time (profiling definition)
2. B) cProfile (Python's profiling module)
3. B) Time in function excluding subcalls (tottime definition)
4. A) Total time including subcalls (cumtime definition)
5. B) Functions with high cumulative time (what to optimize)
6. A) Number of calls (ncalls definition)
7. B) cProfile.run('code', 'filename.prof') (saving profiles)
8. B) pstats (profile analysis module)
9. B) Micro-benchmarks (timeit purpose)
10. B) Hot paths and bottlenecks (what to profile)

---

## Next Steps

Excellent work! You've mastered profiling. You now understand:
- The cProfile module
- How to identify bottlenecks
- How to analyze profiling results
- Profiling techniques

**What's Next?**
- Lesson 18.2: Optimization Techniques
- Learn algorithm optimization
- Understand caching
- Explore optimization strategies

---

## Additional Resources

- **cProfile**: [docs.python.org/3/library/profile.html](https://docs.python.org/3/library/profile.html)
- **pstats**: [docs.python.org/3/library/profile.html#module-pstats](https://docs.python.org/3/library/profile.html#module-pstats)
- **timeit**: [docs.python.org/3/library/timeit.html](https://docs.python.org/3/library/timeit.html)

---

*Lesson completed! You're ready to move on to the next lesson.*

