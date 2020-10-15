<?php
session_start();
$id = $_SESSION['id'];
$conn = mysqli_connect('localhost', 'root', '1442', 'tests');

$sql_query = "SELECT * FROM users WHERE user_id='$id'"; //로그인시 입력된 아이디에 관련된 회원정보를 가져온다
$result = mysqli_query($conn, $sql_query) or die("database error:" . mysqli_error($conn));
$row = mysqli_fetch_assoc($result);
if (isset($_SESSION['id'])) { //세션이 존재할 경우 //echo $_SESSION['id']; -> 아이디 값이 나온다
    if ($row['is_admin'] == 2) { //일반 회원인 경우 메인페이지로
        echo "<meta http-equiv=refresh content=0;url=http://localhost/no3>";//자동이동
        exit;
    }
} else {//로그인하지 않은 경우 로그인 페이지로
    echo "<meta http-equiv=refresh content=0;url=http://localhost/no3/login.php>";//자동이동
    exit;
}
?>

<div class="col-lg-3 mb-4">
    <div class="list-group">
        <a href="ad_admin.php" class="list-group-item">광고관리</a>
        <a href="sidebar.php" class="list-group-item">게시글관리</a>
        <a href="membership.php" class="list-group-item">회원관리</a>
        <a href="order.php" class="list-group-item">결제내역관리</a>
    </div>
</div>