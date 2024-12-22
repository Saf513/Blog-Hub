<?php
session_start();
include('../connection/connection.php');

// Vérification de l'utilisateur
if (!isset($_SESSION['token'])) {
    header("Location: /authentification/login.php");
    exit;
}

// Vérification de l'existence du commentaire
if (isset($_GET['comment_id'])) {
    $commentId = $_GET['comment_id'];
    $query = "SELECT * FROM comments WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $commentId, $_SESSION['user_id']); // $_SESSION['user_id'] contient l'ID de l'utilisateur connecté
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $comment = $result->fetch_assoc();
    } else {
        echo "Commentaire introuvable ou vous n'êtes pas autorisé à le modifier.";
        exit;
    }
} else {
    echo "Aucun commentaire sélectionné.";
    exit;
}

// Traitement du formulaire pour la modification du commentaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newCommentText = $_POST['comment_text'];

    if (!empty($newCommentText)) {
        $query = "UPDATE comments SET comment_text = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $newCommentText, $commentId);
        $stmt->execute();

        echo "Commentaire modifié avec succès.";
        header("Location: /view/post.php?id=" . $comment['post_id']); // Redirection vers le post
        exit;
    } else {
        echo "Le commentaire ne peut pas être vide.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Commentaire</title>
</head>
<body>
    <h2>Modifier votre commentaire</h2>
    <form method="POST">
        <textarea name="comment_text" rows="4" cols="50"><?php echo htmlspecialchars($comment['comment_text']); ?></textarea><br>
        <button type="submit">Modifier</button>
    </form>
</body>
</html>
