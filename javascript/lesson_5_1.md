# Lesson 5.1: Objects

## Learning Objectives

By the end of this lesson, you will be able to:
- Create objects using object literals
- Access object properties using dot and bracket notation
- Add, modify, and delete object properties
- Create and use object methods
- Understand the `this` keyword
- Work with nested objects
- Iterate over object properties

---

## Introduction to Objects

Objects are collections of key-value pairs. They're fundamental to JavaScript and used to represent real-world entities, organize data, and structure code.

### What are Objects?

Objects store data as properties (keys) with associated values. They're similar to dictionaries in other languages.

```javascript
// Simple object
let person = {
    name: "Alice",
    age: 25,
    city: "New York"
};
```

### Why Use Objects?

- Organize related data
- Represent real-world entities
- Group functionality (methods)
- Create complex data structures
- Enable object-oriented programming

---

## Object Literals

Object literals are the most common way to create objects in JavaScript.

### Basic Syntax

```javascript
let objectName = {
    key1: value1,
    key2: value2,
    key3: value3
};
```

### Simple Example

```javascript
let person = {
    name: "Alice",
    age: 25,
    city: "New York"
};
```

### Different Value Types

Objects can contain any type of value:

```javascript
let person = {
    name: "Alice",           // String
    age: 25,                  // Number
    isActive: true,           // Boolean
    hobbies: ["reading", "coding"],  // Array
    address: {                // Nested object
        street: "123 Main St",
        city: "New York"
    },
    greet: function() {        // Function
        return "Hello!";
    }
};
```

### Empty Object

```javascript
let emptyObj = {};
let person = {};  // Start empty, add properties later
```

### Shorthand Property Names (ES6)

If variable name matches property name:

```javascript
let name = "Alice";
let age = 25;

// Old way
let person = {
    name: name,
    age: age
};

// ES6 shorthand
let person = {
    name,
    age
};
```

---

## Accessing Properties

### Dot Notation

Use dot notation for simple property access:

```javascript
let person = {
    name: "Alice",
    age: 25
};

console.log(person.name);  // "Alice"
console.log(person.age);   // 25
```

### Bracket Notation

Use bracket notation for dynamic property access or when property names contain special characters:

```javascript
let person = {
    name: "Alice",
    age: 25,
    "first name": "Alice"  // Property with space
};

console.log(person["name"]);        // "Alice"
console.log(person["age"]);        // 25
console.log(person["first name"]); // "Alice" (required for spaces)
```

### When to Use Each

**Dot notation** (preferred):
- Simple property names
- Known at coding time
- Cleaner syntax

**Bracket notation** (required when):
- Property name has spaces or special characters
- Property name is stored in a variable
- Property name is computed dynamically

```javascript
let person = {
    name: "Alice",
    "first name": "Alice"
};

// Dot notation
console.log(person.name);  // "Alice"

// Bracket notation (required for space)
console.log(person["first name"]);  // "Alice"

// Dynamic access
let prop = "name";
console.log(person[prop]);  // "Alice" (must use brackets)
```

### Accessing Nested Properties

```javascript
let person = {
    name: "Alice",
    address: {
        street: "123 Main St",
        city: "New York",
        country: {
            name: "USA",
            code: "US"
        }
    }
};

console.log(person.address.city);                    // "New York"
console.log(person.address.country.name);            // "USA"
console.log(person["address"]["city"]);             // "New York"
console.log(person.address["country"]["name"]);     // "USA"
```

### Safe Property Access

Check if property exists before accessing:

```javascript
let person = {
    name: "Alice"
};

// Check before access
if (person.age !== undefined) {
    console.log(person.age);
}

// Or use optional chaining (ES2020)
console.log(person?.age);  // undefined (no error)
```

---

## Adding and Modifying Properties

### Adding Properties

You can add properties to objects at any time:

```javascript
let person = {
    name: "Alice"
};

// Add new property
person.age = 25;
person.city = "New York";

console.log(person);  // { name: "Alice", age: 25, city: "New York" }
```

### Modifying Properties

Change existing property values:

```javascript
let person = {
    name: "Alice",
    age: 25
};

// Modify property
person.age = 26;
person.name = "Alice Smith";

console.log(person);  // { name: "Alice Smith", age: 26 }
```

### Using Bracket Notation

```javascript
let person = {};

// Add with bracket notation
person["name"] = "Alice";
person["age"] = 25;

// Modify with bracket notation
person["age"] = 26;
```

### Dynamic Property Names

```javascript
let person = {};
let propertyName = "email";
let propertyValue = "alice@example.com";

person[propertyName] = propertyValue;
console.log(person.email);  // "alice@example.com"
```

### Computed Property Names (ES6)

```javascript
let prefix = "user";
let person = {
    [prefix + "Name"]: "Alice",
    [prefix + "Age"]: 25
};

console.log(person.userName);  // "Alice"
console.log(person.userAge);   // 25
```

---

## Deleting Properties

Use the `delete` operator to remove properties from objects.

### Basic Deletion

```javascript
let person = {
    name: "Alice",
    age: 25,
    city: "New York"
};

delete person.city;
console.log(person);  // { name: "Alice", age: 25 }
```

### Delete with Dot Notation

```javascript
let person = {
    name: "Alice",
    age: 25
};

delete person.age;
console.log(person.age);  // undefined
```

### Delete with Bracket Notation

```javascript
let person = {
    name: "Alice",
    age: 25
};

delete person["age"];
console.log(person);  // { name: "Alice" }
```

### Checking if Property Exists

```javascript
let person = {
    name: "Alice"
};

// Check before deleting
if ("age" in person) {
    delete person.age;
}

// Or check after
delete person.age;
if (!("age" in person)) {
    console.log("Age property deleted");
}
```

### Cannot Delete Variables

```javascript
// ❌ Cannot delete variables
let x = 5;
delete x;  // false (doesn't work)

// ✅ Can delete object properties
let obj = { x: 5 };
delete obj.x;  // true (works)
```

---

## Object Methods

Methods are functions stored as object properties.

### Creating Methods

```javascript
let person = {
    name: "Alice",
    age: 25,
    greet: function() {
        return `Hello, I'm ${this.name}`;
    }
};

console.log(person.greet());  // "Hello, I'm Alice"
```

### Method Shorthand (ES6)

```javascript
// Old way
let person = {
    greet: function() {
        return "Hello!";
    }
};

// ES6 shorthand
let person = {
    greet() {
        return "Hello!";
    }
};
```

### Multiple Methods

```javascript
let calculator = {
    add(a, b) {
        return a + b;
    },
    subtract(a, b) {
        return a - b;
    },
    multiply(a, b) {
        return a * b;
    },
    divide(a, b) {
        return a / b;
    }
};

console.log(calculator.add(5, 3));        // 8
console.log(calculator.multiply(5, 3));  // 15
```

### Methods Accessing Properties

```javascript
let person = {
    firstName: "Alice",
    lastName: "Smith",
    getFullName() {
        return `${this.firstName} ${this.lastName}`;
    },
    setAge(age) {
        this.age = age;
    }
};

console.log(person.getFullName());  // "Alice Smith"
person.setAge(25);
console.log(person.age);            // 25
```

---

## this Keyword

The `this` keyword refers to the object that owns the method.

### Understanding this

```javascript
let person = {
    name: "Alice",
    greet() {
        console.log(`Hello, I'm ${this.name}`);
    }
};

person.greet();  // "Hello, I'm Alice"
// this refers to person object
```

### this in Methods

```javascript
let person = {
    name: "Alice",
    age: 25,
    introduce() {
        return `I'm ${this.name}, ${this.age} years old`;
    },
    haveBirthday() {
        this.age++;
        return `Happy birthday! Now I'm ${this.age}`;
    }
};

console.log(person.introduce());     // "I'm Alice, 25 years old"
console.log(person.haveBirthday());  // "Happy birthday! Now I'm 26"
console.log(person.introduce());     // "I'm Alice, 26 years old"
```

### this Context

`this` depends on how the function is called:

```javascript
let person = {
    name: "Alice",
    greet() {
        console.log(this.name);
    }
};

person.greet();  // "Alice" (this = person)

let greetFunc = person.greet;
greetFunc();     // undefined (this = global/window)
```

### Arrow Functions and this

Arrow functions don't have their own `this` - they inherit from surrounding scope:

```javascript
let person = {
    name: "Alice",
    regular: function() {
        console.log(this.name);  // "Alice"
    },
    arrow: () => {
        console.log(this.name);  // undefined (no this binding)
    }
};

person.regular();  // "Alice"
person.arrow();    // undefined
```

**Best Practice**: Use regular functions for object methods that need `this`.

---

## Nested Objects

Objects can contain other objects, creating nested structures.

### Simple Nesting

```javascript
let person = {
    name: "Alice",
    address: {
        street: "123 Main St",
        city: "New York",
        zipCode: "10001"
    }
};

console.log(person.address.city);  // "New York"
```

### Deep Nesting

```javascript
let company = {
    name: "Tech Corp",
    location: {
        address: {
            street: "123 Tech St",
            city: "San Francisco",
            country: {
                name: "USA",
                code: "US"
            }
        }
    }
};

console.log(company.location.address.country.name);  // "USA"
```

### Modifying Nested Objects

```javascript
let person = {
    name: "Alice",
    address: {
        city: "New York"
    }
};

// Modify nested property
person.address.city = "Boston";
person.address.street = "456 Oak Ave";

// Add nested property
person.address.zipCode = "02101";

console.log(person.address);
// { city: "Boston", street: "456 Oak Ave", zipCode: "02101" }
```

---

## Iterating Over Objects

### for...in Loop

```javascript
let person = {
    name: "Alice",
    age: 25,
    city: "New York"
};

for (let key in person) {
    console.log(key + ": " + person[key]);
}
// name: Alice
// age: 25
// city: New York
```

### Object.keys()

Get array of property names:

```javascript
let person = {
    name: "Alice",
    age: 25,
    city: "New York"
};

let keys = Object.keys(person);
console.log(keys);  // ["name", "age", "city"]

keys.forEach(key => {
    console.log(key, person[key]);
});
```

### Object.values()

Get array of property values:

```javascript
let person = {
    name: "Alice",
    age: 25,
    city: "New York"
};

let values = Object.values(person);
console.log(values);  // ["Alice", 25, "New York"]
```

### Object.entries()

Get array of [key, value] pairs:

```javascript
let person = {
    name: "Alice",
    age: 25,
    city: "New York"
};

let entries = Object.entries(person);
console.log(entries);
// [["name", "Alice"], ["age", 25], ["city", "New York"]]

entries.forEach(([key, value]) => {
    console.log(key, value);
});
```

---

## Practice Exercise

### Exercise: Object Manipulation

**Objective**: Create and manipulate objects using various techniques.

**Instructions**:

1. Create a file called `objects-practice.js`

2. Create objects for:
   - A person with properties and methods
   - A product with nested properties
   - A calculator with methods

3. Practice:
   - Creating objects with literals
   - Accessing properties (dot and bracket)
   - Adding and modifying properties
   - Deleting properties
   - Creating and using methods
   - Using `this` keyword
   - Iterating over objects

**Example Solution**:

```javascript
// Objects Practice
console.log("=== Creating Objects ===");

// Person object
let person = {
    firstName: "Alice",
    lastName: "Smith",
    age: 25,
    city: "New York",
    isActive: true
};

console.log("Person:", person);
console.log();

console.log("=== Accessing Properties ===");
// Dot notation
console.log("Name (dot):", person.firstName);
console.log("Age (dot):", person.age);

// Bracket notation
console.log("Name (bracket):", person["firstName"]);
console.log("Age (bracket):", person["age"]);

// Dynamic access
let property = "city";
console.log("City (dynamic):", person[property]);
console.log();

console.log("=== Adding Properties ===");
person.email = "alice@example.com";
person["phone"] = "555-1234";
person.hobbies = ["reading", "coding"];

console.log("After adding:", person);
console.log();

console.log("=== Modifying Properties ===");
person.age = 26;
person["city"] = "Boston";
person.hobbies.push("traveling");

console.log("After modifying:", person);
console.log();

console.log("=== Deleting Properties ===");
delete person.phone;
delete person["isActive"];

console.log("After deleting:", person);
console.log();

console.log("=== Object Methods ===");
let calculator = {
    result: 0,
    add(num) {
        this.result += num;
        return this;
    },
    subtract(num) {
        this.result -= num;
        return this;
    },
    multiply(num) {
        this.result *= num;
        return this;
    },
    divide(num) {
        this.result /= num;
        return this;
    },
    getResult() {
        return this.result;
    },
    reset() {
        this.result = 0;
        return this;
    }
};

calculator.add(10).multiply(2).subtract(5);
console.log("Calculator result:", calculator.getResult());  // 15
calculator.reset();
console.log("After reset:", calculator.getResult());  // 0
console.log();

console.log("=== Using this Keyword ===");
let user = {
    name: "Bob",
    age: 30,
    introduce() {
        return `Hi, I'm ${this.name} and I'm ${this.age} years old`;
    },
    haveBirthday() {
        this.age++;
        return `Happy birthday! Now I'm ${this.age}`;
    },
    getInfo() {
        return {
            name: this.name,
            age: this.age
        };
    }
};

console.log(user.introduce());     // "Hi, I'm Bob and I'm 30 years old"
console.log(user.haveBirthday());  // "Happy birthday! Now I'm 31"
console.log(user.getInfo());       // { name: "Bob", age: 31 }
console.log();

console.log("=== Nested Objects ===");
let product = {
    name: "Laptop",
    price: 999.99,
    specifications: {
        brand: "TechBrand",
        model: "TB-2024",
        processor: {
            type: "Intel",
            speed: "3.5GHz",
            cores: 8
        },
        memory: {
            ram: "16GB",
            storage: "512GB SSD"
        }
    },
    getFullSpecs() {
        return `${this.name} - ${this.specifications.brand} ${this.specifications.model}`;
    }
};

console.log("Product:", product.name);
console.log("Brand:", product.specifications.brand);
console.log("Processor:", product.specifications.processor.type);
console.log("RAM:", product.specifications.memory.ram);
console.log("Full specs:", product.getFullSpecs());
console.log();

console.log("=== Iterating Over Objects ===");
let student = {
    name: "Charlie",
    age: 20,
    grade: "A",
    subjects: ["Math", "Science", "English"]
};

// for...in
console.log("Using for...in:");
for (let key in student) {
    console.log(`${key}: ${student[key]}`);
}

// Object.keys()
console.log("\nUsing Object.keys():");
Object.keys(student).forEach(key => {
    console.log(`${key}: ${student[key]}`);
});

// Object.values()
console.log("\nUsing Object.values():");
Object.values(student).forEach(value => {
    console.log(value);
});

// Object.entries()
console.log("\nUsing Object.entries():");
Object.entries(student).forEach(([key, value]) => {
    console.log(`${key}: ${value}`);
});
console.log();

console.log("=== Computed Property Names ===");
let prefix = "user";
let dynamicObj = {
    [prefix + "Id"]: 123,
    [prefix + "Name"]: "Alice",
    [prefix + "Email"]: "alice@example.com"
};

console.log("Dynamic object:", dynamicObj);
console.log("User ID:", dynamicObj.userId);
console.log();

console.log("=== Object Methods with Parameters ===");
let bankAccount = {
    balance: 1000,
    deposit(amount) {
        this.balance += amount;
        return `Deposited $${amount}. New balance: $${this.balance}`;
    },
    withdraw(amount) {
        if (amount > this.balance) {
            return "Insufficient funds";
        }
        this.balance -= amount;
        return `Withdrew $${amount}. New balance: $${this.balance}`;
    },
    getBalance() {
        return `Current balance: $${this.balance}`;
    }
};

console.log(bankAccount.getBalance());        // "Current balance: $1000"
console.log(bankAccount.deposit(500));        // "Deposited $500. New balance: $1500"
console.log(bankAccount.withdraw(200));       // "Withdrew $200. New balance: $1300"
console.log(bankAccount.withdraw(2000));      // "Insufficient funds"
console.log(bankAccount.getBalance());        // "Current balance: $1300"
```

**Expected Output**:
```
=== Creating Objects ===
Person: { firstName: "Alice", lastName: "Smith", age: 25, city: "New York", isActive: true }

=== Accessing Properties ===
Name (dot): Alice
Age (dot): 25
Name (bracket): Alice
Age (bracket): 25
City (dynamic): New York

=== Adding Properties ===
After adding: { firstName: "Alice", lastName: "Smith", age: 25, city: "New York", isActive: true, email: "alice@example.com", phone: "555-1234", hobbies: ["reading", "coding"] }

=== Modifying Properties ===
After modifying: { firstName: "Alice", lastName: "Smith", age: 26, city: "Boston", isActive: true, email: "alice@example.com", phone: "555-1234", hobbies: ["reading", "coding", "traveling"] }

=== Deleting Properties ===
After deleting: { firstName: "Alice", lastName: "Smith", age: 26, city: "Boston", email: "alice@example.com", hobbies: ["reading", "coding", "traveling"] }

=== Object Methods ===
Calculator result: 15
After reset: 0

=== Using this Keyword ===
Hi, I'm Bob and I'm 30 years old
Happy birthday! Now I'm 31
{ name: "Bob", age: 31 }

=== Nested Objects ===
Product: Laptop
Brand: TechBrand
Processor: Intel
RAM: 16GB
Full specs: Laptop - TechBrand TB-2024

=== Iterating Over Objects ===
Using for...in:
name: Charlie
age: 20
grade: A
subjects: Math,Science,English

Using Object.keys():
name: Charlie
age: 20
grade: A
subjects: Math,Science,English

Using Object.values():
Charlie
20
A
[ "Math", "Science", "English" ]

Using Object.entries():
name: Charlie
age: 20
grade: A
subjects: Math,Science,English

=== Computed Property Names ===
Dynamic object: { userId: 123, userName: "Alice", userEmail: "alice@example.com" }
User ID: 123

=== Object Methods with Parameters ===
Current balance: $1000
Deposited $500. New balance: $1500
Withdrew $200. New balance: $1300
Insufficient funds
Current balance: $1300
```

**Challenge (Optional)**:
- Create a library management system with objects
- Build a shopping cart with object methods
- Create a user profile system
- Build a game character system

---

## Common Mistakes

### 1. Accessing Non-existent Properties

```javascript
// ⚠️ Returns undefined, not error
let person = { name: "Alice" };
console.log(person.age);  // undefined

// ✅ Check first
if (person.age !== undefined) {
    console.log(person.age);
}
```

### 2. Wrong this Context

```javascript
let person = {
    name: "Alice",
    greet() {
        console.log(this.name);
    }
};

// ⚠️ Loses this context
let greetFunc = person.greet;
greetFunc();  // undefined

// ✅ Keep context
person.greet();  // "Alice"
```

### 3. Forgetting Quotes for Special Keys

```javascript
// ❌ Error: Invalid syntax
// let obj = { first name: "Alice" };

// ✅ Use quotes
let obj = { "first name": "Alice" };
console.log(obj["first name"]);  // Must use brackets
```

### 4. Confusing Dot and Bracket

```javascript
let person = { name: "Alice" };
let prop = "name";

// ❌ Wrong
console.log(person.prop);  // undefined

// ✅ Correct
console.log(person[prop]);  // "Alice"
```

### 5. Modifying const Objects

```javascript
const person = { name: "Alice" };

// ✅ Can modify properties
person.age = 25;  // Works

// ❌ Cannot reassign object
// person = { name: "Bob" };  // Error
```

---

## Key Takeaways

1. **Object Literals**: `{ key: value }` - most common way to create objects
2. **Property Access**: Dot notation (simple) or bracket notation (dynamic)
3. **Adding/Modifying**: Assign to property (creates or updates)
4. **Deleting**: Use `delete` operator
5. **Methods**: Functions as object properties
6. **this Keyword**: Refers to object owning the method
7. **Nested Objects**: Objects can contain other objects
8. **Iteration**: Use `for...in`, `Object.keys()`, `Object.values()`, `Object.entries()`

---

## Quiz: Objects

Test your understanding with these questions:

1. **How do you access property `name` in object `person`?**
   - A) `person[name]`
   - B) `person.name` or `person["name"]`
   - C) `person->name`
   - D) `person::name`

2. **What does `delete person.age` do?**
   - A) Sets age to null
   - B) Sets age to undefined
   - C) Removes age property
   - D) Nothing

3. **What does `this` refer to in an object method?**
   - A) The function
   - B) The object
   - C) Global object
   - D) undefined

4. **Which creates an object method?**
   - A) `method: function() {}`
   - B) `method() {}`
   - C) Both A and B
   - D) Neither

5. **How do you iterate over object properties?**
   - A) `for...in`
   - B) `Object.keys()`
   - C) `Object.entries()`
   - D) All of the above

6. **What is the output: `let obj = {}; obj.x = 5; console.log(obj.x)`?**
   - A) undefined
   - B) 5
   - C) Error
   - D) null

7. **Arrow functions in object methods:**
   - A) Have their own `this`
   - B) Don't have `this` binding
   - C) Always undefined
   - D) Error

**Answers**:
1. B) `person.name` or `person["name"]`
2. C) Removes age property
3. B) The object
4. C) Both A and B (both valid)
5. D) All of the above
6. B) 5
7. B) Don't have `this` binding

---

## Next Steps

Congratulations! You've learned about objects. You now know:
- How to create and access objects
- How to add, modify, and delete properties
- How to create methods and use `this`
- How to work with nested objects

**What's Next?**
- Lesson 5.2: Arrays
- Practice combining objects and arrays
- Learn about object methods
- Build more complex data structures

---

## Additional Resources

- **MDN: Objects**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Working_with_Objects](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Working_with_Objects)
- **MDN: this**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/this](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/this)
- **JavaScript.info: Objects**: [javascript.info/object](https://javascript.info/object)
- **JavaScript.info: Object Methods**: [javascript.info/object-methods](https://javascript.info/object-methods)

---

*Lesson completed! You're ready to move on to the next lesson.*

