<?php
	$host = "94.73.150.252";
	$user = "incnetRoot";
	$passwd = "6eI40i59n22M7f9LIqH9";
	$dbname = "incnet";
?>
<html>
	<head>
		<title>Kayıt 2019 | Aday Takip</title>
		<meta charset=UTF-8 />
		<style>
			table, th, td{
				border: 1px solid black;
			}
		</style>
	</head>
	<body>
		<form>
			Sırala:<br/>
				<select name=sort_by>
					<option value=aday_no <?php if(!isset($_GET['sort_by']) || $_GET['sort_by'] == "aday_no") echo("selected"); ?> >Aday No</option>
					<option value=ad <?php if($_GET['sort_by'] == "ad") echo("selected"); ?> >Ad </option>
					<option value=soyad <?php if($_GET['sort_by'] == "soyad") echo("selected"); ?> > Soyad</option>
					<option value=grup <?php if($_GET['sort_by'] == "grup") echo("selected"); ?> > Grup</option>
				</select>
				<select name=sort_dir>
					<option value="ASC" <?php if(!isset($_GET['sort_dir']) || $_GET['sort_dir'] == "ASC") echo("selected"); ?> >Küçükten Büyüğe</option>
					<option value="DESC" <?php if($_GET['sort_dir'] == "DESC") echo("selected"); ?> >Büyükten Küçüğe</option>
				</select>
			<br/>
			Filtrele:<br/>
			<label for=aday_no>Aday No</label> <input id=aday_no name=aday_no <?php if(isset($_GET['aday_no'])) echo("value=\"$_GET[aday_no]\""); ?> /> 
			<label for=ad>Ad</label> <input id=ad name=ad <?php if(isset($_GET['ad'])) echo("value=\"$_GET[ad]\""); ?> /> 
			<label for=soyad>Soyad</label> <input id=soyad name=soyad <?php if(isset($_GET['soyad'])) echo("value=\"$_GET[soyad]\""); ?> /> 
			<label for=grup>Grup</label> <input id=grup name=grup <?php if(isset($_GET['grup'])) echo("value=\"$_GET[grup]\""); ?> /><br/>
			<input type=submit name=filter value=Filtrele>
		</form>
		<table>
		<meta charset=UTF-8 />
			<tr>
				<th>Aday No</th>
				<th>Ad</th>
				<th>Soyad</th>
				<th>TCKN</th>
				<th>Grup</th>
				<th>Geldi</th>
				<th>CAS Mülakatına Girdi</th>
				<th>Öğretmen Mulakatına Girdi</th>
				<th>İngilizce Sınavına Girdi</th>
			</tr>
<?php
			
			$conn = mysqli_connect($host, $user, $passwd, $dbname) or die("Veritabanına bağlanılamadı!<br/>\n".mysqli_connect_error());
			
			$condition = "true";
			
			if(isset($_GET['aday_no']) && $_GET['aday_no'] != ""){
				$condition.=" AND aday_no=".mysqli_real_escape_string($conn, $_GET['aday_no']);
			}
			if(isset($_GET['ad']) && $_GET['ad'] != ""){
				$condition.=" AND ad LIKE \"".mysqli_real_escape_string($conn, $_GET['ad'])."\"";
			}
			if(isset($_GET['soyad']) && $_GET['soyad'] != ""){
				$condition.=" AND soyad LIKE \"".mysqli_real_escape_string($conn, $_GET['soyad'])."\"";
			}
			if(isset($_GET['grup']) && $_GET['grup'] != ""){
				$condition.=" AND grup LIKE \"".mysqli_real_escape_string($conn, $_GET['grup'])."\"";
			}
			
			$sql = "SELECT * FROM kamp2019takip WHERE $condition ".(isset($_GET['sort_by'], $_GET['sort_dir']) ? ("ORDER BY ".mysqli_real_escape_string($conn, "$_GET[sort_by] $_GET[sort_dir]")) : "");
			$res = mysqli_query($conn, $sql) or die("$sql<br/>\n".mysqli_error($res));
			mysqli_query($conn, "SET NAMES utf8") or die("ERR: ".mysqli_error($res));
			
			while($row = mysqli_fetch_assoc($res)){
				echo("			<tr>
				<td>$row[aday_no]</td>
				<td>$row[ad]</td>
				<td>$row[soyad]</td>
				<td>$row[tckn]</td>
				<td>$row[grup]</td>
				<td>".($row['geldi']?$row['geldi']:"HAYIR")."</td>
				<td>".($row['cas']?$row['cas']:"HAYIR")."</td>
				<td>".($row['mulakat']?$row['mulakat']:"HAYIR")."</td>
				<td>".($row['ingilizce']?$row['ingilizce']:"HAYIR")."</td>
			</tr>\n");
			}
		?>
		</table>
	</body>
</html>