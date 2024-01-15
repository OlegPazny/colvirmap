<?php
    require_once "db_connect.php";

    $cities = mysqli_query($db, "SELECT `CITY`, COUNT(*) as count FROM `temp` GROUP BY `CITY`;");
    $cities = mysqli_fetch_all($cities); 

    echo("<pre>");
    var_dump($cities);
    echo("</pre>");

    foreach($cities as $row) {
        $city = $row[0];
        $count = $row[1];
        $insert = mysqli_query($db, "INSERT INTO `MAP` (`CITY`, `COUNT`) VALUES ('$city', $count)");
    }
?>