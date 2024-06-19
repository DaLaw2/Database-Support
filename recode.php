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

$adminName = $_SESSION['name'];
$labID = $_SESSION['labID'];

include 'connection.php';
$conn = getDatabaseConnection();

$sql_projects = "SELECT T10_TeamYear, T10_TeamName FROM T10_Team 
                 WHERE T10_TeamLabNum='$labID' ORDER BY T10_TeamYear DESC";
$result_projects = $conn->query($sql_projects);
$projects = [];
$years = [];
while ($row_projects = $result_projects->fetch_assoc()) {
    $projects[] = $row_projects;
    if (!in_array($row_projects['T10_TeamYear'], $years)) {
        $years[] = $row_projects['T10_TeamYear'];
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>歷年專題</title>
    <link rel="stylesheet" href="css/generalStyle.css">
    <link rel="stylesheet" href="css/recode.css">
</head>
<body>
<div class="header">
    <div class="left-buttons">
        <button onclick="location.href='adminDashboard.php'">個人中心</button>
        <button onclick="location.href='recode.php'">查詢專題</button>
        <button onclick="location.href='browse.php'">進度審核</button>
    </div>
    <div class="right-button">
        <button onclick="location.href='logout.php'">登出</button>
        <span><?php echo $adminName; ?></span>
    </div>
</div>
<div class="content">
    <div class="projects-container">
        <div class="projects-list box">
            <div class="filter-container">
                <select id="yearFilter" onchange="filterProjectsByYear()">
                    <option value="">所有年度</option>
                    <?php foreach ($years as $year) {
                        echo "<option value='$year'>$year</option>";
                    } ?>
                </select>
                <div class="search-container">
                    <input type="text" id="search" onkeyup="filterProjects()" placeholder="查詢專題...">
                </div>
            </div>
            <ul id="projects">
                <?php foreach ($projects as $project) {
                    echo "<li data-year='{$project['T10_TeamYear']}'>[{$project['T10_TeamYear']}] {$project['T10_TeamName']}</li>";
                } ?>
            </ul>
        </div>
    </div>
</div>
<script>
    function filterProjects() {
        const query = document.getElementById('search').value.toLowerCase();
        const projects = document.getElementById('projects').getElementsByTagName('li');
        for (let i = 0; i < projects.length; i++) {
            const project = projects[i].textContent.toLowerCase();
            projects[i].style.display = project.includes(query) ? '' : 'none';
        }
    }

    function filterProjectsByYear() {
        const selectedYear = document.getElementById('yearFilter').value;
        const projects = document.getElementById('projects').getElementsByTagName('li');
        for (let i = 0; i < projects.length; i++) {
            const projectYear = projects[i].getAttribute('data-year');
            projects[i].style.display = (selectedYear === "" || projectYear === selectedYear) ? '' : 'none';
        }
    }
</script>
</body>
</html>
