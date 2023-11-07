sed -i '/dtoverlay=vc4-kms-v3d/c\#dtoverlay=vc4-kms-v3d' /tftpboot/$1/config.txt
cp "$2/files/kiosk.desktop" /piboot/$1/etc/xdg/autostart
envsubst < /piboot/$1/etc/xdg/autostart > /piboot/$1/etc/xdg/autostart