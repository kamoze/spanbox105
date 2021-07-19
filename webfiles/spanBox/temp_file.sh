!/bin/sh

if [ "$1" = "restart" ]
then
  sudo service asterisk restart 
fi

if [ "$1" = "stop" ]
then
  sudo service asterisk stop && echo "service asterisk stop" >> /etc/rc.local 
fi

if [ "$1" = "service" ]
then
 sed -i "/service asterisk stop/d" /etc/rc.local 
fi

if [ "$1" = "network_config" ]
then
echo > /etc/network/interfaces
echo `auto lo eth1 eth0 lo:1 uap0` >>  /etc/network/interfaces
echo `iface lo inet loopback` >>  /etc/network/interfaces
fi
if [ "$1" = "wlan_config" ]
  then
  if [ "$3" = "yes" ]
  then
    echo iface uap0 inet static >>  /etc/network/interfaces 
    ifconfig uap0 $4  up
    echo ifconfig upa0 $4 up >> /root/k2.6.39.4/init_setup8787.sh
    echo /etc/init.d/udhcpd start >>  /root/k2.6.39.4/init_setup8787.sh
    echo > /etc/udhcpd.conf

    x=`echo $4 | cut -d "." --complement -f4`.100 
    echo start $x >>  /etc/udhcpd.conf

    y=`echo $4 | cut -d "." --complement -f4`.200 
    echo start $y >>  /etc/udhcpd.conf

    echo interface uap0 >> /etc/udhcpd.conf
    echo opt lease 86400 >> /etc/udhcpd.conf
    echo opt domain spanboxng.com >> /etc/udhcpd.conf
    echo max_leases 101 >> /etc/udhcpd.conf
    echo lease_file /var/lib/udhcpd.leases >> /etc/udhcpd.conf
    echo auto_time 5 >> /etc/udhcpd.conf
    rm /var/lib/udhcpd.leases
    touch /var/lib/udhcpd.leases
    /etc/init.d/udhcpd start

    if["$7" != "none"] then
    uaputl sys_cfg_wpa_passphrase $7
    uaputl bss_start
    Sed –i "/uaputl bss_start /d" /root/k2.6.39.4/init_setup8787.sh
    Sed –i "/uaputl sys_cfg_wpa_passphrase/d" /root/k2.6.39.4/init_setup8787.sh
    echo uaputl sys_cfg_wpa_passphrase $7 >> /root/k2.6.39.4/init_setup8787.sh
    echo uaputl bss_start >> /root/k2.6.39.4/init_setup8787.sh
    fi

    /etc/init.d/udhcpd stop
   Sed –i /etc/init.d/udhcpd start/d /root/k2.6.39.4/init_setup8787.sh
   Echo /etc/init.d/udhcpd stop >> /root/k2.6.39.4/init_setup8787.sh 
  fi
fi

if [ "$1" = "wan_config" ]
then
  if["$2 = "yes"]
  then
    echo iface eth0 inet dhcp >>  /etc/network/interfaces 
  fi
  
  if["$3" = "yes"]
  then
    echo iface eth0 inet static >>  /etc/network/interfaces
    echo address $4  >>  /etc/network/interfaces
    echo netmask $6  >>  /etc/network/interfaces
    echo network $5 >>  /etc/network/interfaces
   
    echo iface lo:1 inet static >>  /etc/network/interfaces
    echo address 1.1.1.1 >>  /etc/network/interfaces
    echo netmask 1.1.1.1 >>  /etc/network/interfaces
    echo network 1.1.1.1 >>  /etc/network/interfaces
  fi
fi

if [ "$1" = "lan_config" ]
then
  if["$3" = "yes"]
  then
    echo iface eth1 inet static >>  /etc/network/interfaces
    echo address $4 >>  /etc/network/interfaces
    echo netmask $6 >>  /etc/network/interfaces
    echo network $5  >>  /etc/network/interfaces
    echo subnet $4 netmask $6 {  >> /etc/dhcp/dhcpd.conf
    echo option domain-name-servers 8.8.8.8, 4.2.2.2; >> /etc/dhcp/dhcpd.conf
    echo option domain-name "spanboxng.com"; >> /etc/dhcp/dhcpd.conf 
    echo option routers $4; >> /etc/dhcp/dhcpd.conf
    echo ddns-domainname "spanboxng.com"; >> /etc/dhcp/dhcpd.conf

    x=`echo $4 | cut -d "." --complement -f4`.100

    y=`echo $4 | cut -d "." --complement -f4`.200

    echo range dynamic-bootp $x $y ;} >> /etc/dhcp/dhcpd.conf
    echo default-lease-time 600; >> /etc/dhcp/dhcpd.conf
    echo max-lease-time 7200; >> /etc/dhcp/dhcpd.conf
    /etc/init.d/isc-dhcp-server start

    /etc/init.d/isc-dhcp-server stop
    sed –i /etc/init.d/isc-dhcp-server start/d /root/k2.6.39.4/init_setup8787.sh
   echo /etc/init.d/isc-dhcp-server stop >> /root/k2.6.39.4/init_setup8787.sh

  fi
fi

exit 0
