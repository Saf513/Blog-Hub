<?php
session_start();
include('../connection/connection.php');
include('../authentification/userValidation.php');


$user = userValidation($conn);

if (!isset($user)) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié']);
    exit;
}

$content = isset($_POST['content']) ? mysqli_real_escape_string($conn, $_POST['content']) : '';
$article_id = isset($_POST['article_id']) ? $_POST['article_id'] : 0;

if (empty($content)) {
    echo json_encode(['success' => false, 'message' => 'Le contenu du commentaire est vide']);
    exit;
}

if ($article_id == 0) {
    echo json_encode(['success' => false, 'message' => 'ID d\'article invalide']);
    exit;
}

$query = "INSERT INTO comments (article_id, user_id, content) VALUES (?, ?, ?)";

$stmt = $conn->prepare($query);
$stmt->bind_param("iis", $article_id, $user['id'], $content);

if ($stmt->execute()) {
    // Récupérer les informations du commentaire ajouté
    $comment_id = $stmt->insert_id;
    $created_at = date('Y-m-d H:i:s');
    $user_name = $user['username'];

    // Retourner une réponse JSON avec succès
    echo json_encode([
        'success' => true,
        'message' => 'Commentaire ajouté avec succès.',
        'comment_id' => $comment_id,
        'user_name' => $user_name,
        'created_at' => $created_at,
        'content' => $content
    ]);

} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout du commentaire', 'error' => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
