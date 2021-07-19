sed -i "/server=/d" /etc/dnsmasq.conf
echo "server=10.155.1.1" >> /etc/dnsmasq.conf
/etc/init.d/dnsmasq restart
