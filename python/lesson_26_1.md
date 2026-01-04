# Lesson 26.1: Project Structure

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the importance of project structure
- Organize large Python projects effectively
- Create proper package structures
- Manage configuration files
- Follow Python project best practices
- Understand different project layouts
- Set up project scaffolding
- Manage project metadata
- Create maintainable project structures

---

## Introduction to Project Structure

**Project Structure** refers to how files and directories are organized in a Python project. A well-organized structure makes code:
- **Easier to navigate**
- **Easier to maintain**
- **Easier to test**
- **Easier to deploy**
- **Easier to collaborate on**

**Key Principles**:
- **Separation of concerns**
- **Modularity**
- **Scalability**
- **Clarity**
- **Convention over configuration**

---

## Organizing Large Projects

### Basic Project Structure

```
myproject/
├── README.md
├── LICENSE
├── setup.py
├── requirements.txt
├── .gitignore
├── myproject/
│   ├── __init__.py
│   ├── main.py
│   └── utils.py
└── tests/
    ├── __init__.py
    └── test_utils.py
```

### Standard Project Structure

```
myproject/
├── README.md
├── LICENSE
├── setup.py
├── setup.cfg
├── pyproject.toml
├── requirements.txt
├── requirements-dev.txt
├── .gitignore
├── .env.example
├── docs/
│   ├── conf.py
│   └── index.rst
├── myproject/
│   ├── __init__.py
│   ├── main.py
│   ├── config/
│   │   ├── __init__.py
│   │   └── settings.py
│   ├── core/
│   │   ├── __init__.py
│   │   └── models.py
│   ├── utils/
│   │   ├── __init__.py
│   │   └── helpers.py
│   └── api/
│       ├── __init__.py
│       └── routes.py
├── tests/
│   ├── __init__.py
│   ├── conftest.py
│   ├── test_core/
│   │   └── test_models.py
│   └── test_utils/
│       └── test_helpers.py
└── scripts/
    └── setup.sh
```

### Application vs Library Structure

**Application Structure** (runnable program):
```
myapp/
├── myapp/
│   ├── __init__.py
│   ├── main.py          # Entry point
│   ├── config.py
│   └── modules/
└── tests/
```

**Library Structure** (importable package):
```
mylibrary/
├── mylibrary/
│   ├── __init__.py
│   ├── core.py
│   └── utils.py
└── tests/
```

---

## Package Structure

### Creating Packages

A **package** is a directory containing Python modules and an `__init__.py` file.

```python
# mypackage/__init__.py
"""
My Package

A sample package demonstrating proper structure.
"""

__version__ = "1.0.0"
__author__ = "Your Name"

from .core import CoreClass
from .utils import helper_function

__all__ = ['CoreClass', 'helper_function']
```

### Flat vs Nested Structure

**Flat Structure** (simple projects):
```
mypackage/
├── __init__.py
├── module1.py
├── module2.py
└── module3.py
```

**Nested Structure** (complex projects):
```
mypackage/
├── __init__.py
├── core/
│   ├── __init__.py
│   ├── models.py
│   └── views.py
├── utils/
│   ├── __init__.py
│   ├── helpers.py
│   └── validators.py
└── api/
    ├── __init__.py
    └── endpoints.py
```

### Package Initialization

```python
# mypackage/__init__.py
"""
Package initialization.

This module initializes the package and makes key components available.
"""

# Version
__version__ = "1.0.0"

# Package metadata
__author__ = "Your Name"
__email__ = "your.email@example.com"
__license__ = "MIT"

# Import key components
from .core import CoreClass
from .utils import helper_function

# Define public API
__all__ = [
    'CoreClass',
    'helper_function',
    '__version__',
]
```

### Subpackage Structure

```python
# mypackage/core/__init__.py
"""Core functionality."""

from .models import Model, User, Product
from .views import View, ListView, DetailView

__all__ = ['Model', 'User', 'Product', 'View', 'ListView', 'DetailView']

# mypackage/core/models.py
"""Data models."""

class Model:
    pass

class User(Model):
    pass

class Product(Model):
    pass

# mypackage/core/views.py
"""View classes."""

class View:
    pass

class ListView(View):
    pass

class DetailView(View):
    pass
```

### Relative Imports

```python
# mypackage/utils/__init__.py
from .helpers import helper_function
from .validators import validate_email

# mypackage/utils/helpers.py
def helper_function():
    """Helper function."""
    pass

# mypackage/utils/validators.py
def validate_email(email):
    """Validate email address."""
    pass
```

---

## Configuration Management

### Environment Variables

```python
# config/settings.py
"""Application settings."""

import os
from pathlib import Path

# Base directory
BASE_DIR = Path(__file__).parent.parent

# Environment
ENV = os.getenv('ENV', 'development')
DEBUG = os.getenv('DEBUG', 'False').lower() == 'true'

# Database
DATABASE_URL = os.getenv(
    'DATABASE_URL',
    f'sqlite:///{BASE_DIR / "db.sqlite3"}'
)

# API Keys
API_KEY = os.getenv('API_KEY', '')
SECRET_KEY = os.getenv('SECRET_KEY', 'change-me-in-production')

# Logging
LOG_LEVEL = os.getenv('LOG_LEVEL', 'INFO')
LOG_FILE = os.getenv('LOG_FILE', BASE_DIR / 'logs' / 'app.log')
```

### Configuration Classes

```python
# config/settings.py
"""Configuration management."""

import os
from dataclasses import dataclass
from pathlib import Path
from typing import Optional

@dataclass
class DatabaseConfig:
    """Database configuration."""
    url: str
    pool_size: int = 5
    max_overflow: int = 10
    echo: bool = False

@dataclass
class APIConfig:
    """API configuration."""
    host: str = '0.0.0.0'
    port: int = 8000
    debug: bool = False
    secret_key: str = ''

@dataclass
class Config:
    """Application configuration."""
    env: str
    database: DatabaseConfig
    api: APIConfig
    
    @classmethod
    def from_env(cls) -> 'Config':
        """Load configuration from environment variables."""
        env = os.getenv('ENV', 'development')
        
        database = DatabaseConfig(
            url=os.getenv('DATABASE_URL', 'sqlite:///db.sqlite3'),
            pool_size=int(os.getenv('DB_POOL_SIZE', '5')),
            max_overflow=int(os.getenv('DB_MAX_OVERFLOW', '10')),
            echo=os.getenv('DB_ECHO', 'False').lower() == 'true'
        )
        
        api = APIConfig(
            host=os.getenv('API_HOST', '0.0.0.0'),
            port=int(os.getenv('API_PORT', '8000')),
            debug=os.getenv('DEBUG', 'False').lower() == 'true',
            secret_key=os.getenv('SECRET_KEY', '')
        )
        
        return cls(
            env=env,
            database=database,
            api=api
        )

# Usage
config = Config.from_env()
print(config.database.url)
print(config.api.host)
```

### Configuration Files

**YAML Configuration**:
```yaml
# config/config.yaml
database:
  url: postgresql://user:pass@localhost/dbname
  pool_size: 5
  max_overflow: 10

api:
  host: 0.0.0.0
  port: 8000
  debug: false

logging:
  level: INFO
  file: logs/app.log
```

```python
# config/loader.py
"""Configuration loader."""

import yaml
from pathlib import Path
from typing import Dict, Any

def load_yaml_config(config_path: Path) -> Dict[str, Any]:
    """Load configuration from YAML file."""
    with open(config_path, 'r') as f:
        return yaml.safe_load(f)

# Usage
config = load_yaml_config(Path('config/config.yaml'))
```

**JSON Configuration**:
```json
{
  "database": {
    "url": "postgresql://user:pass@localhost/dbname",
    "pool_size": 5
  },
  "api": {
    "host": "0.0.0.0",
    "port": 8000
  }
}
```

```python
# config/loader.py
import json
from pathlib import Path

def load_json_config(config_path: Path) -> dict:
    """Load configuration from JSON file."""
    with open(config_path, 'r') as f:
        return json.load(f)
```

### Environment-Specific Configuration

```python
# config/settings.py
"""Environment-specific configuration."""

import os
from pathlib import Path

class BaseConfig:
    """Base configuration."""
    SECRET_KEY = os.getenv('SECRET_KEY', 'dev-secret-key')
    DEBUG = False
    TESTING = False

class DevelopmentConfig(BaseConfig):
    """Development configuration."""
    DEBUG = True
    DATABASE_URL = 'sqlite:///dev.db'

class ProductionConfig(BaseConfig):
    """Production configuration."""
    DEBUG = False
    DATABASE_URL = os.getenv('DATABASE_URL')
    SECRET_KEY = os.getenv('SECRET_KEY')

class TestingConfig(BaseConfig):
    """Testing configuration."""
    TESTING = True
    DATABASE_URL = 'sqlite:///:memory:'

# Configuration mapping
config = {
    'development': DevelopmentConfig,
    'production': ProductionConfig,
    'testing': TestingConfig,
    'default': DevelopmentConfig
}

def get_config():
    """Get configuration based on environment."""
    env = os.getenv('ENV', 'default')
    return config.get(env, config['default'])

# Usage
app_config = get_config()
print(app_config.DEBUG)
```

### Configuration Best Practices

```python
# config/settings.py
"""Configuration best practices."""

import os
from pathlib import Path
from typing import Optional

class Config:
    """Configuration with validation."""
    
    def __init__(self):
        self._validate()
    
    @property
    def database_url(self) -> str:
        """Get database URL."""
        url = os.getenv('DATABASE_URL')
        if not url:
            raise ValueError("DATABASE_URL environment variable is required")
        return url
    
    @property
    def secret_key(self) -> str:
        """Get secret key."""
        key = os.getenv('SECRET_KEY')
        if not key:
            raise ValueError("SECRET_KEY environment variable is required")
        if len(key) < 32:
            raise ValueError("SECRET_KEY must be at least 32 characters")
        return key
    
    @property
    def debug(self) -> bool:
        """Get debug mode."""
        return os.getenv('DEBUG', 'False').lower() == 'true'
    
    def _validate(self):
        """Validate configuration."""
        # Check required variables
        required = ['DATABASE_URL', 'SECRET_KEY']
        missing = [var for var in required if not os.getenv(var)]
        if missing:
            raise ValueError(f"Missing required environment variables: {', '.join(missing)}")
```

---

## Project Metadata

### setup.py

```python
# setup.py
"""Package setup configuration."""

from setuptools import setup, find_packages

with open("README.md", "r", encoding="utf-8") as fh:
    long_description = fh.read()

setup(
    name="myproject",
    version="1.0.0",
    author="Your Name",
    author_email="your.email@example.com",
    description="A sample Python project",
    long_description=long_description,
    long_description_content_type="text/markdown",
    url="https://github.com/username/myproject",
    packages=find_packages(),
    classifiers=[
        "Development Status :: 4 - Beta",
        "Intended Audience :: Developers",
        "License :: OSI Approved :: MIT License",
        "Operating System :: OS Independent",
        "Programming Language :: Python :: 3",
        "Programming Language :: Python :: 3.8",
        "Programming Language :: Python :: 3.9",
        "Programming Language :: Python :: 3.10",
    ],
    python_requires=">=3.8",
    install_requires=[
        "requests>=2.25.0",
        "click>=7.0",
    ],
    extras_require={
        "dev": [
            "pytest>=6.0",
            "black>=21.0",
            "flake8>=3.8",
        ],
    },
    entry_points={
        "console_scripts": [
            "myproject=myproject.main:main",
        ],
    },
)
```

### pyproject.toml

```toml
# pyproject.toml
[build-system]
requires = ["setuptools>=45", "wheel"]
build-backend = "setuptools.build_meta"

[project]
name = "myproject"
version = "1.0.0"
description = "A sample Python project"
readme = "README.md"
requires-python = ">=3.8"
license = {text = "MIT"}
authors = [
    {name = "Your Name", email = "your.email@example.com"}
]
keywords = ["python", "example"]
classifiers = [
    "Development Status :: 4 - Beta",
    "Programming Language :: Python :: 3",
]

dependencies = [
    "requests>=2.25.0",
    "click>=7.0",
]

[project.optional-dependencies]
dev = [
    "pytest>=6.0",
    "black>=21.0",
    "flake8>=3.8",
]

[project.scripts]
myproject = "myproject.main:main"

[tool.black]
line-length = 88
target-version = ['py38']

[tool.pytest.ini_options]
testpaths = ["tests"]
python_files = "test_*.py"
```

### setup.cfg

```ini
# setup.cfg
[metadata]
name = myproject
version = 1.0.0
author = Your Name
author_email = your.email@example.com
description = A sample Python project
long_description = file: README.md
long_description_content_type = text/markdown
url = https://github.com/username/myproject
license = MIT
license_files = LICENSE

[options]
packages = find:
python_requires = >=3.8
install_requires =
    requests>=2.25.0
    click>=7.0

[options.extras_require]
dev =
    pytest>=6.0
    black>=21.0
    flake8>=3.8

[options.entry_points]
console_scripts =
    myproject = myproject.main:main

[flake8]
max-line-length = 88
exclude = .git,__pycache__,build,dist
```

---

## Common Project Layouts

### Web Application

```
webapp/
├── README.md
├── requirements.txt
├── .env.example
├── app/
│   ├── __init__.py
│   ├── main.py
│   ├── config.py
│   ├── models/
│   │   ├── __init__.py
│   │   └── user.py
│   ├── routes/
│   │   ├── __init__.py
│   │   └── api.py
│   ├── services/
│   │   ├── __init__.py
│   │   └── auth.py
│   └── templates/
│       └── index.html
├── tests/
│   ├── __init__.py
│   └── test_routes.py
└── migrations/
    └── versions/
```

### CLI Application

```
cli_app/
├── README.md
├── setup.py
├── cli_app/
│   ├── __init__.py
│   ├── main.py
│   ├── commands/
│   │   ├── __init__.py
│   │   ├── init.py
│   │   └── deploy.py
│   └── utils/
│       ├── __init__.py
│       └── helpers.py
└── tests/
    └── test_commands.py
```

### Library Package

```
mylibrary/
├── README.md
├── LICENSE
├── setup.py
├── mylibrary/
│   ├── __init__.py
│   ├── core.py
│   ├── utils.py
│   └── exceptions.py
├── tests/
│   ├── __init__.py
│   ├── test_core.py
│   └── test_utils.py
└── docs/
    └── index.rst
```

---

## Best Practices

### 1. Use Absolute Imports

```python
# GOOD
from myproject.core.models import User
from myproject.utils.helpers import helper_function

# BAD (relative imports can be confusing)
from ..core.models import User
from .helpers import helper_function
```

### 2. Keep Modules Focused

```python
# GOOD: Single responsibility
# models/user.py - User model only
# models/product.py - Product model only

# BAD: Multiple responsibilities
# models.py - All models in one file
```

### 3. Use __init__.py Effectively

```python
# mypackage/__init__.py
"""Package initialization with clear API."""

from .core import CoreClass
from .utils import helper_function

__all__ = ['CoreClass', 'helper_function']
```

### 4. Separate Configuration

```python
# GOOD: Separate config
# config/
#   ├── __init__.py
#   ├── settings.py
#   └── development.py

# BAD: Config in main file
# main.py (contains all config)
```

### 5. Organize Tests

```python
# GOOD: Mirror package structure
# myproject/
#   └── core/
#       └── models.py
# tests/
#   └── core/
#       └── test_models.py

# BAD: All tests in one file
# tests/test_all.py
```

---

## Practical Examples

### Example 1: Complete Project Structure

```
ecommerce/
├── README.md
├── LICENSE
├── setup.py
├── requirements.txt
├── requirements-dev.txt
├── .gitignore
├── .env.example
├── ecommerce/
│   ├── __init__.py
│   ├── main.py
│   ├── config/
│   │   ├── __init__.py
│   │   ├── settings.py
│   │   └── database.py
│   ├── models/
│   │   ├── __init__.py
│   │   ├── user.py
│   │   ├── product.py
│   │   └── order.py
│   ├── api/
│   │   ├── __init__.py
│   │   ├── routes.py
│   │   └── middleware.py
│   ├── services/
│   │   ├── __init__.py
│   │   ├── payment.py
│   │   └── email.py
│   └── utils/
│       ├── __init__.py
│       ├── validators.py
│       └── helpers.py
├── tests/
│   ├── __init__.py
│   ├── conftest.py
│   ├── test_models/
│   │   └── test_user.py
│   ├── test_api/
│   │   └── test_routes.py
│   └── test_services/
│       └── test_payment.py
└── docs/
    └── api.md
```

### Example 2: Configuration Management

```python
# ecommerce/config/settings.py
"""Application settings."""

import os
from pathlib import Path
from dataclasses import dataclass
from typing import Optional

BASE_DIR = Path(__file__).parent.parent.parent

@dataclass
class DatabaseConfig:
    url: str
    pool_size: int = 5
    echo: bool = False

@dataclass
class APIConfig:
    host: str = '0.0.0.0'
    port: int = 8000
    debug: bool = False
    secret_key: str = ''

@dataclass
class Config:
    env: str
    database: DatabaseConfig
    api: APIConfig
    
    @classmethod
    def from_env(cls) -> 'Config':
        """Load configuration from environment."""
        return cls(
            env=os.getenv('ENV', 'development'),
            database=DatabaseConfig(
                url=os.getenv('DATABASE_URL', 'sqlite:///ecommerce.db'),
                pool_size=int(os.getenv('DB_POOL_SIZE', '5')),
                echo=os.getenv('DB_ECHO', 'False').lower() == 'true'
            ),
            api=APIConfig(
                host=os.getenv('API_HOST', '0.0.0.0'),
                port=int(os.getenv('API_PORT', '8000')),
                debug=os.getenv('DEBUG', 'False').lower() == 'true',
                secret_key=os.getenv('SECRET_KEY', '')
            )
        )

# ecommerce/config/__init__.py
"""Configuration package."""

from .settings import Config, get_config

__all__ = ['Config', 'get_config']
```

---

## Practice Exercise

### Exercise: Project Structure

**Objective**: Create a well-structured Python project.

**Requirements**:

1. Create a project with proper structure:
   - Package organization
   - Configuration management
   - Test structure
   - Documentation

2. Project: Task Management System
   - Models for tasks
   - API routes
   - Services
   - Configuration

**Example Solution**:

```
taskmanager/
├── README.md
├── setup.py
├── requirements.txt
├── .gitignore
├── .env.example
├── taskmanager/
│   ├── __init__.py
│   ├── main.py
│   ├── config/
│   │   ├── __init__.py
│   │   └── settings.py
│   ├── models/
│   │   ├── __init__.py
│   │   └── task.py
│   ├── api/
│   │   ├── __init__.py
│   │   └── routes.py
│   ├── services/
│   │   ├── __init__.py
│   │   └── task_service.py
│   └── utils/
│       ├── __init__.py
│       └── validators.py
└── tests/
    ├── __init__.py
    ├── test_models/
    │   └── test_task.py
    └── test_api/
        └── test_routes.py
```

**Files to Create**:

```python
# taskmanager/__init__.py
"""Task Manager Package."""

__version__ = "1.0.0"

# taskmanager/config/settings.py
"""Configuration settings."""

import os
from pathlib import Path

BASE_DIR = Path(__file__).parent.parent.parent

class Config:
    DATABASE_URL = os.getenv('DATABASE_URL', f'sqlite:///{BASE_DIR / "tasks.db"}')
    SECRET_KEY = os.getenv('SECRET_KEY', 'dev-secret-key')
    DEBUG = os.getenv('DEBUG', 'False').lower() == 'true'

# taskmanager/models/task.py
"""Task model."""

from dataclasses import dataclass
from datetime import datetime
from typing import Optional

@dataclass
class Task:
    id: Optional[int]
    title: str
    description: str
    status: str = "pending"
    created_at: datetime = None
    
    def __post_init__(self):
        if self.created_at is None:
            self.created_at = datetime.now()

# taskmanager/api/routes.py
"""API routes."""

from flask import Flask, jsonify, request
from taskmanager.models.task import Task

app = Flask(__name__)

@app.route('/tasks', methods=['GET'])
def get_tasks():
    """Get all tasks."""
    return jsonify([])

@app.route('/tasks', methods=['POST'])
def create_task():
    """Create a task."""
    data = request.json
    return jsonify({'id': 1, **data}), 201

# taskmanager/main.py
"""Application entry point."""

from taskmanager.api.routes import app
from taskmanager.config.settings import Config

if __name__ == '__main__':
    app.config.from_object(Config)
    app.run(debug=Config.DEBUG)
```

**Expected Output**: A complete, well-structured project following best practices.

**Challenge** (Optional):
- Add more models
- Add database integration
- Add authentication
- Add logging
- Add CLI commands
- Add documentation

---

## Key Takeaways

1. **Project Structure** - Organize files logically
2. **Package Structure** - Use packages for modularity
3. **Configuration Management** - Separate config from code
4. **Best Practices** - Follow conventions
5. **Scalability** - Structure for growth
6. **Maintainability** - Easy to navigate and modify
7. **Testing** - Mirror structure in tests
8. **Documentation** - Include README and docs
9. **Metadata** - Use setup.py or pyproject.toml
10. **Environment** - Use environment variables
11. **Separation** - Separate concerns
12. **Conventions** - Follow Python conventions
13. **Imports** - Use absolute imports
14. **Modules** - Keep modules focused
15. **Structure** - Plan structure before coding

---

## Quiz: Architecture

Test your understanding with these questions:

1. **What is a package in Python?**
   - A) A single file
   - B) A directory with __init__.py
   - C) A module
   - D) A function

2. **What should __init__.py contain?**
   - A) Nothing
   - B) Package initialization
   - C) All code
   - D) Only imports

3. **Where should configuration go?**
   - A) In main.py
   - B) In separate config files
   - C) Hardcoded
   - D) In comments

4. **What is the best import style?**
   - A) Relative imports
   - B) Absolute imports
   - C) Wildcard imports
   - D) No imports

5. **How should tests be organized?**
   - A) All in one file
   - B) Mirror package structure
   - C) Randomly
   - D) No tests needed

6. **What is setup.py for?**
   - A) Running code
   - B) Package metadata
   - C) Configuration
   - D) Testing

7. **What should be in .gitignore?**
   - A) All files
   - B) Nothing
   - C) Generated files, __pycache__
   - D) Source code

8. **How to manage environment-specific config?**
   - A) Hardcode
   - B) Use environment variables
   - C) Comment out
   - D) Multiple files

9. **What is pyproject.toml?**
   - A) Old format
   - B) Modern project config
   - C) Not used
   - D) Only for tests

10. **What is the purpose of project structure?**
    - A) Looks good
    - B) Organization and maintainability
    - C) Required by Python
    - D) No purpose

**Answers**:
1. B) A directory with __init__.py (package definition)
2. B) Package initialization (__init__.py purpose)
3. B) In separate config files (configuration best practice)
4. B) Absolute imports (import best practice)
5. B) Mirror package structure (test organization)
6. B) Package metadata (setup.py purpose)
7. C) Generated files, __pycache__ (gitignore content)
8. B) Use environment variables (environment config)
9. B) Modern project config (pyproject.toml purpose)
10. B) Organization and maintainability (structure purpose)

---

## Next Steps

Excellent work! You've mastered project structure. You now understand:
- Organizing large projects
- Package structure
- Configuration management
- Project best practices

**What's Next?**
- Lesson 26.2: Dependency Management
- Learn pip and requirements.txt
- Understand virtual environments
- Use Poetry or pipenv

---

## Additional Resources

- **PEP 8**: Python style guide
- **PEP 420**: Implicit namespace packages
- **setuptools**: Package building
- **Python Packaging**: Official packaging guide
- **Project Structure**: Best practices

---

*Lesson completed! You're ready to move on to the next lesson.*

