<?php
function returnBooks($subject, $limit, $additionalClasses, $mobileWidth) {
    if (!$subject || !$limit) return;
    $formUrl = "https://openlibrary.org/subjects/$subject.json?limit=$limit";
    
    $response = file_get_contents($formUrl);

    if ($response !== false) {
        $data = json_decode($response, true);
        return dataToHtml($data, $additionalClasses, $mobileWidth);
    } else {
        return false;
    }
}

function dataToHtml($data, $classes, $mobileTrueFalse) {
    if (!$data) return false;
    $mobileClass = '';

    if ($mobileTrueFalse) {
        $mobileClass = 'mobileCards';
    } else {
        $mobileClass = '';
    }

    $html = "
    <div class='h1 padding-btm'>
        {$data['name']}
    </div>
    <div class='gap-s margin-btm padding-btm $classes'>
    ";
    foreach ($data['works'] as $book) {
        $coverID = $book['cover_id'] ?? null;
        $coverURL = $coverID 
            ? "https://covers.openlibrary.org/b/id/{$coverID}-M.jpg"
            : "assets/img/failed-to-load.png";

        $html .= "<a class='$mobileClass' href=''>
            <div class='flex-col book justify-between'>
                <img class='skeleton' src='$coverURL' alt='{$book['title']}'>
                <div class='padding-all'>
                    <div class='bold'>{$book['title']}</div>
                    <div>{$book['authors'][0]['name']}</div>
                </div>
            </div>
        </a>";
    }
    $html .= "
    </div>
    ";
    return $html;
}