# FastComet Shared Hosting Deployment Guide

This guide will help you deploy the Learning Management System to FastComet shared hosting.

## Pre-Deployment Checklist

### 1. FastComet Account Setup
- [ ] Access FastComet cPanel
- [ ] Note your domain name (e.g., `learning.bandhanhara.com`)
- [ ] Get your cPanel login credentials
- [ ] Verify PHP version (needs 8.1+)
- [ ] Create MySQL database via cPanel

### 2. Database Setup

1. **Create Database in cPanel**:
   - Go to cPanel → MySQL Databases
   - Create a new database (e.g., `username_pythonlearn`)
   - Create a database user with a strong password
   - Add user to database with ALL PRIVILEGES
   - **Note down**: Database name, username, password, hostname (usually `localhost`)

2. **Database Credentials Format**:
   ```
   Database Name: username_pythonlearn
   Database User: username_dbuser
   Database Password: your_strong_password
   Database Host: localhost (or provided by FastComet)
   ```

### 3. File Structure on FastComet

On FastComet, your files typically go in:
```
/home/username/public_html/  (or subdomain directory)
```

For this application, you have two options:

**Option A: Root Domain (Recommended)**
- Upload all files to `public_html/`
- Set `public/` as document root (via cPanel → Domains → Document Root)

**Option B: Subdomain**
- Upload files to `public_html/subdomain/` or subdomain directory
- Application will be at `subdomain.yourdomain.com`

## Step-by-Step Deployment

### Step 1: Prepare Files Locally

1. **Export Database from Local Docker**:
   ```bash
   docker-compose exec db mysqldump -uroot -prootpassword python_learn > production_backup.sql
   ```

2. **Create Deployment Package**:
   ```bash
   # In your project root
   tar -czf deployment.tar.gz \
     --exclude='.git' \
     --exclude='node_modules' \
     --exclude='.env' \
     --exclude='writable/logs/*' \
     --exclude='writable/session/*' \
     --exclude='writable/uploads/*' \
     --exclude='writable/debugbar/*' \
     --exclude='.DS_Store' \
     --exclude='docker-compose.yml' \
     --exclude='Dockerfile' \
     --exclude='apache-config.conf' \
     .
   ```

### Step 2: Upload Files to FastComet

**Method 1: cPanel File Manager**
1. Log in to cPanel
2. Go to File Manager
3. Navigate to `public_html/` (or your domain directory)
4. Upload `deployment.tar.gz`
5. Extract it (right-click → Extract)

**Method 2: FTP/SFTP**
1. Use FileZilla or similar FTP client
2. Connect using FTP credentials from cPanel
3. Upload all files to `public_html/`
4. Ensure `.htaccess` files are uploaded

**Method 3: Git (if available)**
```bash
# On FastComet via SSH (if available)
cd ~/public_html
git clone your-repository-url .
composer install --no-dev --optimize-autoloader
```

### Step 3: Configure Document Root and .htaccess

You have two options:

**Option A: Set Document Root to public/ (RECOMMENDED - More Secure)**

1. In cPanel → Domains → Manage Domains
2. Find your domain
3. Change Document Root to: `public_html/public` (or your path)
4. Save
5. **Use**: `public/.htaccess` file (already included in deployment)
6. **Delete or ignore**: Root-level `.htaccess` file (not needed in this setup)

This is the recommended approach as it keeps sensitive directories (app/, writable/, vendor/) outside the web-accessible directory.

**Option B: Use Root-Level .htaccess (Alternative - if document root cannot be changed)**

If you cannot change the document root in cPanel (some shared hosting restrictions):

1. Keep document root as: `public_html/` (default)
2. **Use**: Root-level `.htaccess` file (already included in deployment package)
3. This file redirects all requests to `public/` directory
4. This file also protects sensitive directories from direct access

The root-level `.htaccess` is included in your deployment package for this scenario.

### Step 4: Configure Environment

1. **Create `.env` file** in the root directory:
   ```env
   #--------------------------------------------------------------------
   # ENVIRONMENT
   #--------------------------------------------------------------------
   CI_ENVIRONMENT = production
   
   #--------------------------------------------------------------------
   # APP
   #--------------------------------------------------------------------
   app.baseURL = 'https://learning.bandhanhara.com/'
   
   #--------------------------------------------------------------------
   # DATABASE
   #--------------------------------------------------------------------
   database.default.hostname = localhost
   database.default.database = username_pythonlearn
   database.default.username = username_dbuser
   database.default.password = your_database_password
   database.default.DBDriver = MySQLi
   database.default.port = 3306
   
   #--------------------------------------------------------------------
   # SECURITY
   #--------------------------------------------------------------------
   encryption.key = 
   
   # Generate key: php spark key:generate
   ```

2. **Generate Encryption Key** (via cPanel Terminal or SSH):
   ```bash
   cd ~/public_html
   php spark key:generate
   ```
   This will add the encryption key to your `.env` file.

### Step 5: Set PHP Version

**IMPORTANT**: Use PHP 8.3 (NOT 8.4) due to compatibility issues with Parsedown library.

1. In cPanel → Select PHP Version
2. Choose **PHP 8.3** (recommended - avoids PHP 8.4 deprecation warnings)
   - PHP 8.1 or 8.2 also work, but 8.3 is recommended
   - **Avoid PHP 8.4** until vendor libraries are updated
3. Enable required extensions:
   - `pdo_mysql`
   - `mysqli`
   - `mbstring`
   - `exif`
   - `pcntl`
   - `bcmath`
   - `gd`
   - `intl`
   - `curl`
   - `openssl`

### Step 6: Set File Permissions

Via cPanel File Manager or SSH:
```bash
cd ~/public_html
chmod -R 755 writable/
chmod 644 .env
chmod 644 public/.htaccess
```

### Step 7: Install Dependencies

If Composer is available via cPanel Terminal or SSH:
```bash
cd ~/public_html
composer install --no-dev --optimize-autoloader
```

**Note**: If Composer is not available on FastComet:
- Install dependencies locally
- Upload the `vendor/` folder along with other files

### Step 8: Import Database

**Method 1: cPanel phpMyAdmin**
1. Go to cPanel → phpMyAdmin
2. Select your database
3. Click Import
4. Choose `production_backup.sql`
5. Click Go

**Method 2: Via SSH**:
```bash
mysql -u username_dbuser -p username_pythonlearn < production_backup.sql
```

### Step 9: Run Migrations (if needed)

If you need to run migrations (usually not needed if you imported the full database):

Via cPanel Terminal or SSH:
```bash
cd ~/public_html
php spark migrate
```

### Step 10: Configure SSL/HTTPS

1. Go to cPanel → SSL/TLS
2. Install Let's Encrypt SSL certificate
3. Enable Force HTTPS Redirect
4. Update `.env` to use HTTPS URLs

### Step 11: Configure .htaccess

**IMPORTANT**: The `.htaccess` file MUST be uploaded to your server. It's located at `public/.htaccess`.

If the file doesn't exist, create it with the following content:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>
```

### Step 12: Test the Application

1. Visit your domain: `https://learning.bandhanhara.com`
2. Test:
   - [ ] Homepage loads
   - [ ] Course catalog displays
   - [ ] Can view courses
   - [ ] Can register/login
   - [ ] Can view lessons
   - [ ] Admin panel accessible
   - [ ] Images/assets load correctly

## Important FastComet-Specific Notes

### Document Root Considerations

FastComet typically uses `public_html/` as the document root. Since CodeIgniter uses a `public/` directory, you have options:

1. **Set public as document root** (RECOMMENDED - More Secure):
   - Change document root in cPanel to point to `public/` subdirectory
   - Use `public/.htaccess` file (already included)
   - All files stay in place
   - Sensitive files (app/, writable/, vendor/) are not accessible via web

2. **Use root-level .htaccess** (Alternative - if document root cannot be changed):
   - Keep document root as `public_html/`
   - Use root-level `.htaccess` (included in deployment) that redirects to `public/`
   - This file prevents direct access to sensitive directories
   - Use this only if you cannot change the document root in cPanel

3. **Move public contents to root** (NOT RECOMMENDED - Less Secure):
   - Move `public/*` to root directory
   - Move `public/.htaccess` to root
   - This exposes your directory structure
   - Only use if other options are not available

### PHP Configuration

- FastComet supports PHP 8.1+ via cPanel
- Some PHP functions might be disabled (check `phpinfo()`)
- Upload limits: Usually 64MB (can be increased via php.ini)

### Database Connection

- Database host is usually `localhost`
- Some FastComet plans use a remote database server
- Check cPanel MySQL Databases section for the correct hostname

### Composer Installation

- FastComet may not have Composer installed by default
- Options:
  1. Install via SSH (if SSH access available)
  2. Install dependencies locally and upload `vendor/` folder
  3. Request FastComet support to install Composer

## Troubleshooting

### 500 Internal Server Error

1. Check error logs in `writable/logs/`
2. Check cPanel Error Log
3. Verify `.htaccess` exists and is correct
4. Check file permissions (especially `writable/`)
5. Verify PHP version (must be 8.1+)

### Database Connection Error

1. Verify database credentials in `.env`
2. Check database host (might not be `localhost`)
3. Verify database user has proper permissions
4. Test connection via cPanel MySQL Databases

### CSS/JS Not Loading

1. Check `app.baseURL` in `.env`
2. Verify `.htaccess` rewrite rules
3. Check browser console for 404 errors
4. Ensure assets are in `public/assets/`

### Permission Denied

1. Check `writable/` directory permissions (755)
2. Check `.env` file permissions (644)
3. Verify web server can read/write to `writable/`

### Blank Page / White Screen

1. Enable error display temporarily in `app/Config/Exceptions.php`
2. Check `writable/logs/` for errors
3. Verify PHP version compatibility
4. Check if all required PHP extensions are enabled

## Post-Deployment Tasks

1. **Disable Debug Mode**:
   - Ensure `CI_ENVIRONMENT = production` in `.env`
   - Clear cache: `php spark cache:clear`

2. **Set Up Backups**:
   - Configure database backups via cPanel
   - Set up file backups (especially `writable/uploads/`)

3. **Monitor Logs**:
   - Check `writable/logs/` regularly
   - Monitor cPanel Error Log

4. **Performance**:
   - Enable caching if available
   - Optimize database queries
   - Consider CDN for static assets

## Quick Deployment Script

If you have SSH access, you can use this script:

```bash
#!/bin/bash
# Save as deploy.sh

cd ~/public_html

# Set permissions
chmod -R 755 writable/
chmod 644 .env

# Install dependencies (if composer available)
# composer install --no-dev --optimize-autoloader

# Run migrations (if needed)
# php spark migrate

# Clear cache
php spark cache:clear

echo "Deployment complete!"
```

Make it executable:
```bash
chmod +x deploy.sh
./deploy.sh
```

## Support

- FastComet Support: https://www.fastcomet.com/support
- CodeIgniter 4 Docs: https://codeigniter.com/user_guide/
- Check error logs: `writable/logs/`

---

**Last Updated**: 2024-01-02

