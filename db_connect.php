<?php
    $host="localhost";
    $database="colvir";
    $user="root";
    $password="";
    $db=mysqli_connect($host, $user, $password, $database) or die("Ошибка ".mysqli_error($db));
?>