# Lesson 24.3: Code Review

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the code review process
- Identify common code issues
- Provide constructive feedback
- Review code for quality, security, and performance
- Check for PEP 8 compliance
- Review documentation and tests
- Apply code review best practices
- Use code review tools
- Conduct effective code reviews
- Respond to code review feedback
- Improve code through reviews
- Debug code review issues

---

## Introduction to Code Review

**Code Review** is the systematic examination of code by one or more developers to identify bugs, improve code quality, and share knowledge.

**Benefits**:
- **Quality**: Catch bugs before production
- **Knowledge Sharing**: Team members learn from each other
- **Consistency**: Maintain coding standards
- **Security**: Identify security vulnerabilities
- **Performance**: Find performance issues
- **Best Practices**: Ensure code follows best practices

**Types of Code Review**:
- **Formal**: Structured review with checklist
- **Informal**: Quick review for small changes
- **Pair Programming**: Real-time review
- **Automated**: Using tools and linters

---

## Review Process

### Code Review Workflow

```python
# Typical workflow:
# 1. Developer creates pull request (PR)
# 2. Automated checks run (tests, linters)
# 3. Reviewers assigned
# 4. Reviewers examine code
# 5. Feedback provided
# 6. Developer addresses feedback
# 7. Re-review if needed
# 8. Approval and merge
```

### What to Review

**Functionality**:
- Does the code work correctly?
- Are edge cases handled?
- Are error cases handled?
- Does it meet requirements?

**Code Quality**:
- Is code readable and maintainable?
- Does it follow PEP 8?
- Are there code smells?
- Is code well-organized?

**Performance**:
- Are there performance issues?
- Are algorithms efficient?
- Are there unnecessary operations?
- Is memory usage reasonable?

**Security**:
- Are there security vulnerabilities?
- Is input validated?
- Are secrets handled properly?
- Is SQL injection prevented?

**Testing**:
- Are there tests?
- Do tests cover edge cases?
- Are tests maintainable?
- Is test coverage adequate?

**Documentation**:
- Is code documented?
- Are docstrings present?
- Are comments helpful?
- Is README updated?

---

## Common Issues

### Code Quality Issues

```python
# Issue 1: Magic numbers
# BAD
if user.age > 65:
    discount = 0.15

# GOOD
SENIOR_CITIZEN_AGE = 65
SENIOR_DISCOUNT = 0.15
if user.age > SENIOR_CITIZEN_AGE:
    discount = SENIOR_DISCOUNT

# Issue 2: Long functions
# BAD: Function does too much
def process_order(order):
    # Validate order
    # Calculate total
    # Apply discounts
    # Process payment
    # Send confirmation
    # Update inventory
    # ... 100 lines of code
    pass

# GOOD: Break into smaller functions
def process_order(order):
    validate_order(order)
    total = calculate_total(order)
    apply_discounts(order, total)
    process_payment(order, total)
    send_confirmation(order)
    update_inventory(order)

# Issue 3: Duplicate code
# BAD: Code duplication
def calculate_user_total(user):
    total = 0
    for item in user.items:
        total += item.price * item.quantity
    return total

def calculate_order_total(order):
    total = 0
    for item in order.items:
        total += item.price * item.quantity
    return total

# GOOD: Extract common logic
def calculate_total(items):
    return sum(item.price * item.quantity for item in items)

def calculate_user_total(user):
    return calculate_total(user.items)

def calculate_order_total(order):
    return calculate_total(order.items)
```

### Security Issues

```python
# Issue 1: SQL Injection
# BAD: Vulnerable to SQL injection
def get_user(username):
    query = f"SELECT * FROM users WHERE username = '{username}'"
    # Vulnerable!

# GOOD: Use parameterized queries
def get_user(username):
    query = "SELECT * FROM users WHERE username = ?"
    cursor.execute(query, (username,))

# Issue 2: Hardcoded secrets
# BAD: Secrets in code
API_KEY = "sk-1234567890abcdef"
PASSWORD = "admin123"

# GOOD: Use environment variables
import os
API_KEY = os.environ.get('API_KEY')
PASSWORD = os.environ.get('PASSWORD')

# Issue 3: No input validation
# BAD: No validation
def process_payment(amount):
    charge_card(amount)  # What if amount is negative?

# GOOD: Validate input
def process_payment(amount):
    if amount <= 0:
        raise ValueError('Amount must be positive')
    if amount > MAX_PAYMENT:
        raise ValueError(f'Amount exceeds maximum: {MAX_PAYMENT}')
    charge_card(amount)
```

### Performance Issues

```python
# Issue 1: Inefficient algorithms
# BAD: O(n²) complexity
def find_duplicates(items):
    duplicates = []
    for i in range(len(items)):
        for j in range(i + 1, len(items)):
            if items[i] == items[j]:
                duplicates.append(items[i])
    return duplicates

# GOOD: O(n) complexity
def find_duplicates(items):
    seen = set()
    duplicates = []
    for item in items:
        if item in seen:
            duplicates.append(item)
        seen.add(item)
    return duplicates

# Issue 2: Unnecessary operations
# BAD: Multiple database queries in loop
def get_user_posts(user_ids):
    posts = []
    for user_id in user_ids:
        user = get_user(user_id)  # N queries!
        user_posts = get_posts(user_id)  # N queries!
        posts.extend(user_posts)
    return posts

# GOOD: Batch queries
def get_user_posts(user_ids):
    users = get_users(user_ids)  # 1 query
    posts = get_posts_by_users(user_ids)  # 1 query
    return posts

# Issue 3: Memory inefficiency
# BAD: Loading all data into memory
def process_large_file(filename):
    with open(filename) as f:
        all_lines = f.readlines()  # Loads entire file!
    for line in all_lines:
        process(line)

# GOOD: Process line by line
def process_large_file(filename):
    with open(filename) as f:
        for line in f:
            process(line)
```

### Error Handling Issues

```python
# Issue 1: Silent failures
# BAD: Errors are ignored
def process_data(data):
    try:
        result = complex_operation(data)
    except:
        pass  # Error silently ignored!

# GOOD: Proper error handling
def process_data(data):
    try:
        result = complex_operation(data)
        return result
    except ValueError as e:
        logger.error(f'Invalid data: {e}')
        raise
    except Exception as e:
        logger.error(f'Unexpected error: {e}')
        raise

# Issue 2: Too broad exception handling
# BAD: Catching all exceptions
try:
    risky_operation()
except Exception:  # Too broad!
    handle_error()

# GOOD: Catch specific exceptions
try:
    risky_operation()
except ValueError:
    handle_value_error()
except ConnectionError:
    handle_connection_error()
except Exception as e:
    logger.error(f'Unexpected error: {e}')
    raise

# Issue 3: No error handling
# BAD: No error handling
def divide(a, b):
    return a / b  # What if b is 0?

# GOOD: Handle errors
def divide(a, b):
    if b == 0:
        raise ValueError('Cannot divide by zero')
    return a / b
```

### Documentation Issues

```python
# Issue 1: Missing docstrings
# BAD: No documentation
def calculate(x, y):
    return x * y + 10

# GOOD: Documented
def calculate(x, y):
    """Calculate value using formula.
    
    Args:
        x: First value
        y: Second value
    
    Returns:
        Calculated result: x * y + 10
    """
    return x * y + 10

# Issue 2: Outdated comments
# BAD: Comment doesn't match code
# This function calculates the sum
def calculate(x, y):
    return x * y  # Actually multiplies!

# GOOD: Accurate comments
# This function multiplies two numbers
def calculate(x, y):
    return x * y

# Issue 3: No type hints
# BAD: No type information
def process(data, count):
    # What types are data and count?
    pass

# GOOD: Type hints
def process(data: List[Dict], count: int) -> bool:
    """Process data."""
    pass
```

---

## Best Practices

### For Reviewers

**Be Constructive**:
```python
# BAD: Negative feedback
# This code is terrible!

# GOOD: Constructive feedback
# Consider extracting this logic into a separate function
# for better reusability and testability.
```

**Be Specific**:
```python
# BAD: Vague feedback
# This could be better

# GOOD: Specific feedback
# This function is 50 lines long. Consider breaking it into
# smaller functions: validate_input(), process_data(), format_output()
```

**Ask Questions**:
```python
# GOOD: Ask clarifying questions
# Why was this approach chosen over using the existing utility function?
# Is there a specific reason for this implementation?
```

**Suggest Improvements**:
```python
# GOOD: Provide suggestions
# Consider using a dictionary lookup instead of multiple if-else statements:
# STATUS_MAP = {'pending': 1, 'active': 2, 'completed': 3}
# status_code = STATUS_MAP.get(status, 0)
```

**Check the Big Picture**:
- Does this fit with the overall architecture?
- Are there similar patterns elsewhere in the codebase?
- Does this introduce technical debt?

### For Authors

**Keep PRs Small**:
- Easier to review
- Faster feedback
- Less context switching

**Provide Context**:
- Clear PR description
- Link to related issues
- Explain design decisions

**Respond to Feedback**:
- Acknowledge all comments
- Ask for clarification if needed
- Make requested changes or explain why not

**Test Your Code**:
- Write tests
- Test edge cases
- Verify manually

---

## Code Review Checklist

### Functionality
- [ ] Code works as intended
- [ ] Edge cases are handled
- [ ] Error cases are handled
- [ ] Requirements are met
- [ ] No breaking changes (if applicable)

### Code Quality
- [ ] Follows PEP 8
- [ ] Code is readable
- [ ] No code duplication
- [ ] Functions are focused
- [ ] Proper naming conventions

### Security
- [ ] No hardcoded secrets
- [ ] Input validation present
- [ ] SQL injection prevented
- [ ] XSS prevention (if web)
- [ ] Authentication/authorization correct

### Performance
- [ ] No obvious performance issues
- [ ] Efficient algorithms used
- [ ] No unnecessary operations
- [ ] Memory usage reasonable

### Testing
- [ ] Tests are present
- [ ] Tests cover edge cases
- [ ] Tests are maintainable
- [ ] Test coverage adequate

### Documentation
- [ ] Docstrings present
- [ ] Comments are helpful
- [ ] README updated (if needed)
- [ ] Type hints used (if applicable)

---

## Code Review Tools

### Linters

```bash
# flake8 - Style guide enforcement
pip install flake8
flake8 myfile.py

# pylint - Comprehensive linter
pip install pylint
pylint myfile.py

# black - Code formatter
pip install black
black myfile.py

# mypy - Type checker
pip install mypy
mypy myfile.py
```

### Automated Review

```python
# Pre-commit hooks
# .pre-commit-config.yaml
repos:
  - repo: https://github.com/psf/black
    rev: 22.3.0
    hooks:
      - id: black
  - repo: https://github.com/pycqa/flake8
    rev: 4.0.1
    hooks:
      - id: flake8
```

---

## Practical Examples

### Example 1: Reviewing a Function

```python
# CODE TO REVIEW:
def process_users(users):
    result = []
    for u in users:
        if u.age > 18:
            if u.email:
                if '@' in u.email:
                    result.append(u.email.upper())
    return result

# REVIEW FEEDBACK:
"""
Issues found:
1. Function name is vague - what does "process" mean?
2. Nested if statements make code hard to read
3. Email validation is incomplete (just checks for '@')
4. No error handling if users is None or empty
5. No docstring
6. No type hints
7. Magic number (18) should be a constant

Suggested improvements:
- Rename function to be more specific
- Extract email validation to separate function
- Use early returns or list comprehension
- Add proper email validation
- Add docstring and type hints
- Define constant for minimum age
"""

# IMPROVED CODE:
from typing import List, Optional
import re

MIN_AGE = 18

def get_valid_user_emails(users: List[dict]) -> List[str]:
    """Get uppercase emails for users over minimum age.
    
    Args:
        users: List of user dictionaries with 'age' and 'email' keys
    
    Returns:
        List of uppercase email addresses for valid users
    
    Example:
        >>> users = [{'age': 25, 'email': 'user@example.com'}]
        >>> get_valid_user_emails(users)
        ['USER@EXAMPLE.COM']
    """
    if not users:
        return []
    
    valid_emails = []
    for user in users:
        if user.get('age', 0) > MIN_AGE:
            email = user.get('email')
            if email and is_valid_email(email):
                valid_emails.append(email.upper())
    
    return valid_emails

def is_valid_email(email: str) -> bool:
    """Validate email address format.
    
    Args:
        email: Email address to validate
    
    Returns:
        True if email is valid, False otherwise
    """
    pattern = r'^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$'
    return bool(re.match(pattern, email))
```

### Example 2: Reviewing a Class

```python
# CODE TO REVIEW:
class DataProcessor:
    def __init__(self):
        self.data = []
    
    def add(self, x):
        self.data.append(x)
    
    def process(self):
        total = 0
        for x in self.data:
            total = total + x
        return total / len(self.data)

# REVIEW FEEDBACK:
"""
Issues found:
1. No error handling for division by zero
2. No type hints
3. No docstrings
4. Variable name 'x' is not descriptive
5. Could use sum() instead of manual loop
6. No validation of input data

Suggested improvements:
- Add error handling
- Add type hints and docstrings
- Use more descriptive variable names
- Use built-in functions where possible
- Add input validation
"""

# IMPROVED CODE:
from typing import List
from statistics import mean

class DataProcessor:
    """Processes numeric data and calculates statistics."""
    
    def __init__(self):
        """Initialize DataProcessor with empty data list."""
        self.data: List[float] = []
    
    def add(self, value: float) -> None:
        """Add a value to the data set.
        
        Args:
            value: Numeric value to add
        """
        if not isinstance(value, (int, float)):
            raise TypeError('Value must be numeric')
        self.data.append(float(value))
    
    def process(self) -> float:
        """Calculate mean of all values.
        
        Returns:
            Mean of all values in data set
        
        Raises:
            ValueError: If data set is empty
        """
        if not self.data:
            raise ValueError('Cannot process empty data set')
        
        return mean(self.data)
```

---

## Practice Exercise

### Exercise: Code Review

**Objective**: Review provided code and identify issues.

**Instructions**:

1. Review the provided code
2. Identify issues (quality, security, performance, documentation)
3. Provide constructive feedback
4. Suggest improvements
5. Refactor the code

**Example Solution**:

```python
"""
Code Review Exercise
Review and improve this code
"""

# ORIGINAL CODE (with issues):
def process_orders(orders):
    results = []
    for o in orders:
        total = 0
        for item in o.items:
            total = total + item.price * item.quantity
        if total > 100:
            total = total * 0.9
        results.append({'order_id': o.id, 'total': total})
    return results

# REVIEW FEEDBACK:
"""
Issues identified:
1. No type hints
2. No docstring
3. Magic number (100, 0.9) should be constants
4. Variable names are too short (o, item)
5. Manual sum calculation instead of using sum()
6. No error handling
7. No input validation
8. Hardcoded discount logic
9. Could use list comprehension or generator
10. No handling of edge cases (empty orders, None values)

Improvements:
- Add type hints and docstrings
- Extract constants
- Use descriptive variable names
- Use built-in functions
- Add error handling
- Extract discount logic
- Add input validation
"""

# IMPROVED CODE:
from typing import List, Dict, Optional
from dataclasses import dataclass

# Constants
DISCOUNT_THRESHOLD = 100.0
DISCOUNT_RATE = 0.9

@dataclass
class Item:
    """Represents an order item."""
    price: float
    quantity: int

@dataclass
class Order:
    """Represents an order."""
    id: int
    items: List[Item]

def calculate_item_total(item: Item) -> float:
    """Calculate total for a single item.
    
    Args:
        item: Order item with price and quantity
    
    Returns:
        Total price for the item
    """
    return item.price * item.quantity

def calculate_order_total(order: Order) -> float:
    """Calculate total for an order.
    
    Args:
        order: Order with items
    
    Returns:
        Total price for the order
    """
    if not order.items:
        return 0.0
    
    subtotal = sum(calculate_item_total(item) for item in order.items)
    return subtotal

def apply_discount(total: float) -> float:
    """Apply discount if threshold is met.
    
    Args:
        total: Order total
    
    Returns:
        Total with discount applied if applicable
    """
    if total > DISCOUNT_THRESHOLD:
        return total * DISCOUNT_RATE
    return total

def process_orders(orders: List[Order]) -> List[Dict[str, float]]:
    """Process orders and calculate totals with discounts.
    
    Calculates the total for each order and applies a discount
    if the total exceeds the threshold.
    
    Args:
        orders: List of Order objects to process
    
    Returns:
        List of dictionaries with 'order_id' and 'total' keys
    
    Raises:
        ValueError: If orders is None or contains invalid data
    
    Example:
        >>> items = [Item(price=50.0, quantity=2)]
        >>> order = Order(id=1, items=items)
        >>> results = process_orders([order])
        >>> results[0]['total']
        90.0
    """
    if orders is None:
        raise ValueError('Orders cannot be None')
    
    if not orders:
        return []
    
    results = []
    for order in orders:
        if order is None:
            continue
        
        try:
            total = calculate_order_total(order)
            discounted_total = apply_discount(total)
            
            results.append({
                'order_id': order.id,
                'total': round(discounted_total, 2)
            })
        except (AttributeError, TypeError) as e:
            # Log error and skip invalid order
            print(f'Error processing order {order.id if order else "unknown"}: {e}')
            continue
    
    return results

# Additional improvements: Add tests
def test_process_orders():
    """Test process_orders function."""
    # Test with empty list
    assert process_orders([]) == []
    
    # Test with single order
    items = [Item(price=50.0, quantity=2)]
    order = Order(id=1, items=items)
    results = process_orders([order])
    assert results[0]['total'] == 90.0  # 100 * 0.9
    
    # Test with order below threshold
    items = [Item(price=10.0, quantity=5)]
    order = Order(id=2, items=items)
    results = process_orders([order])
    assert results[0]['total'] == 50.0  # No discount
    
    print('All tests passed!')

if __name__ == '__main__':
    test_process_orders()
```

**Expected Output**: Improved code with all issues addressed.

**Challenge** (Optional):
- Review a larger codebase
- Create a code review checklist
- Set up automated code review tools
- Practice pair programming
- Review open-source projects

---

## Key Takeaways

1. **Code Review** - Systematic code examination
2. **Review Process** - Structured workflow
3. **Common Issues** - Quality, security, performance, errors, documentation
4. **Constructive Feedback** - Be helpful and specific
5. **Checklist** - Use checklist for thorough review
6. **Tools** - Use linters and automated tools
7. **Best Practices** - For reviewers and authors
8. **Security** - Check for vulnerabilities
9. **Performance** - Identify performance issues
10. **Documentation** - Ensure code is documented
11. **Testing** - Verify tests are present and adequate
12. **Code Quality** - Check readability and maintainability
13. **Consistency** - Ensure code follows standards
14. **Learning** - Code review is a learning opportunity
15. **Collaboration** - Improves team collaboration

---

## Quiz: Code Review

Test your understanding with these questions:

1. **What is code review?**
   - A) Testing code
   - B) Systematic code examination
   - C) Writing code
   - D) Debugging code

2. **What should reviewers be?**
   - A) Critical
   - B) Constructive
   - C) Negative
   - D) Silent

3. **What is a code smell?**
   - A) Bad code pattern
   - B) Code that works
   - C) Commented code
   - D) Test code

4. **What should be reviewed?**
   - A) Functionality
   - B) Code quality
   - C) Security
   - D) All of the above

5. **What prevents SQL injection?**
   - A) Input validation
   - B) Parameterized queries
   - C) Escaping
   - D) All of the above

6. **What is a magic number?**
   - A) Hardcoded numeric value
   - B) Random number
   - C) Large number
   - D) Prime number

7. **What checks code style?**
   - A) Linter
   - B) Formatter
   - C) Type checker
   - D) All of the above

8. **What should PRs be?**
   - A) Large
   - B) Small
   - C) Complex
   - D) Simple

9. **What should comments explain?**
   - A) What code does
   - B) Why code does it
   - C) How code works
   - D) All of the above

10. **What improves through code review?**
    - A) Code quality
    - B) Team knowledge
    - C) Code consistency
    - D) All of the above

**Answers**:
1. B) Systematic code examination (code review definition)
2. B) Constructive (reviewer approach)
3. A) Bad code pattern (code smell)
4. D) All of the above (review scope)
5. D) All of the above (SQL injection prevention)
6. A) Hardcoded numeric value (magic number)
7. D) All of the above (code checking tools)
8. B) Small (PR size)
9. B) Why code does it (comment best practice)
10. D) All of the above (code review benefits)

---

## Next Steps

Excellent work! You've mastered code review. You now understand:
- Review process
- Common issues
- Best practices
- How to conduct effective code reviews

**What's Next?**
- Module 25: Design Patterns
- Lesson 25.1: Creational Patterns
- Learn design patterns
- Apply patterns to code

---

## Additional Resources

- **Code Review Best Practices**: Industry best practices
- **Google Code Review Guide**: [google.github.io/eng-practices/review/](https://google.github.io/eng-practices/review/)
- **Code Review Checklist**: Create your own checklist
- **Linting Tools**: flake8, pylint, black documentation

---

*Lesson completed! You're ready to move on to the next module.*

