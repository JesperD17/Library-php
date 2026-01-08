<?php

function renderPage($view, $data) {
    $auth = $data;
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Library PHP</title>
        <?php include 'includes/styles.php'; ?>
        <?php include 'includes/js.php'; ?>
    </head>
    <body>
    <div class="h-100-w-100 flex-col bg-background">
    <?php
    include 'includes/header.php';
    ?>
        <div class="page-width">
            <?php
            include "pages/$view.php";
            ?>
        </div>
    <?php
    include 'includes/footer.php';
    ?>
    </div>
    </body>
    </html>
    <?php
}

function renderAction($view, $data) {
    $auth = $data;
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Action - Library PHP</title>
        <?php include 'includes/styles.php'; ?>
    </head>
    <body>
        <div class="h-100-w-100 flex-col bg-background">
            <div class="page-width">
                <?php
                include "actions/$view.php";
                ?>
            </div>
        </div>
    </body>
    </html>
    <?php
}

function renderErrorPage($view, $data = []) {
    extract($data);
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Action - Library PHP</title>
        <?php include 'includes/styles.php'; ?>
    </head>
    <body>
        <div class="h-100-w-100 flex-col bg-background-alt">
            <div class="page-width">
                <?php
                include "pages/$view.php";
                ?>
            </div>
        </div>
    </body>
    </html>
    <?php
}

?>