# Lesson 23.2: Seaborn

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what Seaborn is and its advantages
- Install and import Seaborn
- Create statistical visualizations
- Use advanced plot types
- Apply Seaborn styling
- Work with categorical plots
- Create distribution plots
- Build relationship plots
- Use Seaborn with Pandas DataFrames
- Customize Seaborn plots
- Apply statistical analysis in visualizations
- Build publication-quality statistical plots
- Debug Seaborn-related issues

---

## Introduction to Seaborn

**Seaborn** is a Python data visualization library based on Matplotlib. It provides a high-level interface for drawing attractive and informative statistical graphics.

**Key Features**:
- **Statistical plots**: Built-in support for statistical analysis
- **Beautiful defaults**: Attractive default styles and color palettes
- **Easy integration**: Works seamlessly with Pandas DataFrames
- **Advanced plots**: Heatmaps, violin plots, pair plots, and more
- **Automatic estimation**: Automatic statistical estimation and visualization

**Why Seaborn?**
- Simpler syntax than Matplotlib
- Beautiful default styles
- Statistical functionality built-in
- Better for exploratory data analysis
- Works great with Pandas

---

## Installation

### Installing Seaborn

```bash
# Install Seaborn using pip
pip install seaborn

# Install with conda (if using Anaconda)
conda install seaborn

# Verify installation
python -c "import seaborn; print(seaborn.__version__)"
```

### Importing Seaborn

```python
# Standard import
import seaborn as sns
import matplotlib.pyplot as plt

# Set style (optional)
sns.set_style("whitegrid")
```

---

## Statistical Visualization

### Distribution Plots

```python
import seaborn as sns
import matplotlib.pyplot as plt
import numpy as np

# Generate sample data
data = np.random.normal(100, 15, 1000)

# Histogram with KDE
sns.histplot(data, kde=True)
plt.title('Distribution with KDE')
plt.show()

# Density plot (KDE)
sns.kdeplot(data, fill=True)
plt.title('Kernel Density Estimation')
plt.show()

# Distribution plot (histogram + KDE)
sns.distplot(data, kde=True, hist=True)
plt.title('Distribution Plot')
plt.show()
```

### Comparing Distributions

```python
import seaborn as sns
import matplotlib.pyplot as plt
import numpy as np
import pandas as pd

# Create sample data
data = pd.DataFrame({
    'Group A': np.random.normal(100, 15, 1000),
    'Group B': np.random.normal(110, 15, 1000),
    'Group C': np.random.normal(105, 15, 1000)
})

# Multiple distributions
sns.histplot(data, kde=True, alpha=0.7)
plt.title('Comparing Multiple Distributions')
plt.show()
```

---

## Advanced Plots

### Heatmaps

```python
import seaborn as sns
import matplotlib.pyplot as plt
import numpy as np
import pandas as pd

# Create correlation matrix
data = np.random.randn(10, 10)
corr_matrix = np.corrcoef(data)

# Basic heatmap
sns.heatmap(corr_matrix, annot=True, cmap='coolwarm')
plt.title('Correlation Heatmap')
plt.show()

# Heatmap with custom settings
sns.heatmap(corr_matrix, 
            annot=True,           # Show values
            fmt='.2f',           # Format
            cmap='viridis',       # Colormap
            vmin=-1, vmax=1,      # Value range
            center=0,             # Center colormap
            square=True,          # Square cells
            linewidths=0.5)       # Line width
plt.title('Customized Heatmap')
plt.show()
```

### Violin Plots

```python
import seaborn as sns
import matplotlib.pyplot as plt
import numpy as np
import pandas as pd

# Create sample data
data = pd.DataFrame({
    'Category': ['A'] * 100 + ['B'] * 100 + ['C'] * 100,
    'Value': np.concatenate([
        np.random.normal(100, 15, 100),
        np.random.normal(110, 15, 100),
        np.random.normal(105, 15, 100)
    ])
})

# Violin plot
sns.violinplot(x='Category', y='Value', data=data)
plt.title('Violin Plot')
plt.show()

# Violin plot with split
sns.violinplot(x='Category', y='Value', data=data, split=True)
plt.title('Split Violin Plot')
plt.show()
```

### Box Plots

```python
import seaborn as sns
import matplotlib.pyplot as plt
import numpy as np
import pandas as pd

# Create sample data
data = pd.DataFrame({
    'Category': ['A'] * 100 + ['B'] * 100 + ['C'] * 100,
    'Value': np.concatenate([
        np.random.normal(100, 15, 100),
        np.random.normal(110, 15, 100),
        np.random.normal(105, 15, 100)
    ])
})

# Box plot
sns.boxplot(x='Category', y='Value', data=data)
plt.title('Box Plot')
plt.show()

# Box plot with hue
data['Group'] = ['X'] * 150 + ['Y'] * 150
sns.boxplot(x='Category', y='Value', hue='Group', data=data)
plt.title('Box Plot with Hue')
plt.show()
```

### Pair Plots

```python
import seaborn as sns
import matplotlib.pyplot as plt
import pandas as pd
import numpy as np

# Create sample data
data = pd.DataFrame({
    'x': np.random.randn(100),
    'y': np.random.randn(100),
    'z': np.random.randn(100),
    'category': np.random.choice(['A', 'B', 'C'], 100)
})

# Pair plot
sns.pairplot(data)
plt.show()

# Pair plot with hue
sns.pairplot(data, hue='category')
plt.show()

# Pair plot with custom settings
sns.pairplot(data, 
             hue='category',
             diag_kind='kde',    # KDE for diagonal
             plot_kws={'alpha': 0.6})
plt.show()
```

### Joint Plots

```python
import seaborn as sns
import matplotlib.pyplot as plt
import numpy as np

x = np.random.randn(100)
y = x + np.random.randn(100) * 0.5

# Joint plot
sns.jointplot(x=x, y=y, kind='scatter')
plt.show()

# Joint plot with regression
sns.jointplot(x=x, y=y, kind='reg')
plt.show()

# Joint plot with hexbin
sns.jointplot(x=x, y=y, kind='hex')
plt.show()

# Joint plot with KDE
sns.jointplot(x=x, y=y, kind='kde')
plt.show()
```

### Facet Grids

```python
import seaborn as sns
import matplotlib.pyplot as plt
import pandas as pd
import numpy as np

# Create sample data
data = pd.DataFrame({
    'x': np.random.randn(200),
    'y': np.random.randn(200),
    'category': np.random.choice(['A', 'B'], 200),
    'group': np.random.choice(['X', 'Y'], 200)
})

# Facet grid
g = sns.FacetGrid(data, col='category', row='group')
g.map(plt.scatter, 'x', 'y')
plt.show()

# Facet grid with regression
g = sns.FacetGrid(data, col='category')
g.map(sns.regplot, 'x', 'y')
plt.show()
```

---

## Categorical Plots

### Bar Plots

```python
import seaborn as sns
import matplotlib.pyplot as plt
import pandas as pd

data = pd.DataFrame({
    'category': ['A', 'B', 'C', 'D'],
    'value': [10, 25, 15, 30]
})

# Bar plot
sns.barplot(x='category', y='value', data=data)
plt.title('Bar Plot')
plt.show()

# Bar plot with confidence intervals
sns.barplot(x='category', y='value', data=data, ci=95)
plt.title('Bar Plot with CI')
plt.show()
```

### Count Plots

```python
import seaborn as sns
import matplotlib.pyplot as plt
import pandas as pd
import numpy as np

# Create sample data
data = pd.DataFrame({
    'category': np.random.choice(['A', 'B', 'C', 'D'], 100)
})

# Count plot
sns.countplot(x='category', data=data)
plt.title('Count Plot')
plt.show()
```

### Point Plots

```python
import seaborn as sns
import matplotlib.pyplot as plt
import pandas as pd
import numpy as np

# Create sample data
data = pd.DataFrame({
    'category': ['A', 'B', 'C'] * 50,
    'value': np.random.randn(150),
    'group': ['X', 'Y'] * 75
})

# Point plot
sns.pointplot(x='category', y='value', data=data)
plt.title('Point Plot')
plt.show()

# Point plot with hue
sns.pointplot(x='category', y='value', hue='group', data=data)
plt.title('Point Plot with Hue')
plt.show()
```

---

## Relationship Plots

### Scatter Plots

```python
import seaborn as sns
import matplotlib.pyplot as plt
import pandas as pd
import numpy as np

# Create sample data
data = pd.DataFrame({
    'x': np.random.randn(100),
    'y': np.random.randn(100),
    'category': np.random.choice(['A', 'B', 'C'], 100)
})

# Scatter plot
sns.scatterplot(x='x', y='y', data=data)
plt.title('Scatter Plot')
plt.show()

# Scatter plot with hue
sns.scatterplot(x='x', y='y', hue='category', data=data)
plt.title('Scatter Plot with Hue')
plt.show()

# Scatter plot with size
sns.scatterplot(x='x', y='y', size='category', data=data)
plt.title('Scatter Plot with Size')
plt.show()
```

### Line Plots

```python
import seaborn as sns
import matplotlib.pyplot as plt
import pandas as pd
import numpy as np

# Create sample data
data = pd.DataFrame({
    'x': np.linspace(0, 10, 100),
    'y': np.sin(np.linspace(0, 10, 100)),
    'category': ['A'] * 100
})

# Line plot
sns.lineplot(x='x', y='y', data=data)
plt.title('Line Plot')
plt.show()

# Line plot with confidence interval
sns.lineplot(x='x', y='y', data=data, ci=95)
plt.title('Line Plot with CI')
plt.show()
```

### Regression Plots

```python
import seaborn as sns
import matplotlib.pyplot as plt
import numpy as np

x = np.random.randn(100)
y = x + np.random.randn(100) * 0.5

# Regression plot
sns.regplot(x=x, y=y)
plt.title('Regression Plot')
plt.show()

# Regression plot with polynomial
sns.regplot(x=x, y=y, order=2)
plt.title('Polynomial Regression')
plt.show()

# Regression plot with robust regression
sns.regplot(x=x, y=y, robust=True)
plt.title('Robust Regression')
plt.show()
```

---

## Styling

### Setting Styles

```python
import seaborn as sns
import matplotlib.pyplot as plt

# Available styles
print(sns.style.available)
# ['darkgrid', 'whitegrid', 'dark', 'white', 'ticks']

# Set style
sns.set_style("whitegrid")

# Set context (affects scale)
sns.set_context("paper")  # paper, notebook, talk, poster

# Reset to default
sns.set_style("whitegrid")
sns.set_context("notebook")
```

### Color Palettes

```python
import seaborn as sns
import matplotlib.pyplot as plt

# View color palettes
sns.color_palette("husl", 8)

# Set palette
sns.set_palette("husl")

# Use specific palette
palette = sns.color_palette("husl", 8)
sns.set_palette(palette)

# Diverging palette
sns.color_palette("RdBu_r", 10)

# Sequential palette
sns.color_palette("Blues", 10)

# Categorical palette
sns.color_palette("Set2", 10)
```

### Customizing Plots

```python
import seaborn as sns
import matplotlib.pyplot as plt
import pandas as pd
import numpy as np

# Set style
sns.set_style("whitegrid")
sns.set_palette("husl")

# Create plot with custom settings
data = pd.DataFrame({
    'x': np.random.randn(100),
    'y': np.random.randn(100)
})

sns.scatterplot(x='x', y='y', data=data,
                s=100,           # Size
                alpha=0.6,      # Transparency
                edgecolor='black',  # Edge color
                linewidth=1)     # Edge width
plt.title('Customized Scatter Plot', fontsize=14, fontweight='bold')
plt.xlabel('X', fontsize=12)
plt.ylabel('Y', fontsize=12)
plt.show()
```

---

## Working with Pandas DataFrames

### Direct DataFrame Plotting

```python
import seaborn as sns
import matplotlib.pyplot as plt
import pandas as pd
import numpy as np

# Create DataFrame
df = pd.DataFrame({
    'x': np.random.randn(100),
    'y': np.random.randn(100),
    'category': np.random.choice(['A', 'B', 'C'], 100),
    'value': np.random.randn(100)
})

# Plot directly from DataFrame
sns.scatterplot(data=df, x='x', y='y', hue='category')
plt.show()

# Box plot from DataFrame
sns.boxplot(data=df, x='category', y='value')
plt.show()
```

### Loading Built-in Datasets

```python
import seaborn as sns
import matplotlib.pyplot as plt

# Load built-in datasets
tips = sns.load_dataset("tips")
flights = sns.load_dataset("flights")
iris = sns.load_dataset("iris")

# Explore tips dataset
print(tips.head())

# Create plots
sns.scatterplot(data=tips, x='total_bill', y='tip', hue='smoker')
plt.show()

# Box plot
sns.boxplot(data=tips, x='day', y='total_bill', hue='smoker')
plt.show()
```

---

## Practical Examples

### Example 1: Correlation Analysis

```python
import seaborn as sns
import matplotlib.pyplot as plt
import pandas as pd
import numpy as np

# Create sample data
data = pd.DataFrame({
    'A': np.random.randn(100),
    'B': np.random.randn(100),
    'C': np.random.randn(100),
    'D': np.random.randn(100)
})

# Calculate correlation
corr = data.corr()

# Create heatmap
plt.figure(figsize=(10, 8))
sns.heatmap(corr, annot=True, cmap='coolwarm', center=0,
            square=True, linewidths=0.5, cbar_kws={"shrink": 0.8})
plt.title('Correlation Matrix', fontsize=14, fontweight='bold')
plt.tight_layout()
plt.show()
```

### Example 2: Multi-Variable Analysis

```python
import seaborn as sns
import matplotlib.pyplot as plt
import pandas as pd
import numpy as np

# Load tips dataset
tips = sns.load_dataset("tips")

# Create multiple plots
fig, axes = plt.subplots(2, 2, figsize=(12, 10))

# Scatter plot
sns.scatterplot(data=tips, x='total_bill', y='tip', hue='smoker', ax=axes[0, 0])
axes[0, 0].set_title('Total Bill vs Tip')

# Box plot
sns.boxplot(data=tips, x='day', y='total_bill', ax=axes[0, 1])
axes[0, 1].set_title('Total Bill by Day')

# Violin plot
sns.violinplot(data=tips, x='time', y='tip', ax=axes[1, 0])
axes[1, 0].set_title('Tip Distribution by Time')

# Bar plot
sns.barplot(data=tips, x='day', y='tip', ax=axes[1, 1])
axes[1, 1].set_title('Average Tip by Day')

plt.tight_layout()
plt.show()
```

### Example 3: Distribution Comparison

```python
import seaborn as sns
import matplotlib.pyplot as plt
import pandas as pd
import numpy as np

# Create sample data
data = pd.DataFrame({
    'Group': ['A'] * 100 + ['B'] * 100 + ['C'] * 100,
    'Value': np.concatenate([
        np.random.normal(100, 15, 100),
        np.random.normal(110, 15, 100),
        np.random.normal(105, 15, 100)
    ])
})

# Create violin plot
plt.figure(figsize=(10, 6))
sns.violinplot(data=data, x='Group', y='Value', inner='box')
plt.title('Distribution Comparison', fontsize=14, fontweight='bold')
plt.ylabel('Value', fontsize=12)
plt.xlabel('Group', fontsize=12)
plt.tight_layout()
plt.show()
```

---

## Common Mistakes and Pitfalls

### 1. Not Setting Style

```python
# WRONG: May not look good
sns.scatterplot(x=x, y=y)

# CORRECT: Set style first
sns.set_style("whitegrid")
sns.scatterplot(x=x, y=y)
```

### 2. Forgetting to Show Plot

```python
# WRONG: Plot may not display
sns.scatterplot(x=x, y=y)
# Missing plt.show()

# CORRECT: Always show plot
sns.scatterplot(x=x, y=y)
plt.show()
```

### 3. Incorrect Data Format

```python
# WRONG: Wrong data format
sns.scatterplot(x=[1, 2, 3], y=[4, 5, 6], hue=[1, 2, 3])

# CORRECT: Use DataFrame
df = pd.DataFrame({'x': [1, 2, 3], 'y': [4, 5, 6], 'hue': [1, 2, 3]})
sns.scatterplot(data=df, x='x', y='y', hue='hue')
```

---

## Best Practices

### 1. Use DataFrames

```python
# Good: Use DataFrame
df = pd.DataFrame({'x': x, 'y': y, 'category': cat})
sns.scatterplot(data=df, x='x', y='y', hue='category')

# Better than passing arrays separately
```

### 2. Set Style Early

```python
# Set style at the beginning
sns.set_style("whitegrid")
sns.set_palette("husl")
sns.set_context("notebook")
```

### 3. Use Appropriate Plot Types

```python
# Use violin plots for distributions
# Use heatmaps for correlations
# Use pair plots for multiple variables
# Use regression plots for relationships
```

---

## Practice Exercise

### Exercise: Seaborn

**Objective**: Create various statistical visualizations using Seaborn.

**Instructions**:

1. Load or create sample data
2. Create distribution plots
3. Create relationship plots
4. Create categorical plots
5. Create heatmaps
6. Apply styling and customization

**Example Solution**:

```python
"""
Seaborn Visualization Exercise
This program demonstrates various Seaborn plotting techniques.
"""

import seaborn as sns
import matplotlib.pyplot as plt
import pandas as pd
import numpy as np

print("=" * 50)
print("Seaborn Visualization Exercise")
print("=" * 50)

# Set style
sns.set_style("whitegrid")
sns.set_palette("husl")
sns.set_context("notebook")

# 1. Load built-in dataset
print("\n1. Loading Tips Dataset:")
print("-" * 50)

tips = sns.load_dataset("tips")
print(f"Dataset shape: {tips.shape}")
print(f"\nFirst few rows:")
print(tips.head())

# 2. Distribution Plot
print("\n2. Creating Distribution Plot:")
print("-" * 50)

plt.figure(figsize=(10, 6))
sns.histplot(data=tips, x='total_bill', kde=True, bins=30)
plt.title('Distribution of Total Bill', fontsize=14, fontweight='bold')
plt.xlabel('Total Bill ($)', fontsize=12)
plt.ylabel('Frequency', fontsize=12)
plt.tight_layout()
plt.savefig('distribution_plot.png', dpi=300, bbox_inches='tight')
print("Distribution plot saved as 'distribution_plot.png'")
plt.show()

# 3. Scatter Plot with Regression
print("\n3. Creating Scatter Plot with Regression:")
print("-" * 50)

plt.figure(figsize=(10, 6))
sns.regplot(data=tips, x='total_bill', y='tip', scatter_kws={'alpha': 0.6})
plt.title('Total Bill vs Tip with Regression Line', fontsize=14, fontweight='bold')
plt.xlabel('Total Bill ($)', fontsize=12)
plt.ylabel('Tip ($)', fontsize=12)
plt.tight_layout()
plt.savefig('regression_plot.png', dpi=300, bbox_inches='tight')
print("Regression plot saved as 'regression_plot.png'")
plt.show()

# 4. Box Plot
print("\n4. Creating Box Plot:")
print("-" * 50)

plt.figure(figsize=(10, 6))
sns.boxplot(data=tips, x='day', y='total_bill', hue='smoker')
plt.title('Total Bill by Day and Smoking Status', fontsize=14, fontweight='bold')
plt.xlabel('Day', fontsize=12)
plt.ylabel('Total Bill ($)', fontsize=12)
plt.legend(title='Smoker', fontsize=10)
plt.tight_layout()
plt.savefig('box_plot.png', dpi=300, bbox_inches='tight')
print("Box plot saved as 'box_plot.png'")
plt.show()

# 5. Violin Plot
print("\n5. Creating Violin Plot:")
print("-" * 50)

plt.figure(figsize=(10, 6))
sns.violinplot(data=tips, x='time', y='tip', inner='box')
plt.title('Tip Distribution by Time', fontsize=14, fontweight='bold')
plt.xlabel('Time', fontsize=12)
plt.ylabel('Tip ($)', fontsize=12)
plt.tight_layout()
plt.savefig('violin_plot.png', dpi=300, bbox_inches='tight')
print("Violin plot saved as 'violin_plot.png'")
plt.show()

# 6. Heatmap
print("\n6. Creating Heatmap:")
print("-" * 50)

# Create pivot table for heatmap
flights = sns.load_dataset("flights")
flights_pivot = flights.pivot_table(values='passengers', index='month', columns='year')

plt.figure(figsize=(12, 8))
sns.heatmap(flights_pivot, annot=True, fmt='d', cmap='YlOrRd', linewidths=0.5)
plt.title('Passengers by Month and Year', fontsize=14, fontweight='bold')
plt.xlabel('Year', fontsize=12)
plt.ylabel('Month', fontsize=12)
plt.tight_layout()
plt.savefig('heatmap.png', dpi=300, bbox_inches='tight')
print("Heatmap saved as 'heatmap.png'")
plt.show()

# 7. Pair Plot
print("\n7. Creating Pair Plot:")
print("-" * 50)

iris = sns.load_dataset("iris")
g = sns.pairplot(iris, hue='species', diag_kind='kde', plot_kws={'alpha': 0.7})
g.fig.suptitle('Iris Dataset Pair Plot', fontsize=14, fontweight='bold', y=1.02)
plt.savefig('pair_plot.png', dpi=300, bbox_inches='tight')
print("Pair plot saved as 'pair_plot.png'")
plt.show()

# 8. Joint Plot
print("\n8. Creating Joint Plot:")
print("-" * 50)

plt.figure(figsize=(10, 8))
sns.jointplot(data=tips, x='total_bill', y='tip', kind='reg', height=8)
plt.suptitle('Total Bill vs Tip with Regression', fontsize=14, fontweight='bold', y=1.02)
plt.savefig('joint_plot.png', dpi=300, bbox_inches='tight')
print("Joint plot saved as 'joint_plot.png'")
plt.show()

# 9. Facet Grid
print("\n9. Creating Facet Grid:")
print("-" * 50)

g = sns.FacetGrid(tips, col='time', row='smoker', height=4, aspect=1.2)
g.map(sns.scatterplot, 'total_bill', 'tip', alpha=0.6)
g.add_legend()
g.fig.suptitle('Total Bill vs Tip by Time and Smoking Status', 
                fontsize=14, fontweight='bold', y=1.02)
plt.savefig('facet_grid.png', dpi=300, bbox_inches='tight')
print("Facet grid saved as 'facet_grid.png'")
plt.show()

# 10. Multiple Subplots
print("\n10. Creating Multiple Subplots:")
print("-" * 50)

fig, axes = plt.subplots(2, 2, figsize=(14, 10))

# Scatter plot
sns.scatterplot(data=tips, x='total_bill', y='tip', hue='smoker', ax=axes[0, 0])
axes[0, 0].set_title('Total Bill vs Tip')

# Bar plot
sns.barplot(data=tips, x='day', y='tip', ax=axes[0, 1])
axes[0, 1].set_title('Average Tip by Day')

# Box plot
sns.boxplot(data=tips, x='time', y='total_bill', ax=axes[1, 0])
axes[1, 0].set_title('Total Bill by Time')

# Count plot
sns.countplot(data=tips, x='day', hue='smoker', ax=axes[1, 1])
axes[1, 1].set_title('Count by Day and Smoking Status')

plt.suptitle('Multiple Statistical Visualizations', fontsize=16, fontweight='bold')
plt.tight_layout()
plt.savefig('multiple_plots.png', dpi=300, bbox_inches='tight')
print("Multiple plots saved as 'multiple_plots.png'")
plt.show()

print("\n" + "=" * 50)
print("Exercise completed!")
print("=" * 50)
```

**Expected Output**: Creates and saves various statistical visualizations using Seaborn.

**Challenge** (Optional):
- Create custom color palettes
- Add statistical annotations
- Create interactive plots
- Integrate with real datasets
- Create publication-quality figures

---

## Key Takeaways

1. **Seaborn** - High-level statistical visualization library
2. **Statistical plots** - Built-in statistical functionality
3. **Distribution plots** - Histograms, KDE, distribution plots
4. **Advanced plots** - Heatmaps, violin plots, pair plots, joint plots
5. **Categorical plots** - Bar plots, count plots, point plots
6. **Relationship plots** - Scatter plots, line plots, regression plots
7. **Styling** - Beautiful default styles and color palettes
8. **DataFrames** - Works seamlessly with Pandas
9. **Built-in datasets** - Load sample datasets for practice
10. **Facet grids** - Create multiple plots easily
11. **Customization** - Extensive customization options
12. **Best practices** - Use DataFrames, set style early
13. **Common mistakes** - Not setting style, forgetting plt.show()
14. **Statistical analysis** - Automatic estimation and visualization
15. **Publication quality** - Create professional statistical plots

---

## Quiz: Seaborn

Test your understanding with these questions:

1. **What is the standard import for Seaborn?**
   - A) import seaborn
   - B) import seaborn as sns
   - C) from seaborn import *
   - D) import sns

2. **What creates a distribution plot?**
   - A) sns.distplot()
   - B) sns.histplot()
   - C) sns.kdeplot()
   - D) All of the above

3. **What creates a heatmap?**
   - A) sns.heatmap()
   - B) sns.map()
   - C) sns.colorplot()
   - D) sns.grid()

4. **What creates a violin plot?**
   - A) sns.violinplot()
   - B) sns.violin()
   - C) sns.distribution()
   - D) sns.violin()

5. **What creates a pair plot?**
   - A) sns.pairplot()
   - B) sns.pairs()
   - C) sns.multiplot()
   - D) sns.gridplot()

6. **What sets the style?**
   - A) sns.set_style()
   - B) sns.style()
   - C) sns.set()
   - D) sns.config()

7. **What creates a regression plot?**
   - A) sns.regplot()
   - B) sns.regression()
   - C) sns.lineplot()
   - D) sns.fit()

8. **What loads built-in datasets?**
   - A) sns.load_dataset()
   - B) sns.dataset()
   - C) sns.get_data()
   - D) sns.load()

9. **What creates a joint plot?**
   - A) sns.jointplot()
   - B) sns.joint()
   - C) sns.combined()
   - D) sns.dual()

10. **What creates a facet grid?**
    - A) sns.FacetGrid()
    - B) sns.facet()
    - C) sns.grid()
    - D) sns.multi()

**Answers**:
1. B) import seaborn as sns (standard import)
2. D) All of the above (distribution plot methods)
3. A) sns.heatmap() (heatmap function)
4. A) sns.violinplot() (violin plot)
5. A) sns.pairplot() (pair plot)
6. A) sns.set_style() (set style)
7. A) sns.regplot() (regression plot)
8. A) sns.load_dataset() (load dataset)
9. A) sns.jointplot() (joint plot)
10. A) sns.FacetGrid() (facet grid)

---

## Next Steps

Excellent work! You've mastered Seaborn. You now understand:
- Statistical visualization
- Advanced plots
- Styling
- How to create beautiful statistical plots

**What's Next?**
- Course 6: Practical Projects
- Apply your knowledge
- Build real-world projects
- Continue learning

---

## Additional Resources

- **Seaborn Documentation**: [seaborn.pydata.org/](https://seaborn.pydata.org/)
- **Seaborn Tutorial**: [seaborn.pydata.org/tutorial.html](https://seaborn.pydata.org/tutorial.html)
- **Seaborn Gallery**: [seaborn.pydata.org/examples/index.html](https://seaborn.pydata.org/examples/index.html)
- **Statistical Plots Guide**: [seaborn.pydata.org/tutorial/statistical_intro.html](https://seaborn.pydata.org/tutorial/statistical_intro.html)

---

*Lesson completed! You've completed the Data Visualization module. Great work!*

