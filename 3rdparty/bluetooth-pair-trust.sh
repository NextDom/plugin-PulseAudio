#!/usr/bin/expect -f

set prompt "#"
set port [lindex $argv 0]
set address [lindex $argv 1]

spawn bluetoothctl -a
expect -re $prompt
send "remove $address\r"
sleep 1
send_user "\n"
send_user "############################################################################\n"
send_user "# Try to power on the Bluetooth device on controller $port\n"
send_user "############################################################################\n"
send "select $port\r"
send "power on\r"
expect -re $prompt
send_user "\n"
send_user "############################################################################\n"
send_user "# Try to remove $address first\n"
send_user "############################################################################\n"
expect -re $prompt
send "scan on\r"
send_user "\n"
send_user "############################################################################\n"
send_user "# Scan bluetooth device in progress\n"
send_user "############################################################################\n"
sleep 10
send_user "\n"
send_user "############################################################################\n"
send_user "# Scan bluetooth device done\n"
send_user "############################################################################\n"
send "scan off\r"
expect "Controller"
send "trust $address\r"
sleep 2
send_user "\n"
send_user "############################################################################\n"
send_user "# $address should be trusted now.\n"
send_user "############################################################################\n"
send "pair $address\r"
sleep 2
send_user "\n"
send_user "############################################################################\n"
send_user "# $address should be paired now.\n"
send_user "############################################################################\n"
send "connect $address\r"
#send "0000\r"
sleep 3
send_user "\n"
send_user "############################################################################\n"
send_user "# $address should be checked now.\n"
send_user "############################################################################\n"
send "quit\r"
expect eof
