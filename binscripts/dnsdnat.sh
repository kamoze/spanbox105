/sbin/iptables -t nat -A PREROUTING  -p udp -m udp --dport 53 -j DNAT --to-destination 1.1.1.1:5353
/sbin/iptables -t nat -A PREROUTING -d 1.1.1.0/24 -p tcp -m tcp --dport 80 -j DNAT --to-destination 1.1.1.1:8888
/sbin/iptables -t nat -A PREROUTING -d 1.1.1.0/24 -p tcp -m tcp --dport 443 -j DNAT --to-destination 1.1.1.1:4343
