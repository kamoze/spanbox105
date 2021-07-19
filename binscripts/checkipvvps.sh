test1=`ps aux | grep vpnclient | grep execsvc | wc -l`
test2=`sh -c "cd; cd /usr/local/vpnclient/; ./vpncmd localhost /CLIENT /CMD AccountStatusGet VVPS | grep 'Session Established' | wc -l"`

cur_date=`date "+%Y %b %d %H:%M"`

if [ $test1 -gt 0 ]; then
        if [ $test2 -gt 0 ]; then
                echo "$cur_date VPN Service UP"
		setipvvps.sh
        else
                echo "$cur_date Service UP but Account Not Connected. Restart Manually or from Webpage"
		#sh -c "cd; cd /usr/local/vpnclient/; ./vpncmd localhost /CLIENT /CMD AccountDisconnect VC" 
		#sh -c "cd; cd /usr/local/vpnclient/; ./vpncmd localhost /CLIENT /CMD AccountConnect VC"
        fi
else
        if [ $test2 -gt 0 ]; then
                echo "$cur_date Main Service Not UP. Nothing to Do"
		sudo /etc/init.d/vpnclient start
        else
                echo "$cur_date All Services are Disabled"
                sudo /etc/init.d/vpnclient start
        fi
fi

