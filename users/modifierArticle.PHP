<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier une Publication</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <!-- Card de Formulaire -->
  <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Modifier la Publication</h2>

    <!-- Formulaire -->
    <form action="#" method="POST" class="space-y-6">
      
      <!-- Champ Titre -->
      <div class="relative">
        <label for="title" class="text-[13px] bg-white text-gray-600 absolute px-2 top-[-10px] left-4">
          Titre
        </label>
        <input type="text" id="title" name="title" placeholder="Entrez le titre"
          class="w-full px-4 py-3 bg-white text-black border-2 border-gray-300 rounded focus:outline-none focus:border-blue-500 placeholder-gray-400">
      </div>

      <!-- Champ Contenu -->
      <div class="relative">
        <label for="content" class="text-[13px] bg-white text-gray-600 absolute px-2 top-[-10px] left-4">
          Contenu
        </label>
        <textarea id="content" name="content" placeholder="Entrez le contenu ici..." rows="6"
          class="w-full px-4 py-3 bg-white text-black border-2 border-gray-300 rounded focus:outline-none focus:border-blue-500 placeholder-gray-400">
        </textarea>
      </div>

      <!-- Bouton de Soumission -->
      <div class="flex justify-end">
        <button type="submit" 
          class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition duration-200">
          Modifier
        </button>
      </div>
    </form>
  </div>

</body>
</html>
