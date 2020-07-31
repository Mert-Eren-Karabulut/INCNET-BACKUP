<?php
die();//Just in case, disabling for now
	$chat_name = "The Mighty Feyzioglus";
	
	
	
	$contact = $_POST['contact'];
	$message = $_POST['message'];
	
	//ob_start();
	var_dump($_POST);
	if($contact['name'] == $chat_name){
		if($message['body']['text'] == "/test" || true){
			$response = file_get_contents("https://www.waboxapp.com/api/send/chat?token=76eed66ef0d6b040159dbc6efb2efe915c291737736f8&uid=905378504018&to=".urlencode($contact['uid'])."&custom_uid=1234abclelelel121aa&text=hey");
			file_get_contents("https://www.waboxapp.com/api/send/chat?token=76eed66ef0d6b040159dbc6efb2efe915c291737736f8&uid=905378504018&to=905378504018&custom_uid=1234abclelelelel11aa&text=".urlencode($reponse));
		}
	}
	//file_get_contents("https://www.waboxapp.com/api/send/chat?token=76eed66ef0d6b040159dbc6efb2efe915c291737736f8&uid=905378504018&to=905378504018&custom_uid=1234abclelel1".time()."&text=".urlencode(ob_get_clean())); //DANGEROUS! Creates infinite loop!