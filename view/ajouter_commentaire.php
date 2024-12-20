<?php
session_start();
include('C:\Users\ycode\Desktop\BLOG HUB\connection\connection.php');
include('C:\Users\ycode\Desktop\BLOG HUB\authentification\userValidation.php');

$user = userValidation($conn);

if (!isset($user)) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié']);
    exit;
}

// Récupérer les données POST (commentaire et article_id)
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

// Préparer la requête pour insérer le commentaire
$query = "INSERT INTO comments (article_id, user_id, content) VALUES ('$article_id', '{$user['id']}', '$content')";

if (mysqli_query($conn, $query)) {
    // Récupérer les informations du commentaire ajouté
    $comment_id = mysqli_insert_id($conn);
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
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout du commentaire']);
}
?>
