<?php
session_start();
include('../connection/connection.php');


if (isset($_GET['comment_id'])) {
    $commentId = $_GET['comment_id'];
    var_dump($commentId);

    // Vérifier si l'utilisateur est le propriétaire du commentaire
    $query = "SELECT * FROM comments WHERE id = ? AND id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $commentId, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Supprimer le commentaire
        $query = "DELETE FROM comments WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $commentId);
        $stmt->execute();

        echo "Commentaire supprimé avec succès.";
        // header("Location: /view/post.php?id=" . $result->fetch_assoc()['post_id']); // Redirection vers le post
        exit;
    } else {
        echo "Commentaire introuvable ou vous n'êtes pas autorisé à le supprimer.";
        exit;
    }
} else {
    echo "Aucun commentaire sélectionné.";
    exit;
}
?>
