<?php

/*
 |--------------------------------------------------------------------------
 | ERROR DISPLAY
 |--------------------------------------------------------------------------
 | In production, we don't want to show any errors because they don't
 | help the user. They'll just confuse them. Instead, we should log our
 | errors so we can fix them.
 */
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_WARNING);
ini_set('display_errors', '0');

/*
 |--------------------------------------------------------------------------
 | DEBUG MODE
 |--------------------------------------------------------------------------
 | Debug mode is an experimental flag that can allow additional
 | information to be shown during development.
 */
defined('CI_DEBUG') || define('CI_DEBUG', false);

