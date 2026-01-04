# Lesson 3.2: Loops

## Learning Objectives

By the end of this lesson, you will be able to:
- Use for loops to iterate a specific number of times
- Use while loops for condition-based iteration
- Use do...while loops for guaranteed execution
- Iterate over objects with for...in loops
- Iterate over iterables with for...of loops
- Control loop execution with break and continue
- Create and understand nested loops
- Choose the right loop for different scenarios

---

## Introduction to Loops

Loops allow you to execute a block of code repeatedly. They are essential for:
- Processing arrays and collections
- Repeating actions
- Iterating through data
- Automating repetitive tasks

---

## for Loop

The `for` loop is used when you know how many times you want to iterate.

### Basic Syntax

```javascript
for (initialization; condition; increment) {
    // Code to execute
}
```

### Simple Example

```javascript
for (let i = 0; i < 5; i++) {
    console.log(i);
}
// Output: 0, 1, 2, 3, 4
```

### How It Works

1. **Initialization**: `let i = 0` - Runs once at the start
2. **Condition**: `i < 5` - Checked before each iteration
3. **Code Block**: Executes if condition is true
4. **Increment**: `i++` - Runs after each iteration
5. **Repeat**: Go back to step 2

### Common Patterns

**Count from 0 to n-1:**
```javascript
for (let i = 0; i < 5; i++) {
    console.log(i);
}
// 0, 1, 2, 3, 4
```

**Count from 1 to n:**
```javascript
for (let i = 1; i <= 5; i++) {
    console.log(i);
}
// 1, 2, 3, 4, 5
```

**Count backwards:**
```javascript
for (let i = 5; i > 0; i--) {
    console.log(i);
}
// 5, 4, 3, 2, 1
```

**Count by steps:**
```javascript
for (let i = 0; i < 10; i += 2) {
    console.log(i);
}
// 0, 2, 4, 6, 8
```

### Iterating Over Arrays

```javascript
let fruits = ["apple", "banana", "orange"];

for (let i = 0; i < fruits.length; i++) {
    console.log(fruits[i]);
}
// Output: apple, banana, orange
```

### Practical Examples

**Sum numbers:**
```javascript
let sum = 0;
for (let i = 1; i <= 10; i++) {
    sum += i;
}
console.log(sum);  // 55
```

**Build a string:**
```javascript
let result = "";
for (let i = 0; i < 5; i++) {
    result += "*";
}
console.log(result);  // "*****"
```

**Calculate factorial:**
```javascript
let n = 5;
let factorial = 1;
for (let i = 1; i <= n; i++) {
    factorial *= i;
}
console.log(factorial);  // 120
```

---

## while Loop

The `while` loop continues as long as a condition is true.

### Basic Syntax

```javascript
while (condition) {
    // Code to execute
}
```

### Simple Example

```javascript
let i = 0;
while (i < 5) {
    console.log(i);
    i++;
}
// Output: 0, 1, 2, 3, 4
```

### When to Use while

- When you don't know how many iterations
- When condition depends on external factors
- When you need to check condition before each iteration

### Examples

**Countdown:**
```javascript
let countdown = 5;
while (countdown > 0) {
    console.log(countdown);
    countdown--;
}
console.log("Blast off!");
// Output: 5, 4, 3, 2, 1, "Blast off!"
```

**User input simulation:**
```javascript
let userInput = "";
while (userInput !== "quit") {
    // Simulate getting input
    userInput = getUserInput();
    processInput(userInput);
}
```

**Processing until condition:**
```javascript
let total = 0;
let number = 1;
while (total < 100) {
    total += number;
    number++;
}
console.log(total);  // First sum >= 100
```

### Infinite Loops Warning

**⚠️ Be careful - this creates an infinite loop:**
```javascript
// ❌ Infinite loop!
let i = 0;
while (i < 5) {
    console.log(i);
    // Forgot to increment i!
}
```

**✅ Always ensure condition becomes false:**
```javascript
let i = 0;
while (i < 5) {
    console.log(i);
    i++;  // Increment to avoid infinite loop
}
```

---

## do...while Loop

The `do...while` loop executes the code block at least once, then checks the condition.

### Basic Syntax

```javascript
do {
    // Code to execute
} while (condition);
```

### Simple Example

```javascript
let i = 0;
do {
    console.log(i);
    i++;
} while (i < 5);
// Output: 0, 1, 2, 3, 4
```

### Key Difference from while

**while** - checks condition first (may not execute):
```javascript
let i = 10;
while (i < 5) {
    console.log(i);  // Never executes
    i++;
}
```

**do...while** - executes at least once:
```javascript
let i = 10;
do {
    console.log(i);  // Executes once: 10
    i++;
} while (i < 5);
```

### When to Use do...while

- When you need code to run at least once
- Menu systems
- Input validation (try at least once)

### Example: Menu System

```javascript
let choice;
do {
    console.log("1. Option 1");
    console.log("2. Option 2");
    console.log("3. Quit");
    choice = getUserChoice();
    processChoice(choice);
} while (choice !== 3);
```

---

## for...in Loop

The `for...in` loop iterates over the enumerable properties of an object.

### Basic Syntax

```javascript
for (let key in object) {
    // Code using key
}
```

### Iterating Over Objects

```javascript
let person = {
    name: "Alice",
    age: 25,
    city: "New York"
};

for (let key in person) {
    console.log(key + ": " + person[key]);
}
// Output:
// name: Alice
// age: 25
// city: New York
```

### Important Notes

**Order is not guaranteed** (though modern JS engines usually maintain insertion order for string keys)

**Only enumerable properties:**
```javascript
let obj = {
    a: 1,
    b: 2
};

Object.defineProperty(obj, 'c', {
    value: 3,
    enumerable: false  // Not enumerable
});

for (let key in obj) {
    console.log(key);  // Only 'a' and 'b'
}
```

### With Arrays (Not Recommended)

```javascript
let arr = ["a", "b", "c"];

for (let index in arr) {
    console.log(index, arr[index]);
}
// Output: "0 a", "1 b", "2 c"
// But index is a string, not a number!
```

**⚠️ Use for...of or regular for loop for arrays instead**

### Practical Example

```javascript
let config = {
    host: "localhost",
    port: 3000,
    debug: true
};

for (let key in config) {
    console.log(`Setting ${key} to ${config[key]}`);
}
```

---

## for...of Loop

The `for...of` loop iterates over iterable objects (arrays, strings, etc.).

### Basic Syntax

```javascript
for (let item of iterable) {
    // Code using item
}
```

### Iterating Over Arrays

```javascript
let fruits = ["apple", "banana", "orange"];

for (let fruit of fruits) {
    console.log(fruit);
}
// Output: apple, banana, orange
```

### Iterating Over Strings

```javascript
let text = "Hello";

for (let char of text) {
    console.log(char);
}
// Output: H, e, l, l, o
```

### Getting Index with for...of

```javascript
let fruits = ["apple", "banana", "orange"];

for (let [index, fruit] of fruits.entries()) {
    console.log(index, fruit);
}
// Output: 0 apple, 1 banana, 2 orange
```

### for...of vs for...in

**for...of** (values):
```javascript
let arr = ["a", "b", "c"];
for (let value of arr) {
    console.log(value);  // "a", "b", "c"
}
```

**for...in** (keys/indices):
```javascript
let arr = ["a", "b", "c"];
for (let index in arr) {
    console.log(index);  // "0", "1", "2" (strings!)
}
```

### When to Use for...of

- ✅ Arrays
- ✅ Strings
- ✅ Other iterables (Maps, Sets, NodeLists)
- ✅ When you need values, not indices

### Practical Examples

**Process array items:**
```javascript
let numbers = [1, 2, 3, 4, 5];
let sum = 0;

for (let num of numbers) {
    sum += num;
}
console.log(sum);  // 15
```

**Find item:**
```javascript
let users = ["Alice", "Bob", "Charlie"];
let found = false;

for (let user of users) {
    if (user === "Bob") {
        found = true;
        break;
    }
}
```

---

## break Statement

The `break` statement exits a loop immediately.

### Basic Usage

```javascript
for (let i = 0; i < 10; i++) {
    if (i === 5) {
        break;  // Exit loop when i is 5
    }
    console.log(i);
}
// Output: 0, 1, 2, 3, 4
```

### Examples

**Find first match:**
```javascript
let numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
let found = null;

for (let num of numbers) {
    if (num > 5) {
        found = num;
        break;  // Stop searching
    }
}
console.log(found);  // 6
```

**Exit on condition:**
```javascript
let count = 0;
while (true) {
    count++;
    if (count > 10) {
        break;  // Exit infinite loop
    }
    console.log(count);
}
```

**In switch (different context):**
```javascript
switch (day) {
    case "Monday":
        console.log("Start of week");
        break;  // Exit switch
    case "Friday":
        console.log("End of week");
        break;
}
```

---

## continue Statement

The `continue` statement skips the rest of the current iteration and continues with the next.

### Basic Usage

```javascript
for (let i = 0; i < 10; i++) {
    if (i % 2 === 0) {
        continue;  // Skip even numbers
    }
    console.log(i);
}
// Output: 1, 3, 5, 7, 9
```

### Examples

**Skip specific values:**
```javascript
let numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

for (let num of numbers) {
    if (num % 2 === 0) {
        continue;  // Skip even numbers
    }
    console.log(num);  // Only odd numbers
}
// Output: 1, 3, 5, 7, 9
```

**Process only valid items:**
```javascript
let data = [1, null, 3, undefined, 5, "", 7];

for (let item of data) {
    if (!item) {
        continue;  // Skip falsy values
    }
    console.log(item);
}
// Output: 1, 3, 5, 7
```

**Skip on condition:**
```javascript
for (let i = 0; i < 10; i++) {
    if (i < 3) {
        continue;  // Skip first 3 iterations
    }
    console.log(i);
}
// Output: 3, 4, 5, 6, 7, 8, 9
```

### break vs continue

**break** - exits the loop:
```javascript
for (let i = 0; i < 10; i++) {
    if (i === 5) {
        break;  // Loop stops here
    }
    console.log(i);
}
// Output: 0, 1, 2, 3, 4
```

**continue** - skips to next iteration:
```javascript
for (let i = 0; i < 10; i++) {
    if (i === 5) {
        continue;  // Skip 5, continue with 6
    }
    console.log(i);
}
// Output: 0, 1, 2, 3, 4, 6, 7, 8, 9
```

---

## Nested Loops

You can place loops inside other loops to create nested iterations.

### Basic Nested Structure

```javascript
for (let i = 0; i < 3; i++) {
    for (let j = 0; j < 3; j++) {
        console.log(i, j);
    }
}
// Output:
// 0 0, 0 1, 0 2
// 1 0, 1 1, 1 2
// 2 0, 2 1, 2 2
```

### Multiplication Table

```javascript
for (let i = 1; i <= 5; i++) {
    for (let j = 1; j <= 5; j++) {
        console.log(`${i} x ${j} = ${i * j}`);
    }
    console.log("---");
}
```

### 2D Array Processing

```javascript
let matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
];

for (let i = 0; i < matrix.length; i++) {
    for (let j = 0; j < matrix[i].length; j++) {
        console.log(matrix[i][j]);
    }
}
```

### Pattern Printing

```javascript
// Print triangle
for (let i = 1; i <= 5; i++) {
    let row = "";
    for (let j = 1; j <= i; j++) {
        row += "*";
    }
    console.log(row);
}
// Output:
// *
// **
// ***
// ****
// *****
```

### Performance Consideration

**⚠️ Nested loops can be slow:**
```javascript
// O(n²) complexity
for (let i = 0; i < 1000; i++) {
    for (let j = 0; j < 1000; j++) {
        // This runs 1,000,000 times!
    }
}
```

### break and continue in Nested Loops

**break** - exits only the innermost loop:
```javascript
for (let i = 0; i < 3; i++) {
    for (let j = 0; j < 3; j++) {
        if (j === 1) {
            break;  // Only breaks inner loop
        }
        console.log(i, j);
    }
}
// Output: 0 0, 1 0, 2 0
```

**Labeled break** - exits outer loop:
```javascript
outer: for (let i = 0; i < 3; i++) {
    for (let j = 0; j < 3; j++) {
        if (j === 1) {
            break outer;  // Breaks outer loop
        }
        console.log(i, j);
    }
}
// Output: 0 0
```

---

## Choosing the Right Loop

### When to Use Each Loop

**for loop:**
- Known number of iterations
- Iterating over arrays with index
- Counting

**while loop:**
- Unknown number of iterations
- Condition-based iteration
- Waiting for external condition

**do...while loop:**
- Need to execute at least once
- Menu systems
- Input validation

**for...in loop:**
- Iterating over object properties
- Need keys, not values

**for...of loop:**
- Iterating over arrays/iterables
- Need values, not indices
- Modern, clean syntax

### Comparison Table

| Loop | Use Case | Example |
|------|----------|---------|
| for | Known iterations | `for (let i = 0; i < 10; i++)` |
| while | Condition-based | `while (condition)` |
| do...while | At least once | `do { } while (condition)` |
| for...in | Object properties | `for (let key in obj)` |
| for...of | Iterables | `for (let item of array)` |

---

## Practice Exercise

### Exercise: Loop Practice

**Objective**: Write programs using different types of loops to solve various problems.

**Instructions**:

1. Create a file called `loop-practice.js`

2. Complete these tasks:
   - Count from 1 to 10 using for loop
   - Calculate sum of numbers 1-100 using for loop
   - Print multiplication table using nested loops
   - Iterate over an array using for...of
   - Iterate over an object using for...in
   - Use while loop to find first number > 100
   - Use break to exit loop early
   - Use continue to skip certain values
   - Print patterns using nested loops

**Example Solution**:

```javascript
// Loop Practice
console.log("=== For Loop: Count 1-10 ===");
for (let i = 1; i <= 10; i++) {
    console.log(i);
}
console.log();

console.log("=== For Loop: Sum 1-100 ===");
let sum = 0;
for (let i = 1; i <= 100; i++) {
    sum += i;
}
console.log(`Sum: ${sum}`);  // 5050
console.log();

console.log("=== Nested Loops: Multiplication Table ===");
for (let i = 1; i <= 5; i++) {
    let row = "";
    for (let j = 1; j <= 5; j++) {
        row += `${i * j}\t`;
    }
    console.log(row);
}
console.log();

console.log("=== For...of: Array Iteration ===");
let fruits = ["apple", "banana", "orange", "grape"];
for (let fruit of fruits) {
    console.log(fruit);
}
console.log();

console.log("=== For...in: Object Iteration ===");
let person = {
    name: "Alice",
    age: 25,
    city: "New York",
    occupation: "Developer"
};
for (let key in person) {
    console.log(`${key}: ${person[key]}`);
}
console.log();

console.log("=== While Loop: Find First > 100 ===");
let numbers = [45, 67, 89, 102, 134, 156];
let i = 0;
while (i < numbers.length) {
    if (numbers[i] > 100) {
        console.log(`First number > 100: ${numbers[i]}`);
        break;
    }
    i++;
}
console.log();

console.log("=== Break: Exit Early ===");
for (let i = 1; i <= 10; i++) {
    if (i === 6) {
        console.log("Stopping at 6");
        break;
    }
    console.log(i);
}
console.log();

console.log("=== Continue: Skip Even Numbers ===");
for (let i = 1; i <= 10; i++) {
    if (i % 2 === 0) {
        continue;  // Skip even numbers
    }
    console.log(i);
}
console.log();

console.log("=== Nested Loops: Pattern ===");
for (let i = 1; i <= 5; i++) {
    let pattern = "";
    for (let j = 1; j <= i; j++) {
        pattern += "*";
    }
    console.log(pattern);
}
console.log();

console.log("=== Do...While: At Least Once ===");
let count = 10;
do {
    console.log(`Count: ${count}`);
    count++;
} while (count < 5);  // Condition is false, but executes once
console.log();

console.log("=== Complex: Process 2D Array ===");
let matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
];
let total = 0;
for (let row of matrix) {
    for (let cell of row) {
        total += cell;
    }
}
console.log(`Sum of all cells: ${total}`);  // 45
```

**Expected Output**:
```
=== For Loop: Count 1-10 ===
1
2
3
4
5
6
7
8
9
10

=== For Loop: Sum 1-100 ===
Sum: 5050

=== Nested Loops: Multiplication Table ===
1	2	3	4	5	
2	4	6	8	10	
3	6	9	12	15	
4	8	12	16	20	
5	10	15	20	25	

=== For...of: Array Iteration ===
apple
banana
orange
grape

=== For...in: Object Iteration ===
name: Alice
age: 25
city: New York
occupation: Developer

=== While Loop: Find First > 100 ===
First number > 100: 102

=== Break: Exit Early ===
1
2
3
4
5
Stopping at 6

=== Continue: Skip Even Numbers ===
1
3
5
7
9

=== Nested Loops: Pattern ===
*
**
***
****
*****

=== Do...While: At Least Once ===
Count: 10

=== Complex: Process 2D Array ===
Sum of all cells: 45
```

**Challenge (Optional)**:
- Create a number guessing game with loops
- Build a calendar generator
- Create a pattern generator (diamonds, triangles)
- Process nested data structures
- Optimize nested loops

---

## Common Mistakes

### 1. Infinite Loops

```javascript
// ❌ Infinite loop
let i = 0;
while (i < 5) {
    console.log(i);
    // Forgot to increment!
}

// ✅ Always increment
let i = 0;
while (i < 5) {
    console.log(i);
    i++;
}
```

### 2. Off-by-One Errors

```javascript
// ❌ Wrong range
for (let i = 0; i <= 5; i++) { }  // 0-5 (6 iterations)

// ✅ Correct range
for (let i = 0; i < 5; i++) { }   // 0-4 (5 iterations)
```

### 3. Modifying Array During Iteration

```javascript
// ⚠️ Can cause issues
let arr = [1, 2, 3, 4, 5];
for (let i = 0; i < arr.length; i++) {
    if (arr[i] === 2) {
        arr.splice(i, 1);  // Modifies array
    }
}

// ✅ Better: iterate backwards or use filter
```

### 4. Using for...in on Arrays

```javascript
// ⚠️ Not recommended
let arr = [1, 2, 3];
for (let index in arr) {
    console.log(typeof index);  // "string"!
}

// ✅ Use for...of
for (let value of arr) {
    console.log(value);
}
```

### 5. Confusing break and continue

```javascript
// break - exits loop
for (let i = 0; i < 10; i++) {
    if (i === 5) break;  // Loop stops at 5
}

// continue - skips iteration
for (let i = 0; i < 10; i++) {
    if (i === 5) continue;  // Skips 5, continues
}
```

---

## Key Takeaways

1. **for Loop**: Best for known iterations
2. **while Loop**: Best for condition-based iteration
3. **do...while**: Executes at least once
4. **for...in**: Iterates over object properties
5. **for...of**: Iterates over iterable values
6. **break**: Exits loop immediately
7. **continue**: Skips to next iteration
8. **Nested Loops**: Loops inside loops (watch performance)
9. **Choose Wisely**: Pick the right loop for the task

---

## Quiz: Loops

Test your understanding with these questions:

1. **How many times does this loop run? `for (let i = 0; i < 5; i++)`**
   - A) 4
   - B) 5
   - C) 6
   - D) Infinite

2. **What does `break` do in a loop?**
   - A) Skips current iteration
   - B) Exits the loop
   - C) Continues to next iteration
   - D) Restarts the loop

3. **Which loop executes at least once?**
   - A) for
   - B) while
   - C) do...while
   - D) for...of

4. **What does `continue` do?**
   - A) Exits the loop
   - B) Skips to next iteration
   - C) Restarts the loop
   - D) Breaks the loop

5. **Which is best for iterating over array values?**
   - A) for...in
   - B) for...of
   - C) while
   - D) do...while

6. **What is the output of: `for (let i = 0; i < 3; i++) { if (i === 1) continue; console.log(i); }`**
   - A) 0, 1, 2
   - B) 0, 2
   - C) 1, 2
   - D) 0, 1

7. **Which creates an infinite loop?**
   - A) `for (let i = 0; i < 5; i++)`
   - B) `while (true) { break; }`
   - C) `while (false) { }`
   - D) `while (true) { }` (no break)

**Answers**:
1. B) 5 (0, 1, 2, 3, 4)
2. B) Exits the loop
3. C) do...while
4. B) Skips to next iteration
5. B) for...of
6. B) 0, 2 (skips 1)
7. D) `while (true) { }` (no break)

---

## Next Steps

Congratulations! You've learned all about loops. You now know:
- How to use for, while, and do...while loops
- How to iterate with for...in and for...of
- How to control loops with break and continue
- How to create nested loops

**What's Next?**
- Lesson 3.3: Error Handling
- Practice with different loop types
- Build programs using loops
- Optimize loop performance

---

## Additional Resources

- **MDN: for**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/for](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/for)
- **MDN: while**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/while](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/while)
- **MDN: for...of**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/for...of](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/for...of)
- **MDN: for...in**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/for...in](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/for...in)
- **JavaScript.info: Loops**: [javascript.info/while-for](https://javascript.info/while-for)

---

*Lesson completed! You're ready to move on to the next lesson.*

