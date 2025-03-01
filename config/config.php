<?php
// Base URL
define('BASE_URL', 'http://localhost:8000');

// Application settings
$config = [
    'app_name' => 'Personal CMS',
    'version' => '1.0.0',
    'debug' => true,
    'timezone' => 'UTC',
    'locale' => 'en',
    'upload_dir' => BASE_PATH . '/public/uploads',
];

// Admin email
$config['admin_email'] = 'admin@example.com';

// Set timezone
date_default_timezone_set($config['timezone']);
