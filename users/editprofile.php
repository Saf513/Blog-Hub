<?php
session_start();
include('C:\Users\ycode\Desktop\BLOG HUB\connection\connection.php');
include('C:\Users\ycode\Desktop\BLOG HUB\authentification\userValidation.php');
$user = userValidation($conn);

// Si l'utilisateur est connecté et valide
if (!$user) {
    header("Location: /authentification/login.php");
    exit;
}

// Récupérer les données de l'utilisateur à partir de la base de données
function getUserProfile($conn, $userId) {
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Mettre à jour les informations du profil de l'utilisateur
function updateUserProfile($conn, $userId, $username, $email, $profession, $bio, $profilePicture = null) {
    if ($profilePicture) {
        $query = "UPDATE users SET username = ?, email = ?, profession = ?, about= ?, user_image = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssi", $username, $email, $profession, $bio, $profilePicture, $userId);
    } else {
        $query = "UPDATE users SET username = ?, email = ?, profession = ?, about = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $username, $email, $profession, $bio, $userId);
    }
    $stmt->execute();
}

// Récupérer les informations actuelles de l'utilisateur
$userData = getUserProfile($conn, $user['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $profession = $_POST['profession'];
    $bio = $_POST['bio'];
var_dump($_POST);
    // Gérer le téléchargement de l'image
    if ($_FILES['profile_picture']['error'] === 0) {
        $imagePath = 'uploads/' . basename($_FILES['profile_picture']['name']);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $imagePath);
        updateUserProfile($conn, $user['id'], $username, $email, $profession, $bio, $imagePath);
    } else {
        updateUserProfile($conn, $user['id'], $username, $email, $profession, $bio);
    }

    // Rediriger pour éviter une nouvelle soumission du formulaire
    header('Location: profile.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
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
                        echo '<li><a href="/Admin/dashboard.php" class="text-gray-500 font-semibold hover:text-blue-700">Dashboard</a></li>';
                    }
                    ?>
                </ul>
            </nav>
            <div class="flex items-center space-x-4">
                <?php 
                if (isset($_SESSION['token']) && $user) {
                    echo "<p class='text-gray-700'>Bonjour, " . htmlspecialchars($user['username']) . "</p>";
                    echo '<a href="/authentification/logout.php" class="px-4 py-2 text-sm rounded-full font-bold text-white border-2 border-red-500 bg-red-500 hover:bg-transparent hover:text-red-500">Déconnexion</a>';
                } else {
                    echo '<a href="/authentification/login.php" class="px-4 py-2 text-sm rounded-full font-bold text-gray-500 border-2 hover:bg-gray-50">Login</a>';
                    echo '<a href="/authentification/inscreption.php" class="px-4 py-2 text-sm rounded-full font-bold text-white border-2 border-[#007bff] bg-[#007bff] hover:bg-transparent hover:text-[#007bff]">Sign Up</a>';
                }
                ?>
            </div>
        </div>
    </header>

    <div class="bg-white justify-center w-full flex flex-col gap-5 px-3 md:px-16 lg:px-28 md:flex-row text-[#161931]">
        <main class="w-full min-h-screen py-1 md:w-2/3 lg:w-3/4">
            <div class="p-2 md:p-4">
                <div class="w-full px-6 pb-8 mt-8 sm:max-w-xl sm:rounded-lg">
                    <h2 class="pl-6 text-2xl font-bold sm:text-xl">Edit Profile</h2>

                    <div class="grid max-w-2xl mx-auto mt-8">
    <div class="flex flex-col items-center space-y-5 sm:flex-row sm:space-y-0">
    <img class="object-cover w-40 h-40 p-1 rounded-full ring-2 ring-indigo-300 dark:ring-indigo-500"
    src="<?php echo !empty($userData['user_image']) ? $userData['user_image'] : 'data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M10%209a3%203%200%20100-6%203%203%200%20000%206zm-7%209a7%207%200%201114%200H3z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E'; ?>"
    alt="Profile Picture">

     
    </div>
</div>

                        <form method="POST" enctype="multipart/form-data" class="mt-8">
                            
        <div class="flex flex-col space-y-5 sm:ml-8">
            <label class="block text-sm font-medium text-indigo-900">Change Profile Picture</label>
            <input type="file" name="profile_picture" class="py-3.5 px-7 text-base font-medium text-indigo-100 focus:outline-none bg-[#202142] rounded-lg border border-indigo-200 hover:bg-indigo-900 focus:z-10 focus:ring-4 focus:ring-indigo-200">
        </div>
                            <div class="mb-6">
                                <label for="username" class="block mb-2 text-sm font-medium text-indigo-900">Username</label>
                                <input type="text" id="username" name="username" value="<?php echo $userData['username']; ?>" class="bg-indigo-50 border border-indigo-300 text-indigo-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" required>
                            </div>

                            <div class="mb-6">
                                <label for="email" class="block mb-2 text-sm font-medium text-indigo-900">Email</label>
                                <input type="email" id="email" name="email" value="<?php echo $userData['email']; ?>" class="bg-indigo-50 border border-indigo-300 text-indigo-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" required>
                            </div>

                            <div class="mb-6">
                                <label for="profession" class="block mb-2 text-sm font-medium text-indigo-900">Profession</label>
                                <input type="text" id="profession" name="profession" value="<?php echo $userData['profession']; ?>" class="bg-indigo-50 border border-indigo-300 text-indigo-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" required>
                            </div>

                            <div class="mb-6">
                                <label for="bio" class="block mb-2 text-sm font-medium text-indigo-900">Bio</label>
                                <textarea id="bio" name="bio" rows="4" class="block p-2.5 w-full text-sm text-indigo-900 bg-indigo-50 rounded-lg border border-indigo-300 focus:ring-indigo-500 focus:border-indigo-500"><?php echo $userData['about']; ?></textarea>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
