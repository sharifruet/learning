# Lesson 16.2: IndexedDB

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand IndexedDB basics
- Create and open databases
- Create object stores
- Perform CRUD operations
- Use indexes for queries
- Handle transactions
- Compare IndexedDB with localStorage
- Build database-driven applications

---

## Introduction to IndexedDB

IndexedDB is a low-level API for storing large amounts of structured data in the browser. It's more powerful than localStorage but also more complex.

### Why IndexedDB?

- **Large Storage**: Store much more data than localStorage
- **Structured Data**: Store complex objects
- **Indexes**: Fast queries on any field
- **Transactions**: Safe concurrent operations
- **Asynchronous**: Non-blocking operations
- **Modern Standard**: W3C standard

### IndexedDB vs localStorage

| Feature | localStorage | IndexedDB |
|---------|-------------|-----------|
| Storage Size | ~5-10MB | Much larger (50%+ of disk) |
| Data Type | Strings only | Any structured data |
| Queries | Manual | Indexed queries |
| Performance | Fast for small data | Better for large data |
| Complexity | Simple | More complex |
| Async | Synchronous | Asynchronous |

---

## IndexedDB Basics

### Opening a Database

```javascript
let request = indexedDB.open('myDatabase', 1);

request.onerror = function(event) {
    console.error('Database error:', event.target.error);
};

request.onsuccess = function(event) {
    let db = event.target.result;
    console.log('Database opened:', db);
};

request.onupgradeneeded = function(event) {
    let db = event.target.result;
    // Create object stores here
    if (!db.objectStoreNames.contains('users')) {
        let objectStore = db.createObjectStore('users', { keyPath: 'id', autoIncrement: true });
        objectStore.createIndex('name', 'name', { unique: false });
        objectStore.createIndex('email', 'email', { unique: true });
    }
};
```

### Database Version

```javascript
// Version 1
let request = indexedDB.open('myDatabase', 1);

// Upgrade to version 2
let request = indexedDB.open('myDatabase', 2);

request.onupgradeneeded = function(event) {
    let db = event.target.result;
    let oldVersion = event.oldVersion;
    let newVersion = event.newVersion;
    
    if (oldVersion < 2) {
        // Migration code
    }
};
```

---

## Creating Object Stores

### Basic Object Store

```javascript
request.onupgradeneeded = function(event) {
    let db = event.target.result;
    
    // Create object store
    let objectStore = db.createObjectStore('users', {
        keyPath: 'id',
        autoIncrement: true
    });
};
```

### Object Store Options

```javascript
// With keyPath
let objectStore = db.createObjectStore('users', {
    keyPath: 'id'  // Use 'id' property as key
});

// With autoIncrement
let objectStore = db.createObjectStore('users', {
    keyPath: 'id',
    autoIncrement: true  // Auto-generate keys
});

// Without keyPath (use keys manually)
let objectStore = db.createObjectStore('items', {
    autoIncrement: false
});
```

### Creating Indexes

```javascript
request.onupgradeneeded = function(event) {
    let db = event.target.result;
    let objectStore = db.createObjectStore('users', {
        keyPath: 'id',
        autoIncrement: true
    });
    
    // Create index on name
    objectStore.createIndex('name', 'name', { unique: false });
    
    // Create unique index on email
    objectStore.createIndex('email', 'email', { unique: true });
    
    // Create index on age
    objectStore.createIndex('age', 'age', { unique: false });
};
```

---

## CRUD Operations

### Create (Add)

```javascript
function addUser(db, user) {
    let transaction = db.transaction(['users'], 'readwrite');
    let objectStore = transaction.objectStore('users');
    let request = objectStore.add(user);
    
    request.onsuccess = function() {
        console.log('User added:', request.result);
    };
    
    request.onerror = function() {
        console.error('Error adding user:', request.error);
    };
}

// Usage
indexedDB.open('myDatabase', 1).onsuccess = function(event) {
    let db = event.target.result;
    addUser(db, {
        name: 'Alice',
        email: 'alice@example.com',
        age: 30
    });
};
```

### Read (Get)

```javascript
function getUser(db, id) {
    let transaction = db.transaction(['users'], 'readonly');
    let objectStore = transaction.objectStore('users');
    let request = objectStore.get(id);
    
    request.onsuccess = function() {
        let user = request.result;
        if (user) {
            console.log('User found:', user);
        } else {
            console.log('User not found');
        }
    };
    
    request.onerror = function() {
        console.error('Error getting user:', request.error);
    };
}
```

### Update (Put)

```javascript
function updateUser(db, user) {
    let transaction = db.transaction(['users'], 'readwrite');
    let objectStore = transaction.objectStore('users');
    let request = objectStore.put(user);
    
    request.onsuccess = function() {
        console.log('User updated');
    };
    
    request.onerror = function() {
        console.error('Error updating user:', request.error);
    };
}

// Usage
updateUser(db, {
    id: 1,
    name: 'Alice Updated',
    email: 'alice@example.com',
    age: 31
});
```

### Delete

```javascript
function deleteUser(db, id) {
    let transaction = db.transaction(['users'], 'readwrite');
    let objectStore = transaction.objectStore('users');
    let request = objectStore.delete(id);
    
    request.onsuccess = function() {
        console.log('User deleted');
    };
    
    request.onerror = function() {
        console.error('Error deleting user:', request.error);
    };
}
```

---

## Queries and Indexes

### Get All Records

```javascript
function getAllUsers(db) {
    let transaction = db.transaction(['users'], 'readonly');
    let objectStore = transaction.objectStore('users');
    let request = objectStore.getAll();
    
    request.onsuccess = function() {
        let users = request.result;
        console.log('All users:', users);
    };
}
```

### Query by Index

```javascript
function getUserByEmail(db, email) {
    let transaction = db.transaction(['users'], 'readonly');
    let objectStore = transaction.objectStore('users');
    let index = objectStore.index('email');
    let request = index.get(email);
    
    request.onsuccess = function() {
        let user = request.result;
        if (user) {
            console.log('User found:', user);
        } else {
            console.log('User not found');
        }
    };
}
```

### Range Queries

```javascript
function getUsersByAgeRange(db, minAge, maxAge) {
    let transaction = db.transaction(['users'], 'readonly');
    let objectStore = transaction.objectStore('users');
    let index = objectStore.index('age');
    let range = IDBKeyRange.bound(minAge, maxAge);
    let request = index.getAll(range);
    
    request.onsuccess = function() {
        let users = request.result;
        console.log('Users in age range:', users);
    };
}
```

### Cursor Queries

```javascript
function getAllUsersWithCursor(db) {
    let transaction = db.transaction(['users'], 'readonly');
    let objectStore = transaction.objectStore('users');
    let request = objectStore.openCursor();
    
    request.onsuccess = function(event) {
        let cursor = event.target.result;
        if (cursor) {
            console.log('User:', cursor.value);
            cursor.continue();  // Move to next
        } else {
            console.log('No more users');
        }
    };
}
```

---

## Transactions

### Transaction Modes

```javascript
// Read-only transaction
let transaction = db.transaction(['users'], 'readonly');

// Read-write transaction
let transaction = db.transaction(['users'], 'readwrite');
```

### Transaction Events

```javascript
let transaction = db.transaction(['users'], 'readwrite');

transaction.oncomplete = function() {
    console.log('Transaction completed');
};

transaction.onerror = function() {
    console.error('Transaction error:', transaction.error);
};

transaction.onabort = function() {
    console.log('Transaction aborted');
};
```

### Multiple Object Stores

```javascript
let transaction = db.transaction(['users', 'orders'], 'readwrite');
let userStore = transaction.objectStore('users');
let orderStore = transaction.objectStore('orders');
```

---

## Practical Examples

### Example 1: Database Helper Class

```javascript
class IndexedDBHelper {
    constructor(dbName, version) {
        this.dbName = dbName;
        this.version = version;
        this.db = null;
    }
    
    open() {
        return new Promise((resolve, reject) => {
            let request = indexedDB.open(this.dbName, this.version);
            
            request.onerror = () => reject(request.error);
            request.onsuccess = () => {
                this.db = request.result;
                resolve(this.db);
            };
            
            request.onupgradeneeded = (event) => {
                let db = event.target.result;
                if (!db.objectStoreNames.contains('users')) {
                    let store = db.createObjectStore('users', {
                        keyPath: 'id',
                        autoIncrement: true
                    });
                    store.createIndex('email', 'email', { unique: true });
                }
            };
        });
    }
    
    add(storeName, data) {
        return new Promise((resolve, reject) => {
            let transaction = this.db.transaction([storeName], 'readwrite');
            let store = transaction.objectStore(storeName);
            let request = store.add(data);
            
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }
    
    get(storeName, key) {
        return new Promise((resolve, reject) => {
            let transaction = this.db.transaction([storeName], 'readonly');
            let store = transaction.objectStore(storeName);
            let request = store.get(key);
            
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }
    
    getAll(storeName) {
        return new Promise((resolve, reject) => {
            let transaction = this.db.transaction([storeName], 'readonly');
            let store = transaction.objectStore(storeName);
            let request = store.getAll();
            
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }
    
    put(storeName, data) {
        return new Promise((resolve, reject) => {
            let transaction = this.db.transaction([storeName], 'readwrite');
            let store = transaction.objectStore(storeName);
            let request = store.put(data);
            
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }
    
    delete(storeName, key) {
        return new Promise((resolve, reject) => {
            let transaction = this.db.transaction([storeName], 'readwrite');
            let store = transaction.objectStore(storeName);
            let request = store.delete(key);
            
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    }
    
    query(storeName, indexName, value) {
        return new Promise((resolve, reject) => {
            let transaction = this.db.transaction([storeName], 'readonly');
            let store = transaction.objectStore(storeName);
            let index = store.index(indexName);
            let request = index.get(value);
            
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }
}

// Usage
let dbHelper = new IndexedDBHelper('myDatabase', 1);
dbHelper.open().then(() => {
    return dbHelper.add('users', {
        name: 'Alice',
        email: 'alice@example.com'
    });
}).then(id => {
    console.log('User added with ID:', id);
    return dbHelper.get('users', id);
}).then(user => {
    console.log('User retrieved:', user);
});
```

### Example 2: User Management

```javascript
class UserManager {
    constructor() {
        this.db = null;
    }
    
    async init() {
        return new Promise((resolve, reject) => {
            let request = indexedDB.open('userDB', 1);
            
            request.onerror = () => reject(request.error);
            request.onsuccess = () => {
                this.db = request.result;
                resolve();
            };
            
            request.onupgradeneeded = (event) => {
                let db = event.target.result;
                if (!db.objectStoreNames.contains('users')) {
                    let store = db.createObjectStore('users', {
                        keyPath: 'id',
                        autoIncrement: true
                    });
                    store.createIndex('email', 'email', { unique: true });
                    store.createIndex('name', 'name', { unique: false });
                }
            };
        });
    }
    
    async addUser(user) {
        let transaction = this.db.transaction(['users'], 'readwrite');
        let store = transaction.objectStore('users');
        return new Promise((resolve, reject) => {
            let request = store.add(user);
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }
    
    async getUser(id) {
        let transaction = this.db.transaction(['users'], 'readonly');
        let store = transaction.objectStore('users');
        return new Promise((resolve, reject) => {
            let request = store.get(id);
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }
    
    async getUserByEmail(email) {
        let transaction = this.db.transaction(['users'], 'readonly');
        let store = transaction.objectStore('users');
        let index = store.index('email');
        return new Promise((resolve, reject) => {
            let request = index.get(email);
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }
    
    async getAllUsers() {
        let transaction = this.db.transaction(['users'], 'readonly');
        let store = transaction.objectStore('users');
        return new Promise((resolve, reject) => {
            let request = store.getAll();
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }
    
    async updateUser(user) {
        let transaction = this.db.transaction(['users'], 'readwrite');
        let store = transaction.objectStore('users');
        return new Promise((resolve, reject) => {
            let request = store.put(user);
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    }
    
    async deleteUser(id) {
        let transaction = this.db.transaction(['users'], 'readwrite');
        let store = transaction.objectStore('users');
        return new Promise((resolve, reject) => {
            let request = store.delete(id);
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    }
}

// Usage
let userManager = new UserManager();
userManager.init().then(async () => {
    await userManager.addUser({
        name: 'Alice',
        email: 'alice@example.com',
        age: 30
    });
    
    let user = await userManager.getUserByEmail('alice@example.com');
    console.log('User found:', user);
});
```

---

## Practice Exercise

### Exercise: IndexedDB Practice

**Objective**: Practice creating databases, object stores, and performing CRUD operations.

**Instructions**:

1. Create an HTML file with a form
2. Create a JavaScript file for IndexedDB operations
3. Practice:
   - Creating and opening databases
   - Creating object stores and indexes
   - Adding, reading, updating, deleting data
   - Querying data with indexes

**Example Solution**:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IndexedDB Practice</title>
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
        input {
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
        <h1>IndexedDB Practice</h1>
        
        <h2>Add User</h2>
        <form id="userForm">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" required>
            </div>
            <button type="submit">Add User</button>
        </form>
        
        <h2>Operations</h2>
        <button onclick="showAllUsers()">Show All Users</button>
        <button onclick="clearUsers()">Clear All Users</button>
        
        <div id="output" class="output"></div>
    </div>
    
    <script src="indexeddb-practice.js"></script>
</body>
</html>
```

```javascript
// indexeddb-practice.js
console.log("=== IndexedDB Practice ===");

let db = null;
let output = document.getElementById('output');

function log(message) {
    console.log(message);
    output.innerHTML += '<p>' + message + '</p>';
}

function clearOutput() {
    output.innerHTML = '';
}

console.log("\n=== Opening Database ===");

let request = indexedDB.open('practiceDB', 1);

request.onerror = function(event) {
    console.error('Database error:', event.target.error);
    log('Error opening database: ' + event.target.error);
};

request.onsuccess = function(event) {
    db = event.target.result;
    console.log('Database opened successfully');
    log('Database opened successfully');
    
    // Show all users on load
    showAllUsers();
};

request.onupgradeneeded = function(event) {
    db = event.target.result;
    console.log('Database upgrade needed');
    
    // Create users object store
    if (!db.objectStoreNames.contains('users')) {
        let objectStore = db.createObjectStore('users', {
            keyPath: 'id',
            autoIncrement: true
        });
        
        // Create indexes
        objectStore.createIndex('email', 'email', { unique: true });
        objectStore.createIndex('name', 'name', { unique: false });
        objectStore.createIndex('age', 'age', { unique: false });
        
        console.log('Object store and indexes created');
    }
};
console.log();

console.log("=== Adding Users ===");

let userForm = document.getElementById('userForm');
userForm.addEventListener('submit', function(event) {
    event.preventDefault();
    
    let user = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        age: parseInt(document.getElementById('age').value)
    };
    
    addUser(user);
    
    // Reset form
    userForm.reset();
});

function addUser(user) {
    if (!db) {
        log('Database not ready');
        return;
    }
    
    let transaction = db.transaction(['users'], 'readwrite');
    let objectStore = transaction.objectStore('users');
    let request = objectStore.add(user);
    
    request.onsuccess = function() {
        let id = request.result;
        console.log('User added with ID:', id);
        log('User added with ID: ' + id);
        showAllUsers();
    };
    
    request.onerror = function() {
        console.error('Error adding user:', request.error);
        log('Error adding user: ' + request.error.message);
    };
}
console.log();

console.log("=== Getting All Users ===");

function showAllUsers() {
    if (!db) {
        log('Database not ready');
        return;
    }
    
    clearOutput();
    
    let transaction = db.transaction(['users'], 'readonly');
    let objectStore = transaction.objectStore('users');
    let request = objectStore.getAll();
    
    request.onsuccess = function() {
        let users = request.result;
        console.log('All users:', users);
        
        if (users.length === 0) {
            log('No users in database');
        } else {
            log('Users (' + users.length + '):');
            users.forEach(user => {
                log(`ID: ${user.id}, Name: ${user.name}, Email: ${user.email}, Age: ${user.age}`);
            });
        }
    };
    
    request.onerror = function() {
        console.error('Error getting users:', request.error);
        log('Error getting users: ' + request.error.message);
    };
}
console.log();

console.log("=== Getting User by ID ===");

function getUser(id) {
    if (!db) {
        return Promise.reject('Database not ready');
    }
    
    return new Promise((resolve, reject) => {
        let transaction = db.transaction(['users'], 'readonly');
        let objectStore = transaction.objectStore('users');
        let request = objectStore.get(id);
        
        request.onsuccess = function() {
            resolve(request.result);
        };
        
        request.onerror = function() {
            reject(request.error);
        };
    });
}
console.log();

console.log("=== Querying by Index ===");

function getUserByEmail(email) {
    if (!db) {
        return Promise.reject('Database not ready');
    }
    
    return new Promise((resolve, reject) => {
        let transaction = db.transaction(['users'], 'readonly');
        let objectStore = transaction.objectStore('users');
        let index = objectStore.index('email');
        let request = index.get(email);
        
        request.onsuccess = function() {
            resolve(request.result);
        };
        
        request.onerror = function() {
            reject(request.error);
        };
    });
}
console.log();

console.log("=== Updating User ===");

function updateUser(user) {
    if (!db) {
        return Promise.reject('Database not ready');
    }
    
    return new Promise((resolve, reject) => {
        let transaction = db.transaction(['users'], 'readwrite');
        let objectStore = transaction.objectStore('users');
        let request = objectStore.put(user);
        
        request.onsuccess = function() {
            resolve();
        };
        
        request.onerror = function() {
            reject(request.error);
        };
    });
}
console.log();

console.log("=== Deleting User ===");

function deleteUser(id) {
    if (!db) {
        return Promise.reject('Database not ready');
    }
    
    return new Promise((resolve, reject) => {
        let transaction = db.transaction(['users'], 'readwrite');
        let objectStore = transaction.objectStore('users');
        let request = objectStore.delete(id);
        
        request.onsuccess = function() {
            resolve();
        };
        
        request.onerror = function() {
            reject(request.error);
        };
    });
}
console.log();

console.log("=== Clearing All Users ===");

function clearUsers() {
    if (!db) {
        log('Database not ready');
        return;
    }
    
    let transaction = db.transaction(['users'], 'readwrite');
    let objectStore = transaction.objectStore('users');
    let request = objectStore.clear();
    
    request.onsuccess = function() {
        console.log('All users cleared');
        log('All users cleared');
        showAllUsers();
    };
    
    request.onerror = function() {
        console.error('Error clearing users:', request.error);
        log('Error clearing users: ' + request.error.message);
    };
}
console.log();

console.log("=== Using Cursor ===");

function getAllUsersWithCursor() {
    if (!db) {
        return Promise.reject('Database not ready');
    }
    
    return new Promise((resolve, reject) => {
        let users = [];
        let transaction = db.transaction(['users'], 'readonly');
        let objectStore = transaction.objectStore('users');
        let request = objectStore.openCursor();
        
        request.onsuccess = function(event) {
            let cursor = event.target.result;
            if (cursor) {
                users.push(cursor.value);
                cursor.continue();
            } else {
                resolve(users);
            }
        };
        
        request.onerror = function() {
            reject(request.error);
        };
    });
}
console.log();

console.log("=== Range Queries ===");

function getUsersByAgeRange(minAge, maxAge) {
    if (!db) {
        return Promise.reject('Database not ready');
    }
    
    return new Promise((resolve, reject) => {
        let transaction = db.transaction(['users'], 'readonly');
        let objectStore = transaction.objectStore('users');
        let index = objectStore.index('age');
        let range = IDBKeyRange.bound(minAge, maxAge);
        let request = index.getAll(range);
        
        request.onsuccess = function() {
            resolve(request.result);
        };
        
        request.onerror = function() {
            reject(request.error);
        };
    });
}
console.log();

console.log("=== Database Helper Class ===");

class DBHelper {
    constructor(dbName, version) {
        this.dbName = dbName;
        this.version = version;
        this.db = null;
    }
    
    open() {
        return new Promise((resolve, reject) => {
            let request = indexedDB.open(this.dbName, this.version);
            
            request.onerror = () => reject(request.error);
            request.onsuccess = () => {
                this.db = request.result;
                resolve(this.db);
            };
            
            request.onupgradeneeded = (event) => {
                let db = event.target.result;
                if (!db.objectStoreNames.contains('users')) {
                    let store = db.createObjectStore('users', {
                        keyPath: 'id',
                        autoIncrement: true
                    });
                    store.createIndex('email', 'email', { unique: true });
                }
            };
        });
    }
    
    add(storeName, data) {
        return new Promise((resolve, reject) => {
            let transaction = this.db.transaction([storeName], 'readwrite');
            let store = transaction.objectStore(storeName);
            let request = store.add(data);
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }
    
    get(storeName, key) {
        return new Promise((resolve, reject) => {
            let transaction = this.db.transaction([storeName], 'readonly');
            let store = transaction.objectStore(storeName);
            let request = store.get(key);
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }
    
    getAll(storeName) {
        return new Promise((resolve, reject) => {
            let transaction = this.db.transaction([storeName], 'readonly');
            let store = transaction.objectStore(storeName);
            let request = store.getAll();
            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }
    
    put(storeName, data) {
        return new Promise((resolve, reject) => {
            let transaction = this.db.transaction([storeName], 'readwrite');
            let store = transaction.objectStore(storeName);
            let request = store.put(data);
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    }
    
    delete(storeName, key) {
        return new Promise((resolve, reject) => {
            let transaction = this.db.transaction([storeName], 'readwrite');
            let store = transaction.objectStore(storeName);
            let request = store.delete(key);
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    }
}

// Demonstrate helper
let helper = new DBHelper('helperDB', 1);
helper.open().then(() => {
    console.log('Helper database opened');
    return helper.add('users', { name: 'Test', email: 'test@example.com' });
}).then(id => {
    console.log('Added with ID:', id);
    return helper.get('users', id);
}).then(user => {
    console.log('Retrieved user:', user);
});
```

**Expected Output** (in browser console):
```
=== IndexedDB Practice ===

=== Opening Database ===
Database opened successfully
Database upgrade needed
Object store and indexes created

=== Adding Users ===
[On form submit]
User added with ID: 1

=== Getting All Users ===
[On show all]
All users: [array]
Users (1):
ID: 1, Name: Alice, Email: alice@example.com, Age: 30

=== Database Helper Class ===
Helper database opened
Added with ID: 1
Retrieved user: {id: 1, name: "Test", email: "test@example.com"}
```

**Challenge (Optional)**:
- Build a complete database management system
- Create a complex query system
- Build a data migration utility
- Create a database backup/restore system

---

## Common Mistakes

### 1. Not Handling onupgradeneeded

```javascript
// ⚠️ Problem: Object stores not created
let request = indexedDB.open('db', 1);
request.onsuccess = function(event) {
    let db = event.target.result;
    // Object store doesn't exist!
};

// ✅ Solution: Create in onupgradeneeded
request.onupgradeneeded = function(event) {
    let db = event.target.result;
    db.createObjectStore('users', { keyPath: 'id' });
};
```

### 2. Using Database Before It's Ready

```javascript
// ⚠️ Problem: Database might not be ready
let db = null;
indexedDB.open('db', 1).onsuccess = function(event) {
    db = event.target.result;
};
addUser(db, user);  // db might be null!

// ✅ Solution: Wait for success
indexedDB.open('db', 1).onsuccess = function(event) {
    let db = event.target.result;
    addUser(db, user);
};
```

### 3. Not Handling Errors

```javascript
// ⚠️ Problem: No error handling
let request = objectStore.add(user);

// ✅ Solution: Handle errors
request.onerror = function() {
    console.error('Error:', request.error);
};
```

### 4. Forgetting Transaction Completion

```javascript
// ⚠️ Problem: Transaction might complete before operation
let transaction = db.transaction(['users'], 'readwrite');
let store = transaction.objectStore('users');
store.add(user);
// Transaction might complete before add finishes

// ✅ Solution: Wait for request
let request = store.add(user);
request.onsuccess = function() {
    // Operation complete
};
```

---

## Key Takeaways

1. **IndexedDB**: Large structured data storage
2. **Asynchronous**: All operations are async
3. **Object Stores**: Like tables in a database
4. **Indexes**: Fast queries on any field
5. **Transactions**: Safe concurrent operations
6. **CRUD Operations**: Add, get, put, delete
7. **Best Practice**: Handle errors, wait for operations, use transactions
8. **Use Cases**: Large data, complex queries, offline apps

---

## Quiz: IndexedDB

Test your understanding with these questions:

1. **IndexedDB is:**
   - A) Synchronous
   - B) Asynchronous
   - C) Both
   - D) Neither

2. **Object stores created in:**
   - A) onsuccess
   - B) onupgradeneeded
   - C) onerror
   - D) Anywhere

3. **Indexes are used for:**
   - A) Storage only
   - B) Fast queries
   - C) Validation
   - D) Nothing

4. **Transactions can be:**
   - A) Read-only
   - B) Read-write
   - C) Both
   - D) Neither

5. **keyPath is:**
   - A) Index name
   - B) Property used as key
   - C) Store name
   - D) Database name

6. **Cursor is used for:**
   - A) Iterating records
   - B) Getting one record
   - C) Deleting records
   - D) Nothing

7. **IndexedDB stores:**
   - A) Only strings
   - B) Structured data
   - C) Only numbers
   - D) Nothing

**Answers**:
1. B) Asynchronous
2. B) onupgradeneeded
3. B) Fast queries
4. C) Both
5. B) Property used as key
6. A) Iterating records
7. B) Structured data

---

## Next Steps

Congratulations! You've completed Module 16: Browser Storage. You now know:
- localStorage and sessionStorage
- IndexedDB for large data
- CRUD operations
- Database queries

**What's Next?**
- Module 17: Browser APIs
- Lesson 17.1: Geolocation API
- Learn to get user location
- Work with browser APIs

---

## Additional Resources

- **MDN: IndexedDB**: [developer.mozilla.org/en-US/docs/Web/API/IndexedDB_API](https://developer.mozilla.org/en-US/docs/Web/API/IndexedDB_API)
- **MDN: Using IndexedDB**: [developer.mozilla.org/en-US/docs/Web/API/IndexedDB_API/Using_IndexedDB](https://developer.mozilla.org/en-US/docs/Web/API/IndexedDB_API/Using_IndexedDB)
- **JavaScript.info: IndexedDB**: [javascript.info/indexeddb](https://javascript.info/indexeddb)

---

*Lesson completed! You've finished Module 16: Browser Storage. Ready for Module 17: Browser APIs!*

