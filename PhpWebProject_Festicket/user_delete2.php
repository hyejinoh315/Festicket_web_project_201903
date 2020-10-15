<?php
session_start();

if (isset($_SESSION['id'])) { //세션이 존재할 경우 //echo $_SESSION['id']; -> 아이디 값이 나온다
} else {
    echo "<meta http-equiv=refresh content=0;url=http://localhost/no3>";//자동이동
    //echo "<script>alert('로그인 후 이용할 수 있습니다');</script>";
    exit;
}
$id = $_SESSION['id'];
$conn = mysqli_connect('localhost', 'root', '1442', 'tests');

$sql_query = "SELECT * FROM users WHERE user_id='$id'"; //로그인시 입력된 아이디에 관련된 회원정보를 가져온다
$result = mysqli_query($conn, $sql_query) or die("database error:" . mysqli_error($conn));
$row = mysqli_fetch_assoc($result);

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
    <link href="css/bootstrap.css" rel="stylesheet">

    <!--페이지네이션-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="js/bootstrap-table-pagination.js"></script>
    <script src="js/pagination.js"></script>

</head>

<body>

<?php
include("navbar.php");
?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">My Page
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item active">About</li>
    </ol>


    <hr/><!--구분선-->

    <!-- Content Row    row -->
    <div class="row">

        <?php
        include("my_menu.php");
        ?>

        <div class="col-lg-9 mb-4">
            <h2>회원 탈퇴 페이지</h2>
            <p><?= $row['user_id'] ?>님 탈퇴 후에는 복구할 수 없습니다. 확인 후 탈퇴를 진행해 주세요.</p>
            <div class="list-group">
                <form action="user_delete.php?id=<?= $_GET['id'] ?>" method="post">
                    <input type="hidden" name="my_id" value="<?= $row['user_id'] ?>">
                    <p>비밀번호　　　 <input type="password" id="pw1" name="pw1"></p>
                    <p><input class="btn btn-primary btn-block" id="editbutton" type="submit" value='탈퇴하기'
                              style="width:200px; background-color: black; border: black" onclick="return confirm('정말 탈퇴하시겠습니까?')"></p>
                </form>
            </div>
        </div>
    </div>


</div>
<!-- /.container -->

<?php
include("footer.php");
?>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
