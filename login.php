<?php
include 'connection.php';
$conn = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    $sql = "SELECT * FROM T10_Member WHERE T10_MemSN='$username' AND T10_MemPw='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        session_start();
        $row = $result->fetch_assoc();
        $studentID = $row["T10_MemSN"];
        $_SESSION['studentID'] = $studentID;
        echo "登入成功！";
        echo '<script>window.location.href = "home_page.html";</script>';
    } else {
        echo "登入失敗，請檢查帳號和密碼。";
    }
    $conn->close();
}
