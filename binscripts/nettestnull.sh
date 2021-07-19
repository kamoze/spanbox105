#!/bin/bash
# Program name: pingall.sh
date
dev1=Lo:1
cat /etc/scripts/list.txt |  while read output
do
    ping -c 5 -I $dev1 "$output" > /dev/null
    if [ $? -eq 0 ]; then
    echo "node $output is UP" 
    else
    echo "node $output is DOWN" && ifdown eth0
    fi
done
