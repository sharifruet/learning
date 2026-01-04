# Lesson 9.3: Async/Await

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand async functions
- Use the `await` keyword
- Handle errors with try-catch in async code
- Compare async/await with Promises
- Write clean, readable asynchronous code
- Use async/await in practical scenarios

---

## Introduction to Async/Await

Async/await is syntactic sugar built on top of Promises. It makes asynchronous code look and behave more like synchronous code, making it easier to read and write.

### Why Async/Await?

- **Readable**: Looks like synchronous code
- **Simple**: Easier than Promise chains
- **Error Handling**: Use try-catch like synchronous code
- **Modern**: Preferred in modern JavaScript
- **Less Nesting**: Avoid callback hell and deep Promise chains

---

## async Functions

An `async` function is a function that returns a Promise. The function body can use the `await` keyword.

### Basic async Function

```javascript
async function myFunction() {
    return "Hello";
}

myFunction().then((result) => {
    console.log(result);  // "Hello"
});
```

### async Function Always Returns Promise

```javascript
async function getValue() {
    return 42;  // Automatically wrapped in Promise
}

getValue().then((value) => {
    console.log(value);  // 42
});
```

### async Function with Promise

```javascript
async function fetchData() {
    return new Promise((resolve) => {
        setTimeout(() => resolve("Data"), 1000);
    });
}

fetchData().then((data) => {
    console.log(data);  // "Data"
});
```

---

## await Keyword

The `await` keyword pauses the execution of an async function until a Promise is settled.

### Basic await

```javascript
async function fetchUser() {
    let user = await fetchUserData();
    console.log(user);
    return user;
}
```

### await with Promises

```javascript
function fetchUserData() {
    return new Promise((resolve) => {
        setTimeout(() => {
            resolve({ id: 1, name: "Alice" });
        }, 1000);
    });
}

async function getUser() {
    let user = await fetchUserData();
    console.log("User:", user);  // { id: 1, name: "Alice" }
    return user;
}

getUser();
```

### await Pauses Execution

```javascript
async function example() {
    console.log("1. Start");
    
    let result = await new Promise((resolve) => {
        setTimeout(() => resolve("Done"), 1000);
    });
    
    console.log("2. After await:", result);
    console.log("3. End");
}

example();
// Output:
// 1. Start
// (wait 1 second)
// 2. After await: Done
// 3. End
```

---

## Error Handling with try-catch

Async/await allows using try-catch for error handling, just like synchronous code.

### Basic Error Handling

```javascript
async function fetchData() {
    try {
        let data = await fetchUserData();
        console.log("Success:", data);
        return data;
    } catch (error) {
        console.log("Error:", error.message);
        throw error;
    }
}
```

### try-catch with Promises

```javascript
function fetchUserData() {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            let success = Math.random() > 0.5;
            if (success) {
                resolve({ id: 1, name: "Alice" });
            } else {
                reject(new Error("Failed to fetch"));
            }
        }, 1000);
    });
}

async function getUser() {
    try {
        let user = await fetchUserData();
        console.log("User:", user);
        return user;
    } catch (error) {
        console.log("Error:", error.message);
        return null;
    }
}

getUser();
```

### Multiple await with Error Handling

```javascript
async function processUser() {
    try {
        let user = await fetchUser();
        let posts = await fetchPosts(user.id);
        let comments = await fetchComments(posts[0].id);
        
        return { user, posts, comments };
    } catch (error) {
        console.log("Error in processUser:", error.message);
        throw error;
    }
}
```

---

## Async/Await vs Promises

### Promise Chain

```javascript
fetchUser()
    .then((user) => {
        return fetchPosts(user.id);
    })
    .then((posts) => {
        return fetchComments(posts[0].id);
    })
    .then((comments) => {
        console.log("Comments:", comments);
    })
    .catch((error) => {
        console.log("Error:", error);
    });
```

### Async/Await Equivalent

```javascript
async function getComments() {
    try {
        let user = await fetchUser();
        let posts = await fetchPosts(user.id);
        let comments = await fetchComments(posts[0].id);
        console.log("Comments:", comments);
    } catch (error) {
        console.log("Error:", error);
    }
}
```

### Comparison

**Promises:**
- Chainable
- Functional style
- Can be complex with nesting

**Async/Await:**
- Sequential style
- Easier to read
- Natural error handling
- Looks like synchronous code

---

## Sequential vs Parallel Execution

### Sequential with await

```javascript
async function sequential() {
    let user = await fetchUser(1);      // Wait for user
    let posts = await fetchPosts(1);    // Wait for posts
    let comments = await fetchComments(1); // Wait for comments
    
    return { user, posts, comments };
}
// Total time: sum of all operations
```

### Parallel with Promise.all()

```javascript
async function parallel() {
    let [user, posts, comments] = await Promise.all([
        fetchUser(1),
        fetchPosts(1),
        fetchComments(1)
    ]);
    
    return { user, posts, comments };
}
// Total time: longest operation
```

### Mixed Approach

```javascript
async function mixed() {
    // First, get user (required)
    let user = await fetchUser(1);
    
    // Then, fetch posts and comments in parallel
    let [posts, comments] = await Promise.all([
        fetchPosts(user.id),
        fetchComments(user.id)
    ]);
    
    return { user, posts, comments };
}
```

---

## Practical Examples

### Example 1: API Calls

```javascript
async function fetchUserData(userId) {
    try {
        let response = await fetch(`/api/users/${userId}`);
        let user = await response.json();
        return user;
    } catch (error) {
        console.log("Error fetching user:", error);
        throw error;
    }
}

async function displayUser(userId) {
    try {
        let user = await fetchUserData(userId);
        console.log("User:", user);
    } catch (error) {
        console.log("Failed to display user");
    }
}
```

### Example 2: Sequential Operations

```javascript
async function login(username, password) {
    try {
        // Step 1: Authenticate
        let auth = await authenticate(username, password);
        console.log("Authenticated:", auth.token);
        
        // Step 2: Fetch user data
        let user = await fetchUserData(auth.token);
        console.log("User data:", user);
        
        // Step 3: Load user preferences
        let preferences = await loadPreferences(user.id);
        console.log("Preferences:", preferences);
        
        return { user, preferences };
    } catch (error) {
        console.log("Login failed:", error.message);
        throw error;
    }
}
```

### Example 3: Parallel Operations

```javascript
async function loadDashboard(userId) {
    try {
        // Load all data in parallel
        let [user, posts, notifications, settings] = await Promise.all([
            fetchUser(userId),
            fetchPosts(userId),
            fetchNotifications(userId),
            fetchSettings(userId)
        ]);
        
        return {
            user,
            posts,
            notifications,
            settings
        };
    } catch (error) {
        console.log("Failed to load dashboard:", error);
        throw error;
    }
}
```

### Example 4: Error Handling

```javascript
async function processOrder(orderId) {
    try {
        let order = await fetchOrder(orderId);
        
        if (!order) {
            throw new Error("Order not found");
        }
        
        let payment = await processPayment(order);
        let confirmation = await sendConfirmation(order, payment);
        
        return confirmation;
    } catch (error) {
        // Handle different error types
        if (error.message === "Order not found") {
            console.log("Order doesn't exist");
        } else if (error.message === "Payment failed") {
            console.log("Payment processing failed");
        } else {
            console.log("Unexpected error:", error);
        }
        throw error;
    }
}
```

---

## Advanced Patterns

### Pattern 1: Retry Logic

```javascript
async function fetchWithRetry(url, maxRetries = 3) {
    for (let i = 0; i < maxRetries; i++) {
        try {
            let response = await fetch(url);
            return await response.json();
        } catch (error) {
            if (i === maxRetries - 1) {
                throw error;
            }
            console.log(`Retry ${i + 1}/${maxRetries}`);
            await new Promise(resolve => setTimeout(resolve, 1000));
        }
    }
}
```

### Pattern 2: Timeout

```javascript
async function fetchWithTimeout(url, timeout = 5000) {
    let fetchPromise = fetch(url);
    let timeoutPromise = new Promise((_, reject) => {
        setTimeout(() => reject(new Error("Timeout")), timeout);
    });
    
    try {
        let response = await Promise.race([fetchPromise, timeoutPromise]);
        return await response.json();
    } catch (error) {
        console.log("Request failed:", error.message);
        throw error;
    }
}
```

### Pattern 3: Conditional await

```javascript
async function loadData(loadUser, loadPosts) {
    let data = {};
    
    if (loadUser) {
        data.user = await fetchUser();
    }
    
    if (loadPosts) {
        data.posts = await fetchPosts();
    }
    
    return data;
}
```

---

## Practice Exercise

### Exercise: Async/Await Practice

**Objective**: Practice using async/await for asynchronous operations.

**Instructions**:

1. Create a file called `async-await-practice.js`

2. Practice:
   - Creating async functions
   - Using await keyword
   - Error handling with try-catch
   - Sequential and parallel execution
   - Real-world scenarios

**Example Solution**:

```javascript
// Async/Await Practice
console.log("=== Basic async Function ===");

async function basicAsync() {
    return "Hello from async";
}

basicAsync().then((result) => {
    console.log("Result:", result);
});
console.log();

console.log("=== await with Promises ===");

function fetchData() {
    return new Promise((resolve) => {
        setTimeout(() => {
            resolve({ id: 1, name: "Alice" });
        }, 1000);
    });
}

async function getData() {
    console.log("Fetching data...");
    let data = await fetchData();
    console.log("Data received:", data);
    return data;
}

getData();
console.log();

console.log("=== Sequential Execution ===");

function step1() {
    return new Promise((resolve) => {
        setTimeout(() => {
            console.log("Step 1 complete");
            resolve("Step 1 result");
        }, 1000);
    });
}

function step2(data) {
    return new Promise((resolve) => {
        setTimeout(() => {
            console.log("Step 2 complete with:", data);
            resolve("Step 2 result");
        }, 1000);
    });
}

function step3(data) {
    return new Promise((resolve) => {
        setTimeout(() => {
            console.log("Step 3 complete with:", data);
            resolve("Final result");
        }, 1000);
    });
}

async function sequential() {
    try {
        let result1 = await step1();
        let result2 = await step2(result1);
        let result3 = await step3(result2);
        console.log("All steps complete:", result3);
    } catch (error) {
        console.log("Error:", error);
    }
}

sequential();
console.log();

console.log("=== Parallel Execution ===");

function fetchUser(userId) {
    return new Promise((resolve) => {
        let delay = Math.random() * 1000;
        setTimeout(() => {
            resolve({ id: userId, name: `User ${userId}` });
        }, delay);
    });
}

function fetchPosts(userId) {
    return new Promise((resolve) => {
        let delay = Math.random() * 1000;
        setTimeout(() => {
            resolve([
                { id: 1, title: "Post 1" },
                { id: 2, title: "Post 2" }
            ]);
        }, delay);
    });
}

async function parallel() {
    try {
        let [user, posts] = await Promise.all([
            fetchUser(1),
            fetchPosts(1)
        ]);
        console.log("User:", user);
        console.log("Posts:", posts);
    } catch (error) {
        console.log("Error:", error);
    }
}

setTimeout(() => {
    parallel();
}, 4000);
console.log();

console.log("=== Error Handling ===");

function mightFail(shouldFail) {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            if (shouldFail) {
                reject(new Error("Operation failed"));
            } else {
                resolve("Operation succeeded");
            }
        }, 1000);
    });
}

async function handleErrors() {
    try {
        let result = await mightFail(false);
        console.log("Success:", result);
        
        let result2 = await mightFail(true);
        console.log("This won't run");
    } catch (error) {
        console.log("Caught error:", error.message);
    }
}

setTimeout(() => {
    handleErrors();
}, 7000);
console.log();

console.log("=== Real-World Example: API Calls ===");

function apiCall(endpoint) {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            if (endpoint === "/users") {
                resolve([
                    { id: 1, name: "Alice" },
                    { id: 2, name: "Bob" }
                ]);
            } else if (endpoint === "/posts") {
                resolve([
                    { id: 1, title: "Post 1" },
                    { id: 2, title: "Post 2" }
                ]);
            } else {
                reject(new Error("Endpoint not found"));
            }
        }, 1000);
    });
}

async function loadData() {
    try {
        // Sequential
        console.log("Loading users...");
        let users = await apiCall("/users");
        console.log("Users loaded:", users);
        
        console.log("Loading posts...");
        let posts = await apiCall("/posts");
        console.log("Posts loaded:", posts);
        
        return { users, posts };
    } catch (error) {
        console.log("Error loading data:", error.message);
        throw error;
    }
}

setTimeout(() => {
    loadData();
}, 10000);
console.log();

console.log("=== Mixed Sequential and Parallel ===");

async function mixed() {
    try {
        // First, get user (required)
        console.log("Fetching user...");
        let user = await fetchUser(1);
        console.log("User:", user);
        
        // Then, fetch related data in parallel
        console.log("Fetching related data in parallel...");
        let [posts, comments] = await Promise.all([
            fetchPosts(user.id),
            fetchComments(user.id)
        ]);
        
        console.log("Posts:", posts);
        console.log("Comments:", comments);
        
        return { user, posts, comments };
    } catch (error) {
        console.log("Error:", error);
    }
}

setTimeout(() => {
    mixed();
}, 13000);
```

**Expected Output**:
```
=== Basic async Function ===
Result: Hello from async

=== await with Promises ===
Fetching data...
Data received: { id: 1, name: "Alice" }

=== Sequential Execution ===
Step 1 complete
Step 2 complete with: Step 1 result
Step 3 complete with: Step 2 result
All steps complete: Final result

=== Parallel Execution ===
Posts: [ { id: 1, title: "Post 1" }, { id: 2, title: "Post 2" } ]
User: { id: 1, name: "User 1" }

=== Error Handling ===
Success: Operation succeeded
Caught error: Operation failed

=== Real-World Example: API Calls ===
Loading users...
Users loaded: [ { id: 1, name: "Alice" }, { id: 2, name: "Bob" } ]
Loading posts...
Posts loaded: [ { id: 1, title: "Post 1" }, { id: 2, title: "Post 2" } ]

=== Mixed Sequential and Parallel ===
Fetching user...
User: { id: 1, name: "User 1" }
Fetching related data in parallel...
Posts: [ { id: 1, title: "Post 1" }, { id: 2, title: "Post 2" } ]
Comments: [ { id: 1, text: "Comment 1" } ]
```

**Challenge (Optional)**:
- Build async/await API wrapper
- Create retry logic with async/await
- Build timeout utilities
- Create async utility functions

---

## Common Mistakes

### 1. Forgetting await

```javascript
// ⚠️ Problem: Returns Promise, not value
async function getData() {
    let data = fetchData();  // Missing await
    return data;  // Returns Promise, not data
}

// ✅ Solution: Use await
async function getData() {
    let data = await fetchData();
    return data;
}
```

### 2. await in Non-async Function

```javascript
// ❌ Error: await only in async functions
function getData() {
    let data = await fetchData();  // Error!
}

// ✅ Solution: Make function async
async function getData() {
    let data = await fetchData();
}
```

### 3. Not Handling Errors

```javascript
// ⚠️ Problem: Unhandled promise rejection
async function getData() {
    let data = await fetchData();  // What if it fails?
    return data;
}

// ✅ Solution: Use try-catch
async function getData() {
    try {
        let data = await fetchData();
        return data;
    } catch (error) {
        console.log("Error:", error);
        throw error;
    }
}
```

### 4. Sequential When Parallel Possible

```javascript
// ⚠️ Problem: Unnecessarily sequential
async function loadData() {
    let user = await fetchUser();
    let posts = await fetchPosts();  // Could be parallel
    return { user, posts };
}

// ✅ Solution: Use Promise.all() for parallel
async function loadData() {
    let [user, posts] = await Promise.all([
        fetchUser(),
        fetchPosts()
    ]);
    return { user, posts };
}
```

---

## Key Takeaways

1. **async Function**: Always returns a Promise
2. **await**: Pauses execution until Promise settles
3. **Error Handling**: Use try-catch like synchronous code
4. **Sequential**: Use await for dependent operations
5. **Parallel**: Use Promise.all() for independent operations
6. **Readability**: Much cleaner than Promise chains
7. **Best Practice**: Always handle errors, use parallel when possible
8. **Modern Standard**: Preferred over callbacks and Promise chains

---

## Quiz: Async/Await

Test your understanding with these questions:

1. **async function always returns:**
   - A) Value
   - B) Promise
   - C) undefined
   - D) Error

2. **await can only be used:**
   - A) In any function
   - B) In async functions
   - C) In Promises
   - D) Never

3. **await pauses:**
   - A) Entire program
   - B) Async function execution
   - C) Nothing
   - D) Browser

4. **Error handling in async/await uses:**
   - A) catch()
   - B) try-catch
   - C) then()
   - D) finally()

5. **For parallel operations, use:**
   - A) Multiple await
   - B) Promise.all()
   - C) Sequential await
   - D) Callbacks

6. **async/await is:**
   - A) Different from Promises
   - B) Syntactic sugar over Promises
   - C) Replaces Promises
   - D) Not related to Promises

7. **Missing await returns:**
   - A) Value
   - B) Promise
   - C) undefined
   - D) Error

**Answers**:
1. B) Promise
2. B) In async functions
3. B) Async function execution
4. B) try-catch
5. B) Promise.all()
6. B) Syntactic sugar over Promises
7. B) Promise

---

## Next Steps

Congratulations! You've completed Module 9: Asynchronous JavaScript. You now know:
- How callbacks work
- How to use Promises
- How to use async/await
- Modern asynchronous patterns

**What's Next?**
- Module 10: Iterators and Generators
- Practice combining async patterns
- Build real-world async applications
- Continue learning advanced JavaScript

---

## Additional Resources

- **MDN: async function**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/async_function](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/async_function)
- **MDN: await**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/await](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/await)
- **JavaScript.info: Async/await**: [javascript.info/async-await](https://javascript.info/async-await)
- **Async/Await Best Practices**: Common patterns and pitfalls

---

*Lesson completed! You've finished Module 9: Asynchronous JavaScript. Ready for Module 10: Iterators and Generators!*

