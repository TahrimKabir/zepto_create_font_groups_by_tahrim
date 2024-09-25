<?php
// delete_font.php
require 'dbConnection.php'; // Adjust the path to your database connection

// Get the raw POST data
$data = json_decode(file_get_contents("php://input"));

// Check if ID is provided
if (isset($data->id)) {
    $id = $data->id;

    // Prepare the DELETE query
    $query = "DELETE FROM uploaded_fonts WHERE id = $id";

    // Execute the query
    if (mysqli_query((new DbConnection())->getConnection(), $query)) {
        echo json_encode(['success' => true, 'message' => 'Font deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting font.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No ID provided.']);
}
?>
