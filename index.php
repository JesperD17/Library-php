<?php
session_start();

require 'includes/template.php';

$page = $_GET['page'] ?? 'home';
$page = trim($page, '/');
if ($page === '') $page = 'home';

$path = "pages/$page.php";
$actionPath = "actions/$page.php";

$authPaths = ["profile"];

if (file_exists($path) && in_array($page, $authPaths)) {
    include 'actions/includes/authCheck.php';
    if (!requireAuth()) {
        renderErrorPage('403');
        exit;
    } else {
        renderPage($page);
    }
} else if (file_exists($path)) {
    renderPage($page);
} else if (file_exists($actionPath)) {
    renderAction($actionPath);
} else {
    renderErrorPage('404');
}
?>