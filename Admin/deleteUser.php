<?php
session_start();
require('../connection/connection.php');
require('../authentification/userValidation.php');
$user = userValidation($conn);

if (!$user || $user['role'] != 'admin') {
    echo json_encode(['success' => false, 'message' => 'Accès limité aux admins']);
    exit;
}

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Prepare the DELETE query to remove the user
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        header('Location: ../Admin/dashboard.php?delete=success');    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'ID utilisateur manquant']);
}

$conn->close();
?>
