# Lesson 25.2: Components and Props

## Learning Objectives

By the end of this lesson, you will be able to:
- Create functional components
- Understand class components
- Work with props
- Compose components
- Build reusable components
- Pass data between components
- Structure React applications

---

## Introduction to Components

Components are the building blocks of React applications. They let you split the UI into independent, reusable pieces.

### What are Components?

- **Reusable**: Use components multiple times
- **Independent**: Each component manages its own logic
- **Composable**: Combine components to build UIs
- **Isolated**: Changes in one don't affect others

---

## Functional Components

### Basic Functional Component

```javascript
// Simple functional component
function Welcome() {
    return <h1>Hello, World!</h1>;
}

// Arrow function component
const Welcome = () => {
    return <h1>Hello, World!</h1>;
};

// Usage
function App() {
    return <Welcome />;
}
```

### Component with Props

```javascript
// Component with props
function Welcome(props) {
    return <h1>Hello, {props.name}!</h1>;
}

// Usage
function App() {
    return <Welcome name="Alice" />;
}

// Arrow function with props
const Welcome = (props) => {
    return <h1>Hello, {props.name}!</h1>;
};
```

### Destructuring Props

```javascript
// Destructure props
function Welcome({ name, age }) {
    return (
        <div>
            <h1>Hello, {name}!</h1>
            <p>You are {age} years old</p>
        </div>
    );
}

// Usage
function App() {
    return <Welcome name="Alice" age={30} />;
}
```

---

## Class Components

### Basic Class Component

```javascript
import React, { Component } from 'react';

class Welcome extends Component {
    render() {
        return <h1>Hello, World!</h1>;
    }
}

// Usage
function App() {
    return <Welcome />;
}
```

### Class Component with Props

```javascript
class Welcome extends Component {
    render() {
        return <h1>Hello, {this.props.name}!</h1>;
    }
}

// Usage
function App() {
    return <Welcome name="Alice" />;
}
```

### Note on Class Components

```javascript
// Class components are still supported but
// Functional components with hooks are preferred
// Most new code uses functional components
```

---

## Props

### What are Props?

Props (properties) are data passed from parent to child components.

### Passing Props

```javascript
// Parent component
function App() {
    return (
        <div>
            <User name="Alice" age={30} email="alice@example.com" />
            <User name="Bob" age={25} email="bob@example.com" />
        </div>
    );
}

// Child component
function User({ name, age, email }) {
    return (
        <div>
            <h2>{name}</h2>
            <p>Age: {age}</p>
            <p>Email: {email}</p>
        </div>
    );
}
```

### Props are Read-Only

```javascript
// ❌ Bad: Don't modify props
function User({ name }) {
    name = 'Changed';  // Error: Props are read-only
    return <h1>{name}</h1>;
}

// ✅ Good: Use props as-is
function User({ name }) {
    return <h1>{name}</h1>;
}
```

### Default Props

```javascript
// Default props
function Greeting({ name = 'Guest' }) {
    return <h1>Hello, {name}!</h1>;
}

// Usage
<Greeting />           // Hello, Guest!
<Greeting name="Alice" />  // Hello, Alice!

// Or with defaultProps (class components)
class Greeting extends Component {
    static defaultProps = {
        name: 'Guest'
    };
    
    render() {
        return <h1>Hello, {this.props.name}!</h1>;
    }
}
```

### PropTypes (Type Checking)

```javascript
import PropTypes from 'prop-types';

function User({ name, age, email }) {
    return (
        <div>
            <h2>{name}</h2>
            <p>Age: {age}</p>
            <p>Email: {email}</p>
        </div>
    );
}

User.propTypes = {
    name: PropTypes.string.isRequired,
    age: PropTypes.number.isRequired,
    email: PropTypes.string.isRequired
};
```

---

## Component Composition

### Composing Components

```javascript
// Small components
function Header({ title }) {
    return <header><h1>{title}</h1></header>;
}

function Content({ children }) {
    return <main>{children}</main>;
}

function Footer({ text }) {
    return <footer><p>{text}</p></footer>;
}

// Compose into larger component
function Page() {
    return (
        <div>
            <Header title="My Page" />
            <Content>
                <p>Page content goes here</p>
            </Content>
            <Footer text="Copyright 2024" />
        </div>
    );
}
```

### Children Prop

```javascript
// Component with children
function Container({ children, title }) {
    return (
        <div className="container">
            <h2>{title}</h2>
            {children}
        </div>
    );
}

// Usage
function App() {
    return (
        <Container title="My Container">
            <p>This is the content</p>
            <button>Click me</button>
        </Container>
    );
}
```

### Component Reusability

```javascript
// Reusable Button component
function Button({ text, onClick, variant = 'primary' }) {
    return (
        <button 
            className={`btn btn-${variant}`}
            onClick={onClick}
        >
            {text}
        </button>
    );
}

// Usage
function App() {
    return (
        <div>
            <Button text="Submit" onClick={() => alert('Submitted')} />
            <Button text="Cancel" variant="secondary" onClick={() => alert('Cancelled')} />
            <Button text="Delete" variant="danger" onClick={() => alert('Deleted')} />
        </div>
    );
}
```

---

## Practical Examples

### Example 1: Card Component

```javascript
function Card({ title, description, image }) {
    return (
        <div className="card">
            {image && <img src={image} alt={title} />}
            <div className="card-content">
                <h3>{title}</h3>
                <p>{description}</p>
            </div>
        </div>
    );
}

// Usage
function App() {
    return (
        <div className="card-grid">
            <Card 
                title="React"
                description="A JavaScript library"
                image="/react-logo.png"
            />
            <Card 
                title="Vue"
                description="A progressive framework"
                image="/vue-logo.png"
            />
        </div>
    );
}
```

### Example 2: List Component

```javascript
function List({ items, renderItem }) {
    return (
        <ul>
            {items.map((item, index) => (
                <li key={index}>
                    {renderItem(item)}
                </li>
            ))}
        </ul>
    );
}

// Usage
function App() {
    let users = [
        { id: 1, name: 'Alice', age: 30 },
        { id: 2, name: 'Bob', age: 25 }
    ];
    
    return (
        <List 
            items={users}
            renderItem={(user) => (
                <div>
                    <strong>{user.name}</strong> - {user.age} years old
                </div>
            )}
        />
    );
}
```

### Example 3: Layout Component

```javascript
function Layout({ header, sidebar, main, footer }) {
    return (
        <div className="layout">
            <header>{header}</header>
            <div className="layout-body">
                <aside>{sidebar}</aside>
                <main>{main}</main>
            </div>
            <footer>{footer}</footer>
        </div>
    );
}

// Usage
function App() {
    return (
        <Layout
            header={<h1>My App</h1>}
            sidebar={<nav>Navigation</nav>}
            main={<div>Main content</div>}
            footer={<p>Footer</p>}
        />
    );
}
```

---

## Practice Exercise

### Exercise: Building Components

**Objective**: Practice creating functional components, working with props, and composing components.

**Instructions**:

1. Create a React project
2. Create multiple components
3. Practice:
   - Creating functional components
   - Passing and using props
   - Composing components
   - Building reusable components

**Example Solution**:

```javascript
// src/components/Button.jsx
import React from 'react';

function Button({ text, onClick, variant = 'primary', disabled = false }) {
    return (
        <button 
            className={`btn btn-${variant}`}
            onClick={onClick}
            disabled={disabled}
        >
            {text}
        </button>
    );
}

export default Button;
```

```javascript
// src/components/Card.jsx
import React from 'react';

function Card({ title, description, image, children }) {
    return (
        <div className="card">
            {image && <img src={image} alt={title} className="card-image" />}
            <div className="card-content">
                <h3 className="card-title">{title}</h3>
                {description && <p className="card-description">{description}</p>}
                {children}
            </div>
        </div>
    );
}

export default Card;
```

```javascript
// src/components/UserCard.jsx
import React from 'react';
import Card from './Card';
import Button from './Button';

function UserCard({ user, onEdit, onDelete }) {
    return (
        <Card 
            title={user.name}
            description={`Age: ${user.age} | Email: ${user.email}`}
        >
            <div className="card-actions">
                <Button text="Edit" onClick={() => onEdit(user.id)} variant="secondary" />
                <Button text="Delete" onClick={() => onDelete(user.id)} variant="danger" />
            </div>
        </Card>
    );
}

export default UserCard;
```

```javascript
// src/components/UserList.jsx
import React from 'react';
import UserCard from './UserCard';

function UserList({ users, onEdit, onDelete }) {
    if (users.length === 0) {
        return <p>No users found</p>;
    }
    
    return (
        <div className="user-list">
            {users.map(user => (
                <UserCard 
                    key={user.id}
                    user={user}
                    onEdit={onEdit}
                    onDelete={onDelete}
                />
            ))}
        </div>
    );
}

export default UserList;
```

```javascript
// src/components/Header.jsx
import React from 'react';

function Header({ title, subtitle }) {
    return (
        <header className="header">
            <h1>{title}</h1>
            {subtitle && <p className="subtitle">{subtitle}</p>}
        </header>
    );
}

export default Header;
```

```javascript
// src/components/Layout.jsx
import React from 'react';

function Layout({ header, children, footer }) {
    return (
        <div className="layout">
            {header && <header>{header}</header>}
            <main className="main-content">
                {children}
            </main>
            {footer && <footer>{footer}</footer>}
        </div>
    );
}

export default Layout;
```

```javascript
// src/App.jsx
import React from 'react';
import Layout from './components/Layout';
import Header from './components/Header';
import UserList from './components/UserList';
import Button from './components/Button';
import './App.css';

function App() {
    const users = [
        { id: 1, name: 'Alice', age: 30, email: 'alice@example.com' },
        { id: 2, name: 'Bob', age: 25, email: 'bob@example.com' },
        { id: 3, name: 'Charlie', age: 35, email: 'charlie@example.com' }
    ];
    
    const handleEdit = (userId) => {
        console.log('Edit user:', userId);
        alert(`Editing user ${userId}`);
    };
    
    const handleDelete = (userId) => {
        console.log('Delete user:', userId);
        if (confirm('Are you sure?')) {
            alert(`Deleting user ${userId}`);
        }
    };
    
    return (
        <Layout
            header={
                <Header 
                    title="User Management"
                    subtitle="Manage your users"
                />
            }
            footer={
                <div className="footer">
                    <p>&copy; 2024 My App</p>
                </div>
            }
        >
            <div className="app-content">
                <div className="actions">
                    <Button 
                        text="Add User" 
                        onClick={() => alert('Add user')}
                        variant="primary"
                    />
                </div>
                
                <UserList 
                    users={users}
                    onEdit={handleEdit}
                    onDelete={handleDelete}
                />
            </div>
        </Layout>
    );
}

export default App;
```

```css
/* src/App.css */
.layout {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.main-content {
    flex: 1;
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
}

.header {
    background-color: #282c34;
    color: white;
    padding: 20px;
    text-align: center;
}

.header h1 {
    margin: 0;
    color: #61dafb;
}

.subtitle {
    margin: 10px 0 0 0;
    opacity: 0.8;
}

.app-content {
    padding: 20px;
}

.actions {
    margin-bottom: 20px;
}

.footer {
    background-color: #282c34;
    color: white;
    padding: 10px;
    text-align: center;
}

.user-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.card {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.card-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.card-content {
    padding: 15px;
}

.card-title {
    margin: 0 0 10px 0;
    color: #333;
}

.card-description {
    margin: 0 0 15px 0;
    color: #666;
}

.card-actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.2s;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background-color: #545b62;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn-danger:hover {
    background-color: #c82333;
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
```

**Expected Output** (in browser):
- Layout with header and footer
- User list with cards
- Interactive buttons
- Styled components

**Challenge (Optional)**:
- Build a complete component library
- Create complex component compositions
- Add PropTypes validation
- Build a real application

---

## Common Mistakes

### 1. Modifying Props

```javascript
// ❌ Bad: Modify props
function User({ name }) {
    name = name.toUpperCase();  // Error
    return <h1>{name}</h1>;
}

// ✅ Good: Use props as-is or create new variable
function User({ name }) {
    const upperName = name.toUpperCase();
    return <h1>{upperName}</h1>;
}
```

### 2. Missing Keys in Lists

```javascript
// ❌ Bad: No key
{users.map(user => <UserCard user={user} />)}

// ✅ Good: With key
{users.map(user => <UserCard key={user.id} user={user} />)}
```

### 3. Not Destructuring Props

```javascript
// ❌ Bad: Access via props object
function User(props) {
    return <h1>{props.name}</h1>;
}

// ✅ Good: Destructure props
function User({ name }) {
    return <h1>{name}</h1>;
}
```

---

## Key Takeaways

1. **Components**: Building blocks of React apps
2. **Functional Components**: Preferred way (with hooks)
3. **Props**: Data passed from parent to child
4. **Props are Read-Only**: Don't modify props
5. **Composition**: Combine components to build UIs
6. **Reusability**: Create reusable components
7. **Best Practice**: Destructure props, add keys, use functional components

---

## Quiz: Components

Test your understanding with these questions:

1. **Components are:**
   - A) Reusable
   - B) Independent
   - C) Both
   - D) Neither

2. **Props are:**
   - A) Read-only
   - B) Mutable
   - C) Both
   - D) Neither

3. **Functional components:**
   - A) Preferred
   - B) Deprecated
   - C) Both
   - D) Neither

4. **Props passed:**
   - A) Parent to child
   - B) Child to parent
   - C) Both
   - D) Neither

5. **children prop:**
   - A) Special prop
   - B) Regular prop
   - C) Both
   - D) Neither

6. **Component composition:**
   - A) Combining components
   - B) Separating components
   - C) Both
   - D) Neither

7. **Keys in lists:**
   - A) Required
   - B) Optional
   - C) Both
   - D) Neither

**Answers**:
1. C) Both
2. A) Read-only
3. A) Preferred
4. A) Parent to child
5. A) Special prop
6. A) Combining components
7. A) Required

---

## Next Steps

Congratulations! You've learned components and props. You now know:
- How to create functional components
- How to work with props
- How to compose components
- How to build reusable components

**What's Next?**
- Lesson 25.3: State and Events
- Learn useState hook
- Handle events in React
- Work with controlled components

---

## Additional Resources

- **React Components**: [react.dev/learn/your-first-component](https://react.dev/learn/your-first-component)
- **Props**: [react.dev/learn/passing-props-to-a-component](https://react.dev/learn/passing-props-to-a-component)
- **Component Composition**: [react.dev/learn/passing-data-deeply-with-context](https://react.dev/learn/passing-data-deeply-with-context)

---

*Lesson completed! You're ready to move on to the next lesson.*

