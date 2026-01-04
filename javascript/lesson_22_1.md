# Lesson 22.1: Testing Basics

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand why testing is important
- Know different types of testing
- Understand test-driven development (TDD)
- Write basic tests
- Structure test files
- Run tests
- Build confidence in your code

---

## Introduction to Testing

Testing is the process of verifying that code works as expected. It's essential for building reliable applications.

### Why Test?

- **Confidence**: Know your code works
- **Documentation**: Tests document how code should work
- **Refactoring**: Safe to change code with tests
- **Bug Prevention**: Catch bugs early
- **Quality**: Ensures code quality
- **Professional**: Industry standard practice

### Benefits of Testing

```javascript
// Without tests: Unsure if code works
function add(a, b) {
    return a + b;
}
// Does it work? Maybe?

// With tests: Confident code works
function add(a, b) {
    return a + b;
}
// Test: add(2, 3) === 5 ✓
```

---

## Types of Testing

### Unit Testing

Tests individual units (functions, classes) in isolation.

```javascript
// Unit test example
function multiply(a, b) {
    return a * b;
}

// Test
test('multiply should return product', () => {
    expect(multiply(2, 3)).toBe(6);
    expect(multiply(0, 5)).toBe(0);
    expect(multiply(-1, 5)).toBe(-5);
});
```

### Integration Testing

Tests how multiple units work together.

```javascript
// Integration test example
class UserService {
    constructor(userRepository) {
        this.userRepository = userRepository;
    }
    
    async createUser(userData) {
        // Validate
        if (!userData.email) {
            throw new Error('Email required');
        }
        // Save
        return await this.userRepository.save(userData);
    }
}

// Test: UserService + UserRepository work together
test('createUser should save user', async () => {
    let userRepository = new UserRepository();
    let userService = new UserService(userRepository);
    
    let user = await userService.createUser({
        email: 'test@example.com',
        name: 'Test User'
    });
    
    expect(user.email).toBe('test@example.com');
});
```

### End-to-End (E2E) Testing

Tests the entire application from user's perspective.

```javascript
// E2E test example (conceptual)
test('user can login and view dashboard', async () => {
    // 1. Open browser
    await page.goto('http://localhost:3000');
    
    // 2. Login
    await page.fill('#email', 'user@example.com');
    await page.fill('#password', 'password');
    await page.click('#login-button');
    
    // 3. Verify dashboard
    await expect(page.locator('#dashboard')).toBeVisible();
});
```

### Test Pyramid

```
        /\
       /E2E\        Few, slow, expensive
      /------\
     /Integration\  Some, medium speed
    /------------\
   /   Unit Tests  \  Many, fast, cheap
  /----------------\
```

- **Many Unit Tests**: Fast, test individual functions
- **Some Integration Tests**: Test components together
- **Few E2E Tests**: Test critical user flows

---

## Test-Driven Development (TDD)

### What is TDD?

TDD is a development approach where you write tests before writing code.

### TDD Cycle

```
1. Red: Write failing test
2. Green: Write minimal code to pass
3. Refactor: Improve code while keeping tests green
```

### TDD Example

```javascript
// Step 1: Red - Write failing test
test('calculateTotal should sum prices', () => {
    let items = [
        { price: 10 },
        { price: 20 },
        { price: 30 }
    ];
    expect(calculateTotal(items)).toBe(60);
});
// Test fails: calculateTotal is not defined

// Step 2: Green - Write minimal code
function calculateTotal(items) {
    return 60;  // Hardcoded to pass test
}
// Test passes

// Step 3: Refactor - Write real implementation
function calculateTotal(items) {
    return items.reduce((sum, item) => sum + item.price, 0);
}
// Test still passes, code is correct
```

### Benefits of TDD

- **Better Design**: Forces you to think about interface first
- **Confidence**: Know code works from start
- **Documentation**: Tests document expected behavior
- **Refactoring**: Safe to refactor with tests

---

## Writing Basic Tests

### Test Structure

```javascript
// Basic test structure
test('test description', () => {
    // Arrange: Set up test data
    let input = 5;
    
    // Act: Execute code being tested
    let result = double(input);
    
    // Assert: Verify result
    expect(result).toBe(10);
});
```

### Arrange-Act-Assert Pattern

```javascript
// Arrange: Set up
let numbers = [1, 2, 3, 4, 5];

// Act: Execute
let sum = numbers.reduce((a, b) => a + b, 0);

// Assert: Verify
expect(sum).toBe(15);
```

### Test Cases

```javascript
// Test different cases
test('add handles positive numbers', () => {
    expect(add(2, 3)).toBe(5);
});

test('add handles zero', () => {
    expect(add(5, 0)).toBe(5);
});

test('add handles negative numbers', () => {
    expect(add(-2, 3)).toBe(1);
});

test('add handles decimals', () => {
    expect(add(1.5, 2.5)).toBe(4);
});
```

### Edge Cases

```javascript
// Test edge cases
test('divide handles division by zero', () => {
    expect(() => divide(10, 0)).toThrow('Division by zero');
});

test('findUser handles empty array', () => {
    expect(findUser([], 1)).toBeNull();
});

test('validateEmail handles null', () => {
    expect(validateEmail(null)).toBe(false);
});
```

---

## Test Organization

### Test Files

```javascript
// math.test.js
// Tests for math.js

import { add, subtract, multiply, divide } from './math.js';

describe('Math functions', () => {
    test('add should sum numbers', () => {
        expect(add(2, 3)).toBe(5);
    });
    
    test('subtract should subtract numbers', () => {
        expect(subtract(5, 3)).toBe(2);
    });
    
    test('multiply should multiply numbers', () => {
        expect(multiply(2, 3)).toBe(6);
    });
    
    test('divide should divide numbers', () => {
        expect(divide(10, 2)).toBe(5);
    });
});
```

### Test Suites

```javascript
// Group related tests
describe('UserService', () => {
    describe('createUser', () => {
        test('should create user with valid data', () => {
            // Test
        });
        
        test('should throw error with invalid email', () => {
            // Test
        });
    });
    
    describe('getUser', () => {
        test('should return user by id', () => {
            // Test
        });
        
        test('should return null if not found', () => {
            // Test
        });
    });
});
```

---

## Practice Exercise

### Exercise: Writing Basic Tests

**Objective**: Practice writing basic tests, understanding test structure, and TDD.

**Instructions**:

1. Create a JavaScript file with functions to test
2. Create a test file
3. Practice:
   - Writing unit tests
   - Testing different cases
   - Testing edge cases
   - Using TDD approach

**Example Solution**:

```javascript
// calculator.js
function add(a, b) {
    return a + b;
}

function subtract(a, b) {
    return a - b;
}

function multiply(a, b) {
    return a * b;
}

function divide(a, b) {
    if (b === 0) {
        throw new Error('Division by zero');
    }
    return a / b;
}

function calculateTotal(items) {
    return items.reduce((sum, item) => sum + item.price, 0);
}

function validateEmail(email) {
    if (!email) return false;
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function findUser(users, id) {
    return users.find(user => user.id === id) || null;
}

module.exports = {
    add,
    subtract,
    multiply,
    divide,
    calculateTotal,
    validateEmail,
    findUser
};
```

```javascript
// calculator.test.js
const {
    add,
    subtract,
    multiply,
    divide,
    calculateTotal,
    validateEmail,
    findUser
} = require('./calculator');

console.log("=== Testing Basics Practice ===");

console.log("\n=== Basic Tests ===");

// Test add
function testAdd() {
    console.log('Testing add...');
    
    // Positive numbers
    if (add(2, 3) !== 5) {
        console.error('FAIL: add(2, 3) should be 5');
        return false;
    }
    
    // Zero
    if (add(5, 0) !== 5) {
        console.error('FAIL: add(5, 0) should be 5');
        return false;
    }
    
    // Negative numbers
    if (add(-2, 3) !== 1) {
        console.error('FAIL: add(-2, 3) should be 1');
        return false;
    }
    
    // Decimals
    if (add(1.5, 2.5) !== 4) {
        console.error('FAIL: add(1.5, 2.5) should be 4');
        return false;
    }
    
    console.log('✓ add tests passed');
    return true;
}

// Test subtract
function testSubtract() {
    console.log('Testing subtract...');
    
    if (subtract(5, 3) !== 2) {
        console.error('FAIL: subtract(5, 3) should be 2');
        return false;
    }
    
    if (subtract(0, 5) !== -5) {
        console.error('FAIL: subtract(0, 5) should be -5');
        return false;
    }
    
    console.log('✓ subtract tests passed');
    return true;
}

// Test multiply
function testMultiply() {
    console.log('Testing multiply...');
    
    if (multiply(2, 3) !== 6) {
        console.error('FAIL: multiply(2, 3) should be 6');
        return false;
    }
    
    if (multiply(0, 5) !== 0) {
        console.error('FAIL: multiply(0, 5) should be 0');
        return false;
    }
    
    if (multiply(-2, 3) !== -6) {
        console.error('FAIL: multiply(-2, 3) should be -6');
        return false;
    }
    
    console.log('✓ multiply tests passed');
    return true;
}

// Test divide
function testDivide() {
    console.log('Testing divide...');
    
    if (divide(10, 2) !== 5) {
        console.error('FAIL: divide(10, 2) should be 5');
        return false;
    }
    
    // Test division by zero
    try {
        divide(10, 0);
        console.error('FAIL: divide(10, 0) should throw error');
        return false;
    } catch (error) {
        if (error.message !== 'Division by zero') {
            console.error('FAIL: Error message should be "Division by zero"');
            return false;
        }
    }
    
    console.log('✓ divide tests passed');
    return true;
}

console.log();

console.log("=== Edge Cases ===");

// Test calculateTotal
function testCalculateTotal() {
    console.log('Testing calculateTotal...');
    
    // Normal case
    let items1 = [
        { price: 10 },
        { price: 20 },
        { price: 30 }
    ];
    if (calculateTotal(items1) !== 60) {
        console.error('FAIL: calculateTotal should be 60');
        return false;
    }
    
    // Empty array
    if (calculateTotal([]) !== 0) {
        console.error('FAIL: calculateTotal([]) should be 0');
        return false;
    }
    
    // Single item
    if (calculateTotal([{ price: 5 }]) !== 5) {
        console.error('FAIL: calculateTotal with single item should be 5');
        return false;
    }
    
    console.log('✓ calculateTotal tests passed');
    return true;
}

// Test validateEmail
function testValidateEmail() {
    console.log('Testing validateEmail...');
    
    // Valid emails
    if (!validateEmail('test@example.com')) {
        console.error('FAIL: "test@example.com" should be valid');
        return false;
    }
    
    if (!validateEmail('user.name@example.co.uk')) {
        console.error('FAIL: "user.name@example.co.uk" should be valid');
        return false;
    }
    
    // Invalid emails
    if (validateEmail('invalid')) {
        console.error('FAIL: "invalid" should be invalid');
        return false;
    }
    
    if (validateEmail('invalid@')) {
        console.error('FAIL: "invalid@" should be invalid');
        return false;
    }
    
    if (validateEmail('@example.com')) {
        console.error('FAIL: "@example.com" should be invalid');
        return false;
    }
    
    // Edge cases
    if (validateEmail(null)) {
        console.error('FAIL: null should be invalid');
        return false;
    }
    
    if (validateEmail('')) {
        console.error('FAIL: empty string should be invalid');
        return false;
    }
    
    console.log('✓ validateEmail tests passed');
    return true;
}

// Test findUser
function testFindUser() {
    console.log('Testing findUser...');
    
    let users = [
        { id: 1, name: 'Alice' },
        { id: 2, name: 'Bob' },
        { id: 3, name: 'Charlie' }
    ];
    
    // Found
    let user = findUser(users, 2);
    if (!user || user.name !== 'Bob') {
        console.error('FAIL: findUser should find user with id 2');
        return false;
    }
    
    // Not found
    if (findUser(users, 99) !== null) {
        console.error('FAIL: findUser should return null for non-existent id');
        return false;
    }
    
    // Empty array
    if (findUser([], 1) !== null) {
        console.error('FAIL: findUser should return null for empty array');
        return false;
    }
    
    console.log('✓ findUser tests passed');
    return true;
}

console.log();

console.log("=== TDD Example ===");

// TDD: Test first, then implement
function testReverseString() {
    console.log('Testing reverseString (TDD example)...');
    
    // Step 1: Red - Write failing test
    // We expect reverseString to exist and work
    try {
        if (reverseString('hello') !== 'olleh') {
            console.error('FAIL: reverseString("hello") should be "olleh"');
            return false;
        }
    } catch (error) {
        console.log('Function not implemented yet (expected in TDD)');
        return false;
    }
    
    console.log('✓ reverseString test passed');
    return true;
}

// Step 2: Green - Implement function
function reverseString(str) {
    return str.split('').reverse().join('');
}

// Step 3: Refactor - Already good, but could optimize
// Current implementation is fine

console.log();

console.log("=== Running All Tests ===");

let allTestsPassed = true;

allTestsPassed = testAdd() && allTestsPassed;
allTestsPassed = testSubtract() && allTestsPassed;
allTestsPassed = testMultiply() && allTestsPassed;
allTestsPassed = testDivide() && allTestsPassed;
allTestsPassed = testCalculateTotal() && allTestsPassed;
allTestsPassed = testValidateEmail() && allTestsPassed;
allTestsPassed = testFindUser() && allTestsPassed;
allTestsPassed = testReverseString() && allTestsPassed;

console.log();
if (allTestsPassed) {
    console.log('✓ All tests passed!');
} else {
    console.log('✗ Some tests failed');
}
```

**Expected Output**:
```
=== Testing Basics Practice ===

=== Basic Tests ===
Testing add...
✓ add tests passed
Testing subtract...
✓ subtract tests passed
Testing multiply...
✓ multiply tests passed
Testing divide...
✓ divide tests passed

=== Edge Cases ===
Testing calculateTotal...
✓ calculateTotal tests passed
Testing validateEmail...
✓ validateEmail tests passed
Testing findUser...
✓ findUser tests passed

=== TDD Example ===
Testing reverseString (TDD example)...
✓ reverseString test passed

=== Running All Tests ===
✓ All tests passed!
```

**Challenge (Optional)**:
- Write tests for your own functions
- Practice TDD on a new feature
- Write tests for edge cases
- Build a test suite

---

## Common Mistakes

### 1. Not Testing Edge Cases

```javascript
// ❌ Bad: Only test happy path
test('add works', () => {
    expect(add(2, 3)).toBe(5);
});

// ✅ Good: Test edge cases
test('add works with positive numbers', () => {
    expect(add(2, 3)).toBe(5);
});

test('add works with zero', () => {
    expect(add(5, 0)).toBe(5);
});

test('add works with negative numbers', () => {
    expect(add(-2, 3)).toBe(1);
});
```

### 2. Testing Implementation Details

```javascript
// ❌ Bad: Test implementation
test('should use reduce', () => {
    // Test checks if reduce is used
});

// ✅ Good: Test behavior
test('should calculate total', () => {
    expect(calculateTotal(items)).toBe(60);
});
```

### 3. Not Cleaning Up

```javascript
// ❌ Bad: Tests affect each other
let globalData = [];

test('test 1', () => {
    globalData.push(1);
});

test('test 2', () => {
    // globalData might have data from test 1
});

// ✅ Good: Clean up between tests
beforeEach(() => {
    globalData = [];
});
```

---

## Key Takeaways

1. **Why Test**: Confidence, documentation, refactoring safety
2. **Test Types**: Unit, integration, E2E
3. **Test Pyramid**: Many unit, some integration, few E2E
4. **TDD**: Red-Green-Refactor cycle
5. **Test Structure**: Arrange-Act-Assert
6. **Edge Cases**: Test boundaries and errors
7. **Best Practice**: Test behavior, not implementation

---

## Quiz: Testing Basics

Test your understanding with these questions:

1. **Unit testing tests:**
   - A) Individual functions
   - B) Entire application
   - C) Both
   - D) Neither

2. **Integration testing tests:**
   - A) Single function
   - B) Multiple components together
   - C) Entire app
   - D) Nothing

3. **E2E testing tests:**
   - A) Single function
   - B) Components
   - C) Entire application
   - D) Nothing

4. **TDD cycle:**
   - A) Red-Green-Refactor
   - B) Green-Red-Refactor
   - C) Refactor-Red-Green
   - D) Random

5. **Test pyramid has:**
   - A) Many unit tests
   - B) Some integration tests
   - C) Few E2E tests
   - D) All of the above

6. **Tests should:**
   - A) Test behavior
   - B) Test implementation
   - C) Both
   - D) Neither

7. **Edge cases should:**
   - A) Be tested
   - B) Be ignored
   - C) Sometimes tested
   - D) Never tested

**Answers**:
1. A) Individual functions
2. B) Multiple components together
3. C) Entire application
4. A) Red-Green-Refactor
5. D) All of the above
6. A) Test behavior
7. A) Be tested

---

## Next Steps

Congratulations! You've learned testing basics. You now know:
- Why testing is important
- Different types of testing
- Test-driven development
- How to write basic tests

**What's Next?**
- Lesson 22.2: Jest Framework
- Learn Jest testing framework
- Write tests with Jest
- Use matchers and mocking

---

## Additional Resources

- **Jest Documentation**: [jestjs.io](https://jestjs.io)
- **Testing Best Practices**: [testingjavascript.com](https://testingjavascript.com)
- **MDN: Testing**: [developer.mozilla.org/en-US/docs/Learn/Tools_and_testing](https://developer.mozilla.org/en-US/docs/Learn/Tools_and_testing)

---

*Lesson completed! You're ready to move on to the next lesson.*

