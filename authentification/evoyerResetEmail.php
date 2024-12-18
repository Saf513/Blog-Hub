

<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\Users\ycode\Desktop\BLOG HUB\vendor\autoload.php';
include('C:\Users\ycode\Desktop\BLOG HUB\connection\connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);

    if ($email) {
        $sql = "SELECT id, email FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Génération du token et définition de son expiration
            $token_reset = bin2hex(random_bytes(32));
            $token_expiry = time() + 3600; // Le token expire dans 1 heure

            // Stocker les informations dans la session (pas dans la base de données)
            $_SESSION['reset_token'] = $token_reset;
            $_SESSION['reset_token_expiry'] = $token_expiry;
            $_SESSION['reset_email'] = $email;

            $mail = new PHPMailer(true);

            try {
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
                $reset_link = "http://localhost:3000/authentification/resetPassword.php?reset_token=$token_reset";
                $mail->Body = "Bonjour,<br><br>Veuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe : <br><a href='$reset_link'>$reset_link</a>";

                $mail->send();
                $_SESSION['message'] = "Un e-mail de réinitialisation a été envoyé. Vérifiez votre boîte de réception.";

            } catch (Exception $e) {
                $_SESSION['message'] = "Erreur lors de l'envoi de l'e-mail : " . $mail->ErrorInfo;
            }
        } else {
            $_SESSION['message'] = "Cet e-mail n'est pas enregistré.";
        }
    } else {
        $_SESSION['message'] = "Adresse e-mail invalide.";
    }

    // Rediriger vers la page de login
    header('Location: /authentification/login.php');
    exit();
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
