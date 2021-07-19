#!/bin/sh
NAME=[t]ap3
ifconfig | grep $NAME -w
if [ $? -eq 0 ]; then
   echo "Multiple Openvpn tap interfaces are UP.Restarting VPN"
   /etc/init.d/openvpn stop
   killall openvpn
   /etc/init.d/openvpn start
else
  echo "All Good" 
fi

