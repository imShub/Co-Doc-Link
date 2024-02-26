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
    <title>Friends List </title>
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
                                    <h4 class="card-title">Friends List </h4>
                                    <p class="card-description">
                                        <!-- cancel friend request notificaton  -->
                                        <?php
                                    if (isset($_SESSION['unfriend'])) {
                                        ?>
                                    <div id="notification" class="alert alert-danger" role="alert">
                                        <b> <i class="bi bi-person-x-fill"></i> Removed ! </b> Friend removed
                                        successfully.
                                    </div>
                                    <?php
                                       unset($_SESSION['unfriend']);
                                    }
                                    ?>
                                    </p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Username</th>
                                                    <th>Created</th>
                                                    <th>Remove</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $user = $_SESSION['user_id'];
                                                        $sql = "SELECT * FROM friends INNER JOIN users ON users.user_id = friends.frd_friend where frd_user = $user";
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
                                                                $createdat = strtotime($row['frd_date']);
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
                                                        <!-- Button trigger modal -->
                                                        <button type="button"
                                                            class="btn btn-inverse-danger btn-sm rounded"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#frd_id<?=$row['frd_id']?>">
                                                            <i class="bi bi-person-dash-fill"></i> &nbsp; Remove
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="frd_id<?=$row['frd_id']?>"
                                                            tabindex="-1" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5 text-capitalize"
                                                                            id="exampleModalLabel">
                                                                            <?=$row['user_fullname']?></h1>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to unfriend <b
                                                                            class="text-capitalize"><?=$row['user_fullname']?></b>
                                                                        ?.
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <a href="friends/unfriend_friend.php?frd_id=<?=$row['frd_id']?>"
                                                                            class="btn btn-danger rounded"> <i
                                                                                class="bi bi-person-dash-fill"></i>
                                                                            &nbsp; Remove</a>
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
                                                <td>No Friends </td>
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

            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <?php include 'partials/javascripts.php'; ?>


</body>

</html>