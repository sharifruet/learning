# Capstone Project 2: Data Analysis Project

## Project Overview

Build a comprehensive data analysis project demonstrating mastery of data manipulation, analysis, visualization, and insights generation using Python's data science ecosystem.

**Project Duration**: 2-3 weeks  
**Difficulty**: Advanced  
**Technologies**: Pandas, NumPy, Matplotlib, Seaborn, Jupyter Notebooks, Scikit-learn

---

## Learning Objectives

By completing this project, you will:
- Load and explore datasets
- Clean and preprocess data
- Perform exploratory data analysis (EDA)
- Create meaningful visualizations
- Apply statistical analysis
- Build predictive models
- Generate actionable insights
- Present findings effectively
- Document analysis process

---

## Project Requirements

### Core Requirements

1. **Dataset**: Real-world dataset (minimum 1000 rows, multiple features)
2. **Data Cleaning**: Handle missing values, outliers, duplicates
3. **Exploratory Data Analysis**: Comprehensive EDA with visualizations
4. **Statistical Analysis**: Descriptive statistics, correlations, hypothesis testing
5. **Visualizations**: Multiple chart types (at least 10 different visualizations)
6. **Machine Learning**: At least one predictive model
7. **Documentation**: Jupyter notebook with markdown explanations
8. **Insights**: Clear conclusions and recommendations

### Functional Requirements

1. **Data Loading and Inspection**
   - Load data from CSV, JSON, or API
   - Inspect data structure
   - Check data types
   - Identify missing values

2. **Data Cleaning**
   - Handle missing values
   - Remove duplicates
   - Handle outliers
   - Data type conversions
   - Feature engineering

3. **Exploratory Data Analysis**
   - Univariate analysis
   - Bivariate analysis
   - Multivariate analysis
   - Distribution analysis
   - Correlation analysis

4. **Visualizations**
   - Histograms and distributions
   - Scatter plots
   - Box plots
   - Heatmaps
   - Time series plots (if applicable)
   - Categorical visualizations

5. **Statistical Analysis**
   - Descriptive statistics
   - Inferential statistics
   - Hypothesis testing
   - Confidence intervals

6. **Machine Learning**
   - Data preprocessing for ML
   - Feature selection
   - Model training
   - Model evaluation
   - Model interpretation

### Technical Requirements

1. **Code Quality**
   - Well-organized notebook
   - Clear markdown explanations
   - Reusable functions
   - Comments and docstrings
   - Error handling

2. **Visualization Quality**
   - Professional-looking plots
   - Clear labels and titles
   - Appropriate color schemes
   - Consistent styling

3. **Documentation**
   - Executive summary
   - Methodology explanation
   - Key findings
   - Recommendations
   - Limitations

---

## Suggested Project: E-commerce Sales Analysis

### Dataset Options

1. **E-commerce Sales Data**
   - Customer purchases
   - Product information
   - Sales transactions
   - Customer demographics

2. **Retail Sales Data**
   - Store sales
   - Product categories
   - Time series data
   - Regional sales

3. **Customer Behavior Data**
   - Website analytics
   - User interactions
   - Conversion data
   - Customer segments

### Analysis Goals

1. **Sales Performance**
   - Total sales trends
   - Product performance
   - Category analysis
   - Seasonal patterns

2. **Customer Analysis**
   - Customer segmentation
   - Purchase behavior
   - Customer lifetime value
   - Retention analysis

3. **Predictive Modeling**
   - Sales forecasting
   - Customer churn prediction
   - Product recommendation
   - Price optimization

---

## Technology Stack

### Core Libraries
- **Pandas**: Data manipulation and analysis
- **NumPy**: Numerical computing
- **Matplotlib**: Basic plotting
- **Seaborn**: Statistical visualizations
- **Plotly**: Interactive visualizations (optional)

### Machine Learning
- **Scikit-learn**: Machine learning algorithms
- **XGBoost**: Gradient boosting (optional)
- **Statsmodels**: Statistical modeling

### Data Sources
- **Kaggle**: Datasets
- **UCI ML Repository**: Machine learning datasets
- **Government Data**: Open data portals
- **APIs**: Real-time data

### Tools
- **Jupyter Notebook**: Interactive analysis
- **VS Code / PyCharm**: Code editing
- **Git**: Version control

---

## Project Structure

```
data_analysis_project/
├── README.md
├── requirements.txt
├── .gitignore
├── data/
│   ├── raw/
│   │   └── original_dataset.csv
│   ├── processed/
│   │   └── cleaned_data.csv
│   └── external/
│       └── reference_data.csv
├── notebooks/
│   ├── 01_data_loading.ipynb
│   ├── 02_data_cleaning.ipynb
│   ├── 03_exploratory_analysis.ipynb
│   ├── 04_statistical_analysis.ipynb
│   ├── 05_visualization.ipynb
│   ├── 06_machine_learning.ipynb
│   └── 07_final_report.ipynb
├── src/
│   ├── __init__.py
│   ├── data_loader.py
│   ├── data_cleaner.py
│   ├── visualizer.py
│   ├── analyzer.py
│   └── models.py
├── reports/
│   ├── figures/
│   │   └── (saved visualizations)
│   └── final_report.pdf
└── tests/
    ├── __init__.py
    └── test_data_processing.py
```

---

## Implementation Guide

### Phase 1: Project Setup (Day 1)

#### Step 1: Environment Setup

```bash
# Create project directory
mkdir data_analysis_project
cd data_analysis_project

# Create virtual environment
python -m venv venv
source venv/bin/activate  # Linux/macOS
# venv\Scripts\activate   # Windows

# Install dependencies
pip install pandas numpy matplotlib seaborn plotly
pip install scikit-learn xgboost statsmodels
pip install jupyter notebook ipykernel
pip install openpyxl  # For Excel files

# Create requirements.txt
pip freeze > requirements.txt
```

#### Step 2: Project Structure

```bash
# Create directories
mkdir -p data/{raw,processed,external}
mkdir -p notebooks src reports/figures tests
touch src/__init__.py tests/__init__.py
```

#### Step 3: Dataset Selection

**Recommended Datasets**:
- Kaggle: E-commerce Sales, Retail Sales, Customer Data
- UCI ML: Online Retail, Sales Transactions
- Government: Economic data, Census data

**Dataset Requirements**:
- Minimum 1000 rows
- Multiple features (10+ columns)
- Mix of numerical and categorical
- Real-world relevance

### Phase 2: Data Loading and Inspection (Days 2-3)

#### Data Loading

```python
# notebooks/01_data_loading.ipynb
import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns
import warnings
warnings.filterwarnings('ignore')

# Set style
sns.set_style('whitegrid')
plt.rcParams['figure.figsize'] = (12, 6)

# Load data
df = pd.read_csv('data/raw/sales_data.csv')

# Basic inspection
print("Dataset Shape:", df.shape)
print("\nColumn Names:")
print(df.columns.tolist())
print("\nData Types:")
print(df.dtypes)
print("\nFirst Few Rows:")
df.head()
```

#### Data Inspection

```python
# Basic information
df.info()

# Statistical summary
df.describe()

# Check for missing values
missing_values = df.isnull().sum()
missing_percent = (missing_values / len(df)) * 100
missing_df = pd.DataFrame({
    'Missing Count': missing_values,
    'Percentage': missing_percent
})
missing_df[missing_df['Missing Count'] > 0].sort_values('Missing Count', ascending=False)

# Check for duplicates
duplicate_count = df.duplicated().sum()
print(f"Duplicate rows: {duplicate_count}")

# Unique values in categorical columns
categorical_cols = df.select_dtypes(include=['object']).columns
for col in categorical_cols:
    print(f"\n{col}: {df[col].nunique()} unique values")
    print(df[col].value_counts().head())
```

#### Data Structure Analysis

```python
# Memory usage
print("Memory Usage:")
print(df.memory_usage(deep=True).sum() / 1024**2, "MB")

# Date columns (if any)
date_columns = df.select_dtypes(include=['datetime64']).columns
print(f"\nDate columns: {list(date_columns)}")

# Numerical columns
numerical_cols = df.select_dtypes(include=[np.number]).columns
print(f"\nNumerical columns: {list(numerical_cols)}")

# Categorical columns
categorical_cols = df.select_dtypes(include=['object']).columns
print(f"\nCategorical columns: {list(categorical_cols)}")
```

### Phase 3: Data Cleaning (Days 4-5)

#### Handle Missing Values

```python
# notebooks/02_data_cleaning.ipynb
import pandas as pd
import numpy as np

# Load data
df = pd.read_csv('data/raw/sales_data.csv')

# Strategy 1: Drop columns with >50% missing values
threshold = 0.5
cols_to_drop = df.columns[df.isnull().mean() > threshold]
df_cleaned = df.drop(columns=cols_to_drop)
print(f"Dropped columns: {list(cols_to_drop)}")

# Strategy 2: Fill numerical columns with median
numerical_cols = df_cleaned.select_dtypes(include=[np.number]).columns
for col in numerical_cols:
    if df_cleaned[col].isnull().sum() > 0:
        df_cleaned[col].fillna(df_cleaned[col].median(), inplace=True)

# Strategy 3: Fill categorical columns with mode
categorical_cols = df_cleaned.select_dtypes(include=['object']).columns
for col in categorical_cols:
    if df_cleaned[col].isnull().sum() > 0:
        df_cleaned[col].fillna(df_cleaned[col].mode()[0], inplace=True)

# Verify no missing values
print(f"Missing values remaining: {df_cleaned.isnull().sum().sum()}")
```

#### Handle Duplicates

```python
# Remove duplicates
initial_count = len(df_cleaned)
df_cleaned = df_cleaned.drop_duplicates()
final_count = len(df_cleaned)
print(f"Removed {initial_count - final_count} duplicate rows")
```

#### Handle Outliers

```python
# Detect outliers using IQR method
def detect_outliers_iqr(df, column):
    """Detect outliers using IQR method."""
    Q1 = df[column].quantile(0.25)
    Q3 = df[column].quantile(0.75)
    IQR = Q3 - Q1
    lower_bound = Q1 - 1.5 * IQR
    upper_bound = Q3 + 1.5 * IQR
    outliers = df[(df[column] < lower_bound) | (df[column] > upper_bound)]
    return outliers, lower_bound, upper_bound

# Handle outliers for numerical columns
numerical_cols = df_cleaned.select_dtypes(include=[np.number]).columns
for col in numerical_cols:
    outliers, lower, upper = detect_outliers_iqr(df_cleaned, col)
    if len(outliers) > 0:
        print(f"\n{col}: {len(outliers)} outliers detected")
        # Option 1: Cap outliers
        df_cleaned[col] = df_cleaned[col].clip(lower=lower, upper=upper)
        # Option 2: Remove outliers (if appropriate)
        # df_cleaned = df_cleaned[(df_cleaned[col] >= lower) & (df_cleaned[col] <= upper)]
```

#### Data Type Conversions

```python
# Convert date columns
date_columns = ['order_date', 'ship_date']  # Adjust based on your data
for col in date_columns:
    if col in df_cleaned.columns:
        df_cleaned[col] = pd.to_datetime(df_cleaned[col], errors='coerce')

# Convert categorical to category type (saves memory)
categorical_cols = df_cleaned.select_dtypes(include=['object']).columns
for col in categorical_cols:
    if df_cleaned[col].nunique() < 50:  # Only if reasonable number of categories
        df_cleaned[col] = df_cleaned[col].astype('category')

# Save cleaned data
df_cleaned.to_csv('data/processed/cleaned_data.csv', index=False)
print("Cleaned data saved!")
```

### Phase 4: Exploratory Data Analysis (Days 6-9)

#### Univariate Analysis

```python
# notebooks/03_exploratory_analysis.ipynb
import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns

# Load cleaned data
df = pd.read_csv('data/processed/cleaned_data.csv')

# Numerical variables - Distribution
numerical_cols = df.select_dtypes(include=[np.number]).columns
fig, axes = plt.subplots(len(numerical_cols), 2, figsize=(15, 5*len(numerical_cols)))
fig.suptitle('Univariate Analysis - Numerical Variables', fontsize=16)

for idx, col in enumerate(numerical_cols):
    # Histogram
    axes[idx, 0].hist(df[col].dropna(), bins=30, edgecolor='black')
    axes[idx, 0].set_title(f'Distribution of {col}')
    axes[idx, 0].set_xlabel(col)
    axes[idx, 0].set_ylabel('Frequency')
    
    # Box plot
    axes[idx, 1].boxplot(df[col].dropna())
    axes[idx, 1].set_title(f'Box Plot of {col}')
    axes[idx, 1].set_ylabel(col)

plt.tight_layout()
plt.savefig('reports/figures/univariate_numerical.png', dpi=300, bbox_inches='tight')
plt.show()

# Categorical variables
categorical_cols = df.select_dtypes(include=['object', 'category']).columns
for col in categorical_cols:
    plt.figure(figsize=(12, 6))
    value_counts = df[col].value_counts()
    plt.bar(range(len(value_counts)), value_counts.values)
    plt.xticks(range(len(value_counts)), value_counts.index, rotation=45)
    plt.title(f'Distribution of {col}')
    plt.xlabel(col)
    plt.ylabel('Count')
    plt.tight_layout()
    plt.savefig(f'reports/figures/categorical_{col}.png', dpi=300, bbox_inches='tight')
    plt.show()
```

#### Bivariate Analysis

```python
# Correlation matrix
numerical_cols = df.select_dtypes(include=[np.number]).columns
correlation_matrix = df[numerical_cols].corr()

plt.figure(figsize=(12, 10))
sns.heatmap(correlation_matrix, annot=True, cmap='coolwarm', center=0,
            square=True, linewidths=1, cbar_kws={"shrink": 0.8})
plt.title('Correlation Matrix', fontsize=16)
plt.tight_layout()
plt.savefig('reports/figures/correlation_matrix.png', dpi=300, bbox_inches='tight')
plt.show()

# Scatter plots for key relationships
key_pairs = [('sales', 'quantity'), ('price', 'sales'), ('discount', 'sales')]
for pair in key_pairs:
    if all(col in df.columns for col in pair):
        plt.figure(figsize=(10, 6))
        plt.scatter(df[pair[0]], df[pair[1]], alpha=0.5)
        plt.xlabel(pair[0])
        plt.ylabel(pair[1])
        plt.title(f'{pair[0]} vs {pair[1]}')
        plt.tight_layout()
        plt.savefig(f'reports/figures/scatter_{pair[0]}_{pair[1]}.png', dpi=300, bbox_inches='tight')
        plt.show()
```

#### Multivariate Analysis

```python
# Pair plot for key numerical variables
key_numerical = ['sales', 'quantity', 'price', 'profit']  # Adjust based on your data
key_numerical = [col for col in key_numerical if col in df.columns]

if len(key_numerical) >= 2:
    sns.pairplot(df[key_numerical], diag_kind='kde')
    plt.suptitle('Pair Plot of Key Numerical Variables', y=1.02)
    plt.savefig('reports/figures/pairplot.png', dpi=300, bbox_inches='tight')
    plt.show()

# Grouped analysis
if 'category' in df.columns and 'sales' in df.columns:
    category_sales = df.groupby('category')['sales'].agg(['sum', 'mean', 'count']).sort_values('sum', ascending=False)
    
    fig, axes = plt.subplots(1, 2, figsize=(15, 6))
    
    # Total sales by category
    axes[0].barh(range(len(category_sales)), category_sales['sum'])
    axes[0].set_yticks(range(len(category_sales)))
    axes[0].set_yticklabels(category_sales.index)
    axes[0].set_xlabel('Total Sales')
    axes[0].set_title('Total Sales by Category')
    
    # Average sales by category
    axes[1].barh(range(len(category_sales)), category_sales['mean'])
    axes[1].set_yticks(range(len(category_sales)))
    axes[1].set_yticklabels(category_sales.index)
    axes[1].set_xlabel('Average Sales')
    axes[1].set_title('Average Sales by Category')
    
    plt.tight_layout()
    plt.savefig('reports/figures/category_analysis.png', dpi=300, bbox_inches='tight')
    plt.show()
```

### Phase 5: Statistical Analysis (Days 10-11)

#### Descriptive Statistics

```python
# notebooks/04_statistical_analysis.ipynb
import pandas as pd
import numpy as np
from scipy import stats

# Load cleaned data
df = pd.read_csv('data/processed/cleaned_data.csv')

# Comprehensive descriptive statistics
numerical_cols = df.select_dtypes(include=[np.number]).columns
descriptive_stats = df[numerical_cols].describe()

# Add additional statistics
additional_stats = pd.DataFrame({
    'skewness': df[numerical_cols].skew(),
    'kurtosis': df[numerical_cols].kurtosis(),
    'variance': df[numerical_cols].var(),
    'coefficient_of_variation': df[numerical_cols].std() / df[numerical_cols].mean()
})

# Combine statistics
full_stats = pd.concat([descriptive_stats.T, additional_stats], axis=1)
print("Comprehensive Descriptive Statistics:")
print(full_stats)
```

#### Hypothesis Testing

```python
# Example: Test if sales differ significantly between two categories
if 'category' in df.columns and 'sales' in df.columns:
    categories = df['category'].unique()[:2]  # Compare first two categories
    cat1_sales = df[df['category'] == categories[0]]['sales']
    cat2_sales = df[df['category'] == categories[1]]['sales']
    
    # T-test
    t_stat, p_value = stats.ttest_ind(cat1_sales, cat2_sales)
    print(f"T-test between {categories[0]} and {categories[1]}:")
    print(f"T-statistic: {t_stat:.4f}")
    print(f"P-value: {p_value:.4f}")
    print(f"Significant difference: {'Yes' if p_value < 0.05 else 'No'}")
    
    # Mann-Whitney U test (non-parametric alternative)
    u_stat, u_p_value = stats.mannwhitneyu(cat1_sales, cat2_sales, alternative='two-sided')
    print(f"\nMann-Whitney U test:")
    print(f"U-statistic: {u_stat:.4f}")
    print(f"P-value: {u_p_value:.4f}")
```

#### Correlation Analysis

```python
# Pearson correlation
numerical_cols = df.select_dtypes(include=[np.number]).columns
correlation_matrix = df[numerical_cols].corr(method='pearson')

# Find strong correlations
strong_correlations = []
for i in range(len(correlation_matrix.columns)):
    for j in range(i+1, len(correlation_matrix.columns)):
        corr_value = correlation_matrix.iloc[i, j]
        if abs(corr_value) > 0.7:  # Strong correlation threshold
            strong_correlations.append({
                'Variable 1': correlation_matrix.columns[i],
                'Variable 2': correlation_matrix.columns[j],
                'Correlation': corr_value
            })

if strong_correlations:
    print("Strong Correlations (|r| > 0.7):")
    for corr in strong_correlations:
        print(f"{corr['Variable 1']} - {corr['Variable 2']}: {corr['Correlation']:.4f}")
```

### Phase 6: Advanced Visualizations (Days 12-13)

#### Time Series Analysis

```python
# notebooks/05_visualization.ipynb
import pandas as pd
import matplotlib.pyplot as plt
import seaborn as sns

# Load cleaned data
df = pd.read_csv('data/processed/cleaned_data.csv')

# Time series analysis (if date column exists)
date_columns = df.select_dtypes(include=['datetime64']).columns
if len(date_columns) > 0 and 'sales' in df.columns:
    date_col = date_columns[0]
    df[date_col] = pd.to_datetime(df[date_col])
    df_time = df.set_index(date_col)
    
    # Daily sales trend
    daily_sales = df_time['sales'].resample('D').sum()
    
    fig, axes = plt.subplots(2, 1, figsize=(15, 10))
    
    # Line plot
    axes[0].plot(daily_sales.index, daily_sales.values, linewidth=2)
    axes[0].set_title('Daily Sales Trend', fontsize=14)
    axes[0].set_xlabel('Date')
    axes[0].set_ylabel('Sales')
    axes[0].grid(True, alpha=0.3)
    
    # Monthly aggregation
    monthly_sales = df_time['sales'].resample('M').sum()
    axes[1].bar(range(len(monthly_sales)), monthly_sales.values)
    axes[1].set_xticks(range(len(monthly_sales)))
    axes[1].set_xticklabels([d.strftime('%Y-%m') for d in monthly_sales.index], rotation=45)
    axes[1].set_title('Monthly Sales', fontsize=14)
    axes[1].set_xlabel('Month')
    axes[1].set_ylabel('Sales')
    axes[1].grid(True, alpha=0.3, axis='y')
    
    plt.tight_layout()
    plt.savefig('reports/figures/time_series_sales.png', dpi=300, bbox_inches='tight')
    plt.show()
```

#### Advanced Visualizations

```python
# Violin plots for distribution comparison
if 'category' in df.columns and 'sales' in df.columns:
    plt.figure(figsize=(12, 6))
    sns.violinplot(data=df, x='category', y='sales')
    plt.title('Sales Distribution by Category', fontsize=14)
    plt.xticks(rotation=45)
    plt.tight_layout()
    plt.savefig('reports/figures/violin_category_sales.png', dpi=300, bbox_inches='tight')
    plt.show()

# Heatmap with annotations
if 'category' in df.columns and 'region' in df.columns and 'sales' in df.columns:
    pivot_table = df.pivot_table(values='sales', index='category', columns='region', aggfunc='sum')
    plt.figure(figsize=(12, 8))
    sns.heatmap(pivot_table, annot=True, fmt='.0f', cmap='YlOrRd', linewidths=0.5)
    plt.title('Sales Heatmap: Category vs Region', fontsize=14)
    plt.tight_layout()
    plt.savefig('reports/figures/heatmap_category_region.png', dpi=300, bbox_inches='tight')
    plt.show()

# Stacked bar chart
if 'category' in df.columns and 'status' in df.columns:
    category_status = pd.crosstab(df['category'], df['status'])
    category_status.plot(kind='bar', stacked=True, figsize=(12, 6))
    plt.title('Status Distribution by Category', fontsize=14)
    plt.xlabel('Category')
    plt.ylabel('Count')
    plt.legend(title='Status')
    plt.xticks(rotation=45)
    plt.tight_layout()
    plt.savefig('reports/figures/stacked_bar_category_status.png', dpi=300, bbox_inches='tight')
    plt.show()
```

### Phase 7: Machine Learning (Days 14-16)

#### Data Preprocessing for ML

```python
# notebooks/06_machine_learning.ipynb
import pandas as pd
import numpy as np
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler, LabelEncoder
from sklearn.ensemble import RandomForestRegressor, RandomForestClassifier
from sklearn.metrics import mean_squared_error, r2_score, accuracy_score, classification_report
import joblib

# Load cleaned data
df = pd.read_csv('data/processed/cleaned_data.csv')

# Example: Predict sales based on other features
# Select features
feature_columns = ['quantity', 'price', 'discount']  # Adjust based on your data
target_column = 'sales'

# Prepare data
X = df[feature_columns].copy()
y = df[target_column].copy()

# Handle missing values
X = X.fillna(X.mean())
y = y.fillna(y.mean())

# Encode categorical variables if any
le = LabelEncoder()
for col in X.select_dtypes(include=['object', 'category']).columns:
    X[col] = le.fit_transform(X[col])

# Split data
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Scale features
scaler = StandardScaler()
X_train_scaled = scaler.fit_transform(X_train)
X_test_scaled = scaler.transform(X_test)
```

#### Model Training

```python
# Train Random Forest model
model = RandomForestRegressor(n_estimators=100, random_state=42, n_jobs=-1)
model.fit(X_train_scaled, y_train)

# Predictions
y_train_pred = model.predict(X_train_scaled)
y_test_pred = model.predict(X_test_scaled)

# Evaluation
train_rmse = np.sqrt(mean_squared_error(y_train, y_train_pred))
test_rmse = np.sqrt(mean_squared_error(y_test, y_test_pred))
train_r2 = r2_score(y_train, y_train_pred)
test_r2 = r2_score(y_test, y_test_pred)

print("Model Performance:")
print(f"Train RMSE: {train_rmse:.4f}")
print(f"Test RMSE: {test_rmse:.4f}")
print(f"Train R²: {train_r2:.4f}")
print(f"Test R²: {test_r2:.4f}")

# Feature importance
feature_importance = pd.DataFrame({
    'feature': feature_columns,
    'importance': model.feature_importances_
}).sort_values('importance', ascending=False)

print("\nFeature Importance:")
print(feature_importance)

# Visualize feature importance
plt.figure(figsize=(10, 6))
plt.barh(feature_importance['feature'], feature_importance['importance'])
plt.xlabel('Importance')
plt.title('Feature Importance')
plt.tight_layout()
plt.savefig('reports/figures/feature_importance.png', dpi=300, bbox_inches='tight')
plt.show()

# Save model
joblib.dump(model, 'models/sales_predictor.pkl')
joblib.dump(scaler, 'models/scaler.pkl')
```

#### Model Evaluation

```python
# Prediction vs Actual scatter plot
fig, axes = plt.subplots(1, 2, figsize=(15, 6))

# Training set
axes[0].scatter(y_train, y_train_pred, alpha=0.5)
axes[0].plot([y_train.min(), y_train.max()], [y_train.min(), y_train.max()], 'r--', lw=2)
axes[0].set_xlabel('Actual')
axes[0].set_ylabel('Predicted')
axes[0].set_title(f'Training Set (R² = {train_r2:.4f})')
axes[0].grid(True, alpha=0.3)

# Test set
axes[1].scatter(y_test, y_test_pred, alpha=0.5)
axes[1].plot([y_test.min(), y_test.max()], [y_test.min(), y_test.max()], 'r--', lw=2)
axes[1].set_xlabel('Actual')
axes[1].set_ylabel('Predicted')
axes[1].set_title(f'Test Set (R² = {test_r2:.4f})')
axes[1].grid(True, alpha=0.3)

plt.tight_layout()
plt.savefig('reports/figures/prediction_accuracy.png', dpi=300, bbox_inches='tight')
plt.show()
```

### Phase 8: Final Report and Presentation (Days 17-18)

#### Executive Summary

```python
# notebooks/07_final_report.ipynb
import pandas as pd
import matplotlib.pyplot as plt

# Load cleaned data
df = pd.read_csv('data/processed/cleaned_data.csv')

# Key Metrics Summary
summary = {
    'Total Records': len(df),
    'Total Sales': df['sales'].sum() if 'sales' in df.columns else 'N/A',
    'Average Sales': df['sales'].mean() if 'sales' in df.columns else 'N/A',
    'Unique Customers': df['customer_id'].nunique() if 'customer_id' in df.columns else 'N/A',
    'Unique Products': df['product_id'].nunique() if 'product_id' in df.columns else 'N/A',
    'Date Range': f"{df['date'].min()} to {df['date'].max()}" if 'date' in df.columns else 'N/A'
}

print("=" * 50)
print("EXECUTIVE SUMMARY")
print("=" * 50)
for key, value in summary.items():
    print(f"{key}: {value}")
print("=" * 50)
```

#### Key Findings

```python
# Top insights
print("\nKEY FINDINGS:")
print("1. Sales Performance:")
if 'sales' in df.columns:
    top_category = df.groupby('category')['sales'].sum().idxmax()
    print(f"   - Top performing category: {top_category}")
    print(f"   - Total sales: ${df['sales'].sum():,.2f}")

print("\n2. Customer Insights:")
if 'customer_id' in df.columns:
    avg_order_value = df.groupby('customer_id')['sales'].sum().mean()
    print(f"   - Average customer lifetime value: ${avg_order_value:,.2f}")

print("\n3. Product Insights:")
if 'product_id' in df.columns and 'sales' in df.columns:
    top_product = df.groupby('product_id')['sales'].sum().idxmax()
    print(f"   - Best selling product ID: {top_product}")
```

#### Recommendations

```python
print("\nRECOMMENDATIONS:")
print("1. Focus marketing efforts on top-performing categories")
print("2. Implement customer retention programs for high-value customers")
print("3. Optimize inventory for best-selling products")
print("4. Consider promotional campaigns for underperforming categories")
print("5. Analyze seasonal trends for better inventory planning")
```

---

## Evaluation Criteria

### Data Analysis (30%)
- Comprehensive EDA
- Appropriate visualizations
- Statistical analysis
- Data quality assessment

### Code Quality (20%)
- Well-organized code
- Reusable functions
- Clear comments
- Proper error handling

### Machine Learning (20%)
- Appropriate model selection
- Proper evaluation metrics
- Feature engineering
- Model interpretation

### Documentation (15%)
- Clear markdown explanations
- Methodology documented
- Findings summarized
- Recommendations provided

### Visualization Quality (10%)
- Professional appearance
- Clear labels
- Appropriate chart types
- Consistent styling

### Insights and Recommendations (5%)
- Actionable insights
- Business recommendations
- Clear conclusions

---

## Submission Requirements

1. **Jupyter Notebooks**
   - Complete analysis notebooks
   - All code executable
   - Clear markdown explanations

2. **Data Files**
   - Original dataset
   - Cleaned dataset
   - Processed datasets

3. **Visualizations**
   - All figures saved
   - High resolution (300 DPI)
   - Properly labeled

4. **Documentation**
   - README.md with project overview
   - Final report (PDF or HTML)
   - Methodology explanation

5. **Code**
   - Reusable functions in src/
   - Requirements.txt
   - .gitignore

---

## Additional Resources

- **Kaggle**: kaggle.com/datasets
- **UCI ML Repository**: archive.ics.uci.edu/ml
- **Pandas Documentation**: pandas.pydata.org
- **Matplotlib Gallery**: matplotlib.org/gallery
- **Seaborn Examples**: seaborn.pydata.org/examples

---

## Next Steps

After completing this project:
1. Explore more advanced ML techniques
2. Build interactive dashboards (Plotly Dash, Streamlit)
3. Deploy models as APIs
4. Create automated reporting pipelines
5. Explore deep learning for time series

---

*Good luck with your data analysis project!*

