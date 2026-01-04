<?php

/*
 |--------------------------------------------------------------------------
 | ERROR DISPLAY
 |--------------------------------------------------------------------------
 | In production, we don't want to show any errors because they don't
 | help the user. They'll just confuse them. Instead, we should log our
 | errors so we can fix them.
 */
// Suppress deprecation warnings from vendor libraries (PHP 8.4 compatibility)
// E_DEPRECATED is suppressed to handle third-party library issues (e.g., Parsedown)
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING & ~E_STRICT);

// Error display - set to '0' for production (after debugging)
ini_set('display_errors', '1');

// Enable error logging to file (important for debugging)
// Note: CodeIgniter's logger handles most errors, but PHP errors need this
ini_set('log_errors', '1');
// WRITEPATH is defined later, so use relative path from app directory
ini_set('error_log', __DIR__ . '/../../writable/logs/php_errors.log');

/*
 |--------------------------------------------------------------------------
 | DEBUG MODE
 |--------------------------------------------------------------------------
 | Debug mode is an experimental flag that can allow additional
 | information to be shown during development.
 */
defined('CI_DEBUG') || define('CI_DEBUG', false);

