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
?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">관리자메뉴
        <small>/ 게시글 관리</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="adminpage.php?id=<?= $row['id'] ?>">Menu</a></li>
        <li class="breadcrumb-item active">Festivals</li>
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

                    <div> <!--검색어를 get 값으로 넘겨서 변수에 담는다-->
                        <form method="get" action="sidebar.php">
                            <input type="text" name="search" id="search" placeholder="페스티벌 찾기">
                            <input type="submit" value="검색">
                        </form>
                        <p></p>
                    </div>

                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>사진</th>
                            <th>제목</th>
                            <th>작성시간</th>
                            <th>기타</th>
                        </tr>
                        </thead>
                        <?php
                        ini_set('memory_limit', '-1');

                        //상시-저장된 값 보여주기
                        $conn = mysqli_connect('localhost', 'root', '1442', 'tests');
                        $sql = "SELECT * FROM fesitval ORDER BY id DESC"; //검색어 변수 값이 존재하지 않을때의 쿼리문 -> 모든 데이터를 보여준다

                        // 검색어 변수 = $_GET["search"]
                        if(isset($_GET["search"])){ //검색어 존재하면 검색한 결과만 찾아서 보여준다
                            $sql = "SELECT * FROM fesitval WHERE title LIKE \"%{$_GET["search"]}%\" ORDER BY id DESC";
                        }
                        $result = mysqli_query($conn, $sql);
                        $num = mysqli_num_rows($result);

                        $page = ($_GET['page']) ? $_GET['page'] : 1;
                        $list = 10;
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

                        $i = $result->num_rows + 1;

                        $real_data = mysqli_query($conn, "$sql LIMIT $s_point,$list");
                        $i = ($_GET['page']-1) * $list ;

                        while ($row = mysqli_fetch_array($real_data)) { // 실행할 때마다 한행씩 보여주고 값이 없으면 null 속성을 이용하여 반복문을 돌릴 수 있다
                            $i++;
                            echo "<tbody>
                               <tr>
                                <td> $i </td>
                                <td><img src=\"img/{$row['img']}\" height='30px'></></td>
                                <td><a href=\"festivals_post.php?id={$row['id']}\">{$row['title']}</a></td>
                                <td>{$row['created']}</td>
                                <td><a href=\"edit.php?id={$row['id']}\">수정 </a>|<a href=\"process_delete.php?id={$row['id']}\" 
                                onclick=\"return confirm('게시글을 삭제합니다.');\"> 삭제</a></td>
                               </tr>
                               </tbody>";
                        }
                        ?>
                        <!--tbody>
                        <tr>
                            <td>인덱스</td>
                            <td>페스티벌이름</td>
                            <td>오늘날짜</td>
                        </tr>
                        </tbody-->
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
                <div align="right">
                    <a class="pull-right row btn mb-4 list-grou list-group-item"
                       style="width: 80px" href="create.php">추가</a>
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
