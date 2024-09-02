import time
import subprocess
while(0==0):
  time.sleep(30)

  with open('/var/www/html/czasy.txt', 'r') as plik1:
    czasy= int(plik1.read())
    print(czasy)

  aktualnyczas = round(time.time())
  roznica= int(aktualnyczas-round(czasy))
  print(roznica)

  with open('/var/www/html/przelacznik.txt', 'r+') as plik2:
    przelacznik= int(plik2.read())
    if(przelacznik==1):
        
      # Komenda do zmiany stanu GPIO
      komenda1 = "/usr/local/bin/gpio -g mode 4 out"

      # Wykonanie komendy
      subprocess.call(komenda1, shell=True)
        
    if(przelacznik==1 and roznica>4*60*60):
      print("wchodze")
      plik2.seek(0)
      plik2.write("0")
      with open('/var/www/html/licznik.txt', 'r+') as plik3:
        licznik=int(plik3.read())
        licznik=int(licznik+roznica)
        plik3.seek(0)
        plik3.write(str(licznik))
      # Komenda do zmiany stanu GPIO
      komenda = "/usr/local/bin/gpio -g mode 4 in"

      # Wykonanie komendy
      subprocess.call(komenda, shell=True)
