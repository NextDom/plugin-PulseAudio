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

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class PulseAudio extends eqLogic
{

  public static function pull($_eqLogic_id = null)
  {
    if (self::$_eqLogics === null) {
      self::$_eqLogics = self::byType('PulseAudio');
    }
  }
  public static function usingSudo(){
    $sudo = exec("\$EUID");
    if ($sudo != "0") {
      return "sudo ";
    }
    return "";
  }

  public static function dependancy_info()
  {
    $return                  = array();
    $return['log']           = 'PulseAudio_dep';
    $return['progress_file'] = '/tmp/PulseAudio_dep';
    $pactl                   = '/usr/bin/pactl';
    $return['progress_file'] = '/tmp/PulseAudio_dep';
    if (is_file($pactl)) {
      $return['state'] = 'ok';
    } else {
      // if (!is_file($pactl)) {
      // 	exec('echo PulsAudio binary dependency not found : '. $pactl . ' > ' . log::getPathToLog('PulseAudio_log') . ' 2>&1 &');
      // }
      $return['state'] = 'nok';
    }
    return $return;
  }

  public static function dependancy_install()
  {
    log::add('PulseAudio', 'info', 'Installation des dépéndances PulseAudio');
    $resource_path = realpath(dirname(__FILE__) . '/../../3rdparty');
    passthru('/bin/bash ' . $resource_path . '/install.sh ' . $resource_path . ' > ' . log::getPathToLog('PulseAudio_dep') . ' 2>&1 &');
  }

  /*     * ***********************Methode static*************************** */

  public static function updatePulseAudio()
  {
    log::remove('PulseAudio_update');
    $cmd = '/bin/bash ' . dirname(__FILE__) . '/../../3rdparty/install.sh';
    $cmd .= ' >> ' . log::getPathToLog('PulseAudio_update') . ' 2>&1 &';
    exec($cmd);
  }

  public static function scanbluetoothPulseAudio()
  {
    $sudo_prefix = self::usingSudo();
    log::remove('PulseAudio_scanbluetooth');
    $port = config::byKey('port', 'PulseAudio', 0);
    $cmd  = $sudo_prefix . 'expect ' . dirname(__FILE__) . '/../../3rdparty/bluetooth-scan.sh ' . $port;
    $cmd  .= ' >> ' . log::getPathToLog('PulseAudio_scanbluetooth') . ' 2>&1 &';
    exec($cmd);
  }

  public static function pairbluetoothPulseAudio($macAddress)
  {
    $sudo_prefix = self::usingSudo();
    log::remove('PulseAudio_pairbluetooth');
    $port = config::byKey('port', 'PulseAudio', 0);
    $cmd  = $sudo_prefix . 'expect ' . dirname(__FILE__) . '/../../3rdparty/bluetooth-pair-trust.sh ' . $port . ' ' . $macAddress;
    $cmd  .= ' >> ' . log::getPathToLog('PulseAudio_pairbluetooth') . ' 2>&1 &';
    exec($cmd);
  }

  public static function statusPulseAudio($serviceName)
  {
    $sudo_prefix = self::usingSudo();
    log::remove('PulseAudio_status-' . $serviceName);
    $cmd = $sudo_prefix . 'systemctl -l status pulseaudio-speaker-service-' . $serviceName . '.service';
    $cmd .= ' >> ' . log::getPathToLog('PulseAudio_status-' . $serviceName) . ' 2>&1 &';
    exec($cmd);
  }

  // public static function statusPulseAudiobluetooth($serviceName) {
  // 	log::remove('PulseAudio_status');
  // 	$cmd = '/bin/bash ' .dirname(__FILE__) . '/../../3rdparty/bluetooth-status.sh ' . $serviceName;
  // 	$cmd .= ' >> ' . log::getPathToLog('PulseAudio_status') . ' 2>&1 &';
  // 	exec($cmd);
  // }
  public static function logPulseAudio($serviceName, $folderLog)
  {
    log::remove('PulseAudio_log');
    $cmd = '/bin/bash ' . dirname(__FILE__) . '/../../3rdparty/log.sh ' . $serviceName . ' ' . $folderLog;
    $cmd .= ' >> ' . log::getPathToLog('PulseAudio_log') . ' 2>&1 &';
    exec($cmd);
  }

  public static function soundtestPulseAudio()
  {
    log::remove('PulseAudio_soundtest');
    $cmd = 'mplayer -ao pulse ' . dirname(__FILE__) . '/../../3rdparty/Esther_Garcia_-_A_Beautiful_Day.mp3';
    $cmd .= ' >> ' . log::getPathToLog('PulseAudio_soundtest') . ' 2>&1 & echo $! > ' . dirname(__FILE__) . '/../../PulseAudio_soundtest.pid';
    exec($cmd);
  }

  public static function stopsoundtestPulseAudio($pid)
  {
    $sudo_prefix = self::usingSudo();
    log::remove('PulseAudio_soundtest');
    $cmd = $sudo_prefix . 'kill -9 `cat ' . dirname(__FILE__) . '/../../pulseaudio_soundtest.pid`';
    $cmd .= '; echo `cat ' . dirname(__FILE__) . '/../../pulseaudio_soundtest.pid` killed >> ' . log::getPathToLog('PulseAudio_soundtest') . ' 2>&1 &';
    exec($cmd);
    $cmd = 'rm ' . dirname(__FILE__) . '/../../pulseaudio_soundtest.pid';
    exec($cmd);
  }

  public function preUpdate()
  {
    if ($this->getConfiguration('address') == '') {
      throw new \Exception(__('Le champs Adresse ne peut être vide', __FILE__));
    }
    if (!preg_match("#^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})#", $this->getConfiguration('address'))) {
      throw new \Exception(__('L\'adresse MAC doit être de la forme XX:XX:XX:XX:XX:XX', __FILE__));
    }
    if ($this->getConfiguration('name') === '') {
      throw new \Exception(__('Le champs Nom ne peut être vide', __FILE__));
    }
    // Si la chaîne contient des caractères spéciaux
    if (!preg_match("#[a-zA-Z0-9_-]$#", $this->getConfiguration('name'))) {
      throw new \Exception(__('Le champs Nom ne peut contenir de caractères spéciaux', __FILE__));
    }
    // Si la chaîne contient des caractères spéciaux
    if (preg_match("/\\s/", $this->getConfiguration('name'))) {
      throw new \Exception(__('Le champs Nom ne peut contenir d\'espaces', __FILE__));
    }
  }

  public function preSave()
  {
    $sudo_prefix = self::usingSudo();
    if (!$this->getConfiguration('lastName') == '') {
      $this->setConfiguration('created', true);
      if ($this->getConfiguration('name') !== $this->getConfiguration('lastName')) {
        exec('echo Remove Service Name : ' . $this->getConfiguration('lastName') . ' >> ' . log::getPathToLog('PulseAudio_disable') . ' 2>&1 &');
        $cmd = '/bin/bash ' . $sudo_prefix . dirname(__FILE__) . '/../../3rdparty/disable.sh ' . $this->getConfiguration('lastName');
        $cmd .= ' >> ' . log::getPathToLog('PulseAudio_disable') . ' 2>&1 &';
        exec($cmd);
        sleep(2);
        $this->setConfiguration('lastName', $this->getConfiguration('name'));
        exec('echo Setting Last Service Name : ' . $this->getConfiguration('lastName') . ' >> ' . log::getPathToLog('PulseAudio_delete') . ' 2>&1 &');
      }
    } else {
      $this->setConfiguration('created', false);
    }
    $this->setConfiguration('serviceName', $this->getConfiguration('name'));
  }

  public function postSave()
  {
    foreach (eqLogic::byType('PulseAudio') as $PulseAudio) {
      $PulseAudio->getInformations();
    }
    $sudo_prefix = self::usingSudo();
    $port = config::byKey('port', 'PulseAudio', 0);
    if ($this->getConfiguration('created') == false) {
      $cmd = '/bin/bash ' . $sudo_prefix . dirname(__FILE__) . '/../../3rdparty/create.sh ' . $this->getConfiguration('name') . ' ' . $port . ' ' . $this->getConfiguration('address');
      $cmd .= ' >> ' . log::getPathToLog('PulseAudio_create') . ' 2>&1 &';
      exec('echo Create/Update Service Name : ' . $this->getConfiguration('name') . ' Address : ' . $this->getConfiguration('address') . ' >> ' . log::getPathToLog('PulseAudio_create') . ' 2>&1 &');
      exec($cmd);
    }
    if ($this->getIsEnable()) {
      $cmd = $sudo_prefix . ' /etc/init.d/pulseaudio-speaker-service-' . $this->getConfiguration('name') . ' start ';
      $cmd .= ' >> ' . log::getPathToLog('PulseAudio_connect') . ' 2>&1 &';
      exec('echo Connecting : ' . $this->getConfiguration('name') . ' Address : ' . $this->getConfiguration('address') . ' >> ' . log::getPathToLog('PulseAudio_connect') . ' 2>&1 &');
      exec($cmd);
    } else {
      $cmd = $sudo_prefix . '/etc/init.d/pulseaudio-speaker-service-' . $this->getConfiguration('name') . ' stop ';
      $cmd .= ' >> ' . log::getPathToLog('PulseAudio_disconnect') . ' 2>&1 &';
      exec('echo Disconnecting : ' . $this->getConfiguration('name') . ' Address : ' . $this->getConfiguration('address') . ' >> ' . log::getPathToLog('PulseAudio_disconnect') . ' 2>&1 &');
      exec($cmd);
    }
  }

  public function preRemove()
  {

    log::remove('PulseAudio_status-' . $serviceName);
    $sudo_prefix = self::usingSudo();
    $port = config::byKey('port', 'PulseAudio', 0);
    $cmd  = '/bin/bash ' . $sudo_prefix . dirname(__FILE__) . '/../../3rdparty/delete.sh ' . $this->getConfiguration('name') . ' ' . $port . ' ' . $this->getConfiguration('address');
    $cmd  .= ' >> ' . log::getPathToLog('PulseAudio_delete') . ' 2>&1 &';
    exec('echo Delete Service Name : ' . $this->getConfiguration('name') . ' >> ' . log::getPathToLog('PulseAudio_delete') . ' 2>&1 &');
    exec($cmd);
  }

  public function getInformations()
  {

    $sudo_prefix = self::usingSudo();
    foreach ($this->getCmd() as $cmd) {

      $name    = $this->getConfiguration('name');
      $state = exec($sudo_prefix . "/etc/init.d/pulseaudio-speaker-service-$name status");

      $cmd->event($state);
    }
    if (is_object($state)) {
      return $state;
    } else {
      return '';
    }
  }

}

class PulseAudioCmd extends cmd
{
  /*     * *********************Methode d'instance************************* */

  public function execute($_options = null)
  {
    $name    = $this->getConfiguration('name');

    $sudo_prefix = self::usingSudo();
    $state = exec($sudo_prefix . "/etc/init.d/pulseaudio-speaker-service-$name status");

    $cmd->event($state);
    if (is_object($state)) {
      return $state;
    } else {
      return '';
    }
  }

}
