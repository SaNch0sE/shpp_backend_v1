<?php
	require_once 'err-handler.php';
	$data = json_decode(file_get_contents('php://input'), true);
	$text = htmlspecialchars($data['text']);
	try {
		if (isset($text) && $text != "") {
			$data = json_decode(file_get_contents('tasks.json'), true);
			$id = end($data)['id']+1;
			$data[$id] = ['id' => $id, 'text' => $text, 'checked' => false];
			$data = array_values($data);
			file_put_contents('tasks.json', json_encode($data));
			echo json_encode(['id' => $id]);
		} else {
			throw new Exception("Bad Input Data");
		}
	} catch (Exception $e) {
		header('HTTP/2 400 Error Processing Request');
		$err = ['error' => "<h1>".$e->getMessage()."</h1><p>Input Data: ".json_encode($_GET)."</p>"];
		echo json_encode($err);
	}