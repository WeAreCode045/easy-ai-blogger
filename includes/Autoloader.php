<?php
namespace EasyAiBlogger\Includes;

class Autoloader {
    public static function register() {
        spl_autoload_register([self::class, 'autoload']);
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
        if (file_exists($file)) {
            require_once $file;
        }
    }
}