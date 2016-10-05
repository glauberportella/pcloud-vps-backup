#!/bin/bash
#
# Send backup files to pCloud Service

# Copyright (c) 2016 Glauber Portella <glauberportella@gmail.com>

# Permission is hereby granted, free of charge, to any person obtaining a
# copy of this software and associated documentation files (the "Software"),
# to deal in the Software without restriction, including without limitation
# the rights to use, copy, modify, merge, publish, distribute, sublicense,
# and/or sell copies of the Software, and to permit persons to whom the
# Software is furnished to do so, subject to the following conditions:

# The above copyright notice and this permission notice shall be included in
# all copies or substantial portions of the Software.

# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
# FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
# DEALINGS IN THE SOFTWARE.

if [[ $# -ne 4 ]]; then
    echo "Use uploadfile.sh -e=<user email> -p=<user password> -f=<pCloud folder path> file"
    exit 1
fi

# API endpoints
ENDPOINT_GETDIGEST="https://api.pcloud.com/getdigest"
ENDPOINT_USERINFO="https://api.pcloud.com/userinfo"
ENDPOINT_UPLOAD="https://api.pcloud.com/uploadfile"

# Inputs
for i in "$@"
do
case $i in
    -e=*|--email=*)
    EMAIL="${i#*=}"
    shift # past argument=value
    ;;
    -p=*|--password=*)
    PWD="${i#*=}"
    shift # past argument=value
    ;;
    -f=*|--folder=*)
    FOLDER="${i#*=}"
    shift # past argument=value
    ;;
    *)
    FILEPATH="${i}" # file
    ;;
esac
done

# create digest
DIGEST=$(curl --silent -X GET -H 'ContentType: application/json' $ENDPOINT_GETDIGEST | python -c "import sys, json; print json.load(sys.stdin)['digest']")
PASSDIGEST=$(php -r "echo sha1('$PWD'.sha1(strtolower('$EMAIL')).'$DIGEST');")
# get authcode
AUTH=$(curl --silent -X GET -H 'ContentType: application/json' -G $ENDPOINT_USERINFO -d getauth=1 -d logout=1 -d username=$EMAIL -d digest=$DIGEST -d passworddigest=$PASSDIGEST | python -c "import sys, json; print json.load(sys.stdin)['auth']")

FILENAME=$(php -r "echo basename('$FILEPATH');")
RESULT=$(curl --silent -F "path=$FOLDER" -F "filename=$FILENAME" -F "auth=$AUTH" -F "file=@$FILEPATH" $ENDPOINT_UPLOAD | python -c "import sys, json; print json.load(sys.stdin)")

echo "$FILEPATH: $RESULT"
