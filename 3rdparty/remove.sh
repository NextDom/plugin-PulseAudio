#!/bin/bash
if [[ $EUID -ne 0 ]]; then
  sudo_prefix=sudo;
fi
echo "########### Suppression en cours ##########"
echo "############################################################################"
echo "# Removing all pulseaudio-speaker-service"
echo "############################################################################"
$sudo_prefix service pulseaudio-speaker-service-* stop
$sudo_prefix service pulseaudio stop
$sudo_prefix update-rc.d pulseaudio-speaker-service-* remove
$sudo_prefix update-rc.d pulseaudio remove
$sudo_prefix systemctl daemon-reload


echo "############################################################################"
echo "# Remove packages and dependencies"
echo "############################################################################"
$sudo_prefix apt-get -y remove pulseaudio pulseaudio-module-bluetooth bluez bluez-firmware

echo "############################################################################"
echo "# Remove all plugin configuration files"
echo "############################################################################"
$sudo_prefix rm -Rf /etc/dbus-1/system.d/pulseaudio-bluetooth.conf
$sudo_prefix rm -Rf /etc/pulse/system.pa
$sudo_prefix rm -Rf /etc/systemd/system/pulseaudio.service
$sudo_prefix rm -Rf /etc/init.d/pulseaudio-speaker-service-*
$sudo_prefix rm -Rf /etc/systemd/system/pulseaudio.service

$sudo_prefix rm -Rf /tmp/pulseaudio_dep

echo "########### Fin ##########"
