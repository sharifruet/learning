# Lesson 13.1: Understanding Decorators

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand functions as first-class objects
- Work with higher-order functions
- Understand the concept of decorators
- Recognize how decorators work
- Understand function wrapping
- See decorators in action
- Understand the foundation for creating decorators
- Recognize common decorator patterns
- Understand function metadata preservation
- Apply decorator concepts

---

## Introduction to Decorators

**Decorators** are a powerful feature in Python that allow you to modify or extend the behavior of functions or classes without permanently modifying their code.

### Why Decorators?

- **Code reuse**: Add functionality to multiple functions
- **Separation of concerns**: Keep core logic separate from cross-cutting concerns
- **Clean code**: Avoid repetitive code
- **Pythonic**: Idiomatic Python pattern
- **Flexible**: Can be applied to any function

### What Are Decorators?

Decorators are functions that take another function as an argument and return a modified version of that function.

---

## Functions as First-Class Objects

In Python, **functions are first-class objects**, meaning they can be:
- Assigned to variables
- Passed as arguments to other functions
- Returned from functions
- Stored in data structures

### Assigning Functions to Variables

```python
def greet(name):
    return f"Hello, {name}!"

# Assign function to variable
say_hello = greet
print(say_hello("Alice"))  # Hello, Alice!

# Function is an object
print(type(greet))  # <class 'function'>
print(greet)  # <function greet at 0x...>
```

### Functions as Arguments

```python
def apply_operation(x, operation):
    """Apply operation to x."""
    return operation(x)

def square(n):
    return n ** 2

def cube(n):
    return n ** 3

# Pass functions as arguments
result1 = apply_operation(5, square)  # 25
result2 = apply_operation(5, cube)      # 125

print(result1, result2)  # 25 125
```

### Functions as Return Values

```python
def get_operation(operation_type):
    """Return a function based on operation type."""
    def add(x, y):
        return x + y
    
    def multiply(x, y):
        return x * y
    
    if operation_type == "add":
        return add
    elif operation_type == "multiply":
        return multiply

# Get and use function
add_func = get_operation("add")
result = add_func(3, 4)
print(result)  # 7
```

### Functions in Data Structures

```python
def add(x, y):
    return x + y

def subtract(x, y):
    return x - y

def multiply(x, y):
    return x * y

# Store functions in list
operations = [add, subtract, multiply]

# Use functions from list
for op in operations:
    print(op(10, 5))
# Output: 15, 5, 50

# Store in dictionary
ops_dict = {
    'add': add,
    'subtract': subtract,
    'multiply': multiply
}

result = ops_dict['add'](10, 5)
print(result)  # 15
```

### Function Attributes

```python
def greet(name):
    """Greet someone."""
    return f"Hello, {name}!"

# Functions have attributes
print(greet.__name__)      # greet
print(greet.__doc__)       # Greet someone.
print(greet.__module__)    # __main__
print(greet.__code__)      # <code object ...>
```

---

## Higher-Order Functions

**Higher-order functions** are functions that:
- Take other functions as arguments, or
- Return functions as results

### Functions That Take Functions as Arguments

```python
def apply_twice(func, value):
    """Apply function twice to value."""
    return func(func(value))

def add_one(x):
    return x + 1

result = apply_twice(add_one, 5)
print(result)  # 7 (5 + 1 + 1)
```

### Functions That Return Functions

```python
def make_multiplier(n):
    """Create a function that multiplies by n."""
    def multiplier(x):
        return x * n
    return multiplier

# Create specialized functions
double = make_multiplier(2)
triple = make_multiplier(3)

print(double(5))  # 10
print(triple(5))  # 15
```

### Closure Example

```python
def create_counter():
    """Create a counter function with closure."""
    count = 0
    
    def counter():
        nonlocal count
        count += 1
        return count
    
    return counter

# Create counter instances
counter1 = create_counter()
counter2 = create_counter()

print(counter1())  # 1
print(counter1())  # 2
print(counter2())  # 1 (independent)
print(counter1())  # 3
```

### Practical Example: Function Timer

```python
import time

def timer(func):
    """Measure function execution time."""
    def wrapper(*args, **kwargs):
        start = time.time()
        result = func(*args, **kwargs)
        end = time.time()
        print(f"{func.__name__} took {end - start:.4f} seconds")
        return result
    return wrapper

def slow_function():
    time.sleep(1)
    return "Done"

# Wrap function
timed_function = timer(slow_function)
result = timed_function()
# Output: slow_function took 1.0000 seconds
```

---

## Decorator Basics

A **decorator** is a function that takes another function and extends its behavior without explicitly modifying it.

### Simple Decorator Example

```python
def my_decorator(func):
    """Simple decorator that prints before and after."""
    def wrapper():
        print("Before function call")
        func()
        print("After function call")
    return wrapper

def say_hello():
    print("Hello!")

# Apply decorator manually
decorated_hello = my_decorator(say_hello)
decorated_hello()
# Output:
# Before function call
# Hello!
# After function call
```

### Decorator Syntax (@)

```python
def my_decorator(func):
    """Simple decorator."""
    def wrapper():
        print("Before function call")
        func()
        print("After function call")
    return wrapper

# Using @ syntax (decorator syntax)
@my_decorator
def say_hello():
    print("Hello!")

# Now say_hello is decorated
say_hello()
# Output:
# Before function call
# Hello!
# After function call
```

### Understanding the Decorator Pattern

```python
# This:
@my_decorator
def my_function():
    pass

# Is equivalent to:
def my_function():
    pass
my_function = my_decorator(my_function)
```

### Decorator with Arguments

```python
def my_decorator(func):
    """Decorator that handles function arguments."""
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__} with {args} and {kwargs}")
        result = func(*args, **kwargs)
        print(f"{func.__name__} returned {result}")
        return result
    return wrapper

@my_decorator
def add(x, y):
    return x + y

result = add(3, 4)
# Output:
# Calling add with (3, 4) and {}
# add returned 7
```

### Preserving Function Metadata

```python
def my_decorator(func):
    """Decorator that preserves metadata."""
    def wrapper(*args, **kwargs):
        """Wrapper function."""
        return func(*args, **kwargs)
    # Preserve metadata
    wrapper.__name__ = func.__name__
    wrapper.__doc__ = func.__doc__
    return wrapper

@my_decorator
def greet(name):
    """Greet someone."""
    return f"Hello, {name}!"

print(greet.__name__)  # greet
print(greet.__doc__)   # Greet someone.
```

### Using `functools.wraps`

```python
from functools import wraps

def my_decorator(func):
    """Decorator using functools.wraps."""
    @wraps(func)  # Preserves metadata automatically
    def wrapper(*args, **kwargs):
        """Wrapper function."""
        return func(*args, **kwargs)
    return wrapper

@my_decorator
def greet(name):
    """Greet someone."""
    return f"Hello, {name}!"

print(greet.__name__)  # greet
print(greet.__doc__)   # Greet someone.
```

---

## Common Decorator Patterns

### 1. Logging Decorator

```python
from functools import wraps

def log_calls(func):
    """Log function calls."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__} with args={args}, kwargs={kwargs}")
        result = func(*args, **kwargs)
        print(f"{func.__name__} returned {result}")
        return result
    return wrapper

@log_calls
def add(x, y):
    return x + y

result = add(3, 4)
# Output:
# Calling add with args=(3, 4), kwargs={}
# add returned 7
```

### 2. Timing Decorator

```python
import time
from functools import wraps

def timer(func):
    """Measure function execution time."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        start = time.time()
        result = func(*args, **kwargs)
        end = time.time()
        print(f"{func.__name__} took {end - start:.4f} seconds")
        return result
    return wrapper

@timer
def slow_function():
    time.sleep(1)
    return "Done"

result = slow_function()
# Output: slow_function took 1.0000 seconds
```

### 3. Retry Decorator

```python
from functools import wraps
import time

def retry(max_attempts=3, delay=1):
    """Retry function on failure."""
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            for attempt in range(max_attempts):
                try:
                    return func(*args, **kwargs)
                except Exception as e:
                    if attempt == max_attempts - 1:
                        raise
                    print(f"Attempt {attempt + 1} failed: {e}. Retrying...")
                    time.sleep(delay)
        return wrapper
    return decorator

@retry(max_attempts=3, delay=1)
def unreliable_function():
    import random
    if random.random() < 0.7:
        raise ValueError("Random failure")
    return "Success"
```

### 4. Validation Decorator

```python
from functools import wraps

def validate_positive(func):
    """Validate that arguments are positive."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        for arg in args:
            if isinstance(arg, (int, float)) and arg < 0:
                raise ValueError(f"Argument {arg} must be positive")
        return func(*args, **kwargs)
    return wrapper

@validate_positive
def square_root(x):
    return x ** 0.5

result = square_root(16)  # 4.0
# result = square_root(-4)  # ValueError
```

---

## Understanding Decorator Execution

### Decorator Execution Order

```python
def decorator1(func):
    print("Decorator 1 applied")
    def wrapper():
        print("Wrapper 1")
        return func()
    return wrapper

def decorator2(func):
    print("Decorator 2 applied")
    def wrapper():
        print("Wrapper 2")
        return func()
    return wrapper

@decorator1
@decorator2
def my_function():
    print("Function executed")

# Decorators are applied bottom-up
# Output when module loads:
# Decorator 2 applied
# Decorator 1 applied

my_function()
# Output:
# Wrapper 1
# Wrapper 2
# Function executed
```

### Stacking Decorators

```python
def bold(func):
    def wrapper():
        return f"<b>{func()}</b>"
    return wrapper

def italic(func):
    def wrapper():
        return f"<i>{func()}</i>"
    return wrapper

@bold
@italic
def hello():
    return "Hello"

print(hello())  # <b><i>Hello</i></b>
```

---

## Practical Examples

### Example 1: Function Call Counter

```python
from functools import wraps

def count_calls(func):
    """Count how many times function is called."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        wrapper.call_count += 1
        print(f"{func.__name__} called {wrapper.call_count} times")
        return func(*args, **kwargs)
    wrapper.call_count = 0
    return wrapper

@count_calls
def greet(name):
    return f"Hello, {name}!"

greet("Alice")  # greet called 1 times
greet("Bob")    # greet called 2 times
```

### Example 2: Cache Decorator

```python
from functools import wraps

def cache(func):
    """Cache function results."""
    cache_dict = {}
    @wraps(func)
    def wrapper(*args, **kwargs):
        key = str(args) + str(kwargs)
        if key not in cache_dict:
            cache_dict[key] = func(*args, **kwargs)
        return cache_dict[key]
    return wrapper

@cache
def expensive_function(n):
    print(f"Computing for {n}")
    return n ** 2

print(expensive_function(5))  # Computing for 5, then 25
print(expensive_function(5))  # 25 (cached, no computation)
```

### Example 3: Rate Limiting

```python
import time
from functools import wraps

def rate_limit(calls_per_second):
    """Limit function call rate."""
    min_interval = 1.0 / calls_per_second
    last_called = [0.0]
    
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            elapsed = time.time() - last_called[0]
            left_to_wait = min_interval - elapsed
            if left_to_wait > 0:
                time.sleep(left_to_wait)
            last_called[0] = time.time()
            return func(*args, **kwargs)
        return wrapper
    return decorator

@rate_limit(calls_per_second=2)
def api_call():
    return "API response"

# Function can only be called twice per second
```

---

## Common Mistakes and Pitfalls

### 1. Forgetting `@wraps`

```python
# WRONG: Metadata is lost
def my_decorator(func):
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper

@my_decorator
def greet(name):
    """Greet someone."""
    return f"Hello, {name}!"

print(greet.__name__)  # wrapper (wrong!)

# CORRECT: Use @wraps
from functools import wraps

def my_decorator(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper
```

### 2. Not Handling Arguments

```python
# WRONG: Doesn't handle arguments
def my_decorator(func):
    def wrapper():
        return func()
    return wrapper

@my_decorator
def add(x, y):
    return x + y

# add(3, 4)  # TypeError!

# CORRECT: Use *args, **kwargs
def my_decorator(func):
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper
```

### 3. Decorator Execution Timing

```python
# Decorators are executed at function definition time, not call time
def my_decorator(func):
    print(f"Decorating {func.__name__}")  # Executes immediately
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper

@my_decorator
def my_function():
    pass

# "Decorating my_function" is printed when module loads
```

---

## Best Practices

### 1. Always Use `@wraps`

```python
from functools import wraps

def my_decorator(func):
    @wraps(func)  # Always use this
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper
```

### 2. Handle All Arguments

```python
def my_decorator(func):
    def wrapper(*args, **kwargs):  # Handle all arguments
        return func(*args, **kwargs)
    return wrapper
```

### 3. Keep Decorators Simple

```python
# Good: Simple, focused decorator
def log_calls(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__}")
        return func(*args, **kwargs)
    return wrapper

# Avoid: Complex logic in decorator
# Move complex logic to separate functions
```

### 4. Document Decorators

```python
def my_decorator(func):
    """Decorator that does something.
    
    Args:
        func: Function to decorate
    
    Returns:
        Decorated function
    """
    @wraps(func)
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper
```

---

## Practice Exercise

### Exercise: Basic Decorators

**Objective**: Create a Python program that demonstrates understanding of decorators.

**Instructions**:

1. Create a file called `decorators_practice.py`

2. Write a program that:
   - Demonstrates functions as first-class objects
   - Creates higher-order functions
   - Implements basic decorators
   - Shows decorator patterns
   - Demonstrates practical decorator usage

3. Your program should include:
   - Function assignment and passing
   - Higher-order functions
   - Basic decorator implementation
   - Decorator with @ syntax
   - Preserving function metadata
   - Common decorator patterns

**Example Solution**:

```python
"""
Understanding Decorators Practice
This program demonstrates functions as first-class objects,
higher-order functions, and basic decorators.
"""

from functools import wraps
import time

print("=" * 60)
print("UNDERSTANDING DECORATORS PRACTICE")
print("=" * 60)
print()

# 1. Functions as first-class objects
print("1. FUNCTIONS AS FIRST-CLASS OBJECTS")
print("-" * 60)

def greet(name):
    """Greet someone."""
    return f"Hello, {name}!"

# Assign function to variable
say_hello = greet
print(f"Using variable: {say_hello('Alice')}")

# Function attributes
print(f"Function name: {greet.__name__}")
print(f"Function doc: {greet.__doc__}")
print()

# 2. Functions as arguments
print("2. FUNCTIONS AS ARGUMENTS")
print("-" * 60)

def apply_operation(x, operation):
    """Apply operation to x."""
    return operation(x)

def square(n):
    return n ** 2

def cube(n):
    return n ** 3

result1 = apply_operation(5, square)
result2 = apply_operation(5, cube)
print(f"Square of 5: {result1}")
print(f"Cube of 5: {result2}")
print()

# 3. Functions as return values
print("3. FUNCTIONS AS RETURN VALUES")
print("-" * 60)

def make_multiplier(n):
    """Create a function that multiplies by n."""
    def multiplier(x):
        return x * n
    return multiplier

double = make_multiplier(2)
triple = make_multiplier(3)

print(f"Double of 5: {double(5)}")
print(f"Triple of 5: {triple(5)}")
print()

# 4. Functions in data structures
print("4. FUNCTIONS IN DATA STRUCTURES")
print("-" * 60)

def add(x, y):
    return x + y

def subtract(x, y):
    return x - y

def multiply(x, y):
    return x * y

operations = [add, subtract, multiply]
print("Operations on (10, 5):")
for op in operations:
    print(f"  {op.__name__}: {op(10, 5)}")
print()

# 5. Higher-order function: apply_twice
print("5. HIGHER-ORDER FUNCTION: apply_twice")
print("-" * 60)

def apply_twice(func, value):
    """Apply function twice to value."""
    return func(func(value))

def add_one(x):
    return x + 1

result = apply_twice(add_one, 5)
print(f"apply_twice(add_one, 5): {result}")
print()

# 6. Closure example
print("6. CLOSURE EXAMPLE")
print("-" * 60)

def create_counter():
    """Create a counter function with closure."""
    count = 0
    
    def counter():
        nonlocal count
        count += 1
        return count
    
    return counter

counter1 = create_counter()
counter2 = create_counter()

print(f"Counter1: {counter1()}, {counter1()}, {counter1()}")
print(f"Counter2: {counter2()}, {counter2()}")
print(f"Counter1 again: {counter1()}")
print()

# 7. Basic decorator (manual application)
print("7. BASIC DECORATOR (MANUAL)")
print("-" * 60)

def my_decorator(func):
    """Simple decorator that prints before and after."""
    def wrapper():
        print("Before function call")
        func()
        print("After function call")
    return wrapper

def say_hello():
    print("Hello!")

decorated_hello = my_decorator(say_hello)
decorated_hello()
print()

# 8. Decorator with @ syntax
print("8. DECORATOR WITH @ SYNTAX")
print("-" * 60)

def my_decorator(func):
    """Simple decorator."""
    def wrapper():
        print("Before function call")
        func()
        print("After function call")
    return wrapper

@my_decorator
def say_hello():
    print("Hello!")

say_hello()
print()

# 9. Decorator with arguments
print("9. DECORATOR WITH ARGUMENTS")
print("-" * 60)

def my_decorator(func):
    """Decorator that handles function arguments."""
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__} with {args} and {kwargs}")
        result = func(*args, **kwargs)
        print(f"{func.__name__} returned {result}")
        return result
    return wrapper

@my_decorator
def add(x, y):
    return x + y

result = add(3, 4)
print()

# 10. Preserving metadata with @wraps
print("10. PRESERVING METADATA WITH @wraps")
print("-" * 60)

from functools import wraps

def my_decorator(func):
    """Decorator using functools.wraps."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        """Wrapper function."""
        return func(*args, **kwargs)
    return wrapper

@my_decorator
def greet(name):
    """Greet someone."""
    return f"Hello, {name}!"

print(f"Function name: {greet.__name__}")
print(f"Function doc: {greet.__doc__}")
print()

# 11. Logging decorator
print("11. LOGGING DECORATOR")
print("-" * 60)

def log_calls(func):
    """Log function calls."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__} with args={args}, kwargs={kwargs}")
        result = func(*args, **kwargs)
        print(f"{func.__name__} returned {result}")
        return result
    return wrapper

@log_calls
def multiply(x, y):
    return x * y

result = multiply(3, 4)
print()

# 12. Timing decorator
print("12. TIMING DECORATOR")
print("-" * 60)

def timer(func):
    """Measure function execution time."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        start = time.time()
        result = func(*args, **kwargs)
        end = time.time()
        print(f"{func.__name__} took {end - start:.4f} seconds")
        return result
    return wrapper

@timer
def slow_function():
    time.sleep(0.1)
    return "Done"

result = slow_function()
print()

# 13. Validation decorator
print("13. VALIDATION DECORATOR")
print("-" * 60)

def validate_positive(func):
    """Validate that arguments are positive."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        for arg in args:
            if isinstance(arg, (int, float)) and arg < 0:
                raise ValueError(f"Argument {arg} must be positive")
        return func(*args, **kwargs)
    return wrapper

@validate_positive
def square_root(x):
    return x ** 0.5

result = square_root(16)
print(f"Square root of 16: {result}")
print()

# 14. Function call counter
print("14. FUNCTION CALL COUNTER")
print("-" * 60)

def count_calls(func):
    """Count how many times function is called."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        wrapper.call_count += 1
        print(f"{func.__name__} called {wrapper.call_count} times")
        return func(*args, **kwargs)
    wrapper.call_count = 0
    return wrapper

@count_calls
def greet(name):
    return f"Hello, {name}!"

greet("Alice")
greet("Bob")
print()

# 15. Cache decorator
print("15. CACHE DECORATOR")
print("-" * 60)

def cache(func):
    """Cache function results."""
    cache_dict = {}
    @wraps(func)
    def wrapper(*args, **kwargs):
        key = str(args) + str(kwargs)
        if key not in cache_dict:
            print(f"Computing {func.__name__} for {args}")
            cache_dict[key] = func(*args, **kwargs)
        else:
            print(f"Using cached result for {func.__name__} with {args}")
        return cache_dict[key]
    return wrapper

@cache
def expensive_function(n):
    return n ** 2

print(f"First call: {expensive_function(5)}")
print(f"Second call: {expensive_function(5)}")
print()

# 16. Stacking decorators
print("16. STACKING DECORATORS")
print("-" * 60)

def bold(func):
    @wraps(func)
    def wrapper():
        return f"<b>{func()}</b>"
    return wrapper

def italic(func):
    @wraps(func)
    def wrapper():
        return f"<i>{func()}</i>"
    return wrapper

@bold
@italic
def hello():
    return "Hello"

print(f"Stacked decorators: {hello()}")
print()

# 17. Decorator execution order
print("17. DECORATOR EXECUTION ORDER")
print("-" * 60)

def decorator1(func):
    print("Decorator 1 applied")
    @wraps(func)
    def wrapper():
        print("Wrapper 1")
        return func()
    return wrapper

def decorator2(func):
    print("Decorator 2 applied")
    @wraps(func)
    def wrapper():
        print("Wrapper 2")
        return func()
    return wrapper

@decorator1
@decorator2
def my_function():
    print("Function executed")

print("Calling decorated function:")
my_function()
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
UNDERSTANDING DECORATORS PRACTICE
============================================================

1. FUNCTIONS AS FIRST-CLASS OBJECTS
------------------------------------------------------------
Using variable: Hello, Alice!
Function name: greet
Function doc: Greet someone.

[... rest of output ...]
```

**Challenge** (Optional):
- Create a decorator that measures memory usage
- Build a decorator that validates function return types
- Implement a decorator that handles exceptions
- Create a decorator that adds authentication

---

## Key Takeaways

1. **Functions are first-class objects** - can be assigned, passed, returned
2. **Higher-order functions** - take or return functions
3. **Decorators** - functions that modify other functions
4. **@ syntax** - shorthand for applying decorators
5. **@wraps** - preserves function metadata
6. ***args, **kwargs** - handle all arguments in decorators
7. **Decorators execute** at function definition time
8. **Stacking decorators** - apply multiple decorators
9. **Common patterns** - logging, timing, validation, caching
10. **Closures** - inner functions can access outer scope
11. **Function metadata** - __name__, __doc__, etc.
12. **Decorator pattern** - powerful for cross-cutting concerns
13. **Separation of concerns** - keep logic separate
14. **Code reuse** - apply same behavior to multiple functions
15. **Pythonic** - idiomatic Python pattern

---

## Quiz: Decorator Basics

Test your understanding with these questions:

1. **What are first-class objects in Python?**
   - A) Only classes
   - B) Objects that can be assigned, passed, returned
   - C) Only functions
   - D) Only variables

2. **What is a higher-order function?**
   - A) Function that takes other functions as arguments
   - B) Function that returns functions
   - C) Both A and B
   - D) Function with high complexity

3. **What does the @ symbol do in Python?**
   - A) Creates a new function
   - B) Applies a decorator
   - C) Imports a module
   - D) Defines a class

4. **What does `@wraps` do?**
   - A) Wraps a function
   - B) Preserves function metadata
   - C) Creates a wrapper
   - D) Removes metadata

5. **When are decorators executed?**
   - A) When function is called
   - B) When function is defined
   - C) When module is imported
   - D) Never

6. **What should decorator wrappers use to handle arguments?**
   - A) `*args`
   - B) `**kwargs`
   - C) Both A and B
   - D) No special handling needed

7. **What is a closure?**
   - A) A function that closes
   - B) Inner function accessing outer scope
   - C) A decorator
   - D) A class method

8. **Can you stack multiple decorators?**
   - A) No
   - B) Yes, but only two
   - C) Yes, any number
   - D) Only with special syntax

9. **What is the purpose of decorators?**
   - A) Modify function behavior
   - B) Add functionality without changing code
   - C) Code reuse
   - D) All of the above

10. **What module provides `@wraps`?**
    - A) `decorators`
    - B) `functools`
    - C) `wraps`
    - D) `functions`

**Answers**:
1. B) Objects that can be assigned, passed, returned (first-class objects definition)
2. C) Both A and B (higher-order function definition)
3. B) Applies a decorator (@ syntax purpose)
4. B) Preserves function metadata (@wraps purpose)
5. B) When function is defined (decorator execution timing)
6. C) Both A and B (handle all arguments)
7. B) Inner function accessing outer scope (closure definition)
8. C) Yes, any number (stacking decorators)
9. D) All of the above (decorator purposes)
10. B) `functools` (module with @wraps)

---

## Next Steps

Excellent work! You've mastered the basics of decorators. You now understand:
- Functions as first-class objects
- Higher-order functions
- Basic decorator concepts
- How decorators work

**What's Next?**
- Lesson 13.2: Creating Decorators
- Learn to create your own decorators
- Understand decorators with arguments
- Explore advanced decorator patterns

---

## Additional Resources

- **Decorators**: [docs.python.org/3/glossary.html#term-decorator](https://docs.python.org/3/glossary.html#term-decorator)
- **functools.wraps**: [docs.python.org/3/library/functools.html#functools.wraps](https://docs.python.org/3/library/functools.html#functools.wraps)
- **First-Class Functions**: [docs.python.org/3/tutorial/controlflow.html#defining-functions](https://docs.python.org/3/tutorial/controlflow.html#defining-functions)

---

*Lesson completed! You're ready to move on to the next lesson.*

