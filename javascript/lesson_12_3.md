# Lesson 12.3: Working with JSON

## Learning Objectives

By the end of this lesson, you will be able to:
- Use `JSON.stringify()` to convert objects to JSON
- Use `JSON.parse()` to convert JSON to objects
- Handle JSON data from APIs
- Work with nested JSON structures
- Use JSON with common patterns
- Handle JSON errors
- Manipulate JSON data effectively

---

## Introduction to JSON

JSON (JavaScript Object Notation) is a lightweight data interchange format. It's the standard format for data exchange in web APIs.

### What is JSON?

- **Text Format**: Human-readable text format
- **Language Independent**: Works with any language
- **Lightweight**: Smaller than XML
- **Standard**: Used by most APIs
- **JavaScript Native**: Built into JavaScript

### JSON Syntax

```json
{
  "name": "Alice",
  "age": 25,
  "city": "New York",
  "isActive": true,
  "hobbies": ["reading", "coding"],
  "address": {
    "street": "123 Main St",
    "zipCode": "10001"
  }
}
```

---

## JSON.stringify()

`JSON.stringify()` converts a JavaScript value to a JSON string.

### Basic Usage

```javascript
let person = {
    name: "Alice",
    age: 25,
    city: "New York"
};

let jsonString = JSON.stringify(person);
console.log(jsonString);
// '{"name":"Alice","age":25,"city":"New York"}'
```

### Stringifying Different Types

```javascript
// Object
JSON.stringify({ name: "Alice" });  // '{"name":"Alice"}'

// Array
JSON.stringify([1, 2, 3]);  // '[1,2,3]'

// String
JSON.stringify("Hello");  // '"Hello"'

// Number
JSON.stringify(42);  // '42'

// Boolean
JSON.stringify(true);  // 'true'

// null
JSON.stringify(null);  // 'null'

// undefined (excluded)
JSON.stringify({ x: undefined });  // '{}'
```

### Replacer Function

```javascript
let person = {
    name: "Alice",
    age: 25,
    password: "secret123"
};

// Exclude password
let json = JSON.stringify(person, (key, value) => {
    if (key === "password") {
        return undefined;  // Exclude
    }
    return value;
});

console.log(json);  // '{"name":"Alice","age":25}'
```

### Replacer Array

```javascript
let person = {
    name: "Alice",
    age: 25,
    city: "New York",
    email: "alice@example.com"
};

// Only include specified keys
let json = JSON.stringify(person, ["name", "age"]);
console.log(json);  // '{"name":"Alice","age":25}'
```

### Space Parameter (Pretty Print)

```javascript
let person = {
    name: "Alice",
    age: 25,
    city: "New York"
};

// Pretty print with 2 spaces
let json = JSON.stringify(person, null, 2);
console.log(json);
/*
{
  "name": "Alice",
  "age": 25,
  "city": "New York"
}
*/

// Pretty print with tabs
let json2 = JSON.stringify(person, null, "\t");
```

### Handling Circular References

```javascript
let obj = { name: "Alice" };
obj.self = obj;  // Circular reference

// ⚠️ Error: Converting circular structure
// JSON.stringify(obj);  // Error!

// ✅ Solution: Handle circular references
function stringifyCircular(obj) {
    let seen = new WeakSet();
    return JSON.stringify(obj, (key, value) => {
        if (typeof value === "object" && value !== null) {
            if (seen.has(value)) {
                return "[Circular]";
            }
            seen.add(value);
        }
        return value;
    });
}
```

---

## JSON.parse()

`JSON.parse()` converts a JSON string to a JavaScript object.

### Basic Usage

```javascript
let jsonString = '{"name":"Alice","age":25,"city":"New York"}';
let person = JSON.parse(jsonString);

console.log(person.name);  // "Alice"
console.log(person.age);   // 25
```

### Parsing Arrays

```javascript
let jsonArray = '[1, 2, 3, 4, 5]';
let numbers = JSON.parse(jsonArray);

console.log(numbers);      // [1, 2, 3, 4, 5]
console.log(numbers[0]);   // 1
```

### Reviver Function

```javascript
let jsonString = '{"name":"Alice","age":"25","date":"2024-01-01"}';

let person = JSON.parse(jsonString, (key, value) => {
    // Convert age string to number
    if (key === "age") {
        return parseInt(value);
    }
    // Convert date string to Date object
    if (key === "date") {
        return new Date(value);
    }
    return value;
});

console.log(person.age);   // 25 (number)
console.log(person.date);  // Date object
```

### Error Handling

```javascript
function safeParse(jsonString) {
    try {
        return JSON.parse(jsonString);
    } catch (error) {
        console.error("Invalid JSON:", error.message);
        return null;
    }
}

let valid = safeParse('{"name":"Alice"}');  // { name: "Alice" }
let invalid = safeParse('{name:"Alice"}');  // null (invalid JSON)
```

---

## Working with API Data

### Fetching and Parsing JSON

```javascript
async function fetchUserData(userId) {
    try {
        const response = await fetch(`https://api.example.com/users/${userId}`);
        const jsonString = await response.text();
        const user = JSON.parse(jsonString);
        return user;
    } catch (error) {
        console.error("Error:", error);
        throw error;
    }
}

// Or use response.json() which does parsing automatically
async function fetchUserData(userId) {
    const response = await fetch(`https://api.example.com/users/${userId}`);
    const user = await response.json();  // Automatically parses JSON
    return user;
}
```

### Sending JSON Data

```javascript
async function createUser(userData) {
    try {
        const response = await fetch('https://api.example.com/users', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(userData)  // Convert to JSON string
        });
        
        const newUser = await response.json();
        return newUser;
    } catch (error) {
        console.error("Error:", error);
        throw error;
    }
}

createUser({
    name: "Alice",
    age: 25,
    email: "alice@example.com"
});
```

---

## Common JSON Patterns

### Pattern 1: Deep Clone

```javascript
function deepClone(obj) {
    return JSON.parse(JSON.stringify(obj));
}

let original = {
    name: "Alice",
    address: {
        city: "New York"
    }
};

let cloned = deepClone(original);
cloned.address.city = "Boston";

console.log(original.address.city);  // "New York" (unchanged)
console.log(cloned.address.city);    // "Boston"
```

**Note**: This doesn't work with functions, dates, or circular references.

### Pattern 2: Comparing Objects

```javascript
function objectsEqual(obj1, obj2) {
    return JSON.stringify(obj1) === JSON.stringify(obj2);
}

let obj1 = { name: "Alice", age: 25 };
let obj2 = { name: "Alice", age: 25 };
let obj3 = { age: 25, name: "Alice" };  // Different order

console.log(objectsEqual(obj1, obj2));  // true
console.log(objectsEqual(obj1, obj3));  // false (order matters)
```

### Pattern 3: Filtering Object Properties

```javascript
function filterObject(obj, keys) {
    let filtered = {};
    keys.forEach(key => {
        if (obj.hasOwnProperty(key)) {
            filtered[key] = obj[key];
        }
    });
    return filtered;
}

let person = {
    name: "Alice",
    age: 25,
    email: "alice@example.com",
    password: "secret"
};

let public = filterObject(person, ["name", "age"]);
let json = JSON.stringify(public);
console.log(json);  // '{"name":"Alice","age":25}'
```

### Pattern 4: Transforming Data

```javascript
function transformData(data, transformer) {
    return JSON.parse(
        JSON.stringify(data, transformer)
    );
}

let person = {
    name: "Alice",
    age: 25,
    password: "secret"
};

let transformed = transformData(person, (key, value) => {
    if (key === "password") {
        return undefined;  // Remove
    }
    if (key === "age") {
        return value + 1;  // Transform
    }
    return value;
});

console.log(transformed);  // { name: "Alice", age: 26 }
```

---

## Nested JSON Structures

### Working with Nested Objects

```javascript
let company = {
    name: "Tech Corp",
    employees: [
        {
            id: 1,
            name: "Alice",
            department: {
                name: "Engineering",
                location: "New York"
            }
        },
        {
            id: 2,
            name: "Bob",
            department: {
                name: "Sales",
                location: "Boston"
            }
        }
    ]
};

let json = JSON.stringify(company, null, 2);
console.log(json);

// Access nested data
let parsed = JSON.parse(json);
console.log(parsed.employees[0].department.name);  // "Engineering"
```

### Flattening Nested JSON

```javascript
function flattenObject(obj, prefix = "") {
    let flattened = {};
    
    for (let key in obj) {
        let newKey = prefix ? `${prefix}.${key}` : key;
        
        if (typeof obj[key] === "object" && obj[key] !== null && !Array.isArray(obj[key])) {
            Object.assign(flattened, flattenObject(obj[key], newKey));
        } else {
            flattened[newKey] = obj[key];
        }
    }
    
    return flattened;
}

let nested = {
    user: {
        name: "Alice",
        address: {
            city: "New York"
        }
    }
};

let flat = flattenObject(nested);
console.log(flat);
// { "user.name": "Alice", "user.address.city": "New York" }
```

---

## Practice Exercise

### Exercise: JSON Manipulation

**Objective**: Practice working with JSON data.

**Instructions**:

1. Create a file called `json-practice.js`

2. Practice:
   - JSON.stringify() with different options
   - JSON.parse() with reviver
   - Working with API data
   - Common JSON patterns
   - Nested JSON structures

**Example Solution**:

```javascript
// JSON Practice
console.log("=== JSON.stringify() Basics ===");

let person = {
    name: "Alice",
    age: 25,
    city: "New York",
    isActive: true,
    hobbies: ["reading", "coding"]
};

let json = JSON.stringify(person);
console.log("JSON string:", json);

let pretty = JSON.stringify(person, null, 2);
console.log("Pretty JSON:");
console.log(pretty);
console.log();

console.log("=== JSON.parse() Basics ===");

let jsonString = '{"name":"Alice","age":25,"city":"New York"}';
let parsed = JSON.parse(jsonString);

console.log("Parsed object:", parsed);
console.log("Name:", parsed.name);
console.log("Age:", parsed.age);
console.log();

console.log("=== Replacer Function ===");

let user = {
    name: "Alice",
    age: 25,
    password: "secret123",
    email: "alice@example.com"
};

// Exclude password
let safeJson = JSON.stringify(user, (key, value) => {
    if (key === "password") {
        return undefined;
    }
    return value;
});

console.log("Safe JSON:", safeJson);
console.log();

console.log("=== Replacer Array ===");

let selectedFields = JSON.stringify(user, ["name", "email"]);
console.log("Selected fields:", selectedFields);
console.log();

console.log("=== Reviver Function ===");

let jsonWithTypes = '{"name":"Alice","age":"25","birthDate":"1999-01-01"}';

let parsedWithTypes = JSON.parse(jsonWithTypes, (key, value) => {
    if (key === "age") {
        return parseInt(value);
    }
    if (key === "birthDate") {
        return new Date(value);
    }
    return value;
});

console.log("Age type:", typeof parsedWithTypes.age);  // "number"
console.log("Birth date type:", parsedWithTypes.birthDate instanceof Date);  // true
console.log();

console.log("=== Error Handling ===");

function safeParse(jsonString) {
    try {
        return JSON.parse(jsonString);
    } catch (error) {
        console.error("Parse error:", error.message);
        return null;
    }
}

let valid = safeParse('{"name":"Alice"}');
console.log("Valid JSON:", valid);

let invalid = safeParse('{name:"Alice"}');
console.log("Invalid JSON:", invalid);
console.log();

console.log("=== Deep Clone ===");

let original = {
    name: "Alice",
    address: {
        city: "New York",
        zipCode: "10001"
    }
};

let cloned = JSON.parse(JSON.stringify(original));
cloned.address.city = "Boston";

console.log("Original city:", original.address.city);  // "New York"
console.log("Cloned city:", cloned.address.city);      // "Boston"
console.log();

console.log("=== Comparing Objects ===");

function objectsEqual(obj1, obj2) {
    return JSON.stringify(obj1) === JSON.stringify(obj2);
}

let obj1 = { a: 1, b: 2 };
let obj2 = { a: 1, b: 2 };
let obj3 = { a: 1, b: 3 };

console.log("obj1 === obj2:", objectsEqual(obj1, obj2));  // true
console.log("obj1 === obj3:", objectsEqual(obj1, obj3));  // false
console.log();

console.log("=== Filtering Properties ===");

function filterProperties(obj, keys) {
    let filtered = {};
    keys.forEach(key => {
        if (obj.hasOwnProperty(key)) {
            filtered[key] = obj[key];
        }
    });
    return filtered;
}

let fullUser = {
    name: "Alice",
    age: 25,
    email: "alice@example.com",
    password: "secret",
    phone: "555-1234"
};

let publicUser = filterProperties(fullUser, ["name", "age", "email"]);
console.log("Public user:", JSON.stringify(publicUser, null, 2));
console.log();

console.log("=== Nested JSON ===");

let company = {
    name: "Tech Corp",
    employees: [
        {
            id: 1,
            name: "Alice",
            department: {
                name: "Engineering",
                location: "New York"
            },
            skills: ["JavaScript", "Python"]
        },
        {
            id: 2,
            name: "Bob",
            department: {
                name: "Sales",
                location: "Boston"
            },
            skills: ["Communication", "Negotiation"]
        }
    ]
};

let companyJson = JSON.stringify(company, null, 2);
console.log("Company JSON:");
console.log(companyJson);

let parsedCompany = JSON.parse(companyJson);
console.log("\nFirst employee department:", parsedCompany.employees[0].department.name);
console.log();

console.log("=== Transforming Data ===");

function transformJSON(data, transformer) {
    return JSON.parse(
        JSON.stringify(data, transformer)
    );
}

let data = {
    name: "Alice",
    age: 25,
    password: "secret",
    score: 85
};

let transformed = transformJSON(data, (key, value) => {
    if (key === "password") {
        return undefined;  // Remove
    }
    if (key === "score") {
        return value > 80 ? "A" : "B";  // Transform
    }
    return value;
});

console.log("Transformed:", JSON.stringify(transformed, null, 2));
console.log();

console.log("=== API Data Simulation ===");

// Simulate API response
let apiResponse = {
    status: "success",
    data: {
        users: [
            { id: 1, name: "Alice", email: "alice@example.com" },
            { id: 2, name: "Bob", email: "bob@example.com" }
        ],
        total: 2
    }
};

let responseJson = JSON.stringify(apiResponse);
console.log("API Response JSON:", responseJson);

let parsedResponse = JSON.parse(responseJson);
console.log("Total users:", parsedResponse.data.total);
console.log("First user:", parsedResponse.data.users[0].name);
console.log();

console.log("=== Working with Arrays ===");

let users = [
    { id: 1, name: "Alice" },
    { id: 2, name: "Bob" },
    { id: 3, name: "Charlie" }
];

let usersJson = JSON.stringify(users);
console.log("Users JSON:", usersJson);

let parsedUsers = JSON.parse(usersJson);
console.log("User count:", parsedUsers.length);
console.log("Second user:", parsedUsers[1].name);
```

**Expected Output**:
```
=== JSON.stringify() Basics ===
JSON string: {"name":"Alice","age":25,"city":"New York","isActive":true,"hobbies":["reading","coding"]}
Pretty JSON:
{
  "name": "Alice",
  "age": 25,
  "city": "New York",
  "isActive": true,
  "hobbies": [
    "reading",
    "coding"
  ]
}

=== JSON.parse() Basics ===
Parsed object: { name: "Alice", age: 25, city: "New York" }
Name: Alice
Age: 25

=== Replacer Function ===
Safe JSON: {"name":"Alice","age":25,"email":"alice@example.com"}

=== Replacer Array ===
Selected fields: {"name":"Alice","email":"alice@example.com"}

=== Reviver Function ===
Age type: number
Birth date type: true

=== Error Handling ===
Valid JSON: { name: "Alice" }
Parse error: Expected property name or '}' in JSON at position 1
Invalid JSON: null

=== Deep Clone ===
Original city: New York
Cloned city: Boston

=== Comparing Objects ===
obj1 === obj2: true
obj1 === obj3: false

=== Filtering Properties ===
Public user: {
  "name": "Alice",
  "age": 25,
  "email": "alice@example.com"
}

=== Nested JSON ===
Company JSON:
{
  "name": "Tech Corp",
  "employees": [
    {
      "id": 1,
      "name": "Alice",
      "department": {
        "name": "Engineering",
        "location": "New York"
      },
      "skills": [
        "JavaScript",
        "Python"
      ]
    },
    {
      "id": 2,
      "name": "Bob",
      "department": {
        "name": "Sales",
        "location": "Boston"
      },
      "skills": [
        "Communication",
        "Negotiation"
      ]
    }
  ]
}

First employee department: Engineering

=== Transforming Data ===
Transformed: {
  "name": "Alice",
  "age": 25,
  "score": "A"
}

=== API Data Simulation ===
API Response JSON: {"status":"success","data":{"users":[{"id":1,"name":"Alice","email":"alice@example.com"},{"id":2,"name":"Bob","email":"bob@example.com"}],"total":2}}
Total users: 2
First user: Alice

=== Working with Arrays ===
Users JSON: [{"id":1,"name":"Alice"},{"id":2,"name":"Bob"},{"id":3,"name":"Charlie"}]
User count: 3
Second user: Bob
```

**Challenge (Optional)**:
- Build a JSON validator
- Create JSON transformation utilities
- Build a JSON diff tool
- Create JSON schema validator

---

## Common Mistakes

### 1. Not Handling Parse Errors

```javascript
// ⚠️ Problem: No error handling
let data = JSON.parse(invalidJson);  // Throws error

// ✅ Solution: Use try-catch
try {
    let data = JSON.parse(jsonString);
} catch (error) {
    console.error("Invalid JSON:", error);
}
```

### 2. Forgetting to Stringify

```javascript
// ⚠️ Problem: Sending object directly
fetch(url, {
    method: 'POST',
    body: userObject  // Wrong!
});

// ✅ Solution: Stringify first
fetch(url, {
    method: 'POST',
    body: JSON.stringify(userObject)
});
```

### 3. Circular References

```javascript
// ⚠️ Problem: Circular reference
let obj = { name: "Alice" };
obj.self = obj;
JSON.stringify(obj);  // Error!

// ✅ Solution: Handle circular references
function safeStringify(obj) {
    let seen = new WeakSet();
    return JSON.stringify(obj, (key, value) => {
        if (typeof value === "object" && value !== null) {
            if (seen.has(value)) {
                return "[Circular]";
            }
            seen.add(value);
        }
        return value;
    });
}
```

### 4. Functions Not Stringified

```javascript
// ⚠️ Problem: Functions are lost
let obj = {
    name: "Alice",
    greet: function() {
        return "Hello";
    }
};

JSON.stringify(obj);  // '{"name":"Alice"}' (function lost)

// ✅ Solution: Convert functions to strings or exclude
JSON.stringify(obj, (key, value) => {
    if (typeof value === "function") {
        return value.toString();
    }
    return value;
});
```

---

## Key Takeaways

1. **JSON.stringify()**: Converts JavaScript to JSON string
2. **JSON.parse()**: Converts JSON string to JavaScript
3. **Replacer**: Filter/transform during stringify
4. **Reviver**: Transform during parse
5. **Error Handling**: Always handle parse errors
6. **API Integration**: JSON is standard for APIs
7. **Best Practice**: Use try-catch for parsing
8. **Common Patterns**: Deep clone, compare, filter

---

## Quiz: JSON

Test your understanding with these questions:

1. **JSON.stringify() converts:**
   - A) JSON to object
   - B) Object to JSON string
   - C) String to object
   - D) Nothing

2. **JSON.parse() converts:**
   - A) JSON string to object
   - B) Object to JSON
   - C) String to number
   - D) Nothing

3. **Replacer function is used with:**
   - A) JSON.parse()
   - B) JSON.stringify()
   - C) Both
   - D) Neither

4. **Reviver function is used with:**
   - A) JSON.parse()
   - B) JSON.stringify()
   - C) Both
   - D) Neither

5. **JSON.stringify() excludes:**
   - A) undefined
   - B) functions
   - C) Both A and B
   - D) Nothing

6. **Circular references cause:**
   - A) Error in stringify
   - B) Infinite loop
   - C) Both A and B
   - D) Nothing

7. **Pretty printing uses:**
   - A) Space parameter
   - B) Tab parameter
   - C) Both A and B
   - D) Neither

**Answers**:
1. B) Object to JSON string
2. A) JSON string to object
3. B) JSON.stringify()
4. A) JSON.parse()
5. C) Both A and B
6. A) Error in stringify
7. C) Both A and B (space parameter can be number or string)

---

## Next Steps

Congratulations! You've completed Module 12: Working with APIs. You now know:
- How to use the Fetch API
- How to use Axios
- How to work with JSON data
- Complete API integration

**What's Next?**
- Course 3: DOM Manipulation and Events
- Module 13: DOM Basics
- Learn to manipulate web pages
- Build interactive web applications

---

## Additional Resources

- **MDN: JSON**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/JSON](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/JSON)
- **JSON.org**: [json.org](https://www.json.org/)
- **JSON Guide**: Comprehensive JSON patterns and best practices

---

*Lesson completed! You've finished Module 12: Working with APIs. Ready for Course 3: DOM Manipulation and Events!*

