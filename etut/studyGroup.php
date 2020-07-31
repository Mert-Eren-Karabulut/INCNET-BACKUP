<style>
	.inherit{
		font-family: inherit;
		font-size: inherit;
		text-decoration: inherit;
		color: inherit;
		text-decoration-color: inherit;
	}
</style>

<br/>
<div class=titleDiv style="font-size: 14pt;">Study Group Options for Today <br/> <a style="text-decoration: underline;" class=inherit href=# onclick="alert('Study groups are enabled today. That means if you want to do group study, you can register through here.');">What is this?</a></div><br/>
<br/>

<?php
	$sql = "SELECT * FROM etut_groups WHERE group_id=(SELECT group_id FROM etut_group_joins WHERE user_id=$_SESSION[user_id])";
	$res = mysql_query($sql) or die(mysql_error()."<br/>".$sql);
	while($row = mysql_fetch_assoc($res)){
		$sql2 = "SELECT name, lastname FROM coreusers WHERE user_id=(SELECT owner_id FROM etut_groups WHERE group_id=$row[group_id])";
		$res2 = mysql_query($sql2) or die(mysql_error()."<br/>".$sql2);
		$row2 = mysql_fetch_assoc($res2);
		echo("You are studying in ".ucwords(camelCaseToSpaces($row[room]))." with $row2[name] $row2[lastname]'s group. <form action=# method=POST><input type=Submit name=drop value=Drop><input type=hidden name=dropId value=$row[group_id]></form>");
		$yes = true;
	}
	if(!$yes){
		$sql = "SELECT room, dropped, group_id FROM etut_groups WHERE owner_id=$_SESSION[user_id]";
		$res = mysql_query($sql) or die(mysql_error()."<br/>".$sql);
		if($row = mysql_fetch_assoc($res)){
			$yes = true;
			if($row['dropped'] == 1)
				echo("You have created a study group at $row[room] but are not attending. <form action=# method=POST><input type=Submit name=attend value=Attend></form>");
			else
				echo("You are studying in $row[room] with your group. <form action=# method=POST><input type=Submit name=dropOwn value=Drop><input type=hidden name=dropId value=$row[group_id]></form>");
		}
	}
	if(!$yes){
		echo "You have not been registered to a group. <a href=createGroup.php>Create a new group</a>";
	}
?>
<br/>