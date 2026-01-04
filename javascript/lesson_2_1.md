# Lesson 2.1: Arithmetic Operators

## Learning Objectives

By the end of this lesson, you will be able to:
- Use all basic arithmetic operators (+, -, *, /)
- Understand and use the modulo operator (%)
- Work with exponentiation (**)
- Apply increment and decrement operators (++, --)
- Understand operator precedence and associativity
- Build a simple calculator program

---

## Introduction to Arithmetic Operators

Arithmetic operators perform mathematical operations on numbers (and sometimes strings). They are fundamental to any programming language and are used extensively in JavaScript.

### Basic Arithmetic Operators

JavaScript provides five basic arithmetic operators:

| Operator | Name | Example | Result |
|----------|------|---------|--------|
| `+` | Addition | `5 + 3` | `8` |
| `-` | Subtraction | `5 - 3` | `2` |
| `*` | Multiplication | `5 * 3` | `15` |
| `/` | Division | `5 / 3` | `1.666...` |
| `%` | Modulo (Remainder) | `5 % 3` | `2` |
| `**` | Exponentiation | `5 ** 3` | `125` |

---

## Addition (+)

The addition operator adds two numbers together.

### Basic Addition

```javascript
let sum = 5 + 3;
console.log(sum);  // 8

let a = 10;
let b = 20;
let result = a + b;
console.log(result);  // 30
```

### String Concatenation

When used with strings, `+` performs concatenation (joining strings):

```javascript
let firstName = "Alice";
let lastName = "Smith";
let fullName = firstName + " " + lastName;
console.log(fullName);  // "Alice Smith"

let greeting = "Hello, " + "World!";
console.log(greeting);  // "Hello, World!"
```

### Mixed Types

When mixing numbers and strings, JavaScript converts numbers to strings:

```javascript
console.log("5" + 3);      // "53" (string concatenation)
console.log(5 + "3");     // "53" (string concatenation)
console.log("Result: " + 10);  // "Result: 10"
```

**To force numeric addition:**
```javascript
console.log(Number("5") + 3);  // 8
console.log(+"5" + 3);          // 8 (unary plus)
```

### Multiple Additions

```javascript
let total = 10 + 20 + 30;
console.log(total);  // 60

let a = 5;
let b = 10;
let c = 15;
let sum = a + b + c;
console.log(sum);  // 30
```

---

## Subtraction (-)

The subtraction operator subtracts the right operand from the left operand.

### Basic Subtraction

```javascript
let difference = 10 - 3;
console.log(difference);  // 7

let a = 50;
let b = 20;
let result = a - b;
console.log(result);  // 30
```

### Negative Numbers

```javascript
let result = 5 - 10;
console.log(result);  // -5

let negative = -5;
let positive = 10;
let sum = negative + positive;
console.log(sum);  // 5
```

### Unary Minus

The minus operator can also be used as a unary operator to negate a value:

```javascript
let x = 5;
let y = -x;
console.log(y);  // -5

let positive = 10;
let negative = -positive;
console.log(negative);  // -10
```

### Multiple Subtractions

```javascript
let result = 100 - 20 - 10;
console.log(result);  // 70

// Order matters
let a = 100;
let b = 20;
let c = 10;
let difference = a - b - c;  // (100 - 20) - 10 = 70
console.log(difference);
```

---

## Multiplication (*)

The multiplication operator multiplies two numbers.

### Basic Multiplication

```javascript
let product = 5 * 3;
console.log(product);  // 15

let a = 10;
let b = 4;
let result = a * b;
console.log(result);  // 40
```

### Decimal Numbers

```javascript
let result = 3.5 * 2;
console.log(result);  // 7

let price = 9.99;
let quantity = 3;
let total = price * quantity;
console.log(total);  // 29.97
```

### Multiple Multiplications

```javascript
let result = 2 * 3 * 4;
console.log(result);  // 24

let a = 5;
let b = 2;
let c = 3;
let product = a * b * c;
console.log(product);  // 30
```

### Common Use Cases

```javascript
// Calculate area
let width = 10;
let height = 5;
let area = width * height;
console.log(area);  // 50

// Calculate total price
let unitPrice = 15.50;
let quantity = 4;
let totalPrice = unitPrice * quantity;
console.log(totalPrice);  // 62
```

---

## Division (/)

The division operator divides the left operand by the right operand.

### Basic Division

```javascript
let quotient = 10 / 2;
console.log(quotient);  // 5

let a = 20;
let b = 4;
let result = a / b;
console.log(result);  // 5
```

### Decimal Results

```javascript
let result = 10 / 3;
console.log(result);  // 3.3333333333333335

let a = 7;
let b = 2;
let quotient = a / b;
console.log(quotient);  // 3.5
```

### Division by Zero

```javascript
console.log(10 / 0);   // Infinity
console.log(-10 / 0);  // -Infinity
console.log(0 / 0);    // NaN (Not a Number)
```

### Integer Division

JavaScript doesn't have integer division. To get integer results:

```javascript
// Using Math.floor()
let result = Math.floor(10 / 3);
console.log(result);  // 3

// Using parseInt()
let result2 = parseInt(10 / 3);
console.log(result2);  // 3

// Using bitwise operator (for positive numbers only)
let result3 = (10 / 3) | 0;
console.log(result3);  // 3
```

### Common Use Cases

```javascript
// Calculate average
let sum = 85 + 90 + 78;
let count = 3;
let average = sum / count;
console.log(average);  // 84.333...

// Calculate percentage
let part = 25;
let whole = 100;
let percentage = (part / whole) * 100;
console.log(percentage);  // 25
```

---

## Modulo Operator (%)

The modulo operator returns the remainder of a division operation.

### Basic Modulo

```javascript
let remainder = 10 % 3;
console.log(remainder);  // 1 (10 divided by 3 is 3 with remainder 1)

let result = 15 % 4;
console.log(result);  // 3 (15 divided by 4 is 3 with remainder 3)
```

### Understanding Modulo

```javascript
// 10 % 3 = 1
// Because: 10 = 3 * 3 + 1

// 15 % 4 = 3
// Because: 15 = 4 * 3 + 3

// 20 % 5 = 0
// Because: 20 = 5 * 4 + 0 (no remainder)
```

### Common Use Cases

**1. Check if a number is even or odd:**
```javascript
let number = 7;
if (number % 2 === 0) {
    console.log("Even");
} else {
    console.log("Odd");  // This runs
}

let num = 8;
console.log(num % 2 === 0);  // true (even)
```

**2. Check divisibility:**
```javascript
let number = 15;
if (number % 5 === 0) {
    console.log("Divisible by 5");  // This runs
}

let num = 12;
console.log(num % 3 === 0);  // true (divisible by 3)
```

**3. Get the last digit:**
```javascript
let number = 12345;
let lastDigit = number % 10;
console.log(lastDigit);  // 5
```

**4. Cycle through values:**
```javascript
// Cycle 0, 1, 2, 0, 1, 2...
for (let i = 0; i < 10; i++) {
    console.log(i % 3);  // 0, 1, 2, 0, 1, 2, 0, 1, 2, 0
}
```

**5. Wrap around values:**
```javascript
// Keep value between 0 and 9
let value = 15;
let wrapped = value % 10;
console.log(wrapped);  // 5
```

### Negative Modulo

```javascript
console.log(-10 % 3);   // -1
console.log(10 % -3);   // 1
console.log(-10 % -3);  // -1
```

---

## Exponentiation (**)

The exponentiation operator raises the left operand to the power of the right operand.

### Basic Exponentiation

```javascript
let result = 2 ** 3;
console.log(result);  // 8 (2 to the power of 3 = 2 * 2 * 2)

let power = 5 ** 2;
console.log(power);  // 25 (5 squared)
```

### Understanding Exponentiation

```javascript
// 2 ** 3 = 2 * 2 * 2 = 8
// 3 ** 2 = 3 * 3 = 9
// 4 ** 3 = 4 * 4 * 4 = 64
// 10 ** 2 = 10 * 10 = 100
```

### Common Use Cases

**1. Calculate squares:**
```javascript
let number = 5;
let square = number ** 2;
console.log(square);  // 25
```

**2. Calculate cubes:**
```javascript
let number = 3;
let cube = number ** 3;
console.log(cube);  // 27
```

**3. Calculate powers:**
```javascript
let base = 2;
let exponent = 10;
let result = base ** exponent;
console.log(result);  // 1024
```

**4. Square root (using fractional exponent):**
```javascript
let number = 16;
let squareRoot = number ** 0.5;
console.log(squareRoot);  // 4

// Or use Math.sqrt()
let sqrt = Math.sqrt(16);
console.log(sqrt);  // 4
```

**5. Cube root:**
```javascript
let number = 27;
let cubeRoot = number ** (1/3);
console.log(cubeRoot);  // 3
```

### Alternative: Math.pow()

Before ES2016, you had to use `Math.pow()`:

```javascript
// Old way
let result = Math.pow(2, 3);  // 8

// Modern way
let result2 = 2 ** 3;  // 8
```

---

## Increment and Decrement Operators

These operators increase or decrease a value by 1.

### Increment Operator (++)

**Post-increment** (returns value, then increments):
```javascript
let x = 5;
let y = x++;  // y = 5, x = 6
console.log(x);  // 6
console.log(y);  // 5
```

**Pre-increment** (increments, then returns value):
```javascript
let x = 5;
let y = ++x;  // x = 6, y = 6
console.log(x);  // 6
console.log(y);  // 6
```

### Decrement Operator (--)

**Post-decrement** (returns value, then decrements):
```javascript
let x = 5;
let y = x--;  // y = 5, x = 4
console.log(x);  // 4
console.log(y);  // 5
```

**Pre-decrement** (decrements, then returns value):
```javascript
let x = 5;
let y = --x;  // x = 4, y = 4
console.log(x);  // 4
console.log(y);  // 4
```

### Common Use Cases

**In loops:**
```javascript
for (let i = 0; i < 5; i++) {
    console.log(i);  // 0, 1, 2, 3, 4
}

// Equivalent to:
for (let i = 0; i < 5; i = i + 1) {
    console.log(i);
}
```

**Counter:**
```javascript
let count = 0;
count++;  // count is now 1
count++;  // count is now 2
console.log(count);  // 2
```

**Array indexing:**
```javascript
let index = 0;
let arr = [10, 20, 30];
console.log(arr[index++]);  // 10, index is now 1
console.log(arr[index++]);  // 20, index is now 2
```

### Important Notes

```javascript
// Be careful with post vs pre
let x = 5;
console.log(x++);  // 5 (prints, then increments)
console.log(x);    // 6

let y = 5;
console.log(++y);  // 6 (increments, then prints)
console.log(y);    // 6
```

---

## Operator Precedence

Operator precedence determines the order in which operations are performed when multiple operators are present.

### Precedence Order (Highest to Lowest)

1. **Parentheses** `()` - Highest precedence
2. **Exponentiation** `**`
3. **Multiplication, Division, Modulo** `*`, `/`, `%`
4. **Addition, Subtraction** `+`, `-`
5. **Assignment** `=`

### Examples

```javascript
// Without parentheses
let result = 2 + 3 * 4;
console.log(result);  // 14 (not 20!)
// Because: 2 + (3 * 4) = 2 + 12 = 14

// With parentheses
let result2 = (2 + 3) * 4;
console.log(result2);  // 20
// Because: (2 + 3) * 4 = 5 * 4 = 20
```

### More Examples

```javascript
// Exponentiation first
let a = 2 ** 3 + 1;
console.log(a);  // 9 (8 + 1, not 16!)

// Multiplication before addition
let b = 10 + 5 * 2;
console.log(b);  // 20 (10 + 10, not 30!)

// Modulo same as multiplication/division
let c = 10 + 15 % 4;
console.log(c);  // 13 (10 + 3)

// Complex expression
let d = 2 + 3 * 4 ** 2;
console.log(d);  // 50
// Step 1: 4 ** 2 = 16
// Step 2: 3 * 16 = 48
// Step 3: 2 + 48 = 50
```

### Using Parentheses

Parentheses override precedence and make code clearer:

```javascript
// Clear intent
let result = (2 + 3) * (4 + 5);
console.log(result);  // 45

// Complex calculation
let total = (10 + 5) * 2 - 3;
console.log(total);  // 27
// Step 1: (10 + 5) = 15
// Step 2: 15 * 2 = 30
// Step 3: 30 - 3 = 27
```

### Associativity

When operators have the same precedence, associativity determines the order:

```javascript
// Left-to-right for +, -, *, /
let result = 10 - 5 - 2;
console.log(result);  // 3
// Evaluated as: (10 - 5) - 2 = 5 - 2 = 3

// Right-to-left for **
let power = 2 ** 3 ** 2;
console.log(power);  // 512
// Evaluated as: 2 ** (3 ** 2) = 2 ** 9 = 512
```

---

## Combining Operators

You can combine multiple operators in expressions:

```javascript
// Simple combination
let result = 10 + 5 * 2;
console.log(result);  // 20

// Complex expression
let total = (100 - 20) / 2 + 10;
console.log(total);  // 50

// With variables
let a = 10;
let b = 5;
let c = 2;
let result2 = a + b * c;
console.log(result2);  // 20
```

### Best Practices

**1. Use parentheses for clarity:**
```javascript
// Unclear
let result = a + b * c / d;

// Clear
let result = a + (b * c / d);
```

**2. Break complex expressions:**
```javascript
// Hard to read
let result = (a + b) * (c - d) / (e + f) ** 2;

// Better
let sum1 = a + b;
let diff = c - d;
let sum2 = e + f;
let result = (sum1 * diff) / (sum2 ** 2);
```

---

## Practice Exercise

### Exercise: Calculator Program

**Objective**: Build a simple calculator program that performs basic arithmetic operations.

**Instructions**:

1. Create a file called `calculator.js`

2. Define variables for two numbers:
   ```javascript
   let num1 = 10;
   let num2 = 3;
   ```

3. Perform and display the following operations:
   - Addition
   - Subtraction
   - Multiplication
   - Division
   - Modulo
   - Exponentiation

4. Calculate and display:
   - The average of the two numbers
   - The square of num1
   - The cube of num2
   - Whether num1 is even or odd (using modulo)

5. Use proper formatting and clear output messages

**Example Solution**:

```javascript
// Simple Calculator Program
let num1 = 10;
let num2 = 3;

console.log("=== Simple Calculator ===");
console.log(`Number 1: ${num1}`);
console.log(`Number 2: ${num2}`);
console.log();

// Basic Operations
console.log("=== Basic Operations ===");
console.log(`${num1} + ${num2} = ${num1 + num2}`);
console.log(`${num1} - ${num2} = ${num1 - num2}`);
console.log(`${num1} * ${num2} = ${num1 * num2}`);
console.log(`${num1} / ${num2} = ${num1 / num2}`);
console.log(`${num1} % ${num2} = ${num1 % num2}`);
console.log(`${num1} ** ${num2} = ${num1 ** num2}`);
console.log();

// Advanced Calculations
console.log("=== Advanced Calculations ===");
let average = (num1 + num2) / 2;
console.log(`Average: ${average}`);

let square1 = num1 ** 2;
console.log(`${num1} squared: ${square1}`);

let cube2 = num2 ** 3;
console.log(`${num2} cubed: ${cube2}`);

// Check if even or odd
if (num1 % 2 === 0) {
    console.log(`${num1} is even`);
} else {
    console.log(`${num1} is odd`);
}

if (num2 % 2 === 0) {
    console.log(`${num2} is even`);
} else {
    console.log(`${num2} is odd`);
}
console.log();

// Operator Precedence Examples
console.log("=== Operator Precedence ===");
let result1 = 2 + 3 * 4;
console.log(`2 + 3 * 4 = ${result1} (not 20!)`);

let result2 = (2 + 3) * 4;
console.log(`(2 + 3) * 4 = ${result2}`);

let result3 = 2 ** 3 + 1;
console.log(`2 ** 3 + 1 = ${result3} (not 16!)`);
```

**Expected Output**:
```
=== Simple Calculator ===
Number 1: 10
Number 2: 3

=== Basic Operations ===
10 + 3 = 13
10 - 3 = 7
10 * 3 = 30
10 / 3 = 3.3333333333333335
10 % 3 = 1
10 ** 3 = 1000

=== Advanced Calculations ===
Average: 6.5
10 squared: 100
3 cubed: 27
10 is even
3 is odd

=== Operator Precedence ===
2 + 3 * 4 = 14 (not 20!)
(2 + 3) * 4 = 20
2 ** 3 + 1 = 9 (not 16!)
```

**Challenge (Optional)**:
- Add more operations (square root, percentage)
- Create functions for each operation
- Handle edge cases (division by zero)
- Add input validation
- Create an interactive calculator using prompt()

---

## Common Mistakes

### 1. Forgetting Operator Precedence

```javascript
// ❌ Wrong expectation
let result = 2 + 3 * 4;  // Expects 20, gets 14

// ✅ Correct
let result = (2 + 3) * 4;  // Gets 20
```

### 2. String Concatenation Instead of Addition

```javascript
// ❌ String concatenation
let result = "5" + 3;  // "53"

// ✅ Numeric addition
let result = Number("5") + 3;  // 8
```

### 3. Confusing Post vs Pre Increment

```javascript
// ❌ Wrong expectation
let x = 5;
let y = x++;  // Expects y = 6, gets y = 5

// ✅ Correct
let x = 5;
let y = ++x;  // Gets y = 6
```

### 4. Division by Zero

```javascript
// ⚠️ Be careful
let result = 10 / 0;  // Infinity (not an error!)
```

### 5. Modulo with Negative Numbers

```javascript
// Remember: result sign matches dividend
console.log(-10 % 3);  // -1 (not 2!)
```

---

## Key Takeaways

1. **Arithmetic Operators**: `+`, `-`, `*`, `/`, `%`, `**`
2. **Addition**: Can concatenate strings or add numbers
3. **Modulo**: Returns remainder, useful for checking even/odd, divisibility
4. **Exponentiation**: `**` raises to power (ES2016+)
5. **Increment/Decrement**: `++` and `--` change value by 1
6. **Precedence**: Parentheses > Exponentiation > * / % > + -
7. **Use Parentheses**: Make complex expressions clear and correct

---

## Quiz: Arithmetic Operations

Test your understanding with these questions:

1. **What is the result of `10 % 3`?**
   - A) 3
   - B) 1
   - C) 0
   - D) 3.33

2. **What is the result of `2 ** 3`?**
   - A) 6
   - B) 8
   - C) 9
   - D) 5

3. **What is the result of `2 + 3 * 4`?**
   - A) 20
   - B) 14
   - C) 24
   - D) 12

4. **What is the result of `"5" + 3`?**
   - A) 8
   - B) "8"
   - C) "53"
   - D) Error

5. **What is the result of `let x = 5; let y = x++;` (y = ?)**
   - A) 5
   - B) 6
   - C) 4
   - D) undefined

6. **What is the result of `10 / 0`?**
   - A) 0
   - B) Error
   - C) Infinity
   - D) NaN

7. **Which operator has the highest precedence?**
   - A) +
   - B) *
   - C) **
   - D) ()

**Answers**:
1. B) 1
2. B) 8
3. B) 14 (multiplication before addition)
4. C) "53" (string concatenation)
5. A) 5 (post-increment returns value first)
6. C) Infinity
7. D) () (parentheses have highest precedence)

---

## Next Steps

Congratulations! You've learned arithmetic operators. You now know:
- How to perform basic arithmetic operations
- How to use modulo and exponentiation
- How increment and decrement work
- How operator precedence affects calculations

**What's Next?**
- Lesson 2.2: Comparison and Logical Operators
- Practice building more complex calculations
- Experiment with operator precedence
- Try building a more advanced calculator

---

## Additional Resources

- **MDN: Arithmetic Operators**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Expressions_and_Operators#arithmetic_operators](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Expressions_and_Operators#arithmetic_operators)
- **MDN: Operator Precedence**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Operator_Precedence](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Operator_Precedence)
- **JavaScript.info: Operators**: [javascript.info/operators](https://javascript.info/operators)

---

*Lesson completed! You're ready to move on to the next lesson.*

