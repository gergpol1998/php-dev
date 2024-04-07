<?php
include("./func.php");
conn();
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
</head>

<body>
    <?php
    $i = 0;
    
    $pubname = select(
        "pub_name",
        "receipt_detail INNER JOIN book ON recd_bookid = book_id 
     INNER JOIN publisher ON book_pubid = pub_id 
     GROUP BY pub_name ORDER BY COUNT(recd_bookid) DESC limit 2"
    );

    foreach ($pubname as $pub) {
        $pn = $pub["pub_name"];
        $lb = array();
        $dt = array();
        $book = select(
            "book_name, count(recd_bookid) as nb",
            "receipt_detail INNER JOIN book ON recd_bookid = book_id 
         INNER JOIN publisher ON book_pubid = pub_id 
         WHERE pub_name = '$pn'
         GROUP BY book_name
         ORDER BY count(recd_bookid) desc"
        );


    ?>
        <canvas id='myChart<?= $i ?>' width='200' height='100'></canvas>

        <script>
            var ctx<?= $i ?> = document.getElementById('myChart<?= $i ?>').getContext('2d');
            var myChart<?= $i ?> = new Chart(ctx<?= $i ?>, {
                type: 'bar',
                data: {
                    labels: [
                        <?php
                        foreach ($book as $dt) {
                            echo "'" . $dt['book_name'] . "',";
                        }
                        ?>
                    ],
                    datasets: [{
                        label: 'จำนวนหนังสือ',
                        data: [
                            <?php
                            foreach ($book as $dt) {
                                echo "'" . $dt['nb'] . "',";
                            }
                            ?>
                        ],
                        backgroundColor: [
                            <?php echo "'".randomRGB()."'"?>,
                        ],
                        borderColor: [
                            <?php echo "'".randomRGB()."'"?>,
                        ],
                        borderWidth: 1
                    }]
                },

            });
        </script>
    <?php

        $i++;
    }

    ?>

</body>

</html>