<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file is uploaded successfully
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Upload file
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
                // Add the uploaded file to blog.html
                $blogHTML = "<div class='blog-post'><img src='$targetFile' alt='Uploaded Image'></div>";
                file_put_contents("blog.html", $blogHTML, FILE_APPEND | LOCK_EX);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "Error uploading file.";
    }

    // Append text to blog.html
    if (!empty($_POST['text'])) {
        $text = $_POST['text'];
        $blogHTML = "<div class='blog-post'>$text</div>";
        file_put_contents("blog.html", $blogHTML, FILE_APPEND | LOCK_EX);
    }
}
?>
