# Lesson 14.3: Advanced Events

## Learning Objectives

By the end of this lesson, you will be able to:
- Create and dispatch custom events
- Understand event patterns
- Implement debouncing for performance
- Implement throttling for performance
- Handle touch events for mobile
- Work with keyboard events in detail
- Build advanced event-driven applications

---

## Introduction to Advanced Events

Advanced event handling includes custom events, performance optimization patterns, and specialized event types for modern web applications.

### Advanced Event Topics

- **Custom Events**: Create your own events
- **Debouncing**: Limit function calls
- **Throttling**: Limit function execution rate
- **Touch Events**: Mobile device interactions
- **Keyboard Events**: Advanced keyboard handling

---

## Custom Events

Custom events allow you to create and dispatch your own events.

### Creating Custom Events

```javascript
// Create custom event
let customEvent = new CustomEvent('myEvent', {
    detail: {
        message: 'Hello from custom event',
        data: { id: 1, name: 'Alice' }
    },
    bubbles: true,
    cancelable: true
});

// Dispatch event
element.dispatchEvent(customEvent);
```

### Listening to Custom Events

```javascript
element.addEventListener('myEvent', function(event) {
    console.log('Custom event received:', event.detail);
    console.log('Message:', event.detail.message);
    console.log('Data:', event.detail.data);
});
```

### CustomEvent Constructor

```javascript
new CustomEvent(eventName, {
    detail: {},        // Custom data
    bubbles: true,    // Bubbles up
    cancelable: true  // Can be cancelled
});
```

### Practical Example: Notification System

```javascript
// Create notification event
function showNotification(message, type = 'info') {
    let event = new CustomEvent('notification', {
        detail: {
            message: message,
            type: type,
            timestamp: Date.now()
        },
        bubbles: true
    });
    
    document.dispatchEvent(event);
}

// Listen for notifications
document.addEventListener('notification', function(event) {
    let { message, type, timestamp } = event.detail;
    console.log(`[${type}] ${message} at ${new Date(timestamp)}`);
    // Display notification in UI
});

// Use it
showNotification('User logged in', 'success');
showNotification('Error occurred', 'error');
```

---

## Debouncing

Debouncing limits how often a function can be called. It waits for a pause before executing.

### Basic Debounce Function

```javascript
function debounce(func, delay) {
    let timeoutId;
    
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            func(...args);
        }, delay);
    };
}
```

### Debounce Example: Search Input

```javascript
let searchInput = document.getElementById('search');

function performSearch(query) {
    console.log('Searching for:', query);
    // Make API call
}

let debouncedSearch = debounce(performSearch, 300);

searchInput.addEventListener('input', function(event) {
    debouncedSearch(event.target.value);
    // Only searches 300ms after user stops typing
});
```

### Debounce Example: Window Resize

```javascript
function handleResize() {
    console.log('Window resized:', window.innerWidth, window.innerHeight);
    // Update layout
}

let debouncedResize = debounce(handleResize, 250);

window.addEventListener('resize', debouncedResize);
```

### Debounce with Immediate Option

```javascript
function debounce(func, delay, immediate = false) {
    let timeoutId;
    
    return function(...args) {
        let callNow = immediate && !timeoutId;
        
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            timeoutId = null;
            if (!immediate) {
                func(...args);
            }
        }, delay);
        
        if (callNow) {
            func(...args);
        }
    };
}
```

---

## Throttling

Throttling limits how often a function can execute. It ensures the function runs at most once per time period.

### Basic Throttle Function

```javascript
function throttle(func, limit) {
    let inThrottle;
    
    return function(...args) {
        if (!inThrottle) {
            func(...args);
            inThrottle = true;
            setTimeout(() => {
                inThrottle = false;
            }, limit);
        }
    };
}
```

### Throttle Example: Scroll Event

```javascript
function handleScroll() {
    console.log('Scrolled:', window.scrollY);
    // Update UI
}

let throttledScroll = throttle(handleScroll, 100);

window.addEventListener('scroll', throttledScroll);
// Executes at most once per 100ms
```

### Throttle Example: Mouse Move

```javascript
let element = document.getElementById('myDiv');

function trackMouse(event) {
    console.log('Mouse at:', event.clientX, event.clientY);
}

let throttledTrack = throttle(trackMouse, 100);

element.addEventListener('mousemove', throttledTrack);
```

### Advanced Throttle (Leading and Trailing)

```javascript
function throttle(func, limit, options = {}) {
    let timeoutId;
    let lastRan;
    let { leading = true, trailing = true } = options;
    
    return function(...args) {
        if (!lastRan && leading) {
            func(...args);
            lastRan = Date.now();
        } else {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                if (trailing && Date.now() - lastRan >= limit) {
                    func(...args);
                    lastRan = Date.now();
                }
            }, limit - (Date.now() - lastRan));
        }
    };
}
```

---

## Touch Events

Touch events handle interactions on touch devices (mobile, tablets).

### Touch Event Types

```javascript
// touchstart - Finger touches screen
element.addEventListener('touchstart', handler);

// touchmove - Finger moves on screen
element.addEventListener('touchmove', handler);

// touchend - Finger leaves screen
element.addEventListener('touchend', handler);

// touchcancel - Touch interrupted
element.addEventListener('touchcancel', handler);
```

### Touch Event Object

```javascript
element.addEventListener('touchstart', function(event) {
    let touches = event.touches;        // All touches
    let targetTouches = event.targetTouches;  // Touches on element
    let changedTouches = event.changedTouches; // Changed touches
    
    // Access first touch
    let touch = touches[0];
    console.log('Touch X:', touch.clientX);
    console.log('Touch Y:', touch.clientY);
    console.log('Touch ID:', touch.identifier);
});
```

### Multi-Touch Example

```javascript
element.addEventListener('touchstart', function(event) {
    console.log('Number of touches:', event.touches.length);
    
    for (let i = 0; i < event.touches.length; i++) {
        let touch = event.touches[i];
        console.log(`Touch ${i}:`, touch.clientX, touch.clientY);
    }
});
```

### Preventing Default Touch Behavior

```javascript
element.addEventListener('touchmove', function(event) {
    event.preventDefault();  // Prevent scrolling
    // Handle touch movement
}, { passive: false });
```

---

## Advanced Keyboard Events

### Key Properties

```javascript
input.addEventListener('keydown', function(event) {
    console.log('Key:', event.key);           // "a", "Enter", "ArrowUp"
    console.log('Code:', event.code);         // "KeyA", "Enter", "ArrowUp"
    console.log('Key Code:', event.keyCode);  // 65, 13, 38 (deprecated)
    
    // Modifier keys
    console.log('Ctrl:', event.ctrlKey);
    console.log('Shift:', event.shiftKey);
    console.log('Alt:', event.altKey);
    console.log('Meta:', event.metaKey);
    
    // Repeat
    console.log('Repeat:', event.repeat);
});
```

### Keyboard Shortcuts

```javascript
document.addEventListener('keydown', function(event) {
    // Ctrl+S (Save)
    if (event.ctrlKey && event.key === 's') {
        event.preventDefault();
        console.log('Save shortcut');
        saveDocument();
    }
    
    // Ctrl+Z (Undo)
    if (event.ctrlKey && event.key === 'z' && !event.shiftKey) {
        event.preventDefault();
        undo();
    }
    
    // Ctrl+Shift+Z (Redo)
    if (event.ctrlKey && event.shiftKey && event.key === 'z') {
        event.preventDefault();
        redo();
    }
    
    // Escape
    if (event.key === 'Escape') {
        closeModal();
    }
});
```

### Arrow Key Navigation

```javascript
let items = document.querySelectorAll('.item');
let currentIndex = 0;

document.addEventListener('keydown', function(event) {
    switch (event.key) {
        case 'ArrowDown':
            event.preventDefault();
            currentIndex = Math.min(currentIndex + 1, items.length - 1);
            items[currentIndex].focus();
            break;
            
        case 'ArrowUp':
            event.preventDefault();
            currentIndex = Math.max(currentIndex - 1, 0);
            items[currentIndex].focus();
            break;
            
        case 'Home':
            event.preventDefault();
            currentIndex = 0;
            items[currentIndex].focus();
            break;
            
        case 'End':
            event.preventDefault();
            currentIndex = items.length - 1;
            items[currentIndex].focus();
            break;
    }
});
```

---

## Event Patterns

### Pattern 1: Event Bus

```javascript
class EventBus {
    constructor() {
        this.events = {};
    }
    
    on(event, callback) {
        if (!this.events[event]) {
            this.events[event] = [];
        }
        this.events[event].push(callback);
    }
    
    off(event, callback) {
        if (this.events[event]) {
            this.events[event] = this.events[event].filter(cb => cb !== callback);
        }
    }
    
    emit(event, data) {
        if (this.events[event]) {
            this.events[event].forEach(callback => callback(data));
        }
    }
}

// Usage
let eventBus = new EventBus();

eventBus.on('userLogin', (user) => {
    console.log('User logged in:', user);
});

eventBus.on('userLogin', (user) => {
    updateUI(user);
});

eventBus.emit('userLogin', { id: 1, name: 'Alice' });
```

### Pattern 2: Observer Pattern

```javascript
class Observable {
    constructor() {
        this.observers = [];
    }
    
    subscribe(observer) {
        this.observers.push(observer);
    }
    
    unsubscribe(observer) {
        this.observers = this.observers.filter(obs => obs !== observer);
    }
    
    notify(data) {
        this.observers.forEach(observer => observer(data));
    }
}

// Usage
let subject = new Observable();

subject.subscribe((data) => {
    console.log('Observer 1:', data);
});

subject.subscribe((data) => {
    console.log('Observer 2:', data);
});

subject.notify('Hello');
```

---

## Practice Exercise

### Exercise: Advanced Events

**Objective**: Practice custom events, debouncing, throttling, and advanced event handling.

**Instructions**:

1. Create an HTML file with various interactive elements
2. Create a JavaScript file for advanced event handling
3. Practice:
   - Creating and dispatching custom events
   - Implementing debouncing
   - Implementing throttling
   - Handling touch events
   - Advanced keyboard handling

**Example Solution**:

```javascript
// Advanced Events Practice
console.log("=== Custom Events ===");

// Create custom event
function createCustomEvent(name, data) {
    return new CustomEvent(name, {
        detail: data,
        bubbles: true,
        cancelable: true
    });
}

// Notification system
function showNotification(message, type = 'info') {
    let event = createCustomEvent('notification', {
        message: message,
        type: type,
        timestamp: Date.now()
    });
    document.dispatchEvent(event);
}

document.addEventListener('notification', function(event) {
    let { message, type, timestamp } = event.detail;
    console.log(`[${type.toUpperCase()}] ${message} at ${new Date(timestamp).toLocaleTimeString()}`);
});

showNotification('User logged in', 'success');
showNotification('Data saved', 'info');
showNotification('Error occurred', 'error');
console.log();

console.log("=== Debouncing ===");

function debounce(func, delay) {
    let timeoutId;
    
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            func(...args);
        }, delay);
    };
}

// Search input debouncing
let searchInput = document.createElement('input');
searchInput.type = 'text';
searchInput.placeholder = 'Type to search (debounced)';
document.body.appendChild(searchInput);

let searchCount = 0;
function performSearch(query) {
    searchCount++;
    console.log(`Search ${searchCount} for: "${query}"`);
}

let debouncedSearch = debounce(performSearch, 500);

searchInput.addEventListener('input', function(event) {
    debouncedSearch(event.target.value);
});
console.log("Type in search input - searches after 500ms pause");
console.log();

console.log("=== Throttling ===");

function throttle(func, limit) {
    let inThrottle;
    
    return function(...args) {
        if (!inThrottle) {
            func(...args);
            inThrottle = true;
            setTimeout(() => {
                inThrottle = false;
            }, limit);
        }
    };
}

// Scroll throttling
let scrollCount = 0;
function handleScroll() {
    scrollCount++;
    console.log(`Scroll event ${scrollCount} at position: ${window.scrollY}`);
}

let throttledScroll = throttle(handleScroll, 1000);

window.addEventListener('scroll', throttledScroll);
console.log("Scroll page - events throttled to once per second");
console.log();

console.log("=== Mouse Move Throttling ===");

let moveBox = document.createElement('div');
moveBox.style.width = '200px';
moveBox.style.height = '200px';
moveBox.style.backgroundColor = 'lightblue';
moveBox.style.margin = '20px';
moveBox.textContent = 'Move mouse here (throttled)';
document.body.appendChild(moveBox);

let moveCount = 0;
function trackMouse(event) {
    moveCount++;
    console.log(`Mouse move ${moveCount}: (${event.clientX}, ${event.clientY})`);
}

let throttledMouse = throttle(trackMouse, 200);
moveBox.addEventListener('mousemove', throttledMouse);
console.log();

console.log("=== Touch Events ===");

let touchBox = document.createElement('div');
touchBox.style.width = '200px';
touchBox.style.height = '200px';
touchBox.style.backgroundColor = 'lightgreen';
touchBox.style.margin = '20px';
touchBox.textContent = 'Touch here (mobile)';
document.body.appendChild(touchBox);

touchBox.addEventListener('touchstart', function(event) {
    console.log('Touch started');
    let touch = event.touches[0];
    console.log(`Touch at: (${touch.clientX}, ${touch.clientY})`);
    console.log('Number of touches:', event.touches.length);
});

touchBox.addEventListener('touchmove', function(event) {
    event.preventDefault();
    let touch = event.touches[0];
    console.log(`Touch moved to: (${touch.clientX}, ${touch.clientY})`);
});

touchBox.addEventListener('touchend', function(event) {
    console.log('Touch ended');
    console.log('Changed touches:', event.changedTouches.length);
});
console.log();

console.log("=== Advanced Keyboard Events ===");

let keyboardInput = document.createElement('input');
keyboardInput.type = 'text';
keyboardInput.placeholder = 'Type here (keyboard events)';
keyboardInput.style.display = 'block';
keyboardInput.style.margin = '20px';
keyboardInput.style.padding = '10px';
document.body.appendChild(keyboardInput);

keyboardInput.addEventListener('keydown', function(event) {
    console.log('=== Key Down ===');
    console.log('Key:', event.key);
    console.log('Code:', event.code);
    console.log('Ctrl:', event.ctrlKey);
    console.log('Shift:', event.shiftKey);
    console.log('Alt:', event.altKey);
    console.log('Repeat:', event.repeat);
});

keyboardInput.addEventListener('keyup', function(event) {
    console.log('Key up:', event.key);
});
console.log();

console.log("=== Keyboard Shortcuts ===");

document.addEventListener('keydown', function(event) {
    // Ctrl+S
    if (event.ctrlKey && event.key === 's') {
        event.preventDefault();
        console.log('Save shortcut (Ctrl+S)');
    }
    
    // Ctrl+Z
    if (event.ctrlKey && event.key === 'z' && !event.shiftKey) {
        event.preventDefault();
        console.log('Undo shortcut (Ctrl+Z)');
    }
    
    // Ctrl+Shift+Z
    if (event.ctrlKey && event.shiftKey && event.key === 'z') {
        event.preventDefault();
        console.log('Redo shortcut (Ctrl+Shift+Z)');
    }
    
    // Escape
    if (event.key === 'Escape') {
        console.log('Escape pressed');
    }
    
    // Arrow keys
    if (event.key.startsWith('Arrow')) {
        console.log('Arrow key:', event.key);
    }
});
console.log();

console.log("=== Event Bus Pattern ===");

class EventBus {
    constructor() {
        this.events = {};
    }
    
    on(event, callback) {
        if (!this.events[event]) {
            this.events[event] = [];
        }
        this.events[event].push(callback);
    }
    
    off(event, callback) {
        if (this.events[event]) {
            this.events[event] = this.events[event].filter(cb => cb !== callback);
        }
    }
    
    emit(event, data) {
        if (this.events[event]) {
            this.events[event].forEach(callback => callback(data));
        }
    }
}

let eventBus = new EventBus();

eventBus.on('userAction', (data) => {
    console.log('Handler 1:', data);
});

eventBus.on('userAction', (data) => {
    console.log('Handler 2:', data);
});

eventBus.emit('userAction', { action: 'click', target: 'button' });
console.log();

console.log("=== Debounce with Immediate ===");

function debounceImmediate(func, delay, immediate = false) {
    let timeoutId;
    
    return function(...args) {
        let callNow = immediate && !timeoutId;
        
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            timeoutId = null;
            if (!immediate) {
                func(...args);
            }
        }, delay);
        
        if (callNow) {
            func(...args);
        }
    };
}

let immediateInput = document.createElement('input');
immediateInput.type = 'text';
immediateInput.placeholder = 'Type (immediate debounce)';
document.body.appendChild(immediateInput);

function searchImmediate(query) {
    console.log('Immediate search for:', query);
}

let immediateSearch = debounceImmediate(searchImmediate, 500, true);
immediateInput.addEventListener('input', function(event) {
    immediateSearch(event.target.value);
});
console.log();

console.log("=== Advanced Throttle ===");

function advancedThrottle(func, limit) {
    let lastRan;
    let timeoutId;
    
    return function(...args) {
        if (!lastRan) {
            func(...args);
            lastRan = Date.now();
        } else {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                if (Date.now() - lastRan >= limit) {
                    func(...args);
                    lastRan = Date.now();
                }
            }, limit - (Date.now() - lastRan));
        }
    };
}

let throttleBox = document.createElement('div');
throttleBox.style.width = '200px';
throttleBox.style.height = '200px';
throttleBox.style.backgroundColor = 'lightyellow';
throttleBox.style.margin = '20px';
throttleBox.textContent = 'Move mouse (advanced throttle)';
document.body.appendChild(throttleBox);

let throttleCount = 0;
function advancedTrack(event) {
    throttleCount++;
    console.log(`Advanced throttle ${throttleCount}: (${event.clientX}, ${event.clientY})`);
}

let advancedThrottled = advancedThrottle(advancedTrack, 300);
throttleBox.addEventListener('mousemove', advancedThrottled);
```

**Expected Output** (in browser console):
```
=== Custom Events ===
[SUCCESS] User logged in at [time]
[INFO] Data saved at [time]
[ERROR] Error occurred at [time]

=== Debouncing ===
Type in search input - searches after 500ms pause
[After typing and pausing]
Search 1 for: "[typed text]"

=== Throttling ===
Scroll page - events throttled to once per second
[On scrolling]
Scroll event 1 at position: [position]
[After 1 second]
Scroll event 2 at position: [position]

=== Mouse Move Throttling ===
[On mouse move]
Mouse move 1: (x, y)
[After 200ms]
Mouse move 2: (x, y)

=== Touch Events ===
[On touch - mobile]
Touch started
Touch at: (x, y)
Number of touches: 1
[On move]
Touch moved to: (x, y)
[On release]
Touch ended
Changed touches: 1

=== Advanced Keyboard Events ===
[On key press]
=== Key Down ===
Key: [key]
Code: [code]
Ctrl: false
Shift: false
Alt: false
Repeat: false

=== Keyboard Shortcuts ===
[On Ctrl+S]
Save shortcut (Ctrl+S)
[On Escape]
Escape pressed
[On Arrow keys]
Arrow key: ArrowDown

=== Event Bus Pattern ===
Handler 1: { action: "click", target: "button" }
Handler 2: { action: "click", target: "button" }

=== Debounce with Immediate ===
[On first input]
Immediate search for: [first char]
[After pause]
Immediate search for: [full text]

=== Advanced Throttle ===
[On mouse move]
Advanced throttle 1: (x, y)
[After delay]
Advanced throttle 2: (x, y)
```

**Challenge (Optional)**:
- Build a complete event system
- Create a gesture recognition system
- Build keyboard navigation
- Create a performance-optimized event handler

---

## Common Mistakes

### 1. Not Clearing Timeout in Debounce

```javascript
// ⚠️ Problem: Multiple timeouts
function badDebounce(func, delay) {
    setTimeout(() => func(), delay);  // Doesn't clear previous
}

// ✅ Solution: Clear timeout
function debounce(func, delay) {
    let timeoutId;
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func(...args), delay);
    };
}
```

### 2. Throttle Not Resetting

```javascript
// ⚠️ Problem: Throttle never resets
function badThrottle(func, limit) {
    let inThrottle = false;
    return function() {
        if (!inThrottle) {
            func();
            inThrottle = true;  // Never resets!
        }
    };
}

// ✅ Solution: Reset after delay
function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func(...args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}
```

### 3. Touch Events Not Prevented

```javascript
// ⚠️ Problem: Default scroll behavior
element.addEventListener('touchmove', function(event) {
    // Handle touch but page still scrolls
});

// ✅ Solution: Prevent default
element.addEventListener('touchmove', function(event) {
    event.preventDefault();
    // Handle touch
}, { passive: false });
```

---

## Key Takeaways

1. **Custom Events**: Create and dispatch your own events
2. **Debouncing**: Wait for pause before executing
3. **Throttling**: Limit execution rate
4. **Touch Events**: Handle mobile interactions
5. **Keyboard Events**: Advanced keyboard handling
6. **Event Patterns**: Event bus, observer pattern
7. **Best Practice**: Use debounce/throttle for performance
8. **Mobile Support**: Handle touch events for mobile devices

---

## Quiz: Advanced Events

Test your understanding with these questions:

1. **Custom events are created with:**
   - A) new Event()
   - B) new CustomEvent()
   - C) createEvent()
   - D) addEvent()

2. **Debouncing:**
   - A) Executes immediately
   - B) Waits for pause
   - C) Limits rate
   - D) Nothing

3. **Throttling:**
   - A) Waits for pause
   - B) Limits execution rate
   - C) Executes once
   - D) Nothing

4. **touchstart fires:**
   - A) When finger moves
   - B) When finger touches
   - C) When finger leaves
   - D) Never

5. **event.key returns:**
   - A) Key code
   - B) Key name
   - C) Key number
   - D) Nothing

6. **Debounce is best for:**
   - A) Scroll events
   - B) Search input
   - C) Click events
   - D) Load events

7. **Throttle is best for:**
   - A) Search input
   - B) Scroll events
   - C) Click events
   - D) Load events

**Answers**:
1. B) new CustomEvent()
2. B) Waits for pause
3. B) Limits execution rate
4. B) When finger touches
5. B) Key name
6. B) Search input
7. B) Scroll events

---

## Next Steps

Congratulations! You've completed Module 14: Events. You now know:
- Event basics and types
- Event propagation and delegation
- Custom events and advanced patterns
- Performance optimization

**What's Next?**
- Module 15: Forms and Validation
- Lesson 15.1: Working with Forms
- Learn form handling and validation
- Build interactive forms

---

## Additional Resources

- **MDN: CustomEvent**: [developer.mozilla.org/en-US/docs/Web/API/CustomEvent](https://developer.mozilla.org/en-US/docs/Web/API/CustomEvent)
- **MDN: Touch Events**: [developer.mozilla.org/en-US/docs/Web/API/Touch_events](https://developer.mozilla.org/en-US/docs/Web/API/Touch_events)
- **JavaScript.info: Custom Events**: [javascript.info/dispatch-events](https://javascript.info/dispatch-events)

---

*Lesson completed! You've finished Module 14: Events. Ready for Module 15: Forms and Validation!*

