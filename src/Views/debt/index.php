<!DOCTYPE html>
<html lang="fr">
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <link rel="shortcut icon" href="./assets/img/favicon.ico" />
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/creativetimofficial/tailwind-starter-kit/compiled-tailwind.min.css" />
    <title>Gestion Boutique</title>
</head>

<body class="text-blueGray-700 antialiased">
    <div id="root">
        <nav class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6">
            <div class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto">
                <button class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent" type="button" onclick="toggleNavbar('example-collapse-sidebar')">
                    <i class="fas fa-bars"></i></button>
                <a class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0" href="javascript:void(0)">
                    GESTION BOUTIQUE by csm
                </a>
                <ul class="md:hidden items-center flex flex-wrap list-none">
                    <li class="inline-block relative">
                        <a class="text-blueGray-500 block py-1 px-3" href="#pablo" onclick="openDropdown(event,'notification-dropdown')"><i class="fas fa-bell"></i></a>
                        <div class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg mt-1" style="min-width: 12rem;" id="notification-dropdown">
                            <a href="#pablo" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Action</a><a href="#pablo" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Another action</a><a href="#pablo" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Something else here</a>
                            <div class="h-0 my-2 border border-solid border-blueGray-100"></div>
                            <a href="#pablo" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Seprated link</a>
                        </div>
                    </li>
                    <li class="inline-block relative">
                        <a class="text-blueGray-500 block" href="#pablo" onclick="openDropdown(event,'user-responsive-dropdown')">
                            <div class="items-center flex">
                                <span class="w-12 h-12 text-sm text-white bg-blueGray-200 inline-flex items-center justify-center rounded-full"><img alt="..." class="w-full rounded-full align-middle border-none shadow-lg" src="./assets/img/team-1-800x800.jpg" /></span>
                            </div>
                        </a>
                        <div class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg mt-1" style="min-width: 12rem;" id="user-responsive-dropdown">
                            <a href="#pablo" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Action</a><a href="#pablo" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Another action</a><a href="#pablo" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Something else here</a>
                            <div class="h-0 my-2 border border-solid border-blueGray-100"></div>
                            <a href="#pablo" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Seprated link</a>
                        </div>
                    </li>
                </ul>
                <div class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded hidden" id="example-collapse-sidebar">
                    <div class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-blueGray-200">
                        <div class="flex flex-wrap">
                            <div class="w-6/12">
                                <a class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0" href="javascript:void(0)">
                                    Tailwind Starter Kit
                                </a>
                            </div>
                            <div class="w-6/12 flex justify-end">
                                <button type="button" class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent" onclick="toggleNavbar('example-collapse-sidebar')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <form class="mt-6 mb-4 md:hidden">
                        <div class="mb-3 pt-0">
                            <input type="text" placeholder="Search" class="border-0 px-3 py-2 h-12 border border-solid  border-blueGray-500 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-base leading-snug shadow-none outline-none focus:outline-none w-full font-normal" />
                        </div>
                    </form>
                    <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                        <li class="items-center">
                            <a class="text-blueGray-700 hover:text-blueGray-500 text-xs uppercase py-3 font-bold block" href="/"><i class="fas fa-tv opacity-75 mr-2 text-sm"></i>
                                Acceuil</a>
                        </li>
                        <li class="items-center">
                            <a class="text-pink-500 hover:text-pink-600 text-xs uppercase py-3 font-bold block" href="/debts"><i class="fas fa-newspaper text-blueGray-400 mr-2 text-sm"></i>
                                Dettes</a>
                        </li>

                    </ul>
                    <hr class="my-4 md:min-w-full" />


                </div>
            </div>
        </nav>
        <div class="relative md:ml-64 bg-blueGray-50">
            <nav class="absolute top-0 left-0 w-full z-10 bg-transparent md:flex-row md:flex-nowrap md:justify-start flex items-center p-4">
                <div class="w-full mx-autp items-center flex justify-between md:flex-nowrap flex-wrap md:px-10 px-4">
                    <a class="text-white text-sm uppercase hidden lg:inline-block font-semibold" href="./index.html">Dettes</a>
                    <form class="md:flex hidden flex-row flex-wrap items-center lg:ml-auto mr-3">
                        <div class="relative flex w-full flex-wrap items-stretch">
                            <span class="z-10 h-full leading-snug font-normal absolute text-center text-blueGray-300 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-3"><i class="fas fa-search"></i></span>
                            <input type="text" placeholder="Search here..." class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm shadow outline-none focus:outline-none focus:ring w-full pl-10" />
                        </div>
                    </form>
                    <ul class="flex-col md:flex-row list-none items-center hidden md:flex">
                        <a class="text-blueGray-500 block" href="#pablo" onclick="openDropdown(event,'user-dropdown')">
                            <div class="items-center flex">
                                <span class="w-12 h-12 text-sm text-white bg-blueGray-200 inline-flex items-center justify-center rounded-full"><img alt="..." class="w-full rounded-full align-middle border-none shadow-lg" src="./assets/img/team-1-800x800.jpg" /></span>
                            </div>
                        </a>
                        <div class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg mt-1" style="min-width: 12rem;" id="user-dropdown">
                            <a href="#pablo" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Se deconnecter</a>
                            <div class="h-0 my-2 border border-solid border-blueGray-100"></div>
                        </div>
                    </ul>
                </div>
            </nav>
            <!-- Header -->
            <div class="relative bg-pink-600 md:pt-32 pb-32 pt-12">

            </div>
            <div class="px-4 md:px-10 mx-auto w-full -m-24">

                <div class="flex flex-wrap mt-4">
                    <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4">
                        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                            <div class="rounded-t mb-0 px-4 py-3 border-0">
                                <div class="flex flex-wrap items-center">
                                    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                        <h3 class="font-semibold text-base text-blueGray-700">
                                            Listes des récentes dettes
                                        </h3>
                                    </div>
                                    <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-right">
                                        <button class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1" type="button" style="transition:all .15s ease">
                                            Voir tout
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="block w-full overflow-x-auto">
                                <!-- Projects table -->
                                <table class="items-center w-full bg-transparent border-collapse">
                                    <thead>
                                        <tr>
                                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                Client
                                            </th>
                                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                Vendeur
                                            </th>
                                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                Montant Dette
                                            </th>
                                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                Paiement Dette
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $debts->fetch(PDO::FETCH_ASSOC)) : ?>
                                            <tr>
                                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                    <?php echo htmlspecialchars($row['client_nom']) . ' ' . htmlspecialchars($row['client_prenom']); ?>
                                                </td>
                                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                    <?php echo htmlspecialchars($row['vendeur_nom']) . ' ' . htmlspecialchars($row['vendeur_prenom']); ?>
                                                </td>
                                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                    <?php echo htmlspecialchars($row['montant']); ?>
                                                </td>
                                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                    <i class="fas fa-arrow-up text-emerald-500 mr-4"></i>
                                                    46,53%
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="w-full xl:w-4/12 px-4">
                        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                            <div class="rounded-t mb-0 px-4 py-3 border-0">
                                <div class="flex flex-wrap items-center">
                                    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                        <h3 class="font-semibold text-base text-blueGray-700">
                                            Liste des débiteurs
                                        </h3>
                                    </div>
                                    <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-right">
                                        <button class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1" type="button" style="transition:all .15s ease">
                                            Voir tout
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="block w-full overflow-x-auto">
                                <!-- Projects table -->
                                <table class="items-center w-full bg-transparent border-collapse">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                Client
                                            </th>
                                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                Montant Dette
                                            </th>
                                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left" style="min-width:140px">
                                                Paiement Dette
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $debtors->fetch(PDO::FETCH_ASSOC)) : ?>
                                            <tr>
                                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                    <?php echo htmlspecialchars($row['client_nom'] ?? '') . ' ' . htmlspecialchars($row['client_prenom'] ?? ''); ?>
                                                </td>
                                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                    <?php echo htmlspecialchars($row['montant'] ?? ''); ?>
                                                </td>
                                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                    <div class="flex items-center">
                                                        <span class="mr-2">30%</span>
                                                        <div class="relative w-full">
                                                            <div class="overflow-hidden h-2 text-xs flex rounded bg-orange-200">
                                                                <div style="width:30%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-emerald-500"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" charset="utf-8"></script>
    <script src="https://unpkg.com/@popperjs/core@2.9.1/dist/umd/popper.min.js" charset="utf-8"></script>
</body>

</html>

</html>