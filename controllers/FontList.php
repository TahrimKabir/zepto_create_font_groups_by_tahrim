<?php
require 'dbConnection.php';

class FontList extends DbConnection
{
    public function __construct()
    {
        parent::__construct(); // Inherit the database connection
    }

    public function getUploadedFonts()
    {
        $conn = $this->getConnection(); // Get the database connection
        $query = "SELECT font_name, file_name, file_path FROM uploaded_fonts"; // SQL query to get font list
        $result = mysqli_query($conn, $query);

        // Check if any rows are returned
        if (mysqli_num_rows($result) > 0) {
            $fontList = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $fontList[] = [
                    'font_name' => $row['font_name'],
                    'file_name' => $row['file_name'],
                    'file_path' => $row['file_path']
                ];
            }
            return $fontList;
        } else {
            return [];
        }
    }
}
