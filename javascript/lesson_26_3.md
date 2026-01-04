# Lesson 26.3: State Management

## Learning Objectives

By the end of this lesson, you will be able to:
- Use Context API for state management
- Understand Redux basics
- Apply state management patterns
- Choose appropriate state management solution
- Manage global state
- Handle complex state logic
- Build scalable applications

---

## Introduction to State Management

State management is about how you store, organize, and update application state.

### When to Use State Management?

- **Local State**: Component-specific (useState)
- **Shared State**: Multiple components (Context API, Redux)
- **Global State**: App-wide state (Context API, Redux)
- **Complex State**: Complex logic (Redux, Zustand)

### State Management Solutions

```javascript
// Built-in
useState        // Local state
useContext      // Shared state
useReducer      // Complex local state

// Libraries
Redux           // Predictable state container
Zustand         // Lightweight state management
Jotai           // Atomic state management
Recoil          // Facebook's state management
```

---

## Context API

### What is Context API?

Context API is React's built-in solution for sharing state across components.

### Basic Context

```javascript
import { createContext, useContext, useState } from 'react';

// Create context
const ThemeContext = createContext();

// Provider component
export function ThemeProvider({ children }) {
    const [theme, setTheme] = useState('light');
    
    return (
        <ThemeContext.Provider value={{ theme, setTheme }}>
            {children}
        </ThemeContext.Provider>
    );
}

// Custom hook
export function useTheme() {
    const context = useContext(ThemeContext);
    if (!context) {
        throw new Error('useTheme must be used within ThemeProvider');
    }
    return context;
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
```

### Context with useReducer

```javascript
import { createContext, useContext, useReducer } from 'react';

// Initial state
const initialState = {
    count: 0,
    todos: []
};

// Reducer
function appReducer(state, action) {
    switch (action.type) {
        case 'INCREMENT':
            return { ...state, count: state.count + 1 };
        case 'ADD_TODO':
            return {
                ...state,
                todos: [...state.todos, action.payload]
            };
        default:
            return state;
    }
}

// Context
const AppContext = createContext();

// Provider
export function AppProvider({ children }) {
    const [state, dispatch] = useReducer(appReducer, initialState);
    
    return (
        <AppContext.Provider value={{ state, dispatch }}>
            {children}
        </AppContext.Provider>
    );
}

// Hook
export function useApp() {
    const context = useContext(AppContext);
    if (!context) {
        throw new Error('useApp must be used within AppProvider');
    }
    return context;
}
```

### Example: Shopping Cart

```javascript
// src/contexts/CartContext.jsx
import { createContext, useContext, useReducer } from 'react';

const CartContext = createContext();

const cartReducer = (state, action) => {
    switch (action.type) {
        case 'ADD_ITEM':
            const existingItem = state.items.find(
                item => item.id === action.payload.id
            );
            if (existingItem) {
                return {
                    ...state,
                    items: state.items.map(item =>
                        item.id === action.payload.id
                            ? { ...item, quantity: item.quantity + 1 }
                            : item
                    )
                };
            }
            return {
                ...state,
                items: [...state.items, { ...action.payload, quantity: 1 }]
            };
        case 'REMOVE_ITEM':
            return {
                ...state,
                items: state.items.filter(item => item.id !== action.payload)
            };
        case 'UPDATE_QUANTITY':
            return {
                ...state,
                items: state.items.map(item =>
                    item.id === action.payload.id
                        ? { ...item, quantity: action.payload.quantity }
                        : item
                )
            };
        case 'CLEAR_CART':
            return { ...state, items: [] };
        default:
            return state;
    }
};

export function CartProvider({ children }) {
    const [state, dispatch] = useReducer(cartReducer, { items: [] });
    
    const addItem = (item) => {
        dispatch({ type: 'ADD_ITEM', payload: item });
    };
    
    const removeItem = (id) => {
        dispatch({ type: 'REMOVE_ITEM', payload: id });
    };
    
    const updateQuantity = (id, quantity) => {
        dispatch({ type: 'UPDATE_QUANTITY', payload: { id, quantity } });
    };
    
    const clearCart = () => {
        dispatch({ type: 'CLEAR_CART' });
    };
    
    const total = state.items.reduce(
        (sum, item) => sum + item.price * item.quantity,
        0
    );
    
    return (
        <CartContext.Provider
            value={{
                items: state.items,
                total,
                addItem,
                removeItem,
                updateQuantity,
                clearCart
            }}
        >
            {children}
        </CartContext.Provider>
    );
}

export function useCart() {
    const context = useContext(CartContext);
    if (!context) {
        throw new Error('useCart must be used within CartProvider');
    }
    return context;
}
```

---

## Redux Basics

### What is Redux?

Redux is a predictable state container for JavaScript apps.

### Redux Principles

1. **Single Source of Truth**: One store
2. **State is Read-Only**: Only actions change state
3. **Changes with Pure Functions**: Reducers are pure

### Installation

```bash
# Install Redux
npm install @reduxjs/toolkit react-redux
```

### Basic Redux Setup

```javascript
// src/store/store.js
import { configureStore } from '@reduxjs/toolkit';
import counterReducer from './counterSlice';

export const store = configureStore({
    reducer: {
        counter: counterReducer
    }
});
```

```javascript
// src/store/counterSlice.js
import { createSlice } from '@reduxjs/toolkit';

const initialState = {
    value: 0
};

const counterSlice = createSlice({
    name: 'counter',
    initialState,
    reducers: {
        increment: (state) => {
            state.value += 1;
        },
        decrement: (state) => {
            state.value -= 1;
        },
        incrementByAmount: (state, action) => {
            state.value += action.payload;
        }
    }
});

export const { increment, decrement, incrementByAmount } = counterSlice.actions;
export default counterSlice.reducer;
```

```javascript
// src/main.jsx
import { Provider } from 'react-redux';
import { store } from './store/store';
import App from './App';

ReactDOM.createRoot(document.getElementById('root')).render(
    <Provider store={store}>
        <App />
    </Provider>
);
```

### Using Redux

```javascript
// src/components/Counter.jsx
import { useSelector, useDispatch } from 'react-redux';
import { increment, decrement, incrementByAmount } from '../store/counterSlice';

function Counter() {
    const count = useSelector((state) => state.counter.value);
    const dispatch = useDispatch();
    
    return (
        <div>
            <p>Count: {count}</p>
            <button onClick={() => dispatch(increment())}>+</button>
            <button onClick={() => dispatch(decrement())}>-</button>
            <button onClick={() => dispatch(incrementByAmount(5))}>
                +5
            </button>
        </div>
    );
}
```

### Redux with Async Actions

```javascript
// src/store/todosSlice.js
import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';

// Async thunk
export const fetchTodos = createAsyncThunk(
    'todos/fetchTodos',
    async () => {
        const response = await fetch('/api/todos');
        return response.json();
    }
);

const todosSlice = createSlice({
    name: 'todos',
    initialState: {
        items: [],
        loading: false,
        error: null
    },
    reducers: {
        addTodo: (state, action) => {
            state.items.push(action.payload);
        },
        removeTodo: (state, action) => {
            state.items = state.items.filter(item => item.id !== action.payload);
        }
    },
    extraReducers: (builder) => {
        builder
            .addCase(fetchTodos.pending, (state) => {
                state.loading = true;
            })
            .addCase(fetchTodos.fulfilled, (state, action) => {
                state.loading = false;
                state.items = action.payload;
            })
            .addCase(fetchTodos.rejected, (state, action) => {
                state.loading = false;
                state.error = action.error.message;
            });
    }
});

export const { addTodo, removeTodo } = todosSlice.actions;
export default todosSlice.reducer;
```

---

## State Management Patterns

### Pattern 1: Local State

```javascript
// Use for component-specific state
function Component() {
    const [count, setCount] = useState(0);
    // ...
}
```

### Pattern 2: Lifted State

```javascript
// Lift state to common ancestor
function Parent() {
    const [state, setState] = useState(initialState);
    return (
        <>
            <Child1 state={state} setState={setState} />
            <Child2 state={state} setState={setState} />
        </>
    );
}
```

### Pattern 3: Context API

```javascript
// Use for shared state across components
const Context = createContext();

function Provider({ children }) {
    const [state, setState] = useState(initialState);
    return (
        <Context.Provider value={{ state, setState }}>
            {children}
        </Context.Provider>
    );
}
```

### Pattern 4: Redux

```javascript
// Use for complex global state
const store = configureStore({
    reducer: {
        // Reducers
    }
});
```

### Pattern 5: Custom Hooks

```javascript
// Encapsulate state logic
function useCustomState() {
    const [state, setState] = useState(initialState);
    // Logic
    return { state, actions };
}
```

---

## Practice Exercise

### Exercise: State Management

**Objective**: Practice using Context API, Redux basics, and applying state management patterns.

**Instructions**:

1. Create a React project
2. Practice state management
3. Practice:
   - Context API
   - Redux setup
   - State management patterns
   - Choosing the right solution

**Example Solution**:

```javascript
// src/contexts/AuthContext.jsx
import { createContext, useContext, useState, useEffect } from 'react';

const AuthContext = createContext();

export function AuthProvider({ children }) {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);
    
    useEffect(() => {
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
// src/store/store.js
import { configureStore } from '@reduxjs/toolkit';
import todosReducer from './todosSlice';
import counterReducer from './counterSlice';

export const store = configureStore({
    reducer: {
        todos: todosReducer,
        counter: counterReducer
    }
});
```

```javascript
// src/store/todosSlice.js
import { createSlice } from '@reduxjs/toolkit';

const initialState = {
    items: [],
    filter: 'all'
};

const todosSlice = createSlice({
    name: 'todos',
    initialState,
    reducers: {
        addTodo: (state, action) => {
            state.items.push({
                id: Date.now(),
                text: action.payload,
                completed: false
            });
        },
        toggleTodo: (state, action) => {
            const todo = state.items.find(item => item.id === action.payload);
            if (todo) {
                todo.completed = !todo.completed;
            }
        },
        removeTodo: (state, action) => {
            state.items = state.items.filter(item => item.id !== action.payload);
        },
        setFilter: (state, action) => {
            state.filter = action.payload;
        }
    }
});

export const { addTodo, toggleTodo, removeTodo, setFilter } = todosSlice.actions;
export default todosSlice.reducer;
```

```javascript
// src/store/counterSlice.js
import { createSlice } from '@reduxjs/toolkit';

const initialState = {
    value: 0
};

const counterSlice = createSlice({
    name: 'counter',
    initialState,
    reducers: {
        increment: (state) => {
            state.value += 1;
        },
        decrement: (state) => {
            state.value -= 1;
        },
        reset: (state) => {
            state.value = 0;
        }
    }
});

export const { increment, decrement, reset } = counterSlice.actions;
export default counterSlice.reducer;
```

```javascript
// src/components/TodoList.jsx
import { useSelector, useDispatch } from 'react-redux';
import { addTodo, toggleTodo, removeTodo, setFilter } from '../store/todosSlice';
import { useState } from 'react';

function TodoList() {
    const todos = useSelector((state) => state.todos.items);
    const filter = useSelector((state) => state.todos.filter);
    const dispatch = useDispatch();
    const [input, setInput] = useState('');
    
    const filteredTodos = todos.filter(todo => {
        if (filter === 'active') return !todo.completed;
        if (filter === 'completed') return todo.completed;
        return true;
    });
    
    const handleAdd = () => {
        if (input.trim()) {
            dispatch(addTodo(input));
            setInput('');
        }
    };
    
    return (
        <div className="todo-list">
            <h2>Todo List (Redux)</h2>
            <div className="todo-input">
                <input
                    value={input}
                    onChange={(e) => setInput(e.target.value)}
                    onKeyPress={(e) => e.key === 'Enter' && handleAdd()}
                    placeholder="Add todo..."
                />
                <button onClick={handleAdd}>Add</button>
            </div>
            <div className="filters">
                <button
                    className={filter === 'all' ? 'active' : ''}
                    onClick={() => dispatch(setFilter('all'))}
                >
                    All
                </button>
                <button
                    className={filter === 'active' ? 'active' : ''}
                    onClick={() => dispatch(setFilter('active'))}
                >
                    Active
                </button>
                <button
                    className={filter === 'completed' ? 'active' : ''}
                    onClick={() => dispatch(setFilter('completed'))}
                >
                    Completed
                </button>
            </div>
            <ul>
                {filteredTodos.map(todo => (
                    <li key={todo.id} className={todo.completed ? 'completed' : ''}>
                        <input
                            type="checkbox"
                            checked={todo.completed}
                            onChange={() => dispatch(toggleTodo(todo.id))}
                        />
                        <span>{todo.text}</span>
                        <button onClick={() => dispatch(removeTodo(todo.id))}>
                            Delete
                        </button>
                    </li>
                ))}
            </ul>
        </div>
    );
}

export default TodoList;
```

```javascript
// src/components/Counter.jsx
import { useSelector, useDispatch } from 'react-redux';
import { increment, decrement, reset } from '../store/counterSlice';

function Counter() {
    const count = useSelector((state) => state.counter.value);
    const dispatch = useDispatch();
    
    return (
        <div className="counter">
            <h2>Counter (Redux)</h2>
            <p>Count: {count}</p>
            <div className="buttons">
                <button onClick={() => dispatch(decrement())}>-</button>
                <button onClick={() => dispatch(reset())}>Reset</button>
                <button onClick={() => dispatch(increment())}>+</button>
            </div>
        </div>
    );
}

export default Counter;
```

```javascript
// src/components/UserProfile.jsx
import { useAuth } from '../contexts/AuthContext';

function UserProfile() {
    const { user, logout } = useAuth();
    
    if (!user) {
        return <p>Please log in</p>;
    }
    
    return (
        <div className="user-profile">
            <h2>User Profile (Context)</h2>
            <p>Name: {user.name}</p>
            <p>Email: {user.email}</p>
            <button onClick={logout}>Logout</button>
        </div>
    );
}

export default UserProfile;
```

```javascript
// src/App.jsx
import { Provider } from 'react-redux';
import { store } from './store/store';
import { AuthProvider } from './contexts/AuthContext';
import Counter from './components/Counter';
import TodoList from './components/TodoList';
import UserProfile from './components/UserProfile';
import './App.css';

function App() {
    return (
        <Provider store={store}>
            <AuthProvider>
                <div className="App">
                    <header>
                        <h1>State Management Examples</h1>
                    </header>
                    <main>
                        <section>
                            <Counter />
                        </section>
                        <section>
                            <TodoList />
                        </section>
                        <section>
                            <UserProfile />
                        </section>
                    </main>
                </div>
            </AuthProvider>
        </Provider>
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

.counter, .todo-list {
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

button.active {
    background-color: #28a745;
}

.todo-input {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.todo-input input {
    flex: 1;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.filters {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

ul {
    list-style: none;
    padding: 0;
}

li {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    margin: 5px 0;
    background-color: #f5f5f5;
    border-radius: 4px;
}

li.completed span {
    text-decoration: line-through;
    opacity: 0.6;
}
```

**Expected Output** (in browser):
- Counter using Redux
- Todo list using Redux
- User profile using Context API
- All working together

**Challenge (Optional)**:
- Build complex state management
- Combine Context and Redux
- Add async actions
- Build a complete app

---

## Common Mistakes

### 1. Overusing Redux

```javascript
// ❌ Bad: Redux for simple local state
const [count, setCount] = useState(0);  // Should use useState

// ✅ Good: Redux for global/complex state
// Use Redux for shared state across many components
```

### 2. Not Splitting Contexts

```javascript
// ❌ Bad: One context for everything
const AppContext = createContext();

// ✅ Good: Split contexts by concern
const ThemeContext = createContext();
const UserContext = createContext();
```

### 3. Mutating State in Redux

```javascript
// ❌ Bad: Direct mutation (old Redux)
state.items.push(newItem);

// ✅ Good: Immutable updates (Redux Toolkit)
state.items.push(newItem);  // OK with Redux Toolkit
// Or
state.items = [...state.items, newItem];
```

---

## Key Takeaways

1. **Context API**: Built-in solution for shared state
2. **Redux**: Predictable state container
3. **Patterns**: Choose right solution for use case
4. **Local State**: useState for component-specific
5. **Shared State**: Context API for shared
6. **Global State**: Redux for complex global state
7. **Best Practice**: Don't overuse, split by concern

---

## Quiz: State Management

Test your understanding with these questions:

1. **Context API:**
   - A) Built-in React
   - B) External library
   - C) Both
   - D) Neither

2. **Redux:**
   - A) Predictable state
   - B) Unpredictable state
   - C) Both
   - D) Neither

3. **useState:**
   - A) Local state
   - B) Global state
   - C) Both
   - D) Neither

4. **Context API:**
   - A) Shared state
   - B) Local state
   - C) Both
   - D) Neither

5. **Redux:**
   - A) Complex state
   - B) Simple state
   - C) Both
   - D) Neither

6. **State management:**
   - A) Choose by use case
   - B) Always use Redux
   - C) Both
   - D) Neither

7. **Redux Toolkit:**
   - A) Modern Redux
   - B) Old Redux
   - C) Both
   - D) Neither

**Answers**:
1. A) Built-in React
2. A) Predictable state
3. A) Local state
4. A) Shared state
5. A) Complex state
6. A) Choose by use case
7. A) Modern Redux

---

## Next Steps

Congratulations! You've completed Module 26: React Advanced. You now know:
- React hooks (useEffect, useContext, useReducer)
- React Router
- State management (Context API, Redux)
- How to build advanced React applications

**What's Next?**
- Module 27: Vue.js (Alternative Framework)
- Learn Vue.js basics
- Compare with React
- Build Vue applications

---

## Additional Resources

- **Context API**: [react.dev/reference/react/useContext](https://react.dev/reference/react/useContext)
- **Redux**: [redux.js.org](https://redux.js.org)
- **Redux Toolkit**: [redux-toolkit.js.org](https://redux-toolkit.js.org)
- **State Management Guide**: [react.dev/learn/managing-state](https://react.dev/learn/managing-state)

---

*Lesson completed! You've finished Module 26: React Advanced. Ready for Module 27: Vue.js!*

