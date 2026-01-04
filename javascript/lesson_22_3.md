# Lesson 22.3: Advanced Testing

## Learning Objectives

By the end of this lesson, you will be able to:
- Test React components
- Write integration tests
- Use E2E testing tools (Cypress, Playwright)
- Generate and read coverage reports
- Test complex scenarios
- Build comprehensive test suites
- Ensure application quality

---

## Introduction to Advanced Testing

Advanced testing covers component testing, integration testing, E2E testing, and coverage analysis.

### Why Advanced Testing?

- **Component Testing**: Test UI components in isolation
- **Integration Testing**: Test how components work together
- **E2E Testing**: Test complete user flows
- **Coverage**: Ensure code is tested
- **Quality**: Higher confidence in application
- **Professional**: Industry standard practices

---

## Testing React Components

### Setting Up React Testing

```bash
# Install React Testing Library
npm install --save-dev @testing-library/react @testing-library/jest-dom

# Install React Test Renderer
npm install --save-dev react-test-renderer
```

### Basic Component Test

```javascript
// Button.jsx
import React from 'react';

function Button({ onClick, children }) {
    return (
        <button onClick={onClick}>
            {children}
        </button>
    );
}

export default Button;
```

```javascript
// Button.test.jsx
import React from 'react';
import { render, screen, fireEvent } from '@testing-library/react';
import Button from './Button';

test('renders button with text', () => {
    render(<Button>Click me</Button>);
    let button = screen.getByText('Click me');
    expect(button).toBeInTheDocument();
});

test('calls onClick when clicked', () => {
    let handleClick = jest.fn();
    render(<Button onClick={handleClick}>Click me</Button>);
    
    let button = screen.getByText('Click me');
    fireEvent.click(button);
    
    expect(handleClick).toHaveBeenCalledTimes(1);
});
```

### Testing User Interactions

```javascript
// Form.test.jsx
import { render, screen, fireEvent } from '@testing-library/react';
import Form from './Form';

test('submits form with data', () => {
    let handleSubmit = jest.fn();
    render(<Form onSubmit={handleSubmit} />);
    
    let nameInput = screen.getByLabelText('Name');
    let emailInput = screen.getByLabelText('Email');
    let submitButton = screen.getByRole('button', { name: 'Submit' });
    
    fireEvent.change(nameInput, { target: { value: 'Alice' } });
    fireEvent.change(emailInput, { target: { value: 'alice@example.com' } });
    fireEvent.click(submitButton);
    
    expect(handleSubmit).toHaveBeenCalledWith({
        name: 'Alice',
        email: 'alice@example.com'
    });
});
```

### Testing Async Components

```javascript
// UserProfile.test.jsx
import { render, screen, waitFor } from '@testing-library/react';
import UserProfile from './UserProfile';

test('displays user data after loading', async () => {
    render(<UserProfile userId={1} />);
    
    // Wait for loading to finish
    await waitFor(() => {
        expect(screen.getByText('Alice')).toBeInTheDocument();
    });
});
```

---

## Integration Testing

### What is Integration Testing?

Integration testing verifies that multiple components work together correctly.

### Integration Test Example

```javascript
// UserList.test.jsx
import { render, screen } from '@testing-library/react';
import UserList from './UserList';
import UserService from './UserService';

// Mock service
jest.mock('./UserService');

test('displays list of users', async () => {
    UserService.getUsers.mockResolvedValue([
        { id: 1, name: 'Alice' },
        { id: 2, name: 'Bob' }
    ]);
    
    render(<UserList />);
    
    await waitFor(() => {
        expect(screen.getByText('Alice')).toBeInTheDocument();
        expect(screen.getByText('Bob')).toBeInTheDocument();
    });
});
```

### Testing Component Integration

```javascript
// App.test.jsx
import { render, screen, fireEvent } from '@testing-library/react';
import App from './App';

test('complete user flow', async () => {
    render(<App />);
    
    // 1. Login
    let emailInput = screen.getByLabelText('Email');
    let passwordInput = screen.getByLabelText('Password');
    let loginButton = screen.getByRole('button', { name: 'Login' });
    
    fireEvent.change(emailInput, { target: { value: 'user@example.com' } });
    fireEvent.change(passwordInput, { target: { value: 'password' } });
    fireEvent.click(loginButton);
    
    // 2. Verify dashboard
    await waitFor(() => {
        expect(screen.getByText('Dashboard')).toBeInTheDocument();
    });
    
    // 3. Navigate to profile
    let profileLink = screen.getByText('Profile');
    fireEvent.click(profileLink);
    
    // 4. Verify profile page
    expect(screen.getByText('User Profile')).toBeInTheDocument();
});
```

---

## End-to-End (E2E) Testing

### Cypress

```bash
# Install Cypress
npm install --save-dev cypress
```

```javascript
// cypress/e2e/login.cy.js
describe('Login Flow', () => {
    it('should login successfully', () => {
        cy.visit('http://localhost:3000');
        
        cy.get('[data-testid="email"]').type('user@example.com');
        cy.get('[data-testid="password"]').type('password');
        cy.get('[data-testid="login-button"]').click();
        
        cy.url().should('include', '/dashboard');
        cy.get('[data-testid="dashboard"]').should('be.visible');
    });
});
```

### Playwright

```bash
# Install Playwright
npm install --save-dev @playwright/test
```

```javascript
// tests/login.spec.js
const { test, expect } = require('@playwright/test');

test('should login successfully', async ({ page }) => {
    await page.goto('http://localhost:3000');
    
    await page.fill('[data-testid="email"]', 'user@example.com');
    await page.fill('[data-testid="password"]', 'password');
    await page.click('[data-testid="login-button"]');
    
    await expect(page).toHaveURL(/.*dashboard/);
    await expect(page.locator('[data-testid="dashboard"]')).toBeVisible();
});
```

### E2E Test Best Practices

```javascript
// Use data-testid for selectors
<button data-testid="submit-button">Submit</button>

// Wait for elements
await page.waitForSelector('[data-testid="element"]');

// Use meaningful test descriptions
test('user can add item to cart and checkout', async () => {
    // Test steps
});

// Clean up between tests
afterEach(async () => {
    await page.close();
});
```

---

## Coverage Reports

### Generating Coverage

```bash
# Run tests with coverage
npm test -- --coverage

# Or in package.json
{
  "scripts": {
    "test:coverage": "jest --coverage"
  }
}
```

### Coverage Metrics

```javascript
// Coverage shows:
// - Statements: % of statements executed
// - Branches: % of branches executed
// - Functions: % of functions called
// - Lines: % of lines executed

// Example coverage output:
// File      | % Stmts | % Branch | % Funcs | % Lines
// ----------|---------|----------|---------|--------
// utils.js  |   85.71 |    66.67 |   83.33 |   85.71
```

### Coverage Configuration

```javascript
// jest.config.js
module.exports = {
    collectCoverageFrom: [
        'src/**/*.{js,jsx}',
        '!src/**/*.test.{js,jsx}',
        '!src/index.js'
    ],
    coverageThresholds: {
        global: {
            branches: 80,
            functions: 80,
            lines: 80,
            statements: 80
        }
    }
};
```

---

## Practice Exercise

### Exercise: Advanced Testing

**Objective**: Practice testing React components, integration testing, E2E testing concepts, and coverage.

**Instructions**:

1. Set up testing environment
2. Create components to test
3. Practice:
   - Testing React components
   - Writing integration tests
   - Understanding E2E testing
   - Generating coverage reports

**Example Solution**:

```javascript
// components/Button.jsx
import React from 'react';

function Button({ onClick, children, disabled = false }) {
    return (
        <button onClick={onClick} disabled={disabled}>
            {children}
        </button>
    );
}

export default Button;
```

```javascript
// components/Button.test.jsx
import React from 'react';
import { render, screen, fireEvent } from '@testing-library/react';
import '@testing-library/jest-dom';
import Button from './Button';

describe('Button Component', () => {
    test('renders button with text', () => {
        render(<Button>Click me</Button>);
        let button = screen.getByRole('button', { name: 'Click me' });
        expect(button).toBeInTheDocument();
    });
    
    test('calls onClick when clicked', () => {
        let handleClick = jest.fn();
        render(<Button onClick={handleClick}>Click me</Button>);
        
        let button = screen.getByRole('button');
        fireEvent.click(button);
        
        expect(handleClick).toHaveBeenCalledTimes(1);
    });
    
    test('is disabled when disabled prop is true', () => {
        render(<Button disabled>Click me</Button>);
        let button = screen.getByRole('button');
        expect(button).toBeDisabled();
    });
    
    test('does not call onClick when disabled', () => {
        let handleClick = jest.fn();
        render(<Button onClick={handleClick} disabled>Click me</Button>);
        
        let button = screen.getByRole('button');
        fireEvent.click(button);
        
        expect(handleClick).not.toHaveBeenCalled();
    });
});
```

```javascript
// components/Form.jsx
import React, { useState } from 'react';
import Button from './Button';

function Form({ onSubmit }) {
    let [name, setName] = useState('');
    let [email, setEmail] = useState('');
    
    let handleSubmit = (e) => {
        e.preventDefault();
        onSubmit({ name, email });
    };
    
    return (
        <form onSubmit={handleSubmit}>
            <label>
                Name:
                <input
                    type="text"
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                    data-testid="name-input"
                />
            </label>
            <label>
                Email:
                <input
                    type="email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    data-testid="email-input"
                />
            </label>
            <Button type="submit">Submit</Button>
        </form>
    );
}

export default Form;
```

```javascript
// components/Form.test.jsx
import React from 'react';
import { render, screen, fireEvent } from '@testing-library/react';
import '@testing-library/jest-dom';
import Form from './Form';

describe('Form Component', () => {
    test('submits form with data', () => {
        let handleSubmit = jest.fn();
        render(<Form onSubmit={handleSubmit} />);
        
        let nameInput = screen.getByTestId('name-input');
        let emailInput = screen.getByTestId('email-input');
        let submitButton = screen.getByRole('button', { name: 'Submit' });
        
        fireEvent.change(nameInput, { target: { value: 'Alice' } });
        fireEvent.change(emailInput, { target: { value: 'alice@example.com' } });
        fireEvent.click(submitButton);
        
        expect(handleSubmit).toHaveBeenCalledWith({
            name: 'Alice',
            email: 'alice@example.com'
        });
    });
    
    test('updates input values', () => {
        render(<Form onSubmit={jest.fn()} />);
        
        let nameInput = screen.getByTestId('name-input');
        fireEvent.change(nameInput, { target: { value: 'Bob' } });
        
        expect(nameInput.value).toBe('Bob');
    });
});
```

```javascript
// Integration test example
// App.test.jsx
import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom';
import App from './App';

// Mock API
jest.mock('./api', () => ({
    login: jest.fn(),
    getUser: jest.fn()
}));

import { login, getUser } from './api';

describe('App Integration', () => {
    beforeEach(() => {
        login.mockClear();
        getUser.mockClear();
    });
    
    test('complete login flow', async () => {
        login.mockResolvedValue({ token: 'abc123' });
        getUser.mockResolvedValue({ id: 1, name: 'Alice' });
        
        render(<App />);
        
        // Login
        let emailInput = screen.getByLabelText('Email');
        let passwordInput = screen.getByLabelText('Password');
        let loginButton = screen.getByRole('button', { name: 'Login' });
        
        fireEvent.change(emailInput, { target: { value: 'alice@example.com' } });
        fireEvent.change(passwordInput, { target: { value: 'password' } });
        fireEvent.click(loginButton);
        
        // Wait for dashboard
        await waitFor(() => {
            expect(screen.getByText('Welcome, Alice')).toBeInTheDocument();
        });
        
        expect(login).toHaveBeenCalledWith({
            email: 'alice@example.com',
            password: 'password'
        });
    });
});
```

```javascript
// E2E test concepts (Cypress example)
// cypress/e2e/user-flow.cy.js
describe('User Flow', () => {
    it('should complete registration and login', () => {
        // 1. Visit registration page
        cy.visit('http://localhost:3000/register');
        
        // 2. Fill registration form
        cy.get('[data-testid="name"]').type('Alice');
        cy.get('[data-testid="email"]').type('alice@example.com');
        cy.get('[data-testid="password"]').type('password123');
        cy.get('[data-testid="register-button"]').click();
        
        // 3. Verify redirect to login
        cy.url().should('include', '/login');
        
        // 4. Login
        cy.get('[data-testid="email"]').type('alice@example.com');
        cy.get('[data-testid="password"]').type('password123');
        cy.get('[data-testid="login-button"]').click();
        
        // 5. Verify dashboard
        cy.url().should('include', '/dashboard');
        cy.get('[data-testid="dashboard"]').should('be.visible');
    });
});
```

```javascript
// Coverage example
// Run: npm test -- --coverage

// Coverage output shows:
// - Which files are tested
// - Which lines are covered
// - Which branches are covered
// - Which functions are called

// Example:
// File      | % Stmts | % Branch | % Funcs | % Lines
// ----------|---------|----------|---------|--------
// Button.js |   100   |   100    |   100   |   100
// Form.js   |    85   |    75    |    90   |    85
```

**Expected Output** (when running tests):
```
PASS  components/Button.test.jsx
  Button Component
    ✓ renders button with text
    ✓ calls onClick when clicked
    ✓ is disabled when disabled prop is true
    ✓ does not call onClick when disabled

PASS  components/Form.test.jsx
  Form Component
    ✓ submits form with data
    ✓ updates input values

PASS  App.test.jsx
  App Integration
    ✓ complete login flow

Test Suites: 3 passed, 3 total
Tests:       7 passed, 7 total
```

**Challenge (Optional)**:
- Test complex React components
- Write integration tests for your app
- Set up E2E testing
- Achieve high test coverage

---

## Common Mistakes

### 1. Testing Implementation Details

```javascript
// ❌ Bad: Test implementation
test('should use useState', () => {
    // Check if useState is called
});

// ✅ Good: Test behavior
test('should update input value', () => {
    // Test that input value updates
});
```

### 2. Not Waiting for Async

```javascript
// ❌ Bad: Not waiting
test('displays data', () => {
    render(<Component />);
    expect(screen.getByText('Data')).toBeInTheDocument();
    // Might fail if data loads asynchronously
});

// ✅ Good: Wait for async
test('displays data', async () => {
    render(<Component />);
    await waitFor(() => {
        expect(screen.getByText('Data')).toBeInTheDocument();
    });
});
```

### 3. Over-Mocking

```javascript
// ❌ Bad: Mock everything
jest.mock('./api');
jest.mock('./utils');
jest.mock('./services');

// ✅ Good: Mock only what's needed
jest.mock('./api');
// Test real utils and services when possible
```

---

## Key Takeaways

1. **Component Testing**: Test React components in isolation
2. **Integration Testing**: Test components working together
3. **E2E Testing**: Test complete user flows
4. **Coverage**: Measure how much code is tested
5. **Tools**: React Testing Library, Cypress, Playwright
6. **Best Practice**: Test behavior, wait for async, mock wisely
7. **Quality**: Comprehensive testing ensures quality

---

## Quiz: Advanced Testing

Test your understanding with these questions:

1. **React Testing Library:**
   - A) Tests implementation
   - B) Tests behavior
   - C) Both
   - D) Neither

2. **Integration testing:**
   - A) Tests single component
   - B) Tests multiple components
   - C) Tests entire app
   - D) Nothing

3. **E2E testing:**
   - A) Tests from user perspective
   - B) Tests single function
   - C) Both
   - D) Neither

4. **Cypress is for:**
   - A) Unit testing
   - B) E2E testing
   - C) Both
   - D) Neither

5. **Coverage shows:**
   - A) What's tested
   - B) What's not tested
   - C) Both
   - D) Neither

6. **waitFor is used for:**
   - A) Async operations
   - B) Sync operations
   - C) Both
   - D) Neither

7. **data-testid is for:**
   - A) Styling
   - B) Testing selectors
   - C) Both
   - D) Neither

**Answers**:
1. B) Tests behavior
2. B) Tests multiple components
3. A) Tests from user perspective
4. B) E2E testing
5. C) Both
6. A) Async operations
7. B) Testing selectors

---

## Next Steps

Congratulations! You've completed Module 22: Testing. You now know:
- Testing basics and TDD
- Jest framework
- React component testing
- Integration testing
- E2E testing concepts
- Coverage reports

**What's Next?**
- Module 23: Build Tools and Bundlers
- Lesson 23.1: npm and Package Management
- Learn npm basics
- Work with package management

---

## Additional Resources

- **React Testing Library**: [testing-library.com/react](https://testing-library.com/react)
- **Cypress**: [cypress.io](https://cypress.io)
- **Playwright**: [playwright.dev](https://playwright.dev)
- **Jest Coverage**: [jestjs.io/docs/cli#--coverage](https://jestjs.io/docs/cli#--coverage)

---

*Lesson completed! You've finished Module 22: Testing. Ready for Module 23: Build Tools and Bundlers!*

