# Project 3.1: REST API with Node.js

## Project Overview

Build a complete REST API using Node.js, Express.js, and a database. This project will help you practice backend development, database integration, CRUD operations, and authentication.

## Learning Objectives

By the end of this project, you will be able to:
- Set up Express.js server
- Integrate with databases (MongoDB or MySQL)
- Implement CRUD operations
- Add authentication and authorization
- Handle errors properly
- Structure backend applications
- Test API endpoints

---

## Project Requirements

### Core Features

1. **User Management**: Register, login, get user profile
2. **Product Management**: CRUD operations for products
3. **Authentication**: JWT-based authentication
4. **Authorization**: Protect routes
5. **Error Handling**: Proper error responses
6. **Validation**: Input validation
7. **Database**: Persistent data storage
8. **API Documentation**: Clear API structure

### Technical Requirements

- Node.js and Express.js
- Database (MongoDB with Mongoose or MySQL)
- JWT authentication
- Input validation
- Error handling middleware
- Environment variables
- RESTful API design

---

## Project Setup

```bash
# Create project directory
mkdir rest-api-project
cd rest-api-project

# Initialize npm
npm init -y

# Install dependencies
npm install express mongoose dotenv bcrypt jsonwebtoken express-validator cors
npm install --save-dev nodemon

# Create project structure
mkdir src
mkdir src/controllers
mkdir src/models
mkdir src/routes
mkdir src/middleware
mkdir src/utils
```

---

## Project Structure

```
rest-api-project/
├── src/
│   ├── controllers/
│   │   ├── authController.js
│   │   └── productController.js
│   ├── models/
│   │   ├── User.js
│   │   └── Product.js
│   ├── routes/
│   │   ├── authRoutes.js
│   │   └── productRoutes.js
│   ├── middleware/
│   │   ├── auth.js
│   │   ├── errorHandler.js
│   │   └── validate.js
│   ├── utils/
│   │   └── generateToken.js
│   └── server.js
├── .env
├── .gitignore
└── package.json
```

---

## Step-by-Step Implementation

### Step 1: Package.json Configuration

```json
{
  "name": "rest-api-project",
  "version": "1.0.0",
  "description": "REST API with Node.js and Express",
  "main": "src/server.js",
  "scripts": {
    "start": "node src/server.js",
    "dev": "nodemon src/server.js"
  },
  "keywords": ["api", "rest", "express"],
  "author": "",
  "license": "ISC",
  "dependencies": {
    "express": "^4.18.0",
    "mongoose": "^7.0.0",
    "dotenv": "^16.0.0",
    "bcrypt": "^5.1.0",
    "jsonwebtoken": "^9.0.0",
    "express-validator": "^7.0.0",
    "cors": "^2.8.5"
  },
  "devDependencies": {
    "nodemon": "^2.0.0"
  }
}
```

### Step 2: Environment Variables

```bash
# .env
NODE_ENV=development
PORT=5000
MONGODB_URI=mongodb://localhost:27017/ecommerce
JWT_SECRET=your-super-secret-jwt-key-change-this-in-production
JWT_EXPIRE=7d
```

### Step 3: User Model

```javascript
// src/models/User.js
const mongoose = require('mongoose');
const bcrypt = require('bcrypt');

const userSchema = new mongoose.Schema({
    name: {
        type: String,
        required: [true, 'Please provide a name'],
        trim: true
    },
    email: {
        type: String,
        required: [true, 'Please provide an email'],
        unique: true,
        lowercase: true,
        trim: true,
        match: [/^\S+@\S+\.\S+$/, 'Please provide a valid email']
    },
    password: {
        type: String,
        required: [true, 'Please provide a password'],
        minlength: [6, 'Password must be at least 6 characters'],
        select: false
    },
    role: {
        type: String,
        enum: ['user', 'admin'],
        default: 'user'
    }
}, {
    timestamps: true
});

// Hash password before saving
userSchema.pre('save', async function(next) {
    if (!this.isModified('password')) {
        return next();
    }
    const salt = await bcrypt.genSalt(10);
    this.password = await bcrypt.hash(this.password, salt);
    next();
});

// Compare password method
userSchema.methods.comparePassword = async function(candidatePassword) {
    return await bcrypt.compare(candidatePassword, this.password);
};

module.exports = mongoose.model('User', userSchema);
```

### Step 4: Product Model

```javascript
// src/models/Product.js
const mongoose = require('mongoose');

const productSchema = new mongoose.Schema({
    name: {
        type: String,
        required: [true, 'Please provide a product name'],
        trim: true
    },
    description: {
        type: String,
        required: [true, 'Please provide a description']
    },
    price: {
        type: Number,
        required: [true, 'Please provide a price'],
        min: [0, 'Price must be positive']
    },
    category: {
        type: String,
        required: [true, 'Please provide a category']
    },
    image: {
        type: String,
        default: 'https://via.placeholder.com/300'
    },
    inStock: {
        type: Boolean,
        default: true
    },
    stock: {
        type: Number,
        default: 0,
        min: 0
    },
    createdBy: {
        type: mongoose.Schema.Types.ObjectId,
        ref: 'User',
        required: true
    }
}, {
    timestamps: true
});

module.exports = mongoose.model('Product', productSchema);
```

### Step 5: Generate Token Utility

```javascript
// src/utils/generateToken.js
const jwt = require('jsonwebtoken');

const generateToken = (userId) => {
    return jwt.sign({ userId }, process.env.JWT_SECRET, {
        expiresIn: process.env.JWT_EXPIRE
    });
};

module.exports = generateToken;
```

### Step 6: Authentication Middleware

```javascript
// src/middleware/auth.js
const jwt = require('jsonwebtoken');
const User = require('../models/User');

const protect = async (req, res, next) => {
    let token;
    
    if (req.headers.authorization && req.headers.authorization.startsWith('Bearer')) {
        token = req.headers.authorization.split(' ')[1];
    }
    
    if (!token) {
        return res.status(401).json({
            success: false,
            error: 'Not authorized to access this route'
        });
    }
    
    try {
        const decoded = jwt.verify(token, process.env.JWT_SECRET);
        req.user = await User.findById(decoded.userId).select('-password');
        
        if (!req.user) {
            return res.status(401).json({
                success: false,
                error: 'User not found'
            });
        }
        
        next();
    } catch (error) {
        return res.status(401).json({
            success: false,
            error: 'Not authorized to access this route'
        });
    }
};

const authorize = (...roles) => {
    return (req, res, next) => {
        if (!roles.includes(req.user.role)) {
            return res.status(403).json({
                success: false,
                error: `User role ${req.user.role} is not authorized to access this route`
            });
        }
        next();
    };
};

module.exports = { protect, authorize };
```

### Step 7: Validation Middleware

```javascript
// src/middleware/validate.js
const { validationResult } = require('express-validator');

const validate = (req, res, next) => {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
        return res.status(400).json({
            success: false,
            errors: errors.array()
        });
    }
    next();
};

module.exports = validate;
```

### Step 8: Error Handler Middleware

```javascript
// src/middleware/errorHandler.js
const errorHandler = (err, req, res, next) => {
    let error = { ...err };
    error.message = err.message;
    
    // Log error
    console.error(err);
    
    // Mongoose bad ObjectId
    if (err.name === 'CastError') {
        const message = 'Resource not found';
        error = { message, statusCode: 404 };
    }
    
    // Mongoose duplicate key
    if (err.code === 11000) {
        const message = 'Duplicate field value entered';
        error = { message, statusCode: 400 };
    }
    
    // Mongoose validation error
    if (err.name === 'ValidationError') {
        const message = Object.values(err.errors).map(val => val.message);
        error = { message, statusCode: 400 };
    }
    
    res.status(error.statusCode || 500).json({
        success: false,
        error: error.message || 'Server Error'
    });
};

module.exports = errorHandler;
```

### Step 9: Auth Controller

```javascript
// src/controllers/authController.js
const User = require('../models/User');
const generateToken = require('../utils/generateToken');

// @desc    Register user
// @route   POST /api/auth/register
// @access  Public
exports.register = async (req, res, next) => {
    try {
        const { name, email, password } = req.body;
        
        // Check if user exists
        const userExists = await User.findOne({ email });
        if (userExists) {
            return res.status(400).json({
                success: false,
                error: 'User already exists'
            });
        }
        
        // Create user
        const user = await User.create({
            name,
            email,
            password
        });
        
        // Generate token
        const token = generateToken(user._id);
        
        res.status(201).json({
            success: true,
            token,
            user: {
                id: user._id,
                name: user.name,
                email: user.email,
                role: user.role
            }
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Login user
// @route   POST /api/auth/login
// @access  Public
exports.login = async (req, res, next) => {
    try {
        const { email, password } = req.body;
        
        // Validate email and password
        if (!email || !password) {
            return res.status(400).json({
                success: false,
                error: 'Please provide email and password'
            });
        }
        
        // Check for user
        const user = await User.findOne({ email }).select('+password');
        if (!user) {
            return res.status(401).json({
                success: false,
                error: 'Invalid credentials'
            });
        }
        
        // Check if password matches
        const isMatch = await user.comparePassword(password);
        if (!isMatch) {
            return res.status(401).json({
                success: false,
                error: 'Invalid credentials'
            });
        }
        
        // Generate token
        const token = generateToken(user._id);
        
        res.json({
            success: true,
            token,
            user: {
                id: user._id,
                name: user.name,
                email: user.email,
                role: user.role
            }
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Get current user
// @route   GET /api/auth/me
// @access  Private
exports.getMe = async (req, res, next) => {
    try {
        const user = await User.findById(req.user._id);
        
        res.json({
            success: true,
            user: {
                id: user._id,
                name: user.name,
                email: user.email,
                role: user.role
            }
        });
    } catch (error) {
        next(error);
    }
};
```

### Step 10: Product Controller

```javascript
// src/controllers/productController.js
const Product = require('../models/Product');

// @desc    Get all products
// @route   GET /api/products
// @access  Public
exports.getProducts = async (req, res, next) => {
    try {
        const { category, search, page = 1, limit = 10 } = req.query;
        
        // Build query
        const query = {};
        if (category) {
            query.category = category;
        }
        if (search) {
            query.$or = [
                { name: { $regex: search, $options: 'i' } },
                { description: { $regex: search, $options: 'i' } }
            ];
        }
        
        // Pagination
        const skip = (page - 1) * limit;
        
        const products = await Product.find(query)
            .populate('createdBy', 'name email')
            .skip(skip)
            .limit(parseInt(limit))
            .sort({ createdAt: -1 });
        
        const total = await Product.countDocuments(query);
        
        res.json({
            success: true,
            count: products.length,
            total,
            page: parseInt(page),
            pages: Math.ceil(total / limit),
            data: products
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Get single product
// @route   GET /api/products/:id
// @access  Public
exports.getProduct = async (req, res, next) => {
    try {
        const product = await Product.findById(req.params.id)
            .populate('createdBy', 'name email');
        
        if (!product) {
            return res.status(404).json({
                success: false,
                error: 'Product not found'
            });
        }
        
        res.json({
            success: true,
            data: product
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Create product
// @route   POST /api/products
// @access  Private
exports.createProduct = async (req, res, next) => {
    try {
        req.body.createdBy = req.user._id;
        
        const product = await Product.create(req.body);
        
        res.status(201).json({
            success: true,
            data: product
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Update product
// @route   PUT /api/products/:id
// @access  Private
exports.updateProduct = async (req, res, next) => {
    try {
        let product = await Product.findById(req.params.id);
        
        if (!product) {
            return res.status(404).json({
                success: false,
                error: 'Product not found'
            });
        }
        
        // Make sure user is product owner or admin
        if (product.createdBy.toString() !== req.user._id.toString() && req.user.role !== 'admin') {
            return res.status(403).json({
                success: false,
                error: 'Not authorized to update this product'
            });
        }
        
        product = await Product.findByIdAndUpdate(
            req.params.id,
            req.body,
            {
                new: true,
                runValidators: true
            }
        );
        
        res.json({
            success: true,
            data: product
        });
    } catch (error) {
        next(error);
    }
};

// @desc    Delete product
// @route   DELETE /api/products/:id
// @access  Private
exports.deleteProduct = async (req, res, next) => {
    try {
        const product = await Product.findById(req.params.id);
        
        if (!product) {
            return res.status(404).json({
                success: false,
                error: 'Product not found'
            });
        }
        
        // Make sure user is product owner or admin
        if (product.createdBy.toString() !== req.user._id.toString() && req.user.role !== 'admin') {
            return res.status(403).json({
                success: false,
                error: 'Not authorized to delete this product'
            });
        }
        
        await product.deleteOne();
        
        res.json({
            success: true,
            data: {}
        });
    } catch (error) {
        next(error);
    }
};
```

### Step 11: Auth Routes

```javascript
// src/routes/authRoutes.js
const express = require('express');
const { body } = require('express-validator');
const { register, login, getMe } = require('../controllers/authController');
const { protect } = require('../middleware/auth');
const validate = require('../middleware/validate');

const router = express.Router();

router.post(
    '/register',
    [
        body('name').trim().notEmpty().withMessage('Name is required'),
        body('email').isEmail().withMessage('Please provide a valid email'),
        body('password').isLength({ min: 6 }).withMessage('Password must be at least 6 characters')
    ],
    validate,
    register
);

router.post(
    '/login',
    [
        body('email').isEmail().withMessage('Please provide a valid email'),
        body('password').notEmpty().withMessage('Password is required')
    ],
    validate,
    login
);

router.get('/me', protect, getMe);

module.exports = router;
```

### Step 12: Product Routes

```javascript
// src/routes/productRoutes.js
const express = require('express');
const { body } = require('express-validator');
const {
    getProducts,
    getProduct,
    createProduct,
    updateProduct,
    deleteProduct
} = require('../controllers/productController');
const { protect, authorize } = require('../middleware/auth');
const validate = require('../middleware/validate');

const router = express.Router();

router.get('/', getProducts);
router.get('/:id', getProduct);
router.post(
    '/',
    protect,
    [
        body('name').trim().notEmpty().withMessage('Product name is required'),
        body('description').trim().notEmpty().withMessage('Description is required'),
        body('price').isFloat({ min: 0 }).withMessage('Price must be a positive number'),
        body('category').trim().notEmpty().withMessage('Category is required')
    ],
    validate,
    createProduct
);
router.put(
    '/:id',
    protect,
    [
        body('name').optional().trim().notEmpty().withMessage('Product name cannot be empty'),
        body('price').optional().isFloat({ min: 0 }).withMessage('Price must be a positive number')
    ],
    validate,
    updateProduct
);
router.delete('/:id', protect, deleteProduct);

module.exports = router;
```

### Step 13: Server Setup

```javascript
// src/server.js
const express = require('express');
const mongoose = require('mongoose');
const cors = require('cors');
require('dotenv').config();

const authRoutes = require('./routes/authRoutes');
const productRoutes = require('./routes/productRoutes');
const errorHandler = require('./middleware/errorHandler');

const app = express();

// Middleware
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Routes
app.use('/api/auth', authRoutes);
app.use('/api/products', productRoutes);

// Health check
app.get('/api/health', (req, res) => {
    res.json({
        success: true,
        message: 'API is running'
    });
});

// Error handler (must be last)
app.use(errorHandler);

// Connect to database
mongoose.connect(process.env.MONGODB_URI)
    .then(() => {
        console.log('Connected to MongoDB');
        // Start server
        const PORT = process.env.PORT || 5000;
        app.listen(PORT, () => {
            console.log(`Server running on port ${PORT}`);
        });
    })
    .catch((error) => {
        console.error('MongoDB connection error:', error);
        process.exit(1);
    });
```

---

## API Endpoints

### Authentication

- `POST /api/auth/register` - Register new user
- `POST /api/auth/login` - Login user
- `GET /api/auth/me` - Get current user (Protected)

### Products

- `GET /api/products` - Get all products (with filters)
- `GET /api/products/:id` - Get single product
- `POST /api/products` - Create product (Protected)
- `PUT /api/products/:id` - Update product (Protected)
- `DELETE /api/products/:id` - Delete product (Protected)

---

## Testing Your API

### Using Postman or cURL

```bash
# Register user
curl -X POST http://localhost:5000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","password":"password123"}'

# Login
curl -X POST http://localhost:5000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"password123"}'

# Get products
curl http://localhost:5000/api/products

# Create product (with token)
curl -X POST http://localhost:5000/api/products \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{"name":"Product Name","description":"Description","price":99.99,"category":"Electronics"}'
```

---

## Exercise: REST API

**Instructions**:

1. Set up the project
2. Create all files
3. Test all endpoints
4. Add more features
5. Document the API

**Enhancement Ideas**:

- Add order management
- Add review/rating system
- Add file upload for images
- Add pagination improvements
- Add sorting options
- Add caching
- Add rate limiting
- Add API documentation (Swagger)

---

## Common Issues and Solutions

### Issue: Database connection fails

**Solution**: Check MongoDB is running and connection string is correct.

### Issue: JWT token invalid

**Solution**: Ensure JWT_SECRET is set and token is sent in Authorization header.

### Issue: Validation errors

**Solution**: Check express-validator rules and request body format.

---

## Quiz: Backend API

1. **Express.js:**
   - A) Web framework
   - B) Database
   - C) Both
   - D) Neither

2. **Mongoose:**
   - A) MongoDB ODM
   - B) SQL ORM
   - C) Both
   - D) Neither

3. **JWT:**
   - A) Authentication token
   - B) Database
   - C) Both
   - D) Neither

4. **Middleware:**
   - A) Processes requests
   - B) Doesn't process requests
   - C) Both
   - D) Neither

5. **REST API:**
   - A) Uses HTTP methods
   - B) Doesn't use HTTP methods
   - C) Both
   - D) Neither

**Answers**:
1. A) Web framework
2. A) MongoDB ODM
3. A) Authentication token
4. A) Processes requests
5. A) Uses HTTP methods

---

## Key Takeaways

1. **Express.js**: Fast web framework
2. **Database Integration**: Connect to MongoDB
3. **CRUD Operations**: Create, read, update, delete
4. **Authentication**: JWT-based auth
5. **Best Practice**: Clean structure, error handling

---

## Next Steps

Congratulations! You've built a REST API. You now know:
- How to set up Express.js
- How to integrate databases
- How to implement CRUD operations
- How to add authentication

**What's Next?**
- Project 3.2: Full-Stack Application
- Connect frontend and backend
- Build complete application
- Integrate all components

---

*Project completed! You're ready to move on to the next project.*

