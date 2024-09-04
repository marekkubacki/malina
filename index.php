<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Ogrzewanie</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Ogrzewanie</h1>

    <form method="post" action="index.php" class="animacja-wlaczania">
        <label for="pin">Hasło:</label>
        <input type="password" maxlength="8" name="pin" id="pin">
        
        <label for="suwak">Ustaw czas grzania:</label>
        <input type="range" id="suwak" name="autooff" min="1800" max="36000" value="10800" oninput="updateValue(this.value)">
        <span id="czas">3 godziny 0 minut</span>

        <input type="submit" value="ON / OFF" name="onoff">
    </form>

    <?php
        function rozbicie_sekund($sekundy) 
		{
            $godziny = floor($sekundy / 3600);
            $sekundy %= 3600;
            $minuty = floor($sekundy / 60);
            $sekundy %= 60;
            return($godziny."h : ".$minuty."min : ".$sekundy."sec");
        }

        $plik = 'dane.json';
        $dane = json_decode(file_get_contents($plik), true);
        $wlacz = $dane['przycisk'];

        if (isset($_POST['onoff'])) 
		{
				if ($_POST['pin'] == "456") {
					if($wlacz==0)
				{
					$wlacz=1;

				}
				else
				{
					$wlacz=0;

				}
                $dane['auto_off'] = intval($_POST['autooff']);
                $dane['przycisk'] = intval($wlacz);
                file_put_contents($plik, json_encode($dane));
            } 
			else 
			{
                echo("<p class=\"status grzeje\" style=\"color: red;\">Hasło niepoprawne</p>");
            }
        }

        if ($wlacz == 0) 
		{
            echo("<p class=\"status zimne\">Ogrzewanie - zimne</p>");
        } 
		else 
		{
            echo("<p class=\"status grzeje\">Ogrzewanie - grzeje</p>");
        }

        echo("<p>Czas pracy ogrzewania (licznik główny):<br>" . rozbicie_sekund($dane["licznik"]) . "</p>");
        echo("<p>Czas pracy od ostatniego włączenia:<br>" . rozbicie_sekund($dane["aktualnie"]) . "</p>");
    ?>
	zużycie w poszczególnych miesiącach:
    <div class="dane-miesieczne">
        <?php
            $max_zuzycie = max($dane['miesiace'])/3600;
            foreach ($dane['miesiace'] as $miesiac => $zuzycie)
			{
				$zuzycie=$zuzycie/3600;
                $wysokosc = ($zuzycie / $max_zuzycie) * 100 + 7;
				$zuzycie= round($zuzycie);
                echo "
                    <div class='miesiac'>
                        <div class='słupek' style='height: {$wysokosc}%;'>
                            {$zuzycie}
                        </div>
                        <span>{$miesiac}</span>
                    </div>
                ";
            }
        ?>
    </div>

    <script>
        function updateValue(sekundy) 
		{
            const godziny = Math.floor(sekundy / 3600);
            const minuty = Math.floor((sekundy % 3600) / 60);
            document.getElementById('czas').textContent = `${godziny} h ${minuty} min`;
        }

        updateValue(document.getElementById('suwak').value);
    </script>
</body>
</html>
