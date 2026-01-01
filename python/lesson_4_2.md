# Lesson 4.2: Sets

## Learning Objectives

By the end of this lesson, you will be able to:
- Create sets in Python
- Understand set characteristics (unordered, unique elements)
- Perform set operations (union, intersection, difference, symmetric difference)
- Use common set methods
- Understand when to use sets vs lists
- Apply sets in practical programming scenarios
- Work with set comprehensions
- Understand frozen sets

---

## Introduction to Sets

A **set** is an unordered, mutable collection of unique elements in Python. Sets are useful for membership testing, removing duplicates, and performing mathematical set operations like union, intersection, and difference.

### Key Characteristics of Sets

1. **Unordered**: Elements don't have a defined order
2. **Mutable**: Can be modified after creation (except frozen sets)
3. **Unique Elements**: No duplicate values allowed
4. **Hashable Elements**: Elements must be immutable (strings, numbers, tuples)
5. **Fast Membership Testing**: O(1) average time complexity
6. **Mathematical Operations**: Support union, intersection, difference, etc.

---

## Creating Sets

### Basic Set Creation

**Method 1: Using curly braces `{}`**:
```python
# Empty set (note: {} creates empty dict, not set!)
empty_set = set()  # Must use set() for empty set
print(empty_set)   # Output: set()

# Set with elements
fruits = {"apple", "banana", "orange"}
print(fruits)  # Output: {'apple', 'banana', 'orange'} (order may vary)

# Duplicates are automatically removed
numbers = {1, 2, 3, 2, 1, 4}
print(numbers)  # Output: {1, 2, 3, 4} (duplicates removed)
```

**Method 2: Using the `set()` constructor**:
```python
# From a list
numbers = set([1, 2, 3, 4, 5])
print(numbers)  # Output: {1, 2, 3, 4, 5}

# From a string (creates set of characters)
chars = set("hello")
print(chars)  # Output: {'h', 'e', 'l', 'o'} (duplicates removed)

# From a tuple
numbers = set((1, 2, 3, 4, 5))
print(numbers)  # Output: {1, 2, 3, 4, 5}

# Empty set
empty = set()
print(empty)  # Output: set()
```

**Method 3: Set comprehension** (covered later):
```python
# Squares
squares = {x**2 for x in range(5)}
print(squares)  # Output: {0, 1, 4, 9, 16}
```

### Important: Empty Set Syntax

```python
# Wrong - this creates an empty dictionary!
not_a_set = {}
print(type(not_a_set))  # <class 'dict'>

# Correct - use set() for empty set
is_a_set = set()
print(type(is_a_set))  # <class 'set'>
```

### Set Examples

```python
# Set of strings
fruits = {"apple", "banana", "orange", "grape"}

# Set of numbers
numbers = {1, 2, 3, 4, 5}

# Mixed types (all must be hashable)
mixed = {1, "hello", 3.14, (1, 2)}

# Cannot have mutable elements
# invalid = {1, [2, 3]}  # TypeError: unhashable type: 'list'
# invalid = {1, {2, 3}}  # TypeError: unhashable type: 'set'
```

---

## Set Characteristics

### Unordered Nature

Sets don't maintain insertion order (though Python 3.7+ may preserve it in some cases):

```python
# Order may vary
my_set = {3, 1, 4, 1, 5, 9, 2, 6}
print(my_set)  # Output may vary: {1, 2, 3, 4, 5, 6, 9}

# Don't rely on order!
```

### Unique Elements

Sets automatically remove duplicates:

```python
# Duplicates are removed
numbers = {1, 2, 3, 2, 1, 4, 3, 5}
print(numbers)  # Output: {1, 2, 3, 4, 5}

# Useful for removing duplicates from a list
numbers_list = [1, 2, 3, 2, 1, 4, 3, 5]
unique_numbers = list(set(numbers_list))
print(unique_numbers)  # Output: [1, 2, 3, 4, 5] (order may vary)
```

### Hashable Elements Only

Set elements must be hashable (immutable):

```python
# Valid elements
valid_set = {1, 2, 3, "hello", (1, 2)}

# Invalid elements
# invalid_set = {1, [2, 3]}      # TypeError: unhashable type: 'list'
# invalid_set = {1, {2, 3}}      # TypeError: unhashable type: 'set'
# invalid_set = {1, {"a": 1}}   # TypeError: unhashable type: 'dict'
```

---

## Accessing Set Elements

Sets don't support indexing because they're unordered:

```python
fruits = {"apple", "banana", "orange"}

# Cannot use indexing
# print(fruits[0])  # TypeError: 'set' object is not subscriptable

# Can check membership
print("apple" in fruits)   # Output: True
print("grape" in fruits)   # Output: False
print("banana" not in fruits)  # Output: False

# Can iterate
for fruit in fruits:
    print(fruit)
```

---

## Modifying Sets

### Adding Elements

**1. `.add(element)`** - Adds a single element:
```python
fruits = {"apple", "banana"}
fruits.add("orange")
print(fruits)  # Output: {'apple', 'banana', 'orange'}

# Adding duplicate has no effect
fruits.add("apple")
print(fruits)  # Output: {'apple', 'banana', 'orange'} (no change)
```

**2. `.update(iterable)`** - Adds multiple elements:
```python
fruits = {"apple", "banana"}
fruits.update(["orange", "grape"])
print(fruits)  # Output: {'apple', 'banana', 'orange', 'grape'}

# Can update with any iterable
fruits.update(("kiwi", "mango"))
print(fruits)

# Can update with another set
more_fruits = {"cherry", "date"}
fruits.update(more_fruits)
print(fruits)
```

### Removing Elements

**1. `.remove(element)`** - Removes element, raises KeyError if not found:
```python
fruits = {"apple", "banana", "orange"}
fruits.remove("banana")
print(fruits)  # Output: {'apple', 'orange'}

# Error if element doesn't exist
# fruits.remove("grape")  # KeyError: 'grape'
```

**2. `.discard(element)`** - Removes element, no error if not found:
```python
fruits = {"apple", "banana", "orange"}
fruits.discard("banana")
print(fruits)  # Output: {'apple', 'orange'}

# No error if element doesn't exist
fruits.discard("grape")  # No error, set unchanged
print(fruits)  # Output: {'apple', 'orange'}
```

**3. `.pop()`** - Removes and returns arbitrary element:
```python
fruits = {"apple", "banana", "orange"}
item = fruits.pop()
print(item)     # Output: arbitrary element (e.g., 'apple')
print(fruits)   # Output: remaining elements

# Error if set is empty
# empty_set = set()
# empty_set.pop()  # KeyError: 'pop from an empty set'
```

**4. `.clear()`** - Removes all elements:
```python
fruits = {"apple", "banana", "orange"}
fruits.clear()
print(fruits)  # Output: set()
```

---

## Set Operations

Sets support mathematical set operations.

### Union (| or .union())

Combines elements from both sets:

```python
set1 = {1, 2, 3}
set2 = {3, 4, 5}

# Using | operator
union = set1 | set2
print(union)  # Output: {1, 2, 3, 4, 5}

# Using .union() method
union = set1.union(set2)
print(union)  # Output: {1, 2, 3, 4, 5}

# Multiple sets
set3 = {5, 6, 7}
union = set1 | set2 | set3
print(union)  # Output: {1, 2, 3, 4, 5, 6, 7}
```

### Intersection (& or .intersection())

Returns elements common to both sets:

```python
set1 = {1, 2, 3, 4}
set2 = {3, 4, 5, 6}

# Using & operator
intersection = set1 & set2
print(intersection)  # Output: {3, 4}

# Using .intersection() method
intersection = set1.intersection(set2)
print(intersection)  # Output: {3, 4}
```

### Difference (- or .difference())

Returns elements in first set but not in second:

```python
set1 = {1, 2, 3, 4}
set2 = {3, 4, 5, 6}

# Using - operator
difference = set1 - set2
print(difference)  # Output: {1, 2}

# Using .difference() method
difference = set1.difference(set2)
print(difference)  # Output: {1, 2}

# Note: Not symmetric
difference2 = set2 - set1
print(difference2)  # Output: {5, 6}
```

### Symmetric Difference (^ or .symmetric_difference())

Returns elements in either set, but not in both:

```python
set1 = {1, 2, 3, 4}
set2 = {3, 4, 5, 6}

# Using ^ operator
symmetric = set1 ^ set2
print(symmetric)  # Output: {1, 2, 5, 6}

# Using .symmetric_difference() method
symmetric = set1.symmetric_difference(set2)
print(symmetric)  # Output: {1, 2, 5, 6}
```

### In-Place Operations

Sets support in-place operations:

```python
set1 = {1, 2, 3}
set2 = {3, 4, 5}

# In-place union
set1 |= set2  # Same as set1 = set1 | set2
print(set1)   # Output: {1, 2, 3, 4, 5}

# In-place intersection
set1 = {1, 2, 3, 4}
set1 &= {3, 4, 5}  # Same as set1 = set1 & {3, 4, 5}
print(set1)        # Output: {3, 4}

# In-place difference
set1 = {1, 2, 3, 4}
set1 -= {3, 4}  # Same as set1 = set1 - {3, 4}
print(set1)     # Output: {1, 2}
```

---

## Set Methods

### Membership and Comparison

**1. `.issubset(other)` or `<=`** - Checks if set is subset:
```python
set1 = {1, 2, 3}
set2 = {1, 2, 3, 4, 5}

print(set1.issubset(set2))  # Output: True
print(set1 <= set2)        # Output: True
```

**2. `.issuperset(other)` or `>=`** - Checks if set is superset:
```python
set1 = {1, 2, 3, 4, 5}
set2 = {1, 2, 3}

print(set1.issuperset(set2))  # Output: True
print(set1 >= set2)           # Output: True
```

**3. `.isdisjoint(other)`** - Checks if sets have no common elements:
```python
set1 = {1, 2, 3}
set2 = {4, 5, 6}
set3 = {3, 4, 5}

print(set1.isdisjoint(set2))  # Output: True (no common elements)
print(set1.isdisjoint(set3))  # Output: False (has common element 3)
```

### Other Methods

**1. `.copy()`** - Creates shallow copy:
```python
original = {1, 2, 3}
copy = original.copy()
copy.add(4)
print(original)  # Output: {1, 2, 3}
print(copy)      # Output: {1, 2, 3, 4}
```

**2. `len(set)`** - Returns number of elements:
```python
numbers = {1, 2, 3, 4, 5}
print(len(numbers))  # Output: 5
```

---

## Set Comprehensions

Set comprehensions provide a concise way to create sets.

### Basic Syntax

```python
# Traditional way
squares = set()
for x in range(5):
    squares.add(x**2)
print(squares)  # Output: {0, 1, 4, 9, 16}

# Set comprehension
squares = {x**2 for x in range(5)}
print(squares)  # Output: {0, 1, 4, 9, 16}
```

### Examples

```python
# Squares
squares = {x**2 for x in range(1, 6)}
print(squares)  # Output: {1, 4, 9, 16, 25}

# Even numbers
evens = {x for x in range(10) if x % 2 == 0}
print(evens)  # Output: {0, 2, 4, 6, 8}

# Uppercase characters
text = "Hello World"
uppercase = {char.upper() for char in text if char.isalpha()}
print(uppercase)  # Output: {'H', 'E', 'L', 'O', 'W', 'R', 'D'}
```

---

## Frozen Sets

**Frozen sets** are immutable sets. They're useful when you need an immutable set (e.g., as dictionary keys).

### Creating Frozen Sets

```python
# Using frozenset()
frozen = frozenset([1, 2, 3, 4, 5])
print(frozen)  # Output: frozenset({1, 2, 3, 4, 5})

# Cannot modify
# frozen.add(6)  # AttributeError: 'frozenset' object has no attribute 'add'
# frozen.remove(1)  # AttributeError
```

### Using Frozen Sets as Dictionary Keys

```python
# Regular sets cannot be dictionary keys
# invalid = {{1, 2}: "value"}  # TypeError: unhashable type: 'set'

# Frozen sets can be dictionary keys
valid = {frozenset([1, 2]): "value"}
print(valid)  # Output: {frozenset({1, 2}): 'value'}
```

---

## Sets vs Lists

### When to Use Sets

- **Removing duplicates** from a collection
- **Fast membership testing** (O(1) vs O(n) for lists)
- **Mathematical set operations** (union, intersection, etc.)
- **When order doesn't matter**
- **When you need unique elements**

### When to Use Lists

- **When order matters**
- **When you need indexing**
- **When duplicates are allowed**
- **When you need to modify elements in place**
- **When you need to maintain insertion order**

### Performance Comparison

```python
import time

# Large list
large_list = list(range(1000000))
large_set = set(range(1000000))

# Membership testing
target = 999999

# List (O(n))
start = time.time()
result = target in large_list
list_time = time.time() - start

# Set (O(1))
start = time.time()
result = target in large_set
set_time = time.time() - start

print(f"List time: {list_time:.6f} seconds")
print(f"Set time: {set_time:.6f} seconds")
print(f"Set is {list_time/set_time:.0f}x faster!")
```

---

## Practical Examples

### Example 1: Removing Duplicates

```python
# Remove duplicates from list
numbers = [1, 2, 3, 2, 1, 4, 3, 5]
unique = list(set(numbers))
print(unique)  # Output: [1, 2, 3, 4, 5] (order may vary)

# Preserve order (Python 3.7+)
unique_ordered = list(dict.fromkeys(numbers))
print(unique_ordered)  # Output: [1, 2, 3, 4, 5] (preserves order)
```

### Example 2: Finding Common Elements

```python
# Students in both classes
class_a = {"Alice", "Bob", "Charlie", "Diana"}
class_b = {"Bob", "Diana", "Eve", "Frank"}

# Students in both
both = class_a & class_b
print(f"Students in both classes: {both}")  # Output: {'Bob', 'Diana'}

# Students only in class A
only_a = class_a - class_b
print(f"Only in class A: {only_a}")  # Output: {'Alice', 'Charlie'}
```

### Example 3: Tag System

```python
# Blog posts with tags
posts = {
    "post1": {"python", "tutorial", "beginner"},
    "post2": {"python", "advanced", "optimization"},
    "post3": {"javascript", "tutorial", "beginner"}
}

# Find all unique tags
all_tags = set()
for tags in posts.values():
    all_tags |= tags
print(f"All tags: {all_tags}")

# Find posts with "python" tag
python_posts = [post for post, tags in posts.items() if "python" in tags]
print(f"Python posts: {python_posts}")
```

### Example 4: Permission System

```python
# User permissions
users = {
    "admin": {"read", "write", "delete", "manage"},
    "editor": {"read", "write"},
    "viewer": {"read"}
}

# Check if user has permission
def has_permission(user, permission):
    return permission in users.get(user, set())

print(has_permission("admin", "delete"))   # Output: True
print(has_permission("viewer", "write"))   # Output: False
```

---

## Common Mistakes and Pitfalls

### 1. Empty Set Syntax

```python
# Wrong - creates empty dictionary
empty = {}
print(type(empty))  # <class 'dict'>

# Correct
empty = set()
print(type(empty))  # <class 'set'>
```

### 2. Trying to Index Sets

```python
numbers = {1, 2, 3, 4, 5}
# print(numbers[0])  # TypeError: 'set' object is not subscriptable

# Solution: Convert to list if needed
numbers_list = list(numbers)
print(numbers_list[0])  # Works, but order may vary
```

### 3. Using Mutable Elements

```python
# Wrong
# invalid = {1, [2, 3]}  # TypeError: unhashable type: 'list'

# Correct - use tuples
valid = {1, (2, 3)}
```

### 4. Confusing remove() and discard()

```python
numbers = {1, 2, 3}

# remove() raises error if element doesn't exist
# numbers.remove(4)  # KeyError: 4

# discard() doesn't raise error
numbers.discard(4)  # No error, set unchanged
```

### 5. Relying on Order

```python
# Don't rely on set order (even if Python 3.7+ may preserve it)
numbers = {3, 1, 4, 1, 5}
# Order is not guaranteed!
```

---

## Practice Exercise

### Exercise: Set Operations Practice

**Objective**: Create a Python program that demonstrates various set operations and use cases.

**Instructions**:

1. Create a file called `set_practice.py`

2. Write a program that:
   - Creates sets in different ways
   - Performs set operations (union, intersection, difference)
   - Uses set methods
   - Implements practical set-based solutions
   - Demonstrates set comprehensions

3. Your program should include:
   - Removing duplicates
   - Finding common elements
   - Tag system
   - Permission system
   - Set operations

**Example Solution**:

```python
"""
Set Operations Practice
This program demonstrates various set operations and use cases.
"""

print("=" * 60)
print("SET OPERATIONS PRACTICE")
print("=" * 60)
print()

# 1. Creating Sets
print("1. CREATING SETS")
print("-" * 60)
# Empty set
empty = set()
print(f"Empty set: {empty}")

# Set with elements
fruits = {"apple", "banana", "orange"}
print(f"Fruits: {fruits}")

# From list (removes duplicates)
numbers = set([1, 2, 3, 2, 1, 4, 3, 5])
print(f"Numbers (duplicates removed): {numbers}")

# From string
chars = set("hello")
print(f"Characters in 'hello': {chars}")
print()

# 2. Set Operations
print("2. SET OPERATIONS")
print("-" * 60)
set1 = {1, 2, 3, 4}
set2 = {3, 4, 5, 6}

print(f"Set 1: {set1}")
print(f"Set 2: {set2}")

# Union
union = set1 | set2
print(f"Union (|): {union}")

# Intersection
intersection = set1 & set2
print(f"Intersection (&): {intersection}")

# Difference
difference = set1 - set2
print(f"Difference (-): {difference}")

# Symmetric difference
symmetric = set1 ^ set2
print(f"Symmetric difference (^): {symmetric}")
print()

# 3. Set Methods
print("3. SET METHODS")
print("-" * 60)
fruits = {"apple", "banana", "orange"}

# Add
fruits.add("grape")
print(f"After add('grape'): {fruits}")

# Update
fruits.update(["kiwi", "mango"])
print(f"After update(['kiwi', 'mango']): {fruits}")

# Remove
fruits.remove("kiwi")
print(f"After remove('kiwi'): {fruits}")

# Discard (no error if not found)
fruits.discard("xyz")
print(f"After discard('xyz'): {fruits}")

# Pop
item = fruits.pop()
print(f"Popped: {item}")
print(f"After pop(): {fruits}")
print()

# 4. Membership Testing
print("4. MEMBERSHIP TESTING")
print("-" * 60)
fruits = {"apple", "banana", "orange"}

print(f"'apple' in fruits: {'apple' in fruits}")
print(f"'grape' in fruits: {'grape' in fruits}")
print(f"'banana' not in fruits: {'banana' not in fruits}")

# Fast membership testing
large_set = set(range(1000000))
print(f"\nTesting membership in large set (1M elements):")
import time
start = time.time()
result = 999999 in large_set
set_time = time.time() - start
print(f"Time: {set_time:.6f} seconds (very fast!)")
print()

# 5. Removing Duplicates
print("5. REMOVING DUPLICATES")
print("-" * 60)
numbers = [1, 2, 3, 2, 1, 4, 3, 5, 2, 1]
print(f"Original list: {numbers}")

# Using set
unique = list(set(numbers))
print(f"Unique (using set): {unique}")

# Preserving order (Python 3.7+)
unique_ordered = list(dict.fromkeys(numbers))
print(f"Unique (preserving order): {unique_ordered}")
print()

# 6. Finding Common Elements
print("6. FINDING COMMON ELEMENTS")
print("-" * 60)
class_a = {"Alice", "Bob", "Charlie", "Diana", "Eve"}
class_b = {"Bob", "Diana", "Eve", "Frank", "Grace"}

print(f"Class A: {class_a}")
print(f"Class B: {class_b}")

# In both
both = class_a & class_b
print(f"Students in both classes: {both}")

# Only in A
only_a = class_a - class_b
print(f"Only in class A: {only_a}")

# Only in B
only_b = class_b - class_a
print(f"Only in class B: {only_b}")

# In either (union)
either = class_a | class_b
print(f"Students in either class: {either}")
print()

# 7. Set Comprehensions
print("7. SET COMPREHENSIONS")
print("-" * 60)
# Squares
squares = {x**2 for x in range(1, 6)}
print(f"Squares: {squares}")

# Even numbers
evens = {x for x in range(10) if x % 2 == 0}
print(f"Even numbers: {evens}")

# Uppercase characters
text = "Hello World"
uppercase = {char.upper() for char in text if char.isalpha()}
print(f"Uppercase letters in '{text}': {uppercase}")
print()

# 8. Tag System
print("8. TAG SYSTEM")
print("-" * 60)
posts = {
    "post1": {"python", "tutorial", "beginner"},
    "post2": {"python", "advanced", "optimization"},
    "post3": {"javascript", "tutorial", "beginner"},
    "post4": {"python", "javascript", "web"}
}

print("Posts and tags:")
for post, tags in posts.items():
    print(f"  {post}: {tags}")

# All unique tags
all_tags = set()
for tags in posts.values():
    all_tags |= tags
print(f"\nAll unique tags: {all_tags}")

# Posts with "python" tag
python_posts = [post for post, tags in posts.items() if "python" in tags]
print(f"Posts with 'python' tag: {python_posts}")

# Posts with both "python" and "tutorial"
python_tutorial = [post for post, tags in posts.items() 
                   if "python" in tags and "tutorial" in tags]
print(f"Posts with both 'python' and 'tutorial': {python_tutorial}")
print()

# 9. Permission System
print("9. PERMISSION SYSTEM")
print("-" * 60)
users = {
    "admin": {"read", "write", "delete", "manage"},
    "editor": {"read", "write"},
    "viewer": {"read"}
}

def has_permission(user, permission):
    return permission in users.get(user, set())

def has_all_permissions(user, *permissions):
    user_perms = users.get(user, set())
    return all(perm in user_perms for perm in permissions)

print("Permission checks:")
print(f"  admin can delete: {has_permission('admin', 'delete')}")
print(f"  viewer can write: {has_permission('viewer', 'write')}")
print(f"  editor can read: {has_permission('editor', 'read')}")
print(f"  admin has read and write: {has_all_permissions('admin', 'read', 'write')}")
print()

# 10. Set Comparison Methods
print("10. SET COMPARISON METHODS")
print("-" * 60)
set1 = {1, 2, 3}
set2 = {1, 2, 3, 4, 5}
set3 = {4, 5, 6}

print(f"Set 1: {set1}")
print(f"Set 2: {set2}")
print(f"Set 3: {set3}")

print(f"\nSet 1 is subset of Set 2: {set1.issubset(set2)}")
print(f"Set 2 is superset of Set 1: {set2.issuperset(set1)}")
print(f"Set 1 and Set 3 are disjoint: {set1.isdisjoint(set3)}")
print()

# 11. Frozen Sets
print("11. FROZEN SETS")
print("-" * 60)
frozen = frozenset([1, 2, 3, 4, 5])
print(f"Frozen set: {frozen}")

# Cannot modify
# frozen.add(6)  # AttributeError

# Can use as dictionary key
valid_dict = {frozen: "This is a frozen set"}
print(f"Dictionary with frozen set key: {valid_dict}")
print()

# 12. Practical: Survey Analysis
print("12. PRACTICAL: SURVEY ANALYSIS")
print("-" * 60)
# People who like different programming languages
python_lovers = {"Alice", "Bob", "Charlie", "Diana"}
javascript_lovers = {"Bob", "Diana", "Eve", "Frank"}
java_lovers = {"Charlie", "Diana", "Grace", "Henry"}

# People who like only Python
only_python = python_lovers - javascript_lovers - java_lovers
print(f"Only Python: {only_python}")

# People who like all three
all_three = python_lovers & javascript_lovers & java_lovers
print(f"All three languages: {all_three}")

# People who like at least one
at_least_one = python_lovers | javascript_lovers | java_lovers
print(f"At least one language: {at_least_one}")

# People who like exactly two
python_js = python_lovers & javascript_lovers
python_java = python_lovers & java_lovers
js_java = javascript_lovers & java_lovers
exactly_two = (python_js | python_java | js_java) - all_three
print(f"Exactly two languages: {exactly_two}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
SET OPERATIONS PRACTICE
============================================================

1. CREATING SETS
------------------------------------------------------------
Empty set: set()
Fruits: {'apple', 'banana', 'orange'}
Numbers (duplicates removed): {1, 2, 3, 4, 5}
Characters in 'hello': {'h', 'e', 'l', 'o'}

[... rest of output ...]
```

**Challenge** (Optional):
- Create a more complex permission system
- Build a recommendation system using set operations
- Implement a tag-based search system
- Create a social network friend suggestion system
- Build a data deduplication tool

---

## Key Takeaways

1. **Sets store unique, unordered elements** and provide fast O(1) membership testing
2. **Use `set()` for empty sets**, not `{}` (which creates a dict)
3. **Set elements must be hashable** (immutable: strings, numbers, tuples)
4. **Set operations**: union (`|`), intersection (`&`), difference (`-`), symmetric difference (`^`)
5. **Use sets for**: removing duplicates, fast membership testing, set operations
6. **Use lists for**: ordered data, indexing, when duplicates are needed
7. **Set methods**: `.add()`, `.remove()`, `.discard()`, `.update()`, `.pop()`
8. **Set comprehensions** provide concise set creation
9. **Frozen sets** are immutable and can be dictionary keys
10. **Sets automatically remove duplicates** - useful for deduplication

---

## Quiz: Sets

Test your understanding with these questions:

1. **How do you create an empty set?**
   - A) `{}`
   - B) `set()`
   - C) `[]`
   - D) Both A and B

2. **What happens to duplicates when creating a set?**
   - A) They cause an error
   - B) They are automatically removed
   - C) They are kept
   - D) Only first duplicate is kept

3. **What is the result of `{1, 2, 3} | {3, 4, 5}`?**
   - A) `{1, 2, 3, 4, 5}`
   - B) `{3}`
   - C) `{1, 2, 4, 5}`
   - D) Error

4. **What is the result of `{1, 2, 3} & {3, 4, 5}`?**
   - A) `{1, 2, 3, 4, 5}`
   - B) `{3}`
   - C) `{1, 2, 4, 5}`
   - D) Error

5. **Can you index a set like `my_set[0]`?**
   - A) Yes
   - B) No
   - C) Only if set has one element
   - D) Only in Python 2

6. **What is the difference between `.remove()` and `.discard()`?**
   - A) No difference
   - B) `.remove()` raises error if element doesn't exist, `.discard()` doesn't
   - C) `.discard()` raises error if element doesn't exist, `.remove()` doesn't
   - D) `.remove()` is faster

7. **Which of these can be a set element?**
   - A) List
   - B) Dictionary
   - C) Tuple
   - D) Set

8. **What does `{1, 2, 3} - {2, 3, 4}` return?**
   - A) `{1}`
   - B) `{4}`
   - C) `{1, 4}`
   - D) `{1, 2, 3, 4}`

9. **What is a frozen set?**
   - A) A set that's been sorted
   - B) An immutable set
   - C) A set with only numbers
   - D) A set that can't be modified

10. **When should you use a set instead of a list?**
    - A) When you need fast membership testing
    - B) When you need to remove duplicates
    - C) When order doesn't matter
    - D) All of the above

**Answers**:
1. B) `set()` (`{}` creates an empty dictionary)
2. B) They are automatically removed (sets only store unique elements)
3. A) `{1, 2, 3, 4, 5}` (union combines all elements)
4. B) `{3}` (intersection returns common elements)
5. B) No (sets are unordered and not subscriptable)
6. B) `.remove()` raises error if element doesn't exist, `.discard()` doesn't
7. C) Tuple (must be hashable/immutable)
8. A) `{1}` (difference: elements in first but not in second)
9. B) An immutable set (cannot be modified after creation)
10. D) All of the above (sets are great for these use cases)

---

## Next Steps

Excellent work! You've mastered sets. You now understand:
- How to create and manipulate sets
- Set operations (union, intersection, difference, symmetric difference)
- Set methods and operations
- When to use sets vs lists
- Set comprehensions
- Frozen sets
- Practical applications

**What's Next?**
- Module 5: Control Flow
- Practice building more set-based programs
- Learn about advanced set operations
- Explore real-world set applications

---

## Additional Resources

- **Python Sets**: [docs.python.org/3/tutorial/datastructures.html#sets](https://docs.python.org/3/tutorial/datastructures.html#sets)
- **Set Methods**: [docs.python.org/3/library/stdtypes.html#set](https://docs.python.org/3/library/stdtypes.html#set)
- **Set Comprehensions**: [docs.python.org/3/tutorial/datastructures.html#sets](https://docs.python.org/3/tutorial/datastructures.html#sets)

---

*Lesson completed! You're ready to move on to the next lesson.*

