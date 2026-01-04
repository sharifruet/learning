# Project 2.1: React Todo App

## Project Overview

Build a fully functional Todo List application using React. This project will help you practice React components, state management, hooks, and local storage integration.

## Learning Objectives

By the end of this project, you will be able to:
- Create React components
- Manage state with hooks
- Use useEffect for side effects
- Integrate local storage
- Build reusable components
- Structure React applications
- Handle user interactions

---

## Project Requirements

### Core Features

1. **Add Todos**: Create new todo items
2. **View Todos**: Display all todos
3. **Edit Todos**: Update todo text
4. **Delete Todos**: Remove todos
5. **Toggle Complete**: Mark todos as complete/incomplete
6. **Filter Todos**: Filter by all/active/completed
7. **Persist Data**: Save to local storage
8. **Clear Completed**: Remove all completed todos

### Technical Requirements

- Use React (Create React App or Vite)
- Use functional components with hooks
- Implement local storage
- Clean component structure
- Responsive design
- Error handling

---

## Project Setup

### Option 1: Create React App

```bash
npx create-react-app react-todo-app
cd react-todo-app
npm start
```

### Option 2: Vite

```bash
npm create vite@latest react-todo-app -- --template react
cd react-todo-app
npm install
npm run dev
```

---

## Project Structure

```
react-todo-app/
├── public/
│   └── index.html
├── src/
│   ├── components/
│   │   ├── TodoForm.jsx
│   │   ├── TodoList.jsx
│   │   ├── TodoItem.jsx
│   │   ├── FilterButtons.jsx
│   │   └── TodoStats.jsx
│   ├── hooks/
│   │   └── useLocalStorage.js
│   ├── utils/
│   │   └── storage.js
│   ├── App.jsx
│   ├── App.css
│   └── index.js
└── package.json
```

---

## Step-by-Step Implementation

### Step 1: Custom Hook for Local Storage

```javascript
// src/hooks/useLocalStorage.js
import { useState, useEffect } from 'react';

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
            const valueToStore = value instanceof Function ? value(storedValue) : value;
            setStoredValue(valueToStore);
            window.localStorage.setItem(key, JSON.stringify(valueToStore));
        } catch (error) {
            console.error(error);
        }
    };
    
    return [storedValue, setValue];
}

export default useLocalStorage;
```

### Step 2: Todo Form Component

```javascript
// src/components/TodoForm.jsx
import { useState } from 'react';
import './TodoForm.css';

function TodoForm({ onAddTodo }) {
    const [input, setInput] = useState('');
    
    const handleSubmit = (e) => {
        e.preventDefault();
        if (input.trim()) {
            onAddTodo(input.trim());
            setInput('');
        }
    };
    
    return (
        <form className="todo-form" onSubmit={handleSubmit}>
            <input
                type="text"
                className="todo-input"
                placeholder="Add a new todo..."
                value={input}
                onChange={(e) => setInput(e.target.value)}
            />
            <button type="submit" className="todo-button">
                Add
            </button>
        </form>
    );
}

export default TodoForm;
```

### Step 3: Todo Item Component

```javascript
// src/components/TodoItem.jsx
import { useState } from 'react';
import './TodoItem.css';

function TodoItem({ todo, onToggle, onDelete, onUpdate }) {
    const [isEditing, setIsEditing] = useState(false);
    const [editText, setEditText] = useState(todo.text);
    
    const handleEdit = () => {
        setIsEditing(true);
    };
    
    const handleSave = () => {
        if (editText.trim()) {
            onUpdate(todo.id, editText.trim());
            setIsEditing(false);
        }
    };
    
    const handleCancel = () => {
        setEditText(todo.text);
        setIsEditing(false);
    };
    
    const handleKeyDown = (e) => {
        if (e.key === 'Enter') {
            handleSave();
        } else if (e.key === 'Escape') {
            handleCancel();
        }
    };
    
    return (
        <li className={`todo-item ${todo.completed ? 'completed' : ''} ${isEditing ? 'editing' : ''}`}>
            <input
                type="checkbox"
                className="todo-checkbox"
                checked={todo.completed}
                onChange={() => onToggle(todo.id)}
            />
            
            {isEditing ? (
                <input
                    type="text"
                    className="todo-edit-input"
                    value={editText}
                    onChange={(e) => setEditText(e.target.value)}
                    onBlur={handleSave}
                    onKeyDown={handleKeyDown}
                    autoFocus
                />
            ) : (
                <span className="todo-text" onDoubleClick={handleEdit}>
                    {todo.text}
                </span>
            )}
            
            <div className="todo-actions">
                <button
                    className="todo-btn edit-btn"
                    onClick={handleEdit}
                    disabled={isEditing}
                >
                    Edit
                </button>
                <button
                    className="todo-btn delete-btn"
                    onClick={() => onDelete(todo.id)}
                >
                    Delete
                </button>
            </div>
        </li>
    );
}

export default TodoItem;
```

### Step 4: Todo List Component

```javascript
// src/components/TodoList.jsx
import TodoItem from './TodoItem';
import './TodoList.css';

function TodoList({ todos, onToggle, onDelete, onUpdate }) {
    if (todos.length === 0) {
        return (
            <div className="empty-state">
                <p>No todos found. Add one to get started!</p>
            </div>
        );
    }
    
    return (
        <ul className="todo-list">
            {todos.map(todo => (
                <TodoItem
                    key={todo.id}
                    todo={todo}
                    onToggle={onToggle}
                    onDelete={onDelete}
                    onUpdate={onUpdate}
                />
            ))}
        </ul>
    );
}

export default TodoList;
```

### Step 5: Filter Buttons Component

```javascript
// src/components/FilterButtons.jsx
import './FilterButtons.css';

const filters = [
    { key: 'all', label: 'All' },
    { key: 'active', label: 'Active' },
    { key: 'completed', label: 'Completed' }
];

function FilterButtons({ currentFilter, onFilterChange }) {
    return (
        <div className="filters">
            {filters.map(filter => (
                <button
                    key={filter.key}
                    className={`filter-btn ${currentFilter === filter.key ? 'active' : ''}`}
                    onClick={() => onFilterChange(filter.key)}
                >
                    {filter.label}
                </button>
            ))}
        </div>
    );
}

export default FilterButtons;
```

### Step 6: Todo Stats Component

```javascript
// src/components/TodoStats.jsx
import './TodoStats.css';

function TodoStats({ todos, onClearCompleted }) {
    const activeCount = todos.filter(todo => !todo.completed).length;
    const completedCount = todos.filter(todo => todo.completed).length;
    
    return (
        <div className="todo-stats">
            <span className="todo-count">
                {activeCount} {activeCount === 1 ? 'item' : 'items'} left
            </span>
            <button
                className="clear-completed-btn"
                onClick={onClearCompleted}
                disabled={completedCount === 0}
            >
                Clear Completed
            </button>
        </div>
    );
}

export default TodoStats;
```

### Step 7: Main App Component

```javascript
// src/App.jsx
import { useState, useMemo } from 'react';
import useLocalStorage from './hooks/useLocalStorage';
import TodoForm from './components/TodoForm';
import TodoList from './components/TodoList';
import FilterButtons from './components/FilterButtons';
import TodoStats from './components/TodoStats';
import './App.css';

function App() {
    const [todos, setTodos] = useLocalStorage('todos', []);
    const [filter, setFilter] = useState('all');
    
    const addTodo = (text) => {
        const newTodo = {
            id: Date.now(),
            text,
            completed: false,
            createdAt: new Date().toISOString()
        };
        setTodos([...todos, newTodo]);
    };
    
    const toggleTodo = (id) => {
        setTodos(todos.map(todo =>
            todo.id === id ? { ...todo, completed: !todo.completed } : todo
        ));
    };
    
    const deleteTodo = (id) => {
        setTodos(todos.filter(todo => todo.id !== id));
    };
    
    const updateTodo = (id, newText) => {
        setTodos(todos.map(todo =>
            todo.id === id ? { ...todo, text: newText } : todo
        ));
    };
    
    const clearCompleted = () => {
        setTodos(todos.filter(todo => !todo.completed));
    };
    
    const filteredTodos = useMemo(() => {
        switch (filter) {
            case 'active':
                return todos.filter(todo => !todo.completed);
            case 'completed':
                return todos.filter(todo => todo.completed);
            default:
                return todos;
        }
    }, [todos, filter]);
    
    return (
        <div className="app">
            <div className="container">
                <header>
                    <h1>React Todo App</h1>
                </header>
                
                <main>
                    <TodoForm onAddTodo={addTodo} />
                    <FilterButtons
                        currentFilter={filter}
                        onFilterChange={setFilter}
                    />
                    <TodoList
                        todos={filteredTodos}
                        onToggle={toggleTodo}
                        onDelete={deleteTodo}
                        onUpdate={updateTodo}
                    />
                    <TodoStats
                        todos={todos}
                        onClearCompleted={clearCompleted}
                    />
                </main>
            </div>
        </div>
    );
}

export default App;
```

### Step 8: CSS Styling

```css
/* src/App.css */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
}

.app {
    min-height: 100vh;
    padding: 20px;
}

.container {
    max-width: 600px;
    margin: 0 auto;
    background: white;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    overflow: hidden;
}

header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    text-align: center;
}

header h1 {
    font-size: 2.5em;
    font-weight: 300;
}

main {
    padding: 30px;
}
```

```css
/* src/components/TodoForm.css */
.todo-form {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.todo-input {
    flex: 1;
    padding: 12px;
    border: 2px solid #e0e0e0;
    border-radius: 5px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.todo-input:focus {
    outline: none;
    border-color: #667eea;
}

.todo-button {
    padding: 12px 24px;
    background: #667eea;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
}

.todo-button:hover {
    background: #5568d3;
}
```

```css
/* src/components/TodoItem.css */
.todo-item {
    display: flex;
    align-items: center;
    padding: 15px;
    margin-bottom: 10px;
    background: #f9f9f9;
    border-radius: 5px;
    transition: all 0.3s;
}

.todo-item:hover {
    background: #f0f0f0;
}

.todo-item.completed {
    opacity: 0.6;
}

.todo-item.completed .todo-text {
    text-decoration: line-through;
}

.todo-checkbox {
    width: 20px;
    height: 20px;
    margin-right: 15px;
    cursor: pointer;
}

.todo-text {
    flex: 1;
    font-size: 16px;
    color: #333;
    cursor: pointer;
}

.todo-item.editing .todo-text {
    display: none;
}

.todo-edit-input {
    flex: 1;
    padding: 8px;
    border: 2px solid #667eea;
    border-radius: 5px;
    font-size: 16px;
    display: none;
}

.todo-item.editing .todo-edit-input {
    display: block;
}

.todo-actions {
    display: flex;
    gap: 10px;
}

.todo-btn {
    padding: 5px 10px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s;
}

.edit-btn {
    background: #4caf50;
    color: white;
}

.edit-btn:hover:not(:disabled) {
    background: #45a049;
}

.delete-btn {
    background: #f44336;
    color: white;
}

.delete-btn:hover {
    background: #da190b;
}

.todo-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
```

```css
/* src/components/FilterButtons.css */
.filters {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    justify-content: center;
}

.filter-btn {
    padding: 8px 16px;
    background: #f5f5f5;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s;
}

.filter-btn:hover {
    background: #e0e0e0;
}

.filter-btn.active {
    background: #667eea;
    color: white;
    border-color: #667eea;
}
```

```css
/* src/components/TodoStats.css */
.todo-stats {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 20px;
    border-top: 1px solid #e0e0e0;
}

.todo-count {
    color: #666;
    font-size: 14px;
}

.clear-completed-btn {
    padding: 8px 16px;
    background: #f44336;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s;
}

.clear-completed-btn:hover:not(:disabled) {
    background: #da190b;
}

.clear-completed-btn:disabled {
    background: #ccc;
    cursor: not-allowed;
}
```

---

## Features Implementation

### React Components

- **Functional Components**: All components use function syntax
- **Props**: Data passed via props
- **State Management**: useState and custom hooks
- **Component Composition**: Reusable components

### State Management

- **useState**: Local component state
- **useLocalStorage**: Custom hook for persistence
- **useMemo**: Optimize filtered todos
- **Lifting State**: State managed in App component

### Local Storage

- **Custom Hook**: useLocalStorage hook
- **Automatic Sync**: Data saved automatically
- **Load on Mount**: Data loaded on app start

---

## Testing Your Application

### Manual Testing Checklist

- [ ] Add new todos
- [ ] Toggle todo completion
- [ ] Edit todo text
- [ ] Delete todos
- [ ] Filter todos
- [ ] Clear completed
- [ ] Refresh page (data persists)
- [ ] Test with empty input
- [ ] Test keyboard shortcuts

---

## Exercise: React Todo App

**Instructions**:

1. Set up React project
2. Create all components
3. Implement all features
4. Test thoroughly
5. Customize design

**Enhancement Ideas**:

- Add due dates
- Add priority levels
- Add categories
- Add search functionality
- Add drag-and-drop
- Add animations
- Add dark mode
- Add export/import

---

## Common Issues and Solutions

### Issue: State not updating

**Solution**: Ensure you're using functional updates or spreading state correctly.

### Issue: Local storage not working

**Solution**: Check browser console for errors. Ensure localStorage is enabled.

### Issue: Components not re-rendering

**Solution**: Check that state updates are creating new objects/arrays.

---

## Quiz: React Project

1. **React components:**
   - A) Reusable UI pieces
   - B) Not reusable
   - C) Both
   - D) Neither

2. **useState:**
   - A) Manages state
   - B) Doesn't manage state
   - C) Both
   - D) Neither

3. **Props:**
   - A) Pass data to components
   - B) Don't pass data
   - C) Both
   - D) Neither

4. **useEffect:**
   - A) Handles side effects
   - B) Doesn't handle side effects
   - C) Both
   - D) Neither

5. **Local storage:**
   - A) Persists data
   - B) Temporary data
   - C) Both
   - D) Neither

**Answers**:
1. A) Reusable UI pieces
2. A) Manages state
3. A) Pass data to components
4. A) Handles side effects
5. A) Persists data

---

## Key Takeaways

1. **React Components**: Build reusable UI components
2. **State Management**: Use hooks for state
3. **Local Storage**: Persist data in browser
4. **Component Structure**: Organize components well
5. **Best Practice**: Clean, maintainable code

---

## Next Steps

Congratulations! You've built a React Todo App. You now know:
- How to create React components
- How to manage state
- How to use local storage
- How to structure React apps

**What's Next?**
- Project 2.2: React Blog Application
- Learn React Router
- Build a blog application
- Integrate with APIs

---

*Project completed! You're ready to move on to the next project.*

