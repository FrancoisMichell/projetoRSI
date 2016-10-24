#!/usr/bin/env python
from scapy.all import *
import datetime,time
import fcntl, socket, struct
import requests
import json
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
    try:
	response = urllib2.urlopen('http://216.58.192.142', timeout = 1)
	sts = True
    except urllib2.URLError as err: pass
    return sts

def getHwAddr(ifname):
    s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    info = fcntl.ioctl(s.fileno(), 0x8927,  struct.pack('256s', ifname[:15]))
    return ':'.join(['%02x' % ord(																																																																																																																																																																		char) for char in info[18:24]])

def sendData(lista):

	for i in lista:
		print ("MAC: %s, TIMESTAMP: %s, FORCA SINAL: %s ") %(i.getMac(), i.getHorario(), i.getForcaSinal())
		if not internet_on():
			f = open("unsent.txt", "a")
			aux = "%s/%s/%s\n" % (str(i.getMac()), str(i.getHorario()), str(i.getForcaSinal()))
			f.write(aux)
			f.close()

			subprocess.call(["sudo", "/sbin/ifdown", "wlan0"])
			time.sleep(5)
			subprocess.call(["sudo", "/sbin/ifup", "--force", "wlan0"])
		else:
			r = requests.post("http://rsi2016.orgfree.com/", data={'mac': str(i.getMac()), 'timestamp': str(i.getHorario()), 'forcaSinal': str(i.getForcaSinal())})
			print(r.status_code, r.reason)
			print(r.text[:600] + '...')
			print ""

'''
def sendData(lista):
	macs = {}
	for i in range(len(lista)):
		macs [i] = {'mac': str(lista[i].getMac()), 'timestamp': str(lista[i].getHorario()), 'forcaSinal': str(lista[i].getForcaSinal())}

	print macs
	url = "http://rsi2016.orgfree.com/"
	r = requests.post( url , data=json.dumps(macs))
	print(r.text[:600] + '...')
'''

def PacketHandler(pkt):
	global captured
	global capturedMac
	global start
	global end
	global localMac

	if pkt.haslayer(Dot11):
		if pkt.type == 0 and pkt.subtype == 4 :
			try:
				extra = pkt.notdecoded
				rssi = -(256-ord(extra[-4:-3]))
			except:
				rssi = -100

			if (pkt.addr2 not in capturedMac):
				pacote = Pacote(pkt.addr2,datetime.datetime.fromtimestamp(pkt.time),rssi)
				captured.append(pacote)
				capturedMac.append(pkt.addr2)
			elapsed = end - start
			if (elapsed <= 300.0):																																																																																																																																																																																																																																																																																																																																																														
				#print elapsed
				end = time.time()
			else:
				#print captured
				#print capturedMac
				start = time.time()
				end = time.time()

				#Implementar envio dos macs capturados
				sendData(captured)

				captured = []
				capturedMac = [localMac]

			#print "Probe request - MAC: %s Forca Sinal: %s " % (pkt.addr2, rssi)
			value = datetime.datetime.fromtimestamp(pkt.time)
			#print("Timestamp: " + value.strftime('%d-%m-%Y %H:%M:%S'))	

localMac = getHwAddr('wlan0')

#Time of begginning capture
start = time.time()

#Time of end capture
end = time.time()

#List with objects Pacote
captured = []

#List with macs captured
capturedMac = [localMac]

#Mac address for local machine

sniff(prn = PacketHandler)
