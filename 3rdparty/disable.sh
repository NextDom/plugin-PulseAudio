#!/bin/bash
if [[ $EUID -ne 0 ]]; then
  sudo_prefix=sudo;
fi
cd "$(dirname "$0")"

echo "############################################################################"
echo "# Remove pulseaudio-speaker-service-$1 for this device"
echo "############################################################################"
if [ -f /etc/init.d/pulseaudio-speaker-service-$1 ]; then
    echo "############################################################################"
    echo "# Disconnect bluetooth this device"
    echo "############################################################################"
    $sudo_prefix service pulseaudio-speaker-service-$1 stop
    $sudo_prefix update-rc.d pulseaudio-speaker-service-$1 remove
    $sudo_prefix systemctl daemon-reload
    $sudo_prefix rm -Rf /etc/init.d/pulseaudio-speaker-service-$1
fi
echo "############################################################################"
echo "# Remove pulseaudio-speaker-service-$1 finnished"
echo "############################################################################"
