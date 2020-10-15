<?php
session_start();
$id = $_SESSION['id'];
$conn = mysqli_connect('localhost', 'root', '1442', 'tests');

$sql_query = "SELECT * FROM users WHERE user_id='$id'"; //로그인시 입력된 아이디에 관련된 회원정보를 가져온다
$result = mysqli_query($conn, $sql_query) or die("database error:" . mysqli_error($conn));
$row = mysqli_fetch_assoc($result);

$my_id =$row['user_id'];
$my_pw =$row['pw'];

if (isset($_SESSION['id'])) { //세션이 존재할 경우 //echo $_SESSION['id']; -> 아이디 값이 나온다
    if ($my_pw==$_POST['pw1']) { //본인만 탈퇴가능
//var_dump($_POST);
        $conn = mysqli_connect('localhost', 'root', '1442', 'tests');
//{$_GET['id']}
        $sql = "DELETE FROM users WHERE id='{$_GET['id']}'";
        $result = mysqli_query($conn, $sql);

        if ($result === false) {
            echo '삭제하는 과정에서 문제가 생겼습니다. 관리자에게 문의해 주세요';
            //error_rog(mysqli_error($conn)); // 아파치 에러로그 라는 곳에 기록되고 사용자에게 보이지 않는다
        } else {
            session_start();
            $res = session_destroy();
            if ($res) {
                header('Location: ./index.php');
            }
            //echo "<script>alert('정상적으로 탈퇴되었습니다.');</script>";
        }
    } else {
        echo "<meta http-equiv=refresh content=0;url=http://localhost/no3/mypage.php?id={$_GET['id']}>";//자동이동
        echo "<script>alert('비밀번호를 확인해 주세요');</script>";
        return;
    }
} else {
    echo "<meta http-equiv=refresh content=0;url=http://localhost/no3>";//자동이동
    //echo "<script>alert('비정상적 접근');</script>";
    return;
}

//세션확인하고, 탈퇴시에 세션 지우고, 메인으로 돌아가게끔