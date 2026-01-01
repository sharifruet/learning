# Production Deployment Guide

## Deployment Target
**Domain**: https://learning.bandhanhara.com

## Pre-Deployment Checklist

### 1. Environment Configuration

#### Update `.env` file for production:

```env
# Application Environment
CI_ENVIRONMENT = production

# Base URL
app.baseURL = 'https://learning.bandhanhara.com/'

# Database Configuration (Update with production credentials)
database.default.hostname = localhost
database.default.database = your_production_db_name
database.default.username = your_production_db_user
database.default.password = your_production_db_password
database.default.port = 3306

# Google OAuth (Production)
GOOGLE_CLIENT_ID=your_production_google_client_id
GOOGLE_CLIENT_SECRET=your_production_google_client_secret
GOOGLE_REDIRECT_URI=https://learning.bandhanhara.com/auth/google/callback

# Facebook OAuth (Production)
FACEBOOK_APP_ID=your_production_facebook_app_id
FACEBOOK_APP_SECRET=your_production_facebook_app_secret
FACEBOOK_REDIRECT_URI=https://learning.bandhanhara.com/auth/facebook/callback

# Security
encryption.key = your_production_encryption_key_here
```

#### Generate Encryption Key:
```bash
php spark key:generate
```

### 2. OAuth Provider Configuration

#### Google Cloud Console:
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Navigate to your OAuth 2.0 Client ID
3. Add authorized redirect URI: `https://learning.bandhanhara.com/auth/google/callback`
4. Update authorized JavaScript origins: `https://learning.bandhanhara.com`

#### Facebook Developers:
1. Go to [Facebook Developers](https://developers.facebook.com/)
2. Navigate to your app settings
3. Add to **Valid OAuth Redirect URIs**: `https://learning.bandhanhara.com/auth/facebook/callback`
4. Update **Site URL**: `https://learning.bandhanhara.com`
5. If app is in Development Mode, add your domain or switch to Live mode

### 3. CodeIgniter Configuration

#### Update `app/Config/App.php`:
```php
public string $baseURL = 'https://learning.bandhanhara.com/';
```

Or set via `.env`:
```env
app.baseURL = 'https://learning.bandhanhara.com/'
```

### 4. Server Requirements

- PHP 8.1 or higher
- MySQL 8.0 or higher
- Apache with mod_rewrite enabled
- SSL Certificate (HTTPS required)
- Composer installed

### 5. File Permissions

Set correct permissions on writable directories:
```bash
chmod -R 775 writable/
chown -R www-data:www-data writable/
```

### 6. Database Setup

1. Create production database
2. Run migrations:
```bash
php spark migrate
```

3. (Optional) Run seeders for initial data:
```bash
php spark db:seed DatabaseSeeder
```

### 7. Apache Configuration

#### Virtual Host Configuration:

```apache
<VirtualHost *:80>
    ServerName learning.bandhanhara.com
    Redirect permanent / https://learning.bandhanhara.com/
</VirtualHost>

<VirtualHost *:443>
    ServerName learning.bandhanhara.com
    DocumentRoot /var/www/html/public
    
    SSLEngine on
    SSLCertificateFile /path/to/ssl/certificate.crt
    SSLCertificateKeyFile /path/to/ssl/private.key
    SSLCertificateChainFile /path/to/ssl/chain.crt
    
    <Directory /var/www/html/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/learning_error.log
    CustomLog ${APACHE_LOG_DIR}/learning_access.log combined
</VirtualHost>
```

#### Enable mod_rewrite:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 8. Security Hardening

1. **Disable Debug Mode**:
   - Ensure `CI_ENVIRONMENT = production` in `.env`
   - Set `app.CI_DEBUG = false`

2. **Update `.htaccess` in `public/`**:
   - Ensure it's properly configured for production

3. **Set Secure Cookies**:
   - Update `app/Config/Cookie.php`:
   ```php
   public bool $secure = true; // HTTPS only
   public string $sameSite = 'Lax';
   ```

4. **CSRF Protection**:
   - Ensure CSRF is enabled in `app/Config/Security.php`

5. **Session Security**:
   - Update `app/Config/Session.php`:
   ```php
   public string $cookieName = 'ci_session';
   public bool $cookieSecure = true; // HTTPS only
   public string $cookieSameSite = 'Lax';
   ```

### 9. Performance Optimization

1. **Enable OpCache** (if using PHP-FPM):
   ```ini
   opcache.enable=1
   opcache.memory_consumption=128
   opcache.max_accelerated_files=10000
   ```

2. **Enable Caching**:
   - Configure cache in `app/Config/Cache.php`
   - Use Redis or Memcached for production

3. **Minify Assets** (if applicable):
   - Minify CSS and JavaScript files
   - Enable gzip compression

### 10. Backup Strategy

1. **Database Backups**:
   ```bash
   mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql
   ```

2. **File Backups**:
   - Backup `writable/` directory
   - Backup `.env` file (securely)

### 11. Monitoring

1. **Error Logging**:
   - Monitor `writable/logs/` directory
   - Set up log rotation

2. **Application Monitoring**:
   - Consider using monitoring tools (e.g., New Relic, Sentry)
   - Monitor database performance
   - Monitor server resources

### 12. Deployment Steps

1. **Upload Files**:
   ```bash
   # Exclude development files
   rsync -avz --exclude '.git' --exclude 'node_modules' \
     --exclude '.env' --exclude 'writable/logs/*' \
     ./ user@server:/var/www/html/
   ```

2. **Set Environment**:
   - Upload `.env` file securely (use SFTP/SCP)
   - Never commit `.env` to version control

3. **Install Dependencies**:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

4. **Run Migrations**:
   ```bash
   php spark migrate
   ```

5. **Set Permissions**:
   ```bash
   chmod -R 775 writable/
   chown -R www-data:www-data writable/
   ```

6. **Clear Cache**:
   ```bash
   php spark cache:clear
   ```

7. **Test Application**:
   - Test login/registration
   - Test OAuth flows
   - Test course browsing
   - Test admin functions

### 13. Post-Deployment

1. **Verify HTTPS**:
   - Ensure all pages load over HTTPS
   - Check for mixed content warnings

2. **Test OAuth**:
   - Test Google login
   - Test Facebook login
   - Verify redirect URIs work correctly

3. **Check Error Logs**:
   - Monitor for any errors
   - Check Apache error logs
   - Check application logs

4. **Performance Check**:
   - Test page load times
   - Check database query performance
   - Monitor server resources

### 14. Rollback Plan

If issues occur:

1. **Restore Database**:
   ```bash
   mysql -u username -p database_name < backup.sql
   ```

2. **Restore Files**:
   - Restore from backup
   - Revert to previous version

3. **Clear Cache**:
   ```bash
   php spark cache:clear
   ```

## FastComet Hosting Specific Notes

Since you're deploying to FastComet:

1. **cPanel Access**:
   - Use cPanel to manage databases
   - Use cPanel File Manager for file uploads
   - Use cPanel SSL/TLS for SSL certificates

2. **Database**:
   - Create database via cPanel MySQL Databases
   - Note the database name format: `username_dbname`
   - Use cPanel database credentials

3. **PHP Version**:
   - Set PHP version to 8.1+ via cPanel Select PHP Version
   - Enable required extensions: pdo_mysql, mbstring, exif, pcntl, bcmath, gd, intl, mysqli

4. **File Upload**:
   - Upload files via cPanel File Manager or FTP
   - Ensure `.htaccess` in `public/` is uploaded

5. **SSL Certificate**:
   - Use Let's Encrypt SSL via cPanel SSL/TLS
   - Enable Force HTTPS Redirect

6. **Cron Jobs** (if needed):
   - Set up via cPanel Cron Jobs
   - Example: Database backups, cache clearing

## Troubleshooting

### Common Issues:

1. **500 Internal Server Error**:
   - Check file permissions
   - Check `.htaccess` configuration
   - Check error logs

2. **Database Connection Error**:
   - Verify database credentials in `.env`
   - Check database host (might be `localhost` or specific host)
   - Verify database exists

3. **OAuth Not Working**:
   - Verify redirect URIs match exactly
   - Check OAuth credentials in `.env`
   - Ensure HTTPS is enabled

4. **Permission Denied**:
   - Check `writable/` directory permissions
   - Ensure web server user has write access

5. **CSS/JS Not Loading**:
   - Check `baseURL` configuration
   - Verify asset paths
   - Check `.htaccess` rewrite rules

## Support

For issues:
1. Check error logs in `writable/logs/`
2. Check Apache error logs
3. Enable debug mode temporarily (remember to disable after)
4. Check CodeIgniter documentation

---

**Last Updated**: 2024-12-30
**Domain**: https://learning.bandhanhara.com

