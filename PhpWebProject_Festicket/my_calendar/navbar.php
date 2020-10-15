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
    <div class="container" style="width: 100%">
        <a class="navbar-brand" href="http://localhost/no3/"><h4>F E S T I C K E T</h4></a>

        <!--정렬해줌--><div class="collapse navbar-collapse" id="navbarResponsive"></div>

        <ul class="navbar-nav ml-auto">
            <!--li class="nav-item">
                <a class="nav-link" href="http://localhost/no3/about.php">About</a>
            </li-->
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/no3/calendar">Calendar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/no3/contact.php">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/no3/cart"
                    <?php
                    if (isset($_SESSION['id'])) { //세션이 존재할 경우 히든
                        if ($row['is_admin'] == 0) { //최종관리자인경우
                            echo "hidden";
                        } else {
                        }
                    }?>>장바구니</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/no3/login.php"
                    <?php
                    if (isset($_SESSION['id'])) { //세션이 존재할 경우 히든
                        echo "hidden";
                    } else {
                    } ?>>Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/no3/mypage.php?id=<?= $row['id'] ?>"
                    <?php
                    if (!isset($_SESSION['id'])) { //세션이 존재하지 않을 경우 히든
                        echo "hidden";
                    } else { //세션이 존재하는 경우
                        if($row['is_admin']==0){ //최종관리자인경우
                            echo "hidden";
                        }
                    } ?>>My Page</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/no3/adminpage.php?id=<?=$row['id']?>"
                    <?php
                    if (!isset($_SESSION['id'])) { //세션이 존재하지 않을 경우 히든
                        echo "hidden";
                    } else { //세션이 존재하는 경우
                        if($row['is_admin']==2){ //일반 회원인 경우
                            echo "hidden";
                        }
                    } ?>>관리자메뉴</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/no3/logout.php" style="color:#ff0000;"
                    <?php
                    if (!isset($_SESSION['id'])) { //세션이 존재하지 않을 경우 히든
                        echo "hidden";
                    } else {
                    } ?>>Logout</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" style="color: #23ff2a" onclick="chat();">실시간문의</a>
            </li>
            
        </ul>
    </div>
</nav>