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

$username = $_SESSION['name'];

include 'connection.php';
$conn = getDatabaseConnection();

$teacherQuery = "SELECT T10_LabTN FROM T10_Lab WHERE T10_LabPN = ?";
$stmt = $conn->prepare($teacherQuery);
$stmt->bind_param("s", $username);
$stmt->execute();
$teacherResult = $stmt->get_result();
$labID = $teacherResult->fetch_assoc()['T10_LabTN'];

$studentsQuery = "SELECT T10_InfSN, T10_InfName, T10_InfTeam FROM T10_Information WHERE T10_InfLab = ?";
$stmt = $conn->prepare($studentsQuery);
$stmt->bind_param("s", $labID);
$stmt->execute();
$studentsResult = $stmt->get_result();
$InfSN = $studentsResult->fetch_assoc()['T10_InfSN'];

$progressQuery = "SELECT T10_ProDate, T10_ProTitle, T10_ProSN, T10_ProPass FROM T10_Project WHERE T10_ProSN = ?";
$stmt = $conn->prepare($progressQuery);
$stmt->bind_param("s", $InfSN);
$stmt->execute();
$progressResult = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>所有進度評分歷史</title>
    <link href="css/allProgress.css" rel="stylesheet">
</head>
<body>
<header>
    <div>國立虎尾科技大學</div>
    <a href="#" class="logout">登出 [<?php echo htmlspecialchars($username); ?> 老師]</a>
</header>
<nav>
    <a href="adminDashboard.php">返回</a>
</nav>
<div class="content">
    <div class="section">
        <h2>所有進度評分歷史</h2>
        <?php while ($progress = $progressResult->fetch_assoc()): ?>
            <div>
                <label>日期：<?php echo $progress['T10_ProDate']; ?></label>
                <label>標題：<?php echo $progress['T10_ProTitle']; ?></label>
                <label>學號：<?php echo $progress['T10_ProSN']; ?></label>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
