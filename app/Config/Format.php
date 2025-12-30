<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Format extends BaseConfig
{
    public $supportedResponseFormats = [
        'application/json',
        'application/xml',
        'application/yaml',
    ];

    public $formatters = [
        'application/json' => 'CodeIgniter\Format\JSONFormatter',
        'application/xml'  => 'CodeIgniter\Format\XMLFormatter',
    ];

    public $formatterOptions = [
        'application/json' => JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
        'application/xml'  => 0,
    ];
}

