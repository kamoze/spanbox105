#!/usr/bin/perl 

##### README#############################################
# Hello, this script is designed to to update a DynDNS by sitelutions
# it designed to be run by hand or from cron with an entry like this  (to run every 5 minutes)
# */5 * * * * /path/to/ddnsupdate.pl
# All modifications to fit your needs can be found in the configuration section below
# external software needed : wget (yum install wget if missing)
# Arnaud Brugnon <abrugnon@mail4.pro>
################################################

#
# configuration section
# 
#$ADAPTER=tap0; # identify device to get info from
$VERBOSE=1; # usefull for tunning and development
$LASTIPFILE='/tmp/ddnsupdate.txt'; # the place where to store the lastupdated IP 
$FORCED_ADDRESS=undef; # if you want to force a certain IP address for testing purposes ex : $FORCED_ADDRESS='1.2.3.4';

$SLUSER='research@spantreeng.com'; # sitelutions login
$SLPASS='research'; # This is your password
# If you have multiple records, use something like $SLID=99234,423445,234355
$SLID='9342741';
#
# end configuration section
#

BEGIN {
    # set LANG so we don't mess with LOCALE settings
    $ENV{'LANG'} ='C';
}

# getVpnAddr
# args:
# @device
sub getVpnAddr {
   # $adapter = shift;
    # do we use a forced address for testing ?
    if ($FORCED_ADDRESS) {
	return $FORCED_ADDRESS;
    }
 
   
    $devicelist = `ifconfig | grep 'tun' | cut -d ' ' -f 1`;
    
    @niclist = split /^/, $devicelist;
    foreach $adapter (@niclist) {
	chomp($adapter);
	#print "TEST : $adapter -";
	$netinfo = `ifconfig $adapter | grep 'inet addr'`;
	print $netinfo if $VERBOSE;
	$netinfo =~ s|^\s+inet\s+addr:\s*([0-9.]+)\s+.*|${1}|g;
	print $netinfo if $VERBOSE;
	# check if this failed
	if ($netinfo =~ '^10\.9.\.') {
	    chomp($netinfo);
	    # return captured IP address
	    return $netinfo;
	}
    }
    # not found
    
    return -1;
}

# updateDDNS
# update sitelutions DynDNS with code and data
# @ipaddr : the address you want to set

sub updateDDNS {
    $ipaddr=shift;
    $command="wget -q -O - 'https://www.sitelutions.com/dnsup?user=$SLUSER&pass=$SLPASS&id=$SLID&ip=$ipaddr\'";
    print "Running : $command\n" if $VERBOSE;
    $return=`$command`;
    chomp($return);
    $code = ${^CHILD_ERROR_NATIVE};
    if ( $return ne 'success' || $code !=0) {
	print "Something went wrong in update :\n" . $return;
    }
    print "return : $return / code : $code\n" if $VERBOSE;
    
}

#
#
sub getLastRecordedIP {
    if (-f $LASTIPFILE) {
	$lastip = `cat $LASTIPFILE`;
	return chomp($lastip);
    } else {
	return 'undefined';
    }
}

sub recordIP {
    $lastip=shift;
    open FILE , ">$LASTIPFILE" || die 'Unable to write to file $LASTIPFILE' . $!;
    print FILE $lastip;
    close FILE;
}
### MAIN SECTION ###

$CURRENT_IP=getVpnAddr () ;
if ($CURRENT_IP == -1) {
    print "Interface $ADAPTER down  or no IP address bound\n" if $VERBOSE;
    exit 1;
}
$lastip=  &getLastRecordedIP ();
if ($lastip != $CURRENT_IP) {
    print "Need update to $CURRENT_IP\n" if $VERBOSE;
    updateDDNS ($CURRENT_IP);
    recordIP($CURRENT_IP);
} else {
    print "Nothing to do, DNS up to date with IP : $CURRENT_IP\n" if $VERBOSE;
}
exit 0; 
