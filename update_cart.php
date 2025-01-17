<?php
session_start();
require_once "config.php";
header('Content-Type: application/json');

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    die(json_encode(['error' => 'Nu esti logat!']));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cart_id']) && isset($_POST['action'])) {
    $cart_id = $_POST['cart_id'];
    $action = $_POST['action'];
    $user_id = $_SESSION['id'];

    // get cantitate item
    $check_sql = "SELECT quantity FROM cart WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $quantity = $row['quantity'];

        if ($action === 'increase') {
            $quantity++;
        } else if ($action === 'decrease' && $quantity > 1) {
            $quantity--;
        }

        $update_sql = "UPDATE cart SET quantity = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ii", $quantity, $cart_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Update esuat']);
        }
    } else {
        echo json_encode(['error' => 'Item invalid']);
    }
} else {
    echo json_encode(['error' => 'Request invalid']);
}
?>