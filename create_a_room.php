<?php
include('db.php');
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission to add a new room
    $roomNumber = $_POST['room_number'];
    $roomType = $_POST['room_type'];  // Add this line to retrieve room type

    // Check if the room number already exists
    $checkQuery = "SELECT COUNT(id) AS count FROM rooms WHERE room_number = $roomNumber";
    $checkResult = $conn->query($checkQuery);
    $count = $checkResult->fetch_assoc()['count'];

    if ($count == 0) {
        // Room number doesn't exist, insert a new room
        $insertQuery = "INSERT INTO rooms (room_number, room_type) VALUES ($roomNumber, '$roomType')";
        if ($conn->query($insertQuery) === TRUE) {
            echo "Room added successfully! ";
        } else {
            echo "Error adding room: " . $conn->error;
        }
    } else {
        echo "Room number already exists!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include './include/cdn.php' ?>
    <title>Create A Room</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/signup.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="create_all">
        <div class="title">
            <h1>Admin Panel - Add Room</h1>
        </div>
        <form method="post" action="">
            <div class="forms">
                <label for="room_type">Room Type:</label>
                <input type="text" placeholder="Enter your room type" name="room_type" required>
            </div>
            <div class="forms">
                <label for="room_number">Room Number:</label>
                <input type="number" placeholder="Enter your room number" name="room_number" required>
            </div>
            <div class="forms">
                <button type="submit"> Create Add Room</button>
            </div>
        </form>
    </div>
    <script src="./js/navbar.js"></script>
</body>

</html>
<style>
    body {
        width: 100%;
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-self: center;
    }

    .create_all {
        margin-top: 70px;
        width: 60%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-self: center;
    }
</style>