# Lesson 13.4: Advanced Decorator Patterns

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand functools.wraps in depth
- Create and use decorator factories effectively
- Work with multiple decorators
- Understand decorator execution order
- Create complex decorator patterns
- Handle decorator arguments properly
- Understand decorator composition
- Debug complex decorators
- Apply advanced patterns in real-world scenarios
- Optimize decorator performance

---

## Introduction to Advanced Decorator Patterns

This lesson covers advanced decorator patterns that enable you to create powerful, reusable, and maintainable decorators. We'll dive deep into `functools.wraps`, decorator factories, and working with multiple decorators.

---

## functools.wraps Deep Dive

### Why functools.wraps?

When you create a decorator, the original function is replaced by a wrapper function. Without `@wraps`, the wrapper loses the original function's metadata.

### Problem Without @wraps

```python
def my_decorator(func):
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper

@my_decorator
def greet(name):
    """Greet someone."""
    return f"Hello, {name}!"

print(greet.__name__)  # wrapper (wrong!)
print(greet.__doc__)   # None (wrong!)
print(greet.__module__)  # __main__ (may be wrong)
```

### Solution with @wraps

```python
from functools import wraps

def my_decorator(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper

@my_decorator
def greet(name):
    """Greet someone."""
    return f"Hello, {name}!"

print(greet.__name__)  # greet (correct!)
print(greet.__doc__)   # Greet someone. (correct!)
```

### What @wraps Does

`@wraps` copies metadata from the original function to the wrapper:

```python
from functools import wraps

def my_decorator(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper

@my_decorator
def example(x: int, y: int) -> int:
    """Add two numbers."""
    return x + y

# All metadata is preserved
print(example.__name__)        # example
print(example.__doc__)         # Add two numbers.
print(example.__annotations__) # {'x': <class 'int'>, 'y': <class 'int'>, 'return': <class 'int'>}
```

### Preserving Function Signature

```python
from functools import wraps
import inspect

def my_decorator(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper

@my_decorator
def add(x: int, y: int = 0) -> int:
    """Add two numbers."""
    return x + y

# Signature is preserved
sig = inspect.signature(add)
print(sig)  # (x: int, y: int = 0) -> int
```

### @wraps with Parameters

You can specify which attributes to copy:

```python
from functools import wraps

def my_decorator(func):
    @wraps(func, assigned=('__name__', '__doc__'), updated=())
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper
```

### Manual Metadata Preservation

If you can't use @wraps, preserve metadata manually:

```python
def my_decorator(func):
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    # Manually copy metadata
    wrapper.__name__ = func.__name__
    wrapper.__doc__ = func.__doc__
    wrapper.__module__ = func.__module__
    wrapper.__annotations__ = func.__annotations__
    return wrapper
```

---

## Decorator Factories

A **decorator factory** is a function that returns a decorator. This allows you to create parameterized decorators.

### Basic Decorator Factory Pattern

```python
def decorator_factory(arg1, arg2):
    """Factory that creates a decorator."""
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            # Use arg1 and arg2 here
            print(f"Decorator args: {arg1}, {arg2}")
            return func(*args, **kwargs)
        return wrapper
    return decorator

@decorator_factory("arg1", "arg2")
def my_function():
    pass
```

### Understanding the Pattern

```python
# Step 1: Call factory with arguments
decorator = decorator_factory("arg1", "arg2")

# Step 2: Apply decorator to function
@decorator
def my_function():
    pass

# Equivalent to:
def my_function():
    pass
my_function = decorator_factory("arg1", "arg2")(my_function)
```

### Example: Retry Decorator Factory

```python
from functools import wraps
import time

def retry(max_attempts=3, delay=1):
    """Retry decorator factory."""
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            for attempt in range(max_attempts):
                try:
                    return func(*args, **kwargs)
                except Exception as e:
                    if attempt == max_attempts - 1:
                        raise
                    print(f"Attempt {attempt + 1} failed: {e}. Retrying in {delay}s...")
                    time.sleep(delay)
        return wrapper
    return decorator

@retry(max_attempts=5, delay=2)
def unreliable_function():
    import random
    if random.random() < 0.7:
        raise ValueError("Random failure")
    return "Success"
```

### Example: Rate Limiting Factory

```python
from functools import wraps
import time

def rate_limit(calls_per_second):
    """Rate limiting decorator factory."""
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
```

### Example: Conditional Decorator Factory

```python
from functools import wraps

def conditional_decorator(condition):
    """Apply decorator only if condition is True."""
    def decorator(func):
        if condition:
            @wraps(func)
            def wrapper(*args, **kwargs):
                print(f"Decorator active for {func.__name__}")
                return func(*args, **kwargs)
            return wrapper
        else:
            return func
    return decorator

DEBUG = True

@conditional_decorator(DEBUG)
def my_function():
    return "Result"
```

### Example: Validation Decorator Factory

```python
from functools import wraps

def validate_types(**type_map):
    """Validate function argument types."""
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            # Get function signature
            import inspect
            sig = inspect.signature(func)
            bound = sig.bind(*args, **kwargs)
            bound.apply_defaults()
            
            # Validate types
            for param_name, expected_type in type_map.items():
                if param_name in bound.arguments:
                    value = bound.arguments[param_name]
                    if not isinstance(value, expected_type):
                        raise TypeError(
                            f"{param_name} must be {expected_type.__name__}, "
                            f"got {type(value).__name__}"
                        )
            return func(*args, **kwargs)
        return wrapper
    return decorator

@validate_types(x=int, y=int)
def add(x, y):
    return x + y

result = add(3, 4)  # Works
# result = add("3", 4)  # TypeError
```

### Advanced: Decorator Factory with Optional Arguments

```python
from functools import wraps

def smart_decorator(func=None, *, option1=None, option2=None):
    """Decorator that can be used with or without arguments."""
    def decorator(f):
        @wraps(f)
        def wrapper(*args, **kwargs):
            if option1:
                print(f"Option1: {option1}")
            if option2:
                print(f"Option2: {option2}")
            return f(*args, **kwargs)
        return wrapper
    
    if func is None:
        # Called with arguments
        return decorator
    else:
        # Called without arguments
        return decorator(func)

# Usage without arguments
@smart_decorator
def function1():
    pass

# Usage with arguments
@smart_decorator(option1="value1", option2="value2")
def function2():
    pass
```

---

## Multiple Decorators

### Stacking Decorators

You can apply multiple decorators to a single function:

```python
from functools import wraps

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

def underline(func):
    @wraps(func)
    def wrapper():
        return f"<u>{func()}</u>"
    return wrapper

@bold
@italic
@underline
def hello():
    return "Hello"

print(hello())  # <b><i><u>Hello</u></i></b>
```

### Understanding Execution Order

Decorators are applied **bottom to top**:

```python
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

# Output when module loads:
# Decorator 2 applied
# Decorator 1 applied

# Output when called:
# Wrapper 1
# Wrapper 2
# Function executed
```

### Visualizing Decorator Stacking

```python
# This:
@decorator1
@decorator2
@decorator3
def my_function():
    pass

# Is equivalent to:
def my_function():
    pass
my_function = decorator3(my_function)
my_function = decorator2(my_function)
my_function = decorator1(my_function)
```

### Practical Example: Logging and Timing

```python
from functools import wraps
import time

def log_calls(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__} with {args}, {kwargs}")
        result = func(*args, **kwargs)
        print(f"{func.__name__} returned {result}")
        return result
    return wrapper

def timer(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        start = time.time()
        result = func(*args, **kwargs)
        end = time.time()
        print(f"{func.__name__} took {end - start:.4f} seconds")
        return result
    return wrapper

@log_calls
@timer
def add(x, y):
    return x + y

result = add(3, 4)
# Output:
# Calling add with (3, 4), {}
# add took 0.0000 seconds
# add returned 7
```

### Composing Multiple Decorators

You can create a function that applies multiple decorators:

```python
from functools import wraps

def compose_decorators(*decorators):
    """Compose multiple decorators into one."""
    def decorator(func):
        for dec in reversed(decorators):
            func = dec(func)
        return func
    return decorator

def log_calls(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__}")
        return func(*args, **kwargs)
    return wrapper

def timer(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        import time
        start = time.time()
        result = func(*args, **kwargs)
        end = time.time()
        print(f"Took {end - start:.4f} seconds")
        return result
    return wrapper

# Use composed decorator
@compose_decorators(log_calls, timer)
def my_function():
    return "Result"
```

### Decorator with Multiple Factory Arguments

```python
from functools import wraps

def multi_decorator(*decorator_factories):
    """Apply multiple decorator factories."""
    def decorator(func):
        for factory in reversed(decorator_factories):
            func = factory(func)
        return func
    return decorator

def log_factory(level="INFO"):
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            print(f"[{level}] Calling {func.__name__}")
            return func(*args, **kwargs)
        return wrapper
    return decorator

def timer_factory():
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            import time
            start = time.time()
            result = func(*args, **kwargs)
            end = time.time()
            print(f"Took {end - start:.4f} seconds")
            return result
        return wrapper
    return decorator

@multi_decorator(log_factory("DEBUG"), timer_factory())
def my_function():
    return "Result"
```

---

## Advanced Patterns

### Pattern 1: Decorator Registry

```python
from functools import wraps

DECORATOR_REGISTRY = {}

def register_decorator(name):
    """Register a decorator in a registry."""
    def decorator(func):
        DECORATOR_REGISTRY[name] = func
        @wraps(func)
        def wrapper(*args, **kwargs):
            return func(*args, **kwargs)
        return wrapper
    return decorator

@register_decorator("log")
def log_calls(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__}")
        return func(*args, **kwargs)
    return wrapper

@register_decorator("timer")
def timer(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        import time
        start = time.time()
        result = func(*args, **kwargs)
        end = time.time()
        print(f"Took {end - start:.4f} seconds")
        return result
    return wrapper

# Use registered decorators
@DECORATOR_REGISTRY["log"]
@DECORATOR_REGISTRY["timer"]
def my_function():
    return "Result"
```

### Pattern 2: Decorator with State

```python
from functools import wraps

def stateful_decorator(initial_state):
    """Decorator that maintains state."""
    state = {"value": initial_state}
    
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            state["value"] += 1
            print(f"State: {state['value']}")
            return func(*args, **kwargs)
        wrapper.get_state = lambda: state["value"]
        return wrapper
    return decorator

@stateful_decorator(0)
def my_function():
    return "Result"

my_function()  # State: 1
my_function()  # State: 2
print(my_function.get_state())  # 2
```

### Pattern 3: Decorator Chain

```python
from functools import wraps

class DecoratorChain:
    """Chain multiple decorators together."""
    def __init__(self):
        self.decorators = []
    
    def add(self, decorator):
        """Add a decorator to the chain."""
        self.decorators.append(decorator)
        return self
    
    def __call__(self, func):
        """Apply all decorators."""
        for decorator in reversed(self.decorators):
            func = decorator(func)
        return func

def log_calls(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__}")
        return func(*args, **kwargs)
    return wrapper

def timer(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        import time
        start = time.time()
        result = func(*args, **kwargs)
        end = time.time()
        print(f"Took {end - start:.4f} seconds")
        return result
    return wrapper

chain = DecoratorChain()
chain.add(log_calls).add(timer)

@chain
def my_function():
    return "Result"
```

### Pattern 4: Conditional Application

```python
from functools import wraps

def conditional_apply(condition_func):
    """Apply decorator based on condition."""
    def decorator_factory(decorator):
        def conditional_decorator(func):
            if condition_func(func):
                return decorator(func)
            return func
        return conditional_decorator
    return decorator_factory

def is_public(func):
    """Check if function is public (doesn't start with _)."""
    return not func.__name__.startswith('_')

def log_calls(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__}")
        return func(*args, **kwargs)
    return wrapper

@conditional_apply(is_public)(log_calls)
def public_function():
    return "Public"

@conditional_apply(is_public)(log_calls)
def _private_function():
    return "Private"

# Only public_function will be logged
```

### Pattern 5: Decorator with Configuration

```python
from functools import wraps

class DecoratorConfig:
    """Configuration for decorators."""
    def __init__(self):
        self.enabled = True
        self.log_level = "INFO"
    
    def configure(self, **kwargs):
        """Update configuration."""
        for key, value in kwargs.items():
            setattr(self, key, value)

config = DecoratorConfig()

def configurable_decorator(func):
    """Decorator that uses configuration."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        if config.enabled:
            print(f"[{config.log_level}] Calling {func.__name__}")
        return func(*args, **kwargs)
    return wrapper

@configurable_decorator
def my_function():
    return "Result"

my_function()  # [INFO] Calling my_function
config.configure(log_level="DEBUG")
my_function()  # [DEBUG] Calling my_function
```

---

## Debugging Advanced Decorators

### Inspecting Decorated Functions

```python
from functools import wraps
import inspect

def debug_decorator(func):
    """Debug decorator that preserves inspection."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    
    # Preserve inspection capabilities
    wrapper.__signature__ = inspect.signature(func)
    wrapper.__annotations__ = func.__annotations__
    
    return wrapper

@debug_decorator
def add(x: int, y: int) -> int:
    """Add two numbers."""
    return x + y

# Can still inspect
print(inspect.signature(add))  # (x: int, y: int) -> int
print(add.__annotations__)     # {'x': <class 'int'>, 'y': <class 'int'>, 'return': <class 'int'>}
```

### Tracing Decorator Execution

```python
from functools import wraps

def trace_decorator(func):
    """Trace decorator execution."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"ENTER: {func.__name__}({args}, {kwargs})")
        try:
            result = func(*args, **kwargs)
            print(f"EXIT: {func.__name__} -> {result}")
            return result
        except Exception as e:
            print(f"ERROR: {func.__name__} -> {e}")
            raise
    return wrapper

@trace_decorator
def add(x, y):
    return x + y

result = add(3, 4)
# Output:
# ENTER: add((3, 4), {})
# EXIT: add -> 7
```

### Checking Decorator Application

```python
from functools import wraps

def check_metadata(func):
    """Check if metadata is preserved."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    
    # Verify metadata
    assert wrapper.__name__ == func.__name__, "Name not preserved"
    assert wrapper.__doc__ == func.__doc__, "Docstring not preserved"
    
    return wrapper

@check_metadata
def my_function():
    """My function."""
    return "Result"
```

---

## Best Practices for Advanced Decorators

### 1. Always Use @wraps

```python
from functools import wraps

def my_decorator(func):
    @wraps(func)  # Always use this
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper
```

### 2. Document Decorator Factories

```python
def retry(max_attempts=3, delay=1):
    """Retry decorator factory.
    
    Args:
        max_attempts: Maximum number of retry attempts
        delay: Delay between retries in seconds
    
    Returns:
        Decorator function
    """
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            # Implementation
            pass
        return wrapper
    return decorator
```

### 3. Handle All Arguments

```python
def my_decorator(func):
    @wraps(func)
    def wrapper(*args, **kwargs):  # Handle all arguments
        return func(*args, **kwargs)
    return wrapper
```

### 4. Test Decorator Combinations

```python
def test_decorator_combination():
    """Test that decorators work together."""
    @decorator1
    @decorator2
    def test_function(x, y):
        return x + y
    
    assert test_function(3, 4) == 7
    assert test_function.__name__ == "test_function"
```

### 5. Keep Decorators Focused

```python
# Good: Single responsibility
def log_calls(func):
    """Log function calls."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__}")
        return func(*args, **kwargs)
    return wrapper

# Avoid: Too many responsibilities
def do_everything(func):
    """Does too much."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        # Logging
        # Timing
        # Validation
        # Caching
        # etc.
        return func(*args, **kwargs)
    return wrapper
```

---

## Practice Exercise

### Exercise: Advanced Patterns

**Objective**: Create a Python program that demonstrates advanced decorator patterns.

**Instructions**:

1. Create a file called `advanced_decorators_practice.py`

2. Write a program that:
   - Uses functools.wraps properly
   - Creates decorator factories
   - Stacks multiple decorators
   - Demonstrates advanced patterns
   - Shows real-world applications

3. Your program should include:
   - @wraps usage and importance
   - Decorator factories with arguments
   - Multiple decorator stacking
   - Decorator composition
   - Advanced patterns
   - Debugging techniques

**Example Solution**:

```python
"""
Advanced Decorator Patterns Practice
This program demonstrates advanced decorator patterns.
"""

from functools import wraps
import time
import inspect

print("=" * 60)
print("ADVANCED DECORATOR PATTERNS PRACTICE")
print("=" * 60)
print()

# 1. @wraps importance
print("1. @wraps IMPORTANCE")
print("-" * 60)

def bad_decorator(func):
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper

def good_decorator(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper

@bad_decorator
def greet_bad(name):
    """Greet someone."""
    return f"Hello, {name}!"

@good_decorator
def greet_good(name):
    """Greet someone."""
    return f"Hello, {name}!"

print(f"Bad decorator - name: {greet_bad.__name__}, doc: {greet_bad.__doc__}")
print(f"Good decorator - name: {greet_good.__name__}, doc: {greet_good.__doc__}")
print()

# 2. Preserving function signature
print("2. PRESERVING FUNCTION SIGNATURE")
print("-" * 60)

def my_decorator(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper

@my_decorator
def add(x: int, y: int = 0) -> int:
    """Add two numbers."""
    return x + y

sig = inspect.signature(add)
print(f"Signature: {sig}")
print(f"Annotations: {add.__annotations__}")
print()

# 3. Basic decorator factory
print("3. BASIC DECORATOR FACTORY")
print("-" * 60)

def decorator_factory(arg1, arg2):
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            print(f"Decorator args: {arg1}, {arg2}")
            return func(*args, **kwargs)
        return wrapper
    return decorator

@decorator_factory("arg1", "arg2")
def my_function():
    return "Result"

result = my_function()
print()

# 4. Retry decorator factory
print("4. RETRY DECORATOR FACTORY")
print("-" * 60)

def retry(max_attempts=3, delay=0.1):
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

attempt_count = [0]

@retry(max_attempts=3, delay=0.1)
def unreliable_function():
    attempt_count[0] += 1
    if attempt_count[0] < 3:
        raise ValueError("Random failure")
    return "Success"

result = unreliable_function()
print(f"Result: {result}")
print()

# 5. Rate limiting factory
print("5. RATE LIMITING FACTORY")
print("-" * 60)

def rate_limit(calls_per_second):
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

print("Calling API (rate limited):")
start = time.time()
api_call()
api_call()
end = time.time()
print(f"Two calls took {end - start:.2f} seconds")
print()

# 6. Stacking decorators
print("6. STACKING DECORATORS")
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

def underline(func):
    @wraps(func)
    def wrapper():
        return f"<u>{func()}</u>"
    return wrapper

@bold
@italic
@underline
def hello():
    return "Hello"

print(f"Stacked decorators: {hello()}")
print()

# 7. Decorator execution order
print("7. DECORATOR EXECUTION ORDER")
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

print("Calling function:")
my_function()
print()

# 8. Composing decorators
print("8. COMPOSING DECORATORS")
print("-" * 60)

def compose_decorators(*decorators):
    def decorator(func):
        for dec in reversed(decorators):
            func = dec(func)
        return func
    return decorator

def log_calls(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__}")
        return func(*args, **kwargs)
    return wrapper

def timer(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        start = time.time()
        result = func(*args, **kwargs)
        end = time.time()
        print(f"Took {end - start:.4f} seconds")
        return result
    return wrapper

@compose_decorators(log_calls, timer)
def my_function():
    return "Result"

result = my_function()
print()

# 9. Conditional decorator factory
print("9. CONDITIONAL DECORATOR FACTORY")
print("-" * 60)

def conditional_decorator(condition):
    def decorator(func):
        if condition:
            @wraps(func)
            def wrapper(*args, **kwargs):
                print(f"Decorator active for {func.__name__}")
                return func(*args, **kwargs)
            return wrapper
        else:
            return func
    return decorator

DEBUG = True

@conditional_decorator(DEBUG)
def my_function():
    return "Result"

result = my_function()
print()

# 10. Validation decorator factory
print("10. VALIDATION DECORATOR FACTORY")
print("-" * 60)

def validate_types(**type_map):
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            for param_name, expected_type in type_map.items():
                if param_name in kwargs:
                    value = kwargs[param_name]
                    if not isinstance(value, expected_type):
                        raise TypeError(
                            f"{param_name} must be {expected_type.__name__}"
                        )
            return func(*args, **kwargs)
        return wrapper
    return decorator

@validate_types(x=int, y=int)
def add(x, y):
    return x + y

result = add(3, 4)
print(f"Add result: {result}")
print()

# 11. Decorator with optional arguments
print("11. DECORATOR WITH OPTIONAL ARGUMENTS")
print("-" * 60)

def smart_decorator(func=None, *, option1=None, option2=None):
    def decorator(f):
        @wraps(f)
        def wrapper(*args, **kwargs):
            if option1:
                print(f"Option1: {option1}")
            if option2:
                print(f"Option2: {option2}")
            return f(*args, **kwargs)
        return wrapper
    
    if func is None:
        return decorator
    else:
        return decorator(func)

@smart_decorator
def function1():
    return "Result1"

@smart_decorator(option1="value1", option2="value2")
def function2():
    return "Result2"

result1 = function1()
result2 = function2()
print()

# 12. Stateful decorator
print("12. STATEFUL DECORATOR")
print("-" * 60)

def stateful_decorator(initial_state):
    state = {"value": initial_state}
    
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            state["value"] += 1
            print(f"State: {state['value']}")
            return func(*args, **kwargs)
        wrapper.get_state = lambda: state["value"]
        return wrapper
    return decorator

@stateful_decorator(0)
def my_function():
    return "Result"

my_function()
my_function()
print(f"Final state: {my_function.get_state()}")
print()

# 13. Tracing decorator
print("13. TRACING DECORATOR")
print("-" * 60)

def trace_decorator(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"ENTER: {func.__name__}({args}, {kwargs})")
        try:
            result = func(*args, **kwargs)
            print(f"EXIT: {func.__name__} -> {result}")
            return result
        except Exception as e:
            print(f"ERROR: {func.__name__} -> {e}")
            raise
    return wrapper

@trace_decorator
def add(x, y):
    return x + y

result = add(3, 4)
print()

# 14. Real-world: Logging and timing
print("14. REAL-WORLD: LOGGING AND TIMING")
print("-" * 60)

def log_calls(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__} with {args}, {kwargs}")
        result = func(*args, **kwargs)
        print(f"{func.__name__} returned {result}")
        return result
    return wrapper

def timer(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        start = time.time()
        result = func(*args, **kwargs)
        end = time.time()
        print(f"{func.__name__} took {end - start:.4f} seconds")
        return result
    return wrapper

@log_calls
@timer
def add(x, y):
    return x + y

result = add(3, 4)
print()

# 15. Advanced: Decorator chain
print("15. ADVANCED: DECORATOR CHAIN")
print("-" * 60)

class DecoratorChain:
    def __init__(self):
        self.decorators = []
    
    def add(self, decorator):
        self.decorators.append(decorator)
        return self
    
    def __call__(self, func):
        for decorator in reversed(self.decorators):
            func = decorator(func)
        return func

def log_calls(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__}")
        return func(*args, **kwargs)
    return wrapper

def timer(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        start = time.time()
        result = func(*args, **kwargs)
        end = time.time()
        print(f"Took {end - start:.4f} seconds")
        return result
    return wrapper

chain = DecoratorChain()
chain.add(log_calls).add(timer)

@chain
def my_function():
    return "Result"

result = my_function()
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
ADVANCED DECORATOR PATTERNS PRACTICE
============================================================

1. @wraps IMPORTANCE
------------------------------------------------------------
Bad decorator - name: wrapper, doc: None
Good decorator - name: greet_good, doc: Greet someone.

[... rest of output ...]
```

**Challenge** (Optional):
- Create a decorator that automatically retries with exponential backoff
- Build a decorator that caches results based on function arguments
- Implement a decorator that measures memory usage
- Create a decorator that validates return types
- Build a decorator that handles exceptions and logs them

---

## Key Takeaways

1. **@wraps** - preserves function metadata (name, docstring, annotations)
2. **Decorator factories** - functions that return decorators
3. **Parameterized decorators** - decorators that accept arguments
4. **Multiple decorators** - can be stacked on a single function
5. **Execution order** - decorators applied bottom to top
6. **Decorator composition** - combine multiple decorators
7. **Metadata preservation** - important for debugging and introspection
8. **Function signature** - preserved with @wraps
9. **Optional arguments** - decorators can work with or without arguments
10. **Stateful decorators** - decorators that maintain state
11. **Conditional decorators** - apply based on conditions
12. **Debugging** - trace decorator execution
13. **Best practices** - always use @wraps, handle arguments, document
14. **Testing** - test decorator combinations
15. **Real-world patterns** - logging, timing, validation, retry

---

## Quiz: Advanced Decorators

Test your understanding with these questions:

1. **What does @wraps do?**
   - A) Wraps a function
   - B) Preserves function metadata
   - C) Creates a wrapper
   - D) Removes metadata

2. **What is a decorator factory?**
   - A) A function that creates decorators
   - B) A class that creates decorators
   - C) A function that returns a decorator
   - D) Both A and C

3. **What is the execution order when stacking decorators?**
   - A) Top to bottom
   - B) Bottom to top
   - C) Random
   - D) Depends on decorator

4. **How do you create a parameterized decorator?**
   - A) Use a decorator factory
   - B) Pass arguments directly
   - C) Use a class
   - D) It's not possible

5. **What metadata does @wraps preserve?**
   - A) __name__ only
   - B) __name__ and __doc__
   - C) All function metadata
   - D) Nothing

6. **Can you stack multiple decorators?**
   - A) No
   - B) Yes, but only two
   - C) Yes, any number
   - D) Only with special syntax

7. **What is the pattern for a decorator factory?**
   - A) `def factory(arg): return decorator`
   - B) `def factory(arg): def decorator(func): ...`
   - C) `def factory(func, arg): ...`
   - D) `def factory(arg): def wrapper: ...`

8. **Why is @wraps important?**
   - A) For performance
   - B) For preserving metadata
   - C) For security
   - D) It's not important

9. **How do you compose multiple decorators?**
   - A) Apply them sequentially
   - B) Use a composition function
   - C) Stack them with @
   - D) All of the above

10. **What happens if you don't use @wraps?**
    - A) Function works normally
    - B) Metadata is lost
    - C) Function breaks
    - D) Nothing

**Answers**:
1. B) Preserves function metadata (@wraps purpose)
2. D) Both A and C (decorator factory definition)
3. B) Bottom to top (decorator execution order)
4. A) Use a decorator factory (parameterized decorator pattern)
5. C) All function metadata (@wraps preserves all metadata)
6. C) Yes, any number (stacking decorators)
7. B) `def factory(arg): def decorator(func): ...` (correct pattern)
8. B) For preserving metadata (@wraps importance)
9. D) All of the above (ways to compose decorators)
10. B) Metadata is lost (consequence of not using @wraps)

---

## Next Steps

Excellent work! You've mastered advanced decorator patterns. You now understand:
- functools.wraps in depth
- Decorator factories
- Multiple decorators
- Advanced patterns

**What's Next?**
- Module 14: Context Managers and Resource Management
- Learn the context manager protocol
- Understand resource management
- Explore with statements

---

## Additional Resources

- **functools.wraps**: [docs.python.org/3/library/functools.html#functools.wraps](https://docs.python.org/3/library/functools.html#functools.wraps)
- **Decorator Pattern**: [en.wikipedia.org/wiki/Decorator_pattern](https://en.wikipedia.org/wiki/Decorator_pattern)
- **PEP 318**: [peps.python.org/pep-0318/](https://peps.python.org/pep-0318/) (Function Decorators)

---

*Lesson completed! You're ready to move on to the next module.*

