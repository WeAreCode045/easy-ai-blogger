<?php
/**
 * The template for displaying the dashboard
 *
 * @package Easy AI Blogger
 */
?>
<div class="easy-ai-blogger-dashboard">
    <h1 class="easy-ai-blogger-title">Easy AI Blogger</h1>
    <div class="easy-ai-blogger-steps">
        <div class="easy-ai-blogger-step active" id="step-indicator-1">1. Content</div>
        <div class="easy-ai-blogger-step" id="step-indicator-2">2. Meta</div>
        <div class="easy-ai-blogger-step" id="step-indicator-3">3. Images</div>
        <div class="easy-ai-blogger-step" id="step-indicator-4">4. Review</div>
    </div>
    <form id="easy-ai-blogger-multistep-form" class="wp-core-ui">
        <div id="eab-step-1" class="eab-step">
            <h2 class="easy-ai-blogger-step-title">Step 1: Generate Blog Content</h2>
            <label for="eab-sample-text">Sample Text:</label>
            <textarea id="eab-sample-text" name="sample_text" class="regular-text"></textarea>
            <button type="button" id="eab-generate-content" class="button button-primary">Write Complete Blog Text with AI</button>
            <div id="eab-generated-content" class="easy-ai-blogger-generated"></div>
            <div class="easy-ai-blogger-nav">
                <button type="button" class="button button-primary eab-next-step">Next</button>
                <button type="button" class="button button-secondary easy-ai-blogger-skip" data-skip="2">Skip to Meta</button>
                <button type="button" class="button button-secondary easy-ai-blogger-skip" data-skip="3">Skip to Images</button>
                <button type="button" class="button button-secondary easy-ai-blogger-skip" data-skip="4">Skip to Review</button>
            </div>
        </div>
        <div id="eab-step-2" class="eab-step" style="display:none;">
            <?php include __DIR__ . '/Steps/addPostMeta.php'; ?>
            <div class="easy-ai-blogger-nav">
                <button type="button" class="button button-primary eab-prev-step">Previous</button>
                <button type="button" class="button button-primary eab-next-step">Next</button>
                <button type="button" class="button button-secondary easy-ai-blogger-skip" data-skip="3">Skip to Images</button>
                <button type="button" class="button button-secondary easy-ai-blogger-skip" data-skip="4">Skip to Review</button>
            </div>
        </div>
        <div id="eab-step-3" class="eab-step" style="display:none;">
            <?php include __DIR__ . '/Steps/addImages.php'; ?>
            <div class="easy-ai-blogger-nav">
                <button type="button" class="button button-primary eab-prev-step">Previous</button>
                <button type="button" class="button button-primary eab-next-step">Next</button>
                <button type="button" class="button button-secondary easy-ai-blogger-skip" data-skip="4">Skip to Review</button>
            </div>
        </div>
        <div id="eab-step-4" class="eab-step" style="display:none;">
            <?php include __DIR__ . '/Steps/PostReview.php'; ?>
            <div class="easy-ai-blogger-nav">
                <button type="button" class="button button-primary eab-prev-step">Previous</button>
            </div>
        </div>
    </form>
</div>