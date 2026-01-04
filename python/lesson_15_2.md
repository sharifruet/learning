# Lesson 15.2: Metaclasses

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what metaclasses are
- Understand how `type()` creates classes
- Create custom metaclasses
- Understand when to use metaclasses
- Modify class creation behavior
- Apply metaclasses in practical scenarios
- Understand metaclass inheritance
- Debug metaclass issues
- Know when NOT to use metaclasses
- Understand the relationship between classes and metaclasses

---

## Introduction to Metaclasses

**Metaclasses** are classes whose instances are classes. They are the "class of a class" and control how classes are created.

### Why Metaclasses?

- **Class creation control**: Customize how classes are created
- **Automatic behavior**: Add methods/attributes to all subclasses
- **Validation**: Validate class definition at creation time
- **Framework building**: Create powerful frameworks and APIs
- **Advanced patterns**: Enable sophisticated design patterns

### What Are Metaclasses?

In Python, everything is an object, including classes. Classes are instances of metaclasses. By default, classes are instances of `type`.

```python
class MyClass:
    pass

print(type(MyClass))  # <class 'type'>
print(type(type))     # <class 'type'>
```

---

## type() and Class Creation

### Understanding `type()`

`type()` can be used in two ways:
1. As a function: `type(obj)` - returns the type of an object
2. As a class: `type(name, bases, dict)` - creates a new class

### Creating Classes with `type()`

```python
# Traditional class definition
class MyClass:
    x = 1
    def method(self):
        return "Hello"

# Equivalent using type()
MyClass = type('MyClass', (), {'x': 1, 'method': lambda self: "Hello"})

obj = MyClass()
print(obj.x)        # 1
print(obj.method())  # Hello
```

### `type()` with Bases

```python
# Traditional inheritance
class Base:
    pass

class Derived(Base):
    pass

# Equivalent using type()
Base = type('Base', (), {})
Derived = type('Derived', (Base,), {})

print(issubclass(Derived, Base))  # True
```

### `type()` with Methods

```python
def my_method(self):
    return f"Method called on {self}"

# Create class with method
MyClass = type('MyClass', (), {'method': my_method})

obj = MyClass()
print(obj.method())  # Method called on <__main__.MyClass object at 0x...>
```

### Understanding Class Creation Process

When Python creates a class, it:
1. Collects the class name, bases, and namespace
2. Calls the metaclass's `__new__` method
3. Calls the metaclass's `__init__` method
4. Returns the class object

```python
# This:
class MyClass:
    pass

# Is roughly equivalent to:
MyClass = type.__new__(type, 'MyClass', (), {})
type.__init__(MyClass, 'MyClass', (), {})
```

---

## Custom Metaclasses

### Basic Metaclass

A metaclass is a class that inherits from `type`:

```python
class MyMeta(type):
    def __new__(cls, name, bases, namespace):
        print(f"Creating class {name}")
        return super().__new__(cls, name, bases, namespace)
    
    def __init__(cls, name, bases, namespace):
        print(f"Initializing class {name}")
        super().__init__(name, bases, namespace)

class MyClass(metaclass=MyMeta):
    pass

# Output:
# Creating class MyClass
# Initializing class MyClass
```

### Understanding `__new__` in Metaclasses

`__new__` is called to create the class object:

```python
class MyMeta(type):
    def __new__(cls, name, bases, namespace):
        # Modify namespace before class creation
        namespace['created_by'] = 'MyMeta'
        return super().__new__(cls, name, bases, namespace)

class MyClass(metaclass=MyMeta):
    pass

print(MyClass.created_by)  # MyMeta
```

### Understanding `__init__` in Metaclasses

`__init__` is called after the class is created:

```python
class MyMeta(type):
    def __init__(cls, name, bases, namespace):
        # Add attributes to the class
        cls.meta_attr = "Added by metaclass"
        super().__init__(name, bases, namespace)

class MyClass(metaclass=MyMeta):
    pass

print(MyClass.meta_attr)  # Added by metaclass
```

### Modifying Class Namespace

```python
class AutoRegister(type):
    registry = {}
    
    def __new__(cls, name, bases, namespace):
        # Add to registry
        new_class = super().__new__(cls, name, bases, namespace)
        cls.registry[name] = new_class
        return new_class

class Base(metaclass=AutoRegister):
    pass

class Derived1(Base):
    pass

class Derived2(Base):
    pass

print(AutoRegister.registry)
# {'Base': <class '__main__.Base'>, 'Derived1': <class '__main__.Derived1'>, 'Derived2': <class '__main__.Derived2'>}
```

### Adding Methods to Classes

```python
class AddMethod(type):
    def __new__(cls, name, bases, namespace):
        # Add a method to all classes
        def new_method(self):
            return f"Method added by metaclass to {name}"
        
        namespace['meta_method'] = new_method
        return super().__new__(cls, name, bases, namespace)

class MyClass(metaclass=AddMethod):
    pass

obj = MyClass()
print(obj.meta_method())  # Method added by metaclass to MyClass
```

### Validating Class Definition

```python
class ValidateAttributes(type):
    required_attributes = ['name', 'value']
    
    def __new__(cls, name, bases, namespace):
        # Check for required attributes
        for attr in cls.required_attributes:
            if attr not in namespace:
                raise TypeError(f"{name} must define {attr}")
        return super().__new__(cls, name, bases, namespace)

class ValidClass(metaclass=ValidateAttributes):
    name = "Test"
    value = 42

# class InvalidClass(metaclass=ValidateAttributes):
#     pass  # TypeError: InvalidClass must define name
```

---

## Advanced Metaclass Patterns

### Pattern 1: Singleton Metaclass

```python
class Singleton(type):
    _instances = {}
    
    def __call__(cls, *args, **kwargs):
        if cls not in cls._instances:
            cls._instances[cls] = super().__call__(*args, **kwargs)
        return cls._instances[cls]

class MyClass(metaclass=Singleton):
    def __init__(self, value):
        self.value = value

obj1 = MyClass(1)
obj2 = MyClass(2)
print(obj1 is obj2)  # True
print(obj1.value)     # 1 (first value is kept)
```

### Pattern 2: Auto-Property Metaclass

```python
class AutoProperty(type):
    def __new__(cls, name, bases, namespace):
        # Convert private attributes to properties
        new_namespace = {}
        for key, value in namespace.items():
            if key.startswith('_') and not key.startswith('__'):
                # Create property
                prop_name = key[1:]
                new_namespace[prop_name] = property(
                    lambda self, k=key: getattr(self, k),
                    lambda self, val, k=key: setattr(self, k, val)
                )
            new_namespace[key] = value
        return super().__new__(cls, name, bases, new_namespace)

class MyClass(metaclass=AutoProperty):
    def __init__(self):
        self._value = 0

obj = MyClass()
obj.value = 42
print(obj.value)  # 42
```

### Pattern 3: Method Wrapper Metaclass

```python
class LoggedMethods(type):
    def __new__(cls, name, bases, namespace):
        # Wrap all methods with logging
        for key, value in namespace.items():
            if callable(value) and not key.startswith('__'):
                def make_wrapper(func):
                    def wrapper(self, *args, **kwargs):
                        print(f"Calling {name}.{func.__name__}")
                        return func(self, *args, **kwargs)
                    return wrapper
                namespace[key] = make_wrapper(value)
        return super().__new__(cls, name, bases, namespace)

class MyClass(metaclass=LoggedMethods):
    def method1(self):
        return "Method 1"
    
    def method2(self):
        return "Method 2"

obj = MyClass()
obj.method1()  # Calling MyClass.method1
obj.method2()  # Calling MyClass.method2
```

### Pattern 4: Registry Metaclass

```python
class Registry(type):
    registry = {}
    
    def __new__(cls, name, bases, namespace):
        new_class = super().__new__(cls, name, bases, namespace)
        # Register if it has a 'key' attribute
        if hasattr(new_class, 'key'):
            cls.registry[new_class.key] = new_class
        return new_class
    
    @classmethod
    def get(cls, key):
        return cls.registry.get(key)

class Plugin1(metaclass=Registry):
    key = 'plugin1'
    pass

class Plugin2(metaclass=Registry):
    key = 'plugin2'
    pass

print(Registry.registry)  # {'plugin1': <class '__main__.Plugin1'>, 'plugin2': <class '__main__.Plugin2'>}
plugin = Registry.get('plugin1')
print(plugin)  # <class '__main__.Plugin1'>
```

### Pattern 5: Enforce Interface Metaclass

```python
class Interface(type):
    def __new__(cls, name, bases, namespace):
        # Check if all abstract methods are implemented
        if bases:  # Not a base class
            abstract_methods = set()
            for base in bases:
                if hasattr(base, '__abstractmethods__'):
                    abstract_methods.update(base.__abstractmethods__)
            
            implemented = set(namespace.keys())
            missing = abstract_methods - implemented
            if missing:
                raise TypeError(
                    f"{name} must implement {missing}"
                )
        return super().__new__(cls, name, bases, namespace)

from abc import ABC, abstractmethod

class Base(ABC, metaclass=Interface):
    @abstractmethod
    def method(self):
        pass

class Valid(Base):
    def method(self):
        return "Implemented"

# class Invalid(Base):
#     pass  # TypeError: Invalid must implement {'method'}
```

---

## Understanding `__call__` in Metaclasses

The `__call__` method of a metaclass is called when you instantiate a class:

```python
class MyMeta(type):
    def __call__(cls, *args, **kwargs):
        print(f"Instantiating {cls.__name__}")
        instance = super().__call__(*args, **kwargs)
        print(f"Created instance: {instance}")
        return instance

class MyClass(metaclass=MyMeta):
    def __init__(self, value):
        self.value = value

obj = MyClass(42)
# Output:
# Instantiating MyClass
# Created instance: <__main__.MyClass object at 0x...>
```

### Custom Instance Creation

```python
class CustomInstance(type):
    def __call__(cls, *args, **kwargs):
        # Custom instance creation
        if hasattr(cls, '_create_instance'):
            return cls._create_instance(*args, **kwargs)
        return super().__call__(*args, **kwargs)

class MyClass(metaclass=CustomInstance):
    @classmethod
    def _create_instance(cls, value):
        instance = object.__new__(cls)
        instance.value = value * 2  # Custom initialization
        return instance

obj = MyClass(21)
print(obj.value)  # 42
```

---

## Metaclass Inheritance

### Metaclass Inheritance Rules

When a class inherits from multiple classes with different metaclasses, Python tries to find a compatible metaclass:

```python
class Meta1(type):
    pass

class Meta2(type):
    pass

class Base1(metaclass=Meta1):
    pass

class Base2(metaclass=Meta2):
    pass

# This will fail - incompatible metaclasses
# class Derived(Base1, Base2):
#     pass  # TypeError: metaclass conflict
```

### Creating Compatible Metaclasses

```python
class Meta1(type):
    pass

class Meta2(type):
    pass

# Create a compatible metaclass
class CompatibleMeta(Meta1, Meta2):
    pass

class Base1(metaclass=Meta1):
    pass

class Base2(metaclass=Meta2):
    pass

# This works with compatible metaclass
class Derived(Base1, Base2, metaclass=CompatibleMeta):
    pass
```

---

## When to Use Metaclasses

### Good Use Cases

1. **Framework Development**: Creating frameworks that need to modify class behavior
2. **API Generation**: Automatically generating APIs from class definitions
3. **Validation**: Validating class definitions at creation time
4. **Registration**: Automatically registering classes
5. **ORM Systems**: Object-relational mapping systems

### When NOT to Use Metaclasses

1. **Simple Problems**: Don't use metaclasses for simple problems
2. **First Solution**: Try other solutions first (decorators, inheritance)
3. **Readability**: If it makes code harder to understand
4. **Over-engineering**: Don't over-engineer simple solutions

### Alternatives to Metaclasses

Before using metaclasses, consider:
- **Decorators**: For modifying functions/classes
- **Inheritance**: For sharing behavior
- **Composition**: For combining functionality
- **Descriptors**: For attribute control

---

## Practical Examples

### Example 1: ORM-like System

```python
class ModelMeta(type):
    def __new__(cls, name, bases, namespace):
        # Collect field definitions
        fields = {}
        for key, value in namespace.items():
            if isinstance(value, Field):
                fields[key] = value
        
        namespace['_fields'] = fields
        return super().__new__(cls, name, bases, namespace)

class Field:
    def __init__(self, field_type):
        self.field_type = field_type

class Model(metaclass=ModelMeta):
    def __init__(self, **kwargs):
        for key, value in kwargs.items():
            if key in self._fields:
                setattr(self, key, value)

class User(Model):
    name = Field(str)
    age = Field(int)

user = User(name="Alice", age=25)
print(user.name, user.age)  # Alice 25
```

### Example 2: API Route Registration

```python
class RouteMeta(type):
    routes = []
    
    def __new__(cls, name, bases, namespace):
        new_class = super().__new__(cls, name, bases, namespace)
        # Register routes
        for key, value in namespace.items():
            if hasattr(value, '_route'):
                cls.routes.append((value._route, new_class, value))
        return new_class

def route(path):
    def decorator(func):
        func._route = path
        return func
    return decorator

class APIHandler(metaclass=RouteMeta):
    @route('/users')
    def get_users(self):
        return "Users"
    
    @route('/posts')
    def get_posts(self):
        return "Posts"

print(RouteMeta.routes)
# [('/users', <class '__main__.APIHandler'>, <function ...>), ...]
```

---

## Common Mistakes and Pitfalls

### 1. Forgetting to Call super()

```python
# WRONG: Doesn't call super()
class BadMeta(type):
    def __new__(cls, name, bases, namespace):
        return type(name, bases, namespace)  # Wrong!

# CORRECT: Call super()
class GoodMeta(type):
    def __new__(cls, name, bases, namespace):
        return super().__new__(cls, name, bases, namespace)
```

### 2. Modifying namespace Incorrectly

```python
# WRONG: Modifying during iteration
class BadMeta(type):
    def __new__(cls, name, bases, namespace):
        for key in namespace:
            namespace[key] = "modified"  # Can cause issues
        return super().__new__(cls, name, bases, namespace)

# CORRECT: Create new namespace
class GoodMeta(type):
    def __new__(cls, name, bases, namespace):
        new_namespace = dict(namespace)
        for key, value in new_namespace.items():
            # Modify safely
            pass
        return super().__new__(cls, name, bases, new_namespace)
```

### 3. Metaclass Conflicts

```python
# WRONG: Incompatible metaclasses
class Meta1(type):
    pass

class Meta2(type):
    pass

class Base1(metaclass=Meta1):
    pass

class Base2(metaclass=Meta2):
    pass

# class Derived(Base1, Base2):
#     pass  # TypeError: metaclass conflict

# CORRECT: Create compatible metaclass
class CompatibleMeta(Meta1, Meta2):
    pass

class Derived(Base1, Base2, metaclass=CompatibleMeta):
    pass
```

---

## Best Practices

### 1. Use Metaclasses Sparingly

Only use metaclasses when necessary. Consider alternatives first.

### 2. Document Your Metaclasses

```python
class MyMeta(type):
    """Metaclass that does something.
    
    This metaclass modifies class creation to add
    specific behavior to all classes.
    """
    def __new__(cls, name, bases, namespace):
        # Implementation
        pass
```

### 3. Keep Metaclasses Simple

```python
# Good: Simple and focused
class SimpleMeta(type):
    def __new__(cls, name, bases, namespace):
        namespace['meta_attr'] = 'value'
        return super().__new__(cls, name, bases, namespace)

# Avoid: Too complex
class ComplexMeta(type):
    # Too many responsibilities
    pass
```

### 4. Test Metaclasses Thoroughly

```python
# Test metaclass behavior
def test_metaclass():
    class TestClass(metaclass=MyMeta):
        pass
    
    assert hasattr(TestClass, 'expected_attr')
    # More tests...
```

### 5. Consider Readability

If a metaclass makes code harder to understand, consider alternatives.

---

## Practice Exercise

### Exercise: Metaclasses

**Objective**: Create a Python program that demonstrates metaclasses.

**Instructions**:

1. Create a file called `metaclasses_practice.py`

2. Write a program that:
   - Creates custom metaclasses
   - Uses `type()` to create classes
   - Demonstrates metaclass patterns
   - Shows practical applications
   - Explores advanced patterns

3. Your program should include:
   - Basic metaclass implementation
   - Modifying class namespace
   - Adding methods to classes
   - Validating class definitions
   - Registry pattern
   - Singleton pattern
   - Real-world examples

**Example Solution**:

```python
"""
Metaclasses Practice
This program demonstrates metaclasses in Python.
"""

print("=" * 60)
print("METACLASSES PRACTICE")
print("=" * 60)
print()

# 1. Understanding type()
print("1. UNDERSTANDING type()")
print("-" * 60)

# Traditional class
class TraditionalClass:
    x = 1

# Equivalent using type()
TypeClass = type('TypeClass', (), {'x': 1})

print(f"Traditional: {TraditionalClass.x}")
print(f"Type: {TypeClass.x}")
print()

# 2. Basic metaclass
print("2. BASIC METACLASS")
print("-" * 60)

class MyMeta(type):
    def __new__(cls, name, bases, namespace):
        print(f"Creating class {name}")
        return super().__new__(cls, name, bases, namespace)
    
    def __init__(cls, name, bases, namespace):
        print(f"Initializing class {name}")
        super().__init__(name, bases, namespace)

class MyClass(metaclass=MyMeta):
    pass
print()

# 3. Modifying namespace
print("3. MODIFYING NAMESPACE")
print("-" * 60)

class AddAttribute(type):
    def __new__(cls, name, bases, namespace):
        namespace['created_by'] = 'AddAttribute'
        return super().__new__(cls, name, bases, namespace)

class MyClass(metaclass=AddAttribute):
    pass

print(f"Attribute: {MyClass.created_by}")
print()

# 4. Adding methods
print("4. ADDING METHODS")
print("-" * 60)

class AddMethod(type):
    def __new__(cls, name, bases, namespace):
        def meta_method(self):
            return f"Method added to {name}"
        namespace['meta_method'] = meta_method
        return super().__new__(cls, name, bases, namespace)

class MyClass(metaclass=AddMethod):
    pass

obj = MyClass()
print(obj.meta_method())
print()

# 5. Validating class definition
print("5. VALIDATING CLASS DEFINITION")
print("-" * 60)

class ValidateAttributes(type):
    required = ['name', 'value']
    
    def __new__(cls, name, bases, namespace):
        for attr in cls.required:
            if attr not in namespace:
                raise TypeError(f"{name} must define {attr}")
        return super().__new__(cls, name, bases, namespace)

class ValidClass(metaclass=ValidateAttributes):
    name = "Test"
    value = 42

print(f"Valid class: {ValidClass.name}, {ValidClass.value}")
print()

# 6. Registry pattern
print("6. REGISTRY PATTERN")
print("-" * 60)

class Registry(type):
    registry = {}
    
    def __new__(cls, name, bases, namespace):
        new_class = super().__new__(cls, name, bases, namespace)
        cls.registry[name] = new_class
        return new_class

class Plugin1(metaclass=Registry):
    pass

class Plugin2(metaclass=Registry):
    pass

print(f"Registry: {list(Registry.registry.keys())}")
print()

# 7. Singleton pattern
print("7. SINGLETON PATTERN")
print("-" * 60)

class Singleton(type):
    _instances = {}
    
    def __call__(cls, *args, **kwargs):
        if cls not in cls._instances:
            cls._instances[cls] = super().__call__(*args, **kwargs)
        return cls._instances[cls]

class MyClass(metaclass=Singleton):
    def __init__(self, value):
        self.value = value

obj1 = MyClass(1)
obj2 = MyClass(2)
print(f"Same instance: {obj1 is obj2}")
print(f"Value: {obj1.value}")
print()

# 8. __call__ in metaclass
print("8. __call__ IN METACLASS")
print("-" * 60)

class CallMeta(type):
    def __call__(cls, *args, **kwargs):
        print(f"Instantiating {cls.__name__}")
        return super().__call__(*args, **kwargs)

class MyClass(metaclass=CallMeta):
    def __init__(self, value):
        self.value = value

obj = MyClass(42)
print(f"Value: {obj.value}")
print()

# 9. Auto-property pattern
print("9. AUTO-PROPERTY PATTERN")
print("-" * 60)

class AutoProperty(type):
    def __new__(cls, name, bases, namespace):
        new_namespace = dict(namespace)
        for key, value in namespace.items():
            if key.startswith('_') and not key.startswith('__'):
                prop_name = key[1:]
                new_namespace[prop_name] = property(
                    lambda self, k=key: getattr(self, k, None),
                    lambda self, val, k=key: setattr(self, k, val)
                )
        return super().__new__(cls, name, bases, new_namespace)

class MyClass(metaclass=AutoProperty):
    def __init__(self):
        self._value = 0

obj = MyClass()
obj.value = 42
print(f"Value: {obj.value}")
print()

# 10. Real-world: Model system
print("10. REAL-WORLD: MODEL SYSTEM")
print("-" * 60)

class Field:
    def __init__(self, field_type):
        self.field_type = field_type

class ModelMeta(type):
    def __new__(cls, name, bases, namespace):
        fields = {}
        for key, value in namespace.items():
            if isinstance(value, Field):
                fields[key] = value
        namespace['_fields'] = fields
        return super().__new__(cls, name, bases, namespace)

class Model(metaclass=ModelMeta):
    def __init__(self, **kwargs):
        for key, value in kwargs.items():
            if key in self._fields:
                setattr(self, key, value)

class User(Model):
    name = Field(str)
    age = Field(int)

user = User(name="Alice", age=25)
print(f"User: {user.name}, {user.age}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
METACLASSES PRACTICE
============================================================

1. UNDERSTANDING type()
------------------------------------------------------------
Traditional: 1
Type: 1

[... rest of output ...]
```

**Challenge** (Optional):
- Create a metaclass that automatically generates getter/setter methods
- Build a metaclass that enforces method naming conventions
- Implement a metaclass that tracks all instances of a class
- Create a metaclass that generates REST API endpoints from class methods

---

## Key Takeaways

1. **Metaclasses** - classes whose instances are classes
2. **type()** - can create classes dynamically
3. **__new__** - called to create the class object
4. **__init__** - called after class is created
5. **__call__** - called when instantiating a class
6. **Namespace** - dictionary containing class attributes
7. **Class creation** - controlled by metaclass
8. **Inheritance** - metaclasses can be inherited
9. **Use sparingly** - consider alternatives first
10. **Powerful** - enable advanced patterns
11. **Framework building** - useful for frameworks
12. **Validation** - validate at class creation time
13. **Registration** - automatically register classes
14. **Best practices** - document, keep simple, test
15. **Alternatives** - decorators, inheritance, composition

---

## Quiz: Metaclasses

Test your understanding with these questions:

1. **What is a metaclass?**
   - A) A class method
   - B) A class whose instances are classes
   - C) A type
   - D) A function

2. **What does type() do when called with 3 arguments?**
   - A) Returns the type of an object
   - B) Creates a new class
   - C) Creates an instance
   - D) Nothing

3. **What method is called to create a class?**
   - A) `__init__`
   - B) `__new__`
   - C) `__call__`
   - D) `__create__`

4. **What is the default metaclass?**
   - A) object
   - B) type
   - C) class
   - D) None

5. **When is __call__ called in a metaclass?**
   - A) When creating the class
   - B) When instantiating the class
   - C) When calling a method
   - D) Never

6. **What is the namespace parameter?**
   - A) A string
   - B) A dictionary of class attributes
   - C) A list
   - D) A tuple

7. **When should you use metaclasses?**
   - A) Always
   - B) For simple problems
   - C) For framework development
   - D) Never

8. **What happens with incompatible metaclasses?**
   - A) Python combines them
   - B) TypeError: metaclass conflict
   - C) Works normally
   - D) Warning

9. **What is an alternative to metaclasses?**
   - A) Decorators
   - B) Inheritance
   - C) Composition
   - D) All of the above

10. **What does super() do in a metaclass?**
    - A) Calls parent class method
    - B) Calls type methods
    - C) Creates instance
    - D) Nothing

**Answers**:
1. B) A class whose instances are classes (metaclass definition)
2. B) Creates a new class (type() with 3 arguments)
3. B) `__new__` (method called to create class)
4. B) type (default metaclass)
5. B) When instantiating the class (__call__ timing)
6. B) A dictionary of class attributes (namespace parameter)
7. C) For framework development (when to use metaclasses)
8. B) TypeError: metaclass conflict (incompatible metaclasses)
9. D) All of the above (alternatives to metaclasses)
10. B) Calls type methods (super() in metaclass)

---

## Next Steps

Excellent work! You've mastered metaclasses. You now understand:
- What metaclasses are
- How type() creates classes
- How to create custom metaclasses
- When to use metaclasses

**What's Next?**
- Module 16: Concurrency and Parallelism
- Learn about threading
- Understand multiprocessing
- Explore async programming

---

## Additional Resources

- **Metaclasses**: [docs.python.org/3/reference/datamodel.html#metaclasses](https://docs.python.org/3/reference/datamodel.html#metaclasses)
- **type()**: [docs.python.org/3/library/functions.html#type](https://docs.python.org/3/library/functions.html#type)
- **PEP 3115**: [peps.python.org/pep-3115/](https://peps.python.org/pep-3115/) (Metaclasses in Python 3000)

---

*Lesson completed! You're ready to move on to the next module.*

