#!/bin/bash
if [[ $EUID -ne 0 ]]; then
  sudo_prefix=sudo;
fi
echo "########### Etat du service ##########"
echo `$sudo_prefix systemctl -l status pulseaudio.service`
echo "########### Fin ##########"
