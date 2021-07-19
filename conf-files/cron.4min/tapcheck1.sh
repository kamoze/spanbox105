#!/bin/sh
NAME=[t]ap1
ifconfig | grep $NAME -w
if [ $? -eq 0 ]; then
   echo "Openvpn tap interface is UP"
else
  echo "Starting Openvpn" 
   /etc/init.d/openvpn stop
   /etc/init.d/openvpn start
 fi

