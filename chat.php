<?php
include 'db.php';
$lifetime = 60 * 60 * 48; // 48 hours in seconds
session_set_cookie_params([
    'lifetime' => $lifetime,
    'path' => '/',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();
if (!isset($_SESSION['room_id']) || !isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

$room_id = $_SESSION['room_id'];
$user_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chat Room</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
            padding: 20px;
        }

        #chat-box {
            height: 400px;
            overflow-y: auto;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            background: #fff;
            margin-bottom: 15px;
        }

        .message {
            max-width: 70%;
            padding: 10px 15px;
            margin: 10px 0;
            border-radius: 20px;
            position: relative;
            word-wrap: break-word;
        }

        .mine {
            background-color: #dcf8c6;
            align-self: flex-start;
            margin-left: auto;
            border-bottom-right-radius: 0;
        }

        .theirs {
            background-color: #e8e8e8;
            align-self: flex-end;
            margin-right: auto;
            border-bottom-left-radius: 0;
        }

        .timestamp {
            font-size: 10px;
            color: gray;
            margin-top: 5px;
            text-align: right;
        }

        .date-separator {
            text-align: center;
            margin: 15px 0;
            color: #555;
            font-size: 13px;
        }

        #chat-form {
            display: flex;
            gap: 10px;
        }

        #msg {
            flex: 1;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            padding: 10px 15px;
            border-radius: 20px;
            border: none;
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Room Chat | Logged in as <?php echo htmlspecialchars($user_name); ?></h3>
        <div id="chat-box"></div>

        <form id="chat-form">
            <input type="text" id="msg" placeholder="Type your message..." required />
            <button type="submit">Send</button>
        </form>
    </div>

    <script>
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const msgInput = document.getElementById('msg');
        const userName = "<?php echo $_SESSION['user_name']; ?>";

        function loadMessages() {
            fetch('getMessages.php')
                .then(res => res.json())
                .then(data => {
                    chatBox.innerHTML = '';
                    let lastDate = '';

                    data.forEach(msg => {
                        const msgDate = new Date(msg.timestamp).toDateString();
                        const msgTime = new Date(msg.timestamp).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

                        if (msgDate !== lastDate) {
                            const dateSep = document.createElement('div');
                            dateSep.className = 'date-separator';
                            dateSep.textContent = msgDate;
                            chatBox.appendChild(dateSep);
                            lastDate = msgDate;
                        }

                        const div = document.createElement('div');
                        div.className = 'message ' + (msg.sender_name === userName ? 'mine' : 'theirs');
                        div.innerHTML = `<strong>${msg.sender_name}</strong><br>${msg.message}<div class="timestamp">${msgTime}</div>`;
                        chatBox.appendChild(div);
                    });

                    chatBox.scrollTop = chatBox.scrollHeight;
                });
        }

        chatForm.onsubmit = function(e) {
            e.preventDefault();
            const message = msgInput.value.trim();
            if (message === "") return;

            fetch('sendMessage.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'message=' + encodeURIComponent(message)
            }).then(() => {
                msgInput.value = '';
                loadMessages();
            });
        };

        setInterval(loadMessages, 1000);
        loadMessages();
    </script>
</body>
</html>
