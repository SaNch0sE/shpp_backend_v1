<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: POST");
	$data = json_decode(file_get_contents('php://input'), true);
	$text = htmlspecialchars($data['text']);
	$checked = htmlspecialchars($data['checked']);
	$id = htmlspecialchars($data['id']);
	try {
		if ($id >= 0 && $text != undefined && $checked != undefined && ($checked|| $checked == false)) {
			require_once 'err-handler.php';
			$data = json_decode(file_get_contents('tasks.json'), true);
			$i = 0;
			$output['ok'] = false;
			foreach ($data as $key => $subArr) {
				if ($subArr['id'] === intval($id)) {
					$data[$i] = ['id' => intval($id), 'text' => $text, 'checked' => filter_var($checked, FILTER_VALIDATE_BOOLEAN)];
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
	} catch (Exception $e) {
		header('HTTP/2 400 Error Processing Request');
		$err = ['error' => "<h1>".$e->getMessage()."</h1><p>Input Data: ".json_encode($_GET)."</p>"];
		echo json_encode($err);
	}