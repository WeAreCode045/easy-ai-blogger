<?php
namespace EasyAiBlogger\Includes\Core;

class Config {
    public static function register_settings() {
        register_setting('easy_ai_blogger_settings', 'easy_ai_blogger_openai_token');
        register_setting('easy_ai_blogger_settings', 'easy_ai_blogger_content_field');
        register_setting('easy_ai_blogger_settings', 'easy_ai_blogger_instructions_content');
        register_setting('easy_ai_blogger_settings', 'easy_ai_blogger_instructions_title');
        register_setting('easy_ai_blogger_settings', 'easy_ai_blogger_instructions_category');
        register_setting('easy_ai_blogger_settings', 'easy_ai_blogger_instructions_tags');
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
            'easy_ai_blogger_content_field',
            __('Content Field', 'easy-ai-blogger'),
            [self::class, 'content_field_select'],
            'easy-ai-blogger-settings',
            'easy_ai_blogger_main'
        );
        add_settings_field(
            'easy_ai_blogger_instructions_content',
            __('Instructions for Content (one per line)', 'easy-ai-blogger'),
            [self::class, 'instructions_editor_content'],
            'easy-ai-blogger-settings',
            'easy_ai_blogger_main'
        );
        add_settings_field(
            'easy_ai_blogger_instructions_title',
            __('Instructions for Title (one per line)', 'easy-ai-blogger'),
            [self::class, 'instructions_editor_title'],
            'easy-ai-blogger-settings',
            'easy_ai_blogger_main'
        );
        add_settings_field(
            'easy_ai_blogger_instructions_category',
            __('Instructions for Category (one per line)', 'easy-ai-blogger'),
            [self::class, 'instructions_editor_category'],
            'easy-ai-blogger-settings',
            'easy_ai_blogger_main'
        );
        add_settings_field(
            'easy_ai_blogger_instructions_tags',
            __('Instructions for Tags (one per line)', 'easy-ai-blogger'),
            [self::class, 'instructions_editor_tags'],
            'easy-ai-blogger-settings',
            'easy_ai_blogger_main'
        );
    }

    public static function openai_token_field() {
        $value = esc_attr(get_option('easy_ai_blogger_openai_token', ''));
        echo "<input type='text' name='easy_ai_blogger_openai_token' value='$value' size='50' />";
    }


    public static function content_field_select() {
        $value = esc_attr(get_option('easy_ai_blogger_content_field', 'eab-sample-text'));
        // List all input fields from the form (hardcoded for now, can be dynamic if needed)
        $fields = [
            'eab-sample-text' => __('Sample Text', 'easy-ai-blogger'),
            'eab-title' => __('Title', 'easy-ai-blogger'),
            'eab-category' => __('Category', 'easy-ai-blogger'),
            'eab-tags' => __('Tags', 'easy-ai-blogger'),
            'eab-image-search' => __('Image Search', 'easy-ai-blogger'),
        ];
        echo "<select name='easy_ai_blogger_content_field'>";
        foreach ($fields as $key => $label) {
            $selected = ($value === $key) ? 'selected' : '';
            echo "<option value='$key' $selected>$label</option>";
        }
        echo "</select>";
        echo '<br><small>Select which form field to use as content for the AI prompt.</small>';
    }

    public static function instructions_editor_content() {
        $value = esc_textarea(get_option('easy_ai_blogger_instructions_content', ''));
        echo "<textarea name='easy_ai_blogger_instructions_content' rows='8' cols='80' style='font-family:monospace;'>$value</textarea>";
        echo '<br><small>Add instructions for AI (content), one per line.</small>';
    }
    public static function instructions_editor_title() {
        $value = esc_textarea(get_option('easy_ai_blogger_instructions_title', ''));
        echo "<textarea name='easy_ai_blogger_instructions_title' rows='8' cols='80' style='font-family:monospace;'>$value</textarea>";
        echo '<br><small>Add instructions for AI (title), one per line.</small>';
    }
    public static function instructions_editor_category() {
        $value = esc_textarea(get_option('easy_ai_blogger_instructions_category', ''));
        echo "<textarea name='easy_ai_blogger_instructions_category' rows='8' cols='80' style='font-family:monospace;'>$value</textarea>";
        echo '<br><small>Add instructions for AI (category), one per line.</small>';
    }
    public static function instructions_editor_tags() {
        $value = esc_textarea(get_option('easy_ai_blogger_instructions_tags', ''));
        echo "<textarea name='easy_ai_blogger_instructions_tags' rows='8' cols='80' style='font-family:monospace;'>$value</textarea>";
        echo '<br><small>Add instructions for AI (tags), one per line.</small>';
    }
}

add_action('admin_init', ['EasyAiBlogger\Includes\Core\Config', 'register_settings']);
