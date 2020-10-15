<?php


$mysqli = new mysqli('localhost', 'root', '1442', 'tests');


$sql = "SELECT * FROM order_data
         WHERE id < '".$_GET['last_id']."' ORDER BY id DESC LIMIT 3";


$result = $mysqli->query($sql);


$json = include('data.php');


echo json_encode($json);
?>