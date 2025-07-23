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

    // Rich text editor for textarea
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#eab-sample-text',
            menubar: false,
            toolbar: 'undo redo | bold italic underline | bullist numlist | link | code',
            height: 200,
            branding: false,
            skin: 'oxide',
            content_css: false
        });
    }

    // Show formatted AI content
    $('#eab-generate-content').on('click', function() {
        var sampleText = $('#eab-sample-text').val();
        $('#eab-generated-content').html('<em>Generating blog content...</em>');
        $.post(EasyAiBloggerAjax.ajax_url, {
            action: 'easy_ai_generate_content',
            sample_text: sampleText,
            _ajax_nonce: EasyAiBloggerAjax.nonce
        }, function(response) {
            if (response.success) {
                var formatted = response.data.content
                    .replace(/\n\n+/g, '</p><p>')
                    .replace(/\n/g, '<br>')
                    .replace(/^(#+)\s*(.*)$/gm, function(match, hashes, text) {
                        var level = hashes.length;
                        return '<h' + level + '>' + text + '</h' + level + '>';
                    });
                $('#eab-generated-content').html('<strong>Generated Blog Content:</strong><br><div class="easy-ai-blogger-generated">' + formatted + '</div>');
            } else {
                $('#eab-generated-content').html('<span style="color:red;">Error generating content.</span>');
            }
        });
    });
});
