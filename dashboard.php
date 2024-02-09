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
    <?php include './include/cdn.php' ?>
    <title>Hotel Management System - Stats</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/dashboard.css">
</head>

<body>
    <?php
    include('db.php');

    // Get today's date
    $today = date('Y-m-d');

    // Get the first and last day of the current week
    $firstDayOfWeek = date('Y-m-d', strtotime('monday this week'));
    $lastDayOfWeek = date('Y-m-d', strtotime('sunday this week'));

    // Get the first and last day of the current month
    $firstDayOfMonth = date('Y-m-01');
    $lastDayOfMonth = date('Y-m-t');

    // Get the first and last day of the current year
    $firstDayOfYear = date('Y-01-01');
    $lastDayOfYear = date('Y-12-31');

    // Query to get stats for today
    $bookedTodayQuery = "SELECT COUNT(*) AS booked_rooms_today FROM reservations WHERE DATE(checkin_date) = '$today'";
    $availableTodayQuery = "SELECT COUNT(*) AS available_rooms_today FROM rooms WHERE status = 'available'";

    // Query to get stats for the current week
    $bookedWeekQuery = "SELECT COUNT(*) AS booked_rooms_week FROM reservations WHERE DATE(checkin_date) BETWEEN '$firstDayOfWeek' AND '$lastDayOfWeek'";
    $availableWeekQuery = "SELECT COUNT(*) AS available_rooms_week FROM rooms WHERE status = 'available'";

    // Query to get stats for the current month
    $bookedMonthQuery = "SELECT COUNT(*) AS booked_rooms_month FROM reservations WHERE DATE(checkin_date) BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'";
    $availableMonthQuery = "SELECT COUNT(*) AS available_rooms_month FROM rooms WHERE status = 'available'";

    // Query to get stats for the current year
    $bookedYearQuery = "SELECT COUNT(*) AS booked_rooms_year FROM reservations WHERE DATE(checkin_date) BETWEEN '$firstDayOfYear' AND '$lastDayOfYear'";
    $availableYearQuery = "SELECT COUNT(*) AS available_rooms_year FROM rooms WHERE status = 'available'";

    // Execute queries
    $bookedTodayResult = $conn->query($bookedTodayQuery);
    $availableTodayResult = $conn->query($availableTodayQuery);

    $bookedWeekResult = $conn->query($bookedWeekQuery);
    $availableWeekResult = $conn->query($availableWeekQuery);

    $bookedMonthResult = $conn->query($bookedMonthQuery);
    $availableMonthResult = $conn->query($availableMonthQuery);

    $bookedYearResult = $conn->query($bookedYearQuery);
    $availableYearResult = $conn->query($availableYearQuery);

    // Fetch data
    $bookedRoomsToday = $bookedTodayResult->fetch_assoc()['booked_rooms_today'];
    $availableRoomsToday = $availableTodayResult->fetch_assoc()['available_rooms_today'];

    $bookedRoomsWeek = $bookedWeekResult->fetch_assoc()['booked_rooms_week'];
    $availableRoomsWeek = $availableWeekResult->fetch_assoc()['available_rooms_week'];

    $bookedRoomsMonth = $bookedMonthResult->fetch_assoc()['booked_rooms_month'];
    $availableRoomsMonth = $availableMonthResult->fetch_assoc()['available_rooms_month'];

    $bookedRoomsYear = $bookedYearResult->fetch_assoc()['booked_rooms_year'];
    $availableRoomsYear = $availableYearResult->fetch_assoc()['available_rooms_year'];
    ?>

    <?php include './sidebar.php' ?>

    <div class="container_all">
        <div class="container">
            <!-- Booked Rooms Today -->
            <div class="card">
                <h2>Booked Rooms Today</h2>
                <p>Number of rooms booked for today:</p>
                <p class="highlight"><?php echo $bookedRoomsToday; ?></p>
            </div>

            <!-- Available Rooms Today -->
            <div class="card">
                <h2>Available Rooms Today</h2>
                <p>Number of rooms available for today:</p>
                <p class="highlight"><?php echo $availableRoomsToday; ?></p>
            </div>
        </div>

        <div class="container">
            <!-- Booked Rooms This Week -->
            <div class="card">
                <h2>Booked Rooms This Week</h2>
                <p>Number of rooms booked for this week:</p>
                <p class="highlight"><?php echo $bookedRoomsWeek; ?></p>
            </div>

            <!-- Available Rooms This Week -->
            <div class="card">
                <h2>Available Rooms This Week</h2>
                <p>Number of rooms available for this week:</p>
                <p class="highlight"><?php echo $availableRoomsWeek; ?></p>
            </div>
        </div>

        <div class="container">
            <!-- Booked Rooms This Month -->
            <div class="card">
                <h2>Booked Rooms This Month</h2>
                <p>Number of rooms booked for this month:</p>
                <p class="highlight"><?php echo $bookedRoomsMonth; ?></p>
            </div>

            <!-- Available Rooms This Month -->
            <div class="card">
                <h2>Available Rooms This Month</h2>
                <p>Number of rooms available for this month:</p>
                <p class="highlight"><?php echo $availableRoomsMonth; ?></p>
            </div>
        </div>

        <div class="container">
            <!-- Booked Rooms This Year -->
            <div class="card">
                <h2>Booked Rooms This Year</h2>
                <p>Number of rooms booked for this year:</p>
                <p class="highlight"><?php echo $bookedRoomsYear; ?></p>
            </div>

            <!-- Available Rooms This Year -->
            <div class="card">
                <h2>Available Rooms This Year</h2>
                <p>Number of rooms available for this year:</p>
                <p class="highlight"><?php echo $availableRoomsYear; ?></p>
            </div>
        </div>
    </div>

    <script src="./js/navbar.js"></script>
</body>

</html>