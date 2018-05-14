#!/bin/bash
if [[ $EUID -ne 0 ]]; then
  sudo_prefix=sudo;
fi
echo "########### Lancement du service ##########"
$sudo_prefix systemctl start pulseaudio.service
echo "########### Fin ##########"
