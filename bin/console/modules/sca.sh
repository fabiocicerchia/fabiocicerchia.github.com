#!/bin/bash
#
# FABIO CICERCHIA - WEBSITE
#
# Copyright 2012 Fabio Cicerchia.
#
# Permission is hereby  granted, free of charge, to any  person obtaining a copy
# of this software and associated  documentation files (the "Software"), to deal
# in the Software  without restriction, including without  limitation the rights
# to  use, copy,  modify, merge,  publish, distribute,  sublicense, and/or  sell
# copies  of  the Software,  and  to  permit persons  to  whom  the Software  is
# furnished to do so, subject to the following conditions:
#
# The above copyright notice and this permission notice shall be included in all
# copies or substantial portions of the Software.
#
# THE SOFTWARE  IS PROVIDED "AS  IS", WITHOUT WARRANTY  OF ANY KIND,  EXPRESS OR
# IMPLIED,  INCLUDING BUT  NOT  LIMITED TO  THE  WARRANTIES OF  MERCHANTABILITY,
# FITNESS FOR  A PARTICULAR PURPOSE AND  NONINFRINGEMENT. IN NO EVENT  SHALL THE
# AUTHORS  OR COPYRIGHT  HOLDERS  BE  LIABLE FOR  ANY  CLAIM,  DAMAGES OR  OTHER
# LIABILITY, WHETHER IN AN ACTION OF  CONTRACT, TORT OR OTHERWISE, ARISING FROM,
# OUT OF OR IN CONNECTION WITH THE SOFTWARE  OR THE USE OR OTHER DEALINGS IN THE
# SOFTWARE.
#
# Bash Shell
#
# Category: Code
# Package:  Console
# Author:   Fabio Cicerchia <info@fabiocicerchia.it>
# License:  MIT <http://www.opensource.org/licenses/MIT>
# Link:     http://www.fabiocicerchia.it
#

# TODO: Add {{{ }}} as delimiter.

################################################################################
# SCA ACTIONS
################################################################################

# TODO: Remove handle_errors?
# TODO: Wrap multiline.
sca_phpcs() {
    print_subheader "RUNNING PHP_CodeSniffer"

    mkdir -p "$REPORTDIR/api/logs/app/"
    mkdir -p "$REPORTDIR/api/logs/lib/"
    mkdir -p "$REPORTDIR/api/logs/test/"
    phpcs -s -v --standard="$ROOTDIR/lib/PHPCS/ruleset.xml" --report=xml --report-file="$REPORTDIR/api/logs/app/phpcs.xml" "$API_APP_SOURCEDIR" || handle_errors $?
    phpcs -s -v --standard="$ROOTDIR/lib/PHPCS/ruleset.xml" --report=xml --report-file="$REPORTDIR/api/logs/lib/phpcs.xml" "$API_LIB_SOURCEDIR" || handle_errors $?
    phpcs -s -v --standard="$ROOTDIR/lib/PHPCS/ruleset.xml" --report=xml --report-file="$REPORTDIR/api/logs/test/phpcs.xml" "$API_TEST_SOURCEDIR" || handle_errors $?

    return $?
}

# TODO: Remove handle_errors?
# TODO: Wrap multiline.
sca_phpmd() {
    print_subheader "RUNNING PHPMD"

    mkdir -p "$REPORTDIR/api/logs/app/"
    mkdir -p "$REPORTDIR/api/logs/lib/"
    mkdir -p "$REPORTDIR/api/logs/test/"
    phpmd "$API_APPSOURCEDIR" xml codesize,design,naming,unusedcode --reportfile "$REPORTDIR/api/logs/app/phpmd.xml" || handle_errors $?
    phpmd "$API_LIBSOURCEDIR" xml codesize,design,naming,unusedcode --reportfile "$REPORTDIR/api/logs/lib/phpmd.xml" || handle_errors $?
    phpmd "$API_TESTSOURCEDIR" xml codesize,design,naming,unusedcode --reportfile "$REPORTDIR/api/logs/test/phpmd.xml" || handle_errors $?

    return $?
}

# TODO: Remove handle_errors?
sca_phploc() {
    print_subheader "RUNNING PHPLOC"

    mkdir -p "$REPORTDIR/api/logs/app/"
    mkdir -p "$REPORTDIR/api/logs/lib/"
    mkdir -p "$REPORTDIR/api/logs/test/"
    phploc --log-xml "$REPORTDIR/api/logs/app/phploc.xml" "$API_APPSOURCEDIR" || handle_errors $?
    phploc --log-xml "$REPORTDIR/api/logs/lib/phploc.xml" "$API_LIBSOURCEDIR" || handle_errors $?
    phploc --log-xml "$REPORTDIR/api/logs/test/phploc.xml" "$API_TESTSOURCEDIR" || handle_errors $?

    return $?
}

# TODO: Remove handle_errors?
# TODO: Wrap multiline.
sca_phpcpd() {
    print_subheader "RUNNING PHPCPD"

    mkdir -p "$REPORTDIR/api/logs/app/"
    mkdir -p "$REPORTDIR/api/logs/lib/"
    mkdir -p "$REPORTDIR/api/logs/test/"
    phpcpd --log-pmd "$REPORTDIR/api/logs/app/phpcpd.xml" "$API_APPSOURCEDIR" > "$REPORTDIR/api/logs/app/duplications.txt" || handle_errors $?
    phpcpd --log-pmd "$REPORTDIR/api/logs/lib/phpcpd.xml" "$API_LIBSOURCEDIR" > "$REPORTDIR/api/logs/lib/duplications.txt" || handle_errors $?
    phpcpd --log-pmd "$REPORTDIR/api/logs/test/phpcpd.xml" "$API_TESTSOURCEDIR" > "$REPORTDIR/api/logs/test/duplications.txt" || handle_errors $?

    return $?
}

# TODO: Remove handle_errors?
# TODO: Wrap multiline.
sca_pdepend() {
    print_subheader "RUNNING PHP_DEPEND"

    mkdir -p "$REPORTDIR/api/logs/app/"
    mkdir -p "$REPORTDIR/api/logs/lib/"
    mkdir -p "$REPORTDIR/api/logs/test/"
    pdepend --jdepend-chart="$REPORTDIR/pdepend-chart_app.svg" --overview-pyramid="$REPORTDIR/pdepend-pyramid_app.svg" --jdepend-xml="$REPORTDIR/api/logs/app/pdepend.xml" "$API_APPSOURCEDIR" || handle_errors $?
    pdepend --jdepend-chart="$REPORTDIR/pdepend-chart_lib.svg" --overview-pyramid="$REPORTDIR/pdepend-pyramid_lib.svg" --jdepend-xml="$REPORTDIR/api/logs/lib/pdepend.xml" "$API_LIBSOURCEDIR" || handle_errors $?
    pdepend --jdepend-chart="$REPORTDIR/pdepend-chart_test.svg" --overview-pyramid="$REPORTDIR/pdepend-pyramid_test.svg" --jdepend-xml="$REPORTDIR/api/logs/test/pdepend.xml" "$API_TESTSOURCEDIR" || handle_errors $?

    return $?
}

# TODO: Remove handle_errors?
# TODO: Wrap multiline.
sca_phpcb() {
    print_subheader "RUNNING PHP_CODE_BROWSER"

    phpcb --log="$REPORTDIR/api/logs/app/" --source="$API_APPSOURCEDIR" --output="$REPORTDIR/code_browser/app" || handle_errors $?
    phpcb --log="$REPORTDIR/api/logs/lib/" --source="$API_LIBSOURCEDIR" --output="$REPORTDIR/code_browser/lib" || handle_errors $?
    phpcb --log="$REPORTDIR/api/logs/test/" --source="$API_TESTSOURCEDIR" --output="$REPORTDIR/code_browser/test" || handle_errors $?

    return $?
}

sca_perlcritic() {
    print_subheader "RUNNING PERL CRITIC"

    find $SITE_APP_SOURCEDIR -type f -name "*.pl" | xargs perlcritic --brutal --statistics --color
    find $SITE_TEST_SOURCEDIR -type f -name "*.pl" | xargs perlcritic --brutal --statistics --color
}

sca_pylint() {
    print_subheader "RUNNING PYLINT"

    find $SCRIPT_APP_SOURCEDIR -type f -name "*.py" | xargs pylint
    find $SCRIPT_TEST_SOURCEDIR -type f -name "*.py" | xargs pylint
}

sca_pep8() {
    print_subheader "RUNNING PEP8"

    find $SCRIPT_APP_SOURCEDIR -type f -name "*.py" | xargs pep8
    find $SCRIPT_TEST_SOURCEDIR -type f -name "*.py" | xargs pep8
}
