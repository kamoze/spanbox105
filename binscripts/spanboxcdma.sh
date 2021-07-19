#!/bin/sh

if [ "$1" = "restart" ]
then
  sudo service asterisk restart && sed -i "/service asterisk stop/d" /etc/rc.local 
fi

if [ "$1" = "stop" ]
then
  sudo service asterisk stop && echo "service asterisk stop" >> /etc/rc.local 
fi

if [ "$1" = "service" ]
then
 sed -i "/service asterisk stop/d" /etc/rc.local 
fi

if [ "$1" = "vpn_restart" ]
then
  sudo service openvpn restart && sed -i "/service openvpn stop/d" /etc/rc.local && sed -i "/service openvpn stop/d" /usr/bin/tapcheck0.sh && sudo /usr/bin/spanboxpcrm.sh
fi

if [ "$1" = "vpn_restart2" ]
then
  sudo service openvpn restart && sed -i "/service openvpn stop/d" /etc/rc.local && sed -i "/service openvpn stop/d" /usr/bin/tapcheck0.sh && sudo /usr/bin/spanboxscrm.sh
fi


if [ "$1" = "vpn_stop" ]
then
  sudo killall openvpn && sed -i "/sudo openvpn/d" /etc/rc.local && echo "service openvpn stop" >> /etc/rc.local && echo "service openvpn stop" >> /usr/bin/tapcheck0.sh
fi

if [ "$1" = "vpn_service" ]
then
  sudo update-rc.d openvpn defaults
fi


if [ "$1" = "fw_restart" ]
then
  sudo /sbin/shorewall save && sudo /sbin/shorewall start && sed -i "35i shorewall start" /etc/rc.local
fi

if [ "$1" = "fw_stop" ]
then
  sudo /sbin/shorewall stop && sed -i "/shorewall start/d" /etc/rc.local
fi

if [ "$1" = "reboot" ]
then
  sudo /sbin/reboot
fi

if [ "$1" = "mgt_start" ]
then
  cp /etc/vpnmgt/mgt.conf /etc/openvpn && sudo service openvpn restart
fi

if [ "$1" = "mgt_stop" ]
then
  rm /etc/openvpn/mgt.conf && sudo service openvpn restart
fi

if [ "$1" = "trunk_start" ]
then
  cp /etc/vpnmgt/vcmgt/vc.conf /etc/openvpn && sudo service openvpn restart
fi

if [ "$1" = "trunk_stop" ]
then
  rm /etc/openvpn/vc.conf && sudo service openvpn restart
fi


if [ "$1" = "target_server" ]
then
rm /etc/openvpn/client-pc.conf
echo > /etc/openvpn/client-sc.conf
echo client >> /etc/openvpn/client-sc.conf
sed -i "/remote/d" /etc/openvpn/client-sc.conf && echo remote $2 $4 >> /etc/openvpn/client-sc.conf
echo dev $5 >> /etc/openvpn/client-sc.conf
echo proto $3 >> /etc/openvpn/client-sc.conf
echo resolv-retry infinite >> /etc/openvpn/client-sc.conf
echo nobind >> /etc/openvpn/client-sc.conf
echo user nobody >> /etc/openvpn/client-sc.conf
echo group nobody >> /etc/openvpn/client-sc.conf
echo persist-key >> /etc/openvpn/client-sc.conf
echo persist-tun >> /etc/openvpn/client-sc.conf
mv /etc/openvpn/ca-cert.pem /etc/openvpn/ca.pem && echo ca ca.pem >> /etc/openvpn/client-sc.conf
mv /etc/openvpn/*-cert.pem /etc/openvpn/client-spantree-cert.pem && echo cert client-spantree-cert.pem >> /etc/openvpn/client-sc.conf
mv /etc/openvpn/*-key.pem /etc/openvpn/client-spantree-key.pem && echo key client-spantree-key.pem >> /etc/openvpn/client-sc.conf
echo ns-cert-type server >> /etc/openvpn/client-sc.conf
echo comp-lzo >> /etc/openvpn/client-sc.conf
echo verb 3 >> /etc/openvpn/client-sc.conf
echo route-nopull >> /etc/openvpn/client-sc.conf
echo auth-user-pass /etc/pass/userpass.txt >> /etc/openvpn/client-sc.conf
sed -i '/iptables -t nat -A POSTROUTING/d' /usr/bin/tapvpn.sh && /sbin/shorewall restart
  if [ "$3" = "tcp" ]
  then
  echo tun-mtu 1500  >> /etc/openvpn/client-sc.conf
  echo mssfix  >> /etc/openvpn/client-sc.conf
  else
  echo tun-mtu 1500  >> /etc/openvpn/client-sc.conf
  echo fragment 1300  >> /etc/openvpn/client-sc.conf
  echo mssfix  >> /etc/openvpn/client-sc.conf
  fi
fi

if [ "$1" = "targetp_server" ]
then
#mv /etc/openvpn/*.conf /etc/openvpn/client-pc.conf
sed -i '/remote/d' /etc/openvpn/client-pc.conf
echo remote $2 1194 >> /etc/openvpn/client-pc.conf && /sbin/iptables -t nat -A POSTROUTING -o tap+ -j MASQUERADE && /sbin/iptables -t nat -A POSTROUTING -o tun+ -j MASQUERADE
echo iptables -t nat -A POSTROUTING -o tap+ -j MASQUERADE >> /usr/bin/tapvpn.sh && echo iptables -t nat -A POSTROUTING -o tun+ -j MASQUERADE >> /usr/bin/tapvpn.sh
fi


if [ "$1" = "target_vcserver" ]
then
sed -i '/remote/d' /etc/openvpn/vc.conf
echo remote $2 1194 >> /etc/openvpn/vc.conf && echo remote $2 1194 >> /etc/vpnmgt/vcmgt/vc.conf
fi


if [ "$1" = "targetse_server" ]
then
sed -i '/remote/d' /etc/openvpn/client-sce.conf
echo remote $2 53 >> /etc/openvpn/client-sce.conf
echo remote $2 69 >> /etc/openvpn/client-sce.conf
fi

if [ "$1" = "add_pass" ]
then
echo "$2\n$3" > /etc/pass/userpass.txt 
sed -i '/auth-user-pass/d' /etc/openvpn/client-sc.conf && echo  "\nauth-user-pass /etc/pass/userpass.txt" >> /etc/openvpn/client-sc.conf
sed -i '/auth-user-pass/d' /etc/openvpn/client-pc.conf && echo  "\nauth-user-pass /etc/pass/userpass.txt" >> /etc/openvpn/client-pc.conf
fi

if [ "$1" = "add_vcpass" ]
then
echo "$2\n$3" > /etc/pass/vcpass.txt 
sed -i '/auth-user-pass/d' /etc/openvpn/vc.conf && echo auth-user-pass /etc/pass/vcpass.txt >> /etc/openvpn/vc.conf
sed -i '/auth-user-pass/d' /etc/vpnmgt/vcmgt/vc.conf && echo auth-user-pass /etc/pass/vcpass.txt >> /etc/vpnmgt/vcmgt/vc.conf
fi

if [ "$1" = "add_voicemail" ]
then
echo > /etc/ssmtp/ssmtp.conf
echo "mailhub=$4" >> /etc/ssmtp/ssmtp.conf
echo "hostname=sb105.spanboxng.com" >> /etc/ssmtp/ssmtp.conf
echo "root=$2" >> /etc/ssmtp/ssmtp.conf
echo "AuthUser=$2" >> /etc/ssmtp/ssmtp.conf
echo "AuthPass=$3" >> /etc/ssmtp/ssmtp.conf
echo "UseSTARTTLS=$5" >> /etc/ssmtp/ssmtp.conf
echo "UseTLS=$5" >> /etc/ssmtp/ssmtp.conf
echo "FromLineOverride=yes" >> /etc/ssmtp/ssmtp.conf
echo "AuthMethod=LOGIN" >> /etc/ssmtp/ssmtp.conf
#
echo > /etc/ssmtp/revaliases
echo "root:$2:$4" >> /etc/ssmtp/revaliases
fi


if [ "$1" = "upgrade" ]
then
rm /usr/src/upgrade/*
ftp -in upgrade.spanboxng.com << SCRIPTEND
user ftpuser abcd@1234
pa
ha
lcd /var/www/
mget spanBoxcdma.tar.gz
lcd /usr/bin
mget spanboxcdma.sh
lcd /usr/src/upgrade
cd upgrade
mget sb105-upgrade*
bye
SCRIPTEND
mv /var/www/spanBox/users.txt /var/www/
cd /var/www
gunzip *.gz
tar xvf *.tar
rm *.tar
mv users.txt spanBox/
mv /usr/bin/spanboxcdma.sh /usr/bin/spanbox.sh
chmod +x /usr/bin/spanbox.sh
/bin/cp /var/www/spanBox/update.sh /usr/bin
chmod +x /usr/bin/update.sh
sudo /usr/bin/update.sh

fi

if [ "$1" = "clear_vpn_dir" ]
then
rm /etc/openvpn/* && sudo killall openvpn
fi

if [ "$1" = "clear_voicemail" ]
then
find /var/spool/asterisk/voicemail -name "msg*.*" -print | xargs rm
fi

if [ "$1" = "clear_cdma" ]
then
#echo "from the cdma network" > /var/www/1.txt
sudo /usr/bin/cdmadisconnect && sudo /usr/bin/cdmaconnect 
fi

if [ "$1" = "cdma-config" ]
then
p=$2
q=""$p"@visafone.com.ng"
sed -i '/visafone/d' /etc/ppp/peers/provider
echo '\nuser '"'$q'"'' >> /etc/ppp/peers/provider
sed -i '/visafone/d' /etc/ppp/chap-secrets
echo '\n'"'$q'"' '*' '"'$p'"'' >> /etc/ppp/chap-secrets
sudo /usr/bin/cdmadisconnect && sudo /usr/bin/cdmaconnect
fi


if [ "$1" = "network_config" ]
then
echo > /etc/network/interfaces
echo > /etc/dhcp/dhcpd.conf
echo auto lo eth1 eth0 lo:1 uap0 >>  /etc/network/interfaces
echo iface lo inet loopback >>  /etc/network/interfaces
ifconfig lo:1 1.1.1.1 netmask 255.255.255.255 up 
fi

if [ "$1" = "route_add_host" ]
then
sudo route add -host $2 gw $3 metric $4 && echo route add -host $2 gw $3 metric $4 >> /etc/rc.local
fi

if [ "$1" = "route_add_net" ]
then
sudo route add -net $2 netmask $3 gw $4 metric $5  && echo route add -net $2 netmask $3 gw $4 metric $5 >> /etc/rc.local
fi

if [ "$1" = "route_del_host" ]
then
sudo route del -host $2 && sed -i '/route add -host '$2'/d' /etc/rc.local
fi
if [ "$1" = "route_del_net" ]
then
sudo route del -net $2 netmask $3 && sed -i '/route add -net '$2'/d' /etc/rc.local
fi

if [ "$1" = "wlan_config" ]
  then
    if [ "$3" = "yes" ] 
    then
      sed -i '/ifconfig uap0/d' /root/k2.6.39.4/init_setup8787.sh
      echo ifconfig uap0 $4 netmask $5 up >> /root/k2.6.39.4/init_setup8787.sh
      ifconfig uap0 $4 netmask $5 up
    fi
    if [ "$2" = "yes" ] 
    then
      x=`echo $4 | cut -d "." --complement -f4`.100
      y=`echo $4 | cut -d "." --complement -f4`.200
      echo '#WLAN'>> /etc/dhcp/dhcpd.conf
      echo subnet $4 netmask $5 {  >> /etc/dhcp/dhcpd.conf

      echo option domain-name-servers $8 $9';' >> /etc/dhcp/dhcpd.conf

      echo option domain-name '"'$6'"' '; '>> /etc/dhcp/dhcpd.conf

      echo option routers $7 ';' >> /etc/dhcp/dhcpd.conf

      echo ddns-domainname '"'$6'"' ';' >> /etc/dhcp/dhcpd.conf

      echo range dynamic-bootp $x $y ';}' >> /etc/dhcp/dhcpd.conf 
    fi
fi

if [ "$1" = "wlan_key_apply" ]
then
      echo "WLAN KEY is not empty" $2 >> /var/www/install.log
      sed -i '/uaputl sys_cfg_wpa_passphrase/d' /root/k2.6.39.4/init_setup8787.sh
      sed -i '/uaputl bss_start/d' /root/k2.6.39.4/init_setup8787.sh     
      sed -i '/uaputl sys_cfg_wpa_passphrase/d' /bin/wireless.sh
      sed -i '/uaputl bss_start/d' /bin/wireless.sh
      echo uaputl sys_cfg_wpa_passphrase $2 >> /bin/wireless.sh
      echo uaputl bss_start >> /bin/wireless.sh
      echo uaputl sys_cfg_wpa_passphrase $2 >> /root/k2.6.39.4/init_setup8787.sh
      echo uaputl bss_start >> /root/k2.6.39.4/init_setup8787.sh
      sudo /bin/wireless.sh
      #sudo uaputl bss_stop
      #sudo uaputl sys_cfg_wpa_passphrase $2
      #sudo uaputl bss_start
fi
    
if [ "$1" = "wan_config" ]
  then
  if [ "$2" = "yes" ]
    then
      echo iface eth0 inet dhcp >>  /etc/network/interfaces
  fi
  if [ "$3" = "yes" ]
    then
      echo iface eth0 inet static >>  /etc/network/interfaces

      echo address $4 >>  /etc/network/interfaces

      echo netmask $6 >>  /etc/network/interfaces

      echo gateway $5 >>  /etc/network/interfaces
  fi
fi

if [ "$1" = "lan_config" ]
  then
  if [ "$3" = "yes" ]
  then
    echo  iface eth1 inet static >>  /etc/network/interfaces
    
    echo  address $4 >>  /etc/network/interfaces

    echo  netmask $6 >>  /etc/network/interfaces

    echo  network $5 >>  /etc/network/interfaces
  fi 

  if [ "$2" = "yes" ]
  then
    x=`echo $4 | cut -d "." --complement -f4`.100
    y=`echo $4 | cut -d "." --complement -f4`.200
    echo '#LAN' >> /etc/dhcp/dhcpd.conf
    echo subnet $4 netmask $5 {  >> /etc/dhcp/dhcpd.conf

    echo option domain-name-servers $8 $9';' >> /etc/dhcp/dhcpd.conf

    echo option domain-name '"'$6'"' '; '>> /etc/dhcp/dhcpd.conf

    echo option routers $7 ';' >> /etc/dhcp/dhcpd.conf

    echo ddns-domainname '"'$6'"' ';' >> /etc/dhcp/dhcpd.conf

    echo range dynamic-bootp $x $y ';}' >> /etc/dhcp/dhcpd.conf 

  fi
fi

if [ "$1" = "network_startup" ]
then
echo ifconfig uap0 $4 netmask $5 up >> /var/www/1.txt 
fi
if [ "$1" = "dhcp_clean" ]
then
echo > /etc/dhcp/dhcpd.conf
fi

if [ "$1" = "dhcp_renew" ]
then
    rm /var/lib/dhcp/dhcpd.leases

    touch /var/lib/dhcp/dhcpd.leases

    /etc/init.d/networking restart 

    /etc/init.d/isc-dhcp-server restart
fi

if [ "$1" = "add_fw_rule" ]
then
  if [ -s "/etc/shorewall/rules" ]
  then
  sed -i  "1i $2 $3 $4 $5 $6 $7 " /etc/shorewall/rules
  else
    echo $2 $3 $4 $5 $6 $7 > /etc/shorewall/rules
  fi

/sbin/shorewall save && /sbin/shorewall restart 
fi

if [ "$1" = "rule_del" ]
then
shift
sed -i "$@" /etc/shorewall/rules
/sbin/shorewall save && /sbin/shorewall restart 
fi

if [ "$1" = "add_nat_rule" ]
then
  if [ -s "/etc/shorewall/nat" ]
  then
  sed -i  "1i $2 $3 $4 $5 $6" /etc/shorewall/nat
  else
    echo $2 $3 $4 $5 $6 > /etc/shorewall/nat
  fi
sudo /sbin/shorewall save && sudo /sbin/shorewall restart 
fi

if [ "$1" = "nat_rule_del" ]
then
shift
sed -i "$@" /etc/shorewall/nat
sudo /sbin/shorewall save && sudo /sbin/shorewall restart 
fi
if [ "$1" = "add_sce_srv" ]
then
  if [ "$2" = "0" ]
  then
  echo $3 > /usr/bin/target_server.txt
  else
  sed -i  "$2i $3" /usr/bin/target_server.txt
  fi
fi

if [ "$1" = "del_sce_srv" ]
then
  sed -i  "$2d" /usr/bin/target_server.txt
fi

if [ "$1" = "fw_restart" ]
then
  sudo sbin/shorewall start && sed -i '/startup/d' /etc/default/shorewall && echo 'startup=1' >> /etc/default/shorewall
fi

if [ "$1" = "fw_stop" ]
then
  sudo sbin/shorewall stop && sed -i '/startup/d' /etc/default/shorewall && echo 'startup=1' >> /etc/default/shorewall
fi

exit 0

