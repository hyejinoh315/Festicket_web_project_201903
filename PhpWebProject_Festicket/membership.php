<?php
session_start();
$id = $_SESSION['id'];
$conn = mysqli_connect('localhost', 'root', '1442', 'tests');
$sql = "SELECT * FROM users";

$sql_query = "$sql WHERE user_id='$id'"; //로그인시 입력된 아이디에 관련된 회원정보를 가져온다
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
?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">관리자메뉴
        <small>/ 회원 관리</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="adminpage.php?id=<?= $row['id'] ?>">Menu</a></li>
        <li class="breadcrumb-item active">Membership</li>
    </ol>


    <hr/><!--구분선-->

    <!-- Content Row    row -->
    <div class="row">

        <?php
        include("admin_sidebar.php");
        ?>

        <div class="col-lg-9 mb-4">
            <div class="list-group">

                <div>
                    <form method="get" action="membership.php">
                        <input type="text" id="search" name="search" placeholder="회원 찾기">
                        <input type="submit" value="검색">
                    </form>
                    <p></p>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>이름</th>
                            <th>전화번호</th>
                            <th>생년월일</th>
                            <th>회원등급</th>
                            <th>기타</th>
                        </tr>
                        </thead>
                        <?php
                        ini_set('memory_limit', '-1');

                        $conn = mysqli_connect('localhost', 'root', '1442', 'tests');
                        if(isset($_GET["search"])) { //검색어 존재하면 검색한 결과만 찾아서 보여준다
                            $sql = "SELECT * FROM users WHERE user_id LIKE \"%{$_GET["search"]}%\" OR name LIKE \"%{$_GET["search"]}%\" OR tel LIKE \"%{$_GET["search"]}%\"";
                        }
                        $data = mysqli_query($conn, "$sql");
                        $num = mysqli_num_rows($data);

                        $page = ($_GET['page']) ? $_GET['page'] : 1;
                        $list = 15;
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

//                        echo "현재 페이지는" . $page . "<br/>";
//                        echo "현재 블록은" . $nowBlock . "<br/>";
//
//                        echo "현재 블록의 시작 페이지는" . $s_page . "<br/>";
//                        echo "현재 블록의 끝 페이지는" . $e_page . "<br/>";
//Q
//                        echo "총 페이지는" . $pageNum . "<br/>";
//                        echo "총 블록은" . $blockNum . "<br/>";

                        $s_point = ($page - 1) * $list;
                        ?>
                        <tbody id="developers">
                        <?php
                        $real_data = mysqli_query($conn, "$sql LIMIT $s_point,$list");
                        $i = 1 + ($_GET['page']-1) * $list ;
                        while ($fetch = mysqli_fetch_array($real_data)) {
                            ?>
                            <tr>
                                <td><?= $i++?></td>
                                <td><?= $fetch['user_id'] ?></td>
                                <td><?= $fetch['name'] ?></td>
                                <td><?= $fetch['tel'] ?></td>
                                <td><?= $fetch['birth'] ?></td>
                                <td><?= $fetch['is_admin'] ?></td>
                                <td><a href=#>등급 수정 </a></td>
                            </tr>

                            <?php
                            if ($fetch == false) {
                                exit;
                            }
                        }
                        ?>
                        </tbody>
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
