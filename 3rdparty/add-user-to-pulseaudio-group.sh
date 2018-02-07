#!/bin/bash
echo "########### Add user $1 to pulseaudio group ##########"
sudo adduser $1 pulse-access
echo "########### End ##########"
