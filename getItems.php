<?php
	require_once = 'err-handler';
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST");
	$tasks = json_decode(file_get_contents('tasks.json'));
	$data['items'] = $tasks;
	echo json_encode($data);