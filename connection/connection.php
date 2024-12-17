<?php
$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = "blog-data";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die('Erreur : ' . $conn->connect_error);
}
