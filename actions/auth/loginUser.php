<?php
include_once '../includes/dbConnection.php';

try {
    $users = $db->prepare("SELECT * FROM users WHERE email = ?");
    $users->execute([$_POST['email']]);
    $data = $users->fetchAll(PDO::FETCH_ASSOC);
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
            $stmt = $db->prepare("UPDATE users SET session_token = ? WHERE id = ?");
            $stmt->execute([$randomString, $user]);
            
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
} catch (PDOException $e) {
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