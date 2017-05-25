<?php
if (!function_exists('classAutoLoader')) {
    function classAutoLoader($className)
    {
        $fileName = 'src/' . str_replace('\\', '/', $className) . '.php';
        if (file_exists($fileName)) {
            require_once $fileName;
        }
    }
}
spl_autoload_register('classAutoLoader');
