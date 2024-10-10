<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Ogrzewanie</title>
    <link rel="stylesheet" href="style.css">
	
	<script>
		
			
			function czas_z_sekund(sekundy) 
			{
				const godziny = Math.floor(sekundy / 3600); // Obliczanie godzin
				const minuty = Math.floor((sekundy % 3600) / 60); // Obliczanie minut
				const pozostaleSekundy = sekundy % 60; // Obliczanie sekund
				return `${godziny} h : ${minuty} min : ${pozostaleSekundy} sec`;
			}
			function zwiekszaj_licznik(id) 
			{
				var czasElement = document.getElementById(id); // Odczytujemy element
				var czas = parseInt(czasElement.textContent); // Odczytujemy i parsujemy wartość jako liczbę
				czasElement.textContent = czas_z_sekund(czas); // Aktualizujemy zawartość elementu
				setInterval(() => {
					czas++; // Zwiększamy wartość o 1
					czasElement.textContent = czas_z_sekund(czas); // Aktualizujemy zawartość elementu
				}, 1000); // Aktualizacja co sekundę
			}
			function zmniejszaj_licznik(id) 
			{
				var czasElement = document.getElementById(id); // Odczytujemy element
				var czas = parseInt(czasElement.textContent); // Odczytujemy i parsujemy wartość jako liczbę
				czasElement.textContent = czas_z_sekund(czas); // Aktualizujemy zawartość elementu
				setInterval(() => {
					czas--; // Zwiększamy wartość o 1
					czasElement.textContent = czas_z_sekund(czas); // Aktualizujemy zawartość elementu
					if(czas<=0)
					{
						czasElement.textContent = "0:0:0";
						setTimeout(() => { window.location.reload(); }, 7000);
						//window.location.href = window.location.href;
						//window.location.reload();
						//<button onclick="window.location.reload()">Odśwież stronę</button>
					}
				}, 1000); // Aktualizacja co sekundę
			}

			function updateValue(sekundy) 
			{
				const godziny = Math.floor(sekundy / 3600);
				const minuty = Math.floor((sekundy % 3600) / 60);
				document.getElementById('czas').textContent = `${godziny} h ${minuty} min`;
			}
			
			//function ktorypop(numer)
			//{
				
				//let okienko = document.getElementById('okienko');
				

				//numer.style.border-width = '1px';
				//	okienko.style.display = 'block';
				
				//slupek.addEventListener('mouseout', () => {
				//	okienko.style.display = 'none';
				//});
			//}
			
			document.addEventListener('DOMContentLoaded', () => {
				
				updateValue(document.getElementById('suwak').value);
			
			
			
				for(let i=1; i<=12; i++)
				{
					const slupek = document.getElementById('slupek' + i);
					let okienko = document.getElementById('okienko' + i);
					
					slupek.addEventListener('mouseover', () => {
						okienko.style.display='block';
					});
				
					slupek.addEventListener('mouseout', () => {
						okienko.style.display = 'none';
					});
				}
			});

		
		
    </script>
</head>
<body>
    <h1>Ogrzewanie</h1>

    <form method="post" action="" class="animacja-wlaczania">
        <label for="pin">Hasło:</label>
        <input type="password" maxlength="8" name="pin" id="pin">
        
        <label for="suwak">Ustaw czas grzania:</label>
        <input type="range" id="suwak" name="autooff" min="1800" max="36000" value="10800" oninput="updateValue(this.value)">
        <span id="czas">3 h 0 min</span>

        <input style="cursor: pointer" type="submit" value="ON / OFF" name="onoff">
    </form>

	<div class='kolumna'>

	
    <?php
        function rozbicie_do_sekund($sekundy) 
		{
            $godziny = floor($sekundy / 3600);
            $sekundy %= 3600;
            $minuty = floor($sekundy / 60);
            $sekundy %= 60;
            return($godziny." h : ".$minuty." min : ".$sekundy." sec");
        }
		
		function rozbicie_do_minut($sekundy) 
		{
            $godziny = floor($sekundy / 3600);
            $sekundy %= 3600;
            $minuty = round($sekundy / 60);
			if($godziny>0)
				{return($godziny." h : ".$minuty." m");}
			else
				{return($minuty."m");}
        }
		
		function zmiana_koloru($wartosc, $max_wartosc) 
		{
			$pRed=220;
			$pGreen=240;	// kolor początkowy z którego jest przejście do czerwonego
			$pBlue=255;
			
			$red = $pRed + ($wartosc / $max_wartosc) * (255-230);
			$green = $pGreen*((1-($wartosc / $max_wartosc))/(1+2*($wartosc / $max_wartosc)));
			$blue =  $pBlue*((1-($wartosc / $max_wartosc))/(1+2.5*($wartosc / $max_wartosc)));
														  //  ^ prędkośc zanikania koloru
			return "rgba($red, $green, $blue, 0.85)";
		}
		
		function nazwa_miesiaca($numer)
		{
			$tablica= [
						'Styczeń',
						'Luty',
						'Marzec',
						'Kwiecień',
						'Maj',
						'Czerwiec',
						'Lipiec',
						'Sierpień',
						'Wrzesień',
						'Październik',
						'Listopad',
						'Grudzień'
					];
			return($tablica[$numer-1]);
		}
		
		

		
        $plik = 'dane.json';
        $dane = json_decode(file_get_contents($plik), true);
        $wlacz = $dane['przycisk'];
		
		
        if (isset($_POST['onoff'])) 
		{
			if($_POST['pin'] == "admin")
			{
				header('Location: /admin.php');// przejscie do sekcji admin
			}
			//session_start();
			if ($_POST['pin'] == "456") 
			{
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
				
				// Po przetworzeniu formularza przekierowujemy na stronę metodą GET
				header('Location: '.$_SERVER['PHP_SELF']);
				//exit();
            } 
			else 
			{
                echo("<p class=\"status grzeje\" style=\"color: red;\">Hasło niepoprawne</p><br><br><br><br>");
            }

        }
			
        if ($wlacz == 0) 
		{
            echo("<p class='status zimne'>Ogrzewanie - zimne</p></div>");
			echo("<p>Czas pracy ogrzewania:</p>");
			echo("<p class='status liczniki'>Licznik główny:<br>" . rozbicie_do_sekund($dane["licznik"]) . "</p>");
			echo("<p class='status liczniki'>Dzisiaj:<br>" . rozbicie_do_sekund($dane["dzis"]) . "</p>");
			echo("<p class='status liczniki'>Od ostatniego włączenia:<br>" . rozbicie_do_sekund($dane["aktualnie"]) . "</p>");
			
        } 
		else 
		{	
			echo("<p class='status grzeje'>Ogrzewanie - grzeje</p><br>");
			$licznik_autooff=$dane['auto_off']-$dane['aktualnie']-1;
			echo("<p class='status zimne' style='margin-right:-5px'>czas auto off: <p class='status zimne' id='licznik_autooff'>{$licznik_autooff}</p></p></div><br>");
            
			echo("<p>Czas pracy ogrzewania:</p>");
			echo("<div class='status liczniki'><p>Licznik główny:</p><p id='licznik'>{$dane["licznik"]}</p></div>");
			//echo("<p id='licznik'>{$dane["licznik"]}</p>");
			echo("<div class='status liczniki'><p>Dzisiaj:</p><p id='dzis'>{$dane["dzis"]}</p></div>");
			echo("<div class='status liczniki'><p>Od ostatniego włączenia:</p><p id='aktualnie'>{$dane["aktualnie"]}</p></div>");
			
			//echo("<p class='status liczniki'>Czas pracy od ostatniego włączenia:<br></p>");
			//echo("<p id='aktualnie'>{$dane["aktualnie"]}</p>");
			
			echo("<script> zmniejszaj_licznik('licznik_autooff');</script>");
			echo("<script> zwiekszaj_licznik('licznik'); </script>");
			echo("<script> zwiekszaj_licznik('aktualnie'); </script>");
			echo("<script> zwiekszaj_licznik('dzis'); </script>");			
        }
		
		// Użycie wttr.in do pobrania pogody w Warszawie
		$pogoda = file_get_contents("https://wttr.in/Warsaw?format=%t");
		// Sprawdzenie, czy dane zostały poprawnie pobrane
		if ($pogoda !== false) 
		{
			echo "<div class='pogoda'>Aktualna temperatura w Warszawie:<a href='https://wttr.in/Warsaw?format=1'> $pogoda</a></div>";
		} 
		else 
		{
			echo "Nie udało się pobrać danych.";
		}

		
    ?>	


	<br><br><br><br>
	<p>zużycie w poszczególnych miesiącach:</p>
    <div class="dane-miesieczne">
        <?php
		
		$plik = 'kalendarz.json';
		$kalendarz = json_decode(file_get_contents($plik), true)['k'];
		$miesiace_licznik = array_fill(0,12,0);

		foreach($kalendarz as $miesiac => $wiersz)
		{	
			$miesiac+=1;
			$rok;
			if($miesiac<=date('n'))
			{
				$rok=date('Y');
			}
			else
			{
				$rok=date('Y')-1;
			}
			
			$data="{$rok}-{$miesiac}-01";
			$numerDnia = date('N', strtotime($data)); //numer tygodnia pierwszego dnia miesiąca
			$miesiac_tekst=nazwa_miesiaca($miesiac);
			print("	<div class='popup' id='okienko{$miesiac}'>
							<h2>{$miesiac_tekst}  {$rok}</h2>
							<div class='kalendarz'>
								<div class='dni-tygodnia'>Pon</div>
								<div class='dni-tygodnia'>Wto</div>
								<div class='dni-tygodnia'>Śro</div>
								<div class='dni-tygodnia'>Czw</div>
								<div class='dni-tygodnia'>Pią</div>
								<div class='dni-tygodnia'>Sob</div>
								<div class='dni-tygodnia'>Nie</div>
					  ");
			for($i=1; $i<$numerDnia; $i++)
			{
				print("<div class='dzien' style='background-color: #f2f2f2; opacity: 0.4'> </div>");
			}
			
			foreach($wiersz as $dzien => $element)
			{				
				$miesiace_licznik[$miesiac-1]+=$element;
				$po_zamianie=rozbicie_do_minut($element);				
				$dzien+=1;
				$kolor=zmiana_koloru($element,7*60*60);
			print("<div class='dzien' style='background-color:{$kolor}'><div><h4>{$po_zamianie}</h4></div><div>{$dzien}</div></div>");
			}
			print("</div></div>");
		}
		
		
            $max_zuzycie = max($miesiace_licznik)/3600;
			if($max_zuzycie==0){$max_zuzycie=1;}
            foreach ($miesiace_licznik as $miesiac => $zuzycie)
			{
				$zuzycie=$zuzycie/3600;
                $wysokosc = ($zuzycie / $max_zuzycie) * 100 + 7;
				$zuzycie= round($zuzycie);
				$miesiac+=1;
				$kolor_słupek=" ";
				if($miesiac==date('n'))
				{
					$kolor_słupek="background-color: #6b7095;";
					//#71b5ff;
					//#506699;
					//#707095;
					//rgba(00, 100, 250, 0.5);
				}
				$miesiac_tekst=nazwa_miesiaca($miesiac);
                echo "
                    <div class='miesiac'>
                        <button id='slupek{$miesiac}' class='slupek' style='height: {$wysokosc}%; {$kolor_słupek}'>
                            {$zuzycie}h
                        </button>
                        <span>{$miesiac}</span>
                    </div>
                ";
            }
			
		
        ?>
    </div>


</body>
</html>
