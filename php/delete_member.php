<?php
include '../config.php';
session_start();

$redirect = $_SERVER['HTTP_REFERER'];
$uid = $_GET['uid'];
$mid = $_GET['mid'];
// delete the shared document by this user 
$delete_docs = "DELETE FROM sharefolder_documents WHERE sfdoc_user= $uid";

if ($conn->query($delete_docs) === TRUE) {
//  after delete the documents successfully delete the member from sharefolders list 
        $sql = "DELETE FROM sharefolder_members  where member_id = $mid";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['memberremoved'] = "success";
            header("location: $redirect");
        } else {
        echo "Error deleting record: " . $conn->error;
        }
} else {
  echo "Error deleting record: " . $conn->error;
}
?>