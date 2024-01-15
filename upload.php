<?php
// подключаем файл конфигурации базы данных mysql
include_once 'db_connect.php';
 
if (isset($_POST['submit']))
{
 
    // Разрешенные типы mime
    $fileMimes = array(
        'text/x-comma-separated-values',
        'text/comma-separated-values',
        'application/octet-stream',
        'application/vnd.ms-excel',
        'application/x-csv',
        'text/x-csv',
        'text/csv',
        'application/csv',
        'application/excel',
        'application/vnd.msexcel',
        'text/plain'
    );
 
    // Проверяем, является ли выбранный файл CSV-файлом
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileMimes))
    {
        mysqli_query($db, "TRUNCATE TABLE `temp`;");
 
            // Открываем загруженный CSV-файл в режиме только для чтения
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
 
            // Пропускаем первую строку
            fgetcsv($csvFile);
 
            // Парсим (разбираем) данные из файла CSV построчно
            while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE)
            {
                // Получаем данные строки
                $city = $getData[0];
                     mysqli_query($db, "INSERT INTO `temp` (city) VALUES ('" . $city . "')");
            }
 
            // Закрываем открытый CSV-файл
            fclose($csvFile);
            
            $cities = mysqli_query($db, "SELECT `CITY`, COUNT(*) as count FROM `temp` GROUP BY `CITY`;");
            $cities = mysqli_fetch_all($cities); 
        
            foreach($cities as $row){
                $city=$row[0];
                $count=$row[1];
                //обновление существующих в map
                $update = mysqli_query($db, "UPDATE `MAP` SET `COUNT` = $count WHERE `CITY` LIKE '%$city%'");
                //перенос уникальных из temp в map
                $insert = mysqli_query($db, "INSERT INTO `MAP` (CITY,COUNT)
                SELECT * FROM (SELECT '$city' AS CITY, $count AS COUNT) AS temp
                WHERE NOT EXISTS (
                    SELECT CITY FROM MAP WHERE CITY LIKE '%$city%'
                ) LIMIT 1;");
        
            }
            //удаление несуществующих из map
            $delete=mysqli_query($db, "DELETE FROM `MAP` WHERE NOT EXISTS (SELECT 1 FROM `temp` WHERE `MAP`.`CITY` LIKE CONCAT('%', `temp`.`CITY`, '%'));");
 
            header("Location: update.php");
         
    }
    else
    {
        echo "Please select valid file";
    }
}