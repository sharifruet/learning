# Project 3.2: Full-Stack Application

## Project Overview

Build a complete full-stack application combining the React frontend with the Node.js backend. This project will help you practice connecting frontend and backend, managing authentication across the stack, and building production-ready applications.

## Learning Objectives

By the end of this project, you will be able to:
- Connect React frontend to Node.js backend
- Implement authentication flow
- Manage API calls from frontend
- Handle authentication state
- Build complete full-stack applications
- Deploy full-stack applications
- Handle CORS and security

---

## Project Requirements

### Core Features

1. **User Authentication**: Register, login, logout
2. **Product Management**: View, create, edit, delete products
3. **Protected Routes**: Secure frontend routes
4. **API Integration**: Connect frontend to backend
5. **State Management**: Manage auth and data state
6. **Error Handling**: Handle API errors
7. **Loading States**: Show loading indicators
8. **Responsive Design**: Works on all devices

### Technical Requirements

- React frontend
- Node.js/Express backend
- MongoDB database
- JWT authentication
- Axios for API calls
- Context API for state
- Protected routes

---

## Project Structure

```
fullstack-app/
├── backend/
│   ├── src/
│   │   ├── controllers/
│   │   ├── models/
│   │   ├── routes/
│   │   ├── middleware/
│   │   └── server.js
│   ├── .env
│   └── package.json
├── frontend/
│   ├── src/
│   │   ├── components/
│   │   ├── pages/
│   │   ├── context/
│   │   ├── services/
│   │   └── App.jsx
│   └── package.json
└── README.md
```

---

## Step-by-Step Implementation

### Backend Setup

Use the backend from Project 3.1 or set it up following those instructions.

### Frontend Setup

```bash
# Create React app
npx create-react-app frontend
cd frontend

# Install dependencies
npm install axios react-router-dom

# Start development server
npm start
```

### Frontend API Service

```javascript
// src/services/api.js
import axios from 'axios';

const API_URL = process.env.REACT_APP_API_URL || 'http://localhost:5000/api';

// Create axios instance
const api = axios.create({
    baseURL: API_URL,
    headers: {
        'Content-Type': 'application/json'
    }
});

// Add token to requests
api.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

// Handle response errors
api.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            localStorage.removeItem('token');
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);

// Auth API
export const authAPI = {
    register: (userData) => api.post('/auth/register', userData),
    login: (credentials) => api.post('/auth/login', credentials),
    getMe: () => api.get('/auth/me')
};

// Products API
export const productsAPI = {
    getProducts: (params) => api.get('/products', { params }),
    getProduct: (id) => api.get(`/products/${id}`),
    createProduct: (productData) => api.post('/products', productData),
    updateProduct: (id, productData) => api.put(`/products/${id}`, productData),
    deleteProduct: (id) => api.delete(`/products/${id}`)
};

export default api;
```

### Auth Context

```javascript
// src/context/AuthContext.jsx
import { createContext, useContext, useState, useEffect } from 'react';
import { authAPI } from '../services/api';

const AuthContext = createContext();

export function AuthProvider({ children }) {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);
    const [token, setToken] = useState(localStorage.getItem('token'));
    
    useEffect(() => {
        if (token) {
            loadUser();
        } else {
            setLoading(false);
        }
    }, [token]);
    
    const loadUser = async () => {
        try {
            const response = await authAPI.getMe();
            setUser(response.data.user);
        } catch (error) {
            localStorage.removeItem('token');
            setToken(null);
        } finally {
            setLoading(false);
        }
    };
    
    const register = async (userData) => {
        try {
            const response = await authAPI.register(userData);
            const { token, user } = response.data;
            localStorage.setItem('token', token);
            setToken(token);
            setUser(user);
            return { success: true };
        } catch (error) {
            return {
                success: false,
                error: error.response?.data?.error || 'Registration failed'
            };
        }
    };
    
    const login = async (credentials) => {
        try {
            const response = await authAPI.login(credentials);
            const { token, user } = response.data;
            localStorage.setItem('token', token);
            setToken(token);
            setUser(user);
            return { success: true };
        } catch (error) {
            return {
                success: false,
                error: error.response?.data?.error || 'Login failed'
            };
        }
    };
    
    const logout = () => {
        localStorage.removeItem('token');
        setToken(null);
        setUser(null);
    };
    
    return (
        <AuthContext.Provider
            value={{
                user,
                loading,
                register,
                login,
                logout,
                isAuthenticated: !!user
            }}
        >
            {children}
        </AuthContext.Provider>
    );
}

export function useAuth() {
    const context = useContext(AuthContext);
    if (!context) {
        throw new Error('useAuth must be used within AuthProvider');
    }
    return context;
}
```

### Protected Route Component

```javascript
// src/components/ProtectedRoute.jsx
import { Navigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

function ProtectedRoute({ children }) {
    const { isAuthenticated, loading } = useAuth();
    
    if (loading) {
        return <div>Loading...</div>;
    }
    
    return isAuthenticated ? children : <Navigate to="/login" />;
}

export default ProtectedRoute;
```

### Login Page

```javascript
// src/pages/Login.jsx
import { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import './Login.css';

function Login() {
    const navigate = useNavigate();
    const { login } = useAuth();
    const [formData, setFormData] = useState({
        email: '',
        password: ''
    });
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);
    
    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };
    
    const handleSubmit = async (e) => {
        e.preventDefault();
        setError('');
        setLoading(true);
        
        const result = await login(formData);
        
        if (result.success) {
            navigate('/');
        } else {
            setError(result.error);
        }
        
        setLoading(false);
    };
    
    return (
        <div className="login-page">
            <div className="login-container">
                <h1>Login</h1>
                {error && <div className="error-message">{error}</div>}
                <form onSubmit={handleSubmit}>
                    <div className="form-group">
                        <label>Email</label>
                        <input
                            type="email"
                            name="email"
                            value={formData.email}
                            onChange={handleChange}
                            required
                        />
                    </div>
                    <div className="form-group">
                        <label>Password</label>
                        <input
                            type="password"
                            name="password"
                            value={formData.password}
                            onChange={handleChange}
                            required
                        />
                    </div>
                    <button type="submit" disabled={loading} className="btn btn-primary">
                        {loading ? 'Logging in...' : 'Login'}
                    </button>
                </form>
                <p>
                    Don't have an account? <Link to="/register">Register</Link>
                </p>
            </div>
        </div>
    );
}

export default Login;
```

### Register Page

```javascript
// src/pages/Register.jsx
import { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import './Register.css';

function Register() {
    const navigate = useNavigate();
    const { register } = useAuth();
    const [formData, setFormData] = useState({
        name: '',
        email: '',
        password: ''
    });
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);
    
    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };
    
    const handleSubmit = async (e) => {
        e.preventDefault();
        setError('');
        setLoading(true);
        
        const result = await register(formData);
        
        if (result.success) {
            navigate('/');
        } else {
            setError(result.error);
        }
        
        setLoading(false);
    };
    
    return (
        <div className="register-page">
            <div className="register-container">
                <h1>Register</h1>
                {error && <div className="error-message">{error}</div>}
                <form onSubmit={handleSubmit}>
                    <div className="form-group">
                        <label>Name</label>
                        <input
                            type="text"
                            name="name"
                            value={formData.name}
                            onChange={handleChange}
                            required
                        />
                    </div>
                    <div className="form-group">
                        <label>Email</label>
                        <input
                            type="email"
                            name="email"
                            value={formData.email}
                            onChange={handleChange}
                            required
                        />
                    </div>
                    <div className="form-group">
                        <label>Password</label>
                        <input
                            type="password"
                            name="password"
                            value={formData.password}
                            onChange={handleChange}
                            required
                            minLength="6"
                        />
                    </div>
                    <button type="submit" disabled={loading} className="btn btn-primary">
                        {loading ? 'Registering...' : 'Register'}
                    </button>
                </form>
                <p>
                    Already have an account? <Link to="/login">Login</Link>
                </p>
            </div>
        </div>
    );
}

export default Register;
```

### Products Page

```javascript
// src/pages/Products.jsx
import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { productsAPI } from '../services/api';
import { useAuth } from '../context/AuthContext';
import './Products.css';

function Products() {
    const { isAuthenticated } = useAuth();
    const [products, setProducts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');
    const [filters, setFilters] = useState({
        search: '',
        category: ''
    });
    
    useEffect(() => {
        loadProducts();
    }, [filters]);
    
    const loadProducts = async () => {
        try {
            setLoading(true);
            const response = await productsAPI.getProducts(filters);
            setProducts(response.data.data);
        } catch (error) {
            setError('Failed to load products');
        } finally {
            setLoading(false);
        }
    };
    
    const handleDelete = async (id) => {
        if (window.confirm('Are you sure you want to delete this product?')) {
            try {
                await productsAPI.deleteProduct(id);
                loadProducts();
            } catch (error) {
                alert('Failed to delete product');
            }
        }
    };
    
    if (loading) {
        return <div className="loading">Loading products...</div>;
    }
    
    return (
        <div className="products-page">
            <div className="products-header">
                <h1>Products</h1>
                {isAuthenticated && (
                    <Link to="/products/new" className="btn btn-primary">
                        Add Product
                    </Link>
                )}
            </div>
            
            <div className="filters">
                <input
                    type="text"
                    placeholder="Search products..."
                    value={filters.search}
                    onChange={(e) => setFilters({ ...filters, search: e.target.value })}
                />
                <select
                    value={filters.category}
                    onChange={(e) => setFilters({ ...filters, category: e.target.value })}
                >
                    <option value="">All Categories</option>
                    <option value="Electronics">Electronics</option>
                    <option value="Accessories">Accessories</option>
                </select>
            </div>
            
            {error && <div className="error">{error}</div>}
            
            <div className="products-grid">
                {products.map(product => (
                    <div key={product._id} className="product-card">
                        <Link to={`/products/${product._id}`}>
                            <img src={product.image} alt={product.name} />
                            <h3>{product.name}</h3>
                            <p className="price">${product.price.toFixed(2)}</p>
                        </Link>
                        {isAuthenticated && (
                            <div className="product-actions">
                                <Link
                                    to={`/products/${product._id}/edit`}
                                    className="btn btn-edit"
                                >
                                    Edit
                                </Link>
                                <button
                                    onClick={() => handleDelete(product._id)}
                                    className="btn btn-delete"
                                >
                                    Delete
                                </button>
                            </div>
                        )}
                    </div>
                ))}
            </div>
        </div>
    );
}

export default Products;
```

### Create Product Page

```javascript
// src/pages/CreateProduct.jsx
import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { productsAPI } from '../services/api';
import './CreateProduct.css';

function CreateProduct() {
    const navigate = useNavigate();
    const [formData, setFormData] = useState({
        name: '',
        description: '',
        price: '',
        category: '',
        image: 'https://via.placeholder.com/300',
        inStock: true,
        stock: 0
    });
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);
    
    const handleChange = (e) => {
        const value = e.target.type === 'checkbox' ? e.target.checked : e.target.value;
        setFormData({
            ...formData,
            [e.target.name]: value
        });
    };
    
    const handleSubmit = async (e) => {
        e.preventDefault();
        setError('');
        setLoading(true);
        
        try {
            await productsAPI.createProduct({
                ...formData,
                price: parseFloat(formData.price),
                stock: parseInt(formData.stock)
            });
            navigate('/products');
        } catch (error) {
            setError(error.response?.data?.error || 'Failed to create product');
        } finally {
            setLoading(false);
        }
    };
    
    return (
        <div className="create-product-page">
            <h1>Create Product</h1>
            {error && <div className="error-message">{error}</div>}
            <form onSubmit={handleSubmit} className="product-form">
                <div className="form-group">
                    <label>Name</label>
                    <input
                        type="text"
                        name="name"
                        value={formData.name}
                        onChange={handleChange}
                        required
                    />
                </div>
                <div className="form-group">
                    <label>Description</label>
                    <textarea
                        name="description"
                        value={formData.description}
                        onChange={handleChange}
                        required
                    />
                </div>
                <div className="form-row">
                    <div className="form-group">
                        <label>Price</label>
                        <input
                            type="number"
                            name="price"
                            value={formData.price}
                            onChange={handleChange}
                            step="0.01"
                            min="0"
                            required
                        />
                    </div>
                    <div className="form-group">
                        <label>Category</label>
                        <select
                            name="category"
                            value={formData.category}
                            onChange={handleChange}
                            required
                        >
                            <option value="">Select category</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Accessories">Accessories</option>
                        </select>
                    </div>
                </div>
                <div className="form-group">
                    <label>Image URL</label>
                    <input
                        type="url"
                        name="image"
                        value={formData.image}
                        onChange={handleChange}
                    />
                </div>
                <div className="form-row">
                    <div className="form-group">
                        <label>Stock</label>
                        <input
                            type="number"
                            name="stock"
                            value={formData.stock}
                            onChange={handleChange}
                            min="0"
                        />
                    </div>
                    <div className="form-group">
                        <label>
                            <input
                                type="checkbox"
                                name="inStock"
                                checked={formData.inStock}
                                onChange={handleChange}
                            />
                            In Stock
                        </label>
                    </div>
                </div>
                <div className="form-actions">
                    <button type="submit" disabled={loading} className="btn btn-primary">
                        {loading ? 'Creating...' : 'Create Product'}
                    </button>
                    <button
                        type="button"
                        onClick={() => navigate('/products')}
                        className="btn btn-secondary"
                    >
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    );
}

export default CreateProduct;
```

### App Component with Routes

```javascript
// src/App.jsx
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { AuthProvider } from './context/AuthContext';
import ProtectedRoute from './components/ProtectedRoute';
import Navigation from './components/Navigation';
import Home from './pages/Home';
import Login from './pages/Login';
import Register from './pages/Register';
import Products from './pages/Products';
import ProductDetail from './pages/ProductDetail';
import CreateProduct from './pages/CreateProduct';
import EditProduct from './pages/EditProduct';
import './App.css';

function App() {
    return (
        <AuthProvider>
            <BrowserRouter>
                <Navigation />
                <Routes>
                    <Route path="/" element={<Home />} />
                    <Route path="/login" element={<Login />} />
                    <Route path="/register" element={<Register />} />
                    <Route path="/products" element={<Products />} />
                    <Route path="/products/:id" element={<ProductDetail />} />
                    <Route
                        path="/products/new"
                        element={
                            <ProtectedRoute>
                                <CreateProduct />
                            </ProtectedRoute>
                        }
                    />
                    <Route
                        path="/products/:id/edit"
                        element={
                            <ProtectedRoute>
                                <EditProduct />
                            </ProtectedRoute>
                        }
                    />
                </Routes>
            </BrowserRouter>
        </AuthProvider>
    );
}

export default App;
```

### Navigation Component

```javascript
// src/components/Navigation.jsx
import { Link } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import './Navigation.css';

function Navigation() {
    const { isAuthenticated, user, logout } = useAuth();
    
    return (
        <nav className="navigation">
            <div className="nav-container">
                <Link to="/" className="nav-logo">
                    E-Commerce
                </Link>
                <div className="nav-links">
                    <Link to="/" className="nav-link">Home</Link>
                    <Link to="/products" className="nav-link">Products</Link>
                    {isAuthenticated ? (
                        <>
                            <span className="nav-user">Welcome, {user?.name}</span>
                            <button onClick={logout} className="btn btn-logout">
                                Logout
                            </button>
                        </>
                    ) : (
                        <>
                            <Link to="/login" className="nav-link">Login</Link>
                            <Link to="/register" className="nav-link">Register</Link>
                        </>
                    )}
                </div>
            </div>
        </nav>
    );
}

export default Navigation;
```

---

## Features Implementation

### Frontend-Backend Connection

- **API Service**: Centralized API calls
- **Axios Interceptors**: Automatic token handling
- **Error Handling**: Proper error responses
- **Loading States**: User feedback

### Authentication Flow

- **Register**: Create account, get token
- **Login**: Authenticate, get token
- **Token Storage**: Save in localStorage
- **Protected Routes**: Require authentication
- **Auto-logout**: On token expiration

### State Management

- **Auth Context**: Global auth state
- **API State**: Component-level state
- **Synchronization**: Keep frontend/backend in sync

---

## Testing Your Application

### Manual Testing Checklist

- [ ] Register new user
- [ ] Login with credentials
- [ ] View products
- [ ] Create product (authenticated)
- [ ] Edit product (authenticated)
- [ ] Delete product (authenticated)
- [ ] Logout
- [ ] Access protected routes
- [ ] Test error handling

---

## Exercise: Full-Stack App

**Instructions**:

1. Set up both frontend and backend
2. Connect them together
3. Test all features
4. Deploy application
5. Add enhancements

**Enhancement Ideas**:

- Add order management
- Add shopping cart
- Add user profile page
- Add product reviews
- Add image upload
- Add email notifications
- Add admin dashboard
- Add analytics

---

## Deployment

### Backend Deployment

```bash
# Deploy to Heroku, Railway, or similar
# Set environment variables
# Update CORS settings
```

### Frontend Deployment

```bash
# Build for production
npm run build

# Deploy to Vercel, Netlify, or similar
# Set REACT_APP_API_URL environment variable
```

---

## Common Issues and Solutions

### Issue: CORS errors

**Solution**: Configure CORS in backend to allow frontend origin.

### Issue: Token not sent

**Solution**: Check axios interceptors and localStorage.

### Issue: API calls failing

**Solution**: Verify API URL and backend is running.

---

## Quiz: Full-Stack Concepts

1. **Full-stack app:**
   - A) Frontend + Backend
   - B) Frontend only
   - C) Both
   - D) Neither

2. **Axios:**
   - A) HTTP client
   - B) Database
   - C) Both
   - D) Neither

3. **Context API:**
   - A) Manages global state
   - B) Doesn't manage state
   - C) Both
   - D) Neither

4. **Protected routes:**
   - A) Require authentication
   - B) Don't require authentication
   - C) Both
   - D) Neither

5. **CORS:**
   - A) Cross-origin resource sharing
   - B) Same-origin only
   - C) Both
   - D) Neither

**Answers**:
1. A) Frontend + Backend
2. A) HTTP client
3. A) Manages global state
4. A) Require authentication
5. A) Cross-origin resource sharing

---

## Key Takeaways

1. **Full-Stack**: Combine frontend and backend
2. **API Integration**: Connect React to Express
3. **Authentication**: Manage auth across stack
4. **State Management**: Sync frontend/backend
5. **Best Practice**: Clean architecture, security

---

## Next Steps

Congratulations! You've built a Full-Stack Application. You now know:
- How to connect frontend and backend
- How to implement authentication
- How to manage state
- How to build complete applications

**What's Next?**
- Project 4: Advanced Projects
- Learn WebSockets
- Build real-time applications
- Create advanced features

---

*Project completed! You've finished Project 3: Full-Stack Applications. Ready for Project 4: Advanced Projects!*

