#!/bin/sh
VCIP=`cat /usr/bin/wwwip.txt |  awk -F "=" '{print $2}' | awk '{print $1}'`
cur_date=`date "+%Y %b %d %H:%M"`
test1="$((`sudo /sbin/ifconfig vpn_www | grep 'inet addr' | awk -F ":" '{print $2}' | awk '{print $1}' | wc -l`*`cat /usr/bin/setipwww.txt`))"
static1=`cat /usr/bin/wwwiptype.txt`
#test3=cat /usr/bin/setipwww.txt
#set -x
if [ $test1 = 1 ]; then
	if [ $static1 = 1 ]; then
		echo "$cur_date Static IP Address on Interface"
		defaultwww.sh
	else
		echo "$cur_date DHCP Address on Interface"
		defaultwww.sh
	fi
else
	if [ $static1 = 1 ]; then
		echo "$cur_date No Static IP Address on Interface"
		sudo /sbin/ifconfig vpn_www $VCIP && echo "1" > /usr/bin/setipwww.txt
		iptables -t nat -A POSTROUTING -o vpn_www -j MASQUERADE
	else
		echo "$cur_date No DHCP IP Address on Interface"
		dhclient vpn_www && echo "1" > /usr/bin/setipwww.txt
		iptables -t nat -A POSTROUTING -o vpn_www -j MASQUERADE
	fi
fi
#set +x
