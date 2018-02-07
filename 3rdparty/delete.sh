#!/bin/bash
cd "$(dirname "$0")"

echo "############################################################################"
echo "# Remove pulseaudio-speaker-service-$1 for this device"
echo "############################################################################"
if [ -f /etc/init.d/pulseaudio-speaker-service-$1 ]; then
    echo "############################################################################"
    echo "# Disconnect bluetooth this device"
    echo "############################################################################"
    sudo service pulseaudio-speaker-service-$1 stop
    sudo update-rc.d pulseaudio-speaker-service-$1 remove
    sudo systemctl daemon-reload
    sudo rm -Rf /etc/init.d/pulseaudio-speaker-service-$1

    echo "############################################################################"
    echo "# Remove/Untrust bluetooth this device"
    echo "############################################################################"
    sudo expect /usr/sbin/bluetooth-unpair-untrust.sh $2 $3
    #sleep 5
fi
echo "############################################################################"
echo "# Remove pulseaudio-speaker-service-$1 finnished"
echo "############################################################################"
