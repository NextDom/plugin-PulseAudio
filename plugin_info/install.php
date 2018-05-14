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
function PulseAudio_install() {
/*
    $cron = cron::byClassAndFunction('PulseAudio', 'pull');
    if (!is_object($cron)) {
        $cron = new cron();
        $cron->setClass('PulseAudio');
        $cron->setFunction('pull');
        $cron->setEnable(1);
        $cron->setDeamon(0);*/
      //  $cron->setSchedule('*/5 * * * *');
      /*  $cron->save();
    }
    */
}

function PulseAudio_update() {
  exec('../3rdparty/reset.sh');
  /*  $cron = cron::byClassAndFunction('PulseAudio', 'pull');
    if (!is_object($cron)) {
        $cron = new cron();
        $cron->setClass('PulseAudio');
        $cron->setFunction('pull');
        $cron->setEnable(1);
        $cron->setDeamon(0); */
      //  $cron->setSchedule('*/5 * * * *');
      /*  $cron->save();
    }
    $cron->stop(); */
}

function PulseAudio_remove() {
  exec('../3rdparty/reset.sh');
  exec('../3rdparty/remove.sh');
  log::remove('PulseAudio_update');
  log::remove('PulseAudio_scanbluetooth');
  log::remove('PulseAudio_status');
  log::remove('PulseAudio_delete');
  log::remove('PulseAudio_log');
  log::remove('PulseAudio_create');
  log::remove('PulseAudio_delete');
  log::remove('PulseAudio_disable');
  log::remove('PulseAudio_connect');
  log::remove('PulseAudio_disconnect');
  log::remove('PulseAudio_soundtest');
  log::remove('PulseAudio_dep');
  /*  $cron = cron::byClassAndFunction('PulseAudio', 'pull');
    if (is_object($cron)) {
        $cron->remove();
    }
    */
}
?>
