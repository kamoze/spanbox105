
#!/bin/sh

# interface
#dev1=tap+
# gateway
#p1=GW_of_ISP1
#name1=Name_of_ISP1

#dev2=ppp0
#p2=GW_of_ISP2
#name2=Name_of_ISP2

test_host=10.88.88.88
ping_c=3
ip=/sbin/ip

test1=`ping -c $ping_c $test_host | grep "64 bytes" | wc -l`
test2=`ls /etc/openvpn | grep vc.conf | wc -l`

cur_date=`date "+%Y %b %d %H:%M"`

#$ip route del default

if [ $test1 -gt 0 ]; then
        if [ $test2 -gt 0 ]; then
                echo "$cur_date VoipConnect All Good for the VC Service"
        else
                echo "$cur_date VoipConnect Something Wrong Here"
        fi
else
        if [ $test2 -gt 0 ]; then
                echo "$cur_date VC Server Unreachable Restarting VPN"
	        killall openvpn && killall stunnel4
                /etc/init.d/stunnel4 restart && /etc/init.d/openvpn restart
        else
                echo "$cur_date Voipconnect Service is Disabled"
	fi
fi

