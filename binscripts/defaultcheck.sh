#!/bin/sh
cur_date=`date "+%Y %b %d %H:%M"`
NAME=[d]efault
test1=`route | grep $NAME | wc -l`
if [ $test1 -eq 1 ]; then
   echo "$cur_date DefaultCheck Internet Service is UP and Functional"
   #internet.sh
else
  echo "$cur_date DefaultCheck Disconnecting and Restarting Internet Service"
   #internet.sh
   #3gdisconnect
   #ifdown eth0 && ifup eth0
 fi

