bold=`tput bold`
green=`tput setaf 2`
reset=`tput sgr0`

help:
	@echo "${bold}Docker containers manipulation commands${reset}"
	@echo "${green}up${reset}		Start containers in background mode"
	@echo "${green}down${reset}		Stops containers and removes containers, networks, volumes, and images created by \`up\`"
	@echo ""
	@echo "${bold}Interactive terminals${reset}"
	@echo "${green}sh${reset}		Web container console as www-data user"
	@echo ""
	@echo "${bold}Miscellaneous Macro${reset}"
	@echo "${green}fresh-db${reset}	Initialize database with some data"

# Docker containers manipulation commands ##############################################################################

up:
	@echo "🏃 ${green}Starting the application in the background...${reset}"
	@./vendor/bin/sail up -d
	@echo

down:
	@echo "🏃 ${green}Stopping the application...${reset}"
	@./vendor/bin/sail down

# Interactive terminals ################################################################################################

sh: up
	@./vendor/bin/sail shell

# Miscellaneous Macro ##################################################################################################

fresh-db:
	@./vendor/bin/sail artisan migrate:fresh
	@./vendor/bin/sail artisan db:seed
