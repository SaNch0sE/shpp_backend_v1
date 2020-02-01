<?php 
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