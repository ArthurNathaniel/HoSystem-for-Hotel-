<?php
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <?php include './include/cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
</head>

<body>
    <?php include './sidebar.php' ?>
    <script src="./js/navbar.js"></script>
</body>

</html>