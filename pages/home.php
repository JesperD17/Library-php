<?php
include "actions/includes/dbConnection.php";
echo "Visitor";

$url = "https://openlibrary.org/subjects/classics.json?limit=10";
$response = file_get_contents($url);
$trueFalse;
$coverArray = [];

if ($response !== false) {
    $data = json_decode($response, true);
    $trueFalse = true;
} else {
    $trueFalse = false;
}

$testurl = "https://openlibrary.org/works/OL138052W.json";

?>

<?php if ($trueFalse) { ?>
    <div class="h1">
        <?php echo($data['name']) ?>
    </div>
    <div class="flex-row scroll-y gap-s padding-btm">
        <?php foreach ($data['works'] as $book) { ?>
            <?php 
                $coverID = $book['cover_id'] ?? null;
                $coverURL = $coverID 
                    ? "https://covers.openlibrary.org/b/id/{$coverID}-M.jpg"
                    : "assets/img/failed-to-load.png";
            ?>
            <a href="">
                <div class="flex-col book justify-between">
                    <img class="skeleton" src="<?php echo $coverURL ?>" alt="<?php echo $book['title'] ?>">
                    <div class="padding-all">
                        <div class="bold"><?php echo $book['title'] ?></div>
                        <div><?php echo $book['authors'][0]['name'] ?></div>
                    </div>
                </div>
            </a>
        <?php } ?>
    </div>
<?php } else { ?>
    <div>Failed to fetch data.</div>
<?php } ?>