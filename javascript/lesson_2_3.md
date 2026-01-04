# Lesson 2.3: Assignment and Other Operators

## Learning Objectives

By the end of this lesson, you will be able to:
- Use the assignment operator (=)
- Apply augmented assignment operators (+=, -=, *=, /=, %=, **=)
- Use the ternary operator (?:) for conditional expressions
- Understand nullish coalescing (??) for default values
- Use optional chaining (?.) for safe property access
- Combine these operators effectively in your code

---

## Assignment Operator (=)

The assignment operator assigns a value to a variable.

### Basic Assignment

```javascript
let x = 5;        // Assign 5 to x
let name = "Alice";  // Assign "Alice" to name
let isActive = true; // Assign true to isActive
```

### Multiple Assignments

```javascript
// Chain assignments (same value)
let a, b, c;
a = b = c = 10;
console.log(a, b, c);  // 10 10 10

// Multiple variables, different values
let x = 5, y = 10, z = 15;
```

### Assignment Returns a Value

The assignment operator returns the assigned value, allowing chaining:

```javascript
let x;
let y = x = 5;  // x = 5, then y = x (which is 5)
console.log(x, y);  // 5 5
```

### Common Patterns

```javascript
// Initialize variable
let count = 0;

// Update variable
count = count + 1;  // Increment

// Reassign with new value
let price = 10;
price = 15;  // Update price
```

---

## Augmented Assignment Operators

Augmented assignment operators combine an operation with assignment, making code more concise.

### Addition Assignment (+=)

```javascript
let x = 5;
x += 3;  // Equivalent to: x = x + 3
console.log(x);  // 8

// With strings (concatenation)
let message = "Hello";
message += " World";
console.log(message);  // "Hello World"
```

### Subtraction Assignment (-=)

```javascript
let x = 10;
x -= 3;  // Equivalent to: x = x - 3
console.log(x);  // 7
```

### Multiplication Assignment (*=)

```javascript
let x = 5;
x *= 3;  // Equivalent to: x = x * 3
console.log(x);  // 15
```

### Division Assignment (/=)

```javascript
let x = 15;
x /= 3;  // Equivalent to: x = x / 3
console.log(x);  // 5
```

### Modulo Assignment (%=)

```javascript
let x = 10;
x %= 3;  // Equivalent to: x = x % 3
console.log(x);  // 1
```

### Exponentiation Assignment (**=)

```javascript
let x = 2;
x **= 3;  // Equivalent to: x = x ** 3
console.log(x);  // 8
```

### Complete List

| Operator | Example | Equivalent To |
|----------|---------|--------------|
| `+=` | `x += 5` | `x = x + 5` |
| `-=` | `x -= 5` | `x = x - 5` |
| `*=` | `x *= 5` | `x = x * 5` |
| `/=` | `x /= 5` | `x = x / 5` |
| `%=` | `x %= 5` | `x = x % 5` |
| `**=` | `x **= 5` | `x = x ** 5` |

### Practical Examples

```javascript
// Counter
let count = 0;
count += 1;  // count is now 1
count += 1;  // count is now 2

// Accumulator
let total = 0;
total += 10;  // total is 10
total += 20;  // total is 30
total += 30;  // total is 60

// String building
let html = "";
html += "<div>";
html += "Hello";
html += "</div>";
console.log(html);  // "<div>Hello</div>"

// Percentage calculation
let price = 100;
price *= 1.1;  // Add 10% (price = price * 1.1)
console.log(price);  // 110

// Halving
let value = 100;
value /= 2;  // value = value / 2
console.log(value);  // 50
```

### Benefits of Augmented Assignment

**More Concise:**
```javascript
// Without augmented assignment
let x = 5;
x = x + 3;

// With augmented assignment
let x = 5;
x += 3;  // Shorter and clearer
```

**Less Error-Prone:**
```javascript
// Easy to make mistake
let x = 5;
x = x + 3;  // What if you forget the 'x =' part?

// Harder to make mistake
let x = 5;
x += 3;  // Clear intent
```

---

## Ternary Operator (?:)

The ternary operator is a concise way to write conditional expressions. It's the only operator that takes three operands.

### Syntax

```javascript
condition ? valueIfTrue : valueIfFalse
```

### Basic Usage

```javascript
let age = 20;
let status = age >= 18 ? "Adult" : "Minor";
console.log(status);  // "Adult"

// Equivalent if-else
let status2;
if (age >= 18) {
    status2 = "Adult";
} else {
    status2 = "Minor";
}
```

### Examples

**Simple Condition:**
```javascript
let isLoggedIn = true;
let message = isLoggedIn ? "Welcome back!" : "Please log in";
console.log(message);  // "Welcome back!"

let score = 85;
let grade = score >= 90 ? "A" : "B";
console.log(grade);  // "B"
```

**Multiple Uses:**
```javascript
let temperature = 25;
let weather = temperature > 20 ? "Warm" : "Cold";
console.log(weather);  // "Warm"

let user = null;
let userName = user ? user.name : "Guest";
console.log(userName);  // "Guest"
```

### Nested Ternary (Use Sparingly)

```javascript
let score = 85;
let grade = score >= 90 ? "A" : 
            score >= 80 ? "B" : 
            score >= 70 ? "C" : "F";
console.log(grade);  // "B"

// More readable with if-else
let grade2;
if (score >= 90) {
    grade2 = "A";
} else if (score >= 80) {
    grade2 = "B";
} else if (score >= 70) {
    grade2 = "C";
} else {
    grade2 = "F";
}
```

### Ternary in Expressions

```javascript
let x = 5;
let y = 10;
let max = x > y ? x : y;
console.log(max);  // 10

let a = 3;
let b = 7;
let result = a > b ? a * 2 : b * 2;
console.log(result);  // 14
```

### Ternary for Function Calls

```javascript
let isAdmin = true;
isAdmin ? showAdminPanel() : showUserPanel();

let user = getUser();
user ? logUserActivity(user) : logGuestActivity();
```

### When to Use Ternary

**Good Use Cases:**
- Simple true/false assignments
- Short, readable conditions
- Inline conditional values

**Avoid For:**
- Complex nested conditions
- Multiple statements
- When if-else is clearer

```javascript
// ✅ Good
let message = isActive ? "Active" : "Inactive";

// ❌ Too complex
let result = a > b ? (c > d ? e : f) : (g > h ? i : j);

// ✅ Better
let result;
if (a > b) {
    result = c > d ? e : f;
} else {
    result = g > h ? i : j;
}
```

---

## Nullish Coalescing (??)

The nullish coalescing operator (`??`) returns the right operand when the left is `null` or `undefined`, otherwise returns the left operand.

### Basic Usage

```javascript
let value = null;
let result = value ?? "default";
console.log(result);  // "default"

let value2 = undefined;
let result2 = value2 ?? "default";
console.log(result2);  // "default"

let value3 = "actual";
let result3 = value3 ?? "default";
console.log(result3);  // "actual"
```

### vs Logical OR (||)

**Key Difference:**
- `||` returns right operand for any falsy value (false, 0, "", null, undefined, NaN)
- `??` only returns right operand for `null` or `undefined`

```javascript
// With ||
let value1 = 0;
let result1 = value1 || "default";
console.log(result1);  // "default" (0 is falsy)

let value2 = "";
let result2 = value2 || "default";
console.log(result2);  // "default" ("" is falsy)

let value3 = false;
let result3 = value3 || "default";
console.log(result3);  // "default" (false is falsy)

// With ??
let value4 = 0;
let result4 = value4 ?? "default";
console.log(result4);  // 0 (0 is not null/undefined)

let value5 = "";
let result5 = value5 ?? "default";
console.log(result5);  // "" ("" is not null/undefined)

let value6 = false;
let result6 = value6 ?? "default";
console.log(result6);  // false (false is not null/undefined)

// Only null/undefined trigger ??
let value7 = null;
let result7 = value7 ?? "default";
console.log(result7);  // "default"

let value8 = undefined;
let result8 = value8 ?? "default";
console.log(result8);  // "default"
```

### Practical Examples

**Default Values:**
```javascript
// User input
let userName = getUserName() ?? "Guest";
console.log(userName);

// Configuration
let port = config.port ?? 3000;
let theme = userSettings.theme ?? "light";

// API response
let data = response.data ?? [];
let count = response.count ?? 0;
```

**Function Parameters:**
```javascript
function greet(name) {
    name = name ?? "Guest";
    console.log(`Hello, ${name}!`);
}

greet("Alice");  // "Hello, Alice!"
greet(null);     // "Hello, Guest!"
greet();         // "Hello, Guest!"
```

**Object Properties:**
```javascript
let user = {
    name: "Alice",
    age: null,
    email: undefined
};

let displayName = user.name ?? "Anonymous";
let displayAge = user.age ?? "Not specified";
let displayEmail = user.email ?? "No email";

console.log(displayName);   // "Alice"
console.log(displayAge);     // "Not specified"
console.log(displayEmail);   // "No email"
```

**Chaining:**
```javascript
let value = null;
let result = value ?? getDefault() ?? "fallback";
console.log(result);  // result of getDefault() or "fallback"
```

### When to Use ??

**Use `??` when:**
- You want to preserve falsy values (0, "", false)
- You only care about null/undefined
- Setting default values for optional properties

**Use `||` when:**
- You want to replace any falsy value
- Working with boolean logic
- Legacy code compatibility

```javascript
// ✅ Use ?? for numeric defaults
let count = userCount ?? 0;  // Preserves 0 if userCount is 0

// ✅ Use ?? for string defaults
let name = userName ?? "";  // Preserves "" if userName is ""

// ✅ Use || for boolean logic
let isActive = user.isActive || false;  // Converts truthy to true
```

---

## Optional Chaining (?.)

The optional chaining operator (`?.`) allows safe access to nested object properties and methods, returning `undefined` if any part of the chain is `null` or `undefined`.

### Property Access

```javascript
let user = {
    name: "Alice",
    address: {
        city: "New York"
    }
};

// Without optional chaining (can throw error)
let city1 = user.address.city;  // Works
// let city2 = user.address.street.name;  // Error if street is undefined

// With optional chaining (safe)
let city3 = user.address?.city;  // "New York"
let street = user.address?.street?.name;  // undefined (no error)
```

### Method Calls

```javascript
let user = {
    name: "Alice",
    greet: function() {
        return `Hello, ${this.name}`;
    }
};

// Safe method call
let greeting = user.greet?.();  // "Hello, Alice"

let user2 = null;
let greeting2 = user2.greet?.();  // undefined (no error)
```

### Array Access

```javascript
let users = [
    { name: "Alice" },
    { name: "Bob" }
];

// Safe array access
let firstName = users?.[0]?.name;  // "Alice"
let invalid = users?.[10]?.name;  // undefined (no error)

let emptyArray = null;
let item = emptyArray?.[0];  // undefined (no error)
```

### Combining with Nullish Coalescing

```javascript
let user = {
    profile: {
        name: "Alice"
    }
};

// Safe access with default
let name = user?.profile?.name ?? "Guest";
console.log(name);  // "Alice"

let user2 = null;
let name2 = user2?.profile?.name ?? "Guest";
console.log(name2);  // "Guest"
```

### Practical Examples

**API Responses:**
```javascript
let response = {
    data: {
        user: {
            name: "Alice",
            email: "alice@example.com"
        }
    }
};

// Safe access
let userName = response?.data?.user?.name ?? "Unknown";
let userEmail = response?.data?.user?.email ?? "No email";

// If response structure is different
let userName2 = response?.data?.users?.[0]?.name ?? "Unknown";
```

**DOM Manipulation:**
```javascript
// Safe DOM access
let element = document.querySelector(".my-element");
let text = element?.textContent ?? "Not found";

// Method calls
element?.addEventListener("click", handleClick);
element?.classList?.add("active");
```

**Function Calls:**
```javascript
let obj = {
    method: function() {
        return "result";
    }
};

// Safe method call
let result = obj.method?.();  // "result"

let obj2 = {};
let result2 = obj2.method?.();  // undefined (no error)
```

### When to Use Optional Chaining

**Use `?.` when:**
- Accessing nested properties that might not exist
- Working with API responses with uncertain structure
- Accessing DOM elements that might be null
- Calling methods that might not exist

**Benefits:**
- Prevents errors from null/undefined
- Cleaner code than multiple if checks
- Works well with nullish coalescing

```javascript
// Without optional chaining (verbose)
let city;
if (user && user.address && user.address.city) {
    city = user.address.city;
} else {
    city = "Unknown";
}

// With optional chaining (concise)
let city = user?.address?.city ?? "Unknown";
```

---

## Combining Operators

You can combine these operators for powerful, concise code.

### Examples

```javascript
// Augmented assignment with calculation
let total = 0;
total += 10;
total += 20;
total *= 1.1;  // Add 10%
console.log(total);  // 33

// Ternary with assignment
let age = 20;
let canVote = age >= 18 ? true : false;
let status = age >= 18 ? "Adult" : "Minor";

// Optional chaining with nullish coalescing
let user = getUser();
let name = user?.profile?.name ?? "Guest";
let email = user?.contact?.email ?? "No email";

// Complex expression
let result = (x ?? 0) + (y ?? 0);
let display = user?.name ?? config?.defaultName ?? "Anonymous";
```

### Real-World Example

```javascript
// User profile with safe defaults
let user = getUserFromAPI();

let profile = {
    name: user?.name ?? "Guest",
    age: user?.age ?? 0,
    email: user?.contact?.email ?? "No email",
    city: user?.address?.city ?? "Unknown",
    isPremium: user?.subscription?.type === "premium"
};

// Update counters
let viewCount = 0;
viewCount += 1;
viewCount *= 1.1;  // Add 10% bonus

// Conditional assignment
let discount = user?.isPremium ? 0.2 : 0.1;
let finalPrice = price * (1 - discount);
```

---

## Practice Exercise

### Exercise: Using Operators

**Objective**: Write a program that demonstrates all assignment and other operators.

**Instructions**:

1. Create a file called `operators-practice.js`

2. Use augmented assignment operators:
   - Start with a value and modify it using +=, -=, *=, /=

3. Use ternary operator:
   - Determine status based on conditions
   - Assign values conditionally

4. Use nullish coalescing:
   - Set default values for potentially null/undefined variables
   - Handle API-like data structures

5. Use optional chaining:
   - Safely access nested object properties
   - Handle potentially missing properties

6. Combine operators:
   - Create complex expressions using multiple operators

**Example Solution**:

```javascript
// Operators Practice
console.log("=== Augmented Assignment ===");
let total = 100;
console.log(`Initial: ${total}`);

total += 50;  // Add 50
console.log(`After += 50: ${total}`);  // 150

total -= 25;  // Subtract 25
console.log(`After -= 25: ${total}`);  // 125

total *= 2;   // Multiply by 2
console.log(`After *= 2: ${total}`);   // 250

total /= 5;   // Divide by 5
console.log(`After /= 5: ${total}`);   // 50

total %= 7;   // Modulo 7
console.log(`After %= 7: ${total}`);   // 1
console.log();

console.log("=== Ternary Operator ===");
let age = 20;
let status = age >= 18 ? "Adult" : "Minor";
console.log(`Age ${age}: ${status}`);  // "Adult"

let score = 85;
let grade = score >= 90 ? "A" : score >= 80 ? "B" : "C";
console.log(`Score ${score}: Grade ${grade}`);  // "B"

let isLoggedIn = true;
let message = isLoggedIn ? "Welcome back!" : "Please log in";
console.log(message);  // "Welcome back!"
console.log();

console.log("=== Nullish Coalescing ===");
let userName = null;
let displayName = userName ?? "Guest";
console.log(`User: ${displayName}`);  // "Guest"

let count = 0;
let result = count ?? 10;
console.log(`Count: ${result}`);  // 0 (preserved, not replaced)

let value = undefined;
let defaultValue = value ?? "Not set";
console.log(`Value: ${defaultValue}`);  // "Not set"

// With function
function getConfig() {
    return null;
}
let config = getConfig() ?? { port: 3000, theme: "light" };
console.log(`Config:`, config);
console.log();

console.log("=== Optional Chaining ===");
let user = {
    name: "Alice",
    profile: {
        age: 25,
        email: "alice@example.com"
    }
};

let name = user?.name ?? "Unknown";
let age = user?.profile?.age ?? 0;
let email = user?.profile?.email ?? "No email";
let city = user?.profile?.city ?? "Not specified";

console.log(`Name: ${name}`);
console.log(`Age: ${age}`);
console.log(`Email: ${email}`);
console.log(`City: ${city}`);

// Safe method call
let user2 = {
    greet: function() {
        return "Hello!";
    }
};
let greeting = user2.greet?.() ?? "No greeting";
console.log(`Greeting: ${greeting}`);  // "Hello!"

let user3 = null;
let greeting2 = user3.greet?.() ?? "No greeting";
console.log(`Greeting: ${greeting2}`);  // "No greeting"
console.log();

console.log("=== Combining Operators ===");
let data = {
    user: {
        profile: {
            name: "Bob",
            score: 85
        }
    }
};

// Complex expression
let finalScore = (data?.user?.profile?.score ?? 0) + 10;
let finalGrade = finalScore >= 90 ? "A" : finalScore >= 80 ? "B" : "C";

console.log(`Score: ${finalScore}`);
console.log(`Grade: ${finalGrade}`);

// Accumulator with conditions
let points = 0;
points += data?.user?.profile?.score ?? 0;
points *= 1.1;  // 10% bonus
console.log(`Final Points: ${points}`);

// Conditional assignment with defaults
let settings = {
    theme: null,
    language: "en"
};

let theme = settings?.theme ?? "light";
let language = settings?.language ?? "en";
let fontSize = settings?.fontSize ?? 16;

console.log(`Theme: ${theme}`);
console.log(`Language: ${language}`);
console.log(`Font Size: ${fontSize}`);
```

**Expected Output**:
```
=== Augmented Assignment ===
Initial: 100
After += 50: 150
After -= 25: 125
After *= 2: 250
After /= 5: 50
After %= 7: 1

=== Ternary Operator ===
Age 20: Adult
Score 85: Grade B
Welcome back!

=== Nullish Coalescing ===
User: Guest
Count: 0
Value: Not set
Config: { port: 3000, theme: 'light' }

=== Optional Chaining ===
Name: Alice
Age: 25
Email: alice@example.com
City: Not specified
Greeting: Hello!
Greeting: No greeting

=== Combining Operators ===
Score: 95
Grade: A
Final Points: 104.5
Theme: light
Language: en
Font Size: 16
```

**Challenge (Optional)**:
- Create a shopping cart calculator using augmented assignment
- Build a user profile system with optional chaining and nullish coalescing
- Create a grading system using ternary operators
- Build a configuration manager with all operators

---

## Common Mistakes

### 1. Confusing = with == or ===

```javascript
// ❌ Wrong (assignment, not comparison)
if (x = 5) { }  // Always true, assigns 5 to x

// ✅ Correct
if (x === 5) { }  // Compares x with 5
```

### 2. Using || Instead of ??

```javascript
// ❌ Might not preserve 0 or ""
let count = userCount || 0;  // Loses 0 if userCount is 0

// ✅ Preserves falsy values
let count = userCount ?? 0;  // Keeps 0 if userCount is 0
```

### 3. Forgetting Optional Chaining

```javascript
// ❌ Can throw error
let city = user.address.city;  // Error if address is undefined

// ✅ Safe access
let city = user?.address?.city ?? "Unknown";
```

### 4. Overusing Ternary

```javascript
// ❌ Too complex
let result = a > b ? (c > d ? e : f) : (g > h ? i : j);

// ✅ More readable
let result;
if (a > b) {
    result = c > d ? e : f;
} else {
    result = g > h ? i : j;
}
```

### 5. Wrong Operator Precedence

```javascript
// ⚠️ Be careful with precedence
let x = 5;
let y = x += 3;  // x is 8, y is 8 (assignment returns value)

// Clearer
let x = 5;
x += 3;
let y = x;
```

---

## Key Takeaways

1. **Assignment (=)**: Assigns values to variables
2. **Augmented Assignment**: Shorthand for `x = x op y` (e.g., `x += 5`)
3. **Ternary (?:)**: Concise conditional expression
4. **Nullish Coalescing (??)**: Default values for null/undefined only
5. **Optional Chaining (?.)**: Safe access to nested properties
6. **Combine Operators**: Use together for powerful, concise code
7. **Best Practice**: Use `??` for defaults, `?.` for safe access, ternary for simple conditions

---

## Quiz: Assignment Operations

Test your understanding with these questions:

1. **What is the result of `let x = 5; x += 3;` (x = ?)**
   - A) 5
   - B) 8
   - C) 15
   - D) Error

2. **What is the result of `let x = 5; let y = x += 3;` (y = ?)**
   - A) 5
   - B) 8
   - C) 3
   - D) undefined

3. **What is the result of `5 > 3 ? "Yes" : "No"`?**
   - A) true
   - B) false
   - C) "Yes"
   - D) "No"

4. **What is the result of `null ?? "default"`?**
   - A) null
   - B) "default"
   - C) undefined
   - D) Error

5. **What is the result of `0 ?? "default"`?**
   - A) 0
   - B) "default"
   - C) undefined
   - D) false

6. **What is the result of `user?.profile?.name` if user is null?**
   - A) null
   - B) undefined
   - C) Error
   - D) ""

7. **Which operator should you use for default values when you want to preserve 0 and ""?**
   - A) ||
   - B) ??
   - C) ?.
   - D) :

**Answers**:
1. B) 8
2. B) 8 (assignment returns the assigned value)
3. C) "Yes" (ternary returns value based on condition)
4. B) "default" (null triggers nullish coalescing)
5. A) 0 (0 is not null/undefined, so it's preserved)
6. B) undefined (optional chaining returns undefined for null)
7. B) ?? (nullish coalescing preserves falsy values except null/undefined)

---

## Next Steps

Congratulations! You've learned assignment and other operators. You now know:
- How to use augmented assignment operators
- How to write conditional expressions with ternary
- How to set defaults with nullish coalescing
- How to safely access properties with optional chaining

**What's Next?**
- Module 3: Control Flow
- Lesson 3.1: Conditional Statements
- Practice combining all operators
- Build more complex programs

---

## Additional Resources

- **MDN: Assignment Operators**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Expressions_and_Operators#assignment_operators](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Expressions_and_Operators#assignment_operators)
- **MDN: Conditional (Ternary) Operator**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Conditional_Operator](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Conditional_Operator)
- **MDN: Nullish Coalescing**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Nullish_coalescing](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Nullish_coalescing)
- **MDN: Optional Chaining**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Optional_chaining](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Optional_chaining)
- **JavaScript.info: Operators**: [javascript.info/operators](https://javascript.info/operators)

---

*Lesson completed! You've finished Module 2. Ready for Module 3: Control Flow!*

