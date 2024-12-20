<?php
session_start();
include('C:\Users\ycode\Desktop\BLOG HUB\connection\connection.php');
include('C:\Users\ycode\Desktop\BLOG HUB\authentification\userValidation.php');
$user = userValidation($conn);

if (isset($_GET['id'])) {
    $article_id = $_GET['id'];

    // Préparer la requête pour récupérer les commentaires
    $stmt = $conn->prepare("SELECT c.content, c.created_at ,  u.username AS user_name
    FROM comments c
    JOIN users u ON c.user_id = u.id
    WHERE c.article_id = ?");

    // Vérifier si la préparation a échoué
    if ($stmt === false) {
        echo "Erreur dans la préparation de la requête : " . $conn->error;
        exit;
    }

    // Lier le paramètre à la requête préparée
    $stmt->bind_param("i", $article_id);

    // Exécuter la requête
    if (!$stmt->execute()) {
        echo "Erreur lors de l'exécution de la requête : " . $stmt->error;
        exit;
    }

    // Récupérer les résultats de la requête
    $result = $stmt->get_result();

    // Vérifier si la récupération des résultats a échoué
    if ($result === false) {
        echo "Erreur lors de la récupération des résultats : " . $stmt->error;
        exit;
    }

    // Tableau pour stocker les commentaires
    $comments = [];

    // Vérifier s'il y a des résultats
    if ($result->num_rows > 0) {
        // Parcourir les résultats
        while ($row = $result->fetch_assoc()) {
            $comments[] = [
                'user_name' => $row['user_name'],
                'content' => $row['content'],
                'created_at' => $row['created_at'],
                // Assurez-vous que `updated_at` existe dans la requête SQL
                'updated_at' => isset($row['updated_at']) ? $row['updated_at'] : null,
            ];
        }
        $comments_json = json_encode($comments);
    } else {
        echo "Aucun commentaire trouvé pour cet article.";
    }

    // Fermer la requête préparée
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>


</head>

<body>
    <header class='flex shadow-md py-4 px-4 sm:px-10 bg-white font-[sans-serif] min-h-[70px] tracking-wide relative z-50'>
        <div class='flex flex-wrap items-center justify-between gap-5 w-full'>
            <a href="javascript:void(0)"><img src="/IMG/BLOG HUB (1) (1).png" style="width: 100px; height: max-content ; display: block;" alt="logo" class='w-36' />
            </a>

            <div id="collapseMenu"
                class='max-lg:hidden lg:!block max-lg:before:fixed max-lg:before:bg-black max-lg:before:opacity-50 max-lg:before:inset-0 max-lg:before:z-50'>
                <button id="toggleClose" class='lg:hidden fixed top-2 right-4 z-[100] rounded-full bg-white w-9 h-9 flex items-center justify-center border'>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-black" viewBox="0 0 320.591 320.591">
                        <path
                            d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
                            data-original="#000000"></path>
                        <path
                            d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
                            data-original="#000000"></path>
                    </svg>
                </button>

                <ul
                    class='lg:flex gap-x-5 max-lg:space-y-3 max-lg:fixed max-lg:bg-white max-lg:w-1/2 max-lg:min-w-[300px] max-lg:top-0 max-lg:left-0 max-lg:p-6 max-lg:h-full max-lg:shadow-md max-lg:overflow-auto z-50'>
                    <li class='mb-6 hidden max-lg:block'>
                        <a href="/index.php"><img src="/IMG/BLOG HUB.svg" class="w-32 h-32 object-contain" alt="logo" class='w-36' />
                        </a>
                    </li>
                    <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'>
                        <a href='/index.php'
                            class='hover:text-[#007bff] text-[#007bff] block font-semibold text-[15px]'>Home</a>
                    </li>
                    <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'><a href='/view/BLOG.PHP'
                            class='hover:text-[#007bff] text-gray-500 block font-semibold text-[15px]'>Blog</a>
                    </li>
                    <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'><a href='javascript:void(0)'
                            class='hover:text-[#007bff] text-gray-500 block font-semibold text-[15px]'>Feature</a>
                    </li>

                    <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'><a href='javascript:void(0)'
                            class='hover:text-[#007bff] text-gray-500 block font-semibold text-[15px]'>About</a>
                    </li>
                    <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'><a href='javascript:void(0)'
                            class='hover:text-[#007bff] text-gray-500 block font-semibold text-[15px]'>Contact</a>
                    </li>
                </ul>
            </div>

           
                <?php
                if (isset($_SESSION['token']) && $user) {
                    echo "<p class='text-gray-700'>Bonjour, " . htmlspecialchars($user['username']) . "</p>";
                    echo '<a href="/authentification/logout.php" class="px-4 py-2 text-sm rounded-full font-bold text-white border-2 border-red-500 bg-red-500 hover:bg-transparent hover:text-red-500">Déconnexion</a>';
                } else {
                    echo '<a href="/authentification/login.php" class="px-4 py-2 text-sm rounded-full font-bold text-gray-500 border-2 hover:bg-gray-50">Login</a>';
                    echo '<a href="/authentification/inscreption.php" class="px-4 py-2 text-sm rounded-full font-bold text-white border-2 border-[#007bff] bg-[#007bff] hover:bg-transparent hover:text-[#007bff]">Sign Up</a>';
                }
                ?>
                 <div class="flex items-center space-x-4">
            <div class="relative inline-block">
        <img src="https://avf.asso.fr/guipavas/wp-content/uploads/sites/153/2020/09/92979836-ic%C3%B4ne-de-visage-anonyme-de-profil-personne-silhouette-grise-avatar-par-d%C3%A9faut-masculin-photo-placeholder--300x300.jpg" class="w-14 h-14 rounded-full" />
        <span class="h-3 w-3 rounded-full border border-white bg-green-500 block absolute bottom-1 right-0"></span>
      </div>
                <button id="toggleOpen" class="lg:hidden">
                    <svg class="w-7 h-7" fill="#000" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>


    <!-- body content -->
    <?php
    $stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
    $stmt->bind_param('i', $article_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
        die('Erreur dans la requête : ' . $conn->error);
    }

if ($result->num_rows > 0) {
    $article = $result->fetch_assoc();

    // Variables dynamiques
    $title = htmlspecialchars($article['title']);
    $content = htmlspecialchars($article['content']);
    $created_at = htmlspecialchars($article['created_at']);
    $image_url = htmlspecialchars($article['image_url']);
    $user_id = htmlspecialchars($article['user_id']);


    $likes = intval($article['like']); // Nombre de likes (optionnel)
    $user_query = "SELECT username FROM users WHERE id = $user_id";
    $user_result = $conn->query($user_query);
    $username = $user_result && $user_result->num_rows > 0
        ? htmlspecialchars($user_result->fetch_assoc()['username'])
        : 'Utilisateur inconnu';

    echo "
    <div class='grid sm:grid-cols-2 items-center gap-8 font-[sans-serif] max-w-5xl max-sm:max-w-sm mx-auto p-4'>
        <div class='sm:h-[400px] flex'>
<div class='relative font-[sans-serif] w-max mx-auto'>
      <button type='button' id='dropdownToggle'
        class='px-5 py-2.5 border border-gray-300 text-gray-800 text-sm outline-none bg-white hover:bg-gray-50'>
        
                            <p id='edit_pub' ><i class='fa-solid fa-ellipsis fa-flip-both fa-2x' style='color: #000000;'></i></p>

      </button>

      <ul id='dropdownMenu' class='absolute hidden shadow-[0_8px_19px_-7px_rgba(6,81,237,0.2)] bg-white py-2 z-[1000] min-w-full w-max divide-y max-h-96 overflow-auto'>
        <li class='py-3 px-5 hover:bg-gray-50 text-gray-800 text-sm cursor-pointer'>Supprimmer</li>
        <li class='py-3 px-5 hover:bg-gray-50 text-gray-800 text-sm cursor-pointer'><a href='../users/modifierArticle.php?article_id=$article_id'>Modifier l'article</a>

 </li>
        <li class='py-3 px-5 hover:bg-gray-50 text-gray-800 text-sm cursor-pointer'>desactiver commentaire</li>
        <li class='py-3 px-5 hover:bg-gray-50 text-gray-800 text-sm cursor-pointer'>Archiver</li>
      </ul>
    </div>
            <img src='../users/$image_url' class='w-full h-full object-contain' alt='Image de l'article' />
        </div>

        <div>
            <h3 class='text-xl font-extrabold text-gray-800'>$title</h3>
            <p class='mt-4 text-sm text-gray-800'>$content</p>

            <div class='mt-8 text-left'>
                <h4 class='text-base font-bold'>$username</h4>
            </div>

            <div class='flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 md:space-x-8'>
                <!-- Icônes sociales -->
                <div class='space-x-3 mt-8 flex items-center'>
                    <a href='javascript:void(0)'
                        class='w-7 h-7 inline-flex items-center justify-center rounded-full bg-blue-600 hover:bg-blue-700'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='14px' fill='#fff' viewBox='0 0 155.139 155.139'>
                            <path d='M89.584 155.139V84.378h23.742l3.562-27.585H89.584V39.184c0-7.984 2.208-13.425 13.67-13.425l14.595-.006V1.08C115.325.752 106.661 0 96.577 0 75.52 0 61.104 12.853 61.104 36.452v20.341H37.29v27.585h23.814v70.761h28.48z'></path>
                        </svg>
                    </a>
                    <a href='javascript:void(0)'
                        class='w-7 h-7 inline-flex items-center justify-center rounded-full bg-[#03a9f4] hover:bg-[#03a1f4]'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='14px' fill='#fff' viewBox='0 0 512 512'>
                            <path d='M512 97.248c-19.04 8.352-39.328 13.888-60.48 16.576 21.76-12.992 38.368-33.408 46.176-58.016-20.288 12.096-42.688 20.64-66.56 25.408C411.872 60.704 384.416 48 354.464 48c-58.112 0-104.896 47.168-104.896 104.992 0 8.32.704 16.32 2.432 23.936-87.264-4.256-164.48-46.08-216.352-109.792-9.056 15.712-14.368 33.696-14.368 53.056 0 36.352 18.72 68.576 46.624 87.232-16.864-.32-33.408-5.216-47.424-12.928v1.152c0 51.008 36.384 93.376 84.096 103.136-8.544 2.336-17.856 3.456-27.52 3.456-6.72 0-13.504-.384-19.872-1.792 13.6 41.568 52.192 72.128 98.08 73.12-35.712 27.936-81.056 44.768-130.144 44.768-8.608 0-16.864-.384-25.12-1.44C46.496 446.88 101.6 464 161.024 464c193.152 0 298.752-160 298.752-298.688 0-4.64-.16-9.12-.384-13.568 20.832-14.784 38.336-33.248 52.608-54.496z'></path>
                        </svg>
                    </a>
                    <a href='javascript:void(0)'
                        class='w-7 h-7 inline-flex items-center justify-center rounded-full bg-[#03a9f4] hover:bg-[#03a1f4]'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='14px' fill='#fff' viewBox='0 0 512 512'>
                            <path d='M512 97.248c-19.04 8.352-39.328 13.888-60.48 16.576 21.76-12.992 38.368-33.408 46.176-58.016-20.288 12.096-42.688 20.64-66.56 25.408C411.872 60.704 384.416 48 354.464 48c-58.112 0-104.896 47.168-104.896 104.992 0 8.32.704 16.32 2.432 23.936-87.264-4.256-164.48-46.08-216.352-109.792-9.056 15.712-14.368 33.696-14.368 53.056 0 36.352 18.72 68.576 46.624 87.232-16.864-.32-33.408-5.216-47.424-12.928v1.152c0 51.008 36.384 93.376 84.096 103.136-8.544 2.336-17.856 3.456-27.52 3.456-6.72 0-13.504-.384-19.872-1.792 13.6 41.568 52.192 72.128 98.08 73.12-35.712 27.936-81.056 44.768-130.144 44.768-8.608 0-16.864-.384-25.12-1.44C46.496 446.88 101.6 464 161.024 464c193.152 0 298.752-160 298.752-298.688 0-4.64-.16-9.12-.384-13.568 20.832-14.784 38.336-33.248 52.608-54.496z'></path>
                        </svg>
                    </a>
                   
                
                </div>

                <!-- Bouton Like -->
                <div class='font-[sans-serif] bg-white border-2 divide-x-2 mt-4 flex rounded overflow-hidden'>
                    <button type='button' id='likeButton'
                        class='px-5 py-2.5 flex items-center text-[#333] text-sm tracking-wider font-semibold'>
                        <svg xmlns='http://www.w3.org/2000/svg' class='w-5 h-5 mr-2' viewBox='0 0 512 512'>
                            <path fill='#f9595f' d='M449.28 121.43a115.2 115.2 0 0 0-137.89-35.75c-21.18 9.14-40.07 24.55-55.39 45-15.32-20.5-34.21-35.91-55.39-45a115.2 115.2 0 0 0-137.89 35.75c-16.5 21.62-25.22 48.64-25.22 78.13 0 42.44 25.31 89 75.22 138.44 40.67 40.27 88.73 73.25 113.75 89.32a54.78 54.78 0 0 0 59.06 0c25-16.07 73.08-49.05 113.75-89.32 49.91-49.42 75.22-96 75.22-138.44 0-29.49-8.72-56.51-25.22-78.13z'></path>
                        </svg>
                        Like
                    </button>
                    <button type='button' id='likeCountButton' class='px-5 py-2.5'>$likes</button>
                       <button id='openModal' ><i class='fa-solid fa-comment fa-2x' style='color: #0a0a0a;'></i></button>
                </div>
                </div>
            </div>
        </div>
    </div>";
} else {
    echo "<p>Aucun article trouvé avec cet ID.</p>";
}
?>



   

    <!-- COMMENTAIRES -->

    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden" id="commentModal">
        <div class="bg-white rounded-lg w-11/12 max-w-lg p-6 shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Commentaires</h2>
                <button id="closeModal" class="text-red-500 hover:text-red-700">&times;</button>
            </div>
            <div class="comments-list border border-gray-300 rounded-md p-4 h-48 overflow-y-auto mb-4" id="commentsList">
                <!-- Les commentaires seront ajoutés ici -->
            </div>
            <form action="./ajouter_commentaire.php" method="post">
                <div class="flex items-center space-x-2">
                    <input type="text" id="newComment" name="content" placeholder="Ajouter un commentaire" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="hidden" id="articleId" name="article_id" value="<?php echo $article_id; ?>"> <!-- Champ caché pour l'ID de l'article -->
                    <button id="addComment" class="p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition" type="submit">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Récupérer les commentaires du PHP et afficher dans la modal
        const comments = <?php echo $comments_json; ?>;
        console.log(comments);

        document.addEventListener('DOMContentLoaded', () => {
            const commentsList = document.querySelector('#commentsList');

            // Afficher les commentaires dans la modal
            comments.forEach(comment => {
                const commentDiv = document.createElement('div');
                commentDiv.classList.add('comment', 'mb-4', 'p-4', 'bg-gray-100', 'rounded-md', 'shadow-md', 'border', 'border-gray-300');


                const commentDate = (comment.created_at === comment.updated_at) ?
                    `Créé le : ${new Date(comment.created_at).toLocaleString()}` :
                    `Modifié le : ${new Date(comment.updated_at).toLocaleString()}`;

                commentDiv.innerHTML = `
            <p><strong>${comment.user_name}</strong> - ${commentDate}</p>
            <p>${comment.content}</p>
        `;

                commentsList.appendChild(commentDiv);
            });
        });
    </script>

    <!-- footer -->
    <footer class="font-sans tracking-wide bg-gray-50 px-10 pt-12 pb-6">
        <div class="flex flex-wrap justify-between gap-10">
            <div class="max-w-md">
                <a href='javascript:void(0)'>
                    <img src="/IMG/BLOG HUB (1) (1).png" style="width: 100px; height: max-content ; display: block;" git add . alt="logo" class='w-36' />
                </a>
                <div class="mt-6">
                    <p class="text-gray-600 leading-relaxed text-sm">ReadymadeUI is a library of pre-designed UI components built for Tailwind CSS. It offers a collection of versatile, ready-to-use components that streamline the development process by providing a wide range of UI elements.</p>
                </div>
                <ul class="mt-10 flex space-x-5">
                    <li>
                        <a href='javascript:void(0)'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-blue-600 w-8 h-8" viewBox="0 0 49.652 49.652">
                                <path d="M24.826 0C11.137 0 0 11.137 0 24.826c0 13.688 11.137 24.826 24.826 24.826 13.688 0 24.826-11.138 24.826-24.826C49.652 11.137 38.516 0 24.826 0zM31 25.7h-4.039v14.396h-5.985V25.7h-2.845v-5.088h2.845v-3.291c0-2.357 1.12-6.04 6.04-6.04l4.435.017v4.939h-3.219c-.524 0-1.269.262-1.269 1.386v2.99h4.56z" data-original="#000000" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href='javascript:void(0)'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 112.196 112.196">
                                <circle cx="56.098" cy="56.097" r="56.098" fill="#007ab9" data-original="#007ab9" />
                                <path fill="#fff" d="M89.616 60.611v23.128H76.207V62.161c0-5.418-1.936-9.118-6.791-9.118-3.705 0-5.906 2.491-6.878 4.903-.353.862-.444 2.059-.444 3.268v22.524h-13.41s.18-36.546 0-40.329h13.411v5.715c-.027.045-.065.089-.089.132h.089v-.132c1.782-2.742 4.96-6.662 12.085-6.662 8.822 0 15.436 5.764 15.436 18.149zm-54.96-36.642c-4.587 0-7.588 3.011-7.588 6.967 0 3.872 2.914 6.97 7.412 6.97h.087c4.677 0 7.585-3.098 7.585-6.97-.089-3.956-2.908-6.967-7.496-6.967zm-6.791 59.77H41.27v-40.33H27.865v40.33z" data-original="#f1f2f2" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href='javascript:void(0)'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 152 152">
                                <linearGradient id="a" x1="22.26" x2="129.74" y1="22.26" y2="129.74" gradientUnits="userSpaceOnUse">
                                    <stop offset="0" stop-color="#fae100" />
                                    <stop offset=".15" stop-color="#fcb720" />
                                    <stop offset=".3" stop-color="#ff7950" />
                                    <stop offset=".5" stop-color="#ff1c74" />
                                    <stop offset="1" stop-color="#6c1cd1" />
                                </linearGradient>
                                <g data-name="Layer 2">
                                    <g data-name="03.Instagram">
                                        <rect width="152" height="152" fill="url(#a)" data-original="url(#a)" rx="76" />
                                        <g fill="#fff">
                                            <path fill="#ffffff10" d="M133.2 26c-11.08 20.34-26.75 41.32-46.33 60.9S46.31 122.12 26 133.2q-1.91-1.66-3.71-3.46A76 76 0 1 1 129.74 22.26q1.8 1.8 3.46 3.74z" data-original="#ffffff10" />
                                            <path d="M94 36H58a22 22 0 0 0-22 22v36a22 22 0 0 0 22 22h36a22 22 0 0 0 22-22V58a22 22 0 0 0-22-22zm15 54.84A18.16 18.16 0 0 1 90.84 109H61.16A18.16 18.16 0 0 1 43 90.84V61.16A18.16 18.16 0 0 1 61.16 43h29.68A18.16 18.16 0 0 1 109 61.16z" data-original="#ffffff" />
                                            <path d="m90.59 61.56-.19-.19-.16-.16A20.16 20.16 0 0 0 76 55.33 20.52 20.52 0 0 0 55.62 76a20.75 20.75 0 0 0 6 14.61 20.19 20.19 0 0 0 14.42 6 20.73 20.73 0 0 0 14.55-35.05zM76 89.56A13.56 13.56 0 1 1 89.37 76 13.46 13.46 0 0 1 76 89.56zm26.43-35.18a4.88 4.88 0 0 1-4.85 4.92 4.81 4.81 0 0 1-3.42-1.43 4.93 4.93 0 0 1 3.43-8.39 4.82 4.82 0 0 1 3.09 1.12l.1.1a3.05 3.05 0 0 1 .44.44l.11.12a4.92 4.92 0 0 1 1.1 3.12z" data-original="#ffffff" />
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href='javascript:void(0)'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 1227 1227">
                                <path d="M613.5 0C274.685 0 0 274.685 0 613.5S274.685 1227 613.5 1227 1227 952.315 1227 613.5 952.315 0 613.5 0z" data-original="#000000" />
                                <path fill="#fff" d="m680.617 557.98 262.632-305.288h-62.235L652.97 517.77 470.833 252.692H260.759l275.427 400.844-275.427 320.142h62.239l240.82-279.931 192.35 279.931h210.074L680.601 557.98zM345.423 299.545h95.595l440.024 629.411h-95.595z" data-original="#ffffff" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="max-lg:min-w-[140px]">
                <h4 class="text-gray-800 font-semibold text-base relative max-sm:cursor-pointer">Services</h4>

                <ul class="mt-6 space-y-4">
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Web Development</a>
                    </li>
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Pricing</a>
                    </li>
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Support</a>
                    </li>
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Client Portal</a>
                    </li>
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Resources</a>
                    </li>
                </ul>
            </div>

            <div class="max-lg:min-w-[140px]">
                <h4 class="text-gray-800 font-semibold text-base relative max-sm:cursor-pointer">Platforms</h4>
                <ul class="space-y-4 mt-6">
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Hubspot</a>
                    </li>
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Integration Services</a>
                    </li>
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Marketing Glossar</a>
                    </li>
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>UIPath</a>
                    </li>
                </ul>
            </div>

            <div class="max-lg:min-w-[140px]">
                <h4 class="text-gray-800 font-semibold text-base relative max-sm:cursor-pointer">Company</h4>

                <ul class="space-y-4 mt-6">
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>About us</a>
                    </li>
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Careers</a>
                    </li>
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Blog</a>
                    </li>
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Portfolio</a>
                    </li>
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Events</a>
                    </li>
                </ul>
            </div>

            <div class="max-lg:min-w-[140px]">
                <h4 class="text-gray-800 font-semibold text-base relative max-sm:cursor-pointer">Additional</h4>

                <ul class="space-y-4 mt-6">
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>FAQ</a>
                    </li>
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Partners</a>
                    </li>
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Sitemap</a>
                    </li>
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Contact</a>
                    </li>
                    <li>
                        <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>News</a>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="mt-10 mb-6 border-gray-300" />

        <div class="flex flex-wrap max-md:flex-col gap-4">
            <ul class="md:flex md:space-x-6 max-md:space-y-2">
                <li>
                    <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Terms of Service</a>
                </li>
                <li>
                    <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Privacy Policy</a>
                </li>
                <li>
                    <a href='javascript:void(0)' class='hover:text-gray-800 text-gray-600 text-sm'>Security</a>
                </li>
            </ul>

            <p class='text-gray-600 text-sm md:ml-auto'>© ReadymadeUI. All rights reserved.</p>
        </div>
    </footer>
    <script src="../view/app.js"></script>

</body>

</html>