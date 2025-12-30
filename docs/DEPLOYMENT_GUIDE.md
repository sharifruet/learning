# Deployment Guide - Python Learning Platform

This guide covers deploying the platform to FastComet shared hosting.

## Table of Contents
1. [Pre-Deployment Checklist](#pre-deployment-checklist)
2. [Environment Setup](#environment-setup)
3. [Database Setup](#database-setup)
4. [File Upload](#file-upload)
5. [Configuration](#configuration)
6. [Database Migration](#database-migration)
7. [Post-Deployment](#post-deployment)
8. [Backup Procedures](#backup-procedures)
9. [Troubleshooting](#troubleshooting)

## Pre-Deployment Checklist

### Requirements Verification

- [ ] FastComet hosting account active
- [ ] Domain name configured
- [ ] PHP 8.1+ available
- [ ] MySQL database access
- [ ] SSH access (preferred)
- [ ] SSL certificate installed
- [ ] FTP/SFTP access

### Code Preparation

- [ ] All code committed to Git
- [ ] All migrations tested locally
- [ ] Environment variables documented
- [ ] Configuration files ready
- [ ] Dependencies installed (`composer install --no-dev`)

### Testing

- [ ] All tests passed locally
- [ ] Database migrations tested
- [ ] File uploads tested
- [ ] Email sending tested
- [ ] All features verified

## Environment Setup

### 1. Create Production Environment File

Create `.env` file on production server:

```env
#--------------------------------------------------------------------
# ENVIRONMENT
#--------------------------------------------------------------------
CI_ENVIRONMENT = production

#--------------------------------------------------------------------
# APP
#--------------------------------------------------------------------
app.baseURL = 'https://yourdomain.com/'
app.forceGlobalSecureRequests = true

#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------
database.default.hostname = localhost
database.default.database = your_database_name
database.default.username = your_database_user
database.default.password = your_database_password
database.default.DBDriver = MySQLi
database.default.port = 3306

#--------------------------------------------------------------------
# EMAIL
#--------------------------------------------------------------------
email.SMTPHost = mail.bandhanhara.com
email.SMTPUser = learning@bandhanhara.com
email.SMTPPass = !BadPassw0rd
email.SMTPPort = 587
email.SMTPCrypto = tls
email.fromEmail = learning@bandhanhara.com
email.fromName = Python Learning Platform

#--------------------------------------------------------------------
# SECURITY
#--------------------------------------------------------------------
security.csrfProtection = true
security.tokenRandomize = true
security.tokenName = csrf_token_name
security.headerName = X-CSRF-TOKEN
security.cookieName = csrf_cookie_name
security.expires = 7200
security.regenerate = true
security.redirect = true
security.samesite = Lax

#--------------------------------------------------------------------
# SESSION
#--------------------------------------------------------------------
session.driver = CodeIgniter\Session\Handlers\FileHandler
session.cookieName = ci_session
session.expiration = 7200
session.savePath = WRITEPATH . 'session'
session.matchIP = false
session.timeToUpdate = 300
session.regenerateDestroy = false
```

### 2. Set File Permissions

```bash
# Set writable directory permissions
chmod -R 755 writable/
chmod -R 755 writable/cache/
chmod -R 755 writable/logs/
chmod -R 755 writable/session/
chmod -R 755 writable/uploads/
chmod -R 755 writable/uploads/images/
```

### 3. Configure .htaccess

Ensure `.htaccess` file exists in `public/` directory:

```apache
# Disable directory browsing
Options -Indexes

# Rewrite engine
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Redirect to HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
    
    # Redirect Trailing Slashes
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]
    
    # Rewrite to index.php
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^([\s\S]*)$ index.php/$1 [L,NC,QSA]
    
    # Ensure Authorization header is passed
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
</IfModule>

# PHP Settings
<IfModule mod_php8.c>
    php_value upload_max_filesize 10M
    php_value post_max_size 10M
    php_value max_execution_time 300
    php_value max_input_time 300
    php_value memory_limit 256M
</IfModule>

# Security Headers
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
</IfModule>
```

## Database Setup

### 1. Create Database

Via cPanel or MySQL command line:

```sql
CREATE DATABASE your_database_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'your_database_user'@'localhost' IDENTIFIED BY 'your_database_password';
GRANT ALL PRIVILEGES ON your_database_name.* TO 'your_database_user'@'localhost';
FLUSH PRIVILEGES;
```

### 2. Export Local Database

```bash
# Export database
mysqldump -u python_user -p python_learn > database_backup.sql

# Or using Docker
docker-compose exec db mysqldump -u python_user -ppython_pass python_learn > database_backup.sql
```

### 3. Import to Production

```bash
# Via command line
mysql -u your_database_user -p your_database_name < database_backup.sql

# Or via phpMyAdmin
# 1. Login to phpMyAdmin
# 2. Select database
# 3. Click "Import"
# 4. Choose database_backup.sql
# 5. Click "Go"
```

## File Upload

### Option 1: FTP/SFTP

1. Connect via FTP client (FileZilla, WinSCP)
2. Upload all files to public_html (or subdirectory)
3. Maintain directory structure
4. Set correct permissions

### Option 2: Git Deployment

1. SSH into server
2. Navigate to web root
3. Clone repository:
   ```bash
   git clone your-repo-url .
   ```
4. Install dependencies:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

### Directory Structure

```
public_html/
├── app/
├── public/
│   ├── index.php
│   ├── .htaccess
│   └── assets/
├── writable/
├── vendor/
├── .env
├── composer.json
└── spark
```

## Configuration

### 1. Update Base URL

In `.env`:
```env
app.baseURL = 'https://yourdomain.com/'
```

### 2. Database Configuration

Update database credentials in `.env`:
```env
database.default.hostname = localhost
database.default.database = your_database_name
database.default.username = your_database_user
database.default.password = your_database_password
```

### 3. Email Configuration

Already configured for FastComet:
```env
email.SMTPHost = mail.bandhanhara.com
email.SMTPUser = learning@bandhanhara.com
email.SMTPPass = !BadPassw0rd
email.SMTPPort = 587
email.SMTPCrypto = tls
```

### 4. Security Settings

Ensure production security:
```env
CI_ENVIRONMENT = production
app.forceGlobalSecureRequests = true
security.csrfProtection = true
```

## Database Migration

### Run Migrations

Via SSH:
```bash
php spark migrate
```

Or via web (if migration route enabled):
```
https://yourdomain.com/migrate
```

### Verify Migrations

Check migration status:
```bash
php spark migrate:status
```

## Post-Deployment

### 1. Verify Installation

- [ ] Homepage loads correctly
- [ ] Login works
- [ ] Database connection works
- [ ] File uploads work
- [ ] Email sending works

### 2. Test Critical Features

- [ ] User registration
- [ ] Email verification
- [ ] Course enrollment
- [ ] Lesson viewing
- [ ] Exercise submission
- [ ] Admin panel access

### 3. Performance Check

- [ ] Page load times acceptable
- [ ] Database queries optimized
- [ ] Images optimized
- [ ] Caching enabled (if applicable)

### 4. Security Check

- [ ] HTTPS enabled
- [ ] CSRF protection working
- [ ] XSS protection working
- [ ] SQL injection prevention
- [ ] File upload security

## Backup Procedures

### Database Backup Script

Create `backup_database.sh`:

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/path/to/backups"
DB_NAME="your_database_name"
DB_USER="your_database_user"
DB_PASS="your_database_password"

# Create backup directory if it doesn't exist
mkdir -p $BACKUP_DIR

# Create backup
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_backup_$DATE.sql.gz

# Keep only last 7 days of backups
find $BACKUP_DIR -name "db_backup_*.sql.gz" -mtime +7 -delete

echo "Backup completed: db_backup_$DATE.sql.gz"
```

### Automated Backups

Add to crontab (daily at 2 AM):
```bash
0 2 * * * /path/to/backup_database.sh
```

### File Backup

Backup important directories:
```bash
tar -czf files_backup_$(date +%Y%m%d).tar.gz writable/uploads/
```

### Restore Backup

```bash
# Restore database
gunzip < db_backup_YYYYMMDD_HHMMSS.sql.gz | mysql -u user -p database_name

# Restore files
tar -xzf files_backup_YYYYMMDD.tar.gz
```

## Troubleshooting

### Common Issues

**500 Internal Server Error:**
- Check `.htaccess` file
- Verify file permissions
- Check error logs
- Verify PHP version

**Database Connection Error:**
- Verify database credentials
- Check database server status
- Verify user permissions
- Check firewall settings

**File Upload Not Working:**
- Check directory permissions
- Verify upload_max_filesize
- Check disk space
- Verify .htaccess rules

**Email Not Sending:**
- Verify SMTP credentials
- Check email server status
- Verify port 587 is open
- Check spam folder

**Migration Errors:**
- Verify database user permissions
- Check migration files
- Review error logs
- Run migrations one at a time

### Error Logs

**CodeIgniter Logs:**
```
writable/logs/log-YYYY-MM-DD.log
```

**PHP Error Log:**
Check cPanel error logs or:
```
/var/log/php_errors.log
```

**Apache Error Log:**
```
/var/log/apache2/error.log
```

### Performance Optimization

**Enable OPcache:**
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=10000
```

**Enable Gzip Compression:**
Add to `.htaccess`:
```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>
```

## Maintenance

### Regular Tasks

**Daily:**
- Monitor error logs
- Check disk space
- Verify backups

**Weekly:**
- Review user activity
- Check performance metrics
- Update dependencies (if needed)

**Monthly:**
- Full system backup
- Security audit
- Performance review
- Update documentation

## Rollback Procedure

If deployment fails:

1. **Restore Database:**
   ```bash
   mysql -u user -p database < previous_backup.sql
   ```

2. **Restore Files:**
   ```bash
   git checkout previous-commit
   # Or restore from backup
   ```

3. **Verify Functionality:**
   - Test critical features
   - Check error logs
   - Verify database integrity

## Support

For deployment issues:
1. Check error logs
2. Review this guide
3. Check FastComet documentation
4. Contact hosting support
5. Review CodeIgniter documentation

---

**Deployment Complete!** 🚀

