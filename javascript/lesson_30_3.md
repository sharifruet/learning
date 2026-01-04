# Lesson 30.3: API Security

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand and implement CORS
- Use rate limiting
- Validate input
- Prevent SQL injection
- Implement HTTPS
- Secure APIs
- Follow security best practices

---

## Introduction to API Security

API security is crucial for protecting your APIs from attacks and unauthorized access. It involves multiple layers of protection.

### Security Threats

- **SQL Injection**: Malicious SQL code injection
- **XSS (Cross-Site Scripting)**: Script injection attacks
- **CSRF (Cross-Site Request Forgery)**: Unauthorized actions
- **DDoS**: Denial of service attacks
- **Man-in-the-Middle**: Intercepting communications
- **Brute Force**: Password guessing attacks

---

## CORS

### What is CORS?

CORS (Cross-Origin Resource Sharing) is a mechanism that allows resources to be requested from a different domain.

### CORS Setup

```bash
npm install cors
```

```javascript
const express = require('express');
const cors = require('cors');
const app = express();

// Enable CORS for all routes
app.use(cors());

// Or configure CORS
app.use(cors({
    origin: 'https://example.com',
    methods: ['GET', 'POST', 'PUT', 'DELETE'],
    allowedHeaders: ['Content-Type', 'Authorization'],
    credentials: true
}));
```

### CORS Middleware

```javascript
// Custom CORS middleware
const corsMiddleware = (req, res, next) => {
    const allowedOrigins = [
        'https://example.com',
        'https://www.example.com'
    ];
    
    const origin = req.headers.origin;
    
    if (allowedOrigins.includes(origin)) {
        res.header('Access-Control-Allow-Origin', origin);
    }
    
    res.header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
    res.header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    res.header('Access-Control-Allow-Credentials', 'true');
    
    // Handle preflight
    if (req.method === 'OPTIONS') {
        res.sendStatus(200);
    } else {
        next();
    }
};

app.use(corsMiddleware);
```

---

## Rate Limiting

### What is Rate Limiting?

Rate limiting controls how many requests a client can make in a given time period.

### Express Rate Limit

```bash
npm install express-rate-limit
```

```javascript
const rateLimit = require('express-rate-limit');

// General rate limiter
const limiter = rateLimit({
    windowMs: 15 * 60 * 1000, // 15 minutes
    max: 100, // 100 requests per window
    message: 'Too many requests, please try again later'
});

app.use(limiter);

// Specific route limiter
const loginLimiter = rateLimit({
    windowMs: 15 * 60 * 1000,
    max: 5,
    message: 'Too many login attempts, please try again later',
    standardHeaders: true,
    legacyHeaders: false
});

app.post('/login', loginLimiter, (req, res) => {
    // Login logic
});
```

### Advanced Rate Limiting

```javascript
const rateLimit = require('express-rate-limit');

// Store limiter (requires Redis or similar)
const createAccountLimiter = rateLimit({
    windowMs: 60 * 60 * 1000, // 1 hour
    max: 3, // 3 accounts per hour
    message: 'Too many accounts created, please try again later',
    skipSuccessfulRequests: true
});

app.post('/register', createAccountLimiter, (req, res) => {
    // Registration logic
});

// IP-based rate limiting
const ipLimiter = rateLimit({
    windowMs: 15 * 60 * 1000,
    max: 100,
    keyGenerator: (req) => {
        return req.ip;
    }
});
```

---

## Input Validation

### Why Validate Input?

- **Security**: Prevent injection attacks
- **Data Integrity**: Ensure correct data format
- **User Experience**: Provide clear error messages

### Manual Validation

```javascript
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function validatePassword(password) {
    if (password.length < 8) {
        return { valid: false, error: 'Password must be at least 8 characters' };
    }
    if (!/[A-Z]/.test(password)) {
        return { valid: false, error: 'Password must contain uppercase letter' };
    }
    if (!/[a-z]/.test(password)) {
        return { valid: false, error: 'Password must contain lowercase letter' };
    }
    if (!/[0-9]/.test(password)) {
        return { valid: false, error: 'Password must contain a number' };
    }
    return { valid: true };
}

app.post('/register', (req, res) => {
    const { email, password } = req.body;
    
    if (!validateEmail(email)) {
        return res.status(400).json({ error: 'Invalid email' });
    }
    
    const passwordValidation = validatePassword(password);
    if (!passwordValidation.valid) {
        return res.status(400).json({ error: passwordValidation.error });
    }
    
    // Continue registration
});
```

### Using Validator Library

```bash
npm install validator
```

```javascript
const validator = require('validator');

app.post('/register', (req, res) => {
    const { email, password, name } = req.body;
    
    if (!validator.isEmail(email)) {
        return res.status(400).json({ error: 'Invalid email' });
    }
    
    if (!validator.isLength(password, { min: 8 })) {
        return res.status(400).json({ error: 'Password too short' });
    }
    
    if (!validator.isAlphanumeric(name, 'en-US', { ignore: ' ' })) {
        return res.status(400).json({ error: 'Invalid name' });
    }
    
    // Continue registration
});
```

### Using Joi

```bash
npm install joi
```

```javascript
const Joi = require('joi');

const userSchema = Joi.object({
    name: Joi.string().min(3).max(30).required(),
    email: Joi.string().email().required(),
    password: Joi.string().min(8).pattern(new RegExp('^[a-zA-Z0-9]{3,30}$')).required(),
    age: Joi.number().integer().min(0).max(150).optional()
});

app.post('/register', (req, res) => {
    const { error, value } = userSchema.validate(req.body);
    
    if (error) {
        return res.status(400).json({
            error: error.details[0].message
        });
    }
    
    // Use validated value
    // Continue registration
});
```

### Sanitization

```javascript
const validator = require('validator');

function sanitizeInput(input) {
    // Remove HTML tags
    let sanitized = validator.escape(input);
    
    // Trim whitespace
    sanitized = sanitized.trim();
    
    return sanitized;
}

app.post('/comment', (req, res) => {
    const { comment } = req.body;
    const sanitizedComment = sanitizeInput(comment);
    
    // Use sanitized comment
});
```

---

## SQL Injection Prevention

### What is SQL Injection?

SQL injection is a code injection technique that exploits security vulnerabilities in database queries.

### Vulnerable Code

```javascript
// ❌ Bad: SQL injection vulnerability
const query = `SELECT * FROM users WHERE email = '${email}'`;
const [rows] = await pool.execute(query);
```

### Prevention with Parameterized Queries

```javascript
// ✅ Good: Parameterized query
const query = 'SELECT * FROM users WHERE email = ?';
const [rows] = await pool.execute(query, [email]);
```

### Using ORMs

```javascript
// Sequelize (automatically prevents SQL injection)
const user = await User.findOne({
    where: { email: email }
});

// Mongoose (automatically prevents injection)
const user = await User.findOne({ email });
```

### Input Validation

```javascript
function validateEmail(email) {
    // Only allow valid email format
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

app.get('/user', async (req, res) => {
    const { email } = req.query;
    
    if (!validateEmail(email)) {
        return res.status(400).json({ error: 'Invalid email' });
    }
    
    // Safe to use in query
    const user = await User.findOne({ email });
    res.json(user);
});
```

---

## HTTPS

### What is HTTPS?

HTTPS (HTTP Secure) encrypts data between client and server using SSL/TLS.

### Setting Up HTTPS

```bash
# Generate self-signed certificate (development)
openssl req -x509 -newkey rsa:4096 -nodes -keyout key.pem -out cert.pem -days 365
```

```javascript
const https = require('https');
const fs = require('fs');
const express = require('express');

const app = express();

const options = {
    key: fs.readFileSync('key.pem'),
    cert: fs.readFileSync('cert.pem')
};

https.createServer(options, app).listen(443, () => {
    console.log('HTTPS server running on port 443');
});
```

### Redirect HTTP to HTTPS

```javascript
const express = require('express');
const app = express();

// Redirect HTTP to HTTPS
app.use((req, res, next) => {
    if (req.secure || req.headers['x-forwarded-proto'] === 'https') {
        next();
    } else {
        res.redirect(`https://${req.headers.host}${req.url}`);
    }
});
```

### Security Headers

```javascript
const helmet = require('helmet');
app.use(helmet());

// Or manually set headers
app.use((req, res, next) => {
    res.setHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
    res.setHeader('X-Content-Type-Options', 'nosniff');
    res.setHeader('X-Frame-Options', 'DENY');
    res.setHeader('X-XSS-Protection', '1; mode=block');
    next();
});
```

---

## Practice Exercise

### Exercise: Securing APIs

**Objective**: Practice implementing CORS, rate limiting, input validation, SQL injection prevention, and HTTPS.

**Instructions**:

1. Secure your API
2. Implement CORS
3. Add rate limiting
4. Validate input
5. Prevent SQL injection
6. Practice:
   - CORS configuration
   - Rate limiting
   - Input validation
   - Security headers
   - HTTPS setup

**Example Solution**:

```javascript
// src/middleware/security.js
const rateLimit = require('express-rate-limit');
const helmet = require('helmet');

// Security headers
const securityHeaders = helmet({
    contentSecurityPolicy: {
        directives: {
            defaultSrc: ["'self'"],
            styleSrc: ["'self'", "'unsafe-inline'"],
            scriptSrc: ["'self'"],
            imgSrc: ["'self'", 'data:', 'https:']
        }
    },
    hsts: {
        maxAge: 31536000,
        includeSubDomains: true,
        preload: true
    }
});

// Rate limiters
const generalLimiter = rateLimit({
    windowMs: 15 * 60 * 1000, // 15 minutes
    max: 100,
    message: 'Too many requests, please try again later'
});

const authLimiter = rateLimit({
    windowMs: 15 * 60 * 1000,
    max: 5,
    message: 'Too many authentication attempts, please try again later',
    skipSuccessfulRequests: true
});

const createAccountLimiter = rateLimit({
    windowMs: 60 * 60 * 1000, // 1 hour
    max: 3,
    message: 'Too many accounts created, please try again later'
});

module.exports = {
    securityHeaders,
    generalLimiter,
    authLimiter,
    createAccountLimiter
};
```

```javascript
// src/middleware/validation.js
const Joi = require('joi');

const validate = (schema) => {
    return (req, res, next) => {
        const { error, value } = schema.validate(req.body, {
            abortEarly: false,
            stripUnknown: true
        });
        
        if (error) {
            const errors = error.details.map(detail => ({
                field: detail.path.join('.'),
                message: detail.message
            }));
            
            return res.status(400).json({
                success: false,
                errors
            });
        }
        
        req.body = value;
        next();
    };
};

// Validation schemas
const registerSchema = Joi.object({
    name: Joi.string().min(3).max(50).required(),
    email: Joi.string().email().required(),
    password: Joi.string().min(8).pattern(new RegExp('^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])')).required()
});

const loginSchema = Joi.object({
    email: Joi.string().email().required(),
    password: Joi.string().required()
});

module.exports = {
    validate,
    registerSchema,
    loginSchema
};
```

```javascript
// src/middleware/cors.js
const cors = require('cors');

const corsOptions = {
    origin: (origin, callback) => {
        const allowedOrigins = [
            'http://localhost:3000',
            'https://example.com'
        ];
        
        // Allow requests with no origin (mobile apps, Postman, etc.)
        if (!origin) return callback(null, true);
        
        if (allowedOrigins.indexOf(origin) !== -1) {
            callback(null, true);
        } else {
            callback(new Error('Not allowed by CORS'));
        }
    },
    methods: ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
    allowedHeaders: ['Content-Type', 'Authorization'],
    credentials: true,
    maxAge: 86400 // 24 hours
};

module.exports = cors(corsOptions);
```

```javascript
// src/routes/auth.js
const express = require('express');
const router = express.Router();
const { validate, registerSchema, loginSchema } = require('../middleware/validation');
const { authLimiter, createAccountLimiter } = require('../middleware/security');

// Register with validation and rate limiting
router.post('/register',
    createAccountLimiter,
    validate(registerSchema),
    async (req, res) => {
        // Registration logic
    }
);

// Login with validation and rate limiting
router.post('/login',
    authLimiter,
    validate(loginSchema),
    async (req, res) => {
        // Login logic
    }
);

module.exports = router;
```

```javascript
// src/app.js
const express = require('express');
const mongoose = require('mongoose');
const { securityHeaders, generalLimiter } = require('./middleware/security');
const corsOptions = require('./middleware/cors');
const authRouter = require('./routes/auth');
require('dotenv').config();

const app = express();

// Security middleware
app.use(securityHeaders);
app.use(corsOptions);
app.use(express.json({ limit: '10mb' }));
app.use(express.urlencoded({ extended: true, limit: '10mb' }));

// Rate limiting
app.use('/api/', generalLimiter);

// Database connection
mongoose.connect(process.env.MONGODB_URI || 'mongodb://localhost:27017/mydb')
    .then(() => console.log('Connected to MongoDB'))
    .catch(err => console.error('MongoDB connection error:', err));

// Routes
app.use('/api/auth', authRouter);

// Error handling
app.use((err, req, res, next) => {
    console.error(err.stack);
    res.status(500).json({
        success: false,
        error: process.env.NODE_ENV === 'production' 
            ? 'Internal server error' 
            : err.message
    });
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});
```

```json
// package.json
{
  "name": "api-security-practice",
  "version": "1.0.0",
  "description": "API security practice",
  "main": "src/app.js",
  "scripts": {
    "start": "node src/app.js",
    "dev": "nodemon src/app.js"
  },
  "dependencies": {
    "express": "^4.18.0",
    "mongoose": "^7.0.0",
    "cors": "^2.8.5",
    "helmet": "^7.0.0",
    "express-rate-limit": "^6.7.0",
    "joi": "^17.9.0",
    "dotenv": "^16.0.0"
  },
  "devDependencies": {
    "nodemon": "^2.0.0"
  }
}
```

**Expected Output**:
- CORS configured
- Rate limiting active
- Input validation working
- Security headers set
- API secured

**Challenge (Optional)**:
- Add request logging
- Implement API key authentication
- Add IP whitelisting
- Create security monitoring

---

## Common Mistakes

### 1. Not Using Parameterized Queries

```javascript
// ❌ Bad: SQL injection vulnerability
const query = `SELECT * FROM users WHERE email = '${email}'`;

// ✅ Good: Parameterized query
const query = 'SELECT * FROM users WHERE email = ?';
const [rows] = await pool.execute(query, [email]);
```

### 2. Weak CORS Configuration

```javascript
// ❌ Bad: Allow all origins
app.use(cors());

// ✅ Good: Specific origins
app.use(cors({
    origin: ['https://example.com']
}));
```

### 3. No Input Validation

```javascript
// ❌ Bad: No validation
app.post('/user', (req, res) => {
    const user = await User.create(req.body);
});

// ✅ Good: Validate input
app.post('/user', validate(userSchema), (req, res) => {
    const user = await User.create(req.body);
});
```

---

## Key Takeaways

1. **CORS**: Control cross-origin requests
2. **Rate Limiting**: Prevent abuse
3. **Input Validation**: Ensure data integrity
4. **SQL Injection**: Use parameterized queries
5. **HTTPS**: Encrypt communications
6. **Security Headers**: Add extra protection
7. **Best Practice**: Multiple layers of security

---

## Quiz: API Security

Test your understanding with these questions:

1. **CORS:**
   - A) Cross-Origin Resource Sharing
   - B) Cross-Origin Request Sharing
   - C) Both
   - D) Neither

2. **Rate limiting:**
   - A) Prevents abuse
   - B) Allows abuse
   - C) Both
   - D) Neither

3. **SQL injection:**
   - A) Prevented with parameterized queries
   - B) Not prevented
   - C) Both
   - D) Neither

4. **HTTPS:**
   - A) Encrypts data
   - B) Doesn't encrypt data
   - C) Both
   - D) Neither

5. **Input validation:**
   - A) Important for security
   - B) Not important
   - C) Both
   - D) Neither

6. **Security headers:**
   - A) Add protection
   - B) Don't add protection
   - C) Both
   - D) Neither

7. **Parameterized queries:**
   - A) Prevent SQL injection
   - B) Don't prevent SQL injection
   - C) Both
   - D) Neither

**Answers**:
1. A) Cross-Origin Resource Sharing
2. A) Prevents abuse
3. A) Prevented with parameterized queries
4. A) Encrypts data
5. A) Important for security
6. A) Add protection
7. A) Prevent SQL injection

---

## Next Steps

Congratulations! You've completed Module 30: Databases and Authentication. You now know:
- How to work with databases
- How to implement authentication
- How to secure APIs
- How to protect applications

**What's Next?**
- Course 9: Practical Projects
- Build real-world applications
- Apply all learned concepts
- Create portfolio projects

---

## Additional Resources

- **OWASP**: [owasp.org](https://owasp.org)
- **CORS**: [developer.mozilla.org/en-US/docs/Web/HTTP/CORS](https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS)
- **Helmet**: [helmetjs.github.io](https://helmetjs.github.io)
- **Rate Limiting**: [github.com/express-rate-limit/express-rate-limit](https://github.com/express-rate-limit/express-rate-limit)

---

*Lesson completed! You've finished Module 30: Databases and Authentication. Ready for Course 9: Practical Projects!*

