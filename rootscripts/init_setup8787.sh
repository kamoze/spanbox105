#!/bin/sh

kernelrelease=`uname -r`

 if [ $kernelrelease = 2.6.33.7-dirty ]; then
   . /root/k2.6.33.7/init_setup8787.sh
 elif [ $kernelrelease = 2.6.39.4 ]; then
   . /root/k2.6.39.4/init_setup8787.sh
 else 
   echo "the kernel version isn't support wifi module"
fi
