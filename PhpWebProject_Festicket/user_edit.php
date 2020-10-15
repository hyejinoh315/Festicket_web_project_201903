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
            <h2><?= $row['user_id'] ?>님 비밀번호 변경</h2>
            <p>정보 수정</p>
            <div class="list-group">
                <form action="user_edit2.php?id=<?= $_GET['id'] ?>" method="post">
                    <p>현재 비밀번호　　　 <input type="password" id="pw1" name="pw1"></p>
                    <p>변경할 비밀번호　　 <input type="password" id="pw2" name="pw2"></p>
                    <p>변경 비밀번호 확인　<input type="password" id="pw3" name="pw3"></p>
                    <p><input class="btn btn-primary btn-block" id="editbutton" type="submit" value='수정하기'
                              style="width:200px; background-color: black; border: black"></p>
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
<script>
    var sign = doc.getElementById('editbutton');

    var func = function () {
        var doc = document;

        //1. 정보를 전부 취합한다
        var pw1 = doc.getElementById('pw1').value;
        var pw = doc.getElementById('pw2').value;
        var pwchk = doc.getElementById('pw3').value;

        if (!pw1) {
            alert('항목을 전부 입력해 주세요');
            //커서 이동
            doc.getElementById('pw1').focus();
            return;
        }
        if (!pw) {
            alert('항목을 전부 입력해 주세요');
            //커서 이동
            doc.getElementById('pw2').focus();
            return;
        }
        if (!pwchk) {
            alert('항목을 전부 입력해 주세요');
            //커서 이동
            doc.getElementById('pw3').focus();
            return;
        }

        if (pw != pwchk) {
            alert('비밀번호가 서로 다릅니다');
            //비밀번호를 공백으로 만든다
            doc.getElementById('pw2').value = '';
            doc.getElementById('pw3').value = '';
            doc.getElementById('pw2').focus();
            return;
        }
    }sign.addEventListener('submit',func);
</script>

</body>

</html>
