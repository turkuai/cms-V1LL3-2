<?php
include 'database.php'; // Include the database connection

// Handle GET request (loading data)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Fetch settings
        $sql = "SELECT company_name, description, copyright, logo_path FROM settings LIMIT 1";
        $result = db_query($conn, $sql);
        $settings = $result->get_result()->fetch_assoc();
        if (!$settings) {
            $settings = [
                'company_name' => 'Your company\'s name',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'copyright' => '© 2024, Company\'s name, All rights reserved.',
                'logo_path' => ''
            ];
        }

        // Fetch links
        $sql = "SELECT name, href FROM links WHERE type=? ORDER BY id";
        $navLinks = db_query($conn, $sql, ['nav'])->get_result()->fetch_all(MYSQLI_ASSOC);
        $footerLinks = db_query($conn, $sql, ['footer'])->get_result()->fetch_all(MYSQLI_ASSOC);
        $socialLinks = db_query($conn, $sql, ['social'])->get_result()->fetch_all(MYSQLI_ASSOC);

        // Fetch articles
        $sql = "SELECT title, description AS content, image_url AS imageUrl FROM sections ORDER BY id";
        $articles = db_query($conn, $sql)->get_result()->fetch_all(MYSQLI_ASSOC);

        // Construct the data array
        $data = [
            'companyName' => $settings['company_name'],
            'description' => $settings['description'],
            'copyright' => $settings['copyright'],
            'logoPath' => $settings['logo_path'],
            'navLinks' => array_map(function($link) { return ['text' => $link['name'], 'url' => $link['href']]; }, $navLinks),
            'footerLinks' => array_map(function($link) { return ['text' => $link['name'], 'url' => $link['href']]; }, $footerLinks),
            'socialLinks' => array_map(function($link) { return ['text' => $link['name'], 'url' => $link['href']]; }, $socialLinks),
            'articles' => $articles
        ];

        // Send the data as JSON response
        header('Content-Type: application/json');
        echo json_encode($data);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}

// Handle POST request (saving data)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON data from the request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON data']);
        exit;
    }

    try {
        // Save settings
        $sql = "INSERT INTO settings (id, company_name, description, copyright, logo_path) VALUES (1, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE company_name=?, description=?, copyright=?, logo_path=?";
        db_query($conn, $sql, [
            $data['companyName'], $data['description'], $data['copyright'], $data['logoPath'],
            $data['companyName'], $data['description'], $data['copyright'], $data['logoPath']
        ]);

        // Save links
        // Delete existing links
        db_query($conn, "DELETE FROM links WHERE type='nav'");
        db_query($conn, "DELETE FROM links WHERE type='footer'");
        db_query($conn, "DELETE FROM links WHERE type='social'");

        // Insert new links
        foreach ($data['navLinks'] as $link) {
            db_query($conn, "INSERT INTO links (type, name, href) VALUES ('nav', ?, ?)", [$link['text'], $link['url']]);
        }
        foreach ($data['footerLinks'] as $link) {
            db_query($conn, "INSERT INTO links (type, name, href) VALUES ('footer', ?, ?)", [$link['text'], $link['url']]);
        }
        foreach ($data['socialLinks'] as $link) {
            db_query($conn, "INSERT INTO links (type, name, href) VALUES ('social', ?, ?)", [$link['text'], $link['url']]);
        }

        // Save articles
        db_query($conn, "DELETE FROM sections");
        foreach ($data['articles'] as $article) {
            db_query($conn, "INSERT INTO sections (title, description, image_url) VALUES (?, ?, ?)", [$article['title'], $article['content'], $article['imageUrl']]);
        }

        // Send success response
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'Data saved successfully']);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}

// Return error for unsupported methods
header('HTTP/1.1 405 Method Not Allowed');
header('Content-Type: application/json');
echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
?>