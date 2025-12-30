<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Logger extends BaseConfig
{
    public $threshold = 4;

    public $dateFormat = 'Y-m-d H:i:s';

    public $handlers = [
        'CodeIgniter\Log\Handlers\FileHandler' => [
            'path' => '',
            'fileExtension' => '',
            'filePermissions' => 0644,
        ],
    ];
}

