#!/bin/bash
usr=`whoami`
cd $(dirname $0)
echo "Executing some commands as root"
mkdir -p ~/hostsbot
sudo mkdir -p /Applications/Hostsbot.app/bin
sed "s/__USRDIR__/${usr}/" config.macos.yaml.dist >config.macos.yaml.tmp
sudo cp config.macos.yaml.tmp /Applications/Hostsbot.app/bin/config.yaml
rm config.macos.yaml.tmp
sudo cp hostsbot /Applications/Hostsbot.app/bin/hostsbot
sudo chown -R root:wheel /Applications/Hostsbot.app
sudo rm /usr/local/bin/hostsbot
sudo cp macos-synchostsbot.sh /usr/local/bin/synchostsfile
sudo chmod +x /usr/local/bin/synchostsfile
sudo ln -s /Applications/Hostsbot.app/bin/hostsbot /usr/local/bin/hostsbot

