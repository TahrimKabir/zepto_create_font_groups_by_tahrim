<?php
require 'FontList.php';

// Instantiate the FontList class
$fontList = new FontList();

// Fetch the uploaded fonts
$fonts = $fontList->getUploadedFonts();

// Return the font list as a JSON response
header('Content-Type: application/json');
echo json_encode($fonts);
