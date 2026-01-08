<?php                
$key = $_GET['id'] ?? 'not set';
$formUrl = "https://openlibrary.org/works/{$key}.json";
$data = null;
try {
    $response = @file_get_contents($formUrl);
    if ($response === false) {
        throw new Exception("Failed to fetch data from API.");
    }
    $data = json_decode($response, true);
} catch (Exception $e) {
    echo "<div class='errorMessage'>An error occurred while fetching the data <div class='hide'>$e</div></div>";
}
?>

<div>
    <div class="h1 padding-btm"><?php echo $data['title'] ?? ''; ?></div>
    <div class="flex-col gap">
        <div>
            <?php
            if (isset($data['description'])) {
                if (is_array($data['description']) && isset($data['description']['value'])) {
                    echo nl2br(htmlspecialchars($data['description']['value']));
                } elseif (is_string($data['description'])) {
                    echo nl2br(htmlspecialchars($data['description']));
                } else {
                    echo "No description available.";
                }
            } else {
                echo "No description available.";
            }
            ?>
        </div>
        <div>
            <?php if ($data['first_publish_date'] ?? false) { ?>
            <div>First Publish Date:</div>
            <?php echo htmlspecialchars($data['first_publish_date'] ?? 'Unknown'); ?>
            <?php } ?>
        </div>
        <div>
            <?php if (isset($data['authors']) && is_array($data['authors']) && count($data['authors']) > 0) { ?>
            <div>Author(s):</div>
            <?php
                $html = '<div class="flex-col wrap gap-m">';
                foreach ($data['authors'] as $authorIndex => $authorData) {
                    $authorKey = $authorData['author']['key'] ?? $data['authors'][$authorIndex]['author']['key'] ?? '';
                    $authorUrl = "https://openlibrary.org{$authorKey}.json";
                    $authorName = 'Unknown Author';

                    $authorKeyOnly = trim($authorKey, '/authors/');
                    $coverUrl = "https://covers.openlibrary.org/a/olid/{$authorKeyOnly}-S.jpg";
                    // show size of the cover
                    $imgInfo = @getimagesize($coverUrl);
                    if ($imgInfo[0] === 1 && $imgInfo[1] === 1) {
                        $coverUrl = false;
                    }

                    $authorType = $authorData['type']['key'] ?? $data['authors'][$authorIndex]['type']['key'] ?? '';
                    $typeUrl = "https://openlibrary.org{$authorType}.json";
                    $authorRole = null;

                    try {
                        $authorResponse = @file_get_contents($authorUrl);
                        if ($authorResponse !== false) {
                            $authorDataResp = json_decode($authorResponse, true);
                            $authorName = $authorDataResp['name']
                                ?? $authorDataResp['key']
                                ?? 'Unknown Author';
                        }

                        $typeResponse = @file_get_contents($typeUrl);
                        if ($typeResponse !== false) {
                            $typeData = json_decode($typeResponse, true);
                            // if (isset($typeData['name'])) {
                            //     $authorRole = $typeData['name'];
                            // }
                            $authorRole = $typeData['name'] ?? '';
                        }
                    } catch (Exception $e) {
                    }
                    $html .=
                        '<div class="center gap-s">';
                            if ($coverUrl) {
                            $html .= '
                            <div class=""> <img src="' . htmlspecialchars($coverUrl) . '"></img> </div>
                            ';
                            }
                            $html .= '
                            <div>' . htmlspecialchars($authorName) . " " . htmlspecialchars($authorRole) . '</div>
                        </div>';
                }
                $html .= '</div>';
                echo $html;
            }
            ?>
        </div>

        <?php if (isset($data['subjects']) && is_array($data['subjects']) && count($data['subjects']) > 0) { ?>
            <div>Subjects:</div>
            <?php
                $html = '<div class="flex-row wrap gap-m">';
                    foreach($data['subjects'] as $subject) {
                $html .=
                    '<div class="center"> 
                        <div class="bullet"></div>' . htmlspecialchars($subject) . '
                    </div>';
                    }
                echo $html . '
                </div>';
            } else {
                'No subjects available.';
            }
            ?>
        </div>
</div>