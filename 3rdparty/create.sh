#!/bin/bash
if [[ $EUID -ne 0 ]]; then
  sudo_prefix=sudo;
fi
cd "$(dirname "$0")"
echo "############################################################################"
echo "# Create/Update pulseaudio-speaker-service-$1 for this device"
echo "############################################################################"
if [ -f /etc/init.d/pulseaudio-speaker-service-$1 ]; then
    echo "Service already exist for $1, replace it"
    $sudo_prefix service pulseaudio-speaker-service-$1 stop
    $sudo_prefix update-rc.d -f pulseaudio-speaker-service-$1 remove
    $sudo_prefix rm -Rf /etc/init.d/pulseaudio-speaker-service-$1
fi
$sudo_prefix cp pulseaudio-speaker-service /etc/init.d/pulseaudio-speaker-service-$1

#cd /etc/init.d/
$sudo_prefix sed -i "s|\@\@name\@\@|$1|g" /etc/init.d/pulseaudio-speaker-service-$1
$sudo_prefix sed -i "s|\@\@port\@\@|$2|g" /etc/init.d/pulseaudio-speaker-service-$1
$sudo_prefix sed -i "s|\@\@address\@\@|$3|g" /etc/init.d/pulseaudio-speaker-service-$1
$sudo_prefix chmod +x /etc/init.d/pulseaudio-speaker-service-$1
$sudo_prefix update-rc.d pulseaudio-speaker-service-$1 defaults
$sudo_prefix systemctl daemon-reload

#echo "############################################################################"
#echo "# Pair/Trust bluetooth this device"
#echo "############################################################################"
#$sudo_prefix chmod +x /usr/sbin/bluetooth-pair-trust.sh $2
#$sudo_prefix expect /usr/sbin/bluetooth-pair-trust.sh $2
#sleep 5

echo "############################################################################"
echo "# Connect bluetooth this device"
echo "############################################################################"
$sudo_prefix service pulseaudio-speaker-service-$1 start

echo "############################################################################"
echo "# Create/Update pulseaudio-speaker-service-$1 finnished"
echo "############################################################################"
