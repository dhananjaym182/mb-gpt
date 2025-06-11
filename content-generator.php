<div class="mb-chatbot-container">
    <h1>MB-Chatbot Content Generator</h1>
    <form id="mb-chatbot-form">
        <label for="topic">Topic:</label>
        <input type="text" id="topic" name="topic" required>

        <label for="tone">Tone:</label>
        <select id="tone" name="tone">
            <option value="formal">Formal</option>
            <option value="casual">Casual</option>
        </select>

        <label for="style">Style:</label>
        <select id="style" name="style">
            <option value="informative">Informative</option>
            <option value="persuasive">Persuasive</option>
        </select>

        <button type="submit">Generate Content</button>
    </form>

    <h2>Generated Content</h2>
    <div id="generated-content"></div>
</div>
