<?php
session_start();
    include "C:\Users\ycode\Desktop\BLOG HUB\connection\connection.php";

function articleValidation($conn) {
    $token = $_SESSION['token'];

    if(isset($token)) {
        $sql = 'SELECT * FROM articles WHERE token =  ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $token);
        $stmt->execute();
    
        $data = $stmt->get_result();
        $article = $data->fetch_assoc();
    
        if($article) {
            return $article;
        } else {
            return null;
        }
    }
}
?>