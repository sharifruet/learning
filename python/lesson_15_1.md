# Lesson 15.1: Descriptors

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the descriptor protocol
- Work with property descriptors
- Create custom descriptors
- Understand data descriptors vs non-data descriptors
- Use descriptors for validation
- Implement lazy attributes
- Understand descriptor precedence
- Apply descriptors in real-world scenarios
- Debug descriptor issues
- Understand when to use descriptors

---

## Introduction to Descriptors

**Descriptors** are objects that define how attribute access is handled. They are a powerful feature that underlies properties, methods, static methods, and class methods in Python.

### Why Descriptors?

- **Reusable validation**: Apply same validation logic to multiple attributes
- **Lazy evaluation**: Compute values only when accessed
- **Attribute control**: Control how attributes are accessed, set, and deleted
- **Code reuse**: Share behavior across multiple attributes
- **Powerful abstraction**: Foundation for many Python features

### What Are Descriptors?

A descriptor is an object that implements one or more of:
- `__get__()`: Called when attribute is accessed
- `__set__()`: Called when attribute is set
- `__delete__()`: Called when attribute is deleted

---

## Descriptor Protocol

### Basic Descriptor Protocol

A descriptor must implement at least one of these methods:

```python
class Descriptor:
    def __get__(self, obj, objtype=None):
        """Called when attribute is accessed."""
        return value
    
    def __set__(self, obj, value):
        """Called when attribute is set."""
        pass
    
    def __delete__(self, obj):
        """Called when attribute is deleted."""
        pass
```

### Understanding `__get__`

The `__get__` method receives:
- `self`: The descriptor instance
- `obj`: The instance that owns the attribute (None if accessed on class)
- `objtype`: The class that owns the attribute

```python
class MyDescriptor:
    def __get__(self, obj, objtype=None):
        if obj is None:
            # Accessed on class
            return self
        # Accessed on instance
        return f"Value for {obj}"

class MyClass:
    attr = MyDescriptor()

obj = MyClass()
print(obj.attr)        # Value for <__main__.MyClass object at 0x...>
print(MyClass.attr)    # <__main__.MyDescriptor object at 0x...>
```

### Understanding `__set__`

The `__set__` method receives:
- `self`: The descriptor instance
- `obj`: The instance that owns the attribute
- `value`: The value being set

```python
class MyDescriptor:
    def __set__(self, obj, value):
        print(f"Setting value {value} on {obj}")
        obj._value = value
    
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self
        return getattr(obj, '_value', None)

class MyClass:
    attr = MyDescriptor()

obj = MyClass()
obj.attr = 42  # Setting value 42 on <__main__.MyClass object at 0x...>
print(obj.attr)  # 42
```

### Understanding `__delete__`

The `__delete__` method receives:
- `self`: The descriptor instance
- `obj`: The instance that owns the attribute

```python
class MyDescriptor:
    def __delete__(self, obj):
        print(f"Deleting attribute on {obj}")
        if hasattr(obj, '_value'):
            delattr(obj, '_value')
    
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self
        return getattr(obj, '_value', None)

class MyClass:
    attr = MyDescriptor()

obj = MyClass()
obj.attr = 42
del obj.attr  # Deleting attribute on <__main__.MyClass object at 0x...>
```

---

## Data Descriptors vs Non-Data Descriptors

### Data Descriptors

A **data descriptor** implements `__set__` (and optionally `__delete__`). Data descriptors take precedence over instance dictionaries.

```python
class DataDescriptor:
    def __get__(self, obj, objtype=None):
        return getattr(obj, '_value', None)
    
    def __set__(self, obj, value):
        obj._value = value

class MyClass:
    attr = DataDescriptor()

obj = MyClass()
obj.attr = 42
obj.__dict__['attr'] = 100  # Stored in instance dict
print(obj.attr)  # 42 (descriptor takes precedence)
```

### Non-Data Descriptors

A **non-data descriptor** only implements `__get__`. Non-data descriptors are overridden by instance dictionaries.

```python
class NonDataDescriptor:
    def __get__(self, obj, objtype=None):
        return "Descriptor value"

class MyClass:
    attr = NonDataDescriptor()

obj = MyClass()
print(obj.attr)  # Descriptor value
obj.attr = 100  # Stored in instance dict
print(obj.attr)  # 100 (instance dict overrides descriptor)
```

### Descriptor Precedence

The attribute lookup order is:
1. Data descriptors (on class)
2. Instance dictionary
3. Non-data descriptors (on class)
4. `__getattr__` (if defined)

```python
class DataDescriptor:
    def __get__(self, obj, objtype=None):
        return "Data descriptor"
    def __set__(self, obj, value):
        pass

class NonDataDescriptor:
    def __get__(self, obj, objtype=None):
        return "Non-data descriptor"

class MyClass:
    data_attr = DataDescriptor()
    non_data_attr = NonDataDescriptor()

obj = MyClass()
print(obj.data_attr)  # Data descriptor
obj.__dict__['data_attr'] = "Instance value"
print(obj.data_attr)  # Data descriptor (still takes precedence)

print(obj.non_data_attr)  # Non-data descriptor
obj.__dict__['non_data_attr'] = "Instance value"
print(obj.non_data_attr)  # Instance value (overrides descriptor)
```

---

## Property Descriptors

The `@property` decorator creates a descriptor. Understanding this helps you create custom descriptors.

### How @property Works

```python
class MyClass:
    def __init__(self):
        self._value = 0
    
    @property
    def value(self):
        """Get the value."""
        return self._value
    
    @value.setter
    def value(self, val):
        """Set the value."""
        self._value = val
    
    @value.deleter
    def value(self):
        """Delete the value."""
        del self._value

obj = MyClass()
obj.value = 42
print(obj.value)  # 42
del obj.value
```

### Property as Descriptor

Properties are descriptors under the hood:

```python
class MyClass:
    @property
    def attr(self):
        return "Property value"

obj = MyClass()
print(type(MyClass.attr))  # <class 'property'>
print(hasattr(MyClass.attr, '__get__'))  # True
```

---

## Creating Custom Descriptors

### Example 1: Validated Descriptor

```python
class Validated:
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
    radius = Validated(is_positive)
    
    def __init__(self, radius):
        self.radius = radius

circle = Circle(5)
print(circle.radius)  # 5
# circle.radius = -5  # ValueError: Invalid value: -5
```

### Example 2: Type Checked Descriptor

```python
class Typed:
    def __init__(self, expected_type):
        self.expected_type = expected_type
        self.name = None
    
    def __set_name__(self, owner, name):
        self.name = f"_{name}"
    
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self
        return getattr(obj, self.name, None)
    
    def __set__(self, obj, value):
        if not isinstance(value, self.expected_type):
            raise TypeError(
                f"Expected {self.expected_type.__name__}, "
                f"got {type(value).__name__}"
            )
        setattr(obj, self.name, value)

class Person:
    name = Typed(str)
    age = Typed(int)
    
    def __init__(self, name, age):
        self.name = name
        self.age = age

person = Person("Alice", 25)
print(f"{person.name} is {person.age}")
# person.name = 123  # TypeError
```

### Example 3: Lazy Attribute Descriptor

```python
class LazyProperty:
    def __init__(self, func):
        self.func = func
        self.name = None
    
    def __set_name__(self, owner, name):
        self.name = name
    
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self
        if self.name not in obj.__dict__:
            # Compute and cache value
            obj.__dict__[self.name] = self.func(obj)
        return obj.__dict__[self.name]

class MyClass:
    def __init__(self, data):
        self.data = data
    
    @LazyProperty
    def expensive_computation(self):
        print("Computing expensive value...")
        return sum(x ** 2 for x in range(len(self.data)))

obj = MyClass([1, 2, 3, 4, 5])
# Computation happens on first access
result = obj.expensive_computation  # Computing expensive value...
# Subsequent accesses use cached value
result = obj.expensive_computation  # No computation
```

### Example 4: Cached Descriptor

```python
from functools import lru_cache

class CachedProperty:
    def __init__(self, func):
        self.func = func
        self.name = None
    
    def __set_name__(self, owner, name):
        self.name = name
    
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self
        if self.name not in obj.__dict__:
            obj.__dict__[self.name] = self.func(obj)
        return obj.__dict__[self.name]

class DataProcessor:
    def __init__(self, data):
        self.data = data
    
    @CachedProperty
    def processed_data(self):
        print("Processing data...")
        return [x * 2 for x in self.data]

processor = DataProcessor([1, 2, 3])
print(processor.processed_data)  # Processing data..., [2, 4, 6]
print(processor.processed_data)  # [2, 4, 6] (cached)
```

### Example 5: Read-Only Descriptor

```python
class ReadOnly:
    def __init__(self, value):
        self.value = value
    
    def __get__(self, obj, objtype=None):
        return self.value
    
    def __set__(self, obj, value):
        raise AttributeError("Cannot set read-only attribute")
    
    def __delete__(self, obj):
        raise AttributeError("Cannot delete read-only attribute")

class Config:
    version = ReadOnly("1.0.0")
    author = ReadOnly("John Doe")

config = Config()
print(config.version)  # 1.0.0
# config.version = "2.0.0"  # AttributeError: Cannot set read-only attribute
```

### Example 6: Bounded Descriptor

```python
class Bounded:
    def __init__(self, min_value, max_value):
        self.min_value = min_value
        self.max_value = max_value
        self.name = None
    
    def __set_name__(self, owner, name):
        self.name = f"_{name}"
    
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self
        return getattr(obj, self.name, None)
    
    def __set__(self, obj, value):
        if not (self.min_value <= value <= self.max_value):
            raise ValueError(
                f"Value must be between {self.min_value} and {self.max_value}"
            )
        setattr(obj, self.name, value)

class Temperature:
    celsius = Bounded(-273.15, 1000)  # Absolute zero to reasonable max
    
    def __init__(self, celsius):
        self.celsius = celsius

temp = Temperature(25)
print(temp.celsius)  # 25
# temp.celsius = -300  # ValueError
```

---

## Advanced Descriptor Patterns

### Pattern 1: Descriptor with Storage

```python
class StoredDescriptor:
    def __init__(self):
        self.storage = {}
    
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self
        return self.storage.get(id(obj))
    
    def __set__(self, obj, value):
        self.storage[id(obj)] = value
    
    def __delete__(self, obj):
        self.storage.pop(id(obj), None)

class MyClass:
    attr = StoredDescriptor()

obj1 = MyClass()
obj2 = MyClass()
obj1.attr = "Value 1"
obj2.attr = "Value 2"
print(obj1.attr)  # Value 1
print(obj2.attr)  # Value 2
```

### Pattern 2: Descriptor with Default Value

```python
class DefaultValue:
    def __init__(self, default):
        self.default = default
        self.name = None
    
    def __set_name__(self, owner, name):
        self.name = f"_{name}"
    
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self
        return getattr(obj, self.name, self.default)
    
    def __set__(self, obj, value):
        setattr(obj, self.name, value)

class MyClass:
    value = DefaultValue(42)

obj = MyClass()
print(obj.value)  # 42 (default)
obj.value = 100
print(obj.value)  # 100
```

### Pattern 3: Descriptor with Validation and Transformation

```python
class ValidatedAndTransformed:
    def __init__(self, validator, transformer):
        self.validator = validator
        self.transformer = transformer
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
        transformed = self.transformer(value)
        setattr(obj, self.name, transformed)

def is_positive(x):
    return isinstance(x, (int, float)) and x > 0

def square(x):
    return x ** 2

class MyClass:
    value = ValidatedAndTransformed(is_positive, square)

obj = MyClass()
obj.value = 5
print(obj.value)  # 25 (squared)
```

---

## Common Mistakes and Pitfalls

### 1. Not Using `__set_name__`

```python
# WRONG: Hard-coded attribute name
class BadDescriptor:
    def __get__(self, obj, objtype=None):
        return getattr(obj, '_attr', None)

# CORRECT: Use __set_name__
class GoodDescriptor:
    def __set_name__(self, owner, name):
        self.name = f"_{name}"
    
    def __get__(self, obj, objtype=None):
        return getattr(obj, self.name, None)
```

### 2. Forgetting to Handle Class Access

```python
# WRONG: Doesn't handle class access
class BadDescriptor:
    def __get__(self, obj, objtype=None):
        return obj._value  # Fails when obj is None

# CORRECT: Handle class access
class GoodDescriptor:
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self
        return getattr(obj, '_value', None)
```

### 3. Not Distinguishing Data vs Non-Data Descriptors

```python
# WRONG: Non-data descriptor can be overridden
class NonDataDescriptor:
    def __get__(self, obj, objtype=None):
        return "Descriptor value"

# If you need to prevent overriding, use data descriptor
class DataDescriptor:
    def __get__(self, obj, objtype=None):
        return getattr(obj, '_value', None)
    
    def __set__(self, obj, value):
        obj._value = value  # Makes it a data descriptor
```

### 4. Storing Values in Descriptor Instead of Instance

```python
# WRONG: All instances share the same value
class BadDescriptor:
    def __init__(self):
        self.value = None
    
    def __get__(self, obj, objtype=None):
        return self.value
    
    def __set__(self, obj, value):
        self.value = value  # Shared across all instances!

# CORRECT: Store in instance
class GoodDescriptor:
    def __set_name__(self, owner, name):
        self.name = f"_{name}"
    
    def __get__(self, obj, objtype=None):
        return getattr(obj, self.name, None)
    
    def __set__(self, obj, value):
        setattr(obj, self.name, value)
```

---

## Best Practices

### 1. Use `__set_name__` for Attribute Names

```python
class MyDescriptor:
    def __set_name__(self, owner, name):
        self.name = f"_{name}"
    
    def __get__(self, obj, objtype=None):
        return getattr(obj, self.name, None)
```

### 2. Handle Class Access

```python
class MyDescriptor:
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self  # Accessed on class
        # Accessed on instance
        return getattr(obj, self.name, None)
```

### 3. Use Data Descriptors When Needed

```python
# Use data descriptor if you need to prevent overriding
class DataDescriptor:
    def __set__(self, obj, value):
        # Implementation
        pass
```

### 4. Store Values in Instance, Not Descriptor

```python
class MyDescriptor:
    def __set_name__(self, owner, name):
        self.name = f"_{name}"  # Store in instance
    
    def __set__(self, obj, value):
        setattr(obj, self.name, value)
```

### 5. Document Your Descriptors

```python
class MyDescriptor:
    """Descriptor that does something.
    
    This descriptor validates and stores values.
    """
    def __set_name__(self, owner, name):
        self.name = f"_{name}"
```

---

## Practice Exercise

### Exercise: Descriptors

**Objective**: Create a Python program that demonstrates descriptors.

**Instructions**:

1. Create a file called `descriptors_practice.py`

2. Write a program that:
   - Creates custom descriptors
   - Implements descriptor protocol
   - Demonstrates data vs non-data descriptors
   - Shows practical applications
   - Uses advanced patterns

3. Your program should include:
   - Basic descriptor implementation
   - Validated descriptor
   - Type-checked descriptor
   - Lazy property descriptor
   - Read-only descriptor
   - Bounded descriptor
   - Real-world examples

**Example Solution**:

```python
"""
Descriptors Practice
This program demonstrates descriptors in Python.
"""

print("=" * 60)
print("DESCRIPTORS PRACTICE")
print("=" * 60)
print()

# 1. Basic descriptor
print("1. BASIC DESCRIPTOR")
print("-" * 60)

class MyDescriptor:
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self
        return getattr(obj, '_value', None)
    
    def __set__(self, obj, value):
        obj._value = value

class MyClass:
    attr = MyDescriptor()

obj = MyClass()
obj.attr = 42
print(f"Value: {obj.attr}")
print()

# 2. Validated descriptor
print("2. VALIDATED DESCRIPTOR")
print("-" * 60)

class Validated:
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
    radius = Validated(is_positive)
    
    def __init__(self, radius):
        self.radius = radius

circle = Circle(5)
print(f"Radius: {circle.radius}")
print()

# 3. Type-checked descriptor
print("3. TYPE-CHECKED DESCRIPTOR")
print("-" * 60)

class Typed:
    def __init__(self, expected_type):
        self.expected_type = expected_type
        self.name = None
    
    def __set_name__(self, owner, name):
        self.name = f"_{name}"
    
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self
        return getattr(obj, self.name, None)
    
    def __set__(self, obj, value):
        if not isinstance(value, self.expected_type):
            raise TypeError(
                f"Expected {self.expected_type.__name__}, "
                f"got {type(value).__name__}"
            )
        setattr(obj, self.name, value)

class Person:
    name = Typed(str)
    age = Typed(int)
    
    def __init__(self, name, age):
        self.name = name
        self.age = age

person = Person("Alice", 25)
print(f"{person.name} is {person.age}")
print()

# 4. Lazy property descriptor
print("4. LAZY PROPERTY DESCRIPTOR")
print("-" * 60)

class LazyProperty:
    def __init__(self, func):
        self.func = func
        self.name = None
    
    def __set_name__(self, owner, name):
        self.name = name
    
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self
        if self.name not in obj.__dict__:
            print(f"Computing {self.name}...")
            obj.__dict__[self.name] = self.func(obj)
        return obj.__dict__[self.name]

class MyClass:
    def __init__(self, data):
        self.data = data
    
    @LazyProperty
    def expensive_computation(self):
        return sum(x ** 2 for x in range(len(self.data)))

obj = MyClass([1, 2, 3, 4, 5])
result = obj.expensive_computation  # Computing expensive_computation...
result = obj.expensive_computation  # No computation
print(f"Result: {result}")
print()

# 5. Read-only descriptor
print("5. READ-ONLY DESCRIPTOR")
print("-" * 60)

class ReadOnly:
    def __init__(self, value):
        self.value = value
    
    def __get__(self, obj, objtype=None):
        return self.value
    
    def __set__(self, obj, value):
        raise AttributeError("Cannot set read-only attribute")
    
    def __delete__(self, obj):
        raise AttributeError("Cannot delete read-only attribute")

class Config:
    version = ReadOnly("1.0.0")
    author = ReadOnly("John Doe")

config = Config()
print(f"Version: {config.version}, Author: {config.author}")
print()

# 6. Bounded descriptor
print("6. BOUNDED DESCRIPTOR")
print("-" * 60)

class Bounded:
    def __init__(self, min_value, max_value):
        self.min_value = min_value
        self.max_value = max_value
        self.name = None
    
    def __set_name__(self, owner, name):
        self.name = f"_{name}"
    
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self
        return getattr(obj, self.name, None)
    
    def __set__(self, obj, value):
        if not (self.min_value <= value <= self.max_value):
            raise ValueError(
                f"Value must be between {self.min_value} and {self.max_value}"
            )
        setattr(obj, self.name, value)

class Temperature:
    celsius = Bounded(-273.15, 1000)
    
    def __init__(self, celsius):
        self.celsius = celsius

temp = Temperature(25)
print(f"Temperature: {temp.celsius}°C")
print()

# 7. Data vs non-data descriptors
print("7. DATA VS NON-DATA DESCRIPTORS")
print("-" * 60)

class DataDescriptor:
    def __get__(self, obj, objtype=None):
        return "Data descriptor"
    def __set__(self, obj, value):
        pass

class NonDataDescriptor:
    def __get__(self, obj, objtype=None):
        return "Non-data descriptor"

class MyClass:
    data_attr = DataDescriptor()
    non_data_attr = NonDataDescriptor()

obj = MyClass()
print(f"Data descriptor: {obj.data_attr}")
obj.__dict__['data_attr'] = "Instance value"
print(f"Data descriptor (after override attempt): {obj.data_attr}")

print(f"Non-data descriptor: {obj.non_data_attr}")
obj.__dict__['non_data_attr'] = "Instance value"
print(f"Non-data descriptor (after override): {obj.non_data_attr}")
print()

# 8. Descriptor with storage
print("8. DESCRIPTOR WITH STORAGE")
print("-" * 60)

class StoredDescriptor:
    def __init__(self):
        self.storage = {}
    
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self
        return self.storage.get(id(obj))
    
    def __set__(self, obj, value):
        self.storage[id(obj)] = value

class MyClass:
    attr = StoredDescriptor()

obj1 = MyClass()
obj2 = MyClass()
obj1.attr = "Value 1"
obj2.attr = "Value 2"
print(f"Obj1: {obj1.attr}, Obj2: {obj2.attr}")
print()

# 9. Default value descriptor
print("9. DEFAULT VALUE DESCRIPTOR")
print("-" * 60)

class DefaultValue:
    def __init__(self, default):
        self.default = default
        self.name = None
    
    def __set_name__(self, owner, name):
        self.name = f"_{name}"
    
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self
        return getattr(obj, self.name, self.default)
    
    def __set__(self, obj, value):
        setattr(obj, self.name, value)

class MyClass:
    value = DefaultValue(42)

obj = MyClass()
print(f"Default value: {obj.value}")
obj.value = 100
print(f"Set value: {obj.value}")
print()

# 10. Real-world: Product with validation
print("10. REAL-WORLD: PRODUCT WITH VALIDATION")
print("-" * 60)

class Positive:
    def __init__(self):
        self.name = None
    
    def __set_name__(self, owner, name):
        self.name = f"_{name}"
    
    def __get__(self, obj, objtype=None):
        if obj is None:
            return self
        return getattr(obj, self.name, None)
    
    def __set__(self, obj, value):
        if not isinstance(value, (int, float)) or value < 0:
            raise ValueError(f"{self.name[1:]} must be positive")
        setattr(obj, self.name, value)

class Product:
    price = Positive()
    quantity = Positive()
    
    def __init__(self, name, price, quantity):
        self.name = name
        self.price = price
        self.quantity = quantity
    
    @property
    def total_value(self):
        return self.price * self.quantity

product = Product("Widget", 10.99, 5)
print(f"{product.name}: ${product.price} x {product.quantity} = ${product.total_value}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
DESCRIPTORS PRACTICE
============================================================

1. BASIC DESCRIPTOR
------------------------------------------------------------
Value: 42

[... rest of output ...]
```

**Challenge** (Optional):
- Create a descriptor that logs all attribute access
- Build a descriptor that implements memoization
- Implement a descriptor that enforces immutability after first set
- Create a descriptor that validates based on multiple conditions

---

## Key Takeaways

1. **Descriptor protocol** - `__get__`, `__set__`, `__delete__`
2. **Data descriptors** - implement `__set__`, take precedence over instance dict
3. **Non-data descriptors** - only implement `__get__`, overridden by instance dict
4. **`__set_name__`** - called to set the attribute name
5. **Class access** - handle `obj is None` in `__get__`
6. **Storage** - store values in instance, not descriptor
7. **Validation** - use descriptors for reusable validation
8. **Lazy evaluation** - compute values only when accessed
9. **Properties** - are descriptors under the hood
10. **Precedence** - data descriptors > instance dict > non-data descriptors
11. **Reusability** - share behavior across multiple attributes
12. **Powerful** - foundation for many Python features
13. **Best practices** - use `__set_name__`, handle class access, store in instance
14. **Documentation** - always document your descriptors
15. **Testing** - test descriptors thoroughly

---

## Quiz: Descriptors

Test your understanding with these questions:

1. **What methods does the descriptor protocol define?**
   - A) `__get__`, `__set__`, `__delete__`
   - B) `__init__`, `__del__`
   - C) `get`, `set`, `delete`
   - D) `__call__`

2. **What is a data descriptor?**
   - A) Descriptor that stores data
   - B) Descriptor that implements `__set__`
   - C) Descriptor that implements `__get__`
   - D) Descriptor that implements `__delete__`

3. **What is the precedence order for attribute lookup?**
   - A) Instance dict > data descriptor > non-data descriptor
   - B) Data descriptor > instance dict > non-data descriptor
   - C) Non-data descriptor > data descriptor > instance dict
   - D) Random

4. **What does `__set_name__` do?**
   - A) Sets the descriptor name
   - B) Sets the attribute name on the descriptor
   - C) Sets the value
   - D) Nothing

5. **When is `obj` None in `__get__`?**
   - A) Never
   - B) When accessed on class
   - C) When accessed on instance
   - D) Always

6. **Where should descriptor values be stored?**
   - A) In the descriptor
   - B) In the instance
   - C) In the class
   - D) Anywhere

7. **What is @property?**
   - A) A function
   - B) A descriptor
   - C) A class
   - D) A method

8. **What is a non-data descriptor?**
   - A) Descriptor without `__get__`
   - B) Descriptor with only `__get__`
   - C) Descriptor with `__set__`
   - D) Descriptor with `__delete__`

9. **Can instance dict override a data descriptor?**
   - A) Yes
   - B) No
   - C) Sometimes
   - D) Only in Python 3.9+

10. **What is the main advantage of descriptors?**
    - A) Performance
    - B) Code reuse
    - C) Simplicity
    - D) All of the above

**Answers**:
1. A) `__get__`, `__set__`, `__delete__` (descriptor protocol methods)
2. B) Descriptor that implements `__set__` (data descriptor definition)
3. B) Data descriptor > instance dict > non-data descriptor (attribute lookup order)
4. B) Sets the attribute name on the descriptor (`__set_name__` purpose)
5. B) When accessed on class (`obj` is None on class access)
6. B) In the instance (where to store descriptor values)
7. B) A descriptor (@property is a descriptor)
8. B) Descriptor with only `__get__` (non-data descriptor definition)
9. B) No (data descriptors take precedence)
10. B) Code reuse (main advantage of descriptors)

---

## Next Steps

Excellent work! You've mastered descriptors. You now understand:
- The descriptor protocol
- Property descriptors
- Creating custom descriptors
- Data vs non-data descriptors

**What's Next?**
- Lesson 15.2: Metaclasses
- Learn what metaclasses are
- Understand how to create metaclasses
- Explore metaclass patterns

---

## Additional Resources

- **Descriptors**: [docs.python.org/3/howto/descriptor.html](https://docs.python.org/3/howto/descriptor.html)
- **Descriptor Protocol**: [docs.python.org/3/reference/datamodel.html#descriptors](https://docs.python.org/3/reference/datamodel.html#descriptors)
- **PEP 252**: [peps.python.org/pep-0252/](https://peps.python.org/pep-0252/) (Making Types Look More Like Classes)

---

*Lesson completed! You're ready to move on to the next lesson.*

