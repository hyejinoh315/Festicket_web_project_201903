<?php
session_start();

if (isset($_SESSION['id'])) { //세션이 존재할 경우 //echo $_SESSION['id']; -> 아이디 값이 나온다
} else { //로그인 안했을 경우 로그인페이지로
    echo "<meta http-equiv=refresh content=0;url=http://localhost/no3/login.php>";//자동이동
    exit;
}
$id = $_SESSION['id'];
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

if ($_GET['page'] <= 1) {
    $_GET['page'] = 1;
}

?>

<!-- Page Content -->
<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">My Order
        <small></small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="mypage.php?id=">Menu</a></li>
        <li class="breadcrumb-item active">MyOrder</li>
    </ol>


    <hr/><!--구분선-->

    <!-- Content Row    row -->
    <div class="row">

        <?php
        include("my_menu.php");
        ?>

        <div class="col-lg-9 mb-4">
            <h2>구매내역</h2>
            <p></p>
            <div class="list-group">
                <div class="mb-4" id="accordion" role="tablist" aria-multiselectable="true">
                    <?php
                    ini_set('memory_limit', '-1');

                    $conn = mysqli_connect('localhost', 'root', '1442', 'tests');
                    $data = mysqli_query($conn, "SELECT * FROM order_data WHERE u_id='{$_SESSION['id']}'");
                    $num = mysqli_num_rows($data);

                    $page = ($_GET['page']) ? $_GET['page'] : 1;
                    $list = 1;
                    $block = 1;

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

                    if ($pageNum <= $_GET['page']) {
                        $_GET['page'] = $pageNum;
                    }

                    $s_point = ($page - 1) * $list;

                    $conn = mysqli_connect('localhost', 'root', '1442', 'tests');
                    $sql_query = "SELECT * FROM order_data WHERE u_id='$id' ORDER BY id DESC LIMIT $s_point,$list"; //로그인시 입력된 아이디에 관련된 회원정보를 가져온다
                    $result = mysqli_query($conn, $sql_query) or die("database error:" . mysqli_error($conn));
                    $i = 1;
                    if (!$result->num_rows == 0) {

                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($i % 3 == 1) {
                                ?>
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingOne">
                                        <div class="mb-0">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                               aria-expanded="true" aria-controls="collapseOne">
                                                주문일시 : <?= substr($row['regdate'], 0, 10); ?><br>주문번호
                                                : <?= substr($row['order_no'], 4); ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div id="collapseOne" class="collapse show" role="tabpanel"
                                         aria-labelledby="headingOne">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr align="center">
                                                    <th width="50%">상품</th>
                                                    <th width="25%">가격</th>
                                                    <th width="15%">상태</th>
                                                </tr>
                                                <?php
                                                $order_data = json_decode($row['order_data'], true);

                                                foreach ($order_data as $keys => $values) {
                                                $sql = "SELECT * FROM fesitval WHERE id ={$values['f_id']}";
                                                $res = mysqli_query($conn, $sql);
                                                $row2 = mysqli_fetch_array($res);
                                                $tal = $row2['price'] * $values["quantity"];
                                                ?>
                                                <tr>
                                                    <td>
                                                        <img src="img/<?= $row2['img']; ?>" style="height: 30px;">
                                                        <a href="http://localhost/no3/festivals_post.php?id=<?= $row2['id']; ?>"
                                                           style="color: #000;"><?= $row2['title']; ?></a>
                                                    </td>
                                                    <td align="right">￦ <?= number_format($tal); ?>
                                                        (<?= $values["quantity"]; ?>장 구매)
                                                    </td>
                                                    <td align="center"><?php
                                                        if ($values["status"] == 0) {
                                                            //주문완료, 티켓 발송 전
                                                            ?>
                                                            <div style="color: #000000;">티켓발송전</div>
                                                            <?php
                                                        } elseif ($values ["status"] == 1) {
                                                            //주문 완료, 티켓 발송 후
                                                            ?>
                                                            <div style="color: #007bff;">발송완료</div>
                                                            <?php
                                                        }
                                                        ?></td>
                                                </tr>
                                                <tr>
                                                    <?php
                                                    }
                                                    ?>
                                                    <td align="right">Total</td>
                                                    <td align="right">￦ <?= number_format($row['price']); ?></td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                            <hr/><!--구분선-->
                                            <table class="table table-bordered" style="width: auto; margin-left: auto">
                                                <tr>
                                                    <td>
                                                        <span style="font-size: 20px;">수신자 정보</span><a
                                                                style="float: right; font-size: 14px;" href="#">수정</a>
                                                        <p></p>
                                                        <?= $row['tel'] ?>
                                                        <hr style="width: 200px" align="left"/>
                                                        <span style="color: #008b8b; font-size: 14px">
                                                            주문시 입력된 정보로 모바일 티켓이 전송됩니다.<br>
                                                            번호 수정은 티켓 전송 전에만 가능합니다.
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } elseif ($i % 3 == 2) { ?>
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingTwo">
                                        <div class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                               href="#collapseTwo"
                                               aria-expanded="false" aria-controls="collapseTwo">
                                                주문일시 : <?= substr($row['regdate'], 0, 10); ?><br>주문번호
                                                : <?= substr($row['order_no'], 4); ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div id="collapseTwo" class="collapse show" role="tabpanel"
                                         aria-labelledby="headingTwo">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr align="center">
                                                    <th width="50%">상품</th>
                                                    <th width="25%">가격</th>
                                                    <th width="15%">상태</th>
                                                </tr>
                                                <?php
                                                $order_data = json_decode($row['order_data'], true);

                                                foreach ($order_data

                                                as $keys => $values) {
                                                $sql = "SELECT * FROM fesitval WHERE id ={$values['f_id']}";
                                                $res = mysqli_query($conn, $sql);
                                                $row2 = mysqli_fetch_array($res);
                                                $tal = $row2['price'] * $values["quantity"];
                                                ?>
                                                <tr>
                                                    <td>
                                                        <img src="img/<?= $row2['img']; ?>" style="height: 30px;">
                                                        <a href="http://localhost/no3/festivals_post.php?id=<?= $row2['id']; ?>"
                                                           style="color: #000;"><?= $row2['title']; ?></a>
                                                    </td>
                                                    <td align="right">￦ <?= number_format($tal); ?>
                                                        (<?= $values["quantity"]; ?>장 구매)
                                                    </td>
                                                    <td align="center"><?php
                                                        if ($values["status"] == 0) {
                                                            //주문완료, 티켓 발송 전
                                                            ?>
                                                            <div style="color: #000000;">티켓발송전</div>
                                                            <?php
                                                        } elseif ($values ["status"] == 1) {
                                                            //주문 완료, 티켓 발송 후
                                                            ?>
                                                            <div style="color: #007bff;">발송완료</div>
                                                            <?php
                                                        }
                                                        ?></td>
                                                </tr>
                                                <tr>
                                                    <?php
                                                    }
                                                    ?>
                                                    <td align="right">Total</td>
                                                    <td align="right">￦ <?= number_format($row['price']); ?></td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                            <hr/><!--구분선-->
                                            <table class="table table-bordered" style="width: auto; margin-left: auto">
                                                <tr>
                                                    <td>
                                                        <span style="font-size: 20px;">수신자 정보</span><a
                                                                style="float: right; font-size: 14px;" href="#">수정</a>
                                                        <p></p>
                                                        <?= $row['tel'] ?>
                                                        <hr style="width: 200px" align="left"/>
                                                        <span style="color: #008b8b; font-size: 14px">
                                                            주문시 입력된 정보로 모바일 티켓이 전송됩니다.<br>
                                                            번호 수정은 티켓 전송 전에만 가능합니다.
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } elseif ($i % 3 == 0) {
                                ?>
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingThree">
                                        <div class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                               href="#collapseThree" aria-expanded="false"
                                               aria-controls="collapseThree">
                                                주문일시 : <?= substr($row['regdate'], 0, 10); ?><br>주문번호
                                                : <?= substr($row['order_no'], 4); ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div id="collapseThree" class="collapse show" role="tabpanel"
                                         aria-labelledby="headingThree">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr align="center">
                                                    <th width="50%">상품</th>
                                                    <th width="25%">가격</th>
                                                    <th width="15%">상태</th>
                                                </tr>
                                                <?php
                                                $order_data = json_decode($row['order_data'], true);

                                                foreach ($order_data

                                                as $keys => $values) {
                                                $sql = "SELECT * FROM fesitval WHERE id ={$values['f_id']}";
                                                $res = mysqli_query($conn, $sql);
                                                $row2 = mysqli_fetch_array($res);
                                                $tal = $row2['price'] * $values["quantity"];
                                                ?>
                                                <tr>
                                                    <td>
                                                        <img src="img/<?= $row2['img']; ?>" style="height: 30px;">
                                                        <a href="http://localhost/no3/festivals_post.php?id=<?= $row2['id']; ?>"
                                                           style="color: #000;"><?= $row2['title']; ?></a>
                                                    </td>
                                                    <td align="right">￦ <?= number_format($tal); ?>
                                                        (<?= $values["quantity"]; ?>장 구매)
                                                    </td>
                                                    <td align="center"><?php
                                                        if ($values["status"] == 0) {
                                                            //주문완료, 티켓 발송 전
                                                            ?>
                                                            <div style="color: #000000;">티켓발송전</div>
                                                            <?php
                                                        } elseif ($values ["status"] == 1) {
                                                            //주문 완료, 티켓 발송 후
                                                            ?>
                                                            <div style="color: #007bff;">발송완료</div>
                                                            <?php
                                                        }
                                                        ?></td>
                                                </tr>
                                                <tr>
                                                    <?php
                                                    }
                                                    ?>
                                                    <td align="right">Total</td>
                                                    <td align="right">￦ <?= number_format($row['price']); ?></td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                            <hr/><!--구분선-->
                                            <table class="table table-bordered" style="width: auto; margin-left: auto">
                                                <tr>
                                                    <td>
                                                        <span style="font-size: 20px;">수신자 정보</span><a
                                                                style="float: right; font-size: 14px;" href="#">수정</a>
                                                        <p></p>
                                                        <?= $row['tel'] ?>
                                                        <hr style="width: 200px" align="left"/>
                                                        <span style="color: #008b8b; font-size: 14px">
                                                            주문시 입력된 정보로 모바일 티켓이 전송됩니다.<br>
                                                            번호 수정은 티켓 전송 전에만 가능합니다.
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            $i++;
                            if ($row == false) {
                                exit;
                            }
                        }
                    } else {
                        echo '
                <div class="list-group">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
				        <tr>
					        <td colspan="4" align="center" style="color:#ff0000;">구매내역이 존재하지 않습니다</td>
				        </tr>
				    </table>
				    <hr/>
				</div>
				';
                    }
                    ?>
                </div>
            </div>
            <div align="center">
                <a href="<?= $PHP_SELP ?>?page=1"
                    <?php if ($_GET['page'] == 1) {
                        echo "hidden";
                    } if ($result->num_rows == 0){
                        echo "hidden";
                    }?>>처음으로</a>&nbsp;
                <a href="<?= $PHP_SELP ?>?page=<?= $_GET['page'] - 1 ?>"
                    <?php if ($_GET['page'] == 1) {
                        echo "hidden";
                    } if ($result->num_rows == 0) {
                        echo "hidden";
                    }?>>　이전◀　</a>
                <a href="<?= $PHP_SELP ?>?page=<?= $_GET['page'] + 1 ?>"
                    <?php if ($_GET['page'] == $pageNum) {
                        echo "hidden";
                    } ?>>　▶다음　</a>
                <a href="<?= $PHP_SELP ?>?page=<?= $pageNum ?>"
                    <?php if ($_GET['page'] == $pageNum) {
                        echo "hidden";
                    } ?>>끝으로</a>
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
