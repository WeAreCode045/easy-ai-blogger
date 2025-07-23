<div class="wrap">
    <h1><?php esc_html_e('Easy AI Blogger Settings', 'easy-ai-blogger'); ?></h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('easy_ai_blogger_settings');
        do_settings_sections('easy-ai-blogger-settings');
        submit_button();
        ?>
    </form>
</div>