#!/bin/bash
echo "########### Logs du service $1 ##########"
echo `sudo cat $2/$1.log`
echo "########### Fin ##########"
