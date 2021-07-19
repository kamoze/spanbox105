#!/usr/bin/python

import sys
import dbus
import dbus.service

if __name__ == '__main__':
    # Main processing
    bus = dbus.SystemBus()
    manager = dbus.Interface(bus.get_object("org.bluez", "/"), "org.bluez.Manager")
    adapter = dbus.Interface(bus.get_object("org.bluez", manager.DefaultAdapter()),
                             "org.bluez.Adapter")
    
    if len(sys.argv) > 1:
        macaddr = sys.argv[1]
    else:
        raw_input("Please put your headphones in pairing mode and press Enter: ")
        macaddr = raw_input("Enter the BT headphones' MAC Address: ")

# Write alsa configuration file
    alsa_bt = open("/usr/share/alsa/bluetooth.conf", 'w')
    write_data = str("pcm.headset {\n         type bluetooth\n         device \"" + macaddr + "\"\n         profile \"auto\"\n}\n")
    alsa_bt.write(write_data)
    alsa_bt.close()

# Head Phones Processing
    try:
        device = adapter.FindDevice(macaddr)
        # print "Deleting older device ", device
        delete_device = 1
    except:
        delete_device = 0
        
# Tabula Rasa
    if delete_device:
        adapter.RemoveDevice(device)
        # print "Device removed"
        
# Create the new device
    # print "Creating new device"
    newdevice = adapter.CreateDevice(macaddr)
    audiosink = dbus.Interface(bus.get_object("org.bluez", newdevice),
                                   "org.bluez.AudioSink")
    clean = 1
    try:
        audiosink.Connect()
        # print "Connection Established"
        clean = 0
    except:
        clean = 1
        # print "Connection Failed"

    if clean == 0:
        sys.exit(0)
    else:
        sys.exit(1)
