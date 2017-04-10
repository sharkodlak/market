# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
	# All Vagrant configuration is done here. The most common configuration
	# options are documented and commented below. For a complete reference,
	# please see the online documentation at vagrantup.com.

	# Every Vagrant virtual environment requires a box to build off of.
	config.vm.box = "debian/jessie64"

	# If true, then any SSH connections made will enable agent forwarding.
	# Default value: false
	# config.ssh.forward_agent = true

	machineName = "market"

	config.vm.define machineName
	config.vm.hostname = machineName

	config.vm.provider "virtualbox" do |vb|
		vb.name = machineName
	end

	config.vm.provision "shell", path: "provision/init.sh"

	config.vm.network "forwarded_port", host: 8080, guest: 80
end
