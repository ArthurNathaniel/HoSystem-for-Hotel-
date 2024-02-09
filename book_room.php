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
    <title>Hotel Management System - Book Room</title>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <h1>Receptionist - Book Room</h1>
    <form method="post" action="">
        <label for="guest_name">Guest Name:</label>
        <input type="text" name="guest_name" required><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" required><br>

        <label for="checkin_date">Check-in Date:</label>
        <input type="datetime-local" name="checkin_date" required><br>

        <label for="checkout_date">Check-out Date:</label>
        <input type="datetime-local" name="checkout_date" required><br>

        <label for="room_id">Select Room:</label>
        <select name="room_id" required>
            <?php
            $roomQuery = "SELECT id, room_number, room_type FROM rooms WHERE status = 'available'";
            $roomResult = $conn->query($roomQuery);
            while ($row = $roomResult->fetch_assoc()) {
                echo "<option value='{$row['id']}'>Room {$row['room_number']} ({$row['room_type']})</option>";
            }
            ?>
        </select><br>

        <button type="submit">Book Room</button>
    </form>
</body>

</html>