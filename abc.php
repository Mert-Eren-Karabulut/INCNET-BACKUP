<?php
	if(isset($_GET['token'])){
		if($_GET['token'] != "abc123"){
			die("Token invalid");
		}
	}else die("Automated use only!");
?>