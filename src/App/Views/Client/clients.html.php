<!-- src/App/Views/Client/clients.html.php -->
<div class="min-h-screen bg-gray-100 p-8 flex items-center justify-center">
  <div class="w-full max-w-6xl bg-white rounded-xl shadow-lg overflow-hidden flex">
    <!-- Formulaire de gauche -->
    <div class="w-1/2 p-8 border-r border-gray-200">
      <h2 class="text-2xl font-bold mb-6 text-gray-800">Informations du client</h2>
      <form action="/clients/create" method="post" class="space-y-6" enctype="multipart/form-data">
        <div class="space-y-4">
          <div>
            <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
            <input type="text" id="nom" name="nom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="<?= isset($_POST['nom']) ? $_POST['nom'] : '' ?>">
            <?php if (isset($errors['nom'])): ?>
              <p class="text-red-600 text-sm mt-1"><?= $errors['nom'] ?></p>
            <?php endif; ?>
          </div>
          <div>
            <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
            <input type="text" id="prenom" name="prenom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="<?= isset($_POST['prenom']) ? $_POST['prenom'] : '' ?>">
            <?php if (isset($errors['prenom'])): ?>
              <p class="text-red-600 text-sm mt-1"><?= $errors['prenom'] ?></p>
            <?php endif; ?>
          </div>
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
            <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>">
            <?php if (isset($errors['email'])): ?>
              <p class="text-red-600 text-sm mt-1"><?= $errors['email'] ?></p>
            <?php endif; ?>
          </div>
          <div>
            <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
            <input type="tel" id="telephone" name="telephone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="<?= isset($_POST['telephone']) ? $_POST['telephone'] : '' ?>">
            <?php if (isset($errors['telephone'])): ?>
              <p class="text-red-600 text-sm mt-1"><?= $errors['telephone'] ?></p>
            <?php endif; ?>
          </div>
          <div>
            <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
            <div class="mt-1 flex items-center">
              <input type="file" id="photo" name="photo" class="w-full bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            </div>
          </div>
        </div>
        <div>
          <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Valider
          </button>
        </div>
      </form>
    </div>

    <!-- Formulaire de droite -->
    <div class="w-1/2 p-8 bg-gray-50">
      <h2 class="text-2xl font-bold mb-6 text-gray-800">Gestion des dettes</h2>
      <div class="mb-6">
        <label for="tel" class="block text-sm font-medium text-gray-700 mb-1">Téléphone du client</label>
        <div class="flex">
          <form action="/clients/show" method="post">
            <input type="tel" id="tel" name="searchNumber" class="block w-full rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" value="<?= isset($client->telephone) ? $client->telephone : '' ?>">
            <button class="bg-blue-600 text-white px-4 rounded-r-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" type="submit">OK</button>
          </form>
        </div>0603040506
      </div>

      <?php if (isset($client)): ?>
        <div class="bg-white p-4 rounded-md shadow mb-6">
          <div class="flex justify-between items-center mb-4">
            <span class="text-lg font-medium text-gray-700">Client</span>
            <div>
              <a href="/debt/add" class="bg-blue-600 text-white font-medium py-2 px-4 rounded mr-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Nouvelle dette</a>
              <a href="/debt/list/<?= $client ? $client->id : "aucun id selectionner" ?>" class="bg-green-600 text-white font-medium py-2 px-4 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Voir dette</a>
            </div>
          </div>

          <div class="flex items-start space-x-4">
            <div class="w-1/4 bg-gray-200 h-24 rounded">
              <img src="<?= '/upload/' . $client->photo ?>" alt="Client" class="w-full h-full object-cover rounded">
            </div>
            <div class="space-y-2 flex-1">
              <p><span class="font-medium">Nom :</span> <?= $client->nom ?></p>
              <p><span class="font-medium">Prénom :</span> <?= $client->prenom ?></p>
              <p><span class="font-medium">Email :</span> <?= $client->email ?></p>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <?php if (isset($dettes) && !empty($dettes)): ?>
    <div class="space-y-4">
        <p class="flex justify-between">
            <span class="font-medium">Total Dette :</span>
            <span id="totalDette" class="font-bold">
                <?= $totalMontantImpaye ?>
            </span>
        </p>
        <p class="flex justify-between">
            <span class="font-medium">Montant Versé :</span>
            <span id="montantVerse" class="font-bold text-green-600">
                <?= $totalMontantVerse ?>
            </span>
        </p>
        <p class="flex justify-between">
            <span class="font-medium">Montant Restant :</span>
            <span id="montantRestant" class="font-bold text-red-600">
                <?= $totalMontantImpaye - $totalMontantVerse ?>
            </span>
        </p>
    </div>
<?php endif; ?>

    </div>
  </div>
</div>
