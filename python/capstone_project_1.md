# Capstone Project 1: Full-Stack Web Application

## Project Overview

Build a complete full-stack web application using Python, demonstrating mastery of web development, database management, API design, authentication, and deployment.

**Project Duration**: 2-3 weeks  
**Difficulty**: Advanced  
**Technologies**: Flask/Django, SQLAlchemy, HTML/CSS/JavaScript, Database (SQLite/PostgreSQL)

---

## Learning Objectives

By completing this project, you will:
- Design and implement a full-stack web application
- Create RESTful APIs
- Implement user authentication and authorization
- Design and manage databases
- Build responsive user interfaces
- Handle file uploads and media
- Implement search and filtering
- Deploy application to production
- Write comprehensive tests
- Document your code

---

## Project Requirements

### Core Requirements

1. **Backend Framework**: Use Flask or Django
2. **Database**: SQLite (development) or PostgreSQL (production)
3. **Authentication**: User registration, login, logout
4. **CRUD Operations**: Create, Read, Update, Delete functionality
5. **API Endpoints**: RESTful API design
6. **Frontend**: Responsive web interface
7. **Testing**: Unit tests and integration tests
8. **Documentation**: README, API documentation, code comments

### Functional Requirements

1. **User Management**
   - User registration with validation
   - User login/logout
   - Password hashing
   - User profiles
   - Role-based access control (optional)

2. **Core Features** (Choose one domain):
   - **Blog Platform**: Posts, comments, categories, tags
   - **Task Manager**: Tasks, projects, teams, deadlines
   - **E-commerce**: Products, cart, orders, payments (simulated)
   - **Social Network**: Posts, followers, likes, comments
   - **Learning Platform**: Courses, lessons, progress tracking

3. **Additional Features**
   - Search functionality
   - Pagination
   - File uploads (images, documents)
   - Email notifications (optional)
   - API documentation

### Technical Requirements

1. **Code Quality**
   - Follow PEP 8 style guide
   - Type hints where appropriate
   - Docstrings for all functions/classes
   - Error handling
   - Input validation

2. **Security**
   - Password hashing (bcrypt)
   - CSRF protection
   - SQL injection prevention
   - XSS protection
   - Secure session management

3. **Testing**
   - Minimum 80% code coverage
   - Unit tests
   - Integration tests
   - API endpoint tests

4. **Deployment**
   - Environment configuration
   - Production-ready settings
   - Database migrations
   - Deployment documentation

---

## Suggested Project: Task Management Platform

### Features

1. **User Features**
   - Register/Login/Logout
   - User profile management
   - Dashboard

2. **Task Management**
   - Create, read, update, delete tasks
   - Task categories/tags
   - Task priorities
   - Due dates
   - Task status (pending, in progress, completed)

3. **Project Management**
   - Create projects
   - Assign tasks to projects
   - Project members (optional)
   - Project progress tracking

4. **Additional Features**
   - Search tasks
   - Filter by status, priority, category
   - Task statistics
   - Export tasks (CSV/JSON)

---

## Technology Stack

### Backend
- **Framework**: Flask or Django
- **ORM**: SQLAlchemy (Flask) or Django ORM
- **Authentication**: Flask-Login or Django Auth
- **API**: Flask-RESTful or Django REST Framework
- **Validation**: WTForms or Django Forms

### Database
- **Development**: SQLite
- **Production**: PostgreSQL (optional)

### Frontend
- **Templates**: Jinja2 (Flask) or Django Templates
- **Styling**: Bootstrap or Tailwind CSS
- **JavaScript**: Vanilla JS or jQuery
- **AJAX**: For API interactions

### Testing
- **Framework**: pytest or unittest
- **Coverage**: pytest-cov
- **API Testing**: requests library

### Deployment
- **Platform**: Heroku, Railway, or DigitalOcean
- **Database**: PostgreSQL (production)
- **Environment**: Environment variables

---

## Project Structure

### Flask Structure

```
taskmanager/
├── README.md
├── requirements.txt
├── .env.example
├── .gitignore
├── app/
│   ├── __init__.py
│   ├── config.py
│   ├── models/
│   │   ├── __init__.py
│   │   ├── user.py
│   │   ├── task.py
│   │   └── project.py
│   ├── routes/
│   │   ├── __init__.py
│   │   ├── auth.py
│   │   ├── tasks.py
│   │   └── projects.py
│   ├── api/
│   │   ├── __init__.py
│   │   ├── auth.py
│   │   ├── tasks.py
│   │   └── projects.py
│   ├── forms/
│   │   ├── __init__.py
│   │   ├── auth.py
│   │   └── task.py
│   ├── utils/
│   │   ├── __init__.py
│   │   ├── helpers.py
│   │   └── validators.py
│   ├── templates/
│   │   ├── base.html
│   │   ├── auth/
│   │   │   ├── login.html
│   │   │   └── register.html
│   │   ├── tasks/
│   │   │   ├── list.html
│   │   │   ├── create.html
│   │   │   └── detail.html
│   │   └── dashboard.html
│   ├── static/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   └── migrations/
├── tests/
│   ├── __init__.py
│   ├── conftest.py
│   ├── test_models.py
│   ├── test_routes.py
│   └── test_api.py
└── run.py
```

### Django Structure

```
taskmanager/
├── manage.py
├── requirements.txt
├── .env.example
├── taskmanager/
│   ├── __init__.py
│   ├── settings.py
│   ├── urls.py
│   ├── wsgi.py
│   └── asgi.py
├── accounts/
│   ├── models.py
│   ├── views.py
│   ├── urls.py
│   └── templates/
├── tasks/
│   ├── models.py
│   ├── views.py
│   ├── urls.py
│   ├── serializers.py
│   └── templates/
├── projects/
│   ├── models.py
│   ├── views.py
│   ├── urls.py
│   └── templates/
├── static/
├── media/
└── tests/
```

---

## Implementation Guide

### Phase 1: Setup and Configuration (Days 1-2)

#### Step 1: Project Setup

```bash
# Create project directory
mkdir taskmanager
cd taskmanager

# Create virtual environment
python -m venv venv
source venv/bin/activate  # Linux/macOS
# venv\Scripts\activate   # Windows

# Install dependencies
pip install flask flask-sqlalchemy flask-login flask-wtf flask-migrate
pip install bcrypt python-dotenv
pip install pytest pytest-cov

# Create requirements.txt
pip freeze > requirements.txt
```

#### Step 2: Project Structure

```bash
# Create directory structure
mkdir -p app/{models,routes,api,forms,utils,templates,static/{css,js,images}}
mkdir -p tests
touch app/__init__.py app/config.py
touch app/models/__init__.py
touch app/routes/__init__.py
touch app/api/__init__.py
touch tests/__init__.py
```

#### Step 3: Configuration

```python
# app/config.py
import os
from pathlib import Path

class Config:
    """Base configuration."""
    SECRET_KEY = os.getenv('SECRET_KEY', 'dev-secret-key-change-in-production')
    SQLALCHEMY_DATABASE_URI = os.getenv(
        'DATABASE_URL',
        f'sqlite:///{Path(__file__).parent.parent / "taskmanager.db"}'
    )
    SQLALCHEMY_TRACK_MODIFICATIONS = False
    
    # Flask-Login
    REMEMBER_COOKIE_DURATION = 86400  # 1 day
    
    # File uploads
    MAX_CONTENT_LENGTH = 16 * 1024 * 1024  # 16MB
    UPLOAD_FOLDER = Path(__file__).parent.parent / 'uploads'
    
    # Pagination
    ITEMS_PER_PAGE = 10

class DevelopmentConfig(Config):
    DEBUG = True

class ProductionConfig(Config):
    DEBUG = False
    SQLALCHEMY_DATABASE_URI = os.getenv('DATABASE_URL')

config = {
    'development': DevelopmentConfig,
    'production': ProductionConfig,
    'default': DevelopmentConfig
}
```

```python
# app/__init__.py
from flask import Flask
from flask_sqlalchemy import SQLAlchemy
from flask_login import LoginManager
from flask_migrate import Migrate
from app.config import config
import os

db = SQLAlchemy()
login_manager = LoginManager()
migrate = Migrate()

def create_app(config_name=None):
    """Application factory."""
    app = Flask(__name__)
    
    # Load configuration
    config_name = config_name or os.getenv('FLASK_ENV', 'default')
    app.config.from_object(config[config_name])
    
    # Initialize extensions
    db.init_app(app)
    login_manager.init_app(app)
    login_manager.login_view = 'auth.login'
    login_manager.login_message = 'Please log in to access this page.'
    migrate.init_app(app, db)
    
    # Register blueprints
    from app.routes.auth import auth_bp
    from app.routes.tasks import tasks_bp
    from app.routes.projects import projects_bp
    from app.api import api_bp
    
    app.register_blueprint(auth_bp, url_prefix='/auth')
    app.register_blueprint(tasks_bp, url_prefix='/tasks')
    app.register_blueprint(projects_bp, url_prefix='/projects')
    app.register_blueprint(api_bp, url_prefix='/api')
    
    # Create database tables
    with app.app_context():
        db.create_all()
    
    return app
```

### Phase 2: Database Models (Days 3-4)

#### User Model

```python
# app/models/user.py
from app import db
from flask_login import UserMixin
from werkzeug.security import generate_password_hash, check_password_hash
from datetime import datetime

class User(UserMixin, db.Model):
    """User model."""
    __tablename__ = 'users'
    
    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(80), unique=True, nullable=False, index=True)
    email = db.Column(db.String(120), unique=True, nullable=False, index=True)
    password_hash = db.Column(db.String(255), nullable=False)
    first_name = db.Column(db.String(50))
    last_name = db.Column(db.String(50))
    created_at = db.Column(db.DateTime, default=datetime.utcnow)
    is_active = db.Column(db.Boolean, default=True)
    
    # Relationships
    tasks = db.relationship('Task', backref='user', lazy='dynamic', cascade='all, delete-orphan')
    projects = db.relationship('Project', backref='user', lazy='dynamic', cascade='all, delete-orphan')
    
    def set_password(self, password):
        """Set password hash."""
        self.password_hash = generate_password_hash(password)
    
    def check_password(self, password):
        """Check password."""
        return check_password_hash(self.password_hash, password)
    
    def __repr__(self):
        return f'<User {self.username}>'
```

#### Task Model

```python
# app/models/task.py
from app import db
from datetime import datetime
from enum import Enum

class TaskStatus(Enum):
    PENDING = 'pending'
    IN_PROGRESS = 'in_progress'
    COMPLETED = 'completed'
    CANCELLED = 'cancelled'

class TaskPriority(Enum):
    LOW = 'low'
    MEDIUM = 'medium'
    HIGH = 'high'
    URGENT = 'urgent'

class Task(db.Model):
    """Task model."""
    __tablename__ = 'tasks'
    
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(200), nullable=False)
    description = db.Column(db.Text)
    status = db.Column(db.String(20), default=TaskStatus.PENDING.value)
    priority = db.Column(db.String(20), default=TaskPriority.MEDIUM.value)
    due_date = db.Column(db.DateTime)
    created_at = db.Column(db.DateTime, default=datetime.utcnow)
    updated_at = db.Column(db.DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)
    
    # Foreign keys
    user_id = db.Column(db.Integer, db.ForeignKey('users.id'), nullable=False)
    project_id = db.Column(db.Integer, db.ForeignKey('projects.id'), nullable=True)
    
    # Relationships
    project = db.relationship('Project', backref='tasks')
    
    def __repr__(self):
        return f'<Task {self.title}>'
    
    def to_dict(self):
        """Convert to dictionary."""
        return {
            'id': self.id,
            'title': self.title,
            'description': self.description,
            'status': self.status,
            'priority': self.priority,
            'due_date': self.due_date.isoformat() if self.due_date else None,
            'created_at': self.created_at.isoformat(),
            'user_id': self.user_id,
            'project_id': self.project_id
        }
```

#### Project Model

```python
# app/models/project.py
from app import db
from datetime import datetime

class Project(db.Model):
    """Project model."""
    __tablename__ = 'projects'
    
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(200), nullable=False)
    description = db.Column(db.Text)
    created_at = db.Column(db.DateTime, default=datetime.utcnow)
    updated_at = db.Column(db.DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)
    
    # Foreign keys
    user_id = db.Column(db.Integer, db.ForeignKey('users.id'), nullable=False)
    
    def __repr__(self):
        return f'<Project {self.name}>'
    
    def to_dict(self):
        """Convert to dictionary."""
        return {
            'id': self.id,
            'name': self.name,
            'description': self.description,
            'created_at': self.created_at.isoformat(),
            'user_id': self.user_id,
            'task_count': self.tasks.count()
        }
```

```python
# app/models/__init__.py
from app.models.user import User
from app.models.task import Task, TaskStatus, TaskPriority
from app.models.project import Project

__all__ = ['User', 'Task', 'TaskStatus', 'TaskPriority', 'Project']
```

### Phase 3: Authentication (Days 5-6)

#### Login Manager

```python
# app/__init__.py (add to existing)
from app.models import User

@login_manager.user_loader
def load_user(user_id):
    """Load user for Flask-Login."""
    return User.query.get(int(user_id))
```

#### Authentication Forms

```python
# app/forms/auth.py
from flask_wtf import FlaskForm
from wtforms import StringField, PasswordField, SubmitField, BooleanField
from wtforms.validators import DataRequired, Email, Length, EqualTo, ValidationError
from app.models import User

class RegistrationForm(FlaskForm):
    """User registration form."""
    username = StringField('Username', validators=[
        DataRequired(),
        Length(min=4, max=20, message='Username must be between 4 and 20 characters')
    ])
    email = StringField('Email', validators=[
        DataRequired(),
        Email(message='Invalid email address')
    ])
    password = PasswordField('Password', validators=[
        DataRequired(),
        Length(min=8, message='Password must be at least 8 characters')
    ])
    password2 = PasswordField('Confirm Password', validators=[
        DataRequired(),
        EqualTo('password', message='Passwords must match')
    ])
    submit = SubmitField('Register')
    
    def validate_username(self, username):
        """Validate username uniqueness."""
        user = User.query.filter_by(username=username.data).first()
        if user:
            raise ValidationError('Username already exists. Please choose a different one.')
    
    def validate_email(self, email):
        """Validate email uniqueness."""
        user = User.query.filter_by(email=email.data).first()
        if user:
            raise ValidationError('Email already registered. Please use a different email.')

class LoginForm(FlaskForm):
    """User login form."""
    username = StringField('Username', validators=[DataRequired()])
    password = PasswordField('Password', validators=[DataRequired()])
    remember_me = BooleanField('Remember Me')
    submit = SubmitField('Login')
```

#### Authentication Routes

```python
# app/routes/auth.py
from flask import Blueprint, render_template, redirect, url_for, flash, request
from flask_login import login_user, logout_user, login_required, current_user
from app import db
from app.models import User
from app.forms.auth import RegistrationForm, LoginForm

auth_bp = Blueprint('auth', __name__)

@auth_bp.route('/register', methods=['GET', 'POST'])
def register():
    """User registration."""
    if current_user.is_authenticated:
        return redirect(url_for('tasks.list'))
    
    form = RegistrationForm()
    if form.validate_on_submit():
        user = User(
            username=form.username.data,
            email=form.email.data
        )
        user.set_password(form.password.data)
        db.session.add(user)
        db.session.commit()
        flash('Registration successful! Please log in.', 'success')
        return redirect(url_for('auth.login'))
    
    return render_template('auth/register.html', form=form)

@auth_bp.route('/login', methods=['GET', 'POST'])
def login():
    """User login."""
    if current_user.is_authenticated:
        return redirect(url_for('tasks.list'))
    
    form = LoginForm()
    if form.validate_on_submit():
        user = User.query.filter_by(username=form.username.data).first()
        if user and user.check_password(form.password.data):
            login_user(user, remember=form.remember_me.data)
            next_page = request.args.get('next')
            return redirect(next_page) if next_page else redirect(url_for('tasks.list'))
        flash('Invalid username or password.', 'error')
    
    return render_template('auth/login.html', form=form)

@auth_bp.route('/logout')
@login_required
def logout():
    """User logout."""
    logout_user()
    flash('You have been logged out.', 'info')
    return redirect(url_for('auth.login'))
```

### Phase 4: Task Management (Days 7-10)

#### Task Forms

```python
# app/forms/task.py
from flask_wtf import FlaskForm
from wtforms import StringField, TextAreaField, SelectField, DateTimeField, SubmitField
from wtforms.validators import DataRequired, Optional
from app.models import TaskStatus, TaskPriority

class TaskForm(FlaskForm):
    """Task creation/editing form."""
    title = StringField('Title', validators=[DataRequired()])
    description = TextAreaField('Description')
    status = SelectField('Status', choices=[
        (status.value, status.value.replace('_', ' ').title())
        for status in TaskStatus
    ])
    priority = SelectField('Priority', choices=[
        (priority.value, priority.value.title())
        for priority in TaskPriority
    ])
    due_date = DateTimeField('Due Date', format='%Y-%m-%d %H:%M', validators=[Optional()])
    submit = SubmitField('Save Task')
```

#### Task Routes

```python
# app/routes/tasks.py
from flask import Blueprint, render_template, request, flash, redirect, url_for, jsonify
from flask_login import login_required, current_user
from app import db
from app.models import Task, Project
from app.forms.task import TaskForm
from datetime import datetime

tasks_bp = Blueprint('tasks', __name__)

@tasks_bp.route('/')
@login_required
def list():
    """List all tasks for current user."""
    page = request.args.get('page', 1, type=int)
    status = request.args.get('status', 'all')
    priority = request.args.get('priority', 'all')
    search = request.args.get('search', '')
    
    query = Task.query.filter_by(user_id=current_user.id)
    
    # Filters
    if status != 'all':
        query = query.filter_by(status=status)
    if priority != 'all':
        query = query.filter_by(priority=priority)
    if search:
        query = query.filter(
            Task.title.contains(search) | Task.description.contains(search)
        )
    
    tasks = query.order_by(Task.created_at.desc()).paginate(
        page=page, per_page=10, error_out=False
    )
    
    return render_template('tasks/list.html', tasks=tasks, 
                         status=status, priority=priority, search=search)

@tasks_bp.route('/create', methods=['GET', 'POST'])
@login_required
def create():
    """Create a new task."""
    form = TaskForm()
    form.project_id.choices = [(0, 'None')] + [
        (p.id, p.name) for p in Project.query.filter_by(user_id=current_user.id).all()
    ]
    
    if form.validate_on_submit():
        task = Task(
            title=form.title.data,
            description=form.description.data,
            status=form.status.data,
            priority=form.priority.data,
            due_date=form.due_date.data,
            user_id=current_user.id,
            project_id=form.project_id.data if form.project_id.data else None
        )
        db.session.add(task)
        db.session.commit()
        flash('Task created successfully!', 'success')
        return redirect(url_for('tasks.detail', id=task.id))
    
    return render_template('tasks/create.html', form=form)

@tasks_bp.route('/<int:id>')
@login_required
def detail(id):
    """View task details."""
    task = Task.query.get_or_404(id)
    if task.user_id != current_user.id:
        flash('You do not have permission to view this task.', 'error')
        return redirect(url_for('tasks.list'))
    
    return render_template('tasks/detail.html', task=task)

@tasks_bp.route('/<int:id>/edit', methods=['GET', 'POST'])
@login_required
def edit(id):
    """Edit a task."""
    task = Task.query.get_or_404(id)
    if task.user_id != current_user.id:
        flash('You do not have permission to edit this task.', 'error')
        return redirect(url_for('tasks.list'))
    
    form = TaskForm(obj=task)
    form.project_id.choices = [(0, 'None')] + [
        (p.id, p.name) for p in Project.query.filter_by(user_id=current_user.id).all()
    ]
    
    if form.validate_on_submit():
        task.title = form.title.data
        task.description = form.description.data
        task.status = form.status.data
        task.priority = form.priority.data
        task.due_date = form.due_date.data
        task.updated_at = datetime.utcnow()
        db.session.commit()
        flash('Task updated successfully!', 'success')
        return redirect(url_for('tasks.detail', id=task.id))
    
    return render_template('tasks/edit.html', form=form, task=task)

@tasks_bp.route('/<int:id>/delete', methods=['POST'])
@login_required
def delete(id):
    """Delete a task."""
    task = Task.query.get_or_404(id)
    if task.user_id != current_user.id:
        flash('You do not have permission to delete this task.', 'error')
        return redirect(url_for('tasks.list'))
    
    db.session.delete(task)
    db.session.commit()
    flash('Task deleted successfully!', 'success')
    return redirect(url_for('tasks.list'))
```

### Phase 5: API Development (Days 11-12)

#### API Routes

```python
# app/api/__init__.py
from flask import Blueprint
from flask_restful import Api

api_bp = Blueprint('api', __name__)
api = Api(api_bp)

from app.api import tasks, auth

# Register resources
api.add_resource(tasks.TaskListResource, '/tasks')
api.add_resource(tasks.TaskResource, '/tasks/<int:id>')
api.add_resource(auth.LoginResource, '/auth/login')
```

```python
# app/api/tasks.py
from flask_restful import Resource, reqparse
from flask_login import login_required, current_user
from app import db
from app.models import Task

parser = reqparse.RequestParser()
parser.add_argument('title', type=str, required=True, help='Title is required')
parser.add_argument('description', type=str)
parser.add_argument('status', type=str)
parser.add_argument('priority', type=str)
parser.add_argument('due_date', type=str)

class TaskListResource(Resource):
    """Task list API endpoint."""
    
    @login_required
    def get(self):
        """Get all tasks for current user."""
        tasks = Task.query.filter_by(user_id=current_user.id).all()
        return {'tasks': [task.to_dict() for task in tasks]}, 200
    
    @login_required
    def post(self):
        """Create a new task."""
        args = parser.parse_args()
        task = Task(
            title=args['title'],
            description=args.get('description'),
            status=args.get('status', 'pending'),
            priority=args.get('priority', 'medium'),
            user_id=current_user.id
        )
        db.session.add(task)
        db.session.commit()
        return task.to_dict(), 201

class TaskResource(Resource):
    """Single task API endpoint."""
    
    @login_required
    def get(self, id):
        """Get task by ID."""
        task = Task.query.get_or_404(id)
        if task.user_id != current_user.id:
            return {'error': 'Unauthorized'}, 403
        return task.to_dict(), 200
    
    @login_required
    def put(self, id):
        """Update task."""
        task = Task.query.get_or_404(id)
        if task.user_id != current_user.id:
            return {'error': 'Unauthorized'}, 403
        
        args = parser.parse_args()
        task.title = args['title']
        task.description = args.get('description')
        task.status = args.get('status', task.status)
        task.priority = args.get('priority', task.priority)
        db.session.commit()
        return task.to_dict(), 200
    
    @login_required
    def delete(self, id):
        """Delete task."""
        task = Task.query.get_or_404(id)
        if task.user_id != current_user.id:
            return {'error': 'Unauthorized'}, 403
        
        db.session.delete(task)
        db.session.commit()
        return {'message': 'Task deleted'}, 200
```

### Phase 6: Frontend Templates (Days 13-14)

#### Base Template

```html
<!-- app/templates/base.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{% block title %}Task Manager{% endblock %}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ url_for('static', filename='css/style.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url_for('tasks.list') }}">Task Manager</a>
            <div class="navbar-nav ms-auto">
                {% if current_user.is_authenticated %}
                    <a class="nav-link" href="{{ url_for('tasks.list') }}">Tasks</a>
                    <a class="nav-link" href="{{ url_for('projects.list') }}">Projects</a>
                    <a class="nav-link" href="{{ url_for('auth.logout') }}">Logout</a>
                {% else %}
                    <a class="nav-link" href="{{ url_for('auth.login') }}">Login</a>
                    <a class="nav-link" href="{{ url_for('auth.register') }}">Register</a>
                {% endif %}
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        {% with messages = get_flashed_messages(with_categories=true) %}
            {% if messages %}
                {% for category, message in messages %}
                    <div class="alert alert-{{ 'danger' if category == 'error' else category }} alert-dismissible fade show" role="alert">
                        {{ message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                {% endfor %}
            {% endif %}
        {% endwith %}
        
        {% block content %}{% endblock %}
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    {% block scripts %}{% endblock %}
</body>
</html>
```

#### Task List Template

```html
<!-- app/templates/tasks/list.html -->
{% extends "base.html" %}

{% block content %}
<div class="row">
    <div class="col-md-12">
        <h1>My Tasks</h1>
        <a href="{{ url_for('tasks.create') }}" class="btn btn-primary mb-3">Create New Task</a>
        
        <!-- Filters -->
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ search }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="all" {% if status == 'all' %}selected{% endif %}>All Status</option>
                        <option value="pending" {% if status == 'pending' %}selected{% endif %}>Pending</option>
                        <option value="in_progress" {% if status == 'in_progress' %}selected{% endif %}>In Progress</option>
                        <option value="completed" {% if status == 'completed' %}selected{% endif %}>Completed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary">Filter</button>
                </div>
            </div>
        </form>
        
        <!-- Task List -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {% for task in tasks.items %}
                    <tr>
                        <td><a href="{{ url_for('tasks.detail', id=task.id) }}">{{ task.title }}</a></td>
                        <td><span class="badge bg-{{ 'success' if task.status == 'completed' else 'warning' }}">{{ task.status }}</span></td>
                        <td><span class="badge bg-{{ 'danger' if task.priority == 'urgent' else 'info' }}">{{ task.priority }}</span></td>
                        <td>{{ task.due_date.strftime('%Y-%m-%d') if task.due_date else '-' }}</td>
                        <td>
                            <a href="{{ url_for('tasks.edit', id=task.id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ url_for('tasks.delete', id=task.id) }}" class="d-inline">
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    {% endfor %}
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        {% if tasks.pages > 1 %}
        <nav>
            <ul class="pagination">
                {% if tasks.has_prev %}
                    <li class="page-item"><a class="page-link" href="{{ url_for('tasks.list', page=tasks.prev_num) }}">Previous</a></li>
                {% endif %}
                {% for page_num in tasks.iter_pages() %}
                    {% if page_num %}
                        <li class="page-item {% if page_num == tasks.page %}active{% endif %}">
                            <a class="page-link" href="{{ url_for('tasks.list', page=page_num) }}">{{ page_num }}</a>
                        </li>
                    {% else %}
                        <li class="page-item disabled"><span class="page-link">…</span></li>
                    {% endif %}
                {% endfor %}
                {% if tasks.has_next %}
                    <li class="page-item"><a class="page-link" href="{{ url_for('tasks.list', page=tasks.next_num) }}">Next</a></li>
                {% endif %}
            </ul>
        </nav>
        {% endif %}
    </div>
</div>
{% endblock %}
```

### Phase 7: Testing (Days 15-16)

#### Test Configuration

```python
# tests/conftest.py
import pytest
from app import create_app, db
from app.models import User, Task

@pytest.fixture
def app():
    """Create test application."""
    app = create_app('testing')
    app.config['TESTING'] = True
    app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///:memory:'
    
    with app.app_context():
        db.create_all()
        yield app
        db.drop_all()

@pytest.fixture
def client(app):
    """Create test client."""
    return app.test_client()

@pytest.fixture
def user(app):
    """Create test user."""
    user = User(username='testuser', email='test@example.com')
    user.set_password('password123')
    with app.app_context():
        db.session.add(user)
        db.session.commit()
    return user
```

#### Test Examples

```python
# tests/test_models.py
import pytest
from app import db
from app.models import User, Task

def test_user_creation(app):
    """Test user creation."""
    with app.app_context():
        user = User(username='testuser', email='test@example.com')
        user.set_password('password123')
        db.session.add(user)
        db.session.commit()
        
        assert user.id is not None
        assert user.check_password('password123')
        assert not user.check_password('wrongpassword')

def test_task_creation(app, user):
    """Test task creation."""
    with app.app_context():
        task = Task(
            title='Test Task',
            description='Test Description',
            user_id=user.id
        )
        db.session.add(task)
        db.session.commit()
        
        assert task.id is not None
        assert task.user_id == user.id
```

```python
# tests/test_routes.py
import pytest
from app.models import User, Task

def test_login(client, user):
    """Test user login."""
    response = client.post('/auth/login', data={
        'username': 'testuser',
        'password': 'password123'
    }, follow_redirects=True)
    
    assert response.status_code == 200
    assert b'Task Manager' in response.data

def test_create_task(client, user):
    """Test task creation."""
    # Login first
    client.post('/auth/login', data={
        'username': 'testuser',
        'password': 'password123'
    })
    
    # Create task
    response = client.post('/tasks/create', data={
        'title': 'New Task',
        'description': 'Task Description',
        'status': 'pending',
        'priority': 'medium'
    }, follow_redirects=True)
    
    assert response.status_code == 200
    assert b'New Task' in response.data
```

### Phase 8: Deployment (Days 17-18)

#### Environment Configuration

```bash
# .env.example
FLASK_ENV=production
SECRET_KEY=your-secret-key-here
DATABASE_URL=postgresql://user:password@localhost/taskmanager
DEBUG=False
```

#### Deployment Checklist

- [ ] Set environment variables
- [ ] Configure production database
- [ ] Set up static file serving
- [ ] Configure error logging
- [ ] Set up SSL/HTTPS
- [ ] Configure domain
- [ ] Set up backups
- [ ] Monitor application

---

## Evaluation Criteria

### Functionality (40%)
- All core features implemented
- User authentication works
- CRUD operations functional
- API endpoints working
- Error handling

### Code Quality (25%)
- Follows PEP 8
- Proper code organization
- Type hints and docstrings
- No code duplication
- Clean architecture

### Testing (15%)
- Unit tests written
- Integration tests
- Test coverage > 80%
- Tests pass

### Documentation (10%)
- README with setup instructions
- API documentation
- Code comments
- Deployment guide

### Security (10%)
- Password hashing
- CSRF protection
- Input validation
- SQL injection prevention

---

## Submission Requirements

1. **GitHub Repository**
   - Complete source code
   - README.md
   - requirements.txt
   - .gitignore

2. **Documentation**
   - Setup instructions
   - API documentation
   - Deployment guide

3. **Testing**
   - Test files
   - Coverage report

4. **Demo**
   - Working application
   - Screenshots/video
   - Live deployment (optional)

---

## Additional Resources

- **Flask Documentation**: flask.palletsprojects.com
- **SQLAlchemy Documentation**: docs.sqlalchemy.org
- **Bootstrap Documentation**: getbootstrap.com
- **REST API Design**: restfulapi.net
- **Deployment Guides**: Heroku, Railway, DigitalOcean

---

## Next Steps

After completing this project:
1. Add more features (notifications, file uploads)
2. Implement real-time updates (WebSockets)
3. Add mobile app (React Native)
4. Implement advanced search
5. Add analytics and reporting

---

*Good luck with your capstone project!*

