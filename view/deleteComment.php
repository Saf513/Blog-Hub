<?php
session_start();
include('../connection/connection.php');

// Vérifier si l'ID du commentaire est passé dans l'URL
if (isset($_GET['comment_id'])) {
    $commentId = $_GET['comment_id'];

    // Récupérer d'abord le post_id du commentaire avant de le supprimer
    $query = "SELECT article_id FROM comments WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $commentId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Récupérer l'ID du post lié à ce commentaire
        $row = $result->fetch_assoc();
        $postId = $row['article_id'];

        // Supprimer le commentaire
        $query = "DELETE FROM comments WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $commentId);

        // Si la suppression est réussie
        if ($stmt->execute()) {
            // Redirection vers la page du post après suppression
            header("Location: /view/REAMORE.PHP?id=" . $postId . "#commentModal");
            exit;
        } else {
            echo "Erreur lors de la suppression du commentaire.";
            exit;
        }
    } else {
        echo "Commentaire introuvable ou vous n'êtes pas autorisé à le supprimer.";
        exit;
    }
} else {
    echo "Aucun commentaire sélectionné.";
    exit;
}
?>
