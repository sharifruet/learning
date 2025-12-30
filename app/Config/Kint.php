<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Kint extends BaseConfig
{
    /*
    |--------------------------------------------------------------------------
    | Kint
    |--------------------------------------------------------------------------
    |
    | We use Kint's RichRenderer and CLIRenderer. See the user guide at
    | https://kint-php.github.io/kint/ for details on configuring these.
    |
    */

    /**
     * Enable or disable Kint.
     *
     * @var bool
     */
    public $enabled = true;

    /*
     * ---------------------------------------------------------------
     * Display Settings
     * ---------------------------------------------------------------
     */
    public $plugins = null;
    public $maxDepth = 6;
    public $displayCalledFrom = true;
    public $expanded = false;

    /*
     * ---------------------------------------------------------------
     * RichRenderer Settings
     * ---------------------------------------------------------------
     */
    public $richTheme = 'aante-light.css';
    public $richFolder = false;
    public $richSort = 2; // SORT_FULL
    public $richObjectPlugins = null;
    public $richTabPlugins = null;

    /*
     * ---------------------------------------------------------------
     * CLI Settings
     * ---------------------------------------------------------------
     */
    public $cliColors = true;
    public $cliForceUTF8 = false;
    public $cliDetectWidth = true;
    public $cliMinWidth = 40;
}

