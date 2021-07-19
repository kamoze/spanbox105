#!/bin/sh
set -x 
test1=`cat /usr/bin/checkiprouterun.txt`
Z=checkiproute.sh

cur_date=`date "+%Y %b %d %H:%M"`


if [ $test1 -gt 0 ]; then
   echo "$cur_date Sync Enabled"
   $Z
else
   echo "$cur_date Sync Disabled"
fi
set +x 

