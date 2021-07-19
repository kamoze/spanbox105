set -x
test1=`ps aux | grep lighttpd | grep www-data | wc -l`
test2=`ls /var/run/ | grep lighttpd.pid |  wc -l`
cur_date=`date "+%Y %b %d %H:%M"`

if [ $test1 -gt 0 ]; then
        if [ $test2 -gt 0 ]; then
                echo "$cur_date Light Http Server is Running - All Good"
        else
                echo "$cur_date No PID file! Create one and restart Lighttpd service"
		touch /var/run/lighttpd.pid && /etc/init.d/lighttpd restart
        fi
else
        if [ $test2 -gt 0 ]; then
                echo "$cur_date PID File present but service not running. Restart Service."
		/etc/init.d/lighttpd restart
        else
                echo "$cur_date DNS All Services are Down. Restart Lighttpd service."
		/etc/init.d/lighttpd restart
        fi
fi
set +x 
