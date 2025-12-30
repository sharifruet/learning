# Python Learning Platform - Phase 1 Complete

A comprehensive Learning Management System (LMS) for free, fully web-based courses. Built with CodeIgniter 4, MySQL, and Docker.

## 🎉 Phase 1 Status: Complete & Ready for Launch

Phase 1 has been successfully completed! The platform is now ready for public launch as a free, fully web-based learning platform.

## Features

### For Students
- **User Authentication**: Registration, email verification, login, password reset, OAuth (Google/Facebook)
- **Course Browsing**: Public course catalog with search and filtering
- **Enrollment**: One-click enrollment (no approval needed)
- **Learning**: Rich lesson content with code examples, syntax highlighting
- **Exercises**: Code submission and tracking
- **Progress Tracking**: Lesson completion, course progress, overall statistics
- **Bookmarks**: Save favorite lessons
- **Dashboard**: Personal learning dashboard with statistics

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
- **Accessibility**: WCAG 2.1 compliance considerations

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
   - Seed the database with sample data
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

5. **Set permissions**:
   ```bash
   docker-compose exec web chmod -R 755 writable
   ```

## Default Credentials

### Admin Account
- **Email**: admin@pythonlearn.com
- **Password**: admin123
- **Access**: Full admin panel access

### Student Account
- **Email**: student@pythonlearn.com
- **Password**: student123
- **Access**: Student dashboard and courses

## Project Structure

```
learn-python/
├── app/
│   ├── Config/          # Configuration files
│   ├── Controllers/     # Application controllers
│   │   └── Admin/       # Admin controllers
│   ├── Database/
│   │   ├── Migrations/  # Database migrations
│   │   └── Seeds/       # Database seeders
│   ├── Filters/         # Request filters
│   ├── Models/          # Data models
│   └── Views/           # View templates
│       ├── layouts/     # Layout templates
│       ├── auth/        # Authentication views
│       ├── admin/       # Admin panel views
│       ├── courses/     # Course views
│       └── lessons/     # Lesson views
├── public/              # Web root
│   ├── assets/          # CSS, JS, images
│   └── index.php        # Entry point
├── writable/            # Writable directories
├── docker-compose.yml   # Docker Compose configuration
├── Dockerfile           # Docker image definition
├── composer.json        # PHP dependencies
└── .env                 # Environment configuration
```

## Docker Commands

### Start containers
```bash
docker-compose up -d
```

### Stop containers
```bash
docker-compose down
```

### View logs
```bash
docker-compose logs -f
```

### Access web container shell
```bash
docker-compose exec web bash
```

### Access database
```bash
docker-compose exec db mysql -u python_user -ppython_pass python_learn
```

### Run CodeIgniter commands
```bash
docker-compose exec web php spark [command]
```

## CodeIgniter Commands

### Database Migrations
```bash
# Run all pending migrations
docker-compose exec web php spark migrate

# Rollback last migration
docker-compose exec web php spark migrate:rollback

# Refresh migrations
docker-compose exec web php spark migrate:refresh
```

### Database Seeding
```bash
# Seed all seeders
docker-compose exec web php spark db:seed DatabaseSeeder

# Seed specific seeder
docker-compose exec web php spark db:seed UserSeeder
```

### Clear Cache
```bash
docker-compose exec web php spark cache:clear
```

## Development

### Database Configuration

Database settings are in `.env` file:

```env
database.default.hostname = db
database.default.database = python_learn
database.default.username = python_user
database.default.password = python_pass
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### Environment Configuration

Edit `.env` file for environment-specific settings:
- `CI_ENVIRONMENT`: Set to `development`, `testing`, or `production`
- `app.baseURL`: Application base URL

### Adding New Features

1. **Create Migration**:
   ```bash
   docker-compose exec web php spark make:migration CreateTableName
   ```

2. **Create Model**:
   ```bash
   docker-compose exec web php spark make:model ModelName
   ```

3. **Create Controller**:
   ```bash
   docker-compose exec web php spark make:controller ControllerName
   ```

## Documentation

### User Guides
- **[Student Guide](docs/STUDENT_GUIDE.md)** - Complete guide for students
- **[Instructor Guide](docs/INSTRUCTOR_GUIDE.md)** - Guide for course creators
- **[Admin Guide](docs/ADMIN_GUIDE.md)** - Administrative documentation

### Technical Documentation
- **[Testing Checklist](docs/TESTING_CHECKLIST.md)** - Comprehensive testing guide
- **[Deployment Guide](docs/DEPLOYMENT_GUIDE.md)** - FastComet deployment procedures
- **[Launch Readiness Checklist](LAUNCH_READINESS_CHECKLIST.md)** - Pre-launch verification

### Implementation Summaries
- [Phase 1.1 Implementation](PHASE_1.1_IMPLEMENTATION.md)
- [Phase 1.2 Implementation](PHASE_1.2_IMPLEMENTATION.md)
- [Phase 1.3 Implementation](PHASE_1.3_IMPLEMENTATION.md)
- [Phase 1.4 Implementation](PHASE_1.4_IMPLEMENTATION.md)
- [Phase 1.5 Implementation](PHASE_1.5_IMPLEMENTATION.md)
- [Phase 1.6 Implementation](PHASE_1.6_IMPLEMENTATION.md)
- [Phase 1 Complete Summary](PHASE_1_COMPLETE_SUMMARY.md)

## Database Scripts

Utility scripts for database management (see [scripts/README.md](scripts/README.md)):

- `scripts/backup_database.sh` - Automated database backups
- `scripts/restore_database.sh` - Database restore utility
- `scripts/run_migrations.sh` - Migration runner

## Deployment to FastComet

See the comprehensive [Deployment Guide](docs/DEPLOYMENT_GUIDE.md) for detailed instructions.

Quick steps:
1. **Upload files** via FTP/SFTP
2. **Configure database** in FastComet control panel
3. **Update `.env`** with production settings
4. **Install dependencies**: `composer install --no-dev`
5. **Run migrations**: `php spark migrate`
6. **Set permissions**: `chmod -R 755 writable`
7. **Update `app.baseURL`** in `.env`

## Security Notes

- Change default passwords immediately
- Use strong passwords in production
- Keep dependencies updated
- Review and adjust file permissions
- Enable HTTPS in production
- Review CSRF settings
- Implement rate limiting for API endpoints (if added)

## Troubleshooting

### Port already in use
If port 8080 is already in use, edit `docker-compose.yml` and change the port mapping:
```yaml
ports:
  - "8081:80"  # Change 8080 to 8081
```

### Database connection errors
- Ensure MySQL container is running: `docker-compose ps`
- Check database credentials in `.env`
- Wait a few seconds after starting containers for MySQL to initialize

### Permission errors
```bash
docker-compose exec web chmod -R 755 writable
docker-compose exec web chown -R www-data:www-data writable
```

### Clear all data and start fresh
```bash
docker-compose down -v  # Removes volumes
docker-compose up -d --build
docker-compose exec web php spark migrate
docker-compose exec web php spark db:seed DatabaseSeeder
```

## License

This project is open source and available for educational purposes.

## Support

For issues and questions, please refer to:
- [CodeIgniter 4 Documentation](https://codeigniter.com/user_guide/)
- [FastComet Documentation](https://www.fastcomet.com/tutorials)

