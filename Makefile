#
# FABIO CICERCHIA - WEBSITE
# Copyright (C) 2012. All Rights reserved.
#

# SYSTEM COMMANDS
SUDO=sudo
HIDDEN=@

APT=$(SUDO) $(HIDDEN)apt-get
CD=$(HIDDEN)cd
CHMOD=$(HIDDEN)chmod
CP=$(HIDDEN)cp -r
CURL=$(HIDDEN)curl
ECHO=$(HIDDEN)echo
GIT=$(HIDDEN)git
LN=$(HIDDEN)ln -s
MKDIR=$(HIDDEN)mkdir -p
RM=$(HIDDEN)rm -rf
WGET=$(HIDDEN)wget

# CUSTOM COMMANDS
A2ENMOD=$(SUDO) $(HIDDEN)a2enmod
PDEPEND=$(HIDDEN)pdepend
PEAR=$(SUDO) $(HIDDEN)pear
PECL=$(SUDO) $(HIDDEN)pecl
PERL=$(HIDDEN)perl
PHP=$(HIDDEN)php
PHPCB=$(HIDDEN)phpcb
PHPCPD=$(HIDDEN)phpcpd
PHPCS=$(HIDDEN)phpcs -s -v
PHPDOC=$(HIDDEN)phpdoc
PHPLOC=$(HIDDEN)phploc
PHPMD=$(HIDDEN)phpmd
PHPUNIT=$(HIDDEN)phpunit

# FLAGS
PEAR_INSTALL_FLAGS=--alldeps

# DIRECTORIES
CURRENTDIR=.
API_APP_SOURCEDIR=$(CURRENTDIR)/apps/api
API_LIB_SOURCEDIR=$(CURRENTDIR)/lib/vendor/FabioCicerchia/lib/FabioCicerchia/Api
API_TEST_SOURCEDIR=$(CURRENTDIR)/test/api
REPORTDIR=$(CURRENTDIR)/report

################################################################################
# GENERAL ACTIONS
################################################################################

all: info test sca

info:
	$(ECHO) "--------------------------------------------------------------------------------"
	$(ECHO) "FABIO CICERCHIA - WEBSITE"
	$(ECHO) "--------------------------------------------------------------------------------"

init-environment:
	$(ECHO) "INSTALL THE ENVIRONMENT"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(WGET) http://silex.sensiolabs.org/get/silex.phar -O apps/api/silex.phar
	$(GIT) submodule init
	$(GIT) submodule update
	$(CD) lib/vendor/mongodb
	$(CURL) -s http://getcomposer.org/installer | $(PHP)
	$(PHP) composer.phar install

install-environment: install-php54 install-imagick install-phpunit install-phpcb install-phpcc install-phpcov install-phpcpd install-phploc install-phpdoc2 install-pdepend install-phpmd install-phpcs install-phpmongo

config-environment: config-apache

tests:
	$(ECHO) "RUN THE TESTS"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PHPUNIT) || true
	$(PERL) test/site/test.pl

sca: run-phpcs run-phpmd run-phploc run phpcpd run-pdepend run-phpcb

################################################################################
# SPECIFIC ACTIONS
################################################################################

install-php54:
	$(ECHO) "INSTALLING PHP 5.4"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(SUDO) add-apt-repository ppa:ondrej/php5
	$(APT) update
	$(APT) upgrade
	$(APT) dist-upgrade

install-imagick:
	$(ECHO) "INSTALLING IMAGICK"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PECL) install imagick

install-phpunit:
	$(ECHO) "INSTALLING PHPUNIT"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PEAR) channel-discover pear.phpunit.de || true
	$(PEAR) install $(PEAR_INSTALL_FLAGS) phpunit/PHPUnit

install-phpcb:
	$(ECHO) "INSTALLING PHP_CODE_BROWSER"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PEAR) channel-discover pear.phpunit.de || true
	$(PEAR) install $(PEAR_INSTALL_FLAGS) phpunit/PHP_CodeBrowser

install-phpcc:
	$(ECHO) "INSTALLING PHP_CODE_COVERAGE"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PEAR) channel-discover pear.phpunit.de || true
	$(PEAR) install $(PEAR_INSTALL_FLAGS) phpunit/PHP_CodeCoverage

install-phpcov:
	$(ECHO) "INSTALLING PHPCOV"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PEAR) channel-discover pear.phpunit.de || true
	$(PEAR) install $(PEAR_INSTALL_FLAGS) phpunit/phpcov

install-phpcpd:
	$(ECHO) "INSTALLING PHPCPD"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PEAR) channel-discover pear.phpunit.de || true
	$(PEAR) install $(PEAR_INSTALL_FLAGS) phpunit/phpcpd

install-phploc:
	$(ECHO) "INSTALLING PHPLOC"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PEAR) channel-discover pear.phpunit.de || true
	$(PEAR) install $(PEAR_INSTALL_FLAGS) phpunit/phploc

install-phpdoc2:
	$(ECHO) "INSTALLING PHPDOCUMENTOR2"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PEAR) channel-discover pear.phpdoc.org || true
	$(PEAR) install $(PEAR_INSTALL_FLAGS) phpdoc/phpDocumentor-alpha
	$(APT) install graphviz

install-pdepend:
	$(ECHO) "INSTALLING PHP_DEPEND"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PEAR) channel-discover pear.pdepend.org || true
	$(PEAR) install $(PEAR_INSTALL_FLAGS) pdepend/PHP_Depend-beta

install-phpmd:
	$(ECHO) "INSTALLING PHPMD"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PEAR) channel-discover pear.phpmd.org || true
	$(PEAR) install $(PEAR_INSTALL_FLAGS) phpmd/PHP_PMD

install-phpcs:
	$(ECHO) "INSTALLING PHP_CodeSniffer"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PEAR) install $(PEAR_INSTALL_FLAGS) PHP_CodeSniffer-1.3.2

install-phpmongo:
	$(ECHO) "INSTALLING PHP MONGODB"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PECL) install mongo

config-apache:
	$(ECHO) "CONFIGURING APACHE"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(A2ENMOD) actions
	$(A2ENMOD) cache
	$(A2ENMOD) disk_cache
	$(A2ENMOD) expires
	$(A2ENMOD) headers
	$(A2ENMOD) mem_cache
	$(A2ENMOD) mod-security
	$(A2ENMOD) perl
	$(A2ENMOD) php5
	$(A2ENMOD) rewrite
	$(A2ENMOD) speling

run-phpcs:
	$(ECHO) "RUNNING PHP_CodeSniffer"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PHPCS) --standard="$(CURRENTDIR)/lib/PHPCS/ruleset.xml" --report=xml --report-file="$(REPORTDIR)/api/logs/app/phpcs.xml" "$(API_APP_SOURCEDIR)" || true
	$(PHPCS) --standard="$(CURRENTDIR)/lib/PHPCS/ruleset.xml" --report=xml --report-file="$(REPORTDIR)/api/logs/lib/phpcs.xml" "$(API_LIB_SOURCEDIR)" || true
	$(PHPCS) --standard="$(CURRENTDIR)/lib/PHPCS/ruleset.xml" --report=xml --report-file="$(REPORTDIR)/api/logs/test/phpcs.xml" "$(API_TEST_SOURCEDIR)" || true

run-phpmd:
	$(ECHO) "RUNNING PHPMD"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PHPMD) "$(API_APP_SOURCEDIR)" xml codesize,design,naming,unusedcode --reportfile "$(REPORTDIR)/api/logs/app/phpmd.xml" || true
	$(PHPMD) "$(API_LIB_SOURCEDIR)" xml codesize,design,naming,unusedcode --reportfile "$(REPORTDIR)/api/logs/lib/phpmd.xml" || true
	$(PHPMD) "$(API_TEST_SOURCEDIR)" xml codesize,design,naming,unusedcode --reportfile "$(REPORTDIR)/api/logs/test/phpmd.xml" || true

run-phploc:
	$(ECHO) "RUNNING PHPLOC"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PHPLOC) --log-xml "$(REPORTDIR)/api/logs/app/phploc.xml" "$(API_APP_SOURCEDIR)"
	$(PHPLOC) --log-xml "$(REPORTDIR)/api/logs/lib/phploc.xml" "$(API_LIB_SOURCEDIR)"
	$(PHPLOC) --log-xml "$(REPORTDIR)/api/logs/test/phploc.xml" "$(API_TEST_SOURCEDIR)"

run-phpcpd:
	$(ECHO) "RUNNING PHPCPD"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PHPCPD) --log-pmd "$(REPORTDIR)/api/logs/app/phpcpd.xml" "$(API_APP_SOURCEDIR)" > "$(REPORTDIR)/api/logs/app/duplications.txt"
	$(PHPCPD) --log-pmd "$(REPORTDIR)/api/logs/lib/phpcpd.xml" "$(API_LIB_SOURCEDIR)" > "$(REPORTDIR)/api/logs/lib/duplications.txt"
	$(PHPCPD) --log-pmd "$(REPORTDIR)/api/logs/test/phpcpd.xml" "$(API_TEST_SOURCEDIR)" > "$(REPORTDIR)/api/logs/test/duplications.txt"

run-pdepend:
	$(ECHO) "RUNNING PHP_DEPEND"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PDEPEND) --jdepend-chart="$(REPORTDIR)/api/pdepend-chart_app.svg" --overview-pyramid="$(REPORTDIR)/api/pdepend-pyramid_app.svg" --jdepend-xml="$(REPORTDIR)/api/logs/app/pdepend.xml" "$(API_APP_SOURCEDIR)"
	$(PDEPEND) --jdepend-chart="$(REPORTDIR)/api/pdepend-chart_lib.svg" --overview-pyramid="$(REPORTDIR)/api/pdepend-pyramid_lib.svg" --jdepend-xml="$(REPORTDIR)/api/logs/lib/pdepend.xml" "$(API_LIB_SOURCEDIR)"
	$(PDEPEND) --jdepend-chart="$(REPORTDIR)/api/pdepend-chart_test.svg" --overview-pyramid="$(REPORTDIR)/api/pdepend-pyramid_test.svg" --jdepend-xml="$(REPORTDIR)/api/logs/test/pdepend.xml" "$(API_TEST_SOURCEDIR)"

run-phpcb:
	$(ECHO) "RUNNING PHP_CODE_BROWSER"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PHPCB) --log="$(REPORTDIR)/api/logs/app/" --source="$(API_APP_SOURCEDIR)" --output="$(REPORTDIR)/api/code_browser/app"
	$(PHPCB) --log="$(REPORTDIR)/api/logs/lib/" --source="$(API_LIB_SOURCEDIR)" --output="$(REPORTDIR)/api/code_browser/lib"
	$(PHPCB) --log="$(REPORTDIR)/api/logs/test/" --source="$(API_TEST_SOURCEDIR)" --output="$(REPORTDIR)/api/code_browser/test"

run-phpdoc:
	$(ECHO) "RUNNING PHPDOCUMENTOR"
	$(ECHO) "--------------------------------------------------------------------------------"
	$(PHPDOC)
