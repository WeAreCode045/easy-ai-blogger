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
                // Try to auto-format the AI response with basic HTML
                var formatted = response.data.content
                    .replace(/\n\n+/g, '</p><p>') // double line breaks to paragraphs
                    .replace(/\n/g, '<br>') // single line breaks to <br>
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
</script>
<style>
.easy-ai-blogger-generated h1, .easy-ai-blogger-generated h2, .easy-ai-blogger-generated h3 {
    color: #0073aa;
    margin-top: 1.2em;
    margin-bottom: 0.5em;
}
.easy-ai-blogger-generated p {
    margin: 0 0 1em 0;
    line-height: 1.7;
}
.easy-ai-blogger-generated br {
    margin-bottom: 0.5em;
}
</style>
