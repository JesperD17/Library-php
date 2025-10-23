<?php
session_start();

require 'includes/template.php';

$page = $_GET['page'] ?? 'home';
$page = trim($page, '/');
if ($page === '') $page = 'home';

$path = "pages/$page.php";
$actionPath = "actions/$page.php";

$authPaths = ["search"];

if (file_exists($path) && in_array($page, $authPaths)) {
    include 'actions/includes/authCheck.php';
    if (!requireAuth()) {
        http_response_code(403);
        include 'pages/403.php';
        exit;
    }
    renderPage($page);
} else if (file_exists($path)) {
    renderPage($page);
} else if (file_exists($actionPath)) {
    renderAction($actionPath);
} else {
    http_response_code(404);
    include 'pages/404.php';
}
?>