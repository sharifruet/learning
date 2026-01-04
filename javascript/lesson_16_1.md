# Lesson 16.1: localStorage and sessionStorage

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand browser storage APIs
- Use localStorage for persistent storage
- Use sessionStorage for session storage
- Store and retrieve data
- Handle storage limitations
- Work with storage events
- Build storage utilities

---

## Introduction to Browser Storage

Browser storage allows you to store data in the user's browser. There are two main storage APIs: localStorage and sessionStorage.

### Why Browser Storage?

- **Persistent Data**: Store data across sessions
- **No Server**: Store data client-side
- **Fast Access**: Quick data retrieval
- **User Preferences**: Save user settings
- **Offline Support**: Work without internet
- **Modern Web**: Essential for web apps

---

## localStorage API

localStorage stores data with no expiration date. Data persists until explicitly removed.

### Basic Usage

```javascript
// Store data
localStorage.setItem('key', 'value');

// Retrieve data
let value = localStorage.getItem('key');

// Remove data
localStorage.removeItem('key');

// Clear all data
localStorage.clear();
```

### Storing Different Data Types

```javascript
// String
localStorage.setItem('name', 'Alice');

// Number (stored as string)
localStorage.setItem('age', '30');
// Retrieve and convert
let age = parseInt(localStorage.getItem('age'));

// Boolean (stored as string)
localStorage.setItem('isActive', 'true');
// Retrieve and convert
let isActive = localStorage.getItem('isActive') === 'true';

// Object (must stringify)
let user = { name: 'Alice', age: 30 };
localStorage.setItem('user', JSON.stringify(user));
// Retrieve and parse
let user = JSON.parse(localStorage.getItem('user'));

// Array (must stringify)
let items = ['apple', 'banana', 'orange'];
localStorage.setItem('items', JSON.stringify(items));
// Retrieve and parse
let items = JSON.parse(localStorage.getItem('items'));
```

### Checking if Key Exists

```javascript
// Check if key exists
if (localStorage.getItem('key') !== null) {
    console.log('Key exists');
}

// Or check directly
if ('key' in localStorage) {
    console.log('Key exists');
}

// Get all keys
let keys = Object.keys(localStorage);
console.log('All keys:', keys);
```

### Getting All Items

```javascript
// Get all items
for (let i = 0; i < localStorage.length; i++) {
    let key = localStorage.key(i);
    let value = localStorage.getItem(key);
    console.log(key, value);
}

// Or using Object.keys
Object.keys(localStorage).forEach(key => {
    console.log(key, localStorage.getItem(key));
});
```

---

## sessionStorage API

sessionStorage stores data for one session. Data is cleared when the tab is closed.

### Basic Usage

```javascript
// Store data
sessionStorage.setItem('key', 'value');

// Retrieve data
let value = sessionStorage.getItem('key');

// Remove data
sessionStorage.removeItem('key');

// Clear all data
sessionStorage.clear();
```

### sessionStorage vs localStorage

```javascript
// localStorage: Persists across sessions
localStorage.setItem('persistent', 'data');
// Close and reopen browser - data still exists

// sessionStorage: Only for current session
sessionStorage.setItem('session', 'data');
// Close tab - data is cleared
```

---

## Storage Methods

### setItem(key, value)

Store data:

```javascript
localStorage.setItem('username', 'alice');
localStorage.setItem('score', '100');
localStorage.setItem('settings', JSON.stringify({ theme: 'dark' }));
```

### getItem(key)

Retrieve data:

```javascript
let username = localStorage.getItem('username');
let score = parseInt(localStorage.getItem('score'));
let settings = JSON.parse(localStorage.getItem('settings'));
```

### removeItem(key)

Remove specific item:

```javascript
localStorage.removeItem('username');
```

### clear()

Clear all storage:

```javascript
localStorage.clear();  // Removes all localStorage data
sessionStorage.clear();  // Removes all sessionStorage data
```

### key(index)

Get key at index:

```javascript
let firstKey = localStorage.key(0);
console.log('First key:', firstKey);
```

### length

Get number of items:

```javascript
let count = localStorage.length;
console.log('Number of items:', count);
```

---

## Storage Limitations

### Size Limits

- **localStorage**: ~5-10MB (varies by browser)
- **sessionStorage**: ~5-10MB (varies by browser)
- **Quota Exceeded Error**: Thrown when limit exceeded

### Handling Quota Exceeded

```javascript
function setItemSafe(key, value) {
    try {
        localStorage.setItem(key, value);
        return true;
    } catch (e) {
        if (e.name === 'QuotaExceededError') {
            console.error('Storage quota exceeded');
            // Handle error (e.g., clear old data)
            return false;
        }
        throw e;
    }
}
```

### Checking Available Space

```javascript
function getStorageSize() {
    let total = 0;
    for (let key in localStorage) {
        if (localStorage.hasOwnProperty(key)) {
            total += localStorage[key].length + key.length;
        }
    }
    return total;
}

console.log('Storage used:', getStorageSize(), 'bytes');
```

---

## Storage Events

### storage Event

Fired when storage changes (in other tabs/windows):

```javascript
window.addEventListener('storage', function(event) {
    console.log('Storage changed');
    console.log('Key:', event.key);
    console.log('Old value:', event.oldValue);
    console.log('New value:', event.newValue);
    console.log('Storage area:', event.storageArea);
    console.log('URL:', event.url);
});
```

### Important Notes

- **Only fires in other tabs**: Not in the tab that made the change
- **Only for localStorage**: sessionStorage doesn't fire storage events
- **Useful for sync**: Sync data across tabs

---

## Practical Examples

### Example 1: User Preferences

```javascript
// Save user preferences
function savePreferences(preferences) {
    localStorage.setItem('preferences', JSON.stringify(preferences));
}

// Load user preferences
function loadPreferences() {
    let stored = localStorage.getItem('preferences');
    if (stored) {
        return JSON.parse(stored);
    }
    return {
        theme: 'light',
        language: 'en',
        notifications: true
    };
}

// Use
let prefs = loadPreferences();
console.log('Theme:', prefs.theme);

prefs.theme = 'dark';
savePreferences(prefs);
```

### Example 2: Shopping Cart

```javascript
// Add to cart
function addToCart(item) {
    let cart = getCart();
    cart.push(item);
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Get cart
function getCart() {
    let stored = localStorage.getItem('cart');
    return stored ? JSON.parse(stored) : [];
}

// Remove from cart
function removeFromCart(index) {
    let cart = getCart();
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Clear cart
function clearCart() {
    localStorage.removeItem('cart');
}
```

### Example 3: Form Data Persistence

```javascript
let form = document.getElementById('myForm');

// Save form data on input
form.addEventListener('input', function() {
    let formData = new FormData(form);
    let data = Object.fromEntries(formData);
    localStorage.setItem('formDraft', JSON.stringify(data));
});

// Load form data on page load
window.addEventListener('load', function() {
    let draft = localStorage.getItem('formDraft');
    if (draft) {
        let data = JSON.parse(draft);
        Object.keys(data).forEach(key => {
            let input = form.elements[key];
            if (input) {
                if (input.type === 'checkbox') {
                    input.checked = data[key] === 'on';
                } else {
                    input.value = data[key];
                }
            }
        });
    }
});

// Clear draft on submit
form.addEventListener('submit', function() {
    localStorage.removeItem('formDraft');
});
```

### Example 4: Session Data

```javascript
// Store session data
sessionStorage.setItem('sessionId', generateSessionId());
sessionStorage.setItem('loginTime', Date.now().toString());

// Check if session exists
function isSessionActive() {
    return sessionStorage.getItem('sessionId') !== null;
}

// Get session info
function getSessionInfo() {
    return {
        id: sessionStorage.getItem('sessionId'),
        loginTime: parseInt(sessionStorage.getItem('loginTime'))
    };
}
```

---

## Storage Utilities

### Storage Helper Class

```javascript
class StorageHelper {
    constructor(storage = localStorage) {
        this.storage = storage;
    }
    
    set(key, value) {
        try {
            this.storage.setItem(key, JSON.stringify(value));
            return true;
        } catch (e) {
            console.error('Storage error:', e);
            return false;
        }
    }
    
    get(key, defaultValue = null) {
        try {
            let item = this.storage.getItem(key);
            return item ? JSON.parse(item) : defaultValue;
        } catch (e) {
            console.error('Storage error:', e);
            return defaultValue;
        }
    }
    
    remove(key) {
        this.storage.removeItem(key);
    }
    
    clear() {
        this.storage.clear();
    }
    
    has(key) {
        return this.storage.getItem(key) !== null;
    }
    
    keys() {
        return Object.keys(this.storage);
    }
    
    size() {
        let total = 0;
        for (let key in this.storage) {
            if (this.storage.hasOwnProperty(key)) {
                total += this.storage[key].length + key.length;
            }
        }
        return total;
    }
}

// Usage
let storage = new StorageHelper();
storage.set('user', { name: 'Alice', age: 30 });
let user = storage.get('user');
console.log(user);
```

### Storage with Expiration

```javascript
class ExpiringStorage {
    constructor(storage = localStorage) {
        this.storage = storage;
    }
    
    set(key, value, expirationMinutes) {
        let expiration = Date.now() + (expirationMinutes * 60 * 1000);
        let item = {
            value: value,
            expiration: expiration
        };
        this.storage.setItem(key, JSON.stringify(item));
    }
    
    get(key) {
        let item = this.storage.getItem(key);
        if (!item) return null;
        
        item = JSON.parse(item);
        
        if (Date.now() > item.expiration) {
            this.storage.removeItem(key);
            return null;
        }
        
        return item.value;
    }
}

// Usage
let expiringStorage = new ExpiringStorage();
expiringStorage.set('token', 'abc123', 30);  // Expires in 30 minutes
let token = expiringStorage.get('token');
```

---

## Practice Exercise

### Exercise: Using Storage APIs

**Objective**: Practice using localStorage and sessionStorage to store and retrieve data.

**Instructions**:

1. Create an HTML file with various inputs
2. Create a JavaScript file for storage operations
3. Practice:
   - Storing different data types
   - Retrieving data
   - Handling errors
   - Working with storage events
   - Building storage utilities

**Example Solution**:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browser Storage Practice</title>
    <style>
        .container {
            max-width: 600px;
            margin: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 20px;
            margin: 5px;
        }
        .output {
            margin-top: 20px;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Browser Storage Practice</h1>
        
        <h2>localStorage</h2>
        <div class="form-group">
            <label for="localKey">Key:</label>
            <input type="text" id="localKey" placeholder="Enter key">
        </div>
        <div class="form-group">
            <label for="localValue">Value:</label>
            <input type="text" id="localValue" placeholder="Enter value">
        </div>
        <button onclick="saveToLocalStorage()">Save to localStorage</button>
        <button onclick="loadFromLocalStorage()">Load from localStorage</button>
        <button onclick="removeFromLocalStorage()">Remove from localStorage</button>
        <button onclick="clearLocalStorage()">Clear localStorage</button>
        
        <h2>sessionStorage</h2>
        <div class="form-group">
            <label for="sessionKey">Key:</label>
            <input type="text" id="sessionKey" placeholder="Enter key">
        </div>
        <div class="form-group">
            <label for="sessionValue">Value:</label>
            <input type="text" id="sessionValue" placeholder="Enter value">
        </div>
        <button onclick="saveToSessionStorage()">Save to sessionStorage</button>
        <button onclick="loadFromSessionStorage()">Load from sessionStorage</button>
        <button onclick="clearSessionStorage()">Clear sessionStorage</button>
        
        <h2>Storage Info</h2>
        <button onclick="showStorageInfo()">Show Storage Info</button>
        <button onclick="showAllItems()">Show All Items</button>
        
        <div id="output" class="output"></div>
    </div>
    
    <script src="storage-practice.js"></script>
</body>
</html>
```

```javascript
// storage-practice.js
console.log("=== Browser Storage Practice ===");

let output = document.getElementById('output');

function log(message) {
    console.log(message);
    output.innerHTML += '<p>' + message + '</p>';
}

function clearOutput() {
    output.innerHTML = '';
}

console.log("\n=== localStorage Basics ===");

// Save to localStorage
function saveToLocalStorage() {
    clearOutput();
    let key = document.getElementById('localKey').value;
    let value = document.getElementById('localValue').value;
    
    if (!key) {
        log('Error: Key is required');
        return;
    }
    
    try {
        localStorage.setItem(key, value);
        log(`Saved to localStorage: ${key} = ${value}`);
    } catch (e) {
        if (e.name === 'QuotaExceededError') {
            log('Error: Storage quota exceeded');
        } else {
            log('Error: ' + e.message);
        }
    }
}

// Load from localStorage
function loadFromLocalStorage() {
    clearOutput();
    let key = document.getElementById('localKey').value;
    
    if (!key) {
        log('Error: Key is required');
        return;
    }
    
    let value = localStorage.getItem(key);
    if (value !== null) {
        log(`Loaded from localStorage: ${key} = ${value}`);
        document.getElementById('localValue').value = value;
    } else {
        log(`Key "${key}" not found in localStorage`);
    }
}

// Remove from localStorage
function removeFromLocalStorage() {
    clearOutput();
    let key = document.getElementById('localKey').value;
    
    if (!key) {
        log('Error: Key is required');
        return;
    }
    
    localStorage.removeItem(key);
    log(`Removed "${key}" from localStorage`);
}

// Clear localStorage
function clearLocalStorage() {
    clearOutput();
    localStorage.clear();
    log('Cleared all localStorage data');
}
console.log();

console.log("=== sessionStorage Basics ===");

// Save to sessionStorage
function saveToSessionStorage() {
    clearOutput();
    let key = document.getElementById('sessionKey').value;
    let value = document.getElementById('sessionValue').value;
    
    if (!key) {
        log('Error: Key is required');
        return;
    }
    
    try {
        sessionStorage.setItem(key, value);
        log(`Saved to sessionStorage: ${key} = ${value}`);
    } catch (e) {
        if (e.name === 'QuotaExceededError') {
            log('Error: Storage quota exceeded');
        } else {
            log('Error: ' + e.message);
        }
    }
}

// Load from sessionStorage
function loadFromSessionStorage() {
    clearOutput();
    let key = document.getElementById('sessionKey').value;
    
    if (!key) {
        log('Error: Key is required');
        return;
    }
    
    let value = sessionStorage.getItem(key);
    if (value !== null) {
        log(`Loaded from sessionStorage: ${key} = ${value}`);
        document.getElementById('sessionValue').value = value;
    } else {
        log(`Key "${key}" not found in sessionStorage`);
    }
}

// Clear sessionStorage
function clearSessionStorage() {
    clearOutput();
    sessionStorage.clear();
    log('Cleared all sessionStorage data');
}
console.log();

console.log("=== Storing Different Data Types ===");

// Store object
function storeObject() {
    let user = {
        name: 'Alice',
        age: 30,
        email: 'alice@example.com'
    };
    localStorage.setItem('user', JSON.stringify(user));
    log('Stored object: ' + JSON.stringify(user));
}

// Store array
function storeArray() {
    let items = ['apple', 'banana', 'orange'];
    localStorage.setItem('items', JSON.stringify(items));
    log('Stored array: ' + JSON.stringify(items));
}

// Retrieve and parse
function retrieveObject() {
    let userStr = localStorage.getItem('user');
    if (userStr) {
        let user = JSON.parse(userStr);
        log('Retrieved object: ' + JSON.stringify(user));
        log('User name: ' + user.name);
    }
}

// Store number
function storeNumber() {
    localStorage.setItem('score', '100');
    let score = parseInt(localStorage.getItem('score'));
    log('Stored and retrieved number: ' + score);
}

// Store boolean
function storeBoolean() {
    localStorage.setItem('isActive', 'true');
    let isActive = localStorage.getItem('isActive') === 'true';
    log('Stored and retrieved boolean: ' + isActive);
}
console.log();

console.log("=== Storage Info ===");

function showStorageInfo() {
    clearOutput();
    
    log('=== localStorage Info ===');
    log('Number of items: ' + localStorage.length);
    log('Storage size: ~' + getStorageSize(localStorage) + ' bytes');
    
    log('\n=== sessionStorage Info ===');
    log('Number of items: ' + sessionStorage.length);
    log('Storage size: ~' + getStorageSize(sessionStorage) + ' bytes');
}

function getStorageSize(storage) {
    let total = 0;
    for (let key in storage) {
        if (storage.hasOwnProperty(key)) {
            total += storage[key].length + key.length;
        }
    }
    return total;
}

function showAllItems() {
    clearOutput();
    
    log('=== localStorage Items ===');
    if (localStorage.length === 0) {
        log('No items in localStorage');
    } else {
        for (let i = 0; i < localStorage.length; i++) {
            let key = localStorage.key(i);
            let value = localStorage.getItem(key);
            log(`${key}: ${value}`);
        }
    }
    
    log('\n=== sessionStorage Items ===');
    if (sessionStorage.length === 0) {
        log('No items in sessionStorage');
    } else {
        for (let i = 0; i < sessionStorage.length; i++) {
            let key = sessionStorage.key(i);
            let value = sessionStorage.getItem(key);
            log(`${key}: ${value}`);
        }
    }
}
console.log();

console.log("=== Storage Events ===");

// Listen for storage changes (from other tabs)
window.addEventListener('storage', function(event) {
    console.log('Storage event fired');
    console.log('Key:', event.key);
    console.log('Old value:', event.oldValue);
    console.log('New value:', event.newValue);
    console.log('Storage area:', event.storageArea);
    
    log(`Storage changed: ${event.key} (old: ${event.oldValue}, new: ${event.newValue})`);
});
console.log();

console.log("=== Storage Helper ===");

class StorageHelper {
    constructor(storage = localStorage) {
        this.storage = storage;
    }
    
    set(key, value) {
        try {
            this.storage.setItem(key, JSON.stringify(value));
            return true;
        } catch (e) {
            console.error('Storage error:', e);
            return false;
        }
    }
    
    get(key, defaultValue = null) {
        try {
            let item = this.storage.getItem(key);
            return item ? JSON.parse(item) : defaultValue;
        } catch (e) {
            console.error('Storage error:', e);
            return defaultValue;
        }
    }
    
    remove(key) {
        this.storage.removeItem(key);
    }
    
    clear() {
        this.storage.clear();
    }
    
    has(key) {
        return this.storage.getItem(key) !== null;
    }
    
    keys() {
        return Object.keys(this.storage);
    }
}

// Demonstrate helper
let helper = new StorageHelper();
helper.set('test', { name: 'Test', value: 123 });
let test = helper.get('test');
log('Helper test: ' + JSON.stringify(test));
console.log();

console.log("=== Practical Examples ===");

// User preferences
function savePreferences() {
    let prefs = {
        theme: 'dark',
        language: 'en',
        notifications: true
    };
    localStorage.setItem('preferences', JSON.stringify(prefs));
    log('Saved preferences');
}

function loadPreferences() {
    let stored = localStorage.getItem('preferences');
    if (stored) {
        let prefs = JSON.parse(stored);
        log('Loaded preferences: ' + JSON.stringify(prefs));
        return prefs;
    }
    return null;
}

// Shopping cart
function addToCart(item) {
    let cart = getCart();
    cart.push(item);
    localStorage.setItem('cart', JSON.stringify(cart));
    log('Added to cart: ' + item);
}

function getCart() {
    let stored = localStorage.getItem('cart');
    return stored ? JSON.parse(stored) : [];
}

function showCart() {
    let cart = getCart();
    log('Cart items: ' + JSON.stringify(cart));
}

// Initialize
window.addEventListener('load', function() {
    log('Page loaded. Storage APIs ready.');
    log('Try opening this page in multiple tabs to see storage events!');
});
```

**Expected Output** (in browser console):
```
=== Browser Storage Practice ===

=== localStorage Basics ===
[On save]
Saved to localStorage: key = value

[On load]
Loaded from localStorage: key = value

=== sessionStorage Basics ===
[On save]
Saved to sessionStorage: key = value

=== Storing Different Data Types ===
[On store object]
Stored object: {"name":"Alice","age":30,"email":"alice@example.com"}

[On retrieve]
Retrieved object: {"name":"Alice","age":30,"email":"alice@example.com"}
User name: Alice

=== Storage Info ===
[On show info]
=== localStorage Info ===
Number of items: [count]
Storage size: ~[size] bytes

=== Storage Events ===
[On change in other tab]
Storage event fired
Key: [key]
Old value: [old]
New value: [new]

=== Storage Helper ===
Helper test: {"name":"Test","value":123}

=== Practical Examples ===
[On save preferences]
Saved preferences
[On load]
Loaded preferences: {"theme":"dark","language":"en","notifications":true}
```

**Challenge (Optional)**:
- Build a complete storage management system
- Create a storage quota monitor
- Build a storage sync system
- Create a storage migration utility

---

## Common Mistakes

### 1. Not Stringifying Objects

```javascript
// ⚠️ Problem: Stores "[object Object]"
localStorage.setItem('user', { name: 'Alice' });

// ✅ Solution: Stringify first
localStorage.setItem('user', JSON.stringify({ name: 'Alice' }));
```

### 2. Not Parsing Retrieved Data

```javascript
// ⚠️ Problem: Returns string, not object
let user = localStorage.getItem('user');
console.log(user.name);  // undefined

// ✅ Solution: Parse JSON
let user = JSON.parse(localStorage.getItem('user'));
console.log(user.name);  // "Alice"
```

### 3. Not Handling Errors

```javascript
// ⚠️ Problem: No error handling
localStorage.setItem('key', 'value');  // Might throw

// ✅ Solution: Try-catch
try {
    localStorage.setItem('key', 'value');
} catch (e) {
    if (e.name === 'QuotaExceededError') {
        // Handle quota exceeded
    }
}
```

### 4. Assuming Data Exists

```javascript
// ⚠️ Problem: Might be null
let user = JSON.parse(localStorage.getItem('user'));
console.log(user.name);  // Error if null

// ✅ Solution: Check first
let userStr = localStorage.getItem('user');
if (userStr) {
    let user = JSON.parse(userStr);
    console.log(user.name);
}
```

---

## Key Takeaways

1. **localStorage**: Persistent storage, survives browser restart
2. **sessionStorage**: Session-only storage, cleared on tab close
3. **Storage Methods**: setItem, getItem, removeItem, clear
4. **Data Types**: Store strings, stringify objects/arrays
5. **Limitations**: ~5-10MB per origin
6. **Storage Events**: Fired in other tabs when storage changes
7. **Best Practice**: Always stringify/parse, handle errors, check for null
8. **Use Cases**: Preferences, cart, form drafts, session data

---

## Quiz: Browser Storage

Test your understanding with these questions:

1. **localStorage data:**
   - A) Cleared on tab close
   - B) Persists across sessions
   - C) Cleared on page reload
   - D) Never cleared

2. **sessionStorage data:**
   - A) Persists across sessions
   - B) Cleared on tab close
   - C) Never cleared
   - D) Cleared on page reload

3. **Objects stored in storage:**
   - A) Directly
   - B) Must stringify
   - C) Not allowed
   - D) Automatically

4. **Storage quota is:**
   - A) Unlimited
   - B) ~5-10MB
   - C) 1MB
   - D) 100MB

5. **storage event fires:**
   - A) In same tab
   - B) In other tabs
   - C) Both
   - D) Never

6. **getItem() returns:**
   - A) Object
   - B) String or null
   - C) Number
   - D) Boolean

7. **clear() removes:**
   - A) One item
   - B) All items
   - C) Nothing
   - D) Only expired items

**Answers**:
1. B) Persists across sessions
2. B) Cleared on tab close
3. B) Must stringify
4. B) ~5-10MB
5. B) In other tabs
6. B) String or null
7. B) All items

---

## Next Steps

Congratulations! You've learned localStorage and sessionStorage. You now know:
- How to store and retrieve data
- Storage limitations and error handling
- Storage events
- Building storage utilities

**What's Next?**
- Lesson 16.2: IndexedDB
- Learn IndexedDB for larger storage
- Understand database operations
- Build more complex storage solutions

---

## Additional Resources

- **MDN: Web Storage API**: [developer.mozilla.org/en-US/docs/Web/API/Web_Storage_API](https://developer.mozilla.org/en-US/docs/Web/API/Web_Storage_API)
- **MDN: localStorage**: [developer.mozilla.org/en-US/docs/Web/API/Window/localStorage](https://developer.mozilla.org/en-US/docs/Web/API/Window/localStorage)
- **MDN: sessionStorage**: [developer.mozilla.org/en-US/docs/Web/API/Window/sessionStorage](https://developer.mozilla.org/en-US/docs/Web/API/Window/sessionStorage)

---

*Lesson completed! You're ready to move on to the next lesson.*

