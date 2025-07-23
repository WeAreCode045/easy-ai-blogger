<?php
namespace EasyAiBlogger\Includes\Ajax;

class PostFormHandler {
    public static function register() {
        add_action('wp_ajax_easy_ai_save_post', [self::class, 'save_post']);
    }

    public static function save_post() {
        check_ajax_referer('easy_ai_blogger_nonce');
        $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
        $content = isset($_POST['content']) ? wp_kses_post($_POST['content']) : '';
        $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
        $tags = isset($_POST['tags']) ? sanitize_text_field($_POST['tags']) : '';
        $featured_image = isset($_POST['featured_image']) ? esc_url_raw($_POST['featured_image']) : '';

        $post_data = [
            'post_title'   => $title,
            'post_content' => $content,
            'post_status'  => 'publish',
            'post_category'=> [$category],
            'tags_input'   => $tags,
        ];
        $post_id = wp_insert_post($post_data);
        if ($post_id && $featured_image) {
            // Download and set featured image
            $image_id = media_sideload_image($featured_image, $post_id, null, 'id');
            if (!is_wp_error($image_id)) {
                set_post_thumbnail($post_id, $image_id);
            }
        }
        if ($post_id) {
            $url = get_permalink($post_id);
            wp_send_json_success(['post_id' => $post_id, 'url' => $url]);
        } else {
            wp_send_json_error(['message' => 'Failed to create post.']);
        }
    }
}

add_action('init', ['EasyAiBlogger\Includes\Ajax\PostFormHandler', 'register']);
