<?php
session_start();

// 🔒 ROLE CHECK (FIXED: consistent lowercase)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Vendor') {
    die("❌ Unauthorized Access");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Scan QR - Vendor Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- QR LIBRARY -->
    <script src="https://unpkg.com/html5-qrcode"></script>

    <style>
        #reader {
    position: relative;
}

#reader::after {
    content: "";
    position: absolute;
    border: 3px solid #22c55e;
    width: 260px;
    height: 260px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-radius: 12px;
}
        body {
            margin: 0;
            font-family: Arial;
            background: #020617;
            color: #e5e7eb;
            text-align: center;
        }

        h2 { margin-top: 20px; }

        #reader {
            width: 320px;
            margin: 20px auto;
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid #1f2937;
        }

        .msg {
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
            padding: 12px;
            border-radius: 10px;
            display: none;
        }

        .success { background: #22c55e; color: #020617; }
        .error { background: #ef4444; color: #fff; }

        button {
            margin-top: 15px;
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            background: #6366f1;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover { background: #4f46e5; }
    </style>
</head>

<body>

<h2>📷 Scan Booking QR</h2>

<div id="reader"></div>

<div id="resultBox" class="msg"></div>

<button onclick="startScanner()">▶ Start Scanner</button>

<script>
let scanner;

/* =========================
   START SCANNER (FIXED)
========================= */
function startScanner() {

    document.getElementById("resultBox").style.display = "none";

    // 🔥 CLEAR OLD INSTANCE PROPERLY
    if (scanner) {
        try {
            scanner.clear();
        } catch(e) {}
    }

    scanner = new Html5Qrcode("reader");

    scanner.start(
        { facingMode: "environment" },
        {
            fps: 25,
            qrbox: 280,
            aspectRatio: 1.777
        },
        onScanSuccess,
        onScanError
    ).catch(err => {
        console.error(err);
        showError("❌ Camera error");
    });
}

/* =========================
   SUCCESS SCAN
========================= */
async function onScanSuccess(decodedText) {

    console.log("QR:", decodedText);

    try {
        await scanner.stop();
        await scanner.clear(); // 🔥 IMPORTANT (you missed this)
    } catch (e) {}

    let token = decodedText.trim();

    fetch("api/verify_api.php", {
        method: "POST",
        credentials: "same-origin",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ token: token })
    })
    .then(async res => {
        let text = await res.text();

        try {
            let data = JSON.parse(text);

            let msg = data.msg;

            if (data.slots) {
                msg += "\n\n🕒 Slots:\n" + data.slots;
            }

            if (data.current_time) {
                msg += "\n⌚ Time: " + data.current_time;
            }

            if (data.status === "success") {
                showSuccess(msg);
            } else {
                showError(msg);
            }

        } catch {
            showError("❌ Invalid JSON:\n" + text);
        }
    })
    .catch(err => {
        showError("❌ FETCH ERROR: " + err);
    });
}

/* =========================
   IGNORE NOISE
========================= */
function onScanError(err) {
    // ignore
}

/* =========================
   UI HELPERS
========================= */
function showSuccess(msg) {
    let box = document.getElementById("resultBox");
    box.className = "msg success";
    box.innerText = msg;
    box.style.display = "block";
}

function showError(msg) {
    let box = document.getElementById("resultBox");
    box.className = "msg error";
    box.innerText = msg;
    box.style.display = "block";
}
window.onload = () => {
    startScanner();
};
</script>

</body>
</html>