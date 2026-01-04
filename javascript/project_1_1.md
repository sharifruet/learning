# Project 1.1: Todo List Application

## Project Overview

Build a fully functional Todo List application using vanilla JavaScript. This project will help you practice DOM manipulation, event handling, local storage, and CRUD operations.

## Learning Objectives

By the end of this project, you will be able to:
- Manipulate the DOM dynamically
- Handle various user events
- Store data in local storage
- Implement CRUD operations
- Build a complete interactive application
- Structure JavaScript code effectively

---

## Project Requirements

### Core Features

1. **Add Todos**: Users can add new todo items
2. **View Todos**: Display all todos in a list
3. **Edit Todos**: Update existing todo items
4. **Delete Todos**: Remove todo items
5. **Mark Complete**: Toggle completion status
6. **Filter Todos**: Filter by all/active/completed
7. **Persist Data**: Save todos to local storage
8. **Clear Completed**: Remove all completed todos

### Technical Requirements

- Use vanilla JavaScript (no frameworks)
- Use semantic HTML5
- Responsive CSS design
- Local storage for persistence
- Clean, organized code structure
- Error handling

---

## Project Structure

```
todo-app/
├── index.html
├── css/
│   └── style.css
├── js/
│   ├── app.js
│   ├── todo.js
│   └── storage.js
└── README.md
```

---

## Step-by-Step Implementation

### Step 1: HTML Structure

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List Application</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>My Todo List</h1>
        </header>
        
        <main>
            <!-- Add Todo Form -->
            <form id="todo-form">
                <input 
                    type="text" 
                    id="todo-input" 
                    placeholder="Add a new todo..."
                    required
                >
                <button type="submit">Add</button>
            </form>
            
            <!-- Filter Buttons -->
            <div class="filters">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="active">Active</button>
                <button class="filter-btn" data-filter="completed">Completed</button>
            </div>
            
            <!-- Todo List -->
            <ul id="todo-list"></ul>
            
            <!-- Todo Stats -->
            <div class="stats">
                <span id="todo-count">0 items left</span>
                <button id="clear-completed">Clear Completed</button>
            </div>
        </main>
    </div>
    
    <script src="js/storage.js"></script>
    <script src="js/todo.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
```

### Step 2: CSS Styling

```css
/* css/style.css */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

#todo-form {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

#todo-input {
    flex: 1;
    padding: 12px;
    border: 2px solid #e0e0e0;
    border-radius: 5px;
    font-size: 16px;
    transition: border-color 0.3s;
}

#todo-input:focus {
    outline: none;
    border-color: #667eea;
}

#todo-form button {
    padding: 12px 24px;
    background: #667eea;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
}

#todo-form button:hover {
    background: #5568d3;
}

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

#todo-list {
    list-style: none;
    margin-bottom: 20px;
}

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

.edit-btn:hover {
    background: #45a049;
}

.delete-btn {
    background: #f44336;
    color: white;
}

.delete-btn:hover {
    background: #da190b;
}

.stats {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 20px;
    border-top: 1px solid #e0e0e0;
}

#todo-count {
    color: #666;
    font-size: 14px;
}

#clear-completed {
    padding: 8px 16px;
    background: #f44336;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s;
}

#clear-completed:hover {
    background: #da190b;
}

#clear-completed:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.empty-state {
    text-align: center;
    padding: 40px;
    color: #999;
}

.empty-state.hidden {
    display: none;
}
```

### Step 3: Storage Module

```javascript
// js/storage.js
class Storage {
    static getTodos() {
        const todos = localStorage.getItem('todos');
        return todos ? JSON.parse(todos) : [];
    }
    
    static saveTodos(todos) {
        localStorage.setItem('todos', JSON.stringify(todos));
    }
    
    static addTodo(todo) {
        const todos = this.getTodos();
        todos.push(todo);
        this.saveTodos(todos);
        return todo;
    }
    
    static updateTodo(id, updates) {
        const todos = this.getTodos();
        const index = todos.findIndex(todo => todo.id === id);
        if (index !== -1) {
            todos[index] = { ...todos[index], ...updates };
            this.saveTodos(todos);
            return todos[index];
        }
        return null;
    }
    
    static deleteTodo(id) {
        const todos = this.getTodos();
        const filtered = todos.filter(todo => todo.id !== id);
        this.saveTodos(filtered);
        return filtered;
    }
    
    static clearCompleted() {
        const todos = this.getTodos();
        const active = todos.filter(todo => !todo.completed);
        this.saveTodos(active);
        return active;
    }
}
```

### Step 4: Todo Model

```javascript
// js/todo.js
class Todo {
    constructor(id, text, completed = false) {
        this.id = id;
        this.text = text;
        this.completed = completed;
        this.createdAt = new Date().toISOString();
    }
    
    toggle() {
        this.completed = !this.completed;
        return this;
    }
    
    updateText(newText) {
        this.text = newText;
        return this;
    }
    
    toJSON() {
        return {
            id: this.id,
            text: this.text,
            completed: this.completed,
            createdAt: this.createdAt
        };
    }
    
    static fromJSON(data) {
        const todo = new Todo(data.id, data.text, data.completed);
        todo.createdAt = data.createdAt;
        return todo;
    }
}
```

### Step 5: Main Application

```javascript
// js/app.js
class TodoApp {
    constructor() {
        this.todos = [];
        this.currentFilter = 'all';
        this.editingId = null;
        
        this.initializeElements();
        this.loadTodos();
        this.attachEventListeners();
        this.render();
    }
    
    initializeElements() {
        this.form = document.getElementById('todo-form');
        this.input = document.getElementById('todo-input');
        this.todoList = document.getElementById('todo-list');
        this.filterBtns = document.querySelectorAll('.filter-btn');
        this.todoCount = document.getElementById('todo-count');
        this.clearCompletedBtn = document.getElementById('clear-completed');
    }
    
    loadTodos() {
        const todosData = Storage.getTodos();
        this.todos = todosData.map(data => Todo.fromJSON(data));
    }
    
    attachEventListeners() {
        // Form submission
        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.addTodo();
        });
        
        // Filter buttons
        this.filterBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.setFilter(e.target.dataset.filter);
            });
        });
        
        // Clear completed
        this.clearCompletedBtn.addEventListener('click', () => {
            this.clearCompleted();
        });
    }
    
    addTodo() {
        const text = this.input.value.trim();
        if (!text) return;
        
        const todo = new Todo(Date.now(), text);
        Storage.addTodo(todo.toJSON());
        this.todos.push(todo);
        this.input.value = '';
        this.render();
    }
    
    deleteTodo(id) {
        this.todos = Storage.deleteTodo(id);
        this.render();
    }
    
    toggleTodo(id) {
        const todo = this.todos.find(t => t.id === id);
        if (todo) {
            todo.toggle();
            Storage.updateTodo(id, { completed: todo.completed });
            this.render();
        }
    }
    
    startEditing(id) {
        this.editingId = id;
        this.render();
    }
    
    saveEdit(id, newText) {
        const text = newText.trim();
        if (!text) {
            this.cancelEdit();
            return;
        }
        
        const todo = this.todos.find(t => t.id === id);
        if (todo) {
            todo.updateText(text);
            Storage.updateTodo(id, { text: todo.text });
            this.editingId = null;
            this.render();
        }
    }
    
    cancelEdit() {
        this.editingId = null;
        this.render();
    }
    
    setFilter(filter) {
        this.currentFilter = filter;
        this.filterBtns.forEach(btn => {
            btn.classList.toggle('active', btn.dataset.filter === filter);
        });
        this.render();
    }
    
    clearCompleted() {
        this.todos = Storage.clearCompleted();
        this.render();
    }
    
    getFilteredTodos() {
        switch (this.currentFilter) {
            case 'active':
                return this.todos.filter(todo => !todo.completed);
            case 'completed':
                return this.todos.filter(todo => todo.completed);
            default:
                return this.todos;
        }
    }
    
    getActiveCount() {
        return this.todos.filter(todo => !todo.completed).length;
    }
    
    render() {
        const filteredTodos = this.getFilteredTodos();
        
        // Render todos
        if (filteredTodos.length === 0) {
            this.todoList.innerHTML = `
                <li class="empty-state">
                    <p>No todos found. Add one to get started!</p>
                </li>
            `;
        } else {
            this.todoList.innerHTML = filteredTodos.map(todo => {
                const isEditing = this.editingId === todo.id;
                return `
                    <li class="todo-item ${todo.completed ? 'completed' : ''} ${isEditing ? 'editing' : ''}">
                        <input 
                            type="checkbox" 
                            class="todo-checkbox" 
                            ${todo.completed ? 'checked' : ''}
                            onchange="app.toggleTodo(${todo.id})"
                        >
                        <span class="todo-text">${this.escapeHtml(todo.text)}</span>
                        <input 
                            type="text" 
                            class="todo-edit-input" 
                            value="${this.escapeHtml(todo.text)}"
                            onblur="app.saveEdit(${todo.id}, this.value)"
                            onkeypress="if(event.key === 'Enter') app.saveEdit(${todo.id}, this.value)"
                            onkeydown="if(event.key === 'Escape') app.cancelEdit()"
                        >
                        <div class="todo-actions">
                            <button class="todo-btn edit-btn" onclick="app.startEditing(${todo.id})">
                                Edit
                            </button>
                            <button class="todo-btn delete-btn" onclick="app.deleteTodo(${todo.id})">
                                Delete
                            </button>
                        </div>
                    </li>
                `;
            }).join('');
        }
        
        // Update count
        const activeCount = this.getActiveCount();
        this.todoCount.textContent = `${activeCount} ${activeCount === 1 ? 'item' : 'items'} left`;
        
        // Update clear completed button
        const completedCount = this.todos.filter(t => t.completed).length;
        this.clearCompletedBtn.disabled = completedCount === 0;
    }
    
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Initialize app
const app = new TodoApp();
```

---

## Features Implementation

### DOM Manipulation

- **Dynamic List Rendering**: Todos are rendered dynamically based on state
- **Event Delegation**: Efficient event handling
- **DOM Updates**: Smooth updates without page refresh

### Event Handling

- **Form Submission**: Add new todos
- **Click Events**: Edit, delete, toggle todos
- **Keyboard Events**: Enter to save, Escape to cancel
- **Change Events**: Checkbox toggles

### Local Storage

- **Persist Data**: Todos saved automatically
- **Load on Start**: Todos loaded when app starts
- **Sync Updates**: All changes saved immediately

### CRUD Operations

- **Create**: Add new todos
- **Read**: Display todos with filtering
- **Update**: Edit todo text and toggle completion
- **Delete**: Remove individual or completed todos

---

## Testing Your Application

### Manual Testing Checklist

- [ ] Add a new todo
- [ ] Mark todo as complete
- [ ] Edit todo text
- [ ] Delete a todo
- [ ] Filter by All/Active/Completed
- [ ] Clear all completed todos
- [ ] Refresh page (data should persist)
- [ ] Test with empty input
- [ ] Test with special characters
- [ ] Test keyboard shortcuts

---

## Exercise: Build Todo App

**Instructions**:

1. Create the project structure
2. Implement all files as shown
3. Test all features
4. Customize the design
5. Add your own enhancements

**Enhancement Ideas**:

- Add due dates
- Add priority levels
- Add categories/tags
- Add search functionality
- Add drag-and-drop reordering
- Add animations
- Add dark mode
- Add export/import functionality

---

## Common Issues and Solutions

### Issue: Todos not persisting

**Solution**: Check browser console for errors. Ensure localStorage is enabled.

### Issue: Events not working

**Solution**: Make sure DOM is loaded before initializing app. Use DOMContentLoaded event if needed.

### Issue: Editing not working

**Solution**: Check that editingId is being set correctly and input events are attached.

---

## Quiz: Project Concepts

1. **Local storage stores data as:**
   - A) Strings
   - B) Objects
   - C) Both (JSON stringified)
   - D) Neither

2. **DOM manipulation:**
   - A) Changes page structure
   - B) Doesn't change page
   - C) Both
   - D) Neither

3. **Event handling:**
   - A) Responds to user actions
   - B) Doesn't respond
   - C) Both
   - D) Neither

4. **CRUD stands for:**
   - A) Create, Read, Update, Delete
   - B) Create, Remove, Update, Delete
   - C) Both
   - D) Neither

5. **Local storage:**
   - A) Persists data
   - B) Temporary data
   - C) Both
   - D) Neither

**Answers**:
1. A) Strings (JSON stringified)
2. A) Changes page structure
3. A) Responds to user actions
4. A) Create, Read, Update, Delete
5. A) Persists data

---

## Key Takeaways

1. **DOM Manipulation**: Essential for dynamic web pages
2. **Event Handling**: Responds to user interactions
3. **Local Storage**: Persists data in browser
4. **CRUD Operations**: Core functionality of most apps
5. **Code Organization**: Separate concerns into modules
6. **Best Practice**: Clean, maintainable code structure

---

## Next Steps

Congratulations! You've built a complete Todo List application. You now know:
- How to manipulate the DOM
- How to handle events
- How to use local storage
- How to implement CRUD operations

**What's Next?**
- Project 1.2: Weather App
- Learn API integration
- Work with external data
- Build a weather application

---

*Project completed! You're ready to move on to the next project.*

