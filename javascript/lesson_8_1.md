# Lesson 8.1: Closures

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what closures are and how they work
- Create and use closures effectively
- Recognize common closure patterns
- Understand closure memory considerations
- Use closures for data privacy
- Build powerful function patterns with closures

---

## Introduction to Closures

A closure is a function that has access to variables in its outer (enclosing) lexical scope, even after the outer function has returned. Closures are a fundamental and powerful feature of JavaScript.

### What is a Closure?

A closure is created when:
1. A function is defined inside another function
2. The inner function accesses variables from the outer function's scope
3. The inner function is returned or passed to another function

### Simple Example

```javascript
function outer() {
    let outerVar = "I'm outside!";
    
    function inner() {
        console.log(outerVar);  // Accesses outerVar from outer scope
    }
    
    return inner;
}

let closureFunc = outer();
closureFunc();  // "I'm outside!" - still has access to outerVar
```

---

## Understanding Closures

### Basic Closure

```javascript
function createCounter() {
    let count = 0;  // Private variable
    
    return function() {
        count++;  // Accesses count from outer scope
        return count;
    };
}

let counter = createCounter();
console.log(counter());  // 1
console.log(counter());  // 2
console.log(counter());  // 3
```

### How Closures Work

1. **Outer function executes**: `createCounter()` runs
2. **Inner function created**: The returned function is created
3. **Closure formed**: Inner function "closes over" outer variables
4. **Outer function returns**: But variables remain accessible
5. **Inner function retains access**: Can still access outer variables

### Multiple Closures

Each closure has its own independent scope:

```javascript
function createCounter() {
    let count = 0;
    return function() {
        return ++count;
    };
}

let counter1 = createCounter();
let counter2 = createCounter();

console.log(counter1());  // 1
console.log(counter1());  // 2
console.log(counter2());  // 1 (independent)
console.log(counter1());  // 3
```

---

## Closure Examples

### Example 1: Counter with Increment/Decrement

```javascript
function createCounter(initialValue = 0) {
    let count = initialValue;
    
    return {
        increment() {
            return ++count;
        },
        decrement() {
            return --count;
        },
        getValue() {
            return count;
        },
        reset() {
            count = initialValue;
            return count;
        }
    };
}

let counter = createCounter(10);
console.log(counter.getValue());   // 10
console.log(counter.increment());  // 11
console.log(counter.increment());  // 12
console.log(counter.decrement());  // 11
console.log(counter.reset());      // 10
```

### Example 2: Private Variables

```javascript
function createBankAccount(initialBalance) {
    let balance = initialBalance;  // Private variable
    
    return {
        deposit(amount) {
            if (amount > 0) {
                balance += amount;
                return balance;
            }
            return "Invalid amount";
        },
        withdraw(amount) {
            if (amount > 0 && amount <= balance) {
                balance -= amount;
                return balance;
            }
            return "Insufficient funds";
        },
        getBalance() {
            return balance;
        }
    };
}

let account = createBankAccount(1000);
console.log(account.getBalance());  // 1000
account.deposit(500);
console.log(account.getBalance());  // 1500
account.withdraw(200);
console.log(account.getBalance());  // 1300
// console.log(balance);  // ❌ Error: balance is not accessible
```

### Example 3: Function Factory

```javascript
function createMultiplier(multiplier) {
    return function(number) {
        return number * multiplier;
    };
}

let double = createMultiplier(2);
let triple = createMultiplier(3);
let quadruple = createMultiplier(4);

console.log(double(5));    // 10
console.log(triple(5));    // 15
console.log(quadruple(5)); // 20
```

### Example 4: Memoization

```javascript
function createMemoizedFunction(fn) {
    let cache = {};  // Private cache
    
    return function(...args) {
        let key = JSON.stringify(args);
        
        if (cache[key]) {
            console.log("Cache hit!");
            return cache[key];
        }
        
        console.log("Computing...");
        let result = fn(...args);
        cache[key] = result;
        return result;
    };
}

function expensiveOperation(n) {
    // Simulate expensive computation
    return n * n;
}

let memoized = createMemoizedFunction(expensiveOperation);
console.log(memoized(5));  // Computing... 25
console.log(memoized(5));  // Cache hit! 25
console.log(memoized(10)); // Computing... 100
console.log(memoized(10)); // Cache hit! 100
```

### Example 5: Event Handlers

```javascript
function setupButton(buttonId, clickCount) {
    let count = clickCount;
    let button = document.getElementById(buttonId);
    
    button.addEventListener("click", function() {
        count++;
        console.log(`Button clicked ${count} times`);
    });
}

// Each button has its own independent counter
setupButton("btn1", 0);
setupButton("btn2", 0);
```

---

## Common Closure Patterns

### Pattern 1: Module Pattern

```javascript
let calculator = (function() {
    let result = 0;  // Private
    
    return {
        add(x) {
            result += x;
            return this;
        },
        subtract(x) {
            result -= x;
            return this;
        },
        multiply(x) {
            result *= x;
            return this;
        },
        getResult() {
            return result;
        },
        reset() {
            result = 0;
            return this;
        }
    };
})();

calculator.add(10).multiply(2).subtract(5);
console.log(calculator.getResult());  // 15
```

### Pattern 2: Partial Application

```javascript
function add(a, b, c) {
    return a + b + c;
}

function partial(fn, ...fixedArgs) {
    return function(...remainingArgs) {
        return fn(...fixedArgs, ...remainingArgs);
    };
}

let add5and10 = partial(add, 5, 10);
console.log(add5and10(15));  // 30 (5 + 10 + 15)
```

### Pattern 3: Debouncing

```javascript
function debounce(func, delay) {
    let timeoutId;
    
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            func(...args);
        }, delay);
    };
}

// Usage: Only call function after user stops typing
let debouncedSearch = debounce(function(query) {
    console.log("Searching for:", query);
}, 300);

// debouncedSearch will only execute 300ms after last call
```

### Pattern 4: Throttling

```javascript
function throttle(func, limit) {
    let inThrottle;
    
    return function(...args) {
        if (!inThrottle) {
            func(...args);
            inThrottle = true;
            setTimeout(() => {
                inThrottle = false;
            }, limit);
        }
    };
}

// Usage: Limit function calls to once per limit period
let throttledScroll = throttle(function() {
    console.log("Scrolling...");
}, 1000);
```

### Pattern 5: Currying

```javascript
function curry(fn) {
    return function curried(...args) {
        if (args.length >= fn.length) {
            return fn(...args);
        } else {
            return function(...nextArgs) {
                return curried(...args, ...nextArgs);
            };
        }
    };
}

function add(a, b, c) {
    return a + b + c;
}

let curriedAdd = curry(add);
console.log(curriedAdd(1)(2)(3));      // 6
console.log(curriedAdd(1, 2)(3));     // 6
console.log(curriedAdd(1)(2, 3));     // 6
console.log(curriedAdd(1, 2, 3));     // 6
```

---

## Memory Considerations

### Closures Keep References Alive

Closures keep the entire scope chain alive, which can lead to memory leaks if not careful:

```javascript
function createHandler() {
    let largeData = new Array(1000000).fill("data");  // Large array
    
    return function() {
        console.log("Handler called");
        // largeData is kept in memory even if not used
    };
}

let handler = createHandler();
// largeData stays in memory as long as handler exists
```

### Solution: Clear Unnecessary References

```javascript
function createHandler() {
    let largeData = new Array(1000000).fill("data");
    
    return function() {
        console.log("Handler called");
        // Use largeData
        // ...
        largeData = null;  // Clear reference when done
    };
}
```

### Loop Variables and Closures

**Common Problem:**
```javascript
// ⚠️ Problem: All functions reference same i
for (var i = 0; i < 3; i++) {
    setTimeout(function() {
        console.log(i);  // 3, 3, 3 (all same!)
    }, 100);
}
```

**Solution 1: Use let**
```javascript
// ✅ Solution: let creates new scope for each iteration
for (let i = 0; i < 3; i++) {
    setTimeout(function() {
        console.log(i);  // 0, 1, 2 (correct!)
    }, 100);
}
```

**Solution 2: IIFE**
```javascript
// ✅ Solution: IIFE creates closure for each iteration
for (var i = 0; i < 3; i++) {
    (function(index) {
        setTimeout(function() {
            console.log(index);  // 0, 1, 2
        }, 100);
    })(i);
}
```

**Solution 3: bind()**
```javascript
// ✅ Solution: bind creates new function with bound value
for (var i = 0; i < 3; i++) {
    setTimeout(function(index) {
        console.log(index);  // 0, 1, 2
    }.bind(null, i), 100);
}
```

---

## Practice Exercise

### Exercise: Closure Practice

**Objective**: Practice creating and using closures in various scenarios.

**Instructions**:

1. Create a file called `closures-practice.js`

2. Create closures for:
   - Counter with multiple methods
   - Private data storage
   - Function factories
   - Event handlers
   - Utility functions (debounce, throttle)

3. Demonstrate:
   - Multiple independent closures
   - Data privacy
   - Memory considerations
   - Common patterns

**Example Solution**:

```javascript
// Closures Practice
console.log("=== Basic Closure ===");

function outer() {
    let outerVar = "I'm from outer!";
    
    function inner() {
        console.log(outerVar);
    }
    
    return inner;
}

let closureFunc = outer();
closureFunc();  // "I'm from outer!"
console.log();

console.log("=== Counter Closure ===");

function createCounter(initialValue = 0) {
    let count = initialValue;
    
    return {
        increment() {
            return ++count;
        },
        decrement() {
            return --count;
        },
        getValue() {
            return count;
        },
        reset() {
            count = initialValue;
            return count;
        }
    };
}

let counter1 = createCounter(10);
let counter2 = createCounter(5);

console.log("Counter 1:", counter1.getValue());  // 10
console.log("Counter 2:", counter2.getValue());  // 5
console.log("Counter 1 increment:", counter1.increment());  // 11
console.log("Counter 2 increment:", counter2.increment());  // 6
console.log("Counter 1:", counter1.getValue());  // 11
console.log("Counter 2:", counter2.getValue());  // 6
console.log();

console.log("=== Private Variables ===");

function createBankAccount(initialBalance) {
    let balance = initialBalance;
    let transactions = [];
    
    return {
        deposit(amount) {
            if (amount > 0) {
                balance += amount;
                transactions.push({ type: "deposit", amount, balance });
                return balance;
            }
            return "Invalid amount";
        },
        withdraw(amount) {
            if (amount > 0 && amount <= balance) {
                balance -= amount;
                transactions.push({ type: "withdraw", amount, balance });
                return balance;
            }
            return "Insufficient funds";
        },
        getBalance() {
            return balance;
        },
        getTransactions() {
            return [...transactions];  // Return copy
        }
    };
}

let account = createBankAccount(1000);
console.log("Initial balance:", account.getBalance());  // 1000
account.deposit(500);
console.log("After deposit:", account.getBalance());  // 1500
account.withdraw(200);
console.log("After withdraw:", account.getBalance());  // 1300
console.log("Transactions:", account.getTransactions());
console.log();

console.log("=== Function Factory ===");

function createMultiplier(factor) {
    return function(number) {
        return number * factor;
    };
}

let double = createMultiplier(2);
let triple = createMultiplier(3);
let quadruple = createMultiplier(4);

console.log("Double 5:", double(5));      // 10
console.log("Triple 5:", triple(5));      // 15
console.log("Quadruple 5:", quadruple(5)); // 20
console.log();

console.log("=== Memoization ===");

function createMemoizedFunction(fn) {
    let cache = {};
    
    return function(...args) {
        let key = JSON.stringify(args);
        
        if (cache[key]) {
            console.log("  Cache hit!");
            return cache[key];
        }
        
        console.log("  Computing...");
        let result = fn(...args);
        cache[key] = result;
        return result;
    };
}

function expensiveOperation(n) {
    return n * n;
}

let memoized = createMemoizedFunction(expensiveOperation);
console.log("memoized(5):", memoized(5));   // Computing... 25
console.log("memoized(5):", memoized(5));   // Cache hit! 25
console.log("memoized(10):", memoized(10)); // Computing... 100
console.log("memoized(10):", memoized(10)); // Cache hit! 100
console.log();

console.log("=== Module Pattern ===");

let calculator = (function() {
    let result = 0;
    
    return {
        add(x) {
            result += x;
            return this;
        },
        subtract(x) {
            result -= x;
            return this;
        },
        multiply(x) {
            result *= x;
            return this;
        },
        divide(x) {
            result /= x;
            return this;
        },
        getResult() {
            return result;
        },
        reset() {
            result = 0;
            return this;
        }
    };
})();

calculator.add(10).multiply(2).subtract(5);
console.log("Calculator result:", calculator.getResult());  // 15
calculator.reset();
console.log("After reset:", calculator.getResult());  // 0
console.log();

console.log("=== Debouncing ===");

function debounce(func, delay) {
    let timeoutId;
    
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            func(...args);
        }, delay);
    };
}

let debouncedLog = debounce(function(message) {
    console.log("Debounced:", message);
}, 300);

console.log("Calling debounced function multiple times:");
debouncedLog("Call 1");
debouncedLog("Call 2");
debouncedLog("Call 3");
// Only last call executes after 300ms
console.log();

console.log("=== Throttling ===");

function throttle(func, limit) {
    let inThrottle;
    
    return function(...args) {
        if (!inThrottle) {
            func(...args);
            inThrottle = true;
            setTimeout(() => {
                inThrottle = false;
            }, limit);
        }
    };
}

let throttledLog = throttle(function(message) {
    console.log("Throttled:", message);
}, 1000);

console.log("Calling throttled function multiple times:");
throttledLog("Call 1");  // Executes
throttledLog("Call 2");  // Ignored
throttledLog("Call 3");  // Ignored
// After 1 second, next call will execute
console.log();

console.log("=== Partial Application ===");

function add(a, b, c) {
    return a + b + c;
}

function partial(fn, ...fixedArgs) {
    return function(...remainingArgs) {
        return fn(...fixedArgs, ...remainingArgs);
    };
}

let add5and10 = partial(add, 5, 10);
console.log("add5and10(15):", add5and10(15));  // 30
console.log();

console.log("=== Loop Variables Fix ===");

// Problem with var
console.log("Using var (problem):");
for (var i = 0; i < 3; i++) {
    setTimeout(function() {
        console.log("  var i:", i);  // 3, 3, 3
    }, 10);
}

// Solution with let
setTimeout(() => {
    console.log("Using let (solution):");
    for (let j = 0; j < 3; j++) {
        setTimeout(function() {
            console.log("  let j:", j);  // 0, 1, 2
        }, 20);
    }
}, 50);

// Solution with IIFE
setTimeout(() => {
    console.log("Using IIFE (solution):");
    for (var k = 0; k < 3; k++) {
        (function(index) {
            setTimeout(function() {
                console.log("  IIFE k:", index);  // 0, 1, 2
            }, 30);
        })(k);
    }
}, 100);
```

**Expected Output**:
```
=== Basic Closure ===
I'm from outer!

=== Counter Closure ===
Counter 1: 10
Counter 2: 5
Counter 1 increment: 11
Counter 2 increment: 6
Counter 1: 11
Counter 2: 6

=== Private Variables ===
Initial balance: 1000
After deposit: 1500
After withdraw: 1300
Transactions: [ { type: "deposit", amount: 500, balance: 1500 }, { type: "withdraw", amount: 200, balance: 1300 } ]

=== Function Factory ===
Double 5: 10
Triple 5: 15
Quadruple 5: 20

=== Memoization ===
  Computing...
memoized(5): 25
  Cache hit!
memoized(5): 25
  Computing...
memoized(10): 100
  Cache hit!
memoized(10): 100

=== Module Pattern ===
Calculator result: 15
After reset: 0

=== Debouncing ===
Calling debounced function multiple times:

=== Throttling ===
Calling throttled function multiple times:
Throttled: Call 1

=== Partial Application ===
add5and10(15): 30

=== Loop Variables Fix ===
Using var (problem):
  var i: 3
  var i: 3
  var i: 3
Using let (solution):
  let j: 0
  let j: 1
  let j: 2
Using IIFE (solution):
  IIFE k: 0
  IIFE k: 1
  IIFE k: 2
```

**Challenge (Optional)**:
- Build a closure-based state management system
- Create a closure-based event emitter
- Build a closure-based validation system
- Create advanced closure patterns

---

## Common Mistakes

### 1. Forgetting Closure Scope

```javascript
// ⚠️ Problem: All closures share same variable
for (var i = 0; i < 3; i++) {
    setTimeout(function() {
        console.log(i);  // 3, 3, 3
    }, 100);
}

// ✅ Solution: Use let or IIFE
for (let i = 0; i < 3; i++) {
    setTimeout(function() {
        console.log(i);  // 0, 1, 2
    }, 100);
}
```

### 2. Memory Leaks

```javascript
// ⚠️ Problem: Large data kept in memory
function createHandler() {
    let largeData = new Array(1000000).fill("data");
    return function() {
        // largeData stays in memory
    };
}

// ✅ Solution: Clear when done
function createHandler() {
    let largeData = new Array(1000000).fill("data");
    return function() {
        // Use largeData
        largeData = null;  // Clear reference
    };
}
```

### 3. Not Understanding Closure Persistence

```javascript
// ⚠️ Misunderstanding: Thinking variables reset
function createCounter() {
    let count = 0;
    return function() {
        return count++;
    };
}

let counter = createCounter();
console.log(counter());  // 0
console.log(counter());  // 1 (not 0 again!)
```

---

## Key Takeaways

1. **Closures**: Functions that access outer scope variables
2. **Data Privacy**: Closures enable private variables
3. **Function Factories**: Create specialized functions
4. **Memory**: Closures keep scope chain alive
5. **Common Patterns**: Module, memoization, debouncing, throttling
6. **Loop Variables**: Use `let` or IIFE to fix closure issues
7. **Best Practice**: Understand when closures are created and what they capture

---

## Quiz: Closures

Test your understanding with these questions:

1. **What is a closure?**
   - A) A function
   - B) Function with access to outer scope
   - C) A variable
   - D) An object

2. **When is a closure created?**
   - A) When function is called
   - B) When function is defined
   - C) When variable is declared
   - D) Never

3. **Do closures keep outer variables alive?**
   - A) No
   - B) Yes
   - C) Sometimes
   - D) Only in loops

4. **What's the problem with var in loops?**
   - A) All closures share same variable
   - B) Variables are undefined
   - C) No problem
   - D) Performance issue

5. **Can closures access outer function parameters?**
   - A) No
   - B) Yes
   - C) Sometimes
   - D) Only if returned

6. **What pattern uses closures for private data?**
   - A) Factory pattern
   - B) Module pattern
   - C) Singleton pattern
   - D) Observer pattern

7. **Multiple closures from same function:**
   - A) Share same variables
   - B) Have independent variables
   - C) Can't be created
   - D) Cause errors

**Answers**:
1. B) Function with access to outer scope
2. B) When function is defined
3. B) Yes
4. A) All closures share same variable
5. B) Yes
6. B) Module pattern
7. B) Have independent variables

---

## Next Steps

Congratulations! You've learned closures. You now know:
- What closures are and how they work
- How to create and use closures
- Common closure patterns
- Memory considerations

**What's Next?**
- Lesson 8.2: IIFE (Immediately Invoked Function Expressions)
- Practice creating closure-based utilities
- Understand module patterns
- Build more advanced function patterns

---

## Additional Resources

- **MDN: Closures**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Closures](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Closures)
- **JavaScript.info: Closures**: [javascript.info/closure](https://javascript.info/closure)
- **Understanding Closures in JavaScript**: Comprehensive guide

---

*Lesson completed! You're ready to move on to the next lesson.*

