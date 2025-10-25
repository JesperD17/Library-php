<script>
    <?php
    $js = file_get_contents(__DIR__ . '/../assets/js/global.js');
    if ($js !== false) {
        echo $js;
    } 
    ?>
</script>