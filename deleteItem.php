<?php
	require_once 'err-handler';
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST");
		if (isset($_GET['id']) && $_GET['id'] != undefined) {
			$data = json_decode(file_get_contents('tasks.json'), true);
			$output['ok'] = false;
			$i = 0;
			foreach ($data as $key => $subArr) {
				if ($subArr['id'] === intval($_GET['id'])) {
					unset($data[$i]);
					$data = array_values($data);
					$output['ok'] = true;
				}
				$i += 1;
			}
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