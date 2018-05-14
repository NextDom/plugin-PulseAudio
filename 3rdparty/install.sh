#!/bin/bash
if [[ $EUID -ne 0 ]]; then
  sudo_prefix=sudo;
fi
touch /tmp/pulseaudio_dep
echo 0 > /tmp/pulseaudio_dep
echo "############################################################################"
echo "# Installation in progress"
echo "############################################################################"
echo "############################################################################"
echo "# Update repository packages and install dependencies"
echo "############################################################################"
if ! grep -q "contrib non-free" /etc/apt/sources.list; then
  $sudo_prefix cp /etc/apt/sources.list /etc/apt/sources.list_backup_pulseaudio
  $sudo_prefix sed -i.bak "s| jessie main| jessie main contrib non-free|g" /etc/apt/sources.list
  $sudo_prefix sed -i.bak "s| jessie-updates main| jessie-updates main contrib non-free|g" /etc/apt/sources.list
fi
echo 5 > /tmp/pulseaudio_dep
$sudo_prefix apt-get -y update
echo 10 > /tmp/pulseaudio_dep

if grep -q "Raspbian" /etc/os-release; then
  $sudo_prefix apt-get -y install pi-bluetooth blueman
fi

$sudo_prefix apt-get -y install pulseaudio pulseaudio-module-bluetooth pulseaudio-module-zeroconf avahi-daemon dbus-x11 bluez bluez-firmware expect lsb-release mplayer
if [ -f /etc/apt/sources.list_backup_pulseaudio ]; then
  $sudo_prefix mv /etc/apt/sources.list_backup_pulseaudio /etc/apt/sources.list
fi

echo 60 > /tmp/pulseaudio_dep

echo "############################################################################"
echo "# Add root and jeedom users to pulse-access group"
echo "############################################################################"
$sudo_prefix adduser root pulse-access
$sudo_prefix adduser jeedom pulse-access
$sudo_prefix adduser www-data pulse-access
if grep -q "Raspbian" /etc/os-release; then
  $sudo_prefix adduser pi pulse-access
fi

echo 70 > /tmp/pulseaudio_dep

echo "############################################################################"
echo "# Authorize PulseAudio - which will run as user pulse - to use BlueZ D-BUS interface:"
echo "############################################################################"
$sudo_prefix bash -c "cat <<EOF > /etc/dbus-1/system.d/pulseaudio-bluetooth.conf
<busconfig>

  <policy user=\"pulse\">
	 <allow send_destination=\"org.bluez\"/>
  </policy>
  <policy user=\"jeedom\">
   <allow own="org.bluez"/>
   <allow send_destination="org.bluez"/>
   <allow send_interface="org.bluez.Agent1"/>
   <allow send_interface="org.bluez.MediaEndpoint1"/>
   <allow send_interface="org.bluez.MediaPlayer1"/>
   <allow send_interface="org.bluez.ThermometerWatcher1"/>
   <allow send_interface="org.bluez.AlertAgent1"/>
   <allow send_interface="org.bluez.Profile1"/>
   <allow send_interface="org.bluez.HeartRateWatcher1"/>
   <allow send_interface="org.bluez.CyclingSpeedWatcher1"/>
   <allow send_interface="org.bluez.GattCharacteristic1"/>
   <allow send_interface="org.bluez.GattDescriptor1"/>
   <allow send_interface="org.freedesktop.DBus.ObjectManager"/>
   <allow send_interface="org.freedesktop.DBus.Properties"/>
 </policy>

</busconfig>
EOF"
$sudo_prefix chmod go+w /etc/dbus-1/system.d/pulseaudio-bluetooth.conf
echo 80 > /tmp/pulseaudio_dep

echo "############################################################################"
echo "# Load Bluetooth discover module in SYSTEM MODE:"
echo "############################################################################"
if ! grep -q "load-module module-bluetooth-discover" /etc/pulse/system.pa; then
	$sudo_prefix bash -c "cat <<EOF >> /etc/pulse/system.pa

########################
### Bluetooth Support ##
########################
.ifexists module-bluetooth-discover.so
load-module module-bluetooth-discover
.endif
EOF"
fi
$sudo_prefix chmod go+w /etc/pulse/system.pa

echo "############################################################################"
echo "# Load Network module in SYSTEM MODE:"
echo "############################################################################"
if ! grep -q "module-native-protocol-tcp" /etc/pulse/system.pa; then
	$sudo_prefix bash -c "cat <<EOF >> /etc/pulse/system.pa

#######################
### Network Support ###
#######################
load-module module-native-protocol-tcp auth-anonymous=1
load-module module-zeroconf-publish
#load-module module-simple-protocol-tcp source=1 record=true port=12345
EOF"
fi

echo "############################################################################"
echo "# Load Simultaneous module in SYSTEM MODE:"
echo "############################################################################"
if ! grep -q "module-combine-sink" /etc/pulse/system.pa; then
	$sudo_prefix bash -c "cat <<EOF >> /etc/pulse/system.pa

############################
### Simultaneous Support ###
############################
load-module module-combine-sink sink_name=combined
set-default-sink combined
EOF"
fi

echo 85 > /tmp/pulseaudio_dep

echo "############################################################################"
echo "# Restart Bluetooth and check its status"
echo "############################################################################"
$sudo_prefix systemctl enable bluetooth
$sudo_prefix systemctl restart bluetooth
echo 90 > /tmp/pulseaudio_dep

echo "############################################################################"
echo "# Create a systemd service for running pulseaudio in System Mode as user 'pulse'."
echo "############################################################################"

$sudo_prefix cp -Rf $(dirname "$0")/pulseaudio.service /etc/systemd/system/pulseaudio.service
$sudo_prefix chmod go+wx $(dirname "$0")/pulseaudio.service
echo 95 > /tmp/pulseaudio_dep

echo "############################################################################"
echo "# Restart Bluetooth and check its status"
echo "############################################################################"
$sudo_prefix systemctl daemon-reload
$sudo_prefix systemctl enable pulseaudio.service
$sudo_prefix systemctl start pulseaudio.service
echo 98 > /tmp/pulseaudio_dep

echo "############################################################################"
echo "# Linking scripts"
echo "############################################################################"
if [ ! -f /usr/sbin/bluetooth-connect.sh ]; then
    $sudo_prefix ln -s $(dirname "$0")/bluetooth-connect.sh /usr/sbin/bluetooth-connect.sh
fi
if [ ! -f /usr/sbin/bluetooth-disconnect.sh ]; then
	$sudo_prefix ln -s $(dirname "$0")/bluetooth-disconnect.sh /usr/sbin/bluetooth-disconnect.sh
fi
if [ ! -f /usr/sbin/bluetooth-pair-trust.sh ]; then
	$sudo_prefix ln -s $(dirname "$0")/bluetooth-pair-trust.sh /usr/sbin/bluetooth-pair-trust.sh
fi
if [ ! -f /usr/sbin/bluetooth-unpair-untrust.sh ]; then
	$sudo_prefix ln -s $(dirname "$0")/bluetooth-unpair-untrust.sh /usr/sbin/bluetooth-unpair-untrust.sh
fi

$sudo_prefix chmod +x $(dirname "$0")/bluetooth-connect.sh
$sudo_prefix chmod +x $(dirname "$0")/bluetooth-disconnect.sh
$sudo_prefix chmod +x $(dirname "$0")/bluetooth-pair-trust.sh
$sudo_prefix chmod +x $(dirname "$0")/bluetooth-unpair-untrust.sh
$sudo_prefix chmod +x $(dirname "$0")/bluetooth-scan.sh


echo "############################################################################"
echo "# Installation Information"
echo "############################################################################"
$sudo_prefix cat /etc/os-release
$sudo_prefix bluetoothctl --version

echo "############################################################################"
echo "# Services Information"
echo "############################################################################"
$sudo_prefix systemctl status bluetooth
$sudo_prefix systemctl status pulseaudio.service



echo 100 > /tmp/pulseaudio_dep
rm /tmp/pulseaudio_dep
echo "############################################################################"
echo "# Installation finnished"
echo "############################################################################"
