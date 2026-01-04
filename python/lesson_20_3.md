# Lesson 20.3: GraphQL Basics

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand GraphQL concepts and principles
- Install and use the Graphene library
- Define GraphQL schemas
- Create GraphQL types and resolvers
- Write GraphQL queries
- Handle mutations
- Work with subscriptions
- Understand GraphQL vs REST
- Implement GraphQL with Flask
- Handle errors in GraphQL
- Use GraphQL introspection
- Build GraphQL APIs
- Apply GraphQL best practices
- Debug GraphQL queries

---

## Introduction to GraphQL

**GraphQL** is a query language for APIs and a runtime for executing those queries. It was developed by Facebook and provides a more efficient, powerful, and flexible alternative to REST.

**Key Concepts**:
- **Query**: Read data
- **Mutation**: Modify data
- **Subscription**: Real-time updates
- **Schema**: Defines the API structure
- **Resolver**: Functions that fetch data
- **Type System**: Strongly typed schema

**Advantages over REST**:
- Fetch exactly what you need
- Single endpoint
- Strongly typed
- Introspection
- Real-time subscriptions

---

## GraphQL Concepts

### Queries

```graphql
# Query example
query {
  user(id: "1") {
    name
    email
    posts {
      title
      content
    }
  }
}
```

### Mutations

```graphql
# Mutation example
mutation {
  createUser(name: "John", email: "john@example.com") {
    id
    name
    email
  }
}
```

### Schema Definition

```graphql
type User {
  id: ID!
  name: String!
  email: String!
  posts: [Post!]!
}

type Post {
  id: ID!
  title: String!
  content: String!
  author: User!
}

type Query {
  user(id: ID!): User
  posts: [Post!]!
}

type Mutation {
  createUser(name: String!, email: String!): User!
  createPost(title: String!, content: String!): Post!
}
```

### Type System

```graphql
# Scalar types
String
Int
Float
Boolean
ID

# Object types
User
Post

# Lists
[String]
[User!]!

# Non-nullable
String!
ID!
```

---

## Graphene Library

### Installation

```bash
# Install Graphene
pip install graphene

# Install Flask-GraphQL for Flask integration
pip install flask-graphql

# Install GraphQL Playground (optional, for testing)
pip install graphql-core
```

### Basic Setup

```python
import graphene

class Query(graphene.ObjectType):
    hello = graphene.String()

    def resolve_hello(self, info):
        return "Hello, GraphQL!"

schema = graphene.Schema(query=Query)
```

### Flask Integration

```python
from flask import Flask
from flask_graphql import GraphQLView
import graphene

app = Flask(__name__)

class Query(graphene.ObjectType):
    hello = graphene.String()

    def resolve_hello(self, info):
        return "Hello, GraphQL!"

schema = graphene.Schema(query=Query)

app.add_url_rule(
    '/graphql',
    view_func=GraphQLView.as_view('graphql', schema=schema, graphiql=True)
)

if __name__ == '__main__':
    app.run(debug=True)
```

---

## Defining Types

### Scalar Types

```python
import graphene

class Query(graphene.ObjectType):
    name = graphene.String()
    age = graphene.Int()
    height = graphene.Float()
    is_active = graphene.Boolean()
    user_id = graphene.ID()

    def resolve_name(self, info):
        return "John Doe"
    
    def resolve_age(self, info):
        return 30
    
    def resolve_height(self, info):
        return 5.9
    
    def resolve_is_active(self, info):
        return True
    
    def resolve_user_id(self, info):
        return "1"
```

### Object Types

```python
import graphene

class User(graphene.ObjectType):
    id = graphene.ID()
    name = graphene.String()
    email = graphene.String()

class Query(graphene.ObjectType):
    user = graphene.Field(User)

    def resolve_user(self, info):
        return User(id="1", name="John Doe", email="john@example.com")
```

### Lists

```python
import graphene

class User(graphene.ObjectType):
    id = graphene.ID()
    name = graphene.String()

class Query(graphene.ObjectType):
    users = graphene.List(User)

    def resolve_users(self, info):
        return [
            User(id="1", name="Alice"),
            User(id="2", name="Bob")
        ]
```

### Non-Nullable Fields

```python
import graphene

class User(graphene.ObjectType):
    id = graphene.ID(required=True)  # Non-nullable
    name = graphene.String(required=True)
    email = graphene.String()  # Nullable
```

---

## Resolvers

### Basic Resolvers

```python
import graphene

class User(graphene.ObjectType):
    id = graphene.ID()
    name = graphene.String()
    email = graphene.String()

class Query(graphene.ObjectType):
    user = graphene.Field(User, id=graphene.ID(required=True))

    def resolve_user(self, info, id):
        # Fetch user from database
        return User(id=id, name="John", email="john@example.com")
```

### Resolvers with Arguments

```python
import graphene

class Query(graphene.ObjectType):
    user = graphene.Field(
        User,
        id=graphene.ID(required=True),
        name=graphene.String()
    )

    def resolve_user(self, info, id, name=None):
        # Fetch user by id or name
        if name:
            return User(id=id, name=name, email="email@example.com")
        return User(id=id, name="John", email="john@example.com")
```

### Nested Resolvers

```python
import graphene

class Post(graphene.ObjectType):
    id = graphene.ID()
    title = graphene.String()
    content = graphene.String()

class User(graphene.ObjectType):
    id = graphene.ID()
    name = graphene.String()
    posts = graphene.List(Post)

    def resolve_posts(self, info):
        # Fetch posts for this user
        return [
            Post(id="1", title="Post 1", content="Content 1"),
            Post(id="2", title="Post 2", content="Content 2")
        ]

class Query(graphene.ObjectType):
    user = graphene.Field(User, id=graphene.ID(required=True))

    def resolve_user(self, info, id):
        return User(id=id, name="John")
```

---

## Queries

### Simple Query

```python
import graphene

class Query(graphene.ObjectType):
    hello = graphene.String()

    def resolve_hello(self, info):
        return "Hello, GraphQL!"

schema = graphene.Schema(query=Query)

# Query:
# {
#   hello
# }
```

### Query with Arguments

```python
import graphene

class User(graphene.ObjectType):
    id = graphene.ID()
    name = graphene.String()
    email = graphene.String()

class Query(graphene.ObjectType):
    user = graphene.Field(User, id=graphene.ID(required=True))

    def resolve_user(self, info, id):
        # Fetch user by id
        return User(id=id, name="John", email="john@example.com")

schema = graphene.Schema(query=Query)

# Query:
# {
#   user(id: "1") {
#     name
#     email
#   }
# }
```

### Query with Lists

```python
import graphene

class User(graphene.ObjectType):
    id = graphene.ID()
    name = graphene.String()

class Query(graphene.ObjectType):
    users = graphene.List(User)

    def resolve_users(self, info):
        return [
            User(id="1", name="Alice"),
            User(id="2", name="Bob")
        ]

schema = graphene.Schema(query=Query)

# Query:
# {
#   users {
#     id
#     name
#   }
# }
```

---

## Mutations

### Basic Mutation

```python
import graphene

class CreateUser(graphene.Mutation):
    class Arguments:
        name = graphene.String(required=True)
        email = graphene.String(required=True)
    
    user = graphene.Field(lambda: User)
    
    def mutate(self, info, name, email):
        # Create user in database
        user = User(id="1", name=name, email=email)
        return CreateUser(user=user)

class User(graphene.ObjectType):
    id = graphene.ID()
    name = graphene.String()
    email = graphene.String()

class Mutation(graphene.ObjectType):
    create_user = CreateUser.Field()

schema = graphene.Schema(query=Query, mutation=Mutation)

# Mutation:
# mutation {
#   createUser(name: "John", email: "john@example.com") {
#     user {
#       id
#       name
#       email
#     }
#   }
# }
```

### Mutation with Input Types

```python
import graphene

class UserInput(graphene.InputObjectType):
    name = graphene.String(required=True)
    email = graphene.String(required=True)
    age = graphene.Int()

class CreateUser(graphene.Mutation):
    class Arguments:
        input = UserInput(required=True)
    
    user = graphene.Field(lambda: User)
    
    def mutate(self, info, input):
        user = User(
            id="1",
            name=input.name,
            email=input.email
        )
        return CreateUser(user=user)

class User(graphene.ObjectType):
    id = graphene.ID()
    name = graphene.String()
    email = graphene.String()

class Mutation(graphene.ObjectType):
    create_user = CreateUser.Field()

# Mutation:
# mutation {
#   createUser(input: {name: "John", email: "john@example.com"}) {
#     user {
#       id
#       name
#     }
#   }
# }
```

---

## Complete Example: Blog API

```python
"""
Complete GraphQL Example: Blog API
"""

from flask import Flask
from flask_graphql import GraphQLView
import graphene

# In-memory storage (use database in production)
users = {
    "1": {"id": "1", "name": "Alice", "email": "alice@example.com"},
    "2": {"id": "2", "name": "Bob", "email": "bob@example.com"}
}

posts = {
    "1": {"id": "1", "title": "Post 1", "content": "Content 1", "author_id": "1"},
    "2": {"id": "2", "title": "Post 2", "content": "Content 2", "author_id": "2"}
}

# GraphQL Types
class User(graphene.ObjectType):
    id = graphene.ID()
    name = graphene.String()
    email = graphene.String()
    posts = graphene.List(lambda: Post)
    
    def resolve_posts(self, info):
        return [Post(**post) for post in posts.values() if post["author_id"] == self.id]

class Post(graphene.ObjectType):
    id = graphene.ID()
    title = graphene.String()
    content = graphene.String()
    author = graphene.Field(User)
    
    def resolve_author(self, info):
        author_id = self.author_id if hasattr(self, 'author_id') else None
        if author_id and author_id in users:
            return User(**users[author_id])
        return None

# Queries
class Query(graphene.ObjectType):
    user = graphene.Field(User, id=graphene.ID(required=True))
    users = graphene.List(User)
    post = graphene.Field(Post, id=graphene.ID(required=True))
    posts = graphene.List(Post)
    
    def resolve_user(self, info, id):
        if id in users:
            return User(**users[id])
        return None
    
    def resolve_users(self, info):
        return [User(**user) for user in users.values()]
    
    def resolve_post(self, info, id):
        if id in posts:
            return Post(**posts[id])
        return None
    
    def resolve_posts(self, info):
        return [Post(**post) for post in posts.values()]

# Mutations
class CreateUser(graphene.Mutation):
    class Arguments:
        name = graphene.String(required=True)
        email = graphene.String(required=True)
    
    user = graphene.Field(User)
    
    def mutate(self, info, name, email):
        user_id = str(len(users) + 1)
        user = {"id": user_id, "name": name, "email": email}
        users[user_id] = user
        return CreateUser(user=User(**user))

class CreatePost(graphene.Mutation):
    class Arguments:
        title = graphene.String(required=True)
        content = graphene.String(required=True)
        author_id = graphene.ID(required=True)
    
    post = graphene.Field(Post)
    
    def mutate(self, info, title, content, author_id):
        if author_id not in users:
            raise Exception("User not found")
        
        post_id = str(len(posts) + 1)
        post = {
            "id": post_id,
            "title": title,
            "content": content,
            "author_id": author_id
        }
        posts[post_id] = post
        return CreatePost(post=Post(**post))

class UpdatePost(graphene.Mutation):
    class Arguments:
        id = graphene.ID(required=True)
        title = graphene.String()
        content = graphene.String()
    
    post = graphene.Field(Post)
    
    def mutate(self, info, id, title=None, content=None):
        if id not in posts:
            raise Exception("Post not found")
        
        post = posts[id]
        if title:
            post["title"] = title
        if content:
            post["content"] = content
        
        return UpdatePost(post=Post(**post))

class DeletePost(graphene.Mutation):
    class Arguments:
        id = graphene.ID(required=True)
    
    success = graphene.Boolean()
    
    def mutate(self, info, id):
        if id not in posts:
            raise Exception("Post not found")
        
        del posts[id]
        return DeletePost(success=True)

class Mutation(graphene.ObjectType):
    create_user = CreateUser.Field()
    create_post = CreatePost.Field()
    update_post = UpdatePost.Field()
    delete_post = DeletePost.Field()

# Schema
schema = graphene.Schema(query=Query, mutation=Mutation)

# Flask App
app = Flask(__name__)
app.add_url_rule(
    '/graphql',
    view_func=GraphQLView.as_view('graphql', schema=schema, graphiql=True)
)

if __name__ == '__main__':
    app.run(debug=True)
```

### Example Queries

```graphql
# Get all users
query {
  users {
    id
    name
    email
  }
}

# Get user with posts
query {
  user(id: "1") {
    name
    email
    posts {
      id
      title
    }
  }
}

# Get all posts with authors
query {
  posts {
    id
    title
    content
    author {
      name
      email
    }
  }
}

# Create user
mutation {
  createUser(name: "Charlie", email: "charlie@example.com") {
    user {
      id
      name
      email
    }
  }
}

# Create post
mutation {
  createPost(title: "New Post", content: "Post content", authorId: "1") {
    post {
      id
      title
      author {
        name
      }
    }
  }
}

# Update post
mutation {
  updatePost(id: "1", title: "Updated Title") {
    post {
      id
      title
      content
    }
  }
}

# Delete post
mutation {
  deletePost(id: "1") {
    success
  }
}
```

---

## Error Handling

### Custom Errors

```python
import graphene

class UserNotFoundError(Exception):
    pass

class Query(graphene.ObjectType):
    user = graphene.Field(User, id=graphene.ID(required=True))
    
    def resolve_user(self, info, id):
        if id not in users:
            raise UserNotFoundError(f"User {id} not found")
        return User(**users[id])
```

### Error Formatting

```python
from graphql import GraphQLError

class Query(graphene.ObjectType):
    user = graphene.Field(User, id=graphene.ID(required=True))
    
    def resolve_user(self, info, id):
        if id not in users:
            raise GraphQLError(
                message=f"User {id} not found",
                extensions={"code": "USER_NOT_FOUND"}
            )
        return User(**users[id])
```

---

## GraphQL vs REST

### REST Example

```python
# REST API
GET    /api/users          # Get all users
GET    /api/users/1        # Get user 1
GET    /api/users/1/posts  # Get posts for user 1
POST   /api/users          # Create user
PUT    /api/users/1        # Update user 1
DELETE /api/users/1        # Delete user 1
```

### GraphQL Example

```graphql
# Single endpoint: /graphql

# Query
query {
  users {
    id
    name
    posts {
      title
    }
  }
}

# Mutation
mutation {
  createUser(name: "John", email: "john@example.com") {
    id
    name
  }
}
```

### Comparison

| Feature | REST | GraphQL |
|---------|------|---------|
| Endpoints | Multiple | Single |
| Data Fetching | Fixed | Flexible |
| Over-fetching | Common | Avoided |
| Under-fetching | Common | Avoided |
| Type System | No | Yes |
| Introspection | Limited | Full |
| Caching | Easy | Complex |
| Learning Curve | Easy | Moderate |

---

## Best Practices

### 1. Use Input Types for Mutations

```python
# Good: Use InputObjectType
class UserInput(graphene.InputObjectType):
    name = graphene.String(required=True)
    email = graphene.String(required=True)

class CreateUser(graphene.Mutation):
    class Arguments:
        input = UserInput(required=True)
```

### 2. Handle Errors Gracefully

```python
def resolve_user(self, info, id):
    try:
        user = get_user_from_db(id)
        if not user:
            raise GraphQLError("User not found")
        return user
    except Exception as e:
        raise GraphQLError(f"Error fetching user: {str(e)}")
```

### 3. Use Field Resolvers

```python
class User(graphene.ObjectType):
    id = graphene.ID()
    name = graphene.String()
    posts = graphene.List(Post)
    
    def resolve_posts(self, info):
        # Lazy loading
        return get_posts_for_user(self.id)
```

### 4. Validate Input

```python
class CreateUser(graphene.Mutation):
    class Arguments:
        email = graphene.String(required=True)
    
    def mutate(self, info, email):
        if '@' not in email:
            raise GraphQLError("Invalid email format")
        # Create user
```

### 5. Use Enums

```python
class UserRole(graphene.Enum):
    ADMIN = "admin"
    USER = "user"
    GUEST = "guest"

class User(graphene.ObjectType):
    role = graphene.Field(UserRole)
```

---

## Common Mistakes and Pitfalls

### 1. N+1 Query Problem

```python
# WRONG: N+1 queries
class User(graphene.ObjectType):
    posts = graphene.List(Post)
    
    def resolve_posts(self, info):
        # This runs for each user
        return get_posts_for_user(self.id)

# CORRECT: Batch loading
class User(graphene.ObjectType):
    posts = graphene.List(Post)
    
    def resolve_posts(self, info):
        # Batch load all posts
        return batch_load_posts([user.id for user in users])
```

### 2. Not Using Input Types

```python
# WRONG: Many arguments
class CreateUser(graphene.Mutation):
    class Arguments:
        name = graphene.String(required=True)
        email = graphene.String(required=True)
        age = graphene.Int()
        address = graphene.String()
        # ... many more

# CORRECT: Use InputObjectType
class UserInput(graphene.InputObjectType):
    name = graphene.String(required=True)
    email = graphene.String(required=True)
    # ... all fields

class CreateUser(graphene.Mutation):
    class Arguments:
        input = UserInput(required=True)
```

### 3. Not Handling Errors

```python
# WRONG: No error handling
def resolve_user(self, info, id):
    return users[id]  # May raise KeyError

# CORRECT: Handle errors
def resolve_user(self, info, id):
    if id not in users:
        raise GraphQLError("User not found")
    return users[id]
```

---

## Practice Exercise

### Exercise: GraphQL API

**Objective**: Create a GraphQL API for a task management application.

**Instructions**:

1. Create a GraphQL API with:
   - Task type (id, title, description, completed, created_at)
   - User type (id, name, email, tasks)
   - Queries: tasks, task, users, user
   - Mutations: createTask, updateTask, deleteTask, createUser

2. Your API should include:
   - Proper type definitions
   - Resolvers for all fields
   - Error handling
   - Input validation

**Example Solution**:

```python
"""
GraphQL Exercise: Task Management API
"""

from flask import Flask
from flask_graphql import GraphQLView
import graphene
from datetime import datetime

# In-memory storage
tasks = {}
users = {}
task_id_counter = 1
user_id_counter = 1

# GraphQL Types
class Task(graphene.ObjectType):
    id = graphene.ID()
    title = graphene.String()
    description = graphene.String()
    completed = graphene.Boolean()
    created_at = graphene.String()
    user = graphene.Field(lambda: User)
    
    def resolve_user(self, info):
        user_id = self.user_id if hasattr(self, 'user_id') else None
        if user_id and user_id in users:
            return User(**users[user_id])
        return None

class User(graphene.ObjectType):
    id = graphene.ID()
    name = graphene.String()
    email = graphene.String()
    tasks = graphene.List(Task)
    
    def resolve_tasks(self, info):
        return [Task(**task) for task in tasks.values() if task.get("user_id") == self.id]

# Queries
class Query(graphene.ObjectType):
    task = graphene.Field(Task, id=graphene.ID(required=True))
    tasks = graphene.List(Task, completed=graphene.Boolean())
    user = graphene.Field(User, id=graphene.ID(required=True))
    users = graphene.List(User)
    
    def resolve_task(self, info, id):
        if id not in tasks:
            raise graphene.GraphQLError(f"Task {id} not found")
        return Task(**tasks[id])
    
    def resolve_tasks(self, info, completed=None):
        task_list = [Task(**task) for task in tasks.values()]
        if completed is not None:
            task_list = [t for t in task_list if t.completed == completed]
        return task_list
    
    def resolve_user(self, info, id):
        if id not in users:
            raise graphene.GraphQLError(f"User {id} not found")
        return User(**users[id])
    
    def resolve_users(self, info):
        return [User(**user) for user in users.values()]

# Mutations
class CreateTask(graphene.Mutation):
    class Arguments:
        title = graphene.String(required=True)
        description = graphene.String()
        user_id = graphene.ID(required=True)
    
    task = graphene.Field(Task)
    
    def mutate(self, info, title, description=None, user_id=None):
        global task_id_counter
        
        if user_id and user_id not in users:
            raise graphene.GraphQLError(f"User {user_id} not found")
        
        task_id = str(task_id_counter)
        task = {
            "id": task_id,
            "title": title,
            "description": description or "",
            "completed": False,
            "created_at": datetime.now().isoformat(),
            "user_id": user_id
        }
        tasks[task_id] = task
        task_id_counter += 1
        
        return CreateTask(task=Task(**task))

class UpdateTask(graphene.Mutation):
    class Arguments:
        id = graphene.ID(required=True)
        title = graphene.String()
        description = graphene.String()
        completed = graphene.Boolean()
    
    task = graphene.Field(Task)
    
    def mutate(self, info, id, title=None, description=None, completed=None):
        if id not in tasks:
            raise graphene.GraphQLError(f"Task {id} not found")
        
        task = tasks[id]
        if title is not None:
            task["title"] = title
        if description is not None:
            task["description"] = description
        if completed is not None:
            task["completed"] = completed
        
        return UpdateTask(task=Task(**task))

class DeleteTask(graphene.Mutation):
    class Arguments:
        id = graphene.ID(required=True)
    
    success = graphene.Boolean()
    
    def mutate(self, info, id):
        if id not in tasks:
            raise graphene.GraphQLError(f"Task {id} not found")
        
        del tasks[id]
        return DeleteTask(success=True)

class CreateUser(graphene.Mutation):
    class Arguments:
        name = graphene.String(required=True)
        email = graphene.String(required=True)
    
    user = graphene.Field(User)
    
    def mutate(self, info, name, email):
        global user_id_counter
        
        # Check if email already exists
        for user in users.values():
            if user.get("email") == email:
                raise graphene.GraphQLError("Email already exists")
        
        user_id = str(user_id_counter)
        user = {
            "id": user_id,
            "name": name,
            "email": email
        }
        users[user_id] = user
        user_id_counter += 1
        
        return CreateUser(user=User(**user))

class Mutation(graphene.ObjectType):
    create_task = CreateTask.Field()
    update_task = UpdateTask.Field()
    delete_task = DeleteTask.Field()
    create_user = CreateUser.Field()

# Schema
schema = graphene.Schema(query=Query, mutation=Mutation)

# Flask App
app = Flask(__name__)
app.add_url_rule(
    '/graphql',
    view_func=GraphQLView.as_view('graphql', schema=schema, graphiql=True)
)

if __name__ == '__main__':
    app.run(debug=True)
```

**Example Queries**:

```graphql
# Get all tasks
query {
  tasks {
    id
    title
    description
    completed
    user {
      name
    }
  }
}

# Get completed tasks
query {
  tasks(completed: true) {
    id
    title
  }
}

# Get user with tasks
query {
  user(id: "1") {
    name
    email
    tasks {
      id
      title
      completed
    }
  }
}

# Create task
mutation {
  createTask(title: "New Task", description: "Task description", userId: "1") {
    task {
      id
      title
      completed
    }
  }
}

# Update task
mutation {
  updateTask(id: "1", completed: true) {
    task {
      id
      title
      completed
    }
  }
}

# Delete task
mutation {
  deleteTask(id: "1") {
    success
  }
}
```

**Expected Output**: A complete GraphQL API with task and user management.

**Challenge** (Optional):
- Add task categories
- Add task priorities
- Implement task filtering and sorting
- Add user authentication
- Add subscriptions for real-time updates
- Add pagination

---

## Key Takeaways

1. **GraphQL** - Query language for APIs
2. **Graphene** - Python library for GraphQL
3. **Schema** - Defines API structure
4. **Types** - Object types, scalar types, input types
5. **Queries** - Read data
6. **Mutations** - Modify data
7. **Resolvers** - Functions that fetch data
8. **Type system** - Strongly typed schema
9. **Single endpoint** - All operations through /graphql
10. **Flexible queries** - Fetch exactly what you need
11. **Error handling** - GraphQLError for errors
12. **Input types** - Use for complex mutations
13. **Nested resolvers** - Handle relationships
14. **Best practices** - Input types, error handling, validation
15. **GraphQL vs REST** - Understand differences

---

## Quiz: GraphQL

Test your understanding with these questions:

1. **What does GraphQL stand for?**
   - A) Graph Query Language
   - B) Graph Query Library
   - C) GraphQL Query Language
   - D) None of the above

2. **What is used to read data in GraphQL?**
   - A) Mutation
   - B) Query
   - C) Subscription
   - D) Resolver

3. **What is used to modify data in GraphQL?**
   - A) Mutation
   - B) Query
   - C) Subscription
   - D) Resolver

4. **What Python library is used for GraphQL?**
   - A) GraphQL-Python
   - B) Graphene
   - C) GraphQL-py
   - D) Flask-GraphQL

5. **What defines the API structure?**
   - A) Resolver
   - B) Schema
   - C) Type
   - D) Query

6. **What fetches data in GraphQL?**
   - A) Query
   - B) Resolver
   - C) Mutation
   - D) Schema

7. **What is the main advantage of GraphQL over REST?**
   - A) Multiple endpoints
   - B) Fetch exactly what you need
   - C) Easier caching
   - D) Simpler syntax

8. **What type is used for mutations with multiple fields?**
   - A) ObjectType
   - B) InputObjectType
   - C) ScalarType
   - D) ListType

9. **What indicates a non-nullable field?**
   - A) !
   - B) ?
   - C) *
   - D) +

10. **What is GraphiQL?**
    - A) GraphQL library
    - B) GraphQL IDE
    - C) GraphQL server
    - D) GraphQL client

**Answers**:
1. D) None of the above (GraphQL is the name)
2. B) Query (read data)
3. A) Mutation (modify data)
4. B) Graphene (Python GraphQL library)
5. B) Schema (defines structure)
6. B) Resolver (fetches data)
7. B) Fetch exactly what you need (main advantage)
8. B) InputObjectType (for mutations)
9. A) ! (non-nullable indicator)
10. B) GraphQL IDE (interactive IDE)

---

## Next Steps

Excellent work! You've mastered GraphQL basics. You now understand:
- GraphQL concepts
- Graphene library
- How to build GraphQL APIs
- Queries and mutations

**What's Next?**
- Course 5: Python for Data Science
- Learn data science fundamentals
- Work with data analysis libraries
- Explore machine learning

---

## Additional Resources

- **GraphQL Documentation**: [graphql.org/](https://graphql.org/)
- **Graphene Documentation**: [docs.graphene-python.org/](https://docs.graphene-python.org/)
- **Flask-GraphQL**: [github.com/graphql-python/flask-graphql](https://github.com/graphql-python/flask-graphql)
- **GraphQL Best Practices**: [graphql.org/learn/best-practices/](https://graphql.org/learn/best-practices/)

---

*Lesson completed! You're ready to move on to the next course.*

