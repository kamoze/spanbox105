set -x 
RID=`shuf -n 1 /root/routerid.txt`
ifconfig lo:123 $RID/32
ORID=`vtysh -c 'show run' | grep router-id | awk '{print $3}'`
for i in `grep -rl ''$ORID'' /etc/quagga/ospfd.conf 2> /dev/null`; do sed -i 's/'$ORID'/'$RID'/' $i; done
service quagga restart
set +x
#

