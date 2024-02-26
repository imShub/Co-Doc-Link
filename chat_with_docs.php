<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

include 'config.php';

function query($data) {
    $url = 'https://api-inference.huggingface.co/models/Impira/LayoutLM-Invoices';
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
        return false;
    }

    curl_close($ch);
    return $response;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['document_image'])) {
        $imageData = file_get_contents($_FILES['document_image']['tmp_name']);
        $_SESSION['document_image'] = base64_encode($imageData);
    }

    if (isset($_POST['message'])) {
        $message = $_POST['message'];
        $data = array('inputs' => array('question' => $message));

        if (isset($_SESSION['document_image'])) {
            $data['inputs']['image'] = $_SESSION['document_image'];
        }

        $response = query($data);

        if ($response !== false) {
            $chat_messages[] = json_decode($response, true);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Chat with Documents</title>
    <?php include 'partials/headtags.php'; ?>
    <style>
        .chat-messages {
            margin-top: 20px;
        }

        .user-message {
            background-color: #f2f2f2;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
            text-align: right;
        }

        .bot-message {
            background-color: #4caf50;
            color: white;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <?php include 'partials/navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'partials/settings_panel.php'; ?>
            <?php include 'partials/sidebar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Chat with Documents</h4>
                                    <p class="card-description"></p>
                                    <form class="forms-sample" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="documentImage">Upload Document Image</label>
                                            <input type="file" class="form-control-file" id="documentImage" name="document_image" accept="image/*">
                                        </div>
                                        <button type="submit" class="btn btn-primary me-2">Start Chat</button>
                                    </form>
                                    <div class="chat-messages">
                                        <?php if (isset($chat_messages)) : ?>
                                            <?php foreach ($chat_messages as $messages) : ?>
                                                <?php foreach ($messages as $message) : ?>
                                                    <?php if (isset($message['question'])) : ?>
                                                        <div class="user-message"><?= $message['question'] ?></div>
                                                    <?php endif; ?>
                                                    <?php if (isset($message['answer'])) : ?>
                                                        <div class="bot-message"><?= $message['answer'] ?></div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                    <form class="forms-sample" method="POST">
                                        <div class="form-group">
                                            <label for="chatMessage">Your Message</label>
                                            <input type="text" class="form-control" id="chatMessage" name="message" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary me-2">Send</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">.EXE Developers</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2021. All rights reserved.</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <?php include 'partials/javascripts.php'; ?>
    <script>
        var editor1 = new RichTextEditor("#inp_editor1");
    </script>
</body>

</html>
