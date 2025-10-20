<?php
require 'includes/template.php';

$page = $_GET['page'] ?? 'home';
$page = trim($page, '/');
if ($page === '') $page = 'home';

$path = "pages/$page.php";
$actionPath = "actions/$page.php";

if (file_exists($path)) {
    renderPage($page);
} else if (file_exists($actionPath)) {
    renderAction($actionPath);
} else {
    http_response_code(404);
    include 'pages/404.php';
}
?>