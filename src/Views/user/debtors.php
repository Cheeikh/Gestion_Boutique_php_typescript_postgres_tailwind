<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des clients débiteurs</title>
</head>
<body>
    <h1>Liste des clients débiteurs</h1>
    <ul>
        <?php foreach ($debtors as $debtor): ?>
            <li>
                <?php echo htmlspecialchars($debtor['nom'] . ' ' . $debtor['prenom']); ?> - 
                Total dû : <?php echo htmlspecialchars($debtor['total_du']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
