#!/bin/sh
set -x
test1="$((`pgrep connect.sh | wc -l`+`cat /usr/bin/checkipwww.txt`+`cat /usr/bin/connectrun.txt`))"
#test2="$((`"$test1"`*`cat /usr/bin/connectrun.txt`))"
cur_date=`date "+%Y %b %d %H:%M"`

if [ $test1 -gt 0 ]; then
   echo "$cur_date ConnectRun Wait until Current Process Exits"
else
   echo "$cur_date ConnectRun Run Connect Process Again"
   connect.sh
fi
set +x
