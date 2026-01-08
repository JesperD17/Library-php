<div>
    <div class="h1">Search books</div>
    <div class="flex-col gap">
        <form action="" method="GET">
            <input class="border full-width" type="text" name="query" placeholder="Search..." required minlength="5">
        </form>
        <?php
        if (isset($_GET['query'])) {
            $query = $_GET['query'] ?? 'error';
            $pageNumber = $_GET['pageNumber'] ?? 'error';
            $limit = 20;
            include './actions/searchBooks.php';
        }
        ?>
    </div>
</div>