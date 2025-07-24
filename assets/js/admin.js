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

    // Step 1: AI Content Generation
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
                    .replace(/^(#+)\s*(.*)$/gm, function(match, hashes, text) {
                        var level = hashes.length;
                        return '<h' + level + '>' + text + '</h' + level + '>';
                    })
                    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                    .replace(/__(.*?)__/g, '<strong>$1</strong>')
                    .replace(/_(.*?)_/g, '<u>$1</u>')
                    .replace(/^>\s?(.*)$/gm, '<blockquote>$1</blockquote>')
                    .replace(/(^|\n)[\*-]\s(.*)/g, function(match, p1, item) {
                        return p1 + '<li>' + item + '</li>';
                    })
                    .replace(/(^|\n)\d+\.\s(.*)/g, function(match, p1, item) {
                        return p1 + '<li>' + item + '</li>';
                    })
                    .replace(/\n\n+/g, function() {
                        return '</p><p>';
                    })
                    .replace(/\n/g, '<br />');
                formatted = formatted.replace(/(<li>.*?<\/li>)+/g, function(match) {
                    if (/\d+\./.test(match)) {
                        return '<ol>' + match + '</ol>';
                    } else {
                        return '<ul>' + match + '</ul>';
                    }
                });
                formatted = '<p>' + formatted + '</p>';
                $('#eab-generated-content').html('<strong>Generated Blog Content:</strong><br>' + formatted);
            } else {
                $('#eab-generated-content').html('<span style="color:red;">Error generating content.</span>');
            }
        });
    });

    // Step 3: Image Search
    $('#eab-search-images').on('click', function() {
        var keyword = $('#eab-image-search').val();
        $('#eab-image-results').html('<em>Searching images...</em>');
        $.post(EasyAiBloggerAjax.ajax_url, {
            action: 'easy_ai_search_images',
            keyword: keyword,
            _ajax_nonce: EasyAiBloggerAjax.nonce
        }, function(response) {
            if (response.success && response.data.images.length) {
                var html = '<div class="easy-ai-blogger-image-list">';
                response.data.images.forEach(function(img) {
                    html += '<img src="' + img.url + '" alt="' + img.title + '" style="max-width:120px;margin:8px;cursor:pointer;" />';
                });
                html += '</div>';
                $('#eab-image-results').html(html);
            } else {
                $('#eab-image-results').html('<span style="color:red;">No images found.</span>');
            }
        });
    });

    // Step 4: Review & Save
    function populateReview() {
        var reviewHtml = '';
        reviewHtml += '<h3>Content</h3>' + $('#eab-generated-content').html();
        reviewHtml += '<h3>Title</h3><p>' + $('#eab-title').val() + '</p>';
        reviewHtml += '<h3>Category</h3><p>' + $('#eab-category').val() + '</p>';
        reviewHtml += '<h3>Tags</h3><p>' + $('#eab-tags').val() + '</p>';
        var images = $('.easy-ai-blogger-image-list img.selected');
        if (images.length) {
            reviewHtml += '<h3>Images</h3>';
            images.each(function() {
                reviewHtml += '<img src="' + $(this).attr('src') + '" style="max-width:120px;margin:8px;" />';
            });
        }
        $('#eab-review-content').html(reviewHtml);
    }
    $('.eab-next-step').on('click', function() {
        if (currentStep === 3) {
            populateReview();
        }
    });
    $('#easy-ai-blogger-multistep-form').on('submit', function(e) {
        e.preventDefault();
        var postData = {
            action: 'easy_ai_save_post',
            _ajax_nonce: EasyAiBloggerAjax.nonce,
            content: $('#eab-generated-content').html(),
            title: $('#eab-title').val(),
            category: $('#eab-category').val(),
            tags: $('#eab-tags').val(),
            images: []
        };
        $('.easy-ai-blogger-image-list img.selected').each(function() {
            postData.images.push($(this).attr('src'));
        });
        $('#eab-review-content').html('<em>Saving...</em>');
        $.post(EasyAiBloggerAjax.ajax_url, postData, function(response) {
            if (response.success) {
                $('#eab-review-content').html('<span style="color:green;">Blog post saved!</span>');
            } else {
                $('#eab-review-content').html('<span style="color:red;">Error saving post.</span>');
            }
        });
    });

    // Image selection
    $(document).on('click', '.easy-ai-blogger-image-list img', function() {
        $(this).toggleClass('selected');
    });
});
