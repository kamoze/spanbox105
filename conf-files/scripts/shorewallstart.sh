#!/bin/sh

test1=`grep 'shorewall start' /etc/rc.local | wc -l`
test2=`sudo /sbin/shorewall status | grep 'Shorewall is running' | wc -l`

cur_date=`date "+%Y %b %d %H:%M"`

#$ip route del default

if [ $test1 -gt 0 ]; then
        if [ $test2 -gt 0 ]; then
                echo "$cur_date All Good for the Shorewall Service"
        else
                echo "$cur_date Something Wrong Here. Starting Shorewall"
            	sudo /sbin/shorewall start
        fi
else
        if [ $test2 -gt 0 ]; then
                echo "$cur_date Shorewall should not be up. Stopping Shorewall"
                sudo /sbin/shorewall stop
        else
                echo "$cur_date Service is Disabled"
        fi
fi
