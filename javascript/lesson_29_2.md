# Lesson 29.2: Express.js Framework

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand Express.js framework
- Create Express applications
- Work with routes and middleware
- Handle requests and responses
- Use template engines
- Build web applications with Express
- Organize Express applications

---

## Express Introduction

Express.js is a fast, unopinionated, minimalist web framework for Node.js. It simplifies building web applications and APIs.

### What is Express?

- **Web Framework**: Simplifies Node.js web development
- **Minimalist**: Lightweight and flexible
- **Middleware**: Powerful middleware system
- **Routing**: Easy routing system
- **Template Engines**: Support for various template engines
- **Popular**: Most popular Node.js framework

### Why Express?

- **Simple**: Easy to learn and use
- **Flexible**: Unopinionated, use as needed
- **Fast**: Lightweight and performant
- **Middleware**: Rich ecosystem of middleware
- **Community**: Large community and resources
- **Standard**: Industry standard for Node.js

---

## Express Introduction

### Installation

```bash
# Install Express
npm install express

# Install with dev dependencies
npm install express --save-dev

# Install specific version
npm install express@4.18.0
```

### Basic Express App

```javascript
const express = require('express');
const app = express();
const PORT = 3000;

// Basic route
app.get('/', (req, res) => {
    res.send('Hello, Express!');
});

// Start server
app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});
```

### Express vs Native HTTP

```javascript
// Native HTTP (verbose)
const http = require('http');
const server = http.createServer((req, res) => {
    if (req.url === '/' && req.method === 'GET') {
        res.writeHead(200, { 'Content-Type': 'text/plain' });
        res.end('Hello');
    }
});

// Express (simple)
const express = require('express');
const app = express();
app.get('/', (req, res) => {
    res.send('Hello');
});
```

---

## Routes and Middleware

### Basic Routes

```javascript
const express = require('express');
const app = express();

// GET route
app.get('/', (req, res) => {
    res.send('Home page');
});

// POST route
app.post('/users', (req, res) => {
    res.send('Create user');
});

// PUT route
app.put('/users/:id', (req, res) => {
    res.send('Update user');
});

// DELETE route
app.delete('/users/:id', (req, res) => {
    res.send('Delete user');
});

// All methods
app.all('/test', (req, res) => {
    res.send('Any method');
});
```

### Route Parameters

```javascript
const express = require('express');
const app = express();

// Single parameter
app.get('/users/:id', (req, res) => {
    const userId = req.params.id;
    res.send(`User ID: ${userId}`);
});

// Multiple parameters
app.get('/users/:userId/posts/:postId', (req, res) => {
    const { userId, postId } = req.params;
    res.send(`User ${userId}, Post ${postId}`);
});

// Optional parameter
app.get('/users/:id?', (req, res) => {
    const userId = req.params.id || 'all';
    res.send(`User: ${userId}`);
});
```

### Query Parameters

```javascript
const express = require('express');
const app = express();

// Query parameters
app.get('/search', (req, res) => {
    const { q, page, limit } = req.query;
    res.json({
        query: q,
        page: page || 1,
        limit: limit || 10
    });
});

// Usage: /search?q=express&page=1&limit=10
```

### Route Handlers

```javascript
const express = require('express');
const app = express();

// Single handler
app.get('/single', (req, res) => {
    res.send('Single handler');
});

// Multiple handlers
app.get('/multiple',
    (req, res, next) => {
        console.log('First handler');
        next();
    },
    (req, res) => {
        res.send('Second handler');
    }
);

// Array of handlers
const handlers = [
    (req, res, next) => {
        console.log('Handler 1');
        next();
    },
    (req, res, next) => {
        console.log('Handler 2');
        next();
    },
    (req, res) => {
        res.send('Handler 3');
    }
];
app.get('/array', handlers);
```

### Middleware

```javascript
const express = require('express');
const app = express();

// Application-level middleware
app.use((req, res, next) => {
    console.log('Request:', req.method, req.url);
    next(); // Continue to next middleware
});

// Route-specific middleware
const checkAuth = (req, res, next) => {
    const isAuthenticated = true; // Check authentication
    if (isAuthenticated) {
        next();
    } else {
        res.status(401).send('Unauthorized');
    }
};

app.get('/protected', checkAuth, (req, res) => {
    res.send('Protected route');
});

// Multiple middleware
app.use('/api', checkAuth, (req, res, next) => {
    console.log('API middleware');
    next();
});
```

### Built-in Middleware

```javascript
const express = require('express');
const app = express();

// Parse JSON bodies
app.use(express.json());

// Parse URL-encoded bodies
app.use(express.urlencoded({ extended: true }));

// Serve static files
app.use(express.static('public'));

// CORS (if needed)
app.use((req, res, next) => {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
    next();
});
```

---

## Request Handling

### Request Object

```javascript
const express = require('express');
const app = express();

app.use(express.json());
app.use(express.urlencoded({ extended: true }));

app.post('/users', (req, res) => {
    // Request properties
    console.log('Method:', req.method);
    console.log('URL:', req.url);
    console.log('Path:', req.path);
    console.log('Query:', req.query);
    console.log('Params:', req.params);
    console.log('Headers:', req.headers);
    console.log('Body:', req.body);
    console.log('IP:', req.ip);
    console.log('Protocol:', req.protocol);
    console.log('Hostname:', req.hostname);
    
    res.send('Request logged');
});
```

### Response Methods

```javascript
const express = require('express');
const app = express();

app.get('/response', (req, res) => {
    // Send response
    res.send('Hello, World!');
    
    // Send JSON
    res.json({ message: 'Hello' });
    
    // Send status
    res.status(200).send('OK');
    
    // Send file
    res.sendFile('/path/to/file.html');
    
    // Redirect
    res.redirect('/other-route');
    
    // Set header
    res.set('X-Custom-Header', 'value');
    
    // Set multiple headers
    res.set({
        'X-Header-1': 'value1',
        'X-Header-2': 'value2'
    });
    
    // Cookie
    res.cookie('name', 'value');
    
    // Clear cookie
    res.clearCookie('name');
});
```

### Error Handling

```javascript
const express = require('express');
const app = express();

// Error handling middleware (must be last)
app.use((err, req, res, next) => {
    console.error(err.stack);
    res.status(500).json({
        error: 'Something went wrong!',
        message: err.message
    });
});

// Route with error
app.get('/error', (req, res, next) => {
    try {
        throw new Error('Test error');
    } catch (error) {
        next(error); // Pass to error handler
    }
});

// Async error handling
app.get('/async-error', async (req, res, next) => {
    try {
        // Async operation
        await someAsyncOperation();
    } catch (error) {
        next(error);
    }
});
```

---

## Template Engines

### What are Template Engines?

Template engines allow you to use static template files and replace variables with actual values at runtime.

### Setting Up Template Engine

```javascript
const express = require('express');
const app = express();

// Set view engine
app.set('view engine', 'ejs');

// Set views directory
app.set('views', './views');

// Render template
app.get('/', (req, res) => {
    res.render('index', {
        title: 'Home Page',
        message: 'Hello, World!'
    });
});
```

### EJS Template

```html
<!-- views/index.ejs -->
<!DOCTYPE html>
<html>
<head>
    <title><%= title %></title>
</head>
<body>
    <h1><%= title %></h1>
    <p><%= message %></p>
    
    <!-- Loop -->
    <ul>
        <% users.forEach(user => { %>
            <li><%= user.name %></li>
        <% }); %>
    </ul>
    
    <!-- Condition -->
    <% if (isLoggedIn) { %>
        <p>Welcome back!</p>
    <% } else { %>
        <p>Please log in</p>
    <% } %>
</body>
</html>
```

### Handlebars Template

```javascript
// Install: npm install express-handlebars
const express = require('express');
const exphbs = require('express-handlebars');

const app = express();

app.engine('handlebars', exphbs());
app.set('view engine', 'handlebars');

app.get('/', (req, res) => {
    res.render('index', {
        title: 'Home',
        users: [
            { name: 'Alice' },
            { name: 'Bob' }
        ]
    });
});
```

```handlebars
<!-- views/index.handlebars -->
<h1>{{title}}</h1>
<ul>
    {{#each users}}
        <li>{{name}}</li>
    {{/each}}
</ul>
```

### Pug Template

```javascript
// Install: npm install pug
const express = require('express');
const app = express();

app.set('view engine', 'pug');

app.get('/', (req, res) => {
    res.render('index', {
        title: 'Home',
        users: ['Alice', 'Bob']
    });
});
```

```pug
//- views/index.pug
html
    head
        title= title
    body
        h1= title
        ul
            each user in users
                li= user
```

---

## Practice Exercise

### Exercise: Express App

**Objective**: Practice creating Express applications, working with routes and middleware, handling requests, and using template engines.

**Instructions**:

1. Create an Express application
2. Set up routes and middleware
3. Handle requests and responses
4. Use template engines
5. Practice:
   - Creating Express apps
   - Setting up routes
   - Using middleware
   - Handling requests
   - Rendering templates

**Example Solution**:

```javascript
// src/app.js
const express = require('express');
const path = require('path');
const app = express();
const PORT = process.env.PORT || 3000;

// Set view engine
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// Middleware
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));

// Logging middleware
app.use((req, res, next) => {
    console.log(`${new Date().toISOString()} - ${req.method} ${req.url}`);
    next();
});

// In-memory data store
let users = [
    { id: 1, name: 'Alice', email: 'alice@example.com' },
    { id: 2, name: 'Bob', email: 'bob@example.com' }
];

// Routes
app.get('/', (req, res) => {
    res.render('index', {
        title: 'Home',
        message: 'Welcome to Express App!'
    });
});

app.get('/users', (req, res) => {
    res.render('users', {
        title: 'Users',
        users: users
    });
});

app.get('/users/:id', (req, res) => {
    const user = users.find(u => u.id === parseInt(req.params.id));
    if (user) {
        res.render('user-detail', {
            title: `User: ${user.name}`,
            user: user
        });
    } else {
        res.status(404).render('error', {
            title: 'Not Found',
            message: 'User not found'
        });
    }
});

app.get('/api/users', (req, res) => {
    res.json(users);
});

app.get('/api/users/:id', (req, res) => {
    const user = users.find(u => u.id === parseInt(req.params.id));
    if (user) {
        res.json(user);
    } else {
        res.status(404).json({ error: 'User not found' });
    }
});

app.post('/api/users', (req, res) => {
    const { name, email } = req.body;
    if (!name || !email) {
        return res.status(400).json({ error: 'Name and email are required' });
    }
    
    const newUser = {
        id: users.length > 0 ? Math.max(...users.map(u => u.id)) + 1 : 1,
        name,
        email
    };
    
    users.push(newUser);
    res.status(201).json(newUser);
});

app.put('/api/users/:id', (req, res) => {
    const userId = parseInt(req.params.id);
    const userIndex = users.findIndex(u => u.id === userId);
    
    if (userIndex === -1) {
        return res.status(404).json({ error: 'User not found' });
    }
    
    const { name, email } = req.body;
    users[userIndex] = { ...users[userIndex], ...req.body };
    
    res.json(users[userIndex]);
});

app.delete('/api/users/:id', (req, res) => {
    const userId = parseInt(req.params.id);
    const userIndex = users.findIndex(u => u.id === userId);
    
    if (userIndex === -1) {
        return res.status(404).json({ error: 'User not found' });
    }
    
    users.splice(userIndex, 1);
    res.status(204).send();
});

// Error handling middleware
app.use((err, req, res, next) => {
    console.error(err.stack);
    res.status(500).render('error', {
        title: 'Error',
        message: 'Something went wrong!'
    });
});

// 404 handler
app.use((req, res) => {
    res.status(404).render('error', {
        title: 'Not Found',
        message: 'Page not found'
    });
});

// Start server
app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});
```

```html
<!-- views/index.ejs -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><%= title %></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <h1><%= title %></h1>
        <p><%= message %></p>
        <nav>
            <a href="/">Home</a>
            <a href="/users">Users</a>
            <a href="/api/users">API Users</a>
        </nav>
    </div>
</body>
</html>
```

```html
<!-- views/users.ejs -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><%= title %></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <h1><%= title %></h1>
        <nav>
            <a href="/">Home</a>
            <a href="/users">Users</a>
        </nav>
        <ul class="user-list">
            <% users.forEach(user => { %>
                <li>
                    <a href="/users/<%= user.id %>">
                        <%= user.name %> - <%= user.email %>
                    </a>
                </li>
            <% }); %>
        </ul>
    </div>
</body>
</html>
```

```html
<!-- views/user-detail.ejs -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><%= title %></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <h1><%= title %></h1>
        <nav>
            <a href="/">Home</a>
            <a href="/users">Users</a>
        </nav>
        <div class="user-detail">
            <p><strong>ID:</strong> <%= user.id %></p>
            <p><strong>Name:</strong> <%= user.name %></p>
            <p><strong>Email:</strong> <%= user.email %></p>
        </div>
    </div>
</body>
</html>
```

```html
<!-- views/error.ejs -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><%= title %></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <h1><%= title %></h1>
        <p><%= message %></p>
        <nav>
            <a href="/">Home</a>
        </nav>
    </div>
</body>
</html>
```

```css
/* public/css/style.css */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    color: #333;
    background-color: #f4f4f4;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: white;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

h1 {
    color: #333;
    margin-bottom: 20px;
}

nav {
    margin: 20px 0;
}

nav a {
    display: inline-block;
    margin-right: 10px;
    padding: 8px 16px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 4px;
}

nav a:hover {
    background-color: #0056b3;
}

.user-list {
    list-style: none;
    padding: 0;
}

.user-list li {
    padding: 10px;
    margin: 5px 0;
    background-color: #f8f9fa;
    border-radius: 4px;
}

.user-list a {
    text-decoration: none;
    color: #007bff;
}

.user-list a:hover {
    text-decoration: underline;
}

.user-detail {
    margin-top: 20px;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 4px;
}

.user-detail p {
    margin: 10px 0;
}
```

```json
// package.json
{
  "name": "express-app-practice",
  "version": "1.0.0",
  "description": "Express.js application practice",
  "main": "src/app.js",
  "scripts": {
    "start": "node src/app.js",
    "dev": "nodemon src/app.js"
  },
  "dependencies": {
    "express": "^4.18.0",
    "ejs": "^3.1.9"
  },
  "devDependencies": {
    "nodemon": "^2.0.0"
  },
  "keywords": ["express", "nodejs"],
  "author": "",
  "license": "ISC"
}
```

**Expected Output**:
- Express server running
- HTML pages rendered
- API endpoints working
- Static files served
- Error handling working

**Challenge (Optional)**:
- Add authentication
- Implement sessions
- Add database integration
- Build a complete application

---

## Common Mistakes

### 1. Not Using next() in Middleware

```javascript
// ❌ Bad: Missing next()
app.use((req, res) => {
    console.log('Request');
    // Request hangs
});

// ✅ Good: Call next()
app.use((req, res, next) => {
    console.log('Request');
    next();
});
```

### 2. Wrong Middleware Order

```javascript
// ❌ Bad: Error handler before routes
app.use((err, req, res, next) => {
    // Error handler
});
app.get('/', (req, res) => {
    // Route
});

// ✅ Good: Routes before error handler
app.get('/', (req, res) => {
    // Route
});
app.use((err, req, res, next) => {
    // Error handler
});
```

### 3. Not Parsing Body

```javascript
// ❌ Bad: Body not parsed
app.post('/users', (req, res) => {
    console.log(req.body); // undefined
});

// ✅ Good: Parse body
app.use(express.json());
app.post('/users', (req, res) => {
    console.log(req.body); // { name: 'Alice' }
});
```

---

## Key Takeaways

1. **Express**: Fast, minimalist web framework
2. **Routes**: Easy route definition
3. **Middleware**: Powerful middleware system
4. **Request/Response**: Simplified request/response handling
5. **Template Engines**: Support for various engines
6. **Best Practice**: Use middleware, handle errors, organize code
7. **Popular**: Industry standard for Node.js

---

## Quiz: Express

Test your understanding with these questions:

1. **Express is:**
   - A) Web framework
   - B) Database
   - C) Both
   - D) Neither

2. **app.get:**
   - A) GET route
   - B) POST route
   - C) Both
   - D) Neither

3. **Middleware:**
   - A) Uses next()
   - B) Doesn't use next()
   - C) Both
   - D) Neither

4. **req.params:**
   - A) Route parameters
   - B) Query parameters
   - C) Both
   - D) Neither

5. **req.query:**
   - A) Route parameters
   - B) Query parameters
   - C) Both
   - D) Neither

6. **Template engine:**
   - A) Renders views
   - B) Serves static files
   - C) Both
   - D) Neither

7. **Error handler:**
   - A) 4 parameters
   - B) 3 parameters
   - C) Both
   - D) Neither

**Answers**:
1. A) Web framework
2. A) GET route
3. A) Uses next()
4. A) Route parameters
5. B) Query parameters
6. A) Renders views
7. A) 4 parameters (err, req, res, next)

---

## Next Steps

Congratulations! You've learned Express.js framework. You now know:
- How to create Express applications
- How to work with routes and middleware
- How to handle requests
- How to use template engines

**What's Next?**
- Lesson 29.3: RESTful APIs with Express
- Learn REST principles
- Build REST APIs
- Handle API requests/responses

---

## Additional Resources

- **Express Documentation**: [expressjs.com](https://expressjs.com)
- **Express Guide**: [expressjs.com/en/guide/routing.html](https://expressjs.com/en/guide/routing.html)
- **Middleware**: [expressjs.com/en/guide/using-middleware.html](https://expressjs.com/en/guide/using-middleware.html)

---

*Lesson completed! You're ready to move on to the next lesson.*

