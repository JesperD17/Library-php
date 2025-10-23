<style>
    <?php
    function poppinFonts() {
        return "@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');";
    }
    function boxiconsFonts() {
        return "@import url('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');";
    }
    echo poppinFonts();
    echo boxiconsFonts();
    $css = file_get_contents(__DIR__ . '/../assets/global.css') . "\n";
    $css .= file_get_contents(__DIR__ . '/../assets/forms.css') . "\n";
    $css .= file_get_contents(__DIR__ . '/../assets/component.css') . "\n";
    echo $css;
    ?>
</style>