<?php
session_start();
if (isset($_SESSION['id'])) { //세션이 존재할 경우 //echo $_SESSION['id']; -> 아이디 값이 나온다
} else { //로그인 안했을 경우 로그인페이지로
    echo "<meta http-equiv=refresh content=0;url=http://localhost/no3/login.php>";//자동이동
    exit;
}
$id = $_SESSION['id'];
//echo "<br>" . $_POST['order_no'] . "\n" . $_SESSION['id'] . "\n" . $_POST['fin_tel'] . "\n" . $_POST['total'] . "<br>";
//order_no / u_id / tel / price

$con = mysqli_connect('localhost', 'root', '1442', 'tests');
// 접속 실패 시 메시지 나오게 하기
if (mysqli_connect_errno($con)) {
    echo "MySQL접속 실패: " . mysqli_connect_error();
    exit;
}

// 기본 클라이언트 문자 집합 설정하기
mysqli_set_charset($con, "utf8");
// 쿼리문 실행, 결과를 res에 저장
$res = mysqli_query($con, "SELECT * FROM cart WHERE u_id='{$_SESSION['id']}'");
// 결과를 배열로 변환하기 위한 변수 정의
$result = array();
// 쿼리문의 결과(res)를 배열형식으로 변환(result)
while ($row = mysqli_fetch_array($res)) {
    array_push($result, array('f_id' => $row[2], 'quantity' => $row[3], 'status' => 0));
}
// 배열형식의 결과를 json으로 변환
//echo "<br>" . json_encode($result); // order_data
$json = json_encode($result);


$sql = "INSERT INTO order_data (order_no, u_id, price, tel, order_data)
         VALUES ('{$_POST['order_no']}', '$id', '{$_POST['total']}', '{$_POST['fin_tel']}', '$json')";
$res = mysqli_query($con, $sql);

if ($res === true) {
    $sql = "DELETE FROM cart WHERE u_id='$id'";
    $result = mysqli_query($con, $sql);
    if ($result === true) {
        echo "<br>주문 완료!";
    } else {
        echo "<br>카트 삭제 실패함 / 결제 완료-주문서 저장 완료됨";
        exit;
    }
} else {
    echo "<br>주문서에 저장 실패함 / 결제 완료";
    exit;
}

$order_data = json_decode($json, true);


$sql_query = "SELECT * FROM users WHERE user_id='$id'"; //로그인시 입력된 아이디에 관련된 회원정보를 가져온다
$res_user = mysqli_query($con, $sql_query) or die("database error:" . mysqli_error($conn));
$row_user = mysqli_fetch_assoc($res_user);

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
<style>
    .top {
        vertical-align: top;
        text-align: center;
        margin-left: 20px;
    }

    .middle {
        vertical-align: middle;
        text-align: center;
    }

    .bottom {
        vertical-align: bottom;
        text-align: center;
    }
</style>
<br/>
<div class="container">
    <br/>
    <br/>
    <br/><br/>
    <h1 align="center">주문이 정상적으로 완료되었습니다</h1><br>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="http://localhost/no3/index.php">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="http://localhost/no3/myorder.php?id=<?= $row['id'] ?>">My Order</a>
        </li>
    </ol>
    <hr/><!--구분선-->
    <div class="row">

        <div style="clear:both"></div>
        <br/>
        <h3></h3>
        <div class="top" align="center">
            <div style="float:left;" align="center">
                <table class="table table-bordered">
                    <?php
                    foreach ($order_data as $keys => $values) {
                        //echo "<br>" . $_POST['order_no'] . "\n" . $_SESSION['id'] . "\n" . $_POST['fin_tel'] . "\n" . $_POST['total'] . "<br>";
                        //order_no / u_id / tel / price
                        $sql = "SELECT * FROM fesitval WHERE id ={$values['f_id']}";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($result);
                        ?>
                        <tr>
                            <td><img src="img/<?= $row['img']; ?>" style="height: 150px;"></td>
                            <td>
                                <p style="font-size: 18px;"><?= $row['title']; ?></p>
                                <?= number_format($row['price']); ?>원<br>
                                <?= $values['quantity'] ?>개 주문<br>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div style="float: right; margin-left: 100px;">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>주문번호</th>
                            <th><?= substr($_POST['order_no'], 4); ?></th>
                        </tr>
                        <tr>
                            <th>티켓 수신번호</th>
                            <th><?= $_POST['fin_tel']; ?></th>
                        </tr>

                        <tr>
                            <th>결제금액</th>
                            <th><?= number_format($_POST['total']) . "원"; ?></th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div align="bottom" class="middle" style="margin-top: 20px;">
    <a href="http://localhost/no3"><input type="button" value="계속 쇼핑하기"></a>
    <a href="http://localhost/no3/myorder.php?id=<?= $row['id'] ?>"><button>나의 주문 확인</button></a>

</div>
<br/>
<br/>
<br/>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<div class="bottom">
    <?php
    include("footer.php");
    ?>
</div>
