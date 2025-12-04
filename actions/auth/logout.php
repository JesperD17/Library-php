<?php
session_start();
include_once '../includes/dbConnection.php';

if ($_COOKIE['SESSION_TOKEN']) {
    try {
        $users = $db->prepare("SELECT id FROM users WHERE session_token = ?");
        $users->execute([$_COOKIE['SESSION_TOKEN']]);
        $data = $users->fetchAll(PDO::FETCH_ASSOC);
        $userID = $data[0]['id'];

        $update = $db->prepare("UPDATE users SET session_token = NULL WHERE id = ?");
        $update->execute([$user['id']]);

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