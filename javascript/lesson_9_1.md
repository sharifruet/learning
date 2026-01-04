# Lesson 9.1: Callbacks

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand synchronous vs asynchronous code
- Create and use callback functions
- Handle asynchronous operations with callbacks
- Recognize and avoid callback hell
- Use common callback patterns
- Write clean asynchronous code

---

## Introduction to Asynchronous JavaScript

JavaScript is single-threaded, but it can handle asynchronous operations through callbacks, promises, and async/await. Understanding asynchronous code is crucial for modern JavaScript development.

### Why Asynchronous?

- **Non-blocking**: Don't freeze the UI
- **Efficiency**: Handle multiple operations
- **User Experience**: Keep applications responsive
- **Network Operations**: Fetch data without blocking

---

## Synchronous vs Asynchronous Code

### Synchronous Code

Synchronous code executes line by line, blocking until each operation completes:

```javascript
console.log("1");
console.log("2");
console.log("3");
// Output: 1, 2, 3 (in order)
```

### Asynchronous Code

Asynchronous code doesn't block. Operations can complete out of order:

```javascript
console.log("1");

setTimeout(() => {
    console.log("2");
}, 100);

console.log("3");
// Output: 1, 3, 2 (2 comes after 3)
```

### Example: Synchronous vs Asynchronous

```javascript
// Synchronous: Blocks
function syncOperation() {
    let result = 0;
    for (let i = 0; i < 1000000000; i++) {
        result += i;
    }
    return result;
}

console.log("Start");
let result = syncOperation();  // Blocks here
console.log("End");  // Waits for syncOperation

// Asynchronous: Non-blocking
console.log("Start");
setTimeout(() => {
    console.log("Async operation complete");
}, 1000);
console.log("End");  // Doesn't wait
// Output: Start, End, Async operation complete
```

---

## Callback Functions

A callback is a function passed as an argument to another function and executed later.

### Basic Callback

```javascript
function greet(name, callback) {
    console.log(`Hello, ${name}!`);
    callback();
}

function sayGoodbye() {
    console.log("Goodbye!");
}

greet("Alice", sayGoodbye);
// "Hello, Alice!"
// "Goodbye!"
```

### Inline Callbacks

```javascript
function processData(data, callback) {
    console.log("Processing:", data);
    callback(data);
}

processData("test", function(result) {
    console.log("Callback received:", result);
});
```

### Arrow Function Callbacks

```javascript
processData("test", (result) => {
    console.log("Callback received:", result);
});
```

---

## Asynchronous Callbacks

### setTimeout

```javascript
function delayedGreeting(name, callback) {
    setTimeout(() => {
        console.log(`Hello, ${name}!`);
        callback();
    }, 1000);
}

delayedGreeting("Alice", () => {
    console.log("Greeting complete");
});
```

### setInterval

```javascript
let count = 0;
let intervalId = setInterval(() => {
    count++;
    console.log(`Count: ${count}`);
    
    if (count >= 5) {
        clearInterval(intervalId);
        console.log("Interval stopped");
    }
}, 1000);
```

### Event Listeners

```javascript
button.addEventListener("click", function(event) {
    console.log("Button clicked!", event);
});
```

### Array Methods with Callbacks

```javascript
let numbers = [1, 2, 3, 4, 5];

// forEach
numbers.forEach((num) => {
    console.log(num);
});

// map
let doubled = numbers.map((num) => num * 2);

// filter
let evens = numbers.filter((num) => num % 2 === 0);
```

---

## Common Callback Patterns

### Pattern 1: Error-First Callbacks

Standard Node.js pattern: first parameter is error, second is result.

```javascript
function asyncOperation(callback) {
    setTimeout(() => {
        let success = Math.random() > 0.5;
        
        if (success) {
            callback(null, "Success!");
        } else {
            callback(new Error("Operation failed"), null);
        }
    }, 1000);
}

asyncOperation((error, result) => {
    if (error) {
        console.log("Error:", error.message);
    } else {
        console.log("Result:", result);
    }
});
```

### Pattern 2: Success/Error Callbacks

```javascript
function asyncOperation(onSuccess, onError) {
    setTimeout(() => {
        let success = Math.random() > 0.5;
        
        if (success) {
            onSuccess("Success!");
        } else {
            onError(new Error("Operation failed"));
        }
    }, 1000);
}

asyncOperation(
    (result) => {
        console.log("Success:", result);
    },
    (error) => {
        console.log("Error:", error.message);
    }
);
```

### Pattern 3: Callback with Options

```javascript
function fetchData(options, callback) {
    setTimeout(() => {
        let data = {
            url: options.url,
            method: options.method || "GET",
            data: "Response data"
        };
        callback(null, data);
    }, 1000);
}

fetchData(
    { url: "/api/users", method: "GET" },
    (error, data) => {
        if (error) {
            console.log("Error:", error);
        } else {
            console.log("Data:", data);
        }
    }
);
```

---

## Callback Hell

Callback hell occurs when callbacks are nested deeply, making code hard to read and maintain.

### Example of Callback Hell

```javascript
// ⚠️ Callback Hell
getData(function(a) {
    getMoreData(a, function(b) {
        getMoreData(b, function(c) {
            getMoreData(c, function(d) {
                getMoreData(d, function(e) {
                    console.log(e);
                });
            });
        });
    });
});
```

### Problems with Callback Hell

- **Hard to Read**: Deeply nested code
- **Hard to Maintain**: Difficult to modify
- **Error Handling**: Complex error handling
- **Debugging**: Hard to debug

### Solutions

**1. Named Functions**

```javascript
function handleA(a) {
    getMoreData(a, handleB);
}

function handleB(b) {
    getMoreData(b, handleC);
}

function handleC(c) {
    getMoreData(c, handleD);
}

function handleD(d) {
    getMoreData(d, handleE);
}

function handleE(e) {
    console.log(e);
}

getData(handleA);
```

**2. Promises (covered in next lesson)**

```javascript
getData()
    .then(getMoreData)
    .then(getMoreData)
    .then(getMoreData)
    .then(getMoreData)
    .then(console.log);
```

**3. Async/Await (covered later)**

```javascript
async function process() {
    let a = await getData();
    let b = await getMoreData(a);
    let c = await getMoreData(b);
    let d = await getMoreData(c);
    let e = await getMoreData(d);
    console.log(e);
}
```

---

## Practical Examples

### Example 1: File Reading Simulation

```javascript
function readFile(filename, callback) {
    setTimeout(() => {
        let content = `Content of ${filename}`;
        callback(null, content);
    }, 1000);
}

readFile("data.txt", (error, content) => {
    if (error) {
        console.log("Error:", error);
    } else {
        console.log("File content:", content);
    }
});
```

### Example 2: API Request Simulation

```javascript
function fetchUser(userId, callback) {
    setTimeout(() => {
        if (userId > 0) {
            callback(null, {
                id: userId,
                name: "Alice",
                email: "alice@example.com"
            });
        } else {
            callback(new Error("Invalid user ID"), null);
        }
    }, 1000);
}

fetchUser(1, (error, user) => {
    if (error) {
        console.log("Error:", error.message);
    } else {
        console.log("User:", user);
    }
});
```

### Example 3: Sequential Operations

```javascript
function step1(callback) {
    setTimeout(() => {
        console.log("Step 1 complete");
        callback(null, "Step 1 result");
    }, 1000);
}

function step2(data, callback) {
    setTimeout(() => {
        console.log("Step 2 complete with:", data);
        callback(null, "Step 2 result");
    }, 1000);
}

function step3(data, callback) {
    setTimeout(() => {
        console.log("Step 3 complete with:", data);
        callback(null, "Final result");
    }, 1000);
}

// Sequential execution
step1((error, result1) => {
    if (error) {
        console.log("Error in step1:", error);
        return;
    }
    
    step2(result1, (error, result2) => {
        if (error) {
            console.log("Error in step2:", error);
            return;
        }
        
        step3(result2, (error, result3) => {
            if (error) {
                console.log("Error in step3:", error);
                return;
            }
            
            console.log("All steps complete:", result3);
        });
    });
});
```

### Example 4: Parallel Operations

```javascript
function fetchUser(userId, callback) {
    setTimeout(() => {
        callback(null, { id: userId, name: `User ${userId}` });
    }, Math.random() * 1000);
}

function fetchPost(postId, callback) {
    setTimeout(() => {
        callback(null, { id: postId, title: `Post ${postId}` });
    }, Math.random() * 1000);
}

let results = {};
let completed = 0;
let total = 2;

function checkComplete() {
    completed++;
    if (completed === total) {
        console.log("All operations complete:", results);
    }
}

fetchUser(1, (error, user) => {
    if (!error) {
        results.user = user;
    }
    checkComplete();
});

fetchPost(1, (error, post) => {
    if (!error) {
        results.post = post;
    }
    checkComplete();
});
```

---

## Practice Exercise

### Exercise: Callback Practice

**Objective**: Practice creating and using callbacks for asynchronous operations.

**Instructions**:

1. Create a file called `callbacks-practice.js`

2. Practice:
   - Creating callback functions
   - Using setTimeout and setInterval
   - Error-first callbacks
   - Sequential operations
   - Parallel operations
   - Avoiding callback hell

**Example Solution**:

```javascript
// Callbacks Practice
console.log("=== Synchronous vs Asynchronous ===");

console.log("1. Synchronous");
console.log("2. Synchronous");
console.log("3. Synchronous");

console.log("1. Asynchronous");
setTimeout(() => {
    console.log("2. Asynchronous (delayed)");
}, 100);
console.log("3. Asynchronous");
console.log();

console.log("=== Basic Callbacks ===");

function greet(name, callback) {
    console.log(`Hello, ${name}!`);
    callback();
}

greet("Alice", () => {
    console.log("Callback executed");
});
console.log();

console.log("=== Asynchronous Callbacks ===");

function delayedOperation(message, delay, callback) {
    setTimeout(() => {
        console.log(message);
        callback();
    }, delay);
}

delayedOperation("Operation 1", 100, () => {
    console.log("Operation 1 callback");
});

delayedOperation("Operation 2", 50, () => {
    console.log("Operation 2 callback");
});
console.log();

console.log("=== Error-First Callbacks ===");

function asyncOperation(shouldSucceed, callback) {
    setTimeout(() => {
        if (shouldSucceed) {
            callback(null, "Success!");
        } else {
            callback(new Error("Operation failed"), null);
        }
    }, 500);
}

asyncOperation(true, (error, result) => {
    if (error) {
        console.log("Error:", error.message);
    } else {
        console.log("Result:", result);
    }
});

asyncOperation(false, (error, result) => {
    if (error) {
        console.log("Error:", error.message);
    } else {
        console.log("Result:", result);
    }
});
console.log();

console.log("=== Sequential Operations ===");

function step1(callback) {
    setTimeout(() => {
        console.log("Step 1: Fetching user data...");
        callback(null, { userId: 1, name: "Alice" });
    }, 1000);
}

function step2(userData, callback) {
    setTimeout(() => {
        console.log("Step 2: Processing user data...");
        callback(null, { ...userData, processed: true });
    }, 1000);
}

function step3(processedData, callback) {
    setTimeout(() => {
        console.log("Step 3: Saving data...");
        callback(null, { ...processedData, saved: true });
    }, 1000);
}

step1((error, userData) => {
    if (error) {
        console.log("Error in step1:", error);
        return;
    }
    
    step2(userData, (error, processedData) => {
        if (error) {
            console.log("Error in step2:", error);
            return;
        }
        
        step3(processedData, (error, finalData) => {
            if (error) {
                console.log("Error in step3:", error);
                return;
            }
            
            console.log("All steps complete:", finalData);
        });
    });
});
console.log();

console.log("=== Parallel Operations ===");

function fetchUser(userId, callback) {
    let delay = Math.random() * 1000;
    setTimeout(() => {
        callback(null, { id: userId, name: `User ${userId}` });
    }, delay);
}

function fetchPosts(userId, callback) {
    let delay = Math.random() * 1000;
    setTimeout(() => {
        callback(null, [
            { id: 1, title: "Post 1" },
            { id: 2, title: "Post 2" }
        ]);
    }, delay);
}

let results = {};
let completed = 0;
let total = 2;

function checkComplete() {
    completed++;
    if (completed === total) {
        console.log("All parallel operations complete:", results);
    }
}

fetchUser(1, (error, user) => {
    if (!error) {
        results.user = user;
        console.log("User fetched:", user);
    }
    checkComplete();
});

fetchPosts(1, (error, posts) => {
    if (!error) {
        results.posts = posts;
        console.log("Posts fetched:", posts);
    }
    checkComplete();
});
console.log();

console.log("=== Avoiding Callback Hell ===");

// Named functions instead of nested callbacks
function handleUserData(userData) {
    console.log("Processing user:", userData);
    step2(userData, handleProcessedData);
}

function handleProcessedData(error, processedData) {
    if (error) {
        console.log("Error:", error);
        return;
    }
    console.log("Data processed:", processedData);
    step3(processedData, handleFinalData);
}

function handleFinalData(error, finalData) {
    if (error) {
        console.log("Error:", error);
        return;
    }
    console.log("Final data:", finalData);
}

// Cleaner sequential execution
setTimeout(() => {
    step1(handleUserData);
}, 4000);
console.log();

console.log("=== Array Methods with Callbacks ===");

let numbers = [1, 2, 3, 4, 5];

numbers.forEach((num, index) => {
    console.log(`Index ${index}: ${num}`);
});

let doubled = numbers.map((num) => num * 2);
console.log("Doubled:", doubled);

let evens = numbers.filter((num) => num % 2 === 0);
console.log("Evens:", evens);

let sum = numbers.reduce((acc, num) => acc + num, 0);
console.log("Sum:", sum);
```

**Expected Output**:
```
=== Synchronous vs Asynchronous ===
1. Synchronous
2. Synchronous
3. Synchronous
1. Asynchronous
3. Asynchronous
2. Asynchronous (delayed)

=== Basic Callbacks ===
Hello, Alice!
Callback executed

=== Asynchronous Callbacks ===
Operation 2 callback
Operation 1 callback

=== Error-First Callbacks ===
Result: Success!
Error: Operation failed

=== Sequential Operations ===
Step 1: Fetching user data...
Step 2: Processing user data...
Step 3: Saving data...
All steps complete: { userId: 1, name: "Alice", processed: true, saved: true }

=== Parallel Operations ===
Posts fetched: [ { id: 1, title: "Post 1" }, { id: 2, title: "Post 2" } ]
User fetched: { id: 1, name: "User 1" }
All parallel operations complete: { user: { id: 1, name: "User 1" }, posts: [ { id: 1, title: "Post 1" }, { id: 2, title: "Post 2" } ] }

=== Avoiding Callback Hell ===
[After 4 seconds]
Processing user: { userId: 1, name: "Alice" }
Step 2: Processing user data...
Data processed: { userId: 1, name: "Alice", processed: true }
Step 3: Saving data...
Final data: { userId: 1, name: "Alice", processed: true, saved: true }

=== Array Methods with Callbacks ===
Index 0: 1
Index 1: 2
Index 2: 3
Index 3: 4
Index 4: 5
Doubled: [2, 4, 6, 8, 10]
Evens: [2, 4]
Sum: 15
```

**Challenge (Optional)**:
- Build a callback-based API wrapper
- Create a sequential task runner
- Build a parallel operation manager
- Refactor callback hell to named functions

---

## Common Mistakes

### 1. Not Handling Errors

```javascript
// ⚠️ Problem: No error handling
asyncOperation((result) => {
    console.log(result);  // What if error?
});

// ✅ Solution: Always handle errors
asyncOperation((error, result) => {
    if (error) {
        console.log("Error:", error);
        return;
    }
    console.log("Result:", result);
});
```

### 2. Callback Hell

```javascript
// ⚠️ Problem: Deep nesting
operation1((result1) => {
    operation2(result1, (result2) => {
        operation3(result2, (result3) => {
            // Too nested!
        });
    });
});

// ✅ Solution: Named functions or Promises
function handleResult3(result3) {
    // Handle result
}

function handleResult2(result2) {
    operation3(result2, handleResult3);
}

function handleResult1(result1) {
    operation2(result1, handleResult2);
}

operation1(handleResult1);
```

### 3. Calling Callback Multiple Times

```javascript
// ⚠️ Problem: Callback called multiple times
function badOperation(callback) {
    callback("Result 1");
    callback("Result 2");  // Called twice!
}

// ✅ Solution: Call only once
function goodOperation(callback) {
    let called = false;
    return function(...args) {
        if (!called) {
            called = true;
            callback(...args);
        }
    };
}
```

### 4. Forgetting to Call Callback

```javascript
// ⚠️ Problem: Callback never called
function operation(callback) {
    if (condition) {
        // Forgot to call callback!
        return;
    }
    callback("Result");
}

// ✅ Solution: Always call callback
function operation(callback) {
    if (condition) {
        callback(null, "Result");
        return;
    }
    callback(null, "Other result");
}
```

---

## Key Takeaways

1. **Synchronous**: Executes line by line, blocking
2. **Asynchronous**: Non-blocking, operations can complete out of order
3. **Callbacks**: Functions passed as arguments, executed later
4. **Error-First**: Standard pattern: `callback(error, result)`
5. **Callback Hell**: Deep nesting, hard to read and maintain
6. **Solutions**: Named functions, Promises, async/await
7. **Best Practice**: Always handle errors, avoid deep nesting
8. **Modern Approach**: Prefer Promises or async/await over callbacks

---

## Quiz: Callbacks

Test your understanding with these questions:

1. **What is a callback?**
   - A) A variable
   - B) Function passed as argument
   - C) An object
   - D) A string

2. **Asynchronous code:**
   - A) Blocks execution
   - B) Doesn't block
   - C) Always errors
   - D) Never completes

3. **Error-first callback pattern:**
   - A) Error is first parameter
   - B) Error is last parameter
   - C) No error parameter
   - D) Error is in object

4. **Callback hell is:**
   - A) Good practice
   - B) Deeply nested callbacks
   - C) Fast execution
   - D) Error handling

5. **setTimeout is:**
   - A) Synchronous
   - B) Asynchronous
   - C) Blocking
   - D) Never executes

6. **Which solves callback hell?**
   - A) More nesting
   - B) Named functions
   - C) Ignoring errors
   - D) No callbacks

7. **Callbacks should be called:**
   - A) Multiple times
   - B) Once
   - C) Never
   - D) Sometimes

**Answers**:
1. B) Function passed as argument
2. B) Doesn't block
3. A) Error is first parameter
4. B) Deeply nested callbacks
5. B) Asynchronous
6. B) Named functions
7. B) Once

---

## Next Steps

Congratulations! You've learned callbacks. You now know:
- Synchronous vs asynchronous code
- How to create and use callbacks
- Common callback patterns
- How to avoid callback hell

**What's Next?**
- Lesson 9.2: Promises
- Learn modern asynchronous patterns
- Understand Promise-based code
- Build better async applications

---

## Additional Resources

- **MDN: Asynchronous JavaScript**: [developer.mozilla.org/en-US/docs/Learn/JavaScript/Asynchronous](https://developer.mozilla.org/en-US/docs/Learn/JavaScript/Asynchronous)
- **JavaScript.info: Callbacks**: [javascript.info/callbacks](https://javascript.info/callbacks)
- **Node.js Callback Pattern**: Error-first callback conventions

---

*Lesson completed! You're ready to move on to the next lesson.*

