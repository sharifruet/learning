# Lesson 19.3: Behavioral Patterns

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand behavioral design patterns
- Implement the Observer pattern
- Implement the Strategy pattern
- Implement the Command pattern
- Choose appropriate patterns
- Apply patterns to solve problems
- Build flexible communication systems

---

## Introduction to Behavioral Patterns

Behavioral patterns focus on communication between objects and how responsibilities are distributed.

### Why Behavioral Patterns?

- **Communication**: Better object communication
- **Flexibility**: Easier to change behavior
- **Reusability**: Reuse communication patterns
- **Maintainability**: Clearer responsibilities
- **Decoupling**: Reduce dependencies
- **Best Practices**: Proven communication solutions

### Common Behavioral Patterns

1. **Observer**: Notify multiple objects of changes
2. **Strategy**: Encapsulate algorithms
3. **Command**: Encapsulate requests

---

## Observer Pattern

### What is Observer?

Observer defines a one-to-many dependency between objects so when one changes, all dependents are notified.

### Basic Observer

```javascript
class Subject {
    constructor() {
        this.observers = [];
    }
    
    subscribe(observer) {
        this.observers.push(observer);
    }
    
    unsubscribe(observer) {
        this.observers = this.observers.filter(obs => obs !== observer);
    }
    
    notify(data) {
        this.observers.forEach(observer => observer.update(data));
    }
}

class Observer {
    constructor(name) {
        this.name = name;
    }
    
    update(data) {
        console.log(`${this.name} received:`, data);
    }
}

// Usage
let subject = new Subject();
let observer1 = new Observer('Observer 1');
let observer2 = new Observer('Observer 2');

subject.subscribe(observer1);
subject.subscribe(observer2);

subject.notify('Hello');
// Observer 1 received: Hello
// Observer 2 received: Hello
```

### Observer with Events

```javascript
class EventEmitter {
    constructor() {
        this.events = {};
    }
    
    on(event, callback) {
        if (!this.events[event]) {
            this.events[event] = [];
        }
        this.events[event].push(callback);
    }
    
    off(event, callback) {
        if (this.events[event]) {
            this.events[event] = this.events[event].filter(cb => cb !== callback);
        }
    }
    
    emit(event, data) {
        if (this.events[event]) {
            this.events[event].forEach(callback => callback(data));
        }
    }
}

// Usage
let emitter = new EventEmitter();

emitter.on('userLogin', (user) => {
    console.log('User logged in:', user);
});

emitter.on('userLogin', (user) => {
    console.log('Sending welcome email to:', user.email);
});

emitter.emit('userLogin', { name: 'Alice', email: 'alice@example.com' });
```

### Practical Observer Example

```javascript
class Stock {
    constructor(symbol, price) {
        this.symbol = symbol;
        this.price = price;
        this.observers = [];
    }
    
    subscribe(observer) {
        this.observers.push(observer);
    }
    
    unsubscribe(observer) {
        this.observers = this.observers.filter(obs => obs !== observer);
    }
    
    setPrice(price) {
        if (this.price !== price) {
            this.price = price;
            this.notify();
        }
    }
    
    notify() {
        this.observers.forEach(observer => {
            observer.update(this.symbol, this.price);
        });
    }
}

class PriceDisplay {
    constructor() {
        this.prices = {};
    }
    
    update(symbol, price) {
        this.prices[symbol] = price;
        console.log(`${symbol}: $${price}`);
    }
    
    getPrice(symbol) {
        return this.prices[symbol];
    }
}

// Usage
let stock = new Stock('AAPL', 150);
let display = new PriceDisplay();

stock.subscribe(display);
stock.setPrice(155);  // AAPL: $155
stock.setPrice(160);  // AAPL: $160
```

---

## Strategy Pattern

### What is Strategy?

Strategy defines a family of algorithms, encapsulates each, and makes them interchangeable.

### Basic Strategy

```javascript
// Strategy interface
class PaymentStrategy {
    pay(amount) {
        throw new Error('Method must be implemented');
    }
}

// Concrete strategies
class CreditCardStrategy extends PaymentStrategy {
    constructor(cardNumber, cvv) {
        super();
        this.cardNumber = cardNumber;
        this.cvv = cvv;
    }
    
    pay(amount) {
        console.log(`Paid $${amount} using credit card ${this.cardNumber}`);
    }
}

class PayPalStrategy extends PaymentStrategy {
    constructor(email) {
        super();
        this.email = email;
    }
    
    pay(amount) {
        console.log(`Paid $${amount} using PayPal ${this.email}`);
    }
}

class BitcoinStrategy extends PaymentStrategy {
    constructor(walletAddress) {
        super();
        this.walletAddress = walletAddress;
    }
    
    pay(amount) {
        console.log(`Paid $${amount} using Bitcoin ${this.walletAddress}`);
    }
}

// Context
class PaymentProcessor {
    constructor(strategy) {
        this.strategy = strategy;
    }
    
    setStrategy(strategy) {
        this.strategy = strategy;
    }
    
    processPayment(amount) {
        this.strategy.pay(amount);
    }
}

// Usage
let processor = new PaymentProcessor(new CreditCardStrategy('1234-5678', '123'));
processor.processPayment(100);

processor.setStrategy(new PayPalStrategy('alice@example.com'));
processor.processPayment(200);
```

### Strategy with Functions

```javascript
// Strategy as functions
let strategies = {
    add: (a, b) => a + b,
    subtract: (a, b) => a - b,
    multiply: (a, b) => a * b,
    divide: (a, b) => {
        if (b === 0) throw new Error('Division by zero');
        return a / b;
    }
};

class Calculator {
    constructor() {
        this.strategy = strategies.add;
    }
    
    setStrategy(operation) {
        if (strategies[operation]) {
            this.strategy = strategies[operation];
        } else {
            throw new Error('Unknown operation');
        }
    }
    
    calculate(a, b) {
        return this.strategy(a, b);
    }
}

// Usage
let calc = new Calculator();
console.log(calc.calculate(10, 5));  // 15

calc.setStrategy('multiply');
console.log(calc.calculate(10, 5));  // 50
```

### Practical Strategy Example

```javascript
// Sorting strategies
class SortStrategy {
    sort(array) {
        throw new Error('Method must be implemented');
    }
}

class BubbleSort extends SortStrategy {
    sort(array) {
        let arr = [...array];
        for (let i = 0; i < arr.length; i++) {
            for (let j = 0; j < arr.length - i - 1; j++) {
                if (arr[j] > arr[j + 1]) {
                    [arr[j], arr[j + 1]] = [arr[j + 1], arr[j]];
                }
            }
        }
        return arr;
    }
}

class QuickSort extends SortStrategy {
    sort(array) {
        if (array.length <= 1) return array;
        let pivot = array[Math.floor(array.length / 2)];
        let left = array.filter(x => x < pivot);
        let middle = array.filter(x => x === pivot);
        let right = array.filter(x => x > pivot);
        return [...this.sort(left), ...middle, ...this.sort(right)];
    }
}

class Sorter {
    constructor(strategy) {
        this.strategy = strategy;
    }
    
    setStrategy(strategy) {
        this.strategy = strategy;
    }
    
    sort(array) {
        return this.strategy.sort(array);
    }
}

// Usage
let numbers = [64, 34, 25, 12, 22, 11, 90];
let sorter = new Sorter(new BubbleSort());
console.log('Bubble sort:', sorter.sort(numbers));

sorter.setStrategy(new QuickSort());
console.log('Quick sort:', sorter.sort(numbers));
```

---

## Command Pattern

### What is Command?

Command encapsulates a request as an object, allowing parameterization and queuing of requests.

### Basic Command

```javascript
// Command interface
class Command {
    execute() {
        throw new Error('Method must be implemented');
    }
    
    undo() {
        throw new Error('Method must be implemented');
    }
}

// Concrete commands
class LightOnCommand extends Command {
    constructor(light) {
        super();
        this.light = light;
    }
    
    execute() {
        this.light.turnOn();
    }
    
    undo() {
        this.light.turnOff();
    }
}

class LightOffCommand extends Command {
    constructor(light) {
        super();
        this.light = light;
    }
    
    execute() {
        this.light.turnOff();
    }
    
    undo() {
        this.light.turnOn();
    }
}

// Receiver
class Light {
    turnOn() {
        console.log('Light is ON');
    }
    
    turnOff() {
        console.log('Light is OFF');
    }
}

// Invoker
class RemoteControl {
    constructor() {
        this.command = null;
        this.history = [];
    }
    
    setCommand(command) {
        this.command = command;
    }
    
    pressButton() {
        if (this.command) {
            this.command.execute();
            this.history.push(this.command);
        }
    }
    
    undo() {
        if (this.history.length > 0) {
            let lastCommand = this.history.pop();
            lastCommand.undo();
        }
    }
}

// Usage
let light = new Light();
let lightOn = new LightOnCommand(light);
let lightOff = new LightOffCommand(light);

let remote = new RemoteControl();
remote.setCommand(lightOn);
remote.pressButton();  // Light is ON

remote.setCommand(lightOff);
remote.pressButton();  // Light is OFF

remote.undo();  // Light is ON
```

### Command with Queue

```javascript
class CommandQueue {
    constructor() {
        this.queue = [];
        this.executing = false;
    }
    
    add(command) {
        this.queue.push(command);
        if (!this.executing) {
            this.executeNext();
        }
    }
    
    async executeNext() {
        if (this.queue.length === 0) {
            this.executing = false;
            return;
        }
        
        this.executing = true;
        let command = this.queue.shift();
        await command.execute();
        this.executeNext();
    }
}

// Usage
class DelayCommand {
    constructor(delay, message) {
        this.delay = delay;
        this.message = message;
    }
    
    async execute() {
        return new Promise(resolve => {
            setTimeout(() => {
                console.log(this.message);
                resolve();
            }, this.delay);
        });
    }
}

let queue = new CommandQueue();
queue.add(new DelayCommand(1000, 'First'));
queue.add(new DelayCommand(500, 'Second'));
queue.add(new DelayCommand(200, 'Third'));
// Executes in order
```

### Practical Command Example

```javascript
// Text editor commands
class TextEditor {
    constructor() {
        this.content = '';
        this.history = [];
    }
    
    write(text) {
        this.content += text;
    }
    
    delete(length) {
        this.content = this.content.slice(0, -length);
    }
    
    getContent() {
        return this.content;
    }
}

class WriteCommand {
    constructor(editor, text) {
        this.editor = editor;
        this.text = text;
    }
    
    execute() {
        this.editor.write(this.text);
        this.editor.history.push(this);
    }
    
    undo() {
        this.editor.delete(this.text.length);
    }
}

class DeleteCommand {
    constructor(editor, length) {
        this.editor = editor;
        this.length = length;
        this.deletedText = '';
    }
    
    execute() {
        this.deletedText = this.editor.content.slice(-this.length);
        this.editor.delete(this.length);
        this.editor.history.push(this);
    }
    
    undo() {
        this.editor.write(this.deletedText);
    }
}

// Usage
let editor = new TextEditor();
let writeHello = new WriteCommand(editor, 'Hello');
let writeWorld = new WriteCommand(editor, ' World');

writeHello.execute();
writeWorld.execute();
console.log(editor.getContent());  // 'Hello World'

let lastCommand = editor.history.pop();
lastCommand.undo();
console.log(editor.getContent());  // 'Hello'
```

---

## Practice Exercise

### Exercise: Behavioral Patterns

**Objective**: Practice implementing Observer, Strategy, and Command patterns.

**Instructions**:

1. Create a JavaScript file
2. Practice:
   - Creating observers
   - Implementing strategies
   - Building commands
   - Applying patterns to real problems

**Example Solution**:

```javascript
// behavioral-patterns-practice.js
console.log("=== Behavioral Patterns Practice ===");

console.log("\n=== Observer Pattern ===");

// Basic Observer
class Subject {
    constructor() {
        this.observers = [];
    }
    
    subscribe(observer) {
        this.observers.push(observer);
    }
    
    unsubscribe(observer) {
        this.observers = this.observers.filter(obs => obs !== observer);
    }
    
    notify(data) {
        this.observers.forEach(observer => observer.update(data));
    }
}

class Observer {
    constructor(name) {
        this.name = name;
    }
    
    update(data) {
        console.log(`${this.name} received:`, data);
    }
}

let subject = new Subject();
let observer1 = new Observer('Observer 1');
let observer2 = new Observer('Observer 2');

subject.subscribe(observer1);
subject.subscribe(observer2);

subject.notify('Hello');
subject.unsubscribe(observer1);
subject.notify('World');

// Event Emitter
class EventEmitter {
    constructor() {
        this.events = {};
    }
    
    on(event, callback) {
        if (!this.events[event]) {
            this.events[event] = [];
        }
        this.events[event].push(callback);
    }
    
    off(event, callback) {
        if (this.events[event]) {
            this.events[event] = this.events[event].filter(cb => cb !== callback);
        }
    }
    
    emit(event, data) {
        if (this.events[event]) {
            this.events[event].forEach(callback => callback(data));
        }
    }
}

let emitter = new EventEmitter();

emitter.on('userLogin', (user) => {
    console.log('User logged in:', user.name);
});

emitter.on('userLogin', (user) => {
    console.log('Sending email to:', user.email);
});

emitter.emit('userLogin', { name: 'Alice', email: 'alice@example.com' });
console.log();

console.log("=== Strategy Pattern ===");

// Payment strategies
class PaymentStrategy {
    pay(amount) {
        throw new Error('Method must be implemented');
    }
}

class CreditCardStrategy extends PaymentStrategy {
    constructor(cardNumber) {
        super();
        this.cardNumber = cardNumber;
    }
    
    pay(amount) {
        console.log(`Paid $${amount} using credit card ${this.cardNumber}`);
    }
}

class PayPalStrategy extends PaymentStrategy {
    constructor(email) {
        super();
        this.email = email;
    }
    
    pay(amount) {
        console.log(`Paid $${amount} using PayPal ${this.email}`);
    }
}

class PaymentProcessor {
    constructor(strategy) {
        this.strategy = strategy;
    }
    
    setStrategy(strategy) {
        this.strategy = strategy;
    }
    
    processPayment(amount) {
        this.strategy.pay(amount);
    }
}

let processor = new PaymentProcessor(new CreditCardStrategy('1234-5678'));
processor.processPayment(100);

processor.setStrategy(new PayPalStrategy('alice@example.com'));
processor.processPayment(200);

// Function strategies
let strategies = {
    add: (a, b) => a + b,
    subtract: (a, b) => a - b,
    multiply: (a, b) => a * b,
    divide: (a, b) => {
        if (b === 0) throw new Error('Division by zero');
        return a / b;
    }
};

class Calculator {
    constructor() {
        this.strategy = strategies.add;
    }
    
    setStrategy(operation) {
        if (strategies[operation]) {
            this.strategy = strategies[operation];
        } else {
            throw new Error('Unknown operation');
        }
    }
    
    calculate(a, b) {
        return this.strategy(a, b);
    }
}

let calc = new Calculator();
console.log('10 + 5 =', calc.calculate(10, 5));

calc.setStrategy('multiply');
console.log('10 * 5 =', calc.calculate(10, 5));
console.log();

console.log("=== Command Pattern ===");

// Basic Command
class Command {
    execute() {
        throw new Error('Method must be implemented');
    }
    
    undo() {
        throw new Error('Method must be implemented');
    }
}

class LightOnCommand extends Command {
    constructor(light) {
        super();
        this.light = light;
    }
    
    execute() {
        this.light.turnOn();
    }
    
    undo() {
        this.light.turnOff();
    }
}

class LightOffCommand extends Command {
    constructor(light) {
        super();
        this.light = light;
    }
    
    execute() {
        this.light.turnOff();
    }
    
    undo() {
        this.light.turnOn();
    }
}

class Light {
    turnOn() {
        console.log('Light is ON');
    }
    
    turnOff() {
        console.log('Light is OFF');
    }
}

class RemoteControl {
    constructor() {
        this.history = [];
    }
    
    executeCommand(command) {
        command.execute();
        this.history.push(command);
    }
    
    undo() {
        if (this.history.length > 0) {
            let lastCommand = this.history.pop();
            lastCommand.undo();
        }
    }
}

let light = new Light();
let remote = new RemoteControl();

remote.executeCommand(new LightOnCommand(light));
remote.executeCommand(new LightOffCommand(light));
remote.undo();

// Text Editor Commands
class TextEditor {
    constructor() {
        this.content = '';
        this.history = [];
    }
    
    write(text) {
        this.content += text;
    }
    
    delete(length) {
        this.content = this.content.slice(0, -length);
    }
    
    getContent() {
        return this.content;
    }
}

class WriteCommand {
    constructor(editor, text) {
        this.editor = editor;
        this.text = text;
    }
    
    execute() {
        this.editor.write(this.text);
        this.editor.history.push(this);
    }
    
    undo() {
        this.editor.delete(this.text.length);
    }
}

let editor = new TextEditor();
let writeHello = new WriteCommand(editor, 'Hello');
let writeWorld = new WriteCommand(editor, ' World');

writeHello.execute();
writeWorld.execute();
console.log('Content:', editor.getContent());

let lastCommand = editor.history.pop();
lastCommand.undo();
console.log('After undo:', editor.getContent());
```

**Expected Output**:
```
=== Behavioral Patterns Practice ===

=== Observer Pattern ===
Observer 1 received: Hello
Observer 2 received: Hello
Observer 2 received: World
User logged in: Alice
Sending email to: alice@example.com

=== Strategy Pattern ===
Paid $100 using credit card 1234-5678
Paid $200 using PayPal alice@example.com
10 + 5 = 15
10 * 5 = 50

=== Command Pattern ===
Light is ON
Light is OFF
Light is ON
Content: Hello World
After undo: Hello
```

**Challenge (Optional)**:
- Build a complete application using all three patterns
- Create an event system
- Build a plugin system
- Practice combining patterns

---

## Common Mistakes

### 1. Observer Memory Leaks

```javascript
// ⚠️ Problem: Observers not removed
subject.subscribe(observer);
// Observer never unsubscribed

// ✅ Solution: Always unsubscribe
subject.subscribe(observer);
// Later...
subject.unsubscribe(observer);
```

### 2. Strategy Not Swappable

```javascript
// ⚠️ Problem: Strategy hardcoded
class Processor {
    process() {
        // Hardcoded strategy
    }
}

// ✅ Solution: Make strategy swappable
class Processor {
    constructor(strategy) {
        this.strategy = strategy;
    }
    
    setStrategy(strategy) {
        this.strategy = strategy;
    }
}
```

### 3. Command Without Undo

```javascript
// ⚠️ Problem: No undo capability
class Command {
    execute() { }
    // Missing undo
}

// ✅ Solution: Implement undo
class Command {
    execute() { }
    undo() { }
}
```

---

## Key Takeaways

1. **Observer**: Notify multiple objects of changes
2. **Strategy**: Encapsulate interchangeable algorithms
3. **Command**: Encapsulate requests as objects
4. **When to Use**: Choose based on communication needs
5. **Best Practice**: Keep patterns simple and focused
6. **Memory**: Unsubscribe observers to prevent leaks
7. **Flexibility**: Patterns enable runtime behavior changes

---

## Quiz: Behavioral Patterns

Test your understanding with these questions:

1. **Observer pattern:**
   - A) One-to-many dependency
   - B) Many-to-one dependency
   - C) One-to-one
   - D) None

2. **Strategy pattern:**
   - A) Encapsulates algorithms
   - B) Encapsulates data
   - C) Encapsulates nothing
   - D) Random

3. **Command pattern:**
   - A) Encapsulates requests
   - B) Encapsulates responses
   - C) Encapsulates nothing
   - D) Random

4. **Observer subscribe:**
   - A) Adds observer
   - B) Removes observer
   - C) Notifies observer
   - D) Nothing

5. **Strategy is:**
   - A) Swappable
   - B) Fixed
   - C) Random
   - D) None

6. **Command can:**
   - A) Execute
   - B) Undo
   - C) Both
   - D) Neither

7. **Behavioral patterns focus on:**
   - A) Communication
   - B) Creation
   - C) Structure
   - D) Nothing

**Answers**:
1. A) One-to-many dependency
2. A) Encapsulates algorithms
3. A) Encapsulates requests
4. A) Adds observer
5. A) Swappable
6. C) Both
7. A) Communication

---

## Next Steps

Congratulations! You've completed Module 19: Design Patterns. You now know:
- Creational patterns (Singleton, Factory, Builder)
- Structural patterns (Module, Facade, Decorator)
- Behavioral patterns (Observer, Strategy, Command)
- When to use each pattern

**What's Next?**
- Module 20: Error Handling and Debugging
- Lesson 20.1: Advanced Error Handling
- Learn error types and handling strategies
- Build robust error handling

---

## Additional Resources

- **MDN: Error Handling**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Control_flow_and_error_handling](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Control_flow_and_error_handling)
- **Design Patterns**: [refactoring.guru/design-patterns](https://refactoring.guru/design-patterns)

---

*Lesson completed! You've finished Module 19: Design Patterns. Ready for Module 20: Error Handling and Debugging!*

