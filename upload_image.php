<?php
// Directory to store uploaded images
$uploadDirectory = 'uploads/';

// Create directory if it doesn't exist
if (!file_exists($uploadDirectory)) {
    mkdir($uploadDirectory, 0755, true);
}

// Check if file was uploaded
if (isset($_FILES['logo'])) {
    $file = $_FILES['logo'];
    
    // Check for errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive in the HTML form',
            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload'
        ];
        
        $errorMessage = isset($errorMessages[$file['error']]) 
            ? $errorMessages[$file['error']] 
            : 'Unknown upload error';
        
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => $errorMessage]);
        exit;
    }
    
    // Get file extension
    $fileInfo = pathinfo($file['name']);
    $extension = strtolower($fileInfo['extension']);
    
    // Check file type
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
    if (!in_array($extension, $allowedExtensions)) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only JPG, PNG, GIF and SVG are allowed.']);
        exit;
    }
    
    // Generate unique filename
    $newFilename = uniqid() . '.' . $extension;
    $destination = $uploadDirectory . $newFilename;
    
    // Move the uploaded file
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success', 
            'message' => 'File uploaded successfully',
            'filePath' => $destination
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file']);
    }
    exit;
}

// If no file was received
header('Content-Type: application/json');
echo json_encode(['status' => 'error', 'message' => 'No file uploaded']);