# Lesson 2.2: Comparison and Logical Operators

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand and use all Python comparison operators
- Perform comparisons between different data types
- Use logical operators (and, or, not) effectively
- Understand operator precedence for comparison and logical operators
- Combine multiple conditions using logical operators
- Apply comparison and logical operators in conditional statements
- Avoid common pitfalls with comparison operators

---

## Introduction to Comparison Operators

Comparison operators are used to compare two values and return a boolean result (`True` or `False`). These operators are fundamental for making decisions in your programs.

### Comparison Operators Overview

| Operator | Name | Example | Result |
|----------|------|---------|--------|
| `==` | Equal to | `5 == 5` | `True` |
| `!=` | Not equal to | `5 != 3` | `True` |
| `<` | Less than | `5 < 3` | `False` |
| `>` | Greater than | `5 > 3` | `True` |
| `<=` | Less than or equal to | `5 <= 5` | `True` |
| `>=` | Greater than or equal to | `5 >= 3` | `True` |

**Important**: All comparison operators return boolean values (`True` or `False`).

---

## Equal To (==)

The `==` operator checks if two values are equal.

### Basic Equality

```python
# Numeric equality
print(5 == 5)    # Output: True
print(5 == 3)    # Output: False

# String equality
print("hello" == "hello")  # Output: True
print("hello" == "Hello")  # Output: False (case-sensitive)

# Boolean equality
print(True == True)   # Output: True
print(True == False)  # Output: False
```

### Equality with Variables

```python
x = 10
y = 10
z = 5

print(x == y)  # Output: True
print(x == z)  # Output: False
```

### Important: == vs =

**Common Mistake**: Using `=` instead of `==`

```python
# Wrong - this is assignment, not comparison!
# if x = 5:  # SyntaxError!

# Correct - this is comparison
if x == 5:
    print("x equals 5")
```

### Type Coercion in Comparisons

Python automatically converts compatible types in some comparisons:

```python
# Integer and float comparison
print(5 == 5.0)  # Output: True (5 is converted to 5.0)

# But be careful with strings and numbers
print("5" == 5)   # Output: False (different types)
print("5" == "5") # Output: True
```

### Equality Examples

```python
# Checking user input
user_input = "admin"
if user_input == "admin":
    print("Access granted")

# Comparing calculated values
result1 = 10 + 5
result2 = 3 * 5
if result1 == result2:
    print("Results are equal")

# String comparison (case-sensitive)
password = "Secret123"
if password == "Secret123":
    print("Password correct")
else:
    print("Password incorrect")
```

---

## Not Equal To (!=)

The `!=` operator checks if two values are NOT equal.

### Basic Inequality

```python
# Numeric inequality
print(5 != 3)    # Output: True
print(5 != 5)    # Output: False

# String inequality
print("hello" != "world")  # Output: True
print("hello" != "hello")  # Output: False
```

### Inequality Examples

```python
# Validating input
user_age = 17
if user_age != 18:
    print("You are not 18 years old")

# Checking for invalid values
status = "active"
if status != "inactive":
    print("System is operational")

# Filtering out specific values
numbers = [1, 2, 3, 4, 5]
for num in numbers:
    if num != 3:
        print(num)  # Prints: 1, 2, 4, 5
```

---

## Less Than (<)

The `<` operator checks if the left operand is less than the right operand.

### Basic Less Than

```python
# Numeric comparison
print(3 < 5)     # Output: True
print(5 < 3)     # Output: False
print(5 < 5)     # Output: False

# Float comparison
print(3.14 < 3.15)  # Output: True
```

### String Comparison (Lexicographic)

Strings are compared lexicographically (alphabetically):

```python
# String comparison
print("apple" < "banana")  # Output: True
print("zebra" < "apple")   # Output: False

# Case matters (uppercase comes before lowercase in ASCII)
print("Apple" < "apple")   # Output: True
print("Z" < "a")           # Output: True
```

### Less Than Examples

```python
# Age verification
age = 20
if age < 18:
    print("You are a minor")
else:
    print("You are an adult")

# Price comparison
price1 = 19.99
price2 = 24.99
if price1 < price2:
    print(f"Price 1 (${price1}) is cheaper")

# Sorting logic
scores = [85, 92, 78, 96, 88]
for score in scores:
    if score < 80:
        print(f"Score {score} is below 80")
```

---

## Greater Than (>)

The `>` operator checks if the left operand is greater than the right operand.

### Basic Greater Than

```python
# Numeric comparison
print(5 > 3)     # Output: True
print(3 > 5)     # Output: False
print(5 > 5)     # Output: False
```

### Greater Than Examples

```python
# Score threshold
score = 85
if score > 80:
    print("You passed!")

# Temperature check
temperature = 32
if temperature > 0:
    print("Above freezing")

# Comparing values
a = 10
b = 5
if a > b:
    print(f"{a} is greater than {b}")
```

---

## Less Than or Equal To (<=)

The `<=` operator checks if the left operand is less than or equal to the right operand.

### Basic Less Than or Equal To

```python
# Numeric comparison
print(5 <= 5)    # Output: True
print(3 <= 5)    # Output: True
print(5 <= 3)    # Output: False
```

### Less Than or Equal To Examples

```python
# Age range check
age = 18
if age <= 18:
    print("You are 18 or younger")

# Budget check
budget = 1000
expense = 1000
if expense <= budget:
    print("Within budget")

# Grade boundaries
score = 90
if score >= 90 and score <= 100:
    print("Grade A")
```

---

## Greater Than or Equal To (>=)

The `>=` operator checks if the left operand is greater than or equal to the right operand.

### Basic Greater Than or Equal To

```python
# Numeric comparison
print(5 >= 5)    # Output: True
print(5 >= 3)    # Output: True
print(3 >= 5)    # Output: False
```

### Greater Than or Equal To Examples

```python
# Minimum age requirement
age = 21
if age >= 21:
    print("You can enter")

# Passing grade
score = 60
if score >= 60:
    print("You passed!")

# Stock level check
stock = 50
min_stock = 50
if stock >= min_stock:
    print("Stock level is adequate")
```

---

## Chaining Comparisons

Python allows you to chain multiple comparisons together, which is more readable than using `and`:

```python
# Chained comparison (more readable)
x = 5
print(3 < x < 10)  # Output: True (equivalent to 3 < x and x < 10)

# Multiple chained comparisons
print(1 < 2 < 3 < 4)  # Output: True
print(1 < 2 < 3 > 4)  # Output: False

# Practical example
age = 25
if 18 <= age <= 65:
    print("Working age")

# Temperature range
temp = 72
if 70 <= temp <= 75:
    print("Comfortable temperature")
```

**Note**: Chained comparisons are evaluated left to right, and each comparison must be true for the whole expression to be true.

---

## Comparison with Different Types

### Numeric Types

```python
# Integers and floats
print(5 == 5.0)      # True
print(5 < 5.1)       # True
print(5 <= 5.0)      # True
```

### Strings

```python
# String comparison is case-sensitive
print("Hello" == "hello")  # False
print("Hello" < "hello")   # True (uppercase < lowercase in ASCII)

# Comparing strings of different lengths
print("abc" < "abcd")      # True
```

### Mixed Types

```python
# Numbers and strings cannot be directly compared
# print("5" < 4)  # TypeError: '<' not supported between 'str' and 'int'

# Need to convert first
print(int("5") < 4)  # False
```

### None Comparison

```python
# None comparisons
value = None
print(value == None)   # True (but use 'is' instead - covered later)
print(value != None)   # False
```

---

## Logical Operators

Logical operators are used to combine or modify boolean expressions. Python has three logical operators: `and`, `or`, and `not`.

### Logical Operators Overview

| Operator | Name | Description | Example |
|----------|------|-------------|---------|
| `and` | Logical AND | Returns `True` if both operands are `True` | `True and False` → `False` |
| `or` | Logical OR | Returns `True` if at least one operand is `True` | `True or False` → `True` |
| `not` | Logical NOT | Returns the opposite boolean value | `not True` → `False` |

---

## Logical AND (and)

The `and` operator returns `True` only if both operands are `True`.

### AND Truth Table

| A | B | A and B |
|---|---|---------|
| True | True | True |
| True | False | False |
| False | True | False |
| False | False | False |

### Basic AND

```python
# Both True
print(True and True)   # Output: True

# One False
print(True and False)  # Output: False
print(False and True)  # Output: False

# Both False
print(False and False) # Output: False
```

### AND with Comparisons

```python
# Combining conditions
age = 25
has_license = True

if age >= 18 and has_license:
    print("Can drive")

# Multiple conditions
score = 85
attendance = 0.95
if score >= 80 and attendance >= 0.90:
    print("Eligible for scholarship")
```

### Short-Circuit Evaluation

The `and` operator uses short-circuit evaluation: if the left operand is `False`, the right operand is not evaluated.

```python
# Short-circuit example
x = 0
# This won't cause a division by zero error
if x != 0 and 10 / x > 1:
    print("Safe division")

# Practical use
user = None
if user is not None and user.is_active():
    print("User is active")
```

### AND Examples

```python
# Password validation
password = "Secret123"
if len(password) >= 8 and password.isalnum():
    print("Valid password")

# Range check
number = 15
if number > 10 and number < 20:
    print("Number is between 10 and 20")

# Multiple AND conditions
username = "admin"
password = "secret"
is_active = True
if username == "admin" and password == "secret" and is_active:
    print("Login successful")
```

---

## Logical OR (or)

The `or` operator returns `True` if at least one operand is `True`.

### OR Truth Table

| A | B | A or B |
|---|---|--------|
| True | True | True |
| True | False | True |
| False | True | True |
| False | False | False |

### Basic OR

```python
# At least one True
print(True or False)   # Output: True
print(False or True)   # Output: True
print(True or True)    # Output: True

# Both False
print(False or False)  # Output: False
```

### OR with Comparisons

```python
# Alternative conditions
day = "Saturday"
if day == "Saturday" or day == "Sunday":
    print("It's the weekend!")

# Multiple OR conditions
grade = "A"
if grade == "A" or grade == "B" or grade == "C":
    print("Passing grade")
```

### Short-Circuit Evaluation

The `or` operator also uses short-circuit evaluation: if the left operand is `True`, the right operand is not evaluated.

```python
# Short-circuit example
default_value = "guest"
user_input = "admin"
result = user_input or default_value
print(result)  # Output: "admin" (if user_input is truthy, use it)

# Practical use
config_value = None
value = config_value or "default"
print(value)  # Output: "default"
```

### OR Examples

```python
# Discount eligibility
age = 65
is_student = True
if age >= 65 or is_student:
    print("Eligible for discount")

# Error handling
value = None
if value is None or value == "":
    print("Value is missing")

# Multiple conditions
status = "pending"
if status == "active" or status == "pending" or status == "processing":
    print("Status is valid")
```

---

## Logical NOT (not)

The `not` operator returns the opposite boolean value.

### NOT Truth Table

| A | not A |
|---|-------|
| True | False |
| False | True |

### Basic NOT

```python
# Negation
print(not True)   # Output: False
print(not False)  # Output: True

# With comparisons
print(not (5 > 3))  # Output: False
print(not (5 < 3))  # Output: True
```

### NOT Examples

```python
# Inverting conditions
is_weekend = False
if not is_weekend:
    print("It's a weekday")

# Checking for absence
items = []
if not items:
    print("List is empty")

# Negating complex conditions
age = 20
has_license = False
if not (age >= 18 and has_license):
    print("Cannot drive")
```

### Common NOT Patterns

```python
# Checking if value is not None
value = None
if value is not None:
    print("Value exists")

# Checking if string is not empty
text = ""
if not text:
    print("String is empty")

# Inverting boolean variables
is_active = True
if not is_active:
    print("Account is inactive")
```

---

## Combining Logical Operators

You can combine multiple logical operators to create complex conditions.

### Operator Precedence

When combining operators, Python follows this precedence (highest to lowest):

1. **Comparison operators** (`<`, `>`, `<=`, `>=`, `==`, `!=`)
2. **not**
3. **and**
4. **or**

### Examples of Combined Operators

```python
# Complex condition
age = 25
has_license = True
has_insurance = False

if age >= 18 and has_license and not has_insurance:
    print("Can drive but needs insurance")

# Using parentheses for clarity
if (age >= 18 and has_license) or (age >= 16 and has_permit):
    print("Can drive")

# Multiple conditions
score = 85
attendance = 0.95
is_enrolled = True

if score >= 80 and attendance >= 0.90 and is_enrolled:
    print("Eligible for honors")
```

### Precedence Examples

```python
# Without parentheses (uses precedence)
result = 5 > 3 and 2 < 4 or 1 > 2
# Evaluates as: (5 > 3 and 2 < 4) or (1 > 2)
# = (True and True) or False
# = True or False
# = True

# With parentheses (explicit grouping)
result = (5 > 3 and 2 < 4) or (1 > 2)
# Same result, but clearer

# Different grouping
result = 5 > 3 and (2 < 4 or 1 > 2)
# = True and (True or False)
# = True and True
# = True
```

### Best Practices

```python
# Use parentheses for clarity, even when not strictly necessary
# Good
if (age >= 18 and has_license) or (age >= 16 and has_permit):
    pass

# Also good (precedence makes it work, but less clear)
if age >= 18 and has_license or age >= 16 and has_permit:
    pass

# Better: break into variables
can_drive_with_license = age >= 18 and has_license
can_drive_with_permit = age >= 16 and has_permit
if can_drive_with_license or can_drive_with_permit:
    pass
```

---

## Common Patterns and Use Cases

### 1. Range Checking

```python
# Check if value is in range
value = 15
if 10 <= value <= 20:
    print("Value is in range")

# Using and
if value >= 10 and value <= 20:
    print("Value is in range")
```

### 2. Multiple Conditions

```python
# All conditions must be true
username = "admin"
password = "secret"
is_active = True

if username == "admin" and password == "secret" and is_active:
    print("Access granted")

# At least one condition must be true
status = "pending"
if status == "active" or status == "pending" or status == "processing":
    print("Valid status")
```

### 3. Negation Patterns

```python
# Check if not in list
item = "apple"
if item not in ["banana", "orange", "grape"]:
    print("Item not found")

# Check if not equal
value = 5
if value != 0:
    print("Value is not zero")
```

### 4. Input Validation

```python
# Validate user input
user_input = "25"
if user_input.isdigit() and int(user_input) > 0:
    age = int(user_input)
    print(f"Valid age: {age}")
else:
    print("Invalid input")
```

### 5. Conditional Assignment

```python
# Set default value
value = None
result = value or "default"
print(result)  # Output: "default"

# Conditional value
age = 25
status = "adult" if age >= 18 else "minor"
print(status)  # Output: "adult"
```

---

## Common Pitfalls and Mistakes

### 1. Using = Instead of ==

```python
# Wrong
# if x = 5:  # SyntaxError!

# Correct
if x == 5:
    pass
```

### 2. Chaining == Incorrectly

```python
# This doesn't work as you might expect
x = 5
y = 5
z = 5
# print(x == y == z)  # This works! Returns True

# But this is different
# print(x == y == 5)  # This also works! Returns True
```

### 3. Comparing Floats

```python
# Floating-point precision issues
result = 0.1 + 0.2
print(result == 0.3)  # False! (due to floating-point precision)

# Better approach
print(abs(result - 0.3) < 0.0001)  # True
```

### 4. String Comparison Case Sensitivity

```python
# Case-sensitive comparison
print("Hello" == "hello")  # False

# Case-insensitive comparison
print("Hello".lower() == "hello".lower())  # True
```

### 5. Confusing and/or Precedence

```python
# This might not work as expected
age = 25
has_license = True
has_insurance = False

# Wrong interpretation
# if age >= 18 and has_license or has_insurance:  # This is: (age >= 18 and has_license) or has_insurance

# Clear with parentheses
if (age >= 18 and has_license) or has_insurance:
    pass
```

---

## Practice Exercise

### Exercise: Comparison and Logical Operators Practice

**Objective**: Create a Python program that demonstrates the use of comparison and logical operators in practical scenarios.

**Instructions**:

1. Create a file called `comparison_practice.py`

2. Write a program that:
   - Performs various comparisons
   - Uses logical operators to combine conditions
   - Validates user input
   - Makes decisions based on multiple conditions
   - Demonstrates operator precedence

3. Your program should include:
   - Age verification system
   - Grade calculation with multiple conditions
   - Password validation
   - Temperature range checking
   - Discount eligibility

**Example Solution**:

```python
"""
Comparison and Logical Operators Practice
This program demonstrates the use of comparison and logical operators
in various practical scenarios.
"""

print("=" * 60)
print("COMPARISON AND LOGICAL OPERATORS PRACTICE")
print("=" * 60)
print()

# 1. Basic Comparisons
print("1. BASIC COMPARISONS")
print("-" * 60)
a = 10
b = 5
c = 10

print(f"a = {a}, b = {b}, c = {c}")
print(f"a == b: {a == b}")      # False
print(f"a == c: {a == c}")      # True
print(f"a != b: {a != b}")      # True
print(f"a < b: {a < b}")        # False
print(f"a > b: {a > b}")        # True
print(f"a <= c: {a <= c}")      # True
print(f"a >= b: {a >= b}")      # True
print()

# 2. Chained Comparisons
print("2. CHAINED COMPARISONS")
print("-" * 60)
value = 15
print(f"value = {value}")
print(f"10 <= value <= 20: {10 <= value <= 20}")  # True
print(f"5 < value < 10: {5 < value < 10}")        # False
print()

# 3. Age Verification System
print("3. AGE VERIFICATION SYSTEM")
print("-" * 60)
ages = [16, 18, 21, 25, 65]

for age in ages:
    can_vote = age >= 18
    can_drink = age >= 21
    senior_discount = age >= 65
    
    print(f"Age {age}:")
    print(f"  Can vote: {can_vote}")
    print(f"  Can drink: {can_drink}")
    print(f"  Senior discount: {senior_discount}")
    print()

# 4. Grade Calculation with Multiple Conditions
print("4. GRADE CALCULATION")
print("-" * 60)
scores = [
    {"name": "Alice", "score": 95, "attendance": 0.98},
    {"name": "Bob", "score": 75, "attendance": 0.85},
    {"name": "Charlie", "score": 88, "attendance": 0.92},
    {"name": "Diana", "score": 92, "attendance": 0.75},
]

for student in scores:
    name = student["name"]
    score = student["score"]
    attendance = student["attendance"]
    
    # Determine grade
    if score >= 90:
        grade = "A"
    elif score >= 80:
        grade = "B"
    elif score >= 70:
        grade = "C"
    else:
        grade = "F"
    
    # Check eligibility for honors
    eligible_for_honors = score >= 85 and attendance >= 0.90
    passed = score >= 60 and attendance >= 0.75
    
    print(f"{name}:")
    print(f"  Score: {score}, Attendance: {attendance:.0%}")
    print(f"  Grade: {grade}")
    print(f"  Passed: {passed}")
    print(f"  Eligible for honors: {eligible_for_honors}")
    print()

# 5. Password Validation
print("5. PASSWORD VALIDATION")
print("-" * 60)
passwords = ["short", "NoNumbers", "nouppercase123", "ValidPass123", "Another123!"]

for password in passwords:
    length_ok = len(password) >= 8
    has_upper = any(c.isupper() for c in password)
    has_lower = any(c.islower() for c in password)
    has_digit = any(c.isdigit() for c in password)
    
    is_valid = length_ok and has_upper and has_lower and has_digit
    
    print(f"Password: '{password}'")
    print(f"  Length >= 8: {length_ok}")
    print(f"  Has uppercase: {has_upper}")
    print(f"  Has lowercase: {has_lower}")
    print(f"  Has digit: {has_digit}")
    print(f"  Valid: {is_valid}")
    print()

# 6. Temperature Range Checking
print("6. TEMPERATURE RANGE CHECKING")
print("-" * 60)
temperatures = [32, 50, 68, 75, 85, 95, 100]

for temp in temperatures:
    freezing = temp <= 32
    cold = 32 < temp < 50
    moderate = 50 <= temp < 70
    warm = 70 <= temp < 85
    hot = temp >= 85
    
    print(f"Temperature: {temp}°F")
    if freezing:
        print("  Status: Freezing")
    elif cold:
        print("  Status: Cold")
    elif moderate:
        print("  Status: Moderate")
    elif warm:
        print("  Status: Warm")
    elif hot:
        print("  Status: Hot")
    print()

# 7. Discount Eligibility
print("7. DISCOUNT ELIGIBILITY")
print("-" * 60)
customers = [
    {"age": 25, "is_student": True, "is_member": False},
    {"age": 65, "is_student": False, "is_member": True},
    {"age": 30, "is_student": False, "is_member": False},
    {"age": 20, "is_student": True, "is_member": True},
]

for customer in customers:
    age = customer["age"]
    is_student = customer["is_student"]
    is_member = customer["is_member"]
    
    student_discount = is_student
    senior_discount = age >= 65
    member_discount = is_member
    
    eligible_for_discount = student_discount or senior_discount or member_discount
    
    print(f"Customer: Age {age}, Student: {is_student}, Member: {is_member}")
    print(f"  Student discount: {student_discount}")
    print(f"  Senior discount: {senior_discount}")
    print(f"  Member discount: {member_discount}")
    print(f"  Eligible for any discount: {eligible_for_discount}")
    print()

# 8. Logical Operator Combinations
print("8. LOGICAL OPERATOR COMBINATIONS")
print("-" * 60)
x = 10
y = 5
z = 15

print(f"x = {x}, y = {y}, z = {z}")
print(f"x > y and x < z: {x > y and x < z}")           # True
print(f"x > y or x > z: {x > y or x > z}")             # True
print(f"not (x > y): {not (x > y)}")                   # False
print(f"x > y and not (x > z): {x > y and not (x > z)}")  # True
print()

# 9. String Comparisons
print("9. STRING COMPARISONS")
print("-" * 60)
str1 = "apple"
str2 = "banana"
str3 = "Apple"

print(f"'{str1}' < '{str2}': {str1 < str2}")           # True
print(f"'{str1}' == '{str3}': {str1 == str3}")         # False
print(f"'{str1}.lower()' == '{str3}.lower()': {str1.lower() == str3.lower()}")  # True
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated for brevity):
```
============================================================
COMPARISON AND LOGICAL OPERATORS PRACTICE
============================================================

1. BASIC COMPARISONS
------------------------------------------------------------
a = 10, b = 5, c = 10
a == b: False
a == c: True
a != b: True
a < b: False
a > b: True
a <= c: True
a >= b: True

[... rest of output ...]
```

**Challenge** (Optional):
- Add user input validation
- Create a more complex eligibility system
- Implement a voting eligibility checker
- Build a loan approval system based on multiple criteria
- Create a weather advisory system

---

## Key Takeaways

1. **Comparison operators** (`==`, `!=`, `<`, `>`, `<=`, `>=`) return boolean values
2. **== vs =**: Use `==` for comparison, `=` for assignment
3. **Chained comparisons** (`3 < x < 10`) are more readable than using `and`
4. **Logical AND (`and`)** returns `True` only if both operands are `True`
5. **Logical OR (`or`)** returns `True` if at least one operand is `True`
6. **Logical NOT (`not`)** returns the opposite boolean value
7. **Short-circuit evaluation**: `and` and `or` don't evaluate the right operand if not needed
8. **Operator precedence**: Comparisons > `not` > `and` > `or`
9. **Use parentheses** for clarity when combining multiple logical operators
10. **Be careful with float comparisons** due to precision issues

---

## Quiz: Comparison and Logical Operators

Test your understanding with these questions:

1. **What is the result of `5 == 5.0`?**
   - A) `True`
   - B) `False`
   - C) Error
   - D) `None`

2. **What is the result of `True and False`?**
   - A) `True`
   - B) `False`
   - C) Error
   - D) `None`

3. **What is the result of `True or False`?**
   - A) `True`
   - B) `False`
   - C) Error
   - D) `None`

4. **What is the result of `not True`?**
   - A) `True`
   - B) `False`
   - C) Error
   - D) `None`

5. **What is the result of `5 < 3 or 2 > 1`?**
   - A) `True`
   - B) `False`
   - C) Error
   - D) `None`

6. **What is the result of `3 < x < 10` when `x = 5`?**
   - A) `True`
   - B) `False`
   - C) Error
   - D) `None`

7. **What is the result of `"apple" < "banana"`?**
   - A) `True`
   - B) `False`
   - C) Error
   - D) `None`

8. **What is the result of `5 != 5`?**
   - A) `True`
   - B) `False`
   - C) Error
   - D) `None`

9. **What is the result of `not (5 > 3 and 2 < 4)`?**
   - A) `True`
   - B) `False`
   - C) Error
   - D) `None`

10. **Which operator has the highest precedence?**
    - A) `and`
    - B) `or`
    - C) `not`
    - D) `==`

**Answers**:
1. A) `True` (Python converts int to float for comparison)
2. B) `False` (AND requires both to be True)
3. A) `True` (OR requires at least one to be True)
4. B) `False` (NOT inverts the value)
5. A) `True` (5 < 3 is False, but 2 > 1 is True, so OR returns True)
6. A) `True` (5 is between 3 and 10)
7. A) `True` (lexicographic comparison)
8. B) `False` (5 equals 5, so not equal is False)
9. B) `False` (5 > 3 and 2 < 4 is True, so not True is False)
10. D) `==` (comparison operators have higher precedence than logical operators)

---

## Next Steps

Excellent work! You've mastered comparison and logical operators. You now understand:
- All comparison operators and their usage
- How to combine conditions with logical operators
- Operator precedence and how to use parentheses
- Common patterns and best practices
- How to avoid common pitfalls

**What's Next?**
- Lesson 2.3: Assignment Operators
- Lesson 5.1: Conditional Statements (if, elif, else)
- Practice building programs that make decisions
- Experiment with complex logical expressions

---

## Additional Resources

- **Python Comparisons**: [docs.python.org/3/reference/expressions.html#comparisons](https://docs.python.org/3/reference/expressions.html#comparisons)
- **Boolean Operations**: [docs.python.org/3/reference/expressions.html#boolean-operations](https://docs.python.org/3/reference/expressions.html#boolean-operations)
- **Operator Precedence**: [docs.python.org/3/reference/expressions.html#operator-precedence](https://docs.python.org/3/reference/expressions.html#operator-precedence)
- **Truth Value Testing**: [docs.python.org/3/library/stdtypes.html#truth-value-testing](https://docs.python.org/3/library/stdtypes.html#truth-value-testing)

---

*Lesson completed! You're ready to move on to the next lesson.*

