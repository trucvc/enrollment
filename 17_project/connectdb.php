<?php
    $DB_HOST = 'localhost:3366';
    $DB_USER = 'root';
    $DB_PASS = '';
    $DB_NAME = '17_project'; 
    $conn=mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die("Không thể kết nối tới cơ sở dữ liệu");
    if($conn){
        mysqli_query($conn,"SET NAMES 'utf8'");
    }
?>