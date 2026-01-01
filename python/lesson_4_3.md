# Lesson 4.3: Choosing the Right Data Structure

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the characteristics of each Python data structure
- Know when to use lists, tuples, dictionaries, or sets
- Compare data structures based on use cases
- Make informed decisions about data structure selection
- Understand performance implications of different structures
- Apply best practices for data structure selection
- Recognize common patterns and anti-patterns

---

## Introduction

Choosing the right data structure is crucial for writing efficient, readable, and maintainable Python code. Each data structure has its strengths and weaknesses, and understanding when to use each one will make you a better programmer.

### Data Structures Overview

Python provides four main built-in data structures:

1. **Lists** - Ordered, mutable sequences
2. **Tuples** - Ordered, immutable sequences
3. **Dictionaries** - Key-value mappings
4. **Sets** - Unordered collections of unique elements

---

## Lists

### Characteristics

- **Ordered**: Maintains insertion order
- **Mutable**: Can be modified after creation
- **Indexed**: Access elements by position (0-based)
- **Allows duplicates**: Same value can appear multiple times
- **Heterogeneous**: Can contain different data types

### When to Use Lists

✅ **Use lists when**:
- You need to maintain order
- You need to access elements by index
- You need to modify the collection (add, remove, change elements)
- Duplicates are allowed or needed
- You need to iterate in a specific order
- You're building a sequence that changes over time

### Common Use Cases

```python
# Shopping cart (order matters, can add/remove items)
shopping_cart = ["apple", "banana", "orange"]
shopping_cart.append("grape")

# Student scores (order might matter, can modify)
scores = [85, 92, 78, 96, 88]
scores.sort()

# To-do list (order matters, can reorder)
todos = ["Buy groceries", "Finish homework", "Call dentist"]

# Stack or queue implementation
stack = []
stack.append(1)  # Push
item = stack.pop()  # Pop
```

### Performance Considerations

- **Access by index**: O(1)
- **Search for element**: O(n)
- **Insert at end**: O(1) amortized
- **Insert at beginning/middle**: O(n)
- **Delete**: O(n)

---

## Tuples

### Characteristics

- **Ordered**: Maintains insertion order
- **Immutable**: Cannot be modified after creation
- **Indexed**: Access elements by position
- **Allows duplicates**: Same value can appear multiple times
- **Hashable**: Can be used as dictionary keys (if all elements are hashable)

### When to Use Tuples

✅ **Use tuples when**:
- Data should not be modified (immutability is desired)
- You need to use the collection as a dictionary key
- You're returning multiple values from a function
- You want to ensure data integrity
- You're working with fixed-size collections
- Performance is critical (slightly faster than lists)

### Common Use Cases

```python
# Coordinates (fixed, shouldn't change)
point = (10, 20)
x, y = point  # Unpacking

# RGB colors (fixed values)
red = (255, 0, 0)

# Function return values
def get_name_age():
    return "Alice", 25

name, age = get_name_age()

# Dictionary keys
locations = {
    (0, 0): "Origin",
    (1, 1): "Corner"
}

# Database records (immutable)
student = ("Alice", 25, 3.8)
```

### Performance Considerations

- **Access by index**: O(1)
- **Search for element**: O(n)
- **Creation**: Slightly faster than lists
- **Memory**: Slightly less memory than lists
- **Cannot modify**: No modification operations

---

## Dictionaries

### Characteristics

- **Unordered**: No guaranteed order (Python 3.7+ maintains insertion order)
- **Mutable**: Can be modified after creation
- **Key-Value Pairs**: Access by key, not index
- **Unique Keys**: No duplicate keys allowed
- **Fast Lookup**: O(1) average time complexity
- **Keys Must Be Hashable**: Immutable types only

### When to Use Dictionaries

✅ **Use dictionaries when**:
- You need to map keys to values
- You need fast lookups by key
- You're working with labeled data
- You need to count occurrences
- You're building a cache or lookup table
- You need to group related data by key
- You're working with JSON-like data

### Common Use Cases

```python
# Phone book (name -> number mapping)
phonebook = {
    "Alice": "555-1234",
    "Bob": "555-5678"
}

# Configuration settings
config = {
    "host": "localhost",
    "port": 8080,
    "debug": True
}

# Word counter
word_count = {}
for word in text.split():
    word_count[word] = word_count.get(word, 0) + 1

# Student records (labeled data)
student = {
    "name": "Alice",
    "age": 25,
    "gpa": 3.8
}

# Caching
cache = {}
def expensive_function(x):
    if x not in cache:
        cache[x] = compute(x)
    return cache[x]
```

### Performance Considerations

- **Access by key**: O(1) average
- **Insert/Update**: O(1) average
- **Delete**: O(1) average
- **Search for value**: O(n)
- **Memory**: More than lists/tuples (stores keys and values)

---

## Sets

### Characteristics

- **Unordered**: No guaranteed order
- **Mutable**: Can be modified (except frozen sets)
- **Unique Elements**: No duplicates allowed
- **Fast Membership Testing**: O(1) average
- **Hashable Elements**: Elements must be immutable
- **Set Operations**: Union, intersection, difference, etc.

### When to Use Sets

✅ **Use sets when**:
- You need to remove duplicates
- You need fast membership testing
- You need set operations (union, intersection, etc.)
- Order doesn't matter
- You're tracking unique items
- You're working with mathematical sets
- You need to check if items exist quickly

### Common Use Cases

```python
# Removing duplicates
numbers = [1, 2, 3, 2, 1, 4, 3, 5]
unique = list(set(numbers))

# Fast membership testing
valid_users = {"alice", "bob", "charlie"}
if username in valid_users:  # Very fast!
    print("Valid user")

# Finding common elements
students_class_a = {"Alice", "Bob", "Charlie"}
students_class_b = {"Bob", "Charlie", "Diana"}
both_classes = students_class_a & students_class_b

# Tag system
post_tags = {"python", "tutorial", "beginner"}
all_tags = set()
all_tags.update(post_tags)

# Permission checking
user_permissions = {"read", "write", "delete"}
if "write" in user_permissions:
    print("Can write")
```

### Performance Considerations

- **Membership test**: O(1) average (vs O(n) for lists)
- **Add/Remove**: O(1) average
- **Set operations**: Generally efficient
- **Memory**: More than lists (hash table overhead)
- **No indexing**: Cannot access by position

---

## Comparison Table

| Feature | List | Tuple | Dictionary | Set |
|---------|------|-------|------------|-----|
| **Ordered** | ✅ Yes | ✅ Yes | ⚠️ Insertion order (3.7+) | ❌ No |
| **Mutable** | ✅ Yes | ❌ No | ✅ Yes | ✅ Yes |
| **Indexed** | ✅ Yes | ✅ Yes | ❌ No (use keys) | ❌ No |
| **Duplicates** | ✅ Allowed | ✅ Allowed | ❌ Keys must be unique | ❌ Not allowed |
| **Access** | By index | By index | By key | Membership only |
| **Lookup Speed** | O(n) | O(n) | O(1) | O(1) |
| **Use Case** | Sequences | Fixed data | Key-value pairs | Unique items |
| **Hashable** | ❌ No | ✅ Yes* | ❌ No | ❌ No (frozenset is) |

*If all elements are hashable

---

## Decision Tree

### Step 1: Do you need key-value pairs?

**Yes** → Use **Dictionary**
- Phone book, configuration, JSON data, lookup tables

**No** → Continue to Step 2

### Step 2: Do you need unique elements?

**Yes** → Use **Set**
- Removing duplicates, membership testing, set operations

**No** → Continue to Step 3

### Step 3: Do you need to modify the collection?

**Yes** → Use **List**
- Shopping cart, to-do list, dynamic sequences

**No** → Use **Tuple**
- Coordinates, function returns, dictionary keys, fixed data

---

## Common Patterns and Examples

### Pattern 1: Counting Occurrences

```python
# Dictionary is best for counting
word_count = {}
for word in words:
    word_count[word] = word_count.get(word, 0) + 1

# Set is useful for tracking unique items
unique_words = set(words)
```

### Pattern 2: Grouping Data

```python
# Dictionary for grouping by key
students_by_grade = {
    "A": ["Alice", "Bob"],
    "B": ["Charlie", "Diana"]
}

# List of dictionaries for records
students = [
    {"name": "Alice", "grade": "A"},
    {"name": "Bob", "grade": "A"}
]
```

### Pattern 3: Removing Duplicates

```python
# Set is perfect for this
numbers = [1, 2, 3, 2, 1, 4, 3, 5]
unique = list(set(numbers))

# Preserve order (Python 3.7+)
unique_ordered = list(dict.fromkeys(numbers))
```

### Pattern 4: Fast Lookups

```python
# Dictionary for key-based lookup
user_data = {
    "alice": {"age": 25, "email": "alice@example.com"},
    "bob": {"age": 23, "email": "bob@example.com"}
}
user = user_data["alice"]  # O(1) lookup

# Set for membership testing
valid_ids = {1, 2, 3, 4, 5}
if user_id in valid_ids:  # O(1) lookup
    print("Valid")
```

### Pattern 5: Function Return Values

```python
# Tuple for multiple return values
def get_stats(numbers):
    return sum(numbers), len(numbers), max(numbers)

total, count, maximum = get_stats([1, 2, 3, 4, 5])

# Dictionary for named return values
def get_user_info(user_id):
    return {
        "name": "Alice",
        "age": 25,
        "email": "alice@example.com"
    }
```

---

## Performance Considerations

### Time Complexity Summary

| Operation | List | Tuple | Dictionary | Set |
|-----------|------|-------|------------|-----|
| **Access by index/key** | O(1) | O(1) | O(1) | N/A |
| **Search for element** | O(n) | O(n) | O(1)* | O(1)* |
| **Insert at end** | O(1) | N/A | O(1) | O(1) |
| **Insert at beginning** | O(n) | N/A | O(1) | O(1) |
| **Delete** | O(n) | N/A | O(1) | O(1) |
| **Membership test** | O(n) | O(n) | O(1)* | O(1)* |

*Average case, O(n) worst case

### Memory Considerations

- **Lists**: Store elements + overhead
- **Tuples**: Slightly less memory than lists
- **Dictionaries**: More memory (keys + values + hash table)
- **Sets**: More memory than lists (hash table overhead)

### When Performance Matters

```python
# Large dataset - use set for membership
large_list = list(range(1000000))
large_set = set(range(1000000))

# Slow with list
# 999999 in large_list  # O(n) - checks each element

# Fast with set
999999 in large_set  # O(1) - hash lookup
```

---

## Anti-Patterns (What NOT to Do)

### ❌ Using List for Membership Testing

```python
# Bad: O(n) lookup
valid_ids = [1, 2, 3, 4, 5]
if user_id in valid_ids:  # Slow for large lists!
    pass

# Good: O(1) lookup
valid_ids = {1, 2, 3, 4, 5}
if user_id in valid_ids:  # Fast!
    pass
```

### ❌ Using List for Key-Value Mapping

```python
# Bad: Slow lookup
data = [("name", "Alice"), ("age", 25)]
# Need to search through list to find value

# Good: Fast lookup
data = {"name": "Alice", "age": 25}
value = data["name"]  # O(1) lookup
```

### ❌ Modifying Tuples

```python
# Bad: Trying to modify tuple
coordinates = (10, 20)
# coordinates[0] = 15  # TypeError!

# Good: Create new tuple
coordinates = (15, 20)
```

### ❌ Using Dictionary When Order Matters and No Keys Needed

```python
# Bad: Using dict when list would work
items = {"0": "apple", "1": "banana", "2": "orange"}

# Good: Use list
items = ["apple", "banana", "orange"]
```

### ❌ Not Using Sets for Duplicate Removal

```python
# Bad: Manual duplicate removal
unique = []
for item in items:
    if item not in unique:  # O(n) check each time!
        unique.append(item)

# Good: Use set
unique = list(set(items))  # O(n) total
```

---

## Real-World Examples

### Example 1: E-Commerce Shopping Cart

```python
# List - order matters, can add/remove items
cart = [
    {"product": "Apple", "quantity": 3, "price": 0.99},
    {"product": "Banana", "quantity": 2, "price": 0.79}
]

# Can modify quantities
cart[0]["quantity"] = 5

# Can add items
cart.append({"product": "Orange", "quantity": 1, "price": 1.29})
```

### Example 2: User Authentication

```python
# Set - fast membership testing for valid users
valid_users = {"alice", "bob", "charlie"}

# Dictionary - store user data
users = {
    "alice": {"password": "hash1", "role": "admin"},
    "bob": {"password": "hash2", "role": "user"}
}

# Fast lookup
if username in valid_users:
    user_data = users[username]
```

### Example 3: Configuration Management

```python
# Dictionary - key-value pairs for settings
config = {
    "database": {
        "host": "localhost",
        "port": 5432,
        "name": "mydb"
    },
    "api": {
        "key": "secret",
        "timeout": 30
    }
}

# Easy access
db_host = config["database"]["host"]
```

### Example 4: Tag System

```python
# Set - unique tags, fast membership
post_tags = {"python", "tutorial", "beginner"}

# Dictionary - posts with tags
posts = {
    "post1": {"python", "tutorial"},
    "post2": {"python", "advanced"}
}

# Set operations
python_posts = [post for post, tags in posts.items() 
                if "python" in tags]  # Fast membership test
```

### Example 5: Coordinate System

```python
# Tuple - immutable coordinates
points = [(0, 0), (3, 4), (6, 8)]

# Dictionary - use tuples as keys
grid = {
    (0, 0): "Start",
    (3, 4): "Treasure",
    (6, 8): "End"
}

# Access
cell = grid.get((3, 4), "Empty")
```

---

## Best Practices

### 1. Choose Based on Use Case, Not Habit

```python
# Don't always use lists - think about what you need
# Need fast lookup? → Dictionary or Set
# Need order? → List or Tuple
# Need uniqueness? → Set
# Need key-value? → Dictionary
```

### 2. Consider Performance for Large Data

```python
# For large datasets, choose efficient structures
# Membership testing: Set > Dictionary > List
# Key lookup: Dictionary > List (search)
# Ordered access: List = Tuple > Dictionary/Set
```

### 3. Use Appropriate Immutability

```python
# Use tuples when data shouldn't change
coordinates = (10, 20)  # Immutable

# Use lists when you need to modify
shopping_cart = ["apple", "banana"]  # Mutable
```

### 4. Combine Structures When Needed

```python
# List of dictionaries
students = [
    {"name": "Alice", "grades": [85, 92, 78]},
    {"name": "Bob", "grades": [90, 88, 95]}
]

# Dictionary of lists
grades_by_subject = {
    "Math": [85, 90, 75],
    "Science": [92, 88, 80]
}

# Set of tuples
unique_points = {(0, 0), (3, 4), (6, 8)}
```

### 5. Document Your Choices

```python
# Good: Comment explains why
# Using set for O(1) membership testing
valid_users = {"alice", "bob", "charlie"}

# Using tuple for immutable coordinates
point = (10, 20)  # Immutable - safe to use as dict key
```

---

## Practice Exercise

### Exercise: Data Structure Selection

**Objective**: Analyze scenarios and choose the appropriate data structure.

**Instructions**:

1. For each scenario below, identify the best data structure and explain why.

2. Implement solutions using the chosen data structures.

**Scenarios**:

1. **Student Gradebook**: Store student names and their grades for multiple subjects
2. **Unique Visitors Tracker**: Track unique IP addresses that visited a website
3. **Shopping Cart**: Maintain ordered list of items with quantities
4. **Configuration File**: Store application settings (host, port, debug mode, etc.)
5. **Coordinate System**: Store 2D coordinates for a game board
6. **Tag System**: Track unique tags for blog posts
7. **Function Return**: Return multiple values from a calculation
8. **Cache System**: Store computed results for fast lookup
9. **Permission System**: Check if user has specific permissions
10. **Leaderboard**: Maintain ranked list of players and scores

**Example Solutions**:

```python
"""
Data Structure Selection Practice
Demonstrating appropriate data structure choices for different scenarios.
"""

print("=" * 60)
print("DATA STRUCTURE SELECTION PRACTICE")
print("=" * 60)
print()

# 1. Student Gradebook - Dictionary of Lists
print("1. STUDENT GRADEBOOK")
print("-" * 60)
# Dictionary: student name -> list of grades
grades = {
    "Alice": [85, 92, 78],
    "Bob": [90, 88, 95],
    "Charlie": [75, 80, 85]
}
print("Why: Need key-value mapping (name -> grades)")
print(f"Grades: {grades}")
print()

# 2. Unique Visitors - Set
print("2. UNIQUE VISITORS TRACKER")
print("-" * 60)
# Set: automatically handles uniqueness
visitors = {"192.168.1.1", "192.168.1.2", "192.168.1.1"}
print("Why: Need unique elements, fast membership testing")
print(f"Unique visitors: {visitors}")
print(f"Count: {len(visitors)}")
print()

# 3. Shopping Cart - List of Dictionaries
print("3. SHOPPING CART")
print("-" * 60)
# List: order matters, can add/remove
cart = [
    {"item": "Apple", "quantity": 3, "price": 0.99},
    {"item": "Banana", "quantity": 2, "price": 0.79}
]
print("Why: Order matters, need to modify")
print(f"Cart: {cart}")
print()

# 4. Configuration - Dictionary
print("4. CONFIGURATION FILE")
print("-" * 60)
# Dictionary: key-value pairs for settings
config = {
    "host": "localhost",
    "port": 8080,
    "debug": True,
    "timeout": 30
}
print("Why: Key-value mapping for settings")
print(f"Config: {config}")
print()

# 5. Coordinate System - Tuple (as dict keys)
print("5. COORDINATE SYSTEM")
print("-" * 60)
# Dictionary with tuple keys: immutable coordinates
grid = {
    (0, 0): "Start",
    (3, 4): "Treasure",
    (6, 8): "End"
}
print("Why: Tuples are immutable and hashable (can be dict keys)")
print(f"Grid: {grid}")
print()

# 6. Tag System - Set
print("6. TAG SYSTEM")
print("-" * 60)
# Set: unique tags, fast membership
post_tags = {"python", "tutorial", "beginner"}
print("Why: Need unique elements, fast membership testing")
print(f"Tags: {post_tags}")
print()

# 7. Function Return - Tuple
print("7. FUNCTION RETURN")
print("-" * 60)
# Tuple: multiple return values
def calculate_stats(numbers):
    return sum(numbers), len(numbers), max(numbers)

total, count, maximum = calculate_stats([1, 2, 3, 4, 5])
print("Why: Immutable, can unpack multiple values")
print(f"Stats: total={total}, count={count}, max={maximum}")
print()

# 8. Cache System - Dictionary
print("8. CACHE SYSTEM")
print("-" * 60)
# Dictionary: key (input) -> value (result)
cache = {}
def fibonacci(n):
    if n in cache:
        return cache[n]
    if n <= 1:
        result = n
    else:
        result = fibonacci(n-1) + fibonacci(n-2)
    cache[n] = result
    return result

print("Why: Fast O(1) lookup by key")
print(f"fib(10) = {fibonacci(10)}")
print(f"Cache: {cache}")
print()

# 9. Permission System - Set
print("9. PERMISSION SYSTEM")
print("-" * 60)
# Set: fast membership testing
user_permissions = {"read", "write", "delete"}
print("Why: Fast O(1) membership testing")
print(f"Can write: {'write' in user_permissions}")
print(f"Can manage: {'manage' in user_permissions}")
print()

# 10. Leaderboard - List of Tuples
print("10. LEADERBOARD")
print("-" * 60)
# List: order matters (ranking)
leaderboard = [
    ("Alice", 1000),
    ("Bob", 950),
    ("Charlie", 900)
]
print("Why: Order matters (ranking), tuples for immutable records")
print("Leaderboard:")
for rank, (name, score) in enumerate(leaderboard, 1):
    print(f"  {rank}. {name}: {score}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

---

## Key Takeaways

1. **Lists**: Use for ordered, mutable sequences where duplicates are allowed
2. **Tuples**: Use for immutable, ordered sequences (function returns, dict keys)
3. **Dictionaries**: Use for key-value mappings and fast lookups
4. **Sets**: Use for unique elements and fast membership testing
5. **Consider performance**: Sets and dictionaries offer O(1) lookups vs O(n) for lists
6. **Consider mutability**: Use tuples when data shouldn't change
7. **Consider order**: Use lists/tuples when order matters
8. **Combine structures**: Often need nested structures (list of dicts, dict of lists, etc.)
9. **Choose based on use case**: Not habit or preference
10. **Document your choices**: Explain why you chose a particular structure

---

## Quiz: Choosing the Right Data Structure

Test your understanding with these questions:

1. **What data structure should you use for a phone book (name -> number)?**
   - A) List
   - B) Tuple
   - C) Dictionary
   - D) Set

2. **What data structure is best for removing duplicates?**
   - A) List
   - B) Tuple
   - C) Dictionary
   - D) Set

3. **What data structure should you use for function return values?**
   - A) List
   - B) Tuple
   - C) Dictionary
   - D) Set

4. **What data structure offers O(1) membership testing?**
   - A) List
   - B) Tuple
   - C) Dictionary
   - D) Both C and D

5. **What data structure can be used as a dictionary key?**
   - A) List
   - B) Tuple
   - C) Dictionary
   - D) Set

6. **What data structure is best for a shopping cart?**
   - A) List
   - B) Tuple
   - C) Dictionary
   - D) Set

7. **What data structure is immutable?**
   - A) List
   - B) Tuple
   - C) Dictionary
   - D) Set

8. **What data structure is best for fast key-based lookups?**
   - A) List
   - B) Tuple
   - C) Dictionary
   - D) Set

9. **What data structure automatically removes duplicates?**
   - A) List
   - B) Tuple
   - C) Dictionary
   - D) Set

10. **What data structure maintains insertion order?**
    - A) List
    - B) Tuple
    - C) Dictionary (3.7+)
    - D) All of the above

**Answers**:
1. C) Dictionary (key-value mapping)
2. D) Set (automatically handles uniqueness)
3. B) Tuple (immutable, can unpack multiple values)
4. D) Both C and D (dictionaries and sets offer O(1) membership)
5. B) Tuple (immutable and hashable)
6. A) List (order matters, need to modify)
7. B) Tuple (immutable)
8. C) Dictionary (O(1) key lookup)
9. D) Set (only stores unique elements)
10. D) All of the above (lists, tuples always; dicts in Python 3.7+)

---

## Next Steps

Excellent work! You've learned how to choose the right data structure. You now understand:
- Characteristics of each data structure
- When to use lists, tuples, dictionaries, or sets
- Performance implications
- Common patterns and anti-patterns
- Best practices for data structure selection

**What's Next?**
- Module 5: Control Flow
- Practice building programs with appropriate data structures
- Learn about advanced data structure operations
- Explore algorithm design with different structures

---

## Additional Resources

- **Python Data Structures**: [docs.python.org/3/tutorial/datastructures.html](https://docs.python.org/3/tutorial/datastructures.html)
- **Time Complexity**: Research Big O notation for deeper understanding
- **Algorithm Design**: Learn how data structures affect algorithm performance

---

*Lesson completed! You're ready to move on to the next lesson.*

