
#!/bin/sh

#Interface Cfg
#Global Configuration
echo > /etc/network/interfaces
echo auto lo eth1 eth0 lo:1 uap0 >>  /etc/network/interfaces
echo iface lo inet loopback >>  /etc/network/interfaces
#Default Mgt Interface-Part of Global Cfg
ifconfig lo:1 1.1.1.1 netmask 255.255.255.255 up
#LAN Interface
echo iface eth1 inet static >>  /etc/network/interfaces
echo address 192.168.12.1 >>  /etc/network/interfaces
echo netmask 192.168.12.255 >>  /etc/network/interfaces
echo network 192.168.12.0 >>  /etc/network/interfaces
#WAN Interface
echo iface eth0 inet dhcp >>  /etc/network/interfaces
#Wireless Interface
ifconfig uap0 192.168.11.1 netmask 255.255.255.0 up

#Startup Script Insert
sed -i '/ifconfig uap0/d' /root/k2.6.39.4/init_setup8787.sh
sed -i '/ifconfig lo:1/d' /root/k2.6.39.4/init_setup8787.sh
echo ifconfig uap0 192.168.11.1 netmask 255.255.255.0 up >> /root/k2.6.39.4/init_setup8787.sh
echo ifconfig lo:1 1.1.1.1 netmask 255.255.255.255 up >> /root/k2.6.39.4/init_setup8787.sh
#uaputl sys_cfg_wpa_passphrase $PASS
#uaputl bss_start
#sed -i '/uaputl sys_cfg_wpa_passphrase/d' /root/k2.6.39.4/init_setup8787.sh
#sed -i '/uaputl bss_start/d' /root/k2.6.39.4/init_setup8787.sh
#echo uaputl sys_cfg_wpa_passphrase $PASS >> /root/k2.6.39.4/init_setup8787.sh
#echo uaputl bss_start >> /root/k2.6.39.4/init_setup8787.sh

#DHCP Cfg
    echo > /etc/dhcp/dhcpd.conf
    echo '#Wireless' >> /etc/dhcp/dhcpd.conf
    echo 'subnet 192.168.11.0 netmask 255.255.255.0 {'  >> /etc/dhcp/dhcpd.conf
    echo 'option domain-name-servers 8.8.8.8, 4.2.2.2;' >> /etc/dhcp/dhcpd.conf
    echo 'option domain-name "spanboxng.com";' >> /etc/dhcp/dhcpd.conf
    echo 'option routers 192.168.11.1;' >> /etc/dhcp/dhcpd.conf
    echo 'ddns-domainname "spanboxng.com";' >> /etc/dhcp/dhcpd.conf
    echo 'range dynamic-bootp 192.168.11.100 192.168.11.200;}' >> /etc/dhcp/dhcpd.conf
    
    echo '#LAN' >> /etc/dhcp/dhcpd.conf
    echo 'subnet 192.168.12.0 netmask 255.255.255.0 {'  >> /etc/dhcp/dhcpd.conf
    echo 'option domain-name-servers 8.8.8.8, 4.2.2.2;' >> /etc/dhcp/dhcpd.conf
    echo 'option domain-name "spanboxng.com";' >> /etc/dhcp/dhcpd.conf
    echo 'option routers 192.168.12.1;' >> /etc/dhcp/dhcpd.conf
    echo 'ddns-domainname "spanboxng.com";' >> /etc/dhcp/dhcpd.conf
    echo 'range dynamic-bootp 192.168.12.100 192.168.12.200;}' >> /etc/dhcp/dhcpd.conf
    rm /var/lib/dhcp/dhcpd.leases
    touch /var/lib/dhcp/dhcpd.leases
    /etc/init.d/networking restart
    /etc/init.d/isc-dhcp-server restart
#
