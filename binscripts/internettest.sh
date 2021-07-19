#!/bin/bash
# Program name: pingall.sh
date
dev1=eth0
cat /tmp/list.txt |  while read output
do
    ping -c 1 -I $dev1 "$output" > /dev/null
    if [ $? -eq 0 ]; then
    echo "node $output is UP" 
    else
    echo "node $output is DOWN"
    fi
done
