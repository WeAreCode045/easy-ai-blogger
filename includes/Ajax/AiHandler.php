<?php
namespace EasyAiBlogger\Includes\Ajax;

class AiHandler {
    public static function register() {
        add_action('wp_ajax_easy_ai_generate_content', [self::class, 'generate_content']);
        add_action('wp_ajax_easy_ai_suggest_title', [self::class, 'suggest_title']);
        add_action('wp_ajax_easy_ai_suggest_category', [self::class, 'suggest_category']);
        add_action('wp_ajax_easy_ai_suggest_tags', [self::class, 'suggest_tags']);
        add_action('wp_ajax_easy_ai_search_images', [self::class, 'search_images']);
    }

    public static function generate_content() {
        check_ajax_referer('easy_ai_blogger_nonce');
        $sample_text = isset($_POST['sample_text']) ? sanitize_text_field($_POST['sample_text']) : '';
        $api_key = get_option('easy_ai_blogger_openai_token', '');
        $response = self::call_openai_api('blog_content', $sample_text, $api_key);
        wp_send_json_success(['content' => $response]);
    }
    public static function suggest_title() {
        check_ajax_referer('easy_ai_blogger_nonce');
        $content = isset($_POST['content']) ? sanitize_text_field($_POST['content']) : '';
        $api_key = get_option('easy_ai_blogger_openai_token', '');
        $response = self::call_openai_api('title', $content, $api_key);
        wp_send_json_success(['title' => $response]);
    }
    public static function suggest_category() {
        check_ajax_referer('easy_ai_blogger_nonce');
        $content = isset($_POST['content']) ? sanitize_text_field($_POST['content']) : '';
        $api_key = get_option('easy_ai_blogger_openai_token', '');
        $response = self::call_openai_api('category', $content, $api_key);
        wp_send_json_success(['category' => $response]);
    }
    public static function suggest_tags() {
        check_ajax_referer('easy_ai_blogger_nonce');
        $content = isset($_POST['content']) ? sanitize_text_field($_POST['content']) : '';
        $api_key = get_option('easy_ai_blogger_openai_token', '');
        $response = self::call_openai_api('tags', $content, $api_key);
        wp_send_json_success(['tags' => $response]);
    }

    private static function call_openai_api($type, $content, $api_key) {
        if (!$api_key) return '';
        $prompts = [
            'blog_content' => get_option('easy_ai_blogger_prompt_content', 'Write a complete blog post based on this sample: {input}'),
            'title'        => get_option('easy_ai_blogger_prompt_title', 'Suggest a catchy blog post title for this content: {input}'),
            'category'     => get_option('easy_ai_blogger_prompt_category', 'Suggest the most relevant category for this blog post: {input}'),
            'tags'         => get_option('easy_ai_blogger_prompt_tags', 'Suggest relevant tags for this blog post: {input}'),
        ];
        $prompt = isset($prompts[$type]) ? str_replace('{input}', $content, $prompts[$type]) : $content;
        $body = [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
            'max_tokens' => 256
        ];
        $response = wp_remote_post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json',
            ],
            'body' => wp_json_encode($body),
        ]);
        if (is_wp_error($response)) return '';
        $data = json_decode(wp_remote_retrieve_body($response), true);
        return $data['choices'][0]['message']['content'] ?? '';
    }
    public static function search_images() {
        // TODO: Use OpenAI API or Envato Elements to search images
        wp_send_json_success(['images' => []]);
    }
}

add_action('init', ['EasyAiBlogger\Includes\Ajax\AiHandler', 'register']);
