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
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>
<div id='div_soundtestpulseaudioAlert' style="display: none;"></div>
<a class="btn btn-stop pull-right"  id="bt_stopsoundTest"><i class="fa fa-stop"></i> {{Arrêter le test}}</a>
<a class="btn btn-warning pull-right" data-state="1" id="bt_pulseaudioSoundtestStopStart"><i class="fa fa-pause"></i> {{Pause}}</a>
<input class="form-control pull-right" id="in_pulseaudioSoundtestSearch" style="width : 300px;" placeholder="{{Rechercher}}" />
<br/><br/><br/>
<pre id='pre_pulseaudiosoundtest' style='overflow: auto; height: 90%;with:90%;'></pre>


<script>

	$.ajax({
		type: 'POST',
		url: 'plugins/pulseaudio/core/ajax/pulseaudio.ajax.php',
		data: {
			action: 'soundtestpulseaudio'
		},
		dataType: 'json',
		global: false,
		error: function (request, log, error) {
			handleAjaxError(request, log, error, $('#div_soundtestpulseaudioAlert'));
		},
		success: function () {
			 jeedom.log.autoupdate({
			       log : 'pulseaudio_soundtest',
			       display : $('#pre_pulseaudiosoundtest'),
			       search : $('#in_pulseaudioSoundtestSearch'),
			       control : $('#bt_pulseaudioSoundtestStopStart'),
           		});
		}
	});

	$("#bt_stopsoundTest").click(function(){
		// var pidSoundTest = $("#pidSoundTest").text();
		$.ajax({
			type: 'POST',
			url: 'plugins/pulseaudio/core/ajax/pulseaudio.ajax.php',
			data: {
				action: 'stopsoundtestpulseaudio',
				pid: $("#pidSoundTest").text()
			},
			dataType: 'json',
			global: false
		});
	});
</script>
