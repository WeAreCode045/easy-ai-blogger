<?php
/* Plugin Name: Easy AI Blogger
 * Description: A WordPress plugin to enhance blogging with AI capabilities.
 * Version: 1.0.1
 * Author: WeAreCode045
 * Author URI: https://github.com/WeAreCode045
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: easy-ai-blogger
 * Domain Path: /languages
 */
// Autoload classes
require_once plugin_dir_path(__FILE__) . 'includes/Autoloader.php';
EasyAiBlogger\Includes\Autoloader::register();

// Register admin menu
add_action('admin_menu', function() {
    EasyAiBlogger\Includes\Admin\AdminPage::register();
});

// Enqueue admin assets
add_action('admin_enqueue_scripts', function($hook) {
    if ($hook === 'toplevel_page_easy-ai-blogger-dashboard') {
        wp_enqueue_style('easy-ai-blogger-admin', plugin_dir_url(__FILE__) . 'assets/css/admin.css');
        wp_enqueue_script('easy-ai-blogger-admin', plugin_dir_url(__FILE__) . 'assets/js/admin.js', ['jquery'], null, true);
        wp_localize_script('easy-ai-blogger-admin', 'EasyAiBloggerAjax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('easy_ai_blogger_nonce'),
        ]);
    }
});
