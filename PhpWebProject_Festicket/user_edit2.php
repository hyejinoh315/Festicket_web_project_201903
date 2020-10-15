<?php
session_start();
$id = $_SESSION['id'];
$conn = mysqli_connect('localhost', 'root', '1442', 'tests');

$sql_query = "SELECT * FROM users WHERE user_id='$id'"; //로그인시 입력된 아이디에 관련된 회원정보를 가져온다
$result = mysqli_query($conn, $sql_query) or die("database error:" . mysqli_error($conn));
$row = mysqli_fetch_assoc($result);

$my_pw =$row['pw'];

if (isset($_SESSION['id'])) { //세션이 존재할 경우
    if ($my_pw==$_POST['pw1']) { //현재 비밀번호 일치하는 경우
        if ($_POST['pw2']!=$_POST['pw3']){ //변경할 비밀번호 일치 확인
            echo "<meta http-equiv=refresh content=0;url=http://localhost/no3/mypage.php?id={$_GET['id']}>";//자동이동
            echo "<script>alert('변경할 비밀번호를 확인해 주세요');</script>";
            return;
        } else {
            //var_dump($_POST);
            $conn = mysqli_connect('localhost', 'root', '1442', 'tests');
//{$_GET['id']}, $_POST['img2'] 이전에 존재하던 이미지
            $chk = "SELECT pw FROM users WHERE id = '{$_GET['id']}'";
            $sql = "UPDATE users SET pw = '{$_POST['pw2']}' WHERE id = '{$_GET['id']}'";

            $result = mysqli_query($conn, $sql);

            if ($result === false) {
                echo '수정하는 과정에서 문제가 생겼습니다. 관리자에게 문의해 주세요';
                //error_rog(mysqli_error($conn)); // 아파치 에러로그 라는 곳에 기록되고 사용자에게 보이지 않는다
            } else {
                echo "<meta http-equiv=refresh content=0;url=http://localhost/no3/mypage.php?id={$_GET['id']}>";//자동이동
                echo "<script>alert(\"수정완료\");</script>";
            }
        }
    } else {//현재 비밀번호가 일치하지 않을 경우
        echo "<meta http-equiv=refresh content=0;url=http://localhost/no3/mypage.php?id={$_GET['id']}>";//자동이동
        echo "<script>alert('비밀번호를 확인해 주세요');</script>";
        return;
    }
} else {
    echo "<meta http-equiv=refresh content=0;url=http://localhost/no3>";//자동이동
    //echo "<script>alert('비정상적 접근');</script>";
    return;
}

