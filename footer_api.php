<?php
// Data storage file
$dataFile = 'page_data.json';

// Handle POST request (saving data)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON data from the request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        // JSON error handling
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON data']);
        exit;
    }
    
    // Save the data to file
    if (file_put_contents($dataFile, $json)) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'Data saved successfully']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Failed to save data']);
    }
    exit;
}

// Handle GET request (loading data)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if data file exists
    if (file_exists($dataFile)) {
        // Read the data from file
        $json = file_get_contents($dataFile);
        
        // Send the data as JSON response
        header('Content-Type: application/json');
        echo $json;
    } else {
        // If file doesn't exist, return empty data structure
        header('Content-Type: application/json');
        echo json_encode([
            'companyName' => 'Your company\'s name',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'copyright' => '© 2024, Company\'s name, All rights reserved.',
            'navLinks' => [],
            'footerLinks' => [],
            'socialLinks' => [],
            'articles' => [],
            'logoPath' => ''
        ]);
    }
    exit;
}

// Return error for unsupported methods
header('HTTP/1.1 405 Method Not Allowed');
header('Content-Type: application/json');
echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);