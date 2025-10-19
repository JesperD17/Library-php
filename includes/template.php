<?php

function render($view, $data = []) {
    extract($data);
    include 'includes/header.php';
    include "pages/$view.php";
    include 'includes/footer.php';
}