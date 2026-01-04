# Lesson 30.1: Working with Databases

## Learning Objectives

By the end of this lesson, you will be able to:
- Work with SQL databases (MySQL, PostgreSQL)
- Work with NoSQL databases (MongoDB)
- Use ORMs (Sequelize, Mongoose)
- Establish database connections
- Perform CRUD operations
- Query databases
- Integrate databases with Node.js applications

---

## Introduction to Databases

Databases are systems for storing and managing data. They provide efficient ways to store, retrieve, and manipulate data.

### Types of Databases

- **SQL Databases**: Relational databases (MySQL, PostgreSQL)
- **NoSQL Databases**: Non-relational databases (MongoDB, Redis)
- **In-Memory Databases**: Store data in memory (Redis)
- **Document Databases**: Store documents (MongoDB)
- **Graph Databases**: Store relationships (Neo4j)

---

## SQL Databases

### MySQL

MySQL is a popular open-source relational database management system.

#### Installation

```bash
# Install MySQL driver
npm install mysql2

# Or with promise support
npm install mysql2/promise
```

#### Basic Connection

```javascript
const mysql = require('mysql2/promise');

// Create connection pool
const pool = mysql.createPool({
    host: 'localhost',
    user: 'root',
    password: 'password',
    database: 'mydb',
    waitForConnections: true,
    connectionLimit: 10,
    queueLimit: 0
});

// Use connection
async function getUsers() {
    const [rows] = await pool.execute('SELECT * FROM users');
    return rows;
}
```

#### CRUD Operations

```javascript
const mysql = require('mysql2/promise');

const pool = mysql.createPool({
    host: 'localhost',
    user: 'root',
    password: 'password',
    database: 'mydb'
});

// CREATE
async function createUser(name, email) {
    const [result] = await pool.execute(
        'INSERT INTO users (name, email) VALUES (?, ?)',
        [name, email]
    );
    return result.insertId;
}

// READ
async function getUsers() {
    const [rows] = await pool.execute('SELECT * FROM users');
    return rows;
}

async function getUserById(id) {
    const [rows] = await pool.execute(
        'SELECT * FROM users WHERE id = ?',
        [id]
    );
    return rows[0];
}

// UPDATE
async function updateUser(id, name, email) {
    const [result] = await pool.execute(
        'UPDATE users SET name = ?, email = ? WHERE id = ?',
        [name, email, id]
    );
    return result.affectedRows;
}

// DELETE
async function deleteUser(id) {
    const [result] = await pool.execute(
        'DELETE FROM users WHERE id = ?',
        [id]
    );
    return result.affectedRows;
}
```

### PostgreSQL

PostgreSQL is a powerful open-source relational database.

#### Installation

```bash
npm install pg
```

#### Basic Connection

```javascript
const { Pool } = require('pg');

const pool = new Pool({
    user: 'postgres',
    host: 'localhost',
    database: 'mydb',
    password: 'password',
    port: 5432
});

// Query
async function getUsers() {
    const result = await pool.query('SELECT * FROM users');
    return result.rows;
}
```

#### CRUD Operations

```javascript
const { Pool } = require('pg');

const pool = new Pool({
    user: 'postgres',
    host: 'localhost',
    database: 'mydb',
    password: 'password',
    port: 5432
});

// CREATE
async function createUser(name, email) {
    const result = await pool.query(
        'INSERT INTO users (name, email) VALUES ($1, $2) RETURNING *',
        [name, email]
    );
    return result.rows[0];
}

// READ
async function getUsers() {
    const result = await pool.query('SELECT * FROM users');
    return result.rows;
}

// UPDATE
async function updateUser(id, name, email) {
    const result = await pool.query(
        'UPDATE users SET name = $1, email = $2 WHERE id = $3 RETURNING *',
        [name, email, id]
    );
    return result.rows[0];
}

// DELETE
async function deleteUser(id) {
    const result = await pool.query(
        'DELETE FROM users WHERE id = $1 RETURNING *',
        [id]
    );
    return result.rows[0];
}
```

---

## NoSQL Databases

### MongoDB

MongoDB is a popular NoSQL document database.

#### Installation

```bash
npm install mongodb
# Or with Mongoose
npm install mongoose
```

#### Basic Connection (Native Driver)

```javascript
const { MongoClient } = require('mongodb');

const uri = 'mongodb://localhost:27017';
const client = new MongoClient(uri);

async function connect() {
    try {
        await client.connect();
        console.log('Connected to MongoDB');
        return client.db('mydb');
    } catch (error) {
        console.error('Connection error:', error);
        throw error;
    }
}

// Use database
async function getUsers() {
    const db = await connect();
    const users = db.collection('users');
    return await users.find({}).toArray();
}
```

#### CRUD Operations (Native Driver)

```javascript
const { MongoClient } = require('mongodb');

const uri = 'mongodb://localhost:27017';
const client = new MongoClient(uri);

async function getDb() {
    await client.connect();
    return client.db('mydb');
}

// CREATE
async function createUser(name, email) {
    const db = await getDb();
    const users = db.collection('users');
    const result = await users.insertOne({ name, email });
    return result.insertedId;
}

// READ
async function getUsers() {
    const db = await getDb();
    const users = db.collection('users');
    return await users.find({}).toArray();
}

async function getUserById(id) {
    const db = await getDb();
    const users = db.collection('users');
    return await users.findOne({ _id: id });
}

// UPDATE
async function updateUser(id, name, email) {
    const db = await getDb();
    const users = db.collection('users');
    const result = await users.updateOne(
        { _id: id },
        { $set: { name, email } }
    );
    return result.modifiedCount;
}

// DELETE
async function deleteUser(id) {
    const db = await getDb();
    const users = db.collection('users');
    const result = await users.deleteOne({ _id: id });
    return result.deletedCount;
}
```

---

## ORMs

### Sequelize (SQL ORM)

Sequelize is a promise-based ORM for Node.js.

#### Installation

```bash
npm install sequelize
npm install mysql2  # For MySQL
# or
npm install pg pg-hstore  # For PostgreSQL
```

#### Basic Setup

```javascript
const { Sequelize } = require('sequelize');

const sequelize = new Sequelize('mydb', 'user', 'password', {
    host: 'localhost',
    dialect: 'mysql'
});

// Test connection
async function testConnection() {
    try {
        await sequelize.authenticate();
        console.log('Connection established');
    } catch (error) {
        console.error('Unable to connect:', error);
    }
}
```

#### Define Models

```javascript
const { Sequelize, DataTypes } = require('sequelize');

const sequelize = new Sequelize('mydb', 'user', 'password', {
    host: 'localhost',
    dialect: 'mysql'
});

// Define User model
const User = sequelize.define('User', {
    id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    name: {
        type: DataTypes.STRING,
        allowNull: false
    },
    email: {
        type: DataTypes.STRING,
        allowNull: false,
        unique: true
    }
}, {
    tableName: 'users',
    timestamps: true
});

// Sync model
await User.sync();
```

#### CRUD Operations (Sequelize)

```javascript
// CREATE
const user = await User.create({
    name: 'Alice',
    email: 'alice@example.com'
});

// READ
const users = await User.findAll();
const user = await User.findByPk(1);
const user = await User.findOne({ where: { email: 'alice@example.com' } });

// UPDATE
await user.update({ name: 'Alice Updated' });
// or
await User.update(
    { name: 'Alice Updated' },
    { where: { id: 1 } }
);

// DELETE
await user.destroy();
// or
await User.destroy({ where: { id: 1 } });
```

### Mongoose (MongoDB ORM)

Mongoose is an ODM (Object Document Mapper) for MongoDB.

#### Installation

```bash
npm install mongoose
```

#### Basic Setup

```javascript
const mongoose = require('mongoose');

const uri = 'mongodb://localhost:27017/mydb';

async function connect() {
    try {
        await mongoose.connect(uri);
        console.log('Connected to MongoDB');
    } catch (error) {
        console.error('Connection error:', error);
        throw error;
    }
}
```

#### Define Schemas

```javascript
const mongoose = require('mongoose');

const userSchema = new mongoose.Schema({
    name: {
        type: String,
        required: true
    },
    email: {
        type: String,
        required: true,
        unique: true
    },
    age: {
        type: Number,
        min: 0
    },
    createdAt: {
        type: Date,
        default: Date.now
    }
});

const User = mongoose.model('User', userSchema);
```

#### CRUD Operations (Mongoose)

```javascript
// CREATE
const user = await User.create({
    name: 'Alice',
    email: 'alice@example.com',
    age: 30
});

// READ
const users = await User.find();
const user = await User.findById(id);
const user = await User.findOne({ email: 'alice@example.com' });

// UPDATE
await User.findByIdAndUpdate(id, { name: 'Alice Updated' });
// or
user.name = 'Alice Updated';
await user.save();

// DELETE
await User.findByIdAndDelete(id);
// or
await user.deleteOne();
```

---

## Database Connections

### Connection Pooling

```javascript
// MySQL with connection pool
const mysql = require('mysql2/promise');

const pool = mysql.createPool({
    host: 'localhost',
    user: 'root',
    password: 'password',
    database: 'mydb',
    waitForConnections: true,
    connectionLimit: 10,
    queueLimit: 0
});

// Use pool
const [rows] = await pool.execute('SELECT * FROM users');
```

### Environment Variables

```javascript
// .env file
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=password
DB_NAME=mydb
DB_PORT=3306

// Use in code
require('dotenv').config();

const pool = mysql.createPool({
    host: process.env.DB_HOST,
    user: process.env.DB_USER,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_NAME,
    port: process.env.DB_PORT
});
```

### Error Handling

```javascript
async function getUsers() {
    try {
        const [rows] = await pool.execute('SELECT * FROM users');
        return rows;
    } catch (error) {
        console.error('Database error:', error);
        throw error;
    }
}
```

---

## Practice Exercise

### Exercise: Database Integration

**Objective**: Practice working with databases, using ORMs, and integrating databases with Node.js applications.

**Instructions**:

1. Set up database connection
2. Create models/schemas
3. Implement CRUD operations
4. Practice:
   - SQL databases (MySQL/PostgreSQL)
   - NoSQL databases (MongoDB)
   - ORMs (Sequelize/Mongoose)
   - Database connections

**Example Solution**:

```javascript
// src/config/database.js
const mysql = require('mysql2/promise');
require('dotenv').config();

const pool = mysql.createPool({
    host: process.env.DB_HOST || 'localhost',
    user: process.env.DB_USER || 'root',
    password: process.env.DB_PASSWORD || '',
    database: process.env.DB_NAME || 'mydb',
    waitForConnections: true,
    connectionLimit: 10,
    queueLimit: 0
});

module.exports = pool;
```

```javascript
// src/models/user.js (MySQL with mysql2)
const pool = require('../config/database');

class User {
    static async findAll() {
        const [rows] = await pool.execute('SELECT * FROM users');
        return rows;
    }
    
    static async findById(id) {
        const [rows] = await pool.execute(
            'SELECT * FROM users WHERE id = ?',
            [id]
        );
        return rows[0];
    }
    
    static async create(name, email) {
        const [result] = await pool.execute(
            'INSERT INTO users (name, email) VALUES (?, ?)',
            [name, email]
        );
        return result.insertId;
    }
    
    static async update(id, name, email) {
        const [result] = await pool.execute(
            'UPDATE users SET name = ?, email = ? WHERE id = ?',
            [name, email, id]
        );
        return result.affectedRows;
    }
    
    static async delete(id) {
        const [result] = await pool.execute(
            'DELETE FROM users WHERE id = ?',
            [id]
        );
        return result.affectedRows;
    }
}

module.exports = User;
```

```javascript
// src/models/user.js (MongoDB with Mongoose)
const mongoose = require('mongoose');

const userSchema = new mongoose.Schema({
    name: {
        type: String,
        required: true,
        trim: true
    },
    email: {
        type: String,
        required: true,
        unique: true,
        lowercase: true,
        trim: true
    },
    age: {
        type: Number,
        min: 0
    }
}, {
    timestamps: true
});

const User = mongoose.model('User', userSchema);

module.exports = User;
```

```javascript
// src/models/user.js (Sequelize)
const { DataTypes } = require('sequelize');
const sequelize = require('../config/database');

const User = sequelize.define('User', {
    id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    name: {
        type: DataTypes.STRING,
        allowNull: false,
        validate: {
            notEmpty: true
        }
    },
    email: {
        type: DataTypes.STRING,
        allowNull: false,
        unique: true,
        validate: {
            isEmail: true
        }
    },
    age: {
        type: DataTypes.INTEGER,
        allowNull: true,
        validate: {
            min: 0
        }
    }
}, {
    tableName: 'users',
    timestamps: true
});

module.exports = User;
```

```javascript
// src/routes/users.js (with MySQL)
const express = require('express');
const router = express.Router();
const User = require('../models/user');

router.get('/', async (req, res) => {
    try {
        const users = await User.findAll();
        res.json({ success: true, data: users });
    } catch (error) {
        res.status(500).json({ success: false, error: error.message });
    }
});

router.get('/:id', async (req, res) => {
    try {
        const user = await User.findById(req.params.id);
        if (user) {
            res.json({ success: true, data: user });
        } else {
            res.status(404).json({ success: false, error: 'User not found' });
        }
    } catch (error) {
        res.status(500).json({ success: false, error: error.message });
    }
});

router.post('/', async (req, res) => {
    try {
        const { name, email } = req.body;
        if (!name || !email) {
            return res.status(400).json({
                success: false,
                error: 'Name and email are required'
            });
        }
        
        const userId = await User.create(name, email);
        res.status(201).json({
            success: true,
            data: { id: userId, name, email }
        });
    } catch (error) {
        res.status(500).json({ success: false, error: error.message });
    }
});

router.put('/:id', async (req, res) => {
    try {
        const { name, email } = req.body;
        const affectedRows = await User.update(req.params.id, name, email);
        
        if (affectedRows > 0) {
            res.json({ success: true, message: 'User updated' });
        } else {
            res.status(404).json({ success: false, error: 'User not found' });
        }
    } catch (error) {
        res.status(500).json({ success: false, error: error.message });
    }
});

router.delete('/:id', async (req, res) => {
    try {
        const affectedRows = await User.delete(req.params.id);
        
        if (affectedRows > 0) {
            res.status(204).send();
        } else {
            res.status(404).json({ success: false, error: 'User not found' });
        }
    } catch (error) {
        res.status(500).json({ success: false, error: error.message });
    }
});

module.exports = router;
```

```javascript
// src/routes/users.js (with Mongoose)
const express = require('express');
const router = express.Router();
const User = require('../models/user');

router.get('/', async (req, res) => {
    try {
        const users = await User.find();
        res.json({ success: true, data: users });
    } catch (error) {
        res.status(500).json({ success: false, error: error.message });
    }
});

router.get('/:id', async (req, res) => {
    try {
        const user = await User.findById(req.params.id);
        if (user) {
            res.json({ success: true, data: user });
        } else {
            res.status(404).json({ success: false, error: 'User not found' });
        }
    } catch (error) {
        res.status(500).json({ success: false, error: error.message });
    }
});

router.post('/', async (req, res) => {
    try {
        const { name, email, age } = req.body;
        const user = await User.create({ name, email, age });
        res.status(201).json({ success: true, data: user });
    } catch (error) {
        res.status(500).json({ success: false, error: error.message });
    }
});

router.put('/:id', async (req, res) => {
    try {
        const user = await User.findByIdAndUpdate(
            req.params.id,
            req.body,
            { new: true, runValidators: true }
        );
        
        if (user) {
            res.json({ success: true, data: user });
        } else {
            res.status(404).json({ success: false, error: 'User not found' });
        }
    } catch (error) {
        res.status(500).json({ success: false, error: error.message });
    }
});

router.delete('/:id', async (req, res) => {
    try {
        const user = await User.findByIdAndDelete(req.params.id);
        
        if (user) {
            res.status(204).send();
        } else {
            res.status(404).json({ success: false, error: 'User not found' });
        }
    } catch (error) {
        res.status(500).json({ success: false, error: error.message });
    }
});

module.exports = router;
```

```javascript
// src/app.js
const express = require('express');
const mongoose = require('mongoose');
const usersRouter = require('./routes/users');
require('dotenv').config();

const app = express();

app.use(express.json());

// Connect to MongoDB
mongoose.connect(process.env.MONGODB_URI || 'mongodb://localhost:27017/mydb')
    .then(() => console.log('Connected to MongoDB'))
    .catch(err => console.error('MongoDB connection error:', err));

// Routes
app.use('/api/users', usersRouter);

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});
```

**Expected Output**:
- Database connection established
- CRUD operations working
- API endpoints functional
- Error handling in place

**Challenge (Optional)**:
- Add relationships/associations
- Implement transactions
- Add database migrations
- Create complex queries

---

## Common Mistakes

### 1. SQL Injection

```javascript
// ❌ Bad: SQL injection vulnerability
const query = `SELECT * FROM users WHERE name = '${name}'`;

// ✅ Good: Use parameterized queries
const [rows] = await pool.execute(
    'SELECT * FROM users WHERE name = ?',
    [name]
);
```

### 2. Not Closing Connections

```javascript
// ❌ Bad: Connection not closed
const connection = await mysql.createConnection(config);

// ✅ Good: Use connection pool or close connection
const pool = mysql.createPool(config);
// Pool manages connections automatically
```

### 3. Not Handling Errors

```javascript
// ❌ Bad: No error handling
const users = await User.find();

// ✅ Good: Handle errors
try {
    const users = await User.find();
} catch (error) {
    console.error('Database error:', error);
    throw error;
}
```

---

## Key Takeaways

1. **SQL Databases**: MySQL, PostgreSQL (relational)
2. **NoSQL Databases**: MongoDB (document-based)
3. **ORMs**: Sequelize (SQL), Mongoose (MongoDB)
4. **Connections**: Use connection pools
5. **Security**: Use parameterized queries
6. **Best Practice**: Handle errors, use environment variables
7. **Choose**: Based on use case and requirements

---

## Quiz: Databases

Test your understanding with these questions:

1. **SQL databases:**
   - A) Relational
   - B) Non-relational
   - C) Both
   - D) Neither

2. **NoSQL databases:**
   - A) Relational
   - B) Non-relational
   - C) Both
   - D) Neither

3. **Sequelize:**
   - A) SQL ORM
   - B) MongoDB ODM
   - C) Both
   - D) Neither

4. **Mongoose:**
   - A) SQL ORM
   - B) MongoDB ODM
   - C) Both
   - D) Neither

5. **Connection pool:**
   - A) Manages connections
   - B) Single connection
   - C) Both
   - D) Neither

6. **Parameterized queries:**
   - A) Prevent SQL injection
   - B) Don't prevent SQL injection
   - C) Both
   - D) Neither

7. **MongoDB:**
   - A) Document database
   - B) Relational database
   - C) Both
   - D) Neither

**Answers**:
1. A) Relational
2. B) Non-relational
3. A) SQL ORM
4. B) MongoDB ODM
5. A) Manages connections
6. A) Prevent SQL injection
7. A) Document database

---

## Next Steps

Congratulations! You've learned working with databases. You now know:
- How to work with SQL databases
- How to work with NoSQL databases
- How to use ORMs
- How to establish database connections

**What's Next?**
- Lesson 30.2: Authentication and Security
- Learn authentication strategies
- Understand JWT tokens
- Implement password hashing

---

## Additional Resources

- **MySQL**: [dev.mysql.com](https://dev.mysql.com)
- **PostgreSQL**: [postgresql.org](https://www.postgresql.org)
- **MongoDB**: [mongodb.com](https://www.mongodb.com)
- **Sequelize**: [sequelize.org](https://sequelize.org)
- **Mongoose**: [mongoosejs.com](https://mongoosejs.com)

---

*Lesson completed! You're ready to move on to the next lesson.*

