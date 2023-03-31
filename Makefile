.SILENT:
INVENTORY ?= dev-hosts.yaml

all: checkEnv
	ansible-playbook -i ${INVENTORY} main.yaml

# Make sure every variable listed in var/environment.yaml is set in the environment
checkEnv:
	yq -e '.["env_var"] | all(in($$ENV))' < var/environment.yaml > /dev/null || (		\
		echo Please set up the environment with the variables in var/environment.yaml.;	\
		exit 1																			\
	)

