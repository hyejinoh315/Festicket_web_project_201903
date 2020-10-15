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
//var_dump($_POST);
$conn = mysqli_connect('localhost', 'root', '1442', 'tests');
//{$_GET['id']}, $_POST['img2'] 이전에 존재하던 이미지

if ($_POST['img'] === "") { //바뀐 이미지가 존재하지 않는다면 이 로직으로 저장하고
    $sql = "UPDATE fesitval SET title = '{$_POST['title']}', date = '{$_POST['date']}', 
date_end = '{$_POST['date_end']}', locate = '{$_POST['locate']}', memo = '{$_POST['memo']}', 
img = '{$_POST['old_img']}', price = '{$_POST['price']}' WHERE id = '{$_GET['id']}'";
} else {
    $sql = "UPDATE fesitval SET title = '{$_POST['title']}', date = '{$_POST['date']}', 
date_end = '{$_POST['date_end']}', locate = '{$_POST['locate']}', memo = '{$_POST['memo']}', 
img = '{$_POST['img']}', price = '{$_POST['price']}' WHERE id = '{$_GET['id']}'";
}

$result = mysqli_query($conn, $sql);

if ($result === false) {
    echo '수정하는 과정에서 문제가 생겼습니다. 관리자에게 문의해 주세요';
    //error_rog(mysqli_error($conn)); // 아파치 에러로그 라는 곳에 기록되고 사용자에게 보이지 않는다
} else {
    echo "<meta http-equiv=refresh content=0;url=http://localhost/no3/sidebar.php>";//자동이동
    echo "<script>alert(\"수정완료\");</script>";
}
