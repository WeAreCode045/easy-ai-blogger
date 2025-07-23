<h2>Step 1: Generate Blog Content</h2>
<label for="eab-sample-text">Sample Text:</label>
<input type="text" id="eab-sample-text" name="sample_text" class="easy-ai-blogger-input" placeholder="Enter a topic, summary, or sample text..." style="width:100%;font-size:17px;padding:12px 10px;margin-bottom:16px;" />
<button type="button" id="eab-generate-content">Write Complete Blog Text with AI</button>
<div id="eab-generated-content" class="easy-ai-blogger-generated" style="margin-top:16px; min-height:80px;"></div>
<button type="button" class="eab-next-step">Next</button>
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
                    // Headings
                    .replace(/^(#+)\s*(.*)$/gm, function(match, hashes, text) {
                        var level = hashes.length;
                        return '<h' + level + '>' + text + '</h' + level + '>';
                    })
                    // Bold **text** or __text__
                    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                    .replace(/__(.*?)__/g, '<strong>$1</strong>')
                    // Underline _text_
                    .replace(/_(.*?)_/g, '<u>$1</u>')
                    // Blockquotes > text
                    .replace(/^>\s?(.*)$/gm, '<blockquote>$1</blockquote>')
                    // Unordered lists
                    .replace(/(^|\n)[\*-]\s(.*)/g, function(match, p1, item) {
                        return p1 + '<li>' + item + '</li>';
                    })
                    // Ordered lists
                    .replace(/(^|\n)\d+\.\s(.*)/g, function(match, p1, item) {
                        return p1 + '<li>' + item + '</li>';
                    })
                    // Paragraphs
                    .replace(/\n\n+/g, function() {
                        return '</p><p>';
                    })
                    // Line breaks
                    .replace(/\n/g, '<br />');

                // Wrap lists with ul/ol tags
                formatted = formatted.replace(/(<li>.*?<\/li>)+/g, function(match) {
                    // If the first li is preceded by a digit, it's an ol, else ul
                    if (/\d+\./.test(match)) {
                        return '<ol>' + match + '</ol>';
                    } else {
                        return '<ul>' + match + '</ul>';
                    }
                });

                formatted = '<p>' + formatted + '</p>';
                $('#eab-generated-content').html('<strong>Generated Blog Content:</strong><br><div class="easy-ai-blogger-generated">' + formatted + '</div>');
            } else {
                $('#eab-generated-content').html('<span style="color:red;">Error generating content.</span>');
            }
        });
    });
});
// ...existing code...
