<?php
namespace EasyAiBlogger\Includes;

class Autoloader {
    public static function register() {
        spl_autoload_register([self::class, 'autoload']);
    }

    public static function autoload($class) {
        // Only autoload EasyAiBlogger classes
        if (strpos($class, 'EasyAiBlogger\\') !== 0) {
            return;
        }
        $base_dir = dirname(__DIR__) . '/';
        $relative_class = substr($class, strlen('EasyAiBlogger\\'));
        $file = $base_dir . str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $relative_class) . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
}
