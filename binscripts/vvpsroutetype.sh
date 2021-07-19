test1=`ps aux | grep vpnclient | grep execsvc | wc -l`
test2=`sh -c "cd; cd /usr/local/vpnclient/; ./vpncmd localhost /CLIENT /CMD AccountStatusGet VVPS | grep 'Session Established' | wc -l"`

cur_date=`date "+%Y %b %d %H:%M"`

if [ $test1 -gt 0 ]; then
        if [ $test2 -gt 0 ]; then
                echo "$cur_date Full Routing With No NAT"
		#vvpsaddrcheck.sh
        else
                echo "$cur_date Account Not Connected. Check Credentials"
		#sh -c "cd; cd /usr/local/vpnclient/; ./vpncmd localhost /CLIENT /CMD AccountDisconnect VC" 
		#sh -c "cd; cd /usr/local/vpnclient/; ./vpncmd localhost /CLIENT /CMD AccountConnect VC"
        fi
else
        if [ $test2 -gt 0 ]; then
                echo "$cur_date Partial Routing -  Enable NAT"
                #Enable NAT
                iptables -t nat -A POSTROUTING -o vpn_vvps -j MASQUERADE
        else
                echo "$cur_date All Services are Disabled"
        fi
fi

