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
    <?php include './include/cdn.php' ?>
    <title>Hotel Management System - Room Availability</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/view_booking.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
</head>
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
    <?php include 'sidebar.php'; ?>
    <div class="booking_all">
        <div class="bookig_title">
            <h1>Room Availability</h1>
        </div>
            <table id="bookingTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Room Type</th>
                        <th>Room Number</th>
                        <th>Room Status</th>
                        <th>Availability</th>
                    </tr>
                </thead>
                <tbody>
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

                        echo "<td>{$row['room_type']}</td>";
                        echo "<td>{$row['room_number']}</td>";
                        echo "<td class='{$statusClass}'>{$row['status']}</td>";
                        echo "<td>{$availability}</td>";  // Added availability column
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