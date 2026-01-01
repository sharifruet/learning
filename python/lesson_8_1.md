# Lesson 8.1: Classes and Objects

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the concepts of object-oriented programming (OOP)
- Define classes in Python
- Create objects (instances) from classes
- Work with instance variables
- Understand the difference between classes and objects
- Use constructors to initialize objects
- Access and modify object attributes
- Apply OOP principles to solve problems
- Understand the benefits of OOP

---

## Introduction to Object-Oriented Programming

**Object-Oriented Programming (OOP)** is a programming paradigm that organizes code into objects that contain both data (attributes) and behavior (methods).

### Key Concepts

1. **Class**: A blueprint or template for creating objects
2. **Object (Instance)**: A specific instance created from a class
3. **Attribute**: Data stored in an object
4. **Method**: Functions that belong to an object
5. **Encapsulation**: Bundling data and methods together

### Why Use OOP?

- **Organization**: Code is organized into logical units
- **Reusability**: Classes can be reused to create multiple objects
- **Maintainability**: Easier to maintain and modify code
- **Abstraction**: Hide complexity behind simple interfaces
- **Modeling**: Naturally models real-world entities

### OOP Principles

1. **Encapsulation**: Data and methods together in a class
2. **Inheritance**: Classes can inherit from other classes
3. **Polymorphism**: Different objects can respond to same method
4. **Abstraction**: Hide implementation details

---

## Understanding Classes and Objects

### Real-World Analogy

Think of a **class** as a blueprint for a house:
- The blueprint (class) defines the structure
- Each house built from the blueprint is an **object** (instance)
- All houses have the same structure but different contents

### Example: Car Class

```python
# Class definition (blueprint)
class Car:
    pass

# Creating objects (instances)
car1 = Car()
car2 = Car()
car3 = Car()

print(type(car1))  # Output: <class '__main__.Car'>
print(car1)        # Output: <__main__.Car object at 0x...>
```

---

## Defining Classes

### Basic Class Definition

```python
class ClassName:
    # Class body
    pass
```

### Simple Example

```python
class Dog:
    pass

# Create objects
dog1 = Dog()
dog2 = Dog()

print(dog1)  # Output: <__main__.Dog object at 0x...>
print(dog2)  # Output: <__main__.Dog object at 0x...>
```

### Class Naming Convention

- Use **PascalCase** (CapitalizeWords)
- Be descriptive and clear
- Examples: `Car`, `BankAccount`, `StudentRecord`

---

## Creating Objects (Instances)

### Instantiation

Creating an object from a class is called **instantiation**:

```python
class Person:
    pass

# Create instances
person1 = Person()
person2 = Person()
person3 = Person()

# Each object is independent
print(person1 is person2)  # Output: False (different objects)
```

### Multiple Objects

```python
class Book:
    pass

# Create multiple book objects
book1 = Book()
book2 = Book()
book3 = Book()

# Each is a separate object
print(id(book1))  # Unique ID
print(id(book2))  # Different ID
print(id(book3))  # Different ID
```

---

## Instance Variables (Attributes)

**Instance variables** store data unique to each object.

### Adding Attributes

```python
class Dog:
    pass

# Create object
my_dog = Dog()

# Add attributes (instance variables)
my_dog.name = "Buddy"
my_dog.age = 3
my_dog.breed = "Golden Retriever"

# Access attributes
print(my_dog.name)   # Output: Buddy
print(my_dog.age)    # Output: 3
print(my_dog.breed)  # Output: Golden Retriever
```

### Different Objects, Different Attributes

```python
class Dog:
    pass

# Create multiple dogs
dog1 = Dog()
dog1.name = "Buddy"
dog1.age = 3

dog2 = Dog()
dog2.name = "Max"
dog2.age = 5

# Each has its own attributes
print(f"{dog1.name} is {dog1.age} years old")  # Output: Buddy is 3 years old
print(f"{dog2.name} is {dog2.age} years old")  # Output: Max is 5 years old
```

### Modifying Attributes

```python
class Dog:
    pass

my_dog = Dog()
my_dog.name = "Buddy"
my_dog.age = 3

print(my_dog.age)  # Output: 3

# Modify attribute
my_dog.age = 4
print(my_dog.age)  # Output: 4
```

---

## The `__init__` Method (Constructor)

The `__init__` method is a special method called when an object is created. It's used to initialize object attributes.

### Basic `__init__` Method

```python
class Dog:
    def __init__(self):
        self.name = "Unknown"
        self.age = 0

# Create object
my_dog = Dog()
print(my_dog.name)  # Output: Unknown
print(my_dog.age)   # Output: 0
```

### `__init__` with Parameters

```python
class Dog:
    def __init__(self, name, age):
        self.name = name
        self.age = age

# Create objects with initial values
dog1 = Dog("Buddy", 3)
dog2 = Dog("Max", 5)

print(f"{dog1.name} is {dog1.age} years old")  # Output: Buddy is 3 years old
print(f"{dog2.name} is {dog2.age} years old")  # Output: Max is 5 years old
```

### Understanding `self`

`self` refers to the current instance of the class:

```python
class Dog:
    def __init__(self, name, age):
        self.name = name  # self.name is the instance variable
        self.age = age    # self.age is the instance variable

# When you create: dog1 = Dog("Buddy", 3)
# self refers to dog1
# So self.name = name means dog1.name = "Buddy"
```

### Complete Example

```python
class Car:
    def __init__(self, make, model, year):
        self.make = make
        self.model = model
        self.year = year
        self.mileage = 0  # Default value

# Create car objects
car1 = Car("Toyota", "Camry", 2020)
car2 = Car("Honda", "Civic", 2021)

print(f"{car1.year} {car1.make} {car1.model}")  # Output: 2020 Toyota Camry
print(f"{car2.year} {car2.make} {car2.model}")  # Output: 2021 Honda Civic
print(f"Mileage: {car1.mileage}")  # Output: Mileage: 0
```

---

## More Examples

### Example 1: Bank Account

```python
class BankAccount:
    def __init__(self, account_number, owner_name, initial_balance=0):
        self.account_number = account_number
        self.owner_name = owner_name
        self.balance = initial_balance

# Create accounts
account1 = BankAccount("12345", "Alice", 1000)
account2 = BankAccount("67890", "Bob", 500)

print(f"{account1.owner_name}'s balance: ${account1.balance}")
print(f"{account2.owner_name}'s balance: ${account2.balance}")
```

### Example 2: Student

```python
class Student:
    def __init__(self, name, student_id, grade_level):
        self.name = name
        self.student_id = student_id
        self.grade_level = grade_level
        self.courses = []  # Empty list initially

# Create students
student1 = Student("Alice", "S001", 10)
student2 = Student("Bob", "S002", 11)

print(f"{student1.name} (ID: {student1.student_id}) is in grade {student1.grade_level}")
```

### Example 3: Rectangle

```python
class Rectangle:
    def __init__(self, width, height):
        self.width = width
        self.height = height

# Create rectangles
rect1 = Rectangle(5, 10)
rect2 = Rectangle(3, 7)

print(f"Rectangle 1: {rect1.width} x {rect1.height}")
print(f"Rectangle 2: {rect2.width} x {rect2.height}")
```

---

## Accessing Attributes

### Direct Access

```python
class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age

person = Person("Alice", 30)

# Access attributes directly
print(person.name)  # Output: Alice
print(person.age)   # Output: 30
```

### Using `getattr()` and `setattr()`

```python
class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age

person = Person("Alice", 30)

# Using getattr()
name = getattr(person, "name")
print(name)  # Output: Alice

# Using setattr()
setattr(person, "age", 31)
print(person.age)  # Output: 31

# Check if attribute exists
if hasattr(person, "name"):
    print("Has name attribute")
```

### Attribute Access with Default

```python
class Person:
    def __init__(self, name):
        self.name = name

person = Person("Alice")

# Access with default if not exists
email = getattr(person, "email", "No email")
print(email)  # Output: No email
```

---

## Modifying Attributes

### Direct Modification

```python
class Car:
    def __init__(self, make, model):
        self.make = make
        self.model = model
        self.mileage = 0

car = Car("Toyota", "Camry")
print(f"Mileage: {car.mileage}")  # Output: Mileage: 0

# Modify directly
car.mileage = 1000
print(f"Mileage: {car.mileage}")  # Output: Mileage: 1000
```

### Adding New Attributes

```python
class Car:
    def __init__(self, make, model):
        self.make = make
        self.model = model

car = Car("Toyota", "Camry")

# Add new attribute after creation
car.color = "Blue"
car.year = 2020

print(f"{car.year} {car.color} {car.make} {car.model}")
# Output: 2020 Blue Toyota Camry
```

---

## Default Values in `__init__`

### Optional Parameters

```python
class Dog:
    def __init__(self, name, age=1, breed="Unknown"):
        self.name = name
        self.age = age
        self.breed = breed

# Different ways to create objects
dog1 = Dog("Buddy")  # Uses defaults for age and breed
dog2 = Dog("Max", 5)  # Uses default for breed
dog3 = Dog("Charlie", 3, "Labrador")  # All specified

print(f"{dog1.name}, {dog1.age}, {dog1.breed}")  # Output: Buddy, 1, Unknown
print(f"{dog2.name}, {dog2.age}, {dog2.breed}")  # Output: Max, 5, Unknown
print(f"{dog3.name}, {dog3.age}, {dog3.breed}")  # Output: Charlie, 3, Labrador
```

### Mutable Default Arguments (Be Careful!)

```python
# WRONG: Don't use mutable defaults
class Student:
    def __init__(self, name, courses=[]):  # BAD!
        self.name = name
        self.courses = courses

# RIGHT: Use None and create new list
class Student:
    def __init__(self, name, courses=None):
        self.name = name
        if courses is None:
            self.courses = []
        else:
            self.courses = courses
```

---

## Class Attributes vs Instance Attributes

### Instance Attributes

Belong to individual objects:

```python
class Dog:
    def __init__(self, name):
        self.name = name  # Instance attribute

dog1 = Dog("Buddy")
dog2 = Dog("Max")

print(dog1.name)  # Output: Buddy
print(dog2.name)  # Output: Max (different value)
```

### Class Attributes

Shared by all instances:

```python
class Dog:
    species = "Canis familiaris"  # Class attribute
    
    def __init__(self, name):
        self.name = name  # Instance attribute

dog1 = Dog("Buddy")
dog2 = Dog("Max")

# Class attribute (same for all)
print(dog1.species)  # Output: Canis familiaris
print(dog2.species)  # Output: Canis familiaris

# Instance attribute (different for each)
print(dog1.name)  # Output: Buddy
print(dog2.name)  # Output: Max
```

### Modifying Class Attributes

```python
class Dog:
    species = "Canis familiaris"
    
    def __init__(self, name):
        self.name = name

dog1 = Dog("Buddy")
dog2 = Dog("Max")

# Modify class attribute (affects all)
Dog.species = "Canis lupus"

print(dog1.species)  # Output: Canis lupus
print(dog2.species)  # Output: Canis lupus
```

---

## Object Identity

### Object IDs

Each object has a unique identity:

```python
class Person:
    def __init__(self, name):
        self.name = name

person1 = Person("Alice")
person2 = Person("Alice")
person3 = person1

print(id(person1))  # Unique ID
print(id(person2))  # Different ID
print(id(person3))  # Same as person1

print(person1 is person2)  # Output: False (different objects)
print(person1 is person3)  # Output: True (same object)
```

### Equality vs Identity

```python
class Person:
    def __init__(self, name):
        self.name = name

person1 = Person("Alice")
person2 = Person("Alice")

# Identity (is) - same object?
print(person1 is person2)  # Output: False

# Equality (==) - same values? (needs __eq__ method, covered later)
print(person1 == person2)  # Output: False (by default)
```

---

## Practical Examples

### Example 1: Library Book

```python
class Book:
    def __init__(self, title, author, isbn):
        self.title = title
        self.author = author
        self.isbn = isbn
        self.is_checked_out = False

# Create books
book1 = Book("Python Basics", "John Doe", "123-456")
book2 = Book("Advanced Python", "Jane Smith", "789-012")

print(f"{book1.title} by {book1.author}")
print(f"ISBN: {book1.isbn}")
print(f"Checked out: {book1.is_checked_out}")
```

### Example 2: Product

```python
class Product:
    def __init__(self, name, price, category):
        self.name = name
        self.price = price
        self.category = category
        self.in_stock = True

# Create products
product1 = Product("Laptop", 999.99, "Electronics")
product2 = Product("Book", 19.99, "Education")

print(f"{product1.name}: ${product1.price}")
print(f"Category: {product1.category}")
```

### Example 3: Point

```python
class Point:
    def __init__(self, x=0, y=0):
        self.x = x
        self.y = y

# Create points
point1 = Point(3, 4)
point2 = Point()  # Uses defaults (0, 0)
point3 = Point(5)  # y defaults to 0

print(f"Point 1: ({point1.x}, {point1.y})")  # Output: Point 1: (3, 4)
print(f"Point 2: ({point2.x}, {point2.y})")  # Output: Point 2: (0, 0)
print(f"Point 3: ({point3.x}, {point3.y})")  # Output: Point 3: (5, 0)
```

---

## Common Mistakes and Pitfalls

### 1. Forgetting `self`

```python
# WRONG
class Dog:
    def __init__(self, name):
        name = name  # Doesn't create instance variable!

# CORRECT
class Dog:
    def __init__(self, name):
        self.name = name  # Creates instance variable
```

### 2. Mutable Default Arguments

```python
# WRONG: Shared mutable default
class Student:
    def __init__(self, name, courses=[]):
        self.name = name
        self.courses = courses

# CORRECT: Use None
class Student:
    def __init__(self, name, courses=None):
        self.name = name
        if courses is None:
            self.courses = []
        else:
            self.courses = courses
```

### 3. Accessing Non-Existent Attributes

```python
class Person:
    def __init__(self, name):
        self.name = name

person = Person("Alice")
# print(person.age)  # AttributeError: 'Person' object has no attribute 'age'

# Use hasattr() to check
if hasattr(person, "age"):
    print(person.age)
else:
    print("No age attribute")
```

### 4. Confusing Class and Instance Attributes

```python
class Dog:
    species = "Canis familiaris"  # Class attribute
    
    def __init__(self, name):
        self.name = name  # Instance attribute

dog = Dog("Buddy")
print(dog.species)  # Works (accesses class attribute)
print(Dog.species)  # Also works (accesses class attribute directly)
```

---

## Best Practices

### 1. Use Descriptive Class Names

```python
# Good
class BankAccount:
    pass

class StudentRecord:
    pass

# Avoid
class BA:  # Too short
    pass

class data:  # Not PascalCase
    pass
```

### 2. Initialize All Attributes in `__init__`

```python
# Good: All attributes initialized
class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age

# Avoid: Adding attributes later
class Person:
    def __init__(self, name):
        self.name = name

person = Person("Alice")
person.age = 30  # Added later - not ideal
```

### 3. Use Type Hints (Optional but Recommended)

```python
class Person:
    def __init__(self, name: str, age: int):
        self.name: str = name
        self.age: int = age
```

### 4. Document Your Classes

```python
class Person:
    """Represents a person with name and age."""
    
    def __init__(self, name, age):
        """
        Initialize a Person object.
        
        Args:
            name: The person's name
            age: The person's age
        """
        self.name = name
        self.age = age
```

---

## Practice Exercise

### Exercise: Creating Classes

**Objective**: Create a Python program that demonstrates class definition and object creation.

**Instructions**:

1. Create a file called `classes_practice.py`

2. Write a program that:
   - Defines multiple classes
   - Creates objects from classes
   - Uses `__init__` to initialize objects
   - Works with instance variables
   - Demonstrates class vs instance attributes

3. Your program should include:
   - A `Person` class
   - A `Car` class
   - A `BankAccount` class
   - A `Student` class
   - Create and use objects from each class

**Example Solution**:

```python
"""
Classes and Objects Practice
This program demonstrates class definition and object creation.
"""

print("=" * 60)
print("CLASSES AND OBJECTS PRACTICE")
print("=" * 60)
print()

# 1. Basic Class
print("1. BASIC CLASS")
print("-" * 60)
class Dog:
    def __init__(self, name, age):
        self.name = name
        self.age = age

dog1 = Dog("Buddy", 3)
dog2 = Dog("Max", 5)

print(f"{dog1.name} is {dog1.age} years old")
print(f"{dog2.name} is {dog2.age} years old")
print()

# 2. Person Class
print("2. PERSON CLASS")
print("-" * 60)
class Person:
    def __init__(self, name, age, email):
        self.name = name
        self.age = age
        self.email = email

person1 = Person("Alice", 30, "alice@example.com")
person2 = Person("Bob", 25, "bob@example.com")

print(f"Person 1: {person1.name}, {person1.age}, {person1.email}")
print(f"Person 2: {person2.name}, {person2.age}, {person2.email}")
print()

# 3. Car Class
print("3. CAR CLASS")
print("-" * 60)
class Car:
    def __init__(self, make, model, year):
        self.make = make
        self.model = model
        self.year = year
        self.mileage = 0

car1 = Car("Toyota", "Camry", 2020)
car2 = Car("Honda", "Civic", 2021)

print(f"Car 1: {car1.year} {car1.make} {car1.model}, Mileage: {car1.mileage}")
print(f"Car 2: {car2.year} {car2.make} {car2.model}, Mileage: {car2.mileage}")

# Modify attributes
car1.mileage = 15000
print(f"Updated Car 1 mileage: {car1.mileage}")
print()

# 4. Bank Account Class
print("4. BANK ACCOUNT CLASS")
print("-" * 60)
class BankAccount:
    def __init__(self, account_number, owner_name, initial_balance=0):
        self.account_number = account_number
        self.owner_name = owner_name
        self.balance = initial_balance

account1 = BankAccount("12345", "Alice", 1000)
account2 = BankAccount("67890", "Bob", 500)
account3 = BankAccount("11111", "Charlie")  # Uses default balance

print(f"{account1.owner_name}'s account ({account1.account_number}): ${account1.balance}")
print(f"{account2.owner_name}'s account ({account2.account_number}): ${account2.balance}")
print(f"{account3.owner_name}'s account ({account3.account_number}): ${account3.balance}")
print()

# 5. Student Class
print("5. STUDENT CLASS")
print("-" * 60)
class Student:
    def __init__(self, name, student_id, grade_level):
        self.name = name
        self.student_id = student_id
        self.grade_level = grade_level
        self.courses = []

student1 = Student("Alice", "S001", 10)
student2 = Student("Bob", "S002", 11)

print(f"Student: {student1.name} (ID: {student1.student_id}), Grade: {student1.grade_level}")
print(f"Student: {student2.name} (ID: {student2.student_id}), Grade: {student2.grade_level}")

# Add courses
student1.courses.append("Math")
student1.courses.append("Science")
print(f"{student1.name}'s courses: {student1.courses}")
print()

# 6. Rectangle Class
print("6. RECTANGLE CLASS")
print("-" * 60)
class Rectangle:
    def __init__(self, width, height):
        self.width = width
        self.height = height

rect1 = Rectangle(5, 10)
rect2 = Rectangle(3, 7)

print(f"Rectangle 1: {rect1.width} x {rect1.height}")
print(f"Rectangle 2: {rect2.width} x {rect2.height}")
print()

# 7. Book Class
print("7. BOOK CLASS")
print("-" * 60)
class Book:
    def __init__(self, title, author, isbn):
        self.title = title
        self.author = author
        self.isbn = isbn
        self.is_checked_out = False

book1 = Book("Python Basics", "John Doe", "123-456")
book2 = Book("Advanced Python", "Jane Smith", "789-012")

print(f"Book: {book1.title} by {book1.author}")
print(f"ISBN: {book1.isbn}, Checked out: {book1.is_checked_out}")

book1.is_checked_out = True
print(f"After checkout: {book1.is_checked_out}")
print()

# 8. Product Class
print("8. PRODUCT CLASS")
print("-" * 60)
class Product:
    def __init__(self, name, price, category):
        self.name = name
        self.price = price
        self.category = category
        self.in_stock = True

product1 = Product("Laptop", 999.99, "Electronics")
product2 = Product("Book", 19.99, "Education")

print(f"Product: {product1.name}")
print(f"Price: ${product1.price}, Category: {product1.category}")
print(f"In stock: {product1.in_stock}")
print()

# 9. Point Class with Defaults
print("9. POINT CLASS WITH DEFAULTS")
print("-" * 60)
class Point:
    def __init__(self, x=0, y=0):
        self.x = x
        self.y = y

point1 = Point(3, 4)
point2 = Point()  # Uses defaults
point3 = Point(5)  # y defaults to 0

print(f"Point 1: ({point1.x}, {point1.y})")
print(f"Point 2: ({point2.x}, {point2.y})")
print(f"Point 3: ({point3.x}, {point3.y})")
print()

# 10. Class Attributes vs Instance Attributes
print("10. CLASS ATTRIBUTES VS INSTANCE ATTRIBUTES")
print("-" * 60)
class Dog:
    species = "Canis familiaris"  # Class attribute
    
    def __init__(self, name, age):
        self.name = name  # Instance attribute
        self.age = age    # Instance attribute

dog1 = Dog("Buddy", 3)
dog2 = Dog("Max", 5)

print(f"Dog 1: {dog1.name}, {dog1.age}, Species: {dog1.species}")
print(f"Dog 2: {dog2.name}, {dog2.age}, Species: {dog2.species}")
print(f"Class species: {Dog.species}")
print()

# 11. Object Identity
print("11. OBJECT IDENTITY")
print("-" * 60)
class Person:
    def __init__(self, name):
        self.name = name

person1 = Person("Alice")
person2 = Person("Alice")
person3 = person1

print(f"person1 id: {id(person1)}")
print(f"person2 id: {id(person2)}")
print(f"person3 id: {id(person3)}")
print(f"person1 is person2: {person1 is person2}")
print(f"person1 is person3: {person1 is person3}")
print()

# 12. Using getattr and setattr
print("12. USING GETATTR AND SETATTR")
print("-" * 60)
class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age

person = Person("Alice", 30)
print(f"Name: {getattr(person, 'name')}")
print(f"Age: {getattr(person, 'age')}")

setattr(person, "age", 31)
print(f"Updated age: {person.age}")

if hasattr(person, "email"):
    print(f"Email: {person.email}")
else:
    print("No email attribute")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
CLASSES AND OBJECTS PRACTICE
============================================================

1. BASIC CLASS
------------------------------------------------------------
Buddy is 3 years old
Max is 5 years old

[... rest of output ...]
```

**Challenge** (Optional):
- Create a `Library` class that manages multiple `Book` objects
- Build a `ShoppingCart` class that holds `Product` objects
- Create a `School` class that manages `Student` objects
- Design a `Garage` class that stores `Car` objects

---

## Key Takeaways

1. **Classes are blueprints** for creating objects
2. **Objects are instances** created from classes
3. **`__init__` method** initializes objects when created
4. **`self` refers to the current instance** of the class
5. **Instance variables** store data unique to each object
6. **Attributes are accessed** using dot notation (`object.attribute`)
7. **Each object is independent** - changes to one don't affect others
8. **Class attributes** are shared by all instances
9. **Use PascalCase** for class names
10. **Initialize attributes in `__init__`** for better organization
11. **Avoid mutable default arguments** in `__init__`
12. **OOP helps organize code** and model real-world entities

---

## Quiz: Classes Basics

Test your understanding with these questions:

1. **What is a class?**
   - A) An object
   - B) A blueprint for creating objects
   - C) A variable
   - D) A function

2. **What is `self` in a class method?**
   - A) The class itself
   - B) The current instance of the class
   - C) A keyword
   - D) A variable name

3. **What method is called when an object is created?**
   - A) `__new__`
   - B) `__init__`
   - C) `__create__`
   - D) `__start__`

4. **How do you access an object's attribute?**
   - A) `object->attribute`
   - B) `object.attribute`
   - C) `object[attribute]`
   - D) `object{attribute}`

5. **What is the naming convention for classes?**
   - A) snake_case
   - B) camelCase
   - C) PascalCase
   - D) kebab-case

6. **What happens if you don't define `__init__`?**
   - A) Error
   - B) Object can't be created
   - C) Object is created with no attributes
   - D) Default attributes are added

7. **Can you add attributes to an object after creation?**
   - A) No
   - B) Yes, but not recommended
   - C) Only in `__init__`
   - D) Only with special methods

8. **What is the difference between class and instance attributes?**
   - A) No difference
   - B) Class attributes belong to class, instance to objects
   - C) Instance attributes belong to class
   - D) They're the same

9. **What does `object1 is object2` check?**
   - A) If they have same values
   - B) If they are the same object
   - C) If they are same type
   - D) If they have same attributes

10. **What should you avoid in `__init__` default arguments?**
    - A) Strings
    - B) Numbers
    - C) Mutable objects (like lists)
    - D) None

**Answers**:
1. B) A blueprint for creating objects (class defines structure)
2. B) The current instance of the class (self refers to the object)
3. B) `__init__` (constructor method called on creation)
4. B) `object.attribute` (dot notation in Python)
5. C) PascalCase (CapitalizeWords like `MyClass`)
6. C) Object is created with no attributes (empty object)
7. B) Yes, but not recommended (better to initialize in `__init__`)
8. B) Class attributes belong to class, instance to objects (shared vs unique)
9. B) If they are the same object (identity check, not equality)
10. C) Mutable objects (like lists) (can cause shared state issues)

---

## Next Steps

Excellent work! You've mastered classes and objects. You now understand:
- How to define classes
- How to create objects from classes
- How to use `__init__` to initialize objects
- How to work with instance variables
- The difference between classes and objects

**What's Next?**
- Lesson 8.2: Methods and Attributes
- Learn about instance methods
- Understand class methods and static methods
- Explore property decorators

---

## Additional Resources

- **Python Classes**: [docs.python.org/3/tutorial/classes.html](https://docs.python.org/3/tutorial/classes.html)
- **Object-Oriented Programming**: Research OOP principles and design patterns
- **PEP 8 Style Guide**: [pep8.org](https://pep8.org/) for Python coding standards

---

*Lesson completed! You're ready to move on to the next lesson.*

