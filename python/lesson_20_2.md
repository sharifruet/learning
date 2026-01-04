# Lesson 20.2: Building REST APIs

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand REST API principles
- Install and use Flask-RESTful
- Design RESTful APIs
- Create API endpoints
- Handle HTTP methods (GET, POST, PUT, DELETE)
- Implement request parsing and validation
- Add authentication and authorization
- Handle errors and exceptions
- Use API versioning
- Document APIs
- Test REST APIs
- Apply API design best practices
- Build production-ready REST APIs
- Debug API issues

---

## Introduction to REST APIs

**REST (Representational State Transfer)** is an architectural style for designing networked applications. REST APIs use HTTP methods to perform operations on resources.

**Key Principles**:
- **Stateless**: Each request contains all information needed
- **Resource-based**: URLs represent resources
- **HTTP methods**: GET, POST, PUT, DELETE, PATCH
- **JSON**: Common data format
- **Status codes**: Standard HTTP status codes

---

## Flask-RESTful

### Installation

```bash
# Install Flask-RESTful
pip install flask-restful

# Also install Flask-JWT-Extended for authentication
pip install flask-jwt-extended

# Install Flask-CORS for CORS support
pip install flask-cors
```

### Basic Setup

```python
from flask import Flask
from flask_restful import Api, Resource
from flask_cors import CORS

app = Flask(__name__)
api = Api(app)
CORS(app)  # Enable CORS

if __name__ == '__main__':
    app.run(debug=True)
```

### Simple Resource

```python
from flask import Flask
from flask_restful import Api, Resource

app = Flask(__name__)
api = Api(app)

class HelloWorld(Resource):
    def get(self):
        return {'message': 'Hello, World!'}

api.add_resource(HelloWorld, '/hello')

if __name__ == '__main__':
    app.run(debug=True)
```

---

## API Design Principles

### RESTful URLs

```python
# Good RESTful design
GET    /api/v1/users          # List all users
GET    /api/v1/users/1        # Get user with ID 1
POST   /api/v1/users          # Create new user
PUT    /api/v1/users/1        # Update user with ID 1
DELETE /api/v1/users/1        # Delete user with ID 1

# Bad design (not RESTful)
GET    /api/v1/getUsers
POST   /api/v1/createUser
POST   /api/v1/updateUser
POST   /api/v1/deleteUser
```

### HTTP Methods

```python
from flask_restful import Resource

class UserResource(Resource):
    def get(self, user_id):
        """Retrieve a user."""
        return {'user_id': user_id, 'name': 'John'}
    
    def post(self):
        """Create a new user."""
        return {'message': 'User created'}, 201
    
    def put(self, user_id):
        """Update a user."""
        return {'user_id': user_id, 'message': 'User updated'}
    
    def delete(self, user_id):
        """Delete a user."""
        return {'message': 'User deleted'}, 204
```

### Status Codes

```python
from flask_restful import Resource

class UserResource(Resource):
    def get(self, user_id):
        user = get_user(user_id)
        if not user:
            return {'error': 'User not found'}, 404
        return user, 200
    
    def post(self):
        # Create user
        return {'message': 'User created'}, 201
    
    def put(self, user_id):
        # Update user
        return {'message': 'User updated'}, 200
    
    def delete(self, user_id):
        # Delete user
        return None, 204  # No content
```

---

## Request Parsing

### Basic Parsing

```python
from flask_restful import Resource, reqparse

parser = reqparse.RequestParser()
parser.add_argument('name', type=str, required=True, help='Name is required')
parser.add_argument('email', type=str, required=True)
parser.add_argument('age', type=int, default=0)

class UserResource(Resource):
    def post(self):
        args = parser.parse_args()
        name = args['name']
        email = args['email']
        age = args['age']
        
        # Create user
        return {'message': 'User created', 'name': name}, 201
```

### Advanced Parsing

```python
from flask_restful import Resource, reqparse
from werkzeug.datastructures import FileStorage

parser = reqparse.RequestParser()
parser.add_argument('name', type=str, required=True, location='json')
parser.add_argument('email', type=str, required=True, location='json')
parser.add_argument('age', type=int, location='json')
parser.add_argument('active', type=bool, location='json')
parser.add_argument('tags', type=str, action='append', location='json')
parser.add_argument('file', type=FileStorage, location='files')

class UserResource(Resource):
    def post(self):
        args = parser.parse_args()
        # args['name'], args['email'], etc.
        return {'message': 'User created'}, 201
```

### Validation

```python
from flask_restful import Resource, reqparse
import re

def validate_email(email):
    pattern = r'^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$'
    if not re.match(pattern, email):
        raise ValueError('Invalid email format')
    return email

parser = reqparse.RequestParser()
parser.add_argument('email', type=validate_email, required=True)
parser.add_argument('age', type=int, choices=[18, 19, 20, 21], required=True)

class UserResource(Resource):
    def post(self):
        args = parser.parse_args()
        return {'message': 'User created'}, 201
```

---

## Resource Classes

### Simple Resource

```python
from flask_restful import Resource

class ItemList(Resource):
    def get(self):
        items = [
            {'id': 1, 'name': 'Item 1'},
            {'id': 2, 'name': 'Item 2'}
        ]
        return {'items': items}, 200
    
    def post(self):
        # Create item
        return {'message': 'Item created'}, 201
```

### Resource with ID

```python
from flask_restful import Resource

class Item(Resource):
    def get(self, item_id):
        item = {'id': item_id, 'name': f'Item {item_id}'}
        return item, 200
    
    def put(self, item_id):
        # Update item
        return {'message': 'Item updated'}, 200
    
    def delete(self, item_id):
        # Delete item
        return None, 204
```

### Complete CRUD Resource

```python
from flask_restful import Resource, reqparse

# In-memory storage (use database in production)
items = {}
item_id_counter = 1

parser = reqparse.RequestParser()
parser.add_argument('name', type=str, required=True)
parser.add_argument('description', type=str)

class ItemList(Resource):
    def get(self):
        return {'items': list(items.values())}, 200
    
    def post(self):
        global item_id_counter
        args = parser.parse_args()
        
        item = {
            'id': item_id_counter,
            'name': args['name'],
            'description': args.get('description', '')
        }
        
        items[item_id_counter] = item
        item_id_counter += 1
        
        return item, 201

class Item(Resource):
    def get(self, item_id):
        if item_id not in items:
            return {'error': 'Item not found'}, 404
        return items[item_id], 200
    
    def put(self, item_id):
        if item_id not in items:
            return {'error': 'Item not found'}, 404
        
        args = parser.parse_args()
        items[item_id]['name'] = args['name']
        items[item_id]['description'] = args.get('description', '')
        
        return items[item_id], 200
    
    def delete(self, item_id):
        if item_id not in items:
            return {'error': 'Item not found'}, 404
        
        del items[item_id]
        return None, 204
```

---

## Authentication and Authorization

### JWT Authentication

```python
from flask import Flask
from flask_restful import Api, Resource
from flask_jwt_extended import (
    JWTManager, jwt_required, create_access_token,
    get_jwt_identity, get_jwt
)
from datetime import timedelta

app = Flask(__name__)
app.config['JWT_SECRET_KEY'] = 'your-secret-key-change-in-production'
app.config['JWT_ACCESS_TOKEN_EXPIRES'] = timedelta(hours=1)

jwt = JWTManager(app)
api = Api(app)

# User database (use real database in production)
users = {
    'admin': {'password': 'admin123', 'role': 'admin'},
    'user': {'password': 'user123', 'role': 'user'}
}

class Login(Resource):
    def post(self):
        from flask_restful import reqparse
        parser = reqparse.RequestParser()
        parser.add_argument('username', required=True)
        parser.add_argument('password', required=True)
        args = parser.parse_args()
        
        username = args['username']
        password = args['password']
        
        if username in users and users[username]['password'] == password:
            access_token = create_access_token(
                identity=username,
                additional_claims={'role': users[username]['role']}
            )
            return {'access_token': access_token}, 200
        else:
            return {'error': 'Invalid credentials'}, 401

class ProtectedResource(Resource):
    @jwt_required()
    def get(self):
        current_user = get_jwt_identity()
        claims = get_jwt()
        return {
            'message': f'Hello, {current_user}!',
            'role': claims.get('role')
        }, 200

api.add_resource(Login, '/login')
api.add_resource(ProtectedResource, '/protected')
```

### Role-Based Authorization

```python
from functools import wraps
from flask_jwt_extended import get_jwt, verify_jwt_in_request

def admin_required(fn):
    @wraps(fn)
    @jwt_required()
    def wrapper(*args, **kwargs):
        verify_jwt_in_request()
        claims = get_jwt()
        if claims.get('role') != 'admin':
            return {'error': 'Admin access required'}, 403
        return fn(*args, **kwargs)
    return wrapper

class AdminResource(Resource):
    @admin_required
    def get(self):
        return {'message': 'Admin access granted'}, 200
```

### API Key Authentication

```python
from functools import wraps
from flask import request

API_KEYS = {
    'key123': {'user': 'admin', 'permissions': ['read', 'write']},
    'key456': {'user': 'user', 'permissions': ['read']}
}

def api_key_required(fn):
    @wraps(fn)
    def wrapper(*args, **kwargs):
        api_key = request.headers.get('X-API-Key')
        if not api_key or api_key not in API_KEYS:
            return {'error': 'Invalid API key'}, 401
        request.api_key_data = API_KEYS[api_key]
        return fn(*args, **kwargs)
    return wrapper

class ProtectedResource(Resource):
    @api_key_required
    def get(self):
        key_data = request.api_key_data
        return {'user': key_data['user']}, 200
```

---

## Error Handling

### Custom Error Handlers

```python
from flask import Flask
from flask_restful import Api, Resource
from werkzeug.exceptions import NotFound, BadRequest

app = Flask(__name__)
api = Api(app)

@api.errorhandler(NotFound)
def handle_not_found(e):
    return {'error': 'Resource not found'}, 404

@api.errorhandler(BadRequest)
def handle_bad_request(e):
    return {'error': 'Bad request'}, 400

class Item(Resource):
    def get(self, item_id):
        if item_id not in items:
            raise NotFound('Item not found')
        return items[item_id], 200
```

### Exception Handling in Resources

```python
from flask_restful import Resource
from werkzeug.exceptions import BadRequest, NotFound

class Item(Resource):
    def get(self, item_id):
        try:
            item = get_item(item_id)
            if not item:
                raise NotFound('Item not found')
            return item, 200
        except ValueError as e:
            raise BadRequest(str(e))
        except Exception as e:
            return {'error': 'Internal server error'}, 500
```

### Validation Errors

```python
from flask_restful import Resource, reqparse
from werkzeug.exceptions import BadRequest

parser = reqparse.RequestParser()
parser.add_argument('email', type=str, required=True)

def validate_email(email):
    if '@' not in email:
        raise ValueError('Invalid email format')
    return email

parser.add_argument('email', type=validate_email, required=True)

class UserResource(Resource):
    def post(self):
        try:
            args = parser.parse_args()
            # Create user
            return {'message': 'User created'}, 201
        except ValueError as e:
            raise BadRequest(str(e))
```

---

## API Versioning

### URL-Based Versioning

```python
from flask import Flask
from flask_restful import Api, Resource

app = Flask(__name__)
api_v1 = Api(app, prefix='/api/v1')
api_v2 = Api(app, prefix='/api/v2')

class UserV1(Resource):
    def get(self):
        return {'version': 'v1', 'users': []}

class UserV2(Resource):
    def get(self):
        return {'version': 'v2', 'users': [], 'metadata': {}}

api_v1.add_resource(UserV1, '/users')
api_v2.add_resource(UserV2, '/users')
```

### Header-Based Versioning

```python
from flask import request
from flask_restful import Resource

class VersionedResource(Resource):
    def get(self):
        version = request.headers.get('API-Version', 'v1')
        
        if version == 'v2':
            return {'version': 'v2', 'data': []}
        else:
            return {'version': 'v1', 'data': []}
```

---

## Complete Example: Todo API

```python
"""
Complete REST API Example: Todo Application
"""

from flask import Flask
from flask_restful import Api, Resource, reqparse
from flask_jwt_extended import (
    JWTManager, jwt_required, create_access_token,
    get_jwt_identity
)
from flask_cors import CORS
from datetime import timedelta

app = Flask(__name__)
app.config['JWT_SECRET_KEY'] = 'your-secret-key-change-in-production'
app.config['JWT_ACCESS_TOKEN_EXPIRES'] = timedelta(hours=1)

jwt = JWTManager(app)
api = Api(app)
CORS(app)

# In-memory storage (use database in production)
todos = {}
todo_id_counter = 1
users = {
    'admin': {'password': 'admin123'}
}

# Request parsers
todo_parser = reqparse.RequestParser()
todo_parser.add_argument('title', type=str, required=True, help='Title is required')
todo_parser.add_argument('description', type=str)
todo_parser.add_argument('completed', type=bool, default=False)

login_parser = reqparse.RequestParser()
login_parser.add_argument('username', type=str, required=True)
login_parser.add_argument('password', type=str, required=True)

class Login(Resource):
    def post(self):
        args = login_parser.parse_args()
        username = args['username']
        password = args['password']
        
        if username in users and users[username]['password'] == password:
            access_token = create_access_token(identity=username)
            return {'access_token': access_token}, 200
        else:
            return {'error': 'Invalid credentials'}, 401

class TodoList(Resource):
    @jwt_required()
    def get(self):
        current_user = get_jwt_identity()
        user_todos = [todo for todo in todos.values() if todo['user'] == current_user]
        return {'todos': user_todos}, 200
    
    @jwt_required()
    def post(self):
        global todo_id_counter
        current_user = get_jwt_identity()
        args = todo_parser.parse_args()
        
        todo = {
            'id': todo_id_counter,
            'title': args['title'],
            'description': args.get('description', ''),
            'completed': args.get('completed', False),
            'user': current_user
        }
        
        todos[todo_id_counter] = todo
        todo_id_counter += 1
        
        return todo, 201

class Todo(Resource):
    @jwt_required()
    def get(self, todo_id):
        if todo_id not in todos:
            return {'error': 'Todo not found'}, 404
        
        todo = todos[todo_id]
        current_user = get_jwt_identity()
        
        if todo['user'] != current_user:
            return {'error': 'Access denied'}, 403
        
        return todo, 200
    
    @jwt_required()
    def put(self, todo_id):
        if todo_id not in todos:
            return {'error': 'Todo not found'}, 404
        
        todo = todos[todo_id]
        current_user = get_jwt_identity()
        
        if todo['user'] != current_user:
            return {'error': 'Access denied'}, 403
        
        args = todo_parser.parse_args()
        todo['title'] = args['title']
        todo['description'] = args.get('description', '')
        todo['completed'] = args.get('completed', False)
        
        return todo, 200
    
    @jwt_required()
    def delete(self, todo_id):
        if todo_id not in todos:
            return {'error': 'Todo not found'}, 404
        
        todo = todos[todo_id]
        current_user = get_jwt_identity()
        
        if todo['user'] != current_user:
            return {'error': 'Access denied'}, 403
        
        del todos[todo_id]
        return None, 204

# Register resources
api.add_resource(Login, '/api/login')
api.add_resource(TodoList, '/api/todos')
api.add_resource(Todo, '/api/todos/<int:todo_id>')

if __name__ == '__main__':
    app.run(debug=True)
```

---

## API Documentation

### Using Flask-RESTX (Swagger)

```bash
pip install flask-restx
```

```python
from flask import Flask
from flask_restx import Api, Resource, fields

app = Flask(__name__)
api = Api(app, doc='/swagger/', version='1.0', title='Todo API')

todo_model = api.model('Todo', {
    'id': fields.Integer(readonly=True),
    'title': fields.String(required=True),
    'description': fields.String,
    'completed': fields.Boolean
})

@api.route('/todos')
class TodoList(Resource):
    @api.doc('list_todos')
    @api.marshal_list_with(todo_model)
    def get(self):
        """List all todos"""
        return todos
    
    @api.doc('create_todo')
    @api.expect(todo_model)
    @api.marshal_with(todo_model, code=201)
    def post(self):
        """Create a new todo"""
        # Implementation
        pass
```

---

## Testing REST APIs

### Using requests

```python
import requests
import json

BASE_URL = 'http://localhost:5000/api'

# Test login
response = requests.post(f'{BASE_URL}/login', json={
    'username': 'admin',
    'password': 'admin123'
})
token = response.json()['access_token']
headers = {'Authorization': f'Bearer {token}'}

# Test create todo
response = requests.post(
    f'{BASE_URL}/todos',
    headers=headers,
    json={
        'title': 'Test Todo',
        'description': 'Test description'
    }
)
print(response.json())

# Test get todos
response = requests.get(f'{BASE_URL}/todos', headers=headers)
print(response.json())
```

### Using pytest

```python
import pytest
import requests

BASE_URL = 'http://localhost:5000/api'

@pytest.fixture
def auth_token():
    response = requests.post(f'{BASE_URL}/login', json={
        'username': 'admin',
        'password': 'admin123'
    })
    return response.json()['access_token']

def test_create_todo(auth_token):
    headers = {'Authorization': f'Bearer {auth_token}'}
    response = requests.post(
        f'{BASE_URL}/todos',
        headers=headers,
        json={'title': 'Test Todo'}
    )
    assert response.status_code == 201
    assert 'title' in response.json()

def test_get_todos(auth_token):
    headers = {'Authorization': f'Bearer {auth_token}'}
    response = requests.get(f'{BASE_URL}/todos', headers=headers)
    assert response.status_code == 200
    assert 'todos' in response.json()
```

---

## Common Mistakes and Pitfalls

### 1. Not Using Proper HTTP Methods

```python
# WRONG: Using POST for everything
class UserResource(Resource):
    def post(self):
        # Get user
        pass
    def post(self):
        # Update user
        pass

# CORRECT: Use appropriate HTTP methods
class UserResource(Resource):
    def get(self, user_id):
        # Get user
        pass
    def put(self, user_id):
        # Update user
        pass
```

### 2. Not Returning Proper Status Codes

```python
# WRONG: Always returning 200
def post(self):
    return {'message': 'Created'}, 200

# CORRECT: Use appropriate status codes
def post(self):
    return {'message': 'Created'}, 201
```

### 3. Not Validating Input

```python
# WRONG: No validation
def post(self):
    data = request.json
    name = data['name']  # May fail

# CORRECT: Use reqparse
parser = reqparse.RequestParser()
parser.add_argument('name', type=str, required=True)
def post(self):
    args = parser.parse_args()
    name = args['name']
```

### 4. Exposing Sensitive Data

```python
# WRONG: Returning passwords
def get(self, user_id):
    return {'password': user.password}

# CORRECT: Exclude sensitive data
def get(self, user_id):
    return {'id': user.id, 'name': user.name}
```

---

## Best Practices

### 1. Use Resource Classes

```python
# Good: Separate resources
class UserList(Resource):
    def get(self):
        pass
    def post(self):
        pass

class User(Resource):
    def get(self, user_id):
        pass
    def put(self, user_id):
        pass
```

### 2. Consistent Response Format

```python
def get(self, user_id):
    user = get_user(user_id)
    if not user:
        return {'error': 'User not found'}, 404
    return {'data': user}, 200
```

### 3. Use Environment Variables

```python
import os

app.config['JWT_SECRET_KEY'] = os.environ.get('JWT_SECRET_KEY')
app.config['DATABASE_URL'] = os.environ.get('DATABASE_URL')
```

### 4. Error Handling

```python
from werkzeug.exceptions import NotFound, BadRequest

class Item(Resource):
    def get(self, item_id):
        try:
            item = get_item(item_id)
            if not item:
                raise NotFound('Item not found')
            return item, 200
        except ValueError as e:
            raise BadRequest(str(e))
```

### 5. API Versioning

```python
api_v1 = Api(app, prefix='/api/v1')
api_v2 = Api(app, prefix='/api/v2')
```

---

## Practice Exercise

### Exercise: REST API

**Objective**: Create a REST API for a blog application.

**Instructions**:

1. Create a Flask-RESTful API with:
   - User authentication (JWT)
   - Post resources (CRUD operations)
   - Comment resources
   - Proper error handling
   - Request validation

2. Your API should include:
   - POST /api/login - User login
   - GET /api/posts - List all posts
   - POST /api/posts - Create post (authenticated)
   - GET /api/posts/<id> - Get post
   - PUT /api/posts/<id> - Update post (authenticated, owner only)
   - DELETE /api/posts/<id> - Delete post (authenticated, owner only)
   - GET /api/posts/<id>/comments - Get comments for post
   - POST /api/posts/<id>/comments - Add comment (authenticated)

**Example Solution**:

```python
"""
REST API Exercise: Blog Application
"""

from flask import Flask
from flask_restful import Api, Resource, reqparse
from flask_jwt_extended import (
    JWTManager, jwt_required, create_access_token,
    get_jwt_identity
)
from flask_cors import CORS
from datetime import timedelta

app = Flask(__name__)
app.config['JWT_SECRET_KEY'] = 'your-secret-key-change-in-production'
app.config['JWT_ACCESS_TOKEN_EXPIRES'] = timedelta(hours=1)

jwt = JWTManager(app)
api = Api(app)
CORS(app)

# In-memory storage
posts = {}
comments = {}
post_id_counter = 1
comment_id_counter = 1

users = {
    'alice': {'password': 'alice123', 'name': 'Alice'},
    'bob': {'password': 'bob123', 'name': 'Bob'}
}

# Parsers
login_parser = reqparse.RequestParser()
login_parser.add_argument('username', type=str, required=True)
login_parser.add_argument('password', type=str, required=True)

post_parser = reqparse.RequestParser()
post_parser.add_argument('title', type=str, required=True)
post_parser.add_argument('content', type=str, required=True)

comment_parser = reqparse.RequestParser()
comment_parser.add_argument('content', type=str, required=True)

class Login(Resource):
    def post(self):
        args = login_parser.parse_args()
        username = args['username']
        password = args['password']
        
        if username in users and users[username]['password'] == password:
            access_token = create_access_token(identity=username)
            return {
                'access_token': access_token,
                'user': {'username': username, 'name': users[username]['name']}
            }, 200
        return {'error': 'Invalid credentials'}, 401

class PostList(Resource):
    def get(self):
        return {'posts': list(posts.values())}, 200
    
    @jwt_required()
    def post(self):
        global post_id_counter
        current_user = get_jwt_identity()
        args = post_parser.parse_args()
        
        post = {
            'id': post_id_counter,
            'title': args['title'],
            'content': args['content'],
            'author': current_user,
            'author_name': users[current_user]['name']
        }
        
        posts[post_id_counter] = post
        post_id_counter += 1
        
        return post, 201

class Post(Resource):
    def get(self, post_id):
        if post_id not in posts:
            return {'error': 'Post not found'}, 404
        return posts[post_id], 200
    
    @jwt_required()
    def put(self, post_id):
        if post_id not in posts:
            return {'error': 'Post not found'}, 404
        
        post = posts[post_id]
        current_user = get_jwt_identity()
        
        if post['author'] != current_user:
            return {'error': 'Access denied'}, 403
        
        args = post_parser.parse_args()
        post['title'] = args['title']
        post['content'] = args['content']
        
        return post, 200
    
    @jwt_required()
    def delete(self, post_id):
        if post_id not in posts:
            return {'error': 'Post not found'}, 404
        
        post = posts[post_id]
        current_user = get_jwt_identity()
        
        if post['author'] != current_user:
            return {'error': 'Access denied'}, 403
        
        # Delete associated comments
        global comments
        comments = {k: v for k, v in comments.items() if v['post_id'] != post_id}
        
        del posts[post_id]
        return None, 204

class PostComments(Resource):
    def get(self, post_id):
        if post_id not in posts:
            return {'error': 'Post not found'}, 404
        
        post_comments = [c for c in comments.values() if c['post_id'] == post_id]
        return {'comments': post_comments}, 200
    
    @jwt_required()
    def post(self, post_id):
        global comment_id_counter
        if post_id not in posts:
            return {'error': 'Post not found'}, 404
        
        current_user = get_jwt_identity()
        args = comment_parser.parse_args()
        
        comment = {
            'id': comment_id_counter,
            'post_id': post_id,
            'content': args['content'],
            'author': current_user,
            'author_name': users[current_user]['name']
        }
        
        comments[comment_id_counter] = comment
        comment_id_counter += 1
        
        return comment, 201

# Register resources
api.add_resource(Login, '/api/login')
api.add_resource(PostList, '/api/posts')
api.add_resource(Post, '/api/posts/<int:post_id>')
api.add_resource(PostComments, '/api/posts/<int:post_id>/comments')

if __name__ == '__main__':
    app.run(debug=True)
```

**Expected Output**: A complete REST API with authentication, CRUD operations, and proper error handling.

**Challenge** (Optional):
- Add pagination for posts
- Add search functionality
- Add post categories/tags
- Implement rate limiting
- Add API documentation with Swagger
- Add unit tests

---

## Key Takeaways

1. **REST principles** - Stateless, resource-based, HTTP methods
2. **Flask-RESTful** - Framework for building REST APIs
3. **Resource classes** - Organize API endpoints
4. **Request parsing** - Validate and parse request data
5. **Authentication** - JWT tokens, API keys
6. **Authorization** - Role-based access control
7. **Error handling** - Proper status codes and error messages
8. **API versioning** - URL or header-based versioning
9. **Status codes** - Use appropriate HTTP status codes
10. **Best practices** - Consistent responses, validation, security
11. **Testing** - Test APIs with requests or pytest
12. **Documentation** - Document APIs with Swagger/OpenAPI
13. **CORS** - Handle cross-origin requests
14. **Security** - Never expose sensitive data
15. **Validation** - Always validate input data

---

## Quiz: REST APIs

Test your understanding with these questions:

1. **What does REST stand for?**
   - A) Representational State Transfer
   - B) Remote State Transfer
   - C) Resource State Transfer
   - D) RESTful State Transfer

2. **What HTTP method creates a resource?**
   - A) GET
   - B) POST
   - C) PUT
   - D) DELETE

3. **What status code means "Created"?**
   - A) 200
   - B) 201
   - C) 204
   - D) 400

4. **What is used for authentication in REST APIs?**
   - A) JWT tokens
   - B) API keys
   - C) Basic auth
   - D) All of the above

5. **What validates request data in Flask-RESTful?**
   - A) reqparse
   - B) validator
   - C) parser
   - D) validator

6. **What decorator requires authentication?**
   - A) @auth_required
   - B) @jwt_required
   - C) @login_required
   - D) @secure

7. **What status code means "No Content"?**
   - A) 200
   - B) 201
   - C) 204
   - D) 404

8. **What is used for API versioning?**
   - A) URL prefix
   - B) Headers
   - C) Query parameters
   - D) All of the above

9. **What should you never return in API responses?**
   - A) User IDs
   - B) Passwords
   - C) Names
   - D) Emails

10. **What enables CORS in Flask?**
    - A) flask-cors
    - B) flask-cors extension
    - C) CORS(app)
    - D) All of the above

**Answers**:
1. A) Representational State Transfer (REST definition)
2. B) POST (create resource)
3. B) 201 (Created status code)
4. D) All of the above (authentication methods)
5. A) reqparse (request parsing)
6. B) @jwt_required (JWT authentication)
7. C) 204 (No Content)
8. D) All of the above (versioning methods)
9. B) Passwords (never expose)
10. D) All of the above (CORS setup)

---

## Next Steps

Excellent work! You've mastered building REST APIs. You now understand:
- REST API principles
- Flask-RESTful framework
- Authentication and authorization
- How to build production-ready APIs

**What's Next?**
- Lesson 20.3: GraphQL Basics
- Learn GraphQL concepts
- Work with Graphene library
- Understand GraphQL queries

---

## Additional Resources

- **Flask-RESTful**: [flask-restful.readthedocs.io/](https://flask-restful.readthedocs.io/)
- **Flask-JWT-Extended**: [flask-jwt-extended.readthedocs.io/](https://flask-jwt-extended.readthedocs.io/)
- **REST API Tutorial**: [restfulapi.net/](https://restfulapi.net/)
- **HTTP Status Codes**: [httpstatuses.com/](https://httpstatuses.com/)

---

*Lesson completed! You're ready to move on to the next lesson.*

