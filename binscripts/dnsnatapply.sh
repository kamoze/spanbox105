set -x
test1=`iptables -t nat -S | grep 4343 | wc -l`
cur_date=`date "+%Y %b %d %H:%M"`

if [ $test1 -gt 0 ]; then
     echo "$cur_date DNS NAT Service UP - All Good"
else
     echo "$cur_date DNS NAT Service Down. Applying NAT"
     /usr/bin/dnsdnat.sh
fi
set +x

