set -x
test1=`/etc/init.d/dnsmasq status | grep running | wc -l`
test2=`ls /var/run/ | grep dnsmasq.pid |  wc -l`
cur_date=`date "+%Y %b %d %H:%M"`

if [ $test1 -gt 0 ]; then
        if [ $test2 -gt 0 ]; then
                echo "$cur_date DNSMasq DNS Server is Running - All Good"
        else
                echo "$cur_date No PID file! Create one and restart DNSMasq service"
		touch /var/run/dnsmasq.pid && /etc/init.d/dnsmasq restart
        fi
else
        if [ $test2 -gt 0 ]; then
                echo "$cur_date DNSMasq PID File present but service not running. Restart Service."
		/etc/init.d/dnsmasq restart
        else
                echo "$cur_date DNSMasq All Services are Down. Restart service."
		/etc/init.d/dnsmasq restart
        fi
fi
set +x 
