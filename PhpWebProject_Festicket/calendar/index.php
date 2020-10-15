<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>FESTICKET</title>

    <meta name="description" content="Full view calendar component for twitter bootstrap with year, month, week, day views.">
    <meta name="keywords" content="jQuery,Bootstrap,Calendar,HTML,CSS,JavaScript,responsive,month,week,year,day">
    <meta name="author" content="Serhioromano">
    <meta charset="UTF-8">

    <link rel="stylesheet" href="components/bootstrap2/css/bootstrap.css">
    <link rel="stylesheet" href="components/bootstrap2/css/bootstrap-responsive.css">
    <link rel="stylesheet" href="css/calendar.css">
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<div class="container">

    <?php
    include("navbar.php");
    ?>

    <div class="page-header">

        <!--<div class="pull-right form-inline">
            <div class="btn-group">
                <button class="btn btn-primary" data-calendar-nav="prev"><< 이전</button>
                <button class="btn" data-calendar-nav="today">오늘</button>
                <button class="btn btn-primary" data-calendar-nav="next">다음 >></button>
            </div>
        </div>-->

        <h3></h3>
        <small>@festicket</small>
    </div>

    <div class="row">
        <div class="span9">
            <div id="calendar"></div>
        </div>
        <div class="span2">
            <br>
            <div class="btn-group">
                <button class="btn btn-primary" data-calendar-nav="prev"><< 이전</button>
                <button class="btn" data-calendar-nav="today">오늘</button>
                <button class="btn btn-primary" data-calendar-nav="next">다음 >></button>
            </div>
            <br><br>
            <div class="row-fluid">
                <h4>달력 시작 요일</h4>
                <select id="first_day" class="span12">
                    <option value="" selected="selected">일요일 시작</option>
                    <option value="1">월요일 시작</option>
                </select>
            </div>
        </div>

    </div>
    <br><br>
    <?php
    include("footer.php");
    ?>

    <script type="text/javascript" src="components/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="components/underscore/underscore-min.js"></script>
    <script type="text/javascript" src="components/bootstrap2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="components/jstimezonedetect/jstz.min.js"></script>
    <script type="text/javascript" src="js/language/bg-BG.js"></script>
    <script type="text/javascript" src="js/language/nl-NL.js"></script>
    <script type="text/javascript" src="js/language/fr-FR.js"></script>
    <script type="text/javascript" src="js/language/de-DE.js"></script>
    <script type="text/javascript" src="js/language/el-GR.js"></script>
    <script type="text/javascript" src="js/language/it-IT.js"></script>
    <script type="text/javascript" src="js/language/hu-HU.js"></script>
    <script type="text/javascript" src="js/language/pl-PL.js"></script>
    <script type="text/javascript" src="js/language/pt-BR.js"></script>
    <script type="text/javascript" src="js/language/ro-RO.js"></script>
    <script type="text/javascript" src="js/language/es-CO.js"></script>
    <script type="text/javascript" src="js/language/es-MX.js"></script>
    <script type="text/javascript" src="js/language/es-ES.js"></script>
    <script type="text/javascript" src="js/language/es-CL.js"></script>
    <script type="text/javascript" src="js/language/es-DO.js"></script>
    <script type="text/javascript" src="js/language/ru-RU.js"></script>
    <script type="text/javascript" src="js/language/sk-SR.js"></script>
    <script type="text/javascript" src="js/language/sv-SE.js"></script>
    <script type="text/javascript" src="js/language/zh-CN.js"></script>
    <script type="text/javascript" src="js/language/cs-CZ.js"></script>
    <script type="text/javascript" src="js/language/ko-KR.js"></script>
    <script type="text/javascript" src="js/language/zh-TW.js"></script>
    <script type="text/javascript" src="js/language/id-ID.js"></script>
    <script type="text/javascript" src="js/language/th-TH.js"></script>
    <script type="text/javascript" src="js/calendar.js"></script>
    <script type="text/javascript" src="js/app.js"></script>

    <script type="text/javascript">
        var disqus_shortname = 'bootstrapcalendar'; // required: replace example with your forum shortname
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
</div>
</body>
</html>

<script type="text/javascript" src="qna.js"></script>

