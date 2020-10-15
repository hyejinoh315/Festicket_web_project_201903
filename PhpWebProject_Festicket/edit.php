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

$conn = mysqli_connect('localhost', 'root', '1442', 'tests');

$sql="SELECT*FROM fesitval WHERE id={$_GET['id']}";
$result = mysqli_query($conn, $sql); // 마이에스큐엘 서버에 던져주기

$row = mysqli_fetch_array($result);
$article = array( //키값이 문자인 배열 생성!
    'title'=>$row['title'], //페스티벌명
    'date'=>$row['date'], //운영날짜
    'date_end'=>$row['date_end'],
    'locate'=>$row['locate'], //운영장소
    'memo'=>$row['memo'], //본문
    'img'=>$row['img'], //이미지경로
    'created'=>$row['created'],
    'price'=>$row['price']
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
    <h1 class="mt-4 mb-3">Festivals
        <small>/ 수정페이지</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item active">About</li>
    </ol>

    <form action="process_edit.php?id=<?=$_GET['id']?>" method="post">
        <input type="hidden" name="old_img" value="<?=$article['img']?>">
        <p><input type="text" name="title" value="<?=$article['title']?>" placeholder="페스티벌명" style="margin: auto; width: 100%;"></p> <!--줄바꿈 태그-->
        <p>페스티벌 시작 날짜　<input type="date" name="date" value="<?=$article['date']?>"></p>
        <p>페스티벌 종료 날짜　<input type="date" name="date_end" value="<?=$article['date_end']?>"></p>
        <p><input type="text" name="locate" value="<?=$article['locate']?>" placeholder="운영장소" style="margin: auto; width: 100%;"></p>
        <p><input type="number" name="price" value="<?=$article['price']?>" placeholder="티켓금액" style="margin: auto; width: 100%;"></p>
        <p><textarea name="memo" placeholder="본문" style="margin: auto; width: 100%; height: 300px;"><?=$article['memo']?></textarea></p>
        <p>현재 이미지　　<img src="/no3/img/<?=$article['img']?>" height="50px"></p>
        <p>수정할 이미지　<input type="file" name="img" placeholder="이미지경로"></p>
        <p><input class="btn btn-primary btn-block" type="submit" value='수정하기' style="width:200px; background-color: black"></p>
    </form>

    <?php
    include("footer.php");
    ?>

</body>
</html>
