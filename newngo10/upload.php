<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = $_POST['text'] ?? '';
    $targetDir = "uploads/";

    // Handling image upload
    if (!empty($_FILES["file"]["name"])) {
        $targetFile = $targetDir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if file is an image
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            $uploadOk = 0;
        }

        // Upload file
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
                // Save the text content to a file
                if (!empty($text)) {
                    $textFile = $targetDir . pathinfo($targetFile, PATHINFO_FILENAME) . '.txt';
                    file_put_contents($textFile, $text . PHP_EOL, FILE_APPEND | LOCK_EX);
                }
                // Redirect to the upload page after successful upload
                header('Location: upload_page.html');
                exit;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // Save the text content only
        if (!empty($text)) {
            $textFile = $targetDir . 'text_content.txt';
            file_put_contents($textFile, $text . PHP_EOL, FILE_APPEND | LOCK_EX);
        }
        // Redirect to the upload page after successful upload
        header('Location: upload_page.html');
        exit;
    }
}
?>
