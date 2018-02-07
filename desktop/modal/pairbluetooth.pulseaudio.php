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
<div class="container-modal">
	<div class="stepwizard col-md-offset-3">
	    <div class="stepwizard-row setup-panel">
	      <div class="stepwizard-step">
	        <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
	        <p>{{Étape 1}}</p>
	      </div>
	      <div class="stepwizard-step">
	        <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
	        <p>{{Étape 2}}</p>
	      </div>
	      <div class="stepwizard-step">
	        <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
	        <p>{{Étape 3}}</p>
	      </div>
				<div class="stepwizard-step">
	        <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
	        <p>{{Étape 4}}</p>
	      </div>
				<div class="stepwizard-step">
	        <a href="#step-5" type="button" class="btn btn-default btn-circle" disabled="disabled">5</a>
	        <p>{{Étape 5}}</p>
	      </div>
	    </div>
	  </div>

	  <form role="form" action="" method="post">
	    <div class="row setup-content" id="step-1">
      	<div class="col-xs-6 col-md-offset-3">
	        <div class="col-md-12">
	          <h3>{{Activer le mode découverte de l'enceinte Bluetooth}}</h3>
						<div class="form-group">
							<center><label class="control-label">{{Exemple JBL Flip 3}}</label></center>
							<center><img src="plugins/pulseaudio/doc/images/jbl-flip-3-pairing.jpg" height="400" width="750" /></center>
						</div>
	          <button id="toStep2" class="btn btn-primary nextBtn btn-lg pull-right" type="button" >{{Suivant}}</button>
	        </div>
				</div>
	    </div>
			<div class="row setup-content" id="step-2">
      	<div class="col-xs-6 col-md-offset-3">
					<div class="col-md-12">
						<h3>{{Scanner les périphériques Bluetooth}}</h3>
						<div id='div_scanbluetoothpulseaudioAlert' style="display: none;"></div>
						<a class="btn btn-warning pull-right" data-state="1" id="bt_scanbluetoothpulseaudioStopStart"><i class="fa fa-pause"></i> {{Pause}}</a>
						<input class="form-control pull-right" id="in_scanbluetoothpulseaudioSearch" style="width : 300px;" placeholder="{{Rechercher}}" />
						<br/><br/><br/>
						<pre id='pre_scanbluetoothpulseaudio' style='overflow: auto; height: 90%;with:90%;'></pre>
						<div class="progress" id="step2scanProgress">
					    <div id="step2scanProgressBar" class="progress-bar" role="progressbar">
					      <center><span id="step2scanText">{{Scan en cours}}</span></center>
					    </div>
					  </div>
						<div class="form-group">
							<label class="control-label">{{Adresse MAC}}</label>
							<input id="mac_address_found" type="text" required="required" class="form-control" placeholder="00:00:00:00:00:00" />
						</div>
						<button id="toStep3" disabled="true" class="btn btn-primary nextBtn btn-lg pull-right" type="button" >{{Suivant}}</button>
					</div>
				</div>
			</div>
	    <div class="row setup-content" id="step-3">
      	<div class="col-xs-6 col-md-offset-3">
	        <div class="col-md-12">
	          <h3>{{Appairer l'enceinte Bluetooth}}</h3>
						<div id='div_pairbluetoothpulseaudioAlert' style="display: none;"></div>
						<a class="btn btn-warning pull-right" data-state="1" id="bt_pairbluetoothpulseaudioStopStart"><i class="fa fa-pause"></i> {{Pause}}</a>
						<input class="form-control pull-right" id="in_pairbluetoothpulseaudioSearch" style="width : 300px;" placeholder="{{Rechercher}}" />
						<br/><br/><br/>
						<pre id='pre_pairbluetoothpulseaudio' style='overflow: auto; height: 90%;with:90%;'></pre>
						<div class="progress" id="step3scanProgress">
					    <div id="step3scanProgressBar" class="progress-bar" role="progressbar">
					      <center><span id="step3scanText">{{Appairage en cours}}</span></center>
					    </div>
					  </div>

	          <button id="toStep4" disabled="true" class="btn btn-primary nextBtn btn-lg pull-right" type="button" >{{Suivant}}</button>
	        </div>
				</div>
	    </div>
	    <div class="row setup-content" id="step-4">
      	<div class="col-xs-6 col-md-offset-3">
	        <div class="col-md-12">
	          <h3>{{Créer le service associé à cette enceinte Bluetooth}}</h3>
						<div class="form-group">
							<label class="control-label">{{Nom du service}}</label>
							<input id="service_name_found" type="text" required="required" class="form-control" />
						</div>
						<button id="toStep5" class="btn btn-primary nextBtn btn-lg pull-right" type="button" >{{Suivant}}</button>
	        </div>
				</div>
	    </div>
			<div class="row setup-content" id="step-5">
      	<div class="col-xs-6 col-md-offset-3">
	        <div class="col-md-12">
	          <h3>{{Finaliser la création de votre enceinte Bluetooth}}</h3>
	          <center>{{Vous pouvez clore cette popup puis activer et enregistrer cette nouvelle enceinte Bluetooth.}}</center>
						<center><label class="control-label">{{JBL Flip 3}}</label></center>
						<center><img src="plugins/pulseaudio/doc/images/jbl-flip-3.jpg" height="400" width="750" /></center>
	        </div>
				</div>
	    </div>
	  </form>
	</div>

<script>
	$(document).ready(function () {
	  var navListItems = $('div.setup-panel div a'),
	          allWells = $('.setup-content'),
	          allNextBtn = $('.nextBtn');

	  allWells.hide();

	  navListItems.click(function (e) {
	      e.preventDefault();
	      var $target = $($(this).attr('href')),
	              $item = $(this);

	      if (!$item.hasClass('disabled')) {
	          navListItems.removeClass('btn-primary').addClass('btn-default');
	          $item.addClass('btn-primary');
	          allWells.hide();
	          $target.show();
	          $target.find('input:eq(0)').focus();
	      }
	  });

	  allNextBtn.click(function(){
	      var curStep = $(this).closest(".setup-content"),
	          curStepBtn = curStep.attr("id"),
	          nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
	          curInputs = curStep.find("input[type='text'],input[type='url']"),
	          isValid = true;

	      $(".form-group").removeClass("has-error");
	      for(var i=0; i<curInputs.length; i++){
	          if (!curInputs[i].validity.valid){
	              isValid = false;
	              $(curInputs[i]).closest(".form-group").addClass("has-error");
	          }
	      }

	      if (isValid)
	          nextStepWizard.removeAttr('disabled').trigger('click');
	  });

	  $('div.setup-panel div a.btn-primary').trigger('click');
	});
	$("#toStep2").click(function(){
			document.getElementById('mac_address_found').value = document.getElementById('mac_address').value;
			document.getElementById('service_name_found').value = document.getElementById('service_name').value;
			$.ajax({
				type: 'POST',
				url: 'plugins/pulseaudio/core/ajax/pulseaudio.ajax.php',
				data: {
					action: 'scanbluetoothpulseaudio'
				},
				dataType: 'json',
				global: false,
				error: function (request, log, error) {
					handleAjaxError(request, log, error, $('#div_scanbluetoothpulseaudioAlert'));
				},
				success: function () {
					 jeedom.log.autoupdate({
								 log : 'pulseaudio_scanbluetooth',
								 display : $('#pre_scanbluetoothpulseaudio'),
								 search : $('#in_scanbluetoothpulseaudioSearch'),
								 control : $('#bt_scanbluetoothpulseaudioStopStart'),
									});
				}
			});
			var timerId = 0;
		  var ctr=0;
		  var max=30;

		  timerId = setInterval(function () {
		    // interval function
		    ctr++;
		    $('#step2scanProgress > .progress-bar').attr("style","width:" + ctr*6.3 + "%");
		    // max reached?
		    if (ctr*6.3 > 100){
		      clearInterval(timerId);
					$('#step2scanText').text("Scan terminé");
					$('#step2scanText').attr("style","color:white;");
					$('#step2scanProgress > .progress-bar').attr("style","width:100%;");
					$('#step2scanProgressBar').removeClass('progress-bar').addClass('progress-bar-success');
					$('#toStep3').prop('disabled', false);
		    }
		  }, 1000);
	});
	$("#toStep3").click(function(){
			clearInterval(timerId);
	    $.ajax({
				type: 'POST',
				url: 'plugins/pulseaudio/core/ajax/pulseaudio.ajax.php',
				data: {
					action: 'pairbluetoothpulseaudio',
					macAddress: document.getElementById('mac_address_found').value
				},
				dataType: 'json',
				global: false,
				error: function (request, log, error) {
					handleAjaxError(request, log, error, $('#div_pairbluetoothpulseaudioAlert'));
				},
				success: function () {
					 jeedom.log.autoupdate({
					       log : 'pulseaudio_pairbluetooth',
					       display : $('#pre_pairbluetoothpulseaudio'),
					       search : $('#in_pairbluetoothpulseaudioSearch'),
					       control : $('#bt_pairbluetoothpulseaudioStopStart'),
		           		});
				}
		});
		var timerId = 0;
		var ctr=0;
		var max=30;

		timerId = setInterval(function () {
			// interval function
			ctr++;
			$('#step3scanProgress > .progress-bar').attr("style","width:" + ctr*3 + "%");
			// max reached?
			if (ctr*3 > 100){
				clearInterval(timerId);
				$('#step3scanText').text("Appairage terminé");
				$('#step3scanText').attr("style","color:white;");
				$('#step3scanProgress > .progress-bar').attr("style","width:100%;");
				$('#step3scanProgressBar').removeClass('progress-bar').addClass('progress-bar-success');
				$('#toStep4').prop('disabled', false);
			}
		}, 1000);
	});
	$("#toStep4").click(function(){
			document.getElementById('mac_address').value = document.getElementById('mac_address_found').value;
	});
	$("#toStep5").click(function(){
			document.getElementById('service_name').value = document.getElementById('service_name_found').value;
	});

</script>
<style type="text/css">
body {
    margin-top:40px;
}
.stepwizard-step p {
    margin-top: 10px;
}
.stepwizard-row {
    display: table-row;
}
.stepwizard {
    display: table;
    width: 50%;
    position: relative;
}
.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}
.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;
}
.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}
.btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
}
</style>
