<?php
include 'actions/includes/authCheck.php';

$auth = requireAuth();
?>

<div class="flex-row justify-between padding-all bg-background-alt border-btm">
    <div class="logo"><i class='bx bx-book-bookmark'></i> Library PHP</div>
    <div class="openMenuBtn hideDesktop">
        <div class="flex-row align-center gap-s" onclick="openCloseMenu(event)">
            Open
            <i class='icon-s bx bx-chevron-right'></i>
        </div>
        <div class="flex-col flex-align gap border hide-menu dropdown-menu">
            <a class="link" href="./home">Home</a>
            <a class="link" href="./search">Search</a>
            <?php if (!$auth) { ?>
            <a class="link" href="./login">Login</a>
            <a class="link" href="./register">Register</a>
            <?php } else { ?>
            <a class="link" href="./profile">Profile</a>
            <?php } ?>
        </div>
    </div>
    <div class="flex-row flex-align gap hideMobile">
        <a class="link" href="./home">Home</a>
        <a class="link" href="./search">Search</a>
        <?php if (!$auth) { ?>
        <a class="link" href="./login">Login</a>
        <a class="link" href="./register">Register</a>
        <?php } else { ?>
        <a class="link" href="./profile">Profile</a>
        <?php } ?>
    </div>
</div>