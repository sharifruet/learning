# Lesson 1.3: Variables and Data Types

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the three ways to declare variables (var, let, const)
- Know the differences between var, let, and const
- Identify all JavaScript primitive data types
- Understand type coercion and conversion
- Use the typeof operator to check data types
- Work with different data types in your code

---

## Variable Declarations

Variables are containers that store data values. In JavaScript, you can declare variables using three keywords: `var`, `let`, and `const`.

### var (Legacy - Avoid in Modern Code)

`var` was the original way to declare variables in JavaScript. It has function scope and some quirks.

```javascript
var name = "Alice";
var age = 25;
var isActive = true;
```

**Characteristics of var:**
- Function-scoped (not block-scoped)
- Can be redeclared
- Can be reassigned
- Hoisted (moved to top of scope)
- **Recommendation**: Avoid using `var` in modern JavaScript

**Example:**
```javascript
if (true) {
    var x = 5;
}
console.log(x);  // 5 - accessible outside block (function scope)
```

### let (Modern - Use for Variables That Change)

`let` was introduced in ES6 (2015) and is the modern way to declare variables that will be reassigned.

```javascript
let name = "Alice";
let age = 25;
let isActive = true;
```

**Characteristics of let:**
- Block-scoped
- Cannot be redeclared in the same scope
- Can be reassigned
- Not hoisted (temporal dead zone)
- **Use when**: Value will change

**Example:**
```javascript
let count = 0;
count = 1;      // ✅ Can reassign
count = 2;      // ✅ Can reassign

if (true) {
    let y = 10;
}
// console.log(y);  // ❌ Error - not accessible outside block
```

### const (Modern - Use for Constants)

`const` was also introduced in ES6. It creates constants that cannot be reassigned.

```javascript
const PI = 3.14159;
const MAX_SIZE = 100;
const API_URL = "https://api.example.com";
```

**Characteristics of const:**
- Block-scoped
- Cannot be redeclared
- Cannot be reassigned
- Must be initialized when declared
- Not hoisted (temporal dead zone)
- **Use when**: Value should not change

**Example:**
```javascript
const name = "Alice";
// name = "Bob";  // ❌ Error - cannot reassign

const numbers = [1, 2, 3];
numbers.push(4);  // ✅ Can modify array contents (not reassigning)
// numbers = [5, 6, 7];  // ❌ Error - cannot reassign
```

### When to Use Each

**Use `const` by default:**
```javascript
const userName = "Alice";
const userAge = 25;
const isLoggedIn = true;
```

**Use `let` when you need to reassign:**
```javascript
let counter = 0;
counter++;  // Need to change value

let currentUser = null;
currentUser = getUser();  // Will be assigned later
```

**Avoid `var` (legacy code only):**
```javascript
// Old style (avoid)
var oldStyle = "don't use";

// Modern style
const modernStyle = "use this";
let changeableValue = "or this";
```

### Variable Naming Rules

1. **Must start with**: letter, underscore (_), or dollar sign ($)
2. **Can contain**: letters, digits, underscores, dollar signs
3. **Cannot be**: reserved words (if, for, function, etc.)
4. **Case-sensitive**: `name` and `Name` are different

**Good Names:**
```javascript
let userName = "Alice";
let user_age = 25;
let $element = document.getElementById("id");
let _private = "internal";
```

**Bad Names:**
```javascript
let 2name = "invalid";      // Starts with number
let my-name = "invalid";    // Contains hyphen
let let = "invalid";        // Reserved word
```

### Naming Conventions

**camelCase** (Recommended for variables):
```javascript
let userName = "Alice";
let userAge = 25;
let isActiveUser = true;
```

**UPPER_CASE** (For constants):
```javascript
const MAX_SIZE = 100;
const API_BASE_URL = "https://api.example.com";
const PI = 3.14159;
```

**PascalCase** (For classes/constructors):
```javascript
class UserAccount { }
function UserProfile() { }
```

---

## Primitive Data Types

JavaScript has 7 primitive data types. Primitives are immutable (cannot be changed) and are compared by value.

### 1. String

Strings represent text data, enclosed in quotes.

```javascript
let name = "Alice";           // Double quotes
let city = 'New York';        // Single quotes
let message = `Hello`;        // Template literals (backticks)
```

**String Operations:**
```javascript
let firstName = "Alice";
let lastName = "Smith";

// Concatenation
let fullName = firstName + " " + lastName;  // "Alice Smith"

// Template literals (ES6)
let greeting = `Hello, ${firstName}!`;     // "Hello, Alice!"

// Length
console.log(firstName.length);              // 5

// Access characters
console.log(firstName[0]);                  // "A"
```

**Escape Characters:**
```javascript
let text = "She said \"Hello\"";     // Escape quotes
let newline = "Line 1\nLine 2";      // New line
let tab = "Column1\tColumn2";        // Tab
let backslash = "Path: C:\\Users";   // Backslash
```

### 2. Number

Numbers represent numeric values. JavaScript has one number type (no separate int/float).

```javascript
let integer = 42;
let decimal = 3.14;
let negative = -10;
let scientific = 1.5e6;  // 1,500,000
```

**Number Operations:**
```javascript
let a = 10;
let b = 3;

console.log(a + b);   // 13 (addition)
console.log(a - b);   // 7 (subtraction)
console.log(a * b);   // 30 (multiplication)
console.log(a / b);   // 3.333... (division)
console.log(a % b);   // 1 (modulo/remainder)
console.log(a ** b);  // 1000 (exponentiation)
```

**Special Number Values:**
```javascript
let infinity = Infinity;
let notANumber = NaN;  // Not a Number
let maxValue = Number.MAX_VALUE;
let minValue = Number.MIN_VALUE;
```

**Number Methods:**
```javascript
let num = 3.14159;

console.log(num.toFixed(2));      // "3.14" (string)
console.log(parseInt("42"));      // 42
console.log(parseFloat("3.14"));  // 3.14
console.log(Number("123"));       // 123
```

### 3. Boolean

Booleans represent logical values: `true` or `false`.

```javascript
let isActive = true;
let isLoggedIn = false;
let hasPermission = true;
```

**Boolean Operations:**
```javascript
let a = true;
let b = false;

console.log(a && b);   // false (AND)
console.log(a || b);   // true (OR)
console.log(!a);       // false (NOT)
```

**Truthy and Falsy Values:**
```javascript
// Falsy values (evaluate to false)
false
0
-0
0n (BigInt zero)
"" (empty string)
null
undefined
NaN

// Everything else is truthy
true
1
"hello"
[]
{}
```

### 4. undefined

`undefined` means a variable has been declared but not assigned a value.

```javascript
let x;
console.log(x);  // undefined

let y = undefined;  // Explicitly set to undefined
```

**Common Scenarios:**
```javascript
// Variable declared but not initialized
let name;
console.log(name);  // undefined

// Function with no return
function doNothing() { }
console.log(doNothing());  // undefined

// Accessing non-existent property
let obj = {};
console.log(obj.property);  // undefined
```

### 5. null

`null` represents the intentional absence of a value (different from `undefined`).

```javascript
let user = null;  // Explicitly set to null
```

**null vs undefined:**
```javascript
let a;           // undefined (not assigned)
let b = null;     // null (explicitly set)

console.log(a == null);   // true (loose equality)
console.log(a === null);  // false (strict equality)
console.log(b === null);  // true
```

**When to Use null:**
```javascript
// Indicate "no value" intentionally
let currentUser = null;  // No user logged in

// Reset a variable
let data = getData();
data = null;  // Clear the data
```

### 6. Symbol (ES6)

Symbols are unique, immutable identifiers, often used as object property keys.

```javascript
let id1 = Symbol("id");
let id2 = Symbol("id");

console.log(id1 === id2);  // false (each Symbol is unique)
```

**Common Uses:**
```javascript
// Create unique property keys
let user = {
    name: "Alice",
    [Symbol("id")]: 123  // Hidden property
};

// Well-known symbols
Symbol.iterator
Symbol.toStringTag
```

### 7. BigInt (ES2020)

BigInt represents integers of arbitrary length, useful for very large numbers.

```javascript
let bigNumber = 9007199254740991n;  // Note the 'n' suffix
let anotherBig = BigInt(9007199254740991);
```

**When to Use:**
```javascript
// Regular numbers have limits
console.log(Number.MAX_SAFE_INTEGER);  // 9007199254740991

// BigInt for larger numbers
let huge = 9007199254740992n;
console.log(huge + 1n);  // 9007199254740993n
```

---

## Type Coercion and Conversion

JavaScript automatically converts types in certain situations (coercion) or you can explicitly convert types.

### Type Coercion (Automatic)

JavaScript automatically converts types when needed:

```javascript
// String + Number = String
console.log("5" + 3);        // "53" (concatenation)
console.log("5" + "3");      // "53"

// Number operations convert to number
console.log("5" - 3);        // 2
console.log("5" * "3");     // 15
console.log("10" / "2");    // 5

// Boolean in numeric context
console.log(true + 1);       // 2
console.log(false + 1);      // 1

// Loose equality (==) does coercion
console.log(5 == "5");       // true (coerced)
console.log(5 === "5");      // false (strict, no coercion)
```

### Type Conversion (Explicit)

You can explicitly convert types:

**To String:**
```javascript
let num = 42;
let str1 = String(num);      // "42"
let str2 = num.toString();   // "42"
let str3 = "" + num;         // "42" (coercion)
```

**To Number:**
```javascript
let str = "42";
let num1 = Number(str);      // 42
let num2 = parseInt(str);    // 42
let num3 = parseFloat("3.14"); // 3.14
let num4 = +str;             // 42 (unary plus)
```

**To Boolean:**
```javascript
let value = "hello";
let bool1 = Boolean(value);  // true
let bool2 = !!value;          // true (double negation)
```

**Common Conversions:**
```javascript
// String to Number
Number("42");        // 42
Number("3.14");      // 3.14
Number("abc");       // NaN

parseInt("42px");    // 42 (stops at first non-digit)
parseFloat("3.14.5"); // 3.14

// Number to String
String(42);          // "42"
(42).toString();     // "42"
42 + "";             // "42"

// To Boolean
Boolean(1);          // true
Boolean(0);          // false
Boolean("");         // false
Boolean("hello");    // true
```

---

## typeof Operator

The `typeof` operator returns a string indicating the type of a value.

### Basic Usage

```javascript
typeof "hello";        // "string"
typeof 42;             // "number"
typeof true;            // "boolean"
typeof undefined;       // "undefined"
typeof null;            // "object" (quirk - null is not an object!)
typeof Symbol("id");   // "symbol"
typeof 42n;            // "bigint"
```

### typeof Examples

```javascript
// Primitives
console.log(typeof "hello");      // "string"
console.log(typeof 42);           // "number"
console.log(typeof true);         // "boolean"
console.log(typeof undefined);    // "undefined"
console.log(typeof null);         // "object" (historical quirk)

// Objects
console.log(typeof {});           // "object"
console.log(typeof []);           // "object" (arrays are objects)
console.log(typeof function(){}); // "function"

// Variables
let name = "Alice";
console.log(typeof name);         // "string"

let age = 25;
console.log(typeof age);          // "number"
```

### typeof Quirks

```javascript
// null returns "object" (historical bug, can't be fixed)
console.log(typeof null);         // "object"

// Arrays are objects
console.log(typeof []);           // "object"
console.log(Array.isArray([]));   // true (use this instead)

// Functions are objects but typeof returns "function"
console.log(typeof function(){}); // "function"
```

### Practical Uses

```javascript
// Type checking function
function processValue(value) {
    if (typeof value === "string") {
        return value.toUpperCase();
    } else if (typeof value === "number") {
        return value * 2;
    } else {
        return "Unknown type";
    }
}

console.log(processValue("hello"));  // "HELLO"
console.log(processValue(5));        // 10
```

---

## Working with Different Data Types

### String Operations

```javascript
let firstName = "Alice";
let lastName = "Smith";

// Concatenation
let fullName = firstName + " " + lastName;

// Template literals
let greeting = `Hello, ${firstName}!`;

// Methods
console.log(firstName.length);           // 5
console.log(firstName.toUpperCase());    // "ALICE"
console.log(firstName.toLowerCase());     // "alice"
console.log(firstName.charAt(0));         // "A"
console.log(firstName.includes("lic"));  // true
```

### Number Operations

```javascript
let num1 = 10;
let num2 = 3;

// Arithmetic
console.log(num1 + num2);   // 13
console.log(num1 - num2);   // 7
console.log(num1 * num2);   // 30
console.log(num1 / num2);   // 3.333...
console.log(num1 % num2);   // 1
console.log(num1 ** num2);  // 1000

// Math methods
console.log(Math.max(1, 2, 3));    // 3
console.log(Math.min(1, 2, 3));    // 1
console.log(Math.round(3.7));      // 4
console.log(Math.floor(3.7));      // 3
console.log(Math.ceil(3.2));       // 4
console.log(Math.random());        // Random number 0-1
```

### Boolean Logic

```javascript
let isActive = true;
let isLoggedIn = false;

// Logical operators
console.log(isActive && isLoggedIn);  // false
console.log(isActive || isLoggedIn);  // true
console.log(!isActive);               // false

// Comparison
let age = 25;
console.log(age >= 18);  // true
console.log(age < 30);   // true
console.log(age === 25); // true
```

---

## Practice Exercise

### Exercise: Variable Manipulation

**Objective**: Create a program that demonstrates working with different data types, variables, and type operations.

**Instructions**:

1. Create a file called `variables-practice.js`

2. Declare variables using `let` and `const`:
   - Your name (string)
   - Your age (number)
   - Whether you're a student (boolean)
   - A constant for your birth year
   - An undefined variable
   - A null variable

3. Perform operations:
   - Concatenate your name with a greeting
   - Calculate your age in days (age × 365)
   - Use template literals to create a message
   - Convert a number to a string
   - Convert a string to a number
   - Check types using typeof

4. Display all results using console.log()

**Example Solution**:

```javascript
// Variable Declarations
let userName = "Alice";
let userAge = 25;
let isStudent = true;
const birthYear = 1999;
let futureValue = undefined;
let pastValue = null;

// String Operations
let greeting = "Hello, " + userName;
let message = `My name is ${userName} and I'm ${userAge} years old.`;

// Number Operations
let ageInDays = userAge * 365;
let ageInMonths = userAge * 12;

// Type Conversions
let ageString = String(userAge);        // "25"
let ageNumber = Number(ageString);      // 25
let ageBoolean = Boolean(userAge);      // true

// Type Checking
console.log("=== Variable Types ===");
console.log("userName type:", typeof userName);      // "string"
console.log("userAge type:", typeof userAge);        // "number"
console.log("isStudent type:", typeof isStudent);    // "boolean"
console.log("futureValue type:", typeof futureValue); // "undefined"
console.log("pastValue type:", typeof pastValue);    // "object"

// Display Results
console.log("\n=== Variable Values ===");
console.log("Name:", userName);
console.log("Age:", userAge);
console.log("Is Student:", isStudent);
console.log("Birth Year:", birthYear);
console.log("Age in Days:", ageInDays);
console.log("Age in Months:", ageInMonths);

console.log("\n=== String Operations ===");
console.log(greeting);
console.log(message);

console.log("\n=== Type Conversions ===");
console.log("Age as String:", ageString, typeof ageString);
console.log("Age as Number:", ageNumber, typeof ageNumber);
console.log("Age as Boolean:", ageBoolean, typeof ageBoolean);
```

**Expected Output**:
```
=== Variable Types ===
userName type: string
userAge type: number
isStudent type: boolean
futureValue type: undefined
pastValue type: object

=== Variable Values ===
Name: Alice
Age: 25
Is Student: true
Birth Year: 1999
Age in Days: 9125
Age in Months: 300

=== String Operations ===
Hello, Alice
My name is Alice and I'm 25 years old.

=== Type Conversions ===
Age as String: 25 string
Age as Number: 25 number
Age as Boolean: true boolean
```

**Challenge (Optional)**:
- Create variables of all 7 primitive types
- Perform type coercion experiments
- Use BigInt for large numbers
- Create a Symbol and use it
- Test truthy/falsy values

---

## Common Mistakes

### 1. Using var Instead of let/const

```javascript
// ❌ Old style
var oldStyle = "avoid";

// ✅ Modern style
const modernStyle = "use this";
let changeable = "or this";
```

### 2. Reassigning const

```javascript
// ❌ Error
const PI = 3.14;
PI = 3.14159;  // TypeError

// ✅ Correct
const PI = 3.14159;  // Set correct value initially
```

### 3. Confusing null and undefined

```javascript
// Different meanings
let a;              // undefined (not assigned)
let b = null;       // null (explicitly no value)

// Check correctly
if (a === undefined) { }  // Check for undefined
if (b === null) { }        // Check for null
```

### 4. Type Coercion Surprises

```javascript
// ❌ Unexpected
console.log("5" + 3);      // "53" (not 8!)

// ✅ Explicit
console.log(Number("5") + 3);  // 8
```

### 5. typeof null Quirk

```javascript
// Remember: typeof null is "object"
console.log(typeof null);  // "object" (not "null"!)

// Check for null correctly
let value = null;
if (value === null) { }  // Use strict equality
```

---

## Key Takeaways

1. **Variable Declarations**: Use `const` by default, `let` when reassigning, avoid `var`
2. **Primitive Types**: 7 types - string, number, boolean, undefined, null, symbol, bigint
3. **Type Coercion**: JavaScript automatically converts types in some situations
4. **Type Conversion**: Use explicit methods (String(), Number(), Boolean()) when needed
5. **typeof Operator**: Returns type as string, but has quirks (null returns "object")
6. **Naming**: Use camelCase for variables, UPPER_CASE for constants
7. **Best Practice**: Prefer `const` and `let` over `var` in modern JavaScript

---

## Quiz: Data Types

Test your understanding with these questions:

1. **Which keyword should you use for a variable that won't change?**
   - A) var
   - B) let
   - C) const
   - D) All of the above

2. **What is the result of `typeof null`?**
   - A) "null"
   - B) "object"
   - C) "undefined"
   - D) "number"

3. **What is the result of `"5" + 3`?**
   - A) 8
   - B) "8"
   - C) "53"
   - D) Error

4. **How many primitive data types does JavaScript have?**
   - A) 5
   - B) 6
   - C) 7
   - D) 8

5. **Which of these is NOT a primitive type?**
   - A) string
   - B) number
   - C) object
   - D) boolean

6. **What does `let` provide that `var` doesn't?**
   - A) Block scope
   - B) Function scope
   - C) Global scope
   - D) All of the above

7. **What is the result of `Boolean("")`?**
   - A) true
   - B) false
   - C) undefined
   - D) null

**Answers**:
1. C) const
2. B) "object" (historical quirk)
3. C) "53" (string concatenation)
4. C) 7
5. C) object (objects are not primitives)
6. A) Block scope
7. B) false (empty string is falsy)

---

## Next Steps

Congratulations! You've learned about variables and data types. You now know:
- How to declare variables with var, let, and const
- All 7 primitive data types
- Type coercion and conversion
- How to use the typeof operator

**What's Next?**
- Module 2: Operators and Expressions
- Lesson 2.1: Arithmetic Operators
- Practice working with different data types
- Experiment with type conversions

---

## Additional Resources

- **MDN: Variables**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Grammar_and_types#declarations](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Grammar_and_types#declarations)
- **MDN: Data Types**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Data_structures](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Data_structures)
- **JavaScript.info: Variables**: [javascript.info/variables](https://javascript.info/variables)
- **JavaScript.info: Types**: [javascript.info/types](https://javascript.info/types)

---

*Lesson completed! You're ready to move on to the next module.*

