jQuery(document).ready(function($) {
    var currentStep = 1;
    function showStep(step) {
        $('.eab-step').hide();
        $('#eab-step-' + step).show();
    }
    $('.eab-next-step').on('click', function() {
        if (currentStep < 4) {
            currentStep++;
            showStep(currentStep);
        }
    });
    $('.eab-prev-step').on('click', function() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });
    showStep(currentStep);

    // AI Content Generation
    $('#eab-generate-content').on('click', function() {
        var sampleText = $('#eab-sample-text').val();
        $.post(EasyAiBloggerAjax.ajax_url, {
            action: 'easy_ai_generate_content',
            sample_text: sampleText,
            _ajax_nonce: EasyAiBloggerAjax.nonce
        }, function(response) {
            if (response.success) {
                $('#eab-generated-content').text(response.data.content);
            }
        });
    });

    // AI Title Suggestion
    $('#eab-ai-title').on('click', function() {
        var content = $('#eab-generated-content').text();
        $.post(EasyAiBloggerAjax.ajax_url, {
            action: 'easy_ai_suggest_title',
            content: content,
            _ajax_nonce: EasyAiBloggerAjax.nonce
        }, function(response) {
            if (response.success) {
                $('#eab-title').val(response.data.title);
            }
        });
    });

    // AI Category Suggestion
    $('#eab-ai-category').on('click', function() {
        var content = $('#eab-generated-content').text();
        $.post(EasyAiBloggerAjax.ajax_url, {
            action: 'easy_ai_suggest_category',
            content: content,
            _ajax_nonce: EasyAiBloggerAjax.nonce
        }, function(response) {
            if (response.success) {
                // Optionally, select the category in the dropdown
                var category = response.data.category;
                $('#eab-category').val(category);
            }
        });
    });

    // AI Tags Suggestion
    $('#eab-ai-tags').on('click', function() {
        var content = $('#eab-generated-content').text();
        $.post(EasyAiBloggerAjax.ajax_url, {
            action: 'easy_ai_suggest_tags',
            content: content,
            _ajax_nonce: EasyAiBloggerAjax.nonce
        }, function(response) {
            if (response.success) {
                $('#eab-tags').val(response.data.tags);
            }
        });
    });

    // Load categories into selectbox (Step 2)
    function loadCategories() {
        $.get(ajaxurl, { action: 'easy_ai_get_categories' }, function(response) {
            if (response.success && response.data.categories) {
                var select = $('#eab-category');
                select.empty();
                $.each(response.data.categories, function(i, cat) {
                    select.append($('<option>', { value: cat.name, text: cat.name }));
                });
            }
        });
    }
    loadCategories();

    // Envato Elements tab switching
    $('.eab-image-tab').on('click', function() {
        var tab = $(this).data('tab');
        $('.eab-image-tab-content').hide();
        $('#eab-image-tab-' + tab).show();
    });

    // Envato Elements search
    $('#eab-envato-search').on('keyup', function(e) {
        if (e.keyCode === 13) {
            var query = $(this).val();
            $.post(EasyAiBloggerAjax.ajax_url, {
                action: 'easy_ai_envato_search',
                query: query,
                _ajax_nonce: EasyAiBloggerAjax.nonce
            }, function(response) {
                if (response.success) {
                    // Render Envato images
                    var results = $('#eab-envato-results');
                    results.empty();
                    $.each(response.data.images, function(i, img) {
                        results.append('<img src="' + img.url + '" class="eab-envato-img" data-url="' + img.url + '" style="max-width:100px;cursor:pointer;" />');
                    });
                } else {
                    $('#eab-envato-results').text(response.data.message);
                }
            });
        }
    });

    // AI-powered Envato search
    $('#eab-ai-envato-search').on('click', function() {
        var content = $('#eab-generated-content').text();
        $.post(EasyAiBloggerAjax.ajax_url, {
            action: 'easy_ai_envato_search',
            query: content,
            _ajax_nonce: EasyAiBloggerAjax.nonce
        }, function(response) {
            if (response.success) {
                var results = $('#eab-envato-results');
                results.empty();
                $.each(response.data.images, function(i, img) {
                    results.append('<img src="' + img.url + '" class="eab-envato-img" data-url="' + img.url + '" style="max-width:100px;cursor:pointer;" />');
                });
            } else {
                $('#eab-envato-results').text(response.data.message);
            }
        });
    });
});
