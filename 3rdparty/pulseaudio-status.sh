#!/bin/bash
echo "########### Etat du service ##########"
echo `systemctl -l status pulseaudio.service`
echo "########### Fin ##########"
