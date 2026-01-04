# Lesson 5.2: Arrays

## Learning Objectives

By the end of this lesson, you will be able to:
- Create arrays using different methods
- Access and modify array elements
- Use array modification methods (push, pop, shift, unshift, splice, slice)
- Iterate over arrays (forEach, map, filter, reduce)
- Search arrays (indexOf, find, includes)
- Understand array immutability vs mutability
- Work with array methods effectively

---

## Introduction to Arrays

Arrays are ordered collections of values. They're one of the most important data structures in JavaScript.

### What are Arrays?

Arrays store multiple values in a single variable, accessible by index (position).

```javascript
let fruits = ["apple", "banana", "orange"];
```

### Why Use Arrays?

- Store multiple related values
- Maintain order
- Easy iteration
- Powerful built-in methods
- Common data structure

---

## Creating Arrays

### Array Literal (Most Common)

```javascript
let fruits = ["apple", "banana", "orange"];
let numbers = [1, 2, 3, 4, 5];
let mixed = ["hello", 42, true, null];
```

### Array Constructor

```javascript
let fruits = new Array("apple", "banana", "orange");
let numbers = new Array(5);  // Creates array with 5 empty slots
```

**Note**: Array literal `[]` is preferred over constructor.

### Empty Array

```javascript
let empty = [];
let alsoEmpty = new Array();
```

### Array with Initial Values

```javascript
let numbers = [1, 2, 3, 4, 5];
let names = ["Alice", "Bob", "Charlie"];
let booleans = [true, false, true];
```

---

## Accessing Array Elements

### Index-Based Access

Arrays are zero-indexed (first element is at index 0):

```javascript
let fruits = ["apple", "banana", "orange"];

console.log(fruits[0]);  // "apple" (first element)
console.log(fruits[1]);  // "banana" (second element)
console.log(fruits[2]);  // "orange" (third element)
```

### Getting Array Length

```javascript
let fruits = ["apple", "banana", "orange"];
console.log(fruits.length);  // 3
```

### Accessing Last Element

```javascript
let fruits = ["apple", "banana", "orange"];
let last = fruits[fruits.length - 1];
console.log(last);  // "orange"
```

### Out of Bounds Access

```javascript
let fruits = ["apple", "banana"];

console.log(fruits[2]);     // undefined (doesn't exist)
console.log(fruits[-1]);    // undefined (negative index doesn't work)
console.log(fruits[100]);   // undefined
```

### Modifying Elements

```javascript
let fruits = ["apple", "banana", "orange"];
fruits[1] = "grape";
console.log(fruits);  // ["apple", "grape", "orange"]
```

---

## Array Methods: Adding and Removing

### push() - Add to End

Adds one or more elements to the end of an array:

```javascript
let fruits = ["apple", "banana"];
fruits.push("orange");
console.log(fruits);  // ["apple", "banana", "orange"]

fruits.push("grape", "mango");
console.log(fruits);  // ["apple", "banana", "orange", "grape", "mango"]
```

**Returns**: New length of array

### pop() - Remove from End

Removes and returns the last element:

```javascript
let fruits = ["apple", "banana", "orange"];
let last = fruits.pop();
console.log(last);    // "orange"
console.log(fruits);  // ["apple", "banana"]
```

**Returns**: Removed element (or undefined if array is empty)

### unshift() - Add to Beginning

Adds one or more elements to the beginning:

```javascript
let fruits = ["banana", "orange"];
fruits.unshift("apple");
console.log(fruits);  // ["apple", "banana", "orange"]

fruits.unshift("grape", "mango");
console.log(fruits);  // ["grape", "mango", "apple", "banana", "orange"]
```

**Returns**: New length of array

### shift() - Remove from Beginning

Removes and returns the first element:

```javascript
let fruits = ["apple", "banana", "orange"];
let first = fruits.shift();
console.log(first);   // "apple"
console.log(fruits);  // ["banana", "orange"]
```

**Returns**: Removed element (or undefined if array is empty)

### Comparison

| Method | Adds/Removes | Location | Returns |
|--------|--------------|----------|---------|
| `push()` | Adds | End | Length |
| `pop()` | Removes | End | Element |
| `unshift()` | Adds | Beginning | Length |
| `shift()` | Removes | Beginning | Element |

---

## splice() - Add/Remove Anywhere

`splice()` can add or remove elements at any position.

### Basic Syntax

```javascript
array.splice(start, deleteCount, item1, item2, ...)
```

### Removing Elements

```javascript
let fruits = ["apple", "banana", "orange", "grape"];

// Remove 2 elements starting at index 1
fruits.splice(1, 2);
console.log(fruits);  // ["apple", "grape"]
```

### Adding Elements

```javascript
let fruits = ["apple", "orange"];

// Add at index 1 (don't delete any)
fruits.splice(1, 0, "banana");
console.log(fruits);  // ["apple", "banana", "orange"]
```

### Replacing Elements

```javascript
let fruits = ["apple", "banana", "orange"];

// Replace 1 element at index 1
fruits.splice(1, 1, "grape");
console.log(fruits);  // ["apple", "grape", "orange"]
```

### Returns Removed Elements

```javascript
let fruits = ["apple", "banana", "orange"];
let removed = fruits.splice(1, 2);
console.log(removed);  // ["banana", "orange"]
console.log(fruits);   // ["apple"]
```

---

## slice() - Copy Array Portion

`slice()` creates a copy of a portion of an array (doesn't modify original).

### Basic Syntax

```javascript
array.slice(start, end)
```

### Copy Entire Array

```javascript
let fruits = ["apple", "banana", "orange"];
let copy = fruits.slice();
console.log(copy);  // ["apple", "banana", "orange"]
```

### Copy Portion

```javascript
let fruits = ["apple", "banana", "orange", "grape"];

let portion = fruits.slice(1, 3);
console.log(portion);  // ["banana", "orange"]
console.log(fruits);   // ["apple", "banana", "orange", "grape"] (unchanged)
```

### Negative Indices

```javascript
let fruits = ["apple", "banana", "orange", "grape"];

let lastTwo = fruits.slice(-2);
console.log(lastTwo);  // ["orange", "grape"]
```

### slice() vs splice()

- **slice()**: Doesn't modify original, returns new array
- **splice()**: Modifies original, returns removed elements

---

## Array Iteration Methods

### forEach()

Executes a function for each array element:

```javascript
let fruits = ["apple", "banana", "orange"];

fruits.forEach(function(fruit) {
    console.log(fruit);
});
// apple
// banana
// orange
```

**Arrow function:**
```javascript
fruits.forEach(fruit => console.log(fruit));
```

**With index:**
```javascript
fruits.forEach((fruit, index) => {
    console.log(`${index}: ${fruit}`);
});
```

### map()

Creates a new array by transforming each element:

```javascript
let numbers = [1, 2, 3, 4, 5];
let doubled = numbers.map(num => num * 2);
console.log(doubled);  // [2, 4, 6, 8, 10]
```

**Doesn't modify original:**
```javascript
let numbers = [1, 2, 3];
let squared = numbers.map(n => n * n);
console.log(numbers);  // [1, 2, 3] (unchanged)
console.log(squared);  // [1, 4, 9]
```

**Transform objects:**
```javascript
let users = [
    { name: "Alice", age: 25 },
    { name: "Bob", age: 30 }
];

let names = users.map(user => user.name);
console.log(names);  // ["Alice", "Bob"]
```

### filter()

Creates a new array with elements that pass a test:

```javascript
let numbers = [1, 2, 3, 4, 5, 6];
let evens = numbers.filter(num => num % 2 === 0);
console.log(evens);  // [2, 4, 6]
```

**Filter objects:**
```javascript
let users = [
    { name: "Alice", age: 25 },
    { name: "Bob", age: 17 },
    { name: "Charlie", age: 30 }
];

let adults = users.filter(user => user.age >= 18);
console.log(adults);  // [{ name: "Alice", age: 25 }, { name: "Charlie", age: 30 }]
```

### reduce()

Reduces array to a single value:

```javascript
let numbers = [1, 2, 3, 4, 5];
let sum = numbers.reduce((accumulator, current) => {
    return accumulator + current;
}, 0);
console.log(sum);  // 15
```

**Shorter syntax:**
```javascript
let sum = numbers.reduce((acc, curr) => acc + curr, 0);
```

**Find maximum:**
```javascript
let numbers = [5, 2, 8, 1, 9];
let max = numbers.reduce((acc, curr) => {
    return curr > acc ? curr : acc;
}, numbers[0]);
console.log(max);  // 9
```

**Count occurrences:**
```javascript
let fruits = ["apple", "banana", "apple", "orange", "banana"];
let count = fruits.reduce((acc, fruit) => {
    acc[fruit] = (acc[fruit] || 0) + 1;
    return acc;
}, {});
console.log(count);  // { apple: 2, banana: 2, orange: 1 }
```

---

## Array Searching Methods

### indexOf()

Returns the first index where element is found:

```javascript
let fruits = ["apple", "banana", "orange", "banana"];
console.log(fruits.indexOf("banana"));  // 1
console.log(fruits.indexOf("grape"));    // -1 (not found)
```

**With start index:**
```javascript
let fruits = ["apple", "banana", "orange", "banana"];
console.log(fruits.indexOf("banana", 2));  // 3 (starts searching from index 2)
```

### lastIndexOf()

Returns the last index where element is found:

```javascript
let fruits = ["apple", "banana", "orange", "banana"];
console.log(fruits.lastIndexOf("banana"));  // 3
```

### includes()

Checks if array contains an element:

```javascript
let fruits = ["apple", "banana", "orange"];
console.log(fruits.includes("banana"));  // true
console.log(fruits.includes("grape"));   // false
```

### find()

Returns the first element that passes a test:

```javascript
let numbers = [1, 5, 3, 8, 2];
let found = numbers.find(num => num > 5);
console.log(found);  // 8
```

**With objects:**
```javascript
let users = [
    { name: "Alice", age: 25 },
    { name: "Bob", age: 30 },
    { name: "Charlie", age: 20 }
];

let user = users.find(u => u.age > 25);
console.log(user);  // { name: "Bob", age: 30 }
```

### findIndex()

Returns the index of the first element that passes a test:

```javascript
let numbers = [1, 5, 3, 8, 2];
let index = numbers.findIndex(num => num > 5);
console.log(index);  // 3
```

---

## Practice Exercise

### Exercise: Array Operations

**Objective**: Practice using various array methods and operations.

**Instructions**:

1. Create a file called `arrays-practice.js`

2. Create arrays and practice:
   - Creating arrays
   - Accessing and modifying elements
   - Using push, pop, shift, unshift
   - Using splice and slice
   - Iterating with forEach, map, filter, reduce
   - Searching with indexOf, find, includes

3. Build practical examples:
   - Shopping cart
   - Student grades
   - User list operations

**Example Solution**:

```javascript
// Arrays Practice
console.log("=== Creating Arrays ===");
let fruits = ["apple", "banana", "orange"];
let numbers = [1, 2, 3, 4, 5];
let empty = [];

console.log("Fruits:", fruits);
console.log("Numbers:", numbers);
console.log("Empty:", empty);
console.log();

console.log("=== Accessing Elements ===");
console.log("First fruit:", fruits[0]);           // "apple"
console.log("Last fruit:", fruits[fruits.length - 1]);  // "orange"
console.log("Array length:", fruits.length);      // 3
console.log();

console.log("=== push() and pop() ===");
let stack = [];
stack.push(1);
stack.push(2);
stack.push(3);
console.log("After push:", stack);  // [1, 2, 3]

let last = stack.pop();
console.log("Popped:", last);        // 3
console.log("After pop:", stack);    // [1, 2]
console.log();

console.log("=== unshift() and shift() ===");
let queue = [];
queue.unshift(1);
queue.unshift(2);
queue.unshift(3);
console.log("After unshift:", queue);  // [3, 2, 1]

let first = queue.shift();
console.log("Shifted:", first);        // 3
console.log("After shift:", queue);    // [2, 1]
console.log();

console.log("=== splice() ===");
let items = ["a", "b", "c", "d", "e"];

// Remove elements
let removed = items.splice(1, 2);
console.log("Removed:", removed);      // ["b", "c"]
console.log("After remove:", items);   // ["a", "d", "e"]

// Add elements
items.splice(1, 0, "x", "y");
console.log("After add:", items);      // ["a", "x", "y", "d", "e"]

// Replace
items.splice(2, 1, "z");
console.log("After replace:", items);  // ["a", "x", "z", "d", "e"]
console.log();

console.log("=== slice() ===");
let original = [1, 2, 3, 4, 5];
let copy = original.slice();
let portion = original.slice(1, 4);
let lastTwo = original.slice(-2);

console.log("Original:", original);    // [1, 2, 3, 4, 5]
console.log("Copy:", copy);            // [1, 2, 3, 4, 5]
console.log("Portion:", portion);      // [2, 3, 4]
console.log("Last two:", lastTwo);     // [4, 5]
console.log();

console.log("=== forEach() ===");
let numbers2 = [1, 2, 3, 4, 5];
numbers2.forEach((num, index) => {
    console.log(`Index ${index}: ${num}`);
});
console.log();

console.log("=== map() ===");
let numbers3 = [1, 2, 3, 4, 5];
let doubled = numbers3.map(n => n * 2);
let squared = numbers3.map(n => n * n);

console.log("Original:", numbers3);   // [1, 2, 3, 4, 5]
console.log("Doubled:", doubled);      // [2, 4, 6, 8, 10]
console.log("Squared:", squared);     // [1, 4, 9, 16, 25]
console.log();

console.log("=== filter() ===");
let numbers4 = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
let evens = numbers4.filter(n => n % 2 === 0);
let greaterThan5 = numbers4.filter(n => n > 5);

console.log("Evens:", evens);              // [2, 4, 6, 8, 10]
console.log("Greater than 5:", greaterThan5); // [6, 7, 8, 9, 10]
console.log();

console.log("=== reduce() ===");
let numbers5 = [1, 2, 3, 4, 5];
let sum = numbers5.reduce((acc, curr) => acc + curr, 0);
let product = numbers5.reduce((acc, curr) => acc * curr, 1);
let max = numbers5.reduce((acc, curr) => curr > acc ? curr : acc, numbers5[0]);

console.log("Sum:", sum);        // 15
console.log("Product:", product); // 120
console.log("Max:", max);        // 5
console.log();

console.log("=== Searching ===");
let fruits2 = ["apple", "banana", "orange", "banana"];

console.log("indexOf banana:", fruits2.indexOf("banana"));        // 1
console.log("lastIndexOf banana:", fruits2.lastIndexOf("banana")); // 3
console.log("includes apple:", fruits2.includes("apple"));        // true
console.log("includes grape:", fruits2.includes("grape"));       // false

let numbers6 = [1, 5, 3, 8, 2];
let found = numbers6.find(n => n > 5);
let foundIndex = numbers6.findIndex(n => n > 5);

console.log("Find > 5:", found);        // 8
console.log("FindIndex > 5:", foundIndex); // 3
console.log();

console.log("=== Practical Example: Shopping Cart ===");
let cart = [];

// Add items
cart.push({ name: "Apple", price: 1.50, quantity: 3 });
cart.push({ name: "Banana", price: 0.75, quantity: 5 });
cart.push({ name: "Orange", price: 2.00, quantity: 2 });

console.log("Cart items:", cart.length);

// Calculate total
let total = cart.reduce((sum, item) => {
    return sum + (item.price * item.quantity);
}, 0);
console.log("Cart total: $" + total.toFixed(2));

// Remove item
let bananaIndex = cart.findIndex(item => item.name === "Banana");
if (bananaIndex !== -1) {
    cart.splice(bananaIndex, 1);
}
console.log("After removing banana:", cart.length);

// Update quantity
let apple = cart.find(item => item.name === "Apple");
if (apple) {
    apple.quantity = 5;
}
console.log("Updated cart:", cart);
console.log();

console.log("=== Practical Example: Student Grades ===");
let students = [
    { name: "Alice", grade: 85 },
    { name: "Bob", grade: 92 },
    { name: "Charlie", grade: 78 },
    { name: "Diana", grade: 95 }
];

// Get all names
let names = students.map(s => s.name);
console.log("Student names:", names);

// Get passing grades (>= 80)
let passing = students.filter(s => s.grade >= 80);
console.log("Passing students:", passing.length);

// Calculate average
let average = students.reduce((sum, s) => sum + s.grade, 0) / students.length;
console.log("Average grade:", average.toFixed(2));

// Find highest grade
let topStudent = students.reduce((top, curr) => {
    return curr.grade > top.grade ? curr : top;
}, students[0]);
console.log("Top student:", topStudent.name, "-", topStudent.grade);
```

**Expected Output**:
```
=== Creating Arrays ===
Fruits: [ "apple", "banana", "orange" ]
Numbers: [ 1, 2, 3, 4, 5 ]
Empty: []

=== Accessing Elements ===
First fruit: apple
Last fruit: orange
Array length: 3

=== push() and pop() ===
After push: [ 1, 2, 3 ]
Popped: 3
After pop: [ 1, 2 ]

=== unshift() and shift() ===
After unshift: [ 3, 2, 1 ]
Shifted: 3
After shift: [ 2, 1 ]

=== splice() ===
Removed: [ "b", "c" ]
After remove: [ "a", "d", "e" ]
After add: [ "a", "x", "y", "d", "e" ]
After replace: [ "a", "x", "z", "d", "e" ]

=== slice() ===
Original: [ 1, 2, 3, 4, 5 ]
Copy: [ 1, 2, 3, 4, 5 ]
Portion: [ 2, 3, 4 ]
Last two: [ 4, 5 ]

=== forEach() ===
Index 0: 1
Index 1: 2
Index 2: 3
Index 3: 4
Index 4: 5

=== map() ===
Original: [ 1, 2, 3, 4, 5 ]
Doubled: [ 2, 4, 6, 8, 10 ]
Squared: [ 1, 4, 9, 16, 25 ]

=== filter() ===
Evens: [ 2, 4, 6, 8, 10 ]
Greater than 5: [ 6, 7, 8, 9, 10 ]

=== reduce() ===
Sum: 15
Product: 120
Max: 5

=== Searching ===
indexOf banana: 1
lastIndexOf banana: 3
includes apple: true
includes grape: false
Find > 5: 8
FindIndex > 5: 3

=== Practical Example: Shopping Cart ===
Cart items: 3
Cart total: $13.00
After removing banana: 2
Updated cart: [ { name: "Apple", price: 1.5, quantity: 5 }, { name: "Orange", price: 2, quantity: 2 } ]

=== Practical Example: Student Grades ===
Student names: [ "Alice", "Bob", "Charlie", "Diana" ]
Passing students: 4
Average grade: 87.50
Top student: Diana - 95
```

**Challenge (Optional)**:
- Build a todo list application
- Create a data processing pipeline
- Build a search and filter system
- Create array manipulation utilities

---

## Common Mistakes

### 1. Confusing splice() and slice()

```javascript
let arr = [1, 2, 3, 4, 5];

// splice() modifies original
let removed = arr.splice(1, 2);
console.log(arr);  // [1, 4, 5] (modified!)

// slice() doesn't modify
let arr2 = [1, 2, 3, 4, 5];
let portion = arr2.slice(1, 3);
console.log(arr2);  // [1, 2, 3, 4, 5] (unchanged)
```

### 2. Modifying During Iteration

```javascript
// ⚠️ Can cause issues
let arr = [1, 2, 3, 4, 5];
arr.forEach((item, index) => {
    if (item === 3) {
        arr.splice(index, 1);  // Modifying while iterating
    }
});

// ✅ Better: Create new array
let filtered = arr.filter(item => item !== 3);
```

### 3. Forgetting map() Returns New Array

```javascript
// ⚠️ map() doesn't modify original
let numbers = [1, 2, 3];
numbers.map(n => n * 2);
console.log(numbers);  // [1, 2, 3] (unchanged!)

// ✅ Assign result
let doubled = numbers.map(n => n * 2);
console.log(doubled);  // [2, 4, 6]
```

### 4. Wrong reduce() Initial Value

```javascript
// ⚠️ For sum, start with 0
let sum = [1, 2, 3].reduce((acc, curr) => acc + curr);  // Works but...

// ✅ Explicit initial value
let sum = [1, 2, 3].reduce((acc, curr) => acc + curr, 0);
```

### 5. indexOf() with Objects

```javascript
// ⚠️ Doesn't work with objects
let arr = [{ id: 1 }, { id: 2 }];
console.log(arr.indexOf({ id: 1 }));  // -1 (different objects)

// ✅ Use findIndex()
let index = arr.findIndex(item => item.id === 1);  // 0
```

---

## Key Takeaways

1. **Creating Arrays**: Use `[]` literal (preferred)
2. **Accessing**: Zero-indexed, use `[index]`
3. **Modifying Methods**: `push()`, `pop()`, `shift()`, `unshift()`, `splice()`
4. **Copying Methods**: `slice()` (doesn't modify original)
5. **Iteration**: `forEach()`, `map()`, `filter()`, `reduce()`
6. **Searching**: `indexOf()`, `find()`, `includes()`
7. **Immutability**: `map()`, `filter()`, `slice()` don't modify original
8. **Mutability**: `push()`, `pop()`, `splice()` modify original

---

## Quiz: Arrays

Test your understanding with these questions:

1. **What is the index of the first element in an array?**
   - A) 1
   - B) 0
   - C) -1
   - D) undefined

2. **What does `push()` return?**
   - A) The added element
   - B) The new length
   - C) The array
   - D) undefined

3. **Which method doesn't modify the original array?**
   - A) push()
   - B) splice()
   - C) slice()
   - D) pop()

4. **What does `map()` do?**
   - A) Filters elements
   - B) Transforms each element
   - C) Reduces to single value
   - D) Modifies original array

5. **What does `indexOf()` return if element not found?**
   - A) undefined
   - B) -1
   - C) 0
   - D) null

6. **Which finds first element matching condition?**
   - A) filter()
   - B) find()
   - C) indexOf()
   - D) includes()

7. **What does `reduce()` do?**
   - A) Filters array
   - B) Maps array
   - C) Reduces to single value
   - D) Iterates array

**Answers**:
1. B) 0
2. B) The new length
3. C) slice()
4. B) Transforms each element
5. B) -1
6. B) find()
7. C) Reduces to single value

---

## Next Steps

Congratulations! You've learned about arrays. You now know:
- How to create and access arrays
- Array modification methods
- Array iteration methods
- Array searching methods

**What's Next?**
- Lesson 5.3: Advanced Array Operations
- Practice combining array methods
- Build data processing pipelines
- Work with complex array operations

---

## Additional Resources

- **MDN: Array**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array)
- **MDN: Array Methods**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array#instance_methods](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array#instance_methods)
- **JavaScript.info: Arrays**: [javascript.info/array](https://javascript.info/array)
- **JavaScript.info: Array Methods**: [javascript.info/array-methods](https://javascript.info/array-methods)

---

*Lesson completed! You're ready to move on to the next lesson.*

