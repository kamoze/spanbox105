TARGETS = mountkernfs.sh udev mountdevsubfs.sh bootlogd keyboard-setup hostname.sh hwclockfirst.sh checkroot.sh hwclock.sh ifupdown-clean module-init-tools mtab.sh checkfs.sh mountall.sh ifupdown mountall-bootclean.sh mountoverflowtmp networking urandom x11-common pppd-dns procps udev-mtab portmap mountnfs.sh mountnfs-bootclean.sh kbd console-setup shorewall alsa-utils sudo bootmisc.sh stop-bootlogd-single
INTERACTIVE = udev keyboard-setup checkroot.sh checkfs.sh kbd console-setup
udev: mountkernfs.sh
mountdevsubfs.sh: mountkernfs.sh udev
bootlogd: mountdevsubfs.sh
keyboard-setup: bootlogd mountkernfs.sh udev
hostname.sh: bootlogd
hwclockfirst.sh: mountdevsubfs.sh bootlogd
checkroot.sh: hwclockfirst.sh mountdevsubfs.sh hostname.sh bootlogd keyboard-setup
hwclock.sh: checkroot.sh bootlogd
ifupdown-clean: checkroot.sh
module-init-tools: checkroot.sh
mtab.sh: checkroot.sh
checkfs.sh: checkroot.sh mtab.sh
mountall.sh: checkfs.sh
ifupdown: ifupdown-clean
mountall-bootclean.sh: mountall.sh
mountoverflowtmp: mountall-bootclean.sh
networking: mountkernfs.sh mountall.sh mountoverflowtmp ifupdown
urandom: mountall.sh mountoverflowtmp
x11-common: mountall.sh mountoverflowtmp
pppd-dns: mountall.sh mountoverflowtmp
procps: mountkernfs.sh mountall.sh mountoverflowtmp udev module-init-tools bootlogd
udev-mtab: udev mountall.sh mountoverflowtmp
portmap: networking ifupdown mountall.sh mountoverflowtmp
mountnfs.sh: mountall.sh mountoverflowtmp networking ifupdown portmap
mountnfs-bootclean.sh: mountall.sh mountoverflowtmp mountnfs.sh
kbd: mountall.sh mountoverflowtmp mountnfs.sh mountnfs-bootclean.sh
console-setup: mountall.sh mountoverflowtmp mountnfs.sh mountnfs-bootclean.sh kbd
shorewall: networking ifupdown mountall.sh mountoverflowtmp mountnfs.sh mountnfs-bootclean.sh
alsa-utils: mountall.sh mountoverflowtmp mountnfs.sh mountnfs-bootclean.sh udev
sudo: mountall.sh mountoverflowtmp mountnfs.sh mountnfs-bootclean.sh
bootmisc.sh: mountall.sh mountoverflowtmp mountnfs.sh mountnfs-bootclean.sh udev
stop-bootlogd-single: mountall.sh mountoverflowtmp udev keyboard-setup console-setup hwclock.sh checkroot.sh mountnfs.sh mountnfs-bootclean.sh networking ifupdown portmap ifupdown-clean mountkernfs.sh urandom shorewall alsa-utils hostname.sh sudo mountall-bootclean.sh x11-common pppd-dns module-init-tools checkfs.sh mtab.sh procps hwclockfirst.sh mountdevsubfs.sh bootmisc.sh udev-mtab bootlogd kbd
