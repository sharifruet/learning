# Lesson 23.1: Matplotlib

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what Matplotlib is and why it's important
- Install and import Matplotlib
- Create basic plots (line, bar, scatter)
- Customize plots (colors, labels, titles, legends)
- Work with subplots
- Save plots to files
- Understand plot customization options
- Create publication-quality visualizations
- Handle different plot types
- Apply Matplotlib best practices
- Debug plotting issues

---

## Introduction to Matplotlib

**Matplotlib** is a comprehensive library for creating static, animated, and interactive visualizations in Python. It's the foundation for many other visualization libraries.

**Key Features**:
- **Versatile**: Line plots, bar charts, scatter plots, histograms, and more
- **Customizable**: Extensive customization options
- **Publication-quality**: Create publication-ready figures
- **Integration**: Works with NumPy, Pandas, and other libraries
- **Multiple backends**: Support for different output formats

**Why Matplotlib?**
- Industry standard for Python visualization
- Highly customizable
- Works with scientific data
- Foundation for other libraries (Seaborn, Plotly)
- Extensive documentation and community support

---

## Installation

### Installing Matplotlib

```bash
# Install Matplotlib using pip
pip install matplotlib

# Install with conda (if using Anaconda)
conda install matplotlib

# Verify installation
python -c "import matplotlib; print(matplotlib.__version__)"
```

### Importing Matplotlib

```python
# Standard import
import matplotlib.pyplot as plt

# For inline plots in Jupyter
%matplotlib inline

# For interactive plots
%matplotlib notebook
```

---

## Creating Basic Plots

### Simple Line Plot

```python
import matplotlib.pyplot as plt
import numpy as np

# Create data
x = np.linspace(0, 10, 100)
y = np.sin(x)

# Create plot
plt.plot(x, y)
plt.show()
```

### Plot with Labels and Title

```python
import matplotlib.pyplot as plt
import numpy as np

x = np.linspace(0, 10, 100)
y = np.sin(x)

plt.plot(x, y)
plt.xlabel('X Axis')
plt.ylabel('Y Axis')
plt.title('Sine Wave')
plt.show()
```

### Multiple Lines

```python
import matplotlib.pyplot as plt
import numpy as np

x = np.linspace(0, 10, 100)
y1 = np.sin(x)
y2 = np.cos(x)

plt.plot(x, y1, label='sin(x)')
plt.plot(x, y2, label='cos(x)')
plt.xlabel('X Axis')
plt.ylabel('Y Axis')
plt.title('Trigonometric Functions')
plt.legend()
plt.show()
```

---

## Line Plots

### Basic Line Plot

```python
import matplotlib.pyplot as plt
import numpy as np

x = np.linspace(0, 10, 100)
y = x ** 2

plt.plot(x, y)
plt.show()
```

### Line Plot Customization

```python
import matplotlib.pyplot as plt
import numpy as np

x = np.linspace(0, 10, 100)
y = np.sin(x)

# Customize line
plt.plot(x, y, 
         color='red',           # Line color
         linestyle='--',        # Line style: '-', '--', '-.', ':'
         linewidth=2,           # Line width
         marker='o',            # Marker style
         markersize=5,         # Marker size
         label='sin(x)')
plt.legend()
plt.show()
```

### Line Styles and Markers

```python
import matplotlib.pyplot as plt
import numpy as np

x = np.linspace(0, 10, 20)

# Different line styles
plt.plot(x, x, 'r-', label='solid')      # Red solid line
plt.plot(x, x+1, 'g--', label='dashed')  # Green dashed line
plt.plot(x, x+2, 'b-.', label='dashdot')  # Blue dash-dot
plt.plot(x, x+3, 'm:', label='dotted')     # Magenta dotted

# Different markers
plt.plot(x, x+4, 'ro', label='circles')   # Red circles
plt.plot(x, x+5, 'gs', label='squares')   # Green squares
plt.plot(x, x+6, 'b^', label='triangles')  # Blue triangles

plt.legend()
plt.show()
```

---

## Bar Plots

### Basic Bar Plot

```python
import matplotlib.pyplot as plt

categories = ['A', 'B', 'C', 'D']
values = [10, 25, 15, 30]

plt.bar(categories, values)
plt.xlabel('Categories')
plt.ylabel('Values')
plt.title('Bar Chart')
plt.show()
```

### Horizontal Bar Plot

```python
import matplotlib.pyplot as plt

categories = ['A', 'B', 'C', 'D']
values = [10, 25, 15, 30]

plt.barh(categories, values)
plt.xlabel('Values')
plt.ylabel('Categories')
plt.title('Horizontal Bar Chart')
plt.show()
```

### Grouped Bar Plot

```python
import matplotlib.pyplot as plt
import numpy as np

categories = ['A', 'B', 'C', 'D']
values1 = [10, 25, 15, 30]
values2 = [15, 20, 25, 20]

x = np.arange(len(categories))
width = 0.35

plt.bar(x - width/2, values1, width, label='Group 1')
plt.bar(x + width/2, values2, width, label='Group 2')
plt.xlabel('Categories')
plt.ylabel('Values')
plt.title('Grouped Bar Chart')
plt.xticks(x, categories)
plt.legend()
plt.show()
```

### Stacked Bar Plot

```python
import matplotlib.pyplot as plt
import numpy as np

categories = ['A', 'B', 'C', 'D']
values1 = [10, 25, 15, 30]
values2 = [15, 20, 25, 20]

plt.bar(categories, values1, label='Group 1')
plt.bar(categories, values2, bottom=values1, label='Group 2')
plt.xlabel('Categories')
plt.ylabel('Values')
plt.title('Stacked Bar Chart')
plt.legend()
plt.show()
```

---

## Scatter Plots

### Basic Scatter Plot

```python
import matplotlib.pyplot as plt
import numpy as np

x = np.random.randn(100)
y = np.random.randn(100)

plt.scatter(x, y)
plt.xlabel('X')
plt.ylabel('Y')
plt.title('Scatter Plot')
plt.show()
```

### Scatter Plot Customization

```python
import matplotlib.pyplot as plt
import numpy as np

x = np.random.randn(100)
y = np.random.randn(100)
colors = np.random.rand(100)
sizes = 1000 * np.random.rand(100)

plt.scatter(x, y, 
            c=colors,        # Color array
            s=sizes,        # Size array
            alpha=0.5,      # Transparency
            cmap='viridis')  # Colormap
plt.colorbar()  # Add colorbar
plt.xlabel('X')
plt.ylabel('Y')
plt.title('Customized Scatter Plot')
plt.show()
```

### Scatter Plot with Different Markers

```python
import matplotlib.pyplot as plt
import numpy as np

x1 = np.random.randn(50)
y1 = np.random.randn(50)
x2 = np.random.randn(50)
y2 = np.random.randn(50)

plt.scatter(x1, y1, marker='o', label='Group 1')
plt.scatter(x2, y2, marker='s', label='Group 2')
plt.xlabel('X')
plt.ylabel('Y')
plt.title('Scatter Plot with Groups')
plt.legend()
plt.show()
```

---

## Customization

### Colors

```python
import matplotlib.pyplot as plt
import numpy as np

x = np.linspace(0, 10, 100)
y = np.sin(x)

# Named colors
plt.plot(x, y, color='red')
plt.plot(x, y+1, color='blue')
plt.plot(x, y+2, color='green')

# RGB tuples (0-1 range)
plt.plot(x, y+3, color=(0.5, 0.3, 0.8))

# Hex colors
plt.plot(x, y+4, color='#FF5733')

plt.show()
```

### Labels and Titles

```python
import matplotlib.pyplot as plt
import numpy as np

x = np.linspace(0, 10, 100)
y = np.sin(x)

plt.plot(x, y)
plt.xlabel('X Axis Label', fontsize=12, fontweight='bold')
plt.ylabel('Y Axis Label', fontsize=12)
plt.title('Plot Title', fontsize=14, fontweight='bold')
plt.show()
```

### Legends

```python
import matplotlib.pyplot as plt
import numpy as np

x = np.linspace(0, 10, 100)
y1 = np.sin(x)
y2 = np.cos(x)

plt.plot(x, y1, label='sin(x)')
plt.plot(x, y2, label='cos(x)')
plt.legend(loc='upper right', fontsize=10, frameon=True, shadow=True)
plt.show()
```

### Grid and Axes

```python
import matplotlib.pyplot as plt
import numpy as np

x = np.linspace(0, 10, 100)
y = np.sin(x)

plt.plot(x, y)
plt.grid(True, alpha=0.3, linestyle='--')
plt.xlim(0, 10)
plt.ylim(-1.5, 1.5)
plt.xticks([0, 2, 4, 6, 8, 10])
plt.yticks([-1, 0, 1])
plt.show()
```

### Figure Size and DPI

```python
import matplotlib.pyplot as plt
import numpy as np

x = np.linspace(0, 10, 100)
y = np.sin(x)

# Set figure size
plt.figure(figsize=(10, 6))  # Width, height in inches
plt.plot(x, y)
plt.show()

# Set DPI for higher resolution
plt.figure(figsize=(10, 6), dpi=300)
plt.plot(x, y)
plt.show()
```

### Style Sheets

```python
import matplotlib.pyplot as plt
import numpy as np

# Available styles
print(plt.style.available)

# Use a style
plt.style.use('seaborn-v0_8-darkgrid')

x = np.linspace(0, 10, 100)
y = np.sin(x)
plt.plot(x, y)
plt.show()

# Reset to default
plt.style.use('default')
```

---

## Subplots

### Creating Subplots

```python
import matplotlib.pyplot as plt
import numpy as np

x = np.linspace(0, 10, 100)

# Create 2x2 subplots
fig, axes = plt.subplots(2, 2, figsize=(10, 8))

axes[0, 0].plot(x, np.sin(x))
axes[0, 0].set_title('sin(x)')

axes[0, 1].plot(x, np.cos(x))
axes[0, 1].set_title('cos(x)')

axes[1, 0].plot(x, np.tan(x))
axes[1, 0].set_title('tan(x)')

axes[1, 1].plot(x, np.exp(-x))
axes[1, 1].set_title('exp(-x)')

plt.tight_layout()
plt.show()
```

### Subplot with Shared Axes

```python
import matplotlib.pyplot as plt
import numpy as np

x = np.linspace(0, 10, 100)

fig, axes = plt.subplots(2, 1, figsize=(8, 6), sharex=True)

axes[0].plot(x, np.sin(x))
axes[0].set_ylabel('sin(x)')
axes[0].set_title('Trigonometric Functions')

axes[1].plot(x, np.cos(x))
axes[1].set_xlabel('X')
axes[1].set_ylabel('cos(x)')

plt.tight_layout()
plt.show()
```

---

## Other Plot Types

### Histogram

```python
import matplotlib.pyplot as plt
import numpy as np

data = np.random.normal(100, 15, 1000)

plt.hist(data, bins=30, edgecolor='black', alpha=0.7)
plt.xlabel('Value')
plt.ylabel('Frequency')
plt.title('Histogram')
plt.show()
```

### Pie Chart

```python
import matplotlib.pyplot as plt

categories = ['A', 'B', 'C', 'D']
sizes = [15, 30, 45, 10]
colors = ['red', 'blue', 'green', 'yellow']

plt.pie(sizes, labels=categories, colors=colors, autopct='%1.1f%%')
plt.title('Pie Chart')
plt.show()
```

### Box Plot

```python
import matplotlib.pyplot as plt
import numpy as np

data = [np.random.normal(0, std, 100) for std in range(1, 4)]

plt.boxplot(data, labels=['Group 1', 'Group 2', 'Group 3'])
plt.ylabel('Value')
plt.title('Box Plot')
plt.show()
```

---

## Saving Plots

### Save to File

```python
import matplotlib.pyplot as plt
import numpy as np

x = np.linspace(0, 10, 100)
y = np.sin(x)

plt.plot(x, y)
plt.xlabel('X')
plt.ylabel('Y')
plt.title('Sine Wave')

# Save as PNG
plt.savefig('plot.png', dpi=300, bbox_inches='tight')

# Save as PDF
plt.savefig('plot.pdf', bbox_inches='tight')

# Save as SVG
plt.savefig('plot.svg', bbox_inches='tight')

plt.show()
```

---

## Working with Pandas Data

### Plotting from DataFrame

```python
import matplotlib.pyplot as plt
import pandas as pd
import numpy as np

# Create sample data
df = pd.DataFrame({
    'x': np.linspace(0, 10, 100),
    'y1': np.sin(np.linspace(0, 10, 100)),
    'y2': np.cos(np.linspace(0, 10, 100))
})

# Plot directly from DataFrame
df.plot(x='x', y='y1', label='sin(x)')
df.plot(x='x', y='y2', label='cos(x)')
plt.xlabel('X')
plt.ylabel('Y')
plt.title('Plot from DataFrame')
plt.legend()
plt.show()
```

### Plotting Multiple Columns

```python
import matplotlib.pyplot as plt
import pandas as pd
import numpy as np

df = pd.DataFrame({
    'A': np.random.randn(100),
    'B': np.random.randn(100),
    'C': np.random.randn(100)
})

df.plot(kind='line')
plt.title('Multiple Columns')
plt.show()
```

---

## Practical Examples

### Example 1: Time Series Plot

```python
import matplotlib.pyplot as plt
import pandas as pd
import numpy as np

# Create time series data
dates = pd.date_range('2023-01-01', periods=100, freq='D')
values = np.random.randn(100).cumsum()

plt.figure(figsize=(12, 6))
plt.plot(dates, values)
plt.xlabel('Date')
plt.ylabel('Value')
plt.title('Time Series Plot')
plt.xticks(rotation=45)
plt.grid(True, alpha=0.3)
plt.tight_layout()
plt.show()
```

### Example 2: Comparison Plot

```python
import matplotlib.pyplot as plt
import numpy as np

categories = ['Q1', 'Q2', 'Q3', 'Q4']
sales_2022 = [100, 120, 110, 130]
sales_2023 = [110, 125, 115, 140]

x = np.arange(len(categories))
width = 0.35

plt.bar(x - width/2, sales_2022, width, label='2022')
plt.bar(x + width/2, sales_2023, width, label='2023')
plt.xlabel('Quarter')
plt.ylabel('Sales')
plt.title('Sales Comparison')
plt.xticks(x, categories)
plt.legend()
plt.show()
```

---

## Common Mistakes and Pitfalls

### 1. Forgetting plt.show()

```python
# WRONG: Plot may not display
plt.plot([1, 2, 3, 4])
# Missing plt.show()

# CORRECT: Always call plt.show()
plt.plot([1, 2, 3, 4])
plt.show()
```

### 2. Not Clearing Figure

```python
# WRONG: Plots accumulate
for i in range(5):
    plt.plot([i, i+1, i+2])

# CORRECT: Clear figure or create new one
for i in range(5):
    plt.figure()
    plt.plot([i, i+1, i+2])
    plt.show()
```

### 3. Incorrect Subplot Indexing

```python
# WRONG: May cause IndexError
fig, axes = plt.subplots(2, 2)
axes[2, 0].plot([1, 2, 3])  # IndexError!

# CORRECT: Use correct indices
fig, axes = plt.subplots(2, 2)
axes[1, 0].plot([1, 2, 3])  # Correct
```

---

## Best Practices

### 1. Use Figure Objects

```python
# Good: Explicit figure management
fig, ax = plt.subplots(figsize=(10, 6))
ax.plot(x, y)
ax.set_xlabel('X')
ax.set_ylabel('Y')
ax.set_title('Title')
plt.show()
```

### 2. Consistent Style

```python
# Define style at the beginning
plt.style.use('seaborn-v0_8')
plt.rcParams['figure.figsize'] = (10, 6)
plt.rcParams['font.size'] = 12
```

### 3. Save High-Quality Figures

```python
# Save with high DPI for publications
plt.savefig('figure.png', dpi=300, bbox_inches='tight')
```

---

## Practice Exercise

### Exercise: Plotting

**Objective**: Create various types of plots with customization.

**Instructions**:

1. Create line plots with different styles
2. Create bar charts (vertical and horizontal)
3. Create scatter plots with customization
4. Create subplots
5. Customize colors, labels, legends
6. Save plots to files

**Example Solution**:

```python
"""
Matplotlib Plotting Exercise
This program demonstrates various plotting techniques.
"""

import matplotlib.pyplot as plt
import numpy as np
import pandas as pd

print("=" * 50)
print("Matplotlib Plotting Exercise")
print("=" * 50)

# Set style
plt.style.use('default')
plt.rcParams['figure.figsize'] = (10, 6)

# 1. Line Plot
print("\n1. Creating Line Plot:")
print("-" * 50)

x = np.linspace(0, 10, 100)
y1 = np.sin(x)
y2 = np.cos(x)

plt.figure(figsize=(10, 6))
plt.plot(x, y1, label='sin(x)', linewidth=2, color='blue')
plt.plot(x, y2, label='cos(x)', linewidth=2, color='red', linestyle='--')
plt.xlabel('X', fontsize=12)
plt.ylabel('Y', fontsize=12)
plt.title('Trigonometric Functions', fontsize=14, fontweight='bold')
plt.legend(fontsize=10)
plt.grid(True, alpha=0.3)
plt.tight_layout()
plt.savefig('line_plot.png', dpi=300, bbox_inches='tight')
print("Line plot saved as 'line_plot.png'")
plt.show()

# 2. Bar Chart
print("\n2. Creating Bar Chart:")
print("-" * 50)

categories = ['Product A', 'Product B', 'Product C', 'Product D']
sales = [150, 200, 175, 225]

plt.figure(figsize=(10, 6))
bars = plt.bar(categories, sales, color=['#FF6B6B', '#4ECDC4', '#45B7D1', '#FFA07A'])
plt.xlabel('Products', fontsize=12)
plt.ylabel('Sales', fontsize=12)
plt.title('Product Sales', fontsize=14, fontweight='bold')
plt.grid(True, alpha=0.3, axis='y')

# Add value labels on bars
for bar in bars:
    height = bar.get_height()
    plt.text(bar.get_x() + bar.get_width()/2., height,
             f'{int(height)}',
             ha='center', va='bottom')

plt.tight_layout()
plt.savefig('bar_chart.png', dpi=300, bbox_inches='tight')
print("Bar chart saved as 'bar_chart.png'")
plt.show()

# 3. Scatter Plot
print("\n3. Creating Scatter Plot:")
print("-" * 50)

np.random.seed(42)
x = np.random.randn(100)
y = np.random.randn(100)
colors = np.random.rand(100)
sizes = 1000 * np.random.rand(100)

plt.figure(figsize=(10, 6))
plt.scatter(x, y, c=colors, s=sizes, alpha=0.6, cmap='viridis')
plt.colorbar(label='Color Scale')
plt.xlabel('X', fontsize=12)
plt.ylabel('Y', fontsize=12)
plt.title('Scatter Plot with Color and Size', fontsize=14, fontweight='bold')
plt.grid(True, alpha=0.3)
plt.tight_layout()
plt.savefig('scatter_plot.png', dpi=300, bbox_inches='tight')
print("Scatter plot saved as 'scatter_plot.png'")
plt.show()

# 4. Subplots
print("\n4. Creating Subplots:")
print("-" * 50)

x = np.linspace(0, 10, 100)

fig, axes = plt.subplots(2, 2, figsize=(12, 10))

# Subplot 1: Line plot
axes[0, 0].plot(x, np.sin(x), color='blue')
axes[0, 0].set_title('sin(x)', fontweight='bold')
axes[0, 0].set_xlabel('X')
axes[0, 0].set_ylabel('Y')
axes[0, 0].grid(True, alpha=0.3)

# Subplot 2: Line plot
axes[0, 1].plot(x, np.cos(x), color='red')
axes[0, 1].set_title('cos(x)', fontweight='bold')
axes[0, 1].set_xlabel('X')
axes[0, 1].set_ylabel('Y')
axes[0, 1].grid(True, alpha=0.3)

# Subplot 3: Bar chart
categories = ['A', 'B', 'C']
values = [10, 20, 15]
axes[1, 0].bar(categories, values, color=['#FF6B6B', '#4ECDC4', '#45B7D1'])
axes[1, 0].set_title('Bar Chart', fontweight='bold')
axes[1, 0].set_xlabel('Category')
axes[1, 0].set_ylabel('Value')
axes[1, 0].grid(True, alpha=0.3, axis='y')

# Subplot 4: Histogram
data = np.random.normal(100, 15, 1000)
axes[1, 1].hist(data, bins=30, edgecolor='black', alpha=0.7, color='green')
axes[1, 1].set_title('Histogram', fontweight='bold')
axes[1, 1].set_xlabel('Value')
axes[1, 1].set_ylabel('Frequency')
axes[1, 1].grid(True, alpha=0.3, axis='y')

plt.suptitle('Multiple Subplots', fontsize=16, fontweight='bold', y=0.995)
plt.tight_layout()
plt.savefig('subplots.png', dpi=300, bbox_inches='tight')
print("Subplots saved as 'subplots.png'")
plt.show()

# 5. Grouped Bar Chart
print("\n5. Creating Grouped Bar Chart:")
print("-" * 50)

categories = ['Q1', 'Q2', 'Q3', 'Q4']
sales_2022 = [100, 120, 110, 130]
sales_2023 = [110, 125, 115, 140]

x = np.arange(len(categories))
width = 0.35

plt.figure(figsize=(10, 6))
bars1 = plt.bar(x - width/2, sales_2022, width, label='2022', color='#FF6B6B')
bars2 = plt.bar(x + width/2, sales_2023, width, label='2023', color='#4ECDC4')

plt.xlabel('Quarter', fontsize=12)
plt.ylabel('Sales', fontsize=12)
plt.title('Sales Comparison by Quarter', fontsize=14, fontweight='bold')
plt.xticks(x, categories)
plt.legend(fontsize=10)
plt.grid(True, alpha=0.3, axis='y')

# Add value labels
for bars in [bars1, bars2]:
    for bar in bars:
        height = bar.get_height()
        plt.text(bar.get_x() + bar.get_width()/2., height,
                 f'{int(height)}',
                 ha='center', va='bottom', fontsize=9)

plt.tight_layout()
plt.savefig('grouped_bar.png', dpi=300, bbox_inches='tight')
print("Grouped bar chart saved as 'grouped_bar.png'")
plt.show()

print("\n" + "=" * 50)
print("Exercise completed!")
print("=" * 50)
```

**Expected Output**: Creates and saves various types of plots with customization.

**Challenge** (Optional):
- Create interactive plots
- Add annotations to plots
- Create 3D plots
- Create animated plots
- Integrate with real data

---

## Key Takeaways

1. **Matplotlib** - Powerful plotting library for Python
2. **Basic plots** - Line, bar, scatter plots
3. **Customization** - Colors, labels, titles, legends, grids
4. **Subplots** - Multiple plots in one figure
5. **Line plots** - For continuous data
6. **Bar charts** - For categorical data
7. **Scatter plots** - For relationships between variables
8. **Saving plots** - Save to PNG, PDF, SVG
9. **Pandas integration** - Plot directly from DataFrames
10. **Style sheets** - Use predefined styles
11. **Figure management** - Use figure objects for better control
12. **Best practices** - Consistent style, high DPI for publications
13. **Common mistakes** - Forgetting plt.show(), not clearing figures
14. **Customization options** - Extensive customization available
15. **Publication quality** - Create professional visualizations

---

## Quiz: Matplotlib

Test your understanding with these questions:

1. **What is the standard import for Matplotlib?**
   - A) import matplotlib
   - B) import matplotlib.pyplot as plt
   - C) from matplotlib import *
   - D) import plt

2. **What creates a line plot?**
   - A) plt.line()
   - B) plt.plot()
   - C) plt.draw()
   - D) plt.show()

3. **What adds a legend?**
   - A) plt.legend()
   - B) plt.label()
   - C) plt.key()
   - D) plt.notes()

4. **What creates subplots?**
   - A) plt.subplot()
   - B) plt.subplots()
   - C) plt.multiplot()
   - D) plt.split()

5. **What saves a plot?**
   - A) plt.save()
   - B) plt.savefig()
   - C) plt.export()
   - D) plt.write()

6. **What sets figure size?**
   - A) plt.size()
   - B) plt.figsize()
   - C) plt.figure(figsize=())
   - D) plt.set_size()

7. **What creates a bar chart?**
   - A) plt.bar()
   - B) plt.barh()
   - C) plt.barchart()
   - D) Both A and B

8. **What creates a scatter plot?**
   - A) plt.scatter()
   - B) plt.points()
   - C) plt.dot()
   - D) plt.plot(kind='scatter')

9. **What displays the plot?**
   - A) plt.display()
   - B) plt.show()
   - C) plt.render()
   - D) plt.draw()

10. **What adds grid to plot?**
    - A) plt.grid()
    - B) plt.show_grid()
    - C) plt.add_grid()
    - D) plt.set_grid()

**Answers**:
1. B) import matplotlib.pyplot as plt (standard import)
2. B) plt.plot() (line plot function)
3. A) plt.legend() (add legend)
4. B) plt.subplots() (create subplots)
5. B) plt.savefig() (save figure)
6. C) plt.figure(figsize=()) (set figure size)
7. D) Both A and B (bar and barh)
8. A) plt.scatter() (scatter plot)
9. B) plt.show() (display plot)
10. A) plt.grid() (add grid)

---

## Next Steps

Excellent work! You've mastered Matplotlib basics. You now understand:
- Creating plots
- Line, bar, scatter plots
- Customization
- How to visualize data

**What's Next?**
- Lesson 23.2: Seaborn
- Learn statistical visualization
- Advanced plotting techniques
- More visualization options

---

## Additional Resources

- **Matplotlib Documentation**: [matplotlib.org/](https://matplotlib.org/)
- **Matplotlib Tutorials**: [matplotlib.org/stable/tutorials/index.html](https://matplotlib.org/stable/tutorials/index.html)
- **Matplotlib Gallery**: [matplotlib.org/stable/gallery/index.html](https://matplotlib.org/stable/gallery/index.html)
- **Pyplot Tutorial**: [matplotlib.org/stable/tutorials/introductory/pyplot.html](https://matplotlib.org/stable/tutorials/introductory/pyplot.html)

---

*Lesson completed! You're ready to move on to the next lesson.*

