# Lesson 10.2: Generators

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand generator functions
- Use the `yield` keyword
- Work with generator methods (next, return, throw)
- Understand generator delegation
- Create infinite generators
- Use generators for iteration
- Build advanced generator patterns

---

## Introduction to Generators

Generators are special functions that can be paused and resumed. They provide a powerful way to create iterators and handle asynchronous operations.

### What are Generators?

A generator function returns a generator object that conforms to both the Iterator and Iterable protocols.

### Why Generators?

- **Lazy Evaluation**: Generate values on demand
- **Memory Efficient**: Don't need to store all values
- **Pausable**: Can pause and resume execution
- **Simpler Iterators**: Easier than manual iterator implementation
- **Async Patterns**: Useful for async operations

---

## Generator Functions

### Basic Generator Syntax

Generator functions are declared with `function*`:

```javascript
function* myGenerator() {
    yield 1;
    yield 2;
    yield 3;
}

let gen = myGenerator();
console.log(gen.next());  // { value: 1, done: false }
console.log(gen.next());  // { value: 2, done: false }
console.log(gen.next());  // { value: 3, done: false }
console.log(gen.next());  // { value: undefined, done: true }
```

### Generator Function Declaration

```javascript
function* generator() {
    yield "Hello";
    yield "World";
}

let gen = generator();
for (let value of gen) {
    console.log(value);  // "Hello", "World"
}
```

### Generator Function Expression

```javascript
let generator = function*() {
    yield 1;
    yield 2;
};

let gen = generator();
console.log(gen.next());  // { value: 1, done: false }
```

### Generator Arrow Function

**Note**: Arrow functions cannot be generators. Must use `function*`.

---

## yield Keyword

The `yield` keyword pauses generator execution and returns a value.

### Basic yield

```javascript
function* simpleGenerator() {
    yield 1;
    yield 2;
    yield 3;
}

let gen = simpleGenerator();
console.log(gen.next().value);  // 1
console.log(gen.next().value);  // 2
console.log(gen.next().value);  // 3
```

### yield with Expressions

```javascript
function* expressionGenerator() {
    yield 1 + 1;
    yield 2 * 2;
    yield 3 ** 3;
}

let gen = expressionGenerator();
for (let value of gen) {
    console.log(value);  // 2, 4, 27
}
```

### yield in Loops

```javascript
function* rangeGenerator(start, end) {
    for (let i = start; i <= end; i++) {
        yield i;
    }
}

let gen = rangeGenerator(1, 5);
for (let num of gen) {
    console.log(num);  // 1, 2, 3, 4, 5
}
```

### yield with return

```javascript
function* generatorWithReturn() {
    yield 1;
    yield 2;
    return "Done";
    yield 3;  // Never reached
}

let gen = generatorWithReturn();
console.log(gen.next());  // { value: 1, done: false }
console.log(gen.next());  // { value: 2, done: false }
console.log(gen.next());  // { value: "Done", done: true }
console.log(gen.next());  // { value: undefined, done: true }
```

---

## Generator Methods

### next() Method

`next()` resumes execution and returns the next value:

```javascript
function* counter() {
    let count = 0;
    while (true) {
        yield count++;
    }
}

let gen = counter();
console.log(gen.next().value);  // 0
console.log(gen.next().value);  // 1
console.log(gen.next().value);  // 2
```

### next() with Arguments

Values passed to `next()` become the result of the `yield` expression:

```javascript
function* generator() {
    let x = yield 1;
    let y = yield x + 2;
    yield y + 3;
}

let gen = generator();
console.log(gen.next());      // { value: 1, done: false }
console.log(gen.next(10));   // { value: 12, done: false } (x = 10)
console.log(gen.next(20));  // { value: 23, done: false } (y = 20)
```

### return() Method

`return()` terminates the generator:

```javascript
function* generator() {
    yield 1;
    yield 2;
    yield 3;
}

let gen = generator();
console.log(gen.next());        // { value: 1, done: false }
console.log(gen.return("End"));  // { value: "End", done: true }
console.log(gen.next());         // { value: undefined, done: true }
```

### throw() Method

`throw()` throws an error into the generator:

```javascript
function* generator() {
    try {
        yield 1;
        yield 2;
    } catch (error) {
        console.log("Caught:", error.message);
        yield 3;
    }
}

let gen = generator();
console.log(gen.next());              // { value: 1, done: false }
console.log(gen.throw(new Error("Error")));  // Caught: Error, { value: 3, done: false }
console.log(gen.next());              // { value: undefined, done: true }
```

---

## Generator Delegation

### yield*

`yield*` delegates to another generator or iterable:

```javascript
function* generator1() {
    yield 1;
    yield 2;
}

function* generator2() {
    yield* generator1();
    yield 3;
    yield 4;
}

let gen = generator2();
for (let value of gen) {
    console.log(value);  // 1, 2, 3, 4
}
```

### yield* with Arrays

```javascript
function* generator() {
    yield* [1, 2, 3];
    yield* "ABC";
}

let gen = generator();
for (let value of gen) {
    console.log(value);  // 1, 2, 3, "A", "B", "C"
}
```

### Recursive Delegation

```javascript
function* treeTraversal(node) {
    yield node.value;
    if (node.children) {
        for (let child of node.children) {
            yield* treeTraversal(child);
        }
    }
}

let tree = {
    value: 1,
    children: [
        { value: 2, children: [] },
        {
            value: 3,
            children: [
                { value: 4, children: [] }
            ]
        }
    ]
};

for (let value of treeTraversal(tree)) {
    console.log(value);  // 1, 2, 3, 4
}
```

---

## Practical Examples

### Example 1: Fibonacci Generator

```javascript
function* fibonacci() {
    let prev = 0;
    let curr = 1;
    
    while (true) {
        yield curr;
        [prev, curr] = [curr, prev + curr];
    }
}

let fib = fibonacci();
let count = 0;
for (let num of fib) {
    console.log(num);
    if (++count >= 10) break;  // First 10 numbers
}
```

### Example 2: Range Generator

```javascript
function* range(start, end, step = 1) {
    for (let i = start; i <= end; i += step) {
        yield i;
    }
}

for (let num of range(0, 10, 2)) {
    console.log(num);  // 0, 2, 4, 6, 8, 10
}
```

### Example 3: Infinite Counter

```javascript
function* counter(start = 0, step = 1) {
    let current = start;
    while (true) {
        yield current;
        current += step;
    }
}

let count = counter(10, 5);
console.log(count.next().value);  // 10
console.log(count.next().value);  // 15
console.log(count.next().value);  // 20
```

### Example 4: Data Processing Pipeline

```javascript
function* numbers() {
    yield* [1, 2, 3, 4, 5];
}

function* squares(iterable) {
    for (let num of iterable) {
        yield num * num;
    }
}

function* evens(iterable) {
    for (let num of iterable) {
        if (num % 2 === 0) {
            yield num;
        }
    }
}

let pipeline = evens(squares(numbers()));
for (let value of pipeline) {
    console.log(value);  // 4, 16 (squares of 2 and 4)
}
```

### Example 5: Async-like Generator

```javascript
function* asyncGenerator() {
    yield new Promise(resolve => setTimeout(() => resolve(1), 1000));
    yield new Promise(resolve => setTimeout(() => resolve(2), 1000));
    yield new Promise(resolve => setTimeout(() => resolve(3), 1000));
}

async function process() {
    for await (let value of asyncGenerator()) {
        console.log(value);  // 1, 2, 3 (with delays)
    }
}

process();
```

---

## Advanced Patterns

### Pattern 1: Generator as State Machine

```javascript
function* stateMachine() {
    while (true) {
        let action = yield;
        switch (action) {
            case "start":
                console.log("Starting...");
                break;
            case "pause":
                console.log("Paused");
                break;
            case "stop":
                console.log("Stopped");
                return;
            default:
                console.log("Unknown action");
        }
    }
}

let machine = stateMachine();
machine.next();  // Initialize
machine.next("start");   // Starting...
machine.next("pause");  // Paused
machine.next("stop");   // Stopped
```

### Pattern 2: Coroutines

```javascript
function* coroutine() {
    let result = yield "First";
    console.log("Received:", result);
    result = yield "Second";
    console.log("Received:", result);
    return "Done";
}

let co = coroutine();
console.log(co.next());        // { value: "First", done: false }
console.log(co.next("Hello")); // Received: Hello, { value: "Second", done: false }
console.log(co.next("World")); // Received: World, { value: "Done", done: true }
```

### Pattern 3: Generator Composition

```javascript
function* map(iterable, fn) {
    for (let item of iterable) {
        yield fn(item);
    }
}

function* filter(iterable, predicate) {
    for (let item of iterable) {
        if (predicate(item)) {
            yield item;
        }
    }
}

function* take(iterable, n) {
    let count = 0;
    for (let item of iterable) {
        if (count++ >= n) break;
        yield item;
    }
}

let numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
let pipeline = take(
    filter(
        map(numbers, x => x * 2),
        x => x > 10
    ),
    3
);

for (let value of pipeline) {
    console.log(value);  // 12, 14, 16
}
```

---

## Practice Exercise

### Exercise: Generator Practice

**Objective**: Practice creating and using generators in various scenarios.

**Instructions**:

1. Create a file called `generators-practice.js`

2. Create generators for:
   - Range generator
   - Fibonacci generator
   - Infinite counter
   - Data processing pipeline
   - State machine

3. Practice:
   - Using yield keyword
   - Generator methods (next, return, throw)
   - Generator delegation
   - for...of with generators

**Example Solution**:

```javascript
// Generators Practice
console.log("=== Basic Generator ===");

function* basicGenerator() {
    yield 1;
    yield 2;
    yield 3;
}

let gen = basicGenerator();
console.log(gen.next());  // { value: 1, done: false }
console.log(gen.next());  // { value: 2, done: false }
console.log(gen.next());  // { value: 3, done: false }
console.log(gen.next());  // { value: undefined, done: true }
console.log();

console.log("=== Generator with for...of ===");

function* rangeGenerator(start, end) {
    for (let i = start; i <= end; i++) {
        yield i;
    }
}

for (let num of rangeGenerator(1, 5)) {
    console.log(num);  // 1, 2, 3, 4, 5
}
console.log();

console.log("=== Fibonacci Generator ===");

function* fibonacci() {
    let prev = 0;
    let curr = 1;
    
    while (true) {
        yield curr;
        [prev, curr] = [curr, prev + curr];
    }
}

let fib = fibonacci();
let count = 0;
console.log("First 10 Fibonacci numbers:");
for (let num of fib) {
    console.log(num);
    if (++count >= 10) break;
}
console.log();

console.log("=== next() with Arguments ===");

function* generatorWithArgs() {
    let x = yield "First";
    console.log("Received x:", x);
    let y = yield "Second";
    console.log("Received y:", y);
    yield x + y;
}

let gen2 = generatorWithArgs();
console.log(gen2.next());      // { value: "First", done: false }
console.log(gen2.next(10));   // Received x: 10, { value: "Second", done: false }
console.log(gen2.next(20));   // Received y: 20, { value: 30, done: false }
console.log();

console.log("=== return() Method ===");

function* generatorWithReturn() {
    yield 1;
    yield 2;
    yield 3;
}

let gen3 = generatorWithReturn();
console.log(gen3.next());           // { value: 1, done: false }
console.log(gen3.return("Early"));  // { value: "Early", done: true }
console.log(gen3.next());           // { value: undefined, done: true }
console.log();

console.log("=== throw() Method ===");

function* generatorWithThrow() {
    try {
        yield 1;
        yield 2;
    } catch (error) {
        console.log("Caught error:", error.message);
        yield 3;
    }
}

let gen4 = generatorWithThrow();
console.log(gen4.next());                    // { value: 1, done: false }
console.log(gen4.throw(new Error("Test"))); // Caught error: Test, { value: 3, done: false }
console.log(gen4.next());                    // { value: undefined, done: true }
console.log();

console.log("=== Generator Delegation ===");

function* generator1() {
    yield 1;
    yield 2;
}

function* generator2() {
    yield* generator1();
    yield 3;
    yield 4;
}

for (let value of generator2()) {
    console.log(value);  // 1, 2, 3, 4
}
console.log();

console.log("=== yield* with Arrays ===");

function* arrayGenerator() {
    yield* [1, 2, 3];
    yield* "ABC";
}

for (let value of arrayGenerator()) {
    console.log(value);  // 1, 2, 3, "A", "B", "C"
}
console.log();

console.log("=== Infinite Generator ===");

function* infiniteCounter(start = 0, step = 1) {
    let current = start;
    while (true) {
        yield current;
        current += step;
    }
}

let counter = infiniteCounter(10, 5);
console.log("First 5 values:");
for (let i = 0; i < 5; i++) {
    console.log(counter.next().value);  // 10, 15, 20, 25, 30
}
console.log();

console.log("=== Data Processing Pipeline ===");

function* numbers() {
    yield* [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
}

function* squares(iterable) {
    for (let num of iterable) {
        yield num * num;
    }
}

function* evens(iterable) {
    for (let num of iterable) {
        if (num % 2 === 0) {
            yield num;
        }
    }
}

let pipeline = evens(squares(numbers()));
console.log("Even squares:");
for (let value of pipeline) {
    console.log(value);  // 4, 16, 36, 64, 100
}
console.log();

console.log("=== State Machine Generator ===");

function* stateMachine() {
    while (true) {
        let action = yield;
        switch (action) {
            case "start":
                console.log("  State: Starting");
                break;
            case "run":
                console.log("  State: Running");
                break;
            case "pause":
                console.log("  State: Paused");
                break;
            case "stop":
                console.log("  State: Stopped");
                return;
            default:
                console.log("  Unknown action:", action);
        }
    }
}

let machine = stateMachine();
machine.next();  // Initialize
machine.next("start");   // State: Starting
machine.next("run");     // State: Running
machine.next("pause");   // State: Paused
machine.next("stop");    // State: Stopped
console.log();

console.log("=== Generator Composition ===");

function* map(iterable, fn) {
    for (let item of iterable) {
        yield fn(item);
    }
}

function* filter(iterable, predicate) {
    for (let item of iterable) {
        if (predicate(item)) {
            yield item;
        }
    }
}

function* take(iterable, n) {
    let count = 0;
    for (let item of iterable) {
        if (count++ >= n) break;
        yield item;
    }
}

let data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
let result = take(
    filter(
        map(data, x => x * 2),
        x => x > 10
    ),
    3
);

console.log("Composed pipeline result:");
for (let value of result) {
    console.log(value);  // 12, 14, 16
}
```

**Expected Output**:
```
=== Basic Generator ===
{ value: 1, done: false }
{ value: 2, done: false }
{ value: 3, done: false }
{ value: undefined, done: true }

=== Generator with for...of ===
1
2
3
4
5

=== Fibonacci Generator ===
First 10 Fibonacci numbers:
1
1
2
3
5
8
13
21
34
55

=== next() with Arguments ===
{ value: "First", done: false }
Received x: 10
{ value: "Second", done: false }
Received y: 20
{ value: 30, done: false }

=== return() Method ===
{ value: 1, done: false }
{ value: "Early", done: true }
{ value: undefined, done: true }

=== throw() Method ===
{ value: 1, done: false }
Caught error: Test
{ value: 3, done: false }
{ value: undefined, done: true }

=== Generator Delegation ===
1
2
3
4

=== yield* with Arrays ===
1
2
3
A
B
C

=== Infinite Generator ===
First 5 values:
10
15
20
25
30

=== Data Processing Pipeline ===
Even squares:
4
16
36
64
100

=== State Machine Generator ===
  State: Starting
  State: Running
  State: Paused
  State: Stopped

=== Generator Composition ===
Composed pipeline result:
12
14
16
```

**Challenge (Optional)**:
- Build a generator-based async library
- Create a tree traversal generator
- Build a file processing generator
- Create a reactive programming system with generators

---

## Common Mistakes

### 1. Forgetting function*

```javascript
// ❌ Error: Not a generator
function myGenerator() {
    yield 1;  // Error: Unexpected token
}

// ✅ Correct: Use function*
function* myGenerator() {
    yield 1;
}
```

### 2. Calling Generator Directly

```javascript
// ⚠️ Problem: Generator function returns generator object
function* generator() {
    yield 1;
}

generator();  // Returns generator, doesn't execute

// ✅ Correct: Call and use
let gen = generator();
gen.next();  // Execute
```

### 3. Not Handling Infinite Generators

```javascript
// ⚠️ Problem: Infinite loop
function* infinite() {
    while (true) {
        yield Math.random();
    }
}

for (let value of infinite()) {
    console.log(value);  // Never ends!
}

// ✅ Solution: Break manually
let count = 0;
for (let value of infinite()) {
    console.log(value);
    if (++count >= 10) break;
}
```

### 4. Misunderstanding yield Return Value

```javascript
// ⚠️ Confusion: yield returns value passed to next()
function* generator() {
    let x = yield 1;  // x is value from next()
}

let gen = generator();
gen.next();      // Returns { value: 1, done: false }
gen.next(10);    // x becomes 10
```

---

## Key Takeaways

1. **Generator Functions**: Declared with `function*`
2. **yield**: Pauses execution and returns value
3. **next()**: Resumes execution, can pass value
4. **return()**: Terminates generator
5. **throw()**: Throws error into generator
6. **yield***: Delegates to another generator/iterable
7. **Iterable**: Generators are iterable (work with for...of)
8. **Best Practice**: Use generators for lazy evaluation and iteration

---

## Quiz: Generators

Test your understanding with these questions:

1. **Generator functions use:**
   - A) function
   - B) function*
   - C) function**
   - D) generator

2. **yield keyword:**
   - A) Returns value
   - B) Pauses execution
   - C) Both A and B
   - D) Nothing

3. **next() method:**
   - A) Starts generator
   - B) Resumes execution
   - C) Stops generator
   - D) Returns error

4. **yield* delegates to:**
   - A) Another generator
   - B) Iterable
   - C) Both A and B
   - D) Function

5. **Generators are:**
   - A) Iterators
   - B) Iterables
   - C) Both
   - D) Neither

6. **return() method:**
   - A) Returns value
   - B) Terminates generator
   - C) Both A and B
   - D) Resumes generator

7. **Infinite generators need:**
   - A) Auto-stop
   - B) Manual break
   - C) Error
   - D) Nothing

**Answers**:
1. B) function*
2. C) Both A and B
3. B) Resumes execution
4. C) Both A and B
5. C) Both
6. C) Both A and B
7. B) Manual break

---

## Next Steps

Congratulations! You've completed Module 10: Iterators and Generators. You now know:
- How iterators work
- How to create custom iterators
- How generators work
- How to use yield and generator methods

**What's Next?**
- Module 11: Modules
- Lesson 11.1: ES6 Modules
- Practice combining iterators and generators
- Build more advanced patterns

---

## Additional Resources

- **MDN: Generator Functions**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/function*](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/function*)
- **MDN: yield**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/yield](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/yield)
- **JavaScript.info: Generators**: [javascript.info/generators](https://javascript.info/generators)
- **Generator Patterns**: Advanced patterns and use cases

---

*Lesson completed! You've finished Module 10: Iterators and Generators. Ready for Module 11: Modules!*

