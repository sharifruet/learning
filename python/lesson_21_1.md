# Lesson 21.1: NumPy Basics

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what NumPy is and why it's important
- Install and import NumPy
- Create NumPy arrays
- Understand array properties (shape, dtype, size)
- Perform basic array operations
- Work with different data types
- Create arrays from lists and other sources
- Understand the difference between arrays and lists
- Perform element-wise operations
- Use NumPy's built-in functions
- Apply NumPy in data science contexts
- Debug NumPy-related issues

---

## Introduction to NumPy

**NumPy (Numerical Python)** is a fundamental library for scientific computing in Python. It provides support for large, multi-dimensional arrays and matrices, along with a collection of mathematical functions to operate on these arrays.

**Key Features**:
- **Fast**: Implemented in C, much faster than Python lists
- **Memory efficient**: Uses less memory than Python lists
- **Vectorized operations**: Perform operations on entire arrays
- **Mathematical functions**: Extensive library of mathematical operations
- **Foundation**: Base for many other data science libraries (Pandas, SciPy, etc.)

**Why NumPy?**
- Python lists are slow for numerical computations
- NumPy arrays are homogeneous (same data type)
- NumPy operations are vectorized (faster)
- NumPy is the foundation of the Python data science ecosystem

---

## Installation

### Installing NumPy

```bash
# Install NumPy using pip
pip install numpy

# Install with conda (if using Anaconda)
conda install numpy

# Verify installation
python -c "import numpy; print(numpy.__version__)"
```

### Importing NumPy

```python
# Standard import (recommended)
import numpy as np

# Now you can use np.array(), np.zeros(), etc.
```

---

## Creating Arrays

### From Python Lists

```python
import numpy as np

# Create array from list
arr = np.array([1, 2, 3, 4, 5])
print(arr)  # [1 2 3 4 5]

# Create 2D array
arr_2d = np.array([[1, 2, 3], [4, 5, 6]])
print(arr_2d)
# [[1 2 3]
#  [4 5 6]]

# Create 3D array
arr_3d = np.array([[[1, 2], [3, 4]], [[5, 6], [7, 8]]])
print(arr_3d)
```

### Using Built-in Functions

```python
import numpy as np

# Create array of zeros
zeros = np.zeros(5)
print(zeros)  # [0. 0. 0. 0. 0.]

# Create 2D array of zeros
zeros_2d = np.zeros((3, 4))
print(zeros_2d)
# [[0. 0. 0. 0.]
#  [0. 0. 0. 0.]
#  [0. 0. 0. 0.]]

# Create array of ones
ones = np.ones(5)
print(ones)  # [1. 1. 1. 1. 1.]

# Create array with specific value
full = np.full(5, 7)
print(full)  # [7 7 7 7 7]

# Create identity matrix
identity = np.eye(3)
print(identity)
# [[1. 0. 0.]
#  [0. 1. 0.]
#  [0. 0. 1.]]
```

### Using Ranges

```python
import numpy as np

# Create array with range (similar to range())
arr = np.arange(0, 10, 2)
print(arr)  # [0 2 4 6 8]

# Create array with linspace (evenly spaced values)
arr = np.linspace(0, 10, 5)
print(arr)  # [ 0.   2.5  5.   7.5 10. ]

# Create array with logspace (logarithmically spaced)
arr = np.logspace(0, 2, 5)
print(arr)  # [  1.    3.16  10.   31.62 100.  ]
```

### Random Arrays

```python
import numpy as np

# Random values between 0 and 1
random_arr = np.random.random(5)
print(random_arr)

# Random integers
random_int = np.random.randint(0, 10, size=5)
print(random_int)

# Random array with normal distribution
normal = np.random.normal(0, 1, size=5)
print(normal)

# Random array with uniform distribution
uniform = np.random.uniform(0, 10, size=5)
print(uniform)
```

---

## Array Properties

### Shape and Dimensions

```python
import numpy as np

arr = np.array([1, 2, 3, 4, 5])
print(arr.shape)      # (5,) - 1D array with 5 elements
print(arr.ndim)       # 1 - number of dimensions
print(arr.size)       # 5 - total number of elements

arr_2d = np.array([[1, 2, 3], [4, 5, 6]])
print(arr_2d.shape)   # (2, 3) - 2 rows, 3 columns
print(arr_2d.ndim)    # 2 - 2 dimensions
print(arr_2d.size)    # 6 - total elements
```

### Data Types

```python
import numpy as np

# Check data type
arr = np.array([1, 2, 3, 4, 5])
print(arr.dtype)  # int64

# Specify data type
arr_float = np.array([1, 2, 3], dtype=float)
print(arr_float.dtype)  # float64

# Common data types
arr_int32 = np.array([1, 2, 3], dtype=np.int32)
arr_float32 = np.array([1.0, 2.0, 3.0], dtype=np.float32)
arr_bool = np.array([True, False, True], dtype=bool)
arr_string = np.array(['a', 'b', 'c'], dtype='U1')

print(arr_int32.dtype)    # int32
print(arr_float32.dtype)  # float32
print(arr_bool.dtype)     # bool
print(arr_string.dtype)   # <U1
```

### Reshaping Arrays

```python
import numpy as np

arr = np.arange(12)
print(arr)  # [ 0  1  2  3  4  5  6  7  8  9 10 11]

# Reshape to 2D
arr_2d = arr.reshape(3, 4)
print(arr_2d)
# [[ 0  1  2  3]
#  [ 4  5  6  7]
#  [ 8  9 10 11]]

# Reshape to 3D
arr_3d = arr.reshape(2, 3, 2)
print(arr_3d)

# Flatten array
flat = arr_2d.flatten()
print(flat)  # [ 0  1  2  3  4  5  6  7  8  9 10 11]
```

---

## Array Operations

### Arithmetic Operations

```python
import numpy as np

arr1 = np.array([1, 2, 3, 4])
arr2 = np.array([5, 6, 7, 8])

# Element-wise operations
print(arr1 + arr2)  # [ 6  8 10 12]
print(arr1 - arr2)  # [-4 -4 -4 -4]
print(arr1 * arr2)  # [ 5 12 21 32]
print(arr1 / arr2)  # [0.2 0.333... 0.428... 0.5]
print(arr1 ** 2)    # [ 1  4  9 16]

# Scalar operations
print(arr1 + 10)    # [11 12 13 14]
print(arr1 * 2)     # [2 4 6 8]
print(arr1 ** 2)    # [ 1  4  9 16]
```

### Mathematical Functions

```python
import numpy as np

arr = np.array([1, 2, 3, 4, 5])

# Basic math functions
print(np.sqrt(arr))      # Square root
print(np.exp(arr))       # Exponential
print(np.log(arr))       # Natural logarithm
print(np.sin(arr))       # Sine
print(np.cos(arr))       # Cosine
print(np.abs(arr))       # Absolute value
print(np.round(arr))     # Round

# Statistical functions
print(np.sum(arr))       # Sum of all elements
print(np.mean(arr))      # Mean (average)
print(np.std(arr))       # Standard deviation
print(np.var(arr))       # Variance
print(np.min(arr))       # Minimum value
print(np.max(arr))       # Maximum value
print(np.median(arr))    # Median
```

### Array Comparison

```python
import numpy as np

arr = np.array([1, 2, 3, 4, 5])

# Comparison operations
print(arr > 3)        # [False False False  True  True]
print(arr == 3)       # [False False  True False False]
print(arr != 3)       # [ True  True False  True  True]

# Boolean indexing
mask = arr > 3
print(arr[mask])       # [4 5]

# Multiple conditions
mask = (arr > 2) & (arr < 5)
print(arr[mask])       # [3 4]
```

---

## Working with Different Data Types

### Type Conversion

```python
import numpy as np

# Convert to different types
arr = np.array([1.5, 2.7, 3.2, 4.9])

print(arr.astype(int))        # [1 2 3 4] - truncates
print(arr.astype(float))      # [1.5 2.7 3.2 4.9]
print(arr.astype(str))        # ['1.5' '2.7' '3.2' '4.9']
print(arr.astype(bool))       # [True True True True]
```

### Type Checking

```python
import numpy as np

arr_int = np.array([1, 2, 3])
arr_float = np.array([1.0, 2.0, 3.0])

print(np.issubdtype(arr_int.dtype, np.integer))    # True
print(np.issubdtype(arr_float.dtype, np.floating)) # True
print(np.issubdtype(arr_int.dtype, np.number))   # True
```

---

## Array vs Python Lists

### Performance Comparison

```python
import numpy as np
import time

# Python list
python_list = list(range(1000000))

# NumPy array
numpy_array = np.array(range(1000000))

# Time list operation
start = time.time()
result = [x * 2 for x in python_list]
list_time = time.time() - start

# Time NumPy operation
start = time.time()
result = numpy_array * 2
numpy_time = time.time() - start

print(f"List time: {list_time:.6f} seconds")
print(f"NumPy time: {numpy_time:.6f} seconds")
print(f"NumPy is {list_time/numpy_time:.2f}x faster")
```

### Memory Comparison

```python
import numpy as np
import sys

python_list = [1, 2, 3, 4, 5]
numpy_array = np.array([1, 2, 3, 4, 5])

print(f"Python list size: {sys.getsizeof(python_list)} bytes")
print(f"NumPy array size: {numpy_array.nbytes} bytes")
print(f"NumPy is {sys.getsizeof(python_list) / numpy_array.nbytes:.2f}x more memory efficient")
```

---

## Practical Examples

### Example 1: Basic Statistics

```python
import numpy as np

# Generate random data
data = np.random.normal(100, 15, 1000)  # Mean=100, Std=15, Size=1000

# Calculate statistics
print(f"Mean: {np.mean(data):.2f}")
print(f"Median: {np.median(data):.2f}")
print(f"Standard Deviation: {np.std(data):.2f}")
print(f"Min: {np.min(data):.2f}")
print(f"Max: {np.max(data):.2f}")
print(f"Range: {np.max(data) - np.min(data):.2f}")
```

### Example 2: Array Manipulation

```python
import numpy as np

# Create matrix
matrix = np.array([[1, 2, 3], [4, 5, 6], [7, 8, 9]])
print("Original matrix:")
print(matrix)

# Transpose
transposed = matrix.T
print("\nTransposed:")
print(transposed)

# Sum along axis
print("\nSum along rows (axis=1):", matrix.sum(axis=1))
print("Sum along columns (axis=0):", matrix.sum(axis=0))

# Mean along axis
print("\nMean along rows:", matrix.mean(axis=1))
print("Mean along columns:", matrix.mean(axis=0))
```

### Example 3: Working with Images (Conceptual)

```python
import numpy as np

# Simulate image data (height, width, channels)
image = np.random.randint(0, 256, size=(100, 100, 3), dtype=np.uint8)

print(f"Image shape: {image.shape}")
print(f"Image dtype: {image.dtype}")

# Convert to grayscale (average RGB channels)
grayscale = image.mean(axis=2).astype(np.uint8)
print(f"Grayscale shape: {grayscale.shape}")

# Brighten image
brightened = np.clip(image * 1.5, 0, 255).astype(np.uint8)
```

---

## Common Mistakes and Pitfalls

### 1. Confusing Shape and Size

```python
# WRONG: Confusing shape and size
arr = np.array([1, 2, 3, 4, 5])
print(arr.shape)  # (5,) not 5
print(arr.size)   # 5

# CORRECT: Understand the difference
# shape: dimensions (5,) means 1D with 5 elements
# size: total number of elements
```

### 2. Modifying Arrays in Place

```python
# WRONG: May not work as expected
arr1 = np.array([1, 2, 3])
arr2 = arr1
arr2[0] = 99
print(arr1)  # [99  2  3] - arr1 is also modified!

# CORRECT: Use copy()
arr1 = np.array([1, 2, 3])
arr2 = arr1.copy()
arr2[0] = 99
print(arr1)  # [1 2 3] - arr1 unchanged
```

### 3. Type Mismatches

```python
# WRONG: Mixing types can cause issues
arr = np.array([1, 2, 3], dtype=int)
result = arr / 2  # Results in float, but arr is int

# CORRECT: Be aware of type conversions
arr = np.array([1, 2, 3], dtype=float)
result = arr / 2  # Works correctly
```

---

## Best Practices

### 1. Use Appropriate Data Types

```python
# Use smallest appropriate type to save memory
arr_small = np.array([1, 2, 3], dtype=np.int8)  # 1 byte per element
arr_large = np.array([1, 2, 3], dtype=np.int64)  # 8 bytes per element
```

### 2. Vectorize Operations

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

### 3. Use NumPy Functions

```python
# WRONG: Use Python built-ins
arr = np.array([1, 2, 3, 4, 5])
result = sum(arr)  # Slower

# CORRECT: Use NumPy functions
arr = np.array([1, 2, 3, 4, 5])
result = np.sum(arr)  # Faster
```

### 4. Pre-allocate Arrays

```python
# WRONG: Growing arrays
result = np.array([])
for i in range(100):
    result = np.append(result, i)  # Slow!

# CORRECT: Pre-allocate
result = np.zeros(100)
for i in range(100):
    result[i] = i  # Much faster!
```

---

## Practice Exercise

### Exercise: NumPy Basics

**Objective**: Create a program that demonstrates various NumPy operations.

**Instructions**:

1. Create arrays using different methods
2. Perform arithmetic and mathematical operations
3. Calculate statistics on data
4. Manipulate array shapes
5. Work with different data types

**Example Solution**:

```python
"""
NumPy Basics Exercise
This program demonstrates various NumPy operations.
"""

import numpy as np

print("=" * 50)
print("NumPy Basics Exercise")
print("=" * 50)

# 1. Create arrays
print("\n1. Creating Arrays:")
print("-" * 50)

# From list
arr1 = np.array([1, 2, 3, 4, 5])
print(f"Array from list: {arr1}")

# Using arange
arr2 = np.arange(0, 10, 2)
print(f"Array with arange: {arr2}")

# Using linspace
arr3 = np.linspace(0, 10, 5)
print(f"Array with linspace: {arr3}")

# Zeros and ones
zeros = np.zeros(5)
ones = np.ones(5)
print(f"Zeros: {zeros}")
print(f"Ones: {ones}")

# 2. Array properties
print("\n2. Array Properties:")
print("-" * 50)

arr = np.array([[1, 2, 3], [4, 5, 6]])
print(f"Array:\n{arr}")
print(f"Shape: {arr.shape}")
print(f"Dimensions: {arr.ndim}")
print(f"Size: {arr.size}")
print(f"Data type: {arr.dtype}")

# 3. Array operations
print("\n3. Array Operations:")
print("-" * 50)

a = np.array([1, 2, 3, 4, 5])
b = np.array([6, 7, 8, 9, 10])

print(f"a = {a}")
print(f"b = {b}")
print(f"a + b = {a + b}")
print(f"a * 2 = {a * 2}")
print(f"a ** 2 = {a ** 2}")

# 4. Mathematical functions
print("\n4. Mathematical Functions:")
print("-" * 50)

arr = np.array([1, 2, 3, 4, 5])
print(f"Array: {arr}")
print(f"Sum: {np.sum(arr)}")
print(f"Mean: {np.mean(arr)}")
print(f"Std: {np.std(arr):.2f}")
print(f"Min: {np.min(arr)}")
print(f"Max: {np.max(arr)}")
print(f"Square root: {np.sqrt(arr)}")

# 5. Reshaping
print("\n5. Reshaping Arrays:")
print("-" * 50)

arr = np.arange(12)
print(f"Original (1D): {arr}")
arr_2d = arr.reshape(3, 4)
print(f"Reshaped (2D):\n{arr_2d}")

# 6. Boolean indexing
print("\n6. Boolean Indexing:")
print("-" * 50)

arr = np.array([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
mask = arr > 5
print(f"Array: {arr}")
print(f"Mask (arr > 5): {mask}")
print(f"Filtered (arr > 5): {arr[mask]}")

# 7. Random arrays
print("\n7. Random Arrays:")
print("-" * 50)

random_arr = np.random.random(5)
print(f"Random (0-1): {random_arr}")

random_int = np.random.randint(0, 10, size=5)
print(f"Random integers (0-9): {random_int}")

normal = np.random.normal(0, 1, size=5)
print(f"Normal distribution: {normal}")

# 8. Statistics on random data
print("\n8. Statistics on Random Data:")
print("-" * 50)

data = np.random.normal(100, 15, 1000)
print(f"Generated {len(data)} random values")
print(f"Mean: {np.mean(data):.2f}")
print(f"Median: {np.median(data):.2f}")
print(f"Standard Deviation: {np.std(data):.2f}")
print(f"Min: {np.min(data):.2f}")
print(f"Max: {np.max(data):.2f}")

# 9. Matrix operations
print("\n9. Matrix Operations:")
print("-" * 50)

matrix = np.array([[1, 2, 3], [4, 5, 6], [7, 8, 9]])
print(f"Matrix:\n{matrix}")
print(f"Transpose:\n{matrix.T}")
print(f"Sum of rows: {matrix.sum(axis=1)}")
print(f"Sum of columns: {matrix.sum(axis=0)}")
print(f"Mean of rows: {matrix.mean(axis=1)}")

# 10. Type conversion
print("\n10. Type Conversion:")
print("-" * 50)

arr = np.array([1.5, 2.7, 3.2, 4.9])
print(f"Original (float): {arr}")
print(f"As int: {arr.astype(int)}")
print(f"As string: {arr.astype(str)}")

print("\n" + "=" * 50)
print("Exercise completed!")
print("=" * 50)
```

**Expected Output**:
```
==================================================
NumPy Basics Exercise
==================================================

1. Creating Arrays:
--------------------------------------------------
Array from list: [1 2 3 4 5]
Array with arange: [0 2 4 6 8]
Array with linspace: [ 0.   2.5  5.   7.5 10. ]
Zeros: [0. 0. 0. 0. 0.]
Ones: [1. 1. 1. 1. 1.]

2. Array Properties:
--------------------------------------------------
Array:
[[1 2 3]
 [4 5 6]]
Shape: (2, 3)
Dimensions: 2
Size: 6
Data type: int64

... (more output)
```

**Challenge** (Optional):
- Create a function to calculate correlation between two arrays
- Implement a simple image filter using NumPy
- Create a function to normalize data (0-1 scale)
- Implement a moving average function
- Create a function to find outliers in data

---

## Key Takeaways

1. **NumPy** - Fundamental library for numerical computing
2. **Arrays** - Homogeneous, multi-dimensional data structures
3. **Performance** - Much faster than Python lists for numerical operations
4. **Vectorization** - Operations on entire arrays at once
5. **Shape** - Dimensions of array (rows, columns, etc.)
6. **Data types** - Arrays have specific data types (int, float, etc.)
7. **Operations** - Element-wise arithmetic and mathematical operations
8. **Functions** - Extensive library of mathematical and statistical functions
9. **Indexing** - Boolean indexing for filtering
10. **Reshaping** - Change array dimensions
11. **Memory** - More memory efficient than Python lists
12. **Foundation** - Base for Pandas, SciPy, and other libraries
13. **Best practices** - Vectorize operations, use appropriate types
14. **Common mistakes** - Shape vs size, copying arrays, type mismatches
15. **Applications** - Data science, scientific computing, image processing

---

## Quiz: NumPy

Test your understanding with these questions:

1. **What does NumPy stand for?**
   - A) Number Python
   - B) Numerical Python
   - C) Numeric Python
   - D) Numbers Python

2. **What is the standard import for NumPy?**
   - A) import numpy
   - B) import numpy as np
   - C) from numpy import *
   - D) import np

3. **What creates an array of zeros?**
   - A) np.zeros()
   - B) np.zero()
   - C) np.empty()
   - D) np.none()

4. **What returns the dimensions of an array?**
   - A) arr.shape
   - B) arr.ndim
   - C) arr.size
   - D) arr.dim

5. **What performs element-wise multiplication?**
   - A) np.dot()
   - B) arr1 * arr2
   - C) np.multiply()
   - D) Both B and C

6. **What calculates the mean of an array?**
   - A) arr.mean()
   - B) np.mean(arr)
   - C) np.average(arr)
   - D) All of the above

7. **What creates evenly spaced values?**
   - A) np.arange()
   - B) np.linspace()
   - C) np.range()
   - D) Both A and B

8. **What is the default data type for integers?**
   - A) int32
   - B) int64
   - C) int
   - D) integer

9. **What filters array elements?**
   - A) Boolean indexing
   - B) arr[mask]
   - C) arr[arr > 5]
   - D) All of the above

10. **What is faster for numerical operations?**
    - A) Python lists
    - B) NumPy arrays
    - C) Both are equal
    - D) Depends on the operation

**Answers**:
1. B) Numerical Python (NumPy full name)
2. B) import numpy as np (standard import)
3. A) np.zeros() (creates zeros)
4. B) arr.ndim (number of dimensions)
5. D) Both B and C (element-wise multiplication)
6. D) All of the above (all calculate mean)
7. D) Both A and B (both create sequences)
8. B) int64 (default integer type)
9. D) All of the above (boolean indexing methods)
10. B) NumPy arrays (much faster)

---

## Next Steps

Excellent work! You've mastered NumPy basics. You now understand:
- Creating arrays
- Array properties
- Basic operations
- How NumPy works

**What's Next?**
- Lesson 21.2: Array Operations
- Learn indexing and slicing
- Advanced array manipulation
- More mathematical operations

---

## Additional Resources

- **NumPy Documentation**: [numpy.org/doc/](https://numpy.org/doc/)
- **NumPy User Guide**: [numpy.org/doc/stable/user/index.html](https://numpy.org/doc/stable/user/index.html)
- **NumPy Tutorial**: [numpy.org/doc/stable/user/quickstart.html](https://numpy.org/doc/stable/user/quickstart.html)
- **NumPy Reference**: [numpy.org/doc/stable/reference/](https://numpy.org/doc/stable/reference/)

---

*Lesson completed! You're ready to move on to the next lesson.*

