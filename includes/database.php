<?php
// Ladataan ympäristömuuttujat
if (file_exists('.env')) {
    foreach (parse_ini_file('.env') as $key => $value) {
        $_ENV[$key] = $value;
    }
}

// Muodostetaan yhteys
$conn = new mysqli(
    $_ENV['DB_HOST'],
    $_ENV['DB_USERNAME'],
    $_ENV['DB_PASSWORD'],
    $_ENV['DB_NAME']
);

// Tarkistetaan yhteys
if ($conn->connect_error) {
    // Tuotantoympäristössä näytetään geneerinen virhe
    if ($_ENV['APP_ENV'] === 'production') {
        error_log("Database connection failed: " . $conn->connect_error);
        die("Database connection error. Please try again later.");
    } else {
        // Kehitysympäristössä näytetään tarkempi virhe
        die("Connection failed: " . $conn->connect_error);
    }
}

// Asetetaan merkistökoodaus
$conn->set_charset("utf8mb4");

// Funktio turvalliseen kyselyyn
function db_query($conn, $sql, $params = []) {
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("SQL prepare error: " . $conn->error);
    }
    
    if (!empty($params)) {
        $types = str_repeat('s', count($params)); // Kaikki parametrit käsitellään stringeinä
        $stmt->bind_param($types, ...$params);
    }
    
    if (!$stmt->execute()) {
        throw new Exception("SQL execute error: " . $stmt->error);
    }
    
    return $stmt;
}

// Esimerkki käytöstä:

?>