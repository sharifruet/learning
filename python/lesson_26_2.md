# Lesson 26.2: Dependency Management

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand Python dependency management
- Use pip and requirements.txt
- Create and manage virtual environments
- Use venv for isolation
- Understand Poetry and pipenv
- Manage project dependencies effectively
- Handle dependency conflicts
- Lock dependency versions
- Reproduce environments
- Best practices for dependency management

---

## Introduction to Dependency Management

**Dependency Management** is the process of managing external libraries and packages that your Python project depends on.

**Key Concepts**:
- **Dependencies**: External packages your project needs
- **Virtual Environments**: Isolated Python environments
- **Version Pinning**: Locking specific versions
- **Dependency Resolution**: Resolving conflicts
- **Reproducibility**: Same environment everywhere

**Benefits**:
- **Isolation**: Avoid conflicts between projects
- **Reproducibility**: Same environment for all developers
- **Version Control**: Track dependencies
- **Security**: Update vulnerable packages
- **Collaboration**: Share dependency lists

---

## pip and requirements.txt

### pip Basics

**pip** (Pip Installs Packages) is Python's package installer.

```bash
# Install a package
pip install requests

# Install specific version
pip install requests==2.25.0

# Install version range
pip install "requests>=2.25.0,<3.0.0"

# Install from requirements file
pip install -r requirements.txt

# Uninstall package
pip uninstall requests

# List installed packages
pip list

# Show package info
pip show requests

# Search packages
pip search requests  # Note: search is deprecated

# Upgrade package
pip install --upgrade requests

# Install in user directory
pip install --user requests
```

### requirements.txt

**requirements.txt** is a text file listing project dependencies.

**Basic Format**:
```txt
# requirements.txt
requests==2.25.0
flask==2.0.0
sqlalchemy==1.4.0
```

**Version Specifiers**:
```txt
# Exact version
requests==2.25.0

# Minimum version
requests>=2.25.0

# Version range
requests>=2.25.0,<3.0.0

# Compatible release (same major version)
requests~=2.25.0  # >=2.25.0,<3.0.0

# Any version (not recommended)
requests
```

**Complete requirements.txt Example**:
```txt
# requirements.txt
# Web framework
flask==2.0.0
flask-restful==0.3.9

# Database
sqlalchemy==1.4.0
psycopg2-binary==2.9.0

# HTTP client
requests>=2.25.0,<3.0.0

# Testing
pytest==6.2.5
pytest-cov==2.12.1

# Code quality
black==21.6b0
flake8==3.9.2

# Environment variables
python-dotenv==0.19.0
```

### Generating requirements.txt

```bash
# Generate from current environment
pip freeze > requirements.txt

# Include only packages you installed (not dependencies)
pip freeze | grep -v "^--" > requirements.txt

# Generate with hashes (for security)
pip freeze --all > requirements.txt
```

### Installing from requirements.txt

```bash
# Install all dependencies
pip install -r requirements.txt

# Install without cache
pip install --no-cache-dir -r requirements.txt

# Install in editable mode (for local packages)
pip install -e .
```

### Separate Requirements Files

**Development vs Production**:
```txt
# requirements.txt (production)
flask==2.0.0
requests==2.25.0
sqlalchemy==1.4.0

# requirements-dev.txt (development)
-r requirements.txt
pytest==6.2.5
black==21.6b0
flake8==3.9.2
ipython==7.16.0
```

**Installation**:
```bash
# Production
pip install -r requirements.txt

# Development
pip install -r requirements-dev.txt
```

### Requirements with Comments

```txt
# requirements.txt
# Core dependencies
flask==2.0.0
sqlalchemy==1.4.0

# Optional: Database drivers
# Uncomment the one you need:
# psycopg2-binary==2.9.0  # PostgreSQL
# pymysql==1.0.2           # MySQL

# Development tools
pytest==6.2.5
black==21.6b0
```

---

## virtualenv and venv

### Why Virtual Environments?

**Problems without virtual environments**:
- Global package conflicts
- Different projects need different versions
- System Python pollution
- Difficult to reproduce environments

**Benefits of virtual environments**:
- Isolated environments per project
- No conflicts between projects
- Easy to reproduce
- Easy to delete and recreate

### venv (Built-in)

**venv** is Python's built-in virtual environment tool (Python 3.3+).

**Creating a Virtual Environment**:
```bash
# Create virtual environment
python -m venv venv

# Create with specific Python version
python3.9 -m venv venv

# Create with system site-packages (not recommended)
python -m venv venv --system-site-packages
```

**Activating Virtual Environment**:

**Linux/macOS**:
```bash
source venv/bin/activate
```

**Windows**:
```bash
venv\Scripts\activate
```

**Deactivating**:
```bash
deactivate
```

**Complete Workflow**:
```bash
# Create virtual environment
python -m venv venv

# Activate
source venv/bin/activate  # Linux/macOS
# or
venv\Scripts\activate  # Windows

# Install packages
pip install requests flask

# Generate requirements
pip freeze > requirements.txt

# Deactivate when done
deactivate
```

### virtualenv (Third-party)

**virtualenv** is a third-party tool (more features than venv).

**Installation**:
```bash
pip install virtualenv
```

**Usage**:
```bash
# Create virtual environment
virtualenv venv

# Create with specific Python version
virtualenv -p python3.9 venv

# Create with system packages
virtualenv --system-site-packages venv

# Activate (same as venv)
source venv/bin/activate  # Linux/macOS
venv\Scripts\activate     # Windows
```

### Virtual Environment Best Practices

```bash
# 1. Always use virtual environments
python -m venv venv
source venv/bin/activate

# 2. Add venv to .gitignore
echo "venv/" >> .gitignore
echo "__pycache__/" >> .gitignore
echo "*.pyc" >> .gitignore

# 3. Install dependencies
pip install -r requirements.txt

# 4. Update requirements when adding packages
pip freeze > requirements.txt

# 5. Use consistent naming
# Good: venv, .venv, env
# Bad: myenv, project_env, virtual_environment
```

### Virtual Environment Structure

```
project/
├── venv/              # Virtual environment (gitignored)
│   ├── bin/           # Executables (Linux/macOS)
│   ├── Scripts/       # Executables (Windows)
│   ├── lib/           # Installed packages
│   └── pyvenv.cfg     # Configuration
├── requirements.txt
├── .gitignore
└── src/
```

---

## Poetry

### Introduction to Poetry

**Poetry** is a modern dependency management and packaging tool.

**Features**:
- Dependency resolution
- Lock file for reproducible builds
- Project management
- Publishing to PyPI
- Virtual environment management

**Installation**:
```bash
# Linux/macOS
curl -sSL https://install.python-poetry.org | python3 -

# Windows (PowerShell)
(Invoke-WebRequest -Uri https://install.python-poetry.org -UseBasicParsing).Content | python -

# Or with pip (not recommended for production)
pip install poetry
```

### Poetry Basics

**Initialize Project**:
```bash
# Create new project
poetry new myproject

# Initialize in existing project
poetry init
```

**pyproject.toml** (Poetry configuration):
```toml
[tool.poetry]
name = "myproject"
version = "0.1.0"
description = ""
authors = ["Your Name <you@example.com>"]

[tool.poetry.dependencies]
python = "^3.8"
requests = "^2.25.0"
flask = "^2.0.0"

[tool.poetry.dev-dependencies]
pytest = "^6.2.5"
black = "^21.6b0"

[build-system]
requires = ["poetry-core>=1.0.0"]
build-backend = "poetry.core.masonry.api"
```

### Poetry Commands

```bash
# Add dependency
poetry add requests
poetry add "requests>=2.25.0"

# Add development dependency
poetry add --dev pytest
poetry add --group dev pytest  # Poetry 1.2+

# Remove dependency
poetry remove requests

# Install dependencies
poetry install

# Install without dev dependencies
poetry install --no-dev

# Update dependencies
poetry update

# Update specific package
poetry update requests

# Show dependencies
poetry show

# Show dependency tree
poetry show --tree

# Run commands in virtual environment
poetry run python script.py
poetry run pytest

# Activate virtual environment
poetry shell

# Export to requirements.txt
poetry export -f requirements.txt --output requirements.txt
poetry export -f requirements.txt --output requirements-dev.txt --with dev
```

### Poetry Lock File

**poetry.lock** ensures reproducible installs:

```bash
# Generate lock file
poetry lock

# Install from lock file
poetry install

# Update lock file
poetry lock --no-update
```

### Poetry Virtual Environment

```bash
# Poetry manages virtual environments automatically
# Location: ~/.cache/pypoetry/virtualenvs/ (default)

# Show virtual environment path
poetry env info

# List virtual environments
poetry env list

# Remove virtual environment
poetry env remove python3.9
```

### Poetry Example Workflow

```bash
# 1. Initialize project
poetry init

# 2. Add dependencies
poetry add flask requests

# 3. Add dev dependencies
poetry add --dev pytest black

# 4. Install all dependencies
poetry install

# 5. Run code
poetry run python app.py

# 6. Run tests
poetry run pytest

# 7. Update dependencies
poetry update

# 8. Export requirements (if needed)
poetry export -f requirements.txt --output requirements.txt
```

---

## pipenv

### Introduction to pipenv

**pipenv** combines pip and virtualenv with dependency management.

**Features**:
- Automatic virtual environment management
- Pipfile for dependencies
- Pipfile.lock for reproducibility
- Security vulnerability scanning

**Installation**:
```bash
pip install pipenv
```

### Pipenv Basics

**Initialize Project**:
```bash
# Create Pipfile
pipenv install

# Install package
pipenv install requests

# Install dev dependency
pipenv install pytest --dev

# Install from requirements.txt
pipenv install -r requirements.txt
```

**Pipfile** (pipenv configuration):
```toml
[[source]]
url = "https://pypi.org/simple"
verify_ssl = true
name = "pypi"

[packages]
requests = "*"
flask = "==2.0.0"

[dev-packages]
pytest = "*"
black = "*"

[requires]
python_version = "3.9"
```

### Pipenv Commands

```bash
# Install dependencies
pipenv install

# Install dev dependencies
pipenv install --dev

# Uninstall package
pipenv uninstall requests

# Update package
pipenv update requests

# Update all packages
pipenv update

# Show dependency graph
pipenv graph

# Show virtual environment path
pipenv --venv

# Activate virtual environment
pipenv shell

# Run command in virtual environment
pipenv run python script.py
pipenv run pytest

# Lock dependencies
pipenv lock

# Install from lock file
pipenv install --ignore-pipfile

# Check for security vulnerabilities
pipenv check

# Generate requirements.txt
pipenv requirements > requirements.txt
pipenv requirements --dev > requirements-dev.txt
```

### Pipfile.lock

**Pipfile.lock** ensures reproducible installs:

```bash
# Generate lock file
pipenv lock

# Install from lock file
pipenv install --ignore-pipfile
```

### Pipenv Example Workflow

```bash
# 1. Initialize project
pipenv install

# 2. Install dependencies
pipenv install flask requests

# 3. Install dev dependencies
pipenv install pytest --dev

# 4. Lock dependencies
pipenv lock

# 5. Run code
pipenv run python app.py

# 6. Run tests
pipenv run pytest

# 7. Activate shell
pipenv shell

# 8. Check security
pipenv check
```

---

## Comparison: Poetry vs pipenv vs pip+venv

### pip + venv

**Pros**:
- Built into Python
- Simple and straightforward
- Widely used and understood
- No additional tools needed

**Cons**:
- Manual dependency resolution
- No lock file by default
- More manual work

**Best for**: Simple projects, learning, minimal dependencies

### Poetry

**Pros**:
- Excellent dependency resolution
- Lock file for reproducibility
- Project management built-in
- Can publish to PyPI
- Modern tooling

**Cons**:
- Additional tool to learn
- Different workflow
- Can be overkill for simple projects

**Best for**: Libraries, packages, complex projects, publishing

### pipenv

**Pros**:
- Combines pip and virtualenv
- Automatic virtual environment
- Security scanning
- Lock file support

**Cons**:
- Slower dependency resolution
- Less active development
- Can be slower than alternatives

**Best for**: Applications, teams using Pipfile

---

## Best Practices

### 1. Always Use Virtual Environments

```bash
# Good
python -m venv venv
source venv/bin/activate
pip install -r requirements.txt

# Bad
pip install requests  # Installs globally
```

### 2. Pin Versions

```txt
# Good: Specific versions
requests==2.25.0
flask==2.0.0

# Acceptable: Minimum versions
requests>=2.25.0

# Bad: No version
requests
```

### 3. Separate Dev Dependencies

```txt
# requirements.txt (production)
flask==2.0.0
requests==2.25.0

# requirements-dev.txt (development)
-r requirements.txt
pytest==6.2.5
black==21.6b0
```

### 4. Use Lock Files

```bash
# Poetry
poetry lock

# Pipenv
pipenv lock

# pip (with pip-tools)
pip-compile requirements.in
```

### 5. Update Regularly

```bash
# Check for updates
pip list --outdated

# Update carefully
pip install --upgrade package-name

# Test after updates
pytest
```

### 6. Document Dependencies

```txt
# requirements.txt
# Web framework
flask==2.0.0

# HTTP client
requests==2.25.0

# Database
sqlalchemy==1.4.0
```

### 7. Use .gitignore

```gitignore
# .gitignore
venv/
env/
.venv/
*.pyc
__pycache__/
.pytest_cache/
.coverage
*.egg-info/
dist/
build/
```

---

## Common Issues and Solutions

### Issue 1: Dependency Conflicts

**Problem**: Two packages require different versions of the same dependency.

**Solution**:
```bash
# Check conflicts
pip check

# Use virtual environment
python -m venv venv
source venv/bin/activate

# Try different versions
pip install package1==1.0.0 package2==2.0.0

# Use dependency resolver (Poetry/pipenv)
poetry add package1 package2  # Automatically resolves
```

### Issue 2: "Package not found"

**Problem**: Package not available on PyPI.

**Solution**:
```bash
# Install from Git
pip install git+https://github.com/user/repo.git

# Install from local directory
pip install /path/to/package

# Install from wheel
pip install package.whl
```

### Issue 3: Version Mismatches

**Problem**: Installed version doesn't match requirements.

**Solution**:
```bash
# Reinstall from requirements
pip install -r requirements.txt --force-reinstall

# Clear cache
pip cache purge

# Reinstall
pip install -r requirements.txt
```

### Issue 4: Slow Installation

**Problem**: pip install is slow.

**Solution**:
```bash
# Use cache
pip install --cache-dir /tmp/pip-cache

# Use faster index
pip install -i https://pypi.org/simple package

# Use pip-tools for faster resolution
pip install pip-tools
pip-compile requirements.in
```

---

## Practical Examples

### Example 1: Complete pip Workflow

```bash
# 1. Create project
mkdir myproject
cd myproject

# 2. Create virtual environment
python -m venv venv
source venv/bin/activate  # Linux/macOS
# venv\Scripts\activate   # Windows

# 3. Create requirements.txt
cat > requirements.txt << EOF
flask==2.0.0
requests>=2.25.0
sqlalchemy==1.4.0
EOF

# 4. Install dependencies
pip install -r requirements.txt

# 5. Add dev requirements
cat > requirements-dev.txt << EOF
-r requirements.txt
pytest==6.2.5
black==21.6b0
EOF

# 6. Install dev dependencies
pip install -r requirements-dev.txt

# 7. Update requirements
pip freeze > requirements.txt
```

### Example 2: Complete Poetry Workflow

```bash
# 1. Create project
poetry new myproject
cd myproject

# 2. Add dependencies
poetry add flask requests sqlalchemy

# 3. Add dev dependencies
poetry add --dev pytest black

# 4. Install all
poetry install

# 5. Update dependencies
poetry update

# 6. Show dependency tree
poetry show --tree

# 7. Run code
poetry run python app.py

# 8. Export requirements (if needed)
poetry export -f requirements.txt --output requirements.txt
```

### Example 3: Complete pipenv Workflow

```bash
# 1. Create project
mkdir myproject
cd myproject

# 2. Initialize pipenv
pipenv install

# 3. Install dependencies
pipenv install flask requests sqlalchemy

# 4. Install dev dependencies
pipenv install pytest black --dev

# 5. Lock dependencies
pipenv lock

# 6. Install from lock
pipenv install --ignore-pipfile

# 7. Run code
pipenv run python app.py

# 8. Check security
pipenv check
```

---

## Practice Exercise

### Exercise: Dependencies

**Objective**: Set up dependency management for a project.

**Requirements**:

1. Create a project with proper dependency management:
   - Virtual environment
   - requirements.txt
   - Dev dependencies
   - Lock file (if using Poetry/pipenv)

2. Project: Web API with Flask
   - Flask for web framework
   - SQLAlchemy for database
   - pytest for testing
   - black for formatting

**Example Solution**:

```bash
# 1. Create project structure
mkdir flask-api
cd flask-api
python -m venv venv
source venv/bin/activate

# 2. Create requirements.txt
cat > requirements.txt << EOF
flask==2.0.0
sqlalchemy==1.4.0
python-dotenv==0.19.0
EOF

# 3. Create requirements-dev.txt
cat > requirements-dev.txt << EOF
-r requirements.txt
pytest==6.2.5
pytest-cov==2.12.1
black==21.6b0
flake8==3.9.2
EOF

# 4. Install dependencies
pip install -r requirements-dev.txt

# 5. Verify installation
pip list

# 6. Create .gitignore
cat > .gitignore << EOF
venv/
__pycache__/
*.pyc
.env
*.db
EOF

# 7. Test installation
python -c "import flask; import sqlalchemy; print('All dependencies installed!')"
```

**Poetry Solution**:

```bash
# 1. Initialize Poetry project
poetry init

# 2. Add dependencies
poetry add flask sqlalchemy python-dotenv

# 3. Add dev dependencies
poetry add --dev pytest pytest-cov black flake8

# 4. Install all
poetry install

# 5. Verify
poetry show --tree
```

**Expected Output**: A project with properly managed dependencies.

**Challenge** (Optional):
- Add more dependencies
- Create separate environments
- Use Poetry or pipenv
- Set up CI/CD with dependency installation
- Add dependency security scanning

---

## Key Takeaways

1. **Dependency Management** - Essential for Python projects
2. **pip** - Python package installer
3. **requirements.txt** - List of dependencies
4. **Virtual Environments** - Isolate project dependencies
5. **venv** - Built-in virtual environment tool
6. **Poetry** - Modern dependency management
7. **pipenv** - Combines pip and virtualenv
8. **Version Pinning** - Lock specific versions
9. **Lock Files** - Ensure reproducibility
10. **Best Practices** - Always use venv, pin versions, separate dev deps
11. **Common Issues** - Conflicts, missing packages, version mismatches
12. **Workflow** - Create venv, install deps, update requirements
13. **Security** - Update regularly, check vulnerabilities
14. **Documentation** - Document all dependencies
15. **Reproducibility** - Use lock files for consistent environments

---

## Quiz: Dependency Management

Test your understanding with these questions:

1. **What is pip?**
   - A) Virtual environment
   - B) Package installer
   - C) Package manager
   - D) Both B and C

2. **What is requirements.txt?**
   - A) Package list
   - B) Dependency file
   - C) Configuration file
   - D) All of the above

3. **Why use virtual environments?**
   - A) Isolation
   - B) Avoid conflicts
   - C) Reproducibility
   - D) All of the above

4. **What is venv?**
   - A) Third-party tool
   - B) Built-in Python tool
   - C) Package manager
   - D) Dependency resolver

5. **What does Poetry provide?**
   - A) Dependency resolution
   - B) Lock files
   - C) Project management
   - D) All of the above

6. **What is pipenv?**
   - A) Combines pip and virtualenv
   - B) Dependency manager
   - C) Uses Pipfile
   - D) All of the above

7. **How to install from requirements.txt?**
   - A) pip install requirements.txt
   - B) pip install -r requirements.txt
   - C) pip requirements.txt
   - D) install -r requirements.txt

8. **What is a lock file?**
   - A) Exact versions
   - B) Reproducible installs
   - C) Dependency tree
   - D) All of the above

9. **Best practice for versions?**
   - A) Pin exact versions
   - B) Use ranges
   - C) No versions
   - D) Any version

10. **What should be in .gitignore?**
    - A) venv/
    - B) __pycache__/
    - C) *.pyc
    - D) All of the above

**Answers**:
1. D) Both B and C (pip is package installer/manager)
2. B) Dependency file (requirements.txt purpose)
3. D) All of the above (virtual environment benefits)
4. B) Built-in Python tool (venv definition)
5. D) All of the above (Poetry features)
6. D) All of the above (pipenv features)
7. B) pip install -r requirements.txt (correct command)
8. D) All of the above (lock file purpose)
9. A) Pin exact versions (best practice)
10. D) All of the above (gitignore content)

---

## Next Steps

Excellent work! You've mastered dependency management. You now understand:
- pip and requirements.txt
- virtualenv and venv
- Poetry and pipenv
- Best practices for dependencies

**What's Next?**
- Continue with Module 26 or move to other modules
- Learn deployment and DevOps
- Understand CI/CD pipelines
- Explore advanced topics

---

## Additional Resources

- **pip Documentation**: Official pip guide
- **venv Documentation**: Python venv module
- **Poetry Documentation**: poetry.eustace.io
- **pipenv Documentation**: pipenv.pypa.io
- **Python Packaging**: packaging.python.org

---

*Lesson completed! You're ready to manage dependencies effectively.*

