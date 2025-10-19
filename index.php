<?php
require 'includes/template.php';

$page = $_GET['page'] ?? 'home';
$page = trim($page, '/');
if ($page === '') $page = 'home';

$path = "pages/$page.php";

if (file_exists($path)) {
    render($page);
} else {
    http_response_code(404);
    include 'pages/404.php';
}