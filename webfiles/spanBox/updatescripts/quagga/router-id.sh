RID=`ifconfig eth1 | awk -F ":" '/inet addr/ {print $2}' | awk '{print $1}'`
sed -i '/router ospf/d' /etc/quagga/ospfd.conf
sed -i '/router-id/d' /etc/quagga/ospfd.conf
sed -i '/redistribute connected/d' /etc/quagga/ospfd.conf
sed -i '/network 10.128.0.0/d' /etc/quagga/ospfd.conf
sed -i '/redistribute static/d' /etc/quagga/ospfd.conf
sed -i '/redistribute kernel/d' /etc/quagga/ospfd.conf
sed -i '/neighbor/d' /etc/quagga/ospfd.conf
sed -i '/interface tap/d' /etc/quagga/ospfd.conf
sed -i '/ip ospf network/d' /etc/quagga/ospfd.conf
sed -i '/ip ospf hello-interval/d' /etc/quagga/ospfd.conf
sed -i '/ip ospf dead-interval/d' /etc/quagga/ospfd.conf
echo 'interface tap0' >> /etc/quagga/ospfd.conf
echo 'ip ospf network point-to-multipoint' >> /etc/quagga/ospfd.conf
echo ' ip ospf dead-interval 120' >> /etc/quagga/ospfd.conf
echo ' ip ospf hello-interval 30' >> /etc/quagga/ospfd.conf
echo 'interface tap1' >> /etc/quagga/ospfd.conf
echo 'ip ospf network point-to-multipoint' >> /etc/quagga/ospfd.conf
echo ' ip ospf dead-interval 120' >> /etc/quagga/ospfd.conf
echo ' ip ospf hello-interval 30' >> /etc/quagga/ospfd.conf
echo 'interface tap2' >> /etc/quagga/ospfd.conf
echo 'ip ospf network point-to-multipoint' >> /etc/quagga/ospfd.conf
echo ' ip ospf dead-interval 120' >> /etc/quagga/ospfd.conf
echo ' ip ospf hello-interval 30' >> /etc/quagga/ospfd.conf
echo 'router ospf' >> /etc/quagga/ospfd.conf
echo '  router-id '$RID'' >> /etc/quagga/ospfd.conf
echo '  network 10.128.0.0/9 area 0' >> /etc/quagga/ospfd.conf
echo '  neighbor 10.128.0.1' >> /etc/quagga/ospfd.conf
echo '  redistribute connected metric 100  metric-type 1 route-map NoWAN' >> /etc/quagga/ospfd.conf
echo '  redistribute static metric 100 metric-type 1' >> /etc/quagga/ospfd.conf
echo '  redistribute kernel metric 100 metric-type 1' >> /etc/quagga/ospfd.conf
service quagga restart
#

