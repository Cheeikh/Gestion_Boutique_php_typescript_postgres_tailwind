<!-- src/Views/debt/index.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Dettes</title>
    <link rel="stylesheet" href="/css/tailwind.css">
</head>
<body>
    <h1>Liste des Dettes</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client ID</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Etat</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['id_client']); ?></td>
                    <td><?php echo htmlspecialchars($row['montant']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['etat']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
