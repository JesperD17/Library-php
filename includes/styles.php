<style>
    <?php
    function poppinFonts() {
        return "@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');";
    }
    echo poppinFonts();
    $css = file_get_contents(__DIR__ . '/../assets/global.css') . "\n";
    $css .= file_get_contents(__DIR__ . '/../assets/forms.css');
    echo $css;
    ?>
</style>