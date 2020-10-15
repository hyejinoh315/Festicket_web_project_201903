<?php
//var_dump($_POST);
$tel = preg_replace("/[^0-9]*/s", "", $_POST['userPhone']);
//문자열에서 숫자만 추출하는 함수
/*$length = strlen($tel);
switch ($length) {
    case 11:
        $tel = preg_replace("/([0-9]{3})([0-9]{4})([0-9]{4})/", "$1$2$3", $tel);
        break;
    case 10:
        $tel = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1$2$3", $tel);
        break;
}//echo "정보확인:".$_POST['userId']."/".$_POST['userPass']."/".$_POST['userName']."/".$tel."/".$_POST['birthday'];
*/
$conn = mysqli_connect('localhost', 'root', '1442', 'tests');
//저장하고 돌아오면 실행
$sql = "
    INSERT INTO users
        (user_id, pw, name, tel)
        VALUES (
            '{$_POST['userId']}',
            '{$_POST['userPass']}',
            '{$_POST['userName']}',
            '{$tel}'
            )
";
$result = mysqli_query($conn, $sql);
if($result === false){
    echo '가입하는 과정에서 문제가 생겼습니다. 관리자에게 문의해 주세요';
    //error_rog(mysqli_error($conn)); // 아파치 에러로그 라는 곳에 기록되고 사용자에게 보이지 않는다
} else {
    //echo "<script>alert(\"가입 완료<a href=\"index.php\">돌아가기</a>\");</script>";
    //echo '가입 완료 <a href="index.php">돌아가기</a>';
    echo "<meta http-equiv=refresh content=0;url=http://localhost/no3/login.php>";//자동이동
    echo "<script>alert(\"가입이 완료 되었습니다. 로그인 후 더 많은 혜택을 누려보세요!\");</script>";
}
