<?php

use App\Session\Session; ?>

<div class="p-4 max-w-3xl mx-auto">
<?php if (Session::hasFlash()) : ?>
  <?php $flash = Session::getFlash(); ?>
  <div class="mb-4 p-4 rounded-lg <?= $flash['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
    <?= $flash['message'] ?>
  </div>
<?php endif; ?>

  <form action="/debt/create" method="post">
    <div class="bg-blue-600 text-primary-foreground text-center p-4 rounded-t-lg shadow-md">
      <h1 class="text-2xl font-bold">Enregistrer Une Nouvelle Dette</h1>
    </div>
    <div class="bg-card p-6 rounded-b-lg shadow-lg">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
          <label class="block text-muted-foreground mb-2">Tel :</label>
          <input type="text" placeholder="Tel" class="w-full p-3 border border-muted rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" name="searchNumber" value="<?= isset($client) ? $client->telephone : '' ?>">
        </div>
        <div>
          <label class="block text-muted-foreground mb-2">Client :</label>
          <input type="text" placeholder="Client" class="w-full p-3 border border-muted rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" readonly value="<?= isset($client) ? $client->nom : '' ?>">
        </div>
      </div>
      <div class="bg-muted p-6 rounded-lg mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
          <div class="md:col-span-2">
            <label class="block text-muted-foreground mb-2">Ref :</label>
            <input type="text" placeholder="Ref" class="w-full p-3 border border-muted rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" name="ref_produit" value="<?= isset($produit) ? $produit->id : '' ?>">
          </div>
          <div class="flex items-end">
            <button class="bg-blue-600 text-primary-foreground p-3 rounded-lg w-full md:w-auto" type="submit">Ok</button>
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
          <div>
            <label class="block text-muted-foreground mb-2">Libellé :</label>
            <input type="text" placeholder="Libellé" class="w-full p-3 border border-muted rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" value="<?= isset($produit) ? $produit->nom : '' ?>" readonly>
          </div>
          <div>
            <label class="block text-muted-foreground mb-2">Prix :</label>
            <input type="text" placeholder="Prix" class="w-full p-3 border border-muted rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" value="<?= isset($produit) ? $produit->prix : '' ?>" readonly>
          </div>
          <div>
            <label class="block text-muted-foreground mb-2">Quantité :</label>
            <div class="flex"> <input type="number" placeholder="quantité" class="w-full p-3 border border-muted rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" name="quantite" value="<?= isset($produit) ? $produit->quantite : '' ?>">
              <button class="bg-blue-600 text-primary-foreground p-3 rounded-lg ml-2">Ajouter</button>
            </div>
          </div>
          <div class="flex justify-between items-center mb-6">
          <div class="flex justify-between items-center mb-6">
    <button id="clearCartBtn" class="bg-red-500 text-white p-2 rounded-lg">Vider le panier</button>
    
</div>
    <div>
    </div>
</div>
        </div>
        <table class="w-full border-collapse border border-muted mb-6">
    <thead>
        <tr class="bg-blue-600 text-primary-foreground">
            <th class="border border-muted p-3">Article</th>
            <th class="border border-muted p-3">Prix</th>
            <th class="border border-muted p-3">Quantité</th>
            <th class="border border-muted p-3">Montant</th>
            <th class="border border-muted p-3">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($produits)) : ?>
            <?php foreach ($produits as $index => $produit) : ?>
                <tr>
                    <td class="border border-muted p-3"><?= $produit->nom ?></td>
                    <td class="border border-muted p-3"><?= $produit->prix ?></td>
                    <td class="border border-muted p-3"><?= $produit->quantite ?></td>
                    <td class="border border-muted p-3"><?= $produit->montant ?></td>
                    <td class="border border-muted p-3">
                        <form action="/debt/remove-product" method="post" class="inline">
                            <input type="hidden" name="product_index" value="<?= $index ?>">
                            <button type="submit" class="bg-red-500 text-white p-2 rounded-lg">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td class="border border-muted p-3" colspan="5">Aucune donnée disponible</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
        <div class="flex justify-end items-center mb-6">
          <span class="text-muted-foreground mr-2">Total :</span>
          <span class="border-b border-muted w-24"><?= $total_dette ?? 0 ?></span>
        </div>
        <div class="flex justify-end text-primary-foreground">
          <button class="bg-blue-600 p-3 rounded-lg" name="enregistrer_dette" type="submit">Enregistrer</button>
        </div>
  </form>
</div>
</form>
</div>
<script>
  // Fonction pour faire disparaître le message flash
  function fadeOutFlashMessage() {
    const flashMessage = document.getElementById('flashMessage');
    if (flashMessage) {
      setTimeout(() => {
        flashMessage.style.transition = 'opacity 0.5s ease';
        flashMessage.style.opacity = '0';
        setTimeout(() => {
          flashMessage.remove();
        }, 500);
      }, 3000); // Le message disparaîtra après 3 secondes
    }
  }

  // Appeler la fonction lorsque la page est chargée
  document.addEventListener('DOMContentLoaded', fadeOutFlashMessage);
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const clearCartBtn = document.getElementById('clearCartBtn');
    const productsTable = document.querySelector('table tbody');
    const totalDette = document.getElementById('totalDette');

    clearCartBtn.addEventListener('click', function() {
        fetch('/debt/clear-cart', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Vider le tableau des produits
                productsTable.innerHTML = '<tr><td colspan="5" class="border border-muted p-3">Aucune donnée disponible</td></tr>';
                
                // Mettre à jour le total
                totalDette.textContent = '0';

                // Afficher un message de succès
                showFlashMessage('success', 'Le panier a été vidé avec succès.');
            } else {
                showFlashMessage('error', 'Une erreur est survenue lors de la suppression du panier.');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showFlashMessage('error', 'Une erreur est survenue lors de la suppression du panier.');
        });
    });

    function showFlashMessage(type, message) {
        const flashDiv = document.createElement('div');
        flashDiv.className = `mb-4 p-4 rounded-lg ${type === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}`;
        flashDiv.textContent = message;
        document.querySelector('.p-4.max-w-3xl.mx-auto').prepend(flashDiv);
        setTimeout(() => flashDiv.remove(), 3000);
    }
});
</script>