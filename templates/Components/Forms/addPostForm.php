
<form id="easy-ai-blogger-multistep-form" class="wp-core-ui easy-ai-blogger-form">
    <div class="easy-ai-blogger-steps">
        <div class="easy-ai-blogger-step active" id="step-indicator-1">1. Content</div>
        <div class="easy-ai-blogger-step" id="step-indicator-2">2. Meta</div>
        <div class="easy-ai-blogger-step" id="step-indicator-3">3. Images</div>
        <div class="easy-ai-blogger-step" id="step-indicator-4">4. Review</div>
    </div>
    <!-- Step 1: Content -->
    <div id="eab-step-1" class="eab-step">
        <h2>Step 1: Generate Blog Content</h2>
        <label for="eab-sample-text">Sample Text:</label>
        <input type="text" id="eab-sample-text" name="sample_text" class="regular-text" placeholder="Enter a topic, summary, or sample text..." />
        <button type="button" id="eab-generate-content" class="button button-primary">Write Complete Blog Text with AI</button>
        <div id="eab-generated-content" class="easy-ai-blogger-generated" style="margin-top:16px; min-height:80px;"></div>
        <div class="easy-ai-blogger-nav">
            <button type="button" class="button button-primary eab-next-step">Next</button>
            <button type="button" class="button button-secondary easy-ai-blogger-skip" data-skip="2">Skip to Meta</button>
            <button type="button" class="button button-secondary easy-ai-blogger-skip" data-skip="3">Skip to Images</button>
            <button type="button" class="button button-secondary easy-ai-blogger-skip" data-skip="4">Skip to Review</button>
        </div>
    </div>
    <!-- Step 2: Meta -->
    <div id="eab-step-2" class="eab-step" style="display:none;">
        <h2>Step 2: Post Meta</h2>
        <label for="eab-title">Title:</label>
        <input type="text" id="eab-title" name="title" class="regular-text" />
        <label for="eab-category">Category:</label>
        <input type="text" id="eab-category" name="category" class="regular-text" />
        <label for="eab-tags">Tags:</label>
        <input type="text" id="eab-tags" name="tags" class="regular-text" placeholder="Comma separated" />
        <div class="easy-ai-blogger-nav">
            <button type="button" class="button eab-prev-step">Previous</button>
            <button type="button" class="button button-primary eab-next-step">Next</button>
            <button type="button" class="button button-secondary easy-ai-blogger-skip" data-skip="3">Skip to Images</button>
            <button type="button" class="button button-secondary easy-ai-blogger-skip" data-skip="4">Skip to Review</button>
        </div>
    </div>
    <!-- Step 3: Images -->
    <div id="eab-step-3" class="eab-step" style="display:none;">
        <h2>Step 3: Select Images</h2>
        <label for="eab-image-search">Search Images:</label>
        <input type="text" id="eab-image-search" name="image_search" class="regular-text" placeholder="Keyword or topic" />
        <button type="button" id="eab-search-images" class="button">Search</button>
        <div id="eab-image-results" style="margin-top:16px;"></div>
        <div class="easy-ai-blogger-nav">
            <button type="button" class="button eab-prev-step">Previous</button>
            <button type="button" class="button button-primary eab-next-step">Next</button>
            <button type="button" class="button button-secondary easy-ai-blogger-skip" data-skip="4">Skip to Review</button>
        </div>
    </div>
    <!-- Step 4: Review -->
    <div id="eab-step-4" class="eab-step" style="display:none;">
        <h2>Step 4: Review & Save</h2>
        <div id="eab-review-content"></div>
        <button type="submit" class="button button-primary">Save Blog Post</button>
        <div class="easy-ai-blogger-nav">
            <button type="button" class="button eab-prev-step">Previous</button>
        </div>
    </div>
</form>