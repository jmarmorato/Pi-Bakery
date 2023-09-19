#Create the user pi with password "password".  If we don't create a user, the
#firstboot wizzard will run.
logger "Create default user"
USERNAME="pi"
PASSWORD=$(echo 'password' | openssl passwd -6 -stdin)
echo "$USERNAME:$PASSWORD" > /tftpboot/$1/userconf.txt

#Enable SSH
logger "Enable SSH"
touch /tftpboot/$1/ssh

#Copy SSH public key to pi filesystem.  This is used for running ansible playbooks
#to configure applications
logger "Copy SSH public key to pi filesystem"
mkdir /piboot/$1/root/.ssh
cat /home/pibakery/.ssh/id_rsa.pub >> /piboot/$1/root/.ssh/authorized_keys
