# Lesson 8.6: Multiple Inheritance and Mixins

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand multiple inheritance in Python
- Use Method Resolution Order (MRO) to understand method lookup
- Implement mixins pattern for code reuse
- Understand diamond problem and how Python handles it
- Use `super()` with multiple inheritance
- Inspect MRO using `__mro__` and `mro()`
- Apply mixins effectively
- Understand when to use multiple inheritance vs composition
- Avoid common pitfalls with multiple inheritance

---

## Introduction to Multiple Inheritance

**Multiple inheritance** allows a class to inherit from more than one parent class. Python supports multiple inheritance, which can be powerful but requires careful design.

### Single vs Multiple Inheritance

```python
# Single inheritance
class Animal:
    pass

class Dog(Animal):
    pass

# Multiple inheritance
class Flyable:
    def fly(self):
        return "Flying!"

class Swimmable:
    def swim(self):
        return "Swimming!"

class Duck(Animal, Flyable, Swimmable):
    pass

duck = Duck()
print(duck.fly())   # Output: Flying!
print(duck.swim())  # Output: Swimming!
```

### Basic Multiple Inheritance

```python
class A:
    def method(self):
        return "Method from A"

class B:
    def method(self):
        return "Method from B"

class C(A, B):
    pass

obj = C()
print(obj.method())  # Output: Method from A (first parent)
```

---

## Method Resolution Order (MRO)

**Method Resolution Order (MRO)** determines the order in which Python searches for methods in inheritance hierarchies.

### Understanding MRO

```python
class A:
    def method(self):
        return "A"

class B(A):
    def method(self):
        return "B"

class C(A):
    def method(self):
        return "C"

class D(B, C):
    pass

obj = D()
print(obj.method())  # Which method is called?
```

### Inspecting MRO

```python
class A:
    pass

class B(A):
    pass

class C(A):
    pass

class D(B, C):
    pass

# View MRO
print(D.__mro__)
# Output: (<class '__main__.D'>, <class '__main__.B'>, <class '__main__.C'>, <class '__main__.A'>, <class 'object'>)

print(D.mro())
# Same output as above
```

### MRO Example

```python
class A:
    def method(self):
        return "A"

class B(A):
    def method(self):
        return "B"

class C(A):
    def method(self):
        return "C"

class D(B, C):
    pass

# MRO: D -> B -> C -> A -> object
print(D.__mro__)
# Output: (<class '__main__.D'>, <class '__main__.B'>, <class '__main__.C'>, <class '__main__.A'>, <class 'object'>)

obj = D()
print(obj.method())  # Output: B (first in MRO after D)
```

### MRO with `super()`

```python
class A:
    def method(self):
        return "A"

class B(A):
    def method(self):
        return f"B -> {super().method()}"

class C(A):
    def method(self):
        return f"C -> {super().method()}"

class D(B, C):
    def method(self):
        return f"D -> {super().method()}"

obj = D()
print(obj.method())
# Output: D -> B -> C -> A
# MRO: D -> B -> C -> A
```

---

## The Diamond Problem

The **diamond problem** occurs when a class inherits from two classes that both inherit from the same base class.

### Diamond Problem Example

```python
class A:
    def method(self):
        return "A"

class B(A):
    def method(self):
        return "B"

class C(A):
    def method(self):
        return "C"

class D(B, C):  # Diamond: D -> B -> A <- C
    pass

# Python's MRO handles this
print(D.__mro__)
# Output: (<class '__main__.D'>, <class '__main__.B'>, <class '__main__.C'>, <class '__main__.A'>, <class 'object'>)

obj = D()
print(obj.method())  # Output: B (B comes before C in MRO)
```

### How Python Solves It

Python uses **C3 Linearization** algorithm for MRO, which ensures:
1. **Monotonicity**: If A comes before B in MRO of C, then A comes before B in MRO of any subclass of C
2. **Local precedence**: Subclasses come before their parents
3. **No duplicates**: Each class appears only once

---

## Multiple Inheritance Examples

### Example 1: Multiple Behaviors

```python
class Flyable:
    def fly(self):
        return "Flying high!"

class Swimmable:
    def swim(self):
        return "Swimming deep!"

class Walkable:
    def walk(self):
        return "Walking on land!"

class Duck(Flyable, Swimmable, Walkable):
    def __init__(self, name):
        self.name = name

duck = Duck("Donald")
print(f"{duck.name} can:")
print(duck.fly())    # Output: Flying high!
print(duck.swim())   # Output: Swimming deep!
print(duck.walk())   # Output: Walking on land!
```

### Example 2: Combining Functionality

```python
class Logger:
    def log(self, message):
        print(f"LOG: {message}")

class TimestampMixin:
    def get_timestamp(self):
        from datetime import datetime
        return datetime.now().isoformat()

class TimestampedLogger(Logger, TimestampMixin):
    def log(self, message):
        timestamp = self.get_timestamp()
        super().log(f"[{timestamp}] {message}")

logger = TimestampedLogger()
logger.log("Application started")
# Output: LOG: [2024-03-15T10:30:45.123456] Application started
```

### Example 3: Method Override in Multiple Inheritance

```python
class A:
    def method(self):
        return "A"

class B(A):
    def method(self):
        return "B"

class C(A):
    def method(self):
        return "C"

class D(B, C):
    def method(self):
        return f"D -> {super().method()}"

obj = D()
print(obj.method())  # Output: D -> B
# MRO: D -> B -> C -> A
# super() in D calls B.method()
# super() in B would call C.method() (next in MRO after B)
```

---

## Mixins Pattern

**Mixins** are classes designed to be inherited alongside other classes to add functionality. They're not meant to be instantiated alone.

### Mixin Characteristics

1. **Not meant to be instantiated** directly
2. **Provide specific functionality** to other classes
3. **Usually don't have `__init__`** or call `super().__init__()`
4. **Composable** - can be mixed with other classes

### Basic Mixin

```python
class JSONMixin:
    """Mixin to add JSON serialization."""
    def to_json(self):
        import json
        return json.dumps(self.__dict__)

class XMLMixin:
    """Mixin to add XML serialization."""
    def to_xml(self):
        # Simplified XML conversion
        attrs = " ".join(f'{k}="{v}"' for k, v in self.__dict__.items())
        return f"<{self.__class__.__name__} {attrs}/>"

class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age

class PersonWithJSON(Person, JSONMixin):
    pass

class PersonWithBoth(Person, JSONMixin, XMLMixin):
    pass

person1 = PersonWithJSON("Alice", 30)
print(person1.to_json())  # Output: {"name": "Alice", "age": 30}

person2 = PersonWithBoth("Bob", 25)
print(person2.to_json())  # Output: {"name": "Bob", "age": 25}
print(person2.to_xml())   # Output: <PersonWithBoth name="Bob" age="25"/>
```

### Mixin with Methods

```python
class TimestampMixin:
    def get_timestamp(self):
        from datetime import datetime
        return datetime.now().isoformat()

class LoggableMixin:
    def log(self, message):
        print(f"[{self.get_timestamp()}] {message}")

class SaveableMixin:
    def save(self):
        print(f"Saving {self.__class__.__name__}...")

class Document(TimestampMixin, LoggableMixin, SaveableMixin):
    def __init__(self, title):
        self.title = title
    
    def create(self):
        self.log(f"Creating document: {self.title}")
        self.save()

doc = Document("Report")
doc.create()
# Output:
# [2024-03-15T10:30:45.123456] Creating document: Report
# Saving Document...
```

### Mixin Best Practices

```python
# Good Mixin: Provides functionality, no __init__
class SerializableMixin:
    def serialize(self):
        return str(self.__dict__)

# Good Mixin: Can work with any class
class PrintableMixin:
    def __str__(self):
        return f"{self.__class__.__name__}({', '.join(f'{k}={v}' for k, v in self.__dict__.items())})"

# Avoid: Mixin with __init__ that doesn't call super()
class BadMixin:
    def __init__(self):
        self.value = 10  # Problem: doesn't call super().__init__()

# Better: Mixin that handles __init__ properly
class GoodMixin:
    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)  # Pass through to next in MRO
        self.mixin_value = 10
```

---

## Using `super()` with Multiple Inheritance

### `super()` in Multiple Inheritance

```python
class A:
    def __init__(self):
        print("A.__init__")
        self.a = "a"

class B(A):
    def __init__(self):
        print("B.__init__")
        super().__init__()
        self.b = "b"

class C(A):
    def __init__(self):
        print("C.__init__")
        super().__init__()
        self.c = "c"

class D(B, C):
    def __init__(self):
        print("D.__init__")
        super().__init__()
        self.d = "d"

obj = D()
# Output:
# D.__init__
# B.__init__
# C.__init__
# A.__init__

print(obj.__dict__)
# Output: {'a': 'a', 'c': 'c', 'b': 'b', 'd': 'd'}
```

### `super()` Chain

```python
class A:
    def method(self):
        return "A"

class B(A):
    def method(self):
        return f"B -> {super().method()}"

class C(A):
    def method(self):
        return f"C -> {super().method()}"

class D(B, C):
    def method(self):
        return f"D -> {super().method()}"

obj = D()
print(obj.method())
# Output: D -> B -> C -> A
# MRO: D -> B -> C -> A
```

---

## Practical Examples

### Example 1: Multiple Inheritance for Features

```python
class Readable:
    def read(self):
        return "Reading..."

class Writable:
    def write(self, data):
        return f"Writing: {data}"

class Executable:
    def execute(self):
        return "Executing..."

class File(Readable, Writable):
    def __init__(self, name):
        self.name = name

class Script(Readable, Writable, Executable):
    def __init__(self, name):
        self.name = name

file = File("document.txt")
print(file.read())   # Output: Reading...
print(file.write("content"))  # Output: Writing: content

script = Script("script.py")
print(script.read())     # Output: Reading...
print(script.write("code"))  # Output: Writing: code
print(script.execute())  # Output: Executing...
```

### Example 2: Mixins for Serialization

```python
class JSONSerializableMixin:
    def to_json(self):
        import json
        return json.dumps(self.__dict__, indent=2)

class XMLSerializableMixin:
    def to_xml(self):
        lines = [f"<{self.__class__.__name__}>"]
        for key, value in self.__dict__.items():
            lines.append(f"  <{key}>{value}</{key}>")
        lines.append(f"</{self.__class__.__name__}>")
        return "\n".join(lines)

class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age

class PersonJSON(Person, JSONSerializableMixin):
    pass

class PersonBoth(Person, JSONSerializableMixin, XMLSerializableMixin):
    pass

person1 = PersonJSON("Alice", 30)
print(person1.to_json())

person2 = PersonBoth("Bob", 25)
print(person2.to_json())
print(person2.to_xml())
```

### Example 3: Mixins for Logging and Caching

```python
class LoggableMixin:
    def log(self, message):
        print(f"[{self.__class__.__name__}] {message}")

class CacheableMixin:
    _cache = {}
    
    def cache_get(self, key):
        return self._cache.get(key)
    
    def cache_set(self, key, value):
        self._cache[key] = value
        self.log(f"Cached: {key} = {value}")

class DataProcessor(LoggableMixin, CacheableMixin):
    def __init__(self, name):
        self.name = name
    
    def process(self, data):
        cached = self.cache_get(data)
        if cached:
            self.log(f"Using cached result for {data}")
            return cached
        
        result = f"Processed: {data}"
        self.cache_set(data, result)
        return result

processor = DataProcessor("Processor1")
print(processor.process("data1"))
print(processor.process("data1"))  # Uses cache
```

---

## Common Mistakes and Pitfalls

### 1. Mixin Order Matters

```python
class A:
    def method(self):
        return "A"

class Mixin:
    def method(self):
        return "Mixin"

class B(A, Mixin):  # A comes first
    pass

class C(Mixin, A):  # Mixin comes first
    pass

print(B().method())  # Output: A
print(C().method())  # Output: Mixin
```

### 2. Not Calling `super()` in `__init__`

```python
# WRONG: Doesn't call super()
class A:
    def __init__(self):
        self.a = "a"

class B(A):
    def __init__(self):
        self.b = "b"  # A.__init__ never called!

# CORRECT: Calls super()
class A:
    def __init__(self):
        self.a = "a"

class B(A):
    def __init__(self):
        super().__init__()
        self.b = "b"
```

### 3. Conflicting Method Names

```python
class A:
    def method(self):
        return "A"

class B:
    def method(self):
        return "B"

class C(A, B):
    pass

# Which method is called? Depends on MRO
print(C().method())  # Output: A (A comes first)
print(C.__mro__)     # Check MRO to understand
```

### 4. Mixin with Required Methods

```python
# Problem: Mixin expects method that might not exist
class SerializeMixin:
    def serialize(self):
        return self.to_dict()  # Assumes to_dict() exists

# Solution: Check or provide default
class SerializeMixin:
    def serialize(self):
        if hasattr(self, 'to_dict'):
            return self.to_dict()
        return self.__dict__
```

---

## Best Practices

### 1. Use Mixins for Specific Functionality

```python
# Good: Mixin provides specific feature
class TimestampMixin:
    def get_timestamp(self):
        from datetime import datetime
        return datetime.now().isoformat()

# Avoid: Mixin that does too much
class BadMixin:
    def do_everything(self):
        # Too broad
        pass
```

### 2. Keep Mixins Simple

```python
# Good: Simple, focused mixin
class LoggableMixin:
    def log(self, message):
        print(f"LOG: {message}")

# Avoid: Complex mixin with dependencies
class ComplexMixin:
    def __init__(self):
        # Too complex
        pass
```

### 3. Document Mixin Requirements

```python
class SerializeMixin:
    """
    Mixin for serialization.
    
    Requires: Class must have __dict__ or implement to_dict()
    """
    def serialize(self):
        if hasattr(self, 'to_dict'):
            return self.to_dict()
        return self.__dict__
```

### 4. Use Composition When Appropriate

```python
# Sometimes composition is better than multiple inheritance
class Logger:
    def log(self, message):
        print(f"LOG: {message}")

class Person:
    def __init__(self, name):
        self.name = name
        self.logger = Logger()  # Composition
    
    def introduce(self):
        self.logger.log(f"Hi, I'm {self.name}")
```

---

## When to Use Multiple Inheritance

### ✅ Good Use Cases

1. **Mixins**: Adding specific functionality
2. **Interface implementation**: Multiple interfaces
3. **Feature composition**: Combining independent features

### ❌ Avoid When

1. **Complex hierarchies**: Can become hard to understand
2. **Tight coupling**: Classes depend on each other
3. **Composition works better**: Sometimes composition is clearer

---

## Practice Exercise

### Exercise: Multiple Inheritance

**Objective**: Create a Python program that demonstrates multiple inheritance and mixins.

**Instructions**:

1. Create a file called `multiple_inheritance_practice.py`

2. Write a program that:
   - Uses multiple inheritance
   - Implements mixins
   - Demonstrates MRO
   - Uses `super()` with multiple inheritance

3. Your program should include:
   - Classes with multiple inheritance
   - Mixin classes
   - MRO inspection
   - Examples of `super()` usage

**Example Solution**:

```python
"""
Multiple Inheritance and Mixins Practice
This program demonstrates multiple inheritance and mixins.
"""

print("=" * 60)
print("MULTIPLE INHERITANCE AND MIXINS PRACTICE")
print("=" * 60)
print()

# 1. Basic Multiple Inheritance
print("1. BASIC MULTIPLE INHERITANCE")
print("-" * 60)
class A:
    def method(self):
        return "A"

class B:
    def method(self):
        return "B"

class C(A, B):
    pass

obj = C()
print(f"C().method() = {obj.method()}")  # Output: A (A comes first)
print(f"MRO: {C.__mro__}")
print()

# 2. MRO Inspection
print("2. MRO INSPECTION")
print("-" * 60)
class A:
    pass

class B(A):
    pass

class C(A):
    pass

class D(B, C):
    pass

print("D.__mro__:")
for cls in D.__mro__:
    print(f"  {cls}")
print()

# 3. Diamond Problem
print("3. DIAMOND PROBLEM")
print("-" * 60)
class A:
    def method(self):
        return "A"

class B(A):
    def method(self):
        return "B"

class C(A):
    def method(self):
        return "C"

class D(B, C):
    pass

obj = D()
print(f"D().method() = {obj.method()}")  # Output: B
print("MRO handles diamond problem:")
for cls in D.__mro__:
    print(f"  {cls}")
print()

# 4. super() with Multiple Inheritance
print("4. SUPER() WITH MULTIPLE INHERITANCE")
print("-" * 60)
class A:
    def method(self):
        return "A"

class B(A):
    def method(self):
        return f"B -> {super().method()}"

class C(A):
    def method(self):
        return f"C -> {super().method()}"

class D(B, C):
    def method(self):
        return f"D -> {super().method()}"

obj = D()
print(f"D().method() = {obj.method()}")
# Output: D -> B -> C -> A
print()

# 5. Multiple Behaviors
print("5. MULTIPLE BEHAVIORS")
print("-" * 60)
class Flyable:
    def fly(self):
        return "Flying!"

class Swimmable:
    def swim(self):
        return "Swimming!"

class Walkable:
    def walk(self):
        return "Walking!"

class Duck(Flyable, Swimmable, Walkable):
    def __init__(self, name):
        self.name = name

duck = Duck("Donald")
print(f"{duck.name} can:")
print(f"  {duck.fly()}")
print(f"  {duck.swim()}")
print(f"  {duck.walk()}")
print()

# 6. Basic Mixin
print("6. BASIC MIXIN")
print("-" * 60)
class JSONMixin:
    def to_json(self):
        import json
        return json.dumps(self.__dict__)

class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age

class PersonWithJSON(Person, JSONMixin):
    pass

person = PersonWithJSON("Alice", 30)
print(person.to_json())
print()

# 7. Multiple Mixins
print("7. MULTIPLE MIXINS")
print("-" * 60)
class JSONMixin:
    def to_json(self):
        import json
        return json.dumps(self.__dict__)

class XMLMixin:
    def to_xml(self):
        attrs = " ".join(f'{k}="{v}"' for k, v in self.__dict__.items())
        return f"<{self.__class__.__name__} {attrs}/>"

class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age

class PersonWithBoth(Person, JSONMixin, XMLMixin):
    pass

person = PersonWithBoth("Bob", 25)
print(person.to_json())
print(person.to_xml())
print()

# 8. Mixin with Methods
print("8. MIXIN WITH METHODS")
print("-" * 60)
class TimestampMixin:
    def get_timestamp(self):
        from datetime import datetime
        return datetime.now().strftime("%Y-%m-%d %H:%M:%S")

class LoggableMixin:
    def log(self, message):
        timestamp = self.get_timestamp()
        print(f"[{timestamp}] {message}")

class Document(TimestampMixin, LoggableMixin):
    def __init__(self, title):
        self.title = title
    
    def create(self):
        self.log(f"Creating: {self.title}")

doc = Document("Report")
doc.create()
print()

# 9. super() in __init__
print("9. SUPER() IN __INIT__")
print("-" * 60)
class A:
    def __init__(self):
        print("A.__init__")
        self.a = "a"

class B(A):
    def __init__(self):
        print("B.__init__")
        super().__init__()
        self.b = "b"

class C(A):
    def __init__(self):
        print("C.__init__")
        super().__init__()
        self.c = "c"

class D(B, C):
    def __init__(self):
        print("D.__init__")
        super().__init__()
        self.d = "d"

obj = D()
print(f"Attributes: {obj.__dict__}")
print()

# 10. Mixin Order Matters
print("10. MIXIN ORDER MATTERS")
print("-" * 60)
class A:
    def method(self):
        return "A"

class Mixin:
    def method(self):
        return "Mixin"

class B1(A, Mixin):  # A first
    pass

class B2(Mixin, A):  # Mixin first
    pass

print(f"B1().method() = {B1().method()}")  # Output: A
print(f"B2().method() = {B2().method()}")  # Output: Mixin
print()

# 11. Complete Example: File System
print("11. COMPLETE EXAMPLE: FILE SYSTEM")
print("-" * 60)
class Readable:
    def read(self):
        return "Reading..."

class Writable:
    def write(self, data):
        return f"Writing: {data}"

class Executable:
    def execute(self):
        return "Executing..."

class File(Readable, Writable):
    def __init__(self, name):
        self.name = name

class Script(Readable, Writable, Executable):
    def __init__(self, name):
        self.name = name

file = File("document.txt")
print(f"{file.name}: {file.read()}, {file.write('content')}")

script = Script("script.py")
print(f"{script.name}: {script.read()}, {script.write('code')}, {script.execute()}")
print()

# 12. Serialization Mixins
print("12. SERIALIZATION MIXINS")
print("-" * 60)
class JSONSerializableMixin:
    def to_json(self):
        import json
        return json.dumps(self.__dict__)

class XMLSerializableMixin:
    def to_xml(self):
        lines = [f"<{self.__class__.__name__}>"]
        for key, value in self.__dict__.items():
            lines.append(f"  <{key}>{value}</{key}>")
        lines.append(f"</{self.__class__.__name__}>")
        return "\n".join(lines)

class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age

class PersonJSON(Person, JSONSerializableMixin):
    pass

class PersonBoth(Person, JSONSerializableMixin, XMLSerializableMixin):
    pass

person1 = PersonJSON("Alice", 30)
print("PersonJSON:")
print(person1.to_json())

person2 = PersonBoth("Bob", 25)
print("\nPersonBoth:")
print(person2.to_json())
print(person2.to_xml())
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
MULTIPLE INHERITANCE AND MIXINS PRACTICE
============================================================

1. BASIC MULTIPLE INHERITANCE
------------------------------------------------------------
C().method() = A
MRO: (<class '__main__.C'>, <class '__main__.A'>, <class '__main__.B'>, <class 'object'>)

[... rest of output ...]
```

**Challenge** (Optional):
- Create a plugin system using mixins
- Build a serialization framework with multiple formats
- Design a logging system with multiple backends
- Create a feature flag system using mixins

---

## Key Takeaways

1. **Multiple inheritance** allows a class to inherit from multiple parents
2. **MRO (Method Resolution Order)** determines method lookup order
3. **C3 Linearization** algorithm ensures consistent MRO
4. **Diamond problem** is handled automatically by Python's MRO
5. **Mixins** are classes designed to add functionality to other classes
6. **Mixins should be simple** and focused on specific functionality
7. **`super()`** follows MRO, not just parent class
8. **Inspect MRO** using `__mro__` or `mro()` method
9. **Mixin order matters** - earlier classes in inheritance list have priority
10. **Use composition** when multiple inheritance becomes too complex
11. **Document mixin requirements** - what methods/attributes they expect
12. **Avoid deep inheritance hierarchies** - keep it simple

---

## Quiz: Advanced Inheritance

Test your understanding with these questions:

1. **What is multiple inheritance?**
   - A) One class inheriting from one parent
   - B) One class inheriting from multiple parents
   - C) Multiple classes inheriting from one parent
   - D) No inheritance

2. **What does MRO stand for?**
   - A) Method Return Order
   - B) Method Resolution Order
   - C) Multiple Resolution Order
   - D) Method Reference Order

3. **How do you inspect MRO?**
   - A) `class.__mro__`
   - B) `class.mro()`
   - C) Both A and B
   - D) `class.inheritance()`

4. **What is a mixin?**
   - A) A class meant to be instantiated alone
   - B) A class designed to add functionality to other classes
   - C) A method
   - D) An attribute

5. **What algorithm does Python use for MRO?**
   - A) Depth-first search
   - B) Breadth-first search
   - C) C3 Linearization
   - D) Random order

6. **What is the diamond problem?**
   - A) Class inherits from two classes that inherit from same base
   - B) Too many classes
   - C) Circular inheritance
   - D) No inheritance

7. **What does `super()` follow?**
   - A) Parent class only
   - B) MRO
   - C) First parent
   - D) Last parent

8. **When should you use mixins?**
   - A) Always
   - B) For adding specific functionality
   - C) Never
   - D) Only for inheritance

9. **Does mixin order matter?**
   - A) No
   - B) Yes, earlier classes have priority
   - C) Only sometimes
   - D) Depends on Python version

10. **When might composition be better than multiple inheritance?**
    - A) Never
    - B) When inheritance becomes too complex
    - C) Always
    - D) Only for mixins

**Answers**:
1. B) One class inheriting from multiple parents (multiple inheritance definition)
2. B) Method Resolution Order (determines method lookup)
3. C) Both A and B (both `__mro__` and `mro()` work)
4. B) A class designed to add functionality to other classes (mixin purpose)
5. C) C3 Linearization (Python's MRO algorithm)
6. A) Class inherits from two classes that inherit from same base (diamond problem)
7. B) MRO (super() follows Method Resolution Order)
8. B) For adding specific functionality (mixins are for features)
9. B) Yes, earlier classes have priority (order matters in MRO)
10. B) When inheritance becomes too complex (composition can be simpler)

---

## Next Steps

Excellent work! You've mastered multiple inheritance and mixins. You now understand:
- How multiple inheritance works in Python
- How MRO determines method lookup
- How to use mixins effectively
- How `super()` works with multiple inheritance

**What's Next?**
- Module 9: File Handling
- Learn about reading and writing files
- Understand file operations
- Explore different file formats

---

## Additional Resources

- **Multiple Inheritance**: [docs.python.org/3/tutorial/classes.html#multiple-inheritance](https://docs.python.org/3/tutorial/classes.html#multiple-inheritance)
- **MRO**: [docs.python.org/3/howto/mro.html](https://docs.python.org/3/howto/mro.html)
- **Mixins**: Research mixin pattern and best practices

---

*Lesson completed! You're ready to move on to the next module.*

