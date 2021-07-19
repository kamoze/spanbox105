#!/bin/sh
VVPSIP=`cat /usr/bin/vvpsip.txt |  awk -F "=" '{print $2}' | awk '{print $1}'`
cur_date=`date "+%Y %b %d %H:%M"`
test1="$((`sudo /sbin/ifconfig vpn_vvps | grep 'inet addr' | awk -F ":" '{print $2}' | awk '{print $1}' | wc -l`*`cat /usr/bin/setipvvps.txt`))"
static1=`cat /usr/bin/vvpsiptype.txt`
if [ $test1 = 1 ]; then
	if [ $static1 = 1 ]; then
		echo "$cur_date Static IP Address on Interface"
	else
		echo "$cur_date DHCP Address on Interface"
	fi
else
	if [ $static1 = 1 ]; then
		echo "$cur_date No Static IP Address on Interface"
		sudo /sbin/ifconfig vpn_vvps $VVPSIP  && echo "1" > /usr/bin/setipvvps.txt
                vvpsroutetype.sh
	else
		echo "$cur_date No DHCP IP Address on Interface"
		dhclient vpn_vvps  && echo "1" > /usr/bin/setipvvps.txt
                vvpsroutetype.sh
	fi
fi

