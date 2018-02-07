#!/bin/bash

echo "########### Suppression en cours ##########"
echo "############################################################################"
echo "# Removing all pulseaudio-speaker-service"
echo "############################################################################"
sudo service pulseaudio-speaker-service-* stop
sudo service pulseaudio stop
sudo update-rc.d pulseaudio-speaker-service-* remove
sudo update-rc.d pulseaudio remove
sudo systemctl daemon-reload


echo "############################################################################"
echo "# Remove packages and dependencies"
echo "############################################################################"
sudo apt-get -y remove pulseaudio pulseaudio-module-bluetooth bluez bluez-firmware

echo "############################################################################"
echo "# Remove all plugin configuration files"
echo "############################################################################"
sudo rm -Rf /etc/dbus-1/system.d/pulseaudio-bluetooth.conf
sudo rm -Rf /etc/pulse/system.pa
sudo rm -Rf /etc/systemd/system/pulseaudio.service
sudo rm -Rf /etc/init.d/pulseaudio-speaker-service-*
sudo rm -Rf /etc/systemd/system/pulseaudio.service

sudo rm -Rf /tmp/pulseaudio_dep

echo "########### Fin ##########"
