<?php
include '../config.php';
session_start();

$redirect = $_SERVER['HTTP_REFERER'];
$sfid = $_GET['sfid'];

// delete sharefolder documents 
$sfdocs = "DELETE FROM sharefolder_documents WHERE sfdoc_sfid = $sfid";

if ($conn->query($sfdocs) === TRUE) {
    // after deleting sharefolder documents delete sharefolder members 
            $sfmembers = "DELETE FROM sharefolder_members where member_sf= $sfid";

            if ($conn->query($sfmembers) === TRUE) {
                // after deleting sharefolder documents and members delete the sharefolder record
                        $delsf = "DELETE FROM sharefolder where sf_id= $sfid";

                        if ($conn->query($delsf) === TRUE) {
                            $_SESSION['sfdelete'] = "success";
                            header("location: $redirect");
                        } else {
                        echo "Error deleting record: " . $conn->error;
                        }
            } else {
            echo "Error deleting sharefolder members: " . $conn->error;
            }
} else {
  echo "Error deleting sharefolder documents : " . $conn->error;
}
?>