<?php
session_start();
if (isset($_SESSION['id'])) {//이미로그인한상태 메인으로 이동시킨다
    echo "<meta http-equiv=refresh content=0;url=http://localhost/no3/>";//자동이동
    exit;
}

if (isset($_POST["login_check"])) {
    include "login_check.php";
}

?>

<!DOCTYPE HTML>
<html lang="en; ko">
<head>
    <meta charset="utf-8">
    <title>FESTICKET</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

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
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">L O G I N</h5>
                    <form class="form-signin" method="post">
                        <div class="form-label-group">
                            <label for="inputEmail">ID</label>
                            <input type="text" id="inputEmail" name="id" class="form-control" required autofocus>
                        </div>

                        <div class="form-label-group">
                            <label for="inputPassword">Password</label>
                            <input type="password" id="inputPassword" name="pw" class="form-control" required>
                        </div>

                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="idSaveCheck" name="auto_login"
                                   value="2"/>
                            <label class="custom-control-label" for="customCheck1">ID를 기억합니다</label>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" name="login_check">Login</button>
                    </form>
                    <hr class="my-4">
                    <button class="btn1 btn-google btn-block" type="submit"><i class="fab fa-google mr-2"></i> Sign in
                        with Google
                    </button>
                    <button class="btn1 btn-facebook btn-block" type="submit"><i class="fab fa-facebook-f mr-2"></i>
                        Sign in with Facebook
                    </button>
                    <form action="signup.php" style="horiz-align: center">
                        <br>아직 회원이 아니십니까?
                        <input type="submit" class="btn btn-secondary" value="Sign up">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Contact form JavaScript -->
<!-- Do not edit these files! In order to set the email address and subject line for the contact form go to the bin/contact_me.php file. -->
<script src="js/jqBootstrapValidation.js"></script>
<script src="js/contact_me.js"></script>

<script>
    $(document).ready(function () {
        // 저장된 쿠키값을 가져와서 ID 칸에 넣어준다. 없으면 공백으로 들어감.
        var userInputId = getCookie("userInputId");
        $("input[name='id']").val(userInputId);

        if ($("input[name='id']").val() != "") { // 그 전에 ID를 저장해서 처음 페이지 로딩 시, 입력 칸에 저장된 ID가 표시된 상태라면,
            $("#idSaveCheck").attr("checked", true); // ID 저장하기를 체크 상태로 두기.
        }

        $("#idSaveCheck").change(function () { // 체크박스에 변화가 있다면,
            if ($("#idSaveCheck").is(":checked")) { // ID 저장하기 체크했을 때,
                var userInputId = $("input[name='id']").val();
                setCookie("userInputId", userInputId, 7); // 7일 동안 쿠키 보관
            } else { // ID 저장하기 체크 해제 시,
                deleteCookie("userInputId");
            }
        });

        // ID 저장하기를 체크한 상태에서 ID를 입력하는 경우, 이럴 때도 쿠키 저장.
        $("input[name='id']").keyup(function () { // ID 입력 칸에 ID를 입력할 때,
            if ($("#idSaveCheck").is(":checked")) { // ID 저장하기를 체크한 상태라면,
                var userInputId = $("input[name='id']").val();
                setCookie("userInputId", userInputId, 7); // 7일 동안 쿠키 보관
            }
        });
    });

    function setCookie(cookieName, value, exdays) {
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var cookieValue = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toGMTString());
        document.cookie = cookieName + "=" + cookieValue;
    }

    function deleteCookie(cookieName) {
        var expireDate = new Date();
        expireDate.setDate(expireDate.getDate() - 1);
        document.cookie = cookieName + "= " + "; expires=" + expireDate.toGMTString();
    }

    function getCookie(cookieName) {
        cookieName = cookieName + '=';
        var cookieData = document.cookie;
        var start = cookieData.indexOf(cookieName);
        var cookieValue = '';
        if (start != -1) {
            start += cookieName.length;
            var end = cookieData.indexOf(';', start);
            if (end == -1) end = cookieData.length;
            cookieValue = cookieData.substring(start, end);
        }
        return unescape(cookieValue);
    }
</script>
</body>
</html>
