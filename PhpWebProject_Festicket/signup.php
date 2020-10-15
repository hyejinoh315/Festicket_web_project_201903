<?php
session_start();
if (isset($_SESSION['id'])) {
    echo "<meta http-equiv=refresh content=0;url=http://localhost/no3/>";//자동이동
    //echo "<script>alert('로그인한 상태로 가입할 수 없습니다');</script>";
    exit;
}
?>

<!DOCTYPE HTML>
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
    <link rel="stylesheet" type="text/css" href="test.css">
</head>

<body>

<?php
include("navbar.php");
?>

<div class="container">
    <div class="register">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h1 class="card-title text-center" id="signupInfo">S I G N U P</h1>
                    <!--<hr class="my-4">구분선-->

                    <form action="user_create.php" method="post">
                        <div class="label1">ID</div>
                        <div class="form2">
                            <input type="text" id="userId" name="userId" placeholder="아이디를 입력해 주세요" required/>
                            <button class="btn btn-secondary" type="button" id="idCheck" style="background-color: black"
                                    onclick='
                                        if (!document.getElementById("userId").value) {
                                            alert("아이디를 입력해 주세요");
                                            //커서 이동
                                            doc.getElementById("userId").focus();
                                            return;
                                        }else{
                                            window.open("check.php?userId="+document.getElementById("userId")
                                            .value,"chkid","width=500,height=200")}'>확인
                            </button>
                        </div>

                        <div class="label1">PassWord</div>
                        <div class="form1">
                            <input type="password" id="userPass" name="userPass" placeholder="비밀번호를 입력해 주세요 (6자리 이상)" required/>
                        </div>

                        <div class="label1">PW check</div>
                        <div class="form1">
                            <input type="password" id="passCheck" placeholder="비밀번호를 다시 입력해 주세요" required/>
                        </div>

                        <div class="label1">Name</div>
                        <div class="form1">
                            <input type="text" id="userName" name="userName" placeholder="이름을 입력해 주세요" required/>
                        </div>

                        <div class="label1">Phone</div>
                        <div class="form2">
                            <input type="tel" id="userPhone" name="userPhone" placeholder="전화번호를 입력해 주세요" required/>
                            <button class="btn btn-secondary" type="button" id="telCheck"
                                    style="background-color: black">인증
                            </button>
                        </div>

                        <div class="label1">필수 동의 항목</div>
                        <div class="form">
                            <input type="checkbox" id="chk1"
                                   onclick='window.open("agree_1.php","chkagr1","width=1000,height=400")' required>
                            FESTICKET 이용약관 동의<br>
                            <input type="checkbox" id="chk2"
                                   onclick='window.open("agree_2.php","chkagr2","width=1000,height=400")' required> 개인정보
                            수집 및 이용 동의<br>
                            <!--팝업(탭)오픈script>window.open('noti.php');</script-->
                        </div>
                        <input type="submit" class="btn btn-primary btn-block" id="signupButton" value='가입하기'>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>

<script type="text/javascript" src="signup.js"></script>

</body>
</html>
