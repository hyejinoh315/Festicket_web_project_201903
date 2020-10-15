<div style="position: fixed; top: 90%; left: 70%; z-index: 99; width: 300px; background-color: #404040"
<?php
if (isset($_POST["pop_close"])) {echo "hidden";} else{}
?>>
    <div style="font-family:굴림;font-size:18px; padding:3px 5px;color: white;width: 260px;">
        　<?=$message?>
    </div>
    <div style="float:left;">
        <a href="book.php?id=">
            <input class="btn" style="cursor:pointer; color: #34d0ff;" value="북마크 보기">
        </a>
    </div>
    <div style="float: left;">
        <form method="post">
            <input type="submit" name="pop_close" class="btn" style="cursor:pointer; color: #ff0000;" value="닫기">
        </form>
    </div>
</div>
