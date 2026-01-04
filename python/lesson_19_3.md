# Lesson 19.3: Flask Advanced

## Learning Objectives

By the end of this lesson, you will be able to:
- Handle forms and validation in Flask
- Integrate databases with Flask
- Implement user authentication
- Use Flask extensions
- Work with sessions
- Handle file uploads
- Apply security best practices
- Build complete Flask applications
- Debug advanced Flask issues
- Deploy Flask applications

---

## Introduction to Flask Advanced

This lesson covers advanced Flask features including forms, database integration, and user authentication - essential for building production-ready web applications.

---

## Forms and Validation

### Basic Form Handling

```python
from flask import Flask, render_template, request, redirect, url_for, flash

app = Flask(__name__)
app.config['SECRET_KEY'] = 'your-secret-key-here'

@app.route('/contact', methods=['GET', 'POST'])
def contact():
    if request.method == 'POST':
        name = request.form.get('name')
        email = request.form.get('email')
        message = request.form.get('message')
        
        # Process form data
        flash('Message sent successfully!')
        return redirect(url_for('contact'))
    
    return render_template('contact.html')
```

### Using Flask-WTF

Flask-WTF provides CSRF protection and form handling:

```python
from flask import Flask, render_template, redirect, url_for, flash
from flask_wtf import FlaskForm
from wtforms import StringField, TextAreaField, SubmitField
from wtforms.validators import DataRequired, Email, Length

app = Flask(__name__)
app.config['SECRET_KEY'] = 'your-secret-key-here'

class ContactForm(FlaskForm):
    name = StringField('Name', validators=[DataRequired(), Length(min=2, max=50)])
    email = StringField('Email', validators=[DataRequired(), Email()])
    message = TextAreaField('Message', validators=[DataRequired(), Length(min=10)])
    submit = SubmitField('Send')

@app.route('/contact', methods=['GET', 'POST'])
def contact():
    form = ContactForm()
    if form.validate_on_submit():
        # Process form data
        flash('Message sent successfully!')
        return redirect(url_for('contact'))
    return render_template('contact.html', form=form)
```

### Form Validation

```python
from wtforms import StringField, IntegerField, SelectField
from wtforms.validators import DataRequired, Email, NumberRange, Optional

class UserForm(FlaskForm):
    name = StringField('Name', validators=[DataRequired()])
    email = StringField('Email', validators=[DataRequired(), Email()])
    age = IntegerField('Age', validators=[Optional(), NumberRange(min=0, max=120)])
    role = SelectField('Role', choices=[('user', 'User'), ('admin', 'Admin')])
    submit = SubmitField('Submit')
```

### Displaying Form Errors

```html
<!-- templates/contact.html -->
<form method="POST">
    {{ form.hidden_tag() }}
    
    <div>
        {{ form.name.label }}
        {{ form.name() }}
        {% if form.name.errors %}
            <ul>
            {% for error in form.name.errors %}
                <li>{{ error }}</li>
            {% endfor %}
            </ul>
        {% endif %}
    </div>
    
    <div>
        {{ form.email.label }}
        {{ form.email() }}
        {% if form.email.errors %}
            <ul>
            {% for error in form.email.errors %}
                <li>{{ error }}</li>
            {% endfor %}
            </ul>
        {% endif %}
    </div>
    
    {{ form.submit() }}
</form>
```

### Flash Messages

```python
from flask import flash

@app.route('/submit', methods=['POST'])
def submit():
    # Process form
    flash('Success message', 'success')
    flash('Error message', 'error')
    return redirect(url_for('index'))
```

```html
<!-- Display flash messages -->
{% with messages = get_flashed_messages(with_categories=true) %}
    {% if messages %}
        {% for category, message in messages %}
            <div class="alert alert-{{ category }}">{{ message }}</div>
        {% endfor %}
    {% endif %}
{% endwith %}
```

---

## Database Integration

### SQLAlchemy Setup

SQLAlchemy is the most popular ORM for Flask:

```python
from flask import Flask
from flask_sqlalchemy import SQLAlchemy

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///database.db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)
```

### Defining Models

```python
from flask_sqlalchemy import SQLAlchemy

db = SQLAlchemy()

class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(80), unique=True, nullable=False)
    email = db.Column(db.String(120), unique=True, nullable=False)
    posts = db.relationship('Post', backref='author', lazy=True)
    
    def __repr__(self):
        return f'<User {self.username}>'

class Post(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(100), nullable=False)
    content = db.Column(db.Text, nullable=False)
    user_id = db.Column(db.Integer, db.ForeignKey('user.id'), nullable=False)
    
    def __repr__(self):
        return f'<Post {self.title}>'
```

### Database Operations

```python
# Create tables
with app.app_context():
    db.create_all()

# Create
user = User(username='alice', email='alice@example.com')
db.session.add(user)
db.session.commit()

# Read
user = User.query.get(1)
users = User.query.all()
user = User.query.filter_by(username='alice').first()

# Update
user = User.query.get(1)
user.email = 'newemail@example.com'
db.session.commit()

# Delete
user = User.query.get(1)
db.session.delete(user)
db.session.commit()
```

### Database Queries

```python
# Filter
users = User.query.filter(User.email.endswith('@example.com')).all()

# Order
users = User.query.order_by(User.username).all()

# Limit
users = User.query.limit(10).all()

# Complex queries
from sqlalchemy import and_, or_
users = User.query.filter(
    or_(User.username == 'alice', User.email == 'bob@example.com')
).all()
```

### Relationships

```python
# One-to-Many
class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    posts = db.relationship('Post', backref='author', lazy=True)

class Post(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('user.id'), nullable=False)

# Usage
user = User.query.get(1)
posts = user.posts  # Get all posts by user

post = Post.query.get(1)
author = post.author  # Get post author
```

---

## User Authentication

### Basic Authentication

```python
from flask import Flask, render_template, request, redirect, url_for, session, flash
from werkzeug.security import generate_password_hash, check_password_hash

app = Flask(__name__)
app.config['SECRET_KEY'] = 'your-secret-key-here'

# Simple user storage (use database in production)
users = {}

@app.route('/register', methods=['GET', 'POST'])
def register():
    if request.method == 'POST':
        username = request.form.get('username')
        password = request.form.get('password')
        
        if username in users:
            flash('Username already exists')
            return redirect(url_for('register'))
        
        users[username] = generate_password_hash(password)
        flash('Registration successful!')
        return redirect(url_for('login'))
    
    return render_template('register.html')

@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        username = request.form.get('username')
        password = request.form.get('password')
        
        if username in users and check_password_hash(users[username], password):
            session['username'] = username
            flash('Login successful!')
            return redirect(url_for('dashboard'))
        else:
            flash('Invalid credentials')
    
    return render_template('login.html')

@app.route('/logout')
def logout():
    session.pop('username', None)
    flash('Logged out successfully')
    return redirect(url_for('index'))
```

### Using Flask-Login

Flask-Login provides session management:

```python
from flask import Flask
from flask_login import LoginManager, UserMixin, login_user, logout_user, login_required, current_user
from flask_sqlalchemy import SQLAlchemy

app = Flask(__name__)
app.config['SECRET_KEY'] = 'your-secret-key-here'
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///database.db'

db = SQLAlchemy(app)
login_manager = LoginManager()
login_manager.init_app(app)
login_manager.login_view = 'login'

class User(UserMixin, db.Model):
    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(80), unique=True, nullable=False)
    email = db.Column(db.String(120), unique=True, nullable=False)
    password_hash = db.Column(db.String(128))

@login_manager.user_loader
def load_user(user_id):
    return User.query.get(int(user_id))

@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        user = User.query.filter_by(username=request.form['username']).first()
        if user and check_password_hash(user.password_hash, request.form['password']):
            login_user(user)
            return redirect(url_for('dashboard'))
    return render_template('login.html')

@app.route('/dashboard')
@login_required
def dashboard():
    return render_template('dashboard.html', user=current_user)

@app.route('/logout')
@login_required
def logout():
    logout_user()
    return redirect(url_for('index'))
```

### Protecting Routes

```python
from functools import wraps
from flask import session, redirect, url_for

def login_required(f):
    @wraps(f)
    def decorated_function(*args, **kwargs):
        if 'username' not in session:
            return redirect(url_for('login'))
        return f(*args, **kwargs)
    return decorated_function

@app.route('/protected')
@login_required
def protected():
    return 'This is a protected page'
```

---

## Sessions

### Using Sessions

```python
from flask import Flask, session

app = Flask(__name__)
app.config['SECRET_KEY'] = 'your-secret-key-here'

@app.route('/set')
def set_session():
    session['username'] = 'alice'
    session['logged_in'] = True
    return 'Session set'

@app.route('/get')
def get_session():
    username = session.get('username')
    logged_in = session.get('logged_in', False)
    return f'Username: {username}, Logged in: {logged_in}'

@app.route('/clear')
def clear_session():
    session.clear()
    return 'Session cleared'
```

### Session Configuration

```python
app.config['SECRET_KEY'] = 'your-secret-key-here'
app.config['SESSION_COOKIE_NAME'] = 'my_session'
app.config['SESSION_COOKIE_SECURE'] = True  # HTTPS only
app.config['SESSION_COOKIE_HTTPONLY'] = True
app.config['SESSION_COOKIE_SAMESITE'] = 'Lax'
```

---

## File Uploads

### Handling File Uploads

```python
from flask import Flask, request, redirect, url_for, flash
from werkzeug.utils import secure_filename
import os

app = Flask(__name__)
app.config['SECRET_KEY'] = 'your-secret-key-here'
app.config['UPLOAD_FOLDER'] = 'uploads'
app.config['MAX_CONTENT_LENGTH'] = 16 * 1024 * 1024  # 16MB max

ALLOWED_EXTENSIONS = {'png', 'jpg', 'jpeg', 'gif', 'pdf'}

def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS

@app.route('/upload', methods=['GET', 'POST'])
def upload_file():
    if request.method == 'POST':
        if 'file' not in request.files:
            flash('No file part')
            return redirect(request.url)
        
        file = request.files['file']
        if file.filename == '':
            flash('No selected file')
            return redirect(request.url)
        
        if file and allowed_file(file.filename):
            filename = secure_filename(file.filename)
            file.save(os.path.join(app.config['UPLOAD_FOLDER'], filename))
            flash('File uploaded successfully')
            return redirect(url_for('upload_file'))
    
    return render_template('upload.html')
```

---

## Security Best Practices

### CSRF Protection

```python
from flask_wtf.csrf import CSRFProtect

app = Flask(__name__)
app.config['SECRET_KEY'] = 'your-secret-key-here'
csrf = CSRFProtect(app)
```

### Password Hashing

```python
from werkzeug.security import generate_password_hash, check_password_hash

# Hash password
password_hash = generate_password_hash('mypassword')

# Verify password
is_valid = check_password_hash(password_hash, 'mypassword')
```

### SQL Injection Prevention

```python
# WRONG: SQL injection risk
query = f"SELECT * FROM users WHERE username = '{username}'"

# CORRECT: Use ORM or parameterized queries
user = User.query.filter_by(username=username).first()
```

### XSS Prevention

Jinja2 auto-escapes by default, but be careful:

```html
<!-- Auto-escaped (safe) -->
{{ user_input }}

<!-- Only use |safe if you trust the content -->
{{ trusted_content|safe }}
```

---

## Practical Examples

### Example 1: Complete Blog with Database

```python
from flask import Flask, render_template, request, redirect, url_for, flash
from flask_sqlalchemy import SQLAlchemy
from datetime import datetime

app = Flask(__name__)
app.config['SECRET_KEY'] = 'your-secret-key-here'
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///blog.db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

class Post(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(100), nullable=False)
    content = db.Column(db.Text, nullable=False)
    created_at = db.Column(db.DateTime, default=datetime.utcnow)

@app.route('/')
def index():
    posts = Post.query.order_by(Post.created_at.desc()).all()
    return render_template('index.html', posts=posts)

@app.route('/post/<int:post_id>')
def post(post_id):
    post = Post.query.get_or_404(post_id)
    return render_template('post.html', post=post)

@app.route('/create', methods=['GET', 'POST'])
def create_post():
    if request.method == 'POST':
        post = Post(
            title=request.form['title'],
            content=request.form['content']
        )
        db.session.add(post)
        db.session.commit()
        flash('Post created successfully!')
        return redirect(url_for('index'))
    return render_template('create.html')
```

### Example 2: User Registration and Login

```python
from flask import Flask, render_template, request, redirect, url_for, session, flash
from flask_sqlalchemy import SQLAlchemy
from werkzeug.security import generate_password_hash, check_password_hash

app = Flask(__name__)
app.config['SECRET_KEY'] = 'your-secret-key-here'
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///users.db'

db = SQLAlchemy(app)

class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(80), unique=True, nullable=False)
    email = db.Column(db.String(120), unique=True, nullable=False)
    password_hash = db.Column(db.String(128))

@app.route('/register', methods=['GET', 'POST'])
def register():
    if request.method == 'POST':
        username = request.form['username']
        email = request.form['email']
        password = request.form['password']
        
        if User.query.filter_by(username=username).first():
            flash('Username already exists')
            return redirect(url_for('register'))
        
        user = User(
            username=username,
            email=email,
            password_hash=generate_password_hash(password)
        )
        db.session.add(user)
        db.session.commit()
        flash('Registration successful!')
        return redirect(url_for('login'))
    
    return render_template('register.html')

@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        user = User.query.filter_by(username=request.form['username']).first()
        if user and check_password_hash(user.password_hash, request.form['password']):
            session['user_id'] = user.id
            session['username'] = user.username
            flash('Login successful!')
            return redirect(url_for('dashboard'))
        else:
            flash('Invalid credentials')
    return render_template('login.html')

@app.route('/dashboard')
def dashboard():
    if 'user_id' not in session:
        return redirect(url_for('login'))
    return render_template('dashboard.html', username=session['username'])

@app.route('/logout')
def logout():
    session.clear()
    flash('Logged out successfully')
    return redirect(url_for('index'))
```

---

## Common Mistakes and Pitfalls

### 1. Not Using Secret Key

```python
# WRONG: No secret key
app = Flask(__name__)

# CORRECT: Set secret key
app.config['SECRET_KEY'] = 'your-secret-key-here'
```

### 2. SQL Injection

```python
# WRONG: SQL injection risk
query = f"SELECT * FROM users WHERE username = '{username}'"

# CORRECT: Use ORM
user = User.query.filter_by(username=username).first()
```

### 3. Not Hashing Passwords

```python
# WRONG: Plain text password
user.password = password

# CORRECT: Hash password
user.password_hash = generate_password_hash(password)
```

### 4. Not Validating Input

```python
# WRONG: No validation
username = request.form['username']

# CORRECT: Validate input
from wtforms.validators import DataRequired, Length
username = StringField('Username', validators=[DataRequired(), Length(min=3)])
```

---

## Best Practices

### 1. Use Application Factory

```python
from flask import Flask
from flask_sqlalchemy import SQLAlchemy

db = SQLAlchemy()

def create_app():
    app = Flask(__name__)
    app.config['SECRET_KEY'] = 'your-secret-key-here'
    app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///database.db'
    
    db.init_app(app)
    
    from routes import main
    app.register_blueprint(main.bp)
    
    return app
```

### 2. Use Blueprints

```python
from flask import Blueprint

bp = Blueprint('users', __name__, url_prefix='/users')

@bp.route('/')
def index():
    return 'Users'

# In app.py
from routes.users import bp as users_bp
app.register_blueprint(users_bp)
```

### 3. Environment Configuration

```python
import os

class Config:
    SECRET_KEY = os.environ.get('SECRET_KEY') or 'dev-secret-key'
    SQLALCHEMY_DATABASE_URI = os.environ.get('DATABASE_URL') or 'sqlite:///app.db'

app.config.from_object(Config)
```

### 4. Error Handling

```python
@app.errorhandler(404)
def not_found(error):
    return render_template('404.html'), 404

@app.errorhandler(500)
def internal_error(error):
    db.session.rollback()
    return render_template('500.html'), 500
```

### 5. Database Migrations

```python
# Use Flask-Migrate for database migrations
from flask_migrate import Migrate

migrate = Migrate(app, db)

# Commands:
# flask db init
# flask db migrate -m "Initial migration"
# flask db upgrade
```

---

## Practice Exercise

### Exercise: Flask App with Auth

**Objective**: Create a Flask application with authentication and database.

**Instructions**:

1. Create a Flask application with:
   - User registration
   - User login
   - Protected routes
   - Database integration
   - Forms and validation

2. Your application should include:
   - User model
   - Registration form
   - Login form
   - Session management
   - Password hashing
   - Protected dashboard
   - Logout functionality

**Example Solution**:

```python
"""
Flask Application with Authentication
This program demonstrates advanced Flask features.
"""

from flask import Flask, render_template, request, redirect, url_for, session, flash
from flask_sqlalchemy import SQLAlchemy
from werkzeug.security import generate_password_hash, check_password_hash
from functools import wraps
from datetime import datetime

app = Flask(__name__)
app.config['SECRET_KEY'] = 'your-secret-key-change-in-production'
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///app.db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

# Models
class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(80), unique=True, nullable=False)
    email = db.Column(db.String(120), unique=True, nullable=False)
    password_hash = db.Column(db.String(128))
    created_at = db.Column(db.DateTime, default=datetime.utcnow)
    posts = db.relationship('Post', backref='author', lazy=True)
    
    def __repr__(self):
        return f'<User {self.username}>'

class Post(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(100), nullable=False)
    content = db.Column(db.Text, nullable=False)
    user_id = db.Column(db.Integer, db.ForeignKey('user.id'), nullable=False)
    created_at = db.Column(db.DateTime, default=datetime.utcnow)
    
    def __repr__(self):
        return f'<Post {self.title}>'

# Decorator for protected routes
def login_required(f):
    @wraps(f)
    def decorated_function(*args, **kwargs):
        if 'user_id' not in session:
            flash('Please log in to access this page')
            return redirect(url_for('login'))
        return f(*args, **kwargs)
    return decorated_function

# Routes
@app.route('/')
def index():
    posts = Post.query.order_by(Post.created_at.desc()).limit(10).all()
    return render_template('index.html', posts=posts)

@app.route('/register', methods=['GET', 'POST'])
def register():
    if request.method == 'POST':
        username = request.form.get('username')
        email = request.form.get('email')
        password = request.form.get('password')
        confirm_password = request.form.get('confirm_password')
        
        # Validation
        if not username or not email or not password:
            flash('All fields are required')
            return redirect(url_for('register'))
        
        if password != confirm_password:
            flash('Passwords do not match')
            return redirect(url_for('register'))
        
        if User.query.filter_by(username=username).first():
            flash('Username already exists')
            return redirect(url_for('register'))
        
        if User.query.filter_by(email=email).first():
            flash('Email already exists')
            return redirect(url_for('register'))
        
        # Create user
        user = User(
            username=username,
            email=email,
            password_hash=generate_password_hash(password)
        )
        db.session.add(user)
        db.session.commit()
        
        flash('Registration successful! Please log in.')
        return redirect(url_for('login'))
    
    return render_template('register.html')

@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        username = request.form.get('username')
        password = request.form.get('password')
        
        user = User.query.filter_by(username=username).first()
        
        if user and check_password_hash(user.password_hash, password):
            session['user_id'] = user.id
            session['username'] = user.username
            flash('Login successful!')
            return redirect(url_for('dashboard'))
        else:
            flash('Invalid username or password')
    
    return render_template('login.html')

@app.route('/dashboard')
@login_required
def dashboard():
    user = User.query.get(session['user_id'])
    posts = Post.query.filter_by(user_id=user.id).order_by(Post.created_at.desc()).all()
    return render_template('dashboard.html', user=user, posts=posts)

@app.route('/create-post', methods=['GET', 'POST'])
@login_required
def create_post():
    if request.method == 'POST':
        title = request.form.get('title')
        content = request.form.get('content')
        
        if not title or not content:
            flash('Title and content are required')
            return redirect(url_for('create_post'))
        
        post = Post(
            title=title,
            content=content,
            user_id=session['user_id']
        )
        db.session.add(post)
        db.session.commit()
        
        flash('Post created successfully!')
        return redirect(url_for('dashboard'))
    
    return render_template('create_post.html')

@app.route('/post/<int:post_id>')
def post(post_id):
    post = Post.query.get_or_404(post_id)
    return render_template('post.html', post=post)

@app.route('/logout')
@login_required
def logout():
    session.clear()
    flash('Logged out successfully')
    return redirect(url_for('index'))

# Initialize database
with app.app_context():
    db.create_all()

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
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        nav { background: #333; padding: 10px; margin-bottom: 20px; }
        nav a { color: white; text-decoration: none; margin-right: 20px; }
        .flash { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .flash.success { background: #d4edda; color: #155724; }
        .flash.error { background: #f8d7da; color: #721c24; }
        form { margin: 20px 0; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <nav>
        <a href="{{ url_for('index') }}">Home</a>
        {% if session.username %}
            <a href="{{ url_for('dashboard') }}">Dashboard</a>
            <a href="{{ url_for('create_post') }}">Create Post</a>
            <a href="{{ url_for('logout') }}">Logout ({{ session.username }})</a>
        {% else %}
            <a href="{{ url_for('login') }}">Login</a>
            <a href="{{ url_for('register') }}">Register</a>
        {% endif %}
    </nav>
    
    {% with messages = get_flashed_messages() %}
        {% if messages %}
            {% for message in messages %}
                <div class="flash success">{{ message }}</div>
            {% endfor %}
        {% endif %}
    {% endwith %}
    
    <main>
        {% block content %}{% endblock %}
    </main>
</body>
</html>
```

```html
<!-- templates/register.html -->
{% extends "base.html" %}

{% block title %}Register{% endblock %}

{% block content %}
    <h1>Register</h1>
    <form method="POST">
        <div>
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" required>
        </div>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="{{ url_for('login') }}">Login</a></p>
{% endblock %}
```

```html
<!-- templates/login.html -->
{% extends "base.html" %}

{% block title %}Login{% endblock %}

{% block content %}
    <h1>Login</h1>
    <form method="POST">
        <div>
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="{{ url_for('register') }}">Register</a></p>
{% endblock %}
```

```html
<!-- templates/dashboard.html -->
{% extends "base.html" %}

{% block title %}Dashboard{% endblock %}

{% block content %}
    <h1>Welcome, {{ user.username }}!</h1>
    <p>Email: {{ user.email }}</p>
    
    <h2>Your Posts</h2>
    {% if posts %}
        <ul>
        {% for post in posts %}
            <li>
                <a href="{{ url_for('post', post_id=post.id) }}">{{ post.title }}</a>
                <small>{{ post.created_at.strftime('%Y-%m-%d') }}</small>
            </li>
        {% endfor %}
        </ul>
    {% else %}
        <p>No posts yet. <a href="{{ url_for('create_post') }}">Create your first post</a></p>
    {% endif %}
{% endblock %}
```

**Expected Output**: A complete Flask application with user registration, login, protected routes, and a blog system.

**Challenge** (Optional):
- Add email verification
- Implement password reset functionality
- Add user profile editing
- Create an admin panel
- Add comment system to posts

---

## Key Takeaways

1. **Forms and validation** - Flask-WTF for forms, WTForms for validation
2. **Database integration** - SQLAlchemy ORM
3. **User authentication** - sessions, password hashing, protected routes
4. **Sessions** - maintain state across requests
5. **File uploads** - handle file uploads securely
6. **Security** - CSRF protection, password hashing, input validation
7. **Flask extensions** - Flask-WTF, Flask-SQLAlchemy, Flask-Login
8. **Models** - define database models
9. **Queries** - query database with SQLAlchemy
10. **Relationships** - one-to-many, many-to-many
11. **Password security** - always hash passwords
12. **Session management** - use sessions for authentication
13. **Protected routes** - use decorators to protect routes
14. **Best practices** - application factory, blueprints, migrations
15. **Error handling** - handle errors gracefully

---

## Quiz: Flask Advanced

Test your understanding with these questions:

1. **What is Flask-WTF used for?**
   - A) Database
   - B) Forms and CSRF protection
   - C) Authentication
   - D) Templates

2. **What ORM is commonly used with Flask?**
   - A) Django ORM
   - B) SQLAlchemy
   - C) Peewee
   - D) SQLObject

3. **How do you hash passwords in Flask?**
   - A) hash()
   - B) generate_password_hash()
   - C) encrypt()
   - D) secure()

4. **What decorator protects routes?**
   - A) @protected
   - B) @login_required
   - C) @auth
   - D) @secure

5. **What is used to maintain state?**
   - A) Cookies
   - B) Sessions
   - C) Database
   - D) Files

6. **What should you NEVER store in sessions?**
   - A) User ID
   - B) Username
   - C) Passwords
   - D) Preferences

7. **What validates form input?**
   - A) Flask
   - B) WTForms validators
   - C) Python
   - D) HTML

8. **What creates database tables?**
   - A) db.create()
   - B) db.create_all()
   - C) db.init()
   - D) db.setup()

9. **What is CSRF protection for?**
   - A) SQL injection
   - B) Cross-site request forgery
   - C) XSS
   - D) Authentication

10. **What should you use for database migrations?**
    - A) Manual SQL
    - B) Flask-Migrate
    - C) No migrations
    - D) Git

**Answers**:
1. B) Forms and CSRF protection (Flask-WTF purpose)
2. B) SQLAlchemy (common Flask ORM)
3. B) generate_password_hash() (password hashing)
4. B) @login_required (route protection)
5. B) Sessions (state management)
6. C) Passwords (never in sessions)
7. B) WTForms validators (form validation)
8. B) db.create_all() (create tables)
9. B) Cross-site request forgery (CSRF protection)
10. B) Flask-Migrate (database migrations)

---

## Next Steps

Excellent work! You've mastered Flask advanced features. You now understand:
- Forms and validation
- Database integration
- User authentication
- How to build complete applications

**What's Next?**
- Lesson 19.4: Django Framework (Introduction)
- Learn Django installation
- Understand project structure
- Explore Django features

---

## Additional Resources

- **Flask-WTF**: [flask-wtf.readthedocs.io/](https://flask-wtf.readthedocs.io/)
- **Flask-SQLAlchemy**: [flask-sqlalchemy.palletsprojects.com/](https://flask-sqlalchemy.palletsprojects.com/)
- **Flask-Login**: [flask-login.readthedocs.io/](https://flask-login.readthedocs.io/)
- **WTForms**: [wtforms.readthedocs.io/](https://wtforms.readthedocs.io/)

---

*Lesson completed! You're ready to move on to the next lesson.*

