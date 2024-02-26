<?php
include '../config.php';
session_start();

$redirect = $_SERVER['HTTP_REFERER'];
$userid = $_SESSION['user_id'];
$docid = $_POST['docid'];
$sfid = $_POST['sharefolder'];


// check if document is already shared 
$find_sql = "SELECT count(sfdoc_id) as records from sharefolder_documents where sfdoc_sfid = $sfid AND sfdoc_docid = $docid";
$record_results = $conn->query($find_sql);

if ($record_results->num_rows > 0) {
  // output data of each row
  while($totalrecords = $record_results->fetch_assoc()) {
    $records = $totalrecords['records'];
    // check if document is already exists or not 
    if ($records == 0) {
        $sql = "INSERT INTO sharefolder_documents ( sfdoc_user, sfdoc_sfid, sfdoc_docid)
        VALUES ('$userid', '$sfid', '$docid')";
        
        if ($conn->query($sql) === TRUE) {
            $_SESSION['sharedsuccess'] = "success";
            header("location: $redirect");
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }   
    }
    // else statment if records found 
    else {
        $_SESSION['sfdocexists'] = "success";
            header("location: $redirect");
    }
  }
} else {
  echo "0 results";
}



?>