.SILENT:
INVENTORY ?= dev-hosts.yaml

all: checkEnv
	test -f inventory/${INVENTORY}												|| (	\
		echo "The inventory file inventory/${INVENTORY} does not exist!";				\
		exit 1																			\
	)
	ansible-playbook -i inventory/${INVENTORY} playbook/main.yaml

# Make sure every variable listed in var/environment.yaml is set in the environment
checkEnv:
	yq -e '.["env_var"] | all(in($$ENV))' < var/environment.yaml > /dev/null	|| (	\
		echo Please set up the environment with the variables in var/environment.yaml.;	\
		exit 1																			\
	)

# need to install https://galaxy.ansible.com/geerlingguy/composer

