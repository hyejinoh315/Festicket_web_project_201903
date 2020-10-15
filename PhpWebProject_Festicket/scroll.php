<?php
//$duration = 24 * 60 * 60 * 30;  // 30일
//ini_set('session.gc_maxlifetime', $duration);
//session_set_cookie_params($duration);
session_start();
?>

<!DOCTYPE html>
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


    <!---->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <style type="text/css">
        .ajax-load{
            background: #e1e1e1;
            padding: 10px 0px;
            width: 100%;
        }
    </style>
</head>

<body>

<?php
include("navbar.php");
?>

<header>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <!--움직이는 사진 밑의 흰색 바-->
            <?php
            $conn = mysqli_connect('localhost', 'root', '1442', 'tests');
            $sql = "SELECT * FROM ad";
            $result = mysqli_query($conn, $sql);
            $i = 0;
            while ($row = mysqli_fetch_array($result)) { ?>
                <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" <?php if ($i == 0) {
                    echo "class=\"active\"";
                } ?>></li>
                <?php $i++;
            } ?>
        </ol>
        <div class="carousel-inner" role="listbox">
            <?php
            $conn = mysqli_connect('localhost', 'root', '1442', 'tests');
            $sql = "SELECT * FROM ad";
            $result = mysqli_query($conn, $sql);
            $i = 0;
            while ($row = mysqli_fetch_array($result)) { ?>
                <!-- Slide One - Set the background image for this slide in the line below -->
                <div class="carousel-item <?php if ($i == 0) {
                    echo "active";
                } ?>"
                     style="background-image: url('<?php echo $row['img']; ?>')">
                    <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.5);">
                        <!--a href="#" style="color: #ffffff"-->
                        <h3><?php echo $row['title']; ?></h3>
                        <p><?php echo $row['memo']; ?></p>
                        </a>
                    </div>
                </div>
                <?php $i++;
            } ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</header>
<!--php 동작 확인
   현재시간(php 동작 확인): <b> <? date_default_timezone_set("Asia/Seoul");
echo date("Y-m-d H:i:s") ?></b>-->
<!-- Page Content -->
<div class="container card-body">
    <!-- Portfolio Section -->
    <h1 style="font-family:monospace; font-style:revert; float: left;">FESTIVALS</h1>

    <!-- 페스티벌 검색창 -->
    <span class="col-md-5 card-body input-group">
        <input type="hidden" class="form-control" placeholder="Search for...">
          <span class="input-group-btn">
              <button class="btn btn-secondary" type="button" style="background-color: white; border: white"></button>
          </span>
      </span>

    <div class="row">
        <?php
        //상시-저장된 값 보여주기
        $conn = mysqli_connect('localhost', 'root', '1442', 'tests');
        $sql = "SELECT * FROM fesitval ORDER BY date DESC LIMIT 9";
        $result = mysqli_query($conn, $sql);
        include('data.php');
        ?>
    </div>

    <!-- 페이지 맨 위로 -->
    <div id="gototop">
        ▲GO TO TOP▲
    </div>

</div>
<!-- /.container -->
<?php
include("footer.php");
?>
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    $(function () {
        $("#gototop").on("click",function (e) {
            $('html,body').animate({
                scrollTop:690
            },200);
        });
    });
</script>


<div class="ajax-load text-center" style="display:none">
    <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More post</p>
</div>


<script type="text/javascript">
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height()) {
            var last_id = $(".post-id:last").attr("id");
            loadMoreData(last_id);
        }
    });


    function loadMoreData(last_id){
        $.ajax(
            {
                url: '/loadMoreData.php?last_id=' + last_id,
                type: "get",
                beforeSend: function()
                {
                    $('.ajax-load').show();
                }
            })
            .done(function(data)
            {
                $('.ajax-load').hide();
                $("#post-data").append(data);
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                alert('server not responding...');
            });
    }
</script>


</body>
</html>