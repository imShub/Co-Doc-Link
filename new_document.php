<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Upload New Document</title>
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
                                    <h4 class="card-title">Upload New Document</h4>
                                    <p class="card-description">
                                    
                                        <!-- Notifications here  -->
                                        <!-- file uploaded success message  -->
                                        <?php
                                    if (isset($_SESSION['doc_upload'])) {
                                        ?>
                                    <div id="notification" class="alert alert-success" role="alert">
                                        <b> <i class="bi bi-check-circle-fill"></i>Success ! </b>Document uploaded
                                        successfully.
                                    </div>
                                    <?php
                                       unset($_SESSION['doc_upload']);
                                    }
                                    ?>
                                    <!-- File size exceed message  -->
                                    <?php
                                    if (isset($_SESSION['file_size'])) {
                                        ?>
                                    <div id="notification" class="alert alert-danger" role="alert">
                                        <b> <i class="bi bi-x-circle-fill"></i></i>Failed ! </b> File size exceed
                                        allowed limit (100 MB).
                                    </div>
                                    <?php
                                       unset($_SESSION['file_size']);
                                    }
                                    ?>
                                    <!-- File already exist message  -->
                                    <?php
                                    if (isset($_SESSION['file_exists'])) {
                                        ?>
                                    <div id="notification" class="alert alert-danger" role="alert">
                                        <b> <i class="bi bi-x-circle-fill"></i>Failed ! </b> File already exist.
                                    </div>
                                    <?php
                                       unset($_SESSION['file_exists']);
                                    }
                                    ?>
                                    </p>
                                    <form class="forms-sample" action="php/upload_new_document.php" method="POST"
                                        enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Document Name </label>
                                            <input type="text" name="name" class="form-control"
                                                id="exampleInputUsername1" placeholder="Document Name" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Document Description (Optional)</label>
                                            <textarea id="inp_editor1" name="desc" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Upload File </label>
                                            <input type="file" name="file" class="form-control" id="" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Folder </label>
                                            <select name="folder" class="form-control" id="" required>
                                                <option value="" selected hidden>Choose... </option>
                                                <?php
                                                $user = $_SESSION['user_id'];
                                                $sql = "SELECT * from folders where folder_user = $user";
                                                $result = $conn->query($sql);
                                                
                                                if ($result->num_rows > 0) {
                                                  // output data of each row
                                                  while($row = $result->fetch_assoc()) {
                                                    ?>
                                                <option value="<?=$row['folder_id']?>">
                                                    <span class="text-capitalize"><?=$row['folder_name']?></span>
                                                </option>
                                                <!-- <option value="<?=$row['2']?>" selected>
                                                <span class="text-capitalize"><?=$row['folder_name']?></span>
                                            </option> -->
                                                <?php
                                                  }
                                                }                                                 
                                                ?>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                                        <button class="btn btn-secondary" type="reset">Reset</button>
                                    </form>
                                    <div class="container">
                                    <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["pdf_file"])) {
                                    // Get the PDF file
                                    $pdfFile = $_FILES["pdf_file"];

                                    // Check if the file is a PDF
                                    $fileType = strtolower(pathinfo($pdfFile["name"], PATHINFO_EXTENSION));
                                    if ($fileType !== "pdf") {
                                        die("Error: Only PDF files are allowed.");
                                    }

                                    // PDF to Text Converter API URL
                                    $apiUrl = "https://pdf-to-text-converter.p.rapidapi.com/api/pdf-to-text/convert";

                                    // RapidAPI key
                                    $apiKey = "46d5ef37c2msh9bb8f9fb858af7bp1d03cajsnfaa9986c9e77";

                                    // Create FormData object
                                    $data = array(
                                        'file' => new \CurlFile($pdfFile["tmp_name"], 'application/pdf', 'file'),
                                        'page' => '1'
                                    );

                                    // Prepare cURL options
                                    $ch = curl_init();
                                    curl_setopt_array($ch, array(
                                        CURLOPT_URL => $apiUrl,
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => "",
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 30,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => "POST",
                                        CURLOPT_POSTFIELDS => $data,
                                        CURLOPT_HTTPHEADER => array(
                                            "X-RapidAPI-Key: $apiKey",
                                            "X-RapidAPI-Host: pdf-to-text-converter.p.rapidapi.com",
                                        ),
                                    ));

                                    // Execute cURL request
                                    $response = curl_exec($ch);

                                    // Check for errors
                                    if (curl_errno($ch)) {
                                        echo 'Curl error: ' . curl_error($ch);
                                    }

                                    // Close cURL session
                                    curl_close($ch);

                                    echo $response;
                                    // Extracted text
                                    // $context = $response;

                                    // // OpenAI API endpoint
                                    // $openai_url = 'https://api.openai.com/v1/chat/completions';

                                    // // OpenAI API key
                                    // $openai_api_key = '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';

                                    // // Prompt for OpenAI
                                    // $prompt = "You are a AI Assistant that gives accurate and single word output if the given context is fall under architectural, structural, RDS or Harware categoryas output\n\nContext: $context\n\nCategory:";

                                    // // Data to be sent to OpenAI
                                    // $openai_data = array(
                                    //     'messages' => array(
                                    //         array(
                                    //             'role' => 'system',
                                    //             'content' => $prompt
                                    //         )
                                    //     ),
                                    //     'model' => 'gpt-3.5-turbo', // Specify the model parameter here
                                    //     'max_tokens' => 1,
                                    //     'temperature' => 0.7,
                                    //     'stop' => '\n'
                                    // );

                                    // // Set headers
                                    // $headers = array(
                                    //     'Content-Type: application/json',
                                    //     'Authorization: Bearer ' . $openai_api_key,
                                    // );

                                    // // Initialize cURL session
                                    // $ch_openai = curl_init();

                                    // // Set cURL options for OpenAI
                                    // curl_setopt($ch_openai, CURLOPT_URL, $openai_url);
                                    // curl_setopt($ch_openai, CURLOPT_POST, true);
                                    // curl_setopt($ch_openai, CURLOPT_POSTFIELDS, json_encode($openai_data));
                                    // curl_setopt($ch_openai, CURLOPT_RETURNTRANSFER, true);
                                    // curl_setopt($ch_openai, CURLOPT_HTTPHEADER, $headers);

                                    // // Execute cURL request for OpenAI
                                    // $response_openai = curl_exec($ch_openai);

                                    // // Check for errors
                                    // if ($response_openai === false) {
                                    //     echo 'Curl error: ' . curl_error($ch_openai);
                                    // } else {
                                    //     // Decode JSON response from OpenAI
                                    //     $result_openai = json_decode($response_openai, true);

                                    //     echo "<pre>";
                                    //     print_r($result_openai);
                                    //     echo "</pre>";
                                    // }

                                    // // Close cURL session for OpenAI
                                    // curl_close($ch_openai);
                                } ?>
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
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Premium <a
                                href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from
                            BootstrapDash.</span>
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
    var editor1 = new RichTextEditor("#inp_editor1");
    </script>

</body>

</html>