


<?php
session_start();

include('C:\Users\ycode\Desktop\BLOG HUB\connection\connection.php');
include('../authentification/userValidation.php');
$user = userValidation($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember-me']) ? true : false;


    if (empty($email) || empty($password)) {
        $error_message = "Veuillez remplir tous les champs.";
    } else {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Erreur de préparation de la requête : " . $conn->error);
        }

        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
        
                $token = bin2hex(random_bytes(32));
                $sql_update_token = "UPDATE users SET token = ? WHERE id = ?";
                $stmt_update_token = $conn->prepare($sql_update_token);
                $stmt_update_token->bind_param('si', $token, $user['id']);
                $stmt_update_token->execute();

                $_SESSION['token'] = $token;
                $_SESSION['user_id'] = $user['id'];
                var_dump($user['id']);
                if (!isset($_SESSION['token']) && $_SESSION['user_id'] ) {
                    echo "La session n'a pas enregistré le token.";
                } else {
                    echo "Token enregistré : " . $_SESSION['token'];
                    echo '\n' ;
                     var_dump($_SESSION);
                }
// var_dump($_SESSION['token']);
// var_dump($_SESSION['user_id']);
                // if ($remember_me) {
                //   $cookie_value = base64_encode($email); 
                //   setcookie('remember_me', $cookie_value, time() + (86400 * 30), "/"); 
                // }
                if ($user['role'] == 'admin') {
                    header('Location: /Admin/dashboard.php');
                } else {
                   header('Location: /index.php');
                 }
                exit();
              }
             else {
              $error_message = "Mot de passe incorrect.";
            }
        } 
        else {
            $error_message = "Aucun utilisateur trouvé avec cet email.";
        }

        $stmt->close();
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<header class="flex shadow-md py-4 px-4 sm:px-10 bg-white font-[sans-serif] min-h-[70px] tracking-wide relative z-50">
        <div class="flex flex-wrap items-center justify-between gap-5 w-full">
            <a href="/">
                <img src="/IMG/BLOG HUB (1) (1).png" alt="logo" class="w-36" style="width: 100px; height: auto;">
            </a>
            <nav id="collapseMenu" class="max-lg:hidden lg:block">
                <ul class="lg:flex gap-x-5">
                    <li><a href="/" class="text-[#007bff] font-semibold hover:text-blue-700">Home</a></li>
                    <li><a href="/view/BLOG.PHP" class="text-gray-500 font-semibold hover:text-blue-700">Blog</a></li>
                    <li><a href="#" class="text-gray-500 font-semibold hover:text-blue-700">Feature</a></li>
                    <li><a href="#" class="text-gray-500 font-semibold hover:text-blue-700">About</a></li>
                    <li><a href="#" class="text-gray-500 font-semibold hover:text-blue-700">Contact</a></li>
                    <?php 
                  
if ($user && $user['role'] === 'admin') {
    echo '<li><a href="/Admin/dashboard.php" class="text-gray-500 font-semibold hover:text-blue-700">dashboard</a></li>';
}
?>
                </ul>
            </nav>
            
            <div class="flex items-center space-x-4">
            <?php 
if (isset($_SESSION['token']) && $user) {
    echo "<p class='text-gray-700'>Bonjour, " . htmlspecialchars($user['username']) . "</p>";
    
    // Correction de la syntaxe de l'image
    echo '<div class="relative inline-block">
    <a href="./users/profile.php"> <img src="../users/' . htmlspecialchars($user['user_image']) . '" class="w-14 h-14 rounded-full border-2 border-blue-600 p-0.5" /></a>

            <span class="h-3 w-3 rounded-full border border-white bg-green-500 block absolute top-1 right-0"></span>
          </div>';
    
    echo '<a href="/authentification/logout.php" class="px-4 py-2 text-sm rounded-full font-bold text-white border-2 border-red-500 bg-red-500 hover:bg-transparent hover:text-red-500">Déconnexion</a>';
} else {
    echo '<a href="/authentification/login.php" class="px-4 py-2 text-sm rounded-full font-bold text-gray-500 border-2 hover:bg-gray-50">Login</a>';
    echo '<a href="/authentification/inscreption.php" class="px-4 py-2 text-sm rounded-full font-bold text-white border-2 border-[#007bff] bg-[#007bff] hover:bg-transparent hover:text-[#007bff]">Sign Up</a>';
}
?>

                <button id="toggleOpen" class="lg:hidden">
                    <svg class="w-7 h-7" fill="#000" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>
<body>

<!-- Formulaire de connexion -->
<div class="flex justify-center items-center font-[sans-serif] h-full min-h-screen p-4"
     style="background-image: url(https://readymadeui.com/background-image.webp); background-repeat: no-repeat; background-size: cover;">
    <div class="max-w-md w-full mx-auto">
        <form method="POST" action="" class="bg-opacity-70 bg-white rounded-2xl p-6 shadow-[0_2px_16px_-3px_rgba(6,81,237,0.3)]">
            <!-- Message d'erreur -->
            <?php if (!empty($error_message)) : ?>
                <div class="bg-red-100 text-red-800 p-4 mb-4 rounded-lg" role="alert">
                    <strong class="font-bold text-sm mr-4">Erreur!</strong>
                    <span class="block text-sm"><?= htmlspecialchars($error_message); ?></span>
                </div>
            <?php endif; ?>

            <!-- Message de succès -->
            <?php if (!empty($success_message)) : ?>
                <div class="bg-green-100 text-green-800 p-4 mb-4 rounded-lg" role="alert">
                    <strong class="font-bold text-sm mr-4">Succès!</strong>
                    <span class="block text-sm"><?= htmlspecialchars($success_message); ?></span>
                </div>
            <?php endif; ?>

            <!-- Titre -->
            <div class="mb-8">
                <h3 class="text-gray-800 text-3xl font-extrabold">Sign in</h3>
            </div>

            <!-- Champ Email -->
            <div class="mb-6">
                <div class="relative flex items-center">
                    <input name="email" type="text" required
                           class="bg-transparent w-full text-sm text-gray-800 border-b border-gray-400 focus:border-gray-800 px-2 py-3 outline-none placeholder:text-gray-800"
                           placeholder="Enter email" />
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#333" stroke="#333" class="w-[18px] h-[18px] absolute right-2"
                         viewBox="0 0 682.667 682.667">
                        <g transform="matrix(1.33 0 0 -1.33 0 682.667)">
                            <path fill="none" stroke-miterlimit="10" stroke-width="40"
                                  d="M452 444H60c-22.091 0-40-17.909-40-40v-39.446l212.127-157.782c14.17-10.54 33.576-10.54 47.746 0L492 364.554V404c0 22.091-17.909 40-40 40Z"
                                  data-original="#000000"></path>
                        </g>
                    </svg>
                </div>
            </div>

            <!-- Champ Mot de passe -->
            <div class="mb-6">
                <div class="relative flex items-center">
                    <input name="password" type="password" required
                           class="bg-transparent w-full text-sm text-gray-800 border-b border-gray-400 focus:border-gray-800 px-2 py-3 outline-none placeholder:text-gray-800"
                           placeholder="Enter password" />
                          
              <svg xmlns="http://www.w3.org/2000/svg" fill="#333" stroke="#333"
                class="w-[18px] h-[18px] absolute right-2 cursor-pointer" viewBox="0 0 128 128">
                <path
                  d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"
                  data-original="#000000"></path>
              </svg>
                </div>
            </div>

            <!-- Options supplémentaires -->
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 border-gray-300 rounded" />
                    <label for="remember-me" class="ml-3 text-sm text-gray-800">Remember me</label>
                </div>
                <a href="/authentification/evoyerResetEmail.php" class="text-blue-600 text-sm font-semibold hover:underline">Forgot Password?</a>
            </div>

            <!-- Bouton d'envoi -->
            <div>
                <button type="submit"
                        class="w-full py-2.5 px-4 text-sm font-semibold tracking-wider rounded-full text-white bg-gray-800 hover:bg-[#222] focus:outline-none">
                    Sign in
                </button>
                <p class="text-gray-800 text-sm text-center mt-4">
                    Don't have an account? <a href="/authentification/inscreption.php" class="text-blue-600 font-semibold hover:underline ml-1">Register here</a>
                </p>
            </div>
        </form>
    </div>
</div>

</body>
</html>