<?php
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // creare conexiune 
    $conn = new mysqli($host, $username, $password);
    
    if ($conn->connect_error) {
        die("Conexiune esuata: " . $conn->connect_error);
    }

    // creare baza
    $sql = "CREATE DATABASE IF NOT EXISTS danny";
    if ($conn->query($sql) === TRUE) {
        echo "Baza de date creata sau exista deja!<br>";
    } else {
        echo "Eroare creare baza de date: " . $conn->error . "<br>";
    }

    // selectare baza
    $conn->select_db("danny");

    // tabel useri daca nu exista
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        email VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Tabel useri creat sau exista deja!<br>";
    } else {
        echo "Eroare creare tabel useri: " . $conn->error . "<br>";
    }

    // tabel iteme daca nu exista
    $sql = "CREATE TABLE IF NOT EXISTS items (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        image_url VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Tabel iteme creat sau exista deja<br>";
    } else {
        echo "Eroare creare tabel iteme: " . $conn->error . "<br>";
    }

    // tabel cos daca nu exista
    $sql = "CREATE TABLE IF NOT EXISTS cart (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        item_id INT NOT NULL,
        quantity INT NOT NULL DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (item_id) REFERENCES items(id)
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Tabel cos creat sau exista deja<br>";
    } else {
        echo "Eroare creare tabel cos: " . $conn->error . "<br>";
    }

    // inserare iteme
    $check_items = "SELECT COUNT(*) as count FROM items";
    $result = $conn->query($check_items);
    $row = $result->fetch_assoc();

    if ($row['count'] == 0) {
        $sample_items = [
            ['Gaming Laptop', 'High-performance gaming laptop with RTX 3080', 1999.99, 'laptop.jpg'],
            ['Smartphone', 'Latest model with 5G capability', 999.99, 'phone.jpg'],
            ['Wireless Earbuds', 'Premium sound quality with noise cancellation', 199.99, 'earbuds.jpg'],
            ['Smart Watch', 'Fitness tracking and notifications', 299.99, 'watch.jpg'],
            ['Tablet', '10.9-inch Retina display', 599.99, 'tablet.jpg']
        ];

        $insert_sql = "INSERT INTO items (name, description, price, image_url) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        
        foreach ($sample_items as $item) {
            $stmt->bind_param("ssds", $item[0], $item[1], $item[2], $item[3]);
            $stmt->execute();
        }
        echo "Iteme inserate cu succes<br>";
    }

    $conn->close();
    echo "Setup complet";

} catch (Exception $e) {
    echo "Eroare: " . $e->getMessage();
}
?>