<?php
session_start();
include('C:\Users\ycode\Desktop\BLOG HUB\connection\connection.php');
include('C:\Users\ycode\Desktop\BLOG HUB\authentification\userValidation.php');
$user = userValidation($conn);

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
          <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'><a href='javascript:void(0)'
              class='hover:text-[#007bff] text-gray-500 block font-semibold text-[15px]'>Blog</a>
          </li>
          <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'><a href='javascript:void(0)'
              class='hover:text-[#007bff] text-gray-500 block font-semibold text-[15px]'>Feature</a>
          </li>
          <!-- <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'><a href='javascript:void(0)'
              class='hover:text-[#007bff] text-gray-500 block font-semibold text-[15px]'>Blog</a>
            </li> -->
          <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'><a href='javascript:void(0)'
              class='hover:text-[#007bff] text-gray-500 block font-semibold text-[15px]'>About</a>
          </li>
          <li class='max-lg:border-b border-gray-300 max-lg:py-3 px-3'><a href='javascript:void(0)'
              class='hover:text-[#007bff] text-gray-500 block font-semibold text-[15px]'>Contact</a>
          </li>
        </ul>
      </div>

      <div class='flex max-lg:ml-auto space-x-4'>
        <?php
        if (isset($_SESSION['token']) && $user) {
         

          echo "<p class='text-gray-700'>Bonjour, " . htmlspecialchars($user['username']) . "</p>";
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
        <div id="burger-menu" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden buttom-4 left-12 ">
          <div class="bg-white p-6 rounded-lg shadow-lg w-3/4 max-w-md">
            <button id="close-btn" class="text-right text-2xl text-red-600 hover:text-red-800">&times;</button>
            <ul class="space-y-4 text-center text-gray-800 text-xl">
              <li><a href="#" class="block hover:text-blue-600">Accueil</a></li>
              <li><a href="#" class="block hover:text-blue-600">Services</a></li>
              <li><a href="#" class="block hover:text-blue-600">À propos</a></li>
              <li><a href="#" class="block hover:text-blue-600">Contact</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- SEARCH BAR -->
  <div class="flex rounded-full border-2 border-blue-500 overflow-hidden max-w-md mx-auto font-[sans-serif] mt-4">
    <input type="email" placeholder="Search Something..."
      class="w-full outline-none bg-white text-sm px-5 py-3" />
    <button type='button' class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 px-6">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192.904 192.904" width="18px" class="fill-white">
        <path
          d="m190.707 180.101-47.078-47.077c11.702-14.072 18.752-32.142 18.752-51.831C162.381 36.423 125.959 0 81.191 0 36.422 0 0 36.423 0 81.193c0 44.767 36.422 81.187 81.191 81.187 19.688 0 37.759-7.049 51.831-18.751l47.079 47.078a7.474 7.474 0 0 0 5.303 2.197 7.498 7.498 0 0 0 5.303-12.803zM15 81.193C15 44.694 44.693 15 81.191 15c36.497 0 66.189 29.694 66.189 66.193 0 36.496-29.692 66.187-66.189 66.187C44.693 147.38 15 117.689 15 81.193z">
        </path>
      </svg>
    </button>
  </div>

  <div class="bg-white font-sans p-4 ">
    <div class="max-w-5xl flex  max-lg:max-w-3xl max-md:max-w-sm mx-auto">
      <div>
        <div class="flex justify-between items-center mb-5 p-4 bg-gray-50 rounded-lg shadow-md">
          <h2 class="text-3xl font-extrabold text-gray-800">LATEST BLOGS</h2>
          <button class="bg-blue-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-600">
            <a href="../users/addArticle.php">Add Article</a>
          </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">


        <?php
// Requête pour récupérer tous les articles
$sql = "SELECT * FROM articles";
$articles_result = $conn->query($sql);

// Vérification si la requête des articles a échoué
if (!$articles_result) {
    die('Erreur de récupération des articles : ' . $conn->connect_error);
}

// Boucle sur les articles
while ($row = $articles_result->fetch_assoc()) {
    // Préparer la requête pour récupérer les tags de l'article
    $stmt_tags = $conn->prepare("
        SELECT t.name 
        FROM tags t
        JOIN article_tags at ON t.id = at.tag_id
        WHERE at.article_id = ?
    ");

    if (!$stmt_tags) {
        die("Erreur de préparation de la requête des tags : " . $conn->error);
    }

    // Lier l'ID de l'article à la requête des tags
    $stmt_tags->bind_param('i', $row['id']);
    $stmt_tags->execute();
    $result_tags = $stmt_tags->get_result();

    // Récupérer les tags dans un tableau
    $tags = [];
    while ($row_tag = $result_tags->fetch_assoc()) {
        $tags[] = $row_tag['name'];
    }

    // Générer la chaîne des tags
    $tags_html = !empty($tags)
        ? implode(' ', array_map(function ($tag) {
            return '#' . htmlspecialchars($tag);
        }, $tags))
        : "Aucun tag trouvé pour cet article.";

    $stmt_tags->close();

    // Requête SQL pour récupérer le nom d'utilisateur de l'auteur de l'article
    $req_user = "SELECT username FROM users WHERE id = '{$row['user_id']}'";
    $user_result = mysqli_query($conn, $req_user);

    // Vérification si la requête pour l'utilisateur a renvoyé un résultat
    if ($user_result && mysqli_num_rows($user_result) > 0) {
        // Récupérer le nom d'utilisateur
        $user = mysqli_fetch_assoc($user_result);
        $username = $user['username'];
    } else {
        // Si aucun utilisateur n'est trouvé ou erreur dans la requête
        $username = 'Utilisateur inconnu';  // Valeur par défaut
    }

    // Afficher l'article avec ses tags et autres informations
    echo '
    <div class="flex max-lg:flex-col bg-white cursor-pointer rounded overflow-hidden shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] hover:scale-[1.03] transition-all duration-300">
        <div class="h-64 lg:w-full">
            <img src="../users/' . htmlspecialchars($row['image_url']) . '" alt="Blog Post" class="w-full h-full object-cover">
        </div>
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-800">' . htmlspecialchars_decode($row['title']) . '</h3>
            <span class="text-sm block text-gray-400 mt-2">' . htmlspecialchars($row['created_at']) . ' | BY ' . htmlspecialchars($username) . '</span>
            <p class="text-sm text-gray-500 mt-4">' . htmlspecialchars_decode($row['content']) . '</p>
            <p class="text-sm text-gray-500 mt-4">' . $tags_html . '</p>
            <a href="../view/REAMORE.PHP?id=' . htmlspecialchars($row['id']) . '" class="mt-4 inline-block text-blue-600 font-semibold text-sm hover:underline">Read More</a>
        </div>
    </div>
    ';
}
?>


          <!-- pagination  -->

          <ul class="flex space-x-5 justify-center font-[sans-serif]">
            <li class="flex items-center justify-center shrink-0 bg-gray-100 w-10 h-10 rounded-full">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-3 fill-gray-300" viewBox="0 0 55.753 55.753">
                <path
                  d="M12.745 23.915c.283-.282.59-.52.913-.727L35.266 1.581a5.4 5.4 0 0 1 7.637 7.638L24.294 27.828l18.705 18.706a5.4 5.4 0 0 1-7.636 7.637L13.658 32.464a5.367 5.367 0 0 1-.913-.727 5.367 5.367 0 0 1-1.572-3.911 5.369 5.369 0 0 1 1.572-3.911z"
                  data-original="#000000" />
              </svg>
            </li>
            <li
              class="flex items-center justify-center shrink-0 bg-blue-500  border-2 border-blue-500 cursor-pointer text-base font-bold text-white w-10 h-10 rounded-full">
              1
            </li>
            <li
              class="flex items-center justify-center shrink-0 hover:bg-gray-50  border-2 cursor-pointer text-base font-bold text-[#333] w-10 h-10 rounded-full">
              2
            </li>
            <li
              class="flex items-center justify-center shrink-0 hover:bg-gray-50  border-2 cursor-pointer text-base font-bold text-[#333] w-10 h-10 rounded-full">
              3
            </li>
            <li
              class="flex items-center justify-center shrink-0 hover:bg-gray-50  border-2 cursor-pointer text-base font-bold text-[#333] w-10 h-10 rounded-full">
              4
            </li>
            <li class="flex items-center justify-center shrink-0 hover:bg-gray-50 border-2 cursor-pointer w-10 h-10 rounded-full">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-3 fill-gray-400 rotate-180" viewBox="0 0 55.753 55.753">
                <path
                  d="M12.745 23.915c.283-.282.59-.52.913-.727L35.266 1.581a5.4 5.4 0 0 1 7.637 7.638L24.294 27.828l18.705 18.706a5.4 5.4 0 0 1-7.636 7.637L13.658 32.464a5.367 5.367 0 0 1-.913-.727 5.367 5.367 0 0 1-1.572-3.911 5.369 5.369 0 0 1 1.572-3.911z"
                  data-original="#000000" />
              </svg>
            </li>
          </ul>
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
          <script src="/view/app.js"></script>
</body>

</html>