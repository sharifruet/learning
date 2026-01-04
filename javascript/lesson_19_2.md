# Lesson 19.2: Structural Patterns

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand structural design patterns
- Implement the Module pattern
- Implement the Facade pattern
- Implement the Decorator pattern
- Choose appropriate patterns
- Apply patterns to organize code
- Build maintainable code structures

---

## Introduction to Structural Patterns

Structural patterns focus on how classes and objects are composed to form larger structures.

### Why Structural Patterns?

- **Organization**: Better code organization
- **Reusability**: Reuse existing code
- **Flexibility**: Easier to modify and extend
- **Maintainability**: Clearer code structure
- **Separation of Concerns**: Better code separation
- **Best Practices**: Proven structural solutions

### Common Structural Patterns

1. **Module**: Encapsulate code
2. **Facade**: Simplify complex interfaces
3. **Decorator**: Add behavior dynamically

---

## Module Pattern

### What is Module Pattern?

Module pattern provides a way to create private and public members.

### Basic Module Pattern

```javascript
const Module = (function() {
    // Private variables
    let privateVar = 'private';
    
    // Private functions
    function privateFunction() {
        return 'private function';
    }
    
    // Public API
    return {
        publicVar: 'public',
        publicFunction: function() {
            return 'public function';
        },
        getPrivateVar: function() {
            return privateVar;
        }
    };
})();

console.log(Module.publicVar);           // 'public'
console.log(Module.publicFunction());     // 'public function'
console.log(Module.getPrivateVar());      // 'private'
// console.log(Module.privateVar);        // undefined
```

### Module with Revealing Pattern

```javascript
const Calculator = (function() {
    // Private
    function add(a, b) {
        return a + b;
    }
    
    function subtract(a, b) {
        return a - b;
    }
    
    function multiply(a, b) {
        return a * b;
    }
    
    function divide(a, b) {
        if (b === 0) {
            throw new Error('Division by zero');
        }
        return a / b;
    }
    
    // Public API
    return {
        add: add,
        subtract: subtract,
        multiply: multiply,
        divide: divide
    };
})();

console.log(Calculator.add(5, 3));        // 8
console.log(Calculator.multiply(4, 2));   // 8
```

### ES6 Module Pattern

```javascript
// Using ES6 classes with private fields
class Calculator {
    #history = [];
    
    add(a, b) {
        let result = a + b;
        this.#history.push(`add(${a}, ${b}) = ${result}`);
        return result;
    }
    
    subtract(a, b) {
        let result = a - b;
        this.#history.push(`subtract(${a}, ${b}) = ${result}`);
        return result;
    }
    
    getHistory() {
        return [...this.#history];
    }
    
    clearHistory() {
        this.#history = [];
    }
}

let calc = new Calculator();
calc.add(5, 3);
calc.subtract(10, 4);
console.log(calc.getHistory());
```

### Practical Module Example

```javascript
const UserModule = (function() {
    let users = [];
    let nextId = 1;
    
    function findUser(id) {
        return users.find(u => u.id === id);
    }
    
    return {
        create: function(name, email) {
            let user = {
                id: nextId++,
                name: name,
                email: email,
                createdAt: new Date()
            };
            users.push(user);
            return user;
        },
        
        findById: function(id) {
            return findUser(id);
        },
        
        findAll: function() {
            return [...users];
        },
        
        update: function(id, updates) {
            let user = findUser(id);
            if (user) {
                Object.assign(user, updates);
                return user;
            }
            return null;
        },
        
        delete: function(id) {
            let index = users.findIndex(u => u.id === id);
            if (index !== -1) {
                return users.splice(index, 1)[0];
            }
            return null;
        }
    };
})();

// Usage
let user1 = UserModule.create('Alice', 'alice@example.com');
let user2 = UserModule.create('Bob', 'bob@example.com');
console.log(UserModule.findAll());
```

---

## Facade Pattern

### What is Facade?

Facade provides a simplified interface to a complex subsystem.

### Basic Facade

```javascript
// Complex subsystem
class CPU {
    start() {
        console.log('CPU starting...');
    }
}

class Memory {
    load() {
        console.log('Memory loading...');
    }
}

class HardDrive {
    read() {
        console.log('Hard drive reading...');
    }
}

// Facade
class ComputerFacade {
    constructor() {
        this.cpu = new CPU();
        this.memory = new Memory();
        this.hardDrive = new HardDrive();
    }
    
    start() {
        this.cpu.start();
        this.memory.load();
        this.hardDrive.read();
        console.log('Computer started');
    }
}

// Usage
let computer = new ComputerFacade();
computer.start();
// Simple interface instead of calling each component
```

### Facade for API

```javascript
// Complex API calls
class UserAPI {
    async getUser(id) {
        return fetch(`/api/users/${id}`).then(r => r.json());
    }
    
    async updateUser(id, data) {
        return fetch(`/api/users/${id}`, {
            method: 'PUT',
            body: JSON.stringify(data)
        }).then(r => r.json());
    }
}

class PostAPI {
    async getPosts(userId) {
        return fetch(`/api/users/${userId}/posts`).then(r => r.json());
    }
}

class CommentAPI {
    async getComments(postId) {
        return fetch(`/api/posts/${postId}/comments`).then(r => r.json());
    }
}

// Facade
class SocialMediaFacade {
    constructor() {
        this.userAPI = new UserAPI();
        this.postAPI = new PostAPI();
        this.commentAPI = new CommentAPI();
    }
    
    async getUserProfile(userId) {
        let user = await this.userAPI.getUser(userId);
        let posts = await this.postAPI.getPosts(userId);
        
        for (let post of posts) {
            post.comments = await this.commentAPI.getComments(post.id);
        }
        
        return {
            user: user,
            posts: posts
        };
    }
}

// Usage
let facade = new SocialMediaFacade();
facade.getUserProfile(1).then(profile => {
    console.log(profile);
});
```

### Facade for DOM

```javascript
// Facade for DOM manipulation
class DOMFacade {
    static createElement(tag, attributes = {}, children = []) {
        let element = document.createElement(tag);
        
        Object.keys(attributes).forEach(key => {
            if (key === 'className') {
                element.className = attributes[key];
            } else if (key === 'textContent') {
                element.textContent = attributes[key];
            } else {
                element.setAttribute(key, attributes[key]);
            }
        });
        
        children.forEach(child => {
            if (typeof child === 'string') {
                element.appendChild(document.createTextNode(child));
            } else {
                element.appendChild(child);
            }
        });
        
        return element;
    }
    
    static append(parent, child) {
        if (typeof child === 'string') {
            parent.appendChild(document.createTextNode(child));
        } else {
            parent.appendChild(child);
        }
    }
    
    static remove(element) {
        element.parentNode.removeChild(element);
    }
}

// Usage
let div = DOMFacade.createElement('div', {
    className: 'container',
    id: 'main'
}, [
    DOMFacade.createElement('h1', { textContent: 'Hello' }),
    DOMFacade.createElement('p', { textContent: 'World' })
]);
```

---

## Decorator Pattern

### What is Decorator?

Decorator adds behavior to objects dynamically without modifying their structure.

### Basic Decorator

```javascript
// Base class
class Coffee {
    getCost() {
        return 5;
    }
    
    getDescription() {
        return 'Coffee';
    }
}

// Decorator
class CoffeeDecorator {
    constructor(coffee) {
        this.coffee = coffee;
    }
    
    getCost() {
        return this.coffee.getCost();
    }
    
    getDescription() {
        return this.coffee.getDescription();
    }
}

// Concrete decorators
class MilkDecorator extends CoffeeDecorator {
    getCost() {
        return this.coffee.getCost() + 1;
    }
    
    getDescription() {
        return this.coffee.getDescription() + ', Milk';
    }
}

class SugarDecorator extends CoffeeDecorator {
    getCost() {
        return this.coffee.getCost() + 0.5;
    }
    
    getDescription() {
        return this.coffee.getDescription() + ', Sugar';
    }
}

// Usage
let coffee = new Coffee();
coffee = new MilkDecorator(coffee);
coffee = new SugarDecorator(coffee);

console.log(coffee.getDescription());  // 'Coffee, Milk, Sugar'
console.log(coffee.getCost());         // 6.5
```

### Function Decorator

```javascript
// Function decorator
function withLogging(fn) {
    return function(...args) {
        console.log(`Calling ${fn.name} with:`, args);
        let result = fn.apply(this, args);
        console.log(`Result:`, result);
        return result;
    };
}

function add(a, b) {
    return a + b;
}

let loggedAdd = withLogging(add);
loggedAdd(2, 3);
// Calling add with: [2, 3]
// Result: 5
```

### Multiple Decorators

```javascript
// Timing decorator
function withTiming(fn) {
    return function(...args) {
        let start = performance.now();
        let result = fn.apply(this, args);
        let end = performance.now();
        console.log(`${fn.name} took ${end - start}ms`);
        return result;
    };
}

// Caching decorator
function withCache(fn) {
    let cache = new Map();
    return function(...args) {
        let key = JSON.stringify(args);
        if (cache.has(key)) {
            console.log('Cache hit');
            return cache.get(key);
        }
        let result = fn.apply(this, args);
        cache.set(key, result);
        return result;
    };
}

// Combine decorators
function expensiveOperation(n) {
    let result = 0;
    for (let i = 0; i < n * 1000000; i++) {
        result += i;
    }
    return result;
}

let decorated = withTiming(withCache(expensiveOperation));
decorated(10);  // Calculates and times
decorated(10);  // Uses cache and times
```

### Class Decorator

```javascript
// Class decorator
function withValidation(target) {
    return class extends target {
        constructor(...args) {
            super(...args);
            this.validate();
        }
        
        validate() {
            if (!this.name || this.name.trim() === '') {
                throw new Error('Name is required');
            }
        }
    };
}

@withValidation
class User {
    constructor(name, email) {
        this.name = name;
        this.email = email;
    }
}

// Usage (requires decorator support)
let user = new User('Alice', 'alice@example.com');
```

### Practical Decorator Example

```javascript
// HTTP Request decorator
function withRetry(fn, maxRetries = 3) {
    return async function(...args) {
        for (let i = 0; i < maxRetries; i++) {
            try {
                return await fn.apply(this, args);
            } catch (error) {
                if (i === maxRetries - 1) throw error;
                console.log(`Retry ${i + 1}/${maxRetries}`);
            }
        }
    };
}

function withTimeout(fn, timeout = 5000) {
    return function(...args) {
        return Promise.race([
            fn.apply(this, args),
            new Promise((_, reject) =>
                setTimeout(() => reject(new Error('Timeout')), timeout)
            )
        ]);
    };
}

async function fetchData(url) {
    let response = await fetch(url);
    return response.json();
}

let decoratedFetch = withRetry(withTimeout(fetchData, 5000), 3);
```

---

## Practice Exercise

### Exercise: Structural Patterns

**Objective**: Practice implementing Module, Facade, and Decorator patterns.

**Instructions**:

1. Create a JavaScript file
2. Practice:
   - Creating modules
   - Building facades
   - Implementing decorators
   - Applying patterns to real problems

**Example Solution**:

```javascript
// structural-patterns-practice.js
console.log("=== Structural Patterns Practice ===");

console.log("\n=== Module Pattern ===");

// Basic Module
const Calculator = (function() {
    let history = [];
    
    function add(a, b) {
        return a + b;
    }
    
    function subtract(a, b) {
        return a - b;
    }
    
    function multiply(a, b) {
        return a * b;
    }
    
    function divide(a, b) {
        if (b === 0) {
            throw new Error('Division by zero');
        }
        return a / b;
    }
    
    return {
        add: function(a, b) {
            let result = add(a, b);
            history.push(`add(${a}, ${b}) = ${result}`);
            return result;
        },
        subtract: function(a, b) {
            let result = subtract(a, b);
            history.push(`subtract(${a}, ${b}) = ${result}`);
            return result;
        },
        multiply: function(a, b) {
            let result = multiply(a, b);
            history.push(`multiply(${a}, ${b}) = ${result}`);
            return result;
        },
        divide: function(a, b) {
            let result = divide(a, b);
            history.push(`divide(${a}, ${b}) = ${result}`);
            return result;
        },
        getHistory: function() {
            return [...history];
        },
        clearHistory: function() {
            history = [];
        }
    };
})();

Calculator.add(5, 3);
Calculator.multiply(4, 2);
console.log('Calculator history:', Calculator.getHistory());

// ES6 Module with private fields
class UserModule {
    #users = [];
    #nextId = 1;
    
    #findUser(id) {
        return this.#users.find(u => u.id === id);
    }
    
    create(name, email) {
        let user = {
            id: this.#nextId++,
            name: name,
            email: email,
            createdAt: new Date()
        };
        this.#users.push(user);
        return user;
    }
    
    findById(id) {
        return this.#findUser(id);
    }
    
    findAll() {
        return [...this.#users];
    }
    
    update(id, updates) {
        let user = this.#findUser(id);
        if (user) {
            Object.assign(user, updates);
            return user;
        }
        return null;
    }
    
    delete(id) {
        let index = this.#users.findIndex(u => u.id === id);
        if (index !== -1) {
            return this.#users.splice(index, 1)[0];
        }
        return null;
    }
}

let userModule = new UserModule();
userModule.create('Alice', 'alice@example.com');
userModule.create('Bob', 'bob@example.com');
console.log('Users:', userModule.findAll());
console.log();

console.log("=== Facade Pattern ===");

// Complex subsystem
class CPU {
    start() {
        console.log('CPU starting...');
    }
}

class Memory {
    load() {
        console.log('Memory loading...');
    }
}

class HardDrive {
    read() {
        console.log('Hard drive reading...');
    }
}

// Facade
class ComputerFacade {
    constructor() {
        this.cpu = new CPU();
        this.memory = new Memory();
        this.hardDrive = new HardDrive();
    }
    
    start() {
        this.cpu.start();
        this.memory.load();
        this.hardDrive.read();
        console.log('Computer started');
    }
}

let computer = new ComputerFacade();
computer.start();

// API Facade
class API {
    async get(url) {
        return fetch(url).then(r => r.json());
    }
    
    async post(url, data) {
        return fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        }).then(r => r.json());
    }
}

class UserService {
    constructor() {
        this.api = new API();
    }
    
    async getUser(id) {
        return this.api.get(`/api/users/${id}`);
    }
    
    async createUser(data) {
        return this.api.post('/api/users', data);
    }
}

class PostService {
    constructor() {
        this.api = new API();
    }
    
    async getPosts(userId) {
        return this.api.get(`/api/users/${userId}/posts`);
    }
}

// Facade
class SocialMediaFacade {
    constructor() {
        this.userService = new UserService();
        this.postService = new PostService();
    }
    
    async getUserProfile(userId) {
        let user = await this.userService.getUser(userId);
        let posts = await this.postService.getPosts(userId);
        return { user, posts };
    }
}

let facade = new SocialMediaFacade();
// facade.getUserProfile(1).then(profile => console.log(profile));
console.log();

console.log("=== Decorator Pattern ===");

// Base class
class Coffee {
    getCost() {
        return 5;
    }
    
    getDescription() {
        return 'Coffee';
    }
}

// Decorator base
class CoffeeDecorator {
    constructor(coffee) {
        this.coffee = coffee;
    }
    
    getCost() {
        return this.coffee.getCost();
    }
    
    getDescription() {
        return this.coffee.getDescription();
    }
}

// Concrete decorators
class MilkDecorator extends CoffeeDecorator {
    getCost() {
        return this.coffee.getCost() + 1;
    }
    
    getDescription() {
        return this.coffee.getDescription() + ', Milk';
    }
}

class SugarDecorator extends CoffeeDecorator {
    getCost() {
        return this.coffee.getCost() + 0.5;
    }
    
    getDescription() {
        return this.coffee.getDescription() + ', Sugar';
    }
}

let coffee = new Coffee();
coffee = new MilkDecorator(coffee);
coffee = new SugarDecorator(coffee);

console.log('Coffee description:', coffee.getDescription());
console.log('Coffee cost:', coffee.getCost());

// Function decorators
function withLogging(fn) {
    return function(...args) {
        console.log(`Calling ${fn.name} with:`, args);
        let result = fn.apply(this, args);
        console.log(`Result:`, result);
        return result;
    };
}

function withTiming(fn) {
    return function(...args) {
        let start = performance.now();
        let result = fn.apply(this, args);
        let end = performance.now();
        console.log(`${fn.name} took ${(end - start).toFixed(2)}ms`);
        return result;
    };
}

function add(a, b) {
    return a + b;
}

let loggedAdd = withLogging(add);
let timedLoggedAdd = withTiming(loggedAdd);
timedLoggedAdd(2, 3);

// Caching decorator
function withCache(fn) {
    let cache = new Map();
    return function(...args) {
        let key = JSON.stringify(args);
        if (cache.has(key)) {
            console.log('Cache hit');
            return cache.get(key);
        }
        console.log('Cache miss');
        let result = fn.apply(this, args);
        cache.set(key, result);
        return result;
    };
}

function expensiveOperation(n) {
    let result = 0;
    for (let i = 0; i < n * 100000; i++) {
        result += i;
    }
    return result;
}

let cachedOperation = withCache(expensiveOperation);
cachedOperation(10);
cachedOperation(10);  // Uses cache
```

**Expected Output**:
```
=== Structural Patterns Practice ===

=== Module Pattern ===
Calculator history: [array]
Users: [array]

=== Facade Pattern ===
CPU starting...
Memory loading...
Hard drive reading...
Computer started

=== Decorator Pattern ===
Coffee description: Coffee, Milk, Sugar
Coffee cost: 6.5
Calling add with: [2, 3]
Result: 5
add took [time]ms
Cache miss
Cache hit
```

**Challenge (Optional)**:
- Build a complete application using all three patterns
- Create a plugin system
- Build a middleware system
- Practice combining patterns

---

## Common Mistakes

### 1. Exposing Private Members

```javascript
// ⚠️ Problem: Private members exposed
const Module = (function() {
    let private = 'secret';
    return {
        private: private  // Exposed!
    };
})();

// ✅ Solution: Keep private
const Module = (function() {
    let private = 'secret';
    return {
        getPrivate: function() {
            return private;  // Controlled access
        }
    };
})();
```

### 2. Facade Too Complex

```javascript
// ⚠️ Problem: Facade is too complex
class Facade {
    // Too many responsibilities
}

// ✅ Solution: Keep facade simple
class Facade {
    // Simple interface to complex system
}
```

### 3. Decorator Not Preserving Interface

```javascript
// ⚠️ Problem: Changes interface
class Decorator {
    newMethod() { }  // Adds new method
}

// ✅ Solution: Preserve interface
class Decorator {
    // Same interface as decorated object
}
```

---

## Key Takeaways

1. **Module**: Encapsulate private and public members
2. **Facade**: Simplify complex interfaces
3. **Decorator**: Add behavior dynamically
4. **When to Use**: Choose based on organization needs
5. **Best Practice**: Keep patterns simple and focused
6. **Privacy**: Use closures or private fields for privacy
7. **Interface**: Decorators should preserve interface

---

## Quiz: Structural Patterns

Test your understanding with these questions:

1. **Module pattern provides:**
   - A) Public members only
   - B) Private and public members
   - C) No members
   - D) Random

2. **Facade pattern:**
   - A) Simplifies interface
   - B) Complicates interface
   - C) Removes interface
   - D) Nothing

3. **Decorator pattern:**
   - A) Adds behavior
   - B) Removes behavior
   - C) Modifies structure
   - D) Nothing

4. **Module uses:**
   - A) Closures
   - B) Classes only
   - C) Functions only
   - D) Nothing

5. **Facade hides:**
   - A) Complexity
   - B) Simplicity
   - C) Nothing
   - D) Everything

6. **Decorator preserves:**
   - A) Interface
   - B) Implementation
   - C) Both
   - D) Neither

7. **Structural patterns help:**
   - A) Code organization
   - B) Code destruction
   - C) Code modification
   - D) Nothing

**Answers**:
1. B) Private and public members
2. A) Simplifies interface
3. A) Adds behavior
4. A) Closures
5. A) Complexity
6. A) Interface
7. A) Code organization

---

## Next Steps

Congratulations! You've learned structural patterns. You now know:
- How to create modules
- How to build facades
- How to implement decorators
- When to use each pattern

**What's Next?**
- Lesson 19.3: Behavioral Patterns
- Learn Observer pattern
- Understand Strategy pattern
- Work with Command pattern

---

## Additional Resources

- **MDN: Closures**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Closures](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Closures)
- **Design Patterns**: [refactoring.guru/design-patterns](https://refactoring.guru/design-patterns)

---

*Lesson completed! You're ready to move on to the next lesson.*

