<?php
class Uploader
{
    private $uploadDir;
    private $allowedTypes;

    public function __construct($uploadDir = '../uploads/')
    {
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
                return json_encode(['status' => 'success', 'message' => 'File uploaded successfully']);
            } else {
                return json_encode(['status' => 'error', 'message' => 'Error uploading file']);
            }
        } else {
            return json_encode(['status' => 'error', 'message' => 'Invalid file type']);
        }
    }
}
