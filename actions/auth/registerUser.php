<?php
session_start();
include_once '../includes/dbConnection.php';

try {
    $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $hashed = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->execute([$_POST['username'], $_POST['email'], $hashed]);

    $_SESSION['message'] = [
        'classes' => 'successMessage',
        'text' => 'Registration successful! You can now <a href="./login">log in.</a>',
    ];
    header("Location: ../../register");
    exit();

} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        $_SESSION['message'] = [
            'classes' => 'errorMessage',
            'text' => 'Username or email already taken. Please try again.'
        ];
    } else {
        $_SESSION['message'] = [
            'classes' => 'errorMessage',
            'text' => 'Database error. Please try again later.'
        ];
    }
    header("Location: ../../register");
    exit();
}
?>