<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

include 'config.php';

function query($data) {
    $url = 'https://api-inference.huggingface.co/models/SaiRaj03/Text_To_Image';
    $authorization = 'Bearer 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';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        "Authorization: $authorization"
    ));

    $response = curl_exec($ch);

    if ($response === false) {
        return false; // Error handling
    }

    curl_close($ch);
    return $response;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $architecture_prompt = $_POST['architecture_prompt'];

    $data = array(
        'inputs' => $architecture_prompt
    );

    $response = query($data);
    if ($response !== false) {
        // Use the image
        $image_name = 'generated_image.png';
        file_put_contents($image_name, $response);
        echo 'Image generated successfully!';
    } else {
        echo 'Failed to generate image.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Generate Architecture's using Gen-AI</title>
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
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Generate New Architecture's using Gen-AI</h4>
                                    <p class="card-description"></p>
                                    <form class="forms-sample" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="architecturePrompt">Architecture Prompt </label>
                                            <input type="text" name="architecture_prompt" class="form-control"
                                                id="architecturePrompt" placeholder="Architecture Prompt" required>
                                        </div>

                                        <button type="submit" class="btn btn-primary me-2">Generate</button>
                                    </form>
                                    <?php if (isset($image_name)) { ?>
                                    <div class="mt-3">
                                        <h5 class="card-title">Generated Architecture Image:</h5>
                                        <img src="<?php echo $image_name; ?>" class="img-fluid" alt="Generated Image">
                                    </div>
                                    <?php } ?>
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
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright ©
                            2021. All
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
    var editor1 = new RichTextEditor("#inp_editor1");
    </script>
</body>

</html>
