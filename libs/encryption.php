<?php
include_once("../env.php");
function encryptMessage($plaintext) {
    $key = hash('sha256', SECRET_KEY, true);

    // Generate random IV (16 bytes for AES-256-CBC)
    $iv = openssl_random_pseudo_bytes(16);

    // Encrypt
    $ciphertext = openssl_encrypt(
        $plaintext,
        'AES-256-CBC',
        $key,
        OPENSSL_RAW_DATA,
        $iv
    );

    // Store IV + encrypted data together
    return base64_encode($iv . $ciphertext);
}

function decryptMessage($encrypted) {
    $key = hash('sha256', SECRET_KEY, true);

    // Decode
    $data = base64_decode($encrypted);

    // Extract IV and ciphertext
    $iv = substr($data, 0, 16);
    $ciphertext = substr($data, 16);

    // Decrypt
    return openssl_decrypt(
        $ciphertext,
        'AES-256-CBC',
        $key,
        OPENSSL_RAW_DATA,
        $iv
    );
}