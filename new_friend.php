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
    <title>Add New Friends </title>
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
                        <div class="col-lg-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Users</h4>
                                    <p class="card-description">
                                        <!-- friend request sent notificaton  -->
                                        <?php
                                    if (isset($_SESSION['requestsent'])) {
                                        ?>
                                    <div id="notification" class="alert alert-success" role="alert">
                                        <b> <i class="bi bi-person-check-fill"></i> Success ! </b> Friend request
                                        sent.
                                    </div>
                                    <?php
                                       unset($_SESSION['requestsent']);
                                    }
                                    ?>
                                    <!-- cancel friend request notificaton  -->
                                    <?php
                                    if (isset($_SESSION['cancelrequest'])) {
                                        ?>
                                    <div id="notification" class="alert alert-danger" role="alert">
                                        <b> <i class="bi bi-person-x-fill"></i> Cancelled ! </b> Friend request
                                        cancelled.
                                    </div>
                                    <?php
                                       unset($_SESSION['cancelrequest']);
                                    }
                                    ?>
                                    </p>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Username</th>
                                                    <th>Joined</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $user = $_SESSION['user_id'];
                                                $sql = "SELECT * 
                                                FROM users 
                                                WHERE user_id != $user 
                                                AND NOT EXISTS (
                                                    SELECT 1
                                                    FROM friends
                                                    WHERE (frd_user = $user AND frd_friend = users.user_id)
                                                    OR (frd_user = users.user_id AND frd_friend = $user)
                                                )";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                // output data of each row
                                                while($row = $result->fetch_assoc()) {
                                                  ?>
                                                <tr>
                                                    <td><span class="text-capitalize"><?=$row['user_fullname']?></span>
                                                    </td>
                                                    <td><?=$row['username']?></td>
                                                    <td>
                                                        <?php
                                                                // Set the timezone to Asia/Kolkata
                                                                date_default_timezone_set('Asia/Kolkata');

                                                                // Assuming $row['story_date'] contains the story's date in a format like 'Y-m-d H:i:s'
                                                                $createdat = strtotime($row['created_at']);
                                                                $currentDate = time(); // Get the current timestamp in Asia/Kolkata timezone

                                                                // Calculate the time difference in seconds
                                                                $timeDifference = $currentDate - $createdat;

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
                                                        <?php
                                                        $fr_sent = $row['user_id'];
                                                    $frsql = "SELECT count(friend_requests.fr_id) as sent, friend_requests.* from friend_requests where fr_to=$fr_sent AND fr_from = $user";
                                                    $fr_result = $conn->query($frsql);
                                                    
                                                    if ($fr_result->num_rows > 0) {
                                                      // output data of each row
                                                      while($fr_row = $fr_result->fetch_assoc()) {                                                        
                                                        $sent = $fr_row['sent'];
                                                        if ($sent > 0 ) {
                                                            ?>
                                                        <a href="friends/cancel_friend_request.php?fid=<?=$fr_row['fr_id']?>"
                                                            class="btn btn-inverse-danger btn-sm rounded"><i
                                                                class="bi bi-person-x-fill"></i> &nbsp; Cancel </a>
                                                        <?php
                                                        }else {
                                                            ?>
                                                        <a href="friends/send_friend_request.php?uid=<?=$row['user_id']?>"
                                                            class="btn btn-primary btn-sm rounded"><i
                                                                class="bi bi-person-plus-fill"></i> &nbsp; Add </a>
                                                        <?php
                                                        }
                                                        ?>

                                                        <?php
                                                      }
                                                    } else {
                                                     ?>

                                                        <?php
                                                    }

                                                    ?>

                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                                } else {
                                                    ?>
                                                <td>No User Found</td>

                                                <?php
                                                }
                                                ?>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"> Friend Requests </h4>
                                    <p class="card-description">
                                        <!-- approve friend request notificaton  -->
                                        <?php
                                    if (isset($_SESSION['approve'])) {
                                        ?>
                                    <div id="notification" class="alert alert-success" role="alert">
                                        <b> <i class="bi bi-person-fill-check"></i> Approved ! </b> Friend request
                                        approved succesfully.
                                    </div>
                                    <?php
                                       unset($_SESSION['approve']);
                                    }
                                    ?>
                                    <!-- decline friend request notificaton  -->
                                    <?php
                                    if (isset($_SESSION['decline'])) {
                                        ?>
                                    <div id="notification" class="alert alert-danger" role="alert">
                                        <b> <i class="bi bi-person-x-fill"></i> Declined ! </b> Friend request
                                        declined succesfully.
                                    </div>
                                    <?php
                                       unset($_SESSION['decline']);
                                    }
                                    ?>

                                    </p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Username</th>
                                                    <th> Request </th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                    $friendrequestssql = "SELECT * from friend_requests INNER JOIN users ON users.user_id = friend_requests.fr_from where fr_to = $user AND fr_status = 0";
                                                    $friendrequestsresult = $conn->query($friendrequestssql);

                                                    if ($friendrequestsresult->num_rows > 0) {
                                                    // output data of each row
                                                    while($friendrequestsrow = $friendrequestsresult->fetch_assoc()) {
                                                        ?>
                                                <tr>
                                                    <td><span
                                                            class="text-capitalize"><?=$friendrequestsrow['user_fullname']?></span>
                                                    </td>
                                                    <td><?=$friendrequestsrow['username']?></td>
                                                    <td>
                                                        <?php
                                                                // Set the timezone to Asia/Kolkata
                                                                date_default_timezone_set('Asia/Kolkata');

                                                                // Assuming $row['story_date'] contains the story's date in a format like 'Y-m-d H:i:s'
                                                                $createdat = strtotime($friendrequestsrow['fr_date']);
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
                                                    <td>
                                                        <a href="friends/approve_friend_request.php?fid=<?=$friendrequestsrow['fr_id']?>"
                                                            class="btn btn-inverse-success btn-sm rounded">Approve</a>
                                                        <a href="friends/decline_friend_request.php?fid=<?=$friendrequestsrow['fr_id']?>"
                                                            class="btn btn-inverse-danger btn-sm rounded">Decline</a>
                                                    </td>
                                                </tr>

                                                <?php
                                                    }
                                                    } else {
                                                        ?>
<td>No Friend Requests</td>
                                                        <?php
                                                    }
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
                <!-- partial:../../partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">.EXE Developers</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2021. All
                            rights reserved.</span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->

        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <?php include 'partials/javascripts.php'; ?>
    <script>
    // Automatically hide the success alert after 3 seconds (3000 milliseconds)
    setTimeout(function() {
        var successAlert = document.getElementById('notification');
        successAlert.style.display = 'none';
    }, 3000);
    </script>

</body>

</html>