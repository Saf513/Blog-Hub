

<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\Users\ycode\Desktop\BLOG HUB\vendor\autoload.php';
include('C:\Users\ycode\Desktop\BLOG HUB\connection\connection.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $sql = "SELECT id, email FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];

        // Générer un token unique
        $token = bin2hex(random_bytes(32)); // Génère un token de 64 caractères


        // Stocker temporairement le token dans la session
        $_SESSION['reset_token'] = $token;
        $_SESSION['reset_token_expiry'] = time() + 3600; // Le token expire dans 1 heure

        // Envoyer l'email avec PHPMailer
        $mail = new PHPMailer();
         $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'safiakhoulaid@gmail.com';
                    $mail->Password = 'htowsukixpyklgnq';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port = 465;

        $mail->setFrom('safiakhoulaid@gmail.com', 'Votre site');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Réinitialisation de votre mot de passe';
        $reset_link = "http://votre_site.com/reset_password.php?token=$token"; // Remplacez par l'URL de votre site
        $mail->Body = "Bonjour,<br><br>Veuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe : <br><a href='http://localhost:3000/authentification/resetPassword.php'>$reset_link</a>";

        if ($mail->send()) {
            $_SESSION['message'] = "Un e-mail de réinitialisation a été envoyé. Vérifiez votre boîte de réception.";
        } else {
            $_SESSION['message'] = "Erreur lors de l'envoi de l'e-mail. Veuillez réessayer.";
        }
    } else {
        $_SESSION['message'] = "Cet e-mail n'est pas enregistré.";
    }

    // Rediriger l'utilisateur
    // header('Location: C:\Users\ycode\Desktop\BLOG HUB\authentification\evoyerResetEmail.php');
    // exit();
}

$conn->close();
?>





<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <!-- Lien vers Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Demander la réinitialisation de votre mot de passe</h2>
        <form method="post">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-600 mb-2">Votre adresse e-mail :</label>
                <input type="email" name="email" id="email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-800">
            </div>
            <button type="submit"
                class="w-full py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                Réinitialiser mon mot de passe
            </button>
        </form>
    </div>
</body>
</html>
