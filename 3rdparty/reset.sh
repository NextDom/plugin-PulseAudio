#!/bin/bash
echo "########### Reset ##########"
echo Arrêt des services en cours :
echo `ls /etc/init.d/pulseaudio-speaker-service-*`
echo `sudo service pulseaudio-speaker-service-* stop`
echo `sudo service pulseaudio-speaker-service-* status`

# echo PPID supprimés :
# echo `ps -afe | grep avconv | awk '{print $3}'`
# sudo kill -9 `ps -afe | grep avconv | grep rtsp | awk '{print $3}'`
#
# echo PID supprimés :
# echo `ps aux | grep avconv | awk '{print $2}'`
# sudo kill -9 `ps aux | grep avconv | grep rtsp | awk '{print $2}'`
#
echo Pensez à activer à nouveau vos services
echo en sauvegardant les configurations que vous souhaitez relancer parmi :
echo `ls /etc/init.d/pulseaudio-speaker-service-*`

# echo Services zombies, doit être vide :
# echo `ps aux | grep avconv | grep rtsp`

echo "########### Fin ##########"
