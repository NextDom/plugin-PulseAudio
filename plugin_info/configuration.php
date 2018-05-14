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
include_file('core', 'authentification', 'php');
if (!isConnect()) {
    include_file('desktop', '404', 'php');
    die();
}
?>


<form class="form-horizontal">
  <div class="panel panel-info" style="height: 100%;">
      <div class="panel-heading" role="tab">
          <h4 class="panel-title">
              Plugin PulseAudio
          </h4>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">{{Configuration :}}</label>
        <div class="col-lg-4">
          <a class="btn btn-info" href=/index.php?v=d&m=PulseAudio&p=PulseAudio> {{Accès à la configuration}}</a>
        </div>
        <!-- <label class="col-sm-2 control-label">{{Réparer :}}</label>
  			<div class="col-sm-4">
  				<a class="btn btn-danger" id="bt_resetPulseAudio"><i class="fa fa-check"></i> {{Forcer l'arrêt de tous les services PulseAudio}}</a>
  			</div> -->
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">{{Port clef bluetooth}}</label>
        <div class="col-sm-2">
          <select class="configKey form-control" data-l1key="port">
            <option value="none">{{Aucun}}</option>
            <?php
            foreach (jeedom::getBluetoothMapping() as $name => $value) {
              echo '<option value="' . $name . '">' . $name . ' (' . $value . ')</option>';
            }
            ?>
          </select>
        </div>
      </div>
  </div>
  <div class="panel panel-info" style="height: 100%;">
      <div class="panel-heading" role="tab">
          <h4 class="panel-title">
              Service PulseAudio via PaWebControl
          </h4>
      </div>
      <iframe frameborder="0" height="90%" width="100%" src="plugins/PulseAudio/PaWebControl/index.html"/>
  </div>
</form>
