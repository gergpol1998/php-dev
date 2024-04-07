<?php
$data = array(
    "pub a" => array(
        "book 1" => 3,
        "book 2" => 2,
        "book 3" => 3,
    ),
    "pub b" => array(
        "book 4" => 1,
        "book 5" => 4,

    ),
    "pub c" => array(
        "book 6" => 2,
        "book 7" => 1,
        "book 8" => 4,
    )
);
$pubn = array();
foreach ($data as $key => $books) {
    $pubn[] = $key;
}

$i = 0;
foreach ($data as $pub => $books) {
    if ($pub === 'pub a') {
        foreach ($books as $book => $nb) {
            echo "{
            label: \"$book\",
            data : [$nb,],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
            ],
            borderWidth: 1
        },";
        }
    }
}
