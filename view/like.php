<?php

session_start();
include('../connection/connection.php'); 

$data = json_decode(file_get_contents('php://input'), true);
$articleId = $data['article_id'];
$userId = $data['user_id'];

// Vérification si l'utilisateur a déjà liké cet article
$query = "SELECT * FROM likes WHERE article_id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $articleId, $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // L'utilisateur n'a pas encore liké l'article, on l'ajoute
    $insertLike = "INSERT INTO likes (user_id, article_id) VALUES (?, ?)";
    $stmt = $conn->prepare($insertLike);
    $stmt->bind_param("ii", $userId, $articleId);
    $stmt->execute();

    // Mettre à jour le compteur de likes dans la table articles
    $updateLikes = "UPDATE articles SET likes = likes + 1 WHERE id = ?";
    $stmt = $conn->prepare($updateLikes);
    $stmt->bind_param("i", $articleId);
    $stmt->execute();

    // Obtenir le nouveau nombre de likes
    $queryLikes = "SELECT likes FROM articles WHERE id = ?";
    $stmt = $conn->prepare($queryLikes);
    $stmt->bind_param("i", $articleId);
    $stmt->execute();
    $resultLikes = $stmt->get_result();
    $row = $resultLikes->fetch_assoc();
    $newLikeCount = $row['likes'];

    // Retourner la réponse en JSON
    echo json_encode(['success' => true, 'newLikeCount' => $newLikeCount]);
} else {
    // L'utilisateur a déjà liké cet article
    echo json_encode(['success' => false, 'message' => 'Vous avez déjà liké cet article']);
}
?>
