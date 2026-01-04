# Lesson 22.2: Data Manipulation

## Learning Objectives

By the end of this lesson, you will be able to:
- Filter DataFrames using various conditions
- Select data using different methods
- Group data by columns
- Perform aggregations on grouped data
- Merge and join DataFrames
- Understand different join types
- Combine data from multiple sources
- Apply advanced filtering techniques
- Use pivot tables
- Transform data effectively
- Handle complex data manipulation tasks
- Debug data manipulation issues

---

## Filtering and Selection

### Boolean Indexing

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob', 'Charlie', 'David', 'Eve'],
    'age': [25, 30, 35, 40, 45],
    'salary': [50000, 60000, 70000, 80000, 90000],
    'department': ['Sales', 'IT', 'Sales', 'IT', 'HR']
})

# Single condition
filtered = df[df['age'] > 30]
print(filtered)

# Multiple conditions (AND)
filtered = df[(df['age'] > 30) & (df['department'] == 'IT')]
print(filtered)

# Multiple conditions (OR)
filtered = df[(df['age'] > 35) | (df['department'] == 'Sales')]
print(filtered)

# Using isin()
filtered = df[df['department'].isin(['IT', 'HR'])]
print(filtered)

# Using not
filtered = df[~df['department'].isin(['IT'])]
print(filtered)
```

### Using query() Method

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob', 'Charlie'],
    'age': [25, 30, 35],
    'salary': [50000, 60000, 70000]
})

# Query with single condition
filtered = df.query('age > 30')
print(filtered)

# Query with multiple conditions
filtered = df.query('age > 25 and salary > 55000')
print(filtered)

# Query with variables
min_age = 30
filtered = df.query('age > @min_age')
print(filtered)
```

### Using loc and iloc

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob', 'Charlie', 'David'],
    'age': [25, 30, 35, 40],
    'salary': [50000, 60000, 70000, 80000]
})

# Using iloc (integer position)
print(df.iloc[0])              # First row
print(df.iloc[0:2])            # First 2 rows
print(df.iloc[0:2, 0:2])       # First 2 rows, first 2 columns
print(df.iloc[[0, 2]])         # Rows 0 and 2

# Using loc (label-based)
df_indexed = df.set_index('name')
print(df_indexed.loc['Alice'])  # Row with label 'Alice'
print(df_indexed.loc['Alice':'Charlie'])  # Rows from Alice to Charlie
print(df_indexed.loc[['Alice', 'Charlie']])  # Specific rows

# Using loc with conditions
filtered = df.loc[df['age'] > 30, ['name', 'salary']]
print(filtered)
```

### String Methods

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice Smith', 'Bob Johnson', 'Charlie Brown', 'David Lee'],
    'email': ['alice@example.com', 'bob@test.com', 'charlie@example.com', 'david@test.com']
})

# Contains
filtered = df[df['name'].str.contains('Smith')]
print(filtered)

# Starts with
filtered = df[df['name'].str.startswith('A')]
print(filtered)

# Ends with
filtered = df[df['email'].str.endswith('example.com')]
print(filtered)

# Case insensitive
filtered = df[df['name'].str.contains('smith', case=False)]
print(filtered)
```

---

## Grouping and Aggregation

### Basic Grouping

```python
import pandas as pd

df = pd.DataFrame({
    'department': ['Sales', 'IT', 'Sales', 'IT', 'HR', 'Sales'],
    'employee': ['Alice', 'Bob', 'Charlie', 'David', 'Eve', 'Frank'],
    'salary': [50000, 60000, 55000, 70000, 65000, 60000]
})

# Group by single column
grouped = df.groupby('department')
print(grouped.groups)  # Shows groups

# Iterate over groups
for name, group in grouped:
    print(f"\n{name}:")
    print(group)
```

### Aggregation Functions

```python
import pandas as pd

df = pd.DataFrame({
    'department': ['Sales', 'IT', 'Sales', 'IT', 'HR', 'Sales'],
    'salary': [50000, 60000, 55000, 70000, 65000, 60000],
    'age': [25, 30, 35, 40, 45, 28]
})

# Single aggregation
result = df.groupby('department')['salary'].mean()
print(result)

# Multiple aggregations
result = df.groupby('department')['salary'].agg(['mean', 'sum', 'count', 'min', 'max'])
print(result)

# Different aggregations for different columns
result = df.groupby('department').agg({
    'salary': ['mean', 'sum'],
    'age': 'mean'
})
print(result)

# Custom aggregation function
def salary_range(group):
    return group.max() - group.min()

result = df.groupby('department')['salary'].agg(salary_range)
print(result)
```

### Common Aggregation Functions

```python
import pandas as pd

df = pd.DataFrame({
    'department': ['Sales', 'IT', 'Sales', 'IT'],
    'salary': [50000, 60000, 55000, 70000]
})

grouped = df.groupby('department')['salary']

# Common aggregations
print(grouped.sum())      # Sum
print(grouped.mean())     # Mean
print(grouped.median())   # Median
print(grouped.std())      # Standard deviation
print(grouped.var())      # Variance
print(grouped.min())     # Minimum
print(grouped.max())      # Maximum
print(grouped.count())   # Count
print(grouped.size())     # Size (includes NaN)
print(grouped.first())    # First value
print(grouped.last())     # Last value
```

### Grouping by Multiple Columns

```python
import pandas as pd

df = pd.DataFrame({
    'department': ['Sales', 'IT', 'Sales', 'IT', 'Sales', 'IT'],
    'location': ['NY', 'NY', 'LA', 'LA', 'NY', 'LA'],
    'salary': [50000, 60000, 55000, 70000, 60000, 75000]
})

# Group by multiple columns
result = df.groupby(['department', 'location'])['salary'].mean()
print(result)

# Unstack to create pivot-like structure
result = df.groupby(['department', 'location'])['salary'].mean().unstack()
print(result)
```

### Transform and Apply

```python
import pandas as pd

df = pd.DataFrame({
    'department': ['Sales', 'IT', 'Sales', 'IT'],
    'salary': [50000, 60000, 55000, 70000]
})

# Transform (returns same shape as original)
df['salary_normalized'] = df.groupby('department')['salary'].transform(
    lambda x: (x - x.mean()) / x.std()
)
print(df)

# Apply custom function
def custom_func(group):
    return group['salary'].sum() / len(group)

result = df.groupby('department').apply(custom_func)
print(result)
```

---

## Merging and Joining

### Merge Basics

```python
import pandas as pd

# Create sample DataFrames
df1 = pd.DataFrame({
    'id': [1, 2, 3, 4],
    'name': ['Alice', 'Bob', 'Charlie', 'David'],
    'department_id': [1, 2, 1, 3]
})

df2 = pd.DataFrame({
    'id': [1, 2, 3],
    'department': ['Sales', 'IT', 'HR']
})

# Merge on common column
merged = pd.merge(df1, df2, left_on='department_id', right_on='id', suffixes=('_emp', '_dept'))
print(merged)
```

### Join Types

```python
import pandas as pd

left = pd.DataFrame({
    'key': ['A', 'B', 'C', 'D'],
    'value_left': [1, 2, 3, 4]
})

right = pd.DataFrame({
    'key': ['B', 'C', 'D', 'E'],
    'value_right': [5, 6, 7, 8]
})

# Inner join (default)
inner = pd.merge(left, right, on='key', how='inner')
print("Inner join:")
print(inner)

# Left join
left_join = pd.merge(left, right, on='key', how='left')
print("\nLeft join:")
print(left_join)

# Right join
right_join = pd.merge(left, right, on='key', how='right')
print("\nRight join:")
print(right_join)

# Outer join (full outer)
outer = pd.merge(left, right, on='key', how='outer')
print("\nOuter join:")
print(outer)
```

### Merge on Multiple Columns

```python
import pandas as pd

df1 = pd.DataFrame({
    'first_name': ['Alice', 'Bob', 'Charlie'],
    'last_name': ['Smith', 'Johnson', 'Brown'],
    'age': [25, 30, 35]
})

df2 = pd.DataFrame({
    'first_name': ['Alice', 'Bob', 'David'],
    'last_name': ['Smith', 'Johnson', 'Lee'],
    'salary': [50000, 60000, 70000]
})

# Merge on multiple columns
merged = pd.merge(df1, df2, on=['first_name', 'last_name'], how='inner')
print(merged)
```

### Using join() Method

```python
import pandas as pd

left = pd.DataFrame({
    'A': ['A0', 'A1', 'A2'],
    'B': ['B0', 'B1', 'B2']
}, index=['K0', 'K1', 'K2'])

right = pd.DataFrame({
    'C': ['C0', 'C1', 'C2'],
    'D': ['D0', 'D1', 'D2']
}, index=['K0', 'K1', 'K3'])

# Join on index
result = left.join(right)
print(result)

# Join with how parameter
result = left.join(right, how='outer')
print(result)
```

### Concatenation

```python
import pandas as pd

df1 = pd.DataFrame({
    'A': ['A0', 'A1'],
    'B': ['B0', 'B1']
})

df2 = pd.DataFrame({
    'A': ['A2', 'A3'],
    'B': ['B2', 'B3']
})

# Concatenate vertically (stack rows)
result = pd.concat([df1, df2], ignore_index=True)
print(result)

# Concatenate horizontally (stack columns)
df3 = pd.DataFrame({
    'C': ['C0', 'C1'],
    'D': ['D0', 'D1']
})

result = pd.concat([df1, df3], axis=1)
print(result)

# Concatenate with keys
result = pd.concat([df1, df2], keys=['first', 'second'])
print(result)
```

---

## Pivot Tables

### Basic Pivot

```python
import pandas as pd

df = pd.DataFrame({
    'date': ['2023-01-01', '2023-01-01', '2023-01-02', '2023-01-02'],
    'product': ['A', 'B', 'A', 'B'],
    'sales': [100, 200, 150, 250]
})

# Create pivot table
pivot = df.pivot_table(values='sales', index='date', columns='product', aggfunc='sum')
print(pivot)
```

### Pivot with Aggregation

```python
import pandas as pd

df = pd.DataFrame({
    'date': ['2023-01-01', '2023-01-01', '2023-01-01', '2023-01-02', '2023-01-02'],
    'product': ['A', 'A', 'B', 'A', 'B'],
    'sales': [100, 150, 200, 120, 250],
    'region': ['North', 'South', 'North', 'South', 'North']
})

# Pivot with multiple aggregations
pivot = df.pivot_table(
    values='sales',
    index='date',
    columns='product',
    aggfunc=['sum', 'mean']
)
print(pivot)

# Pivot with multiple index columns
pivot = df.pivot_table(
    values='sales',
    index=['date', 'region'],
    columns='product',
    aggfunc='sum'
)
print(pivot)
```

---

## Advanced Filtering

### Using apply() for Complex Filtering

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob', 'Charlie'],
    'age': [25, 30, 35],
    'salary': [50000, 60000, 70000]
})

# Filter using apply
def high_earner(row):
    return row['salary'] > 55000 and row['age'] < 35

filtered = df[df.apply(high_earner, axis=1)]
print(filtered)
```

### Using query() with Complex Conditions

```python
import pandas as pd

df = pd.DataFrame({
    'name': ['Alice', 'Bob', 'Charlie'],
    'age': [25, 30, 35],
    'salary': [50000, 60000, 70000],
    'department': ['Sales', 'IT', 'Sales']
})

# Complex query
filtered = df.query('(age > 25 and salary > 55000) or department == "Sales"')
print(filtered)
```

---

## Practical Examples

### Example 1: Sales Analysis

```python
import pandas as pd

# Sample sales data
sales_data = pd.DataFrame({
    'date': pd.date_range('2023-01-01', periods=10, freq='D'),
    'product': ['A', 'B', 'A', 'C', 'B', 'A', 'C', 'B', 'A', 'C'],
    'sales': [100, 200, 150, 300, 250, 120, 350, 280, 110, 320],
    'region': ['North', 'South', 'North', 'East', 'South', 'North', 'East', 'South', 'North', 'East']
})

# Group by product
product_sales = sales_data.groupby('product')['sales'].agg(['sum', 'mean', 'count'])
print("Sales by Product:")
print(product_sales)

# Group by region
region_sales = sales_data.groupby('region')['sales'].sum()
print("\nSales by Region:")
print(region_sales)

# Pivot table
pivot = sales_data.pivot_table(
    values='sales',
    index='date',
    columns='product',
    aggfunc='sum',
    fill_value=0
)
print("\nPivot Table:")
print(pivot)
```

### Example 2: Employee Analysis

```python
import pandas as pd

# Employee data
employees = pd.DataFrame({
    'employee_id': [1, 2, 3, 4, 5],
    'name': ['Alice', 'Bob', 'Charlie', 'David', 'Eve'],
    'department_id': [1, 2, 1, 3, 2],
    'salary': [50000, 60000, 55000, 70000, 65000]
})

# Department data
departments = pd.DataFrame({
    'department_id': [1, 2, 3],
    'name': ['Sales', 'IT', 'HR']
})

# Merge
merged = pd.merge(employees, departments, on='department_id', suffixes=('_emp', '_dept'))
print("Merged Data:")
print(merged)

# Analysis
dept_stats = merged.groupby('name_dept').agg({
    'salary': ['mean', 'sum', 'count'],
    'employee_id': 'count'
})
print("\nDepartment Statistics:")
print(dept_stats)
```

---

## Common Mistakes and Pitfalls

### 1. SettingWithCopyWarning

```python
# WRONG: May cause warning
df = pd.DataFrame({'a': [1, 2, 3], 'b': [4, 5, 6]})
subset = df[df['a'] > 1]
subset['c'] = 10  # Warning!

# CORRECT: Use copy()
subset = df[df['a'] > 1].copy()
subset['c'] = 10  # No warning
```

### 2. Forgetting to Reset Index

```python
# After filtering, index may not be sequential
df_filtered = df[df['age'] > 30]
print(df_filtered.index)  # May have gaps

# Reset index if needed
df_filtered = df[df['age'] > 30].reset_index(drop=True)
print(df_filtered.index)  # Sequential
```

### 3. Merge Key Mismatch

```python
# WRONG: Keys don't match
df1 = pd.DataFrame({'id': [1, 2, 3]})
df2 = pd.DataFrame({'ID': [1, 2, 3]})  # Different case
# merged = pd.merge(df1, df2, on='id')  # Error!

# CORRECT: Specify correct keys
merged = pd.merge(df1, df2, left_on='id', right_on='ID')
```

---

## Best Practices

### 1. Use Vectorized Operations

```python
# WRONG: Use apply for simple operations
df['new_col'] = df.apply(lambda row: row['a'] * 2, axis=1)

# CORRECT: Use vectorized operations
df['new_col'] = df['a'] * 2
```

### 2. Chain Operations Efficiently

```python
# Chain operations for readability
result = (df[df['age'] > 30]
          .groupby('department')
          .agg({'salary': 'mean'})
          .sort_values('salary', ascending=False))
```

### 3. Use Appropriate Join Types

```python
# Choose the right join type for your use case
# Inner: Only matching records
# Left: All left records + matching right
# Right: All right records + matching left
# Outer: All records from both
```

---

## Practice Exercise

### Exercise: Data Manipulation

**Objective**: Create a program that demonstrates data manipulation operations.

**Instructions**:

1. Create or load sample data
2. Perform filtering and selection operations
3. Group data and perform aggregations
4. Merge/join multiple DataFrames
5. Create pivot tables
6. Apply advanced data manipulation techniques

**Example Solution**:

```python
"""
Data Manipulation Exercise
This program demonstrates various data manipulation operations.
"""

import pandas as pd
import numpy as np

print("=" * 50)
print("Data Manipulation Exercise")
print("=" * 50)

# 1. Create sample data
print("\n1. Creating Sample Data:")
print("-" * 50)

employees = pd.DataFrame({
    'employee_id': [1, 2, 3, 4, 5, 6, 7, 8],
    'name': ['Alice', 'Bob', 'Charlie', 'David', 'Eve', 'Frank', 'Grace', 'Henry'],
    'department_id': [1, 2, 1, 3, 2, 1, 3, 2],
    'salary': [50000, 60000, 55000, 70000, 65000, 58000, 72000, 62000],
    'age': [25, 30, 35, 40, 28, 32, 38, 29]
})

departments = pd.DataFrame({
    'department_id': [1, 2, 3],
    'name': ['Sales', 'IT', 'HR'],
    'location': ['NY', 'LA', 'NY']
})

print("Employees DataFrame:")
print(employees)
print("\nDepartments DataFrame:")
print(departments)

# 2. Filtering
print("\n2. Filtering Operations:")
print("-" * 50)

# Filter by age
young_employees = employees[employees['age'] < 30]
print("Employees under 30:")
print(young_employees[['name', 'age', 'salary']])

# Filter by multiple conditions
high_earners = employees[(employees['salary'] > 60000) & (employees['age'] < 35)]
print("\nHigh earners under 35:")
print(high_earners[['name', 'age', 'salary']])

# Filter using isin
sales_it = employees[employees['department_id'].isin([1, 2])]
print("\nSales and IT employees:")
print(sales_it[['name', 'department_id']])

# Filter using query
filtered = employees.query('salary > 60000 and age < 35')
print("\nUsing query method:")
print(filtered[['name', 'age', 'salary']])

# 3. Selection
print("\n3. Selection Operations:")
print("-" * 50)

# Select specific columns
print("Name and salary columns:")
print(employees[['name', 'salary']].head())

# Select using loc
print("\nFirst 3 rows, name and salary:")
print(employees.loc[0:2, ['name', 'salary']])

# Select using iloc
print("\nFirst 2 rows, first 3 columns:")
print(employees.iloc[0:2, 0:3])

# 4. Grouping and Aggregation
print("\n4. Grouping and Aggregation:")
print("-" * 50)

# Group by department
dept_stats = employees.groupby('department_id').agg({
    'salary': ['mean', 'sum', 'count', 'min', 'max'],
    'age': 'mean'
})
print("Department Statistics:")
print(dept_stats)

# Group by department with custom aggregation
dept_summary = employees.groupby('department_id')['salary'].agg([
    ('avg_salary', 'mean'),
    ('total_salary', 'sum'),
    ('employee_count', 'count')
])
print("\nDepartment Summary:")
print(dept_summary)

# Multiple column grouping
age_dept = employees.groupby(['department_id', 'age'])['salary'].mean()
print("\nAverage salary by department and age:")
print(age_dept.head(10))

# 5. Merging
print("\n5. Merging DataFrames:")
print("-" * 50)

# Merge employees with departments
merged = pd.merge(employees, departments, on='department_id', how='inner')
print("Merged DataFrame:")
print(merged[['name', 'salary', 'name_y', 'location']].head())

# Rename columns for clarity
merged = merged.rename(columns={'name_x': 'employee_name', 'name_y': 'department_name'})
print("\nRenamed columns:")
print(merged[['employee_name', 'salary', 'department_name', 'location']].head())

# 6. Analysis on Merged Data
print("\n6. Analysis on Merged Data:")
print("-" * 50)

# Group by department name
dept_analysis = merged.groupby('department_name').agg({
    'salary': ['mean', 'sum', 'count'],
    'age': 'mean'
})
print("Analysis by Department Name:")
print(dept_analysis)

# Group by location
location_analysis = merged.groupby('location').agg({
    'salary': 'mean',
    'employee_name': 'count'
})
print("\nAnalysis by Location:")
print(location_analysis)

# 7. Pivot Table
print("\n7. Pivot Tables:")
print("-" * 50)

# Create pivot table
pivot = merged.pivot_table(
    values='salary',
    index='department_name',
    columns='location',
    aggfunc='mean',
    fill_value=0
)
print("Pivot Table (Salary by Department and Location):")
print(pivot)

# 8. Advanced Operations
print("\n8. Advanced Operations:")
print("-" * 50)

# Transform: Normalize salary within department
merged['salary_normalized'] = merged.groupby('department_name')['salary'].transform(
    lambda x: (x - x.mean()) / x.std()
)
print("Salary normalized within department:")
print(merged[['employee_name', 'department_name', 'salary', 'salary_normalized']].head())

# Apply: Create salary category
def salary_category(row):
    if row['salary'] < 55000:
        return 'Low'
    elif row['salary'] < 65000:
        return 'Medium'
    else:
        return 'High'

merged['salary_category'] = merged.apply(salary_category, axis=1)
print("\nSalary categories:")
print(merged[['employee_name', 'salary', 'salary_category']].head())

# 9. Cross-tabulation
print("\n9. Cross-tabulation:")
print("-" * 50)

crosstab = pd.crosstab(merged['department_name'], merged['salary_category'])
print("Department vs Salary Category:")
print(crosstab)

# 10. Concatenation
print("\n10. Concatenation:")
print("-" * 50)

# Create additional data
new_employees = pd.DataFrame({
    'employee_id': [9, 10],
    'name': ['Iris', 'Jack'],
    'department_id': [1, 2],
    'salary': [52000, 63000],
    'age': [27, 31]
})

# Concatenate
all_employees = pd.concat([employees, new_employees], ignore_index=True)
print("All employees (after concatenation):")
print(all_employees)

print("\n" + "=" * 50)
print("Exercise completed!")
print("=" * 50)
```

**Expected Output**: Demonstrates various data manipulation operations including filtering, grouping, merging, and advanced operations.

**Challenge** (Optional):
- Work with time series data
- Perform more complex aggregations
- Create multi-level pivot tables
- Handle duplicate data
- Implement data validation

---

## Key Takeaways

1. **Filtering** - Boolean indexing, query(), loc, iloc
2. **Selection** - Select columns, rows, subsets
3. **Grouping** - groupby() for aggregations
4. **Aggregation** - sum, mean, count, min, max, custom functions
5. **Merging** - Inner, left, right, outer joins
6. **Joining** - join() method for index-based joins
7. **Concatenation** - Combine DataFrames vertically or horizontally
8. **Pivot tables** - Reshape data for analysis
9. **Transform** - Apply functions that return same shape
10. **Apply** - Apply custom functions to rows/columns
11. **String methods** - Filter using string operations
12. **Multiple grouping** - Group by multiple columns
13. **Cross-tabulation** - Create frequency tables
14. **Best practices** - Vectorized operations, appropriate joins
15. **Common mistakes** - SettingWithCopyWarning, index issues

---

## Quiz: Data Manipulation

Test your understanding with these questions:

1. **What filters rows where age > 30?**
   - A) df[age > 30]
   - B) df[df['age'] > 30]
   - C) df.filter(age > 30)
   - D) df.where(age > 30)

2. **What groups data by column?**
   - A) df.group()
   - B) df.groupby()
   - C) df.aggregate()
   - D) df.collect()

3. **What is the default join type in merge()?**
   - A) left
   - B) right
   - C) inner
   - D) outer

4. **What concatenates DataFrames vertically?**
   - A) pd.concat([df1, df2], axis=0)
   - B) pd.concat([df1, df2], axis=1)
   - C) pd.merge(df1, df2)
   - D) df1.join(df2)

5. **What creates a pivot table?**
   - A) df.pivot()
   - B) df.pivot_table()
   - C) df.reshape()
   - D) df.transpose()

6. **What aggregates multiple functions?**
   - A) df.agg()
   - B) df.aggregate()
   - C) df.groupby().agg()
   - D) All of the above

7. **What filters using string contains?**
   - A) df[df['col'].contains('text')]
   - B) df[df['col'].str.contains('text')]
   - C) df.filter('text')
   - D) df[df['col'] == 'text']

8. **What resets index after filtering?**
   - A) df.reset_index()
   - B) df.reindex()
   - C) df.set_index()
   - D) df.index_reset()

9. **What applies function to each row?**
   - A) df.apply(func, axis=0)
   - B) df.apply(func, axis=1)
   - C) df.map(func)
   - D) df.transform(func)

10. **What joins on index?**
    - A) pd.merge()
    - B) df.join()
    - C) pd.concat()
    - D) Both A and B

**Answers**:
1. B) df[df['age'] > 30] (boolean indexing)
2. B) df.groupby() (grouping function)
3. C) inner (default join type)
4. A) pd.concat([df1, df2], axis=0) (vertical concatenation)
5. B) df.pivot_table() (pivot table function)
6. D) All of the above (aggregation methods)
7. B) df[df['col'].str.contains('text')] (string method)
8. A) df.reset_index() (reset index)
9. B) df.apply(func, axis=1) (apply to rows)
10. B) df.join() (index-based join)

---

## Next Steps

Excellent work! You've mastered data manipulation. You now understand:
- Filtering and selection
- Grouping and aggregation
- Merging and joining
- Advanced data operations

**What's Next?**
- Lesson 22.3: Data Cleaning
- Learn handling missing data
- Data transformation techniques
- More data preparation

---

## Additional Resources

- **Pandas Documentation**: [pandas.pydata.org/](https://pandas.pydata.org/)
- **Pandas User Guide**: [pandas.pydata.org/docs/user_guide/index.html](https://pandas.pydata.org/docs/user_guide/index.html)
- **Groupby Guide**: [pandas.pydata.org/docs/user_guide/groupby.html](https://pandas.pydata.org/docs/user_guide/groupby.html)
- **Merge Guide**: [pandas.pydata.org/docs/user_guide/merging.html](https://pandas.pydata.org/docs/user_guide/merging.html)

---

*Lesson completed! You're ready to move on to the next lesson.*

