# Lesson 30.2: Authentication and Security

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand authentication strategies
- Implement JWT tokens
- Hash passwords with bcrypt
- Manage sessions
- Apply security best practices
- Build secure authentication systems
- Protect user data

---

## Introduction to Authentication

Authentication is the process of verifying who a user is. It ensures that users are who they claim to be.

### Authentication vs Authorization

- **Authentication**: Verifying identity (who you are)
- **Authorization**: Verifying permissions (what you can do)

### Authentication Methods

- **Password-based**: Username and password
- **Token-based**: JWT tokens
- **Session-based**: Server-side sessions
- **OAuth**: Third-party authentication
- **Multi-factor**: Multiple verification methods

---

## Authentication Strategies

### Basic Authentication

```javascript
const express = require('express');
const app = express();

// Basic auth middleware
const basicAuth = (req, res, next) => {
    const authHeader = req.headers.authorization;
    
    if (!authHeader) {
        return res.status(401).json({ error: 'Unauthorized' });
    }
    
    const credentials = Buffer.from(
        authHeader.split(' ')[1],
        'base64'
    ).toString().split(':');
    
    const [username, password] = credentials;
    
    // Verify credentials
    if (username === 'admin' && password === 'password') {
        next();
    } else {
        res.status(401).json({ error: 'Invalid credentials' });
    }
};

app.get('/protected', basicAuth, (req, res) => {
    res.json({ message: 'Protected resource' });
});
```

### Custom Authentication

```javascript
const express = require('express');
const app = express();

// Login endpoint
app.post('/login', async (req, res) => {
    const { email, password } = req.body;
    
    // Find user
    const user = await User.findOne({ email });
    if (!user) {
        return res.status(401).json({ error: 'Invalid credentials' });
    }
    
    // Verify password
    const isValid = await bcrypt.compare(password, user.password);
    if (!isValid) {
        return res.status(401).json({ error: 'Invalid credentials' });
    }
    
    // Generate token
    const token = jwt.sign(
        { userId: user.id },
        process.env.JWT_SECRET,
        { expiresIn: '1h' }
    );
    
    res.json({ token, user: { id: user.id, email: user.email } });
});
```

---

## JWT Tokens

### What is JWT?

JWT (JSON Web Token) is a compact, URL-safe token format for securely transmitting information.

### JWT Structure

```
header.payload.signature
```

### Installation

```bash
npm install jsonwebtoken
```

### Creating Tokens

```javascript
const jwt = require('jsonwebtoken');

// Create token
const token = jwt.sign(
    { userId: 123, email: 'user@example.com' },
    process.env.JWT_SECRET,
    { expiresIn: '1h' }
);

// Token with more options
const token = jwt.sign(
    { userId: 123 },
    process.env.JWT_SECRET,
    {
        expiresIn: '24h',
        issuer: 'myapp',
        audience: 'myapp-users'
    }
);
```

### Verifying Tokens

```javascript
const jwt = require('jsonwebtoken');

// Verify token
try {
    const decoded = jwt.verify(token, process.env.JWT_SECRET);
    console.log('Decoded:', decoded);
} catch (error) {
    console.error('Invalid token:', error);
}
```

### JWT Middleware

```javascript
const jwt = require('jsonwebtoken');

const authenticateToken = (req, res, next) => {
    const authHeader = req.headers['authorization'];
    const token = authHeader && authHeader.split(' ')[1]; // Bearer TOKEN
    
    if (!token) {
        return res.status(401).json({ error: 'Access token required' });
    }
    
    jwt.verify(token, process.env.JWT_SECRET, (err, user) => {
        if (err) {
            return res.status(403).json({ error: 'Invalid or expired token' });
        }
        
        req.user = user;
        next();
    });
};

// Use middleware
app.get('/protected', authenticateToken, (req, res) => {
    res.json({ message: 'Protected resource', user: req.user });
});
```

### Refresh Tokens

```javascript
const jwt = require('jsonwebtoken');

// Generate tokens
function generateTokens(user) {
    const accessToken = jwt.sign(
        { userId: user.id },
        process.env.JWT_SECRET,
        { expiresIn: '15m' }
    );
    
    const refreshToken = jwt.sign(
        { userId: user.id },
        process.env.JWT_REFRESH_SECRET,
        { expiresIn: '7d' }
    );
    
    return { accessToken, refreshToken };
}

// Refresh access token
app.post('/refresh', (req, res) => {
    const { refreshToken } = req.body;
    
    if (!refreshToken) {
        return res.status(401).json({ error: 'Refresh token required' });
    }
    
    jwt.verify(refreshToken, process.env.JWT_REFRESH_SECRET, (err, user) => {
        if (err) {
            return res.status(403).json({ error: 'Invalid refresh token' });
        }
        
        const accessToken = jwt.sign(
            { userId: user.userId },
            process.env.JWT_SECRET,
            { expiresIn: '15m' }
        );
        
        res.json({ accessToken });
    });
});
```

---

## Password Hashing (bcrypt)

### Why Hash Passwords?

- **Security**: Passwords should never be stored in plain text
- **Hashing**: One-way function (can't be reversed)
- **Salting**: Adds random data to prevent rainbow table attacks

### Installation

```bash
npm install bcrypt
```

### Hashing Passwords

```javascript
const bcrypt = require('bcrypt');

// Hash password
async function hashPassword(password) {
    const saltRounds = 10;
    const hashedPassword = await bcrypt.hash(password, saltRounds);
    return hashedPassword;
}

// Compare password
async function comparePassword(password, hashedPassword) {
    const isMatch = await bcrypt.compare(password, hashedPassword);
    return isMatch;
}
```

### User Registration

```javascript
const bcrypt = require('bcrypt');
const User = require('../models/user');

app.post('/register', async (req, res) => {
    try {
        const { name, email, password } = req.body;
        
        // Check if user exists
        const existingUser = await User.findOne({ email });
        if (existingUser) {
            return res.status(400).json({ error: 'User already exists' });
        }
        
        // Hash password
        const hashedPassword = await bcrypt.hash(password, 10);
        
        // Create user
        const user = await User.create({
            name,
            email,
            password: hashedPassword
        });
        
        // Generate token
        const token = jwt.sign(
            { userId: user.id },
            process.env.JWT_SECRET,
            { expiresIn: '1h' }
        );
        
        res.status(201).json({
            token,
            user: { id: user.id, name: user.name, email: user.email }
        });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});
```

### User Login

```javascript
const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');
const User = require('../models/user');

app.post('/login', async (req, res) => {
    try {
        const { email, password } = req.body;
        
        // Find user
        const user = await User.findOne({ email });
        if (!user) {
            return res.status(401).json({ error: 'Invalid credentials' });
        }
        
        // Compare password
        const isMatch = await bcrypt.compare(password, user.password);
        if (!isMatch) {
            return res.status(401).json({ error: 'Invalid credentials' });
        }
        
        // Generate token
        const token = jwt.sign(
            { userId: user.id },
            process.env.JWT_SECRET,
            { expiresIn: '1h' }
        );
        
        res.json({
            token,
            user: { id: user.id, name: user.name, email: user.email }
        });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});
```

---

## Session Management

### Express Sessions

```bash
npm install express-session
```

### Session Setup

```javascript
const express = require('express');
const session = require('express-session');
const app = express();

app.use(session({
    secret: process.env.SESSION_SECRET,
    resave: false,
    saveUninitialized: false,
    cookie: {
        secure: process.env.NODE_ENV === 'production',
        httpOnly: true,
        maxAge: 24 * 60 * 60 * 1000 // 24 hours
    }
}));
```

### Using Sessions

```javascript
// Login
app.post('/login', async (req, res) => {
    const { email, password } = req.body;
    
    const user = await User.findOne({ email });
    if (!user) {
        return res.status(401).json({ error: 'Invalid credentials' });
    }
    
    const isMatch = await bcrypt.compare(password, user.password);
    if (!isMatch) {
        return res.status(401).json({ error: 'Invalid credentials' });
    }
    
    // Store in session
    req.session.userId = user.id;
    req.session.email = user.email;
    
    res.json({ message: 'Logged in successfully' });
});

// Protected route
app.get('/profile', (req, res) => {
    if (!req.session.userId) {
        return res.status(401).json({ error: 'Not authenticated' });
    }
    
    res.json({ userId: req.session.userId, email: req.session.email });
});

// Logout
app.post('/logout', (req, res) => {
    req.session.destroy((err) => {
        if (err) {
            return res.status(500).json({ error: 'Logout failed' });
        }
        res.json({ message: 'Logged out successfully' });
    });
});
```

---

## Security Best Practices

### Password Requirements

```javascript
function validatePassword(password) {
    // At least 8 characters
    if (password.length < 8) {
        return { valid: false, error: 'Password must be at least 8 characters' };
    }
    
    // At least one uppercase letter
    if (!/[A-Z]/.test(password)) {
        return { valid: false, error: 'Password must contain uppercase letter' };
    }
    
    // At least one lowercase letter
    if (!/[a-z]/.test(password)) {
        return { valid: false, error: 'Password must contain lowercase letter' };
    }
    
    // At least one number
    if (!/[0-9]/.test(password)) {
        return { valid: false, error: 'Password must contain a number' };
    }
    
    // At least one special character
    if (!/[!@#$%^&*]/.test(password)) {
        return { valid: false, error: 'Password must contain special character' };
    }
    
    return { valid: true };
}
```

### Rate Limiting

```bash
npm install express-rate-limit
```

```javascript
const rateLimit = require('express-rate-limit');

const loginLimiter = rateLimit({
    windowMs: 15 * 60 * 1000, // 15 minutes
    max: 5, // 5 requests per window
    message: 'Too many login attempts, please try again later'
});

app.post('/login', loginLimiter, async (req, res) => {
    // Login logic
});
```

### Input Validation

```javascript
const validator = require('validator');

function validateEmail(email) {
    return validator.isEmail(email);
}

function validatePassword(password) {
    return password.length >= 8;
}

app.post('/register', (req, res) => {
    const { email, password } = req.body;
    
    if (!validateEmail(email)) {
        return res.status(400).json({ error: 'Invalid email' });
    }
    
    if (!validatePassword(password)) {
        return res.status(400).json({ error: 'Invalid password' });
    }
    
    // Continue registration
});
```

### Environment Variables

```javascript
// .env file
JWT_SECRET=your-secret-key-here
JWT_REFRESH_SECRET=your-refresh-secret-here
SESSION_SECRET=your-session-secret-here
NODE_ENV=production

// Use in code
require('dotenv').config();

const token = jwt.sign(
    { userId: user.id },
    process.env.JWT_SECRET
);
```

---

## Practice Exercise

### Exercise: Authentication System

**Objective**: Practice implementing authentication, JWT tokens, password hashing, and session management.

**Instructions**:

1. Create authentication system
2. Implement JWT tokens
3. Hash passwords
4. Add session management
5. Practice:
   - User registration
   - User login
   - Token generation
   - Password hashing
   - Protected routes

**Example Solution**:

```javascript
// src/middleware/auth.js
const jwt = require('jsonwebtoken');

const authenticateToken = (req, res, next) => {
    const authHeader = req.headers['authorization'];
    const token = authHeader && authHeader.split(' ')[1];
    
    if (!token) {
        return res.status(401).json({ error: 'Access token required' });
    }
    
    jwt.verify(token, process.env.JWT_SECRET, (err, user) => {
        if (err) {
            return res.status(403).json({ error: 'Invalid or expired token' });
        }
        req.user = user;
        next();
    });
};

module.exports = authenticateToken;
```

```javascript
// src/routes/auth.js
const express = require('express');
const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');
const User = require('../models/user');
const authenticateToken = require('../middleware/auth');

const router = express.Router();

// Register
router.post('/register', async (req, res) => {
    try {
        const { name, email, password } = req.body;
        
        // Validation
        if (!name || !email || !password) {
            return res.status(400).json({
                error: 'Name, email, and password are required'
            });
        }
        
        if (password.length < 8) {
            return res.status(400).json({
                error: 'Password must be at least 8 characters'
            });
        }
        
        // Check if user exists
        const existingUser = await User.findOne({ email });
        if (existingUser) {
            return res.status(400).json({ error: 'User already exists' });
        }
        
        // Hash password
        const hashedPassword = await bcrypt.hash(password, 10);
        
        // Create user
        const user = await User.create({
            name,
            email,
            password: hashedPassword
        });
        
        // Generate token
        const token = jwt.sign(
            { userId: user._id },
            process.env.JWT_SECRET,
            { expiresIn: '24h' }
        );
        
        res.status(201).json({
            success: true,
            token,
            user: {
                id: user._id,
                name: user.name,
                email: user.email
            }
        });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

// Login
router.post('/login', async (req, res) => {
    try {
        const { email, password } = req.body;
        
        if (!email || !password) {
            return res.status(400).json({
                error: 'Email and password are required'
            });
        }
        
        // Find user
        const user = await User.findOne({ email });
        if (!user) {
            return res.status(401).json({ error: 'Invalid credentials' });
        }
        
        // Compare password
        const isMatch = await bcrypt.compare(password, user.password);
        if (!isMatch) {
            return res.status(401).json({ error: 'Invalid credentials' });
        }
        
        // Generate token
        const token = jwt.sign(
            { userId: user._id },
            process.env.JWT_SECRET,
            { expiresIn: '24h' }
        );
        
        res.json({
            success: true,
            token,
            user: {
                id: user._id,
                name: user.name,
                email: user.email
            }
        });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

// Get current user
router.get('/me', authenticateToken, async (req, res) => {
    try {
        const user = await User.findById(req.user.userId).select('-password');
        if (!user) {
            return res.status(404).json({ error: 'User not found' });
        }
        res.json({ success: true, user });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

module.exports = router;
```

```javascript
// src/models/user.js
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
    password: {
        type: String,
        required: true,
        minlength: 8
    }
}, {
    timestamps: true
});

// Remove password from JSON
userSchema.methods.toJSON = function() {
    const user = this.toObject();
    delete user.password;
    return user;
};

const User = mongoose.model('User', userSchema);

module.exports = User;
```

```javascript
// src/app.js
const express = require('express');
const mongoose = require('mongoose');
const authRouter = require('./routes/auth');
require('dotenv').config();

const app = express();

app.use(express.json());

// Connect to MongoDB
mongoose.connect(process.env.MONGODB_URI || 'mongodb://localhost:27017/mydb')
    .then(() => console.log('Connected to MongoDB'))
    .catch(err => console.error('MongoDB connection error:', err));

// Routes
app.use('/api/auth', authRouter);

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});
```

**Expected Output**:
- User registration working
- User login working
- JWT tokens generated
- Passwords hashed
- Protected routes working

**Challenge (Optional)**:
- Add refresh tokens
- Implement password reset
- Add email verification
- Add two-factor authentication

---

## Common Mistakes

### 1. Storing Plain Text Passwords

```javascript
// ❌ Bad: Plain text password
const user = await User.create({
    email,
    password: password  // Never do this!
});

// ✅ Good: Hash password
const hashedPassword = await bcrypt.hash(password, 10);
const user = await User.create({
    email,
    password: hashedPassword
});
```

### 2. Weak JWT Secret

```javascript
// ❌ Bad: Weak secret
const token = jwt.sign(payload, 'secret');

// ✅ Good: Strong secret from environment
const token = jwt.sign(payload, process.env.JWT_SECRET);
```

### 3. Not Validating Tokens

```javascript
// ❌ Bad: No validation
const decoded = jwt.decode(token);

// ✅ Good: Verify token
const decoded = jwt.verify(token, process.env.JWT_SECRET);
```

---

## Key Takeaways

1. **Authentication**: Verify user identity
2. **JWT Tokens**: Stateless authentication
3. **Password Hashing**: Use bcrypt
4. **Sessions**: Server-side state
5. **Security**: Rate limiting, validation, strong secrets
6. **Best Practice**: Never store plain passwords, use HTTPS
7. **Tokens**: Short-lived access tokens, longer refresh tokens

---

## Quiz: Authentication

Test your understanding with these questions:

1. **Authentication:**
   - A) Verify identity
   - B) Verify permissions
   - C) Both
   - D) Neither

2. **JWT:**
   - A) Stateless
   - B) Stateful
   - C) Both
   - D) Neither

3. **bcrypt:**
   - A) Hash passwords
   - B) Encrypt passwords
   - C) Both
   - D) Neither

4. **Password hashing:**
   - A) One-way
   - B) Two-way
   - C) Both
   - D) Neither

5. **JWT secret:**
   - A) Should be strong
   - B) Can be weak
   - C) Both
   - D) Neither

6. **Sessions:**
   - A) Server-side
   - B) Client-side
   - C) Both
   - D) Neither

7. **Rate limiting:**
   - A) Prevents abuse
   - B) Doesn't prevent abuse
   - C) Both
   - D) Neither

**Answers**:
1. A) Verify identity
2. A) Stateless
3. A) Hash passwords
4. A) One-way
5. A) Should be strong
6. A) Server-side
7. A) Prevents abuse

---

## Next Steps

Congratulations! You've learned authentication and security. You now know:
- How to implement authentication
- How to use JWT tokens
- How to hash passwords
- How to manage sessions

**What's Next?**
- Lesson 30.3: API Security
- Learn CORS
- Understand rate limiting
- Implement input validation

---

## Additional Resources

- **JWT**: [jwt.io](https://jwt.io)
- **bcrypt**: [github.com/kelektiv/node.bcrypt.js](https://github.com/kelektiv/node.bcrypt.js)
- **Express Sessions**: [github.com/expressjs/session](https://github.com/expressjs/session)
- **OWASP**: [owasp.org](https://owasp.org)

---

*Lesson completed! You're ready to move on to the next lesson.*

