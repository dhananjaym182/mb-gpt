<?php
/**
 * Plugin Name: MB-Chatbot
 * Description: A customizable WordPress plugin that integrates multiple AI APIs for generating humanized blog content focused on EEAT principles.
 * Version: 1.0
 * Author: Your Name
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('MB_CHATBOT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MB_CHATBOT_PLUGIN_URL', plugin_dir_url(__FILE__));

// Enqueue scripts and styles
function mb_chatbot_enqueue_scripts() {
    wp_enqueue_style('mb-chatbot-style', MB_CHATBOT_PLUGIN_URL . 'assets/css/style.css');
    wp_enqueue_script('mb-chatbot-script', MB_CHATBOT_PLUGIN_URL . 'assets/js/script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'mb_chatbot_enqueue_scripts');

// Create admin menu
function mb_chatbot_admin_menu() {
    add_menu_page('MB-Chatbot', 'MB-Chatbot', 'manage_options', 'mb-chatbot', 'mb_chatbot_settings_page');
}
add_action('admin_menu', 'mb_chatbot_admin_menu');

// Settings page
function mb_chatbot_settings_page() {
    include MB_CHATBOT_PLUGIN_DIR . 'templates/content-generator.php';
}

// API request function
function mb_chatbot_generate_content($api, $topic, $tone, $style) {
    // Implement API request logic here
    // Example for OpenAI
    if ($api === 'openai') {
        $api_key = get_option('openai_api_key');
        $response = wp_remote_post('https://api.openai.com/v1/engines/davinci/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                'prompt' => "Write a blog post about $topic in a $tone tone and $style style.",
                'max_tokens' => 500,
            ]),
        ]);

        if (is_wp_error($response)) {
            return 'Error generating content';
        }

        return json_decode(wp_remote_retrieve_body($response), true)['choices'][0]['text'];
    }
    // Add logic for other APIs (Google Gemini, OpenRouter.ai) here
}
