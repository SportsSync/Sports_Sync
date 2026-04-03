<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Login required";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vendor Chat</title>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #0b1120;
            color: white;
        }

        .chat-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .header {
            padding: 15px 20px;
            font-size: 18px;
            font-weight: bold;
            background: #020617;
            border-bottom: 1px solid #1e293b;
        }

        .chat-box {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .message {
            margin: 10px 0;
            max-width: 60%;
            padding: 12px;
            border-radius: 12px;
            position: relative;
        }

        .sent {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            margin-left: auto;
        }

        .received {
            background: #1e293b;
        }

        .meta {
            font-size: 10px;
            margin-top: 5px;
            text-align: right;
            color: #cbd5f5;
        }

        .delete-btn {
            position: absolute;
            top: 5px;
            right: 8px;
            background: transparent;
            border: none;
            color: #fff;
            font-size: 12px;
            cursor: pointer;
        }

        .input-box {
            display: flex;
            padding: 10px;
            background: #020617;
            border-top: 1px solid #1e293b;
        }

        .input-box input {
            flex: 1;
            padding: 12px;
            border-radius: 8px;
            border: none;
            outline: none;
            background: #1e293b;
            color: white;
        }

        .input-box button {
            margin-left: 10px;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="chat-container">

    <div class="header">Chat with Admin</div>

    <div id="chat-box" class="chat-box"></div>

    <div class="input-box">
        <input type="text" id="message" placeholder="Type message...">
        <button onclick="sendMessage()">Send</button>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    let currentUserId = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; ?>;

    function sendMessage() {
        let input = document.getElementById("message");
        let msg = input.value.trim();

        if (msg === "") return;

        fetch("../chat/send_message.php", {
            method: "POST",
            headers: {"Content-Type":"application/x-www-form-urlencoded"},
            body: `message=${encodeURIComponent(msg)}`
        })
        .then(() => {
            input.value = "";
            loadMessages();
        });
    }

    // SEND MESSAGE ON ENTER KEY
    let inputField = document.getElementById("message");

    inputField.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault(); // stop any default behavior
            sendMessage();
        }
    });

    // 🔥 CONFIRM DELETE
    function deleteMessage(id){
        if(confirm("Are you sure you want to delete this message?")){
            fetch("../chat/delete_message.php", {
                method: "POST",
                headers: {"Content-Type":"application/x-www-form-urlencoded"},
                body: `message_id=${id}`
            }).then(loadMessages);
        }
    }

    function loadMessages() {
        fetch("../chat/fetch_messages.php")
        .then(res => res.json())
        .then(data => {

            let chatBox = document.getElementById("chat-box");
            let html = "";

           data.forEach(m => {

    let type = (m.sender_id == currentUserId) ? "sent" : "received";

    // 🕒 FORMAT TIME
    let time = new Date(m.created_at);
    let formattedTime = time.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

    if(type === "sent"){
        let status = m.is_read == 1 ? "seen" : "delivered";

        html += `
        <div class="message ${type}">
            ${m.message}
            <button class="delete-btn" onclick="deleteMessage(${m.message_id})">x</button>

            <div class="meta">
                ${formattedTime} &nbsp; ${status}
            </div>
        </div>`;
    } else {
        html += `
        <div class="message ${type}">
            ${m.message}

            <div class="meta">
                ${formattedTime}
            </div>
        </div>`;
    }
});

            chatBox.innerHTML = html;
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    }

    window.sendMessage = sendMessage;
    window.deleteMessage = deleteMessage;

    setInterval(loadMessages, 3000);
    loadMessages();
});
</script>

</body>
</html>