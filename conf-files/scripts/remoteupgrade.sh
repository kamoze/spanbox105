rm /usr/src/upgrade/*
scp root@upgrade.spanboxng.com:/home/upgrade/* /usr/src/upgrade
chown root:root /usr/src/upgrade/* && chmod +x /usr/src/upgrade/sb105-upgradescript.sh && /usr/src/upgrade/sb105-upgradescript.sh

