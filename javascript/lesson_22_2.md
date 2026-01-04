# Lesson 22.2: Jest Framework

## Learning Objectives

By the end of this lesson, you will be able to:
- Install and set up Jest
- Write tests with Jest
- Use Jest matchers
- Test asynchronous code
- Mock functions and modules
- Use Jest features effectively
- Build comprehensive test suites

---

## Introduction to Jest

Jest is a JavaScript testing framework developed by Facebook. It's popular, easy to use, and has many built-in features.

### Why Jest?

- **Zero Configuration**: Works out of the box
- **Fast**: Parallel test execution
- **Built-in Mocking**: Easy to mock functions
- **Snapshot Testing**: Test UI components
- **Coverage Reports**: Built-in coverage
- **Great Documentation**: Excellent docs
- **Popular**: Widely used in industry

---

## Installing Jest

### npm Installation

```bash
# Install Jest
npm install --save-dev jest

# Or with yarn
yarn add --dev jest
```

### package.json Configuration

```json
{
  "scripts": {
    "test": "jest",
    "test:watch": "jest --watch",
    "test:coverage": "jest --coverage"
  },
  "devDependencies": {
    "jest": "^29.0.0"
  }
}
```

### Running Tests

```bash
# Run all tests
npm test

# Run in watch mode
npm test -- --watch

# Run with coverage
npm test -- --coverage
```

---

## Writing Tests

### Basic Test

```javascript
// math.js
function add(a, b) {
    return a + b;
}

module.exports = { add };
```

```javascript
// math.test.js
const { add } = require('./math');

test('adds 1 + 2 to equal 3', () => {
    expect(add(1, 2)).toBe(3);
});
```

### Test Structure

```javascript
// test(description, testFunction)
test('should do something', () => {
    // Test code
});

// or using describe
describe('Math functions', () => {
    test('add should sum numbers', () => {
        expect(add(2, 3)).toBe(5);
    });
});
```

### describe Blocks

```javascript
describe('Calculator', () => {
    describe('add', () => {
        test('should add positive numbers', () => {
            expect(add(2, 3)).toBe(5);
        });
        
        test('should add negative numbers', () => {
            expect(add(-2, -3)).toBe(-5);
        });
    });
    
    describe('subtract', () => {
        test('should subtract numbers', () => {
            expect(subtract(5, 3)).toBe(2);
        });
    });
});
```

---

## Matchers

### Common Matchers

```javascript
// toBe - Exact equality
expect(2 + 2).toBe(4);

// toEqual - Deep equality
expect({ a: 1 }).toEqual({ a: 1 });

// not - Negation
expect(2 + 2).not.toBe(5);

// toBeTruthy - Truthy value
expect(true).toBeTruthy();
expect(1).toBeTruthy();

// toBeFalsy - Falsy value
expect(false).toBeFalsy();
expect(0).toBeFalsy();
expect(null).toBeFalsy();

// toBeNull - Null
expect(null).toBeNull();

// toBeUndefined - Undefined
expect(undefined).toBeUndefined();

// toBeDefined - Not undefined
expect(5).toBeDefined();
```

### Number Matchers

```javascript
// toBeGreaterThan
expect(10).toBeGreaterThan(5);

// toBeGreaterThanOrEqual
expect(10).toBeGreaterThanOrEqual(10);

// toBeLessThan
expect(5).toBeLessThan(10);

// toBeLessThanOrEqual
expect(5).toBeLessThanOrEqual(5);

// toBeCloseTo - For floating point
expect(0.1 + 0.2).toBeCloseTo(0.3);
```

### String Matchers

```javascript
// toMatch - Regex
expect('Hello World').toMatch(/World/);

// toContain - Substring
expect('Hello World').toContain('World');
```

### Array Matchers

```javascript
// toContain
expect(['apple', 'banana', 'orange']).toContain('banana');

// toHaveLength
expect([1, 2, 3]).toHaveLength(3);
```

### Object Matchers

```javascript
// toHaveProperty
expect({ name: 'Alice', age: 30 }).toHaveProperty('name');
expect({ name: 'Alice', age: 30 }).toHaveProperty('age', 30);

// toMatchObject
expect({ name: 'Alice', age: 30 }).toMatchObject({ name: 'Alice' });
```

### Exception Matchers

```javascript
// toThrow
expect(() => {
    throw new Error('Error message');
}).toThrow();

expect(() => {
    throw new Error('Error message');
}).toThrow('Error message');

expect(() => {
    throw new Error('Error message');
}).toThrow(Error);
```

---

## Async Testing

### Promises

```javascript
// Return promise
test('fetches data', () => {
    return fetchData().then(data => {
        expect(data).toBeDefined();
    });
});

// Or use async/await
test('fetches data', async () => {
    let data = await fetchData();
    expect(data).toBeDefined();
});
```

### Async/Await

```javascript
test('async function works', async () => {
    let result = await asyncFunction();
    expect(result).toBe('expected value');
});
```

### Resolves/Rejects

```javascript
// Resolves
test('promise resolves', async () => {
    await expect(fetchData()).resolves.toBe('data');
});

// Rejects
test('promise rejects', async () => {
    await expect(failingFunction()).rejects.toThrow('Error');
});
```

### Timeouts

```javascript
// Set timeout
test('slow operation', async () => {
    await slowOperation();
}, 10000);  // 10 second timeout
```

---

## Mocking

### Mock Functions

```javascript
// Create mock function
let mockFn = jest.fn();

// Use mock
mockFn('arg1', 'arg2');

// Check calls
expect(mockFn).toHaveBeenCalled();
expect(mockFn).toHaveBeenCalledWith('arg1', 'arg2');
expect(mockFn).toHaveBeenCalledTimes(1);

// Mock return value
let mockFn = jest.fn();
mockFn.mockReturnValue(42);
expect(mockFn()).toBe(42);

// Mock implementation
let mockFn = jest.fn((a, b) => a + b);
expect(mockFn(2, 3)).toBe(5);
```

### Mocking Modules

```javascript
// Mock entire module
jest.mock('./api');

// Mock specific function
jest.mock('./api', () => ({
    fetchUser: jest.fn(() => Promise.resolve({ id: 1, name: 'Test' }))
}));
```

### Mock Implementation

```javascript
// Mock with implementation
let mockFn = jest.fn();
mockFn.mockImplementation((a, b) => a * b);
expect(mockFn(2, 3)).toBe(6);

// Different implementations per call
mockFn
    .mockImplementationOnce(() => 1)
    .mockImplementationOnce(() => 2);
expect(mockFn()).toBe(1);
expect(mockFn()).toBe(2);
```

### Spying

```javascript
// Spy on existing function
let obj = {
    method: () => 'original'
};

let spy = jest.spyOn(obj, 'method');
obj.method();
expect(spy).toHaveBeenCalled();

// Restore original
spy.mockRestore();
```

---

## Setup and Teardown

### beforeEach and afterEach

```javascript
let database;

beforeEach(() => {
    database = new Database();
    database.connect();
});

afterEach(() => {
    database.disconnect();
});

test('test 1', () => {
    // database is available
});

test('test 2', () => {
    // database is fresh for each test
});
```

### beforeAll and afterAll

```javascript
let sharedResource;

beforeAll(() => {
    sharedResource = initializeResource();
});

afterAll(() => {
    cleanupResource(sharedResource);
});

test('test 1', () => {
    // Uses sharedResource
});

test('test 2', () => {
    // Uses same sharedResource
});
```

---

## Practice Exercise

### Exercise: Jest Practice

**Objective**: Practice writing tests with Jest, using matchers, testing async code, and mocking.

**Instructions**:

1. Install Jest
2. Create test files
3. Practice:
   - Writing tests with Jest
   - Using matchers
   - Testing async code
   - Mocking functions and modules

**Example Solution**:

```javascript
// utils.js
function add(a, b) {
    return a + b;
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

async function fetchUser(id) {
    // Simulate API call
    return new Promise(resolve => {
        setTimeout(() => {
            resolve({ id, name: 'User ' + id });
        }, 100);
    });
}

function processItems(items, processor) {
    return items.map(processor);
}

module.exports = {
    add,
    multiply,
    divide,
    fetchUser,
    processItems
};
```

```javascript
// utils.test.js
const {
    add,
    multiply,
    divide,
    fetchUser,
    processItems
} = require('./utils');

describe('Math functions', () => {
    describe('add', () => {
        test('should add positive numbers', () => {
            expect(add(2, 3)).toBe(5);
        });
        
        test('should add negative numbers', () => {
            expect(add(-2, -3)).toBe(-5);
        });
        
        test('should add zero', () => {
            expect(add(5, 0)).toBe(5);
        });
        
        test('should handle decimals', () => {
            expect(add(1.5, 2.5)).toBe(4);
        });
    });
    
    describe('multiply', () => {
        test('should multiply numbers', () => {
            expect(multiply(2, 3)).toBe(6);
        });
        
        test('should multiply by zero', () => {
            expect(multiply(5, 0)).toBe(0);
        });
    });
    
    describe('divide', () => {
        test('should divide numbers', () => {
            expect(divide(10, 2)).toBe(5);
        });
        
        test('should throw error on division by zero', () => {
            expect(() => divide(10, 0)).toThrow('Division by zero');
        });
    });
});

describe('Async functions', () => {
    test('fetchUser should return user', async () => {
        let user = await fetchUser(1);
        expect(user).toEqual({ id: 1, name: 'User 1' });
    });
    
    test('fetchUser should resolve', async () => {
        await expect(fetchUser(1)).resolves.toEqual({ id: 1, name: 'User 1' });
    });
});

describe('Mocking', () => {
    test('processItems should use processor function', () => {
        let mockProcessor = jest.fn(x => x * 2);
        let items = [1, 2, 3];
        
        let result = processItems(items, mockProcessor);
        
        expect(result).toEqual([2, 4, 6]);
        expect(mockProcessor).toHaveBeenCalledTimes(3);
        expect(mockProcessor).toHaveBeenCalledWith(1);
        expect(mockProcessor).toHaveBeenCalledWith(2);
        expect(mockProcessor).toHaveBeenCalledWith(3);
    });
    
    test('mock function with return value', () => {
        let mockFn = jest.fn();
        mockFn.mockReturnValue(42);
        
        expect(mockFn()).toBe(42);
        expect(mockFn).toHaveBeenCalled();
    });
    
    test('mock function with implementation', () => {
        let mockFn = jest.fn((a, b) => a + b);
        
        expect(mockFn(2, 3)).toBe(5);
        expect(mockFn).toHaveBeenCalledWith(2, 3);
    });
    
    test('mock function multiple calls', () => {
        let mockFn = jest.fn();
        mockFn.mockReturnValueOnce(1);
        mockFn.mockReturnValueOnce(2);
        mockFn.mockReturnValue(3);
        
        expect(mockFn()).toBe(1);
        expect(mockFn()).toBe(2);
        expect(mockFn()).toBe(3);
        expect(mockFn()).toBe(3);
    });
});

describe('Matchers', () => {
    test('toBe vs toEqual', () => {
        expect(2 + 2).toBe(4);
        expect({ a: 1 }).toEqual({ a: 1 });
        expect({ a: 1 }).not.toBe({ a: 1 });  // Different objects
    });
    
    test('truthiness', () => {
        expect(true).toBeTruthy();
        expect(1).toBeTruthy();
        expect(false).toBeFalsy();
        expect(0).toBeFalsy();
        expect(null).toBeNull();
        expect(undefined).toBeUndefined();
    });
    
    test('numbers', () => {
        expect(10).toBeGreaterThan(5);
        expect(5).toBeLessThan(10);
        expect(0.1 + 0.2).toBeCloseTo(0.3);
    });
    
    test('strings', () => {
        expect('Hello World').toMatch(/World/);
        expect('Hello World').toContain('World');
    });
    
    test('arrays', () => {
        expect([1, 2, 3]).toContain(2);
        expect([1, 2, 3]).toHaveLength(3);
    });
    
    test('objects', () => {
        let obj = { name: 'Alice', age: 30 };
        expect(obj).toHaveProperty('name');
        expect(obj).toHaveProperty('age', 30);
        expect(obj).toMatchObject({ name: 'Alice' });
    });
});

describe('Setup and Teardown', () => {
    let data;
    
    beforeEach(() => {
        data = [];
    });
    
    afterEach(() => {
        data = null;
    });
    
    test('test 1', () => {
        data.push(1);
        expect(data).toHaveLength(1);
    });
    
    test('test 2', () => {
        // data is fresh (empty)
        expect(data).toHaveLength(0);
    });
});
```

**Expected Output** (when running `npm test`):
```
PASS  utils.test.js
  Math functions
    add
      ✓ should add positive numbers (2 ms)
      ✓ should add negative numbers
      ✓ should add zero
      ✓ should handle decimals
    multiply
      ✓ should multiply numbers
      ✓ should multiply by zero
    divide
      ✓ should divide numbers
      ✓ should throw error on division by zero
  Async functions
    ✓ fetchUser should return user (105 ms)
    ✓ fetchUser should resolves
  Mocking
    ✓ processItems should use processor function
    ✓ mock function with return value
    ✓ mock function with implementation
    ✓ mock function multiple calls
  Matchers
    ✓ toBe vs toEqual
    ✓ truthiness
    ✓ numbers
    ✓ strings
    ✓ arrays
    ✓ objects
  Setup and Teardown
    ✓ test 1
    ✓ test 2

Test Suites: 1 passed, 1 total
Tests:       20 passed, 20 total
```

**Challenge (Optional)**:
- Write tests for your own code
- Practice mocking complex dependencies
- Test async operations
- Build a complete test suite

---

## Common Mistakes

### 1. Not Awaiting Async

```javascript
// ❌ Bad: Not awaiting
test('async test', () => {
    fetchData().then(data => {
        expect(data).toBeDefined();
    });
    // Test might finish before promise resolves
});

// ✅ Good: Await
test('async test', async () => {
    let data = await fetchData();
    expect(data).toBeDefined();
});
```

### 2. Not Clearing Mocks

```javascript
// ❌ Bad: Mocks accumulate
test('test 1', () => {
    mockFn();
});

test('test 2', () => {
    mockFn();
    // mockFn has been called twice total
});

// ✅ Good: Clear between tests
beforeEach(() => {
    mockFn.mockClear();
});
```

### 3. Testing Implementation

```javascript
// ❌ Bad: Test implementation
test('should use reduce', () => {
    // Check if reduce is used
});

// ✅ Good: Test behavior
test('should calculate total', () => {
    expect(calculateTotal(items)).toBe(60);
});
```

---

## Key Takeaways

1. **Jest**: Popular, easy-to-use testing framework
2. **Matchers**: toBe, toEqual, toContain, etc.
3. **Async Testing**: Use async/await or promises
4. **Mocking**: Mock functions and modules
5. **Setup/Teardown**: beforeEach, afterEach, beforeAll, afterAll
6. **Best Practice**: Test behavior, clear mocks, await async
7. **Coverage**: Use --coverage for coverage reports

---

## Quiz: Jest

Test your understanding with these questions:

1. **Jest is:**
   - A) Testing framework
   - B) Build tool
   - C) Both
   - D) Neither

2. **toBe checks:**
   - A) Deep equality
   - B) Exact equality
   - C) Both
   - D) Neither

3. **toEqual checks:**
   - A) Deep equality
   - B) Exact equality
   - C) Both
   - D) Neither

4. **jest.fn() creates:**
   - A) Mock function
   - B) Real function
   - C) Both
   - D) Neither

5. **beforeEach runs:**
   - A) Once before all tests
   - B) Before each test
   - C) After each test
   - D) Never

6. **Async tests need:**
   - A) async/await
   - B) .then()
   - C) Both
   - D) Neither

7. **--coverage flag:**
   - A) Shows coverage
   - B) Runs faster
   - C) Both
   - D) Neither

**Answers**:
1. A) Testing framework
2. B) Exact equality
3. A) Deep equality
4. A) Mock function
5. B) Before each test
6. C) Both
7. A) Shows coverage

---

## Next Steps

Congratulations! You've learned Jest framework. You now know:
- How to install and use Jest
- How to write tests
- How to use matchers
- How to test async code
- How to mock functions

**What's Next?**
- Lesson 22.3: Advanced Testing
- Learn React component testing
- Understand integration testing
- Work with E2E testing tools

---

## Additional Resources

- **Jest Documentation**: [jestjs.io/docs/getting-started](https://jestjs.io/docs/getting-started)
- **Jest Matchers**: [jestjs.io/docs/expect](https://jestjs.io/docs/expect)
- **Jest Mocking**: [jestjs.io/docs/mock-functions](https://jestjs.io/docs/mock-functions)

---

*Lesson completed! You're ready to move on to the next lesson.*

