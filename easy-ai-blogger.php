<?php
/* Plugin Name: Easy AI Blogger
 * Description: A WordPress plugin to enhance blogging with AI capabilities.
 * Version: 1.0.12
 * Author: WeAreCode045
 * Author URI: https://github.com/WeAreCode045
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: easy-ai-blogger
 * Domain Path: /languages
 */

$wpversion = get_bloginfo('version');
define('EASY_AI_BLOGGER_VERSION', $wpversion );
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
require_once EASY_AI_BLOGGER_DIR . 'includes/Core/Config.php';

// Include admin page
require_once EASY_AI_BLOGGER_DIR . 'includes/Admin/AdminPage.php';
// Register admin menu
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
// Include Envato Elements integration
require_once EASY_AI_BLOGGER_DIR . 'includes/Integrations/EnvatoElements/EnvatoElements.php';
// Include AI handler
require_once EASY_AI_BLOGGER_DIR . 'includes/Ajax/AiHandler.php';
