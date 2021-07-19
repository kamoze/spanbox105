rm /etc/openvpn/client-pc.conf && sed -i '/iptables -t nat -A POSTROUTING/d' /usr/bin/tapvpn.sh && /sbin/shorewall restart
