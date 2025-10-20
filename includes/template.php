<?php

function renderPage($view, $data = []) {
    extract($data);
    include 'includes/header.php';
    include "pages/$view.php";
    include 'includes/footer.php';
}

function renderAction($view, $data = []) {
    extract($data);
    include "actions/$view.php";
}

?>