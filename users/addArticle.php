<?php
session_start();
include('C:\Users\ycode\Desktop\BLOG HUB\connection\connection.php');
// Vérifier si la session token existe
if (!isset($_SESSION['token'])) {
    // Rediriger vers la page de connexion
    header("Location: /authentification/login.php");
    exit(); // Toujours utiliser exit() après une redirection pour éviter une exécution supplémentaire du script
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $image_path = null;
    $user_id = $_SESSION['user_id'];

    $tags = isset($_POST['tags']) ? $_POST['tags'] : '';
    $tags = array_map('trim', explode(',', $tags));

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {

        // Define the directory for uploading images
        $upload_dir = 'uploads/';
        
        // Ensure the uploads directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true); // Create the directory if it doesn't exist
        }
    
        // Generate a unique name for the file to avoid overwriting
        $file_name = uniqid() . '_' . basename($_FILES['image']['name']);
        $target_file = $upload_dir . $file_name;
    
        // Validate the file type (only images, you can customize this as needed)
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'jfif'];
    
        if (!in_array($image_file_type, $allowed_types)) {
            die("Erreur: L'extension du fichier n'est pas autorisée.");
        }
    
        // Check file size (optional: adjust the limit as necessary)
        if ($_FILES['image']['size'] > 5000000) { // Max size 5MB
            die("Erreur: Le fichier est trop volumineux.");
        }
    
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
            // echo "L'image a été téléchargée avec succès: " . htmlspecialchars($file_name);
        } else {
            die("Erreur lors du téléchargement de l'image.");
        }
    
    } else {
        die("Erreur: Aucun fichier téléchargé ou une erreur inconnue.");
    }

    // Insérer l'article dans la table 'articles'
    $stmt = $conn->prepare("INSERT INTO articles (user_id, title, content, image_url, created_at) VALUES (?, ?, ?, ?, NOW())");
    if (!$stmt) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    // Lier les paramètres
    $stmt->bind_param('isss', $user_id, $title, $description, $image_path);

    // Exécuter la requête
    if ($stmt->execute()) {
        $article_id = $stmt->insert_id;  

        // Insérer les tags dans la table 'tags' et associer à l'article
        foreach ($tags as $tag) {
            if (!empty($tag)) {
                // Vérifier si le tag existe déjà dans la table 'tags'
                $tag = htmlspecialchars($tag);  // Échapper le tag pour éviter les injections
                $stmt_tag = $conn->prepare("SELECT id FROM tags WHERE name = ?");
                $stmt_tag->bind_param('s', $tag);
                $stmt_tag->execute();
                $result_tag = $stmt_tag->get_result();

                if ($result_tag->num_rows === 0) {
                    // Insérer le tag dans la table 'tags' s'il n'existe pas
                    $stmt_insert_tag = $conn->prepare("INSERT INTO tags (name) VALUES (?)");
                    $stmt_insert_tag->bind_param('s', $tag);
                    $stmt_insert_tag->execute();
                    $tag_id = $stmt_insert_tag->insert_id;  // Récupérer l'ID du nouveau tag
                    $stmt_insert_tag->close();
                } else {
                    // Si le tag existe déjà, récupérer son ID
                    $tag_data = $result_tag->fetch_assoc();
                    $tag_id = $tag_data['id'];
                }
                $stmt_tag->close();

                // Vérifier si l'association article_id et tag_id existe déjà dans la table 'article_tags'
                $stmt_check_association = $conn->prepare("SELECT 1 FROM article_tags WHERE article_id = ? AND tag_id = ?");
                $stmt_check_association->bind_param('ii', $article_id, $tag_id);
                $stmt_check_association->execute();
                $result_check = $stmt_check_association->get_result();

                if ($result_check->num_rows === 0) {
                    $stmt_assoc = $conn->prepare("INSERT INTO article_tags (article_id, tag_id) VALUES (?, ?)");
                    $stmt_assoc->bind_param('ii', $article_id, $tag_id);
                    $stmt_assoc->execute();
                    $stmt_assoc->close();
                }
                $stmt_check_association->close();
            }
        }

        // echo "Article ajouté avec succès avec les tags !";
    } else {
        echo "Erreur lors de l'ajout de l'article : " . $stmt->error;
    }

    // Fermer la requête de l'article
    $stmt->close();
}

// Fermer la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- Place the first <script> tag in your HTML's <head> -->
    <script src="https://cdn.tiny.cloud/1/863nz3y2j8bhq6arxc9l0bbksx1tue0pxh3jl1pe5lb3cye5/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: [
                // Core editing features
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                // Your account includes a free trial of TinyMCE premium features
                // Try the most popular premium features until Jan 1, 2025:
                'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
        });
    </script>

</head>

<body>

    <div class="bg-gradient-to-t from-purple-200 via-purple-50 to-purple-50 py-20 px-4 font-[sans-serif]">
        <div class="max-w-4xl w-full mx-auto text-center">
            <h2 class="text-gray-800 text-4xl md:text-5xl font-extrabold mb-6 leading-[45px]">Create your publication</h2>
            <p class="text-base text-gray-600">Stay updated with our latest news and exclusive offers. Join our community today!</p>
            <form class="font-[sans-serif] m-6 max-w-4xl mx-auto mt-4" method="post" enctype="multipart/form-data">
                <div class="grid sm:grid-cols-2 gap-10">
                    <div class="relative flex items-center">
                        <label class="text-[13px] bg-white text-black absolute px-2 top-[-10px] left-[18px]">Title
                        </label>
                        <input type="text" name="title" placeholder="Enter last name"
                            class="px-4 py-3.5 bg-white text-black w-full text-sm border-2 border-gray-100 focus:border-blue-500 rounded outline-none" />

                    </div>


                    <div class="relative flex flex-col items-start">
                        <label class="text-[13px] bg-white text-black px-2 mb-2">
                            Tags
                        </label>
                        <div id="tag-container" class="flex flex-wrap items-center border-2 border-gray-100 bg-white px-2 py-2 rounded w-full">
                            <span id="tag-list" class="flex flex-wrap gap-2"></span>
                            <input
                                type="text"
                                id="tag-input"
                                placeholder="Add a tag and press Enter"
                                class="px-4 py-2 flex-grow bg-white text-black text-sm focus:outline-none"
                                name="tags"
                                onkeydown="handleTagInput(event)" />
                        </div>
                        <input type="hidden" name="tags" id="tags-hidden-input" />
                    </div>

                    <div class="relative">
                        <!-- Label -->
                        <label for="description" class="text-[13px] text-gray-700 absolute px-2 bg-white top-[-20px] left-4">
                            Description
                        </label>
                        <!-- Textarea -->
                        <textarea id="description" name="description" placeholder="Enter your description here..."
                            rows="4"
                            class="w-full px-4  mt-4 py-3 bg-white text-black border-2 border-gray-300 rounded focus:outline-none focus:border-blue-500 placeholder-gray-400">
                        </textarea>

                    </div>
                </div>
                <div class="font-[sans-serif] max-w-md mx-auto">
                    <label class="text-base font-semibold text-gray-600 mb-2 block">Upload files</label>
                    <input type="file" name="image" class="w-full text-gray-400 font-semibold text-sm bg-white border file:cursor-pointer cursor-pointer file:border-0 file:py-2.5 file:px-4 file:mr-4 file:bg-gray-100 file:hover:bg-gray-200 file:text-gray-600 rounded" />

                    <div
                        class="mt-5 bg-gray-50 text-gray-600 text-base rounded w-full h-48 flex flex-col items-center justify-center border-2 border-gray-300 border-dashed">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 mb-2 fill-gray-400" viewBox="0 0 32 32">
                            <path
                                d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956z"
                                data-original="#000000" />
                            <path
                                d="M20.293 19.707a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z"
                                data-original="#000000" />
                        </svg>
                        <p class="text-base font-semibold text-gray-600">Drag & Drop files here</p>
                    </div>
                </div>

                <button type="submit"
                    class="mt-8 px-6 py-2.5 w-full text-sm bg-blue-500 text-white rounded hover:bg-blue-600 transition-all">Submit
                </button>
            </form>
        </div>
    </div>
    <script src="../view/app.js"></script>

</body>

</html>
