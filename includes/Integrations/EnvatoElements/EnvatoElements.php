<?php
namespace EasyAiBlogger\Includes\Integrations\EnvatoElements;

class EnvatoElements {
    public static function is_active() {
        return is_plugin_active('envato-elements/envato-elements.php');
    }

    public static function register_ajax() {
        add_action('wp_ajax_easy_ai_envato_search', [self::class, 'search_images']);
    }

    public static function search_images() {
        check_ajax_referer('easy_ai_blogger_nonce');
        $query = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';
        // If Envato Elements plugin provides an API, call it here. Otherwise, fallback to a message.
        if (!self::is_active()) {
            wp_send_json_error(['message' => 'Envato Elements plugin is not active.']);
        }
        // Example: Use Envato Elements API or WordPress hooks to search images
        // $results = ...
        wp_send_json_success(['images' => []]); // Replace with actual results
    }
}

add_action('init', ['EasyAiBlogger\Includes\Integrations\EnvatoElements\EnvatoElements', 'register_ajax']);
