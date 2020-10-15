<?php
session_start();
if (!isset($_SESSION['id'])) { //세션이 존재할 경우 //echo $_SESSION['id']; -> 아이디 값이 나온다
    //로그인 하지 않은 상태로 좋아요를 누른 경우
    $_SESSION['book'] = $_GET['id'];//북마크를 위해 세션 변수를 등록해준다
    echo "<meta http-equiv=refresh content=0;url=http://localhost/no3/login.php>";//자동이동
    return;
}

$conn = mysqli_connect('localhost', 'root', '1442', 'tests');


$sql = "
    INSERT INTO bookmark
        (f_id, u_id, uni)
        VALUES (
            '{$_GET['id']}',
            '{$_SESSION['id']}',
            '{$_GET['id']}{$_SESSION['id']}'
            )
";

$result = mysqli_query($conn, $sql);

if ($result === false) {
    $sql = "SELECT uni FROM bookmark WHERE uni='{$_GET['id']}{$_SESSION['id']}'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $sql = "DELETE FROM bookmark WHERE uni='{$_GET['id']}{$_SESSION['id']}'";
        $result = mysqli_query($conn, $sql);
        {//알림팝업 띄우기
            if (isset($_GET["action"])) {
                header("location:book.php?success=1");
            }else {
                header("location:festivals_post.php?success=1&id={$_GET['id']}");
            }
        }
        if (isset($_SESSION['book'])) {
            unset($_SESSION['book']);
        }
    } else {
        echo '북마크를 수정하는 과정에서 문제가 생겼습니다. 관리자에게 문의해 주세요';
    }
} else {
    {//알림팝업 띄우기
        if (isset($_GET["action"])) {
            header("location:book.php?success=2");
        }else {
            header("location:festivals_post.php?success=2&id={$_GET['id']}");
        }
    }
    if (isset($_SESSION['book'])) {
        unset($_SESSION['book']);
    }
}
