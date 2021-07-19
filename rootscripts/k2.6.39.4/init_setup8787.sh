#!/bin/sh

# This is called from /etc/rc.local to perform the initial setup.

# We always bootup in AP mode. Delete any stale files
#rm -f /etc/wlanclient.mode
curdir=/root/k2.6.39.4
insmod $curdir/mlan.ko
insmod $curdir/sd8787.ko drv_mode=2

ip link set eth1 up 
SSID=spanbox105-`ip link show eth1 | awk -F ":" '/link/ {print $5$6}' | awk '{print $1}'`
PASS=sp@n-`ifconfig eth0 | awk -F ":" '/HWaddr/ {print $6$7}'`

uaputl bss_stop
uaputl sys_cfg_ssid $SSID
uaputl sys_cfg_protocol 32 
uaputl sys_cfg_cipher 8 8
uaputl sys_cfg_channel 0 1

echo $SSID > /etc/hostname
echo 127.0.0.1 $SSID  >> /etc/hosts

iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE
iptables -t nat -A POSTROUTING -o ppp0 -j MASQUERADE

echo 1 > /proc/sys/net/ipv4/ip_forward 

iptables -A INPUT -i uap0 -p tcp -m tcp --dport 80 -j ACCEPT

# Re-enable bluetooth. In the earlier case, it didn't find the firmware.
#rmmod libertas_sdio libertas btmrvl_sdio btmrvl bluetooth 2>/dev/null
#/etc/init.d/bluetooth start

#insmod $curdir/mbtchar.ko
#insmod $curdir/bt8787.ko
#hciconfig hci0 up
#hciconfig hci0 piscan
#mute-agent &

blinkled >> /dev/null

# Set leds
echo 1 > `eval ls /sys/class/leds/guruplug\:green\:wmode/brightness`
echo 0 > `eval ls /sys/class/leds/guruplug\:red\:wmode/brightness`
#

ifconfig lo:1 1.1.1.1 netmask 255.255.255.255 up
ifconfig eth1:1 192.168.254.254 netmask 255.255.255.252 up

iptables -t nat -A POSTROUTING -o tap+ -j MASQUERADE
iptables -t nat -A POSTROUTING -o tap+ -j MASQUERADE
uaputl sys_cfg_wpa_passphrase $PASS
uaputl bss_start
ifconfig uap0 192.168.158.1 netmask 255.255.255.0 up
