<?php
	include("check_token.php");
?>

{
	"forceAltTitles": false,
	"vectors":[
		{
			"type": "BUTTON",
			"title_id": "checkin_btn_text",
			"alt_title": "Alternative Title",
			"onclick": "/test_module.php",
			"style": "See style spec",
			"force_alt_title": true
		},
		{
			"type": "BUTTON",
			"title_id": "pool_btn_text",
			"alt_title": "Alternative Title 2",
			"onclick": "/test_module2.php",
			"style": "See style spec"
		},
		{
			"type": "BUTTON",
			"title_id": "etut_btn_text",
			"alt_title": "Alternative Title 3",
			"onclick": "URL3",
			"style": "See style spec"
		}
	]
}