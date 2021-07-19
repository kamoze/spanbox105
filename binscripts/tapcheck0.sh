#!/bin/sh

test1=`ls /etc/openvpn | grep mgt.conf | wc -l`
test2=`ifconfig | grep 10.111. | wc -l`
cur_date=`date "+%Y %b %d %H:%M"`

#NAME=[t]ap
#ifconfig | grep $NAME

if [ $test1 -gt 0 ]; then
   	if [ $test2 -gt 0 ]; then
      		echo "$cur_date Tapcheck0 All Good Openvpn tap interface is UP"
   	else
      		echo "$cur_date Tapcheck0 Service Down Restarting Openvpn"
      		sudo openvpn --config /etc/openvpn/mgt.conf
   	fi
else
   	if [ $test2 -gt 0 ]; then
      		echo "$cur_date Tapcheck0 Restart VPN service"
		service openvpn restart
	else
      		echo "$cur_date Tapcheck0 Service is Disabled"
   	fi
fi

