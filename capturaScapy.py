#!/usr/bin/env python
from scapy.all import *
import datetime

def PacketHandler(pkt):
	if pkt.haslayer(Dot11):
		if pkt.type == 0 and pkt.subtype == 4:
			try:
		            extra = pkt.notdecoded
		            rssi = -(256-ord(extra[-4:-3]))
		        except:
		            rssi = -100
			print "Probe request - MAC: %s Forca Sinal: %s " % (pkt.addr2, rssi)
			value = datetime.datetime.fromtimestamp(pkt.time)
			print("Timestamp: " + value.strftime('%d-%m-%Y %H:%M:%S'))	

sniff(prn = PacketHandler)
