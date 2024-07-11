<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-gray-800 text-white p-4">
        <h1 class="text-2xl">Gestion Boutique</h1>
    </header>
    <nav class="bg-gray-200 p-4">
        <ul class="flex space-x-4">
            <li><a href="/clients" class="text-blue-500">Clients</a></li>
            <li><a href="/clients/form" class="text-blue-500">Formulaire</a></li>
        </ul>
    </nav>
    <main class="p-4">
        <?php echo $content; ?>
    </main>
    <footer class="bg-gray-800 text-white p-4">
        &copy; 2024 Gestion Boutique
    </footer>
</body>
</html>
