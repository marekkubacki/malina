<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Ogrzewanie</title>
    <link rel="stylesheet" href="style.css">
	
		
</head>
<body>
    <h1>Ogrzewanie- sekcja admin</h1>

    <form method="post" action="" class="animacja-wlaczania">
        <label for="pin">Hasło:</label>
        <input type="password" maxlength="8" name="pin" id="pin">
        

        <input style="cursor: pointer" type="submit" value="wyczyść kalendarz" name="kalendarz">
		<input style="cursor: pointer" type="submit" value="wyczyść liczniki" name="liczniki">
    </form>

	

	
    <?php				
		


				
        if (isset($_POST['liczniki'])) 
		{
			//session_start();
			if ($_POST['pin'] == "admin456") 
			{
				sleep(3);
				$plik = 'dane.json';
				$dane = json_decode(file_get_contents($plik), true);
				$dane['ostatni']=0;
				$dane['dzis']=0;
				$dane['licznik']=0;
				$dane['aktualnie']=0;
				file_put_contents($plik, json_encode($dane));
				echo "wyczyszczono liczniki";
			}
				
			else 
			{
				sleep(3);
                echo("<p class=\"status grzeje\" style=\"color: red;\">Hasło niepoprawne</p>");
            }

        }
		
		if (isset($_POST['kalendarz'])) 
		{
			//session_start();
			if ($_POST['pin'] == "admin456") 
			{				
				sleep(3);
				$stary = 'kalendarz.json';
				$nowy = 'czysty_kalendarz.json';
				
				if (copy($nowy , $stary)) 
				{
					echo "czyszczenie udane";
				} 
				else 
				{
					echo "wystąpił problem podczas kopiowania pliku, czyszczenie nieudane";
				}

			}
			else 
			{
				sleep(5);
                echo("<p class=\"status grzeje\" style=\"color: red;\">Hasło niepoprawne</p>");
            }

        }
		
    ?>	
<br>
<br>
<a href="dane.json">dane.json</a>
<br>
<a href="kalendarz.json">kalendarz.json</a>

</body>
</html>
