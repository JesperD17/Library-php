<?php

function requireAuth() {
    $db = include __DIR__ . '/../includes/dbConnection.php';

    try {
        $token = $_COOKIE['SESSION_TOKEN'] ?? null;
        $stmt = $db->prepare("SELECT id FROM users WHERE session_token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return (bool) $user;
    } catch (PDOException $e) {
        return false;
    }
}
?>