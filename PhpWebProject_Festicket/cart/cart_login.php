<?php
session_start();//로그인한상태의 로직
$id = $_SESSION['id'];
$conn = mysqli_connect('localhost', 'root', '1442', 'tests');

if (isset($_COOKIE["shopping_cart"])) {
//쿠키가 존재한다는 가정
    $total = 0;
    $cookie_data = stripslashes($_COOKIE['shopping_cart']);
    $cart_data = json_decode($cookie_data, true);
//쿠키소멸시킨다
    setcookie("shopping_cart", "", time() - 3600);
//데이터베이스에 추가한다
    foreach ($cart_data as $keys => $values) {
        //$sql = "UPDATE cart SET u_id='$id', f_id='{$values['item_id']}', quantity='{$values['item_quantity']}'";
        $sql = "INSERT INTO cart (u_id, f_id, quantity, uni) VALUES ('$id', '{$values['item_id']}', '{$values['item_quantity']}', '$id{$values['item_id']}')";
        $result = mysqli_query($conn, $sql);
        if ($result === false) { //유니크키값이 존재하는 경우기 때문에 업데이트를 한다
            $sql = "SELECT * FROM cart WHERE uni='$id{$values['item_id']}'";
            $result = $conn->query($sql);
            if ($result->num_rows == 1) {
                //이미 추가된 상황이므로 숫자만 업데이트한다
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $sql = "UPDATE cart SET quantity=({$values['item_quantity']}+{$row['quantity']}) WHERE uni='$id{$values['item_id']}'";
                $result = mysqli_query($conn, $sql);
                if ($result === false) {
                    echo '존재하는상품개수: ' . $row['quantity'];
                    echo '<br>넘어온상품개수: ' . $values['item_quantity'];
                    echo '<br>유니크: ' . $id . $values['item_id'];
                }
            }
        }
    }
}

if (isset($_POST["add_to_cart"])) {
    //hidden_name hidden_price hidden_id quantity
    //외부에서 제품 추가버튼을 눌러서 상품을 카트로 넘겼을 경우, 이미 유니크 키가 존재할 때(id+f_id) 존재하지 않을 때
    $sql = "SELECT * FROM cart WHERE uni='{$_GET['id']}'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        //이미 추가된 상황이므로 숫자만 업데이트한다
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $sql = "UPDATE cart SET quantity=({$_POST['quantity']}+{$row['quantity']}) WHERE uni='{$_GET['id']}'";
        $result = mysqli_query($conn, $sql);
        if ($result === false) {
            echo '존재하는상품개수: ' . $row['quantity'];
            echo '<br>넘어온상품개수: ' . $_POST['quantity'];
            echo '<br>유니크: ' . $_GET['id'];
        }
    } else {
        //상품이 추가된 이력이 없으므로 인서트한다
        $sql = "INSERT INTO cart (u_id, f_id, quantity, uni) VALUES ('$id', '{$_POST['hidden_id']}', '{$_POST['quantity']}', '$id{$_POST['hidden_id']}')";
        $result = mysqli_query($conn, $sql);
        if ($result === false) {
        }
    }
    header("location:index.php?success=1");
}

if (isset($_POST["edit_to_cart"])) {//내부 수정버튼 클릭했을 경우
    $sql = "UPDATE cart SET quantity={$_POST['quantity']} WHERE uni='$id{$_POST['hidden_id']}'";
    $result = mysqli_query($conn, $sql);
    if ($result === false) {
    }
    header("location:index.php?success_edit=1");
}

if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        $sql = "DELETE FROM cart WHERE uni='$id{$_GET['id']}'";
        $result = mysqli_query($conn, $sql);
        if ($result === false) {
        } else {
            header("location:index.php?remove=1");
        }
    }
    if ($_GET["action"] == "clear") {
        $sql = "DELETE FROM cart WHERE u_id='$id'";
        $result = mysqli_query($conn, $sql);
        if ($result === false) {
        } else {
            header("location:index.php?clearall=1");
        }
    }
}
//hidden_name hidden_price hidden_id quantity
if (isset($_GET["success"])) {
    $message = '
	<div class="alert alert-success alert-dismissible">
	  	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  	상품이 성공적으로 담겼습니다
	  	<a href="#" onclick="history.back();">　되돌아가기</a>	  	
	</div>
	';
}
if (isset($_GET["empty"])) {
    $message = '
	<div class="alert alert-info alert-dismissible">
	  	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  	상품을 담은 뒤 주문이 가능합니다
	  	<a href="#" onclick="window.location.href=\'http://localhost/no3/\';">　구경하러가기</a>	  	
	</div>
	';
}
if (isset($_GET["success_edit"])) {
    $message = '
	<div class="alert alert-warning alert-dismissible">
	  	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  	상품 갯수가 수정되었습니다
	</div>
	';
}
//color = primary 청색 secondary 밝은회색 success 녹색 danger 적색 warning 황색 info 청녹색 light 흰색 dark 어두운회색;
if (isset($_GET["remove"])) {
    $message = '
	<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		상품이 삭제되었습니다
	</div>
	';
}
if (isset($_GET["clearall"])) {
    $message = '
	<div class="alert alert-primary alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		장바구니를 비웠습니다...
	</div>
	';
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
    <h2><?= $_SESSION['id'] ?>님의 장바구니</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="http://localhost/no3/index.php">Home</a>
        </li>
        <li class="breadcrumb-item active">Shopping Cart</li>
    </ol>
    <hr/><!--구분선-->

    <div style="clear:both"></div>
    <br/>
    <h3></h3>
    <div class="table-responsive">
        <?php echo $message; ?>
        <div align="right"  <?php
        $sql = "SELECT f_id, quantity, title, price,img FROM cart LEFT JOIN fesitval ON cart.f_id = fesitval.id WHERE u_id='$id'";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows == 0) { echo "hidden";}?>>
            <a href="index.php?action=clear"><b>장바구니 비우기</b></a>
        </div>
        <table class="table table-hover table-bordered">
            <tr align="center">
                <th width="40%">페스티벌명</th>
                <th width="12%">수량</th>
                <th width="18%">판매가</th>
                <th width="15%">합계</th>
                <th width="5%">기타</th>
            </tr>
            <?php
            $sql = "SELECT f_id, quantity, title, price,img FROM cart LEFT JOIN fesitval ON cart.f_id = fesitval.id WHERE u_id='$id'";
            $result = mysqli_query($conn, $sql);
            if (!$result->num_rows == 0) {
                while ($row = mysqli_fetch_array($result)) {
                    //f_id, quantity, title, price
                    ?>
                    <tr>
                        <td><img src="img/<?=$row['img']?>" style="height: 40px;">
                            <a href="http://localhost/no3/festivals_post.php?id=<?= $row['f_id'] ?>"
                               style="color: #000;font-size: 20px"><?= $row['title'] ?></a>
                        </td>
                        <form method="post">
                            <input type="hidden" name="hidden_name" value="<?= $row['title'] ?>"/>
                            <input type="hidden" name="hidden_price" value="<?= $row['price'] ?>"/>
                            <input type="hidden" name="hidden_id" value="<?= $row['f_id'] ?>"/>
                            <td>
                                <div style="float:left;"><input type="number" min="1" name="quantity"
                                                                value="<?= $row['quantity'] ?>"
                                                                class="form-control" style="width: 55px"/></div>
                                <div style="float: right;"><input type="submit" name="edit_to_cart"
                                                                  style="border: black;" class="btn btn-secondary"
                                                                  value="수정"/></div>
                            </td>
                        </form>
                        <td align="right">￦ <?= number_format($row['price']) ?></td>
                        <td align="right">￦ <?= number_format($row['quantity'] * $row['price']) ?></td>
                        <td><a href="index.php?action=delete&id=<?= $row['f_id'] ?>"><span class="text-danger">삭제</span></a>
                        </td>
                    </tr>
                    <?php
                    $total = $total + ($row['quantity'] * $row['price']);
                }
                ?>
                <tr>
                    <td colspan="3" align="right">Total</td>
                    <td align="right">￦ <?php echo number_format($total); ?></td>
                    <td></td>
                </tr>
                <?php
            }else if ($result->num_rows == 0) {
                echo '
				<tr>
					<td colspan="5" align="center">장바구니가 비어있습니다</td>
				</tr>
				';
            }
            ?>

        </table>

<?php
if (isset($_SESSION['cart'])) {
    echo "<script>location.href='order.php?id={$_SESSION['id']}';</script>";
}
?>