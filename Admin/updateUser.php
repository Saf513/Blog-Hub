<?php
session_start();
require('../connection/connection.php');
require('../authentification/userValidation.php');

// Assuming userValidation() function will return the user details for the current logged-in user
$user = userValidation($conn);

// Check if the user is logged in and has the correct role (admin)
if (!$user || $user['role'] != 'admin') {
    echo json_encode(['success' => false, 'message' => 'Accès limité aux admins']);
    exit;
}

// If the form is submitted, process the data (Update logic can be implemented here)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // You can process the form submission here, e.g. updating the database
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Don't forget to hash the password before saving
    $role = $_POST['role'];

    $user_id = $_GET['user_id'];
    // Update the user details in the database
    // Assuming there's a function to update user data
    $updateQuery = "UPDATE users SET username = ?, email = ?, password = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssssi", $name, $email, $password, $role,  $user_id);
    $stmt->execute();
    $stmt->close();

    // After processing, you can display a success message
    $success_message = "Utilisateur mis à jour avec succès!";
    header('Location: ../Admin/dashboard.php'); // Use relative path
    exit; // Ensure the script stops execution after the redirect
    }

// Fetch the current user's data from the database
$user_id = $_GET['user_id'];

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$current_user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Function to hide message after 10 seconds
        function hideMessage(messageId) {
            setTimeout(function() {
                const message = document.getElementById(messageId);
                if (message) {
                    message.style.display = 'none';
                }
            }, 3000); // 10000ms = 10 seconds
        }
    </script>
</head>

<body>

    <!-- FORMULAIRE DE L INSCRIPTION -->
    <div class="font-[sans-serif] relative">
        <div class="h-[240px] font-[sans-serif]">
            <img src="https://readymadeui.com/cardImg.webp" alt="Banner Image" class="w-full h-full object-cover" />
        </div>

        <div class="relative -mt-40 m-4">
            <form class="bg-white max-w-xl w-full mx-auto shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] p-8 rounded-2xl" method="post">
                
               <!-- Error and Success Messages -->
               <?php if (!empty($error_message)) { ?>
                    <div id="error-message" class="bg-red-100 text-red-800 p-4 rounded-lg mb-4" role="alert">
                        <strong class="font-bold text-sm mr-4">Erreur!</strong>
                        <span class="block text-sm sm:inline max-sm:mt-2"><?php echo htmlspecialchars($error_message); ?></span>
                    </div>
                    <script>
                        // Call hideMessage function to hide the error message after 10 seconds
                        hideMessage('error-message');
                    </script>
                <?php } ?>

                <?php if (!empty($success_message)) { ?>
                    <div id="success-message" class="bg-green-100 text-green-800 p-4 rounded-lg mb-4" role="alert">
                        <strong class="font-bold text-sm mr-4">Succès!</strong>
                        <span class="block text-sm sm:inline max-sm:mt-2"><?php echo htmlspecialchars($success_message); ?></span>
                    </div>
                    <script>
                        // Call hideMessage function to hide the success message after 10 seconds
                        hideMessage('success-message');
                    </script>
                <?php } ?>


                <div class="mb-12">
                    <h3 class="text-gray-800 text-3xl font-bold text-center">Modification</h3>
                </div>

                <div>
                    <label class="text-gray-800 text-xs block mb-2">Full Name</label>
                    <div class="relative flex items-center">
                        <input name="name" type="text" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter name" value="<?php echo htmlspecialchars($current_user['username']); ?>" />
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2" viewBox="0 0 24 24">
                            <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                            <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z" data-original="#000000"></path>
                        </svg>
                    </div>
                </div>

                <div class="mt-8">
                    <label class="text-gray-800 text-xs block mb-2">Email</label>
                    <div class="relative flex items-center">
                        <input name="email" type="text" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter email" value="<?php echo htmlspecialchars($current_user['email']); ?>" />
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
                </div>

                <div class="mt-8">
                    <label class="text-gray-800 text-xs block mb-2">Password</label>
                    <div class="relative flex items-center">
                        <input name="password" type="password" required class="w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none" placeholder="Enter password" value="<?php echo htmlspecialchars($current_user['password']); ?>" />
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2 cursor-pointer" viewBox="0 0 128 128">
                            <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" data-original="#000000"></path>
                        </svg>
                    </div>
                </div>

                <div class="mt-8">
                    <label class="text-gray-800 text-xs block mb-2">Role</label>
                    <div class="relative flex items-center w-full bg-transparent text-sm text-gray-800 border-b border-gray-300 focus:border-blue-500 px-2 py-3 outline-none">
                        <select name="role">
                            <option value="admin" <?php echo $current_user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="user" <?php echo $current_user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="mt-8 px-6 py-2.5 w-full text-sm bg-blue-500 text-white rounded hover:bg-blue-600 transition-all">Submit</button>
            </form>
        </div>
    </div>

</body>

</html>

