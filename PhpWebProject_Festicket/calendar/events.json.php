<?php
$conn=mysqli_connect("localhost", "root", "1442", "tests"); //접속하기
$res =mysqli_query($conn,"SELECT * FROM fesitval");

$out = array();
$color = array("event-warning", "event-success", "event-info", "event-inverse", "event-special", "event-important", "");
$i=0;
while($data = mysqli_fetch_array($res)) {
    $out[] = array(
        'id' => $data['id'],
        'title' => $data['title'],
        'start' => strtotime($data['date']).'000',
        'end' => strtotime($data['date_end']).'000',
        'url' => "http://localhost/no3/festivals_post.php?id={$data['id']}",
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
