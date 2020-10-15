<?php
session_start();
$id = $_SESSION['id'];
$conn = mysqli_connect('localhost', 'root', '1442', 'tests');

$sql_query = "SELECT * FROM users WHERE user_id='$id'"; //로그인시 입력된 아이디에 관련된 회원정보를 가져온다
$result = mysqli_query($conn, $sql_query) or die("database error:" . mysqli_error($conn));
$row_u = mysqli_fetch_assoc($result);

if (isset($_SESSION['id'])) { //세션이 존재할 경우 //echo $_SESSION['id']; -> 아이디 값이 나온다

} else {
    echo "<meta http-equiv=refresh content=0;url=http://localhost/no3/login.php>";//자동이동
    exit;
}

if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        include "like_edit.php";
    }
}
if (isset($_GET["success"])) {
    if ($_GET["success"] == 1) {
        $message = '북마크가 삭제되었습니다';
        include "pop.php";
    } else {
        $message = '북마크가 추가되었습니다';
        include "pop.php";
    }
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
    <h1 class="mt-4 mb-3">Bookmark
        <small></small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="mypage.php?id=<?= $row_u['id'] ?>">Menu</a></li>
        <li class="breadcrumb-item active">Bookmark</li>
    </ol>


    <hr/><!--구분선-->

    <!-- Content Row    row -->
    <div class="row">

        <?php
        include("my_menu.php");
        ?>

        <div class="col-lg-9 mb-4">
            <div class="container">

                <div class="list-group">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>MY FESTIVAL</th>
                            <th>일정</th>
                            <th>장소</th>
                            <th>기타</th>
                        </tr>
                        </thead>
                        <?php
                        ini_set('memory_limit', '-1');

                        //상시-저장된 값 보여주기
                        $conn = mysqli_connect('localhost', 'root', '1442', 'tests');
                        $sql = "SELECT f_id, img, title, date, date_end, locate FROM bookmark LEFT JOIN fesitval ON bookmark.f_id = fesitval.id WHERE u_id='$id'"; //로그인시 입력된 아이디에 관련된 회원정보를 가져온다
                        $result = mysqli_query($conn, $sql);
                        $num = mysqli_num_rows($result);

                        $page = ($_GET['page']) ? $_GET['page'] : 1;
                        $list = 11;
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

                        if (!$result->num_rows == 0) {

                            $real_data = mysqli_query($conn, "$sql LIMIT $s_point,$list");
                            $i = 1 + ($_GET['page']-1) * $list ;

                            while ($row = mysqli_fetch_array($real_data)) { // 실행할 때마다 한행씩 보여주고 값이 없으면 null 속성을 이용하여 반복문을 돌릴 수 있다
                                echo "<tbody>
                               <tr>
                                <td><img src=\"img/{$row['img']}\" height='30px'><a href=\"festivals_post.php?id={$row['f_id']}\"> {$row['title']}</a></td>
                                <td>{$row['date']}~{$row['date_end']}</td>
                                <td>{$row['locate']}</td>
                                <td><a href=\"book.php?action=delete&id={$row['f_id']}\">제거</a></td>                                
                               </tr>
                               </tbody>";
                                if ($row == false) {
                                    exit;
                                }
                            }
                            ?>
                            <!--tbody>
                            <tr>
                                <td>인덱스</td>
                                <td>페스티벌이름</td>
                                <td>오늘날짜</td>
                            </tr>
                            </tbody-->
                            <?php
                        } else if ($result->num_rows == 0) {
                            echo '
				<tr>
					<td colspan="4" align="center">북마크된 페스티벌이 없습니다</td>
				</tr>
				';
                        }
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
                <hr/>
                <div style="float: right">
                    <a class="pull-right row btn mb-4 list-grou list-group-item" style="width: auto;"
                       href="my_calendar/index.php?id=<?= $row_u['id'] ?>">내 달력보기</a>
                </div>
                <!-- Content Row
                <div class="row">

                    <div class="col-lg-3 mb-4">
                        <div class="list-group">
                            <a href="index.html" class="list-group-item">Home</a>
                            <a href="about.html" class="list-group-item">About</a>
                            <a href="services.html" class="list-group-item">Services</a>
                            <a href="contact.html" class="list-group-item">Contact</a>
                        </div>
                    </div>

                    <div class="col-lg-9 mb-4">
                        <h2>사이드바</h2>
                        <p>memo</p>
                    </div>
                </div>
                row -->

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
