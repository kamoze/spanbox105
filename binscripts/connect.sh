#!/bin/sh
GConn=3gconnect

GDConn=3gdisconnect

# interface
dev1=eth0
# gateway
#p1=GW_of_ISP1
#name1=Name_of_ISP1

C=$GConn
D=$GDConn
Z=$test1
test1=`nettestdev1.sh | grep UP | wc -l`


G=$test2

#default check
NAME=[d]efault
test3=`route | grep $NAME | wc -l`

dev2=ppp0
#p2=GW_of_ISP2
#name2=Name_of_ISP2

test_host=4.2.2.2
ping_c=5
ip=/sbin/ip

test2=`nettestdev2.sh | grep UP | wc -l`
#test4=`nettestnull.sh | grep UP | wc -l`


#test2=`ping -I $dev2 -c $ping_c $test_host | grep "64 bytes" | wc -l`

cur_date=`date "+%Y %b %d %H:%M"`

#$ip route del default

if [ $test3 -gt 0 ]; then
        if [ $test1 -gt 0 ]; then
                echo "$cur_date Connect Pry link is Up"
                $D
		#wancheck.sh
        elif [ $test2 -gt 0 ]; then
                echo "$cur_date Connect Secondary link is Up"
		#set ip link eth0 down
        else
                echo "$cur_date Connect Default Up but both links unreachable Resetting all Links"
                $ip route del default
		$D
		$C
		nettestdev1.sh
        fi
else
        if [ $test1 -gt 0 ]; then
                echo "$cur_date Connect Primary Internet link Up But no Default Resetting the WAN link"
                $D
		wancheck.sh 

        elif [ $test2 -gt 0 ]; then
                echo "$cur_date Connect Resetting Secondary Link"
                $D && $C && ifdown eth0
        else
                echo "$cur_date Connect All links Down Resetting"
                $D
		$C
      	 	nettestdev1.sh
        fi
fi


