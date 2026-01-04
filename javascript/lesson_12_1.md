# Lesson 12.1: Fetch API

## Learning Objectives

By the end of this lesson, you will be able to:
- Make HTTP requests using the Fetch API
- Perform GET, POST, PUT, and DELETE requests
- Configure request options (headers, body, method)
- Handle responses and parse data
- Handle errors properly
- Work with async/await and Fetch
- Build API-integrated applications

---

## Introduction to Fetch API

The Fetch API provides a modern, promise-based way to make HTTP requests. It's built into modern browsers and is the standard for making network requests in JavaScript.

### Why Fetch API?

- **Promise-based**: Works with async/await
- **Modern**: Built into browsers
- **Flexible**: Supports all HTTP methods
- **Streaming**: Can handle streaming responses
- **Standard**: Replaces older XMLHttpRequest

---

## Basic Fetch Request

### Simple GET Request

```javascript
fetch('https://api.example.com/users')
    .then(response => response.json())
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
```

### Fetch with async/await

```javascript
async function fetchUsers() {
    try {
        const response = await fetch('https://api.example.com/users');
        const data = await response.json();
        console.log(data);
    } catch (error) {
        console.error('Error:', error);
    }
}

fetchUsers();
```

---

## HTTP Methods

### GET Request

```javascript
// Simple GET
fetch('https://api.example.com/users')
    .then(response => response.json())
    .then(data => console.log(data));

// GET with async/await
async function getUsers() {
    const response = await fetch('https://api.example.com/users');
    const data = await response.json();
    return data;
}
```

### POST Request

```javascript
// POST with JSON body
fetch('https://api.example.com/users', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        name: 'Alice',
        email: 'alice@example.com'
    })
})
    .then(response => response.json())
    .then(data => console.log('Created:', data));

// POST with async/await
async function createUser(userData) {
    const response = await fetch('https://api.example.com/users', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(userData)
    });
    return await response.json();
}
```

### PUT Request

```javascript
// PUT to update resource
async function updateUser(userId, userData) {
    const response = await fetch(`https://api.example.com/users/${userId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(userData)
    });
    return await response.json();
}
```

### DELETE Request

```javascript
// DELETE to remove resource
async function deleteUser(userId) {
    const response = await fetch(`https://api.example.com/users/${userId}`, {
        method: 'DELETE'
    });
    return await response.json();
}
```

---

## Request Options

### Headers

```javascript
fetch('https://api.example.com/data', {
    headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer token123',
        'X-Custom-Header': 'value'
    }
});
```

### Request Body

```javascript
// JSON body
fetch('https://api.example.com/users', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        name: 'Alice',
        age: 25
    })
});

// Form data
const formData = new FormData();
formData.append('name', 'Alice');
formData.append('age', '25');

fetch('https://api.example.com/users', {
    method: 'POST',
    body: formData
});
```

### Complete Request Options

```javascript
fetch('https://api.example.com/users', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer token123'
    },
    body: JSON.stringify({
        name: 'Alice',
        email: 'alice@example.com'
    }),
    mode: 'cors',           // cors, no-cors, same-origin
    cache: 'no-cache',      // default, no-cache, reload, force-cache
    credentials: 'include', // include, same-origin, omit
    redirect: 'follow'      // follow, error, manual
});
```

---

## Response Handling

### Checking Response Status

```javascript
async function fetchData() {
    const response = await fetch('https://api.example.com/data');
    
    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }
    
    const data = await response.json();
    return data;
}
```

### Response Methods

```javascript
async function handleResponse() {
    const response = await fetch('https://api.example.com/data');
    
    // JSON
    const jsonData = await response.json();
    
    // Text
    const textData = await response.text();
    
    // Blob
    const blobData = await response.blob();
    
    // ArrayBuffer
    const bufferData = await response.arrayBuffer();
    
    // FormData
    const formData = await response.formData();
}
```

### Response Properties

```javascript
async function checkResponse() {
    const response = await fetch('https://api.example.com/data');
    
    console.log(response.status);      // 200
    console.log(response.statusText);   // "OK"
    console.log(response.ok);          // true
    console.log(response.headers);     // Headers object
    console.log(response.url);         // Request URL
    console.log(response.type);        // "cors", "basic", etc.
}
```

---

## Error Handling

### Basic Error Handling

```javascript
async function fetchWithErrorHandling() {
    try {
        const response = await fetch('https://api.example.com/data');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Fetch error:', error);
        throw error;
    }
}
```

### Handling Different Error Types

```javascript
async function robustFetch(url) {
    try {
        const response = await fetch(url);
        
        // Check for HTTP errors
        if (!response.ok) {
            if (response.status === 404) {
                throw new Error('Resource not found');
            } else if (response.status === 500) {
                throw new Error('Server error');
            } else {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
        }
        
        // Parse JSON
        const data = await response.json();
        return data;
    } catch (error) {
        // Handle network errors
        if (error instanceof TypeError) {
            console.error('Network error:', error.message);
        } else {
            console.error('Error:', error.message);
        }
        throw error;
    }
}
```

---

## Practical Examples

### Example 1: Fetching User Data

```javascript
async function getUser(userId) {
    try {
        const response = await fetch(`https://api.example.com/users/${userId}`);
        
        if (!response.ok) {
            throw new Error(`Failed to fetch user: ${response.status}`);
        }
        
        const user = await response.json();
        return user;
    } catch (error) {
        console.error('Error fetching user:', error);
        throw error;
    }
}

// Usage
getUser(1)
    .then(user => console.log('User:', user))
    .catch(error => console.error('Error:', error));
```

### Example 2: Creating a Resource

```javascript
async function createUser(userData) {
    try {
        const response = await fetch('https://api.example.com/users', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(userData)
        });
        
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Failed to create user');
        }
        
        const newUser = await response.json();
        return newUser;
    } catch (error) {
        console.error('Error creating user:', error);
        throw error;
    }
}

// Usage
createUser({ name: 'Alice', email: 'alice@example.com' })
    .then(user => console.log('Created:', user))
    .catch(error => console.error('Error:', error));
```

### Example 3: Updating a Resource

```javascript
async function updateUser(userId, updates) {
    try {
        const response = await fetch(`https://api.example.com/users/${userId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(updates)
        });
        
        if (!response.ok) {
            throw new Error(`Failed to update user: ${response.status}`);
        }
        
        const updatedUser = await response.json();
        return updatedUser;
    } catch (error) {
        console.error('Error updating user:', error);
        throw error;
    }
}
```

### Example 4: Deleting a Resource

```javascript
async function deleteUser(userId) {
    try {
        const response = await fetch(`https://api.example.com/users/${userId}`, {
            method: 'DELETE'
        });
        
        if (!response.ok) {
            throw new Error(`Failed to delete user: ${response.status}`);
        }
        
        // Some APIs return data, others return empty
        if (response.status === 204) {
            return { success: true };
        }
        
        return await response.json();
    } catch (error) {
        console.error('Error deleting user:', error);
        throw error;
    }
}
```

### Example 5: Fetching Multiple Resources

```javascript
async function fetchMultipleUsers(userIds) {
    try {
        const promises = userIds.map(id =>
            fetch(`https://api.example.com/users/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Failed to fetch user ${id}`);
                    }
                    return response.json();
                })
        );
        
        const users = await Promise.all(promises);
        return users;
    } catch (error) {
        console.error('Error fetching users:', error);
        throw error;
    }
}

// Usage
fetchMultipleUsers([1, 2, 3])
    .then(users => console.log('Users:', users))
    .catch(error => console.error('Error:', error));
```

---

## Practice Exercise

### Exercise: Fetch API Practice

**Objective**: Practice making HTTP requests with the Fetch API.

**Instructions**:

1. Create a file called `fetch-practice.js`

2. Practice:
   - GET requests
   - POST requests
   - PUT requests
   - DELETE requests
   - Error handling
   - Response handling
   - Multiple requests

3. Use a mock API or JSONPlaceholder (https://jsonplaceholder.typicode.com)

**Example Solution**:

```javascript
// Fetch API Practice
const API_URL = 'https://jsonplaceholder.typicode.com';

console.log("=== GET Request ===");

async function getUsers() {
    try {
        const response = await fetch(`${API_URL}/users`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const users = await response.json();
        console.log('Users:', users);
        return users;
    } catch (error) {
        console.error('Error fetching users:', error);
        throw error;
    }
}

getUsers().then(users => {
    console.log(`Fetched ${users.length} users`);
});
console.log();

console.log("=== GET Single User ===");

async function getUser(userId) {
    try {
        const response = await fetch(`${API_URL}/users/${userId}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const user = await response.json();
        console.log('User:', user);
        return user;
    } catch (error) {
        console.error('Error fetching user:', error);
        throw error;
    }
}

getUser(1).then(user => {
    console.log(`User name: ${user.name}`);
});
console.log();

console.log("=== POST Request ===");

async function createPost(postData) {
    try {
        const response = await fetch(`${API_URL}/posts`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(postData)
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const newPost = await response.json();
        console.log('Created post:', newPost);
        return newPost;
    } catch (error) {
        console.error('Error creating post:', error);
        throw error;
    }
}

createPost({
    title: 'My New Post',
    body: 'This is the body of my post',
    userId: 1
}).then(post => {
    console.log(`Post created with ID: ${post.id}`);
});
console.log();

console.log("=== PUT Request ===");

async function updatePost(postId, updates) {
    try {
        const response = await fetch(`${API_URL}/posts/${postId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(updates)
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const updatedPost = await response.json();
        console.log('Updated post:', updatedPost);
        return updatedPost;
    } catch (error) {
        console.error('Error updating post:', error);
        throw error;
    }
}

updatePost(1, {
    title: 'Updated Title',
    body: 'Updated body',
    userId: 1
}).then(post => {
    console.log(`Post ${post.id} updated`);
});
console.log();

console.log("=== DELETE Request ===");

async function deletePost(postId) {
    try {
        const response = await fetch(`${API_URL}/posts/${postId}`, {
            method: 'DELETE'
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        console.log(`Post ${postId} deleted`);
        return { success: true };
    } catch (error) {
        console.error('Error deleting post:', error);
        throw error;
    }
}

deletePost(1).then(result => {
    console.log('Delete result:', result);
});
console.log();

console.log("=== Error Handling ===");

async function fetchWithErrorHandling(url) {
    try {
        const response = await fetch(url);
        
        if (!response.ok) {
            if (response.status === 404) {
                throw new Error('Resource not found');
            } else if (response.status >= 500) {
                throw new Error('Server error');
            } else {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
        }
        
        const data = await response.json();
        return data;
    } catch (error) {
        if (error instanceof TypeError) {
            console.error('Network error:', error.message);
        } else {
            console.error('Error:', error.message);
        }
        throw error;
    }
}

// Test with invalid URL
fetchWithErrorHandling(`${API_URL}/invalid`)
    .catch(error => {
        console.log('Caught error:', error.message);
    });
console.log();

console.log("=== Multiple Requests ===");

async function fetchUserPosts(userId) {
    try {
        // Fetch user and posts in parallel
        const [userResponse, postsResponse] = await Promise.all([
            fetch(`${API_URL}/users/${userId}`),
            fetch(`${API_URL}/users/${userId}/posts`)
        ]);
        
        if (!userResponse.ok || !postsResponse.ok) {
            throw new Error('Failed to fetch data');
        }
        
        const [user, posts] = await Promise.all([
            userResponse.json(),
            postsResponse.json()
        ]);
        
        console.log(`User: ${user.name}`);
        console.log(`Posts: ${posts.length}`);
        return { user, posts };
    } catch (error) {
        console.error('Error:', error);
        throw error;
    }
}

fetchUserPosts(1).then(data => {
    console.log('User data:', data);
});
console.log();

console.log("=== Response Headers ===");

async function checkHeaders() {
    try {
        const response = await fetch(`${API_URL}/users/1`);
        
        console.log('Status:', response.status);
        console.log('Status Text:', response.statusText);
        console.log('OK:', response.ok);
        console.log('Content-Type:', response.headers.get('Content-Type'));
        console.log('URL:', response.url);
    } catch (error) {
        console.error('Error:', error);
    }
}

checkHeaders();
```

**Expected Output** (will vary based on API response):
```
=== GET Request ===
Users: [array of users]
Fetched 10 users

=== GET Single User ===
User: { id: 1, name: "Leanne Graham", ... }
User name: Leanne Graham

=== POST Request ===
Created post: { id: 101, title: "My New Post", ... }
Post created with ID: 101

=== PUT Request ===
Updated post: { id: 1, title: "Updated Title", ... }
Post 1 updated

=== DELETE Request ===
Post 1 deleted
Delete result: { success: true }

=== Error Handling ===
Error: Resource not found
Caught error: Resource not found

=== Multiple Requests ===
User: Leanne Graham
Posts: 10
User data: { user: {...}, posts: [...] }

=== Response Headers ===
Status: 200
Status Text: OK
OK: true
Content-Type: application/json; charset=utf-8
URL: https://jsonplaceholder.typicode.com/users/1
```

**Challenge (Optional)**:
- Build a complete CRUD application with Fetch
- Create a reusable API client
- Implement retry logic
- Add request timeout handling

---

## Common Mistakes

### 1. Not Checking response.ok

```javascript
// ⚠️ Problem: Doesn't check for HTTP errors
const response = await fetch(url);
const data = await response.json();  // May fail if response is error

// ✅ Solution: Always check response.ok
const response = await fetch(url);
if (!response.ok) {
    throw new Error(`HTTP error! status: ${response.status}`);
}
const data = await response.json();
```

### 2. Forgetting to Parse JSON

```javascript
// ⚠️ Problem: Response is not parsed
const response = await fetch(url);
console.log(response);  // Response object, not data

// ✅ Solution: Parse response
const response = await fetch(url);
const data = await response.json();
console.log(data);  // Actual data
```

### 3. Not Handling Errors

```javascript
// ⚠️ Problem: No error handling
const data = await fetch(url).then(r => r.json());

// ✅ Solution: Always handle errors
try {
    const response = await fetch(url);
    if (!response.ok) throw new Error('HTTP error');
    const data = await response.json();
} catch (error) {
    console.error('Error:', error);
}
```

### 4. Missing Headers for POST/PUT

```javascript
// ⚠️ Problem: Missing Content-Type header
fetch(url, {
    method: 'POST',
    body: JSON.stringify(data)  // Server may not parse correctly
});

// ✅ Solution: Include Content-Type
fetch(url, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
});
```

---

## Key Takeaways

1. **Fetch API**: Modern, promise-based HTTP client
2. **HTTP Methods**: GET, POST, PUT, DELETE
3. **Request Options**: Headers, body, method, etc.
4. **Response Handling**: Check status, parse data
5. **Error Handling**: Always check response.ok, handle errors
6. **async/await**: Preferred over .then() chains
7. **Best Practice**: Always handle errors, check response status
8. **Modern Standard**: Fetch is the standard for HTTP requests

---

## Quiz: Fetch API

Test your understanding with these questions:

1. **Fetch returns:**
   - A) Data directly
   - B) Promise
   - C) Response object
   - D) Error

2. **To parse JSON response:**
   - A) response.json()
   - B) response.text()
   - C) JSON.parse(response)
   - D) response.data

3. **POST request needs:**
   - A) method: 'POST'
   - B) body
   - C) headers (usually)
   - D) All of the above

4. **response.ok is:**
   - A) Always true
   - B) True for 2xx status
   - C) True for 200 only
   - D) Always false

5. **Fetch is:**
   - A) Synchronous
   - B) Asynchronous
   - C) Both
   - D) Neither

6. **Error handling should:**
   - A) Check response.ok
   - B) Use try-catch
   - C) Both A and B
   - D) Neither

7. **Multiple requests can use:**
   - A) Promise.all()
   - B) Sequential await
   - C) Both
   - D) Neither

**Answers**:
1. B) Promise (that resolves to Response)
2. A) response.json()
3. D) All of the above
4. B) True for 2xx status codes
5. B) Asynchronous
6. C) Both A and B
7. C) Both (Promise.all for parallel, sequential await for dependent)

---

## Next Steps

Congratulations! You've learned the Fetch API. You now know:
- How to make HTTP requests
- All HTTP methods (GET, POST, PUT, DELETE)
- How to handle responses and errors
- Best practices for API calls

**What's Next?**
- Lesson 12.2: Axios and HTTP Libraries
- Learn about alternative HTTP libraries
- Understand when to use different tools
- Build more complex API integrations

---

## Additional Resources

- **MDN: Fetch API**: [developer.mozilla.org/en-US/docs/Web/API/Fetch_API](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API)
- **Fetch API Guide**: Comprehensive examples and patterns
- **JSONPlaceholder**: [jsonplaceholder.typicode.com](https://jsonplaceholder.typicode.com) - Free fake API for testing

---

*Lesson completed! You're ready to move on to the next lesson.*

