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

$teacherName = $_SESSION['name'];

$accountApprovalQuery = "SELECT T10_CheSN, T10_CheN, T10_ChePN, T10_CheW FROM T10_Check WHERE T10_ChePN = ?";
$stmt = $conn->prepare($accountApprovalQuery);
$stmt->bind_param("s", $teacherName);
$stmt->execute();
$accountApprovalResult = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理員個人中心</title>
    <link href="css/adminDashboard.css" rel="stylesheet">
</head>
<body>
<header>
    <div>國立虎尾科技大學</div>
    <a href="logout.php" class="logout">登出 [<?php echo $teacherName; ?> 老師]</a>
</header>
<nav>
    <a href="adminDetail.php">個人中心</a>
    <a href="recode.php">查詢專題</a>
    <a href="#">進度審核</a>
</nav>
<nav>
    <a href="adminDashboard.php">返回</a>
</nav>
<div class="content">
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
                <form action="updatePermission.php" method="post">
                    <input type="hidden" name="username" value="<?php echo $row['T10_CheSN']; ?>">
                    <input type="hidden" name="student_name" value="<?php echo $row['T10_CheN']; ?>">
                    <input type="hidden" name="teacher_name" value="<?php echo $teacherName; ?>">
                    <button type="submit" name="action" value="accept" class="accept">接受</button>
                    <button type="submit" name="action" value="reject" class="reject">拒絕</button>
                </form>
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
