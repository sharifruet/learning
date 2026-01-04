# Lesson 13.3: Class Decorators

## Learning Objectives

By the end of this lesson, you will be able to:
- Decorate classes with decorators
- Use property decorators effectively
- Understand built-in decorators (@staticmethod, @classmethod)
- Create class decorators
- Apply decorators to class methods
- Understand property getters, setters, and deleters
- Use @property for computed attributes
- Apply @staticmethod and @classmethod appropriately
- Understand when to use each decorator type
- Create custom class decorators

---

## Introduction to Class Decorators

**Class decorators** are decorators that can be applied to classes to modify or enhance their behavior. Python also provides built-in decorators for classes and methods that are essential for object-oriented programming.

---

## Decorating Classes

### Basic Class Decorator

A class decorator is a function that takes a class and returns a modified class.

```python
def add_methods(cls):
    """Add methods to a class."""
    def new_method(self):
        return "New method added!"
    
    cls.new_method = new_method
    return cls

@add_methods
class MyClass:
    def existing_method(self):
        return "Existing method"

obj = MyClass()
print(obj.existing_method())  # Existing method
print(obj.new_method())       # New method added!
```

### Class Decorator Example: Singleton

```python
def singleton(cls):
    """Make a class a singleton."""
    instances = {}
    
    def get_instance(*args, **kwargs):
        if cls not in instances:
            instances[cls] = cls(*args, **kwargs)
        return instances[cls]
    
    return get_instance

@singleton
class Database:
    def __init__(self):
        print("Database initialized")

# Only one instance is created
db1 = Database()  # Database initialized
db2 = Database()  # No output (uses existing instance)
print(db1 is db2)  # True
```

### Class Decorator Example: Add Attributes

```python
def add_attributes(**attrs):
    """Add attributes to a class."""
    def decorator(cls):
        for key, value in attrs.items():
            setattr(cls, key, value)
        return cls
    return decorator

@add_attributes(version="1.0", author="John Doe")
class MyClass:
    pass

print(MyClass.version)  # 1.0
print(MyClass.author)   # John Doe
```

### Class Decorator Example: Register Classes

```python
registry = {}

def register_class(name):
    """Register a class in a registry."""
    def decorator(cls):
        registry[name] = cls
        return cls
    return decorator

@register_class("user")
class User:
    pass

@register_class("admin")
class Admin:
    pass

print(registry)  # {'user': <class '__main__.User'>, 'admin': <class '__main__.Admin'>}
```

### Class Decorator Example: Freeze Class

```python
def freeze_class(cls):
    """Prevent adding new attributes to class instances."""
    def __setattr__(self, name, value):
        if hasattr(self, name):
            object.__setattr__(self, name, value)
        else:
            raise AttributeError(f"Cannot add new attribute {name}")
    
    cls.__setattr__ = __setattr__
    return cls

@freeze_class
class Point:
    def __init__(self, x, y):
        self.x = x
        self.y = y

p = Point(1, 2)
p.x = 3  # OK (modifying existing)
# p.z = 4  # AttributeError: Cannot add new attribute z
```

---

## Property Decorators

The `@property` decorator allows you to define methods that can be accessed like attributes.

### Basic Property

```python
class Circle:
    def __init__(self, radius):
        self._radius = radius
    
    @property
    def radius(self):
        """Get the radius."""
        return self._radius
    
    @property
    def area(self):
        """Calculate the area."""
        return 3.14159 * self._radius ** 2

circle = Circle(5)
print(circle.radius)  # 5 (accessed like attribute)
print(circle.area)    # 78.53975 (computed property)
```

### Property with Setter

```python
class Circle:
    def __init__(self, radius):
        self._radius = radius
    
    @property
    def radius(self):
        """Get the radius."""
        return self._radius
    
    @radius.setter
    def radius(self, value):
        """Set the radius with validation."""
        if value < 0:
            raise ValueError("Radius must be positive")
        self._radius = value

circle = Circle(5)
print(circle.radius)  # 5
circle.radius = 10
print(circle.radius)  # 10
# circle.radius = -5  # ValueError: Radius must be positive
```

### Property with Deleter

```python
class Circle:
    def __init__(self, radius):
        self._radius = radius
    
    @property
    def radius(self):
        """Get the radius."""
        return self._radius
    
    @radius.setter
    def radius(self, value):
        """Set the radius."""
        if value < 0:
            raise ValueError("Radius must be positive")
        self._radius = value
    
    @radius.deleter
    def radius(self):
        """Delete the radius."""
        print("Deleting radius")
        del self._radius

circle = Circle(5)
print(circle.radius)  # 5
del circle.radius      # Deleting radius
# print(circle.radius)  # AttributeError: 'Circle' object has no attribute '_radius'
```

### Complete Property Example

```python
class Temperature:
    def __init__(self, celsius):
        self._celsius = celsius
    
    @property
    def celsius(self):
        """Temperature in Celsius."""
        return self._celsius
    
    @celsius.setter
    def celsius(self, value):
        """Set temperature in Celsius."""
        self._celsius = value
    
    @property
    def fahrenheit(self):
        """Temperature in Fahrenheit."""
        return self._celsius * 9/5 + 32
    
    @fahrenheit.setter
    def fahrenheit(self, value):
        """Set temperature in Fahrenheit."""
        self._celsius = (value - 32) * 5/9

temp = Temperature(25)
print(f"Celsius: {temp.celsius}")        # Celsius: 25
print(f"Fahrenheit: {temp.fahrenheit}")  # Fahrenheit: 77.0

temp.fahrenheit = 100
print(f"Celsius: {temp.celsius}")        # Celsius: 37.777...
print(f"Fahrenheit: {temp.fahrenheit}")  # Fahrenheit: 100.0
```

### Property for Computed Attributes

```python
class Rectangle:
    def __init__(self, width, height):
        self.width = width
        self.height = height
    
    @property
    def area(self):
        """Calculate area."""
        return self.width * self.height
    
    @property
    def perimeter(self):
        """Calculate perimeter."""
        return 2 * (self.width + self.height)

rect = Rectangle(5, 3)
print(rect.area)       # 15
print(rect.perimeter)  # 16
```

### Property for Data Validation

```python
class Person:
    def __init__(self, age):
        self._age = None
        self.age = age  # Use setter for validation
    
    @property
    def age(self):
        """Get age."""
        return self._age
    
    @age.setter
    def age(self, value):
        """Set age with validation."""
        if not isinstance(value, int):
            raise TypeError("Age must be an integer")
        if value < 0:
            raise ValueError("Age cannot be negative")
        if value > 150:
            raise ValueError("Age cannot exceed 150")
        self._age = value

person = Person(25)
print(person.age)  # 25
person.age = 30
print(person.age)  # 30
# person.age = -5   # ValueError: Age cannot be negative
```

---

## Built-in Decorators

### @staticmethod

`@staticmethod` creates a method that doesn't require access to the instance or class.

```python
class MathUtils:
    @staticmethod
    def add(x, y):
        """Add two numbers."""
        return x + y
    
    @staticmethod
    def multiply(x, y):
        """Multiply two numbers."""
        return x * y

# Can be called on class or instance
result1 = MathUtils.add(3, 4)      # 7
result2 = MathUtils.multiply(3, 4)  # 12

obj = MathUtils()
result3 = obj.add(5, 6)  # 11 (also works on instance)
```

### @classmethod

`@classmethod` creates a method that receives the class as the first argument.

```python
class Person:
    population = 0
    
    def __init__(self, name):
        self.name = name
        Person.population += 1
    
    @classmethod
    def get_population(cls):
        """Get the total population."""
        return cls.population
    
    @classmethod
    def from_string(cls, string):
        """Create Person from string."""
        name = string.strip()
        return cls(name)

person1 = Person("Alice")
person2 = Person("Bob")
print(Person.get_population())  # 2

person3 = Person.from_string("Charlie")
print(Person.get_population())  # 3
```

### @classmethod for Alternative Constructors

```python
class Date:
    def __init__(self, year, month, day):
        self.year = year
        self.month = month
        self.day = day
    
    @classmethod
    def from_string(cls, date_string):
        """Create Date from string 'YYYY-MM-DD'."""
        year, month, day = map(int, date_string.split('-'))
        return cls(year, month, day)
    
    @classmethod
    def from_timestamp(cls, timestamp):
        """Create Date from timestamp."""
        import datetime
        dt = datetime.datetime.fromtimestamp(timestamp)
        return cls(dt.year, dt.month, dt.day)
    
    def __str__(self):
        return f"{self.year}-{self.month:02d}-{self.day:02d}"

date1 = Date(2024, 1, 15)
date2 = Date.from_string("2024-01-15")
date3 = Date.from_timestamp(1705276800)

print(date1)  # 2024-01-15
print(date2)  # 2024-01-15
print(date3)  # 2024-01-15
```

### Comparing @staticmethod and @classmethod

```python
class MyClass:
    class_var = "Class variable"
    
    def __init__(self, instance_var):
        self.instance_var = instance_var
    
    def instance_method(self):
        """Has access to instance and class."""
        print(f"Instance: {self.instance_var}")
        print(f"Class: {self.class_var}")
    
    @classmethod
    def class_method(cls):
        """Has access to class, not instance."""
        print(f"Class: {cls.class_var}")
        # Cannot access self.instance_var
    
    @staticmethod
    def static_method():
        """No access to instance or class."""
        print("Static method")
        # Cannot access self or cls

obj = MyClass("Instance value")
obj.instance_method()  # Has access to both
MyClass.class_method()  # Has access to class only
MyClass.static_method()  # No access to either
```

---

## Advanced Property Patterns

### Cached Property

```python
from functools import lru_cache

class DataProcessor:
    def __init__(self, data):
        self.data = data
    
    @property
    @lru_cache(maxsize=1)
    def processed_data(self):
        """Process data (cached)."""
        print("Processing data...")
        return [x * 2 for x in self.data]

processor = DataProcessor([1, 2, 3])
print(processor.processed_data)  # Processing data..., [2, 4, 6]
print(processor.processed_data)  # [2, 4, 6] (cached, no processing)
```

### Property with Lazy Initialization

```python
class LazyProperty:
    def __init__(self, func):
        self.func = func
        self.name = func.__name__
    
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self
        value = self.func(obj)
        setattr(obj, self.name, value)
        return value

class MyClass:
    @LazyProperty
    def expensive_computation(self):
        print("Computing...")
        return sum(range(1000000))

obj = MyClass()
# Computation happens on first access
result = obj.expensive_computation  # Computing...
# Subsequent accesses use cached value
result = obj.expensive_computation  # No computation
```

### Property Descriptor

```python
class ValidatedProperty:
    def __init__(self, validator):
        self.validator = validator
        self.name = None
    
    def __set_name__(self, owner, name):
        self.name = f"_{name}"
    
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self
        return getattr(obj, self.name, None)
    
    def __set__(self, obj, value):
        if not self.validator(value):
            raise ValueError(f"Invalid value: {value}")
        setattr(obj, self.name, value)

def is_positive(x):
    return isinstance(x, (int, float)) and x > 0

class Circle:
    radius = ValidatedProperty(is_positive)
    
    def __init__(self, radius):
        self.radius = radius

circle = Circle(5)
print(circle.radius)  # 5
# circle.radius = -5  # ValueError: Invalid value: -5
```

---

## Combining Decorators

### Decorating Methods in a Class

```python
from functools import wraps
import time

def timer(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        start = time.time()
        result = func(*args, **kwargs)
        end = time.time()
        print(f"{func.__name__} took {end - start:.4f} seconds")
        return result
    return wrapper

class Calculator:
    @timer
    def add(self, x, y):
        return x + y
    
    @timer
    def multiply(self, x, y):
        return x * y
    
    @staticmethod
    @timer
    def subtract(x, y):
        return x - y

calc = Calculator()
result = calc.add(3, 4)  # add took 0.0000 seconds
result = calc.multiply(3, 4)  # multiply took 0.0000 seconds
result = Calculator.subtract(10, 5)  # subtract took 0.0000 seconds
```

### Property with Method Decorators

```python
from functools import wraps

def log_access(func):
    @wraps(func)
    def wrapper(self, *args, **kwargs):
        print(f"Accessing {func.__name__}")
        return func(self, *args, **kwargs)
    return wrapper

class BankAccount:
    def __init__(self, balance):
        self._balance = balance
    
    @property
    @log_access
    def balance(self):
        return self._balance
    
    @balance.setter
    @log_access
    def balance(self, value):
        print(f"Setting balance to {value}")
        self._balance = value

account = BankAccount(1000)
print(account.balance)  # Accessing balance, 1000
account.balance = 2000  # Accessing balance, Setting balance to 2000
```

---

## Practical Examples

### Example 1: Configuration Class

```python
class Config:
    _instance = None
    
    def __new__(cls):
        if cls._instance is None:
            cls._instance = super().__new__(cls)
        return cls._instance
    
    def __init__(self):
        if not hasattr(self, 'initialized'):
            self._settings = {}
            self.initialized = True
    
    @property
    def settings(self):
        """Get all settings."""
        return self._settings.copy()
    
    def set_setting(self, key, value):
        """Set a configuration setting."""
        self._settings[key] = value
    
    @classmethod
    def load_from_file(cls, filename):
        """Load configuration from file."""
        config = cls()
        # Load from file logic here
        return config

config1 = Config()
config2 = Config()
print(config1 is config2)  # True (singleton)
```

### Example 2: Data Model with Validation

```python
class Product:
    def __init__(self, name, price, quantity):
        self.name = name
        self.price = price
        self.quantity = quantity
    
    @property
    def price(self):
        return self._price
    
    @price.setter
    def price(self, value):
        if value < 0:
            raise ValueError("Price cannot be negative")
        self._price = value
    
    @property
    def quantity(self):
        return self._quantity
    
    @quantity.setter
    def quantity(self, value):
        if not isinstance(value, int):
            raise TypeError("Quantity must be an integer")
        if value < 0:
            raise ValueError("Quantity cannot be negative")
        self._quantity = value
    
    @property
    def total_value(self):
        """Calculate total value."""
        return self.price * self.quantity
    
    @classmethod
    def from_dict(cls, data):
        """Create Product from dictionary."""
        return cls(
            name=data['name'],
            price=data['price'],
            quantity=data['quantity']
        )

product = Product("Widget", 10.99, 5)
print(product.total_value)  # 54.95
```

### Example 3: API Client with Rate Limiting

```python
import time
from functools import wraps

def rate_limit(calls_per_second):
    min_interval = 1.0 / calls_per_second
    last_called = [0.0]
    
    def decorator(func):
        @wraps(func)
        def wrapper(self, *args, **kwargs):
            elapsed = time.time() - last_called[0]
            left_to_wait = min_interval - elapsed
            if left_to_wait > 0:
                time.sleep(left_to_wait)
            last_called[0] = time.time()
            return func(self, *args, **kwargs)
        return wrapper
    return decorator

class APIClient:
    @rate_limit(calls_per_second=2)
    def get_data(self, endpoint):
        """Get data from API."""
        return f"Data from {endpoint}"
    
    @staticmethod
    def parse_response(response):
        """Parse API response."""
        return response.upper()

client = APIClient()
data = client.get_data("/users")
parsed = APIClient.parse_response(data)
```

---

## Common Mistakes and Pitfalls

### 1. Forgetting @property

```python
# WRONG: Method called with ()
class Circle:
    def __init__(self, radius):
        self._radius = radius
    
    def area(self):  # Missing @property
        return 3.14159 * self._radius ** 2

circle = Circle(5)
print(circle.area())  # Must use () - not like attribute

# CORRECT: Use @property
class Circle:
    def __init__(self, radius):
        self._radius = radius
    
    @property
    def area(self):
        return 3.14159 * self._radius ** 2

circle = Circle(5)
print(circle.area)  # Accessed like attribute
```

### 2. Confusing @staticmethod and @classmethod

```python
# WRONG: Using @staticmethod when you need class
class Counter:
    count = 0
    
    @staticmethod
    def increment():
        Counter.count += 1  # Works but not ideal

# CORRECT: Use @classmethod
class Counter:
    count = 0
    
    @classmethod
    def increment(cls):
        cls.count += 1  # Better - uses cls
```

### 3. Property Setter Without Getter

```python
# WRONG: Setter without getter
class Circle:
    @property
    def radius(self):
        return self._radius
    
    # Missing @radius.setter
    def set_radius(self, value):  # Not a property setter
        self._radius = value

# CORRECT: Use @property.setter
class Circle:
    @property
    def radius(self):
        return self._radius
    
    @radius.setter
    def radius(self, value):
        self._radius = value
```

### 4. Modifying Class in Decorator

```python
# WRONG: Modifying class incorrectly
def bad_decorator(cls):
    cls.new_attr = "value"  # Works but not ideal
    return cls

# CORRECT: Return modified class
def good_decorator(cls):
    class NewClass(cls):
        new_attr = "value"
    return NewClass
```

---

## Best Practices

### 1. Use @property for Computed Attributes

```python
class Rectangle:
    def __init__(self, width, height):
        self.width = width
        self.height = height
    
    @property
    def area(self):
        """Use @property for computed values."""
        return self.width * self.height
```

### 2. Use @classmethod for Alternative Constructors

```python
class Date:
    def __init__(self, year, month, day):
        self.year = year
        self.month = month
        self.day = day
    
    @classmethod
    def from_string(cls, date_string):
        """Alternative constructor."""
        year, month, day = map(int, date_string.split('-'))
        return cls(year, month, day)
```

### 3. Use @staticmethod for Utility Functions

```python
class MathUtils:
    @staticmethod
    def add(x, y):
        """Utility function that doesn't need class/instance."""
        return x + y
```

### 4. Validate in Property Setters

```python
class Person:
    @property
    def age(self):
        return self._age
    
    @age.setter
    def age(self, value):
        if value < 0:
            raise ValueError("Age cannot be negative")
        self._age = value
```

### 5. Document Your Decorators

```python
class MyClass:
    @property
    def value(self):
        """Get the value.
        
        Returns:
            The current value.
        """
        return self._value
```

---

## Practice Exercise

### Exercise: Class Decorators

**Objective**: Create a Python program that demonstrates class decorators and built-in decorators.

**Instructions**:

1. Create a file called `class_decorators_practice.py`

2. Write a program that:
   - Creates class decorators
   - Uses @property decorators
   - Uses @staticmethod and @classmethod
   - Demonstrates practical applications
   - Shows advanced patterns

3. Your program should include:
   - Basic class decorators
   - Property decorators with getters/setters/deleters
   - @staticmethod examples
   - @classmethod examples
   - Alternative constructors
   - Real-world examples

**Example Solution**:

```python
"""
Class Decorators Practice
This program demonstrates class decorators and built-in decorators.
"""

from functools import wraps
import time

print("=" * 60)
print("CLASS DECORATORS PRACTICE")
print("=" * 60)
print()

# 1. Basic class decorator
print("1. BASIC CLASS DECORATOR")
print("-" * 60)

def add_methods(cls):
    """Add methods to a class."""
    def new_method(self):
        return "New method added!"
    
    cls.new_method = new_method
    return cls

@add_methods
class MyClass:
    def existing_method(self):
        return "Existing method"

obj = MyClass()
print(f"Existing: {obj.existing_method()}")
print(f"New: {obj.new_method()}")
print()

# 2. Singleton decorator
print("2. SINGLETON DECORATOR")
print("-" * 60)

def singleton(cls):
    """Make a class a singleton."""
    instances = {}
    
    def get_instance(*args, **kwargs):
        if cls not in instances:
            instances[cls] = cls(*args, **kwargs)
        return instances[cls]
    
    return get_instance

@singleton
class Database:
    def __init__(self):
        print("Database initialized")

db1 = Database()  # Database initialized
db2 = Database()  # No output
print(f"Same instance: {db1 is db2}")
print()

# 3. Basic property
print("3. BASIC PROPERTY")
print("-" * 60)

class Circle:
    def __init__(self, radius):
        self._radius = radius
    
    @property
    def radius(self):
        return self._radius
    
    @property
    def area(self):
        return 3.14159 * self._radius ** 2

circle = Circle(5)
print(f"Radius: {circle.radius}")
print(f"Area: {circle.area}")
print()

# 4. Property with setter
print("4. PROPERTY WITH SETTER")
print("-" * 60)

class Circle:
    def __init__(self, radius):
        self._radius = radius
    
    @property
    def radius(self):
        return self._radius
    
    @radius.setter
    def radius(self, value):
        if value < 0:
            raise ValueError("Radius must be positive")
        self._radius = value

circle = Circle(5)
print(f"Radius: {circle.radius}")
circle.radius = 10
print(f"New radius: {circle.radius}")
print()

# 5. Property with deleter
print("5. PROPERTY WITH DELETER")
print("-" * 60)

class Circle:
    def __init__(self, radius):
        self._radius = radius
    
    @property
    def radius(self):
        return self._radius
    
    @radius.setter
    def radius(self, value):
        self._radius = value
    
    @radius.deleter
    def radius(self):
        print("Deleting radius")
        del self._radius

circle = Circle(5)
print(f"Radius: {circle.radius}")
del circle.radius
print()

# 6. Temperature conversion with properties
print("6. TEMPERATURE CONVERSION")
print("-" * 60)

class Temperature:
    def __init__(self, celsius):
        self._celsius = celsius
    
    @property
    def celsius(self):
        return self._celsius
    
    @celsius.setter
    def celsius(self, value):
        self._celsius = value
    
    @property
    def fahrenheit(self):
        return self._celsius * 9/5 + 32
    
    @fahrenheit.setter
    def fahrenheit(self, value):
        self._celsius = (value - 32) * 5/9

temp = Temperature(25)
print(f"Celsius: {temp.celsius}, Fahrenheit: {temp.fahrenheit}")
temp.fahrenheit = 100
print(f"Celsius: {temp.celsius:.2f}, Fahrenheit: {temp.fahrenheit}")
print()

# 7. @staticmethod
print("7. @staticmethod")
print("-" * 60)

class MathUtils:
    @staticmethod
    def add(x, y):
        return x + y
    
    @staticmethod
    def multiply(x, y):
        return x * y

result1 = MathUtils.add(3, 4)
result2 = MathUtils.multiply(3, 4)
print(f"Add: {result1}, Multiply: {result2}")

obj = MathUtils()
result3 = obj.add(5, 6)
print(f"Instance call: {result3}")
print()

# 8. @classmethod
print("8. @classmethod")
print("-" * 60)

class Person:
    population = 0
    
    def __init__(self, name):
        self.name = name
        Person.population += 1
    
    @classmethod
    def get_population(cls):
        return cls.population
    
    @classmethod
    def from_string(cls, string):
        name = string.strip()
        return cls(name)

person1 = Person("Alice")
person2 = Person("Bob")
print(f"Population: {Person.get_population()}")

person3 = Person.from_string("Charlie")
print(f"Population: {Person.get_population()}")
print()

# 9. Alternative constructor
print("9. ALTERNATIVE CONSTRUCTOR")
print("-" * 60)

class Date:
    def __init__(self, year, month, day):
        self.year = year
        self.month = month
        self.day = day
    
    @classmethod
    def from_string(cls, date_string):
        year, month, day = map(int, date_string.split('-'))
        return cls(year, month, day)
    
    def __str__(self):
        return f"{self.year}-{self.month:02d}-{self.day:02d}"

date1 = Date(2024, 1, 15)
date2 = Date.from_string("2024-01-15")
print(f"Date1: {date1}")
print(f"Date2: {date2}")
print()

# 10. Property validation
print("10. PROPERTY VALIDATION")
print("-" * 60)

class Person:
    def __init__(self, age):
        self._age = None
        self.age = age
    
    @property
    def age(self):
        return self._age
    
    @age.setter
    def age(self, value):
        if not isinstance(value, int):
            raise TypeError("Age must be an integer")
        if value < 0:
            raise ValueError("Age cannot be negative")
        self._age = value

person = Person(25)
print(f"Age: {person.age}")
person.age = 30
print(f"New age: {person.age}")
print()

# 11. Computed property
print("11. COMPUTED PROPERTY")
print("-" * 60)

class Rectangle:
    def __init__(self, width, height):
        self.width = width
        self.height = height
    
    @property
    def area(self):
        return self.width * self.height
    
    @property
    def perimeter(self):
        return 2 * (self.width + self.height)

rect = Rectangle(5, 3)
print(f"Area: {rect.area}, Perimeter: {rect.perimeter}")
print()

# 12. Class decorator with attributes
print("12. CLASS DECORATOR WITH ATTRIBUTES")
print("-" * 60)

def add_attributes(**attrs):
    def decorator(cls):
        for key, value in attrs.items():
            setattr(cls, key, value)
        return cls
    return decorator

@add_attributes(version="1.0", author="John Doe")
class MyClass:
    pass

print(f"Version: {MyClass.version}, Author: {MyClass.author}")
print()

# 13. Register classes
print("13. REGISTER CLASSES")
print("-" * 60)

registry = {}

def register_class(name):
    def decorator(cls):
        registry[name] = cls
        return cls
    return decorator

@register_class("user")
class User:
    pass

@register_class("admin")
class Admin:
    pass

print(f"Registry: {list(registry.keys())}")
print()

# 14. Combining decorators
print("14. COMBINING DECORATORS")
print("-" * 60)

def timer(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        start = time.time()
        result = func(*args, **kwargs)
        end = time.time()
        print(f"{func.__name__} took {end - start:.4f} seconds")
        return result
    return wrapper

class Calculator:
    @timer
    def add(self, x, y):
        return x + y
    
    @staticmethod
    @timer
    def subtract(x, y):
        return x - y

calc = Calculator()
result = calc.add(3, 4)
result = Calculator.subtract(10, 5)
print()

# 15. Real-world example: Product
print("15. REAL-WORLD EXAMPLE: PRODUCT")
print("-" * 60)

class Product:
    def __init__(self, name, price, quantity):
        self.name = name
        self.price = price
        self.quantity = quantity
    
    @property
    def price(self):
        return self._price
    
    @price.setter
    def price(self, value):
        if value < 0:
            raise ValueError("Price cannot be negative")
        self._price = value
    
    @property
    def total_value(self):
        return self.price * self.quantity
    
    @classmethod
    def from_dict(cls, data):
        return cls(
            name=data['name'],
            price=data['price'],
            quantity=data['quantity']
        )

product = Product("Widget", 10.99, 5)
print(f"Product: {product.name}, Total value: {product.total_value}")

product_dict = {'name': 'Gadget', 'price': 15.99, 'quantity': 3}
product2 = Product.from_dict(product_dict)
print(f"Product2: {product2.name}, Total value: {product2.total_value}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
CLASS DECORATORS PRACTICE
============================================================

1. BASIC CLASS DECORATOR
------------------------------------------------------------
Existing: Existing method
New: New method added!

[... rest of output ...]
```

**Challenge** (Optional):
- Create a class decorator that adds logging to all methods
- Build a property decorator that caches expensive computations
- Implement a class decorator that enforces immutability
- Create a decorator that adds type checking to class methods

---

## Key Takeaways

1. **Class decorators** - modify or enhance classes
2. **@property** - create computed attributes
3. **Property setters** - validate and set values
4. **Property deleters** - handle attribute deletion
5. **@staticmethod** - methods that don't need instance/class
6. **@classmethod** - methods that receive class as first argument
7. **Alternative constructors** - use @classmethod for different ways to create objects
8. **Class decorators** - can add methods, attributes, or modify behavior
9. **Singleton pattern** - implemented with class decorator
10. **Property validation** - validate data in setters
11. **Computed properties** - calculate values on access
12. **Method decorators** - can be combined with class decorators
13. **Best practices** - use appropriate decorator for the task
14. **Documentation** - always document your decorators
15. **Testing** - test decorators thoroughly

---

## Quiz: Class Decorators

Test your understanding with these questions:

1. **What does @property do?**
   - A) Makes a method private
   - B) Allows method to be accessed like attribute
   - C) Makes a method static
   - D) Makes a method a class method

2. **What is the first argument of a @classmethod?**
   - A) self
   - B) cls
   - C) args
   - D) No first argument

3. **What is the first argument of a @staticmethod?**
   - A) self
   - B) cls
   - C) No special first argument
   - D) args

4. **How do you create a property setter?**
   - A) @setter
   - B) @property.setter
   - C) @setter(property_name)
   - D) def set_property_name()

5. **What is a class decorator?**
   - A) Decorator that modifies a class
   - B) Decorator inside a class
   - C) Class that is a decorator
   - D) All of the above

6. **When should you use @staticmethod?**
   - A) When you need access to instance
   - B) When you need access to class
   - C) When you don't need instance or class
   - D) Never

7. **When should you use @classmethod?**
   - A) For alternative constructors
   - B) When you need class but not instance
   - C) For utility functions
   - D) Both A and B

8. **Can you combine @property with other decorators?**
   - A) No
   - B) Yes, but only with @staticmethod
   - C) Yes, with any decorator
   - D) Only with @classmethod

9. **What does a property deleter do?**
   - A) Deletes the property
   - B) Handles deletion of attribute
   - C) Removes property decorator
   - D) Nothing

10. **What is the order of decorators when stacking?**
    - A) Top to bottom
    - B) Bottom to top
    - C) Random
    - D) Depends on decorator

**Answers**:
1. B) Allows method to be accessed like attribute (@property purpose)
2. B) cls (first argument of @classmethod)
3. C) No special first argument (@staticmethod has no special first argument)
4. B) @property.setter (property setter syntax)
5. A) Decorator that modifies a class (class decorator definition)
6. C) When you don't need instance or class (@staticmethod use case)
7. D) Both A and B (@classmethod use cases)
8. C) Yes, with any decorator (decorator combination)
9. B) Handles deletion of attribute (property deleter purpose)
10. B) Bottom to top (decorator execution order)

---

## Next Steps

Excellent work! You've mastered class decorators. You now understand:
- How to decorate classes
- Property decorators
- Built-in decorators (@staticmethod, @classmethod)
- Advanced patterns

**What's Next?**
- Lesson 13.4: Advanced Decorator Patterns
- Learn functools.wraps in detail
- Explore decorator factories
- Understand advanced decorator techniques

---

## Additional Resources

- **Property Decorator**: [docs.python.org/3/library/functions.html#property](https://docs.python.org/3/library/functions.html#property)
- **@staticmethod**: [docs.python.org/3/library/functions.html#staticmethod](https://docs.python.org/3/library/functions.html#staticmethod)
- **@classmethod**: [docs.python.org/3/library/functions.html#classmethod](https://docs.python.org/3/library/functions.html#classmethod)
- **Descriptors**: [docs.python.org/3/howto/descriptor.html](https://docs.python.org/3/howto/descriptor.html)

---

*Lesson completed! You're ready to move on to the next lesson.*

