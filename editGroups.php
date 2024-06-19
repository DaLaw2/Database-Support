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

$teacherName = $_SESSION['name'];

include 'connection.php';
$conn = getDatabaseConnection();

$teacherQuery = "SELECT T10_LabTN FROM T10_Lab WHERE T10_LabPN = ?";
$stmt = $conn->prepare($teacherQuery);
$stmt->bind_param("s", $teacherName);
$stmt->execute();
$teacherResult = $stmt->get_result();
$labID = $teacherResult->fetch_assoc()['T10_LabTN'];

$studentsQuery = "SELECT T10_InfSN, T10_InfName, T10_InfTeam FROM T10_Information WHERE T10_InfLab = ?";
$stmt = $conn->prepare($studentsQuery);
$stmt->bind_param("s", $labID);
$stmt->execute();
$studentsResult = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編輯組別</title>
    <link href="css/editGroups.css" rel="stylesheet">
</head>
<body>
<header>
    <div>國立虎尾科技大學</div>
    <a href="#" class="logout">登出 [<?php echo $_SESSION['teacher_name']; ?> 老師]</a>
</header>
<nav>
    <a href="dashboardReview.php">返回</a>
</nav>
<div class="content">
    <div class="section">
        <h2>編輯組別</h2>
        <form action="updateGroups.php" method="post">
            <?php while ($student = $studentsResult->fetch_assoc()): ?>
                <div>
                    <label>學生：<?php echo $student['T10_InfName']; ?></label>
                    <label>組別：</label>
                    <select name="group_<?php echo $student['T10_InfSN']; ?>">
                        <option value="" <?php echo is_null($student['T10_InfTeam']) ? 'selected' : ''; ?>>選擇組別
                        </option>
                        <option value="1" <?php echo $student['T10_InfTeam'] == 1 ? 'selected' : ''; ?>>1</option>
                        <option value="2" <?php echo $student['T10_InfTeam'] == 2 ? 'selected' : ''; ?>>2</option>
                        <option value="3" <?php echo $student['T10_InfTeam'] == 3 ? 'selected' : ''; ?>>3</option>
                        <option value="4" <?php echo $student['T10_InfTeam'] == 4 ? 'selected' : ''; ?>>4</option>
                    </select>
                </div>
            <?php endwhile; ?>
            <button type="submit" class="update">更新組別</button>
        </form>
    </div>
</div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
