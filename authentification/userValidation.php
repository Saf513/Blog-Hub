<?php
    include "C:\Users\ycode\Desktop\BLOG HUB\connection\connection.php";

function userValidation($conn) {
 

    if(isset($_SESSION['token'])) {
        $token = $_SESSION['token'];
        $sql = 'SELECT * FROM users WHERE token = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $token);
        $stmt->execute();
    
        $data = $stmt->get_result();
        $user = $data->fetch_assoc();
    
        if($user) {
            return $user;
        } else {
            return null;
        }
    }
    else{
       
    }
}
?>