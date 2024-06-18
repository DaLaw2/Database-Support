<?php
include 'connection.php';

$studentNumber = $_SESSION['studentNumber'] ?? "41143151";

$reportTitle = $_POST['reportTitle'];
$currentProgress = $_POST['currentProgress'];
$nextWeekPlan = $_POST['nextWeekPlan'];
$date = date("YmdHis");
$datetime = date("Y-m-d H:i:s");

$targetDir = "./file/$studentNumber/$date/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$uploadedFiles = [];
if (isset($_FILES['fileUpload']) && !empty($_FILES['fileUpload']['name'][0])) {
    foreach ($_FILES['fileUpload']['name'] as $key => $name) {
        $targetFile = $targetDir . basename($name);
        if (move_uploaded_file($_FILES['fileUpload']['tmp_name'][$key], $targetFile)) {
            $uploadedFiles[] = htmlspecialchars($name);
        } else {
            echo "Sorry, there was an error uploading your file: $name";
        }
    }

    if (!empty($uploadedFiles)) {
        echo "The following files have been uploaded: " . implode(", ", $uploadedFiles);
    }
} else {
    echo "No files uploaded.";
}

$conn = getDatabaseConnection();
$stmt = $conn->prepare("INSERT INTO T10_Project (T10_ProSN, T10_ProDate, T10_ProTitle, T10_ProTW, T10_ProNW) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $studentNumber, $datetime, $reportTitle, $currentProgress, $nextWeekPlan);

if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
