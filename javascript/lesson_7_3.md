# Lesson 7.3: Template Literals and Symbols

## Learning Objectives

By the end of this lesson, you will be able to:
- Use template literals for string interpolation
- Create multiline strings easily
- Use tagged templates for advanced string processing
- Understand Symbols and their use cases
- Create unique identifiers with Symbols
- Use Symbol properties
- Write modern, clean string code

---

## Introduction to Template Literals

Template literals (template strings) are a new way to create strings in JavaScript. They use backticks (`` ` ``) instead of quotes and provide powerful features like interpolation and multiline strings.

### Benefits of Template Literals

- **String Interpolation**: Embed expressions easily
- **Multiline Strings**: No need for concatenation
- **Tagged Templates**: Advanced string processing
- **Readability**: Cleaner than string concatenation

---

## Template Literals Basics

### Basic Syntax

Use backticks (`` ` ``) instead of quotes:

```javascript
let name = "Alice";
let greeting = `Hello, ${name}!`;
console.log(greeting);  // "Hello, Alice!"
```

### String Interpolation

Embed expressions using `${expression}`:

```javascript
let name = "Alice";
let age = 25;
let message = `Hello, I'm ${name} and I'm ${age} years old`;
console.log(message);  // "Hello, I'm Alice and I'm 25 years old"
```

### Expressions in Template Literals

Any valid JavaScript expression can be used:

```javascript
let a = 5;
let b = 10;
let result = `The sum of ${a} and ${b} is ${a + b}`;
console.log(result);  // "The sum of 5 and 10 is 15"
```

### Function Calls

```javascript
function getName() {
    return "Alice";
}

let message = `Hello, ${getName()}!`;
console.log(message);  // "Hello, Alice!"
```

### Object Properties

```javascript
let person = {
    name: "Alice",
    age: 25
};

let info = `Name: ${person.name}, Age: ${person.age}`;
console.log(info);  // "Name: Alice, Age: 25"
```

---

## Multiline Strings

### Traditional Way (Concatenation)

```javascript
// Old way: Concatenation
let multiline = "Line 1\n" +
                "Line 2\n" +
                "Line 3";
```

### Template Literal Way

```javascript
// New way: Template literal
let multiline = `Line 1
Line 2
Line 3`;
```

### Preserving Formatting

Template literals preserve whitespace and line breaks:

```javascript
let html = `
<div>
    <h1>Title</h1>
    <p>Content</p>
</div>
`;
```

### Practical Example

```javascript
let email = `
Dear ${recipient},

Thank you for your order.

Order Details:
- Item: ${itemName}
- Price: $${price}
- Quantity: ${quantity}

Total: $${price * quantity}

Best regards,
${senderName}
`;
```

---

## Advanced Template Literal Features

### Nested Template Literals

```javascript
let items = ["apple", "banana", "orange"];
let list = `
Shopping List:
${items.map(item => `- ${item}`).join("\n")}
`;
console.log(list);
```

### Conditional Expressions

```javascript
let user = { name: "Alice", isAdmin: true };
let message = `
Welcome, ${user.name}!
${user.isAdmin ? "You have admin privileges." : "You are a regular user."}
`;
```

### Ternary Operators

```javascript
let score = 85;
let result = `Your score is ${score}. ${score >= 70 ? "Passed!" : "Failed!"}`;
console.log(result);  // "Your score is 85. Passed!"
```

### Template Literals in Functions

```javascript
function createGreeting(name, age) {
    return `Hello, ${name}! You are ${age} years old.`;
}

console.log(createGreeting("Alice", 25));
```

---

## Tagged Templates

Tagged templates allow you to process template literals with a function.

### Basic Tagged Template

```javascript
function myTag(strings, ...values) {
    console.log("Strings:", strings);
    console.log("Values:", values);
    return "Processed";
}

let name = "Alice";
let age = 25;
let result = myTag`Hello, ${name}! You are ${age} years old.`;
// Strings: ["Hello, ", "! You are ", " years old."]
// Values: ["Alice", 25]
```

### How Tagged Templates Work

The tag function receives:
1. **strings**: Array of string literals
2. **values**: Array of interpolated values

```javascript
function tag(strings, ...values) {
    let result = "";
    for (let i = 0; i < strings.length; i++) {
        result += strings[i];
        if (i < values.length) {
            result += values[i];
        }
    }
    return result;
}

let name = "Alice";
let message = tag`Hello, ${name}!`;
console.log(message);  // "Hello, Alice!"
```

### Practical Example: HTML Escaping

```javascript
function htmlEscape(strings, ...values) {
    let result = strings[0];
    for (let i = 0; i < values.length; i++) {
        let escaped = String(values[i])
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#39;");
        result += escaped + strings[i + 1];
    }
    return result;
}

let userInput = "<script>alert('XSS')</script>";
let safe = htmlEscape`<div>${userInput}</div>`;
console.log(safe);  // "<div>&lt;script&gt;alert(&#39;XSS&#39;)&lt;/script&gt;</div>"
```

### Example: String Formatting

```javascript
function format(strings, ...values) {
    return strings.reduce((result, str, i) => {
        let value = values[i];
        if (typeof value === "number") {
            value = value.toFixed(2);
        }
        return result + str + (value || "");
    }, "");
}

let price = 19.99;
let quantity = 3;
let total = format`Price: $${price}, Quantity: ${quantity}, Total: $${price * quantity}`;
console.log(total);  // "Price: $19.99, Quantity: 3, Total: $59.97"
```

### Example: Translation

```javascript
const translations = {
    en: { greeting: "Hello", farewell: "Goodbye" },
    es: { greeting: "Hola", farewell: "Adiós" }
};

function translate(lang) {
    return function(strings, ...values) {
        let result = strings[0];
        for (let i = 0; i < values.length; i++) {
            let key = values[i];
            let translated = translations[lang][key] || key;
            result += translated + strings[i + 1];
        }
        return result;
    };
}

let t = translate("es");
let message = t`${"greeting"}, ${"farewell"}`;
console.log(message);  // "Hola, Adiós"
```

---

## Symbols

Symbols are a primitive data type introduced in ES6. They create unique, immutable identifiers.

### What are Symbols?

- **Unique**: Every symbol is unique
- **Immutable**: Cannot be changed
- **Primitive**: Not objects
- **Use Cases**: Private properties, constants, metadata

### Creating Symbols

```javascript
let sym1 = Symbol();
let sym2 = Symbol();
console.log(sym1 === sym2);  // false (each is unique)
```

### Symbol with Description

```javascript
let sym1 = Symbol("description");
let sym2 = Symbol("description");
console.log(sym1 === sym2);  // false (still unique, description is just a label)
```

### Symbol.for() - Global Registry

`Symbol.for()` creates or retrieves symbols from a global registry:

```javascript
let sym1 = Symbol.for("key");
let sym2 = Symbol.for("key");
console.log(sym1 === sym2);  // true (same symbol from registry)
```

### Symbol.keyFor()

Get the key for a symbol from the global registry:

```javascript
let sym = Symbol.for("myKey");
console.log(Symbol.keyFor(sym));  // "myKey"

let sym2 = Symbol("notInRegistry");
console.log(Symbol.keyFor(sym2));  // undefined
```

---

## Using Symbols

### Symbols as Property Keys

```javascript
let id = Symbol("id");
let person = {
    name: "Alice",
    [id]: 123  // Symbol as property key
};

console.log(person[id]);  // 123
console.log(person.name); // "Alice"
```

### Symbols are Hidden

Symbol properties don't appear in normal iteration:

```javascript
let id = Symbol("id");
let person = {
    name: "Alice",
    [id]: 123
};

// Normal iteration doesn't show symbols
for (let key in person) {
    console.log(key);  // Only "name"
}

console.log(Object.keys(person));  // ["name"]
console.log(Object.getOwnPropertyNames(person));  // ["name"]
```

### Accessing Symbol Properties

```javascript
let id = Symbol("id");
let person = {
    name: "Alice",
    [id]: 123
};

// Get symbol properties
let symbols = Object.getOwnPropertySymbols(person);
console.log(symbols);  // [Symbol(id)]
console.log(person[symbols[0]]);  // 123
```

### Private Properties Pattern

```javascript
let _name = Symbol("name");
let _age = Symbol("age");

class Person {
    constructor(name, age) {
        this[_name] = name;
        this[_age] = age;
    }
    
    getName() {
        return this[_name];
    }
    
    getAge() {
        return this[_age];
    }
}

let person = new Person("Alice", 25);
console.log(person.getName());  // "Alice"
console.log(person[_name]);     // "Alice" (but requires symbol reference)
```

### Well-Known Symbols

JavaScript has built-in well-known symbols:

```javascript
// Symbol.iterator - for iteration
let arr = [1, 2, 3];
let iterator = arr[Symbol.iterator]();
console.log(iterator.next());  // { value: 1, done: false }

// Symbol.toStringTag - for toString
class MyClass {
    get [Symbol.toStringTag]() {
        return "MyClass";
    }
}
let obj = new MyClass();
console.log(obj.toString());  // "[object MyClass]"
```

---

## Practical Examples

### Example 1: Template Literals for HTML

```javascript
function createCard(title, content, author) {
    return `
        <div class="card">
            <h2>${title}</h2>
            <p>${content}</p>
            <footer>By ${author}</footer>
        </div>
    `;
}

let html = createCard("My Title", "My content", "Alice");
console.log(html);
```

### Example 2: SQL Query Builder

```javascript
function buildQuery(table, conditions) {
    let query = `SELECT * FROM ${table}`;
    if (conditions.length > 0) {
        query += ` WHERE ${conditions.join(" AND ")}`;
    }
    return query;
}

let conditions = ["age > 18", "status = 'active'"];
let sql = buildQuery("users", conditions);
console.log(sql);  // "SELECT * FROM users WHERE age > 18 AND status = 'active'"
```

### Example 3: Constants with Symbols

```javascript
const STATUS = {
    PENDING: Symbol("pending"),
    APPROVED: Symbol("approved"),
    REJECTED: Symbol("rejected")
};

function processRequest(status) {
    if (status === STATUS.PENDING) {
        return "Request is pending";
    } else if (status === STATUS.APPROVED) {
        return "Request approved";
    } else if (status === STATUS.REJECTED) {
        return "Request rejected";
    }
}

console.log(processRequest(STATUS.PENDING));  // "Request is pending"
```

### Example 4: Metadata with Symbols

```javascript
const METADATA = Symbol("metadata");

class Document {
    constructor(title, content) {
        this.title = title;
        this.content = content;
        this[METADATA] = {
            createdAt: new Date(),
            version: 1
        };
    }
    
    getMetadata() {
        return this[METADATA];
    }
    
    updateMetadata(updates) {
        Object.assign(this[METADATA], updates);
    }
}

let doc = new Document("My Doc", "Content");
console.log(doc.getMetadata());
doc.updateMetadata({ version: 2 });
console.log(doc.getMetadata());
```

---

## Practice Exercise

### Exercise: Template Literals and Symbols

**Objective**: Practice using template literals and symbols in various scenarios.

**Instructions**:

1. Create a file called `template-literals-symbols.js`

2. Practice:
   - Template literals for string interpolation
   - Multiline strings
   - Tagged templates
   - Creating and using symbols
   - Symbol properties
   - Real-world examples

**Example Solution**:

```javascript
// Template Literals and Symbols Practice
console.log("=== Template Literals Basics ===");

let name = "Alice";
let age = 25;
let city = "New York";

// Basic interpolation
let greeting = `Hello, ${name}!`;
console.log("Greeting:", greeting);  // "Hello, Alice!"

// Multiple variables
let info = `Name: ${name}, Age: ${age}, City: ${city}`;
console.log("Info:", info);

// Expressions
let sum = `The sum of 5 and 10 is ${5 + 10}`;
console.log("Sum:", sum);  // "The sum of 5 and 10 is 15"

// Function calls
function getCurrentYear() {
    return new Date().getFullYear();
}
let yearMessage = `Current year: ${getCurrentYear()}`;
console.log("Year:", yearMessage);
console.log();

console.log("=== Multiline Strings ===");

// Traditional way
let oldWay = "Line 1\n" +
             "Line 2\n" +
             "Line 3";
console.log("Old way:", oldWay);

// Template literal way
let newWay = `Line 1
Line 2
Line 3`;
console.log("New way:", newWay);

// HTML example
let html = `
<div class="container">
    <h1>${name}</h1>
    <p>Age: ${age}</p>
    <p>City: ${city}</p>
</div>
`;
console.log("HTML:", html);
console.log();

console.log("=== Advanced Template Literals ===");

// Nested template literals
let items = ["apple", "banana", "orange"];
let list = `
Shopping List:
${items.map(item => `  - ${item}`).join("\n")}
`;
console.log("List:", list);

// Conditional
let user = { name: "Alice", isAdmin: true };
let accessMessage = `
Welcome, ${user.name}!
${user.isAdmin ? "You have admin access." : "You are a regular user."}
`;
console.log("Access:", accessMessage);

// Ternary
let score = 85;
let result = `Score: ${score}. ${score >= 70 ? "Passed!" : "Failed!"}`;
console.log("Result:", result);
console.log();

console.log("=== Tagged Templates ===");

// Basic tagged template
function myTag(strings, ...values) {
    console.log("Strings:", strings);
    console.log("Values:", values);
    return "Processed";
}

let result2 = myTag`Hello, ${name}! You are ${age} years old.`;

// HTML escaping
function htmlEscape(strings, ...values) {
    let result = strings[0];
    for (let i = 0; i < values.length; i++) {
        let escaped = String(values[i])
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;");
        result += escaped + strings[i + 1];
    }
    return result;
}

let userInput = "<script>alert('XSS')</script>";
let safe = htmlEscape`<div>${userInput}</div>`;
console.log("Safe HTML:", safe);

// Formatting
function format(strings, ...values) {
    return strings.reduce((result, str, i) => {
        let value = values[i];
        if (typeof value === "number") {
            value = value.toFixed(2);
        }
        return result + str + (value || "");
    }, "");
}

let price = 19.99;
let quantity = 3;
let total = format`Price: $${price}, Qty: ${quantity}, Total: $${price * quantity}`;
console.log("Formatted:", total);
console.log();

console.log("=== Symbols Basics ===");

// Creating symbols
let sym1 = Symbol();
let sym2 = Symbol();
console.log("sym1 === sym2:", sym1 === sym2);  // false

// With description
let sym3 = Symbol("id");
let sym4 = Symbol("id");
console.log("sym3 === sym4:", sym3 === sym4);  // false

// Symbol.for (global registry)
let sym5 = Symbol.for("key");
let sym6 = Symbol.for("key");
console.log("sym5 === sym6:", sym5 === sym6);  // true

// Symbol.keyFor
console.log("Key for sym5:", Symbol.keyFor(sym5));  // "key"
console.log();

console.log("=== Symbols as Properties ===");

// Symbol property
let id = Symbol("id");
let person = {
    name: "Alice",
    [id]: 123
};

console.log("person[id]:", person[id]);  // 123
console.log("person.name:", person.name); // "Alice"

// Symbols are hidden
console.log("Object.keys:", Object.keys(person));  // ["name"]
console.log("for...in:");
for (let key in person) {
    console.log("  ", key);  // Only "name"
}

// Get symbol properties
let symbols = Object.getOwnPropertySymbols(person);
console.log("Symbols:", symbols);
console.log("Symbol value:", person[symbols[0]]);
console.log();

console.log("=== Private Properties Pattern ===");

let _name = Symbol("name");
let _age = Symbol("age");

class Person {
    constructor(name, age) {
        this[_name] = name;
        this[_age] = age;
    }
    
    getName() {
        return this[_name];
    }
    
    getAge() {
        return this[_age];
    }
}

let person2 = new Person("Bob", 30);
console.log("Name:", person2.getName());  // "Bob"
console.log("Age:", person2.getAge());     // 30
console.log("Direct access:", person2[_name]);  // "Bob" (but requires symbol)
console.log();

console.log("=== Constants with Symbols ===");

const STATUS = {
    PENDING: Symbol("pending"),
    APPROVED: Symbol("approved"),
    REJECTED: Symbol("rejected")
};

function processRequest(status) {
    if (status === STATUS.PENDING) {
        return "Request is pending";
    } else if (status === STATUS.APPROVED) {
        return "Request approved";
    } else if (status === STATUS.REJECTED) {
        return "Request rejected";
    }
}

console.log("Status:", processRequest(STATUS.PENDING));  // "Request is pending"
console.log();

console.log("=== Real-World Examples ===");

// Email template
function createEmail(to, subject, body) {
    return `
To: ${to}
Subject: ${subject}

${body}

---
This is an automated message.
`;
}

let email = createEmail("user@example.com", "Welcome", "Thank you for joining!");
console.log("Email:", email);

// Configuration with symbols
const CONFIG_KEY = Symbol("config");

class App {
    constructor() {
        this[CONFIG_KEY] = {
            apiUrl: "https://api.example.com",
            timeout: 5000
        };
    }
    
    getConfig() {
        return this[CONFIG_KEY];
    }
}

let app = new App();
console.log("Config:", app.getConfig());
```

**Expected Output**:
```
=== Template Literals Basics ===
Greeting: Hello, Alice!
Info: Name: Alice, Age: 25, City: New York
Sum: The sum of 5 and 10 is 15
Year: Current year: 2024

=== Multiline Strings ===
Old way: Line 1
Line 2
Line 3
New way: Line 1
Line 2
Line 3
HTML: 
<div class="container">
    <h1>Alice</h1>
    <p>Age: 25</p>
    <p>City: New York</p>
</div>

=== Advanced Template Literals ===
List: 
Shopping List:
  - apple
  - banana
  - orange
Access: 
Welcome, Alice!
You have admin access.
Result: Score: 85. Passed!

=== Tagged Templates ===
Strings: [ "Hello, ", "! You are ", " years old." ]
Values: [ "Alice", 25 ]
Safe HTML: <div>&lt;script&gt;alert(&#39;XSS&#39;)&lt;/script&gt;</div>
Formatted: Price: $19.99, Qty: 3, Total: $59.97

=== Symbols Basics ===
sym1 === sym2: false
sym3 === sym4: false
sym5 === sym6: true
Key for sym5: key

=== Symbols as Properties ===
person[id]: 123
person.name: Alice
Object.keys: [ "name" ]
for...in:
   name
Symbols: [ Symbol(id) ]
Symbol value: 123

=== Private Properties Pattern ===
Name: Bob
Age: 30
Direct access: Bob

=== Constants with Symbols ===
Status: Request is pending

=== Real-World Examples ===
Email: 
To: user@example.com
Subject: Welcome

Thank you for joining!

---
This is an automated message.

Config: { apiUrl: "https://api.example.com", timeout: 5000 }
```

**Challenge (Optional)**:
- Build a template engine with tagged templates
- Create a symbol-based event system
- Build HTML generators with template literals
- Create private property systems with symbols

---

## Common Mistakes

### 1. Using Quotes Instead of Backticks

```javascript
// ❌ Wrong: No interpolation
let name = "Alice";
let message = "Hello, ${name}!";  // Literal "${name}"

// ✅ Correct: Use backticks
let message = `Hello, ${name}!`;  // "Hello, Alice!"
```

### 2. Forgetting ${} for Expressions

```javascript
// ❌ Wrong
let message = `Hello, name!`;  // Literal "name"

// ✅ Correct
let message = `Hello, ${name}!`;  // Interpolated
```

### 3. Confusing Symbol Uniqueness

```javascript
// ⚠️ Each Symbol() call creates unique symbol
let sym1 = Symbol("id");
let sym2 = Symbol("id");
console.log(sym1 === sym2);  // false

// ✅ Use Symbol.for() for shared symbols
let sym3 = Symbol.for("id");
let sym4 = Symbol.for("id");
console.log(sym3 === sym4);  // true
```

### 4. Symbols Not in Iteration

```javascript
let id = Symbol("id");
let obj = { name: "Alice", [id]: 123 };

// ⚠️ Symbols don't appear in normal iteration
for (let key in obj) {
    console.log(key);  // Only "name"
}

// ✅ Use Object.getOwnPropertySymbols()
let symbols = Object.getOwnPropertySymbols(obj);
```

---

## Key Takeaways

1. **Template Literals**: Use backticks for strings with interpolation
2. **Interpolation**: `${expression}` embeds values
3. **Multiline**: Template literals preserve line breaks
4. **Tagged Templates**: Functions that process template literals
5. **Symbols**: Unique, immutable identifiers
6. **Symbol Properties**: Hidden from normal iteration
7. **Use Cases**: Private properties, constants, metadata
8. **Best Practice**: Use template literals for all string creation

---

## Quiz: Template Literals and Symbols

Test your understanding with these questions:

1. **What character is used for template literals?**
   - A) "
   - B) '
   - C) `
   - D) {

2. **What syntax embeds expressions?**
   - A) ${}
   - B) {}
   - C) $()
   - D) {{}}

3. **Are symbols unique?**
   - A) Yes, always
   - B) No
   - C) Only with Symbol.for()
   - D) Sometimes

4. **Do symbol properties appear in for...in loops?**
   - A) Yes
   - B) No
   - C) Sometimes
   - D) Only if public

5. **What does Symbol.for() do?**
   - A) Creates unique symbol
   - B) Gets/creates from global registry
   - C) Deletes symbol
   - D) Nothing

6. **Template literals preserve:**
   - A) Only text
   - B) Whitespace and line breaks
   - C) Nothing
   - D) Only expressions

7. **Tagged templates receive:**
   - A) Just strings
   - B) Strings and values
   - C) Just values
   - D) Nothing

**Answers**:
1. C) `
2. A) ${}
3. A) Yes, always (each Symbol() call is unique)
4. B) No
5. B) Gets/creates from global registry
6. B) Whitespace and line breaks
7. B) Strings and values

---

## Next Steps

Congratulations! You've completed Module 7: ES6+ Features. You now know:
- Modern variable declarations (let, const)
- Destructuring arrays and objects
- Template literals and string interpolation
- Symbols and their use cases

**What's Next?**
- Module 8: Advanced Functions
- Practice combining ES6+ features
- Build more modern JavaScript applications
- Continue learning advanced JavaScript

---

## Additional Resources

- **MDN: Template Literals**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Template_literals](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Template_literals)
- **MDN: Symbol**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Symbol](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Symbol)
- **JavaScript.info: Template Literals**: [javascript.info/string](https://javascript.info/string)
- **JavaScript.info: Symbol**: [javascript.info/symbol](https://javascript.info/symbol)

---

*Lesson completed! You've finished Module 7: ES6+ Features. Ready for Module 8: Advanced Functions!*

