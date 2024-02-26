<?php
include "../config.php";
session_start();

$redirect = $_SERVER['HTTP_REFERER'];
$docid = $_GET['docid'];

// Fetch the document record from the database
$sql = "SELECT * FROM documents WHERE doc_id = $docid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the document information
    $row = $result->fetch_assoc();
    $docName = $row['doc_name'];
    $docFilePath = $row['doc_path']; // Assuming this field contains the file path

    // SQL to delete the record
    $delete = "DELETE FROM documents WHERE doc_id = $docid";

    // Delete the file from the folder location
    if (unlink($docFilePath)) {
        // If file deletion is successful, delete the database record
        if ($conn->query($delete) === TRUE) {
            $_SESSION['doc_delete'] = $docName;
            header("location: $redirect");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Error deleting file.";
    }

    $conn->close();
} else {
    echo "No Doc Found!";
}
?>
