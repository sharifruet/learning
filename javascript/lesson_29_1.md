# Lesson 29.1: HTTP Server with Node.js

## Learning Objectives

By the end of this lesson, you will be able to:
- Create HTTP servers with Node.js
- Handle HTTP requests
- Implement routing
- Work with request and response objects
- Build basic web servers
- Understand HTTP protocol
- Process different request types

---

## Introduction to HTTP Servers

HTTP servers listen for incoming HTTP requests and send responses. Node.js provides the `http` module to create servers.

### What is an HTTP Server?

- **Listens**: Waits for incoming requests
- **Processes**: Handles request data
- **Responds**: Sends response back
- **Stateless**: Each request is independent
- **Protocol**: Uses HTTP/HTTPS protocol

---

## Creating HTTP Server

### Basic Server

```javascript
const http = require('http');

// Create server
const server = http.createServer((req, res) => {
    res.writeHead(200, { 'Content-Type': 'text/plain' });
    res.end('Hello, World!');
});

// Listen on port
server.listen(3000, () => {
    console.log('Server running on http://localhost:3000');
});
```

### Server with Options

```javascript
const http = require('http');

const server = http.createServer((req, res) => {
    res.writeHead(200, { 'Content-Type': 'text/plain' });
    res.end('Hello, World!');
});

server.listen(3000, 'localhost', () => {
    console.log('Server running on http://localhost:3000');
});

// Or specify host
server.listen(3000, '0.0.0.0', () => {
    console.log('Server running on all interfaces');
});
```

### Server Class

```javascript
const http = require('http');

const server = http.createServer();

// Handle request event
server.on('request', (req, res) => {
    res.writeHead(200, { 'Content-Type': 'text/plain' });
    res.end('Hello, World!');
});

// Handle connection event
server.on('connection', (socket) => {
    console.log('New connection');
});

server.listen(3000, () => {
    console.log('Server running on port 3000');
});
```

---

## Handling Requests

### Request Object

```javascript
const http = require('http');

const server = http.createServer((req, res) => {
    // Request method
    console.log('Method:', req.method);
    
    // Request URL
    console.log('URL:', req.url);
    
    // Request headers
    console.log('Headers:', req.headers);
    
    // Request body (for POST, PUT, etc.)
    let body = '';
    req.on('data', (chunk) => {
        body += chunk.toString();
    });
    
    req.on('end', () => {
        console.log('Body:', body);
        
        res.writeHead(200, { 'Content-Type': 'text/plain' });
        res.end('Request received');
    });
});

server.listen(3000);
```

### Response Object

```javascript
const http = require('http');

const server = http.createServer((req, res) => {
    // Set status code
    res.statusCode = 200;
    
    // Set headers
    res.setHeader('Content-Type', 'text/html');
    res.setHeader('X-Custom-Header', 'my-value');
    
    // Write response
    res.write('<h1>Hello, World!</h1>');
    res.write('<p>This is a response</p>');
    
    // End response
    res.end();
});

server.listen(3000);
```

### Different Response Types

```javascript
const http = require('http');

const server = http.createServer((req, res) => {
    // JSON response
    if (req.url === '/api/data') {
        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Hello', data: [1, 2, 3] }));
        return;
    }
    
    // HTML response
    if (req.url === '/') {
        res.writeHead(200, { 'Content-Type': 'text/html' });
        res.end('<h1>Home Page</h1>');
        return;
    }
    
    // Plain text response
    res.writeHead(200, { 'Content-Type': 'text/plain' });
    res.end('Default response');
});

server.listen(3000);
```

---

## Routing

### Basic Routing

```javascript
const http = require('http');
const url = require('url');

const server = http.createServer((req, res) => {
    const parsedUrl = url.parse(req.url, true);
    const path = parsedUrl.pathname;
    
    // Route handling
    if (path === '/') {
        res.writeHead(200, { 'Content-Type': 'text/html' });
        res.end('<h1>Home Page</h1>');
    } else if (path === '/about') {
        res.writeHead(200, { 'Content-Type': 'text/html' });
        res.end('<h1>About Page</h1>');
    } else if (path === '/contact') {
        res.writeHead(200, { 'Content-Type': 'text/html' });
        res.end('<h1>Contact Page</h1>');
    } else {
        res.writeHead(404, { 'Content-Type': 'text/html' });
        res.end('<h1>404 - Page Not Found</h1>');
    }
});

server.listen(3000);
```

### Method-Based Routing

```javascript
const http = require('http');
const url = require('url');

const server = http.createServer((req, res) => {
    const parsedUrl = url.parse(req.url, true);
    const path = parsedUrl.pathname;
    const method = req.method;
    
    // GET requests
    if (method === 'GET') {
        if (path === '/users') {
            res.writeHead(200, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify([{ id: 1, name: 'Alice' }]));
        } else if (path.startsWith('/users/')) {
            const userId = path.split('/')[2];
            res.writeHead(200, { 'Content-Type': 'application/json' });
            res.end(JSON.stringify({ id: userId, name: 'Alice' }));
        }
    }
    
    // POST requests
    else if (method === 'POST') {
        if (path === '/users') {
            let body = '';
            req.on('data', (chunk) => {
                body += chunk.toString();
            });
            
            req.on('end', () => {
                const user = JSON.parse(body);
                res.writeHead(201, { 'Content-Type': 'application/json' });
                res.end(JSON.stringify({ id: Date.now(), ...user }));
            });
        }
    }
    
    // PUT requests
    else if (method === 'PUT') {
        if (path.startsWith('/users/')) {
            const userId = path.split('/')[2];
            let body = '';
            req.on('data', (chunk) => {
                body += chunk.toString();
            });
            
            req.on('end', () => {
                const user = JSON.parse(body);
                res.writeHead(200, { 'Content-Type': 'application/json' });
                res.end(JSON.stringify({ id: userId, ...user }));
            });
        }
    }
    
    // DELETE requests
    else if (method === 'DELETE') {
        if (path.startsWith('/users/')) {
            const userId = path.split('/')[2];
            res.writeHead(204);
            res.end();
        }
    }
    
    // 404 for other routes
    else {
        res.writeHead(404, { 'Content-Type': 'text/plain' });
        res.end('Not Found');
    }
});

server.listen(3000);
```

### Router Helper

```javascript
const http = require('http');
const url = require('url');

// Simple router
class Router {
    constructor() {
        this.routes = {};
    }
    
    get(path, handler) {
        if (!this.routes[path]) {
            this.routes[path] = {};
        }
        this.routes[path].GET = handler;
    }
    
    post(path, handler) {
        if (!this.routes[path]) {
            this.routes[path] = {};
        }
        this.routes[path].POST = handler;
    }
    
    handle(req, res) {
        const parsedUrl = url.parse(req.url, true);
        const path = parsedUrl.pathname;
        const method = req.method;
        
        const route = this.routes[path];
        if (route && route[method]) {
            route[method](req, res);
        } else {
            res.writeHead(404, { 'Content-Type': 'text/plain' });
            res.end('Not Found');
        }
    }
}

// Use router
const router = new Router();

router.get('/', (req, res) => {
    res.writeHead(200, { 'Content-Type': 'text/html' });
    res.end('<h1>Home</h1>');
});

router.get('/about', (req, res) => {
    res.writeHead(200, { 'Content-Type': 'text/html' });
    res.end('<h1>About</h1>');
});

router.post('/users', (req, res) => {
    let body = '';
    req.on('data', (chunk) => {
        body += chunk.toString();
    });
    
    req.on('end', () => {
        res.writeHead(201, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'User created' }));
    });
});

const server = http.createServer((req, res) => {
    router.handle(req, res);
});

server.listen(3000);
```

---

## Request and Response Objects

### Request Object Properties

```javascript
const http = require('http');

const server = http.createServer((req, res) => {
    // Method
    console.log('Method:', req.method);
    
    // URL
    console.log('URL:', req.url);
    
    // Headers
    console.log('Headers:', req.headers);
    console.log('User-Agent:', req.headers['user-agent']);
    console.log('Content-Type:', req.headers['content-type']);
    
    // HTTP Version
    console.log('HTTP Version:', req.httpVersion);
    
    // Status Code (response)
    console.log('Status Code:', req.statusCode);
    
    // Socket
    console.log('Remote Address:', req.socket.remoteAddress);
    console.log('Remote Port:', req.socket.remotePort);
    
    res.end('Request logged');
});

server.listen(3000);
```

### Response Object Methods

```javascript
const http = require('http');

const server = http.createServer((req, res) => {
    // Set status code
    res.statusCode = 200;
    
    // Set status message
    res.statusMessage = 'OK';
    
    // Set header
    res.setHeader('Content-Type', 'text/html');
    res.setHeader('X-Custom-Header', 'value');
    
    // Set multiple headers
    res.writeHead(200, {
        'Content-Type': 'text/html',
        'X-Custom-Header': 'value'
    });
    
    // Write data
    res.write('<h1>Hello</h1>');
    res.write('<p>World</p>');
    
    // End response
    res.end();
    
    // Check if headers sent
    console.log('Headers sent:', res.headersSent);
    
    // Get header
    const contentType = res.getHeader('Content-Type');
    console.log('Content-Type:', contentType);
    
    // Remove header
    res.removeHeader('X-Custom-Header');
});
```

### Handling Request Body

```javascript
const http = require('http');

const server = http.createServer((req, res) => {
    // Only handle POST, PUT, PATCH
    if (['POST', 'PUT', 'PATCH'].includes(req.method)) {
        let body = '';
        
        req.on('data', (chunk) => {
            body += chunk.toString();
        });
        
        req.on('end', () => {
            try {
                // Parse JSON
                const data = JSON.parse(body);
                console.log('Received data:', data);
                
                res.writeHead(200, { 'Content-Type': 'application/json' });
                res.end(JSON.stringify({ success: true, data }));
            } catch (error) {
                res.writeHead(400, { 'Content-Type': 'application/json' });
                res.end(JSON.stringify({ error: 'Invalid JSON' }));
            }
        });
    } else {
        res.writeHead(200, { 'Content-Type': 'text/plain' });
        res.end('OK');
    }
});

server.listen(3000);
```

---

## Practice Exercise

### Exercise: Basic Server

**Objective**: Practice creating HTTP servers, handling requests, implementing routing, and working with request/response objects.

**Instructions**:

1. Create an HTTP server
2. Implement routing
3. Handle different request methods
4. Practice:
   - Creating servers
   - Handling requests
   - Implementing routing
   - Working with request/response objects

**Example Solution**:

```javascript
// src/server.js
const http = require('http');
const url = require('url');

// Simple in-memory data store
let users = [
    { id: 1, name: 'Alice', email: 'alice@example.com' },
    { id: 2, name: 'Bob', email: 'bob@example.com' }
];

// Helper function to parse request body
function parseBody(req) {
    return new Promise((resolve, reject) => {
        let body = '';
        req.on('data', (chunk) => {
            body += chunk.toString();
        });
        req.on('end', () => {
            try {
                resolve(body ? JSON.parse(body) : {});
            } catch (error) {
                reject(error);
            }
        });
        req.on('error', reject);
    });
}

// Helper function to send JSON response
function sendJSON(res, statusCode, data) {
    res.writeHead(statusCode, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify(data));
}

// Create server
const server = http.createServer(async (req, res) => {
    const parsedUrl = url.parse(req.url, true);
    const path = parsedUrl.pathname;
    const method = req.method;
    const query = parsedUrl.query;
    
    // CORS headers
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    res.setHeader('Access-Control-Allow-Headers', 'Content-Type');
    
    // Handle OPTIONS (preflight)
    if (method === 'OPTIONS') {
        res.writeHead(200);
        res.end();
        return;
    }
    
    // Route: GET /
    if (path === '/' && method === 'GET') {
        res.writeHead(200, { 'Content-Type': 'text/html' });
        res.end(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Node.js HTTP Server</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    h1 { color: #333; }
                    .endpoint { background: #f5f5f5; padding: 10px; margin: 10px 0; border-radius: 5px; }
                </style>
            </head>
            <body>
                <h1>Node.js HTTP Server</h1>
                <p>Welcome to the HTTP server!</p>
                <h2>Available Endpoints:</h2>
                <div class="endpoint">
                    <strong>GET /users</strong> - Get all users
                </div>
                <div class="endpoint">
                    <strong>GET /users/:id</strong> - Get user by ID
                </div>
                <div class="endpoint">
                    <strong>POST /users</strong> - Create new user
                </div>
                <div class="endpoint">
                    <strong>PUT /users/:id</strong> - Update user
                </div>
                <div class="endpoint">
                    <strong>DELETE /users/:id</strong> - Delete user
                </div>
            </body>
            </html>
        `);
        return;
    }
    
    // Route: GET /users
    if (path === '/users' && method === 'GET') {
        sendJSON(res, 200, users);
        return;
    }
    
    // Route: GET /users/:id
    if (path.startsWith('/users/') && method === 'GET') {
        const userId = parseInt(path.split('/')[2]);
        const user = users.find(u => u.id === userId);
        
        if (user) {
            sendJSON(res, 200, user);
        } else {
            sendJSON(res, 404, { error: 'User not found' });
        }
        return;
    }
    
    // Route: POST /users
    if (path === '/users' && method === 'POST') {
        try {
            const body = await parseBody(req);
            
            if (!body.name || !body.email) {
                sendJSON(res, 400, { error: 'Name and email are required' });
                return;
            }
            
            const newUser = {
                id: users.length > 0 ? Math.max(...users.map(u => u.id)) + 1 : 1,
                name: body.name,
                email: body.email
            };
            
            users.push(newUser);
            sendJSON(res, 201, newUser);
        } catch (error) {
            sendJSON(res, 400, { error: 'Invalid JSON' });
        }
        return;
    }
    
    // Route: PUT /users/:id
    if (path.startsWith('/users/') && method === 'PUT') {
        try {
            const userId = parseInt(path.split('/')[2]);
            const userIndex = users.findIndex(u => u.id === userId);
            
            if (userIndex === -1) {
                sendJSON(res, 404, { error: 'User not found' });
                return;
            }
            
            const body = await parseBody(req);
            users[userIndex] = { ...users[userIndex], ...body };
            
            sendJSON(res, 200, users[userIndex]);
        } catch (error) {
            sendJSON(res, 400, { error: 'Invalid JSON' });
        }
        return;
    }
    
    // Route: DELETE /users/:id
    if (path.startsWith('/users/') && method === 'DELETE') {
        const userId = parseInt(path.split('/')[2]);
        const userIndex = users.findIndex(u => u.id === userId);
        
        if (userIndex === -1) {
            sendJSON(res, 404, { error: 'User not found' });
            return;
        }
        
        users.splice(userIndex, 1);
        res.writeHead(204);
        res.end();
        return;
    }
    
    // 404 - Not Found
    sendJSON(res, 404, { error: 'Route not found' });
});

// Start server
const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
    console.log(`Visit http://localhost:${PORT} in your browser`);
});
```

```json
// package.json
{
  "name": "http-server-practice",
  "version": "1.0.0",
  "description": "HTTP server practice with Node.js",
  "main": "src/server.js",
  "scripts": {
    "start": "node src/server.js",
    "dev": "node --watch src/server.js"
  },
  "keywords": ["nodejs", "http", "server"],
  "author": "",
  "license": "ISC"
}
```

**Testing the Server**:

```bash
# Start server
node src/server.js

# Test endpoints (in another terminal or browser)
# GET /users
curl http://localhost:3000/users

# GET /users/1
curl http://localhost:3000/users/1

# POST /users
curl -X POST http://localhost:3000/users \
  -H "Content-Type: application/json" \
  -d '{"name":"Charlie","email":"charlie@example.com"}'

# PUT /users/1
curl -X PUT http://localhost:3000/users/1 \
  -H "Content-Type: application/json" \
  -d '{"name":"Alice Updated","email":"alice.updated@example.com"}'

# DELETE /users/1
curl -X DELETE http://localhost:3000/users/1
```

**Expected Output**:
- Server running on port 3000
- HTML page at root
- RESTful API endpoints working
- CRUD operations functional

**Challenge (Optional)**:
- Add more routes
- Implement authentication
- Add request validation
- Create a complete API

---

## Common Mistakes

### 1. Not Ending Response

```javascript
// ❌ Bad: Response never ends
res.writeHead(200);
res.write('Hello');

// ✅ Good: Always end response
res.writeHead(200);
res.end('Hello');
```

### 2. Writing After End

```javascript
// ❌ Bad: Write after end
res.end('Hello');
res.write('World');  // Error

// ✅ Good: Write before end
res.write('Hello');
res.end('World');
```

### 3. Not Handling Errors

```javascript
// ❌ Bad: No error handling
const data = JSON.parse(body);

// ✅ Good: Handle errors
try {
    const data = JSON.parse(body);
} catch (error) {
    res.writeHead(400);
    res.end('Invalid JSON');
}
```

---

## Key Takeaways

1. **HTTP Server**: Created with http.createServer()
2. **Request Object**: Contains method, URL, headers, body
3. **Response Object**: Used to send responses
4. **Routing**: Handle different paths and methods
5. **Status Codes**: Use appropriate HTTP status codes
6. **Best Practice**: Always end response, handle errors
7. **Protocol**: Understand HTTP methods and status codes

---

## Quiz: HTTP Server

Test your understanding with these questions:

1. **http.createServer:**
   - A) Creates server
   - B) Starts server
   - C) Both
   - D) Neither

2. **server.listen:**
   - A) Creates server
   - B) Starts server
   - C) Both
   - D) Neither

3. **req.method:**
   - A) Request method
   - B) Response method
   - C) Both
   - D) Neither

4. **res.end:**
   - A) Required
   - B) Optional
   - C) Both
   - D) Neither

5. **Status code 200:**
   - A) Success
   - B) Error
   - C) Both
   - D) Neither

6. **Status code 404:**
   - A) Not found
   - B) Found
   - C) Both
   - D) Neither

7. **Request body:**
   - A) Stream
   - B) String
   - C) Both
   - D) Neither

**Answers**:
1. A) Creates server
2. B) Starts server
3. A) Request method
4. A) Required
5. A) Success
6. A) Not found
7. A) Stream (needs to be read)

---

## Next Steps

Congratulations! You've learned HTTP server with Node.js. You now know:
- How to create HTTP servers
- How to handle requests
- How to implement routing
- How to work with request/response objects

**What's Next?**
- Lesson 29.2: Express.js Framework
- Learn Express.js
- Understand routes and middleware
- Build web applications

---

## Additional Resources

- **HTTP Module**: [nodejs.org/api/http.html](https://nodejs.org/api/http.html)
- **HTTP Status Codes**: [developer.mozilla.org/en-US/docs/Web/HTTP/Status](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status)
- **HTTP Methods**: [developer.mozilla.org/en-US/docs/Web/HTTP/Methods](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods)

---

*Lesson completed! You're ready to move on to the next lesson.*

