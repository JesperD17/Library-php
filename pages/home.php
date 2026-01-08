<?php
include "actions/fetchSubjects.php";
?>

<div>
    <?php 
    echo returnBooks('classics', 10, 'flex-row scroll-y', false, []);
    echo returnBooks('fiction', 10, 'flex-row wrap', true, []);
    echo returnBooks('programming', 10, 'flex-row scroll-y', false, []);
    echo returnBooks('psychology', 10, 'flex-row wrap', true, []);
    ?>
</div>