<?php
spl_autoload_register(function ($class) {
    $prefix = '';
    $base_dir = __DIR__ . '/../src/';
    $len = strlen($prefix);
    
    $relative_class = $class;
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});
