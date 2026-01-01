# Lesson 6.2: Function Arguments

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand different types of function arguments
- Use positional and keyword arguments
- Define functions with default parameters
- Use variable-length arguments (*args and **kwargs)
- Understand argument order and precedence
- Apply different argument types in practical scenarios
- Write flexible and versatile functions
- Avoid common argument-related mistakes

---

## Introduction to Function Arguments

Python provides several ways to pass arguments to functions, making them flexible and powerful. Understanding these different argument types allows you to write functions that can handle various calling patterns.

### Types of Arguments

1. **Positional arguments** - passed in order
2. **Keyword arguments** - passed by name
3. **Default arguments** - have default values
4. **Variable-length arguments** - *args and **kwargs

---

## Positional Arguments

**Positional arguments** are passed to a function in a specific order, matching the parameter order in the function definition.

### Basic Positional Arguments

```python
def greet(first_name, last_name):
    print(f"Hello, {first_name} {last_name}!")

# Call with positional arguments
greet("Alice", "Smith")  # Output: Hello, Alice Smith!

# Order matters!
greet("Smith", "Alice")  # Output: Hello, Smith Alice! (wrong order)
```

### Multiple Positional Arguments

```python
def calculate_total(price, quantity, tax_rate):
    subtotal = price * quantity
    tax = subtotal * tax_rate
    return subtotal + tax

# Call with positional arguments
total = calculate_total(10.0, 3, 0.08)
print(total)  # Output: 32.4
```

### Positional Arguments Example

```python
def create_student(name, age, gpa):
    return {
        "name": name,
        "age": age,
        "gpa": gpa
    }

# Must pass arguments in correct order
student = create_student("Alice", 25, 3.8)
print(student)  # Output: {'name': 'Alice', 'age': 25, 'gpa': 3.8}
```

---

## Keyword Arguments

**Keyword arguments** are passed by name, allowing you to specify which parameter gets which value.

### Basic Keyword Arguments

```python
def greet(first_name, last_name):
    print(f"Hello, {first_name} {last_name}!")

# Call with keyword arguments
greet(first_name="Alice", last_name="Smith")  # Output: Hello, Alice Smith!

# Order doesn't matter with keyword arguments
greet(last_name="Smith", first_name="Alice")  # Output: Hello, Alice Smith!
```

### Benefits of Keyword Arguments

1. **Clarity** - Makes code more readable
2. **Order independence** - Can pass in any order
3. **Self-documenting** - Parameter names show what values mean

```python
def create_rectangle(length, width, color="blue", border="solid"):
    return {
        "length": length,
        "width": width,
        "color": color,
        "border": border
    }

# More readable with keyword arguments
rect1 = create_rectangle(length=10, width=5, color="red", border="dashed")
rect2 = create_rectangle(width=5, length=10, border="dashed", color="red")  # Same result
```

### Mixing Positional and Keyword Arguments

You can mix positional and keyword arguments, but **positional must come first**:

```python
def calculate_total(price, quantity, tax_rate, discount=0):
    subtotal = price * quantity
    subtotal -= subtotal * discount
    tax = subtotal * tax_rate
    return subtotal + tax

# Mix positional and keyword
total = calculate_total(10.0, 3, tax_rate=0.08, discount=0.1)
print(total)  # Output: 29.16

# All positional
total = calculate_total(10.0, 3, 0.08, 0.1)

# All keyword
total = calculate_total(price=10.0, quantity=3, tax_rate=0.08, discount=0.1)
```

---

## Default Parameters

**Default parameters** have default values that are used if no argument is provided.

### Basic Default Parameters

```python
# Function with default parameter
def greet(name, greeting="Hello"):
    print(f"{greeting}, {name}!")

# Use default
greet("Alice")  # Output: Hello, Alice!

# Override default
greet("Alice", "Hi")  # Output: Hi, Alice!

# Use keyword to override
greet("Alice", greeting="Good morning")  # Output: Good morning, Alice!
```

### Multiple Default Parameters

```python
def create_student(name, age=18, gpa=0.0, city="Unknown"):
    return {
        "name": name,
        "age": age,
        "gpa": gpa,
        "city": city
    }

# Use all defaults except name
student1 = create_student("Alice")
print(student1)  # Output: {'name': 'Alice', 'age': 18, 'gpa': 0.0, 'city': 'Unknown'}

# Override some defaults
student2 = create_student("Bob", age=23)
print(student2)  # Output: {'name': 'Bob', 'age': 23, 'gpa': 0.0, 'city': 'Unknown'}

# Override multiple defaults
student3 = create_student("Charlie", age=24, gpa=3.8)
print(student3)  # Output: {'name': 'Charlie', 'age': 24, 'gpa': 3.8, 'city': 'Unknown'}
```

### Important: Mutable Default Arguments

**Warning**: Don't use mutable objects (lists, dictionaries) as default values!

```python
# Wrong: mutable default argument
def add_item(item, items=[]):  # BAD!
    items.append(item)
    return items

list1 = add_item("apple")
print(list1)  # Output: ['apple']

list2 = add_item("banana")
print(list2)  # Output: ['apple', 'banana'] (unexpected!)

# Correct: use None as default
def add_item(item, items=None):
    if items is None:
        items = []
    items.append(item)
    return items

list1 = add_item("apple")
print(list1)  # Output: ['apple']

list2 = add_item("banana")
print(list2)  # Output: ['banana'] (correct!)
```

### Default Parameter Examples

```python
# Power function with default exponent
def power(base, exponent=2):
    """Raise base to exponent (default: square)."""
    return base ** exponent

print(power(5))      # Output: 25 (5^2)
print(power(5, 3))   # Output: 125 (5^3)

# Formatting function
def format_name(first, last, title=""):
    if title:
        return f"{title} {first} {last}"
    return f"{first} {last}"

print(format_name("Alice", "Smith"))              # Output: Alice Smith
print(format_name("Alice", "Smith", "Dr."))       # Output: Dr. Alice Smith
```

---

## Variable-Length Arguments: *args

The `*args` syntax allows a function to accept any number of positional arguments.

### Basic *args

```python
# Function with *args
def sum_numbers(*args):
    total = 0
    for num in args:
        total += num
    return total

# Call with different numbers of arguments
print(sum_numbers(1, 2, 3))        # Output: 6
print(sum_numbers(1, 2, 3, 4, 5))  # Output: 15
print(sum_numbers(10))              # Output: 10
print(sum_numbers())                # Output: 0
```

### How *args Works

```python
def print_args(*args):
    print(f"Number of arguments: {len(args)}")
    print(f"Arguments: {args}")
    print(f"Type: {type(args)}")  # Always a tuple

print_args(1, 2, 3)
# Output:
# Number of arguments: 3
# Arguments: (1, 2, 3)
# Type: <class 'tuple'>

print_args("hello", "world")
# Output:
# Number of arguments: 2
# Arguments: ('hello', 'world')
# Type: <class 'tuple'>
```

### *args with Regular Parameters

```python
# *args must come after regular parameters
def greet(greeting, *names):
    for name in names:
        print(f"{greeting}, {name}!")

greet("Hello", "Alice", "Bob", "Charlie")
# Output:
# Hello, Alice!
# Hello, Bob!
# Hello, Charlie!
```

### Unpacking with *args

```python
# Unpack a list/tuple as arguments
def multiply(a, b, c):
    return a * b * c

numbers = [2, 3, 4]
result = multiply(*numbers)  # Unpacks: multiply(2, 3, 4)
print(result)  # Output: 24

# Unpack in function call
def sum_numbers(*args):
    return sum(args)

numbers = [1, 2, 3, 4, 5]
result = sum_numbers(*numbers)  # Unpacks list
print(result)  # Output: 15
```

### Practical *args Examples

```python
# Find maximum of any number of values
def find_max(*args):
    if not args:
        return None
    maximum = args[0]
    for num in args[1:]:
        if num > maximum:
            maximum = num
    return maximum

print(find_max(1, 5, 3, 9, 2))  # Output: 9
print(find_max(10, 20, 15))     # Output: 20

# Average of numbers
def average(*args):
    if not args:
        return 0
    return sum(args) / len(args)

print(average(10, 20, 30))      # Output: 20.0
print(average(5, 15, 25, 35))   # Output: 20.0
```

---

## Variable-Length Arguments: **kwargs

The `**kwargs` syntax allows a function to accept any number of keyword arguments.

### Basic **kwargs

```python
# Function with **kwargs
def print_info(**kwargs):
    for key, value in kwargs.items():
        print(f"{key}: {value}")

# Call with keyword arguments
print_info(name="Alice", age=25, city="NYC")
# Output:
# name: Alice
# age: 25
# city: NYC

print_info(title="Manager", department="IT")
# Output:
# title: Manager
# department: IT
```

### How **kwargs Works

```python
def print_kwargs(**kwargs):
    print(f"Number of keyword arguments: {len(kwargs)}")
    print(f"Arguments: {kwargs}")
    print(f"Type: {type(kwargs)}")  # Always a dictionary

print_kwargs(name="Alice", age=25)
# Output:
# Number of keyword arguments: 2
# Arguments: {'name': 'Alice', 'age': 25}
# Type: <class 'dict'>
```

### **kwargs with Other Parameters

```python
# **kwargs must come last
def create_profile(name, age, **kwargs):
    profile = {
        "name": name,
        "age": age
    }
    profile.update(kwargs)  # Add any additional info
    return profile

profile = create_profile("Alice", 25, city="NYC", job="Engineer")
print(profile)
# Output: {'name': 'Alice', 'age': 25, 'city': 'NYC', 'job': 'Engineer'}
```

### Unpacking with **kwargs

```python
# Unpack dictionary as keyword arguments
def greet(name, age, city):
    print(f"{name}, age {age}, lives in {city}")

person = {"name": "Alice", "age": 25, "city": "NYC"}
greet(**person)  # Unpacks: greet(name="Alice", age=25, city="NYC")
# Output: Alice, age 25, lives in NYC
```

### Practical **kwargs Examples

```python
# Configuration function
def configure_app(**settings):
    config = {
        "host": "localhost",
        "port": 8080,
        "debug": False
    }
    config.update(settings)  # Override with provided settings
    return config

app_config = configure_app(port=3000, debug=True)
print(app_config)
# Output: {'host': 'localhost', 'port': 3000, 'debug': True}

# Flexible data creation
def create_record(**data):
    return data

student = create_record(name="Alice", age=25, gpa=3.8, major="CS")
print(student)
# Output: {'name': 'Alice', 'age': 25, 'gpa': 3.8, 'major': 'CS'}
```

---

## Combining All Argument Types

You can combine all argument types, but they must follow a specific order:

### Argument Order

1. **Positional arguments** (required)
2. **Default arguments** (optional)
3. ***args** (variable positional)
4. **Keyword-only arguments** (after *args)
5. ****kwargs** (variable keyword)

### Example with All Types

```python
def complex_function(required1, required2, default1=10, default2=20, *args, keyword_only=None, **kwargs):
    """Example function with all argument types."""
    print(f"Required: {required1}, {required2}")
    print(f"Defaults: {default1}, {default2}")
    print(f"*args: {args}")
    print(f"keyword_only: {keyword_only}")
    print(f"**kwargs: {kwargs}")

# Call with all types
complex_function(
    1,                    # required1
    2,                    # required2
    default1=30,          # override default1
    # default2 uses default (20)
    100, 200, 300,        # *args
    keyword_only="test",  # keyword-only
    extra1="value1",      # **kwargs
    extra2="value2"       # **kwargs
)
```

### Practical Combined Example

```python
def process_data(name, age, *scores, city="Unknown", **metadata):
    """Process student data with flexible arguments."""
    result = {
        "name": name,
        "age": age,
        "scores": scores,
        "city": city
    }
    result.update(metadata)
    return result

student = process_data(
    "Alice",           # name (required)
    25,                # age (required)
    85, 92, 78,        # *scores (variable)
    city="NYC",        # city (keyword, overrides default)
    major="CS",        # **metadata
    year="Senior"      # **metadata
)
print(student)
```

---

## Common Patterns

### Pattern 1: Flexible Function with Defaults

```python
def send_email(to, subject, body, cc=None, bcc=None, priority="normal"):
    """Send email with optional parameters."""
    email = {
        "to": to,
        "subject": subject,
        "body": body,
        "cc": cc,
        "bcc": bcc,
        "priority": priority
    }
    # Send email logic...
    return email

# Use with defaults
email1 = send_email("user@example.com", "Hello", "Message body")

# Override defaults
email2 = send_email(
    "user@example.com",
    "Important",
    "Urgent message",
    priority="high"
)
```

### Pattern 2: Wrapper Function with *args and **kwargs

```python
def log_function_call(func):
    """Wrapper that logs function calls."""
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__} with args={args}, kwargs={kwargs}")
        result = func(*args, **kwargs)
        print(f"Result: {result}")
        return result
    return wrapper

@log_function_call
def add(a, b):
    return a + b

add(5, 3)  # Logs the call and result
```

### Pattern 3: Configuration Function

```python
def create_config(**options):
    """Create configuration with defaults and overrides."""
    config = {
        "host": "localhost",
        "port": 8080,
        "debug": False,
        "timeout": 30
    }
    config.update(options)  # Override with provided options
    return config

# Use defaults
default_config = create_config()

# Override some
custom_config = create_config(port=3000, debug=True)
```

---

## Common Mistakes and Pitfalls

### 1. Mutable Default Arguments

```python
# Wrong: mutable default
def add_item(item, items=[]):  # BAD!
    items.append(item)
    return items

# Correct: use None
def add_item(item, items=None):
    if items is None:
        items = []
    items.append(item)
    return items
```

### 2. Wrong Argument Order

```python
# Wrong: keyword before positional
def func(a, b, c=10):
    pass

# func(a=1, 2, 3)  # SyntaxError!

# Correct: positional before keyword
func(1, 2, c=3)  # OK
func(1, b=2, c=3)  # OK
```

### 3. Confusing *args and **kwargs

```python
# *args collects positional arguments (tuple)
def func1(*args):
    print(args)  # Tuple

# **kwargs collects keyword arguments (dict)
def func2(**kwargs):
    print(kwargs)  # Dictionary

func1(1, 2, 3)        # args = (1, 2, 3)
func2(a=1, b=2, c=3)  # kwargs = {'a': 1, 'b': 2, 'c': 3}
```

### 4. Forgetting to Unpack

```python
def add(a, b, c):
    return a + b + c

numbers = [1, 2, 3]

# Wrong: passes list as single argument
# add(numbers)  # TypeError!

# Correct: unpack the list
add(*numbers)  # Unpacks to add(1, 2, 3)
```

### 5. Default Parameter Evaluation

```python
# Default values are evaluated once when function is defined
import time

# Wrong: default uses current time when function is defined
def log_time(msg, timestamp=time.time()):  # BAD!
    print(f"{timestamp}: {msg}")

# Correct: use None and evaluate inside function
def log_time(msg, timestamp=None):
    if timestamp is None:
        timestamp = time.time()
    print(f"{timestamp}: {msg}")
```

---

## Practice Exercise

### Exercise: Function Arguments Practice

**Objective**: Create a Python program that demonstrates various function argument types and patterns.

**Instructions**:

1. Create a file called `function_arguments_practice.py`

2. Write a program that:
   - Uses positional and keyword arguments
   - Defines functions with default parameters
   - Uses *args for variable positional arguments
   - Uses **kwargs for variable keyword arguments
   - Combines different argument types
   - Implements practical argument-based solutions

3. Your program should include:
   - Functions with default parameters
   - Functions with *args
   - Functions with **kwargs
   - Combined argument patterns
   - Practical examples

**Example Solution**:

```python
"""
Function Arguments Practice
This program demonstrates various function argument types and patterns.
"""

print("=" * 60)
print("FUNCTION ARGUMENTS PRACTICE")
print("=" * 60)
print()

# 1. Positional Arguments
print("1. POSITIONAL ARGUMENTS")
print("-" * 60)
def greet(first_name, last_name):
    print(f"Hello, {first_name} {last_name}!")

greet("Alice", "Smith")
greet("Bob", "Jones")
print()

# 2. Keyword Arguments
print("2. KEYWORD ARGUMENTS")
print("-" * 60)
def create_rectangle(length, width, color="blue"):
    return {"length": length, "width": width, "color": color}

rect1 = create_rectangle(length=10, width=5, color="red")
rect2 = create_rectangle(width=5, color="green", length=10)  # Order doesn't matter
print(f"Rectangle 1: {rect1}")
print(f"Rectangle 2: {rect2}")
print()

# 3. Default Parameters
print("3. DEFAULT PARAMETERS")
print("-" * 60)
def greet(name, greeting="Hello"):
    print(f"{greeting}, {name}!")

greet("Alice")  # Uses default
greet("Bob", "Hi")  # Overrides default
greet("Charlie", greeting="Good morning")  # Keyword override
print()

# 4. Multiple Default Parameters
print("4. MULTIPLE DEFAULT PARAMETERS")
print("-" * 60)
def create_student(name, age=18, gpa=0.0, city="Unknown"):
    return {"name": name, "age": age, "gpa": gpa, "city": city}

student1 = create_student("Alice")
student2 = create_student("Bob", age=23)
student3 = create_student("Charlie", age=24, gpa=3.8)

print(f"Student 1: {student1}")
print(f"Student 2: {student2}")
print(f"Student 3: {student3}")
print()

# 5. Mutable Default Arguments (Correct Way)
print("5. MUTABLE DEFAULT ARGUMENTS")
print("-" * 60)
def add_item(item, items=None):
    """Correct way to handle mutable defaults."""
    if items is None:
        items = []
    items.append(item)
    return items

list1 = add_item("apple")
list2 = add_item("banana")
print(f"List 1: {list1}")  # ['apple']
print(f"List 2: {list2}")  # ['banana'] (correct!)
print()

# 6. *args - Variable Positional Arguments
print("6. *args - VARIABLE POSITIONAL ARGUMENTS")
print("-" * 60)
def sum_numbers(*args):
    return sum(args)

print(f"sum_numbers(1, 2, 3): {sum_numbers(1, 2, 3)}")
print(f"sum_numbers(1, 2, 3, 4, 5): {sum_numbers(1, 2, 3, 4, 5)}")
print(f"sum_numbers(10): {sum_numbers(10)}")
print(f"sum_numbers(): {sum_numbers()}")

def find_max(*args):
    if not args:
        return None
    return max(args)

print(f"\nfind_max(1, 5, 3, 9, 2): {find_max(1, 5, 3, 9, 2)}")
print(f"find_max(10, 20, 15): {find_max(10, 20, 15)}")
print()

# 7. *args with Regular Parameters
print("7. *args WITH REGULAR PARAMETERS")
print("-" * 60)
def greet_many(greeting, *names):
    for name in names:
        print(f"{greeting}, {name}!")

greet_many("Hello", "Alice", "Bob", "Charlie")
print()

# 8. Unpacking with *args
print("8. UNPACKING WITH *args")
print("-" * 60)
def multiply(a, b, c):
    return a * b * c

numbers = [2, 3, 4]
result = multiply(*numbers)
print(f"multiply(*{numbers}) = {result}")

def sum_all(*args):
    return sum(args)

numbers = [1, 2, 3, 4, 5]
result = sum_all(*numbers)
print(f"sum_all(*{numbers}) = {result}")
print()

# 9. **kwargs - Variable Keyword Arguments
print("9. **kwargs - VARIABLE KEYWORD ARGUMENTS")
print("-" * 60)
def print_info(**kwargs):
    for key, value in kwargs.items():
        print(f"  {key}: {value}")

print("Person info:")
print_info(name="Alice", age=25, city="NYC")

print("\nJob info:")
print_info(title="Engineer", department="IT", salary=75000)
print()

# 10. **kwargs with Other Parameters
print("10. **kwargs WITH OTHER PARAMETERS")
print("-" * 60)
def create_profile(name, age, **kwargs):
    profile = {"name": name, "age": age}
    profile.update(kwargs)
    return profile

profile = create_profile("Alice", 25, city="NYC", job="Engineer", salary=75000)
print(f"Profile: {profile}")
print()

# 11. Unpacking with **kwargs
print("11. UNPACKING WITH **kwargs")
print("-" * 60)
def greet(name, age, city):
    print(f"{name}, age {age}, lives in {city}")

person = {"name": "Alice", "age": 25, "city": "NYC"}
greet(**person)
print()

# 12. Combining All Argument Types
print("12. COMBINING ALL ARGUMENT TYPES")
print("-" * 60)
def process_data(name, age, *scores, city="Unknown", **metadata):
    result = {
        "name": name,
        "age": age,
        "scores": scores,
        "city": city
    }
    result.update(metadata)
    return result

student = process_data(
    "Alice",
    25,
    85, 92, 78,
    city="NYC",
    major="CS",
    year="Senior"
)
print(f"Student data: {student}")
print()

# 13. Flexible Configuration
print("13. FLEXIBLE CONFIGURATION")
print("-" * 60)
def create_config(**options):
    config = {
        "host": "localhost",
        "port": 8080,
        "debug": False,
        "timeout": 30
    }
    config.update(options)
    return config

default = create_config()
custom = create_config(port=3000, debug=True, timeout=60)

print(f"Default config: {default}")
print(f"Custom config: {custom}")
print()

# 14. Practical: Flexible Calculator
print("14. PRACTICAL: FLEXIBLE CALCULATOR")
print("-" * 60)
def calculate(operation, *numbers, **options):
    """Perform calculation with flexible arguments."""
    if not numbers:
        return None
    
    if operation == "sum":
        result = sum(numbers)
    elif operation == "product":
        result = 1
        for num in numbers:
            result *= num
    elif operation == "average":
        result = sum(numbers) / len(numbers)
    else:
        return None
    
    # Apply options
    if options.get("round", False):
        result = round(result, options.get("decimals", 2))
    
    return result

print(f"Sum: {calculate('sum', 1, 2, 3, 4, 5)}")
print(f"Product: {calculate('product', 2, 3, 4)}")
print(f"Average: {calculate('average', 10, 20, 30)}")
print(f"Average (rounded): {calculate('average', 10, 20, 30, round=True, decimals=1)}")
print()

# 15. Practical: Data Processing
print("15. PRACTICAL: DATA PROCESSING")
print("-" * 60)
def process_student(name, age, *grades, **info):
    """Process student data with flexible arguments."""
    student = {
        "name": name,
        "age": age,
        "grades": grades,
        "average": sum(grades) / len(grades) if grades else 0
    }
    student.update(info)
    return student

student1 = process_student("Alice", 25, 85, 92, 78, major="CS", year="Senior")
student2 = process_student("Bob", 23, 90, 88, 95, major="Math")

print(f"Student 1: {student1}")
print(f"Student 2: {student2}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
FUNCTION ARGUMENTS PRACTICE
============================================================

1. POSITIONAL ARGUMENTS
------------------------------------------------------------
Hello, Alice Smith!
Hello, Bob Jones!

2. KEYWORD ARGUMENTS
------------------------------------------------------------
Rectangle 1: {'length': 10, 'width': 5, 'color': 'red'}
Rectangle 2: {'length': 10, 'width': 5, 'color': 'green'}

[... rest of output ...]
```

**Challenge** (Optional):
- Create a flexible API wrapper function
- Build a data validation system with *args and **kwargs
- Implement a logging system with flexible arguments
- Create a configuration manager
- Build a function decorator system

---

## Key Takeaways

1. **Positional arguments** are passed in order and match parameter positions
2. **Keyword arguments** are passed by name and can be in any order
3. **Default parameters** have default values used when argument is omitted
4. **Avoid mutable defaults** - use None and create new object inside function
5. ***args collects positional arguments** into a tuple
6. ****kwargs collects keyword arguments** into a dictionary
7. **Argument order matters**: positional → defaults → *args → **kwargs
8. **Unpack with * and ** when calling** functions with sequences/dicts
9. **Mix argument types** but follow the correct order
10. **Use keyword arguments** for clarity and flexibility

---

## Quiz: Function Arguments

Test your understanding with these questions:

1. **What is the difference between positional and keyword arguments?**
   - A) No difference
   - B) Positional are passed by order, keyword by name
   - C) Keyword are passed by order, positional by name
   - D) Both must be used together

2. **What happens if you use a mutable object as a default parameter?**
   - A) Works fine
   - B) Can cause unexpected behavior (shared state)
   - C) Error
   - D) Slows down the function

3. **What does *args collect?**
   - A) Keyword arguments
   - B) Positional arguments (as tuple)
   - C) Default arguments
   - D) Return values

4. **What does **kwargs collect?**
   - A) Positional arguments
   - B) Keyword arguments (as dict)
   - C) Default arguments
   - D) Return values

5. **What is the correct order of arguments?**
   - A) *args, defaults, positional, **kwargs
   - B) Positional, defaults, *args, **kwargs
   - C) **kwargs, *args, defaults, positional
   - D) Order doesn't matter

6. **How do you unpack a list as arguments?**
   - A) `func(list)`
   - B) `func(*list)`
   - C) `func(**list)`
   - D) `func(list[])`

7. **What is the output of: `def func(x=[]): x.append(1); return x; print(func()); print(func())`?**
   - A) `[1]` then `[1]`
   - B) `[1]` then `[1, 1]`
   - C) Error
   - D) `[]` then `[]`

8. **Can you mix positional and keyword arguments?**
   - A) No
   - B) Yes, but positional must come first
   - C) Yes, in any order
   - D) Only with *args

9. **What does `greet(**{"name": "Alice"})` do if `greet(name)` is defined?**
   - A) Error
   - B) Calls `greet(name="Alice")`
   - C) Calls `greet("Alice")`
   - D) Does nothing

10. **What is the correct way to handle mutable default arguments?**
    - A) Use the mutable object directly
    - B) Use None and create new object inside function
    - C) Use empty string
    - D) Don't use defaults

**Answers**:
1. B) Positional are passed by order, keyword by name
2. B) Can cause unexpected behavior (shared state between calls)
3. B) Positional arguments (as tuple)
4. B) Keyword arguments (as dict)
5. B) Positional, defaults, *args, **kwargs (correct order)
6. B) `func(*list)` (* unpacks list as positional arguments)
7. B) `[1]` then `[1, 1]` (mutable default shares state!)
8. B) Yes, but positional must come first
9. B) Calls `greet(name="Alice")` (** unpacks dict as keyword arguments)
10. B) Use None and create new object inside function (avoids shared state)

---

## Next Steps

Excellent work! You've mastered function arguments. You now understand:
- Positional and keyword arguments
- Default parameters and their pitfalls
- Variable-length arguments (*args and **kwargs)
- How to combine different argument types
- Best practices and common patterns

**What's Next?**
- Lesson 6.3: Scope and Namespaces
- Practice building flexible, reusable functions
- Learn about function decorators
- Explore advanced function features

---

## Additional Resources

- **Python Function Arguments**: [docs.python.org/3/tutorial/controlflow.html#more-on-defining-functions](https://docs.python.org/3/tutorial/controlflow.html#more-on-defining-functions)
- **Unpacking Arguments**: [docs.python.org/3/tutorial/controlflow.html#unpacking-argument-lists](https://docs.python.org/3/tutorial/controlflow.html#unpacking-argument-lists)
- **Default Argument Values**: [docs.python.org/3/tutorial/controlflow.html#default-argument-values](https://docs.python.org/3/tutorial/controlflow.html#default-argument-values)

---

*Lesson completed! You're ready to move on to the next lesson.*

