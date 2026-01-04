# Lesson 22.1: Pandas DataFrames

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what Pandas is and why it's important
- Install and import Pandas
- Create DataFrames from various sources
- Understand DataFrame structure and properties
- Read data from CSV and Excel files
- Write data to files
- Inspect and explore DataFrames
- Understand Series vs DataFrame
- Work with DataFrame columns and rows
- Handle missing data basics
- Apply basic DataFrame operations
- Use Pandas for data analysis
- Debug Pandas-related issues

---

## Introduction to Pandas

**Pandas** is a powerful Python library for data manipulation and analysis. It provides data structures and functions needed to work with structured data seamlessly.

**Key Features**:
- **DataFrames**: Two-dimensional labeled data structures
- **Series**: One-dimensional labeled arrays
- **Data I/O**: Read/write CSV, Excel, JSON, SQL, and more
- **Data cleaning**: Handle missing data, duplicates, etc.
- **Data transformation**: Filter, group, merge, pivot
- **Time series**: Built-in support for time series data
- **Performance**: Built on NumPy for speed

**Why Pandas?**
- Easy data manipulation
- Handles missing data gracefully
- Powerful grouping and aggregation
- Integrates with NumPy, Matplotlib, and other libraries
- Industry standard for data analysis in Python

---

## Installation

### Installing Pandas

```bash
# Install Pandas using pip
pip install pandas

# Install with conda (if using Anaconda)
conda install pandas

# Install with Excel support
pip install pandas openpyxl

# Verify installation
python -c "import pandas; print(pandas.__version__)"
```

### Importing Pandas

```python
# Standard import (recommended)
import pandas as pd

# Now you can use pd.DataFrame(), pd.read_csv(), etc.
```

---

## Creating DataFrames

### From Dictionary

```python
import pandas as pd

# Create DataFrame from dictionary
data = {
    'name': ['Alice', 'Bob', 'Charlie', 'David'],
    'age': [25, 30, 35, 40],
    'city': ['New York', 'London', 'Tokyo', 'Paris']
}

df = pd.DataFrame(data)
print(df)
```

**Output**:
```
      name  age      city
0    Alice   25  New York
1      Bob   30    London
2  Charlie   35     Tokyo
3    David   40     Paris
```

### From List of Dictionaries

```python
import pandas as pd

# Create DataFrame from list of dictionaries
data = [
    {'name': 'Alice', 'age': 25, 'city': 'New York'},
    {'name': 'Bob', 'age': 30, 'city': 'London'},
    {'name': 'Charlie', 'age': 35, 'city': 'Tokyo'},
    {'name': 'David', 'age': 40, 'city': 'Paris'}
]

df = pd.DataFrame(data)
print(df)
```

### From NumPy Array

```python
import pandas as pd
import numpy as np

# Create DataFrame from NumPy array
data = np.array([[1, 2, 3], [4, 5, 6], [7, 8, 9]])
df = pd.DataFrame(data, columns=['A', 'B', 'C'])
print(df)
```

### From CSV String

```python
import pandas as pd
from io import StringIO

# CSV string
csv_data = """name,age,city
Alice,25,New York
Bob,30,London
Charlie,35,Tokyo"""

df = pd.read_csv(StringIO(csv_data))
print(df)
```

### Empty DataFrame

```python
import pandas as pd

# Create empty DataFrame with columns
df = pd.DataFrame(columns=['name', 'age', 'city'])
print(df)  # Empty DataFrame

# Add data later
df.loc[0] = ['Alice', 25, 'New York']
print(df)
```

---

## DataFrame Properties

### Basic Information

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob', 'Charlie'],
    'age': [25, 30, 35],
    'city': ['New York', 'London', 'Tokyo']
})

# Shape (rows, columns)
print(df.shape)           # (3, 3)

# Size (total elements)
print(df.size)            # 9

# Dimensions
print(df.ndim)            # 2

# Column names
print(df.columns)         # Index(['name', 'age', 'city'], dtype='object')

# Index
print(df.index)           # RangeIndex(start=0, stop=3, step=1)

# Data types
print(df.dtypes)
# name    object
# age      int64
# city     object
# dtype: object

# Info about DataFrame
print(df.info())
```

### Data Types

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob'],
    'age': [25, 30],
    'salary': [50000.0, 60000.0],
    'active': [True, False]
})

print(df.dtypes)
# name      object
# age        int64
# salary    float64
# active      bool
# dtype: object

# Convert data types
df['age'] = df['age'].astype(float)
print(df.dtypes)
```

---

## Reading Data

### Reading CSV Files

```python
import pandas as pd

# Read CSV file
df = pd.read_csv('data.csv')

# Read with options
df = pd.read_csv('data.csv', 
                 sep=',',           # Separator
                 header=0,          # Header row
                 index_col=0,       # Use first column as index
                 skiprows=1,        # Skip first row
                 nrows=100,         # Read only first 100 rows
                 encoding='utf-8')  # Encoding

# Read without header
df = pd.read_csv('data.csv', header=None)

# Specify column names
df = pd.read_csv('data.csv', names=['col1', 'col2', 'col3'])

# Handle missing values
df = pd.read_csv('data.csv', na_values=['NA', 'N/A', ''])
```

### Reading Excel Files

```python
import pandas as pd

# Read Excel file
df = pd.read_excel('data.xlsx')

# Read specific sheet
df = pd.read_excel('data.xlsx', sheet_name='Sheet1')

# Read multiple sheets
sheets = pd.read_excel('data.xlsx', sheet_name=['Sheet1', 'Sheet2'])

# Read with options
df = pd.read_excel('data.xlsx',
                   sheet_name=0,      # Sheet index or name
                   header=0,           # Header row
                   index_col=0,        # Index column
                   skiprows=1,         # Skip rows
                   nrows=100)          # Number of rows to read
```

### Reading Other Formats

```python
import pandas as pd

# Read JSON
df = pd.read_json('data.json')

# Read from URL
df = pd.read_csv('https://example.com/data.csv')

# Read from SQL
import sqlite3
conn = sqlite3.connect('database.db')
df = pd.read_sql('SELECT * FROM table', conn)

# Read HTML tables
df = pd.read_html('https://example.com/table.html')[0]
```

---

## Writing Data

### Writing to CSV

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob', 'Charlie'],
    'age': [25, 30, 35]
})

# Write to CSV
df.to_csv('output.csv')

# Write with options
df.to_csv('output.csv',
          index=False,        # Don't write index
          header=True,        # Write header
          sep=',',            # Separator
          encoding='utf-8')   # Encoding
```

### Writing to Excel

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob', 'Charlie'],
    'age': [25, 30, 35]
})

# Write to Excel
df.to_excel('output.xlsx')

# Write with options
df.to_excel('output.xlsx',
            sheet_name='Sheet1',  # Sheet name
            index=False,          # Don't write index
            header=True)          # Write header

# Write multiple DataFrames to different sheets
with pd.ExcelWriter('output.xlsx') as writer:
    df1.to_excel(writer, sheet_name='Sheet1')
    df2.to_excel(writer, sheet_name='Sheet2')
```

### Writing to Other Formats

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob'],
    'age': [25, 30]
})

# Write to JSON
df.to_json('output.json')

# Write to SQL
import sqlite3
conn = sqlite3.connect('database.db')
df.to_sql('table_name', conn, if_exists='replace')
```

---

## Inspecting DataFrames

### Viewing Data

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob', 'Charlie', 'David', 'Eve'],
    'age': [25, 30, 35, 40, 45],
    'city': ['New York', 'London', 'Tokyo', 'Paris', 'Berlin']
})

# First few rows
print(df.head())        # First 5 rows (default)
print(df.head(3))       # First 3 rows

# Last few rows
print(df.tail())        # Last 5 rows (default)
print(df.tail(3))  # Last 3 rows

# Display all data
print(df)

# Sample rows
print(df.sample(3))     # Random 3 rows
```

### Basic Statistics

```python
import pandas as pd

df = pd.DataFrame({
    'age': [25, 30, 35, 40, 45],
    'salary': [50000, 60000, 70000, 80000, 90000]
})

# Descriptive statistics
print(df.describe())
#        age      salary
# count   5.0        5.0
# mean   35.0    70000.0
# std     7.9    15811.4
# min    25.0    50000.0
# 25%    30.0    60000.0
# 50%    35.0    70000.0
# 75%    40.0    80000.0
# max    45.0    90000.0

# Summary info
print(df.info())

# Count non-null values
print(df.count())

# Value counts (for categorical data)
print(df['city'].value_counts())
```

---

## Series vs DataFrame

### Series

```python
import pandas as pd

# Create Series (1D)
s = pd.Series([1, 2, 3, 4, 5])
print(s)
# 0    1
# 1    2
# 2    3
# 3    4
# 4    5
# dtype: int64

# Series with index
s = pd.Series([1, 2, 3], index=['a', 'b', 'c'])
print(s)
# a    1
# b    2
# c    3
# dtype: int64

# Access Series elements
print(s['a'])           # 1
print(s[0])             # 1
```

### DataFrame

```python
import pandas as pd

# DataFrame is collection of Series
df = pd.DataFrame({
    'age': [25, 30, 35],
    'city': ['NY', 'London', 'Tokyo']
})

# Access column (returns Series)
age_series = df['age']
print(type(age_series))  # <class 'pandas.core.series.Series'>

# Access multiple columns (returns DataFrame)
subset = df[['age', 'city']]
print(type(subset))      # <class 'pandas.core.frame.DataFrame'>
```

---

## Working with Columns

### Selecting Columns

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob', 'Charlie'],
    'age': [25, 30, 35],
    'city': ['NY', 'London', 'Tokyo'],
    'salary': [50000, 60000, 70000]
})

# Single column (returns Series)
age = df['age']
print(age)

# Multiple columns (returns DataFrame)
subset = df[['name', 'age']]
print(subset)

# Using dot notation (only for valid Python identifiers)
age = df.age
print(age)
```

### Adding Columns

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob'],
    'age': [25, 30]
})

# Add new column
df['city'] = ['NY', 'London']
print(df)

# Add calculated column
df['age_next_year'] = df['age'] + 1
print(df)

# Add column with same value
df['active'] = True
print(df)
```

### Renaming Columns

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob'],
    'age': [25, 30]
})

# Rename columns
df = df.rename(columns={'name': 'full_name', 'age': 'years'})
print(df)

# Rename in place
df.rename(columns={'full_name': 'name'}, inplace=True)
print(df)
```

### Dropping Columns

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob'],
    'age': [25, 30],
    'city': ['NY', 'London']
})

# Drop column (returns new DataFrame)
df_new = df.drop('city', axis=1)
print(df_new)

# Drop multiple columns
df_new = df.drop(['city', 'age'], axis=1)
print(df_new)

# Drop in place
df.drop('city', axis=1, inplace=True)
print(df)
```

---

## Working with Rows

### Selecting Rows

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob', 'Charlie', 'David'],
    'age': [25, 30, 35, 40]
})

# Select by index
print(df.iloc[0])        # First row
print(df.iloc[0:2])      # First 2 rows
print(df.iloc[[0, 2]])   # Rows 0 and 2

# Select by label (if index is labeled)
df_indexed = df.set_index('name')
print(df_indexed.loc['Alice'])

# Select by condition
print(df[df['age'] > 30])
```

### Adding Rows

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob'],
    'age': [25, 30]
})

# Add row using loc
df.loc[2] = ['Charlie', 35]
print(df)

# Add row using append (creates new DataFrame)
new_row = pd.DataFrame({'name': ['David'], 'age': [40]})
df = df.append(new_row, ignore_index=True)
print(df)

# Using concat (recommended)
new_row = pd.DataFrame({'name': ['Eve'], 'age': [45]})
df = pd.concat([df, new_row], ignore_index=True)
print(df)
```

### Dropping Rows

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob', 'Charlie'],
    'age': [25, 30, 35]
})

# Drop by index
df_new = df.drop(0)      # Drop first row
print(df_new)

# Drop multiple rows
df_new = df.drop([0, 2])  # Drop rows 0 and 2
print(df_new)

# Drop by condition
df_new = df[df['age'] != 30]  # Keep rows where age != 30
print(df_new)
```

---

## Handling Missing Data

### Detecting Missing Data

```python
import pandas as pd
import numpy as np

df = pd.DataFrame({
    'name': ['Alice', 'Bob', None, 'David'],
    'age': [25, 30, np.nan, 40],
    'city': ['NY', None, 'Tokyo', 'Paris']
})

# Check for missing values
print(df.isna())         # Boolean DataFrame
print(df.isnull())       # Same as isna()

# Count missing values
print(df.isna().sum())  # Count per column

# Check if any missing
print(df.isna().any())  # True if any missing in column
```

### Handling Missing Data

```python
import pandas as pd
import numpy as np

df = pd.DataFrame({
    'age': [25, 30, np.nan, 40],
    'salary': [50000, np.nan, 70000, 80000]
})

# Drop rows with missing values
df_dropped = df.dropna()
print(df_dropped)

# Drop columns with missing values
df_dropped = df.dropna(axis=1)
print(df_dropped)

# Fill missing values
df_filled = df.fillna(0)  # Fill with 0
print(df_filled)

# Fill with mean
df['age'].fillna(df['age'].mean(), inplace=True)
print(df)

# Forward fill
df_filled = df.fillna(method='ffill')
print(df_filled)
```

---

## Practical Examples

### Example 1: Basic Data Analysis

```python
import pandas as pd

# Create sample data
data = {
    'name': ['Alice', 'Bob', 'Charlie', 'David', 'Eve'],
    'age': [25, 30, 35, 40, 45],
    'salary': [50000, 60000, 70000, 80000, 90000],
    'city': ['NY', 'London', 'Tokyo', 'Paris', 'Berlin']
}

df = pd.DataFrame(data)

# Basic statistics
print("Basic Statistics:")
print(df.describe())

# Filter data
print("\nPeople over 30:")
print(df[df['age'] > 30])

# Calculate average salary
print(f"\nAverage salary: ${df['salary'].mean():,.2f}")

# Group by city
print("\nAverage salary by city:")
print(df.groupby('city')['salary'].mean())
```

### Example 2: Reading and Processing CSV

```python
import pandas as pd

# Read CSV file
df = pd.read_csv('sales_data.csv')

# Inspect data
print("First few rows:")
print(df.head())

print("\nData info:")
print(df.info())

print("\nBasic statistics:")
print(df.describe())

# Process data
df['total'] = df['quantity'] * df['price']
print("\nData with total:")
print(df.head())

# Save processed data
df.to_csv('processed_sales.csv', index=False)
```

---

## Common Mistakes and Pitfalls

### 1. SettingWithCopyWarning

```python
# WRONG: May cause SettingWithCopyWarning
df = pd.DataFrame({'a': [1, 2, 3], 'b': [4, 5, 6]})
subset = df[df['a'] > 1]
subset['c'] = 10  # Warning!

# CORRECT: Use copy() or loc
subset = df[df['a'] > 1].copy()
subset['c'] = 10  # No warning
```

### 2. Modifying Original DataFrame

```python
# WRONG: Modifies original
df = pd.DataFrame({'a': [1, 2, 3]})
df2 = df
df2['b'] = [4, 5, 6]
print(df)  # df is also modified!

# CORRECT: Use copy()
df = pd.DataFrame({'a': [1, 2, 3]})
df2 = df.copy()
df2['b'] = [4, 5, 6]
print(df)  # df unchanged
```

### 3. Index Issues

```python
# WRONG: May cause KeyError
df = pd.DataFrame({'a': [1, 2, 3]})
print(df.loc[5])  # KeyError if index 5 doesn't exist

# CORRECT: Check index or use iloc
if 5 in df.index:
    print(df.loc[5])
```

---

## Best Practices

### 1. Use Appropriate Data Types

```python
# Convert to appropriate types to save memory
df['age'] = df['age'].astype('int8')
df['price'] = df['price'].astype('float32')
```

### 2. Handle Missing Data Early

```python
# Check for missing data first
print(df.isna().sum())

# Handle missing data appropriately
df = df.dropna()  # or fillna()
```

### 3. Use Vectorized Operations

```python
# WRONG: Use loops
for i in range(len(df)):
    df.loc[i, 'new_col'] = df.loc[i, 'old_col'] * 2

# CORRECT: Use vectorized operations
df['new_col'] = df['old_col'] * 2
```

---

## Practice Exercise

### Exercise: DataFrames

**Objective**: Create a program that demonstrates DataFrame operations.

**Instructions**:

1. Create a DataFrame with sample data
2. Read data from a CSV file (or create sample data)
3. Inspect and explore the DataFrame
4. Perform basic operations (filtering, calculations)
5. Handle missing data
6. Write results to a file

**Example Solution**:

```python
"""
Pandas DataFrames Exercise
This program demonstrates various DataFrame operations.
"""

import pandas as pd
import numpy as np

print("=" * 50)
print("Pandas DataFrames Exercise")
print("=" * 50)

# 1. Create DataFrame
print("\n1. Creating DataFrame:")
print("-" * 50)

data = {
    'name': ['Alice', 'Bob', 'Charlie', 'David', 'Eve', 'Frank'],
    'age': [25, 30, 35, 40, 45, 50],
    'city': ['New York', 'London', 'Tokyo', 'Paris', 'Berlin', 'Sydney'],
    'salary': [50000, 60000, 70000, 80000, 90000, 100000],
    'department': ['Sales', 'IT', 'Sales', 'IT', 'HR', 'IT']
}

df = pd.DataFrame(data)
print(df)

# 2. DataFrame Properties
print("\n2. DataFrame Properties:")
print("-" * 50)

print(f"Shape: {df.shape}")
print(f"Columns: {list(df.columns)}")
print(f"Data types:\n{df.dtypes}")
print(f"\nInfo:")
print(df.info())

# 3. Viewing Data
print("\n3. Viewing Data:")
print("-" * 50)

print("First 3 rows:")
print(df.head(3))

print("\nLast 3 rows:")
print(df.tail(3))

print("\nRandom 2 rows:")
print(df.sample(2))

# 4. Basic Statistics
print("\n4. Basic Statistics:")
print("-" * 50)

print("Descriptive statistics:")
print(df.describe())

print("\nValue counts for department:")
print(df['department'].value_counts())

# 5. Selecting Columns
print("\n5. Selecting Columns:")
print("-" * 50)

print("Name and age columns:")
print(df[['name', 'age']])

print("\nAge column (Series):")
print(df['age'])

# 6. Filtering Data
print("\n6. Filtering Data:")
print("-" * 50)

print("People over 35:")
print(df[df['age'] > 35])

print("\nPeople in IT department:")
print(df[df['department'] == 'IT'])

print("\nPeople with salary > 70000:")
print(df[df['salary'] > 70000])

# 7. Adding Columns
print("\n7. Adding Columns:")
print("-" * 50)

df['age_next_year'] = df['age'] + 1
df['salary_category'] = df['salary'].apply(
    lambda x: 'High' if x > 75000 else 'Medium' if x > 60000 else 'Low'
)
print(df[['name', 'age', 'age_next_year', 'salary', 'salary_category']])

# 8. Calculations
print("\n8. Calculations:")
print("-" * 50)

print(f"Average age: {df['age'].mean():.2f}")
print(f"Average salary: ${df['salary'].mean():,.2f}")
print(f"Total salary: ${df['salary'].sum():,.2f}")
print(f"Min age: {df['age'].min()}")
print(f"Max age: {df['age'].max()}")

# 9. Grouping
print("\n9. Grouping:")
print("-" * 50)

print("Average salary by department:")
print(df.groupby('department')['salary'].mean())

print("\nCount by department:")
print(df.groupby('department').size())

# 10. Handling Missing Data
print("\n10. Handling Missing Data:")
print("-" * 50)

# Create DataFrame with missing data
df_with_na = df.copy()
df_with_na.loc[2, 'salary'] = np.nan
df_with_na.loc[4, 'city'] = None

print("DataFrame with missing values:")
print(df_with_na)

print("\nMissing values count:")
print(df_with_na.isna().sum())

print("\nAfter dropping rows with missing values:")
df_cleaned = df_with_na.dropna()
print(df_cleaned)

# 11. Sorting
print("\n11. Sorting:")
print("-" * 50)

print("Sorted by age:")
print(df.sort_values('age'))

print("\nSorted by salary (descending):")
print(df.sort_values('salary', ascending=False))

# 12. Writing to File
print("\n12. Writing to File:")
print("-" * 50)

# Write to CSV
df.to_csv('output_data.csv', index=False)
print("Data written to output_data.csv")

# Write to Excel (if openpyxl is installed)
try:
    df.to_excel('output_data.xlsx', index=False)
    print("Data written to output_data.xlsx")
except ImportError:
    print("openpyxl not installed, skipping Excel export")

print("\n" + "=" * 50)
print("Exercise completed!")
print("=" * 50)
```

**Expected Output**: Demonstrates various DataFrame operations including creation, inspection, filtering, calculations, and data handling.

**Challenge** (Optional):
- Read data from a real CSV file
- Perform more complex filtering and grouping
- Create visualizations using the data
- Handle date/time columns
- Merge multiple DataFrames

---

## Key Takeaways

1. **Pandas** - Powerful library for data manipulation
2. **DataFrame** - Two-dimensional labeled data structure
3. **Series** - One-dimensional labeled array
4. **Creating DataFrames** - From dictionaries, lists, NumPy arrays, files
5. **Reading data** - CSV, Excel, JSON, SQL, etc.
6. **Writing data** - Save to various formats
7. **Inspecting data** - head(), tail(), info(), describe()
8. **Selecting data** - Columns, rows, subsets
9. **Filtering** - Boolean indexing, conditions
10. **Calculations** - Mean, sum, min, max, etc.
11. **Grouping** - groupby() for aggregations
12. **Missing data** - isna(), dropna(), fillna()
13. **Sorting** - sort_values()
14. **Data types** - Understanding and converting types
15. **Best practices** - Vectorized operations, appropriate types

---

## Quiz: Pandas Basics

Test your understanding with these questions:

1. **What is the standard import for Pandas?**
   - A) import pandas
   - B) import pandas as pd
   - C) from pandas import *
   - D) import pd

2. **What is a DataFrame?**
   - A) One-dimensional array
   - B) Two-dimensional labeled data structure
   - C) Three-dimensional array
   - D) Dictionary

3. **What reads a CSV file?**
   - A) pd.read_csv()
   - B) pd.read_file()
   - C) pd.load_csv()
   - D) pd.import_csv()

4. **What shows first 5 rows?**
   - A) df.head()
   - B) df.first()
   - C) df.top()
   - D) df.show()

5. **What returns DataFrame shape?**
   - A) df.shape
   - B) df.size
   - C) df.dimensions
   - D) df.length

6. **What filters rows where age > 30?**
   - A) df[age > 30]
   - B) df[df['age'] > 30]
   - C) df.filter(age > 30)
   - D) df.where(age > 30)

7. **What calculates mean?**
   - A) df.mean()
   - B) df['column'].mean()
   - C) np.mean(df['column'])
   - D) All of the above

8. **What checks for missing values?**
   - A) df.isna()
   - B) df.isnull()
   - C) df.missing()
   - D) Both A and B

9. **What drops rows with missing values?**
   - A) df.dropna()
   - B) df.remove_na()
   - C) df.delete_na()
   - D) df.clean()

10. **What groups data by column?**
    - A) df.group()
    - B) df.groupby()
    - C) df.aggregate()
    - D) df.collect()

**Answers**:
1. B) import pandas as pd (standard import)
2. B) Two-dimensional labeled data structure (DataFrame definition)
3. A) pd.read_csv() (read CSV function)
4. A) df.head() (show first rows)
5. A) df.shape (returns shape tuple)
6. B) df[df['age'] > 30] (boolean indexing)
7. D) All of the above (all calculate mean)
8. D) Both A and B (isna and isnull are same)
9. A) df.dropna() (remove missing values)
10. B) df.groupby() (grouping function)

---

## Next Steps

Excellent work! You've mastered Pandas DataFrames basics. You now understand:
- Creating DataFrames
- Reading and writing data
- Basic DataFrame operations
- How to work with data

**What's Next?**
- Lesson 22.2: Data Manipulation
- Learn filtering and selection
- Advanced data operations
- More data analysis techniques

---

## Additional Resources

- **Pandas Documentation**: [pandas.pydata.org/](https://pandas.pydata.org/)
- **Pandas User Guide**: [pandas.pydata.org/docs/user_guide/index.html](https://pandas.pydata.org/docs/user_guide/index.html)
- **10 Minutes to Pandas**: [pandas.pydata.org/docs/user_guide/10min.html](https://pandas.pydata.org/docs/user_guide/10min.html)
- **Pandas Tutorial**: [pandas.pydata.org/docs/getting_started/intro_tutorials/](https://pandas.pydata.org/docs/getting_started/intro_tutorials/)

---

*Lesson completed! You're ready to move on to the next lesson.*

