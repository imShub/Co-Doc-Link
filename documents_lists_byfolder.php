<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
include 'config.php';
include 'partials/php_functions.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Documents List </title>
    <?php include 'partials/headtags.php'; ?>

</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <?php include 'partials/navbar.php'; ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->
            <?php include 'partials/settings_panel.php'; ?>
            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            <?php include 'partials/sidebar.php'; ?>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32"
                                            viewBox="0 0 48 48">
                                            <linearGradient id="WQEfvoQAcpQgQgyjQQ4Hqa_dINnkNb1FBl4_gr1" x1="24" x2="24"
                                                y1="6.708" y2="14.977" gradientUnits="userSpaceOnUse">
                                                <stop offset="0" stop-color="#eba600"></stop>
                                                <stop offset="1" stop-color="#c28200"></stop>
                                            </linearGradient>
                                            <path fill="url(#WQEfvoQAcpQgQgyjQQ4Hqa_dINnkNb1FBl4_gr1)"
                                                d="M24.414,10.414l-2.536-2.536C21.316,7.316,20.553,7,19.757,7L5,7C3.895,7,3,7.895,3,9l0,30	c0,1.105,0.895,2,2,2l38,0c1.105,0,2-0.895,2-2V13c0-1.105-0.895-2-2-2l-17.172,0C25.298,11,24.789,10.789,24.414,10.414z">
                                            </path>
                                            <linearGradient id="WQEfvoQAcpQgQgyjQQ4Hqb_dINnkNb1FBl4_gr2" x1="24" x2="24"
                                                y1="10.854" y2="40.983" gradientUnits="userSpaceOnUse">
                                                <stop offset="0" stop-color="#ffd869"></stop>
                                                <stop offset="1" stop-color="#fec52b"></stop>
                                            </linearGradient>
                                            <path fill="url(#WQEfvoQAcpQgQgyjQQ4Hqb_dINnkNb1FBl4_gr2)"
                                                d="M21.586,14.414l3.268-3.268C24.947,11.053,25.074,11,25.207,11H43c1.105,0,2,0.895,2,2v26	c0,1.105-0.895,2-2,2H5c-1.105,0-2-0.895-2-2V15.5C3,15.224,3.224,15,3.5,15h16.672C20.702,15,21.211,14.789,21.586,14.414z">
                                            </path>
                                        </svg>
                                        <?php
                                        $folder = $_GET['fid'];
                                        $fname = "SELECT * from folders where folder_id = $folder";
                                        $fresult = $conn->query($fname);

                                        if ($fresult->num_rows > 0) {
                                            // output data of each row
                                            while ($frow = $fresult->fetch_assoc()) {
                                                echo $frow['folder_name'];
                                            }
                                        }
                                        ?>
                                        <!-- <a href="new_document.php" class="btn btn-inverse-success float-end rounded-pill">Upload
                                            New</a> -->
                                    </h4>
                                    <p class="card-description">
                                        <!-- Document delte notification  -->
                                        <?php
                                        if (isset($_SESSION['doc_delete'])) {
                                        ?>
                                    <div id="notification" class="alert alert-danger" role="alert">
                                        <b> <i class="bi bi-exclamation-triangle-fill"></i> Deleted ! </b>Document "<b
                                            class="text-capitalize"><?php echo $_SESSION['doc_delete'] ?></b>"
                                        Deleted
                                        successfully.
                                    </div>
                                    <?php
                                            unset($_SESSION['doc_delete']);
                                        }
                                ?>
                                    <!-- Document shared notification  -->
                                    <?php
                                if (isset($_SESSION['sharedsuccess'])) {
                                ?>
                                    <div id="notification" class="alert alert-success" role="alert">
                                        <b> <i class="bi bi-x-circle-fill"></i> Success ! Document shared to
                                            sharedfolder
                                            successfully.
                                    </div>
                                    <?php
                                    unset($_SESSION['sharedsuccess']);
                                }
                                ?>

                                    <!-- Document already shared  notification  -->
                                    <?php
                                if (isset($_SESSION['sfdocexists'])) {
                                ?>
                                    <div id="notification" class="alert alert-danger" role="alert">
                                        <b> <i class="bi bi-exclamation-triangle-fill"></i> Failed ! Document already
                                            shared in this sharedfolder.
                                    </div>
                                    <?php
                                    unset($_SESSION['sfdocexists']);
                                }
                                ?>
                                    </p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name </th>
                                                    <th>File Size</th>
                                                    <th>Uploaded on</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                            $fid = $_GET['fid'];
                                            $sql = "SELECT * FROM documents where doc_folder= $fid";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                <tr>
                                                    <td>


                                                        <?php
                                                            $docName = $row['doc_path'];
                                                            $docType = pathinfo($docName, PATHINFO_EXTENSION);
                                                            if ($docType == "pdf") {
                                                            ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                                            width="32" height="32" viewBox="0 0 48 48">
                                                            <path fill="#e53935"
                                                                d="M38,42H10c-2.209,0-4-1.791-4-4V10c0-2.209,1.791-4,4-4h28c2.209,0,4,1.791,4,4v28	C42,40.209,40.209,42,38,42z">
                                                            </path>
                                                            <path fill="#fff"
                                                                d="M34.841,26.799c-1.692-1.757-6.314-1.041-7.42-0.911c-1.627-1.562-2.734-3.45-3.124-4.101 c0.586-1.757,0.976-3.515,1.041-5.402c0-1.627-0.651-3.385-2.473-3.385c-0.651,0-1.237,0.391-1.562,0.911 c-0.781,1.367-0.456,4.101,0.781,6.899c-0.716,2.018-1.367,3.97-3.189,7.42c-1.888,0.781-5.858,2.604-6.183,4.556 c-0.13,0.586,0.065,1.172,0.521,1.627C13.688,34.805,14.273,35,14.859,35c2.408,0,4.751-3.32,6.379-6.118 c1.367-0.456,3.515-1.107,5.663-1.497c2.538,2.213,4.751,2.538,5.923,2.538c1.562,0,2.148-0.651,2.343-1.237 C35.492,28.036,35.297,27.32,34.841,26.799z M33.214,27.905c-0.065,0.456-0.651,0.911-1.692,0.651 c-1.237-0.325-2.343-0.911-3.32-1.692c0.846-0.13,2.734-0.325,4.101-0.065C32.824,26.929,33.344,27.254,33.214,27.905z M22.344,14.497c0.13-0.195,0.325-0.325,0.521-0.325c0.586,0,0.716,0.716,0.716,1.302c-0.065,1.367-0.325,2.734-0.781,4.036 C21.824,16.905,22.019,15.083,22.344,14.497z M22.214,27.124c0.521-1.041,1.237-2.864,1.497-3.645 c0.586,0.976,1.562,2.148,2.083,2.669C25.794,26.213,23.776,26.604,22.214,27.124z M18.374,29.728 c-1.497,2.473-3.059,4.036-3.905,4.036c-0.13,0-0.26-0.065-0.391-0.13c-0.195-0.13-0.26-0.325-0.195-0.586 C14.078,32.136,15.77,30.899,18.374,29.728z">
                                                            </path>
                                                        </svg>
                                                        <?php
                                                            }
                                                            else if (in_array($docType, array("png", "jpeg", "jpg", "svg", "gif"))) {
                                                            ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                                            width="32" height="32" viewBox="0 0 48 48">
                                                            <path fill="#90CAF9" d="M40 45L8 45 8 3 30 3 40 13z"></path>
                                                            <path fill="#E1F5FE" d="M38.5 14L29 14 29 4.5z"></path>
                                                            <path fill="#1565C0" d="M21 23L14 33 28 33z"></path>
                                                            <path fill="#1976D2"
                                                                d="M28 26.4L23 33 33 33zM31.5 23A1.5 1.5 0 1 0 31.5 26 1.5 1.5 0 1 0 31.5 23z">
                                                            </path>
                                                        </svg>
                                                        <?php
                                                            }elseif (in_array($docType, array("zip", "rar", "7z", "gz", "tar", "bz2"))) {
                                                               ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                                            width="32" height="32" viewBox="0 0 48 48">
                                                            <linearGradient id="Ja~RXCbVqNAHlfRcVj7wMa_PLvn50bVGAlA_gr1"
                                                                x1="24" x2="24" y1="18" y2="30"
                                                                gradientUnits="userSpaceOnUse">
                                                                <stop offset=".233" stop-color="#41a5ee"></stop>
                                                                <stop offset=".317" stop-color="#3994de"></stop>
                                                                <stop offset=".562" stop-color="#2366b4"></stop>
                                                                <stop offset=".751" stop-color="#154a9b"></stop>
                                                                <stop offset=".86" stop-color="#103f91"></stop>
                                                            </linearGradient>
                                                            <rect width="36" height="12" x="6" y="18"
                                                                fill="url(#Ja~RXCbVqNAHlfRcVj7wMa_PLvn50bVGAlA_gr1)">
                                                            </rect>
                                                            <linearGradient id="Ja~RXCbVqNAHlfRcVj7wMb_PLvn50bVGAlA_gr2"
                                                                x1="24" x2="24" y1="6" y2="18"
                                                                gradientUnits="userSpaceOnUse">
                                                                <stop offset=".233" stop-color="#e8457c"></stop>
                                                                <stop offset=".272" stop-color="#e14177"></stop>
                                                                <stop offset=".537" stop-color="#b32c59"></stop>
                                                                <stop offset=".742" stop-color="#971e46"></stop>
                                                                <stop offset=".86" stop-color="#8c193f"></stop>
                                                            </linearGradient>
                                                            <path fill="url(#Ja~RXCbVqNAHlfRcVj7wMb_PLvn50bVGAlA_gr2)"
                                                                d="M42,18H6V8c0-1.105,0.895-2,2-2h32c1.105,0,2,0.895,2,2V18z">
                                                            </path>
                                                            <linearGradient id="Ja~RXCbVqNAHlfRcVj7wMc_PLvn50bVGAlA_gr3"
                                                                x1="24" x2="24" y1="30" y2="42"
                                                                gradientUnits="userSpaceOnUse">
                                                                <stop offset=".233" stop-color="#33c481"></stop>
                                                                <stop offset=".325" stop-color="#2eb173"></stop>
                                                                <stop offset=".566" stop-color="#228353"></stop>
                                                                <stop offset=".752" stop-color="#1b673f"></stop>
                                                                <stop offset=".86" stop-color="#185c37"></stop>
                                                            </linearGradient>
                                                            <path fill="url(#Ja~RXCbVqNAHlfRcVj7wMc_PLvn50bVGAlA_gr3)"
                                                                d="M40,42H8c-1.105,0-2-0.895-2-2V30h36v10C42,41.105,41.105,42,40,42z">
                                                            </path>
                                                            <rect width="14" height="36" x="17" y="6" opacity=".05">
                                                            </rect>
                                                            <rect width="13" height="36" x="17.5" y="6" opacity=".07">
                                                            </rect>
                                                            <linearGradient id="Ja~RXCbVqNAHlfRcVj7wMd_PLvn50bVGAlA_gr4"
                                                                x1="24" x2="24" y1="6" y2="42"
                                                                gradientUnits="userSpaceOnUse">
                                                                <stop offset=".039" stop-color="#f8c819"></stop>
                                                                <stop offset=".282" stop-color="#af4316"></stop>
                                                            </linearGradient>
                                                            <rect width="12" height="36" x="18" y="6"
                                                                fill="url(#Ja~RXCbVqNAHlfRcVj7wMd_PLvn50bVGAlA_gr4)">
                                                            </rect>
                                                            <linearGradient id="Ja~RXCbVqNAHlfRcVj7wMe_PLvn50bVGAlA_gr5"
                                                                x1="24" x2="24" y1="12" y2="42"
                                                                gradientUnits="userSpaceOnUse">
                                                                <stop offset="0" stop-color="#eaad29"></stop>
                                                                <stop offset=".245" stop-color="#d98e24"></stop>
                                                                <stop offset=".632" stop-color="#c0631c"></stop>
                                                                <stop offset=".828" stop-color="#b75219"></stop>
                                                                <stop offset=".871" stop-color="#a94917"></stop>
                                                                <stop offset=".949" stop-color="#943b13"></stop>
                                                                <stop offset="1" stop-color="#8c3612"></stop>
                                                            </linearGradient>
                                                            <path fill="url(#Ja~RXCbVqNAHlfRcVj7wMe_PLvn50bVGAlA_gr5)"
                                                                d="M24,12c-3.314,0-6,2.686-6,6v24h12V18C30,14.686,27.314,12,24,12z">
                                                            </path>
                                                            <path
                                                                d="M20,32c-0.73,0-1.41-0.2-2-0.55v1.14c0.61,0.26,1.29,0.41,2,0.41h8c0.71,0,1.39-0.15,2-0.41v-1.14 C29.41,31.8,28.73,32,28,32H20z M29,22v6c0,0.55-0.45,1-1,1h-2v-2c0-1.1-0.9-2-2-2s-2,0.9-2,2v2h-2c-0.55,0-1-0.45-1-1v-6 c0-0.55-0.45-1-1-1v7c0,1.1,0.9,2,2,2h3v-3c0-0.55,0.45-1,1-1s1,0.45,1,1v3h3c1.1,0,2-0.9,2-2v-7C29.45,21,29,21.45,29,22z"
                                                                opacity=".05"></path>
                                                            <path
                                                                d="M29.5,22v6c0,0.83-0.67,1.5-1.5,1.5h-2.5V27c0-0.83-0.67-1.5-1.5-1.5s-1.5,0.67-1.5,1.5v2.5H20 c-0.83,0-1.5-0.67-1.5-1.5v-6c0-0.28-0.22-0.5-0.5-0.5V28c0,1.1,0.9,2,2,2h3v-3c0-0.55,0.45-1,1-1s1,0.45,1,1v3h3c1.1,0,2-0.9,2-2 v-6.5C29.72,21.5,29.5,21.72,29.5,22z M20,32c-0.73,0-1.41-0.2-2-0.55v0.58c0.6,0.3,1.28,0.47,2,0.47h8c0.72,0,1.4-0.17,2-0.47 v-0.58C29.41,31.8,28.73,32,28,32H20z"
                                                                opacity=".07"></path>
                                                            <linearGradient id="Ja~RXCbVqNAHlfRcVj7wMf_PLvn50bVGAlA_gr6"
                                                                x1="24" x2="24" y1="21" y2="32"
                                                                gradientUnits="userSpaceOnUse">
                                                                <stop offset=".613" stop-color="#e6e6e6"></stop>
                                                                <stop offset=".785" stop-color="#e4e4e4"></stop>
                                                                <stop offset=".857" stop-color="#ddd"></stop>
                                                                <stop offset=".91" stop-color="#d1d1d1"></stop>
                                                                <stop offset=".953" stop-color="#bfbfbf"></stop>
                                                                <stop offset=".967" stop-color="#b8b8b8"></stop>
                                                            </linearGradient>
                                                            <path fill="url(#Ja~RXCbVqNAHlfRcVj7wMf_PLvn50bVGAlA_gr6)"
                                                                d="M32,23v5c0,2.2-1.8,4-4,4h-8c-2.2,0-4-1.8-4-4v-5c0-1.105,0.895-2,2-2h0v7 c0,1.105,0.895,2,2,2h3v-3c0-0.552,0.448-1,1-1h0c0.552,0,1,0.448,1,1v3h3c1.105,0,2-0.895,2-2v-7C31.1,21,32,21.9,32,23z">
                                                            </path>
                                                        </svg>
                                                        <?php
                                                            }
                                                            ?>
                                                        <span class="text-capitalize"><?= $row['doc_name'] ?></span>
                                                    </td>
                                                    <td><?php $size = $row['doc_size'];
                                                            $sizefomat = formatFileSize($size);
                                                            echo $sizefomat;
                                                            ?></td>
                                                    <td>
                                                        <?php
                                                            // Set the timezone to Asia/Kolkata
                                                            date_default_timezone_set('Asia/Kolkata');

                                                            // Assuming $row['story_date'] contains the story's date in a format like 'Y-m-d H:i:s'
                                                            $storyDate = strtotime($row['doc_date']);
                                                            $currentDate = time(); // Get the current timestamp in Asia/Kolkata timezone

                                                            // Calculate the time difference in seconds
                                                            $timeDifference = $currentDate - $storyDate;

                                                            // Create a string to display the time when the story was posted
                                                            $timePosted = '';

                                                            if ($timeDifference < 60) {
                                                                // Less than a minute
                                                                $timePosted = "Uploaded just now";
                                                            } elseif ($timeDifference < 3600) {
                                                                // Less than an hour
                                                                $minutes = floor($timeDifference / 60);
                                                                $timePosted = $minutes . ' minute' . ($minutes != 1 ? 's' : '') . ' ago';
                                                            } elseif ($timeDifference < 86400) {
                                                                // Less than a day
                                                                $hours = floor($timeDifference / 3600);
                                                                $timePosted = $hours . ' hour' . ($hours != 1 ? 's' : '') . ' ago';
                                                            } elseif ($timeDifference < 2592000) {
                                                                // Less than a month (30 days)
                                                                $days = floor($timeDifference / 86400);
                                                                $timePosted = $days . ' day' . ($days != 1 ? 's' : '') . ' ago';
                                                            } else {
                                                                // More than a month
                                                                $months = floor($timeDifference / 2592000); // Approximate number of seconds in a month
                                                                $timePosted = $months . ' month' . ($months != 1 ? 's' : '') . ' ago';
                                                            }

                                                            // Print the time when the story was posted
                                                            echo $timePosted;
                                                            ?>

                                                    </td>
                                                    <td>
                                                        <div class="template-demo d-flex flex-nowrap">
                                                            <!-- Download section  -->
                                                            <a href="folders_list/<?= $row['doc_path'] ?>"
                                                                class="btn btn-inverse-success btn-sm rounded align-items-center"
                                                                download>
                                                                <i class="bi bi-download"></i>
                                                            </a>
                                                            <!-- Delete section  -->
                                                            <a class="btn btn-inverse-danger btn-sm rounded align-items-center"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete_doc-<?= $row['doc_id'] ?>">
                                                                <i class="bi bi-trash-fill"></i>
                                                            </a>

                                                            <!-- delete modal -->
                                                            <div class="modal fade"
                                                                id="delete_doc-<?= $row['doc_id'] ?>" tabindex="-1"
                                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body text-wrap">

                                                                            <div class="alert alert-danger"
                                                                                role="alert">
                                                                                <h4
                                                                                    class="alert-heading fw-bolder text-danger">
                                                                                    <i
                                                                                        class="bi bi-exclamation-triangle-fill"></i>Warning
                                                                                </h4>
                                                                                <br><br>
                                                                                <b class="fs-6 text-center text-danger">Are
                                                                                    you sure
                                                                                    you
                                                                                    want to
                                                                                    delete "<span
                                                                                        class="text-dark text-capitalize"><?= $row['doc_name'] ?></span>"
                                                                                    document ? </b>
                                                                                <hr>
                                                                                <p class="fw-bold text-danger">This will
                                                                                    delete this
                                                                                    document permanently, You cannot
                                                                                    undo this action. </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-header mt-0">
                                                                            <button type="button"
                                                                                class="btn btn-secondary rounded-pill"
                                                                                data-bs-dismiss="modal">No,
                                                                                Cancel</button>
                                                                            <a type="button"
                                                                                href="php/delete_document.php?docid=<?= $row['doc_id'] ?>"
                                                                                class="btn btn-danger rounded-pill">Yes,
                                                                                I'm Sure</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- delete modal end here  -->

                                                            <!-- Document description modal  -->

                                                            <?php
                                                                $desc = $row['doc_desc'];
                                                                if ($desc > 0) {
                                                                ?>
                                                            <!-- Button trigger modal -->
                                                            <a type="button"
                                                                class="btn btn-inverse-info btn-sm rounded align-items-center"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#desc<?= $row['doc_id'] ?>">
                                                                <i class="bi bi-info-circle-fill"></i>
                                                            </a>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="desc<?= $row['doc_id'] ?>"
                                                                tabindex="-1" aria-labelledby="exampleModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5"
                                                                                id="exampleModalLabel">Document
                                                                                Description</h1>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <?= $row['doc_desc'] ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- modal end here  -->
                                                            <?php
                                                                }
                                                                ?>
                                                            <!-- share  trigger modal -->
                                                            <button type="button"
                                                                class="btn btn-inverse-primary btn-sm rounded align-items-center"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#share<?= $row['doc_id'] ?>">
                                                                <i class="bi bi-share-fill"></i>
                                                            </button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="share<?= $row['doc_id'] ?>"
                                                                tabindex="-1" aria-labelledby="exampleModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5"
                                                                                id="exampleModalLabel">Share Documents
                                                                            </h1>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form
                                                                                action="php/share_document_in_share_folder.php"
                                                                                method="POST">
                                                                                <div class="mb-3">
                                                                                    <label for="exampleInputEmail1"
                                                                                        class="form-label">Choose Shared
                                                                                        Folder </label>
                                                                                    <input type="hidden" name="docid"
                                                                                        value="<?= $row['doc_id'] ?>">
                                                                                    <select name="sharefolder"
                                                                                        class="form-control" id=""
                                                                                        required>
                                                                                        <option value="" selected
                                                                                            hidden>Choose... </option>
                                                                                        <?php
                                                                                            $userid = $_SESSION['user_id'];
                                                                                            $sfsql = "SELECT DISTINCT sf.*
                                                                                            FROM sharefolder AS sf
                                                                                            LEFT JOIN sharefolder_members AS sfm ON sfm.member_sf = sf.sf_id
                                                                                            WHERE sf.sf_user = $userid OR sfm.member_userid = $userid";
                                                                                            $sfresult = $conn->query($sfsql);

                                                                                            if ($sfresult->num_rows > 0) {
                                                                                                // output data of each row
                                                                                                while ($sf_row = $sfresult->fetch_assoc()) {
                                                                                            ?>
                                                                                        <option
                                                                                            value="<?= $sf_row['sf_id'] ?>">
                                                                                            <span
                                                                                                class="text-capitalize"><?= $sf_row['sf_name'] ?></span>
                                                                                        </option>
                                                                                        <?php
                                                                                                }
                                                                                            } else {
                                                                                                ?>
                                                                                        <option value="" disabled>No
                                                                                            Shared Folder Active
                                                                                        </option>
                                                                                        <?php
                                                                                            }
                                                                                            ?>
                                                                                    </select>

                                                                                </div>

                                                                                <button type="submit"
                                                                                    class="btn btn-primary float-end">Share</button>
                                                                            </form>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                            }
                                            $conn->close();
                                            ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <br>
                                    <button class="btn btn-inverse-dark btn-rounded btn-sm" onclick="goBack()"><i
                                            class="bi bi-arrow-left-short"></i> Back</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->

            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <?php include 'partials/javascripts.php'; ?>
    <script>
    function goBack() {
        window.history.go(-1);
    }
    </script>
    <script>
    // Specify the URL of your PDF file
    var pdfFile = 'path_to_your_pdf_file.pdf';

    // Initialize PDF.js
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'path_to_pdfjs/pdf.worker.js';

    // Create a PDF viewer instance
    var pdfViewer = document.getElementById('pdfViewer');
    var pdfViewerContainer = document.createElement('div');
    pdfViewerContainer.style.width = '100%';
    pdfViewerContainer.style.height = '500px'; // Set the desired height
    pdfViewer.appendChild(pdfViewerContainer);

    // Load and render the PDF
    pdfjsLib.getDocument(pdfFile).promise.then(function(pdfDoc) {
        pdfDoc.getPage(1).then(function(page) {
            var viewport = page.getViewport({
                scale: 1
            });
            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            pdfViewerContainer.appendChild(canvas);
            page.render({
                canvasContext: context,
                viewport: viewport
            });
        });
    });
    </script>

</body>

</html>