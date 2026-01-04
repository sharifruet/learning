# Lesson 8.3: Bind, Call, and Apply

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the `this` binding problem
- Use `call()` to invoke functions with specific `this`
- Use `apply()` to invoke functions with arrays
- Use `bind()` to create bound functions
- Understand when to use each method
- Fix `this` context issues
- Write more flexible function code

---

## Introduction to Method Binding

JavaScript functions have methods (`call`, `apply`, `bind`) that allow you to control the `this` context and how functions are invoked.

### The `this` Problem

```javascript
let person = {
    name: "Alice",
    greet: function() {
        return `Hello, I'm ${this.name}`;
    }
};

console.log(person.greet());  // "Hello, I'm Alice"

let greetFunc = person.greet;
console.log(greetFunc());    // "Hello, I'm undefined" (lost context)
```

### Solution: call(), apply(), bind()

These methods help control `this` context:
- **call()**: Invoke function with specific `this` and arguments
- **apply()**: Invoke function with specific `this` and array of arguments
- **bind()**: Create new function with bound `this` and arguments

---

## call() Method

The `call()` method invokes a function with a specified `this` value and arguments provided individually.

### Basic Syntax

```javascript
function.call(thisArg, arg1, arg2, ...)
```

### Basic call() Example

```javascript
function greet(greeting, punctuation) {
    return `${greeting}, I'm ${this.name}${punctuation}`;
}

let person = { name: "Alice" };

console.log(greet.call(person, "Hello", "!"));  // "Hello, I'm Alice!"
```

### call() with Methods

```javascript
let person1 = {
    name: "Alice",
    age: 25
};

let person2 = {
    name: "Bob",
    age: 30
};

function introduce() {
    return `Hi, I'm ${this.name} and I'm ${this.age} years old`;
}

console.log(introduce.call(person1));  // "Hi, I'm Alice and I'm 25 years old"
console.log(introduce.call(person2));  // "Hi, I'm Bob and I'm 30 years old"
```

### call() for Method Borrowing

```javascript
let person = {
    firstName: "Alice",
    lastName: "Smith"
};

let person2 = {
    firstName: "Bob",
    lastName: "Jones"
};

function getFullName() {
    return `${this.firstName} ${this.lastName}`;
}

console.log(getFullName.call(person));   // "Alice Smith"
console.log(getFullName.call(person2));  // "Bob Jones"
```

### call() with Arguments

```javascript
function add(a, b, c) {
    return a + b + c;
}

let numbers = [1, 2, 3];
console.log(add.call(null, 1, 2, 3));  // 6
```

---

## apply() Method

The `apply()` method is similar to `call()`, but arguments are provided as an array.

### Basic Syntax

```javascript
function.apply(thisArg, [arg1, arg2, ...])
```

### Basic apply() Example

```javascript
function greet(greeting, punctuation) {
    return `${greeting}, I'm ${this.name}${punctuation}`;
}

let person = { name: "Alice" };
let args = ["Hello", "!"];

console.log(greet.apply(person, args));  // "Hello, I'm Alice!"
```

### apply() vs call()

```javascript
function introduce(greeting, name, age) {
    return `${greeting}, I'm ${name} and I'm ${age} years old`;
}

let person = { name: "Alice" };

// call(): Arguments individually
console.log(introduce.call(person, "Hi", "Alice", 25));

// apply(): Arguments as array
console.log(introduce.apply(person, ["Hi", "Alice", 25]));
```

### apply() with Math Methods

```javascript
let numbers = [5, 10, 15, 20, 25];

// Find maximum
let max = Math.max.apply(null, numbers);
console.log(max);  // 25

// Find minimum
let min = Math.min.apply(null, numbers);
console.log(min);  // 5

// Note: ES6 spread operator is preferred now
let max2 = Math.max(...numbers);  // Modern way
```

### apply() for Array Methods

```javascript
let numbers = [1, 2, 3];
let moreNumbers = [4, 5, 6];

// Push multiple items
numbers.push.apply(numbers, moreNumbers);
console.log(numbers);  // [1, 2, 3, 4, 5, 6]

// Modern way: spread operator
let numbers2 = [1, 2, 3];
numbers2.push(...moreNumbers);
console.log(numbers2);  // [1, 2, 3, 4, 5, 6]
```

---

## bind() Method

The `bind()` method creates a new function with a bound `this` value and optionally pre-filled arguments.

### Basic Syntax

```javascript
function.bind(thisArg, arg1, arg2, ...)
```

### Basic bind() Example

```javascript
let person = {
    name: "Alice",
    greet: function() {
        return `Hello, I'm ${this.name}`;
    }
};

let boundGreet = person.greet.bind(person);
console.log(boundGreet());  // "Hello, I'm Alice"

// Works even when called differently
let greetFunc = boundGreet;
console.log(greetFunc());  // "Hello, I'm Alice" (context preserved)
```

### bind() Preserves Context

```javascript
let person = {
    name: "Alice",
    greet: function() {
        return `Hello, I'm ${this.name}`;
    }
};

// Without bind: loses context
let greetFunc1 = person.greet;
console.log(greetFunc1());  // "Hello, I'm undefined"

// With bind: preserves context
let greetFunc2 = person.greet.bind(person);
console.log(greetFunc2());  // "Hello, I'm Alice"
```

### bind() with Arguments (Partial Application)

```javascript
function multiply(a, b, c) {
    return a * b * c;
}

// Bind first argument
let multiplyBy2 = multiply.bind(null, 2);
console.log(multiplyBy2(3, 4));  // 24 (2 * 3 * 4)

// Bind first two arguments
let multiplyBy2And3 = multiply.bind(null, 2, 3);
console.log(multiplyBy2And3(4));  // 24 (2 * 3 * 4)
```

### bind() in Event Handlers

```javascript
class Button {
    constructor(name) {
        this.name = name;
    }
    
    click() {
        console.log(`Button ${this.name} clicked`);
    }
    
    setup() {
        // Without bind: this is lost
        // button.addEventListener("click", this.click);  // Wrong
        
        // With bind: this is preserved
        button.addEventListener("click", this.click.bind(this));
    }
}
```

### bind() vs call() vs apply()

```javascript
function greet(greeting, name) {
    return `${greeting}, ${name}! I'm ${this.personName}`;
}

let context = { personName: "Alice" };

// call(): Invoke immediately
console.log(greet.call(context, "Hello", "Bob"));  // "Hello, Bob! I'm Alice"

// apply(): Invoke immediately with array
console.log(greet.apply(context, ["Hello", "Bob"]));  // "Hello, Bob! I'm Alice"

// bind(): Create new function, don't invoke
let boundGreet = greet.bind(context, "Hello");
console.log(boundGreet("Bob"));  // "Hello, Bob! I'm Alice"
```

---

## Practical Examples

### Example 1: Method Borrowing

```javascript
let calculator = {
    numbers: [1, 2, 3, 4, 5],
    sum: function() {
        return this.numbers.reduce((a, b) => a + b, 0);
    }
};

let calculator2 = {
    numbers: [10, 20, 30]
};

// Borrow method from calculator
let sum = calculator.sum.call(calculator2);
console.log(sum);  // 60
```

### Example 2: Array-like Objects

```javascript
// Array-like object
let arrayLike = {
    0: "a",
    1: "b",
    2: "c",
    length: 3
};

// Convert to real array
let realArray = Array.prototype.slice.call(arrayLike);
console.log(realArray);  // ["a", "b", "c"]

// Modern way
let realArray2 = Array.from(arrayLike);
```

### Example 3: Function Currying with bind()

```javascript
function add(a, b, c) {
    return a + b + c;
}

// Create curried functions
let add5 = add.bind(null, 5);
let add5And10 = add5.bind(null, 10);

console.log(add5And10(15));  // 30 (5 + 10 + 15)
```

### Example 4: setTimeout with Context

```javascript
let person = {
    name: "Alice",
    sayHello: function() {
        console.log(`Hello from ${this.name}`);
    }
};

// Without bind: this is lost
setTimeout(person.sayHello, 1000);  // "Hello from undefined"

// With bind: this is preserved
setTimeout(person.sayHello.bind(person), 1000);  // "Hello from Alice"
```

### Example 5: Callback Functions

```javascript
let dataProcessor = {
    data: [1, 2, 3, 4, 5],
    multiplier: 2,
    process: function(item) {
        return item * this.multiplier;
    },
    processAll: function() {
        return this.data.map(this.process.bind(this));
    }
};

console.log(dataProcessor.processAll());  // [2, 4, 6, 8, 10]
```

---

## Comparison Table

| Method | Invokes Function? | Arguments Format | Returns |
|--------|------------------|------------------|---------|
| **call()** | Yes (immediately) | Individual arguments | Function result |
| **apply()** | Yes (immediately) | Array of arguments | Function result |
| **bind()** | No (creates function) | Individual arguments | New function |

### When to Use Each

- **call()**: When you know arguments and want to invoke immediately
- **apply()**: When arguments are in an array
- **bind()**: When you want to create a function with preset context/arguments

---

## Practice Exercise

### Exercise: Method Binding

**Objective**: Practice using call(), apply(), and bind() in various scenarios.

**Instructions**:

1. Create a file called `binding-practice.js`

2. Practice:
   - Using call() to set this context
   - Using apply() with arrays
   - Using bind() to create bound functions
   - Method borrowing
   - Event handlers
   - Callback functions

**Example Solution**:

```javascript
// Binding Practice
console.log("=== call() Method ===");

function introduce(greeting, punctuation) {
    return `${greeting}, I'm ${this.name}${punctuation}`;
}

let person1 = { name: "Alice" };
let person2 = { name: "Bob" };

console.log(introduce.call(person1, "Hello", "!"));  // "Hello, I'm Alice!"
console.log(introduce.call(person2, "Hi", "."));      // "Hi, I'm Bob."
console.log();

console.log("=== apply() Method ===");

function add(a, b, c) {
    return a + b + c;
}

let numbers = [1, 2, 3];
console.log(add.apply(null, numbers));  // 6

// Math operations
let values = [5, 10, 15, 20, 25];
let max = Math.max.apply(null, values);
let min = Math.min.apply(null, values);
console.log("Max:", max);  // 25
console.log("Min:", min);  // 5
console.log();

console.log("=== bind() Method ===");

let person = {
    name: "Alice",
    greet: function() {
        return `Hello, I'm ${this.name}`;
    }
};

// Without bind: loses context
let greetFunc1 = person.greet;
console.log("Without bind:", greetFunc1());  // "Hello, I'm undefined"

// With bind: preserves context
let greetFunc2 = person.greet.bind(person);
console.log("With bind:", greetFunc2());  // "Hello, I'm Alice"
console.log();

console.log("=== Partial Application with bind() ===");

function multiply(a, b, c) {
    return a * b * c;
}

// Bind first argument
let multiplyBy2 = multiply.bind(null, 2);
console.log("multiplyBy2(3, 4):", multiplyBy2(3, 4));  // 24

// Bind first two arguments
let multiplyBy2And3 = multiply.bind(null, 2, 3);
console.log("multiplyBy2And3(4):", multiplyBy2And3(4));  // 24

// Bind all arguments
let multiply2By3By4 = multiply.bind(null, 2, 3, 4);
console.log("multiply2By3By4():", multiply2By3By4());  // 24
console.log();

console.log("=== Method Borrowing ===");

let calculator1 = {
    numbers: [1, 2, 3, 4, 5],
    sum: function() {
        return this.numbers.reduce((a, b) => a + b, 0);
    }
};

let calculator2 = {
    numbers: [10, 20, 30]
};

// Borrow sum method
let sum1 = calculator1.sum.call(calculator1);
let sum2 = calculator1.sum.call(calculator2);
console.log("Calculator 1 sum:", sum1);  // 15
console.log("Calculator 2 sum:", sum2);  // 60
console.log();

console.log("=== Array-like Objects ===");

let arrayLike = {
    0: "a",
    1: "b",
    2: "c",
    length: 3
};

// Convert to array using call
let realArray = Array.prototype.slice.call(arrayLike);
console.log("Real array:", realArray);  // ["a", "b", "c"]
console.log();

console.log("=== setTimeout with Context ===");

let timer = {
    name: "Timer",
    start: function() {
        console.log(`${this.name} started`);
    }
};

// Without bind: loses context
setTimeout(timer.start, 100);  // "undefined started"

// With bind: preserves context
setTimeout(timer.start.bind(timer), 200);  // "Timer started"
console.log();

console.log("=== Callback Functions ===");

let processor = {
    multiplier: 5,
    process: function(item) {
        return item * this.multiplier;
    },
    processArray: function(arr) {
        return arr.map(this.process.bind(this));
    }
};

let numbers2 = [1, 2, 3, 4, 5];
let processed = processor.processArray(numbers2);
console.log("Processed:", processed);  // [5, 10, 15, 20, 25]
console.log();

console.log("=== Function Currying ===");

function add(a, b, c) {
    return a + b + c;
}

// Create curried functions
let add5 = add.bind(null, 5);
let add5And10 = add5.bind(null, 10);

console.log("add5(10, 15):", add5(10, 15));        // 30
console.log("add5And10(15):", add5And10(15));      // 30
console.log();

console.log("=== Comparison: call vs apply vs bind ===");

function greet(greeting, name) {
    return `${greeting}, ${name}! I'm ${this.personName}`;
}

let context = { personName: "Alice" };

// call: immediate invocation
let result1 = greet.call(context, "Hello", "Bob");
console.log("call():", result1);  // "Hello, Bob! I'm Alice"

// apply: immediate invocation with array
let result2 = greet.apply(context, ["Hello", "Bob"]);
console.log("apply():", result2);  // "Hello, Bob! I'm Alice"

// bind: create function, don't invoke
let boundGreet = greet.bind(context, "Hello");
let result3 = boundGreet("Bob");
console.log("bind():", result3);  // "Hello, Bob! I'm Alice"
console.log();

console.log("=== Real-World Example: Event Handler ===");

class Button {
    constructor(label) {
        this.label = label;
    }
    
    handleClick() {
        console.log(`Button "${this.label}" was clicked`);
    }
    
    // Simulate adding event listener
    attachHandler() {
        // Simulate: button.addEventListener("click", this.handleClick.bind(this));
        let boundHandler = this.handleClick.bind(this);
        boundHandler();  // Simulate click
    }
}

let button = new Button("Submit");
button.attachHandler();  // "Button "Submit" was clicked"
```

**Expected Output**:
```
=== call() Method ===
Hello, I'm Alice!
Hi, I'm Bob.

=== apply() Method ===
6
Max: 25
Min: 5

=== bind() Method ===
Without bind: Hello, I'm undefined
With bind: Hello, I'm Alice

=== Partial Application with bind() ===
multiplyBy2(3, 4): 24
multiplyBy2And3(4): 24
multiply2By3By4(): 24

=== Method Borrowing ===
Calculator 1 sum: 15
Calculator 2 sum: 60

=== Array-like Objects ===
Real array: [ "a", "b", "c" ]

=== setTimeout with Context ===
undefined started
Timer started

=== Callback Functions ===
Processed: [5, 10, 15, 20, 25]

=== Function Currying ===
add5(10, 15): 30
add5And10(15): 30

=== Comparison: call vs apply vs bind ===
call(): Hello, Bob! I'm Alice
apply(): Hello, Bob! I'm Alice
bind(): Hello, Bob! I'm Alice

=== Real-World Example: Event Handler ===
Button "Submit" was clicked
```

**Challenge (Optional)**:
- Build a method borrowing utility
- Create a function currying system
- Build event handler management
- Create callback wrappers

---

## Common Mistakes

### 1. Forgetting bind() in Callbacks

```javascript
// ⚠️ Problem: Loses context
let obj = {
    name: "Alice",
    method: function() {
        console.log(this.name);
    }
};
setTimeout(obj.method, 100);  // undefined

// ✅ Solution: Use bind()
setTimeout(obj.method.bind(obj), 100);  // "Alice"
```

### 2. Confusing call() and bind()

```javascript
// call(): Invokes immediately
greet.call(context, "Hello");  // Returns result

// bind(): Creates function
let bound = greet.bind(context, "Hello");  // Returns function
bound();  // Now invoke
```

### 3. Wrong Arguments Format

```javascript
// ⚠️ apply() needs array
greet.apply(context, "Hello");  // Error

// ✅ Correct
greet.apply(context, ["Hello"]);
```

### 4. Arrow Functions Don't Work

```javascript
// ⚠️ Arrow functions don't have their own this
let obj = {
    name: "Alice",
    method: () => {
        console.log(this.name);  // undefined (this is from outer scope)
    }
};

// bind() won't help with arrow functions
let bound = obj.method.bind(obj);
bound();  // Still undefined
```

---

## Key Takeaways

1. **call()**: Invoke function with specific `this` and individual arguments
2. **apply()**: Invoke function with specific `this` and array of arguments
3. **bind()**: Create new function with bound `this` and arguments
4. **Method Borrowing**: Use call/apply to borrow methods
5. **Context Preservation**: Use bind() to preserve `this` in callbacks
6. **Partial Application**: Use bind() to pre-fill arguments
7. **Best Practice**: Use bind() for event handlers and callbacks
8. **Modern Alternative**: Arrow functions for simpler cases

---

## Quiz: Binding Methods

Test your understanding with these questions:

1. **What does call() do?**
   - A) Creates function
   - B) Invokes function immediately
   - C) Binds this
   - D) Nothing

2. **apply() takes arguments as:**
   - A) Individual arguments
   - B) Array
   - C) Object
   - D) String

3. **bind() returns:**
   - A) Function result
   - B) New function
   - C) undefined
   - D) this

4. **Which preserves context in callbacks?**
   - A) call()
   - B) apply()
   - C) bind()
   - D) All of them

5. **Which is used for method borrowing?**
   - A) call() and apply()
   - B) bind()
   - C) call() only
   - D) apply() only

6. **bind() with arguments creates:**
   - A) Curried function
   - B) Error
   - C) Nothing
   - D) Array

7. **Arrow functions with bind():**
   - A) Work perfectly
   - B) Don't work (no own this)
   - C) Sometimes work
   - D) Cause errors

**Answers**:
1. B) Invokes function immediately
2. B) Array
3. B) New function
4. C) bind()
5. A) call() and apply()
6. A) Curried function
7. B) Don't work (no own this)

---

## Next Steps

Congratulations! You've completed Module 8: Advanced Functions. You now know:
- How closures work
- How to use IIFEs
- How to control `this` with call, apply, and bind

**What's Next?**
- Module 9: Asynchronous JavaScript
- Lesson 9.1: Callbacks
- Practice combining advanced function techniques
- Build more complex applications

---

## Additional Resources

- **MDN: call()**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/call](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/call)
- **MDN: apply()**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/apply](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/apply)
- **MDN: bind()**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/bind](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/bind)
- **JavaScript.info: Function Methods**: [javascript.info/function-basics](https://javascript.info/function-basics)

---

*Lesson completed! You've finished Module 8: Advanced Functions. Ready for Module 9: Asynchronous JavaScript!*

