#!/bin/sh
VCIP=`cat /usr/bin/vcip.txt |  awk -F "=" '{print $2}' | awk '{print $1}'`
cur_date=`date "+%Y %b %d %H:%M"`
test1="$((`sudo /sbin/ifconfig vpn_vc | grep 'inet addr' | awk -F ":" '{print $2}' | awk '{print $1}' | wc -l`*`cat /usr/bin/setipvc.txt`))"
static1=`cat /usr/bin/vciptype.txt`
#test3=cat /usr/bin/setipvc.txt
#set -x
if [ $test1 = 1 ]; then
	if [ $static1 = 1 ]; then
		echo "$cur_date Static IP Address on Interface"
	else
		echo "$cur_date DHCP Address on Interface"
	fi
else
	if [ $static1 = 1 ]; then
		echo "$cur_date No Static IP Address on Interface"
		sudo /sbin/ifconfig vpn_vc $VCIP && echo "1" > /usr/bin/setipvc.txt
		iptables -t nat -A POSTROUTING -o vpn_vc -j MASQUERADE
	else
		echo "$cur_date No DHCP IP Address on Interface"
		dhclient vpn_vc && echo "1" > /usr/bin/setipvc.txt
		iptables -t nat -A POSTROUTING -o vpn_vc -j MASQUERADE
	fi
fi
#set +x
