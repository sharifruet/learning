<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class ContentSecurityPolicy extends BaseConfig
{
    public $reportOnly = false;
    public $defaultSrc = 'none';
    public $scriptSrc = 'self';
    public $styleSrc = 'self';
    public $imageSrc = 'self';
    public $baseURI = 'self';
    public $childSrc = 'self';
    public $connectSrc = 'self';
    public $fontSrc = 'self';
    public $formAction = 'self';
    public $frameAncestors = 'none';
    public $frameSrc = 'none';
    public $mediaSrc = 'self';
    public $objectSrc = 'none';
    public $pluginTypes = 'none';
    public $reportURI = '';
    public $sandbox = false;
    public $upgradeInsecureRequests = false;
    public $styleNonceTag = '{csp-style-nonce}';
    public $scriptNonceTag = '{csp-script-nonce}';
    public $autoNonce = true;
}

