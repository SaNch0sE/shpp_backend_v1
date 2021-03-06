<?php
	require_once 'err-handler.php';
	$data = json_decode(file_get_contents('php://input'), true);
	$id = intval(htmlspecialchars($data['id']));
	try {
		$db = json_decode(file_get_contents('tasks.json'), true);
		if ($id >= 0 && $id <= end($db)['id']) {
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
		$err = ['error' => "<h1>".$e->getMessage()."</h1><p>Input Data: ".json_encode($data)."</p>"];
		echo json_encode($err);
	}