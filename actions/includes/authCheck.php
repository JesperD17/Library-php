<?php

function requireAuth() {
    require_once __DIR__ . '/../includes/dbConnection.php';
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
    try {
        $token = $_COOKIE['SESSION_TOKEN'] ?? null;
        $stmt = $conn->prepare("SELECT id FROM users WHERE session_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        return (bool) $user;
    } catch (mysqli_sql_exception $e) {
        return false;
    }
}
?>