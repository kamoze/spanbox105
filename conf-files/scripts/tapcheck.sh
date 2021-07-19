#!/bin/sh
cur_date=`date "+%Y %b %d %H:%M"`
NAME=[t]ap
ifconfig | grep $NAME
if [ $? -eq 0 ]; then
   echo "$cur_date Openvpn tap interface is UP"
else
  echo "$cur_date Starting Openvpn" 
   /etc/init.d/openvpn start
 fi

