<?php
session_start();

require 'includes/template.php';
include 'actions/includes/authCheck.php';

function hasInternetConnection(): bool {
    $connected = @fsockopen("www.google.com", 80, $errno, $errstr, 3);
    if ($connected) {
        fclose($connected);
        return true;
    }
    return false;
}

// check if user has wifi
if (!hasInternetConnection()) {
    renderErrorPage('no-wifi');
    exit;
}

$prop = requireAuth();

$page = $_GET['page'] ?? 'home';
$page = trim($page, '/');
if ($page === '') $page = 'home';

$path = "pages/$page.php";
$actionPath = "actions/$page.php";
$actionAuthPath = "actions/auth/$page.php";
$actionIncludePath = "actions/includes/$page.php";

$authPaths = ["profile"];

if (file_exists($path) && in_array($page, $authPaths)) {
    if (!requireAuth()) {
        renderErrorPage('403');
        exit;
    } else {
        renderPage($page, $prop);
    }
} else if (file_exists($path)) {
    renderPage($page, $prop);
} else if (file_exists($actionPath)) {
    renderAction($actionPath, $prop);
} else {
    renderErrorPage('404');
}
?>