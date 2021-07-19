#!/bin/sh
set -x
name1=`route -n | grep UG | grep 0.0.0.0 | awk '{print $2}'`
#Z=checkiproute.sh
#cur_date=`date "+%Y %b %d %H:%M"`
echo > /etc/resolv.conf
echo "nameserver "$name1"" >> /etc/resolv.conf
echo "nameserver "8.8.8.8"" >> /etc/resolv.conf
echo "nameserver "8.8.4.4"" >> /etc/resolv.conf
echo "nameserver "4.2.2.2"" >> /etc/resolv.conf
set +x

