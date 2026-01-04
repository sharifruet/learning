# Lesson 24.2: TypeScript Introduction

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand TypeScript basics
- Use types and interfaces
- Add type annotations
- Compile TypeScript to JavaScript
- Work with TypeScript features
- Build type-safe applications
- Understand type system benefits

---

## Introduction to TypeScript

TypeScript is a typed superset of JavaScript that compiles to plain JavaScript.

### Why TypeScript?

- **Type Safety**: Catch errors at compile time
- **Better IDE Support**: Autocomplete, refactoring
- **Documentation**: Types document code
- **Refactoring**: Safer to refactor
- **Large Projects**: Better for large codebases
- **Industry Standard**: Widely adopted
- **Modern JavaScript**: Supports latest features

---

## TypeScript Basics

### Installation

```bash
# Install TypeScript
npm install -g typescript

# Or locally
npm install --save-dev typescript

# Check version
tsc --version
```

### First TypeScript File

```typescript
// hello.ts
function greet(name: string): string {
    return `Hello, ${name}!`;
}

let message = greet('World');
console.log(message);
```

### Compiling TypeScript

```bash
# Compile TypeScript
tsc hello.ts

# Generates hello.js
```

---

## Types

### Basic Types

```typescript
// String
let name: string = 'Alice';

// Number
let age: number = 30;

// Boolean
let isActive: boolean = true;

// Array
let numbers: number[] = [1, 2, 3];
let names: Array<string> = ['Alice', 'Bob'];

// Tuple
let tuple: [string, number] = ['Alice', 30];

// Any
let anything: any = 'can be anything';

// Void
function log(message: string): void {
    console.log(message);
}

// Null and Undefined
let nullValue: null = null;
let undefinedValue: undefined = undefined;
```

### Union Types

```typescript
// Union type
let value: string | number;
value = 'hello';
value = 42;

// Union with null
let name: string | null = null;
name = 'Alice';
```

### Literal Types

```typescript
// Literal types
let direction: 'up' | 'down' | 'left' | 'right';
direction = 'up';
// direction = 'diagonal';  // Error

// Boolean literal
let isTrue: true = true;
```

---

## Type Annotations

### Function Types

```typescript
// Function with types
function add(a: number, b: number): number {
    return a + b;
}

// Arrow function
let multiply = (a: number, b: number): number => {
    return a * b;
};

// Function type
let operation: (a: number, b: number) => number;
operation = add;
operation = multiply;
```

### Variable Types

```typescript
// Explicit type
let count: number = 0;

// Type inference
let name = 'Alice';  // Type: string
let age = 30;        // Type: number

// Type assertion
let value: any = 'hello';
let length = (value as string).length;
```

### Object Types

```typescript
// Object type
let user: {
    name: string;
    age: number;
    email?: string;  // Optional
} = {
    name: 'Alice',
    age: 30
};
```

---

## Interfaces

### Basic Interface

```typescript
// Define interface
interface User {
    name: string;
    age: number;
    email?: string;  // Optional property
}

// Use interface
let user: User = {
    name: 'Alice',
    age: 30
};

// Function with interface
function getUser(): User {
    return {
        name: 'Bob',
        age: 25,
        email: 'bob@example.com'
    };
}
```

### Interface with Methods

```typescript
interface Calculator {
    add(a: number, b: number): number;
    subtract(a: number, b: number): number;
}

let calc: Calculator = {
    add: (a, b) => a + b,
    subtract: (a, b) => a - b
};
```

### Extending Interfaces

```typescript
interface Person {
    name: string;
    age: number;
}

interface Employee extends Person {
    employeeId: string;
    department: string;
}

let employee: Employee = {
    name: 'Alice',
    age: 30,
    employeeId: 'E001',
    department: 'Engineering'
};
```

---

## Classes

### TypeScript Classes

```typescript
class User {
    name: string;
    age: number;
    
    constructor(name: string, age: number) {
        this.name = name;
        this.age = age;
    }
    
    greet(): string {
        return `Hello, I'm ${this.name}`;
    }
}

let user = new User('Alice', 30);
console.log(user.greet());
```

### Access Modifiers

```typescript
class User {
    public name: string;      // Public (default)
    private age: number;      // Private
    protected email: string;  // Protected
    
    constructor(name: string, age: number, email: string) {
        this.name = name;
        this.age = age;
        this.email = email;
    }
}
```

---

## Generics

### Basic Generics

```typescript
// Generic function
function identity<T>(arg: T): T {
    return arg;
}

let number = identity<number>(42);
let string = identity<string>('hello');

// Generic interface
interface Box<T> {
    value: T;
}

let numberBox: Box<number> = { value: 42 };
let stringBox: Box<string> = { value: 'hello' };
```

### Generic Constraints

```typescript
interface Lengthwise {
    length: number;
}

function logLength<T extends Lengthwise>(arg: T): T {
    console.log(arg.length);
    return arg;
}

logLength('hello');  // OK
logLength([1, 2, 3]);  // OK
// logLength(42);  // Error: number doesn't have length
```

---

## Compiling TypeScript

### tsconfig.json

```json
{
  "compilerOptions": {
    "target": "ES2020",
    "module": "ES2020",
    "lib": ["ES2020"],
    "outDir": "./dist",
    "rootDir": "./src",
    "strict": true,
    "esModuleInterop": true,
    "skipLibCheck": true,
    "forceConsistentCasingInFileNames": true
  },
  "include": ["src/**/*"],
  "exclude": ["node_modules", "dist"]
}
```

### Compiler Options

```json
{
  "compilerOptions": {
    "target": "ES2020",           // JavaScript version
    "module": "ES2020",           // Module system
    "lib": ["ES2020"],            // Library files
    "outDir": "./dist",           // Output directory
    "rootDir": "./src",           // Root directory
    "strict": true,               // Strict type checking
    "noImplicitAny": true,        // Error on implicit any
    "strictNullChecks": true,     // Strict null checks
    "esModuleInterop": true,      // ES module interop
    "skipLibCheck": true,         // Skip lib checking
    "sourceMap": true             // Generate source maps
  }
}
```

### Compiling

```bash
# Compile TypeScript
tsc

# Watch mode
tsc --watch

# Compile specific file
tsc file.ts

# Compile with config
tsc --project tsconfig.json
```

---

## Practice Exercise

### Exercise: TypeScript Practice

**Objective**: Practice using TypeScript, working with types, interfaces, and compiling TypeScript.

**Instructions**:

1. Install TypeScript
2. Create TypeScript files
3. Practice:
   - Using basic types
   - Creating interfaces
   - Adding type annotations
   - Compiling TypeScript

**Example Solution**:

```bash
# 1. Install TypeScript
npm install --save-dev typescript

# 2. Initialize TypeScript
npx tsc --init
```

```json
// tsconfig.json
{
  "compilerOptions": {
    "target": "ES2020",
    "module": "ES2020",
    "lib": ["ES2020"],
    "outDir": "./dist",
    "rootDir": "./src",
    "strict": true,
    "esModuleInterop": true,
    "skipLibCheck": true,
    "forceConsistentCasingInFileNames": true,
    "sourceMap": true
  },
  "include": ["src/**/*"],
  "exclude": ["node_modules", "dist"]
}
```

```typescript
// src/basics.ts
console.log("=== TypeScript Basics ===");

// Basic types
let name: string = 'Alice';
let age: number = 30;
let isActive: boolean = true;

console.log('Name:', name);
console.log('Age:', age);
console.log('Active:', isActive);

// Arrays
let numbers: number[] = [1, 2, 3, 4, 5];
let names: Array<string> = ['Alice', 'Bob', 'Charlie'];

console.log('Numbers:', numbers);
console.log('Names:', names);

// Tuples
let tuple: [string, number] = ['Alice', 30];
console.log('Tuple:', tuple);

// Union types
let value: string | number;
value = 'hello';
console.log('Value (string):', value);
value = 42;
console.log('Value (number):', value);

// Any
let anything: any = 'can be anything';
anything = 42;
anything = true;
console.log('Anything:', anything);
```

```typescript
// src/functions.ts
console.log("=== Functions ===");

// Function with types
function add(a: number, b: number): number {
    return a + b;
}

console.log('add(2, 3):', add(2, 3));

// Arrow function
let multiply = (a: number, b: number): number => {
    return a * b;
};

console.log('multiply(4, 5):', multiply(4, 5));

// Optional parameters
function greet(name: string, title?: string): string {
    if (title) {
        return `Hello, ${title} ${name}!`;
    }
    return `Hello, ${name}!`;
}

console.log('greet("Alice"):', greet('Alice'));
console.log('greet("Alice", "Dr."):', greet('Alice', 'Dr.'));

// Default parameters
function createUser(name: string, age: number = 18): { name: string; age: number } {
    return { name, age };
}

console.log('createUser("Bob"):', createUser('Bob'));
console.log('createUser("Charlie", 25):', createUser('Charlie', 25));

// Rest parameters
function sum(...numbers: number[]): number {
    return numbers.reduce((total, num) => total + num, 0);
}

console.log('sum(1, 2, 3, 4, 5):', sum(1, 2, 3, 4, 5));
```

```typescript
// src/interfaces.ts
console.log("=== Interfaces ===");

// Basic interface
interface User {
    name: string;
    age: number;
    email?: string;  // Optional
}

let user: User = {
    name: 'Alice',
    age: 30,
    email: 'alice@example.com'
};

console.log('User:', user);

// Interface with methods
interface Calculator {
    add(a: number, b: number): number;
    subtract(a: number, b: number): number;
    multiply(a: number, b: number): number;
    divide(a: number, b: number): number;
}

let calc: Calculator = {
    add: (a, b) => a + b,
    subtract: (a, b) => a - b,
    multiply: (a, b) => a * b,
    divide: (a, b) => {
        if (b === 0) {
            throw new Error('Division by zero');
        }
        return a / b;
    }
};

console.log('calc.add(10, 5):', calc.add(10, 5));
console.log('calc.subtract(10, 5):', calc.subtract(10, 5));
console.log('calc.multiply(10, 5):', calc.multiply(10, 5));
console.log('calc.divide(10, 5):', calc.divide(10, 5));

// Extending interfaces
interface Person {
    name: string;
    age: number;
}

interface Employee extends Person {
    employeeId: string;
    department: string;
}

let employee: Employee = {
    name: 'Bob',
    age: 25,
    employeeId: 'E001',
    department: 'Engineering'
};

console.log('Employee:', employee);
```

```typescript
// src/classes.ts
console.log("=== Classes ===");

class User {
    name: string;
    age: number;
    private email: string;
    
    constructor(name: string, age: number, email: string) {
        this.name = name;
        this.age = age;
        this.email = email;
    }
    
    greet(): string {
        return `Hello, I'm ${this.name}`;
    }
    
    getEmail(): string {
        return this.email;
    }
}

let user = new User('Alice', 30, 'alice@example.com');
console.log('User:', user.greet());
console.log('Email:', user.getEmail());

// Class with inheritance
class Admin extends User {
    permissions: string[];
    
    constructor(name: string, age: number, email: string, permissions: string[]) {
        super(name, age, email);
        this.permissions = permissions;
    }
    
    hasPermission(permission: string): boolean {
        return this.permissions.includes(permission);
    }
}

let admin = new Admin('Admin', 35, 'admin@example.com', ['read', 'write', 'delete']);
console.log('Admin:', admin.greet());
console.log('Has write permission:', admin.hasPermission('write'));
```

```typescript
// src/generics.ts
console.log("=== Generics ===");

// Generic function
function identity<T>(arg: T): T {
    return arg;
}

let number = identity<number>(42);
let string = identity<string>('hello');
let boolean = identity<boolean>(true);

console.log('Identity number:', number);
console.log('Identity string:', string);
console.log('Identity boolean:', boolean);

// Generic interface
interface Box<T> {
    value: T;
    getValue(): T;
}

let numberBox: Box<number> = {
    value: 42,
    getValue: function() {
        return this.value;
    }
};

let stringBox: Box<string> = {
    value: 'hello',
    getValue: function() {
        return this.value;
    }
};

console.log('Number box:', numberBox.getValue());
console.log('String box:', stringBox.getValue());

// Generic class
class Container<T> {
    private items: T[] = [];
    
    add(item: T): void {
        this.items.push(item);
    }
    
    get(index: number): T {
        return this.items[index];
    }
    
    getAll(): T[] {
        return this.items;
    }
}

let numberContainer = new Container<number>();
numberContainer.add(1);
numberContainer.add(2);
numberContainer.add(3);
console.log('Number container:', numberContainer.getAll());

let stringContainer = new Container<string>();
stringContainer.add('a');
stringContainer.add('b');
stringContainer.add('c');
console.log('String container:', stringContainer.getAll());
```

```typescript
// src/index.ts
import './basics';
import './functions';
import './interfaces';
import './classes';
import './generics';
```

```json
// package.json
{
  "name": "typescript-practice",
  "version": "1.0.0",
  "scripts": {
    "build": "tsc",
    "watch": "tsc --watch",
    "start": "node dist/index.js"
  },
  "devDependencies": {
    "typescript": "^5.2.0"
  }
}
```

**Expected Output** (after compiling and running):
```
=== TypeScript Basics ===
Name: Alice
Age: 30
Active: true
Numbers: [1, 2, 3, 4, 5]
Names: ['Alice', 'Bob', 'Charlie']
Tuple: ['Alice', 30]
Value (string): hello
Value (number): 42
Anything: true

=== Functions ===
add(2, 3): 5
multiply(4, 5): 20
greet("Alice"): Hello, Alice!
greet("Alice", "Dr."): Hello, Dr. Alice!
createUser("Bob"): { name: 'Bob', age: 18 }
createUser("Charlie", 25): { name: 'Charlie', age: 25 }
sum(1, 2, 3, 4, 5): 15

=== Interfaces ===
User: { name: 'Alice', age: 30, email: 'alice@example.com' }
calc.add(10, 5): 15
calc.subtract(10, 5): 5
calc.multiply(10, 5): 50
calc.divide(10, 5): 2
Employee: { name: 'Bob', age: 25, employeeId: 'E001', department: 'Engineering' }

=== Classes ===
User: Hello, I'm Alice
Email: alice@example.com
Admin: Hello, I'm Admin
Has write permission: true

=== Generics ===
Identity number: 42
Identity string: hello
Identity boolean: true
Number box: 42
String box: hello
Number container: [1, 2, 3]
String container: ['a', 'b', 'c']
```

**Challenge (Optional)**:
- Convert JavaScript project to TypeScript
- Add types to existing code
- Create type definitions
- Build a complete TypeScript application

---

## Common Mistakes

### 1. Using any Too Much

```typescript
// ❌ Bad: Too much any
function process(data: any): any {
    return data;
}

// ✅ Good: Use specific types
function process<T>(data: T): T {
    return data;
}
```

### 2. Not Using Strict Mode

```json
// ❌ Bad: No strict mode
{
  "compilerOptions": {
    "strict": false
  }
}

// ✅ Good: Use strict mode
{
  "compilerOptions": {
    "strict": true
  }
}
```

### 3. Ignoring Type Errors

```typescript
// ❌ Bad: Ignore errors
// @ts-ignore
let value = undefinedValue.property;

// ✅ Good: Fix the error
let value = definedValue?.property;
```

---

## Key Takeaways

1. **TypeScript**: Typed superset of JavaScript
2. **Types**: string, number, boolean, arrays, etc.
3. **Interfaces**: Define object shapes
4. **Classes**: Type-safe classes with modifiers
5. **Generics**: Reusable type-safe code
6. **Compilation**: Compiles to JavaScript
7. **Best Practice**: Use strict mode, avoid any, leverage types

---

## Quiz: TypeScript

Test your understanding with these questions:

1. **TypeScript is:**
   - A) Typed superset of JavaScript
   - B) Different language
   - C) Both
   - D) Neither

2. **Type annotation uses:**
   - A) :
   - B) =
   - C) Both
   - D) Neither

3. **Interface defines:**
   - A) Object shape
   - B) Function
   - C) Both
   - D) Neither

4. **private modifier:**
   - A) Accessible anywhere
   - B) Accessible in class only
   - C) Accessible in subclasses
   - D) Nothing

5. **Generics use:**
   - A) <T>
   - B) {T}
   - C) [T]
   - D) (T)

6. **tsc compiles:**
   - A) TypeScript to JavaScript
   - B) JavaScript to TypeScript
   - C) Both
   - D) Neither

7. **strict mode:**
   - A) Enables strict checking
   - B) Disables checking
   - C) Both
   - D) Neither

**Answers**:
1. A) Typed superset of JavaScript
2. A) :
3. A) Object shape
4. B) Accessible in class only
5. A) <T>
6. A) TypeScript to JavaScript
7. A) Enables strict checking

---

## Next Steps

Congratulations! You've completed Module 24: Code Quality and Linting. You now know:
- ESLint for code quality
- TypeScript for type safety
- How to maintain code quality
- How to build type-safe applications

**What's Next?**
- Course 7: Frontend Frameworks
- Module 25: React Basics
- Lesson 25.1: React Introduction
- Learn what React is
- Set up React projects

---

## Additional Resources

- **TypeScript Documentation**: [typescriptlang.org](https://www.typescriptlang.org)
- **TypeScript Handbook**: [typescriptlang.org/docs/handbook/intro.html](https://www.typescriptlang.org/docs/handbook/intro.html)
- **TypeScript Playground**: [typescriptlang.org/play](https://www.typescriptlang.org/play)

---

*Lesson completed! You've finished Module 24: Code Quality and Linting. Ready for Course 7: Frontend Frameworks!*

