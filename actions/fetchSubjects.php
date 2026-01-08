<?php
function returnBooks($subject, $limit, $additionalClasses, $mobileWidth) {
    if (!$subject || !$limit) return;
    $formUrl = "https://openlibrary.org/subjects/$subject.json?limit=$limit";
    
    $response = file_get_contents($formUrl);

    if ($response !== false) {
        $data = json_decode($response, true);
        return dataToHtml($data, $additionalClasses, $mobileWidth, 'works', []);
    } else {
        return false;
    }
}

function dataToHtml($data, $classes, $mobileTrueFalse, $dataType, $urlData) {
    if (!$data) return false;
    $mobileClass = '';
    
    if ($mobileTrueFalse) {
        $mobileClass = 'mobileCards';
    } else {
        $mobileClass = '';
    }

    $coverTypes = [
        'cover_i' => 'b/id/',
        'cover_id' => 'b/id/',
        'cover_edition_key' => 'b/olid/',
        'isbn' => 'b/isbn/',
        'oclc' => 'b/oclc/',
        'lccn' => 'b/lccn/'
    ];

    if (!empty($data['name'])) {
        $html = "
        <div class='h1 padding-btm'>
            {$data['name']}
        </div>
        ";
    } else {
        $html = "";
    }
    
    if (!empty($urlData)) {
        $foundNumber = $data['work_count'] ?? $data['numFound'] ?? 0;
        $limit = max(1, (int)($urlData['limit'] ?? 10));
        $page = max(1, (int)($urlData['pageNumber'] ?? 1));
        $totalPages = max(1, (int)ceil($foundNumber / $limit));
        $page = min($page, $totalPages);
        $query = urlencode($urlData['query'] ?? '');

        $html .= "
        <div class='padding-btm flex-row justify-between'>
            {$foundNumber} results
            <div class='flex-row gap'>";
                if ($page > 3) {
                    $html .= "<a href='./search?query={$query}&pageNumber=1' class='link'>1</a><span>…</span>";
                }

                if ($page > 1) {
                    $prev = $page - 1;
                    $html .= "<a href='./search?query={$query}&pageNumber={$prev}' class='link'>&laquo; {$prev}</a>";
                }
                $html .= "<a href='./search?query={$query}&pageNumber={$page}' class='bold link'>{$page}</a>";

                $maxNext = min($totalPages, $page + 2);
                for ($p = $page + 1; $p <= $maxNext; $p++) {
                    $html .= "<a href='./search?query={$query}&pageNumber={$p}' class='link'>{$p}</a>";
                }

                if ($page + 2 < $totalPages) {
                    $html .= "<span>…</span><a href='./search?query={$query}&pageNumber={$totalPages}' class='link'>{$totalPages}</a>";
                }
        $html .= "
            </div>
        </div>
        ";
    }

    $html .= "
    <div class='gap-s margin-btm padding-btm $classes'>
    ";
    foreach ($data[$dataType] as $book) {
        $coverURL = "assets/img/failed-to-load.png";
        $coverEr = false;

        foreach ($coverTypes as $key => $path) {
            if (!empty($book[$key])) {
                $value = is_array($book[$key]) ? $book[$key][0] : $book[$key];
                $coverURL = "https://covers.openlibrary.org/{$path}{$value}-M.jpg";
                break;
            }
        }

        if ($coverURL == "assets/img/failed-to-load.png") {
            $coverEr = true;
        }

        $authorName = $book['authors'][0]['name'] ?? $book['author_name'][0] ?? 'Unknown Author';
        $title = htmlspecialchars($book['title'] ?? 'Untitled', ENT_QUOTES);

        $bookKey = str_replace('/works/', '', $book['key'] ?? '');

        $html .= "
        <a class='$mobileClass link' href='./book?id={$bookKey}'>
            <div class='flex-col book justify-between'>
                <img class='skeleton "; 
                if ($coverEr == true) $html .= "objCover";
                $html .= "' src='$coverURL' alt='$title'>
                <div class='padding-all'>
                    <div class='bold two-lines'>$title</div>
                    <div class='two-lines'>$authorName</div>
                </div>
            </div>
        </a>";
    }
    $html .= "
    </div>
    ";
    return $html;
}