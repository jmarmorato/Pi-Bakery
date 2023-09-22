logger "Start Server Commands"

sed -i '/dtoverlay=vc4-kms-v3d/c\#dtoverlay=vc4-kms-v3d' /tftpboot/$1/config.txt

logger \"$2/files/kiosk.desktop\" /piboot/$1/etc/xdg/autostart

cp "$2/files/kiosk.desktop" /piboot/$1/etc/xdg/autostart