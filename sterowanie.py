import time
import subprocess
import json
from datetime import datetime
while(0==0):

  aktualnyczas = time.time()	

  time.sleep(5)
  #Komenda do zmiany stanu GPIO
  komenda_off = "/usr/local/bin/gpio -g mode 4 in"
  komenda_on = "/usr/local/bin/gpio -g mode 4 out"
  

  a=time.time()
  with open('dane.json', 'r') as plik:
    dane = json.load(plik)

  if(dane["data"]["d"]!=datetime.today().day or dane["data"]["m"]!=datetime.today().month or dane["data"]["y"]!=datetime.today().year):

    with open('kalendarz.json', 'r') as plik:
      kalendarz = json.load(plik)

    if(dane["data"]["m"]!=datetime.today().month):
      kalendarz["k"][datetime.today().month-1] = [0] *len(kalendarz["k"][datetime.today().month-1])

    kalendarz["k"][dane["data"]["m"]-1][dane["data"]["d"]-1]=dane["dzis"]
    dane["dzis"]=0
    with open('kalendarz.json', 'w') as plik:
      json.dump(kalendarz, plik, indent=8)

  dane["data"]["d"]=datetime.today().day 
  dane["data"]["m"]=datetime.today().month
  dane["data"]["y"]=datetime.today().year



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
    roznica = (round(time.time(),3)) - aktualnyczas
    print(roznica)
    dane["licznik"]+=roznica
    dane["aktualnie"]+=roznica
    dane["dzis"]+=roznica
  

    
  with open('dane.json', 'w') as plik:
    json.dump(dane, plik, indent=4)
  print(time.time()-a)
	


	  
