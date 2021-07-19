rm /etc/openvpn/client-sc.conf && /sbin/iptables -t nat -A POSTROUTING -o tap+ -j MASQUERADE && /sbin/iptables -t nat -A POSTROUTING -o tun+ -j MASQUERADE && echo iptables -t nat -A POSTROUTING -o tap+ -j MASQUERADE >> /usr/bin/tapvpn.sh && echo iptables -t nat -A POSTROUTING -o tun+ -j MASQUERADE >> /usr/bin/tapvpn.sh

