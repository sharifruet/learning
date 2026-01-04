# Lesson 19.2: Flask Framework

## Learning Objectives

By the end of this lesson, you will be able to:
- Install and set up Flask
- Create Flask applications
- Define routes and views
- Use templates
- Handle requests and responses
- Work with URL parameters
- Use request methods
- Apply Flask best practices
- Debug Flask applications
- Build basic web applications

---

## Introduction to Flask

**Flask** is a lightweight Python web framework that makes it easy to build web applications. It's known for its simplicity and flexibility.

### Why Flask?

- **Simple**: Easy to learn and use
- **Lightweight**: Minimal dependencies
- **Flexible**: No enforced structure
- **Extensible**: Many extensions available
- **Pythonic**: Follows Python conventions

### What is Flask?

Flask is a micro web framework written in Python. It provides tools, libraries, and technologies to build web applications.

---

## Flask Installation and Setup

### Installing Flask

```bash
# Install Flask
pip install flask

# Or with requirements.txt
pip install -r requirements.txt
```

### Basic Flask Application

```python
from flask import Flask

app = Flask(__name__)

@app.route('/')
def hello():
    return 'Hello, World!'

if __name__ == '__main__':
    app.run(debug=True)
```

### Running Flask Application

```bash
# Run the application
python app.py

# Or use Flask CLI
flask run

# With debug mode
flask run --debug
```

### Project Structure

```
myapp/
├── app.py
├── templates/
│   └── index.html
├── static/
│   ├── css/
│   └── js/
└── requirements.txt
```

---

## Routes and Views

### Basic Route

A **route** maps a URL to a Python function (view):

```python
from flask import Flask

app = Flask(__name__)

@app.route('/')
def index():
    return 'Home Page'

@app.route('/about')
def about():
    return 'About Page'
```

### URL Parameters

Capture URL parameters:

```python
@app.route('/user/<username>')
def show_user(username):
    return f'User: {username}'

@app.route('/post/<int:post_id>')
def show_post(post_id):
    return f'Post ID: {post_id}'
```

### URL Parameter Types

```python
# String (default)
@app.route('/user/<name>')
def user(name):
    return f'User: {name}'

# Integer
@app.route('/post/<int:id>')
def post(id):
    return f'Post: {id}'

# Float
@app.route('/price/<float:amount>')
def price(amount):
    return f'Price: {amount}'

# Path (includes slashes)
@app.route('/path/<path:subpath>')
def path(subpath):
    return f'Path: {subpath}'
```

### Multiple Routes

One view can handle multiple routes:

```python
@app.route('/')
@app.route('/home')
@app.route('/index')
def home():
    return 'Home Page'
```

### HTTP Methods

Specify allowed HTTP methods:

```python
from flask import Flask, request

app = Flask(__name__)

# GET only (default)
@app.route('/users', methods=['GET'])
def get_users():
    return 'List of users'

# POST only
@app.route('/users', methods=['POST'])
def create_user():
    return 'Create user'

# Multiple methods
@app.route('/users/<int:user_id>', methods=['GET', 'PUT', 'DELETE'])
def user_operations(user_id):
    if request.method == 'GET':
        return f'Get user {user_id}'
    elif request.method == 'PUT':
        return f'Update user {user_id}'
    elif request.method == 'DELETE':
        return f'Delete user {user_id}'
```

### Request Object

Access request data:

```python
from flask import Flask, request

app = Flask(__name__)

@app.route('/example', methods=['GET', 'POST'])
def example():
    # Request method
    method = request.method
    
    # Query parameters
    name = request.args.get('name')
    
    # Form data
    email = request.form.get('email')
    
    # JSON data
    if request.is_json:
        data = request.get_json()
    
    # Headers
    user_agent = request.headers.get('User-Agent')
    
    return f'Method: {method}, Name: {name}'
```

---

## Templates

### What are Templates?

**Templates** are HTML files with dynamic content using Jinja2 templating engine.

### Basic Template

```python
from flask import Flask, render_template

app = Flask(__name__)

@app.route('/')
def index():
    return render_template('index.html')
```

```html
<!-- templates/index.html -->
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h1>Welcome!</h1>
</body>
</html>
```

### Template Variables

Pass variables to templates:

```python
@app.route('/user/<name>')
def user(name):
    return render_template('user.html', name=name)
```

```html
<!-- templates/user.html -->
<h1>Hello, {{ name }}!</h1>
```

### Template Filters

Jinja2 provides filters:

```html
<!-- Uppercase -->
{{ name|upper }}

<!-- Lowercase -->
{{ name|lower }}

<!-- Title case -->
{{ name|title }}

<!-- Length -->
{{ items|length }}

<!-- Default value -->
{{ value|default('N/A') }}
```

### Template Control Structures

#### If Statements

```html
{% if user %}
    <p>Welcome, {{ user.name }}!</p>
{% else %}
    <p>Please log in.</p>
{% endif %}
```

#### For Loops

```html
<ul>
{% for item in items %}
    <li>{{ item }}</li>
{% endfor %}
</ul>
```

#### Loop Variables

```html
{% for item in items %}
    <p>Item {{ loop.index }}: {{ item }}</p>
    {% if loop.first %}
        <p>First item</p>
    {% endif %}
    {% if loop.last %}
        <p>Last item</p>
    {% endif %}
{% endfor %}
```

### Template Inheritance

Base template:

```html
<!-- templates/base.html -->
<!DOCTYPE html>
<html>
<head>
    <title>{% block title %}My App{% endblock %}</title>
</head>
<body>
    <nav>
        <a href="/">Home</a>
        <a href="/about">About</a>
    </nav>
    
    <main>
        {% block content %}{% endblock %}
    </main>
    
    <footer>
        {% block footer %}{% endblock %}
    </footer>
</body>
</html>
```

Child template:

```html
<!-- templates/index.html -->
{% extends "base.html" %}

{% block title %}Home - My App{% endblock %}

{% block content %}
    <h1>Welcome!</h1>
    <p>This is the home page.</p>
{% endblock %}
```

### Including Templates

```html
<!-- templates/header.html -->
<header>
    <h1>My Website</h1>
</header>

<!-- templates/index.html -->
{% include 'header.html' %}
<main>Content here</main>
```

### Template Context

Pass multiple variables:

```python
@app.route('/dashboard')
def dashboard():
    user = {'name': 'Alice', 'email': 'alice@example.com'}
    posts = ['Post 1', 'Post 2', 'Post 3']
    return render_template('dashboard.html', user=user, posts=posts)
```

```html
<!-- templates/dashboard.html -->
<h1>Dashboard</h1>
<p>User: {{ user.name }}</p>
<p>Email: {{ user.email }}</p>

<h2>Posts</h2>
<ul>
{% for post in posts %}
    <li>{{ post }}</li>
{% endfor %}
</ul>
```

---

## Static Files

### Serving Static Files

Flask automatically serves files from the `static` folder:

```
myapp/
├── app.py
└── static/
    ├── css/
    │   └── style.css
    ├── js/
    │   └── script.js
    └── images/
        └── logo.png
```

### Using Static Files in Templates

```html
<!-- Link to CSS -->
<link rel="stylesheet" href="{{ url_for('static', filename='css/style.css') }}">

<!-- Link to JavaScript -->
<script src="{{ url_for('static', filename='js/script.js') }}"></script>

<!-- Image -->
<img src="{{ url_for('static', filename='images/logo.png') }}" alt="Logo">
```

---

## URL Building

### url_for() Function

Generate URLs for routes:

```python
from flask import Flask, url_for

app = Flask(__name__)

@app.route('/')
def index():
    return 'Home'

@app.route('/user/<username>')
def user(username):
    return f'User: {username}'

# Generate URLs
print(url_for('index'))  # /
print(url_for('user', username='alice'))  # /user/alice
```

### Using url_for() in Templates

```html
<a href="{{ url_for('index') }}">Home</a>
<a href="{{ url_for('user', username='alice') }}">Alice's Profile</a>
```

---

## Request Handling

### Accessing Request Data

```python
from flask import Flask, request

app = Flask(__name__)

@app.route('/example', methods=['GET', 'POST'])
def example():
    # Method
    method = request.method
    
    # Query parameters
    page = request.args.get('page', 1, type=int)
    
    # Form data
    name = request.form.get('name')
    
    # JSON
    if request.is_json:
        data = request.get_json()
    
    # Files
    file = request.files.get('file')
    
    # Headers
    content_type = request.headers.get('Content-Type')
    
    return f'Method: {method}'
```

### Response Objects

Create custom responses:

```python
from flask import Flask, make_response, jsonify

app = Flask(__name__)

@app.route('/json')
def json_response():
    return jsonify({'message': 'Hello', 'status': 'success'})

@app.route('/custom')
def custom_response():
    response = make_response('Custom Response')
    response.headers['X-Custom-Header'] = 'Value'
    response.status_code = 201
    return response
```

### Redirects

```python
from flask import Flask, redirect, url_for

app = Flask(__name__)

@app.route('/old')
def old():
    return redirect(url_for('new'))

@app.route('/new')
def new():
    return 'New page'
```

---

## Practical Examples

### Example 1: Simple Blog

```python
from flask import Flask, render_template

app = Flask(__name__)

posts = [
    {'id': 1, 'title': 'First Post', 'content': 'Content of first post'},
    {'id': 2, 'title': 'Second Post', 'content': 'Content of second post'},
]

@app.route('/')
def index():
    return render_template('index.html', posts=posts)

@app.route('/post/<int:post_id>')
def post(post_id):
    post = next((p for p in posts if p['id'] == post_id), None)
    if post:
        return render_template('post.html', post=post)
    return 'Post not found', 404
```

### Example 2: User API

```python
from flask import Flask, jsonify, request

app = Flask(__name__)

users = [
    {'id': 1, 'name': 'Alice', 'email': 'alice@example.com'},
    {'id': 2, 'name': 'Bob', 'email': 'bob@example.com'},
]

@app.route('/api/users', methods=['GET'])
def get_users():
    return jsonify(users)

@app.route('/api/users/<int:user_id>', methods=['GET'])
def get_user(user_id):
    user = next((u for u in users if u['id'] == user_id), None)
    if user:
        return jsonify(user)
    return jsonify({'error': 'User not found'}), 404

@app.route('/api/users', methods=['POST'])
def create_user():
    data = request.get_json()
    new_user = {
        'id': len(users) + 1,
        'name': data.get('name'),
        'email': data.get('email')
    }
    users.append(new_user)
    return jsonify(new_user), 201
```

### Example 3: Form Handling

```python
from flask import Flask, render_template, request, redirect, url_for

app = Flask(__name__)

@app.route('/contact', methods=['GET', 'POST'])
def contact():
    if request.method == 'POST':
        name = request.form.get('name')
        email = request.form.get('email')
        message = request.form.get('message')
        # Process form data
        return redirect(url_for('thank_you'))
    return render_template('contact.html')

@app.route('/thank-you')
def thank_you():
    return render_template('thank_you.html')
```

---

## Common Mistakes and Pitfalls

### 1. Not Using url_for()

```python
# WRONG: Hard-coded URLs
<a href="/user/alice">Profile</a>

# CORRECT: Use url_for()
<a href="{{ url_for('user', username='alice') }}">Profile</a>
```

### 2. Not Handling Errors

```python
# WRONG: No error handling
user = users[user_id]  # May raise IndexError

# CORRECT: Handle errors
user = next((u for u in users if u['id'] == user_id), None)
if not user:
    return 'User not found', 404
```

### 3. Not Escaping Template Variables

```python
# Jinja2 auto-escapes by default, but be careful
# Use |safe filter only when you trust the content
{{ user_input|safe }}  # Only if trusted!
```

### 4. Running in Production with Debug

```python
# WRONG: Debug mode in production
app.run(debug=True)  # Security risk!

# CORRECT: Debug only in development
if __name__ == '__main__':
    app.run(debug=True)  # Only for development
```

---

## Best Practices

### 1. Use Application Factory Pattern

```python
from flask import Flask

def create_app():
    app = Flask(__name__)
    
    @app.route('/')
    def index():
        return 'Hello'
    
    return app

if __name__ == '__main__':
    app = create_app()
    app.run(debug=True)
```

### 2. Organize Routes

```python
# app.py
from flask import Flask

app = Flask(__name__)

# Import routes
from routes import main, users, posts

app.register_blueprint(main.bp)
app.register_blueprint(users.bp)
app.register_blueprint(posts.bp)
```

### 3. Use Configuration

```python
from flask import Flask

app = Flask(__name__)
app.config['SECRET_KEY'] = 'your-secret-key'
app.config['DEBUG'] = True
```

### 4. Error Handling

```python
@app.errorhandler(404)
def not_found(error):
    return render_template('404.html'), 404

@app.errorhandler(500)
def internal_error(error):
    return render_template('500.html'), 500
```

### 5. Use Blueprints

```python
from flask import Blueprint

bp = Blueprint('users', __name__, url_prefix='/users')

@bp.route('/')
def index():
    return 'Users'
```

---

## Practice Exercise

### Exercise: Flask App

**Objective**: Create a Flask web application.

**Instructions**:

1. Create a Flask application with the following structure:
   ```
   flask_app/
   ├── app.py
   ├── templates/
   │   ├── base.html
   │   ├── index.html
   │   └── user.html
   └── static/
       └── css/
           └── style.css
   ```

2. Create a web application that:
   - Has multiple routes
   - Uses templates
   - Handles URL parameters
   - Serves static files
   - Demonstrates Flask features

3. Your application should include:
   - Home page
   - User profile page
   - About page
   - Template inheritance
   - Static CSS
   - URL building

**Example Solution**:

```python
"""
Flask Application Practice
This program demonstrates Flask framework basics.
"""

from flask import Flask, render_template, url_for, request, redirect

app = Flask(__name__)

# Sample data
users = [
    {'id': 1, 'name': 'Alice', 'email': 'alice@example.com', 'bio': 'Software Developer'},
    {'id': 2, 'name': 'Bob', 'email': 'bob@example.com', 'bio': 'Data Scientist'},
    {'id': 3, 'name': 'Charlie', 'email': 'charlie@example.com', 'bio': 'Web Designer'},
]

posts = [
    {'id': 1, 'title': 'First Post', 'content': 'This is the first post', 'author': 'Alice'},
    {'id': 2, 'title': 'Second Post', 'content': 'This is the second post', 'author': 'Bob'},
]

# Routes
@app.route('/')
def index():
    return render_template('index.html', users=users, posts=posts)

@app.route('/about')
def about():
    return render_template('about.html')

@app.route('/user/<int:user_id>')
def user(user_id):
    user = next((u for u in users if u['id'] == user_id), None)
    if user:
        user_posts = [p for p in posts if p['author'] == user['name']]
        return render_template('user.html', user=user, posts=user_posts)
    return render_template('404.html'), 404

@app.route('/post/<int:post_id>')
def post(post_id):
    post = next((p for p in posts if p['id'] == post_id), None)
    if post:
        return render_template('post.html', post=post)
    return render_template('404.html'), 404

@app.route('/search')
def search():
    query = request.args.get('q', '')
    if query:
        filtered_posts = [p for p in posts if query.lower() in p['title'].lower()]
        return render_template('search.html', query=query, posts=filtered_posts)
    return render_template('search.html', query='', posts=[])

# Error handlers
@app.errorhandler(404)
def not_found(error):
    return render_template('404.html'), 404

if __name__ == '__main__':
    app.run(debug=True)
```

```html
<!-- templates/base.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{% block title %}My Flask App{% endblock %}</title>
    <link rel="stylesheet" href="{{ url_for('static', filename='css/style.css') }}">
</head>
<body>
    <nav>
        <a href="{{ url_for('index') }}">Home</a>
        <a href="{{ url_for('about') }}">About</a>
    </nav>
    
    <main>
        {% block content %}{% endblock %}
    </main>
    
    <footer>
        <p>&copy; 2024 My Flask App</p>
    </footer>
</body>
</html>
```

```html
<!-- templates/index.html -->
{% extends "base.html" %}

{% block title %}Home - My Flask App{% endblock %}

{% block content %}
    <h1>Welcome to My Flask App</h1>
    
    <h2>Users</h2>
    <ul>
    {% for user in users %}
        <li><a href="{{ url_for('user', user_id=user.id) }}">{{ user.name }}</a></li>
    {% endfor %}
    </ul>
    
    <h2>Recent Posts</h2>
    <ul>
    {% for post in posts %}
        <li><a href="{{ url_for('post', post_id=post.id) }}">{{ post.title }}</a></li>
    {% endfor %}
    </ul>
{% endblock %}
```

```html
<!-- templates/user.html -->
{% extends "base.html" %}

{% block title %}{{ user.name }} - My Flask App{% endblock %}

{% block content %}
    <h1>{{ user.name }}</h1>
    <p><strong>Email:</strong> {{ user.email }}</p>
    <p><strong>Bio:</strong> {{ user.bio }}</p>
    
    <h2>Posts by {{ user.name }}</h2>
    {% if posts %}
        <ul>
        {% for post in posts %}
            <li><a href="{{ url_for('post', post_id=post.id) }}">{{ post.title }}</a></li>
        {% endfor %}
        </ul>
    {% else %}
        <p>No posts yet.</p>
    {% endif %}
{% endblock %}
```

```html
<!-- templates/about.html -->
{% extends "base.html" %}

{% block title %}About - My Flask App{% endblock %}

{% block content %}
    <h1>About</h1>
    <p>This is a Flask web application demonstrating basic features.</p>
{% endblock %}
```

```html
<!-- templates/404.html -->
{% extends "base.html" %}

{% block title %}404 - Not Found{% endblock %}

{% block content %}
    <h1>404 - Page Not Found</h1>
    <p>The page you're looking for doesn't exist.</p>
    <a href="{{ url_for('index') }}">Go Home</a>
{% endblock %}
```

```css
/* static/css/style.css */
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

nav {
    background-color: #333;
    padding: 10px;
    margin-bottom: 20px;
}

nav a {
    color: white;
    text-decoration: none;
    margin-right: 20px;
}

nav a:hover {
    text-decoration: underline;
}

footer {
    margin-top: 40px;
    padding-top: 20px;
    border-top: 1px solid #ccc;
    text-align: center;
    color: #666;
}
```

**Expected Output**: A working Flask web application with multiple pages, navigation, and styling.

**Challenge** (Optional):
- Add a contact form
- Implement user authentication
- Add a blog post creation page
- Create an API endpoint
- Add pagination for posts

---

## Key Takeaways

1. **Flask installation** - `pip install flask`
2. **Basic app structure** - Flask instance, routes, run
3. **Routes** - map URLs to functions
4. **URL parameters** - capture dynamic values
5. **HTTP methods** - GET, POST, PUT, DELETE
6. **Templates** - Jinja2 templating engine
7. **Template inheritance** - base templates
8. **Static files** - CSS, JS, images
9. **url_for()** - generate URLs
10. **Request handling** - access request data
11. **Response objects** - custom responses
12. **Error handling** - error handlers
13. **Best practices** - application factory, blueprints, configuration
14. **Debug mode** - only for development
15. **Project structure** - organize files properly

---

## Quiz: Flask Basics

Test your understanding with these questions:

1. **What is Flask?**
   - A) A database
   - B) A web framework
   - C) A programming language
   - D) A database framework

2. **How do you create a Flask app?**
   - A) Flask()
   - B) Flask(__name__)
   - C) create_app()
   - D) new Flask()

3. **What decorator defines a route?**
   - A) @route
   - B) @app.route
   - C) @flask.route
   - D) @path

4. **What template engine does Flask use?**
   - A) Django templates
   - B) Jinja2
   - C) Mustache
   - D) Handlebars

5. **Where are templates stored?**
   - A) templates/ folder
   - B) views/ folder
   - C) html/ folder
   - D) pages/ folder

6. **What function renders templates?**
   - A) render()
   - B) render_template()
   - C) template()
   - D) show_template()

7. **What function generates URLs?**
   - A) url()
   - B) url_for()
   - C) generate_url()
   - D) make_url()

8. **What is the default HTTP method?**
   - A) POST
   - B) GET
   - C) PUT
   - D) DELETE

9. **How do you access query parameters?**
   - A) request.query
   - B) request.args
   - C) request.params
   - D) request.get

10. **What should you NOT do in production?**
    - A) Use templates
    - B) Use routes
    - C) Use debug=True
    - D) Use Flask

**Answers**:
1. B) A web framework (Flask definition)
2. B) Flask(__name__) (creating Flask app)
3. B) @app.route (route decorator)
4. B) Jinja2 (Flask template engine)
5. A) templates/ folder (template location)
6. B) render_template() (template rendering)
7. B) url_for() (URL generation)
8. B) GET (default HTTP method)
9. B) request.args (query parameters)
10. C) Use debug=True (production security)

---

## Next Steps

Excellent work! You've mastered Flask basics. You now understand:
- Flask installation and setup
- Routes and views
- Templates
- How to build web applications

**What's Next?**
- Lesson 19.3: Flask Advanced
- Learn forms and validation
- Understand database integration
- Explore advanced Flask features

---

## Additional Resources

- **Flask Documentation**: [flask.palletsprojects.com/](https://flask.palletsprojects.com/)
- **Jinja2 Templates**: [jinja.palletsprojects.com/](https://jinja.palletsprojects.com/)
- **Flask Tutorial**: [flask.palletsprojects.com/en/latest/tutorial/](https://flask.palletsprojects.com/en/latest/tutorial/)

---

*Lesson completed! You're ready to move on to the next lesson.*

