sed -i "/server=/d" /etc/dnsmasq.conf
sed -i "/address=/d" /etc/dnsmasq.conf
echo "server=10.155.1.1" >> /etc/dnsmasq.conf
echo "server=10.155.1.2" >> /etc/dnsmasq.conf
echo "address=/.xxx/1.1.1.11" >> /etc/dnsmasq.conf
echo "address=/.info/1.1.1.11" >> /etc/dnsmasq.conf
echo "address=/.sex/1.1.1.11" >> /etc/dnsmasq.conf
