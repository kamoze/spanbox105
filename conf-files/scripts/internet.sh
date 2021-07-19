#!/bin/sh

# interface
dev1=eth0
# gateway
#p1=GW_of_ISP1
#name1=Name_of_ISP1

dev2=ppp0
#p2=GW_of_ISP2
#name2=Name_of_ISP2

test_host=8.8.8.8
ping_c=3
ip=/sbin/ip

test1=`ping -I $dev1 -c $ping_c $test_host | grep "64 bytes" | wc -l`
test2=`ping -I $dev2 -c $ping_c $test_host | grep "64 bytes" | wc -l`

cur_date=`date "+%Y %b %d %H:%M"`

#$ip route del default

if [ $test1 -gt 0 ]; then
        if [ $test2 -gt 0 ]; then
                echo "$cur_date Dual Internet links active Disconnecting 3g link"
                3gdisconnect
        else
                echo "$cur_date Primary Internet link is up"
        fi
else
        if [ $test2 -gt 0 ]; then
                echo "$cur_date Primary Internet link is down but Backup link active"
                ifdown eth0 && ifup eth0 
        else
                echo "$cur_date Activating 3g Backup Link"
		$ip route del default
		3gconnect
        fi
fi

