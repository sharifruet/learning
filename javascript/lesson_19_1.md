# Lesson 19.1: Creational Patterns

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand creational design patterns
- Implement the Singleton pattern
- Implement the Factory pattern
- Implement the Builder pattern
- Choose appropriate patterns
- Apply patterns to solve problems
- Build reusable object creation solutions

---

## Introduction to Creational Patterns

Creational patterns provide ways to create objects while hiding the creation logic.

### Why Creational Patterns?

- **Flexibility**: Control how objects are created
- **Reusability**: Reuse object creation logic
- **Maintainability**: Centralize creation logic
- **Testability**: Easier to test and mock
- **Best Practices**: Proven solutions to common problems
- **Code Quality**: Better organized code

### Common Creational Patterns

1. **Singleton**: Single instance
2. **Factory**: Create objects without specifying exact class
3. **Builder**: Construct complex objects step by step

---

## Singleton Pattern

### What is Singleton?

Singleton ensures a class has only one instance and provides global access.

### Basic Singleton

```javascript
class Singleton {
    constructor() {
        if (Singleton.instance) {
            return Singleton.instance;
        }
        Singleton.instance = this;
        return this;
    }
}

let instance1 = new Singleton();
let instance2 = new Singleton();
console.log(instance1 === instance2);  // true
```

### Singleton with Private Constructor

```javascript
class Singleton {
    static instance = null;
    
    constructor() {
        if (Singleton.instance) {
            return Singleton.instance;
        }
        Singleton.instance = this;
    }
    
    static getInstance() {
        if (!Singleton.instance) {
            Singleton.instance = new Singleton();
        }
        return Singleton.instance;
    }
}

let instance1 = Singleton.getInstance();
let instance2 = Singleton.getInstance();
console.log(instance1 === instance2);  // true
```

### Singleton with Module Pattern

```javascript
const Singleton = (function() {
    let instance;
    
    function createInstance() {
        return {
            data: 'Singleton data',
            getData: function() {
                return this.data;
            }
        };
    }
    
    return {
        getInstance: function() {
            if (!instance) {
                instance = createInstance();
            }
            return instance;
        }
    };
})();

let instance1 = Singleton.getInstance();
let instance2 = Singleton.getInstance();
console.log(instance1 === instance2);  // true
```

### Practical Singleton Example

```javascript
class DatabaseConnection {
    static instance = null;
    
    constructor() {
        if (DatabaseConnection.instance) {
            return DatabaseConnection.instance;
        }
        
        this.connection = this.connect();
        DatabaseConnection.instance = this;
    }
    
    connect() {
        console.log('Connecting to database...');
        // Simulate connection
        return { connected: true };
    }
    
    query(sql) {
        console.log('Executing query:', sql);
        return { results: [] };
    }
    
    static getInstance() {
        if (!DatabaseConnection.instance) {
            DatabaseConnection.instance = new DatabaseConnection();
        }
        return DatabaseConnection.instance;
    }
}

// Usage
let db1 = DatabaseConnection.getInstance();
let db2 = DatabaseConnection.getInstance();
console.log(db1 === db2);  // true
```

---

## Factory Pattern

### What is Factory?

Factory creates objects without specifying the exact class.

### Basic Factory

```javascript
class Car {
    constructor(type) {
        this.type = type;
    }
}

class Truck {
    constructor(type) {
        this.type = type;
    }
}

class VehicleFactory {
    createVehicle(type) {
        switch(type) {
            case 'car':
                return new Car('car');
            case 'truck':
                return new Truck('truck');
            default:
                throw new Error('Unknown vehicle type');
        }
    }
}

let factory = new VehicleFactory();
let car = factory.createVehicle('car');
let truck = factory.createVehicle('truck');
```

### Factory with Classes

```javascript
class Shape {
    draw() {
        throw new Error('Method must be implemented');
    }
}

class Circle extends Shape {
    draw() {
        console.log('Drawing circle');
    }
}

class Rectangle extends Shape {
    draw() {
        console.log('Drawing rectangle');
    }
}

class ShapeFactory {
    createShape(type) {
        switch(type) {
            case 'circle':
                return new Circle();
            case 'rectangle':
                return new Rectangle();
            default:
                throw new Error('Unknown shape type');
        }
    }
}

let factory = new ShapeFactory();
let circle = factory.createShape('circle');
let rectangle = factory.createShape('rectangle');
circle.draw();      // Drawing circle
rectangle.draw();  // Drawing rectangle
```

### Factory Function

```javascript
function createUser(type, name) {
    switch(type) {
        case 'admin':
            return {
                name: name,
                role: 'admin',
                permissions: ['read', 'write', 'delete']
            };
        case 'user':
            return {
                name: name,
                role: 'user',
                permissions: ['read']
            };
        default:
            throw new Error('Unknown user type');
    }
}

let admin = createUser('admin', 'Alice');
let user = createUser('user', 'Bob');
```

### Practical Factory Example

```javascript
class NotificationFactory {
    createNotification(type, message) {
        switch(type) {
            case 'email':
                return new EmailNotification(message);
            case 'sms':
                return new SMSNotification(message);
            case 'push':
                return new PushNotification(message);
            default:
                throw new Error('Unknown notification type');
        }
    }
}

class EmailNotification {
    constructor(message) {
        this.message = message;
        this.type = 'email';
    }
    
    send() {
        console.log('Sending email:', this.message);
    }
}

class SMSNotification {
    constructor(message) {
        this.message = message;
        this.type = 'sms';
    }
    
    send() {
        console.log('Sending SMS:', this.message);
    }
}

class PushNotification {
    constructor(message) {
        this.message = message;
        this.type = 'push';
    }
    
    send() {
        console.log('Sending push notification:', this.message);
    }
}

// Usage
let factory = new NotificationFactory();
let email = factory.createNotification('email', 'Hello');
let sms = factory.createNotification('sms', 'Hello');
email.send();
sms.send();
```

---

## Builder Pattern

### What is Builder?

Builder constructs complex objects step by step.

### Basic Builder

```javascript
class PizzaBuilder {
    constructor() {
        this.pizza = {};
    }
    
    setSize(size) {
        this.pizza.size = size;
        return this;
    }
    
    setCrust(crust) {
        this.pizza.crust = crust;
        return this;
    }
    
    addTopping(topping) {
        if (!this.pizza.toppings) {
            this.pizza.toppings = [];
        }
        this.pizza.toppings.push(topping);
        return this;
    }
    
    build() {
        return this.pizza;
    }
}

// Usage
let pizza = new PizzaBuilder()
    .setSize('large')
    .setCrust('thin')
    .addTopping('pepperoni')
    .addTopping('cheese')
    .build();
```

### Builder with Validation

```javascript
class UserBuilder {
    constructor() {
        this.user = {};
    }
    
    setName(name) {
        if (!name || name.trim() === '') {
            throw new Error('Name is required');
        }
        this.user.name = name;
        return this;
    }
    
    setEmail(email) {
        if (!email || !email.includes('@')) {
            throw new Error('Valid email is required');
        }
        this.user.email = email;
        return this;
    }
    
    setAge(age) {
        if (age < 0 || age > 150) {
            throw new Error('Invalid age');
        }
        this.user.age = age;
        return this;
    }
    
    build() {
        if (!this.user.name || !this.user.email) {
            throw new Error('Name and email are required');
        }
        return this.user;
    }
}

// Usage
let user = new UserBuilder()
    .setName('Alice')
    .setEmail('alice@example.com')
    .setAge(30)
    .build();
```

### Builder with Director

```javascript
class QueryBuilder {
    constructor() {
        this.query = {
            select: [],
            from: '',
            where: [],
            orderBy: []
        };
    }
    
    select(fields) {
        this.query.select = Array.isArray(fields) ? fields : [fields];
        return this;
    }
    
    from(table) {
        this.query.from = table;
        return this;
    }
    
    where(condition) {
        this.query.where.push(condition);
        return this;
    }
    
    orderBy(field, direction = 'ASC') {
        this.query.orderBy.push({ field, direction });
        return this;
    }
    
    build() {
        let sql = 'SELECT ' + this.query.select.join(', ');
        sql += ' FROM ' + this.query.from;
        
        if (this.query.where.length > 0) {
            sql += ' WHERE ' + this.query.where.join(' AND ');
        }
        
        if (this.query.orderBy.length > 0) {
            let order = this.query.orderBy.map(o => `${o.field} ${o.direction}`).join(', ');
            sql += ' ORDER BY ' + order;
        }
        
        return sql;
    }
}

// Usage
let query = new QueryBuilder()
    .select(['name', 'email'])
    .from('users')
    .where('age > 18')
    .where('active = true')
    .orderBy('name', 'ASC')
    .build();

console.log(query);
// SELECT name, email FROM users WHERE age > 18 AND active = true ORDER BY name ASC
```

### Practical Builder Example

```javascript
class HTTPRequestBuilder {
    constructor() {
        this.request = {
            method: 'GET',
            url: '',
            headers: {},
            body: null
        };
    }
    
    method(method) {
        this.request.method = method.toUpperCase();
        return this;
    }
    
    url(url) {
        this.request.url = url;
        return this;
    }
    
    header(key, value) {
        this.request.headers[key] = value;
        return this;
    }
    
    body(data) {
        this.request.body = JSON.stringify(data);
        this.header('Content-Type', 'application/json');
        return this;
    }
    
    build() {
        return this.request;
    }
    
    async execute() {
        return fetch(this.request.url, {
            method: this.request.method,
            headers: this.request.headers,
            body: this.request.body
        });
    }
}

// Usage
let request = new HTTPRequestBuilder()
    .method('POST')
    .url('/api/users')
    .header('Authorization', 'Bearer token')
    .body({ name: 'Alice', email: 'alice@example.com' })
    .build();
```

---

## Practice Exercise

### Exercise: Creational Patterns

**Objective**: Practice implementing Singleton, Factory, and Builder patterns.

**Instructions**:

1. Create a JavaScript file
2. Practice:
   - Implementing Singleton pattern
   - Creating Factory pattern
   - Building Builder pattern
   - Applying patterns to real problems

**Example Solution**:

```javascript
// creational-patterns-practice.js
console.log("=== Creational Patterns Practice ===");

console.log("\n=== Singleton Pattern ===");

// Basic Singleton
class Singleton {
    static instance = null;
    
    constructor() {
        if (Singleton.instance) {
            return Singleton.instance;
        }
        Singleton.instance = this;
        this.data = 'Singleton data';
    }
    
    static getInstance() {
        if (!Singleton.instance) {
            Singleton.instance = new Singleton();
        }
        return Singleton.instance;
    }
    
    getData() {
        return this.data;
    }
}

let instance1 = Singleton.getInstance();
let instance2 = Singleton.getInstance();
console.log('instance1 === instance2:', instance1 === instance2);  // true
console.log('instance1.getData():', instance1.getData());

// Singleton with Module Pattern
const Config = (function() {
    let instance;
    
    function createInstance() {
        return {
            apiUrl: 'https://api.example.com',
            timeout: 5000,
            getConfig: function() {
                return {
                    apiUrl: this.apiUrl,
                    timeout: this.timeout
                };
            }
        };
    }
    
    return {
        getInstance: function() {
            if (!instance) {
                instance = createInstance();
            }
            return instance;
        }
    };
})();

let config1 = Config.getInstance();
let config2 = Config.getInstance();
console.log('config1 === config2:', config1 === config2);  // true
console.log();

console.log("=== Factory Pattern ===");

// Basic Factory
class VehicleFactory {
    createVehicle(type, brand) {
        switch(type) {
            case 'car':
                return new Car(brand);
            case 'truck':
                return new Truck(brand);
            case 'motorcycle':
                return new Motorcycle(brand);
            default:
                throw new Error('Unknown vehicle type');
        }
    }
}

class Car {
    constructor(brand) {
        this.type = 'car';
        this.brand = brand;
    }
    
    drive() {
        console.log(`Driving ${this.brand} car`);
    }
}

class Truck {
    constructor(brand) {
        this.type = 'truck';
        this.brand = brand;
    }
    
    drive() {
        console.log(`Driving ${this.brand} truck`);
    }
}

class Motorcycle {
    constructor(brand) {
        this.type = 'motorcycle';
        this.brand = brand;
    }
    
    drive() {
        console.log(`Riding ${this.brand} motorcycle`);
    }
}

let factory = new VehicleFactory();
let car = factory.createVehicle('car', 'Toyota');
let truck = factory.createVehicle('truck', 'Ford');
car.drive();
truck.drive();

// Factory Function
function createUser(type, name, email) {
    const userTypes = {
        admin: {
            role: 'admin',
            permissions: ['read', 'write', 'delete', 'manage']
        },
        editor: {
            role: 'editor',
            permissions: ['read', 'write']
        },
        viewer: {
            role: 'viewer',
            permissions: ['read']
        }
    };
    
    const userType = userTypes[type];
    if (!userType) {
        throw new Error('Unknown user type');
    }
    
    return {
        name: name,
        email: email,
        role: userType.role,
        permissions: userType.permissions,
        hasPermission: function(permission) {
            return this.permissions.includes(permission);
        }
    };
}

let admin = createUser('admin', 'Alice', 'alice@example.com');
let viewer = createUser('viewer', 'Bob', 'bob@example.com');
console.log('Admin permissions:', admin.permissions);
console.log('Viewer can write:', viewer.hasPermission('write'));  // false
console.log();

console.log("=== Builder Pattern ===");

// Basic Builder
class PizzaBuilder {
    constructor() {
        this.pizza = {
            size: 'medium',
            crust: 'regular',
            toppings: []
        };
    }
    
    setSize(size) {
        this.pizza.size = size;
        return this;
    }
    
    setCrust(crust) {
        this.pizza.crust = crust;
        return this;
    }
    
    addTopping(topping) {
        this.pizza.toppings.push(topping);
        return this;
    }
    
    build() {
        return this.pizza;
    }
}

let pizza = new PizzaBuilder()
    .setSize('large')
    .setCrust('thin')
    .addTopping('pepperoni')
    .addTopping('cheese')
    .addTopping('mushrooms')
    .build();

console.log('Pizza:', pizza);

// Builder with Validation
class UserBuilder {
    constructor() {
        this.user = {};
    }
    
    setName(name) {
        if (!name || name.trim() === '') {
            throw new Error('Name is required');
        }
        this.user.name = name;
        return this;
    }
    
    setEmail(email) {
        if (!email || !email.includes('@')) {
            throw new Error('Valid email is required');
        }
        this.user.email = email;
        return this;
    }
    
    setAge(age) {
        if (age < 0 || age > 150) {
            throw new Error('Invalid age');
        }
        this.user.age = age;
        return this;
    }
    
    setAddress(address) {
        this.user.address = address;
        return this;
    }
    
    build() {
        if (!this.user.name || !this.user.email) {
            throw new Error('Name and email are required');
        }
        return this.user;
    }
}

let user = new UserBuilder()
    .setName('Alice')
    .setEmail('alice@example.com')
    .setAge(30)
    .setAddress('123 Main St')
    .build();

console.log('User:', user);

// Query Builder
class QueryBuilder {
    constructor() {
        this.query = {
            select: [],
            from: '',
            where: [],
            orderBy: []
        };
    }
    
    select(fields) {
        this.query.select = Array.isArray(fields) ? fields : [fields];
        return this;
    }
    
    from(table) {
        this.query.from = table;
        return this;
    }
    
    where(condition) {
        this.query.where.push(condition);
        return this;
    }
    
    orderBy(field, direction = 'ASC') {
        this.query.orderBy.push({ field, direction });
        return this;
    }
    
    build() {
        let sql = 'SELECT ' + (this.query.select.length > 0 ? this.query.select.join(', ') : '*');
        sql += ' FROM ' + this.query.from;
        
        if (this.query.where.length > 0) {
            sql += ' WHERE ' + this.query.where.join(' AND ');
        }
        
        if (this.query.orderBy.length > 0) {
            let order = this.query.orderBy.map(o => `${o.field} ${o.direction}`).join(', ');
            sql += ' ORDER BY ' + order;
        }
        
        return sql;
    }
}

let query = new QueryBuilder()
    .select(['name', 'email', 'age'])
    .from('users')
    .where('age >= 18')
    .where('active = true')
    .orderBy('name', 'ASC')
    .build();

console.log('SQL Query:', query);
console.log();

console.log("=== Practical Examples ===");

// Example 1: Logger Singleton
class Logger {
    static instance = null;
    logs = [];
    
    constructor() {
        if (Logger.instance) {
            return Logger.instance;
        }
        Logger.instance = this;
    }
    
    log(message) {
        let logEntry = {
            timestamp: new Date().toISOString(),
            message: message
        };
        this.logs.push(logEntry);
        console.log(`[${logEntry.timestamp}] ${message}`);
    }
    
    getLogs() {
        return this.logs;
    }
    
    static getInstance() {
        if (!Logger.instance) {
            Logger.instance = new Logger();
        }
        return Logger.instance;
    }
}

let logger1 = Logger.getInstance();
let logger2 = Logger.getInstance();
logger1.log('First log');
logger2.log('Second log');
console.log('Logs:', logger1.getLogs());

// Example 2: Notification Factory
class NotificationFactory {
    createNotification(type, message, recipient) {
        switch(type) {
            case 'email':
                return new EmailNotification(message, recipient);
            case 'sms':
                return new SMSNotification(message, recipient);
            case 'push':
                return new PushNotification(message, recipient);
            default:
                throw new Error('Unknown notification type');
        }
    }
}

class EmailNotification {
    constructor(message, recipient) {
        this.type = 'email';
        this.message = message;
        this.recipient = recipient;
    }
    
    send() {
        console.log(`Sending email to ${this.recipient}: ${this.message}`);
    }
}

class SMSNotification {
    constructor(message, recipient) {
        this.type = 'sms';
        this.message = message;
        this.recipient = recipient;
    }
    
    send() {
        console.log(`Sending SMS to ${this.recipient}: ${this.message}`);
    }
}

class PushNotification {
    constructor(message, recipient) {
        this.type = 'push';
        this.message = message;
        this.recipient = recipient;
    }
    
    send() {
        console.log(`Sending push to ${this.recipient}: ${this.message}`);
    }
}

let notificationFactory = new NotificationFactory();
let email = notificationFactory.createNotification('email', 'Hello', 'alice@example.com');
let sms = notificationFactory.createNotification('sms', 'Hello', '1234567890');
email.send();
sms.send();
```

**Expected Output**:
```
=== Creational Patterns Practice ===

=== Singleton Pattern ===
instance1 === instance2: true
instance1.getData(): Singleton data
config1 === config2: true

=== Factory Pattern ===
Driving Toyota car
Driving Ford truck
Admin permissions: ['read', 'write', 'delete', 'manage']
Viewer can write: false

=== Builder Pattern ===
Pizza: { size: 'large', crust: 'thin', toppings: [...] }
User: { name: 'Alice', email: 'alice@example.com', ... }
SQL Query: SELECT name, email, age FROM users WHERE age >= 18 AND active = true ORDER BY name ASC

=== Practical Examples ===
[timestamp] First log
[timestamp] Second log
Logs: [array]
Sending email to alice@example.com: Hello
Sending SMS to 1234567890: Hello
```

**Challenge (Optional)**:
- Build a complete application using all three patterns
- Create a configuration management system
- Build a form builder
- Practice combining patterns

---

## Common Mistakes

### 1. Not Preventing Multiple Instances in Singleton

```javascript
// ⚠️ Problem: Can create multiple instances
class Singleton {
    constructor() {
        // No check
    }
}

// ✅ Solution: Check for existing instance
class Singleton {
    static instance = null;
    constructor() {
        if (Singleton.instance) {
            return Singleton.instance;
        }
        Singleton.instance = this;
    }
}
```

### 2. Factory Without Error Handling

```javascript
// ⚠️ Problem: No error handling
class Factory {
    create(type) {
        switch(type) {
            case 'type1':
                return new Type1();
            // Missing default
        }
    }
}

// ✅ Solution: Handle unknown types
class Factory {
    create(type) {
        switch(type) {
            case 'type1':
                return new Type1();
            default:
                throw new Error('Unknown type');
        }
    }
}
```

### 3. Builder Not Returning this

```javascript
// ⚠️ Problem: Can't chain
class Builder {
    setValue(value) {
        this.value = value;
        // Missing return this
    }
}

// ✅ Solution: Return this for chaining
class Builder {
    setValue(value) {
        this.value = value;
        return this;
    }
}
```

---

## Key Takeaways

1. **Singleton**: Ensures single instance, global access
2. **Factory**: Creates objects without specifying exact class
3. **Builder**: Constructs complex objects step by step
4. **When to Use**: Choose based on problem requirements
5. **Best Practice**: Keep patterns simple, add validation
6. **Chaining**: Builders should return this for method chaining
7. **Error Handling**: Always handle edge cases

---

## Quiz: Creational Patterns

Test your understanding with these questions:

1. **Singleton ensures:**
   - A) Multiple instances
   - B) Single instance
   - C) No instances
   - D) Random instances

2. **Factory pattern:**
   - A) Creates objects
   - B) Destroys objects
   - C) Modifies objects
   - D) Nothing

3. **Builder pattern:**
   - A) Builds step by step
   - B) Builds all at once
   - C) Doesn't build
   - D) Random

4. **Singleton getInstance():**
   - A) Creates new instance always
   - B) Returns existing instance
   - C) Deletes instance
   - D) Nothing

5. **Factory is useful for:**
   - A) Single object
   - B) Multiple object types
   - C) No objects
   - D) Random

6. **Builder methods should:**
   - A) Return this
   - B) Return void
   - C) Return null
   - D) Nothing

7. **Creational patterns help:**
   - A) Object creation
   - B) Object destruction
   - C) Object modification
   - D) Nothing

**Answers**:
1. B) Single instance
2. A) Creates objects
3. A) Builds step by step
4. B) Returns existing instance
5. B) Multiple object types
6. A) Return this
7. A) Object creation

---

## Next Steps

Congratulations! You've learned creational patterns. You now know:
- How to implement Singleton
- How to create Factory pattern
- How to build Builder pattern
- When to use each pattern

**What's Next?**
- Lesson 19.2: Structural Patterns
- Learn Module pattern
- Understand Facade pattern
- Work with Decorator pattern

---

## Additional Resources

- **MDN: Classes**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Classes](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Classes)
- **Design Patterns**: [refactoring.guru/design-patterns](https://refactoring.guru/design-patterns)

---

*Lesson completed! You're ready to move on to the next lesson.*

