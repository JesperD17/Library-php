<?php
include '../includes/dbConnection.php';

if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
try {
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $hashed = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->bind_param("sss", $_POST['username'], $_POST['email'], $hashed);
    $stmt->execute();

    $_SESSION['message'] = [
        'classes' => 'successMessage',
        'text' => 'Registration successful! You can now <a href="./login">log in.</a>',
    ];
    header("Location: ../../register");
    exit();

} catch (mysqli_sql_exception $e) {
    if ($e->getCode() === 1062) {
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