# Lesson 11.4: Standard Library Overview

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand Python's standard library
- Use the `datetime` module for date and time operations
- Use the `collections` module for specialized data structures
- Use the `itertools` module for efficient iteration
- Use the `random` module for random number generation
- Understand key standard library modules
- Apply standard library modules in practical scenarios
- Explore Python's built-in modules

---

## Introduction to Standard Library

Python's **standard library** is a collection of modules that come with Python. It provides a wide range of functionality without requiring external packages.

### What is the Standard Library?

- **Built-in modules**: Included with Python installation
- **Extensive functionality**: Covers many common tasks
- **Well-documented**: Comprehensive documentation
- **Cross-platform**: Works on all platforms
- **No installation needed**: Available immediately

### Benefits

- **No dependencies**: Don't need to install additional packages
- **Well-tested**: Thoroughly tested and maintained
- **Documentation**: Comprehensive documentation available
- **Performance**: Often optimized C implementations

---

## The `datetime` Module

The `datetime` module provides classes for working with dates and times.

### Basic Date and Time

```python
from datetime import datetime, date, time

# Current date and time
now = datetime.now()
print(now)  # Output: 2024-03-15 10:30:45.123456

# Current date
today = date.today()
print(today)  # Output: 2024-03-15

# Create specific datetime
dt = datetime(2024, 3, 15, 10, 30, 45)
print(dt)  # Output: 2024-03-15 10:30:45
```

### Date Operations

```python
from datetime import datetime, timedelta

# Current date
now = datetime.now()

# Add days
future = now + timedelta(days=7)
print(future)

# Subtract days
past = now - timedelta(days=30)
print(past)

# Add weeks, hours, minutes
future = now + timedelta(weeks=2, hours=5, minutes=30)
print(future)
```

### Date Formatting

```python
from datetime import datetime

now = datetime.now()

# Format datetime
formatted = now.strftime("%Y-%m-%d %H:%M:%S")
print(formatted)  # Output: 2024-03-15 10:30:45

# Parse string to datetime
date_string = "2024-03-15 10:30:45"
parsed = datetime.strptime(date_string, "%Y-%m-%d %H:%M:%S")
print(parsed)
```

### Date Comparison

```python
from datetime import datetime, timedelta

date1 = datetime(2024, 3, 15)
date2 = datetime(2024, 3, 20)

# Compare dates
print(date1 < date2)  # True
print(date1 > date2)  # False

# Calculate difference
difference = date2 - date1
print(difference.days)  # 5
```

### Common Date Format Codes

- `%Y` - Year with century (2024)
- `%m` - Month (01-12)
- `%d` - Day (01-31)
- `%H` - Hour (00-23)
- `%M` - Minute (00-59)
- `%S` - Second (00-59)

---

## The `collections` Module

The `collections` module provides specialized data structures beyond the built-in types.

### Counter

```python
from collections import Counter

# Count elements
words = ['apple', 'banana', 'apple', 'cherry', 'banana', 'apple']
counter = Counter(words)
print(counter)  # Counter({'apple': 3, 'banana': 2, 'cherry': 1})

# Most common
print(counter.most_common(2))  # [('apple', 3), ('banana', 2)]

# Count characters
text = "hello world"
char_count = Counter(text)
print(char_count)
```

### defaultdict

```python
from collections import defaultdict

# Default dictionary with list factory
dd = defaultdict(list)
dd['fruits'].append('apple')
dd['fruits'].append('banana')
dd['vegetables'].append('carrot')
print(dd)

# Default dictionary with int factory
dd_int = defaultdict(int)
dd_int['count'] += 1
dd_int['count'] += 1
print(dd_int['count'])  # 2
```

### namedtuple

```python
from collections import namedtuple

# Create named tuple
Point = namedtuple('Point', ['x', 'y'])
p = Point(3, 4)
print(p.x, p.y)  # 3 4

# Access by name or index
print(p[0], p[1])  # 3 4
print(p.x, p.y)    # 3 4
```

### deque

```python
from collections import deque

# Double-ended queue
dq = deque([1, 2, 3])
dq.append(4)      # Add to right
dq.appendleft(0)  # Add to left
print(dq)  # deque([0, 1, 2, 3, 4])

dq.pop()          # Remove from right
dq.popleft()      # Remove from left
print(dq)  # deque([1, 2, 3])
```

---

## The `itertools` Module

The `itertools` module provides functions for efficient iteration and combinatorics.

### Infinite Iterators

```python
import itertools

# Count - infinite counter
counter = itertools.count(start=0, step=1)
print(next(counter))  # 0
print(next(counter))  # 1
print(next(counter))  # 2

# Cycle - cycle through iterable
cycle_iter = itertools.cycle(['A', 'B', 'C'])
print(next(cycle_iter))  # A
print(next(cycle_iter))  # B
print(next(cycle_iter))  # C
print(next(cycle_iter))  # A (cycles back)

# Repeat - repeat value
repeat_iter = itertools.repeat(10, times=3)
print(list(repeat_iter))  # [10, 10, 10]
```

### Combinatoric Iterators

```python
import itertools

# Combinations
items = ['A', 'B', 'C']
combs = list(itertools.combinations(items, 2))
print(combs)  # [('A', 'B'), ('A', 'C'), ('B', 'C')]

# Permutations
perms = list(itertools.permutations(items, 2))
print(perms)  # [('A', 'B'), ('A', 'C'), ('B', 'A'), ('B', 'C'), ('C', 'A'), ('C', 'B')]

# Product (Cartesian product)
prod = list(itertools.product([1, 2], ['a', 'b']))
print(prod)  # [(1, 'a'), (1, 'b'), (2, 'a'), (2, 'b')]
```

### Iterator Functions

```python
import itertools

# Chain - combine iterables
list1 = [1, 2, 3]
list2 = [4, 5, 6]
chained = list(itertools.chain(list1, list2))
print(chained)  # [1, 2, 3, 4, 5, 6]

# Filter - filter elements
numbers = [1, 2, 3, 4, 5, 6]
evens = list(itertools.filterfalse(lambda x: x % 2 == 1, numbers))
print(evens)  # [2, 4, 6]

# Groupby - group consecutive elements
data = [1, 1, 2, 2, 3, 3, 3]
grouped = {k: list(v) for k, v in itertools.groupby(data)}
print(grouped)  # {1: [1, 1], 2: [2, 2], 3: [3, 3, 3]}
```

---

## The `random` Module

The `random` module provides functions for generating random numbers and making random choices.

### Random Numbers

```python
import random

# Random float between 0 and 1
rand_float = random.random()
print(rand_float)  # e.g., 0.123456

# Random integer in range
rand_int = random.randint(1, 100)
print(rand_int)  # e.g., 42

# Random float in range
rand_range = random.uniform(1.0, 10.0)
print(rand_range)  # e.g., 5.678
```

### Random Choices

```python
import random

# Random choice from sequence
items = ['apple', 'banana', 'cherry']
choice = random.choice(items)
print(choice)  # e.g., 'banana'

# Multiple random choices
choices = random.choices(items, k=3)
print(choices)  # e.g., ['apple', 'cherry', 'apple']

# Random sample (without replacement)
sample = random.sample(items, 2)
print(sample)  # e.g., ['banana', 'cherry']
```

### Shuffling

```python
import random

# Shuffle list in place
numbers = [1, 2, 3, 4, 5]
random.shuffle(numbers)
print(numbers)  # e.g., [3, 1, 5, 2, 4]
```

### Seed for Reproducibility

```python
import random

# Set seed for reproducible results
random.seed(42)
print(random.randint(1, 100))  # Same result each time

random.seed(42)
print(random.randint(1, 100))  # Same result
```

---

## Other Important Standard Library Modules

### `os` Module

```python
import os

# Current directory
print(os.getcwd())

# List directory
files = os.listdir('.')

# Environment variables
path = os.getenv('PATH')

# Path operations
os.path.join('folder', 'file.txt')
os.path.exists('file.txt')
```

### `sys` Module

```python
import sys

# Command line arguments
args = sys.argv

# Python version
print(sys.version)

# Exit program
sys.exit(0)

# Standard streams
sys.stdout.write("Hello\n")
```

### `json` Module

```python
import json

# Convert Python to JSON
data = {"name": "Alice", "age": 30}
json_str = json.dumps(data)

# Convert JSON to Python
python_obj = json.loads(json_str)

# Read/write JSON files
with open('data.json', 'w') as f:
    json.dump(data, f)
```

### `re` Module (Regular Expressions)

```python
import re

# Search pattern
text = "The price is $50"
match = re.search(r'\$(\d+)', text)
if match:
    print(match.group(1))  # 50

# Find all matches
numbers = re.findall(r'\d+', "I have 5 apples and 10 oranges")
print(numbers)  # ['5', '10']
```

---

## Practical Examples

### Example 1: Date Calculations

```python
from datetime import datetime, timedelta

def days_until_deadline(deadline_date):
    """Calculate days until deadline."""
    today = datetime.now()
    deadline = datetime.strptime(deadline_date, "%Y-%m-%d")
    difference = deadline - today
    return difference.days

days = days_until_deadline("2024-12-31")
print(f"Days until deadline: {days}")
```

### Example 2: Word Frequency

```python
from collections import Counter

def word_frequency(text):
    """Count word frequency in text."""
    words = text.lower().split()
    counter = Counter(words)
    return counter.most_common(5)

text = "the quick brown fox jumps over the lazy dog the fox"
freq = word_frequency(text)
print(freq)  # [('the', 3), ('fox', 2), ...]
```

### Example 3: Random Password Generator

```python
import random
import string

def generate_password(length=12):
    """Generate random password."""
    characters = string.ascii_letters + string.digits + string.punctuation
    password = ''.join(random.choice(characters) for _ in range(length))
    return password

password = generate_password(16)
print(password)
```

### Example 4: Date Range Generator

```python
from datetime import datetime, timedelta
import itertools

def date_range(start_date, end_date):
    """Generate date range."""
    start = datetime.strptime(start_date, "%Y-%m-%d")
    end = datetime.strptime(end_date, "%Y-%m-%d")
    
    current = start
    while current <= end:
        yield current.strftime("%Y-%m-%d")
        current += timedelta(days=1)

# Use generator
dates = list(date_range("2024-01-01", "2024-01-05"))
print(dates)
```

---

## Common Patterns

### Pattern 1: Date Formatting

```python
from datetime import datetime

now = datetime.now()
formatted = now.strftime("%Y-%m-%d %H:%M:%S")
```

### Pattern 2: Counter Usage

```python
from collections import Counter

items = [1, 2, 2, 3, 3, 3]
counter = Counter(items)
most_common = counter.most_common(1)
```

### Pattern 3: Random Sampling

```python
import random

population = list(range(100))
sample = random.sample(population, 10)
```

### Pattern 4: Itertools Chaining

```python
import itertools

list1 = [1, 2, 3]
list2 = [4, 5, 6]
combined = list(itertools.chain(list1, list2))
```

---

## Best Practices

### 1. Use Standard Library First

```python
# Good: Use standard library
from collections import Counter
counter = Counter(items)

# Avoid: Reimplementing functionality
def count_items(items):
    # Custom implementation (usually unnecessary)
    pass
```

### 2. Understand Module Purpose

```python
# datetime for dates/times
from datetime import datetime

# collections for specialized data structures
from collections import Counter, defaultdict

# itertools for iteration
import itertools
```

### 3. Read Documentation

```python
# Use help() to explore modules
help(datetime)
help(Counter)
```

---

## Practice Exercise

### Exercise: Standard Library

**Objective**: Create a Python program that demonstrates using standard library modules.

**Instructions**:

1. Create a file called `standard_library_practice.py`

2. Write a program that:
   - Uses datetime module
   - Uses collections module
   - Uses itertools module
   - Uses random module
   - Demonstrates practical applications

3. Your program should include:
   - Date and time operations
   - Collections data structures
   - Iteration utilities
   - Random number generation
   - Practical examples

**Example Solution**:

```python
"""
Standard Library Practice
This program demonstrates using Python's standard library modules.
"""

from datetime import datetime, timedelta, date
from collections import Counter, defaultdict, namedtuple
import itertools
import random
import json
import os

print("=" * 60)
print("STANDARD LIBRARY PRACTICE")
print("=" * 60)
print()

# 1. datetime - Current date and time
print("1. DATETIME - CURRENT DATE AND TIME")
print("-" * 60)
now = datetime.now()
print(f"Current datetime: {now}")
print(f"Current date: {now.date()}")
print(f"Current time: {now.time()}")
print(f"Year: {now.year}, Month: {now.month}, Day: {now.day}")
print()

# 2. datetime - Date operations
print("2. DATETIME - DATE OPERATIONS")
print("-" * 60)
today = date.today()
future = today + timedelta(days=30)
past = today - timedelta(weeks=2)

print(f"Today: {today}")
print(f"30 days from now: {future}")
print(f"2 weeks ago: {past}")

# Date difference
difference = future - today
print(f"Difference: {difference.days} days")
print()

# 3. datetime - Date formatting
print("3. DATETIME - DATE FORMATTING")
print("-" * 60)
now = datetime.now()
formatted = now.strftime("%Y-%m-%d %H:%M:%S")
print(f"Formatted: {formatted}")

date_str = "2024-03-15 10:30:45"
parsed = datetime.strptime(date_str, "%Y-%m-%d %H:%M:%S")
print(f"Parsed: {parsed}")
print()

# 4. datetime - Date comparison
print("4. DATETIME - DATE COMPARISON")
print("-" * 60)
date1 = datetime(2024, 3, 15)
date2 = datetime(2024, 3, 20)

print(f"Date1: {date1}")
print(f"Date2: {date2}")
print(f"Date1 < Date2: {date1 < date2}")
print(f"Date1 > Date2: {date1 > date2}")

diff = date2 - date1
print(f"Difference: {diff.days} days")
print()

# 5. collections - Counter
print("5. COLLECTIONS - COUNTER")
print("-" * 60)
words = ['apple', 'banana', 'apple', 'cherry', 'banana', 'apple']
counter = Counter(words)
print(f"Word count: {counter}")
print(f"Most common 2: {counter.most_common(2)}")

text = "hello world"
char_counter = Counter(text)
print(f"Character count: {char_counter}")
print()

# 6. collections - defaultdict
print("6. COLLECTIONS - DEFAULTDICT")
print("-" * 60)
# Defaultdict with list
dd_list = defaultdict(list)
dd_list['fruits'].append('apple')
dd_list['fruits'].append('banana')
dd_list['vegetables'].append('carrot')
print(f"Defaultdict list: {dict(dd_list)}")

# Defaultdict with int
dd_int = defaultdict(int)
dd_int['count'] += 1
dd_int['count'] += 1
print(f"Defaultdict int: {dict(dd_int)}")
print()

# 7. collections - namedtuple
print("7. COLLECTIONS - NAMEDTUPLE")
print("-" * 60)
Point = namedtuple('Point', ['x', 'y'])
p = Point(3, 4)
print(f"Point: {p}")
print(f"x: {p.x}, y: {p.y}")
print(f"Index access: p[0]={p[0]}, p[1]={p[1]}")

Person = namedtuple('Person', ['name', 'age', 'city'])
person = Person('Alice', 30, 'New York')
print(f"Person: {person.name}, {person.age}, {person.city}")
print()

# 8. collections - deque
print("8. COLLECTIONS - DEQUE")
print("-" * 60)
dq = deque([1, 2, 3])
print(f"Initial: {dq}")

dq.append(4)        # Add to right
dq.appendleft(0)    # Add to left
print(f"After append: {dq}")

dq.pop()            # Remove from right
dq.popleft()        # Remove from left
print(f"After pop: {dq}")
print()

# 9. itertools - count
print("9. ITERTOOLS - COUNT")
print("-" * 60)
counter = itertools.count(start=0, step=1)
first_five = [next(counter) for _ in range(5)]
print(f"Count first 5: {first_five}")
print()

# 10. itertools - cycle
print("10. ITERTOOLS - CYCLE")
print("-" * 60)
cycle_iter = itertools.cycle(['A', 'B', 'C'])
first_six = [next(cycle_iter) for _ in range(6)]
print(f"Cycle first 6: {first_six}")
print()

# 11. itertools - combinations
print("11. ITERTOOLS - COMBINATIONS")
print("-" * 60)
items = ['A', 'B', 'C']
combs = list(itertools.combinations(items, 2))
print(f"Combinations of 2: {combs}")
print()

# 12. itertools - permutations
print("12. ITERTOOLS - PERMUTATIONS")
print("-" * 60)
perms = list(itertools.permutations(items, 2))
print(f"Permutations of 2: {perms}")
print()

# 13. itertools - product
print("13. ITERTOOLS - PRODUCT")
print("-" * 60)
prod = list(itertools.product([1, 2], ['a', 'b']))
print(f"Cartesian product: {prod}")
print()

# 14. itertools - chain
print("14. ITERTOOLS - CHAIN")
print("-" * 60)
list1 = [1, 2, 3]
list2 = [4, 5, 6]
chained = list(itertools.chain(list1, list2))
print(f"Chained lists: {chained}")
print()

# 15. random - Random numbers
print("15. RANDOM - RANDOM NUMBERS")
print("-" * 60)
print(f"Random float (0-1): {random.random()}")
print(f"Random int (1-100): {random.randint(1, 100)}")
print(f"Random float (1-10): {random.uniform(1.0, 10.0)}")
print()

# 16. random - Random choices
print("16. RANDOM - RANDOM CHOICES")
print("-" * 60)
items = ['apple', 'banana', 'cherry']
print(f"Random choice: {random.choice(items)}")
print(f"Random choices (k=3): {random.choices(items, k=3)}")
print(f"Random sample (k=2): {random.sample(items, 2)}")
print()

# 17. random - Shuffle
print("17. RANDOM - SHUFFLE")
print("-" * 60)
numbers = [1, 2, 3, 4, 5]
print(f"Original: {numbers}")
random.shuffle(numbers)
print(f"Shuffled: {numbers}")
print()

# 18. random - Seed
print("18. RANDOM - SEED")
print("-" * 60)
random.seed(42)
num1 = random.randint(1, 100)
random.seed(42)
num2 = random.randint(1, 100)
print(f"With seed 42: {num1} (same as {num2})")
print()

# 19. Practical: Word frequency
print("19. PRACTICAL: WORD FREQUENCY")
print("-" * 60)
text = "the quick brown fox jumps over the lazy dog the fox"
words = text.split()
counter = Counter(words)
print(f"Word frequencies: {counter.most_common(3)}")
print()

# 20. Practical: Date calculations
print("20. PRACTICAL: DATE CALCULATIONS")
print("-" * 60)
today = datetime.now()
deadline = datetime(2024, 12, 31)
days_left = (deadline - today).days
print(f"Days until Dec 31, 2024: {days_left}")
print()

# 21. Practical: Random password
print("21. PRACTICAL: RANDOM PASSWORD")
print("-" * 60)
import string
characters = string.ascii_letters + string.digits
password = ''.join(random.choice(characters) for _ in range(12))
print(f"Random password: {password}")
print()

# 22. Practical: Grouping data
print("22. PRACTICAL: GROUPING DATA")
print("-" * 60)
data = [(1, 'a'), (1, 'b'), (2, 'c'), (2, 'd'), (3, 'e')]
grouped = {}
for key, group in itertools.groupby(data, lambda x: x[0]):
    grouped[key] = list(group)
print(f"Grouped data: {grouped}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
STANDARD LIBRARY PRACTICE
============================================================

1. DATETIME - CURRENT DATE AND TIME
------------------------------------------------------------
Current datetime: 2024-03-15 10:30:45.123456
Current date: 2024-03-15
Current time: 10:30:45.123456
Year: 2024, Month: 3, Day: 15

[... rest of output ...]
```

**Challenge** (Optional):
- Explore more standard library modules
- Create utilities using standard library
- Build applications using standard library only
- Research additional standard library modules

---

## Key Takeaways

1. **Standard library** comes with Python (no installation needed)
2. **`datetime` module** provides date and time operations
3. **`collections` module** provides specialized data structures (Counter, defaultdict, namedtuple, deque)
4. **`itertools` module** provides efficient iteration utilities
5. **`random` module** provides random number generation
6. **Use standard library first** before external packages
7. **Counter** counts elements in iterables
8. **defaultdict** provides default values for missing keys
9. **namedtuple** creates tuple subclasses with named fields
10. **deque** is a double-ended queue
11. **itertools** provides combinatoric and iteration functions
12. **random** provides random numbers, choices, and shuffling
13. **datetime** handles dates, times, and timedeltas
14. **Standard library** is extensive and well-documented
15. **Explore documentation** to discover more modules

---

## Quiz: Standard Library

Test your understanding with these questions:

1. **What is the standard library?**
   - A) External packages
   - B) Built-in Python modules
   - C) Third-party libraries
   - D) User-defined modules

2. **Which module is used for date/time operations?**
   - A) `time`
   - B) `datetime`
   - C) `date`
   - D) `calendar`

3. **What does Counter from collections do?**
   - A) Counts elements
   - B) Creates lists
   - C) Sorts items
   - D) Filters items

4. **What does defaultdict provide?**
   - A) Default values for missing keys
   - B) Sorted dictionaries
   - C) Fixed-size dictionaries
   - D) Read-only dictionaries

5. **What does itertools provide?**
   - A) Date operations
   - B) Iteration utilities
   - C) Random numbers
   - D) File operations

6. **What does random.randint() return?**
   - A) Random float
   - B) Random integer in range
   - C) Random choice
   - D) Random sample

7. **What is a namedtuple?**
   - A) Named dictionary
   - B) Tuple with named fields
   - C) Named list
   - D) Named set

8. **What does itertools.combinations() do?**
   - A) Generates permutations
   - B) Generates combinations
   - C) Chains iterables
   - D) Cycles through items

9. **What does timedelta represent?**
   - A) Date
   - B) Time
   - C) Duration/difference
   - D) Timezone

10. **What is deque?**
    - A) Single-ended queue
    - B) Double-ended queue
    - C) Stack
    - D) Heap

**Answers**:
1. B) Built-in Python modules (standard library definition)
2. B) `datetime` (module for date/time operations)
3. A) Counts elements (Counter counts occurrences)
4. A) Default values for missing keys (defaultdict feature)
5. B) Iteration utilities (itertools purpose)
6. B) Random integer in range (randint returns integer)
7. B) Tuple with named fields (namedtuple definition)
8. B) Generates combinations (combinations function)
9. C) Duration/difference (timedelta represents time difference)
10. B) Double-ended queue (deque definition)

---

## Next Steps

Excellent work! You've mastered the standard library overview. You now understand:
- Key standard library modules
- How to use datetime, collections, itertools, random
- When to use standard library modules
- Practical applications

**What's Next?**
- Module 12: Advanced Data Structures
- Learn about advanced collections
- Understand specialized data structures
- Explore more Python features

---

## Additional Resources

- **Standard Library**: [docs.python.org/3/library/index.html](https://docs.python.org/3/library/index.html)
- **datetime**: [docs.python.org/3/library/datetime.html](https://docs.python.org/3/library/datetime.html)
- **collections**: [docs.python.org/3/library/collections.html](https://docs.python.org/3/library/collections.html)
- **itertools**: [docs.python.org/3/library/itertools.html](https://docs.python.org/3/library/itertools.html)
- **random**: [docs.python.org/3/library/random.html](https://docs.python.org/3/library/random.html)

---

*Lesson completed! You're ready to move on to the next module.*

