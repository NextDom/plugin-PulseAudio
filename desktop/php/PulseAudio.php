<?php
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
sendVarToJS('eqType', 'PulseAudio');
$eqLogics = eqLogic::byType('PulseAudio');
?>

<div class="row row-overflow">
  <div class="col-lg-2 col-md-3 col-sm-4">
    <div class="bs-sidebar">
      <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
        <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter une enceinte Bluetooth}}</a>
        <li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
        <?php
foreach ($eqLogics as $eqLogic) {
    $opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
    echo '<li class="cursor li_eqLogic" data-eqLogic_id="'.$eqLogic->getId().'" style="'.$opacity.'"><a>'.$eqLogic->getHumanName(true).'</a></li>';
}
?>
     </ul>
   </div>
 </div>

<div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
	<legend><i class="fa fa-cog"></i>  {{Gestion}}</legend>
	<div class="eqLogicThumbnailContainer">
		<div class="cursor eqLogicAction" data-action="gotoPluginConf" style="background-color : #ffffff; height : 140px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
			<center>
				<i class="fa fa-wrench" style="font-size : 5em;color:#767676;"></i>
			</center>
			<span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676"><center>{{Configuration}}</center></span>
		</div>
	</div>
  <legend><i class="fa fa-table"></i>  {{Mes enceintes Bluetooth}}</legend>
  <div class="eqLogicThumbnailContainer">
    <div class="cursor eqLogicAction" data-action="add" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
     <center>
      <i class="fa fa-plus-circle" style="font-size : 7em;color:#94ca02;"></i>
     </center>
     <span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02"><center>Ajouter</center></span>
  	</div>
	  <?php
        foreach ($eqLogics as $eqLogic) {
            $opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
            echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="'.$eqLogic->getId().'" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;'.$opacity.'" >';
            echo '<center>';
            echo '<img src="plugins/PulseAudio/docs/images/PulseAudio_icon.png" height="105" width="95" />';
            echo '</center>';
            echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>'.$eqLogic->getHumanName(true, true).'</center></span>';
            echo '</div>';
        }
        ?>
	</div>
</div>



<div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
  <a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
  <a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
  <a class="btn btn-default eqLogicAction pull-right" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a>
  <ul class="nav nav-tabs" role="tablist">
  <li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li>
  <li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-tachometer"></i> {{Equipement}}</a></li>
  <li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Commandes}}</a></li>
  </ul>
  <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
    <div role="tabpanel" class="tab-pane active" id="eqlogictab">
          <form class="form-horizontal">
            <fieldset>
              <legend>{{Général}}</legend>
              <div class="form-group">
                <label class="col-sm-3 control-label">{{Nom de l'enceinte Bluetooth}}</label>
                <div class="col-sm-3">
                  <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
                  <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'enceinte Bluetooth}}"/>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" >{{Objet parent}}</label>
                <div class="col-sm-3">
                  <select class="form-control eqLogicAttr" data-l1key="object_id">
                    <option value="">{{Aucun}}</option>
                    <?php
                    foreach (object::all() as $object) {
                        echo '<option value="'.$object->getId().'">'.$object->getName().'</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              <!-- <div class="form-group">
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
              </div> -->
              <div class="form-group">
                <label class="col-sm-3 control-label">{{Catégorie}}</label>
                <div class="col-sm-8">
                  <?php
                  foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
                      echo '<label class="checkbox-inline">';
                      echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="'.$key.'" />'.$value['name'];
                      echo '</label>';
                  }
                  ?>

                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">{{Commentaire}}</label>
                <div class="col-sm-3">
                  <textarea class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="commentaire" ></textarea>
                </div>
              </div>
              <div class="form-group">
               <label class="col-sm-3 control-label" >{{Activer}}</label>
               <div class="col-sm-9">
           			<input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>
              </div>
              <!-- <div class="form-group">
               <label class="col-sm-3 control-label" >{{Visible}}</label>
               <div class="col-sm-9">
           			<input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>
              </div> -->
            </div>

          </fieldset>
          <div class="col-sm-6">
              <form class="form-horizontal">
                  <fieldset>
                    <legend>{{Paramètres}}</legend>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">{{Assistant}}</label>
                      <div class="col-sm-3">
                        <a class="btn btn-infos" id="bt_bluetoothPair"><i class="fa fa-bluetooth-b"></i> {{Appairer l'enceinte Bluetooth}}
                        </a>
                      </div>
                    </div>
                   <div class="form-group">
                    <label class="col-sm-3 control-label">{{Adresse MAC}}</label>
                    <div class="col-sm-3">
                      <input id="mac_address" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="address"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">{{Nom du Service}}</label>
                    <div class="col-sm-3">
                      <input id="service_name" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="name"/>
                    </div>
                  </div>
                  </fieldset>
              </form>
          </div>
          <span id="serviceName" class="eqLogicAttr" data-l1key="configuration" data-l2key="serviceName" style="display:none;"></span>
          <div class="col-sm-6">
              <form class="form-horizontal">
                  <fieldset>
                      <legend>{{Test}}</legend>
          						<div class="form-group">
          							<div class="col-sm-2">
          								<a class="btn btn-infos" id="bt_serviceStatus">
                            <i class="fa fa-check"></i> {{Status}}
                          </a>
          							</div>
          							<!-- <div class="col-sm-2">
          								<a class="btn btn-infos" id="bt_serviceLog">
                            <i class="fa fa-commenting-o"></i> {{Logs}}
                          </a>
          							</div> -->
          							<div class="col-sm-2">
          								<a class="btn btn-infos" id="bt_startsoundTest" data-toggle="tooltip" data-placement="right" title="A Beautiful Day - Esther Garcia - Creative Common">
          									<i class="fa fa-play-circle"></i> {{Tester}}
          								</a>
          							</div>
          						</div>
                  </fieldset>
              </form>
          </div>
        </form>
      </div>
      <div role="tabpanel" class="tab-pane" id="commandtab">
        <table id="table_cmd" class="table table-bordered table-condensed">
          <thead>
            <tr>
              <th style="width: 50px;">#</th>
              <th style="width: 300px;">{{Nom}}</th>
              <th style="width: 160px;">{{Sous-Type}}</th>
              <th style="width: 200px;">{{Paramètres}}</th>
              <th style="width: 100px;"></th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>

<?php include_file('desktop', 'PulseAudio', 'js', 'PulseAudio'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>

<script>
	$("#bt_serviceStatus").click(function(){
			$('#md_modal').dialog({title: "{{Service Status}}"});
			$('#md_modal').load('index.php?v=d&plugin=PulseAudio&modal=status.PulseAudio').dialog('open');
  });

	$("#bt_serviceLog").click(function(){
			$('#md_modal').dialog({title: "{{Logs}}"});
			$('#md_modal').load('index.php?v=d&plugin=PulseAudio&modal=log.PulseAudio').dialog('open');
  });

	// $("#bt_bluetoothScan").click(function(){
	// 		$('#md_modal').dialog({title: "{{Bluetooth Scan}}"});
	// 		$('#md_modal').load('index.php?v=d&plugin=PulseAudio&modal=scanbluetooth.PulseAudio').dialog('open');
  // });

	$("#bt_startsoundTest").click(function(){
			$('#md_modal').dialog({title: "{{Tester}}"});
			$('#md_modal').load('index.php?v=d&plugin=PulseAudio&modal=soundtest.PulseAudio').dialog('open');
	});

	$("#bt_bluetoothPair").click(function(){
			// alert("Mettez votre enceinte BLuetooth en mode appairage");
			$('#md_modal').dialog({title: "{{Bluetooth Appairage}}"});
			// var mac = document.getElementById('mac_address').value;
			//  $(".form-group #mac_address_found").val( mac );
			// if (/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})/.test(mac)) {
					$('#md_modal').load('index.php?v=d&plugin=PulseAudio&modal=pairbluetooth.PulseAudio').dialog('open');
			// } else {
			//     alert("Adresse MAC invalide :" + mac);
			// }

	});

</script>
