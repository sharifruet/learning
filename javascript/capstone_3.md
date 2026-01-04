# Capstone Project 3: Real-Time Application

## Project Overview

Build a production-ready Real-Time Application using WebSockets, combining frontend and backend with real-time communication. This capstone project will demonstrate mastery of WebSocket integration, real-time features, backend API development, database integration, and deployment.

## Learning Objectives

By the end of this project, you will be able to:
- Implement WebSocket connections
- Build real-time features
- Design and develop backend APIs
- Integrate databases with real-time updates
- Handle concurrent connections
- Optimize real-time performance
- Deploy real-time applications
- Handle edge cases and errors

---

## Project Requirements

### Core Features

1. **Real-Time Communication**
   - Instant message delivery
   - Live updates
   - User presence indicators
   - Typing indicators
   - Notifications

2. **Backend API**
   - RESTful API endpoints
   - WebSocket server
   - Database integration
   - Authentication
   - Error handling

3. **Database**
   - Store messages and data
   - User management
   - Real-time data sync
   - Data persistence

4. **User Features**
   - User authentication
   - User profiles
   - Online/offline status
   - Message history
   - Room/channel management

5. **Advanced Features**
   - File sharing
   - Message reactions
   - Read receipts
   - Message editing/deleting
   - Search functionality

### Technical Requirements

- **Backend**: Node.js, Express.js, Socket.io
- **Frontend**: React or Vue.js
- **Database**: MongoDB or PostgreSQL
- **Authentication**: JWT
- **WebSockets**: Socket.io
- **Deployment**: Backend and frontend deployment

---

## Project Ideas

Choose one of these or create your own:

### Option 1: Real-Time Collaboration Tool
- Multiple users editing documents
- Live cursor positions
- Change tracking
- Comments and suggestions
- Version history

### Option 2: Live Dashboard Application
- Real-time data visualization
- Multiple data sources
- Live updates
- Customizable widgets
- Alerts and notifications

### Option 3: Multiplayer Game
- Real-time game state
- Player interactions
- Leaderboards
- Game rooms
- Chat system

### Option 4: Live Polling/Voting App
- Create polls
- Real-time vote counting
- Results visualization
- Multiple poll types
- Admin controls

### Option 5: Team Communication Platform
- Channels and direct messages
- File sharing
- Video/audio calls (optional)
- Notifications
- Message threads

---

## Recommended Project: Real-Time Collaboration Tool

We'll use a Real-Time Collaboration Tool as our example. You can adapt this to any of the options above.

---

## Project Structure

```
collaboration-app/
├── backend/
│   ├── src/
│   │   ├── config/
│   │   │   └── database.js
│   │   ├── models/
│   │   │   ├── User.js
│   │   │   ├── Document.js
│   │   │   └── Change.js
│   │   ├── controllers/
│   │   │   ├── authController.js
│   │   │   ├── documentController.js
│   │   │   └── userController.js
│   │   ├── routes/
│   │   │   ├── authRoutes.js
│   │   │   ├── documentRoutes.js
│   │   │   └── userRoutes.js
│   │   ├── socket/
│   │   │   ├── socketHandlers.js
│   │   │   └── documentHandlers.js
│   │   ├── middleware/
│   │   │   ├── auth.js
│   │   │   └── errorHandler.js
│   │   └── server.js
│   ├── .env
│   └── package.json
├── frontend/
│   ├── src/
│   │   ├── components/
│   │   │   ├── Layout/
│   │   │   ├── Document/
│   │   │   ├── Editor/
│   │   │   └── UserList/
│   │   ├── pages/
│   │   │   ├── Home.jsx
│   │   │   ├── DocumentPage.jsx
│   │   │   └── Dashboard.jsx
│   │   ├── context/
│   │   │   ├── AuthContext.jsx
│   │   │   └── SocketContext.jsx
│   │   ├── hooks/
│   │   │   └── useSocket.js
│   │   ├── services/
│   │   │   └── api.js
│   │   └── App.jsx
│   └── package.json
└── README.md
```

---

## Step-by-Step Implementation

### Phase 1: Backend Setup

```bash
# Create backend directory
mkdir collaboration-backend
cd collaboration-backend
npm init -y

# Install dependencies
npm install express socket.io mongoose dotenv bcrypt jsonwebtoken cors helmet express-rate-limit
npm install --save-dev nodemon

# Create project structure
mkdir -p src/{config,models,controllers,routes,socket,middleware}
```

### Phase 2: Database Models

```javascript
// backend/src/models/Document.js
const mongoose = require('mongoose');

const changeSchema = new mongoose.Schema({
    type: {
        type: String,
        enum: ['insert', 'delete', 'format'],
        required: true
    },
    position: {
        type: Number,
        required: true
    },
    text: String,
    length: Number,
    format: {
        type: Map,
        of: String
    },
    userId: {
        type: mongoose.Schema.Types.ObjectId,
        ref: 'User',
        required: true
    },
    timestamp: {
        type: Date,
        default: Date.now
    }
}, { _id: false });

const documentSchema = new mongoose.Schema({
    title: {
        type: String,
        required: true,
        trim: true
    },
    content: {
        type: String,
        default: ''
    },
    owner: {
        type: mongoose.Schema.Types.ObjectId,
        ref: 'User',
        required: true
    },
    collaborators: [{
        user: {
            type: mongoose.Schema.Types.ObjectId,
            ref: 'User'
        },
        role: {
            type: String,
            enum: ['viewer', 'editor'],
            default: 'editor'
        }
    }],
    changes: [changeSchema],
    version: {
        type: Number,
        default: 1
    },
    isPublic: {
        type: Boolean,
        default: false
    }
}, {
    timestamps: true
});

module.exports = mongoose.model('Document', documentSchema);
```

### Phase 3: Socket Handlers

```javascript
// backend/src/socket/documentHandlers.js
const Document = require('../models/Document');
const User = require('../models/User');

// Store active users per document
const activeUsers = new Map();

function setupDocumentHandlers(io, socket) {
    // Join document room
    socket.on('document:join', async (data) => {
        const { documentId, userId } = data;
        
        try {
            const document = await Document.findById(documentId);
            if (!document) {
                socket.emit('error', { message: 'Document not found' });
                return;
            }
            
            // Check access
            const hasAccess = document.owner.toString() === userId ||
                            document.collaborators.some(c => c.user.toString() === userId) ||
                            document.isPublic;
            
            if (!hasAccess) {
                socket.emit('error', { message: 'Access denied' });
                return;
            }
            
            // Join room
            socket.join(documentId);
            
            // Track active user
            if (!activeUsers.has(documentId)) {
                activeUsers.set(documentId, new Map());
            }
            
            const user = await User.findById(userId).select('name email');
            activeUsers.get(documentId).set(socket.id, {
                userId,
                name: user.name,
                cursor: null
            });
            
            // Notify others
            socket.to(documentId).emit('user:joined', {
                userId,
                name: user.name
            });
            
            // Send current document state
            socket.emit('document:state', {
                content: document.content,
                version: document.version
            });
            
            // Send active users
            const users = Array.from(activeUsers.get(documentId).values());
            io.to(documentId).emit('users:list', users);
            
        } catch (error) {
            socket.emit('error', { message: error.message });
        }
    });
    
    // Handle text changes
    socket.on('document:change', async (data) => {
        const { documentId, change, userId } = data;
        
        try {
            const document = await Document.findById(documentId);
            if (!document) return;
            
            // Apply change to content
            let newContent = document.content;
            if (change.type === 'insert') {
                newContent = newContent.slice(0, change.position) +
                           change.text +
                           newContent.slice(change.position);
            } else if (change.type === 'delete') {
                newContent = newContent.slice(0, change.position) +
                           newContent.slice(change.position + change.length);
            }
            
            // Save change
            document.content = newContent;
            document.changes.push({
                ...change,
                userId
            });
            document.version += 1;
            await document.save();
            
            // Broadcast to other users in room
            socket.to(documentId).emit('document:change', {
                change,
                userId,
                version: document.version
            });
            
        } catch (error) {
            socket.emit('error', { message: error.message });
        }
    });
    
    // Handle cursor position
    socket.on('cursor:update', (data) => {
        const { documentId, position, userId } = data;
        
        if (activeUsers.has(documentId)) {
            const user = activeUsers.get(documentId).get(socket.id);
            if (user) {
                user.cursor = position;
                socket.to(documentId).emit('cursor:update', {
                    userId,
                    position,
                    name: user.name
                });
            }
        }
    });
    
    // Handle user leaving
    socket.on('document:leave', (data) => {
        const { documentId, userId } = data;
        
        if (activeUsers.has(documentId)) {
            activeUsers.get(documentId).delete(socket.id);
            
            if (activeUsers.get(documentId).size === 0) {
                activeUsers.delete(documentId);
            } else {
                socket.to(documentId).emit('user:left', { userId });
                const users = Array.from(activeUsers.get(documentId).values());
                io.to(documentId).emit('users:list', users);
            }
        }
    });
    
    // Cleanup on disconnect
    socket.on('disconnect', () => {
        activeUsers.forEach((users, documentId) => {
            if (users.has(socket.id)) {
                const user = users.get(socket.id);
                users.delete(socket.id);
                
                if (users.size === 0) {
                    activeUsers.delete(documentId);
                } else {
                    io.to(documentId).emit('user:left', { userId: user.userId });
                    const userList = Array.from(users.values());
                    io.to(documentId).emit('users:list', userList);
                }
            }
        });
    });
}

module.exports = setupDocumentHandlers;
```

### Phase 4: Socket Server Setup

```javascript
// backend/src/socket/socketHandlers.js
const jwt = require('jsonwebtoken');
const User = require('../models/User');
const setupDocumentHandlers = require('./documentHandlers');

function setupSocketIO(io) {
    // Authentication middleware for Socket.io
    io.use(async (socket, next) => {
        try {
            const token = socket.handshake.auth.token;
            
            if (!token) {
                return next(new Error('Authentication error'));
            }
            
            const decoded = jwt.verify(token, process.env.JWT_SECRET);
            const user = await User.findById(decoded.userId).select('-password');
            
            if (!user) {
                return next(new Error('User not found'));
            }
            
            socket.userId = user._id.toString();
            socket.user = user;
            next();
        } catch (error) {
            next(new Error('Authentication error'));
        }
    });
    
    io.on('connection', (socket) => {
        console.log('User connected:', socket.userId);
        
        // Setup document handlers
        setupDocumentHandlers(io, socket);
        
        socket.on('disconnect', () => {
            console.log('User disconnected:', socket.userId);
        });
    });
}

module.exports = setupSocketIO;
```

### Phase 5: Server with Socket.io

```javascript
// backend/src/server.js
const express = require('express');
const http = require('http');
const { Server } = require('socket.io');
const mongoose = require('mongoose');
const cors = require('cors');
const helmet = require('helmet');
require('dotenv').config();

const authRoutes = require('./routes/authRoutes');
const documentRoutes = require('./routes/documentRoutes');
const errorHandler = require('./middleware/errorHandler');
const setupSocketIO = require('./socket/socketHandlers');

const app = express();
const server = http.createServer(app);

// Configure Socket.io
const io = new Server(server, {
    cors: {
        origin: process.env.CLIENT_URL || 'http://localhost:3000',
        methods: ['GET', 'POST'],
        credentials: true
    }
});

// Setup Socket.io handlers
setupSocketIO(io);

// Middleware
app.use(helmet());
app.use(cors({
    origin: process.env.CLIENT_URL || 'http://localhost:3000',
    credentials: true
}));
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Routes
app.use('/api/auth', authRoutes);
app.use('/api/documents', documentRoutes);

// Health check
app.get('/api/health', (req, res) => {
    res.json({
        success: true,
        message: 'API is running',
        timestamp: new Date().toISOString()
    });
});

// Error handler
app.use(errorHandler);

// Connect to database
mongoose.connect(process.env.MONGODB_URI)
    .then(() => {
        console.log('Connected to MongoDB');
        const PORT = process.env.PORT || 5000;
        server.listen(PORT, () => {
            console.log(`Server running on port ${PORT}`);
        });
    })
    .catch((error) => {
        console.error('MongoDB connection error:', error);
        process.exit(1);
    });
```

### Phase 6: Frontend Socket Context

```javascript
// frontend/src/context/SocketContext.jsx
import { createContext, useContext, useEffect, useState } from 'react';
import { io } from 'socket.io-client';
import { useAuth } from './AuthContext';

const SocketContext = createContext();

export function SocketProvider({ children }) {
    const { user, isAuthenticated } = useAuth();
    const [socket, setSocket] = useState(null);
    const [connected, setConnected] = useState(false);
    
    useEffect(() => {
        if (isAuthenticated && user) {
            const token = localStorage.getItem('token');
            const newSocket = io(process.env.REACT_APP_SOCKET_URL || 'http://localhost:5000', {
                auth: {
                    token
                },
                transports: ['websocket']
            });
            
            newSocket.on('connect', () => {
                console.log('Socket connected');
                setConnected(true);
            });
            
            newSocket.on('disconnect', () => {
                console.log('Socket disconnected');
                setConnected(false);
            });
            
            newSocket.on('error', (error) => {
                console.error('Socket error:', error);
            });
            
            setSocket(newSocket);
            
            return () => {
                newSocket.close();
            };
        }
    }, [isAuthenticated, user]);
    
    return (
        <SocketContext.Provider value={{ socket, connected }}>
            {children}
        </SocketContext.Provider>
    );
}

export function useSocket() {
    const context = useContext(SocketContext);
    if (!context) {
        throw new Error('useSocket must be used within SocketProvider');
    }
    return context;
}
```

### Phase 7: Document Editor Component

```javascript
// frontend/src/components/Editor/DocumentEditor.jsx
import { useState, useEffect, useRef } from 'react';
import { useSocket } from '../../context/SocketContext';
import { useAuth } from '../../context/AuthContext';
import './DocumentEditor.css';

function DocumentEditor({ documentId, initialContent }) {
    const { socket } = useSocket();
    const { user } = useAuth();
    const [content, setContent] = useState(initialContent || '');
    const [version, setVersion] = useState(1);
    const [activeUsers, setActiveUsers] = useState([]);
    const [cursors, setCursors] = useState(new Map());
    const editorRef = useRef(null);
    const lastChangeRef = useRef(null);
    
    useEffect(() => {
        if (!socket || !documentId) return;
        
        // Join document
        socket.emit('document:join', {
            documentId,
            userId: user.id
        });
        
        // Listen for document state
        socket.on('document:state', (data) => {
            setContent(data.content);
            setVersion(data.version);
        });
        
        // Listen for changes from others
        socket.on('document:change', (data) => {
            if (data.userId !== user.id) {
                applyChange(data.change);
                setVersion(data.version);
            }
        });
        
        // Listen for active users
        socket.on('users:list', (users) => {
            setActiveUsers(users);
        });
        
        // Listen for cursor updates
        socket.on('cursor:update', (data) => {
            if (data.userId !== user.id) {
                setCursors(prev => {
                    const newCursors = new Map(prev);
                    newCursors.set(data.userId, {
                        position: data.position,
                        name: data.name
                    });
                    return newCursors;
                });
            }
        });
        
        // Listen for user joined/left
        socket.on('user:joined', (data) => {
            console.log(`${data.name} joined`);
        });
        
        socket.on('user:left', (data) => {
            setCursors(prev => {
                const newCursors = new Map(prev);
                newCursors.delete(data.userId);
                return newCursors;
            });
        });
        
        return () => {
            socket.emit('document:leave', { documentId, userId: user.id });
            socket.off('document:state');
            socket.off('document:change');
            socket.off('users:list');
            socket.off('cursor:update');
            socket.off('user:joined');
            socket.off('user:left');
        };
    }, [socket, documentId, user]);
    
    const applyChange = (change) => {
        setContent(prev => {
            if (change.type === 'insert') {
                return prev.slice(0, change.position) +
                       change.text +
                       prev.slice(change.position);
            } else if (change.type === 'delete') {
                return prev.slice(0, change.position) +
                       prev.slice(change.position + change.length);
            }
            return prev;
        });
    };
    
    const handleChange = (e) => {
        const newContent = e.target.value;
        const oldContent = content;
        const position = e.target.selectionStart;
        
        // Calculate change
        let change;
        if (newContent.length > oldContent.length) {
            // Insert
            const insertedText = newContent.slice(position - (newContent.length - oldContent.length), position);
            change = {
                type: 'insert',
                position: position - insertedText.length,
                text: insertedText
            };
        } else {
            // Delete
            change = {
                type: 'delete',
                position,
                length: oldContent.length - newContent.length
            };
        }
        
        // Update local state
        setContent(newContent);
        
        // Debounce and send change
        if (lastChangeRef.current) {
            clearTimeout(lastChangeRef.current);
        }
        
        lastChangeRef.current = setTimeout(() => {
            if (socket && documentId) {
                socket.emit('document:change', {
                    documentId,
                    change,
                    userId: user.id
                });
            }
        }, 100);
        
        // Update cursor position
        if (socket && documentId) {
            socket.emit('cursor:update', {
                documentId,
                position: e.target.selectionStart,
                userId: user.id
            });
        }
    };
    
    const handleSelectionChange = (e) => {
        if (socket && documentId) {
            socket.emit('cursor:update', {
                documentId,
                position: e.target.selectionStart,
                userId: user.id
            });
        }
    };
    
    return (
        <div className="document-editor">
            <div className="editor-header">
                <div className="active-users">
                    {activeUsers.map(u => (
                        <span key={u.userId} className="user-badge">
                            {u.name}
                        </span>
                    ))}
                </div>
                <div className="editor-version">
                    Version: {version}
                </div>
            </div>
            
            <textarea
                ref={editorRef}
                value={content}
                onChange={handleChange}
                onSelect={handleSelectionChange}
                className="editor-textarea"
                placeholder="Start typing..."
            />
            
            <div className="cursors-overlay">
                {Array.from(cursors.entries()).map(([userId, cursor]) => (
                    <div
                        key={userId}
                        className="cursor-indicator"
                        style={{ left: `${cursor.position * 8}px` }}
                    >
                        <span className="cursor-name">{cursor.name}</span>
                        <div className="cursor-line"></div>
                    </div>
                ))}
            </div>
        </div>
    );
}

export default DocumentEditor;
```

### Phase 8: Document Page

```javascript
// frontend/src/pages/DocumentPage.jsx
import { useState, useEffect } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { documentsAPI } from '../services/api';
import { useAuth } from '../context/AuthContext';
import DocumentEditor from '../components/Editor/DocumentEditor';
import Loading from '../components/Common/Loading';
import Error from '../components/Common/Error';
import './DocumentPage.css';

function DocumentPage() {
    const { id } = useParams();
    const navigate = useNavigate();
    const { user } = useAuth();
    const [document, setDocument] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    
    useEffect(() => {
        loadDocument();
    }, [id]);
    
    const loadDocument = async () => {
        try {
            setLoading(true);
            const response = await documentsAPI.getDocument(id);
            setDocument(response.data.data);
        } catch (err) {
            setError(err.response?.data?.error || 'Failed to load document');
        } finally {
            setLoading(false);
        }
    };
    
    if (loading) {
        return <Loading />;
    }
    
    if (error) {
        return <Error message={error} />;
    }
    
    if (!document) {
        return <Error message="Document not found" />;
    }
    
    return (
        <div className="document-page">
            <div className="document-header">
                <button onClick={() => navigate(-1)} className="btn btn-back">
                    ← Back
                </button>
                <h1>{document.title}</h1>
                <div className="document-actions">
                    <button className="btn btn-secondary">Share</button>
                    <button className="btn btn-secondary">Export</button>
                </div>
            </div>
            
            <DocumentEditor
                documentId={id}
                initialContent={document.content}
            />
        </div>
    );
}

export default DocumentPage;
```

### Phase 9: App Component

```javascript
// frontend/src/App.jsx
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { AuthProvider } from './context/AuthContext';
import { SocketProvider } from './context/SocketContext';
import Layout from './components/Layout/Layout';
import Home from './pages/Home';
import Login from './pages/Login';
import Register from './pages/Register';
import Dashboard from './pages/Dashboard';
import DocumentPage from './pages/DocumentPage';
import ProtectedRoute from './components/ProtectedRoute';
import './App.css';

function App() {
    return (
        <AuthProvider>
            <SocketProvider>
                <BrowserRouter>
                    <Layout>
                        <Routes>
                            <Route path="/" element={<Home />} />
                            <Route path="/login" element={<Login />} />
                            <Route path="/register" element={<Register />} />
                            <Route
                                path="/dashboard"
                                element={
                                    <ProtectedRoute>
                                        <Dashboard />
                                    </ProtectedRoute>
                                }
                            />
                            <Route
                                path="/document/:id"
                                element={
                                    <ProtectedRoute>
                                        <DocumentPage />
                                    </ProtectedRoute>
                                }
                            />
                        </Routes>
                    </Layout>
                </BrowserRouter>
            </SocketProvider>
        </AuthProvider>
    );
}

export default App;
```

---

## Features Implementation

### WebSocket Integration

- **Socket.io Server**: Real-time server setup
- **Socket.io Client**: Frontend connection
- **Authentication**: JWT-based socket auth
- **Room Management**: Document rooms

### Real-Time Features

- **Live Editing**: Collaborative text editing
- **Cursor Tracking**: See other users' cursors
- **User Presence**: Show active users
- **Change Broadcasting**: Instant updates
- **Version Control**: Track document versions

### Backend API

- **REST Endpoints**: Document CRUD
- **WebSocket Events**: Real-time events
- **Database**: MongoDB integration
- **Authentication**: Secure access

### Database

- **Document Storage**: Store documents
- **Change History**: Track all changes
- **User Management**: User data
- **Relationships**: User-document relationships

---

## Testing Your Application

### Manual Testing Checklist

- [ ] Connect multiple users
- [ ] Real-time text editing
- [ ] See other users' cursors
- [ ] User join/leave notifications
- [ ] Document persistence
- [ ] Change history
- [ ] Error handling
- [ ] Reconnection handling
- [ ] Performance with many users
- [ ] Mobile responsiveness

---

## Deployment

### Backend Deployment

```bash
# Heroku example
heroku create your-app-backend
heroku config:set MONGODB_URI=your-uri
heroku config:set JWT_SECRET=your-secret
heroku config:set CLIENT_URL=https://your-frontend.com
git push heroku main
```

### Frontend Deployment

```bash
# Vercel example
npm run build
vercel
vercel env add REACT_APP_SOCKET_URL
vercel env add REACT_APP_API_URL
```

### Environment Variables

**Backend (.env)**:
```
NODE_ENV=production
PORT=5000
MONGODB_URI=your-mongodb-uri
JWT_SECRET=your-secret-key
CLIENT_URL=https://your-frontend.com
```

**Frontend (.env)**:
```
REACT_APP_API_URL=https://your-backend.com/api
REACT_APP_SOCKET_URL=https://your-backend.com
```

---

## Exercise: Real-Time Application

**Instructions**:

1. Choose your project idea
2. Set up backend with Socket.io
3. Set up frontend
4. Implement real-time features
5. Test with multiple users
6. Deploy to production

**Timeline**: 3-4 weeks recommended

---

## Common Issues and Solutions

### Issue: Socket connection fails

**Solution**: Check CORS configuration and authentication token.

### Issue: Changes not syncing

**Solution**: Verify event names match and changes are being saved.

### Issue: Performance issues

**Solution**: Implement debouncing, optimize change broadcasting.

---

## Quiz: WebSockets

1. **WebSockets:**
   - A) Real-time bidirectional communication
   - B) One-way communication
   - C) Both
   - D) Neither

2. **Socket.io:**
   - A) WebSocket library
   - B) HTTP library
   - C) Both
   - D) Neither

3. **Real-time features:**
   - A) Instant updates
   - B) Delayed updates
   - C) Both
   - D) Neither

4. **Rooms:**
   - A) Group connections
   - B) Don't group connections
   - C) Both
   - D) Neither

5. **Database:**
   - A) Persists real-time data
   - B) Doesn't persist data
   - C) Both
   - D) Neither

**Answers**:
1. A) Real-time bidirectional communication
2. A) WebSocket library
3. A) Instant updates
4. A) Group connections
5. A) Persists real-time data

---

## Key Takeaways

1. **WebSockets**: Enable real-time communication
2. **Socket.io**: Simplifies WebSocket implementation
3. **Real-Time Features**: Instant updates and collaboration
4. **Backend API**: REST + WebSocket combination
5. **Database**: Persist real-time data
6. **Best Practice**: Handle connections, errors, and performance

---

## Next Steps

Congratulations! You've built a Real-Time Application. You now know:
- How to implement WebSockets
- How to build real-time features
- How to integrate backend APIs
- How to work with databases
- How to deploy real-time apps

**What's Next?**
- Assessment and Certification
- Complete all projects
- Pass assessments
- Get certified

---

*Capstone Project completed! You've demonstrated mastery of real-time application development!*

