# Project 2.3: E-commerce Frontend

## Project Overview

Build a complete E-commerce Frontend application with shopping cart, product catalog, and complex state management. This project will help you practice advanced React concepts, state management patterns, and building complex user interfaces.

## Learning Objectives

By the end of this project, you will be able to:
- Manage complex application state
- Implement shopping cart functionality
- Build product catalog with filtering
- Use Context API for global state
- Handle user interactions
- Create responsive e-commerce UI
- Implement cart persistence

---

## Project Requirements

### Core Features

1. **Product Catalog**: Display products with images, prices, descriptions
2. **Product Details**: View individual product information
3. **Shopping Cart**: Add/remove items, update quantities
4. **Cart Persistence**: Save cart to local storage
5. **Filter Products**: Filter by category, price, search
6. **Cart Summary**: Show total, item count
7. **Checkout Page**: Review order before checkout
8. **Responsive Design**: Works on all devices

### Technical Requirements

- Use React with Context API
- Complex state management
- Local storage integration
- Responsive design
- Clean component architecture
- Error handling

---

## Project Setup

```bash
# Create React app
npx create-react-app ecommerce-frontend
cd ecommerce-frontend

# Install dependencies
npm install react-router-dom

# Start development server
npm start
```

---

## Project Structure

```
ecommerce-frontend/
├── public/
│   └── index.html
├── src/
│   ├── components/
│   │   ├── Layout.jsx
│   │   ├── Navigation.jsx
│   │   ├── ProductCard.jsx
│   │   ├── ProductList.jsx
│   │   ├── ProductDetail.jsx
│   │   ├── Cart.jsx
│   │   ├── CartItem.jsx
│   │   ├── FilterBar.jsx
│   │   └── Checkout.jsx
│   ├── context/
│   │   ├── CartContext.jsx
│   │   └── ProductContext.jsx
│   ├── pages/
│   │   ├── Home.jsx
│   │   ├── Products.jsx
│   │   ├── ProductDetailPage.jsx
│   │   └── CheckoutPage.jsx
│   ├── data/
│   │   └── products.js
│   ├── App.jsx
│   ├── App.css
│   └── index.js
└── package.json
```

---

## Step-by-Step Implementation

### Step 1: Products Data

```javascript
// src/data/products.js
export const products = [
    {
        id: 1,
        name: 'Wireless Headphones',
        price: 99.99,
        image: 'https://via.placeholder.com/300',
        category: 'Electronics',
        description: 'High-quality wireless headphones with noise cancellation.',
        inStock: true
    },
    {
        id: 2,
        name: 'Smart Watch',
        price: 199.99,
        image: 'https://via.placeholder.com/300',
        category: 'Electronics',
        description: 'Feature-rich smartwatch with fitness tracking.',
        inStock: true
    },
    {
        id: 3,
        name: 'Laptop Backpack',
        price: 49.99,
        image: 'https://via.placeholder.com/300',
        category: 'Accessories',
        description: 'Durable laptop backpack with multiple compartments.',
        inStock: true
    },
    {
        id: 4,
        name: 'USB-C Cable',
        price: 19.99,
        image: 'https://via.placeholder.com/300',
        category: 'Accessories',
        description: 'Fast charging USB-C cable, 6 feet long.',
        inStock: true
    },
    {
        id: 5,
        name: 'Wireless Mouse',
        price: 29.99,
        image: 'https://via.placeholder.com/300',
        category: 'Electronics',
        description: 'Ergonomic wireless mouse with long battery life.',
        inStock: true
    },
    {
        id: 6,
        name: 'Mechanical Keyboard',
        price: 129.99,
        image: 'https://via.placeholder.com/300',
        category: 'Electronics',
        description: 'RGB mechanical keyboard with customizable keys.',
        inStock: false
    }
];
```

### Step 2: Cart Context

```javascript
// src/context/CartContext.jsx
import { createContext, useContext, useReducer, useEffect } from 'react';

const CartContext = createContext();

const cartReducer = (state, action) => {
    switch (action.type) {
        case 'LOAD_CART':
            return action.payload;
        case 'ADD_ITEM':
            const existingItem = state.items.find(item => item.id === action.payload.id);
            if (existingItem) {
                return {
                    ...state,
                    items: state.items.map(item =>
                        item.id === action.payload.id
                            ? { ...item, quantity: item.quantity + 1 }
                            : item
                    )
                };
            }
            return {
                ...state,
                items: [...state.items, { ...action.payload, quantity: 1 }]
            };
        case 'REMOVE_ITEM':
            return {
                ...state,
                items: state.items.filter(item => item.id !== action.payload)
            };
        case 'UPDATE_QUANTITY':
            return {
                ...state,
                items: state.items.map(item =>
                    item.id === action.payload.id
                        ? { ...item, quantity: action.payload.quantity }
                        : item
                )
            };
        case 'CLEAR_CART':
            return { items: [] };
        default:
            return state;
    }
};

const initialState = { items: [] };

export function CartProvider({ children }) {
    const [state, dispatch] = useReducer(cartReducer, initialState);
    
    // Load cart from localStorage
    useEffect(() => {
        const savedCart = localStorage.getItem('cart');
        if (savedCart) {
            dispatch({ type: 'LOAD_CART', payload: JSON.parse(savedCart) });
        }
    }, []);
    
    // Save cart to localStorage
    useEffect(() => {
        localStorage.setItem('cart', JSON.stringify(state));
    }, [state]);
    
    const addItem = (product) => {
        dispatch({ type: 'ADD_ITEM', payload: product });
    };
    
    const removeItem = (id) => {
        dispatch({ type: 'REMOVE_ITEM', payload: id });
    };
    
    const updateQuantity = (id, quantity) => {
        if (quantity <= 0) {
            removeItem(id);
        } else {
            dispatch({ type: 'UPDATE_QUANTITY', payload: { id, quantity } });
        }
    };
    
    const clearCart = () => {
        dispatch({ type: 'CLEAR_CART' });
    };
    
    const getTotal = () => {
        return state.items.reduce((total, item) => {
            return total + (item.price * item.quantity);
        }, 0);
    };
    
    const getItemCount = () => {
        return state.items.reduce((count, item) => count + item.quantity, 0);
    };
    
    return (
        <CartContext.Provider
            value={{
                items: state.items,
                addItem,
                removeItem,
                updateQuantity,
                clearCart,
                getTotal,
                getItemCount
            }}
        >
            {children}
        </CartContext.Provider>
    );
}

export function useCart() {
    const context = useContext(CartContext);
    if (!context) {
        throw new Error('useCart must be used within CartProvider');
    }
    return context;
}
```

### Step 3: Product Context

```javascript
// src/context/ProductContext.jsx
import { createContext, useContext, useState, useMemo } from 'react';
import { products } from '../data/products';

const ProductContext = createContext();

export function ProductProvider({ children }) {
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedCategory, setSelectedCategory] = useState('All');
    const [priceRange, setPriceRange] = useState([0, 1000]);
    
    const categories = useMemo(() => {
        const cats = ['All', ...new Set(products.map(p => p.category))];
        return cats;
    }, []);
    
    const filteredProducts = useMemo(() => {
        return products.filter(product => {
            const matchesSearch = product.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                                product.description.toLowerCase().includes(searchTerm.toLowerCase());
            const matchesCategory = selectedCategory === 'All' || product.category === selectedCategory;
            const matchesPrice = product.price >= priceRange[0] && product.price <= priceRange[1];
            
            return matchesSearch && matchesCategory && matchesPrice;
        });
    }, [searchTerm, selectedCategory, priceRange]);
    
    return (
        <ProductContext.Provider
            value={{
                products: filteredProducts,
                allProducts: products,
                categories,
                searchTerm,
                setSearchTerm,
                selectedCategory,
                setSelectedCategory,
                priceRange,
                setPriceRange
            }}
        >
            {children}
        </ProductContext.Provider>
    );
}

export function useProducts() {
    const context = useContext(ProductContext);
    if (!context) {
        throw new Error('useProducts must be used within ProductProvider');
    }
    return context;
}
```

### Step 4: Product Card Component

```javascript
// src/components/ProductCard.jsx
import { Link } from 'react-router-dom';
import { useCart } from '../context/CartContext';
import './ProductCard.css';

function ProductCard({ product }) {
    const { addItem } = useCart();
    
    const handleAddToCart = (e) => {
        e.preventDefault();
        addItem(product);
    };
    
    return (
        <div className="product-card">
            <Link to={`/products/${product.id}`} className="product-link">
                <div className="product-image-container">
                    <img src={product.image} alt={product.name} className="product-image" />
                    {!product.inStock && (
                        <div className="out-of-stock">Out of Stock</div>
                    )}
                </div>
                <div className="product-info">
                    <h3 className="product-name">{product.name}</h3>
                    <p className="product-category">{product.category}</p>
                    <p className="product-price">${product.price.toFixed(2)}</p>
                </div>
            </Link>
            <button
                className="add-to-cart-btn"
                onClick={handleAddToCart}
                disabled={!product.inStock}
            >
                {product.inStock ? 'Add to Cart' : 'Out of Stock'}
            </button>
        </div>
    );
}

export default ProductCard;
```

### Step 5: Product List Component

```javascript
// src/components/ProductList.jsx
import ProductCard from './ProductCard';
import './ProductList.css';

function ProductList({ products }) {
    if (products.length === 0) {
        return (
            <div className="no-products">
                <p>No products found. Try adjusting your filters.</p>
            </div>
        );
    }
    
    return (
        <div className="product-list">
            {products.map(product => (
                <ProductCard key={product.id} product={product} />
            ))}
        </div>
    );
}

export default ProductList;
```

### Step 6: Filter Bar Component

```javascript
// src/components/FilterBar.jsx
import { useProducts } from '../context/ProductContext';
import './FilterBar.css';

function FilterBar() {
    const {
        searchTerm,
        setSearchTerm,
        selectedCategory,
        setSelectedCategory,
        categories,
        priceRange,
        setPriceRange
    } = useProducts();
    
    return (
        <div className="filter-bar">
            <div className="filter-group">
                <label>Search</label>
                <input
                    type="text"
                    placeholder="Search products..."
                    value={searchTerm}
                    onChange={(e) => setSearchTerm(e.target.value)}
                    className="search-input"
                />
            </div>
            
            <div className="filter-group">
                <label>Category</label>
                <select
                    value={selectedCategory}
                    onChange={(e) => setSelectedCategory(e.target.value)}
                    className="category-select"
                >
                    {categories.map(category => (
                        <option key={category} value={category}>
                            {category}
                        </option>
                    ))}
                </select>
            </div>
            
            <div className="filter-group">
                <label>Price Range: ${priceRange[0]} - ${priceRange[1]}</label>
                <input
                    type="range"
                    min="0"
                    max="1000"
                    value={priceRange[1]}
                    onChange={(e) => setPriceRange([priceRange[0], parseInt(e.target.value)])}
                    className="price-range"
                />
            </div>
        </div>
    );
}

export default FilterBar;
```

### Step 7: Cart Item Component

```javascript
// src/components/CartItem.jsx
import { useCart } from '../context/CartContext';
import './CartItem.css';

function CartItem({ item }) {
    const { removeItem, updateQuantity } = useCart();
    
    return (
        <div className="cart-item">
            <img src={item.image} alt={item.name} className="cart-item-image" />
            <div className="cart-item-info">
                <h4>{item.name}</h4>
                <p className="cart-item-price">${item.price.toFixed(2)}</p>
            </div>
            <div className="cart-item-actions">
                <div className="quantity-controls">
                    <button onClick={() => updateQuantity(item.id, item.quantity - 1)}>
                        −
                    </button>
                    <span>{item.quantity}</span>
                    <button onClick={() => updateQuantity(item.id, item.quantity + 1)}>
                        +
                    </button>
                </div>
                <button
                    className="remove-btn"
                    onClick={() => removeItem(item.id)}
                >
                    Remove
                </button>
            </div>
            <div className="cart-item-total">
                ${(item.price * item.quantity).toFixed(2)}
            </div>
        </div>
    );
}

export default CartItem;
```

### Step 8: Cart Component

```javascript
// src/components/Cart.jsx
import { useCart } from '../context/CartContext';
import CartItem from './CartItem';
import { Link } from 'react-router-dom';
import './Cart.css';

function Cart() {
    const { items, getTotal, clearCart } = useCart();
    
    if (items.length === 0) {
        return (
            <div className="cart-empty">
                <p>Your cart is empty</p>
                <Link to="/products" className="btn btn-primary">
                    Continue Shopping
                </Link>
            </div>
        );
    }
    
    return (
        <div className="cart">
            <div className="cart-header">
                <h2>Shopping Cart</h2>
                <button onClick={clearCart} className="clear-cart-btn">
                    Clear Cart
                </button>
            </div>
            
            <div className="cart-items">
                {items.map(item => (
                    <CartItem key={item.id} item={item} />
                ))}
            </div>
            
            <div className="cart-summary">
                <div className="cart-total">
                    <h3>Total: ${getTotal().toFixed(2)}</h3>
                </div>
                <Link to="/checkout" className="btn btn-checkout">
                    Proceed to Checkout
                </Link>
            </div>
        </div>
    );
}

export default Cart;
```

### Step 9: Checkout Component

```javascript
// src/components/Checkout.jsx
import { useState } from 'react';
import { useCart } from '../context/CartContext';
import { useNavigate } from 'react-router-dom';
import './Checkout.css';

function Checkout() {
    const { items, getTotal, clearCart } = useCart();
    const navigate = useNavigate();
    const [formData, setFormData] = useState({
        name: '',
        email: '',
        address: '',
        city: '',
        zip: '',
        cardNumber: '',
        expiryDate: '',
        cvv: ''
    });
    const [errors, setErrors] = useState({});
    
    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };
    
    const validate = () => {
        const newErrors = {};
        if (!formData.name.trim()) newErrors.name = 'Name is required';
        if (!formData.email.trim()) newErrors.email = 'Email is required';
        if (!formData.address.trim()) newErrors.address = 'Address is required';
        if (!formData.city.trim()) newErrors.city = 'City is required';
        if (!formData.zip.trim()) newErrors.zip = 'ZIP code is required';
        if (!formData.cardNumber.trim()) newErrors.cardNumber = 'Card number is required';
        if (!formData.expiryDate.trim()) newErrors.expiryDate = 'Expiry date is required';
        if (!formData.cvv.trim()) newErrors.cvv = 'CVV is required';
        
        setErrors(newErrors);
        return Object.keys(newErrors).length === 0;
    };
    
    const handleSubmit = (e) => {
        e.preventDefault();
        if (validate()) {
            // In a real app, this would send data to backend
            alert('Order placed successfully!');
            clearCart();
            navigate('/');
        }
    };
    
    return (
        <div className="checkout">
            <h1>Checkout</h1>
            <div className="checkout-content">
                <div className="checkout-form-container">
                    <form className="checkout-form" onSubmit={handleSubmit}>
                        <h2>Shipping Information</h2>
                        <div className="form-group">
                            <label>Full Name</label>
                            <input
                                type="text"
                                name="name"
                                value={formData.name}
                                onChange={handleChange}
                                className={errors.name ? 'error' : ''}
                            />
                            {errors.name && <span className="error-message">{errors.name}</span>}
                        </div>
                        
                        <div className="form-group">
                            <label>Email</label>
                            <input
                                type="email"
                                name="email"
                                value={formData.email}
                                onChange={handleChange}
                                className={errors.email ? 'error' : ''}
                            />
                            {errors.email && <span className="error-message">{errors.email}</span>}
                        </div>
                        
                        <div className="form-group">
                            <label>Address</label>
                            <input
                                type="text"
                                name="address"
                                value={formData.address}
                                onChange={handleChange}
                                className={errors.address ? 'error' : ''}
                            />
                            {errors.address && <span className="error-message">{errors.address}</span>}
                        </div>
                        
                        <div className="form-row">
                            <div className="form-group">
                                <label>City</label>
                                <input
                                    type="text"
                                    name="city"
                                    value={formData.city}
                                    onChange={handleChange}
                                    className={errors.city ? 'error' : ''}
                                />
                                {errors.city && <span className="error-message">{errors.city}</span>}
                            </div>
                            
                            <div className="form-group">
                                <label>ZIP Code</label>
                                <input
                                    type="text"
                                    name="zip"
                                    value={formData.zip}
                                    onChange={handleChange}
                                    className={errors.zip ? 'error' : ''}
                                />
                                {errors.zip && <span className="error-message">{errors.zip}</span>}
                            </div>
                        </div>
                        
                        <h2>Payment Information</h2>
                        <div className="form-group">
                            <label>Card Number</label>
                            <input
                                type="text"
                                name="cardNumber"
                                value={formData.cardNumber}
                                onChange={handleChange}
                                placeholder="1234 5678 9012 3456"
                                className={errors.cardNumber ? 'error' : ''}
                            />
                            {errors.cardNumber && <span className="error-message">{errors.cardNumber}</span>}
                        </div>
                        
                        <div className="form-row">
                            <div className="form-group">
                                <label>Expiry Date</label>
                                <input
                                    type="text"
                                    name="expiryDate"
                                    value={formData.expiryDate}
                                    onChange={handleChange}
                                    placeholder="MM/YY"
                                    className={errors.expiryDate ? 'error' : ''}
                                />
                                {errors.expiryDate && <span className="error-message">{errors.expiryDate}</span>}
                            </div>
                            
                            <div className="form-group">
                                <label>CVV</label>
                                <input
                                    type="text"
                                    name="cvv"
                                    value={formData.cvv}
                                    onChange={handleChange}
                                    placeholder="123"
                                    className={errors.cvv ? 'error' : ''}
                                />
                                {errors.cvv && <span className="error-message">{errors.cvv}</span>}
                            </div>
                        </div>
                        
                        <button type="submit" className="btn btn-submit">
                            Place Order
                        </button>
                    </form>
                </div>
                
                <div className="order-summary">
                    <h2>Order Summary</h2>
                    <div className="summary-items">
                        {items.map(item => (
                            <div key={item.id} className="summary-item">
                                <span>{item.name} x{item.quantity}</span>
                                <span>${(item.price * item.quantity).toFixed(2)}</span>
                            </div>
                        ))}
                    </div>
                    <div className="summary-total">
                        <h3>Total: ${getTotal().toFixed(2)}</h3>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Checkout;
```

### Step 10: Navigation Component

```javascript
// src/components/Navigation.jsx
import { Link } from 'react-router-dom';
import { useCart } from '../context/CartContext';
import './Navigation.css';

function Navigation() {
    const { getItemCount } = useCart();
    const itemCount = getItemCount();
    
    return (
        <nav className="navigation">
            <div className="nav-container">
                <Link to="/" className="nav-logo">
                    E-Commerce
                </Link>
                <div className="nav-links">
                    <Link to="/" className="nav-link">Home</Link>
                    <Link to="/products" className="nav-link">Products</Link>
                    <Link to="/cart" className="nav-link cart-link">
                        Cart
                        {itemCount > 0 && <span className="cart-badge">{itemCount}</span>}
                    </Link>
                </div>
            </div>
        </nav>
    );
}

export default Navigation;
```

### Step 11: Pages

```javascript
// src/pages/Home.jsx
import { Link } from 'react-router-dom';
import './Home.css';

function Home() {
    return (
        <div className="home">
            <div className="hero">
                <h1>Welcome to Our Store</h1>
                <p>Discover amazing products at great prices</p>
                <Link to="/products" className="btn btn-primary">
                    Shop Now
                </Link>
            </div>
        </div>
    );
}

export default Home;
```

```javascript
// src/pages/Products.jsx
import { useProducts } from '../context/ProductContext';
import FilterBar from '../components/FilterBar';
import ProductList from '../components/ProductList';
import './Products.css';

function Products() {
    const { products } = useProducts();
    
    return (
        <div className="products-page">
            <h1>Products</h1>
            <FilterBar />
            <ProductList products={products} />
        </div>
    );
}

export default Products;
```

```javascript
// src/pages/ProductDetailPage.jsx
import { useParams, useNavigate } from 'react-router-dom';
import { useProducts } from '../context/ProductContext';
import { useCart } from '../context/CartContext';
import './ProductDetailPage.css';

function ProductDetailPage() {
    const { id } = useParams();
    const navigate = useNavigate();
    const { allProducts } = useProducts();
    const { addItem } = useCart();
    
    const product = allProducts.find(p => p.id === parseInt(id));
    
    if (!product) {
        return <div>Product not found</div>;
    }
    
    const handleAddToCart = () => {
        addItem(product);
        navigate('/cart');
    };
    
    return (
        <div className="product-detail-page">
            <button onClick={() => navigate(-1)} className="back-btn">
                ← Back
            </button>
            <div className="product-detail">
                <div className="product-detail-image">
                    <img src={product.image} alt={product.name} />
                </div>
                <div className="product-detail-info">
                    <h1>{product.name}</h1>
                    <p className="product-category">{product.category}</p>
                    <p className="product-price">${product.price.toFixed(2)}</p>
                    <p className="product-description">{product.description}</p>
                    <div className="product-status">
                        {product.inStock ? (
                            <span className="in-stock">In Stock</span>
                        ) : (
                            <span className="out-of-stock">Out of Stock</span>
                        )}
                    </div>
                    <button
                        className="btn btn-primary add-to-cart-detail"
                        onClick={handleAddToCart}
                        disabled={!product.inStock}
                    >
                        {product.inStock ? 'Add to Cart' : 'Out of Stock'}
                    </button>
                </div>
            </div>
        </div>
    );
}

export default ProductDetailPage;
```

```javascript
// src/pages/CheckoutPage.jsx
import Checkout from '../components/Checkout';
import './CheckoutPage.css';

function CheckoutPage() {
    return (
        <div className="checkout-page">
            <Checkout />
        </div>
    );
}

export default CheckoutPage;
```

### Step 12: App Component

```javascript
// src/App.jsx
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { CartProvider } from './context/CartContext';
import { ProductProvider } from './context/ProductContext';
import Layout from './components/Layout';
import Home from './pages/Home';
import Products from './pages/Products';
import ProductDetailPage from './pages/ProductDetailPage';
import Cart from './components/Cart';
import CheckoutPage from './pages/CheckoutPage';
import './App.css';

function App() {
    return (
        <CartProvider>
            <ProductProvider>
                <BrowserRouter>
                    <Routes>
                        <Route path="/" element={<Layout />}>
                            <Route index element={<Home />} />
                            <Route path="products" element={<Products />} />
                            <Route path="products/:id" element={<ProductDetailPage />} />
                            <Route path="cart" element={<Cart />} />
                            <Route path="checkout" element={<CheckoutPage />} />
                        </Route>
                    </Routes>
                </BrowserRouter>
            </ProductProvider>
        </CartProvider>
    );
}

export default App;
```

---

## Features Implementation

### Complex State Management

- **Context API**: Global state for cart and products
- **useReducer**: Complex cart state management
- **Local Storage**: Persist cart data
- **State Updates**: Efficient state updates

### Shopping Cart

- **Add Items**: Add products to cart
- **Remove Items**: Remove from cart
- **Update Quantities**: Change item quantities
- **Calculate Totals**: Automatic total calculation
- **Persist Cart**: Save to local storage

### Product Catalog

- **Display Products**: Show all products
- **Filtering**: Filter by category, price, search
- **Product Details**: Individual product pages
- **Responsive Grid**: Product grid layout

---

## Testing Your Application

### Manual Testing Checklist

- [ ] View product catalog
- [ ] Filter products
- [ ] View product details
- [ ] Add items to cart
- [ ] Update cart quantities
- [ ] Remove items from cart
- [ ] View cart
- [ ] Proceed to checkout
- [ ] Complete checkout form
- [ ] Test cart persistence

---

## Exercise: E-commerce Frontend

**Instructions**:

1. Set up React project
2. Create all components and contexts
3. Implement all features
4. Test thoroughly
5. Customize design

**Enhancement Ideas**:

- Add user authentication
- Add product reviews
- Add wishlist functionality
- Add product recommendations
- Add order history
- Add payment integration
- Add shipping calculator
- Add product images gallery

---

## Common Issues and Solutions

### Issue: Cart not persisting

**Solution**: Check localStorage implementation in CartContext.

### Issue: State not updating

**Solution**: Ensure Context providers wrap components correctly.

### Issue: Filters not working

**Solution**: Check useMemo dependencies in ProductContext.

---

## Quiz: Complex React App

1. **Context API:**
   - A) Manages global state
   - B) Doesn't manage state
   - C) Both
   - D) Neither

2. **useReducer:**
   - A) Complex state management
   - B) Simple state management
   - C) Both
   - D) Neither

3. **Shopping cart:**
   - A) Complex state
   - B) Simple state
   - C) Both
   - D) Neither

4. **Local storage:**
   - A) Persists data
   - B) Temporary data
   - C) Both
   - D) Neither

5. **Product filtering:**
   - A) Uses useMemo
   - B) Doesn't use useMemo
   - C) Both
   - D) Neither

**Answers**:
1. A) Manages global state
2. A) Complex state management
3. A) Complex state
4. A) Persists data
5. A) Uses useMemo (for optimization)

---

## Key Takeaways

1. **Complex State**: Use Context API and useReducer
2. **Shopping Cart**: Implement cart functionality
3. **Product Catalog**: Build filtering and display
4. **State Management**: Efficient state updates
5. **Best Practice**: Clean architecture and separation

---

## Next Steps

Congratulations! You've built an E-commerce Frontend. You now know:
- How to manage complex state
- How to implement shopping cart
- How to build product catalog
- How to create complex React apps

**What's Next?**
- Project 3: Full-Stack Applications
- Learn backend development
- Build REST APIs
- Create full-stack applications

---

*Project completed! You've finished Project 2: Frontend Applications. Ready for Project 3: Full-Stack Applications!*

