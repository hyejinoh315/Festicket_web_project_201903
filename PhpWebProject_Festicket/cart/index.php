<?php
session_start();
if(isset($_SESSION['id'])) {
    include("cart_login.php");
}else {
    include ("cart_not_login.php");
}
?>
<div style='float: right;'<?php if (!isset($_COOKIE["shopping_cart"])&&!isset($_SESSION['id'])) { echo "hidden";}?>>
    <a href='order.php?id=<?=$_SESSION['id']?>' class='btn btn-primary' style='background-color: black; border: white'>주문하기</a></div>
</div>
</div>
<br />
<br />
<?php
include("footer.php");
?>
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>

