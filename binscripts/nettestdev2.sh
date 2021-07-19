#!/bin/bash
# Program name: pingall.sh
date
dev1=ppp0
cat /etc/scripts/list.txt |  while read output
do
    ping -c 2 -I $dev1 "$output" > /dev/null
    if [ $? -eq 0 ]; then
    echo "node $output is UP"
    else
    echo "node $output is DOWN"
    shuf -n 1 /etc/scripts/tracklist.txt > /etc/scripts/list.txt
    fi
done
