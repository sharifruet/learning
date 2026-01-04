# Lesson 14.1: Event Basics

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what events are
- Recognize different event types
- Add event listeners using addEventListener
- Understand event objects
- Access event properties
- Remove event listeners
- Handle events effectively

---

## Introduction to Events

Events are actions or occurrences that happen in the browser, such as clicks, keyboard presses, or page loads. JavaScript can listen for these events and respond to them.

### What are Events?

- **User Actions**: Clicks, key presses, mouse movements
- **Browser Actions**: Page load, resize, scroll
- **Form Actions**: Submit, input, change
- **Network Actions**: Load, error, complete

### Why Events?

- **Interactivity**: Make pages respond to user actions
- **User Experience**: Create engaging interfaces
- **Dynamic Behavior**: Change page based on events
- **Modern Web**: Essential for web applications

---

## Event Types

### Mouse Events

```javascript
// click - Mouse click
element.addEventListener('click', handler);

// dblclick - Double click
element.addEventListener('dblclick', handler);

// mousedown - Mouse button pressed
element.addEventListener('mousedown', handler);

// mouseup - Mouse button released
element.addEventListener('mouseup', handler);

// mouseover - Mouse enters element
element.addEventListener('mouseover', handler);

// mouseout - Mouse leaves element
element.addEventListener('mouseout', handler);

// mousemove - Mouse moves over element
element.addEventListener('mousemove', handler);
```

### Keyboard Events

```javascript
// keydown - Key pressed down
element.addEventListener('keydown', handler);

// keyup - Key released
element.addEventListener('keyup', handler);

// keypress - Key pressed (deprecated, use keydown)
element.addEventListener('keypress', handler);
```

### Form Events

```javascript
// submit - Form submitted
form.addEventListener('submit', handler);

// change - Input value changed
input.addEventListener('change', handler);

// input - Input value changing (real-time)
input.addEventListener('input', handler);

// focus - Element receives focus
input.addEventListener('focus', handler);

// blur - Element loses focus
input.addEventListener('blur', handler);
```

### Window Events

```javascript
// load - Page loaded
window.addEventListener('load', handler);

// DOMContentLoaded - DOM ready
document.addEventListener('DOMContentLoaded', handler);

// resize - Window resized
window.addEventListener('resize', handler);

// scroll - Page scrolled
window.addEventListener('scroll', handler);

// beforeunload - Before page unloads
window.addEventListener('beforeunload', handler);
```

---

## addEventListener()

The modern way to add event listeners.

### Basic Syntax

```javascript
element.addEventListener(eventType, handler, options);
```

### Basic Example

```javascript
let button = document.getElementById('myButton');

button.addEventListener('click', function() {
    console.log('Button clicked!');
});
```

### Arrow Function

```javascript
button.addEventListener('click', () => {
    console.log('Button clicked!');
});
```

### Named Function

```javascript
function handleClick() {
    console.log('Button clicked!');
}

button.addEventListener('click', handleClick);
```

### Multiple Listeners

```javascript
button.addEventListener('click', function() {
    console.log('First handler');
});

button.addEventListener('click', function() {
    console.log('Second handler');
});

// Both handlers execute
```

### Options Parameter

```javascript
// Once: Remove after first trigger
button.addEventListener('click', handler, { once: true });

// Capture: Use capture phase
button.addEventListener('click', handler, { capture: true });

// Passive: Listener won't call preventDefault()
button.addEventListener('scroll', handler, { passive: true });
```

---

## Event Objects

Event handlers receive an event object with information about the event.

### Accessing Event Object

```javascript
button.addEventListener('click', function(event) {
    console.log(event);
    console.log(event.type);      // "click"
    console.log(event.target);    // Element that triggered event
    console.log(event.currentTarget); // Element with listener
});
```

### Common Event Properties

```javascript
function handleEvent(event) {
    // Event type
    console.log(event.type);           // "click", "keydown", etc.
    
    // Target element
    console.log(event.target);         // Element that triggered event
    console.log(event.currentTarget);  // Element with listener
    
    // Mouse events
    console.log(event.clientX);        // X coordinate
    console.log(event.clientY);        // Y coordinate
    console.log(event.button);         // Mouse button (0=left, 1=middle, 2=right)
    
    // Keyboard events
    console.log(event.key);            // Key pressed
    console.log(event.code);           // Physical key code
    console.log(event.ctrlKey);        // Ctrl key pressed
    console.log(event.shiftKey);       // Shift key pressed
    console.log(event.altKey);         // Alt key pressed
    
    // Time
    console.log(event.timeStamp);      // When event occurred
}
```

---

## Removing Event Listeners

### removeEventListener()

Remove an event listener (must be same function reference):

```javascript
function handleClick() {
    console.log('Clicked');
}

button.addEventListener('click', handleClick);

// Remove listener
button.removeEventListener('click', handleClick);
```

### Important: Function Reference

```javascript
// ❌ Won't work: Different function reference
button.addEventListener('click', function() {
    console.log('Clicked');
});
button.removeEventListener('click', function() { });  // Different function!

// ✅ Works: Same function reference
function handler() {
    console.log('Clicked');
}
button.addEventListener('click', handler);
button.removeEventListener('click', handler);
```

### Using once Option

```javascript
// Automatically removes after first trigger
button.addEventListener('click', handler, { once: true });
```

---

## Practical Examples

### Example 1: Button Click

```javascript
let button = document.getElementById('myButton');

button.addEventListener('click', function(event) {
    console.log('Button clicked!');
    console.log('Event type:', event.type);
    console.log('Target:', event.target);
});
```

### Example 2: Form Submission

```javascript
let form = document.getElementById('myForm');

form.addEventListener('submit', function(event) {
    event.preventDefault();  // Prevent default form submission
    
    let formData = new FormData(form);
    console.log('Form submitted:', formData);
    
    // Process form data
});
```

### Example 3: Input Change

```javascript
let input = document.getElementById('myInput');

input.addEventListener('input', function(event) {
    console.log('Input value:', event.target.value);
    
    // Real-time validation or processing
    if (event.target.value.length < 5) {
        console.log('Too short');
    }
});
```

### Example 4: Keyboard Events

```javascript
let input = document.getElementById('myInput');

input.addEventListener('keydown', function(event) {
    console.log('Key pressed:', event.key);
    console.log('Key code:', event.code);
    
    // Enter key
    if (event.key === 'Enter') {
        console.log('Enter pressed');
    }
    
    // Ctrl+S
    if (event.ctrlKey && event.key === 's') {
        event.preventDefault();
        console.log('Save shortcut');
    }
});
```

### Example 5: Mouse Events

```javascript
let div = document.getElementById('myDiv');

div.addEventListener('mouseenter', function() {
    div.style.backgroundColor = 'yellow';
});

div.addEventListener('mouseleave', function() {
    div.style.backgroundColor = 'white';
});

div.addEventListener('mousemove', function(event) {
    console.log('Mouse at:', event.clientX, event.clientY);
});
```

### Example 6: Window Events

```javascript
// Page load
window.addEventListener('load', function() {
    console.log('Page loaded');
});

// DOM ready (faster than load)
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM ready');
});

// Window resize
window.addEventListener('resize', function() {
    console.log('Window resized:', window.innerWidth, window.innerHeight);
});

// Scroll
window.addEventListener('scroll', function() {
    console.log('Scrolled:', window.scrollY);
});
```

---

## Practice Exercise

### Exercise: Basic Event Handling

**Objective**: Practice adding and handling various events.

**Instructions**:

1. Create an HTML file with various interactive elements
2. Create a JavaScript file for event handling
3. Practice:
   - Adding event listeners
   - Handling different event types
   - Accessing event properties
   - Removing event listeners

**Example Solution**:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Basics Practice</title>
    <style>
        .box {
            width: 200px;
            height: 200px;
            background-color: lightblue;
            margin: 20px;
            padding: 20px;
            cursor: pointer;
        }
        .highlight {
            background-color: yellow;
        }
    </style>
</head>
<body>
    <h1>Event Basics Practice</h1>
    
    <button id="clickBtn">Click Me</button>
    <button id="doubleClickBtn">Double Click Me</button>
    
    <div id="hoverBox" class="box">Hover over me</div>
    
    <input type="text" id="textInput" placeholder="Type something">
    <p id="output"></p>
    
    <form id="myForm">
        <input type="text" name="username" placeholder="Username">
        <button type="submit">Submit</button>
    </form>
    
    <script src="event-basics.js"></script>
</body>
</html>
```

```javascript
// event-basics.js
console.log("=== Event Basics Practice ===");

console.log("\n=== Click Event ===");

let clickBtn = document.getElementById('clickBtn');
clickBtn.addEventListener('click', function(event) {
    console.log('Button clicked!');
    console.log('Event type:', event.type);
    console.log('Target:', event.target);
    console.log('Current target:', event.currentTarget);
    event.target.textContent = 'Clicked!';
});
console.log();

console.log("=== Double Click Event ===");

let doubleClickBtn = document.getElementById('doubleClickBtn');
doubleClickBtn.addEventListener('dblclick', function(event) {
    console.log('Double clicked!');
    event.target.textContent = 'Double Clicked!';
});
console.log();

console.log("=== Mouse Events ===");

let hoverBox = document.getElementById('hoverBox');

hoverBox.addEventListener('mouseenter', function(event) {
    console.log('Mouse entered box');
    event.target.classList.add('highlight');
});

hoverBox.addEventListener('mouseleave', function(event) {
    console.log('Mouse left box');
    event.target.classList.remove('highlight');
});

hoverBox.addEventListener('mousemove', function(event) {
    let x = event.clientX;
    let y = event.clientY;
    event.target.textContent = `Mouse: ${x}, ${y}`;
});

hoverBox.addEventListener('mousedown', function(event) {
    console.log('Mouse down on box');
    event.target.style.backgroundColor = 'red';
});

hoverBox.addEventListener('mouseup', function(event) {
    console.log('Mouse up on box');
    event.target.style.backgroundColor = 'lightblue';
});
console.log();

console.log("=== Keyboard Events ===");

let textInput = document.getElementById('textInput');
let output = document.getElementById('output');

textInput.addEventListener('keydown', function(event) {
    console.log('Key down:', event.key, event.code);
    
    // Enter key
    if (event.key === 'Enter') {
        console.log('Enter pressed');
    }
    
    // Escape key
    if (event.key === 'Escape') {
        event.target.value = '';
    }
});

textInput.addEventListener('keyup', function(event) {
    console.log('Key up:', event.key);
});

textInput.addEventListener('input', function(event) {
    output.textContent = 'You typed: ' + event.target.value;
});

textInput.addEventListener('focus', function(event) {
    console.log('Input focused');
    event.target.style.border = '2px solid blue';
});

textInput.addEventListener('blur', function(event) {
    console.log('Input blurred');
    event.target.style.border = '1px solid gray';
});
console.log();

console.log("=== Form Events ===");

let form = document.getElementById('myForm');

form.addEventListener('submit', function(event) {
    event.preventDefault();  // Prevent default submission
    console.log('Form submitted');
    
    let formData = new FormData(form);
    let username = formData.get('username');
    console.log('Username:', username);
    
    alert('Form submitted: ' + username);
});

let usernameInput = form.querySelector('input[name="username"]');
usernameInput.addEventListener('change', function(event) {
    console.log('Username changed:', event.target.value);
});
console.log();

console.log("=== Window Events ===");

window.addEventListener('load', function() {
    console.log('Page fully loaded');
});

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM content loaded');
});

window.addEventListener('resize', function() {
    console.log('Window resized:', window.innerWidth, 'x', window.innerHeight);
});

window.addEventListener('scroll', function() {
    console.log('Scrolled:', window.scrollY);
});
console.log();

console.log("=== Event Object Properties ===");

let testBtn = document.createElement('button');
testBtn.textContent = 'Test Event Properties';
document.body.appendChild(testBtn);

testBtn.addEventListener('click', function(event) {
    console.log('=== Event Properties ===');
    console.log('Type:', event.type);
    console.log('Target:', event.target);
    console.log('Current Target:', event.currentTarget);
    console.log('Time Stamp:', event.timeStamp);
    console.log('Bubbles:', event.bubbles);
    console.log('Cancelable:', event.cancelable);
    console.log('Default Prevented:', event.defaultPrevented);
});
console.log();

console.log("=== Removing Event Listeners ===");

let removeBtn = document.createElement('button');
removeBtn.textContent = 'Click to Remove Listener';
document.body.appendChild(removeBtn);

let clickCount = 0;

function handleRemoveClick(event) {
    clickCount++;
    console.log(`Clicked ${clickCount} times`);
    
    if (clickCount >= 3) {
        removeBtn.removeEventListener('click', handleRemoveClick);
        removeBtn.textContent = 'Listener removed';
        console.log('Event listener removed');
    }
}

removeBtn.addEventListener('click', handleRemoveClick);
console.log();

console.log("=== Once Option ===");

let onceBtn = document.createElement('button');
onceBtn.textContent = 'Click Once (auto-remove)';
document.body.appendChild(onceBtn);

onceBtn.addEventListener('click', function() {
    console.log('This will only fire once');
    onceBtn.textContent = 'Already clicked';
}, { once: true });
console.log();

console.log("=== Multiple Listeners ===");

let multiBtn = document.createElement('button');
multiBtn.textContent = 'Multiple Listeners';
document.body.appendChild(multiBtn);

multiBtn.addEventListener('click', function() {
    console.log('Handler 1');
});

multiBtn.addEventListener('click', function() {
    console.log('Handler 2');
});

multiBtn.addEventListener('click', function() {
    console.log('Handler 3');
});

// All three handlers execute
console.log();
```

**Expected Output** (in browser console):
```
=== Event Basics Practice ===

=== Click Event ===
[On click]
Button clicked!
Event type: click
Target: [button element]
Current target: [button element]

=== Double Click Event ===
[On double click]
Double clicked!

=== Mouse Events ===
[On mouse enter]
Mouse entered box
[On mouse leave]
Mouse left box
[On mouse move]
[Shows coordinates]

=== Keyboard Events ===
[On key press]
Key down: [key] [code]
[On input]
[Shows typed text]

=== Form Events ===
[On submit]
Form submitted
Username: [value]

=== Window Events ===
DOM content loaded
Page fully loaded
[On resize]
Window resized: [width] x [height]
[On scroll]
Scrolled: [position]

=== Event Object Properties ===
[On click]
=== Event Properties ===
Type: click
Target: [element]
Current Target: [element]
Time Stamp: [timestamp]
Bubbles: true
Cancelable: true
Default Prevented: false

=== Removing Event Listeners ===
[On click]
Clicked 1 times
Clicked 2 times
Clicked 3 times
Event listener removed

=== Once Option ===
[On click]
This will only fire once

=== Multiple Listeners ===
[On click]
Handler 1
Handler 2
Handler 3
```

**Challenge (Optional)**:
- Build an interactive game with events
- Create a form validation system
- Build a keyboard shortcut system
- Create a drag-and-drop interface

---

## Common Mistakes

### 1. Not Preventing Default

```javascript
// ⚠️ Problem: Form submits and page reloads
form.addEventListener('submit', function(event) {
    // Process form
    // Page reloads!
});

// ✅ Solution: Prevent default
form.addEventListener('submit', function(event) {
    event.preventDefault();
    // Process form
});
```

### 2. Wrong Function Reference for Removal

```javascript
// ⚠️ Problem: Can't remove (different function)
button.addEventListener('click', function() {
    console.log('Click');
});
button.removeEventListener('click', function() { });  // Won't work

// ✅ Solution: Use same reference
function handler() {
    console.log('Click');
}
button.addEventListener('click', handler);
button.removeEventListener('click', handler);
```

### 3. Adding Listener Before Element Exists

```javascript
// ⚠️ Problem: Element might not exist
let button = document.getElementById('myButton');
button.addEventListener('click', handler);  // Error if button is null

// ✅ Solution: Check or wait for DOM
document.addEventListener('DOMContentLoaded', function() {
    let button = document.getElementById('myButton');
    if (button) {
        button.addEventListener('click', handler);
    }
});
```

### 4. Using Inline Handlers

```javascript
// ⚠️ Problem: Inline handlers (not recommended)
<button onclick="handleClick()">Click</button>

// ✅ Solution: Use addEventListener
button.addEventListener('click', handleClick);
```

---

## Key Takeaways

1. **Events**: Actions that occur in the browser
2. **addEventListener()**: Modern way to add listeners
3. **Event Types**: click, keydown, submit, load, etc.
4. **Event Object**: Contains event information
5. **removeEventListener()**: Remove listeners (same function reference)
6. **Options**: once, capture, passive
7. **Best Practice**: Use addEventListener, prevent default when needed
8. **Multiple Listeners**: Can add multiple listeners to same element

---

## Quiz: Events Basics

Test your understanding with these questions:

1. **addEventListener() is:**
   - A) Old method
   - B) Modern method
   - C) Deprecated
   - D) Not available

2. **Event handler receives:**
   - A) Nothing
   - B) Event object
   - C) Element
   - D) String

3. **removeEventListener() requires:**
   - A) Same function reference
   - B) Different function
   - C) No function
   - D) String

4. **event.target is:**
   - A) Element with listener
   - B) Element that triggered event
   - C) Parent element
   - D) Document

5. **once option:**
   - A) Prevents event
   - B) Removes after first trigger
   - C) Adds multiple times
   - D) Nothing

6. **DOMContentLoaded fires:**
   - A) After images load
   - B) When DOM ready
   - C) Never
   - D) On click

7. **Multiple listeners:**
   - A) Only first executes
   - B) All execute
   - C) Error
   - D) Random

**Answers**:
1. B) Modern method
2. B) Event object
3. A) Same function reference
4. B) Element that triggered event
5. B) Removes after first trigger
6. B) When DOM ready
7. B) All execute

---

## Next Steps

Congratulations! You've learned event basics. You now know:
- What events are
- Different event types
- How to add event listeners
- How to access event properties

**What's Next?**
- Lesson 14.2: Event Propagation
- Learn about event bubbling and capturing
- Understand event delegation
- Build more complex event handling

---

## Additional Resources

- **MDN: Events**: [developer.mozilla.org/en-US/docs/Web/API/Event](https://developer.mozilla.org/en-US/docs/Web/API/Event)
- **MDN: addEventListener()**: [developer.mozilla.org/en-US/docs/Web/API/EventTarget/addEventListener](https://developer.mozilla.org/en-US/docs/Web/API/EventTarget/addEventListener)
- **JavaScript.info: Events**: [javascript.info/events](https://javascript.info/events)

---

*Lesson completed! You're ready to move on to the next lesson.*

