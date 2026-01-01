# Lesson 2.3: Assignment Operators

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the basic assignment operator (=)
- Use augmented assignment operators (+=, -=, *=, /=, etc.)
- Recognize when to use augmented assignment vs regular assignment
- Understand multiple assignment and tuple unpacking
- Use assignment operators in loops and accumulators
- Apply assignment operators in practical programming scenarios
- Avoid common mistakes with assignment operators

---

## Introduction to Assignment Operators

Assignment operators are used to assign values to variables. Python provides the basic assignment operator (`=`) and several augmented assignment operators that combine an operation with assignment.

### Assignment Operators Overview

| Operator | Name | Example | Equivalent To |
|----------|------|---------|---------------|
| `=` | Assignment | `x = 5` | `x = 5` |
| `+=` | Add and assign | `x += 3` | `x = x + 3` |
| `-=` | Subtract and assign | `x -= 3` | `x = x - 3` |
| `*=` | Multiply and assign | `x *= 3` | `x = x * 3` |
| `/=` | Divide and assign | `x /= 3` | `x = x / 3` |
| `//=` | Floor divide and assign | `x //= 3` | `x = x // 3` |
| `%=` | Modulo and assign | `x %= 3` | `x = x % 3` |
| `**=` | Exponentiate and assign | `x **= 3` | `x = x ** 3` |

---

## Basic Assignment (=)

The basic assignment operator (`=`) assigns a value to a variable.

### Simple Assignment

```python
# Assigning a value to a variable
x = 10
name = "Alice"
is_active = True

print(x)        # Output: 10
print(name)     # Output: Alice
print(is_active)  # Output: True
```

### Multiple Assignment

Python allows multiple assignments in several ways:

**1. Multiple variables, same value**:
```python
# All three variables get the same value
x = y = z = 0
print(x, y, z)  # Output: 0 0 0

# Useful for initialization
count = total = sum = 0
```

**2. Multiple variables, different values** (tuple unpacking):
```python
# Assign different values to different variables
x, y, z = 1, 2, 3
print(x, y, z)  # Output: 1 2 3

# Can use with any sequence
a, b, c = [10, 20, 30]
print(a, b, c)  # Output: 10 20 30

# String unpacking
first, second, third = "ABC"
print(first, second, third)  # Output: A B C
```

**3. Swapping variables** (Python makes this easy!):
```python
# Traditional way (in other languages, needs a temp variable)
a = 5
b = 10
temp = a
a = b
b = temp
print(a, b)  # Output: 10 5

# Python way (elegant!)
a = 5
b = 10
a, b = b, a  # Swap in one line!
print(a, b)  # Output: 10 5
```

### Assignment Examples

```python
# Initializing variables
counter = 0
total = 0.0
name = ""
is_valid = False

# Assigning from calculations
result = 10 + 5 * 2
print(result)  # Output: 20

# Assigning from function calls (we'll learn functions later)
length = len("Hello")
print(length)  # Output: 5
```

---

## Augmented Assignment Operators

Augmented assignment operators combine an operation with assignment. They are more concise and often more efficient than writing the full expression.

### Add and Assign (+=)

The `+=` operator adds the right operand to the left operand and assigns the result to the left operand.

```python
# Basic usage
x = 10
x += 5  # Equivalent to: x = x + 5
print(x)  # Output: 15

# With different types
count = 0
count += 1  # Increment by 1
count += 1
print(count)  # Output: 2

# With strings (concatenation)
message = "Hello"
message += " World"
print(message)  # Output: "Hello World"

# With lists (extends the list)
numbers = [1, 2, 3]
numbers += [4, 5]  # Equivalent to: numbers.extend([4, 5])
print(numbers)  # Output: [1, 2, 3, 4, 5]
```

### Subtract and Assign (-=)

The `-=` operator subtracts the right operand from the left operand.

```python
# Basic usage
x = 10
x -= 3  # Equivalent to: x = x - 3
print(x)  # Output: 7

# Decrementing
counter = 10
counter -= 1  # Decrement by 1
print(counter)  # Output: 9

# Practical example
balance = 1000
withdrawal = 250
balance -= withdrawal
print(f"Remaining balance: ${balance}")  # Output: Remaining balance: $750
```

### Multiply and Assign (*=)

The `*=` operator multiplies the left operand by the right operand.

```python
# Basic usage
x = 5
x *= 3  # Equivalent to: x = x * 3
print(x)  # Output: 15

# Accumulating products
total = 1
total *= 2
total *= 3
total *= 4
print(total)  # Output: 24 (1 * 2 * 3 * 4)

# With strings (repetition)
pattern = "*"
pattern *= 5
print(pattern)  # Output: "*****"
```

### Divide and Assign (/=)

The `/=` operator divides the left operand by the right operand.

```python
# Basic usage
x = 15
x /= 3  # Equivalent to: x = x / 3
print(x)  # Output: 5.0 (always returns float)

# Calculating average
total = 100
count = 4
average = total / count  # 25.0
# Or using /=
total /= count
print(total)  # Output: 25.0
```

### Floor Divide and Assign (//=)

The `//=` operator performs floor division and assigns the result.

```python
# Basic usage
x = 17
x //= 5  # Equivalent to: x = x // 5
print(x)  # Output: 3

# Converting to integer part
value = 15.7
value //= 1
print(value)  # Output: 15.0
```

### Modulo and Assign (%=)

The `%=` operator performs modulo operation and assigns the result.

```python
# Basic usage
x = 17
x %= 5  # Equivalent to: x = x % 5
print(x)  # Output: 2

# Keeping value in range
value = 25
value %= 24  # Keep within 0-23 range
print(value)  # Output: 1
```

### Exponentiate and Assign (**=)

The `**=` operator raises the left operand to the power of the right operand.

```python
# Basic usage
x = 2
x **= 3  # Equivalent to: x = x ** 3
print(x)  # Output: 8

# Calculating powers
base = 2
base **= 10  # 2^10
print(base)  # Output: 1024
```

---

## When to Use Augmented Assignment

### Advantages of Augmented Assignment

1. **More concise**: Shorter and cleaner code
2. **More readable**: Clearer intent
3. **Potentially more efficient**: Python can optimize these operations
4. **Less error-prone**: Variable name appears only once

### Comparison: Regular vs Augmented Assignment

```python
# Regular assignment
x = 10
x = x + 5
x = x * 2
x = x - 3

# Augmented assignment (cleaner)
x = 10
x += 5
x *= 2
x -= 3

# Both produce the same result, but augmented is more concise
```

### Common Use Cases

**1. Counters and Accumulators**:
```python
# Counting
count = 0
for i in range(10):
    count += 1
print(count)  # Output: 10

# Summing
total = 0
numbers = [1, 2, 3, 4, 5]
for num in numbers:
    total += num
print(total)  # Output: 15
```

**2. String Building**:
```python
# Building a string
message = ""
message += "Hello"
message += " "
message += "World"
print(message)  # Output: "Hello World"

# Note: For many concatenations, using a list and join() is more efficient
```

**3. Updating Values**:
```python
# Updating a value
price = 100
price *= 1.1  # Increase by 10%
print(price)  # Output: 110.0

# Discount
price = 100
price *= 0.9  # Apply 10% discount
print(price)  # Output: 90.0
```

---

## Assignment in Loops

Assignment operators are commonly used in loops for accumulating values.

### Accumulating Sums

```python
# Sum of numbers
total = 0
for i in range(1, 11):
    total += i
print(f"Sum of 1 to 10: {total}")  # Output: Sum of 1 to 10: 55

# Sum of list elements
numbers = [10, 20, 30, 40, 50]
sum = 0
for num in numbers:
    sum += num
print(f"Sum: {sum}")  # Output: Sum: 150
```

### Counting Occurrences

```python
# Count even numbers
numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
even_count = 0
for num in numbers:
    if num % 2 == 0:
        even_count += 1
print(f"Even numbers: {even_count}")  # Output: Even numbers: 5
```

### Building Lists

```python
# Building a list (though list.append() is more common)
squares = []
for i in range(5):
    squares += [i ** 2]  # Adds single element
print(squares)  # Output: [0, 1, 4, 9, 16]

# More common approach
squares = []
for i in range(5):
    squares.append(i ** 2)
print(squares)  # Output: [0, 1, 4, 9, 16]
```

### Calculating Products

```python
# Product of numbers
product = 1
numbers = [2, 3, 4, 5]
for num in numbers:
    product *= num
print(f"Product: {product}")  # Output: Product: 120
```

---

## Advanced Assignment Patterns

### Chained Assignment

```python
# All variables point to the same object
a = b = c = []
a.append(1)
print(a, b, c)  # Output: [1] [1] [1] (all same list!)

# For immutable types, this is fine
x = y = z = 0
x += 1
print(x, y, z)  # Output: 1 0 0 (integers are immutable, so new object)
```

### Tuple Unpacking

```python
# Unpacking tuples
coordinates = (10, 20)
x, y = coordinates
print(x, y)  # Output: 10 20

# Function returns (we'll learn functions later)
def get_name_age():
    return "Alice", 25

name, age = get_name_age()
print(f"{name} is {age} years old")  # Output: Alice is 25 years old
```

### Extended Unpacking

```python
# Unpacking with * (advanced)
first, *middle, last = [1, 2, 3, 4, 5]
print(first)   # Output: 1
print(middle)  # Output: [2, 3, 4]
print(last)    # Output: 5

# Ignoring values with _
x, _, y = (1, 2, 3)
print(x, y)  # Output: 1 3 (ignored the middle value)
```

### Conditional Assignment

```python
# Using ternary operator for conditional assignment
age = 20
status = "adult" if age >= 18 else "minor"
print(status)  # Output: adult

# Setting default values
value = None
result = value or "default"
print(result)  # Output: default
```

---

## Common Patterns and Use Cases

### 1. Incrementing and Decrementing

```python
# Increment
counter = 0
counter += 1  # Most common pattern
counter += 1
print(counter)  # Output: 2

# Decrement
countdown = 10
countdown -= 1
print(countdown)  # Output: 9
```

### 2. Accumulating Values

```python
# Sum accumulator
total = 0
for i in range(1, 6):
    total += i
print(total)  # Output: 15

# Product accumulator
product = 1
for i in range(1, 6):
    product *= i
print(product)  # Output: 120 (5!)
```

### 3. Updating Percentages

```python
# Increase by percentage
price = 100
price *= 1.15  # Increase by 15%
print(price)  # Output: 115.0

# Decrease by percentage
price = 100
price *= 0.85  # Decrease by 15%
print(price)  # Output: 85.0
```

### 4. String Building

```python
# Building strings
output = ""
output += "Line 1\n"
output += "Line 2\n"
output += "Line 3\n"
print(output)
# Output:
# Line 1
# Line 2
# Line 3
```

### 5. Modulo for Wrapping

```python
# Keeping values in range
index = 10
index %= 5  # Wrap to 0-4 range
print(index)  # Output: 0

# Clock arithmetic
hour = 14
hour %= 12
if hour == 0:
    hour = 12
print(f"{hour}:00")  # Output: 2:00
```

---

## Common Mistakes and Pitfalls

### 1. Confusing = with ==

```python
# Wrong - this is assignment, not comparison
# if x = 5:  # SyntaxError!

# Correct
if x == 5:
    pass
```

### 2. Chained Assignment with Mutable Objects

```python
# Be careful with mutable objects
a = b = []  # Both point to the same list
a.append(1)
print(b)  # Output: [1] (b is also affected!)

# Better approach
a = []
b = []
a.append(1)
print(b)  # Output: [] (b is independent)
```

### 3. Augmented Assignment with Different Types

```python
# Works fine
x = 10
x += 5  # x is now 15

# But be careful with type changes
x = 10
x /= 2  # x is now 5.0 (changed from int to float)
print(type(x))  # <class 'float'>
```

### 4. Augmented Assignment Order

```python
# Augmented assignment happens after the operation
x = 5
x += 3 * 2  # x = x + (3 * 2) = 5 + 6 = 11
print(x)  # Output: 11

# Not: x = (x + 3) * 2 = 16
```

### 5. Using += with Strings (Performance)

```python
# For many concatenations, this is inefficient
result = ""
for i in range(1000):
    result += str(i)  # Creates new string each time

# Better approach
result = "".join(str(i) for i in range(1000))
```

---

## Practice Exercise

### Exercise: Assignment Operators Practice

**Objective**: Create a Python program that demonstrates the use of various assignment operators in practical scenarios.

**Instructions**:

1. Create a file called `assignment_practice.py`

2. Write a program that:
   - Uses basic assignment
   - Demonstrates all augmented assignment operators
   - Uses assignment in loops for accumulation
   - Shows multiple assignment and swapping
   - Implements practical calculations

3. Your program should include:
   - Counter and accumulator examples
   - Percentage calculations
   - String building
   - List operations
   - Practical business logic

**Example Solution**:

```python
"""
Assignment Operators Practice
This program demonstrates the use of assignment operators
in various practical scenarios.
"""

print("=" * 60)
print("ASSIGNMENT OPERATORS PRACTICE")
print("=" * 60)
print()

# 1. Basic Assignment
print("1. BASIC ASSIGNMENT")
print("-" * 60)
x = 10
y = 20
z = 30
print(f"Initial values: x={x}, y={y}, z={z}")

# Multiple assignment
a = b = c = 0
print(f"Multiple assignment: a={a}, b={b}, c={c}")

# Tuple unpacking
x, y, z = 1, 2, 3
print(f"Tuple unpacking: x={x}, y={y}, z={z}")
print()

# 2. Swapping Variables
print("2. SWAPPING VARIABLES")
print("-" * 60)
a = 5
b = 10
print(f"Before swap: a={a}, b={b}")
a, b = b, a
print(f"After swap: a={a}, b={b}")
print()

# 3. Augmented Assignment Operators
print("3. AUGMENTED ASSIGNMENT OPERATORS")
print("-" * 60)
x = 10
print(f"Initial x = {x}")

x += 5
print(f"After x += 5: x = {x}")

x -= 3
print(f"After x -= 3: x = {x}")

x *= 2
print(f"After x *= 2: x = {x}")

x /= 4
print(f"After x /= 4: x = {x}")

x = 17
x //= 5
print(f"After x //= 5: x = {x}")

x = 17
x %= 5
print(f"After x %= 5: x = {x}")

x = 2
x **= 3
print(f"After x **= 3: x = {x}")
print()

# 4. Counters and Accumulators
print("4. COUNTERS AND ACCUMULATORS")
print("-" * 60)

# Counter
count = 0
for i in range(10):
    count += 1
print(f"Count from 0 to 9: {count}")

# Sum accumulator
total = 0
numbers = [10, 20, 30, 40, 50]
for num in numbers:
    total += num
print(f"Sum of {numbers}: {total}")

# Product accumulator
product = 1
for i in range(1, 6):
    product *= i
print(f"Product of 1 to 5: {product} (5!)")
print()

# 5. Percentage Calculations
print("5. PERCENTAGE CALCULATIONS")
print("-" * 60)
price = 100.0
print(f"Original price: ${price:.2f}")

# Increase by 20%
price *= 1.20
print(f"After 20% increase: ${price:.2f}")

# Decrease by 15%
price *= 0.85
print(f"After 15% decrease: ${price:.2f}")

# Reset and apply multiple discounts
price = 100.0
price *= 0.9   # 10% off
price *= 0.95  # Additional 5% off
print(f"After 10% + 5% discounts: ${price:.2f}")
print()

# 6. String Building
print("6. STRING BUILDING")
print("-" * 60)
message = ""
message += "Hello"
message += " "
message += "World"
message += "!"
print(f"Built message: '{message}'")

# Building formatted output
output = ""
output += "Name: Alice\n"
output += "Age: 25\n"
output += "City: NYC\n"
print("Formatted output:")
print(output)
print()

# 7. List Operations
print("7. LIST OPERATIONS")
print("-" * 60)
numbers = [1, 2, 3]
print(f"Initial list: {numbers}")

numbers += [4, 5]  # Extend list
print(f"After += [4, 5]: {numbers}")

numbers *= 2  # Repeat list
print(f"After *= 2: {numbers}")
print()

# 8. Modulo for Wrapping
print("8. MODULO FOR WRAPPING")
print("-" * 60)
# Clock arithmetic
hour = 14
print(f"24-hour format: {hour}:00")
hour %= 12
if hour == 0:
    hour = 12
print(f"12-hour format: {hour}:00")

# Array index wrapping
index = 7
array_length = 5
index %= array_length
print(f"Wrapped index: {index} (for array of length {array_length})")
print()

# 9. Practical Example: Shopping Cart
print("9. PRACTICAL EXAMPLE: SHOPPING CART")
print("-" * 60)
cart_total = 0.0
items = [
    {"name": "Apple", "price": 1.50, "quantity": 3},
    {"name": "Banana", "price": 0.75, "quantity": 5},
    {"name": "Orange", "price": 2.00, "quantity": 2},
]

print("Shopping Cart:")
for item in items:
    item_total = item["price"] * item["quantity"]
    cart_total += item_total
    print(f"  {item['name']}: ${item['price']:.2f} x {item['quantity']} = ${item_total:.2f}")

print(f"\nSubtotal: ${cart_total:.2f}")

# Apply tax
tax_rate = 0.08
tax = cart_total * tax_rate
cart_total += tax
print(f"Tax (8%): ${tax:.2f}")
print(f"Total: ${cart_total:.2f}")
print()

# 10. Accumulating Statistics
print("10. ACCUMULATING STATISTICS")
print("-" * 60)
scores = [85, 92, 78, 96, 88, 91, 87]
total = 0
count = 0
max_score = scores[0]
min_score = scores[0]

for score in scores:
    total += score
    count += 1
    if score > max_score:
        max_score = score
    if score < min_score:
        min_score = score

average = total / count
print(f"Scores: {scores}")
print(f"Count: {count}")
print(f"Total: {total}")
print(f"Average: {average:.2f}")
print(f"Maximum: {max_score}")
print(f"Minimum: {min_score}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
ASSIGNMENT OPERATORS PRACTICE
============================================================

1. BASIC ASSIGNMENT
------------------------------------------------------------
Initial values: x=10, y=20, z=30
Multiple assignment: a=0, b=0, c=0
Tuple unpacking: x=1, y=2, z=3

2. SWAPPING VARIABLES
------------------------------------------------------------
Before swap: a=5, b=10
After swap: a=10, b=5

[... rest of output ...]
```

**Challenge** (Optional):
- Create a grade calculator that accumulates points
- Build a budget tracker that updates balances
- Implement a game score system
- Create a data aggregator for statistics
- Build a text formatter using string assignment

---

## Key Takeaways

1. **Basic assignment (`=`)** assigns values to variables
2. **Augmented assignment operators** combine operation and assignment (`+=`, `-=`, `*=`, etc.)
3. **Augmented assignment is more concise** than regular assignment
4. **Multiple assignment** allows assigning same or different values to multiple variables
5. **Tuple unpacking** enables elegant variable swapping and multiple assignments
6. **Assignment in loops** is essential for accumulators and counters
7. **Augmented assignment works with** numbers, strings, and lists (with appropriate operators)
8. **Be careful with mutable objects** in chained assignments
9. **Augmented assignment is evaluated** after the operation (respects precedence)
10. **Use augmented assignment** for cleaner, more readable code

---

## Quiz: Assignment Operators

Test your understanding with these questions:

1. **What is the result after: `x = 5; x += 3`?**
   - A) `5`
   - B) `8`
   - C) `15`
   - D) Error

2. **What is the equivalent of `x *= 2`?**
   - A) `x = 2`
   - B) `x = x * 2`
   - C) `x = 2 * x`
   - D) `x = x + 2`

3. **What is the result of: `a, b = 1, 2`?**
   - A) `a = 1, b = 2`
   - B) `a = (1, 2), b = None`
   - C) Error
   - D) `a = 1, b = 1`

4. **What happens with: `x = 10; x /= 2`?**
   - A) `x` becomes `5`
   - B) `x` becomes `5.0`
   - C) `x` becomes `2`
   - D) Error

5. **What is the result of: `x = 17; x %= 5`?**
   - A) `2`
   - B) `3`
   - C) `5`
   - D) `17`

6. **What is the result of: `a = b = []` followed by `a.append(1)`?**
   - A) `a = [1], b = []`
   - B) `a = [1], b = [1]`
   - C) Error
   - D) `a = [], b = [1]`

7. **What is the equivalent of `x **= 3`?**
   - A) `x = 3`
   - B) `x = x ** 3`
   - C) `x = 3 ** x`
   - D) `x = x * 3`

8. **What is the result of: `x = 5; x += 3 * 2`?**
   - A) `11`
   - B) `16`
   - C) `13`
   - D) `10`

9. **How do you swap two variables `a` and `b` in Python?**
   - A) `a = b; b = a`
   - B) `a, b = b, a`
   - C) `swap(a, b)`
   - D) `a = b`

10. **What is the result of: `message = ""; message += "Hello"; message += " World"`?**
    - A) `"Hello World"`
    - B) `"Hello"`
    - C) `" World"`
    - D) Error

**Answers**:
1. B) `8` (5 + 3 = 8)
2. B) `x = x * 2` (multiply and assign)
3. A) `a = 1, b = 2` (tuple unpacking)
4. B) `x` becomes `5.0` (division always returns float)
5. A) `2` (17 % 5 = 2)
6. B) `a = [1], b = [1]` (both point to same list object)
7. B) `x = x ** 3` (exponentiate and assign)
8. A) `11` (5 + (3 * 2) = 5 + 6 = 11)
9. B) `a, b = b, a` (Python's elegant swap)
10. A) `"Hello World"` (string concatenation)

---

## Next Steps

Excellent work! You've mastered assignment operators. You now understand:
- Basic and augmented assignment operators
- Multiple assignment and tuple unpacking
- Using assignment in loops and accumulators
- Practical applications and patterns
- Common pitfalls to avoid

**What's Next?**
- Module 3: Data Structures - Lists and Tuples
- Lesson 5.1: Conditional Statements (if, elif, else)
- Practice building programs that use assignment operators
- Learn about variable scope and lifetime

---

## Additional Resources

- **Assignment Statements**: [docs.python.org/3/reference/simple_stmts.html#assignment-statements](https://docs.python.org/3/reference/simple_stmts.html#assignment-statements)
- **Augmented Assignment**: [docs.python.org/3/reference/simple_stmts.html#augmented-assignment-statements](https://docs.python.org/3/reference/simple_stmts.html#augmented-assignment-statements)
- **PEP 8 Style Guide**: [pep8.org](https://pep8.org/) (for assignment style guidelines)

---

*Lesson completed! You're ready to move on to the next lesson.*

