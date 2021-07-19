#!/bin/sh
if [ "$1" = "add_sync" ]; then
	if [ $4 -gt 0 ] && [ $2 = 'localhost' ] && [ $3 = 'sp@nb0x' ]; then
               echo "$cur_date Set to Local Sync"
               sed -i '/Z=/d' /usr/bin/checkiprouterun.sh
	       sed -i "4i Z=checkiproute.sh" /usr/bin/checkiprouterun.sh 
        elif [ $4 = 0 ]; then
               echo "$cur_date Controller Sync"
               sed -i '/Z=/d' /usr/bin/checkiprouterun.sh
               sed -i "4i Z=checkiprouteremote.sh" /usr/bin/checkiprouterun.sh
        else
	      echo "$cur_date No Sync"
        fi
fi

if [ "$1" = "sync_restart" ]
then
  /usr/bin/checkiprouterun.sh
fi

if [ "$1" = "pool_init" ]
then
  /usr/bin/checkiproute.sh
fi

if [ "$1" = "pool_server" ]
then
  /usr/bin/ipcalc $2 /$3 | grep Network: | awk '{print $2}' | grep -v ''$2'' | grep -v '192.168.1.0/24' | grep -v '192.168.254.0/24' > /root/vvpsipsub.txt
fi

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
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountDisconnect VVPS
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountDelete VVPS
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD NicDelete vvps
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD NicCreate vvps
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountCreate VVPS /SERVER:vpnvcvoip1.spantreeng.com:443 /HUB:VVPS /USERNAME:vvpsdemo1 /NICNAME:vvps
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /IN:/etc/vpnmgt/vvpsmgt/vvpscmd.txt
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountStartupSet VVPS
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountConnect VVPS
  echo "0" > /usr/bin/setipvvps.txt && sudo /usr/bin/setipvvps.sh
  /usr/bin/checkipvvps.sh
  #sudo service vpnclient restart && sudo service openvpn restart && sed -i "/service openvpn stop/d" /etc/rc.local && sed -i "/service openvpn stop/d" /usr/bin/tapcheck0.sh && sudo /usr/bin/spanboxpcrm.sh
fi

if [ "$1" = "voip_restart" ]
then
sudo service asterisk restart
fi

if [ "$1" = "vpn_restart2" ]
then
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountDisconnect WWW
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountDelete WWW
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD NicDelete www
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD NicCreate www
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountCreate WWW /SERVER:vpnvcvoip1.spantreeng.com:443 /HUB:Internet /USERNAME:wwwdemo1 /NICNAME:www
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /IN:/etc/vpnmgt/wwwmgt/wwwcmd.txt
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountStartupSet WWW
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountConnect WWW
  echo "0" > /usr/bin/setipwww.txt && sudo /usr/bin/setipwww.sh
  /usr/bin/checkipwww.sh
#sudo service openvpn restart && sed -i "/service openvpn stop/d" /etc/rc.local && sed -i "/service openvpn stop/d" /usr/bin/tapcheck0.sh && sudo /usr/bin/spanboxscrm.sh
fi

if [ "$1" = "vpn_stop2" ]
then
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountDisconnect WWW
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountStartupRemove WWW
  echo "0" > /usr/bin/checkipwww.txt
  ip route del default
  ifdown eth0 && ifup eth0
#sudo service openvpn restart && sed -i "/service openvpn stop/d" /etc/rc.local && sed -i "/service openvpn stop/d" /usr/bin/tapcheck0.sh && sudo /usr/bin/spanboxscrm.$
fi

if [ "$1" = "vpn_stop1" ]
then
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountDisconnect VVPS
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountStartupRemove VVPS
fi

if [ "$1" = "vpn_stop" ]
then
  sudo service vpnclient stop && sudo killall openvpn && sed -i "/sudo openvpn/d" /etc/rc.local && echo "service openvpn stop" >> /etc/rc.local && echo "service openvpn stop" >> /usr/bin/tapcheck0.sh
fi

if [ "$1" = "vpn_start" ]
then
  sudo service vpnclient start && sed -i "/sudo openvpn/d" /etc/rc.local
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
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountDisconnect MGT
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountDelete MGT
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD NicDelete mgt
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD NicCreate mgt
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountCreate MGT /SERVER:vpnvcvoip1.spantreeng.com:443 /HUB:Mgt /USERNAME:mgt1974001 /NICNAME:mgt
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountConnect MGT
  /sbin/dhclient vpn_mgt
fi

if [ "$1" = "mgt_stop" ]
then
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountStartupRemove MGT
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountDisconnect MGT
fi

if [ "$1" = "target_dnsserver" ]
then
  echo "rsync -avz webfilter@upgrade.spantreeng.com:/home/webfilter/"$2"/ /etc/vpnmgt/dnsmgt/" > /usr/bin/dnssync.sh
  sudo /usr/bin/nameserver.sh
  sleep 5
  sudo /usr/bin/dnssync.sh
  chmod +x /etc/vpnmgt/dnsmgt/dnsserver.sh && sudo /etc/vpnmgt/dnsmgt/dnsserver.sh
fi

if [ "$1" = "wf_start" ]
then
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountDisconnect DNS
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountDelete DNS
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD NicDelete dns
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD NicCreate dns
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountCreate DNS /SERVER:vpnsmevoip1.spantreeng.com:443 /HUB:DNS /USERNAME:dns1974001 /NICNAME:dns
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountStartupSet DNS
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountConnect DNS
  sudo service dnsmasq restart
  /sbin/iptables -t nat -A PREROUTING  -p udp -m udp --dport 53 -j DNAT --to-destination 1.1.1.1:5353
  /sbin/iptables -t nat -A PREROUTING -d 1.1.1.0/24 -p tcp -m tcp --dport 80 -j DNAT --to-destination 1.1.1.1:8888
  /sbin/iptables -t nat -A PREROUTING -d 1.1.1.0/24 -p tcp -m tcp --dport 443 -j DNAT --to-destination 1.1.1.1:4343
  echo "/sbin/iptables -t nat -A PREROUTING  -p udp -m udp --dport 53 -j DNAT --to-destination 1.1.1.1:5353" > /usr/bin/dnsdnat.sh
  echo "/sbin/iptables -t nat -A PREROUTING -d 1.1.1.0/24 -p tcp -m tcp --dport 80 -j DNAT --to-destination 1.1.1.1:8888" >> /usr/bin/dnsdnat.sh
  echo "/sbin/iptables -t nat -A PREROUTING -d 1.1.1.0/24 -p tcp -m tcp --dport 443 -j DNAT --to-destination 1.1.1.1:4343" >> /usr/bin/dnsdnat.sh
  echo "1" > /usr/bin/setipdns.txt && /sbin/dhclient vpn_dns
fi

if [ "$1" = "wf_stop" ]
then
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountStartupRemove DNS
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountDisconnect DNS
  /sbin/iptables -t nat -F && sudo /sbin/shorewall restart
  echo > /usr/bin/dnsdnat.sh && echo "echo ""DNS Filter Disabled""" >> /usr/bin/dnsdnat.sh
  sudo /usr/bin/dnsreset.sh
  echo "0" > /usr/bin/setipdns.txt
  /sbin/iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE
  /sbin/iptables -t nat -A POSTROUTING -o ppp0 -j MASQUERADE
fi

if [ "$1" = "wf_start2" ]
then
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountDisconnect DNS
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountDelete DNS
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD NicDelete dns
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD NicCreate dns
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountCreate DNS /SERVER:vpnsmevoip1.spantreeng.com:443 /HUB:DNS /USERNAME:dns1974001 /NICNAME:dns
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountStartupSet DNS
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /IN:/etc/vpnmgt/dnsmgt/dnscmd.txt
  sudo service dnsmasq restart && /sbin/iptables -t nat -A PREROUTING  -p udp -m udp --dport 53 -j DNAT --to-destination 1.1.1.1:5353
  /sbin/iptables -t nat -A PREROUTING -d 1.1.1.0/24 -p tcp -m tcp --dport 80 -j DNAT --to-destination 1.1.1.1:8888
  /sbin/iptables -t nat -A PREROUTING -d 1.1.1.0/24 -p tcp -m tcp --dport 443 -j DNAT --to-destination 1.1.1.1:4343
  echo "/sbin/iptables -t nat -A PREROUTING  -p udp -m udp --dport 53 -j DNAT --to-destination 1.1.1.1:5353" > /usr/bin/dnsdnat.sh
  echo "/sbin/iptables -t nat -A PREROUTING -d 1.1.1.0/24 -p tcp -m tcp --dport 80 -j DNAT --to-destination 1.1.1.1:8888" >> /usr/bin/dnsdnat.sh
  echo "/sbin/iptables -t nat -A PREROUTING -d 1.1.1.0/24 -p tcp -m tcp --dport 443 -j DNAT --to-destination 1.1.1.1:4343" >> /usr/bin/dnsdnat.sh
  echo "1" > /usr/bin/setipdns.txt && /sbin/dhclient vpn_dns
fi



if [ "$1" = "trunk_start" ]
then
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountDisconnect VC
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountDelete VC
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD NicDelete vc
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD NicCreate vc
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountCreate VC /SERVER:vpnvcvoip1.spantreeng.com:443 /HUB:VoIPConnect /USERNAME:vcdemo1 /NICNAME:vc
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /IN:/etc/vpnmgt/vcmgt/vccmd.txt
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountStartupSet VC
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountConnect VC
  echo "0" > /usr/bin/setipvc.txt && sudo /usr/bin/setipvc.sh
fi

if [ "$1" = "trunk_stop" ]
then
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountStartupRemove VC
  sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /CMD AccountDisconnect VC
fi

if [ "$1" = "sync_start" ]
then
  echo 1 > /usr/bin/checkiprouterun.txt
fi

if [ "$1" = "sync_stop" ]
then
  echo 0 > /usr/bin/checkiprouterun.txt
fi

if [ "$1" = "sla_server" ]
then
  echo ""$2"" | awk -F '[,]' '{print $1}' > /etc/scripts/tracklist.txt
#  echo ""$2"" | awk -F '[,]' '{print $2}' >> /etc/scripts/tracklist.txt
#  echo ""$2"" | awk -F '[,]' '{print $3}' >> /etc/scripts/tracklist.txt
#  echo ""$2"" | awk -F '[,]' '{print $4}' >> /etc/scripts/tracklist.txt
  shuf -n 1 /etc/scripts/tracklist.txt > /etc/scripts/list.txt
  /usr/bin/trackcheck.sh
fi

if [ "$1" = "sla_stop" ]
then
  echo 1 > /usr/bin/connectrun.txt
fi

if [ "$1" = "sla_start" ]
then
  echo 0 > /usr/bin/connectrun.txt
fi

if [ "$1" = "target_server" ]
then
echo > /etc/vpnmgt/vvpsmgt/vvpscmd.txt
echo "AccountSet VVPS /SERVER:"$2":"$3" /HUB:VVPS" >> /etc/vpnmgt/vvpsmgt/vvpscmd.txt
echo "AccountCompressEnable VVPS" >> /etc/vpnmgt/vvpsmgt/vvpscmd.txt
echo "AccountEncryptEnable VVPS" >> /etc/vpnmgt/vvpsmgt/vvpscmd.txt
echo ""$4"" > /usr/bin/vvpsiptype.txt
echo "VVPSIP="$5"" > /usr/bin/vvpsip.txt
echo ""$6"" > /usr/bin/vvpsroutetype.txt
#rm /etc/openvpn/client-pc.conf
#echo > /etc/openvpn/client-sc.conf
#echo client >> /etc/openvpn/client-sc.conf
#sed -i "/remote/d" /etc/openvpn/client-sc.conf && echo remote $2 $4 >> /etc/openvpn/client-sc.conf
#echo dev $5 >> /etc/openvpn/client-sc.conf
#echo proto $3 >> /etc/openvpn/client-sc.conf
#echo resolv-retry infinite >> /etc/openvpn/client-sc.conf
#echo nobind >> /etc/openvpn/client-sc.conf
#echo user nobody >> /etc/openvpn/client-sc.conf
#echo group nobody >> /etc/openvpn/client-sc.conf
#echo persist-key >> /etc/openvpn/client-sc.conf
#echo persist-tun >> /etc/openvpn/client-sc.conf
#mv /etc/openvpn/ca-cert.pem /etc/openvpn/ca.pem && echo ca ca.pem >> /etc/openvpn/client-sc.conf
#mv /etc/openvpn/*-cert.pem /etc/openvpn/client-spantree-cert.pem && echo cert client-spantree-cert.pem >> /etc/openvpn/client-sc.conf
#mv /etc/openvpn/*-key.pem /etc/openvpn/client-spantree-key.pem && echo key client-spantree-key.pem >> /etc/openvpn/client-sc.conf
#echo ns-cert-type server >> /etc/openvpn/client-sc.conf
#echo comp-lzo >> /etc/openvpn/client-sc.conf
#echo verb 3 >> /etc/openvpn/client-sc.conf
#echo route-nopull >> /etc/openvpn/client-sc.conf
#echo auth-user-pass /etc/pass/userpass.txt >> /etc/openvpn/client-sc.conf
#sed -i '/iptables -t nat -A POSTROUTING/d' /usr/bin/tapvpn.sh && /sbin/shorewall restart
# if [ "$3" = "tcp" ]
#  then
#  echo tun-mtu 1500  >> /etc/openvpn/client-sc.conf
#  echo mssfix  >> /etc/openvpn/client-sc.conf
#  else
#  echo tun-mtu 1500  >> /etc/openvpn/client-sc.conf
#  echo fragment 1300  >> /etc/openvpn/client-sc.conf
#  echo mssfix  >> /etc/openvpn/client-sc.conf
#  fi
fi

if [ "$1" = "targetp_server" ]
then
echo > /etc/vpnmgt/wwwmgt/wwwcmd.txt
echo "AccountSet WWW /SERVER:"$2":443 /HUB:Internet" >> /etc/vpnmgt/wwwmgt/wwwcmd.txt
#mv /etc/openvpn/*.conf /etc/openvpn/client-pc.conf
#sed -i '/remote/d' /etc/openvpn/client-pc.conf
#echo remote $2 1194 >> /etc/openvpn/client-pc.conf && /sbin/iptables -t nat -A POSTROUTING -o tap+ -j MASQUERADE && /sbin/iptables -t nat -A POSTROUTING -o tun+ -j MASQUERADE
#echo iptables -t nat -A POSTROUTING -o tap+ -j MASQUERADE >> /usr/bin/tapvpn.sh && echo iptables -t nat -A POSTROUTING -o tun+ -j MASQUERADE >> /usr/bin/tapvpn.sh
fi


if [ "$1" = "target_vcserver" ]
then
#sed -i '/remote/d' /etc/openvpn/vc.conf
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
echo "$2" "$3" "$4" > /var/www/2.txt
echo "AccountUsernameSet VVPS /USERNAME:"$2"" >> /etc/vpnmgt/vvpsmgt/vvpscmd.txt
echo "AccountPasswordSet VVPS /PASSWORD:"$3" /TYPE:"$4"" >> /etc/vpnmgt/vvpsmgt/vvpscmd.txt
#echo "$2\n$3" > /etc/pass/userpass.txt 
#sed -i '/auth-user-pass/d' /etc/openvpn/client-sc.conf && echo  "\nauth-user-pass /etc/pass/userpass.txt" >> /etc/openvpn/client-sc.conf
#sed -i '/auth-user-pass/d' /etc/openvpn/client-pc.conf && echo  "\nauth-user-pass /etc/pass/userpass.txt" >> /etc/openvpn/client-pc.conf
fi

if [ "$1" = "add_vcpass" ]
then
echo > /etc/vpnmgt/vcmgt/vccmd.txt
echo "$2\n$3" > /etc/pass/vcpass.txt
echo "AccountUsernameSet VC /USERNAME:"$2"" >> /etc/vpnmgt/vcmgt/vccmd.txt
echo "AccountPasswordSet VC /PASSWORD:"$3" /TYPE:standard" >> /etc/vpnmgt/vcmgt/vccmd.txt
echo "AccountSet VC /SERVER:"$4":443 /HUB:VoIPConnect" >> /etc/vpnmgt/vcmgt/vccmd.txt
echo "AccountCompressEnable VC" >> /etc/vpnmgt/vcmgt/vccmd.txt
echo "AccountEncryptEnable VC" >> /etc/vpnmgt/vcmgt/vccmd.txt
echo ""$5"" > /usr/bin/vciptype.txt
echo "VCIP="$6"" > /usr/bin/vcip.txt
sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /IN:/etc/vpnmgt/vcmgt/vccmd.txt
#sed -i '/auth-user-pass/d' /etc/openvpn/vc.conf && echo auth-user-pass /etc/pass/vcpass.txt >> /etc/openvpn/vc.conf
#sed -i '/auth-user-pass/d' /etc/vpnmgt/vcmgt/vc.conf && echo auth-user-pass /etc/pass/vcpass.txt >> /etc/vpnmgt/vcmgt/vc.conf
fi

if [ "$1" = "add_wwwpass" ]
then
echo > /etc/vpnmgt/wwwmgt/wwwcmd.txt
echo "AccountUsernameSet WWW /USERNAME:"$2"" >> /etc/vpnmgt/wwwmgt/wwwcmd.txt
echo "AccountPasswordSet WWW /PASSWORD:"$3" /TYPE:standard" >> /etc/vpnmgt/wwwmgt/wwwcmd.txt
echo "AccountSet WWW /SERVER:"$4":443 /HUB:Internet" >> /etc/vpnmgt/wwwmgt/wwwcmd.txt
echo "AccountCompressEnable WWW" >> /etc/vpnmgt/wwwmgt/wwwcmd.txt
echo "AccountEncryptEnable WWW" >> /etc/vpnmgt/wwwmgt/wwwcmd.txt
sudo /usr/local/vpnclient/vpncmd localhost /CLIENT /IN:/etc/vpnmgt/wwwmgt/wwwcmd.txt
#echo "$2\n$3" > /etc/pass/wwwpass.txt
#sed -i '/auth-user-pass/d' /etc/openvpn/client-sc.conf && echo  "\nauth-user-pass /etc/pass/userpass.txt" >> /etc/openvpn/client-sc.conf
#sed -i '/auth-user-pass/d' /etc/openvpn/client-pc.conf && echo  "\nauth-user-pass /etc/pass/userpass.txt" >> /etc/openvpn/client-pc.conf
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
mv /var/www/spanBox/users.txt /var/www/
sudo /usr/bin/upgradesync.sh
mv /var/www/users.txt /var/www/spanBox/
/bin/cp /usr/src/upgrade/update.sh /usr/bin/
/bin/cp /usr/src/upgrade/spanbox.sh /usr/bin/
/bin/cp /usr/src/upgrade/spanBox/ /var/www/spanBox/
chmod +x /usr/bin/spanbox.sh
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

if [ "$1" = "3gstaticset" ]
then
sed -i '/Z=/d' /usr/bin/connect.sh
sed -i '/test1=/d' /usr/bin/connect.sh 
sed -i "15i test1=`nettestnull.sh | grep UP | wc -l`" /usr/bin/connect.sh
sed -i "14i Z="$"test4" /usr/bin/connect.sh
fi

if [ "$1" = "3gstaticunset" ]
then
sed -i '/Z=/d' /usr/bin/connect.sh
sed -i '/test1=/d' /usr/bin/connect.sh
sed -i "14i Z="$"test1" /usr/bin/connect.sh
sed -i '15i test1=`'nettestdev1.sh' | grep UP | wc -l`' /usr/bin/connect.sh
fi

if [ "$1" = "cdmaset" ]
then
sed -i '/3gconnect*/d' /usr/bin/connect.sh
sed -i '/3gdisconnect/d' /usr/bin/connect.sh
sed -i '/cdmaconnect/d' /usr/bin/connect.sh
sed -i '/cdmadisconnect/d' /usr/bin/connect.sh
sed -i "2i GConn=cdmaconnect" /usr/bin/connect.sh
sed -i "3i GDConn=cdmadisconnect" /usr/bin/connect.sh
fi

if [ "$1" = "gsmset" ]
then
sed -i '/3gconnect*/d' /usr/bin/connect.sh
sed -i '/3gdisconnect/d' /usr/bin/connect.sh
sed -i '/cdmaconnect/d' /usr/bin/connect.sh
sed -i '/cdmadisconnect/d' /usr/bin/connect.sh
sed -i "2i GConn=3gconnect" /usr/bin/connect.sh
sed -i "3i GDConn=3gdisconnect" /usr/bin/connect.sh
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
      echo post-up /usr/bin/nameserver.sh >>  /etc/network/interfaces
  fi
  if [ "$3" = "yes" ]
    then
      echo iface eth0 inet static >>  /etc/network/interfaces

      echo address $4 >>  /etc/network/interfaces

      echo netmask $6 >>  /etc/network/interfaces

      echo gateway $5 >>  /etc/network/interfaces
      echo post-up /usr/bin/nameserver.sh >>  /etc/network/interfaces
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
    /bin/cp /etc/quagga/router-id.sh /usr/bin/ && sudo /usr/bin/router-id.sh
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
