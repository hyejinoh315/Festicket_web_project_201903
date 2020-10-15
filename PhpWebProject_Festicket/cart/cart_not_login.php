<?php
//로그인하지 않은 상태의 로직이다 = 쿠키를 사용한다
$connect = new PDO("mysql:host=localhost;dbname=tests", "root", "1442");

$message = '';

if(isset($_POST["add_to_cart"]))
{
    if(isset($_COOKIE["shopping_cart"]))
    {
        $cookie_data = stripslashes($_COOKIE['shopping_cart']);

        $cart_data = json_decode($cookie_data, true);
    }
    else
    {
        $cart_data = array();
    }

    $item_id_list = array_column($cart_data, 'item_id');

    if(in_array($_POST["hidden_id"], $item_id_list))
    {
        foreach($cart_data as $keys => $values)
        {
            if($cart_data[$keys]["item_id"] == $_POST["hidden_id"])
            {
                $cart_data[$keys]["item_quantity"] = $cart_data[$keys]["item_quantity"] + $_POST["quantity"];
            }
        }
    }
    else
    {
        $item_array = array(
            'item_id'			=>	$_POST["hidden_id"],
            'item_name'			=>	$_POST["hidden_name"],
            'item_price'		=>	$_POST["hidden_price"],
            'item_quantity'		=>	$_POST["quantity"]
        );
        $cart_data[] = $item_array;
    }


    $item_data = json_encode($cart_data);
    setcookie('shopping_cart', $item_data, time() + (86400 * 30));
    header("location:index.php?success=1");
}

if(isset($_POST["edit_to_cart"]))
{
    if(isset($_COOKIE["shopping_cart"]))
    {
        $cookie_data = stripslashes($_COOKIE['shopping_cart']);

        $cart_data = json_decode($cookie_data, true);
    }
    else
    {
        $cart_data = array();
    }

    $item_id_list = array_column($cart_data, 'item_id');

    if(in_array($_POST["hidden_id"], $item_id_list))
    {
        foreach($cart_data as $keys => $values)
        {
            if($cart_data[$keys]["item_id"] == $_POST["hidden_id"])
            {
                $cart_data[$keys]["item_quantity"] = $_POST["quantity"];
            }
        }
    }
    else
    {
        $item_array = array(
            'item_id'			=>	$_POST["hidden_id"],
            'item_name'			=>	$_POST["hidden_name"],
            'item_price'		=>	$_POST["hidden_price"],
            'item_quantity'		=>	$_POST["quantity"]
        );
        $cart_data[] = $item_array;
    }


    $item_data = json_encode($cart_data);
    setcookie('shopping_cart', $item_data, time() + (86400 * 30));
    header("location:index.php?success_edit=1");
}

if(isset($_GET["action"]))
{
    if($_GET["action"] == "delete")
    {
        $cookie_data = stripslashes($_COOKIE['shopping_cart']);
        $cart_data = json_decode($cookie_data, true);
        foreach($cart_data as $keys => $values)
        {
            if($cart_data[$keys]['item_id'] == $_GET["id"])
            {
                unset($cart_data[$keys]);
                $item_data = json_encode($cart_data);
                setcookie("shopping_cart", $item_data, time() + (86400 * 30));
                header("location:index.php?remove=1");
            }
        }
    }
    if($_GET["action"] == "clear")
    {
        setcookie("shopping_cart", "", time() - 3600);
        header("location:index.php?clearall=1");
    }
}

if (isset($_GET["success"])) {
    $message = '
	<div class="alert alert-success alert-dismissible">
	  	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  	상품이 성공적으로 담겼습니다
	  	<a href="#" onclick="history.back();">　되돌아가기</a>	  	
	</div>
	';
}

if(isset($_GET["success_edit"]))
{
    $message = '
	<div class="alert alert-warning alert-dismissible">
	  	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  	상품 갯수가 수정되었습니다
	</div>
	';
}
//color = primary 청색 secondary 밝은회색 success 녹색 danger 적색 warning 황색 info 청녹색 light 흰색 dark 어두운회색;
if(isset($_GET["remove"]))
{
    $message = '
	<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		상품이 삭제되었습니다
	</div>
	';
}
if(isset($_GET["clearall"]))
{
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
<br />
<div class="container">
    <br/>
    <br/>
    <br/>
    <h2>장바구니</h2>
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
        <div align="right" <?php if (!isset($_COOKIE["shopping_cart"])) { echo "hidden";}?>>
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
            if(isset($_COOKIE["shopping_cart"]))
            {
                $total = 0;
                $cookie_data = stripslashes($_COOKIE['shopping_cart']);
                $cart_data = json_decode($cookie_data, true);

                //echo '<p>'.$cookie_data.'</p>'; 제이슨데이터

                foreach($cart_data as $keys => $values)
                {
                    //echo '<p>'.$keys.'</p>';
                    //echo '<p>'.$values["item_id"].'</p>';
                    //echo '<p>'.$values["item_name"].'</p>';
                    //echo '<p>'.$values["item_quantity"].'</p>';
                    //echo '<p>'.$values["item_price"].'</p>';
                    $conn = mysqli_connect('localhost', 'root', '1442', 'tests');
                    $sql = "SELECT * FROM fesitval WHERE id={$values["item_id"]}";
                    $res=mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($res);
                    ?>
                    <tr>
                        <td><img src="img/<?=$row['img']?>" style="height: 40px;">
                            <a href="http://localhost/no3/festivals_post.php?id=<?php echo $values["item_id"]; ?>"
                               style="color: #000; font-size: 20px"><?php echo $values["item_name"]; ?></a></td>
                        <form method="post">
                            <input type="hidden" name="hidden_name" value="<?php echo $values["item_name"]; ?>" />
                            <input type="hidden" name="hidden_price" value="<?php echo $values["item_price"]; ?>" />
                            <input type="hidden" name="hidden_id" value="<?php echo $values["item_id"]; ?>" />
                            <td><div style="float:left;"><input type="number" min="1" name="quantity" value="<?php echo $values["item_quantity"]; ?>"
                                                                class="form-control" style="width: 55px"/></div>
                                <div style="float: right;"><input type="submit" name="edit_to_cart" style="border: black;" class="btn btn-secondary" value="수정"/></div>
                            </td>
                        </form>
                        <td align="right">￦ <?php echo number_format($values["item_price"]); ?></td>
                        <td align="right">￦ <?php echo number_format($values["item_quantity"] * $values["item_price"]);?></td>
                        <td><a href="index.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">삭제</span></a></td>
                    </tr>
                    <?php
                    $total = $total + ($values["item_quantity"] * $values["item_price"]);
                }
                ?>
                <tr>
                    <td colspan="3" align="right">Total</td>
                    <td align="right">￦ <?php echo number_format($total); ?></td>
                    <td></td>
                </tr>
                <?php
            }
            else
            {
                echo '
				<tr>
					<td colspan="5" align="center">장바구니가 비어있습니다</td>
				</tr>
				';
            }
            ?>
        </table>
