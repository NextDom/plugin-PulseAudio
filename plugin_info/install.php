<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
function pulseaudio_install() {
/*
    $cron = cron::byClassAndFunction('pulseaudio', 'pull');
    if (!is_object($cron)) {
        $cron = new cron();
        $cron->setClass('pulseaudio');
        $cron->setFunction('pull');
        $cron->setEnable(1);
        $cron->setDeamon(0);*/
      //  $cron->setSchedule('*/5 * * * *');
      /*  $cron->save();
    }
    */
}

function pulseaudio_update() {
  exec('../3rdparty/reset.sh');
  /*  $cron = cron::byClassAndFunction('pulseaudio', 'pull');
    if (!is_object($cron)) {
        $cron = new cron();
        $cron->setClass('pulseaudio');
        $cron->setFunction('pull');
        $cron->setEnable(1);
        $cron->setDeamon(0); */
      //  $cron->setSchedule('*/5 * * * *');
      /*  $cron->save();
    }
    $cron->stop(); */
}

function pulseaudio_remove() {
  exec('../3rdparty/reset.sh');
  exec('../3rdparty/remove.sh');
  log::remove('pulseaudio_update');
  log::remove('pulseaudio_scanbluetooth');
  log::remove('pulseaudio_status');
  log::remove('pulseaudio_delete');
  log::remove('pulseaudio_log');
  log::remove('pulseaudio_create');
  log::remove('pulseaudio_delete');
  log::remove('pulseaudio_disable');
  log::remove('pulseaudio_connect');
  log::remove('pulseaudio_disconnect');
  log::remove('pulseaudio_soundtest');
  log::remove('pulseaudio_dep');
  /*  $cron = cron::byClassAndFunction('pulseaudio', 'pull');
    if (is_object($cron)) {
        $cron->remove();
    }
    */
}
?>
