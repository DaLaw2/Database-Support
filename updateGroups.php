<?php
session_start();

if ($_SESSION['isLogin'] !== true) {
    header("Location: login.html");
    exit();
}

if (!$_SESSION['isAdmin']) {
    header("Location: dashboard.php");
    exit();
}

include 'connection.php';
$conn = getDatabaseConnection();

foreach ($_POST as $key => $value) {
    if (strpos($key, 'group_') === 0) {
        $studentId = str_replace('group_', '', $key);
        $newGroupId = intval($value);
        $updateQuery = "UPDATE T10_Information SET T10_InfTeam = ? WHERE T10_InfSN = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("is", $newGroupId, $studentId);
        $stmt->execute();
    }
}
$conn->close();
header("Location: dashboardReview.php");
exit;
