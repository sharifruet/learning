# Lesson 6.3: Scope and Namespaces

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the concept of scope in Python
- Distinguish between local and global scope
- Use the `global` keyword correctly
- Understand the `nonlocal` keyword
- Understand Python's namespace concept
- Recognize scope resolution order (LEGB rule)
- Apply scope knowledge to write correct code
- Avoid common scope-related errors
- Understand how scope affects variable access

---

## Introduction to Scope

**Scope** determines where in your code a variable can be accessed. Understanding scope is crucial for writing correct Python programs and avoiding bugs related to variable access.

### What is Scope?

Scope defines the **visibility** and **lifetime** of variables:
- **Visibility**: Where a variable can be accessed
- **Lifetime**: How long a variable exists

Python has different levels of scope, and variables are accessible based on where they're defined.

---

## Types of Scope

Python has four main levels of scope (from narrowest to broadest):

1. **Local (L)** - Inside the current function
2. **Enclosing (E)** - In enclosing functions (for nested functions)
3. **Global (G)** - At the module level
4. **Built-in (B)** - Built-in Python names

This is known as the **LEGB rule** (Local, Enclosing, Global, Built-in).

---

## Local Scope

**Local scope** refers to variables defined inside a function. These variables are only accessible within that function.

### Basic Local Scope

```python
def my_function():
    local_var = "I'm local"
    print(local_var)

my_function()  # Output: I'm local
# print(local_var)  # NameError: name 'local_var' is not defined
```

### Local Variables Are Independent

```python
def function1():
    x = 10
    print(f"function1: x = {x}")

def function2():
    x = 20  # Different variable, same name
    print(f"function2: x = {x}")

function1()  # Output: function1: x = 10
function2()  # Output: function2: x = 20

# Each function has its own 'x'
```

### Parameters Are Local

```python
def greet(name):  # 'name' is a local variable
    print(f"Hello, {name}")

greet("Alice")  # Output: Hello, Alice
# print(name)  # NameError: name 'name' is not defined
```

### Local Scope Examples

```python
def calculate_area(length, width):
    # 'length', 'width', and 'area' are all local
    area = length * width
    return area

result = calculate_area(5, 3)
print(result)  # Output: 15
# print(area)  # NameError: 'area' is not defined
```

---

## Global Scope

**Global scope** refers to variables defined at the module level (outside any function). These variables are accessible throughout the module.

### Basic Global Scope

```python
# Global variable
global_var = "I'm global"

def my_function():
    # Can access global variable
    print(global_var)

my_function()  # Output: I'm global
print(global_var)  # Also accessible here
```

### Reading Global Variables

You can **read** global variables without any special keyword:

```python
global_count = 0

def show_count():
    print(f"Count is: {global_count}")  # Can read global

show_count()  # Output: Count is: 0
```

### Modifying Global Variables

To **modify** a global variable inside a function, use the `global` keyword:

```python
count = 0

def increment():
    global count  # Declare we're using global variable
    count += 1
    print(f"Count: {count}")

increment()  # Output: Count: 1
increment()  # Output: Count: 2
print(count)  # Output: 2
```

### Without `global` Keyword

```python
count = 0

def try_increment():
    # Without 'global', Python thinks this is a new local variable
    count = count + 1  # UnboundLocalError!

# try_increment()  # UnboundLocalError: local variable 'count' referenced before assignment
```

### Global Scope Examples

```python
# Global variables
PI = 3.14159
APP_NAME = "My Application"

def calculate_circle_area(radius):
    # Can read global PI
    return PI * radius ** 2

def get_app_info():
    # Can read global APP_NAME
    return f"Welcome to {APP_NAME}"

area = calculate_circle_area(5)
print(area)  # Output: 78.53975

info = get_app_info()
print(info)  # Output: Welcome to My Application
```

---

## The `global` Keyword

The `global` keyword declares that you want to use a global variable inside a function.

### Basic Usage

```python
x = 10  # Global variable

def modify_global():
    global x  # Declare we're modifying global x
    x = 20    # Modify global variable
    print(f"Inside function: x = {x}")

print(f"Before: x = {x}")  # Output: Before: x = 10
modify_global()            # Output: Inside function: x = 20
print(f"After: x = {x}")   # Output: After: x = 20
```

### Creating Global Variables

You can also **create** global variables from inside a function:

```python
def create_global():
    global new_global
    new_global = "I was created in a function"
    print(new_global)

create_global()
print(new_global)  # Output: I was created in a function
```

### Multiple Global Variables

```python
x = 1
y = 2
z = 3

def modify_globals():
    global x, y, z  # Declare multiple globals
    x = 10
    y = 20
    z = 30

print(f"Before: x={x}, y={y}, z={z}")  # Output: Before: x=1, y=2, z=3
modify_globals()
print(f"After: x={x}, y={y}, z={z}")   # Output: After: x=10, y=20, z=30
```

### When to Use `global`

**Use `global` when**:
- You need to modify a global variable
- You want to create a global variable from inside a function

**Avoid `global` when**:
- You only need to read the global variable (not required)
- You can pass values as parameters and return results instead

**Best Practice**: Prefer passing parameters and returning values over using global variables.

```python
# Less ideal: using global
counter = 0

def increment_global():
    global counter
    counter += 1

# Better: pass and return
def increment(value):
    return value + 1

counter = 0
counter = increment(counter)
```

---

## The `nonlocal` Keyword

The `nonlocal` keyword is used in nested functions to access variables from the enclosing (non-global) scope.

### Basic nonlocal Usage

```python
def outer_function():
    x = "outer"  # Enclosing scope variable
    
    def inner_function():
        nonlocal x  # Access enclosing scope variable
        x = "inner"  # Modify enclosing scope variable
        print(f"Inside inner: x = {x}")
    
    print(f"Before inner: x = {x}")  # Output: Before inner: x = outer
    inner_function()                  # Output: Inside inner: x = inner
    print(f"After inner: x = {x}")   # Output: After inner: x = inner

outer_function()
```

### nonlocal vs global

```python
# Global variable
global_var = "global"

def outer():
    # Enclosing variable
    enclosing_var = "enclosing"
    
    def inner():
        # Can access global (read only, or use 'global' to modify)
        print(f"Global: {global_var}")
        
        # Use 'nonlocal' to modify enclosing variable
        nonlocal enclosing_var
        enclosing_var = "modified"
        print(f"Enclosing: {enclosing_var}")
    
    print(f"Before inner: {enclosing_var}")  # Output: Before inner: enclosing
    inner()                                   # Output: Global: global
                                              #         Enclosing: modified
    print(f"After inner: {enclosing_var}")   # Output: After inner: modified

outer()
```

### Practical nonlocal Example

```python
def counter():
    count = 0  # Enclosing scope
    
    def increment():
        nonlocal count
        count += 1
        return count
    
    return increment

# Create counter function
my_counter = counter()
print(my_counter())  # Output: 1
print(my_counter())  # Output: 2
print(my_counter())  # Output: 3

# Each counter is independent
another_counter = counter()
print(another_counter())  # Output: 1 (new counter)
```

---

## Scope Resolution: LEGB Rule

Python follows the **LEGB rule** when looking up variable names:

1. **Local (L)** - Look in local scope first
2. **Enclosing (E)** - Look in enclosing functions
3. **Global (G)** - Look in global scope
4. **Built-in (B)** - Look in built-in names

### LEGB Examples

```python
# Built-in
print("Hello")  # 'print' is built-in

# Global
x = "global"

def outer():
    # Enclosing
    x = "enclosing"
    
    def inner():
        # Local
        x = "local"
        print(x)  # Output: local (found in local scope)
    
    inner()
    print(x)  # Output: enclosing (found in enclosing scope)

outer()
print(x)  # Output: global (found in global scope)
```

### Scope Lookup Order

```python
def example():
    # Python looks for 'len' in this order:
    # 1. Local scope (not found)
    # 2. Enclosing scope (not found)
    # 3. Global scope (not found)
    # 4. Built-in scope (found!)
    result = len([1, 2, 3])  # Uses built-in len()
    return result

print(example())  # Output: 3
```

### Shadowing Variables

When a local variable has the same name as a global variable, it **shadows** (hides) the global:

```python
x = "global"

def my_function():
    x = "local"  # Shadows global x
    print(x)     # Output: local

my_function()
print(x)  # Output: global (global x unchanged)
```

---

## Nested Functions and Scope

Nested functions can access variables from enclosing functions.

### Basic Nested Function Scope

```python
def outer():
    outer_var = "outer"
    
    def inner():
        # Can access outer_var (read)
        print(f"Accessing: {outer_var}")
    
    inner()

outer()  # Output: Accessing: outer
```

### Modifying Enclosing Variables

```python
def outer():
    count = 0
    
    def inner():
        nonlocal count  # Required to modify
        count += 1
        print(f"Count: {count}")
    
    inner()  # Output: Count: 1
    inner()  # Output: Count: 2
    print(f"Final count: {count}")  # Output: Final count: 2

outer()
```

### Multiple Levels of Nesting

```python
def level1():
    var1 = "level1"
    
    def level2():
        var2 = "level2"
        
        def level3():
            # Can access var1 and var2
            nonlocal var1, var2
            var1 = "modified1"
            var2 = "modified2"
            print(f"Level3: {var1}, {var2}")
        
        level3()
        print(f"Level2: {var1}, {var2}")
    
    level2()
    print(f"Level1: {var1}")

level1()
```

---

## Common Scope Patterns

### Pattern 1: Counter with Closure

```python
def create_counter():
    count = 0  # Enclosing scope
    
    def counter():
        nonlocal count
        count += 1
        return count
    
    return counter

# Create independent counters
counter1 = create_counter()
counter2 = create_counter()

print(counter1())  # Output: 1
print(counter1())  # Output: 2
print(counter2())  # Output: 1 (independent)
print(counter1())  # Output: 3
```

### Pattern 2: Configuration Access

```python
# Global configuration
CONFIG = {
    "debug": True,
    "timeout": 30
}

def get_config(key):
    """Access global config."""
    return CONFIG.get(key)

def set_config(key, value):
    """Modify global config."""
    global CONFIG
    CONFIG[key] = value

print(get_config("debug"))    # Output: True
set_config("timeout", 60)
print(get_config("timeout"))  # Output: 60
```

### Pattern 3: Accumulator Function

```python
def create_accumulator(initial=0):
    total = initial  # Enclosing scope
    
    def add(value):
        nonlocal total
        total += value
        return total
    
    return add

acc = create_accumulator(10)
print(acc(5))   # Output: 15
print(acc(3))   # Output: 18
print(acc(7))   # Output: 25
```

---

## Common Mistakes and Pitfalls

### 1. Modifying Global Without `global` Keyword

```python
count = 0

def increment():
    # count = count + 1  # UnboundLocalError!
    # Python thinks 'count' is local because of assignment

# Correct
def increment():
    global count
    count += 1
```

### 2. Confusing Local and Global Variables

```python
x = 10  # Global

def my_function():
    x = 20  # Local (shadows global)
    print(x)  # Output: 20

my_function()
print(x)  # Output: 10 (global unchanged)
```

### 3. Forgetting `nonlocal` in Nested Functions

```python
def outer():
    x = 10
    
    def inner():
        # x = 20  # Creates new local x, doesn't modify outer x!
        nonlocal x
        x = 20  # Correct: modifies outer x
    
    inner()
    print(x)  # Output: 20

outer()
```

### 4. Trying to Access Local Before Assignment

```python
def my_function():
    print(x)  # NameError if x is assigned later in function
    x = 10

# my_function()  # UnboundLocalError

# Correct: assign before use, or use global
def my_function():
    x = 10
    print(x)
```

### 5. Mutable Objects and Scope

```python
# Lists and dictionaries are mutable
my_list = [1, 2, 3]  # Global

def modify_list():
    # Can modify without 'global' (modifying object, not reassigning)
    my_list.append(4)
    print(my_list)  # Output: [1, 2, 3, 4]

modify_list()

# But reassignment requires 'global'
def reassign_list():
    global my_list
    my_list = [5, 6, 7]  # Reassignment requires global

reassign_list()
print(my_list)  # Output: [5, 6, 7]
```

---

## Best Practices

### 1. Minimize Global Variables

```python
# Less ideal: many globals
counter = 0
total = 0
average = 0

def process():
    global counter, total, average
    # Complex logic...

# Better: encapsulate in class or pass parameters
def process(counter, total):
    # Process with parameters
    new_total = total + 1
    new_counter = counter + 1
    return new_counter, new_total
```

### 2. Use Parameters and Return Values

```python
# Less ideal: global state
result = None

def calculate(x, y):
    global result
    result = x + y

# Better: return value
def calculate(x, y):
    return x + y

result = calculate(5, 3)
```

### 3. Clear Variable Names

```python
# Good: clear names help understand scope
def process_user_data(user_name, user_age):
    local_result = user_name.upper()
    return local_result

# Less clear
def process(a, b):
    x = a.upper()
    return x
```

### 4. Document Scope Intentions

```python
# Good: document when using global
GLOBAL_COUNTER = 0

def increment_counter():
    """Increment the global counter.
    
    Note: Modifies global variable GLOBAL_COUNTER.
    """
    global GLOBAL_COUNTER
    GLOBAL_COUNTER += 1
```

---

## Practice Exercise

### Exercise: Scope and Namespaces Practice

**Objective**: Create a Python program that demonstrates scope concepts, global/local variables, and namespace usage.

**Instructions**:

1. Create a file called `scope_practice.py`

2. Write a program that:
   - Demonstrates local and global scope
   - Uses the `global` keyword
   - Uses the `nonlocal` keyword
   - Shows nested function scope
   - Implements practical scope-based solutions

3. Your program should include:
   - Local variable examples
   - Global variable examples
   - Nested function examples
   - Closure examples
   - Scope resolution examples

**Example Solution**:

```python
"""
Scope and Namespaces Practice
This program demonstrates scope concepts and namespace usage.
"""

print("=" * 60)
print("SCOPE AND NAMESPACES PRACTICE")
print("=" * 60)
print()

# 1. Local Scope
print("1. LOCAL SCOPE")
print("-" * 60)
def my_function():
    local_var = "I'm local"
    print(f"  Inside function: {local_var}")

my_function()
# print(local_var)  # NameError if uncommented
print()

# 2. Global Scope
print("2. GLOBAL SCOPE")
print("-" * 60)
global_var = "I'm global"

def read_global():
    # Can read global without 'global' keyword
    print(f"  Reading global: {global_var}")

read_global()
print(f"  Outside function: {global_var}")
print()

# 3. Modifying Global Variables
print("3. MODIFYING GLOBAL VARIABLES")
print("-" * 60)
count = 0

def increment():
    global count
    count += 1
    print(f"  Count: {count}")

print(f"  Before: count = {count}")
increment()
increment()
print(f"  After: count = {count}")
print()

# 4. Local vs Global (Shadowing)
print("4. LOCAL vs GLOBAL (SHADOWING)")
print("-" * 60)
x = "global"

def my_function():
    x = "local"  # Shadows global x
    print(f"  Inside function: x = '{x}'")

my_function()
print(f"  Outside function: x = '{x}'")
print()

# 5. Reading vs Modifying
print("5. READING vs MODIFYING")
print("-" * 60)
value = 10

def read_only():
    # Can read without 'global'
    print(f"  Reading: {value}")

def modify():
    global value
    value = 20
    print(f"  Modified to: {value}")

read_only()
modify()
read_only()
print()

# 6. Nested Functions - Reading Enclosing
print("6. NESTED FUNCTIONS - READING ENCLOSING")
print("-" * 60)
def outer():
    outer_var = "outer variable"
    
    def inner():
        # Can read enclosing variable
        print(f"  Inner accessing: {outer_var}")
    
    inner()

outer()
print()

# 7. Nested Functions - Modifying Enclosing (nonlocal)
print("7. NESTED FUNCTIONS - MODIFYING ENCLOSING")
print("-" * 60)
def outer():
    count = 0
    
    def inner():
        nonlocal count
        count += 1
        print(f"  Inner count: {count}")
    
    print(f"  Before inner: count = {count}")
    inner()
    inner()
    print(f"  After inner: count = {count}")

outer()
print()

# 8. Closure Example
print("8. CLOSURE EXAMPLE")
print("-" * 60)
def create_counter():
    count = 0  # Enclosing scope
    
    def counter():
        nonlocal count
        count += 1
        return count
    
    return counter

counter1 = create_counter()
counter2 = create_counter()

print(f"  Counter1: {counter1()}")
print(f"  Counter1: {counter1()}")
print(f"  Counter2: {counter2()}")
print(f"  Counter1: {counter1()}")
print()

# 9. LEGB Rule Demonstration
print("9. LEGB RULE DEMONSTRATION")
print("-" * 60)
# Built-in
print(f"  Built-in 'len': {len([1, 2, 3])}")

# Global
x = "global"

def outer():
    # Enclosing
    x = "enclosing"
    
    def inner():
        # Local
        x = "local"
        print(f"    Local scope: x = '{x}'")
    
    print(f"  Enclosing scope: x = '{x}'")
    inner()
    print(f"  Enclosing scope: x = '{x}'")

print(f"  Global scope: x = '{x}'")
outer()
print(f"  Global scope: x = '{x}'")
print()

# 10. Multiple Levels of Nesting
print("10. MULTIPLE LEVELS OF NESTING")
print("-" * 60)
def level1():
    var1 = "level1"
    
    def level2():
        var2 = "level2"
        
        def level3():
            nonlocal var1, var2
            var1 = "modified1"
            var2 = "modified2"
            print(f"    Level3: var1='{var1}', var2='{var2}'")
        
        print(f"  Level2 before: var1='{var1}', var2='{var2}'")
        level3()
        print(f"  Level2 after: var1='{var1}', var2='{var2}'")
    
    print(f"Level1 before: var1='{var1}'")
    level2()
    print(f"Level1 after: var1='{var1}'")

level1()
print()

# 11. Accumulator Function
print("11. ACCUMULATOR FUNCTION")
print("-" * 60)
def create_accumulator(initial=0):
    total = initial
    
    def add(value):
        nonlocal total
        total += value
        return total
    
    return add

acc = create_accumulator(10)
print(f"  Start: 10")
print(f"  Add 5: {acc(5)}")
print(f"  Add 3: {acc(3)}")
print(f"  Add 7: {acc(7)}")
print()

# 12. Configuration Pattern
print("12. CONFIGURATION PATTERN")
print("-" * 60)
CONFIG = {
    "debug": True,
    "timeout": 30
}

def get_config(key):
    return CONFIG.get(key)

def set_config(key, value):
    global CONFIG
    CONFIG[key] = value

print(f"  Initial config: {CONFIG}")
print(f"  Get 'debug': {get_config('debug')}")
set_config("timeout", 60)
print(f"  After set_config: {CONFIG}")
print()

# 13. Mutable Objects and Scope
print("13. MUTABLE OBJECTS AND SCOPE")
print("-" * 60)
my_list = [1, 2, 3]

def modify_list():
    # Can modify list without 'global' (modifying object)
    my_list.append(4)
    print(f"  Modified list: {my_list}")

def reassign_list():
    global my_list
    my_list = [5, 6, 7]  # Reassignment requires 'global'
    print(f"  Reassigned list: {my_list}")

print(f"  Original: {my_list}")
modify_list()
print(f"  After modify: {my_list}")
reassign_list()
print(f"  After reassign: {my_list}")
print()

# 14. Independent Function Scopes
print("14. INDEPENDENT FUNCTION SCOPES")
print("-" * 60)
def function1():
    x = 10
    print(f"  function1: x = {x}")

def function2():
    x = 20  # Different variable, same name
    print(f"  function2: x = {x}")

function1()
function2()
print("  Each function has its own 'x'")
print()

# 15. Practical: Bank Account
print("15. PRACTICAL: BANK ACCOUNT")
print("-" * 60)
def create_account(initial_balance=0):
    balance = initial_balance
    
    def deposit(amount):
        nonlocal balance
        balance += amount
        return balance
    
    def withdraw(amount):
        nonlocal balance
        if amount <= balance:
            balance -= amount
            return balance
        return "Insufficient funds"
    
    def get_balance():
        return balance
    
    return {"deposit": deposit, "withdraw": withdraw, "balance": get_balance}

account = create_account(100)
print(f"  Initial balance: {account['balance']()}")
print(f"  After deposit 50: {account['deposit'](50)}")
print(f"  After withdraw 30: {account['withdraw'](30)}")
print(f"  Current balance: {account['balance']()}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
SCOPE AND NAMESPACES PRACTICE
============================================================

1. LOCAL SCOPE
------------------------------------------------------------
  Inside function: I'm local

2. GLOBAL SCOPE
------------------------------------------------------------
  Reading global: I'm global
  Outside function: I'm global

[... rest of output ...]
```

**Challenge** (Optional):
- Create a more complex closure system
- Build a state management system
- Implement a decorator using closures
- Create a module-level configuration system
- Build a function factory pattern

---

## Key Takeaways

1. **Scope determines variable visibility** - where variables can be accessed
2. **LEGB rule** - Local, Enclosing, Global, Built-in (lookup order)
3. **Local variables** are only accessible within their function
4. **Global variables** are accessible throughout the module
5. **Use `global` keyword** to modify global variables inside functions
6. **Use `nonlocal` keyword** to modify enclosing scope variables
7. **Reading globals** doesn't require `global` keyword
8. **Modifying requires declaration** - use `global` or `nonlocal`
9. **Each function has its own scope** - variables are independent
10. **Closures** - nested functions can "remember" enclosing scope variables

---

## Quiz: Scope and Namespaces

Test your understanding with these questions:

1. **What is the LEGB rule?**
   - A) Local, Enclosing, Global, Built-in
   - B) Local, Global, Enclosing, Built-in
   - C) Built-in, Global, Enclosing, Local
   - D) Global, Local, Enclosing, Built-in

2. **Do you need `global` to read a global variable?**
   - A) Yes, always
   - B) No, only to modify
   - C) Yes, for both read and write
   - D) Never needed

3. **What keyword is used to modify enclosing scope variables?**
   - A) `global`
   - B) `nonlocal`
   - C) `local`
   - D) `enclosing`

4. **What happens if you assign to a variable without `global`?**
   - A) Creates local variable
   - B) Modifies global
   - C) Error
   - D) Does nothing

5. **Can nested functions access enclosing scope variables?**
   - A) No
   - B) Yes, to read only
   - C) Yes, to read and modify (with nonlocal)
   - D) Only with global

6. **What is a closure?**
   - A) A function that closes
   - B) A nested function that remembers enclosing scope
   - C) A global function
   - D) A built-in function

7. **What is variable shadowing?**
   - A) Hiding a variable
   - B) Local variable hiding global with same name
   - C) Global variable hiding local
   - D) Error condition

8. **What does `nonlocal` do?**
   - A) Accesses global variables
   - B) Accesses enclosing scope variables
   - C) Creates new variables
   - D) Deletes variables

9. **Can you modify a list without `global`?**
   - A) No
   - B) Yes, if modifying the object (not reassigning)
   - C) Always requires global
   - D) Only in Python 2

10. **What is the scope of a parameter?**
    - A) Global
    - B) Local
    - C) Enclosing
    - D) Built-in

**Answers**:
1. A) Local, Enclosing, Global, Built-in (LEGB lookup order)
2. B) No, only to modify (can read globals without global keyword)
3. B) `nonlocal` (for modifying enclosing scope variables)
4. A) Creates local variable (shadows global if same name)
5. C) Yes, to read and modify (with nonlocal for modification)
6. B) A nested function that remembers enclosing scope (closure)
7. B) Local variable hiding global with same name
8. B) Accesses enclosing scope variables (for modification)
9. B) Yes, if modifying the object (not reassigning) - mutation vs reassignment
10. B) Local (parameters are local to the function)

---

## Next Steps

Excellent work! You've mastered scope and namespaces. You now understand:
- Local and global scope
- The `global` and `nonlocal` keywords
- LEGB rule for scope resolution
- Nested functions and closures
- Best practices for scope management

**What's Next?**
- Lesson 6.4: Lambda Functions
- Practice building functions with proper scope
- Learn about advanced scope patterns
- Explore decorators and closures

---

## Additional Resources

- **Python Scopes and Namespaces**: [docs.python.org/3/tutorial/classes.html#python-scopes-and-namespaces](https://docs.python.org/3/tutorial/classes.html#python-scopes-and-namespaces)
- **Naming and Binding**: [docs.python.org/3/reference/executionmodel.html#naming-and-binding](https://docs.python.org/3/reference/executionmodel.html#naming-and-binding)
- **Closures**: Research Python closures and their applications

---

*Lesson completed! You're ready to move on to the next lesson.*

