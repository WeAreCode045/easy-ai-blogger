<style>
.easy-ai-blogger-steps {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 32px;
    gap: 16px;
}
.easy-ai-blogger-step {
    display: flex;
    align-items: center;
    font-weight: 500;
    color: #888;
    background: #f1f1f1;
    border-radius: 20px;
    padding: 6px 18px;
    font-size: 1rem;
    transition: background 0.2s, color 0.2s;
}
.easy-ai-blogger-step.active {
    background: #0073aa;
    color: #fff;
}
.easy-ai-blogger-step.completed {
    background: #00b894;
    color: #fff;
}
.easy-ai-blogger-step:not(:last-child)::after {
    content: '\2192';
    margin-left: 12px;
    color: #bbb;
    font-size: 1.2em;
}
.easy-ai-blogger-nav {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    margin-top: 16px;
}
.easy-ai-blogger-skip {
    background: #e0e0e0;
    color: #23282d;
    border: none;
    border-radius: 4px;
    padding: 8px 18px;
    cursor: pointer;
    font-size: 1rem;
    margin-left: 8px;
}
.easy-ai-blogger-skip:hover {
    background: #bdbdbd;
}
</style>
<div class="easy-ai-blogger-steps">
    <div class="easy-ai-blogger-step active" id="step-indicator-1">1. Content</div>
    <div class="easy-ai-blogger-step" id="step-indicator-2">2. Meta</div>
    <div class="easy-ai-blogger-step" id="step-indicator-3">3. Images</div>
    <div class="easy-ai-blogger-step" id="step-indicator-4">4. Review</div>
</div>
<form id="easy-ai-blogger-multistep-form">
    <div id="eab-step-1" class="eab-step">
        <?php include __DIR__ . '/Steps/addContent.php'; ?>
        <div class="easy-ai-blogger-nav">
            <button type="button" class="eab-next-step">Next</button>
            <button type="button" class="easy-ai-blogger-skip" data-skip="2">Skip to Meta</button>
            <button type="button" class="easy-ai-blogger-skip" data-skip="3">Skip to Images</button>
            <button type="button" class="easy-ai-blogger-skip" data-skip="4">Skip to Review</button>
        </div>
    </div>
    <div id="eab-step-2" class="eab-step" style="display:none;">
        <?php include __DIR__ . '/Steps/addPostMeta.php'; ?>
        <div class="easy-ai-blogger-nav">
            <button type="button" class="eab-prev-step">Previous</button>
            <button type="button" class="eab-next-step">Next</button>
            <button type="button" class="easy-ai-blogger-skip" data-skip="3">Skip to Images</button>
            <button type="button" class="easy-ai-blogger-skip" data-skip="4">Skip to Review</button>
        </div>
    </div>
    <div id="eab-step-3" class="eab-step" style="display:none;">
        <?php include __DIR__ . '/Steps/addImages.php'; ?>
        <div class="easy-ai-blogger-nav">
            <button type="button" class="eab-prev-step">Previous</button>
            <button type="button" class="eab-next-step">Next</button>
            <button type="button" class="easy-ai-blogger-skip" data-skip="4">Skip to Review</button>
        </div>
    </div>
    <div id="eab-step-4" class="eab-step" style="display:none;">
        <?php include __DIR__ . '/Steps/PostReview.php'; ?>
        <div class="easy-ai-blogger-nav">
            <button type="button" class="eab-prev-step">Previous</button>
        </div>
    </div>
</form>
<script>
jQuery(document).ready(function($) {
    var currentStep = 1;
    function showStep(step) {
        $('.eab-step').hide();
        $('#eab-step-' + step).show();
        $('.easy-ai-blogger-step').removeClass('active completed');
        for (var i = 1; i <= 4; i++) {
            if (i < step) {
                $('#step-indicator-' + i).addClass('completed');
            } else if (i === step) {
                $('#step-indicator-' + i).addClass('active');
            }
        }
        currentStep = step;
    }
    $('.eab-next-step').on('click', function() {
        if (currentStep < 4) {
            showStep(currentStep + 1);
        }
    });
    $('.eab-prev-step').on('click', function() {
        if (currentStep > 1) {
            showStep(currentStep - 1);
        }
    });
    $('.easy-ai-blogger-skip').on('click', function() {
        var skipTo = $(this).data('skip');
        showStep(parseInt(skipTo));
    });
    showStep(currentStep);
});
</script>
