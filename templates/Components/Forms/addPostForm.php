<div class="easy-ai-blogger-steps">
    <div class="easy-ai-blogger-step active" id="step-indicator-1">1. Content</div>
    <div class="easy-ai-blogger-step" id="step-indicator-2">2. Meta</div>
    <div class="easy-ai-blogger-step" id="step-indicator-3">3. Images</div>
    <div class="easy-ai-blogger-step" id="step-indicator-4">4. Review</div>
</div>
<form id="easy-ai-blogger-multistep-form" class="wp-core-ui">
    <div id="eab-step-1" class="eab-step">
        <?php include __DIR__ . '/../../Components/Steps/addContent.php'; ?>
        <div class="easy-ai-blogger-nav">
            <button type="button" class="button button-primary eab-next-step">Next</button>
            <button type="button" class="button easy-ai-blogger-skip" data-skip="2">Skip to Meta</button>
            <button type="button" class="button easy-ai-blogger-skip" data-skip="3">Skip to Images</button>
            <button type="button" class="button easy-ai-blogger-skip" data-skip="4">Skip to Review</button>
        </div>
    </div>
    <div id="eab-step-2" class="eab-step" style="display:none;">
        <?php include __DIR__ . '/../../Components/Steps/addPostMeta.php'; ?>
        <div class="easy-ai-blogger-nav">
            <button type="button" class="button eab-prev-step">Previous</button>
            <button type="button" class="button button-primary eab-next-step">Next</button>
            <button type="button" class="button easy-ai-blogger-skip" data-skip="3">Skip to Images</button>
            <button type="button" class="button easy-ai-blogger-skip" data-skip="4">Skip to Review</button>
        </div>
    </div>
    <div id="eab-step-3" class="eab-step" style="display:none;">
        <?php include __DIR__ . '/../../Components/Steps/addImages.php'; ?>
        <div class="easy-ai-blogger-nav">
            <button type="button" class="button eab-prev-step">Previous</button>
            <button type="button" class="button button-primary eab-next-step">Next</button>
            <button type="button" class="button easy-ai-blogger-skip" data-skip="4">Skip to Review</button>
        </div>
    </div>
    <div id="eab-step-4" class="eab-step" style="display:none;">
        <?php include __DIR__ . '/../../Components/Steps/PostReview.php'; ?>
        <div class="easy-ai-blogger-nav">
            <button type="button" class="button eab-prev-step">Previous</button>
        </div>
    </div>
</form>