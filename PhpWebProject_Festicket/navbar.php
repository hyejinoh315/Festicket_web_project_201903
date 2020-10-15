<?php
if (isset($_SESSION['id'])) { //세션이 존재할 경우
//echo $_SESSION['id']; -> 아이디 값이 나온다
}
$id = $_SESSION['id'];
$conn = mysqli_connect('localhost', 'root', '1442', 'tests');

$sql_query = "SELECT * FROM users WHERE user_id='$id'"; //로그인시 입력된 아이디에 관련된 회원정보를 가져온다
$result = mysqli_query($conn, $sql_query) or die("database error:" . mysqli_error($conn));
$row = mysqli_fetch_assoc($result)
?>

<!--메인 맨 위 -bar- -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php"><h4>F E S T I C K E T</h4></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <!--li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li-->
                <li class="nav-item">
                    <a class="nav-link" href="/no3/calendar/">Calendar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/no3/cart"
                        <?php
                        if (isset($_SESSION['id'])) { //세션이 존재할 경우 히든
                            if ($row['is_admin'] == 0) { //최종관리자인경우
                                echo "hidden";
                            } else {
                            }
                        } ?>>장바구니</a>
                </li>
                <!--<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownPortfolio" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        메뉴
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
                        <a class="dropdown-item" href="sidebar.php">Festivals</a>
                        <a class="dropdown-item" href="membership.php">회원관리</a>
                        <a class="dropdown-item" href="qna.php">Q n A</a>
                        <a class="dropdown-item" href="contact.php">Contact</a>
                    </div>
                </li>-->
                <li class="nav-item">
                    <a class="nav-link" href="login.php"
                        <?php
                        if (isset($_SESSION['id'])) { //세션이 존재할 경우 히든
                            echo "hidden";
                        } else {
                        } ?>>Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mypage.php?id=<?= $row['id'] ?>"
                        <?php
                        if (!isset($_SESSION['id'])) { //세션이 존재하지 않을 경우 히든
                            echo "hidden";
                        } else { //세션이 존재하는 경우
                            if ($row['is_admin'] == 0) { //최종관리자인경우
                                echo "hidden";
                            }
                        } ?>>My Page</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="adminpage.php?id=<?= $row['id'] ?>"
                        <?php
                        if (!isset($_SESSION['id'])) { //세션이 존재하지 않을 경우 히든
                            echo "hidden";
                        } else { //세션이 존재하는 경우
                            if ($row['is_admin'] == 2) { //일반 회원인 경우
                                echo "hidden";
                            }
                        } ?>>관리자메뉴</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" style="color:#ff0000;"
                        <?php
                        if (!isset($_SESSION['id'])) { //세션이 존재하지 않을 경우 히든
                            echo "hidden";
                        } else {
                        } ?>>Logout</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" style="color: #23ff2a; cursor: pointer;" onclick="chat();">실시간문의</a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
    function chat() {

        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/5cd6a665d07d7e0c63931004/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    }
</script>
<!--End of Tawk.to Script-->