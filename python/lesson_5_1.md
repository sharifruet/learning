# Lesson 5.1: Conditional Statements

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand and use if statements
- Use elif for multiple conditions
- Use else for default cases
- Write nested conditional statements
- Understand truthiness and falsiness in conditionals
- Apply conditional logic in practical scenarios
- Write clean and readable conditional code
- Avoid common pitfalls with conditionals

---

## Introduction to Conditional Statements

**Conditional statements** allow your program to make decisions and execute different code based on conditions. They are fundamental to programming and enable your code to respond dynamically to different situations.

Python provides three main conditional constructs:
- `if` - executes code if condition is True
- `elif` - checks additional conditions if previous ones are False
- `else` - executes code if all conditions are False

---

## The if Statement

The `if` statement is the most basic conditional. It executes code only when a condition is True.

### Basic Syntax

```python
if condition:
    # Code to execute if condition is True
    statement1
    statement2
```

**Important**: 
- The condition is followed by a colon `:`
- The code block is indented (typically 4 spaces)
- All indented code belongs to the if block

### Simple Examples

```python
# Basic if statement
age = 20
if age >= 18:
    print("You are an adult")

# With variable
temperature = 25
if temperature > 0:
    print("Above freezing")

# With string
name = "Alice"
if name == "Alice":
    print("Hello, Alice!")
```

### Real-World Example

```python
# Check if user can vote
age = 20
if age >= 18:
    print("You are eligible to vote!")
    print("Please register to vote.")
```

---

## The if-else Statement

The `else` clause provides an alternative path when the condition is False.

### Basic Syntax

```python
if condition:
    # Code if condition is True
    statement1
else:
    # Code if condition is False
    statement2
```

### Examples

```python
# Age check
age = 15
if age >= 18:
    print("You are an adult")
else:
    print("You are a minor")

# Number check
number = 5
if number % 2 == 0:
    print("Even number")
else:
    print("Odd number")

# Password check
password = "secret123"
if len(password) >= 8:
    print("Password is valid")
else:
    print("Password must be at least 8 characters")
```

### Real-World Example

```python
# Login system
username = "admin"
password = "secret123"

if username == "admin" and password == "secret123":
    print("Login successful!")
    print("Welcome to the system.")
else:
    print("Invalid username or password")
    print("Please try again.")
```

---

## The if-elif-else Statement

The `elif` (else if) allows you to check multiple conditions in sequence.

### Basic Syntax

```python
if condition1:
    # Code if condition1 is True
    statement1
elif condition2:
    # Code if condition1 is False and condition2 is True
    statement2
elif condition3:
    # Code if previous conditions are False and condition3 is True
    statement3
else:
    # Code if all conditions are False
    statement4
```

### Examples

```python
# Grade system
score = 85
if score >= 90:
    grade = "A"
elif score >= 80:
    grade = "B"
elif score >= 70:
    grade = "C"
elif score >= 60:
    grade = "D"
else:
    grade = "F"

print(f"Your grade is: {grade}")

# Temperature check
temp = 25
if temp > 30:
    print("It's hot!")
elif temp > 20:
    print("It's warm")
elif temp > 10:
    print("It's cool")
else:
    print("It's cold")
```

### Important Notes

- Conditions are checked **in order** from top to bottom
- Once a condition is True, that block executes and the rest are **skipped**
- Only **one** block executes (the first True condition)

```python
# Example showing order matters
score = 95
if score >= 60:  # This is True first!
    grade = "D"  # This executes
elif score >= 70:
    grade = "C"  # This is skipped
elif score >= 80:
    grade = "B"  # This is skipped
elif score >= 90:
    grade = "A"  # This is skipped

print(grade)  # Output: D (wrong! should be A)

# Correct order (highest to lowest)
score = 95
if score >= 90:
    grade = "A"
elif score >= 80:
    grade = "B"
elif score >= 70:
    grade = "C"
elif score >= 60:
    grade = "D"
else:
    grade = "F"

print(grade)  # Output: A (correct!)
```

---

## Nested Conditionals

You can nest conditional statements inside other conditionals to create complex decision trees.

### Basic Syntax

```python
if condition1:
    # Outer if block
    if condition2:
        # Inner if block
        statement1
    else:
        # Inner else block
        statement2
else:
    # Outer else block
    statement3
```

### Examples

```python
# Nested age and license check
age = 25
has_license = True

if age >= 18:
    if has_license:
        print("You can drive")
    else:
        print("You need a license to drive")
else:
    print("You are too young to drive")

# Nested grade and attendance check
score = 85
attendance = 0.95

if score >= 80:
    if attendance >= 0.90:
        print("Eligible for honors")
    else:
        print("Good score, but attendance too low")
else:
    if attendance >= 0.90:
        print("Good attendance, but score too low")
    else:
        print("Need to improve both score and attendance")
```

### Real-World Example

```python
# User access control
user_role = "admin"
is_active = True
has_permission = True

if user_role == "admin":
    if is_active:
        if has_permission:
            print("Full access granted")
        else:
            print("Admin account but no permission")
    else:
        print("Admin account is inactive")
elif user_role == "user":
    if is_active:
        print("Standard user access")
    else:
        print("User account is inactive")
else:
    print("Unknown user role")
```

### Best Practices for Nested Conditionals

**Avoid deep nesting** (more than 2-3 levels):

```python
# Bad: Too deeply nested
if condition1:
    if condition2:
        if condition3:
            if condition4:
                print("Too nested!")

# Better: Use early returns or combine conditions
if condition1 and condition2 and condition3 and condition4:
    print("Cleaner!")
```

---

## Truthiness and Falsiness

Python evaluates values as "truthy" or "falsy" in conditional statements.

### Falsy Values

These values evaluate to `False`:
- `False`
- `None`
- `0` (any numeric zero)
- `""` (empty string)
- `[]` (empty list)
- `{}` (empty dictionary)
- `()` (empty tuple)
- `set()` (empty set)

### Truthy Values

Everything else evaluates to `True`:
- Non-zero numbers
- Non-empty strings
- Non-empty collections
- Most objects

### Examples

```python
# Falsy values
if 0:
    print("This won't print")
if "":
    print("This won't print")
if []:
    print("This won't print")
if None:
    print("This won't print")

# Truthy values
if 1:
    print("This will print")  # Output: This will print
if "hello":
    print("This will print")  # Output: This will print
if [1, 2, 3]:
    print("This will print")  # Output: This will print

# Practical use
name = ""
if name:  # Checks if name is not empty
    print(f"Hello, {name}")
else:
    print("Name is required")

# Check if list has items
items = []
if items:
    print(f"You have {len(items)} items")
else:
    print("Your list is empty")
```

### Explicit vs Implicit Checks

```python
# Implicit (using truthiness)
value = None
if value:
    print("Has value")

# Explicit (more clear)
value = None
if value is not None:
    print("Has value")

# Both work, but explicit is often clearer
```

---

## Comparison Operators in Conditionals

You've learned these operators before, but here's how they're used in conditionals:

```python
# Equality
if x == 5:
    print("x equals 5")

# Inequality
if x != 5:
    print("x does not equal 5")

# Less than
if x < 5:
    print("x is less than 5")

# Greater than
if x > 5:
    print("x is greater than 5")

# Less than or equal
if x <= 5:
    print("x is less than or equal to 5")

# Greater than or equal
if x >= 5:
    print("x is greater than or equal to 5")
```

---

## Logical Operators in Conditionals

Combine conditions using `and`, `or`, and `not`:

### and Operator

```python
# Both conditions must be True
age = 25
has_license = True

if age >= 18 and has_license:
    print("You can drive")

# Multiple conditions
score = 85
attendance = 0.95
is_enrolled = True

if score >= 80 and attendance >= 0.90 and is_enrolled:
    print("Eligible for honors")
```

### or Operator

```python
# At least one condition must be True
age = 65
is_student = False

if age >= 65 or is_student:
    print("Eligible for discount")

# Multiple conditions
status = "pending"
if status == "active" or status == "pending" or status == "processing":
    print("Valid status")
```

### not Operator

```python
# Negates the condition
is_weekend = False

if not is_weekend:
    print("It's a weekday")

# Check if value is not in list
items = ["apple", "banana"]
if "orange" not in items:
    print("Orange is not in the list")

# Check if value is not None
value = None
if value is not None:
    print("Value exists")
```

### Combining Operators

```python
# Complex conditions
age = 25
has_license = True
has_insurance = False

if age >= 18 and has_license and not has_insurance:
    print("Can drive but needs insurance")

# Using parentheses for clarity
if (age >= 18 and has_license) or (age >= 16 and has_permit):
    print("Can drive")
```

---

## Ternary Operator (Conditional Expression)

Python supports a concise way to assign values based on conditions.

### Syntax

```python
value = expression_if_true if condition else expression_if_false
```

### Examples

```python
# Basic ternary
age = 20
status = "adult" if age >= 18 else "minor"
print(status)  # Output: adult

# Number comparison
x = 10
y = 5
max_value = x if x > y else y
print(max_value)  # Output: 10

# String formatting
score = 85
grade = "Pass" if score >= 60 else "Fail"
print(f"Score: {score}, Grade: {grade}")

# Nested ternary (use sparingly)
score = 85
grade = "A" if score >= 90 else "B" if score >= 80 else "C" if score >= 70 else "F"
print(grade)  # Output: B
```

### When to Use Ternary

**Good for simple assignments**:
```python
# Clean and readable
status = "active" if user.is_active else "inactive"
```

**Avoid for complex logic**:
```python
# Too complex - use if-else instead
result = func1() if condition1 else func2() if condition2 else func3() if condition3 else default
```

---

## Common Patterns

### Pattern 1: Early Return / Guard Clauses

```python
# Instead of deep nesting, return early
def process_user(user):
    if user is None:
        return "No user provided"
    
    if not user.is_active:
        return "User is inactive"
    
    if not user.has_permission:
        return "User lacks permission"
    
    # Main logic here
    return "Processing user..."
```

### Pattern 2: Range Checking

```python
# Check if value is in range
score = 85
if 80 <= score <= 100:
    print("Good score")

# Or using and
if score >= 80 and score <= 100:
    print("Good score")
```

### Pattern 3: Multiple Conditions

```python
# Check multiple conditions
username = "admin"
password = "secret"
is_active = True

if username == "admin" and password == "secret" and is_active:
    print("Access granted")
```

### Pattern 4: Default Values

```python
# Provide default if value is missing
name = None
display_name = name if name else "Guest"
print(display_name)  # Output: Guest

# Or using or
display_name = name or "Guest"
print(display_name)  # Output: Guest
```

---

## Common Mistakes and Pitfalls

### 1. Missing Colon

```python
# Wrong
# if x > 5
#     print("Greater")

# Correct
if x > 5:
    print("Greater")
```

### 2. Incorrect Indentation

```python
# Wrong
if x > 5:
print("Greater")  # IndentationError!

# Correct
if x > 5:
    print("Greater")
```

### 3. Using = Instead of ==

```python
# Wrong
# if x = 5:  # SyntaxError!

# Correct
if x == 5:
    print("x equals 5")
```

### 4. Incorrect elif Order

```python
# Wrong - checks lower threshold first
score = 95
if score >= 60:
    grade = "D"  # Executes first!
elif score >= 90:
    grade = "A"  # Never reached

# Correct - check higher thresholds first
score = 95
if score >= 90:
    grade = "A"
elif score >= 80:
    grade = "B"
elif score >= 70:
    grade = "C"
elif score >= 60:
    grade = "D"
```

### 5. Confusing and/or

```python
# Wrong understanding
age = 25
if age >= 18 and age < 65:  # Both must be True
    print("Working age")

# Wrong - this is different!
if age >= 18 or age < 65:  # Always True! (everyone is either >=18 OR <65)
    print("This always executes")
```

### 6. Not Using Parentheses for Clarity

```python
# Unclear
if x > 5 and y < 10 or z == 0:
    pass

# Clear with parentheses
if (x > 5 and y < 10) or z == 0:
    pass
```

---

## Practice Exercise

### Exercise: Conditional Logic Practice

**Objective**: Create a Python program that demonstrates various conditional statements and patterns.

**Instructions**:

1. Create a file called `conditionals_practice.py`

2. Write a program that:
   - Uses if, elif, and else statements
   - Demonstrates nested conditionals
   - Uses logical operators
   - Implements practical conditional logic
   - Shows common patterns

3. Your program should include:
   - Grade calculator
   - Age verification system
   - Login system
   - Temperature converter with conditions
   - Permission checker

**Example Solution**:

```python
"""
Conditional Statements Practice
This program demonstrates various conditional statements and patterns.
"""

print("=" * 60)
print("CONDITIONAL STATEMENTS PRACTICE")
print("=" * 60)
print()

# 1. Basic if Statement
print("1. BASIC IF STATEMENT")
print("-" * 60)
age = 20
if age >= 18:
    print(f"Age {age}: You are an adult")
print()

# 2. if-else Statement
print("2. IF-ELSE STATEMENT")
print("-" * 60)
age = 15
if age >= 18:
    print(f"Age {age}: You are an adult")
else:
    print(f"Age {age}: You are a minor")
print()

# 3. if-elif-else Statement
print("3. IF-ELIF-ELSE STATEMENT")
print("-" * 60)
score = 85
if score >= 90:
    grade = "A"
elif score >= 80:
    grade = "B"
elif score >= 70:
    grade = "C"
elif score >= 60:
    grade = "D"
else:
    grade = "F"

print(f"Score {score}: Grade {grade}")

# Temperature check
temp = 25
if temp > 30:
    condition = "hot"
elif temp > 20:
    condition = "warm"
elif temp > 10:
    condition = "cool"
else:
    condition = "cold"

print(f"Temperature {temp}°C: It's {condition}")
print()

# 4. Nested Conditionals
print("4. NESTED CONDITIONALS")
print("-" * 60)
age = 25
has_license = True
has_insurance = False

if age >= 18:
    if has_license:
        if has_insurance:
            print("You can drive legally")
        else:
            print("You can drive but need insurance")
    else:
        print("You need a license to drive")
else:
    print("You are too young to drive")
print()

# 5. Logical Operators
print("5. LOGICAL OPERATORS")
print("-" * 60)
# and
age = 25
has_license = True
if age >= 18 and has_license:
    print("Can drive (using and)")

# or
age = 65
is_student = False
if age >= 65 or is_student:
    print("Eligible for discount (using or)")

# not
is_weekend = False
if not is_weekend:
    print("It's a weekday (using not)")

# Combined
score = 85
attendance = 0.95
is_enrolled = True
if score >= 80 and attendance >= 0.90 and is_enrolled:
    print("Eligible for honors (combined conditions)")
print()

# 6. Truthiness and Falsiness
print("6. TRUTHINESS AND FALSINESS")
print("-" * 60)
# Falsy values
if 0:
    print("0 is truthy")
else:
    print("0 is falsy")

if "":
    print("Empty string is truthy")
else:
    print("Empty string is falsy")

if []:
    print("Empty list is truthy")
else:
    print("Empty list is falsy")

# Truthy values
if 1:
    print("1 is truthy")

if "hello":
    print("Non-empty string is truthy")

if [1, 2, 3]:
    print("Non-empty list is truthy")

# Practical use
name = ""
if name:
    print(f"Hello, {name}")
else:
    print("Name is required")
print()

# 7. Grade Calculator
print("7. GRADE CALCULATOR")
print("-" * 60)
scores = [95, 85, 75, 65, 55]

for score in scores:
    if score >= 90:
        grade = "A"
        comment = "Excellent"
    elif score >= 80:
        grade = "B"
        comment = "Good"
    elif score >= 70:
        grade = "C"
        comment = "Average"
    elif score >= 60:
        grade = "D"
        comment = "Below Average"
    else:
        grade = "F"
        comment = "Fail"
    
    print(f"Score {score}: Grade {grade} ({comment})")
print()

# 8. Age Verification System
print("8. AGE VERIFICATION SYSTEM")
print("-" * 60)
ages = [16, 18, 21, 25, 65]

for age in ages:
    print(f"Age {age}:")
    if age >= 65:
        print("  - Senior discount eligible")
    if age >= 21:
        print("  - Can drink alcohol")
    if age >= 18:
        print("  - Can vote")
        print("  - Can drive (with license)")
    else:
        print("  - Minor")
    print()

# 9. Login System
print("9. LOGIN SYSTEM")
print("-" * 60)
username = "admin"
password = "secret123"
is_active = True

if username == "admin" and password == "secret123":
    if is_active:
        print("Login successful!")
        print("Welcome, admin!")
    else:
        print("Account is inactive")
else:
    print("Invalid username or password")
print()

# 10. Permission Checker
print("10. PERMISSION CHECKER")
print("-" * 60)
user_role = "editor"
action = "delete"

# Define permissions
permissions = {
    "admin": ["read", "write", "delete", "manage"],
    "editor": ["read", "write"],
    "viewer": ["read"]
}

user_perms = permissions.get(user_role, [])

if action in user_perms:
    print(f"User '{user_role}' has permission to '{action}'")
else:
    print(f"User '{user_role}' does NOT have permission to '{action}'")
print()

# 11. Ternary Operator
print("11. TERNARY OPERATOR")
print("-" * 60)
age = 20
status = "adult" if age >= 18 else "minor"
print(f"Age {age}: {status}")

score = 85
result = "Pass" if score >= 60 else "Fail"
print(f"Score {score}: {result}")

x = 10
y = 5
max_val = x if x > y else y
print(f"Max of {x} and {y}: {max_val}")
print()

# 12. Range Checking
print("12. RANGE CHECKING")
print("-" * 60)
values = [5, 15, 25, 35, 45]

for value in values:
    if 10 <= value <= 30:
        print(f"{value} is in range [10, 30]")
    else:
        print(f"{value} is NOT in range [10, 30]")
print()

# 13. Multiple Conditions
print("13. MULTIPLE CONDITIONS")
print("-" * 60)
username = "admin"
password = "secret123"
is_active = True
has_2fa = True

if username == "admin" and password == "secret123" and is_active:
    if has_2fa:
        print("Full access granted with 2FA")
    else:
        print("Access granted, but 2FA recommended")
else:
    print("Access denied")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
CONDITIONAL STATEMENTS PRACTICE
============================================================

1. BASIC IF STATEMENT
------------------------------------------------------------
Age 20: You are an adult

2. IF-ELSE STATEMENT
------------------------------------------------------------
Age 15: You are a minor

[... rest of output ...]
```

**Challenge** (Optional):
- Create a more complex decision tree
- Build a complete user management system
- Implement a game with conditional logic
- Create a recommendation system
- Build a data validation framework

---

## Key Takeaways

1. **if statements** execute code when a condition is True
2. **else clauses** provide alternative paths when conditions are False
3. **elif allows multiple conditions** to be checked in sequence
4. **Conditions are checked in order** - first True condition executes
5. **Nested conditionals** allow complex decision trees
6. **Truthiness and falsiness** - values evaluate to True/False in conditionals
7. **Logical operators** (`and`, `or`, `not`) combine conditions
8. **Ternary operator** provides concise conditional assignments
9. **Use proper indentation** - Python uses indentation to define blocks
10. **Avoid deep nesting** - use early returns or combine conditions when possible

---

## Quiz: Conditional Statements

Test your understanding with these questions:

1. **What keyword is used for additional conditions after if?**
   - A) `elseif`
   - B) `elif`
   - C) `else if`
   - D) `ifelse`

2. **What is required after the condition in an if statement?**
   - A) Semicolon
   - B) Colon
   - C) Comma
   - D) Nothing

3. **What happens if multiple elif conditions are True?**
   - A) All execute
   - B) First True condition executes
   - C) Last True condition executes
   - D) Error

4. **What is the result of `if []:`?**
   - A) True
   - B) False
   - C) Error
   - D) None

5. **What does `if x and y:` check?**
   - A) If x or y is True
   - B) If both x and y are True
   - C) If x is True
   - D) If y is True

6. **What is the output of: `x = 5; print("Yes" if x > 3 else "No")`?**
   - A) `Yes`
   - B) `No`
   - C) Error
   - D) `True`

7. **How many elif blocks can you have?**
   - A) 0
   - B) 1
   - C) Unlimited
   - D) 10

8. **What is the correct syntax for nested if?**
   - A) `if x: if y:`
   - B) `if x and y:`
   - C) `if x: if y: pass`
   - D) Both A and C

9. **What does `if not x:` check?**
   - A) If x is True
   - B) If x is False
   - C) If x exists
   - D) If x is None

10. **What is wrong with: `if x = 5:`?**
    - A) Nothing
    - B) Should use `==` instead of `=`
    - C) Missing colon
    - D) Missing indentation

**Answers**:
1. B) `elif` (else if in Python)
2. B) Colon (`:`) is required
3. B) First True condition executes (rest are skipped)
4. B) False (empty list is falsy)
5. B) If both x and y are True (and operator)
6. A) `Yes` (ternary operator, 5 > 3 is True)
7. C) Unlimited (can have as many as needed)
8. D) Both A and C (nested if syntax)
9. B) If x is False (not negates the condition)
10. B) Should use `==` instead of `=` (`=` is assignment, `==` is comparison)

---

## Next Steps

Excellent work! You've mastered conditional statements. You now understand:
- How to use if, elif, and else statements
- Nested conditionals
- Truthiness and falsiness
- Logical operators in conditionals
- Ternary operators
- Common patterns and best practices

**What's Next?**
- Lesson 5.2: Loops - For Loops
- Practice building programs with conditional logic
- Learn about loop control with conditionals
- Explore more advanced conditional patterns

---

## Additional Resources

- **Python Control Flow**: [docs.python.org/3/tutorial/controlflow.html](https://docs.python.org/3/tutorial/controlflow.html)
- **Truth Value Testing**: [docs.python.org/3/library/stdtypes.html#truth-value-testing](https://docs.python.org/3/library/stdtypes.html#truth-value-testing)
- **PEP 8 Style Guide**: [pep8.org](https://pep8.org/) (for conditional formatting)

---

*Lesson completed! You're ready to move on to the next lesson.*

