<?php

function renderPage($view, $data = []) {
    extract($data);
    include 'includes/styles.php';
    ?>
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
    <?php
}

function renderAction($view, $data = []) {
    extract($data);
    include 'includes/styles.php';
    ?> 
        <div class="h-100-w-100 flex-col bg-background">
            <div class="page-width"> 
                <?php
                include "actions/$view.php";
                ?>
            </div>
        </div>
    <?php
}

?>