#!/bin/bash
echo "########### Etat du service $1 ##########"
echo `systemctl -l status bluetooth.service`
echo "########### Fin ##########"
