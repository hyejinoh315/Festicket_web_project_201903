<?php
session_start();
//inputEmail inputPassword
$id=$_POST['id'];
$pw=$_POST['pw'];

$conn = mysqli_connect('localhost', 'root', '1442', 'tests');
$sql="SELECT * FROM users WHERE user_id='$id'";

$result=$conn->query($sql);
if($result->num_rows==1){
    $row=$result->fetch_array(MYSQLI_ASSOC); //하나의 배열로 가져오기
    if($row['pw']==$pw){ //MYSQLI_ASSOC 필드명으로 첨자 가능
        $_SESSION['id']=$id;
        if(isset($_SESSION['id'])&&isset($_SESSION['book'])){
            echo "<script>location.href=\"http://localhost/no3/festivals_post.php?id={$_SESSION['book']}\";</script>";
        }elseif (isset($_SESSION['id'])&&isset($_SESSION['cart'])){
            echo "<script>location.href=\"http://localhost/no3/cart/\";</script>";
        }elseif (isset($_SESSION['id'])){
            //echo "<meta http-equiv=refresh content=0;url=http://localhost/no3/>";//자동이동
            echo "<script>history.go(-2);</script>";
            //header('Location: ./index.php');
        }
        else{
            echo "로그인 실패 / 세션 저장 실패";
        }
    }else{
        echo "<script>alert(\"ID 와 PW 를 확인해 주세요\");</script>";
    }
}else{
    echo "<script>alert(\"존재하지 않는 ID 입니다\");history.back();</script>";
}

