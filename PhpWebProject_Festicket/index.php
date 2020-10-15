<?php
//$duration = 24 * 60 * 60 * 30;  // 30일
//ini_set('session.gc_maxlifetime', $duration);
//session_set_cookie_params($duration);
session_start();
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
</head>


<?php
include("navbar.php");
?>

<header>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"
        <?php
        if($_GET['page']>1){
            echo "hidden";
        }
        ?>>
        <ol class="carousel-indicators">
            <!--움직이는 사진 밑의 흰색 바-->
            <?php
            $conn = mysqli_connect('localhost', 'root', '1442', 'tests');
            $sql = "SELECT * FROM ad";
            $result = mysqli_query($conn, $sql);
            $i = 0;
            while ($row = mysqli_fetch_array($result)) { ?>
                <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" <?php if ($i == 0) {
                    echo "class=\"active\"";
                } ?>></li>
                <?php $i++;
            } ?>
        </ol>
        <div class="carousel-inner" role="listbox">
            <?php
            $conn = mysqli_connect('localhost', 'root', '1442', 'tests');
            $sql = "SELECT * FROM ad";
            $result = mysqli_query($conn, $sql);
            $i = 0;
            while ($row = mysqli_fetch_array($result)) { ?>
                <!-- Slide One - Set the background image for this slide in the line below -->
                <div class="carousel-item <?php if ($i == 0) {
                    echo "active";
                } ?>"
                     style="background-image: url('<?php echo $row['img']; ?>')">
                    <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.5);">
                        <!--a href="#" style="color: #ffffff"-->
                        <h3><?php echo $row['title']; ?></h3>
                        <p><?php echo $row['memo']; ?></p>
                        </a>
                    </div>
                </div>
                <?php $i++;
            } ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</header>
<!--php 동작 확인
   현재시간(php 동작 확인): <b> <? date_default_timezone_set("Asia/Seoul");
echo date("Y-m-d H:i:s") ?></b>-->

<p>
<form method="get" action="index.php" style="margin-left: 80%">
    <input type="text" name="search" id="search" placeholder="페스티벌 찾기">
    <input type="submit" value="검색">
</form>
<!-- Page Content -->
<div class="container card-body">
    <!-- Portfolio Section -->
    <h1 style="font-family:monospace; font-style:revert; float: left;">FESTIVALS</h1>

    <!-- 페스티벌 검색창 -->
    <span class="col-md-5 card-body input-group">
        <input type="hidden" class="form-control" placeholder="Search for...">
          <span class="input-group-btn">
              <button class="btn btn-secondary" type="button" style="background-color: white; border: white"></button>
          </span>
      </span>

    <div class="row">
        <?php
        //상시-저장된 값 보여주기
        $conn = mysqli_connect('localhost', 'root', '1442', 'tests');
        $sql = "SELECT * FROM fesitval ORDER BY date DESC";
        // 검색어 변수 = $_GET["search"]
        if(isset($_GET["search"])){ //검색어 존재하면 검색한 결과만 찾아서 보여준다
            $sql = "SELECT * FROM fesitval WHERE title LIKE \"%{$_GET["search"]}%\" ORDER BY date DESC";
        }
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);

        $page = ($_GET['page']) ? $_GET['page'] : 1;
        $list = 6;
        $block = 3;

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

        $result = mysqli_query($conn, "$sql LIMIT $s_point,$list");
        $i = 1 + ($_GET['page']-1) * $list ;

        include('data.php');
        ?>
    </div>

    <!-- 페이지 맨 위로
    <div id="gototop">
        ▲GO TO TOP▲
    </div>
     -->

    <div align="center">
        <a href="<?= $PHP_SELP ?>?page=1"
            <?php if($_GET['page']==1){echo "hidden";}?>>처음으로</a>&nbsp;
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
            <?php if($_GET['page']==$pageNum){echo "hidden";}?>>끝으로</a>
    </div>

</div>
<!-- /.container -->
<?php
include("footer.php");
?>
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!--script>
    $(function () {
        $("#gototop").on("click",function (e) {
            $('html,body').animate({
                scrollTop:690
            },200);
        });
    });
</script-->

</body>
</html>
