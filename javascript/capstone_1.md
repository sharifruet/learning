# Capstone Project 1: Full-Stack Web Application

## Project Overview

Build a complete, production-ready Full-Stack Web Application that demonstrates mastery of JavaScript, React, Node.js, databases, and deployment. This capstone project will showcase all the skills you've learned throughout the JavaScript curriculum.

## Learning Objectives

By the end of this project, you will be able to:
- Design and build a complete full-stack application
- Implement secure authentication and authorization
- Integrate databases effectively
- Design RESTful APIs
- Deploy applications to production
- Handle errors and edge cases
- Write clean, maintainable code
- Document your application

---

## Project Requirements

### Core Features

1. **User Authentication & Authorization**
   - User registration and login
   - JWT-based authentication
   - Protected routes
   - User profiles
   - Password reset (optional)

2. **Core Application Features**
   - CRUD operations for main entities
   - Data relationships
   - Search and filtering
   - Pagination
   - Sorting

3. **Database Integration**
   - MongoDB or MySQL/PostgreSQL
   - Proper schema design
   - Relationships and associations
   - Data validation

4. **API Design**
   - RESTful API endpoints
   - Proper HTTP methods
   - Status codes
   - Error handling
   - API documentation

5. **Frontend**
   - React application
   - State management
   - Routing
   - Responsive design
   - Error handling
   - Loading states

6. **Deployment**
   - Backend deployment
   - Frontend deployment
   - Environment configuration
   - Database setup

### Technical Requirements

- **Backend**: Node.js, Express.js
- **Frontend**: React
- **Database**: MongoDB (Mongoose) or MySQL/PostgreSQL (Sequelize)
- **Authentication**: JWT
- **Validation**: Input validation on both ends
- **Error Handling**: Comprehensive error handling
- **Security**: CORS, rate limiting, input sanitization
- **Documentation**: README with setup instructions

---

## Project Ideas

Choose one of these or create your own:

### Option 1: Task Management System
- Projects, tasks, subtasks
- Team collaboration
- Due dates and priorities
- File attachments
- Activity logs

### Option 2: E-Commerce Platform
- Product catalog
- Shopping cart
- Checkout process
- Order management
- Payment integration (Stripe)

### Option 3: Social Media Platform
- User profiles
- Posts and comments
- Likes and shares
- Follow system
- News feed

### Option 4: Learning Management System
- Courses and lessons
- Student enrollment
- Progress tracking
- Quizzes and assessments
- Certificates

### Option 5: Recipe Sharing Platform
- Recipe creation
- Categories and tags
- Ratings and reviews
- Search and filtering
- User collections

---

## Recommended Project: Task Management System

We'll use a Task Management System as our example. You can adapt this to any of the options above.

---

## Project Structure

```
task-management-system/
├── backend/
│   ├── src/
│   │   ├── config/
│   │   │   └── database.js
│   │   ├── controllers/
│   │   │   ├── authController.js
│   │   │   ├── projectController.js
│   │   │   ├── taskController.js
│   │   │   └── userController.js
│   │   ├── models/
│   │   │   ├── User.js
│   │   │   ├── Project.js
│   │   │   └── Task.js
│   │   ├── routes/
│   │   │   ├── authRoutes.js
│   │   │   ├── projectRoutes.js
│   │   │   ├── taskRoutes.js
│   │   │   └── userRoutes.js
│   │   ├── middleware/
│   │   │   ├── auth.js
│   │   │   ├── errorHandler.js
│   │   │   └── validate.js
│   │   ├── utils/
│   │   │   └── generateToken.js
│   │   └── server.js
│   ├── .env
│   ├── .gitignore
│   └── package.json
├── frontend/
│   ├── src/
│   │   ├── components/
│   │   │   ├── Layout.jsx
│   │   │   ├── Navigation.jsx
│   │   │   ├── ProjectCard.jsx
│   │   │   ├── TaskCard.jsx
│   │   │   ├── ProjectForm.jsx
│   │   │   ├── TaskForm.jsx
│   │   │   └── Loading.jsx
│   │   ├── pages/
│   │   │   ├── Home.jsx
│   │   │   ├── Login.jsx
│   │   │   ├── Register.jsx
│   │   │   ├── Dashboard.jsx
│   │   │   ├── Projects.jsx
│   │   │   ├── ProjectDetail.jsx
│   │   │   └── Profile.jsx
│   │   ├── context/
│   │   │   ├── AuthContext.jsx
│   │   │   └── ProjectContext.jsx
│   │   ├── services/
│   │   │   └── api.js
│   │   ├── App.jsx
│   │   └── index.js
│   ├── .env
│   └── package.json
└── README.md
```

---

## Step-by-Step Implementation

### Phase 1: Backend Setup

#### 1. Initialize Backend

```bash
mkdir task-management-backend
cd task-management-backend
npm init -y
npm install express mongoose dotenv bcrypt jsonwebtoken express-validator cors helmet express-rate-limit
npm install --save-dev nodemon
```

#### 2. Database Models

```javascript
// backend/src/models/User.js
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
    avatar: {
        type: String,
        default: 'https://via.placeholder.com/150'
    },
    role: {
        type: String,
        enum: ['user', 'admin'],
        default: 'user'
    }
}, {
    timestamps: true
});

userSchema.pre('save', async function(next) {
    if (!this.isModified('password')) return next();
    const salt = await bcrypt.genSalt(10);
    this.password = await bcrypt.hash(this.password, salt);
    next();
});

userSchema.methods.comparePassword = async function(candidatePassword) {
    return await bcrypt.compare(candidatePassword, this.password);
};

module.exports = mongoose.model('User', userSchema);
```

```javascript
// backend/src/models/Project.js
const mongoose = require('mongoose');

const projectSchema = new mongoose.Schema({
    name: {
        type: String,
        required: [true, 'Please provide a project name'],
        trim: true
    },
    description: {
        type: String,
        trim: true
    },
    owner: {
        type: mongoose.Schema.Types.ObjectId,
        ref: 'User',
        required: true
    },
    members: [{
        type: mongoose.Schema.Types.ObjectId,
        ref: 'User'
    }],
    status: {
        type: String,
        enum: ['active', 'completed', 'archived'],
        default: 'active'
    },
    color: {
        type: String,
        default: '#667eea'
    }
}, {
    timestamps: true
});

module.exports = mongoose.model('Project', projectSchema);
```

```javascript
// backend/src/models/Task.js
const mongoose = require('mongoose');

const taskSchema = new mongoose.Schema({
    title: {
        type: String,
        required: [true, 'Please provide a task title'],
        trim: true
    },
    description: {
        type: String,
        trim: true
    },
    project: {
        type: mongoose.Schema.Types.ObjectId,
        ref: 'Project',
        required: true
    },
    assignedTo: {
        type: mongoose.Schema.Types.ObjectId,
        ref: 'User'
    },
    createdBy: {
        type: mongoose.Schema.Types.ObjectId,
        ref: 'User',
        required: true
    },
    status: {
        type: String,
        enum: ['todo', 'in-progress', 'completed'],
        default: 'todo'
    },
    priority: {
        type: String,
        enum: ['low', 'medium', 'high'],
        default: 'medium'
    },
    dueDate: {
        type: Date
    },
    tags: [{
        type: String
    }]
}, {
    timestamps: true
});

module.exports = mongoose.model('Task', taskSchema);
```

#### 3. Controllers

```javascript
// backend/src/controllers/projectController.js
const Project = require('../models/Project');
const Task = require('../models/Task');

exports.getProjects = async (req, res, next) => {
    try {
        const projects = await Project.find({
            $or: [
                { owner: req.user._id },
                { members: req.user._id }
            ]
        })
        .populate('owner', 'name email')
        .populate('members', 'name email')
        .sort({ createdAt: -1 });
        
        res.json({
            success: true,
            count: projects.length,
            data: projects
        });
    } catch (error) {
        next(error);
    }
};

exports.getProject = async (req, res, next) => {
    try {
        const project = await Project.findById(req.params.id)
            .populate('owner', 'name email')
            .populate('members', 'name email');
        
        if (!project) {
            return res.status(404).json({
                success: false,
                error: 'Project not found'
            });
        }
        
        // Check access
        const hasAccess = project.owner._id.toString() === req.user._id.toString() ||
                         project.members.some(m => m._id.toString() === req.user._id.toString());
        
        if (!hasAccess) {
            return res.status(403).json({
                success: false,
                error: 'Not authorized to access this project'
            });
        }
        
        res.json({
            success: true,
            data: project
        });
    } catch (error) {
        next(error);
    }
};

exports.createProject = async (req, res, next) => {
    try {
        req.body.owner = req.user._id;
        const project = await Project.create(req.body);
        
        const populatedProject = await Project.findById(project._id)
            .populate('owner', 'name email');
        
        res.status(201).json({
            success: true,
            data: populatedProject
        });
    } catch (error) {
        next(error);
    }
};

exports.updateProject = async (req, res, next) => {
    try {
        let project = await Project.findById(req.params.id);
        
        if (!project) {
            return res.status(404).json({
                success: false,
                error: 'Project not found'
            });
        }
        
        // Check ownership
        if (project.owner.toString() !== req.user._id.toString() && req.user.role !== 'admin') {
            return res.status(403).json({
                success: false,
                error: 'Not authorized to update this project'
            });
        }
        
        project = await Project.findByIdAndUpdate(
            req.params.id,
            req.body,
            { new: true, runValidators: true }
        ).populate('owner', 'name email')
         .populate('members', 'name email');
        
        res.json({
            success: true,
            data: project
        });
    } catch (error) {
        next(error);
    }
};

exports.deleteProject = async (req, res, next) => {
    try {
        const project = await Project.findById(req.params.id);
        
        if (!project) {
            return res.status(404).json({
                success: false,
                error: 'Project not found'
            });
        }
        
        // Check ownership
        if (project.owner.toString() !== req.user._id.toString() && req.user.role !== 'admin') {
            return res.status(403).json({
                success: false,
                error: 'Not authorized to delete this project'
            });
        }
        
        // Delete associated tasks
        await Task.deleteMany({ project: project._id });
        
        await project.deleteOne();
        
        res.json({
            success: true,
            data: {}
        });
    } catch (error) {
        next(error);
    }
};
```

```javascript
// backend/src/controllers/taskController.js
const Task = require('../models/Task');
const Project = require('../models/Project');

exports.getTasks = async (req, res, next) => {
    try {
        const { projectId, status, priority } = req.query;
        const query = {};
        
        if (projectId) {
            query.project = projectId;
        }
        if (status) {
            query.status = status;
        }
        if (priority) {
            query.priority = priority;
        }
        
        // Only get tasks from projects user has access to
        const userProjects = await Project.find({
            $or: [
                { owner: req.user._id },
                { members: req.user._id }
            ]
        }).select('_id');
        
        const projectIds = userProjects.map(p => p._id);
        query.project = { $in: projectIds };
        
        const tasks = await Task.find(query)
            .populate('project', 'name')
            .populate('assignedTo', 'name email')
            .populate('createdBy', 'name email')
            .sort({ createdAt: -1 });
        
        res.json({
            success: true,
            count: tasks.length,
            data: tasks
        });
    } catch (error) {
        next(error);
    }
};

exports.getTask = async (req, res, next) => {
    try {
        const task = await Task.findById(req.params.id)
            .populate('project', 'name owner members')
            .populate('assignedTo', 'name email')
            .populate('createdBy', 'name email');
        
        if (!task) {
            return res.status(404).json({
                success: false,
                error: 'Task not found'
            });
        }
        
        // Check access through project
        const project = task.project;
        const hasAccess = project.owner.toString() === req.user._id.toString() ||
                         project.members.some(m => m.toString() === req.user._id.toString());
        
        if (!hasAccess) {
            return res.status(403).json({
                success: false,
                error: 'Not authorized to access this task'
            });
        }
        
        res.json({
            success: true,
            data: task
        });
    } catch (error) {
        next(error);
    }
};

exports.createTask = async (req, res, next) => {
    try {
        // Verify project access
        const project = await Project.findById(req.body.project);
        if (!project) {
            return res.status(404).json({
                success: false,
                error: 'Project not found'
            });
        }
        
        const hasAccess = project.owner.toString() === req.user._id.toString() ||
                         project.members.some(m => m.toString() === req.user._id.toString());
        
        if (!hasAccess) {
            return res.status(403).json({
                success: false,
                error: 'Not authorized to create tasks in this project'
            });
        }
        
        req.body.createdBy = req.user._id;
        const task = await Task.create(req.body);
        
        const populatedTask = await Task.findById(task._id)
            .populate('project', 'name')
            .populate('assignedTo', 'name email')
            .populate('createdBy', 'name email');
        
        res.status(201).json({
            success: true,
            data: populatedTask
        });
    } catch (error) {
        next(error);
    }
};

exports.updateTask = async (req, res, next) => {
    try {
        let task = await Task.findById(req.params.id).populate('project');
        
        if (!task) {
            return res.status(404).json({
                success: false,
                error: 'Task not found'
            });
        }
        
        // Check access
        const project = task.project;
        const hasAccess = project.owner.toString() === req.user._id.toString() ||
                         project.members.some(m => m.toString() === req.user._id.toString()) ||
                         task.assignedTo?.toString() === req.user._id.toString();
        
        if (!hasAccess) {
            return res.status(403).json({
                success: false,
                error: 'Not authorized to update this task'
            });
        }
        
        task = await Task.findByIdAndUpdate(
            req.params.id,
            req.body,
            { new: true, runValidators: true }
        ).populate('project', 'name')
         .populate('assignedTo', 'name email')
         .populate('createdBy', 'name email');
        
        res.json({
            success: true,
            data: task
        });
    } catch (error) {
        next(error);
    }
};

exports.deleteTask = async (req, res, next) => {
    try {
        const task = await Task.findById(req.params.id).populate('project');
        
        if (!task) {
            return res.status(404).json({
                success: false,
                error: 'Task not found'
            });
        }
        
        // Check access
        const project = task.project;
        const hasAccess = project.owner.toString() === req.user._id.toString() ||
                         project.members.some(m => m.toString() === req.user._id.toString()) ||
                         task.createdBy.toString() === req.user._id.toString();
        
        if (!hasAccess) {
            return res.status(403).json({
                success: false,
                error: 'Not authorized to delete this task'
            });
        }
        
        await task.deleteOne();
        
        res.json({
            success: true,
            data: {}
        });
    } catch (error) {
        next(error);
    }
};
```

#### 4. Routes

```javascript
// backend/src/routes/projectRoutes.js
const express = require('express');
const {
    getProjects,
    getProject,
    createProject,
    updateProject,
    deleteProject
} = require('../controllers/projectController');
const { protect } = require('../middleware/auth');
const { body } = require('express-validator');
const validate = require('../middleware/validate');

const router = express.Router();

router.use(protect);

router.get('/', getProjects);
router.get('/:id', getProject);
router.post(
    '/',
    [
        body('name').trim().notEmpty().withMessage('Project name is required')
    ],
    validate,
    createProject
);
router.put('/:id', updateProject);
router.delete('/:id', deleteProject);

module.exports = router;
```

```javascript
// backend/src/routes/taskRoutes.js
const express = require('express');
const {
    getTasks,
    getTask,
    createTask,
    updateTask,
    deleteTask
} = require('../controllers/taskController');
const { protect } = require('../middleware/auth');
const { body } = require('express-validator');
const validate = require('../middleware/validate');

const router = express.Router();

router.use(protect);

router.get('/', getTasks);
router.get('/:id', getTask);
router.post(
    '/',
    [
        body('title').trim().notEmpty().withMessage('Task title is required'),
        body('project').notEmpty().withMessage('Project is required')
    ],
    validate,
    createTask
);
router.put('/:id', updateTask);
router.delete('/:id', deleteTask);

module.exports = router;
```

#### 5. Server Setup

```javascript
// backend/src/server.js
const express = require('express');
const mongoose = require('mongoose');
const cors = require('cors');
const helmet = require('helmet');
const rateLimit = require('express-rate-limit');
require('dotenv').config();

const authRoutes = require('./routes/authRoutes');
const projectRoutes = require('./routes/projectRoutes');
const taskRoutes = require('./routes/taskRoutes');
const userRoutes = require('./routes/userRoutes');
const errorHandler = require('./middleware/errorHandler');

const app = express();

// Security middleware
app.use(helmet());
app.use(cors({
    origin: process.env.CLIENT_URL || 'http://localhost:3000',
    credentials: true
}));

// Rate limiting
const limiter = rateLimit({
    windowMs: 15 * 60 * 1000, // 15 minutes
    max: 100 // limit each IP to 100 requests per windowMs
});
app.use('/api/', limiter);

// Body parser
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Routes
app.use('/api/auth', authRoutes);
app.use('/api/projects', projectRoutes);
app.use('/api/tasks', taskRoutes);
app.use('/api/users', userRoutes);

// Health check
app.get('/api/health', (req, res) => {
    res.json({
        success: true,
        message: 'API is running',
        timestamp: new Date().toISOString()
    });
});

// Error handler (must be last)
app.use(errorHandler);

// Connect to database
mongoose.connect(process.env.MONGODB_URI)
    .then(() => {
        console.log('Connected to MongoDB');
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

### Phase 2: Frontend Setup

#### 1. Initialize Frontend

```bash
npx create-react-app task-management-frontend
cd task-management-frontend
npm install axios react-router-dom date-fns
```

#### 2. API Service

```javascript
// frontend/src/services/api.js
import axios from 'axios';

const API_URL = process.env.REACT_APP_API_URL || 'http://localhost:5000/api';

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
    (error) => Promise.reject(error)
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

export const authAPI = {
    register: (userData) => api.post('/auth/register', userData),
    login: (credentials) => api.post('/auth/login', credentials),
    getMe: () => api.get('/auth/me')
};

export const projectsAPI = {
    getProjects: () => api.get('/projects'),
    getProject: (id) => api.get(`/projects/${id}`),
    createProject: (data) => api.post('/projects', data),
    updateProject: (id, data) => api.put(`/projects/${id}`, data),
    deleteProject: (id) => api.delete(`/projects/${id}`)
};

export const tasksAPI = {
    getTasks: (params) => api.get('/tasks', { params }),
    getTask: (id) => api.get(`/tasks/${id}`),
    createTask: (data) => api.post('/tasks', data),
    updateTask: (id, data) => api.put(`/tasks/${id}`, data),
    deleteTask: (id) => api.delete(`/tasks/${id}`)
};

export default api;
```

#### 3. Context Providers

```javascript
// frontend/src/context/AuthContext.jsx
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

#### 4. Main Pages

```javascript
// frontend/src/pages/Dashboard.jsx
import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { projectsAPI, tasksAPI } from '../services/api';
import { useAuth } from '../context/AuthContext';
import ProjectCard from '../components/ProjectCard';
import Loading from '../components/Loading';
import './Dashboard.css';

function Dashboard() {
    const { user } = useAuth();
    const [projects, setProjects] = useState([]);
    const [tasks, setTasks] = useState([]);
    const [loading, setLoading] = useState(true);
    const [stats, setStats] = useState({
        totalProjects: 0,
        totalTasks: 0,
        completedTasks: 0,
        activeTasks: 0
    });
    
    useEffect(() => {
        loadData();
    }, []);
    
    const loadData = async () => {
        try {
            setLoading(true);
            const [projectsRes, tasksRes] = await Promise.all([
                projectsAPI.getProjects(),
                tasksAPI.getTasks()
            ]);
            
            setProjects(projectsRes.data.data.slice(0, 5));
            setTasks(tasksRes.data.data.slice(0, 5));
            
            const allTasks = tasksRes.data.data;
            setStats({
                totalProjects: projectsRes.data.count,
                totalTasks: allTasks.length,
                completedTasks: allTasks.filter(t => t.status === 'completed').length,
                activeTasks: allTasks.filter(t => t.status !== 'completed').length
            });
        } catch (error) {
            console.error('Failed to load data:', error);
        } finally {
            setLoading(false);
        }
    };
    
    if (loading) {
        return <Loading />;
    }
    
    return (
        <div className="dashboard">
            <h1>Welcome, {user?.name}!</h1>
            
            <div className="stats-grid">
                <div className="stat-card">
                    <h3>{stats.totalProjects}</h3>
                    <p>Projects</p>
                </div>
                <div className="stat-card">
                    <h3>{stats.totalTasks}</h3>
                    <p>Total Tasks</p>
                </div>
                <div className="stat-card">
                    <h3>{stats.activeTasks}</h3>
                    <p>Active Tasks</p>
                </div>
                <div className="stat-card">
                    <h3>{stats.completedTasks}</h3>
                    <p>Completed Tasks</p>
                </div>
            </div>
            
            <div className="dashboard-sections">
                <section className="recent-projects">
                    <div className="section-header">
                        <h2>Recent Projects</h2>
                        <Link to="/projects" className="btn btn-link">View All</Link>
                    </div>
                    <div className="projects-grid">
                        {projects.map(project => (
                            <ProjectCard key={project._id} project={project} />
                        ))}
                    </div>
                </section>
                
                <section className="recent-tasks">
                    <div className="section-header">
                        <h2>Recent Tasks</h2>
                        <Link to="/tasks" className="btn btn-link">View All</Link>
                    </div>
                    <div className="tasks-list">
                        {tasks.map(task => (
                            <TaskCard key={task._id} task={task} />
                        ))}
                    </div>
                </section>
            </div>
        </div>
    );
}

export default Dashboard;
```

---

## Deployment Guide

### Backend Deployment (Heroku Example)

```bash
# Install Heroku CLI
# Login to Heroku
heroku login

# Create app
heroku create your-app-name

# Set environment variables
heroku config:set NODE_ENV=production
heroku config:set MONGODB_URI=your-mongodb-uri
heroku config:set JWT_SECRET=your-secret-key
heroku config:set CLIENT_URL=https://your-frontend-url.com

# Deploy
git push heroku main
```

### Frontend Deployment (Vercel Example)

```bash
# Install Vercel CLI
npm install -g vercel

# Build project
npm run build

# Deploy
vercel

# Set environment variable
vercel env add REACT_APP_API_URL
```

---

## Testing Checklist

- [ ] User registration
- [ ] User login
- [ ] Protected routes
- [ ] Create project
- [ ] View projects
- [ ] Update project
- [ ] Delete project
- [ ] Create task
- [ ] View tasks
- [ ] Update task
- [ ] Delete task
- [ ] Filter and search
- [ ] Error handling
- [ ] Responsive design
- [ ] Deployment

---

## Documentation Requirements

### README.md Should Include:

1. **Project Description**: What the application does
2. **Features**: List of features
3. **Tech Stack**: Technologies used
4. **Installation**: Step-by-step setup
5. **Configuration**: Environment variables
6. **API Documentation**: Endpoints and examples
7. **Deployment**: Deployment instructions
8. **Screenshots**: Application screenshots
9. **Contributing**: How to contribute
10. **License**: License information

---

## Evaluation Criteria

Your project will be evaluated on:

1. **Functionality** (30%)
   - All features work correctly
   - No critical bugs
   - Edge cases handled

2. **Code Quality** (25%)
   - Clean, readable code
   - Proper structure
   - Comments where needed

3. **Security** (20%)
   - Authentication implemented
   - Input validation
   - Error handling
   - Security best practices

4. **Design** (15%)
   - User-friendly interface
   - Responsive design
   - Good UX

5. **Documentation** (10%)
   - Complete README
   - API documentation
   - Setup instructions

---

## Exercise: Full-Stack Web Application

**Instructions**:

1. Choose your project idea
2. Plan your application architecture
3. Set up backend and frontend
4. Implement all features
5. Test thoroughly
6. Deploy to production
7. Document your project

**Timeline**: 2-4 weeks recommended

---

## Key Takeaways

1. **Full-Stack Development**: Complete application development
2. **Architecture**: Plan before coding
3. **Security**: Always prioritize security
4. **Testing**: Test all features
5. **Deployment**: Deploy to production
6. **Documentation**: Document everything

---

## Next Steps

Congratulations! You've completed your Capstone Project. You now know:
- How to build complete full-stack applications
- How to implement authentication
- How to integrate databases
- How to design APIs
- How to deploy applications

**What's Next?**
- Capstone Project 2: Single Page Application (SPA)
- Build modern SPAs
- Apply advanced concepts
- Create portfolio projects

---

*Capstone Project completed! You've demonstrated mastery of full-stack JavaScript development!*

