<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST");
	$data = json_decode(file_get_contents('php://input'), true);
	$id = htmlspecialchars($data['id']);
	try {
		if (is_int($id) && $id >= 0) {
			require_once 'err-handler.php';
			$db = json_decode(file_get_contents('tasks.json'), true);
			$output['ok'] = false;
			$i = 0;
			foreach ($db as $key => $subArr) {
				if ($subArr['id'] === intval($id)) {
					unset($db[$i]);
					$db = array_values($db);
					$output['ok'] = true;
				}
				$i += 1;
			}
			file_put_contents('tasks.json', json_encode($db));
			echo json_encode($output);
		} else {
			throw new Exception("Bad Input Data");
		}
	} catch (Exception $e) {
		header('HTTP/2 400 Error Processing Request');
		$err = ['error' => "<h1>".$e->getMessage()."</h1><p>Input Data: ".json_encode($_GET)."</p>"];
		echo json_encode($err);
	}