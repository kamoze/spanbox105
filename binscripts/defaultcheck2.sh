dev2=ppp0
#p2=GW_of_ISP2
#name2=Name_of_ISP2

test_host=4.2.2.2
ping_c=3
ip=/sbin/ip
test1=`route | grep default | wc -l`
test2=`ping -I $dev2 -c $ping_c $test_host | grep "64 bytes" | wc -l`

cur_date=`date "+%Y %b %d %H:%M"`

#NAME=[d]efault
#route | grep $NAME | wc -l

if [ $test1 -gt 0 ]; then
        if [ $test2 -gt 0 ]; then
                echo "$cur_date DefaultCheck2 3g Link Up, Clearing WAN to be Sure"
      		ifdown eth0 && ifup eth0
        else
                echo "$cur_date DefaultCheck2 Maybe Pry Link is Up Doing Nothing"
                #service openvpn restart
        fi
else
        if [ $test2 -gt 0 ]; then
                echo "$cur_date Defaultcheck2 Something crazy going on here Restarting to be sure"
                internet.sh
        else
                echo "$cur_date DefaultCheck2 Still Restarting to be sure"
        fi
fi
