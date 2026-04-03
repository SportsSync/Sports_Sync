<?php
session_start();
header('Content-Type: application/json');

require 'config.php';

$data = json_decode(file_get_contents("php://input"), true);
$amount = (float)($data['amount'] ?? 0);

if ($amount <= 0) {
    echo json_encode(['error' => 'Invalid amount']);
    exit;
}

// 🚀 REAL ORDER CREATION (Server-Side)
// We use CURL to call the Razorpay API with your Key ID and Key Secret
$payload = json_encode([
    'amount'   => $amount * 100, // paises
    'currency' => 'INR',
    'receipt'  => 'rcpt_' . time()
]);

$ch = curl_init('https://api.razorpay.com/v1/orders');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_USERPWD, RAZORPAY_KEY_ID . ":" . RAZORPAY_KEY_SECRET);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code !== 200) {
    echo json_encode(['error' => 'Razorpay API Error: ' . $response]);
    exit;
}

echo $response; // Return the REAL Razorpay Order (including the real ID)