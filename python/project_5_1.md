# Project 5.1: Full-Stack API Project

## Learning Objectives

By the end of this project, you will be able to:
- Build a complete REST API from scratch
- Integrate databases with APIs
- Implement authentication and authorization
- Create API documentation
- Handle errors and validation
- Structure a full-stack API project
- Use Flask-RESTful or FastAPI
- Implement JWT authentication
- Create database models
- Write comprehensive tests
- Deploy APIs
- Apply API best practices
- Debug API issues

---

## Introduction to Full-Stack API Development

**Full-Stack API** development involves creating a complete backend API that can serve frontend applications, mobile apps, or other services. It includes database integration, authentication, error handling, and documentation.

**Key Components**:
- **REST API**: RESTful endpoints
- **Database**: Data persistence
- **Authentication**: User authentication and authorization
- **Validation**: Input validation and error handling
- **Documentation**: API documentation
- **Testing**: Unit and integration tests

**Project Structure**:
```
project/
├── app/
│   ├── __init__.py
│   ├── models.py          # Database models
│   ├── routes.py          # API routes
│   ├── auth.py            # Authentication
│   ├── config.py          # Configuration
│   └── utils.py           # Utilities
├── tests/                 # Tests
├── requirements.txt       # Dependencies
├── README.md              # Documentation
└── run.py                 # Application entry point
```

---

## Complete REST API

### Project Setup

```python
# requirements.txt
flask==2.3.0
flask-restful==0.3.10
flask-jwt-extended==4.5.0
flask-sqlalchemy==3.0.5
flask-migrate==4.0.4
flask-cors==4.0.0
python-dotenv==1.0.0
marshmallow==3.20.0
```

### Application Structure

```python
# app/__init__.py
from flask import Flask
from flask_restful import Api
from flask_sqlalchemy import SQLAlchemy
from flask_jwt_extended import JWTManager
from flask_cors import CORS
from flask_migrate import Migrate
from config import Config

db = SQLAlchemy()
jwt = JWTManager()
migrate = Migrate()

def create_app(config_class=Config):
    app = Flask(__name__)
    app.config.from_object(config_class)
    
    # Initialize extensions
    db.init_app(app)
    jwt.init_app(app)
    migrate.init_app(app, db)
    CORS(app)
    
    # Register blueprints/routes
    from app.routes import api_bp
    app.register_blueprint(api_bp)
    
    return app
```

### Configuration

```python
# config.py
import os
from datetime import timedelta

class Config:
    SECRET_KEY = os.environ.get('SECRET_KEY') or 'dev-secret-key-change-in-production'
    SQLALCHEMY_DATABASE_URI = os.environ.get('DATABASE_URL') or 'sqlite:///app.db'
    SQLALCHEMY_TRACK_MODIFICATIONS = False
    
    # JWT Configuration
    JWT_SECRET_KEY = os.environ.get('JWT_SECRET_KEY') or 'jwt-secret-key'
    JWT_ACCESS_TOKEN_EXPIRES = timedelta(hours=1)
    JWT_REFRESH_TOKEN_EXPIRES = timedelta(days=30)
    
    # CORS
    CORS_ORIGINS = os.environ.get('CORS_ORIGINS', '*').split(',')
```

---

## Database Integration

### Models

```python
# app/models.py
from app import db
from datetime import datetime
from werkzeug.security import generate_password_hash, check_password_hash

class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(80), unique=True, nullable=False, index=True)
    email = db.Column(db.String(120), unique=True, nullable=False, index=True)
    password_hash = db.Column(db.String(128), nullable=False)
    created_at = db.Column(db.DateTime, default=datetime.utcnow)
    is_active = db.Column(db.Boolean, default=True)
    
    # Relationships
    posts = db.relationship('Post', backref='author', lazy=True, cascade='all, delete-orphan')
    
    def set_password(self, password):
        self.password_hash = generate_password_hash(password)
    
    def check_password(self, password):
        return check_password_hash(self.password_hash, password)
    
    def to_dict(self):
        return {
            'id': self.id,
            'username': self.username,
            'email': self.email,
            'created_at': self.created_at.isoformat(),
            'is_active': self.is_active
        }
    
    def __repr__(self):
        return f'<User {self.username}>'

class Post(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(200), nullable=False)
    content = db.Column(db.Text, nullable=False)
    author_id = db.Column(db.Integer, db.ForeignKey('user.id'), nullable=False)
    created_at = db.Column(db.DateTime, default=datetime.utcnow, index=True)
    updated_at = db.Column(db.DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)
    published = db.Column(db.Boolean, default=False, index=True)
    
    def to_dict(self):
        return {
            'id': self.id,
            'title': self.title,
            'content': self.content,
            'author_id': self.author_id,
            'author': self.author.username if self.author else None,
            'created_at': self.created_at.isoformat(),
            'updated_at': self.updated_at.isoformat(),
            'published': self.published
        }
    
    def __repr__(self):
        return f'<Post {self.title}>'
```

### Database Initialization

```python
# app/__init__.py (continued)
def create_app(config_class=Config):
    # ... previous code ...
    
    # Create tables
    with app.app_context():
        db.create_all()
    
    return app
```

---

## Authentication

### JWT Authentication

```python
# app/auth.py
from flask_jwt_extended import create_access_token, create_refresh_token
from app.models import User
from app import db

def authenticate(username, password):
    """Authenticate user and return tokens."""
    user = User.query.filter_by(username=username).first()
    if user and user.check_password(password):
        access_token = create_access_token(identity=user.id)
        refresh_token = create_refresh_token(identity=user.id)
        return {
            'access_token': access_token,
            'refresh_token': refresh_token,
            'user': user.to_dict()
        }
    return None

def register_user(username, email, password):
    """Register a new user."""
    if User.query.filter_by(username=username).first():
        return {'error': 'Username already exists'}, 400
    
    if User.query.filter_by(email=email).first():
        return {'error': 'Email already exists'}, 400
    
    user = User(username=username, email=email)
    user.set_password(password)
    db.session.add(user)
    db.session.commit()
    
    return {'message': 'User created successfully', 'user': user.to_dict()}, 201
```

### Protected Routes

```python
# app/routes.py
from flask import Blueprint
from flask_restful import Api, Resource, reqparse
from flask_jwt_extended import jwt_required, get_jwt_identity, get_jwt
from app.models import User, Post, db
from app.auth import authenticate, register_user

api_bp = Blueprint('api', __name__, url_prefix='/api')
api = Api(api_bp)

# Request parsers
login_parser = reqparse.RequestParser()
login_parser.add_argument('username', type=str, required=True)
login_parser.add_argument('password', type=str, required=True)

register_parser = reqparse.RequestParser()
register_parser.add_argument('username', type=str, required=True)
register_parser.add_argument('email', type=str, required=True)
register_parser.add_argument('password', type=str, required=True)

post_parser = reqparse.RequestParser()
post_parser.add_argument('title', type=str, required=True)
post_parser.add_argument('content', type=str, required=True)
post_parser.add_argument('published', type=bool, default=False)

class Login(Resource):
    def post(self):
        args = login_parser.parse_args()
        result = authenticate(args['username'], args['password'])
        if result:
            return result, 200
        return {'error': 'Invalid credentials'}, 401

class Register(Resource):
    def post(self):
        args = register_parser.parse_args()
        return register_user(args['username'], args['email'], args['password'])

class PostList(Resource):
    @jwt_required()
    def get(self):
        """Get all posts (authenticated users only)."""
        posts = Post.query.filter_by(published=True).order_by(Post.created_at.desc()).all()
        return {'posts': [post.to_dict() for post in posts]}, 200
    
    @jwt_required()
    def post(self):
        """Create a new post."""
        current_user_id = get_jwt_identity()
        args = post_parser.parse_args()
        
        post = Post(
            title=args['title'],
            content=args['content'],
            author_id=current_user_id,
            published=args.get('published', False)
        )
        db.session.add(post)
        db.session.commit()
        
        return post.to_dict(), 201

class PostDetail(Resource):
    @jwt_required()
    def get(self, post_id):
        """Get a specific post."""
        post = Post.query.get_or_404(post_id)
        return post.to_dict(), 200
    
    @jwt_required()
    def put(self, post_id):
        """Update a post (owner only)."""
        current_user_id = get_jwt_identity()
        post = Post.query.get_or_404(post_id)
        
        if post.author_id != current_user_id:
            return {'error': 'Permission denied'}, 403
        
        args = post_parser.parse_args()
        post.title = args['title']
        post.content = args['content']
        post.published = args.get('published', post.published)
        db.session.commit()
        
        return post.to_dict(), 200
    
    @jwt_required()
    def delete(self, post_id):
        """Delete a post (owner only)."""
        current_user_id = get_jwt_identity()
        post = Post.query.get_or_404(post_id)
        
        if post.author_id != current_user_id:
            return {'error': 'Permission denied'}, 403
        
        db.session.delete(post)
        db.session.commit()
        
        return {'message': 'Post deleted'}, 204

# Register resources
api.add_resource(Login, '/login')
api.add_resource(Register, '/register')
api.add_resource(PostList, '/posts')
api.add_resource(PostDetail, '/posts/<int:post_id>')
```

---

## Complete API Project

### Full Application

```python
# run.py
from app import create_app, db
from app.models import User, Post

app = create_app()

@app.shell_context_processor
def make_shell_context():
    return {'db': db, 'User': User, 'Post': Post}

if __name__ == '__main__':
    app.run(debug=True)
```

### Enhanced Routes with Error Handling

```python
# app/routes.py (enhanced)
from flask import Blueprint
from flask_restful import Api, Resource, reqparse
from flask_jwt_extended import jwt_required, get_jwt_identity
from werkzeug.exceptions import NotFound, BadRequest
from app.models import User, Post, db
from app.auth import authenticate, register_user

api_bp = Blueprint('api', __name__, url_prefix='/api/v1')
api = Api(api_bp)

# Error handlers
@api_bp.errorhandler(404)
def not_found(error):
    return {'error': 'Resource not found'}, 404

@api_bp.errorhandler(400)
def bad_request(error):
    return {'error': 'Bad request'}, 400

@api_bp.errorhandler(500)
def internal_error(error):
    db.session.rollback()
    return {'error': 'Internal server error'}, 500

# Parsers
login_parser = reqparse.RequestParser()
login_parser.add_argument('username', type=str, required=True, help='Username is required')
login_parser.add_argument('password', type=str, required=True, help='Password is required')

register_parser = reqparse.RequestParser()
register_parser.add_argument('username', type=str, required=True, help='Username is required')
register_parser.add_argument('email', type=str, required=True, help='Email is required')
register_parser.add_argument('password', type=str, required=True, help='Password is required')

post_parser = reqparse.RequestParser()
post_parser.add_argument('title', type=str, required=True, help='Title is required')
post_parser.add_argument('content', type=str, required=True, help='Content is required')
post_parser.add_argument('published', type=bool, default=False)

class Login(Resource):
    def post(self):
        """User login endpoint."""
        args = login_parser.parse_args()
        result = authenticate(args['username'], args['password'])
        if result:
            return result, 200
        return {'error': 'Invalid username or password'}, 401

class Register(Resource):
    def post(self):
        """User registration endpoint."""
        args = register_parser.parse_args()
        return register_user(args['username'], args['email'], args['password'])

class PostList(Resource):
    @jwt_required()
    def get(self):
        """Get all published posts."""
        posts = Post.query.filter_by(published=True).order_by(Post.created_at.desc()).all()
        return {
            'posts': [post.to_dict() for post in posts],
            'count': len(posts)
        }, 200
    
    @jwt_required()
    def post(self):
        """Create a new post."""
        current_user_id = get_jwt_identity()
        args = post_parser.parse_args()
        
        try:
            post = Post(
                title=args['title'],
                content=args['content'],
                author_id=current_user_id,
                published=args.get('published', False)
            )
            db.session.add(post)
            db.session.commit()
            return post.to_dict(), 201
        except Exception as e:
            db.session.rollback()
            return {'error': str(e)}, 500

class PostDetail(Resource):
    @jwt_required()
    def get(self, post_id):
        """Get a specific post."""
        post = Post.query.get_or_404(post_id)
        return post.to_dict(), 200
    
    @jwt_required()
    def put(self, post_id):
        """Update a post."""
        current_user_id = get_jwt_identity()
        post = Post.query.get_or_404(post_id)
        
        if post.author_id != current_user_id:
            return {'error': 'Permission denied'}, 403
        
        args = post_parser.parse_args()
        post.title = args['title']
        post.content = args['content']
        post.published = args.get('published', post.published)
        
        try:
            db.session.commit()
            return post.to_dict(), 200
        except Exception as e:
            db.session.rollback()
            return {'error': str(e)}, 500
    
    @jwt_required()
    def delete(self, post_id):
        """Delete a post."""
        current_user_id = get_jwt_identity()
        post = Post.query.get_or_404(post_id)
        
        if post.author_id != current_user_id:
            return {'error': 'Permission denied'}, 403
        
        try:
            db.session.delete(post)
            db.session.commit()
            return {'message': 'Post deleted successfully'}, 200
        except Exception as e:
            db.session.rollback()
            return {'error': str(e)}, 500

class UserPosts(Resource):
    @jwt_required()
    def get(self, user_id):
        """Get all posts by a specific user."""
        user = User.query.get_or_404(user_id)
        posts = Post.query.filter_by(author_id=user_id).order_by(Post.created_at.desc()).all()
        return {
            'user': user.to_dict(),
            'posts': [post.to_dict() for post in posts],
            'count': len(posts)
        }, 200

class UserProfile(Resource):
    @jwt_required()
    def get(self):
        """Get current user profile."""
        current_user_id = get_jwt_identity()
        user = User.query.get_or_404(current_user_id)
        return user.to_dict(), 200

# Register resources
api.add_resource(Login, '/auth/login')
api.add_resource(Register, '/auth/register')
api.add_resource(PostList, '/posts')
api.add_resource(PostDetail, '/posts/<int:post_id>')
api.add_resource(UserPosts, '/users/<int:user_id>/posts')
api.add_resource(UserProfile, '/users/me')
```

---

## Documentation

### API Documentation

```python
# app/docs.py
from flask import Blueprint
from flask_restful import Api, Resource

docs_bp = Blueprint('docs', __name__)
api = Api(docs_bp)

class APIDocs(Resource):
    def get(self):
        """API Documentation."""
        return {
            'title': 'Blog API',
            'version': '1.0',
            'endpoints': {
                'authentication': {
                    'POST /api/v1/auth/login': {
                        'description': 'User login',
                        'parameters': {
                            'username': 'string (required)',
                            'password': 'string (required)'
                        },
                        'response': {
                            'access_token': 'JWT token',
                            'refresh_token': 'Refresh token',
                            'user': 'User object'
                        }
                    },
                    'POST /api/v1/auth/register': {
                        'description': 'User registration',
                        'parameters': {
                            'username': 'string (required)',
                            'email': 'string (required)',
                            'password': 'string (required)'
                        }
                    }
                },
                'posts': {
                    'GET /api/v1/posts': {
                        'description': 'Get all published posts',
                        'authentication': 'Required',
                        'response': 'List of posts'
                    },
                    'POST /api/v1/posts': {
                        'description': 'Create a new post',
                        'authentication': 'Required',
                        'parameters': {
                            'title': 'string (required)',
                            'content': 'string (required)',
                            'published': 'boolean (optional)'
                        }
                    },
                    'GET /api/v1/posts/<id>': {
                        'description': 'Get a specific post',
                        'authentication': 'Required'
                    },
                    'PUT /api/v1/posts/<id>': {
                        'description': 'Update a post (owner only)',
                        'authentication': 'Required'
                    },
                    'DELETE /api/v1/posts/<id>': {
                        'description': 'Delete a post (owner only)',
                        'authentication': 'Required'
                    }
                },
                'users': {
                    'GET /api/v1/users/me': {
                        'description': 'Get current user profile',
                        'authentication': 'Required'
                    },
                    'GET /api/v1/users/<id>/posts': {
                        'description': 'Get all posts by a user',
                        'authentication': 'Required'
                    }
                }
            },
            'authentication': {
                'type': 'JWT Bearer Token',
                'header': 'Authorization: Bearer <token>'
            }
        }

api.add_resource(APIDocs, '/docs')
```

### Using Flask-RESTX for Swagger

```python
# Install: pip install flask-restx

from flask_restx import Api, Resource, fields
from flask import Blueprint

docs_bp = Blueprint('api', __name__, url_prefix='/api')
api = Api(docs_bp, doc='/swagger/', version='1.0', title='Blog API')

# Define models
user_model = api.model('User', {
    'id': fields.Integer(readonly=True),
    'username': fields.String(required=True),
    'email': fields.String(required=True),
    'created_at': fields.DateTime(readonly=True)
})

post_model = api.model('Post', {
    'id': fields.Integer(readonly=True),
    'title': fields.String(required=True),
    'content': fields.String(required=True),
    'author_id': fields.Integer(readonly=True),
    'published': fields.Boolean(default=False),
    'created_at': fields.DateTime(readonly=True)
})

# Document endpoints
@api.route('/posts')
class PostList(Resource):
    @api.doc('list_posts')
    @api.marshal_list_with(post_model)
    @jwt_required()
    def get(self):
        """List all posts"""
        posts = Post.query.filter_by(published=True).all()
        return posts
    
    @api.doc('create_post')
    @api.expect(post_model)
    @api.marshal_with(post_model, code=201)
    @jwt_required()
    def post(self):
        """Create a new post"""
        # Implementation
        pass
```

---

## Testing

### Unit Tests

```python
# tests/test_api.py
import unittest
from app import create_app, db
from app.models import User, Post
from flask_jwt_extended import create_access_token

class APITestCase(unittest.TestCase):
    def setUp(self):
        self.app = create_app('testing')
        self.app_context = self.app.app_context()
        self.app_context.push()
        self.client = self.app.test_client()
        db.create_all()
        
        # Create test user
        self.user = User(username='testuser', email='test@example.com')
        self.user.set_password('testpass')
        db.session.add(self.user)
        db.session.commit()
        
        # Create access token
        self.token = create_access_token(identity=self.user.id)
    
    def tearDown(self):
        db.session.remove()
        db.drop_all()
        self.app_context.pop()
    
    def test_register(self):
        """Test user registration."""
        response = self.client.post('/api/v1/auth/register', json={
            'username': 'newuser',
            'email': 'newuser@example.com',
            'password': 'password123'
        })
        self.assertEqual(response.status_code, 201)
        self.assertIn('user', response.json)
    
    def test_login(self):
        """Test user login."""
        response = self.client.post('/api/v1/auth/login', json={
            'username': 'testuser',
            'password': 'testpass'
        })
        self.assertEqual(response.status_code, 200)
        self.assertIn('access_token', response.json)
    
    def test_create_post(self):
        """Test creating a post."""
        response = self.client.post('/api/v1/posts',
            headers={'Authorization': f'Bearer {self.token}'},
            json={
                'title': 'Test Post',
                'content': 'Test content',
                'published': True
            }
        )
        self.assertEqual(response.status_code, 201)
        self.assertIn('title', response.json)
    
    def test_get_posts(self):
        """Test getting posts."""
        # Create a post
        post = Post(title='Test', content='Content', author_id=self.user.id, published=True)
        db.session.add(post)
        db.session.commit()
        
        response = self.client.get('/api/v1/posts',
            headers={'Authorization': f'Bearer {self.token}'}
        )
        self.assertEqual(response.status_code, 200)
        self.assertIn('posts', response.json)

if __name__ == '__main__':
    unittest.main()
```

---

## Practice Exercise

### Exercise: Full API Project

**Objective**: Create a complete full-stack API project.

**Requirements**:

1. Create a REST API with:
   - User authentication (register, login)
   - CRUD operations for a resource (e.g., tasks, notes, products)
   - Database integration
   - Error handling
   - API documentation

2. Features:
   - JWT authentication
   - User registration and login
   - Protected routes
   - Resource ownership
   - Input validation
   - Error handling
   - API documentation

**Example Solution**:

```python
#!/usr/bin/env python3
"""
Complete Full-Stack API Project
Task Management API with authentication
"""

# See complete implementation above in "Complete API Project" section

# Additional features to implement:
# - Pagination
# - Filtering and searching
# - File uploads
# - Email notifications
# - Rate limiting
# - Caching
```

**Expected Output**: A complete, production-ready REST API with authentication, database integration, and documentation.

**Challenge** (Optional):
- Add pagination
- Add filtering and search
- Add file uploads
- Add email notifications
- Add rate limiting
- Add caching with Redis
- Create frontend client
- Deploy to cloud

---

## Key Takeaways

1. **Full-Stack API** - Complete backend API
2. **REST API** - RESTful endpoints
3. **Database Integration** - SQLAlchemy ORM
4. **Authentication** - JWT tokens
5. **Authorization** - Role-based access
6. **Error Handling** - Proper error responses
7. **Validation** - Input validation
8. **Documentation** - API documentation
9. **Testing** - Unit and integration tests
10. **Project Structure** - Organized codebase
11. **Best Practices** - Security, performance, maintainability
12. **Deployment** - Production deployment
13. **Versioning** - API versioning
14. **CORS** - Cross-origin resource sharing
15. **Security** - Authentication, authorization, validation

---

## Quiz: API Development

Test your understanding with these questions:

1. **What is a full-stack API?**
   - A) Frontend only
   - B) Complete backend API
   - C) Database only
   - D) Frontend and backend

2. **What is JWT used for?**
   - A) Database queries
   - B) Authentication
   - C) File storage
   - D) API documentation

3. **What integrates database with API?**
   - A) SQLAlchemy
   - B) Flask
   - C) requests
   - D) BeautifulSoup

4. **What protects routes?**
   - A) @protected
   - B) @jwt_required
   - C) @auth
   - D) @secure

5. **What validates input?**
   - A) reqparse
   - B) validator
   - C) parser
   - D) checker

6. **What documents APIs?**
   - A) Swagger
   - B) OpenAPI
   - C) Flask-RESTX
   - D) All of the above

7. **What is API versioning?**
   - A) /api/v1/
   - B) /api/v2/
   - C) URL prefix
   - D) All of the above

8. **What handles errors?**
   - A) Error handlers
   - B) Try-except
   - C) Validation
   - D) All of the above

9. **What is CORS?**
   - A) Cross-origin resource sharing
   - B) Security feature
   - C) Allows frontend access
   - D) All of the above

10. **What tests APIs?**
    - A) unittest
    - B) pytest
    - C) Integration tests
    - D) All of the above

**Answers**:
1. B) Complete backend API (full-stack API)
2. B) Authentication (JWT purpose)
3. A) SQLAlchemy (database integration)
4. B) @jwt_required (protect routes)
5. A) reqparse (input validation)
6. D) All of the above (API documentation)
7. D) All of the above (API versioning)
8. D) All of the above (error handling)
9. D) All of the above (CORS)
10. D) All of the above (testing)

---

## Next Steps

Excellent work! You've mastered full-stack API development. You now understand:
- Complete REST API
- Database integration
- Authentication
- Documentation
- How to build production APIs

**Congratulations!** You've completed the Python course!

---

## Additional Resources

- **Flask Documentation**: [flask.palletsprojects.com/](https://flask.palletsprojects.com/)
- **Flask-RESTful**: [flask-restful.readthedocs.io/](https://flask-restful.readthedocs.io/)
- **SQLAlchemy**: [docs.sqlalchemy.org/](https://docs.sqlalchemy.org/)
- **JWT**: [jwt.io/](https://jwt.io/)
- **API Design**: Best practices for REST APIs
- **Deployment**: Deploying Flask applications

---

*Project completed! You've completed the full Python course. Congratulations!*

