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
    <title>Admin Chat</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #0e0f11;
            color: white;
        }

        /* ===== HEADER ===== */
        .chat-header {
            height: 60px;
            background: rgba(18,18,18,0.95);
            display: flex;
            align-items: center;
            padding: 0 20px;
            border-bottom: 1px solid #262626;
            backdrop-filter: blur(8px);
        }

        .back-btn {
            background: transparent;
            border: 1px solid #262626;
            color:  #9526F3;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            margin-right: 15px;
            transition: 0.3s;
        }

        .back-btn:hover {
            background: #9526F3;
            color: #fff;
        }

        .chat-title {
            font-size: 18px;
            font-weight: bold;
            color: #9526F3;
        }

        /* ===== MAIN ===== */
        .chat-container {
            display: flex;
            height: calc(100vh - 60px);
        }

        /* ===== USER LIST ===== */
        .user-list {
            width: 25%;
            background: #121212;
            border-right: 1px solid  #262626;
            overflow-y: auto;
        }

        .user-item {
            padding: 12px;
            cursor: pointer;
            border-bottom: 1px solid #262626;
            display: flex;
            flex-direction: column;
            gap: 4px;
            transition: 0.3s;
        }

        .user-item:hover {
            background: #1e1e1e;
        }

        .active-user {
            background: #1e1e1e;
            border-left: 3px solid #9526F3;
        }

        .unread {
            border-left: 3px solid #9526F3;
        }

        /* ===== CHAT ===== */
        .chat-section {
            width: 75%;
            display: flex;
            flex-direction: column;
        }

        .chat-box {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .message {
            margin: 10px 0;
            max-width: 65%;
            padding: 10px 12px;
            border-radius: 12px;
            font-size: 14px;
            transition: 0.3s;
        }
        .message:hover {
            transform: scale(1.02);
        }
        .sent {
            background: linear-gradient(135deg, #9526F3, #7a1fd6, #b44cff);
            margin-left: auto;
            box-shadow: 0 0 10px rgba(149, 38, 243, 0.4);
        }

        .received {
            background: #121212;
            border: 1px solid #262626;
        }

        .meta {
            font-size: 11px;
            margin-top: 5px;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            color: #cbd5f5;
        }

        /* ===== INPUT ===== */
        .input-box {
            display: flex;
            padding: 10px;
            gap: 10px;
            border-top: 1px solid #262626;
            background: rgba(18,18,18,0.95);
        }

        .input-box input {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #262626;
            background: #121212;
            color: white;
            transition: 0.3s;
        }
        .input-box input:focus {
            border-color: #9526F3;
            box-shadow: 0 0 8px rgba(149, 38, 243, 0.4);
        }
        .input-box button {
            padding: 10px 16px;
            border-radius: 8px;
            border:  2px solid #9526F3;
            background: transparent;
            color: #9526F3;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .input-box button::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #9526F3, #7a1fd6, #b44cff);
            transform: scaleX(0);
            transform-origin: left;
            transition: 0.4s ease;
            z-index: 0;
        }
        /* text layer */
        .input-box button span {
            position: relative;
            z-index: 2;
        }

        /* hover */
        .input-box button:hover::before {
            transform: scaleX(1);
        }

        .input-box button:hover span {
            color: #fff;
        }

        /* DELETE BUTTON */
        .delete-btn {
            background: rgba(239, 68, 68, 0.15);
            border: none;
            color: #ef4444;
            padding: 4px 8px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            transition: 0.2s;
        }

        .delete-btn:hover {
            background: #ef4444;
            color: white;
        }
    </style>
</head>

<body>

<!-- HEADER -->
<div class="chat-header">
    <button class="back-btn" onclick="goBack()">← Back</button>
    <div class="chat-title">Admin Chat</div>
</div>

<div class="chat-container">

    <!-- USERS -->
    <div class="user-list" id="user-list"></div>

    <!-- CHAT -->
    <div class="chat-section">

        <div id="chat-box" class="chat-box"></div>

        <div class="input-box">
            <input type="text" id="message" placeholder="Type message...">
            <button onclick="sendMessage()"><span> Send</span></button>
        </div>

    </div>

</div>

<script>
function goBack(){
    window.location.href = "dashboard.php";
}

document.addEventListener("DOMContentLoaded", function () {

    let selectedUser = null;
    let currentUserId = <?php echo $_SESSION['user_id']; ?>;
    let urlParams = new URLSearchParams(window.location.search);
    let preSelectedUser = urlParams.get("user_id");
    let inputField = document.getElementById("message");

    // 🔒 DISABLE INPUT INITIALLY
    inputField.disabled = true;

    function loadUsers() {
        fetch("../chat/get_users.php")
        .then(res => res.json())
        .then(data => {

            let html = "";

            data.forEach(u => {

    let unread = u.unread_count > 0;

    let isActive = (preSelectedUser == u.id);

    html += `
    <div onclick="selectUser(${u.id}, this)" 
         class="user-item ${unread ? 'unread' : ''} ${isActive ? 'active-user' : ''}">
        
        <div style="font-weight:bold;">
            ${u.name}
            <span style="color:#f97316;font-size:12px;">
                (${u.role})
            </span>
        </div>

        <div style="font-size:12px;color:#94a3b8;">
            ${u.last_message ?? ''}
        </div>

        ${unread ? `
            <span style="
                background:#f97316;
                font-size:11px;
                padding:2px 6px;
                border-radius:10px;
                align-self:flex-end;">
                ${u.unread_count}
            </span>` : ''}
    </div>`;
});

            document.getElementById("user-list").innerHTML = html;
            // 🔥 AUTO SELECT FROM URL
if(preSelectedUser){
    let el = document.querySelector(`[onclick*="selectUser(${preSelectedUser}"]`);
    if(el){
        selectUser(preSelectedUser, el);
        preSelectedUser = null; // prevent repeat
    }
}
        });
    }

    window.selectUser = function(id, el) {
        selectedUser = id;

        // ✅ ENABLE INPUT WHEN USER SELECTED
        inputField.disabled = false;
        inputField.focus();

        document.querySelectorAll(".user-item").forEach(e => e.classList.remove("active-user"));
        el.classList.add("active-user");

        loadMessages();
    }

    window.sendMessage = function() {
        let msg = inputField.value.trim();

        if (!selectedUser) return;
        if (msg === "") return;

        fetch("../chat/send_message.php", {
            method: "POST",
            headers: {"Content-Type":"application/x-www-form-urlencoded"},
            body: `receiver_id=${selectedUser}&message=${encodeURIComponent(msg)}`
        }).then(() => {
            inputField.value = "";
            inputField.focus(); // smooth typing
            loadMessages();
            loadUsers();
        });
    }

    // ✅ ENTER KEY SUPPORT
    inputField.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();

            if (!selectedUser) return;
            if (inputField.value.trim() === "") return;

            sendMessage();
        }
    });

    window.deleteMessage = function(id){
        if(confirm("Delete this message?")){
            fetch("../chat/delete_message.php", {
                method: "POST",
                headers: {"Content-Type":"application/x-www-form-urlencoded"},
                body: `message_id=${id}`
            }).then(loadMessages);
        }
    }

    function loadMessages() {
        if (!selectedUser) return;

        fetch(`../chat/fetch_messages.php?receiver_id=${selectedUser}`)
        .then(res => res.json())
        .then(data => {

            let html = "";

            data.forEach(m => {

                let type = m.sender_id == currentUserId ? "sent" : "received";

                let time = new Date(m.created_at).toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                if(type === "sent"){
                    let status = m.is_read == 1 ? "✔✔" : "✔";

                    html += `
                    <div class="message ${type}">
                        ${m.message}
                        <div class="meta">
                            <span>${time}</span>
                            <span>${status}</span>
                            <button class="delete-btn" onclick="deleteMessage(${m.message_id})">🗑</button>
                        </div>
                    </div>`;
                } else {
                    html += `
                    <div class="message ${type}">
                        ${m.message}
                        <div class="meta" style="justify-content:flex-start;color:#94a3b8;">
                            ${time}
                        </div>
                    </div>`;
                }

            });

            let box = document.getElementById("chat-box");
            box.innerHTML = html;
            box.scrollTop = box.scrollHeight;
        });
    }

    setInterval(() => {
        loadMessages();
        loadUsers();
    }, 1000);

    loadUsers();
});
</script>

</body>
</html>