<?php
session_start();

if ($_SESSION['isLogin'] !== true) {
    header("Location: login.php");
    exit();
}

if (!$_SESSION['isAdmin']) {
    header("Location: dashboard.php");
    exit();
}

$teacherName = $_SESSION['name'];

include 'connection.php';
$conn = getDatabaseConnection();

$accountApprovalQuery = "SELECT T10_CheSN, T10_CheN, T10_CheW FROM T10_Check WHERE T10_ChePN = ? LIMIT 3";
$stmt = $conn->prepare($accountApprovalQuery);
$stmt->bind_param("s", $teacherName);
$stmt->execute();
$accountApprovalResult = $stmt->get_result();

$groupQuery = "SELECT T10_InfTeam, GROUP_CONCAT(T10_InfName SEPARATOR ', ') as students FROM T10_Information GROUP BY T10_InfTeam";
$groupResult = $conn->query($groupQuery);

$labQuery = "SELECT T10_LabTN FROM T10_Lab WHERE T10_LabPN = ?";
$stmt = $conn->prepare($labQuery);
$stmt->bind_param("s", $teacherName);
$stmt->execute();
$labResult = $stmt->get_result();
$labTN = $labResult->fetch_assoc()['T10_LabTN'] ?? null;

if ($labTN) {
    $studentIdsQuery = "SELECT T10_InfSN FROM T10_Information WHERE T10_InfLab = ?";
    $stmt = $conn->prepare($studentIdsQuery);
    $stmt->bind_param("s", $labTN);
    $stmt->execute();
    $studentIdsResult = $stmt->get_result();
    $studentIds = [];
    while ($row = $studentIdsResult->fetch_assoc())
        $studentIds[] = $row['T10_InfSN'];
    $studentIdsString = "'" . implode("','", $studentIds) . "'";
    $progressQuery = "SELECT T10_ProDate, T10_ProTitle, T10_ProSN FROM t10_project WHERE T10_ProSN IN ($studentIdsString) ORDER BY T10_ProDate DESC LIMIT 5";
    $progressResult = $conn->query($progressQuery);
} else {
    die("无法获取实验室编号，请检查数据库配置。");
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理員個人中心</title>
    <link href="css/dashboardReview.css" rel="stylesheet">
</head>
<body>
<header>
    <div>國立虎尾科技大學</div>
    <a href="logout.php" class="logout">登出 [<?php echo $teacherName; ?> 老師]</a>
</header>
<nav>
    <a href="adminDashboard.php">個人中心</a>
    <a href="recode.php">查詢專題</a>
    <a href="browse.php">進度審核</a>
</nav>
<div class="container">
    <div class="left-section">
        <div class="section">
            <h2>學生審核</h2>
            <?php while ($row = $accountApprovalResult->fetch_assoc()): ?>
                <div>
                    <label>學號：<?php echo $row['T10_CheSN']; ?></label>
                    <label>姓名：<?php echo $row['T10_CheN']; ?></label>
                    <label>留言：</label>
                    <label>
                        <textarea readonly><?php echo $row['T10_CheW']; ?></textarea>
                    </label>
                </div>
            <?php endwhile; ?>
            <a href="adminDetail.php">更多</a>
        </div>
        <div class="section">
            <h2>組別管理</h2>
            <?php while ($group = $groupResult->fetch_assoc()): ?>
                <div>
                    <label>組別 <?php echo $group['T10_InfTeam']; ?>：<?php echo $group['students']; ?></label>
                </div>
            <?php endwhile; ?>
            <a href="editGroups.php">編輯</a>
        </div>
    </div>
    <div class="right-section">
        <div class="section">
            <h2>進度評分歷史</h2>
            <?php if ($progressResult->num_rows > 0): ?>
                <?php while ($row = $progressResult->fetch_assoc()): ?>
                    <div>
                        <label>日期：<?php echo htmlspecialchars($row['T10_ProDate']); ?></label>
                        <label>標題：<?php echo htmlspecialchars($row['T10_ProTitle']); ?></label>
                        <label>學號：<?php echo htmlspecialchars($row['T10_ProSN']); ?></label>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>無進度評分歷史</p>
            <?php endif; ?>
            <a href="allProgress.php">更多</a>
        </div>
    </div>
</div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
