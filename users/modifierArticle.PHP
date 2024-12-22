<?php
session_start();
include('C:\Users\ycode\Desktop\BLOG HUB\connection\connection.php');
include('C:\Users\ycode\Desktop\BLOG HUB\authentification\userValidation.php');
$user = userValidation($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['article_id']) && is_numeric($_GET['article_id'])) {
        $article_id = intval($_GET['article_id']);
        
        // Récupérer les valeurs du formulaire
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $tags = isset($_POST['tags']) ? $_POST['tags'] : '';
        
        // Gestion de l'image (si une nouvelle image a été téléchargée)
        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Si une image est téléchargée, traiter l'image
            $image = $_FILES['image']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        }

        // Mise à jour de l'article dans la base de données
        $sql = "UPDATE articles SET title = ?, content = ?, image_url = ? WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('sssi', $title, $description, $image, $article_id);
            if ($stmt->execute()) {
                echo "<div class='text-green-500'>Article mis à jour avec succès!</div>";
            } else {
                echo "<div class='text-red-500'>Erreur lors de la mise à jour de l'article.</div>";
            }
            $stmt->close();
        } else {
            echo "<div class='text-red-500'>Erreur dans la préparation de la requête de mise à jour.</div>";
        }

        // Mise à jour des tags (en cas de changement)
        // Supprimer les tags existants et ajouter les nouveaux
        $sql = "DELETE FROM article_tags WHERE article_id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('i', $article_id);
            $stmt->execute();
            $stmt->close();
        }

        // Ajouter les nouveaux tags
        $tagsArray = explode(',', $tags); // Les tags sont séparés par des virgules
        foreach ($tagsArray as $tag) {
            $tag = trim($tag); // Enlever les espaces inutiles
            if (!empty($tag)) {
                // Vérifier si le tag existe déjà, sinon l'ajouter
                $sql = "INSERT INTO tags (name) VALUES (?)";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param('s', $tag);
                    $stmt->execute();
                    $stmt->close();

                    // Récupérer l'ID du tag ajouté
                    $tag_id = $conn->insert_id;

                    // Associer le tag à l'article
                    $sql = "INSERT INTO article_tags (article_id, tag_id) VALUES (?, ?)";
                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param('ii', $article_id, $tag_id);
                        $stmt->execute();
                        $stmt->close();
                    }
                }
            }
        }
    }
}
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
        'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'visualblocks', 'wordcount',
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
            // Convertir le tableau de tags en une chaîne JSON
            $tags_json = json_encode($tags);
        } else {
            echo "<div>Aucun tag trouvé pour cet article.</div>";
            $tags_json = '[]'; // Si aucun tag n'est trouvé
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
            echo "
<form class='font-[sans-serif] m-6 max-w-4xl mx-auto mt-4' method='post' enctype='multipart/form-data'>
    <div class='grid sm:grid-cols-2 gap-10'>
        <div class='relative flex items-center'>
            <label class='text-[13px] bg-white text-black absolute px-2 top-[-10px] left-[18px]'>Title</label>
            <input type='text' name='title' placeholder='Enter title' value='" . htmlspecialchars($article['title']) . "'
                class='px-4 py-3.5 bg-white text-black w-full text-sm border-2 border-gray-100 focus:border-blue-500 rounded outline-none' />
        </div>

        <div class='relative flex flex-col items-start'>
            <label class='text-[13px] bg-white text-black px-2 mb-2'>Tags</label>
            <div id='tag-container' class='flex flex-wrap items-center border-2 border-gray-100 bg-white px-2 py-2 rounded w-full'>
                <span id='tag-list' class='flex flex-wrap gap-2'></span>
                <input
                    type='text'
                    id='tag-input'
                    placeholder='Add a tag and press Enter'
                    class='px-4 py-2 flex-grow bg-white text-black text-sm focus:outline-none'
                    name='tags'
                    onkeydown='handleTagInput(event)' />
            </div>
            <input type='hidden' name='tags' id='tags-hidden-input' />
        </div>

        <div class='relative'>
            <label for='description' class='text-[13px] text-gray-700 absolute px-2 bg-white top-[-20px] left-4'>Description</label>
       <textarea id='description' name='description' placeholder='Enter your description here...' rows='4'
    class='w-full px-4 mt-4 py-3 bg-white text-black border-2 border-gray-300 rounded focus:outline-none focus:border-blue-500 placeholder-gray-400'>
    ". htmlspecialchars($article['title'])."
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

<script>
// Les tags récupérés de PHP et encodés en JSON
const existingTags = <?php echo $tags_json; ?>;

// Fonction pour afficher les tags dans le conteneur
function displayTags(tags) {
    const tagListContainer = document.getElementById('tag-list');
    tagListContainer.innerHTML = '';  // Vide le conteneur des tags existants
    
    tags.forEach(tag => {
        const tagElement = document.createElement('span');
        tagElement.classList.add('tag');
        tagElement.classList.add('bg-blue-100', 'text-blue-700', 'px-3', 'py-1', 'rounded-full', 'flex', 'items-center');
        tagElement.textContent = tag;

        // Créer un bouton de suppression pour chaque tag
        const removeBtn = document.createElement('button');
        removeBtn.classList.add('ml-2', 'text-blue-500');
        removeBtn.textContent = '×';
        removeBtn.onclick = function () {
            removeTag(tag);
            tagListContainer.removeChild(tagElement);  // Supprimer visuellement le tag
        };

        tagElement.appendChild(removeBtn);
        tagListContainer.appendChild(tagElement);
    });
}

// Fonction pour gérer l'ajout d'un tag lors de l'appui sur Entrée
function handleTagInput(event) {
    if (event.key === 'Enter') {
        const inputElement = document.getElementById('tag-input');
        const newTag = inputElement.value.trim();
        
        if (newTag && !existingTags.includes(newTag)) {
            existingTags.push(newTag);  // Ajoute le nouveau tag à la liste existante
            displayTags(existingTags);  // Met à jour l'affichage des tags
        }
        
        inputElement.value = ''; // Vide l'input après l'ajout du tag
    }
}

// Fonction pour supprimer un tag de la liste des tags existants
function removeTag(tagToRemove) {
    const index = existingTags.indexOf(tagToRemove);
    if (index > -1) {
        existingTags.splice(index, 1);  // Supprime le tag de la liste
        updateHiddenInput();  // Met à jour l'input caché pour refléter les modifications
    }
}

// Fonction pour mettre à jour l'input caché avec la liste des tags
function updateHiddenInput() {
    const hiddenInput = document.getElementById('hidden-tags');  // Supposons qu'il y a un input caché
    hiddenInput.value = JSON.stringify(existingTags);  // Met à jour la valeur de l'input caché
}

// Affiche les tags existants au chargement de la page
document.addEventListener('DOMContentLoaded', function () {
    displayTags(existingTags);
    document.getElementById('tag-input').addEventListener('keyup', handleTagInput);
});
</script>

<!-- HTML pour afficher les tags et un champ caché -->
<div id="tag-list"></div>
<input type="text" id="tag-input" placeholder="Ajouter un tag" />
<input type="hidden" id="hidden-tags" name="tags" value="" />


   </div>
  </div>
  <script src='../view/app.js'></script>

</body>

</html>