<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '1442', 'tests');

$sql = "SELECT*FROM fesitval WHERE id={$_GET['id']}";
$result = mysqli_query($conn, $sql); // 마이에스큐엘 서버에 던져주기
//print_r($sql); //확인
//print_r($result); //확인

$row = mysqli_fetch_array($result);
$article = array( //키값이 문자인 배열 생성!
    'title' => $row['title'], //페스티벌명
    'date' => $row['date'], //운영날짜
    'date_end' => $row['date_end'],
    'locate' => $row['locate'], //운영장소
    'memo' => $row['memo'], //본문
    'img' => $row['img'], //이미지경로
    'created' => $row['created'],
    'price' => $row['price'],
    'id' => $row['id']
);
//print_r($article); //확인하는메소드
//<?=$article['변수명']

if (isset($_POST["bookmark"])) {
    include "like_edit.php";
}
if (isset($_SESSION['book'])) {
    include "like_edit.php";
}
if (isset($_GET["success"])) {
    if ($_GET["success"] == 1) {
        $message = '북마크가 삭제되었습니다';
        include "pop.php";
    }else{
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

</head>

<body>

<?php
include("navbar.php");
?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">Festivals
        <small>
            /
            <?= $article['title'] ?>
        </small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item active"><?php
            if (!isset($_SESSION['id'])) { //세션이 존재하지 않을 경우
                echo "Festivals";
            } else { //세션이 존재하는 경우
                if($row['is_admin']==2){ //일반 회원인 경우
                    echo "Festivals";
                }else{ //관리자일경우
                    echo "<a href='sidebar.php'>게시판 메뉴로 이동</a>";
                }
            } ?></li>
    </ol>

    <!-- Portfolio Item Row -->
    <div class="row">

        <div class="col-md-8">
            <img class="img-fluid" src="img/<?= $article['img'] ?>" alt="">
        </div>

        <div class="col-md-4">
            <!--h3 class="my-3">일번</h3>
            <p>일번내용</p-->
            <h3 class="my-3"><?= $article['title'] ?></h3>
            <ul>
                <p>
                <li>
                    <dir style="font-size: large; font-weight: bold">운영 날짜</dir>
                    <?= $article['date'] ?> ~ <?= $article['date_end'] ?></li>
                </p>
                <p>
                <li>
                    <dir style="font-size: large; font-weight: bold">운영 장소</dir>
                    <?= $article['locate'] ?></li>
                </p>
                <p>
                <li>
                    <dir style="font-size: large; font-weight: bold">금액</dir>
                    <dir class="text-danger">￦ <?= number_format($article['price']) ?></dir></li>
                </p>
            </ul>
            <br>
            <p><form action="festivals_post.php?id=<?= $article['id'] ?>" method="post">
                    <button class="btn" id="like" type="submit" name="bookmark">
                        <img style="width: 50px; height: 50px" class="btn-img" src="img/like.png">
                        <?php
                        $conn2 = mysqli_connect('localhost', 'root', '1442', 'tests');
                        $sql2 = "SELECT COUNT(f_id) FROM bookmark WHERE f_id={$_GET['id']}";
                        $result2 = mysqli_query($conn2, $sql2);
                        $row = mysqli_fetch_array($result2);
                        $total_rows = $row[0];
                        ?>
                        <?=number_format($total_rows)?>명이 기대하는 페스티벌입니다
                        <?php
                        $conn3 = mysqli_connect('localhost', 'root', '1442', 'tests');
                        $sql3 = "SELECT uni FROM bookmark WHERE uni='{$_GET['id']}{$_SESSION['id']}'";
                        $result = $conn3->query($sql3);
                        if($result->num_rows==1) {
                            echo '<div class="text-danger" align="center" style=\'font-family:"malgun gothic"; font-size: smaller\'>북마크 추가됨</div>';
                        }
                        ?>
                    </button>
                </form>
            </p>

            <form method="post" action="cart/index.php?id=<?=$_SESSION['id'].$article['id']?>">
                <input type="hidden" name="hidden_name" value="<?php echo $article['title']; ?>" />
                <input type="hidden" name="hidden_price" value="<?php echo $article['price']; ?>" />
                <input type="hidden" name="hidden_id" value="<?php echo $article['id']; ?>" />
                <p><input type="number" min="1" name="quantity" value="1" class="form-control"
                        <?php
                        include('timeCompare2.php');
                        ?>/></p>
                <input type="submit" name="add_to_cart" class="btn btn-lg btn-block text-uppercase"
                    style="font-family: monospace; height: auto; color: #fff; background-color: #ff5f33;"
                    value="Add to Cart"
                    <?php
                    include('timeCompare2.php');
                    ?>>
                <?php
                if($str_now > $str_target) {
                    echo "<h3><div style='alignment: center; color: brown;'>※판매 종료된 상품입니다</div></h3>";
                } elseif ($str_now == $str_target) {
                    echo "<h3><div style='alignment: center; color: darkblue;'>※당일 티켓 구매는 현장에서 가능합니다</div></h3>";
                }
                ?>
            </form>
        </div>

    </div>
    <!-- /.row -->

    <!-- Date/Time
    <p><?= $article['date'] ?></p>-->

    <hr>

    <!-- Post Content -->
    <p class="lead" style="font-family: monospace">INFORMATION</p>

    <p><?= nl2br($article['memo']) ?></p>

    <blockquote class="blockquote">
        <p class="mb-0"></p>
        <footer class="blockquote-footer">작성시간
            <cite title="Source Title"><?= $article['created'] ?></cite>
        </footer>
    </blockquote>
    <hr>


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
