<?php
include './actions/auth/fetchUserData.php';

$db = include './actions/includes/dbConnection.php';
$userJson = fetchUserData($db);
?>

<div class="h-100-w-100 flex-center">
    <?php if (is_array($userJson)) { ?>
    <div class="flex-col gap full-width">
        <div class="flex-row justify-between gap">
            <div>
                Name: 
            </div>
            <div class="scroll-y">
                <?php echo $userJson['username']; ?>
            </div>
        </div>
        <div class="flex-row justify-between gap">
            <div>
                Email: 
            </div>
            <div class="scroll-y">
                <?php echo $userJson['email']; ?>
            </div>
        </div>
        <div class="flex-row justify-between gap">
            <div>
                Account created: 
            </div>
            <div class="scroll-y">
                <?php echo $userJson['created_at']; ?>
            </div>
        </div>
        <div class="flex-row justify-between gap">
            <form action="./actions/auth/logout.php" method="GET">
                <button class="btn" type="submit">Logout</button>
            </form>
            <form action="./actions/auth/removeUser.php" method="DELETE">
                <button class="btn" type="submit">Delete account</button>
            </form>
        </div>
    </div>
    <?php } else { ?>
    <div>
        Failed to load user data.
    </div>
    <?php } ?>
</div>