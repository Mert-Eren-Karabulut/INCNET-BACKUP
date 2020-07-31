<?php

$action = "ssl.php";
$method = "POST";

$tab = "&nbsp;&nbsp;&nbsp;&nbsp;";
echo("
Action is $action<br/>
Method is $method<br/>

<form action=$action method=$method>
<label for=username>username</label> $tab$tab
<input name=username id=username /><br/>
<label for=password>password</label> $tab$tab
<input name=password id=password type=\"password\"/><br/>
<input type=Submit />
");
