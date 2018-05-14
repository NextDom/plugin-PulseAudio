#!/bin/bash
if [[ $EUID -ne 0 ]]; then
  sudo_prefix=sudo;
fi
echo "########### Arrêt du service ##########"
$sudo_prefix systemctl stop pulseaudio.service
echo "########### Fin ##########"
