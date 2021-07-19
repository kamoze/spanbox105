#!/bin/sh
cur_date=`date "+%Y %b %d %H:%M"`
/etc/init.d/quagga restart
service apache2 restart
#

