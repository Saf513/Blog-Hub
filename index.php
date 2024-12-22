
<?php  
session_start();
include __DIR__ . "/authentification/userValidation.php";
include __DIR__ . "/connection/connection.php";
$user = userValidation($conn);

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOG HUB</title>
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
</body>
</html>
  <!-- hero section -->
  <section>
    <div class="relative bg-gradient-to-r from-purple-900 to-indigo-800 py-16 font-[sans-serif]">
      <div class="absolute inset-0">
        <img src="https://readymadeui.com/cardImg.webp" alt="Background Image" class="w-full h-full object-cover opacity-50" />
      </div>
      <div class="relative max-w-screen-xl mx-auto px-8 z-10 text-center text-white">
        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">Bienvenue sur notre blog !</h1>
        <p class="text-lg md:text-xl mb-12">Explorez les dernières tendances, conseils et inspirations pour enrichir votre quotidien .</p>
        <p class="text-lg md:text-xl mb-12">Veuillez creer votre propre blog .</p>
        <button  type="button" class="bg-indigo-600 hover:bg-indigo-700 text-white text-base tracking-wide px-6 py-3 rounded-full transition duration-300 ease-in-out shadow-lg hover:shadow-xl"><a href="/users/addArticle.php">Create Publication</a></button>
      </div>
    </div>
  </section>

  <!-- content site -->

  <div class="bg-gradient-to-r from-purple-500 to-blue-500 animate-gradient-x text-white mt-4 rounded-lg shadow-lg p-8 max-w-xl mx-auto font-[sans-serif]">
    <h2 class="text-2xl font-bold text-center">
      We're constantly evolving and innovating
    </h2>
    <marquee class="mt-4 text-base font-italic" behavior="scroll" direction="left" scrollamount="3">
      Always pushing boundaries, never settling, always creating the future.
    </marquee>
  </div>

  <!-- featurs -->

  <div class="bg-gray-50 px-4 py-12 font-[sans-serif]">
    <div class="max-w-6xl mx-auto">
      <h2 class="text-gray-800 sm:text-4xl text-2xl font-extrabold text-left mb-12">Our Features</h2>
      <div class="grid lg:grid-cols-3 md:grid-cols-2 max-md:max-w-lg mx-auto gap-8">
        <div class="p-6 bg-white rounded-lg text-left shadow">
          <h3 class="text-gray-800 text-xl font-bold mb-4">Customization</h3>
          <p class="text-gray-500 text-sm">Qui elit labore in nisi dolore tempor anim laboris ipsum ad ad consequat id. Dolore et sint mollit in nisi tempor culpa consectetur.</p>
          <button class="text-sm bg-transparent px-4 py-2 border border-blue-500 text-blue-500 mt-8 rounded-lg">Read More</button>
        </div>

        <div class="p-6 bg-blue-500 rounded-lg text-left shadow text-white">
          <h3 class="text-white text-xl font-bold mb-4">Security</h3>
          <p class="text-sm text-white">Qui elit labore in nisi dolore tempor anim laboris ipsum ad ad consequat id. Dolore et sint mollit in nisi tempor culpa consectetur.</p>
          <button class="text-sm bg-transparent px-4 py-2 border border-white text-white mt-6 rounded-lg">Read More</button>
        </div>

        <div class="p-6 bg-white rounded-lg text-left shadow">
          <h3 class="text-gray-800 text-xl font-bold mb-4">Support</h3>
          <p class="text-gray-500 text-sm">Qui elit labore in nisi dolore tempor anim laboris ipsum ad ad consequat id. Dolore et sint mollit in nisi tempor culpa consectetur.</p>
          <button class="text-sm bg-transparent px-4 py-2 border border-blue-500 text-blue-500 mt-8 rounded-lg">Read More</button>
        </div>
      </div>
    </div>
  </div>
  <!-- news letter -->

  <div class="bg-[#2e0249] py-16 px-6 font-[sans-serif]">
    <div class="max-w-5xl mx-auto text-center">
      <h2 class="text-5xl font-bold mb-6 text-white">Subscribe to Our Newsletter</h2>
      <p class="text-base text-gray-300">Stay updated with the latest news, trends, and special offers. Don't miss out on our exciting updates.</p>
      <div class="mt-12 flex items-center overflow-hidden bg-gray-50 rounded-md max-w-xl mx-auto">
        <input type="email" placeholder="Enter your email" class="w-full bg-transparent py-3.5 px-4 text-gray-800 text-base focus:outline-none" />
        <button class="bg-[#a91079] hover:bg-[#a91079e2] text-white text-base tracking-wide py-3.5 px-6 hover:shadow-md hover:transition-transform transition-transform hover:scale-105 focus:outline-none">
          Subscribe
        </button>
      </div>
    </div>
  </div>
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

