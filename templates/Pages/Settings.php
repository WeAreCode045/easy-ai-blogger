<h1>Easy AI Blogger Settings</h1>
<form method="post" action="options.php">
    <?php
    settings_fields('easy_ai_blogger_settings');
    do_settings_sections('easy-ai-blogger-settings');
    submit_button();
    ?>
</form>
