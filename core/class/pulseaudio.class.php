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

class pulseaudio extends eqLogic
{

  public static function pull($_eqLogic_id = null)
  {
    if (self::$_eqLogics === null) {
      self::$_eqLogics = self::byType('pulseaudio');
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
    $return['log']           = 'pulseaudio_dep';
    $return['progress_file'] = '/tmp/pulseaudio_dep';
    $pactl                   = '/usr/bin/pactl';
    $return['progress_file'] = '/tmp/pulseaudio_dep';
    if (is_file($pactl)) {
      $return['state'] = 'ok';
    } else {
      // if (!is_file($pactl)) {
      // 	exec('echo PulsAudio binary dependency not found : '. $pactl . ' > ' . log::getPathToLog('pulseaudio_log') . ' 2>&1 &');
      // }
      $return['state'] = 'nok';
    }
    return $return;
  }

  public static function dependancy_install()
  {
    log::add('pulseaudio', 'info', 'Installation des dépéndances pulseaudio');
    $resource_path = realpath(dirname(__FILE__) . '/../../3rdparty');
    passthru('/bin/bash ' . $resource_path . '/install.sh ' . $resource_path . ' > ' . log::getPathToLog('pulseaudio_dep') . ' 2>&1 &');
  }

  /*     * ***********************Methode static*************************** */

  public static function updatepulseaudio()
  {
    log::remove('pulseaudio_update');
    $cmd = '/bin/bash ' . dirname(__FILE__) . '/../../3rdparty/install.sh';
    $cmd .= ' >> ' . log::getPathToLog('pulseaudio_update') . ' 2>&1 &';
    exec($cmd);
  }

  public static function scanbluetoothpulseaudio()
  {
    $sudo_prefix = self::usingSudo();
    log::remove('pulseaudio_scanbluetooth');
    $port = config::byKey('port', 'pulseaudio', 0);
    $cmd  = $sudo_prefix . 'expect ' . dirname(__FILE__) . '/../../3rdparty/bluetooth-scan.sh ' . $port;
    $cmd  .= ' >> ' . log::getPathToLog('pulseaudio_scanbluetooth') . ' 2>&1 &';
    exec($cmd);
  }

  public static function pairbluetoothpulseaudio($macAddress)
  {
    $sudo_prefix = self::usingSudo();
    log::remove('pulseaudio_pairbluetooth');
    $port = config::byKey('port', 'pulseaudio', 0);
    $cmd  = $sudo_prefix . 'expect ' . dirname(__FILE__) . '/../../3rdparty/bluetooth-pair-trust.sh ' . $port . ' ' . $macAddress;
    $cmd  .= ' >> ' . log::getPathToLog('pulseaudio_pairbluetooth') . ' 2>&1 &';
    exec($cmd);
  }

  public static function statuspulseaudio($serviceName)
  {
    $sudo_prefix = self::usingSudo();
    log::remove('pulseaudio_status-' . $serviceName);
    $cmd = $sudo_prefix . 'systemctl -l status pulseaudio-speaker-service-' . $serviceName . '.service';
    $cmd .= ' >> ' . log::getPathToLog('pulseaudio_status-' . $serviceName) . ' 2>&1 &';
    exec($cmd);
  }

  // public static function statuspulseaudiobluetooth($serviceName) {
  // 	log::remove('pulseaudio_status');
  // 	$cmd = '/bin/bash ' .dirname(__FILE__) . '/../../3rdparty/bluetooth-status.sh ' . $serviceName;
  // 	$cmd .= ' >> ' . log::getPathToLog('pulseaudio_status') . ' 2>&1 &';
  // 	exec($cmd);
  // }
  public static function logpulseaudio($serviceName, $folderLog)
  {
    log::remove('pulseaudio_log');
    $cmd = '/bin/bash ' . dirname(__FILE__) . '/../../3rdparty/log.sh ' . $serviceName . ' ' . $folderLog;
    $cmd .= ' >> ' . log::getPathToLog('pulseaudio_log') . ' 2>&1 &';
    exec($cmd);
  }

  public static function soundtestpulseaudio()
  {
    log::remove('pulseaudio_soundtest');
    $cmd = 'mplayer -ao pulse ' . dirname(__FILE__) . '/../../3rdparty/Esther_Garcia_-_A_Beautiful_Day.mp3';
    $cmd .= ' >> ' . log::getPathToLog('pulseaudio_soundtest') . ' 2>&1 & echo $! > ' . dirname(__FILE__) . '/../../pulseaudio_soundtest.pid';
    exec($cmd);
  }

  public static function stopsoundtestpulseaudio($pid)
  {
    $sudo_prefix = self::usingSudo();
    log::remove('pulseaudio_soundtest');
    $cmd = $sudo_prefix . 'kill -9 `cat ' . dirname(__FILE__) . '/../../pulseaudio_soundtest.pid`';
    $cmd .= '; echo `cat ' . dirname(__FILE__) . '/../../pulseaudio_soundtest.pid` killed >> ' . log::getPathToLog('pulseaudio_soundtest') . ' 2>&1 &';
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
        exec('echo Remove Service Name : ' . $this->getConfiguration('lastName') . ' >> ' . log::getPathToLog('pulseaudio_disable') . ' 2>&1 &');
        $cmd = '/bin/bash ' . $sudo_prefix . dirname(__FILE__) . '/../../3rdparty/disable.sh ' . $this->getConfiguration('lastName');
        $cmd .= ' >> ' . log::getPathToLog('pulseaudio_disable') . ' 2>&1 &';
        exec($cmd);
        sleep(2);
        $this->setConfiguration('lastName', $this->getConfiguration('name'));
        exec('echo Setting Last Service Name : ' . $this->getConfiguration('lastName') . ' >> ' . log::getPathToLog('pulseaudio_delete') . ' 2>&1 &');
      }
    } else {
      $this->setConfiguration('created', false);
    }
    $this->setConfiguration('serviceName', $this->getConfiguration('name'));
  }

  public function postSave()
  {
    foreach (eqLogic::byType('pulseaudio') as $pulseaudio) {
      $pulseaudio->getInformations();
    }
    $sudo_prefix = self::usingSudo();
    $port = config::byKey('port', 'pulseaudio', 0);
    if ($this->getConfiguration('created') == false) {
      $cmd = '/bin/bash ' . $sudo_prefix . dirname(__FILE__) . '/../../3rdparty/create.sh ' . $this->getConfiguration('name') . ' ' . $port . ' ' . $this->getConfiguration('address');
      $cmd .= ' >> ' . log::getPathToLog('pulseaudio_create') . ' 2>&1 &';
      exec('echo Create/Update Service Name : ' . $this->getConfiguration('name') . ' Address : ' . $this->getConfiguration('address') . ' >> ' . log::getPathToLog('pulseaudio_create') . ' 2>&1 &');
      exec($cmd);
    }
    if ($this->getIsEnable()) {
      $cmd = $sudo_prefix . ' /etc/init.d/pulseaudio-speaker-service-' . $this->getConfiguration('name') . ' start ';
      $cmd .= ' >> ' . log::getPathToLog('pulseaudio_connect') . ' 2>&1 &';
      exec('echo Connecting : ' . $this->getConfiguration('name') . ' Address : ' . $this->getConfiguration('address') . ' >> ' . log::getPathToLog('pulseaudio_connect') . ' 2>&1 &');
      exec($cmd);
    } else {
      $cmd = $sudo_prefix . '/etc/init.d/pulseaudio-speaker-service-' . $this->getConfiguration('name') . ' stop ';
      $cmd .= ' >> ' . log::getPathToLog('pulseaudio_disconnect') . ' 2>&1 &';
      exec('echo Disconnecting : ' . $this->getConfiguration('name') . ' Address : ' . $this->getConfiguration('address') . ' >> ' . log::getPathToLog('pulseaudio_disconnect') . ' 2>&1 &');
      exec($cmd);
    }
  }

  public function preRemove()
  {

    log::remove('pulseaudio_status-' . $serviceName);
    $sudo_prefix = self::usingSudo();
    $port = config::byKey('port', 'pulseaudio', 0);
    $cmd  = '/bin/bash ' . $sudo_prefix . dirname(__FILE__) . '/../../3rdparty/delete.sh ' . $this->getConfiguration('name') . ' ' . $port . ' ' . $this->getConfiguration('address');
    $cmd  .= ' >> ' . log::getPathToLog('pulseaudio_delete') . ' 2>&1 &';
    exec('echo Delete Service Name : ' . $this->getConfiguration('name') . ' >> ' . log::getPathToLog('pulseaudio_delete') . ' 2>&1 &');
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

class pulseaudioCmd extends cmd
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
