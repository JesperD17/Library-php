<?php
include '../includes/dbConnection.php';

function index($userData, $conn) {
    $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'], 3), '../');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
        try {
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $hashed = password_hash($userData['password'], PASSWORD_BCRYPT);
            $stmt->bind_param("sss", $userData['username'], $userData['email'], $hashed);
    
            $stmt->execute();
            header("Location: $basePath/register?success=true");
            exit();
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) {
                // echo "Error: Duplicate entry.";
                header("Location: $basePath/register?success=false&error=duplicate");
            } else {
                // echo "SQL Error: " . $e->getMessage();
                header("Location: $basePath/register?success=false&error=sql");
            }
            exit();
        }
    } else {
        header("Location: $basePath/404");
        exit;
    }
    $stmt->close();
    $conn->close();
}
index($_POST, $conn);
?>