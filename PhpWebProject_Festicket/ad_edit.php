<?php
session_start();
$id = $_SESSION['id'];
$conn = mysqli_connect('localhost', 'root', '1442', 'tests');

$sql_query = "SELECT * FROM users WHERE user_id='$id'"; //로그인시 입력된 아이디에 관련된 회원정보를 가져온다
$result = mysqli_query($conn, $sql_query) or die("database error:" . mysqli_error($conn));
$row = mysqli_fetch_assoc($result);

if (isset($_SESSION['id'])) { //세션이 존재할 경우 //echo $_SESSION['id']; -> 아이디 값이 나온다
    if($row['is_admin']==2){ //일반 회원인 경우 메인페이지로
        echo "<meta http-equiv=refresh content=0;url=http://localhost/no3>";//자동이동
        exit;
    }
}else{//로그인하지 않은 경우 로그인 페이지로
    echo "<meta http-equiv=refresh content=0;url=http://localhost/no3/login.php>";//자동이동
    exit;
}

$sql = "SELECT * FROM ad WHERE id = {$_GET['id']}";
$result = mysqli_query($conn, $sql); // 마이에스큐엘 서버에 던져주기

$row = mysqli_fetch_array($result);
$article = array( //키값이 문자인 배열 생성!
    'title'=>$row['title'], //광고 타이틀
    'memo'=>$row['memo'], //광고 내용
    'img'=>$row['img'], //이미지경로
);

?>

<!DOCTYPE html>
<html lang="en; ko">

<head>

    <!--한국어 쓰려면 꼭 기재-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>FESTICKET</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css"

</head>

<body>

<?php
include("navbar.php");
?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">A D
        <small>/ 등록페이지</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item active">About</li>
    </ol>

    <form method="post">
        <p><input type="text" name="title" value="<?=$article['title']?>" placeholder="광고 타이틀" style="margin: auto; width: 100%;"></p> <!--줄바꿈 태그-->
        <p><textarea name="memo" style="margin: auto; width: 100%; height: 300px;"><?=$article['memo']?></textarea></p>
        <p>현재 이미지 <img src="<?=$article['img']?>" height='30px'><!--input type="text" name="img" value="<?=$article['img']?>" placeholder="이미지경로" style="margin: auto; width: 100%;"--></p>
        <p>수정할 이미지 <input type="file" name="img2" placeholder="이미지경로" ></p>
        <p><input class="btn btn-primary btn-block" name="editBtn" type="submit" value='수정하기' style="width:200px; background-color: black"></p>
        <input type="hidden" name="id" value="<?=$_GET['id']?>">
    </form>

    <?php

    if (isset($_POST['editBtn'])){
        $sql = "UPDATE ad SET title = '{$_POST['title']}', memo = '{$_POST['memo']}' WHERE id ={$_GET['id']}";
        $result = mysqli_query($conn, $sql);
        if($result)
        echo "<meta http-equiv=refresh content=0;url=http://localhost/no3/ad_admin.php>";//자동이동
    }

    include("footer.php");
    ?>

</body>
</html>
