<?php
require 'config.php';

try {
    $conn = new PDO("mysql:host=$servername", $username, $password, $options);
    
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}