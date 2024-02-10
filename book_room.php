<?php
include('db.php');
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
// Include logic to update booking status
include('update_booking_status.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission to book a room for a user
    $guestName = $_POST['guest_name'];
    $phoneNumber = $_POST['phone_number'];
    $checkinDate = $_POST['checkin_date'];
    $checkoutDate = $_POST['checkout_date'];
    $roomId = $_POST['room_id'];

    // Check if the room is available for the given dates
    $availabilityQuery = "SELECT status, room_type FROM rooms WHERE id = $roomId";
    $availabilityResult = $conn->query($availabilityQuery);
    $roomData = $availabilityResult->fetch_assoc();

    if ($roomData['status'] === 'available') {
        // Room is available, book it
        $insertQuery = "INSERT INTO reservations (room_id, guest_name, phone_number, checkin_date, checkout_date) VALUES ($roomId, '$guestName', '$phoneNumber', '$checkinDate', '$checkoutDate')";
        if ($conn->query($insertQuery) === TRUE) {
            // Update room status to booked
            $updateRoomQuery = "UPDATE rooms SET status = 'booked' WHERE id = $roomId";
            $conn->query($updateRoomQuery);

            echo "Booking successful for Room {$roomId} ({$roomData['room_type']})!";
        } else {
            echo "Error booking room: " . $conn->error;
        }
    } else {
        echo "Room not available for the selected dates.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include './include/cdn.php' ?>
    <title>Hotel Management System - Book Room</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/signup.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="booked_all">
        <div class="title">
            <h1>Receptionist - Book Room</h1>
        </div>
        <form method="post" action="">
            <div class="forms">
                <label for="guest_name">Guest Name:</label>
                <input type="text" placeholder="Enter your guest name" name="guest_name" required>
            </div>
            <div class="forms">
                <label for="phone_number">Phone Number:</label>
                <input type="number" placeholder="Enter your phone number" name="phone_number" required>
            </div>
            <div class="forms">
                <label for="checkin_date">Check-in Date:</label>
                <input type="datetime-local" placeholder="Pick a date for check in" name="checkin_date" id="myDateTime" required>
            </div>
            <div class="forms">
                <label for="checkout_date">Check-out Date:</label>
                <input type="datetime-local" placeholder="Pick a date for check out" name="checkout_date" id="myDateTime" required><br>

            </div>
            <label for="room_id">Select Room:</label>
            <div class="forms">
                <select name="room_id" required>
                    <?php
                    $roomQuery = "SELECT id, room_number, room_type FROM rooms WHERE status = 'available'";
                    $roomResult = $conn->query($roomQuery);
                    while ($row = $roomResult->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>Room {$row['room_number']} ({$row['room_type']})</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="forms">
                <button type="submit">Book Room</button>
            </div>
        </form>
    </div>
    <script src="./js/navbar.js"></script>
</body>

</html>

<style>
    .booked_all {
        margin-top: 70px;
        padding: 0 15%;
    }

    .forms select {
        height: 50px;
        border: 2px solid #8f8989c7;
        border-radius: 10px;
        padding-left: 2%;
    }

    .title {
        margin-bottom: 30px;
    }
</style>