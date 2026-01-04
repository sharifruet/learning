# Project 2.2: React Blog Application

## Project Overview

Build a complete Blog Application using React and React Router. This project will help you practice routing, component architecture, API integration, and building multi-page React applications.

## Learning Objectives

By the end of this project, you will be able to:
- Set up and use React Router
- Create multiple routes and pages
- Build component architecture
- Integrate with APIs
- Handle navigation
- Manage application state
- Create dynamic routes

---

## Project Requirements

### Core Features

1. **Home Page**: Display list of blog posts
2. **Post Detail**: View individual post
3. **Create Post**: Add new blog posts
4. **Edit Post**: Update existing posts
5. **Delete Post**: Remove posts
6. **Navigation**: Navigate between pages
7. **API Integration**: Fetch and post data
8. **Loading States**: Show loading indicators

### Technical Requirements

- Use React Router for navigation
- Component-based architecture
- API integration (JSONPlaceholder or custom)
- Error handling
- Responsive design
- Clean code structure

---

## Project Setup

```bash
# Create React app
npx create-react-app react-blog-app
cd react-blog-app

# Install React Router
npm install react-router-dom

# Start development server
npm start
```

---

## Project Structure

```
react-blog-app/
├── public/
│   └── index.html
├── src/
│   ├── components/
│   │   ├── Layout.jsx
│   │   ├── Navigation.jsx
│   │   ├── PostCard.jsx
│   │   ├── PostForm.jsx
│   │   └── Loading.jsx
│   ├── pages/
│   │   ├── Home.jsx
│   │   ├── PostDetail.jsx
│   │   ├── CreatePost.jsx
│   │   └── EditPost.jsx
│   ├── hooks/
│   │   └── usePosts.js
│   ├── services/
│   │   └── api.js
│   ├── App.jsx
│   ├── App.css
│   └── index.js
└── package.json
```

---

## Step-by-Step Implementation

### Step 1: API Service

```javascript
// src/services/api.js
const API_URL = 'https://jsonplaceholder.typicode.com/posts';

export const api = {
    // Get all posts
    async getPosts() {
        try {
            const response = await fetch(API_URL);
            if (!response.ok) {
                throw new Error('Failed to fetch posts');
            }
            return await response.json();
        } catch (error) {
            throw error;
        }
    },
    
    // Get single post
    async getPost(id) {
        try {
            const response = await fetch(`${API_URL}/${id}`);
            if (!response.ok) {
                throw new Error('Failed to fetch post');
            }
            return await response.json();
        } catch (error) {
            throw error;
        }
    },
    
    // Create post
    async createPost(post) {
        try {
            const response = await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(post),
            });
            if (!response.ok) {
                throw new Error('Failed to create post');
            }
            return await response.json();
        } catch (error) {
            throw error;
        }
    },
    
    // Update post
    async updatePost(id, post) {
        try {
            const response = await fetch(`${API_URL}/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(post),
            });
            if (!response.ok) {
                throw new Error('Failed to update post');
            }
            return await response.json();
        } catch (error) {
            throw error;
        }
    },
    
    // Delete post
    async deletePost(id) {
        try {
            const response = await fetch(`${API_URL}/${id}`, {
                method: 'DELETE',
            });
            if (!response.ok) {
                throw new Error('Failed to delete post');
            }
            return true;
        } catch (error) {
            throw error;
        }
    },
};
```

### Step 2: Custom Hook for Posts

```javascript
// src/hooks/usePosts.js
import { useState, useEffect } from 'react';
import { api } from '../services/api';

export function usePosts() {
    const [posts, setPosts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    
    useEffect(() => {
        loadPosts();
    }, []);
    
    const loadPosts = async () => {
        try {
            setLoading(true);
            setError(null);
            const data = await api.getPosts();
            setPosts(data);
        } catch (err) {
            setError(err.message);
        } finally {
            setLoading(false);
        }
    };
    
    const createPost = async (post) => {
        try {
            const newPost = await api.createPost(post);
            setPosts([newPost, ...posts]);
            return newPost;
        } catch (err) {
            throw err;
        }
    };
    
    const updatePost = async (id, post) => {
        try {
            const updatedPost = await api.updatePost(id, post);
            setPosts(posts.map(p => p.id === id ? updatedPost : p));
            return updatedPost;
        } catch (err) {
            throw err;
        }
    };
    
    const deletePost = async (id) => {
        try {
            await api.deletePost(id);
            setPosts(posts.filter(p => p.id !== id));
        } catch (err) {
            throw err;
        }
    };
    
    return {
        posts,
        loading,
        error,
        createPost,
        updatePost,
        deletePost,
        reloadPosts: loadPosts
    };
}
```

### Step 3: Layout Component

```javascript
// src/components/Layout.jsx
import { Outlet } from 'react-router-dom';
import Navigation from './Navigation';
import './Layout.css';

function Layout() {
    return (
        <div className="layout">
            <Navigation />
            <main className="main-content">
                <Outlet />
            </main>
        </div>
    );
}

export default Layout;
```

### Step 4: Navigation Component

```javascript
// src/components/Navigation.jsx
import { Link, useLocation } from 'react-router-dom';
import './Navigation.css';

function Navigation() {
    const location = useLocation();
    
    const isActive = (path) => {
        return location.pathname === path;
    };
    
    return (
        <nav className="navigation">
            <div className="nav-container">
                <Link to="/" className="nav-logo">
                    My Blog
                </Link>
                <div className="nav-links">
                    <Link
                        to="/"
                        className={`nav-link ${isActive('/') ? 'active' : ''}`}
                    >
                        Home
                    </Link>
                    <Link
                        to="/create"
                        className={`nav-link ${isActive('/create') ? 'active' : ''}`}
                    >
                        Create Post
                    </Link>
                </div>
            </div>
        </nav>
    );
}

export default Navigation;
```

### Step 5: Post Card Component

```javascript
// src/components/PostCard.jsx
import { Link } from 'react-router-dom';
import './PostCard.css';

function PostCard({ post, onDelete }) {
    const handleDelete = async (e) => {
        e.preventDefault();
        if (window.confirm('Are you sure you want to delete this post?')) {
            await onDelete(post.id);
        }
    };
    
    return (
        <div className="post-card">
            <Link to={`/posts/${post.id}`} className="post-link">
                <h2 className="post-title">{post.title}</h2>
                <p className="post-body">{post.body}</p>
            </Link>
            <div className="post-actions">
                <Link to={`/posts/${post.id}/edit`} className="btn btn-edit">
                    Edit
                </Link>
                <button onClick={handleDelete} className="btn btn-delete">
                    Delete
                </button>
            </div>
        </div>
    );
}

export default PostCard;
```

### Step 6: Post Form Component

```javascript
// src/components/PostForm.jsx
import { useState, useEffect } from 'react';
import './PostForm.css';

function PostForm({ post, onSubmit, onCancel }) {
    const [title, setTitle] = useState('');
    const [body, setBody] = useState('');
    const [errors, setErrors] = useState({});
    
    useEffect(() => {
        if (post) {
            setTitle(post.title || '');
            setBody(post.body || '');
        }
    }, [post]);
    
    const validate = () => {
        const newErrors = {};
        if (!title.trim()) {
            newErrors.title = 'Title is required';
        }
        if (!body.trim()) {
            newErrors.body = 'Body is required';
        }
        setErrors(newErrors);
        return Object.keys(newErrors).length === 0;
    };
    
    const handleSubmit = (e) => {
        e.preventDefault();
        if (validate()) {
            onSubmit({ title: title.trim(), body: body.trim() });
        }
    };
    
    return (
        <form className="post-form" onSubmit={handleSubmit}>
            <div className="form-group">
                <label htmlFor="title">Title</label>
                <input
                    type="text"
                    id="title"
                    value={title}
                    onChange={(e) => setTitle(e.target.value)}
                    className={errors.title ? 'error' : ''}
                />
                {errors.title && <span className="error-message">{errors.title}</span>}
            </div>
            
            <div className="form-group">
                <label htmlFor="body">Body</label>
                <textarea
                    id="body"
                    value={body}
                    onChange={(e) => setBody(e.target.value)}
                    rows="10"
                    className={errors.body ? 'error' : ''}
                />
                {errors.body && <span className="error-message">{errors.body}</span>}
            </div>
            
            <div className="form-actions">
                <button type="submit" className="btn btn-primary">
                    {post ? 'Update' : 'Create'} Post
                </button>
                {onCancel && (
                    <button type="button" onClick={onCancel} className="btn btn-secondary">
                        Cancel
                    </button>
                )}
            </div>
        </form>
    );
}

export default PostForm;
```

### Step 7: Loading Component

```javascript
// src/components/Loading.jsx
import './Loading.css';

function Loading() {
    return (
        <div className="loading">
            <div className="spinner"></div>
            <p>Loading...</p>
        </div>
    );
}

export default Loading;
```

### Step 8: Home Page

```javascript
// src/pages/Home.jsx
import { usePosts } from '../hooks/usePosts';
import PostCard from '../components/PostCard';
import Loading from '../components/Loading';
import './Home.css';

function Home() {
    const { posts, loading, error, deletePost } = usePosts();
    
    if (loading) {
        return <Loading />;
    }
    
    if (error) {
        return <div className="error">Error: {error}</div>;
    }
    
    return (
        <div className="home">
            <h1>Blog Posts</h1>
            <div className="posts-grid">
                {posts.map(post => (
                    <PostCard
                        key={post.id}
                        post={post}
                        onDelete={deletePost}
                    />
                ))}
            </div>
        </div>
    );
}

export default Home;
```

### Step 9: Post Detail Page

```javascript
// src/pages/PostDetail.jsx
import { useParams, Link, useNavigate } from 'react-router-dom';
import { useState, useEffect } from 'react';
import { api } from '../services/api';
import Loading from '../components/Loading';
import './PostDetail.css';

function PostDetail() {
    const { id } = useParams();
    const navigate = useNavigate();
    const [post, setPost] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    
    useEffect(() => {
        loadPost();
    }, [id]);
    
    const loadPost = async () => {
        try {
            setLoading(true);
            setError(null);
            const data = await api.getPost(id);
            setPost(data);
        } catch (err) {
            setError(err.message);
        } finally {
            setLoading(false);
        }
    };
    
    const handleDelete = async () => {
        if (window.confirm('Are you sure you want to delete this post?')) {
            try {
                await api.deletePost(id);
                navigate('/');
            } catch (err) {
                alert('Failed to delete post');
            }
        }
    };
    
    if (loading) {
        return <Loading />;
    }
    
    if (error) {
        return <div className="error">Error: {error}</div>;
    }
    
    if (!post) {
        return <div className="error">Post not found</div>;
    }
    
    return (
        <div className="post-detail">
            <Link to="/" className="back-link">← Back to Posts</Link>
            <article className="post">
                <h1>{post.title}</h1>
                <div className="post-meta">
                    <span>Post ID: {post.id}</span>
                </div>
                <div className="post-body">
                    <p>{post.body}</p>
                </div>
                <div className="post-actions">
                    <Link to={`/posts/${post.id}/edit`} className="btn btn-edit">
                        Edit
                    </Link>
                    <button onClick={handleDelete} className="btn btn-delete">
                        Delete
                    </button>
                </div>
            </article>
        </div>
    );
}

export default PostDetail;
```

### Step 10: Create Post Page

```javascript
// src/pages/CreatePost.jsx
import { useNavigate } from 'react-router-dom';
import { usePosts } from '../hooks/usePosts';
import PostForm from '../components/PostForm';
import './CreatePost.css';

function CreatePost() {
    const navigate = useNavigate();
    const { createPost } = usePosts();
    
    const handleSubmit = async (postData) => {
        try {
            await createPost({
                ...postData,
                userId: 1 // Default user ID
            });
            navigate('/');
        } catch (error) {
            alert('Failed to create post');
        }
    };
    
    return (
        <div className="create-post">
            <h1>Create New Post</h1>
            <PostForm onSubmit={handleSubmit} onCancel={() => navigate('/')} />
        </div>
    );
}

export default CreatePost;
```

### Step 11: Edit Post Page

```javascript
// src/pages/EditPost.jsx
import { useParams, useNavigate } from 'react-router-dom';
import { useState, useEffect } from 'react';
import { api } from '../services/api';
import { usePosts } from '../hooks/usePosts';
import PostForm from '../components/PostForm';
import Loading from '../components/Loading';
import './EditPost.css';

function EditPost() {
    const { id } = useParams();
    const navigate = useNavigate();
    const { updatePost } = usePosts();
    const [post, setPost] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    
    useEffect(() => {
        loadPost();
    }, [id]);
    
    const loadPost = async () => {
        try {
            setLoading(true);
            setError(null);
            const data = await api.getPost(id);
            setPost(data);
        } catch (err) {
            setError(err.message);
        } finally {
            setLoading(false);
        }
    };
    
    const handleSubmit = async (postData) => {
        try {
            await updatePost(id, {
                ...postData,
                userId: post.userId,
                id: parseInt(id)
            });
            navigate(`/posts/${id}`);
        } catch (error) {
            alert('Failed to update post');
        }
    };
    
    if (loading) {
        return <Loading />;
    }
    
    if (error) {
        return <div className="error">Error: {error}</div>;
    }
    
    if (!post) {
        return <div className="error">Post not found</div>;
    }
    
    return (
        <div className="edit-post">
            <h1>Edit Post</h1>
            <PostForm post={post} onSubmit={handleSubmit} onCancel={() => navigate(-1)} />
        </div>
    );
}

export default EditPost;
```

### Step 12: App Component with Routes

```javascript
// src/App.jsx
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Layout from './components/Layout';
import Home from './pages/Home';
import PostDetail from './pages/PostDetail';
import CreatePost from './pages/CreatePost';
import EditPost from './pages/EditPost';
import './App.css';

function App() {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/" element={<Layout />}>
                    <Route index element={<Home />} />
                    <Route path="posts/:id" element={<PostDetail />} />
                    <Route path="posts/:id/edit" element={<EditPost />} />
                    <Route path="create" element={<CreatePost />} />
                </Route>
            </Routes>
        </BrowserRouter>
    );
}

export default App;
```

---

## Features Implementation

### React Router

- **BrowserRouter**: Enables routing
- **Routes**: Define route structure
- **Route**: Individual routes
- **Link**: Navigation links
- **useNavigate**: Programmatic navigation
- **useParams**: Access route parameters

### Component Architecture

- **Layout Component**: Shared layout
- **Page Components**: Route-specific pages
- **Reusable Components**: PostCard, PostForm, etc.
- **Separation of Concerns**: Clear component boundaries

### API Integration

- **Service Layer**: API calls in service file
- **Custom Hooks**: usePosts hook for data management
- **Error Handling**: Proper error handling
- **Loading States**: Loading indicators

---

## Testing Your Application

### Manual Testing Checklist

- [ ] Navigate to home page
- [ ] View post details
- [ ] Create new post
- [ ] Edit existing post
- [ ] Delete post
- [ ] Test navigation
- [ ] Test error handling
- [ ] Test loading states

---

## Exercise: Blog App

**Instructions**:

1. Set up React Router
2. Create all components and pages
3. Implement API integration
4. Test all features
5. Customize design

**Enhancement Ideas**:

- Add user authentication
- Add comments system
- Add categories/tags
- Add search functionality
- Add pagination
- Add image upload
- Add markdown support
- Add dark mode

---

## Common Issues and Solutions

### Issue: Routes not working

**Solution**: Ensure BrowserRouter wraps the app and routes are correctly defined.

### Issue: API calls failing

**Solution**: Check API URL and network connectivity. Handle CORS if needed.

### Issue: Navigation not working

**Solution**: Use Link components for navigation, not anchor tags.

---

## Quiz: React Routing

1. **React Router:**
   - A) Enables routing
   - B) Doesn't enable routing
   - C) Both
   - D) Neither

2. **BrowserRouter:**
   - A) Wraps the app
   - B) Doesn't wrap app
   - C) Both
   - D) Neither

3. **useParams:**
   - A) Gets route parameters
   - B) Doesn't get parameters
   - C) Both
   - D) Neither

4. **Link component:**
   - A) Navigates without reload
   - B) Reloads page
   - C) Both
   - D) Neither

5. **Outlet:**
   - A) Renders child routes
   - B) Doesn't render routes
   - C) Both
   - D) Neither

**Answers**:
1. A) Enables routing
2. A) Wraps the app
3. A) Gets route parameters
4. A) Navigates without reload
5. A) Renders child routes

---

## Key Takeaways

1. **React Router**: Essential for multi-page apps
2. **Component Architecture**: Organize components well
3. **API Integration**: Connect to backend services
4. **Navigation**: Smooth user experience
5. **Best Practice**: Clean, maintainable structure

---

## Next Steps

Congratulations! You've built a React Blog Application. You now know:
- How to use React Router
- How to build component architecture
- How to integrate with APIs
- How to create multi-page apps

**What's Next?**
- Project 2.3: E-commerce Frontend
- Learn complex state management
- Build shopping cart
- Create product catalog

---

*Project completed! You're ready to move on to the next project.*

