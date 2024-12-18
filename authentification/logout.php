<?php
session_start(); // Démarrer la session

// Supprimer toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Supprimer le cookie "remember_me" si présent
if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, '/'); // Définit un cookie expiré
}

// Rediriger vers la page de connexion ou d'accueil
header("Location:http://localhost:3000/index.php");
exit();
?>
