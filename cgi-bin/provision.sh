#!/bin/bash

source $1/$2

logger "Begin provisioning process for device " $SERIAL

function delete_provision () {
        #Delete the provision trigger file
        rm $1/$2
}

#This command mounts the RaspberryPi OS img file to a loop device
#so we can mount the poartitions within it to the filesystem.  The
#device variable holds the name of the loop device in /dev/ so we
#can mount its partitions in the next step.
device=$(losetup --show -f -P $IMGPATH)
if [ ! $? -eq 0 ]
then
	echo "Failed to mount image to loop device"
        delete_provision
	exit 1000
fi
logger "Successfully mounted image to loop device " $device

#This command mounts the first partition (the boot partition) to
#the filesystem so we can copy the files from it to the Pi directory
mount "${device}p1" /media/boot
if [ ! $? -eq 0 ]
then
        logger "Failed to mount image boot partition to filesystem"
        delete_provision
        exit 1001
fi
logger "Mounted image boot partition to filesystem"

#This command mounts the main partition to the filesystem so we can
#copy the files from it to the Pi directory
mount "${device}p2" /media/root
if [ ! $? -eq 0 ]
then
        logger "Failed to mount image main partition to filesystem"
        delete_provision
        exit 1003
fi
logger "Mounted image main partition to filesystem"

#Delete the Pi directory if it exists already.  This is useful when
#re-provisioning a device
rm -rf /piboot/$SERIAL
if [ ! $? -eq 0 ]
then
        logger "Failed to delete existing Pi directory"
        delete_provision
        exit 1004
fi
logger "Deleted the existing directory for device $SERIAL (if it exists)"

#Create the new Pi directory.  This is what the Pi will mount over
#NFS when booting.
mkdir -p /piboot/$SERIAL
if [ ! $? -eq 0 ]
then
        logger "Failed to create new Pi directory"
        delete_provision
        exit 1005
fi
logger "Created a new directory for device $SERIAL"

#Copy the contents of the mounted root partition to the pi directory.
#The p flag maintains permissions from the source to the destination
cp -rp /media/root/* /piboot/$SERIAL
if [ ! $? -eq 0 ]
then
        logger "Failed to copy root files top the Pi directory"
        delete_provision
        exit 1005
fi
logger "Copied root files to the Pi directory"

#Copy the contents of the mounted boot partition to the pi directory.
#The p flag maintains permissions from the source to the destination 
cp -rp /media/boot/* /piboot/$SERIAL/boot/
if [ ! $? -eq 0 ]
then
        logger "Failed to copy boot files to the Pi directory"
        delete_provision
        exit 1005
fi
logger "Copied boot files to the Pi directory"

#Link the tftpboot directory to the boot directory in the pi
#directory
ln -s /piboot/$SERIAL/boot/ /tftpboot/$SERIAL
if [ ! $? -eq 0 ]
then
        logger "Failed to link /tftpboot/<pi-serial> to /piboot/<serial>/boot"
        delete_provision
        exit 1005
fi
logger "Linked /tftpboot/<pi-serial> to /piboot/<serial>/boot"

#Unmount Loop Device
umount -f /media/root
if [ ! $? -eq 0 ]
then
        logger "Failed to unmount the Pi image root partition from the filesystem"
        delete_provision
        exit 1005
fi
logger "Unmounted the Pi image root partition from the filesystem"
umount -f /media/boot
if [ ! $? -eq 0 ]
then
        logger "Failed to unmount the Pi image boot partition from the filesystem"
        delete_provision
        exit 1005
fi
logger "Unmounted the Pi image boot partition from the filesystem"

#Unmount loop device
losetup --detach $device
if [ ! $? -eq 0 ]
then
        logger "Failed to unmount loop device $device"
        delete_provision
        exit 1005
fi
logger "Unmounted loop device " $device

#Build /boot/cmdline.txt and /etc/fstab
logger "Building system templates"
/var/www/PiBakery/templates/system_templates.sh $SERIAL "192.168.8.9" $BOOTNETTYPE $BOOTNETIP $BOOTNETGATEWAY 255.255.255.0
if [ ! $? -eq 0 ]
then
        logger "Error building system templates"
        delete_provision
        exit 1005
fi

#Create the primary user, enable SSH, and copy the PiBakery server's SSH public key to the Pi
logger "Performing filesystem tasks"
/var/www/PiBakery/cgi-bin/fs_mods.sh $SERIAL
if [ ! $? -eq 0 ]
then
        logger "Failed to perform filesystem tasks"
        delete_provision
        exit 1005
fi

if [ -f "$TEMPLATE/server_commands.sh" ];
then
        logger "Run the template's server_commands"
        "$TEMPLATE/server_commands.sh" $SERIAL "$TEMPLATE"
fi

logger "Provision complete"