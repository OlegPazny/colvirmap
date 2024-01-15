<?php
    require_once "db_connect.php";

    $points = mysqli_query($db, "SELECT * FROM `MAP`");
    $points = mysqli_fetch_all($points);
    
    $max_count = mysqli_query($db, "SELECT MAX(`COUNT`) from `MAP`;");
    $max_count = mysqli_fetch_all($max_count);

    $avg_count = mysqli_query($db, "SELECT ROUND((MAX(`COUNT`) + MIN(`COUNT`)) / 2) FROM `MAP`;");
    $avg_count = mysqli_fetch_all($avg_count);
?>