#!/bin/sh
set -x
test1=`cat /etc/scripts/tracklist.txt`
cur_date=`date "+%Y %b %d %H:%M"`

if [ $test1 = 0 ]; then
   echo "$cur_date Resetting Track List to Assume up"
   echo "127.0.0.1" > /etc/scripts/tracklist.txt
   echo "127.0.0.1" > /etc/scripts/list.txt 
else
   echo "$cur_date Track List OK"
fi
set +x

