#!/bin/bash

source $1/$2

logger "Deleting configuration for device " $SERIAL

rm $1/$2
rm /tftpboot/$2
rm /piboot/$2 -rf

logger "Deleted configuration for device " $SERIAL