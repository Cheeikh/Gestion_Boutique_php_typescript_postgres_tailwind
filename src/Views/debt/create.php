<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Enregistrer une Dette</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <h1>Enregistrer une Dette</h1>
    <form action="/debt/store" method="POST">
        <label for="client_id">Client :</label>
        <select name="client_id" id="client_id" required>
            <?php foreach ($clients as $client): ?>
                <option value="<?php echo $client['id']; ?>"><?php echo htmlspecialchars($client['nom'] . ' ' . $client['prenom']); ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="montant">Montant :</label>
        <input type="number" name="montant" id="montant" required step="0.01"><br><br>

        <label for="articles">Articles :</label>
        <input type="text" name="articles" id="articles" required><br><br>

        <label for="quantites">Quantités :</label>
        <input type="number" name="quantites" id="quantites" required><br><br>

        <label for="montant_verse">Montant Versé :</label>
        <input type="number" name="montant_verse" id="montant_verse" required step="0.01"><br><br>

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
