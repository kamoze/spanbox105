#!/bin/sh -x
NAME=[0].0.0.0
route | grep $NAME
if [ $? -eq 0 ]; then
   echo "Internet is up"
else
  echo "Trying to reach the Internet"
   ifdown eth0 && ifup eth0
fi
if [ $? -eq 0 ]; then
   echo "Internet is now up"
else
   /usr/bin/3gdisconnect
   /usr/bin/3gconnect
fi

