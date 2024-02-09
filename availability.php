<?php
include('db.php');
        session_start();

        // Check if the user is not logged in, redirect to the login page
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }
// Fetch available rooms with room type
$query = "SELECT id, room_number, room_type, status FROM rooms";
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
    <title>Hotel Management System - Room Availability</title>
    <style>
        .available {
            color: green;
        }

        .booked {
            color: orange;
        }

        .occupied {
            color: red;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <h1>Room Availability</h1>
    <table border="1">
        <tr>
            <th>Room Number</th>
            <th>Room Type</th>
            <th>Status</th>
            <th>Availability</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            $statusClass = '';
            switch ($row['status']) {
                case 'available':
                    $statusClass = 'available';
                    break;
                case 'booked':
                    $statusClass = 'booked';
                    break;
                case 'occupied':
                    $statusClass = 'occupied';
                    break;
            }

            $availability = ($row['status'] === 'available') ? 'Available' : 'Not Available';

            echo "<tr>";
            echo "<td>{$row['room_number']}</td>";
            echo "<td>{$row['room_type']}</td>";  // Added room type column
            echo "<td class='{$statusClass}'>{$row['status']}</td>";
            echo "<td>{$availability}</td>";  // Added availability column
            echo "</tr>";
        }
        ?>
    </table>
</body>

</html>