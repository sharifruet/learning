# Lesson 8.5: Encapsulation and Polymorphism

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand encapsulation and its benefits
- Use private attributes and methods in Python
- Implement property decorators for controlled access
- Understand polymorphism concepts
- Apply duck typing in Python
- Use getters and setters appropriately
- Implement data validation with properties
- Understand the difference between encapsulation and abstraction
- Apply OOP principles effectively

---

## Introduction to Encapsulation

**Encapsulation** is the bundling of data and methods that operate on that data within a single unit (class), while restricting access to some components.

### Key Concepts

1. **Data Hiding**: Hide internal implementation details
2. **Controlled Access**: Control how data is accessed and modified
3. **Interface**: Provide a clean interface to interact with objects
4. **Protection**: Protect data from invalid modifications

### Benefits of Encapsulation

- **Data Protection**: Prevent invalid data states
- **Flexibility**: Can change implementation without affecting users
- **Maintainability**: Easier to maintain and debug
- **Abstraction**: Hide complexity from users

---

## Private Attributes and Methods

Python uses naming conventions to indicate privacy, though it doesn't enforce true privacy.

### Single Underscore (Protected)

A single underscore `_` indicates a "protected" attribute (convention only):

```python
class BankAccount:
    def __init__(self, owner, balance=0):
        self.owner = owner
        self._balance = balance  # Protected (convention)
    
    def get_balance(self):
        return self._balance

account = BankAccount("Alice", 1000)
print(account._balance)  # Still accessible, but convention says "don't access directly"
```

### Double Underscore (Name Mangling)

Double underscore `__` triggers **name mangling**, making attributes harder to access:

```python
class BankAccount:
    def __init__(self, owner, balance=0):
        self.owner = owner
        self.__balance = balance  # Name mangling
    
    def get_balance(self):
        return self.__balance

account = BankAccount("Alice", 1000)
print(account.get_balance())  # Output: 1000
# print(account.__balance)  # AttributeError: 'BankAccount' object has no attribute '__balance'
# Access via name mangling: account._BankAccount__balance (not recommended)
```

### Private Methods

```python
class BankAccount:
    def __init__(self, owner, balance=0):
        self.owner = owner
        self.__balance = balance
    
    def __validate_amount(self, amount):  # Private method
        return amount > 0
    
    def deposit(self, amount):
        if self.__validate_amount(amount):
            self.__balance += amount
            return True
        return False
    
    def get_balance(self):
        return self.__balance

account = BankAccount("Alice", 1000)
account.deposit(500)
print(account.get_balance())  # Output: 1500
# account.__validate_amount(100)  # AttributeError
```

### Example: Complete Encapsulation

```python
class Temperature:
    def __init__(self, celsius):
        self.__celsius = celsius  # Private attribute
    
    def get_celsius(self):
        return self.__celsius
    
    def set_celsius(self, value):
        if value < -273.15:  # Absolute zero
            raise ValueError("Temperature cannot be below absolute zero")
        self.__celsius = value
    
    def get_fahrenheit(self):
        return self.__celsius * 9/5 + 32
    
    def set_fahrenheit(self, value):
        celsius = (value - 32) * 5/9
        self.set_celsius(celsius)

temp = Temperature(25)
print(f"Celsius: {temp.get_celsius()}")      # Output: Celsius: 25
print(f"Fahrenheit: {temp.get_fahrenheit()}")  # Output: Fahrenheit: 77.0

temp.set_fahrenheit(86)
print(f"Celsius: {temp.get_celsius()}")      # Output: Celsius: 30.0
```

---

## Property Decorators

**Properties** provide a cleaner way to access and modify attributes with validation.

### Basic Property

```python
class Circle:
    def __init__(self, radius):
        self._radius = radius  # Protected attribute
    
    @property
    def radius(self):
        """Get the radius."""
        return self._radius
    
    @property
    def area(self):
        """Calculate and return the area."""
        return 3.14159 * self._radius ** 2

circle = Circle(5)
print(circle.radius)  # Output: 5 (accessed like attribute)
print(circle.area)    # Output: 78.53975 (computed property)
```

### Property with Setter

```python
class Circle:
    def __init__(self, radius):
        self._radius = radius
    
    @property
    def radius(self):
        return self._radius
    
    @radius.setter
    def radius(self, value):
        if value < 0:
            raise ValueError("Radius cannot be negative")
        self._radius = value
    
    @property
    def area(self):
        return 3.14159 * self._radius ** 2

circle = Circle(5)
print(circle.radius)  # Output: 5

circle.radius = 10  # Uses setter
print(circle.radius)  # Output: 10
print(circle.area)    # Output: 314.159

# circle.radius = -5  # ValueError: Radius cannot be negative
```

### Property with Deleter

```python
class Person:
    def __init__(self, name):
        self._name = name
    
    @property
    def name(self):
        return self._name
    
    @name.setter
    def name(self, value):
        if not value or not isinstance(value, str):
            raise ValueError("Name must be a non-empty string")
        self._name = value
    
    @name.deleter
    def name(self):
        raise AttributeError("Cannot delete name attribute")

person = Person("Alice")
print(person.name)  # Output: Alice

person.name = "Bob"
print(person.name)  # Output: Bob

# del person.name  # AttributeError: Cannot delete name attribute
```

### Read-Only Property

```python
class Rectangle:
    def __init__(self, width, height):
        self.width = width
        self.height = height
    
    @property
    def area(self):
        """Read-only property - no setter defined."""
        return self.width * self.height

rect = Rectangle(5, 10)
print(rect.area)  # Output: 50

# rect.area = 100  # AttributeError: can't set attribute
```

### Property with Validation

```python
class BankAccount:
    def __init__(self, owner, balance=0):
        self.owner = owner
        self._balance = balance
    
    @property
    def balance(self):
        return self._balance
    
    @balance.setter
    def balance(self, value):
        if value < 0:
            raise ValueError("Balance cannot be negative")
        self._balance = value

account = BankAccount("Alice", 1000)
print(account.balance)  # Output: 1000

account.balance = 1500
print(account.balance)  # Output: 1500

# account.balance = -100  # ValueError: Balance cannot be negative
```

### Property vs Getter/Setter Methods

```python
# Using getter/setter methods (old way)
class Temperature:
    def __init__(self, celsius):
        self._celsius = celsius
    
    def get_celsius(self):
        return self._celsius
    
    def set_celsius(self, value):
        if value < -273.15:
            raise ValueError("Too cold")
        self._celsius = value

temp = Temperature(25)
temp.set_celsius(30)
print(temp.get_celsius())

# Using properties (modern way)
class Temperature:
    def __init__(self, celsius):
        self._celsius = celsius
    
    @property
    def celsius(self):
        return self._celsius
    
    @celsius.setter
    def celsius(self, value):
        if value < -273.15:
            raise ValueError("Too cold")
        self._celsius = value

temp = Temperature(25)
temp.celsius = 30  # More Pythonic
print(temp.celsius)
```

---

## Polymorphism Concepts

**Polymorphism** means "many forms" - the ability to use a single interface for different types.

### Types of Polymorphism

1. **Duck Typing**: "If it walks like a duck and quacks like a duck, it's a duck"
2. **Method Overriding**: Subclasses override parent methods
3. **Operator Overloading**: Same operator works with different types

### Duck Typing

Python uses **duck typing** - if an object has the required methods, it can be used:

```python
class Dog:
    def speak(self):
        return "Woof!"

class Cat:
    def speak(self):
        return "Meow!"

class Duck:
    def speak(self):
        return "Quack!"

def make_sound(animal):
    # Works with any object that has a speak() method
    print(animal.speak())

dog = Dog()
cat = Cat()
duck = Duck()

make_sound(dog)   # Output: Woof!
make_sound(cat)   # Output: Meow!
make_sound(duck)  # Output: Quack!
```

### Polymorphism with Inheritance

```python
class Animal:
    def speak(self):
        raise NotImplementedError("Subclass must implement speak()")

class Dog(Animal):
    def speak(self):
        return "Woof!"

class Cat(Animal):
    def speak(self):
        return "Meow!"

class Duck(Animal):
    def speak(self):
        return "Quack!"

def make_sound(animal):
    print(animal.speak())

animals = [Dog(), Cat(), Duck()]
for animal in animals:
    make_sound(animal)
# Output:
# Woof!
# Meow!
# Quack!
```

### Polymorphism with Different Interfaces

```python
class Rectangle:
    def __init__(self, width, height):
        self.width = width
        self.height = height
    
    def area(self):
        return self.width * self.height

class Circle:
    def __init__(self, radius):
        self.radius = radius
    
    def area(self):
        return 3.14159 * self.radius ** 2

def print_area(shape):
    # Works with any object that has an area() method
    print(f"Area: {shape.area()}")

rect = Rectangle(5, 10)
circle = Circle(5)

print_area(rect)    # Output: Area: 50
print_area(circle)  # Output: Area: 78.53975
```

---

## Duck Typing in Detail

**Duck typing** is Python's approach to polymorphism - focus on what an object can do, not what it is.

### Example: File-like Objects

```python
class StringIO:
    """File-like object that works with strings."""
    def __init__(self, content):
        self.content = content
        self.position = 0
    
    def read(self, size=-1):
        if size == -1:
            result = self.content[self.position:]
            self.position = len(self.content)
        else:
            result = self.content[self.position:self.position + size]
            self.position += size
        return result
    
    def write(self, text):
        self.content += text
        return len(text)

def process_file(file_obj):
    # Works with any object that has read() method
    content = file_obj.read()
    print(f"Content: {content}")

# Works with actual file
with open("test.txt", "w") as f:
    f.write("Hello World")

with open("test.txt", "r") as f:
    process_file(f)  # Output: Content: Hello World

# Works with StringIO
string_file = StringIO("Hello World")
process_file(string_file)  # Output: Content: Hello World
```

### Example: Iterable Objects

```python
class Countdown:
    def __init__(self, start):
        self.current = start
    
    def __iter__(self):
        return self
    
    def __next__(self):
        if self.current <= 0:
            raise StopIteration
        self.current -= 1
        return self.current + 1

def print_items(iterable):
    # Works with any iterable object
    for item in iterable:
        print(item, end=" ")
    print()

# Works with list
print_items([1, 2, 3])  # Output: 1 2 3

# Works with Countdown
print_items(Countdown(5))  # Output: 5 4 3 2 1

# Works with string
print_items("ABC")  # Output: A B C
```

### Duck Typing vs Type Checking

```python
# Duck typing approach (Pythonic)
def process_data(data):
    # Just use the methods you need
    return data.upper()  # Works if object has upper() method

# Type checking approach (less Pythonic)
def process_data(data):
    if isinstance(data, str):
        return data.upper()
    else:
        raise TypeError("Expected string")

# Duck typing is more flexible
class MyString:
    def upper(self):
        return "CUSTOM UPPER"

print(process_data("hello"))      # Works
print(process_data(MyString()))   # Also works with duck typing!
```

---

## Practical Examples

### Example 1: Encapsulated Bank Account

```python
class BankAccount:
    def __init__(self, owner, initial_balance=0):
        self.owner = owner
        self._balance = initial_balance  # Protected
        self._transaction_count = 0      # Protected
    
    @property
    def balance(self):
        return self._balance
    
    @property
    def transaction_count(self):
        return self._transaction_count
    
    def deposit(self, amount):
        if amount <= 0:
            raise ValueError("Amount must be positive")
        self._balance += amount
        self._transaction_count += 1
        return self._balance
    
    def withdraw(self, amount):
        if amount <= 0:
            raise ValueError("Amount must be positive")
        if amount > self._balance:
            raise ValueError("Insufficient funds")
        self._balance -= amount
        self._transaction_count += 1
        return self._balance

account = BankAccount("Alice", 1000)
account.deposit(500)
print(f"Balance: ${account.balance}")
print(f"Transactions: {account.transaction_count}")
```

### Example 2: Polymorphic Shape Classes

```python
class Shape:
    def area(self):
        raise NotImplementedError("Subclass must implement area()")
    
    def perimeter(self):
        raise NotImplementedError("Subclass must implement perimeter()")

class Rectangle(Shape):
    def __init__(self, width, height):
        self.width = width
        self.height = height
    
    def area(self):
        return self.width * self.height
    
    def perimeter(self):
        return 2 * (self.width + self.height)

class Circle(Shape):
    def __init__(self, radius):
        self.radius = radius
    
    def area(self):
        return 3.14159 * self.radius ** 2
    
    def perimeter(self):
        return 2 * 3.14159 * self.radius

def print_shape_info(shape):
    # Polymorphic - works with any Shape subclass
    print(f"Area: {shape.area():.2f}")
    print(f"Perimeter: {shape.perimeter():.2f}")

shapes = [
    Rectangle(5, 10),
    Circle(5),
    Rectangle(3, 7)
]

for shape in shapes:
    print_shape_info(shape)
    print()
```

### Example 3: Temperature with Properties

```python
class Temperature:
    def __init__(self, celsius=0):
        self._celsius = celsius
    
    @property
    def celsius(self):
        return self._celsius
    
    @celsius.setter
    def celsius(self, value):
        if value < -273.15:
            raise ValueError("Temperature cannot be below absolute zero")
        self._celsius = value
    
    @property
    def fahrenheit(self):
        return self._celsius * 9/5 + 32
    
    @fahrenheit.setter
    def fahrenheit(self, value):
        self.celsius = (value - 32) * 5/9
    
    @property
    def kelvin(self):
        return self._celsius + 273.15
    
    @kelvin.setter
    def kelvin(self, value):
        if value < 0:
            raise ValueError("Temperature cannot be below absolute zero")
        self.celsius = value - 273.15

temp = Temperature(25)
print(f"Celsius: {temp.celsius}")
print(f"Fahrenheit: {temp.fahrenheit}")
print(f"Kelvin: {temp.kelvin}")

temp.fahrenheit = 86
print(f"Celsius: {temp.celsius}")
```

---

## Common Mistakes and Pitfalls

### 1. Thinking Double Underscore is Truly Private

```python
class BankAccount:
    def __init__(self, balance):
        self.__balance = balance  # Name mangling, not truly private

account = BankAccount(1000)
# Still accessible via name mangling (not recommended)
# print(account._BankAccount__balance)
```

**Best Practice**: Use single underscore for "protected" and rely on convention.

### 2. Overusing Private Attributes

```python
# WRONG: Over-encapsulation
class Person:
    def __init__(self, name):
        self.__name = name
    
    def get_name(self):
        return self.__name
    
    def set_name(self, name):
        self.__name = name

# BETTER: Use properties or just public attributes if no validation needed
class Person:
    def __init__(self, name):
        self.name = name  # Simple case - no need for encapsulation
```

### 3. Not Using Properties When Appropriate

```python
# WRONG: Getter/setter methods when property would be better
class Circle:
    def __init__(self, radius):
        self._radius = radius
    
    def get_radius(self):
        return self._radius
    
    def set_radius(self, value):
        self._radius = value

# BETTER: Use properties
class Circle:
    def __init__(self, radius):
        self._radius = radius
    
    @property
    def radius(self):
        return self._radius
    
    @radius.setter
    def radius(self, value):
        self._radius = value
```

---

## Best Practices

### 1. Use Single Underscore for Protected

```python
class BankAccount:
    def __init__(self, balance):
        self._balance = balance  # Protected by convention
```

### 2. Use Properties for Validation

```python
class BankAccount:
    def __init__(self, balance):
        self._balance = balance
    
    @property
    def balance(self):
        return self._balance
    
    @balance.setter
    def balance(self, value):
        if value < 0:
            raise ValueError("Balance cannot be negative")
        self._balance = value
```

### 3. Embrace Duck Typing

```python
# Good: Duck typing
def process_data(obj):
    return obj.process()  # Works with any object that has process()

# Avoid: Excessive type checking
def process_data(obj):
    if isinstance(obj, MyClass):
        return obj.process()
    else:
        raise TypeError("Wrong type")
```

### 4. Use Properties for Computed Values

```python
class Rectangle:
    def __init__(self, width, height):
        self.width = width
        self.height = height
    
    @property
    def area(self):
        return self.width * self.height  # Computed property
```

---

## Practice Exercise

### Exercise: Encapsulation

**Objective**: Create a Python program that demonstrates encapsulation and polymorphism.

**Instructions**:

1. Create a file called `encapsulation_practice.py`

2. Write a program that:
   - Uses private/protected attributes
   - Implements properties with validation
   - Demonstrates polymorphism with duck typing
   - Shows encapsulation benefits

3. Your program should include:
   - A class with private attributes and properties
   - A class demonstrating polymorphism
   - Examples of duck typing
   - Validation using properties

**Example Solution**:

```python
"""
Encapsulation and Polymorphism Practice
This program demonstrates encapsulation and polymorphism concepts.
"""

print("=" * 60)
print("ENCAPSULATION AND POLYMORPHISM PRACTICE")
print("=" * 60)
print()

# 1. Private Attributes
print("1. PRIVATE ATTRIBUTES")
print("-" * 60)
class BankAccount:
    def __init__(self, owner, balance=0):
        self.owner = owner
        self.__balance = balance  # Private (name mangling)
    
    def get_balance(self):
        return self.__balance
    
    def deposit(self, amount):
        if amount > 0:
            self.__balance += amount
            return self.__balance
        return False

account = BankAccount("Alice", 1000)
print(f"Owner: {account.owner}")
print(f"Balance: ${account.get_balance()}")
account.deposit(500)
print(f"After deposit: ${account.get_balance()}")
print()

# 2. Protected Attributes
print("2. PROTECTED ATTRIBUTES")
print("-" * 60)
class Person:
    def __init__(self, name, age):
        self.name = name
        self._age = age  # Protected (convention)
    
    def get_age(self):
        return self._age

person = Person("Alice", 30)
print(f"Name: {person.name}")
print(f"Age: {person.get_age()}")
print()

# 3. Basic Property
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
print(f"Area: {circle.area:.2f}")
print()

# 4. Property with Setter
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
            raise ValueError("Radius cannot be negative")
        self._radius = value
    
    @property
    def area(self):
        return 3.14159 * self._radius ** 2

circle = Circle(5)
print(f"Radius: {circle.radius}")
circle.radius = 10
print(f"New radius: {circle.radius}")
print(f"New area: {circle.area:.2f}")
print()

# 5. Property with Validation
print("5. PROPERTY WITH VALIDATION")
print("-" * 60)
class BankAccount:
    def __init__(self, owner, balance=0):
        self.owner = owner
        self._balance = balance
    
    @property
    def balance(self):
        return self._balance
    
    @balance.setter
    def balance(self, value):
        if value < 0:
            raise ValueError("Balance cannot be negative")
        self._balance = value

account = BankAccount("Alice", 1000)
print(f"Balance: ${account.balance}")
account.balance = 1500
print(f"New balance: ${account.balance}")
print()

# 6. Temperature with Multiple Properties
print("6. TEMPERATURE WITH MULTIPLE PROPERTIES")
print("-" * 60)
class Temperature:
    def __init__(self, celsius=0):
        self._celsius = celsius
    
    @property
    def celsius(self):
        return self._celsius
    
    @celsius.setter
    def celsius(self, value):
        if value < -273.15:
            raise ValueError("Temperature cannot be below absolute zero")
        self._celsius = value
    
    @property
    def fahrenheit(self):
        return self._celsius * 9/5 + 32
    
    @fahrenheit.setter
    def fahrenheit(self, value):
        self.celsius = (value - 32) * 5/9

temp = Temperature(25)
print(f"Celsius: {temp.celsius}°C")
print(f"Fahrenheit: {temp.fahrenheit}°F")

temp.fahrenheit = 86
print(f"After setting to 86°F:")
print(f"Celsius: {temp.celsius}°C")
print()

# 7. Duck Typing
print("7. DUCK TYPING")
print("-" * 60)
class Dog:
    def speak(self):
        return "Woof!"

class Cat:
    def speak(self):
        return "Meow!"

class Duck:
    def speak(self):
        return "Quack!"

def make_sound(animal):
    # Works with any object that has speak() method
    print(animal.speak())

animals = [Dog(), Cat(), Duck()]
for animal in animals:
    make_sound(animal)
print()

# 8. Polymorphism with Inheritance
print("8. POLYMORPHISM WITH INHERITANCE")
print("-" * 60)
class Shape:
    def area(self):
        raise NotImplementedError("Subclass must implement area()")

class Rectangle(Shape):
    def __init__(self, width, height):
        self.width = width
        self.height = height
    
    def area(self):
        return self.width * self.height

class Circle(Shape):
    def __init__(self, radius):
        self.radius = radius
    
    def area(self):
        return 3.14159 * self.radius ** 2

def print_area(shape):
    print(f"Area: {shape.area():.2f}")

shapes = [Rectangle(5, 10), Circle(5), Rectangle(3, 7)]
for shape in shapes:
    print_area(shape)
print()

# 9. Polymorphism with Different Interfaces
print("9. POLYMORPHISM WITH DIFFERENT INTERFACES")
print("-" * 60)
class Rectangle:
    def __init__(self, width, height):
        self.width = width
        self.height = height
    
    def area(self):
        return self.width * self.height

class Circle:
    def __init__(self, radius):
        self.radius = radius
    
    def area(self):
        return 3.14159 * self.radius ** 2

def calculate_total_area(shapes):
    total = 0
    for shape in shapes:
        total += shape.area()  # Duck typing
    return total

shapes = [Rectangle(5, 10), Circle(5), Rectangle(3, 7)]
total = calculate_total_area(shapes)
print(f"Total area: {total:.2f}")
print()

# 10. Complete Encapsulated Class
print("10. COMPLETE ENCAPSULATED CLASS")
print("-" * 60)
class BankAccount:
    def __init__(self, owner, initial_balance=0):
        self.owner = owner
        self._balance = initial_balance
        self._transaction_count = 0
    
    @property
    def balance(self):
        return self._balance
    
    @property
    def transaction_count(self):
        return self._transaction_count
    
    def deposit(self, amount):
        if amount <= 0:
            raise ValueError("Amount must be positive")
        self._balance += amount
        self._transaction_count += 1
        return self._balance
    
    def withdraw(self, amount):
        if amount <= 0:
            raise ValueError("Amount must be positive")
        if amount > self._balance:
            raise ValueError("Insufficient funds")
        self._balance -= amount
        self._transaction_count += 1
        return self._balance

account = BankAccount("Alice", 1000)
account.deposit(500)
account.withdraw(200)
print(f"Owner: {account.owner}")
print(f"Balance: ${account.balance}")
print(f"Transactions: {account.transaction_count}")
print()

# 11. Property with Deleter
print("11. PROPERTY WITH DELETER")
print("-" * 60)
class Person:
    def __init__(self, name):
        self._name = name
    
    @property
    def name(self):
        return self._name
    
    @name.setter
    def name(self, value):
        if not value or not isinstance(value, str):
            raise ValueError("Name must be a non-empty string")
        self._name = value
    
    @name.deleter
    def name(self):
        raise AttributeError("Cannot delete name attribute")

person = Person("Alice")
print(f"Name: {person.name}")
person.name = "Bob"
print(f"New name: {person.name}")
print()

# 12. Read-Only Property
print("12. READ-ONLY PROPERTY")
print("-" * 60)
class Rectangle:
    def __init__(self, width, height):
        self.width = width
        self.height = height
    
    @property
    def area(self):
        """Read-only property - no setter defined."""
        return self.width * self.height

rect = Rectangle(5, 10)
print(f"Width: {rect.width}, Height: {rect.height}")
print(f"Area: {rect.area}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
ENCAPSULATION AND POLYMORPHISM PRACTICE
============================================================

1. PRIVATE ATTRIBUTES
------------------------------------------------------------
Owner: Alice
Balance: $1000
After deposit: $1500

[... rest of output ...]
```

**Challenge** (Optional):
- Create a `Student` class with encapsulated grades
- Build a polymorphic `Payment` system with different payment methods
- Create a `FileHandler` class demonstrating duck typing
- Design a `Config` class with validated properties

---

## Key Takeaways

1. **Encapsulation** bundles data and methods, restricting access
2. **Single underscore `_`** indicates protected (convention)
3. **Double underscore `__`** triggers name mangling (harder to access)
4. **Properties** provide clean attribute access with validation
5. **`@property`** creates getter, `@property.setter` creates setter
6. **Polymorphism** allows different types to be used interchangeably
7. **Duck typing** focuses on what objects can do, not what they are
8. **Use properties** instead of getter/setter methods when possible
9. **Embrace duck typing** - it's Pythonic and flexible
10. **Private attributes** are a convention, not enforced by Python
11. **Properties enable validation** and computed values
12. **Polymorphism works** with inheritance and duck typing

---

## Quiz: OOP Concepts

Test your understanding with these questions:

1. **What does encapsulation do?**
   - A) Hides implementation details
   - B) Makes code faster
   - C) Removes methods
   - D) Changes syntax

2. **What does a single underscore `_` indicate?**
   - A) Private attribute
   - B) Protected attribute (convention)
   - C) Public attribute
   - D) Method

3. **What does double underscore `__` do?**
   - A) Makes attribute truly private
   - B) Triggers name mangling
   - C) Makes attribute public
   - D) Creates a method

4. **What decorator creates a property?**
   - A) `@getter`
   - B) `@property`
   - C) `@attribute`
   - D) `@prop`

5. **What is polymorphism?**
   - A) Many classes
   - B) Ability to use different types interchangeably
   - C) One class
   - D) No classes

6. **What is duck typing?**
   - A) Type checking
   - B) Focus on what object can do, not what it is
   - C) Only works with ducks
   - D) Requires inheritance

7. **What does `@property.setter` do?**
   - A) Creates a getter
   - B) Creates a setter
   - C) Deletes attribute
   - D) Validates type

8. **Can you access `__attribute` from outside the class?**
   - A) Yes, easily
   - B) No, never
   - C) Yes, via name mangling (not recommended)
   - D) Only with special permission

9. **What is the benefit of properties over getter/setter methods?**
   - A) Faster execution
   - B) Cleaner syntax, accessed like attributes
   - C) More methods
   - D) No benefit

10. **When should you use private attributes?**
    - A) Always
    - B) When you need to protect data or hide implementation
    - C) Never
    - D) Only for methods

**Answers**:
1. A) Hides implementation details (encapsulation bundles and protects data)
2. B) Protected attribute (convention - indicates "don't access directly")
3. B) Triggers name mangling (makes attribute harder to access)
4. B) `@property` (decorator for creating properties)
5. B) Ability to use different types interchangeably (polymorphism)
6. B) Focus on what object can do, not what it is (Python's approach)
7. B) Creates a setter (allows setting property values)
8. C) Yes, via name mangling (not recommended, but possible)
9. B) Cleaner syntax, accessed like attributes (more Pythonic)
10. B) When you need to protect data or hide implementation (use when needed)

---

## Next Steps

Excellent work! You've mastered encapsulation and polymorphism. You now understand:
- How to use private and protected attributes
- How to implement properties with validation
- How polymorphism and duck typing work
- When and how to use encapsulation

**What's Next?**
- Lesson 8.6: Multiple Inheritance and Mixins
- Learn about multiple inheritance
- Understand Method Resolution Order (MRO)
- Explore mixins pattern

---

## Additional Resources

- **Property Decorator**: [docs.python.org/3/library/functions.html#property](https://docs.python.org/3/library/functions.html#property)
- **Name Mangling**: [docs.python.org/3/tutorial/classes.html#private-variables](https://docs.python.org/3/tutorial/classes.html#private-variables)
- **Duck Typing**: Research Python's duck typing philosophy

---

*Lesson completed! You're ready to move on to the next lesson.*

