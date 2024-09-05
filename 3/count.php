<?php

require_once('function.php');
$db = db();
$data = print_r($_POST, 1);
$postData = file_get_contents('php://input');
$data = json_decode($postData, true);



$row = $db->select('ips', '*', 'ip = ?', [$data['ip']])->fetch();

if (!$row) {
	$id = $db->insert('ips', $data);
} else {
	$id = $row['id'];
}
if ($id) {
	$db->insert('visits', ['ip' => $id, 'created' => date('Y-m-d H:i:s')]);
}
var_dump($id);
print_r($data);
