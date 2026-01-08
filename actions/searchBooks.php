<?php
include "./actions/fetchSubjects.php";

$urlData = [
    "query" => $query,
    "pageNumber" => $pageNumber,
    "limit" => $limit
];

if ($pageNumber == 'error') {
    $pageNumber = 1;
}

$formUrl = "https://openlibrary.org/search.json?q=$query&page=$pageNumber&limit=$limit";

try {
    $response = @file_get_contents($formUrl);
    if ($response === false) {
        throw new Exception("Failed to fetch data from API.");
    }
    $data = json_decode($response, true);
    echo dataToHtml($data, 'flex-row wrap justify-center', true, 'docs', $urlData);
} catch (Exception $e) {
    echo "<div class='errorMessage'>An error occurred while fetching the data <div class='hide'>$e</div></div>";
}
?>