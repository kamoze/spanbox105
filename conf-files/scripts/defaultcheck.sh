#!/bin/sh
cur_date=`date "+%Y %b %d %H:%M"`
NAME=[d]efault
route | grep $NAME -w
if [ $? -eq 0 ]; then
   echo "$cur_date Internet Service is UP and Functional"
else
  echo "$cur_date Disconnecting and Restarting Internet Service" 
   3gdisconnect
   ifdown eth0 && ifup eth0
 fi

