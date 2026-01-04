# Lesson 9.2: Promises

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what Promises are and why they're useful
- Create Promises
- Use `then()` and `catch()` to handle results
- Chain Promises together
- Use `Promise.all()` and `Promise.race()`
- Handle errors in Promises
- Write clean asynchronous code with Promises

---

## Introduction to Promises

A Promise is an object representing the eventual completion (or failure) of an asynchronous operation. Promises provide a cleaner alternative to callbacks.

### Why Promises?

- **Better than Callbacks**: Avoid callback hell
- **Chainable**: Easy to chain operations
- **Error Handling**: Built-in error handling
- **Readable**: More readable than nested callbacks
- **Modern Standard**: Used in modern JavaScript

### Promise States

A Promise has three states:
1. **Pending**: Initial state, not fulfilled or rejected
2. **Fulfilled**: Operation completed successfully
3. **Rejected**: Operation failed

---

## Creating Promises

### Basic Promise Syntax

```javascript
let promise = new Promise((resolve, reject) => {
    // Asynchronous operation
    if (success) {
        resolve(value);  // Fulfill promise
    } else {
        reject(error);   // Reject promise
    }
});
```

### Simple Promise Example

```javascript
let promise = new Promise((resolve, reject) => {
    setTimeout(() => {
        resolve("Success!");
    }, 1000);
});

promise.then((result) => {
    console.log(result);  // "Success!" (after 1 second)
});
```

### Promise with Rejection

```javascript
let promise = new Promise((resolve, reject) => {
    setTimeout(() => {
        let success = Math.random() > 0.5;
        
        if (success) {
            resolve("Success!");
        } else {
            reject(new Error("Failed!"));
        }
    }, 1000);
});
```

### Promise Constructor

```javascript
function createPromise(shouldSucceed) {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            if (shouldSucceed) {
                resolve("Operation succeeded");
            } else {
                reject(new Error("Operation failed"));
            }
        }, 1000);
    });
}
```

---

## then() and catch()

### then() Method

`then()` handles fulfilled promises:

```javascript
let promise = new Promise((resolve) => {
    setTimeout(() => resolve("Hello"), 1000);
});

promise.then((result) => {
    console.log(result);  // "Hello"
});
```

### catch() Method

`catch()` handles rejected promises:

```javascript
let promise = new Promise((resolve, reject) => {
    setTimeout(() => reject(new Error("Failed")), 1000);
});

promise.catch((error) => {
    console.log("Error:", error.message);  // "Error: Failed"
});
```

### then() and catch() Together

```javascript
let promise = new Promise((resolve, reject) => {
    let success = Math.random() > 0.5;
    setTimeout(() => {
        if (success) {
            resolve("Success!");
        } else {
            reject(new Error("Failed!"));
        }
    }, 1000);
});

promise
    .then((result) => {
        console.log("Success:", result);
    })
    .catch((error) => {
        console.log("Error:", error.message);
    });
```

### then() with Two Handlers

```javascript
promise.then(
    (result) => {
        console.log("Success:", result);
    },
    (error) => {
        console.log("Error:", error.message);
    }
);
```

---

## Promise Chaining

Promises can be chained together, making sequential operations easy.

### Basic Chaining

```javascript
function step1() {
    return new Promise((resolve) => {
        setTimeout(() => resolve("Step 1"), 1000);
    });
}

function step2(data) {
    return new Promise((resolve) => {
        setTimeout(() => resolve(`${data} -> Step 2`), 1000);
    });
}

function step3(data) {
    return new Promise((resolve) => {
        setTimeout(() => resolve(`${data} -> Step 3`), 1000);
    });
}

step1()
    .then(step2)
    .then(step3)
    .then((result) => {
        console.log("Final:", result);
    });
```

### Chaining with Data Transformation

```javascript
fetchUser(1)
    .then((user) => {
        console.log("User:", user);
        return user.id;
    })
    .then((userId) => {
        return fetchPosts(userId);
    })
    .then((posts) => {
        console.log("Posts:", posts);
    })
    .catch((error) => {
        console.log("Error:", error);
    });
```

### Error Handling in Chains

```javascript
step1()
    .then(step2)
    .then(step3)
    .catch((error) => {
        console.log("Error in any step:", error);
        // Error from any step is caught here
    });
```

---

## Promise.all()

`Promise.all()` waits for all promises to resolve, or rejects if any promise rejects.

### Basic Promise.all()

```javascript
let promise1 = new Promise((resolve) => {
    setTimeout(() => resolve("Result 1"), 1000);
});

let promise2 = new Promise((resolve) => {
    setTimeout(() => resolve("Result 2"), 2000);
});

let promise3 = new Promise((resolve) => {
    setTimeout(() => resolve("Result 3"), 1500);
});

Promise.all([promise1, promise2, promise3])
    .then((results) => {
        console.log("All completed:", results);
        // ["Result 1", "Result 2", "Result 3"]
    });
```

### Promise.all() with Rejection

```javascript
let promise1 = Promise.resolve("Success 1");
let promise2 = Promise.reject(new Error("Failed"));
let promise3 = Promise.resolve("Success 3");

Promise.all([promise1, promise2, promise3])
    .then((results) => {
        console.log("All succeeded");
    })
    .catch((error) => {
        console.log("One failed:", error.message);  // "One failed: Failed"
    });
```

### Practical Example

```javascript
function fetchUser(userId) {
    return new Promise((resolve) => {
        setTimeout(() => resolve({ id: userId, name: `User ${userId}` }), 1000);
    });
}

function fetchPosts(userId) {
    return new Promise((resolve) => {
        setTimeout(() => resolve([
            { id: 1, title: "Post 1" },
            { id: 2, title: "Post 2" }
        ]), 1500);
    });
}

function fetchComments(postId) {
    return new Promise((resolve) => {
        setTimeout(() => resolve([
            { id: 1, text: "Comment 1" }
        ]), 500);
    });
}

// Fetch all in parallel
Promise.all([
    fetchUser(1),
    fetchPosts(1),
    fetchComments(1)
])
    .then(([user, posts, comments]) => {
        console.log("User:", user);
        console.log("Posts:", posts);
        console.log("Comments:", comments);
    });
```

---

## Promise.race()

`Promise.race()` returns the first promise that settles (fulfills or rejects).

### Basic Promise.race()

```javascript
let promise1 = new Promise((resolve) => {
    setTimeout(() => resolve("Fast"), 500);
});

let promise2 = new Promise((resolve) => {
    setTimeout(() => resolve("Slow"), 2000);
});

Promise.race([promise1, promise2])
    .then((result) => {
        console.log("Winner:", result);  // "Winner: Fast"
    });
```

### Promise.race() with Timeout

```javascript
function fetchWithTimeout(url, timeout) {
    let fetchPromise = fetch(url);
    let timeoutPromise = new Promise((_, reject) => {
        setTimeout(() => reject(new Error("Timeout")), timeout);
    });
    
    return Promise.race([fetchPromise, timeoutPromise]);
}

fetchWithTimeout("/api/data", 5000)
    .then((data) => {
        console.log("Data:", data);
    })
    .catch((error) => {
        console.log("Error:", error.message);
    });
```

---

## Promise Utility Methods

### Promise.resolve()

Creates a resolved promise:

```javascript
let resolved = Promise.resolve("Value");
resolved.then((value) => {
    console.log(value);  // "Value"
});
```

### Promise.reject()

Creates a rejected promise:

```javascript
let rejected = Promise.reject(new Error("Error"));
rejected.catch((error) => {
    console.log(error.message);  // "Error"
});
```

### Promise.allSettled()

Waits for all promises to settle (fulfill or reject):

```javascript
let promise1 = Promise.resolve("Success 1");
let promise2 = Promise.reject(new Error("Failed"));
let promise3 = Promise.resolve("Success 3");

Promise.allSettled([promise1, promise2, promise3])
    .then((results) => {
        results.forEach((result, index) => {
            if (result.status === "fulfilled") {
                console.log(`Promise ${index + 1}:`, result.value);
            } else {
                console.log(`Promise ${index + 1}:`, result.reason.message);
            }
        });
    });
```

---

## Practical Examples

### Example 1: API Request

```javascript
function fetchUser(userId) {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            if (userId > 0) {
                resolve({
                    id: userId,
                    name: "Alice",
                    email: "alice@example.com"
                });
            } else {
                reject(new Error("Invalid user ID"));
            }
        }, 1000);
    });
}

fetchUser(1)
    .then((user) => {
        console.log("User:", user);
    })
    .catch((error) => {
        console.log("Error:", error.message);
    });
```

### Example 2: Sequential Operations

```javascript
function login(username, password) {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            if (username && password) {
                resolve({ token: "abc123", userId: 1 });
            } else {
                reject(new Error("Invalid credentials"));
            }
        }, 1000);
    });
}

function fetchUserData(token) {
    return new Promise((resolve) => {
        setTimeout(() => {
            resolve({ name: "Alice", email: "alice@example.com" });
        }, 1000);
    });
}

login("alice", "password")
    .then((auth) => {
        console.log("Logged in:", auth.token);
        return fetchUserData(auth.token);
    })
    .then((userData) => {
        console.log("User data:", userData);
    })
    .catch((error) => {
        console.log("Error:", error.message);
    });
```

### Example 3: Parallel Operations

```javascript
function fetchUser(userId) {
    return new Promise((resolve) => {
        setTimeout(() => resolve({ id: userId, name: `User ${userId}` }), 1000);
    });
}

function fetchPosts(userId) {
    return new Promise((resolve) => {
        setTimeout(() => resolve([
            { id: 1, title: "Post 1" },
            { id: 2, title: "Post 2" }
        ]), 1500);
    });
}

// Fetch in parallel
Promise.all([
    fetchUser(1),
    fetchPosts(1)
])
    .then(([user, posts]) => {
        console.log("User:", user);
        console.log("Posts:", posts);
    });
```

---

## Practice Exercise

### Exercise: Promise Practice

**Objective**: Practice creating and using Promises in various scenarios.

**Instructions**:

1. Create a file called `promises-practice.js`

2. Practice:
   - Creating Promises
   - Using then() and catch()
   - Chaining Promises
   - Using Promise.all() and Promise.race()
   - Error handling
   - Real-world scenarios

**Example Solution**:

```javascript
// Promises Practice
console.log("=== Creating Promises ===");

let promise1 = new Promise((resolve, reject) => {
    setTimeout(() => {
        resolve("Promise 1 resolved");
    }, 1000);
});

promise1.then((result) => {
    console.log("Result:", result);
});
console.log();

console.log("=== Promise with Rejection ===");

let promise2 = new Promise((resolve, reject) => {
    setTimeout(() => {
        let success = Math.random() > 0.5;
        if (success) {
            resolve("Success!");
        } else {
            reject(new Error("Failed!"));
        }
    }, 1000);
});

promise2
    .then((result) => {
        console.log("Success:", result);
    })
    .catch((error) => {
        console.log("Error:", error.message);
    });
console.log();

console.log("=== Promise Chaining ===");

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

step1()
    .then(step2)
    .then(step3)
    .then((result) => {
        console.log("All steps complete:", result);
    })
    .catch((error) => {
        console.log("Error in chain:", error);
    });
console.log();

console.log("=== Promise.all() ===");

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

Promise.all([
    fetchUser(1),
    fetchPosts(1)
])
    .then(([user, posts]) => {
        console.log("User:", user);
        console.log("Posts:", posts);
    });
console.log();

console.log("=== Promise.race() ===");

let fastPromise = new Promise((resolve) => {
    setTimeout(() => resolve("Fast"), 500);
});

let slowPromise = new Promise((resolve) => {
    setTimeout(() => resolve("Slow"), 2000);
});

Promise.race([fastPromise, slowPromise])
    .then((result) => {
        console.log("Winner:", result);  // "Fast"
    });
console.log();

console.log("=== Promise.resolve() and Promise.reject() ===");

let resolved = Promise.resolve("Resolved value");
resolved.then((value) => {
    console.log("Resolved:", value);
});

let rejected = Promise.reject(new Error("Rejected"));
rejected.catch((error) => {
    console.log("Rejected:", error.message);
});
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

mightFail(false)
    .then((result) => {
        console.log("Success:", result);
        return mightFail(true);
    })
    .then((result) => {
        console.log("This won't run");
    })
    .catch((error) => {
        console.log("Caught error:", error.message);
    });
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

// Sequential
apiCall("/users")
    .then((users) => {
        console.log("Users:", users);
        return apiCall("/posts");
    })
    .then((posts) => {
        console.log("Posts:", posts);
    })
    .catch((error) => {
        console.log("Error:", error.message);
    });

// Parallel
setTimeout(() => {
    Promise.all([
        apiCall("/users"),
        apiCall("/posts")
    ])
        .then(([users, posts]) => {
            console.log("All data:", { users, posts });
        })
        .catch((error) => {
            console.log("Error:", error.message);
        });
}, 3000);
```

**Expected Output**:
```
=== Creating Promises ===

=== Promise with Rejection ===
[Either "Success: Success!" or "Error: Failed!"]

=== Promise Chaining ===
Step 1 complete
Step 2 complete with: Step 1 result
Step 3 complete with: Step 2 result
All steps complete: Final result

=== Promise.all() ===
Posts: [ { id: 1, title: "Post 1" }, { id: 2, title: "Post 2" } ]
User: { id: 1, name: "User 1" }

=== Promise.race() ===
Winner: Fast

=== Promise.resolve() and Promise.reject() ===
Resolved: Resolved value
Rejected: Rejected

=== Error Handling ===
Success: Operation succeeded
Caught error: Operation failed

=== Real-World Example: API Calls ===
Users: [ { id: 1, name: "Alice" }, { id: 2, name: "Bob" } ]
Posts: [ { id: 1, title: "Post 1" }, { id: 2, title: "Post 2" } ]
All data: { users: [ { id: 1, name: "Alice" }, { id: 2, name: "Bob" } ], posts: [ { id: 1, title: "Post 1" }, { id: 2, title: "Post 2" } ] }
```

**Challenge (Optional)**:
- Build a Promise-based API wrapper
- Create a Promise utility library
- Build a retry mechanism with Promises
- Create a timeout wrapper for Promises

---

## Common Mistakes

### 1. Forgetting to Return in then()

```javascript
// ⚠️ Problem: Doesn't return promise
promise1
    .then((result) => {
        promise2(result);  // Forgot return
    })
    .then((result) => {
        // result is undefined!
    });

// ✅ Solution: Return promise
promise1
    .then((result) => {
        return promise2(result);
    })
    .then((result) => {
        // result is correct
    });
```

### 2. Not Handling Errors

```javascript
// ⚠️ Problem: No error handling
promise.then((result) => {
    console.log(result);
});

// ✅ Solution: Always handle errors
promise
    .then((result) => {
        console.log(result);
    })
    .catch((error) => {
        console.log("Error:", error);
    });
```

### 3. Creating Promise in then()

```javascript
// ⚠️ Problem: Unnecessary nesting
promise.then((result) => {
    return new Promise((resolve) => {
        resolve(process(result));
    });
});

// ✅ Solution: Return value directly
promise.then((result) => {
    return process(result);
});
```

### 4. Promise Constructor Anti-pattern

```javascript
// ⚠️ Problem: Wrapping already-promise value
function badFunction() {
    return new Promise((resolve) => {
        resolve(anotherPromise);  // Unnecessary
    });
}

// ✅ Solution: Return promise directly
function goodFunction() {
    return anotherPromise;
}
```

---

## Key Takeaways

1. **Promises**: Represent eventual completion of async operations
2. **States**: Pending, Fulfilled, Rejected
3. **then()**: Handles fulfilled promises
4. **catch()**: Handles rejected promises
5. **Chaining**: Chain operations with then()
6. **Promise.all()**: Wait for all promises
7. **Promise.race()**: Get first settled promise
8. **Best Practice**: Always handle errors, return promises in chains

---

## Quiz: Promises

Test your understanding with these questions:

1. **What is a Promise?**
   - A) A function
   - B) Object representing async operation
   - C) A variable
   - D) An error

2. **Promise has how many states?**
   - A) 1
   - B) 2
   - C) 3
   - D) 4

3. **then() handles:**
   - A) Rejected promises
   - B) Fulfilled promises
   - C) Pending promises
   - D) All promises

4. **catch() handles:**
   - A) Fulfilled promises
   - B) Rejected promises
   - C) All promises
   - D) Nothing

5. **Promise.all() waits for:**
   - A) First promise
   - B) All promises
   - C) Any promise
   - D) No promises

6. **Promise.race() returns:**
   - A) All promises
   - B) First settled promise
   - C) Last promise
   - D) Error

7. **In then(), you should:**
   - A) Return value
   - B) Not return
   - C) Always return promise
   - D) Return undefined

**Answers**:
1. B) Object representing async operation
2. C) 3 (Pending, Fulfilled, Rejected)
3. B) Fulfilled promises
4. B) Rejected promises
5. B) All promises
6. B) First settled promise
7. A) Return value (or promise for chaining)

---

## Next Steps

Congratulations! You've learned Promises. You now know:
- How to create and use Promises
- Promise chaining
- Promise.all() and Promise.race()
- Error handling with Promises

**What's Next?**
- Lesson 9.3: Async/Await
- Learn modern async syntax
- Understand async/await vs Promises
- Write even cleaner async code

---

## Additional Resources

- **MDN: Promises**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Promise](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Promise)
- **JavaScript.info: Promises**: [javascript.info/promise-basics](https://javascript.info/promise-basics)
- **Promise Patterns**: Common patterns and best practices

---

*Lesson completed! You're ready to move on to the next lesson.*

