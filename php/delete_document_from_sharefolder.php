<?php
include '../config.php';
session_start();

$redirect = $_SERVER['HTTP_REFERER'];

$docid = $_GET['docid'];

// delete document from sharefolder 
$delete = "DELETE FROM sharefolder_documents WHERE sfdoc_id = $docid";

if ($conn->query($delete) === TRUE) {
    $_SESSION['doc_delete_sf'] = "success";
    header("location: $redirect");
  } else {
    echo "Error deleting record: " . $conn->error;
  }

?>