<?php
// session_start();

function fetchUserData($db) {
    try {
        $token = $_COOKIE['SESSION_TOKEN'] ?? null;
        $stmt = $db->prepare("SELECT username, email, created_at FROM users WHERE session_token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    } catch (PDOException $e) {
        return false;
    }
}