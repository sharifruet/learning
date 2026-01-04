# Lesson 18.2: Array Methods for Functional Programming

## Learning Objectives

By the end of this lesson, you will be able to:
- Use map() to transform arrays
- Use filter() to select elements
- Use reduce() to accumulate values
- Use find() and findIndex() to search
- Use some() and every() to test conditions
- Chain array methods
- Build functional data pipelines
- Write more declarative code

---

## Introduction to Functional Array Methods

JavaScript provides powerful array methods that support functional programming. These methods are pure, immutable, and chainable.

### Why Functional Array Methods?

- **Declarative**: Say what you want, not how
- **Immutable**: Don't modify original arrays
- **Chainable**: Can combine multiple operations
- **Readable**: Code is easier to understand
- **Testable**: Easier to test pure functions
- **Modern JavaScript**: Standard approach

---

## map()

### What is map()?

`map()` creates a new array by transforming each element.

### Basic Syntax

```javascript
let newArray = array.map(function(element, index, array) {
    // Return transformed element
    return transformedElement;
});
```

### Basic Examples

```javascript
// Double each number
let numbers = [1, 2, 3, 4, 5];
let doubled = numbers.map(x => x * 2);
console.log(doubled);  // [2, 4, 6, 8, 10]

// Convert to strings
let numbers = [1, 2, 3];
let strings = numbers.map(x => x.toString());
console.log(strings);  // ['1', '2', '3']

// Extract property
let users = [
    { name: 'Alice', age: 30 },
    { name: 'Bob', age: 25 }
];
let names = users.map(user => user.name);
console.log(names);  // ['Alice', 'Bob']
```

### More map() Examples

```javascript
// Transform objects
let users = [
    { name: 'Alice', age: 30 },
    { name: 'Bob', age: 25 }
];

let formatted = users.map(user => ({
    name: user.name.toUpperCase(),
    age: user.age,
    isAdult: user.age >= 18
}));
console.log(formatted);
// [{ name: 'ALICE', age: 30, isAdult: true }, ...]

// With index
let numbers = [10, 20, 30];
let indexed = numbers.map((x, i) => x + i);
console.log(indexed);  // [10, 21, 32]
```

---

## filter()

### What is filter()?

`filter()` creates a new array with elements that pass a test.

### Basic Syntax

```javascript
let newArray = array.filter(function(element, index, array) {
    // Return true to keep, false to remove
    return condition;
});
```

### Basic Examples

```javascript
// Filter even numbers
let numbers = [1, 2, 3, 4, 5, 6];
let evens = numbers.filter(x => x % 2 === 0);
console.log(evens);  // [2, 4, 6]

// Filter by property
let users = [
    { name: 'Alice', age: 30 },
    { name: 'Bob', age: 15 },
    { name: 'Charlie', age: 25 }
];
let adults = users.filter(user => user.age >= 18);
console.log(adults);  // [{ name: 'Alice', age: 30 }, { name: 'Charlie', age: 25 }]

// Filter by condition
let words = ['apple', 'banana', 'cherry', 'date'];
let longWords = words.filter(word => word.length > 5);
console.log(longWords);  // ['banana', 'cherry']
```

### More filter() Examples

```javascript
// Filter truthy values
let values = [0, 1, '', 'hello', null, undefined, 42];
let truthy = values.filter(Boolean);
console.log(truthy);  // [1, 'hello', 42]

// Filter unique values
let numbers = [1, 2, 2, 3, 3, 3, 4];
let unique = numbers.filter((value, index, self) => {
    return self.indexOf(value) === index;
});
console.log(unique);  // [1, 2, 3, 4]
```

---

## reduce()

### What is reduce()?

`reduce()` reduces an array to a single value by applying a function.

### Basic Syntax

```javascript
let result = array.reduce(function(accumulator, currentValue, index, array) {
    // Return new accumulator
    return newAccumulator;
}, initialValue);
```

### Basic Examples

```javascript
// Sum numbers
let numbers = [1, 2, 3, 4, 5];
let sum = numbers.reduce((acc, x) => acc + x, 0);
console.log(sum);  // 15

// Product
let numbers = [2, 3, 4];
let product = numbers.reduce((acc, x) => acc * x, 1);
console.log(product);  // 24

// Count occurrences
let words = ['apple', 'banana', 'apple', 'cherry', 'banana'];
let counts = words.reduce((acc, word) => {
    acc[word] = (acc[word] || 0) + 1;
    return acc;
}, {});
console.log(counts);  // { apple: 2, banana: 2, cherry: 1 }
```

### More reduce() Examples

```javascript
// Flatten array
let nested = [[1, 2], [3, 4], [5, 6]];
let flat = nested.reduce((acc, arr) => acc.concat(arr), []);
console.log(flat);  // [1, 2, 3, 4, 5, 6]

// Group by property
let users = [
    { name: 'Alice', age: 30, city: 'NYC' },
    { name: 'Bob', age: 25, city: 'LA' },
    { name: 'Charlie', age: 30, city: 'NYC' }
];
let grouped = users.reduce((acc, user) => {
    if (!acc[user.city]) {
        acc[user.city] = [];
    }
    acc[user.city].push(user);
    return acc;
}, {});
console.log(grouped);
// { NYC: [...], LA: [...] }

// Find max
let numbers = [5, 2, 8, 1, 9];
let max = numbers.reduce((acc, x) => x > acc ? x : acc, numbers[0]);
console.log(max);  // 9
```

---

## find() and findIndex()

### find()

`find()` returns the first element that passes a test.

```javascript
// Find first even number
let numbers = [1, 3, 4, 5, 6];
let firstEven = numbers.find(x => x % 2 === 0);
console.log(firstEven);  // 4

// Find user by name
let users = [
    { name: 'Alice', age: 30 },
    { name: 'Bob', age: 25 },
    { name: 'Charlie', age: 35 }
];
let user = users.find(u => u.name === 'Bob');
console.log(user);  // { name: 'Bob', age: 25 }

// Returns undefined if not found
let notFound = users.find(u => u.name === 'David');
console.log(notFound);  // undefined
```

### findIndex()

`findIndex()` returns the index of the first element that passes a test.

```javascript
// Find index of first even number
let numbers = [1, 3, 4, 5, 6];
let index = numbers.findIndex(x => x % 2 === 0);
console.log(index);  // 2

// Find index of user
let users = [
    { name: 'Alice', age: 30 },
    { name: 'Bob', age: 25 }
];
let index = users.findIndex(u => u.name === 'Bob');
console.log(index);  // 1

// Returns -1 if not found
let notFound = users.findIndex(u => u.name === 'David');
console.log(notFound);  // -1
```

---

## some() and every()

### some()

`some()` returns true if at least one element passes a test.

```javascript
// Check if any number is even
let numbers = [1, 3, 5, 6, 7];
let hasEven = numbers.some(x => x % 2 === 0);
console.log(hasEven);  // true

// Check if any user is adult
let users = [
    { name: 'Alice', age: 30 },
    { name: 'Bob', age: 15 }
];
let hasAdult = users.some(u => u.age >= 18);
console.log(hasAdult);  // true
```

### every()

`every()` returns true if all elements pass a test.

```javascript
// Check if all numbers are positive
let numbers = [1, 2, 3, 4, 5];
let allPositive = numbers.every(x => x > 0);
console.log(allPositive);  // true

// Check if all users are adults
let users = [
    { name: 'Alice', age: 30 },
    { name: 'Bob', age: 25 }
];
let allAdults = users.every(u => u.age >= 18);
console.log(allAdults);  // true

let mixed = [
    { name: 'Alice', age: 30 },
    { name: 'Bob', age: 15 }
];
let allAdults2 = mixed.every(u => u.age >= 18);
console.log(allAdults2);  // false
```

---

## Chaining Methods

### Method Chaining

You can chain array methods together:

```javascript
let numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

let result = numbers
    .filter(x => x % 2 === 0)  // [2, 4, 6, 8, 10]
    .map(x => x * 2)            // [4, 8, 12, 16, 20]
    .reduce((acc, x) => acc + x, 0);  // 60

console.log(result);  // 60
```

### Complex Chaining Example

```javascript
let users = [
    { name: 'Alice', age: 30, score: 85 },
    { name: 'Bob', age: 25, score: 92 },
    { name: 'Charlie', age: 35, score: 78 },
    { name: 'David', age: 20, score: 95 }
];

let result = users
    .filter(user => user.age >= 25)        // Adults only
    .map(user => ({                        // Transform
        name: user.name.toUpperCase(),
        score: user.score
    }))
    .filter(user => user.score >= 80)      // High scores
    .reduce((acc, user) => {               // Group by score range
        let range = user.score >= 90 ? 'A' : 'B';
        if (!acc[range]) acc[range] = [];
        acc[range].push(user);
        return acc;
    }, {});

console.log(result);
// { B: [{ name: 'ALICE', score: 85 }] }
```

---

## Practical Examples

### Example 1: Data Processing Pipeline

```javascript
let products = [
    { name: 'Laptop', price: 1000, category: 'Electronics' },
    { name: 'Book', price: 20, category: 'Education' },
    { name: 'Phone', price: 800, category: 'Electronics' },
    { name: 'Pen', price: 2, category: 'Education' }
];

// Get expensive electronics
let expensiveElectronics = products
    .filter(p => p.category === 'Electronics')
    .filter(p => p.price > 500)
    .map(p => ({
        name: p.name,
        price: p.price,
        discountedPrice: p.price * 0.9
    }));

console.log(expensiveElectronics);
```

### Example 2: Statistics

```javascript
let scores = [85, 92, 78, 95, 88, 90, 82];

// Calculate statistics
let stats = {
    count: scores.length,
    sum: scores.reduce((a, b) => a + b, 0),
    average: scores.reduce((a, b) => a + b, 0) / scores.length,
    max: scores.reduce((a, b) => Math.max(a, b)),
    min: scores.reduce((a, b) => Math.min(a, b)),
    passed: scores.filter(s => s >= 80).length
};

console.log(stats);
```

### Example 3: Data Transformation

```javascript
let orders = [
    { id: 1, items: [{ name: 'Apple', price: 1 }, { name: 'Banana', price: 0.5 }] },
    { id: 2, items: [{ name: 'Orange', price: 1.5 }] },
    { id: 3, items: [{ name: 'Apple', price: 1 }, { name: 'Orange', price: 1.5 }] }
];

// Get all items with order info
let allItems = orders.flatMap(order =>
    order.items.map(item => ({
        orderId: order.id,
        ...item
    }))
);

// Calculate total per order
let orderTotals = orders.map(order => ({
    id: order.id,
    total: order.items.reduce((sum, item) => sum + item.price, 0)
}));

console.log(allItems);
console.log(orderTotals);
```

---

## Practice Exercise

### Exercise: Functional Array Methods

**Objective**: Practice using map, filter, reduce, find, findIndex, some, and every to process data.

**Instructions**:

1. Create a JavaScript file
2. Practice:
   - Transforming arrays with map
   - Filtering arrays
   - Reducing arrays
   - Finding elements
   - Testing conditions
   - Chaining methods

**Example Solution**:

```javascript
// functional-array-methods-practice.js
console.log("=== Functional Array Methods Practice ===");

let numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
let users = [
    { id: 1, name: 'Alice', age: 30, score: 85, active: true },
    { id: 2, name: 'Bob', age: 25, score: 92, active: true },
    { id: 3, name: 'Charlie', age: 35, score: 78, active: false },
    { id: 4, name: 'David', age: 20, score: 95, active: true },
    { id: 5, name: 'Eve', age: 28, score: 88, active: true }
];

console.log("\n=== map() ===");

// Double each number
let doubled = numbers.map(x => x * 2);
console.log('Doubled:', doubled);  // [2, 4, 6, 8, 10, 12, 14, 16, 18, 20]

// Get user names
let names = users.map(user => user.name);
console.log('Names:', names);  // ['Alice', 'Bob', 'Charlie', 'David', 'Eve']

// Transform users
let formatted = users.map(user => ({
    name: user.name.toUpperCase(),
    age: user.age,
    isAdult: user.age >= 18
}));
console.log('Formatted users:', formatted);

// With index
let indexed = numbers.map((x, i) => x + i);
console.log('Indexed:', indexed);
console.log();

console.log("=== filter() ===");

// Filter even numbers
let evens = numbers.filter(x => x % 2 === 0);
console.log('Even numbers:', evens);  // [2, 4, 6, 8, 10]

// Filter adults
let adults = users.filter(user => user.age >= 18);
console.log('Adults:', adults.length, 'users');

// Filter active users
let activeUsers = users.filter(user => user.active);
console.log('Active users:', activeUsers.length, 'users');

// Filter high scores
let highScores = users.filter(user => user.score >= 85);
console.log('High scores:', highScores.length, 'users');

// Filter truthy values
let values = [0, 1, '', 'hello', null, undefined, 42, false];
let truthy = values.filter(Boolean);
console.log('Truthy values:', truthy);
console.log();

console.log("=== reduce() ===");

// Sum numbers
let sum = numbers.reduce((acc, x) => acc + x, 0);
console.log('Sum:', sum);  // 55

// Product
let product = numbers.slice(0, 5).reduce((acc, x) => acc * x, 1);
console.log('Product of first 5:', product);  // 120

// Count occurrences
let words = ['apple', 'banana', 'apple', 'cherry', 'banana', 'apple'];
let counts = words.reduce((acc, word) => {
    acc[word] = (acc[word] || 0) + 1;
    return acc;
}, {});
console.log('Word counts:', counts);

// Group by age range
let grouped = users.reduce((acc, user) => {
    let range = user.age < 25 ? 'young' : user.age < 30 ? 'adult' : 'senior';
    if (!acc[range]) acc[range] = [];
    acc[range].push(user);
    return acc;
}, {});
console.log('Grouped by age:', grouped);

// Find max score
let maxScore = users.reduce((max, user) => 
    user.score > max ? user.score : max, 0
);
console.log('Max score:', maxScore);

// Flatten array
let nested = [[1, 2], [3, 4], [5, 6]];
let flat = nested.reduce((acc, arr) => acc.concat(arr), []);
console.log('Flattened:', flat);
console.log();

console.log("=== find() and findIndex() ===");

// Find first even number
let firstEven = numbers.find(x => x % 2 === 0);
console.log('First even:', firstEven);  // 2

// Find user by name
let alice = users.find(user => user.name === 'Alice');
console.log('Found Alice:', alice);

// Find user by score
let highScorer = users.find(user => user.score >= 90);
console.log('High scorer:', highScorer);

// Find index
let index = users.findIndex(user => user.name === 'Charlie');
console.log('Charlie index:', index);  // 2

// Not found
let notFound = users.find(user => user.name === 'Frank');
console.log('Not found:', notFound);  // undefined
console.log();

console.log("=== some() and every() ===");

// Check if any number is even
let hasEven = numbers.some(x => x % 2 === 0);
console.log('Has even:', hasEven);  // true

// Check if any user is inactive
let hasInactive = users.some(user => !user.active);
console.log('Has inactive:', hasInactive);  // true

// Check if all numbers are positive
let allPositive = numbers.every(x => x > 0);
console.log('All positive:', allPositive);  // true

// Check if all users are adults
let allAdults = users.every(user => user.age >= 18);
console.log('All adults:', allAdults);  // true

// Check if all users are active
let allActive = users.every(user => user.active);
console.log('All active:', allActive);  // false
console.log();

console.log("=== Method Chaining ===");

// Chain: filter -> map -> reduce
let result = numbers
    .filter(x => x % 2 === 0)      // [2, 4, 6, 8, 10]
    .map(x => x * 2)                // [4, 8, 12, 16, 20]
    .reduce((acc, x) => acc + x, 0); // 60
console.log('Chained result:', result);  // 60

// Complex chain
let complexResult = users
    .filter(user => user.active)           // Active users
    .filter(user => user.age >= 25)        // Age >= 25
    .map(user => ({                        // Transform
        name: user.name.toUpperCase(),
        score: user.score
    }))
    .filter(user => user.score >= 85)      // High scores
    .reduce((acc, user) => {               // Group by score
        let grade = user.score >= 90 ? 'A' : 'B';
        if (!acc[grade]) acc[grade] = [];
        acc[grade].push(user);
        return acc;
    }, {});
console.log('Complex chain result:', complexResult);

// Calculate average score of active adults
let avgScore = users
    .filter(user => user.active)
    .filter(user => user.age >= 25)
    .map(user => user.score)
    .reduce((acc, score, index, array) => {
        acc += score;
        if (index === array.length - 1) {
            return acc / array.length;
        }
        return acc;
    }, 0);
console.log('Average score:', avgScore.toFixed(2));
console.log();

console.log("=== Practical Examples ===");

// Example 1: Data Processing Pipeline
let products = [
    { name: 'Laptop', price: 1000, category: 'Electronics', inStock: true },
    { name: 'Book', price: 20, category: 'Education', inStock: true },
    { name: 'Phone', price: 800, category: 'Electronics', inStock: false },
    { name: 'Pen', price: 2, category: 'Education', inStock: true }
];

let expensiveElectronics = products
    .filter(p => p.category === 'Electronics')
    .filter(p => p.price > 500)
    .filter(p => p.inStock)
    .map(p => ({
        name: p.name,
        price: p.price,
        discountedPrice: p.price * 0.9
    }));
console.log('Expensive electronics:', expensiveElectronics);

// Example 2: Statistics
let scores = users.map(u => u.score);
let stats = {
    count: scores.length,
    sum: scores.reduce((a, b) => a + b, 0),
    average: scores.reduce((a, b) => a + b, 0) / scores.length,
    max: scores.reduce((a, b) => Math.max(a, b)),
    min: scores.reduce((a, b) => Math.min(a, b)),
    passed: scores.filter(s => s >= 80).length
};
console.log('Score statistics:', stats);

// Example 3: Data Transformation
let orders = [
    { id: 1, items: [{ name: 'Apple', price: 1 }, { name: 'Banana', price: 0.5 }] },
    { id: 2, items: [{ name: 'Orange', price: 1.5 }] },
    { id: 3, items: [{ name: 'Apple', price: 1 }, { name: 'Orange', price: 1.5 }] }
];

let allItems = orders.flatMap(order =>
    order.items.map(item => ({
        orderId: order.id,
        ...item
    }))
);
console.log('All items:', allItems);

let orderTotals = orders.map(order => ({
    id: order.id,
    total: order.items.reduce((sum, item) => sum + item.price, 0)
}));
console.log('Order totals:', orderTotals);
```

**Expected Output**:
```
=== Functional Array Methods Practice ===

=== map() ===
Doubled: [2, 4, 6, 8, 10, 12, 14, 16, 18, 20]
Names: ['Alice', 'Bob', 'Charlie', 'David', 'Eve']
Formatted users: [array]
Indexed: [1, 3, 5, 7, 9, 11, 13, 15, 17, 19]

=== filter() ===
Even numbers: [2, 4, 6, 8, 10]
Adults: 5 users
Active users: 4 users
High scores: 4 users
Truthy values: [1, 'hello', 42]

=== reduce() ===
Sum: 55
Product of first 5: 120
Word counts: { apple: 3, banana: 2, cherry: 1 }
Grouped by age: { object }
Max score: 95
Flattened: [1, 2, 3, 4, 5, 6]

=== find() and findIndex() ===
First even: 2
Found Alice: { id: 1, name: 'Alice', ... }
High scorer: { id: 2, name: 'Bob', ... }
Charlie index: 2
Not found: undefined

=== some() and every() ===
Has even: true
Has inactive: true
All positive: true
All adults: true
All active: false

=== Method Chaining ===
Chained result: 60
Complex chain result: { object }
Average score: [value]

=== Practical Examples ===
Expensive electronics: [array]
Score statistics: { object }
All items: [array]
Order totals: [array]
```

**Challenge (Optional)**:
- Build a complete data processing pipeline
- Create reusable transformation functions
- Build a query builder
- Practice complex method chaining

---

## Common Mistakes

### 1. Forgetting Return in map()

```javascript
// ⚠️ Problem: Returns undefined
let doubled = numbers.map(x => {
    x * 2;  // Missing return
});

// ✅ Solution: Return value
let doubled = numbers.map(x => x * 2);
```

### 2. Modifying Original Array

```javascript
// ⚠️ Problem: Modifies original
let filtered = numbers.filter(x => {
    numbers.push(x * 2);  // Modifies original
    return x > 5;
});

// ✅ Solution: Don't modify in callbacks
let filtered = numbers.filter(x => x > 5);
```

### 3. Not Providing Initial Value in reduce()

```javascript
// ⚠️ Problem: Might fail with empty array
let sum = numbers.reduce((acc, x) => acc + x);

// ✅ Solution: Provide initial value
let sum = numbers.reduce((acc, x) => acc + x, 0);
```

---

## Key Takeaways

1. **map()**: Transform each element
2. **filter()**: Select elements that pass test
3. **reduce()**: Accumulate to single value
4. **find()**: Find first matching element
5. **findIndex()**: Find index of first match
6. **some()**: Test if any element passes
7. **every()**: Test if all elements pass
8. **Chaining**: Combine methods for powerful pipelines

---

## Quiz: Functional Array Methods

Test your understanding with these questions:

1. **map() returns:**
   - A) Modified original array
   - B) New array
   - C) Single value
   - D) Nothing

2. **filter() keeps elements where:**
   - A) Condition is false
   - B) Condition is true
   - C) Always
   - D) Never

3. **reduce() needs:**
   - A) Accumulator
   - B) Current value
   - C) Initial value (optional)
   - D) All of the above

4. **find() returns:**
   - A) First match
   - B) All matches
   - C) Index
   - D) Nothing

5. **some() returns:**
   - A) true if any pass
   - B) true if all pass
   - C) false always
   - D) undefined

6. **every() returns:**
   - A) true if any pass
   - B) true if all pass
   - C) false always
   - D) undefined

7. **Methods can be:**
   - A) Chained
   - B) Used separately
   - C) Both
   - D) Neither

**Answers**:
1. B) New array
2. B) Condition is true
3. D) All of the above
4. A) First match
5. A) true if any pass
6. B) true if all pass
7. C) Both

---

## Next Steps

Congratulations! You've learned functional array methods. You now know:
- How to transform arrays with map
- How to filter arrays
- How to reduce arrays
- How to find elements
- How to test conditions
- How to chain methods

**What's Next?**
- Lesson 18.3: Advanced Functional Patterns
- Learn function composition
- Understand currying
- Work with memoization
- Build higher-order functions

---

## Additional Resources

- **MDN: Array Methods**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array)
- **JavaScript.info: Array Methods**: [javascript.info/array-methods](https://javascript.info/array-methods)

---

*Lesson completed! You're ready to move on to the next lesson.*

