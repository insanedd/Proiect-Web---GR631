<?php
// config.php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'danny');

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($conn === false){
    die("EROARE: Nu se poate conecta la baza de date. " . mysqli_connect_error());
}

function getCartItemCount($user_id, $conn) {
    $sql = "SELECT SUM(quantity) as item_count FROM cart WHERE user_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['item_count'] ? $row['item_count'] : 0;
    } else {
        return 0;
    }
}

?>