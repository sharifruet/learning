# Lesson 19.1: HTTP and Web Concepts

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand HTTP protocol basics
- Understand the request/response cycle
- Work with HTTP methods
- Understand HTTP status codes
- Understand headers and cookies
- Understand RESTful APIs
- Make HTTP requests in Python
- Handle HTTP responses
- Understand web architecture
- Apply web concepts in practice

---

## Introduction to HTTP and Web Concepts

**HTTP (Hypertext Transfer Protocol)** is the foundation of data communication on the web. Understanding HTTP is essential for web development.

### Why Learn HTTP?

- **Web foundation**: HTTP is the basis of web communication
- **API development**: Essential for building and consuming APIs
- **Web frameworks**: Understanding HTTP helps with frameworks
- **Debugging**: Helps debug web applications
- **Best practices**: Enables following web standards

### What is HTTP?

HTTP is a protocol for transferring data between clients (browsers) and servers. It defines how messages are formatted and transmitted.

---

## HTTP Protocol Basics

### What is HTTP?

**HTTP** is a stateless, application-layer protocol for distributed, collaborative, hypermedia information systems.

### HTTP Characteristics

- **Stateless**: Each request is independent
- **Client-Server**: Client makes requests, server responds
- **Request-Response**: Request from client, response from server
- **Text-based**: Human-readable format

### HTTP Versions

- **HTTP/1.0**: Original version
- **HTTP/1.1**: Current standard (most common)
- **HTTP/2**: Improved performance
- **HTTP/3**: Latest version (uses QUIC)

### Basic HTTP Request

```
GET /index.html HTTP/1.1
Host: www.example.com
User-Agent: Mozilla/5.0
```

### Basic HTTP Response

```
HTTP/1.1 200 OK
Content-Type: text/html
Content-Length: 1234

<html>...</html>
```

---

## Request/Response Cycle

### Understanding the Cycle

1. **Client sends request**: Browser/client sends HTTP request
2. **Server processes**: Server processes the request
3. **Server sends response**: Server sends HTTP response
4. **Client receives**: Client receives and processes response

### Request Components

An HTTP request consists of:
- **Request line**: Method, path, HTTP version
- **Headers**: Additional information
- **Body**: Optional data (for POST, PUT, etc.)

```
GET /api/users HTTP/1.1
Host: api.example.com
Accept: application/json
```

### Response Components

An HTTP response consists of:
- **Status line**: HTTP version, status code, status message
- **Headers**: Additional information
- **Body**: Response data

```
HTTP/1.1 200 OK
Content-Type: application/json
Content-Length: 123

{"users": [...]}
```

### Example Request/Response

```python
# Client request
GET /api/users/1 HTTP/1.1
Host: api.example.com
Accept: application/json

# Server response
HTTP/1.1 200 OK
Content-Type: application/json
Content-Length: 45

{"id": 1, "name": "Alice", "email": "alice@example.com"}
```

---

## HTTP Methods

### GET

**GET** retrieves data from the server:

```python
# GET request
GET /api/users HTTP/1.1
Host: api.example.com

# Response
HTTP/1.1 200 OK
Content-Type: application/json

[{"id": 1, "name": "Alice"}]
```

### POST

**POST** sends data to create a resource:

```python
# POST request
POST /api/users HTTP/1.1
Host: api.example.com
Content-Type: application/json

{"name": "Bob", "email": "bob@example.com"}

# Response
HTTP/1.1 201 Created
Content-Type: application/json

{"id": 2, "name": "Bob", "email": "bob@example.com"}
```

### PUT

**PUT** updates an existing resource:

```python
# PUT request
PUT /api/users/1 HTTP/1.1
Host: api.example.com
Content-Type: application/json

{"name": "Alice Updated", "email": "alice@example.com"}

# Response
HTTP/1.1 200 OK
Content-Type: application/json

{"id": 1, "name": "Alice Updated", "email": "alice@example.com"}
```

### DELETE

**DELETE** removes a resource:

```python
# DELETE request
DELETE /api/users/1 HTTP/1.1
Host: api.example.com

# Response
HTTP/1.1 204 No Content
```

### PATCH

**PATCH** partially updates a resource:

```python
# PATCH request
PATCH /api/users/1 HTTP/1.1
Host: api.example.com
Content-Type: application/json

{"name": "Alice New"}

# Response
HTTP/1.1 200 OK
Content-Type: application/json

{"id": 1, "name": "Alice New", "email": "alice@example.com"}
```

### Method Summary

| Method | Purpose | Idempotent | Safe |
|--------|---------|------------|------|
| GET | Retrieve data | Yes | Yes |
| POST | Create resource | No | No |
| PUT | Update/replace | Yes | No |
| DELETE | Remove resource | Yes | No |
| PATCH | Partial update | No | No |

---

## HTTP Status Codes

### 2xx Success

- **200 OK**: Request succeeded
- **201 Created**: Resource created
- **204 No Content**: Success, no content

```python
# 200 OK
HTTP/1.1 200 OK
Content-Type: application/json
{"data": "..."}

# 201 Created
HTTP/1.1 201 Created
Location: /api/users/1
{"id": 1, "name": "Alice"}
```

### 3xx Redirection

- **301 Moved Permanently**: Resource moved permanently
- **302 Found**: Resource temporarily moved
- **304 Not Modified**: Resource not modified (cached)

```python
# 301 Moved Permanently
HTTP/1.1 301 Moved Permanently
Location: https://www.example.com/new-url
```

### 4xx Client Error

- **400 Bad Request**: Invalid request
- **401 Unauthorized**: Authentication required
- **403 Forbidden**: Access denied
- **404 Not Found**: Resource not found
- **422 Unprocessable Entity**: Validation error

```python
# 404 Not Found
HTTP/1.1 404 Not Found
Content-Type: application/json
{"error": "Resource not found"}

# 400 Bad Request
HTTP/1.1 400 Bad Request
Content-Type: application/json
{"error": "Invalid request data"}
```

### 5xx Server Error

- **500 Internal Server Error**: Server error
- **502 Bad Gateway**: Gateway error
- **503 Service Unavailable**: Service unavailable

```python
# 500 Internal Server Error
HTTP/1.1 500 Internal Server Error
Content-Type: application/json
{"error": "Internal server error"}
```

---

## HTTP Headers

### Common Request Headers

```python
# Request headers
GET /api/users HTTP/1.1
Host: api.example.com
User-Agent: Mozilla/5.0
Accept: application/json
Accept-Language: en-US
Authorization: Bearer token123
Content-Type: application/json
```

### Common Response Headers

```python
# Response headers
HTTP/1.1 200 OK
Content-Type: application/json
Content-Length: 1234
Cache-Control: max-age=3600
Set-Cookie: session=abc123
```

### Important Headers

- **Content-Type**: Type of content (application/json, text/html)
- **Authorization**: Authentication credentials
- **Accept**: What client accepts
- **Cache-Control**: Caching directives
- **Cookie**: Client cookies
- **Set-Cookie**: Server sets cookie

---

## Cookies and Sessions

### What are Cookies?

**Cookies** are small pieces of data stored by the browser:

```python
# Server sets cookie
HTTP/1.1 200 OK
Set-Cookie: session_id=abc123; Path=/; HttpOnly

# Client sends cookie
GET /api/users HTTP/1.1
Cookie: session_id=abc123
```

### Cookie Attributes

```python
Set-Cookie: name=value; Path=/; Domain=.example.com; Secure; HttpOnly; SameSite=Strict
```

- **Path**: Cookie path
- **Domain**: Cookie domain
- **Secure**: Only over HTTPS
- **HttpOnly**: Not accessible via JavaScript
- **SameSite**: CSRF protection

### Sessions

Sessions use cookies to maintain state:

```python
# Login sets session
POST /api/login HTTP/1.1
{"username": "alice", "password": "secret"}

# Response sets session cookie
HTTP/1.1 200 OK
Set-Cookie: session_id=abc123; HttpOnly

# Subsequent requests include session
GET /api/profile HTTP/1.1
Cookie: session_id=abc123
```

---

## RESTful APIs

### What is REST?

**REST (Representational State Transfer)** is an architectural style for designing web services.

### REST Principles

1. **Stateless**: Each request contains all information
2. **Client-Server**: Separation of concerns
3. **Uniform Interface**: Consistent API design
4. **Resource-based**: Everything is a resource
5. **HTTP methods**: Use appropriate HTTP methods

### RESTful URL Design

```python
# Good RESTful URLs
GET    /api/users           # List users
GET    /api/users/1         # Get user 1
POST   /api/users           # Create user
PUT    /api/users/1         # Update user 1
DELETE /api/users/1         # Delete user 1

# Nested resources
GET    /api/users/1/posts    # Get posts by user 1
GET    /api/users/1/posts/5   # Get post 5 by user 1
```

### RESTful Response Formats

```python
# List response
GET /api/users
{
  "users": [
    {"id": 1, "name": "Alice"},
    {"id": 2, "name": "Bob"}
  ],
  "total": 2
}

# Single resource
GET /api/users/1
{
  "id": 1,
  "name": "Alice",
  "email": "alice@example.com"
}

# Error response
{
  "error": {
    "code": 404,
    "message": "User not found"
  }
}
```

### HTTP Methods in REST

```python
# RESTful API example
GET    /api/users      # List all users
POST   /api/users      # Create new user
GET    /api/users/1    # Get user by ID
PUT    /api/users/1    # Update user
PATCH  /api/users/1    # Partial update
DELETE /api/users/1    # Delete user
```

---

## Making HTTP Requests in Python

### Using requests Library

```python
import requests

# GET request
response = requests.get('https://api.example.com/users')
print(response.status_code)
print(response.json())

# POST request
data = {'name': 'Alice', 'email': 'alice@example.com'}
response = requests.post('https://api.example.com/users', json=data)
print(response.status_code)
print(response.json())
```

### Request Methods

```python
import requests

# GET
response = requests.get(url)

# POST
response = requests.post(url, json=data)

# PUT
response = requests.put(url, json=data)

# DELETE
response = requests.delete(url)

# PATCH
response = requests.patch(url, json=data)
```

### Request Headers

```python
import requests

headers = {
    'Authorization': 'Bearer token123',
    'Content-Type': 'application/json',
    'Accept': 'application/json'
}

response = requests.get(url, headers=headers)
```

### Response Handling

```python
import requests

response = requests.get(url)

# Status code
print(response.status_code)

# Headers
print(response.headers)

# Content
print(response.text)      # String
print(response.json())    # JSON
print(response.content)  # Bytes

# Check status
if response.status_code == 200:
    data = response.json()
elif response.status_code == 404:
    print("Not found")
```

### Error Handling

```python
import requests

try:
    response = requests.get(url)
    response.raise_for_status()  # Raises exception for 4xx/5xx
    data = response.json()
except requests.exceptions.HTTPError as e:
    print(f"HTTP error: {e}")
except requests.exceptions.RequestException as e:
    print(f"Request error: {e}")
```

---

## Practical Examples

### Example 1: GET Request

```python
import requests

# Get user data
response = requests.get('https://api.example.com/users/1')
if response.status_code == 200:
    user = response.json()
    print(f"User: {user['name']}")
else:
    print(f"Error: {response.status_code}")
```

### Example 2: POST Request

```python
import requests

# Create user
data = {
    'name': 'Alice',
    'email': 'alice@example.com'
}
response = requests.post(
    'https://api.example.com/users',
    json=data,
    headers={'Authorization': 'Bearer token123'}
)
if response.status_code == 201:
    user = response.json()
    print(f"Created user: {user['id']}")
```

### Example 3: PUT Request

```python
import requests

# Update user
data = {'name': 'Alice Updated'}
response = requests.put(
    'https://api.example.com/users/1',
    json=data
)
if response.status_code == 200:
    user = response.json()
    print(f"Updated: {user['name']}")
```

### Example 4: DELETE Request

```python
import requests

# Delete user
response = requests.delete('https://api.example.com/users/1')
if response.status_code == 204:
    print("User deleted")
```

### Example 5: Handling Authentication

```python
import requests

# Using Bearer token
headers = {'Authorization': 'Bearer token123'}
response = requests.get(url, headers=headers)

# Using session
session = requests.Session()
session.headers.update({'Authorization': 'Bearer token123'})
response = session.get(url)
```

---

## Web Architecture Concepts

### Client-Server Model

```
Client (Browser)  ←→  Server (Web Server)
     Request
     Response
```

### Stateless Nature

HTTP is stateless - each request is independent:

```python
# Request 1
GET /api/users/1
# Server doesn't remember previous requests

# Request 2
GET /api/users/2
# Server treats this as new request
```

### State Management

Since HTTP is stateless, state is managed via:
- **Cookies**: Stored in browser
- **Sessions**: Stored on server
- **Tokens**: JWT, API keys

---

## Common Mistakes and Pitfalls

### 1. Not Handling Errors

```python
# WRONG: No error handling
response = requests.get(url)
data = response.json()  # May fail

# CORRECT: Handle errors
response = requests.get(url)
response.raise_for_status()
data = response.json()
```

### 2. Wrong HTTP Method

```python
# WRONG: Using GET to create
requests.get('/api/users', json=data)

# CORRECT: Use POST to create
requests.post('/api/users', json=data)
```

### 3. Not Setting Headers

```python
# WRONG: Missing Content-Type
requests.post(url, data={'key': 'value'})

# CORRECT: Set appropriate headers
requests.post(url, json={'key': 'value'})
```

### 4. Ignoring Status Codes

```python
# WRONG: Ignoring status
response = requests.get(url)
data = response.json()  # May be error response

# CORRECT: Check status
response = requests.get(url)
if response.status_code == 200:
    data = response.json()
else:
    handle_error(response)
```

---

## Best Practices

### 1. Use Appropriate HTTP Methods

```python
GET    # Retrieve
POST   # Create
PUT    # Update/replace
PATCH  # Partial update
DELETE # Delete
```

### 2. Use Proper Status Codes

```python
200  # Success
201  # Created
204  # No content
400  # Bad request
401  # Unauthorized
404  # Not found
500  # Server error
```

### 3. Handle Errors Properly

```python
try:
    response = requests.get(url)
    response.raise_for_status()
except requests.exceptions.HTTPError as e:
    # Handle HTTP errors
    pass
```

### 4. Use JSON for APIs

```python
# Good: Use json parameter
requests.post(url, json=data)

# Avoid: Manual JSON encoding
requests.post(url, data=json.dumps(data), headers={'Content-Type': 'application/json'})
```

### 5. Follow RESTful Conventions

```python
# Good RESTful design
GET    /api/users
GET    /api/users/1
POST   /api/users
PUT    /api/users/1
DELETE /api/users/1
```

---

## Practice Exercise

### Exercise: HTTP Concepts

**Objective**: Create a Python program that demonstrates HTTP concepts.

**Instructions**:

1. Create a file called `http_practice.py`

2. Write a program that:
   - Makes HTTP requests
   - Handles responses
   - Demonstrates different HTTP methods
   - Shows RESTful API usage
   - Handles errors properly

3. Your program should include:
   - GET requests
   - POST requests
   - PUT requests
   - DELETE requests
   - Error handling
   - Headers usage
   - Real-world examples

**Example Solution**:

```python
"""
HTTP and Web Concepts Practice
This program demonstrates HTTP concepts using Python.
"""

import requests
import json

print("=" * 60)
print("HTTP AND WEB CONCEPTS PRACTICE")
print("=" * 60)
print()

# Note: These examples use httpbin.org for testing
# In real applications, replace with actual API endpoints

# 1. GET request
print("1. GET REQUEST")
print("-" * 60)
try:
    response = requests.get('https://httpbin.org/get?name=Alice&age=25')
    print(f"Status Code: {response.status_code}")
    print(f"Response: {response.json()}")
except requests.exceptions.RequestException as e:
    print(f"Error: {e}")
print()

# 2. POST request
print("2. POST REQUEST")
print("-" * 60)
try:
    data = {'name': 'Alice', 'email': 'alice@example.com'}
    response = requests.post('https://httpbin.org/post', json=data)
    print(f"Status Code: {response.status_code}")
    print(f"Response: {response.json()}")
except requests.exceptions.RequestException as e:
    print(f"Error: {e}")
print()

# 3. PUT request
print("3. PUT REQUEST")
print("-" * 60)
try:
    data = {'name': 'Alice Updated'}
    response = requests.put('https://httpbin.org/put', json=data)
    print(f"Status Code: {response.status_code}")
    print(f"Response: {response.json()}")
except requests.exceptions.RequestException as e:
    print(f"Error: {e}")
print()

# 4. DELETE request
print("4. DELETE REQUEST")
print("-" * 60)
try:
    response = requests.delete('https://httpbin.org/delete')
    print(f"Status Code: {response.status_code}")
    print(f"Response: {response.json()}")
except requests.exceptions.RequestException as e:
    print(f"Error: {e}")
print()

# 5. PATCH request
print("5. PATCH REQUEST")
print("-" * 60)
try:
    data = {'name': 'Alice Patched'}
    response = requests.patch('https://httpbin.org/patch', json=data)
    print(f"Status Code: {response.status_code}")
    print(f"Response: {response.json()}")
except requests.exceptions.RequestException as e:
    print(f"Error: {e}")
print()

# 6. Request with headers
print("6. REQUEST WITH HEADERS")
print("-" * 60)
try:
    headers = {
        'Authorization': 'Bearer token123',
        'Content-Type': 'application/json',
        'User-Agent': 'Python-Client/1.0'
    }
    response = requests.get('https://httpbin.org/headers', headers=headers)
    print(f"Status Code: {response.status_code}")
    print(f"Response: {response.json()}")
except requests.exceptions.RequestException as e:
    print(f"Error: {e}")
print()

# 7. Handling different status codes
print("7. HANDLING DIFFERENT STATUS CODES")
print("-" * 60)
try:
    # 200 OK
    response = requests.get('https://httpbin.org/status/200')
    print(f"200 OK: {response.status_code}")
    
    # 404 Not Found
    response = requests.get('https://httpbin.org/status/404')
    print(f"404 Not Found: {response.status_code}")
    
    # 500 Server Error
    response = requests.get('https://httpbin.org/status/500')
    print(f"500 Server Error: {response.status_code}")
except requests.exceptions.RequestException as e:
    print(f"Error: {e}")
print()

# 8. Error handling
print("8. ERROR HANDLING")
print("-" * 60)
try:
    response = requests.get('https://httpbin.org/status/404')
    response.raise_for_status()  # Raises exception for 4xx/5xx
except requests.exceptions.HTTPError as e:
    print(f"HTTP Error: {e}")
except requests.exceptions.RequestException as e:
    print(f"Request Error: {e}")
print()

# 9. Response headers
print("9. RESPONSE HEADERS")
print("-" * 60)
try:
    response = requests.get('https://httpbin.org/get')
    print(f"Content-Type: {response.headers.get('Content-Type')}")
    print(f"Content-Length: {response.headers.get('Content-Length')}")
    print(f"All headers: {dict(response.headers)}")
except requests.exceptions.RequestException as e:
    print(f"Error: {e}")
print()

# 10. Query parameters
print("10. QUERY PARAMETERS")
print("-" * 60)
try:
    params = {'page': 1, 'limit': 10, 'sort': 'name'}
    response = requests.get('https://httpbin.org/get', params=params)
    print(f"URL: {response.url}")
    print(f"Response: {response.json()}")
except requests.exceptions.RequestException as e:
    print(f"Error: {e}")
print()

# 11. Form data
print("11. FORM DATA")
print("-" * 60)
try:
    form_data = {'username': 'alice', 'password': 'secret'}
    response = requests.post('https://httpbin.org/post', data=form_data)
    print(f"Status Code: {response.status_code}")
    print(f"Response: {response.json()}")
except requests.exceptions.RequestException as e:
    print(f"Error: {e}")
print()

# 12. JSON data
print("12. JSON DATA")
print("-" * 60)
try:
    json_data = {'name': 'Alice', 'age': 25, 'city': 'NYC'}
    response = requests.post('https://httpbin.org/post', json=json_data)
    print(f"Status Code: {response.status_code}")
    print(f"Response: {response.json()}")
except requests.exceptions.RequestException as e:
    print(f"Error: {e}")
print()

# 13. Session for cookies
print("13. SESSION FOR COOKIES")
print("-" * 60)
try:
    session = requests.Session()
    # First request sets cookie
    response = session.get('https://httpbin.org/cookies/set/session_id/abc123')
    print(f"First request status: {response.status_code}")
    
    # Second request includes cookie
    response = session.get('https://httpbin.org/cookies')
    print(f"Cookies: {response.json()}")
except requests.exceptions.RequestException as e:
    print(f"Error: {e}")
print()

# 14. Timeout handling
print("14. TIMEOUT HANDLING")
print("-" * 60)
try:
    response = requests.get('https://httpbin.org/delay/1', timeout=0.5)
except requests.exceptions.Timeout:
    print("Request timed out")
except requests.exceptions.RequestException as e:
    print(f"Error: {e}")
print()

# 15. RESTful API example
print("15. RESTFUL API EXAMPLE")
print("-" * 60)
base_url = 'https://httpbin.org'

# GET - List resources
print("GET - List resources:")
response = requests.get(f'{base_url}/get')
print(f"Status: {response.status_code}")

# POST - Create resource
print("\nPOST - Create resource:")
data = {'name': 'Alice', 'email': 'alice@example.com'}
response = requests.post(f'{base_url}/post', json=data)
print(f"Status: {response.status_code}")

# PUT - Update resource
print("\nPUT - Update resource:")
data = {'name': 'Alice Updated'}
response = requests.put(f'{base_url}/put', json=data)
print(f"Status: {response.status_code}")

# DELETE - Delete resource
print("\nDELETE - Delete resource:")
response = requests.delete(f'{base_url}/delete')
print(f"Status: {response.status_code}")
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
HTTP AND WEB CONCEPTS PRACTICE
============================================================

1. GET REQUEST
------------------------------------------------------------
Status Code: 200
Response: {'args': {'age': '25', 'name': 'Alice'}, ...}

[... rest of output ...]
```

**Note**: The examples use httpbin.org for testing. In real applications, replace with actual API endpoints.

**Challenge** (Optional):
- Create a RESTful API client
- Build an HTTP request wrapper class
- Implement retry logic for failed requests
- Create a web scraper using HTTP requests

---

## Key Takeaways

1. **HTTP protocol** - foundation of web communication
2. **Request/Response cycle** - client requests, server responds
3. **HTTP methods** - GET, POST, PUT, DELETE, PATCH
4. **Status codes** - 2xx success, 4xx client error, 5xx server error
5. **Headers** - additional request/response information
6. **Cookies** - state management in stateless HTTP
7. **RESTful APIs** - architectural style for web services
8. **requests library** - Python library for HTTP requests
9. **Error handling** - handle HTTP errors properly
10. **Best practices** - use appropriate methods, status codes, handle errors
11. **Stateless** - each request is independent
12. **Client-Server** - separation of concerns
13. **Resource-based** - REST treats everything as resources
14. **Uniform interface** - consistent API design
15. **JSON** - common format for API data

---

## Quiz: Web Basics

Test your understanding with these questions:

1. **What does HTTP stand for?**
   - A) Hypertext Transfer Protocol
   - B) Hypertext Transport Protocol
   - C) Hyper Transfer Protocol
   - D) Hyper Transport

2. **What HTTP method retrieves data?**
   - A) POST
   - B) GET
   - C) PUT
   - D) DELETE

3. **What HTTP method creates a resource?**
   - A) GET
   - B) POST
   - C) PUT
   - D) DELETE

4. **What status code means success?**
   - A) 400
   - B) 200
   - C) 500
   - D) 300

5. **What status code means not found?**
   - A) 400
   - B) 404
   - C) 500
   - D) 200

6. **What is REST?**
   - A) A programming language
   - B) An architectural style
   - C) A database
   - D) A framework

7. **Is HTTP stateless?**
   - A) Yes
   - B) No
   - C) Sometimes
   - D) Depends

8. **What library is commonly used for HTTP requests in Python?**
   - A) urllib
   - B) requests
   - C) http
   - D) web

9. **What does 201 status code mean?**
   - A) OK
   - B) Created
   - C) Not Found
   - D) Error

10. **What is a cookie used for?**
    - A) Storing data in browser
    - B) Authentication
    - C) Session management
    - D) All of the above

**Answers**:
1. A) Hypertext Transfer Protocol (HTTP definition)
2. B) GET (retrieves data)
3. B) POST (creates resource)
4. B) 200 (success status code)
5. B) 404 (not found status code)
6. B) An architectural style (REST definition)
7. A) Yes (HTTP is stateless)
8. B) requests (common Python HTTP library)
9. B) Created (201 status code)
10. D) All of the above (cookie uses)

---

## Next Steps

Excellent work! You've mastered HTTP and web concepts. You now understand:
- HTTP protocol basics
- Request/Response cycle
- RESTful APIs
- Making HTTP requests in Python

**What's Next?**
- Lesson 19.2: Flask Framework
- Learn Flask installation and setup
- Understand routes and views
- Explore templates

---

## Additional Resources

- **HTTP Protocol**: [developer.mozilla.org/en-US/docs/Web/HTTP](https://developer.mozilla.org/en-US/docs/Web/HTTP)
- **REST API**: [restfulapi.net/](https://restfulapi.net/)
- **requests library**: [docs.python-requests.org/](https://docs.python-requests.org/)

---

*Lesson completed! You're ready to move on to the next lesson.*

