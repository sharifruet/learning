# Project 4.1: Real-Time Chat Application

## Project Overview

Build a real-time chat application using WebSockets and Socket.io. This project will help you practice real-time communication, WebSocket connections, user management, and building interactive applications.

## Learning Objectives

By the end of this project, you will be able to:
- Understand WebSockets and real-time communication
- Use Socket.io for bidirectional communication
- Manage user connections and disconnections
- Handle real-time messaging
- Build interactive chat interfaces
- Manage chat rooms and channels
- Handle user presence

---

## Project Requirements

### Core Features

1. **Real-Time Messaging**: Send and receive messages instantly
2. **User Management**: Join/leave, user list
3. **Chat Rooms**: Multiple chat rooms
4. **Typing Indicators**: Show when users are typing
5. **User Presence**: Show online/offline status
6. **Message History**: Store and display message history
7. **Notifications**: Notify users of new messages
8. **Responsive Design**: Works on all devices

### Technical Requirements

- Node.js backend with Socket.io
- React frontend with Socket.io client
- Real-time WebSocket connections
- User session management
- Message storage (optional database)
- Clean UI/UX

---

## Project Setup

### Backend Setup

```bash
# Create backend directory
mkdir chat-backend
cd chat-backend

# Initialize npm
npm init -y

# Install dependencies
npm install express socket.io cors dotenv
npm install --save-dev nodemon

# Create project structure
mkdir src
```

### Frontend Setup

```bash
# Create React app
npx create-react-app chat-frontend
cd chat-frontend

# Install Socket.io client
npm install socket.io-client

# Start development server
npm start
```

---

## Project Structure

```
chat-application/
├── backend/
│   ├── src/
│   │   ├── server.js
│   │   └── socketHandlers.js
│   ├── .env
│   └── package.json
└── frontend/
    ├── src/
    │   ├── components/
    │   │   ├── ChatRoom.jsx
    │   │   ├── MessageList.jsx
    │   │   ├── MessageInput.jsx
    │   │   ├── UserList.jsx
    │   │   └── Login.jsx
    │   ├── hooks/
    │   │   └── useSocket.js
    │   ├── App.jsx
    │   └── index.js
    └── package.json
```

---

## Step-by-Step Implementation

### Backend: Server Setup

```javascript
// backend/src/server.js
const express = require('express');
const http = require('http');
const { Server } = require('socket.io');
const cors = require('cors');
require('dotenv').config();

const app = express();
const server = http.createServer(app);

// Configure CORS for Socket.io
const io = new Server(server, {
    cors: {
        origin: process.env.CLIENT_URL || 'http://localhost:3000',
        methods: ['GET', 'POST']
    }
});

app.use(cors());
app.use(express.json());

// Store connected users
const users = new Map();
const messages = [];

// Socket.io connection handling
io.on('connection', (socket) => {
    console.log('User connected:', socket.id);
    
    // User joins
    socket.on('user:join', (userData) => {
        users.set(socket.id, {
            id: socket.id,
            username: userData.username,
            room: userData.room || 'general'
        });
        
        // Join room
        socket.join(userData.room || 'general');
        
        // Notify others
        socket.to(userData.room || 'general').emit('user:joined', {
            username: userData.username,
            message: `${userData.username} joined the chat`
        });
        
        // Send current users
        const roomUsers = Array.from(users.values())
            .filter(user => user.room === (userData.room || 'general'));
        io.to(userData.room || 'general').emit('users:list', roomUsers);
        
        // Send message history
        const roomMessages = messages.filter(
            msg => msg.room === (userData.room || 'general')
        );
        socket.emit('messages:history', roomMessages);
    });
    
    // Send message
    socket.on('message:send', (messageData) => {
        const user = users.get(socket.id);
        if (user) {
            const message = {
                id: Date.now(),
                username: user.username,
                text: messageData.text,
                room: user.room,
                timestamp: new Date().toISOString()
            };
            
            messages.push(message);
            
            // Send to room
            io.to(user.room).emit('message:receive', message);
        }
    });
    
    // Typing indicator
    socket.on('typing:start', () => {
        const user = users.get(socket.id);
        if (user) {
            socket.to(user.room).emit('typing:start', {
                username: user.username
            });
        }
    });
    
    socket.on('typing:stop', () => {
        const user = users.get(socket.id);
        if (user) {
            socket.to(user.room).emit('typing:stop', {
                username: user.username
            });
        }
    });
    
    // User disconnects
    socket.on('disconnect', () => {
        const user = users.get(socket.id);
        if (user) {
            users.delete(socket.id);
            
            // Notify others
            socket.to(user.room).emit('user:left', {
                username: user.username,
                message: `${user.username} left the chat`
            });
            
            // Update user list
            const roomUsers = Array.from(users.values())
                .filter(u => u.room === user.room);
            io.to(user.room).emit('users:list', roomUsers);
        }
        console.log('User disconnected:', socket.id);
    });
});

const PORT = process.env.PORT || 5000;
server.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});
```

### Frontend: Socket Hook

```javascript
// frontend/src/hooks/useSocket.js
import { useEffect, useState } from 'react';
import io from 'socket.io-client';

const SOCKET_URL = process.env.REACT_APP_SOCKET_URL || 'http://localhost:5000';

export function useSocket() {
    const [socket, setSocket] = useState(null);
    const [connected, setConnected] = useState(false);
    
    useEffect(() => {
        const newSocket = io(SOCKET_URL);
        
        newSocket.on('connect', () => {
            setConnected(true);
        });
        
        newSocket.on('disconnect', () => {
            setConnected(false);
        });
        
        setSocket(newSocket);
        
        return () => {
            newSocket.close();
        };
    }, []);
    
    return { socket, connected };
}
```

### Frontend: Login Component

```javascript
// frontend/src/components/Login.jsx
import { useState } from 'react';
import './Login.css';

function Login({ onLogin }) {
    const [username, setUsername] = useState('');
    const [room, setRoom] = useState('general');
    
    const handleSubmit = (e) => {
        e.preventDefault();
        if (username.trim()) {
            onLogin(username.trim(), room);
        }
    };
    
    return (
        <div className="login-container">
            <div className="login-box">
                <h1>Join Chat</h1>
                <form onSubmit={handleSubmit}>
                    <div className="form-group">
                        <label>Username</label>
                        <input
                            type="text"
                            value={username}
                            onChange={(e) => setUsername(e.target.value)}
                            placeholder="Enter your username"
                            required
                        />
                    </div>
                    <div className="form-group">
                        <label>Room</label>
                        <select
                            value={room}
                            onChange={(e) => setRoom(e.target.value)}
                        >
                            <option value="general">General</option>
                            <option value="random">Random</option>
                            <option value="tech">Tech</option>
                            <option value="gaming">Gaming</option>
                        </select>
                    </div>
                    <button type="submit" className="btn btn-primary">
                        Join Chat
                    </button>
                </form>
            </div>
        </div>
    );
}

export default Login;
```

### Frontend: Message List Component

```javascript
// frontend/src/components/MessageList.jsx
import { useEffect, useRef } from 'react';
import './MessageList.css';

function MessageList({ messages, currentUser }) {
    const messagesEndRef = useRef(null);
    
    const scrollToBottom = () => {
        messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' });
    };
    
    useEffect(() => {
        scrollToBottom();
    }, [messages]);
    
    return (
        <div className="message-list">
            {messages.map(message => (
                <div
                    key={message.id}
                    className={`message ${message.username === currentUser ? 'own' : ''}`}
                >
                    <div className="message-header">
                        <span className="message-username">{message.username}</span>
                        <span className="message-time">
                            {new Date(message.timestamp).toLocaleTimeString()}
                        </span>
                    </div>
                    <div className="message-text">{message.text}</div>
                </div>
            ))}
            <div ref={messagesEndRef} />
        </div>
    );
}

export default MessageList;
```

### Frontend: Message Input Component

```javascript
// frontend/src/components/MessageInput.jsx
import { useState, useEffect, useRef } from 'react';
import './MessageInput.css';

function MessageInput({ socket, currentUser, room }) {
    const [message, setMessage] = useState('');
    const [isTyping, setIsTyping] = useState(false);
    const typingTimeoutRef = useRef(null);
    
    useEffect(() => {
        return () => {
            if (typingTimeoutRef.current) {
                clearTimeout(typingTimeoutRef.current);
            }
        };
    }, []);
    
    const handleChange = (e) => {
        setMessage(e.target.value);
        
        if (!isTyping) {
            setIsTyping(true);
            socket.emit('typing:start');
        }
        
        clearTimeout(typingTimeoutRef.current);
        typingTimeoutRef.current = setTimeout(() => {
            setIsTyping(false);
            socket.emit('typing:stop');
        }, 1000);
    };
    
    const handleSubmit = (e) => {
        e.preventDefault();
        if (message.trim()) {
            socket.emit('message:send', { text: message.trim() });
            setMessage('');
            setIsTyping(false);
            socket.emit('typing:stop');
        }
    };
    
    return (
        <form className="message-input" onSubmit={handleSubmit}>
            <input
                type="text"
                value={message}
                onChange={handleChange}
                placeholder="Type a message..."
                className="message-input-field"
            />
            <button type="submit" className="btn btn-send">
                Send
            </button>
        </form>
    );
}

export default MessageInput;
```

### Frontend: User List Component

```javascript
// frontend/src/components/UserList.jsx
import './UserList.css';

function UserList({ users, currentUser }) {
    return (
        <div className="user-list">
            <h3>Online Users ({users.length})</h3>
            <ul>
                {users.map(user => (
                    <li key={user.id} className={user.username === currentUser ? 'current' : ''}>
                        <span className="user-indicator"></span>
                        {user.username}
                        {user.username === currentUser && ' (You)'}
                    </li>
                ))}
            </ul>
        </div>
    );
}

export default UserList;
```

### Frontend: Chat Room Component

```javascript
// frontend/src/components/ChatRoom.jsx
import { useState, useEffect } from 'react';
import { useSocket } from '../hooks/useSocket';
import MessageList from './MessageList';
import MessageInput from './MessageInput';
import UserList from './UserList';
import './ChatRoom.css';

function ChatRoom({ username, room, onLeave }) {
    const { socket, connected } = useSocket();
    const [messages, setMessages] = useState([]);
    const [users, setUsers] = useState([]);
    const [typingUsers, setTypingUsers] = useState([]);
    const [systemMessage, setSystemMessage] = useState('');
    
    useEffect(() => {
        if (socket && username) {
            // Join room
            socket.emit('user:join', { username, room });
            
            // Listen for messages
            socket.on('message:receive', (message) => {
                setMessages(prev => [...prev, message]);
            });
            
            // Listen for message history
            socket.on('messages:history', (history) => {
                setMessages(history);
            });
            
            // Listen for user list
            socket.on('users:list', (userList) => {
                setUsers(userList);
            });
            
            // Listen for user joined
            socket.on('user:joined', (data) => {
                setSystemMessage(`${data.username} joined the chat`);
                setTimeout(() => setSystemMessage(''), 3000);
            });
            
            // Listen for user left
            socket.on('user:left', (data) => {
                setSystemMessage(`${data.username} left the chat`);
                setTimeout(() => setSystemMessage(''), 3000);
            });
            
            // Listen for typing
            socket.on('typing:start', (data) => {
                setTypingUsers(prev => {
                    if (!prev.includes(data.username)) {
                        return [...prev, data.username];
                    }
                    return prev;
                });
            });
            
            socket.on('typing:stop', (data) => {
                setTypingUsers(prev => prev.filter(u => u !== data.username));
            });
            
            return () => {
                socket.off('message:receive');
                socket.off('messages:history');
                socket.off('users:list');
                socket.off('user:joined');
                socket.off('user:left');
                socket.off('typing:start');
                socket.off('typing:stop');
            };
        }
    }, [socket, username, room]);
    
    return (
        <div className="chat-room">
            <div className="chat-header">
                <div>
                    <h2>Room: {room}</h2>
                    <span className={`connection-status ${connected ? 'connected' : 'disconnected'}`}>
                        {connected ? '● Connected' : '○ Disconnected'}
                    </span>
                </div>
                <button onClick={onLeave} className="btn btn-leave">
                    Leave Room
                </button>
            </div>
            
            <div className="chat-content">
                <div className="chat-messages">
                    <MessageList messages={messages} currentUser={username} />
                    {systemMessage && (
                        <div className="system-message">{systemMessage}</div>
                    )}
                    {typingUsers.length > 0 && (
                        <div className="typing-indicator">
                            {typingUsers.join(', ')} {typingUsers.length === 1 ? 'is' : 'are'} typing...
                        </div>
                    )}
                    <MessageInput socket={socket} currentUser={username} room={room} />
                </div>
                
                <UserList users={users} currentUser={username} />
            </div>
        </div>
    );
}

export default ChatRoom;
```

### Frontend: App Component

```javascript
// frontend/src/App.jsx
import { useState } from 'react';
import Login from './components/Login';
import ChatRoom from './components/ChatRoom';
import './App.css';

function App() {
    const [username, setUsername] = useState(null);
    const [room, setRoom] = useState(null);
    
    const handleLogin = (user, selectedRoom) => {
        setUsername(user);
        setRoom(selectedRoom);
    };
    
    const handleLeave = () => {
        setUsername(null);
        setRoom(null);
    };
    
    return (
        <div className="app">
            {!username ? (
                <Login onLogin={handleLogin} />
            ) : (
                <ChatRoom username={username} room={room} onLeave={handleLeave} />
            )}
        </div>
    );
}

export default App;
```

---

## Features Implementation

### WebSockets

- **Real-Time Connection**: Bidirectional communication
- **Event-Based**: Emit and listen to events
- **Room Management**: Join/leave rooms
- **Connection Status**: Track connection state

### Real-Time Communication

- **Instant Messaging**: Messages sent/received instantly
- **Typing Indicators**: Show when users are typing
- **User Presence**: Show online users
- **System Messages**: Notify of user joins/leaves

### User Management

- **User List**: Display connected users
- **User Identification**: Track users by socket ID
- **Room Assignment**: Users belong to rooms
- **Disconnect Handling**: Clean up on disconnect

---

## Testing Your Application

### Manual Testing Checklist

- [ ] Connect to chat
- [ ] Send messages
- [ ] Receive messages
- [ ] See user list
- [ ] See typing indicators
- [ ] Join different rooms
- [ ] See system messages
- [ ] Handle disconnection
- [ ] Multiple users
- [ ] Message history

---

## Exercise: Chat App

**Instructions**:

1. Set up backend and frontend
2. Implement all features
3. Test with multiple users
4. Add enhancements
5. Deploy application

**Enhancement Ideas**:

- Add private messaging
- Add file sharing
- Add emoji support
- Add message reactions
- Add user avatars
- Add message search
- Add message editing/deleting
- Add voice/video chat

---

## Common Issues and Solutions

### Issue: Connection fails

**Solution**: Check CORS configuration and Socket.io URL.

### Issue: Messages not appearing

**Solution**: Verify event names match on emit and on.

### Issue: Users not updating

**Solution**: Ensure user list is updated on join/leave events.

---

## Quiz: WebSockets

1. **WebSockets:**
   - A) Real-time communication
   - B) Request-response only
   - C) Both
   - D) Neither

2. **Socket.io:**
   - A) WebSocket library
   - B) HTTP library
   - C) Both
   - D) Neither

3. **Real-time:**
   - A) Instant updates
   - B) Delayed updates
   - C) Both
   - D) Neither

4. **Rooms:**
   - A) Group users
   - B) Don't group users
   - C) Both
   - D) Neither

5. **Typing indicators:**
   - A) Show user activity
   - B) Don't show activity
   - C) Both
   - D) Neither

**Answers**:
1. A) Real-time communication
2. A) WebSocket library
3. A) Instant updates
4. A) Group users
5. A) Show user activity

---

## Key Takeaways

1. **WebSockets**: Real-time bidirectional communication
2. **Socket.io**: Easy WebSocket implementation
3. **Real-Time**: Instant updates without polling
4. **User Management**: Track connected users
5. **Best Practice**: Handle connections and disconnections

---

## Next Steps

Congratulations! You've built a Real-Time Chat Application. You now know:
- How to use WebSockets
- How to implement Socket.io
- How to handle real-time communication
- How to manage users

**What's Next?**
- Project 4.2: Social Media Clone
- Learn complex state management
- Build social features
- Handle image uploads

---

*Project completed! You're ready to move on to the next project.*

