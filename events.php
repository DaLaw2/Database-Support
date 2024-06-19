<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "user";
$password = "user";
$dbname = "dddd";

include 'connection.php';
$conn = getDatabaseConnection();

$sql = "SELECT * FROM t10_project";
$result = $conn->query($sql);

$events = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $eventDate = date('Y-m-d', strtotime($row['T10_ProDate']));
        $events[] = [
            //'date' => $eventDate,
            'date' => $row['T10_ProDate'],
            'description' => $row['T10_ProTitle']
            ,
            'pass' => $row['T10_ProPass']
        ];
    }
} else {
    echo "0 results";
}
$conn->close();

header('Content-Type: application/json');
echo json_encode($events);
