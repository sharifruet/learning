# Lesson 6.3: Inheritance

## Learning Objectives

By the end of this lesson, you will be able to:
- Use the `extends` keyword to create class inheritance
- Use the `super` keyword to call parent class methods
- Override methods in child classes
- Understand prototypal inheritance
- Create class hierarchies
- Build complex object-oriented structures

---

## Introduction to Inheritance

Inheritance allows one class to inherit properties and methods from another class. This promotes code reuse and creates hierarchical relationships.

### Benefits of Inheritance

- **Code Reuse**: Share common functionality
- **Hierarchy**: Model real-world relationships
- **Polymorphism**: Different classes can respond to same methods
- **Maintainability**: Update parent class affects all children

---

## extends Keyword

The `extends` keyword creates a child class that inherits from a parent class.

### Basic Inheritance

```javascript
class Animal {
    constructor(name) {
        this.name = name;
    }
    
    speak() {
        return `${this.name} makes a sound`;
    }
}

class Dog extends Animal {
    // Inherits name and speak() from Animal
}

let dog = new Dog("Buddy");
console.log(dog.name);        // "Buddy"
console.log(dog.speak());     // "Buddy makes a sound"
```

### Adding Child-Specific Properties

```javascript
class Animal {
    constructor(name) {
        this.name = name;
    }
    
    speak() {
        return `${this.name} makes a sound`;
    }
}

class Dog extends Animal {
    constructor(name, breed) {
        super(name);  // Call parent constructor
        this.breed = breed;
    }
}

let dog = new Dog("Buddy", "Golden Retriever");
console.log(dog.name);   // "Buddy"
console.log(dog.breed);  // "Golden Retriever"
```

### Inheritance Chain

```javascript
class Animal {
    constructor(name) {
        this.name = name;
    }
}

class Mammal extends Animal {
    constructor(name, hasFur) {
        super(name);
        this.hasFur = hasFur;
    }
}

class Dog extends Mammal {
    constructor(name, hasFur, breed) {
        super(name, hasFur);
        this.breed = breed;
    }
}

let dog = new Dog("Buddy", true, "Golden Retriever");
console.log(dog.name);    // "Buddy" (from Animal)
console.log(dog.hasFur);  // true (from Mammal)
console.log(dog.breed);   // "Golden Retriever" (from Dog)
```

---

## super Keyword

The `super` keyword is used to call methods and access properties of the parent class.

### super in Constructor

Must call `super()` before using `this` in child constructor:

```javascript
class Animal {
    constructor(name) {
        this.name = name;
    }
}

class Dog extends Animal {
    constructor(name, breed) {
        super(name);  // Must call super first
        this.breed = breed;  // Now can use this
    }
}
```

### super for Methods

Call parent class methods:

```javascript
class Animal {
    constructor(name) {
        this.name = name;
    }
    
    speak() {
        return `${this.name} makes a sound`;
    }
}

class Dog extends Animal {
    constructor(name, breed) {
        super(name);
        this.breed = breed;
    }
    
    speak() {
        return super.speak() + " - Woof!";
    }
}

let dog = new Dog("Buddy", "Golden Retriever");
console.log(dog.speak());  // "Buddy makes a sound - Woof!"
```

### super Examples

```javascript
class Shape {
    constructor(color) {
        this.color = color;
    }
    
    getInfo() {
        return `Shape with color ${this.color}`;
    }
}

class Circle extends Shape {
    constructor(color, radius) {
        super(color);
        this.radius = radius;
    }
    
    getInfo() {
        return super.getInfo() + ` and radius ${this.radius}`;
    }
}

let circle = new Circle("red", 5);
console.log(circle.getInfo());  // "Shape with color red and radius 5"
```

---

## Method Overriding

Child classes can override parent class methods to provide their own implementation.

### Basic Override

```javascript
class Animal {
    speak() {
        return "Some sound";
    }
}

class Dog extends Animal {
    speak() {
        return "Woof!";
    }
}

class Cat extends Animal {
    speak() {
        return "Meow!";
    }
}

let dog = new Dog();
let cat = new Cat();

console.log(dog.speak());  // "Woof!"
console.log(cat.speak());  // "Meow!"
```

### Override with super

You can override but still call the parent method:

```javascript
class Animal {
    constructor(name) {
        this.name = name;
    }
    
    introduce() {
        return `I'm ${this.name}`;
    }
}

class Dog extends Animal {
    introduce() {
        return super.introduce() + " and I'm a dog";
    }
}

let dog = new Dog("Buddy");
console.log(dog.introduce());  // "I'm Buddy and I'm a dog"
```

### Complete Override Example

```javascript
class Vehicle {
    constructor(brand, model) {
        this.brand = brand;
        this.model = model;
        this.speed = 0;
    }
    
    accelerate(amount) {
        this.speed += amount;
        return `Speed: ${this.speed} mph`;
    }
    
    getInfo() {
        return `${this.brand} ${this.model}`;
    }
}

class Car extends Vehicle {
    constructor(brand, model, doors) {
        super(brand, model);
        this.doors = doors;
    }
    
    // Override getInfo
    getInfo() {
        return `${super.getInfo()} with ${this.doors} doors`;
    }
}

class Truck extends Vehicle {
    constructor(brand, model, capacity) {
        super(brand, model);
        this.capacity = capacity;
    }
    
    // Override accelerate (trucks accelerate slower)
    accelerate(amount) {
        this.speed += amount * 0.5;  // Half the acceleration
        return `Speed: ${this.speed} mph (truck mode)`;
    }
    
    // Override getInfo
    getInfo() {
        return `${super.getInfo()} with ${this.capacity} ton capacity`;
    }
}

let car = new Car("Toyota", "Camry", 4);
let truck = new Truck("Ford", "F-150", 2);

console.log(car.getInfo());        // "Toyota Camry with 4 doors"
console.log(car.accelerate(30));   // "Speed: 30 mph"
console.log(truck.getInfo());      // "Ford F-150 with 2 ton capacity"
console.log(truck.accelerate(30)); // "Speed: 15 mph (truck mode)"
```

---

## Prototypal Inheritance

Under the hood, JavaScript uses prototypal inheritance. Classes are syntactic sugar over this system.

### How Inheritance Works

```javascript
class Animal {
    constructor(name) {
        this.name = name;
    }
}

class Dog extends Animal {
    constructor(name, breed) {
        super(name);
        this.breed = breed;
    }
}

let dog = new Dog("Buddy", "Golden Retriever");

// Prototype chain:
// dog → Dog.prototype → Animal.prototype → Object.prototype → null

console.log(dog instanceof Dog);     // true
console.log(dog instanceof Animal);  // true
console.log(dog instanceof Object);  // true
```

### Prototype Chain Visualization

```
dog instance
  ├─ name: "Buddy" (own property)
  ├─ breed: "Golden Retriever" (own property)
  └─ __proto__ → Dog.prototype
       └─ __proto__ → Animal.prototype
            └─ __proto__ → Object.prototype
                 └─ __proto__ → null
```

### Checking Inheritance

```javascript
class Animal { }
class Dog extends Animal { }
class Puppy extends Dog { }

let puppy = new Puppy();

console.log(puppy instanceof Puppy);  // true
console.log(puppy instanceof Dog);  // true
console.log(puppy instanceof Animal); // true
console.log(puppy instanceof Object); // true
```

### Accessing Parent Prototype

```javascript
class Animal {
    speak() {
        return "Some sound";
    }
}

class Dog extends Animal {
    speak() {
        return "Woof!";
    }
}

let dog = new Dog();

// Access parent method through prototype
console.log(Animal.prototype.speak.call(dog));  // "Some sound"
console.log(dog.speak());                        // "Woof!" (overridden)
```

---

## Multiple Levels of Inheritance

You can create inheritance chains with multiple levels.

### Three-Level Inheritance

```javascript
class Vehicle {
    constructor(brand) {
        this.brand = brand;
        this.isRunning = false;
    }
    
    start() {
        this.isRunning = true;
        return "Vehicle started";
    }
}

class Car extends Vehicle {
    constructor(brand, doors) {
        super(brand);
        this.doors = doors;
    }
    
    openTrunk() {
        return "Trunk opened";
    }
}

class SportsCar extends Car {
    constructor(brand, doors, topSpeed) {
        super(brand, doors);
        this.topSpeed = topSpeed;
    }
    
    race() {
        if (this.isRunning) {
            return `Racing at up to ${this.topSpeed} mph!`;
        }
        return "Start the car first";
    }
}

let sportsCar = new SportsCar("Ferrari", 2, 200);
console.log(sportsCar.start());      // "Vehicle started" (from Vehicle)
console.log(sportsCar.openTrunk());  // "Trunk opened" (from Car)
console.log(sportsCar.race());       // "Racing at up to 200 mph!" (from SportsCar)
```

### Method Resolution

When a method is called, JavaScript looks up the prototype chain:

```javascript
class Animal {
    eat() {
        return "Eating food";
    }
}

class Dog extends Animal {
    bark() {
        return "Woof!";
    }
}

let dog = new Dog();

// JavaScript looks for eat():
// 1. dog object → not found
// 2. Dog.prototype → not found
// 3. Animal.prototype → found! "Eating food"
console.log(dog.eat());  // "Eating food"
```

---

## Complete Inheritance Example

### Shape Hierarchy

```javascript
class Shape {
    constructor(color) {
        this.color = color;
    }
    
    getArea() {
        throw new Error("getArea() must be implemented by subclass");
    }
    
    getInfo() {
        return `Shape with color ${this.color}`;
    }
}

class Circle extends Shape {
    constructor(color, radius) {
        super(color);
        this.radius = radius;
    }
    
    getArea() {
        return Math.PI * this.radius ** 2;
    }
    
    getInfo() {
        return `${super.getInfo()}, radius ${this.radius}`;
    }
}

class Rectangle extends Shape {
    constructor(color, width, height) {
        super(color);
        this.width = width;
        this.height = height;
    }
    
    getArea() {
        return this.width * this.height;
    }
    
    getInfo() {
        return `${super.getInfo()}, ${this.width}x${this.height}`;
    }
}

class Square extends Rectangle {
    constructor(color, side) {
        super(color, side, side);
        this.side = side;
    }
    
    getInfo() {
        return `${super.getInfo()} (square)`;
    }
}

// Usage
let circle = new Circle("red", 5);
let rectangle = new Rectangle("blue", 10, 5);
let square = new Square("green", 4);

console.log(circle.getInfo());     // "Shape with color red, radius 5"
console.log(circle.getArea());     // 78.54...

console.log(rectangle.getInfo());  // "Shape with color blue, 10x5"
console.log(rectangle.getArea());  // 50

console.log(square.getInfo());     // "Shape with color green, 4x4 (square)"
console.log(square.getArea());     // 16
```

---

## Practice Exercise

### Exercise: Inheritance Practice

**Objective**: Create class hierarchies using inheritance, super, and method overriding.

**Instructions**:

1. Create a file called `inheritance-practice.js`

2. Create class hierarchies:
   - Animal → Dog, Cat
   - Vehicle → Car, Truck, Motorcycle
   - Employee → Manager, Developer

3. Practice:
   - Using extends
   - Calling super()
   - Method overriding
   - Accessing parent methods
   - Creating multi-level inheritance

**Example Solution**:

```javascript
// Inheritance Practice
console.log("=== Animal Hierarchy ===");

class Animal {
    constructor(name, age) {
        this.name = name;
        this.age = age;
    }
    
    speak() {
        return `${this.name} makes a sound`;
    }
    
    getInfo() {
        return `${this.name} is ${this.age} years old`;
    }
}

class Dog extends Animal {
    constructor(name, age, breed) {
        super(name, age);
        this.breed = breed;
    }
    
    speak() {
        return `${this.name} says Woof!`;
    }
    
    fetch() {
        return `${this.name} fetches the ball`;
    }
    
    getInfo() {
        return `${super.getInfo()} and is a ${this.breed}`;
    }
}

class Cat extends Animal {
    constructor(name, age, color) {
        super(name, age);
        this.color = color;
    }
    
    speak() {
        return `${this.name} says Meow!`;
    }
    
    purr() {
        return `${this.name} purrs contentedly`;
    }
    
    getInfo() {
        return `${super.getInfo()} and is ${this.color}`;
    }
}

let dog = new Dog("Buddy", 3, "Golden Retriever");
let cat = new Cat("Whiskers", 2, "orange");

console.log(dog.speak());      // "Buddy says Woof!"
console.log(dog.fetch());      // "Buddy fetches the ball"
console.log(dog.getInfo());    // "Buddy is 3 years old and is a Golden Retriever"

console.log(cat.speak());      // "Whiskers says Meow!"
console.log(cat.purr());       // "Whiskers purrs contentedly"
console.log(cat.getInfo());    // "Whiskers is 2 years old and is orange"
console.log();

console.log("=== Vehicle Hierarchy ===");

class Vehicle {
    constructor(brand, model, year) {
        this.brand = brand;
        this.model = model;
        this.year = year;
        this.speed = 0;
        this.isRunning = false;
    }
    
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
        return "Vehicle is not running";
    }
    
    getInfo() {
        return `${this.year} ${this.brand} ${this.model}`;
    }
}

class Car extends Vehicle {
    constructor(brand, model, year, doors) {
        super(brand, model, year);
        this.doors = doors;
    }
    
    openTrunk() {
        return "Trunk opened";
    }
    
    getInfo() {
        return `${super.getInfo()} with ${this.doors} doors`;
    }
}

class Truck extends Vehicle {
    constructor(brand, model, year, capacity) {
        super(brand, model, year);
        this.capacity = capacity;
    }
    
    accelerate(amount) {
        if (this.isRunning) {
            this.speed += amount * 0.7;  // Trucks accelerate slower
            return `Speed: ${this.speed} mph (truck)`;
        }
        return "Truck is not running";
    }
    
    loadCargo(weight) {
        if (weight <= this.capacity) {
            return `Loaded ${weight} tons of cargo`;
        }
        return `Cannot load ${weight} tons (max: ${this.capacity})`;
    }
    
    getInfo() {
        return `${super.getInfo()} with ${this.capacity} ton capacity`;
    }
}

class Motorcycle extends Vehicle {
    constructor(brand, model, year, engineSize) {
        super(brand, model, year);
        this.engineSize = engineSize;
    }
    
    accelerate(amount) {
        if (this.isRunning) {
            this.speed += amount * 1.5;  // Motorcycles accelerate faster
            return `Speed: ${this.speed} mph (motorcycle)`;
        }
        return "Motorcycle is not running";
    }
    
    wheelie() {
        if (this.isRunning && this.speed > 20) {
            return "Doing a wheelie!";
        }
        return "Need more speed for wheelie";
    }
    
    getInfo() {
        return `${super.getInfo()} with ${this.engineSize}cc engine`;
    }
}

let car = new Car("Toyota", "Camry", 2020, 4);
let truck = new Truck("Ford", "F-150", 2021, 2);
let motorcycle = new Motorcycle("Honda", "CBR", 2022, 600);

console.log(car.getInfo());           // "2020 Toyota Camry with 4 doors"
console.log(car.start());             // "Toyota Camry started"
console.log(car.accelerate(30));       // "Speed: 30 mph"
console.log(car.openTrunk());         // "Trunk opened"

console.log(truck.getInfo());         // "2021 Ford F-150 with 2 ton capacity"
console.log(truck.start());           // "Ford F-150 started"
console.log(truck.accelerate(30));    // "Speed: 21 mph (truck)"
console.log(truck.loadCargo(1.5));    // "Loaded 1.5 tons of cargo"

console.log(motorcycle.getInfo());    // "2022 Honda CBR with 600cc engine"
console.log(motorcycle.start());      // "Honda CBR started"
console.log(motorcycle.accelerate(30)); // "Speed: 45 mph (motorcycle)"
console.log(motorcycle.wheelie());    // "Doing a wheelie!"
console.log();

console.log("=== Employee Hierarchy ===");

class Employee {
    constructor(name, id, salary) {
        this.name = name;
        this.id = id;
        this.salary = salary;
    }
    
    work() {
        return `${this.name} is working`;
    }
    
    getSalary() {
        return `Salary: $${this.salary}`;
    }
    
    getInfo() {
        return `${this.name} (ID: ${this.id})`;
    }
}

class Manager extends Employee {
    constructor(name, id, salary, department) {
        super(name, id, salary);
        this.department = department;
        this.team = [];
    }
    
    addTeamMember(employee) {
        this.team.push(employee);
        return `Added ${employee.name} to team`;
    }
    
    work() {
        return `${this.name} is managing the ${this.department} department`;
    }
    
    getTeamSize() {
        return this.team.length;
    }
    
    getInfo() {
        return `${super.getInfo()} - Manager of ${this.department}`;
    }
}

class Developer extends Employee {
    constructor(name, id, salary, language) {
        super(name, id, salary);
        this.language = language;
    }
    
    work() {
        return `${this.name} is coding in ${this.language}`;
    }
    
    debug() {
        return `${this.name} is debugging code`;
    }
    
    getInfo() {
        return `${super.getInfo()} - Developer (${this.language})`;
    }
}

let manager = new Manager("Alice", "M001", 80000, "Engineering");
let dev1 = new Developer("Bob", "D001", 70000, "JavaScript");
let dev2 = new Developer("Charlie", "D002", 75000, "Python");

console.log(manager.getInfo());        // "Alice (ID: M001) - Manager of Engineering"
console.log(manager.work());           // "Alice is managing the Engineering department"
console.log(manager.addTeamMember(dev1)); // "Added Bob to team"
console.log(manager.addTeamMember(dev2)); // "Added Charlie to team"
console.log("Team size:", manager.getTeamSize()); // 2

console.log(dev1.getInfo());           // "Bob (ID: D001) - Developer (JavaScript)"
console.log(dev1.work());              // "Bob is coding in JavaScript"
console.log(dev1.debug());             // "Bob is debugging code"
console.log();

console.log("=== instanceof Checks ===");
console.log("dog instanceof Dog:", dog instanceof Dog);           // true
console.log("dog instanceof Animal:", dog instanceof Animal);     // true
console.log("car instanceof Car:", car instanceof Car);           // true
console.log("car instanceof Vehicle:", car instanceof Vehicle);    // true
console.log("manager instanceof Manager:", manager instanceof Manager); // true
console.log("manager instanceof Employee:", manager instanceof Employee); // true
```

**Expected Output**:
```
=== Animal Hierarchy ===
Buddy says Woof!
Buddy fetches the ball
Buddy is 3 years old and is a Golden Retriever
Whiskers says Meow!
Whiskers purrs contentedly
Whiskers is 2 years old and is orange

=== Vehicle Hierarchy ===
2020 Toyota Camry with 4 doors
Toyota Camry started
Speed: 30 mph
Trunk opened
2021 Ford F-150 with 2 ton capacity
Ford F-150 started
Speed: 21 mph (truck)
Loaded 1.5 tons of cargo
2022 Honda CBR with 600cc engine
Honda CBR started
Speed: 45 mph (motorcycle)
Doing a wheelie!

=== Employee Hierarchy ===
Alice (ID: M001) - Manager of Engineering
Alice is managing the Engineering department
Added Bob to team
Added Charlie to team
Team size: 2
Bob (ID: D001) - Developer (JavaScript)
Bob is coding in JavaScript
Bob is debugging code

=== instanceof Checks ===
dog instanceof Dog: true
dog instanceof Animal: true
car instanceof Car: true
car instanceof Vehicle: true
manager instanceof Manager: true
manager instanceof Employee: true
```

**Challenge (Optional)**:
- Create a game character hierarchy
- Build a shape system with multiple levels
- Create a file system hierarchy
- Build a UI component system

---

## Common Mistakes

### 1. Forgetting super() in Constructor

```javascript
// ❌ Error: Must call super before accessing this
class Dog extends Animal {
    constructor(name, breed) {
        this.breed = breed;  // Error!
        super(name);
    }
}

// ✅ Correct
class Dog extends Animal {
    constructor(name, breed) {
        super(name);
        this.breed = breed;
    }
}
```

### 2. Calling super() After return

```javascript
// ❌ Error: super() must be called before return
class Dog extends Animal {
    constructor(name) {
        return {};
        super(name);  // Never reached
    }
}
```

### 3. Overriding Without super

```javascript
// ⚠️ Loses parent functionality
class Dog extends Animal {
    getInfo() {
        return `Dog: ${this.name}`;  // Doesn't use parent's getInfo
    }
}

// ✅ Better: Use super
class Dog extends Animal {
    getInfo() {
        return `Dog: ${super.getInfo()}`;
    }
}
```

### 4. Wrong super Usage

```javascript
// ❌ super is not a variable
class Dog extends Animal {
    method() {
        let parent = super;  // Error: super is a keyword
    }
}

// ✅ Correct: Call super methods
class Dog extends Animal {
    method() {
        return super.method();
    }
}
```

### 5. Extending Non-Constructor

```javascript
// ❌ Cannot extend non-constructor
class Dog extends "Animal" { }  // Error

// ✅ Must extend a class or constructor
class Dog extends Animal { }  // Correct
```

---

## Key Takeaways

1. **extends**: Creates inheritance relationship
2. **super**: Calls parent class constructor/methods
3. **Method Overriding**: Child classes can override parent methods
4. **super()**: Must be called before `this` in child constructor
5. **Prototypal Inheritance**: Classes use prototype chain under the hood
6. **instanceof**: Works with inheritance (checks prototype chain)
7. **Multi-level**: Can have multiple levels of inheritance
8. **Best Practice**: Use super to extend parent functionality

---

## Quiz: Inheritance

Test your understanding with these questions:

1. **What keyword creates inheritance?**
   - A) inherits
   - B) extends
   - C) super
   - D) parent

2. **When must super() be called?**
   - A) After using this
   - B) Before using this
   - C) Never
   - D) Anytime

3. **What does super refer to?**
   - A) Current class
   - B) Parent class
   - C) Child class
   - D) Global object

4. **Can child classes override parent methods?**
   - A) No
   - B) Yes
   - C) Sometimes
   - D) Only static methods

5. **What does instanceof check with inheritance?**
   - A) Only direct class
   - B) Prototype chain
   - C) Property names
   - D) Method names

6. **How many classes can a class extend?**
   - A) 0
   - B) 1
   - C) Multiple
   - D) Unlimited

7. **Inheritance uses:**
   - A) Copying
   - B) Prototype chain
   - C) Cloning
   - D) Duplication

**Answers**:
1. B) extends
2. B) Before using this
3. B) Parent class
4. B) Yes
5. B) Prototype chain
6. B) 1 (single inheritance)
7. B) Prototype chain

---

## Next Steps

Congratulations! You've completed Module 6: Object-Oriented Programming. You now know:
- Constructor functions and prototypes
- ES6 class syntax
- Inheritance with extends and super
- Method overriding

**What's Next?**
- Course 2: Intermediate JavaScript
- Module 7: ES6+ Features
- Practice building class hierarchies
- Create more complex OOP structures

---

## Additional Resources

- **MDN: Inheritance**: [developer.mozilla.org/en-US/docs/Learn/JavaScript/Objects/Inheritance](https://developer.mozilla.org/en-US/docs/Learn/JavaScript/Objects/Inheritance)
- **MDN: extends**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Classes/extends](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Classes/extends)
- **MDN: super**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/super](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/super)
- **JavaScript.info: Class Inheritance**: [javascript.info/class-inheritance](https://javascript.info/class-inheritance)

---

*Lesson completed! You've finished Module 6: Object-Oriented Programming. Ready for Course 2: Intermediate JavaScript!*

