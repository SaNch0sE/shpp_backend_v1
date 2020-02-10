<?php
	header("Access-Control-Allow-Origin: *");
	$data = json_decode(file_get_contents('tasks.json'), true);
	$id = end($data)['id']+1;
	$data[$id] = ['id' => $id, 'text' => $_GET['text'], 'checked' => false];
	file_put_contents('tasks.json', json_encode($data));
	echo json_encode(['id' => $id]);