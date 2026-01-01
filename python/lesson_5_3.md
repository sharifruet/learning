# Lesson 5.3: Loops - While Loops

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand when to use while loops vs for loops
- Write while loops with proper syntax
- Use loop control statements (break, continue) with while loops
- Understand infinite loops and how to avoid them
- Use while loops for input validation
- Implement while loops in practical scenarios
- Combine while loops with conditionals
- Write efficient and safe while loop code

---

## Introduction to While Loops

A **while loop** repeatedly executes a block of code as long as a condition is True. Unlike for loops that iterate over a sequence, while loops continue until the condition becomes False.

### When to Use While Loops

- **Unknown number of iterations** - when you don't know how many times to loop
- **Condition-based repetition** - when you need to repeat until a condition is met
- **Input validation** - keep asking until valid input is received
- **Event-driven loops** - waiting for events or conditions
- **Game loops** - continue until game ends

### When to Use For Loops Instead

- **Known number of iterations** - when you know how many times to loop
- **Iterating over sequences** - when you have a collection to process
- **Definite iteration** - when the loop has a clear end point

---

## Basic While Loop Syntax

### Basic Syntax

```python
while condition:
    # Code to execute while condition is True
    statement1
    statement2
    # Make sure condition can become False!
```

**Important**:
- The condition is checked before each iteration
- The code block is indented
- The condition must eventually become False, or you'll have an infinite loop

### Simple Examples

```python
# Count from 1 to 5
count = 1
while count <= 5:
    print(count)
    count += 1  # Important: modify the condition variable!
# Output:
# 1
# 2
# 3
# 4
# 5

# Countdown
count = 5
while count > 0:
    print(count)
    count -= 1
print("Blast off!")
# Output:
# 5
# 4
# 3
# 2
# 1
# Blast off!
```

### Key Difference from For Loops

```python
# For loop - definite iteration
for i in range(5):
    print(i)

# While loop - condition-based iteration
i = 0
while i < 5:
    print(i)
    i += 1
```

---

## Common While Loop Patterns

### Pattern 1: Counter-Based Loop

```python
# Count up
count = 0
while count < 10:
    print(count)
    count += 1

# Count down
count = 10
while count > 0:
    print(count)
    count -= 1
```

### Pattern 2: Flag-Based Loop

```python
# Using a flag to control the loop
running = True
while running:
    user_input = input("Enter 'quit' to stop: ")
    if user_input == "quit":
        running = False
    else:
        print(f"You entered: {user_input}")
```

### Pattern 3: Condition-Based Loop

```python
# Continue until condition is met
number = 0
while number != 42:
    number = int(input("Guess the number: "))
    if number == 42:
        print("Correct!")
    else:
        print("Try again!")
```

### Pattern 4: Input Validation

```python
# Keep asking until valid input
age = -1
while age < 0 or age > 120:
    age = int(input("Enter your age (0-120): "))
    if age < 0 or age > 120:
        print("Invalid age! Please try again.")

print(f"Your age is: {age}")
```

---

## Loop Control Statements

### break Statement

Exits the loop immediately, even if the condition is still True.

```python
# Find first even number
numbers = [1, 3, 5, 8, 9, 10]
i = 0
while i < len(numbers):
    if numbers[i] % 2 == 0:
        print(f"First even number: {numbers[i]}")
        break
    i += 1

# Search loop
found = False
i = 0
while i < len(names):
    if names[i] == search_term:
        print(f"Found at index {i}")
        found = True
        break
    i += 1
```

### continue Statement

Skips the rest of the current iteration and continues with the next.

```python
# Print only even numbers
count = 0
while count < 10:
    count += 1
    if count % 2 != 0:  # Skip odd numbers
        continue
    print(count)
# Output:
# 2
# 4
# 6
# 8
# 10
```

### else Clause with While Loops

The `else` clause executes if the loop completes normally (condition becomes False, not via break).

```python
# Search with else
names = ["Alice", "Bob", "Charlie"]
search = "Diana"
i = 0

while i < len(names):
    if names[i] == search:
        print(f"Found {search}!")
        break
    i += 1
else:
    print(f"{search} not found")  # Executes if loop completes without break
```

---

## Infinite Loops

An **infinite loop** runs forever because the condition never becomes False.

### Accidental Infinite Loops

```python
# Wrong: condition never changes
# count = 1
# while count <= 5:
#     print(count)
#     # Forgot to increment count! Infinite loop!

# Correct: modify the condition variable
count = 1
while count <= 5:
    print(count)
    count += 1  # This makes the condition eventually False
```

### Intentional Infinite Loops

Sometimes you want an infinite loop (with a break to exit):

```python
# Game loop
while True:
    user_input = input("Enter command (or 'quit' to exit): ")
    if user_input == "quit":
        break
    print(f"Executing: {user_input}")

# Server loop
running = True
while running:
    # Process requests
    request = get_request()
    if request == "shutdown":
        running = False
    else:
        process_request(request)
```

### Breaking Out of Infinite Loops

```python
# Always provide a way to exit
while True:
    user_input = input("Enter 'quit' to exit: ")
    if user_input == "quit":
        break
    print(f"You said: {user_input}")
```

---

## Input Validation with While Loops

While loops are perfect for input validation - keep asking until you get valid input.

### Basic Input Validation

```python
# Validate number input
number = None
while number is None:
    try:
        number = int(input("Enter a number: "))
    except ValueError:
        print("Invalid input! Please enter a number.")

print(f"You entered: {number}")

# Validate range
age = -1
while age < 0 or age > 120:
    try:
        age = int(input("Enter your age (0-120): "))
        if age < 0 or age > 120:
            print("Age must be between 0 and 120!")
    except ValueError:
        print("Please enter a valid number!")

print(f"Your age is: {age}")
```

### Menu System

```python
# Menu loop
while True:
    print("\nMenu:")
    print("1. Option 1")
    print("2. Option 2")
    print("3. Quit")
    
    choice = input("Enter your choice: ")
    
    if choice == "1":
        print("You selected Option 1")
    elif choice == "2":
        print("You selected Option 2")
    elif choice == "3":
        print("Goodbye!")
        break
    else:
        print("Invalid choice! Please try again.")
```

### Password Validation

```python
# Password validation
max_attempts = 3
attempts = 0
correct_password = "secret123"

while attempts < max_attempts:
    password = input("Enter password: ")
    if password == correct_password:
        print("Access granted!")
        break
    else:
        attempts += 1
        remaining = max_attempts - attempts
        if remaining > 0:
            print(f"Wrong password! {remaining} attempts remaining.")
        else:
            print("Access denied! Too many failed attempts.")
```

---

## While Loops vs For Loops

### When to Use While Loops

✅ **Use while loops when**:
- Number of iterations is unknown
- Condition-based repetition
- Input validation
- Event-driven programming
- Game loops
- Waiting for conditions

### When to Use For Loops

✅ **Use for loops when**:
- Iterating over a sequence
- Known number of iterations
- Processing collections
- Definite iteration

### Comparison Examples

```python
# For loop - iterate over known sequence
fruits = ["apple", "banana", "orange"]
for fruit in fruits:
    print(fruit)

# While loop - condition-based
count = 0
while count < len(fruits):
    print(fruits[count])
    count += 1

# While loop - better for unknown iterations
user_input = ""
while user_input != "quit":
    user_input = input("Enter command (or 'quit'): ")
    print(f"Processing: {user_input}")
```

---

## Nested While Loops

You can nest while loops just like for loops.

### Basic Nested While Loop

```python
# Multiplication table
i = 1
while i <= 3:
    j = 1
    while j <= 3:
        print(f"{i} x {j} = {i * j}")
        j += 1
    i += 1
    print()  # Blank line between tables
```

### Real-World Example

```python
# Pattern generation
rows = 5
i = 1
while i <= rows:
    j = 1
    while j <= i:
        print("*", end="")
        j += 1
    print()  # New line
    i += 1
# Output:
# *
# **
# ***
# ****
# *****
```

---

## Common Patterns

### Pattern 1: Accumulating Values

```python
# Sum numbers until user enters 0
total = 0
number = 1

while number != 0:
    number = int(input("Enter a number (0 to stop): "))
    total += number

print(f"Total: {total}")
```

### Pattern 2: Processing Until Condition

```python
# Process items until empty
items = ["apple", "banana", "orange"]
while items:  # While list is not empty
    item = items.pop()
    print(f"Processing: {item}")
```

### Pattern 3: Retry Logic

```python
# Retry with maximum attempts
max_attempts = 3
attempts = 0
success = False

while attempts < max_attempts and not success:
    try:
        # Attempt operation
        result = risky_operation()
        success = True
        print("Operation successful!")
    except Exception as e:
        attempts += 1
        print(f"Attempt {attempts} failed: {e}")
        if attempts >= max_attempts:
            print("Max attempts reached!")
```

### Pattern 4: Event Loop

```python
# Simple event loop
events = []
running = True

while running:
    # Process events
    if events:
        event = events.pop(0)
        process_event(event)
    
    # Check for exit condition
    if should_exit():
        running = False
```

---

## Practical Examples

### Example 1: Number Guessing Game

```python
import random

# Generate random number
secret_number = random.randint(1, 100)
guesses = 0
max_guesses = 7

print("I'm thinking of a number between 1 and 100.")
print(f"You have {max_guesses} guesses.")

while guesses < max_guesses:
    guess = int(input("Enter your guess: "))
    guesses += 1
    
    if guess == secret_number:
        print(f"Congratulations! You guessed it in {guesses} tries!")
        break
    elif guess < secret_number:
        print("Too low!")
    else:
        print("Too high!")
    
    remaining = max_guesses - guesses
    if remaining > 0:
        print(f"You have {remaining} guesses remaining.")
else:
    print(f"Game over! The number was {secret_number}.")
```

### Example 2: Calculator with Menu

```python
while True:
    print("\nCalculator Menu:")
    print("1. Add")
    print("2. Subtract")
    print("3. Multiply")
    print("4. Divide")
    print("5. Quit")
    
    choice = input("Enter your choice: ")
    
    if choice == "5":
        print("Goodbye!")
        break
    
    if choice in ["1", "2", "3", "4"]:
        num1 = float(input("Enter first number: "))
        num2 = float(input("Enter second number: "))
        
        if choice == "1":
            result = num1 + num2
            print(f"Result: {result}")
        elif choice == "2":
            result = num1 - num2
            print(f"Result: {result}")
        elif choice == "3":
            result = num1 * num2
            print(f"Result: {result}")
        elif choice == "4":
            if num2 != 0:
                result = num1 / num2
                print(f"Result: {result}")
            else:
                print("Error: Division by zero!")
    else:
        print("Invalid choice! Please try again.")
```

### Example 3: Data Processing

```python
# Process data until sentinel value
numbers = []
print("Enter numbers (enter 'done' to finish):")

while True:
    user_input = input("Enter a number: ")
    if user_input == "done":
        break
    
    try:
        number = float(user_input)
        numbers.append(number)
    except ValueError:
        print("Invalid input! Please enter a number or 'done'.")

if numbers:
    print(f"\nYou entered {len(numbers)} numbers.")
    print(f"Sum: {sum(numbers)}")
    print(f"Average: {sum(numbers) / len(numbers):.2f}")
    print(f"Maximum: {max(numbers)}")
    print(f"Minimum: {min(numbers)}")
else:
    print("No numbers entered.")
```

---

## Common Mistakes and Pitfalls

### 1. Infinite Loops

```python
# Wrong: condition never changes
# count = 1
# while count <= 5:
#     print(count)
#     # Missing count += 1!

# Correct: modify condition variable
count = 1
while count <= 5:
    print(count)
    count += 1
```

### 2. Forgetting to Initialize

```python
# Wrong: variable not initialized
# while count < 10:
#     print(count)
#     count += 1

# Correct: initialize first
count = 0
while count < 10:
    print(count)
    count += 1
```

### 3. Wrong Condition

```python
# Wrong: condition is always True
# while True:
#     print("This runs forever!")
#     # No break statement!

# Correct: provide exit condition
while True:
    user_input = input("Enter 'quit' to exit: ")
    if user_input == "quit":
        break
    print(f"You said: {user_input}")
```

### 4. Off-by-One Errors

```python
# Be careful with boundary conditions
count = 0
while count < 5:  # Executes 5 times (0, 1, 2, 3, 4)
    print(count)
    count += 1

count = 1
while count <= 5:  # Also executes 5 times (1, 2, 3, 4, 5)
    print(count)
    count += 1
```

### 5. Modifying Wrong Variable

```python
# Wrong: modifying wrong variable
# i = 0
# j = 0
# while i < 5:
#     print(i)
#     j += 1  # Wrong variable!

# Correct: modify the condition variable
i = 0
while i < 5:
    print(i)
    i += 1
```

---

## Best Practices

### 1. Always Ensure Exit Condition

```python
# Good: clear exit condition
count = 0
while count < 10:
    print(count)
    count += 1  # Ensures loop will exit

# Good: break statement
while True:
    user_input = input("Enter 'quit': ")
    if user_input == "quit":
        break  # Clear exit point
```

### 2. Use Meaningful Variable Names

```python
# Good
attempts = 0
while attempts < 3:
    attempts += 1

# Less clear
i = 0
while i < 3:
    i += 1
```

### 3. Initialize Variables Before Loop

```python
# Good: initialize before loop
total = 0
count = 0
while count < 10:
    total += count
    count += 1

# Bad: might forget initialization
# while count < 10:  # NameError if count not defined
```

### 4. Avoid Deep Nesting

```python
# Try to keep nesting shallow
# If you need deep nesting, consider refactoring
```

---

## Practice Exercise

### Exercise: While Loop Practice

**Objective**: Create a Python program that demonstrates various while loop operations and patterns.

**Instructions**:

1. Create a file called `while_loop_practice.py`

2. Write a program that:
   - Uses while loops with different patterns
   - Implements input validation
   - Uses loop control statements
   - Demonstrates practical while loop applications
   - Shows while vs for loop differences

3. Your program should include:
   - Counter-based loops
   - Input validation
   - Menu system
   - Game loop
   - Data processing

**Example Solution**:

```python
"""
While Loop Practice
This program demonstrates various while loop operations and patterns.
"""

print("=" * 60)
print("WHILE LOOP PRACTICE")
print("=" * 60)
print()

# 1. Basic While Loop
print("1. BASIC WHILE LOOP")
print("-" * 60)
count = 1
while count <= 5:
    print(f"  Count: {count}")
    count += 1
print()

# 2. Countdown
print("2. COUNTDOWN")
print("-" * 60)
count = 5
while count > 0:
    print(f"  {count}")
    count -= 1
print("  Blast off!")
print()

# 3. Flag-Based Loop
print("3. FLAG-BASED LOOP")
print("-" * 60)
running = True
iterations = 0
while running:
    iterations += 1
    if iterations >= 3:
        running = False
    print(f"  Iteration {iterations}")
print()

# 4. Input Validation
print("4. INPUT VALIDATION")
print("-" * 60)
# Simulate input validation
age = -1
attempts = 0
valid_inputs = [25, 30, 18]  # Simulated user inputs
input_index = 0

print("  (Simulated) Enter age (0-120):")
while age < 0 or age > 120:
    if attempts < len(valid_inputs):
        age = valid_inputs[input_index]
        input_index += 1
        attempts += 1
        print(f"  Attempt {attempts}: {age}")
        if age < 0 or age > 120:
            print("    Invalid age! Please try again.")
    else:
        age = 25  # Default for demo
        break

print(f"  Valid age entered: {age}")
print()

# 5. Loop Control: break
print("5. LOOP CONTROL: break")
print("-" * 60)
count = 0
while count < 10:
    count += 1
    if count == 5:
        print(f"  Breaking at {count}")
        break
    print(f"  Count: {count}")
print()

# 6. Loop Control: continue
print("6. LOOP CONTROL: continue")
print("-" * 60)
count = 0
print("  Even numbers from 1 to 10:")
while count < 10:
    count += 1
    if count % 2 != 0:
        continue
    print(f"  {count}")
print()

# 7. Loop Control: else
print("7. LOOP CONTROL: else")
print("-" * 60)
numbers = [1, 3, 5, 7, 9]
search = 8
i = 0

print(f"  Searching for {search} in {numbers}:")
while i < len(numbers):
    if numbers[i] == search:
        print(f"    Found {search} at index {i}!")
        break
    i += 1
else:
    print(f"    {search} not found")
print()

# 8. Processing Until Empty
print("8. PROCESSING UNTIL EMPTY")
print("-" * 60)
items = ["apple", "banana", "orange"]
print(f"  Processing items: {items}")
while items:
    item = items.pop(0)
    print(f"    Processing: {item}")
print(f"  All items processed. Remaining: {items}")
print()

# 9. Accumulating Values
print("9. ACCUMULATING VALUES")
print("-" * 60)
total = 0
count = 1
print("  Summing numbers 1 to 5:")
while count <= 5:
    total += count
    print(f"    Adding {count}, total: {total}")
    count += 1
print(f"  Final total: {total}")
print()

# 10. Nested While Loops
print("10. NESTED WHILE LOOPS")
print("-" * 60)
print("  Multiplication table (1-3):")
i = 1
while i <= 3:
    j = 1
    while j <= 3:
        print(f"    {i} x {j} = {i * j}")
        j += 1
    i += 1
    print()
print()

# 11. Pattern Generation
print("11. PATTERN GENERATION")
print("-" * 60)
rows = 5
i = 1
print("  Star pattern:")
while i <= rows:
    j = 1
    while j <= i:
        print("*", end="")
        j += 1
    print()  # New line
    i += 1
print()

# 12. Retry Logic
print("12. RETRY LOGIC")
print("-" * 60)
max_attempts = 3
attempts = 0
success = False
simulated_results = [False, False, True]  # Simulated operation results

print("  Attempting operation with retry:")
while attempts < max_attempts and not success:
    attempts += 1
    print(f"    Attempt {attempts}...")
    # Simulate operation
    if attempts <= len(simulated_results):
        success = simulated_results[attempts - 1]
    else:
        success = True  # Default success
    
    if success:
        print("      Operation successful!")
    else:
        if attempts < max_attempts:
            print(f"      Failed. Retrying... ({max_attempts - attempts} attempts left)")
        else:
            print("      Max attempts reached!")
print()

# 13. Menu System (Simulated)
print("13. MENU SYSTEM")
print("-" * 60)
print("  (Simulated menu selections)")
menu_choices = ["1", "2", "3"]  # Simulated user choices
choice_index = 0

print("  Menu:")
print("    1. Option 1")
print("    2. Option 2")
print("    3. Quit")

iterations = 0
while iterations < len(menu_choices):
    if choice_index < len(menu_choices):
        choice = menu_choices[choice_index]
        choice_index += 1
    else:
        choice = "3"  # Quit
    
    if choice == "1":
        print("    You selected Option 1")
    elif choice == "2":
        print("    You selected Option 2")
    elif choice == "3":
        print("    Goodbye!")
        break
    else:
        print("    Invalid choice!")
    
    iterations += 1
print()

# 14. Number Guessing (Simulated)
print("14. NUMBER GUESSING GAME")
print("-" * 60)
secret_number = 42
guesses = [50, 30, 45, 42]  # Simulated guesses
guess_index = 0
max_guesses = 7
attempts = 0

print(f"  I'm thinking of a number between 1 and 100.")
print(f"  (Secret number is {secret_number})")

while attempts < max_guesses:
    if guess_index < len(guesses):
        guess = guesses[guess_index]
        guess_index += 1
    else:
        guess = secret_number  # Correct guess
    
    attempts += 1
    print(f"  Guess {attempts}: {guess}")
    
    if guess == secret_number:
        print(f"    Congratulations! You guessed it in {attempts} tries!")
        break
    elif guess < secret_number:
        print("    Too low!")
    else:
        print("    Too high!")
    
    remaining = max_guesses - attempts
    if remaining > 0:
        print(f"    {remaining} guesses remaining.")
else:
    print(f"  Game over! The number was {secret_number}.")
print()

# 15. While vs For Comparison
print("15. WHILE vs FOR COMPARISON")
print("-" * 60)
print("  For loop (definite iteration):")
for i in range(5):
    print(f"    {i}")

print("\n  While loop (equivalent):")
i = 0
while i < 5:
    print(f"    {i}")
    i += 1

print("\n  While loop (condition-based - better use case):")
user_input = "continue"
iterations = 0
while user_input == "continue" and iterations < 3:
    iterations += 1
    print(f"    Iteration {iterations}")
    if iterations >= 3:
        user_input = "quit"
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
WHILE LOOP PRACTICE
============================================================

1. BASIC WHILE LOOP
------------------------------------------------------------
  Count: 1
  Count: 2
  Count: 3
  Count: 4
  Count: 5

[... rest of output ...]
```

**Challenge** (Optional):
- Create a complete interactive game
- Build a data processing system with retry logic
- Implement a real-time monitoring loop
- Create a file processing system
- Build a network request handler with retries

---

## Key Takeaways

1. **While loops repeat while condition is True** - condition-based iteration
2. **Always ensure exit condition** - modify condition variable or use break
3. **Use while for unknown iterations** - when you don't know how many times to loop
4. **Use for for known iterations** - when iterating over sequences
5. **break exits the loop** - stops execution immediately
6. **continue skips to next iteration** - skips rest of current iteration
7. **else with while** - executes if loop completes without break
8. **Input validation** - while loops are perfect for validating user input
9. **Avoid infinite loops** - always provide a way to exit
10. **Initialize variables** - set up condition variables before the loop

---

## Quiz: While Loops

Test your understanding with these questions:

1. **What is the main difference between while and for loops?**
   - A) While loops are faster
   - B) While loops are condition-based, for loops iterate over sequences
   - C) For loops are condition-based, while loops iterate over sequences
   - D) No difference

2. **What happens if the while condition never becomes False?**
   - A) Error
   - B) Loop runs once
   - C) Infinite loop
   - D) Loop doesn't run

3. **What does `break` do in a while loop?**
   - A) Skips to next iteration
   - B) Exits the loop
   - C) Does nothing
   - D) Restarts the loop

4. **What is required to avoid infinite loops?**
   - A) break statement
   - B) Condition that becomes False
   - C) continue statement
   - D) Both A and B

5. **When should you use a while loop instead of a for loop?**
   - A) When iterating over a list
   - B) When number of iterations is unknown
   - C) When you know how many times to loop
   - D) Always use for loops

6. **What does the `else` clause do with a while loop?**
   - A) Always executes
   - B) Executes if loop completes without break
   - C) Never executes
   - D) Executes on error

7. **What is the output of: `count = 0; while count < 3: print(count); count += 1`?**
   - A) 0, 1, 2
   - B) 0, 1, 2, 3
   - C) 1, 2, 3
   - D) Infinite loop

8. **What happens if you forget to modify the condition variable?**
   - A) Loop runs once
   - B) Infinite loop
   - C) Error
   - D) Loop doesn't run

9. **What is a common use case for while loops?**
   - A) Iterating over lists
   - B) Input validation
   - C) Processing sequences
   - D) All of the above

10. **What is the correct way to create an infinite loop with exit?**
    - A) `while True: break`
    - B) `while 1: break`
    - C) `while True: if condition: break`
    - D) All of the above

**Answers**:
1. B) While loops are condition-based, for loops iterate over sequences
2. C) Infinite loop (runs forever)
3. B) Exits the loop (stops execution immediately)
4. D) Both A and B (break or condition becoming False)
5. B) When number of iterations is unknown
6. B) Executes if loop completes without break
7. A) 0, 1, 2 (count goes from 0 to 2, then condition becomes False)
8. B) Infinite loop (condition never changes)
9. B) Input validation (while loops excel at this)
10. D) All of the above (all create infinite loops with break exit)

---

## Next Steps

Excellent work! You've mastered while loops. You now understand:
- When to use while loops vs for loops
- How to write while loops with proper syntax
- Loop control statements with while loops
- How to avoid infinite loops
- Input validation patterns
- Practical while loop applications

**What's Next?**
- Lesson 5.4: Loop Techniques
- Practice combining while and for loops
- Learn about advanced loop patterns
- Explore more complex control flow

---

## Additional Resources

- **Python While Loops**: [docs.python.org/3/tutorial/controlflow.html#while-statements](https://docs.python.org/3/tutorial/controlflow.html#while-statements)
- **Control Flow**: [docs.python.org/3/tutorial/controlflow.html](https://docs.python.org/3/tutorial/controlflow.html)
- **Input/Output**: [docs.python.org/3/tutorial/inputoutput.html](https://docs.python.org/3/tutorial/inputoutput.html)

---

*Lesson completed! You're ready to move on to the next lesson.*

