# Troubleshooting Deployment Issues

## Common Issues and Solutions

### 1. Generic Error: "We seem to have hit a snag"

This is CodeIgniter's generic error page in production mode. To see the actual error:

**Option A: Check Error Logs (Recommended)**
```bash
# Via SSH or cPanel File Manager
cat writable/logs/log-YYYY-MM-DD.log

# Or check the latest log file
ls -lt writable/logs/ | head -5
```

**Option B: Temporarily Enable Error Display**

Edit `app/Config/Boot/production.php`:
```php
ini_set('display_errors', '1');  // Change from '0' to '1'
```

⚠️ **Remember to set it back to '0' after debugging!**

### 2. Deprecated E_STRICT Warning (FIXED)

✅ **Fixed in**: `app/Config/Boot/production.php`
- Removed `E_STRICT` from error_reporting (deprecated in PHP 8.1+)

### 3. Common Deployment Errors

#### Database Connection Error
**Symptoms**: Error mentions database connection
**Solution**:
- Check `.env` file database credentials
- Verify database host (may not be `localhost` on FastComet)
- Check database user permissions in cPanel

#### File Permission Errors
**Symptoms**: Cannot write to writable/ directory
**Solution**:
```bash
chmod -R 755 writable/
chmod 644 .env
```

#### Missing Vendor Directory
**Symptoms**: Class not found errors
**Solution**:
- Run `composer install --no-dev --optimize-autoloader`
- Or upload `vendor/` directory from local installation

#### Base URL Configuration
**Symptoms**: CSS/JS not loading, 404 errors
**Solution**:
- Check `.env` file: `app.baseURL = 'https://learning.bandhanhara.com/'`
- Ensure trailing slash is included

#### Missing Encryption Key
**Symptoms**: Session/cookie errors
**Solution**:
```bash
php spark key:generate
```

### 4. FastComet-Specific Issues

#### Document Root Path
- Verify document root points to `public/` subdirectory
- Check via cPanel → Domains → Manage Domains

#### PHP Version
- Ensure PHP 8.1+ is selected
- cPanel → Select PHP Version

#### Required PHP Extensions
Enable these extensions in cPanel → Select PHP Version:
- pdo_mysql
- mysqli
- mbstring
- exif
- pcntl
- bcmath
- gd
- intl
- curl
- openssl

## Quick Debugging Checklist

1. ✅ Check `writable/logs/` for error messages
2. ✅ Verify `.env` file exists and is configured
3. ✅ Check file permissions: `writable/` should be 755
4. ✅ Verify PHP version is 8.1+
5. ✅ Check database connection in `.env`
6. ✅ Verify `app.baseURL` matches your domain
7. ✅ Ensure `vendor/` directory exists
8. ✅ Check that `public/.htaccess` exists

## Getting More Details

### Enable Detailed Error Logging

Edit `app/Config/Exceptions.php`:
```php
public $log = true;  // Ensure this is true
```

### Check Apache Error Logs

Via cPanel → Error Log or check:
```
/home/username/logs/error_log
```

### Check PHP Error Log

Via cPanel → Error Log or check:
```
/home/username/logs/php_error_log
```

## Still Having Issues?

1. Check the latest log file in `writable/logs/`
2. Temporarily enable error display (see above)
3. Check cPanel error logs
4. Verify all files were uploaded correctly
5. Ensure database was imported successfully

