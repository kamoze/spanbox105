#!/bin/sh

NAME=[0].0.0.0 | eth0
route | grep $NAME
if [ $? -eq 0 ]; then
   echo "Internet is up"
else
  echo "Trying to reach the Internet"
   ifdown eth0 && ifup eth0
fi

