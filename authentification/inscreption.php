<?php
session_start();
require '../connection/connection.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$nom = '';
$email = '';
$password = '';
$password_confirm = '';
$role = 'user';
$token = '';
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if (empty($nom) || empty($email) || empty($password) || empty($password_confirm)) {
        $error_message = 'Tous les champs sont obligatoires.';
    } elseif ($password !== $password_confirm) {
        $error_message = 'Les mots de passe ne correspondent pas.';
    } else {
        // Check if email already exists
        $sql_check_user = "SELECT * FROM users WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check_user);
        $stmt_check->bind_param('s', $email);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            $error_message = 'Cet email est déjà utilisé.';
        } else {
            // Check if username already exists
            $sql_check_username = "SELECT * FROM users WHERE username = ?";
            $stmt_check_username = $conn->prepare($sql_check_username);
            $stmt_check_username->bind_param('s', $nom);
            $stmt_check_username->execute();
            $result_username = $stmt_check_username->get_result();

            if ($result_username->num_rows > 0) {
                $error_message = 'Ce nom d\'utilisateur est déjà pris. Veuillez en choisir un autre.';
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $token = bin2hex(random_bytes(32));

                
                // Insert the new user
                $sql_insert = "INSERT INTO users (username, email, password, role, token) VALUES (?, ?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param('sssss', $nom, $email, $hashed_password, $role, $token);

                if ($stmt_insert->execute()) {
                    $mail = new PHPMailer(true);
                    try {
                        // Configuration de l'email
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'safiakhoulaid@gmail.com';
                        $mail->Password = 'htowsukixpyklgnq';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                        $mail->Port = 465;

                        // Contenu de l'email
                        $mail->setFrom('safiakhoulaid@gmail.com', 'safiakhoulaid');
                        $mail->addAddress($email, $nom);
                        $mail->isHTML(true);
                        $mail->Subject = 'Confirmation d\'inscription';
                        $mail->Body    = "<h1>Bonjour, $nom</h1><p>Merci de vous être inscrit sur notre site !</p>";
                        $mail->send();
                    } catch (Exception $e) {
                        echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
                    }

                    // Redirect based on role
                    if ($role == 'admin') {
                        header('Location: /admin_dashboard.php');
                    } else {
                        header('Location: /index.php');
                    }
                    exit();
                }
            }
        }
    }
}


         
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <!-- FORMULAIRE DE L'INSCRIPTION -->
    <div class="font-[sans-serif] relative">
        <div class="h-[240px] font-[sans-serif]">
            <img src="https://readymadeui.com/cardImg.webp" alt="Banner Image" class="w-full h-full object-cover" />
        </div>

        <div class="relative -mt-40 m-4">
            <form class="bg-white max-w-xl w-full mx-auto shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] p-8 rounded-2xl" method="post">
                <div class="mb-12">
                    <h3 class="text-gray-800 text-3xl font-bold text-center">Register</h3>
                </div>

                <!-- Nom -->
                <div>
                    <label class="text-gray-800 text-xs block mb-2">Full Name</label>
                    <div class="relative flex items-center">
                        <input name="name" type="text" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter name" value="<?= htmlspecialchars($nom) ?>" />
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2" viewBox="0 0 24 24">
                            <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                            <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z" data-original="#000000"></path>
                        </svg>
                    </div>
                    <!-- Message d'erreur pour le nom -->
                    <?php if (!empty($error_message)) { echo '<p class="text-red-500 text-xs mt-1">' . htmlspecialchars($error_message) . '</p>'; } ?>
                </div>

                <!-- Email -->
                <div class="mt-8">
                    <label class="text-gray-800 text-xs block mb-2">Email</label>
                    <div class="relative flex items-center">
                        <input name="email" type="text" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter email" value="<?= htmlspecialchars($email) ?>" />
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2" viewBox="0 0 682.667 682.667">
                            <defs>
                                <clipPath id="a" clipPathUnits="userSpaceOnUse">
                                    <path d="M0 512h512V0H0Z" data-original="#000000"></path>
                                </clipPath>
                            </defs>
                            <g clip-path="url(#a)" transform="matrix(1.33 0 0 -1.33 0 682.667)">
                                <path fill="none" stroke-miterlimit="10" stroke-width="40" d="M452 444H60c-22.091 0-40-17.909-40-40v-39.446l212.127-157.782c14.17-10.54 33.576-10.54 47.746 0L492 364.554V404c0 22.091-17.909 40-40 40Z" data-original="#000000"></path>
                                <path d="M472 274.9V107.999c0-11.027-8.972-20-20-20H60c-11.028 0-20 8.973-20 20V274.9L0 304.652V107.999c0-33.084 26.916-60 60-60h392c33.084 0 60 26.916 60 60v196.653Z" data-original="#000000"></path>
                            </g>
                        </svg>
                    </div>
                    <!-- Message d'erreur pour l'email -->
                    <?php if (!empty($error_message)) { echo '<p class="text-red-500 text-xs mt-1">' . htmlspecialchars($error_message) . '</p>'; } ?>
                </div>

                <!-- Password -->
                <div class="mt-8">
                    <label class="text-gray-800 text-xs block mb-2">Password</label>
                    <div class="relative flex items-center">
                        <input name="password" type="password" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter password" />
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mt-8">
                    <label class="text-gray-800 text-xs block mb-2">Confirm Password</label>
                    <div class="relative flex items-center">
                        <input name="password_confirm" type="password" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter password" />
                    </div>
                    <!-- Message d'erreur pour la confirmation de mot de passe -->
                    <?php if (!empty($error_message)) { echo '<p class="text-red-500 text-xs mt-1">' . htmlspecialchars($error_message) . '</p>'; } ?>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="mt-8 px-6 py-2.5 w-full text-sm bg-blue-500 text-white rounded hover:bg-blue-600 transition-all">Submit</button>
                <p class="text-gray-800 text-sm text-center mt-4">
                    Do you have an account? <a href="/authentification/login.php" class="text-blue-600 font-semibold hover:underline ml-1">Login here</a>
                </p>
            </form>
        </div>
    </div>
</body>

</html>