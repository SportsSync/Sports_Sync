<?php

session_start();
include('db.php');

if($_SERVER['REQUEST_METHOD']=="POST")
{
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);


    if ($email === "" || $password === "") {
        echo "Email and password required";
        exit;
    }

    $stmt = $conn->prepare(
        "SELECT id, password FROM user WHERE email = ?"
    );
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            // ✅ LOGIN SUCCESS
            $_SESSION['user_id'] = $user['id'];

            echo "success";
            exit;
        } else {
            echo "Invalid password";
            exit;
        }

    } else {
        echo "Email not registered";
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>