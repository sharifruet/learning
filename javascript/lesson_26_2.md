# Lesson 26.2: React Router

## Learning Objectives

By the end of this lesson, you will be able to:
- Set up React Router
- Create routes and navigation
- Handle route parameters
- Work with nested routes
- Build single-page applications
- Implement navigation
- Handle protected routes

---

## Introduction to React Router

React Router is a library for routing in React applications. It enables navigation without page refreshes.

### What is React Router?

- **Client-Side Routing**: Navigation without page reload
- **Single-Page Application**: One HTML page, multiple views
- **URL-Based Navigation**: URLs reflect current view
- **History API**: Uses browser history API

### Installation

```bash
# Install React Router
npm install react-router-dom
```

---

## Setting Up React Router

### Basic Setup

```javascript
// src/main.jsx or src/index.js
import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom';
import App from './App';

ReactDOM.createRoot(document.getElementById('root')).render(
    <React.StrictMode>
        <BrowserRouter>
            <App />
        </BrowserRouter>
    </React.StrictMode>
);
```

### Router Types

```javascript
// BrowserRouter: Uses HTML5 history API (recommended)
import { BrowserRouter } from 'react-router-dom';

// HashRouter: Uses hash in URL (#)
import { HashRouter } from 'react-router-dom';

// MemoryRouter: Keeps history in memory (testing)
import { MemoryRouter } from 'react-router-dom';
```

---

## Routes and Navigation

### Basic Routes

```javascript
import { Routes, Route } from 'react-router-dom';

function App() {
    return (
        <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/about" element={<About />} />
            <Route path="/contact" element={<Contact />} />
        </Routes>
    );
}
```

### Navigation with Link

```javascript
import { Link } from 'react-router-dom';

function Navigation() {
    return (
        <nav>
            <Link to="/">Home</Link>
            <Link to="/about">About</Link>
            <Link to="/contact">Contact</Link>
        </nav>
    );
}
```

### Navigation with useNavigate

```javascript
import { useNavigate } from 'react-router-dom';

function Button() {
    const navigate = useNavigate();
    
    const handleClick = () => {
        navigate('/about');
    };
    
    return <button onClick={handleClick}>Go to About</button>;
}
```

### Complete Example

```javascript
// src/App.jsx
import { Routes, Route } from 'react-router-dom';
import Navigation from './components/Navigation';
import Home from './pages/Home';
import About from './pages/About';
import Contact from './pages/Contact';

function App() {
    return (
        <div>
            <Navigation />
            <Routes>
                <Route path="/" element={<Home />} />
                <Route path="/about" element={<About />} />
                <Route path="/contact" element={<Contact />} />
            </Routes>
        </div>
    );
}

export default App;
```

```javascript
// src/components/Navigation.jsx
import { Link } from 'react-router-dom';

function Navigation() {
    return (
        <nav>
            <Link to="/">Home</Link>
            <Link to="/about">About</Link>
            <Link to="/contact">Contact</Link>
        </nav>
    );
}

export default Navigation;
```

```javascript
// src/pages/Home.jsx
function Home() {
    return <h1>Home Page</h1>;
}

export default Home;
```

---

## Route Parameters

### Dynamic Routes

```javascript
// Route with parameter
<Route path="/user/:id" element={<UserProfile />} />

// Access parameter
import { useParams } from 'react-router-dom';

function UserProfile() {
    const { id } = useParams();
    return <h1>User ID: {id}</h1>;
}
```

### Multiple Parameters

```javascript
// Multiple parameters
<Route path="/user/:userId/post/:postId" element={<Post />} />

// Access multiple parameters
function Post() {
    const { userId, postId } = useParams();
    return (
        <div>
            <h1>User: {userId}</h1>
            <h2>Post: {postId}</h2>
        </div>
    );
}
```

### Example: User Profile

```javascript
// src/App.jsx
<Route path="/users/:id" element={<UserProfile />} />

// src/pages/UserProfile.jsx
import { useParams } from 'react-router-dom';

function UserProfile() {
    const { id } = useParams();
    const [user, setUser] = useState(null);
    
    useEffect(() => {
        fetch(`/api/users/${id}`)
            .then(res => res.json())
            .then(data => setUser(data));
    }, [id]);
    
    if (!user) return <div>Loading...</div>;
    
    return (
        <div>
            <h1>{user.name}</h1>
            <p>{user.email}</p>
        </div>
    );
}
```

### Optional Parameters

```javascript
// Optional parameter
<Route path="/blog/:slug?" element={<BlogPost />} />

// Access optional parameter
function BlogPost() {
    const { slug } = useParams();
    return <div>{slug ? `Post: ${slug}` : 'All Posts'}</div>;
}
```

---

## Nested Routes

### Basic Nested Routes

```javascript
// Parent route
<Route path="/dashboard" element={<Dashboard />}>
    <Route path="profile" element={<Profile />} />
    <Route path="settings" element={<Settings />} />
</Route>

// Dashboard component with Outlet
import { Outlet, Link } from 'react-router-dom';

function Dashboard() {
    return (
        <div>
            <nav>
                <Link to="/dashboard/profile">Profile</Link>
                <Link to="/dashboard/settings">Settings</Link>
            </nav>
            <Outlet />  {/* Renders child routes */}
        </div>
    );
}
```

### Index Routes

```javascript
// Index route (default child)
<Route path="/dashboard" element={<Dashboard />}>
    <Route index element={<DashboardHome />} />
    <Route path="profile" element={<Profile />} />
    <Route path="settings" element={<Settings />} />
</Route>
```

### Example: Dashboard with Nested Routes

```javascript
// src/App.jsx
import { Routes, Route } from 'react-router-dom';
import Dashboard from './pages/Dashboard';
import DashboardHome from './pages/DashboardHome';
import Profile from './pages/Profile';
import Settings from './pages/Settings';

function App() {
    return (
        <Routes>
            <Route path="/dashboard" element={<Dashboard />}>
                <Route index element={<DashboardHome />} />
                <Route path="profile" element={<Profile />} />
                <Route path="settings" element={<Settings />} />
            </Route>
        </Routes>
    );
}
```

```javascript
// src/pages/Dashboard.jsx
import { Outlet, Link, useLocation } from 'react-router-dom';

function Dashboard() {
    const location = useLocation();
    
    return (
        <div className="dashboard">
            <aside>
                <nav>
                    <Link 
                        to="/dashboard" 
                        className={location.pathname === '/dashboard' ? 'active' : ''}
                    >
                        Home
                    </Link>
                    <Link 
                        to="/dashboard/profile"
                        className={location.pathname === '/dashboard/profile' ? 'active' : ''}
                    >
                        Profile
                    </Link>
                    <Link 
                        to="/dashboard/settings"
                        className={location.pathname === '/dashboard/settings' ? 'active' : ''}
                    >
                        Settings
                    </Link>
                </nav>
            </aside>
            <main>
                <Outlet />
            </main>
        </div>
    );
}

export default Dashboard;
```

---

## Advanced Routing

### Protected Routes

```javascript
// Protected route component
import { Navigate } from 'react-router-dom';

function ProtectedRoute({ children }) {
    const isAuthenticated = localStorage.getItem('user');
    
    if (!isAuthenticated) {
        return <Navigate to="/login" replace />;
    }
    
    return children;
}

// Usage
<Route 
    path="/dashboard" 
    element={
        <ProtectedRoute>
            <Dashboard />
        </ProtectedRoute>
    }
/>
```

### Redirect

```javascript
import { Navigate } from 'react-router-dom';

// Redirect route
<Route path="/old" element={<Navigate to="/new" replace />} />

// Conditional redirect
function Home() {
    const isLoggedIn = localStorage.getItem('user');
    
    if (isLoggedIn) {
        return <Navigate to="/dashboard" replace />;
    }
    
    return <h1>Home</h1>;
}
```

### 404 Not Found

```javascript
// Catch-all route (must be last)
<Route path="*" element={<NotFound />} />

// NotFound component
function NotFound() {
    return (
        <div>
            <h1>404 - Page Not Found</h1>
            <Link to="/">Go Home</Link>
        </div>
    );
}
```

### Query Parameters

```javascript
import { useSearchParams } from 'react-router-dom';

function Search() {
    const [searchParams, setSearchParams] = useSearchParams();
    const query = searchParams.get('q') || '';
    
    const handleSearch = (e) => {
        e.preventDefault();
        setSearchParams({ q: e.target.search.value });
    };
    
    return (
        <form onSubmit={handleSearch}>
            <input name="search" defaultValue={query} />
            <button type="submit">Search</button>
        </form>
    );
}
```

---

## Practice Exercise

### Exercise: Routing

**Objective**: Practice setting up React Router, creating routes, handling parameters, and nested routes.

**Instructions**:

1. Create a React project
2. Install React Router
3. Practice:
   - Setting up routes
   - Navigation
   - Route parameters
   - Nested routes
   - Protected routes

**Example Solution**:

```javascript
// src/App.jsx
import { Routes, Route } from 'react-router-dom';
import Layout from './components/Layout';
import Home from './pages/Home';
import About from './pages/About';
import Contact from './pages/Contact';
import Users from './pages/Users';
import UserProfile from './pages/UserProfile';
import Dashboard from './pages/Dashboard';
import DashboardHome from './pages/DashboardHome';
import Profile from './pages/Profile';
import Settings from './pages/Settings';
import Login from './pages/Login';
import ProtectedRoute from './components/ProtectedRoute';
import NotFound from './pages/NotFound';
import './App.css';

function App() {
    return (
        <Routes>
            <Route path="/" element={<Layout />}>
                <Route index element={<Home />} />
                <Route path="about" element={<About />} />
                <Route path="contact" element={<Contact />} />
                <Route path="users" element={<Users />} />
                <Route path="users/:id" element={<UserProfile />} />
                <Route path="login" element={<Login />} />
                <Route 
                    path="dashboard" 
                    element={
                        <ProtectedRoute>
                            <Dashboard />
                        </ProtectedRoute>
                    }
                >
                    <Route index element={<DashboardHome />} />
                    <Route path="profile" element={<Profile />} />
                    <Route path="settings" element={<Settings />} />
                </Route>
                <Route path="*" element={<NotFound />} />
            </Route>
        </Routes>
    );
}

export default App;
```

```javascript
// src/components/Layout.jsx
import { Outlet, Link, useLocation } from 'react-router-dom';

function Layout() {
    const location = useLocation();
    
    return (
        <div className="layout">
            <header>
                <h1>My App</h1>
                <nav>
                    <Link 
                        to="/" 
                        className={location.pathname === '/' ? 'active' : ''}
                    >
                        Home
                    </Link>
                    <Link 
                        to="/about"
                        className={location.pathname === '/about' ? 'active' : ''}
                    >
                        About
                    </Link>
                    <Link 
                        to="/contact"
                        className={location.pathname === '/contact' ? 'active' : ''}
                    >
                        Contact
                    </Link>
                    <Link 
                        to="/users"
                        className={location.pathname === '/users' ? 'active' : ''}
                    >
                        Users
                    </Link>
                    <Link 
                        to="/dashboard"
                        className={location.pathname.startsWith('/dashboard') ? 'active' : ''}
                    >
                        Dashboard
                    </Link>
                </nav>
            </header>
            <main>
                <Outlet />
            </main>
            <footer>
                <p>&copy; 2024 My App</p>
            </footer>
        </div>
    );
}

export default Layout;
```

```javascript
// src/components/ProtectedRoute.jsx
import { Navigate } from 'react-router-dom';

function ProtectedRoute({ children }) {
    const isAuthenticated = localStorage.getItem('user');
    
    if (!isAuthenticated) {
        return <Navigate to="/login" replace />;
    }
    
    return children;
}

export default ProtectedRoute;
```

```javascript
// src/pages/Home.jsx
function Home() {
    return (
        <div className="page">
            <h1>Home</h1>
            <p>Welcome to the home page!</p>
        </div>
    );
}

export default Home;
```

```javascript
// src/pages/Users.jsx
import { Link } from 'react-router-dom';

function Users() {
    const users = [
        { id: 1, name: 'Alice', email: 'alice@example.com' },
        { id: 2, name: 'Bob', email: 'bob@example.com' },
        { id: 3, name: 'Charlie', email: 'charlie@example.com' }
    ];
    
    return (
        <div className="page">
            <h1>Users</h1>
            <ul className="user-list">
                {users.map(user => (
                    <li key={user.id}>
                        <Link to={`/users/${user.id}`}>
                            {user.name} - {user.email}
                        </Link>
                    </li>
                ))}
            </ul>
        </div>
    );
}

export default Users;
```

```javascript
// src/pages/UserProfile.jsx
import { useParams, Link, useNavigate } from 'react-router-dom';

function UserProfile() {
    const { id } = useParams();
    const navigate = useNavigate();
    
    const users = {
        1: { id: 1, name: 'Alice', email: 'alice@example.com', bio: 'Developer' },
        2: { id: 2, name: 'Bob', email: 'bob@example.com', bio: 'Designer' },
        3: { id: 3, name: 'Charlie', email: 'charlie@example.com', bio: 'Manager' }
    };
    
    const user = users[id];
    
    if (!user) {
        return (
            <div className="page">
                <h1>User Not Found</h1>
                <Link to="/users">Back to Users</Link>
            </div>
        );
    }
    
    return (
        <div className="page">
            <button onClick={() => navigate(-1)}>Back</button>
            <h1>{user.name}</h1>
            <p><strong>Email:</strong> {user.email}</p>
            <p><strong>Bio:</strong> {user.bio}</p>
            <Link to="/users">Back to Users</Link>
        </div>
    );
}

export default UserProfile;
```

```javascript
// src/pages/Dashboard.jsx
import { Outlet, Link, useLocation } from 'react-router-dom';

function Dashboard() {
    const location = useLocation();
    
    return (
        <div className="dashboard">
            <aside className="sidebar">
                <h2>Dashboard</h2>
                <nav>
                    <Link 
                        to="/dashboard"
                        className={location.pathname === '/dashboard' ? 'active' : ''}
                    >
                        Home
                    </Link>
                    <Link 
                        to="/dashboard/profile"
                        className={location.pathname === '/dashboard/profile' ? 'active' : ''}
                    >
                        Profile
                    </Link>
                    <Link 
                        to="/dashboard/settings"
                        className={location.pathname === '/dashboard/settings' ? 'active' : ''}
                    >
                        Settings
                    </Link>
                </nav>
            </aside>
            <main className="dashboard-content">
                <Outlet />
            </main>
        </div>
    );
}

export default Dashboard;
```

```javascript
// src/pages/DashboardHome.jsx
function DashboardHome() {
    return (
        <div>
            <h1>Dashboard Home</h1>
            <p>Welcome to your dashboard!</p>
        </div>
    );
}

export default DashboardHome;
```

```javascript
// src/pages/Login.jsx
import { useNavigate } from 'react-router-dom';

function Login() {
    const navigate = useNavigate();
    
    const handleLogin = (e) => {
        e.preventDefault();
        localStorage.setItem('user', JSON.stringify({ name: 'User', id: 1 }));
        navigate('/dashboard');
    };
    
    return (
        <div className="page">
            <h1>Login</h1>
            <form onSubmit={handleLogin}>
                <input type="text" placeholder="Username" required />
                <input type="password" placeholder="Password" required />
                <button type="submit">Login</button>
            </form>
        </div>
    );
}

export default Login;
```

```javascript
// src/pages/NotFound.jsx
import { Link } from 'react-router-dom';

function NotFound() {
    return (
        <div className="page">
            <h1>404 - Page Not Found</h1>
            <p>The page you're looking for doesn't exist.</p>
            <Link to="/">Go Home</Link>
        </div>
    );
}

export default NotFound;
```

```css
/* src/App.css */
.layout {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

header {
    background-color: #282c34;
    color: white;
    padding: 20px;
}

header nav {
    display: flex;
    gap: 20px;
    margin-top: 10px;
}

header nav a {
    color: white;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 4px;
}

header nav a:hover,
header nav a.active {
    background-color: #61dafb;
    color: #282c34;
}

main {
    flex: 1;
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
}

footer {
    background-color: #282c34;
    color: white;
    padding: 10px;
    text-align: center;
}

.page {
    padding: 20px;
}

.user-list {
    list-style: none;
    padding: 0;
}

.user-list li {
    padding: 10px;
    margin: 5px 0;
    background-color: #f5f5f5;
    border-radius: 4px;
}

.user-list a {
    text-decoration: none;
    color: #007bff;
}

.user-list a:hover {
    text-decoration: underline;
}

.dashboard {
    display: flex;
    min-height: calc(100vh - 200px);
}

.sidebar {
    width: 200px;
    background-color: #f5f5f5;
    padding: 20px;
}

.sidebar nav {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.sidebar nav a {
    padding: 10px;
    text-decoration: none;
    color: #333;
    border-radius: 4px;
}

.sidebar nav a:hover,
.sidebar nav a.active {
    background-color: #007bff;
    color: white;
}

.dashboard-content {
    flex: 1;
    padding: 20px;
}

form {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-width: 300px;
}

form input {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

form button {
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
```

**Expected Output** (in browser):
- Navigation between pages
- User profiles with dynamic routes
- Protected dashboard
- Nested routes in dashboard
- 404 page for unknown routes

**Challenge (Optional)**:
- Build a complete SPA
- Add more routes
- Implement search with query params
- Add breadcrumbs

---

## Common Mistakes

### 1. Forgetting BrowserRouter

```javascript
// ❌ Bad: Missing BrowserRouter
function App() {
    return <Routes>...</Routes>;
}

// ✅ Good: Wrap with BrowserRouter
<BrowserRouter>
    <App />
</BrowserRouter>
```

### 2. Wrong Route Path

```javascript
// ❌ Bad: Absolute path in nested route
<Route path="/dashboard/profile" element={<Profile />} />

// ✅ Good: Relative path
<Route path="profile" element={<Profile />} />
```

### 3. Missing Outlet

```javascript
// ❌ Bad: No Outlet for nested routes
function Dashboard() {
    return <div>Dashboard</div>;
}

// ✅ Good: Include Outlet
function Dashboard() {
    return (
        <div>
            <nav>...</nav>
            <Outlet />
        </div>
    );
}
```

---

## Key Takeaways

1. **React Router**: Client-side routing library
2. **Routes**: Define application routes
3. **Navigation**: Link and useNavigate
4. **Parameters**: Dynamic route parameters
5. **Nested Routes**: Hierarchical routing
6. **Protected Routes**: Authentication-based routing
7. **Best Practice**: Use BrowserRouter, include Outlet, handle 404

---

## Quiz: React Router

Test your understanding with these questions:

1. **React Router:**
   - A) Client-side routing
   - B) Server-side routing
   - C) Both
   - D) Neither

2. **Routes defined:**
   - A) In Routes component
   - B) In Router component
   - C) Both
   - D) Neither

3. **Route parameters:**
   - A) Dynamic values
   - B) Static values
   - C) Both
   - D) Neither

4. **Nested routes:**
   - A) Child routes
   - B) Parent routes
   - C) Both
   - D) Neither

5. **Outlet:**
   - A) Renders child routes
   - B) Renders parent routes
   - C) Both
   - D) Neither

6. **Protected routes:**
   - A) Require authentication
   - B) Public routes
   - C) Both
   - D) Neither

7. **404 route:**
   - A) Catch-all route
   - B) Specific route
   - C) Both
   - D) Neither

**Answers**:
1. A) Client-side routing
2. A) In Routes component
3. A) Dynamic values
4. C) Both (child routes within parent)
5. A) Renders child routes
6. A) Require authentication
7. A) Catch-all route

---

## Next Steps

Congratulations! You've learned React Router. You now know:
- How to set up React Router
- How to create routes
- How to handle navigation
- How to work with nested routes

**What's Next?**
- Lesson 26.3: State Management
- Learn Context API
- Learn Redux basics
- Understand state management patterns

---

## Additional Resources

- **React Router**: [reactrouter.com](https://reactrouter.com)
- **Getting Started**: [reactrouter.com/en/main/start/overview](https://reactrouter.com/en/main/start/overview)
- **API Reference**: [reactrouter.com/en/main/route/route](https://reactrouter.com/en/main/route/route)

---

*Lesson completed! You're ready to move on to the next lesson.*

