# Lesson 17.2: pytest Framework

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand pytest basics
- Use pytest fixtures
- Apply parametrization
- Run pytest tests
- Use pytest markers
- Understand pytest configuration
- Apply pytest best practices
- Debug pytest tests
- Use advanced pytest features
- Understand when to use pytest vs unittest

---

## Introduction to pytest

**pytest** is a popular Python testing framework that makes it easy to write simple and scalable tests. It's more Pythonic and feature-rich than unittest.

### Why pytest?

- **Simple syntax**: Less boilerplate than unittest
- **Powerful fixtures**: Flexible fixture system
- **Parametrization**: Easy test parametrization
- **Better assertions**: Detailed failure messages
- **Plugin ecosystem**: Many plugins available
- **Auto-discovery**: Automatically finds tests
- **Rich output**: Better test output and reporting

### What is pytest?

pytest is a testing framework that uses Python's assert statement and provides powerful features for testing.

---

## pytest Basics

### Simple Test Function

pytest tests are just functions that start with `test_`:

```python
# test_example.py
def test_add():
    assert add(2, 3) == 5

def test_subtract():
    assert subtract(5, 3) == 2
```

### Running Tests

```bash
# Run all tests
pytest

# Run specific file
pytest test_example.py

# Run specific test
pytest test_example.py::test_add

# Run with verbosity
pytest -v

# Run with output
pytest -s
```

### Assert Statements

pytest uses Python's assert statement:

```python
def test_assertions():
    assert True
    assert 1 == 1
    assert "hello" == "hello"
    assert [1, 2, 3] == [1, 2, 3]
    assert 2 in [1, 2, 3]
    assert "a" in "abc"
```

### Better Assertions

pytest provides detailed failure messages:

```python
def test_detailed_assertion():
    x = [1, 2, 3]
    y = [1, 2, 4]
    assert x == y  # Shows detailed diff
```

### Test Discovery

pytest automatically discovers tests:
- Files named `test_*.py` or `*_test.py`
- Functions named `test_*`
- Classes named `Test*` with methods named `test_*`

```python
# test_calculator.py
def test_add():
    assert add(2, 3) == 5

class TestCalculator:
    def test_subtract(self):
        assert subtract(5, 3) == 2
```

---

## Fixtures

### Basic Fixture

Fixtures provide setup and teardown functionality:

```python
import pytest

@pytest.fixture
def sample_data():
    return [1, 2, 3, 4, 5]

def test_sum(sample_data):
    assert sum(sample_data) == 15
```

### Fixture Scope

Fixtures can have different scopes:

```python
@pytest.fixture(scope="function")  # Default: runs for each test
def function_fixture():
    return "function"

@pytest.fixture(scope="class")  # Runs once per test class
def class_fixture():
    return "class"

@pytest.fixture(scope="module")  # Runs once per module
def module_fixture():
    return "module"

@pytest.fixture(scope="session")  # Runs once per test session
def session_fixture():
    return "session"
```

### Fixture with Setup and Teardown

```python
import pytest

@pytest.fixture
def database():
    # Setup
    db = create_database()
    yield db
    # Teardown
    db.close()

def test_query(database):
    result = database.query("SELECT * FROM users")
    assert result is not None
```

### Fixture Dependencies

Fixtures can depend on other fixtures:

```python
import pytest

@pytest.fixture
def user_data():
    return {"name": "Alice", "age": 25}

@pytest.fixture
def user(user_data):
    return User(**user_data)

def test_user_name(user):
    assert user.name == "Alice"
```

### Autouse Fixtures

Fixtures can automatically run without being requested:

```python
import pytest

@pytest.fixture(autouse=True)
def setup_environment():
    # Runs automatically for all tests
    os.environ['TEST_MODE'] = 'true'
    yield
    del os.environ['TEST_MODE']
```

### Fixture Parameters

Fixtures can be parametrized:

```python
import pytest

@pytest.fixture(params=[1, 2, 3])
def number(request):
    return request.param

def test_number(number):
    assert number > 0
```

### conftest.py

Shared fixtures can be placed in `conftest.py`:

```python
# conftest.py
import pytest

@pytest.fixture
def shared_fixture():
    return "shared"

# test_file.py
def test_something(shared_fixture):
    assert shared_fixture == "shared"
```

---

## Parametrization

### Basic Parametrization

Use `@pytest.mark.parametrize` to run a test with different inputs:

```python
import pytest

@pytest.mark.parametrize("x,y,expected", [
    (2, 3, 5),
    (0, 0, 0),
    (-2, -3, -5),
    (10, -5, 5),
])
def test_add(x, y, expected):
    assert add(x, y) == expected
```

### Multiple Parameters

```python
import pytest

@pytest.mark.parametrize("x", [1, 2, 3])
@pytest.mark.parametrize("y", [10, 20])
def test_multiply(x, y):
    result = x * y
    assert result == x * y
```

### Parametrize with Fixtures

```python
import pytest

@pytest.fixture(params=[1, 2, 3])
def number(request):
    return request.param

def test_square(number):
    assert number ** 2 >= 0
```

### Parametrize Classes

```python
import pytest

@pytest.mark.parametrize("name,age", [
    ("Alice", 25),
    ("Bob", 30),
    ("Charlie", 35),
])
class TestUser:
    def test_user_creation(self, name, age):
        user = User(name, age)
        assert user.name == name
        assert user.age == age
```

---

## Advanced pytest Features

### Markers

Markers allow you to categorize tests:

```python
import pytest

@pytest.mark.slow
def test_slow_operation():
    time.sleep(5)
    assert True

@pytest.mark.integration
def test_integration():
    # Integration test
    pass

# Run only slow tests
# pytest -m slow

# Skip slow tests
# pytest -m "not slow"
```

### Skipping Tests

```python
import pytest

@pytest.mark.skip(reason="Not implemented yet")
def test_future_feature():
    assert False

@pytest.mark.skipif(sys.version_info < (3, 8), reason="Requires Python 3.8+")
def test_python38_feature():
    assert True
```

### Expected Failures

```python
import pytest

@pytest.mark.xfail(reason="Known bug")
def test_known_bug():
    assert False  # Expected to fail
```

### Exception Testing

```python
import pytest

def test_raises_exception():
    with pytest.raises(ValueError):
        int("not a number")

def test_raises_with_message():
    with pytest.raises(ValueError, match="invalid literal"):
        int("not a number")
```

### Temporary Files and Directories

```python
import pytest

def test_file_operations(tmp_path):
    file_path = tmp_path / "test.txt"
    file_path.write_text("test content")
    assert file_path.read_text() == "test content"
```

### Capturing Output

```python
import pytest

def test_print_output(capsys):
    print("Hello, World!")
    captured = capsys.readouterr()
    assert "Hello, World!" in captured.out
```

### Monkeypatching

```python
import pytest

def test_monkeypatch(monkeypatch):
    def mock_time():
        return 1234567890
    
    monkeypatch.setattr(time, "time", mock_time)
    assert time.time() == 1234567890
```

---

## pytest Configuration

### pytest.ini

Create `pytest.ini` for configuration:

```ini
[pytest]
testpaths = tests
python_files = test_*.py
python_classes = Test*
python_functions = test_*
addopts = -v --tb=short
markers =
    slow: marks tests as slow
    integration: marks tests as integration tests
```

### pyproject.toml

Or use `pyproject.toml`:

```toml
[tool.pytest.ini_options]
testpaths = ["tests"]
python_files = "test_*.py"
addopts = "-v"
markers = [
    "slow: marks tests as slow",
    "integration: marks tests as integration tests",
]
```

---

## Practical Examples

### Example 1: Testing a Calculator

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
        if y == 0:
            raise ValueError("Cannot divide by zero")
        return x / y

# test_calculator.py
import pytest
from calculator import Calculator

@pytest.fixture
def calc():
    return Calculator()

@pytest.mark.parametrize("x,y,expected", [
    (2, 3, 5),
    (0, 0, 0),
    (-2, -3, -5),
])
def test_add(calc, x, y, expected):
    assert calc.add(x, y) == expected

def test_divide_by_zero(calc):
    with pytest.raises(ValueError, match="Cannot divide by zero"):
        calc.divide(10, 0)
```

### Example 2: Testing with Database

```python
import pytest

@pytest.fixture(scope="module")
def database():
    db = create_test_database()
    yield db
    db.close()

@pytest.fixture
def user(database):
    user = database.create_user("Alice", "alice@example.com")
    yield user
    database.delete_user(user.id)

def test_user_query(database, user):
    result = database.get_user(user.id)
    assert result.name == "Alice"
```

### Example 3: Testing API Endpoints

```python
import pytest
from fastapi.testclient import TestClient
from app import app

@pytest.fixture
def client():
    return TestClient(app)

def test_get_users(client):
    response = client.get("/users")
    assert response.status_code == 200
    assert isinstance(response.json(), list)

def test_create_user(client):
    response = client.post("/users", json={"name": "Alice", "email": "alice@example.com"})
    assert response.status_code == 201
    assert response.json()["name"] == "Alice"
```

---

## Common Mistakes and Pitfalls

### 1. Not Using Fixtures for Setup

```python
# WRONG: Setup in each test
def test_something():
    db = create_database()
    # test code
    db.close()

# CORRECT: Use fixture
@pytest.fixture
def database():
    db = create_database()
    yield db
    db.close()

def test_something(database):
    # test code
    pass
```

### 2. Forgetting to Request Fixtures

```python
# WRONG: Fixture not requested
@pytest.fixture
def data():
    return [1, 2, 3]

def test_something():
    # data fixture not available
    pass

# CORRECT: Request fixture
def test_something(data):
    assert len(data) == 3
```

### 3. Not Using Parametrization

```python
# WRONG: Multiple similar tests
def test_add_1():
    assert add(1, 2) == 3

def test_add_2():
    assert add(2, 3) == 5

# CORRECT: Use parametrization
@pytest.mark.parametrize("x,y,expected", [
    (1, 2, 3),
    (2, 3, 5),
])
def test_add(x, y, expected):
    assert add(x, y) == expected
```

### 4. Not Cleaning Up in Fixtures

```python
# WRONG: No cleanup
@pytest.fixture
def file():
    f = open('test.txt', 'w')
    return f

# CORRECT: Use yield for cleanup
@pytest.fixture
def file():
    f = open('test.txt', 'w')
    yield f
    f.close()
    os.remove('test.txt')
```

---

## Best Practices

### 1. Use Descriptive Test Names

```python
# Good
def test_add_returns_sum_of_two_positive_numbers():
    pass

# Bad
def test_add():
    pass
```

### 2. Use Fixtures for Shared Setup

```python
@pytest.fixture
def calculator():
    return Calculator()
```

### 3. Use Parametrization for Similar Tests

```python
@pytest.mark.parametrize("input,expected", [
    (1, 2),
    (2, 4),
])
def test_double(input, expected):
    assert double(input) == expected
```

### 4. Keep Tests Independent

```python
# Each test should work independently
def test_add():
    assert add(2, 3) == 5

def test_subtract():
    assert subtract(5, 3) == 2
```

### 5. Use Appropriate Fixture Scopes

```python
@pytest.fixture(scope="session")  # Expensive setup
def database():
    return create_database()

@pytest.fixture(scope="function")  # Simple setup
def user():
    return User("Alice")
```

### 6. Organize Tests in Classes

```python
class TestCalculator:
    def test_add(self):
        pass
    
    def test_subtract(self):
        pass
```

---

## Practice Exercise

### Exercise: pytest

**Objective**: Create a Python program that demonstrates pytest features.

**Instructions**:

1. Create a file called `test_pytest_practice.py`

2. Write a program that:
   - Uses pytest fixtures
   - Uses parametrization
   - Demonstrates pytest features
   - Shows practical applications
   - Uses markers and advanced features

3. Your program should include:
   - Basic pytest tests
   - Fixtures with different scopes
   - Parametrized tests
   - Exception testing
   - Markers
   - Real-world examples

**Example Solution**:

```python
"""
pytest Framework Practice
This program demonstrates pytest features.
"""

import pytest
import os

# Code to test
def add(x, y):
    return x + y

def divide(x, y):
    if y == 0:
        raise ValueError("Cannot divide by zero")
    return x / y

class Calculator:
    def __init__(self):
        self.history = []
    
    def add(self, x, y):
        result = x + y
        self.history.append(f"{x} + {y} = {result}")
        return result

# 1. Basic pytest tests
def test_add_basic():
    assert add(2, 3) == 5

def test_add_negative():
    assert add(-2, -3) == -5

# 2. Basic fixture
@pytest.fixture
def calculator():
    return Calculator()

def test_calculator_add(calculator):
    result = calculator.add(2, 3)
    assert result == 5
    assert len(calculator.history) == 1

# 3. Fixture with setup/teardown
@pytest.fixture
def temp_file(tmp_path):
    file_path = tmp_path / "test.txt"
    file_path.write_text("test content")
    yield file_path
    # Cleanup happens automatically

def test_file_operations(temp_file):
    assert temp_file.read_text() == "test content"

# 4. Parametrized test
@pytest.mark.parametrize("x,y,expected", [
    (2, 3, 5),
    (0, 0, 0),
    (-2, -3, -5),
    (10, -5, 5),
])
def test_add_parametrized(x, y, expected):
    assert add(x, y) == expected

# 5. Multiple parametrization
@pytest.mark.parametrize("x", [1, 2, 3])
@pytest.mark.parametrize("y", [10, 20])
def test_multiply(x, y):
    assert x * y == x * y

# 6. Fixture with parameters
@pytest.fixture(params=[1, 2, 3])
def number(request):
    return request.param

def test_square(number):
    assert number ** 2 >= 0

# 7. Exception testing
def test_divide_by_zero():
    with pytest.raises(ValueError):
        divide(10, 0)

def test_divide_by_zero_message():
    with pytest.raises(ValueError, match="Cannot divide by zero"):
        divide(10, 0)

# 8. Markers
@pytest.mark.slow
def test_slow_operation():
    import time
    time.sleep(0.1)  # Simulate slow operation
    assert True

@pytest.mark.integration
def test_integration():
    # Integration test
    assert True

# 9. Skipping tests
@pytest.mark.skip(reason="Not implemented yet")
def test_future_feature():
    assert False

@pytest.mark.skipif(os.name == 'nt', reason="Doesn't work on Windows")
def test_unix_only():
    assert True

# 10. Expected failures
@pytest.mark.xfail(reason="Known bug")
def test_known_bug():
    assert False

# 11. Fixture dependencies
@pytest.fixture
def user_data():
    return {"name": "Alice", "age": 25}

@pytest.fixture
def user(user_data):
    class User:
        def __init__(self, name, age):
            self.name = name
            self.age = age
    return User(**user_data)

def test_user_name(user):
    assert user.name == "Alice"

def test_user_age(user):
    assert user.age == 25

# 12. Autouse fixture
@pytest.fixture(autouse=True)
def setup_environment(monkeypatch):
    monkeypatch.setenv('TEST_MODE', 'true')
    yield
    monkeypatch.delenv('TEST_MODE', raising=False)

def test_environment():
    assert os.environ.get('TEST_MODE') == 'true'

# 13. Class-based tests with parametrization
@pytest.mark.parametrize("name,age", [
    ("Alice", 25),
    ("Bob", 30),
])
class TestUser:
    def test_user_creation(self, name, age):
        class User:
            def __init__(self, name, age):
                self.name = name
                self.age = age
        user = User(name, age)
        assert user.name == name
        assert user.age == age

# 14. Fixture scope
@pytest.fixture(scope="module")
def module_fixture():
    print("Module fixture setup")
    yield "module_data"
    print("Module fixture teardown")

def test_module_1(module_fixture):
    assert module_fixture == "module_data"

def test_module_2(module_fixture):
    assert module_fixture == "module_data"

# 15. Capturing output
def test_print_output(capsys):
    print("Hello, World!")
    captured = capsys.readouterr()
    assert "Hello, World!" in captured.out

# 16. Monkeypatching
def test_monkeypatch(monkeypatch):
    import time
    def mock_time():
        return 1234567890
    monkeypatch.setattr(time, "time", mock_time)
    assert time.time() == 1234567890

# 17. Real-world: Calculator with history
@pytest.fixture
def calc():
    return Calculator()

def test_calculator_history(calc):
    calc.add(1, 2)
    calc.add(3, 4)
    assert len(calc.history) == 2
    assert "1 + 2 = 3" in calc.history
    assert "3 + 4 = 7" in calc.history

# 18. Parametrized exception testing
@pytest.mark.parametrize("x,y,exception", [
    (10, 0, ValueError),
    ("10", 2, TypeError),
])
def test_divide_exceptions(x, y, exception):
    with pytest.raises(exception):
        divide(x, y)
```

**Expected Output** (when running `pytest -v`):
```
test_pytest_practice.py::test_add_basic PASSED
test_pytest_practice.py::test_add_negative PASSED
test_pytest_practice.py::test_calculator_add PASSED
test_pytest_practice.py::test_add_parametrized[2-3-5] PASSED
test_pytest_practice.py::test_add_parametrized[0-0-0] PASSED
[... rest of output ...]

========================= 25 passed in 0.15s =========================
```

**Challenge** (Optional):
- Create a comprehensive test suite using pytest
- Implement custom fixtures for complex test scenarios
- Use parametrization to test multiple scenarios efficiently
- Create pytest plugins or custom markers
- Set up pytest configuration for a large project

---

## Key Takeaways

1. **pytest basics** - simple test functions, auto-discovery
2. **Fixtures** - setup/teardown, scopes, dependencies
3. **Parametrization** - test multiple inputs easily
4. **Markers** - categorize and filter tests
5. **Better assertions** - detailed failure messages
6. **conftest.py** - shared fixtures
7. **Temporary files** - tmp_path fixture
8. **Monkeypatching** - mock objects and functions
9. **Exception testing** - pytest.raises()
10. **Configuration** - pytest.ini or pyproject.toml
11. **Simple syntax** - less boilerplate than unittest
12. **Plugin ecosystem** - many plugins available
13. **Best practices** - use fixtures, parametrize, keep tests independent
14. **When to use** - modern Python projects, complex test scenarios
15. **Advanced features** - markers, skipping, xfail, capturing

---

## Quiz: pytest

Test your understanding with these questions:

1. **What is pytest?**
   - A) A Python package manager
   - B) A testing framework
   - C) A code editor
   - D) A database

2. **How do you define a test in pytest?**
   - A) class TestSomething
   - B) def test_something()
   - C) test something()
   - D) @test

3. **What is a fixture?**
   - A) A test function
   - B) Setup/teardown code
   - C) An assertion
   - D) A marker

4. **What does @pytest.mark.parametrize do?**
   - A) Marks a test as slow
   - B) Runs a test with different inputs
   - C) Skips a test
   - D) Makes a test fail

5. **What is conftest.py used for?**
   - A) Test configuration
   - B) Shared fixtures
   - C) Test data
   - D) Nothing

6. **What fixture scope runs once per test session?**
   - A) function
   - B) class
   - C) module
   - D) session

7. **How do you skip a test?**
   - A) @pytest.skip
   - B) @pytest.mark.skip
   - C) pytest.skip()
   - D) skip()

8. **What does pytest.raises() do?**
   - A) Raises an exception
   - B) Tests that an exception is raised
   - C) Catches an exception
   - D) Nothing

9. **What is the default fixture scope?**
   - A) function
   - B) class
   - C) module
   - D) session

10. **What makes pytest better than unittest?**
    - A) Simpler syntax
    - B) Better fixtures
    - C) Parametrization
    - D) All of the above

**Answers**:
1. B) A testing framework (pytest definition)
2. B) def test_something() (pytest test definition)
3. B) Setup/teardown code (fixture definition)
4. B) Runs a test with different inputs (parametrize purpose)
5. B) Shared fixtures (conftest.py purpose)
6. D) session (fixture scope)
7. B) @pytest.mark.skip (skipping tests)
8. B) Tests that an exception is raised (pytest.raises purpose)
9. A) function (default fixture scope)
10. D) All of the above (pytest advantages)

---

## Next Steps

Excellent work! You've mastered pytest. You now understand:
- pytest basics
- Fixtures
- Parametrization
- Advanced pytest features

**What's Next?**
- Lesson 17.3: Test-Driven Development (TDD)
- Learn the TDD cycle
- Understand writing tests first
- Explore TDD practices

---

## Additional Resources

- **pytest**: [docs.pytest.org/](https://docs.pytest.org/)
- **pytest fixtures**: [docs.pytest.org/en/stable/fixture.html](https://docs.pytest.org/en/stable/fixture.html)
- **pytest parametrize**: [docs.pytest.org/en/stable/parametrize.html](https://docs.pytest.org/en/stable/parametrize.html)

---

*Lesson completed! You're ready to move on to the next lesson.*

