# Lesson 26.1: React Hooks

## Learning Objectives

By the end of this lesson, you will be able to:
- Use useEffect hook
- Use useContext hook
- Use useReducer hook
- Create custom hooks
- Manage side effects
- Share context across components
- Handle complex state logic
- Build reusable hook logic

---

## Introduction to Hooks

Hooks are functions that let you "hook into" React features from functional components.

### What are Hooks?

- **Functional Components**: Use state and lifecycle in functions
- **Reusable Logic**: Share stateful logic between components
- **No Classes**: Don't need class components
- **Rules**: Only call at top level, only in React functions

### Built-in Hooks

```javascript
// State
useState        // Manage state
useReducer      // Complex state logic

// Effects
useEffect       // Side effects
useLayoutEffect // Synchronous effects

// Context
useContext      // Access context

// Refs
useRef          // DOM refs
useImperativeHandle // Custom refs

// Performance
useMemo         // Memoize values
useCallback     // Memoize functions

// Custom
// Create your own hooks
```

---

## useEffect Hook

### What is useEffect?

useEffect lets you perform side effects in functional components.

### Basic useEffect

```javascript
import { useState, useEffect } from 'react';

function Counter() {
    const [count, setCount] = useState(0);
    
    // Runs after every render
    useEffect(() => {
        document.title = `Count: ${count}`;
    });
    
    return (
        <div>
            <p>Count: {count}</p>
            <button onClick={() => setCount(count + 1)}>Increment</button>
        </div>
    );
}
```

### useEffect with Dependencies

```javascript
// Runs only on mount
useEffect(() => {
    console.log('Component mounted');
}, []);  // Empty dependency array

// Runs when count changes
useEffect(() => {
    console.log('Count changed:', count);
}, [count]);  // Dependency array

// Runs when count or name changes
useEffect(() => {
    console.log('Count or name changed');
}, [count, name]);
```

### Cleanup Function

```javascript
function Timer() {
    const [seconds, setSeconds] = useState(0);
    
    useEffect(() => {
        const interval = setInterval(() => {
            setSeconds(prev => prev + 1);
        }, 1000);
        
        // Cleanup function
        return () => {
            clearInterval(interval);
        };
    }, []);  // Run once on mount
    
    return <div>Seconds: {seconds}</div>;
}
```

### Fetching Data

```javascript
function UserProfile({ userId }) {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    
    useEffect(() => {
        // Reset state
        setLoading(true);
        setError(null);
        
        // Fetch data
        fetch(`/api/users/${userId}`)
            .then(response => response.json())
            .then(data => {
                setUser(data);
                setLoading(false);
            })
            .catch(err => {
                setError(err.message);
                setLoading(false);
            });
    }, [userId]);  // Re-fetch when userId changes
    
    if (loading) return <div>Loading...</div>;
    if (error) return <div>Error: {error}</div>;
    if (!user) return <div>No user found</div>;
    
    return (
        <div>
            <h1>{user.name}</h1>
            <p>{user.email}</p>
        </div>
    );
}
```

### Multiple useEffect Hooks

```javascript
function Component() {
    const [count, setCount] = useState(0);
    const [name, setName] = useState('');
    
    // Separate effects for different concerns
    useEffect(() => {
        document.title = `Count: ${count}`;
    }, [count]);
    
    useEffect(() => {
        console.log('Name changed:', name);
    }, [name]);
    
    useEffect(() => {
        // Setup
        console.log('Component mounted');
        
        return () => {
            // Cleanup
            console.log('Component unmounted');
        };
    }, []);
    
    return <div>...</div>;
}
```

---

## useContext Hook

### What is useContext?

useContext lets you access context values without prop drilling.

### Creating Context

```javascript
import { createContext, useContext } from 'react';

// Create context
const ThemeContext = createContext('light');

// Provider component
function ThemeProvider({ children }) {
    const [theme, setTheme] = useState('light');
    
    return (
        <ThemeContext.Provider value={{ theme, setTheme }}>
            {children}
        </ThemeContext.Provider>
    );
}

// Custom hook to use context
function useTheme() {
    const context = useContext(ThemeContext);
    if (!context) {
        throw new Error('useTheme must be used within ThemeProvider');
    }
    return context;
}
```

### Using Context

```javascript
// Child component
function Button() {
    const { theme, setTheme } = useTheme();
    
    return (
        <button 
            className={`btn btn-${theme}`}
            onClick={() => setTheme(theme === 'light' ? 'dark' : 'light')}
        >
            Toggle Theme
        </button>
    );
}

// App component
function App() {
    return (
        <ThemeProvider>
            <Button />
        </ThemeProvider>
    );
}
```

### Multiple Contexts

```javascript
// Theme context
const ThemeContext = createContext();

// User context
const UserContext = createContext();

function App() {
    return (
        <ThemeProvider>
            <UserProvider>
                <Component />
            </UserProvider>
        </ThemeProvider>
    );
}

function Component() {
    const theme = useContext(ThemeContext);
    const user = useContext(UserContext);
    
    return <div>...</div>;
}
```

### Context Example: User Authentication

```javascript
// AuthContext.jsx
import { createContext, useContext, useState, useEffect } from 'react';

const AuthContext = createContext();

export function AuthProvider({ children }) {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);
    
    useEffect(() => {
        // Check if user is logged in
        const savedUser = localStorage.getItem('user');
        if (savedUser) {
            setUser(JSON.parse(savedUser));
        }
        setLoading(false);
    }, []);
    
    const login = (userData) => {
        setUser(userData);
        localStorage.setItem('user', JSON.stringify(userData));
    };
    
    const logout = () => {
        setUser(null);
        localStorage.removeItem('user');
    };
    
    return (
        <AuthContext.Provider value={{ user, login, logout, loading }}>
            {children}
        </AuthContext.Provider>
    );
}

export function useAuth() {
    const context = useContext(AuthContext);
    if (!context) {
        throw new Error('useAuth must be used within AuthProvider');
    }
    return context;
}
```

```javascript
// Using AuthContext
function LoginButton() {
    const { user, login, logout } = useAuth();
    
    if (user) {
        return (
            <div>
                <p>Welcome, {user.name}!</p>
                <button onClick={logout}>Logout</button>
            </div>
        );
    }
    
    return (
        <button onClick={() => login({ name: 'Alice', id: 1 })}>
            Login
        </button>
    );
}
```

---

## useReducer Hook

### What is useReducer?

useReducer is an alternative to useState for managing complex state logic.

### Basic useReducer

```javascript
import { useReducer } from 'react';

// Reducer function
function counterReducer(state, action) {
    switch (action.type) {
        case 'increment':
            return { count: state.count + 1 };
        case 'decrement':
            return { count: state.count - 1 };
        case 'reset':
            return { count: 0 };
        default:
            return state;
    }
}

function Counter() {
    const [state, dispatch] = useReducer(counterReducer, { count: 0 });
    
    return (
        <div>
            <p>Count: {state.count}</p>
            <button onClick={() => dispatch({ type: 'increment' })}>+</button>
            <button onClick={() => dispatch({ type: 'decrement' })}>-</button>
            <button onClick={() => dispatch({ type: 'reset' })}>Reset</button>
        </div>
    );
}
```

### Complex State with useReducer

```javascript
// Reducer for todo list
function todoReducer(state, action) {
    switch (action.type) {
        case 'add':
            return {
                ...state,
                todos: [...state.todos, {
                    id: Date.now(),
                    text: action.text,
                    completed: false
                }]
            };
        case 'toggle':
            return {
                ...state,
                todos: state.todos.map(todo =>
                    todo.id === action.id
                        ? { ...todo, completed: !todo.completed }
                        : todo
                )
            };
        case 'delete':
            return {
                ...state,
                todos: state.todos.filter(todo => todo.id !== action.id)
            };
        case 'setFilter':
            return {
                ...state,
                filter: action.filter
            };
        default:
            return state;
    }
}

function TodoApp() {
    const [state, dispatch] = useReducer(todoReducer, {
        todos: [],
        filter: 'all'
    });
    
    const addTodo = (text) => {
        dispatch({ type: 'add', text });
    };
    
    const toggleTodo = (id) => {
        dispatch({ type: 'toggle', id });
    };
    
    const deleteTodo = (id) => {
        dispatch({ type: 'delete', id });
    };
    
    const filteredTodos = state.todos.filter(todo => {
        if (state.filter === 'active') return !todo.completed;
        if (state.filter === 'completed') return todo.completed;
        return true;
    });
    
    return (
        <div>
            <input
                onKeyPress={(e) => {
                    if (e.key === 'Enter') {
                        addTodo(e.target.value);
                        e.target.value = '';
                    }
                }}
            />
            <div>
                <button onClick={() => dispatch({ type: 'setFilter', filter: 'all' })}>
                    All
                </button>
                <button onClick={() => dispatch({ type: 'setFilter', filter: 'active' })}>
                    Active
                </button>
                <button onClick={() => dispatch({ type: 'setFilter', filter: 'completed' })}>
                    Completed
                </button>
            </div>
            <ul>
                {filteredTodos.map(todo => (
                    <li key={todo.id}>
                        <input
                            type="checkbox"
                            checked={todo.completed}
                            onChange={() => toggleTodo(todo.id)}
                        />
                        {todo.text}
                        <button onClick={() => deleteTodo(todo.id)}>Delete</button>
                    </li>
                ))}
            </ul>
        </div>
    );
}
```

### useReducer vs useState

```javascript
// useState: Simple state
const [count, setCount] = useState(0);

// useReducer: Complex state logic
const [state, dispatch] = useReducer(reducer, initialState);

// When to use useReducer:
// - Complex state logic
// - Multiple sub-values
// - Next state depends on previous
// - Better for testing
```

---

## Custom Hooks

### What are Custom Hooks?

Custom hooks are functions that use other hooks to encapsulate reusable logic.

### Basic Custom Hook

```javascript
// Custom hook: useCounter
function useCounter(initialValue = 0) {
    const [count, setCount] = useState(initialValue);
    
    const increment = () => setCount(count + 1);
    const decrement = () => setCount(count - 1);
    const reset = () => setCount(initialValue);
    
    return { count, increment, decrement, reset };
}

// Using custom hook
function Counter() {
    const { count, increment, decrement, reset } = useCounter(0);
    
    return (
        <div>
            <p>Count: {count}</p>
            <button onClick={increment}>+</button>
            <button onClick={decrement}>-</button>
            <button onClick={reset}>Reset</button>
        </div>
    );
}
```

### Custom Hook: useFetch

```javascript
// Custom hook: useFetch
function useFetch(url) {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    
    useEffect(() => {
        setLoading(true);
        setError(null);
        
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                setData(data);
                setLoading(false);
            })
            .catch(err => {
                setError(err.message);
                setLoading(false);
            });
    }, [url]);
    
    return { data, loading, error };
}

// Using custom hook
function UserProfile({ userId }) {
    const { data: user, loading, error } = useFetch(`/api/users/${userId}`);
    
    if (loading) return <div>Loading...</div>;
    if (error) return <div>Error: {error}</div>;
    if (!user) return <div>No user found</div>;
    
    return (
        <div>
            <h1>{user.name}</h1>
            <p>{user.email}</p>
        </div>
    );
}
```

### Custom Hook: useLocalStorage

```javascript
// Custom hook: useLocalStorage
function useLocalStorage(key, initialValue) {
    const [storedValue, setStoredValue] = useState(() => {
        try {
            const item = window.localStorage.getItem(key);
            return item ? JSON.parse(item) : initialValue;
        } catch (error) {
            console.error(error);
            return initialValue;
        }
    });
    
    const setValue = (value) => {
        try {
            setStoredValue(value);
            window.localStorage.setItem(key, JSON.stringify(value));
        } catch (error) {
            console.error(error);
        }
    };
    
    return [storedValue, setValue];
}

// Using custom hook
function Settings() {
    const [theme, setTheme] = useLocalStorage('theme', 'light');
    const [language, setLanguage] = useLocalStorage('language', 'en');
    
    return (
        <div>
            <select value={theme} onChange={(e) => setTheme(e.target.value)}>
                <option value="light">Light</option>
                <option value="dark">Dark</option>
            </select>
            <select value={language} onChange={(e) => setLanguage(e.target.value)}>
                <option value="en">English</option>
                <option value="es">Spanish</option>
            </select>
        </div>
    );
}
```

### Custom Hook: useDebounce

```javascript
// Custom hook: useDebounce
function useDebounce(value, delay) {
    const [debouncedValue, setDebouncedValue] = useState(value);
    
    useEffect(() => {
        const handler = setTimeout(() => {
            setDebouncedValue(value);
        }, delay);
        
        return () => {
            clearTimeout(handler);
        };
    }, [value, delay]);
    
    return debouncedValue;
}

// Using custom hook
function SearchInput() {
    const [searchTerm, setSearchTerm] = useState('');
    const debouncedSearchTerm = useDebounce(searchTerm, 500);
    const [results, setResults] = useState([]);
    
    useEffect(() => {
        if (debouncedSearchTerm) {
            // Perform search
            fetch(`/api/search?q=${debouncedSearchTerm}`)
                .then(res => res.json())
                .then(data => setResults(data));
        } else {
            setResults([]);
        }
    }, [debouncedSearchTerm]);
    
    return (
        <div>
            <input
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                placeholder="Search..."
            />
            <ul>
                {results.map(result => (
                    <li key={result.id}>{result.name}</li>
                ))}
            </ul>
        </div>
    );
}
```

---

## Practice Exercise

### Exercise: Hooks Practice

**Objective**: Practice using useEffect, useContext, useReducer, and creating custom hooks.

**Instructions**:

1. Create a React project
2. Practice hooks
3. Practice:
   - Using useEffect for side effects
   - Using useContext for context
   - Using useReducer for complex state
   - Creating custom hooks

**Example Solution**:

```javascript
// src/hooks/useCounter.js
import { useState } from 'react';

export function useCounter(initialValue = 0, step = 1) {
    const [count, setCount] = useState(initialValue);
    
    const increment = () => setCount(count + step);
    const decrement = () => setCount(count - step);
    const reset = () => setCount(initialValue);
    
    return { count, increment, decrement, reset };
}
```

```javascript
// src/hooks/useFetch.js
import { useState, useEffect } from 'react';

export function useFetch(url) {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    
    useEffect(() => {
        let cancelled = false;
        
        setLoading(true);
        setError(null);
        
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (!cancelled) {
                    setData(data);
                    setLoading(false);
                }
            })
            .catch(err => {
                if (!cancelled) {
                    setError(err.message);
                    setLoading(false);
                }
            });
        
        return () => {
            cancelled = true;
        };
    }, [url]);
    
    return { data, loading, error };
}
```

```javascript
// src/hooks/useLocalStorage.js
import { useState, useEffect } from 'react';

export function useLocalStorage(key, initialValue) {
    const [storedValue, setStoredValue] = useState(() => {
        try {
            const item = window.localStorage.getItem(key);
            return item ? JSON.parse(item) : initialValue;
        } catch (error) {
            console.error(error);
            return initialValue;
        }
    });
    
    const setValue = (value) => {
        try {
            const valueToStore = value instanceof Function ? value(storedValue) : value;
            setStoredValue(valueToStore);
            window.localStorage.setItem(key, JSON.stringify(valueToStore));
        } catch (error) {
            console.error(error);
        }
    };
    
    return [storedValue, setValue];
}
```

```javascript
// src/contexts/ThemeContext.jsx
import { createContext, useContext, useState, useEffect } from 'react';

const ThemeContext = createContext();

export function ThemeProvider({ children }) {
    const [theme, setTheme] = useLocalStorage('theme', 'light');
    
    useEffect(() => {
        document.documentElement.setAttribute('data-theme', theme);
    }, [theme]);
    
    return (
        <ThemeContext.Provider value={{ theme, setTheme }}>
            {children}
        </ThemeContext.Provider>
    );
}

export function useTheme() {
    const context = useContext(ThemeContext);
    if (!context) {
        throw new Error('useTheme must be used within ThemeProvider');
    }
    return context;
}
```

```javascript
// src/components/Counter.jsx
import React from 'react';
import { useCounter } from '../hooks/useCounter';

function Counter() {
    const { count, increment, decrement, reset } = useCounter(0);
    
    return (
        <div className="counter">
            <h2>Counter</h2>
            <p>Count: {count}</p>
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
// src/components/TodoApp.jsx
import React, { useReducer, useState } from 'react';

function todoReducer(state, action) {
    switch (action.type) {
        case 'add':
            return {
                ...state,
                todos: [...state.todos, {
                    id: Date.now(),
                    text: action.text,
                    completed: false
                }]
            };
        case 'toggle':
            return {
                ...state,
                todos: state.todos.map(todo =>
                    todo.id === action.id
                        ? { ...todo, completed: !todo.completed }
                        : todo
                )
            };
        case 'delete':
            return {
                ...state,
                todos: state.todos.filter(todo => todo.id !== action.id)
            };
        case 'setFilter':
            return {
                ...state,
                filter: action.filter
            };
        default:
            return state;
    }
}

function TodoApp() {
    const [state, dispatch] = useReducer(todoReducer, {
        todos: [],
        filter: 'all'
    });
    const [input, setInput] = useState('');
    
    const addTodo = () => {
        if (input.trim()) {
            dispatch({ type: 'add', text: input });
            setInput('');
        }
    };
    
    const filteredTodos = state.todos.filter(todo => {
        if (state.filter === 'active') return !todo.completed;
        if (state.filter === 'completed') return todo.completed;
        return true;
    });
    
    return (
        <div className="todo-app">
            <h2>Todo App</h2>
            <div className="todo-input">
                <input
                    value={input}
                    onChange={(e) => setInput(e.target.value)}
                    onKeyPress={(e) => e.key === 'Enter' && addTodo()}
                    placeholder="Add todo..."
                />
                <button onClick={addTodo}>Add</button>
            </div>
            <div className="filters">
                <button
                    className={state.filter === 'all' ? 'active' : ''}
                    onClick={() => dispatch({ type: 'setFilter', filter: 'all' })}
                >
                    All
                </button>
                <button
                    className={state.filter === 'active' ? 'active' : ''}
                    onClick={() => dispatch({ type: 'setFilter', filter: 'active' })}
                >
                    Active
                </button>
                <button
                    className={state.filter === 'completed' ? 'active' : ''}
                    onClick={() => dispatch({ type: 'setFilter', filter: 'completed' })}
                >
                    Completed
                </button>
            </div>
            <ul className="todo-list">
                {filteredTodos.map(todo => (
                    <li key={todo.id} className={todo.completed ? 'completed' : ''}>
                        <input
                            type="checkbox"
                            checked={todo.completed}
                            onChange={() => dispatch({ type: 'toggle', id: todo.id })}
                        />
                        <span>{todo.text}</span>
                        <button onClick={() => dispatch({ type: 'delete', id: todo.id })}>
                            Delete
                        </button>
                    </li>
                ))}
            </ul>
        </div>
    );
}

export default TodoApp;
```

```javascript
// src/components/ThemeToggle.jsx
import React from 'react';
import { useTheme } from '../contexts/ThemeContext';

function ThemeToggle() {
    const { theme, setTheme } = useTheme();
    
    return (
        <button
            className="theme-toggle"
            onClick={() => setTheme(theme === 'light' ? 'dark' : 'light')}
        >
            {theme === 'light' ? '🌙' : '☀️'} {theme}
        </button>
    );
}

export default ThemeToggle;
```

```javascript
// src/components/UserProfile.jsx
import React from 'react';
import { useFetch } from '../hooks/useFetch';

function UserProfile({ userId }) {
    const { data: user, loading, error } = useFetch(`https://jsonplaceholder.typicode.com/users/${userId}`);
    
    if (loading) return <div className="loading">Loading...</div>;
    if (error) return <div className="error">Error: {error}</div>;
    if (!user) return <div>No user found</div>;
    
    return (
        <div className="user-profile">
            <h2>{user.name}</h2>
            <p><strong>Email:</strong> {user.email}</p>
            <p><strong>Phone:</strong> {user.phone}</p>
            <p><strong>Website:</strong> {user.website}</p>
        </div>
    );
}

export default UserProfile;
```

```javascript
// src/App.jsx
import React from 'react';
import { ThemeProvider } from './contexts/ThemeContext';
import Counter from './components/Counter';
import TodoApp from './components/TodoApp';
import ThemeToggle from './components/ThemeToggle';
import UserProfile from './components/UserProfile';
import './App.css';

function App() {
    return (
        <ThemeProvider>
            <div className="App">
                <header>
                    <h1>React Hooks Practice</h1>
                    <ThemeToggle />
                </header>
                <main>
                    <section>
                        <Counter />
                    </section>
                    <section>
                        <TodoApp />
                    </section>
                    <section>
                        <UserProfile userId={1} />
                    </section>
                </main>
            </div>
        </ThemeProvider>
    );
}

export default App;
```

```css
/* src/App.css */
[data-theme="light"] {
    --bg-color: #ffffff;
    --text-color: #000000;
    --border-color: #ddd;
}

[data-theme="dark"] {
    --bg-color: #1a1a1a;
    --text-color: #ffffff;
    --border-color: #444;
}

.App {
    min-height: 100vh;
    background-color: var(--bg-color);
    color: var(--text-color);
    padding: 20px;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid var(--border-color);
}

section {
    margin-bottom: 40px;
    padding: 20px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
}

.counter, .todo-app {
    max-width: 500px;
}

.buttons {
    display: flex;
    gap: 10px;
}

button {
    padding: 8px 16px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

.todo-input {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.todo-input input {
    flex: 1;
    padding: 8px;
    border: 1px solid var(--border-color);
    border-radius: 4px;
}

.filters {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.filters button.active {
    background-color: #28a745;
}

.todo-list {
    list-style: none;
    padding: 0;
}

.todo-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    margin: 5px 0;
    background-color: var(--bg-color);
    border: 1px solid var(--border-color);
    border-radius: 4px;
}

.todo-list li.completed span {
    text-decoration: line-through;
    opacity: 0.6;
}

.loading, .error {
    padding: 20px;
    text-align: center;
}

.user-profile {
    max-width: 400px;
}
```

**Expected Output** (in browser):
- Counter with custom hook
- Todo app with useReducer
- Theme toggle with context
- User profile with useFetch
- All working together

**Challenge (Optional)**:
- Create more custom hooks
- Build complex state management
- Practice all hooks together
- Build a complete application

---

## Common Mistakes

### 1. Missing Dependencies

```javascript
// ❌ Bad: Missing dependency
useEffect(() => {
    fetchData(userId);
}, []);  // Missing userId

// ✅ Good: Include dependencies
useEffect(() => {
    fetchData(userId);
}, [userId]);
```

### 2. Infinite Loops

```javascript
// ❌ Bad: Infinite loop
useEffect(() => {
    setCount(count + 1);
}, [count]);  // count changes, triggers effect, changes count again

// ✅ Good: Use functional update
useEffect(() => {
    setCount(prev => prev + 1);
}, []);  // Only run once
```

### 3. Not Cleaning Up

```javascript
// ❌ Bad: No cleanup
useEffect(() => {
    const interval = setInterval(() => {
        // Do something
    }, 1000);
    // Missing cleanup
}, []);

// ✅ Good: Cleanup
useEffect(() => {
    const interval = setInterval(() => {
        // Do something
    }, 1000);
    return () => clearInterval(interval);
}, []);
```

---

## Key Takeaways

1. **useEffect**: Handle side effects
2. **useContext**: Share context across components
3. **useReducer**: Manage complex state logic
4. **Custom Hooks**: Reusable logic
5. **Best Practice**: Clean up effects, include dependencies
6. **Patterns**: Separate concerns, use custom hooks
7. **Rules**: Only call hooks at top level

---

## Quiz: Hooks

Test your understanding with these questions:

1. **useEffect runs:**
   - A) After render
   - B) Before render
   - C) Both
   - D) Neither

2. **useContext:**
   - A) Accesses context
   - B) Creates context
   - C) Both
   - D) Neither

3. **useReducer:**
   - A) Complex state
   - B) Simple state
   - C) Both
   - D) Neither

4. **Custom hooks:**
   - A) Reusable logic
   - B) Component logic
   - C) Both
   - D) Neither

5. **Cleanup function:**
   - A) Required
   - B) Optional
   - C) Both
   - D) Neither

6. **Dependency array:**
   - A) Controls when effect runs
   - B) Doesn't matter
   - C) Both
   - D) Neither

7. **Hooks can be called:**
   - A) Top level only
   - B) Anywhere
   - C) Both
   - D) Neither

**Answers**:
1. A) After render
2. A) Accesses context
3. A) Complex state
4. A) Reusable logic
5. B) Optional (but recommended)
6. A) Controls when effect runs
7. A) Top level only

---

## Next Steps

Congratulations! You've learned React hooks. You now know:
- How to use useEffect
- How to use useContext
- How to use useReducer
- How to create custom hooks

**What's Next?**
- Lesson 26.2: React Router
- Learn routing in React
- Set up React Router
- Handle navigation

---

## Additional Resources

- **React Hooks**: [react.dev/reference/react](https://react.dev/reference/react)
- **useEffect**: [react.dev/reference/react/useEffect](https://react.dev/reference/react/useEffect)
- **useContext**: [react.dev/reference/react/useContext](https://react.dev/reference/react/useContext)
- **useReducer**: [react.dev/reference/react/useReducer](https://react.dev/reference/react/useReducer)

---

*Lesson completed! You're ready to move on to the next lesson.*

