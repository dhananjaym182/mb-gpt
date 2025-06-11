<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register plugin settings, add settings page and fields for API keys.
 */

function mb_chatbot_register_settings() {
    register_setting('mb_chatbot_settings_group', 'mb_chatbot_openai_api_key');
    register_setting('mb_chatbot_settings_group', 'mb_chatbot_google_gemini_api_key');
    register_setting('mb_chatbot_settings_group', 'mb_chatbot_openrouter_api_key');

    add_settings_section(
        'mb_chatbot_api_keys_section',
        __('API Keys Settings', 'mb-chatbot'),
        'mb_chatbot_api_keys_section_cb',
        'mb-chatbot-settings'
    );

    add_settings_field(
        'mb_chatbot_openai_api_key',
        __('OpenAI API Key', 'mb-chatbot'),
        'mb_chatbot_openai_api_key_cb',
        'mb-chatbot-settings',
        'mb_chatbot_api_keys_section'
    );

    add_settings_field(
        'mb_chatbot_google_gemini_api_key',
        __('Google Gemini API Key', 'mb-chatbot'),
        'mb_chatbot_google_gemini_api_key_cb',
        'mb-chatbot-settings',
        'mb_chatbot_api_keys_section'
    );

    add_settings_field(
        'mb_chatbot_openrouter_api_key',
        __('OpenRouter.ai API Key', 'mb-chatbot'),
        'mb_chatbot_openrouter_api_key_cb',
        'mb-chatbot-settings',
        'mb_chatbot_api_keys_section'
    );
}
add_action('admin_init', 'mb_chatbot_register_settings');

function mb_chatbot_api_keys_section_cb() {
    echo '<p>' . esc_html__('Enter your API keys here. These keys will be used for content generation.', 'mb-chatbot') . '</p>';
}

function mb_chatbot_openai_api_key_cb() {
    $value = get_option('mb_chatbot_openai_api_key', '');
    echo '<input type="text" name="mb_chatbot_openai_api_key" value="' . esc_attr($value) . '" class="regular-text" />';
}

function mb_chatbot_google_gemini_api_key_cb() {
    $value = get_option('mb_chatbot_google_gemini_api_key', '');
    echo '<input type="text" name="mb_chatbot_google_gemini_api_key" value="' . esc_attr($value) . '" class="regular-text" />';
}

function mb_chatbot_openrouter_api_key_cb() {
    $value = get_option('mb_chatbot_openrouter_api_key', '');
    echo '<input type="text" name="mb_chatbot_openrouter_api_key" value="' . esc_attr($value) . '" class="regular-text" />';
}

// Add the settings page under the Settings menu
function mb_chatbot_add_settings_page() {
    add_options_page(
        __('MB-Chatbot Settings', 'mb-chatbot'),
        __('MB-Chatbot', 'mb-chatbot'),
        'manage_options',
        'mb-chatbot-settings',
        'mb_chatbot_render_settings_page'
    );
}
add_action('admin_menu', 'mb_chatbot_add_settings_page');

function mb_chatbot_render_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('MB-Chatbot Settings', 'mb-chatbot'); ?></h1>
        <form action="options.php" method="post">
            <?php
                settings_fields('mb_chatbot_settings_group');
                do_settings_sections('mb-chatbot-settings');
                submit_button();
            ?>
        </form>
    </div>
    <?php
}
