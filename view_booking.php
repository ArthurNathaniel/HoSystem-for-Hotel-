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

    <?php include './include/cdn.php' ?>
    <title>Hotel Management System - View Booking Details</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/view_booking.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="booking_all">
        <div class="bookig_title">
            <h1>View Booking Details</h1>
        </div>
        <table id="bookingTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Guest Name</th>
                    <th>Phone Number</th>
                    <th>Check-in Date</th>
                    <th>Check-out Date</th>
                    <th>Room Number</th>
                    <th>Room Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['guest_name']}</td>";
                    echo "<td>{$row['phone_number']}</td>";
                    echo "<td>" . date('F j, Y g:i A', strtotime($row['checkin_date'])) . "</td>";
                    echo "<td>" . date('F j, Y g:i A', strtotime($row['checkout_date'])) . "</td>";
                    echo "<td>Room {$row['room_number']}</td>";
                    echo "<td>{$row['room_type']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#bookingTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'print'
                ]
            });
        });
    </script>
    <script src="./js/navbar.js"></script>
</body>

</html>