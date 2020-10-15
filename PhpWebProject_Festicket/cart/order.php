<?php
session_start();
if(isset($_SESSION['id'])) {
    include("cart_order.php");
}else if($_GET['id']=='') {
    $_SESSION['cart'] = 'cart';//카트로 이동하기 위한 세션 변수를 등록해준다

    echo "<meta http-equiv=refresh content=0;url=http://localhost/no3/login.php>";//자동이동
    exit;
}

