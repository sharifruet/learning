# Enable Error Logging

## Why Errors Might Not Be Logged

Errors might not be written to logs due to several reasons:

1. **PHP error logging not enabled** - PHP's `log_errors` might be off
2. **Log threshold too high** - Logger threshold might filter out errors
3. **Writable permissions** - `writable/logs/` directory might not be writable
4. **Error reporting suppression** - Suppressed error types won't be logged

## Quick Fix

### 1. Check/Update Production Boot File

The `app/Config/Boot/production.php` file should enable error logging:

```php
// Enable error logging to file
ini_set('log_errors', '1');
ini_set('error_log', WRITEPATH . 'logs/php_errors.log');
```

### 2. Verify Logger Configuration

In `app/Config/Logger.php`, ensure threshold allows errors:
- `threshold = 4` means log CRITICAL, ALERT, EMERGENCY, and ERROR levels
- This should be sufficient for errors

### 3. Verify Exceptions Configuration

In `app/Config/Exceptions.php`:
- `public $log = true;` - Should be `true` to log exceptions

### 4. Check Directory Permissions

On your FastComet server:
```bash
chmod -R 755 writable/logs/
```

Or via cPanel File Manager:
- Navigate to `writable/logs/`
- Right-click → Change Permissions → 755

### 5. Check Log Files

Logs should be in:
- `writable/logs/log-YYYY-MM-DD.log` (CodeIgniter logs)
- `writable/logs/php_errors.log` (PHP error log, if enabled)

## After Making Changes

1. Upload the updated `production.php` file
2. Verify permissions on `writable/logs/`
3. Trigger an error (or wait for one)
4. Check log files:
   - CodeIgniter logs: `writable/logs/log-YYYY-MM-DD.log`
   - PHP errors: `writable/logs/php_errors.log`

## Log Threshold Levels

- 0 = Emergency (system unusable)
- 1 = Alert (action must be taken)
- 2 = Critical (critical conditions)
- 3 = Error (error conditions)
- 4 = Warning (warning conditions)
- 5 = Notice (normal but significant)
- 6 = Info (informational)
- 7 = Debug (debug messages)

Threshold of 4 means: log levels 0-4 (Emergency through Warning)


