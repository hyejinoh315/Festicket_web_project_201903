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

if(isset($_POST['jsonData'])){
    $j = $_POST['jsonData'];
    $idx = $_POST['idx'];
    $no = "\"".$_POST['orderNo']."\"";
//UPDATE order_data SET order_data = JSON_SET(@j, '$[1].status', 1) WHERE order_no = "imp_630354753110"
// [{"f_id":"65","quantity":"1","status":0}] 0 "imp_741793678269"
//UPDATE order_data SET order_data = JSON_SET([{"f_id":"67","quantity":"1","status":0}], '$[0].status', 1) WHERE order_no = "imp_467656358161"

    $json_sql = "UPDATE order_data SET order_data = JSON_SET('$j', '$[$idx].status', 1) WHERE order_no = {$no} ";
    $result = mysqli_query($conn, $json_sql);
    if($result==true){
        echo $_POST['idx'];
    }
}

//if(isset($_POST['fin'])) echo $_POST['idx'];

?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">관리자메뉴
        <small>/ 결제내역 관리</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="adminpage.php?id=<?= $row['id'] ?>">Menu</a></li>
        <li class="breadcrumb-item active">Order</li>
    </ol>


    <hr/><!--구분선-->

    <!-- Content Row    row -->
    <div class="row">

        <?php
        include("admin_sidebar.php");
        ?>

        <div class="col-lg-9 mb-4">
            <div class="container">

                <div class="list-group">

                    <div>
                        <form method="get" action="order.php">
                            <input type="text" name="search" id="search" placeholder="결제내역 찾기">
                            <input type="submit" value="검색">
                        </form>
                        <p></p>
                    </div>

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>주문번호(ID)</th>
                            <th>구매정보</th>
                        </tr>
                        </thead>
                        <?php
                        ini_set('memory_limit', '-1');
                        //상시-저장된 값 보여주기
                        $conn = mysqli_connect('localhost', 'root', '1442', 'tests');
                        $sql = "SELECT * FROM order_data ORDER BY id DESC";
                        if(isset($_GET["search"])) { //검색어 존재하면 검색한 결과만 찾아서 보여준다
                            $sql = "SELECT * FROM order_data WHERE order_no LIKE \"%{$_GET["search"]}%\" OR u_id LIKE \"%{$_GET["search"]}%\" ORDER BY id DESC";
                        }
                        $result = mysqli_query($conn, $sql);
                        $num = mysqli_num_rows($result);

                        $page = ($_GET['page']) ? $_GET['page'] : 1;
                        $list = 5;
                        $block = 10;

                        $pageNum = ceil($num / $list); // 총 페이지
                        $blockNum = ceil($pageNum / $block); // 총 블록
                        $nowBlock = ceil($page / $block);

                        $s_page = ($nowBlock * $block) - ($block - 1);
                        if ($s_page <= 1) {
                            $s_page = 1;
                        }
                        $e_page = $nowBlock * $block;
                        if ($pageNum <= $e_page) {
                            $e_page = $pageNum;
                        }

                        if ($_GET['page'] <= 1) {
                            $_GET['page'] = 1;
                        }
                        if ($pageNum <= $_GET['page']) {
                            $_GET['page'] = $pageNum;
                        }
                        $s_point = ($page - 1) * $list;

                        $real_data = mysqli_query($conn, "$sql LIMIT $s_point,$list");
                        $i = 1 + ($_GET['page']-1) * $list ;
                        include("order_data.php");
                        ?>
                    </table>
                    <div align="center">
                        <a href="<?= $PHP_SELP ?>?page=1"
                            <?php if($_GET['page']==1){echo "hidden";}?>>시작페이지</a>&nbsp;
                        <a href="<?= $PHP_SELP ?>?page=<?= $_GET['page'] - $block ?>"
                            <?php if($_GET['page']==1){echo "hidden";}?>><<</a>&nbsp;
                        <a href="<?= $PHP_SELP ?>?page=<?= $_GET['page'] - 1 ?>"
                            <?php if($_GET['page']==1){echo "hidden";}?>><</a>
                        <?php
                        for ($p = $s_page; $p <= $e_page; $p++) {
                            ?>
                            &nbsp;<a href="<?= $PHP_SELP ?>?page=<?= $p ?>"
                                <?php if($_GET['page']==$p){echo "style='font-size: 20px; color: black;'";}?>><?= $p ?></a>&nbsp;
                            <?php
                        }
                        ?>
                        <a href="<?= $PHP_SELP ?>?page=<?= $_GET['page'] + 1 ?>"
                            <?php if($_GET['page']==$pageNum){echo "hidden";}?>>></a>&nbsp;
                        <a href="<?= $PHP_SELP ?>?page=<?= $_GET['page'] + $block ?>"
                            <?php if($_GET['page']==$pageNum){echo "hidden";}?>>>></a>&nbsp;
                        <a href="<?= $PHP_SELP ?>?page=<?= $pageNum ?>"
                            <?php if($_GET['page']==$pageNum){echo "hidden";}?>>마지막페이지</a>
                    </div>

                </div>
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
