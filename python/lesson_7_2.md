# Lesson 7.2: Regular Expressions

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what regular expressions are and when to use them
- Use the `re` module in Python
- Write basic regex patterns
- Match and search for patterns in strings
- Use common regex metacharacters and special sequences
- Extract, replace, and split text using regex
- Compile regex patterns for efficiency
- Use flags to modify regex behavior
- Apply regex to solve real-world text processing problems
- Debug and test regex patterns

---

## Introduction to Regular Expressions

**Regular expressions (regex)** are powerful pattern-matching tools that allow you to search, match, and manipulate text based on patterns rather than exact strings.

### What Are Regular Expressions?

- **Pattern matching language** for text
- **Powerful tool** for finding, extracting, and replacing text
- **Used in many languages** (Python, JavaScript, Perl, etc.)
- **Syntax** that describes text patterns

### When to Use Regex

✅ **Good for**:
- Validating input (emails, phone numbers, etc.)
- Extracting data from text
- Finding patterns in large text
- Text cleaning and transformation
- Parsing structured text

❌ **Avoid for**:
- Simple string operations (use string methods)
- Very complex patterns (can be hard to read)
- Performance-critical code (can be slower)

### Python's `re` Module

Python provides the `re` module for regular expressions:

```python
import re
```

---

## Basic Regex Patterns

### Literal Characters

Match exact characters:

```python
import re

text = "hello world"
pattern = "hello"

match = re.search(pattern, text)
if match:
    print("Found!")  # Output: Found!
```

### Special Characters (Metacharacters)

These have special meaning in regex:
- `.` (dot) - matches any character except newline
- `^` - matches start of string
- `$` - matches end of string
- `*` - zero or more of preceding character
- `+` - one or more of preceding character
- `?` - zero or one of preceding character
- `|` - OR operator
- `[]` - character class
- `()` - grouping
- `{}` - quantifier
- `\` - escape character

---

## The `re` Module Functions

### re.search()

Find first match in string:

```python
import re

text = "The price is $50"
pattern = r"\$50"  # r"" is raw string (recommended)

match = re.search(pattern, text)
if match:
    print(f"Found: {match.group()}")  # Output: Found: $50
    print(f"Position: {match.start()} to {match.end()}")  # Position: 13 to 16
```

### re.match()

Match only at the beginning of string:

```python
import re

text = "hello world"
pattern = r"hello"

match = re.match(pattern, text)
if match:
    print("Match found!")  # Output: Match found!

# Doesn't match if not at start
text = "world hello"
match = re.match(pattern, text)
if match:
    print("Match found!")
else:
    print("No match")  # Output: No match
```

### re.findall()

Find all matches:

```python
import re

text = "The prices are $50, $100, and $200"
pattern = r"\$\d+"

matches = re.findall(pattern, text)
print(matches)  # Output: ['$50', '$100', '$200']
```

### re.finditer()

Find all matches with match objects:

```python
import re

text = "The prices are $50, $100, and $200"
pattern = r"\$\d+"

for match in re.finditer(pattern, text):
    print(f"Found: {match.group()} at position {match.start()}")
# Output:
# Found: $50 at position 17
# Found: $100 at position 21
# Found: $200 at position 30
```

### re.sub()

Replace matches:

```python
import re

text = "The price is $50"
pattern = r"\$\d+"
replacement = "$100"

new_text = re.sub(pattern, replacement, text)
print(new_text)  # Output: The price is $100
```

### re.split()

Split by pattern:

```python
import re

text = "apple,banana;cherry:grape"
pattern = r"[,;:]"

parts = re.split(pattern, text)
print(parts)  # Output: ['apple', 'banana', 'cherry', 'grape']
```

---

## Character Classes

### Basic Character Classes

Match specific sets of characters:

```python
import re

# [abc] - matches a, b, or c
text = "apple banana cherry"
pattern = r"[abc]"
matches = re.findall(pattern, text)
print(matches)  # Output: ['a', 'p', 'p', 'l', 'e', 'b', 'a', 'n', 'a', 'n', 'a', 'c', 'h', 'e', 'r', 'r', 'y']

# [a-z] - matches lowercase letters
pattern = r"[a-z]"
matches = re.findall(pattern, text)
print(len(matches))  # Count of lowercase letters

# [A-Z] - matches uppercase letters
# [0-9] - matches digits
# [a-zA-Z0-9] - matches alphanumeric
```

### Predefined Character Classes

```python
import re

text = "Hello123 World!"

# \d - digit [0-9]
digits = re.findall(r"\d", text)
print(digits)  # Output: ['1', '2', '3']

# \D - non-digit
non_digits = re.findall(r"\D", text)
print(non_digits)  # All non-digit characters

# \w - word character [a-zA-Z0-9_]
word_chars = re.findall(r"\w", text)
print(word_chars)

# \W - non-word character
non_word = re.findall(r"\W", text)
print(non_word)  # Output: [' ', '!']

# \s - whitespace
spaces = re.findall(r"\s", text)
print(spaces)  # Output: [' ']

# \S - non-whitespace
non_space = re.findall(r"\S", text)
print(non_space)
```

### Negated Character Classes

```python
import re

# [^abc] - matches anything except a, b, or c
text = "hello world"
pattern = r"[^aeiou]"  # Match non-vowels
matches = re.findall(pattern, text)
print(matches)

# [^0-9] - matches non-digits
text = "abc123def"
pattern = r"[^0-9]"
matches = re.findall(pattern, text)
print(matches)  # Output: ['a', 'b', 'c', 'd', 'e', 'f']
```

---

## Quantifiers

### Basic Quantifiers

```python
import re

# * - zero or more
text = "color colour"
pattern = r"colou?r"  # ? makes 'u' optional
matches = re.findall(pattern, text)
print(matches)  # Output: ['color', 'colour']

# + - one or more
text = "a aa aaa aaaa"
pattern = r"a+"
matches = re.findall(pattern, text)
print(matches)  # Output: ['a', 'aa', 'aaa', 'aaaa']

# * - zero or more
text = "a aa aaa"
pattern = r"a*"
matches = re.findall(pattern, text)
print(matches)  # Output: ['a', '', 'aa', '', 'aaa', '']

# ? - zero or one
text = "color colour"
pattern = r"colou?r"
matches = re.findall(pattern, text)
print(matches)  # Output: ['color', 'colour']
```

### Specific Quantifiers

```python
import re

# {n} - exactly n times
text = "a aa aaa aaaa"
pattern = r"a{3}"
matches = re.findall(pattern, text)
print(matches)  # Output: ['aaa', 'aaa']

# {n,} - n or more times
pattern = r"a{3,}"
matches = re.findall(pattern, text)
print(matches)  # Output: ['aaa', 'aaaa']

# {n,m} - between n and m times
pattern = r"a{2,3}"
matches = re.findall(pattern, text)
print(matches)  # Output: ['aa', 'aaa', 'aaa']
```

### Greedy vs Non-Greedy

```python
import re

text = "<div>content</div>"

# Greedy (default) - matches as much as possible
pattern = r"<.*>"
match = re.search(pattern, text)
print(match.group())  # Output: <div>content</div>

# Non-greedy (lazy) - matches as little as possible
pattern = r"<.*?>"
match = re.search(pattern, text)
print(match.group())  # Output: <div>
```

---

## Anchors

### Start and End Anchors

```python
import re

# ^ - start of string
text = "hello world"
pattern = r"^hello"
match = re.search(pattern, text)
if match:
    print("Starts with hello")  # Output: Starts with hello

# $ - end of string
pattern = r"world$"
match = re.search(pattern, text)
if match:
    print("Ends with world")  # Output: Ends with world

# ^...$ - entire string
pattern = r"^hello world$"
match = re.search(pattern, text)
if match:
    print("Exact match")  # Output: Exact match
```

### Word Boundaries

```python
import re

# \b - word boundary
text = "the cat in the hat"
pattern = r"\bthe\b"  # Match 'the' as whole word
matches = re.findall(pattern, text)
print(matches)  # Output: ['the', 'the']

# Without word boundary
pattern = r"the"
matches = re.findall(pattern, text)
print(matches)  # Output: ['the', 'the', 'the'] (matches 'the' in 'the', 'the', 'the')

# \B - non-word boundary
text = "there"
pattern = r"\Bthe"
match = re.search(pattern, text)
if match:
    print("Found")  # Matches 'the' in 'there'
```

---

## Groups and Capturing

### Basic Groups

```python
import re

# () - capturing group
text = "Date: 2024-03-15"
pattern = r"(\d{4})-(\d{2})-(\d{2})"

match = re.search(pattern, text)
if match:
    print(f"Full match: {match.group()}")      # Output: 2024-03-15
    print(f"Group 1 (year): {match.group(1)}")  # Output: 2024
    print(f"Group 2 (month): {match.group(2)}")  # Output: 03
    print(f"Group 3 (day): {match.group(3)}")    # Output: 15
    print(f"All groups: {match.groups()}")       # Output: ('2024', '03', '15')
```

### Named Groups

```python
import re

text = "Date: 2024-03-15"
pattern = r"(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2})"

match = re.search(pattern, text)
if match:
    print(f"Year: {match.group('year')}")    # Output: 2024
    print(f"Month: {match.group('month')}")  # Output: 03
    print(f"Day: {match.group('day')}")     # Output: 15
    print(f"Dict: {match.groupdict()}")      # Output: {'year': '2024', 'month': '03', 'day': '15'}
```

### Non-Capturing Groups

```python
import re

# (?:...) - non-capturing group
text = "color colour"
pattern = r"colou?:r"  # ?: makes group non-capturing
match = re.search(pattern, text)
if match:
    print(match.groups())  # Output: () (no groups captured)
```

### Alternation

```python
import re

# | - OR operator
text = "cat dog bird"
pattern = r"cat|dog"

matches = re.findall(pattern, text)
print(matches)  # Output: ['cat', 'dog']

# With groups
pattern = r"(cat|dog|bird)"
matches = re.findall(pattern, text)
print(matches)  # Output: ['cat', 'dog', 'bird']
```

---

## Common Regex Patterns

### Email Pattern

```python
import re

# Basic email pattern
email_pattern = r"^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"

emails = [
    "user@example.com",
    "test.email@domain.co.uk",
    "invalid.email",
    "user@domain"
]

for email in emails:
    match = re.match(email_pattern, email)
    if match:
        print(f"Valid: {email}")
    else:
        print(f"Invalid: {email}")
```

### Phone Number Pattern

```python
import re

# US phone number pattern
phone_pattern = r"^(\+?1[-.\s]?)?\(?([0-9]{3})\)?[-.\s]?([0-9]{3})[-.\s]?([0-9]{4})$"

phones = [
    "(555) 123-4567",
    "555-123-4567",
    "555.123.4567",
    "5551234567",
    "+1-555-123-4567"
]

for phone in phones:
    match = re.match(phone_pattern, phone)
    if match:
        print(f"Valid: {phone}")
        print(f"Groups: {match.groups()}")
```

### URL Pattern

```python
import re

url_pattern = r"https?://(?:[-\w.])+(?:[:\d]+)?(?:/(?:[\w/_.])*)?(?:\?(?:[\w&=%.])*)?(?:#(?:\w)*)?"

urls = [
    "https://example.com",
    "http://example.com/path",
    "https://example.com:8080/path?query=value",
    "invalid-url"
]

for url in urls:
    match = re.match(url_pattern, url)
    if match:
        print(f"Valid: {url}")
```

### Date Pattern

```python
import re

# Date in YYYY-MM-DD format
date_pattern = r"^(\d{4})-(\d{2})-(\d{2})$"

dates = [
    "2024-03-15",
    "2024-3-15",  # Invalid (month needs leading zero)
    "24-03-15",   # Invalid (year needs 4 digits)
    "2024-13-15"  # Invalid (month > 12)
]

for date in dates:
    match = re.match(date_pattern, date)
    if match:
        year, month, day = match.groups()
        if 1 <= int(month) <= 12 and 1 <= int(day) <= 31:
            print(f"Valid: {date}")
        else:
            print(f"Invalid format: {date}")
    else:
        print(f"Invalid: {date}")
```

### Credit Card Pattern

```python
import re

# Credit card (simplified - just format check)
card_pattern = r"^\d{4}[\s-]?\d{4}[\s-]?\d{4}[\s-]?\d{4}$"

cards = [
    "1234 5678 9012 3456",
    "1234-5678-9012-3456",
    "1234567890123456",
    "1234 5678 9012"  # Invalid
]

for card in cards:
    match = re.match(card_pattern, card)
    if match:
        print(f"Valid format: {card}")
```

---

## Compiled Patterns

For efficiency when using the same pattern multiple times:

```python
import re

# Compile pattern once
pattern = re.compile(r"\d+")

# Use compiled pattern multiple times
text1 = "Price: $50"
text2 = "Price: $100"

match1 = pattern.search(text1)
match2 = pattern.search(text2)

if match1:
    print(f"Found in text1: {match1.group()}")
if match2:
    print(f"Found in text2: {match2.group()}")
```

### Compiled Pattern Methods

```python
import re

pattern = re.compile(r"\d+")

text = "The prices are $50, $100, and $200"

# All re module functions available as methods
match = pattern.search(text)
all_matches = pattern.findall(text)
new_text = pattern.sub("$XXX", text)
parts = pattern.split(text)

print(all_matches)  # Output: ['50', '100', '200']
```

---

## Regex Flags

Flags modify regex behavior:

```python
import re

# re.IGNORECASE (or re.I) - case insensitive
text = "Hello World"
pattern = r"hello"
match = re.search(pattern, text, re.IGNORECASE)
if match:
    print("Found (case insensitive)")

# re.MULTILINE (or re.M) - ^ and $ match line boundaries
text = "line1\nline2\nline3"
pattern = r"^line"
matches = re.findall(pattern, text, re.MULTILINE)
print(matches)  # Output: ['line', 'line', 'line']

# re.DOTALL (or re.S) - . matches newline too
text = "hello\nworld"
pattern = r"hello.world"
match = re.search(pattern, text, re.DOTALL)
if match:
    print("Found with DOTALL")

# re.VERBOSE (or re.X) - allow comments and whitespace
pattern = re.compile(r"""
    \d{4}      # Year
    -          # Separator
    \d{2}      # Month
    -          # Separator
    \d{2}      # Day
""", re.VERBOSE)

# Multiple flags
match = re.search(pattern, text, re.IGNORECASE | re.MULTILINE)
```

---

## Practical Examples

### Example 1: Extract Email Addresses

```python
import re

text = "Contact us at support@example.com or sales@company.com for help."
pattern = r"[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"

emails = re.findall(pattern, text)
print(emails)  # Output: ['support@example.com', 'sales@company.com']
```

### Example 2: Extract Phone Numbers

```python
import re

text = "Call us at (555) 123-4567 or 555-987-6543"
pattern = r"\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4}"

phones = re.findall(pattern, text)
print(phones)  # Output: ['(555) 123-4567', '555-987-6543']
```

### Example 3: Clean Text

```python
import re

text = "Hello!!!   World???   Python..."
# Remove multiple punctuation and spaces
cleaned = re.sub(r"[!?.]+", "", text)
cleaned = re.sub(r"\s+", " ", cleaned)
print(cleaned)  # Output: Hello   World   Python

# Better: combine patterns
cleaned = re.sub(r"[!?.]+\s*", " ", text)
print(cleaned)  # Output: Hello   World   Python
```

### Example 4: Extract URLs

```python
import re

text = "Visit https://example.com or http://test.org for more info."
pattern = r"https?://[^\s]+"

urls = re.findall(pattern, text)
print(urls)  # Output: ['https://example.com', 'http://test.org']
```

### Example 5: Parse Log Files

```python
import re

log_line = "2024-03-15 10:30:45 INFO User logged in from 192.168.1.1"
pattern = r"(\d{4}-\d{2}-\d{2}) (\d{2}:\d{2}:\d{2}) (\w+) (.+)"

match = re.match(pattern, log_line)
if match:
    date, time, level, message = match.groups()
    print(f"Date: {date}, Time: {time}, Level: {level}, Message: {message}")
```

### Example 6: Validate Password

```python
import re

def validate_password(password):
    """Check password strength with regex."""
    checks = {
        "length": len(password) >= 8,
        "has_upper": bool(re.search(r"[A-Z]", password)),
        "has_lower": bool(re.search(r"[a-z]", password)),
        "has_digit": bool(re.search(r"\d", password)),
        "has_special": bool(re.search(r"[!@#$%^&*(),.?\":{}|<>]", password))
    }
    return checks

password = "MyP@ssw0rd"
checks = validate_password(password)
print(checks)
```

### Example 7: Extract Data from HTML

```python
import re

html = '<div class="title">Hello World</div>'
pattern = r'<div[^>]*>([^<]+)</div>'

match = re.search(pattern, html)
if match:
    content = match.group(1)
    print(content)  # Output: Hello World
```

---

## Common Mistakes and Pitfalls

### 1. Not Using Raw Strings

```python
import re

# Wrong: backslash issues
pattern = "\d+"  # \d might be interpreted incorrectly

# Correct: use raw strings
pattern = r"\d+"  # \d is treated as regex metacharacter
```

### 2. Greedy Matching

```python
import re

# Wrong: greedy match
text = "<div>content</div><div>more</div>"
pattern = r"<div>.*</div>"
match = re.search(pattern, text)
print(match.group())  # Matches entire string

# Correct: non-greedy
pattern = r"<div>.*?</div>"
match = re.search(pattern, text)
print(match.group())  # Matches first div only
```

### 3. Not Anchoring Patterns

```python
import re

# Wrong: matches anywhere
text = "invalid@email.com is not valid"
pattern = r"[a-z]+@[a-z]+\.[a-z]+"
match = re.search(pattern, text)
if match:
    print("Found")  # Matches even though it's in invalid context

# Better: anchor if needed
pattern = r"^[a-z]+@[a-z]+\.[a-z]+$"
match = re.match(pattern, text)
if match:
    print("Valid email")
```

### 4. Forgetting to Escape Special Characters

```python
import re

# Wrong: . is special character
text = "file.txt"
pattern = r"file.txt"  # . matches any character
match = re.search(pattern, "filext")  # Matches!

# Correct: escape special characters
pattern = r"file\.txt"  # \. matches literal dot
match = re.search(pattern, "filext")  # Doesn't match
```

### 5. Overusing Regex

```python
import re

# Wrong: using regex for simple operation
text = "hello world"
pattern = r"world"
new_text = re.sub(pattern, "python", text)

# Better: use string methods
new_text = text.replace("world", "python")
```

---

## Best Practices

### 1. Use Raw Strings

```python
import re

# Always use raw strings for regex patterns
pattern = r"\d+"  # Good
# pattern = "\d+"  # Avoid
```

### 2. Compile Patterns for Repeated Use

```python
import re

# If using pattern multiple times
pattern = re.compile(r"\d+")

# Use compiled pattern
matches = pattern.findall(text1)
matches = pattern.findall(text2)
```

### 3. Use Verbose Mode for Complex Patterns

```python
import re

# Complex pattern with comments
pattern = re.compile(r"""
    ^
    [a-zA-Z0-9._%+-]+  # Username
    @                   # @ symbol
    [a-zA-Z0-9.-]+      # Domain
    \.                  # Dot
    [a-zA-Z]{2,}        # TLD
    $
""", re.VERBOSE)
```

### 4. Test Patterns Thoroughly

```python
import re

def test_pattern(pattern, test_cases):
    """Test regex pattern with multiple cases."""
    compiled = re.compile(pattern)
    for test, expected in test_cases:
        result = bool(compiled.match(test))
        status = "✓" if result == expected else "✗"
        print(f"{status} '{test}': {result} (expected {expected})")

# Test email pattern
pattern = r"^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
test_cases = [
    ("user@example.com", True),
    ("invalid", False),
    ("user@domain", False),
    ("@example.com", False)
]

test_pattern(pattern, test_cases)
```

### 5. Use Groups for Extraction

```python
import re

# Extract structured data
text = "Date: 2024-03-15"
pattern = r"(\d{4})-(\d{2})-(\d{2})"

match = re.search(pattern, text)
if match:
    year, month, day = match.groups()
    # Use extracted values
```

---

## Practice Exercise

### Exercise: Regex Practice

**Objective**: Create a Python program that demonstrates various regex patterns and operations.

**Instructions**:

1. Create a file called `regex_practice.py`

2. Write a program that:
   - Validates common patterns (email, phone, etc.)
   - Extracts data from text
   - Replaces text using patterns
   - Demonstrates regex flags
   - Uses groups and capturing
   - Implements practical regex utilities

3. Your program should include:
   - Email validation
   - Phone number extraction
   - URL extraction
   - Text cleaning
   - Data extraction
   - Pattern testing utilities

**Example Solution**:

```python
"""
Regular Expressions Practice
This program demonstrates various regex patterns and operations.
"""

import re

print("=" * 60)
print("REGULAR EXPRESSIONS PRACTICE")
print("=" * 60)
print()

# 1. Basic Patterns
print("1. BASIC PATTERNS")
print("-" * 60)
text = "The price is $50"
pattern = r"\$\d+"
match = re.search(pattern, text)
if match:
    print(f"Found: {match.group()}")
print()

# 2. Character Classes
print("2. CHARACTER CLASSES")
print("-" * 60)
text = "Hello123 World!"
print(f"Text: {text}")
print(f"Digits: {re.findall(r'\d', text)}")
print(f"Letters: {re.findall(r'[a-zA-Z]', text)}")
print(f"Word chars: {re.findall(r'\w', text)}")
print()

# 3. Quantifiers
print("3. QUANTIFIERS")
print("-" * 60)
text = "a aa aaa aaaa"
print(f"Text: {text}")
print(f"One or more: {re.findall(r'a+', text)}")
print(f"Exactly 3: {re.findall(r'a{3}', text)}")
print(f"2 to 3: {re.findall(r'a{2,3}', text)}")
print()

# 4. Anchors
print("4. ANCHORS")
print("-" * 60)
text = "hello world"
print(f"Text: {text}")
print(f"Starts with 'hello': {bool(re.match(r'^hello', text))}")
print(f"Ends with 'world': {bool(re.search(r'world$', text))}")
print(f"Word boundary: {re.findall(r'\\bhello\\b', text)}")
print()

# 5. Groups
print("5. GROUPS")
print("-" * 60)
text = "Date: 2024-03-15"
pattern = r"(\d{4})-(\d{2})-(\d{2})"
match = re.search(pattern, text)
if match:
    print(f"Full match: {match.group()}")
    print(f"Groups: {match.groups()}")
    print(f"Year: {match.group(1)}, Month: {match.group(2)}, Day: {match.group(3)}")
print()

# 6. Named Groups
print("6. NAMED GROUPS")
print("-" * 60)
text = "Date: 2024-03-15"
pattern = r"(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2})"
match = re.search(pattern, text)
if match:
    print(f"Year: {match.group('year')}")
    print(f"Month: {match.group('month')}")
    print(f"Day: {match.group('day')}")
    print(f"Dict: {match.groupdict()}")
print()

# 7. Email Validation
print("7. EMAIL VALIDATION")
print("-" * 60)
email_pattern = r"^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$"
emails = [
    "user@example.com",
    "test.email@domain.co.uk",
    "invalid.email",
    "user@domain"
]

for email in emails:
    match = re.match(email_pattern, email)
    status = "Valid" if match else "Invalid"
    print(f"{status}: {email}")
print()

# 8. Phone Number Extraction
print("8. PHONE NUMBER EXTRACTION")
print("-" * 60)
text = "Call us at (555) 123-4567 or 555-987-6543"
pattern = r"\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4}"
phones = re.findall(pattern, text)
print(f"Text: {text}")
print(f"Phone numbers: {phones}")
print()

# 9. URL Extraction
print("9. URL EXTRACTION")
print("-" * 60)
text = "Visit https://example.com or http://test.org for more info."
pattern = r"https?://[^\s]+"
urls = re.findall(pattern, text)
print(f"Text: {text}")
print(f"URLs: {urls}")
print()

# 10. Text Cleaning
print("10. TEXT CLEANING")
print("-" * 60)
text = "Hello!!!   World???   Python..."
print(f"Original: '{text}'")
# Remove multiple punctuation
cleaned = re.sub(r"[!?.]+", "", text)
# Normalize spaces
cleaned = re.sub(r"\s+", " ", cleaned)
print(f"Cleaned: '{cleaned}'")
print()

# 11. Find All with Groups
print("11. FIND ALL WITH GROUPS")
print("-" * 60)
text = "Dates: 2024-03-15, 2024-04-20, 2024-05-10"
pattern = r"(\d{4})-(\d{2})-(\d{2})"
matches = re.findall(pattern, text)
print(f"Text: {text}")
print(f"Dates found: {matches}")
for year, month, day in matches:
    print(f"  {year}-{month}-{day}")
print()

# 12. Find Iter
print("12. FIND ITER")
print("-" * 60)
text = "The prices are $50, $100, and $200"
pattern = r"\$\d+"
print(f"Text: {text}")
for match in re.finditer(pattern, text):
    print(f"Found: {match.group()} at position {match.start()}-{match.end()}")
print()

# 13. Split by Pattern
print("13. SPLIT BY PATTERN")
print("-" * 60)
text = "apple,banana;cherry:grape"
pattern = r"[,;:]"
parts = re.split(pattern, text)
print(f"Text: {text}")
print(f"Split: {parts}")
print()

# 14. Flags
print("14. FLAGS")
print("-" * 60)
text = "Hello WORLD"
pattern = r"hello"
# Case insensitive
match = re.search(pattern, text, re.IGNORECASE)
if match:
    print(f"Found (case insensitive): {match.group()}")

# Multiline
text = "line1\\nline2\\nline3"
pattern = r"^line"
matches = re.findall(pattern, text, re.MULTILINE)
print(f"Multiline matches: {matches}")
print()

# 15. Compiled Patterns
print("15. COMPILED PATTERNS")
print("-" * 60)
pattern = re.compile(r"\d+")
text1 = "Price: $50"
text2 = "Price: $100"
match1 = pattern.search(text1)
match2 = pattern.search(text2)
print(f"Text1: {match1.group() if match1 else 'Not found'}")
print(f"Text2: {match2.group() if match2 else 'Not found'}")
print()

# 16. Greedy vs Non-Greedy
print("16. GREEDY VS NON-GREEDY")
print("-" * 60)
text = "<div>content</div><div>more</div>"
# Greedy
greedy_pattern = r"<div>.*</div>"
match = re.search(greedy_pattern, text)
print(f"Greedy: {match.group() if match else 'Not found'}")

# Non-greedy
non_greedy_pattern = r"<div>.*?</div>"
match = re.search(non_greedy_pattern, text)
print(f"Non-greedy: {match.group() if match else 'Not found'}")
print()

# 17. Password Validation
print("17. PASSWORD VALIDATION")
print("-" * 60)
def validate_password(password):
    checks = {
        "length": len(password) >= 8,
        "has_upper": bool(re.search(r"[A-Z]", password)),
        "has_lower": bool(re.search(r"[a-z]", password)),
        "has_digit": bool(re.search(r"\d", password)),
        "has_special": bool(re.search(r"[!@#$%^&*(),.?\":{}|<>]", password))
    }
    return checks

password = "MyP@ssw0rd"
checks = validate_password(password)
print(f"Password: {password}")
for check, result in checks.items():
    status = "✓" if result else "✗"
    print(f"  {status} {check}")
print()

# 18. Extract Data from Text
print("18. EXTRACT DATA FROM TEXT")
print("-" * 60)
text = "Name: John Doe, Age: 30, Email: john@example.com"
name_pattern = r"Name:\s*([^,]+)"
age_pattern = r"Age:\s*(\d+)"
email_pattern = r"Email:\s*([^\s]+)"

name_match = re.search(name_pattern, text)
age_match = re.search(age_pattern, text)
email_match = re.search(email_pattern, text)

print(f"Text: {text}")
if name_match:
    print(f"Name: {name_match.group(1)}")
if age_match:
    print(f"Age: {age_match.group(1)}")
if email_match:
    print(f"Email: {email_match.group(1)}")
print()

# 19. Replace with Function
print("19. REPLACE WITH FUNCTION")
print("-" * 60)
def double_number(match):
    number = int(match.group())
    return str(number * 2)

text = "I have 5 apples and 10 oranges"
pattern = r"\d+"
result = re.sub(pattern, double_number, text)
print(f"Original: {text}")
print(f"Result: {result}")
print()

# 20. Complex Pattern
print("20. COMPLEX PATTERN")
print("-" * 60)
# Parse log line
log_line = "2024-03-15 10:30:45 INFO User logged in from 192.168.1.1"
pattern = r"(\d{4}-\d{2}-\d{2}) (\d{2}:\d{2}:\d{2}) (\w+) (.+)"
match = re.match(pattern, log_line)
if match:
    date, time, level, message = match.groups()
    print(f"Log: {log_line}")
    print(f"Date: {date}")
    print(f"Time: {time}")
    print(f"Level: {level}")
    print(f"Message: {message}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
REGULAR EXPRESSIONS PRACTICE
============================================================

1. BASIC PATTERNS
------------------------------------------------------------
Found: $50

[... rest of output ...]
```

**Challenge** (Optional):
- Build a regex tester tool
- Create a log file parser
- Build a data extraction tool
- Implement a text validator
- Create a search and replace utility

---

## Key Takeaways

1. **Regular expressions** are powerful pattern-matching tools
2. **Use raw strings** (`r""`) for regex patterns to avoid escape issues
3. **Basic functions**: `search()`, `match()`, `findall()`, `finditer()`, `sub()`, `split()`
4. **Character classes**: `[abc]`, `[a-z]`, `\d`, `\w`, `\s` and their negations
5. **Quantifiers**: `*`, `+`, `?`, `{n}`, `{n,m}` (greedy vs non-greedy)
6. **Anchors**: `^` (start), `$` (end), `\b` (word boundary)
7. **Groups**: `()` for capturing, `(?P<name>...)` for named groups
8. **Flags**: `re.IGNORECASE`, `re.MULTILINE`, `re.DOTALL`, `re.VERBOSE`
9. **Compile patterns** for repeated use with `re.compile()`
10. **Common patterns**: email, phone, URL, date validation
11. **Test thoroughly** - regex can be tricky
12. **Don't overuse** - simple string methods are often better

---

## Quiz: Regular Expressions

Test your understanding with these questions:

1. **What does `\d` match in regex?**
   - A) Any character
   - B) Any digit [0-9]
   - C) Any letter
   - D) Dot character

2. **What does `r"\d+"` mean?**
   - A) One digit
   - B) Zero or more digits
   - C) One or more digits
   - D) Exactly one digit

3. **What does `^` match?**
   - A) End of string
   - B) Start of string
   - C) Any character
   - D) Word boundary

4. **What does `.*?` mean?**
   - A) Greedy match
   - B) Non-greedy match
   - C) Match nothing
   - D) Error

5. **What does `re.search()` do?**
   - A) Match only at start
   - B) Find first match anywhere
   - C) Find all matches
   - D) Replace matches

6. **What does `()` do in regex?**
   - A) Groups characters
   - B) Makes optional
   - C) Escapes character
   - D) Anchors pattern

7. **What flag makes regex case-insensitive?**
   - A) `re.CASE`
   - B) `re.IGNORECASE`
   - C) `re.NOCASE`
   - D) `re.CASELESS`

8. **What does `\b` match?**
   - A) Backspace
   - B) Word boundary
   - C) Beginning of string
   - D) End of string

9. **What does `re.findall()` return?**
   - A) First match
   - B) List of all matches
   - C) Match object
   - D) Boolean

10. **Why use raw strings for regex?**
    - A) Faster execution
    - B) Avoid escape issues
    - C) Required syntax
    - D) No reason

**Answers**:
1. B) Any digit [0-9] (\d matches digits)
2. C) One or more digits (+ means one or more)
3. B) Start of string (^ anchors to start)
4. B) Non-greedy match (? makes * non-greedy)
5. B) Find first match anywhere (search finds anywhere, match only at start)
6. A) Groups characters (parentheses create capturing groups)
7. B) `re.IGNORECASE` (makes pattern case-insensitive)
8. B) Word boundary (\b matches word boundaries)
9. B) List of all matches (findall returns list of strings)
10. B) Avoid escape issues (raw strings prevent Python from interpreting backslashes)

---

## Next Steps

Excellent work! You've mastered regular expressions. You now understand:
- How to write and use regex patterns
- Common metacharacters and special sequences
- The `re` module functions
- Pattern compilation and flags
- Practical applications of regex

**What's Next?**
- Module 8: File Handling
- Practice with more complex patterns
- Learn about regex optimization
- Explore advanced regex features

---

## Additional Resources

- **re Module**: [docs.python.org/3/library/re.html](https://docs.python.org/3/library/re.html)
- **Regular Expression HOWTO**: [docs.python.org/3/howto/regex.html](https://docs.python.org/3/howto/regex.html)
- **Regex Tester**: Use online tools like regex101.com to test patterns

---

*Lesson completed! You're ready to move on to the next lesson.*

