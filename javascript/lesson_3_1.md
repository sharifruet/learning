# Lesson 3.1: Conditional Statements

## Learning Objectives

By the end of this lesson, you will be able to:
- Use if, else, and else if statements to make decisions
- Understand truthy and falsy values in JavaScript
- Use switch statements for multiple conditions
- Write nested conditional statements
- Apply conditional logic to solve real-world problems

---

## Introduction to Conditional Statements

Conditional statements allow your program to make decisions and execute different code based on conditions. They are fundamental to programming and enable your code to respond dynamically to different situations.

### Why Conditional Statements?

- Make decisions based on user input
- Handle different scenarios
- Validate data
- Control program flow
- Create interactive applications

---

## if Statement

The `if` statement executes a block of code only if a condition is true.

### Basic Syntax

```javascript
if (condition) {
    // Code to execute if condition is true
}
```

### Simple Example

```javascript
let age = 20;

if (age >= 18) {
    console.log("You are an adult");
}
// Output: "You are an adult"
```

### Multiple Statements

```javascript
let score = 85;

if (score >= 80) {
    console.log("Great job!");
    console.log("You passed the exam");
    console.log("Your grade is B or higher");
}
```

### Real-World Examples

```javascript
// Check if user is logged in
let isLoggedIn = true;

if (isLoggedIn) {
    console.log("Welcome back!");
    showDashboard();
}

// Check if number is positive
let number = 5;

if (number > 0) {
    console.log("Number is positive");
}

// Check if string is not empty
let name = "Alice";

if (name.length > 0) {
    console.log(`Hello, ${name}!`);
}
```

---

## else Statement

The `else` statement provides an alternative code block that executes when the condition is false.

### Basic Syntax

```javascript
if (condition) {
    // Code if condition is true
} else {
    // Code if condition is false
}
```

### Example

```javascript
let age = 15;

if (age >= 18) {
    console.log("You are an adult");
} else {
    console.log("You are a minor");
}
// Output: "You are a minor"
```

### More Examples

```javascript
// Even or odd
let number = 7;

if (number % 2 === 0) {
    console.log("Even");
} else {
    console.log("Odd");
}
// Output: "Odd"

// Login check
let isLoggedIn = false;

if (isLoggedIn) {
    console.log("Welcome!");
} else {
    console.log("Please log in");
}
// Output: "Please log in"

// Temperature check
let temperature = 25;

if (temperature > 20) {
    console.log("It's warm");
} else {
    console.log("It's cold");
}
// Output: "It's warm"
```

---

## else if Statement

The `else if` statement allows you to check multiple conditions in sequence.

### Basic Syntax

```javascript
if (condition1) {
    // Code if condition1 is true
} else if (condition2) {
    // Code if condition2 is true
} else if (condition3) {
    // Code if condition3 is true
} else {
    // Code if all conditions are false
}
```

### Example: Grade System

```javascript
let score = 85;

if (score >= 90) {
    console.log("Grade A");
} else if (score >= 80) {
    console.log("Grade B");
} else if (score >= 70) {
    console.log("Grade C");
} else if (score >= 60) {
    console.log("Grade D");
} else {
    console.log("Grade F");
}
// Output: "Grade B"
```

### Multiple Conditions

```javascript
// Age categories
let age = 25;

if (age < 13) {
    console.log("Child");
} else if (age < 20) {
    console.log("Teenager");
} else if (age < 65) {
    console.log("Adult");
} else {
    console.log("Senior");
}
// Output: "Adult"

// Temperature ranges
let temp = 15;

if (temp > 30) {
    console.log("Hot");
} else if (temp > 20) {
    console.log("Warm");
} else if (temp > 10) {
    console.log("Cool");
} else {
    console.log("Cold");
}
// Output: "Cool"
```

### Important Notes

- Conditions are checked in order
- Only the first true condition executes
- Once a condition is true, remaining conditions are skipped

```javascript
let score = 95;

if (score >= 90) {
    console.log("A");  // This executes
} else if (score >= 80) {
    console.log("B");  // Skipped (already found match)
} else {
    console.log("C");  // Skipped
}
// Output: "A"
```

---

## Nested if Statements

You can nest if statements inside other if statements for complex logic.

### Basic Nested Structure

```javascript
if (condition1) {
    if (condition2) {
        // Code if both conditions are true
    }
}
```

### Example: Login and Permission Check

```javascript
let isLoggedIn = true;
let isAdmin = true;

if (isLoggedIn) {
    console.log("User is logged in");
    
    if (isAdmin) {
        console.log("Admin access granted");
        showAdminPanel();
    } else {
        console.log("Regular user access");
        showUserPanel();
    }
} else {
    console.log("Please log in");
}
```

### Example: Age and License Check

```javascript
let age = 20;
let hasLicense = true;

if (age >= 18) {
    console.log("Age requirement met");
    
    if (hasLicense) {
        console.log("Can drive");
    } else {
        console.log("Need a license");
    }
} else {
    console.log("Too young to drive");
}
```

### Complex Nested Example

```javascript
let user = {
    age: 25,
    hasLicense: true,
    hasInsurance: false
};

if (user.age >= 18) {
    if (user.hasLicense) {
        if (user.hasInsurance) {
            console.log("Can drive legally");
        } else {
            console.log("Need insurance");
        }
    } else {
        console.log("Need a license");
    }
} else {
    console.log("Too young");
}
```

### Best Practices for Nesting

**Avoid Deep Nesting:**
```javascript
// ❌ Too nested (hard to read)
if (condition1) {
    if (condition2) {
        if (condition3) {
            if (condition4) {
                // Code
            }
        }
    }
}

// ✅ Better (use else if or early returns)
if (!condition1) {
    return;
}
if (!condition2) {
    return;
}
if (!condition3) {
    return;
}
// Code here
```

---

## Truthy and Falsy Values

JavaScript uses truthy and falsy values in conditional statements. Understanding these is crucial for writing correct conditions.

### Falsy Values

These values evaluate to `false` in boolean context:

1. `false` - Boolean false
2. `0` - Number zero
3. `-0` - Negative zero
4. `0n` - BigInt zero
5. `""` - Empty string
6. `null` - Null value
7. `undefined` - Undefined value
8. `NaN` - Not a Number

```javascript
if (false) { }      // Falsy
if (0) { }          // Falsy
if (-0) { }         // Falsy
if (0n) { }         // Falsy
if ("") { }         // Falsy
if (null) { }       // Falsy
if (undefined) { }  // Falsy
if (NaN) { }        // Falsy
```

### Truthy Values

Everything else is truthy, including:

```javascript
if (true) { }           // Truthy
if (1) { }              // Truthy
if (-1) { }             // Truthy
if ("hello") { }        // Truthy
if ("0") { }            // Truthy (string)
if ("false") { }        // Truthy (string)
if ([]) { }             // Truthy (empty array)
if ({}) { }             // Truthy (empty object)
if (function() {}) { }  // Truthy
```

### Practical Examples

```javascript
// Check if variable exists
let name = "Alice";

if (name) {  // Truthy if name is not empty string
    console.log(`Hello, ${name}!`);
} else {
    console.log("No name provided");
}

// Check if array has items
let items = [1, 2, 3];

if (items.length) {  // Truthy if length > 0
    console.log("Array has items");
} else {
    console.log("Array is empty");
}

// Check if object property exists
let user = {
    name: "Alice"
};

if (user.name) {  // Truthy if name exists and is not empty
    console.log(user.name);
} else {
    console.log("No name");
}
```

### Common Pitfalls

```javascript
// ⚠️ Empty array is truthy!
let arr = [];
if (arr) {
    console.log("Array exists");  // This runs (array is truthy)
}

// ✅ Check length instead
if (arr.length > 0) {
    console.log("Array has items");
} else {
    console.log("Array is empty");
}

// ⚠️ String "0" is truthy!
let value = "0";
if (value) {
    console.log("Has value");  // This runs
}

// ✅ Explicit check
if (value !== "" && value !== null) {
    console.log("Has value");
}
```

### Explicit Boolean Conversion

```javascript
// Convert to boolean explicitly
let value = "hello";
if (Boolean(value)) { }  // Explicit
if (!!value) { }         // Double negation (common pattern)

// Check for specific values
let name = "";
if (name !== "" && name !== null && name !== undefined) {
    console.log(name);
}

// Or use nullish coalescing
let name2 = "";
let displayName = name2 || "Guest";
```

---

## Switch Statement

The `switch` statement provides an alternative to multiple `else if` statements when comparing one value against multiple options.

### Basic Syntax

```javascript
switch (expression) {
    case value1:
        // Code for value1
        break;
    case value2:
        // Code for value2
        break;
    default:
        // Code if no match
}
```

### Simple Example

```javascript
let day = "Monday";

switch (day) {
    case "Monday":
        console.log("Start of work week");
        break;
    case "Friday":
        console.log("TGIF!");
        break;
    case "Saturday":
    case "Sunday":
        console.log("Weekend!");
        break;
    default:
        console.log("Regular day");
}
// Output: "Start of work week"
```

### Grade System with Switch

```javascript
let grade = "B";

switch (grade) {
    case "A":
        console.log("Excellent!");
        break;
    case "B":
        console.log("Good job!");
        break;
    case "C":
        console.log("Average");
        break;
    case "D":
        console.log("Needs improvement");
        break;
    case "F":
        console.log("Failed");
        break;
    default:
        console.log("Invalid grade");
}
// Output: "Good job!"
```

### The break Statement

**Without break (fall-through):**
```javascript
let day = "Monday";

switch (day) {
    case "Monday":
        console.log("Monday");
        // No break - falls through!
    case "Tuesday":
        console.log("Tuesday");
        break;
}
// Output: "Monday" and "Tuesday"
```

**With break (stops execution):**
```javascript
let day = "Monday";

switch (day) {
    case "Monday":
        console.log("Monday");
        break;  // Stops here
    case "Tuesday":
        console.log("Tuesday");
        break;
}
// Output: "Monday" only
```

### Multiple Cases (Fall-Through)

You can have multiple cases execute the same code:

```javascript
let day = "Saturday";

switch (day) {
    case "Monday":
    case "Tuesday":
    case "Wednesday":
    case "Thursday":
    case "Friday":
        console.log("Weekday");
        break;
    case "Saturday":
    case "Sunday":
        console.log("Weekend");
        break;
    default:
        console.log("Invalid day");
}
// Output: "Weekend"
```

### Switch with Numbers

```javascript
let month = 3;

switch (month) {
    case 1:
        console.log("January");
        break;
    case 2:
        console.log("February");
        break;
    case 3:
        console.log("March");
        break;
    // ... more cases
    default:
        console.log("Invalid month");
}
// Output: "March"
```

### Switch vs if-else

**When to use switch:**
- Comparing one value against multiple options
- Clear, discrete values
- More readable for many conditions

**When to use if-else:**
- Complex conditions (>, <, >=, etc.)
- Multiple variables
- Range checks
- Boolean logic

```javascript
// ✅ Good for switch
let status = "active";
switch (status) {
    case "active":
    case "pending":
    case "inactive":
        // Handle
}

// ✅ Better with if-else
let score = 85;
if (score >= 90) {
    // A
} else if (score >= 80) {
    // B
} else if (score >= 70) {
    // C
}
```

### Default Case

The `default` case executes when no other case matches:

```javascript
let status = "unknown";

switch (status) {
    case "active":
        console.log("Active");
        break;
    case "inactive":
        console.log("Inactive");
        break;
    default:
        console.log("Unknown status");
}
// Output: "Unknown status"
```

---

## Combining Conditions

You can combine multiple conditions using logical operators.

### AND (&&)

```javascript
let age = 25;
let hasLicense = true;

if (age >= 18 && hasLicense) {
    console.log("Can drive");
} else {
    console.log("Cannot drive");
}
```

### OR (||)

```javascript
let isWeekend = false;
let isHoliday = true;

if (isWeekend || isHoliday) {
    console.log("No work today");
} else {
    console.log("Work day");
}
```

### NOT (!)

```javascript
let isLoggedIn = false;

if (!isLoggedIn) {
    console.log("Please log in");
} else {
    console.log("Welcome!");
}
```

### Complex Conditions

```javascript
let age = 25;
let hasLicense = true;
let hasInsurance = true;

if (age >= 18 && hasLicense && hasInsurance) {
    console.log("Can drive legally");
} else if (age >= 18 && hasLicense) {
    console.log("Need insurance");
} else if (age >= 18) {
    console.log("Need license");
} else {
    console.log("Too young");
}
```

---

## Practice Exercise

### Exercise: Building Decision Logic

**Objective**: Create a program that uses conditional statements to make various decisions.

**Instructions**:

1. Create a file called `conditional-practice.js`

2. Create a user profile with:
   - Age
   - Is student (boolean)
   - Has membership (boolean)
   - Score/grade

3. Write conditional logic for:
   - Age category (child, teenager, adult, senior)
   - Discount eligibility (student or member)
   - Grade determination (A, B, C, D, F)
   - Access level (admin, member, guest)
   - Day of week activities (using switch)

4. Use if-else, else if, switch, and nested conditions

**Example Solution**:

```javascript
// Conditional Logic Practice
console.log("=== User Profile ===");
let user = {
    age: 22,
    isStudent: true,
    hasMembership: false,
    score: 85,
    role: "member",
    day: "Saturday"
};

console.log(`Age: ${user.age}`);
console.log(`Student: ${user.isStudent}`);
console.log(`Member: ${user.hasMembership}`);
console.log(`Score: ${user.score}`);
console.log(`Role: ${user.role}`);
console.log(`Day: ${user.day}`);
console.log();

// Age Category
console.log("=== Age Category ===");
if (user.age < 13) {
    console.log("Child");
} else if (user.age < 20) {
    console.log("Teenager");
} else if (user.age < 65) {
    console.log("Adult");
} else {
    console.log("Senior");
}
console.log();

// Discount Eligibility
console.log("=== Discount Eligibility ===");
if (user.isStudent || user.hasMembership) {
    let discount = 0;
    if (user.isStudent && user.hasMembership) {
        discount = 25;  // Both
    } else if (user.isStudent) {
        discount = 15;  // Student only
    } else {
        discount = 10;  // Member only
    }
    console.log(`You qualify for a ${discount}% discount!`);
} else {
    console.log("No discount available");
}
console.log();

// Grade Determination
console.log("=== Grade Determination ===");
if (user.score >= 90) {
    console.log("Grade: A (Excellent)");
} else if (user.score >= 80) {
    console.log("Grade: B (Good)");
} else if (user.score >= 70) {
    console.log("Grade: C (Average)");
} else if (user.score >= 60) {
    console.log("Grade: D (Needs Improvement)");
} else {
    console.log("Grade: F (Failed)");
}
console.log();

// Access Level
console.log("=== Access Level ===");
if (user.role === "admin") {
    console.log("Full admin access");
    console.log("Can manage users");
    console.log("Can modify settings");
} else if (user.role === "member") {
    console.log("Member access");
    console.log("Can view content");
    console.log("Can post comments");
} else {
    console.log("Guest access");
    console.log("Limited content viewing");
}
console.log();

// Day Activities (Switch)
console.log("=== Day Activities ===");
switch (user.day) {
    case "Monday":
        console.log("Start of work week");
        console.log("Team meeting at 10 AM");
        break;
    case "Tuesday":
    case "Wednesday":
    case "Thursday":
        console.log("Regular work day");
        break;
    case "Friday":
        console.log("TGIF! End of work week");
        break;
    case "Saturday":
    case "Sunday":
        console.log("Weekend! Time to relax");
        break;
    default:
        console.log("Invalid day");
}
console.log();

// Complex Nested Condition
console.log("=== Complex Condition ===");
if (user.age >= 18) {
    if (user.isStudent) {
        if (user.score >= 80) {
            console.log("Eligible for scholarship");
        } else {
            console.log("Maintain good grades for scholarship");
        }
    } else {
        console.log("Not a student");
    }
} else {
    console.log("Too young");
}
console.log();

// Truthy/Falsy Examples
console.log("=== Truthy/Falsy Examples ===");
let values = [0, "", null, undefined, false, "hello", 42, [], {}];

values.forEach(value => {
    if (value) {
        console.log(`${JSON.stringify(value)} is truthy`);
    } else {
        console.log(`${JSON.stringify(value)} is falsy`);
    }
});
```

**Expected Output**:
```
=== User Profile ===
Age: 22
Student: true
Member: false
Score: 85
Role: member
Day: Saturday

=== Age Category ===
Adult

=== Discount Eligibility ===
You qualify for a 15% discount!

=== Grade Determination ===
Grade: B (Good)

=== Access Level ===
Member access
Can view content
Can post comments

=== Day Activities ===
Weekend! Time to relax

=== Complex Condition ===
Eligible for scholarship

=== Truthy/Falsy Examples ===
0 is falsy
"" is falsy
null is falsy
undefined is falsy
false is falsy
"hello" is truthy
42 is truthy
[] is truthy
{} is truthy
```

**Challenge (Optional)**:
- Create a weather-based activity planner
- Build a menu system with switch
- Create a permission system with nested conditions
- Add input validation with conditionals

---

## Common Mistakes

### 1. Using = Instead of ===

```javascript
// ❌ Wrong (assignment, not comparison)
if (x = 5) { }

// ✅ Correct
if (x === 5) { }
```

### 2. Missing break in Switch

```javascript
// ❌ Falls through
switch (day) {
    case "Monday":
        console.log("Monday");
        // Missing break!
    case "Tuesday":
        console.log("Tuesday");
}

// ✅ With break
switch (day) {
    case "Monday":
        console.log("Monday");
        break;
    case "Tuesday":
        console.log("Tuesday");
        break;
}
```

### 3. Truthy/Falsy Confusion

```javascript
// ⚠️ Empty array is truthy!
let arr = [];
if (arr) {
    console.log("Has items");  // Wrong! Array is empty
}

// ✅ Check length
if (arr.length > 0) {
    console.log("Has items");
}
```

### 4. Incorrect else if Order

```javascript
// ❌ Wrong order
if (score >= 60) {
    console.log("D");
} else if (score >= 90) {  // Never reached!
    console.log("A");
}

// ✅ Correct order
if (score >= 90) {
    console.log("A");
} else if (score >= 60) {
    console.log("D");
}
```

### 5. Forgetting Default Case

```javascript
// ⚠️ No handling for unexpected values
switch (status) {
    case "active":
        // Handle
    case "inactive":
        // Handle
    // What if status is "pending"?
}

// ✅ With default
switch (status) {
    case "active":
        // Handle
    case "inactive":
        // Handle
    default:
        console.log("Unknown status");
}
```

---

## Key Takeaways

1. **if Statement**: Executes code when condition is true
2. **else Statement**: Provides alternative when condition is false
3. **else if**: Checks multiple conditions in sequence
4. **Nested if**: if statements inside other if statements
5. **Switch**: Alternative to multiple else if for discrete values
6. **Truthy/Falsy**: Understand which values evaluate to true/false
7. **break**: Essential in switch to prevent fall-through
8. **Best Practice**: Use switch for discrete values, if-else for ranges

---

## Quiz: Conditionals

Test your understanding with these questions:

1. **What is the output of: `if (0) { console.log("Yes"); } else { console.log("No"); }`?**
   - A) "Yes"
   - B) "No"
   - C) Error
   - D) Nothing

2. **What happens if you forget `break` in a switch case?**
   - A) Error
   - B) Code stops executing
   - C) Code falls through to next case
   - D) Nothing

3. **Which is falsy in JavaScript?**
   - A) "0"
   - B) []
   - C) {}
   - D) ""

4. **How many `else if` statements can you have?**
   - A) 1
   - B) 2
   - C) Unlimited
   - D) 10

5. **What is the purpose of the `default` case in switch?**
   - A) Required syntax
   - B) Handles unmatched values
   - C) Always executes
   - D) Error handling

6. **Which evaluates to true?**
   - A) `if (0)`
   - B) `if ("")`
   - C) `if ([])`
   - D) `if (null)`

7. **When should you use switch instead of if-else?**
   - A) Always
   - B) For range checks
   - C) For discrete value comparisons
   - D) Never

**Answers**:
1. B) "No" (0 is falsy)
2. C) Code falls through to next case
3. D) "" (empty string is falsy)
4. C) Unlimited
5. B) Handles unmatched values
6. C) `if ([])` (empty array is truthy)
7. C) For discrete value comparisons

---

## Next Steps

Congratulations! You've learned conditional statements. You now know:
- How to use if, else, and else if
- How to use switch statements
- Understanding of truthy and falsy values
- How to write nested conditions

**What's Next?**
- Lesson 3.2: Loops
- Practice building more complex conditional logic
- Experiment with switch statements
- Combine conditions with logical operators

---

## Additional Resources

- **MDN: if...else**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/if...else](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/if...else)
- **MDN: switch**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/switch](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/switch)
- **JavaScript.info: Conditional Branching**: [javascript.info/ifelse](https://javascript.info/ifelse)
- **JavaScript.info: Switch**: [javascript.info/switch](https://javascript.info/switch)

---

*Lesson completed! You're ready to move on to the next lesson.*

