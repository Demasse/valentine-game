<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Nombre de vues</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg text-center">
        <h1 class="text-3xl font-bold mb-4">📊 Nombre de vues sur la page Valentine</h1>
        <p class="text-2xl text-pink-600 font-semibold">{{ $views }}</p>
        <p class="mt-4 text-gray-600">Voici le compteur actuel de toutes les visites uniques.</p>
        <a href="/http://127.0.0.1:8000/" class="mt-6 inline-block bg-pink-500 text-white px-6 py-3 rounded hover:bg-pink-600">Voir la page</a>
    </div>
</body>
</html>
