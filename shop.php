<?php
session_start();

// verif user logat
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";


$items = $conn->query("SELECT * FROM items ORDER BY created_at DESC");

if (!$items) {
    die("Eroare la preluarea itemelor: " . $conn->error);
}

// numar produse cos
$user_id = $_SESSION['id'];
$cart_item_count = getCartItemCount($user_id, $conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magazin Online</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
            <div class="flex space-x-7">
                    <a href="shop.php" class="flex items-center py-4">
                        <img src="uploads/logo.png" alt="Logo" class="h-32 w-32 mr-2">
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="cart.php" class="py-2 px-2 font-medium text-gray-500 hover:text-gray-900">Cos</a>
                    <a href="shop.php" class="py-2 px-2 font-medium text-gray-500 hover:text-gray-900">Magazin</a>
                    <a href="contact.php" class="py-2 px-2 font-medium text-gray-500 hover:text-gray-900">Contact</a>
                    <a href="add_product.php" class="py-2 px-2 font-medium text-green-500 hover:text-green-700">Adauga Produs</a>
                    <a href="logout.php" class="py-2 px-2 font-medium text-red-500 hover:text-red-700">Deconecteaza-te</a>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="container mx-auto mt-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php if ($items->num_rows > 0): ?>
                <?php while($item = $items->fetch_assoc()): ?>
                    <div class="border p-4 rounded">
                        <?php
                        $images = explode(',', $item['image_urls']);
                        $cover_image = htmlspecialchars($item['cover_image']);
                        ?>
                        <img src="<?php echo $cover_image; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="h-64 w-full object-contain mb-4">
                        <div class="flex space-x-2">
                            <?php foreach ($images as $image): ?>
                                <?php if ($image !== $cover_image): ?>
                                    <a href="<?php echo htmlspecialchars($image); ?>" target="_blank">
                                        <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="h-16 w-16 object-contain">
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800 mt-4"><?php echo htmlspecialchars($item['name']); ?></h2>
                        <p class="text-gray-600"><?php echo htmlspecialchars($item['description']); ?></p>
                        <p class="text-gray-800 font-bold">$<?php echo htmlspecialchars($item['price']); ?></p>
                        <a href="add_to_cart.php?id=<?php echo htmlspecialchars($item['id']); ?>" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">Adauga in cos</a>
                        <a href="delete_product.php?id=<?php echo htmlspecialchars($item['id']); ?>" class="mt-4 inline-block bg-red-500 text-white px-4 py-2 rounded">Sterge produs</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-gray-600">Nici un produs disponibil.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>