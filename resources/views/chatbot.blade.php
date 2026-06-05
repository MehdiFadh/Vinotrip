<!-- Fichier resources/views/partials/chatbot.blade.php -->

<div id="chatbot-btn" onclick="toggleChatbot()">
    <i class="fas fa-comment-dots"></i>
</div>

<div id="chatbot">
    <div id="chatbot-header">
        <strong>Chatbot</strong>
        <span onclick="toggleChatbot()" style="cursor: pointer;">&times;</span>
    </div>
    <div id="chatbot-body">
        <div id="messages"></div>
    </div>
    <div id="chatbot-footer">
        <input type="text" id="userMessage" placeholder="Votre message..." />
        <button onclick="sendMessage()">Envoyer</button>
    </div>
</div>

<script>
    function toggleChatbot() {
        var chatbot = document.getElementById('chatbot');
        if (chatbot.style.display === 'none' || chatbot.style.display === '') {
            chatbot.style.display = 'block';
        } else {
            chatbot.style.display = 'none';
        }
    }

    function sendMessage() {
        var userMessage = document.getElementById('userMessage').value;
        if (userMessage.trim() === '') return;

        var messages = document.getElementById('messages');
        messages.innerHTML += '<div><strong>Vous:</strong> ' + userMessage + '</div>';
        
        document.getElementById('userMessage').value = '';

        fetch('/botman', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ message: userMessage }),
        })
        .then(response => response.json())
        .then(data => {
            messages.innerHTML += '<div><strong>Bot:</strong> ' + data.reply + '</div>';
        });
    }
</script>
