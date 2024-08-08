<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat</title>
<link rel="stylesheet" href="../css/chat.css">
</head>
<body>
    <div class="container">
        <a href="../index.html" class="home-link">Home</a>
        <div class="chat-section">
            <h2>Chat with Your Study Partner</h2>
            <div class="chat-window">
                <div id="messages" class="messages">
                    <!-- Messages will be appended here dynamically -->
                </div>
                <input type="text" id="chat-input" placeholder="Type a message...">
                <button onclick="sendMessage()">Send</button>
            </div>
        </div>

    </div>
<script src="script.js"></script>
</body>
</html>

