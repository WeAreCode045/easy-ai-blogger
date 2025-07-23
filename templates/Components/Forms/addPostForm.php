<form id="easy-ai-blogger-multistep-form">
    <div id="eab-step-1" class="eab-step">
        <?php include __DIR__ . '/Steps/addContent.php'; ?>
    </div>
    <div id="eab-step-2" class="eab-step" style="display:none;">
        <?php include __DIR__ . '/Steps/addPostMeta.php'; ?>
    </div>
    <div id="eab-step-3" class="eab-step" style="display:none;">
        <?php include __DIR__ . '/Steps/addImages.php'; ?>
    </div>
    <div id="eab-step-4" class="eab-step" style="display:none;">
        <?php include __DIR__ . '/Steps/PostReview.php'; ?>
    </div>
</form>
