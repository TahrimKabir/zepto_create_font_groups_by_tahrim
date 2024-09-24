<?php
require 'dbConnection.php';
class Uploader extends DbConnection
{
    private $uploadDir;
    private $allowedTypes;

    public function __construct($uploadDir = '../uploads/')
    {
        parent::__construct();
        $this->uploadDir = $uploadDir;
        $this->allowedTypes = ['ttf', 'otf', 'woff', 'woff2'];


        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }


    private function validateFileType($fileName)
    {
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        return in_array($fileExt, $this->allowedTypes);
    }


    public function uploadFile($file)
    {
        if ($this->validateFileType($file['name'])) {
            $targetFile = $this->uploadDir . basename($file['name']);

            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                $this->insertFileDetails($file['name'], $targetFile);
                return json_encode(['status' => 'success', 'message' => 'File uploaded successfully']);
            } else {
                return json_encode(['status' => 'error', 'message' => 'Error uploading file']);
            }
        } else {
            return json_encode(['status' => 'error', 'message' => 'Invalid file type']);
        }
    }
    private function insertFileDetails($fileName, $filePath)
    {
        $query = "CREATE TABLE IF NOT EXISTS uploaded_fonts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            font_name VARCHAR(255) NOT NULL,
            file_name VARCHAR(255) NOT NULL,
            file_path VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $conn = $this->getConnection();
        if (mysqli_query($conn, $query)) {
           
            $query1 = "INSERT INTO uploaded_fonts (font_name, file_name, file_path) VALUES ('$filePath', '$fileName', '$filePath')";

            if (mysqli_query($conn, $query1)) {
                return true;
            } else {
                return false;
            }
            return true;
        } else {
            
            return false;
        }
    }
}
