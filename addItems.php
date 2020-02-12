<?php
	require_once = 'err-handler';
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST");
	$data = json_decode(file_get_contents('tasks.json'), true);
	$id = end($data)['id']+1;
	try {
		if (isset($_GET['text']) && $_GET['text'] != undefined) {
			$data[$id] = ['id' => $id, 'text' => $_GET['text'], 'checked' => false];
			$data = array_values($data);
			file_put_contents('tasks.json', json_encode($data));
			echo json_encode(['id' => $id]);
		} else {
			throw new Exception("Bad Input Data");
		}
	} catch ($e) {
		header('HTTP/2 400 Error Processing Request');
		$err = ['error' => "<h1>".$e->getMessage()."</h1><p>Input Data: ".json_encode($_GET)."</p>"];
		echo json_encode($err);
	}