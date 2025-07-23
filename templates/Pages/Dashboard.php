<?php
/**
 * The template for displaying the dashboard
 *
 * @package Easy AI Blogger
 */
?>
<div class="wrap">
    <h1><?php esc_html_e('Easy AI Blogger Dashboard', 'easy-ai-blogger'); ?></h1>
    <?php include plugin_dir_path(__FILE__) . '../Components/Forms/addPostForm.php'; ?>
</div>