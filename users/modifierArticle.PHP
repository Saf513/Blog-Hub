<?php
session_start();
include('C:\Users\ycode\Desktop\BLOG HUB\connection\connection.php');
include('C:\Users\ycode\Desktop\BLOG HUB\authentification\userValidation.php');
$user = userValidation($conn);

?>

<!DOCTYPE html>
<html lang='en'>

<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>Document</title>
  <script src='https://cdn.tailwindcss.com'></script>
  <script src='https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js' referrerpolicy='origin'></script>
  <!-- Place the first <script> tag in your HTML's <head> -->
  <script src='https://cdn.tiny.cloud/1/863nz3y2j8bhq6arxc9l0bbksx1tue0pxh3jl1pe5lb3cye5/tinymce/7/tinymce.min.js' referrerpolicy='origin'></script>

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

  <div class='bg-gradient-to-t from-purple-200 via-purple-50 to-purple-50 py-20 px-4 font-[sans-serif]'>
    <div class='max-w-4xl w-full mx-auto text-center'>
      <h2 class='text-gray-800 text-4xl md:text-5xl font-extrabold mb-6 leading-[45px]'>Editer votre publication</h2>
      <p class='text-base text-gray-600'>Stay updated with our latest news and exclusive offers. Join our community today!</p>
      <?php
// Vérification que l'ID de l'article est présent dans l'URL et est valide
if (isset($_GET['article_id']) && is_numeric($_GET['article_id'])) {
    $article_id = intval($_GET['article_id']);
  
    // Requête SQL pour récupérer les tags associés à cet article
    $sql = "SELECT t.name 
            FROM tags t
            JOIN article_tags at ON t.id = at.tag_id
            WHERE at.article_id = ?";
    
    // Préparation de la requête
    if ($stmt = $conn->prepare($sql)) {
        // Liaison du paramètre (l'ID de l'article)
        $stmt->bind_param('i', $article_id);

        // Exécution de la requête
        $stmt->execute();

        // Récupération des résultats
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $tags = [];
            while ($row = $result->fetch_assoc()) {
                $tags[] = $row['name']; 
            }
            // Convertir le tableau de tags en une chaîne séparée par des virgules
            $tags_str = implode(', ', $tags);
        } else {
            echo "<div>Aucun tag trouvé pour cet article.</div>";
            $tags_str = ''; // Aucun tag si rien n'est trouvé
        }

        // Fermeture de la requête
        $stmt->close();
    } else {
        echo "Erreur dans la préparation de la requête.";
    }

    // Préparation de la requête SQL pour récupérer l'article
    $sql = 'SELECT * FROM articles WHERE id = ?';
    $stmt = $conn->prepare($sql);
    
    // Vérification si la préparation a réussi
    if ($stmt === false) {
        die('Erreur dans la préparation de la requête : ' . $conn->error);
    }
    // Liaison des paramètres et exécution
    $stmt->bind_param('i', $article_id);
    if ($stmt->execute()) {
        // Récupération des résultats
        $result = $stmt->get_result();
        // Vérification si un article a été trouvé
        if ($result->num_rows > 0) {
            $article = $result->fetch_assoc();
            echo "<form class='font-[sans-serif] m-6 max-w-4xl mx-auto mt-4' method='post' enctype='multipart/form-data'>
                    <div class='grid sm:grid-cols-2 gap-10'>
                        <div class='relative flex items-center'>
                            <label class='text-[13px] bg-white text-black absolute px-2 top-[-10px] left-[18px]'>Title</label>
                            <input type='text' name='title' placeholder='Enter title' value='" . htmlspecialchars($article['title']) . "'
                                class='px-4 py-3.5 bg-white text-black w-full text-sm border-2 border-gray-100 focus:border-blue-500 rounded outline-none' />
                        </div>
  <?php
                    foreach ($tags as $tag) {
                        echo '<span class='bg-blue-100 text-blue-700 px-3 py-1 rounded-full flex items-center' data-tag='$tag'>
                                $tag
                                <span class='ml-2 cursor-pointer text-red-500' onclick='removeTag(this)'>×</span>
                              </span>';
                    }
                    ?>

                  
                <div class='relative'>
                    <label for='description' class='text-[13px] text-gray-700 absolute px-2 bg-white top-[-20px] left-4'>Description</label>
                    <textarea id='description' name='description' placeholder='Enter your description here...' rows='4'
                        class='w-full px-4 mt-4 py-3 bg-white text-black border-2 border-gray-300 rounded focus:outline-none focus:border-blue-500 placeholder-gray-400'>
                    </textarea>
                </div>
            </div>
            <div class='font-[sans-serif] max-w-md mx-auto'>
                <label class='text-base font-semibold text-gray-600 mb-2 block'>Upload files</label>
                <input type='file' name='image' class='w-full text-gray-400 font-semibold text-sm bg-white border file:cursor-pointer cursor-pointer file:border-0 file:py-2.5 file:px-4 file:mr-4 file:bg-gray-100 file:hover:bg-gray-200 file:text-gray-600 rounded' />
                <button type='submit' class='mt-8 px-6 py-2.5 w-full text-sm bg-blue-500 text-white rounded hover:bg-blue-600 transition-all'>Submit</button>
            </div>
        </form>";
        } else {
            echo '<p>Aucun article trouvé avec cet ID.</p>';
        }
    } else {
        echo 'Erreur lors de l\'exécution de la requête : ' . $stmt->error;
    }

    // Fermeture de la requête préparée
    $stmt->close();
} else {
    echo '<p>ID d\'article invalide.</p>';
}

// Fermeture de la connexion à la base de données
$conn->close();
?>

   </div>
  </div>
  <script src='../view/app.js'></script>

</body>

</html>