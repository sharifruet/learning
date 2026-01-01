# Lesson 8.3: Constructors and Special Methods

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the `__init__` constructor method
- Use `__str__` and `__repr__` for string representation
- Implement comparison methods (`__eq__`, `__lt__`, etc.)
- Use `__len__` to make objects work with `len()`
- Understand operator overloading with special methods
- Implement arithmetic operations (`__add__`, `__sub__`, etc.)
- Use other important special methods
- Customize object behavior with special methods
- Understand when and how to use special methods

---

## Introduction to Special Methods

**Special methods** (also called **magic methods** or **dunder methods**) are methods with double underscores (`__method__`) that Python calls automatically in certain situations.

### Why Special Methods?

- **Customize behavior**: Control how objects behave with built-in functions
- **Operator overloading**: Define how operators work with your objects
- **Integration**: Make objects work seamlessly with Python's built-in features

### Common Special Methods

- `__init__`: Constructor
- `__str__`: String representation (user-friendly)
- `__repr__`: String representation (developer-friendly)
- `__len__`: Length
- `__eq__`, `__ne__`, `__lt__`, `__le__`, `__gt__`, `__ge__`: Comparisons
- `__add__`, `__sub__`, `__mul__`, etc.: Arithmetic operations

---

## The `__init__` Method (Constructor)

The `__init__` method is called when an object is created. It initializes the object.

### Basic `__init__`

```python
class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age

person = Person("Alice", 30)
print(person.name)  # Output: Alice
print(person.age)   # Output: 30
```

### `__init__` with Default Values

```python
class Dog:
    def __init__(self, name, age=1, breed="Unknown"):
        self.name = name
        self.age = age
        self.breed = breed

dog1 = Dog("Buddy")
dog2 = Dog("Max", 5, "Labrador")

print(f"{dog1.name}, {dog1.age}, {dog1.breed}")  # Output: Buddy, 1, Unknown
print(f"{dog2.name}, {dog2.age}, {dog2.breed}")  # Output: Max, 5, Labrador
```

### `__init__` with Validation

```python
class BankAccount:
    def __init__(self, owner, initial_balance=0):
        if initial_balance < 0:
            raise ValueError("Initial balance cannot be negative")
        self.owner = owner
        self.balance = initial_balance

# account = BankAccount("Alice", -100)  # ValueError
account = BankAccount("Alice", 1000)
print(account.balance)  # Output: 1000
```

---

## `__str__` and `__repr__`

### `__str__` Method

`__str__` returns a user-friendly string representation. Called by `str()` and `print()`.

```python
class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age
    
    def __str__(self):
        return f"{self.name}, {self.age} years old"

person = Person("Alice", 30)
print(person)           # Output: Alice, 30 years old
print(str(person))      # Output: Alice, 30 years old
```

### `__repr__` Method

`__repr__` returns a developer-friendly string representation. Should ideally be valid Python code.

```python
class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age
    
    def __repr__(self):
        return f"Person('{self.name}', {self.age})"

person = Person("Alice", 30)
print(repr(person))     # Output: Person('Alice', 30)
print(person)           # Output: Person('Alice', 30) (uses __repr__ if __str__ not defined)
```

### Both `__str__` and `__repr__`

```python
class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age
    
    def __str__(self):
        return f"{self.name}, {self.age} years old"
    
    def __repr__(self):
        return f"Person('{self.name}', {self.age})"

person = Person("Alice", 30)
print(person)           # Output: Alice, 30 years old (uses __str__)
print(repr(person))     # Output: Person('Alice', 30) (uses __repr__)
```

### When to Use Each

- **`__str__`**: User-friendly, readable output
- **`__repr__`**: Developer-friendly, should be unambiguous and ideally recreate the object

**Best Practice**: Always define `__repr__`. Define `__str__` if you want different user-friendly output.

---

## Comparison Methods

### `__eq__` (Equality)

```python
class Point:
    def __init__(self, x, y):
        self.x = x
        self.y = y
    
    def __eq__(self, other):
        if not isinstance(other, Point):
            return NotImplemented
        return self.x == other.x and self.y == other.y

point1 = Point(3, 4)
point2 = Point(3, 4)
point3 = Point(5, 6)

print(point1 == point2)  # Output: True
print(point1 == point3)   # Output: False
```

### `__ne__` (Not Equal)

```python
class Point:
    def __init__(self, x, y):
        self.x = x
        self.y = y
    
    def __eq__(self, other):
        if not isinstance(other, Point):
            return NotImplemented
        return self.x == other.x and self.y == other.y
    
    def __ne__(self, other):
        return not self.__eq__(other)

point1 = Point(3, 4)
point2 = Point(5, 6)

print(point1 != point2)  # Output: True
```

### `__lt__`, `__le__`, `__gt__`, `__ge__` (Ordering)

```python
class Student:
    def __init__(self, name, grade):
        self.name = name
        self.grade = grade
    
    def __lt__(self, other):
        if not isinstance(other, Student):
            return NotImplemented
        return self.grade < other.grade
    
    def __le__(self, other):
        if not isinstance(other, Student):
            return NotImplemented
        return self.grade <= other.grade
    
    def __gt__(self, other):
        if not isinstance(other, Student):
            return NotImplemented
        return self.grade > other.grade
    
    def __ge__(self, other):
        if not isinstance(other, Student):
            return NotImplemented
        return self.grade >= other.grade

student1 = Student("Alice", 85)
student2 = Student("Bob", 90)
student3 = Student("Charlie", 85)

print(student1 < student2)   # Output: True
print(student1 <= student3)  # Output: True
print(student1 > student2)   # Output: False
print(student1 >= student3)  # Output: True
```

### Using `functools.total_ordering`

For convenience, you can use `functools.total_ordering` to automatically generate comparison methods:

```python
from functools import total_ordering

@total_ordering
class Student:
    def __init__(self, name, grade):
        self.name = name
        self.grade = grade
    
    def __eq__(self, other):
        if not isinstance(other, Student):
            return NotImplemented
        return self.grade == other.grade
    
    def __lt__(self, other):
        if not isinstance(other, Student):
            return NotImplemented
        return self.grade < other.grade

student1 = Student("Alice", 85)
student2 = Student("Bob", 90)

print(student1 < student2)   # Output: True
print(student1 <= student2)  # Output: True (automatically generated)
print(student1 > student2)  # Output: False (automatically generated)
```

---

## The `__len__` Method

`__len__` makes objects work with the `len()` function.

```python
class ShoppingCart:
    def __init__(self):
        self.items = []
    
    def add_item(self, item):
        self.items.append(item)
    
    def __len__(self):
        return len(self.items)

cart = ShoppingCart()
cart.add_item("Apple")
cart.add_item("Banana")
cart.add_item("Orange")

print(len(cart))  # Output: 3
```

### Example: Custom List-like Class

```python
class MyList:
    def __init__(self, items=None):
        if items is None:
            self.items = []
        else:
            self.items = list(items)
    
    def append(self, item):
        self.items.append(item)
    
    def __len__(self):
        return len(self.items)
    
    def __str__(self):
        return str(self.items)

my_list = MyList([1, 2, 3])
print(len(my_list))  # Output: 3
my_list.append(4)
print(len(my_list))  # Output: 4
```

---

## Arithmetic Operations

### `__add__` (Addition)

```python
class Point:
    def __init__(self, x, y):
        self.x = x
        self.y = y
    
    def __str__(self):
        return f"Point({self.x}, {self.y})"
    
    def __add__(self, other):
        if not isinstance(other, Point):
            return NotImplemented
        return Point(self.x + other.x, self.y + other.y)

point1 = Point(3, 4)
point2 = Point(1, 2)
point3 = point1 + point2

print(point3)  # Output: Point(4, 6)
```

### `__sub__` (Subtraction)

```python
class Point:
    def __init__(self, x, y):
        self.x = x
        self.y = y
    
    def __sub__(self, other):
        if not isinstance(other, Point):
            return NotImplemented
        return Point(self.x - other.x, self.y - other.y)

point1 = Point(5, 6)
point2 = Point(2, 3)
point3 = point1 - point2

print(point3)  # Output: Point(3, 3)
```

### `__mul__` (Multiplication)

```python
class Vector:
    def __init__(self, x, y):
        self.x = x
        self.y = y
    
    def __mul__(self, scalar):
        if isinstance(scalar, (int, float)):
            return Vector(self.x * scalar, self.y * scalar)
        return NotImplemented
    
    def __str__(self):
        return f"Vector({self.x}, {self.y})"

vector = Vector(3, 4)
result = vector * 2

print(result)  # Output: Vector(6, 8)
```

### `__truediv__` (Division)

```python
class Vector:
    def __init__(self, x, y):
        self.x = x
        self.y = y
    
    def __truediv__(self, scalar):
        if isinstance(scalar, (int, float)):
            if scalar == 0:
                raise ValueError("Cannot divide by zero")
            return Vector(self.x / scalar, self.y / scalar)
        return NotImplemented
    
    def __str__(self):
        return f"Vector({self.x}, {self.y})"

vector = Vector(6, 8)
result = vector / 2

print(result)  # Output: Vector(3.0, 4.0)
```

### Right-Side Operations

For operations like `2 * vector`, implement `__rmul__`:

```python
class Vector:
    def __init__(self, x, y):
        self.x = x
        self.y = y
    
    def __mul__(self, scalar):
        if isinstance(scalar, (int, float)):
            return Vector(self.x * scalar, self.y * scalar)
        return NotImplemented
    
    def __rmul__(self, scalar):
        # Called when scalar * vector (right multiplication)
        return self.__mul__(scalar)
    
    def __str__(self):
        return f"Vector({self.x}, {self.y})"

vector = Vector(3, 4)
result1 = vector * 2    # Uses __mul__
result2 = 2 * vector    # Uses __rmul__

print(result1)  # Output: Vector(6, 8)
print(result2)  # Output: Vector(6, 8)
```

---

## Other Important Special Methods

### `__bool__` (Truthiness)

```python
class BankAccount:
    def __init__(self, balance):
        self.balance = balance
    
    def __bool__(self):
        return self.balance > 0

account1 = BankAccount(100)
account2 = BankAccount(0)

if account1:
    print("Account has money")  # Output: Account has money

if account2:
    print("Account has money")
else:
    print("Account is empty")  # Output: Account is empty
```

### `__getitem__` and `__setitem__` (Indexing)

```python
class MyList:
    def __init__(self, items=None):
        if items is None:
            self.items = []
        else:
            self.items = list(items)
    
    def __getitem__(self, index):
        return self.items[index]
    
    def __setitem__(self, index, value):
        self.items[index] = value
    
    def __len__(self):
        return len(self.items)

my_list = MyList([1, 2, 3, 4, 5])
print(my_list[0])      # Output: 1 (uses __getitem__)
print(my_list[2])      # Output: 3

my_list[1] = 10        # Uses __setitem__
print(my_list[1])       # Output: 10
```

### `__contains__` (Membership Testing)

```python
class MyList:
    def __init__(self, items=None):
        if items is None:
            self.items = []
        else:
            self.items = list(items)
    
    def __contains__(self, item):
        return item in self.items

my_list = MyList([1, 2, 3, 4, 5])
print(3 in my_list)    # Output: True (uses __contains__)
print(10 in my_list)    # Output: False
```

### `__call__` (Making Objects Callable)

```python
class Multiplier:
    def __init__(self, factor):
        self.factor = factor
    
    def __call__(self, number):
        return number * self.factor

multiply_by_5 = Multiplier(5)
result = multiply_by_5(10)  # Calls __call__

print(result)  # Output: 50
```

### `__iter__` and `__next__` (Iteration)

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

countdown = Countdown(5)
for number in countdown:
    print(number)
# Output:
# 5
# 4
# 3
# 2
# 1
```

---

## Complete Example: Fraction Class

```python
class Fraction:
    def __init__(self, numerator, denominator=1):
        if denominator == 0:
            raise ValueError("Denominator cannot be zero")
        self.numerator = numerator
        self.denominator = denominator
        self._simplify()
    
    def _simplify(self):
        """Simplify the fraction."""
        from math import gcd
        common = gcd(self.numerator, self.denominator)
        self.numerator //= common
        self.denominator //= common
    
    def __str__(self):
        if self.denominator == 1:
            return str(self.numerator)
        return f"{self.numerator}/{self.denominator}"
    
    def __repr__(self):
        return f"Fraction({self.numerator}, {self.denominator})"
    
    def __add__(self, other):
        if not isinstance(other, Fraction):
            other = Fraction(other)
        new_num = self.numerator * other.denominator + other.numerator * self.denominator
        new_den = self.denominator * other.denominator
        return Fraction(new_num, new_den)
    
    def __sub__(self, other):
        if not isinstance(other, Fraction):
            other = Fraction(other)
        new_num = self.numerator * other.denominator - other.numerator * self.denominator
        new_den = self.denominator * other.denominator
        return Fraction(new_num, new_den)
    
    def __mul__(self, other):
        if not isinstance(other, Fraction):
            other = Fraction(other)
        return Fraction(self.numerator * other.numerator, self.denominator * other.denominator)
    
    def __truediv__(self, other):
        if not isinstance(other, Fraction):
            other = Fraction(other)
        return Fraction(self.numerator * other.denominator, self.denominator * other.numerator)
    
    def __eq__(self, other):
        if not isinstance(other, Fraction):
            other = Fraction(other)
        return self.numerator == other.numerator and self.denominator == other.denominator
    
    def __lt__(self, other):
        if not isinstance(other, Fraction):
            other = Fraction(other)
        return self.numerator * other.denominator < other.numerator * self.denominator

# Use the Fraction class
f1 = Fraction(1, 2)
f2 = Fraction(1, 4)

print(f1)              # Output: 1/2
print(f2)              # Output: 1/4
print(f1 + f2)         # Output: 3/4
print(f1 - f2)         # Output: 1/4
print(f1 * f2)         # Output: 1/8
print(f1 / f2)         # Output: 2/1
print(f1 == f2)        # Output: False
print(f1 < f2)         # Output: False
```

---

## Common Mistakes and Pitfalls

### 1. Not Returning `NotImplemented`

```python
# WRONG: Should return NotImplemented for unsupported types
class Point:
    def __add__(self, other):
        return Point(self.x + other.x, self.y + other.y)

# CORRECT: Return NotImplemented for unsupported types
class Point:
    def __add__(self, other):
        if not isinstance(other, Point):
            return NotImplemented
        return Point(self.x + other.x, self.y + other.y)
```

### 2. Modifying `self` in `__str__` or `__repr__`

```python
# WRONG: Don't modify state in string methods
class Counter:
    def __str__(self):
        self.count += 1  # Side effect!
        return str(self.count)

# CORRECT: String methods should be pure
class Counter:
    def __str__(self):
        return str(self.count)
```

### 3. Forgetting to Handle Different Types

```python
# WRONG: Assumes other is same type
class Point:
    def __eq__(self, other):
        return self.x == other.x and self.y == other.y

# CORRECT: Check type first
class Point:
    def __eq__(self, other):
        if not isinstance(other, Point):
            return NotImplemented
        return self.x == other.x and self.y == other.y
```

---

## Best Practices

### 1. Always Define `__repr__`

```python
class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age
    
    def __repr__(self):
        return f"Person('{self.name}', {self.age})"
```

### 2. Return `NotImplemented` for Unsupported Types

```python
class Point:
    def __add__(self, other):
        if not isinstance(other, Point):
            return NotImplemented
        return Point(self.x + other.x, self.y + other.y)
```

### 3. Use `functools.total_ordering` for Comparisons

```python
from functools import total_ordering

@total_ordering
class Student:
    def __eq__(self, other):
        return self.grade == other.grade
    
    def __lt__(self, other):
        return self.grade < other.grade
```

### 4. Keep String Methods Pure

```python
# Don't modify state in __str__ or __repr__
def __str__(self):
    return f"{self.name}"  # No side effects
```

---

## Practice Exercise

### Exercise: Special Methods

**Objective**: Create a Python program that demonstrates various special methods.

**Instructions**:

1. Create a file called `special_methods_practice.py`

2. Write a program that:
   - Implements `__str__` and `__repr__`
   - Implements comparison methods
   - Implements arithmetic operations
   - Implements `__len__`
   - Uses other special methods

3. Your program should include:
   - A class with string representation methods
   - A class with comparison methods
   - A class with arithmetic operations
   - A class with `__len__`
   - Examples of other special methods

**Example Solution**:

```python
"""
Special Methods Practice
This program demonstrates various special methods in Python.
"""

print("=" * 60)
print("SPECIAL METHODS PRACTICE")
print("=" * 60)
print()

# 1. __init__ and __str__
print("1. __INIT__ AND __STR__")
print("-" * 60)
class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age
    
    def __str__(self):
        return f"{self.name}, {self.age} years old"

person = Person("Alice", 30)
print(person)  # Output: Alice, 30 years old
print()

# 2. __str__ and __repr__
print("2. __STR__ AND __REPR__")
print("-" * 60)
class Person:
    def __init__(self, name, age):
        self.name = name
        self.age = age
    
    def __str__(self):
        return f"{self.name}, {self.age} years old"
    
    def __repr__(self):
        return f"Person('{self.name}', {self.age})"

person = Person("Alice", 30)
print(str(person))    # Output: Alice, 30 years old
print(repr(person))   # Output: Person('Alice', 30)
print()

# 3. __eq__ (Equality)
print("3. __EQ__ (EQUALITY)")
print("-" * 60)
class Point:
    def __init__(self, x, y):
        self.x = x
        self.y = y
    
    def __eq__(self, other):
        if not isinstance(other, Point):
            return NotImplemented
        return self.x == other.x and self.y == other.y
    
    def __str__(self):
        return f"Point({self.x}, {self.y})"

point1 = Point(3, 4)
point2 = Point(3, 4)
point3 = Point(5, 6)

print(f"{point1} == {point2}: {point1 == point2}")  # Output: True
print(f"{point1} == {point3}: {point1 == point3}")  # Output: False
print()

# 4. Comparison Methods
print("4. COMPARISON METHODS")
print("-" * 60)
class Student:
    def __init__(self, name, grade):
        self.name = name
        self.grade = grade
    
    def __eq__(self, other):
        if not isinstance(other, Student):
            return NotImplemented
        return self.grade == other.grade
    
    def __lt__(self, other):
        if not isinstance(other, Student):
            return NotImplemented
        return self.grade < other.grade
    
    def __le__(self, other):
        if not isinstance(other, Student):
            return NotImplemented
        return self.grade <= other.grade
    
    def __str__(self):
        return f"{self.name} (Grade: {self.grade})"

student1 = Student("Alice", 85)
student2 = Student("Bob", 90)
student3 = Student("Charlie", 85)

print(f"{student1} < {student2}: {student1 < student2}")   # Output: True
print(f"{student1} <= {student3}: {student1 <= student3}")  # Output: True
print(f"{student1} == {student3}: {student1 == student3}") # Output: True
print()

# 5. __len__
print("5. __LEN__")
print("-" * 60)
class ShoppingCart:
    def __init__(self):
        self.items = []
    
    def add_item(self, item):
        self.items.append(item)
    
    def __len__(self):
        return len(self.items)

cart = ShoppingCart()
cart.add_item("Apple")
cart.add_item("Banana")
cart.add_item("Orange")

print(f"Cart has {len(cart)} items")  # Output: Cart has 3 items
print()

# 6. __add__ (Addition)
print("6. __ADD__ (ADDITION)")
print("-" * 60)
class Point:
    def __init__(self, x, y):
        self.x = x
        self.y = y
    
    def __add__(self, other):
        if not isinstance(other, Point):
            return NotImplemented
        return Point(self.x + other.x, self.y + other.y)
    
    def __str__(self):
        return f"Point({self.x}, {self.y})"

point1 = Point(3, 4)
point2 = Point(1, 2)
point3 = point1 + point2

print(f"{point1} + {point2} = {point3}")  # Output: Point(3, 4) + Point(1, 2) = Point(4, 6)
print()

# 7. __sub__ (Subtraction)
print("7. __SUB__ (SUBTRACTION)")
print("-" * 60)
class Point:
    def __init__(self, x, y):
        self.x = x
        self.y = y
    
    def __sub__(self, other):
        if not isinstance(other, Point):
            return NotImplemented
        return Point(self.x - other.x, self.y - other.y)
    
    def __str__(self):
        return f"Point({self.x}, {self.y})"

point1 = Point(5, 6)
point2 = Point(2, 3)
point3 = point1 - point2

print(f"{point1} - {point2} = {point3}")  # Output: Point(5, 6) - Point(2, 3) = Point(3, 3)
print()

# 8. __mul__ (Multiplication)
print("8. __MUL__ (MULTIPLICATION)")
print("-" * 60)
class Vector:
    def __init__(self, x, y):
        self.x = x
        self.y = y
    
    def __mul__(self, scalar):
        if isinstance(scalar, (int, float)):
            return Vector(self.x * scalar, self.y * scalar)
        return NotImplemented
    
    def __rmul__(self, scalar):
        return self.__mul__(scalar)
    
    def __str__(self):
        return f"Vector({self.x}, {self.y})"

vector = Vector(3, 4)
result1 = vector * 2
result2 = 2 * vector

print(f"{vector} * 2 = {result1}")  # Output: Vector(3, 4) * 2 = Vector(6, 8)
print(f"2 * {vector} = {result2}")  # Output: 2 * Vector(3, 4) = Vector(6, 8)
print()

# 9. __bool__
print("9. __BOOL__")
print("-" * 60)
class BankAccount:
    def __init__(self, balance):
        self.balance = balance
    
    def __bool__(self):
        return self.balance > 0
    
    def __str__(self):
        return f"Balance: ${self.balance}"

account1 = BankAccount(100)
account2 = BankAccount(0)

print(f"{account1}: {bool(account1)}")  # Output: Balance: $100: True
print(f"{account2}: {bool(account2)}")  # Output: Balance: $0: False
print()

# 10. __getitem__ and __setitem__
print("10. __GETITEM__ AND __SETITEM__")
print("-" * 60)
class MyList:
    def __init__(self, items=None):
        if items is None:
            self.items = []
        else:
            self.items = list(items)
    
    def __getitem__(self, index):
        return self.items[index]
    
    def __setitem__(self, index, value):
        self.items[index] = value
    
    def __len__(self):
        return len(self.items)
    
    def __str__(self):
        return str(self.items)

my_list = MyList([1, 2, 3, 4, 5])
print(f"Original: {my_list}")
print(f"my_list[0]: {my_list[0]}")

my_list[1] = 10
print(f"After my_list[1] = 10: {my_list}")
print()

# 11. __contains__
print("11. __CONTAINS__")
print("-" * 60)
class MyList:
    def __init__(self, items=None):
        if items is None:
            self.items = []
        else:
            self.items = list(items)
    
    def __contains__(self, item):
        return item in self.items
    
    def __str__(self):
        return str(self.items)

my_list = MyList([1, 2, 3, 4, 5])
print(f"List: {my_list}")
print(f"3 in my_list: {3 in my_list}")    # Output: True
print(f"10 in my_list: {10 in my_list}")   # Output: False
print()

# 12. __call__
print("12. __CALL__")
print("-" * 60)
class Multiplier:
    def __init__(self, factor):
        self.factor = factor
    
    def __call__(self, number):
        return number * self.factor

multiply_by_5 = Multiplier(5)
result = multiply_by_5(10)

print(f"multiply_by_5(10) = {result}")  # Output: multiply_by_5(10) = 50
print()

# 13. __iter__ and __next__
print("13. __ITER__ AND __NEXT__")
print("-" * 60)
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

print("Countdown from 5:")
for number in Countdown(5):
    print(number, end=" ")
print()
print()

# 14. Complete Example: Fraction Class
print("14. COMPLETE EXAMPLE: FRACTION CLASS")
print("-" * 60)
class Fraction:
    def __init__(self, numerator, denominator=1):
        if denominator == 0:
            raise ValueError("Denominator cannot be zero")
        self.numerator = numerator
        self.denominator = denominator
        self._simplify()
    
    def _simplify(self):
        from math import gcd
        common = gcd(self.numerator, self.denominator)
        self.numerator //= common
        self.denominator //= common
    
    def __str__(self):
        if self.denominator == 1:
            return str(self.numerator)
        return f"{self.numerator}/{self.denominator}"
    
    def __repr__(self):
        return f"Fraction({self.numerator}, {self.denominator})"
    
    def __add__(self, other):
        if not isinstance(other, Fraction):
            other = Fraction(other)
        new_num = self.numerator * other.denominator + other.numerator * self.denominator
        new_den = self.denominator * other.denominator
        return Fraction(new_num, new_den)
    
    def __eq__(self, other):
        if not isinstance(other, Fraction):
            other = Fraction(other)
        return self.numerator == other.numerator and self.denominator == other.denominator
    
    def __lt__(self, other):
        if not isinstance(other, Fraction):
            other = Fraction(other)
        return self.numerator * other.denominator < other.numerator * self.denominator

f1 = Fraction(1, 2)
f2 = Fraction(1, 4)

print(f"{f1} + {f2} = {f1 + f2}")
print(f"{f1} == {f2}: {f1 == f2}")
print(f"{f1} < {f2}: {f1 < f2}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
SPECIAL METHODS PRACTICE
============================================================

1. __INIT__ AND __STR__
------------------------------------------------------------
Alice, 30 years old

[... rest of output ...]
```

**Challenge** (Optional):
- Create a `Complex` class with arithmetic operations
- Build a `Matrix` class with addition and multiplication
- Create a `Time` class with comparison and arithmetic
- Design a `Polynomial` class with operations

---

## Key Takeaways

1. **Special methods** (dunder methods) customize object behavior
2. **`__init__`** is the constructor called when object is created
3. **`__str__`** provides user-friendly string representation
4. **`__repr__`** provides developer-friendly string representation (should be unambiguous)
5. **Comparison methods** (`__eq__`, `__lt__`, etc.) define how objects compare
6. **`__len__`** makes objects work with `len()` function
7. **Arithmetic methods** (`__add__`, `__sub__`, etc.) enable operator overloading
8. **Return `NotImplemented`** for unsupported types in operator methods
9. **`__rmul__`** etc. handle right-side operations (e.g., `2 * obj`)
10. **`__bool__`** defines truthiness of objects
11. **`__getitem__` and `__setitem__`** enable indexing
12. **`__contains__`** enables `in` operator
13. **`__call__`** makes objects callable
14. **`__iter__` and `__next__`** enable iteration
15. **Always define `__repr__`** for debugging

---

## Quiz: Special Methods

Test your understanding with these questions:

1. **What method is called when an object is created?**
   - A) `__new__`
   - B) `__init__`
   - C) `__create__`
   - D) `__start__`

2. **What does `__str__` return?**
   - A) Developer-friendly representation
   - B) User-friendly representation
   - C) Object ID
   - D) Class name

3. **What should `__repr__` ideally return?**
   - A) User-friendly string
   - B) Valid Python code to recreate object
   - C) Object memory address
   - D) Class name

4. **What method enables `len(obj)`?**
   - A) `__length__`
   - B) `__len__`
   - C) `__size__`
   - D) `__count__`

5. **What method enables `obj1 + obj2`?**
   - A) `__plus__`
   - B) `__add__`
   - C) `__sum__`
   - D) `__concat__`

6. **What should you return for unsupported types in operator methods?**
   - A) `None`
   - B) `False`
   - C) `NotImplemented`
   - D) `raise TypeError`

7. **What method enables `obj1 == obj2`?**
   - A) `__equal__`
   - B) `__eq__`
   - C) `__compare__`
   - D) `__same__`

8. **What method enables `obj[index]`?**
   - A) `__index__`
   - B) `__getitem__`
   - C) `__get__`
   - D) `__item__`

9. **What method makes an object callable?**
   - A) `__callable__`
   - B) `__call__`
   - C) `__invoke__`
   - D) `__execute__`

10. **What method enables `item in obj`?**
    - A) `__in__`
    - B) `__contains__`
    - C) `__has__`
    - D) `__member__`

**Answers**:
1. B) `__init__` (constructor method called on object creation)
2. B) User-friendly representation (called by `str()` and `print()`)
3. B) Valid Python code to recreate object (should be unambiguous)
4. B) `__len__` (enables `len()` function)
5. B) `__add__` (enables addition operator)
6. C) `NotImplemented` (tells Python to try other methods)
7. B) `__eq__` (enables equality comparison)
8. B) `__getitem__` (enables indexing)
9. B) `__call__` (makes object callable like a function)
10. B) `__contains__` (enables `in` operator)

---

## Next Steps

Excellent work! You've mastered special methods. You now understand:
- How to use `__init__` for initialization
- How to implement `__str__` and `__repr__`
- How to implement comparison methods
- How to implement arithmetic operations
- How to use other special methods

**What's Next?**
- Lesson 8.4: Inheritance
- Learn about single and multiple inheritance
- Understand method overriding
- Explore polymorphism

---

## Additional Resources

- **Special Method Names**: [docs.python.org/3/reference/datamodel.html#special-method-names](https://docs.python.org/3/reference/datamodel.html#special-method-names)
- **Operator Overloading**: Research how to overload operators in Python
- **Data Model**: [docs.python.org/3/reference/datamodel.html](https://docs.python.org/3/reference/datamodel.html)

---

*Lesson completed! You're ready to move on to the next lesson.*

