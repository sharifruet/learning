# Lesson 22.3: Data Cleaning

## Learning Objectives

By the end of this lesson, you will be able to:
- Identify and handle missing data effectively
- Understand different types of missing data
- Fill or drop missing values appropriately
- Transform data types and formats
- Normalize and standardize data
- Remove duplicates from DataFrames
- Handle outliers
- Clean string data
- Validate data quality
- Apply data cleaning best practices
- Build data cleaning pipelines
- Debug data cleaning issues

---

## Introduction to Data Cleaning

**Data cleaning** is the process of detecting and correcting (or removing) corrupt, inaccurate, or incomplete data. It's a crucial step in data analysis and machine learning.

**Common Data Issues**:
- Missing values (NaN, None, empty strings)
- Duplicate records
- Inconsistent data types
- Outliers
- Incorrect formats
- Typos and inconsistencies
- Invalid values

**Why Data Cleaning Matters**:
- Improves data quality
- Prevents errors in analysis
- Ensures accurate results
- Required for machine learning
- Makes data usable

---

## Handling Missing Data

### Detecting Missing Data

```python
import pandas as pd
import numpy as np

# Create DataFrame with missing values
df = pd.DataFrame({
    'name': ['Alice', 'Bob', None, 'David', 'Eve'],
    'age': [25, 30, np.nan, 40, None],
    'salary': [50000, np.nan, 70000, 80000, 90000],
    'city': ['NY', None, 'Tokyo', 'Paris', 'Berlin']
})

# Check for missing values
print(df.isna())         # Boolean DataFrame
print(df.isnull())       # Same as isna()
print(df.notna())        # Opposite of isna()

# Count missing values per column
print(df.isna().sum())

# Count missing values per row
print(df.isna().sum(axis=1))

# Percentage of missing values
print(df.isna().sum() / len(df) * 100)

# Check if any missing values exist
print(df.isna().any().any())  # True if any missing
```

### Visualizing Missing Data

```python
import pandas as pd
import matplotlib.pyplot as plt

# Create sample data with missing values
df = pd.DataFrame({
    'A': [1, 2, np.nan, 4, 5],
    'B': [np.nan, 2, 3, np.nan, 5],
    'C': [1, np.nan, 3, 4, np.nan]
})

# Visualize missing data (requires matplotlib)
# import missingno as msno
# msno.matrix(df)  # Visual representation
# msno.bar(df)     # Bar chart of missing values
```

### Dropping Missing Data

```python
import pandas as pd
import numpy as np

df = pd.DataFrame({
    'name': ['Alice', 'Bob', None, 'David'],
    'age': [25, 30, np.nan, 40],
    'salary': [50000, np.nan, 70000, 80000]
})

# Drop rows with any missing values
df_dropped = df.dropna()
print(df_dropped)

# Drop rows where all values are missing
df_dropped = df.dropna(how='all')
print(df_dropped)

# Drop rows with missing values in specific columns
df_dropped = df.dropna(subset=['age', 'salary'])
print(df_dropped)

# Drop columns with any missing values
df_dropped = df.dropna(axis=1)
print(df_dropped)

# Drop columns with all missing values
df_dropped = df.dropna(axis=1, how='all')
print(df_dropped)

# Drop with threshold (keep rows with at least N non-null values)
df_dropped = df.dropna(thresh=2)  # Keep rows with at least 2 non-null
print(df_dropped)
```

### Filling Missing Data

```python
import pandas as pd
import numpy as np

df = pd.DataFrame({
    'age': [25, 30, np.nan, 40, np.nan],
    'salary': [50000, np.nan, 70000, np.nan, 90000],
    'city': ['NY', None, 'Tokyo', 'Paris', None]
})

# Fill with constant value
df_filled = df.fillna(0)
print(df_filled)

# Fill with different values per column
df_filled = df.fillna({
    'age': df['age'].mean(),
    'salary': df['salary'].median(),
    'city': 'Unknown'
})
print(df_filled)

# Forward fill (use previous value)
df_filled = df.fillna(method='ffill')
print(df_filled)

# Backward fill (use next value)
df_filled = df.fillna(method='bfill')
print(df_filled)

# Fill with mean
df['age'].fillna(df['age'].mean(), inplace=True)

# Fill with median
df['salary'].fillna(df['salary'].median(), inplace=True)

# Fill with mode (most frequent)
df['city'].fillna(df['city'].mode()[0], inplace=True)
```

### Advanced Missing Data Handling

```python
import pandas as pd
import numpy as np

df = pd.DataFrame({
    'age': [25, 30, np.nan, 40, np.nan],
    'salary': [50000, np.nan, 70000, np.nan, 90000]
})

# Interpolate (for time series or ordered data)
df['age'] = df['age'].interpolate()
print(df)

# Fill with group mean
df = pd.DataFrame({
    'department': ['Sales', 'IT', 'Sales', 'IT', 'Sales'],
    'salary': [50000, np.nan, 55000, np.nan, 60000]
})
df['salary'] = df.groupby('department')['salary'].transform(
    lambda x: x.fillna(x.mean())
)
print(df)
```

---

## Data Transformation

### Type Conversion

```python
import pandas as pd

df = pd.DataFrame({
    'age': ['25', '30', '35'],  # Strings
    'salary': ['50000', '60000', '70000'],
    'active': ['True', 'False', 'True']
})

# Convert to numeric
df['age'] = pd.to_numeric(df['age'])
df['salary'] = pd.to_numeric(df['salary'])

# Convert to boolean
df['active'] = df['active'].map({'True': True, 'False': False})

# Convert to datetime
df['date'] = pd.to_datetime(['2023-01-01', '2023-01-02', '2023-01-03'])

# Convert to category (saves memory)
df['department'] = df['department'].astype('category')

# Using astype()
df['age'] = df['age'].astype(int)
df['salary'] = df['salary'].astype(float)
```

### String Cleaning

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['  Alice  ', 'BOB', 'charlie', 'dAvId'],
    'email': ['ALICE@EXAMPLE.COM', 'bob@test.com', 'CHARLIE@EXAMPLE.COM', 'david@test.com']
})

# Strip whitespace
df['name'] = df['name'].str.strip()

# Convert to lowercase
df['name'] = df['name'].str.lower()
df['email'] = df['email'].str.lower()

# Convert to uppercase
df['name'] = df['name'].str.upper()

# Capitalize (first letter uppercase)
df['name'] = df['name'].str.capitalize()

# Title case (each word capitalized)
df['name'] = df['name'].str.title()

# Replace strings
df['name'] = df['name'].str.replace(' ', '_')

# Remove special characters
df['name'] = df['name'].str.replace('[^a-zA-Z0-9]', '', regex=True)
```

### Date/Time Transformation

```python
import pandas as pd

df = pd.DataFrame({
    'date_str': ['2023-01-01', '2023-02-15', '2023-03-20']
})

# Convert to datetime
df['date'] = pd.to_datetime(df['date_str'])

# Extract components
df['year'] = df['date'].dt.year
df['month'] = df['date'].dt.month
df['day'] = df['date'].dt.day
df['day_of_week'] = df['date'].dt.dayofweek
df['day_name'] = df['date'].dt.day_name()

# Format dates
df['date_formatted'] = df['date'].dt.strftime('%Y-%m-%d')

# Handle different date formats
dates = ['01/15/2023', '2023-02-15', '15-03-2023']
df['date'] = pd.to_datetime(dates, infer_datetime_format=True)
```

### Normalization and Standardization

```python
import pandas as pd
import numpy as np

df = pd.DataFrame({
    'age': [25, 30, 35, 40, 45],
    'salary': [50000, 60000, 70000, 80000, 90000]
})

# Min-Max normalization (0-1 scale)
df['age_normalized'] = (df['age'] - df['age'].min()) / (df['age'].max() - df['age'].min())

# Z-score standardization (mean=0, std=1)
df['age_standardized'] = (df['age'] - df['age'].mean()) / df['age'].std()

# Using sklearn (if available)
# from sklearn.preprocessing import MinMaxScaler, StandardScaler
# scaler = MinMaxScaler()
# df[['age_normalized']] = scaler.fit_transform(df[['age']])
```

### Binning and Categorization

```python
import pandas as pd

df = pd.DataFrame({
    'age': [25, 30, 35, 40, 45, 50, 55, 60]
})

# Create bins
df['age_group'] = pd.cut(df['age'], bins=[0, 30, 40, 50, 100], labels=['Young', 'Middle', 'Senior', 'Elderly'])

# Quantile-based binning
df['age_quartile'] = pd.qcut(df['age'], q=4, labels=['Q1', 'Q2', 'Q3', 'Q4'])

# Custom binning
bins = [0, 30, 45, 100]
labels = ['Young', 'Middle-aged', 'Senior']
df['age_category'] = pd.cut(df['age'], bins=bins, labels=labels)
```

---

## Removing Duplicates

### Finding Duplicates

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob', 'Alice', 'Charlie', 'Bob'],
    'age': [25, 30, 25, 35, 30],
    'city': ['NY', 'London', 'NY', 'Tokyo', 'London']
})

# Check for duplicate rows
print(df.duplicated())           # Boolean Series

# Count duplicates
print(df.duplicated().sum())

# Find duplicate rows
duplicates = df[df.duplicated()]
print(duplicates)

# Find all duplicates (including first occurrence)
all_duplicates = df[df.duplicated(keep=False)]
print(all_duplicates)
```

### Removing Duplicates

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob', 'Alice', 'Charlie', 'Bob'],
    'age': [25, 30, 25, 35, 30],
    'city': ['NY', 'London', 'NY', 'Tokyo', 'London']
})

# Remove duplicates (keep first occurrence)
df_unique = df.drop_duplicates()
print(df_unique)

# Remove duplicates (keep last occurrence)
df_unique = df.drop_duplicates(keep='last')
print(df_unique)

# Remove all duplicates
df_unique = df.drop_duplicates(keep=False)
print(df_unique)

# Remove duplicates based on specific columns
df_unique = df.drop_duplicates(subset=['name', 'age'])
print(df_unique)

# Remove duplicates in place
df.drop_duplicates(inplace=True)
```

### Handling Duplicate Values in Columns

```python
import pandas as pd

df = pd.DataFrame({
    'id': [1, 2, 3, 4, 5],
    'name': ['Alice', 'Bob', 'Alice', 'David', 'Bob']
})

# Find duplicate values in a column
duplicate_names = df[df['name'].duplicated(keep=False)]
print(duplicate_names)

# Get unique values
unique_names = df['name'].unique()
print(unique_names)

# Count occurrences
name_counts = df['name'].value_counts()
print(name_counts)
```

---

## Handling Outliers

### Detecting Outliers

```python
import pandas as pd
import numpy as np

df = pd.DataFrame({
    'age': [25, 30, 35, 40, 45, 150],  # 150 is an outlier
    'salary': [50000, 60000, 70000, 80000, 90000, 1000000]  # 1000000 is an outlier
})

# Using IQR (Interquartile Range)
Q1 = df['age'].quantile(0.25)
Q3 = df['age'].quantile(0.75)
IQR = Q3 - Q1
lower_bound = Q1 - 1.5 * IQR
upper_bound = Q3 + 1.5 * IQR

outliers = df[(df['age'] < lower_bound) | (df['age'] > upper_bound)]
print(outliers)

# Using Z-score
from scipy import stats
z_scores = np.abs(stats.zscore(df['age']))
outliers = df[z_scores > 3]
print(outliers)

# Using percentile
lower_percentile = df['age'].quantile(0.05)
upper_percentile = df['age'].quantile(0.95)
outliers = df[(df['age'] < lower_percentile) | (df['age'] > upper_percentile)]
print(outliers)
```

### Handling Outliers

```python
import pandas as pd
import numpy as np

df = pd.DataFrame({
    'age': [25, 30, 35, 40, 45, 150],
    'salary': [50000, 60000, 70000, 80000, 90000, 1000000]
})

# Method 1: Remove outliers
Q1 = df['age'].quantile(0.25)
Q3 = df['age'].quantile(0.75)
IQR = Q3 - Q1
df_cleaned = df[(df['age'] >= Q1 - 1.5*IQR) & (df['age'] <= Q3 + 1.5*IQR)]
print(df_cleaned)

# Method 2: Cap outliers (winsorization)
lower_bound = df['age'].quantile(0.05)
upper_bound = df['age'].quantile(0.95)
df['age_capped'] = df['age'].clip(lower=lower_bound, upper=upper_bound)
print(df)

# Method 3: Replace with median/mean
median_age = df['age'].median()
df['age'] = df['age'].replace(150, median_age)
print(df)
```

---

## Data Validation

### Checking Data Quality

```python
import pandas as pd
import numpy as np

df = pd.DataFrame({
    'email': ['alice@example.com', 'invalid-email', 'bob@test.com', 'not-an-email'],
    'age': [25, -5, 30, 200],  # -5 and 200 are invalid
    'phone': ['123-456-7890', 'invalid', '987-654-3210', '123']
})

# Validate email format
import re
def is_valid_email(email):
    pattern = r'^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$'
    return bool(re.match(pattern, str(email)))

df['valid_email'] = df['email'].apply(is_valid_email)
invalid_emails = df[~df['valid_email']]
print(invalid_emails)

# Validate age range
df['valid_age'] = (df['age'] >= 0) & (df['age'] <= 120)
invalid_ages = df[~df['valid_age']]
print(invalid_ages)

# Validate phone format
def is_valid_phone(phone):
    pattern = r'^\d{3}-\d{3}-\d{4}$'
    return bool(re.match(pattern, str(phone)))

df['valid_phone'] = df['phone'].apply(is_valid_phone)
invalid_phones = df[~df['valid_phone']]
print(invalid_phones)
```

### Data Quality Report

```python
import pandas as pd
import numpy as np

def data_quality_report(df):
    """Generate a data quality report."""
    report = pd.DataFrame({
        'Column': df.columns,
        'Data Type': df.dtypes.values,
        'Non-Null Count': df.count().values,
        'Null Count': df.isna().sum().values,
        'Null Percentage': (df.isna().sum() / len(df) * 100).values,
        'Unique Values': df.nunique().values
    })
    return report

df = pd.DataFrame({
    'name': ['Alice', 'Bob', None, 'David'],
    'age': [25, 30, np.nan, 40],
    'salary': [50000, np.nan, 70000, 80000]
})

report = data_quality_report(df)
print(report)
```

---

## Practical Examples

### Example 1: Complete Data Cleaning Pipeline

```python
import pandas as pd
import numpy as np

# Sample messy data
df = pd.DataFrame({
    'name': ['  Alice  ', 'BOB', 'charlie', None, 'dAvId'],
    'age': ['25', '30', '35', 'invalid', '40'],
    'salary': [50000, np.nan, 70000, 80000, np.nan],
    'email': ['ALICE@EXAMPLE.COM', 'bob@test.com', None, 'david@test.com', 'invalid-email'],
    'date': ['2023-01-01', 'invalid-date', '2023-03-20', '2023-04-15', '2023-05-10']
})

print("Original Data:")
print(df)
print("\nData Info:")
print(df.info())

# Step 1: Clean names
df['name'] = df['name'].str.strip().str.title()
df['name'] = df['name'].fillna('Unknown')

# Step 2: Clean age
df['age'] = pd.to_numeric(df['age'], errors='coerce')
df['age'] = df['age'].fillna(df['age'].median())

# Step 3: Clean salary
df['salary'] = df['salary'].fillna(df['salary'].median())

# Step 4: Clean email
df['email'] = df['email'].str.lower().str.strip()
df['email'] = df['email'].fillna('unknown@example.com')

# Step 5: Clean dates
df['date'] = pd.to_datetime(df['date'], errors='coerce')
df['date'] = df['date'].fillna(pd.Timestamp('2023-01-01'))

# Step 6: Remove duplicates
df = df.drop_duplicates()

print("\nCleaned Data:")
print(df)
print("\nCleaned Data Info:")
print(df.info())
```

### Example 2: Handling Real-World Data Issues

```python
import pandas as pd
import numpy as np

# Simulate real-world messy data
df = pd.DataFrame({
    'customer_id': [1, 2, 2, 3, 4, 5, 5, 6],
    'name': ['Alice Smith', 'Bob Johnson', 'Bob Johnson', 'Charlie Brown', 'David Lee', 'Eve Wilson', 'Eve Wilson', 'Frank Miller'],
    'purchase_amount': [100.50, 200.75, 200.75, 150.00, 300.25, 250.00, 250.00, 180.50],
    'date': ['2023-01-01', '2023-01-02', '2023-01-02', '2023-01-03', '2023-01-04', '2023-01-05', '2023-01-05', '2023-01-06']
})

# Remove duplicate transactions
df = df.drop_duplicates(subset=['customer_id', 'date', 'purchase_amount'])

# Handle outliers in purchase_amount
Q1 = df['purchase_amount'].quantile(0.25)
Q3 = df['purchase_amount'].quantile(0.75)
IQR = Q3 - Q1
df = df[(df['purchase_amount'] >= Q1 - 1.5*IQR) & (df['purchase_amount'] <= Q3 + 1.5*IQR)]

# Clean date column
df['date'] = pd.to_datetime(df['date'])

print("Cleaned Data:")
print(df)
```

---

## Common Mistakes and Pitfalls

### 1. Not Checking Data Types

```python
# WRONG: Assume data types
df = pd.read_csv('data.csv')
result = df['age'] + 1  # May fail if age is string

# CORRECT: Check and convert types
df['age'] = pd.to_numeric(df['age'], errors='coerce')
result = df['age'] + 1
```

### 2. Dropping Too Much Data

```python
# WRONG: Drop all rows with any missing value
df_cleaned = df.dropna()  # May lose too much data

# CORRECT: Be selective
df_cleaned = df.dropna(subset=['critical_column'])
# Or fill missing values appropriately
```

### 3. Not Handling Outliers

```python
# WRONG: Ignore outliers
mean = df['salary'].mean()  # May be skewed by outliers

# CORRECT: Handle outliers first
df_cleaned = df[(df['salary'] > 0) & (df['salary'] < 1000000)]
mean = df_cleaned['salary'].mean()
```

---

## Best Practices

### 1. Create a Cleaning Pipeline

```python
def clean_data(df):
    """Data cleaning pipeline."""
    # 1. Remove duplicates
    df = df.drop_duplicates()
    
    # 2. Handle missing values
    df = df.fillna({'age': df['age'].median()})
    
    # 3. Clean strings
    df['name'] = df['name'].str.strip().str.title()
    
    # 4. Convert types
    df['age'] = pd.to_numeric(df['age'], errors='coerce')
    
    # 5. Remove outliers
    Q1 = df['age'].quantile(0.25)
    Q3 = df['age'].quantile(0.75)
    IQR = Q3 - Q1
    df = df[(df['age'] >= Q1 - 1.5*IQR) & (df['age'] <= Q3 + 1.5*IQR)]
    
    return df
```

### 2. Document Your Cleaning Steps

```python
# Document what you're doing
# Step 1: Remove duplicates - 5 rows removed
# Step 2: Fill missing ages with median - 3 values filled
# Step 3: Remove outliers - 2 rows removed
```

### 3. Keep Original Data

```python
# Always keep original
df_original = df.copy()

# Clean data
df_cleaned = clean_data(df)

# Compare
print(f"Original: {len(df_original)} rows")
print(f"Cleaned: {len(df_cleaned)} rows")
```

---

## Practice Exercise

### Exercise: Data Cleaning

**Objective**: Create a program that cleans messy data.

**Instructions**:

1. Create or load messy data with various issues
2. Handle missing data
3. Remove duplicates
4. Clean string data
5. Handle outliers
6. Transform data types
7. Validate data quality

**Example Solution**:

```python
"""
Data Cleaning Exercise
This program demonstrates comprehensive data cleaning.
"""

import pandas as pd
import numpy as np

print("=" * 50)
print("Data Cleaning Exercise")
print("=" * 50)

# 1. Create messy data
print("\n1. Creating Messy Data:")
print("-" * 50)

df = pd.DataFrame({
    'customer_id': [1, 2, 2, 3, 4, 5, 6, 7, 8, 9],
    'name': ['  Alice Smith  ', 'BOB JOHNSON', 'Bob Johnson', 'charlie brown', 'David Lee', 'Eve Wilson', 'Frank Miller', None, 'Grace Taylor', 'Henry Davis'],
    'age': ['25', '30', '30', '35', '40', 'invalid', '45', '28', '32', '150'],  # 'invalid' and '150' are issues
    'email': ['ALICE@EXAMPLE.COM', 'bob@test.com', 'bob@test.com', 'charlie@example.com', 'david@test.com', 'eve@example.com', 'frank@test.com', None, 'grace@example.com', 'henry@test.com'],
    'purchase_amount': [100.50, 200.75, 200.75, 150.00, 300.25, 250.00, 180.50, 220.00, 190.75, 50000.00],  # 50000 is outlier
    'date': ['2023-01-01', '2023-01-02', '2023-01-02', '2023-01-03', '2023-01-04', '2023-01-05', '2023-01-06', 'invalid-date', '2023-01-08', '2023-01-09']
})

print("Original messy data:")
print(df)
print(f"\nShape: {df.shape}")
print(f"Missing values:\n{df.isna().sum()}")

# 2. Remove duplicates
print("\n2. Removing Duplicates:")
print("-" * 50)

print(f"Duplicates found: {df.duplicated().sum()}")
df = df.drop_duplicates()
print(f"After removing duplicates: {df.shape[0]} rows")

# 3. Clean names
print("\n3. Cleaning Names:")
print("-" * 50)

df['name'] = df['name'].str.strip().str.title()
df['name'] = df['name'].fillna('Unknown')
print("Cleaned names:")
print(df[['customer_id', 'name']].head())

# 4. Clean age
print("\n4. Cleaning Age:")
print("-" * 50)

# Convert to numeric, invalid becomes NaN
df['age'] = pd.to_numeric(df['age'], errors='coerce')

# Fill missing with median
median_age = df['age'].median()
df['age'] = df['age'].fillna(median_age)

# Handle outliers (age > 120 is invalid)
df['age'] = df['age'].clip(lower=0, upper=120)

print("Cleaned age:")
print(df[['customer_id', 'name', 'age']].head())

# 5. Clean email
print("\n5. Cleaning Email:")
print("-" * 50)

df['email'] = df['email'].str.lower().str.strip()
df['email'] = df['email'].fillna('unknown@example.com')
print("Cleaned emails:")
print(df[['customer_id', 'name', 'email']].head())

# 6. Handle outliers in purchase_amount
print("\n6. Handling Outliers in Purchase Amount:")
print("-" * 50)

Q1 = df['purchase_amount'].quantile(0.25)
Q3 = df['purchase_amount'].quantile(0.75)
IQR = Q3 - Q1
lower_bound = Q1 - 1.5 * IQR
upper_bound = Q3 + 1.5 * IQR

print(f"Q1: {Q1}, Q3: {Q3}, IQR: {IQR}")
print(f"Bounds: [{lower_bound}, {upper_bound}]")

# Cap outliers instead of removing
df['purchase_amount'] = df['purchase_amount'].clip(lower=lower_bound, upper=upper_bound)
print("Purchase amounts after capping outliers:")
print(df[['customer_id', 'name', 'purchase_amount']])

# 7. Clean dates
print("\n7. Cleaning Dates:")
print("-" * 50)

df['date'] = pd.to_datetime(df['date'], errors='coerce')
df['date'] = df['date'].fillna(pd.Timestamp('2023-01-01'))
print("Cleaned dates:")
print(df[['customer_id', 'name', 'date']].head())

# 8. Final data quality check
print("\n8. Final Data Quality Check:")
print("-" * 50)

print("Missing values:")
print(df.isna().sum())

print("\nData types:")
print(df.dtypes)

print("\nSummary statistics:")
print(df.describe())

print("\nFinal cleaned data:")
print(df)

print("\n" + "=" * 50)
print("Data cleaning completed!")
print("=" * 50)
print(f"Final shape: {df.shape}")
print(f"Rows removed: {10 - df.shape[0]}")
```

**Expected Output**: Demonstrates comprehensive data cleaning including handling missing data, duplicates, outliers, and data type conversions.

**Challenge** (Optional):
- Create a reusable data cleaning function
- Add data validation rules
- Create a data quality report
- Handle more complex data issues
- Implement data profiling

---

## Key Takeaways

1. **Missing data** - Detect, drop, or fill appropriately
2. **Data types** - Convert to appropriate types
3. **String cleaning** - Strip, case conversion, replace
4. **Duplicates** - Find and remove duplicate records
5. **Outliers** - Detect and handle using IQR, Z-score, or percentiles
6. **Data validation** - Check data quality and validity
7. **Transformation** - Normalize, standardize, bin data
8. **Date/time** - Convert and extract components
9. **Best practices** - Create pipelines, document steps, keep originals
10. **Common issues** - Missing values, wrong types, duplicates, outliers
11. **Cleaning pipeline** - Systematic approach to cleaning
12. **Data quality** - Generate reports and validate
13. **Error handling** - Use errors='coerce' for conversions
14. **Preserve data** - Keep original data for comparison
15. **Iterative process** - Data cleaning is often iterative

---

## Quiz: Data Cleaning

Test your understanding with these questions:

1. **What detects missing values?**
   - A) df.isna()
   - B) df.isnull()
   - C) df.missing()
   - D) Both A and B

2. **What drops rows with missing values?**
   - A) df.dropna()
   - B) df.remove_na()
   - C) df.delete_na()
   - D) df.clean()

3. **What fills missing values?**
   - A) df.fillna()
   - B) df.replace_na()
   - C) df.fill()
   - D) df.complete()

4. **What removes duplicates?**
   - A) df.remove_duplicates()
   - B) df.drop_duplicates()
   - C) df.delete_duplicates()
   - D) df.unique()

5. **What converts to numeric?**
   - A) pd.to_numeric()
   - B) df.astype(float)
   - C) df.convert_numeric()
   - D) Both A and B

6. **What strips whitespace from strings?**
   - A) df.str.strip()
   - B) df.strip()
   - C) df.clean()
   - D) df.trim()

7. **What detects outliers using IQR?**
   - A) Q1 - 1.5*IQR and Q3 + 1.5*IQR
   - B) Mean ± 2*Std
   - C) Percentiles
   - D) All of the above

8. **What converts to datetime?**
   - A) pd.to_datetime()
   - B) df.astype('datetime')
   - C) df.convert_datetime()
   - D) Both A and B

9. **What normalizes data to 0-1 range?**
   - A) Min-Max normalization
   - B) Z-score standardization
   - C) Both
   - D) Neither

10. **What should you do before cleaning?**
    - A) Make a copy
    - B) Check data types
    - C) Inspect data
    - D) All of the above

**Answers**:
1. D) Both A and B (isna and isnull are same)
2. A) df.dropna() (remove missing values)
3. A) df.fillna() (fill missing values)
4. B) df.drop_duplicates() (remove duplicates)
5. D) Both A and B (numeric conversion methods)
6. A) df.str.strip() (string method)
7. A) Q1 - 1.5*IQR and Q3 + 1.5*IQR (IQR method)
8. A) pd.to_datetime() (datetime conversion)
9. A) Min-Max normalization (0-1 range)
10. D) All of the above (best practices)

---

## Next Steps

Excellent work! You've mastered data cleaning. You now understand:
- Handling missing data
- Data transformation
- Removing duplicates
- Data quality

**What's Next?**
- Module 23: Data Visualization
- Lesson 23.1: Matplotlib
- Learn to create visualizations
- Visualize your cleaned data

---

## Additional Resources

- **Pandas Documentation**: [pandas.pydata.org/](https://pandas.pydata.org/)
- **Data Cleaning Guide**: [pandas.pydata.org/docs/user_guide/missing_data.html](https://pandas.pydata.org/docs/user_guide/missing_data.html)
- **Data Quality**: Best practices for data cleaning
- **Real Python Data Cleaning**: [realpython.com/python-data-cleaning-numpy-pandas/](https://realpython.com/python-data-cleaning-numpy-pandas/)

---

*Lesson completed! You're ready to move on to the next module.*

