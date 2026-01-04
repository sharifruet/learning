# Lesson 12.2: Axios and HTTP Libraries

## Learning Objectives

By the end of this lesson, you will be able to:
- Install and use Axios
- Compare Axios with Fetch API
- Use request and response interceptors
- Handle errors with Axios
- Configure Axios instances
- Work with other HTTP libraries
- Choose the right HTTP client for your project

---

## Introduction to Axios

Axios is a popular HTTP client library for JavaScript. It provides a simple API and additional features compared to the native Fetch API.

### Why Axios?

- **Promise-based**: Works with async/await
- **Automatic JSON**: Automatically parses JSON
- **Interceptors**: Request/response interceptors
- **Error Handling**: Better error handling
- **Request Cancellation**: Cancel requests
- **Browser & Node.js**: Works in both environments

---

## Installing Axios

### npm Installation

```bash
npm install axios
```

### CDN (Browser)

```html
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
```

### Import Axios

```javascript
// ES6 Modules
import axios from 'axios';

// CommonJS
const axios = require('axios');
```

---

## Basic Axios Usage

### GET Request

```javascript
// Simple GET
axios.get('https://api.example.com/users')
    .then(response => {
        console.log(response.data);
    })
    .catch(error => {
        console.error('Error:', error);
    });

// With async/await
async function getUsers() {
    try {
        const response = await axios.get('https://api.example.com/users');
        console.log(response.data);
        return response.data;
    } catch (error) {
        console.error('Error:', error);
        throw error;
    }
}
```

### POST Request

```javascript
// POST request
axios.post('https://api.example.com/users', {
    name: 'Alice',
    email: 'alice@example.com'
})
    .then(response => {
        console.log('Created:', response.data);
    })
    .catch(error => {
        console.error('Error:', error);
    });

// With async/await
async function createUser(userData) {
    try {
        const response = await axios.post('https://api.example.com/users', userData);
        return response.data;
    } catch (error) {
        console.error('Error creating user:', error);
        throw error;
    }
}
```

### PUT Request

```javascript
async function updateUser(userId, userData) {
    try {
        const response = await axios.put(`https://api.example.com/users/${userId}`, userData);
        return response.data;
    } catch (error) {
        console.error('Error updating user:', error);
        throw error;
    }
}
```

### DELETE Request

```javascript
async function deleteUser(userId) {
    try {
        const response = await axios.delete(`https://api.example.com/users/${userId}`);
        return response.data;
    } catch (error) {
        console.error('Error deleting user:', error);
        throw error;
    }
}
```

---

## Axios vs Fetch

### Comparison Table

| Feature | Fetch | Axios |
|---------|-------|-------|
| **JSON Parsing** | Manual (response.json()) | Automatic |
| **Request Cancellation** | AbortController | Built-in |
| **Interceptors** | No | Yes |
| **Error Handling** | Manual check | Automatic |
| **Browser Support** | Modern browsers | All browsers |
| **Bundle Size** | Built-in (0KB) | ~13KB |
| **Request Timeout** | Manual | Built-in |
| **Response Timeout** | No | Yes |

### Code Comparison

**Fetch:**
```javascript
fetch('https://api.example.com/users', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({ name: 'Alice' })
})
    .then(response => {
        if (!response.ok) {
            throw new Error('HTTP error');
        }
        return response.json();
    })
    .then(data => console.log(data))
    .catch(error => console.error(error));
```

**Axios:**
```javascript
axios.post('https://api.example.com/users', { name: 'Alice' })
    .then(response => console.log(response.data))
    .catch(error => console.error(error));
```

---

## Request Configuration

### Config Object

```javascript
axios({
    method: 'POST',
    url: 'https://api.example.com/users',
    data: {
        name: 'Alice',
        email: 'alice@example.com'
    },
    headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer token123'
    },
    timeout: 5000,
    params: {
        page: 1,
        limit: 10
    }
});
```

### Common Config Options

```javascript
axios.get('https://api.example.com/users', {
    params: {
        page: 1,
        limit: 10
    },
    headers: {
        'Authorization': 'Bearer token123'
    },
    timeout: 5000,
    responseType: 'json'  // json, text, blob, arraybuffer
});
```

---

## Response Object

### Response Structure

```javascript
const response = await axios.get('https://api.example.com/users');

console.log(response.data);      // Response body (parsed)
console.log(response.status);     // HTTP status code
console.log(response.statusText); // HTTP status text
console.log(response.headers);   // Response headers
console.log(response.config);    // Request config
```

### Accessing Data

```javascript
// Axios automatically parses JSON
const response = await axios.get('https://api.example.com/users');
const users = response.data;  // Already parsed JSON

// For other types
const response = await axios.get('https://api.example.com/image.png', {
    responseType: 'blob'
});
const image = response.data;  // Blob object
```

---

## Error Handling

### Basic Error Handling

```javascript
try {
    const response = await axios.get('https://api.example.com/users');
    console.log(response.data);
} catch (error) {
    if (error.response) {
        // Server responded with error status
        console.error('Status:', error.response.status);
        console.error('Data:', error.response.data);
    } else if (error.request) {
        // Request made but no response
        console.error('No response:', error.request);
    } else {
        // Error setting up request
        console.error('Error:', error.message);
    }
}
```

### Error Object Structure

```javascript
catch (error) {
    console.log(error.message);        // Error message
    console.log(error.response);       // Response object (if received)
    console.log(error.response.status); // HTTP status
    console.log(error.response.data);   // Response data
    console.log(error.request);         // Request object
    console.log(error.config);          // Request config
}
```

### Handling Specific Status Codes

```javascript
try {
    const response = await axios.get('https://api.example.com/users');
} catch (error) {
    if (error.response) {
        switch (error.response.status) {
            case 404:
                console.error('Resource not found');
                break;
            case 401:
                console.error('Unauthorized');
                break;
            case 500:
                console.error('Server error');
                break;
            default:
                console.error('Error:', error.response.status);
        }
    }
}
```

---

## Interceptors

### Request Interceptor

```javascript
// Add token to all requests
axios.interceptors.request.use(
    config => {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    error => {
        return Promise.reject(error);
    }
);
```

### Response Interceptor

```javascript
// Handle responses globally
axios.interceptors.response.use(
    response => {
        // Modify response before returning
        return response;
    },
    error => {
        // Handle errors globally
        if (error.response?.status === 401) {
            // Redirect to login
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);
```

### Multiple Interceptors

```javascript
// Request interceptor 1
const requestInterceptor1 = axios.interceptors.request.use(config => {
    console.log('Request 1:', config.url);
    return config;
});

// Request interceptor 2
const requestInterceptor2 = axios.interceptors.request.use(config => {
    config.headers['X-Custom'] = 'value';
    return config;
});

// Remove interceptor
axios.interceptors.request.eject(requestInterceptor1);
```

---

## Axios Instances

### Creating an Instance

```javascript
const apiClient = axios.create({
    baseURL: 'https://api.example.com',
    timeout: 5000,
    headers: {
        'Content-Type': 'application/json'
    }
});

// Use instance
apiClient.get('/users')
    .then(response => console.log(response.data));
```

### Instance with Defaults

```javascript
const apiClient = axios.create({
    baseURL: 'https://api.example.com',
    timeout: 10000
});

// Add default header
apiClient.defaults.headers.common['Authorization'] = 'Bearer token123';

// Add interceptor to instance
apiClient.interceptors.request.use(config => {
    console.log('API Request:', config.url);
    return config;
});
```

---

## Request Cancellation

### Cancel Token (Axios < 0.22)

```javascript
const CancelToken = axios.CancelToken;
const source = CancelToken.source();

axios.get('https://api.example.com/users', {
    cancelToken: source.token
})
    .then(response => console.log(response.data))
    .catch(error => {
        if (axios.isCancel(error)) {
            console.log('Request cancelled');
        }
    });

// Cancel request
source.cancel('Operation cancelled');
```

### AbortController (Axios >= 0.22)

```javascript
const controller = new AbortController();

axios.get('https://api.example.com/users', {
    signal: controller.signal
})
    .then(response => console.log(response.data))
    .catch(error => {
        if (axios.isCancel(error)) {
            console.log('Request cancelled');
        }
    });

// Cancel request
controller.abort();
```

---

## Practical Examples

### Example 1: API Client Class

```javascript
class ApiClient {
    constructor(baseURL) {
        this.client = axios.create({
            baseURL,
            timeout: 10000,
            headers: {
                'Content-Type': 'application/json'
            }
        });
        
        this.setupInterceptors();
    }
    
    setupInterceptors() {
        // Request interceptor
        this.client.interceptors.request.use(
            config => {
                const token = localStorage.getItem('token');
                if (token) {
                    config.headers.Authorization = `Bearer ${token}`;
                }
                return config;
            },
            error => Promise.reject(error)
        );
        
        // Response interceptor
        this.client.interceptors.response.use(
            response => response,
            error => {
                if (error.response?.status === 401) {
                    localStorage.removeItem('token');
                    window.location.href = '/login';
                }
                return Promise.reject(error);
            }
        );
    }
    
    async get(url, config) {
        return this.client.get(url, config);
    }
    
    async post(url, data, config) {
        return this.client.post(url, data, config);
    }
    
    async put(url, data, config) {
        return this.client.put(url, data, config);
    }
    
    async delete(url, config) {
        return this.client.delete(url, config);
    }
}

// Usage
const api = new ApiClient('https://api.example.com');
const users = await api.get('/users');
```

### Example 2: Error Handling Utility

```javascript
function handleAxiosError(error) {
    if (error.response) {
        // Server responded with error
        const { status, data } = error.response;
        switch (status) {
            case 400:
                return { message: 'Bad request', details: data };
            case 401:
                return { message: 'Unauthorized', details: data };
            case 404:
                return { message: 'Not found', details: data };
            case 500:
                return { message: 'Server error', details: data };
            default:
                return { message: `HTTP error ${status}`, details: data };
        }
    } else if (error.request) {
        // Request made but no response
        return { message: 'No response from server', details: null };
    } else {
        // Error setting up request
        return { message: error.message, details: null };
    }
}

// Usage
try {
    await axios.get('https://api.example.com/users');
} catch (error) {
    const errorInfo = handleAxiosError(error);
    console.error(errorInfo);
}
```

---

## Practice Exercise

### Exercise: Axios Practice

**Objective**: Practice using Axios for HTTP requests.

**Instructions**:

1. Install Axios (or use CDN)
2. Create a file called `axios-practice.js`
3. Practice:
   - GET, POST, PUT, DELETE requests
   - Error handling
   - Interceptors
   - Creating instances
   - Request cancellation

**Example Solution**:

```javascript
// Axios Practice
// Note: Requires axios to be installed or loaded via CDN
const axios = require('axios'); // or import axios from 'axios';

const API_URL = 'https://jsonplaceholder.typicode.com';

console.log("=== Basic GET Request ===");

async function getUsers() {
    try {
        const response = await axios.get(`${API_URL}/users`);
        console.log(`Fetched ${response.data.length} users`);
        return response.data;
    } catch (error) {
        console.error('Error:', error.message);
        throw error;
    }
}

getUsers();
console.log();

console.log("=== GET with Params ===");

async function getUserPosts(userId) {
    try {
        const response = await axios.get(`${API_URL}/posts`, {
            params: {
                userId: userId
            }
        });
        console.log(`User ${userId} has ${response.data.length} posts`);
        return response.data;
    } catch (error) {
        console.error('Error:', error.message);
        throw error;
    }
}

getUserPosts(1);
console.log();

console.log("=== POST Request ===");

async function createPost(postData) {
    try {
        const response = await axios.post(`${API_URL}/posts`, postData);
        console.log('Created post:', response.data.id);
        return response.data;
    } catch (error) {
        console.error('Error creating post:', error.message);
        throw error;
    }
}

createPost({
    title: 'My New Post',
    body: 'This is the body',
    userId: 1
});
console.log();

console.log("=== PUT Request ===");

async function updatePost(postId, updates) {
    try {
        const response = await axios.put(`${API_URL}/posts/${postId}`, updates);
        console.log('Updated post:', response.data.id);
        return response.data;
    } catch (error) {
        console.error('Error updating post:', error.message);
        throw error;
    }
}

updatePost(1, {
    title: 'Updated Title',
    body: 'Updated body',
    userId: 1
});
console.log();

console.log("=== DELETE Request ===");

async function deletePost(postId) {
    try {
        const response = await axios.delete(`${API_URL}/posts/${postId}`);
        console.log(`Post ${postId} deleted`);
        return response.data;
    } catch (error) {
        console.error('Error deleting post:', error.message);
        throw error;
    }
}

deletePost(1);
console.log();

console.log("=== Error Handling ===");

async function handleErrors() {
    try {
        await axios.get(`${API_URL}/invalid-endpoint`);
    } catch (error) {
        if (error.response) {
            console.log('Status:', error.response.status);
            console.log('Data:', error.response.data);
        } else if (error.request) {
            console.log('No response received');
        } else {
            console.log('Error:', error.message);
        }
    }
}

handleErrors();
console.log();

console.log("=== Request Interceptor ===");

// Add token to all requests
axios.interceptors.request.use(
    config => {
        const token = 'mock-token-123';
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        console.log('Request interceptor:', config.url);
        return config;
    },
    error => {
        return Promise.reject(error);
    }
);

axios.get(`${API_URL}/users/1`)
    .then(response => {
        console.log('Request completed with interceptor');
    });
console.log();

console.log("=== Response Interceptor ===");

axios.interceptors.response.use(
    response => {
        console.log('Response interceptor:', response.status);
        return response;
    },
    error => {
        if (error.response?.status === 404) {
            console.log('404 error intercepted');
        }
        return Promise.reject(error);
    }
);

axios.get(`${API_URL}/users/1`)
    .then(response => {
        console.log('Response received');
    });
console.log();

console.log("=== Axios Instance ===");

const apiClient = axios.create({
    baseURL: API_URL,
    timeout: 5000,
    headers: {
        'Content-Type': 'application/json'
    }
});

// Use instance
apiClient.get('/users/1')
    .then(response => {
        console.log('Instance request successful');
    });
console.log();

console.log("=== Request Cancellation ===");

const controller = new AbortController();

setTimeout(() => {
    controller.abort();
    console.log('Request cancelled');
}, 100);

try {
    await axios.get(`${API_URL}/users`, {
        signal: controller.signal
    });
} catch (error) {
    if (axios.isCancel(error)) {
        console.log('Request was cancelled');
    } else {
        console.error('Error:', error.message);
    }
}
```

**Expected Output** (will vary):
```
=== Basic GET Request ===
Fetched 10 users

=== GET with Params ===
User 1 has 10 posts

=== POST Request ===
Created post: 101

=== PUT Request ===
Updated post: 1

=== DELETE Request ===
Post 1 deleted

=== Error Handling ===
Status: 404
Data: {}

=== Request Interceptor ===
Request interceptor: https://jsonplaceholder.typicode.com/users/1
Request completed with interceptor

=== Response Interceptor ===
Response interceptor: 200
Response received

=== Axios Instance ===
Instance request successful

=== Request Cancellation ===
Request cancelled
Request was cancelled
```

**Challenge (Optional)**:
- Build a complete API client with Axios
- Create reusable interceptors
- Implement retry logic
- Build error handling utilities

---

## Common Mistakes

### 1. Not Handling Errors

```javascript
// ⚠️ Problem: No error handling
const response = await axios.get(url);
console.log(response.data);

// ✅ Solution: Always handle errors
try {
    const response = await axios.get(url);
    console.log(response.data);
} catch (error) {
    console.error('Error:', error);
}
```

### 2. Accessing Wrong Property

```javascript
// ⚠️ Problem: Wrong property
const data = await axios.get(url);
console.log(data);  // Response object, not data

// ✅ Solution: Use response.data
const response = await axios.get(url);
console.log(response.data);  // Actual data
```

### 3. Not Using Interceptors Properly

```javascript
// ⚠️ Problem: Interceptor not returning config
axios.interceptors.request.use(config => {
    config.headers.Auth = 'token';
    // Missing return!
});

// ✅ Solution: Always return config
axios.interceptors.request.use(config => {
    config.headers.Auth = 'token';
    return config;
});
```

---

## Key Takeaways

1. **Axios**: Popular HTTP client library
2. **Automatic JSON**: Parses JSON automatically
3. **Interceptors**: Request/response interceptors
4. **Error Handling**: Better error handling than Fetch
5. **Instances**: Create configured instances
6. **Cancellation**: Cancel requests
7. **Best Practice**: Use interceptors for common logic
8. **When to Use**: When you need features beyond Fetch

---

## Quiz: HTTP Libraries

Test your understanding with these questions:

1. **Axios automatically:**
   - A) Parses JSON
   - B) Handles errors
   - C) Both A and B
   - D) Neither

2. **Interceptors are used for:**
   - A) Request modification
   - B) Response modification
   - C) Both A and B
   - D) Error handling only

3. **Axios instance is created with:**
   - A) axios.create()
   - B) new Axios()
   - C) axios.instance()
   - D) axios.new()

4. **Axios vs Fetch:**
   - A) Axios is built-in
   - B) Fetch needs more code
   - C) Both are same
   - D) Fetch is better

5. **Error.response contains:**
   - A) Status code
   - B) Response data
   - C) Both A and B
   - D) Request data

6. **Request cancellation uses:**
   - A) AbortController
   - B) CancelToken
   - C) Both (depending on version)
   - D) Neither

7. **Axios is:**
   - A) Only for browsers
   - B) Only for Node.js
   - C) Both browser and Node.js
   - D) Neither

**Answers**:
1. C) Both A and B
2. C) Both A and B
3. A) axios.create()
4. B) Fetch needs more code (Axios is simpler)
5. C) Both A and B
6. C) Both (depending on version)
7. C) Both browser and Node.js

---

## Next Steps

Congratulations! You've learned Axios. You now know:
- How to use Axios for HTTP requests
- How Axios compares to Fetch
- How to use interceptors
- How to handle errors with Axios

**What's Next?**
- Lesson 12.3: Working with JSON
- Learn JSON manipulation
- Practice API data handling
- Build complete API integrations

---

## Additional Resources

- **Axios Documentation**: [axios-http.com](https://axios-http.com/)
- **Axios GitHub**: [github.com/axios/axios](https://github.com/axios/axios)
- **Axios vs Fetch**: Comparison guides

---

*Lesson completed! You're ready to move on to the next lesson.*

