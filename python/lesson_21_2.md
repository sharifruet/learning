# Lesson 21.2: Array Operations

## Learning Objectives

By the end of this lesson, you will be able to:
- Master indexing and slicing NumPy arrays
- Understand advanced indexing techniques
- Perform array manipulation operations
- Use broadcasting for array operations
- Apply mathematical operations on arrays
- Work with multi-dimensional arrays
- Use array concatenation and splitting
- Perform array stacking operations
- Apply universal functions (ufuncs)
- Use array aggregation functions
- Handle array transformations
- Apply advanced array operations
- Debug array operation issues

---

## Indexing and Slicing

### Basic Indexing

```python
import numpy as np

# 1D array indexing
arr = np.array([10, 20, 30, 40, 50])
print(arr[0])    # 10 - first element
print(arr[2])    # 30 - third element
print(arr[-1])   # 50 - last element
print(arr[-2])   # 40 - second to last
```

### Slicing

```python
import numpy as np

arr = np.array([10, 20, 30, 40, 50, 60, 70, 80])

# Basic slicing: [start:stop:step]
print(arr[1:5])      # [20 30 40 50] - elements 1 to 4
print(arr[:5])       # [10 20 30 40 50] - first 5 elements
print(arr[3:])       # [40 50 60 70 80] - from index 3 to end
print(arr[::2])      # [10 30 50 70] - every 2nd element
print(arr[::-1])     # [80 70 60 50 40 30 20 10] - reverse
```

### 2D Array Indexing

```python
import numpy as np

arr = np.array([[1, 2, 3], [4, 5, 6], [7, 8, 9]])

# Single element
print(arr[0, 0])     # 1 - row 0, column 0
print(arr[1, 2])     # 6 - row 1, column 2

# Row slicing
print(arr[0, :])     # [1 2 3] - entire first row
print(arr[1, :])     # [4 5 6] - entire second row

# Column slicing
print(arr[:, 0])     # [1 4 7] - entire first column
print(arr[:, 2])     # [3 6 9] - entire third column

# Subarray
print(arr[0:2, 1:3]) # [[2 3] [5 6]] - 2x2 subarray
```

### 3D Array Indexing

```python
import numpy as np

arr = np.array([[[1, 2], [3, 4]], [[5, 6], [7, 8]]])

print(arr[0, 0, 0])      # 1
print(arr[1, 1, 1])      # 8
print(arr[0, :, :])      # [[1 2] [3 4]] - first "layer"
print(arr[:, 0, :])      # [[1 2] [5 6]] - first row of each layer
```

### Boolean Indexing

```python
import numpy as np

arr = np.array([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])

# Create boolean mask
mask = arr > 5
print(mask)              # [False False False False False  True  True  True  True  True]

# Use mask to filter
print(arr[mask])         # [ 6  7  8  9 10]

# Direct boolean indexing
print(arr[arr > 5])      # [ 6  7  8  9 10]
print(arr[arr % 2 == 0]) # [ 2  4  6  8 10] - even numbers
```

### Fancy Indexing

```python
import numpy as np

arr = np.array([10, 20, 30, 40, 50, 60, 70, 80])

# Select specific indices
indices = [0, 2, 5, 7]
print(arr[indices])      # [10 30 60 80]

# 2D fancy indexing
arr_2d = np.array([[1, 2, 3], [4, 5, 6], [7, 8, 9]])
rows = [0, 2]
cols = [1, 2]
print(arr_2d[rows, cols])  # [2 9] - elements at (0,1) and (2,2)
```

### Conditional Indexing

```python
import numpy as np

arr = np.array([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])

# Multiple conditions
mask = (arr > 3) & (arr < 8)
print(arr[mask])         # [4 5 6 7]

# Using where
result = np.where(arr > 5, arr, 0)
print(result)            # [0 0 0 0 0 0 7 8 9 10]

# Get indices where condition is true
indices = np.where(arr > 5)
print(indices)           # (array([6, 7, 8, 9]),)
print(arr[indices])      # [ 7  8  9 10]
```

---

## Array Manipulation

### Reshaping

```python
import numpy as np

arr = np.arange(12)
print(arr)                # [ 0  1  2  3  4  5  6  7  8  9 10 11]

# Reshape to 2D
arr_2d = arr.reshape(3, 4)
print(arr_2d)
# [[ 0  1  2  3]
#  [ 4  5  6  7]
#  [ 8  9 10 11]]

# Reshape to 3D
arr_3d = arr.reshape(2, 3, 2)
print(arr_3d)

# Flatten
flat = arr_2d.flatten()
print(flat)               # [ 0  1  2  3  4  5  6  7  8  9 10 11]

# Ravel (similar to flatten, but returns view if possible)
raveled = arr_2d.ravel()
print(raveled)
```

### Transpose

```python
import numpy as np

arr = np.array([[1, 2, 3], [4, 5, 6]])
print(arr)
# [[1 2 3]
#  [4 5 6]]

# Transpose
transposed = arr.T
print(transposed)
# [[1 4]
#  [2 5]
#  [3 6]]

# Using transpose method
transposed2 = arr.transpose()
print(transposed2)
```

### Concatenation

```python
import numpy as np

arr1 = np.array([1, 2, 3])
arr2 = np.array([4, 5, 6])

# Concatenate 1D arrays
result = np.concatenate([arr1, arr2])
print(result)              # [1 2 3 4 5 6]

# Concatenate 2D arrays
arr1_2d = np.array([[1, 2], [3, 4]])
arr2_2d = np.array([[5, 6], [7, 8]])

# Along axis 0 (rows)
result = np.concatenate([arr1_2d, arr2_2d], axis=0)
print(result)
# [[1 2]
#  [3 4]
#  [5 6]
#  [7 8]]

# Along axis 1 (columns)
result = np.concatenate([arr1_2d, arr2_2d], axis=1)
print(result)
# [[1 2 5 6]
#  [3 4 7 8]]
```

### Stacking

```python
import numpy as np

arr1 = np.array([1, 2, 3])
arr2 = np.array([4, 5, 6])

# Stack vertically (rows)
result = np.vstack([arr1, arr2])
print(result)
# [[1 2 3]
#  [4 5 6]]

# Stack horizontally (columns)
result = np.hstack([arr1, arr2])
print(result)              # [1 2 3 4 5 6]

# Stack along depth (3D)
result = np.dstack([arr1, arr2])
print(result)
# [[[1 4]
#   [2 5]
#   [3 6]]]

# General stacking
result = np.stack([arr1, arr2], axis=0)  # Stack along new axis
print(result)
```

### Splitting

```python
import numpy as np

arr = np.array([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])

# Split into equal parts
parts = np.split(arr, 2)
print(parts)              # [array([1, 2, 3, 4, 5]), array([ 6,  7,  8,  9, 10])]

# Split at specific indices
parts = np.split(arr, [3, 7])
print(parts)              # [array([1, 2, 3]), array([4, 5, 6, 7]), array([ 8,  9, 10])]

# 2D splitting
arr_2d = np.array([[1, 2, 3], [4, 5, 6], [7, 8, 9], [10, 11, 12]])

# Split along axis 0 (rows)
parts = np.split(arr_2d, 2, axis=0)
print(parts)

# Split along axis 1 (columns)
parts = np.split(arr_2d, 3, axis=1)
print(parts)

# Horizontal and vertical split
hsplit = np.hsplit(arr_2d, 3)  # Split into 3 columns
vsplit = np.vsplit(arr_2d, 2)   # Split into 2 rows
```

### Copying Arrays

```python
import numpy as np

arr = np.array([1, 2, 3, 4, 5])

# Shallow copy (view)
view = arr
view[0] = 99
print(arr)                # [99  2  3  4  5] - original changed!

# Deep copy
arr = np.array([1, 2, 3, 4, 5])
copy = arr.copy()
copy[0] = 99
print(arr)                # [1 2 3 4 5] - original unchanged
print(copy)               # [99  2  3  4  5]
```

### Adding and Removing Elements

```python
import numpy as np

arr = np.array([1, 2, 3, 4, 5])

# Append
arr = np.append(arr, 6)
print(arr)                # [1 2 3 4 5 6]

# Insert
arr = np.insert(arr, 2, 99)
print(arr)                # [ 1  2 99  3  4  5  6]

# Delete
arr = np.delete(arr, 2)
print(arr)                # [1 2 3 4 5 6]
```

---

## Mathematical Operations

### Element-wise Operations

```python
import numpy as np

arr1 = np.array([1, 2, 3, 4])
arr2 = np.array([5, 6, 7, 8])

# Addition
print(arr1 + arr2)        # [ 6  8 10 12]

# Subtraction
print(arr2 - arr1)        # [4 4 4 4]

# Multiplication
print(arr1 * arr2)        # [ 5 12 21 32]

# Division
print(arr2 / arr1)        # [5.  3.  2.333... 2.  ]

# Power
print(arr1 ** 2)          # [ 1  4  9 16]

# Modulo
print(arr2 % arr1)        # [0 0 1 0]
```

### Universal Functions (ufuncs)

```python
import numpy as np

arr = np.array([1, 2, 3, 4, 5])

# Trigonometric functions
angles = np.array([0, np.pi/2, np.pi])
print(np.sin(angles))
print(np.cos(angles))
print(np.tan(angles))

# Exponential and logarithmic
print(np.exp(arr))        # Exponential
print(np.log(arr))        # Natural log
print(np.log10(arr))      # Base 10 log
print(np.log2(arr))       # Base 2 log

# Power functions
print(np.sqrt(arr))       # Square root
print(np.power(arr, 2))   # Power
print(np.square(arr))     # Square

# Rounding
arr_float = np.array([1.5, 2.7, 3.2, 4.9])
print(np.round(arr_float))    # [2. 3. 3. 5.]
print(np.floor(arr_float))    # [1. 2. 3. 4.]
print(np.ceil(arr_float))     # [2. 3. 4. 5.]
```

### Matrix Operations

```python
import numpy as np

# Matrix multiplication
A = np.array([[1, 2], [3, 4]])
B = np.array([[5, 6], [7, 8]])

# Element-wise multiplication
print(A * B)
# [[ 5 12]
#  [21 32]]

# Matrix multiplication (dot product)
print(np.dot(A, B))
# [[19 22]
#  [43 50]]

# Using @ operator (Python 3.5+)
print(A @ B)
# [[19 22]
#  [43 50]]

# Inner product
print(np.inner(A, B))

# Outer product
a = np.array([1, 2, 3])
b = np.array([4, 5, 6])
print(np.outer(a, b))
```

### Aggregation Functions

```python
import numpy as np

arr = np.array([[1, 2, 3], [4, 5, 6], [7, 8, 9]])

# Sum
print(np.sum(arr))        # 45 - sum of all elements
print(np.sum(arr, axis=0)) # [12 15 18] - sum along columns
print(np.sum(arr, axis=1)) # [ 6 15 24] - sum along rows

# Mean
print(np.mean(arr))       # 5.0
print(np.mean(arr, axis=0)) # [4. 5. 6.]

# Standard deviation
print(np.std(arr))        # 2.581...

# Variance
print(np.var(arr))        # 6.666...

# Min and Max
print(np.min(arr))        # 1
print(np.max(arr))        # 9
print(np.argmin(arr))     # 0 - index of minimum
print(np.argmax(arr))     # 8 - index of maximum

# Median
print(np.median(arr))     # 5.0

# Percentile
print(np.percentile(arr, 50))  # 50th percentile (median)
print(np.percentile(arr, [25, 50, 75]))  # [3. 5. 7.]
```

### Broadcasting

```python
import numpy as np

# Broadcasting allows operations on arrays of different shapes
arr = np.array([[1, 2, 3], [4, 5, 6], [7, 8, 9]])

# Add scalar to array
print(arr + 10)
# [[11 12 13]
#  [14 15 16]
#  [17 18 19]]

# Multiply array by scalar
print(arr * 2)
# [[ 2  4  6]
#  [ 8 10 12]
#  [14 16 18]]

# Add 1D array to 2D array
row = np.array([10, 20, 30])
print(arr + row)
# [[11 22 33]
#  [14 25 36]
#  [17 28 39]]

# Add column vector
col = np.array([[10], [20], [30]])
print(arr + col)
# [[11 12 13]
#  [24 25 26]
#  [37 38 39]]
```

---

## Advanced Operations

### Sorting

```python
import numpy as np

arr = np.array([3, 1, 4, 1, 5, 9, 2, 6])

# Sort (in-place)
arr_sorted = np.sort(arr)
print(arr_sorted)         # [1 1 2 3 4 5 6 9]

# Argsort (indices that would sort)
indices = np.argsort(arr)
print(indices)            # [1 3 6 0 2 4 7 5]

# Sort along axis
arr_2d = np.array([[3, 1, 4], [1, 5, 9], [2, 6, 5]])
print(np.sort(arr_2d, axis=0))  # Sort along columns
print(np.sort(arr_2d, axis=1))   # Sort along rows
```

### Searching

```python
import numpy as np

arr = np.array([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])

# Find indices where condition is true
indices = np.where(arr > 5)
print(indices)            # (array([5, 6, 7, 8, 9]),)

# Search sorted array
sorted_arr = np.array([1, 3, 5, 7, 9])
idx = np.searchsorted(sorted_arr, 6)
print(idx)               # 3 - index where 6 should be inserted

# Find non-zero elements
arr_with_zeros = np.array([0, 1, 0, 2, 0, 3])
non_zero = np.nonzero(arr_with_zeros)
print(non_zero)          # (array([1, 3, 5]),)
```

### Set Operations

```python
import numpy as np

arr1 = np.array([1, 2, 3, 4, 5])
arr2 = np.array([4, 5, 6, 7, 8])

# Unique elements
print(np.unique(arr1))   # [1 2 3 4 5]

# Intersection
print(np.intersect1d(arr1, arr2))  # [4 5]

# Union
print(np.union1d(arr1, arr2))      # [1 2 3 4 5 6 7 8]

# Set difference
print(np.setdiff1d(arr1, arr2))    # [1 2 3]
print(np.setdiff1d(arr2, arr1))    # [6 7 8]

# Set XOR (elements in either but not both)
print(np.setxor1d(arr1, arr2))      # [1 2 3 6 7 8]
```

### Linear Algebra

```python
import numpy as np

# Determinant
matrix = np.array([[1, 2], [3, 4]])
det = np.linalg.det(matrix)
print(det)               # -2.0

# Inverse
inv = np.linalg.inv(matrix)
print(inv)
# [[-2.   1. ]
#  [ 1.5 -0.5]]

# Eigenvalues and eigenvectors
eigenvals, eigenvecs = np.linalg.eig(matrix)
print(eigenvals)         # Eigenvalues
print(eigenvecs)         # Eigenvectors

# Solve linear system: Ax = b
A = np.array([[3, 1], [1, 2]])
b = np.array([9, 8])
x = np.linalg.solve(A, b)
print(x)                 # [2. 3.]

# Matrix rank
rank = np.linalg.matrix_rank(matrix)
print(rank)              # 2
```

---

## Practical Examples

### Example 1: Image Processing Simulation

```python
import numpy as np

# Simulate image (height, width)
image = np.random.randint(0, 256, size=(100, 100), dtype=np.uint8)

# Crop image
cropped = image[20:80, 20:80]

# Flip image
flipped_h = image[:, ::-1]  # Horizontal flip
flipped_v = image[::-1, :]   # Vertical flip

# Rotate (transpose)
rotated = image.T

# Brightness adjustment
brightened = np.clip(image * 1.5, 0, 255).astype(np.uint8)

# Contrast adjustment
contrast = np.clip((image - 128) * 1.5 + 128, 0, 255).astype(np.uint8)
```

### Example 2: Data Analysis

```python
import numpy as np

# Generate sample data
data = np.random.normal(100, 15, 1000)

# Calculate statistics
mean = np.mean(data)
std = np.std(data)
median = np.median(data)
q25 = np.percentile(data, 25)
q75 = np.percentile(data, 75)

print(f"Mean: {mean:.2f}")
print(f"Std: {std:.2f}")
print(f"Median: {median:.2f}")
print(f"Q1: {q25:.2f}")
print(f"Q3: {q75:.2f}")

# Find outliers (beyond 3 standard deviations)
outliers = data[np.abs(data - mean) > 3 * std]
print(f"Outliers: {len(outliers)}")
```

### Example 3: Matrix Operations

```python
import numpy as np

# Create matrices
A = np.array([[1, 2, 3], [4, 5, 6]])
B = np.array([[7, 8], [9, 10], [11, 12]])

# Matrix multiplication
C = A @ B
print(C)
# [[ 58  64]
#  [139 154]]

# Element-wise operations
D = A * A  # Square each element
print(D)

# Sum along different axes
row_sums = A.sum(axis=1)
col_sums = A.sum(axis=0)
print(f"Row sums: {row_sums}")
print(f"Column sums: {col_sums}")
```

---

## Common Mistakes and Pitfalls

### 1. View vs Copy

```python
# WRONG: Modifying view changes original
arr = np.array([1, 2, 3, 4, 5])
view = arr[1:4]
view[0] = 99
print(arr)  # [ 1 99  3  4  5] - original changed!

# CORRECT: Use copy() when needed
arr = np.array([1, 2, 3, 4, 5])
copy = arr[1:4].copy()
copy[0] = 99
print(arr)  # [1 2 3 4 5] - original unchanged
```

### 2. Broadcasting Errors

```python
# WRONG: Incompatible shapes
arr1 = np.array([[1, 2], [3, 4]])
arr2 = np.array([1, 2, 3])
# result = arr1 + arr2  # Error: shapes not compatible

# CORRECT: Ensure compatible shapes
arr1 = np.array([[1, 2], [3, 4]])
arr2 = np.array([1, 2])
result = arr1 + arr2  # Works with broadcasting
```

### 3. Index Out of Bounds

```python
# WRONG: Index out of bounds
arr = np.array([1, 2, 3, 4, 5])
# print(arr[10])  # IndexError

# CORRECT: Check bounds or use safe indexing
if 10 < len(arr):
    print(arr[10])
else:
    print("Index out of bounds")
```

---

## Best Practices

### 1. Use Vectorized Operations

```python
# WRONG: Use loops
arr = np.array([1, 2, 3, 4, 5])
result = np.zeros_like(arr)
for i in range(len(arr)):
    result[i] = arr[i] * 2

# CORRECT: Use vectorized operations
arr = np.array([1, 2, 3, 4, 5])
result = arr * 2  # Much faster!
```

### 2. Prefer NumPy Functions

```python
# WRONG: Use Python built-ins
arr = np.array([1, 2, 3, 4, 5])
result = sum(arr)  # Slower

# CORRECT: Use NumPy functions
arr = np.array([1, 2, 3, 4, 5])
result = np.sum(arr)  # Faster
```

### 3. Use Appropriate Data Types

```python
# Use smallest appropriate type
arr = np.array([1, 2, 3], dtype=np.int8)  # 1 byte vs 8 bytes
```

---

## Practice Exercise

### Exercise: Array Operations

**Objective**: Create a program that demonstrates various NumPy array operations.

**Instructions**:

1. Create arrays and perform indexing/slicing
2. Manipulate arrays (reshape, concatenate, split)
3. Perform mathematical operations
4. Use aggregation functions
5. Apply advanced operations (sorting, searching)

**Example Solution**:

```python
"""
Array Operations Exercise
This program demonstrates various NumPy array operations.
"""

import numpy as np

print("=" * 50)
print("Array Operations Exercise")
print("=" * 50)

# 1. Indexing and Slicing
print("\n1. Indexing and Slicing:")
print("-" * 50)

arr = np.arange(10, 20)
print(f"Array: {arr}")
print(f"First element: {arr[0]}")
print(f"Last element: {arr[-1]}")
print(f"Slice [2:7]: {arr[2:7]}")
print(f"Every 2nd element: {arr[::2]}")
print(f"Reverse: {arr[::-1]}")

# 2D array
arr_2d = np.array([[1, 2, 3, 4], [5, 6, 7, 8], [9, 10, 11, 12]])
print(f"\n2D Array:\n{arr_2d}")
print(f"Element [1, 2]: {arr_2d[1, 2]}")
print(f"Row 1: {arr_2d[1, :]}")
print(f"Column 2: {arr_2d[:, 2]}")
print(f"Subarray [0:2, 1:3]:\n{arr_2d[0:2, 1:3]}")

# Boolean indexing
arr = np.array([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
mask = arr > 5
print(f"\nArray: {arr}")
print(f"Elements > 5: {arr[mask]}")

# 2. Array Manipulation
print("\n2. Array Manipulation:")
print("-" * 50)

arr = np.arange(12)
print(f"Original: {arr}")

# Reshape
arr_2d = arr.reshape(3, 4)
print(f"Reshaped (3x4):\n{arr_2d}")

# Transpose
transposed = arr_2d.T
print(f"Transposed (4x3):\n{transposed}")

# Concatenate
arr1 = np.array([1, 2, 3])
arr2 = np.array([4, 5, 6])
concatenated = np.concatenate([arr1, arr2])
print(f"\nConcatenated: {concatenated}")

# Stack
stacked = np.vstack([arr1, arr2])
print(f"Stacked vertically:\n{stacked}")

# Split
arr = np.array([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
parts = np.split(arr, 2)
print(f"\nSplit into 2 parts: {parts}")

# 3. Mathematical Operations
print("\n3. Mathematical Operations:")
print("-" * 50)

arr1 = np.array([1, 2, 3, 4])
arr2 = np.array([5, 6, 7, 8])

print(f"arr1: {arr1}")
print(f"arr2: {arr2}")
print(f"Addition: {arr1 + arr2}")
print(f"Multiplication: {arr1 * arr2}")
print(f"Power: {arr1 ** 2}")

# Universal functions
arr = np.array([1, 2, 3, 4, 5])
print(f"\nArray: {arr}")
print(f"Square root: {np.sqrt(arr)}")
print(f"Exponential: {np.exp(arr)}")
print(f"Logarithm: {np.log(arr)}")

# 4. Aggregation Functions
print("\n4. Aggregation Functions:")
print("-" * 50)

arr = np.array([[1, 2, 3], [4, 5, 6], [7, 8, 9]])
print(f"Array:\n{arr}")
print(f"Sum of all: {np.sum(arr)}")
print(f"Sum along rows: {np.sum(arr, axis=1)}")
print(f"Sum along columns: {np.sum(arr, axis=0)}")
print(f"Mean: {np.mean(arr):.2f}")
print(f"Std: {np.std(arr):.2f}")
print(f"Min: {np.min(arr)}")
print(f"Max: {np.max(arr)}")

# 5. Advanced Operations
print("\n5. Advanced Operations:")
print("-" * 50)

arr = np.array([3, 1, 4, 1, 5, 9, 2, 6])
print(f"Original: {arr}")
sorted_arr = np.sort(arr)
print(f"Sorted: {sorted_arr}")

# Searching
indices = np.where(arr > 4)
print(f"Indices where > 4: {indices[0]}")
print(f"Values > 4: {arr[indices]}")

# Set operations
arr1 = np.array([1, 2, 3, 4, 5])
arr2 = np.array([4, 5, 6, 7, 8])
print(f"\nArray 1: {arr1}")
print(f"Array 2: {arr2}")
print(f"Unique in arr1: {np.unique(arr1)}")
print(f"Intersection: {np.intersect1d(arr1, arr2)}")
print(f"Union: {np.union1d(arr1, arr2)}")
print(f"Difference (arr1 - arr2): {np.setdiff1d(arr1, arr2)}")

# 6. Broadcasting
print("\n6. Broadcasting:")
print("-" * 50)

arr = np.array([[1, 2, 3], [4, 5, 6], [7, 8, 9]])
print(f"Array:\n{arr}")
print(f"Add 10:\n{arr + 10}")
row = np.array([10, 20, 30])
print(f"Add row vector:\n{arr + row}")

# 7. Linear Algebra
print("\n7. Linear Algebra:")
print("-" * 50)

A = np.array([[1, 2], [3, 4]])
B = np.array([[5, 6], [7, 8]])

print(f"Matrix A:\n{A}")
print(f"Matrix B:\n{B}")
print(f"A @ B:\n{A @ B}")
print(f"Determinant of A: {np.linalg.det(A):.2f}")

print("\n" + "=" * 50)
print("Exercise completed!")
print("=" * 50)
```

**Expected Output**: Demonstrates various array operations including indexing, manipulation, mathematical operations, and advanced features.

**Challenge** (Optional):
- Implement a function to normalize data (0-1 scale)
- Create a function to calculate correlation between two arrays
- Implement a moving average function
- Create a function to find and remove outliers
- Implement matrix operations for image transformations

---

## Key Takeaways

1. **Indexing** - Access elements using indices
2. **Slicing** - Extract subarrays using [start:stop:step]
3. **Boolean indexing** - Filter arrays using conditions
4. **Fancy indexing** - Select specific indices
5. **Reshaping** - Change array dimensions
6. **Concatenation** - Combine arrays
7. **Splitting** - Divide arrays into parts
8. **Mathematical operations** - Element-wise and matrix operations
9. **Universal functions** - Fast mathematical functions
10. **Aggregation** - Sum, mean, std, min, max, etc.
11. **Broadcasting** - Operations on arrays of different shapes
12. **Sorting** - Sort arrays and get sort indices
13. **Searching** - Find elements and indices
14. **Set operations** - Unique, intersect, union, difference
15. **Linear algebra** - Matrix operations, determinants, inverses

---

## Quiz: NumPy Operations

Test your understanding with these questions:

1. **What does arr[1:5] return?**
   - A) Elements at indices 1, 2, 3, 4, 5
   - B) Elements at indices 1, 2, 3, 4
   - C) Elements at indices 0, 1, 2, 3, 4
   - D) Error

2. **What does arr[::-1] do?**
   - A) Reverses the array
   - B) Skips every element
   - C) Returns empty array
   - D) Error

3. **What is broadcasting?**
   - A) Operations on same-shaped arrays
   - B) Operations on different-shaped arrays
   - C) Network operations
   - D) Array copying

4. **What does np.concatenate() do?**
   - A) Split arrays
   - B) Combine arrays
   - C) Reshape arrays
   - D) Transpose arrays

5. **What axis=0 means in 2D arrays?**
   - A) Rows
   - B) Columns
   - C) Depth
   - D) None

6. **What does np.sum(arr, axis=1) do?**
   - A) Sum all elements
   - B) Sum along rows
   - C) Sum along columns
   - D) Sum along depth

7. **What is the difference between view and copy?**
   - A) View is faster
   - B) Copy is independent
   - C) View shares memory
   - D) All of the above

8. **What does np.where() return?**
   - A) Values
   - B) Indices
   - C) Boolean array
   - D) Modified array

9. **What does np.unique() do?**
   - A) Sort array
   - B) Remove duplicates
   - C) Find unique elements
   - D) Both B and C

10. **What is matrix multiplication?**
    - A) Element-wise multiplication
    - B) Dot product
    - C) Outer product
    - D) All of the above

**Answers**:
1. B) Elements at indices 1, 2, 3, 4 (slicing excludes stop)
2. A) Reverses the array (negative step)
3. B) Operations on different-shaped arrays (broadcasting)
4. B) Combine arrays (concatenation)
5. A) Rows (axis=0 is rows)
6. B) Sum along rows (axis=1 is columns, but sum along axis=1 sums rows)
7. D) All of the above (view vs copy differences)
8. B) Indices (where returns indices)
9. D) Both B and C (unique removes duplicates and returns unique)
10. B) Dot product (matrix multiplication)

---

## Next Steps

Excellent work! You've mastered array operations. You now understand:
- Indexing and slicing
- Array manipulation
- Mathematical operations
- Advanced NumPy features

**What's Next?**
- Module 22: Pandas
- Lesson 22.1: Pandas DataFrames
- Learn data manipulation with Pandas
- Work with structured data

---

## Additional Resources

- **NumPy Documentation**: [numpy.org/doc/](https://numpy.org/doc/)
- **NumPy User Guide**: [numpy.org/doc/stable/user/index.html](https://numpy.org/doc/stable/user/index.html)
- **NumPy Reference**: [numpy.org/doc/stable/reference/](https://numpy.org/doc/stable/reference/)

---

*Lesson completed! You're ready to move on to the next module.*

