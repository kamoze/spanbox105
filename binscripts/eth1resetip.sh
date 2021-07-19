set -x
echo "Testing for eth1 script"
shuf1=`shuf -n 1 /root/vvpsipsub.txt | awk -F '[/]' '{print $1}' | awk -F '[.]' '{print $1}'`
shuf2=`shuf -n 1 /root/vvpsipsub.txt | awk -F '[/]' '{print $1}' | awk -F '[.]' '{print $2}'`
shuf3=`shuf -n 1 /root/vvpsipsub.txt | awk -F '[/]' '{print $1}' | awk -F '[.]' '{print $3}'`
IP=$shuf1.$shuf2.$shuf3.1
NET=$shuf1.$shuf2.$shuf3.0
sed -i '/'$NET'/d' /root/vvpsipsub.txt
OIP=`ifconfig eth1 | awk -F ":" '/inet addr/ {print $2}' | awk '{print $1}'`
set1=`ifconfig eth1 | awk -F ":" '/inet addr/ {print $2}' | awk '{print $1}' | awk -F '[.]' '{print $1}'`
set2=`ifconfig eth1 | awk -F ":" '/inet addr/ {print $2}' | awk '{print $1}' | awk -F '[.]' '{print $2}'`
set3=`ifconfig eth1 | awk -F ":" '/inet addr/ {print $2}' | awk '{print $1}' | awk -F '[.]' '{print $3}'`
ONET=$set1.$set2.$set3.0
Range1=$shuf1.$shuf2.$shuf3.100
Range2=$shuf1.$shuf2.$shuf3.200
ORange1=$set1.$set2.$set3.100
ORange2=$set1.$set2.$set3.200
#Set IP address scripts
for i in `grep -rl ''$OIP'' /etc/network/interfaces 2> /dev/null`; do sed -i 's/'$OIP'/'$IP'/' $i; done
for i in `grep -rl ''$ONET'' /etc/network/interfaces 2> /dev/null`; do sed -i 's/'$ONET'/'$NET'/' $i; done
#Set DHCP scripts
for i in `grep -rl ''$OIP'' /etc/dhcp/dhcpd.conf 2> /dev/null`; do sed -i 's/'$OIP'/'$IP'/' $i; done
for i in `grep -rl ''$ONET'' /etc/dhcp/dhcpd.conf 2> /dev/null`; do sed -i 's/'$ONET'/'$NET'/' $i; done
for i in `grep -rl ''$ORange1'' /etc/dhcp/dhcpd.conf 2> /dev/null`; do sed -i 's/'$ORange1'/'$Range1'/' $i; done
for i in `grep -rl ''$ORange2'' /etc/dhcp/dhcpd.conf 2> /dev/null`; do sed -i 's/'$ORange2'/'$Range2'/' $i; done
#Reset Networking 
rm /var/lib/dhcp/dhcpd.leases
touch /var/lib/dhcp/dhcpd.leases
/etc/init.d/networking restart
/etc/init.d/isc-dhcp-server restart
/bin/cp /etc/quagga/router-id.sh /usr/bin/ && sudo /usr/bin/router-id.sh
set +x
