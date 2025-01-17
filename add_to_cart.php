<?php
session_start();

// verif user logat
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";

if (isset($_GET['id'])) {
    $item_id = intval($_GET['id']);
    $user_id = $_SESSION['id']; 

    // verif item deja in cos
    $sql = "SELECT * FROM cart WHERE user_id = ? AND item_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $user_id, $item_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // item deja in cos, actualizare cantitate
            $sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND item_id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ii", $user_id, $item_id);
                if ($stmt->execute()) {
                    echo "Cantitate actualizata!.";
                } else {
                    echo "Eroare actualizare cantitate: " . $stmt->error;
                }
            } else {
                echo "Eroare declaratie de actualizare: " . $conn->error;
            }
        } else {
            // item neexistent in cos, adaugare
            $sql = "INSERT INTO cart (user_id, item_id, quantity) VALUES (?, ?, 1)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ii", $user_id, $item_id);
                if ($stmt->execute()) {
                    echo "Item adaugat in cos.";
                } else {
                    echo "Eroare adaugare item in cos: " . $stmt->error;
                }
            } else {
                echo "Eroare declaratie de adaugare item: " . $conn->error;
            }
        }

        $stmt->close();
    } else {
        echo "Eroare declaratie de selectare item: " . $conn->error;
    }
} else {
    echo "ID item nu este setat.";
}

// redirect homepage
header("location: shop.php");
exit;
?>