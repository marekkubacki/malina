import time
import subprocess
import json
from datetime import datetime
while(0==0):

  aktualnyczas = round(time.time())	
  time.sleep(3)
  #Komenda do zmiany stanu GPIO
  komenda_off = "/usr/local/bin/gpio -g mode 4 in"
  komenda_on = "/usr/local/bin/gpio -g mode 4 out"
  
  print("alee")
  with open('dane.json', 'r') as plik:
    dane = json.load(plik)




  if(dane["przycisk"]==0):
    if(dane["aktualnie"]!=0):
      dane["ostatni"]=dane["aktualnie"]
      
    subprocess.call(komenda_off, shell=True)
    dane["aktualnie"]=0

	  
  if(dane["przycisk"]==1):
        
    subprocess.call(komenda_on, shell=True)

      #sprawdzanie czy nie przekroczono czasu auto wylaczania
    if(dane["auto_off"]<=dane["aktualnie"]):
      dane["przycisk"]=0
      subprocess.call(komenda_off, shell=True)
	
    # obliczenie ile czasu dodać do liczników
    roznica = round(time.time()) - aktualnyczas
    dane["licznik"]+=roznica
    dane["aktualnie"]+=roznica
    dane["miesiace"][datetime.now().month]+=roznica

    
  with open('dane.json', 'w') as plik:
    json.dump(dane, plik, indent=4)
	


	  
