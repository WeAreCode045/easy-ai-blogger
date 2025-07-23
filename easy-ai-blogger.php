<?php
/* Plugin Name: Easy AI Blogger
 * Description: A WordPress plugin to enhance blogging with AI capabilities.
 * Version: 1.0.3
 * Author: WeAreCode045
 * Author URI: https://github.com/WeAreCode045
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: easy-ai-blogger
 * Domain Path: /languages
 */

define('EASY_AI_BLOGGER_VERSION', '1.0.2');
define('EASY_AI_BLOGGER_DIR', plugin_dir_path(__FILE__));
define('EASY_AI_BLOGGER_URL', plugin_dir_url(__FILE__));
// Load plugin text domain for translations
add_action('plugins_loaded', function() {
    load_plugin_textdomain('easy-ai-blogger', false, dirname(plugin_basename(__FILE__)) . '/languages');
});


// Autoload classes
require_once EASY_AI_BLOGGER_DIR . 'includes/Autoloader.php';
EasyAiBlogger\Includes\Autoloader::register();

// Include core configuration
require_once EASY_AI_BLOGGER_DIR . 'includes/Core/Settings.php';
// Removed call to unknown method EasyAiBlogger\Includes\Core\Config::init()
// EasyAiBlogger\Includes\Core\Settings::init();
// Include admin page
require_once EASY_AI_BLOGGER_DIR . 'includes/Admin/AdminPage.php';
// Register admin page
add_action('admin_menu', ['EasyAiBlogger\Includes\Admin\AdminPage', 'register']);   
// Enqueue admin scripts and styles
add_action('admin_enqueue_scripts', function($hook) {
    if ($hook === 'toplevel_page_easy-ai-blogger-dashboard') {
        wp_enqueue_style('easy-ai-blogger-admin', EASY_AI_BLOGGER_URL . 'assets/css/admin.css');
        wp_enqueue_script('easy-ai-blogger-admin', EASY_AI_BLOGGER_URL . 'assets/js/admin.js', ['jquery'], EASY_AI_BLOGGER_VERSION, true);
        wp_localize_script('easy-ai-blogger-admin', 'EasyAiBloggerAjax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('easy_ai_blogger_nonce'),
        ]);
    }
});
// Include AJAX handlers
require_once EASY_AI_BLOGGER_DIR . 'includes/Ajax/PostFormHandler.php';
EasyAiBlogger\Includes\Ajax\PostFormHandler::register();
// Include Envato Elements integration
require_once EASY_AI_BLOGGER_DIR . 'includes/Integrations/EnvatoElements/EnvatoElements.php';
if (EasyAiBlogger\Includes\Integrations\EnvatoElements\EnvatoElements::is_active()) {
    EasyAiBlogger\Includes\Integrations\EnvatoElements\EnvatoElements::register_ajax();
}
// Include AI handler
require_once EASY_AI_BLOGGER_DIR . 'includes/Ajax/AiHandler.php';
EasyAiBlogger\Includes\Ajax\AiHandler::register();
// Register AI AJAX handlers
add_action('wp_ajax_easy_ai_generate_content', ['EasyAiBlogger\Includes\Ajax\AiHandler', 'generate_content']);
add_action('wp_ajax_easy_ai_suggest_title', ['EasyAiBlogger\Includes\Ajax\AiHandler', 'suggest_title']);
add_action('wp_ajax_easy_ai_suggest_category', ['EasyAiBlogger\Includes\Ajax\AiHandler', 'suggest_category']);
add_action('wp_ajax_easy_ai_suggest_tags', ['EasyAiBlogger\Includes\Ajax\AiHandler', 'suggest_tags']);
add_action('wp_ajax_easy_ai_search  _images', ['EasyAiBlogger\Includes\Ajax\AiHandler', 'search_images']);  
// Include settings page
require_once EASY_AI_BLOGGER_DIR . 'includes/Core/Settings.php';

// Register settings
add_action('admin_init', ['EasyAiBlogger\Includes\Core\Settings', 'register_settings']);

// Register AI handler
add_action('init', ['EasyAiBlogger\Includes\Ajax\AiHandler', 'register']);      

// Register post form handler
add_action('init', ['EasyAiBlogger\Includes\Ajax\PostFormHandler', 'register']);

// Register Envato Elements integration
if (EasyAiBlogger\Includes\Integrations\EnvatoElements\EnvatoElements::is_active()) {
    EasyAiBlogger\Includes\Integrations\EnvatoElements\EnvatoElements::register_ajax();
}       

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
