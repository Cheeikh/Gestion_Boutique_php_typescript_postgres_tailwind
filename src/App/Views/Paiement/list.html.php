
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Détails de la dette</h1>
    
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <p><strong>Montant :</strong> <?= $dette->montant ?> €</p>
        <p><strong>État :</strong> <?= $dette->etat ?></p>
        <p><strong>Date :</strong> <?= $dette->date ?></p>
    </div>



    <a href="/paiement/add/<?= $dette->id ?>" class="bg-green-600 mb-4 text-white font-medium py-2 px-4 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Enregistrer un Paiement</a>


    <h2 class="text-xl font-bold mb-4">Paiements associés</h2>

    <?php if (empty($paiements)): ?>
        <p>Aucun paiement enregistré pour cette dette.</p>
    <?php else: ?>
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php foreach ($paiements as $paiement): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $paiement['montant'] ?> €</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $paiement['date'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>