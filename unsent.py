
#!/usr/bin/env python
from scapy.all import *
import requests

registros = []
arquivo = open("unsentt.txt","r")
lista_arquivo = arquivo.readlines()
for x in lista_arquivo:
	x = x.replace("\n","")
	x = x.split('/')
	print ("MAC: %s, TIMESTAMP: %s, FORCA SINAL: %s ") %(x[0], x[1], x[2])
	r = requests.post("http://rsi2016.orgfree.com/", data={'mac': str(x[0]), 'timestamp': str(x[1]), 'forcaSinal': str(x[2])})
	print(r.status_code, r.reason)
	print(r.text[:600] + '...')
	print ""