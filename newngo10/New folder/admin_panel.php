<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

echo "Welcome " . $_SESSION['username'];
echo "<br><a href='logout.php'>Logout</a>";
?>
