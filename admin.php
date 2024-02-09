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
            echo "Room added successfully!";
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
    <title>Hotel Management System - Admin</title>
</head>

<body>
    <?php include 'navbar.php';?>
    <h1>Admin Panel - Add Room</h1>
    <form method="post" action="">
        <label for="room_number">Room Number:</label>
        <input type="number" name="room_number" required>

        <label for="room_type">Room Type:</label>
        <input type="text" name="room_type" required> <!-- Add this line for room type -->

        <button type="submit">Add Room</button>
    </form>
</body>

</html>