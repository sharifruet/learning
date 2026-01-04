# Lesson 7.2: Destructuring

## Learning Objectives

By the end of this lesson, you will be able to:
- Destructure arrays to extract values
- Destructure objects to extract properties
- Use default values in destructuring
- Perform nested destructuring
- Use rest in destructuring
- Apply destructuring in function parameters
- Write cleaner, more readable code

---

## Introduction to Destructuring

Destructuring is a convenient way to extract values from arrays and objects into variables. It's one of the most useful ES6 features.

### Benefits of Destructuring

- **Cleaner Code**: Less verbose than traditional assignment
- **Readability**: Clear intent
- **Convenience**: Extract multiple values at once
- **Default Values**: Handle missing values easily
- **Swapping**: Easy variable swapping

---

## Array Destructuring

### Basic Array Destructuring

```javascript
let numbers = [1, 2, 3];
let [a, b, c] = numbers;

console.log(a);  // 1
console.log(b);  // 2
console.log(c);  // 3
```

### Skipping Elements

Use empty slots to skip elements:

```javascript
let numbers = [1, 2, 3, 4, 5];
let [first, , third, , fifth] = numbers;

console.log(first);   // 1
console.log(third);   // 3
console.log(fifth);   // 5
```

### Default Values

Provide default values for missing elements:

```javascript
let numbers = [1, 2];
let [a, b, c = 10] = numbers;

console.log(a);  // 1
console.log(b);  // 2
console.log(c);  // 10 (default)
```

### Rest in Array Destructuring

Collect remaining elements:

```javascript
let numbers = [1, 2, 3, 4, 5];
let [first, second, ...rest] = numbers;

console.log(first);   // 1
console.log(second);  // 2
console.log(rest);    // [3, 4, 5]
```

### Swapping Variables

Easy variable swapping:

```javascript
let a = 5;
let b = 10;

[a, b] = [b, a];

console.log(a);  // 10
console.log(b);  // 5
```

### Function Return Values

Destructure function return values:

```javascript
function getNumbers() {
    return [1, 2, 3];
}

let [x, y, z] = getNumbers();
console.log(x, y, z);  // 1, 2, 3
```

### Nested Array Destructuring

```javascript
let numbers = [1, [2, 3], 4];
let [a, [b, c], d] = numbers;

console.log(a);  // 1
console.log(b);  // 2
console.log(c);  // 3
console.log(d);  // 4
```

### Ignoring Values

```javascript
let numbers = [1, 2, 3, 4, 5];
let [first, , , fourth] = numbers;

console.log(first);   // 1
console.log(fourth);  // 4
```

---

## Object Destructuring

### Basic Object Destructuring

```javascript
let person = {
    name: "Alice",
    age: 25,
    city: "New York"
};

let { name, age, city } = person;

console.log(name);  // "Alice"
console.log(age);   // 25
console.log(city);  // "New York"
```

### Different Variable Names

Assign to different variable names:

```javascript
let person = {
    name: "Alice",
    age: 25
};

let { name: userName, age: userAge } = person;

console.log(userName);  // "Alice"
console.log(userAge);   // 25
// console.log(name);   // ❌ Error: name is not defined
```

### Default Values

```javascript
let person = {
    name: "Alice"
};

let { name, age = 0, city = "Unknown" } = person;

console.log(name);  // "Alice"
console.log(age);   // 0 (default)
console.log(city);  // "Unknown" (default)
```

### Combining Renaming and Defaults

```javascript
let person = {
    name: "Alice"
};

let { name: userName, age: userAge = 0 } = person;

console.log(userName);  // "Alice"
console.log(userAge);   // 0
```

### Nested Object Destructuring

```javascript
let user = {
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

let {
    name,
    address: {
        street,
        city,
        country: { name: countryName }
    }
} = user;

console.log(name);        // "Alice"
console.log(street);      // "123 Main St"
console.log(city);        // "New York"
console.log(countryName); // "USA"
```

### Rest in Object Destructuring

```javascript
let person = {
    name: "Alice",
    age: 25,
    city: "New York",
    country: "USA"
};

let { name, ...rest } = person;

console.log(name);  // "Alice"
console.log(rest);  // { age: 25, city: "New York", country: "USA" }
```

### Destructuring Existing Variables

```javascript
let name, age;

({ name, age } = { name: "Alice", age: 25 });

console.log(name);  // "Alice"
console.log(age);   // 25
```

**Note**: Parentheses required when destructuring into existing variables.

---

## Destructuring in Function Parameters

### Array Parameters

```javascript
function processCoordinates([x, y]) {
    console.log(`X: ${x}, Y: ${y}`);
}

processCoordinates([10, 20]);  // "X: 10, Y: 20"
```

### Object Parameters

```javascript
function greet({ name, age }) {
    console.log(`Hello, ${name}! You are ${age} years old.`);
}

greet({ name: "Alice", age: 25 });  // "Hello, Alice! You are 25 years old."
```

### Default Parameters with Destructuring

```javascript
function createUser({ name, age = 0, city = "Unknown" }) {
    return {
        name: name,
        age: age,
        city: city
    };
}

let user1 = createUser({ name: "Alice", age: 25 });
let user2 = createUser({ name: "Bob" });  // Uses defaults
```

### Nested Destructuring in Parameters

```javascript
function processUser({
    name,
    address: { city, country }
}) {
    console.log(`${name} lives in ${city}, ${country}`);
}

processUser({
    name: "Alice",
    address: {
        city: "New York",
        country: "USA"
    }
});
```

---

## Practical Examples

### Example 1: API Response

```javascript
// Simulated API response
let apiResponse = {
    status: "success",
    data: {
        user: {
            id: 1,
            name: "Alice",
            email: "alice@example.com"
        }
    }
};

let {
    status,
    data: {
        user: { id, name, email }
    }
} = apiResponse;

console.log(`User ${name} (${email}) - Status: ${status}`);
```

### Example 2: Configuration

```javascript
let config = {
    host: "localhost",
    port: 3000,
    database: {
        name: "mydb",
        user: "admin"
    }
};

let {
    host,
    port,
    database: { name: dbName, user: dbUser }
} = config;

console.log(`Connecting to ${host}:${port} with database ${dbName}`);
```

### Example 3: Array Methods

```javascript
let points = [
    [10, 20],
    [30, 40],
    [50, 60]
];

points.forEach(([x, y]) => {
    console.log(`Point: (${x}, ${y})`);
});
```

### Example 4: Function Returns

```javascript
function getMinMax(numbers) {
    return [Math.min(...numbers), Math.max(...numbers)];
}

let [min, max] = getMinMax([5, 2, 8, 1, 9]);
console.log(`Min: ${min}, Max: ${max}`);  // "Min: 1, Max: 9"
```

---

## Practice Exercise

### Exercise: Destructuring Practice

**Objective**: Practice array and object destructuring in various scenarios.

**Instructions**:

1. Create a file called `destructuring-practice.js`

2. Practice:
   - Array destructuring (basic, skipping, defaults, rest)
   - Object destructuring (basic, renaming, defaults, nested)
   - Function parameters with destructuring
   - Real-world examples (API responses, configs)

**Example Solution**:

```javascript
// Destructuring Practice
console.log("=== Array Destructuring ===");

// Basic
let numbers = [1, 2, 3, 4, 5];
let [a, b, c] = numbers;
console.log("Basic:", a, b, c);  // 1, 2, 3

// Skipping
let [first, , third, , fifth] = numbers;
console.log("Skipped:", first, third, fifth);  // 1, 3, 5

// Default values
let numbers2 = [1, 2];
let [x, y, z = 10] = numbers2;
console.log("With default:", x, y, z);  // 1, 2, 10

// Rest
let [first2, second, ...rest] = numbers;
console.log("First:", first2);    // 1
console.log("Second:", second);   // 2
console.log("Rest:", rest);       // [3, 4, 5]

// Swapping
let p = 5;
let q = 10;
[p, q] = [q, p];
console.log("Swapped:", p, q);  // 10, 5

// Nested
let nested = [1, [2, 3], 4];
let [a2, [b2, c2], d] = nested;
console.log("Nested:", a2, b2, c2, d);  // 1, 2, 3, 4
console.log();

console.log("=== Object Destructuring ===");

// Basic
let person = {
    name: "Alice",
    age: 25,
    city: "New York"
};

let { name, age, city } = person;
console.log("Basic:", name, age, city);  // Alice, 25, New York

// Renaming
let { name: userName, age: userAge } = person;
console.log("Renamed:", userName, userAge);  // Alice, 25

// Default values
let person2 = { name: "Bob" };
let { name: name2, age: age2 = 0, city: city2 = "Unknown" } = person2;
console.log("With defaults:", name2, age2, city2);  // Bob, 0, Unknown

// Rest
let { name: name3, ...rest2 } = person;
console.log("Name:", name3);  // Alice
console.log("Rest:", rest2);  // { age: 25, city: "New York" }

// Nested
let user = {
    name: "Alice",
    address: {
        street: "123 Main St",
        city: "New York",
        zip: "10001"
    }
};

let {
    name: userName2,
    address: { street, city: userCity, zip }
} = user;

console.log("Nested:", userName2, street, userCity, zip);
// Alice, 123 Main St, New York, 10001
console.log();

console.log("=== Function Parameters ===");

// Array parameter
function processArray([first, second, third]) {
    console.log(`Processing: ${first}, ${second}, ${third}`);
}
processArray([10, 20, 30]);  // "Processing: 10, 20, 30"

// Object parameter
function greetUser({ name, age = 0 }) {
    console.log(`Hello, ${name}! Age: ${age}`);
}
greetUser({ name: "Alice", age: 25 });  // "Hello, Alice! Age: 25"
greetUser({ name: "Bob" });             // "Hello, Bob! Age: 0"

// Nested parameter
function processConfig({
    server: { host, port },
    database: { name: dbName }
}) {
    console.log(`Server: ${host}:${port}, DB: ${dbName}`);
}

processConfig({
    server: { host: "localhost", port: 3000 },
    database: { name: "mydb" }
});
// "Server: localhost:3000, DB: mydb"
console.log();

console.log("=== Real-World Examples ===");

// API Response
let apiResponse = {
    status: "success",
    data: {
        users: [
            { id: 1, name: "Alice" },
            { id: 2, name: "Bob" }
        ],
        total: 2
    }
};

let {
    status,
    data: {
        users,
        total
    }
} = apiResponse;

console.log("API Status:", status);
console.log("Total users:", total);
users.forEach(({ id, name }) => {
    console.log(`User ${id}: ${name}`);
console.log();

// Function returns
function getStats(numbers) {
    return {
        min: Math.min(...numbers),
        max: Math.max(...numbers),
        sum: numbers.reduce((a, b) => a + b, 0),
        count: numbers.length
    };
}

let { min, max, sum, count } = getStats([5, 10, 15, 20, 25]);
console.log(`Stats: min=${min}, max=${max}, sum=${sum}, count=${count}`);
// "Stats: min=5, max=25, sum=75, count=5"
console.log();

// Configuration
let appConfig = {
    app: {
        name: "MyApp",
        version: "1.0.0"
    },
    api: {
        baseUrl: "https://api.example.com",
        timeout: 5000
    },
    features: {
        darkMode: true,
        notifications: false
    }
};

let {
    app: { name: appName, version },
    api: { baseUrl, timeout },
    features: { darkMode, notifications }
} = appConfig;

console.log(`App: ${appName} v${version}`);
console.log(`API: ${baseUrl} (timeout: ${timeout}ms)`);
console.log(`Features: darkMode=${darkMode}, notifications=${notifications}`);
console.log();

// Array methods with destructuring
let coordinates = [
    [10, 20],
    [30, 40],
    [50, 60]
];

console.log("Coordinates:");
coordinates.forEach(([x, y], index) => {
    console.log(`Point ${index + 1}: (${x}, ${y})`);
});

// Map with destructuring
let users2 = [
    { firstName: "Alice", lastName: "Smith" },
    { firstName: "Bob", lastName: "Jones" }
];

let fullNames = users2.map(({ firstName, lastName }) => {
    return `${firstName} ${lastName}`;
});
console.log("Full names:", fullNames);  // ["Alice Smith", "Bob Jones"]
```

**Expected Output**:
```
=== Array Destructuring ===
Basic: 1, 2, 3
Skipped: 1, 3, 5
With default: 1, 2, 10
First: 1
Second: 2
Rest: [3, 4, 5]
Swapped: 10, 5
Nested: 1, 2, 3, 4

=== Object Destructuring ===
Basic: Alice, 25, New York
Renamed: Alice, 25
With defaults: Bob, 0, Unknown
Name: Alice
Rest: { age: 25, city: "New York" }
Nested: Alice, 123 Main St, New York, 10001

=== Function Parameters ===
Processing: 10, 20, 30
Hello, Alice! Age: 25
Hello, Bob! Age: 0
Server: localhost:3000, DB: mydb

=== Real-World Examples ===
API Status: success
Total users: 2
User 1: Alice
User 2: Bob

Stats: min=5, max=25, sum=75, count=5

App: MyApp v1.0.0
API: https://api.example.com (timeout: 5000ms)
Features: darkMode=true, notifications=false

Coordinates:
Point 1: (10, 20)
Point 2: (30, 40)
Point 3: (50, 60)
Full names: ["Alice Smith", "Bob Jones"]
```

**Challenge (Optional)**:
- Refactor code to use destructuring
- Create utility functions with destructuring
- Build data processing pipelines
- Practice complex nested destructuring

---

## Common Mistakes

### 1. Destructuring Undefined/Null

```javascript
// ⚠️ Error if value is undefined/null
let { name } = undefined;  // Error

// ✅ Check first or use default
let { name = "Unknown" } = user || {};
```

### 2. Rest Must Be Last

```javascript
// ❌ Error: Rest element must be last
// let [first, ...middle, last] = [1, 2, 3, 4];

// ✅ Correct
let [first, ...rest] = [1, 2, 3, 4];
let last = rest[rest.length - 1];
```

### 3. Missing Parentheses

```javascript
let name, age;

// ❌ Error: Unexpected token
// { name, age } = { name: "Alice", age: 25 };

// ✅ Correct: Need parentheses
({ name, age } = { name: "Alice", age: 25 });
```

### 4. Wrong Syntax

```javascript
// ❌ Wrong
let { name: } = person;  // Missing variable name

// ✅ Correct
let { name: userName } = person;
```

### 5. Confusing Array/Object Syntax

```javascript
// Array: []
let [a, b] = [1, 2];

// Object: {}
let { a, b } = { a: 1, b: 2 };
```

---

## Key Takeaways

1. **Array Destructuring**: Extract values from arrays `[a, b] = array`
2. **Object Destructuring**: Extract properties from objects `{a, b} = object`
3. **Default Values**: Provide fallbacks for missing values
4. **Renaming**: Assign to different variable names
5. **Rest**: Collect remaining values
6. **Nested**: Destructure nested structures
7. **Function Parameters**: Use destructuring in parameters
8. **Best Practice**: Use destructuring for cleaner, more readable code

---

## Quiz: Destructuring

Test your understanding with these questions:

1. **What is the result: `let [a, b] = [1, 2, 3]; console.log(a, b)`?**
   - A) 1, 2
   - B) 1, 2, 3
   - C) Error
   - D) undefined, undefined

2. **Rest in destructuring must be:**
   - A) First
   - B) Last
   - C) Middle
   - D) Anywhere

3. **What does `let {name: userName} = person` do?**
   - A) Creates userName from person.name
   - B) Creates name from person.userName
   - C) Error
   - D) Nothing

4. **Default values in destructuring use:**
   - A) =
   - B) :
   - C) =>
   - D) ==

5. **What is the result: `let [a, , c] = [1, 2, 3]; console.log(c)`?**
   - A) 1
   - B) 2
   - C) 3
   - D) undefined

6. **Can you destructure function parameters?**
   - A) No
   - B) Yes
   - C) Only arrays
   - D) Only objects

7. **What does `let {a, ...rest} = {a: 1, b: 2, c: 3}` make rest?**
   - A) [2, 3]
   - B) {b: 2, c: 3}
   - C) Error
   - D) undefined

**Answers**:
1. A) 1, 2
2. B) Last
3. A) Creates userName from person.name
4. A) =
5. C) 3
6. B) Yes
7. B) {b: 2, c: 3}

---

## Next Steps

Congratulations! You've learned destructuring. You now know:
- How to destructure arrays and objects
- Using default values and renaming
- Nested destructuring
- Destructuring in function parameters

**What's Next?**
- Lesson 7.3: Template Literals and Symbols
- Practice using destructuring in real code
- Refactor existing code with destructuring
- Combine destructuring with other ES6 features

---

## Additional Resources

- **MDN: Destructuring Assignment**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Destructuring_assignment](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Destructuring_assignment)
- **JavaScript.info: Destructuring**: [javascript.info/destructuring-assignment](https://javascript.info/destructuring-assignment)
- **ES6 Destructuring Guide**: Comprehensive examples and patterns

---

*Lesson completed! You're ready to move on to the next lesson.*

