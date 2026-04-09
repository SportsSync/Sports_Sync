<?php
session_start();

// 🔒 ROLE CHECK (STRICT)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'vendor') {
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
        body {
            margin: 0;
            font-family: Arial;
            background: #020617;
            color: #e5e7eb;
            text-align: center;
        }

        h2 {
            margin-top: 20px;
        }

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

        .success {
            background: #22c55e;
            color: #020617;
        }

        .error {
            background: #ef4444;
            color: #fff;
        }

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

        button:hover {
            background: #4f46e5;
        }
    </style>
</head>

<body>

<h2>📷 Scan Booking QR</h2>

<div id="reader"></div>

<div id="resultBox" class="msg"></div>

<button onclick="startScanner()">🔄 Scan Again</button>

<script>
let scanner;

/* =========================
   START SCANNER
========================= */
function startScanner() {

    document.getElementById("resultBox").style.display = "none";

    scanner = new Html5Qrcode("reader");

    Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length) {

           let cameraId = devices.find(d => d.label.toLowerCase().includes('back'))?.id || devices[0].id;

            scanner.start(
                cameraId,
                {
                    fps: 10,
                    qrbox: 250
                },
                onScanSuccess,
                onScanError
            );

        } else {
            showError("❌ No camera found");
        }
    }).catch(err => {
        showError("❌ Camera permission denied");
    });
}

/* =========================
   SUCCESS SCAN
========================= */
function onScanSuccess(decodedText) {

    scanner.stop();

    // 🔥 IMPORTANT: assume QR contains ONLY TOKEN
    let token = decodedText.trim();

    fetch("api/verify_api.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ token: token })
    })
    .then(res => res.json())
    .then(data => {

        if (data.status === "success") {
            showSuccess(data.msg || "✅ Entry Allowed");
        } else {
            showError(data.msg || "❌ Invalid");
        }

    })
    .catch(() => {
        showError("❌ Server Error");
    });
}

/* =========================
   SCAN ERROR (IGNORE)
========================= */
function onScanError(error) {
    // ignore frequent scan errors
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

/* =========================
   AUTO START ON LOAD
========================= */
window.onload = () => {
    startScanner();
};
</script>

</body>
</html>