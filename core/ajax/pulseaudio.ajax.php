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

try {
    require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
    include_file('core', 'authentification', 'php');
    
    if (!isConnect('admin')) {
        throw new \Exception(__('401 - Accès non autorisé', __FILE__));
    }
    
    switch(init('action')){
    
        case 'updatePulseAudio':
            PulseAudio::updatePulseAudio();
            ajax::success();
       break;
       
        case 'statusPulseAudio':
            PulseAudio::statusPulseAudio(init('serviceName'));
            ajax::success();
       break;
       
       case 'logPulseAudio':
            PulseAudio::logPulseAudio(init('serviceName'),init('folderLog'));
            ajax::success();
       break;
            
       case 'scanbluetoothPulseAudio':
           PulseAudio::scanbluetoothPulseAudio();
           ajax::success();
       break;
            
       case 'pairbluetoothPulseAudio':
            PulseAudio::pairbluetoothPulseAudio(init('macAddress'));
            ajax::success();
       break;
       
        case 'soundtestPulseAudio':
            PulseAudio::soundtestPulseAudio();
            ajax::success();
        break;
            
        case 'stopsoundtestPulseAudio':
            PulseAudio::stopsoundtestPulseAudio(init('pid'));
            ajax::success();
        break;
            
        default:
             throw new Exception(__('Aucune methode correspondante à : ', __FILE__)   );
        break;
    }
   
    /*     * *********Catch exeption*************** */
} catch (\Exception $e) {
    ajax::error(displayExeption($e), $e->getCode());
}


