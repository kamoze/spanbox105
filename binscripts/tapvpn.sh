
iptables -t nat -A POSTROUTING -o tap+ -j MASQUERADE
iptables -t nat -A POSTROUTING -o tun+ -j MASQUERADE
