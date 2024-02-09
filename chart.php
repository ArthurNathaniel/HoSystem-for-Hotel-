<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include './include/cdn.php' ?>
    <title>Hotel Management System - Stats</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/chart.css">
</head>

<body>
    <?php
    include('db.php');
    session_start();

    // Check if the user is not logged in, redirect to the login page
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }
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

    <?php include 'sidebar.php' ?>


    <div class="chart_all">
        <div class="container">
            <!-- Booked Rooms Today -->
            <div class="card">
                <h2>Booked Rooms Today</h2>
                <p>Number of rooms booked for today:</p>
                <p class="highlight"><?php echo $bookedRoomsToday; ?></p>
                <div class="chart-container">
                    <canvas id="bookedRoomsTodayChart"></canvas>
                </div>
            </div>

            <!-- Available Rooms Today -->
            <div class="card">
                <h2>Available Rooms Today</h2>
                <p>Number of rooms available for today:</p>
                <p class="highlight"><?php echo $availableRoomsToday; ?></p>
                <div class="chart-container">
                    <canvas id="availableRoomsTodayChart"></canvas>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- Booked Rooms This Week -->
            <div class="card">
                <h2>Booked Rooms This Week</h2>
                <p>Number of rooms booked for this week:</p>
                <p class="highlight"><?php echo $bookedRoomsWeek; ?></p>
                <div class="chart-container">
                    <canvas id="bookedRoomsWeekChart"></canvas>
                </div>
            </div>

            <!-- Available Rooms This Week -->
            <div class="card">
                <h2>Available Rooms This Week</h2>
                <p>Number of rooms available for this week:</p>
                <p class="highlight"><?php echo $availableRoomsWeek; ?></p>
                <div class="chart-container">
                    <canvas id="availableRoomsWeekChart"></canvas>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- Booked Rooms This Month -->
            <div class="card">
                <h2>Booked Rooms This Month</h2>
                <p>Number of rooms booked for this month:</p>
                <p class="highlight"><?php echo $bookedRoomsMonth; ?></p>
                <div class="chart-container">
                    <canvas id="bookedRoomsMonthChart"></canvas>
                </div>
            </div>

            <!-- Available Rooms This Month -->
            <div class="card">
                <h2>Available Rooms This Month</h2>
                <p>Number of rooms available for this month:</p>
                <p class="highlight"><?php echo $availableRoomsMonth; ?></p>
                <div class="chart-container">
                    <canvas id="availableRoomsMonthChart"></canvas>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- Booked Rooms This Year -->
            <div class="card">
                <h2>Booked Rooms This Year</h2>
                <p>Number of rooms booked for this year:</p>
                <p class="highlight"><?php echo $bookedRoomsYear; ?></p>
                <div class="chart-container">
                    <canvas id="bookedRoomsYearChart"></canvas>
                </div>
            </div>

            <!-- Available Rooms This Year -->
            <div class="card">
                <h2>Available Rooms This Year</h2>
                <p>Number of rooms available for this year:</p>
                <p class="highlight"><?php echo $availableRoomsYear; ?></p>
                <div class="chart-container">
                    <canvas id="availableRoomsYearChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Chart.js code
        document.addEventListener('DOMContentLoaded', function() {
            // Booked Rooms Today Chart
            var bookedRoomsTodayChart = new Chart(document.getElementById('bookedRoomsTodayChart'), {
                type: 'bar',
                data: {
                    labels: ['Booked Rooms Today'],
                    datasets: [{
                        label: 'Booked Rooms Today',
                        data: [<?php echo $bookedRoomsToday; ?>],
                        backgroundColor: '#6158e5',
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Available Rooms Today Chart
            var availableRoomsTodayChart = new Chart(document.getElementById('availableRoomsTodayChart'), {
                type: 'bar',
                data: {
                    labels: ['Available Rooms Today'],
                    datasets: [{
                        label: 'Available Rooms Today',
                        data: [<?php echo $availableRoomsToday; ?>],
                        backgroundColor: '#ff4961',
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Booked Rooms This Week Chart
            var bookedRoomsWeekChart = new Chart(document.getElementById('bookedRoomsWeekChart'), {
                type: 'bar',
                data: {
                    labels: ['Booked Rooms This Week'],
                    datasets: [{
                        label: 'Booked Rooms This Week',
                        data: [<?php echo $bookedRoomsWeek; ?>],
                        backgroundColor: '#6158e5',
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Available Rooms This Week Chart
            var availableRoomsWeekChart = new Chart(document.getElementById('availableRoomsWeekChart'), {
                type: 'bar',
                data: {
                    labels: ['Available Rooms This Week'],
                    datasets: [{
                        label: 'Available Rooms This Week',
                        data: [<?php echo $availableRoomsWeek; ?>],
                        backgroundColor: '#ff4961',
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Booked Rooms This Month Chart
            var bookedRoomsMonthChart = new Chart(document.getElementById('bookedRoomsMonthChart'), {
                type: 'bar',
                data: {
                    labels: ['Booked Rooms This Month'],
                    datasets: [{
                        label: 'Booked Rooms This Month',
                        data: [<?php echo $bookedRoomsMonth; ?>],
                        backgroundColor: '#6158e5',
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Available Rooms This Month Chart
            var availableRoomsMonthChart = new Chart(document.getElementById('availableRoomsMonthChart'), {
                type: 'bar',
                data: {
                    labels: ['Available Rooms This Month'],
                    datasets: [{
                        label: 'Available Rooms This Month',
                        data: [<?php echo $availableRoomsMonth; ?>],
                        backgroundColor: '#ff4961',
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Booked Rooms This Year Chart
            var bookedRoomsYearChart = new Chart(document.getElementById('bookedRoomsYearChart'), {
                type: 'bar',
                data: {
                    labels: ['Booked Rooms This Year'],
                    datasets: [{
                        label: 'Booked Rooms This Year',
                        data: [<?php echo $bookedRoomsYear; ?>],
                        backgroundColor: '#6158e5',
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Available Rooms This Year Chart
            var availableRoomsYearChart = new Chart(document.getElementById('availableRoomsYearChart'), {
                type: 'bar',
                data: {
                    labels: ['Available Rooms This Year'],
                    datasets: [{
                        label: 'Available Rooms This Year',
                        data: [<?php echo $availableRoomsYear; ?>],
                        backgroundColor: '#ff4961',
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
    <script src="./js/navbar.js"></script>
</body>

</html>