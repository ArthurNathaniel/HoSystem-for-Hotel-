<?php
include('db.php');
        session_start();

        // Check if the user is not logged in, redirect to the login page
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }
// Fetch booking details with room type
$query = "SELECT reservations.id, reservations.guest_name, reservations.phone_number, 
          reservations.checkin_date, reservations.checkout_date, rooms.room_number, rooms.room_type
          FROM reservations
          INNER JOIN rooms ON reservations.room_id = rooms.id
          ORDER BY reservations.checkin_date DESC";
$result = $conn->query($query);

// Check for errors
if (!$result) {
    die("Error fetching data: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management System - View Booking Details</title>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <h1>View Booking Details</h1>
    <table border="1">
        <tr>
            <th>Booking ID</th>
            <th>Guest Name</th>
            <th>Phone Number</th>
            <th>Check-in Date</th>
            <th>Check-out Date</th>
            <th>Room Number</th>
            <th>Room Type</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['guest_name']}</td>";
            echo "<td>{$row['phone_number']}</td>";
            echo "<td>{$row['checkin_date']}</td>";
            echo "<td>{$row['checkout_date']}</td>";
            echo "<td>Room {$row['room_number']}</td>";
            echo "<td>{$row['room_type']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>

</html>