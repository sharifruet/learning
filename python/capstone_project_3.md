# Capstone Project 3: API Development Project

## Project Overview

Build a production-ready RESTful API demonstrating mastery of API design, implementation, authentication, testing, documentation, and deployment using Python.

**Project Duration**: 2-3 weeks  
**Difficulty**: Advanced  
**Technologies**: Flask/FastAPI, SQLAlchemy, JWT, pytest, Swagger/OpenAPI, Docker

---

## Learning Objectives

By completing this project, you will:
- Design RESTful API endpoints
- Implement authentication and authorization
- Create database models and relationships
- Handle API requests and responses
- Implement error handling and validation
- Write comprehensive API tests
- Document APIs with OpenAPI/Swagger
- Deploy APIs to production
- Implement rate limiting and security
- Monitor and log API usage

---

## Project Requirements

### Core Requirements

1. **API Framework**: Flask or FastAPI
2. **Database**: PostgreSQL or SQLite
3. **Authentication**: JWT or OAuth2
4. **API Endpoints**: Minimum 10 endpoints
5. **CRUD Operations**: Full CRUD for at least 2 resources
6. **Validation**: Request/response validation
7. **Error Handling**: Proper HTTP status codes
8. **Testing**: Unit and integration tests (>80% coverage)
9. **Documentation**: OpenAPI/Swagger documentation
10. **Deployment**: Production-ready deployment

### Functional Requirements

1. **Authentication & Authorization**
   - User registration
   - User login (JWT tokens)
   - Token refresh
   - Password reset
   - Role-based access control (optional)

2. **Core Resources** (Choose one domain):
   - **Blog API**: Posts, comments, categories, tags
   - **E-commerce API**: Products, orders, cart, payments
   - **Task Management API**: Tasks, projects, teams
   - **Social Media API**: Posts, users, followers, likes
   - **Library Management API**: Books, authors, loans, members

3. **Additional Features**
   - Pagination
   - Filtering and searching
   - Sorting
   - File uploads
   - Rate limiting
   - Caching (optional)
   - Webhooks (optional)

### Technical Requirements

1. **Code Quality**
   - Follow PEP 8
   - Type hints
   - Docstrings
   - Error handling
   - Input validation

2. **Security**
   - Password hashing
   - JWT token security
   - CORS configuration
   - SQL injection prevention
   - XSS protection
   - Rate limiting

3. **Testing**
   - Unit tests
   - Integration tests
   - API endpoint tests
   - Authentication tests
   - Minimum 80% coverage

4. **Documentation**
   - OpenAPI/Swagger docs
   - README with setup instructions
   - API usage examples
   - Deployment guide

---

## Suggested Project: Task Management API

### Features

1. **User Management**
   - Register/Login/Logout
   - User profiles
   - Password management

2. **Task Management**
   - Create, read, update, delete tasks
   - Task categories and tags
   - Task priorities and status
   - Due dates and reminders

3. **Project Management**
   - Create projects
   - Assign tasks to projects
   - Project members
   - Project statistics

4. **Additional Features**
   - Search and filter tasks
   - Task statistics
   - Export tasks (JSON/CSV)
   - Task comments
   - File attachments

---

## Technology Stack

### Backend Framework
- **Flask**: Flask-RESTful, Flask-JWT-Extended
- **FastAPI**: Modern, fast framework with automatic docs

### Database
- **ORM**: SQLAlchemy (Flask) or SQLAlchemy (FastAPI)
- **Database**: PostgreSQL (production) or SQLite (development)
- **Migrations**: Flask-Migrate or Alembic

### Authentication
- **JWT**: Flask-JWT-Extended or python-jose
- **Password**: bcrypt or passlib

### Validation
- **Flask**: Marshmallow or Pydantic
- **FastAPI**: Pydantic (built-in)

### Testing
- **Framework**: pytest
- **API Testing**: requests, pytest-flask
- **Coverage**: pytest-cov

### Documentation
- **Flask**: Flask-RESTX (Swagger)
- **FastAPI**: Built-in OpenAPI/Swagger

### Deployment
- **Containerization**: Docker
- **Platform**: Heroku, Railway, DigitalOcean, AWS
- **Database**: PostgreSQL (production)

---

## Project Structure

### Flask Structure

```
task_api/
├── README.md
├── requirements.txt
├── .env.example
├── .gitignore
├── docker-compose.yml
├── Dockerfile
├── app/
│   ├── __init__.py
│   ├── config.py
│   ├── extensions.py
│   ├── models/
│   │   ├── __init__.py
│   │   ├── user.py
│   │   ├── task.py
│   │   └── project.py
│   ├── schemas/
│   │   ├── __init__.py
│   │   ├── user.py
│   │   ├── task.py
│   │   └── project.py
│   ├── resources/
│   │   ├── __init__.py
│   │   ├── auth.py
│   │   ├── tasks.py
│   │   └── projects.py
│   ├── utils/
│   │   ├── __init__.py
│   │   ├── validators.py
│   │   └── helpers.py
│   └── migrations/
├── tests/
│   ├── __init__.py
│   ├── conftest.py
│   ├── test_models.py
│   ├── test_auth.py
│   ├── test_tasks.py
│   └── test_projects.py
└── run.py
```

### FastAPI Structure

```
task_api/
├── README.md
├── requirements.txt
├── .env.example
├── .gitignore
├── docker-compose.yml
├── Dockerfile
├── app/
│   ├── __init__.py
│   ├── main.py
│   ├── config.py
│   ├── database.py
│   ├── models/
│   │   ├── __init__.py
│   │   ├── user.py
│   │   ├── task.py
│   │   └── project.py
│   ├── schemas/
│   │   ├── __init__.py
│   │   ├── user.py
│   │   ├── task.py
│   │   └── project.py
│   ├── routers/
│   │   ├── __init__.py
│   │   ├── auth.py
│   │   ├── tasks.py
│   │   └── projects.py
│   ├── services/
│   │   ├── __init__.py
│   │   ├── auth.py
│   │   └── tasks.py
│   └── utils/
│       ├── __init__.py
│       └── security.py
├── tests/
│   ├── __init__.py
│   ├── conftest.py
│   ├── test_auth.py
│   ├── test_tasks.py
│   └── test_projects.py
└── alembic/
    └── versions/
```

---

## Implementation Guide

### Phase 1: Project Setup (Days 1-2)

#### Step 1: Environment Setup

```bash
# Create project directory
mkdir task_api
cd task_api

# Create virtual environment
python -m venv venv
source venv/bin/activate  # Linux/macOS
# venv\Scripts\activate   # Windows

# Install dependencies (Flask)
pip install flask flask-restful flask-sqlalchemy flask-migrate
pip install flask-jwt-extended flask-cors marshmallow
pip install bcrypt python-dotenv
pip install pytest pytest-cov pytest-flask
pip install flask-restx  # For Swagger docs

# Or FastAPI
pip install fastapi uvicorn sqlalchemy alembic
pip install pydantic python-jose[cryptography] passlib[bcrypt]
pip install python-multipart
pip install pytest pytest-cov httpx

# Create requirements.txt
pip freeze > requirements.txt
```

#### Step 2: Project Structure

```bash
# Create directory structure
mkdir -p app/{models,schemas,resources,utils}
mkdir -p tests
touch app/__init__.py app/config.py
touch app/models/__init__.py
touch app/schemas/__init__.py
touch app/resources/__init__.py
touch tests/__init__.py
```

#### Step 3: Configuration

```python
# app/config.py (Flask)
import os
from pathlib import Path

class Config:
    """Base configuration."""
    SECRET_KEY = os.getenv('SECRET_KEY', 'dev-secret-key-change-in-production')
    SQLALCHEMY_DATABASE_URI = os.getenv(
        'DATABASE_URL',
        f'sqlite:///{Path(__file__).parent.parent / "task_api.db"}'
    )
    SQLALCHEMY_TRACK_MODIFICATIONS = False
    
    # JWT Configuration
    JWT_SECRET_KEY = os.getenv('JWT_SECRET_KEY', 'jwt-secret-key')
    JWT_ACCESS_TOKEN_EXPIRES = 3600  # 1 hour
    JWT_REFRESH_TOKEN_EXPIRES = 86400  # 24 hours
    
    # CORS
    CORS_ORIGINS = os.getenv('CORS_ORIGINS', '*').split(',')
    
    # Pagination
    ITEMS_PER_PAGE = 20

class DevelopmentConfig(Config):
    DEBUG = True

class ProductionConfig(Config):
    DEBUG = False
    SQLALCHEMY_DATABASE_URI = os.getenv('DATABASE_URL')

class TestingConfig(Config):
    TESTING = True
    SQLALCHEMY_DATABASE_URI = 'sqlite:///:memory:'

config = {
    'development': DevelopmentConfig,
    'production': ProductionConfig,
    'testing': TestingConfig,
    'default': DevelopmentConfig
}
```

```python
# app/config.py (FastAPI)
from pydantic_settings import BaseSettings
from typing import List

class Settings(BaseSettings):
    """Application settings."""
    # App
    APP_NAME: str = "Task Management API"
    DEBUG: bool = False
    
    # Database
    DATABASE_URL: str = "sqlite:///./task_api.db"
    
    # JWT
    SECRET_KEY: str = "dev-secret-key-change-in-production"
    ALGORITHM: str = "HS256"
    ACCESS_TOKEN_EXPIRE_MINUTES: int = 60
    REFRESH_TOKEN_EXPIRE_DAYS: int = 7
    
    # CORS
    CORS_ORIGINS: List[str] = ["*"]
    
    class Config:
        env_file = ".env"

settings = Settings()
```

### Phase 2: Database Models (Days 3-4)

#### User Model

```python
# app/models/user.py (Flask)
from app.extensions import db
from werkzeug.security import generate_password_hash, check_password_hash
from datetime import datetime

class User(db.Model):
    """User model."""
    __tablename__ = 'users'
    
    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(80), unique=True, nullable=False, index=True)
    email = db.Column(db.String(120), unique=True, nullable=False, index=True)
    password_hash = db.Column(db.String(255), nullable=False)
    first_name = db.Column(db.String(50))
    last_name = db.Column(db.String(50))
    is_active = db.Column(db.Boolean, default=True)
    created_at = db.Column(db.DateTime, default=datetime.utcnow)
    updated_at = db.Column(db.DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)
    
    # Relationships
    tasks = db.relationship('Task', backref='user', lazy='dynamic', cascade='all, delete-orphan')
    projects = db.relationship('Project', backref='user', lazy='dynamic', cascade='all, delete-orphan')
    
    def set_password(self, password: str):
        """Set password hash."""
        self.password_hash = generate_password_hash(password)
    
    def check_password(self, password: str) -> bool:
        """Check password."""
        return check_password_hash(self.password_hash, password)
    
    def to_dict(self):
        """Convert to dictionary."""
        return {
            'id': self.id,
            'username': self.username,
            'email': self.email,
            'first_name': self.first_name,
            'last_name': self.last_name,
            'is_active': self.is_active,
            'created_at': self.created_at.isoformat(),
        }
```

```python
# app/models/user.py (FastAPI)
from sqlalchemy import Column, Integer, String, Boolean, DateTime
from sqlalchemy.orm import relationship
from sqlalchemy.sql import func
from app.database import Base

class User(Base):
    """User model."""
    __tablename__ = 'users'
    
    id = Column(Integer, primary_key=True, index=True)
    username = Column(String(80), unique=True, nullable=False, index=True)
    email = Column(String(120), unique=True, nullable=False, index=True)
    password_hash = Column(String(255), nullable=False)
    first_name = Column(String(50))
    last_name = Column(String(50))
    is_active = Column(Boolean, default=True)
    created_at = Column(DateTime(timezone=True), server_default=func.now())
    updated_at = Column(DateTime(timezone=True), onupdate=func.now())
    
    # Relationships
    tasks = relationship('Task', back_populates='user', cascade='all, delete-orphan')
    projects = relationship('Project', back_populates='user', cascade='all, delete-orphan')
```

#### Task Model

```python
# app/models/task.py (Flask)
from app.extensions import db
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
    status = db.Column(db.String(20), default=TaskStatus.PENDING.value, index=True)
    priority = db.Column(db.String(20), default=TaskPriority.MEDIUM.value)
    due_date = db.Column(db.DateTime)
    created_at = db.Column(db.DateTime, default=datetime.utcnow)
    updated_at = db.Column(db.DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)
    
    # Foreign keys
    user_id = db.Column(db.Integer, db.ForeignKey('users.id'), nullable=False, index=True)
    project_id = db.Column(db.Integer, db.ForeignKey('projects.id'), nullable=True, index=True)
    
    # Relationships
    project = db.relationship('Project', backref='tasks')
    
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
            'updated_at': self.updated_at.isoformat(),
            'user_id': self.user_id,
            'project_id': self.project_id
        }
```

### Phase 3: Schemas/Serializers (Days 5-6)

#### Flask with Marshmallow

```python
# app/schemas/task.py
from marshmallow import Schema, fields, validate, post_load
from app.models import Task

class TaskSchema(Schema):
    """Task schema for serialization."""
    id = fields.Int(dump_only=True)
    title = fields.Str(required=True, validate=validate.Length(min=1, max=200))
    description = fields.Str(allow_none=True)
    status = fields.Str(validate=validate.OneOf(['pending', 'in_progress', 'completed', 'cancelled']))
    priority = fields.Str(validate=validate.OneOf(['low', 'medium', 'high', 'urgent']))
    due_date = fields.DateTime(allow_none=True)
    created_at = fields.DateTime(dump_only=True)
    updated_at = fields.DateTime(dump_only=True)
    user_id = fields.Int(dump_only=True)
    project_id = fields.Int(allow_none=True)
    
    @post_load
    def make_task(self, data, **kwargs):
        return Task(**data)

class TaskCreateSchema(Schema):
    """Schema for task creation."""
    title = fields.Str(required=True, validate=validate.Length(min=1, max=200))
    description = fields.Str(allow_none=True)
    status = fields.Str(missing='pending')
    priority = fields.Str(missing='medium')
    due_date = fields.DateTime(allow_none=True)
    project_id = fields.Int(allow_none=True)

class TaskUpdateSchema(Schema):
    """Schema for task update."""
    title = fields.Str(validate=validate.Length(min=1, max=200))
    description = fields.Str(allow_none=True)
    status = fields.Str(validate=validate.OneOf(['pending', 'in_progress', 'completed', 'cancelled']))
    priority = fields.Str(validate=validate.OneOf(['low', 'medium', 'high', 'urgent']))
    due_date = fields.DateTime(allow_none=True)
    project_id = fields.Int(allow_none=True)
```

#### FastAPI with Pydantic

```python
# app/schemas/task.py
from pydantic import BaseModel, Field, validator
from typing import Optional
from datetime import datetime
from enum import Enum

class TaskStatus(str, Enum):
    PENDING = 'pending'
    IN_PROGRESS = 'in_progress'
    COMPLETED = 'completed'
    CANCELLED = 'cancelled'

class TaskPriority(str, Enum):
    LOW = 'low'
    MEDIUM = 'medium'
    HIGH = 'high'
    URGENT = 'urgent'

class TaskBase(BaseModel):
    """Base task schema."""
    title: str = Field(..., min_length=1, max_length=200)
    description: Optional[str] = None
    status: TaskStatus = TaskStatus.PENDING
    priority: TaskPriority = TaskPriority.MEDIUM
    due_date: Optional[datetime] = None
    project_id: Optional[int] = None

class TaskCreate(TaskBase):
    """Schema for task creation."""
    pass

class TaskUpdate(BaseModel):
    """Schema for task update."""
    title: Optional[str] = Field(None, min_length=1, max_length=200)
    description: Optional[str] = None
    status: Optional[TaskStatus] = None
    priority: Optional[TaskPriority] = None
    due_date: Optional[datetime] = None
    project_id: Optional[int] = None

class TaskResponse(TaskBase):
    """Schema for task response."""
    id: int
    user_id: int
    created_at: datetime
    updated_at: datetime
    
    class Config:
        from_attributes = True
```

### Phase 4: Authentication (Days 7-8)

#### Flask JWT Authentication

```python
# app/resources/auth.py
from flask import request
from flask_restful import Resource
from flask_jwt_extended import create_access_token, create_refresh_token, jwt_required, get_jwt_identity
from app.extensions import db
from app.models import User
from app.schemas.user import UserSchema, UserCreateSchema
from marshmallow import ValidationError

class RegisterResource(Resource):
    """User registration endpoint."""
    
    def post(self):
        """Register a new user."""
        schema = UserCreateSchema()
        try:
            data = schema.load(request.json)
        except ValidationError as err:
            return {'errors': err.messages}, 400
        
        # Check if user exists
        if User.query.filter_by(username=data['username']).first():
            return {'error': 'Username already exists'}, 400
        if User.query.filter_by(email=data['email']).first():
            return {'error': 'Email already registered'}, 400
        
        # Create user
        user = User(
            username=data['username'],
            email=data['email'],
            first_name=data.get('first_name'),
            last_name=data.get('last_name')
        )
        user.set_password(data['password'])
        
        db.session.add(user)
        db.session.commit()
        
        # Generate tokens
        access_token = create_access_token(identity=user.id)
        refresh_token = create_refresh_token(identity=user.id)
        
        return {
            'message': 'User registered successfully',
            'access_token': access_token,
            'refresh_token': refresh_token,
            'user': UserSchema().dump(user)
        }, 201

class LoginResource(Resource):
    """User login endpoint."""
    
    def post(self):
        """Login user."""
        data = request.json
        username = data.get('username')
        password = data.get('password')
        
        if not username or not password:
            return {'error': 'Username and password required'}, 400
        
        user = User.query.filter_by(username=username).first()
        
        if not user or not user.check_password(password):
            return {'error': 'Invalid credentials'}, 401
        
        if not user.is_active:
            return {'error': 'User account is inactive'}, 403
        
        # Generate tokens
        access_token = create_access_token(identity=user.id)
        refresh_token = create_refresh_token(identity=user.id)
        
        return {
            'access_token': access_token,
            'refresh_token': refresh_token,
            'user': UserSchema().dump(user)
        }, 200

class RefreshResource(Resource):
    """Token refresh endpoint."""
    
    @jwt_required(refresh=True)
    def post(self):
        """Refresh access token."""
        current_user_id = get_jwt_identity()
        new_token = create_access_token(identity=current_user_id)
        return {'access_token': new_token}, 200

class ProfileResource(Resource):
    """User profile endpoint."""
    
    @jwt_required()
    def get(self):
        """Get current user profile."""
        current_user_id = get_jwt_identity()
        user = User.query.get_or_404(current_user_id)
        return UserSchema().dump(user), 200
```

#### FastAPI Authentication

```python
# app/utils/security.py
from datetime import datetime, timedelta
from typing import Optional
from jose import JWTError, jwt
from passlib.context import CryptContext
from app.config import settings

pwd_context = CryptContext(schemes=["bcrypt"], deprecated="auto")

def verify_password(plain_password: str, hashed_password: str) -> bool:
    """Verify password."""
    return pwd_context.verify(plain_password, hashed_password)

def get_password_hash(password: str) -> str:
    """Hash password."""
    return pwd_context.hash(password)

def create_access_token(data: dict, expires_delta: Optional[timedelta] = None) -> str:
    """Create JWT access token."""
    to_encode = data.copy()
    if expires_delta:
        expire = datetime.utcnow() + expires_delta
    else:
        expire = datetime.utcnow() + timedelta(minutes=settings.ACCESS_TOKEN_EXPIRE_MINUTES)
    to_encode.update({"exp": expire})
    encoded_jwt = jwt.encode(to_encode, settings.SECRET_KEY, algorithm=settings.ALGORITHM)
    return encoded_jwt

def decode_token(token: str) -> Optional[dict]:
    """Decode JWT token."""
    try:
        payload = jwt.decode(token, settings.SECRET_KEY, algorithms=[settings.ALGORITHM])
        return payload
    except JWTError:
        return None
```

### Phase 5: API Resources/Routers (Days 9-12)

#### Flask Task Resources

```python
# app/resources/tasks.py
from flask import request
from flask_restful import Resource
from flask_jwt_extended import jwt_required, get_jwt_identity
from app.extensions import db
from app.models import Task, User
from app.schemas.task import TaskSchema, TaskCreateSchema, TaskUpdateSchema
from marshmallow import ValidationError

class TaskListResource(Resource):
    """Task list endpoint."""
    
    @jwt_required()
    def get(self):
        """Get all tasks for current user."""
        current_user_id = get_jwt_identity()
        page = request.args.get('page', 1, type=int)
        per_page = request.args.get('per_page', 20, type=int)
        status = request.args.get('status')
        priority = request.args.get('priority')
        search = request.args.get('search')
        
        query = Task.query.filter_by(user_id=current_user_id)
        
        # Filters
        if status:
            query = query.filter_by(status=status)
        if priority:
            query = query.filter_by(priority=priority)
        if search:
            query = query.filter(
                Task.title.contains(search) | Task.description.contains(search)
            )
        
        # Pagination
        pagination = query.order_by(Task.created_at.desc()).paginate(
            page=page, per_page=per_page, error_out=False
        )
        
        schema = TaskSchema(many=True)
        return {
            'tasks': schema.dump(pagination.items),
            'pagination': {
                'page': page,
                'pages': pagination.pages,
                'per_page': per_page,
                'total': pagination.total
            }
        }, 200
    
    @jwt_required()
    def post(self):
        """Create a new task."""
        current_user_id = get_jwt_identity()
        schema = TaskCreateSchema()
        
        try:
            data = schema.load(request.json)
        except ValidationError as err:
            return {'errors': err.messages}, 400
        
        task = Task(user_id=current_user_id, **data)
        db.session.add(task)
        db.session.commit()
        
        return TaskSchema().dump(task), 201

class TaskResource(Resource):
    """Single task endpoint."""
    
    @jwt_required()
    def get(self, task_id):
        """Get task by ID."""
        current_user_id = get_jwt_identity()
        task = Task.query.get_or_404(task_id)
        
        if task.user_id != current_user_id:
            return {'error': 'Forbidden'}, 403
        
        return TaskSchema().dump(task), 200
    
    @jwt_required()
    def put(self, task_id):
        """Update task."""
        current_user_id = get_jwt_identity()
        task = Task.query.get_or_404(task_id)
        
        if task.user_id != current_user_id:
            return {'error': 'Forbidden'}, 403
        
        schema = TaskUpdateSchema()
        try:
            data = schema.load(request.json, partial=True)
        except ValidationError as err:
            return {'errors': err.messages}, 400
        
        for key, value in data.items():
            setattr(task, key, value)
        
        db.session.commit()
        return TaskSchema().dump(task), 200
    
    @jwt_required()
    def delete(self, task_id):
        """Delete task."""
        current_user_id = get_jwt_identity()
        task = Task.query.get_or_404(task_id)
        
        if task.user_id != current_user_id:
            return {'error': 'Forbidden'}, 403
        
        db.session.delete(task)
        db.session.commit()
        return {'message': 'Task deleted successfully'}, 200
```

#### FastAPI Task Router

```python
# app/routers/tasks.py
from fastapi import APIRouter, Depends, HTTPException, Query
from sqlalchemy.orm import Session
from typing import List, Optional
from app.database import get_db
from app.models import Task, User
from app.schemas.task import TaskCreate, TaskUpdate, TaskResponse
from app.utils.security import get_current_user

router = APIRouter(prefix="/tasks", tags=["tasks"])

@router.get("/", response_model=List[TaskResponse])
def get_tasks(
    skip: int = Query(0, ge=0),
    limit: int = Query(20, ge=1, le=100),
    status: Optional[str] = None,
    priority: Optional[str] = None,
    search: Optional[str] = None,
    db: Session = Depends(get_db),
    current_user: User = Depends(get_current_user)
):
    """Get all tasks for current user."""
    query = db.query(Task).filter(Task.user_id == current_user.id)
    
    if status:
        query = query.filter(Task.status == status)
    if priority:
        query = query.filter(Task.priority == priority)
    if search:
        query = query.filter(
            Task.title.contains(search) | Task.description.contains(search)
        )
    
    tasks = query.order_by(Task.created_at.desc()).offset(skip).limit(limit).all()
    return tasks

@router.post("/", response_model=TaskResponse, status_code=201)
def create_task(
    task: TaskCreate,
    db: Session = Depends(get_db),
    current_user: User = Depends(get_current_user)
):
    """Create a new task."""
    db_task = Task(user_id=current_user.id, **task.dict())
    db.add(db_task)
    db.commit()
    db.refresh(db_task)
    return db_task

@router.get("/{task_id}", response_model=TaskResponse)
def get_task(
    task_id: int,
    db: Session = Depends(get_db),
    current_user: User = Depends(get_current_user)
):
    """Get task by ID."""
    task = db.query(Task).filter(Task.id == task_id).first()
    if not task:
        raise HTTPException(status_code=404, detail="Task not found")
    if task.user_id != current_user.id:
        raise HTTPException(status_code=403, detail="Forbidden")
    return task

@router.put("/{task_id}", response_model=TaskResponse)
def update_task(
    task_id: int,
    task_update: TaskUpdate,
    db: Session = Depends(get_db),
    current_user: User = Depends(get_current_user)
):
    """Update task."""
    task = db.query(Task).filter(Task.id == task_id).first()
    if not task:
        raise HTTPException(status_code=404, detail="Task not found")
    if task.user_id != current_user.id:
        raise HTTPException(status_code=403, detail="Forbidden")
    
    update_data = task_update.dict(exclude_unset=True)
    for key, value in update_data.items():
        setattr(task, key, value)
    
    db.commit()
    db.refresh(task)
    return task

@router.delete("/{task_id}", status_code=204)
def delete_task(
    task_id: int,
    db: Session = Depends(get_db),
    current_user: User = Depends(get_current_user)
):
    """Delete task."""
    task = db.query(Task).filter(Task.id == task_id).first()
    if not task:
        raise HTTPException(status_code=404, detail="Task not found")
    if task.user_id != current_user.id:
        raise HTTPException(status_code=403, detail="Forbidden")
    
    db.delete(task)
    db.commit()
    return None
```

### Phase 6: Error Handling (Days 13-14)

#### Flask Error Handlers

```python
# app/__init__.py (add error handlers)
from flask import jsonify
from app.extensions import db

@app.errorhandler(404)
def not_found(error):
    return jsonify({'error': 'Resource not found'}), 404

@app.errorhandler(400)
def bad_request(error):
    return jsonify({'error': 'Bad request'}), 400

@app.errorhandler(500)
def internal_error(error):
    db.session.rollback()
    return jsonify({'error': 'Internal server error'}), 500

@app.errorhandler(422)
def validation_error(error):
    return jsonify({'error': 'Validation error', 'details': str(error)}), 422
```

#### FastAPI Exception Handlers

```python
# app/main.py
from fastapi import FastAPI, Request, status
from fastapi.responses import JSONResponse
from fastapi.exceptions import RequestValidationError
from sqlalchemy.exc import SQLAlchemyError

app = FastAPI()

@app.exception_handler(404)
async def not_found_handler(request: Request, exc: Exception):
    return JSONResponse(
        status_code=status.HTTP_404_NOT_FOUND,
        content={"error": "Resource not found"}
    )

@app.exception_handler(RequestValidationError)
async def validation_exception_handler(request: Request, exc: RequestValidationError):
    return JSONResponse(
        status_code=status.HTTP_422_UNPROCESSABLE_ENTITY,
        content={"error": "Validation error", "details": exc.errors()}
    )

@app.exception_handler(SQLAlchemyError)
async def database_exception_handler(request: Request, exc: SQLAlchemyError):
    return JSONResponse(
        status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
        content={"error": "Database error"}
    )
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

@pytest.fixture
def auth_headers(client, user):
    """Get authentication headers."""
    response = client.post('/api/auth/login', json={
        'username': 'testuser',
        'password': 'password123'
    })
    token = response.json['access_token']
    return {'Authorization': f'Bearer {token}'}
```

#### API Tests

```python
# tests/test_tasks.py
import pytest
from app.models import Task

def test_create_task(client, auth_headers):
    """Test task creation."""
    response = client.post('/api/tasks', json={
        'title': 'Test Task',
        'description': 'Test Description',
        'status': 'pending',
        'priority': 'medium'
    }, headers=auth_headers)
    
    assert response.status_code == 201
    assert response.json['title'] == 'Test Task'

def test_get_tasks(client, auth_headers):
    """Test getting tasks."""
    response = client.get('/api/tasks', headers=auth_headers)
    assert response.status_code == 200
    assert 'tasks' in response.json

def test_get_task(client, auth_headers, task):
    """Test getting single task."""
    response = client.get(f'/api/tasks/{task.id}', headers=auth_headers)
    assert response.status_code == 200
    assert response.json['id'] == task.id

def test_update_task(client, auth_headers, task):
    """Test task update."""
    response = client.put(f'/api/tasks/{task.id}', json={
        'title': 'Updated Task'
    }, headers=auth_headers)
    assert response.status_code == 200
    assert response.json['title'] == 'Updated Task'

def test_delete_task(client, auth_headers, task):
    """Test task deletion."""
    response = client.delete(f'/api/tasks/{task.id}', headers=auth_headers)
    assert response.status_code == 200
```

### Phase 8: Documentation (Days 17-18)

#### Flask-RESTX Swagger

```python
# app/__init__.py
from flask_restx import Api
from app.resources.auth import RegisterResource, LoginResource
from app.resources.tasks import TaskListResource, TaskResource

api = Api(
    app,
    version='1.0',
    title='Task Management API',
    description='A comprehensive task management API',
    doc='/api/docs/'
)

# Add namespaces
auth_ns = api.namespace('auth', description='Authentication operations')
tasks_ns = api.namespace('tasks', description='Task operations')

# Register resources
auth_ns.add_resource(RegisterResource, '/register')
auth_ns.add_resource(LoginResource, '/login')
tasks_ns.add_resource(TaskListResource, '/')
tasks_ns.add_resource(TaskResource, '/<int:task_id>')
```

#### FastAPI Automatic Docs

```python
# app/main.py
from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from app.routers import auth, tasks, projects
from app.config import settings

app = FastAPI(
    title="Task Management API",
    description="A comprehensive task management API",
    version="1.0.0",
    docs_url="/api/docs",
    redoc_url="/api/redoc"
)

# CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=settings.CORS_ORIGINS,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Include routers
app.include_router(auth.router, prefix="/api")
app.include_router(tasks.router, prefix="/api")
app.include_router(projects.router, prefix="/api")
```

---

## Evaluation Criteria

### API Design (25%)
- RESTful principles
- Proper HTTP methods
- Status codes
- Resource naming

### Functionality (25%)
- All endpoints working
- Authentication/authorization
- CRUD operations
- Validation

### Code Quality (20%)
- Clean code
- Error handling
- Type hints
- Documentation

### Testing (15%)
- Test coverage >80%
- Unit tests
- Integration tests
- API tests

### Documentation (10%)
- OpenAPI/Swagger docs
- README
- API examples
- Setup instructions

### Security (5%)
- Password hashing
- JWT security
- Input validation
- CORS configuration

---

## Submission Requirements

1. **Source Code**
   - Complete API code
   - All endpoints implemented
   - Tests included

2. **Documentation**
   - README.md
   - API documentation (Swagger/OpenAPI)
   - Setup instructions
   - Deployment guide

3. **Testing**
   - Test files
   - Coverage report
   - Test results

4. **Deployment**
   - Docker configuration (optional)
   - Environment variables
   - Production-ready code

---

## Additional Resources

- **Flask-RESTful**: flask-restful.readthedocs.io
- **FastAPI**: fastapi.tiangolo.com
- **OpenAPI**: swagger.io/specification
- **JWT**: jwt.io
- **Postman**: API testing tool

---

## Next Steps

After completing this project:
1. Add rate limiting
2. Implement caching
3. Add WebSocket support
4. Create API client libraries
5. Set up CI/CD pipeline
6. Add monitoring and logging

---

*Good luck with your API development project!*

