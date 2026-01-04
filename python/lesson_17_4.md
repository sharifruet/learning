# Lesson 17.4: Mocking and Patching

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand unittest.mock module
- Create and use mock objects
- Use patching techniques
- Mock functions and methods
- Mock external dependencies
- Use MagicMock and Mock
- Apply mocking in tests
- Understand when to use mocks
- Debug mocking issues
- Follow mocking best practices

---

## Introduction to Mocking

**Mocking** is the practice of replacing real objects with fake objects (mocks) in tests. This allows you to test code in isolation without depending on external systems.

### Why Mocking?

- **Isolation**: Test code without external dependencies
- **Speed**: Avoid slow operations (network, database)
- **Control**: Control behavior of dependencies
- **Reliability**: Tests don't depend on external systems
- **Focus**: Test your code, not dependencies

### What is Mocking?

Mocking involves replacing real objects with mock objects that simulate their behavior.

---

## unittest.mock Module

### Basic Mock

The `unittest.mock` module provides the `Mock` class:

```python
from unittest.mock import Mock

# Create a mock object
mock_obj = Mock()

# Use the mock
mock_obj.some_method()
mock_obj.some_attribute

# Verify calls
mock_obj.some_method.assert_called_once()
```

### Mock Return Values

```python
from unittest.mock import Mock

# Create mock with return value
mock_func = Mock(return_value=42)
result = mock_func()
print(result)  # 42

# Set return value
mock_func.return_value = 100
result = mock_func()
print(result)  # 100
```

### Mock Side Effects

```python
from unittest.mock import Mock

# Mock that raises exception
mock_func = Mock(side_effect=ValueError("Error"))
# mock_func()  # Raises ValueError

# Mock with multiple side effects
mock_func = Mock(side_effect=[1, 2, 3])
print(mock_func())  # 1
print(mock_func())  # 2
print(mock_func())  # 3
```

---

## Mock Objects

### Creating Mock Objects

```python
from unittest.mock import Mock

# Basic mock
mock = Mock()

# Mock with attributes
mock = Mock(name="test_mock")
mock.attribute = "value"

# Mock with methods
mock = Mock()
mock.method.return_value = "result"
print(mock.method())  # result
```

### Configuring Mocks

```python
from unittest.mock import Mock

# Configure mock
mock = Mock()
mock.method.return_value = 42
mock.attribute = "test"

# Use configured mock
result = mock.method()
print(result)  # 42
print(mock.attribute)  # test
```

### MagicMock

`MagicMock` is like `Mock` but supports magic methods:

```python
from unittest.mock import MagicMock

# MagicMock supports magic methods
mock = MagicMock()
mock.__len__.return_value = 5
print(len(mock))  # 5

# Supports operators
mock = MagicMock()
mock.__str__.return_value = "Mock object"
print(str(mock))  # Mock object
```

### Mock Attributes

```python
from unittest.mock import Mock

# Set attributes
mock = Mock()
mock.attribute = "value"
print(mock.attribute)  # value

# Access non-existent attributes (creates new mock)
mock = Mock()
print(mock.new_attribute)  # <Mock name='mock.new_attribute' id='...'>
```

---

## Verifying Mock Calls

### Asserting Calls

```python
from unittest.mock import Mock

mock = Mock()

# Call the mock
mock.method(1, 2, key="value")

# Verify it was called
mock.method.assert_called_once()
mock.method.assert_called_with(1, 2, key="value")
mock.method.assert_called_once_with(1, 2, key="value")
```

### Call Count

```python
from unittest.mock import Mock

mock = Mock()
mock.method()
mock.method()
mock.method()

# Check call count
assert mock.method.call_count == 3
mock.method.assert_called()
```

### Call Arguments

```python
from unittest.mock import Mock

mock = Mock()
mock.method(1, 2, key="value")

# Check arguments
args, kwargs = mock.method.call_args
print(args)  # (1, 2)
print(kwargs)  # {'key': 'value'}

# Check all calls
print(mock.method.call_args_list)
# [call(1, 2, key='value')]
```

### Call History

```python
from unittest.mock import Mock, call

mock = Mock()
mock.method(1)
mock.method(2)
mock.method(3)

# Check call history
expected_calls = [call(1), call(2), call(3)]
mock.method.assert_has_calls(expected_calls)
```

---

## Patching

### @patch Decorator

The `@patch` decorator replaces objects with mocks:

```python
from unittest.mock import patch

@patch('module.function')
def test_something(mock_function):
    mock_function.return_value = 42
    result = module.function()
    assert result == 42
```

### patch() Context Manager

```python
from unittest.mock import patch

def test_something():
    with patch('module.function') as mock_function:
        mock_function.return_value = 42
        result = module.function()
        assert result == 42
```

### Patching Objects

```python
from unittest.mock import patch, Mock

@patch('module.ClassName')
def test_something(mock_class):
    mock_instance = Mock()
    mock_class.return_value = mock_instance
    mock_instance.method.return_value = "result"
    
    obj = module.ClassName()
    result = obj.method()
    assert result == "result"
```

### Patching Methods

```python
from unittest.mock import patch

class MyClass:
    def method(self):
        return "real"

@patch.object(MyClass, 'method')
def test_method(mock_method):
    mock_method.return_value = "mocked"
    obj = MyClass()
    result = obj.method()
    assert result == "mocked"
```

### Patching Multiple Objects

```python
from unittest.mock import patch

@patch('module.function1')
@patch('module.function2')
def test_multiple(mock_func2, mock_func1):
    mock_func1.return_value = 1
    mock_func2.return_value = 2
    # Test code
```

---

## Practical Examples

### Example 1: Mocking API Calls

```python
from unittest.mock import patch, Mock
import requests

def fetch_data(url):
    response = requests.get(url)
    return response.json()

@patch('requests.get')
def test_fetch_data(mock_get):
    # Mock response
    mock_response = Mock()
    mock_response.json.return_value = {'data': 'test'}
    mock_get.return_value = mock_response
    
    # Test
    result = fetch_data('https://api.example.com')
    
    # Assertions
    assert result == {'data': 'test'}
    mock_get.assert_called_once_with('https://api.example.com')
```

### Example 2: Mocking Database

```python
from unittest.mock import Mock, patch

class Database:
    def query(self, sql):
        # Real database query
        pass

def get_user_count(db):
    result = db.query("SELECT COUNT(*) FROM users")
    return result

@patch('module.Database')
def test_get_user_count(mock_db_class):
    # Mock database instance
    mock_db = Mock()
    mock_db_class.return_value = mock_db
    mock_db.query.return_value = 42
    
    # Test
    db = Database()
    count = get_user_count(db)
    
    assert count == 42
    mock_db.query.assert_called_once_with("SELECT COUNT(*) FROM users")
```

### Example 3: Mocking File Operations

```python
from unittest.mock import patch, mock_open

def read_config(filename):
    with open(filename, 'r') as f:
        return f.read()

@patch('builtins.open', new_callable=mock_open, read_data='config data')
def test_read_config(mock_file):
    result = read_config('config.txt')
    assert result == 'config data'
    mock_file.assert_called_once_with('config.txt', 'r')
```

### Example 4: Mocking Time

```python
from unittest.mock import patch
import time

def get_timestamp():
    return time.time()

@patch('time.time')
def test_get_timestamp(mock_time):
    mock_time.return_value = 1234567890
    result = get_timestamp()
    assert result == 1234567890
```

### Example 5: Mocking Random

```python
from unittest.mock import patch
import random

def roll_dice():
    return random.randint(1, 6)

@patch('random.randint')
def test_roll_dice(mock_randint):
    mock_randint.return_value = 5
    result = roll_dice()
    assert result == 5
    mock_randint.assert_called_once_with(1, 6)
```

---

## Advanced Mocking Techniques

### Mocking Properties

```python
from unittest.mock import Mock, PropertyMock

class MyClass:
    @property
    def value(self):
        return "real"

@patch.object(MyClass, 'value', new_callable=PropertyMock)
def test_property(mock_value):
    mock_value.return_value = "mocked"
    obj = MyClass()
    assert obj.value == "mocked"
```

### Mocking Context Managers

```python
from unittest.mock import Mock, MagicMock

mock_context = MagicMock()
mock_context.__enter__.return_value = "entered"
mock_context.__exit__.return_value = False

with mock_context as value:
    assert value == "entered"
```

### Mocking Iterables

```python
from unittest.mock import Mock

mock_iterable = Mock()
mock_iterable.__iter__.return_value = iter([1, 2, 3])

for item in mock_iterable:
    print(item)  # 1, 2, 3
```

### Spec and SpecSet

```python
from unittest.mock import Mock

# spec restricts mock to specified attributes
class MyClass:
    def method(self):
        pass
    attribute = "value"

# Mock with spec
mock = Mock(spec=MyClass)
mock.method()  # OK
# mock.unknown()  # AttributeError

# spec_set is stricter (can't add attributes)
mock = Mock(spec_set=MyClass)
# mock.new_attr = "value"  # AttributeError
```

---

## Common Patterns

### Pattern 1: Mock External Service

```python
from unittest.mock import patch

@patch('requests.post')
def test_api_call(mock_post):
    mock_post.return_value.json.return_value = {'status': 'success'}
    # Test code that uses API
```

### Pattern 2: Mock Database

```python
from unittest.mock import Mock

def test_database_operation():
    mock_db = Mock()
    mock_db.execute.return_value = 1
    # Test code
```

### Pattern 3: Mock File I/O

```python
from unittest.mock import patch, mock_open

@patch('builtins.open', new_callable=mock_open, read_data='content')
def test_file_read(mock_file):
    # Test code that reads file
    pass
```

### Pattern 4: Mock Time-Dependent Code

```python
from unittest.mock import patch
from datetime import datetime

@patch('datetime.datetime')
def test_time_dependent(mock_datetime):
    mock_datetime.now.return_value = datetime(2024, 1, 1)
    # Test code
```

---

## Common Mistakes and Pitfalls

### 1. Patching Wrong Location

```python
# WRONG: Patching where it's defined
@patch('module.requests.get')

# CORRECT: Patch where it's used
@patch('my_module.requests.get')
```

### 2. Not Resetting Mocks

```python
# WRONG: Mock state persists
mock = Mock()
mock.method()
# Mock still has call history

# CORRECT: Reset when needed
mock.reset_mock()
```

### 3. Over-Mocking

```python
# WRONG: Mocking everything
@patch('module.function1')
@patch('module.function2')
@patch('module.function3')
# Too many mocks!

# CORRECT: Mock only what's necessary
@patch('module.external_dependency')
```

### 4. Not Verifying Calls

```python
# WRONG: Don't verify mock was called
mock.method()
# No assertion

# CORRECT: Verify calls
mock.method.assert_called_once()
```

---

## Best Practices

### 1. Mock External Dependencies

```python
# Mock external services, databases, file I/O
@patch('requests.get')
def test_api(mock_get):
    pass
```

### 2. Use Specs for Type Safety

```python
mock = Mock(spec=MyClass)
```

### 3. Verify Important Calls

```python
mock.method.assert_called_once_with(expected_args)
```

### 4. Keep Mocks Simple

```python
# Simple mock
mock.return_value = 42

# Avoid complex mock setups
```

### 5. Use Context Managers When Appropriate

```python
with patch('module.function') as mock_func:
    # Test code
    pass
```

### 6. Document Mock Behavior

```python
# Mock that simulates API response
mock_api.return_value = {'status': 'success'}
```

---

## Practice Exercise

### Exercise: Mocking

**Objective**: Create a Python program that demonstrates mocking and patching.

**Instructions**:

1. Create a file called `test_mocking_practice.py`

2. Write a program that:
   - Creates mock objects
   - Uses patching
   - Mocks external dependencies
   - Verifies mock calls
   - Demonstrates practical applications

3. Your program should include:
   - Basic Mock usage
   - MagicMock usage
   - Patching functions
   - Patching methods
   - Mocking API calls
   - Mocking file operations
   - Verifying calls
   - Real-world examples

**Example Solution**:

```python
"""
Mocking and Patching Practice
This program demonstrates unittest.mock features.
"""

from unittest.mock import Mock, MagicMock, patch, mock_open, PropertyMock
import unittest

# Code to test
def fetch_user_data(user_id):
    import requests
    response = requests.get(f'https://api.example.com/users/{user_id}')
    return response.json()

def process_file(filename):
    with open(filename, 'r') as f:
        return f.read().upper()

class UserService:
    def __init__(self, db):
        self.db = db
    
    def get_user(self, user_id):
        return self.db.query(f"SELECT * FROM users WHERE id={user_id}")

# Test cases
class TestMocking(unittest.TestCase):
    
    # 1. Basic Mock
    def test_basic_mock(self):
        mock = Mock()
        mock.method.return_value = 42
        result = mock.method()
        self.assertEqual(result, 42)
        mock.method.assert_called_once()
    
    # 2. Mock with return value
    def test_mock_return_value(self):
        mock_func = Mock(return_value="result")
        self.assertEqual(mock_func(), "result")
    
    # 3. Mock with side effect
    def test_mock_side_effect(self):
        mock_func = Mock(side_effect=[1, 2, 3])
        self.assertEqual(mock_func(), 1)
        self.assertEqual(mock_func(), 2)
        self.assertEqual(mock_func(), 3)
    
    # 4. Mock that raises exception
    def test_mock_exception(self):
        mock_func = Mock(side_effect=ValueError("Error"))
        with self.assertRaises(ValueError):
            mock_func()
    
    # 5. MagicMock
    def test_magic_mock(self):
        mock = MagicMock()
        mock.__len__.return_value = 5
        self.assertEqual(len(mock), 5)
    
    # 6. Verifying calls
    def test_verify_calls(self):
        mock = Mock()
        mock.method(1, 2, key="value")
        mock.method.assert_called_once()
        mock.method.assert_called_with(1, 2, key="value")
    
    # 7. Call count
    def test_call_count(self):
        mock = Mock()
        mock.method()
        mock.method()
        mock.method()
        self.assertEqual(mock.method.call_count, 3)
    
    # 8. Patching function
    @patch('requests.get')
    def test_patch_function(self, mock_get):
        mock_response = Mock()
        mock_response.json.return_value = {'id': 1, 'name': 'Alice'}
        mock_get.return_value = mock_response
        
        result = fetch_user_data(1)
        
        self.assertEqual(result, {'id': 1, 'name': 'Alice'})
        mock_get.assert_called_once_with('https://api.example.com/users/1')
    
    # 9. Patching with context manager
    def test_patch_context_manager(self):
        with patch('requests.get') as mock_get:
            mock_response = Mock()
            mock_response.json.return_value = {'status': 'ok'}
            mock_get.return_value = mock_response
            
            result = fetch_user_data(1)
            self.assertEqual(result, {'status': 'ok'})
    
    # 10. Patching file operations
    @patch('builtins.open', new_callable=mock_open, read_data='test content')
    def test_patch_file(self, mock_file):
        result = process_file('test.txt')
        self.assertEqual(result, 'TEST CONTENT')
        mock_file.assert_called_once_with('test.txt', 'r')
    
    # 11. Patching method
    def test_patch_method(self):
        mock_db = Mock()
        mock_db.query.return_value = {'id': 1, 'name': 'Alice'}
        
        service = UserService(mock_db)
        result = service.get_user(1)
        
        self.assertEqual(result, {'id': 1, 'name': 'Alice'})
        mock_db.query.assert_called_once_with("SELECT * FROM users WHERE id=1")
    
    # 12. Patching multiple objects
    @patch('module.function2')
    @patch('module.function1')
    def test_patch_multiple(self, mock_func1, mock_func2):
        mock_func1.return_value = 1
        mock_func2.return_value = 2
        # Test code
        pass
    
    # 13. Mock with spec
    def test_mock_with_spec(self):
        class MyClass:
            def method(self):
                pass
            attribute = "value"
        
        mock = Mock(spec=MyClass)
        mock.method()  # OK
        # mock.unknown()  # Would raise AttributeError
    
    # 14. Mock property
    def test_mock_property(self):
        class MyClass:
            @property
            def value(self):
                return "real"
        
        with patch.object(MyClass, 'value', new_callable=PropertyMock) as mock_prop:
            mock_prop.return_value = "mocked"
            obj = MyClass()
            self.assertEqual(obj.value, "mocked")
    
    # 15. Mock context manager
    def test_mock_context_manager(self):
        mock_cm = MagicMock()
        mock_cm.__enter__.return_value = "entered"
        mock_cm.__exit__.return_value = False
        
        with mock_cm as value:
            self.assertEqual(value, "entered")
        
        mock_cm.__enter__.assert_called_once()
        mock_cm.__exit__.assert_called_once()
    
    # 16. Mock iterable
    def test_mock_iterable(self):
        mock_iter = Mock()
        mock_iter.__iter__.return_value = iter([1, 2, 3])
        
        result = list(mock_iter)
        self.assertEqual(result, [1, 2, 3])
    
    # 17. Real-world: Mocking API service
    def test_mock_api_service(self):
        mock_api = Mock()
        mock_api.get_user.return_value = {'id': 1, 'name': 'Alice', 'email': 'alice@example.com'}
        
        user = mock_api.get_user(1)
        self.assertEqual(user['name'], 'Alice')
        mock_api.get_user.assert_called_once_with(1)
    
    # 18. Real-world: Mocking database
    def test_mock_database(self):
        mock_db = Mock()
        mock_db.execute.return_value = 1
        mock_db.fetchall.return_value = [{'id': 1, 'name': 'Alice'}]
        
        mock_db.execute("INSERT INTO users (name) VALUES (?)", ("Alice",))
        users = mock_db.fetchall()
        
        self.assertEqual(len(users), 1)
        self.assertEqual(users[0]['name'], 'Alice')
    
    # 19. Real-world: Mocking time
    @patch('time.sleep')
    def test_mock_time(self, mock_sleep):
        import time
        time.sleep(5)  # Doesn't actually sleep
        mock_sleep.assert_called_once_with(5)
    
    # 20. Real-world: Mocking random
    @patch('random.randint')
    def test_mock_random(self, mock_randint):
        import random
        mock_randint.return_value = 5
        result = random.randint(1, 6)
        self.assertEqual(result, 5)
        mock_randint.assert_called_once_with(1, 6)

if __name__ == '__main__':
    unittest.main()
```

**Expected Output** (when running `python -m unittest test_mocking_practice.py -v`):
```
test_basic_mock (__main__.TestMocking) ... ok
test_call_count (__main__.TestMocking) ... ok
test_magic_mock (__main__.TestMocking) ... ok
[... rest of output ...]

----------------------------------------------------------------------
Ran 20 tests in 0.002s

OK
```

**Challenge** (Optional):
- Create mocks for a complete external API
- Build a test suite that mocks a database layer
- Implement mocks for file system operations
- Create mocks for complex third-party libraries

---

## Key Takeaways

1. **unittest.mock** - Python's mocking module
2. **Mock objects** - fake objects that simulate behavior
3. **MagicMock** - Mock with magic method support
4. **Patching** - replacing objects with mocks
5. **@patch decorator** - decorator for patching
6. **patch() context manager** - context manager for patching
7. **Verifying calls** - assert_called, assert_called_with, etc.
8. **Mock configuration** - return_value, side_effect, spec
9. **External dependencies** - mock APIs, databases, file I/O
10. **Isolation** - test code without dependencies
11. **Speed** - avoid slow operations in tests
12. **Control** - control dependency behavior
13. **Best practices** - mock external deps, use specs, verify calls
14. **Common mistakes** - patching wrong location, over-mocking
15. **When to use** - external dependencies, slow operations, unreliable services

---

## Quiz: Mocking

Test your understanding with these questions:

1. **What is mocking?**
   - A) Testing real objects
   - B) Replacing real objects with fake objects
   - C) Creating real objects
   - D) Deleting objects

2. **What module provides mocking in Python?**
   - A) mock
   - B) unittest.mock
   - C) testing.mock
   - D) fake

3. **What is the difference between Mock and MagicMock?**
   - A) No difference
   - B) MagicMock supports magic methods
   - C) Mock is faster
   - D) MagicMock is slower

4. **What does @patch do?**
   - A) Creates a mock
   - B) Replaces object with mock
   - C) Deletes object
   - D) Nothing

5. **Where should you patch an object?**
   - A) Where it's defined
   - B) Where it's used
   - C) Anywhere
   - D) Nowhere

6. **What does return_value do?**
   - A) Sets return value for mock
   - B) Gets return value
   - C) Deletes return value
   - D) Nothing

7. **What does side_effect do?**
   - A) Sets return value
   - B) Sets side effects (exceptions, multiple returns)
   - C) Deletes side effects
   - D) Nothing

8. **How do you verify a mock was called?**
   - A) mock.assert_called()
   - B) mock.was_called()
   - C) mock.called()
   - D) check(mock)

9. **What is spec used for?**
   - A) Speed up mocks
   - B) Restrict mock to specified attributes
   - C) Delete attributes
   - D) Nothing

10. **When should you use mocks?**
    - A) Always
    - B) For external dependencies
    - C) Never
    - D) Only in unittest

**Answers**:
1. B) Replacing real objects with fake objects (mocking definition)
2. B) unittest.mock (Python's mocking module)
3. B) MagicMock supports magic methods (difference)
4. B) Replaces object with mock (@patch purpose)
5. B) Where it's used (patching location)
6. A) Sets return value for mock (return_value purpose)
7. B) Sets side effects (exceptions, multiple returns) (side_effect purpose)
8. A) mock.assert_called() (verifying calls)
9. B) Restrict mock to specified attributes (spec purpose)
10. B) For external dependencies (when to use mocks)

---

## Next Steps

Excellent work! You've mastered mocking and patching. You now understand:
- unittest.mock module
- Mock objects
- Patching techniques
- When and how to use mocks

**What's Next?**
- Module 18: Performance Optimization
- Learn about profiling
- Understand performance measurement
- Explore optimization techniques

---

## Additional Resources

- **unittest.mock**: [docs.python.org/3/library/unittest.mock.html](https://docs.python.org/3/library/unittest.mock.html)
- **Mock Objects**: [en.wikipedia.org/wiki/Mock_object](https://en.wikipedia.org/wiki/Mock_object)
- **Patching**: [docs.python.org/3/library/unittest.mock.html#patch](https://docs.python.org/3/library/unittest.mock.html#patch)

---

*Lesson completed! You're ready to move on to the next module.*

