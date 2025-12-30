<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Setup how the exception handler works.
 */
class Exceptions extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * LOG EXCEPTIONS?
     * --------------------------------------------------------------------------
     * If true, then exceptions will be logged
     * through the Logging system.
     */
    public $log = true;

    /**
     * --------------------------------------------------------------------------
     * DO NOT LOG STATUS CODES
     * --------------------------------------------------------------------------
     * Any status codes here will NOT be logged if logging is turned on.
     * By default, only 404 (Page Not Found) exceptions are ignored.
     */
    public $ignoreCodes = [404];

    /**
     * --------------------------------------------------------------------------
     * Error Views Path
     * --------------------------------------------------------------------------
     * This is the path to the directory that contains the 'cli' and 'html'
     * directories that hold the views used to generate errors.
     *
     * This path defaults to APPPATH.'Views/errors' for native application error
     * views, and SYSTEMPATH.'ThirdParty/CodeIgniter/Views/errors' for error
     * views when any third-party PHP library or framework error views
     * are present.
     */
    public $errorViewPath = APPPATH . 'Views/errors';

    /**
     * --------------------------------------------------------------------------
     * HIDE TOKENS FROM TRACES?
     * --------------------------------------------------------------------------
     */
    public $sensitiveDataInTrace = [];

    /**
     * --------------------------------------------------------------------------
     * LOG DEPRECATIONS?
     * --------------------------------------------------------------------------
     */
    public $logDeprecations = false;

    /**
     * --------------------------------------------------------------------------
     * DEPRECATION LOG LEVEL
     * --------------------------------------------------------------------------
     */
    public $deprecationLogLevel = 7;
}

