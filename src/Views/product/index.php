<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../public/css/tailwind.css" rel="stylesheet">
    <title>Liste des Utilisateurs</title>
</head>
<body>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold">Liste des Utilisateurs</h1>
        <ul>
            <?php foreach($users as $user): ?>
                <li><?php echo htmlspecialchars($user['nom'] . ' ' . $user['prenom']); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
