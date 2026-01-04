# Lesson 14.2: Event Propagation

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand event bubbling
- Understand event capturing
- Use stopPropagation() to stop event propagation
- Use preventDefault() to prevent default behavior
- Implement event delegation
- Control event flow effectively
- Build efficient event handling systems

---

## Introduction to Event Propagation

Event propagation is the mechanism by which events travel through the DOM tree. Understanding propagation is crucial for effective event handling.

### Event Propagation Phases

1. **Capturing Phase**: Event travels down from document to target
2. **Target Phase**: Event reaches the target element
3. **Bubbling Phase**: Event travels up from target to document

---

## Event Bubbling

Event bubbling means events bubble up from the target element to the document root.

### How Bubbling Works

```html
<div id="grandparent">
    <div id="parent">
        <div id="child">Click me</div>
    </div>
</div>
```

```javascript
document.getElementById('grandparent').addEventListener('click', function() {
    console.log('Grandparent clicked');
});

document.getElementById('parent').addEventListener('click', function() {
    console.log('Parent clicked');
});

document.getElementById('child').addEventListener('click', function() {
    console.log('Child clicked');
});

// Clicking child outputs:
// Child clicked
// Parent clicked
// Grandparent clicked
```

### Bubbling Example

```javascript
let container = document.getElementById('container');
let button = document.getElementById('button');

button.addEventListener('click', function(event) {
    console.log('Button clicked');
});

container.addEventListener('click', function(event) {
    console.log('Container clicked');
});

// Clicking button triggers both handlers
```

---

## Event Capturing

Event capturing means events are captured on the way down to the target.

### How Capturing Works

```javascript
document.getElementById('grandparent').addEventListener('click', function() {
    console.log('Grandparent captured');
}, true);  // Use capture phase

document.getElementById('parent').addEventListener('click', function() {
    console.log('Parent captured');
}, true);

document.getElementById('child').addEventListener('click', function() {
    console.log('Child clicked');
});

// Clicking child outputs:
// Grandparent captured
// Parent captured
// Child clicked
```

### Capture vs Bubble

```javascript
// Capture phase (true)
element.addEventListener('click', handler, true);

// Bubble phase (false or omitted)
element.addEventListener('click', handler, false);
element.addEventListener('click', handler);  // Default: bubble
```

---

## stopPropagation()

`stopPropagation()` stops the event from propagating to other elements.

### Stopping Bubbling

```javascript
let parent = document.getElementById('parent');
let child = document.getElementById('child');

child.addEventListener('click', function(event) {
    console.log('Child clicked');
    event.stopPropagation();  // Stop bubbling
});

parent.addEventListener('click', function() {
    console.log('Parent clicked');  // Won't execute
});

// Only "Child clicked" is logged
```

### Stopping Capturing

```javascript
let parent = document.getElementById('parent');
let child = document.getElementById('child');

parent.addEventListener('click', function(event) {
    console.log('Parent captured');
    event.stopPropagation();  // Stop capturing
}, true);

child.addEventListener('click', function() {
    console.log('Child clicked');  // Won't execute
});
```

### stopImmediatePropagation()

Stops propagation and prevents other listeners on same element:

```javascript
button.addEventListener('click', function(event) {
    console.log('Handler 1');
    event.stopImmediatePropagation();  // Stops all other handlers
});

button.addEventListener('click', function() {
    console.log('Handler 2');  // Won't execute
});

// Only "Handler 1" is logged
```

---

## preventDefault()

`preventDefault()` prevents the default behavior of an event.

### Common Use Cases

```javascript
// Prevent form submission
form.addEventListener('submit', function(event) {
    event.preventDefault();
    // Handle form manually
});

// Prevent link navigation
link.addEventListener('click', function(event) {
    event.preventDefault();
    // Handle navigation manually
});

// Prevent context menu
element.addEventListener('contextmenu', function(event) {
    event.preventDefault();
    // Show custom menu
});
```

### preventDefault() vs stopPropagation()

```javascript
// preventDefault(): Prevents default behavior
link.addEventListener('click', function(event) {
    event.preventDefault();  // Link won't navigate
    // Event still bubbles
});

// stopPropagation(): Stops event propagation
link.addEventListener('click', function(event) {
    event.stopPropagation();  // Event won't bubble
    // Link still navigates (default behavior)
});

// Both
link.addEventListener('click', function(event) {
    event.preventDefault();      // Prevent navigation
    event.stopPropagation();     // Stop bubbling
});
```

---

## Event Delegation

Event delegation uses event bubbling to handle events on multiple elements with a single listener.

### Problem: Multiple Listeners

```javascript
// ⚠️ Problem: Many listeners
let items = document.querySelectorAll('.item');
items.forEach(item => {
    item.addEventListener('click', function() {
        console.log('Item clicked');
    });
});

// New items added dynamically won't have listeners
```

### Solution: Event Delegation

```javascript
// ✅ Solution: Single listener on parent
let list = document.getElementById('list');

list.addEventListener('click', function(event) {
    // Check if clicked element is an item
    if (event.target.classList.contains('item')) {
        console.log('Item clicked:', event.target.textContent);
    }
});

// Works for dynamically added items too!
```

### Event Delegation Benefits

- **Performance**: Fewer event listeners
- **Dynamic Elements**: Works with dynamically added elements
- **Memory**: Less memory usage
- **Flexibility**: Easy to add/remove items

### Event Delegation Pattern

```javascript
parent.addEventListener('click', function(event) {
    // Check if target matches selector
    if (event.target.matches('.item')) {
        // Handle event
        handleItemClick(event.target);
    }
});

// Or use closest() for nested elements
parent.addEventListener('click', function(event) {
    let item = event.target.closest('.item');
    if (item) {
        handleItemClick(item);
    }
});
```

---

## Practical Examples

### Example 1: Stop Bubbling

```javascript
let container = document.getElementById('container');
let button = document.getElementById('button');

button.addEventListener('click', function(event) {
    console.log('Button clicked');
    event.stopPropagation();  // Don't bubble to container
});

container.addEventListener('click', function() {
    console.log('Container clicked');  // Won't execute
});
```

### Example 2: Prevent Default

```javascript
let form = document.getElementById('myForm');

form.addEventListener('submit', function(event) {
    event.preventDefault();  // Prevent form submission
    
    // Validate and process
    let formData = new FormData(form);
    console.log('Form data:', formData);
    
    // Submit via AJAX instead
    fetch('/api/submit', {
        method: 'POST',
        body: formData
    });
});
```

### Example 3: Event Delegation for List

```javascript
let todoList = document.getElementById('todoList');

// Single listener for all items
todoList.addEventListener('click', function(event) {
    let item = event.target.closest('.todo-item');
    if (item) {
        // Handle item click
        if (event.target.classList.contains('delete-btn')) {
            item.remove();
        } else if (event.target.classList.contains('complete-btn')) {
            item.classList.toggle('completed');
        }
    }
});

// Add new items dynamically
function addTodoItem(text) {
    let li = document.createElement('li');
    li.className = 'todo-item';
    li.innerHTML = `
        <span>${text}</span>
        <button class="complete-btn">Complete</button>
        <button class="delete-btn">Delete</button>
    `;
    todoList.appendChild(li);
    // No need to add listeners - delegation handles it!
}
```

### Example 4: Modal Close on Outside Click

```javascript
let modal = document.getElementById('modal');
let modalContent = document.getElementById('modalContent');

modal.addEventListener('click', function(event) {
    // If click is outside modal content
    if (!modalContent.contains(event.target)) {
        modal.style.display = 'none';
    }
});

// Prevent clicks inside modal from closing
modalContent.addEventListener('click', function(event) {
    event.stopPropagation();
});
```

---

## Practice Exercise

### Exercise: Event Propagation

**Objective**: Practice event propagation, stopping propagation, and event delegation.

**Instructions**:

1. Create an HTML file with nested elements
2. Create a JavaScript file for event handling
3. Practice:
   - Event bubbling
   - Event capturing
   - stopPropagation()
   - preventDefault()
   - Event delegation

**Example Solution**:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Propagation Practice</title>
    <style>
        .container {
            padding: 20px;
            border: 2px solid blue;
            margin: 10px;
        }
        .box {
            padding: 15px;
            border: 2px solid green;
            margin: 10px;
        }
        .item {
            padding: 10px;
            border: 2px solid red;
            margin: 5px;
            cursor: pointer;
        }
        .highlight {
            background-color: yellow;
        }
    </style>
</head>
<body>
    <h1>Event Propagation Practice</h1>
    
    <div id="grandparent" class="container">
        Grandparent
        <div id="parent" class="box">
            Parent
            <div id="child" class="item">Child - Click me</div>
        </div>
    </div>
    
    <form id="myForm">
        <input type="text" name="username" placeholder="Username">
        <button type="submit">Submit</button>
    </form>
    
    <ul id="todoList">
        <li class="todo-item">
            <span>Task 1</span>
            <button class="delete-btn">Delete</button>
        </li>
        <li class="todo-item">
            <span>Task 2</span>
            <button class="delete-btn">Delete</button>
        </li>
    </ul>
    <button id="addTask">Add Task</button>
    
    <script src="event-propagation.js"></script>
</body>
</html>
```

```javascript
// event-propagation.js
console.log("=== Event Propagation Practice ===");

console.log("\n=== Event Bubbling ===");

let grandparent = document.getElementById('grandparent');
let parent = document.getElementById('parent');
let child = document.getElementById('child');

grandparent.addEventListener('click', function(event) {
    console.log('Grandparent clicked (bubble)');
    event.currentTarget.classList.add('highlight');
    setTimeout(() => event.currentTarget.classList.remove('highlight'), 500);
});

parent.addEventListener('click', function(event) {
    console.log('Parent clicked (bubble)');
    event.currentTarget.classList.add('highlight');
    setTimeout(() => event.currentTarget.classList.remove('highlight'), 500);
});

child.addEventListener('click', function(event) {
    console.log('Child clicked (bubble)');
    event.currentTarget.classList.add('highlight');
    setTimeout(() => event.currentTarget.classList.remove('highlight'), 500);
});

// Clicking child triggers all three (bubbling)
console.log();

console.log("=== Event Capturing ===");

let grandparentCapture = document.getElementById('grandparent');
let parentCapture = document.getElementById('parent');
let childCapture = document.getElementById('child');

grandparentCapture.addEventListener('click', function(event) {
    console.log('Grandparent captured');
}, true);  // Capture phase

parentCapture.addEventListener('click', function(event) {
    console.log('Parent captured');
}, true);  // Capture phase

childCapture.addEventListener('click', function(event) {
    console.log('Child clicked');
});  // Bubble phase (default)

// Clicking child outputs: Grandparent captured, Parent captured, Child clicked
console.log();

console.log("=== stopPropagation() ===");

let stopParent = document.getElementById('parent');
let stopChild = document.getElementById('child');

// Create new elements for stopPropagation demo
let stopContainer = document.createElement('div');
stopContainer.className = 'container';
stopContainer.id = 'stopContainer';
stopContainer.innerHTML = `
    <div class="box" id="stopParent">
        <div class="item" id="stopChild">Click to stop propagation</div>
    </div>
`;
document.body.appendChild(stopContainer);

let stopParentEl = document.getElementById('stopParent');
let stopChildEl = document.getElementById('stopChild');

stopParentEl.addEventListener('click', function() {
    console.log('Parent clicked (should not see this)');
});

stopChildEl.addEventListener('click', function(event) {
    console.log('Child clicked - stopping propagation');
    event.stopPropagation();  // Stop bubbling
});
console.log();

console.log("=== preventDefault() ===");

let form = document.getElementById('myForm');

form.addEventListener('submit', function(event) {
    event.preventDefault();  // Prevent form submission
    console.log('Form submission prevented');
    
    let formData = new FormData(form);
    let username = formData.get('username');
    console.log('Username:', username);
    
    alert('Form would submit: ' + username);
});
console.log();

console.log("=== Event Delegation ===");

let todoList = document.getElementById('todoList');
let addTaskBtn = document.getElementById('addTask');

// Single listener for all items (including dynamically added)
todoList.addEventListener('click', function(event) {
    let item = event.target.closest('.todo-item');
    
    if (item) {
        if (event.target.classList.contains('delete-btn')) {
            console.log('Delete button clicked');
            item.remove();
        } else if (event.target.tagName === 'SPAN') {
            console.log('Task clicked:', event.target.textContent);
            item.classList.toggle('highlight');
        }
    }
});

// Add new tasks dynamically
addTaskBtn.addEventListener('click', function() {
    let taskNumber = todoList.children.length + 1;
    let li = document.createElement('li');
    li.className = 'todo-item';
    li.innerHTML = `
        <span>Task ${taskNumber}</span>
        <button class="delete-btn">Delete</button>
    `;
    todoList.appendChild(li);
    console.log(`Added Task ${taskNumber} (delegation handles clicks)`);
});
console.log();

console.log("=== stopImmediatePropagation() ===");

let immediateBtn = document.createElement('button');
immediateBtn.textContent = 'Stop Immediate Propagation';
document.body.appendChild(immediateBtn);

immediateBtn.addEventListener('click', function(event) {
    console.log('Handler 1');
    event.stopImmediatePropagation();  // Stops other handlers
});

immediateBtn.addEventListener('click', function() {
    console.log('Handler 2');  // Won't execute
});

immediateBtn.addEventListener('click', function() {
    console.log('Handler 3');  // Won't execute
});
console.log();

console.log("=== Combined: preventDefault and stopPropagation ===");

let link = document.createElement('a');
link.href = 'https://example.com';
link.textContent = 'Link (prevented)';
link.style.display = 'block';
link.style.margin = '10px';
document.body.appendChild(link);

link.addEventListener('click', function(event) {
    event.preventDefault();      // Prevent navigation
    event.stopPropagation();     // Stop bubbling
    console.log('Link clicked - default prevented and propagation stopped');
    alert('Link click handled, navigation prevented');
});
console.log();

console.log("=== Event Delegation with matches() ===");

let container = document.createElement('div');
container.id = 'delegationContainer';
container.className = 'container';
container.innerHTML = `
    <button class="action-btn" data-action="save">Save</button>
    <button class="action-btn" data-action="delete">Delete</button>
    <button class="action-btn" data-action="edit">Edit</button>
    <div class="info">Click buttons above</div>
`;
document.body.appendChild(container);

let infoDiv = container.querySelector('.info');

container.addEventListener('click', function(event) {
    if (event.target.matches('.action-btn')) {
        let action = event.target.dataset.action;
        console.log(`Action: ${action}`);
        infoDiv.textContent = `Last action: ${action}`;
    }
});
console.log();

console.log("=== Nested Event Delegation ===");

let nestedList = document.createElement('ul');
nestedList.id = 'nestedList';
nestedList.innerHTML = `
    <li class="category">
        <span class="category-name">Category 1</span>
        <ul>
            <li class="item">Item 1.1</li>
            <li class="item">Item 1.2</li>
        </ul>
    </li>
    <li class="category">
        <span class="category-name">Category 2</span>
        <ul>
            <li class="item">Item 2.1</li>
            <li class="item">Item 2.2</li>
        </ul>
    </li>
`;
document.body.appendChild(nestedList);

nestedList.addEventListener('click', function(event) {
    // Handle category clicks
    if (event.target.classList.contains('category-name')) {
        console.log('Category clicked:', event.target.textContent);
        event.target.parentElement.classList.toggle('highlight');
    }
    
    // Handle item clicks (using closest for nested elements)
    let item = event.target.closest('.item');
    if (item && event.target === item) {
        console.log('Item clicked:', item.textContent);
        item.classList.toggle('highlight');
    }
});
```

**Expected Output** (in browser console):
```
=== Event Propagation Practice ===

=== Event Bubbling ===
[On clicking child]
Child clicked (bubble)
Parent clicked (bubble)
Grandparent clicked (bubble)

=== Event Capturing ===
[On clicking child]
Grandparent captured
Parent captured
Child clicked

=== stopPropagation() ===
[On clicking stopChild]
Child clicked - stopping propagation

=== preventDefault() ===
[On form submit]
Form submission prevented
Username: [value]

=== Event Delegation ===
[On clicking delete button]
Delete button clicked
[On clicking task]
Task clicked: Task 1
[On adding task]
Added Task 3 (delegation handles clicks)

=== stopImmediatePropagation() ===
[On clicking button]
Handler 1

=== Combined: preventDefault and stopPropagation ===
[On clicking link]
Link clicked - default prevented and propagation stopped

=== Event Delegation with matches() ===
[On clicking button]
Action: save
[On clicking button]
Action: delete

=== Nested Event Delegation ===
[On clicking category]
Category clicked: Category 1
[On clicking item]
Item clicked: Item 1.1
```

**Challenge (Optional)**:
- Build a complex event delegation system
- Create a modal system with outside click detection
- Build a nested menu system
- Create a drag-and-drop with event handling

---

## Common Mistakes

### 1. Confusing preventDefault and stopPropagation

```javascript
// ⚠️ Confusion
event.preventDefault();   // Prevents default behavior
event.stopPropagation();  // Stops event propagation

// They do different things!
```

### 2. Not Using Event Delegation

```javascript
// ⚠️ Problem: Many listeners, doesn't work with dynamic elements
items.forEach(item => {
    item.addEventListener('click', handler);
});

// ✅ Solution: Event delegation
parent.addEventListener('click', function(event) {
    if (event.target.matches('.item')) {
        handler(event.target);
    }
});
```

### 3. stopPropagation Too Early

```javascript
// ⚠️ Problem: Stops before handling
child.addEventListener('click', function(event) {
    event.stopPropagation();  // Stops immediately
    // Do something
    // Parent won't receive event (might be needed)
});

// ✅ Solution: Only stop if needed
child.addEventListener('click', function(event) {
    // Do something
    if (shouldStopPropagation) {
        event.stopPropagation();
    }
});
```

### 4. Wrong Target in Delegation

```javascript
// ⚠️ Problem: Target might be nested element
list.addEventListener('click', function(event) {
    event.target.classList.add('active');  // Might be span inside li
});

// ✅ Solution: Use closest()
list.addEventListener('click', function(event) {
    let item = event.target.closest('.item');
    if (item) {
        item.classList.add('active');
    }
});
```

---

## Key Takeaways

1. **Event Bubbling**: Events bubble up from target to document
2. **Event Capturing**: Events captured on way down (use true option)
3. **stopPropagation()**: Stops event propagation
4. **preventDefault()**: Prevents default behavior
5. **Event Delegation**: Single listener on parent for multiple children
6. **closest()**: Find ancestor matching selector
7. **matches()**: Check if element matches selector
8. **Best Practice**: Use event delegation for dynamic elements

---

## Quiz: Event Propagation

Test your understanding with these questions:

1. **Event bubbling:**
   - A) Goes down
   - B) Goes up
   - C) Stays at target
   - D) Doesn't happen

2. **Event capturing uses:**
   - A) addEventListener(..., true)
   - B) addEventListener(..., false)
   - C) No option
   - D) preventDefault()

3. **stopPropagation() stops:**
   - A) Default behavior
   - B) Event propagation
   - C) Event listener
   - D) Nothing

4. **preventDefault() prevents:**
   - A) Event propagation
   - B) Default behavior
   - C) Event listener
   - D) Nothing

5. **Event delegation uses:**
   - A) Multiple listeners
   - B) Single listener on parent
   - C) No listeners
   - D) Inline handlers

6. **closest() finds:**
   - A) Child element
   - B) Ancestor element
   - C) Sibling element
   - D) Any element

7. **stopImmediatePropagation() stops:**
   - A) Propagation only
   - B) Other listeners on same element
   - C) Default behavior
   - D) Nothing

**Answers**:
1. B) Goes up
2. A) addEventListener(..., true)
3. B) Event propagation
4. B) Default behavior
5. B) Single listener on parent
6. B) Ancestor element
7. B) Other listeners on same element

---

## Next Steps

Congratulations! You've learned event propagation. You now know:
- How event bubbling and capturing work
- How to stop propagation
- How to prevent default behavior
- How to use event delegation

**What's Next?**
- Lesson 14.3: Advanced Events
- Learn custom events
- Understand debouncing and throttling
- Work with touch and keyboard events

---

## Additional Resources

- **MDN: Event Propagation**: [developer.mozilla.org/en-US/docs/Web/API/Event/stopPropagation](https://developer.mozilla.org/en-US/docs/Web/API/Event/stopPropagation)
- **MDN: preventDefault()**: [developer.mozilla.org/en-US/docs/Web/API/Event/preventDefault](https://developer.mozilla.org/en-US/docs/Web/API/Event/preventDefault)
- **JavaScript.info: Event Delegation**: [javascript.info/event-delegation](https://javascript.info/event-delegation)

---

*Lesson completed! You're ready to move on to the next lesson.*

