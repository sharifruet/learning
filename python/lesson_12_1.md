# Lesson 12.1: Collections Module

## Learning Objectives

By the end of this lesson, you will be able to:
- Use `namedtuple` for creating tuple subclasses with named fields
- Use `deque` for efficient double-ended queues
- Use `Counter` for counting hashable objects
- Use `defaultdict` for dictionaries with default values
- Use `OrderedDict` for ordered dictionaries
- Understand when to use each collection type
- Apply collections in practical scenarios
- Choose appropriate collection for your needs

---

## Introduction to Collections Module

The `collections` module provides specialized container datatypes that are alternatives to Python's general-purpose built-in containers (dict, list, set, tuple).

### Why Collections?

- **Performance**: Optimized for specific use cases
- **Functionality**: Provide additional features
- **Convenience**: Simplify common operations
- **Memory efficiency**: More efficient for specific patterns

### Collections Overview

- **namedtuple**: Tuple with named fields
- **deque**: Double-ended queue
- **Counter**: Count hashable objects
- **defaultdict**: Dictionary with default factory
- **OrderedDict**: Dictionary that remembers insertion order

---

## namedtuple

`namedtuple` creates tuple subclasses with named fields, making code more readable and self-documenting.

### Creating namedtuple

```python
from collections import namedtuple

# Define namedtuple type
Point = namedtuple('Point', ['x', 'y'])

# Create instances
p1 = Point(3, 4)
p2 = Point(x=5, y=6)

print(p1.x, p1.y)  # 3 4
print(p2.x, p2.y)  # 5 6
```

### Accessing Fields

```python
from collections import namedtuple

Person = namedtuple('Person', ['name', 'age', 'city'])

person = Person('Alice', 30, 'New York')

# Access by name
print(person.name)   # Alice
print(person.age)    # 30
print(person.city)   # New York

# Access by index (still works)
print(person[0])     # Alice
print(person[1])     # 30
print(person[2])     # New York
```

### namedtuple Methods

```python
from collections import namedtuple

Point = namedtuple('Point', ['x', 'y'])
p = Point(3, 4)

# Convert to dictionary
print(p._asdict())  # OrderedDict([('x', 3), ('y', 4)])

# Replace fields (creates new instance)
p2 = p._replace(x=10)
print(p2)  # Point(x=10, y=4)

# Get field names
print(p._fields)  # ('x', 'y')
```

### Practical Example: Coordinates

```python
from collections import namedtuple

# Define coordinate
Coordinate = namedtuple('Coordinate', ['latitude', 'longitude'])

# Create coordinates
nyc = Coordinate(40.7128, -74.0060)
london = Coordinate(51.5074, -0.1278)

print(f"NYC: {nyc.latitude}, {nyc.longitude}")
print(f"London: {london.latitude}, {london.longitude}")
```

### Practical Example: Data Records

```python
from collections import namedtuple

# Define record structure
Student = namedtuple('Student', ['name', 'age', 'grades'])

students = [
    Student('Alice', 20, [85, 90, 88]),
    Student('Bob', 19, [92, 87, 90]),
    Student('Charlie', 21, [78, 85, 82])
]

for student in students:
    avg = sum(student.grades) / len(student.grades)
    print(f"{student.name}: {avg:.2f}")
```

---

## deque

`deque` (double-ended queue) is a list-like container optimized for fast appends and pops from both ends.

### Creating deque

```python
from collections import deque

# Create deque
dq = deque([1, 2, 3])
print(dq)  # deque([1, 2, 3])

# Create empty deque
dq = deque()
dq.append(1)
dq.append(2)
```

### Adding Elements

```python
from collections import deque

dq = deque([1, 2, 3])

# Add to right (end)
dq.append(4)
print(dq)  # deque([1, 2, 3, 4])

# Add to left (beginning)
dq.appendleft(0)
print(dq)  # deque([0, 1, 2, 3, 4])

# Extend from right
dq.extend([5, 6])
print(dq)  # deque([0, 1, 2, 3, 4, 5, 6])

# Extend from left
dq.extendleft([-2, -1])
print(dq)  # deque([-1, -2, 0, 1, 2, 3, 4, 5, 6])
```

### Removing Elements

```python
from collections import deque

dq = deque([1, 2, 3, 4, 5])

# Remove from right
value = dq.pop()
print(value)  # 5
print(dq)     # deque([1, 2, 3, 4])

# Remove from left
value = dq.popleft()
print(value)  # 1
print(dq)     # deque([2, 3, 4])
```

### deque Operations

```python
from collections import deque

dq = deque([1, 2, 3, 4, 5])

# Rotate
dq.rotate(2)      # Rotate right
print(dq)  # deque([4, 5, 1, 2, 3])

dq.rotate(-1)     # Rotate left
print(dq)  # deque([5, 1, 2, 3, 4])

# Maximum size
dq_max = deque([1, 2, 3], maxlen=5)
dq_max.append(4)
dq_max.append(5)
dq_max.append(6)  # Removes leftmost (1)
print(dq_max)  # deque([2, 3, 4, 5, 6], maxlen=5)
```

### Practical Example: Queue

```python
from collections import deque

# Use deque as queue (FIFO)
queue = deque()

# Enqueue
queue.append('task1')
queue.append('task2')
queue.append('task3')

# Dequeue
while queue:
    task = queue.popleft()
    print(f"Processing: {task}")
```

### Practical Example: Stack

```python
from collections import deque

# Use deque as stack (LIFO)
stack = deque()

# Push
stack.append('item1')
stack.append('item2')
stack.append('item3')

# Pop
while stack:
    item = stack.pop()
    print(f"Popped: {item}")
```

---

## Counter

`Counter` is a dict subclass for counting hashable objects.

### Creating Counter

```python
from collections import Counter

# From iterable
words = ['apple', 'banana', 'apple', 'cherry', 'banana', 'apple']
counter = Counter(words)
print(counter)  # Counter({'apple': 3, 'banana': 2, 'cherry': 1})

# From string
text = "hello world"
char_counter = Counter(text)
print(char_counter)

# From dictionary
counter = Counter({'a': 3, 'b': 2, 'c': 1})
```

### Counter Operations

```python
from collections import Counter

c1 = Counter(['a', 'b', 'c', 'a'])
c2 = Counter(['a', 'b', 'b'])

# Addition
print(c1 + c2)  # Counter({'a': 3, 'b': 3, 'c': 1})

# Subtraction
print(c1 - c2)  # Counter({'a': 1, 'c': 1})

# Union (max)
print(c1 | c2)  # Counter({'a': 2, 'b': 2, 'c': 1})

# Intersection (min)
print(c1 & c2)  # Counter({'a': 1, 'b': 1})
```

### Counter Methods

```python
from collections import Counter

counter = Counter(['a', 'b', 'c', 'a', 'b', 'a'])

# Most common
print(counter.most_common(2))  # [('a', 3), ('b', 2)]

# Elements (iterator)
print(list(counter.elements()))  # ['a', 'a', 'a', 'b', 'b', 'c']

# Subtract
counter.subtract(['a', 'b'])
print(counter)  # Counter({'a': 2, 'b': 1, 'c': 1})

# Update
counter.update(['a', 'b', 'c'])
print(counter)  # Counter({'a': 3, 'b': 2, 'c': 2})
```

### Practical Example: Word Frequency

```python
from collections import Counter

def word_frequency(text):
    """Count word frequency in text."""
    words = text.lower().split()
    return Counter(words)

text = "the quick brown fox jumps over the lazy dog the fox"
freq = word_frequency(text)
print(freq.most_common(3))  # [('the', 3), ('fox', 2), ...]
```

### Practical Example: Character Frequency

```python
from collections import Counter

def char_frequency(text):
    """Count character frequency."""
    return Counter(text.lower())

text = "Hello World"
char_freq = char_frequency(text)
print(char_freq.most_common(5))
```

---

## defaultdict

`defaultdict` is a dictionary subclass that calls a factory function to supply missing values.

### Creating defaultdict

```python
from collections import defaultdict

# defaultdict with list factory
dd_list = defaultdict(list)
dd_list['fruits'].append('apple')
dd_list['fruits'].append('banana')
print(dd_list)  # defaultdict(<class 'list'>, {'fruits': ['apple', 'banana']})

# defaultdict with int factory
dd_int = defaultdict(int)
dd_int['count'] += 1
dd_int['count'] += 1
print(dd_int['count'])  # 2
```

### defaultdict with Different Factories

```python
from collections import defaultdict

# List factory
dd_list = defaultdict(list)
dd_list['items'].append(1)

# Int factory
dd_int = defaultdict(int)
dd_int['counter'] += 1

# Set factory
dd_set = defaultdict(set)
dd_set['tags'].add('python')

# String factory
dd_str = defaultdict(str)
dd_str['name'] += 'Hello'

# Custom factory function
def default_factory():
    return "default value"

dd_custom = defaultdict(default_factory)
print(dd_custom['key'])  # 'default value'
```

### Practical Example: Grouping

```python
from collections import defaultdict

# Group items by category
items = [
    ('fruit', 'apple'),
    ('fruit', 'banana'),
    ('vegetable', 'carrot'),
    ('fruit', 'cherry'),
    ('vegetable', 'potato')
]

grouped = defaultdict(list)
for category, item in items:
    grouped[category].append(item)

print(dict(grouped))
# {'fruit': ['apple', 'banana', 'cherry'], 'vegetable': ['carrot', 'potato']}
```

### Practical Example: Counting

```python
from collections import defaultdict

# Count items
items = ['apple', 'banana', 'apple', 'cherry', 'banana', 'apple']

count = defaultdict(int)
for item in items:
    count[item] += 1

print(dict(count))  # {'apple': 3, 'banana': 2, 'cherry': 1}
```

---

## OrderedDict

`OrderedDict` is a dictionary subclass that remembers the order entries were added.

### Creating OrderedDict

```python
from collections import OrderedDict

# Create ordered dict
od = OrderedDict()
od['first'] = 1
od['second'] = 2
od['third'] = 3

print(od)  # OrderedDict([('first', 1), ('second', 2), ('third', 3)])
```

### OrderedDict Operations

```python
from collections import OrderedDict

od = OrderedDict([('a', 1), ('b', 2), ('c', 3)])

# Move to end
od.move_to_end('a')
print(od)  # OrderedDict([('b', 2), ('c', 3), ('a', 1)])

# Move to beginning
od.move_to_end('a', last=False)
print(od)  # OrderedDict([('a', 1), ('b', 2), ('c', 3)])

# Pop last
last = od.popitem()
print(last)  # ('c', 3)

# Pop first
first = od.popitem(last=False)
print(first)  # ('a', 1)
```

### Note: Python 3.7+ Dicts are Ordered

In Python 3.7+, regular dictionaries remember insertion order, so `OrderedDict` is less necessary but still useful for:
- Explicit ordering requirements
- `move_to_end()` method
- Equality based on order
- Backward compatibility

```python
# Python 3.7+: Regular dict maintains order
d = {'first': 1, 'second': 2, 'third': 3}
print(d)  # {'first': 1, 'second': 2, 'third': 3} (ordered)

# But OrderedDict still useful for move_to_end()
from collections import OrderedDict
od = OrderedDict([('a', 1), ('b', 2), ('c', 3)])
od.move_to_end('a')  # Only available in OrderedDict
```

### Practical Example: LRU Cache (Concept)

```python
from collections import OrderedDict

class LRUCache:
    def __init__(self, capacity):
        self.cache = OrderedDict()
        self.capacity = capacity
    
    def get(self, key):
        if key not in self.cache:
            return -1
        self.cache.move_to_end(key)
        return self.cache[key]
    
    def put(self, key, value):
        if key in self.cache:
            self.cache.move_to_end(key)
        self.cache[key] = value
        if len(self.cache) > self.capacity:
            self.cache.popitem(last=False)
```

---

## Practical Examples

### Example 1: Data Processing with namedtuple

```python
from collections import namedtuple

# Define data structure
Transaction = namedtuple('Transaction', ['date', 'amount', 'type'])

transactions = [
    Transaction('2024-01-01', 100, 'income'),
    Transaction('2024-01-02', -50, 'expense'),
    Transaction('2024-01-03', 200, 'income'),
]

total_income = sum(t.amount for t in transactions if t.type == 'income')
total_expense = sum(t.amount for t in transactions if t.type == 'expense')

print(f"Income: ${total_income}")
print(f"Expense: ${total_expense}")
```

### Example 2: Sliding Window with deque

```python
from collections import deque

def sliding_window_max(nums, k):
    """Find maximum in each sliding window."""
    result = []
    window = deque()
    
    for i, num in enumerate(nums):
        # Remove indices outside window
        while window and window[0] <= i - k:
            window.popleft()
        
        # Remove indices with smaller values
        while window and nums[window[-1]] < num:
            window.pop()
        
        window.append(i)
        
        # Add maximum if window is full
        if i >= k - 1:
            result.append(nums[window[0]])
    
    return result

nums = [1, 3, -1, -3, 5, 3, 6, 7]
print(sliding_window_max(nums, 3))  # [3, 3, 5, 5, 6, 7]
```

### Example 3: Text Analysis with Counter

```python
from collections import Counter
import re

def analyze_text(text):
    """Analyze text statistics."""
    # Word frequency
    words = re.findall(r'\w+', text.lower())
    word_freq = Counter(words)
    
    # Character frequency
    char_freq = Counter(text.lower())
    
    return {
        'word_frequency': word_freq.most_common(10),
        'character_frequency': char_freq.most_common(10),
        'total_words': len(words),
        'unique_words': len(word_freq)
    }

text = "The quick brown fox jumps over the lazy dog. The fox is quick."
stats = analyze_text(text)
print(stats)
```

---

## Best Practices

### 1. Choose Appropriate Collection

```python
# Use namedtuple for structured data
Point = namedtuple('Point', ['x', 'y'])

# Use deque for queues/stacks
queue = deque()

# Use Counter for counting
counter = Counter(items)

# Use defaultdict for grouping
grouped = defaultdict(list)
```

### 2. Use namedtuple for Readability

```python
# Good: Clear field names
Person = namedtuple('Person', ['name', 'age'])
person = Person('Alice', 30)

# Avoid: Unclear tuple
person = ('Alice', 30)  # What is index 0? 1?
```

### 3. Use defaultdict to Avoid KeyError

```python
# Good: No KeyError
dd = defaultdict(list)
dd['key'].append('value')

# Avoid: Need to check key
d = {}
if 'key' not in d:
    d['key'] = []
d['key'].append('value')
```

---

## Common Mistakes and Pitfalls

### 1. Forgetting namedtuple is Immutable

```python
from collections import namedtuple

Point = namedtuple('Point', ['x', 'y'])
p = Point(3, 4)

# WRONG: Cannot modify
# p.x = 5  # AttributeError

# CORRECT: Create new instance
p = p._replace(x=5)
```

### 2. Using deque When List is Fine

```python
# WRONG: deque for simple list operations
dq = deque()
dq.append(1)
dq.append(2)
value = dq[0]  # Works but list is simpler

# CORRECT: Use list for simple operations
lst = [1, 2]
value = lst[0]
```

### 3. Not Using Counter When Counting

```python
# WRONG: Manual counting
count = {}
for item in items:
    if item not in count:
        count[item] = 0
    count[item] += 1

# CORRECT: Use Counter
from collections import Counter
count = Counter(items)
```

---

## Practice Exercise

### Exercise: Collections

**Objective**: Create a Python program that demonstrates using collections module.

**Instructions**:

1. Create a file called `collections_practice.py`

2. Write a program that:
   - Uses namedtuple
   - Uses deque
   - Uses Counter
   - Uses defaultdict
   - Uses OrderedDict
   - Demonstrates practical applications

3. Your program should include:
   - Creating and using each collection type
   - Common operations
   - Practical examples

**Example Solution**:

```python
"""
Collections Module Practice
This program demonstrates using collections module.
"""

from collections import namedtuple, deque, Counter, defaultdict, OrderedDict

print("=" * 60)
print("COLLECTIONS MODULE PRACTICE")
print("=" * 60)
print()

# 1. namedtuple - Creating and using
print("1. NAMEDTUPLE - CREATING AND USING")
print("-" * 60)
Point = namedtuple('Point', ['x', 'y'])
p1 = Point(3, 4)
p2 = Point(x=5, y=6)

print(f"Point 1: x={p1.x}, y={p1.y}")
print(f"Point 2: x={p2.x}, y={p2.y}")
print(f"Point 1 as dict: {p1._asdict()}")
print()

# 2. namedtuple - Methods
print("2. NAMEDTUPLE - METHODS")
print("-" * 60)
Person = namedtuple('Person', ['name', 'age', 'city'])
person = Person('Alice', 30, 'New York')

print(f"Person: {person}")
print(f"Field names: {person._fields}")
person_updated = person._replace(age=31)
print(f"Updated person: {person_updated}")
print()

# 3. namedtuple - Data records
print("3. NAMEDTUPLE - DATA RECORDS")
print("-" * 60)
Student = namedtuple('Student', ['name', 'age', 'grades'])

students = [
    Student('Alice', 20, [85, 90, 88]),
    Student('Bob', 19, [92, 87, 90]),
    Student('Charlie', 21, [78, 85, 82])
]

for student in students:
    avg = sum(student.grades) / len(student.grades)
    print(f"{student.name}: average={avg:.2f}")
print()

# 4. deque - Creating and adding
print("4. DEQUE - CREATING AND ADDING")
print("-" * 60)
dq = deque([1, 2, 3])
print(f"Initial: {dq}")

dq.append(4)        # Add to right
dq.appendleft(0)    # Add to left
print(f"After append: {dq}")

dq.extend([5, 6])       # Extend right
dq.extendleft([-2, -1]) # Extend left
print(f"After extend: {dq}")
print()

# 5. deque - Removing elements
print("5. DEQUE - REMOVING ELEMENTS")
print("-" * 60)
dq = deque([1, 2, 3, 4, 5])
print(f"Initial: {dq}")

right = dq.pop()
left = dq.popleft()
print(f"Popped right: {right}, left: {left}")
print(f"After pop: {dq}")
print()

# 6. deque - Rotate
print("6. DEQUE - ROTATE")
print("-" * 60)
dq = deque([1, 2, 3, 4, 5])
print(f"Initial: {dq}")

dq.rotate(2)
print(f"Rotate right 2: {dq}")

dq.rotate(-1)
print(f"Rotate left 1: {dq}")
print()

# 7. deque - Max length
print("7. DEQUE - MAX LENGTH")
print("-" * 60)
dq = deque([1, 2, 3], maxlen=5)
dq.extend([4, 5, 6])
print(f"With maxlen=5: {dq}")
print()

# 8. deque - Queue (FIFO)
print("8. DEQUE - QUEUE (FIFO)")
print("-" * 60)
queue = deque()
queue.append('task1')
queue.append('task2')
queue.append('task3')

print("Processing queue:")
while queue:
    task = queue.popleft()
    print(f"  Processing: {task}")
print()

# 9. deque - Stack (LIFO)
print("9. DEQUE - STACK (LIFO)")
print("-" * 60)
stack = deque()
stack.append('item1')
stack.append('item2')
stack.append('item3')

print("Popping stack:")
while stack:
    item = stack.pop()
    print(f"  Popped: {item}")
print()

# 10. Counter - Creating
print("10. COUNTER - CREATING")
print("-" * 60)
words = ['apple', 'banana', 'apple', 'cherry', 'banana', 'apple']
counter = Counter(words)
print(f"Word counter: {counter}")

text = "hello world"
char_counter = Counter(text)
print(f"Character counter: {char_counter.most_common(5)}")
print()

# 11. Counter - Operations
print("11. COUNTER - OPERATIONS")
print("-" * 60)
c1 = Counter(['a', 'b', 'c', 'a'])
c2 = Counter(['a', 'b', 'b'])

print(f"c1: {c1}")
print(f"c2: {c2}")
print(f"c1 + c2: {c1 + c2}")
print(f"c1 - c2: {c1 - c2}")
print()

# 12. Counter - Methods
print("12. COUNTER - METHODS")
print("-" * 60)
counter = Counter(['a', 'b', 'c', 'a', 'b', 'a'])
print(f"Counter: {counter}")
print(f"Most common 2: {counter.most_common(2)}")
print(f"Elements: {list(counter.elements())}")
print()

# 13. Counter - Update and subtract
print("13. COUNTER - UPDATE AND SUBTRACT")
print("-" * 60)
counter = Counter(['a', 'b', 'c'])
print(f"Initial: {counter}")

counter.update(['a', 'b'])
print(f"After update: {counter}")

counter.subtract(['a'])
print(f"After subtract: {counter}")
print()

# 14. defaultdict - List factory
print("14. DEFAULTDICT - LIST FACTORY")
print("-" * 60)
dd_list = defaultdict(list)
dd_list['fruits'].append('apple')
dd_list['fruits'].append('banana')
dd_list['vegetables'].append('carrot')
print(f"Defaultdict list: {dict(dd_list)}")
print()

# 15. defaultdict - Int factory
print("15. DEFAULTDICT - INT FACTORY")
print("-" * 60)
dd_int = defaultdict(int)
dd_int['count'] += 1
dd_int['count'] += 1
dd_int['other'] += 1
print(f"Defaultdict int: {dict(dd_int)}")
print()

# 16. defaultdict - Set factory
print("16. DEFAULTDICT - SET FACTORY")
print("-" * 60)
dd_set = defaultdict(set)
dd_set['tags'].add('python')
dd_set['tags'].add('programming')
dd_set['tags'].add('python')  # Duplicate ignored
print(f"Defaultdict set: {dict(dd_set)}")
print()

# 17. defaultdict - Grouping
print("17. DEFAULTDICT - GROUPING")
print("-" * 60)
items = [
    ('fruit', 'apple'),
    ('fruit', 'banana'),
    ('vegetable', 'carrot'),
    ('fruit', 'cherry'),
]

grouped = defaultdict(list)
for category, item in items:
    grouped[category].append(item)

print(f"Grouped items: {dict(grouped)}")
print()

# 18. defaultdict - Counting
print("18. DEFAULTDICT - COUNTING")
print("-" * 60)
items = ['apple', 'banana', 'apple', 'cherry', 'banana', 'apple']
count = defaultdict(int)

for item in items:
    count[item] += 1

print(f"Count: {dict(count)}")
print()

# 19. OrderedDict - Creating and operations
print("19. ORDEREDDICT - CREATING AND OPERATIONS")
print("-" * 60)
od = OrderedDict([('a', 1), ('b', 2), ('c', 3)])
print(f"Initial: {od}")

od.move_to_end('a')
print(f"After move_to_end('a'): {od}")

od.move_to_end('a', last=False)
print(f"After move_to_end('a', last=False): {od}")
print()

# 20. OrderedDict - Pop operations
print("20. ORDEREDDICT - POP OPERATIONS")
print("-" * 60)
od = OrderedDict([('a', 1), ('b', 2), ('c', 3)])
print(f"Initial: {od}")

last = od.popitem()
print(f"Pop last: {last}, remaining: {od}")

first = od.popitem(last=False)
print(f"Pop first: {first}, remaining: {od}")
print()

# 21. Practical: Word frequency analysis
print("21. PRACTICAL: WORD FREQUENCY ANALYSIS")
print("-" * 60)
text = "the quick brown fox jumps over the lazy dog the fox"
words = text.split()
word_freq = Counter(words)
print(f"Word frequencies: {word_freq.most_common(3)}")
print()

# 22. Practical: Grouping data
print("22. PRACTICAL: GROUPING DATA")
print("-" * 60)
transactions = [
    ('income', 100),
    ('expense', 50),
    ('income', 200),
    ('expense', 30),
    ('income', 150),
]

grouped = defaultdict(list)
for category, amount in transactions:
    grouped[category].append(amount)

for category, amounts in grouped.items():
    total = sum(amounts)
    print(f"{category}: {amounts} (total: {total})")
print()

# 23. Practical: Queue implementation
print("23. PRACTICAL: QUEUE IMPLEMENTATION")
print("-" * 60)
queue = deque(['task1', 'task2', 'task3'])
print(f"Queue: {queue}")

# Process queue
while queue:
    task = queue.popleft()
    print(f"Processing: {task}")
print()

# 24. Practical: Named records
print("24. PRACTICAL: NAMED RECORDS")
print("-" * 60)
Transaction = namedtuple('Transaction', ['date', 'amount', 'type'])

transactions = [
    Transaction('2024-01-01', 100, 'income'),
    Transaction('2024-01-02', -50, 'expense'),
    Transaction('2024-01-03', 200, 'income'),
]

total = sum(t.amount for t in transactions)
print(f"Total transactions: {len(transactions)}")
print(f"Net amount: ${total}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
COLLECTIONS MODULE PRACTICE
============================================================

1. NAMEDTUPLE - CREATING AND USING
------------------------------------------------------------
Point 1: x=3, y=4
Point 2: x=5, y=6
Point 1 as dict: OrderedDict([('x', 3), ('y', 4)])

[... rest of output ...]
```

**Challenge** (Optional):
- Implement an LRU cache using OrderedDict
- Build a sliding window algorithm using deque
- Create a data analysis tool using Counter
- Build a grouping utility using defaultdict

---

## Key Takeaways

1. **namedtuple** creates tuple subclasses with named fields
2. **deque** is a double-ended queue optimized for both ends
3. **Counter** counts hashable objects efficiently
4. **defaultdict** provides default values for missing keys
5. **OrderedDict** maintains insertion order (Python 3.7+ dicts also ordered)
6. **Use namedtuple** for structured, immutable data
7. **Use deque** for queues and stacks (faster than list for ends)
8. **Use Counter** for counting operations (simpler than manual counting)
9. **Use defaultdict** to avoid KeyError and simplify grouping
10. **Collections provide** optimized alternatives to built-in types
11. **namedtuple is immutable** - use `_replace()` to create new instances
12. **deque supports** rotate() and maxlen for specialized use cases
13. **Counter supports** arithmetic operations (+, -, |, &)
14. **defaultdict factory** can be list, int, set, or custom function
15. **OrderedDict** still useful for move_to_end() and explicit ordering

---

## Quiz: Collections

Test your understanding with these questions:

1. **What does namedtuple create?**
   - A) Named dictionary
   - B) Tuple subclass with named fields
   - C) Named list
   - D) Named set

2. **What is deque optimized for?**
   - A) Random access
   - B) Operations on both ends
   - C) Sorting
   - D) Searching

3. **What does Counter count?**
   - A) Only numbers
   - B) Hashable objects
   - C) Only strings
   - D) Only lists

4. **What does defaultdict provide?**
   - A) Sorted keys
   - B) Default values for missing keys
   - C) Fixed size
   - D) Read-only access

5. **What is OrderedDict?**
   - A) Dictionary sorted by key
   - B) Dictionary that remembers insertion order
   - C) Dictionary sorted by value
   - D) Dictionary with unique values

6. **Can you modify a namedtuple?**
   - A) Yes, directly
   - B) No, it's immutable
   - C) Only in Python 2
   - D) Only with special method

7. **What does deque.rotate() do?**
   - A) Sorts elements
   - B) Rotates elements
   - C) Reverses elements
   - D) Shuffles elements

8. **What does Counter.most_common() return?**
   - A) Least common items
   - B) Most common items
   - C) All items
   - D) Unique items

9. **What factory is commonly used with defaultdict?**
   - A) dict
   - B) tuple
   - C) list or int
   - D) set

10. **When should you use collections?**
    - A) Never
    - B) When built-in types are insufficient
    - C) Always
    - D) Only for large data

**Answers**:
1. B) Tuple subclass with named fields (namedtuple definition)
2. B) Operations on both ends (deque optimization)
3. B) Hashable objects (Counter counts hashable items)
4. B) Default values for missing keys (defaultdict feature)
5. B) Dictionary that remembers insertion order (OrderedDict definition)
6. B) No, it's immutable (must use _replace() for new instance)
7. B) Rotates elements (rotate method rotates deque)
8. B) Most common items (most_common returns most frequent)
9. C) list or int (common factories for defaultdict)
10. B) When built-in types are insufficient (use when appropriate)

---

## Next Steps

Excellent work! You've mastered the collections module. You now understand:
- How to use namedtuple, deque, Counter, defaultdict, OrderedDict
- When to use each collection type
- Practical applications

**What's Next?**
- Lesson 12.2: Generators and Iterators
- Learn about generator functions
- Understand iterator protocol
- Explore generator expressions

---

## Additional Resources

- **collections**: [docs.python.org/3/library/collections.html](https://docs.python.org/3/library/collections.html)
- **namedtuple**: [docs.python.org/3/library/collections.html#collections.namedtuple](https://docs.python.org/3/library/collections.html#collections.namedtuple)
- **deque**: [docs.python.org/3/library/collections.html#collections.deque](https://docs.python.org/3/library/collections.html#collections.deque)

---

*Lesson completed! You're ready to move on to the next lesson.*

