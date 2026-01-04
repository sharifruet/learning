# Lesson 24.2: Code Documentation

## Learning Objectives

By the end of this lesson, you will be able to:
- Write effective docstrings
- Understand different docstring styles (Google, NumPy, Sphinx)
- Use type hints effectively
- Write meaningful comments
- Document functions, classes, and modules
- Generate documentation from docstrings
- Apply documentation best practices
- Use documentation tools
- Create API documentation
- Write self-documenting code
- Debug documentation issues

---

## Introduction to Code Documentation

**Code Documentation** is the practice of writing clear explanations of what code does, how it works, and how to use it. Good documentation makes code more maintainable and easier to understand.

**Types of Documentation**:
- **Docstrings**: Documentation strings in code
- **Type Hints**: Type annotations
- **Comments**: Inline explanations
- **README files**: Project documentation
- **API Documentation**: External documentation

**Benefits**:
- **Understanding**: Easier to understand code
- **Maintenance**: Easier to maintain and modify
- **Onboarding**: Faster onboarding for new developers
- **API Usage**: Clear API usage instructions
- **Tooling**: Enables documentation generation

---

## Docstrings

### Module Docstrings

```python
"""Module for user management.

This module provides classes and functions for managing users,
including creation, authentication, and profile management.

Example:
    >>> from user_manager import UserManager
    >>> manager = UserManager()
    >>> user = manager.create_user('alice', 'alice@example.com')
"""

__version__ = '1.0.0'
__author__ = 'Your Name'
```

### Function Docstrings

```python
def calculate_total(items, discount=0.0):
    """Calculate total price with discount.
    
    Args:
        items: List of items, each with a 'price' key
        discount: Discount percentage (0.0 to 1.0)
    
    Returns:
        float: Total price after discount
    
    Raises:
        ValueError: If discount is not between 0 and 1
    
    Example:
        >>> items = [{'price': 10}, {'price': 20}]
        >>> calculate_total(items, discount=0.1)
        27.0
    """
    if not 0 <= discount <= 1:
        raise ValueError('Discount must be between 0 and 1')
    
    subtotal = sum(item['price'] for item in items)
    return subtotal * (1 - discount)
```

### Class Docstrings

```python
class UserManager:
    """Manages user operations.
    
    This class provides methods for creating, updating, and
    managing users in the system.
    
    Attributes:
        api_url: Base URL for the API
        session: HTTP session for API requests
    
    Example:
        >>> manager = UserManager('https://api.example.com')
        >>> user = manager.create_user('alice', 'alice@example.com')
    """
    
    def __init__(self, api_url):
        """Initialize UserManager.
        
        Args:
            api_url: Base URL for the API endpoint
        """
        self.api_url = api_url
        self.session = requests.Session()
```

### Method Docstrings

```python
class UserManager:
    def create_user(self, username, email, age=None):
        """Create a new user.
        
        Args:
            username: User's username (must be unique)
            email: User's email address (must be valid)
            age: User's age in years (optional)
        
        Returns:
            dict: User data dictionary with keys:
                - id: User ID
                - username: Username
                - email: Email address
                - age: Age (if provided)
        
        Raises:
            ValueError: If username or email is invalid
            ConnectionError: If API request fails
        
        Example:
            >>> manager = UserManager('https://api.example.com')
            >>> user = manager.create_user('alice', 'alice@example.com', 25)
            >>> print(user['username'])
            alice
        """
        # Implementation
        pass
```

---

## Docstring Styles

### Google Style

```python
def function_name(param1, param2):
    """Short description.
    
    Longer description if needed.
    
    Args:
        param1: Description of param1
        param2: Description of param2
    
    Returns:
        Description of return value
    
    Raises:
        ValueError: When something goes wrong
    
    Example:
        >>> function_name(1, 2)
        3
    """
    pass
```

### NumPy Style

```python
def function_name(param1, param2):
    """Short description.
    
    Longer description if needed.
    
    Parameters
    ----------
    param1 : type
        Description of param1
    param2 : type
        Description of param2
    
    Returns
    -------
    return_type
        Description of return value
    
    Raises
    ------
    ValueError
        When something goes wrong
    
    Examples
    --------
    >>> function_name(1, 2)
    3
    """
    pass
```

### Sphinx Style

```python
def function_name(param1, param2):
    """Short description.
    
    Longer description if needed.
    
    :param param1: Description of param1
    :type param1: type
    :param param2: Description of param2
    :type param2: type
    :returns: Description of return value
    :rtype: return_type
    :raises ValueError: When something goes wrong
    
    .. code-block:: python
    
        >>> function_name(1, 2)
        3
    """
    pass
```

---

## Type Hints

### Basic Type Hints

```python
from typing import List, Dict, Optional, Union

def greet(name: str) -> str:
    """Greet a person by name.
    
    Args:
        name: Person's name
    
    Returns:
        Greeting message
    """
    return f'Hello, {name}!'

def calculate_sum(numbers: List[int]) -> int:
    """Calculate sum of numbers.
    
    Args:
        numbers: List of integers
    
    Returns:
        Sum of all numbers
    """
    return sum(numbers)

def get_user_data(user_id: int) -> Optional[Dict[str, str]]:
    """Get user data by ID.
    
    Args:
        user_id: User ID
    
    Returns:
        User data dictionary or None if not found
    """
    # Implementation
    pass
```

### Advanced Type Hints

```python
from typing import List, Dict, Optional, Union, Tuple, Callable

# Union types
def process_data(data: Union[str, int, float]) -> str:
    """Process data of different types."""
    return str(data)

# Optional types
def find_user(username: str) -> Optional[Dict]:
    """Find user, returns None if not found."""
    pass

# Tuple types
def get_coordinates() -> Tuple[float, float]:
    """Get coordinates as (x, y) tuple."""
    return (10.5, 20.3)

# Callable types
def apply_function(func: Callable[[int, int], int], a: int, b: int) -> int:
    """Apply a function to two integers."""
    return func(a, b)

# Generic types
from typing import TypeVar, Generic

T = TypeVar('T')

class Stack(Generic[T]):
    """Generic stack implementation."""
    def push(self, item: T) -> None:
        """Push item onto stack."""
        pass
    
    def pop(self) -> T:
        """Pop item from stack."""
        pass
```

### Type Hints for Classes

```python
from typing import List, Optional

class User:
    """User class with type hints."""
    
    def __init__(self, username: str, email: str, age: Optional[int] = None):
        """Initialize user.
        
        Args:
            username: User's username
            email: User's email
            age: User's age (optional)
        """
        self.username: str = username
        self.email: str = email
        self.age: Optional[int] = age
        self.posts: List['Post'] = []
    
    def add_post(self, post: 'Post') -> None:
        """Add a post to user's posts.
        
        Args:
            post: Post object to add
        """
        self.posts.append(post)
```

### Type Hints with Annotations

```python
from typing import Annotated

def process_file(
    filename: Annotated[str, "Path to the file"],
    mode: Annotated[str, "File mode ('r' or 'w')"] = 'r'
) -> Annotated[str, "File contents"]:
    """Process a file with annotated types."""
    pass
```

---

## Comments Best Practices

### Good Comments

```python
# Good: Explain why, not what
# Use binary search because the list is sorted
result = binary_search(sorted_list, target)

# Good: Explain complex algorithms
# Calculate Fibonacci using dynamic programming to avoid
# exponential time complexity of recursive approach
def fibonacci(n):
    # Implementation
    pass

# Good: Document non-obvious behavior
# Note: This function modifies the list in-place for performance
def process_list(items):
    # Implementation
    pass

# Good: Explain business logic
# Apply 10% discount for customers with more than 5 orders
if customer.order_count > 5:
    discount = 0.1
```

### Bad Comments

```python
# Bad: Obvious comment
# Increment counter
counter += 1

# Bad: Commented-out code
# def old_function():
#     pass

# Bad: Redundant comment
def add(a, b):
    # Add a and b
    return a + b

# Bad: Outdated comment
# This function calculates the sum (but it actually multiplies now)
def calculate(x, y):
    return x * y
```

### Comment Styles

```python
# Single-line comment
result = calculate_total(items)

# Multi-line comment for complex explanations
# This algorithm uses a two-pass approach:
# 1. First pass: Identify all potential matches
# 2. Second pass: Filter and rank matches
results = complex_algorithm(data)

# Inline comment (use sparingly)
total = price * quantity  # Apply quantity discount if > 10
```

### TODO Comments

```python
# TODO: Implement caching for better performance
def get_data():
    pass

# FIXME: Handle edge case when list is empty
def process_list(items):
    pass

# NOTE: This is a temporary workaround
def temporary_solution():
    pass

# HACK: Quick fix, needs proper implementation
def quick_fix():
    pass
```

---

## Documentation Tools

### Sphinx

```python
# Install Sphinx
# pip install sphinx

# Generate documentation
# sphinx-quickstart
# sphinx-build -b html . _build/html
```

### pydoc

```python
# Generate HTML documentation
# python -m pydoc -w module_name

# View documentation in browser
# python -m pydoc -p 8000
```

### doctest

```python
def add(a, b):
    """Add two numbers.
    
    >>> add(2, 3)
    5
    >>> add(-1, 1)
    0
    >>> add(0, 0)
    0
    """
    return a + b

# Run doctests
# python -m doctest module.py
```

---

## Complete Documentation Example

```python
"""User Management Module.

This module provides comprehensive user management functionality including
user creation, authentication, profile management, and user data operations.

Classes:
    User: Represents a user in the system
    UserManager: Manages user operations and API interactions

Functions:
    validate_email: Validates email address format
    hash_password: Securely hash passwords

Example:
    Basic usage::
    
        >>> from user_manager import UserManager
        >>> manager = UserManager('https://api.example.com')
        >>> user = manager.create_user('alice', 'alice@example.com')
        >>> print(user.username)
        alice

Author:
    Your Name

Version:
    1.0.0
"""

from typing import Optional, Dict, List
from datetime import datetime
import hashlib
import re


def validate_email(email: str) -> bool:
    """Validate email address format.
    
    Uses regex pattern to validate email addresses according to
    standard email format specifications.
    
    Args:
        email: Email address to validate
    
    Returns:
        True if email is valid, False otherwise
    
    Example:
        >>> validate_email('user@example.com')
        True
        >>> validate_email('invalid-email')
        False
    """
    pattern = r'^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$'
    return bool(re.match(pattern, email))


def hash_password(password: str) -> str:
    """Hash a password using SHA-256.
    
    Note: In production, use bcrypt or similar for password hashing.
    This is a simplified example.
    
    Args:
        password: Plain text password
    
    Returns:
        Hashed password as hexadecimal string
    
    Example:
        >>> hash_password('mypassword')
        '89e01536ac207279409d4de1e5253e01f4a1769e696db0d6062ca9b8f56767c8'
    """
    return hashlib.sha256(password.encode()).hexdigest()


class User:
    """Represents a user in the system.
    
    This class encapsulates user data and provides methods for
    user-related operations.
    
    Attributes:
        id: Unique user identifier
        username: User's username
        email: User's email address
        created_at: Account creation timestamp
        is_active: Whether the account is active
    
    Example:
        >>> user = User('alice', 'alice@example.com')
        >>> print(user.username)
        'alice'
    """
    
    def __init__(self, username: str, email: str, user_id: Optional[int] = None):
        """Initialize a User instance.
        
        Args:
            username: User's username (must be unique)
            email: User's email address (must be valid and unique)
            user_id: Optional user ID (auto-generated if not provided)
        
        Raises:
            ValueError: If email format is invalid
        """
        if not validate_email(email):
            raise ValueError(f'Invalid email format: {email}')
        
        self.id: Optional[int] = user_id
        self.username: str = username
        self.email: str = email
        self.created_at: datetime = datetime.utcnow()
        self.is_active: bool = True
    
    def deactivate(self) -> None:
        """Deactivate the user account.
        
        Sets is_active to False. This is a soft delete operation.
        """
        self.is_active = False
    
    def activate(self) -> None:
        """Activate the user account.
        
        Sets is_active to True.
        """
        self.is_active = True
    
    def to_dict(self) -> Dict[str, any]:
        """Convert user to dictionary.
        
        Returns:
            Dictionary containing user data
        """
        return {
            'id': self.id,
            'username': self.username,
            'email': self.email,
            'created_at': self.created_at.isoformat(),
            'is_active': self.is_active
        }
    
    def __repr__(self) -> str:
        """String representation of user."""
        return f'<User(username={self.username}, email={self.email})>'


class UserManager:
    """Manages user operations and API interactions.
    
    This class provides a high-level interface for user management
    operations including creation, retrieval, and updates.
    
    Attributes:
        api_url: Base URL for the user API
        session: HTTP session for API requests
    
    Example:
        >>> manager = UserManager('https://api.example.com')
        >>> user_data = manager.create_user('alice', 'alice@example.com')
        >>> user = User(**user_data)
    """
    
    def __init__(self, api_url: str):
        """Initialize UserManager.
        
        Args:
            api_url: Base URL for the user management API
        
        Raises:
            ValueError: If api_url is empty or invalid
        """
        if not api_url:
            raise ValueError('api_url cannot be empty')
        
        self.api_url: str = api_url.rstrip('/')
        self.session = None  # Would be requests.Session() in real implementation
    
    def create_user(self, username: str, email: str, password: Optional[str] = None) -> Dict:
        """Create a new user.
        
        Creates a new user account with the provided information.
        If password is provided, it will be hashed before storage.
        
        Args:
            username: Desired username (must be unique)
            email: User's email address (must be valid and unique)
            password: Optional password (will be hashed)
        
        Returns:
            Dictionary containing created user data
        
        Raises:
            ValueError: If username or email is invalid
            ConnectionError: If API request fails
            ValueError: If username or email already exists
        
        Example:
            >>> manager = UserManager('https://api.example.com')
            >>> user = manager.create_user('alice', 'alice@example.com', 'password123')
            >>> print(user['username'])
            alice
        """
        if not validate_email(email):
            raise ValueError(f'Invalid email format: {email}')
        
        user_data = {
            'username': username,
            'email': email
        }
        
        if password:
            user_data['password_hash'] = hash_password(password)
        
        # In real implementation, make API call
        # response = self.session.post(f'{self.api_url}/users', json=user_data)
        # return response.json()
        
        return user_data
    
    def get_user(self, user_id: int) -> Optional[Dict]:
        """Get user by ID.
        
        Args:
            user_id: User ID to retrieve
        
        Returns:
            User data dictionary or None if not found
        
        Raises:
            ConnectionError: If API request fails
        
        Example:
            >>> manager = UserManager('https://api.example.com')
            >>> user = manager.get_user(1)
            >>> if user:
            ...     print(user['username'])
        """
        # In real implementation, make API call
        # response = self.session.get(f'{self.api_url}/users/{user_id}')
        # return response.json() if response.status_code == 200 else None
        return None
    
    def list_users(self, active_only: bool = True) -> List[Dict]:
        """List all users.
        
        Args:
            active_only: If True, only return active users
        
        Returns:
            List of user data dictionaries
        
        Raises:
            ConnectionError: If API request fails
        
        Example:
            >>> manager = UserManager('https://api.example.com')
            >>> users = manager.list_users(active_only=True)
            >>> print(f'Found {len(users)} active users')
        """
        # In real implementation, make API call
        # response = self.session.get(f'{self.api_url}/users', params={'active': active_only})
        # return response.json()
        return []
```

---

## Best Practices

### 1. Write Clear Docstrings

```python
# Good: Clear and concise
def calculate_total(items, discount=0.0):
    """Calculate total price with discount.
    
    Args:
        items: List of items with 'price' key
        discount: Discount percentage (0.0 to 1.0)
    
    Returns:
        Total price after discount
    """
    pass

# Bad: Vague and unclear
def calc(items, d):
    """Calculate stuff."""
    pass
```

### 2. Keep Comments Up to Date

```python
# Good: Accurate comment
# Use binary search for O(log n) performance
result = binary_search(sorted_list, target)

# Bad: Outdated comment
# Use linear search (but code actually uses binary search)
result = binary_search(sorted_list, target)
```

### 3. Use Type Hints

```python
# Good: With type hints
def process_data(data: List[Dict[str, int]]) -> int:
    """Process data and return result."""
    pass

# Less clear: Without type hints
def process_data(data):
    """Process data and return result."""
    pass
```

### 4. Document Complex Logic

```python
# Good: Explain complex algorithm
def find_optimal_path(graph, start, end):
    """Find optimal path using Dijkstra's algorithm.
    
    This implementation uses a priority queue to efficiently
    find the shortest path in a weighted graph.
    
    Args:
        graph: Graph represented as adjacency list
        start: Starting node
        end: Destination node
    
    Returns:
        List of nodes representing the optimal path
    """
    # Implementation with comments for complex parts
    pass
```

---

## Practice Exercise

### Exercise: Documentation

**Objective**: Add comprehensive documentation to existing code.

**Instructions**:

1. Take a code file without documentation
2. Add module docstring
3. Add function/method docstrings
4. Add type hints
5. Add meaningful comments
6. Use consistent docstring style

**Example Solution**:

```python
"""Data Processing Module.

This module provides utilities for processing and analyzing data,
including filtering, transformation, and aggregation operations.

Classes:
    DataProcessor: Main class for data processing operations
    DataFilter: Utility class for filtering data

Functions:
    calculate_statistics: Calculate basic statistics for data
    normalize_data: Normalize data to 0-1 range

Example:
    Basic usage::
    
        >>> from data_processor import DataProcessor
        >>> processor = DataProcessor()
        >>> result = processor.process([1, 2, 3, 4, 5])
        >>> print(result)
        {'mean': 3.0, 'std': 1.58}

Author:
    Your Name

Version:
    1.0.0
"""

from typing import List, Dict, Optional, Callable
from statistics import mean, stdev


def calculate_statistics(data: List[float]) -> Dict[str, float]:
    """Calculate basic statistics for a list of numbers.
    
    Computes mean and standard deviation for the given data.
    Returns empty dictionary if data is empty.
    
    Args:
        data: List of numeric values
    
    Returns:
        Dictionary with keys:
            - mean: Average value
            - std: Standard deviation
    
    Raises:
        ValueError: If data contains non-numeric values
    
    Example:
        >>> stats = calculate_statistics([1, 2, 3, 4, 5])
        >>> print(stats['mean'])
        3.0
        >>> print(stats['std'])
        1.58...
    """
    if not data:
        return {}
    
    try:
        return {
            'mean': mean(data),
            'std': stdev(data) if len(data) > 1 else 0.0
        }
    except TypeError:
        raise ValueError('Data must contain numeric values')


def normalize_data(data: List[float]) -> List[float]:
    """Normalize data to 0-1 range.
    
    Uses min-max normalization to scale all values to the range [0, 1].
    If all values are the same, returns list of zeros.
    
    Args:
        data: List of numeric values to normalize
    
    Returns:
        List of normalized values in range [0, 1]
    
    Raises:
        ValueError: If data is empty or contains non-numeric values
    
    Example:
        >>> normalize_data([1, 2, 3, 4, 5])
        [0.0, 0.25, 0.5, 0.75, 1.0]
    """
    if not data:
        raise ValueError('Data cannot be empty')
    
    min_val = min(data)
    max_val = max(data)
    
    # Handle case where all values are the same
    if max_val == min_val:
        return [0.0] * len(data)
    
    # Normalize: (x - min) / (max - min)
    return [(x - min_val) / (max_val - min_val) for x in data]


class DataProcessor:
    """Process and analyze data.
    
    This class provides methods for processing data including
    filtering, transformation, and aggregation.
    
    Attributes:
        data: Current data being processed
        filters: List of filter functions to apply
    
    Example:
        >>> processor = DataProcessor([1, 2, 3, 4, 5])
        >>> processor.add_filter(lambda x: x > 2)
        >>> result = processor.apply_filters()
        >>> print(result)
        [3, 4, 5]
    """
    
    def __init__(self, data: Optional[List[float]] = None):
        """Initialize DataProcessor.
        
        Args:
            data: Optional initial data to process
        """
        self.data: List[float] = data if data is not None else []
        self.filters: List[Callable[[float], bool]] = []
    
    def add_data(self, data: List[float]) -> None:
        """Add data to processor.
        
        Args:
            data: List of numeric values to add
        """
        self.data.extend(data)
    
    def add_filter(self, filter_func: Callable[[float], bool]) -> None:
        """Add a filter function.
        
        Filter functions should return True for values to keep.
        
        Args:
            filter_func: Function that takes a value and returns bool
        
        Example:
            >>> processor = DataProcessor([1, 2, 3, 4, 5])
            >>> processor.add_filter(lambda x: x > 2)
            >>> processor.add_filter(lambda x: x < 5)
        """
        self.filters.append(filter_func)
    
    def apply_filters(self) -> List[float]:
        """Apply all filters to data.
        
        Returns:
            Filtered data list
        
        Example:
            >>> processor = DataProcessor([1, 2, 3, 4, 5])
            >>> processor.add_filter(lambda x: x > 2)
            >>> filtered = processor.apply_filters()
            >>> print(filtered)
            [3, 4, 5]
        """
        result = self.data
        
        for filter_func in self.filters:
            result = [x for x in result if filter_func(x)]
        
        return result
    
    def get_statistics(self) -> Dict[str, float]:
        """Get statistics for current data.
        
        Returns:
            Dictionary with mean and std statistics
        
        Example:
            >>> processor = DataProcessor([1, 2, 3, 4, 5])
            >>> stats = processor.get_statistics()
            >>> print(stats['mean'])
            3.0
        """
        return calculate_statistics(self.data)
    
    def normalize(self) -> List[float]:
        """Normalize current data.
        
        Returns:
            Normalized data in range [0, 1]
        
        Note:
            This modifies the internal data. Use copy if needed.
        """
        self.data = normalize_data(self.data)
        return self.data


class DataFilter:
    """Utility class for creating common data filters.
    
    Provides static methods for creating commonly used filter functions.
    
    Example:
        >>> processor = DataProcessor([1, 2, 3, 4, 5])
        >>> processor.add_filter(DataFilter.greater_than(3))
        >>> result = processor.apply_filters()
        >>> print(result)
        [4, 5]
    """
    
    @staticmethod
    def greater_than(threshold: float) -> Callable[[float], bool]:
        """Create filter for values greater than threshold.
        
        Args:
            threshold: Minimum value to keep
        
        Returns:
            Filter function
        """
        return lambda x: x > threshold
    
    @staticmethod
    def less_than(threshold: float) -> Callable[[float], bool]:
        """Create filter for values less than threshold.
        
        Args:
            threshold: Maximum value to keep
        
        Returns:
            Filter function
        """
        return lambda x: x < threshold
    
    @staticmethod
    def in_range(min_val: float, max_val: float) -> Callable[[float], bool]:
        """Create filter for values in range.
        
        Args:
            min_val: Minimum value (inclusive)
            max_val: Maximum value (inclusive)
        
        Returns:
            Filter function
        
        Raises:
            ValueError: If min_val > max_val
        """
        if min_val > max_val:
            raise ValueError('min_val must be <= max_val')
        
        return lambda x: min_val <= x <= max_val


def main():
    """Main function demonstrating module usage."""
    # Create processor with sample data
    processor = DataProcessor([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
    
    # Add filters
    processor.add_filter(DataFilter.greater_than(3))
    processor.add_filter(DataFilter.less_than(8))
    
    # Apply filters
    filtered = processor.apply_filters()
    print(f'Filtered data: {filtered}')
    
    # Get statistics
    stats = processor.get_statistics()
    print(f'Statistics: {stats}')
    
    # Normalize
    normalized = processor.normalize()
    print(f'Normalized: {normalized}')


if __name__ == '__main__':
    main()
```

**Expected Output**: Fully documented code with docstrings, type hints, and comments.

**Challenge** (Optional):
- Generate documentation with Sphinx
- Add doctests
- Create API documentation
- Add examples to all functions
- Document edge cases

---

## Key Takeaways

1. **Docstrings** - Documentation strings for modules, functions, classes
2. **Docstring Styles** - Google, NumPy, Sphinx styles
3. **Type Hints** - Type annotations for better code clarity
4. **Comments** - Inline explanations (explain why, not what)
5. **Module Docstrings** - Document entire modules
6. **Function Docstrings** - Document parameters, returns, raises
7. **Class Docstrings** - Document classes and their attributes
8. **Method Docstrings** - Document methods and their behavior
9. **Type Annotations** - Use typing module for complex types
10. **Documentation Tools** - Sphinx, pydoc, doctest
11. **Best Practices** - Clear, accurate, up-to-date documentation
12. **Self-Documenting Code** - Write code that explains itself
13. **Examples** - Include examples in docstrings
14. **Keep Updated** - Maintain documentation as code changes
15. **Consistency** - Use consistent documentation style

---

## Quiz: Documentation

Test your understanding with these questions:

1. **What are docstrings?**
   - A) Comments
   - B) Documentation strings
   - C) Type hints
   - D) All of the above

2. **What docstring style uses Args/Returns?**
   - A) Google style
   - B) NumPy style
   - C) Sphinx style
   - D) All of the above

3. **What adds type information?**
   - A) Docstrings
   - B) Type hints
   - C) Comments
   - D) All of the above

4. **What should comments explain?**
   - A) What code does
   - B) Why code does it
   - C) How code works
   - D) All of the above

5. **What generates documentation?**
   - A) Sphinx
   - B) pydoc
   - C) doctest
   - D) All of the above

6. **What is Optional type?**
   - A) Can be None
   - B) Required parameter
   - C) Default value
   - D) Type error

7. **What documents modules?**
   - A) Module docstring
   - B) Comments
   - C) Type hints
   - D) All of the above

8. **What is Union type?**
   - A) Multiple possible types
   - B) Single type
   - C) No type
   - D) Generic type

9. **What runs examples in docstrings?**
   - A) doctest
   - B) pytest
   - C) unittest
   - D) All of the above

10. **What should be documented?**
    - A) Functions
    - B) Classes
    - C) Modules
    - D) All of the above

**Answers**:
1. B) Documentation strings (docstrings definition)
2. A) Google style (Args/Returns format)
3. B) Type hints (type information)
4. B) Why code does it (comment best practice)
5. D) All of the above (documentation tools)
6. A) Can be None (Optional type)
7. A) Module docstring (module documentation)
8. A) Multiple possible types (Union type)
9. A) doctest (runs docstring examples)
10. D) All of the above (documentation scope)

---

## Next Steps

Excellent work! You've mastered code documentation. You now understand:
- Docstrings
- Type hints
- Comments best practices
- How to document code effectively

**What's Next?**
- Lesson 24.3: Code Review
- Learn code review process
- Identify common issues
- Improve code quality

---

## Additional Resources

- **PEP 257**: [www.python.org/dev/peps/pep-0257/](https://www.python.org/dev/peps/pep-0257/) (Docstring conventions)
- **PEP 484**: [www.python.org/dev/peps/pep-0484/](https://www.python.org/dev/peps/pep-0484/) (Type hints)
- **Sphinx**: [www.sphinx-doc.org/](https://www.sphinx-doc.org/)
- **Google Style Guide**: [google.github.io/styleguide/pyguide.html](https://google.github.io/styleguide/pyguide.html)
- **NumPy Style Guide**: [numpydoc.readthedocs.io/](https://numpydoc.readthedocs.io/)

---

*Lesson completed! You're ready to move on to the next lesson.*

