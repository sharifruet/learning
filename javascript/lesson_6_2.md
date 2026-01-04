# Lesson 6.2: Classes (ES6)

## Learning Objectives

By the end of this lesson, you will be able to:
- Use ES6 class syntax to create classes
- Understand constructor methods
- Create instance methods
- Use static methods
- Work with class fields
- Understand how classes relate to prototypes
- Write clean, modern object-oriented code

---

## Introduction to ES6 Classes

ES6 introduced the `class` keyword, providing a cleaner syntax for creating objects and handling inheritance. Under the hood, classes are still based on prototypes, but the syntax is more familiar to developers from class-based languages.

### Why Classes?

- Cleaner syntax than constructor functions
- More familiar to developers from other languages
- Better organization
- Built-in support for inheritance
- Still uses prototypes (no performance difference)

---

## Class Syntax

### Basic Class Declaration

```javascript
class Person {
    constructor(name, age) {
        this.name = name;
        this.age = age;
    }
}

let person = new Person("Alice", 25);
console.log(person);  // Person { name: "Alice", age: 25 }
```

### Class vs Constructor Function

**Constructor Function (old way):**
```javascript
function Person(name, age) {
    this.name = name;
    this.age = age;
}
```

**Class (ES6 way):**
```javascript
class Person {
    constructor(name, age) {
        this.name = name;
        this.age = age;
    }
}
```

Both create the same result, but class syntax is cleaner.

---

## Constructor Methods

The `constructor` method is a special method that runs when a new instance is created.

### Basic Constructor

```javascript
class Person {
    constructor(name, age) {
        this.name = name;
        this.age = age;
    }
}

let person = new Person("Alice", 25);
```

### Constructor with Default Values

```javascript
class Person {
    constructor(name, age = 0) {
        this.name = name;
        this.age = age;
    }
}

let person1 = new Person("Alice", 25);
let person2 = new Person("Bob");  // age defaults to 0
```

### Constructor Validation

```javascript
class Person {
    constructor(name, age) {
        if (typeof name !== "string" || name.length === 0) {
            throw new Error("Name must be a non-empty string");
        }
        if (age < 0) {
            throw new Error("Age cannot be negative");
        }
        this.name = name;
        this.age = age;
    }
}
```

### No Constructor

If you don't define a constructor, JavaScript provides an empty one:

```javascript
class Person {
    // No constructor defined
}

let person = new Person();  // Works! Empty object
```

---

## Instance Methods

Instance methods are available on all instances of the class.

### Basic Instance Methods

```javascript
class Person {
    constructor(name, age) {
        this.name = name;
        this.age = age;
    }
    
    greet() {
        return `Hello, I'm ${this.name}`;
    }
    
    haveBirthday() {
        this.age++;
        return `Happy birthday! Now I'm ${this.age}`;
    }
    
    introduce() {
        return `Hi, I'm ${this.name} and I'm ${this.age} years old`;
    }
}

let person = new Person("Alice", 25);
console.log(person.greet());        // "Hello, I'm Alice"
console.log(person.haveBirthday()); // "Happy birthday! Now I'm 26"
console.log(person.introduce());     // "Hi, I'm Alice and I'm 26 years old"
```

### Methods Accessing Properties

```javascript
class Rectangle {
    constructor(width, height) {
        this.width = width;
        this.height = height;
    }
    
    getArea() {
        return this.width * this.height;
    }
    
    getPerimeter() {
        return 2 * (this.width + this.height);
    }
    
    isSquare() {
        return this.width === this.height;
    }
}

let rect = new Rectangle(10, 5);
console.log(rect.getArea());      // 50
console.log(rect.getPerimeter()); // 30
console.log(rect.isSquare());     // false
```

### Methods Modifying State

```javascript
class BankAccount {
    constructor(accountNumber, balance = 0) {
        this.accountNumber = accountNumber;
        this.balance = balance;
    }
    
    deposit(amount) {
        if (amount > 0) {
            this.balance += amount;
            return `Deposited $${amount}. New balance: $${this.balance}`;
        }
        return "Invalid deposit amount";
    }
    
    withdraw(amount) {
        if (amount > 0 && amount <= this.balance) {
            this.balance -= amount;
            return `Withdrew $${amount}. New balance: $${this.balance}`;
        }
        return "Insufficient funds or invalid amount";
    }
    
    getBalance() {
        return this.balance;
    }
}
```

---

## Static Methods

Static methods belong to the class itself, not to instances. They're called on the class, not on instances.

### Basic Static Method

```javascript
class MathUtils {
    static add(a, b) {
        return a + b;
    }
    
    static multiply(a, b) {
        return a * b;
    }
}

// Call on class, not instance
console.log(MathUtils.add(5, 3));        // 8
console.log(MathUtils.multiply(5, 3));   // 15

// ❌ Cannot call on instance
let utils = new MathUtils();
// utils.add(5, 3);  // Error: utils.add is not a function
```

### Static Methods for Utilities

```javascript
class Person {
    constructor(name, age) {
        this.name = name;
        this.age = age;
    }
    
    // Static method to create from object
    static fromObject(obj) {
        return new Person(obj.name, obj.age);
    }
    
    // Static method to compare ages
    static compareAge(person1, person2) {
        return person1.age - person2.age;
    }
    
    // Static method to validate age
    static isValidAge(age) {
        return typeof age === "number" && age >= 0 && age <= 150;
    }
}

let person1 = Person.fromObject({ name: "Alice", age: 25 });
let person2 = Person.fromObject({ name: "Bob", age: 30 });

console.log(Person.compareAge(person1, person2));  // -5 (Alice is younger)
console.log(Person.isValidAge(25));                 // true
console.log(Person.isValidAge(200));                // false
```

### When to Use Static Methods

- Utility functions related to the class
- Factory methods (create instances in special ways)
- Validation methods
- Methods that don't need instance data

---

## Class Fields

Class fields allow you to define properties directly in the class body (ES2022).

### Instance Fields

```javascript
class Person {
    // Instance fields
    name = "Unknown";
    age = 0;
    
    constructor(name, age) {
        this.name = name;
        this.age = age;
    }
}

let person = new Person("Alice", 25);
console.log(person.name);  // "Alice"
```

### Private Fields (ES2022)

Private fields are only accessible within the class:

```javascript
class BankAccount {
    // Private field (starts with #)
    #balance = 0;
    
    constructor(accountNumber) {
        this.accountNumber = accountNumber;
    }
    
    deposit(amount) {
        this.#balance += amount;
    }
    
    getBalance() {
        return this.#balance;
    }
}

let account = new BankAccount("ACC001");
account.deposit(100);
console.log(account.getBalance());  // 100
// console.log(account.#balance);   // ❌ Error: Private field
```

### Static Fields

```javascript
class Person {
    // Static field
    static species = "Homo sapiens";
    static count = 0;
    
    constructor(name) {
        this.name = name;
        Person.count++;  // Increment static counter
    }
    
    static getCount() {
        return Person.count;
    }
}

console.log(Person.species);  // "Homo sapiens"

let person1 = new Person("Alice");
let person2 = new Person("Bob");

console.log(Person.getCount());  // 2
```

### Field Initialization

```javascript
class Counter {
    count = 0;  // Instance field with initial value
    
    increment() {
        this.count++;
    }
    
    getCount() {
        return this.count;
    }
}

let counter = new Counter();
console.log(counter.getCount());  // 0
counter.increment();
console.log(counter.getCount());  // 1
```

---

## Getters and Setters

Getters and setters allow you to define computed properties.

### Getters

```javascript
class Rectangle {
    constructor(width, height) {
        this.width = width;
        this.height = height;
    }
    
    get area() {
        return this.width * this.height;
    }
    
    get perimeter() {
        return 2 * (this.width + this.height);
    }
}

let rect = new Rectangle(10, 5);
console.log(rect.area);       // 50 (accessed like property)
console.log(rect.perimeter);   // 30
```

### Setters

```javascript
class Person {
    constructor(firstName, lastName) {
        this.firstName = firstName;
        this.lastName = lastName;
    }
    
    get fullName() {
        return `${this.firstName} ${this.lastName}`;
    }
    
    set fullName(name) {
        const parts = name.split(" ");
        this.firstName = parts[0] || "";
        this.lastName = parts.slice(1).join(" ") || "";
    }
}

let person = new Person("Alice", "Smith");
console.log(person.fullName);  // "Alice Smith"

person.fullName = "Bob Jones";
console.log(person.firstName);  // "Bob"
console.log(person.lastName);   // "Jones"
```

### Practical Example

```javascript
class Temperature {
    constructor(celsius) {
        this._celsius = celsius;
    }
    
    get celsius() {
        return this._celsius;
    }
    
    set celsius(value) {
        if (value < -273.15) {
            throw new Error("Temperature cannot be below absolute zero");
        }
        this._celsius = value;
    }
    
    get fahrenheit() {
        return (this._celsius * 9/5) + 32;
    }
    
    set fahrenheit(value) {
        this._celsius = (value - 32) * 5/9;
    }
}

let temp = new Temperature(25);
console.log(temp.celsius);     // 25
console.log(temp.fahrenheit);  // 77

temp.fahrenheit = 100;
console.log(temp.celsius);     // 37.777...
```

---

## Complete Class Example

### Car Class

```javascript
class Car {
    // Static field
    static totalCars = 0;
    
    // Constructor
    constructor(brand, model, year) {
        this.brand = brand;
        this.model = model;
        this.year = year;
        this.speed = 0;
        this.isRunning = false;
        
        Car.totalCars++;
    }
    
    // Instance methods
    start() {
        this.isRunning = true;
        return `${this.brand} ${this.model} started`;
    }
    
    stop() {
        this.isRunning = false;
        this.speed = 0;
        return `${this.brand} ${this.model} stopped`;
    }
    
    accelerate(amount) {
        if (this.isRunning) {
            this.speed += amount;
            return `Speed: ${this.speed} mph`;
        }
        return "Car is not running";
    }
    
    brake(amount) {
        if (this.speed > 0) {
            this.speed = Math.max(0, this.speed - amount);
            return `Speed: ${this.speed} mph`;
        }
        return "Car is already stopped";
    }
    
    // Getter
    get info() {
        return `${this.year} ${this.brand} ${this.model}`;
    }
    
    // Static method
    static getTotalCars() {
        return Car.totalCars;
    }
    
    static compareYear(car1, car2) {
        return car1.year - car2.year;
    }
}

// Usage
let car1 = new Car("Toyota", "Camry", 2020);
let car2 = new Car("Honda", "Civic", 2021);

console.log(car1.start());           // "Toyota Camry started"
console.log(car1.accelerate(30));    // "Speed: 30 mph"
console.log(car1.info);              // "2020 Toyota Camry"
console.log(Car.getTotalCars());     // 2
console.log(Car.compareYear(car1, car2));  // -1 (car1 is older)
```

---

## Classes vs Constructor Functions

### Similarities

Both create the same result:

```javascript
// Constructor function
function Person(name) {
    this.name = name;
}
Person.prototype.greet = function() {
    return `Hello, ${this.name}`;
};

// Class
class Person {
    constructor(name) {
        this.name = name;
    }
    greet() {
        return `Hello, ${this.name}`;
    }
}
```

### Differences

**Classes:**
- ✅ Cleaner syntax
- ✅ Built-in support for inheritance
- ✅ Cannot be called without `new`
- ✅ Methods are non-enumerable
- ✅ Always in strict mode

**Constructor Functions:**
- ⚠️ Can be called without `new` (creates bugs)
- ⚠️ More verbose
- ✅ More flexible (can return different objects)

### Class Hoisting

Classes are NOT hoisted (unlike function declarations):

```javascript
// ❌ Error: Cannot access before initialization
let person = new Person("Alice");

class Person {
    constructor(name) {
        this.name = name;
    }
}
```

---

## Practice Exercise

### Exercise: Building Classes

**Objective**: Create classes using ES6 class syntax with constructors, instance methods, static methods, and class fields.

**Instructions**:

1. Create a file called `classes-practice.js`

2. Create classes for:
   - Product (name, price, quantity)
   - Circle (radius)
   - Library (books management)

3. Include:
   - Constructors with validation
   - Instance methods
   - Static methods
   - Getters and setters
   - Class fields

**Example Solution**:

```javascript
// Classes Practice
console.log("=== Product Class ===");

class Product {
    // Static field
    static totalProducts = 0;
    
    constructor(name, price, quantity = 0) {
        if (!name || typeof name !== "string") {
            throw new Error("Product name must be a non-empty string");
        }
        if (price < 0) {
            throw new Error("Price cannot be negative");
        }
        if (quantity < 0) {
            throw new Error("Quantity cannot be negative");
        }
        
        this.name = name;
        this.price = price;
        this.quantity = quantity;
        
        Product.totalProducts++;
    }
    
    // Instance methods
    getTotalValue() {
        return this.price * this.quantity;
    }
    
    addStock(amount) {
        if (amount > 0) {
            this.quantity += amount;
            return `Added ${amount} units. New quantity: ${this.quantity}`;
        }
        return "Invalid amount";
    }
    
    sell(amount) {
        if (amount > 0 && amount <= this.quantity) {
            this.quantity -= amount;
            return `Sold ${amount} units. Remaining: ${this.quantity}`;
        }
        return "Invalid sale or insufficient stock";
    }
    
    // Getter
    get isInStock() {
        return this.quantity > 0;
    }
    
    get info() {
        return `${this.name}: $${this.price} (${this.quantity} in stock)`;
    }
    
    // Static methods
    static getTotalProducts() {
        return Product.totalProducts;
    }
    
    static comparePrice(product1, product2) {
        return product1.price - product2.price;
    }
    
    static findCheapest(products) {
        return products.reduce((cheapest, current) => {
            return current.price < cheapest.price ? current : cheapest;
        });
    }
}

let product1 = new Product("Laptop", 999.99, 10);
let product2 = new Product("Mouse", 29.99, 50);
let product3 = new Product("Keyboard", 79.99, 25);

console.log(product1.info);                    // "Laptop: $999.99 (10 in stock)"
console.log(product1.getTotalValue());         // 9999.9
console.log(product1.isInStock);              // true
console.log(product1.sell(3));                // "Sold 3 units. Remaining: 7"
console.log(Product.getTotalProducts());        // 3
console.log(Product.comparePrice(product2, product3));  // -50 (mouse is cheaper)
console.log();

console.log("=== Circle Class ===");

class Circle {
    constructor(radius) {
        if (radius < 0) {
            throw new Error("Radius cannot be negative");
        }
        this.radius = radius;
    }
    
    // Getters
    get diameter() {
        return this.radius * 2;
    }
    
    get area() {
        return Math.PI * this.radius ** 2;
    }
    
    get circumference() {
        return 2 * Math.PI * this.radius;
    }
    
    // Setters
    set diameter(value) {
        this.radius = value / 2;
    }
    
    set area(value) {
        this.radius = Math.sqrt(value / Math.PI);
    }
    
    // Instance methods
    scale(factor) {
        if (factor > 0) {
            this.radius *= factor;
            return `Scaled by ${factor}. New radius: ${this.radius}`;
        }
        return "Invalid scale factor";
    }
    
    // Static methods
    static fromDiameter(diameter) {
        return new Circle(diameter / 2);
    }
    
    static fromArea(area) {
        return new Circle(Math.sqrt(area / Math.PI));
    }
    
    static compareArea(circle1, circle2) {
        return circle1.area - circle2.area;
    }
}

let circle1 = new Circle(5);
console.log("Radius:", circle1.radius);           // 5
console.log("Diameter:", circle1.diameter);       // 10
console.log("Area:", circle1.area.toFixed(2));    // 78.54
console.log("Circumference:", circle1.circumference.toFixed(2));  // 31.42

circle1.diameter = 20;
console.log("New radius:", circle1.radius);      // 10

let circle2 = Circle.fromDiameter(14);
console.log("Circle from diameter:", circle2.radius);  // 7

let circle3 = Circle.fromArea(100);
console.log("Circle from area:", circle3.radius.toFixed(2));  // 5.64
console.log();

console.log("=== Library Class ===");

class Library {
    constructor(name) {
        this.name = name;
        this.books = [];
    }
    
    // Instance methods
    addBook(book) {
        this.books.push(book);
        return `Added "${book.title}" to library`;
    }
    
    removeBook(title) {
        const index = this.books.findIndex(book => book.title === title);
        if (index !== -1) {
            this.books.splice(index, 1);
            return `Removed "${title}" from library`;
        }
        return `Book "${title}" not found`;
    }
    
    findBook(title) {
        return this.books.find(book => book.title === title);
    }
    
    getTotalBooks() {
        return this.books.length;
    }
    
    // Getter
    get bookTitles() {
        return this.books.map(book => book.title);
    }
    
    get totalValue() {
        return this.books.reduce((sum, book) => sum + (book.price || 0), 0);
    }
    
    // Static method
    static mergeLibraries(lib1, lib2) {
        const merged = new Library(`${lib1.name} & ${lib2.name}`);
        merged.books = [...lib1.books, ...lib2.books];
        return merged;
    }
}

class Book {
    constructor(title, author, year, price = 0) {
        this.title = title;
        this.author = author;
        this.year = year;
        this.price = price;
    }
    
    get info() {
        return `${this.title} by ${this.author} (${this.year})`;
    }
}

let library = new Library("City Library");
let book1 = new Book("1984", "George Orwell", 1949, 15.99);
let book2 = new Book("The Great Gatsby", "F. Scott Fitzgerald", 1925, 12.99);
let book3 = new Book("To Kill a Mockingbird", "Harper Lee", 1960, 14.99);

library.addBook(book1);
library.addBook(book2);
library.addBook(book3);

console.log("Total books:", library.getTotalBooks());  // 3
console.log("Book titles:", library.bookTitles);
console.log("Total value: $" + library.totalValue.toFixed(2));  // $43.97
console.log("Found book:", library.findBook("1984")?.info);
console.log(library.removeBook("The Great Gatsby"));
console.log("After removal:", library.getTotalBooks());  // 2
```

**Expected Output**:
```
=== Product Class ===
Laptop: $999.99 (10 in stock)
9999.9
true
Sold 3 units. Remaining: 7
3
-50

=== Circle Class ===
Radius: 5
Diameter: 10
Area: 78.54
Circumference: 31.42
New radius: 10
Circle from diameter: 7
Circle from area: 5.64

=== Library Class ===
Total books: 3
Book titles: [ "1984", "The Great Gatsby", "To Kill a Mockingbird" ]
Total value: $43.97
Found book: 1984 by George Orwell (1949)
Removed "The Great Gatsby" from library
After removal: 2
```

**Challenge (Optional)**:
- Create a game character class system
- Build a shape hierarchy (Circle, Rectangle, Triangle)
- Create a vehicle management system
- Build a user management system with validation

---

## Common Mistakes

### 1. Forgetting `new` with Classes

```javascript
// ❌ Error: Class constructor cannot be invoked without 'new'
class Person {
    constructor(name) {
        this.name = name;
    }
}

let person = Person("Alice");  // TypeError
```

### 2. Methods as Arrow Functions

```javascript
// ⚠️ Arrow functions don't have their own `this`
class Person {
    constructor(name) {
        this.name = name;
    }
    
    greet = () => {
        console.log(this.name);  // Works, but different behavior
    }
}

// ✅ Better: Regular method
class Person {
    constructor(name) {
        this.name = name;
    }
    
    greet() {
        console.log(this.name);
    }
}
```

### 3. Static Method Access

```javascript
class Person {
    static getCount() {
        return 5;
    }
}

let person = new Person();
// person.getCount();  // ❌ Error: Not a function

Person.getCount();  // ✅ Correct
```

### 4. Class Hoisting

```javascript
// ❌ Error: Cannot access before initialization
let person = new Person("Alice");

class Person {
    constructor(name) {
        this.name = name;
    }
}
```

### 5. Private Field Access

```javascript
class BankAccount {
    #balance = 0;
}

let account = new BankAccount();
// console.log(account.#balance);  // ❌ Error: Private field
```

---

## Key Takeaways

1. **Class Syntax**: Cleaner than constructor functions
2. **Constructor**: Special method that runs on instantiation
3. **Instance Methods**: Available on all instances
4. **Static Methods**: Called on class, not instances
5. **Class Fields**: Define properties in class body
6. **Getters/Setters**: Computed properties
7. **Still Prototypes**: Classes are syntactic sugar over prototypes
8. **No Hoisting**: Classes must be defined before use

---

## Quiz: Classes

Test your understanding with these questions:

1. **What is the special method called when creating an instance?**
   - A) init()
   - B) constructor()
   - C) create()
   - D) new()

2. **Static methods are called on:**
   - A) Instances
   - B) The class
   - C) Prototype
   - D) Both A and B

3. **Classes are:**
   - A) Hoisted
   - B) Not hoisted
   - C) Sometimes hoisted
   - D) Always undefined

4. **Private fields start with:**
   - A) _
   - B) #
   - C) private
   - D) $

5. **Getters are accessed like:**
   - A) Methods
   - B) Properties
   - C) Functions
   - D) Variables

6. **What happens if you call a class without `new`?**
   - A) Works fine
   - B) Error
   - C) Returns undefined
   - D) Creates global variable

7. **Classes are:**
   - A) Completely new feature
   - B) Syntactic sugar over prototypes
   - C) Different from constructors
   - D) Slower than constructors

**Answers**:
1. B) constructor()
2. B) The class
3. B) Not hoisted
4. B) #
5. B) Properties
6. B) Error
7. B) Syntactic sugar over prototypes

---

## Next Steps

Congratulations! You've learned ES6 classes. You now know:
- How to create classes
- Constructor, instance, and static methods
- Class fields and getters/setters
- How classes relate to prototypes

**What's Next?**
- Lesson 6.3: Inheritance
- Practice building class hierarchies
- Learn about extends and super
- Build more complex OOP structures

---

## Additional Resources

- **MDN: Classes**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Classes](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Classes)
- **MDN: Static**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Classes/static](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Classes/static)
- **JavaScript.info: Classes**: [javascript.info/class](https://javascript.info/class)
- **JavaScript.info: Class Fields**: [javascript.info/class](https://javascript.info/class)

---

*Lesson completed! You're ready to move on to the next lesson.*

