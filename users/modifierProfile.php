<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Modification de Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Modifier le Profil</h2>

        <form action="#" method="POST" class="space-y-4">

            <!-- Champ Nom Complet -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nom Complet</label>
                <input type="text" id="name" name="name" placeholder="Votre nom complet"
                    class="mt-1 block w-full px-4 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Champ Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Adresse Email</label>
                <input type="email" id="email" name="email" placeholder="exemple@domaine.com"
                    class="mt-1 block w-full px-4 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Champ Numéro de Téléphone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Numéro de Téléphone</label>
                <input type="tel" id="phone" name="phone" placeholder="Votre numéro de téléphone"
                    class="mt-1 block w-full px-4 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Champ Mot de Passe -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de Passe</label>
                <input type="password" id="password" name="password" placeholder="••••••••"
                    class="mt-1 block w-full px-4 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Bouton Soumettre -->
            <div>
                <button type="submit"
                    class="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition duration-300">
                    Enregistrer les Modifications
                </button>
            </div>
        </form>
    </div>

</body>
</html>
