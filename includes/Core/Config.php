<?php
namespace EasyAiBlogger\Includes\Core;

class Config {
    public static function register_settings() {
        register_setting('easy_ai_blogger_settings', 'easy_ai_blogger_openai_token');
        register_setting('easy_ai_blogger_settings', 'easy_ai_blogger_prompt_content');
        register_setting('easy_ai_blogger_settings', 'easy_ai_blogger_prompt_title');
        register_setting('easy_ai_blogger_settings', 'easy_ai_blogger_prompt_category');
        register_setting('easy_ai_blogger_settings', 'easy_ai_blogger_prompt_tags');
        add_settings_section(
            'easy_ai_blogger_main',
            __('Main Settings', 'easy-ai-blogger'),
            function() {},
            'easy-ai-blogger-settings'
        );
        add_settings_field(
            'easy_ai_blogger_openai_token',
            __('OpenAI API Token', 'easy-ai-blogger'),
            [self::class, 'openai_token_field'],
            'easy-ai-blogger-settings',
            'easy_ai_blogger_main'
        );
        add_settings_field(
            'easy_ai_blogger_prompt_content',
            __('Prompt for Blog Content', 'easy-ai-blogger'),
            [self::class, 'prompt_content_field'],
            'easy-ai-blogger-settings',
            'easy_ai_blogger_main'
        );
        add_settings_field(
            'easy_ai_blogger_prompt_title',
            __('Prompt for Title', 'easy-ai-blogger'),
            [self::class, 'prompt_title_field'],
            'easy-ai-blogger-settings',
            'easy_ai_blogger_main'
        );
        add_settings_field(
            'easy_ai_blogger_prompt_category',
            __('Prompt for Category', 'easy-ai-blogger'),
            [self::class, 'prompt_category_field'],
            'easy-ai-blogger-settings',
            'easy_ai_blogger_main'
        );
        add_settings_field(
            'easy_ai_blogger_prompt_tags',
            __('Prompt for Tags', 'easy-ai-blogger'),
            [self::class, 'prompt_tags_field'],
            'easy-ai-blogger-settings',
            'easy_ai_blogger_main'
        );
    }

    public static function openai_token_field() {
        $value = esc_attr(get_option('easy_ai_blogger_openai_token', ''));
        echo "<input type='text' name='easy_ai_blogger_openai_token' value='$value' size='50' />";
    }

    public static function prompt_content_field() {
        $value = esc_attr(get_option('easy_ai_blogger_prompt_content', 'Write a complete blog post based on this sample: {input}'));
        echo "<input type='text' name='easy_ai_blogger_prompt_content' value='$value' size='80' />";
        echo '<br><small>Use {input} as placeholder for the sample text.</small>';
    }
    public static function prompt_title_field() {
        $value = esc_attr(get_option('easy_ai_blogger_prompt_title', 'Suggest a catchy blog post title for this content: {input}'));
        echo "<input type='text' name='easy_ai_blogger_prompt_title' value='$value' size='80' />";
        echo '<br><small>Use {input} as placeholder for the blog content.</small>';
    }
    public static function prompt_category_field() {
        $value = esc_attr(get_option('easy_ai_blogger_prompt_category', 'Suggest the most relevant category for this blog post: {input}'));
        echo "<input type='text' name='easy_ai_blogger_prompt_category' value='$value' size='80' />";
        echo '<br><small>Use {input} as placeholder for the blog content.</small>';
    }
    public static function prompt_tags_field() {
        $value = esc_attr(get_option('easy_ai_blogger_prompt_tags', 'Suggest relevant tags for this blog post: {input}'));
        echo "<input type='text' name='easy_ai_blogger_prompt_tags' value='$value' size='80' />";
        echo '<br><small>Use {input} as placeholder for the blog content.</small>';
    }
}

add_action('admin_init', ['EasyAiBlogger\Includes\Core\Config', 'register_settings']);
