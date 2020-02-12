<?php 
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST");
	$data = json_decode(file_get_contents('tasks.json'), true);
	$i = 0;
	$output['ok'] = false;
	foreach ($data as $key => $value) {
		if ($value['id'] === $_GET['id']) {
			$data[$i] = ['id' => intval($_GET['id']), 'text' => $_GET['text'], 'checked' => filter_var($_GET['checked'], FILTER_VALIDATE_BOOLEAN)];
			$output['ok'] = true;
			break;
		}
		$i += 1;
	}
	$data = array_values($data);
	file_put_contents('tasks.json', json_encode($data));
	echo json_encode($output);