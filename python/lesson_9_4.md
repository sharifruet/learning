# Lesson 9.4: Working with Different File Formats

## Learning Objectives

By the end of this lesson, you will be able to:
- Read and write CSV files using the `csv` module
- Work with JSON files using the `json` module
- Understand XML file basics with the `xml` module
- Parse and create structured data files
- Handle different data formats appropriately
- Convert between different file formats
- Work with dictionaries and lists in file formats
- Handle encoding and formatting issues
- Apply file format operations in practical scenarios

---

## Introduction to File Formats

Different file formats serve different purposes:
- **CSV**: Tabular data, spreadsheets
- **JSON**: Structured data, APIs, configuration
- **XML**: Structured data, documents, configuration

Each format has its strengths and use cases.

---

## CSV Files (Comma-Separated Values)

CSV files store tabular data in plain text, with values separated by commas (or other delimiters).

### Reading CSV Files

#### Basic Reading

```python
import csv

# Read CSV file
with open("data.csv", "r") as file:
    reader = csv.reader(file)
    for row in reader:
        print(row)
```

#### Reading as Dictionary

```python
import csv

# Read CSV as dictionary (uses header row as keys)
with open("data.csv", "r") as file:
    reader = csv.DictReader(file)
    for row in reader:
        print(row)  # Each row is a dictionary
        print(row["name"])  # Access by column name
```

#### Example CSV File

```csv
name,age,city
Alice,30,New York
Bob,25,London
Charlie,35,Tokyo
```

#### Reading Example

```python
import csv

with open("people.csv", "r") as file:
    reader = csv.DictReader(file)
    for person in reader:
        print(f"{person['name']} is {person['age']} years old from {person['city']}")
```

### Writing CSV Files

#### Basic Writing

```python
import csv

# Write CSV file
data = [
    ["name", "age", "city"],
    ["Alice", "30", "New York"],
    ["Bob", "25", "London"],
    ["Charlie", "35", "Tokyo"]
]

with open("output.csv", "w", newline="") as file:
    writer = csv.writer(file)
    writer.writerows(data)
```

#### Writing as Dictionary

```python
import csv

# Write CSV from dictionaries
data = [
    {"name": "Alice", "age": "30", "city": "New York"},
    {"name": "Bob", "age": "25", "city": "London"},
    {"name": "Charlie", "age": "35", "city": "Tokyo"}
]

with open("output.csv", "w", newline="") as file:
    fieldnames = ["name", "age", "city"]
    writer = csv.DictWriter(file, fieldnames=fieldnames)
    writer.writeheader()  # Write header row
    writer.writerows(data)
```

### CSV Options

#### Custom Delimiter

```python
import csv

# Use semicolon as delimiter
with open("data.csv", "r") as file:
    reader = csv.reader(file, delimiter=";")
    for row in reader:
        print(row)
```

#### Custom Quote Character

```python
import csv

# Use single quote
with open("data.csv", "r") as file:
    reader = csv.reader(file, quotechar="'")
    for row in reader:
        print(row)
```

#### Skip Initial Space

```python
import csv

# Skip whitespace after delimiter
with open("data.csv", "r") as file:
    reader = csv.reader(file, skipinitialspace=True)
    for row in reader:
        print(row)
```

### Complete CSV Example

```python
import csv

# Write CSV
people = [
    {"name": "Alice", "age": 30, "city": "New York"},
    {"name": "Bob", "age": 25, "city": "London"},
    {"name": "Charlie", "age": 35, "city": "Tokyo"}
]

with open("people.csv", "w", newline="") as file:
    writer = csv.DictWriter(file, fieldnames=["name", "age", "city"])
    writer.writeheader()
    writer.writerows(people)

# Read CSV
with open("people.csv", "r") as file:
    reader = csv.DictReader(file)
    for person in reader:
        print(f"{person['name']}: {person['age']} years, {person['city']}")
```

---

## JSON Files (JavaScript Object Notation)

JSON is a lightweight data-interchange format, easy for humans to read and write, and easy for machines to parse.

### Reading JSON Files

#### Basic Reading

```python
import json

# Read JSON file
with open("data.json", "r") as file:
    data = json.load(file)
    print(data)
```

#### Example JSON File

```json
{
    "name": "Alice",
    "age": 30,
    "city": "New York",
    "hobbies": ["reading", "coding", "traveling"]
}
```

#### Reading Example

```python
import json

with open("person.json", "r") as file:
    person = json.load(file)
    print(f"Name: {person['name']}")
    print(f"Age: {person['age']}")
    print(f"Hobbies: {', '.join(person['hobbies'])}")
```

### Writing JSON Files

#### Basic Writing

```python
import json

# Write JSON file
data = {
    "name": "Alice",
    "age": 30,
    "city": "New York",
    "hobbies": ["reading", "coding", "traveling"]
}

with open("output.json", "w") as file:
    json.dump(data, file)
```

#### Pretty Printing

```python
import json

data = {
    "name": "Alice",
    "age": 30,
    "city": "New York"
}

# Pretty print with indentation
with open("output.json", "w") as file:
    json.dump(data, file, indent=4)
```

#### JSON String Operations

```python
import json

# Convert Python object to JSON string
data = {"name": "Alice", "age": 30}
json_string = json.dumps(data)
print(json_string)  # Output: {"name": "Alice", "age": 30}

# Convert JSON string to Python object
python_obj = json.loads(json_string)
print(python_obj)  # Output: {'name': 'Alice', 'age': 30}
```

### JSON Options

#### Indentation

```python
import json

data = {"name": "Alice", "age": 30}

# Pretty print
json_string = json.dumps(data, indent=2)
print(json_string)
```

#### Sorting Keys

```python
import json

data = {"zebra": 1, "apple": 2, "banana": 3}

# Sort keys
json_string = json.dumps(data, sort_keys=True)
print(json_string)  # Keys sorted alphabetically
```

#### Custom Separators

```python
import json

data = {"name": "Alice", "age": 30}

# Custom separators (compact format)
json_string = json.dumps(data, separators=(",", ":"))
print(json_string)
```

### Complete JSON Example

```python
import json

# Write JSON
people = [
    {"name": "Alice", "age": 30, "city": "New York"},
    {"name": "Bob", "age": 25, "city": "London"},
    {"name": "Charlie", "age": 35, "city": "Tokyo"}
]

with open("people.json", "w") as file:
    json.dump(people, file, indent=2)

# Read JSON
with open("people.json", "r") as file:
    people = json.load(file)
    for person in people:
        print(f"{person['name']}: {person['age']} years, {person['city']}")
```

---

## XML Files (eXtensible Markup Language)

XML is a markup language that defines rules for encoding documents in a format that is both human-readable and machine-readable.

### Basic XML Structure

```xml
<?xml version="1.0" encoding="UTF-8"?>
<root>
    <person>
        <name>Alice</name>
        <age>30</age>
        <city>New York</city>
    </person>
    <person>
        <name>Bob</name>
        <age>25</age>
        <city>London</city>
    </person>
</root>
```

### Reading XML Files

#### Using `xml.etree.ElementTree`

```python
import xml.etree.ElementTree as ET

# Parse XML file
tree = ET.parse("data.xml")
root = tree.getroot()

# Access elements
for person in root.findall("person"):
    name = person.find("name").text
    age = person.find("age").text
    city = person.find("city").text
    print(f"{name}: {age} years, {city}")
```

#### Reading Example

```python
import xml.etree.ElementTree as ET

tree = ET.parse("people.xml")
root = tree.getroot()

for person in root:
    name = person.find("name").text
    age = person.find("age").text
    print(f"{name} is {age} years old")
```

### Writing XML Files

#### Creating XML

```python
import xml.etree.ElementTree as ET

# Create root element
root = ET.Element("people")

# Create person elements
person1 = ET.SubElement(root, "person")
ET.SubElement(person1, "name").text = "Alice"
ET.SubElement(person1, "age").text = "30"
ET.SubElement(person1, "city").text = "New York"

person2 = ET.SubElement(root, "person")
ET.SubElement(person2, "name").text = "Bob"
ET.SubElement(person2, "age").text = "25"
ET.SubElement(person2, "city").text = "London"

# Create tree and write
tree = ET.ElementTree(root)
tree.write("output.xml", encoding="utf-8", xml_declaration=True)
```

#### Pretty Printing XML

```python
import xml.etree.ElementTree as ET
from xml.dom import minidom

# Create XML
root = ET.Element("people")
person = ET.SubElement(root, "person")
ET.SubElement(person, "name").text = "Alice"
ET.SubElement(person, "age").text = "30"

# Pretty print
rough_string = ET.tostring(root, encoding="unicode")
reparsed = minidom.parseString(rough_string)
pretty = reparsed.toprettyxml(indent="  ")

with open("output.xml", "w") as file:
    file.write(pretty)
```

### XML Attributes

```python
import xml.etree.ElementTree as ET

# Create element with attributes
root = ET.Element("people")
person = ET.SubElement(root, "person", id="1", active="true")
ET.SubElement(person, "name").text = "Alice"
ET.SubElement(person, "age").text = "30"

# Read attributes
tree = ET.ElementTree(root)
for person in tree.getroot():
    person_id = person.get("id")
    active = person.get("active")
    print(f"Person ID: {person_id}, Active: {active}")
```

---

## Practical Examples

### Example 1: CSV to JSON Converter

```python
import csv
import json

def csv_to_json(csv_file, json_file):
    """Convert CSV file to JSON file."""
    data = []
    
    # Read CSV
    with open(csv_file, "r") as file:
        reader = csv.DictReader(file)
        for row in reader:
            data.append(row)
    
    # Write JSON
    with open(json_file, "w") as file:
        json.dump(data, file, indent=2)

csv_to_json("people.csv", "people.json")
```

### Example 2: JSON to CSV Converter

```python
import csv
import json

def json_to_csv(json_file, csv_file):
    """Convert JSON file to CSV file."""
    # Read JSON
    with open(json_file, "r") as file:
        data = json.load(file)
    
    # Write CSV
    if data:
        with open(csv_file, "w", newline="") as file:
            writer = csv.DictWriter(file, fieldnames=data[0].keys())
            writer.writeheader()
            writer.writerows(data)

json_to_csv("people.json", "people.csv")
```

### Example 3: Processing CSV Data

```python
import csv

def process_csv(filename):
    """Process CSV and calculate statistics."""
    total_age = 0
    count = 0
    cities = {}
    
    with open(filename, "r") as file:
        reader = csv.DictReader(file)
        for row in reader:
            age = int(row["age"])
            total_age += age
            count += 1
            
            city = row["city"]
            cities[city] = cities.get(city, 0) + 1
    
    if count > 0:
        avg_age = total_age / count
        print(f"Average age: {avg_age:.2f}")
        print(f"City distribution: {cities}")

process_csv("people.csv")
```

### Example 4: Config File with JSON

```python
import json
from pathlib import Path

class Config:
    def __init__(self, config_file="config.json"):
        self.config_file = Path(config_file)
        self.data = self.load()
    
    def load(self):
        """Load configuration from file."""
        if self.config_file.exists():
            with open(self.config_file, "r") as file:
                return json.load(file)
        return {}
    
    def save(self):
        """Save configuration to file."""
        with open(self.config_file, "w") as file:
            json.dump(self.data, file, indent=2)
    
    def get(self, key, default=None):
        """Get configuration value."""
        return self.data.get(key, default)
    
    def set(self, key, value):
        """Set configuration value."""
        self.data[key] = value
        self.save()

# Use it
config = Config()
config.set("database_host", "localhost")
config.set("database_port", 5432)
print(config.get("database_host"))
```

### Example 5: XML Data Processing

```python
import xml.etree.ElementTree as ET

def process_xml(filename):
    """Process XML file and extract data."""
    tree = ET.parse(filename)
    root = tree.getroot()
    
    results = []
    for person in root.findall("person"):
        data = {
            "name": person.find("name").text,
            "age": int(person.find("age").text),
            "city": person.find("city").text
        }
        results.append(data)
    
    return results

people = process_xml("people.xml")
for person in people:
    print(person)
```

---

## Common Mistakes and Pitfalls

### 1. Forgetting `newline=""` in CSV Writing

```python
# WRONG: Extra blank lines in CSV
with open("data.csv", "w") as file:
    writer = csv.writer(file)
    writer.writerow(["a", "b", "c"])

# CORRECT: Use newline=""
with open("data.csv", "w", newline="") as file:
    writer = csv.writer(file)
    writer.writerow(["a", "b", "c"])
```

### 2. Not Handling JSON Encoding

```python
# WRONG: May fail with special characters
with open("data.json", "w") as file:
    json.dump(data, file)

# CORRECT: Specify encoding
with open("data.json", "w", encoding="utf-8") as file:
    json.dump(data, file)
```

### 3. Not Validating JSON

```python
# WRONG: Assume JSON is valid
data = json.load(file)

# CORRECT: Handle JSON errors
try:
    data = json.load(file)
except json.JSONDecodeError as e:
    print(f"Invalid JSON: {e}")
```

### 4. XML Namespace Issues

```python
# WRONG: May not find elements with namespaces
root.find("element")

# CORRECT: Handle namespaces
namespaces = {"ns": "http://example.com/ns"}
root.find("ns:element", namespaces)
```

---

## Best Practices

### 1. Always Use Context Managers

```python
# Good
with open("data.json", "r") as file:
    data = json.load(file)
```

### 2. Handle Encoding Explicitly

```python
# Good: Specify encoding
with open("data.json", "r", encoding="utf-8") as file:
    data = json.load(file)
```

### 3. Validate Data

```python
# Good: Validate before processing
try:
    data = json.load(file)
except json.JSONDecodeError:
    print("Invalid JSON")
```

### 4. Use Appropriate Format

```python
# CSV: Tabular data
# JSON: Structured data, APIs
# XML: Documents, complex structures
```

### 5. Pretty Print for Readability

```python
# Good: Pretty print JSON
json.dump(data, file, indent=2)
```

---

## Practice Exercise

### Exercise: File Formats

**Objective**: Create a Python program that demonstrates working with different file formats.

**Instructions**:

1. Create a file called `file_formats_practice.py`

2. Write a program that:
   - Reads and writes CSV files
   - Reads and writes JSON files
   - Reads and writes XML files
   - Converts between formats
   - Processes data from files

3. Your program should include:
   - CSV operations
   - JSON operations
   - XML operations
   - Format conversion
   - Data processing

**Example Solution**:

```python
"""
File Formats Practice
This program demonstrates working with CSV, JSON, and XML files.
"""

import csv
import json
import xml.etree.ElementTree as ET
from pathlib import Path

print("=" * 60)
print("FILE FORMATS PRACTICE")
print("=" * 60)
print()

# Sample data
people_data = [
    {"name": "Alice", "age": 30, "city": "New York"},
    {"name": "Bob", "age": 25, "city": "London"},
    {"name": "Charlie", "age": 35, "city": "Tokyo"}
]

# 1. Writing CSV
print("1. WRITING CSV")
print("-" * 60)
with open("people.csv", "w", newline="") as file:
    writer = csv.DictWriter(file, fieldnames=["name", "age", "city"])
    writer.writeheader()
    writer.writerows(people_data)
print("Created people.csv")
print()

# 2. Reading CSV
print("2. READING CSV")
print("-" * 60)
with open("people.csv", "r") as file:
    reader = csv.DictReader(file)
    for person in reader:
        print(f"{person['name']}: {person['age']} years, {person['city']}")
print()

# 3. Writing JSON
print("3. WRITING JSON")
print("-" * 60)
with open("people.json", "w") as file:
    json.dump(people_data, file, indent=2)
print("Created people.json")
print()

# 4. Reading JSON
print("4. READING JSON")
print("-" * 60)
with open("people.json", "r") as file:
    data = json.load(file)
    for person in data:
        print(f"{person['name']}: {person['age']} years, {person['city']}")
print()

# 5. JSON pretty printing
print("5. JSON PRETTY PRINTING")
print("-" * 60)
json_string = json.dumps(people_data, indent=2, sort_keys=True)
print(json_string)
print()

# 6. JSON string operations
print("6. JSON STRING OPERATIONS")
print("-" * 60)
# Convert to JSON string
json_str = json.dumps({"name": "Alice", "age": 30})
print(f"JSON string: {json_str}")

# Convert from JSON string
python_obj = json.loads(json_str)
print(f"Python object: {python_obj}")
print()

# 7. Writing XML
print("7. WRITING XML")
print("-" * 60)
root = ET.Element("people")
for person_data in people_data:
    person = ET.SubElement(root, "person")
    ET.SubElement(person, "name").text = person_data["name"]
    ET.SubElement(person, "age").text = str(person_data["age"])
    ET.SubElement(person, "city").text = person_data["city"]

tree = ET.ElementTree(root)
tree.write("people.xml", encoding="utf-8", xml_declaration=True)
print("Created people.xml")
print()

# 8. Reading XML
print("8. READING XML")
print("-" * 60)
tree = ET.parse("people.xml")
root = tree.getroot()
for person in root.findall("person"):
    name = person.find("name").text
    age = person.find("age").text
    city = person.find("city").text
    print(f"{name}: {age} years, {city}")
print()

# 9. CSV to JSON conversion
print("9. CSV TO JSON CONVERSION")
print("-" * 60)
data = []
with open("people.csv", "r") as file:
    reader = csv.DictReader(file)
    for row in reader:
        data.append(row)

with open("converted.json", "w") as file:
    json.dump(data, file, indent=2)
print("Converted people.csv to converted.json")
print()

# 10. JSON to CSV conversion
print("10. JSON TO CSV CONVERSION")
print("-" * 60)
with open("people.json", "r") as file:
    data = json.load(file)

if data:
    with open("converted.csv", "w", newline="") as file:
        writer = csv.DictWriter(file, fieldnames=data[0].keys())
        writer.writeheader()
        writer.writerows(data)
    print("Converted people.json to converted.csv")
print()

# 11. Processing CSV data
print("11. PROCESSING CSV DATA")
print("-" * 60)
total_age = 0
count = 0
cities = {}

with open("people.csv", "r") as file:
    reader = csv.DictReader(file)
    for row in reader:
        age = int(row["age"])
        total_age += age
        count += 1
        city = row["city"]
        cities[city] = cities.get(city, 0) + 1

if count > 0:
    avg_age = total_age / count
    print(f"Average age: {avg_age:.2f}")
    print(f"City distribution: {cities}")
print()

# 12. JSON with nested data
print("12. JSON WITH NESTED DATA")
print("-" * 60)
nested_data = {
    "company": "Tech Corp",
    "employees": [
        {"name": "Alice", "department": "Engineering", "skills": ["Python", "Java"]},
        {"name": "Bob", "department": "Marketing", "skills": ["Design", "Writing"]}
    ]
}

with open("company.json", "w") as file:
    json.dump(nested_data, file, indent=2)

with open("company.json", "r") as file:
    data = json.load(file)
    print(f"Company: {data['company']}")
    for emp in data["employees"]:
        print(f"  {emp['name']} - {emp['department']}: {', '.join(emp['skills'])}")
print()

# 13. XML with attributes
print("13. XML WITH ATTRIBUTES")
print("-" * 60)
root = ET.Element("people")
for i, person_data in enumerate(people_data, 1):
    person = ET.SubElement(root, "person", id=str(i))
    ET.SubElement(person, "name").text = person_data["name"]
    ET.SubElement(person, "age").text = str(person_data["age"])

tree = ET.ElementTree(root)
tree.write("people_attrs.xml", encoding="utf-8", xml_declaration=True)

# Read with attributes
tree = ET.parse("people_attrs.xml")
for person in tree.getroot():
    person_id = person.get("id")
    name = person.find("name").text
    print(f"Person ID {person_id}: {name}")
print()

# 14. Error handling
print("14. ERROR HANDLING")
print("-" * 60)
# JSON error handling
try:
    with open("invalid.json", "r") as file:
        data = json.load(file)
except FileNotFoundError:
    print("File not found")
except json.JSONDecodeError as e:
    print(f"Invalid JSON: {e}")

# CSV error handling
try:
    with open("nonexistent.csv", "r") as file:
        reader = csv.DictReader(file)
        for row in reader:
            print(row)
except FileNotFoundError:
    print("CSV file not found")
print()

# 15. Custom CSV delimiter
print("15. CUSTOM CSV DELIMITER")
print("-" * 60)
# Write with semicolon delimiter
with open("people_semicolon.csv", "w", newline="") as file:
    writer = csv.writer(file, delimiter=";")
    writer.writerow(["name", "age", "city"])
    for person in people_data:
        writer.writerow([person["name"], person["age"], person["city"]])

# Read with semicolon delimiter
with open("people_semicolon.csv", "r") as file:
    reader = csv.reader(file, delimiter=";")
    for row in reader:
        print(row)
print()

# Cleanup
print("Cleaning up test files...")
test_files = [
    "people.csv", "people.json", "people.xml",
    "converted.json", "converted.csv",
    "company.json", "people_attrs.xml",
    "people_semicolon.csv"
]
for filename in test_files:
    if Path(filename).exists():
        Path(filename).unlink()
        print(f"Removed {filename}")

print()
print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
FILE FORMATS PRACTICE
============================================================

1. WRITING CSV
------------------------------------------------------------
Created people.csv

[... rest of output ...]
```

**Challenge** (Optional):
- Create a data export/import system
- Build a configuration file manager
- Create a data validation tool
- Implement a format converter utility

---

## Key Takeaways

1. **CSV files** store tabular data, use `csv` module
2. **JSON files** store structured data, use `json` module
3. **XML files** store structured documents, use `xml.etree.ElementTree`
4. **CSV reading**: `csv.reader()` or `csv.DictReader()`
5. **CSV writing**: `csv.writer()` or `csv.DictWriter()`
6. **Use `newline=""`** when writing CSV files
7. **JSON reading**: `json.load()` for files, `json.loads()` for strings
8. **JSON writing**: `json.dump()` for files, `json.dumps()` for strings
9. **JSON pretty print**: Use `indent` parameter
10. **XML parsing**: Use `ET.parse()` or `ET.fromstring()`
11. **XML creation**: Use `ET.Element()` and `ET.SubElement()`
12. **Always use context managers** (`with` statement)
13. **Handle encoding** explicitly (UTF-8)
14. **Validate data** before processing
15. **Choose appropriate format** for your use case

---

## Quiz: File Formats

Test your understanding with these questions:

1. **What module is used for CSV files?**
   - A) `csv`
   - B) `json`
   - C) `xml`
   - D) `file`

2. **What does `csv.DictReader()` return?**
   - A) List of lists
   - B) List of dictionaries
   - C) Dictionary
   - D) String

3. **What parameter should you use when writing CSV files?**
   - A) `encoding="utf-8"`
   - B) `newline=""`
   - C) `mode="w"`
   - D) `delimiter=","`

4. **What does `json.load()` do?**
   - A) Converts Python to JSON string
   - B) Reads JSON from file
   - C) Writes JSON to file
   - D) Validates JSON

5. **What does `json.dumps()` return?**
   - A) File object
   - B) Python object
   - C) JSON string
   - D) Dictionary

6. **What module is used for XML?**
   - A) `csv`
   - B) `json`
   - C) `xml.etree.ElementTree`
   - D) `xml`

7. **What method parses an XML file?**
   - A) `ET.parse()`
   - B) `ET.read()`
   - C) `ET.load()`
   - D) `ET.open()`

8. **What creates an XML element?**
   - A) `ET.Element()`
   - B) `ET.create()`
   - C) `ET.new()`
   - D) `ET.make()`

9. **What format is best for tabular data?**
   - A) JSON
   - B) XML
   - C) CSV
   - D) TXT

10. **What format is best for APIs?**
    - A) CSV
    - B) XML
    - C) JSON
    - D) TXT

**Answers**:
1. A) `csv` (module for CSV file operations)
2. B) List of dictionaries (DictReader returns dict per row)
3. B) `newline=""` (prevents extra blank lines in CSV)
4. B) Reads JSON from file (load reads from file, loads reads from string)
5. C) JSON string (dumps converts Python to JSON string)
6. C) `xml.etree.ElementTree` (module for XML operations)
7. A) `ET.parse()` (parses XML file)
8. A) `ET.Element()` (creates XML element)
9. C) CSV (best for tabular/spreadsheet data)
10. C) JSON (most common for APIs and web services)

---

## Next Steps

Excellent work! You've mastered different file formats. You now understand:
- How to work with CSV files
- How to work with JSON files
- How to work with XML files
- How to convert between formats

**What's Next?**
- Module 10: Error Handling and Debugging
- Learn about exceptions
- Understand error handling
- Explore debugging techniques

---

## Additional Resources

- **CSV Module**: [docs.python.org/3/library/csv.html](https://docs.python.org/3/library/csv.html)
- **JSON Module**: [docs.python.org/3/library/json.html](https://docs.python.org/3/library/json.html)
- **XML Module**: [docs.python.org/3/library/xml.etree.elementtree.html](https://docs.python.org/3/library/xml.etree.elementtree.html)

---

*Lesson completed! You're ready to move on to the next module.*

