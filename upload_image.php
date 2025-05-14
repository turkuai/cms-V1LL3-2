<?php
// Tämä kooditiedosto käsittelee kuvien latauksen

// Määritetään kansio kuville
$target_dir = "uploads/";

// Varmistetaan, että kansio on olemassa
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

header('Content-Type: application/json');

try {
    // Tarkistetaan, että tiedosto on ladattu
    if (!isset($_FILES['logo']) || $_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("File upload failed: " . $_FILES['logo']['error']);
    }

    // Tarkistetaan tiedostotyyppi
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
    $file_type = $_FILES['logo']['type'];
    
    if (!in_array($file_type, $allowed_types)) {
        throw new Exception("Invalid file type. Only JPEG, PNG, GIF and SVG are allowed.");
    }

    // Luodaan uniikki tiedostonimi
    $file_extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
    $filename = uniqid('logo_') . '.' . $file_extension;
    $target_file = $target_dir . $filename;

    // Siirretään tiedosto palvelimelle
    if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_file)) {
        // Tallennetaan logo-polku tietokantaan
        require_once 'includes/database.php';
        
        $logoPath = $target_file;
        db_query($conn, 
            "INSERT INTO sections (name, content) VALUES ('logo', ?) 
             ON DUPLICATE KEY UPDATE content = VALUES(content)",
            [$logoPath]
        );
        
        // Palautetaan onnistumisviesti
        echo json_encode([
            'status' => 'success',
            'filePath' => $logoPath
        ]);
    } else {
        throw new Exception("Error moving uploaded file.");
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
    error_log("File upload error: " . $e->getMessage());
}
?>