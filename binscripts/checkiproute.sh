#!/bin/sh
set -x
#GConn=3gconnect2
#GDConn=3gdisconnect
#dev1=eth0
#C=$GConn
#D=$GDConn
#Z=$test1
#test1=`nettestdev1.sh | grep UP | wc -l`
#G=$test2
##default check
#NAME=[d]efault
#test3=`route | grep $NAME | wc -l`
#dev2=ppp0
#test_host=4.2.2.2
#ping_c=5
#ip=/sbin/ip
#test2=`nettestdev2.sh | grep UP | wc -l`
cur_date=`date "+%Y %b %d %H:%M"`
vtysh -c 'show ip route' | awk '{print $2}' > /tmp/vtyroutes.txt
test3=`sort /tmp/vtyroutes.txt | uniq -c | grep -v '^ *1' | wc -l`

#Check for LAN Interface IP Clash
sort /tmp/vtyroutes.txt | uniq -c | grep -v '^ *1' | awk '{print $2}' | awk -F '[/]' '{print $1}' > /tmp/sorteth1.txt
route -n | grep -E 'eth1' | awk '{print $1}' >> /tmp/sorteth1.txt
#Check for WLAN Interface IP Clash
sort /tmp/vtyroutes.txt | uniq -c | grep -v '^ *1' | awk '{print $2}' | awk -F '[/]' '{print $1}'  > /tmp/sortuap0.txt
route -n | grep -E 'uap0' | awk '{print $1}' >> /tmp/sortuap0.txt
#Variables
test1="$((`sort /tmp/sorteth1.txt | uniq -c | grep -v '^ *1' | wc -l`*`sort /tmp/sortuap0.txt | uniq -c | grep -v '^ *1' | wc -l`))"
test2=`sort /tmp/sortuap0.txt | uniq -c | grep -v '^ *1' | wc -l`
test4=`sort /tmp/sorteth1.txt | uniq -c | grep -v '^ *1' | wc -l`
if [ $test3 -gt 0 ]; then
        if [ $test1 -gt 0 ]; then
                echo "$cur_date CheckIPRoute - LAN and WLAN IP Conflict - Change IP Addresses"
                eth1resetip.sh && uap0resetip.sh
        elif [ $test2 -gt 0 ]; then
                echo "$cur_date CheckIPRoute - WLAN IP Conflict - Change IP Address"
		uap0resetip.sh
        elif [ $test4 -gt 0 ]; then
                echo "$cur_date CheckIPRoute - LAN IP Conflict - Change IP Address"
		eth1resetip.sh
	else
                echo "$cur_date Mgt IP - Check Redistribution"
        fi
else
        if [ $test4 -gt 0 ]; then
                echo "$cur_date Check Script"

        elif [ $test2 -gt 0 ]; then
                echo "$cur_date Check Script"
        else
                echo "$cur_date CheckIPRoute - All Quiet And Good"
        fi
fi
set +x

