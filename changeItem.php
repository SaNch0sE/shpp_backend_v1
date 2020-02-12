<?php
	require_once = 'err-handler';
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST");
	try {
		if (isset($_GET['id']) && isset($_GET['text']) && isset($_GET['checked']) && $_GET['id'] != undefined && $_GET['text'] != undefined && $_GET['checked'] != undefined) {
			$data = json_decode(file_get_contents('tasks.json'), true);
			$i = 0;
			$output['ok'] = false;
			foreach ($data as $key => $subArr) {
				if ($subArr['id'] === intval($_GET['id'])) {
					$data[$i] = ['id' => intval($_GET['id']), 'text' => $_GET['text'], 'checked' => filter_var($_GET['checked'], FILTER_VALIDATE_BOOLEAN)];
					$output['ok'] = true;
					break;
				}
				$i += 1;
			}
			$data = array_values($data);
			file_put_contents('tasks.json', json_encode($data));
			echo json_encode($output);
		} else {
			throw new Exception("Bad Input Data");
		}
	} catch ($e) {
		header('HTTP/2 400 Error Processing Request');
		$err = ['error' => "<h1>".$e->getMessage()."</h1><p>Input Data: ".json_encode($_GET)."</p>"];
		echo json_encode($err);
	}