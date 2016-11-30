#!/usr/bin/env python
from scapy.all import *
import datetime,time
import fcntl, socket, struct
import requests
import json
#import gc
import urllib2
import subprocess
import time

class Pacote:

	def __init__(self, mac, horario,forcaSinal):
		self.mac = mac
		self.horario = horario
		self.forcaSinal = forcaSinal

	def setMac(self,mac):
		self.mac = mac

	def getMac(self):
		return self.mac

	def setHorario(self,horario):
		self.horario = horario

	def getHorario(self):
		return self.horario

	def setForcaSinal(self,forcaSinal):
		self.forcaSinal = forcaSinal

	def getForcaSinal(self):
		return self.forcaSinal

def internet_on():
    sts = False 
    print "Verificando conexao"
    try:
        response = urllib2.urlopen('http://216.58.192.142', timeout = 1)
        sts = True
    except Exception as e: 
	print e
	pass
    return sts


def getHwAddr(ifname):
    s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    info = fcntl.ioctl(s.fileno(), 0x8927,  struct.pack('256s', ifname[:15]))
    return ':'.join(['%02x' % ord(char) for char in info[18:24]])

def sendData(lista):
	if not internet_on():
		for i in lista:
			f = open("unsent.txt", "a")
			print "SALVANDO NO ARQUIVO %s/%s/%s\n" % (str(i.getMac()), str(i.getHorario()), str(i.getForcaSinal()))
			aux = "%s/%s/%s\n" % (str(i.getMac()), str(i.getHorario()), str(i.getForcaSinal()))
			f.write(aux)
			f.close()
			#subprocess.call(["sudo", "/sbin/ifdown", "wlp2s0"])
			#subprocess.call(["sudo", "/sbin/ifup",  "wlp2s0"])
	else:
		for i in lista:
			print ("MAC: %s, TIMESTAMP: %s, FORCA SINAL: %s ") %(i.getMac(), i.getHorario(), i.getForcaSinal())
			r = requests.post("http://rsi2016.orgfree.com/", data={'mac': str(i.getMac()), 'timestamp': str(i.getHorario()), 'forcaSinal': str(i.getForcaSinal())})
			print(r.status_code, r.reason)
			print(r.text[:600] + '...')
			print ""


def PacketHandler(pkt):
	global captured
	global start
	global end

	if pkt.haslayer(Dot11):
		if pkt.type == 0 and pkt.subtype == 4 :
			try:
				extra = pkt.notdecoded
				rssi = -(256-ord(extra[-4:-3]))
			except:
				rssi = -100

			try:
				pacote = Pacote(pkt.addr2,datetime.datetime.fromtimestamp(pkt.time),rssi)
				captured[pkt.addr2] = pacote
			except:
				pass

			elapsed = end - start
			if (elapsed <= 200.0):
				end = time.time()
			else:
				start = time.time()
				end = time.time()
				print captured.values()
				sendData(captured.values())
				captured.clear()
				#gc.collect()

#localMac = getHwAddr('wlp2s0')

#Time of begginning capture
start = time.time()

#Time of end capture
end = time.time()

#List with objects Pacote
captured = {}

#List with macs captured
#capturedMac = [localMac]

#Mac address for local machine

sniff(prn = PacketHandler)
