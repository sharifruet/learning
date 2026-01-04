# Project 4.2: Social Media Clone

## Project Overview

Build a Social Media Clone application with complex state management, image uploads, and user interactions. This project will help you practice advanced React concepts, file handling, and building complex user interfaces.

## Learning Objectives

By the end of this project, you will be able to:
- Manage complex application state
- Handle image uploads
- Implement user interactions (like, comment, share)
- Build feed systems
- Create user profiles
- Handle real-time updates
- Optimize performance

---

## Project Requirements

### Core Features

1. **User Profiles**: View and edit profiles
2. **Posts**: Create, view, edit, delete posts
3. **Feed**: Display posts in chronological order
4. **Image Upload**: Upload and display images
5. **Interactions**: Like, comment on posts
6. **Follow System**: Follow/unfollow users
7. **Notifications**: Show user notifications
8. **Search**: Search users and posts

### Technical Requirements

- React with Context API or Redux
- Image upload handling
- Complex state management
- API integration
- Responsive design
- Performance optimization

---

## Project Setup

```bash
# Create React app
npx create-react-app social-media-app
cd social-media-app

# Install dependencies
npm install axios react-router-dom
npm install react-dropzone  # For image uploads
npm install date-fns  # For date formatting

# Start development server
npm start
```

---

## Project Structure

```
social-media-app/
├── src/
│   ├── components/
│   │   ├── Layout.jsx
│   │   ├── Navigation.jsx
│   │   ├── PostCard.jsx
│   │   ├── PostForm.jsx
│   │   ├── CommentSection.jsx
│   │   ├── UserProfile.jsx
│   │   ├── Feed.jsx
│   │   └── ImageUpload.jsx
│   ├── context/
│   │   ├── AuthContext.jsx
│   │   └── PostContext.jsx
│   ├── pages/
│   │   ├── Home.jsx
│   │   ├── Profile.jsx
│   │   └── Explore.jsx
│   ├── services/
│   │   └── api.js
│   ├── utils/
│   │   └── imageUtils.js
│   ├── App.jsx
│   └── index.js
└── package.json
```

---

## Step-by-Step Implementation

### Image Upload Component

```javascript
// src/components/ImageUpload.jsx
import { useState, useCallback } from 'react';
import { useDropzone } from 'react-dropzone';
import './ImageUpload.css';

function ImageUpload({ onImageSelect, maxSize = 5 * 1024 * 1024 }) {
    const [preview, setPreview] = useState(null);
    const [error, setError] = useState('');
    
    const onDrop = useCallback((acceptedFiles, rejectedFiles) => {
        setError('');
        
        if (rejectedFiles.length > 0) {
            setError('File is too large or invalid format');
            return;
        }
        
        const file = acceptedFiles[0];
        if (file.size > maxSize) {
            setError('File size exceeds 5MB');
            return;
        }
        
        // Create preview
        const reader = new FileReader();
        reader.onload = () => {
            setPreview(reader.result);
            onImageSelect(file);
        };
        reader.readAsDataURL(file);
    }, [onImageSelect, maxSize]);
    
    const { getRootProps, getInputProps, isDragActive } = useDropzone({
        onDrop,
        accept: {
            'image/*': ['.jpeg', '.jpg', '.png', '.gif']
        },
        maxFiles: 1,
        maxSize: maxSize
    });
    
    const handleRemove = () => {
        setPreview(null);
        onImageSelect(null);
    };
    
    return (
        <div className="image-upload">
            {preview ? (
                <div className="image-preview">
                    <img src={preview} alt="Preview" />
                    <button onClick={handleRemove} className="btn-remove">
                        Remove
                    </button>
                </div>
            ) : (
                <div
                    {...getRootProps()}
                    className={`dropzone ${isDragActive ? 'active' : ''}`}
                >
                    <input {...getInputProps()} />
                    <p>Drag & drop an image, or click to select</p>
                    <p className="dropzone-hint">Max size: 5MB</p>
                </div>
            )}
            {error && <div className="error-message">{error}</div>}
        </div>
    );
}

export default ImageUpload;
```

### Post Context

```javascript
// src/context/PostContext.jsx
import { createContext, useContext, useReducer, useEffect } from 'react';
import { postsAPI } from '../services/api';

const PostContext = createContext();

const postReducer = (state, action) => {
    switch (action.type) {
        case 'SET_LOADING':
            return { ...state, loading: action.payload };
        case 'SET_POSTS':
            return { ...state, posts: action.payload, loading: false };
        case 'ADD_POST':
            return { ...state, posts: [action.payload, ...state.posts] };
        case 'UPDATE_POST':
            return {
                ...state,
                posts: state.posts.map(post =>
                    post.id === action.payload.id ? action.payload : post
                )
            };
        case 'DELETE_POST':
            return {
                ...state,
                posts: state.posts.filter(post => post.id !== action.payload)
            };
        case 'LIKE_POST':
            return {
                ...state,
                posts: state.posts.map(post =>
                    post.id === action.payload.id
                        ? {
                              ...post,
                              likes: action.payload.liked
                                  ? [...post.likes, action.payload.userId]
                                  : post.likes.filter(id => id !== action.payload.userId)
                          }
                        : post
                )
            };
        case 'ADD_COMMENT':
            return {
                ...state,
                posts: state.posts.map(post =>
                    post.id === action.payload.postId
                        ? {
                              ...post,
                              comments: [...post.comments, action.payload.comment]
                          }
                        : post
                )
            };
        default:
            return state;
    }
};

const initialState = {
    posts: [],
    loading: true,
    error: null
};

export function PostProvider({ children }) {
    const [state, dispatch] = useReducer(postReducer, initialState);
    
    useEffect(() => {
        loadPosts();
    }, []);
    
    const loadPosts = async () => {
        try {
            dispatch({ type: 'SET_LOADING', payload: true });
            const response = await postsAPI.getPosts();
            dispatch({ type: 'SET_POSTS', payload: response.data });
        } catch (error) {
            dispatch({ type: 'SET_ERROR', payload: error.message });
        }
    };
    
    const createPost = async (postData) => {
        try {
            const response = await postsAPI.createPost(postData);
            dispatch({ type: 'ADD_POST', payload: response.data });
            return { success: true };
        } catch (error) {
            return { success: false, error: error.message };
        }
    };
    
    const updatePost = async (id, postData) => {
        try {
            const response = await postsAPI.updatePost(id, postData);
            dispatch({ type: 'UPDATE_POST', payload: response.data });
            return { success: true };
        } catch (error) {
            return { success: false, error: error.message };
        }
    };
    
    const deletePost = async (id) => {
        try {
            await postsAPI.deletePost(id);
            dispatch({ type: 'DELETE_POST', payload: id });
            return { success: true };
        } catch (error) {
            return { success: false, error: error.message };
        }
    };
    
    const likePost = async (postId, userId) => {
        try {
            const post = state.posts.find(p => p.id === postId);
            const isLiked = post.likes.includes(userId);
            
            await postsAPI.likePost(postId, !isLiked);
            dispatch({
                type: 'LIKE_POST',
                payload: { id: postId, userId, liked: !isLiked }
            });
        } catch (error) {
            console.error('Failed to like post:', error);
        }
    };
    
    const addComment = async (postId, commentText, userId) => {
        try {
            const comment = {
                id: Date.now(),
                userId,
                text: commentText,
                createdAt: new Date().toISOString()
            };
            
            await postsAPI.addComment(postId, comment);
            dispatch({
                type: 'ADD_COMMENT',
                payload: { postId, comment }
            });
        } catch (error) {
            console.error('Failed to add comment:', error);
        }
    };
    
    return (
        <PostContext.Provider
            value={{
                ...state,
                loadPosts,
                createPost,
                updatePost,
                deletePost,
                likePost,
                addComment
            }}
        >
            {children}
        </PostContext.Provider>
    );
}

export function usePosts() {
    const context = useContext(PostContext);
    if (!context) {
        throw new Error('usePosts must be used within PostProvider');
    }
    return context;
}
```

### Post Form Component

```javascript
// src/components/PostForm.jsx
import { useState } from 'react';
import { usePosts } from '../context/PostContext';
import { useAuth } from '../context/AuthContext';
import ImageUpload from './ImageUpload';
import './PostForm.css';

function PostForm({ onClose }) {
    const { createPost } = usePosts();
    const { user } = useAuth();
    const [text, setText] = useState('');
    const [image, setImage] = useState(null);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState('');
    
    const handleSubmit = async (e) => {
        e.preventDefault();
        
        if (!text.trim() && !image) {
            setError('Please add text or an image');
            return;
        }
        
        setLoading(true);
        setError('');
        
        try {
            // Upload image if present
            let imageUrl = null;
            if (image) {
                const formData = new FormData();
                formData.append('image', image);
                // Upload image to server
                // imageUrl = await uploadImage(formData);
            }
            
            const result = await createPost({
                text: text.trim(),
                image: imageUrl,
                userId: user.id
            });
            
            if (result.success) {
                setText('');
                setImage(null);
                if (onClose) onClose();
            } else {
                setError(result.error);
            }
        } catch (error) {
            setError('Failed to create post');
        } finally {
            setLoading(false);
        }
    };
    
    return (
        <div className="post-form-container">
            <form className="post-form" onSubmit={handleSubmit}>
                <div className="post-form-header">
                    <h2>Create Post</h2>
                    {onClose && (
                        <button type="button" onClick={onClose} className="btn-close">
                            ×
                        </button>
                    )}
                </div>
                
                <div className="post-form-content">
                    <textarea
                        value={text}
                        onChange={(e) => setText(e.target.value)}
                        placeholder="What's on your mind?"
                        className="post-textarea"
                        rows="4"
                    />
                    
                    <ImageUpload onImageSelect={setImage} />
                    
                    {error && <div className="error-message">{error}</div>}
                </div>
                
                <div className="post-form-actions">
                    <button
                        type="submit"
                        disabled={loading}
                        className="btn btn-primary"
                    >
                        {loading ? 'Posting...' : 'Post'}
                    </button>
                </div>
            </form>
        </div>
    );
}

export default PostForm;
```

### Post Card Component

```javascript
// src/components/PostCard.jsx
import { useState } from 'react';
import { formatDistanceToNow } from 'date-fns';
import { usePosts } from '../context/PostContext';
import { useAuth } from '../context/AuthContext';
import CommentSection from './CommentSection';
import './PostCard.css';

function PostCard({ post }) {
    const { likePost, deletePost } = usePosts();
    const { user } = useAuth();
    const [showComments, setShowComments] = useState(false);
    
    const isLiked = post.likes?.includes(user?.id) || false;
    const isOwner = post.userId === user?.id;
    
    const handleLike = () => {
        if (user) {
            likePost(post.id, user.id);
        }
    };
    
    const handleDelete = async () => {
        if (window.confirm('Are you sure you want to delete this post?')) {
            await deletePost(post.id);
        }
    };
    
    return (
        <div className="post-card">
            <div className="post-header">
                <div className="post-author">
                    <img
                        src={post.author?.avatar || 'https://via.placeholder.com/40'}
                        alt={post.author?.name}
                        className="author-avatar"
                    />
                    <div>
                        <h4>{post.author?.name || 'Unknown User'}</h4>
                        <span className="post-time">
                            {formatDistanceToNow(new Date(post.createdAt), { addSuffix: true })}
                        </span>
                    </div>
                </div>
                {isOwner && (
                    <button onClick={handleDelete} className="btn-delete">
                        Delete
                    </button>
                )}
            </div>
            
            {post.text && (
                <div className="post-content">
                    <p>{post.text}</p>
                </div>
            )}
            
            {post.image && (
                <div className="post-image">
                    <img src={post.image} alt="Post" />
                </div>
            )}
            
            <div className="post-actions">
                <button
                    onClick={handleLike}
                    className={`btn-action ${isLiked ? 'liked' : ''}`}
                >
                    <span>❤️</span>
                    <span>{post.likes?.length || 0}</span>
                </button>
                <button
                    onClick={() => setShowComments(!showComments)}
                    className="btn-action"
                >
                    <span>💬</span>
                    <span>{post.comments?.length || 0}</span>
                </button>
                <button className="btn-action">
                    <span>🔗</span>
                    <span>Share</span>
                </button>
            </div>
            
            {showComments && (
                <CommentSection postId={post.id} comments={post.comments || []} />
            )}
        </div>
    );
}

export default PostCard;
```

### Comment Section Component

```javascript
// src/components/CommentSection.jsx
import { useState } from 'react';
import { formatDistanceToNow } from 'date-fns';
import { usePosts } from '../context/PostContext';
import { useAuth } from '../context/AuthContext';
import './CommentSection.css';

function CommentSection({ postId, comments }) {
    const { addComment } = usePosts();
    const { user } = useAuth();
    const [commentText, setCommentText] = useState('');
    const [loading, setLoading] = useState(false);
    
    const handleSubmit = async (e) => {
        e.preventDefault();
        if (!commentText.trim() || !user) return;
        
        setLoading(true);
        await addComment(postId, commentText.trim(), user.id);
        setCommentText('');
        setLoading(false);
    };
    
    return (
        <div className="comment-section">
            <div className="comments-list">
                {comments.map(comment => (
                    <div key={comment.id} className="comment">
                        <img
                            src={comment.author?.avatar || 'https://via.placeholder.com/30'}
                            alt={comment.author?.name}
                            className="comment-avatar"
                        />
                        <div className="comment-content">
                            <div className="comment-header">
                                <strong>{comment.author?.name || 'Unknown'}</strong>
                                <span className="comment-time">
                                    {formatDistanceToNow(new Date(comment.createdAt), { addSuffix: true })}
                                </span>
                            </div>
                            <p>{comment.text}</p>
                        </div>
                    </div>
                ))}
            </div>
            
            {user && (
                <form className="comment-form" onSubmit={handleSubmit}>
                    <input
                        type="text"
                        value={commentText}
                        onChange={(e) => setCommentText(e.target.value)}
                        placeholder="Write a comment..."
                        className="comment-input"
                    />
                    <button
                        type="submit"
                        disabled={loading || !commentText.trim()}
                        className="btn-comment"
                    >
                        Post
                    </button>
                </form>
            )}
        </div>
    );
}

export default CommentSection;
```

### Feed Component

```javascript
// src/components/Feed.jsx
import { usePosts } from '../context/PostContext';
import PostCard from './PostCard';
import Loading from './Loading';
import './Feed.css';

function Feed() {
    const { posts, loading } = usePosts();
    
    if (loading) {
        return <Loading />;
    }
    
    if (posts.length === 0) {
        return (
            <div className="empty-feed">
                <p>No posts yet. Be the first to post!</p>
            </div>
        );
    }
    
    return (
        <div className="feed">
            {posts.map(post => (
                <PostCard key={post.id} post={post} />
            ))}
        </div>
    );
}

export default Feed;
```

### App Component

```javascript
// src/App.jsx
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { AuthProvider } from './context/AuthContext';
import { PostProvider } from './context/PostContext';
import Layout from './components/Layout';
import Home from './pages/Home';
import Profile from './pages/Profile';
import Explore from './pages/Explore';
import './App.css';

function App() {
    return (
        <AuthProvider>
            <PostProvider>
                <BrowserRouter>
                    <Routes>
                        <Route path="/" element={<Layout />}>
                            <Route index element={<Home />} />
                            <Route path="profile/:userId" element={<Profile />} />
                            <Route path="explore" element={<Explore />} />
                        </Route>
                    </Routes>
                </BrowserRouter>
            </PostProvider>
        </AuthProvider>
    );
}

export default App;
```

---

## Features Implementation

### Complex State Management

- **Context API**: Global state for posts and auth
- **useReducer**: Complex state logic
- **Optimistic Updates**: Immediate UI updates
- **State Synchronization**: Keep state in sync

### Image Uploads

- **File Handling**: Process image files
- **Preview**: Show image before upload
- **Validation**: Check file size and type
- **Upload**: Send to server

### User Interactions

- **Likes**: Toggle like status
- **Comments**: Add and display comments
- **Shares**: Share posts
- **Real-Time**: Update UI instantly

---

## Testing Your Application

### Manual Testing Checklist

- [ ] Create post with text
- [ ] Create post with image
- [ ] Like/unlike posts
- [ ] Add comments
- [ ] Delete own posts
- [ ] View feed
- [ ] View profiles
- [ ] Search functionality
- [ ] Follow users
- [ ] Handle errors

---

## Exercise: Social Media App

**Instructions**:

1. Set up React project
2. Create all components
3. Implement state management
4. Add image upload
5. Test all features

**Enhancement Ideas**:

- Add stories feature
- Add direct messaging
- Add video posts
- Add hashtags
- Add mentions
- Add notifications
- Add analytics
- Add dark mode

---

## Common Issues and Solutions

### Issue: Images not uploading

**Solution**: Check file size limits and server configuration.

### Issue: State not updating

**Solution**: Ensure reducer returns new state objects.

### Issue: Performance issues

**Solution**: Use React.memo, useMemo, and useCallback.

---

## Quiz: Complex App

1. **Complex state:**
   - A) Requires careful management
   - B) Simple to manage
   - C) Both
   - D) Neither

2. **Image uploads:**
   - A) Need file handling
   - B) Don't need handling
   - C) Both
   - D) Neither

3. **User interactions:**
   - A) Update state
   - B) Don't update state
   - C) Both
   - D) Neither

4. **Performance:**
   - A) Important for complex apps
   - B) Not important
   - C) Both
   - D) Neither

5. **State management:**
   - A) Critical for complex apps
   - B) Not critical
   - C) Both
   - D) Neither

**Answers**:
1. A) Requires careful management
2. A) Need file handling
3. A) Update state
4. A) Important for complex apps
5. A) Critical for complex apps

---

## Key Takeaways

1. **Complex State**: Use Context API and useReducer
2. **Image Uploads**: Handle files properly
3. **User Interactions**: Real-time updates
4. **Performance**: Optimize with memoization
5. **Best Practice**: Clean architecture, proper state management

---

## Next Steps

Congratulations! You've built a Social Media Clone. You now know:
- How to manage complex state
- How to handle image uploads
- How to implement user interactions
- How to build complex applications

**What's Next?**
- Final Projects: Capstone Projects
- Build complete applications
- Apply all learned concepts
- Create portfolio projects

---

*Project completed! You've finished Project 4: Advanced Projects. Ready for Final Projects!*

