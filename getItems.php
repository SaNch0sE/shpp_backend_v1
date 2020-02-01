<?php 
	$tasks = json_decode(file_get_contents('tasks.json'));
	$data['items'] = $tasks;
	echo json_encode($data);