jQuery(document).ready(function($) {
    $('#mb-chatbot-form').on('submit', function(e) {
        e.preventDefault();

        var topic = $('#topic').val();
        var tone = $('#tone').val();
        var style = $('#style').val();

        $.ajax({
            url: ajaxurl, // WordPress AJAX URL
            type: 'POST',
            data: {
                action: 'mb_chatbot_generate_content',
                topic: topic,
                tone: tone,
                style: style
            },
            success: function(response) {
                $('#generated-content').html(response);
            },
            error: function() {
                $('#generated-content').html('Error generating content');
            }
        });
    });
});
