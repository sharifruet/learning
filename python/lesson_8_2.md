# Lesson 8.2: Methods and Attributes

## Learning Objectives

By the end of this lesson, you will be able to:
- Define and use instance methods
- Understand the difference between instance, class, and static methods
- Use class methods with `@classmethod` decorator
- Use static methods with `@staticmethod` decorator
- Work with class attributes vs instance attributes
- Understand method binding and how `self` works
- Use property decorators for attribute access
- Apply different method types appropriately
- Understand when to use each method type

---

## Introduction to Methods

**Methods** are functions that belong to a class. They define the behavior of objects created from that class.

### Types of Methods

1. **Instance Methods**: Work with instance data
2. **Class Methods**: Work with class data
3. **Static Methods**: Don't need class or instance data

---

## Instance Methods

**Instance methods** are the most common type of method. They operate on instance data and always take `self` as the first parameter.

### Basic Instance Method

```python
class Dog:
    def __init__(self, name, age):
        self.name = name
        self.age = age
    
    def bark(self):
        return f"{self.name} says Woof!"
    
    def get_info(self):
        return f"{self.name} is {self.age} years old"

# Create object and use methods
dog = Dog("Buddy", 3)
print(dog.bark())      # Output: Buddy says Woof!
print(dog.get_info())  # Output: Buddy is 3 years old
```

### Understanding `self`

`self` refers to the current instance:

```python
class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age
    
    def introduce(self):
        # self refers to the current Person object
        return f"Hi, I'm {self.name} and I'm {self.age} years old"

person = Person("Alice", 30)
print(person.introduce())  # Output: Hi, I'm Alice and I'm 30 years old

# When you call person.introduce(), Python automatically passes person as self
```

### Methods with Parameters

```python
class BankAccount:
    def __init__(self, owner, balance=0):
        self.owner = owner
        self.balance = balance
    
    def deposit(self, amount):
        self.balance += amount
        return f"Deposited ${amount}. New balance: ${self.balance}"
    
    def withdraw(self, amount):
        if amount <= self.balance:
            self.balance -= amount
            return f"Withdrew ${amount}. New balance: ${self.balance}"
        else:
            return "Insufficient funds"
    
    def get_balance(self):
        return self.balance

# Use methods
account = BankAccount("Alice", 1000)
print(account.deposit(500))   # Output: Deposited $500. New balance: $1500
print(account.withdraw(200))  # Output: Withdrew $200. New balance: $1300
print(account.get_balance())  # Output: 1300
```

### Modifying Instance Attributes

```python
class Car:
    def __init__(self, make, model, year):
        self.make = make
        self.model = model
        self.year = year
        self.mileage = 0
    
    def drive(self, miles):
        self.mileage += miles
        return f"Drove {miles} miles. Total mileage: {self.mileage}"
    
    def update_make(self, new_make):
        old_make = self.make
        self.make = new_make
        return f"Changed make from {old_make} to {new_make}"

car = Car("Toyota", "Camry", 2020)
print(car.drive(100))        # Output: Drove 100 miles. Total mileage: 100
print(car.update_make("Honda"))  # Output: Changed make from Toyota to Honda
```

### Returning Values from Methods

```python
class Rectangle:
    def __init__(self, width, height):
        self.width = width
        self.height = height
    
    def area(self):
        return self.width * self.height
    
    def perimeter(self):
        return 2 * (self.width + self.height)
    
    def is_square(self):
        return self.width == self.height

rect = Rectangle(5, 5)
print(f"Area: {rect.area()}")           # Output: Area: 25
print(f"Perimeter: {rect.perimeter()}") # Output: Perimeter: 20
print(f"Is square: {rect.is_square()}") # Output: Is square: True
```

---

## Class Methods

**Class methods** work with the class itself, not instances. They use the `@classmethod` decorator and take `cls` (class) as the first parameter.

### Basic Class Method

```python
class Dog:
    species = "Canis familiaris"  # Class attribute
    
    def __init__(self, name, age):
        self.name = name
        self.age = age
    
    @classmethod
    def get_species(cls):
        return cls.species
    
    @classmethod
    def create_puppy(cls, name):
        # Create a Dog with age 0
        return cls(name, 0)

# Use class method
print(Dog.get_species())  # Output: Canis familiaris

# Create object using class method
puppy = Dog.create_puppy("Buddy")
print(f"{puppy.name} is {puppy.age} years old")  # Output: Buddy is 0 years old
```

### Alternative Constructors

Class methods are often used to create alternative ways to construct objects:

```python
class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age
    
    @classmethod
    def from_birth_year(cls, name, birth_year):
        # Calculate age from birth year
        current_year = 2024
        age = current_year - birth_year
        return cls(name, age)
    
    @classmethod
    def from_string(cls, person_string):
        # Parse string like "Alice,30"
        name, age = person_string.split(",")
        return cls(name, int(age))

# Different ways to create Person objects
person1 = Person("Alice", 30)
person2 = Person.from_birth_year("Bob", 1995)
person3 = Person.from_string("Charlie,25")

print(f"{person1.name} is {person1.age}")  # Output: Alice is 30
print(f"{person2.name} is {person2.age}")  # Output: Bob is 29
print(f"{person3.name} is {person3.age}")  # Output: Charlie is 25
```

### Class Methods with Class Attributes

```python
class Car:
    total_cars = 0  # Class attribute
    
    def __init__(self, make, model):
        self.make = make
        self.model = model
        Car.total_cars += 1
    
    @classmethod
    def get_total_cars(cls):
        return cls.total_cars
    
    @classmethod
    def reset_count(cls):
        cls.total_cars = 0

# Create cars
car1 = Car("Toyota", "Camry")
car2 = Car("Honda", "Civic")
car3 = Car("Ford", "Focus")

print(Car.get_total_cars())  # Output: 3

Car.reset_count()
print(Car.get_total_cars())  # Output: 0
```

---

## Static Methods

**Static methods** don't need access to the class or instance. They use the `@staticmethod` decorator and don't take `self` or `cls`.

### Basic Static Method

```python
class MathUtils:
    @staticmethod
    def add(a, b):
        return a + b
    
    @staticmethod
    def multiply(a, b):
        return a * b
    
    @staticmethod
    def is_even(number):
        return number % 2 == 0

# Use static methods
print(MathUtils.add(5, 3))        # Output: 8
print(MathUtils.multiply(4, 7))   # Output: 28
print(MathUtils.is_even(10))      # Output: True

# Can also call from instance
utils = MathUtils()
print(utils.add(2, 3))  # Output: 5
```

### When to Use Static Methods

Static methods are useful for utility functions related to the class but don't need instance or class data:

```python
class DateUtils:
    @staticmethod
    def is_valid_date(year, month, day):
        if month < 1 or month > 12:
            return False
        if day < 1 or day > 31:
            return False
        return True
    
    @staticmethod
    def is_leap_year(year):
        return year % 4 == 0 and (year % 100 != 0 or year % 400 == 0)

# Use without creating instance
print(DateUtils.is_valid_date(2024, 3, 15))  # Output: True
print(DateUtils.is_valid_date(2024, 13, 15)) # Output: False
print(DateUtils.is_leap_year(2024))          # Output: True
```

### Static Methods in Classes

```python
class StringProcessor:
    def __init__(self, text):
        self.text = text
    
    def process(self):
        return self.text.upper()
    
    @staticmethod
    def clean_text(text):
        # Utility function that doesn't need instance
        return text.strip().lower()
    
    @staticmethod
    def count_words(text):
        return len(text.split())

# Use static method
cleaned = StringProcessor.clean_text("  Hello World  ")
print(f"'{cleaned}'")  # Output: 'hello world'

word_count = StringProcessor.count_words("Hello world Python")
print(word_count)  # Output: 3

# Also works with instance
processor = StringProcessor("test")
cleaned = processor.clean_text("  Another Text  ")
print(f"'{cleaned}'")  # Output: 'another text'
```

---

## Comparing Method Types

### Summary Table

| Method Type | Decorator | First Parameter | Access To |
|-----------|-----------|---------------|-----------|
| Instance Method | None | `self` | Instance attributes and methods |
| Class Method | `@classmethod` | `cls` | Class attributes and methods |
| Static Method | `@staticmethod` | None | No access to class or instance |

### Example with All Three Types

```python
class MyClass:
    class_var = "Class variable"
    
    def __init__(self, instance_var):
        self.instance_var = instance_var
    
    # Instance method
    def instance_method(self):
        return f"Instance: {self.instance_var}, Class: {MyClass.class_var}"
    
    # Class method
    @classmethod
    def class_method(cls):
        return f"Class variable: {cls.class_var}"
    
    # Static method
    @staticmethod
    def static_method(value):
        return f"Static: {value}"

# Use instance method
obj = MyClass("Instance value")
print(obj.instance_method())  # Output: Instance: Instance value, Class: Class variable

# Use class method
print(MyClass.class_method())  # Output: Class variable: Class variable
print(obj.class_method())       # Also works from instance

# Use static method
print(MyClass.static_method("Test"))  # Output: Static: Test
print(obj.static_method("Test"))      # Also works from instance
```

---

## Class Attributes vs Instance Attributes

### Instance Attributes

Belong to individual objects:

```python
class Dog:
    def __init__(self, name, age):
        self.name = name      # Instance attribute
        self.age = age        # Instance attribute

dog1 = Dog("Buddy", 3)
dog2 = Dog("Max", 5)

print(dog1.name)  # Output: Buddy
print(dog2.name)  # Output: Max (different)
```

### Class Attributes

Shared by all instances:

```python
class Dog:
    species = "Canis familiaris"  # Class attribute
    
    def __init__(self, name, age):
        self.name = name  # Instance attribute
        self.age = age    # Instance attribute

dog1 = Dog("Buddy", 3)
dog2 = Dog("Max", 5)

# Class attribute (same for all)
print(dog1.species)  # Output: Canis familiaris
print(dog2.species)  # Output: Canis familiaris
print(Dog.species)      # Output: Canis familiaris

# Instance attributes (different for each)
print(dog1.name)  # Output: Buddy
print(dog2.name)  # Output: Max
```

### Modifying Class Attributes

```python
class Dog:
    species = "Canis familiaris"
    count = 0  # Class attribute
    
    def __init__(self, name):
        self.name = name
        Dog.count += 1  # Increment class attribute

dog1 = Dog("Buddy")
dog2 = Dog("Max")
dog3 = Dog("Charlie")

print(Dog.count)  # Output: 3
print(dog1.count)  # Output: 3 (accessing class attribute)
print(dog2.count)  # Output: 3

# Modify class attribute
Dog.count = 0
print(dog1.count)  # Output: 0 (all see the change)
```

### Shadowing Class Attributes

```python
class Dog:
    species = "Canis familiaris"  # Class attribute
    
    def __init__(self, name, species=None):
        self.name = name
        if species:
            self.species = species  # Creates instance attribute

dog1 = Dog("Buddy")
dog2 = Dog("Max", "Canis lupus")

print(dog1.species)  # Output: Canis familiaris (class attribute)
print(dog2.species)  # Output: Canis lupus (instance attribute)
print(Dog.species)   # Output: Canis familiaris (unchanged)
```

---

## Properties (Getters and Setters)

Python properties allow you to use methods like attributes, with getters and setters.

### Basic Property

```python
class Circle:
    def __init__(self, radius):
        self._radius = radius  # Private convention
    
    @property
    def radius(self):
        return self._radius
    
    @property
    def area(self):
        return 3.14159 * self._radius ** 2

circle = Circle(5)
print(circle.radius)  # Output: 5 (accessed like attribute)
print(circle.area)     # Output: 78.53975 (computed property)
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

### Computed Properties

```python
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
    
    @property
    def is_square(self):
        return self.width == self.height

rect = Rectangle(5, 5)
print(rect.area)        # Output: 25
print(rect.perimeter)    # Output: 20
print(rect.is_square)    # Output: True

# Properties are read-only by default (no setter)
# rect.area = 30  # AttributeError: can't set attribute
```

---

## Method Chaining

Methods can return `self` to allow chaining:

```python
class Calculator:
    def __init__(self, value=0):
        self.value = value
    
    def add(self, num):
        self.value += num
        return self  # Return self for chaining
    
    def multiply(self, num):
        self.value *= num
        return self
    
    def subtract(self, num):
        self.value -= num
        return self
    
    def get_result(self):
        return self.value

# Chain methods
calc = Calculator(10)
result = calc.add(5).multiply(2).subtract(3).get_result()
print(result)  # Output: 27

# Step by step:
# 10 + 5 = 15
# 15 * 2 = 30
# 30 - 3 = 27
```

---

## Practical Examples

### Example 1: Bank Account with Methods

```python
class BankAccount:
    def __init__(self, owner, balance=0):
        self.owner = owner
        self.balance = balance
        self.transaction_history = []
    
    def deposit(self, amount):
        if amount > 0:
            self.balance += amount
            self.transaction_history.append(f"Deposited ${amount}")
            return True
        return False
    
    def withdraw(self, amount):
        if 0 < amount <= self.balance:
            self.balance -= amount
            self.transaction_history.append(f"Withdrew ${amount}")
            return True
        return False
    
    def get_balance(self):
        return self.balance
    
    def get_history(self):
        return self.transaction_history

account = BankAccount("Alice", 1000)
account.deposit(500)
account.withdraw(200)
print(f"Balance: ${account.get_balance()}")
print(f"History: {account.get_history()}")
```

### Example 2: Student with Class Methods

```python
class Student:
    total_students = 0
    
    def __init__(self, name, student_id):
        self.name = name
        self.student_id = student_id
        self.grades = []
        Student.total_students += 1
    
    def add_grade(self, grade):
        if 0 <= grade <= 100:
            self.grades.append(grade)
    
    def get_average(self):
        if self.grades:
            return sum(self.grades) / len(self.grades)
        return 0
    
    @classmethod
    def get_total_students(cls):
        return cls.total_students
    
    @classmethod
    def from_string(cls, student_string):
        name, student_id = student_string.split(",")
        return cls(name.strip(), student_id.strip())

student1 = Student("Alice", "S001")
student2 = Student.from_string("Bob, S002")

print(Student.get_total_students())  # Output: 2
```

### Example 3: Math Utilities with Static Methods

```python
class MathUtils:
    @staticmethod
    def factorial(n):
        if n <= 1:
            return 1
        result = 1
        for i in range(2, n + 1):
            result *= i
        return result
    
    @staticmethod
    def is_prime(n):
        if n < 2:
            return False
        for i in range(2, int(n ** 0.5) + 1):
            if n % i == 0:
                return False
        return True
    
    @staticmethod
    def gcd(a, b):
        while b:
            a, b = b, a % b
        return a

print(MathUtils.factorial(5))    # Output: 120
print(MathUtils.is_prime(17))    # Output: True
print(MathUtils.gcd(48, 18))     # Output: 6
```

---

## Common Mistakes and Pitfalls

### 1. Forgetting `self` in Instance Methods

```python
# WRONG
class Dog:
    def bark():
        return "Woof!"  # Missing self

# CORRECT
class Dog:
    def bark(self):
        return "Woof!"
```

### 2. Using `self` in Static Methods

```python
# WRONG
class Utils:
    @staticmethod
    def add(self, a, b):  # Don't use self in static methods
        return a + b

# CORRECT
class Utils:
    @staticmethod
    def add(a, b):
        return a + b
```

### 3. Confusing Class and Instance Attributes

```python
class Dog:
    count = 0  # Class attribute
    
    def __init__(self, name):
        self.name = name
        self.count = 1  # Creates instance attribute, shadows class attribute

dog = Dog("Buddy")
print(dog.count)      # Output: 1 (instance attribute)
print(Dog.count)       # Output: 0 (class attribute)
```

### 4. Modifying Mutable Class Attributes

```python
# WRONG: Shared mutable class attribute
class Student:
    courses = []  # Shared by all instances!
    
    def __init__(self, name):
        self.name = name
        self.courses.append("Math")  # All students share same list!

# CORRECT: Instance attribute
class Student:
    def __init__(self, name):
        self.name = name
        self.courses = []  # Each student has own list
        self.courses.append("Math")
```

---

## Best Practices

### 1. Use Instance Methods for Object Behavior

```python
class BankAccount:
    def __init__(self, balance):
        self.balance = balance
    
    def withdraw(self, amount):  # Instance method - uses self
        self.balance -= amount
```

### 2. Use Class Methods for Alternative Constructors

```python
class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age
    
    @classmethod
    def from_birth_year(cls, name, birth_year):
        age = 2024 - birth_year
        return cls(name, age)
```

### 3. Use Static Methods for Utilities

```python
class StringUtils:
    @staticmethod
    def is_palindrome(text):
        return text == text[::-1]
```

### 4. Use Properties for Computed Attributes

```python
class Rectangle:
    def __init__(self, width, height):
        self.width = width
        self.height = height
    
    @property
    def area(self):
        return self.width * self.height
```

---

## Practice Exercise

### Exercise: Methods Practice

**Objective**: Create a Python program that demonstrates different types of methods and their usage.

**Instructions**:

1. Create a file called `methods_practice.py`

2. Write a program that:
   - Defines classes with instance methods
   - Uses class methods for alternative constructors
   - Implements static methods for utilities
   - Demonstrates class vs instance attributes
   - Uses properties for computed values
   - Shows method chaining

3. Your program should include:
   - A class with instance methods
   - A class with class methods
   - A class with static methods
   - A class with properties
   - Examples of method chaining

**Example Solution**:

```python
"""
Methods and Attributes Practice
This program demonstrates different types of methods and their usage.
"""

print("=" * 60)
print("METHODS AND ATTRIBUTES PRACTICE")
print("=" * 60)
print()

# 1. Instance Methods
print("1. INSTANCE METHODS")
print("-" * 60)
class Dog:
    def __init__(self, name, age):
        self.name = name
        self.age = age
    
    def bark(self):
        return f"{self.name} says Woof!"
    
    def get_info(self):
        return f"{self.name} is {self.age} years old"
    
    def have_birthday(self):
        self.age += 1
        return f"{self.name} is now {self.age} years old"

dog = Dog("Buddy", 3)
print(dog.bark())
print(dog.get_info())
print(dog.have_birthday())
print()

# 2. Instance Methods with Parameters
print("2. INSTANCE METHODS WITH PARAMETERS")
print("-" * 60)
class BankAccount:
    def __init__(self, owner, balance=0):
        self.owner = owner
        self.balance = balance
    
    def deposit(self, amount):
        if amount > 0:
            self.balance += amount
            return f"Deposited ${amount}. Balance: ${self.balance}"
        return "Invalid amount"
    
    def withdraw(self, amount):
        if 0 < amount <= self.balance:
            self.balance -= amount
            return f"Withdrew ${amount}. Balance: ${self.balance}"
        return "Insufficient funds"
    
    def get_balance(self):
        return self.balance

account = BankAccount("Alice", 1000)
print(account.deposit(500))
print(account.withdraw(200))
print(f"Final balance: ${account.get_balance()}")
print()

# 3. Class Methods
print("3. CLASS METHODS")
print("-" * 60)
class Person:
    species = "Homo sapiens"
    
    def __init__(self, name, age):
        self.name = name
        self.age = age
    
    @classmethod
    def get_species(cls):
        return cls.species
    
    @classmethod
    def from_birth_year(cls, name, birth_year):
        age = 2024 - birth_year
        return cls(name, age)
    
    @classmethod
    def from_string(cls, person_string):
        name, age = person_string.split(",")
        return cls(name.strip(), int(age.strip()))

print(f"Species: {Person.get_species()}")

person1 = Person("Alice", 30)
person2 = Person.from_birth_year("Bob", 1995)
person3 = Person.from_string("Charlie, 25")

print(f"{person1.name} is {person1.age}")
print(f"{person2.name} is {person2.age}")
print(f"{person3.name} is {person3.age}")
print()

# 4. Class Methods with Class Attributes
print("4. CLASS METHODS WITH CLASS ATTRIBUTES")
print("-" * 60)
class Car:
    total_cars = 0
    
    def __init__(self, make, model):
        self.make = make
        self.model = model
        Car.total_cars += 1
    
    @classmethod
    def get_total_cars(cls):
        return cls.total_cars
    
    @classmethod
    def reset_count(cls):
        cls.total_cars = 0

car1 = Car("Toyota", "Camry")
car2 = Car("Honda", "Civic")
car3 = Car("Ford", "Focus")

print(f"Total cars created: {Car.get_total_cars()}")
Car.reset_count()
print(f"After reset: {Car.get_total_cars()}")
print()

# 5. Static Methods
print("5. STATIC METHODS")
print("-" * 60)
class MathUtils:
    @staticmethod
    def add(a, b):
        return a + b
    
    @staticmethod
    def multiply(a, b):
        return a * b
    
    @staticmethod
    def is_even(number):
        return number % 2 == 0
    
    @staticmethod
    def factorial(n):
        if n <= 1:
            return 1
        result = 1
        for i in range(2, n + 1):
            result *= i
        return result

print(f"5 + 3 = {MathUtils.add(5, 3)}")
print(f"4 * 7 = {MathUtils.multiply(4, 7)}")
print(f"Is 10 even? {MathUtils.is_even(10)}")
print(f"5! = {MathUtils.factorial(5)}")

# Can also call from instance
utils = MathUtils()
print(f"2 + 3 = {utils.add(2, 3)}")
print()

# 6. Static Methods in Classes
print("6. STATIC METHODS IN CLASSES")
print("-" * 60)
class StringProcessor:
    def __init__(self, text):
        self.text = text
    
    def process(self):
        return self.text.upper()
    
    @staticmethod
    def clean_text(text):
        return text.strip().lower()
    
    @staticmethod
    def count_words(text):
        return len(text.split())
    
    @staticmethod
    def is_palindrome(text):
        cleaned = text.lower().replace(" ", "")
        return cleaned == cleaned[::-1]

cleaned = StringProcessor.clean_text("  Hello World  ")
print(f"Cleaned: '{cleaned}'")
print(f"Word count: {StringProcessor.count_words('Hello world Python')}")
print(f"Is 'racecar' palindrome? {StringProcessor.is_palindrome('racecar')}")
print()

# 7. Properties
print("7. PROPERTIES")
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
    
    @property
    def circumference(self):
        return 2 * 3.14159 * self._radius

circle = Circle(5)
print(f"Radius: {circle.radius}")
print(f"Area: {circle.area:.2f}")
print(f"Circumference: {circle.circumference:.2f}")

circle.radius = 10
print(f"New radius: {circle.radius}")
print(f"New area: {circle.area:.2f}")
print()

# 8. Computed Properties
print("8. COMPUTED PROPERTIES")
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
    
    @property
    def is_square(self):
        return self.width == self.height

rect = Rectangle(5, 5)
print(f"Width: {rect.width}, Height: {rect.height}")
print(f"Area: {rect.area}")
print(f"Perimeter: {rect.perimeter}")
print(f"Is square: {rect.is_square}")
print()

# 9. Method Chaining
print("9. METHOD CHAINING")
print("-" * 60)
class Calculator:
    def __init__(self, value=0):
        self.value = value
    
    def add(self, num):
        self.value += num
        return self
    
    def multiply(self, num):
        self.value *= num
        return self
    
    def subtract(self, num):
        self.value -= num
        return self
    
    def divide(self, num):
        if num != 0:
            self.value /= num
        return self
    
    def get_result(self):
        return self.value

calc = Calculator(10)
result = calc.add(5).multiply(2).subtract(3).divide(2).get_result()
print(f"Result: {result}")  # (10 + 5) * 2 - 3) / 2 = 13.5
print()

# 10. Class vs Instance Attributes
print("10. CLASS VS INSTANCE ATTRIBUTES")
print("-" * 60)
class Dog:
    species = "Canis familiaris"  # Class attribute
    count = 0  # Class attribute
    
    def __init__(self, name, age):
        self.name = name  # Instance attribute
        self.age = age    # Instance attribute
        Dog.count += 1
    
    @classmethod
    def get_count(cls):
        return cls.count

dog1 = Dog("Buddy", 3)
dog2 = Dog("Max", 5)
dog3 = Dog("Charlie", 2)

print(f"Class species: {Dog.species}")
print(f"dog1.species: {dog1.species}")
print(f"dog2.species: {dog2.species}")
print(f"Total dogs: {Dog.get_count()}")
print(f"dog1.name: {dog1.name} (instance)")
print(f"dog2.name: {dog2.name} (instance)")
print()

# 11. All Method Types Together
print("11. ALL METHOD TYPES TOGETHER")
print("-" * 60)
class Student:
    total_students = 0  # Class attribute
    
    def __init__(self, name, student_id):
        self.name = name  # Instance attribute
        self.student_id = student_id
        self.grades = []
        Student.total_students += 1
    
    # Instance method
    def add_grade(self, grade):
        if 0 <= grade <= 100:
            self.grades.append(grade)
    
    # Instance method
    def get_average(self):
        if self.grades:
            return sum(self.grades) / len(self.grades)
        return 0
    
    # Class method
    @classmethod
    def get_total_students(cls):
        return cls.total_students
    
    # Class method
    @classmethod
    def from_string(cls, student_string):
        name, student_id = student_string.split(",")
        return cls(name.strip(), student_id.strip())
    
    # Static method
    @staticmethod
    def is_passing_grade(grade):
        return grade >= 60
    
    # Property
    @property
    def grade_count(self):
        return len(self.grades)

student1 = Student("Alice", "S001")
student1.add_grade(85)
student1.add_grade(90)
student1.add_grade(78)

student2 = Student.from_string("Bob, S002")

print(f"Student: {student1.name}")
print(f"Average: {student1.get_average():.2f}")
print(f"Grade count: {student1.grade_count}")
print(f"Is 85 passing? {Student.is_passing_grade(85)}")
print(f"Total students: {Student.get_total_students()}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
METHODS AND ATTRIBUTES PRACTICE
============================================================

1. INSTANCE METHODS
------------------------------------------------------------
Buddy says Woof!
Buddy is 3 years old
Buddy is now 4 years old

[... rest of output ...]
```

**Challenge** (Optional):
- Create a `ShoppingCart` class with methods to add/remove items
- Build a `Time` class with class methods for different time formats
- Create a `Validator` class with static methods for validation
- Design a `Temperature` class with properties for different scales

---

## Key Takeaways

1. **Instance methods** operate on instance data and take `self` as first parameter
2. **Class methods** operate on class data and take `cls` as first parameter, use `@classmethod`
3. **Static methods** don't need class or instance data, use `@staticmethod`
4. **`self`** refers to the current instance in instance methods
5. **`cls`** refers to the class in class methods
6. **Class attributes** are shared by all instances
7. **Instance attributes** belong to individual objects
8. **Properties** allow methods to be accessed like attributes using `@property`
9. **Method chaining** is possible by returning `self` from methods
10. **Use instance methods** for object behavior
11. **Use class methods** for alternative constructors
12. **Use static methods** for utility functions related to the class

---

## Quiz: Methods

Test your understanding with these questions:

1. **What is the first parameter of an instance method?**
   - A) `cls`
   - B) `self`
   - C) `this`
   - D) None

2. **What decorator is used for class methods?**
   - A) `@instancemethod`
   - B) `@classmethod`
   - C) `@staticmethod`
   - D) `@method`

3. **What does `self` refer to?**
   - A) The class
   - B) The current instance
   - C) A method
   - D) An attribute

4. **Can static methods access instance attributes?**
   - A) Yes
   - B) No
   - C) Only with special syntax
   - D) Sometimes

5. **What decorator is used for properties?**
   - A) `@property`
   - B) `@getter`
   - C) `@attribute`
   - D) `@prop`

6. **What is the first parameter of a class method?**
   - A) `self`
   - B) `cls`
   - C) `class`
   - D) None

7. **Can you call a class method from an instance?**
   - A) No
   - B) Yes
   - C) Only with special syntax
   - D) Only in Python 3

8. **What are class attributes shared by?**
   - A) Only one instance
   - B) All instances of the class
   - C) Only the class itself
   - D) No instances

9. **What does `@property` allow?**
   - A) Methods to be called like attributes
   - B) Attributes to be called like methods
   - C) Classes to have properties
   - D) Static methods

10. **When should you use static methods?**
    - A) For object behavior
    - B) For utility functions that don't need instance/class data
    - C) For alternative constructors
    - D) Never

**Answers**:
1. B) `self` (first parameter of instance methods)
2. B) `@classmethod` (decorator for class methods)
3. B) The current instance (self refers to the object)
4. B) No (static methods don't have access to instance or class)
5. A) `@property` (decorator for properties)
6. B) `cls` (first parameter of class methods)
7. B) Yes (can call class methods from instances)
8. B) All instances of the class (class attributes are shared)
9. A) Methods to be called like attributes (property decorator)
10. B) For utility functions that don't need instance/class data (static methods are utilities)

---

## Next Steps

Excellent work! You've mastered methods and attributes. You now understand:
- How to define and use instance methods
- How to create class methods and static methods
- The difference between class and instance attributes
- How to use properties for computed attributes
- When to use each type of method

**What's Next?**
- Lesson 8.3: Constructors and Special Methods
- Learn about `__init__` and other special methods
- Understand operator overloading
- Explore more advanced OOP concepts

---

## Additional Resources

- **Python Classes**: [docs.python.org/3/tutorial/classes.html](https://docs.python.org/3/tutorial/classes.html)
- **Property Decorator**: [docs.python.org/3/library/functions.html#property](https://docs.python.org/3/library/functions.html#property)
- **Method Types**: Research instance, class, and static methods in Python

---

*Lesson completed! You're ready to move on to the next lesson.*

