# Lesson 6.1: Function Basics

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what functions are and why they're useful
- Define functions using the `def` keyword
- Call functions with arguments
- Understand function parameters and arguments
- Use return statements to return values
- Write functions with and without parameters
- Understand function scope basics
- Apply functions in practical programming scenarios
- Write clean and reusable function code

---

## Introduction to Functions

A **function** is a reusable block of code that performs a specific task. Functions allow you to:
- **Organize code** into logical, manageable pieces
- **Avoid repetition** (DRY - Don't Repeat Yourself)
- **Make code reusable** across different parts of your program
- **Improve readability** by giving meaningful names to code blocks
- **Facilitate testing** and debugging

### Why Use Functions?

**Without functions** (repetitive code):
```python
# Calculate area of rectangle - repeated code
length1 = 5
width1 = 3
area1 = length1 * width1
print(f"Area 1: {area1}")

length2 = 10
width2 = 4
area2 = length2 * width2
print(f"Area 2: {area2}")

length3 = 7
width3 = 2
area3 = length3 * width3
print(f"Area 3: {area3}")
```

**With functions** (reusable code):
```python
def calculate_area(length, width):
    return length * width

area1 = calculate_area(5, 3)
area2 = calculate_area(10, 4)
area3 = calculate_area(7, 2)
print(f"Area 1: {area1}")
print(f"Area 2: {area2}")
print(f"Area 3: {area3}")
```

---

## Defining Functions

### Basic Syntax

```python
def function_name(parameters):
    """Optional docstring describing the function"""
    # Function body
    statement1
    statement2
    return value  # Optional
```

**Key Components**:
- `def` - keyword to define a function
- `function_name` - name of the function (follows variable naming rules)
- `parameters` - optional inputs to the function (in parentheses)
- `:` - colon required after function signature
- **Indented block** - function body (code that executes)
- `return` - optional statement to return a value

### Simple Function Examples

```python
# Function without parameters
def greet():
    print("Hello, World!")

# Function with parameters
def greet_person(name):
    print(f"Hello, {name}!")

# Function with return value
def add_numbers(a, b):
    return a + b

# Function with docstring
def multiply(x, y):
    """Multiply two numbers and return the result."""
    return x * y
```

---

## Calling Functions

To use a function, you **call** (invoke) it by using its name followed by parentheses.

### Basic Function Calls

```python
# Define function
def greet():
    print("Hello, World!")

# Call function
greet()  # Output: Hello, World!

# Function with parameters
def greet_person(name):
    print(f"Hello, {name}!")

# Call with argument
greet_person("Alice")  # Output: Hello, Alice!

# Function with return value
def add_numbers(a, b):
    return a + b

# Call and use return value
result = add_numbers(5, 3)
print(result)  # Output: 8

# Call directly in expression
print(add_numbers(10, 20))  # Output: 30
```

### Function Call Syntax

```python
# Basic call
function_name()

# Call with arguments
function_name(arg1, arg2)

# Call and store result
result = function_name(arg1, arg2)

# Call in expression
value = function_name(arg1) + 10
```

---

## Function Parameters and Arguments

### Parameters vs Arguments

- **Parameter**: Variable in the function definition
- **Argument**: Value passed to the function when calling it

```python
# 'name' is a parameter
def greet_person(name):
    print(f"Hello, {name}!")

# "Alice" is an argument
greet_person("Alice")
```

### Functions with Parameters

```python
# Single parameter
def square(number):
    return number ** 2

result = square(5)
print(result)  # Output: 25

# Multiple parameters
def calculate_area(length, width):
    return length * width

area = calculate_area(5, 3)
print(area)  # Output: 15

# Parameters are used like variables
def greet(first_name, last_name):
    full_name = f"{first_name} {last_name}"
    print(f"Hello, {full_name}!")

greet("Alice", "Smith")  # Output: Hello, Alice Smith!
```

### Parameter Order Matters

```python
def introduce(name, age, city):
    print(f"{name} is {age} years old and lives in {city}")

# Correct order
introduce("Alice", 25, "NYC")  # Output: Alice is 25 years old and lives in NYC

# Wrong order (produces incorrect output)
introduce(25, "Alice", "NYC")  # Output: 25 is Alice years old and lives in NYC
```

---

## Return Statements

The `return` statement sends a value back to the caller and exits the function.

### Basic Return

```python
# Function that returns a value
def add(a, b):
    return a + b

result = add(5, 3)
print(result)  # Output: 8

# Function without return (returns None)
def greet(name):
    print(f"Hello, {name}!")

result = greet("Alice")
print(result)  # Output: Hello, Alice!
#          None (implicit return)
```

### Multiple Return Values

Python functions can return multiple values (as a tuple):

```python
# Return multiple values
def get_name_age():
    return "Alice", 25

# Unpack the return values
name, age = get_name_age()
print(f"{name} is {age} years old")  # Output: Alice is 25 years old

# Or use as tuple
result = get_name_age()
print(result)  # Output: ('Alice', 25)

# Return multiple calculated values
def calculate_stats(numbers):
    total = sum(numbers)
    count = len(numbers)
    average = total / count
    return total, count, average

scores = [85, 92, 78, 96, 88]
total, count, avg = calculate_stats(scores)
print(f"Total: {total}, Count: {count}, Average: {avg:.2f}")
```

### Early Return

You can use `return` to exit a function early:

```python
def check_age(age):
    if age < 0:
        return "Invalid age"  # Early return
    if age < 18:
        return "Minor"
    if age < 65:
        return "Adult"
    return "Senior"

print(check_age(25))   # Output: Adult
print(check_age(-5))   # Output: Invalid age
print(check_age(70))   # Output: Senior
```

### Return None Explicitly

```python
# Explicit None return
def process_data(data):
    if not data:
        return None
    # Process data...
    return processed_result

# Implicit None return
def do_something():
    print("Doing something...")
    # No return statement - returns None automatically
```

---

## Functions Without Parameters

Functions don't always need parameters:

```python
# Function with no parameters
def get_current_time():
    import datetime
    return datetime.datetime.now()

current_time = get_current_time()
print(current_time)

# Function that prints a message
def print_welcome():
    print("Welcome to the program!")
    print("Please follow the instructions.")

print_welcome()
```

---

## Functions Without Return Values

Functions that don't return a value (or return None) are useful for:
- Printing output
- Modifying global variables
- Performing actions (side effects)

```python
# Function that prints (no return value)
def display_menu():
    print("1. Option 1")
    print("2. Option 2")
    print("3. Option 3")

display_menu()

# Function that modifies global state
counter = 0

def increment_counter():
    global counter
    counter += 1
    print(f"Counter: {counter}")

increment_counter()  # Output: Counter: 1
increment_counter()  # Output: Counter: 2
```

---

## Function Scope (Basics)

**Scope** determines where variables can be accessed.

### Local Variables

Variables defined inside a function are **local** to that function:

```python
def my_function():
    local_var = "I'm local"
    print(local_var)

my_function()  # Output: I'm local
# print(local_var)  # NameError: name 'local_var' is not defined
```

### Global Variables

Variables defined outside functions are **global**:

```python
global_var = "I'm global"

def my_function():
    print(global_var)  # Can access global variable

my_function()  # Output: I'm global
print(global_var)  # Also accessible here
```

### Modifying Global Variables

To modify a global variable inside a function, use the `global` keyword:

```python
count = 0

def increment():
    global count  # Declare we're using global variable
    count += 1

increment()
print(count)  # Output: 1

# Without global keyword
def try_increment():
    count = count + 1  # Error! Can't modify without global

# try_increment()  # UnboundLocalError
```

**Note**: We'll cover scope in more detail in a later lesson.

---

## Docstrings

**Docstrings** document what a function does. They're placed immediately after the function definition.

### Basic Docstring

```python
def calculate_area(length, width):
    """Calculate the area of a rectangle.
    
    Args:
        length (float): The length of the rectangle
        width (float): The width of the rectangle
    
    Returns:
        float: The area of the rectangle
    """
    return length * width
```

### Accessing Docstrings

```python
def greet(name):
    """Greet a person by name."""
    print(f"Hello, {name}!")

# Access docstring
print(greet.__doc__)  # Output: Greet a person by name.

# Or use help()
help(greet)
```

### Docstring Styles

```python
# Simple one-line docstring
def add(a, b):
    """Add two numbers."""
    return a + b

# Multi-line docstring
def process_data(data):
    """Process the given data.
    
    This function takes data and processes it
    according to the specified rules.
    """
    # Process data...
    pass
```

---

## Practical Examples

### Example 1: Calculator Functions

```python
def add(a, b):
    """Add two numbers."""
    return a + b

def subtract(a, b):
    """Subtract b from a."""
    return a - b

def multiply(a, b):
    """Multiply two numbers."""
    return a * b

def divide(a, b):
    """Divide a by b."""
    if b == 0:
        return "Error: Division by zero"
    return a / b

# Use the functions
print(add(10, 5))        # Output: 15
print(subtract(10, 5))   # Output: 5
print(multiply(10, 5))   # Output: 50
print(divide(10, 5))     # Output: 2.0
print(divide(10, 0))     # Output: Error: Division by zero
```

### Example 2: String Processing

```python
def capitalize_words(text):
    """Capitalize the first letter of each word."""
    return text.title()

def reverse_string(text):
    """Reverse a string."""
    return text[::-1]

def count_words(text):
    """Count the number of words in a string."""
    return len(text.split())

# Use the functions
text = "hello world python"
print(capitalize_words(text))  # Output: Hello World Python
print(reverse_string(text))    # Output: nohtyp dlrow olleh
print(count_words(text))       # Output: 3
```

### Example 3: Data Processing

```python
def calculate_average(numbers):
    """Calculate the average of a list of numbers."""
    if not numbers:
        return 0
    return sum(numbers) / len(numbers)

def find_max_min(numbers):
    """Find the maximum and minimum values."""
    if not numbers:
        return None, None
    return max(numbers), min(numbers)

# Use the functions
scores = [85, 92, 78, 96, 88]
avg = calculate_average(scores)
print(f"Average: {avg:.2f}")  # Output: Average: 87.80

maximum, minimum = find_max_min(scores)
print(f"Max: {maximum}, Min: {minimum}")  # Output: Max: 96, Min: 78
```

### Example 4: Validation Functions

```python
def is_valid_email(email):
    """Check if email format is valid (simple check)."""
    return "@" in email and "." in email

def is_valid_age(age):
    """Check if age is in valid range."""
    return 0 <= age <= 120

def validate_password(password):
    """Check if password meets requirements."""
    if len(password) < 8:
        return False, "Password must be at least 8 characters"
    if not any(c.isupper() for c in password):
        return False, "Password must contain uppercase letter"
    if not any(c.isdigit() for c in password):
        return False, "Password must contain a digit"
    return True, "Password is valid"

# Use the functions
print(is_valid_email("user@example.com"))  # Output: True
print(is_valid_age(25))                     # Output: True
print(is_valid_age(150))                   # Output: False

is_valid, message = validate_password("Secret123")
print(f"{message}: {is_valid}")  # Output: Password is valid: True
```

---

## Common Patterns

### Pattern 1: Pure Functions

Functions that don't modify external state and always return the same output for the same input:

```python
def square(x):
    """Pure function - no side effects."""
    return x ** 2

result1 = square(5)
result2 = square(5)
# result1 == result2 always True
```

### Pattern 2: Helper Functions

Small functions that help with specific tasks:

```python
def is_even(number):
    """Helper function to check if number is even."""
    return number % 2 == 0

def filter_evens(numbers):
    """Filter even numbers using helper function."""
    return [n for n in numbers if is_even(n)]

numbers = [1, 2, 3, 4, 5, 6]
evens = filter_evens(numbers)
print(evens)  # Output: [2, 4, 6]
```

### Pattern 3: Function Composition

Using the output of one function as input to another:

```python
def add_one(x):
    return x + 1

def multiply_by_two(x):
    return x * 2

# Compose functions
result = multiply_by_two(add_one(5))
print(result)  # Output: 12 (5+1=6, 6*2=12)
```

---

## Common Mistakes and Pitfalls

### 1. Forgetting Colon

```python
# Wrong
# def greet()
#     print("Hello")

# Correct
def greet():
    print("Hello")
```

### 2. Incorrect Indentation

```python
# Wrong
# def greet():
# print("Hello")  # IndentationError!

# Correct
def greet():
    print("Hello")
```

### 3. Forgetting to Call the Function

```python
def greet():
    print("Hello")

# Wrong: just referencing the function
greet  # Does nothing!

# Correct: call the function
greet()  # Executes the function
```

### 4. Wrong Number of Arguments

```python
def greet(name, age):
    print(f"{name} is {age} years old")

# Wrong: missing argument
# greet("Alice")  # TypeError: missing 1 required argument

# Wrong: too many arguments
# greet("Alice", 25, "NYC")  # TypeError: too many arguments

# Correct
greet("Alice", 25)
```

### 5. Confusing Return and Print

```python
# Function that prints (no return value)
def add_print(a, b):
    print(a + b)  # Prints but doesn't return

result = add_print(5, 3)  # Prints: 8
print(result)  # Output: None (no return value)

# Function that returns (no print)
def add_return(a, b):
    return a + b  # Returns but doesn't print

result = add_return(5, 3)  # Doesn't print anything
print(result)  # Output: 8
```

---

## Best Practices

### 1. Use Descriptive Names

```python
# Good
def calculate_rectangle_area(length, width):
    return length * width

# Bad
def calc(l, w):
    return l * w
```

### 2. Keep Functions Focused

```python
# Good: single responsibility
def calculate_area(length, width):
    return length * width

def calculate_perimeter(length, width):
    return 2 * (length + width)

# Bad: does too much
def calculate_rectangle(length, width):
    area = length * width
    perimeter = 2 * (length + width)
    volume = length * width * height  # height not defined!
    return area, perimeter, volume
```

### 3. Use Docstrings

```python
# Good
def process_data(data):
    """Process the given data and return results."""
    # Implementation
    pass

# Less clear
def process_data(data):
    # Process the given data and return results
    pass
```

### 4. Return Values, Don't Print (Usually)

```python
# Good: returns value (flexible)
def calculate_total(prices):
    return sum(prices)

total = calculate_total([10, 20, 30])
print(f"Total: ${total}")

# Less flexible: always prints
def calculate_total(prices):
    total = sum(prices)
    print(f"Total: ${total}")  # Can't use value elsewhere
```

---

## Practice Exercise

### Exercise: Function Basics Practice

**Objective**: Create a Python program that demonstrates function definition, calling, parameters, and return values.

**Instructions**:

1. Create a file called `function_basics_practice.py`

2. Write a program that:
   - Defines functions with and without parameters
   - Uses return statements
   - Calls functions with arguments
   - Demonstrates function composition
   - Implements practical function-based solutions

3. Your program should include:
   - Calculator functions
   - String processing functions
   - Data processing functions
   - Validation functions
   - Helper functions

**Example Solution**:

```python
"""
Function Basics Practice
This program demonstrates function definition, calling, and usage.
"""

print("=" * 60)
print("FUNCTION BASICS PRACTICE")
print("=" * 60)
print()

# 1. Simple Function
print("1. SIMPLE FUNCTION")
print("-" * 60)
def greet():
    print("Hello, World!")

greet()
print()

# 2. Function with Parameters
print("2. FUNCTION WITH PARAMETERS")
print("-" * 60)
def greet_person(name):
    print(f"Hello, {name}!")

greet_person("Alice")
greet_person("Bob")
print()

# 3. Function with Return Value
print("3. FUNCTION WITH RETURN VALUE")
print("-" * 60)
def add(a, b):
    return a + b

result = add(5, 3)
print(f"add(5, 3) = {result}")

# Use in expression
total = add(10, 20) + add(5, 5)
print(f"add(10, 20) + add(5, 5) = {total}")
print()

# 4. Multiple Parameters
print("4. MULTIPLE PARAMETERS")
print("-" * 60)
def calculate_area(length, width):
    return length * width

area = calculate_area(5, 3)
print(f"Area of rectangle (5 x 3): {area}")

def introduce(name, age, city):
    print(f"{name} is {age} years old and lives in {city}")

introduce("Alice", 25, "NYC")
print()

# 5. Multiple Return Values
print("5. MULTIPLE RETURN VALUES")
print("-" * 60)
def get_name_age():
    return "Alice", 25

name, age = get_name_age()
print(f"Name: {name}, Age: {age}")

def calculate_stats(numbers):
    if not numbers:
        return 0, 0, 0
    total = sum(numbers)
    count = len(numbers)
    average = total / count
    return total, count, average

scores = [85, 92, 78, 96, 88]
total, count, avg = calculate_stats(scores)
print(f"Scores: {scores}")
print(f"Total: {total}, Count: {count}, Average: {avg:.2f}")
print()

# 6. Calculator Functions
print("6. CALCULATOR FUNCTIONS")
print("-" * 60)
def add(a, b):
    return a + b

def subtract(a, b):
    return a - b

def multiply(a, b):
    return a * b

def divide(a, b):
    if b == 0:
        return "Error: Division by zero"
    return a / b

a, b = 10, 5
print(f"{a} + {b} = {add(a, b)}")
print(f"{a} - {b} = {subtract(a, b)}")
print(f"{a} * {b} = {multiply(a, b)}")
print(f"{a} / {b} = {divide(a, b)}")
print(f"{a} / 0 = {divide(a, 0)}")
print()

# 7. String Processing Functions
print("7. STRING PROCESSING FUNCTIONS")
print("-" * 60)
def capitalize_words(text):
    """Capitalize the first letter of each word."""
    return text.title()

def reverse_string(text):
    """Reverse a string."""
    return text[::-1]

def count_words(text):
    """Count the number of words."""
    return len(text.split())

text = "hello world python"
print(f"Original: '{text}'")
print(f"Capitalized: '{capitalize_words(text)}'")
print(f"Reversed: '{reverse_string(text)}'")
print(f"Word count: {count_words(text)}")
print()

# 8. Data Processing Functions
print("8. DATA PROCESSING FUNCTIONS")
print("-" * 60)
def calculate_average(numbers):
    """Calculate average of numbers."""
    if not numbers:
        return 0
    return sum(numbers) / len(numbers)

def find_max_min(numbers):
    """Find maximum and minimum."""
    if not numbers:
        return None, None
    return max(numbers), min(numbers)

numbers = [3, 1, 4, 1, 5, 9, 2, 6]
print(f"Numbers: {numbers}")
print(f"Average: {calculate_average(numbers):.2f}")
maximum, minimum = find_max_min(numbers)
print(f"Maximum: {maximum}, Minimum: {minimum}")
print()

# 9. Validation Functions
print("9. VALIDATION FUNCTIONS")
print("-" * 60)
def is_valid_email(email):
    """Simple email validation."""
    return "@" in email and "." in email

def is_valid_age(age):
    """Check if age is valid."""
    return 0 <= age <= 120

def validate_password(password):
    """Validate password strength."""
    if len(password) < 8:
        return False, "Password must be at least 8 characters"
    if not any(c.isupper() for c in password):
        return False, "Password must contain uppercase"
    if not any(c.isdigit() for c in password):
        return False, "Password must contain a digit"
    return True, "Password is valid"

# Test validations
print(f"Email 'user@example.com' valid: {is_valid_email('user@example.com')}")
print(f"Email 'invalid' valid: {is_valid_email('invalid')}")
print(f"Age 25 valid: {is_valid_age(25)}")
print(f"Age 150 valid: {is_valid_age(150)}")

is_valid, message = validate_password("Secret123")
print(f"Password 'Secret123': {message} ({is_valid})")

is_valid, message = validate_password("weak")
print(f"Password 'weak': {message} ({is_valid})")
print()

# 10. Helper Functions
print("10. HELPER FUNCTIONS")
print("-" * 60)
def is_even(number):
    """Check if number is even."""
    return number % 2 == 0

def is_positive(number):
    """Check if number is positive."""
    return number > 0

def filter_numbers(numbers, condition):
    """Filter numbers based on condition function."""
    return [n for n in numbers if condition(n)]

numbers = [-2, -1, 0, 1, 2, 3, 4, 5]
print(f"Numbers: {numbers}")
evens = filter_numbers(numbers, is_even)
positives = filter_numbers(numbers, is_positive)
print(f"Even numbers: {evens}")
print(f"Positive numbers: {positives}")
print()

# 11. Function Composition
print("11. FUNCTION COMPOSITION")
print("-" * 60)
def add_one(x):
    return x + 1

def multiply_by_two(x):
    return x * 2

def square(x):
    return x ** 2

# Compose functions
x = 5
result1 = multiply_by_two(add_one(x))
print(f"multiply_by_two(add_one({x})) = {result1}")

result2 = square(multiply_by_two(x))
print(f"square(multiply_by_two({x})) = {result2}")
print()

# 12. Functions with Docstrings
print("12. FUNCTIONS WITH DOCSTRINGS")
print("-" * 60)
def calculate_rectangle_area(length, width):
    """Calculate the area of a rectangle.
    
    Args:
        length (float): The length of the rectangle
        width (float): The width of the rectangle
    
    Returns:
        float: The area of the rectangle
    """
    return length * width

# Access docstring
print("Docstring:")
print(calculate_rectangle_area.__doc__)
print()

# 13. Early Return
print("13. EARLY RETURN")
print("-" * 60)
def check_age_category(age):
    """Categorize age with early returns."""
    if age < 0:
        return "Invalid age"
    if age < 18:
        return "Minor"
    if age < 65:
        return "Adult"
    return "Senior"

ages = [-5, 15, 25, 70]
for age in ages:
    category = check_age_category(age)
    print(f"Age {age}: {category}")
print()

# 14. Functions Without Return
print("14. FUNCTIONS WITHOUT RETURN")
print("-" * 60)
def display_menu():
    """Display a menu (no return value)."""
    print("Menu:")
    print("  1. Option 1")
    print("  2. Option 2")
    print("  3. Option 3")

result = display_menu()
print(f"Function return value: {result}")  # None
print()

# 15. Practical Example: Grade Calculator
print("15. PRACTICAL EXAMPLE: GRADE CALCULATOR")
print("-" * 60)
def calculate_grade(score):
    """Calculate letter grade from score."""
    if score >= 90:
        return "A"
    elif score >= 80:
        return "B"
    elif score >= 70:
        return "C"
    elif score >= 60:
        return "D"
    else:
        return "F"

def process_student_scores(students, scores):
    """Process student scores and return report."""
    results = []
    for student, score in zip(students, scores):
        grade = calculate_grade(score)
        results.append((student, score, grade))
    return results

students = ["Alice", "Bob", "Charlie", "Diana"]
scores = [95, 85, 75, 65]

report = process_student_scores(students, scores)
print("Student Grade Report:")
for student, score, grade in report:
    print(f"  {student}: {score} → {grade}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
FUNCTION BASICS PRACTICE
============================================================

1. SIMPLE FUNCTION
------------------------------------------------------------
Hello, World!

2. FUNCTION WITH PARAMETERS
------------------------------------------------------------
Hello, Alice!
Hello, Bob!

[... rest of output ...]
```

**Challenge** (Optional):
- Create a complete utility library with multiple functions
- Build a data processing pipeline using function composition
- Implement a validation framework
- Create a calculator with multiple operations
- Build a text processing toolkit

---

## Key Takeaways

1. **Functions are reusable code blocks** that perform specific tasks
2. **Define functions with `def`** followed by function name and parameters
3. **Call functions** using function name followed by parentheses
4. **Parameters** are variables in the function definition
5. **Arguments** are values passed when calling the function
6. **Return statements** send values back to the caller
7. **Functions can return multiple values** (as tuples)
8. **Functions can have no parameters** or no return value
9. **Use docstrings** to document what functions do
10. **Functions improve code organization** and reusability

---

## Quiz: Function Basics

Test your understanding with these questions:

1. **What keyword is used to define a function?**
   - A) `function`
   - B) `def`
   - C) `func`
   - D) `define`

2. **What is the difference between a parameter and an argument?**
   - A) No difference
   - B) Parameter is in definition, argument is when calling
   - C) Argument is in definition, parameter is when calling
   - D) Both are the same thing

3. **What does a function return if there's no return statement?**
   - A) `0`
   - B) `""`
   - C) `None`
   - D) Error

4. **How do you call a function named `greet`?**
   - A) `greet`
   - B) `greet()`
   - C) `call greet()`
   - D) `greet[]`

5. **Can a function return multiple values?**
   - A) No
   - B) Yes, as a tuple
   - C) Yes, as a list
   - D) Only two values

6. **What is a docstring?**
   - A) A comment
   - B) Documentation string for a function
   - C) A variable name
   - D) A return value

7. **What happens if you call a function with wrong number of arguments?**
   - A) Nothing
   - B) `TypeError`
   - C) `ValueError`
   - D) `NameError`

8. **What is the output of: `def add(x, y): return x + y; print(add(2, 3))`?**
   - A) `5`
   - B) `x + y`
   - C) `None`
   - D) Error

9. **What keyword is used to modify global variables inside a function?**
   - A) `global`
   - B) `nonlocal`
   - C) `local`
   - D) `var`

10. **What is the purpose of the `return` statement?**
    - A) Print a value
    - B) Send a value back to the caller
    - C) Exit the program
    - D) Define a variable

**Answers**:
1. B) `def` (define function)
2. B) Parameter is in definition, argument is when calling
3. C) `None` (functions return None if no return statement)
4. B) `greet()` (function name followed by parentheses)
5. B) Yes, as a tuple (can unpack multiple values)
6. B) Documentation string for a function (describes what function does)
7. B) `TypeError` (wrong number of arguments causes TypeError)
8. A) `5` (function returns 2 + 3 = 5)
9. A) `global` (declare global variable access)
10. B) Send a value back to the caller (return exits function and sends value)

---

## Next Steps

Excellent work! You've mastered function basics. You now understand:
- How to define and call functions
- Function parameters and arguments
- Return statements and values
- Function scope basics
- Docstrings and documentation
- Practical function patterns

**What's Next?**
- Lesson 6.2: Function Arguments (default parameters, *args, **kwargs)
- Practice building reusable function libraries
- Learn about advanced function features
- Explore function design patterns

---

## Additional Resources

- **Python Functions**: [docs.python.org/3/tutorial/controlflow.html#defining-functions](https://docs.python.org/3/tutorial/controlflow.html#defining-functions)
- **Function Definitions**: [docs.python.org/3/reference/compound_stmts.html#function-definitions](https://docs.python.org/3/reference/compound_stmts.html#function-definitions)
- **PEP 8 Function Naming**: [pep8.org](https://pep8.org/) (style guide for functions)

---

*Lesson completed! You're ready to move on to the next lesson.*

