<?php
namespace EasyAiBlogger\Includes;

class Autoloader {
    private static $registered = false;
    private static $loadedFiles = [];

    public static function register() {
        if (!self::$registered) {
            spl_autoload_register([self::class, 'autoload']);
            self::$registered = true;
        }
    }

    public static function autoload($className) {
        // Only autoload EasyAiBlogger classes
        if (strpos($className, 'EasyAiBlogger\\') !== 0) {
            return;
        }
        // Get plugin root directory
        $baseDir = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR;
        $relativeClass = substr($className, strlen('EasyAiBlogger\\'));
        $file = $baseDir . str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $relativeClass) . '.php';
        if (file_exists($file) && empty(self::$loadedFiles[$file])) {
            require_once $file;
            self::$loadedFiles[$file] = true;
        }
    }
}