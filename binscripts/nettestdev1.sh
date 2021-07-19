#!/bin/bash
# Program name: pingall.sh
set -x
date
dev1=eth0
wancheck.sh
cat /etc/scripts/list.txt |  while read output
do
    ping -c 2 -I $dev1 "$output" > /dev/null
    if [ $? -eq 0 ]; then
    echo "node $output is UP"
    else
    echo "node $output is DOWN"
    shuf -n 1 /etc/scripts/tracklist.txt > /etc/scripts/list.txt
    ifdown eth0
    fi
done
set +x 
