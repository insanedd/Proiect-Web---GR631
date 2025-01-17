<?php
session_start();

// verif user logat
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $message = "Multumim pentru mesaj. Revenim cu un raspuns in maxim 24 ore!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacteaza-ne</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
            <div class="flex space-x-7">
                    <a href="#" class="flex items-center py-4">
                        <img src="uploads/logo.png" alt="Logo" class="h-32 w-32 mr-2">
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="shop.php" class="py-2 px-2 font-medium text-gray-500 hover:text-gray-900">Magazin</a>
                    <a href="logout.php" class="py-2 px-2 font-medium text-red-500 hover:text-red-700">Deconecteaza-te</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-5xl mx-auto">
            <!-- header contact -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Ia legatura cu noi</h1>
                <p class="text-gray-600">Ne-ar face plăcere să auzim de la dumneavoastră. Vă rugăm să completați acest formular sau să folosiți informațiile noastre de contact de mai jos.</p>
            </div>

           
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- formular contact -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <?php if($message): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nume complet</label>
                            <input type="text" id="name" name="name" required
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Adresa email</label>
                            <input type="email" id="email" name="email" required
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="subject">Subiect</label>
                            <select id="subject" name="subject" required
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Alege un subiect</option>
                                <option value="general">Întrebare Generală</option>
<option value="support">Suport Produs</option>
<option value="feedback">Feedback</option>
<option value="billing">Întrebare Facturare</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="message">Mesaj</label>
                            <textarea id="message" name="message" rows="4" required
                                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                        </div>

                        <button type="submit" 
                                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Trimite mesaj
                        </button>
                    </form>
                </div>

               
                <div class="space-y-6">
                        <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Program</h2>
                        <div class="space-y-2 text-gray-600">
                        <p>Luni - Vineri: 9:00 - 18:00</p>
<p>Sâmbătă: 10:00 - 16:00</p>
<p>Duminică: Închis</p>
                        </div>
                    </div>

                        <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Informatii contact</h2>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="text-blue-500 mr-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Telefon</p>
                                    <p class="text-gray-600">+40 (725) 333-3333</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="text-blue-500 mr-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Email</p>
                                    <p class="text-gray-600">contact@danny.com</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="text-blue-500 mr-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Locatie</p>
                                    <p class="text-gray-600">Calea Victoriei 32</p>
                                    <p class="text-gray-600">Bucuresti, Romania</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- social media -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Urmareste-ne</h2>
                        <div class="flex space-x-4">
                            <a href="#" class="text-blue-500 hover:text-blue-600">
                                <span class="sr-only">Facebook</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.77,7.46H14.5V5.9a.9.9,0,0,1,.94-.85h3.03V.47L14.61.46a4.78,4.78,0,0,0-4.97,5V7.46H6.74v4.78h2.9v12.3h4.86V12.24h4.1l.58-4.78Z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-blue-400 hover:text-blue-500">
                                <span class="sr-only">Twitter</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161c-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63.961-.689 1.8-1.56 2.46-2.548l-.047-.02z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-pink-500 hover:text-pink-600">
                                <span class="sr-only">Instagram</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.897 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.897-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844-.061-3.204 0-3.584.016-4.849.071-1.171.055-1.806.249-2.228.415-.562.217-.96.477-1.382.896-.419.42-.679.819-.896 1.381-.164.422-.36 1.057-.413 2.227-.057 1.266-.07 1.646-.07 4.85s.015 3.585.074 4.85c.061 1.17.256 1.805.421 2.227.224.562.479.96.897 1.382.419.419.824.679 1.38.896.42.164 1.065.36 2.235.413 1.274.057 1.649.07 4.859.07 3.211 0 3.586-.015 4.859-.074 1.171-.061 1.816-.256 2.236-.421.569-.224.96-.479 1.379-.897.421-.419.69-.824.9-1.38.165-.42.359-1.065.42-2.235.045-1.26.061-1.649.061-4.844 0-3.196-.016-3.586-.061-4.851-.061-1.17-.256-1.805-.42-2.227-.24-.563-.48-.96-.899-1.379-.419-.419-.824-.679-1.38-.896-.42-.164-1.065-.36-2.235-.413-1.275-.057-1.65-.07-4.859-.07zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-blue-700 hover:text-blue-800">
                                <span class="sr-only">LinkedIn</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- info -->
            <div class="mt-12">
               <h2 class="text-2xl font-bold text-gray-800 mb-6">Întrebări Frecvente</h2>
               <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                   <div class="bg-white rounded-lg shadow-md p-6">
                       <h3 class="font-bold text-gray-800 mb-2">Care sunt taxele de livrare?</h3>
                       <p class="text-gray-600">Oferim livrare gratuită pentru comenzile de peste 250 RON. Pentru comenzile sub 250 RON, taxele de livrare încep de la 29.99 RON.</p>
                   </div>
                   <div class="bg-white rounded-lg shadow-md p-6">
                       <h3 class="font-bold text-gray-800 mb-2">Care este politica de retur?</h3>
                       <p class="text-gray-600">Acceptăm retururi în termen de 30 de zile de la achiziție. Produsele trebuie să fie nefolosite și în ambalajul original.</p>
                   </div>
                   <div class="bg-white rounded-lg shadow-md p-6">
                       <h3 class="font-bold text-gray-800 mb-2">Livrați și în străinătate?</h3>
                       <p class="text-gray-600">Da, livrăm în majoritatea țărilor din lume. Taxele de livrare internațională variază în funcție de locație.</p>
                   </div>
                   <div class="bg-white rounded-lg shadow-md p-6">
                       <h3 class="font-bold text-gray-800 mb-2">Cum îmi pot urmări comanda?</h3>
                       <p class="text-gray-600">După ce comanda dvs. este expediată, veți primi un număr de urmărire prin email pentru a monitoriza livrarea.</p>
                   </div>
               </div>
           </div>
        </div>
    </div>

    <!-- footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center text-gray-400 text-sm">
                © 2025 Magazin Online. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>