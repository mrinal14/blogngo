<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a caption is provided
    if (isset($_POST['caption']) && !empty($_POST['caption'])) {
        $caption = $_POST['caption'];

        // Check if a file is uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Define the directory to save the uploaded file
            $uploadDir = 'uploads/';

            // Create the directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Generate a unique filename for the uploaded file
            $filename = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $filename;

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // The file has been uploaded successfully
                // You can save the post information to a database here if needed
                // For now, let's just echo the caption and the filename
                echo "Caption: " . $caption . "<br>";
                echo "Image uploaded: " . $filename;
            } else {
                echo "Error uploading the file.";
            }
        } else {
            echo "Please upload an image.";
        }
    } else {
        echo "Please enter a caption.";
    }
} else {
    // Redirect to the post page if the form is not submitted
    header("Location: post.html");
    exit();
}
?>
