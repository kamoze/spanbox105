rm /var/lib/dhcp/dhcpd.leases
touch /var/lib/dhcp/dhcpd.leases
/etc/init.d/networking restart
/etc/init.d/isc-dhcp-server restart
#

