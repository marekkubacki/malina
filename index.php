<!DOCTYPE html>
<html>
<head>
	<title> ogrzewanie </title>
</head>

<body>
	<h1>
	TESTTT
	<center>
	<form method="post" action="index.php">
		<label>hasło: </label>
 		<input type="password" maxlength="8" name="pin">
		<input type="submit" value="zmień" name="onoff">
	</form>
<?php
	$licznik = file("licznik.txt")[0];
	$sczas = file("czasy.txt")[0];
	$wlacz = file("przelacznik.txt")[0];

	$czas=time();

	if(isset($_POST['onoff']))
	{
		if($_POST['pin']=="456")
		{
			if($wlacz==0)
			{
				$wlacz=1;
				file_put_contents("czasy.txt",$czas);	
				file_put_contents("przelacznik.txt",$wlacz);
				$gpio_on = shell_exec("/usr/local/bin/gpio -g mode 4 out");
			}
			else
			{
				$wlacz=0;
				file_put_contents("licznik.txt",$czas-$sczas+$licznik);
				file_put_contents("przelacznik.txt",$wlacz);
				$gpio_off = shell_exec("/usr/local/bin/gpio -g mode 4 in");
			}
		}
		else
		{
			echo("haslo niepoprawne <br>");
		}

	}
	if($wlacz==0)
	{
		echo("<p style=\"color: blue;\">ogrzewanie-zimne</p>");
	}
	else
	{
		echo("<p style=\"color: red;\">ogrzewanie-grzeje</p>");
	}
	echo("<br>");
	$sekundy = file("licznik.txt")[0];
	$godziny = floor($sekundy / 3600);
	$sekundy %= 3600;
	$minuty = floor($sekundy / 60);
	$sekundy %= 60;
	echo("czas pracy ogrzewania:<br>");
	echo($godziny."h : ".$minuty."min : ".$sekundy."sec");

?>
</center>
</h1>
</body>
</html>
