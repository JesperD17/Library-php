<?php
session_start();
include_once '../includes/dbConnection.php';

if ($_COOKIE['SESSION_TOKEN']) {
    try {
        $remove = $db->prepare("DELETE FROM users WHERE session_token=?");
        $remove->execute([$_COOKIE['SESSION_TOKEN']]);

        setcookie('SESSION_TOKEN', '', time() - 3600, '/');

        header("Location: ../../home");
        exit();
    } catch (PDOException $e) {
        $_SESSION['message'] = [
            'classes' => 'errorMessage',
            'text' => 'Database error. Please try again later.',
            'error' => $e
        ];
        header("Location: ../../profile");
        exit();
    }
} else {
    $_SESSION['message'] = [
        'classes' => 'errorMessage',
        'text' => 'User is not logged in.',
        'error' => $e
    ];
    header("Location: ../../profile");
    exit();
}
?>