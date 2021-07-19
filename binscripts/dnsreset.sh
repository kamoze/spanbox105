#!/bin/sh
set -x
name1=`route -n | grep UG | grep 0.0.0.0 | awk '{print $2}'`
#test1=`/etc/init.d/dnsmasq status | grep 'running' | wc -l`
#cur_date=`date "+%Y %b %d %H:%M"`
sed -i "/server=/d" /etc/dnsmasq.conf
echo "server="$name1"" >> /etc/dnsmasq.conf
echo "server="8.8.8.8"" >> /etc/dnsmasq.conf
echo "server="8.8.4.4"" >> /etc/dnsmasq.conf
echo "server="4.2.2.2"" >> /etc/dnsmasq.conf
echo "server="192.168.1.1"" >> /etc/dnsmasq.conf
set +x

