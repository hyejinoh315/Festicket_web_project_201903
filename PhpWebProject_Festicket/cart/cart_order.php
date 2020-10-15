<?php
session_start();//로그인한상태의 로직
$id = $_SESSION['id'];
$conn = mysqli_connect('localhost', 'root', '1442', 'tests');

$sql_query = "SELECT * FROM users WHERE user_id='$id'"; //로그인시 입력된 아이디에 관련된 회원정보를 가져온다
$result_user = mysqli_query($conn, $sql_query) or die("database error:" . mysqli_error($conn));
$row_user = mysqli_fetch_assoc($result_user);

//장바구니 담은 상품 없으면
$sql = "SELECT f_id, quantity, title, price FROM cart LEFT JOIN fesitval ON cart.f_id = fesitval.id WHERE u_id='$id'";
$result = mysqli_query($conn, $sql);
if ($result->num_rows == 0) {
    header("location:index.php?empty=1");
}
?>

<!DOCTYPE html>
<html lang="en; ko">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>FESTICKET</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">
</head>
<body>
<?php
include("navbar.php");
?>
<br/>
<div class="container">
    <br/>
    <br/>
    <br/>
    <h2><?= $_SESSION['id'] ?>님의 주문내역</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="http://localhost/no3/index.php">Home</a>
        </li>
        <li class="breadcrumb-item active">Order page</li>
    </ol>
    <hr/><!--구분선-->

    <div style="clear:both"></div>
    <br/>
    <h3></h3>
    <div class="table-responsive">
        <div align="right">
        </div>
        <table class="table table-hover table-bordered">
            <tr align="center">
                <th width="40%">페스티벌명</th>
                <th width="12%">수량</th>
                <th width="18%">판매가</th>
                <th width="15%">합계</th>
            </tr>
            <?php
            $sql = "SELECT f_id, quantity, title, price,img FROM cart LEFT JOIN fesitval ON cart.f_id = fesitval.id WHERE u_id='$id'";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)) {
                //f_id, quantity, title, price
                ?>
                <tr>
                    <td><img src="img/<?=$row['img']?>" style="height: 40px;">
                        <a href="http://localhost/no3/festivals_post.php?id=<?= $row['f_id'] ?>"
                           style="color: #000;font-size: 20px"><?= $row['title'] ?></a>
                    <td align="right"><?= $row['quantity'] ?>개</td>
                    <td align="right">￦ <?= number_format($row['price']) ?></td>
                    <td align="right">￦ <?= number_format($row['quantity'] * $row['price']) ?></td>
                </tr>
                <?php
                $total = $total + ($row['quantity'] * $row['price']);
            }
            ?>
            <tr>
                <td colspan="3" align="right">Total</td>
                <td align="right">￦ <?php echo number_format($total); ?></td>
            </tr>
        </table>

        <hr/><!--구분선-->
        <table class="table table-bordered" style="width: auto; margin-left: auto">
            <tr>
                <td>
                    <h5>주문자정보</h5>
                    <p></p>
                    <p><?= $row_user['name'] ?></p>
                    <p><?= $row_user['tel'] ?></p>
                    <hr style="width: 200px" align="left"/>
                    <span style="color: #008b8b; font-size: 14px">
                        <p>주문자 정보로 결제관련 정보를 제공합니다.</p>
                        <p>정확한 정보로 등록되어 있는지 확인해 주세요.</p>
                    </span>
                </td>
            </tr>
            <tr>
                <td>
                    <h5>수신자정보</h5>
                    <p></p>
                    <p>SMS로 티켓을 전송합니다. 수신받을 번호를 입력해 주세요.</p>
                    <p><input type="tel" id="fin_tel">
                        <button onclick='$("#fin_tel").val("<?= $row_user['tel'] ?>")'>주문자와 동일</button>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <h5>결제금액</h5>
                    <p></p>
                    <p><?php echo number_format($total); ?>원</p>
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" id="chk1"> 위 상품의 구매조건 확인 및 결제 진행 동의</td>
            </tr>
        </table>
        <?php
        $sql = "SELECT f_id, title FROM cart LEFT JOIN fesitval ON cart.f_id = fesitval.id WHERE u_id='$id' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $sql2 = "SELECT COUNT(f_id) FROM cart WHERE u_id='$id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($result2);
        $total_rows = $row2[0];
        ?>
        <input type="hidden" id="value" value="<?= $total_rows ?>"/>
        <input type="hidden" id="product" value="<?= $row['title'] ?>"/>
        <input type="hidden" id="total" value="<?= $total ?>"/>
        <input type="hidden" id="name" value="<?= $row_user['name'] ?>"/>
        <input type="hidden" id="tel" value="<?= $row_user['tel'] ?>"/>
        <div style='float: right;'><input type="submit" id="pay_btn" name="payment" value="결제하기" class="btn btn-primary"
                                          style='background-color: black; border: white'></div>
    </div>
</div>
<br/>
<br/>
<?php
include("footer.php");
?>
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!--아임포트-->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
<script type="text/javascript" src="payment.js"></script>

</body>
</html>
<?php
if (isset($_SESSION['cart'])) {
    echo "<script>alert('기존에 담겨있던 상품이 존재하는 경우에는 함께 주문서가 작성됩니다');location.href='order.php?id={$_SESSION['id']}';</script>";
    unset($_SESSION['cart']);
}
?>