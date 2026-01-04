# Lesson 17.1: Testing Basics

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand why testing is important
- Understand unit testing concepts
- Use the unittest module
- Write test cases
- Use test fixtures
- Organize test suites
- Run tests
- Understand test assertions
- Apply testing best practices
- Debug test failures

---

## Introduction to Testing

**Testing** is the process of verifying that your code works as expected. Writing tests helps ensure code quality, catch bugs early, and maintain confidence when making changes.

### Why Test?

- **Catch bugs early**: Find issues before they reach production
- **Documentation**: Tests serve as executable documentation
- **Confidence**: Make changes with confidence
- **Refactoring**: Safely refactor code knowing tests will catch issues
- **Regression prevention**: Prevent old bugs from returning
- **Code quality**: Encourages better code design

### What is Testing?

Testing involves writing code that verifies your application code behaves correctly under various conditions.

---

## Why Test?

### Benefits of Testing

1. **Early Bug Detection**: Find bugs during development
2. **Documentation**: Tests show how code should be used
3. **Confidence**: Know your code works
4. **Refactoring Safety**: Change code without fear
5. **Regression Prevention**: Prevent bugs from returning
6. **Better Design**: Writing tests improves code design

### Testing Pyramid

```
        /\
       /  \      E2E Tests (Few)
      /____\
     /      \    Integration Tests (Some)
    /________\
   /          \  Unit Tests (Many)
  /____________\
```

- **Unit Tests**: Test individual components (most tests)
- **Integration Tests**: Test component interactions (some tests)
- **E2E Tests**: Test entire system (few tests)

---

## Unit Testing Concepts

### What is Unit Testing?

**Unit testing** is testing individual units of code (functions, methods, classes) in isolation.

### Test Case

A **test case** is a single test that verifies a specific behavior:

```python
def test_add():
    assert add(2, 3) == 5
```

### Test Suite

A **test suite** is a collection of test cases:

```python
class TestCalculator:
    def test_add(self):
        assert add(2, 3) == 5
    
    def test_subtract(self):
        assert subtract(5, 3) == 2
```

### Test Fixtures

**Fixtures** are setup and teardown code that runs before/after tests:

```python
def setup():
    # Setup code
    pass

def teardown():
    # Cleanup code
    pass
```

### Assertions

**Assertions** verify expected behavior:

```python
assert condition, "Error message"
```

---

## unittest Module

### Basic Test Case

The `unittest` module provides a testing framework:

```python
import unittest

class TestCalculator(unittest.TestCase):
    def test_add(self):
        self.assertEqual(add(2, 3), 5)
    
    def test_subtract(self):
        self.assertEqual(subtract(5, 3), 2)

if __name__ == '__main__':
    unittest.main()
```

### Test Structure

```python
import unittest

class TestMyFunction(unittest.TestCase):
    def setUp(self):
        """Run before each test method."""
        pass
    
    def tearDown(self):
        """Run after each test method."""
        pass
    
    def test_something(self):
        """Test method - must start with 'test'."""
        pass
```

### Running Tests

```python
# Run from command line
python -m unittest test_module.py

# Run specific test
python -m unittest test_module.TestClass.test_method

# Run with verbosity
python -m unittest -v test_module.py
```

---

## Test Assertions

### Common Assertions

```python
import unittest

class TestAssertions(unittest.TestCase):
    def test_assert_equal(self):
        self.assertEqual(2 + 2, 4)
    
    def test_assert_not_equal(self):
        self.assertNotEqual(2 + 2, 5)
    
    def test_assert_true(self):
        self.assertTrue(True)
    
    def test_assert_false(self):
        self.assertFalse(False)
    
    def test_assert_is(self):
        a = [1, 2, 3]
        b = a
        self.assertIs(a, b)
    
    def test_assert_is_not(self):
        a = [1, 2, 3]
        b = [1, 2, 3]
        self.assertIsNot(a, b)
    
    def test_assert_is_none(self):
        self.assertIsNone(None)
    
    def test_assert_is_not_none(self):
        self.assertIsNotNone(42)
    
    def test_assert_in(self):
        self.assertIn(2, [1, 2, 3])
    
    def test_assert_not_in(self):
        self.assertNotIn(4, [1, 2, 3])
    
    def test_assert_is_instance(self):
        self.assertIsInstance([1, 2, 3], list)
    
    def test_assert_raises(self):
        with self.assertRaises(ValueError):
            int("not a number")
```

### Assertion Methods

| Method | Checks |
|--------|--------|
| `assertEqual(a, b)` | a == b |
| `assertNotEqual(a, b)` | a != b |
| `assertTrue(x)` | bool(x) is True |
| `assertFalse(x)` | bool(x) is False |
| `assertIs(a, b)` | a is b |
| `assertIsNot(a, b)` | a is not b |
| `assertIsNone(x)` | x is None |
| `assertIsNotNone(x)` | x is not None |
| `assertIn(a, b)` | a in b |
| `assertNotIn(a, b)` | a not in b |
| `assertIsInstance(a, b)` | isinstance(a, b) |
| `assertRaises(exception)` | Raises exception |

---

## Test Fixtures

### setUp and tearDown

```python
import unittest

class TestDatabase(unittest.TestCase):
    def setUp(self):
        """Run before each test."""
        self.db = create_test_database()
    
    def tearDown(self):
        """Run after each test."""
        self.db.close()
    
    def test_query(self):
        result = self.db.query("SELECT * FROM users")
        self.assertIsNotNone(result)
```

### setUpClass and tearDownClass

```python
import unittest

class TestDatabase(unittest.TestCase):
    @classmethod
    def setUpClass(cls):
        """Run once before all tests."""
        cls.db = create_test_database()
    
    @classmethod
    def tearDownClass(cls):
        """Run once after all tests."""
        cls.db.close()
    
    def test_query1(self):
        result = self.db.query("SELECT * FROM users")
        self.assertIsNotNone(result)
    
    def test_query2(self):
        result = self.db.query("SELECT * FROM posts")
        self.assertIsNotNone(result)
```

### setUpModule and tearDownModule

```python
import unittest

def setUpModule():
    """Run once before all test classes."""
    print("Setting up module")

def tearDownModule():
    """Run once after all test classes."""
    print("Tearing down module")

class TestClass1(unittest.TestCase):
    def test_something(self):
        pass

class TestClass2(unittest.TestCase):
    def test_something_else(self):
        pass
```

---

## Organizing Tests

### Test Discovery

unittest can automatically discover tests:

```python
# Run all tests in current directory
python -m unittest discover

# Run tests in specific directory
python -m unittest discover tests/

# Run tests with pattern
python -m unittest discover -p "test_*.py"
```

### Test File Structure

```
project/
├── src/
│   └── calculator.py
└── tests/
    ├── __init__.py
    ├── test_calculator.py
    └── test_advanced.py
```

### Test Class Organization

```python
import unittest
from calculator import Calculator

class TestCalculatorBasic(unittest.TestCase):
    """Test basic calculator operations."""
    def test_add(self):
        calc = Calculator()
        self.assertEqual(calc.add(2, 3), 5)

class TestCalculatorAdvanced(unittest.TestCase):
    """Test advanced calculator operations."""
    def test_power(self):
        calc = Calculator()
        self.assertEqual(calc.power(2, 3), 8)
```

---

## Practical Examples

### Example 1: Testing a Simple Function

```python
# calculator.py
def add(x, y):
    return x + y

def subtract(x, y):
    return x - y

# test_calculator.py
import unittest
from calculator import add, subtract

class TestCalculator(unittest.TestCase):
    def test_add_positive(self):
        self.assertEqual(add(2, 3), 5)
    
    def test_add_negative(self):
        self.assertEqual(add(-2, -3), -5)
    
    def test_add_zero(self):
        self.assertEqual(add(5, 0), 5)
    
    def test_subtract_positive(self):
        self.assertEqual(subtract(5, 3), 2)
    
    def test_subtract_negative(self):
        self.assertEqual(subtract(5, -3), 8)

if __name__ == '__main__':
    unittest.main()
```

### Example 2: Testing a Class

```python
# user.py
class User:
    def __init__(self, name, email):
        self.name = name
        self.email = email
        self.active = True
    
    def deactivate(self):
        self.active = False
    
    def activate(self):
        self.active = True

# test_user.py
import unittest
from user import User

class TestUser(unittest.TestCase):
    def setUp(self):
        self.user = User("Alice", "alice@example.com")
    
    def test_user_creation(self):
        self.assertEqual(self.user.name, "Alice")
        self.assertEqual(self.user.email, "alice@example.com")
        self.assertTrue(self.user.active)
    
    def test_deactivate(self):
        self.user.deactivate()
        self.assertFalse(self.user.active)
    
    def test_activate(self):
        self.user.deactivate()
        self.user.activate()
        self.assertTrue(self.user.active)
```

### Example 3: Testing Exceptions

```python
# validator.py
def validate_age(age):
    if not isinstance(age, int):
        raise TypeError("Age must be an integer")
    if age < 0:
        raise ValueError("Age cannot be negative")
    if age > 150:
        raise ValueError("Age cannot exceed 150")
    return True

# test_validator.py
import unittest
from validator import validate_age

class TestValidator(unittest.TestCase):
    def test_valid_age(self):
        self.assertTrue(validate_age(25))
    
    def test_negative_age(self):
        with self.assertRaises(ValueError):
            validate_age(-5)
    
    def test_too_old(self):
        with self.assertRaises(ValueError):
            validate_age(200)
    
    def test_non_integer(self):
        with self.assertRaises(TypeError):
            validate_age("25")
```

### Example 4: Testing with Mock Data

```python
import unittest
from unittest.mock import Mock, patch

class TestAPI(unittest.TestCase):
    @patch('requests.get')
    def test_fetch_data(self, mock_get):
        # Mock the response
        mock_response = Mock()
        mock_response.json.return_value = {'data': 'test'}
        mock_get.return_value = mock_response
        
        # Test the function
        from api import fetch_data
        result = fetch_data('https://api.example.com')
        
        self.assertEqual(result, {'data': 'test'})
        mock_get.assert_called_once_with('https://api.example.com')
```

---

## Common Testing Patterns

### Pattern 1: Arrange-Act-Assert (AAA)

```python
class TestCalculator(unittest.TestCase):
    def test_add(self):
        # Arrange
        calc = Calculator()
        x, y = 2, 3
        
        # Act
        result = calc.add(x, y)
        
        # Assert
        self.assertEqual(result, 5)
```

### Pattern 2: Test Edge Cases

```python
class TestCalculator(unittest.TestCase):
    def test_add_zero(self):
        self.assertEqual(add(5, 0), 5)
    
    def test_add_negative(self):
        self.assertEqual(add(-2, -3), -5)
    
    def test_add_large_numbers(self):
        self.assertEqual(add(1000000, 2000000), 3000000)
```

### Pattern 3: Test Error Cases

```python
class TestValidator(unittest.TestCase):
    def test_invalid_input(self):
        with self.assertRaises(ValueError):
            validate_age(-1)
    
    def test_wrong_type(self):
        with self.assertRaises(TypeError):
            validate_age("25")
```

---

## Common Mistakes and Pitfalls

### 1. Not Testing Edge Cases

```python
# WRONG: Only testing happy path
def test_add(self):
    self.assertEqual(add(2, 3), 5)

# CORRECT: Test edge cases
def test_add(self):
    self.assertEqual(add(2, 3), 5)
    self.assertEqual(add(0, 0), 0)
    self.assertEqual(add(-2, -3), -5)
```

### 2. Testing Implementation Instead of Behavior

```python
# WRONG: Testing implementation details
def test_internal_variable(self):
    self.assertEqual(obj._internal_var, 5)

# CORRECT: Test behavior
def test_public_method(self):
    result = obj.public_method()
    self.assertEqual(result, expected)
```

### 3. Not Isolating Tests

```python
# WRONG: Tests depend on each other
def test_step1(self):
    self.obj.value = 5

def test_step2(self):
    self.assertEqual(self.obj.value, 5)  # Depends on test_step1

# CORRECT: Each test is independent
def test_step1(self):
    obj = MyClass()
    obj.value = 5
    self.assertEqual(obj.value, 5)

def test_step2(self):
    obj = MyClass()
    obj.value = 10
    self.assertEqual(obj.value, 10)
```

### 4. Not Cleaning Up

```python
# WRONG: No cleanup
def test_file_operation(self):
    with open('test.txt', 'w') as f:
        f.write('test')
    # File not cleaned up

# CORRECT: Clean up in tearDown
def tearDown(self):
    if os.path.exists('test.txt'):
        os.remove('test.txt')
```

---

## Best Practices

### 1. Write Tests First (TDD)

Test-Driven Development (TDD):
1. Write a failing test
2. Write code to make it pass
3. Refactor

### 2. Test One Thing at a Time

```python
# Good: One assertion per test concept
def test_add_positive(self):
    self.assertEqual(add(2, 3), 5)

def test_add_negative(self):
    self.assertEqual(add(-2, -3), -5)
```

### 3. Use Descriptive Test Names

```python
# Good: Descriptive name
def test_add_returns_sum_of_two_positive_numbers(self):
    pass

# Bad: Unclear name
def test_add(self):
    pass
```

### 4. Keep Tests Simple

```python
# Good: Simple and clear
def test_add(self):
    result = add(2, 3)
    self.assertEqual(result, 5)

# Bad: Complex and hard to understand
def test_add(self):
    result = add(2, 3)
    if result == 5:
        self.assertTrue(True)
    else:
        self.assertTrue(False)
```

### 5. Test Edge Cases

```python
def test_divide(self):
    self.assertEqual(divide(10, 2), 5)
    self.assertEqual(divide(10, -2), -5)
    with self.assertRaises(ZeroDivisionError):
        divide(10, 0)
```

### 6. Use Fixtures for Setup

```python
def setUp(self):
    self.calculator = Calculator()
    self.test_data = [1, 2, 3, 4, 5]
```

---

## Practice Exercise

### Exercise: Writing Tests

**Objective**: Create a Python program that demonstrates testing basics.

**Instructions**:

1. Create a file called `test_practice.py`

2. Write a program that:
   - Tests simple functions
   - Tests classes
   - Uses test fixtures
   - Tests exceptions
   - Demonstrates test organization

3. Your program should include:
   - Basic test cases
   - setUp and tearDown
   - Multiple test methods
   - Exception testing
   - Edge case testing
   - Real-world examples

**Example Solution**:

```python
"""
Testing Basics Practice
This program demonstrates unittest module.
"""

import unittest
import os

# Code to test
def add(x, y):
    return x + y

def divide(x, y):
    if y == 0:
        raise ZeroDivisionError("Cannot divide by zero")
    return x / y

class Calculator:
    def __init__(self):
        self.history = []
    
    def add(self, x, y):
        result = x + y
        self.history.append(f"{x} + {y} = {result}")
        return result
    
    def subtract(self, x, y):
        result = x - y
        self.history.append(f"{x} - {y} = {result}")
        return result
    
    def get_history(self):
        return self.history

# Test cases
class TestAddFunction(unittest.TestCase):
    def test_add_positive(self):
        self.assertEqual(add(2, 3), 5)
    
    def test_add_negative(self):
        self.assertEqual(add(-2, -3), -5)
    
    def test_add_zero(self):
        self.assertEqual(add(5, 0), 5)
        self.assertEqual(add(0, 5), 5)
    
    def test_add_mixed(self):
        self.assertEqual(add(-2, 3), 1)

class TestDivideFunction(unittest.TestCase):
    def test_divide_positive(self):
        self.assertEqual(divide(10, 2), 5)
    
    def test_divide_negative(self):
        self.assertEqual(divide(10, -2), -5)
    
    def test_divide_zero(self):
        with self.assertRaises(ZeroDivisionError):
            divide(10, 0)
    
    def test_divide_float_result(self):
        self.assertEqual(divide(7, 2), 3.5)

class TestCalculator(unittest.TestCase):
    def setUp(self):
        """Run before each test."""
        self.calc = Calculator()
    
    def tearDown(self):
        """Run after each test."""
        self.calc.history.clear()
    
    def test_add(self):
        result = self.calc.add(2, 3)
        self.assertEqual(result, 5)
        self.assertEqual(len(self.calc.history), 1)
    
    def test_subtract(self):
        result = self.calc.subtract(5, 3)
        self.assertEqual(result, 2)
        self.assertEqual(len(self.calc.history), 1)
    
    def test_history(self):
        self.calc.add(1, 2)
        self.calc.subtract(5, 3)
        history = self.calc.get_history()
        self.assertEqual(len(history), 2)
        self.assertIn("1 + 2 = 3", history)
        self.assertIn("5 - 3 = 2", history)

class TestCalculatorClass(unittest.TestCase):
    @classmethod
    def setUpClass(cls):
        """Run once before all tests."""
        cls.shared_calc = Calculator()
    
    def test_shared_calculator(self):
        result = self.shared_calc.add(10, 20)
        self.assertEqual(result, 30)

class TestFileOperations(unittest.TestCase):
    def setUp(self):
        self.test_file = 'test_file.txt'
    
    def tearDown(self):
        if os.path.exists(self.test_file):
            os.remove(self.test_file)
    
    def test_file_creation(self):
        with open(self.test_file, 'w') as f:
            f.write('test content')
        self.assertTrue(os.path.exists(self.test_file))
    
    def test_file_content(self):
        with open(self.test_file, 'w') as f:
            f.write('test content')
        with open(self.test_file, 'r') as f:
            content = f.read()
        self.assertEqual(content, 'test content')

class TestAssertions(unittest.TestCase):
    def test_assert_equal(self):
        self.assertEqual(2 + 2, 4)
    
    def test_assert_not_equal(self):
        self.assertNotEqual(2 + 2, 5)
    
    def test_assert_true(self):
        self.assertTrue(True)
        self.assertTrue(1)
        self.assertTrue([1, 2, 3])
    
    def test_assert_false(self):
        self.assertFalse(False)
        self.assertFalse(0)
        self.assertFalse([])
    
    def test_assert_is(self):
        a = [1, 2, 3]
        b = a
        self.assertIs(a, b)
    
    def test_assert_is_not(self):
        a = [1, 2, 3]
        b = [1, 2, 3]
        self.assertIsNot(a, b)
    
    def test_assert_is_none(self):
        self.assertIsNone(None)
    
    def test_assert_is_not_none(self):
        self.assertIsNotNone(42)
        self.assertIsNotNone([1, 2, 3])
    
    def test_assert_in(self):
        self.assertIn(2, [1, 2, 3])
        self.assertIn('a', 'abc')
    
    def test_assert_not_in(self):
        self.assertNotIn(4, [1, 2, 3])
        self.assertNotIn('d', 'abc')
    
    def test_assert_is_instance(self):
        self.assertIsInstance([1, 2, 3], list)
        self.assertIsInstance('hello', str)
        self.assertIsInstance(42, int)
    
    def test_assert_raises(self):
        with self.assertRaises(ValueError):
            int("not a number")
        
        with self.assertRaises(ZeroDivisionError):
            1 / 0

if __name__ == '__main__':
    unittest.main(verbosity=2)
```

**Expected Output** (truncated):
```
test_add_negative (__main__.TestAddFunction) ... ok
test_add_positive (__main__.TestAddFunction) ... ok
test_add_zero (__main__.TestAddFunction) ... ok
test_divide_negative (__main__.TestDivideFunction) ... ok
test_divide_positive (__main__.TestDivideFunction) ... ok
test_divide_zero (__main__.TestDivideFunction) ... ok

[... rest of output ...]

----------------------------------------------------------------------
Ran 25 tests in 0.001s

OK
```

**Challenge** (Optional):
- Create a test suite for a complete module
- Write tests for edge cases and error conditions
- Implement test fixtures for complex setup
- Create integration tests that test multiple components together

---

## Key Takeaways

1. **Why test** - catch bugs, document code, enable refactoring
2. **Unit testing** - test individual components in isolation
3. **unittest module** - Python's built-in testing framework
4. **Test structure** - TestCase class with test methods
5. **Assertions** - verify expected behavior
6. **Fixtures** - setUp, tearDown, setUpClass, tearDownClass
7. **Test organization** - organize tests in classes and modules
8. **Test discovery** - unittest can automatically find tests
9. **Best practices** - write tests first, test one thing, use descriptive names
10. **Edge cases** - test boundary conditions and error cases
11. **Isolation** - each test should be independent
12. **Cleanup** - always clean up in tearDown
13. **AAA pattern** - Arrange-Act-Assert
14. **Test names** - use descriptive test method names
15. **Test coverage** - aim for good test coverage

---

## Quiz: Testing Basics

Test your understanding with these questions:

1. **What is unit testing?**
   - A) Testing the entire system
   - B) Testing individual components in isolation
   - C) Testing user interfaces
   - D) Testing databases

2. **What module provides testing functionality?**
   - A) test
   - B) unittest
   - C) testing
   - D) pytest

3. **What must test methods start with?**
   - A) test_
   - B) check_
   - C) verify_
   - D) assert_

4. **What does setUp do?**
   - A) Runs after each test
   - B) Runs before each test
   - C) Runs once before all tests
   - D) Nothing

5. **What does tearDown do?**
   - A) Runs after each test
   - B) Runs before each test
   - C) Runs once after all tests
   - D) Nothing

6. **What is an assertion?**
   - A) A test method
   - B) A verification of expected behavior
   - C) A test class
   - D) A fixture

7. **What is the AAA pattern?**
   - A) Arrange, Act, Assert
   - B) Act, Arrange, Assert
   - C) Assert, Arrange, Act
   - D) Arrange, Assert, Act

8. **What should test names be?**
   - A) Short
   - B) Descriptive
   - C) Random
   - D) Numbers

9. **Should tests depend on each other?**
   - A) Yes
   - B) No
   - C) Sometimes
   - D) Only in unittest

10. **What is TDD?**
    - A) Test-Driven Development
    - B) Test Design Document
    - C) Test Data Definition
    - D) Test Development Document

**Answers**:
1. B) Testing individual components in isolation (unit testing definition)
2. B) unittest (Python's testing module)
3. A) test_ (test method naming convention)
4. B) Runs before each test (setUp purpose)
5. A) Runs after each test (tearDown purpose)
6. B) A verification of expected behavior (assertion definition)
7. A) Arrange, Act, Assert (AAA pattern)
8. B) Descriptive (test naming best practice)
9. B) No (tests should be independent)
10. A) Test-Driven Development (TDD definition)

---

## Next Steps

Excellent work! You've mastered testing basics. You now understand:
- Why testing is important
- Unit testing concepts
- The unittest module
- How to write and organize tests

**What's Next?**
- Lesson 17.2: pytest Framework
- Learn pytest basics
- Understand pytest features
- Explore advanced pytest patterns

---

## Additional Resources

- **unittest**: [docs.python.org/3/library/unittest.html](https://docs.python.org/3/library/unittest.html)
- **Test-Driven Development**: [en.wikipedia.org/wiki/Test-driven_development](https://en.wikipedia.org/wiki/Test-driven_development)
- **Testing Best Practices**: [docs.python-guide.org/writing/tests/](https://docs.python-guide.org/writing/tests/)

---

*Lesson completed! You're ready to move on to the next lesson.*

