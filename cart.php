<?php
session_start();
require_once "config.php";

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// get iteme
$user_id = $_SESSION['id'];
$sql = "SELECT c.id as cart_id, c.quantity, i.* 
        FROM cart c 
        JOIN items i ON c.item_id = i.id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_items = $stmt->get_result();

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cos Produse - Online Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body class="bg-gray-100">
    <!-- bara navigare -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
            <div class="flex space-x-7">
                    <a href="#" class="flex items-center py-4">
                        <img src="uploads/logo.png" alt="Logo" class="h-32 w-32 mr-2">
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="cart.php" class="py-2 px-2 font-medium text-gray-500 hover:text-gray-900">
                        Cos
                        <?php if($cart_items && $cart_items->num_rows > 0): ?>
                        <span class="absolute mb-
                         inline-flex items-center justify-center px-2 py-1 text-xs rounded-full bg-red-600 font-bold leading-none text-red-100">
                        <?php echo $cart_items->num_rows; ?>
                        </span>
                        <?php endif; ?>
                    </a>
                    <a href="shop.php" class="py-2 px-2 font-medium text-gray-500 hover:text-gray-900">Magazin</a>
                    <a href="contact.php" class="py-2 px-2 font-medium text-gray-500 hover:text-gray-900">Contact</a>
                    <a href="logout.php" class="py-2 px-2 font-medium text-red-500 hover:text-red-700">Deconecteaza-te</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Cosul tau</h1>

        <div class="cart-container">
            <?php if ($cart_items->num_rows > 0): ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex flex-col">
                        <?php while($item = $cart_items->fetch_assoc()): 
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                        <div class="cart-item flex items-center py-5 border-b">
                            <div class="flex-shrink-0 w-24 h-24">
                                <img src="<?php echo htmlspecialchars($item['cover_image']); ?>" 
                                     alt="<?php echo htmlspecialchars($item['name']); ?>"
                                     class="w-full h-full object-cover rounded">
                            </div>
                            <div class="ml-4 flex-1">
                                <h2 class="text-lg font-bold text-gray-800"><?php echo htmlspecialchars($item['name']); ?></h2>
                                <p class="text-gray-600"><?php echo htmlspecialchars($item['description']); ?></p>
                                <div class="mt-2 flex items-center">
                                    <span class="text-gray-800">$<?php echo number_format($item['price'], 2); ?> × <span class="quantity-display"><?php echo $item['quantity']; ?></span></span>
                                    <span class="ml-auto font-bold subtotal-display">$<?php echo number_format($subtotal, 2); ?></span>
                                </div>
                                <div class="mt-2 flex items-center">
                                    <button class="update-quantity bg-gray-200 px-2 py-1 rounded" 
                                            data-cart-id="<?php echo $item['cart_id']; ?>" 
                                            data-action="decrease">-</button>
                                    <span class="mx-2"><?php echo $item['quantity']; ?></span>
                                    <button class="update-quantity bg-gray-200 px-2 py-1 rounded" 
                                            data-cart-id="<?php echo $item['cart_id']; ?>" 
                                            data-action="increase">+</button>
                                    <button class="remove-item ml-4 text-red-500 hover:text-red-700" 
                                            data-cart-id="<?php echo $item['cart_id']; ?>">Sterge</button>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <div class="mt-6 border-t pt-6">
                        <div class="flex justify-between text-xl font-bold">
                            <span>Total:</span>
                            <span class="cart-total">$<?php echo number_format($total, 2); ?></span>
                        </div>
                        <button class="mt-6 w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                            Finalizeaza comanda
                        </button>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <p class="text-gray-600">Cosul tau este gol</p>
                    <a href="shop.php" class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        Continua cumparaturile
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // actualizare cantitate
        $('.update-quantity').click(function() {
            const cartId = $(this).data('cart-id');
            const action = $(this).data('action');
            const itemContainer = $(this).closest('.cart-item');
            
            $.post('update_cart.php', {
                cart_id: cartId,
                action: action
            }, function(response) {
                if (response.success) {
                    location.reload();
                }
            }, 'json');
        });

        // stergere item
        $('.remove-item').click(function() {
            const cartId = $(this).data('cart-id');
            const itemContainer = $(this).closest('.cart-item');
            
            $.post('remove_from_cart.php', {
                cart_id: cartId
            }, function(response) {
                if (response.success) {
                    location.reload();
                }
            }, 'json');
        });
    });
    </script>
</body>
</html>