# Lesson 29.3: RESTful APIs with Express

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand REST principles
- Design RESTful API endpoints
- Handle API requests and responses
- Implement proper error handling
- Build REST APIs with Express
- Follow REST conventions
- Create production-ready APIs

---

## Introduction to REST

REST (Representational State Transfer) is an architectural style for designing networked applications. RESTful APIs use HTTP methods to perform operations on resources.

### What is REST?

- **Architectural Style**: Design pattern for web services
- **Resource-Based**: Everything is a resource
- **HTTP Methods**: Use standard HTTP methods
- **Stateless**: Each request is independent
- **Uniform Interface**: Consistent API design
- **Client-Server**: Separation of concerns

---

## REST Principles

### REST Principles

1. **Client-Server**: Separation of client and server
2. **Stateless**: Each request contains all information
3. **Cacheable**: Responses can be cached
4. **Uniform Interface**: Consistent resource identification
5. **Layered System**: System can have multiple layers
6. **Code on Demand**: Optional - server can send executable code

### RESTful Design

- **Resources**: Identified by URLs
- **HTTP Methods**: GET, POST, PUT, DELETE, PATCH
- **Status Codes**: Use appropriate HTTP status codes
- **JSON**: Common format for data exchange
- **Stateless**: No server-side session state

---

## API Endpoints

### RESTful Endpoint Design

```javascript
// Resource: Users
GET    /users           // Get all users
GET    /users/:id       // Get user by ID
POST   /users           // Create new user
PUT    /users/:id       // Update entire user
PATCH  /users/:id       // Partially update user
DELETE /users/:id       // Delete user

// Nested resources
GET    /users/:id/posts        // Get user's posts
GET    /users/:id/posts/:postId // Get specific post
POST   /users/:id/posts        // Create post for user
```

### Express Router

```javascript
const express = require('express');
const router = express.Router();

// GET /users
router.get('/', (req, res) => {
    res.json(users);
});

// GET /users/:id
router.get('/:id', (req, res) => {
    const user = users.find(u => u.id === parseInt(req.params.id));
    if (user) {
        res.json(user);
    } else {
        res.status(404).json({ error: 'User not found' });
    }
});

// POST /users
router.post('/', (req, res) => {
    const newUser = {
        id: users.length + 1,
        ...req.body
    };
    users.push(newUser);
    res.status(201).json(newUser);
});

// PUT /users/:id
router.put('/:id', (req, res) => {
    const userId = parseInt(req.params.id);
    const userIndex = users.findIndex(u => u.id === userId);
    
    if (userIndex === -1) {
        return res.status(404).json({ error: 'User not found' });
    }
    
    users[userIndex] = { id: userId, ...req.body };
    res.json(users[userIndex]);
});

// DELETE /users/:id
router.delete('/:id', (req, res) => {
    const userId = parseInt(req.params.id);
    const userIndex = users.findIndex(u => u.id === userId);
    
    if (userIndex === -1) {
        return res.status(404).json({ error: 'User not found' });
    }
    
    users.splice(userIndex, 1);
    res.status(204).send();
});

module.exports = router;
```

### Using Router

```javascript
const express = require('express');
const usersRouter = require('./routes/users');
const postsRouter = require('./routes/posts');

const app = express();

app.use(express.json());

// Mount routers
app.use('/api/users', usersRouter);
app.use('/api/posts', postsRouter);

app.listen(3000);
```

---

## Request/Response Handling

### Request Validation

```javascript
const express = require('express');
const router = express.Router();

// Validation middleware
const validateUser = (req, res, next) => {
    const { name, email } = req.body;
    
    if (!name || !email) {
        return res.status(400).json({
            error: 'Name and email are required'
        });
    }
    
    if (!email.includes('@')) {
        return res.status(400).json({
            error: 'Invalid email format'
        });
    }
    
    next();
};

// Use validation
router.post('/', validateUser, (req, res) => {
    const newUser = {
        id: Date.now(),
        ...req.body
    };
    res.status(201).json(newUser);
});
```

### Response Formatting

```javascript
const express = require('express');
const router = express.Router();

// Success response
router.get('/:id', (req, res) => {
    const user = users.find(u => u.id === parseInt(req.params.id));
    
    if (user) {
        res.json({
            success: true,
            data: user
        });
    } else {
        res.status(404).json({
            success: false,
            error: 'User not found'
        });
    }
});

// List response
router.get('/', (req, res) => {
    res.json({
        success: true,
        count: users.length,
        data: users
    });
});
```

### Query Parameters

```javascript
const express = require('express');
const router = express.Router();

router.get('/', (req, res) => {
    const { page = 1, limit = 10, sort = 'id', order = 'asc' } = req.query;
    
    // Pagination
    const startIndex = (page - 1) * limit;
    const endIndex = page * limit;
    
    // Sorting
    const sortedUsers = [...users].sort((a, b) => {
        if (order === 'asc') {
            return a[sort] > b[sort] ? 1 : -1;
        } else {
            return a[sort] < b[sort] ? 1 : -1;
        }
    });
    
    // Paginate
    const paginatedUsers = sortedUsers.slice(startIndex, endIndex);
    
    res.json({
        success: true,
        page: parseInt(page),
        limit: parseInt(limit),
        total: users.length,
        data: paginatedUsers
    });
});
```

---

## Error Handling

### Error Handling Middleware

```javascript
const express = require('express');
const app = express();

// Custom error class
class AppError extends Error {
    constructor(message, statusCode) {
        super(message);
        this.statusCode = statusCode;
        this.isOperational = true;
        Error.captureStackTrace(this, this.constructor);
    }
}

// Error handling middleware
const errorHandler = (err, req, res, next) => {
    err.statusCode = err.statusCode || 500;
    err.status = err.status || 'error';
    
    if (process.env.NODE_ENV === 'development') {
        res.status(err.statusCode).json({
            status: err.status,
            error: err,
            message: err.message,
            stack: err.stack
        });
    } else {
        // Production
        if (err.isOperational) {
            res.status(err.statusCode).json({
                status: err.status,
                message: err.message
            });
        } else {
            // Programming or unknown error
            res.status(500).json({
                status: 'error',
                message: 'Something went wrong!'
            });
        }
    }
};

// Use error handler
app.use(errorHandler);
```

### Async Error Handling

```javascript
const express = require('express');
const router = express.Router();

// Async wrapper
const asyncHandler = (fn) => {
    return (req, res, next) => {
        Promise.resolve(fn(req, res, next)).catch(next);
    };
};

// Use with async functions
router.get('/:id', asyncHandler(async (req, res) => {
    const user = await User.findById(req.params.id);
    if (!user) {
        throw new AppError('User not found', 404);
    }
    res.json({ success: true, data: user });
}));
```

### Error Types

```javascript
// 400 - Bad Request
if (!req.body.name) {
    return res.status(400).json({
        error: 'Name is required'
    });
}

// 401 - Unauthorized
if (!isAuthenticated) {
    return res.status(401).json({
        error: 'Unauthorized'
    });
}

// 403 - Forbidden
if (!hasPermission) {
    return res.status(403).json({
        error: 'Forbidden'
    });
}

// 404 - Not Found
if (!user) {
    return res.status(404).json({
        error: 'User not found'
    });
}

// 409 - Conflict
if (userExists) {
    return res.status(409).json({
        error: 'User already exists'
    });
}

// 500 - Internal Server Error
try {
    // Operation
} catch (error) {
    return res.status(500).json({
        error: 'Internal server error'
    });
}
```

---

## Practice Exercise

### Exercise: REST API

**Objective**: Practice building RESTful APIs with Express, implementing proper endpoints, request/response handling, and error handling.

**Instructions**:

1. Create a REST API
2. Implement CRUD operations
3. Add validation and error handling
4. Practice:
   - REST principles
   - API endpoints
   - Request/response handling
   - Error handling

**Example Solution**:

```javascript
// src/routes/users.js
const express = require('express');
const router = express.Router();

// In-memory data store
let users = [
    { id: 1, name: 'Alice', email: 'alice@example.com', age: 30 },
    { id: 2, name: 'Bob', email: 'bob@example.com', age: 25 }
];

// Validation middleware
const validateUser = (req, res, next) => {
    const { name, email, age } = req.body;
    
    if (!name || !email) {
        return res.status(400).json({
            success: false,
            error: 'Name and email are required'
        });
    }
    
    if (!email.includes('@')) {
        return res.status(400).json({
            success: false,
            error: 'Invalid email format'
        });
    }
    
    if (age && (isNaN(age) || age < 0)) {
        return res.status(400).json({
            success: false,
            error: 'Age must be a positive number'
        });
    }
    
    next();
};

// GET /api/users - Get all users
router.get('/', (req, res) => {
    const { page = 1, limit = 10, sort = 'id', order = 'asc' } = req.query;
    
    // Sorting
    const sortedUsers = [...users].sort((a, b) => {
        const aVal = a[sort];
        const bVal = b[sort];
        
        if (order === 'desc') {
            return aVal < bVal ? 1 : -1;
        }
        return aVal > bVal ? 1 : -1;
    });
    
    // Pagination
    const startIndex = (page - 1) * limit;
    const endIndex = page * limit;
    const paginatedUsers = sortedUsers.slice(startIndex, endIndex);
    
    res.json({
        success: true,
        page: parseInt(page),
        limit: parseInt(limit),
        total: users.length,
        data: paginatedUsers
    });
});

// GET /api/users/:id - Get user by ID
router.get('/:id', (req, res) => {
    const userId = parseInt(req.params.id);
    const user = users.find(u => u.id === userId);
    
    if (!user) {
        return res.status(404).json({
            success: false,
            error: 'User not found'
        });
    }
    
    res.json({
        success: true,
        data: user
    });
});

// POST /api/users - Create new user
router.post('/', validateUser, (req, res) => {
    const { name, email, age } = req.body;
    
    // Check if email already exists
    const existingUser = users.find(u => u.email === email);
    if (existingUser) {
        return res.status(409).json({
            success: false,
            error: 'User with this email already exists'
        });
    }
    
    const newUser = {
        id: users.length > 0 ? Math.max(...users.map(u => u.id)) + 1 : 1,
        name,
        email,
        age: age || null
    };
    
    users.push(newUser);
    
    res.status(201).json({
        success: true,
        data: newUser
    });
});

// PUT /api/users/:id - Update entire user
router.put('/:id', validateUser, (req, res) => {
    const userId = parseInt(req.params.id);
    const userIndex = users.findIndex(u => u.id === userId);
    
    if (userIndex === -1) {
        return res.status(404).json({
            success: false,
            error: 'User not found'
        });
    }
    
    const { name, email, age } = req.body;
    
    // Check if email is taken by another user
    const emailTaken = users.some(u => u.email === email && u.id !== userId);
    if (emailTaken) {
        return res.status(409).json({
            success: false,
            error: 'Email already taken'
        });
    }
    
    users[userIndex] = {
        id: userId,
        name,
        email,
        age: age || null
    };
    
    res.json({
        success: true,
        data: users[userIndex]
    });
});

// PATCH /api/users/:id - Partially update user
router.patch('/:id', (req, res) => {
    const userId = parseInt(req.params.id);
    const userIndex = users.findIndex(u => u.id === userId);
    
    if (userIndex === -1) {
        return res.status(404).json({
            success: false,
            error: 'User not found'
        });
    }
    
    const { name, email, age } = req.body;
    
    // Validate email if provided
    if (email && !email.includes('@')) {
        return res.status(400).json({
            success: false,
            error: 'Invalid email format'
        });
    }
    
    // Check if email is taken
    if (email) {
        const emailTaken = users.some(u => u.email === email && u.id !== userId);
        if (emailTaken) {
            return res.status(409).json({
                success: false,
                error: 'Email already taken'
            });
        }
    }
    
    // Update only provided fields
    if (name) users[userIndex].name = name;
    if (email) users[userIndex].email = email;
    if (age !== undefined) users[userIndex].age = age;
    
    res.json({
        success: true,
        data: users[userIndex]
    });
});

// DELETE /api/users/:id - Delete user
router.delete('/:id', (req, res) => {
    const userId = parseInt(req.params.id);
    const userIndex = users.findIndex(u => u.id === userId);
    
    if (userIndex === -1) {
        return res.status(404).json({
            success: false,
            error: 'User not found'
        });
    }
    
    users.splice(userIndex, 1);
    
    res.status(204).send();
});

module.exports = router;
```

```javascript
// src/middleware/errorHandler.js
const errorHandler = (err, req, res, next) => {
    let error = { ...err };
    error.message = err.message;
    
    // Log error
    console.error(err);
    
    // Mongoose bad ObjectId
    if (err.name === 'CastError') {
        const message = 'Resource not found';
        error = { message, statusCode: 404 };
    }
    
    // Mongoose duplicate key
    if (err.code === 11000) {
        const message = 'Duplicate field value entered';
        error = { message, statusCode: 400 };
    }
    
    // Mongoose validation error
    if (err.name === 'ValidationError') {
        const message = Object.values(err.errors).map(val => val.message);
        error = { message, statusCode: 400 };
    }
    
    res.status(error.statusCode || 500).json({
        success: false,
        error: error.message || 'Server Error'
    });
};

module.exports = errorHandler;
```

```javascript
// src/middleware/notFound.js
const notFound = (req, res, next) => {
    res.status(404).json({
        success: false,
        error: `Route ${req.originalUrl} not found`
    });
};

module.exports = notFound;
```

```javascript
// src/app.js
const express = require('express');
const usersRouter = require('./routes/users');
const errorHandler = require('./middleware/errorHandler');
const notFound = require('./middleware/notFound');

const app = express();

// Middleware
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// CORS
app.use((req, res, next) => {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE');
    res.header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    next();
});

// Routes
app.get('/', (req, res) => {
    res.json({
        success: true,
        message: 'Welcome to REST API',
        endpoints: {
            users: '/api/users'
        }
    });
});

app.use('/api/users', usersRouter);

// Error handling
app.use(notFound);
app.use(errorHandler);

// Start server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
    console.log(`API available at http://localhost:${PORT}/api`);
});
```

```json
// package.json
{
  "name": "rest-api-practice",
  "version": "1.0.0",
  "description": "RESTful API practice with Express",
  "main": "src/app.js",
  "scripts": {
    "start": "node src/app.js",
    "dev": "nodemon src/app.js"
  },
  "dependencies": {
    "express": "^4.18.0"
  },
  "devDependencies": {
    "nodemon": "^2.0.0"
  },
  "keywords": ["express", "rest", "api"],
  "author": "",
  "license": "ISC"
}
```

**Testing the API**:

```bash
# Start server
npm start

# GET all users
curl http://localhost:3000/api/users

# GET user by ID
curl http://localhost:3000/api/users/1

# POST create user
curl -X POST http://localhost:3000/api/users \
  -H "Content-Type: application/json" \
  -d '{"name":"Charlie","email":"charlie@example.com","age":35}'

# PUT update user
curl -X PUT http://localhost:3000/api/users/1 \
  -H "Content-Type: application/json" \
  -d '{"name":"Alice Updated","email":"alice.updated@example.com","age":31}'

# PATCH partial update
curl -X PATCH http://localhost:3000/api/users/1 \
  -H "Content-Type: application/json" \
  -d '{"age":32}'

# DELETE user
curl -X DELETE http://localhost:3000/api/users/1
```

**Expected Output**:
- REST API with CRUD operations
- Proper status codes
- Error handling
- Validation
- Pagination and sorting

**Challenge (Optional)**:
- Add authentication
- Implement rate limiting
- Add API documentation
- Create nested resources

---

## Common Mistakes

### 1. Wrong HTTP Methods

```javascript
// ❌ Bad: Using GET for creating
app.get('/users', createUser);

// ✅ Good: Use POST for creating
app.post('/users', createUser);
```

### 2. Not Using Status Codes

```javascript
// ❌ Bad: Always 200
res.json({ error: 'Not found' });

// ✅ Good: Use appropriate status code
res.status(404).json({ error: 'Not found' });
```

### 3. Inconsistent Response Format

```javascript
// ❌ Bad: Inconsistent format
res.json(user);
res.json({ data: user });
res.json({ success: true, user });

// ✅ Good: Consistent format
res.json({ success: true, data: user });
```

---

## Key Takeaways

1. **REST**: Architectural style for web services
2. **Resources**: Identified by URLs
3. **HTTP Methods**: GET, POST, PUT, PATCH, DELETE
4. **Status Codes**: Use appropriate codes
5. **Error Handling**: Proper error responses
6. **Best Practice**: Consistent format, validation, documentation
7. **RESTful**: Follow REST principles

---

## Quiz: REST APIs

Test your understanding with these questions:

1. **REST stands for:**
   - A) Representational State Transfer
   - B) Remote State Transfer
   - C) Both
   - D) Neither

2. **GET method:**
   - A) Retrieve data
   - B) Create data
   - C) Both
   - D) Neither

3. **POST method:**
   - A) Retrieve data
   - B) Create data
   - C) Both
   - D) Neither

4. **PUT method:**
   - A) Update entire resource
   - B) Partial update
   - C) Both
   - D) Neither

5. **PATCH method:**
   - A) Update entire resource
   - B) Partial update
   - C) Both
   - D) Neither

6. **Status code 201:**
   - A) Created
   - B) Updated
   - C) Both
   - D) Neither

7. **Status code 204:**
   - A) No content
   - B) Success
   - C) Both
   - D) Neither

**Answers**:
1. A) Representational State Transfer
2. A) Retrieve data
3. B) Create data
4. A) Update entire resource
5. B) Partial update
6. A) Created
7. A) No content

---

## Next Steps

Congratulations! You've completed Module 29: Building Web Servers. You now know:
- How to create HTTP servers
- How to use Express.js
- How to build RESTful APIs
- How to handle requests and errors

**What's Next?**
- Module 30: Databases and Authentication
- Lesson 30.1: Working with Databases
- Learn database integration
- Work with SQL and NoSQL databases

---

## Additional Resources

- **REST API Tutorial**: [restfulapi.net](https://restfulapi.net)
- **HTTP Status Codes**: [developer.mozilla.org/en-US/docs/Web/HTTP/Status](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status)
- **Express Best Practices**: [expressjs.com/en/advanced/best-practice-performance.html](https://expressjs.com/en/advanced/best-practice-performance.html)

---

*Lesson completed! You've finished Module 29: Building Web Servers. Ready for Module 30: Databases and Authentication!*

