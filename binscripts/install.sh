echo > /var/www/install.log
mkdir -p /usr/src/upgrade
rm /usr/src/upgrade/*
ftp -in ftp.wertecknologies.com << SCRIPTEND
user spanbox@wertecknologies.com abcd@1234
pa
ha
lcd /var/www/
mget *.gz 
lcd /usr/bin
mget *.sh
cd upgrade
lcd /usr/src/upgrade
mget sb105-upgrade*
bye
SCRIPTEND
echo "Files Copied" >> /var/www/install.log
cd /var/www
gunzip *.gz
tar xvf *.tar
rm *.tar
cd spanBox
chmod 777 users.txt
chmod 777 /usr/bin/spanbox.sh
if  grep  -Fq "www-data ALL=(ALL) NOPASSWD" /etc/sudoers 
then
  echo "sudoers already updated" >> /var/www/install.log 
else
  echo "www-data ALL=(ALL) NOPASSWD:/usr/sbin/service" >> /etc/sudoers
  echo "www-data ALL=(ALL) NOPASSWD:/usr/bin/spanbox.sh" >> /etc/sudoers
fi
if  grep  -Fq "export PATH" /etc/apache2/envvars
then
  echo "envvars already updated" >> /var/www/install.log 
else 
  echo "export PATH=$PATH:/sbin:/usr/sbin" >> /etc/apache2/envvars
fi
chmod 777 /etc/openvpn
chmod 777 /etc/shorewall/rules
