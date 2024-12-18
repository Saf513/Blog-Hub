<?php
session_start();
include('C:\Users\ycode\Desktop\BLOG HUB\connection\connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);
    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        if (isset($_SESSION['user_id'])) {
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $hashed_password, $_SESSION['user_id']);
            if ($stmt->execute()) {
                // Réinitialisation réussie : supprimer le token de session
                unset($_SESSION['reset_token']);
                unset($_SESSION['reset_token_expiry']);
                unset($_SESSION['user_id']);

                // Message de succès et redirection
                $_SESSION['message'] = "Votre mot de passe a été réinitialisé avec succès.";
                header('Location: /index.php'); 
                exit();
            } else {
                echo "Une erreur est survenue lors de la mise à jour du mot de passe.";
            }
        } else {
            echo "Session expirée ou utilisateur non authentifié.";
        }
    } else {
        echo "Les mots de passe ne correspondent pas.";
    }
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Réinitialisation du mot de passe</h2>
        <form  method="post" class="space-y-4">
            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                <input 
                    type="password" 
                    name="new_password" 
                    id="new_password" 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                    placeholder="Entrez votre nouveau mot de passe" 
                    required>
            </div>
            <div>
                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                <input 
                    type="password" 
                    name="confirm_password" 
                    id="confirm_password" 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                    placeholder="Confirmez votre mot de passe" 
                    required>
            </div>
            <div>
                <button 
                    type="submit" 
                    class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Réinitialiser le mot de passe
                </button>
            </div>
        </form>
    </div>
</body>
</html>
