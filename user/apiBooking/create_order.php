<?php
session_start();
header('Content-Type: application/json');

// 💡 No SDK needed for testing
$data = json_decode(file_get_contents("php://input"), true);
$amount = (float)($data['amount'] ?? 0);

if ($amount <= 0) {
    echo json_encode(['error' => 'Invalid amount']);
    exit;
}

// Simulate a Razorpay order ID for testing
$order_id = "order_test_" . time(); // unique order id

echo json_encode([
    'id' => $order_id,   // frontend will use this as order_id
    'amount' => $amount * 100, // amount in paise
    'currency' => 'INR'
]);