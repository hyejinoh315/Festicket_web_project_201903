<?php
session_start();
$id = $_SESSION['id'];
$conn = mysqli_connect('localhost', 'root', '1442', 'tests');

$sql_query = "SELECT * FROM users WHERE user_id='$id'"; //로그인시 입력된 아이디에 관련된 회원정보를 가져온다
$result = mysqli_query($conn, $sql_query) or die("database error:" . mysqli_error($conn));
$row_u = mysqli_fetch_assoc($result);

if (isset($_SESSION['id'])) { //세션이 존재할 경우 //echo $_SESSION['id']; -> 아이디 값이 나온다

}else{
    echo "<meta http-equiv=refresh content=0;url=http://localhost/no3/login.php>";//자동이동
    echo "<script>alert('로그인후 이용 가능한 페이지 입니다');</script>";
}

$conn = mysqli_connect('localhost', 'root', '1442', 'tests');
$sql = "SELECT f_id, img, title, date, date_end, locate FROM bookmark LEFT JOIN fesitval ON bookmark.f_id = fesitval.id WHERE u_id='$id'"; //로그인시 입력된 아이디에 관련된 회원정보를 가져온다
$result=mysqli_query($conn, $sql);

$out = array();
$color = array("event-warning", "event-success", "event-info", "event-inverse", "event-special", "event-important", "");
$i=0;
while($data = mysqli_fetch_array($result)) {
    $out[] = array(
        'id' => $data['f_id'],
        'title' => $data['title'],
        'start' => strtotime($data['date']).'000',
        'end' => strtotime($data['date_end']).'000',
        'url' => "http://localhost/no3/festivals_post.php?id={$data['f_id']}",
        'class' => $color[$i],
    );
    if($i<count($color)-1){
        $i++;
    }else{
        $i=0;
    }
}
echo json_encode(array('success' => 1, 'result' => $out));
exit;
?>

{
	"success": 1,
	"result": [
		{
			"id": "293",
			"title": "This is warning class event with very long title to check how it fits to evet in day view",
			"url": "http://www.example.com/",
			"class": "event-warning",
			"start": "1362938400000",
			"end":   "1363197686300"
		},
		{
			"id": "256",
			"title": "Event that ends on timeline",
			"url": "http://www.example.com/",
			"class": "event-warning",
			"start": "1363155300000",
			"end":   "1363227600000"
		},
		{
			"id": "276",
			"title": "Short day event",
			"url": "http://www.example.com/",
			"class": "event-success",
			"start": "1363245600000",
			"end":   "1363252200000"
		},
		{
			"id": "294",
			"title": "This is information class ",
			"url": "http://www.example.com/",
			"class": "event-info",
			"start": "1363111200000",
			"end":   "1363284086400"
		},
		{
			"id": "297",
			"title": "This is success event",
			"url": "http://www.example.com/",
			"class": "event-success",
			"start": "1363234500000",
			"end":   "1363284062400"
		},
		{
			"id": "54",
			"title": "This is simple event",
			"url": "http://www.example.com/",
			"class": "",
			"start": "1363712400000",
			"end":   "1363716086400"
		},
		{
			"id": "532",
			"title": "This is inverse event",
			"url": "http://www.example.com/",
			"class": "event-inverse",
			"start": "1364407200000",
			"end":   "1364493686400"
		},
		{
			"id": "548",
			"title": "This is special event",
			"url": "http://www.example.com/",
			"class": "event-special",
			"start": "1363197600000",
			"end":   "1363629686400"
		},
		{
			"id": "295",
			"title": "Event 3",
			"url": "http://www.example.com/",
			"class": "event-important",
			"start": "1364320800000",
			"end":   "1364407286400"
		}
	]
}
