<h2>Step 1: Generate Blog Content</h2>
<label for="eab-sample-text">Sample Text:</label>
<textarea id="eab-sample-text" name="sample_text" rows="4" cols="50"></textarea>
<button type="button" id="eab-generate-content">Write Complete Blog Text with AI</button>
<div id="eab-generated-content" style="margin-top:16px; background:#fff; border:1px solid #ccd0d4; border-radius:4px; padding:16px; min-height:80px;"></div>
<button type="button" class="eab-next-step">Next</button>
<script>
jQuery(document).ready(function($) {
    $('#eab-generate-content').on('click', function() {
        var sampleText = $('#eab-sample-text').val();
        $('#eab-generated-content').html('<em>Generating blog content...</em>');
        $.post(EasyAiBloggerAjax.ajax_url, {
            action: 'easy_ai_generate_content',
            sample_text: sampleText,
            _ajax_nonce: EasyAiBloggerAjax.nonce
        }, function(response) {
            if (response.success) {
                $('#eab-generated-content').html('<strong>Generated Blog Content:</strong><br>' + response.data.content);
            } else {
                $('#eab-generated-content').html('<span style="color:red;">Error generating content.</span>');
            }
        });
    });
});
</script>
