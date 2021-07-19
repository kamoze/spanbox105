/usr/bin/nameserver.sh
sleep 5
rsync -avz upgrade@upgrade.spantreeng.com:/home/upgrade/sb105-upgrade/ /usr/src/upgrade/
