test1=`sh -c "cd; cd /usr/local/vpnclient/; ./vpncmd localhost /CLIENT /CMD AccountStatusGet DNS | grep 'Session Established' | wc -l"`
test2="$((`sudo /sbin/ifconfig vpn_dns | grep 'inet addr' | awk -F ":" '{print $2}' | awk '{print $1}' | wc -l`*`cat /usr/bin/setipdns.txt`))"
cur_date=`date "+%Y %b %d %H:%M"`

if [ $test1 -gt 0 ]; then
        if [ $test2 -gt 0 ]; then
                echo "$cur_date DNS VPN Service UP - All Good"
        else
                echo "$cur_date DNS Service UP but No IP Address - Resetting IP Address"
		/sbin/dhclient vpn_dns
        fi
else
        if [ $test2 -gt 0 ]; then
                echo "$cur_date DNS Main Service Not UP. Checking Nameserver"
		nameserver.sh
        else
                echo "$cur_date DNS All Services are Disabled"
                nameserver.sh
	fi
fi

