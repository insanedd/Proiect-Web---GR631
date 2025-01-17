<?php
session_start();

// verif user logat
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // sterge din tabel cos
    $stmt = $conn->prepare("DELETE FROM cart WHERE item_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // delete item
    $sql = "DELETE FROM items WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Produs sters cu succes.";
        } else {
            echo "Eroare: Nu se poate executa: $sql. " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Nu se poate pregati interogarea: $sql. " . $conn->error;
    }

    $conn->close();
    header("location: shop.php");
    exit;
} else {
    echo "Invalid product ID.";
}
?>