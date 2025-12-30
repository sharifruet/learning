# Lesson 2.1: Arithmetic Operators

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand and use all Python arithmetic operators
- Perform basic mathematical operations (addition, subtraction, multiplication, division)
- Use advanced operators (modulo, floor division, exponentiation)
- Understand operator precedence and associativity
- Apply arithmetic operations in practical scenarios
- Handle common arithmetic errors and edge cases
- Build a simple calculator program

---

## Introduction to Arithmetic Operators

Arithmetic operators are symbols used to perform mathematical operations on numbers. Python provides a comprehensive set of arithmetic operators that work with integers, floats, and complex numbers.

### Basic Arithmetic Operators

Python supports the following arithmetic operators:

| Operator | Name | Example | Result |
|----------|------|---------|--------|
| `+` | Addition | `5 + 3` | `8` |
| `-` | Subtraction | `5 - 3` | `2` |
| `*` | Multiplication | `5 * 3` | `15` |
| `/` | Division | `5 / 3` | `1.666...` |
| `//` | Floor Division | `5 // 3` | `1` |
| `%` | Modulo (Remainder) | `5 % 3` | `2` |
| `**` | Exponentiation | `5 ** 3` | `125` |

---

## Addition (+)

The addition operator adds two numbers together.

### Basic Addition

```python
# Integer addition
result = 5 + 3
print(result)  # Output: 8

# Float addition
result = 3.14 + 2.86
print(result)  # Output: 6.0

# Mixed types (int + float)
result = 5 + 3.14
print(result)  # Output: 8.14 (int is converted to float)
```

### Addition with Variables

```python
a = 10
b = 20
sum = a + b
print(sum)  # Output: 30

# Multiple additions
total = 5 + 10 + 15 + 20
print(total)  # Output: 50
```

### String Concatenation (Special Case)

The `+` operator also concatenates strings (though this isn't arithmetic):

```python
# String concatenation
first_name = "Alice"
last_name = "Smith"
full_name = first_name + " " + last_name
print(full_name)  # Output: "Alice Smith"
```

### Addition Examples

```python
# Calculating totals
price1 = 19.99
price2 = 29.99
price3 = 15.50
total = price1 + price2 + price3
print(f"Total: ${total:.2f}")  # Output: Total: $65.48

# Adding to existing value
count = 5
count = count + 3  # count is now 8
print(count)  # Output: 8

# Shorthand (augmented assignment - covered later)
count += 3  # Same as count = count + 3
print(count)  # Output: 11
```

---

## Subtraction (-)

The subtraction operator subtracts the right operand from the left operand.

### Basic Subtraction

```python
# Integer subtraction
result = 10 - 4
print(result)  # Output: 6

# Float subtraction
result = 10.5 - 3.2
print(result)  # Output: 7.3

# Negative results
result = 5 - 10
print(result)  # Output: -5
```

### Subtraction with Variables

```python
balance = 1000
withdrawal = 250
remaining = balance - withdrawal
print(f"Remaining balance: ${remaining}")  # Output: Remaining balance: $750

# Multiple subtractions
total = 100 - 10 - 20 - 30
print(total)  # Output: 40
```

### Subtraction Examples

```python
# Temperature difference
high_temp = 85
low_temp = 65
difference = high_temp - low_temp
print(f"Temperature difference: {difference}°F")  # Output: Temperature difference: 20°F

# Age calculation
current_year = 2024
birth_year = 1999
age = current_year - birth_year
print(f"Age: {age} years")  # Output: Age: 25 years

# Distance calculation
start_mile = 100
end_mile = 150
distance = end_mile - start_mile
print(f"Distance traveled: {distance} miles")  # Output: Distance traveled: 50 miles
```

---

## Multiplication (*)

The multiplication operator multiplies two numbers.

### Basic Multiplication

```python
# Integer multiplication
result = 5 * 3
print(result)  # Output: 15

# Float multiplication
result = 2.5 * 4
print(result)  # Output: 10.0

# Mixed types
result = 3 * 2.5
print(result)  # Output: 7.5
```

### Multiplication with Variables

```python
quantity = 5
price_per_unit = 12.99
total_cost = quantity * price_per_unit
print(f"Total cost: ${total_cost:.2f}")  # Output: Total cost: $64.95
```

### String Repetition (Special Case)

The `*` operator can also repeat strings:

```python
# String repetition
greeting = "Hello! " * 3
print(greeting)  # Output: "Hello! Hello! Hello! "

# Creating patterns
separator = "-" * 50
print(separator)  # Output: "--------------------------------------------------"
```

### Multiplication Examples

```python
# Area calculation
length = 10
width = 5
area = length * width
print(f"Area: {area} square units")  # Output: Area: 50 square units

# Compound interest (simplified)
principal = 1000
rate = 0.05
years = 3
# Simple interest calculation
interest = principal * rate * years
print(f"Interest: ${interest}")  # Output: Interest: $150.0

# Multiple multiplications
result = 2 * 3 * 4 * 5
print(result)  # Output: 120
```

---

## Division (/)

The division operator divides the left operand by the right operand. **Important**: Division always returns a float, even when dividing two integers.

### Basic Division

```python
# Integer division (returns float!)
result = 10 / 2
print(result)  # Output: 5.0 (not 5!)
print(type(result))  # <class 'float'>

# Float division
result = 15.0 / 4.0
print(result)  # Output: 3.75

# Mixed types
result = 10 / 3
print(result)  # Output: 3.3333333333333335
```

### Division Examples

```python
# Average calculation
scores = [85, 90, 78, 92, 88]
total = sum(scores)  # We'll learn sum() later
average = total / len(scores)  # len() returns the count
print(f"Average score: {average}")  # Output: Average score: 86.6

# Unit price calculation
total_price = 24.99
quantity = 3
unit_price = total_price / quantity
print(f"Unit price: ${unit_price:.2f}")  # Output: Unit price: $8.33

# Speed calculation
distance = 120  # miles
time = 2  # hours
speed = distance / time
print(f"Speed: {speed} mph")  # Output: Speed: 60.0 mph
```

### Division by Zero

**Important**: Dividing by zero causes a `ZeroDivisionError`:

```python
# This will cause an error
# result = 10 / 0  # ZeroDivisionError: division by zero

# Safe division
def safe_divide(a, b):
    if b == 0:
        return "Cannot divide by zero"
    return a / b

print(safe_divide(10, 2))  # Output: 5.0
print(safe_divide(10, 0))  # Output: Cannot divide by zero
```

### Precision in Division

Floating-point division can have precision issues:

```python
result = 1 / 3
print(result)  # Output: 0.3333333333333333

# For precise decimal arithmetic, use the decimal module
from decimal import Decimal
precise = Decimal('1') / Decimal('3')
print(precise)  # Output: 0.3333333333333333333333333333
```

---

## Floor Division (//)

Floor division (also called integer division) divides and rounds down to the nearest integer. It returns an integer when both operands are integers, otherwise a float.

### Basic Floor Division

```python
# Integer floor division (returns int)
result = 10 // 3
print(result)  # Output: 3 (not 3.333...)
print(type(result))  # <class 'int'>

# Float floor division (returns float)
result = 10.0 // 3.0
print(result)  # Output: 3.0
print(type(result))  # <class 'float'>

# Negative numbers (rounds down, which is more negative)
result = -10 // 3
print(result)  # Output: -4 (not -3!)
```

### Floor Division Examples

```python
# Converting hours to days
hours = 50
days = hours // 24
remaining_hours = hours % 24
print(f"{hours} hours = {days} days and {remaining_hours} hours")
# Output: 50 hours = 2 days and 2 hours

# Splitting items into groups
total_items = 25
items_per_group = 7
full_groups = total_items // items_per_group
print(f"Full groups: {full_groups}")  # Output: Full groups: 3

# Calculating pages needed
items_per_page = 10
total_items = 47
pages_needed = (total_items + items_per_page - 1) // items_per_page
print(f"Pages needed: {pages_needed}")  # Output: Pages needed: 5
```

### Floor Division vs Regular Division

```python
# Regular division
result1 = 10 / 3
print(result1)  # Output: 3.3333333333333335

# Floor division
result2 = 10 // 3
print(result2)  # Output: 3

# When you need the integer part
value = 15.7
integer_part = value // 1
print(integer_part)  # Output: 15.0
```

---

## Modulo (%)

The modulo operator returns the remainder after division. It's extremely useful for many programming tasks.

### Basic Modulo

```python
# Integer modulo
result = 10 % 3
print(result)  # Output: 2 (10 divided by 3 is 3 with remainder 2)

# Float modulo
result = 10.5 % 3.2
print(result)  # Output: 0.8999999999999995

# When numbers divide evenly
result = 10 % 5
print(result)  # Output: 0
```

### Modulo Examples

**1. Checking Even/Odd Numbers**:
```python
number = 7
if number % 2 == 0:
    print("Even")
else:
    print("Odd")  # Output: Odd

# Function to check if number is even
def is_even(n):
    return n % 2 == 0

print(is_even(4))   # Output: True
print(is_even(7))   # Output: False
```

**2. Extracting Digits**:
```python
# Get last digit
number = 12345
last_digit = number % 10
print(last_digit)  # Output: 5

# Get last two digits
last_two = number % 100
print(last_two)  # Output: 45
```

**3. Time Calculations**:
```python
# Converting seconds to hours, minutes, seconds
total_seconds = 3665
hours = total_seconds // 3600
minutes = (total_seconds % 3600) // 60
seconds = total_seconds % 60
print(f"{hours}h {minutes}m {seconds}s")  # Output: 1h 1m 5s
```

**4. Wrapping Values (Circular)**:
```python
# Clock arithmetic (12-hour format)
hour = 14
hour_12 = hour % 12
if hour_12 == 0:
    hour_12 = 12
print(f"{hour}:00 = {hour_12}:00")  # Output: 14:00 = 2:00

# Array indexing (wrapping around)
items = ['a', 'b', 'c', 'd']
index = 7
wrapped_index = index % len(items)
print(items[wrapped_index])  # Output: 'd'
```

**5. Checking Divisibility**:
```python
# Check if divisible by 3
number = 15
if number % 3 == 0:
    print(f"{number} is divisible by 3")  # Output: 15 is divisible by 3

# Check if divisible by both 3 and 5
if number % 3 == 0 and number % 5 == 0:
    print(f"{number} is divisible by both 3 and 5")  # Output: 15 is divisible by both 3 and 5
```

---

## Exponentiation (**)

The exponentiation operator raises the left operand to the power of the right operand.

### Basic Exponentiation

```python
# Integer exponentiation
result = 2 ** 3
print(result)  # Output: 8 (2 to the power of 3)

# Float exponentiation
result = 2.5 ** 2
print(result)  # Output: 6.25

# Negative exponents
result = 2 ** -2
print(result)  # Output: 0.25 (1 / 4)

# Fractional exponents (roots)
result = 16 ** 0.5
print(result)  # Output: 4.0 (square root of 16)

result = 8 ** (1/3)
print(result)  # Output: 2.0 (cube root of 8)
```

### Exponentiation Examples

**1. Powers of 2**:
```python
# Calculate powers of 2
for i in range(6):
    power = 2 ** i
    print(f"2^{i} = {power}")
# Output:
# 2^0 = 1
# 2^1 = 2
# 2^2 = 4
# 2^3 = 8
# 2^4 = 16
# 2^5 = 32
```

**2. Area and Volume Calculations**:
```python
# Area of a square
side = 5
area = side ** 2
print(f"Area: {area}")  # Output: Area: 25

# Volume of a cube
side = 3
volume = side ** 3
print(f"Volume: {volume}")  # Output: Volume: 27
```

**3. Scientific Calculations**:
```python
# Compound interest
principal = 1000
rate = 0.05
years = 10
amount = principal * (1 + rate) ** years
print(f"Amount after {years} years: ${amount:.2f}")
# Output: Amount after 10 years: $1628.89

# Distance formula (2D)
x1, y1 = 0, 0
x2, y2 = 3, 4
distance = ((x2 - x1) ** 2 + (y2 - y1) ** 2) ** 0.5
print(f"Distance: {distance}")  # Output: Distance: 5.0
```

**4. Large Numbers**:
```python
# Python handles large exponents
big_number = 2 ** 100
print(big_number)  # Output: 1267650600228229401496703205376

# Scientific notation for very large numbers
very_large = 10 ** 20
print(very_large)  # Output: 100000000000000000000
```

---

## Operator Precedence

When multiple operators appear in an expression, Python follows a specific order of operations (precedence). Operators with higher precedence are evaluated first.

### Precedence Order (Highest to Lowest)

1. **Parentheses** `()` - Highest precedence
2. **Exponentiation** `**`
3. **Multiplication, Division, Floor Division, Modulo** `*`, `/`, `//`, `%` (left to right)
4. **Addition, Subtraction** `+`, `-` (left to right)

### Examples of Precedence

```python
# Without parentheses
result = 2 + 3 * 4
print(result)  # Output: 14 (not 20!)
# Explanation: 3 * 4 = 12, then 2 + 12 = 14

# With parentheses
result = (2 + 3) * 4
print(result)  # Output: 20
# Explanation: (2 + 3) = 5, then 5 * 4 = 20

# Exponentiation has higher precedence than multiplication
result = 2 ** 3 * 4
print(result)  # Output: 32 (not 4096!)
# Explanation: 2 ** 3 = 8, then 8 * 4 = 32

# Multiple operations
result = 10 + 5 * 2 ** 3 - 4
print(result)  # Output: 46
# Explanation:
# 1. 2 ** 3 = 8
# 2. 5 * 8 = 40
# 3. 10 + 40 = 50
# 4. 50 - 4 = 46
```

### Using Parentheses for Clarity

Even when not strictly necessary, parentheses can make code more readable:

```python
# Less clear
result = a + b * c - d / e

# More clear
result = a + (b * c) - (d / e)

# Even better for complex expressions
result = (a + b) * (c - d) / e
```

### Associativity

When operators have the same precedence, they're evaluated left to right (left-associative):

```python
# Left to right for same precedence
result = 10 - 5 - 2
print(result)  # Output: 3
# Explanation: (10 - 5) - 2 = 5 - 2 = 3

# Exponentiation is right-associative
result = 2 ** 3 ** 2
print(result)  # Output: 512 (not 64!)
# Explanation: 2 ** (3 ** 2) = 2 ** 9 = 512
```

---

## Common Arithmetic Patterns

### 1. Incrementing and Decrementing

```python
# Increment
count = 5
count = count + 1
print(count)  # Output: 6

# Decrement
count = count - 1
print(count)  # Output: 5

# Shorthand (augmented assignment - covered in detail later)
count += 1  # Same as count = count + 1
count -= 1  # Same as count = count - 1
```

### 2. Calculating Percentages

```python
# Calculate percentage
part = 25
whole = 100
percentage = (part / whole) * 100
print(f"{percentage}%")  # Output: 25.0%

# Calculate part from percentage
whole = 200
percentage = 15
part = (percentage / 100) * whole
print(f"{percentage}% of {whole} is {part}")  # Output: 15% of 200 is 30.0
```

### 3. Rounding and Truncation

```python
# Rounding (using round() function)
value = 3.14159
rounded = round(value, 2)
print(rounded)  # Output: 3.14

# Truncation using floor division
value = 3.99
truncated = value // 1
print(truncated)  # Output: 3.0
```

### 4. Converting Between Units

```python
# Temperature: Celsius to Fahrenheit
celsius = 25
fahrenheit = (celsius * 9/5) + 32
print(f"{celsius}°C = {fahrenheit}°F")  # Output: 25°C = 77.0°F

# Distance: kilometers to miles
km = 100
miles = km * 0.621371
print(f"{km} km = {miles:.2f} miles")  # Output: 100 km = 62.14 miles
```

---

## Practice Exercise

### Exercise: Calculator Program

**Objective**: Create a Python program that performs various arithmetic operations and demonstrates understanding of operator precedence.

**Instructions**:

1. Create a file called `calculator.py`

2. Write a program that:
   - Performs basic arithmetic operations (+, -, *, /)
   - Uses floor division and modulo
   - Demonstrates exponentiation
   - Shows operator precedence
   - Calculates practical values (area, volume, percentages, etc.)

3. Your program should include:
   - Variable assignments with meaningful names
   - Multiple calculations
   - Formatted output using f-strings
   - Comments explaining the operations

**Example Solution**:

```python
"""
Arithmetic Operators Practice - Calculator Program
This program demonstrates various arithmetic operations
and their practical applications.
"""

print("=" * 60)
print("ARITHMETIC OPERATORS CALCULATOR")
print("=" * 60)
print()

# Basic Operations
print("1. BASIC OPERATIONS")
print("-" * 60)
a = 15
b = 4

print(f"a = {a}, b = {b}")
print(f"Addition: {a} + {b} = {a + b}")
print(f"Subtraction: {a} - {b} = {a - b}")
print(f"Multiplication: {a} * {b} = {a * b}")
print(f"Division: {a} / {b} = {a / b}")
print(f"Floor Division: {a} // {b} = {a // b}")
print(f"Modulo: {a} % {b} = {a % b}")
print(f"Exponentiation: {a} ** {b} = {a ** b}")
print()

# Operator Precedence
print("2. OPERATOR PRECEDENCE")
print("-" * 60)
result1 = 2 + 3 * 4
result2 = (2 + 3) * 4
result3 = 2 ** 3 * 4
result4 = 10 + 5 * 2 ** 3 - 4

print(f"2 + 3 * 4 = {result1} (multiplication first)")
print(f"(2 + 3) * 4 = {result2} (parentheses first)")
print(f"2 ** 3 * 4 = {result3} (exponentiation first)")
print(f"10 + 5 * 2 ** 3 - 4 = {result4}")
print()

# Practical Calculations
print("3. PRACTICAL CALCULATIONS")
print("-" * 60)

# Area of a rectangle
length = 12.5
width = 8.3
area = length * width
print(f"Rectangle: length={length}, width={width}")
print(f"Area = {length} * {width} = {area:.2f} square units")
print()

# Circle calculations
radius = 5
pi = 3.14159
circumference = 2 * pi * radius
area_circle = pi * radius ** 2
print(f"Circle: radius={radius}")
print(f"Circumference = 2 * π * {radius} = {circumference:.2f}")
print(f"Area = π * {radius}² = {area_circle:.2f}")
print()

# Percentage calculations
total_students = 120
passed = 96
pass_percentage = (passed / total_students) * 100
print(f"Students: {passed} passed out of {total_students}")
print(f"Pass percentage = ({passed}/{total_students}) * 100 = {pass_percentage:.1f}%")
print()

# Time calculations
total_seconds = 3665
hours = total_seconds // 3600
minutes = (total_seconds % 3600) // 60
seconds = total_seconds % 60
print(f"Time: {total_seconds} seconds")
print(f"= {hours} hours, {minutes} minutes, {seconds} seconds")
print()

# Even/Odd check
print("4. EVEN/ODD CHECK")
print("-" * 60)
numbers = [7, 12, 15, 20, 23]
for num in numbers:
    if num % 2 == 0:
        print(f"{num} is even")
    else:
        print(f"{num} is odd")
print()

# Powers of 2
print("5. POWERS OF 2")
print("-" * 60)
for i in range(6):
    power = 2 ** i
    print(f"2^{i} = {power}")
print()

# Compound calculation
print("6. COMPOUND CALCULATION")
print("-" * 60)
principal = 1000
rate = 0.05
years = 5
amount = principal * (1 + rate) ** years
interest = amount - principal
print(f"Principal: ${principal}")
print(f"Rate: {rate * 100}% per year")
print(f"Years: {years}")
print(f"Final amount: ${amount:.2f}")
print(f"Interest earned: ${interest:.2f}")
print()

print("=" * 60)
print("CALCULATIONS COMPLETE!")
print("=" * 60)
```

**Expected Output**:
```
============================================================
ARITHMETIC OPERATORS CALCULATOR
============================================================

1. BASIC OPERATIONS
------------------------------------------------------------
a = 15, b = 4
Addition: 15 + 4 = 19
Subtraction: 15 - 4 = 11
Multiplication: 15 * 4 = 60
Division: 15 / 4 = 3.75
Floor Division: 15 // 4 = 3
Modulo: 15 % 4 = 3
Exponentiation: 15 ** 4 = 50625

2. OPERATOR PRECEDENCE
------------------------------------------------------------
2 + 3 * 4 = 14 (multiplication first)
(2 + 3) * 4 = 20 (parentheses first)
2 ** 3 * 4 = 32 (exponentiation first)
10 + 5 * 2 ** 3 - 4 = 46

3. PRACTICAL CALCULATIONS
------------------------------------------------------------
Rectangle: length=12.5, width=8.3
Area = 12.5 * 8.3 = 103.75 square units

Circle: radius=5
Circumference = 2 * π * 5 = 31.42
Area = π * 5² = 78.54

Students: 96 passed out of 120
Pass percentage = (96/120) * 100 = 80.0%

Time: 3665 seconds
= 1 hours, 1 minutes, 5 seconds

4. EVEN/ODD CHECK
------------------------------------------------------------
7 is odd
12 is even
15 is odd
20 is even
23 is odd

5. POWERS OF 2
------------------------------------------------------------
2^0 = 1
2^1 = 2
2^2 = 4
2^3 = 8
2^4 = 16
2^5 = 32

6. COMPOUND CALCULATION
------------------------------------------------------------
Principal: $1000
Rate: 5.0% per year
Years: 5
Final amount: $1276.28
Interest earned: $276.28

============================================================
CALCULATIONS COMPLETE!
============================================================
```

**Challenge** (Optional):
- Add input from the user to make it interactive
- Create functions for each calculation type
- Add more practical calculations (BMI, currency conversion, etc.)
- Handle division by zero errors
- Format numbers with thousands separators

---

## Key Takeaways

1. **Arithmetic operators** perform mathematical operations: `+`, `-`, `*`, `/`, `//`, `%`, `**`
2. **Division (`/`)** always returns a float, even when dividing integers
3. **Floor division (`//`)** returns the integer part (or float if operands are floats)
4. **Modulo (`%`)** returns the remainder and is useful for many programming tasks
5. **Exponentiation (`**`)** raises a number to a power
6. **Operator precedence** determines the order of operations (parentheses > exponentiation > multiplication/division > addition/subtraction)
7. **Use parentheses** to clarify and control the order of operations
8. **Division by zero** causes a `ZeroDivisionError` - always check for this
9. **Floating-point arithmetic** can have precision issues - be aware when comparing floats
10. **Arithmetic operators** work with integers, floats, and complex numbers

---

## Quiz: Arithmetic Operations

Test your understanding with these questions:

1. **What is the result of `10 / 3`?**
   - A) `3`
   - B) `3.0`
   - C) `3.3333333333333335`
   - D) `3.33`

2. **What is the result of `10 // 3`?**
   - A) `3`
   - B) `3.0`
   - C) `3.3333333333333335`
   - D) `4`

3. **What is the result of `10 % 3`?**
   - A) `0`
   - B) `1`
   - C) `2`
   - D) `3`

4. **What is the result of `2 ** 3 ** 2`?**
   - A) `64`
   - B) `512`
   - C) `36`
   - D) `18`

5. **What is the result of `2 + 3 * 4`?**
   - A) `20`
   - B) `14`
   - C) `24`
   - D) `11`

6. **Which operator has the highest precedence?**
   - A) `+`
   - B) `*`
   - C) `**`
   - D) `()`

7. **What is the result of `-10 // 3`?**
   - A) `-3`
   - B) `-4`
   - C) `-3.33`
   - D) `3`

8. **How do you check if a number is even?**
   - A) `number / 2 == 0`
   - B) `number % 2 == 0`
   - C) `number // 2 == 0`
   - D) `number * 2 == 0`

9. **What is the result of `16 ** 0.5`?**
   - A) `8`
   - B) `4.0`
   - C) `256`
   - D) `32`

10. **What happens when you divide by zero?**
    - A) Returns `infinity`
    - B) Returns `0`
    - C) Raises `ZeroDivisionError`
    - D) Returns `None`

**Answers**:
1. C) `3.3333333333333335` (division always returns float)
2. A) `3` (floor division returns integer when operands are integers)
3. B) `1` (10 divided by 3 is 3 with remainder 1)
4. B) `512` (exponentiation is right-associative: 2 ** (3 ** 2) = 2 ** 9 = 512)
5. B) `14` (multiplication before addition: 3 * 4 = 12, then 2 + 12 = 14)
6. D) `()` (parentheses have the highest precedence)
7. B) `-4` (floor division rounds down, so -10 // 3 = -4)
8. B) `number % 2 == 0` (modulo 2 returns 0 for even numbers)
9. B) `4.0` (0.5 exponent is square root: √16 = 4.0)
10. C) Raises `ZeroDivisionError` (division by zero is not allowed)

---

## Next Steps

Great job! You've mastered arithmetic operators. You now understand:
- All basic arithmetic operations
- Floor division and modulo operators
- Exponentiation
- Operator precedence and associativity
- Practical applications of arithmetic operations

**What's Next?**
- Lesson 2.2: Comparison and Logical Operators
- Practice building more calculator programs
- Experiment with complex arithmetic expressions
- Learn about augmented assignment operators

---

## Additional Resources

- **Python Numeric Types**: [docs.python.org/3/library/stdtypes.html#numeric-types](https://docs.python.org/3/library/stdtypes.html#numeric-types)
- **Operator Precedence**: [docs.python.org/3/reference/expressions.html#operator-precedence](https://docs.python.org/3/reference/expressions.html#operator-precedence)
- **Math Module**: [docs.python.org/3/library/math.html](https://docs.python.org/3/library/math.html) (for advanced math operations)
- **Decimal Module**: [docs.python.org/3/library/decimal.html](https://docs.python.org/3/library/decimal.html) (for precise decimal arithmetic)

---

*Lesson completed! You're ready to move on to the next lesson.*

