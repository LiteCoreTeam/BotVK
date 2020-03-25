<?php
$domen = ''; // ДОМЕН ДЛЯ СООБЩЕНИЯ/РЕДИРЕКТА
$token = ''; // ТОКЕН ГРУППЫ
$anofs = ''; // ОТВЕТ КОТОРЫЙ ДОЛЖЕН ВЕРНУТЬ СЕРВЕР

if (!isPost()) {
    header('Location: http://'.$domen);
    exit;
}

include 'vk_api.php';
$vk = new vk_api($token, '5.82');
$data = json_decode(file_get_contents('php://input'));
if ($data->type === 'confirmation') {
	exit($anofs);
}
$vk->sendOK();
$peer_id = $data->object->peer_id;
$id = $data->object->from_id;
$message = $data->object->text;
$messagei = strtolower($message);

if ($data->type === 'message_new') {
    if(substr($messagei, 0, 3) === '/id'){
    	if ($id === $peer_id) {
    		$vk->sendMessage($peer_id, 'Ваш айди: '.$id);
            $vk->sendOK();
    	}else{
    		$vk->sendMessage($peer_id, 'Ваш айди: '.$id.PHP_EOL.'Айди беседы: '.$peer_id);
            $vk->sendOK();
    	}
    	
    	exit();
    }

    if(substr($messagei, 0, 5) === '/info'){
    	$vk->sendMessage($peer_id, "Пусто");
        $vk->sendOK();
    	exit();
    }

    if(substr($messagei, 0, 5) === '/rand'){
    	$rand = rand();
    	$vk->sendMessage($peer_id, "Сгенерировано случайное число: $rand");
        $vk->sendOK();
    	exit();
    }
    
    if(substr($messagei, 0, 5) === '/sell'){
    	$vk->sendMessage($peer_id, "В продаже..");
        $vk->sendOK();
    	exit();
    }

    if(substr($messagei, 0, 6) === '/rules'){
    	$vk->sendMessage($peer_id, "Пусто");
        $vk->sendOK();
    	exit();
    }
}

function isPost(){
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}