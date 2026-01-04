# Lesson 2.2: Comparison and Logical Operators

## Learning Objectives

By the end of this lesson, you will be able to:
- Use all comparison operators (==, ===, !=, !==, <, >, <=, >=)
- Understand the difference between strict (===) and loose (==) equality
- Apply logical operators (&&, ||, !)
- Understand short-circuit evaluation
- Combine comparison and logical operators
- Write conditional logic expressions

---

## Introduction to Comparison Operators

Comparison operators compare two values and return a boolean (`true` or `false`). They are essential for making decisions in your code.

### Comparison Operators Overview

| Operator | Name | Example | Result |
|----------|------|---------|--------|
| `==` | Loose equality | `5 == "5"` | `true` |
| `===` | Strict equality | `5 === "5"` | `false` |
| `!=` | Loose inequality | `5 != "5"` | `false` |
| `!==` | Strict inequality | `5 !== "5"` | `true` |
| `<` | Less than | `3 < 5` | `true` |
| `>` | Greater than | `5 > 3` | `true` |
| `<=` | Less than or equal | `5 <= 5` | `true` |
| `>=` | Greater than or equal | `5 >= 3` | `true` |

---

## Equality Operators

### Loose Equality (==)

The `==` operator performs type coercion before comparison. It converts operands to the same type before comparing.

```javascript
console.log(5 == 5);        // true
console.log(5 == "5");     // true (string converted to number)
console.log(true == 1);     // true (boolean converted to number)
console.log(false == 0);    // true (boolean converted to number)
console.log(null == undefined); // true (special case)
```

**Type Coercion Examples:**
```javascript
// String to number
console.log("5" == 5);      // true

// Boolean to number
console.log(true == 1);    // true
console.log(false == 0);   // true

// null and undefined
console.log(null == undefined);  // true
console.log(null == 0);         // false
console.log(undefined == 0);   // false

// Arrays and objects
console.log([] == 0);      // true (array converted to string, then number)
console.log([5] == 5);     // true
console.log([1, 2] == "1,2"); // true
```

**When Loose Equality Can Be Problematic:**
```javascript
// Unexpected results
console.log("" == 0);           // true
console.log("0" == 0);          // true
console.log(false == "false");  // false (string "false" is not converted to boolean false)
console.log([] == false);       // true
console.log([0] == false);      // true
```

### Strict Equality (===)

The `===` operator compares both value and type. No type coercion occurs.

```javascript
console.log(5 === 5);        // true
console.log(5 === "5");     // false (different types)
console.log(true === 1);     // false (different types)
console.log(false === 0);    // false (different types)
console.log(null === undefined); // false (different types)
```

**Why Use Strict Equality:**
```javascript
// More predictable
console.log(5 === 5);        // true
console.log(5 === "5");     // false (clear: different types)
console.log(true === 1);     // false (clear: different types)

// Prevents bugs
let value = "5";
if (value === 5) {  // false - won't execute
    console.log("Number");
} else {
    console.log("String");  // This runs
}
```

**Best Practice: Always Use `===`**
```javascript
// ✅ Good
if (age === 18) { }
if (name === "Alice") { }
if (isActive === true) { }

// ❌ Avoid
if (age == 18) { }
if (name == "Alice") { }
```

### Inequality Operators

**Loose Inequality (!=):**
```javascript
console.log(5 != 3);        // true
console.log(5 != "5");     // false (coerced, so equal)
console.log(true != 1);     // false (coerced, so equal)
```

**Strict Inequality (!==):**
```javascript
console.log(5 !== 3);        // true
console.log(5 !== "5");     // true (different types)
console.log(true !== 1);     // true (different types)
```

**Best Practice: Always Use `!==`**
```javascript
// ✅ Good
if (age !== 18) { }
if (name !== "Alice") { }

// ❌ Avoid
if (age != 18) { }
```

---

## Relational Operators

Relational operators compare the order of values.

### Less Than (<)

```javascript
console.log(3 < 5);        // true
console.log(5 < 3);       // false
console.log(3 < 3);       // false
console.log("a" < "b");   // true (lexicographic comparison)
console.log("apple" < "banana"); // true
```

**String Comparison:**
```javascript
// Lexicographic (dictionary) order
console.log("a" < "b");        // true
console.log("A" < "a");        // true (uppercase < lowercase in ASCII)
console.log("10" < "2");      // true (string comparison, not numeric!)
console.log("10" < 2);        // false (string "10" converted to 10, then compared)
```

### Greater Than (>)

```javascript
console.log(5 > 3);        // true
console.log(3 > 5);       // false
console.log(5 > 5);       // false
console.log("b" > "a");   // true
```

### Less Than or Equal (<=)

```javascript
console.log(3 <= 5);       // true
console.log(5 <= 5);      // true
console.log(5 <= 3);      // false
```

### Greater Than or Equal (>=)

```javascript
console.log(5 >= 3);       // true
console.log(5 >= 5);      // true
console.log(3 >= 5);      // false
```

### Numeric Comparisons

```javascript
let age = 25;
console.log(age >= 18);    // true (adult)
console.log(age < 65);     // true (not senior)

let score = 85;
console.log(score >= 90);  // false (not A grade)
console.log(score >= 80);  // true (B grade or higher)
```

### String Comparisons

```javascript
// Alphabetical order
console.log("apple" < "banana");  // true
console.log("zebra" > "apple");   // true

// Case matters
console.log("Apple" < "apple");    // true (uppercase comes first in ASCII)
console.log("A" < "a");           // true

// Numbers as strings
console.log("10" < "2");          // true (lexicographic, not numeric!)
console.log("10" < 2);            // false (type coercion to number)
```

---

## Logical Operators

Logical operators combine or negate boolean values.

### Logical AND (&&)

Returns `true` only if both operands are `true`.

```javascript
console.log(true && true);    // true
console.log(true && false);   // false
console.log(false && true);   // false
console.log(false && false);  // false
```

**Practical Examples:**
```javascript
let age = 25;
let hasLicense = true;

if (age >= 18 && hasLicense) {
    console.log("Can drive");  // This runs
}

let isLoggedIn = true;
let isAdmin = false;

if (isLoggedIn && isAdmin) {
    console.log("Admin access");  // Doesn't run
}
```

**Truth Table for AND:**
| A | B | A && B |
|---|---|--------|
| true | true | true |
| true | false | false |
| false | true | false |
| false | false | false |

### Logical OR (||)

Returns `true` if at least one operand is `true`.

```javascript
console.log(true || true);    // true
console.log(true || false);   // true
console.log(false || true);    // true
console.log(false || false);  // false
```

**Practical Examples:**
```javascript
let hasCreditCard = false;
let hasPayPal = true;

if (hasCreditCard || hasPayPal) {
    console.log("Can make payment");  // This runs
}

let isWeekend = false;
let isHoliday = true;

if (isWeekend || isHoliday) {
    console.log("No work today");  // This runs
}
```

**Truth Table for OR:**
| A | B | A \|\| B |
|---|---|----------|
| true | true | true |
| true | false | true |
| false | true | true |
| false | false | false |

### Logical NOT (!)

Negates a boolean value.

```javascript
console.log(!true);    // false
console.log(!false);   // true
console.log(!0);       // true (0 is falsy)
console.log(!1);       // false (1 is truthy)
console.log(!!"hello"); // true (double negation converts to boolean)
```

**Practical Examples:**
```javascript
let isLoggedOut = !isLoggedIn;

if (!isAdmin) {
    console.log("Regular user");
}

let isEmpty = !array.length;  // true if array is empty
```

**Truth Table for NOT:**
| A | !A |
|---|---|
| true | false |
| false | true |

### Combining Logical Operators

```javascript
let age = 25;
let hasLicense = true;
let hasInsurance = false;

// Complex condition
if (age >= 18 && hasLicense && hasInsurance) {
    console.log("Can drive legally");
} else {
    console.log("Cannot drive");  // This runs (missing insurance)
}

// Using OR
if (age < 18 || !hasLicense) {
    console.log("Cannot drive");
}

// Combining AND and OR
if ((age >= 18 && hasLicense) || hasInsurance) {
    console.log("Some form of driving allowed");
}
```

**Operator Precedence:**
```javascript
// NOT has highest precedence, then AND, then OR
let result = !false && true || false;
// Evaluated as: ((!false) && true) || false
// = (true && true) || false
// = true || false
// = true
```

---

## Short-Circuit Evaluation

JavaScript uses short-circuit evaluation for logical operators, meaning it stops evaluating as soon as the result is determined.

### AND Short-Circuit (&&)

If the left operand is `false`, the right operand is not evaluated.

```javascript
// If first is false, second is never evaluated
false && console.log("This won't print");

// If first is true, second is evaluated
true && console.log("This will print");  // "This will print"
```

**Practical Use - Default Values:**
```javascript
// If user exists, get name, otherwise use "Guest"
let userName = user && user.name || "Guest";

// If config exists, use it, otherwise use default
let settings = config && config.settings || defaultSettings;
```

**Conditional Execution:**
```javascript
// Only call function if condition is true
isLoggedIn && showDashboard();

// Only set value if it exists
data && processData(data);
```

### OR Short-Circuit (||)

If the left operand is `true`, the right operand is not evaluated.

```javascript
// If first is true, second is never evaluated
true || console.log("This won't print");

// If first is false, second is evaluated
false || console.log("This will print");  // "This will print"
```

**Practical Use - Default Values:**
```javascript
// Use provided value or default
let name = userName || "Guest";
let port = config.port || 3000;
let theme = userTheme || "light";
```

**Fallback Values:**
```javascript
// Try first option, fallback to second, then third
let value = option1 || option2 || option3 || "default";
```

### Real-World Examples

**1. Safe Property Access:**
```javascript
// Avoid errors if user might be null
let name = user && user.profile && user.profile.name || "Anonymous";

// Modern alternative (optional chaining - ES2020)
let name2 = user?.profile?.name || "Anonymous";
```

**2. Function Calls:**
```javascript
// Only call if function exists
callback && callback(data);

// Call with fallback
onSuccess && onSuccess(result) || console.log("No callback");
```

**3. Default Parameters:**
```javascript
function greet(name) {
    name = name || "Guest";
    console.log(`Hello, ${name}!`);
}

greet("Alice");  // "Hello, Alice!"
greet();        // "Hello, Guest!"
```

---

## Combining Comparison and Logical Operators

You can combine comparison and logical operators to create complex conditions.

### Examples

```javascript
let age = 25;
let hasLicense = true;
let hasInsurance = true;

// Multiple conditions
if (age >= 18 && age <= 65 && hasLicense && hasInsurance) {
    console.log("Fully qualified driver");
}

let score = 85;
let attendance = 0.95;

// Grade determination
if (score >= 90 && attendance >= 0.9) {
    console.log("Grade A");
} else if (score >= 80 && attendance >= 0.8) {
    console.log("Grade B");
} else if (score >= 70 || attendance < 0.7) {
    console.log("Grade C or needs improvement");
}
```

### Complex Conditions

```javascript
let temperature = 25;
let isRaining = false;
let isWeekend = true;

// Complex weather condition
if ((temperature > 20 && temperature < 30) && !isRaining && isWeekend) {
    console.log("Perfect day for outdoor activities");
}

let user = {
    age: 25,
    isPremium: true,
    isActive: true
};

// Multiple checks
if (user.age >= 18 && user.isPremium && user.isActive) {
    console.log("Full access granted");
}
```

### Precedence in Complex Expressions

```javascript
// Parentheses clarify intent
let result = (age >= 18 && hasLicense) || (hasParent && isSupervised);

// Without parentheses (same result due to precedence)
let result2 = age >= 18 && hasLicense || hasParent && isSupervised;
// Evaluated as: (age >= 18 && hasLicense) || (hasParent && isSupervised)
```

---

## Practice Exercise

### Exercise: Conditional Logic Practice

**Objective**: Write a program that uses comparison and logical operators to make decisions.

**Instructions**:

1. Create a file called `conditional-logic.js`

2. Define variables for a user profile:
   - Age
   - Has driver's license (boolean)
   - Has insurance (boolean)
   - Credit score
   - Is premium member (boolean)

3. Write conditions to determine:
   - Can the user drive? (age >= 18 && hasLicense)
   - Can the user drive legally? (age >= 18 && hasLicense && hasInsurance)
   - Is the user eligible for a loan? (credit score >= 700 || isPremium)
   - What membership level? (premium or regular)
   - Age category (minor, adult, senior)

4. Display all results with clear messages

**Example Solution**:

```javascript
// Conditional Logic Practice
let age = 25;
let hasLicense = true;
let hasInsurance = true;
let creditScore = 750;
let isPremium = false;

console.log("=== User Profile ===");
console.log(`Age: ${age}`);
console.log(`Has License: ${hasLicense}`);
console.log(`Has Insurance: ${hasInsurance}`);
console.log(`Credit Score: ${creditScore}`);
console.log(`Premium Member: ${isPremium}`);
console.log();

// Driving Eligibility
console.log("=== Driving Eligibility ===");
if (age >= 18 && hasLicense) {
    console.log("✅ Can drive");
} else {
    console.log("❌ Cannot drive");
}

if (age >= 18 && hasLicense && hasInsurance) {
    console.log("✅ Can drive legally");
} else {
    console.log("❌ Cannot drive legally");
}
console.log();

// Loan Eligibility
console.log("=== Loan Eligibility ===");
if (creditScore >= 700 || isPremium) {
    console.log("✅ Eligible for loan");
} else {
    console.log("❌ Not eligible for loan");
}
console.log();

// Membership Level
console.log("=== Membership Level ===");
if (isPremium) {
    console.log("⭐ Premium Member");
} else {
    console.log("👤 Regular Member");
}
console.log();

// Age Category
console.log("=== Age Category ===");
if (age < 18) {
    console.log("Minor");
} else if (age >= 18 && age < 65) {
    console.log("Adult");
} else {
    console.log("Senior");
}
console.log();

// Complex Conditions
console.log("=== Complex Conditions ===");
let canRentCar = age >= 21 && hasLicense && hasInsurance && (creditScore >= 650 || isPremium);
if (canRentCar) {
    console.log("✅ Can rent a car");
} else {
    console.log("❌ Cannot rent a car");
}

let hasFullAccess = age >= 18 && isPremium && creditScore >= 700;
if (hasFullAccess) {
    console.log("✅ Has full platform access");
} else {
    console.log("❌ Limited access");
}

// Comparison Examples
console.log();
console.log("=== Comparison Examples ===");
console.log(`Age >= 18: ${age >= 18}`);
console.log(`Age < 30: ${age < 30}`);
console.log(`Credit Score > 700: ${creditScore > 700}`);
console.log(`Credit Score <= 800: ${creditScore <= 800}`);

// Logical Operator Examples
console.log();
console.log("=== Logical Operator Examples ===");
console.log(`hasLicense && hasInsurance: ${hasLicense && hasInsurance}`);
console.log(`hasLicense || hasInsurance: ${hasLicense || hasInsurance}`);
console.log(`!isPremium: ${!isPremium}`);
console.log(`age >= 18 && creditScore >= 700: ${age >= 18 && creditScore >= 700}`);
```

**Expected Output**:
```
=== User Profile ===
Age: 25
Has License: true
Has Insurance: true
Credit Score: 750
Premium Member: false

=== Driving Eligibility ===
✅ Can drive
✅ Can drive legally

=== Loan Eligibility ===
✅ Eligible for loan

=== Membership Level ===
👤 Regular Member

=== Age Category ===
Adult

=== Complex Conditions ===
✅ Can rent a car
✅ Has full platform access

=== Comparison Examples ===
Age >= 18: true
Age < 30: true
Credit Score > 700: true
Credit Score <= 800: true

=== Logical Operator Examples ===
hasLicense && hasInsurance: true
hasLicense || hasInsurance: true
!isPremium: true
age >= 18 && creditScore >= 700: true
```

**Challenge (Optional)**:
- Add more conditions (voting eligibility, senior discounts)
- Create a grading system (A, B, C, D, F)
- Build a discount calculator based on multiple conditions
- Use short-circuit evaluation for default values

---

## Common Mistakes

### 1. Using == Instead of ===

```javascript
// ❌ Can cause bugs
if (age == "18") { }  // Might be true unexpectedly

// ✅ Always use strict equality
if (age === 18) { }
```

### 2. Confusing && and ||

```javascript
// ❌ Wrong logic
if (age >= 18 || hasLicense) { }  // Too permissive

// ✅ Correct
if (age >= 18 && hasLicense) { }  // Both required
```

### 3. Forgetting Operator Precedence

```javascript
// ❌ Might not work as expected
if (age >= 18 && hasLicense || isParent) { }

// ✅ Use parentheses for clarity
if ((age >= 18 && hasLicense) || isParent) { }
```

### 4. String vs Number Comparison

```javascript
// ❌ String comparison
if ("10" < "2") { }  // true (lexicographic)

// ✅ Numeric comparison
if (10 < 2) { }  // false
if (Number("10") < 2) { }  // false
```

### 5. Truthy/Falsy Confusion

```javascript
// ⚠️ Be careful with truthy/falsy
if (userName) { }  // false if userName is "" or null

// ✅ Explicit check
if (userName !== "" && userName !== null) { }
// Or
if (userName && userName.length > 0) { }
```

---

## Key Takeaways

1. **Strict Equality**: Always use `===` and `!==` instead of `==` and `!=`
2. **Comparison Operators**: `<`, `>`, `<=`, `>=` compare values
3. **Logical Operators**: `&&` (AND), `||` (OR), `!` (NOT)
4. **Short-Circuit**: `&&` and `||` stop evaluating when result is known
5. **Combining Operators**: Use parentheses to clarify complex conditions
6. **Best Practice**: Use strict equality and explicit boolean checks

---

## Quiz: Operators

Test your understanding with these questions:

1. **What is the result of `5 === "5"`?**
   - A) true
   - B) false
   - C) undefined
   - D) Error

2. **What is the result of `true && false`?**
   - A) true
   - B) false
   - C) undefined
   - D) null

3. **What is the result of `true || false`?**
   - A) true
   - B) false
   - C) undefined
   - D) null

4. **Which operator should you use for equality?**
   - A) ==
   - B) ===
   - C) =
   - D) == or === (doesn't matter)

5. **What is the result of `!true`?**
   - A) true
   - B) false
   - C) 1
   - D) 0

6. **What is the result of `"10" < "2"`?**
   - A) true
   - B) false
   - C) Error
   - D) undefined

7. **In `true && false || true`, what is evaluated first?**
   - A) true && false
   - B) false || true
   - C) They're evaluated simultaneously
   - D) Depends on the context

**Answers**:
1. B) false (strict equality checks type)
2. B) false (AND requires both true)
3. A) true (OR needs at least one true)
4. B) === (always use strict equality)
5. B) false (NOT negates the value)
6. A) true (string comparison is lexicographic)
7. A) true && false (AND has higher precedence than OR)

---

## Next Steps

Congratulations! You've learned comparison and logical operators. You now know:
- How to compare values with comparison operators
- The difference between strict and loose equality
- How to use logical operators
- How short-circuit evaluation works

**What's Next?**
- Lesson 2.3: Assignment and Other Operators
- Practice combining operators
- Experiment with short-circuit evaluation
- Build more complex conditional logic

---

## Additional Resources

- **MDN: Comparison Operators**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Expressions_and_Operators#comparison_operators](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Expressions_and_Operators#comparison_operators)
- **MDN: Logical Operators**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Expressions_and_Operators#logical_operators](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Expressions_and_Operators#logical_operators)
- **JavaScript.info: Comparisons**: [javascript.info/comparison](https://javascript.info/comparison)
- **JavaScript.info: Logical Operators**: [javascript.info/logical-operators](https://javascript.info/logical-operators)

---

*Lesson completed! You're ready to move on to the next lesson.*

