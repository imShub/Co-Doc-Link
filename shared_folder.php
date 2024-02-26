<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
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
    <title>Shared Folder </title>
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
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Create Shared Folder with Friends</h4>
                                    <p class="card-description">
                                        <!-- Shared folder crated notification  -->
                                        <?php
                                    if (isset($_SESSION['sf_created'])) {
                                        ?>
                                    <div id="notification" class="alert alert-success" role="alert">
                                        <b> <i class="bi bi-check-circle-fill"></i>Success ! </b> Shared Folder created
                                        successfully.
                                    </div>
                                    <?php
                                       unset($_SESSION['sf_created']);
                                    }
                                    ?>
                                    </p>
                                    <form class="forms-sample" action="php/new_share_folder.php" method="POST">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Shared Folder Name</label>
                                            <input type="text" name="foldername" class="form-control"
                                                id="exampleInputEmail1" placeholder="Folder Name">
                                        </div>
                                        <button type="submit" class="btn btn-primary me-2">Create</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"> Share Folders </h4>
                                    <p class="card-description">
                                        <!-- share folder delete notiication  -->
                                        <?php
                                    if (isset($_SESSION['sfdelete'])) {
                                        ?>
                                    <div id="notification" class="alert alert-success" role="alert">
                                        <b> <i class="bi bi-check-circle-fill"></i>Success ! </b> Shared Folder deleted
                                        successfully.
                                    </div>
                                    <?php
                                       unset($_SESSION['sfdelete']);
                                    }
                                    ?>
                                    </p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Profile</th>
                                                    <th>Members</th>
                                                    <th>Created</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $userid = $_SESSION['user_id'];
                                                $sfsql = "SELECT DISTINCT sf.*, COALESCE(sf_member_count, 0) AS total_members
                                                FROM sharefolder AS sf
                                                LEFT JOIN sharefolder_members AS sfm ON sfm.member_sf = sf.sf_id
                                                LEFT JOIN (
                                                    SELECT member_sf, COUNT(*) AS sf_member_count
                                                    FROM sharefolder_members
                                                    GROUP BY member_sf
                                                ) AS member_counts ON member_counts.member_sf = sf.sf_id
                                                WHERE sf.sf_user = $userid OR sfm.member_userid = $userid";
                                                $sf_result = $conn->query($sfsql);

                                                if ($sf_result->num_rows > 0) {
                                                // output data of each row
                                                while($sfrow = $sf_result->fetch_assoc()) {
                                                    ?>
                                                <tr>
                                                    <td>
                                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                                            width="32" height="32" viewBox="0 0 48 48">
                                                            <linearGradient id="WQEfvoQAcpQgQgyjQQ4Hqa_dINnkNb1FBl4_gr1"
                                                                x1="24" x2="24" y1="6.708" y2="14.977"
                                                                gradientUnits="userSpaceOnUse">
                                                                <stop offset="0" stop-color="#eba600"></stop>
                                                                <stop offset="1" stop-color="#c28200"></stop>
                                                            </linearGradient>
                                                            <path fill="url(#WQEfvoQAcpQgQgyjQQ4Hqa_dINnkNb1FBl4_gr1)"
                                                                d="M24.414,10.414l-2.536-2.536C21.316,7.316,20.553,7,19.757,7L5,7C3.895,7,3,7.895,3,9l0,30	c0,1.105,0.895,2,2,2l38,0c1.105,0,2-0.895,2-2V13c0-1.105-0.895-2-2-2l-17.172,0C25.298,11,24.789,10.789,24.414,10.414z">
                                                            </path>
                                                            <linearGradient id="WQEfvoQAcpQgQgyjQQ4Hqb_dINnkNb1FBl4_gr2"
                                                                x1="24" x2="24" y1="10.854" y2="40.983"
                                                                gradientUnits="userSpaceOnUse">
                                                                <stop offset="0" stop-color="#ffd869"></stop>
                                                                <stop offset="1" stop-color="#fec52b"></stop>
                                                            </linearGradient>
                                                            <path fill="url(#WQEfvoQAcpQgQgyjQQ4Hqb_dINnkNb1FBl4_gr2)"
                                                                d="M21.586,14.414l3.268-3.268C24.947,11.053,25.074,11,25.207,11H43c1.105,0,2,0.895,2,2v26	c0,1.105-0.895,2-2,2H5c-1.105,0-2-0.895-2-2V15.5C3,15.224,3.224,15,3.5,15h16.672C20.702,15,21.211,14.789,21.586,14.414z">
                                                            </path>
                                                        </svg> &nbsp;
                                                        <?=$sfrow['sf_name']?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                    $members = $sfrow['total_members'];
                                                    if ($members == 1) {
                                                        echo $members. " member";
                                                    }else {
                                                        echo $members. " members";
                                                    }

                                                    ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                                // Set the timezone to Asia/Kolkata
                                                                date_default_timezone_set('Asia/Kolkata');

                                                                // Assuming $row['story_date'] contains the story's date in a format like 'Y-m-d H:i:s'
                                                                $createdat = strtotime($sfrow['sf_date']);
                                                                $currentDate = time(); // Get the current timestamp in Asia/Kolkata timezone

                                                                // Calculate the time difference in seconds
                                                                $timeDifference = $currentDate - $createdat;

                                                                // Create a string to display the time when the story was posted
                                                                $timePosted = '';

                                                                if ($timeDifference < 60) {
                                                                    // Less than a minute
                                                                    $timePosted = "Just now";
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
                                                    <td><a href="share_folder_documents.php?id=<?=$sfrow['sf_id']?>"
                                                            class="btn btn-inverse-primary btn-sm rounded">Open</a>

                                                        <?php
                                                            $sf_id = $sfrow['sf_user'];
                                                            if ($sf_id == $userid) {
                                                                ?>
                                                        <!-- delete trigger modal -->
                                                        <button type="button"
                                                            class="btn btn-inverse-danger btn-sm rounded"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deletesharefolder<?=$sfrow['sf_id']?>">
                                                            Delete
                                                        </button>
                                                        <?php
                                                            }
                                                            ?>
                                                        <!-- delete Modal -->
                                                        <div class="modal fade"
                                                            id="deletesharefolder<?=$sfrow['sf_id']?>" tabindex="-1"
                                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body fs-6 fw-bold text-wrap">
                                                                        Are you sure you want to close this sharefolder,
                                                                        all the documents and members will be removed
                                                                        from this sharefolder. This action cannot be
                                                                        undo. <br> Are you sure you want to continue ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary btn-sm"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <a type="button"
                                                                            href="php/delete_sharefolder.php?sfid=<?=$sfrow['sf_id']?>"
                                                                            class="btn btn-danger btn-sm">Yes, Continue
                                                                            <i class="bi bi-arrow-right-short"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </td>

                                                </tr>

                                                <?php
                                                }
                                                } else {
                                               ?>
                                                <td>No Sharefolder found !</td>
                                                <?php
                                                }
                                                $conn->close();
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
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

</body>

</html>