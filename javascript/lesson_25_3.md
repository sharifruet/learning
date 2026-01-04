# Lesson 25.3: State and Events

## Learning Objectives

By the end of this lesson, you will be able to:
- Use useState hook
- Handle events in React
- Create controlled components
- Lift state up
- Manage component state
- Build interactive components
- Create dynamic UIs

---

## Introduction to State

State is data that can change over time. When state changes, React re-renders the component.

### What is State?

- **Dynamic Data**: Data that can change
- **Component Memory**: Remembers values between renders
- **Triggers Re-render**: Component updates when state changes
- **Local to Component**: Each component has its own state

### State vs Props

```javascript
// Props: Passed from parent (read-only)
function User({ name }) {
    return <h1>{name}</h1>;  // name comes from props
}

// State: Managed by component (can change)
function Counter() {
    const [count, setCount] = useState(0);  // count is state
    return <h1>{count}</h1>;
}
```

---

## useState Hook

### Basic useState

```javascript
import { useState } from 'react';

function Counter() {
    const [count, setCount] = useState(0);
    
    return (
        <div>
            <p>Count: {count}</p>
            <button onClick={() => setCount(count + 1)}>
                Increment
            </button>
        </div>
    );
}
```

### useState Syntax

```javascript
// useState returns array: [value, setter]
const [state, setState] = useState(initialValue);

// Example
const [name, setName] = useState('Alice');
const [age, setAge] = useState(30);
const [isActive, setIsActive] = useState(true);
```

### Updating State

```javascript
function Counter() {
    const [count, setCount] = useState(0);
    
    // Direct update
    const increment = () => {
        setCount(count + 1);
    };
    
    // Functional update (when new state depends on old)
    const increment = () => {
        setCount(prevCount => prevCount + 1);
    };
    
    // Multiple updates
    const reset = () => {
        setCount(0);
    };
    
    return (
        <div>
            <p>Count: {count}</p>
            <button onClick={increment}>Increment</button>
            <button onClick={reset}>Reset</button>
        </div>
    );
}
```

### Multiple State Variables

```javascript
function UserForm() {
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [age, setAge] = useState(0);
    
    return (
        <form>
            <input 
                value={name}
                onChange={(e) => setName(e.target.value)}
                placeholder="Name"
            />
            <input 
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                placeholder="Email"
            />
            <input 
                type="number"
                value={age}
                onChange={(e) => setAge(parseInt(e.target.value))}
                placeholder="Age"
            />
        </form>
    );
}
```

### State with Objects

```javascript
function UserProfile() {
    const [user, setUser] = useState({
        name: '',
        email: '',
        age: 0
    });
    
    // Update object state
    const updateName = (name) => {
        setUser({ ...user, name });  // Spread operator
    };
    
    const updateEmail = (email) => {
        setUser(prevUser => ({ ...prevUser, email }));
    };
    
    return (
        <div>
            <input 
                value={user.name}
                onChange={(e) => updateName(e.target.value)}
            />
            <input 
                value={user.email}
                onChange={(e) => updateEmail(e.target.value)}
            />
        </div>
    );
}
```

### State with Arrays

```javascript
function TodoList() {
    const [todos, setTodos] = useState([]);
    const [input, setInput] = useState('');
    
    const addTodo = () => {
        if (input.trim()) {
            setTodos([...todos, input]);
            setInput('');
        }
    };
    
    const removeTodo = (index) => {
        setTodos(todos.filter((_, i) => i !== index));
    };
    
    return (
        <div>
            <input 
                value={input}
                onChange={(e) => setInput(e.target.value)}
            />
            <button onClick={addTodo}>Add</button>
            <ul>
                {todos.map((todo, index) => (
                    <li key={index}>
                        {todo}
                        <button onClick={() => removeTodo(index)}>Remove</button>
                    </li>
                ))}
            </ul>
        </div>
    );
}
```

---

## Event Handling

### Basic Event Handling

```javascript
function Button() {
    const handleClick = () => {
        console.log('Button clicked!');
    };
    
    return <button onClick={handleClick}>Click me</button>;
}
```

### Event Object

```javascript
function Input() {
    const handleChange = (event) => {
        console.log('Value:', event.target.value);
    };
    
    return <input onChange={handleChange} />;
}
```

### Common Events

```javascript
function EventExamples() {
    const handleClick = () => console.log('Clicked');
    const handleChange = (e) => console.log('Changed:', e.target.value);
    const handleSubmit = (e) => {
        e.preventDefault();
        console.log('Submitted');
    };
    const handleMouseEnter = () => console.log('Mouse entered');
    const handleMouseLeave = () => console.log('Mouse left');
    const handleFocus = () => console.log('Focused');
    const handleBlur = () => console.log('Blurred');
    
    return (
        <div>
            <button onClick={handleClick}>Click</button>
            <input onChange={handleChange} />
            <form onSubmit={handleSubmit}>
                <button type="submit">Submit</button>
            </form>
            <div 
                onMouseEnter={handleMouseEnter}
                onMouseLeave={handleMouseLeave}
            >
                Hover me
            </div>
            <input 
                onFocus={handleFocus}
                onBlur={handleBlur}
            />
        </div>
    );
}
```

### Passing Arguments

```javascript
function TodoList() {
    const [todos, setTodos] = useState(['Task 1', 'Task 2']);
    
    const handleRemove = (index) => {
        setTodos(todos.filter((_, i) => i !== index));
    };
    
    return (
        <ul>
            {todos.map((todo, index) => (
                <li key={index}>
                    {todo}
                    <button onClick={() => handleRemove(index)}>
                        Remove
                    </button>
                </li>
            ))}
        </ul>
    );
}
```

---

## Controlled Components

### What are Controlled Components?

Controlled components have their value controlled by React state.

### Input Example

```javascript
function ControlledInput() {
    const [value, setValue] = useState('');
    
    const handleChange = (e) => {
        setValue(e.target.value);
    };
    
    return (
        <input 
            type="text"
            value={value}
            onChange={handleChange}
        />
    );
}
```

### Form Example

```javascript
function LoginForm() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    
    const handleSubmit = (e) => {
        e.preventDefault();
        console.log('Email:', email);
        console.log('Password:', password);
        // Handle login
    };
    
    return (
        <form onSubmit={handleSubmit}>
            <input
                type="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                placeholder="Email"
            />
            <input
                type="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                placeholder="Password"
            />
            <button type="submit">Login</button>
        </form>
    );
}
```

### Select Example

```javascript
function SelectExample() {
    const [selected, setSelected] = useState('');
    
    return (
        <select value={selected} onChange={(e) => setSelected(e.target.value)}>
            <option value="">Choose...</option>
            <option value="option1">Option 1</option>
            <option value="option2">Option 2</option>
            <option value="option3">Option 3</option>
        </select>
    );
}
```

---

## Lifting State Up

### What is Lifting State Up?

Moving state from child to parent component so multiple children can share it.

### Example: Temperature Converter

```javascript
// Child component
function TemperatureInput({ temperature, scale, onTemperatureChange }) {
    return (
        <fieldset>
            <legend>Enter temperature in {scale}:</legend>
            <input
                value={temperature}
                onChange={(e) => onTemperatureChange(e.target.value)}
            />
        </fieldset>
    );
}

// Parent component
function Calculator() {
    const [celsius, setCelsius] = useState('');
    const [fahrenheit, setFahrenheit] = useState('');
    
    const handleCelsiusChange = (value) => {
        setCelsius(value);
        setFahrenheit(value ? (parseFloat(value) * 9 / 5 + 32).toString() : '');
    };
    
    const handleFahrenheitChange = (value) => {
        setFahrenheit(value);
        setCelsius(value ? ((parseFloat(value) - 32) * 5 / 9).toString() : '');
    };
    
    return (
        <div>
            <TemperatureInput
                scale="celsius"
                temperature={celsius}
                onTemperatureChange={handleCelsiusChange}
            />
            <TemperatureInput
                scale="fahrenheit"
                temperature={fahrenheit}
                onTemperatureChange={handleFahrenheitChange}
            />
        </div>
    );
}
```

### Example: Shared Counter

```javascript
// Child component
function Counter({ count, onIncrement, onDecrement }) {
    return (
        <div>
            <p>Count: {count}</p>
            <button onClick={onIncrement}>+</button>
            <button onClick={onDecrement}>-</button>
        </div>
    );
}

// Parent component
function App() {
    const [count, setCount] = useState(0);
    
    return (
        <div>
            <Counter
                count={count}
                onIncrement={() => setCount(count + 1)}
                onDecrement={() => setCount(count - 1)}
            />
            <p>Total: {count}</p>
        </div>
    );
}
```

---

## Practice Exercise

### Exercise: State Management

**Objective**: Practice using useState, handling events, creating controlled components, and lifting state up.

**Instructions**:

1. Create a React project
2. Build interactive components
3. Practice:
   - Using useState hook
   - Handling events
   - Creating controlled components
   - Lifting state up

**Example Solution**:

```javascript
// src/components/Counter.jsx
import React, { useState } from 'react';

function Counter() {
    const [count, setCount] = useState(0);
    
    const increment = () => setCount(count + 1);
    const decrement = () => setCount(count - 1);
    const reset = () => setCount(0);
    
    return (
        <div className="counter">
            <h2>Counter</h2>
            <p className="count-display">Count: {count}</p>
            <div className="buttons">
                <button onClick={decrement}>-</button>
                <button onClick={reset}>Reset</button>
                <button onClick={increment}>+</button>
            </div>
        </div>
    );
}

export default Counter;
```

```javascript
// src/components/Form.jsx
import React, { useState } from 'react';

function Form({ onSubmit }) {
    const [formData, setFormData] = useState({
        name: '',
        email: '',
        message: ''
    });
    
    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };
    
    const handleSubmit = (e) => {
        e.preventDefault();
        onSubmit(formData);
        setFormData({ name: '', email: '', message: '' });
    };
    
    return (
        <form onSubmit={handleSubmit} className="form">
            <div className="form-group">
                <label>Name:</label>
                <input
                    type="text"
                    name="name"
                    value={formData.name}
                    onChange={handleChange}
                    required
                />
            </div>
            <div className="form-group">
                <label>Email:</label>
                <input
                    type="email"
                    name="email"
                    value={formData.email}
                    onChange={handleChange}
                    required
                />
            </div>
            <div className="form-group">
                <label>Message:</label>
                <textarea
                    name="message"
                    value={formData.message}
                    onChange={handleChange}
                    required
                />
            </div>
            <button type="submit">Submit</button>
        </form>
    );
}

export default Form;
```

```javascript
// src/components/TodoList.jsx
import React, { useState } from 'react';

function TodoList() {
    const [todos, setTodos] = useState([]);
    const [input, setInput] = useState('');
    
    const addTodo = (e) => {
        e.preventDefault();
        if (input.trim()) {
            setTodos([...todos, {
                id: Date.now(),
                text: input,
                completed: false
            }]);
            setInput('');
        }
    };
    
    const toggleTodo = (id) => {
        setTodos(todos.map(todo =>
            todo.id === id ? { ...todo, completed: !todo.completed } : todo
        ));
    };
    
    const removeTodo = (id) => {
        setTodos(todos.filter(todo => todo.id !== id));
    };
    
    return (
        <div className="todo-list">
            <h2>Todo List</h2>
            <form onSubmit={addTodo}>
                <input
                    value={input}
                    onChange={(e) => setInput(e.target.value)}
                    placeholder="Add todo..."
                />
                <button type="submit">Add</button>
            </form>
            <ul>
                {todos.map(todo => (
                    <li key={todo.id} className={todo.completed ? 'completed' : ''}>
                        <input
                            type="checkbox"
                            checked={todo.completed}
                            onChange={() => toggleTodo(todo.id)}
                        />
                        <span>{todo.text}</span>
                        <button onClick={() => removeTodo(todo.id)}>Remove</button>
                    </li>
                ))}
            </ul>
        </div>
    );
}

export default TodoList;
```

```javascript
// src/components/ColorPicker.jsx
import React, { useState } from 'react';

function ColorPicker() {
    const [color, setColor] = useState('#000000');
    const [colors, setColors] = useState([]);
    
    const handleColorChange = (e) => {
        setColor(e.target.value);
    };
    
    const saveColor = () => {
        setColors([...colors, color]);
    };
    
    return (
        <div className="color-picker">
            <h2>Color Picker</h2>
            <div className="picker-controls">
                <input
                    type="color"
                    value={color}
                    onChange={handleColorChange}
                />
                <button onClick={saveColor}>Save Color</button>
            </div>
            <div 
                className="color-preview"
                style={{ backgroundColor: color }}
            >
                Selected Color
            </div>
            <div className="saved-colors">
                <h3>Saved Colors:</h3>
                {colors.map((c, index) => (
                    <div
                        key={index}
                        className="saved-color"
                        style={{ backgroundColor: c }}
                        onClick={() => setColor(c)}
                    />
                ))}
            </div>
        </div>
    );
}

export default ColorPicker;
```

```javascript
// src/components/SharedStateExample.jsx
import React, { useState } from 'react';

// Child component
function Counter({ count, onIncrement, onDecrement, label }) {
    return (
        <div className="counter">
            <h3>{label}</h3>
            <p>Count: {count}</p>
            <button onClick={onIncrement}>+</button>
            <button onClick={onDecrement}>-</button>
        </div>
    );
}

// Parent component
function SharedStateExample() {
    const [count, setCount] = useState(0);
    
    return (
        <div className="shared-state">
            <h2>Shared State Example</h2>
            <p>Total: {count}</p>
            <div className="counters">
                <Counter
                    label="Counter 1"
                    count={count}
                    onIncrement={() => setCount(count + 1)}
                    onDecrement={() => setCount(count - 1)}
                />
                <Counter
                    label="Counter 2"
                    count={count}
                    onIncrement={() => setCount(count + 1)}
                    onDecrement={() => setCount(count - 1)}
                />
            </div>
        </div>
    );
}

export default SharedStateExample;
```

```javascript
// src/App.jsx
import React, { useState } from 'react';
import Counter from './components/Counter';
import Form from './components/Form';
import TodoList from './components/TodoList';
import ColorPicker from './components/ColorPicker';
import SharedStateExample from './components/SharedStateExample';
import './App.css';

function App() {
    const [submissions, setSubmissions] = useState([]);
    
    const handleFormSubmit = (data) => {
        setSubmissions([...submissions, data]);
        alert('Form submitted!');
    };
    
    return (
        <div className="App">
            <header>
                <h1>React State and Events Practice</h1>
            </header>
            
            <main>
                <section>
                    <Counter />
                </section>
                
                <section>
                    <h2>Contact Form</h2>
                    <Form onSubmit={handleFormSubmit} />
                    {submissions.length > 0 && (
                        <div className="submissions">
                            <h3>Submissions:</h3>
                            {submissions.map((sub, index) => (
                                <div key={index} className="submission">
                                    <p><strong>{sub.name}</strong> ({sub.email})</p>
                                    <p>{sub.message}</p>
                                </div>
                            ))}
                        </div>
                    )}
                </section>
                
                <section>
                    <TodoList />
                </section>
                
                <section>
                    <ColorPicker />
                </section>
                
                <section>
                    <SharedStateExample />
                </section>
            </main>
        </div>
    );
}

export default App;
```

```css
/* src/App.css */
.App {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

header {
    text-align: center;
    margin-bottom: 30px;
}

section {
    margin-bottom: 40px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.counter {
    text-align: center;
}

.count-display {
    font-size: 24px;
    font-weight: bold;
    margin: 20px 0;
}

.buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
}

button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #0056b3;
}

.form {
    max-width: 400px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.todo-list ul {
    list-style: none;
    padding: 0;
}

.todo-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    margin: 5px 0;
    background-color: #f5f5f5;
    border-radius: 4px;
}

.todo-list li.completed span {
    text-decoration: line-through;
    opacity: 0.6;
}

.color-picker {
    max-width: 400px;
}

.picker-controls {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.color-preview {
    width: 100%;
    height: 100px;
    border: 2px solid #ddd;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

.saved-colors {
    margin-top: 20px;
}

.saved-color {
    width: 50px;
    height: 50px;
    border: 2px solid #ddd;
    border-radius: 4px;
    display: inline-block;
    margin: 5px;
    cursor: pointer;
}

.shared-state .counters {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.submissions {
    margin-top: 20px;
}

.submission {
    padding: 10px;
    margin: 10px 0;
    background-color: #f0f0f0;
    border-radius: 4px;
}
```

**Expected Output** (in browser):
- Interactive counter
- Working form with controlled inputs
- Todo list with add/remove/toggle
- Color picker with saved colors
- Shared state example

**Challenge (Optional)**:
- Build a complete interactive app
- Create complex state management
- Build forms with validation
- Practice lifting state up

---

## Common Mistakes

### 1. Mutating State Directly

```javascript
// ❌ Bad: Mutate state
const [items, setItems] = useState([1, 2, 3]);
items.push(4);  // Don't do this!

// ✅ Good: Create new array
const [items, setItems] = useState([1, 2, 3]);
setItems([...items, 4]);
```

### 2. Not Using Functional Updates

```javascript
// ❌ Bad: When state depends on previous state
const increment = () => {
    setCount(count + 1);
    setCount(count + 1);  // Only increments once!
};

// ✅ Good: Use functional update
const increment = () => {
    setCount(prev => prev + 1);
    setCount(prev => prev + 1);  // Increments twice!
};
```

### 3. Forgetting to Prevent Default

```javascript
// ❌ Bad: Form submits and page reloads
const handleSubmit = () => {
    // Process form
};

// ✅ Good: Prevent default
const handleSubmit = (e) => {
    e.preventDefault();
    // Process form
};
```

---

## Key Takeaways

1. **useState**: Hook for managing state
2. **State Updates**: Trigger re-renders
3. **Events**: Handle user interactions
4. **Controlled Components**: Value controlled by state
5. **Lifting State**: Move state to common ancestor
6. **Best Practice**: Don't mutate state, use functional updates
7. **Patterns**: Controlled inputs, event handlers, state lifting

---

## Quiz: State and Events

Test your understanding with these questions:

1. **useState returns:**
   - A) [value, setter]
   - B) {value, setter}
   - C) value only
   - D) Nothing

2. **State changes:**
   - A) Trigger re-render
   - B) Don't trigger re-render
   - C) Both
   - D) Neither

3. **Controlled component:**
   - A) Value from state
   - B) Value from DOM
   - C) Both
   - D) Neither

4. **Event handlers:**
   - A) Handle user interactions
   - B) Handle state
   - C) Both
   - D) Neither

5. **Lifting state:**
   - A) Move to parent
   - B) Move to child
   - C) Both
   - D) Neither

6. **State should be:**
   - A) Immutable
   - B) Mutable
   - C) Both
   - D) Neither

7. **Functional update:**
   - A) Uses previous state
   - B) Uses current state
   - C) Both
   - D) Neither

**Answers**:
1. A) [value, setter]
2. A) Trigger re-render
3. A) Value from state
4. A) Handle user interactions
5. A) Move to parent
6. A) Immutable
7. A) Uses previous state

---

## Next Steps

Congratulations! You've completed Module 25: React Basics. You now know:
- React introduction and JSX
- Components and props
- State and events
- How to build interactive React apps

**What's Next?**
- Module 26: React Advanced
- Lesson 26.1: React Hooks
- Learn useEffect, useContext, useReducer
- Build custom hooks

---

## Additional Resources

- **React State**: [react.dev/learn/state-a-components-memory](https://react.dev/learn/state-a-components-memory)
- **Events**: [react.dev/learn/responding-to-events](https://react.dev/learn/responding-to-events)
- **Controlled Components**: [react.dev/reference/react-dom/components/input#controlling-an-input-with-a-state-variable](https://react.dev/reference/react-dom/components/input#controlling-an-input-with-a-state-variable)

---

*Lesson completed! You've finished Module 25: React Basics. Ready for Module 26: React Advanced!*

