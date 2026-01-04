# Lesson 6.1: Object-Oriented Basics

## Learning Objectives

By the end of this lesson, you will be able to:
- Create objects using constructor functions
- Understand prototypes and the prototype chain
- Use the instanceof operator to check object types
- Add methods to prototypes
- Understand how JavaScript implements inheritance
- Work with constructor patterns

---

## Introduction to Object-Oriented Programming

Object-Oriented Programming (OOP) is a programming paradigm that organizes code around objects and classes. JavaScript uses prototypes for OOP, which is different from class-based languages but equally powerful.

### Key OOP Concepts

- **Encapsulation**: Bundling data and methods together
- **Inheritance**: Objects can inherit properties and methods
- **Polymorphism**: Different objects can respond to the same method
- **Abstraction**: Hiding complex implementation details

---

## Constructor Functions

Constructor functions are used to create multiple objects with the same structure. They're like blueprints for creating objects.

### Basic Constructor

```javascript
function Person(name, age) {
    this.name = name;
    this.age = age;
}

let person1 = new Person("Alice", 25);
let person2 = new Person("Bob", 30);

console.log(person1);  // Person { name: "Alice", age: 25 }
console.log(person2);  // Person { name: "Bob", age: 30 }
```

### The `new` Keyword

The `new` keyword does several things:
1. Creates a new empty object
2. Sets `this` to point to the new object
3. Executes the constructor function
4. Returns the new object (unless constructor returns something else)

```javascript
function Person(name) {
    this.name = name;
}

let person = new Person("Alice");
// What happens:
// 1. New object created: {}
// 2. this = {}
// 3. this.name = "Alice"
// 4. Return { name: "Alice" }
```

### Constructor Naming Convention

Constructor functions are typically named with PascalCase (first letter uppercase):

```javascript
// ✅ Good: PascalCase
function Person(name) { }
function Car(brand) { }
function User(email) { }

// ❌ Avoid: camelCase (confusing)
function person(name) { }
```

### Adding Methods

You can add methods inside the constructor:

```javascript
function Person(name, age) {
    this.name = name;
    this.age = age;
    
    this.greet = function() {
        return `Hello, I'm ${this.name}`;
    };
    
    this.haveBirthday = function() {
        this.age++;
        return `Happy birthday! Now I'm ${this.age}`;
    };
}

let person = new Person("Alice", 25);
console.log(person.greet());        // "Hello, I'm Alice"
console.log(person.haveBirthday()); // "Happy birthday! Now I'm 26"
```

**⚠️ Problem**: Each instance gets its own copy of methods (memory inefficient).

**✅ Better**: Add methods to prototype (covered next).

### Constructor Examples

```javascript
// Car constructor
function Car(brand, model, year) {
    this.brand = brand;
    this.model = model;
    this.year = year;
    this.isRunning = false;
    
    this.start = function() {
        this.isRunning = true;
        return `${this.brand} ${this.model} started`;
    };
    
    this.stop = function() {
        this.isRunning = false;
        return `${this.brand} ${this.model} stopped`;
    };
}

let car1 = new Car("Toyota", "Camry", 2020);
let car2 = new Car("Honda", "Civic", 2021);

console.log(car1.start());  // "Toyota Camry started"
console.log(car2.start());  // "Honda Civic started"
```

### Constructor Return Value

If constructor returns an object, that object is used instead:

```javascript
function Person(name) {
    this.name = name;
    return { custom: "object" };  // Returns this instead
}

let person = new Person("Alice");
console.log(person);  // { custom: "object" } (not Person instance)
```

**Best Practice**: Don't return values from constructors (except `this`).

---

## Prototypes

Every JavaScript object has a prototype. The prototype is an object that other objects can inherit properties and methods from.

### Understanding Prototypes

```javascript
function Person(name) {
    this.name = name;
}

let person = new Person("Alice");
console.log(person.__proto__);  // Person.prototype
```

### Adding Methods to Prototype

This is more memory-efficient - all instances share the same method:

```javascript
function Person(name, age) {
    this.name = name;
    this.age = age;
}

// Add method to prototype
Person.prototype.greet = function() {
    return `Hello, I'm ${this.name}`;
};

Person.prototype.haveBirthday = function() {
    this.age++;
    return `Happy birthday! Now I'm ${this.age}`;
};

let person1 = new Person("Alice", 25);
let person2 = new Person("Bob", 30);

console.log(person1.greet());  // "Hello, I'm Alice"
console.log(person2.greet());  // "Hello, I'm Bob"

// Both instances share the same method (memory efficient)
console.log(person1.greet === person2.greet);  // true
```

### Prototype Properties

You can also add properties to prototype:

```javascript
function Person(name) {
    this.name = name;
}

Person.prototype.species = "Homo sapiens";

let person = new Person("Alice");
console.log(person.species);  // "Homo sapiens"
```

### Accessing Prototype

```javascript
function Person(name) {
    this.name = name;
}

Person.prototype.greet = function() {
    return `Hello, I'm ${this.name}`;
};

let person = new Person("Alice");

// Access prototype
console.log(Person.prototype);
console.log(Object.getPrototypeOf(person));
console.log(person.__proto__);  // Deprecated but works
```

### Prototype Methods vs Instance Methods

**Instance methods** (in constructor):
```javascript
function Person(name) {
    this.name = name;
    this.greet = function() {
        return `Hello, I'm ${this.name}`;
    };
}
// Each instance has its own copy
```

**Prototype methods** (on prototype):
```javascript
function Person(name) {
    this.name = name;
}
Person.prototype.greet = function() {
    return `Hello, I'm ${this.name}`;
};
// All instances share the same method
```

**Best Practice**: Use prototype methods for shared functionality.

---

## Prototype Chain

The prototype chain is how JavaScript implements inheritance. When you access a property, JavaScript looks up the chain until it finds it.

### How Prototype Chain Works

```javascript
function Person(name) {
    this.name = name;
}

Person.prototype.species = "Homo sapiens";

let person = new Person("Alice");

// JavaScript looks for 'species':
// 1. Check person object → not found
// 2. Check Person.prototype → found! "Homo sapiens"
console.log(person.species);  // "Homo sapiens"
```

### Chain Visualization

```
person
  ├─ name: "Alice" (own property)
  └─ __proto__ → Person.prototype
       ├─ species: "Homo sapiens"
       ├─ greet: function()
       └─ __proto__ → Object.prototype
            ├─ toString: function()
            ├─ valueOf: function()
            └─ __proto__ → null
```

### Property Lookup

```javascript
function Person(name) {
    this.name = name;
}

Person.prototype.species = "Homo sapiens";
Object.prototype.planet = "Earth";

let person = new Person("Alice");

console.log(person.name);    // "Alice" (own property)
console.log(person.species); // "Homo sapiens" (from Person.prototype)
console.log(person.planet);  // "Earth" (from Object.prototype)
console.log(person.toString); // function (from Object.prototype)
```

### hasOwnProperty()

Check if property belongs to object itself (not prototype):

```javascript
function Person(name) {
    this.name = name;
}

Person.prototype.species = "Homo sapiens";

let person = new Person("Alice");

console.log(person.hasOwnProperty("name"));    // true (own property)
console.log(person.hasOwnProperty("species")); // false (from prototype)
```

### Checking Prototype Chain

```javascript
function Person(name) {
    this.name = name;
}

Person.prototype.species = "Homo sapiens";

let person = new Person("Alice");

// Check if property exists (anywhere in chain)
console.log("name" in person);     // true
console.log("species" in person);  // true
console.log("toString" in person); // true

// Check if own property
console.log(person.hasOwnProperty("name"));     // true
console.log(person.hasOwnProperty("species"));   // false
console.log(person.hasOwnProperty("toString"));  // false
```

---

## instanceof Operator

The `instanceof` operator checks if an object is an instance of a constructor function.

### Basic Usage

```javascript
function Person(name) {
    this.name = name;
}

let person = new Person("Alice");

console.log(person instanceof Person);  // true
console.log(person instanceof Object);   // true (all objects inherit from Object)
```

### How instanceof Works

`instanceof` checks the prototype chain:

```javascript
function Person(name) {
    this.name = name;
}

let person = new Person("Alice");

// Checks if Person.prototype is in person's prototype chain
console.log(person instanceof Person);  // true
```

### Examples

```javascript
function Car(brand) {
    this.brand = brand;
}

function Truck(brand) {
    this.brand = brand;
}

let car = new Car("Toyota");
let truck = new Truck("Ford");

console.log(car instanceof Car);     // true
console.log(car instanceof Truck);   // false
console.log(car instanceof Object);  // true
```

### Arrays and instanceof

```javascript
let arr = [1, 2, 3];

console.log(arr instanceof Array);   // true
console.log(arr instanceof Object);  // true
```

### Functions and instanceof

```javascript
function myFunction() { }

console.log(myFunction instanceof Function);  // true
console.log(myFunction instanceof Object);   // true
```

### Using instanceof for Type Checking

```javascript
function processVehicle(vehicle) {
    if (vehicle instanceof Car) {
        console.log("Processing car");
    } else if (vehicle instanceof Truck) {
        console.log("Processing truck");
    } else {
        console.log("Unknown vehicle type");
    }
}
```

---

## Complete Example

### Person Constructor with Prototype

```javascript
// Constructor
function Person(firstName, lastName, age) {
    this.firstName = firstName;
    this.lastName = lastName;
    this.age = age;
}

// Prototype methods
Person.prototype.getFullName = function() {
    return `${this.firstName} ${this.lastName}`;
};

Person.prototype.haveBirthday = function() {
    this.age++;
    return `Happy birthday! Now I'm ${this.age}`;
};

Person.prototype.introduce = function() {
    return `Hi, I'm ${this.getFullName()} and I'm ${this.age} years old`;
};

// Prototype property
Person.prototype.species = "Homo sapiens";

// Usage
let person1 = new Person("Alice", "Smith", 25);
let person2 = new Person("Bob", "Jones", 30);

console.log(person1.getFullName());     // "Alice Smith"
console.log(person1.introduce());        // "Hi, I'm Alice Smith and I'm 25 years old"
console.log(person2.introduce());        // "Hi, I'm Bob Jones and I'm 30 years old"
console.log(person1.species);            // "Homo sapiens"
console.log(person1 instanceof Person);  // true
```

### Car Constructor Example

```javascript
function Car(brand, model, year) {
    this.brand = brand;
    this.model = model;
    this.year = year;
    this.speed = 0;
    this.isRunning = false;
}

Car.prototype.start = function() {
    this.isRunning = true;
    return `${this.brand} ${this.model} started`;
};

Car.prototype.stop = function() {
    this.isRunning = false;
    this.speed = 0;
    return `${this.brand} ${this.model} stopped`;
};

Car.prototype.accelerate = function(amount) {
    if (this.isRunning) {
        this.speed += amount;
        return `Speed: ${this.speed} mph`;
    }
    return "Car is not running";
};

Car.prototype.getInfo = function() {
    return `${this.year} ${this.brand} ${this.model}`;
};

// Usage
let car = new Car("Toyota", "Camry", 2020);
console.log(car.start());           // "Toyota Camry started"
console.log(car.accelerate(30));    // "Speed: 30 mph"
console.log(car.accelerate(20));    // "Speed: 50 mph"
console.log(car.getInfo());         // "2020 Toyota Camry"
console.log(car.stop());            // "Toyota Camry stopped"
```

---

## Practice Exercise

### Exercise: Creating Objects with Constructors

**Objective**: Create constructor functions and use prototypes to build object-oriented code.

**Instructions**:

1. Create a file called `oop-basics.js`

2. Create constructor functions for:
   - Book (title, author, year, pages)
   - BankAccount (accountNumber, balance)
   - Student (name, age, grade)

3. Add prototype methods for each:
   - Book: getInfo(), isLong() (pages > 300)
   - BankAccount: deposit(), withdraw(), getBalance()
   - Student: introduce(), promote() (increase grade)

4. Test with instanceof operator

5. Demonstrate prototype chain

**Example Solution**:

```javascript
// OOP Basics Practice
console.log("=== Book Constructor ===");

function Book(title, author, year, pages) {
    this.title = title;
    this.author = author;
    this.year = year;
    this.pages = pages;
}

Book.prototype.getInfo = function() {
    return `${this.title} by ${this.author} (${this.year})`;
};

Book.prototype.isLong = function() {
    return this.pages > 300;
};

Book.prototype.getSummary = function() {
    return `${this.title} is a ${this.pages}-page book written by ${this.author} in ${this.year}`;
};

let book1 = new Book("1984", "George Orwell", 1949, 328);
let book2 = new Book("The Great Gatsby", "F. Scott Fitzgerald", 1925, 180);

console.log(book1.getInfo());        // "1984 by George Orwell (1949)"
console.log(book1.isLong());         // true
console.log(book2.isLong());         // false
console.log(book1.getSummary());
console.log("Instanceof Book:", book1 instanceof Book);  // true
console.log();

console.log("=== BankAccount Constructor ===");

function BankAccount(accountNumber, initialBalance = 0) {
    this.accountNumber = accountNumber;
    this.balance = initialBalance;
    this.transactions = [];
}

BankAccount.prototype.deposit = function(amount) {
    if (amount > 0) {
        this.balance += amount;
        this.transactions.push({ type: "deposit", amount, balance: this.balance });
        return `Deposited $${amount}. New balance: $${this.balance}`;
    }
    return "Invalid deposit amount";
};

BankAccount.prototype.withdraw = function(amount) {
    if (amount > 0 && amount <= this.balance) {
        this.balance -= amount;
        this.transactions.push({ type: "withdraw", amount, balance: this.balance });
        return `Withdrew $${amount}. New balance: $${this.balance}`;
    }
    return amount > this.balance ? "Insufficient funds" : "Invalid withdrawal amount";
};

BankAccount.prototype.getBalance = function() {
    return `Account ${this.accountNumber}: $${this.balance}`;
};

BankAccount.prototype.getTransactionHistory = function() {
    return this.transactions;
};

let account1 = new BankAccount("ACC001", 1000);
let account2 = new BankAccount("ACC002", 500);

console.log(account1.getBalance());        // "Account ACC001: $1000"
console.log(account1.deposit(500));        // "Deposited $500. New balance: $1500"
console.log(account1.withdraw(200));       // "Withdrew $200. New balance: $1300"
console.log(account1.withdraw(2000));      // "Insufficient funds"
console.log("Instanceof BankAccount:", account1 instanceof BankAccount);  // true
console.log();

console.log("=== Student Constructor ===");

function Student(name, age, grade) {
    this.name = name;
    this.age = age;
    this.grade = grade;
    this.subjects = [];
}

Student.prototype.introduce = function() {
    return `Hi, I'm ${this.name}, ${this.age} years old, in grade ${this.grade}`;
};

Student.prototype.promote = function() {
    this.grade++;
    return `Promoted to grade ${this.grade}`;
};

Student.prototype.addSubject = function(subject) {
    this.subjects.push(subject);
    return `Added ${subject} to subjects`;
};

Student.prototype.getSubjects = function() {
    return this.subjects.length > 0 
        ? `${this.name}'s subjects: ${this.subjects.join(", ")}`
        : `${this.name} has no subjects yet`;
};

let student1 = new Student("Alice", 15, 9);
let student2 = new Student("Bob", 16, 10);

console.log(student1.introduce());         // "Hi, I'm Alice, 15 years old, in grade 9"
console.log(student1.promote());          // "Promoted to grade 10"
student1.addSubject("Math");
student1.addSubject("Science");
console.log(student1.getSubjects());       // "Alice's subjects: Math, Science"
console.log("Instanceof Student:", student1 instanceof Student);  // true
console.log();

console.log("=== Prototype Chain Demonstration ===");

function Person(name) {
    this.name = name;
}

Person.prototype.species = "Homo sapiens";
Object.prototype.planet = "Earth";

let person = new Person("Alice");

console.log("Own property 'name':", person.hasOwnProperty("name"));        // true
console.log("Own property 'species':", person.hasOwnProperty("species"));   // false
console.log("Own property 'planet':", person.hasOwnProperty("planet"));    // false
console.log("Own property 'toString':", person.hasOwnProperty("toString")); // false

console.log("'name' in person:", "name" in person);         // true
console.log("'species' in person:", "species" in person);     // true
console.log("'planet' in person:", "planet" in person);      // true
console.log("'toString' in person:", "toString" in person);   // true

console.log("person.name:", person.name);           // "Alice"
console.log("person.species:", person.species);     // "Homo sapiens"
console.log("person.planet:", person.planet);       // "Earth"
console.log();

console.log("=== instanceof Examples ===");

let book = new Book("Test", "Author", 2020, 100);
let account = new BankAccount("ACC003", 100);
let student = new Student("Charlie", 14, 8);

console.log("book instanceof Book:", book instanceof Book);           // true
console.log("book instanceof Object:", book instanceof Object);      // true
console.log("account instanceof BankAccount:", account instanceof BankAccount); // true
console.log("student instanceof Student:", student instanceof Student);         // true
console.log("student instanceof Object:", student instanceof Object);          // true

// All objects are instances of Object
console.log("All are Object instances:");
console.log(book instanceof Object);     // true
console.log(account instanceof Object);  // true
console.log(student instanceof Object);   // true
```

**Expected Output**:
```
=== Book Constructor ===
1984 by George Orwell (1949)
true
false
1984 is a 328-page book written by George Orwell in 1949
Instanceof Book: true

=== BankAccount Constructor ===
Account ACC001: $1000
Deposited $500. New balance: $1500
Withdrew $200. New balance: $1300
Insufficient funds
Instanceof BankAccount: true

=== Student Constructor ===
Hi, I'm Alice, 15 years old, in grade 9
Promoted to grade 10
Alice's subjects: Math, Science
Instanceof Student: true

=== Prototype Chain Demonstration ===
Own property 'name': true
Own property 'species': false
Own property 'planet': false
Own property 'toString': false
'name' in person: true
'species' in person: true
'planet' in person: true
'toString' in person: true
person.name: Alice
person.species: Homo sapiens
person.planet: Earth

=== instanceof Examples ===
book instanceof Book: true
book instanceof Object: true
account instanceof BankAccount: true
student instanceof Student: true
student instanceof Object: true
All are Object instances:
true
true
true
```

**Challenge (Optional)**:
- Create a library management system
- Build a game with multiple character types
- Create a shape hierarchy (Circle, Rectangle, etc.)
- Build a vehicle system (Car, Truck, Motorcycle)

---

## Common Mistakes

### 1. Forgetting `new` Keyword

```javascript
// ❌ Wrong: this refers to global/window
function Person(name) {
    this.name = name;
}
let person = Person("Alice");  // No 'new'
console.log(person);  // undefined
console.log(name);    // "Alice" (global variable!)

// ✅ Correct
let person = new Person("Alice");
```

### 2. Methods in Constructor (Memory Inefficient)

```javascript
// ⚠️ Each instance gets its own copy
function Person(name) {
    this.name = name;
    this.greet = function() { };  // New function for each instance
}

// ✅ Better: Use prototype
function Person(name) {
    this.name = name;
}
Person.prototype.greet = function() { };  // Shared method
```

### 3. Modifying Prototype After Creation

```javascript
function Person(name) {
    this.name = name;
}

let person = new Person("Alice");

// Adding to prototype after creation still works
Person.prototype.greet = function() {
    return "Hello!";
};

console.log(person.greet());  // "Hello!" (works!)
```

### 4. Confusing hasOwnProperty and `in`

```javascript
function Person(name) {
    this.name = name;
}
Person.prototype.species = "Homo sapiens";

let person = new Person("Alice");

console.log("name" in person);     // true (anywhere in chain)
console.log("species" in person);  // true (anywhere in chain)

console.log(person.hasOwnProperty("name"));     // true (own property)
console.log(person.hasOwnProperty("species"));  // false (from prototype)
```

### 5. Prototype vs __proto__

```javascript
// __proto__ is deprecated but works
let person = new Person("Alice");
console.log(person.__proto__);  // Person.prototype

// ✅ Better: Use Object.getPrototypeOf()
console.log(Object.getPrototypeOf(person));  // Person.prototype
```

---

## Key Takeaways

1. **Constructor Functions**: Create objects with `new` keyword
2. **Prototypes**: Shared object for methods and properties
3. **Prototype Chain**: JavaScript looks up properties through chain
4. **instanceof**: Checks if object is instance of constructor
5. **hasOwnProperty()**: Checks if property is own (not from prototype)
6. **Best Practice**: Use prototype methods for shared functionality
7. **Memory Efficiency**: Prototype methods are shared, constructor methods are not

---

## Quiz: OOP Basics

Test your understanding with these questions:

1. **What does `new` keyword do?**
   - A) Creates new function
   - B) Creates new object and sets this
   - C) Deletes object
   - D) Nothing

2. **Where should shared methods be placed?**
   - A) In constructor
   - B) On prototype
   - C) Outside function
   - D) Doesn't matter

3. **What does `instanceof` check?**
   - A) Property existence
   - B) Prototype chain
   - C) Value type
   - D) Object equality

4. **What does `hasOwnProperty()` check?**
   - A) If property exists in prototype chain
   - B) If property is own property
   - C) If property is a function
   - D) If property is undefined

5. **Prototype chain ends at:**
   - A) Object.prototype
   - B) null
   - C) Function.prototype
   - D) Array.prototype

6. **What happens if you forget `new`?**
   - A) Error
   - B) `this` refers to global
   - C) Returns undefined
   - D) Both B and C

7. **All objects inherit from:**
   - A) Function
   - B) Array
   - C) Object
   - D) String

**Answers**:
1. B) Creates new object and sets this
2. B) On prototype
3. B) Prototype chain
4. B) If property is own property
5. B) null (Object.prototype.__proto__ is null)
6. D) Both B and C
7. C) Object

---

## Next Steps

Congratulations! You've learned object-oriented basics. You now know:
- How to create constructor functions
- How prototypes work
- How the prototype chain functions
- How to use instanceof

**What's Next?**
- Lesson 6.2: Classes (ES6)
- Practice with constructor patterns
- Understand prototype inheritance
- Build more complex object hierarchies

---

## Additional Resources

- **MDN: Object-oriented JavaScript**: [developer.mozilla.org/en-US/docs/Learn/JavaScript/Objects/Object-oriented_JS](https://developer.mozilla.org/en-US/docs/Learn/JavaScript/Objects/Object-oriented_JS)
- **MDN: instanceof**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/instanceof](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/instanceof)
- **JavaScript.info: Prototypes**: [javascript.info/prototype-inheritance](https://javascript.info/prototype-inheritance)
- **JavaScript.info: Constructor Functions**: [javascript.info/constructor-new](https://javascript.info/constructor-new)

---

*Lesson completed! You're ready to move on to the next lesson.*

