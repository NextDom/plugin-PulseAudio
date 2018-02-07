#!/usr/bin/expect -f

set prompt "#"
set port [lindex $argv 0]
set address [lindex $argv 1]

spawn bluetoothctl -a
expect -re $promptsend_user "\n"
send_user "############################################################################\n"
send_user "# Try to power on the Bluetooth device on controller $port\n"
send_user "############################################################################\n"
send "select $port\r"
send "power on\r"
send_user "\n"
send_user "############################################################################\n"
send_user "# Try to disconnect $address\n"
send_user "############################################################################\n"
send "disconnect $address\r"
sleep 1
send_user "\n"
send_user "############################################################################\n"
send_user "# $address should be disconnected now\n"
send_user "############################################################################\n"
send "untrust $address\r"
sleep 1
send_user "\n"
send_user "############################################################################\n"
send_user "# $address should be removed from trusted device now\n"
send_user "############################################################################\n"
expect -re $prompt
send "remove $address\r"
sleep 1
send_user "\n"
send_user "############################################################################\n"
send_user "# $address should be unpaired now\n"
send_user "############################################################################\n"
send "quit\r"
expect eof
