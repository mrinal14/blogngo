<?php
$targetDir = "uploads/";
$files = glob($targetDir . '*.{jpg,jpeg,png,gif,mp4}', GLOB_BRACE);

foreach ($files as $file) {
    echo "<div class='blog-post'>";
    // Display the image or video
    if (pathinfo($file, PATHINFO_EXTENSION) === 'mp4') {
        echo "<video controls>";
        echo "<source src='$file' type='video/mp4'>";
        echo "Your browser does not support the video tag.";
        echo "</video>";
    } else {
        echo "<img src='$file' alt='Uploaded Image'>";
    }

    // Read and display text content for this post
    $textFile = pathinfo($file, PATHINFO_FILENAME) . ".txt";
    $textFilePath = $targetDir . $textFile;

    if (file_exists($textFilePath)) {
        $textContent = file_get_contents($textFilePath);
        echo "<p>$textContent</p>";
    } else {
        echo "<p>No text content available.</p>";
    }

    echo "</div>";
}
?>
