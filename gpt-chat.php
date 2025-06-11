<?php
/**
 * Plugin Name: MB GPT Chat Box
 * Description: A simple frontend chatbox using OpenAI GPT API.
 * Version: 1.0
 * Author: Your Name
 */

add_shortcode('gpt_chatbox', 'gpt_chatbox_shortcode');

function gpt_chatbox_shortcode() {
    ob_start();
    ?>
    <div id="gpt-chatbox" style="max-width:500px; margin:auto;">
        <div id="gpt-output" style="border:1px solid #ccc; padding:10px; min-height:100px;"></div>
        <textarea id="gpt-input" rows="3" style="width:100%; margin-top:10px;" placeholder="Ask something..."></textarea>
        <button id="gpt-send">Send</button>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const output = document.getElementById('gpt-output');
        const input = document.getElementById('gpt-input');
        const send = document.getElementById('gpt-send');
        let history = [];

        send.addEventListener('click', async () => {
            const userMsg = input.value.trim();
            if (!userMsg) return;
            history.push({ role: "user", content: userMsg });
            input.value = '';
            output.innerHTML += "<p><strong>You:</strong> " + userMsg + "</p>";

            const response = await fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    action: "gpt_chat",
                    history: history
                })
            });

            const data = await response.json();
            const reply = data.reply || "No response.";
            history.push({ role: "assistant", content: reply });
            output.innerHTML += "<p><strong>GPT:</strong> " + reply + "</p>";
        });
    });
    </script>
    <?php
    return ob_get_clean();
}

add_action('wp_ajax_gpt_chat', 'gpt_chat_ajax');
add_action('wp_ajax_nopriv_gpt_chat', 'gpt_chat_ajax');

function gpt_chat_ajax() {
    $json = json_decode(file_get_contents("php://input"), true);
    $history = $json['history'] ?? [];

    $api_key = 'your_openai_api_key'; // Replace this with your actual API key
    $response = wp_remote_post('https://api.openai.com/v1/chat/completions', [
        'headers' => [
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type'  => 'application/json',
        ],
        'body' => json_encode([
            'model' => 'gpt-4o',
            'messages' => $history,
            'temperature' => 0.7,
        ]),
    ]);

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    wp_send_json([
        'reply' => $data['choices'][0]['message']['content'] ?? 'Sorry, something went wrong.',
    ]);
}
