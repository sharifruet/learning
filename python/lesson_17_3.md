# Lesson 17.3: Test-Driven Development (TDD)

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the TDD cycle
- Write tests first
- Refactor code safely
- Apply TDD in practice
- Understand TDD benefits
- Follow TDD best practices
- Handle TDD challenges
- Apply TDD to real-world scenarios
- Understand when to use TDD
- Debug TDD workflow issues

---

## Introduction to Test-Driven Development

**Test-Driven Development (TDD)** is a software development approach where you write tests before writing the actual code. It follows a simple cycle: Red, Green, Refactor.

### Why TDD?

- **Better design**: Writing tests first improves code design
- **Confidence**: Know your code works
- **Documentation**: Tests serve as executable documentation
- **Refactoring safety**: Refactor with confidence
- **Faster debugging**: Catch bugs early
- **Focus**: Stay focused on requirements

### What is TDD?

TDD is a development methodology where you:
1. Write a failing test (Red)
2. Write minimal code to make it pass (Green)
3. Refactor the code (Refactor)
4. Repeat

---

## TDD Cycle

### The Red-Green-Refactor Cycle

The TDD cycle consists of three phases:

```
┌─────────┐
│   RED   │  Write a failing test
└────┬────┘
     │
     ▼
┌─────────┐
│  GREEN  │  Write code to make test pass
└────┬────┘
     │
     ▼
┌──────────┐
│ REFACTOR │  Improve code while keeping tests green
└────┬─────┘
     │
     └─────► Repeat
```

### Phase 1: Red (Write Failing Test)

Write a test that describes the desired behavior:

```python
# test_calculator.py
import unittest
from calculator import add

class TestCalculator(unittest.TestCase):
    def test_add_two_numbers(self):
        self.assertEqual(add(2, 3), 5)
```

Run the test - it should fail (Red):

```bash
$ python -m unittest test_calculator.py
E
======================================================================
ERROR: test_add_two_numbers (test_calculator.TestCalculator)
----------------------------------------------------------------------
NameError: name 'add' is not defined
----------------------------------------------------------------------
Ran 1 test in 0.001s

FAILED (errors=1)
```

### Phase 2: Green (Make Test Pass)

Write the minimal code to make the test pass:

```python
# calculator.py
def add(x, y):
    return x + y
```

Run the test - it should pass (Green):

```bash
$ python -m unittest test_calculator.py
.
----------------------------------------------------------------------
Ran 1 test in 0.001s

OK
```

### Phase 3: Refactor (Improve Code)

Improve the code while keeping tests green:

```python
# calculator.py
def add(x, y):
    """Add two numbers.
    
    Args:
        x: First number
        y: Second number
    
    Returns:
        Sum of x and y
    """
    return x + y
```

Run the test again - should still pass:

```bash
$ python -m unittest test_calculator.py
.
----------------------------------------------------------------------
Ran 1 test in 0.001s

OK
```

### Complete Example: Building a Calculator

Let's build a calculator using TDD:

#### Step 1: Red - Test Addition

```python
# test_calculator.py
import unittest
from calculator import Calculator

class TestCalculator(unittest.TestCase):
    def test_add(self):
        calc = Calculator()
        self.assertEqual(calc.add(2, 3), 5)
```

#### Step 2: Green - Implement Addition

```python
# calculator.py
class Calculator:
    def add(self, x, y):
        return x + y
```

#### Step 3: Refactor - Improve Code

```python
# calculator.py
class Calculator:
    def add(self, x, y):
        """Add two numbers."""
        return x + y
```

#### Step 4: Red - Test Subtraction

```python
# test_calculator.py
def test_subtract(self):
    calc = Calculator()
    self.assertEqual(calc.subtract(5, 3), 2)
```

#### Step 5: Green - Implement Subtraction

```python
# calculator.py
def subtract(self, x, y):
    return x - y
```

#### Step 6: Continue Cycle

Continue adding features following the same cycle.

---

## Writing Tests First

### Benefits of Writing Tests First

1. **Clarifies requirements**: Forces you to think about what you want
2. **Better design**: Tests guide better API design
3. **Prevents over-engineering**: Only write what's needed
4. **Confidence**: Know when you're done
5. **Documentation**: Tests document expected behavior

### Example: Building a Stack

#### Step 1: Write Test for Empty Stack

```python
# test_stack.py
import unittest
from stack import Stack

class TestStack(unittest.TestCase):
    def test_empty_stack(self):
        stack = Stack()
        self.assertTrue(stack.is_empty())
        self.assertEqual(stack.size(), 0)
```

#### Step 2: Implement Minimal Code

```python
# stack.py
class Stack:
    def __init__(self):
        self.items = []
    
    def is_empty(self):
        return len(self.items) == 0
    
    def size(self):
        return len(self.items)
```

#### Step 3: Write Test for Push

```python
def test_push(self):
    stack = Stack()
    stack.push(1)
    self.assertFalse(stack.is_empty())
    self.assertEqual(stack.size(), 1)
```

#### Step 4: Implement Push

```python
def push(self, item):
    self.items.append(item)
```

#### Step 5: Write Test for Pop

```python
def test_pop(self):
    stack = Stack()
    stack.push(1)
    stack.push(2)
    self.assertEqual(stack.pop(), 2)
    self.assertEqual(stack.size(), 1)
```

#### Step 6: Implement Pop

```python
def pop(self):
    if self.is_empty():
        raise IndexError("Stack is empty")
    return self.items.pop()
```

### Thinking in Tests

When writing tests first, think about:
- **What should it do?** (Behavior)
- **What are the inputs?** (Parameters)
- **What should it return?** (Output)
- **What are edge cases?** (Boundary conditions)
- **What errors might occur?** (Error handling)

---

## Refactoring

### What is Refactoring?

**Refactoring** is improving code structure without changing its behavior. Tests ensure behavior stays the same.

### Refactoring Safely

With tests, you can refactor confidently:

```python
# Before refactoring
def calculate_total(items):
    total = 0
    for item in items:
        total = total + item.price
    return total

# After refactoring (tests still pass)
def calculate_total(items):
    return sum(item.price for item in items)
```

### Refactoring Example

#### Original Code

```python
# calculator.py
class Calculator:
    def add(self, x, y):
        return x + y
    
    def subtract(self, x, y):
        return x - y
    
    def multiply(self, x, y):
        return x * y
    
    def divide(self, x, y):
        return x / y
```

#### Refactored Code

```python
# calculator.py
class Calculator:
    def _validate_numbers(self, x, y):
        """Validate that inputs are numbers."""
        if not isinstance(x, (int, float)) or not isinstance(y, (int, float)):
            raise TypeError("Arguments must be numbers")
    
    def add(self, x, y):
        self._validate_numbers(x, y)
        return x + y
    
    def subtract(self, x, y):
        self._validate_numbers(x, y)
        return x - y
    
    def multiply(self, x, y):
        self._validate_numbers(x, y)
        return x * y
    
    def divide(self, x, y):
        self._validate_numbers(x, y)
        if y == 0:
            raise ValueError("Cannot divide by zero")
        return x / y
```

Tests ensure the refactoring didn't break anything!

### When to Refactor

Refactor when:
- **Code duplication**: Extract common code
- **Complex code**: Simplify logic
- **Poor naming**: Improve names
- **Long methods**: Break into smaller methods
- **After green phase**: Once tests pass

### Refactoring Checklist

- [ ] All tests pass before refactoring
- [ ] Make small, incremental changes
- [ ] Run tests after each change
- [ ] Keep tests green throughout
- [ ] Don't add features while refactoring

---

## TDD Best Practices

### 1. Write One Test at a Time

```python
# Good: One test, one feature
def test_add_positive_numbers(self):
    self.assertEqual(add(2, 3), 5)

# Avoid: Multiple tests at once
def test_add_everything(self):
    self.assertEqual(add(2, 3), 5)
    self.assertEqual(add(-2, -3), -5)
    self.assertEqual(add(0, 0), 0)
```

### 2. Write Minimal Code to Pass

```python
# Good: Minimal implementation
def add(x, y):
    return x + y

# Avoid: Over-engineering
def add(x, y):
    if isinstance(x, int) and isinstance(y, int):
        return x + y
    elif isinstance(x, float) and isinstance(y, float):
        return x + y
    # ... more code
```

### 3. Test Behavior, Not Implementation

```python
# Good: Test behavior
def test_add(self):
    result = add(2, 3)
    self.assertEqual(result, 5)

# Avoid: Test implementation
def test_add(self):
    self.assertEqual(add._internal_method(), 5)
```

### 4. Keep Tests Simple

```python
# Good: Simple and clear
def test_add(self):
    self.assertEqual(add(2, 3), 5)

# Avoid: Complex test
def test_add(self):
    x, y = 2, 3
    expected = 5
    result = add(x, y)
    if result == expected:
        self.assertTrue(True)
    else:
        self.assertTrue(False)
```

### 5. Test Edge Cases

```python
def test_add(self):
    self.assertEqual(add(2, 3), 5)
    self.assertEqual(add(0, 0), 0)
    self.assertEqual(add(-2, -3), -5)
    self.assertEqual(add(2, -3), -1)
```

### 6. Refactor Regularly

Don't wait until code is messy. Refactor after each green phase.

---

## TDD Workflow Example

### Building a Bank Account Class

#### Iteration 1: Create Account

**Red:**
```python
def test_create_account(self):
    account = BankAccount("Alice", 100)
    self.assertEqual(account.balance, 100)
```

**Green:**
```python
class BankAccount:
    def __init__(self, name, initial_balance):
        self.name = name
        self.balance = initial_balance
```

**Refactor:** (No refactoring needed yet)

#### Iteration 2: Deposit

**Red:**
```python
def test_deposit(self):
    account = BankAccount("Alice", 100)
    account.deposit(50)
    self.assertEqual(account.balance, 150)
```

**Green:**
```python
def deposit(self, amount):
    self.balance += amount
```

**Refactor:** (No refactoring needed)

#### Iteration 3: Withdraw

**Red:**
```python
def test_withdraw(self):
    account = BankAccount("Alice", 100)
    account.withdraw(30)
    self.assertEqual(account.balance, 70)
```

**Green:**
```python
def withdraw(self, amount):
    self.balance -= amount
```

**Refactor:** (No refactoring needed)

#### Iteration 4: Prevent Overdraft

**Red:**
```python
def test_withdraw_insufficient_funds(self):
    account = BankAccount("Alice", 100)
    with self.assertRaises(ValueError):
        account.withdraw(150)
```

**Green:**
```python
def withdraw(self, amount):
    if amount > self.balance:
        raise ValueError("Insufficient funds")
    self.balance -= amount
```

**Refactor:**
```python
def withdraw(self, amount):
    if not self._has_sufficient_funds(amount):
        raise ValueError("Insufficient funds")
    self.balance -= amount

def _has_sufficient_funds(self, amount):
    return amount <= self.balance
```

---

## Common TDD Challenges

### Challenge 1: Writing Tests for Complex Code

**Solution**: Start simple, add complexity gradually:

```python
# Start simple
def test_basic_functionality(self):
    pass

# Add complexity
def test_edge_cases(self):
    pass

# Add error handling
def test_error_cases(self):
    pass
```

### Challenge 2: Testing External Dependencies

**Solution**: Use mocks and stubs:

```python
from unittest.mock import Mock, patch

@patch('requests.get')
def test_fetch_data(mock_get):
    mock_get.return_value.json.return_value = {'data': 'test'}
    result = fetch_data('url')
    assert result == {'data': 'test'}
```

### Challenge 3: Knowing When to Stop

**Solution**: Stop when:
- All requirements are met
- All edge cases are covered
- Code is clean and maintainable
- Tests provide good coverage

### Challenge 4: Refactoring Large Codebases

**Solution**: 
- Refactor in small steps
- Run tests frequently
- Keep tests green
- Don't refactor and add features simultaneously

---

## TDD Benefits

### 1. Better Code Design

Writing tests first forces you to think about:
- **API design**: How should it be used?
- **Dependencies**: What does it need?
- **Interfaces**: What should it expose?

### 2. Confidence

- Know your code works
- Make changes safely
- Deploy with confidence

### 3. Documentation

Tests serve as:
- **Executable documentation**: Shows how code should be used
- **Examples**: Demonstrates usage patterns
- **Specifications**: Describes expected behavior

### 4. Faster Development

- **Catch bugs early**: Find issues during development
- **Less debugging**: Fewer bugs in production
- **Faster feedback**: Know immediately if something breaks

### 5. Refactoring Safety

- **Safe refactoring**: Change code with confidence
- **Prevent regressions**: Tests catch breaking changes
- **Improve code quality**: Refactor without fear

---

## When to Use TDD

### Good Use Cases

- **New features**: Building new functionality
- **Bug fixes**: Fix bugs with tests
- **Refactoring**: Refactor with test safety net
- **Learning**: Understand requirements better
- **APIs**: Design clean APIs

### When TDD Might Not Fit

- **Exploratory coding**: Learning and experimenting
- **Prototyping**: Quick prototypes
- **Legacy code**: Adding tests to existing code
- **Simple scripts**: One-off scripts

### TDD vs Other Approaches

| Approach | When to Use |
|----------|-------------|
| TDD | New features, APIs, complex logic |
| Test After | Legacy code, quick fixes |
| No Tests | Prototypes, one-off scripts |

---

## Practice Exercise

### Exercise: TDD Practice

**Objective**: Build a feature using TDD methodology.

**Instructions**:

1. Create files: `test_todo.py` and `todo.py`

2. Build a TodoList class using TDD:
   - Follow Red-Green-Refactor cycle
   - Write tests first
   - Implement minimal code
   - Refactor when needed

3. Features to implement:
   - Create empty todo list
   - Add todo item
   - Remove todo item
   - Mark todo as complete
   - Get all todos
   - Get incomplete todos

**Example Solution**:

```python
"""
TDD Practice: Building a TodoList
Follow the Red-Green-Refactor cycle for each feature.
"""

# test_todo.py
import unittest
from todo import TodoList, TodoItem

# Iteration 1: Create empty todo list
class TestTodoList(unittest.TestCase):
    def test_create_empty_list(self):
        todo_list = TodoList()
        self.assertEqual(todo_list.count(), 0)
        self.assertTrue(todo_list.is_empty())

# Iteration 2: Add todo item
    def test_add_todo(self):
        todo_list = TodoList()
        todo_list.add("Buy groceries")
        self.assertEqual(todo_list.count(), 1)
        self.assertFalse(todo_list.is_empty())

# Iteration 3: Get all todos
    def test_get_all_todos(self):
        todo_list = TodoList()
        todo_list.add("Buy groceries")
        todo_list.add("Walk the dog")
        todos = todo_list.get_all()
        self.assertEqual(len(todos), 2)
        self.assertEqual(todos[0].text, "Buy groceries")

# Iteration 4: Remove todo
    def test_remove_todo(self):
        todo_list = TodoList()
        todo_list.add("Buy groceries")
        todo_list.add("Walk the dog")
        todo_list.remove(0)
        self.assertEqual(todo_list.count(), 1)
        self.assertEqual(todo_list.get_all()[0].text, "Walk the dog")

# Iteration 5: Mark as complete
    def test_mark_complete(self):
        todo_list = TodoList()
        todo_list.add("Buy groceries")
        todo = todo_list.get_all()[0]
        todo.mark_complete()
        self.assertTrue(todo.is_complete())

# Iteration 6: Get incomplete todos
    def test_get_incomplete_todos(self):
        todo_list = TodoList()
        todo_list.add("Buy groceries")
        todo_list.add("Walk the dog")
        todo_list.get_all()[0].mark_complete()
        incomplete = todo_list.get_incomplete()
        self.assertEqual(len(incomplete), 1)
        self.assertEqual(incomplete[0].text, "Walk the dog")

# Iteration 7: Error handling
    def test_remove_invalid_index(self):
        todo_list = TodoList()
        with self.assertRaises(IndexError):
            todo_list.remove(0)

if __name__ == '__main__':
    unittest.main()

# todo.py
class TodoItem:
    def __init__(self, text):
        self.text = text
        self.complete = False
    
    def mark_complete(self):
        self.complete = True
    
    def is_complete(self):
        return self.complete

class TodoList:
    def __init__(self):
        self.items = []
    
    def count(self):
        return len(self.items)
    
    def is_empty(self):
        return len(self.items) == 0
    
    def add(self, text):
        self.items.append(TodoItem(text))
    
    def get_all(self):
        return self.items.copy()
    
    def remove(self, index):
        if index < 0 or index >= len(self.items):
            raise IndexError("Invalid index")
        self.items.pop(index)
    
    def get_incomplete(self):
        return [item for item in self.items if not item.is_complete()]
```

**TDD Cycle Walkthrough**:

1. **Red**: Write test for empty list → Test fails (TodoList doesn't exist)
2. **Green**: Create TodoList class → Test passes
3. **Refactor**: (No refactoring needed)
4. **Red**: Write test for add → Test fails (add method doesn't exist)
5. **Green**: Implement add method → Test passes
6. **Refactor**: (No refactoring needed)
7. Continue cycle for each feature...

**Challenge** (Optional):
- Add feature to get completed todos
- Add feature to clear all todos
- Add feature to filter todos by text
- Add feature to prioritize todos

---

## Key Takeaways

1. **TDD cycle** - Red, Green, Refactor
2. **Write tests first** - Before writing code
3. **Red phase** - Write failing test
4. **Green phase** - Write minimal code to pass
5. **Refactor phase** - Improve code while keeping tests green
6. **One test at a time** - Focus on one feature
7. **Minimal code** - Only write what's needed
8. **Test behavior** - Not implementation
9. **Refactor regularly** - After each green phase
10. **Benefits** - Better design, confidence, documentation
11. **When to use** - New features, APIs, complex logic
12. **Challenges** - Complex code, external dependencies
13. **Best practices** - Simple tests, edge cases, regular refactoring
14. **Workflow** - Iterative cycle of test-code-refactor
15. **Confidence** - Safe refactoring and changes

---

## Quiz: TDD

Test your understanding with these questions:

1. **What is TDD?**
   - A) Testing after development
   - B) Writing tests before code
   - C) Writing code before tests
   - D) No testing

2. **What is the TDD cycle?**
   - A) Write, Test, Refactor
   - B) Red, Green, Refactor
   - C) Test, Code, Debug
   - D) Code, Test, Fix

3. **What is the Red phase?**
   - A) Write passing test
   - B) Write failing test
   - C) Write code
   - D) Refactor code

4. **What is the Green phase?**
   - A) Write test
   - B) Write code to make test pass
   - C) Refactor code
   - D) Delete code

5. **What is the Refactor phase?**
   - A) Write new test
   - B) Write code
   - C) Improve code while keeping tests green
   - D) Delete tests

6. **What should you write in the Red phase?**
   - A) Production code
   - B) Failing test
   - C) Documentation
   - D) Comments

7. **What should you write in the Green phase?**
   - A) More tests
   - B) Minimal code to pass
   - C) Complex code
   - D) Documentation

8. **When should you refactor?**
   - A) Before writing tests
   - B) After tests pass
   - C) Never
   - D) Before writing code

9. **What is a benefit of TDD?**
   - A) Slower development
   - B) Better code design
   - C) More bugs
   - D) Less confidence

10. **How many tests should you write at once?**
    - A) Many
    - B) One
    - C) None
    - D) All

**Answers**:
1. B) Writing tests before code (TDD definition)
2. B) Red, Green, Refactor (TDD cycle)
3. B) Write failing test (Red phase)
4. B) Write code to make test pass (Green phase)
5. C) Improve code while keeping tests green (Refactor phase)
6. B) Failing test (Red phase)
7. B) Minimal code to pass (Green phase)
8. B) After tests pass (refactoring timing)
9. B) Better code design (TDD benefit)
10. B) One (TDD best practice)

---

## Next Steps

Excellent work! You've mastered Test-Driven Development. You now understand:
- The TDD cycle
- Writing tests first
- Refactoring safely
- TDD benefits and practices

**What's Next?**
- Lesson 17.4: Mocking and Patching
- Learn unittest.mock
- Understand mock objects
- Explore patching techniques

---

## Additional Resources

- **Test-Driven Development**: [en.wikipedia.org/wiki/Test-driven_development](https://en.wikipedia.org/wiki/Test-driven_development)
- **TDD by Example**: [martinfowler.com/bliki/TestDrivenDevelopment.html](https://martinfowler.com/bliki/TestDrivenDevelopment.html)
- **Red-Green-Refactor**: [blog.cleancoder.com/uncle-bob/2014/12/17/TheCyclesOfTDD.html](https://blog.cleancoder.com/uncle-bob/2014/12/17/TheCyclesOfTDD.html)

---

*Lesson completed! You're ready to move on to the next lesson.*

