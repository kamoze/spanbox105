#!/bin/sh
set -x
hub=`sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountStatusGet WWW | grep 'Server Name' | awk -F "|" '{print $2}'`
check1=`route -n | grep vpn_www | awk '{print $1}' | grep 0.0.0.0 | wc -l`
check2=`route -n | grep -E 'eth0|ppp0' | awk '{print $1}' | grep 0.0.0.0 | wc -l`
defgw=`route -n | grep -E 'eth0|ppp0' | grep '0.0.0.0' | grep 'UG' | awk '{print $2}'`

#test1="$((`pgrep connect.sh | wc -l`+`cat /usr/bin/checkipwww.txt`))"

cur_date=`date "+%Y %b %d %H:%M"`

if [ $check1 = 1 ]; then
        if [ $check2 -gt 0 ]; then
                echo "$cur_date Duplicate Routes"
		route add -host $hub gw $defgw
		ip route flush 0/0 && dhclient vpn_www
        else
                echo "$cur_date VPN Route Active - All Good"
        fi
else
        if [ $check2 -gt 0 ]; then
                echo "$cur_date No VPN Routes"
		route add -host $hub gw $defgw
                ip route flush 0/0 && dhclient vpn_www
        else
                echo "$cur_date No Routes - Internet Access Not Possible"
		echo "0" > /usr/bin/checkipwww.txt && connectrun.sh
        fi
fi
set +x
