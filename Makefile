default: help

PROJECT_NAME := Goodloss

#
#### General
#

### General actions

## Clear cache & build server
all: web cache
dev: web-dev cache-dev
prod: web-prod cache-prod

#
#### Server
#

### Actions for server

## Build web server
web: web-dev web-prod

## Build dev web server
web-dev:
	npm run dev

## Build prod web server
web-prod:
	npm run build

#
#### Cache
#

### Actions for cache 

## Create Env File

## Clear cache
cache: cache-dev cache-prod

## Clear dev cache
cache-dev:
	symfony console cache:clear

## Clear prod cache
cache-prod:
	symfony console cache:clear --env=prod --no-debug

# COLORS
GREEN  := $(shell tput -Txterm setaf 2)
YELLOW := $(shell tput -Txterm setaf 3)
WHITE  := $(shell tput -Txterm setaf 7)
RESET  := $(shell tput -Txterm sgr0)
TARGET_MAX_CHAR_NUM=25

help:
	@echo ""
	@echo "####################"
	@echo "# Project $(PROJECT_NAME) #"
	@echo "####################"
	@awk '/^### (.*)/ { \
	    print ""; \
	    for (i = 2; i <= NF; i++) {\
	        printf "%s ", $$i; \
	    } \
	    print ""; \
	} \
	/^#### (.*)/ { \
	    printf "\n==========\n  "; \
	    for (i = 2; i <= NF; i++) { \
	        printf "%s ", $$i; \
	    } \
	    print "\n=========="; \
	} \
	/^[a-zA-Z\-\_0-9\/]+:/ { \
	    helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf "    ${YELLOW}%-$(TARGET_MAX_CHAR_NUM)s${RESET} ${GREEN}%s${RESET}\n", helpCommand, helpMessage; \
		} \
	} { lastLine = $$0 }' $(MAKEFILE_LIST)
