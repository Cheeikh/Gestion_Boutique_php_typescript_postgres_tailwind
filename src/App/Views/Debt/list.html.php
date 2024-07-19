<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-indigo-600">
            <h1 class="text-3xl font-bold text-white">Détails du client</h1>
        </div>
        <div class="p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4"><?= $client['prenom'] ?> <?= $client['nom'] ?></h2>

            <div class="mb-4">
                <p class="text-lg font-medium text-gray-700">Total des dettes impayées : <?= number_format($dettes['total_dette_impaye'], 2) ?> Franc CFA</p>
                <p class="text-lg font-medium text-gray-700">Total des montants versés : <?= number_format($dettes['total_montant_verse'], 2) ?> Franc CFA</p>
            </div>

            <!-- Filtre -->
            <div class="mb-4">
                <label for="etatFiltre" class="block text-sm font-medium text-gray-700">Filtrer par état :</label>
                <select id="etatFiltre" name="etatFiltre" onchange="this.form.submit()" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="impaye" <?= $etatFiltre === 'impaye' ? 'selected' : '' ?>>Impayé</option>
                    <option value="paye" <?= $etatFiltre === 'paye' ? 'selected' : '' ?>>Payé</option>
                </select>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant restant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant versé</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">État</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($dettes['dettes'] as $dette) : ?>
                            <tr data-debt-id="<?= $dette->id ?>">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $dette->montant ?> Franc CFA</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= number_format(floatval($dette->montant) - floatval($dette->montant_verser), 2) ?> Franc CFA</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $dette->montant_verser ?> Franc CFA</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $dette->etat === 'impaye' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' ?>">
                                        <?= ucfirst($dette->etat) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $dette->date ?></td>
                                <td class="px-6 py-4 text-right">
                                    <a href="/paiments/<?= $dette->id ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Paiment</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="mt-6 flex justify-between">
                <?php if ($page > 1) : ?>
                    <a href="?id=<?= $client['id'] ?>&etat=<?= $etatFiltre ?>&page=<?= $page - 1 ?>" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Précédent</a>
                <?php endif; ?>

                <span class="text-sm text-gray-700">Page <?= $page ?> sur <?= $totalPages ?></span>

                <?php if ($page < $totalPages) : ?>
                    <a href="?id=<?= $client['id'] ?>&etat=<?= $etatFiltre ?>&page=<?= $page + 1 ?>" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Suivant</a>
                <?php endif; ?>
            </div>
        </div>


    </div>
</div>

<!-- Popup pour afficher les détails de la dette -->
<div id="debtDetailsPopup" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Détails de la dette</h3>
                        <div class="mt-2" id="debtDetailsContent">
                            <!-- Les détails de la dette seront insérés ici -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button id="closePopup" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>



<script>
    document.getElementById('etatFiltre').addEventListener('change', function() {
        window.location.href = '?id=<?= $client['id'] ?>&etat=' + this.value;
    });
</script>

<!-- Inclure ce script dans votre vue detail.php -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const debtRows = document.querySelectorAll('tr[data-debt-id]');

        debtRows.forEach(row => {
            row.addEventListener('click', function() {
                const debtId = row.getAttribute('data-debt-id');
                fetch(`/dettes/details/${debtId}`)
                    .then(response => response.text())
                    .then(data => {
                        const popupContent = data;
                        const debtDetailsPopup = document.getElementById('debtDetailsPopup');
                        const debtDetailsContent = document.getElementById('debtDetailsContent');
                        
                        debtDetailsContent.innerHTML = popupContent;
                        debtDetailsPopup.classList.remove('hidden');
                    })
                    .catch(error => console.error('Erreur:', error));
            });
        });

        // Fermer le popup
        const closeBtn = document.getElementById('closePopup');
        closeBtn.addEventListener('click', function() {
            const popup = document.getElementById('debtDetailsPopup');
            popup.classList.add('hidden');
        });
    });
</script>
