#!/bin/bash
cd "$(dirname "$0")"
echo "############################################################################"
echo "# Create/Update pulseaudio-speaker-service-$1 for this device"
echo "############################################################################"
if [ -f /etc/init.d/pulseaudio-speaker-service-$1 ]; then
    echo "Service already exist for $1, replace it"
    sudo service pulseaudio-speaker-service-$1 stop
    sudo update-rc.d -f pulseaudio-speaker-service-$1 remove
    sudo rm -Rf /etc/init.d/pulseaudio-speaker-service-$1
fi
sudo cp pulseaudio-speaker-service /etc/init.d/pulseaudio-speaker-service-$1

#cd /etc/init.d/
sudo sed -i "s|\@\@name\@\@|$1|g" /etc/init.d/pulseaudio-speaker-service-$1
sudo sed -i "s|\@\@port\@\@|$2|g" /etc/init.d/pulseaudio-speaker-service-$1
sudo sed -i "s|\@\@address\@\@|$3|g" /etc/init.d/pulseaudio-speaker-service-$1
sudo chmod +x /etc/init.d/pulseaudio-speaker-service-$1
sudo update-rc.d pulseaudio-speaker-service-$1 defaults
sudo systemctl daemon-reload

#echo "############################################################################"
#echo "# Pair/Trust bluetooth this device"
#echo "############################################################################"
#sudo chmod +x /usr/sbin/bluetooth-pair-trust.sh $2
#sudo expect /usr/sbin/bluetooth-pair-trust.sh $2
#sleep 5

echo "############################################################################"
echo "# Connect bluetooth this device"
echo "############################################################################"
sudo service pulseaudio-speaker-service-$1 start

echo "############################################################################"
echo "# Create/Update pulseaudio-speaker-service-$1 finnished"
echo "############################################################################"
