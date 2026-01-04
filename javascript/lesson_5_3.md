# Lesson 5.3: Advanced Array Operations

## Learning Objectives

By the end of this lesson, you will be able to:
- Use array testing methods (some, every)
- Sort and reverse arrays
- Destructure arrays to extract values
- Use spread operator with arrays effectively
- Work with multidimensional arrays
- Combine advanced array techniques
- Write efficient array manipulation code

---

## Introduction

Advanced array operations enable powerful data manipulation. These techniques make arrays more versatile and your code more expressive.

---

## Array Testing Methods

### some()

Tests if at least one element passes a test. Returns `true` if any element passes, `false` otherwise.

```javascript
let numbers = [1, 2, 3, 4, 5];
let hasEven = numbers.some(num => num % 2 === 0);
console.log(hasEven);  // true (has at least one even number)
```

**Examples:**
```javascript
// Check if any number is greater than 10
let numbers = [1, 5, 8, 12, 3];
let hasLarge = numbers.some(n => n > 10);
console.log(hasLarge);  // true

// Check if any user is admin
let users = [
    { name: "Alice", role: "user" },
    { name: "Bob", role: "admin" },
    { name: "Charlie", role: "user" }
];
let hasAdmin = users.some(u => u.role === "admin");
console.log(hasAdmin);  // true
```

### every()

Tests if all elements pass a test. Returns `true` only if all elements pass.

```javascript
let numbers = [2, 4, 6, 8, 10];
let allEven = numbers.every(num => num % 2 === 0);
console.log(allEven);  // true (all are even)
```

**Examples:**
```javascript
// Check if all numbers are positive
let numbers = [1, 5, 8, 12, 3];
let allPositive = numbers.every(n => n > 0);
console.log(allPositive);  // true

// Check if all users are adults
let users = [
    { name: "Alice", age: 25 },
    { name: "Bob", age: 30 },
    { name: "Charlie", age: 17 }
];
let allAdults = users.every(u => u.age >= 18);
console.log(allAdults);  // false (Charlie is 17)
```

### some() vs every()

```javascript
let numbers = [1, 2, 3, 4, 5];

// some: at least one
console.log(numbers.some(n => n > 3));  // true (4, 5)

// every: all
console.log(numbers.every(n => n > 3)); // false (1, 2, 3 don't pass)
```

---

## Sorting Arrays

### sort()

Sorts array elements. **Modifies the original array.**

### String Sorting (Default)

```javascript
let fruits = ["banana", "apple", "orange"];
fruits.sort();
console.log(fruits);  // ["apple", "banana", "orange"]
```

### Number Sorting

**⚠️ Default sort converts to strings:**
```javascript
let numbers = [10, 2, 5, 1, 20];
numbers.sort();
console.log(numbers);  // [1, 10, 2, 20, 5] (wrong! string sort)
```

**✅ Correct number sorting:**
```javascript
let numbers = [10, 2, 5, 1, 20];

// Ascending
numbers.sort((a, b) => a - b);
console.log(numbers);  // [1, 2, 5, 10, 20]

// Descending
numbers.sort((a, b) => b - a);
console.log(numbers);  // [20, 10, 5, 2, 1]
```

### Sort Comparison Function

The comparison function should return:
- Negative: `a` comes before `b`
- Zero: `a` and `b` are equal
- Positive: `a` comes after `b`

```javascript
// Ascending: a - b
[10, 2, 5].sort((a, b) => a - b);  // [2, 5, 10]

// Descending: b - a
[10, 2, 5].sort((a, b) => b - a);  // [10, 5, 2]
```

### Sorting Objects

```javascript
let users = [
    { name: "Alice", age: 25 },
    { name: "Bob", age: 30 },
    { name: "Charlie", age: 20 }
];

// Sort by age (ascending)
users.sort((a, b) => a.age - b.age);
console.log(users);
// [{ name: "Charlie", age: 20 }, { name: "Alice", age: 25 }, { name: "Bob", age: 30 }]

// Sort by name (alphabetical)
users.sort((a, b) => {
    if (a.name < b.name) return -1;
    if (a.name > b.name) return 1;
    return 0;
});
```

### reverse()

Reverses the order of array elements. **Modifies the original array.**

```javascript
let numbers = [1, 2, 3, 4, 5];
numbers.reverse();
console.log(numbers);  // [5, 4, 3, 2, 1]
```

**Combining sort and reverse:**
```javascript
let numbers = [3, 1, 4, 2, 5];
numbers.sort((a, b) => a - b).reverse();
console.log(numbers);  // [5, 4, 3, 2, 1] (sorted descending)
```

---

## Array Destructuring

Array destructuring allows you to extract values from arrays into variables.

### Basic Destructuring

```javascript
let numbers = [1, 2, 3];
let [a, b, c] = numbers;
console.log(a, b, c);  // 1, 2, 3
```

### Skipping Elements

```javascript
let numbers = [1, 2, 3, 4, 5];
let [first, , third, , fifth] = numbers;
console.log(first, third, fifth);  // 1, 3, 5
```

### Default Values

```javascript
let numbers = [1, 2];
let [a, b, c = 10] = numbers;
console.log(a, b, c);  // 1, 2, 10 (c uses default)
```

### Rest in Destructuring

```javascript
let numbers = [1, 2, 3, 4, 5];
let [first, second, ...rest] = numbers;
console.log(first);   // 1
console.log(second);  // 2
console.log(rest);    // [3, 4, 5]
```

### Swapping Variables

```javascript
let a = 5;
let b = 10;
[a, b] = [b, a];
console.log(a, b);  // 10, 5
```

### Function Return Values

```javascript
function getNumbers() {
    return [1, 2, 3];
}

let [x, y, z] = getNumbers();
console.log(x, y, z);  // 1, 2, 3
```

### Nested Destructuring

```javascript
let numbers = [1, [2, 3], 4];
let [a, [b, c], d] = numbers;
console.log(a, b, c, d);  // 1, 2, 3, 4
```

### Practical Examples

```javascript
// Extract first and last
let names = ["Alice", "Bob", "Charlie", "Diana"];
let [first, ...middle, last] = names;  // ⚠️ Rest must be last
// Better:
let [first] = names;
let last = names[names.length - 1];

// Function parameters
function process([first, second]) {
    console.log(first, second);
}
process([1, 2]);  // 1, 2
```

---

## Spread Operator with Arrays

The spread operator (`...`) expands arrays into individual elements.

### Copying Arrays

```javascript
let original = [1, 2, 3];
let copy = [...original];
copy.push(4);
console.log(original);  // [1, 2, 3] (unchanged)
console.log(copy);     // [1, 2, 3, 4]
```

### Combining Arrays

```javascript
let arr1 = [1, 2, 3];
let arr2 = [4, 5, 6];
let combined = [...arr1, ...arr2];
console.log(combined);  // [1, 2, 3, 4, 5, 6]
```

### Adding Elements

```javascript
let numbers = [2, 3, 4];
let withFirst = [1, ...numbers];
let withLast = [...numbers, 5];
let withBoth = [1, ...numbers, 5];
console.log(withBoth);  // [1, 2, 3, 4, 5]
```

### Function Arguments

```javascript
function add(a, b, c) {
    return a + b + c;
}

let numbers = [1, 2, 3];
console.log(add(...numbers));  // 6
```

### Math Operations

```javascript
let numbers = [5, 10, 15, 20, 25];
console.log(Math.max(...numbers));  // 25
console.log(Math.min(...numbers));  // 5
```

### Converting String to Array

```javascript
let str = "Hello";
let chars = [...str];
console.log(chars);  // ["H", "e", "l", "l", "o"]
```

### Removing Duplicates

```javascript
let numbers = [1, 2, 2, 3, 3, 4];
let unique = [...new Set(numbers)];
console.log(unique);  // [1, 2, 3, 4]
```

---

## Multidimensional Arrays

Arrays can contain other arrays, creating multidimensional structures.

### 2D Arrays (Matrix)

```javascript
let matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
];

console.log(matrix[0][0]);  // 1 (first row, first column)
console.log(matrix[1][2]);  // 6 (second row, third column)
```

### Accessing Elements

```javascript
let matrix = [
    [1, 2, 3],
    [4, 5, 6]
];

// Access row
console.log(matrix[0]);  // [1, 2, 3]

// Access element
console.log(matrix[0][1]);  // 2
```

### Iterating 2D Arrays

```javascript
let matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
];

// Nested loops
for (let i = 0; i < matrix.length; i++) {
    for (let j = 0; j < matrix[i].length; j++) {
        console.log(matrix[i][j]);
    }
}

// for...of
for (let row of matrix) {
    for (let cell of row) {
        console.log(cell);
    }
}

// forEach
matrix.forEach(row => {
    row.forEach(cell => {
        console.log(cell);
    });
});
```

### Creating 2D Arrays

```javascript
// Empty 3x3 matrix
let matrix = [];
for (let i = 0; i < 3; i++) {
    matrix[i] = [];
    for (let j = 0; j < 3; j++) {
        matrix[i][j] = 0;
    }
}
console.log(matrix);
// [[0, 0, 0], [0, 0, 0], [0, 0, 0]]
```

### 3D Arrays

```javascript
let cube = [
    [
        [1, 2],
        [3, 4]
    ],
    [
        [5, 6],
        [7, 8]
    ]
];

console.log(cube[0][0][0]);  // 1
console.log(cube[1][1][1]);  // 8
```

### Practical Example: Tic-Tac-Toe

```javascript
let board = [
    ["X", "O", "X"],
    ["O", "X", "O"],
    ["X", "O", "X"]
];

function printBoard(board) {
    board.forEach(row => {
        console.log(row.join(" | "));
    });
}

printBoard(board);
// X | O | X
// O | X | O
// X | O | X
```

---

## Combining Advanced Techniques

### Destructuring + Spread

```javascript
let numbers = [1, 2, 3, 4, 5];
let [first, ...rest] = numbers;
let doubled = rest.map(n => n * 2);
let result = [first, ...doubled];
console.log(result);  // [1, 4, 6, 8, 10]
```

### Sort + Destructure

```javascript
let users = [
    { name: "Alice", age: 25 },
    { name: "Bob", age: 30 },
    { name: "Charlie", age: 20 }
];

users.sort((a, b) => b.age - a.age);  // Sort by age descending
let [oldest, ...others] = users;
console.log(oldest.name);  // "Bob"
```

### Filter + Map + Spread

```javascript
let numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
let evens = numbers.filter(n => n % 2 === 0);
let doubled = evens.map(n => n * 2);
let result = [0, ...doubled, 20];
console.log(result);  // [0, 4, 8, 12, 16, 20]
```

---

## Practice Exercise

### Exercise: Advanced Array Manipulation

**Objective**: Practice advanced array operations including some, every, sort, destructuring, spread, and multidimensional arrays.

**Instructions**:

1. Create a file called `advanced-arrays.js`

2. Practice:
   - Using some() and every()
   - Sorting arrays (numbers, objects, strings)
   - Array destructuring
   - Spread operator with arrays
   - Working with 2D arrays

3. Build practical examples:
   - Data validation
   - Matrix operations
   - Data transformation

**Example Solution**:

```javascript
// Advanced Arrays Practice
console.log("=== some() and every() ===");

let numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

let hasEven = numbers.some(n => n % 2 === 0);
let allPositive = numbers.every(n => n > 0);
let allEven = numbers.every(n => n % 2 === 0);

console.log("Has even:", hasEven);        // true
console.log("All positive:", allPositive); // true
console.log("All even:", allEven);        // false

let users = [
    { name: "Alice", age: 25, active: true },
    { name: "Bob", age: 30, active: true },
    { name: "Charlie", age: 20, active: false }
];

let hasInactive = users.some(u => !u.active);
let allAdults = users.every(u => u.age >= 18);
let allActive = users.every(u => u.active);

console.log("Has inactive:", hasInactive);  // true
console.log("All adults:", allAdults);       // true
console.log("All active:", allActive);       // false
console.log();

console.log("=== Sorting ===");

// Number sorting
let numbers2 = [10, 2, 5, 1, 20, 3];
numbers2.sort((a, b) => a - b);
console.log("Ascending:", numbers2);  // [1, 2, 3, 5, 10, 20]

numbers2.sort((a, b) => b - a);
console.log("Descending:", numbers2); // [20, 10, 5, 3, 2, 1]

// String sorting
let fruits = ["banana", "apple", "orange", "grape"];
fruits.sort();
console.log("Fruits sorted:", fruits);  // ["apple", "banana", "grape", "orange"]

// Object sorting
let students = [
    { name: "Alice", grade: 85 },
    { name: "Bob", grade: 92 },
    { name: "Charlie", grade: 78 },
    { name: "Diana", grade: 95 }
];

students.sort((a, b) => b.grade - a.grade);  // Sort by grade descending
console.log("Students by grade:");
students.forEach(s => {
    console.log(`${s.name}: ${s.grade}`);
});
console.log();

console.log("=== reverse() ===");
let numbers3 = [1, 2, 3, 4, 5];
numbers3.reverse();
console.log("Reversed:", numbers3);  // [5, 4, 3, 2, 1]

// Sort then reverse
let numbers4 = [3, 1, 4, 2, 5];
numbers4.sort((a, b) => a - b).reverse();
console.log("Sorted descending:", numbers4);  // [5, 4, 3, 2, 1]
console.log();

console.log("=== Array Destructuring ===");

// Basic
let numbers5 = [1, 2, 3];
let [a, b, c] = numbers5;
console.log("Destructured:", a, b, c);  // 1, 2, 3

// Skipping
let numbers6 = [1, 2, 3, 4, 5];
let [first, , third, , fifth] = numbers6;
console.log("Skipped:", first, third, fifth);  // 1, 3, 5

// Default values
let numbers7 = [1, 2];
let [x, y, z = 10] = numbers7;
console.log("With default:", x, y, z);  // 1, 2, 10

// Rest
let numbers8 = [1, 2, 3, 4, 5];
let [first2, ...rest] = numbers8;
console.log("First:", first2);    // 1
console.log("Rest:", rest);        // [2, 3, 4, 5]

// Swapping
let p = 5;
let q = 10;
[p, q] = [q, p];
console.log("Swapped:", p, q);  // 10, 5

// Function return
function getCoords() {
    return [10, 20];
}
let [xCoord, yCoord] = getCoords();
console.log("Coords:", xCoord, yCoord);  // 10, 20
console.log();

console.log("=== Spread Operator ===");

// Copying
let original = [1, 2, 3];
let copy = [...original];
copy.push(4);
console.log("Original:", original);  // [1, 2, 3]
console.log("Copy:", copy);          // [1, 2, 3, 4]

// Combining
let arr1 = [1, 2, 3];
let arr2 = [4, 5, 6];
let combined = [...arr1, ...arr2];
console.log("Combined:", combined);  // [1, 2, 3, 4, 5, 6]

// Adding elements
let numbers9 = [2, 3, 4];
let withBoth = [1, ...numbers9, 5];
console.log("With both:", withBoth);  // [1, 2, 3, 4, 5]

// Math operations
let numbers10 = [5, 10, 15, 20, 25];
console.log("Max:", Math.max(...numbers10));  // 25
console.log("Min:", Math.min(...numbers10));  // 5

// Removing duplicates
let duplicates = [1, 2, 2, 3, 3, 4, 4, 5];
let unique = [...new Set(duplicates)];
console.log("Unique:", unique);  // [1, 2, 3, 4, 5]
console.log();

console.log("=== Multidimensional Arrays ===");

// 2D Array
let matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
];

console.log("Matrix:");
matrix.forEach(row => {
    console.log(row);
});

console.log("Element [1][2]:", matrix[1][2]);  // 6

// Sum all elements
let sum = 0;
matrix.forEach(row => {
    row.forEach(cell => {
        sum += cell;
    });
});
console.log("Sum of all:", sum);  // 45

// Transpose matrix
function transpose(matrix) {
    return matrix[0].map((_, colIndex) => {
        return matrix.map(row => row[colIndex]);
    });
}

let transposed = transpose(matrix);
console.log("Transposed:");
transposed.forEach(row => {
    console.log(row);
});
console.log();

console.log("=== Combining Techniques ===");

// Sort + Destructure + Spread
let users2 = [
    { name: "Alice", score: 85 },
    { name: "Bob", score: 92 },
    { name: "Charlie", score: 78 }
];

users2.sort((a, b) => b.score - a.score);
let [top, ...others] = users2;
let topScores = [top, ...others.filter(u => u.score >= 80)];

console.log("Top scorer:", top.name);
console.log("Top scores:", topScores.map(u => u.name));

// Filter + Map + Spread
let numbers11 = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
let processed = [
    0,
    ...numbers11.filter(n => n % 2 === 0).map(n => n * 2),
    100
];
console.log("Processed:", processed);  // [0, 4, 8, 12, 16, 20, 100]

// Destructure + Spread in function
function processData([first, ...rest]) {
    return [first * 2, ...rest.map(n => n + 1)];
}

let result = processData([1, 2, 3, 4]);
console.log("Processed data:", result);  // [2, 3, 4, 5]
```

**Expected Output**:
```
=== some() and every() ===
Has even: true
All positive: true
All even: false
Has inactive: true
All adults: true
All active: false

=== Sorting ===
Ascending: [1, 2, 3, 5, 10, 20]
Descending: [20, 10, 5, 3, 2, 1]
Fruits sorted: ["apple", "banana", "grape", "orange"]
Students by grade:
Diana: 95
Bob: 92
Alice: 85
Charlie: 78

=== reverse() ===
Reversed: [5, 4, 3, 2, 1]
Sorted descending: [5, 4, 3, 2, 1]

=== Array Destructuring ===
Destructured: 1, 2, 3
Skipped: 1, 3, 5
With default: 1, 2, 10
First: 1
Rest: [2, 3, 4, 5]
Swapped: 10, 5
Coords: 10, 20

=== Spread Operator ===
Original: [1, 2, 3]
Copy: [1, 2, 3, 4]
Combined: [1, 2, 3, 4, 5, 6]
With both: [1, 2, 3, 4, 5]
Max: 25
Min: 5
Unique: [1, 2, 3, 4, 5]

=== Multidimensional Arrays ===
Matrix:
[1, 2, 3]
[4, 5, 6]
[7, 8, 9]
Element [1][2]: 6
Sum of all: 45
Transposed:
[1, 4, 7]
[2, 5, 8]
[3, 6, 9]

=== Combining Techniques ===
Top scorer: Bob
Top scores: ["Bob", "Alice"]
Processed: [0, 4, 8, 12, 16, 20, 100]
Processed data: [2, 3, 4, 5]
```

**Challenge (Optional)**:
- Build a matrix calculator
- Create a data processing pipeline
- Build a sorting and filtering system
- Create array utility functions

---

## Common Mistakes

### 1. Forgetting sort() Modifies Original

```javascript
// ⚠️ Original is modified
let numbers = [3, 1, 2];
let sorted = numbers.sort();
console.log(numbers);  // [1, 2, 3] (modified!)

// ✅ Copy first
let numbers2 = [3, 1, 2];
let sorted2 = [...numbers2].sort();
console.log(numbers2);  // [3, 1, 2] (unchanged)
```

### 2. Wrong Number Sort

```javascript
// ❌ Wrong: String sort
let numbers = [10, 2, 5];
numbers.sort();
console.log(numbers);  // [10, 2, 5] (wrong!)

// ✅ Correct: Number sort
numbers.sort((a, b) => a - b);
console.log(numbers);  // [2, 5, 10]
```

### 3. Destructuring Rest Position

```javascript
// ❌ Error: Rest must be last
// let [first, ...middle, last] = [1, 2, 3, 4];

// ✅ Correct
let [first, ...rest] = [1, 2, 3, 4];
let last = rest[rest.length - 1];
```

### 4. Confusing some() and every()

```javascript
let numbers = [1, 2, 3, 4, 5];

// some: at least one
console.log(numbers.some(n => n > 3));  // true

// every: all
console.log(numbers.every(n => n > 3)); // false
```

### 5. Multidimensional Array Access

```javascript
let matrix = [[1, 2], [3, 4]];

// ✅ Correct
console.log(matrix[0][1]);  // 2

// ❌ Wrong
// console.log(matrix[0, 1]);  // Doesn't work
```

---

## Key Takeaways

1. **some()**: Returns true if at least one element passes test
2. **every()**: Returns true only if all elements pass test
3. **sort()**: Sorts array (modifies original), use comparison function for numbers
4. **reverse()**: Reverses array order (modifies original)
5. **Destructuring**: Extract values from arrays into variables
6. **Spread**: Expand arrays into individual elements
7. **Multidimensional**: Arrays containing arrays
8. **Combine**: Use techniques together for powerful operations

---

## Quiz: Advanced Arrays

Test your understanding with these questions:

1. **What does `some()` return if no elements pass?**
   - A) true
   - B) false
   - C) undefined
   - D) []

2. **What does `every()` return if all elements pass?**
   - A) true
   - B) false
   - C) undefined
   - D) []

3. **What does `sort()` do by default?**
   - A) Sorts numbers correctly
   - B) Sorts as strings
   - C) Doesn't sort
   - D) Random order

4. **What does `[...arr]` do?**
   - A) Modifies arr
   - B) Creates copy of arr
   - C) Deletes arr
   - D) Nothing

5. **In destructuring, rest must be:**
   - A) First
   - B) Last
   - C) Middle
   - D) Anywhere

6. **What is `matrix[1][2]` accessing?**
   - A) First row, second column
   - B) Second row, third column
   - C) Third row, second column
   - D) Error

7. **Which modifies the original array?**
   - A) slice()
   - B) map()
   - C) sort()
   - D) filter()

**Answers**:
1. B) false
2. A) true
3. B) Sorts as strings
4. B) Creates copy of arr
5. B) Last
6. B) Second row, third column
7. C) sort()

---

## Next Steps

Congratulations! You've completed Module 5: Objects and Arrays. You now know:
- How to work with objects
- Array basics and methods
- Advanced array operations

**What's Next?**
- Module 6: Object-Oriented Programming
- Lesson 6.1: Object-Oriented Basics
- Practice combining objects and arrays
- Build complex data structures

---

## Additional Resources

- **MDN: Array Methods**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array)
- **MDN: Destructuring**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Destructuring_assignment](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Destructuring_assignment)
- **JavaScript.info: Array Methods**: [javascript.info/array-methods](https://javascript.info/array-methods)
- **JavaScript.info: Destructuring**: [javascript.info/destructuring-assignment](https://javascript.info/destructuring-assignment)

---

*Lesson completed! You've finished Module 5: Objects and Arrays. Ready for Module 6: Object-Oriented Programming!*

