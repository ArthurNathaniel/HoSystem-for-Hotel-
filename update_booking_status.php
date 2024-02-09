<?php
include('db.php');

// Get current date and time
$currentDateTime = date('Y-m-d H:i:s');

// Update reservations and rooms based on checkout date and time
$updateQuery = "UPDATE reservations
                SET status = 'checked-out'
                WHERE checkout_date <= '$currentDateTime' AND status = 'booked'";
$conn->query($updateQuery);

$updateRoomQuery = "UPDATE rooms
                    SET status = 'available'
                    WHERE NOT EXISTS (
                        SELECT 1 FROM reservations
                        WHERE room_id = rooms.id
                        AND status = 'booked'
                    )";
$conn->query($updateRoomQuery);
