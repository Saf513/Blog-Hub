<?php
session_start();
include('C:\Users\ycode\Desktop\BLOG HUB\connection\connection.php');
include('C:\Users\ycode\Desktop\BLOG HUB\authentification\userValidation.php');
$user = userValidation($conn);


// if (!isset($_SESSION['user_id'])) {
//     echo "You must be logged in to delete articles.";
//     exit;
// }

if (isset($_GET['article_id'])) {
    // Get the article ID from the URL
    $article_id = $_GET['article_id'];

    // Prepare the DELETE query to remove the article
    $sql = "DELETE FROM articles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $article_id);  // Bind the article ID as an integer parameter

    if ($stmt->execute()) {
        // Redirect back to the article list page or dashboard after successful deletion
        header('Location: ../view/BLOG.PHP'); // Or redirect to the page you want
        exit;
    } else {
        echo "Error deleting article. Please try again.";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Article ID is missing.";
}

$conn->close();
?>
