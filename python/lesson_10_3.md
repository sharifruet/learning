# Lesson 10.3: Raising Exceptions

## Learning Objectives

By the end of this lesson, you will be able to:
- Use the `raise` statement to raise exceptions
- Create custom exception classes
- Understand exception chaining
- Raise exceptions with custom messages
- Re-raise exceptions
- Use exception chaining with `from`
- Design exception hierarchies
- Apply custom exceptions in practical scenarios
- Understand when to raise exceptions vs return error values

---

## Introduction to Raising Exceptions

**Raising exceptions** allows you to signal that an error or exceptional condition has occurred. You can raise built-in exceptions or create custom ones.

### Why Raise Exceptions?

- **Signal errors**: Indicate that something went wrong
- **Validation**: Enforce constraints and rules
- **Control flow**: Stop execution when conditions aren't met
- **API design**: Provide clear error messages to users

---

## The `raise` Statement

### Basic `raise` Syntax

```python
raise ExceptionType("Error message")
```

### Raising Built-in Exceptions

```python
# Raise ValueError
if age < 0:
    raise ValueError("Age cannot be negative")

# Raise TypeError
if not isinstance(name, str):
    raise TypeError("Name must be a string")

# Raise custom message
if divisor == 0:
    raise ZeroDivisionError("Cannot divide by zero")
```

### Basic Examples

```python
# Raise ValueError
def set_age(age):
    if age < 0:
        raise ValueError("Age cannot be negative")
    return age

# Usage
try:
    set_age(-5)
except ValueError as e:
    print(f"Error: {e}")
```

### Raising Without Arguments

```python
# Re-raise current exception
try:
    risky_operation()
except Exception:
    # Do some handling
    raise  # Re-raise the same exception
```

---

## Raising Exceptions with Messages

### Custom Error Messages

```python
def divide(a, b):
    if b == 0:
        raise ZeroDivisionError("Cannot divide by zero")
    if not isinstance(a, (int, float)) or not isinstance(b, (int, float)):
        raise TypeError("Both arguments must be numbers")
    return a / b

# Usage
try:
    result = divide(10, 0)
except ZeroDivisionError as e:
    print(f"Error: {e}")
```

### Formatting Error Messages

```python
def validate_age(age):
    if not isinstance(age, int):
        raise TypeError(f"Expected int, got {type(age).__name__}")
    if age < 0:
        raise ValueError(f"Age {age} cannot be negative")
    if age > 150:
        raise ValueError(f"Age {age} seems unrealistic")
    return age
```

### Example: Input Validation

```python
def get_positive_number(value):
    try:
        number = float(value)
    except ValueError:
        raise ValueError(f"'{value}' is not a valid number")
    
    if number <= 0:
        raise ValueError(f"Number must be positive, got {number}")
    
    return number

# Usage
try:
    num = get_positive_number("-5")
except ValueError as e:
    print(f"Validation error: {e}")
```

---

## Creating Custom Exceptions

### Basic Custom Exception

```python
class CustomError(Exception):
    pass

# Use it
raise CustomError("Something went wrong")
```

### Custom Exception with Message

```python
class ValidationError(Exception):
    """Exception raised for validation errors."""
    pass

# Use it
if not valid:
    raise ValidationError("Validation failed")
```

### Custom Exception with Attributes

```python
class AgeError(Exception):
    """Exception raised for age-related errors."""
    
    def __init__(self, age, message="Invalid age"):
        self.age = age
        self.message = message
        super().__init__(self.message)
    
    def __str__(self):
        return f"{self.message}: {age}"

# Use it
if age < 0:
    raise AgeError(age, "Age cannot be negative")
```

### Example: Custom Validation Exception

```python
class InvalidInputError(Exception):
    """Exception for invalid input."""
    
    def __init__(self, input_value, reason):
        self.input_value = input_value
        self.reason = reason
        message = f"Invalid input '{input_value}': {reason}"
        super().__init__(message)

# Use it
def validate_email(email):
    if "@" not in email:
        raise InvalidInputError(email, "Missing @ symbol")
    if "." not in email:
        raise InvalidInputError(email, "Missing domain")
    return email

try:
    validate_email("invalid")
except InvalidInputError as e:
    print(f"Error: {e}")
    print(f"Input: {e.input_value}, Reason: {e.reason}")
```

---

## Exception Hierarchies

### Creating Exception Hierarchy

```python
class DatabaseError(Exception):
    """Base exception for database errors."""
    pass

class ConnectionError(DatabaseError):
    """Exception for connection errors."""
    pass

class QueryError(DatabaseError):
    """Exception for query errors."""
    pass

class TimeoutError(ConnectionError):
    """Exception for timeout errors."""
    pass

# Use hierarchy
try:
    # Database operation
    pass
except TimeoutError:
    print("Connection timeout")
except ConnectionError:
    print("Connection error")
except DatabaseError:
    print("Database error")
```

### Example: Application Exception Hierarchy

```python
class ApplicationError(Exception):
    """Base exception for application."""
    pass

class ValidationError(ApplicationError):
    """Exception for validation errors."""
    pass

class BusinessLogicError(ApplicationError):
    """Exception for business logic errors."""
    pass

class DataError(ApplicationError):
    """Exception for data errors."""
    pass

class NotFoundError(DataError):
    """Exception when resource not found."""
    pass

class DuplicateError(DataError):
    """Exception when duplicate found."""
    pass

# Use it
def create_user(username):
    if not username:
        raise ValidationError("Username cannot be empty")
    if user_exists(username):
        raise DuplicateError(f"User '{username}' already exists")
    # Create user
```

---

## Exception Chaining

### Basic Exception Chaining

Exception chaining preserves the original exception when raising a new one.

### Using `from`

```python
try:
    result = 10 / 0
except ZeroDivisionError as e:
    raise ValueError("Invalid operation") from e
```

### Example: Exception Chaining

```python
def process_file(filename):
    try:
        with open(filename, "r") as file:
            content = file.read()
            number = int(content)
            return number
    except FileNotFoundError as e:
        raise ValueError(f"Cannot process file: {filename}") from e
    except ValueError as e:
        raise ValueError(f"Invalid content in file: {filename}") from e

# Usage
try:
    result = process_file("data.txt")
except ValueError as e:
    print(f"Error: {e}")
    print(f"Original: {e.__cause__}")
```

### Chaining Without `from`

```python
# Without 'from'
try:
    result = 10 / 0
except ZeroDivisionError:
    raise ValueError("Invalid operation")
# Original exception is lost
```

### Suppressing Exception Chaining

```python
try:
    result = 10 / 0
except ZeroDivisionError:
    raise ValueError("Invalid operation") from None
# Suppresses the original exception
```

---

## Re-raising Exceptions

### Re-raise Current Exception

```python
try:
    risky_operation()
except Exception:
    # Do some logging or cleanup
    print("Error occurred, logging...")
    raise  # Re-raise the same exception
```

### Example: Re-raising

```python
def process_data(data):
    try:
        result = complex_operation(data)
        return result
    except ValueError:
        # Log the error
        print("Value error in complex_operation")
        raise  # Re-raise to caller
    except TypeError:
        # Handle differently
        print("Type error in complex_operation")
        raise

# Usage
try:
    result = process_data(invalid_data)
except ValueError:
    print("Handled at caller level")
```

---

## Practical Examples

### Example 1: Validation with Custom Exception

```python
class ValidationError(Exception):
    """Custom validation exception."""
    pass

def validate_user(username, age, email):
    errors = []
    
    if not username or len(username) < 3:
        errors.append("Username must be at least 3 characters")
    
    if not isinstance(age, int) or age < 0:
        errors.append("Age must be a non-negative integer")
    
    if "@" not in email:
        errors.append("Invalid email format")
    
    if errors:
        raise ValidationError("; ".join(errors))
    
    return True

# Usage
try:
    validate_user("ab", -5, "invalid-email")
except ValidationError as e:
    print(f"Validation failed: {e}")
```

### Example 2: API Error Handling

```python
class APIError(Exception):
    """Base exception for API errors."""
    pass

class AuthenticationError(APIError):
    """Exception for authentication errors."""
    pass

class RateLimitError(APIError):
    """Exception for rate limit errors."""
    pass

class ServerError(APIError):
    """Exception for server errors."""
    pass

def make_api_request(url):
    # Simulate API call
    if "auth" in url:
        raise AuthenticationError("Invalid credentials")
    elif "rate" in url:
        raise RateLimitError("Rate limit exceeded")
    elif "server" in url:
        raise ServerError("Server error")
    return {"status": "success"}

# Usage
try:
    response = make_api_request("api/auth")
except AuthenticationError:
    print("Please check your credentials")
except RateLimitError:
    print("Please wait before trying again")
except APIError as e:
    print(f"API error: {e}")
```

### Example 3: File Processing with Chaining

```python
class FileProcessingError(Exception):
    """Exception for file processing errors."""
    pass

def process_config_file(filename):
    try:
        with open(filename, "r") as file:
            config = json.load(file)
            return config
    except FileNotFoundError as e:
        raise FileProcessingError(f"Config file not found: {filename}") from e
    except json.JSONDecodeError as e:
        raise FileProcessingError(f"Invalid JSON in {filename}") from e
    except Exception as e:
        raise FileProcessingError(f"Error processing {filename}") from e

# Usage
try:
    config = process_config_file("config.json")
except FileProcessingError as e:
    print(f"Error: {e}")
    if e.__cause__:
        print(f"Original error: {e.__cause__}")
```

### Example 4: Business Logic Exceptions

```python
class InsufficientFundsError(Exception):
    """Exception for insufficient funds."""
    
    def __init__(self, balance, amount):
        self.balance = balance
        self.amount = amount
        message = f"Insufficient funds: balance={balance}, requested={amount}"
        super().__init__(message)

class Account:
    def __init__(self, balance=0):
        self.balance = balance
    
    def withdraw(self, amount):
        if amount <= 0:
            raise ValueError("Amount must be positive")
        if amount > self.balance:
            raise InsufficientFundsError(self.balance, amount)
        self.balance -= amount
        return self.balance

# Usage
account = Account(100)
try:
    account.withdraw(150)
except InsufficientFundsError as e:
    print(f"Error: {e}")
    print(f"Balance: ${e.balance}, Requested: ${e.amount}")
```

---

## Best Practices

### 1. Use Specific Exceptions

```python
# Good: Specific exception
if age < 0:
    raise ValueError("Age cannot be negative")

# Avoid: Generic exception
if age < 0:
    raise Exception("Age cannot be negative")
```

### 2. Provide Clear Messages

```python
# Good: Clear message
raise ValueError(f"Age {age} is invalid. Must be between 0 and 150.")

# Avoid: Vague message
raise ValueError("Invalid")
```

### 3. Create Custom Exceptions for Your Domain

```python
# Good: Domain-specific exception
class UserNotFoundError(Exception):
    pass

# Avoid: Using generic exceptions
raise ValueError("User not found")  # Less clear
```

### 4. Use Exception Hierarchies

```python
# Good: Hierarchical exceptions
class DatabaseError(Exception):
    pass

class ConnectionError(DatabaseError):
    pass

# Allows catching at different levels
```

### 5. Preserve Exception Context

```python
# Good: Preserve original exception
try:
    operation()
except OriginalError as e:
    raise NewError("Context") from e
```

---

## Common Mistakes and Pitfalls

### 1. Raising Generic Exceptions

```python
# WRONG: Too generic
raise Exception("Error occurred")

# BETTER: Specific exception
raise ValueError("Invalid value")
```

### 2. Losing Exception Context

```python
# WRONG: Loses original exception
try:
    operation()
except OriginalError:
    raise NewError("Error")  # Original lost

# BETTER: Preserve context
try:
    operation()
except OriginalError as e:
    raise NewError("Error") from e
```

### 3. Not Providing Error Messages

```python
# WRONG: No message
raise ValueError()

# BETTER: Clear message
raise ValueError("Age cannot be negative")
```

### 4. Raising Instead of Returning

```python
# WRONG: Using exception for control flow
def find_user(username):
    if not user_exists(username):
        raise NotFoundError()
    return user

# BETTER: Return None or use exception appropriately
def find_user(username):
    if not user_exists(username):
        return None  # Or raise if it's truly exceptional
    return user
```

---

## When to Raise Exceptions

### ✅ Good Use Cases

- **Validation errors**: Invalid input
- **Resource errors**: File not found, network error
- **Business logic errors**: Insufficient funds, invalid state
- **Programming errors**: Wrong type, missing required parameter

### ❌ Avoid For

- **Normal control flow**: Use if/else instead
- **Expected conditions**: Return None or use optional values
- **Performance**: Exceptions have overhead

---

## Practice Exercise

### Exercise: Custom Exceptions

**Objective**: Create a Python program that demonstrates raising exceptions and creating custom exceptions.

**Instructions**:

1. Create a file called `custom_exceptions_practice.py`

2. Write a program that:
   - Raises built-in exceptions
   - Creates custom exception classes
   - Uses exception chaining
   - Implements exception hierarchies
   - Applies exceptions in practical scenarios

3. Your program should include:
   - Raising exceptions with messages
   - Custom exception classes
   - Exception hierarchies
   - Exception chaining
   - Practical exception usage

**Example Solution**:

```python
"""
Custom Exceptions Practice
This program demonstrates raising exceptions and creating custom exceptions.
"""

print("=" * 60)
print("CUSTOM EXCEPTIONS PRACTICE")
print("=" * 60)
print()

# 1. Raising built-in exceptions
print("1. RAISING BUILT-IN EXCEPTIONS")
print("-" * 60)
def validate_age(age):
    if age < 0:
        raise ValueError("Age cannot be negative")
    if age > 150:
        raise ValueError("Age seems unrealistic")
    return age

try:
    validate_age(-5)
except ValueError as e:
    print(f"Caught: {e}")
print()

# 2. Basic custom exception
print("2. BASIC CUSTOM EXCEPTION")
print("-" * 60)
class CustomError(Exception):
    pass

try:
    raise CustomError("Something went wrong")
except CustomError as e:
    print(f"Caught custom error: {e}")
print()

# 3. Custom exception with message
print("3. CUSTOM EXCEPTION WITH MESSAGE")
print("-" * 60)
class ValidationError(Exception):
    """Exception for validation errors."""
    pass

def validate_email(email):
    if "@" not in email:
        raise ValidationError(f"Invalid email: '{email}' missing @")
    return email

try:
    validate_email("invalid-email")
except ValidationError as e:
    print(f"Validation error: {e}")
print()

# 4. Custom exception with attributes
print("4. CUSTOM EXCEPTION WITH ATTRIBUTES")
print("-" * 60)
class AgeError(Exception):
    """Exception for age-related errors."""
    
    def __init__(self, age, message="Invalid age"):
        self.age = age
        self.message = message
        super().__init__(f"{message}: {age}")

try:
    age = -5
    if age < 0:
        raise AgeError(age, "Age cannot be negative")
except AgeError as e:
    print(f"Error: {e}")
    print(f"Age value: {e.age}")
print()

# 5. Exception hierarchy
print("5. EXCEPTION HIERARCHY")
print("-" * 60)
class DatabaseError(Exception):
    """Base exception for database errors."""
    pass

class ConnectionError(DatabaseError):
    """Exception for connection errors."""
    pass

class QueryError(DatabaseError):
    """Exception for query errors."""
    pass

try:
    raise ConnectionError("Cannot connect to database")
except ConnectionError as e:
    print(f"Connection error: {e}")
except DatabaseError as e:
    print(f"Database error: {e}")
print()

# 6. Exception chaining with from
print("6. EXCEPTION CHAINING WITH FROM")
print("-" * 60)
def process_file(filename):
    try:
        with open(filename, "r") as file:
            content = file.read()
            number = int(content)
            return number
    except FileNotFoundError as e:
        raise ValueError(f"Cannot process file: {filename}") from e

try:
    result = process_file("nonexistent.txt")
except ValueError as e:
    print(f"Error: {e}")
    print(f"Original error: {e.__cause__}")
print()

# 7. Re-raising exceptions
print("7. RE-RAISING EXCEPTIONS")
print("-" * 60)
def process_data(data):
    try:
        if not isinstance(data, int):
            raise TypeError("Data must be an integer")
        return data * 2
    except TypeError:
        print("Type error in process_data, re-raising...")
        raise

try:
    result = process_data("not a number")
except TypeError as e:
    print(f"Caught at caller: {e}")
print()

# 8. Application exception hierarchy
print("8. APPLICATION EXCEPTION HIERARCHY")
print("-" * 60)
class ApplicationError(Exception):
    """Base exception for application."""
    pass

class ValidationError(ApplicationError):
    """Exception for validation errors."""
    pass

class BusinessLogicError(ApplicationError):
    """Exception for business logic errors."""
    pass

class DataError(ApplicationError):
    """Exception for data errors."""
    pass

class NotFoundError(DataError):
    """Exception when resource not found."""
    pass

def find_user(username):
    if not username:
        raise ValidationError("Username cannot be empty")
    # Simulate not found
    raise NotFoundError(f"User '{username}' not found")

try:
    find_user("")
except ValidationError as e:
    print(f"Validation error: {e}")

try:
    find_user("alice")
except NotFoundError as e:
    print(f"Not found: {e}")
except DataError as e:
    print(f"Data error: {e}")
print()

# 9. Custom exception with multiple attributes
print("9. CUSTOM EXCEPTION WITH MULTIPLE ATTRIBUTES")
print("-" * 60)
class InvalidInputError(Exception):
    """Exception for invalid input."""
    
    def __init__(self, input_value, reason, field=None):
        self.input_value = input_value
        self.reason = reason
        self.field = field
        message = f"Invalid input '{input_value}': {reason}"
        if field:
            message += f" (field: {field})"
        super().__init__(message)

def validate_form(name, age, email):
    errors = []
    
    if not name:
        errors.append(InvalidInputError(name, "Cannot be empty", "name"))
    if not isinstance(age, int) or age < 0:
        errors.append(InvalidInputError(age, "Must be non-negative integer", "age"))
    if "@" not in email:
        errors.append(InvalidInputError(email, "Invalid format", "email"))
    
    if errors:
        raise ExceptionGroup("Validation errors", errors)
    return True

try:
    validate_form("", -5, "invalid")
except* InvalidInputError as e:
    for error in e.exceptions:
        print(f"Error in {error.field}: {error.reason}")
except ExceptionGroup as e:
    print(f"Multiple errors: {len(e.exceptions)}")
print()

# 10. Business logic exception
print("10. BUSINESS LOGIC EXCEPTION")
print("-" * 60)
class InsufficientFundsError(Exception):
    """Exception for insufficient funds."""
    
    def __init__(self, balance, amount):
        self.balance = balance
        self.amount = amount
        message = f"Insufficient funds: balance=${balance}, requested=${amount}"
        super().__init__(message)

class Account:
    def __init__(self, balance=0):
        self.balance = balance
    
    def withdraw(self, amount):
        if amount <= 0:
            raise ValueError("Amount must be positive")
        if amount > self.balance:
            raise InsufficientFundsError(self.balance, amount)
        self.balance -= amount
        return self.balance

account = Account(100)
try:
    account.withdraw(150)
except InsufficientFundsError as e:
    print(f"Error: {e}")
    print(f"Balance: ${e.balance}, Requested: ${e.amount}")
print()

# 11. API error exceptions
print("11. API ERROR EXCEPTIONS")
print("-" * 60)
class APIError(Exception):
    """Base exception for API errors."""
    pass

class AuthenticationError(APIError):
    """Exception for authentication errors."""
    pass

class RateLimitError(APIError):
    """Exception for rate limit errors."""
    pass

class ServerError(APIError):
    """Exception for server errors."""
    pass

def make_request(endpoint):
    if "auth" in endpoint:
        raise AuthenticationError("Invalid credentials")
    elif "rate" in endpoint:
        raise RateLimitError("Rate limit exceeded")
    return {"status": "success"}

try:
    response = make_request("api/auth")
except AuthenticationError:
    print("Please check your credentials")
except APIError as e:
    print(f"API error: {e}")
print()

# 12. Exception with context
print("12. EXCEPTION WITH CONTEXT")
print("-" * 60)
class ProcessingError(Exception):
    """Exception with processing context."""
    
    def __init__(self, message, context=None):
        self.context = context
        if context:
            message = f"{message} (context: {context})"
        super().__init__(message)

def process_item(item, context):
    if not item:
        raise ProcessingError("Item is empty", context)
    return item.upper()

try:
    result = process_item("", "user_input")
except ProcessingError as e:
    print(f"Error: {e}")
    print(f"Context: {e.context}")
print()

# 13. Suppressing exception chaining
print("13. SUPPRESSING EXCEPTION CHAINING")
print("-" * 60)
try:
    result = 10 / 0
except ZeroDivisionError:
    raise ValueError("Invalid operation") from None
    # Original exception is suppressed
except ValueError as e:
    print(f"Error: {e}")
    print(f"Original suppressed: {e.__cause__ is None}")
print()

# 14. Multiple exception types
print("14. MULTIPLE EXCEPTION TYPES")
print("-" * 60)
class ValidationError(Exception):
    pass

class FormatError(ValidationError):
    pass

class RangeError(ValidationError):
    pass

def validate_number(value, min_val=0, max_val=100):
    try:
        number = float(value)
    except ValueError:
        raise FormatError(f"'{value}' is not a number")
    
    if number < min_val:
        raise RangeError(f"Value {number} is below minimum {min_val}")
    if number > max_val:
        raise RangeError(f"Value {number} is above maximum {max_val}")
    
    return number

try:
    validate_number("abc")
except FormatError as e:
    print(f"Format error: {e}")

try:
    validate_number("150")
except RangeError as e:
    print(f"Range error: {e}")
print()

# 15. Exception with default message
print("15. EXCEPTION WITH DEFAULT MESSAGE")
print("-" * 60)
class ConfigurationError(Exception):
    """Exception for configuration errors."""
    
    def __init__(self, message="Configuration error occurred"):
        self.message = message
        super().__init__(self.message)

try:
    raise ConfigurationError()
except ConfigurationError as e:
    print(f"Default message: {e}")

try:
    raise ConfigurationError("Custom configuration error")
except ConfigurationError as e:
    print(f"Custom message: {e}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
CUSTOM EXCEPTIONS PRACTICE
============================================================

1. RAISING BUILT-IN EXCEPTIONS
------------------------------------------------------------
Caught: Age cannot be negative

[... rest of output ...]
```

**Challenge** (Optional):
- Create a complete exception hierarchy for your application
- Build a validation framework with custom exceptions
- Implement error recovery mechanisms
- Create exception logging system

---

## Key Takeaways

1. **`raise` statement** raises exceptions
2. **Raise built-in exceptions** for standard errors
3. **Create custom exceptions** for domain-specific errors
4. **Exception hierarchies** allow catching at different levels
5. **Exception chaining** preserves original exception with `from`
6. **Re-raise exceptions** with `raise` (no arguments)
7. **Provide clear error messages** in exceptions
8. **Use specific exceptions** rather than generic ones
9. **Custom exceptions** should inherit from `Exception`
10. **Exception attributes** can store additional information
11. **Exception hierarchies** help organize related errors
12. **Preserve exception context** when chaining
13. **Use exceptions for exceptional cases**, not normal flow
14. **Document custom exceptions** with docstrings
15. **Exception chaining** helps debug complex error scenarios

---

## Quiz: Raising Exceptions

Test your understanding with these questions:

1. **What statement raises an exception?**
   - A) `throw`
   - B) `raise`
   - C) `except`
   - D) `error`

2. **How do you create a custom exception?**
   - A) `class MyError(Exception)`
   - B) `def MyError(Exception)`
   - C) `MyError = Exception()`
   - D) `raise MyError()`

3. **What does `raise` without arguments do?**
   - A) Raises new exception
   - B) Re-raises current exception
   - C) Does nothing
   - D) Suppresses exception

4. **How do you chain exceptions?**
   - A) `raise NewError from old_error`
   - B) `raise NewError(old_error)`
   - C) `raise NewError, old_error`
   - D) `raise NewError with old_error`

5. **What should custom exceptions inherit from?**
   - A) `BaseException`
   - B) `Exception`
   - C) `Error`
   - D) `object`

6. **What does `from None` do in exception chaining?**
   - A) Preserves original
   - B) Suppresses original
   - C) Creates new exception
   - D) Does nothing

7. **When should you raise exceptions?**
   - A) For normal control flow
   - B) For exceptional conditions
   - C) Always
   - D) Never

8. **What is the benefit of exception hierarchies?**
   - A) Faster execution
   - B) Can catch at different levels
   - C) Smaller code
   - D) No benefit

9. **How do you preserve exception context?**
   - A) `raise NewError()`
   - B) `raise NewError() from e`
   - C) `raise NewError(), e`
   - D) `raise NewError(e)`

10. **What should exception messages be?**
    - A) Vague
    - B) Clear and descriptive
    - C) Empty
    - D) Technical only

**Answers**:
1. B) `raise` (statement to raise exceptions)
2. A) `class MyError(Exception)` (inherit from Exception)
3. B) Re-raises current exception (raise without args re-raises)
4. A) `raise NewError from old_error` (exception chaining syntax)
5. B) `Exception` (custom exceptions should inherit from Exception)
6. B) Suppresses original (from None suppresses chaining)
7. B) For exceptional conditions (not normal flow)
8. B) Can catch at different levels (hierarchy benefit)
9. B) `raise NewError() from e` (preserves context)
10. B) Clear and descriptive (good error messages)

---

## Next Steps

Excellent work! You've mastered raising exceptions. You now understand:
- How to raise exceptions
- How to create custom exceptions
- How to use exception chaining
- How to design exception hierarchies

**What's Next?**
- Lesson 10.4: Debugging Techniques
- Learn debugging methods
- Use debuggers
- Understand debugging tools

---

## Additional Resources

- **Raising Exceptions**: [docs.python.org/3/tutorial/errors.html#raising-exceptions](https://docs.python.org/3/tutorial/errors.html#raising-exceptions)
- **Exception Classes**: [docs.python.org/3/tutorial/errors.html#user-defined-exceptions](https://docs.python.org/3/tutorial/errors.html#user-defined-exceptions)
- **Exception Chaining**: [docs.python.org/3/tutorial/errors.html#exception-chaining](https://docs.python.org/3/tutorial/errors.html#exception-chaining)

---

*Lesson completed! You're ready to move on to the next lesson.*

