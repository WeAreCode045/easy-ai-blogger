<?php
namespace EasyAiBlogger\Includes;

class Autoloader {
    public static function register() {
        spl_autoload_register([self::class, 'autoload']);
    }

    public static function autoload($class) {
        if (strpos($class, 'EasyAiBlogger\\') !== 0) {
            return;
        }
        $base_dir = __DIR__ . '/../';
        $relative_class = substr($class, strlen('EasyAiBlogger\\'));
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
}
