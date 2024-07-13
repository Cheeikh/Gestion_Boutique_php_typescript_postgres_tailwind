
  <div class="container mx-auto max-w-2xl p-4">
    <h1 class="text-2xl font-bold text-center">Enregistrer une nouvelle dette</h1>

    <form class="mt-8">
      <div class="flex flex-col">
        <label for="client" class="block mb-2 text-gray-700">Client:</label>
        <input type="text" id="client" name="client" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div class="flex flex-col mt-4">
        <label for="tel" class="block mb-2 text-gray-700">Tel:</label>
        <input type="text" id="tel" name="tel" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div class="flex flex-col mt-4">
        <label for="ref" class="block mb-2 text-gray-700">Ref:</label>
        <input type="text" id="ref" name="ref" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div class="flex flex-col mt-4">
        <label for="libelle" class="block mb-2 text-gray-700">Libellé:</label>
        <input type="text" id="libelle" name="libelle" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div class="flex flex-row mt-4">
        <div class="flex flex-col w-1/3 mr-4">
          <label for="prix" class="block mb-2 text-gray-700">Prix:</label>
          <input type="number" id="prix" name="prix" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex flex-col w-1/3 mr-4">
          <label for="quantite" class="block mb-2 text-gray-700">Quantité:</label>
          <input type="number" id="quantite" name="quantite" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex flex-col w-1/3">
          <label for="montant" class="block mb-2 text-gray-700">Montant:</label>
          <input type="number" id="montant" name="montant" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" readonly>
        </div>
      </div>

      <div class="flex flex-row mt-4">
        <div class="flex flex-col w-1/3 mr-4">
          <label for="article" class="block mb-2 text-gray-700">Article:</label>
          <select id="article" name="article" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Sélectionnez un article</option>
            <option value="article1">Article 1</option>
            <option value="article2">Article 2</option>
            <option value="article3">Article 3</option>
          </select>
        </div>

        <div class="flex flex-col w-1/3 mr-4">
          <label for="date_echeance" class="block mb-2 text-gray-700">Date d'échéance:</label>
          <input type="date" id="date_echeance" name="date_echeance" class="
          <input type="date" id="date_echeance" name="date_echeance" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex flex-col w-1/3">
          <button type="submit" class="w-full py-2 px-4 bg-blue-500 text-white font-bold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400">Enregistrer</button>
        </div>
      </div>
    </form>
  </div>
