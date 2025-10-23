<?php
include '../includes/dbConnection.php';

if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
try {
    $users = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $users->bind_param("s", $_POST['email']);
    $users->execute();
    $result = $users->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $passHashDB = $data[0]['password'];
    $user = $data[0]['id'];

    if (password_verify($_POST['password'], $passHashDB)) {
        if ($currentToken = $data[0]['session_token'] === null || $currentToken = $data[0]['session_token']) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            $length = 250;

            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[random_int(0, $charactersLength - 1)];
            }

            setcookie("SESSION_TOKEN", $randomString, time() + (365 * 24 * 60 * 60) , "/");
            $stmt = $conn->prepare("UPDATE users SET session_token = ? WHERE id = ?");
            $stmt->bind_param("si", $randomString, $user);
            $stmt->execute();
            
            $_SESSION['message'] = [
                'classes' => 'successMessage',
                'text' => 'Login successful! Redirecting...',
            ];
            header("Location: ../../");
            exit();
        }
    } else {
        $_SESSION['message'] = [
            'classes' => 'errorMessage',
            'text' => 'These credentials do not match our records.'
        ];
        header("Location: ../../login");
        exit();
    }
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() === 1062) {
        $_SESSION['message'] = [
            'classes' => 'errorMessage',
            'text' => 'These credentials do not match our records. aaa'
        ];
    } else {
        $_SESSION['message'] = [
            'classes' => 'errorMessage',
            'text' => 'Database error. Please try again later.'
        ];
    }
    header("Location: ../../login");
    exit();
}

?>