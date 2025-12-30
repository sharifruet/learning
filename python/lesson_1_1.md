# Lesson 1.1: Introduction to Python

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what Python is and its key characteristics
- Explain why Python is a valuable programming language to learn
- Identify different Python versions and their differences
- Install Python on your system
- Set up a development environment
- Write and run your first Python program

---

## What is Python?

Python is a high-level, interpreted programming language known for its simplicity and readability. Created by Guido van Rossum and first released in 1991, Python has become one of the most popular programming languages in the world.

### Key Characteristics of Python

1. **Interpreted Language**: Python code is executed line by line by an interpreter, which means you don't need to compile your code before running it.

2. **High-Level Language**: Python abstracts away low-level details, allowing you to focus on solving problems rather than managing memory or system resources.

3. **Dynamically Typed**: You don't need to declare variable types explicitly. Python determines the type automatically based on the value assigned.

4. **Readable Syntax**: Python's syntax is designed to be clear and readable, often described as "executable pseudocode."

5. **Multi-Paradigm**: Python supports multiple programming paradigms including:
   - Object-Oriented Programming (OOP)
   - Procedural Programming
   - Functional Programming

6. **Extensive Standard Library**: Python comes with a large standard library that provides modules for many common tasks, from file handling to web development.

7. **Cross-Platform**: Python runs on Windows, macOS, Linux, and many other operating systems.

### Python's Philosophy

Python follows a set of principles known as "The Zen of Python" (PEP 20), which emphasizes:
- Readability counts
- Simple is better than complex
- There should be one obvious way to do things
- Code should be beautiful and elegant

---

## Why Learn Python?

Python has become one of the most in-demand programming languages for several compelling reasons:

### 1. **Versatility**

Python is used in diverse fields:
- **Web Development**: Frameworks like Django and Flask
- **Data Science**: Libraries like NumPy, Pandas, and Matplotlib
- **Machine Learning & AI**: TensorFlow, PyTorch, scikit-learn
- **Automation & Scripting**: Task automation and system administration
- **Game Development**: Pygame and other game frameworks
- **Desktop Applications**: Tkinter, PyQt
- **Cybersecurity**: Security tools and penetration testing
- **Scientific Computing**: Research and analysis

### 2. **Easy to Learn**

Python's syntax is intuitive and beginner-friendly. Many programming concepts are easier to understand in Python compared to other languages.

### 3. **Strong Job Market**

Python developers are in high demand across industries. According to various job market reports, Python consistently ranks among the top programming languages by job postings and salary.

### 4. **Large Community**

Python has a massive, active community that provides:
- Extensive documentation
- Helpful forums and communities
- Thousands of open-source packages
- Regular updates and improvements

### 5. **Rapid Development**

Python allows you to build applications quickly, making it ideal for prototyping and rapid development cycles.

### 6. **Excellent for Beginners**

Python is often recommended as a first programming language because:
- Clear, readable syntax
- Immediate feedback (no compilation step)
- Extensive learning resources
- Gentle learning curve

---

## Python Versions and Installation

### Python Version History

Python has two major version lines:

1. **Python 2.x** (Legacy - No longer maintained)
   - Final version: Python 2.7 (released in 2010)
   - End of life: January 1, 2020
   - **Important**: Do not use Python 2 for new projects

2. **Python 3.x** (Current and Recommended)
   - First released: 2008
   - Current stable version: Python 3.12+ (as of 2024)
   - Actively maintained and improved
   - **This is what you should learn and use**

### Key Differences Between Python 2 and 3

- Print statement vs. print function
- String handling (Unicode by default in Python 3)
- Integer division behavior
- Syntax improvements

**Always use Python 3 for new projects!**

### Installing Python

#### Windows

1. **Download Python**:
   - Visit [python.org/downloads](https://www.python.org/downloads/)
   - Download the latest Python 3.x installer
   - Choose the Windows installer (64-bit recommended)

2. **Run the Installer**:
   - Check "Add Python to PATH" (IMPORTANT!)
   - Click "Install Now"
   - Wait for installation to complete

3. **Verify Installation**:
   - Open Command Prompt (cmd)
   - Type: `python --version`
   - You should see: `Python 3.x.x`

#### macOS

**Option 1: Official Installer**
1. Visit [python.org/downloads](https://www.python.org/downloads/)
2. Download the macOS installer
3. Run the installer package
4. Follow the installation wizard

**Option 2: Using Homebrew** (Recommended for developers)
```bash
brew install python3
```

**Verify Installation**:
```bash
python3 --version
```

#### Linux

Most Linux distributions come with Python pre-installed. To install or update:

**Ubuntu/Debian**:
```bash
sudo apt update
sudo apt install python3 python3-pip
```

**Fedora/RHEL**:
```bash
sudo dnf install python3 python3-pip
```

**Verify Installation**:
```bash
python3 --version
```

### Checking Your Python Installation

After installation, verify Python is working correctly:

**Windows**:
```bash
python --version
python -c "print('Hello, Python!')"
```

**macOS/Linux**:
```bash
python3 --version
python3 -c "print('Hello, Python!')"
```

---

## Setting Up Your Development Environment

A good development environment makes coding easier and more efficient. Here are the essential components:

### 1. **Python Interpreter**

You've already installed this! The Python interpreter is what runs your Python code.

### 2. **Code Editor or IDE**

Choose one that fits your needs:

#### **Beginner-Friendly Options**:

**Visual Studio Code (VS Code)** (Recommended)
- Free and open-source
- Excellent Python support
- Extensions available
- Cross-platform
- Download: [code.visualstudio.com](https://code.visualstudio.com/)

**PyCharm Community Edition**
- Free version available
- Built specifically for Python
- Powerful features
- Download: [jetbrains.com/pycharm](https://www.jetbrains.com/pycharm/)

**Sublime Text**
- Lightweight and fast
- Great for beginners
- Download: [sublimetext.com](https://www.sublimetext.com/)

#### **Simple Options**:

**IDLE** (Included with Python)
- Comes with Python installation
- Simple and basic
- Good for absolute beginners
- Limited features

**Notepad++** (Windows)
- Simple text editor
- Syntax highlighting
- Free

### 3. **Installing VS Code Python Extension**

If you choose VS Code:

1. Open VS Code
2. Click the Extensions icon (or press `Ctrl+Shift+X` / `Cmd+Shift+X`)
3. Search for "Python"
4. Install the official "Python" extension by Microsoft
5. This provides:
   - Syntax highlighting
   - Code completion
   - Debugging support
   - Linting

### 4. **Terminal/Command Line**

You'll use the terminal to run Python programs:

- **Windows**: Command Prompt or PowerShell
- **macOS**: Terminal (built-in)
- **Linux**: Terminal (built-in)

### 5. **Package Manager: pip**

pip comes with Python 3.4+ and is used to install Python packages.

**Verify pip is installed**:
```bash
# Windows
pip --version

# macOS/Linux
pip3 --version
```

**Update pip** (recommended):
```bash
# Windows
python -m pip install --upgrade pip

# macOS/Linux
python3 -m pip install --upgrade pip
```

### Recommended Setup for Beginners

1. **Python 3.x** (latest stable version)
2. **Visual Studio Code** with Python extension
3. **Terminal/Command Prompt** for running programs
4. **A dedicated folder** for your Python projects

---

## Your First Python Program: Hello World

The traditional first program in any programming language is "Hello, World!" - a simple program that displays a greeting.

### Method 1: Using Python Interactively (Python Shell)

You can run Python code directly in the interactive shell:

1. **Open Terminal/Command Prompt**

2. **Start Python**:
   ```bash
   # Windows
   python
   
   # macOS/Linux
   python3
   ```

3. **You'll see the Python prompt** (`>>>`):
   ```python
   Python 3.12.0 (default, Oct  2 2023, 12:00:00)
   [Clang 14.0.0] on darwin
   Type "help", "copyright", "credits" or "license" for more information.
   >>>
   ```

4. **Type your first command**:
   ```python
   print("Hello, World!")
   ```

5. **Press Enter**. You should see:
   ```
   Hello, World!
   ```

6. **Exit Python**:
   ```python
   exit()
   ```
   Or press `Ctrl+D` (macOS/Linux) or `Ctrl+Z` then Enter (Windows)

### Method 2: Creating a Python File

For real programs, you'll write code in files:

1. **Create a new file** named `hello.py`

2. **Open it in your code editor** and type:
   ```python
   print("Hello, World!")
   ```

3. **Save the file**

4. **Run it from terminal**:
   ```bash
   # Windows
   python hello.py
   
   # macOS/Linux
   python3 hello.py
   ```

5. **Output**:
   ```
   Hello, World!
   ```

### Understanding the Code

Let's break down what happened:

```python
print("Hello, World!")
```

- `print` is a built-in Python function that displays output
- `"Hello, World!"` is a string (text) enclosed in quotation marks
- The parentheses contain the argument(s) passed to the function
- The exclamation mark at the end indicates the end of the statement

### Variations of Hello World

Try these variations to see different ways to use print:

```python
# Simple print
print("Hello, World!")

# Print with single quotes (also works)
print('Hello, World!')

# Print multiple items
print("Hello,", "World!")

# Print without quotes (for numbers)
print(42)

# Print multiple lines
print("Hello,")
print("World!")

# Print with escape characters
print("Hello,\nWorld!")  # \n creates a new line
```

### Running Your Program

**Step-by-step process**:

1. **Write your code** in a `.py` file
2. **Save the file** (e.g., `hello.py`)
3. **Open terminal/command prompt**
4. **Navigate to the file location**:
   ```bash
   cd /path/to/your/file
   ```
5. **Run the program**:
   ```bash
   python hello.py  # Windows
   python3 hello.py  # macOS/Linux
   ```

### Common Issues and Solutions

**Issue**: `python: command not found` or `python3: command not found`
- **Solution**: Python may not be in your PATH. Reinstall Python and check "Add to PATH" (Windows) or use `python3` explicitly (macOS/Linux)

**Issue**: `SyntaxError: invalid syntax`
- **Solution**: Check for typos, missing quotes, or incorrect indentation

**Issue**: File runs but nothing happens
- **Solution**: Make sure you're using `print()` to display output

**Issue**: Can't find the file
- **Solution**: Make sure you're in the correct directory. Use `cd` to navigate to your file's location

---

## Practice Exercise

### Exercise: Write and Run Your First Program

**Objective**: Create a Python program that introduces yourself.

**Instructions**:

1. Create a new file called `introduction.py`

2. Write a program that:
   - Prints your name
   - Prints your favorite programming language (hint: it's Python!)
   - Prints a fun fact about yourself
   - Uses at least 3 different print statements

3. Save the file

4. Run the program and verify the output

**Example Solution**:

```python
print("My name is [Your Name]")
print("My favorite programming language is Python!")
print("I'm excited to learn Python programming.")
```

**Expected Output** (with your information):
```
My name is [Your Name]
My favorite programming language is Python!
I'm excited to learn Python programming.
```

**Challenge** (Optional):
- Try printing everything in a single print statement
- Add emojis or special characters
- Print your name and age on the same line

---

## Key Takeaways

1. **Python** is a versatile, beginner-friendly programming language
2. **Python 3** is the current version you should use (not Python 2)
3. **Installation** varies by operating system but is straightforward
4. **Development environment** includes Python, a code editor, and terminal
5. **print()** function displays output to the screen
6. **Python files** use the `.py` extension
7. **Running Python** can be done interactively or from files

---

## Quiz: Python Basics

Test your understanding with these questions:

1. **What is Python?**
   - A) A snake
   - B) A high-level programming language
   - C) A web browser
   - D) An operating system

2. **Which Python version should you use for new projects?**
   - A) Python 2.7
   - B) Python 3.x
   - C) Both are fine
   - D) It doesn't matter

3. **What does the print() function do?**
   - A) Reads input from the user
   - B) Displays output to the screen
   - C) Performs calculations
   - D) Creates files

4. **What extension do Python files use?**
   - A) .txt
   - B) .py
   - C) .python
   - D) .exe

5. **True or False: Python code must be compiled before running.**
   - A) True
   - B) False

6. **Which of these is NOT a characteristic of Python?**
   - A) Interpreted language
   - B) Dynamically typed
   - C) Must be compiled
   - D) Readable syntax

**Answers**:
1. B) A high-level programming language
2. B) Python 3.x
3. B) Displays output to the screen
4. B) .py
5. B) False (Python is interpreted, not compiled)
6. C) Must be compiled

---

## Next Steps

Congratulations! You've completed your first Python lesson. You now know:
- What Python is and why it's valuable
- How to install Python
- How to set up a development environment
- How to write and run your first Python program

**What's Next?**
- Lesson 1.2: Python Syntax and Basics
- Practice writing more programs
- Experiment with different print() variations
- Explore your code editor's features

---

## Additional Resources

- **Official Python Documentation**: [docs.python.org](https://docs.python.org/)
- **Python.org Tutorial**: [docs.python.org/3/tutorial](https://docs.python.org/3/tutorial/)
- **Python Installation Guide**: [python.org/about/gettingstarted](https://www.python.org/about/gettingstarted/)
- **VS Code Python Tutorial**: [code.visualstudio.com/docs/languages/python](https://code.visualstudio.com/docs/languages/python)

---

*Lesson completed! You're ready to move on to the next lesson.*

