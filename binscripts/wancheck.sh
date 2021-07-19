#!/bin/sh

test1=`ip link show eth0 | grep "state UP" | wc -l`

cur_date=`date "+%Y %b %d %H:%M"`

if [ $test1 -gt 0 ]; then
   echo "$cur_date WANCheck Link Active - Do Nothing"
else
   echo "$cur_date WAN Link Down - Run Full Route Refresh"
    ifdown eth0 && ifup eth0
fi
