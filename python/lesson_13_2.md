# Lesson 13.2: Creating Decorators

## Learning Objectives

By the end of this lesson, you will be able to:
- Create function decorators
- Use decorator syntax (@)
- Create decorators with arguments
- Understand decorator factories
- Create parameterized decorators
- Handle decorator arguments properly
- Create reusable decorators
- Understand decorator patterns
- Apply decorators effectively
- Debug decorator issues

---

## Introduction to Creating Decorators

Now that you understand how decorators work, let's learn to create your own decorators. This lesson covers creating function decorators, using decorator syntax, and creating decorators that accept arguments.

---

## Function Decorators

### Basic Function Decorator

A **function decorator** is a function that takes another function and returns a modified version of it.

### Simple Decorator Example

```python
def simple_decorator(func):
    """Simple decorator that adds functionality."""
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__}")
        result = func(*args, **kwargs)
        print(f"{func.__name__} finished")
        return result
    return wrapper

# Apply decorator manually
def greet(name):
    return f"Hello, {name}!"

decorated_greet = simple_decorator(greet)
result = decorated_greet("Alice")
# Output:
# Calling greet
# greet finished
```

### Using Decorator Syntax

```python
def simple_decorator(func):
    """Simple decorator."""
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__}")
        result = func(*args, **kwargs)
        print(f"{func.__name__} finished")
        return result
    return wrapper

# Using @ syntax
@simple_decorator
def greet(name):
    return f"Hello, {name}!"

result = greet("Alice")
# Output:
# Calling greet
# greet finished
```

### Preserving Metadata

```python
from functools import wraps

def simple_decorator(func):
    """Simple decorator with metadata preservation."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__}")
        result = func(*args, **kwargs)
        print(f"{func.__name__} finished")
        return result
    return wrapper

@simple_decorator
def greet(name):
    """Greet someone."""
    return f"Hello, {name}!"

print(greet.__name__)  # greet (not wrapper)
print(greet.__doc__)   # Greet someone.
```

---

## Creating Practical Decorators

### 1. Logging Decorator

```python
from functools import wraps
import logging

# Setup logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

def log_function(func):
    """Log function calls and results."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        logger.info(f"Calling {func.__name__} with args={args}, kwargs={kwargs}")
        try:
            result = func(*args, **kwargs)
            logger.info(f"{func.__name__} returned {result}")
            return result
        except Exception as e:
            logger.error(f"{func.__name__} raised {e}")
            raise
    return wrapper

@log_function
def add(x, y):
    return x + y

result = add(3, 4)
# Logs: INFO: Calling add with args=(3, 4), kwargs={}
# Logs: INFO: add returned 7
```

### 2. Timing Decorator

```python
from functools import wraps
import time

def timer(func):
    """Measure and print function execution time."""
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
                    print(f"Attempt {attempt + 1} failed: {e}. Retrying in {delay}s...")
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

def validate_types(*expected_types):
    """Validate function argument types."""
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            if len(args) != len(expected_types):
                raise TypeError(f"Expected {len(expected_types)} arguments, got {len(args)}")
            for arg, expected_type in zip(args, expected_types):
                if not isinstance(arg, expected_type):
                    raise TypeError(f"Expected {expected_type.__name__}, got {type(arg).__name__}")
            return func(*args, **kwargs)
        return wrapper
    return decorator

@validate_types(int, int)
def add(x, y):
    return x + y

result = add(3, 4)  # Works
# result = add("3", 4)  # TypeError
```

### 5. Cache Decorator

```python
from functools import wraps

def cache(func):
    """Cache function results."""
    cache_dict = {}
    @wraps(func)
    def wrapper(*args, **kwargs):
        # Create cache key
        key = str(args) + str(sorted(kwargs.items()))
        if key not in cache_dict:
            cache_dict[key] = func(*args, **kwargs)
        return cache_dict[key]
    return wrapper

@cache
def expensive_function(n):
    print(f"Computing for {n}")
    return n ** 2

print(expensive_function(5))  # Computing for 5, then 25
print(expensive_function(5))  # 25 (cached)
```

---

## Decorators with Arguments

### Understanding Decorator Factories

When you need a decorator that accepts arguments, you need a **decorator factory** - a function that returns a decorator.

### Basic Pattern

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

### Example: Repeat Decorator

```python
from functools import wraps

def repeat(times):
    """Repeat function execution multiple times."""
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            results = []
            for _ in range(times):
                result = func(*args, **kwargs)
                results.append(result)
            return results
        return wrapper
    return decorator

@repeat(times=3)
def greet(name):
    return f"Hello, {name}!"

result = greet("Alice")
print(result)  # ['Hello, Alice!', 'Hello, Alice!', 'Hello, Alice!']
```

### Example: Rate Limiting Decorator

```python
from functools import wraps
import time

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

### Example: Timeout Decorator

```python
from functools import wraps
import signal

def timeout(seconds):
    """Timeout decorator (Unix only)."""
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            def timeout_handler(signum, frame):
                raise TimeoutError(f"Function {func.__name__} timed out after {seconds} seconds")
            
            # Set signal handler
            old_handler = signal.signal(signal.SIGALRM, timeout_handler)
            signal.alarm(seconds)
            
            try:
                result = func(*args, **kwargs)
            finally:
                signal.alarm(0)
                signal.signal(signal.SIGALRM, old_handler)
            
            return result
        return wrapper
    return decorator

@timeout(seconds=5)
def slow_function():
    time.sleep(10)  # Will timeout
    return "Done"
```

### Example: Conditional Decorator

```python
from functools import wraps

def conditional_decorator(condition):
    """Apply decorator only if condition is True."""
    def decorator(func):
        if condition:
            @wraps(func)
            def wrapper(*args, **kwargs):
                print(f"Decorator is active for {func.__name__}")
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

---

## Advanced Decorator Patterns

### 1. Decorator with Optional Arguments

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

### 2. Class-Based Decorator

```python
class CountCalls:
    """Decorator that counts function calls."""
    def __init__(self, func):
        self.func = func
        self.count = 0
        functools.update_wrapper(self, func)
    
    def __call__(self, *args, **kwargs):
        self.count += 1
        print(f"{self.func.__name__} called {self.count} times")
        return self.func(*args, **kwargs)

@CountCalls
def greet(name):
    return f"Hello, {name}!"

greet("Alice")  # greet called 1 times
greet("Bob")    # greet called 2 times
```

### 3. Class-Based Decorator with Arguments

```python
from functools import wraps

class Retry:
    """Retry decorator as a class."""
    def __init__(self, max_attempts=3, delay=1):
        self.max_attempts = max_attempts
        self.delay = delay
    
    def __call__(self, func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            for attempt in range(self.max_attempts):
                try:
                    return func(*args, **kwargs)
                except Exception as e:
                    if attempt == self.max_attempts - 1:
                        raise
                    print(f"Attempt {attempt + 1} failed: {e}. Retrying...")
                    time.sleep(self.delay)
        return wrapper

@Retry(max_attempts=3, delay=1)
def unreliable_function():
    import random
    if random.random() < 0.7:
        raise ValueError("Random failure")
    return "Success"
```

### 4. Stacking Multiple Decorators

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

---

## Practical Examples

### Example 1: Authentication Decorator

```python
from functools import wraps

def require_auth(func):
    """Require authentication before function execution."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        # Check authentication (simplified)
        is_authenticated = check_authentication()  # Your auth logic
        if not is_authenticated:
            raise PermissionError("Authentication required")
        return func(*args, **kwargs)
    return wrapper

def check_authentication():
    # Your authentication logic
    return True  # Simplified

@require_auth
def protected_function():
    return "Protected content"
```

### Example 2: Deprecation Warning

```python
from functools import wraps
import warnings

def deprecated(reason=None):
    """Mark function as deprecated."""
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            message = f"{func.__name__} is deprecated"
            if reason:
                message += f": {reason}"
            warnings.warn(message, DeprecationWarning, stacklevel=2)
            return func(*args, **kwargs)
        return wrapper
    return decorator

@deprecated(reason="Use new_function instead")
def old_function():
    return "Old result"
```

### Example 3: Memoization Decorator

```python
from functools import wraps

def memoize(func):
    """Memoize function results."""
    cache = {}
    @wraps(func)
    def wrapper(*args, **kwargs):
        # Create cache key
        key = str(args) + str(sorted(kwargs.items()))
        if key not in cache:
            cache[key] = func(*args, **kwargs)
        return cache[key]
    return wrapper

@memoize
def fibonacci(n):
    if n < 2:
        return n
    return fibonacci(n - 1) + fibonacci(n - 2)

# Much faster with memoization
result = fibonacci(30)
```

### Example 4: Debug Decorator

```python
from functools import wraps
import inspect

def debug(func):
    """Debug decorator that prints function details."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__}")
        print(f"  Arguments: {args}")
        print(f"  Keyword arguments: {kwargs}")
        print(f"  Signature: {inspect.signature(func)}")
        result = func(*args, **kwargs)
        print(f"  Returned: {result}")
        return result
    return wrapper

@debug
def add(x, y, z=0):
    return x + y + z

result = add(3, 4, z=5)
```

---

## Common Mistakes and Pitfalls

### 1. Forgetting to Return the Wrapper

```python
# WRONG: Not returning wrapper
def bad_decorator(func):
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    # Missing return statement!

# CORRECT: Return wrapper
def good_decorator(func):
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper
```

### 2. Not Using @wraps

```python
# WRONG: Metadata lost
def bad_decorator(func):
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper

@bad_decorator
def greet(name):
    """Greet someone."""
    return f"Hello, {name}!"

print(greet.__name__)  # wrapper (wrong!)

# CORRECT: Use @wraps
from functools import wraps

def good_decorator(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper
```

### 3. Incorrect Decorator Factory Pattern

```python
# WRONG: Not a factory
def bad_decorator(func, arg):
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper

# CORRECT: Factory pattern
def good_decorator(arg):
    def decorator(func):
        def wrapper(*args, **kwargs):
            return func(*args, **kwargs)
        return wrapper
    return decorator
```

### 4. Not Handling Arguments Properly

```python
# WRONG: Doesn't handle arguments
def bad_decorator(func):
    def wrapper():
        return func()
    return wrapper

@bad_decorator
def add(x, y):
    return x + y

# add(3, 4)  # TypeError!

# CORRECT: Handle all arguments
def good_decorator(func):
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper
```

---

## Best Practices

### 1. Always Use @wraps

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

### 3. Document Your Decorators

```python
def my_decorator(func):
    """Decorator that does something.
    
    This decorator modifies the behavior of the function
    by adding some functionality.
    
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

### 4. Keep Decorators Focused

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

### 5. Test Your Decorators

```python
def my_decorator(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper

# Test
@my_decorator
def test_function(x, y):
    return x + y

assert test_function(3, 4) == 7
assert test_function.__name__ == "test_function"
```

---

## Decorator Composition and Chaining

### Composing Multiple Decorators

You can combine multiple decorators to create complex behavior:

```python
from functools import wraps
import time

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
        print(f"{func.__name__} took {end - start:.4f} seconds")
        return result
    return wrapper

def validate_positive(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        for arg in args:
            if isinstance(arg, (int, float)) and arg < 0:
                raise ValueError(f"Argument {arg} must be positive")
        return func(*args, **kwargs)
    return wrapper

# Compose decorators
@log_calls
@timer
@validate_positive
def square_root(x):
    return x ** 0.5

result = square_root(16)
# Output:
# Calling square_root
# square_root took 0.0000 seconds
```

### Creating Decorator Compositions

You can create a decorator that applies multiple decorators:

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

---

## Performance Considerations

### Decorator Overhead

Decorators add a small overhead to function calls:

```python
import time
from functools import wraps

def no_op_decorator(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    return wrapper

@no_op_decorator
def simple_function(x):
    return x * 2

# Measure overhead
start = time.time()
for _ in range(1000000):
    simple_function(5)
end = time.time()
print(f"Decorated: {end - start:.4f} seconds")

# Compare with undecorated
def simple_function_undecorated(x):
    return x * 2

start = time.time()
for _ in range(1000000):
    simple_function_undecorated(5)
end = time.time()
print(f"Undecorated: {end - start:.4f} seconds")
```

### Optimizing Decorators

For performance-critical code, consider:

```python
# Option 1: Conditional decoration
def conditional_decorator(condition):
    def decorator(func):
        if condition:
            @wraps(func)
            def wrapper(*args, **kwargs):
                # Add functionality
                return func(*args, **kwargs)
            return wrapper
        return func
    return decorator

# Option 2: Lazy evaluation
def lazy_decorator(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        # Only do expensive operations when needed
        if some_condition:
            expensive_operation()
        return func(*args, **kwargs)
    return wrapper
```

---

## Real-World Use Cases

### 1. Web Framework Decorators

```python
from functools import wraps

def route(path):
    """Route decorator for web framework."""
    def decorator(func):
        func.route_path = path
        func.is_route = True
        return func
    return decorator

@route("/users")
def get_users():
    return {"users": []}

@route("/users/<id>")
def get_user(id):
    return {"user": {"id": id}}
```

### 2. API Rate Limiting

```python
from functools import wraps
import time
from collections import defaultdict

class RateLimiter:
    def __init__(self, max_calls, period):
        self.max_calls = max_calls
        self.period = period
        self.calls = defaultdict(list)
    
    def __call__(self, func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            now = time.time()
            # Clean old calls
            self.calls[func.__name__] = [
                call_time for call_time in self.calls[func.__name__]
                if now - call_time < self.period
            ]
            
            if len(self.calls[func.__name__]) >= self.max_calls:
                raise Exception("Rate limit exceeded")
            
            self.calls[func.__name__].append(now)
            return func(*args, **kwargs)
        return wrapper

@RateLimiter(max_calls=5, period=60)
def api_call():
    return "API response"
```

### 3. Database Transaction Management

```python
from functools import wraps

def transaction(func):
    """Manage database transactions."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        db = get_database_connection()
        try:
            result = func(*args, **kwargs)
            db.commit()
            return result
        except Exception as e:
            db.rollback()
            raise
        finally:
            db.close()
    return wrapper

@transaction
def create_user(name, email):
    db.execute("INSERT INTO users (name, email) VALUES (?, ?)", (name, email))
    return {"id": db.lastrowid}
```

### 4. Permission Checking

```python
from functools import wraps

def require_permission(permission):
    """Check user permissions."""
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            user = get_current_user()
            if not user.has_permission(permission):
                raise PermissionError(f"Requires {permission} permission")
            return func(*args, **kwargs)
        return wrapper
    return decorator

@require_permission("admin")
def delete_user(user_id):
    # Delete user logic
    return {"status": "deleted"}
```

### 5. Input/Output Validation

```python
from functools import wraps

def validate_input(**validators):
    """Validate function inputs."""
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            # Validate based on validators
            for param_name, validator in validators.items():
                if param_name in kwargs:
                    if not validator(kwargs[param_name]):
                        raise ValueError(f"Invalid {param_name}")
            return func(*args, **kwargs)
        return wrapper
    return decorator

def is_positive(x):
    return isinstance(x, (int, float)) and x > 0

@validate_input(age=is_positive, name=lambda x: isinstance(x, str) and len(x) > 0)
def create_profile(name, age):
    return {"name": name, "age": age}
```

---

## Debugging Decorators

### Common Debugging Techniques

```python
from functools import wraps
import traceback

def debug_decorator(func):
    """Debug decorator that shows execution flow."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"DEBUG: Entering {func.__name__}")
        print(f"DEBUG: Args: {args}, Kwargs: {kwargs}")
        try:
            result = func(*args, **kwargs)
            print(f"DEBUG: Exiting {func.__name__} with result: {result}")
            return result
        except Exception as e:
            print(f"DEBUG: Exception in {func.__name__}: {e}")
            traceback.print_exc()
            raise
    return wrapper

@debug_decorator
def problematic_function(x, y):
    return x / y

# This will show detailed debug information
```

### Inspecting Decorated Functions

```python
from functools import wraps
import inspect

def inspect_decorator(func):
    """Decorator that preserves inspection capabilities."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs)
    
    # Preserve inspection attributes
    wrapper.__signature__ = inspect.signature(func)
    wrapper.__annotations__ = func.__annotations__
    
    return wrapper

@inspect_decorator
def add(x: int, y: int) -> int:
    """Add two numbers."""
    return x + y

# Can still inspect
print(inspect.signature(add))  # (x: int, y: int) -> int
print(add.__annotations__)     # {'x': <class 'int'>, 'y': <class 'int'>, 'return': <class 'int'>}
```

### Testing Decorators

```python
import unittest
from functools import wraps

def my_decorator(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        return func(*args, **kwargs) * 2
    return wrapper

class TestDecorator(unittest.TestCase):
    def test_decorator_applies(self):
        @my_decorator
        def add(x, y):
            return x + y
        
        result = add(3, 4)
        self.assertEqual(result, 14)  # (3 + 4) * 2
    
    def test_metadata_preserved(self):
        @my_decorator
        def greet(name):
            """Greet someone."""
            return f"Hello, {name}!"
        
        self.assertEqual(greet.__name__, "greet")
        self.assertEqual(greet.__doc__, "Greet someone.")
```

---

## Practice Exercise

### Exercise: Creating Decorators

**Objective**: Create a Python program that demonstrates creating various decorators.

**Instructions**:

1. Create a file called `creating_decorators_practice.py`

2. Write a program that:
   - Creates basic function decorators
   - Creates decorators with arguments
   - Implements practical decorators
   - Demonstrates decorator patterns
   - Shows advanced decorator techniques

3. Your program should include:
   - Basic decorator creation
   - Decorator with @ syntax
   - Decorator factories
   - Parameterized decorators
   - Class-based decorators
   - Stacking decorators
   - Real-world decorator examples

**Example Solution**:

```python
"""
Creating Decorators Practice
This program demonstrates creating various types of decorators.
"""

from functools import wraps
import time

print("=" * 60)
print("CREATING DECORATORS PRACTICE")
print("=" * 60)
print()

# 1. Basic function decorator
print("1. BASIC FUNCTION DECORATOR")
print("-" * 60)

def simple_decorator(func):
    """Simple decorator."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__}")
        result = func(*args, **kwargs)
        print(f"{func.__name__} finished")
        return result
    return wrapper

@simple_decorator
def greet(name):
    return f"Hello, {name}!"

result = greet("Alice")
print()

# 2. Logging decorator
print("2. LOGGING DECORATOR")
print("-" * 60)

def log_function(func):
    """Log function calls."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__} with args={args}, kwargs={kwargs}")
        result = func(*args, **kwargs)
        print(f"{func.__name__} returned {result}")
        return result
    return wrapper

@log_function
def add(x, y):
    return x + y

result = add(3, 4)
print()

# 3. Timing decorator
print("3. TIMING DECORATOR")
print("-" * 60)

def timer(func):
    """Measure execution time."""
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

# 4. Decorator with arguments - Repeat
print("4. DECORATOR WITH ARGUMENTS - REPEAT")
print("-" * 60)

def repeat(times):
    """Repeat function execution."""
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            results = []
            for _ in range(times):
                result = func(*args, **kwargs)
                results.append(result)
            return results
        return wrapper
    return decorator

@repeat(times=3)
def greet(name):
    return f"Hello, {name}!"

result = greet("Alice")
print(f"Result: {result}")
print()

# 5. Rate limiting decorator
print("5. RATE LIMITING DECORATOR")
print("-" * 60)

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

print("Calling API (rate limited):")
start = time.time()
api_call()
api_call()
end = time.time()
print(f"Two calls took {end - start:.2f} seconds")
print()

# 6. Validation decorator
print("6. VALIDATION DECORATOR")
print("-" * 60)

def validate_positive(func):
    """Validate arguments are positive."""
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

# 7. Cache decorator
print("7. CACHE DECORATOR")
print("-" * 60)

def cache(func):
    """Cache function results."""
    cache_dict = {}
    @wraps(func)
    def wrapper(*args, **kwargs):
        key = str(args) + str(sorted(kwargs.items()))
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

# 8. Function call counter
print("8. FUNCTION CALL COUNTER")
print("-" * 60)

def count_calls(func):
    """Count function calls."""
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

# 9. Retry decorator
print("9. RETRY DECORATOR")
print("-" * 60)

def retry(max_attempts=3, delay=0.1):
    """Retry on failure."""
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

# 10. Class-based decorator
print("10. CLASS-BASED DECORATOR")
print("-" * 60)

class CountCalls:
    """Count function calls using class."""
    def __init__(self, func):
        self.func = func
        self.count = 0
        wraps(func)(self)
    
    def __call__(self, *args, **kwargs):
        self.count += 1
        print(f"{self.func.__name__} called {self.count} times")
        return self.func(*args, **kwargs)

@CountCalls
def greet(name):
    return f"Hello, {name}!"

greet("Alice")
greet("Bob")
print()

# 11. Class-based decorator with arguments
print("11. CLASS-BASED DECORATOR WITH ARGUMENTS")
print("-" * 60)

class Retry:
    """Retry decorator as class."""
    def __init__(self, max_attempts=3, delay=0.1):
        self.max_attempts = max_attempts
        self.delay = delay
    
    def __call__(self, func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            for attempt in range(self.max_attempts):
                try:
                    return func(*args, **kwargs)
                except Exception as e:
                    if attempt == self.max_attempts - 1:
                        raise
                    print(f"Attempt {attempt + 1} failed: {e}. Retrying...")
                    time.sleep(self.delay)
        return wrapper

attempt_count = [0]

@Retry(max_attempts=3, delay=0.1)
def unreliable_function2():
    attempt_count[0] += 1
    if attempt_count[0] < 3:
        raise ValueError("Random failure")
    return "Success"

result = unreliable_function2()
print(f"Result: {result}")
print()

# 12. Stacking decorators
print("12. STACKING DECORATORS")
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

# 13. Conditional decorator
print("13. CONDITIONAL DECORATOR")
print("-" * 60)

def conditional_decorator(condition):
    """Apply decorator only if condition is True."""
    def decorator(func):
        if condition:
            @wraps(func)
            def wrapper(*args, **kwargs):
                print(f"Decorator is active for {func.__name__}")
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

# 14. Debug decorator
print("14. DEBUG DECORATOR")
print("-" * 60)

def debug(func):
    """Debug decorator."""
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"DEBUG: Calling {func.__name__}")
        print(f"DEBUG:   Arguments: {args}")
        print(f"DEBUG:   Keyword arguments: {kwargs}")
        result = func(*args, **kwargs)
        print(f"DEBUG:   Returned: {result}")
        return result
    return wrapper

@debug
def add(x, y, z=0):
    return x + y + z

result = add(3, 4, z=5)
print()

# 15. Memoization decorator
print("15. MEMOIZATION DECORATOR")
print("-" * 60)

def memoize(func):
    """Memoize function results."""
    cache = {}
    @wraps(func)
    def wrapper(*args, **kwargs):
        key = str(args) + str(sorted(kwargs.items()))
        if key not in cache:
            cache[key] = func(*args, **kwargs)
        return cache[key]
    return wrapper

@memoize
def fibonacci(n):
    if n < 2:
        return n
    return fibonacci(n - 1) + fibonacci(n - 2)

print(f"Fibonacci(10): {fibonacci(10)}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
CREATING DECORATORS PRACTICE
============================================================

1. BASIC FUNCTION DECORATOR
------------------------------------------------------------
Calling greet
greet finished

[... rest of output ...]
```

**Challenge** (Optional):
- Create a decorator that measures memory usage
- Build a decorator that validates return types
- Implement a decorator that handles exceptions gracefully
- Create a decorator that adds authentication
- Build a decorator that tracks function performance metrics

---

## Key Takeaways

1. **Function decorators** - functions that modify other functions
2. **@ syntax** - shorthand for applying decorators
3. **@wraps** - preserves function metadata
4. **Decorator factories** - functions that return decorators
5. **Parameterized decorators** - decorators that accept arguments
6. **Class-based decorators** - decorators implemented as classes
7. **Stacking decorators** - applying multiple decorators
8. **Common patterns** - logging, timing, validation, caching, retry
9. **Best practices** - use @wraps, handle arguments, document
10. **Decorator factories** - pattern for decorators with arguments
11. **Closures** - inner functions access outer scope
12. **Metadata preservation** - important for debugging
13. **Reusability** - decorators enable code reuse
14. **Separation of concerns** - keep logic separate
15. **Testing** - always test your decorators

---

## Quiz: Decorator Creation

Test your understanding with these questions:

1. **What is a decorator factory?**
   - A) A function that creates decorators
   - B) A class that creates decorators
   - C) A function that returns a decorator
   - D) Both A and C

2. **How do you create a decorator that accepts arguments?**
   - A) Use a decorator factory
   - B) Pass arguments directly
   - C) Use a class
   - D) It's not possible

3. **What does @wraps do?**
   - A) Wraps a function
   - B) Preserves function metadata
   - C) Creates a wrapper
   - D) Removes metadata

4. **Can you stack multiple decorators?**
   - A) No
   - B) Yes, but only two
   - C) Yes, any number
   - D) Only with special syntax

5. **What pattern is used for decorators with arguments?**
   - A) Direct arguments
   - B) Decorator factory
   - C) Class decorator
   - D) Nested functions

6. **What should decorator wrappers use to handle arguments?**
   - A) `*args`
   - B) `**kwargs`
   - C) Both A and B
   - D) No special handling

7. **What is the correct pattern for a decorator factory?**
   - A) `def factory(arg): return decorator`
   - B) `def factory(arg): def decorator(func): ...`
   - C) `def factory(func, arg): ...`
   - D) `def factory(arg): def wrapper: ...`

8. **Can decorators be implemented as classes?**
   - A) No
   - B) Yes, using __call__
   - C) Yes, using __init__
   - D) Only in Python 3.9+

9. **What happens if you don't use @wraps?**
   - A) Function works normally
   - B) Metadata is lost
   - C) Function breaks
   - D) Nothing

10. **What is the order of decorator execution when stacking?**
    - A) Top to bottom
    - B) Bottom to top
    - C) Random
    - D) Depends on decorator

**Answers**:
1. D) Both A and C (decorator factory definition)
2. A) Use a decorator factory (pattern for arguments)
3. B) Preserves function metadata (@wraps purpose)
4. C) Yes, any number (stacking decorators)
5. B) Decorator factory (pattern for arguments)
6. C) Both A and B (handle all arguments)
7. B) `def factory(arg): def decorator(func): ...` (correct pattern)
8. B) Yes, using __call__ (class-based decorators)
9. B) Metadata is lost (consequence of not using @wraps)
10. B) Bottom to top (decorator execution order)

---

## Next Steps

Excellent work! You've mastered creating decorators. You now understand:
- How to create function decorators
- How to use decorator syntax
- How to create decorators with arguments
- Advanced decorator patterns

**What's Next?**
- Lesson 13.3: Class Decorators
- Learn to decorate classes
- Understand property decorators
- Explore class decorator patterns

---

## Additional Resources

- **Decorators**: [docs.python.org/3/glossary.html#term-decorator](https://docs.python.org/3/glossary.html#term-decorator)
- **functools.wraps**: [docs.python.org/3/library/functools.html#functools.wraps](https://docs.python.org/3/library/functools.html#functools.wraps)
- **PEP 318**: [peps.python.org/pep-0318/](https://peps.python.org/pep-0318/) (Function Decorators)

---

*Lesson completed! You're ready to move on to the next lesson.*

