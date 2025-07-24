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
        $content_field = get_option('easy_ai_blogger_content_field', 'eab-sample-text');
        $content_value = isset($_POST[$content_field]) ? sanitize_text_field($_POST[$content_field]) : '';
        $api_key = get_option('easy_ai_blogger_openai_token', '');
        $response = self::call_openai_api('blog_content', $content_value, $api_key);
        if (empty($response)) {
            error_log('Easy AI Blogger: Empty AI response. Content field: ' . $content_field . ' | Value: ' . $content_value . ' | API Key: ' . ($api_key ? 'set' : 'missing'));
            wp_send_json_error(['message' => 'AI did not return any content. Please check your API key, prompt, and selected content field.']);
        } else {
            wp_send_json_success(['content' => $response]);
        }
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
        $instructions_content = trim(get_option('easy_ai_blogger_instructions_content', ''));
        $instructions_title = trim(get_option('easy_ai_blogger_instructions_title', ''));
        $instructions_category = trim(get_option('easy_ai_blogger_instructions_category', ''));
        $instructions_tags = trim(get_option('easy_ai_blogger_instructions_tags', ''));
        $prompts = [
            'blog_content' => "Write a complete blog post based on this sample: {input}." . ($instructions_content ? ("\nInstructions:\n" . $instructions_content) : ''),
            'title'        => "Suggest a catchy blog post title for this content: {input}." . ($instructions_title ? ("\nInstructions:\n" . $instructions_title) : ''),
            'category'     => "Suggest the most relevant category for this blog post: {input}." . ($instructions_category ? ("\nInstructions:\n" . $instructions_category) : ''),
            'tags'         => "Suggest relevant tags for this blog post: {input}." . ($instructions_tags ? ("\nInstructions:\n" . $instructions_tags) : ''),
        ];
        $prompt = isset($prompts[$type]) ? str_replace('{input}', $content, $prompts[$type]) : $content;
        $body = [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ]
        ];
        $response = wp_remote_post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json',
            ],
            'body' => wp_json_encode($body),
        ]);
        if (is_wp_error($response)) {
            error_log('Easy AI Blogger: OpenAI API error - ' . $response->get_error_message());
            return '';
        }
        $raw_body = wp_remote_retrieve_body($response);
        $data = json_decode($raw_body, true);
        if (empty($data['choices'][0]['message']['content'])) {
            error_log('Easy AI Blogger: OpenAI raw response: ' . $raw_body);
        }
        return $data['choices'][0]['message']['content'] ?? '';
    }
    public static function search_images() {
        // TODO: Use OpenAI API or Envato Elements to search images
        wp_send_json_success(['images' => []]);
    }
}

add_action('init', ['EasyAiBlogger\Includes\Ajax\AiHandler', 'register']);
