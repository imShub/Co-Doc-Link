<?php
// Include your database connection code here
include('../config.php'); // Replace 'db_connection.php' with your database connection script
session_start();

// Maximum file size in bytes (2MB)
$maxFileSize = 100 * 1024 * 1024; // 100MB

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user = $_SESSION['user_id'];
    $redirect = $_SERVER['HTTP_REFERER'];
    $documentName = $_POST['name'];
    $folderID = $_POST['folder'];
    $documentDesc = $_POST['desc'];
    $sql1 = "SELECT * from folders where folder_id = $folderID";
    $result1 = $conn->query($sql1);

    if ($result1->num_rows > 0) {
        // Output data of each row
        while ($row1 = $result1->fetch_assoc()) {
            $foldername = $row1['folder_name'];
            $uploadDir = '../folders_list/' . $foldername . '/';
            $uploadFile = $uploadDir . basename($_FILES['file']['name']);

            // Check if the file already exists in the folder
            if (file_exists($uploadFile)) {
                $_SESSION['file_exists'] = "success";
                            header("location: $redirect");
            } else {
                // Check if the file size is within the allowed limit
                if ($_FILES['file']['size'] <= $maxFileSize) {
                    // File upload handling
                    $fileSize = $_FILES['file']['size']; // Get the file size

                    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
                        // File uploaded successfully, insert data into the database
                        $sql = "INSERT INTO documents (doc_user, doc_name, doc_folder, doc_desc, doc_path, doc_size) VALUES (?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("isissi", $user, $documentName, $folderID, $documentDesc, $uploadFile, $fileSize);

                        if ($stmt->execute()) {
                            // Insertion successful                   
                            $_SESSION['doc_upload'] = "success";
                            header("location: $redirect");
                            exit();
                        } else {
                            // Insertion failed
                            echo "Error: " . $stmt->error;
                        }

                        $stmt->close();
                    } else {
                        // File upload failed
                        echo "File upload failed!";
                    }
                } else {
                    $_SESSION['file_size'] = "success";
                    header("location: $redirect");
                }
            }
        }
    } else {
        echo "Error in fetching folder name from database";
    }
}
?>