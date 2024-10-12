<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Ogrzewanie</title>
    <link rel="stylesheet" href="style.css">
	<script src="https://js.hcaptcha.com/1/api.js" async defer></script>  <!captcha ES_4b30aa1a8e7a46d49286ed3e244bfdb6 >
		
</head>
<body>
    <h1>Ogrzewanie- sekcja admin</h1>

    <form method="post" action="" class="animacja-wlaczania">
        <label for="pin">Hasło:</label>
        <input type="password" maxlength="8" name="pin" id="pin">
		<?php
			$proby = json_decode(file_get_contents('proby.json'), true);
			if($proby['i']>4)
			{
				echo("<div class='h-captcha' data-sitekey='0da84802-f86e-4ac0-b018-d6405eda4792'></div>");
			}
			
		?>
        <input style="cursor: pointer" type="submit" value="wyczyść kalendarz" name="kalendarz">
		<input style="cursor: pointer" type="submit" value="wyczyść liczniki" name="liczniki">
    </form>

	

	
    <?php				
		

		$zdaneCaptcha = true;
				
        if (isset($_POST['liczniki'])) 
		{
					
			if($proby['i']>5)
			{
				$secretKey = "ES_4b30aa1a8e7a46d49286ed3e244bfdb6";
				$response = $_POST['h-captcha-response'];

				// Sprawdzenie poprawności hCaptcha
				$verify = file_get_contents("https://hcaptcha.com/siteverify?secret={$secretKey}&response={$response}");
				$captchaSuccess = json_decode($verify);

				$zdaneCaptcha = $captchaSuccess->success; // zmienna bool
			}

			if ($_POST['pin'] == "admin456" && $zdaneCaptcha) 
			{
				$proby['i']=0;
				
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
				$proby['i']++;
                echo("<p class=\"status grzeje\" style=\"color: red;\">Hasło niepoprawne</p>");
            }

        }
		
		if (isset($_POST['kalendarz'])) 
		{
			
			if($proby['i']>5)
			{
				$secretKey = "ES_4b30aa1a8e7a46d49286ed3e244bfdb6";
				$response = $_POST['h-captcha-response'];

				// Sprawdzenie poprawności hCaptcha
				$verify = file_get_contents("https://hcaptcha.com/siteverify?secret={$secretKey}&response={$response}");
				$captchaSuccess = json_decode($verify);

				$zdaneCaptcha = $captchaSuccess->success; // zmienna bool
			}
			
			if ($_POST['pin'] == "admin456" && $zdaneCaptcha) 
			{				
				$proby['i']=0;
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
				$proby['i']++;
                echo("<p class=\"status grzeje\" style=\"color: red;\">Hasło niepoprawne</p>");
            }

        }
		file_put_contents('proby.json', json_encode($proby));
    ?>	
<br>
<br>
<a href="dane.json">dane.json</a>
<br>
<a href="kalendarz.json">kalendarz.json</a>
<br>
<a href="proby.json">proby.json</a>

</body>
</html>
