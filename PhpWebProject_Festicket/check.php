<?php
$conn=mysqli_connect("localhost", "root", "1442", "tests"); //접속하기
$uid = $_GET["userId"];

if ($uid === "") {?>
    <div style='font-family:"malgun gothic"' ;>항목을 입력해 주세요.</div>
    <button value="닫기" onclick="window.close()">닫기</button>
    <?php
    return;
}

$sql = "SELECT user_id FROM users WHERE user_id='$uid'";
$result = mysqli_query($conn, $sql);

$member = mysqli_fetch_array($result, MYSQLI_NUM);
if ($member == 0) {
    ?>
    <div style='font-family:"malgun gothic"' ;><?php echo $uid; ?>는 사용가능한 아이디입니다.</div>
    <?php
} else {
    ?>
    <div style='font-family:"malgun gothic"; color:red;'><?php echo $uid; ?>는 중복된아이디입니다.</div>
    <?php
}
?>
<button value="닫기" onclick="window.close()">닫기</button>
<script>
</script>