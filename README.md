# bandhanhara learning

A comprehensive free learning platform for any subject. Start with Python, JavaScript, or any topic you want to learn. Built with CodeIgniter 4, MySQL, and Docker.

## 🌟 Key Features

### Public Access
- **No Login Required** - Browse and view all courses, modules, and lessons without creating an account
- **Free Access** - All courses are completely free
- **Public Course Catalog** - Anyone can explore any course content
- **Any Subject** - Not limited to programming - learn any topic you want

### For Students
- **User Authentication** (optional): Registration, email verification, login, password reset, OAuth (Google/Facebook)
- **Course Browsing**: Public course catalog with search and filtering - no login required
- **Enrollment**: One-click enrollment for tracking progress (requires login)
- **Learning**: Rich lesson content with examples, exercises, and interactive materials
- **Exercises**: Practice exercises and assignments (requires login for submission)
- **Progress Tracking**: Lesson completion, course progress, overall statistics (requires login)
- **Bookmarks**: Save favorite lessons (requires login)
- **Dashboard**: Personal learning dashboard with statistics (requires login)

### For Instructors
- **Instructor Dashboard**: Course overview and statistics
- **Course Creation**: Full course management
- **Content Management**: Modules, lessons, exercises
- **Rich Text Editor**: WYSIWYG editor for lesson content
- **Image Upload**: Direct image upload in editor
- **Enrollment Statistics**: Track student enrollments

### For Admins
- **Admin Dashboard**: System-wide statistics and overview
- **User Management**: Full CRUD for users, role management
- **Course Management**: Manage all courses
- **Content Management**: Full content management capabilities
- **System Monitoring**: Recent activity, user statistics

### Technical Features
- **Responsive Design**: Fully responsive, mobile-friendly
- **Security**: CSRF protection, XSS protection, SQL injection prevention
- **Performance**: Optimized queries, efficient data loading
- **Flexible Content**: Designed to support any subject or topic

## Technology Stack

- **Backend**: CodeIgniter 4 (PHP 8.2)
- **Database**: MySQL 8.0
- **Frontend**: Bootstrap 5, HTML5, CSS3, JavaScript
- **Containerization**: Docker & Docker Compose
- **Server**: Apache

## Prerequisites

- Docker Desktop installed and running
- Docker Compose (usually included with Docker Desktop)
- Git (optional, for cloning the repository)

## Quick Start

### Automated Setup

1. **Run the setup script**:
   ```bash
   chmod +x setup.sh
   ./setup.sh
   ```

   This script will:
   - Build Docker containers
   - Install Composer dependencies
   - Run database migrations
   - Seed the database with sample data (Python and JavaScript courses)
   - Set proper file permissions

2. **Access the application**:
   - Application: http://localhost:8080
   - MySQL: localhost:3306

### Manual Setup

If you prefer to set up manually:

1. **Build and start containers**:
   ```bash
   docker-compose up -d --build
   ```

2. **Install dependencies**:
   ```bash
   docker-compose exec web composer install
   ```

3. **Run migrations**:
   ```bash
   docker-compose exec web php spark migrate
   ```

4. **Seed database**:
   ```bash
   docker-compose exec web php spark db:seed DatabaseSeeder
   ```

## Usage

### Public Access

- **Browse Courses**: Visit http://localhost:8080/courses to see all available courses
- **View Lessons**: Click on any course to view its modules and lessons
- **No Registration Required**: All course content is publicly accessible

### With Account (Optional)

- **Create Account**: Register at http://localhost:8080/auth/register
- **Login**: Use email/password or OAuth (Google/Facebook)
- **Enroll in Courses**: Track your progress and save bookmarks
- **Submit Exercises**: Practice coding with interactive exercises

## Project Structure

```
learn-python/
├── app/
│   ├── Config/          # Configuration files
│   ├── Controllers/     # Application controllers
│   ├── Database/        # Migrations and seeders
│   ├── Models/          # Data models
│   ├── Views/           # View templates
│   └── Libraries/       # Custom libraries
├── public/              # Public web root
├── writable/            # Writable directories
├── docker-compose.yml   # Docker configuration
├── Dockerfile           # Docker image definition
└── README.md            # This file
```

## Current Courses

We're starting with programming courses, but the platform supports any subject:
- **Python Programming** - Beginner-friendly Python course
- **JavaScript Programming** - Beginner-friendly JavaScript course

More courses on various topics coming soon!

## Development

### Running Migrations

```bash
docker-compose exec web php spark migrate
```

### Running Seeders

```bash
docker-compose exec web php spark db:seed DatabaseSeeder
```

### Accessing the Database

```bash
docker-compose exec db mysql -u python_user -ppython_pass python_learn
```

## Deployment

See `DEPLOYMENT.md` for production deployment instructions.

**Production Domain**: https://learning.bandhanhara.com

## License

MIT License

---

**bandhanhara learning** - Free programming courses for everyone
