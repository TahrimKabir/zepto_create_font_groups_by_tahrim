<?php
require 'Uploader.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['upload_font'])) {
        $uploader = new Uploader();
        $response = $uploader->uploadFile($_FILES['upload_font']);
        echo $response;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No file uploaded']);
    }
}
