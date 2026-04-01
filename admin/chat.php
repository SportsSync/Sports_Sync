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
            background: #0f172a;
            color: white;
        }

        /* ===== HEADER ===== */
        .chat-header {
            height: 60px;
            background: #020617;
            display: flex;
            align-items: center;
            padding: 0 20px;
            border-bottom: 1px solid #1e293b;
        }

        .back-btn {
            background: transparent;
            border: 1px solid #1e293b;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            margin-right: 15px;
        }

        .back-btn:hover {
            background: #1e293b;
        }

        .chat-title {
            font-size: 18px;
            font-weight: bold;
        }

        /* ===== MAIN ===== */
        .chat-container {
            display: flex;
            height: calc(100vh - 60px);
        }

        /* ===== USER LIST ===== */
        .user-list {
            width: 25%;
            background: #020617;
            border-right: 1px solid #1e293b;
            overflow-y: auto;
        }

        .user-item {
            padding: 12px;
            cursor: pointer;
            border-bottom: 1px solid #1e293b;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .user-item:hover {
            background: #1e293b;
        }

        .active-user {
            background: #334155;
        }

        .unread {
            border-left: 3px solid #f97316;
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
        }

        .sent {
            background: #f97316;
            margin-left: auto;
        }

        .received {
            background: #1e293b;
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
            border-top: 1px solid #1e293b;
            background: #020617;
        }

        .input-box input {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #1e293b;
            background: #0f172a;
            color: white;
        }

        .input-box button {
            padding: 10px 16px;
            border: none;
            background: #f97316;
            color: white;
            border-radius: 8px;
            cursor: pointer;
        }
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
            <button onclick="sendMessage()">Send</button>
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

    function loadUsers() {
        fetch("../chat/get_users.php")
        .then(res => res.json())
        .then(data => {

            let html = "";

            data.forEach(u => {

                let unread = u.unread_count > 0;

                html += `
                <div onclick="selectUser(${u.id}, this)" 
                     class="user-item ${unread ? 'unread' : ''}">
                    
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
        });
    }

    window.selectUser = function(id, el) {
        selectedUser = id;

        document.querySelectorAll(".user-item").forEach(e => e.classList.remove("active-user"));
        el.classList.add("active-user");

        loadMessages();
    }

    window.sendMessage = function() {
        let input = document.getElementById("message");
        let msg = input.value.trim();

        if (!selectedUser) return alert("Select user first");
        if (msg === "") return;

        fetch("../chat/send_message.php", {
            method: "POST",
            headers: {"Content-Type":"application/x-www-form-urlencoded"},
            body: `receiver_id=${selectedUser}&message=${encodeURIComponent(msg)}`
        }).then(() => {
            input.value = "";
            loadMessages();
            loadUsers();
        });
    }

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
    }, 2000);

    loadUsers();
});
</script>

</body>
</html>