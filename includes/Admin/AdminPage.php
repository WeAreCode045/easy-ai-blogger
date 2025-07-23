<?php
namespace EasyAiBlogger\Includes\Admin;

class AdminPage {
    public static function register() {
        add_menu_page(
            __('Easy AI Blogger', 'easy-ai-blogger'),
            __('Easy AI Blogger', 'easy-ai-blogger'),
            'manage_options',
            'easy-ai-blogger-dashboard',
            [self::class, 'render'],
            'dashicons-edit',
            2
        );
        add_submenu_page(
            'easy-ai-blogger-dashboard',
            __('Settings', 'easy-ai-blogger'),
            __('Settings', 'easy-ai-blogger'),
            'manage_options',
            'easy-ai-blogger-settings',
            [self::class, 'render_settings']
        );
    }

    public static function render() {
        include plugin_dir_path(__FILE__) . '../../../templates/Pages/Dashboard.php';
    }

    public static function render_settings() {
        include plugin_dir_path(__FILE__) . '../../../templates/Pages/Settings.php';
    }
}
