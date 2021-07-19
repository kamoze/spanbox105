test1=`ls /etc/openvpn | grep client-sc.conf | wc -l`
test2=`ifconfig | grep 10.128. | wc -l`
cur_date=`date "+%Y %b %d %H:%M"`

#NAME=[t]ap
#ifconfig | grep $NAME

if [ $test1 -gt 0 ]; then
        if [ $test2 -gt 0 ]; then
                echo "$cur_date Tapcheck1 All Good Openvpn tap interface is UP"
        else
                echo "$cur_date Tapcheck1 Service Down Restarting Openvpn"
                service openvpn restart
        fi
else
        if [ $test2 -gt 0 ]; then
                echo "$cur_date Tapcheck1 Something crazy going on here Restarting to be sure"
                service openvpn restart
        else
                echo "$cur_date Tapcheck1 Service is Disabled"
        fi
fi

