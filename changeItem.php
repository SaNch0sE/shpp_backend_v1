<?php 
	header("Access-Control-Allow-Origin: *");
	$data = json_decode(file_get_contents('tasks.json'), true);
	$i = 0;
	$output['ok'] = false;
	foreach ($data as $key => $value) {
		if ($value['id'] === intval($_GET['id'])) {
			$data[$i] = ['id' => intval($_GET['id']), 'text' => $_GET['text'], 'checked' => filter_var($_GET['checked'], FILTER_VALIDATE_BOOLEAN)];
			$output['ok'] = true;
			break;
		}
		$i += 1;
	}
	file_put_contents('tasks.json', json_encode($data));
	echo json_encode($output);