<?php
session_start();

// verif user logat
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";

// Create uploads directory if it doesn't exist
if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);
    $price = trim($_POST["price"]);
    $image_urls = [];

    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $file_name = basename($_FILES['images']['name'][$key]);
        $target_file = "uploads/" . $file_name;
        if (move_uploaded_file($tmp_name, $target_file)) {
            $image_urls[] = $target_file;
        }
    }

    $image_urls_str = implode(',', $image_urls);
    $cover_image = $_POST['cover_image'];

    // pregatire inserare item
    $sql = "INSERT INTO items (name, description, price, image_urls, cover_image) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssdss", $name, $description, $price, $image_urls_str, $cover_image);

        if ($stmt->execute()) {
            echo "Produs adaugat.";
        } else {
            echo "Eroare: Nu se poate executa interogarea: $sql. " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Eroare: Nu se poate pregati interogarea: $sql. " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
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
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Adauga produse</h1>
        <form action="add_product.php" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="name" class="block text-black font-bold">Nume produs</label>
                <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label for="name" class="block text-black font-bold">Descriere</label>
                <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label for="name" class="block text-black font-bold">Nume produs</label>
                <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label for="images" class="block text-black font-bold">Imagini produs</label>
                <input type="file" name="images[]" id="images" class="w-full px-3 py-2 border rounded" multiple required>
            </div>
            <div class="mb-4" id="cover-image-selection" style="display: none;">
                <label for="cover_image" class="block text-black font-bold">Imagine de coperta</label>
                <select name="cover_image" id="cover_image" class="w-full px-3 py-2 border rounded">
                    <!-- Options will be populated by JavaScript -->
                </select>
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Adauga produs</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('images').addEventListener('change', function() {
            var imageSelect = document.getElementById('cover_image');
            var coverImageSelection = document.getElementById('cover-image-selection');
            imageSelect.innerHTML = '';
            if (this.files.length > 1) {
                coverImageSelection.style.display = 'block';
                for (var i = 0; i < this.files.length; i++) {
                    var option = document.createElement('option');
                    option.value = 'uploads/' + this.files[i].name;
                    option.text = this.files[i].name;
                    imageSelect.appendChild(option);
                }
            } else {
                coverImageSelection.style.display = 'none';
            }
        });
    </script>
</body>
</html>