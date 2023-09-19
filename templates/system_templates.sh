#!/bin/bash

export PISERIAL=$1
export NFSIP=$2
export CLIENTIP=$4
export GATEWAY=$5
export NETMASK=$6

NETTYPE=$3

if [ "$NETTYPE" = "dhcp" ]
then
        TEMPLATE="/var/www/PiBakery/templates/cmdline-dhcp.template"
else
        TEMPLATE="/var/www/PiBakery/templates/cmdline-static.template"
fi

logger "Build cmdline.txt"
envsubst < $TEMPLATE > /piboot/$PISERIAL/boot/cmdline.txt
if [ ! $? -eq 0 ]
then
        logger "Failed to build cmdline.txt template"
        exit 1005
fi

logger "Build fstab"
envsubst < /var/www/PiBakery/templates/fstab > /piboot/$PISERIAL/etc/fstab
if [ ! $? -eq 0 ]
then
        logger "Failed to build fstab template"
        exit 1005
fi
