# Production Deployment Checklist

## Pre-Deployment

### Configuration Files
- [ ] Update `.env` file with production values
- [ ] Set `CI_ENVIRONMENT = production`
- [ ] Update `app.baseURL = 'https://learning.bandhanhara.com/'`
- [ ] Generate encryption key: `php spark key:generate`
- [ ] Update database credentials
- [ ] Configure OAuth redirect URIs

### OAuth Setup
- [ ] Google OAuth: Add `https://learning.bandhanhara.com/auth/google/callback` to authorized redirect URIs
- [ ] Google OAuth: Add `https://learning.bandhanhara.com` to authorized JavaScript origins
- [ ] Facebook OAuth: Add `https://learning.bandhanhara.com/auth/facebook/callback` to Valid OAuth Redirect URIs
- [ ] Facebook OAuth: Update Site URL to `https://learning.bandhanhara.com`
- [ ] Facebook OAuth: Switch app to Live mode (if ready)

### Server Setup
- [ ] PHP 8.1+ installed
- [ ] MySQL 8.0+ installed
- [ ] Apache with mod_rewrite enabled
- [ ] SSL certificate installed
- [ ] Required PHP extensions enabled:
  - [ ] pdo_mysql
  - [ ] mbstring
  - [ ] exif
  - [ ] pcntl
  - [ ] bcmath
  - [ ] gd
  - [ ] intl
  - [ ] mysqli

### Database
- [ ] Create production database
- [ ] Create database user with proper permissions
- [ ] Backup existing database (if any)

## Deployment

### File Upload
- [ ] Upload all application files
- [ ] Exclude `.git`, `node_modules`, `.env` from upload
- [ ] Upload `.htaccess` file to `public/` directory
- [ ] Upload `.env` file securely (via SFTP/SCP)

### Dependencies
- [ ] Run `composer install --no-dev --optimize-autoloader`
- [ ] Verify all dependencies installed correctly

### Database
- [ ] Run migrations: `php spark migrate`
- [ ] (Optional) Run seeders: `php spark db:seed DatabaseSeeder`

### Permissions
- [ ] Set `writable/` directory permissions: `chmod -R 775 writable/`
- [ ] Set ownership: `chown -R www-data:www-data writable/`
- [ ] Verify web server can write to `writable/` directories

### Configuration
- [ ] Verify `.env` file is not accessible via web
- [ ] Update `app/Config/App.php` baseURL (or via .env)
- [ ] Configure secure cookies in `app/Config/Cookie.php`
- [ ] Configure secure sessions in `app/Config/Session.php`

### Apache Configuration
- [ ] Configure virtual host
- [ ] Enable HTTPS redirect
- [ ] Configure SSL certificate
- [ ] Enable mod_rewrite
- [ ] Set DocumentRoot to `public/` directory
- [ ] Restart Apache

### Security
- [ ] Disable debug mode: `CI_DEBUG = false`
- [ ] Enable force HTTPS: `forceGlobalSecureRequests = true`
- [ ] Verify CSRF protection is enabled
- [ ] Check file permissions
- [ ] Remove development files

## Post-Deployment Testing

### Basic Functionality
- [ ] Home page loads correctly
- [ ] HTTPS redirect works
- [ ] No mixed content warnings
- [ ] CSS/JS files load correctly

### Authentication
- [ ] User registration works
- [ ] Email verification works
- [ ] User login works
- [ ] Password reset works
- [ ] Google OAuth login works
- [ ] Facebook OAuth login works
- [ ] Logout works

### Application Features
- [ ] Course listing works
- [ ] Course viewing works
- [ ] Lesson viewing works
- [ ] Dashboard loads correctly
- [ ] Admin panel accessible (if admin user exists)

### OAuth Testing
- [ ] Google login redirects correctly
- [ ] Google callback works
- [ ] Facebook login redirects correctly
- [ ] Facebook callback works
- [ ] OAuth users can access dashboard
- [ ] OAuth users have correct permissions

### Error Handling
- [ ] 404 errors display correctly
- [ ] Error pages don't expose sensitive information
- [ ] Error logs are being written

## Monitoring & Maintenance

### Logs
- [ ] Check application logs: `writable/logs/`
- [ ] Check Apache error logs
- [ ] Set up log rotation

### Performance
- [ ] Test page load times
- [ ] Check database query performance
- [ ] Monitor server resources (CPU, Memory, Disk)

### Backups
- [ ] Set up database backup schedule
- [ ] Set up file backup schedule
- [ ] Test backup restoration

### Security
- [ ] Regular security updates
- [ ] Monitor for suspicious activity
- [ ] Review error logs regularly
- [ ] Keep dependencies updated

## FastComet Specific

### cPanel Configuration
- [ ] PHP version set to 8.1+
- [ ] Required PHP extensions enabled
- [ ] Database created via cPanel
- [ ] SSL certificate installed via cPanel
- [ ] Force HTTPS enabled

### File Management
- [ ] Files uploaded via cPanel File Manager or FTP
- [ ] File permissions set correctly
- [ ] `.htaccess` file in place

### Database
- [ ] Database created via cPanel MySQL Databases
- [ ] Database user created with proper permissions
- [ ] Database credentials noted

## Rollback Plan

If deployment fails:
- [ ] Restore database from backup
- [ ] Restore files from backup
- [ ] Clear cache: `php spark cache:clear`
- [ ] Verify application works
- [ ] Document issues for next deployment

---

**Deployment Date**: _______________
**Deployed By**: _______________
**Domain**: https://learning.bandhanhara.com

